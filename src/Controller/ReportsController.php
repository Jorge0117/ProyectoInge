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
class ReportsController extends AppController
{

    /**
     * approved_Student_report
     * 
     * @return 
     */

    /*
    public function approvedReport()
    {

        $table = $this->loadModel('ApprovedRequestsView');
        $approvedRequestsView = $table->find('all',array('conditions'=>array('prof_id'=>$current_user[identification_number])));
        $approvedRequestsView = $table->find('all')
        ->where(
            ['prof_id'=>$current_user[identification_number]]
        );
        debug( $approvedRequestsView );die();
        $user= new UsersController;
        $idProf = $approvedRequestsView->toArray()[0]->id_prof;
        $ProfessorName = $user->getNameUser($idProf);
    
        $this->set(compact('approvedRequestsView', 'ProfessorName'));
        
    }
    */

    public function studentRequests(){
        $table = $this->loadModel('ProfessorAssistants');

        $studentRequests = $table->find()->where(['id_student'=>$this->viewVars['current_user']['identification_number']]);
        if(count($studentRequests->toArray()) > 0){
            $user= new UsersController;
            $idProf = $studentRequests->toArray()[0]->id_prof;
            $ProfessorName = $user->getNameUser($idProf);
        }
        $this->set(compact('studentRequests', 'ProfessorName'));
    }
    

    /** 
     * Autor: Mayquely
     */
    public function professorAssistants(){
        $table = $this->loadModel('ProfessorAssistants');
         $professorAssistants= $table->find()->where(['id_prof'=>$this->viewVars['current_user']['identification_number']]);
         $ProfessorName = ' '; 

        if(count($professorAssistants->toArray()) > 0){
           
            $user= new UsersController;
            $idProf = $professorAssistants->toArray()[0]->id_prof;
            $ProfessorName = $user->getNameUser($idProf);

        }
        
        $this->set(compact('professorAssistants',   'ProfessorName' ));
    }

    public function getRoundByValues($round,$semester,$year)
    {
		if($semester == 1)
			$semester = 'I';
		else if($semester == 2)
			$semester = 'II';
		
        //Debe comunicarse con rondas
		$rounds_c = new RoundsController;
        return $rounds_c->get_round_key($round,$semester,$year); //
    }

    public function reportsView($parametro = null){
		
		$report =  explode("t",$parametro);
		
		$llave_ronda = '\'' . $report[0] .'\'';		
		$tipo = $report[1];
		$aprobadas = 0;
		//Se basa en el tipo paraelegir que parametro realizar
		switch($tipo)
		{
			case 1:
				//Imprime aprobadas
				$table = $this->loadModel('info_requests');
                $estado = '\'a\'';
                $report= $table->find()->where(['inicio = ' . $llave_ronda . ' AND estado = ' . $estado]);
				//$report = $this->Reports->getApprovedByRound($llave_ronda);
				break;
			case 2:
				//Imprime elegibles rechazados
				$table = $this->loadModel('info_requests');  
                $estado = '\'r\'';
                $report= $table->find()->where(['inicio = ' . $llave_ronda . ' AND estado = ' . $estado]);
				break;
			case 3:
				//Imprime no elegibles
				$table = $this->loadModel('info_requests');  
                $estado = '\'n\'';
                $report= $table->find()->where(['inicio = ' . $llave_ronda . ' AND estado = ' . $estado]);
				break;
		}
		
		if ($this->request->is('post')){
			//Poner aqui lo del excel
        }

        $this->set(compact('report'));
           
    }


    public function reportsAdmin(){
        if ($this->request->is('post')){
            $data= $this->request ->getData();
            $semester = $data['semester'] + 1;
            $year = $data['year'];
            $round = $data['round'] +1;

            $round_key = $this->getRoundByValues($round,$semester, $year);

			if($round_key != null)
			{		
				$round_key = $round_key[0][0];	
				
				if ($data['report_type'] = 'Elegibles aceptados' )
				{		 				 
					 $parametro = $round_key . 't' . '1';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);
				}
				
				if ($data['report_type'] = 'Elegibles rechazados' ){

					 $parametro = $round_key . 't' . '2';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);				}

			   if ($data['report_type'] = 'No elegibles' ){

					 $parametro = $round_key . 't' . '3';				 
					 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $parametro]);		   
			   }
	   }//Fin round_key != nulo
	   else
	   {
		   $this->Flash->error(__('Error: No se logró generar el reporte'));
	   }
           
    }
    
    $this->set(compact('report' ));
    }
    
}