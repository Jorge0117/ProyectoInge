<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 *
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->Auth->allow('add');
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $file = $this->Files->newEntity();
        if ($this->request->is('post')) {
            $file = $this->Files->patchEntity($file, $this->request->getData());

            $fileTable = $this->loadmodel('Files');
            $fileTable->deleteFiles();

            if ($this->Files->save($file)) {
                //$this->Flash->success(__('The file has been saved.'));
                return $this->redirect(['controller' => 'CoursesClassesVW', 'action' => 'importExcelfile']);
            }
            $this->Flash->error(__('Error subiendo el archivo'));
        }
        $this->set(compact('file'));
    }

    public function getDir(){
        $fileTable = $this->loadmodel('Files');
        return $fileTable->getDir();
    }
    
}
