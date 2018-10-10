<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Security Controller
 *
 */
class SecurityController extends AppController
{


    public function login()
    {
                

        if($this->request->is('post'))
        {
            
            $user = $this->Auth->identify();
            if($user)
            {
                debug("Se logro autenticar");

                if ($user['identification_number'] == 'NEW_USER') {
                    // Caso en que los credenciales fueron válidos pero el usuario no existe!
                    // Cambiar la siguiente línea por la accion de agregar usuario
                    $this->redirect(['controller' => 'Security', 'action' => 'register', $user['username']]);

                } else {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            } else {
                debug("No se logro autenticar");
            }

        }
    }

    public function register(string $username)
    {
        debug('Se ingresaron datos válidos para ' . $username . ' pero el usuario no existe en la BD');
        debug('Sustituir por llamado a User add');
        die();
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }



}
