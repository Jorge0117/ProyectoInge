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
     * Activa el item del menú de navegación
     * 
     * @author Daniel Díaz
     */
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        $this->set('active_menu', 'MenubarRonda');

    }
    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Index method
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
        if($roundData){
            $this->displayWarning(
                $roundData['total_student_hours'],
                $roundData['total_student_hours_d'],
                $roundData['total_assistant_hours'],
                $roundData['actual_student_hours'],
                $roundData['actual_student_hours_d'],
                $roundData['actual_assistant_hours']
            );
        }
    }
    
    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * add method
     *
     * @param array|null $data post data.
     */
    public function add($data = null){
        
        $role_c = new RolesController;
        $user = $this->Auth->user();
        $roundData = $this->viewVars['roundData'];
        if ($role_c->is_Authorized($user['role_id'], 'Rounds', 'add')){
            $start = $this->mirrorDate($data['start_date']);
            $end = $this->mirrorDate($data['end_date']);
            $tsh = $data['total_student_hours'];
            $tdh = $data['total_student_hours_d'];
            $tah = $data['total_assistant_hours'];
            if($roundData){
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
            }else{
                $RoundsTable = $this->loadmodel('Rounds');            
                $RoundsTable->insertRound($start,$end,$tsh,$tdh,$tah);
                $this->updateGlobal();
                $this->Flash->success(__('Se agregó la ronda correctamente.'));
            }
            
        }
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * edit method
     *
     * @param array|null $data post data.
     */
    public function edit($data = null){
        $role_c = new RolesController;
        $user = $this->Auth->user();
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
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Delete method
     *
     * @param string|null $id Round id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null){
        $role_c = new RolesController;
        $user = $this->Auth->user();
        if ($role_c->is_Authorized($user['role_id'], 'Rounds', 'delete')){
            $this->request->allowMethod(['post', 'delete']);
            $round = $this->Rounds->get($id);
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

    /** 
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Trasnforma una fecha de formato y-m-d a d-m-y y vicesversa
     */
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

    /** 
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Actualiza el valor de la variable roundData en el sistema.
     * El método debe de ser llamado cada vez que surge un cambio
     * en la tabla de rondas
     */
    public function updateGlobal(){
        $roundData = $this->Rounds->getLastRow();
        $this->request->getSession()->write('roundData',$roundData);
        $this->set(compact('roundData'));
    }

    /** 
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Despliega advertencias con respecto a las condiciones dadas.
     */
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


    /** 
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Informa si el día de hoy se encuentra dentro de la úlitma ronda agregada
     */
    public function between(){
        $RoundsTable = $this->loadmodel('Rounds');
        return $RoundsTable->between();
    }
	
	/**
     * @author Esteban Rojas
     * 
		Esta funcion obtiene los datos de la ronda que esta activa en el sistema.
		
		@return array Si no hay ronda activa, entonces el valor retornado será nulo
     */
	public function get_actual_round()
    {
		$RoundsTable = $this->loadmodel('Rounds');
        return $RoundsTable->getActualRound(date('y-m-d'));
    }
	
	/**
     * @author Esteban Rojas 
     * 
		Esta funcion obtiene la llave de una ronda según el número de ronda, semestre y año.

		@param string $round  
		@param string $semester  
		@param string $year  
		@return array Si hay un número de ronda  del semestre y año especificados, de lo contrario nulo
     */	
	public function get_round_key($round,$semester,$year)
	{
		$RoundsTable = $this->loadmodel('Rounds');
        return $RoundsTable->getRoundKey($round,$semester,$year);
	}

}
