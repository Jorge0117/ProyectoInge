<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Security Controller
 * Este controlador se encarga de autenticar los usuarios del sistema.
 * Se apoya en el componente MyLdapAuthenticate para manejar la verificación de
 * credenciales con la red de la ECCI 
 * 
 * @author Daniel Díaz
 */
class SecurityController extends AppController
{


    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('logout');
    }

    /**
     * Pantalla de login que autentica a los usuarios. Si un usuario ingresa
     * datos válidos pero no se encuentra en la Base de Datos se redirige a
     * la pantalla de registrarse.
     * 
     * @author Daniel Díaz
     */
    public function login()
    {
        // Si el usuario ya ingresó redirigir al menú principal;
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if($this->request->is('post'))
        {
            
            $user = $this->Auth->identify();
            if($user)
            {
                if ($user['identification_number'] == 'NEW_USER') {
                    // Caso en que los credenciales fueron válidos pero el usuario no existe!
                    // Cambiar la siguiente línea por la accion de agregar usuario
                    $this->getRequest()->getSession()->write('NEW_USER', $user['username']);
                    return $this->redirect(['controller' => 'Users', 'action' => 'register', $user['username']]);

                } else {
                    $this->Auth->setUser($user);

                    $request_c = new RequestsController;
                    if ($user['role_id'] === 'Estudiante') {
                        $request_c->updateMessageVariable(1);
                    }
                    
                    return $this->redirect($this->Auth->redirectUrl());
                }
            } else {
                $this->Flash->error('Credenciales inválidos.');
            }

        }

    }

    /**
     * Limpia la sesión activa.
     * @author Daniel Díaz
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
