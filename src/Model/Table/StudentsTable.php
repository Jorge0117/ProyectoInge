<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Students Model
 *
 * @property \App\Model\Table\ApplicationsTable|\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\RequestsTable|\Cake\ORM\Association\HasMany $Requests
 * @property \App\Model\Table\RequestsBackupTable|\Cake\ORM\Association\HasMany $RequestsBackup
 *
 * @method \App\Model\Entity\Student get($primaryKey, $options = [])
 * @method \App\Model\Entity\Student newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Student[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Student[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student findOrCreate($search, callable $callback = null, $options = [])
 */
class StudentsTable extends Table
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

        $this->setTable('students');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');

        $this->hasMany('Applications', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('Requests', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('RequestsBackup', [
            'foreignKey' => 'student_id'
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
            ->scalar('user_id')
            ->maxLength('user_id', 20)
            ->allowEmpty('user_id', 'create');

        $validator
            ->scalar('carne')
            ->maxLength('carne', 6)
            ->requirePresence('carne', 'create')
            ->notEmpty('carne');

        return $validator;
    }
}
