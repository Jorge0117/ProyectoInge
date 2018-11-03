<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RequestsRequirements Model
 *
 * @property \App\Model\Table\RequestsTable|\Cake\ORM\Association\BelongsTo $Requests
 *
 * @method \App\Model\Entity\RequestsRequirement get($primaryKey, $options = [])
 * @method \App\Model\Entity\RequestsRequirement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RequestsRequirement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RequestsRequirement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestsRequirement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RequestsRequirement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RequestsRequirement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RequestsRequirement findOrCreate($search, callable $callback = null, $options = [])
 */
class RequestsRequirementsTable extends Table
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

        $this->setTable('requests_requirements');
        $this->setDisplayField('requirement_number');
        $this->setPrimaryKey(['requirement_number', 'request_id']);

        $this->belongsTo('Requests', [
            'foreignKey' => 'request_id',
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
            ->integer('requirement_number')
            ->allowEmpty('requirement_number', 'create');

        $validator
            ->scalar('state')
            ->maxLength('state', 1)
            ->requirePresence('state', 'create')
            ->notEmpty('state');

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
        $rules->add($rules->existsIn(['request_id'], 'Requests'));

        return $rules;
    }
}
