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
            $username = $this->request->data['Usuario'];
            $password = $this->request->data['Contraseña'];

            debug($username);
            debug($password);

            $ldapconn = ldap_connect("10.1.4.78", 389);

            $dn = $username . "@ecci.ucr.ac.cr";

            if ($ldapconn) {
                $ldapbind = @ldap_bind($ldapconn, $dn, $password);
                if ($ldapbind) {
                    debug("EXITO!");
                }
                else {
                    debug("Datos invalidos");
                    $this->Flash->error('Datos inválidos', ['key' => 'auth']);
                }
            }
            else {
                debug("No hay conexion");
                $this->Flash->error('No se pudo conectar con el servidor', ['key' => 'auth']);
            }


            die();

            // $user = $this->Auth->identify();

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
