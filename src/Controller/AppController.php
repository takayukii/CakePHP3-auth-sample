<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use DateTime;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * smarty class
     */
    public $viewClass = 'App\View\SmartyView';
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'name']
                ]
            ],
            'passwordHasher' => [
                'className' => 'Default',
            ],
            'loginRedirect' => '/users'
        ]);
    }

    function beforeFilter(Event $event)
    {
        $this->Cookie->config([
            'domain' => '.example.com',
            'encryption' => false
        ]);

        $isAuthenticated = !empty($this->Auth->user());

        if($isAuthenticated){

            $this->request->session()->renew();

            $cookieExpiry = $this->Cookie->read('AUTOLOGIN-EXPIRY');
            $hasAutoLogin = !empty($cookieExpiry);

            if($hasAutoLogin){
                $cookieLifeTime = new DateTime($cookieExpiry);

                $this->Cookie->config([
                    'domain' => '.example.com',
                    'encryption' => false,
                    'expires' => $cookieLifeTime,
                    'httpOnly' => true
                ]);
                $this->Cookie->write('AUTOLOGIN', $this->request->session()->id());
                $this->Cookie->write('AUTOLOGIN-EXPIRY', $cookieLifeTime->format('Y-m-d H:i:s'));
            }

        }else{

            $autoLoginSessionId = $this->Cookie->read('AUTOLOGIN');
            $isAutoLoginFound = !empty($autoLoginSessionId);
            
            if($isAutoLoginFound){
                if($autoLoginSessionId !== $this->request->session()->id()){

                    // ブラウザセッションのCakePHPのセッションにAUTOLOGINを設定しリダイレクトすることで自動ログインする
                    $this->request->session()->id($autoLoginSessionId);
                    $this->redirect($this->request->url);

                }
            }

        }
    }

}
