<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Mainpage Controller
 *
 *
 * @method \App\Model\Entity\Mainpage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MainpageController extends AppController
{
    var $uses = false;

    public function initialize() {
        parent::initialize();
        $this->modelClass = false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('active_menu', 'MenubarInicio');
        
    }
}
