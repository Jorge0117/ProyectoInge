<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Classes Controller
 *
 * @property \App\Model\Table\ClassesTable $Classes
 *
 * @method \App\Model\Entity\Class[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClassesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Courses', 'Professors']
        ];
        $classes = $this->paginate($this->Classes);

        $this->set(compact('classes'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($code, $group, $semester, $year, $profId)
    {
        $classTable=$this->loadmodel('Classes');
        return $classTable->addClass($code, $group, $semester, $year, 1, $profId);
    }

    /**
     * Edit method
     *
     * @param string|null $id Class id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $class = $this->Classes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $class = $this->Classes->patchEntity($class, $this->request->getData());
            if ($this->Classes->save($class)) {
                $this->Flash->success(__('The class has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The class could not be saved. Please, try again.'));
        }
        $courses = $this->Classes->Courses->find('list', ['limit' => 200]);
        $professors = $this->Classes->Professors->find('list', ['limit' => 200]);
        $this->set(compact('class', 'courses', 'professors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Class id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($code, $class_number, $semester, $year)
    {
        //------------------------------------------------
        $result = false;
        //------------------------------------------------
        $model = $this->Classes->newEntity();
        //------------------------------------------------
        if ($this->request->is('post')) {
            //------------------------------------------------
            $model = $this->Classes->patchEntity(
                $model, 
                $this->request->getData()
            );
            //------------------------------------------------
            $classesModel = $this->loadmodel('Classes');
            //------------------------------------------------
            $result = $classesModel->deleteClass(
                $code, 
                $class_number, 
                $semester,
                $year
            );
        }
        //------------------------------------------------
        return $result;
    }
}
