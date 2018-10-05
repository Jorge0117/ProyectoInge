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

        // debug("holi");

        if($this->request->is('post'))
        {
            $user = $this->Auth->identify();
            debug($user);
            if($user)
            {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());

            }
            else
            {
                $this->Flash->error('Datos inválidos', ['key' => 'auth']);
            }
        }

    }

    public function logout()
    {

    }



}
