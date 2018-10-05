<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Request Entity
 *
 * @property int $id
 * @property int $round_number
 * @property int $round_semester
 * @property int $round_year
 * @property \Cake\I18n\FrozenTime $reception_date
 * @property string $class_year
 * @property string $course_id
 * @property int $class_semester
 * @property int $class_number
 * @property string $student_id
 * @property string $status
 * @property int $another_assistant_hours
 * @property int $another_student_hours
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\Student $student
 */
class Request extends Entity
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
        'round_number' => true,
        'round_semester' => true,
        'round_year' => true,
        'reception_date' => true,
        'class_year' => true,
        'course_id' => true,
        'class_semester' => true,
        'class_number' => true,
        'student_id' => true,
        'status' => true,
        'another_assistant_hours' => true,
        'another_student_hours' => true,
        'course' => true,
        'student' => true
    ];
}
