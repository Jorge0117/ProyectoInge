<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AdministrativeAssistants Controller
 *
 * @property \App\Model\Table\AdministrativeAssistantsTable $AdministrativeAssistants
 *
 * @method \App\Model\Entity\AdministrativeAssistant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdministrativeAssistantsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $administrativeAssistants = $this->paginate($this->AdministrativeAssistants);

        $this->set(compact('administrativeAssistants'));
    }

    /**
     * View method
     *
     * @param string|null $id Administrative Assistant id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $administrativeAssistant = $this->AdministrativeAssistants->get($id, [
            'contain' => []
        ]);

        $this->set('administrativeAssistant', $administrativeAssistant);
    }

    /**
     * Add a new professor specifying id
     */
    public function newAssistant($id){
        $p = new AdministrativeAssistant([
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
        $administrativeAssistant = $this->AdministrativeAssistants->newEntity();
        if ($this->request->is('post')) {
            $administrativeAssistant = $this->AdministrativeAssistants->patchEntity($administrativeAssistant, $this->request->getData());
            if ($this->AdministrativeAssistants->save($administrativeAssistant)) {
                $this->Flash->success(__('The administrative assistant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The administrative assistant could not be saved. Please, try again.'));
        }
        $this->set(compact('administrativeAssistant'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Administrative Assistant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $administrativeAssistant = $this->AdministrativeAssistants->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $administrativeAssistant = $this->AdministrativeAssistants->patchEntity($administrativeAssistant, $this->request->getData());
            if ($this->AdministrativeAssistants->save($administrativeAssistant)) {
                $this->Flash->success(__('The administrative assistant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The administrative assistant could not be saved. Please, try again.'));
        }
        $this->set(compact('administrativeAssistant'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Administrative Assistant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $administrativeAssistant = $this->AdministrativeAssistants->get($id);
        if ($this->AdministrativeAssistants->delete($administrativeAssistant)) {
            $this->Flash->success(__('The administrative assistant has been deleted.'));
        } else {
            $this->Flash->error(__('The administrative assistant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
