<?php
namespace App\Controller;

use App\Controller\AppController;

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
     * View method
     *
     * @param string|null $id Courses Classes Vw id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coursesClassesVw = $this->CoursesClassesVw->get($id, [
            'contain' => []
        ]);

        $this->set('coursesClassesVw', $coursesClassesVw);
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


            $name=$coursesClassesVw->Curso;
            $code=$coursesClassesVw->Sigla;
            $cred=$coursesClassesVw->Creditos;
            $group=$coursesClassesVw->Grupo;
            $professor=$coursesClassesVw->Profesor;
            $semester=$coursesClassesVw->Semestre;
            $year=$coursesClassesVw->Año;

            debug($name);
            debug($code);
            debug($cred);
            //die();

            $courseController = new CoursesController;
            $courseController->add($code, $name, $cred);

            $classController = new ClassesController;
            $classController->add($code, $group, $semester, $year, '111111111');
            /*
            $courseTable=$this->loadmodel('Courses');
            $courseTable->addCourse($code, $name, $cred);
            
            $classTable=$this->loadmodel('Classes');
            $classTable->addClass($code, $group, $semester, $year, 1, '111111111');
            */
            $this->Flash->success(__('Se agregó el curso correctamente.'));
            return $this->redirect(['action' => 'index']);

            /*
            if ($this->CoursesClassesVw->save($coursesClassesVw)) {
                $this->Flash->success(__('The courses classes vw has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The courses classes vw could not be saved. Please, try again.'));*/
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
    public function edit($id = null)
    {
        $coursesClassesVw = $this->CoursesClassesVw->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
     * Delete method
     *
     * @param string|null $id Courses Classes Vw id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coursesClassesVw = $this->CoursesClassesVw->get($id);
        if ($this->CoursesClassesVw->delete($coursesClassesVw)) {
            $this->Flash->success(__('The courses classes vw has been deleted.'));
        } else {
            $this->Flash->error(__('The courses classes vw could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
