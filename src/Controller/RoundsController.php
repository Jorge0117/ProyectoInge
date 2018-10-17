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
        $round = $this->Rounds->get($id, [
            'contain' => []
        ]);

        $this->set('round', $round);
    }

    /**
     * StartAdd method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function startAdd(){
        return false;
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($s_date, $e_date)
    {
        $round = $this->Rounds->newEntity();
        if ($this->request->is('post')) {
            $round = $this->Rounds->patchEntity($round, $this->request->getData());
            $RoundTable=$this->loadmodel('Rounds');
            $start=date_format($round->start_date,'Y-m-d');
            $end=date_format($round->end_date,'Y-m-d');
            $RoundTable->insertRound($start,$end);
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
    public function edit(){
        {
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
    }

    /**
     * Delete method
     *
     * @param string|null $id Round id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null){   
        $date = $this->dmYtoYmd($id);
        $this->request->allowMethod(['post', 'delete']);
        $round = $this->Rounds->get($date);
        if ($this->Rounds->delete($round)) {
            $this->Flash->success(__('Se borró la ronda correctamente.'));
        } else {
            $this->Flash->error(__('Error: no se logró borrar la ronda.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function dmYtoYmd($date){
        $day = substr($date,0,2);
        $month = substr($date,3,2);
        $year = substr($date,6,4);
        return $year . "-" . $month . "-" . $day;
    }
}
