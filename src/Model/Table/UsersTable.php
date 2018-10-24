<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;


/**
 * Users Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\AdministrativeAssistantsTable|\Cake\ORM\Association\HasMany $AdministrativeAssistants
 * @property \App\Model\Table\AdministrativeBossesTable|\Cake\ORM\Association\HasMany $AdministrativeBosses
 * @property \App\Model\Table\ProfessorsTable|\Cake\ORM\Association\HasMany $Professors
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\HasMany $Students
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('identification_number');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AdministrativeAssistants', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('AdministrativeBosses', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Professors', [
            'foreignKey' => 'user_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'user_id'
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
            ->scalar('identification_number')
            ->maxLength('identification_number', 20)
            ->notEmpty('identification_number');
        
        $validator->add(
            'identification_number', 
                ['unique' => [
                    'rule' => 'validateUnique', 
                    'provider' => 'table', 
                    'message' => 'Not unique']
                ]
        );

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('lastname1')
            ->maxLength('lastname1', 50)
            ->requirePresence('lastname1', 'create')
            ->notEmpty('lastname1');

        $validator
            ->scalar('lastname2')
            ->maxLength('lastname2', 50)
            ->allowEmpty('lastname2');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            ->notEmpty('username')
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('email_personal')
            ->maxLength('email_personal', 200)
            ->requirePresence('email_personal', 'create')
            ->notEmpty('email_personal');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 12)
            ->allowEmpty('phone');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    public function getId ($name, $lastname) {
        $connect = ConnectionManager::get('default');

        $id = $connect->execute("select identification_number from users where name like '%$name' and lastname1 like '$lastname%'") ->fetchAll();
        if($id != null){
            return $id[0][0];
        }else{
            return null;
        }
        
    }

    public function getProfessors() {
        $connect = ConnectionManager::get('default');

        $prof = $connect->execute("select CONCAT(name, \" \", lastname1) from users where role_id = 'Profesor'") ->fetchAll();
        $prof = array_column($prof, 0);
        return $prof;
    }
}
