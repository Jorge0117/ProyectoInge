<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\ClassesController;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require ROOT.DS.'vendor' .DS. 'phpoffice/phpspreadsheet/src/Bootstrap.php';

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

            $courseController = new CoursesController;
            $courseController->add($code, $name, $cred);

            $classController = new ClassesController;
            $classController->addClass($code, $group, $semester, $year, '111111111');

            
            $this->Flash->success(__('Se agregó el curso correctamente.'));
            return $this->redirect(['action' => 'index']);

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
        echo 'THIS IS A TEST |';
        echo $code;
        echo '|';
        echo $class_number;
        echo '|';
        echo $semester;
        echo '|';
        echo $year;
        echo '|';
        //------------------------------------------------
        $result = false;
        //------------------------------------------------
        $model = $this->CoursesClassesVw->newEntity();
        //------------------------------------------------
        if ($this->request->is('post')) {
            //------------------------------------------------
            // $model = $this->CoursesClassesVw->patchEntity(
            //     $model, 
            //     $this->request->getData()
            // );
            //------------------------------------------------
            // $coursesClassesModel = $this->loadmodel('Classes');
            //------------------------------------------------
            // $result = $coursesClassesModel->fetchARow(
            //     $code, 
            //     $class_number, 
            //     $semester,
            //     $year
            // );
            //------------------------------------------------
            if ($this->request->is(['patch', 'post', 'put'])) {
                // $coursesClassesVw = $this->CoursesClassesVw->patchEntity($coursesClassesVw, $this->request->getData());
                // if ($this->CoursesClassesLoad->save($coursesClassesVw)) {
                //     $this->Flash->success(__('The courses classes vw has been saved.'));
                //     return $this->redirect(['action' => 'index']);
                // }
                // $this->Flash->error(__('The courses classes vw could not be saved. Please, try again.'));
                $model = $this->CoursesClassesVw->patchEntity(
                    $model, 
                    $this->request->getData()
                );
                echo "END OF THE VIEW|";
                echo $model->Sigla;
                // Here we can save the thing in the model!!!!!!
                echo "|";
                return $this->redirect(['action' => 'index']);
            }
            // $this->set(compact('coursesClassesVw'));
        }
        //------------------------------------------------
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

    /**
     * 
     */
    public function fetchAllClasses($code = null, $semester = null, $year = null)
    {
        //------------------------------------------------
        $result = -1;
        //------------------------------------------------
        $model = $this->CoursesClassesVw->newEntity();
        //------------------------------------------------
        //------------------------------------------------
        $model = $this->CoursesClassesVw->patchEntity(
            $model, 
            $this->request->getData()
        );
        //------------------------------------------------
        $coursesClassesModel = $this->loadmodel('CoursesClassesVw');
        //------------------------------------------------
        $result = $coursesClassesModel->fetchAllClasses(
            $code,
            $semester,
            $year
        );
        echo $result;
        //------------------------------------------------
        if ($this->request->is('post')) {
            echo "Cute new places keep on poping up";
        }
        return $result;
    }

    

    public function importExcelfile (){
        /*
        $helper = new Helper\Sample();
        debug($helper);
        //$inputFileName = WWW_ROOT . ‘example1.xls‘;
        $inputFileName = TESTS. DS. 'archPrueba2.xlsx';
        ini_set('memory_limit', '-1');
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        var_dump($sheetData);
        die(“here”);
        */

        $coursesClassesVw = $this->CoursesClassesVw->newEntity();

        ini_set('memory_limit', '-1');
        $inputFileName = TESTS. DS. 'archPrueba.xlsx';
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(null);
        $highestColumn = $worksheet->getHighestDataColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
        debug($highestRow);
        debug($highestColumn);
        debug($highestColumnIndex);
        //die();
        
        $table = [];
        $parameters = [];
        for ($row = 5; $row <= $highestRow; ++$row) {
            for ($col = 1; $col <= 4; ++$col) {
                $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                //debug($value);
                $parameters[$col -1] = $value;
            }
            $table[$row -5] = $parameters;
            //debug($parameters);
            unset($parameters);
        }
        $this->set('table', $table);

        if ($this->request->is('post')) {
            for ($row = 0; $row < count($table); ++$row) {
                $this->addFromFile($table[$row]);
            }
        }
        $this->set(compact('coursesClassesVw'));
        //debug($table);
        //die();
        //return $this->redirect(['controller' => 'CoursesClassesVw', 'action' => 'index']);
    }

    public function addFromFile ($parameters){
        if($parameters[0] != null){

            $profId;

            $courseController = new CoursesController;
            $courseController->add($parameters[1], $parameters[0], 0);

            $classController = new ClassesController;
            $classController->addClass($parameters[1], $parameters[2], 1, 2019, $profId);

            debug($parameters);
            die();
        }
    }

}
