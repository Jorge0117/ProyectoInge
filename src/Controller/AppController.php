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
use Cake\Core\Configure;

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
        
        /**
         * Authentication component.
         * 
         * Controla la autenticación por medio del LDAP
         * de la ECCI.
         * @author Daniel Díaz
         */
        $this->loadComponent('Auth',[
            'authorize' => ['Controller'],
            'authenticate' => ['MyLdap'],
            'loginAction' => [
                'controller' => 'Security',
                'action' => 'login',
            ],
            'authError' => 'No tiene permisos para ingresar a esta pagina.',
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
         * 
         * Redirige los requests al método forceSSL si no usan conexión segura
         */
        $this->loadComponent('Security', ['blackHoleCallback' => 'forceSSL']);

    }

    /**
     * Este método corre antes de ejecutar las acciones de cualquier controlador.
     * 
     * Opciones para todos los controladores y variables accesibles desde cualquier vista.
     */
    public function beforeFilter(Event $event)
    {
        /**
         * Obliga al servidor a establecer una conexión segura.
         */
        parent::beforeFilter($event);
        $this->Security->requireSecure();

        /**
         * Información del usuario actual accesible desde las vistas. 
         */
        $current_user = $this->Auth->user();
        $this->set('current_user', $current_user);

        /** 
         *  @author Daniel Marín <110100010111h@gmail.com>
         * 
         *  Convierte los datos de ronda en una variable global para evitar conexiones repetitivas a la base de datos
         */
        if(!$current_user){
            $this->loadModel('Rounds');
            $roundData = $this->Rounds->getLastRow();
            $this->set(compact('roundData'));
            $this->getRequest()->getSession()->write('roundData',$roundData);
        }else{
            $roundData = $this->getRequest()->getSession()->read('roundData');
            $this->set(compact('roundData'));
        }

    }

    /**
     * Forzar conexión segura (SSL), y redigir páginas a https automáticamente.
     * 
     * Captura excepciones de seguridad, si se deben a una conexión insegura
     * (por medio de http) redirecciona a la misma URL con https. De lo contrario
     * vuelve a levantar la excepción.
     * 
     * @author Daniel Díaz
     * 
     * @param string error Tipo de error
     * @param SecurityException exception Excepción  de seguridad que causó el llamado del método.
     */
    public function forceSSL($error = '', SecurityException $exception = null)
    {
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
        $role_c = new RolesController;
        $action =$this->request->getParam('action');
        $module = $this->request->getParam('controller');
        
        if(!$role_c->is_Authorized($user['role_id'], $module, $action)){
            debug("Si le aparecio este mensaje es por que, posiblemente, los permisos de esta accion (".$module.'-'.$action.
              ") no estan en la base, o simplemente el rol [".$user['role_id']."] no lo tiene.\n Solución:\n".
              "\t1) Verifique que el rol del usuario con el que esta logueado deba tener este permiso.\n".
              "\t2) En caso de que si lo deba tener, o bien sea una accion nueva, mandarle a kevin un mensaje con el siguiente formato:\n". 
              "\t\tRol(es): [Rol(es) que debe(n) tener este permiso]\n".
              "\t\tDescripción: [Descripción de la acción]\n".
              "\t\tAcción: ".$module.'-'.$action);
            die();
        }
        return $role_c->is_Authorized($user['role_id'], $module, $action); 
    }
}
