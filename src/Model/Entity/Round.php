<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Round Entity
 *
 * @property int $number
 * @property int $semester
 * @property int $year
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property \Cake\I18n\FrozenTime $approve_limit_date
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
        'approve_limit_date' => true
    ];
}
