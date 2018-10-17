<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PermissionsRolesFixture
 *
 */
class PermissionsRolesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'permission_id' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'role_id' => ['type' => 'string', 'length' => 24, 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'permission_id' => ['type' => 'index', 'columns' => ['permission_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['role_id', 'permission_id'], 'length' => []],
            'permissions_roles_ibfk_1' => ['type' => 'foreign', 'columns' => ['role_id'], 'references' => ['roles', 'role_id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'permissions_roles_ibfk_2' => ['type' => 'foreign', 'columns' => ['permission_id'], 'references' => ['permissions', 'permission_id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'permission_id' => 'ffa805bd-8491-476a-881b-a510b242720e',
                'role_id' => '94775330-a598-4989-a3ca-15fcdccc0948'
            ],
        ];
        parent::init();
    }
}
