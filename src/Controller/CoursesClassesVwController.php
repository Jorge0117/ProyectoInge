<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\ClassesController;

/**
 * CoursesClassesVw Controller
 *
 * @property \App\Model\Table\CoursesClassesVwTable $CoursesClassesVw
 *
 * @method \App\Model\Entity\CoursesClassesVw[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesClassesVwController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $coursesClassesVw = $this->paginate($this->CoursesClassesVw);

        $this->set(compact('coursesClassesVw'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $coursesClassesVw = $this->CoursesClassesVw->newEntity();
        if ($this->request->is('post')) {
            $coursesClassesVw = $this->CoursesClassesVw->patchEntity($coursesClassesVw, $this->request->getData());
            if ($this->CoursesClassesVw->save($coursesClassesVw)) {
                $this->Flash->success(__('The courses classes vw has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The courses classes vw could not be saved. Please, try again.'));
        }
        $this->set(compact('coursesClassesVw'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Courses Classes Vw id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($code = null, $class_number = null, $semester = null,$year = null)
    {
        //------------------------------------------------
        $result = false;
        //------------------------------------------------
        $model = $this->CoursesClassesVw->newEntity();
        //------------------------------------------------
        if ($this->request->is('post')) {
            //------------------------------------------------
            $model = $this->CoursesClassesVw->patchEntity(
                $model, 
                $this->request->getData()
            );
            echo 'test014568';
            //------------------------------------------------
            $coursesClassesModel = $this->loadmodel('Classes');
            //------------------------------------------------
            $result = $coursesClassesModel->fetchARow(
                $code, 
                $class_number, 
                $semester,
                $year
            );
            //------------------------------------------------
            if ($this->request->is(['patch', 'post', 'put'])) {
                $coursesClassesVw = $this->CoursesClassesVw->patchEntity($coursesClassesVw, $this->request->getData());
                if ($this->CoursesClassesLoad->save($coursesClassesVw)) {
                    $this->Flash->success(__('The courses classes vw has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The courses classes vw could not be saved. Please, try again.'));
            }
            // $this->set(compact('coursesClassesVw'));
        }
        //------------------------------------------------
        //return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Courses Classes Vw id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($code = null, $class_number = null, $semester = null,$year = null)
    {
        //------------------------------------------------
        $ClassesController = new ClassesController;
        //------------------------------------------------
        $result = $ClassesController->delete(
            $code, 
            $class_number, 
            $semester, 
            $year
        );
        //------------------------------------------------
        if ($result) {
            $this->Flash->success(__('The courses classes vw has been deleted.'));
        } else {
            $this->Flash->error(__('The courses classes vw could not be deleted. Please, try again.'));
        }
        //------------------------------------------------
        return $this->redirect(['action' => 'index']);
    }
}
