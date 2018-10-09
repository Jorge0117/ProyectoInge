<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PermissionsRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PermissionsRolesTable Test Case
 */
class PermissionsRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PermissionsRolesTable
     */
    public $PermissionsRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.permissions_roles',
        'app.permissions',
        'app.roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PermissionsRoles') ? [] : ['className' => PermissionsRolesTable::class];
        $this->PermissionsRoles = TableRegistry::getTableLocator()->get('PermissionsRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PermissionsRoles);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
