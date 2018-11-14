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

        $this->hasMany('RequestsRequirements', [
            'foreignKey' => 'requirement_number'
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

        $validator
            ->scalar('hour_type')
            ->requirePresence('hour_type', 'create')
            ->notEmpty('hour_type');

        return $validator;
    }

    /**
     * Retorna un array con los requisito de la solicitud con $id categorizados en opcionales y obligatorios.
     * 
     * @param String $id Identificador de la solicitud
     * @return array Array con los requisitos de la solicitud categorizados en opcionales y obligatorios
     * 
     */
    public function getRequestRequirements($id){

        // Solicita a la base los requisitos opcionales, esto devuelve un array con toda la informacion
        $requirements = $this->find()->matching('RequestsRequirements', function($q) use($id){
            return $q->select(['RequestsRequirements.state','RequestsRequirements.acepted_inopia'])->where(['RequestsRequirements.request_id' => $id]); 
        })->where(['hour_type' => 'Estudiante'])->toArray();

        /* En el array que se retorna, solo se guarda los campos necesarios(para disminuir el trafico en la red)
         * En el caso de los opcionales se guarda el estado, numero de requisito, si fue aceptado por inopia
         * y su descripcion
         */
        $student_requirements = [];
        for ($i = 0; $i < count($requirements); $i++){
            $student_requirements[$i] = [];
            $student_requirements[$i]['state'] = $requirements[$i]['_matchingData']['RequestsRequirements']['state'];
            $student_requirements[$i]['acepted_inopia'] = $requirements[$i]['_matchingData']['RequestsRequirements']['acepted_inopia'];
            $student_requirements[$i]['requirement_number'] = $requirements[$i]['requirement_number'];
            $student_requirements[$i]['description'] = $requirements[$i]['description'];
            $student_requirements[$i]['type'] = $requirements[$i]['type'];
        }

        // Solicita a la base los requisitos obligatorios
        $requirements = $this->find()->matching('RequestsRequirements', function($q) use($id){
            return $q->select(['RequestsRequirements.state','RequestsRequirements.acepted_inopia'])->where(['RequestsRequirements.request_id' => $id]); 
        })->where(['hour_type' => 'Asistente'])->toArray();

        /*
         * En el array que se retorna, solo se guarda los campos necesarios(para disminuir el trafico en la red)
         * En el caso de los obligatorios se guarda el estado, numero de requisito y su descripcion
         */
		$assistant_requirements = [];
        for ($i = 0; $i < count($requirements); $i++){
            $assistant_requirements[$i] = [];
            $assistant_requirements[$i]['state'] = $requirements[$i]['_matchingData']['RequestsRequirements']['state'];
            $assistant_requirements[$i]['acepted_inopia'] = $requirements[$i]['_matchingData']['RequestsRequirements']['acepted_inopia'];
            $assistant_requirements[$i]['requirement_number'] = $requirements[$i]['requirement_number'];
            $assistant_requirements[$i]['description'] = $requirements[$i]['description'];
            $assistant_requirements[$i]['type'] = $requirements[$i]['type'];
        }

        // Solicita a la base los requisitos obligatorios
        $requirements = $this->find()->matching('RequestsRequirements', function($q) use($id){
            return $q->select(['RequestsRequirements.state','RequestsRequirements.acepted_inopia'])->where(['RequestsRequirements.request_id' => $id]); 
        })->where(['hour_type' => 'Ambos'])->toArray();

        $general_requirements = [];
        for ($i = 0; $i < count($requirements); $i++){
            $general_requirements[$i] = [];
            $general_requirements[$i]['state'] = $requirements[$i]['_matchingData']['RequestsRequirements']['state'];
            $general_requirements[$i]['requirement_number'] = $requirements[$i]['requirement_number'];
            $general_requirements[$i]['description'] = $requirements[$i]['description'];
            $general_requirements[$i]['type'] = $requirements[$i]['type'];
        }
        

        /*
         * En el array final, los requisitos se separan en opcionales y obligatorios
         */
        $requirements = ['Estudiante' => $student_requirements, 'Asistente' => $assistant_requirements, 'Ambos' => $general_requirements];
		return $requirements;
    }
}
