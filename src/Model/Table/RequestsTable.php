<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;




/**
 * Requests Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\BelongsTo $Students
 *
 * @method \App\Model\Entity\Request get($primaryKey, $options = [])
 * @method \App\Model\Entity\Request newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Request[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Request|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Request|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Request patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Request[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Request findOrCreate($search, callable $callback = null, $options = [])
 */
class RequestsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Classes', [
            'foreignKey' => ['class_year', 'course_id', 'class_semester', 'class_number'],
            'bindingKey' => ['year', 'course_id', 'semester', 'class_number'],
            'joinType' => 'INNER'
		]);
		
		$this->belongsToMany('Requirements',[
            'foreignKey' => 'request_id',
            'joinType' => 'INNER'
		]);
		
    }
    
    //Funciones auxiliares encargadas de ayudar a los validadores


    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
     
    //Valida que se seleccione un curso valido
    public function validarCurso($check)
    {
        return ($check != "Seleccione un Curso" && $check != "0");
    }
    
    //Valida que se seleccione un grupo valido
    public function validarGrupo($check)
    {
        return ($check != "Seleccione un Grupo");
    }


    public function validationDefault(Validator $validator)
    {           
        //Valida que se seleccione un curso valido
        $validator->add('course_id', [
            'validarCurso' => [
                'rule' => 'validarCurso',
                'provider' => 'table',
                'message' => 'Seleccione un curso'
            ]
        ]);     
        //Valida que se seleccione un grupo valido
        $validator->add('class_number', [
            'validarGrupo' => [
                'rule' => 'validarGrupo',
                'provider' => 'table',
                'message' => 'Seleccione un Grupo'
            ]
        ]);
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->existsIn(['course_id'], 'Courses'));
        //$rules->add($rules->existsIn(['student_id'], 'Students'));

        return $rules;
    }
	
	public function updateRequestHours($id, $ha, $he)
	{
		$connet = ConnectionManager::get('default');
		$connet->execute("update requests set wants_assistant_hours = '$ha', wants_student_hours = '$he' WHERE id = '$id'");
        return 1;

    }

    public function getRequests()
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from requests");
        $result = $result->fetchAll('assoc');
        return $result;
    }

    public function getStudentInfo($student_id)
	{
		$connet = ConnectionManager::get('default');
		      //  $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from Classes c, users u WHERE c.course_id = "+$courseId+" AND c.class_number = "+$classNumber+" AND c.professor_id = u.identification_number");
		$result = $connet->execute("select * from users u, students s where u.identification_number = '$student_id' and u.identification_number = s.user_id");
		$result = $result->fetchAll('assoc');
        return $result;
    }
	
	public function getID()
	{
		$connet = ConnectionManager::get('default');
        $result = $connet->execute("select professor_id from classes;");
        $result = $result->fetchAll('assoc');
        return $result;
    }

    public function getTeachers()
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select CONCAT(name,' ',lastname1) from users where role_id = 'Profesor'");
        $result = $result->fetchAll('assoc');
        return $result;
    }

    public function getTeacher($courseId, $classNumber)
    {
        $connet = ConnectionManager::get('default');
              //  $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from Classes c, users u WHERE c.course_id = "+$courseId+" AND c.class_number = "+$classNumber+" AND c.professor_id = u.identification_number");
        $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from classes c, users u WHERE c.course_id = '$courseId' AND c.class_number = '$classNumber' AND c.professor_id = u.identification_number");
        $result = $result->fetchAll('assoc');
        return $result;

	}
	
	//Obtiene todas las solicitudes pendientes que coincidan con el curso y grupo actual.
	/*
		Nota: No es necesario enviar el semestre y año, ya que todas las solicitudes que no sean de este semestre y año
		van a estar aprobadas o rechazadas.
	*/
	public function getSameRequests($course, $class)
	{
		$connet = ConnectionManager::get('default');
		$result = $connet->execute("Select * from requests where course_id = '$course' and class_number = '$class'and status = 'p'");
		$result = $result->fetchAll('assoc');
        return $result;

    }
    
    //Obtiene los codigos y nombres de los cursos que tengan al menos un grupo que requierade un asistente
    public function getCourses()
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select c.code, c.name from courses c where c.code in (Select course_id from classes where state = 1)");
        $result = $result->fetchAll('assoc');
        return $result;
    }
    
	/**
	* Devuelve todos los cursos y grupos en los que el estudiante no tiene una solicitud de asistencia. Esto permite que el estudiante
	* no solicite más de una vez una asistencia al mismo grupo del mismo curso. Además, impide que el estudiante solicite asistencia a 
	* grupos que ya tienen un asistente.
	* @author Esteban Rojas
	* @param String $id_estudiante Identificación del estudiante
	* @param String $semestre semestre de los grupos a seleccionar
	* @param String $year año de los grupos a seleccionar
	* @return Array con todos los cursos y grupos disponibles para que el estudiante solicite una asistencia
	*/
    public function getGroups($id_estudiante, $semestre, $year)
    {
        $connet = ConnectionManager::get('default');

        $result = $connet->execute("select c.course_id,c.class_number, co.name, concat(u.name,' ',u.lastname1,' ',u.lastname2) 
		as prof from classes c, courses co, users u
        where c.year = '$year' and c.semester = '$semestre' and co.code = c.course_id AND c.state = 1 AND 
		u.identification_number = c.professor_id AND
        concat(c.course_id,c.class_number)  NOT IN(
        select concat(c.course_id,c.class_number) from classes c, requests r 
        where c.course_id = r.course_id and r.class_number = c.class_number and r.status = 'p' and r.student_id = '$id_estudiante')");

        $result = $result->fetchAll('assoc');
        return $result;
    }
    
    //Obtiene la ronda actual: año, semestre, fecha de inicio y fecha final
    public function getActualRound($fechaActual)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from rounds where start_date <= '$fechaActual' AND '$fechaActual'  <= end_date");
        $result = $result->fetchAll('assoc');
        return $result;
    }
    
    //Obtiene toda la información de un usuario según su carnet
    public function getStudent($carnet)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from students s, users u  where s.carne = '$carnet' AND s.user_id = u.identification_number");
        $result = $result->fetchAll('assoc');
        return $result;
    }
	
	//Obtiene el id de la solicitud en base a los datos de dicha solicitud
	public function getNewRequest($curso,$grupo,$cedula,$ronda)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select id from requests where student_id = '$cedula' AND round_start = '$ronda' AND course_id = '$curso' AND class_number = '$grupo' AND status = 'p'  ");
        $result = $result->fetchAll('assoc');
        return $result;
    }
    
    //Obtiene informacion del curso y grupo según el numero de grupo y la sigla del curso
    public function getClass($curso, $grupo)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from courses c, classes g where c.code = '$curso' and g.class_number = '$grupo' and 
        c.code = g.course_id");
        $result = $result->fetchAll('assoc');
        return $result;
    }
    
    //Devuelve el profesor que imparte un grupo en un semestre y año determinado
    public function getProfessor($curso, $grupo, $semestre, $año)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select CONCAT(name,' ',lastname1) from users u, class c where u.identification_number = c.professor_id
        and class_semester = '$semestre' and class_year = '$year' and course_id = '$curso'");
        $result = $result->fetchAll('assoc');
        return $result;
    }


    /**
     * This method was added by Joseph Rementería
     * 
     * Fetches the state of the given id request.
     */
    public function fetchState($id = null)
    {
        $connect = ConnectionManager::get('default');
        $result = $connect->execute("SELECT status FROM request WHERE id = '$id'");
        //debug($result);
        die();
        return $result;
    }
    
    
    //Permite modificar el estado de una solicitud segun el id de solicitud
    public function updateRequestStatus($id = null, $status = null)
    {
        $connet = ConnectionManager::get('default');
        $connet->execute("update requests set status = '$status' WHERE id = '$id'");
    }
    
    /**
     * This method was edded by Joseph Rementería.
     * 
     * It queries the status of a request and returns an int that shall
     * be used as the default option in the preliminar review screen.
     * 
     * @param  int $id 
     * @return  int the default index for the preliminar review screen
     */
    public function getStatusIndexOutOfId($id = null)
    {
        $connection = ConnectionManager::get('default');
        $request = $this->get($id);
        $result = -1;

        switch($request['status']){
            case 'p':
                $result = 0;
                break;
            case 'e':
                $result = 1;
                break;
            case 'n':
                $result = 2;
                break;
            case 'i':
                $result = 3;
                break;
            case 'a':
                $result = 4;
                break;
            case 'r':
                $result = 5;
                break;
            case 'c':
                $result = 6;
                break;
        }
        return $result;
    }

    public function getStatus($id){
        $connection = ConnectionManager::get('default');
        $request = $this->get($id);
        return $request['status'];
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * llama al procedimiento almacenado creado para aprobar solicitudes
     * 
     * @param {int} $req_id - ID de la solicitud
     * @param {string} $h_type - Tipo de horas por agregar
     * @param {int} $cnt - cantidad de horas por agregar
     */
    public function approveRequest($req_id,$h_type,$cnt){
        $connet = ConnectionManager::get('default');
        $connet->execute(
            "CALL approve_request('$req_id', '$h_type', '$cnt')"
        );
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Obtiene la solicitud aprobada con el ID respectivo
     * 
     * @param {int} $id - ID de la solicitud
     * @return {array} solicitud aprobada 
     */
    public function getApproved($id) {
        $connet = ConnectionManager::get('default');
        $query = $connet->execute(
            "SELECT * FROM approved_requests
             WHERE request_id = '$id'"
        )->fetchAll();
        return $query;
    }
    
    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Verifica si existe al menos una solicitud en la ronda actual
     */
    public function requestsOnRound(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute(
            "SELECT EXISTS (SELECT 1 FROM requests WHERE round_start = (SELECT max(start_date) FROM rounds))"
        )->fetchAll()[0][0];
        return $query;
    }

    /**
     * Metodo que obtiene todos los requisitos no cumplidos por el estudiante en una solicitud.
     * 
     * @author Estiven Alfaro <estivenalg@gmail.com>
     * @param int $id que es el identificador de la solicitud
     * @param char $s se debe poner el valor que identifique a los requisitos rechados
     * @param int $in que identifica si se aprueba requisito por inopia o no.
     * @return result: los requisitos no aprobados en la solicitud.
     */
    public function getRequirements($id,$s,$in)
	{
        $connet = ConnectionManager::get('default');
        //Se hace consulta para obtener los requisitos rechazados dentro de la solicitud, se hace join con requirements
        // Para obtener la descripción de los requisitos.
		$result = $connet->execute("select re.description from requests_requirements r, requirements re 
		where r.requirement_number = re.requirement_number and r.request_id = '$id'
		and r.state = '$s' and r.acepted_inopia = '$in'");
		$result = $result->fetchAll('assoc');
        return $result; // Se devuelve la lista de requisitos.
    }
    
    /**
     * Determina si un estudiante es dueño de una solicitud.
     * 
     * Retorna verdadero si la socilitud $id fue realizada por el estudiante $student_id.
     * 
     * @param string $id
     * @param string $student_id
     * @return bool 
     */
    public function isOwnedBy($id, $student_id)
    {
        return $this->exists(['id' => $id, 'student_id' => $student_id]);
    }

    public function traerElegibles()
    {
        $connet = ConnectionManager::get('default');
        $query = $connet->execute(
        "SELECT r.id, u.username, s.average, r.course_id, r.class_number, r.has_another_hours
         FROM requests r, students s, users u, rounds ro
         WHERE ro.start_date = r.round_start
         AND (r.status = 'e' OR r.status = 'i')
         AND r.student_id = s.user_id 
         AND s.user_id = u.identification_number"
        )->fetchAll();
        return $query;
    }
    /**
     * Determina si un profesor está a cargo del curso para el cual se solicita una
     * asistencia.
     * 
     * Retorna verdadero si el profesor $professor_id imparte el curso de la solicitud $id.
     * 
     * @param string $id
     * @param string $professor_id
     * @return bool
     */
    public function isTaughtBy($id, $professor_id)
    {
        $submission = $this->get($id,[
            'contain' => [
                'Classes'
            ]
        ]);
        return $submission->class->professor_id === $professor_id;  
    }

    /**
     * Retorna toda la información asociada a una solicitud, incluyendo el estudiante
     * que hizo la solicitud, el curso-grupo que solicita y el profesor que lo imparte.
     * 
     * @param string $id
     * @return array Arreglo con toda la información.
     */
    public function getAllRequestInfo($id)
    {

        $submission = $this->get($id, [
            'contain' => [
                'Classes' => ['Professors' => ['Users'], 'Courses'],
                'Students' => ['Users']
            ],
        ]);

        return $submission;
    }


    //EMPIEZA JORGE
    //Retorna si una solicitud tiene inopia en un array
    public function isInopia($id){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute("select count(*) from requests_requirements where acepted_inopia = 1 and request_id = '$id'")->fetchAll();
        if($query[0][0] > 0){
            return true;
        }else{
            return false;
        }
    }
    
    //Metodo que guarda en la base que tipo de horas se le puede asignar a una solicitud
    public function setRequestScope($id, $scope){
        $connet = ConnectionManager::get('default');

        $query = $connet->execute("update requests set scope = '$scope' where id = '$id'");
    }

    /**
     * Devuelve el tipo de horas que se le pueden asignar a un estudiante basado en la revision de requisistos.
     * 
     * @author Kevin Jiménez <kevinja9608@gmail.com>
     * @param String $id Id de la solicitud
     * @return String Devuelve n para ninguno, e para horas estudiante y a para ambos
     */
    public function getScope($id){
        $request = $this->get($id);
        return $request->scope;
    }
	
	 /**
     * Devuelve todas las solicitudes aprobadas en una ronda.
     * 
     * @author Esteban Rojas
     * @param String $llave_ronda Id de la ronda
     * @return Array con todas las solicitudes aprobadas
     */
	public function getApprovedRequestsByRound($llave_ronda)
	{
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from info_requests i, approved_requests a, courses c where i.inicio = $llave_ronda AND i.id = a.request_id and c.code = i.curso");
        $result = $result->fetchAll('assoc');
        return $result;
	}
	
	/**
     * Devuelve todas las solicitudes según su estado en una ronda. No se recomienda utilizarlo con las solicitudes aprobadas dado que no se
     * trae la cantidad de horas asignadas 
	 *
     * @author Esteban Rojas
     * @param String $llave_ronda Id de la ronda
	 @param char $estado
     * @return Array con todas las solicitudes según dicho estado
     */
	public function getRequestsByRoundStatus($llave_ronda,$estado)
	{
		$connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from info_requests i, courses c where i.inicio = $llave_ronda AND c.code = i.curso AND i.estado = '$estado'");
        $result = $result->fetchAll('assoc');
        return $result;
	}
	/**
     * Devuelve todas las solicitudes en una ronda.
     * 
     * @author Esteban Rojas
     * @param String $llave_ronda Id de la ronda
     * @return Array con todas las solicitudes de dicha ronda
     */
	public function getAllRequestsByRound($llave_ronda)
	{
		$connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from info_requests i, courses c where i.inicio = $llave_ronda AND i.curso = c.code");
        $result = $result->fetchAll('assoc');
        return $result;
	}

}


