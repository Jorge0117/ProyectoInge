<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * CanceledRequests Model
 *
 * @method \App\Model\Entity\CanceledRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\CanceledRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CanceledRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CanceledRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CanceledRequest|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CanceledRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CanceledRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CanceledRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class CanceledRequestsTable extends Table
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

        $this->setTable('canceled_requests');
        $this->setDisplayField('request_id');
        $this->setPrimaryKey('request_id');
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
            ->integer('request_id')
            ->allowEmpty('request_id', 'create');

        $validator
            ->scalar('justification')
            ->maxLength('justification', 250)
            ->requirePresence('justification', 'create')
            ->notEmpty('justification');

        return $validator;
    }

    public function cancelRequest($id, $just){
        $connect = ConnectionManager::get('default');

        $inTable = count($connect->execute("select request_id from canceled_requests where request_id = '$id'"));

        if ($inTable == 0) {
            $connect->execute("insert into canceled_requests values('$id', '$just')");
            return true;
        }else{
            return false;
        }
    }

    public function getJustification($id){
        $connect = ConnectionManager::get('default');

        $result = $connect->execute("select justification from canceled_requests where request_id = '$id'");

        $result = $result->fetchAll('assoc');
        return $result;
    }
}
