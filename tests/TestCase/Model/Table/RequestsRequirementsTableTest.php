<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequestsRequirementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequestsRequirementsTable Test Case
 */
class RequestsRequirementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RequestsRequirementsTable
     */
    public $RequestsRequirements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.requests_requirements',
        'app.requests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RequestsRequirements') ? [] : ['className' => RequestsRequirementsTable::class];
        $this->RequestsRequirements = TableRegistry::getTableLocator()->get('RequestsRequirements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RequestsRequirements);

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
