<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Classes Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 * @property \App\Model\Table\ProfessorsTable|\Cake\ORM\Association\BelongsTo $Professors
 *
 * @method \App\Model\Entity\Class get($primaryKey, $options = [])
 * @method \App\Model\Entity\Class newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Class[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Class|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Class|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Class patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Class[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Class findOrCreate($search, callable $callback = null, $options = [])
 */
class ClassesTable extends Table
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

        $this->setTable('classes');
        $this->setDisplayField('course_id');
        $this->setPrimaryKey(['course_id', 'class_number', 'semester', 'year']);

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Professors', [
            'foreignKey' => 'professor_id'
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
            ->allowEmpty('class_number', 'create');

        $validator
            ->allowEmpty('semester', 'create');

        $validator
            ->scalar('year')
            ->allowEmpty('year', 'create');

        $validator
            ->boolean('state')
            ->allowEmpty('state');

        return $validator;
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
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        $rules->add($rules->existsIn(['professor_id'], 'Professors'));

        return $rules;
    }

    public function addClass($id, $number, $semester, $year, $state, $profId )
    {
        $return = false;
        $connect = ConnectionManager::get('default');

        $inTable = count($connect->execute("select * from classes where course_id = '$id' and class_number = '$number' and semester = '$semester' and year = '$year'"));

        if ($inTable == 0) {
            $connect->execute("call addClass('$id', '$number', '$semester', '$year', '$state', '$profId')");
            $return = true;
        }
        return $return;
    }


    public function deleteClass($code, $class_number, $semester, $year)
    {
        //------------------------------------------------
        $result = true;
        //------------------------------------------------
        $connection = ConnectionManager::get('default');
        //------------------------------------------------
        $result = $connection->execute(
            "DELETE FROM classes 
            WHERE   course_id       = '$code' 
                AND class_number    = $class_number
                AND semester        = $semester
                AND year            = '$year';
            "
        );
        //------------------------------------------------
        return $result;
    }

    /**
     * Fetch all row that match with the given attributes.
     */
    public function fetchAllClasses($code = null, $semester = null, $year = null)
    {
        //------------------------------------------------
        $result = -1;
        //------------------------------------------------
        $connection = ConnectionManager::get('default');
        //------------------------------------------------
        $result = $this->$classes
            ->find('all')
            ->where(
                [
                    'course_id' => $code,
                    'semester'  => $semester,
                    'year'      => $year
                ]
            )
            ->toArray()
        ;
        // $result = $connection->execute(
        //     "SELECT 
        //     FROM classes C
        //     WHERE   C.course_id = '$code'
        //         AND C.semester  = $semester
        //         AND C.year      = $year
        //     "
        // );
        //------------------------------------------------
        return $result;
    }

    public function deleteAllClasses()
    {
        //------------------------------------------------
        $result = true;
        //------------------------------------------------
        $connection = ConnectionManager::get('default');
        //------------------------------------------------
        $result = $connection->execute(
            "DELETE FROM classes"
        );
        //------------------------------------------------
        return $result;
    }


    public function updateClass($code, $class_number, $semester, $year, $new_course_id, $new_class_number, $new_semester, $new_year,$new_user_id)
    {
        //------------------------------------------------
        $result = true;
        //------------------------------------------------
        $connection = ConnectionManager::get('default');
        //------------------------------------------------
        $result = $connection->execute(
            "UPDATE classes 
            SET 
                course_id           = '$new_course_id',
                class_number        = $new_class_number,
                semester            = $new_semester,
                year                = $new_year,
                professor_id        = '$new_user_id'
            WHERE   course_id       = '$code' 
                AND class_number    = '$class_number'
                AND semester        = '$semester'
                AND year            = '$year';
            "
        );
        //------------------------------------------------
        return $result;
    }
}
