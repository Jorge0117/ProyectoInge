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
            'foreignKey' => 'class_number',
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
    
    /*public function validarSolicitudRepetida($check,  $datos)
    {
        $curso = debug($datos['data']['course_id']);
        $grupo = debug($datos['data']['class_number']);
        
        //Si encuentro una sola tupla de solicitudes pendientes con el mismo curso y grupo, entonces de una vez indico que 
        //la solicitud ya existe
        //$estudiante = $this->get_student_id();
        $tuplas = $this->getSameRequests($curso,$grupo);
        debug($datos);
        
        return true;
        //return (count($tuplas) == 0);
    }*/

    public function validationDefault(Validator $validator)
    {
        
        //Valida que el promedio ponderado se encuentre entre 0 y 10
        $validator
            ->notEmpty('average')
            ->lessThanOrEqual('average', 10, '* El valor máximo del promedio ponderado es 10')
            ->GreaterThanOrEqual('average', 0, '* El valor minimo del promedio ponderado es 0');
            
        //Valida que la cantidad de horas asistente se encuentre entre 0 y 20
        $validator
            ->integer('another_student_hours')
            ->allowEmpty('another_student_hours')
            ->lessThanOrEqual('another_student_hours', 20, '* La cantidad maxima de horas ya asignadas es 20')
            ->GreaterThanOrEqual('another_student_hours', 0, 'La cantidad minima de horas ya asignadas es 0');
            
        //Valida que la cantidad de horas estudiante se encuentre entre 0 y 20
        $validator
            ->integer('another_assistant_hours')
            ->allowEmpty('another_assistant_hours')
            ->lessThanOrEqual('another_assistant_hours', 20, '* La cantidad maxima de horas ya asignadas es 20')
            ->GreaterThanOrEqual('another_assistant_hours', 0, 'La cantidad minima de horas ya asignadas es 0');
            

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
        
        //Valida que no se ingrese una solicitud repetida
        /*$validator->add('class_number',[
        'validarSolicitudRepetida'=>[
        'rule'=>'validarSolicitudRepetida', ["contexto"],
        'provider'=>'table',
        'message'=>'La solicitud a este curso/grupo ya existe'
         ]
        ]);*/
        
        //Los demas elementos no es necesario validarlos, ya que los checkboxs pueden guardarse como nulos en la DB
        
        //debug($validator);

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
        $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from Classes c, users u WHERE c.course_id = '$courseId' AND c.class_number = '$classNumber' AND c.professor_id = u.identification_number");
        $result = $result->fetchAll('assoc');
        return $result;

	}


	/*
	public function getStudentInfo($student_id)
	{
		$connet = ConnectionManager::get('default');
		      //  $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from Classes c, users u WHERE c.course_id = "+$courseId+" AND c.class_number = "+$classNumber+" AND c.professor_id = u.identification_number");
		$result = $connet->execute("select * from users u, students s where u.identification_number = '$student_id' and u.identification_number = s.user_id");
		$result = $result->fetchAll('assoc');
        return $result;

	}
	*/
	
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
    
    //Obtiene los codigos de curso y codigo nombre de las grupo de este semestre y año cuyo estado sea 1
    public function getGroups($id_estudiante, $semestre, $year)
    {
        $connet = ConnectionManager::get('default');

        $result = $connet->execute("select c.course_id,c.class_number, co.name from classes c, courses co
        where c.year = '$year' and c.semester = '$semestre' and co.code = c.course_id AND c.state = 1 AND 
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
        debug($result);
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
        }
        return $result;
    }

    public function getRequirements($id,$s,$in)
	{
		$connet = ConnectionManager::get('default');
		$result = $connet->execute("select re.description from requests_requirements r, requirements re 
		where r.requirement_number = re.requirement_number and r.request_id = '$id'
		and r.state = '$s' and r.acepted_inopia = '$in'");
		$result = $result->fetchAll('assoc');
        return $result;
	}

}
