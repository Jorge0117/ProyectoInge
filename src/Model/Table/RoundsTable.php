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
class RoundsTable extends Table
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
            ->requirePresence('total_assistant_hours', 'create')
            ->notEmpty('total_assistant_hours');
        return $validator;
    }
  // inserta la ronda correspondiente a la tabla ronda.
  public function insertRound($start_d,$end_d,$tsh,$tah){
    $connet = ConnectionManager::get('default');
    $connet->execute(
        "CALL insert_round('$start_d','$end_d','$tsh','$tah')"
    );
}
// edita la ronda correspondiente.
public function editRound($start_d,$end_d,$old_start_d,$tsh,$tah){
    $connet = ConnectionManager::get('default');
    $connet->execute(
        "CALL update_round('$start_d','$end_d', '$old_start_d', '$tsh', '$tah')"
    );
}
// obtiene la ultima tupla ingresada.
public function getLastRow(){
    $connet = ConnectionManager::get('default');
    $last = $connet->execute(
       "SELECT * 
        FROM rounds 
        WHERE start_date = (SELECT MAX(start_date)
                            FROM rounds)"
    )->fetchAll();
    if($last != null){
        return $last[0];
    }
    return null;
}

public function getPenultimateRow(){
    $last = $this->getLastRow()[0];
    $connet = ConnectionManager::get('default');
    $penultimate = $connet->execute(
        "SELECT * 
         FROM rounds 
         WHERE start_date = (SELECT MAX(start_date)
                             FROM rounds
                             WHERE start_date < '$last')"
     )->fetchAll();
    if($penultimate != null){
        return $penultimate[0];
    }
    return null;
}

// obtiene el día actual.
public function getToday(){
    $connet = ConnectionManager::get('default');
    $query = $connet->execute(
        "SELECT DATE(now())"
    )->fetchAll();
    return $query[0][0];
}

// permite averiguar si el día actual se encuentra entre el periodo de inicio y fin. 
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

public function active(){
    $connet = ConnectionManager::get('default');
    $query = $connet->execute(
       "SELECT DATE(NOW()) <= (SELECT MAX(end_date) 
                        FROM rounds)"
    )->fetchAll();
    return $query[0][0];
} 

    public function getStartActualRound(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute("SELECT max(start_date) from rounds;")->fetchAll();
        return $query[0][0];   
    }



    //Autor: Esteban Rojas
	//Esta funcion obtiene los datos de la ronda que esta activa en el sistema. Dado que los tiempos entre rondas no se traslapan 
	//entonces esta función obtiene como máximo una sola tupla de rondas.
	//Si no hay ninguna ronda activa, entonces retorna un vector vacio.
	//Recordar referenciar los atributos de la ronda con [0]['campo']
    public function getActualRound($fechaActual)
    {
        $connet = ConnectionManager::get('default');
        $result = $connet->execute("select * from rounds where start_date <= '$fechaActual' AND '$fechaActual'  <= end_date");
        $result = $result->fetchAll('assoc');
        return $result;
    }
    
     //obtiene la ultima ronda creada.
     public function getLastRound() {
        $last = $this->getLastRow();
        $dsh = (int)$last[5]-(int)$last[7];
        $dah = (int)$last[6]-(int)$last[8];

        if($last!= null){
            return [
                "Ronda #" . $last[2] .' '. $last[3] . '-' . substr($last[4], -2),
                "Del: " . substr($last[0], 5).
                " al: " . substr($last[1], 5),
                "HE-ECCI: ".(string)$dsh,
                "HA-ECCI: ".(string)$dah
            ]; 
        }
        return "";
    }
	
}