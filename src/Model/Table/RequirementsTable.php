<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Requirements Model
 *
 * @property \App\Model\Table\FulfillsRequirementTable|\Cake\ORM\Association\HasMany $FulfillsRequirement
 *
 * @method \App\Model\Entity\Requirement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Requirement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Requirement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Requirement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Requirement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Requirement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Requirement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Requirement findOrCreate($search, callable $callback = null, $options = [])
 */
class RequirementsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    //Se inicializa la tabla
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('requirements');
        $this->setDisplayField('requirement_number');
        $this->setPrimaryKey('requirement_number');

        $this->hasMany('FulfillsRequirement', [
            'foreignKey' => 'requirement_id'
        ]);

        $this->belongsToMany('Requests', [
            'foreignKey' => 'requirement_number',
            'joinType' => 'INNER'
        ]);
    }
    //Función para eliminar un requisito, llamada por el controlador
    public function deleteRequirement($requirement_number)
    {
        //------------------------------------------------
        $result = true;
        //------------------------------------------------
        $connection = ConnectionManager::get('default');
        //------------------------------------------------
        //Ejecuta el código SQL en la base de datos directamente, para eliminar el requisito con la
        //llave primaria que se mandó como parámetro
        $result = $connection->execute(
            "DELETE FROM requirements 
            WHERE   requirement_number  = '$requirement_number' 
            "
        );
        //------------------------------------------------
        //Se envía el resultado de la operación
        return $result;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    //Se realizan las validaciones
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('requirement_number')
            ->allowEmpty('requirement_number', 'create');

        $validator
            ->scalar('description')
            ->maxLength('description', 250)
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }

    public function getRequestRequirements($id){

        //$request_id = intval($request_id);
        $optional_requirements = $this->find('all')->join([
            'rr' => [
                'table' => 'requests_requirements',
                'conditions' => 'rr.requirement_number = Requirements.requirement_number and rr.request_id = '.$id.' and Requirements.type = \'Opcional\''
            ]
        ])->toArray();

        $compulsory_requirements = $this->find('all')->join([
            'rr' => [
                'table' => 'requests_requirements',
                'conditions' => 'rr.requirement_number = Requirements.requirement_number and rr.request_id = '.$id.' and Requirements.type = \'Obligatorio\''
            ]
        ])->toArray();
		
        
        $requirements = ['Obligatorio' => $compulsory_requirements, 'Opcional' => $optional_requirements];
		return $requirements;
    }
}
