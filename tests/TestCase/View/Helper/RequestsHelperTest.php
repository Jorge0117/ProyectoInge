<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\RequestsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\RequestsHelper Test Case
 */
class RequestsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\RequestsHelper
     */
    public $Requests;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Requests = new RequestsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Requests);

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
