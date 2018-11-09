<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ApprovedRequestsViewTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ApprovedRequestsViewTable Test Case
 */
class ApprovedRequestsViewTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ApprovedRequestsViewTable
     */
    public $ApprovedRequestsView;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.approved_requests_view'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ApprovedRequestsView') ? [] : ['className' => ApprovedRequestsViewTable::class];
        $this->ApprovedRequestsView = TableRegistry::getTableLocator()->get('ApprovedRequestsView', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ApprovedRequestsView);

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
