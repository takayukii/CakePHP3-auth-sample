<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;

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
        $this->Auth->allow('add', 'edit');
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
        if ($this->request->is('post')) {

            $user = $this->Auth->identify();
            $isLoginSuccess = !empty($user);

            if($isLoginSuccess){

                $this->Auth->setUser($user);

                $isSaveCookie = $this->request->data['remember_me'] == 1;
                $cookieLifeTime = 0;
                if($isSaveCookie){
                    $cookieLifeTime = '+ 1day'; 
                }

                $this->Cookie->config([
                    'domain' => '.example.com',
                    'encryption' => false,
                    'expires' => $cookieLifeTime,
                    'httpOnly' => true
                ]);
                $this->Cookie->write('SESSID', $this->request->session()->id());

                $this->Flash->success(__('The user has been logged in.'));
                $this->redirect($this->Auth->redirectUrl());

            }else{

                $this->Flash->error(__('The user could not be logged in. Please, try again.'));

            }

        }
    }
}
