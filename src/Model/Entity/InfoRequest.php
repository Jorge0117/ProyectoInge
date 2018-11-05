<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InfoRequest Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $fecha
 * @property string $cedula
 * @property string $carne
 * @property string $nombre
 * @property float $promedio
 * @property string $anno
 * @property int $semestre
 * @property string $curso
 * @property int $grupo
 * @property \Cake\I18n\FrozenDate $inicio
 * @property string $ronda
 * @property string $estado
 * @property bool $otras_horas
 * @property string $id_prof
 */
class InfoRequest extends Entity
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
        'fecha' => true,
        'cedula' => true,
        'carne' => true,
        'nombre' => true,
        'promedio' => true,
        'anno' => true,
        'semestre' => true,
        'curso' => true,
        'grupo' => true,
        'inicio' => true,
        'ronda' => true,
        'estado' => true,
        'otras_horas' => true,
        'id_prof' => true
    ];
}
