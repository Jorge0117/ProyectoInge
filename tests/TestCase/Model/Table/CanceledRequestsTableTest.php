<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CanceledRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CanceledRequestsTable Test Case
 */
class CanceledRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CanceledRequestsTable
     */
    public $CanceledRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.canceled_requests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CanceledRequests') ? [] : ['className' => CanceledRequestsTable::class];
        $this->CanceledRequests = TableRegistry::getTableLocator()->get('CanceledRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CanceledRequests);

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
