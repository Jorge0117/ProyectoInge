<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;


/**
 * AdministrativeAssistants Model
 *
 * @method \App\Model\Entity\AdministrativeAssistant get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdministrativeAssistant findOrCreate($search, callable $callback = null, $options = [])
 */
class AdministrativeAssistantsTable extends Table
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

        $this->setTable('administrative_assistants');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');
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

        return $validator;
    }

    public function addAssistant($id){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\d+/", $id)){
            $connect->execute("INSERT INTO administrative_assistants (`user_id`) VALUES ('$id');") ;
        }
        
    }

    public function deleteAssistant($id){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\d+/", $id)){
            $connect->execute("DELETE from administrative_assistants where user_id = '$id';") ; 
        }       
    }
}
