<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * RequestsBackup Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 * @property \App\Model\Table\ClassesTable|\Cake\ORM\Association\BelongsTo $Classes
 *
 * @method \App\Model\Entity\RequestsBackup get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequestsBackup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequestsBackup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequestsBackup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestsBackup|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestsBackup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequestsBackup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequestsBackup findOrCreate($search, callable $callback = null, $options = [])
 */
class RequestsBackupTable extends Table
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

        $this->setTable('requests_backup');
        $this->setDisplayField('student_id');
        $this->setPrimaryKey('student_id');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id'
        ]);
        $this->belongsTo('Classes', [
            'foreignKey' => 'class_id'
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
            ->scalar('student_id')
            ->maxLength('student_id', 20)
            ->allowEmpty('student_id', 'create');

        $validator
            ->scalar('requests_backupcol')
            ->maxLength('requests_backupcol', 45)
            ->allowEmpty('requests_backupcol');

        $validator
            ->allowEmpty('another_student_hours');

        $validator
            ->allowEmpty('another_assistant_hours');

        $validator
            ->boolean('first_time')
            ->allowEmpty('first_time');

        $validator
            ->boolean('has_another_hours')
            ->allowEmpty('has_another_hours');

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
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        $rules->add($rules->existsIn(['class_id'], 'Classes'));

        return $rules;
    }
	
	public function saveRequest($st,$ci,$cai,$ash,$aah,$ft,$hah)
	{
		$connet = ConnectionManager::get('default');
        $connet->execute("call save_request ('$st','$ci','$cai','$ash','$aah','$ft','$hah')");
		
	}
}
