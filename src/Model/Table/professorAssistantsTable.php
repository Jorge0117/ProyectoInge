<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApprovedRequestsView Model
 *
 * @method \App\Model\Entity\ApprovedRequestsView get($primaryKey, $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovedRequestsView findOrCreate($search, callable $callback = null, $options = [])
 */
class professorAssistantsTable extends Table
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

        $this->setTable('professor_assistants');
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
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->scalar('carne')
            ->maxLength('carne', 6)
            ->requirePresence('carne', 'create')
            ->notEmpty('carne');

        $validator
            ->numeric('nombre')
            ->allowEmpty('nombre');

        $validator
            ->scalar('anno')
            ->requirePresence('anno', 'create')
            ->notEmpty('anno');

        $validator
            ->requirePresence('semestre', 'create')
            ->notEmpty('semestre');

        $validator
            ->scalar('curso')
            ->maxLength('curso', 7)
            ->requirePresence('curso', 'create')
            ->notEmpty('curso');

        $validator
            ->requirePresence('grupo', 'create')
            ->notEmpty('grupo');

        $validator
            ->scalar('tipo_hora')
            ->maxLength('tipo_hora', 2)
            ->requirePresence('tipo_hora', 'create')
            ->notEmpty('tipo_hora');

        $validator
            ->requirePresence('hour_ammount', 'create')
            ->notEmpty('hour_ammount');

        $validator
            ->scalar('id_prof')
            ->maxLength('id_prof', 20)
            ->allowEmpty('id_prof');

        $validator
            ->scalar('id_student')
            ->maxLength('id_student', 20)
            ->allowEmpty('id_student');    

        return $validator;
    }
}
