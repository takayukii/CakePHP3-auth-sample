<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Exception\Exception;
use Cake\Utility\Security;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use DateTime;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'checkAuth']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            $hasher = new DefaultPasswordHasher();
            $this->request->data['password'] = $hasher->hash($this->request->data['password']);

            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $hasher = new DefaultPasswordHasher();
            $this->request->data['password'] = $hasher->hash($this->request->data['password']);

            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function login()
    {
        if ($this->request->is('get')) {

//            $redirectUrl = $this->request->query('redirect');
//            $this->request->session()->write('redirect', $redirectUrl);
//
//            $level = $this->request->query('level');
//            if(!empty($level)){
//                $this->request->session()->write('level', $level);
//            }

        } else if ($this->request->is('post')) {

            $user = $this->Auth->identify();
            $isLoginSuccess = !empty($user);

            if($isLoginSuccess){

                $this->Auth->setUser($user);

                $isSaveCookie = $this->request->data['remember_me'] == 1;
                if($isSaveCookie){

                    $cookieLifeTime = (new DateTime())->modify('+2 weeks');
                    $this->Cookie->config([
                        'domain' => '.example.com',
                        'encryption' => false,
                        'expires' => $cookieLifeTime,
                        'httpOnly' => true
                    ]);
                    $this->Cookie->write('SSOSID-EXPIRY', $cookieLifeTime->format('Y-m-d H:i:s'));

                }else{
                    $this->Cookie->config([
                        'domain' => '.example.com',
                        'encryption' => false,
                        'expires' => 0,
                        'httpOnly' => true
                    ]);
                }
                $this->Cookie->write('SSOSID', $this->request->session()->id());

                $this->Flash->success(__('The user has been logged in.'));

                $redirectUrl = $this->request->query('redirect');
                $level = $this->request->query('level');
                if(empty($level)){
                    $level = 1;
                }

                $this->request->session()->write('authLevel', $level);

                $hasRedirectUrl = !empty($redirectUrl);
                if($hasRedirectUrl){
                    $this->redirect($redirectUrl);
                }else{
                    $this->redirect($this->Auth->redirectUrl());
                }

            }else{

                $this->Flash->error(__('The user could not be logged in. Please, try again.'));

            }

        }
    }

    /**
     *
     */
    public function checkAuth(){

        $this->log(__METHOD__.' called', LOG_DEBUG);

        $this->viewClass = 'Json';
        $level = $this->request->query('level');

        if(empty($level)){
            $level = 1;
        }

        try{

            $isAuthenticated = !empty($this->Auth->user());

            if(!$isAuthenticated){
                throw new Exception('not auth');
            }

            $authLevel = $this->request->session()->read('authLevel');
            $isSatisfyAuthLevel = $authLevel >= $level;

            if(!$isSatisfyAuthLevel){
                throw new Exception('not statisfy level');
            }

            $this->set([
                'auth' => $this->Auth->user(),
                '_serialize' => ['auth']
            ]);


        }catch(Exception $e) {

            $this->response->statusCode(403);
            $this->set([
                'error' => $e->getMessage(),
                '_serialize' => ['error']
            ]);

        }

    }
}
