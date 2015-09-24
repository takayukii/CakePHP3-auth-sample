<?php
namespace App\Controller;

use Cake\Core\Configure;

/**
 * 拡張Error Handling Controller
 */
class ErrorController extends \Cake\Controller\ErrorController
{
    /**
     * Constructor
     *
     * @param \Cake\Network\Request|null $request Request instance.
     * @param \Cake\Network\Response|null $response Response instance.
     */
    public function __construct($request = null, $response = null)
    {
        parent::__construct($request, $response);
        
        //通常時はsmartyを使用する。
        if (!Configure::read('debug')) {
            $this->viewClass = 'App\View\SmartyView';
        }
    }
}
