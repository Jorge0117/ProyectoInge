<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Course Entity
 *
 * @property string $code
 * @property string $name
 * @property int $credits
 *
 * @property \App\Model\Entity\Application[] $applications
 * @property \App\Model\Entity\Class[] $classes
 */
class Course extends Entity
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
        'name' => true,
        'credits' => true,
        'applications' => true,
        'classes' => true
    ];
}
