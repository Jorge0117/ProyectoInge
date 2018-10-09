<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Student Entity
 *
 * @property string $user_id
 * @property string $carne
 *
 * @property \App\Model\Entity\Application[] $applications
 * @property \App\Model\Entity\Request[] $requests
 * @property \App\Model\Entity\RequestsBackup[] $requests_backup
 */
class Student extends Entity
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
        'carne' => true,
        'applications' => true,
        'requests' => true,
        'requests_backup' => true
    ];
}
