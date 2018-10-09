<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mainpage Controller
 *
 *
 * @method \App\Model\Entity\Mainpage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MainpageController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $mainpage = $this->paginate($this->Mainpage);

        $this->set(compact('mainpage'));
    }

    /**
     * View method
     *
     * @param string|null $id Mainpage id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mainpage = $this->Mainpage->get($id, [
            'contain' => []
        ]);

        $this->set('mainpage', $mainpage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mainpage = $this->Mainpage->newEntity();
        if ($this->request->is('post')) {
            $mainpage = $this->Mainpage->patchEntity($mainpage, $this->request->getData());
            if ($this->Mainpage->save($mainpage)) {
                $this->Flash->success(__('The mainpage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mainpage could not be saved. Please, try again.'));
        }
        $this->set(compact('mainpage'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Mainpage id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mainpage = $this->Mainpage->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mainpage = $this->Mainpage->patchEntity($mainpage, $this->request->getData());
            if ($this->Mainpage->save($mainpage)) {
                $this->Flash->success(__('The mainpage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mainpage could not be saved. Please, try again.'));
        }
        $this->set(compact('mainpage'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Mainpage id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mainpage = $this->Mainpage->get($id);
        if ($this->Mainpage->delete($mainpage)) {
            $this->Flash->success(__('The mainpage has been deleted.'));
        } else {
            $this->Flash->error(__('The mainpage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
