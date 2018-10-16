<?php

namespace App\Controller;


namespace App\Auth;

use Cake\Auth\BaseAuthorize;
use Cake\Http\ServerRequest;
use Cake\Controller\Component;
use App\Controller\RolesController;

class MyLdapAuthorize extends BaseAuthorize
{
    public function authorize($user, ServerRequest $request)
    {
        $Roles_c = new RolesController;
        return $Roles_c->is_Authorized($user['role_id'], $request->getAttribute('here'));
    }   
}
