<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permissions Model
 *
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsToMany $Roles
 *
 * @method \App\Model\Entity\Permission get($primaryKey, $options = [])
 * @method \App\Model\Entity\Permission newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Permission[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Permission|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permission|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Permission[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Permission findOrCreate($search, callable $callback = null, $options = [])
 */
class PermissionsTable extends Table
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

        $this->setTable('permissions');
        $this->setDisplayField('permission_id');
        $this->setPrimaryKey('permission_id');

        $this->belongsToMany('Roles', [
            'foreignKey' => 'permission_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'permissions_roles',
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
            ->scalar('permission_id')
            ->maxLength('permission_id', 30)
            ->allowEmpty('permission_id', 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->allowEmpty('description');

        return $validator;
    }

    /**
     * Devuelve los permisos concedidos a un rol
     * 
     * @author Kevin Jimenez <kevinja9608@gmail.com>
     * @param String $rol
     * @return Array Permisos concedidos a un rol
     */
    public function getPermissions($rol)
    {
        return $this->find('list')->matching('Roles', function ($q) use ($rol) {
            return $q->where(['Roles.role_id' => $rol]);
        })->toArray();
    }

    /**
     * Devuelve todos los permisos del sistema ordenados por modulo 
     *
     * @author Kevin Jimenez <kevinja9608@gmail.com>
     * @return Array Permisos ordenados por modulo
     */
    public function getAllPermissionsByModule()
    {
        /*
         * Esta es la forma general del array que sera devuelto.
         * Cada campo (que representa cada modulo) contendrá 
         * un array cuyas llaves seran la acciones relacionadas con ese modulo.
         * Para ilustrar esto, observe el siguiente ejemplo de un permiso guardado en esta estructura:
         *      $permissions_by_module['Users']['add'] = 'Agregar un usuario';
         * En este caso, el permiso es 'Agregar un usuario', que se referencia como una 
         * acción 'add' del modulo 'Users'.
         */
        $permissions_by_module = [
            'CoursesClassesVw' => [],
            'Mainpage' => [],
            'Reports' => [],
            'Requests' => [],
            'Requirements' => [],
            'Roles' => [],
            'Rounds' => [],
            'Users' => [],
        ];
        
        /*
         * Se solicitan todos los permisos existentes del sistema.
         * Esto devuelve un array que contiene las tuplas de permisos.
         * Estas tuplas estan compuestas por dos campos: permission_id 
         * y description (y otra información que no es relevante aqui).
         */ 
        $all_permissions = $this->find('all')->toArray();

        /*
         * En este ciclo, cada tupla devuelta es recorrida y "desarmada". Esto significa
         * que el modulo y la accion son guardadas en variables distintas, 
         * asi como su descripcion. Estas variables son usadas para llenar
         * la estructura $permissions_by_module.
         */
        foreach ($all_permissions as $key => $value) {
            list($module, $action) = explode("-",$value['permission_id']);
            $description = $value['description'];
            $permissions_by_module[$module][$action] = $description;
        }

        return $permissions_by_module;
    }
}
