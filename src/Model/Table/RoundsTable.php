<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Rounds Model
 *
 * @property |\Cake\ORM\Association\HasMany $Applications
 *
 * @method \App\Model\Entity\Round get($primaryKey, $options = [])
 * @method \App\Model\Entity\Round newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Round[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Round|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Round|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Round patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Round[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Round findOrCreate($search, callable $callback = null, $options = [])
 */
class RoundsTable extends Table{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('rounds');
        $this->setDisplayField('start_date');
        $this->setPrimaryKey('start_date');

        $this->hasMany('Applications', [
            'foreignKey' => 'round_id'
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
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->requirePresence('total_student_hours', 'create')
            ->notEmpty('total_student_hours');

        $validator
            ->requirePresence('total_student_hours_d', 'create')
            ->notEmpty('total_student_hours_d');

        $validator
            ->requirePresence('total_assistant_hours', 'create')
            ->notEmpty('total_assistant_hours');
        return $validator;
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Llama al procedimiento almacenado creado para insertar rondas
     */
    public function insertRound($start_d,$end_d,$tsh,$tdh,$tah){
        $connet = ConnectionManager::get('default');
        $connet->execute(
            "CALL insert_round('$start_d','$end_d','$tsh','$tdh','$tah')"
        );
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Llama al procedimiento almacenado creado para editar rondas
     */
    public function editRound($start_d,$end_d,$old_start_d,$tsh,$tdh,$tah){
        $connet = ConnectionManager::get('default');
        $connet->execute(
            "CALL update_round('$start_d','$end_d', '$old_start_d', '$tsh', '$tdh', '$tah')"
        );
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Obtiene la última tupla ingresada en rondas.
     */
    public function getLastRow(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute(
        "SELECT * 
            FROM rounds 
            WHERE start_date = (SELECT MAX(start_date) FROM rounds)"
        )->fetchAll('assoc');
        if($query != null){
            return $query[0];
        }
        return null;
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Obtiene la penultima tupla ingresada en rondas.
     */
    public function getPenultimateRow(){
        $last = $this->getLastRow()['start_date'];
        $connet = ConnectionManager::get('default');
        $penultimate = $connet->execute(
            "SELECT * 
            FROM rounds 
            WHERE start_date = (SELECT MAX(start_date)
                                FROM rounds
                                WHERE start_date < '$last')"
        )->fetchAll('assoc');
        if($penultimate != null){
            return $penultimate[0];
        }
        return null;
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Obtiene el día actual.
     */
    public function getToday(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute(
            "SELECT DATE(now())"
        )->fetchAll();
        return $query[0][0];
    }

    /**
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Permite averiguar si el día actual se encuentra entre el periodo de inicio y fin. 
     */
    public function between(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute(
        "SELECT DATE(NOW()) >= (SELECT MAX(start_date) 
                            FROM rounds) AND 
                DATE(NOW()) <= (SELECT MAX(end_date) 
                            FROM rounds)"
        )->fetchAll();
        return $query[0][0];
    } 

    /*public function getStartActualRound(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute("SELECT max(start_date) from rounds;")->fetchAll();
        return $query[0][0];   
    }*/

    /*public function getEndActualRound(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute("SELECT max(end_date) from rounds;")->fetchAll();
        return $query[0][0];   
    }*/




	/**
     * @author Esteban Rojas 
     * 
		Esta funcion obtiene los datos de la ronda que esta activa en el sistema.
		
		@param string $fechaActual  fecha desde la cual se obtiene la ronda activa
		@return array Si no hay ronda activa, entonces el valor retornado será nulo
     */
    public function getActualRound($fechaActual)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from rounds where start_date <= '$fechaActual' AND '$fechaActual'  <= end_date");
        $result = $result->fetchAll('assoc');
        return $result;
    }	
	
	/**
     * @author Esteban Rojas 
     * 
		Esta funcion obtiene la llave de una ronda según el número de ronda, semestre y año.

		@param string $round  
		@param string $semester  
		@param string $year  
		@return array Si hay un número de ronda  del semestre y año especificados, de lo contrario nulo
     */	
	public function getRoundKey($round,$semester,$year){
    $connet = ConnectionManager::get('default');
    $query = $connet->execute(
        "SELECT start_date FROM rounds
		 WHERE round_number = '$round' AND semester = '$semester' AND year = '$year' "
    )->fetchAll();
    return $query;
}
}