<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApprovedRequest Entity
 *
 * @property int $request_id
 * @property string $hour_type
 * @property int $hour_ammount
 */
class ApprovedRequest extends Entity
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
        'hour_type' => true,
        'hour_ammount' => true
    ];
}
