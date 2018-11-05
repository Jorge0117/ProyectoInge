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

    public function approvedReport()
    {
        $table = $this->loadModel('ApprovedRequestsView');
        $approvedRequestsView = $table->find();
        $user= new UsersController;
        $idProf = $approvedRequestsView->toArray()[0]->id_prof;
        $ProfessorName = $user->getNameUser($idProf);
        $this->set(compact('approvedRequestsView', 'ProfessorName'));
    }

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

}