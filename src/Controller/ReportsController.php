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
        $table = $this->loadModel('InfoRequests');

        $studentRequests = $table->find()->where(['cedula'=>$this->viewVars['current_user']['identification_number']]);
        if(count($studentRequests->toArray()) > 0){
            $user= new UsersController;
            $idProf = $studentRequests->toArray()[0]->id_prof;
            $ProfessorName = $user->getNameUser($idProf);
        }
        $this->set(compact('studentRequests', 'ProfessorName'));
    }
    
    public function professorAssistants(){
        $table = $this->loadModel('ProfessorAssistants');
         $professorAssistants= $table->find()->where(['id_prof'=>$this->viewVars['current_user']['identification_number']]);

        if(count($professorAssistants->toArray()) > 0){
           
            $user= new UsersController;
            $contactInfo = $user-> getContactInfo($professorAssistants->toArray()[0]->id_student);
            $idProf = $professorAssistants->toArray()[0]->id_prof;
            $ProfessorName = $user->getNameUser($idProf);

        }
        
        $this->set(compact('professorAssistants', 'contactInfo','ProfessorName' ));
    }

    
}