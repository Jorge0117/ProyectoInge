<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
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
	
	public function validarSolicitudRepetida($check,  $datos)
	{
		$curso = debug($datos['data']['course_id']);
		$grupo = debug($datos['data']['class_number']);
		
		//Si encuentro una sola tupla de solicitudes pendientes con el mismo curso y grupo, entonces de una vez indico que 
		//la solicitud ya existe
		
		$tuplas = $this->getSameRequests($curso,$grupo);
		
		debug($tuplas);
		

		return (count($tuplas) == 0);
	}
	 
    public function validationDefault(Validator $validator)
    {
		
		//Valida que el promedio ponderado se encuentre entre 0 y 10
		$validator	
			->notEmpty('average')
			->lessThanOrEqual('average',10,'* El valor máximo del promedio ponderado es 10')
			->GreaterThanOrEqual('average',0,'* El valor minimo del promedio ponderado es 0');
			
		//Valida que la cantidad de horas asistente se encuentre entre 0 y 20
		$validator
			->integer('another_student_hours')
			->allowEmpty('another_student_hours')
			->lessThanOrEqual('another_student_hours',20,'* La cantidad maxima de horas ya asignadas es 20')
			->GreaterThanOrEqual('another_student_hours',0,'La cantidad minima de horas ya asignadas es 0');
			
		//Valida que la cantidad de horas estudiante se encuentre entre 0 y 20
		$validator
			->integer('another_assistant_hours')
			->allowEmpty('another_assistant_hours')
			->lessThanOrEqual('another_assistant_hours',20,'* La cantidad maxima de horas ya asignadas es 20')
			->GreaterThanOrEqual('another_assistant_hours',0,'La cantidad minima de horas ya asignadas es 0');
			

		//Valida que se seleccione un curso valido
        $validator->add('course_id',[
        'validarCurso'=>[
        'rule'=>'validarCurso',
        'provider'=>'table',
        'message'=>'Seleccione un curso'
         ]
        ]);

		
		//Valida que se seleccione un grupo valido
		$validator->add('class_number',[
        'validarGrupo'=>[
        'rule'=>'validarGrupo',
        'provider'=>'table',
        'message'=>'Seleccione un Grupo'
         ]
        ]);
		
		//Valida que no se ingrese una solicitud repetida
		$validator->add('class_number',[
        'validarSolicitudRepetida'=>[
        'rule'=>'validarSolicitudRepetida', ["contexto"],
        'provider'=>'table',
        'message'=>'La solicitud a este curso/grupo ya existe'
         ]
        ]);
		
		//Los demas elementos no es necesario validarlos, ya que los checkboxs pueden guardarse como nulos en la DB
		


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
	
	public function getStudentInfo($student_carnet)
	{
		$connet = ConnectionManager::get('default');
		      //  $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from Classes c, users u WHERE c.course_id = "+$courseId+" AND c.class_number = "+$classNumber+" AND c.professor_id = u.identification_number");
		$result = $connet->execute("select * from users u, students s where s.carne = '$student_carnet' and u.identification_number = s.user_id");
		$result = $result->fetchAll('assoc');
        return $result;

	}
	
	public function getSameRequests($course, $class)
	{
		$connet = ConnectionManager::get('default');
		$result = $connet->execute("Select * from requests where course_id = '$course' and class_number = '$class'and status = 'p'");
		$result = $result->fetchAll('assoc');
        return $result;

	}
	
	
	
}
