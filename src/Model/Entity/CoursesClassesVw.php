<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CoursesClassesVw Entity
 *
 * @property string $Sigla
 * @property string $Curso
 * @property int $Grupo
 * @property float $Profesor
 * @property int $Semestre
 * @property string $Año
 * @property int $Creditos
 */
class CoursesClassesVw extends Entity
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
        'Sigla' => true,
        'Curso' => true,
        'Grupo' => true,
        'Profesor' => true,
        'Semestre' => true,
        'Año' => true,
        'Creditos' => true
    ];
}
