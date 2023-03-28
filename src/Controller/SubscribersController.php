<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subscribers Controller
 *
 * @property \App\Model\Table\SubscribersTable $Subscribers
 * @method \App\Model\Entity\Subscriber[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscribersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $subscribers = $this->paginate($this->Subscribers);

        $this->set(compact('subscribers'));
    }

    /**
     * View method
     *
     * @param string|null $id Subscriber id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscriber = $this->Subscribers->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('subscriber'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscriber = $this->Subscribers->newEmptyEntity();
        if ($this->request->is('post')) {
            $subscriber = $this->Subscribers->patchEntity($subscriber, $this->request->getData());
            if ($this->Subscribers->save($subscriber)) {
                $this->Flash->success(__('The subscriber has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriber could not be saved. Please, try again.'));
        }
        $users = $this->Subscribers->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('subscriber', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscriber id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscriber = $this->Subscribers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscriber = $this->Subscribers->patchEntity($subscriber, $this->request->getData());
            if ($this->Subscribers->save($subscriber)) {
                $this->Flash->success(__('The subscriber has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriber could not be saved. Please, try again.'));
        }
        $users = $this->Subscribers->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('subscriber', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscriber id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscriber = $this->Subscribers->get($id);
        if ($this->Subscribers->delete($subscriber)) {
            $this->Flash->success(__('The subscriber has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriber could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
