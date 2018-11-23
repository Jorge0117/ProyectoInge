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
     * 
     * @return null
     */
    public function index(){   
        $round = $this->Rounds->newEntity();
        // Recibe el form y con base a los datos recibidos elige si agregar o editar una ronda
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if($data['flag'] == '1') $this->add($data);
            else if($data['flag'] == '2') $this->edit($data);
        }
        $this->set(compact('round'));
        $roundData = $this->viewVars['roundData'];
        $this->displayWarning(
            $roundData['total_student_hours'],
            $roundData['total_student_hours_d'],
            $roundData['total_assistant_hours'],
            $roundData['actual_student_hours'],
            $roundData['actual_student_hours_d'],
            $roundData['actual_assistant_hours']
        );
    }
    
    /**
     * add method
     *
     * @param array|null $data post data.
     * @return null
     */
    public function add($data = null){
        if ($role_c->is_Authorized($user['role_id'], 'Rounds', 'add')){
            $roundData = $this->viewVars['roundData'];
            $start = $this->mirrorDate($data['start_date']);
            $end = $this->mirrorDate($data['end_date']);
            $tsh = $data['total_student_hours'];
            $tdh = $data['total_student_hours_d'];
            $tah = $data['total_assistant_hours'];
            $sameYear = substr($roundData['year'],-2) === substr($start,2,2);
            $old_month = substr($roundData['start_date'],5,2);
            $new_month = substr($start,5,2);
            $sameSemester = ($old_month<7&&$old_month==12)&&($new_month<7&&$new_month==12)||
                            ($old_month>=7&&$old_month<12)&&($new_month>=7&&$new_month<12);
            if($roundData['round_number']==3 && $sameYear && $sameSemester){
                $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que ha llegado al límite de 3 rondas por semestre, puede proceder a eliminar o editar la ronda actual.'));
            }else if($start < $roundData['start_date']){//fixme
                $this->Flash->error(__('Error: No se logró agregar la ronda, debido a que hay otra existente que comparte una parte del rango, para realizar un cambio puede proceder a editar la ronda.'));
            }else{
                $RoundsTable = $this->loadmodel('Rounds');            
                $RoundsTable->insertRound($start,$end,$tsh,$tdh,$tah);
                $this->updateGlobal();
                $this->Flash->success(__('Se agregó la ronda correctamente.'));
            }
        }
    }

    /**
     * edit method
     *
     * @param array|null $data post data.
     * @return null
     */
    public function edit($data = null){
        if ($role_c->is_Authorized($user['role_id'], 'Rounds', 'edit')){
            $roundData = $this->viewVars['roundData'];
            $start = $this->mirrorDate($data['start_date']);
            $end = $this->mirrorDate($data['end_date']);
            $tsh = $data['total_student_hours'];
            $tdh = $data['total_student_hours_d'];
            $tah = $data['total_assistant_hours'];
            $RoundsTable = $this->loadmodel('Rounds');
            $RoundsTable->editRound($start,$end,$roundData['start_date'],$tsh,$tdh,$tah);
            $this->updateGlobal();
            $this->Flash->success(__('Se editó la ronda correctamente.'));
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
        if ($role_c->is_Authorized($user['role_id'], 'Rounds', 'delete')){
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
                    $this->updateGlobal();
                    $this->Flash->success(__('Se borró la ronda correctamente.'));
                }
            }else if($ror){
                $this->Flash->error(__('Error: no se logró borrar la ronda, debido a que tiene solicitudes asociadas, puede proceder a editarla.'));
            }else{
                $this->Flash->error(__('Error: no se logró borrar la ronda, debido a que ya se le ha dado inicio, puede proceder a editarla.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    // Trasnforma una fecha de formato y-m-d a d-m-y y vicesversa
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

    public function updateGlobal(){
        $roundData = $this->Rounds->getLastRow();
        $this->request->session()->write('roundData',$roundData);
        $this->set(compact('roundData'));
    }

    private function displayWarning($tsh,$tdh,$tah,$ash,$adh,$aah){
        if(!$this->between()){
            $this->Flash->warning(__('Advertencia: Actualmente no se encuentra dentro de una ronda'));
        }
        if( $tsh == $ash && ( $tdh != $adh || !$tdh ) && ( $tah != $aah || !$tah ) && $tsh) 
            $this->Flash->warning(__('Advertencia: No hay más horas estudiante de la ecci disponibles, total de horas estudiante ecci: '.$tsh.'.'));
        else if( ( $tsh != $ash || !$tsh ) && $tdh == $adh && ( $tah != $aah || !$tah ) && $tdh) 
            $this->Flash->warning(__('Advertencia: No hay más horas estudiante de docencia disponibles, total de horas estudiante docencia: '.$tdh.'.'));
        else if( ( $tsh != $ash || !$tsh ) && ( $tdh != $adh || !$tdh ) && $tah == $aah && $tah) 
            $this->Flash->warning(__('Advertencia: No hay más horas asistente disponibles, total de horas asistente: '.$tah.'.'));
        else if( $tsh == $ash && $tdh == $adh && ( $tah != $aah || !$tah ) && $tsh && $tdh) 
            $this->Flash->warning(__('Advertencia: No hay más horas estudiante de la ecci ni de docencia disponibles, total de horas estudiante ecci: '.$tsh.', total de horas estudiante docencia: '.$tdh.'.'));
        else if( $tsh == $ash && ( $tdh != $adh || !$tdh ) && $tah == $aah && $tsh && $tah) 
            $this->Flash->warning(__('Advertencia: No hay más horas estudiante de la ecci ni horas asistente disponibles, total de horas estudiante ecci: '.$tsh.', total de horas asistente: '.$tah.'.'));
        else if( ( $tsh != $ash || !$tsh ) && $tdh == $adh && $tah == $aah && $tdh && $tah) 
            $this->Flash->warning(__('Advertencia: No hay más horas estudiante de docencia ni horas asistente disponibles, total de horas estudiante docencia: '.$tdh.', total de horas asistente: '.$tah.'.'));
        else if( $tsh == $ash && $tdh == $adh && $tah == $aah && $tsh && $tdh && $tah) 
            $this->Flash->warning(__('Advertencia: No hay más horas estudiante ni asistente disponibles, total de horas estudiante ecci: '.$tsh.', total de horas estudiante docencia: '.$tdh.', total de horas asistente: '.$tah.'.'));
    }



    // informa si el día de hoy se encuentra dentro de la úlitma ronda agregada
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
