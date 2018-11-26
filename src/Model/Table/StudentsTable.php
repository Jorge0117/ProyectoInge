<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Students Model
 *
 * @property \App\Model\Table\ApplicationsTable|\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\RequestsTable|\Cake\ORM\Association\HasMany $Requests
 * @property \App\Model\Table\RequestsBackupTable|\Cake\ORM\Association\HasMany $RequestsBackup
 *
 * @method \App\Model\Entity\Student get($primaryKey, $options = [])
 * @method \App\Model\Entity\Student newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Student[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Student[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student findOrCreate($search, callable $callback = null, $options = [])
 */
class StudentsTable extends Table
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

        $this->setTable('students');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey('user_id');

        $this->hasMany('Applications', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('Requests', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('RequestsBackup', [
            'foreignKey' => 'student_id'
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

        $validator
            ->scalar('carne')
            ->maxLength('carne', 6)
            ->requirePresence('carne', 'create')
            ->notEmpty('carne');

        return $validator;
    }

    public function addStudent($id, $carne){
        $connect = ConnectionManager::get('default');
        if(preg_match("/\w\d{5}/", $carne) && preg_match("/\d+/", $id)){
            $connect->execute("INSERT INTO students (`user_id`, `carne`) VALUES ('$id', '$carne');") ;
        }
        
    }

    public function deleteStudent($id){
        $connect = ConnectionManager::get('default');
        $return = -1;
        if(preg_match("/\d+/", $id)){
            $connect->execute("DELETE from students where user_id = '$id';") ;
            $return = 1;
        }
        return $return;
    }

    /**
     * Modifica el ponderado de un estudiante.
     * 
     * @author Kevin Jiménez <kevinja9608@gmail.com>
     * @param String $id Identificador del estudiante
     * @param Float $average Ponderado del estudiante
     * @return Boolv Verdadero si se completo correctamente, falso en otro caso.
     */
    public function saveAverage($id, $average){
       $student = $this->get($id);
       $student->average = $average;
       return $this->save($student);
    }

    /**
     * Retorna el ponderado de un estudiante.
     * 
     * @author Kevin Jiménez <kevinja9608@gmail.com>
     * @param String $id Identificador del estudiante
     * @return float Ponderado del estudiante, 0 si no se la ha asignado uno.
     */
    public function getAverage($id){
        return $this->get($id)->average;
    }
}
