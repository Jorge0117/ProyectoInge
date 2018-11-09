<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InfoRequests Model
 *
 * @method \App\Model\Entity\InfoRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\InfoRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InfoRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InfoRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InfoRequest|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InfoRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InfoRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InfoRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class InfoRequestsTable extends Table
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

        $this->setTable('info_requests');
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
            ->date('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha');

        $validator
            ->scalar('cedula')
            ->maxLength('cedula', 20)
            ->requirePresence('cedula', 'create')
            ->notEmpty('cedula');

        $validator
            ->scalar('carne')
            ->maxLength('carne', 6)
            ->requirePresence('carne', 'create')
            ->notEmpty('carne');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 152)
            ->allowEmpty('nombre');

        $validator
            ->decimal('promedio')
            ->requirePresence('promedio', 'create')
            ->notEmpty('promedio');

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
            ->date('inicio')
            ->requirePresence('inicio', 'create')
            ->notEmpty('inicio');

        $validator
            ->scalar('ronda')
            ->requirePresence('ronda', 'create')
            ->notEmpty('ronda');

        $validator
            ->scalar('estado')
            ->maxLength('estado', 1)
            ->requirePresence('estado', 'create')
            ->notEmpty('estado');

        $validator
            ->boolean('otras_horas')
            ->requirePresence('otras_horas', 'create')
            ->notEmpty('otras_horas');

        $validator
            ->scalar('id_prof')
            ->maxLength('id_prof', 20)
            ->allowEmpty('id_prof');

        return $validator;
    }
}
