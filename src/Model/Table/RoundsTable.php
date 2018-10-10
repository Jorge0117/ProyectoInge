<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Rounds Model
 *
 * @method \App\Model\Entity\Round get($primaryKey, $options = [])
 * @method \App\Model\Entity\Round newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Round[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Round|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Round|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Round patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Round[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Round findOrCreate($search, callable $callback = null, $options = [])
 */
class RoundsTable extends Table
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

        $this->setTable('rounds');
        $this->setDisplayField('semester');
        $this->setPrimaryKey(['semester', 'number', 'year']);
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
            ->scalar('round_number')
            ->requirePresence('round_number', 'create')
            ->notEmpty('round_number');

        $validator
            ->scalar('semester')
            ->requirePresence('semester', 'create')
            ->notEmpty('semester');

        $validator
            ->scalar('year')
            ->requirePresence('year', 'create')
            ->notEmpty('year');

        $validator
            ->date('start_date')
            ->allowEmpty('start_date', 'create');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->date('approve_limit_date')
            ->requirePresence('approve_limit_date', 'create')
            ->notEmpty('approve_limit_date');

        return $validator;
    }
    
    public function insertRound($start_d,$end_d,$approve){
        $connet = ConnectionManager::get('default');
        $connet->execute("call insert_round ('$start_d','$end_d','$approve')");
    }

    public function getLastRound(){
        $connet = ConnectionManager::get('default');
        $connet->execute("call select_last_round ()");
        //return $result;
    }

    public function deleteLastRound(){
        $connet = ConnectionManager::get('default');
        $connet->execute("call delete_last_round ()");
    }

}
