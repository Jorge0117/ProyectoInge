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
    /**
     * Index method
     */
    public function index(){   
        $round = $this->Rounds->newEntity();
        $last = $this->Rounds->getLastRow();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if($data['flag'] == '1') $this->add($data);
            else if($data['flag'] == '2') $this->edit($data);
        }
        $this->set(compact('round'));
        if(!$this->between()){
            $this->Flash->warning(__('Advertencia: Actualmente no se encuentra dentro de una ronda'));
        }
    }
    
    /**
     * add method
     *
     * @param array|null $data post data.
     */
    public function add($data = null){
        $last = $this->Rounds->getLastRow();
        $start = $this->mirrorDate($data['start_date']);
        $end = $this->mirrorDate($data['end_date']);
        $tsh = $data['total_student_hours'];
        $tah = $data['total_assistant_hours'];
        $ash = $last[7];
        $aah = $last[8];
        $sameYear = substr($last[4],-2) === substr($start,2,2);
        $old_month = substr($last[0],5,2);
        $new_month = substr($start,5,2);
        $sameSemester = ($old_month<7&&$old_month==12)&&($new_month<7&&$new_month==12)||
                        ($old_month>=7&&$old_month<12)&&($new_month>=7&&$new_month<12);
        if($last[2]==3 && $sameYear && $sameSemester){
            $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que ha llegado al límite de 3 rondas por semestre, puede proceder a eliminar o editar la ronda actual.'));
        }else if($start < $last[0]){
            $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que hay otra existente que comparte una parte del rango, para realizar un cambio puede proceder a editar la ronda.'));
        }else if(!$tsh && !$tah){
            $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que se le ha asignado el valor de cero al total de las horas estudiante y al total de horas asistente.'));
        }else if(!$tsh){
            $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que se le ha asignado el valor de cero al total de las horas estudiante.'));
        }else if(!$tah){
            $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que se le ha asignado el valor de cero al total de las horas asistente.'));
        }else{
            $RoundsTable = $this->loadmodel('Rounds');
            $RoundsTable->insertRound($start,$end,$tsh,$tah);
            $this->Flash->success(__('Se agregó la ronda correctamente.'));
            if($last[2]!=3){
                if($tsh == $ash && $tah != $aah) $this->Flash->warning(__('No hay más horas estudiante disponibles, total de horas estudiante: '.$tsh.'.'));
                else if($tsh != $ash && $tah == $aah) $this->Flash->warning(__('No hay más horas asistente disponibles, total de horas asistente: '.$tah.'.'));
                else if($tsh == $ash && $tah == $aah)  $this->Flash->warning(__('No hay más horas estudiante ni asistente disponibles, total de horas estudiante: '.$tsh.', total de horas asistente: '.$tah.'.'));
            }
        }
    }

    /**
     * edit method
     *
     * @param array|null $data post data.
     */
    public function edit($data = null){
        $last = $this->Rounds->getLastRow();
        $start = $this->mirrorDate($data['start_date']);
        $end = $this->mirrorDate($data['end_date']);
        $tsh = $data['total_student_hours'];
        $tah = $data['total_assistant_hours'];
        $ash = $last[7];
        $aah = $last[8];
        if(!$tsh && !$tah){
            $this->Flash->error(__('Error: No se logró editar la ronda, debido a que se le ha asignado el valor de cero al total de las horas estudiante y al total de horas asistente.'));
        }else if(!$tsh){
            $this->Flash->error(__('Error: No se logró editar la ronda, debido a que se le ha asignado el valor de cero al total de las horas estudiante.'));
        }else if(!$tah){
            $this->Flash->error(__('Error: No se logró editar la ronda, debido a que se le ha asignado el valor de cero al total de las horas asistente.'));
        }else{
            $RoundsTable = $this->loadmodel('Rounds');
            $RoundsTable->editRound($start,$end,$last[0],$tsh,$tah);
            $this->Flash->success(__('Se editó la ronda correctamente.'));
            if($tsh == $ash && $tah != $aah) $this->Flash->warning(__('No hay más horas estudiante disponibles, total de horas estudiante: '.$tsh.'.'));
            else if($tsh != $ash && $tah == $aah) $this->Flash->warning(__('No hay más horas asistente disponibles, total de horas asistente: '.$tah.'.'));
            else if($tsh == $ash && $tah == $aah)  $this->Flash->warning(__('No hay más horas estudiante ni asistente disponibles, total de horas estudiante: '.$tsh.', total de horas asistente: '.$tah.'.'));
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
        $date = $this->mirrorDate($id);
        $this->request->allowMethod(['post', 'delete']);
        $round = $this->Rounds->get($date);
        $RoundsTable = $this->loadmodel('Rounds');
        $RequestsTable = $this->loadmodel('Requests');
        $now = $RoundsTable->getToday();
        $s_date = $round->start_date;
        $less = substr($now,0,4) < $s_date->year;
        if(!$less){
            $less = substr($now,5,2) < $s_date->month;
            if(!$less)
                $less = substr($now,8,2)-2 < $s_date->day;
        } 
        $ror = $RequestsTable->requestsOnRound();
        if($less && !$ror){
            if($this->Rounds->delete($round)){
                $this->Flash->success(__('Se borró la ronda correctamente.'));
            }
        }else if($ror){
            $this->Flash->error(__('Error: no se logró borrar la ronda, debido a que tiene solicitudes asociadas, puede proceder a editarla.'));
        }else{
            $this->Flash->error(__('Error: no se logró borrar la ronda, debido a que ya se le ha dado inicio, puede proceder a editarla.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function mirrorDate($date){
        $j = $i = 0;
        while($date[$i] != '/' && $date[$i] != '-')$i++;
        $first = substr($date,$j,$i++);
        $j = $i; $i = 0;
        while($date[$j+$i] != '/' && $date[$j+$i] != '-')$i++;
        $second = substr($date,$j,$i++);
        $third = substr($date,$j+$i);
        return $third . "-" . $second . "-" . $first;
    }

    public function between(){
        $RoundsTable = $this->loadmodel('Rounds');
        return $RoundsTable->between();
    }
	
	//Autor: Esteban Rojas
	//Llama al modelo de Rondas y solicita la ronda actual.
	public function get_actual_round()
    {
		$RoundsTable = $this->loadmodel('Rounds');
        return $RoundsTable->getActualRound(date('y-m-d'));
    }

}
