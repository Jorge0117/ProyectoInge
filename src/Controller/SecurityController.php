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
        $this->set('Variable1', 'holamundo');

        

        if($this->request->is('post'))
        {
            
            debug("hola");
            $user = $this->Auth->identify();

            if($user)
            {
                debug("Se logro autenticar");
            } else {
                debug("No se logro autenticar");
            }

            // debug($this->Auth);
            // die();

            // debug($user);
            // if($user)
            // {
            //     die();
            //     $this->Auth->setUser($user);
            //     return $this->redirect($this->Auth->redirectUrl());

            // }
            // else
            // {
                
            // }
        }
    }

    public function logout()
    {

    }



}
