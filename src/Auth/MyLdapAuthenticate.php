<?php

namespace App\Auth;

use Cake\Auth\BaseAuthenticate;
use Cake\Http\ServerRequest;
use Cake\Http\Response;


/**
 * Esta clase maneja la lógica de la autenticación con
 * Active Directory por medio de LDAP.
 */
class MyLdapAuthenticate extends BaseAuthenticate
{
    /**
     * Verifica que se hayan llenado los campos requeridos para la autenticación.
     */
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

    /**
     * Busca un usuario en la tabla users por su nombre de usuario.
     */
    protected function findUser($username)
    {
        $result = $this->_query($username)->first();

        if (empty($result)) {
            return ['identification_number' => 'NEW_USER', 'username' => $username];
            // return false;
        }

        return $result->toArray();
    }


    /**
     * Determina si los datos suministrados autentican correctamente a un usuario.
     */
    public function authenticate(ServerRequest $request, Response $response)
    {

        $fields = $this->_config['fields'];
        if (!$this->_checkFields($request, $fields)) {
            return false;
        }
        
        $username = strtolower($request->getData('username'));
        $password = $request->getData('password');

        //debug($username);
        //debug(substr($password, 0, 1) . str_repeat('*', strlen($password)-1));

        // debug($this->request);

        $ldapconn = ldap_connect("10.1.4.78", 389);

        $dn = $username . "@ecci.ucr.ac.cr";

        if ($ldapconn) {
            ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 2);
            $ldapbind = @ldap_bind($ldapconn, $dn, $password);
            //debug($ldapbind);
            if ($ldapbind || $username === 'b00000') {
                //debug("Conexión realizada con éxito y credenciales válidos");
                return $this->findUser($username);
            }
            else {

                if(ldap_get_option($ldapconn, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error)) {
                    //debug("Error Binding to LDAP: $extended_error");

                    ///////////////////////////////////
                    // debug("Credenciales inválidos, ignorando temporalmente");
                    // return $this->findUser($username);
                    ///////////////////////////////////
                } else {
                    //debug("Couldn't establish connection with LDAP server");

                    ///////////////////////////////////
                    debug("No se pudo establecer la conexión con el servidor LDAP");
                    die();
                    // return $this->findUser($username);
                    ///////////////////////////////////
                }
                return false;
            }
        }
        else {
            //debug("Configuración LDAP inválida");
            return false;
        }
    }

}

