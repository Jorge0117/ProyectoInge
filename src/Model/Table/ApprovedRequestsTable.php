<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ApprovedRequests Model
 *
 * @method \App\Model\Entity\ApprovedRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\ApprovedRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ApprovedRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ApprovedRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApprovedRequest|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ApprovedRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovedRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ApprovedRequest findOrCreate($search, callable $callback = null, $options = [])
 */
class ApprovedRequestsTable extends Table
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

        $this->setTable('approved_requests');
        $this->setDisplayField('request_id');
        $this->setPrimaryKey('request_id');
        $this->belongsTo('Requests')
            ->setForeignKey('request_id');
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
            ->integer('request_id')
            ->allowEmpty('request_id', 'create');

        $validator
            ->scalar('hour_type')
            ->requirePresence('hour_type', 'create')
            ->notEmpty('hour_type');

        $validator
            ->requirePresence('hour_ammount', 'create')
            ->notEmpty('hour_ammount');

        return $validator;
    }

    public function getAsignedHours($student_id){
        $student_hours_by_student = $this->find('all')->matching('Requests', function ($q) use ($student_id) {
            return $q->where(['ApprovedRequests.hour_type' => 'HEE', 'student_id' => $student_id]);
        })->select(['count' => $this->find()->func()->sum('hour_ammount')])->toArray();

        $student_doc_hours_by_student = $this->find('all')->matching('Requests', function ($q) use ($student_id) {
            return $q->where(['ApprovedRequests.hour_type' => 'HED', 'student_id' => $student_id]);
        })->select(['count' => $this->find()->func()->sum('hour_ammount')])->toArray();

        $assistant_hours_by_student = $this->find('all')->matching('Requests', function ($q) use ($student_id) {
            return $q->where(['ApprovedRequests.hour_type' => 'HAE', 'student_id' => $student_id]);
        })->select(['count' => $this->find()->func()->sum('hour_ammount')])->toArray();
        
        return ['HEE' => $student_hours_by_student[0]['count'] == null? 0: $student_hours_by_student[0]['count'], 
                'HED' => $student_doc_hours_by_student[0]['count'] == null? 0: $student_doc_hours_by_student[0]['count'],
                'HAE' => $assistant_hours_by_student[0]['count'] == null? 0: $assistant_hours_by_student[0]['count']];
    }

    public function getThisRequestAsignedHours($request_id){
        $request_hours = $this->get($request_id);
        return [$request_hours->hour_type => $request_hours->hour_ammount];
    }
}
