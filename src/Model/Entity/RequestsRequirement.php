<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RequestsRequirement Entity
 *
 * @property int $requirement_number
 * @property int $request_id
 * @property string $state
 *
 * @property \App\Model\Entity\Request $request
 */
class RequestsRequirement extends Entity
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
        'request' => true
    ];
}
