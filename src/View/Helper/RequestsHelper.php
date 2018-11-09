<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use App\Model\Table\RequestsTable;
/**
 * Requests helper
 */
class RequestsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public function getApproved($id)
    {
        return (new RequestsTable)->getApproved($id);
    }
}
