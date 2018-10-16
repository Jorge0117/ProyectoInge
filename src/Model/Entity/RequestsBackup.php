<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequestsBackup Entity
 *
 * @property string $student_id
 * @property string $course_id
 * @property string $class_id
 * @property string $requests_backupcol
 * @property int $another_student_hours
 * @property int $another_assistant_hours
 * @property bool $first_time
 * @property bool $has_another_hours
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\Class $class
 */
class RequestsBackup extends Entity
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
        'course_id' => true,
        'class_id' => true,
        'requests_backupcol' => true,
        'another_student_hours' => true,
        'another_assistant_hours' => true,
        'first_time' => true,
        'has_another_hours' => true,
        'course' => true,
        'class' => true
    ];
}
