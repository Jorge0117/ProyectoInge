<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Round Entity
 *
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 * @property string $round_number
 * @property string $semester
 * @property string $year
 * @property int $total_student_hours
 * @property int $total_assistant_hours
 * @property int $actual_student_hours
 * @property int $actual_assistant_hours
 */
class Round extends Entity
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
        'start_date' => true,
        'end_date' => true,
        'total_student_hours' => true,
        'total_assistant_hours' => true,
    ];
}
