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

        return $validator;
    }
    // inserta la ronda correspondiente a la tabla ronda.
    public function insertRound($start_d,$end_d){
        $connet = ConnectionManager::get('default');
        $connet->execute("call insert_round ('$start_d','$end_d')");
    }
    // edita la ronda correspondiente.
    public function editRound($start_d,$end_d,$old_start_d){
        $connet = ConnectionManager::get('default');
        $connet->execute("call update_round ('$start_d','$end_d', $old_start_d)");
    }
    // obtiene la ultima tupla ingresada.
    public function getLastRow(){
        $connet = ConnectionManager::get('default');
        $last = $connet->execute("select * from rounds where start_date = (select MAX(start_date) from rounds)")->fetchAll();
        if($last != null){
            return $last[0];
        }
        return null;
    }

    // obtiene el día actual.
    public function getToday(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute("select now()")->fetchAll();
        return $query[0][0];
    }

    // permite averiguar si el día actual se encuentra entre el periodo de inicio y fin. 
    public function between(){
        $connet = ConnectionManager::get('default');
        $query = $connet->execute("select now() > (select MAX(start_date) from rounds) AND now() < (select MAX(end_date) from rounds)")->fetchAll();
        return $query[0][0];
    }


}
