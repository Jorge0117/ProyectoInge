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
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                debug("No se logro autenticar");
            }

        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }



}
