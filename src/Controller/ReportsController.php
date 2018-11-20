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

    
}