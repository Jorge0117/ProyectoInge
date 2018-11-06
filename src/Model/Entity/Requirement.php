<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Requirement Entity
 *
 * @property int $requirement_number
 * @property string $description
 * @property string $type
 *
 * @property \App\Model\Entity\FulfillsRequirement[] $fulfills_requirement
 */
class Requirement extends Entity
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
        'description' => true,
        'type' => true,
        'hour_type' => true,
        'fulfills_requirement' => true
    ];
}
