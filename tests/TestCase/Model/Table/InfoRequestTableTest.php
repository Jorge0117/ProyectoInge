<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InfoRequestTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InfoRequestTable Test Case
 */
class InfoRequestTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InfoRequestTable
     */
    public $InfoRequest;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.info_request'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InfoRequest') ? [] : ['className' => InfoRequestTable::class];
        $this->InfoRequest = TableRegistry::getTableLocator()->get('InfoRequest', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InfoRequest);

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
