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

    public function studentRequests(){
        $table = $this->loadModel('ProfessorAssistants');

        $studentRequests = $table->find()->where(['id_student'=>$this->viewVars['current_user']['identification_number']]);
        if(count($studentRequests->toArray()) > 0){
            //Obtiene el nombre del profesor al que le solicitó la asistencia
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

    public function CreateExcel($type){
        $fileName = "Reporte".$type.".xls";
        $headerRow = array("Curso","Semestre","Grupo","Carné","Estudiante","Tipo de horas","Cantidad de horas");
        $fileContent = implode("\t ", $headerRow);
        echo $fileContent;
        exit;
    }

    public function getRoundByValues($round,$semester,$year)
    {
        //Debe comunicarse con rondas. Por ahora solo agarra un valor por default
        return '2018-11-06';
    }

    public function reportsView($report = null){
        if ($this->request->is('post')){
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

            if ($data['report_type'] = 'Elegibles aceptados' ){
                
                 $table = $this->loadModel('info_requests');  
                 $estado = ' \'a\'';
                 $report= $table->find()->where(['' . $round. ' = ronda AND ' . $semester . '= semestre AND anno = ' . $year . ' and estado = ' . $estado]);
                 
                 return $this->redirect(['controller' => 'Reports', 'action' => 'reports_view', $report]);
                }
            
            if ($data['report_type'] = 'Elegibles rechazados' ){

                $table = $this->loadModel('info_requests');  
               //$report= $table->find()->where(['semestre'=> $data['semester'] and 'anno'=> $data['year'] and 'ronda'=> $data['round'] and 'estado' => 'r' ]);
           }

           if ($data['report_type'] = 'No elegibles' ){

            $table = $this->loadModel('info_requests');  
            //$report= $table->find()->where(['semestre'=> $data['semester'] and 'anno'=> $data['year'] and 'ronda'=> $data['round'] and 'estado' => 'n' ]);
       }
           
    }
    
    $this->set(compact('report' ));
    }
    
}