<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Requests Controller
 *
 * @property \App\Model\Table\RequestsTable $Requests
 *
 * @method \App\Model\Entity\Request[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequestsController extends AppController
{
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function validarFecha()
	{
		$resultado = false;
		$inicio = "2009-10-25"; //CAMBIAR POR FUNCION DE RONDA
		$final = "2019-10-25"; //CAMBIAR POR FUNCION DE RONDA
		
		if(strtotime(date("y-m-d")) < strtotime($final) && strtotime(date("y-m-d")) > strtotime($inicio))
			$resultado = true;
		return $resultado;
	
	}	
	 
    public function index()
    {
        $table = $this->loadModel('InfoRequests');
    
        $rol_usuario = $this->getRequest()->getSession()->read('role_id');
        $id_usuario = $this->getRequest()->getSession()->read('identification_number');

        //Si es un administrativo (Jefe Administrativo o Asistente Asministrativo) muestra todas las solicitudes.
        if($rol_usuario === 'Administrador' || $rol_usuario === 'Asistente'){   //muestra todos
            $query = $table->find();
            $disponible = false; //Devuelve true si la fecha actual se encuentra entre el periodo de alguna ronda
		
            $this->set(compact('query','disponible'));
        }else{

            //ESTUDIANTE
            //Si es estudiante solamente muestra sus solicitudes.
            if($rol_usuario === 'Estudiante'){
                $query = $table->find('all', [
                    'conditions' => ['cedula' => $id_usuario]]);
                $disponible = $this->validarFecha(); //Devuelve true si la fecha actual se encuentra entre el periodo de alguna ronda
		
                $this->set(compact('query','disponible'));                
                
            }else{
                //PROFESOR
                //Si es profesor solamente muestra las solicitudes de sus grupos.
                $query = $table->find('all', [
                    'conditions' => ['id_prof' => $id_usuario]]);
                $disponible = false; 
				
                $this->set(compact('query','disponible'));

            }
        }
        

    }

    /**
     * View method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->loadModel('Users');
		$this->loadModel('Classes');

        $request = $this->Requests->get($id, [
			'contain' => ['Courses', 'Students']
		]);
		
		$user = $this->Users->get($request->student->user_id);

		$query = $this->Classes
				->find()
				->select('professor_id')
				->where(['course_id' => $request->course_id,
					'class_number' => $request->class_number,
					'semester' => $request->class_semester,
					'year' => $request->class_year]);

		$profesor = $query->first();

		if ($profesor) {
			$request['docente'] = $this->Users->get($profesor['professor_id']);
		}
		$this->set('profesor', $profesor);
		// $docente = $this->Users->get($query);
		$request['user'] = $user;
		$this->set('request', $request);		
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
   /* public function add()
    {
        $request = $this->Requests->newEntity();
        if ($this->request->is('post')) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
			
			$RequestsTable=$this->loadmodel('Requests');
			//$round almacena datos originales
			
			debug($request->status,'char');
			
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
        $courses = $this->Requests->Courses->find('list', ['limit' => 200]);
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
        $this->set(compact('request', 'courses', 'students'));
    }
*/

public function get_round_start_date()
{
	$start = date('2018-10-20'); //Deberia pedirselo a ronda
	
	return $start;
}

public function get_student_id()
{
	$student_id = "402220000";
	
    return $student_id;
    
    //return 	$this->Auth->user('identificacion_number'); //Este es el que en realidad hay que devolver
}

public function get_round()
{
	return $this->Requests->getActualRound(date('y-m-d')); //En realidad deberia llamar a la controladora de ronda, la cual luego ejecuta esta instruccion
}

public function add()
    {
		$request = $this->Requests->newEntity();

        if ($this->request->is('post')) {
			
            $request = $this->Requests->patchEntity($request, $this->request->getData());

			$RequestsTable=$this->loadmodel('Requests');
			//$round almacena datos originales
			
			//Modifica los datos que debe extraer de las otras controladoras o que van por defecto:
			$request->set('status', 'p'); //Toda solicitud esta pendiente 
			$request->set('round_start',$this->get_round_start_date());//obtiene llave de ronda

			$request->set('student_id',$this->get_student_id()); //obtiene el id del estudiante logueado
			$request->set('class_year',date('Y')); //obtiene el año actual de la solicitud
			$request->set('class_semester',$this->get_semester()); //obtiene el semestre actual de la solicitud
			$request->set('reception_date',date('Y-m-d')); //obtiene fecha actual
			//die();
			//debug($request);
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('La Solicitud de Asistencia ha sido ingresada exitosamente'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
		$request->set('student_id',$this->get_student_id()); //obtiene el id del estudiante logueado
		/*Este codigo solo se ejecuta al iniciar el formulario del agregar solicitud
		Por lo tanto, lo que se hara aqui es traerse toda la información útil de la base de datos:
		Todos los nombres y codigos de los cursos que tengan al menos un curso disponible para asistencias
		Todos los 
		*/
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
		//$classes = $this->Requests->Classes->find('list', ['limit' => 200]);
		$nombre;
		
		$semestre = "1";
		$año = 2019;
		
		//Se trae la ronda actusl
		$ronda = $this->get_round();
		//debug($ronda);
		
		//Modifica las clases para dejar los datos requeridos de curso y grupo
		//$tuplas = $classes->execute();
		$course = array();
		$teacher;
		
		$classes;
		$grupos = $this->Requests->getGroups($this->get_student_id(),$semestre,$año);
	
		$aux;
		//$aux[0] = "Seleccione un Curso"; 
		//Se trae todos los grupos de la base de datos y los almacena en un vector
		$i = 0;
		$course_counter = 0; 
		foreach($grupos as $g)
		{
			$class[$i] = $g['class_number']; //Se trae el número de clase
			$course[$i] = $g['course_id']; //Se trae el nombre de curso. Esto es para que cuando se seleccione un grupo se pueda encontrar
											//sus grupos sin necesidad de realizar un acceso adicional a la base de datos. Recomendado por Diego
											
			//Busca los cursos y los coloca solo 1 vez en el vector de cursos.
			//Realiza la busqueda en base al codigo de curso, ya que al ser más corto entonces la busqueda será más eficiente
			$encontrado = 0;
			for($j = 0; $j < $course_counter && $encontrado == 0; $j = $j+1)
			{
				if(strcmp($aux[$j]['code'],$g['course_id']) == 0)
					$encontrado = 1;
			}


			
			if($encontrado == 0)
			{
				$aux[$course_counter] = array();
				$aux[$course_counter]['code'] = $g['course_id'];
				$aux[$course_counter]['name'] = $g['name'];
				$course_counter = $course_counter + 1;
			}
								
			$i = $i + 1;
		}	
		

			
		
		//Poner esta etiqueta en el primer campo es obligatorio, para asi obligar al usuario a seleccionar un grupo y asi se pueda
		//activar el evento onChange del select de grupos

		$i = 0;
		//Esta parte se encarga de controlar los codigos y nombres de cursos
		//$cursos = $this->Requests->getCourses(); //Llama a la función encargada de traerse el codigo y nombre de cada curso en el sistema
		
		
		$c2[0] = "Seleccione un Curso"; 
		//foreach($aux as $c) //Recorre cada tupla de curso
		foreach($aux as $c) //Recorre cada tupla de curso
		{
			//Dado que la primer opcion ya tiene un valor por default, los campos deben modifcar el valor proximo a i	
			$c2[$i+1] = $c['code']; //Almacena el codigo de curso
			$nombre[$i+1] = $c['name']; //Almacena el nombre del curso
			$i = $i + 1;
			
		}
		
		$teacher = $this->Requests->getTeachers();
		$id = $this->Requests->getID();
		
		//Funcionalidad Solicitada: Agregar datos del usuario
		
		//Obtiene el carnet del estudiante actual.
		$estudiante = $this->get_student_id();
		
		//En base al carnet del estudiante actual, se trae la tupla de usuario respectiva a ese estudiante
		$estudiante = $this->Requests->getStudentInfo($estudiante);
		
		//Las keys de los arrays deben corresponder al nombre del campo de la tabla que almacene los usuarios
		$nombreEstudiante = $estudiante[0]['name'] . " " . $estudiante[0]['lastname1'] . " " . $estudiante[0]['lastname2'];
		$correo = $estudiante[0]['email_personal'];
		$telefono = $estudiante[0]['phone'];
		$carnet = $estudiante[0]['carne'];
		$cedula = $estudiante[0]['identification_number'];
		
		//$año = date('Y'); //obtiene el año actual de la solicitud
		//$semestre = $this->get_semester(); //obtiene el semestre actual de la solicitud
		
		//debug($nombreEstudiante);
        $this->set(compact('request', 'c2', 'students','class','course','teacher','nombre','id', 'nombreEstudiante', 'carnet', 'correo', 'telefono', 'cedula', 'año', 'semestre'));
		

    }
    /**
     * Edit method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $request = $this->Requests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
		debug($request);
        $courses = $this->Requests->Courses->find('list', ['limit' => 200]);
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
        $this->set(compact('request', 'courses', 'students'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $request = $this->Requests->get($id);
        if ($this->Requests->delete($request)) {
            $this->Flash->success(__('The request has been deleted.'));
        } else {
            $this->Flash->error(__('The request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
		
    }
	
	public function obtenerProfesor()
	{

		$curso = $_GET['curso'];
		$grupo = $_GET['grupo'];

		$profesor = $this->Requests->getTeacher($curso,$grupo);
		
		foreach($profesor as $p) {
			print_r($p);
		}
		
	
		
		 $this->autoRender = false ;
		 

	}
	
	/*public function save()
	{
		//Guarda los datos;
		$backup = $this->loadModel('RequestsBackup');
		$request = $this->Requests->newEntity();
		$request = $this->Requests->patchEntity($request, $this->request->getData()); //Obtiene valores de los campos
		
		$st = $this->get_student_id();
		$ci = null;
		$cai = null;
		$ash = null;
		$aah = null;
		$ft = null; 
		$hah = $request->get('has_another_hours');
		$backup->saveRequest($st,$ci,$cai,$ash,$aah,$ft,$hah);
		
		debug($hah);
		
		//Redirecciona al index
		//return $this->redirect(['action' => 'index']);
	}*/

}
