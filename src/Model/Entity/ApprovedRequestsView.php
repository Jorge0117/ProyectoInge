<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ApprovedRequestsView Entity
 *
 * @property int $id
 * @property string $carne
 * @property float $nombre
 * @property string $anno
 * @property int $semestre
 * @property string $curso
 * @property int $grupo
 * @property string $tipo_hora
 * @property int $hour_ammount
 * @property string $id_prof
 */
class ApprovedRequestsView extends Entity
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
        'id' => true,
        'carne' => true,
        'nombre' => true,
        'anno' => true,
        'semestre' => true,
        'curso' => true,
        'grupo' => true,
        'tipo_hora' => true,
        'hour_ammount' => true,
        'id_prof' => true
    ];
}
