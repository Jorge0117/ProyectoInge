<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermissionsRoles Model
 *
 * @property \App\Model\Table\PermissionsTable|\Cake\ORM\Association\BelongsTo $Permissions
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\PermissionsRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\PermissionsRole newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PermissionsRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PermissionsRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermissionsRole|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermissionsRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PermissionsRole[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PermissionsRole findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionsRolesTable extends Table
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

        $this->setTable('permissions_roles');
        $this->setDisplayField('role_id');
        $this->setPrimaryKey(['role_id', 'permission_id']);

        $this->belongsTo('Permissions', [
            'foreignKey' => 'permission_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['permission_id'], 'Permissions'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
