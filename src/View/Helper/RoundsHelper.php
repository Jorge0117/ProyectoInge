<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use App\Model\Table\RoundsTable;

/**
 * Rounds helper
 */
class RoundsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public function getLastRow() {
        return (new RoundsTable)->getLastRow();
    }
}
