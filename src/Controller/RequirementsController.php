<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Requirements Controller
 *
 * @property \App\Model\Table\RequirementsTable $Requirements
 *
 * @method \App\Model\Entity\Requirement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequirementsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $requirements = $this->paginate($this->Requirements);

        $this->set(compact('requirements'));
    }

    /**
     * View method
     *
     * @param string|null $id Requirement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requirement = $this->Requirements->get($id, [
            'contain' => ['FulfillsRequirement']
        ]);

        $this->set('requirement', $requirement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requirement = $this->Requirements->newEntity();
        if ($this->request->is('post')) {
            pr($this->request->data);
            $requirement = $this->Requirements->patchEntity($requirement, $this->request->getData());
            if ($this->Requirements->save($requirement)) {

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requirement could not be saved. Please, try again.'));
        }
        $this->set(compact('requirement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Requirement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requirement = $this->Requirements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requirement = $this->Requirements->patchEntity($requirement, $this->request->getData());
            if ($this->Requirements->save($requirement)) {
                $this->Flash->success(__('The requirement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The requirement could not be saved. Please, try again.'));
        }
        $this->set(compact('requirement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requirement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($requirement_number)
    {
        //------------------------------------------------
        $result = false;
        //------------------------------------------------
        $model = $this->Requirements->newEntity();
        //------------------------------------------------
        if ($this->request->is('post')) {
            //------------------------------------------------
            $model = $this->Requirements->patchEntity(
                $model, 
                $this->request->getData()
            );
            //------------------------------------------------
            $requirementsModel = $this->loadmodel('Requirements');
            //------------------------------------------------
            $result = $requirementsModel->deleteClass(
                $requirement_number
            );
        }
        //------------------------------------------------
        return $this->redirect(['action' => 'index']);
    }
}
