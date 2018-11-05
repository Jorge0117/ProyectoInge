<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;


/**
 * AdministrativeBosses Model
 *
 * @method \App\Model\Entity\AdministrativeBoss get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdministrativeBoss newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdministrativeBoss[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdministrativeBoss|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdministrativeBoss|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdministrativeBoss patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdministrativeBoss[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdministrativeBoss findOrCreate($search, callable $callback = null, $options = [])
 */
class AdministrativeBossesTable extends Table
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

        $this->setTable('administrative_bosses');
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

    public function addBoss($id){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\d+/", $id)){
            $connect->execute("INSERT INTO administrative_bosses (`user_id`) VALUES ('$id');") ;
        }
        
    }

    public function deleteBoss($id){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\d+/", $id)){
            $connect->execute("DELETE FROM administrative_bosses WHERE `user_id` = '$id';") ;
        }
    }
}
