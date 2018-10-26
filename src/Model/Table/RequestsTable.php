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

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('round_start')
            ->requirePresence('round_start', 'create')
            ->notEmpty('round_start');

        $validator
            ->date('reception_date')
            ->requirePresence('reception_date', 'create')
            ->notEmpty('reception_date');

        $validator
            ->scalar('class_year')
            ->requirePresence('class_year', 'create')
            ->notEmpty('class_year');

        $validator
            ->requirePresence('class_semester', 'create')
            ->notEmpty('class_semester');

        $validator
            ->requirePresence('class_number', 'create')
            ->notEmpty('class_number');

        $validator
            ->scalar('status')
            ->maxLength('status', 1)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->requirePresence('another_assistant_hours', 'create')
            ->notEmpty('another_assistant_hours');

        $validator
            ->requirePresence('another_student_hours', 'create')
            ->notEmpty('another_student_hours');

        $validator
            ->boolean('has_another_hours')
            ->requirePresence('has_another_hours', 'create')
            ->notEmpty('has_another_hours');

        $validator
            ->boolean('first_time')
            ->requirePresence('first_time', 'create')
            ->notEmpty('first_time');

        $validator
            ->decimal('average')
            ->requirePresence('average', 'create')
            ->notEmpty('average');

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
	public function getClass($curso,$grupo)
	{
		$connet = ConnectionManager::get('default');
		$result = $connet->execute("select * from courses c, classes g where c.code = '$curso' and g.class_number = '$grupo' and 
		c.code = g.course_id");
		$result = $result->fetchAll('assoc');
        return $result;	
	}
	
	//Devuelve el profesor que imparte un grupo en un semestre y año determinado
	public function getProfessor($curso,$grupo, $semestre, $año)
	{
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select CONCAT(name,' ',lastname1) from users u, class c where u.identification_number = c.professor_id
		and class_semester = '$semestre' and class_year = '$year' and course_id = '$curso'");
		$result = $result->fetchAll('assoc');
        return $result;
    }
	

	
	
	
}
