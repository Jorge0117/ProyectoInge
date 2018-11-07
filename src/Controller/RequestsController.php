<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;

/**
 * Requests Controller
 *
 * @property \App\Model\Table\RequestsTable $Requests
 *
 * @method \App\Model\Entity\Request[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequestsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        /**
         * FIXME
         * Arreglar permisos en la bd.
         */
        parent::beforeFilter($event);
        $this->Auth->allow('print');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    /*public function validarFecha()
    {
        $resultado = false;
        $inicio = "2009-10-25"; //CAMBIAR POR FUNCION DE RONDA
        $final = "2019-10-25"; //CAMBIAR POR FUNCION DE RONDA

        if (strtotime(date("y-m-d")) < strtotime($final) && strtotime(date("y-m-d")) > strtotime($inicio)) {
            $resultado = true;
        }

        return $resultado;

    }*/

    public function index()
    {
        $table = $this->loadModel('InfoRequests');
        $rounds = $this->loadModel('Rounds');
        $rol_usuario = $this->Auth->user('role_id');
        $id_usuario = $this->Auth->user('identification_number');
        $ronda_actual = $rounds->getStartActualRound();

        //Si es un administrativo (Jefe Administrativo o Asistente Asministrativo) muestra todas las solicitudes.
        if ($rol_usuario === 'Administrador' || $rol_usuario === 'Asistente') { //muestra todos
            $query = $table->find('all', [
                'conditions' => ['inicio' => $ronda_actual],
            ]);
            $admin = true;
            $this->set(compact('query', 'admin'));
        } else {

            //ESTUDIANTE
            //Si es estudiante solamente muestra sus solicitudes.
            if ($rol_usuario === 'Estudiante') {
                $query = $table->find('all', [
                    'conditions' => ['cedula' => $id_usuario, 'inicio' => $ronda_actual],
                ]);
                $admin = false;
                $this->set(compact('query', 'admin'));

            } else {
                //PROFESOR
                //Si es profesor solamente muestra las solicitudes de sus grupos.
                $query = $table->find('all', [
                    'conditions' => ['id_prof' => $id_usuario, 'inicio' => $ronda_actual],
                ]);
                $admin = false;
                $this->set(compact('query', 'admin'));
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
            'contain' => ['Courses', 'Students'],
        ]);

        $user = $this->Users->get($request->student->user_id);

        $query = $this->Classes
            ->find()
            ->select('professor_id')
            ->where(
                [
                    'course_id' => $request->course_id,
                    'class_number' => $request->class_number,
                    'semester' => $request->class_semester,
                    'year' => $request->class_year,
                ]
            );

        $profesor = $query->first();

        if ($profesor) {
            $request['docente'] = $this->Users->get($profesor['professor_id']);
        }
        $this->set('profesor', $profesor);
        // $docente = $this->Users->get($query);
        $request['user'] = $user;
        $this->set('request', $request);
    }
    
    public function print($id = null)
    {
		// $this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->layout = 'request';
		$this->loadModel('Users');
		$this->loadModel('Classes');

        $request = $this->Requests->get($id, [
            'contain' => ['Courses', 'Students'],
        ]);

        $user = $this->Users->get($request->student->user_id);

        $query = $this->Classes
            ->find()
            ->select('professor_id')
            ->where(
                [
                    'course_id' => $request->course_id,
                    'class_number' => $request->class_number,
                    'semester' => $request->class_semester,
                    'year' => $request->class_year,
                ]
            );

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

       // return $student_id;

		return     $this->Auth->user('identification_number'); //Este es el que en realidad hay que devolver
    }

    // public function get_student_id()
    // {
    //     $student_id = "402220000";

    //     return $student_id;

    // //return     $this->Auth->user('identificacion_number'); //Este es el que en realidad hay que devolver
    // }

    public function get_round()
    {
        return $this->Requests->getActualRound(date('y-m-d')); //En realidad deberia llamar a la controladora de ronda, la cual luego ejecuta esta instruccion
    }

    public function get_semester()
    {
        //Pedir get_round y luego sacar el atributo

        return "1";
    }

    public function add()
    {
        $request = $this->Requests->newEntity();

        if ($this->request->is('post')) {

            $request = $this->Requests->patchEntity($request, $this->request->getData());

            $RequestsTable = $this->loadmodel('Requests');
            //$round almacena datos originales

            //Modifica los datos que debe extraer de las otras controladoras o que van por defecto:
            $request->set('status', 'p'); //Toda solicitud esta pendiente
            //$request->set('round_start', $this->get_round_start_date()); //obtiene llave de ronda

            $request->set('student_id', $this->get_student_id()); //obtiene el id del estudiante logueado
			
			//Se trae la ronda actusl
			$ronda = $this->get_round();
			
			//---------------------------------
			if($ronda[0]['semester'] == 'II')
				$nuevoSemestre = "2";
			else
				$nuevoSemestre = "1";
			
			$nuevoAño = $ronda[0]['year'];
			$request->set('round_start', $ronda[0]['start_date']);
			//---------------------------------
			
            $request->set('class_year', $nuevoAño); //obtiene el año actual de la solicitud
            $request->set('class_semester', $nuevoSemestre); //obtiene el semestre actual de la solicitud
            $request->set('reception_date', date('Y-m-d')); //obtiene fecha actual

			
			if(($request->get('wants_student_hours') || $request->get('wants_assistant_hours')) == false)
			{
				//Si el estudiante no marco ningun tipo de hora, entonces deja las horas asistente por defecto
				$request->set('wants_assistant_hours',true);
			}
			
            //die();
            //debug($request);
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('Se agrego la Solicitud Correctamente'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error: No se logró agregar la solicitud'));
        }
        $request->set('student_id', $this->get_student_id()); //obtiene el id del estudiante logueado
        /*Este codigo solo se ejecuta al iniciar el formulario del agregar solicitud
        Por lo tanto, lo que se hara aqui es traerse toda la información útil de la base de datos:
        Todos los nombres y codigos de los cursos que tengan al menos un curso disponible para asistencias
        Todos los
         */
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
        //$classes = $this->Requests->Classes->find('list', ['limit' => 200]);
        $nombre;

        $semestre = "2";
        $año = 2018;

        //Se trae la ronda actusl
        $ronda = $this->get_round();

				//debug($ronda);
		//---------------------------------
		if($ronda[0]['semester'] == 'II')
			$semestre = "2";
		else
			$semestre = "1";
		
		$año = $ronda[0]['year'];
		//---------------------------------
		
        //Modifica las clases para dejar los datos requeridos de curso y grupo
        //$tuplas = $classes->execute();
        $course = array();
        $teacher;

        $classes;
        $grupos = $this->Requests->getGroups($this->get_student_id(), $semestre, $año);

        $aux;
        //$aux[0] = "Seleccione un Curso";
        //Se trae todos los grupos de la base de datos y los almacena en un vector
        $i = 0;
        $course_counter = 0;
        foreach ($grupos as $g) {
            $class[$i] = $g['class_number']; //Se trae el número de clase
            $course[$i] = $g['course_id']; //Se trae el nombre de curso. Esto es para que cuando se seleccione un grupo se pueda encontrar
            //sus grupos sin necesidad de realizar un acceso adicional a la base de datos. Recomendado por Diego
			$profesor[$i] = $g['prof']; //Se trae el nombre del profesor el grupo
            //Busca los cursos y los coloca solo 1 vez en el vector de cursos.
            //Realiza la busqueda en base al codigo de curso, ya que al ser más corto entonces la busqueda será más eficiente
            $encontrado = 0;
            for ($j = 0; $j < $course_counter && $encontrado == 0; $j = $j + 1) {
                if (strcmp($aux[$j]['code'], $g['course_id']) == 0) {
                    $encontrado = 1;
                }

            }

            if ($encontrado == 0) {
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
        foreach ($aux as $c) //Recorre cada tupla de curso
        {
            //Dado que la primer opcion ya tiene un valor por default, los campos deben modifcar el valor proximo a i
            $c2[$i + 1] = $c['code']; //Almacena el codigo de curso
            $nombre[$i + 1] = $c['name']; //Almacena el nombre del curso
            $i = $i + 1;

        }


        //$teacher = $this->Requests->getTeachers();
        //$id = $this->Requests->getID();

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
        $this->set(compact('request', 'c2', 'students', 'class', 'course', 'teacher', 'nombre', 'id', 'nombreEstudiante', 'carnet', 'correo', 'telefono', 'cedula', 'año', 'semestre', 'profesor'));

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
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
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

        $profesor = $this->Requests->getTeacher($curso, $grupo);

        foreach ($profesor as $p) {
            print_r($p);
        }

        $this->autoRender = false;

    }

    public function review($id = null)
    {
        $role_c = new RolesController;
        $this->loadModel('Requirements');
        $this->loadModel('RequestsRequirements');
        //--------------------------------------------------------------------------
        // Modulo y acción requeridos para verificar permisos
        $action = 'review';
        $module = 'Requests';
        $user = $this->Auth->user();
        //debug($user);
        $request = $this->Requests->get($id);
        $data_stage_completed = false;
        //Datos de la solicitud

        // All of the variables added in this section are ment to be for
        // the preliminar review of each requests.
        $load_preliminar_review = false;
        $default_index = null;

        $load_final_review = false;
        //--------------------------------------------------------------------------

        $load_final_review = false;

        $request_stage = $request->stage;
        $this->set(compact('request_stage'));

        //Datos de la solicitud
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Data')) {

        }
        //Revision de requisitos
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Requirements') && $request_stage > 0) {
            $requirements = $this->Requirements->getRequestRequirements($id); 
            $requirements['stage'] =  $request->stage;
            //debug($requirements);
			$this->set(compact('requirements'));			
        }

        //Revisión preliminar
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Preliminary') && $request_stage > 1) {
            $load_preliminar_review = true; // $load_review_requirements
            $default_index = $this->Requests->getStatusIndexOutOfId($id);
        }

        //Revisión final
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Final') && $request_stage > 2 && ($default_index == 1 || $default_index >=3)) {
            $load_final_review = true;
            $default_indexf = 0;
            if($default_index == 4)$default_indexf = 1;
            else if($default_index == 5)$default_indexf = 2;
            $this->set('default_indexf', $default_indexf);
            $this->set('id', $id);
        }

        //Se trae los datos de la solicitud
        $request = $this->Requests->get($id);
        $user = $this->Requests->getStudentInfo($request['student_id']);
        $user = $user[0]; //Agarra la unica tupla
        $class = $this->Requests->getClass($request['course_id'], $request['class_number']);
        $class = $class[0];
        $professor = $this->Requests->getTeacher($request['course_id'], $request['class_number'], $request['class_semester'], $request['class_year']);
        $professor = $professor[0];

        //--------------------------------------------------------------------------
        // Sending the value of the boolean that says whether the preliminar review
        // should appears or not and the default index.
        $this->set('load_preliminar_review', $load_preliminar_review);
        $this->set('default_index', $default_index);
        //--------------------------------------------------------------------------
        //Manda los parametros a la revision
        $this->set(compact('request', 'user', 'class', 'professor'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            //debug($data);
            //--------------------------------------------------------------------------
            if (array_key_exists('AceptarRequisitos', $data)) {
				// Actualizar el estado de los requisitos opcionales
				$requirements_review_completed = true;
                for ($i = 0; $i < count($requirements['Opcional']); $i++) {
                    $requirement_number = intval($requirements['Opcional'][$i]['requirement_number']);
                    $optional_requirement = $this->RequestsRequirements->newEntity();
                    $optional_requirement->request_id = intval($id);
                    $optional_requirement->requirement_number = $requirement_number;
                    $optional_requirement->state = $data['requirement_' . $requirement_number] == 'rejected' ? 'r' : 'a';
                    if(array_key_exists('inopia_op_' . $requirement_number,$data)){
                        $optional_requirement->acepted_inopia = 1;
                    }else{
                        $optional_requirement->acepted_inopia = 0;
                    }
                    //debug($optional_requirement);
                    if (!$this->RequestsRequirements->save($optional_requirement)) {
						$requirements_review_completed = false;
						return;
					}
				}
				
				// Actualizar el estado de los requisitos obligatorios
                for ($i = 0; $i < count($requirements['Obligatorio']); $i++) {
                    $requirement_number = intval($requirements['Obligatorio'][$i]['requirement_number']);
                    $optional_requirement = $this->RequestsRequirements->newEntity();
                    $optional_requirement->request_id = intval($id);
                    $optional_requirement->requirement_number = $requirement_number;
                    $optional_requirement->state = $data['requirement_' . $requirement_number] == 'rejected' ? 'r' : 'a';
                    //debug($optional_requirement);
                    if (!$this->RequestsRequirements->save($optional_requirement)) {
                        $requirements_review_completed = false;
						return;
                    }
				}

				//Se muestra un mensaje informando si la transacción se completo o no.
				if($requirements_review_completed){
					$this->Flash->success(__('Se ha guardado la revision de requerimientos.'));
					$request_reviewed = $this->Requests->get($id);
					$request_reviewed->stage = 2;
					$this->Requests->save($request_reviewed);
				}else{
					$this->Flash->error(__('No se ha logrado guardar la revision de requerimientos.'));
				}
            }
            //--------------------------------------------------------------------------
            // When the user says 'aceptar', we only have to change a request status
            // if the loaded view was the preliminar one and not the last one
            if (array_key_exists('AceptarPreliminar', $data)) {
                //--------------------------------------------------------------------------
                $status_index = $data['Clasificación'];
                switch ($status_index) {
                    case 0:
                        $status_new_val = 'p';
                        break;
                    case 1:
                        $status_new_val = 'e';
                        break;
                    case 2:
                        $status_new_val = 'n';
                        break;
                    case 3:
                        $status_new_val = 'i';
                        break;
                }
                $requirements = $this->Requirements->getRequestRequirements($id);
                //--------------------------------------------------------------------------
                // Comunication with other controllers
                $requirementsController = new RequirementsController();
                //--------------------------------------------------------------------------
                // This counts the  amount of mandatory requirements in the reqirements table
                // and the amount of them in this request
                $total_of_mandatories_requirements = $requirementsController->countmandatoryRequirements();
                $total_of_aproved_req = sizeof($requirements['Obligatorio']);
                //--------------------------------------------------------------------------
                // if this request was the same amount of mandatory requirements approved 
                // as the ones in the table and whether the administrator wants to 
                // classified this as 'i' or 'e', the change can be seen in the DB.
                $update_bool = false;
                if (('p' == $status_new_val) || ('n' == $status_new_val)) {
                    $update_bool = true; 
                }
                if (($total_of_mandatories_requirements == $total_of_aproved_req) && (('e' == $status_new_val) || ('i' == $status_new_val))) {
                    $update_bool = true;
                    //Redirecciona al index:
                } else {
                    if (('e' == $status_new_val) || ('i' == $status_new_val)) {
                        $this->Flash->error(__('El estudiante no cumple con los requisitos obligatorios'));
                    }
                }

                if ($update_bool) {
                    $this->Requests->updateRequestStatus($request['id'], $status_new_val); //llama al metodo para actualizar el estado
					$this->Flash->success(__('Se ha cambiado el estado de la solicitud correctamente'));
					$request_reviewed = $this->Requests->get($id);
					$request_reviewed->stage = 3;
                    $this->Requests->save($request_reviewed);
                }
                //Si el estado es no aceptado, se envía el tipo de mensaje 1
                if($status_new_val == 'n'){
                    $this->sendMail($request['id'],1);
                }
            }
            //--------------------------------------------------------------------------
            // return $this->redirect(['action' => 'index']);
            //$request_status = $this->Requests->getStatusIndexOutOfId($id);
            //debug('entra '.$load_final_review);
            if (array_key_exists('AceptarFin', $data)) {
                debug($data);
                $status_index = $data['End-Classification'];
                switch ($status_index) {
                    case 1:
                        $status_new_val = 'a';
                        break;
                    case 2:
                        $status_new_val = 'r';
                        break;
                }
                if($status_new_val == 'a'){
                    $this->Requests->approveRequest($id,$data["type"],$data["hours"]);
                    $this->Requests->updateRequestStatus($id, $status_new_val);
                }else if($status_new_val == 'r'){
                    $this->Requests->declineRequest($id);
                    $this->Requests->updateRequestStatus($id, $status_new_val);
                }
                
                //Si el estado es rechazado, se envía correo con el tipo de mensaje 2
                if($status_index == 'r'){
                    $this->sendMail($id,2);
                }
                //Si el estado es aceptado, se envía correo con el tipo de mensaje 3
                else if($status_index == 'a'){
                    $this->sendMail($id,3);
                }
                $this->Flash->success(__('Se ha cambiado el estado de la solicitud correctamente'));
                return $this->redirect(['action' => 'index']);
                
            }
        }
        $this->set('load_final_review', $load_final_review);
        $this->set(compact('data_stage_completed'));
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

    //Método para recuperar los requisitos que no fueron cumplidos por el estudiante
    //Recibe el id de la solicitud
	public function reprovedMessage($id)
	{
		$s = 'r'; //Es el valor que tienen los requisitos rechazados
		$in = '0'; //Para indicar que no sean por inopia
		$requisitos = $this->Requests->getRequirements($id,$s,$in); //Llama al método que está en el modelo
		$lista = ' '; //Inicializa la lista de los requisitos rechazados
		foreach($requisitos as $r) //Aquí se van concatenando los requisitos recuperados
		{
			$lista .= '
			' . $r['description'];
		}
		return $lista; //Se devuelve la lista de requisitos rechazados del estudiante
	}

    //Método para enviar correo electrónico al estudiante, dando algún aviso.
    //Recibe el id de la solicitud y un estado para indicar si es no elegible, aceptado o rechazado.
    public function sendMail($id,$estado)
    {
        //Aquí se obtienen datos de la solicitud, nombre de profesor, curso, grupo y nombre de estudiante, 
        // necesarios para el correo
        $request = $this->Requests->get($id);
        $estudiante = $this->Requests->getStudentInfo($request['student_id']);
        $clase = $this->Requests->getClass($request['course_id'], $request['class_number']);
        $prof = $this->Requests->getTeacher($request['course_id'], $request['class_number'], $request['class_semester'], $request['class_year']);
        $profesor = $prof[0]['name'];
        $curso = $clase[0]['name'];
        $grupo = $request['class_number'];
		$mail = $estudiante[0]['email_personal'];
        $name = $estudiante[0]['name'] . " " . $estudiante[0]['lastname1'] . " " . $estudiante[0]['lastname2'];
        
        //Se crea una nueva instancia de correo de cakephp
    	$email = new Email();
		$email->transport('mailjet'); //Se debe cambiar 'mailjet' por el nombre de transporte que se puso en config/app.php

        //En todos los mensajes se debe cambiar la parte "correo de contacto" por el correo utilizado para atender dudas con respecto al tema de solicitudes de horas

        //Indica que si el estado es 1, se debe enviar mensaje de estudiante no elegible.
        if($estado == 1){
		$text = 'Estudiante ' . $name . ' :
		Por este medio se le comunica que su solicitud del concurso fue RECHAZADA debido a que no cumplió el(los) siguiente(s) requisito(s):';
		$lista = $this->reprovedMessage($id);
		$text .= ' 
        ' . $lista;
        $text .= '
        Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o "correo de contacto"';
        }

        // Si el estado es 2, se debe enviar mensaje de estudiante rechazado.
        if($estado == 2){
		$text = 'Estudiante ' . $name . ' :
		Por este medio se le comunica que su solicitud del concurso no fue Aceptada por el(la) profesor(a) ' . $profesor .
        ' en el curso ' . $curso . ' y grupo ' . $grupo . '. ' . 'Sin embargo, usted se mantiene como Elegible y puede participar en la próxima ronda.
        
        Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o "correo de contacto".';
        }

        //Si el estado es 3, se debe enviar mensaje de estudiante aceptado.
        if($estado == 3){
		$text = 'Estimado Estudiante ' . $name . ' :
		Su solicitud del concurso al curso con el(la) profesor(a) ' . $profesor . ', curso ' . $curso .  ' y grupo' . $grupo . ', ' . 
        'fue ACEPTADA.
        
        Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o "correo de contacto"';

        //Se envía el correo.
        }
        try {
            $res = $email->from('estivenalg@gmail.com') // Se debe cambiar este correo por el que se usa en config/app.php
                  ->to($mail)
                  ->subject('Resultado del concurso de asistencia')                  
                  ->send($text);

        } catch (Exception $e) {

            echo 'Exception : ',  $e->getMessage(), "\n";

         }
    }

}
