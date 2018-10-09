<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdministrativeAssistantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdministrativeAssistantsTable Test Case
 */
class AdministrativeAssistantsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdministrativeAssistantsTable
     */
    public $AdministrativeAssistants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.administrative_assistants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AdministrativeAssistants') ? [] : ['className' => AdministrativeAssistantsTable::class];
        $this->AdministrativeAssistants = TableRegistry::getTableLocator()->get('AdministrativeAssistants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AdministrativeAssistants);

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
