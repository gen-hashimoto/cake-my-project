<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LoginHistorys Controller
 *
 * @property \App\Model\Table\LoginHistorysTable $LoginHistorys
 *
 * @method \App\Model\Entity\LoginHistory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LoginHistorysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $loginHistorys = $this->paginate($this->LoginHistorys);

        $this->set(compact('loginHistorys'));
    }

    /**
     * View method
     *
     * @param string|null $id Login History id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loginHistory = $this->LoginHistorys->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set('loginHistory', $loginHistory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loginHistory = $this->LoginHistorys->newEntity();
        if ($this->request->is('post')) {
            $loginHistory = $this->LoginHistorys->patchEntity($loginHistory, $this->request->getData());
            if ($this->LoginHistorys->save($loginHistory)) {
                $this->Flash->success(__('The login history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The login history could not be saved. Please, try again.'));
        }
        $users = $this->LoginHistorys->Users->find('list', ['limit' => 200]);
        $this->set(compact('loginHistory', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Login History id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loginHistory = $this->LoginHistorys->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $loginHistory = $this->LoginHistorys->patchEntity($loginHistory, $this->request->getData());
            if ($this->LoginHistorys->save($loginHistory)) {
                $this->Flash->success(__('The login history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The login history could not be saved. Please, try again.'));
        }
        $users = $this->LoginHistorys->Users->find('list', ['limit' => 200]);
        $this->set(compact('loginHistory', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Login History id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $loginHistory = $this->LoginHistorys->get($id);
        if ($this->LoginHistorys->delete($loginHistory)) {
            $this->Flash->success(__('The login history has been deleted.'));
        } else {
            $this->Flash->error(__('The login history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
