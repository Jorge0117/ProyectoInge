<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Requests cell
 */
class RequestsCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
		//$m = $this->loadModel("Requests")->getRequests();
		//debug($m);
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
    }
}
