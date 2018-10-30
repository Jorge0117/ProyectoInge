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

    public function getStudentInfo($student_id)
	{
		$connet = ConnectionManager::get('default');
		      //  $result = $connet->execute("Select CONCAT(name,' ',lastname1) AS name from Classes c, users u WHERE c.course_id = "+$courseId+" AND c.class_number = "+$classNumber+" AND c.professor_id = u.identification_number");
		$result = $connet->execute("select * from users u, students s where u.identification_number = '$student_id' and u.identification_number = s.user_id");
		$result = $result->fetchAll('assoc');
        return $result;
    }
	
}
