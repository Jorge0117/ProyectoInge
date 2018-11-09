<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Controller\Exception\SecurityException;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        
        $this->loadComponent('Flash');
        
        // $this->loadComponent('Security');
        $this->loadComponent('Auth',[
            'authorize' => ['Controller'],
            'authenticate' => ['MyLdap'],
            'loginAction' => [
                'controller' => 'Security',
                'action' => 'login',
            ],
            'authError' => 'Ingrese al sistema',
            'flash' => [
                'element' => 'error'
            ],
            'loginRedirect' => [
                'controller' => 'Mainpage',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'controller' => 'Security',
                'action' => 'login'
            ],
            'storage' => 'Session'
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security', ['blackHoleCallback' => 'forceSSL']);

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Security->requireSecure();

        $current_user = $this->Auth->user();
        $this->set('current_user', $current_user);

    }

    public function forceSSL($error = '', SecurityException $exception = null)
    {
        // debug($error);
        // debug($exception);
        // die();
        if ($exception instanceof SecurityException && $exception->getType() === 'secure') {
            return $this->redirect('https://' . env('SERVER_NAME') . Router::url($this->request->getRequestTarget()));
        }

        throw $exception;
    }

    /**
     *  Retorna true si el usuario esta autrorizado a realizar la $action en $module, si no, retorna falso. 
     *
     * @param array $user Current user logged information
     * @return boolean
     */
    public function isAuthorized($user)
    {
        //return true;
        $role_c = new RolesController;
        $action =$this->request->getParam('action');
        $module = $this->request->getParam('controller');
        //debug($module);
        //debug($action);
        return $role_c->is_Authorized($user['role_id'], $module, $action); 
        //return true;
    }
}
