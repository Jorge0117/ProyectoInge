<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;


/**
 * Professors Model
 *
 * @property \App\Model\Table\ClassesTable|\Cake\ORM\Association\HasMany $Classes
 *
 * @method \App\Model\Entity\Professor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Professor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Professor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Professor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Professor|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Professor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Professor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Professor findOrCreate($search, callable $callback = null, $options = [])
 */
class ProfessorsTable extends Table
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

        $this->setTable('professors');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');

        $this->hasMany('Classes', [
            'foreignKey' => 'professor_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'bindingKey' => 'identification_number',
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
            ->scalar('user_id')
            ->maxLength('user_id', 20)
            ->allowEmpty('user_id', 'create');

        return $validator;
    }

    public function addProfessor($id){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\d+/", $id)){
            $connect->execute("INSERT INTO professors (`user_id`) VALUES ('$id');") ;
        }
        
    }

    public function deleteProfessor($id){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\d+/", $id)){
            $connect->execute("DELETE FROM professors WHERE `user_id` = '$id';") ;
        }
    }
}
