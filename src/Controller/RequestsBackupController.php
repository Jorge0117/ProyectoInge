<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * RequestsBackup Controller
 *
 * @property \App\Model\Table\RequestsBackupTable $RequestsBackup
 *
 * @method \App\Model\Entity\RequestsBackup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequestsBackupController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Courses', 'Classes']
        ];
        $requestsBackup = $this->paginate($this->RequestsBackup);

        $this->set(compact('requestsBackup'));
    }

    /**
     * View method
     *
     * @param string|null $id Requests Backup id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requestsBackup = $this->RequestsBackup->get($id, [
            'contain' => ['Courses', 'Classes']
        ]);

        $this->set('requestsBackup', $requestsBackup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requestsBackup = $this->RequestsBackup->newEntity();
        if ($this->request->is('post')) {
            $requestsBackup = $this->RequestsBackup->patchEntity($requestsBackup, $this->request->getData());
            if ($this->RequestsBackup->save($requestsBackup)) {
                $this->Flash->success(__('The requests backup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requests backup could not be saved. Please, try again.'));
        }
        $courses = $this->RequestsBackup->Courses->find('list', ['limit' => 200]);
        $classes = $this->RequestsBackup->Classes->find('list', ['limit' => 200]);
        $this->set(compact('requestsBackup', 'courses', 'classes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requests Backup id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requestsBackup = $this->RequestsBackup->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestsBackup = $this->RequestsBackup->patchEntity($requestsBackup, $this->request->getData());
            if ($this->RequestsBackup->save($requestsBackup)) {
                $this->Flash->success(__('The requests backup has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requests backup could not be saved. Please, try again.'));
        }
        $courses = $this->RequestsBackup->Courses->find('list', ['limit' => 200]);
        $classes = $this->RequestsBackup->Classes->find('list', ['limit' => 200]);
        $this->set(compact('requestsBackup', 'courses', 'classes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requests Backup id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requestsBackup = $this->RequestsBackup->get($id);
        if ($this->RequestsBackup->delete($requestsBackup)) {
            $this->Flash->success(__('The requests backup has been deleted.'));
        } else {
            $this->Flash->error(__('The requests backup could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function respaldar()
	{
		//Realiza el salvado de valores
	}
}
