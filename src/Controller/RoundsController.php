<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Rounds Controller
 *
 * @property \App\Model\Table\RoundsTable $Rounds
 *
 * @method \App\Model\Entity\Round[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoundsController extends AppController
{
    public $add = true;
    /**
     * Index method
     */
    public function index()
    {   
        $round = $this->Rounds->newEntity();
        $last = $this->Rounds->getLastRow();
        if ($this->request->is('post') || $this->request->is(['patch', 'post', 'put'])) {
            debug($data);
            die;
            $data = $this->request->getData();
            
            $start = $this->dmYtoYmd($data['start_date']);
            $end = $this->dmYtoYmd($data['end_date']);
            $RoundTable = $this->loadmodel('Rounds');
            
            if($this->add){
                //debug('add');
                //die;
                
                $sameYear = substr($last[3],-2) === substr($start,2,2);
                $old_month = substr($last[0],5,2);
                $new_month = substr($start,5,2);
                $sameSemester = ($old_month<7&&$old_month==12)&&($new_month<7&&$new_month==12)||
                                ($old_month>=7&&$old_month<12)&&($new_month>=7&&$new_month<12);
                if($last[1]==3 && $sameYear && $sameSemester){
                    $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que ha llegado al límite de 3 rondas por semestre, puede proceder a eliminar o editar la ronda actual.'));
                }else if($start == $last[0]){
                    $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que hay otra existente que comparte una parte del rango, para realizar un cambio puede proceder a editar la ronda.'));
                }else{
                    $RoundTable->insertRound($start,$end);
                    $this->Flash->success(__('Se agregó la ronda correctamente.'));
                }
            }else{
            //    debug('edit');
            //    die;
            //    $RoundTable->editRound($this->mdYtoYmd($round->start_date),$this->mdYtoYmd($round->end_date),$last[0]);
            //    $this->Flash->success(__('Se editó la ronda correctamente.'));
            }
        }
        $this->set(compact('round'));
    }

    /**
     * Add method
     */
    public function add(){
        $this->add=true;
    }

    /**
     * Edit method
     */
    public function edit(){
        debug("magia");
        die;
        $this->add=false;
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
        $now = Time::now();
        $s_date = $round->start_date;
        $less = $now->year > $s_date->year;
        if(!$less){
            $less = $now->month > $s_date->month;
            if(!$less){
                $less = $now->day > $s_date->day;
            }
        } 
        if (!$less) {
            if($this->Rounds->delete($round)){
                $this->Flash->success(__('Se borró la ronda correctamente.'));
            }
        } else {
            $this->Flash->error(__('Error: no se logró borrar, debido a que ya se le ha dado inicio a la ronda, puede proceder a editarla.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function dmYtoYmd($date){
        $j = $i = 0;
        while($date[$i] != '/' && $date[$i] != '-'){
            $i++;
        }
        $day = substr($date,$j,$i++);
        $j = $i;
        $i = 0;
        while($date[$j+$i] != '/' && $date[$j+$i] != '-'){
            $i++;
        }
        $month = substr($date,$j,$i++);
        
        $year = substr($date,$j+$i);
        return $year . "-" . $month . "-" . $day;
    }
}
