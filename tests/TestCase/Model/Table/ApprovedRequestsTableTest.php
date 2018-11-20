<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApprovedRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApprovedRequestsTable Test Case
 */
class ApprovedRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ApprovedRequestsTable
     */
    public $ApprovedRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.approved_requests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ApprovedRequests') ? [] : ['className' => ApprovedRequestsTable::class];
        $this->ApprovedRequests = TableRegistry::getTableLocator()->get('ApprovedRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ApprovedRequests);

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
