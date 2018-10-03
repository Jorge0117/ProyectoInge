<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CoursesClassesVw Model
 *
 * @method \App\Model\Entity\CoursesClassesVw get($primaryKey, $options = [])
 * @method \App\Model\Entity\CoursesClassesVw newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CoursesClassesVw[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CoursesClassesVw|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CoursesClassesVw|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CoursesClassesVw patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CoursesClassesVw[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CoursesClassesVw findOrCreate($search, callable $callback = null, $options = [])
 */
class CoursesClassesVwTable extends Table
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

        $this->setTable('courses_classes_vw');
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
            ->scalar('Sigla')
            ->maxLength('Sigla', 7)
            ->requirePresence('Sigla', 'create')
            ->notEmpty('Sigla');

        $validator
            ->scalar('Curso')
            ->maxLength('Curso', 255)
            ->allowEmpty('Curso');

        $validator
            ->requirePresence('Grupo', 'create')
            ->notEmpty('Grupo');

        $validator
            ->numeric('Profesor')
            ->allowEmpty('Profesor');

        $validator
            ->requirePresence('Semestre', 'create')
            ->notEmpty('Semestre');

        $validator
            ->scalar('Año')
            ->requirePresence('Año', 'create')
            ->notEmpty('Año');

        return $validator;
    }
}
