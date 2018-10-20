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
        $table = $this->loadmodel('CoursesClassesVw');

        $coursesClassesVw = $table->find();

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
            //Lee los datos del form
            $coursesClassesVw = $this->CoursesClassesVw->patchEntity($coursesClassesVw, $this->request->getData());

            //Guarda cada dato en una variable. En el caso del profesor guarda el índice que se escogió
            $name=$coursesClassesVw->Curso;
            $code=$coursesClassesVw->Sigla;
            $cred=$coursesClassesVw->Creditos;
            $group=$coursesClassesVw->Grupo;
            $indexProf=$coursesClassesVw->Profesor;
            $semester=$coursesClassesVw->Semestre;
            $year=$coursesClassesVw->Año;

            //Obtiene el array de profesores
            $usersController = new UsersController;
            $prof = $usersController->getProfessors();

            //Con el índice de profesor y el método preg_split, so consigue el nombre y el apellido del profesor en un array
            $prof = preg_split('/\s+/', $prof[$indexProf]);
            //Se consigue el id del profesor con el nombre y apellido
            $prof = $usersController->getId($prof[0], $prof[1]);

            //Agrega el curso a la base
            $courseController = new CoursesController;
            $courseController->add($code, $name, $cred);

            //Agrega el grupo al a base
            $classController = new ClassesController;
            $classController->addClass($code, $group, $semester, $year, $prof);


            $this->Flash->success(__('Se agregó el curso correctamente.'));
            return $this->redirect(['action' => 'index']);

        }
        //Consigue le array de profesores
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
    public function edit(
        $code = null, 
        $class_number = null, 
        $semester = null,
        $year = null, 
        $course_name = null,
        $old_professor = null
    )
    {
        //------------------------------------------------
        // To know whether or not the entire process went right.
        $result = false;
        //------------------------------------------------
        $model = $this->CoursesClassesVw->newEntity();
        //------------------------------------------------
        // Three controller to comunicate with other models or handle the two relations or tables.
        $usersController = new UsersController;
        //------------------------------------------------
        // To fetch the options of the courses and the classes.
        $classesModel = $this->loadmodel('Classes');
        $coursesModel = $this->loadmodel('Courses');
        $courses = $coursesModel->find('list', ['limit' => 1000]);
        $all_classes_codes = $classesModel->find('list', ['limit' => 1000])->select('class_number');
        //------------------------------------------------
        // This fetch the professors' names.
        // Actually, this instruction fetches a array of
        // arrays with the information of the professors
        // so we use it a little bit weird in a momnent.
        $professors = $usersController->getProfessors();
        //------------------------------------------------
        // This send the creates the variable and its content.
        $this->set('code', $code);
        $this->set('class_number', $class_number);
        $this->set('semester', $semester);
        $this->set('year', $year);
        $this->set('professors', $professors);
        $this->set('courses', $courses);
        $this->set('all_classes_codes', $all_classes_codes);
        $this->set('course_name', $course_name);
        $this->set('old_professor', $old_professor);
        //------------------------------------------------
        // This is when the user says 'Aceptar'.
        if ($this->request->is('post')) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                // To prevent SQL injection.
                $model = $this->CoursesClassesVw->patchEntity(
                    $model,
                    $this->request->getData()
                );
                // First we fetch the selected index
                $indexProf=$model->Profesor;
                // Then we fetch the professors again.
                $prof = $usersController->getProfessors();
                // And finally we "translate" the professors index into the dni
                $prof = preg_split('/\s+/', $prof[$indexProf]);
                $prof = $usersController->getId($prof[0], $prof[1]);
                //------------------------------------------------
                // Finally,we make the update.
                $result = $classesModel->updateClass(
                    $code,
                    $class_number,
                    $semester,
                    $year,
                    $model->Curso,
                    $model->Grupo,
                    $model->Semestre + 1,
                    $model->Año,
                    $prof
                );
                //------------------------------------------------
                // Thsi shows the message to the user.
                if ($result) {
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
        // This loads the model so we can execute an 
        // query into de database.
        $classesModel = $this->loadmodel('Classes');
        //------------------------------------------------
        // The call itself
        $result = $classesModel->deleteClass(
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
        $this->loadModel('CoursesClassesVw');
        $coursesClassesVw = $this->CoursesClassesVw->newEntity();
        $UserController = new UsersController;
        $fileController = new FilesController;
        //Quita el límite de la memoria, ya que los archivos la pueden gastar
        ini_set('memory_limit', '-1');

        //Lee el archivo que se va a subir

        $fileDir = $fileController->getDir();
        $inputFileName = WWW_ROOT. 'files'. DS. 'files'. DS. 'file'. DS. $fileDir[1]. DS. $fileDir[0];

        //$inputFileName = TESTS. DS. 'archPrueba.xlsx';
        //Identifica el tipo de archivo
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        //Crea un nuevo reader para el tipo de archivo
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        //Hace que el reader sólo lea archivos con datos
        $reader->setReadDataOnly(true);
        //Carga el archivo a un spreadsheet
        $spreadsheet = $reader->load($inputFileName);

        $worksheet = $spreadsheet->getActiveSheet();
        //Consigue la posición de la última fila
        $highestRow = $worksheet->getHighestRow(null);
        //Consigue la posición de la última columna
        $highestColumn = $worksheet->getHighestDataColumn();
        //Transforma la última fila a un index. Ejemplo C = 3
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        //Contiene una matriz con las filas del archivo
        $table = [];
        //Contiene las filas del archivo
        $rows = [];

        $profIds = [];
        //Se llena la matriz
        for ($row = 5; $row <= $highestRow; ++$row) {
            for ($col = 1; $col <= 4; ++$col) {
                $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                $rows[$col -1] = $value;

                //Revisa si el profe existe
                if($col == 4){
                    if($value != null){
                        //Divide el profesor en nombre y apellido
                        $prof = preg_split('/\s+/', $value);
                        //Consigue el id del profesor
                        $id = $UserController->getId($prof[1], $prof[0]);
                        if($id == null){
                            debug($value);
                            //die();
                            $this->Flash->error('El profesor '. $value .' no se encuentra en la tabla');
                            return $this->redirect(['controller' => 'CoursesClassesVw', 'action' => 'index']);
                        }else{
                            array_push($profIds, $id);
                        }
                    }else{
                        array_push($profIds, null);
                    }
                    
                }

            }
            $table[$row -5] = $rows;
            unset($rows); //resetea el array rows
        }
        //Hace que table sea visible para el template
        $this->set('table', $table);

        //Cuando se da aceptar
        if ($this->request->is('post')) {
            //Borra todos los grupos
            $ClassesController = new ClassesController;
            $result = $ClassesController->deleteAll();

            //Llama al método addFromFile con cada fila
            for ($row = 0; $row < count($table); ++$row) {
                $this->addFromFile($table[$row], $profIds[$row]);
            }
            $this->Flash->success(__('Se agregaron los cursos correctamente.'));
            return $this->redirect(['controller' => 'CoursesClassesVw', 'action' => 'index']);
        }
        $this->set(compact('coursesClassesVw'));
    }

    public function addFromFile ($parameters, $profId){
        //Si la fila está vacía no hace nada
        if($parameters[0] != null){

            //Divide el profesor en nombre y apellido
            //$prof = preg_split('/\s+/', $parameters[3]);
            //Consigue el id del profesor
            //$UserController = new UsersController;
            //$profId = $UserController->getId($prof[1], $prof[0]);

            //Agrega el curso
            $courseController = new CoursesController;
            $courseController->add($parameters[1], $parameters[0], 0);

            //Agrega el grupo
            $classController = new ClassesController;
            $classController->addClass($parameters[1], $parameters[2], 1, 2019, $profId);

        }
    }

    public function deleteAll (){
        //Borra todos los grupos
        $ClassesController = new ClassesController;
        $result = $ClassesController->deleteAll();
    }
}
