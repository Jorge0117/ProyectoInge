<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Class Entity
 *
 * @property string $course_id
 * @property int $class_number
 * @property int $semester
 * @property string $year
 * @property bool $state
 * @property string $professor_id
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\Professor $professor
 */
<<<<<<< HEAD
class ClassT extends Entity
=======
class Class extends Entity
>>>>>>> curso-grupo
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'state' => true,
        'professor_id' => true,
        'course' => true,
        'professor' => true
    ];
}
