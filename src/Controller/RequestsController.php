<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;

/**
 * Requests Controller
 *
 * @property \App\Model\Table\RequestsTable $Requests
 *
 * @method \App\Model\Entity\Request[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequestsController extends AppController
{
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        $this->set('active_menu', 'MenubarSolicitudes');

    }

    /**
     * Devuelve verdadero si el usuario tiene permiso para ingresar al view o print.
     *
     * @param String $user
     * @return boolean Verdadero si el usuario tiene permiso para ingresar al view o print, falso si no
     */
    public function isAuthorized($user)
    {

        if (in_array($this->request->getParam('action'), ['view', 'print'])) {

            $request_id = (int) $this->request->getParam('pass.0');

            if ($user['role_id'] === 'Estudiante') {
                // Un estudiante puede ver sus propias solicitudes y nada más

                return $this->Requests->isOwnedBy($request_id, $user['identification_number']);

            } elseif ($user['role_id'] === 'Profesor') {
                // Un profesor puede ver solicitudes de los cursos que imparte

                return $this->Requests->isTaughtBy($request_id, $user['identification_number']);
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $table = $this->loadModel('InfoRequests');
        //$rounds = $this->loadModel('Rounds');
        $roundData = $this->viewVars['roundData'];
        $rol_usuario = $this->Auth->user('role_id');
        $id_usuario = $this->Auth->user('identification_number');
        //$ronda_actual = $rounds->getStartActualRound();
        $ronda_actual = $roundData["start_date"];

        // FIXME: Está mal usar consultas a la base de datos en los controladores
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
     * Consultar una solicitud. Muestra el detalle de la solicitud consultada
     * Los datos se presentan en un formato de tabla.
     *
     * @param string|null $id Número o id de la solicitud.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $backLocation = 'index', $backController = 'requests')
    {

        //Se le dice a que vista debe regresar al precionar atras. Por defecto al index
        $this->set('backLocation', $backLocation);
        $this->set('backController', $backController);

        //Se obtiene la fecha de fin de la ronda actual
        $rounds_c = new RoundsController;
        //$rounds = $this->loadModel('Rounds');
        $roundData = $this->viewVars['roundData'];
        //$fechaFin = $rounds_c->mirrorDate($rounds->getEndActualRound());
        $fechaFin = $rounds_c->mirrorDate($roundData['end_date']);
        

        $request = $this->Requests->getAllRequestInfo($id);

        $this->set('request', $request);
        $this->set('fecha', $fechaFin);
        $this->set('yc', $this->getRequest()->getSession()->read('created_request'));
        
        $this->getRequest()->getSession()->write('created_request', 0);
    }

    public function updateMessageVariable($newValue)
    {
        $this->getRequest()->getSession()->write('created_request', $newValue);
    }

    /**
     * Muestra una solicitud en formato de impresión.
     *
     * Esta acción es casi idéntica a la accion view, pero
     * cambia el layout de la vista. Sustituye las
     * barras de navegación por el encabezado y pie de
     * página de la boleta de asistencia. La vista en sí
     * tiene el mismo formato que la boleta de asistencia
     * que se debe presentar en secretaría.
     */
    function print($id = null) {
        
        $this->viewBuilder()->setLayout('request');

        $request = $this->Requests->getAllRequestInfo($id);

        $this->set('request', $request);
    }

    public function get_round_start_date()
    {
        $start = date('2018-10-20');
        return $start;
    }

    public function get_student_id()
    {
        $student_id = "402220000";

        // return $student_id;

        return $this->Auth->user('identification_number'); //Este es el que en realidad hay que devolver
    }

    //Solicita a la controladora de rondas la información de la ronda actual
    public function get_round()
    {
        $rounds_c = new RoundsController;
        return $rounds_c->get_actual_round(date('y-m-d')); //
    }

    //Solicita a la controladora de usuarios la información del usuario actual
    public function getStudentInfo($id)
    {
        $users_c = new UsersController;
        return $users_c->getStudentInfo($id); //
    }

    public function get_semester()
    {
        //Pedir get_round y luego sacar el atributo

        return "1";
    }

	/**
     * @author Esteban Rojas Solís <esteban201483@gmail.com>
     * 
		Esta funcion Permite controla la lógica para agregar solicitud
     */
    public function add()
    {
        if ($this->Auth->user('role_id') === 'Estudiante') {
            $this->set('active_menu', 'MenubarEstSolicitar');
        } else {
            $this->set('active_menu', 'MenubarSolicitudes');
        }

        /***** Nathan González *****/
        // Si no se está en ronda de admisión de solicitudes no permite entrar a la vista ni por URL
        if( $this->loadmodel('Rounds')->between() == false )
            return $this->redirect(['controller' => 'Mainpage', 'action' => 'index']);
        /***** Nathan González *****/

        $request = $this->Requests->newEntity();
        $roundData = $this->viewVars['roundData'];

        if ($this->request->is('post')) {

            $request = $this->Requests->patchEntity($request, $this->request->getData());

            $RequestsTable = $this->loadmodel('Requests');
            //$round almacena datos originales

            //Modifica los datos que debe extraer de las otras controladoras o que van por defecto:
            $request->set('status', 'p'); //Toda solicitud esta pendiente
            //$request->set('round_start', $this->get_round_start_date()); //obtiene llave de ronda

            $request->set('student_id', $this->get_student_id()); //obtiene el id del estudiante logueado

            //Se trae la ronda actusl


            //---------------------------------
            //if($ronda[0]['semester'] == 'II')
            if ($roundData['semester'] == 'II') {
                $nuevoSemestre = "2";
            } else {
                $nuevoSemestre = "1";
            }

            //$nuevoAño = $ronda[0]['year'];
            $nuevoAño = $roundData['year'];
            //$request->set('round_start', $ronda[0]['start_date']);
            $request->set('round_start', $roundData['start_date']);
            //---------------------------------

            $request->set('class_year', $nuevoAño); //obtiene el año actual de la solicitud
            $request->set('class_semester', $nuevoSemestre); //obtiene el semestre actual de la solicitud
            $request->set('reception_date', date('Y-m-d')); //obtiene fecha actual

            //Si no se selecciono ningun tipo de hora
            if (($request->get('wants_student_hours') || $request->get('wants_assistant_hours')) == false) {
                //
                //$request->set('wants_assistant_hours',true);
            } else {
                //debug($request);
                $nuevoCurso = substr($request['course_id'], 0, 6);
                $nuevoGrupo = substr($request['class_number'], 0, 1);
                $nuevoId = $request['student_id'];
                $nuevaRonda = $request['round_start'];

				if ($this->Requests->save($request)) {
					$this->Flash->success(__('Se agregó la solicitud correctamente. Se envió un mensaje de confirmación a su correo electrónico.'));
					//Se envía correo con mensaje al estudiante de que la solicitud fue enviada.
					$this->sendMail($request['id'],5);
				   // return $this->redirect(['action' => 'index']);
					
					
					//Obtiene el id de la nueva solicitud
					$id = $this->Requests->getNewRequest($nuevoCurso,$nuevoGrupo,$nuevoId,$nuevaRonda);
					
					//Declara la variable para indicarle al view que debe desplegar el mensaje de la impresión de esta solicitud
					$this->getRequest()->getSession()->write('created_request',1);

                    //Obtiene el id de la nueva solicitud
                    $id = $this->Requests->getNewRequest($nuevoCurso, $nuevoGrupo, $nuevoId, $nuevaRonda);

                    //Declara la variable para indicarle al view que debe desplegar el mensaje de la impresión de esta solicitud
                    $this->getRequest()->getSession()->write('created_request', 1);

                    return $this->redirect(array("controller" => "Requests",
                        "action" => "view", $id[0]['id']));
                }
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
        //$ronda = $this->get_round();

        //debug($ronda);
        //---------------------------------
        //if($ronda[0]['semester'] == 'II')
        if ($roundData['semester'] == 'II') {
            $semestre = "2";
        } else {
            $semestre = "1";
        }

        $año = $roundData['year'];
        //---------------------------------

        //Modifica las clases para dejar los datos requeridos de curso y grupo
        //$tuplas = $classes->execute();
        $course = array();
        $teacher;

        $classes;
        $grupos = $this->Requests->getGroups($this->get_student_id(), $semestre, $año);

		if($grupos == null)
		{
			$this->Flash->error(__('Error: No hay Grupos Disponibles'));
			return $this->redirect(['controller' => 'Mainpage', 'action' => 'index']);
		}	
		
		
        $aux;

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
        $c2[0] = "Seleccione un Curso";
        $c3[0] = "Seleccione un Curso";
        foreach ($aux as $c) //Recorre cada tupla de curso
        {
            //Dado que la primer opcion ya tiene un valor por default, los campos deben modifcar el valor proximo a i
            $c2[$i + 1] = $c['code']; //Almacena el codigo de curso
            $nombre[$i + 1] = $c['name']; //Almacena el nombre del curso

            //autor: Daniel Marín
            $c3[$i + 1] = $c['code'] . ' - ' . $c['name']; //Almacena el codigo junto al nombre del curso

            $i = $i + 1;
        }

        //Funcionalidad Solicitada: Agregar datos del usuario

        //Obtiene el carnet del estudiante actual.
        $estudiante = $this->get_student_id();

        //En base al carnet del estudiante actual, se trae la tupla de usuario respectiva a ese estudiante
        $estudiante = $this->getStudentInfo($estudiante);
        //Las keys de los arrays deben corresponder al nombre del campo de la tabla que almacene los usuarios
        $nombreEstudiante = $estudiante[0]['name'] . " " . $estudiante[0]['lastname1'] . " " . $estudiante[0]['lastname2'];
        $correo = $estudiante[0]['email_personal'];
        $telefono = $estudiante[0]['phone'];
        $carnet = $estudiante[0]['carne'];
        $cedula = $estudiante[0]['identification_number'];

        $this->set(compact('request', 'c2', 'c3', 'students', 'class', 'course', 'teacher', 'nombre', 'id', 'nombreEstudiante', 'carnet', 'correo', 'telefono', 'cedula', 'año', 'semestre', 'profesor'));
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

    /**
     * Se encarga de la logica de la revision de solicitudes. Se divide en la cuatro etapas de la revisión.
     *
     * @author Kevin Jiménez <kevinja9608@gmail.com> 
     * @param String $id Identificador de la solicitud
     * @return void
     */
    public function review($id = null)
    {
        $this->set('id', $id);
        $this->loadModel('ApprovedRequests');
        $this->loadModel('CanceledRequests');
        $roundData = $this->viewVars['roundData'];

        //--------------------------------------------------------------------------
        // Controlador de roles necesario para verificar que hayan permisos
        $role_c = new RolesController;
        $this->loadModel('Requirements');
        $this->loadModel('RequestsRequirements');

        //--------------------------------------------------------------------------
        // Modulo y acción requeridos para verificar permisos
        $action = 'review';
        $module = 'Requests';

        //--------------------------------------------------------------------------
        // Datos del usuario y solicitud que se encuentra revisando
        $user = $this->Auth->user();
        $request = $this->Requests->get($id);

        //--------------------------------------------------------------------------
        // Varibles para indicar que cargar a la vista
        $load_requirements_review = false;
        $load_preliminar_review = false;
        $load_final_review = false;

        // All of the variables added in this section are ment to be for
        // the preliminar review of each requests.
        $default_index = null;

        //--------------------------------------------------------------------------
        $load_final_review = false;

        // Etapa de la solicitud
        $request_stage = $request->stage;
        $student_c = new StudentsController;
        $request_ponderado = $student_c->getAverage($request->student_id);
        $this->set(compact('request_stage', 'request_ponderado'));

        $anulada = false;
        //--------------------------------------------------------------------------
        // Kevin
        // Etapa Revision de requisitos
        // Se le indica a la vista que cargue la parte de revisión de requisitos
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Requirements') && $request_stage > 0) {
            // Valeria
            if($request->status === 'x'){
                // la solicitud esta anulada
                $anulada = true;
                $justificacion = $this->CanceledRequests->getJustification($id);
                $this->set(compact('anulada', 'justificacion'));
                //termina Valeria
            }else{
                // Se le indica a la vista que debe cargar la parte de revision de requisitos
                $load_requirements_review = true;
        
                // Se cargan a la vista los requisitos de esta solicitud en especifico
                $requirements = $this->Requirements->getRequestRequirements($id);
                $requirements['stage'] = $request->stage;
                $this->set(compact('requirements', 'anulada'));
            }
        }
        $this->set(compact('load_requirements_review'));

        //Revisión preliminar
        //EMPIEZA JORGE
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Preliminary') && $request_stage > 1) {
            $load_preliminar_review = true; // $load_review_requirements
            $default_index = $this->Requests->getStatus($id);

            $requirementList = $this->Requirements->getRequestRequirements($id);
            //Se asume que puede aplicar para ambos
            $hourType = 'a';
            for ($index = 0; $index < sizeof($requirementList['Asistente']); $index++){
                if($requirementList['Asistente'][$index]['state'] == 'r'){
                    //Si se rechaza algun requerimiento de asistente, se asume que puede aplicar para estudiante
                    $hourType = 'e';
                }
            }
            if($hourType == 'a' && $requirementList['Asistente'][1]['acepted_inopia']){
                $hourType = 'c';
            }

            //Si se cumplen los requisitos para horas asistente, no es necesario verificar si cumple los de horas estudiante
            if($hourType != 'a'){
                for ($index = 0; $index < sizeof($requirementList['Estudiante']); $index++){
                    if($requirementList['Estudiante'][$index]['state'] == 'r'){
                        //Si se rechaza algun requerimiento de estudiante, no puede aplicar para ningun tipo de horas
                        $hourType = 'n';
                    }
                }
            }

            // c: inopia solo en asistente
            // b: inopia en asistente y en estudiante
            // i: inopia solo en estudiante(requisito obligatorio en asistente rechazado)
            if($requirementList['Estudiante'][1]['acepted_inopia']){
                if($hourType == 'c'){
                    $hourType = 'b';
                }else if($hourType == 'e'){
                    $hourType = 'i';
                }
            }
            

            //Si ya no puede aplicar para ninguna, no es necesario verificar los requisitos generales
            if($hourType != 'n'){
                for ($index = 0; $index < sizeof($requirementList['Ambos']); $index++){
                    if($requirementList['Ambos'][$index]['state'] == 'r'){
                        //Si se rechaza alguno de estos requerimientos generales, no puede aplicar para horas
                        $hourType = 'n';
                    }
                }
            }

            if($hourType != 'n'){
                $hasInopia = $this->Requests->isInopia($id);
                if($hasInopia){
                    $preeliminarOptions = array("p" => "-No Clasificado-", "i" =>"Elegible por inopia", "n" => "No elegible", "x" => "Anulado");
                }else{
                    $preeliminarOptions = array("p" => "-No Clasificado-", "e" =>"Elegible", "n" => "No elegible", "x" => "Anulado");
                }
            }else{
                $preeliminarOptions = array("p" => "-No Clasificado-", "n" => "No elegible", "x" => "Anulado");
            }

        }

        // Kevin y Daniel M
        //Revisión final
        if ($role_c->is_Authorized($user['role_id'], $module, $action . 'Final') && $request_stage > 2 && ($default_index == 'e' || $default_index == 'i' || $default_index == 'a' || $default_index == 'r' || $default_index == 'c')) {
            $load_final_review = true;
            $default_indexf = 0;
            $inopia = 0;
            if ($default_index == 'i' || $default_index == 'c') {
                $inopia = 1;
            }

            if ($default_index == 'a' || $default_index == 'c') {
                $default_indexf = 1;
            } else if ($default_index == 'r') {
                $default_indexf = 2;
            }

            $this->setMaxHours($id, $request->student_id,'');
            $this->set('default_indexf', $default_indexf);

        }

        //--------------------------------------------------------------------------
        //Datos de la solicitud
		//Empieza Esteban
        //Se trae los datos de la solicitud
        $request = $this->Requests->get($id);
        $user = $this->Requests->getStudentInfo($request['student_id']);
        $user = $user[0]; //Agarra la unica tupla
        $class = $this->Requests->getClass($request['course_id'], $request['class_number']);
        $class = $class[0];
        $professor = $this->Requests->getTeacher($request['course_id'], $request['class_number'], $request['class_semester'], $request['class_year']);
        $professor = $professor[0];
        $this->set(compact('request', 'user', 'class', 'professor', 'preeliminarOptions'));

        //--------------------------------------------------------------------------
        // Sending the value of the boolean that says whether the preliminar review
        // should appears or not and the default index.
        $this->set('load_preliminar_review', $load_preliminar_review);
        $this->set('default_index', $default_index);
        //--------------------------------------------------------------------------
        //Manda los parametros a la revision

        // Manejo de los requests
		//Autor: Esteban
        if ($this->request->is(['patch', 'post', 'put'])) {
            // Se guarda los datos del request
            $data = $this->request->getData();
            $requirements_review_completed = true;

            //Entra en este if si el boton oprimido fue el de cambiar el tipo de horas
            if (array_key_exists('AceptarCambioHoras', $data)) {

                //Solo cambia las horas si se asigna al menos un tipo de hora
                if ($data['modify_hours_ha'] != 0 || $data['modify_hours_he'] != 0) {
                    $this->Requests->updateRequestHours($data['reqId'], $data['modify_hours_ha'], $data['modify_hours_he']);
                    $this->Flash->success(__('Se han modificado las horas correctamente.'));
                } else {
                    $this->Flash->error(__('Error: No se logro modificar las horas'));
                }

            }
			//Termina Esteban
            // Entra en este if si el boton oprimido fue el de revision de requisitos
            if (array_key_exists('AceptarRequisitos', $data)) {

                // Actualizar el estado de los requisitos de estudiante
                for ($i = 0; $i < count($requirements['Estudiante']); $i++) {
                    $requirement_number = intval($requirements['Estudiante'][$i]['requirement_number']);
                    $student_requirement = $this->RequestsRequirements->newEntity();
                    $student_requirement->request_id = intval($id);
                    $student_requirement->requirement_number = $requirement_number;
                    $student_requirement->state = $data['requirement_' . $requirement_number] == 'rejected' ? 'r' : 'a';

                    // Guarda si fue aprovado por inopia
                    if ($requirements['Estudiante'][$i]['type'] == 'Opcional' && $data['requirement_' . $requirement_number] == 'inopia') {
                        $student_requirement->acepted_inopia = 1;
                    } else {
                        $student_requirement->acepted_inopia = 0;
                    }

                    // Verifica que todos los requisitos hayan sido guardados correctamente
                    if (!$this->RequestsRequirements->save($student_requirement)) {
                        $requirements_review_completed = false;
                        return;
                    }
                }

                // Actualizar el estado de los requisitos asistente
                for ($i = 0; $i < count($requirements['Asistente']); $i++) {
                    $requirement_number = intval($requirements['Asistente'][$i]['requirement_number']);
                    $student_requirement = $this->RequestsRequirements->newEntity();
                    $student_requirement->request_id = intval($id);
                    $student_requirement->requirement_number = $requirement_number;
                    $student_requirement->state = $data['requirement_' . $requirement_number] == 'rejected' ? 'r' : 'a';

                    // Guarda si fue aprovado por inopia
                    if ($requirements['Asistente'][$i]['type'] == 'Opcional' && $data['requirement_' . $requirement_number] == 'inopia') {
                        $student_requirement->acepted_inopia = 1;
                    } else {
                        $student_requirement->acepted_inopia = 0;
                    }

                    // Verifica que todos los requisitos hayan sido guardados correctamente
                    if (!$this->RequestsRequirements->save($student_requirement)) {
                        $requirements_review_completed = false;
                        return;
                    }
                }

                // Actualizar el estado de los requisitos generales
                for ($i = 0; $i < count($requirements['Ambos']); $i++) {
                    $requirement_number = intval($requirements['Ambos'][$i]['requirement_number']);
                    $student_requirement = $this->RequestsRequirements->newEntity();
                    $student_requirement->request_id = intval($id);
                    $student_requirement->requirement_number = $requirement_number;
                    $student_requirement->state = $data['requirement_' . $requirement_number] == 'rejected' ? 'r' : 'a';

                    // Guarda si fue aprovado por inopia
                    if ($requirements['Ambos'][$i]['type'] == 'Opcional' && $data['requirement_' . $requirement_number] == 'inopia') {
                        $student_requirement->acepted_inopia = 1;
                    } else {
                        $student_requirement->acepted_inopia = 0;
                    }

                    // Verifica que todos los requisitos hayan sido guardados correctamente
                    if (!$this->RequestsRequirements->save($student_requirement)) {
                        $requirements_review_completed = false;
                        return;
                    }
                }


                // Se muestra un mensaje informando si la transacción se completo o no. Tambien se actualiza en
                // etapa se encuentra la solicitud
                $request_reviewed = $this->Requests->get($id);
                $request_reviewed->stage = 2;
                
                $student_c = new StudentsController;
                if ($requirements_review_completed && $this->Requests->save($request_reviewed) && $student_c->saveAverage($request->student_id, floatval($data['ponderado']))) {

                    $this->Requests->updateRequestStatus($id, 'p'); //llama al metodo para actualizar el estado
                    (new RoundsController)->updateGlobal();// actualiza los datos de rondas
                    $this->Flash->success(__('Se ha guardado la revision de requerimientos.'));
                } else {
                    $this->Flash->error(__('No se ha logrado guardar la revision de requerimientos.'));
                }

            }
            //EMPIEZA JOE

            //--------------------------------------------------------------------------
            // When the user says 'aceptar', we only have to change a request status
            // if the loaded view was the preliminar one and not the last one
            if (array_key_exists('AceptarPreliminar', $data)) {
                //--------------------------------------------------------------------------
                $status_new_val = $data['Clasificación'];

                //--------------------------------------------------------------------------
                // Comunication with other controllers
                $requirementsController = new RequirementsController();
                //--------------------------------------------------------------------------
                // This counts the  amount of mandatory requirements in the reqirements table
                // and the amount of them in this request

                //Empieza JORGE

                //Se guarda en la base para que tipo de horas puede aplicar
                $this->Requests->setRequestScope($id, $hourType);
                //Si es posible aplicar para horas, actualiza los estados necesarios
                if ($hourType != 'n' || $status_new_val == 'x') {
                    $this->Requests->updateRequestStatus($request['id'], $status_new_val); //llama al metodo para actualizar el estado
                    (new RoundsController)->updateGlobal();// actualiza los datos de rondas
                    $this->Flash->success(__('Se ha cambiado el estado de la solicitud correctamente'));
                    $request_reviewed = $this->Requests->get($id);
                    $request_reviewed->stage = 3;
                    $this->Requests->save($request_reviewed);
                }
                //TERMINA JORGE
                //Si el estado es no aceptado, se envía el tipo de mensaje 1
                if ($status_new_val == 'n') {
                    $this->sendMail($request['id'], 1);
                }
                return $this->redirect(['action' => 'index']);
            }
            //--------------------------------------------------------------------------
            // Inicia Daniel Marín
            if (array_key_exists('AceptarFin', $data)) {
                $status_index = $data['End-Classification'];
                switch ($status_index) {
                    case 1:
                        if ($inopia) {
                            $status_new_val = 'c';
                        } else {
                            $status_new_val = 'a';
                        }

                        break;
                    case 2:
                        $status_new_val = 'r';
                        break;
                }
                if ($status_new_val == 'a') {
                    $this->Requests->approveRequest($id, $data["type"], $data["hours"]);
                    $this->Requests->updateRequestStatus($id, $status_new_val);
                    $this->sendMail($id, 3);
                } else if ($status_new_val == 'c') {
                    $this->Requests->approveRequest($id, $data["type"], $data["hours"]);
                    $this->Requests->updateRequestStatus($id, $status_new_val);
                    $this->sendMail($id, 4);
                } else if ($status_new_val == 'r') {
                    $this->Requests->updateRequestStatus($id, $status_new_val);
                    $this->sendMail($id, 2);
                }
                (new RoundsController)->updateGlobal();
                $this->Flash->success(__('Se ha cambiado el estado de la solicitud correctamente'));
                return $this->redirect(['action' => 'index']);
            }
            //termina Daniel Marín

            // Se recarga la vista para que se actualicen los estados de revision
            $this->redirect('/requests/review/' . $id);
        }
        $this->set('load_final_review', $load_final_review);
    }

    /**
     * Metodo que obtiene los requisitos no cumplidos por el estudiante en la solicitud.
     * 
     * @author Estiven Alfaro <estivenalg@gmail.com>
     * @param $id que es el identificador de la solicitud
     * @return string con todos los requisitos no cumplidos.
     */
    public function reprovedMessage($id)
    {
        $s = 'r'; //Es el valor que tienen los requisitos rechazados
        $in = '0'; //Para indicar que no sean por inopia
        $requirements = $this->Requests->getRequirements($id, $s, $in); //Llama al método que está en el modelo
        $list = ' '; //Inicializa la lista de los requisitos rechazados
        foreach ($requirements as $r) //Aquí se van concatenando los requisitos recuperados
        {
            $list .= "*" . $r['description'] . "\v \r \r";
        }
        return $list; //Se devuelve la lista de requisitos rechazados del estudiante
    }

    /**
     * Metodo que envia correos a los estudiantes.
     * 
     * @author Estiven Alfaro <estivenalg@gmail.com>
     * @param int $id que es el identificador de la solicitud
     * @param int $state que es el tipo de mensaje que se 
     * debe enviar, dependiendo del estado de la solicitud
     * @return void.
     */
    public function sendMail($id, $state)
    {
        //Aquí se obtienen datos de la solicitud, nombre de profesor, curso, grupo y nombre de estudiante,
        // necesarios para el correo
        $request = $this->Requests->get($id);
        $student = $this->Requests->getStudentInfo($request['student_id']);
        $class = $this->Requests->getClass($request['course_id'], $request['class_number']);
        $prof = $this->Requests->getTeacher($request['course_id'], $request['class_number'], $request['class_semester'], $request['class_year']);
        $professor = $prof[0]['name'];
        $course = $class[0]['name'];
        $group = $request['class_number'];
        $mail = $student[0]['email_personal'];
        $name = $student[0]['name'] . " " . $student[0]['lastname1'] . " " . $student[0]['lastname2'];

        //Se crea una nueva instancia de correo de cakephp
        $email = new Email();
        $email->setTransport('outlook'); //Se debe cambiar 'mailjet' por el nombre de transporte que se puso en config/app.php

        //En todos los mensajes se debe cambiar la parte "correo de contacto" por el correo utilizado para atender dudas con respecto al tema de solicitudes de horas

        //Indica que si el estado es 1, se debe enviar mensaje de estudiante no elegible.
        if ($state == 1) {
            $text = "Estudiante $name:" . "\v \r \v \r" .
                "Por este medio se le comunica que su solicitud de horas no fue aceptada debido a que no cumplió con el(los) siguiente(s) requisito(s):" . "\v \r \v \r";
            $list = $this->reprovedMessage($id);
            $text .= $list;
            $text .= "\r \r" . "Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o 'correo de contacto'.";
        }

        // Si el estado es 2, se debe enviar mensaje de estudiante rechazado.
        if ($state == 2) {
            $text = "Estudiante $name:" . "\v \r \v \r" .
                "Por este medio se le comunica que usted no fue seleccionado por el(la) profesor(a) $professor en el curso $course y grupo $group. Sin embargo, usted se mantiene como elegible y puede participar en la próxima ronda." . "\v \r \v \r" .
                "Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o 'correo de contacto'.";
        }

        //Si el estado es 3, se debe enviar mensaje de estudiante aceptado.
        if ($state == 3) {
            $text = "Estimado estudiante $name:" . "\v \r \v \r" .
                "Su solicitud de horas al curso con el(la) profesor(a) $professor, curso $course y grupo $group, fue aceptada." . "\v \r \v \r" .
                "Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o 'correo de contacto'.";
        }

        //Si el estado es 4, se debe enviar mensaje de estudiante aceptado por inopia.
        if ($state == 4) {
            $text = "Estimado estudiante $name:" . "\v \r \v \r" .
                "Su solicitud de horas al curso con el(la) profesor(a) $professor, curso $course y grupo $group, fue aceptada por inopia." . "\v \r \v \r" .
                "Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o 'correo de contacto'.";
        }

        if ($state == 5) {
            $text = "Estimado estudiante $name:" . "\v \r \v \r" .
                "Su solicitud de horas al curso con el(la) profesor(a) $professor, curso $course y grupo $group, fue enviada con éxito." . "\v \r \v \r" .
                "Por favor no contestar este correo. Cualquier consulta comunicarse con la secretaría de la ECCI al 2511-0000 o 'correo de contacto'.";
            $email->setSubject('Concurso de asistencia ECCI');
        }
        else{
            $email->setSubject('Resultado concurso de asistencia ECCI');
        }

        //Se envía el correo.
        try {
            $res = $email->setFrom('asistenciasecciucr@outlook.com') // Se debe cambiar este correo por el que se usa en config/app.php
                  ->setTo($mail)                 
                  ->send($text);

        } catch (Exception $e) {

            echo 'Exception : ', $e->getMessage(), "\n";

        }
    }

    //Empieza jorge

    public function cancelRequest($id, $just){
        $cancelTable=$this->loadmodel('CanceledRequests');
        $result = $cancelTable->cancelRequest($id, $just);
        $request = $this->Requests->get($id);

        if($result){
            $request->stage = 1;
            $request->status = 'x';

            $this->Requests->save($request);
            $this->Flash->success(__('Se anuló la solicitud correctamente.'));
        }else{
            $this->Flash->error(__('Error: no se pudo anular la solicitud.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
	
	
	public function getApprovedRequestsByRound($llave_ronda)
	{
		return $this->Requests->getApprovedRequestsByRound($llave_ronda);
	}
	
	public function getRequestsByRoundStatus($llave_ronda,$estado)
	{
		return $this->Requests->getRequestsByRoundStatus($llave_ronda, $estado);
	}
	
	public function getAllRequestsByRound($llave_ronda)
	{
		return $this->Requests->getAllRequestsByRound($llave_ronda);
	}

    public function setMaxHours($request_id, $student_id, $var_id){
        $request = $this->Requests->get($request_id);
        $roundData = $this->viewVars['roundData'];
        /*
        * Kevin
        * Dependiendo de la fases anteriores, se podran asignar horas estudiante o asistente.
        * Con la variable $hourTypeAsignable, en la vista podemos verificar que tipo de hora se le debe
        * permitir al usuario asignar.
        *
        * Si $hourTypeAsignable es igual a n, significa que el estudiante no es eligible, por lo
        * tanto no se le debe asignar ningun tipo de hora.
        * Si $hourTypeAsignable es igual a e, significa que al estudiante solo se le pueden asignar horas
        * estudiante.
        * Si $hourTypeAsignable es igual a a, significa que al estudiante se le pueden asignar horas estudiante o asistente.
        *
        * No hay un estado en el que solo se le puedan asignar horas asistente, ya que si cumple con los requisitos de estas,
        * tambien cumple con los de estudiante.
        */
        $hourTypeAsignableb = $this->Requests->getScope($request_id);

        /*
        * Kevin
        * Se cargan las horas del estudiante ya asignadas, para verificar que no se le asignen una cantidad mayor a
        * las horas definidas por el reglamento.
        */
        $student_asigned_hours = $this->ApprovedRequests->getAsignedHours($student_id);
        $student_asigned_hours_request = $this->ApprovedRequests->getThisRequestAsignedHours($request_id);


        /*
        * Kevin
        * Se crea un array con la maxima cantidad de horas de cada tipo que se le pueden asignar a un estudiante.
        * 
        * Primero se calcula la cantidad de horas estudiante maximas que se le pueden asignar al estudiante. Se hace esto
        * ya que el maximo de horas de este tipo es 12, por lo que con esto se sabe que nunca se le podra asignar más de 12.
        * Luego, se calcula la cantidad total maxima de horas que se pueden asignar. Se hace esto, ya que el estudiante podria tener
        * muchas horas asistente, por lo que debemos tomar esto en cuenta, ya que esto limita la cantidad de horas asignables.
        * Por ultimo, se verifica que el sistema tenga horas suficientes, en caso que no, el maximo sera la cantidad de horas,
        * que le quedan al sistema.
        * 
        * Despues de realizar esto, se debe tomar en cuenta las horas ya asignadas en la misma solictud. Por lo que estas se suman al 
        * maximo ya que estas ya estan asignadas. Esto se hace asi, ya que si se cambia la cantidad de horas, se le "cae encima" al 
        * dato anterior, por lo que al menos debe poder asignar las que ya tiene.
        * 
        * Siglas:
        *  * HEE = Horas estudiante de la ECCI
        *  * HED = Horas estudiante de DOCENCIA
        *  * HAE = Horas asistente de la ECCI 
        */ 
        $totalAsignedHours = $student_asigned_hours['HAE'] + $student_asigned_hours['HED'] + $student_asigned_hours['HEE'] + $request->another_student_hours + $request->another_assistant_hours ;
        $totalAsignedStudentHours =  $student_asigned_hours['HED'] + $student_asigned_hours['HEE'] + $request->another_student_hours;
        $student_max_hours['HEE'] = min(
                                        12 - $totalAsignedStudentHours,
                                        20 - $totalAsignedHours,
                                        $roundData['total_student_hours'] - $roundData['actual_student_hours']
                                    ) + (array_key_exists('HEE', $student_asigned_hours_request) ? $student_asigned_hours_request['HEE'] : 0);

                                    
        $student_max_hours['HED'] = min(
                                        12 - $totalAsignedStudentHours,
                                        20 - $totalAsignedHours, 
                                        $roundData['total_student_hours'] - $roundData['actual_student_hours']
                                    ) + (array_key_exists('HED', $student_asigned_hours_request) ? $student_asigned_hours_request['HED']:0);
                                    
        $student_max_hours['HAE'] = min(
                                        20 - $totalAsignedHours, 
                                        $roundData['total_assistant_hours'] - $roundData['actual_assistant_hours']
                                    ) + (array_key_exists('HAE', $student_asigned_hours_request) ? $student_asigned_hours_request['HAE']:0);      
        
        $hasAsignedHours = false;   
        if($student_asigned_hours['HED'] + $student_asigned_hours['HEE'] + $student_asigned_hours['HAE']){           
            $hasAsignedHours =  true;
        }

        $this->set('student_asigned_hours_request'.$var_id, $student_asigned_hours_request);
        $this->set('hasAsignedHours'.$var_id, $hasAsignedHours);
        $this->set('student_max_hours'.$var_id, $student_max_hours);
        $this->set('hourTypeAsignableb'.$var_id, $hourTypeAsignableb);

    }

    /**
     * Revisar solicitudes elegible o elegibles por inopia en un índice.
     * 
     * @author Nathan González
     * @return Flash Para informar que la solicitud se reviso con exito.
     */
    public function indexReview(){
        // Carga el modelo de Requests
        $this->loadModel('Requests');
        $this->loadModel('ApprovedRequests');
        
        // Se cargan los valores del índice para una nueva vista
        $requests = $this->Requests->traerElegibles();
        foreach ($requests as $request){
            $r = $this->Requests->get($request[0]);
            $var_name = 'request_'.$request[0];
            $this->set($var_name,$r); 
            $this->setMaxHours($request[0], $r->student_id, '_'.$request[0]);
        }  
        
        $this->set(compact('requests',$requests)); 

        // Si la solicitud fue hecha procede a almacenarla y enviar el correo correspondiente
        if ($this->request->is(['patch', 'post', 'put', 'ajax'])) {

            // Toma los datos de la solicitud
            $data = $this->request->getData();

            /* Si la solicitud es aceptada o aceptada por inopia se almacena el estado, las horas 
             * establecidas y se envía una notificación, caso contrario se guarda el estado y se 
             * envia una notificación
             */
            if( $data['sendStatus'] == 'a' || $data['sendStatus'] == 'i' ){
                if( $data['sendStatus'] == 'a' ) $this->sendMail( $data['sendId'], 3 );
                else $this->sendMail( $data['sendId'], 4) ;

                $this->Requests->approveRequest( $data['sendId'], $data['sendHourType'], $data['sendHour'] );
                $this->Requests->updateRequestStatus( $data['sendId'], $data['sendStatus'] );
            }
            else{
                $this->sendMail( $data['sendId'], 2 );

                $this->Requests->updateRequestStatus( $data['sendId'], $data['sendStatus'] );
            }

            // Se redirecciona para cargar la nueva vista
            $this->redirect(['action' => 'indexReview']);
            (new RoundsController)->updateGlobal();
            // Mensaje informativo de exito
            return $this->Flash->success(__('Se revisó la solicitud correctamente'));
        }

        

    }
}
