<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InfoRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InfoRequestsTable Test Case
 */
class InfoRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InfoRequestsTable
     */
    public $InfoRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.info_requests'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InfoRequests') ? [] : ['className' => InfoRequestsTable::class];
        $this->InfoRequests = TableRegistry::getTableLocator()->get('InfoRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InfoRequests);

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
