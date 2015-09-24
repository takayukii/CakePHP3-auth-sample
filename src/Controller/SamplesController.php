<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Network\Email\Email;

/**
 * Samples Controller
 *
 * @property \App\Model\Table\SamplesTable $Samples
 */
class SamplesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('samples', $this->paginate($this->Samples));
        $this->set('_serialize', ['samples']);
    }

    /**
     * View method
     *
     * @param string|null $id Sample id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sample = $this->Samples->get($id, [
            'contain' => []
        ]);
        $this->set('sample', $sample);
        $this->set('_serialize', ['sample']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sample = $this->Samples->newEntity();
        if ($this->request->is('post')) {
            $sample = $this->Samples->patchEntity($sample, $this->request->data);
            if ($this->Samples->save($sample)) {
                $this->Flash->success(__('The sample has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sample could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('sample'));
        $this->set('_serialize', ['sample']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sample id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sample = $this->Samples->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sample = $this->Samples->patchEntity($sample, $this->request->data);
            if ($this->Samples->save($sample)) {
                $this->Flash->success(__('The sample has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The sample could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('sample'));
        $this->set('_serialize', ['sample']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sample id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sample = $this->Samples->get($id);
        if ($this->Samples->delete($sample)) {
            $this->Flash->success(__('The sample has been deleted.'));
        } else {
            $this->Flash->error(__('The sample could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * mail method
     */
    public function mail()
    {
        $email = new Email('default');
        $email->from(['test@petgo.co.jp' => 'TEST']);
        $email->to('tatsurou_mizuno@petgo.co.jp');
        $email->subject('TEST');
        $email->emailFormat('html');
        $email->template('default');
        //$email->template('test', "layout");
        $email->viewRender('App\View\SmartyView');
        $email->send('My message');
        
        $this->autoRender = false;
    }
}
