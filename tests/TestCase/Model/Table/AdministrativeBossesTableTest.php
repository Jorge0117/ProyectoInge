<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdministrativeBossesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdministrativeBossesTable Test Case
 */
class AdministrativeBossesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdministrativeBossesTable
     */
    public $AdministrativeBosses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.administrative_bosses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdministrativeBosses') ? [] : ['className' => AdministrativeBossesTable::class];
        $this->AdministrativeBosses = TableRegistry::getTableLocator()->get('AdministrativeBosses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdministrativeBosses);

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
}
