<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
//use\ORM\TableRegistry;

/**
 * Courses Model
 *
 * @property \App\Model\Table\ApplicationsTable|\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\ClassesTable|\Cake\ORM\Association\HasMany $Classes
 *
 * @method \App\Model\Entity\Course get($primaryKey, $options = [])
 * @method \App\Model\Entity\Course newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Course[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Course|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Course[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Course findOrCreate($search, callable $callback = null, $options = [])
 */
class CoursesTable extends Table
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

        $this->setTable('courses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('code');

        $this->hasMany('Applications', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Classes', [
            'foreignKey' => 'course_id'
        ]);
    }
    //Agrega el curso a la base si no está
    public function addCourse($courseCode, $courseName)
    {
        $return = false;
        $connect = ConnectionManager::get('default');

        //Verifica que no esté el curso en la tabla
        $inTable = count($connect->execute("select code from courses where code = '$courseCode'"));

        if ($inTable == 0) {
            $connect->execute("call addCourse('$courseCode', '$courseName')");
            $return = true;
        }
        return $return;
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
            ->scalar('code')
            ->maxLength('code', 7)
            ->notEmpty('code')
            ->add('code', 'validFormat',[
                'rule' => '/^[A-Z]{2}[0-9]{4}$/i',
                'message' => 'El formato de curso no es correcto'
            ]);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmpty('name');

        $validator
            ->allowEmpty('credits');

        return $validator;
    }
    
    public function selectACourseCodeFromName($name)
    {
        $connection = $connection = ConnectionManager::get('default');
        return $name;
        // return $connection->execute(
        //     "SELECT code FROM courses WHERE name = '$name'"
        // );
    }
}
