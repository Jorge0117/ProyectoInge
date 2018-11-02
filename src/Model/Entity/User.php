<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


/**
 * User Entity
 *
 * @property string $identification_number
 * @property string $identification_type
 * @property string $name
 * @property string $lastname1
 * @property string $lastname2
 * @property string $username
 * @property string $email_personal
 * @property string $phone
 * @property string $role_id
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\AdministrativeAssistant[] $administrative_assistants
 * @property \App\Model\Entity\AdministrativeBoss[] $administrative_bosses
 * @property \App\Model\Entity\Professor[] $professors
 * @property \App\Model\Entity\Student[] $students
 */
class User extends Entity
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
        'identification_number' => true,
        'identification_type' => true,
        'name' => true,
        'lastname1' => true,
        'lastname2' => true,
        'username' => true,
        'email_personal' => true,
        'phone' => true,
        'role_id' => true,
        'role' => true,
        'administrative_assistants' => true,
        'administrative_bosses' => true,
        'professors' => true,
        'students' => true
    ];
}
