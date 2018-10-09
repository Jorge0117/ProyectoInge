<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rounds Controller
 *
 * @property \App\Model\Table\RoundsTable $Rounds
 *
 * @method \App\Model\Entity\Round[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoundsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //$RoundTable=$this->loadmodel('Rounds');
        //$RoundTable->getLastRound();
        // TODO: aprender a obtener el resultado de un stored procedure y mostrarlo
        //  o
        // Crear una vista que contenga únicamente la ultima ronda y redirigir
        $rounds = $this->paginate($this->Rounds);
 
        $this->set(compact('rounds'));
    }

    /**
     * View method
     *
     * @param string|null $id Round id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
            //todo: obtener la id correcta 
        $round = $this->Rounds->get($id, [
            'contain' => []
        ]);

        $this->set('round', $round);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $round = $this->Rounds->newEntity();
        if ($this->request->is('post')) {
            $round = $this->Rounds->patchEntity($round, $this->request->getData());
            
            $RoundTable=$this->loadmodel('Rounds');
            $start=date_format($round->start_date,'Y-m-d');
            $end=date_format($round->end_date,'Y-m-d');
            $approve=date_format($round->approve_limit_date,'Y-m-d');
            $RoundTable->insertRound($start,$end,$approve);

            $this->Flash->success(__('Se agregó la ronda correctamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('round'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Round id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //Todo: otro stores procedure similar al de crear pero con update
        $round = $this->Rounds->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $round = $this->Rounds->patchEntity($round, $this->request->getData());
            if ($this->Rounds->save($round)) {
                $this->Flash->success(__('The round has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The round could not be saved. Please, try again.'));
        }
        $this->set(compact('round'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Round id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $RoundTable=$this->loadmodel('Rounds');
        $RoundTable->deleteLastRound();
        $this->Flash->success(__('The round has been deleted.'));
        return $this->redirect(['action' => 'index']);
    }
}
