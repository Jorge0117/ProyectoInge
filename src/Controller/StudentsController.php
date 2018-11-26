<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Students Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 *
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $students = $this->paginate($this->Students);

        $this->set(compact('students'));
    }

    /**
     * View method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['Applications', 'Requests', 'RequestsBackup']
        ]);

        $this->set('student', $student);
    }

    /**
     * Add a new student specifying id and carne
     */
    public function newStudent($id, $carne){        
        $student = new Student([
            'user_id' => $id,
            'carne' => $carne
        ]);
        
        if ($articles->save($student)) {
            $this->Flash->success(__('Se agregó el estudiante correctamente.'));        
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $student = $this->Students->newEntity();
        if ($this->request->is('post')) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }
        $this->set(compact('student'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }
        $this->set(compact('student'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student = $this->Students->get($id);
        if ($this->Students->delete($student)) {
            $this->Flash->success(__('The student has been deleted.'));
        } else {
            $this->Flash->error(__('The student could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Modifica el ponderado de un estudiante.
     * 
     * @author Kevin Jiménez <kevinja9608@gmail.com>
     * @param String $id Identificador del estudiante
     * @param Float $average Ponderado del estudiante
     * @return Bool Verdadero si se completo correctamente, falso en otro caso.
     */
    public function saveAverage($id, $average){
        return $this->Students->saveAverage($id, $average);
    }

    /**
     * Retorna el ponderado de un estudiante.
     * 
     * @author Kevin Jiménez <kevinja9608@gmail.com>
     * @param String $id Identificador del estudiante
     * @return float Ponderado del estudiante, 0 si no se la ha asignado uno.
     */
    public function getAverage($id){
        return floatval($this->Students->getAverage($id));
    }
}
