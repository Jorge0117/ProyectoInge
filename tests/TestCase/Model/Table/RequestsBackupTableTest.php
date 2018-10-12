<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequestsBackupTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequestsBackupTable Test Case
 */
class RequestsBackupTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RequestsBackupTable
     */
    public $RequestsBackup;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.requests_backup',
        'app.courses',
        'app.classes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RequestsBackup') ? [] : ['className' => RequestsBackupTable::class];
        $this->RequestsBackup = TableRegistry::getTableLocator()->get('RequestsBackup', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequestsBackup);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
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
