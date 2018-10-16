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
     * Index method, Joseph Rementería.
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


            $name=$coursesClassesVw->Curso;
            $code=$coursesClassesVw->Sigla;
            $cred=$coursesClassesVw->Creditos;
            $group=$coursesClassesVw->Grupo;
            $indexProf=$coursesClassesVw->Profesor;
            $semester=$coursesClassesVw->Semestre;
            $year=$coursesClassesVw->Año;

            $usersController = new UsersController;
            $prof = $usersController->getProfessors();

            $prof = preg_split('/\s+/', $prof[$indexProf]);
            $prof = $usersController->getId($prof[0], $prof[1]);

            $courseController = new CoursesController;
            $courseController->add($code, $name, $cred);

            $classController = new ClassesController;
            $classController->addClass($code, $group, $semester, $year, $prof);


            $this->Flash->success(__('Se agregó el curso correctamente.'));
            return $this->redirect(['action' => 'index']);

        }
        $usersController = new UsersController;
        $professors = $usersController->getProfessors();
        $this->set(compact('coursesClassesVw', 'professors'));
    }

    /**
     * Edit method, edited by Joseph Rementería.
     *
     * params:
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($code = null, $class_number = null, $semester = null,$year = null, $course_name = null)
    {
        //------------------------------------------------
        // To know whether or not the entire process went right.
        $result = false;
        //------------------------------------------------
        $model = $this->CoursesClassesVw->newEntity();
        //------------------------------------------------
        // Three controller to comunicate with other models or handle the two relations or tables.
        $ClassesController = new ClassesController;
        $CoursesController = new CoursesController;
        $usersController = new UsersController;
        //------------------------------------------------
        // To fetch the options of the courses and the classes.
        $courses = $CoursesController->Courses->find('list',['limit' => 1000]);
        $all_classes_codes = $ClassesController->Classes->find('list',['limit' => 1000])->select('class_number');
        //------------------------------------------------
        // This fetch the professors' names.
        // Actually, this instruction fetches a array of
        // arrays with the information of the professors
        // so we use it a little bit weird in a momnent.
        $professors = $usersController->getProfessors();
        //------------------------------------------------
        // This send the creates the variable and its content.
        $this->set('code',$code);
        $this->set('class_number',$class_number);
        $this->set('semester',$semester);
        $this->set('year',$year);
        $this->set('professors',$professors);
        $this->set('courses',$courses);
        $this->set('all_classes_codes',$all_classes_codes);
        $this->set('course_name',$course_name);
        //------------------------------------------------
        // This is when the user says 'Aceptar'.
        if ($this->request->is('post')) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                // To prevent SQL injection.
                $model = $this->CoursesClassesVw->patchEntity(
                    $model,
                    $this->request->getData()
                );
                //------------------------------------------------
                // This is to translate the course's nae to the code.
                $new_course_id = $CoursesController->selectACourseCodeFromName($model->Curso);
                //------------------------------------------------
                // First we fetch the selected index
                $indexProf=$model->Profesor;
                // Then we fetch the professors again.
                $prof = $usersController->getProfessors();
                // And finally we "translate" the professors index into the dni
                $prof = preg_split('/\s+/', $prof[$indexProf]);
                $prof = $usersController->getId($prof[0], $prof[1]);
                //------------------------------------------------
                // Finally,we make the update.
                $result = $ClassesController->update(
                    $code,
                    $class_number,
                    $semester,
                    $year,
                    $new_course_id,
                    $model->Grupo,
                    $model->Semestre,
                    $model->Año,
                    $prof
                );
                //------------------------------------------------
                // Thsi shows the message to the user.
                if (!$result) {
                    $this->Flash->success(__('Se editó el curso correctamente.'));
                } else {
                    $this->Flash->error(__('Error: no se pudo editar el curso.'));
                }
                //------------------------------------------------
                // This redirect the view to the index.
                return $this->redirect(['action' => 'index']);
            }
        }
        //------------------------------------------------
    }

    /**
     * Delete method, edited by Joseph Rementería.
     *
     * @param string|null $id Courses Classes Vw id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($code = null, $class_number = null, $semester = null,$year = null)
    {
        //------------------------------------------------
        // The courses are only deleted when a new
        // 'Excel' is loaded so this delete method call the
        // one from the classses/groups controller .
        $ClassesController = new ClassesController;
        //------------------------------------------------
        // The call itself
        $result = $ClassesController->delete(
            $code,
            $class_number,
            $semester,
            $year
        );
        //------------------------------------------------
        if ($result) {
            $this->Flash->success(__('Se eliminó el curso correctamente.'));
        } else {
            $this->Flash->error(__('Error: no se pudo eliminar el curso.'));
        }
        //------------------------------------------------
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Fetches all the groups numbers thath matches with the given params.
     */
    public function fetchAllClasses($code = null, $semester = null, $year = null)
    {
        //------------------------------------------------
        $result = false;
        //------------------------------------------------
        $coursesClassesModel = $this->loadmodel('CoursesClassesVw');
        //------------------------------------------------
        $result = $coursesClassesModel->fetchAllClasses(
            $code,
            $semester,
            $year
        );
        //------------------------------------------------
        return $result;
    }

    public function importExcelfile (){

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
            $ClassesController = new ClassesController;
            $result = $ClassesController->deleteAll();

            for ($row = 0; $row < count($table); ++$row) {
                $this->addFromFile($table[$row]);
            }
            return $this->redirect(['controller' => 'CoursesClassesVw', 'action' => 'index']);
        }
        $this->set(compact('coursesClassesVw'));
        //debug($table);
        //die();
        //return $this->redirect(['controller' => 'CoursesClassesVw', 'action' => 'index']);
    }

    public function addFromFile ($parameters){
        if($parameters[0] != null){

            $prof = preg_split('/\s+/', $parameters[3]);
            $UserController = new UsersController;
            $profId = $UserController->getId($prof[1], $prof[0]);

            $courseController = new CoursesController;
            $courseController->add($parameters[1], $parameters[0], 0);

            $classController = new ClassesController;
            $classController->addClass($parameters[1], $parameters[2], 1, 2019, $profId);

            //debug($parameters);
        }
    }

    public function deleteAll (){
        $ClassesController = new ClassesController;
        $result = $ClassesController->deleteAll();
    }
}
