<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AdministrativeBosses Controller
 *
 * @property \App\Model\Table\AdministrativeBossesTable $AdministrativeBosses
 *
 * @method \App\Model\Entity\AdministrativeBoss[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdministrativeBossesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $administrativeBosses = $this->paginate($this->AdministrativeBosses);

        $this->set(compact('administrativeBosses'));
    }

    /**
     * View method
     *
     * @param string|null $id Administrative Boss id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $administrativeBoss = $this->AdministrativeBosses->get($id, [
            'contain' => []
        ]);

        $this->set('administrativeBoss', $administrativeBoss);
    }

    /**
     * Add a new professor specifying id
     */
    public function newAdmin($id){
        $p = new AdministrativeBoss([
            'user_id' => $id
        ]);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $administrativeBoss = $this->AdministrativeBosses->newEntity();
        if ($this->request->is('post')) {
            $administrativeBoss = $this->AdministrativeBosses->patchEntity($administrativeBoss, $this->request->getData());
            if ($this->AdministrativeBosses->save($administrativeBoss)) {
                $this->Flash->success(__('The administrative boss has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The administrative boss could not be saved. Please, try again.'));
        }
        $this->set(compact('administrativeBoss'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Administrative Boss id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $administrativeBoss = $this->AdministrativeBosses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $administrativeBoss = $this->AdministrativeBosses->patchEntity($administrativeBoss, $this->request->getData());
            if ($this->AdministrativeBosses->save($administrativeBoss)) {
                $this->Flash->success(__('The administrative boss has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The administrative boss could not be saved. Please, try again.'));
        }
        $this->set(compact('administrativeBoss'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Administrative Boss id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $administrativeBoss = $this->AdministrativeBosses->get($id);
        if ($this->AdministrativeBosses->delete($administrativeBoss)) {
            $this->Flash->success(__('The administrative boss has been deleted.'));
        } else {
            $this->Flash->error(__('The administrative boss could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
