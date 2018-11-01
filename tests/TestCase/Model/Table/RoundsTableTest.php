<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RoundsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoundsTable Test Case
 */
class RoundsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RoundsTable
     */
    public $Rounds;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rounds'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Rounds') ? [] : ['className' => RoundsTable::class];
        $this->Rounds = TableRegistry::getTableLocator()->get('Rounds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rounds);

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
     * Test insertRound method
     *
     * @return void
     */
    public function testInsertRound()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test editRound method
     *
     * @return void
     */
    public function testEditRound()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getLastRow method
     *
     * @return void
     */
    public function testGetLastRow()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getPenultimateRow method
     *
     * @return void
     */
    public function testGetPenultimateRow()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getToday method
     *
     * @return void
     */
    public function testGetToday()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test between method
     *
     * @return void
     */
    public function testBetween()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test active method
     *
     * @return void
     */
    public function testActive()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
