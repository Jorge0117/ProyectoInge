<?php

namespace App\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Http\ServerRequest;
use Cake\Http\Response;

class MyLdapAuthenticate extends BaseAuthenticate
{

    protected function _checkFields(ServerRequest $request, array $fields)
    {
        foreach ([$fields['username'], $fields['password']] as $field) {
            $value = $request->getData($field);
            if (empty($value) || !is_string($value)) {
                return false;
            }
        }
        return true;
    }

    protected function findUser($username)
    {
        $result = $this->_query($username)->first();

        if (empty($result)) {
            return false;
        }

        return $result->toArray();
    }


    public function authenticate(ServerRequest $request, Response $response)
    {

        $fields = $this->_config['fields'];
        if (!$this->_checkFields($request, $fields)) {
            return false;
        }
        
        $username = $request->data['username'];
        $password = $request->data['password'];

        debug($username);
        debug($password);

        // debug($this->request);

        $ldapconn = ldap_connect("10.1.4.78", 389);

        $dn = $username . "@ecci.ucr.ac.cr";

        if ($ldapconn) {
            ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 2);
            $ldapbind = @ldap_bind($ldapconn, $dn, $password);
            debug($ldapbind);
            if ($ldapbind) {
                // Poner aquí código para obtener el usuario!!!!!!

                // ---------------------------------------- //
                debug("EXITO!");
                return $this->findUser($username);
            }
            else {

                if(ldap_get_option($ldapconn, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
                    debug("Error Binding to LDAP: $extended_error");
                    // $this->Flash->error('Datos inválidos');
                } else {
                    debug("Couldn't establish connection");
                    // $this->Flash->error('No se pudo conectar con el servidor');
                    debug("Ignorando contraseña temporalmente");
                    return $this->findUser($username);
                }
                return false;
            }
        }
        else {
            debug("Datos de conexión invalidos");
            return false;
        }
    }
}

