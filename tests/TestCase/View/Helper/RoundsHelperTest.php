<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\RoundsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\RoundsHelper Test Case
 */
class RoundsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\RoundsHelper
     */
    public $Rounds;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Rounds = new RoundsHelper($view);
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
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
