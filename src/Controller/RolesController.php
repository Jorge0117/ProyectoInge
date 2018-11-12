<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{
    /**
     * Index method.
     *
     * @return \Cake\Http\Response|void
     */
    public function edit()
    {
        $this->loadModel('Permissions');
        $this->loadModel('PermissionsRoles');

        $roles_array = $this->Roles->find('list');
        $this->set(compact('roles_array'));

        // Administrator permissions
        $administrator_permissions = $this->Permissions->getPermissions('Administrador');
        $this->set(compact('administrator_permissions'));

        // Assistant permissions
        $assistant_permissions = $this->Permissions->getPermissions('Asistente');
        $this->set(compact('assistant_permissions'));

        // Student permissions
        $student_permissions = $this->Permissions->getPermissions('Estudiante');
        $this->set(compact('student_permissions'));
 
        // Professor permissions
        $professor_permissions = $this->Permissions->getPermissions('Profesor');
        $this->set(compact('professor_permissions'));

        $all_permissions_by_module = $this->Permissions->getAllPermissionsByModule();
        $this->set(compact('all_permissions_by_module'));

        // Manejo la solicitud del cliente
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $completed = true;
            if(array_key_exists('AceptarAdministrador',$data)){
                unset($data['AceptarAdministrador']);
                $permissions_to_add = array_diff_key($data, $administrator_permissions);
                $permissions_to_delete = array_diff_key($administrator_permissions, $data);
                unset($permissions_to_delete['Roles-edit']);
                unset($permissions_to_delete['Mainpage-index']);

                foreach ($permissions_to_add as $permission => $value) {
                    $permission_to_add = $this->PermissionsRoles->newEntity();
                    $permission_to_add->permission_id = $permission;
                    $permission_to_add->role_id= 'Administrador';
                    if(!$this->PermissionsRoles->save($permission_to_add)){
                        $complete = false;
                    }
                }

                foreach ($permissions_to_delete as $permission => $value) {
                    $permission_to_delete = $this->PermissionsRoles->get(
                        ['role_id' => 'Administrador',
                            'permission_id' => $permission]);
                    if(!$this->PermissionsRoles->delete($permission_to_delete)){
                        $complete = false;
                    }
                }
                
            }else if(array_key_exists('AceptarEstudiante',$data)){
                unset($data['AceptarEstudiante']);
                $permissions_to_add = array_diff_key($data, $student_permissions);
                $permissions_to_delete = array_diff_key($student_permissions, $data);
                unset($permissions_to_delete['Mainpage-index']);

                foreach ($permissions_to_add as $permission => $value) {
                    $permission_to_add = $this->PermissionsRoles->newEntity();
                    $permission_to_add->permission_id = $permission;
                    $permission_to_add->role_id= 'Estudiante';
                    if(!$this->PermissionsRoles->save($permission_to_add)){
                        $complete = false;
                    }
                }

                foreach ($permissions_to_delete as $permission => $value) {
                    $permission_to_delete = $this->PermissionsRoles->get(
                        ['role_id' => 'Estudiante',
                            'permission_id' => $permission]);
                    if(!$this->PermissionsRoles->delete($permission_to_delete)){
                        $complete = false;
                    }
                }
                
            }else if(array_key_exists('AceptarAsistente',$data)){
                unset($data['AceptarAsistente']);
                $permissions_to_add = array_diff_key($data, $assistant_permissions);
                $permissions_to_delete = array_diff_key($assistant_permissions, $data);
                unset($permissions_to_delete['Mainpage-index']);

                foreach ($permissions_to_add as $permission => $value) {
                    $permission_to_add = $this->PermissionsRoles->newEntity();
                    $permission_to_add->permission_id = $permission;
                    $permission_to_add->role_id= 'Asistente';
                    if(!$this->PermissionsRoles->save($permission_to_add)){
                        $complete = false;
                    }
                }

                foreach ($permissions_to_delete as $permission => $value) {
                    $permission_to_delete = $this->PermissionsRoles->get(
                        ['role_id' => 'Asistente',
                            'permission_id' => $permission]);
                    if(!$this->PermissionsRoles->delete($permission_to_delete)){
                        $complete = false;
                    }
                }

            }else if(array_key_exists('AceptarProfesor',$data)){
                unset($data['AceptarAsistente']);
                $permissions_to_add = array_diff_key($data, $professor_permissions);
                $permissions_to_delete = array_diff_key($professor_permissions, $data);
                unset($permissions_to_delete['Mainpage-index']);

                foreach ($permissions_to_add as $permission => $value) {
                    $permission_to_add = $this->PermissionsRoles->newEntity();
                    $permission_to_add->permission_id = $permission;
                    $permission_to_add->role_id= 'Profesor';
                    if(!$this->PermissionsRoles->save($permission_to_add)){
                        $complete = false;
                    }
                }

                foreach ($permissions_to_delete as $permission => $value) {
                    $permission_to_delete = $this->PermissionsRoles->get(
                        ['role_id' => 'Profesor',
                            'permission_id' => $permission]);
                    if(!$this->PermissionsRoles->delete($permission_to_delete)){
                        $complete = false;
                    }
                }
            }

            if($completed){
                $this->Flash->success(__('Se modificaron los permisos del rol correctamente.'));
            }else{
                $this->Flash->error(__('Error: no se lograron modificar los permisos del usuario.'));
            }
            return $this->redirect('/roles/index');
        }
    }

    /**
     * Agrega o borra los permisos seleccionados del rol seleccionado en la vista. 
     *
     * @return void
     */
    public function updatePermissions()
    {
        $updates_completed = true;
        $n_permission_types = count($this->permission_types);
        $this->render(false);
        $this->loadModel('PermissionsRoles');
        $this->loadModel('Permissions');
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($data['role_select'] == 'Administrador') {
                $role_selected = 'administrator';
                $old_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                    return $q->where(['Roles.role_id' => 'Administrador']);
                })->toArray();

            } else if ($data['role_select'] == 'Asistente') {
                $role_selected = 'assistant';
                $old_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                    return $q->where(['Roles.role_id' => 'Asistente']);
                })->toArray();

            } else if ($data['role_select'] == 'Estudiante') {
                $role_selected = 'student';
                $old_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                    return $q->where(['Roles.role_id' => 'Estudiante']);
                })->toArray();

            } else if ($data['role_select'] == 'Profesor') {
                $role_selected = 'professor';
                $old_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                    return $q->where(['Roles.role_id' => 'Profesor']);
                })->toArray();

            }

            for ($i = 0; $i < $n_permission_types; $i++) {
                $old_permissions_matrix[$i][0] = $this->permission_list[$i];
                for ($j = 1; $j <= count($this->permissions_id_matrix[$i]); $j++) {
                    $old_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $old_permissions);
                }
            }

            for ($i = 0; $i < $n_permission_types; $i++) {
                for ($j = 1; $j <= count($this->permissions_id_matrix[$i]); $j++) {
                    if (array_key_exists($role_selected, $data) &&
                        array_key_exists($i, $data[$role_selected]) &&
                        array_key_exists($j, $data[$role_selected][$i])) {
                        if (!$old_permissions_matrix[$i][$j]) {
                            $permission_role = $this->PermissionsRoles->newEntity();
                            $permission_role->role_id = $data['role_select'];
                            $permission_role->permission_id = $this->permissions_id_matrix[$i][$j - 1];
                            echo (var_dump('' . $permission_role->role_id . $permission_role->permission_id));
                            if (!$this->PermissionsRoles->save($permission_role)) {
                                $updates_completed = false;
                            }
                        }
                    } else {
                        if ($old_permissions_matrix[$i][$j]) {
                            $permission_role = $this->PermissionsRoles->get(
                                ['role_id' => $data['role_select'],
                                    'permission_id' => $this->permissions_id_matrix[$i][$j - 1]]);
                            if (!$this->PermissionsRoles->delete($permission_role)) {
                                $updates_completed = false;
                            }
                        }
                    }
                }
            }
            if($updates_completed){
                $this->Flash->success(__('Se han actualizado los permisos del rol.'));
            }else{
                $this->Flash->error(__('Los permisos del rol no han sido ser actualizados.'));
            }
        }

        return $this->redirect('/roles/index');
    }

    /**
     * Retorna true si el usuario esta autrorizado a realizar la $action en $module, si no, retorna falso.
     * 
     * @param String $role Rol que efectuara la acción
     * @param String $module Modulo donde se efectuara la acción
     * @param String $action La acción a efectuarse
     * @return boolean
     */
    public function is_Authorized($role, $module, $action){
        $role_permissions = [];
        $this->loadModel('PermissionsRoles');
        $this->loadModel('Permissions');
        if ($role == 'Administrador') {
            $role_selected = 'administrator';
            $role_permissions = $this->Permissions->getPermissions('Administrador');

        } else if ($role == 'Asistente') {
            $role_selected = 'assistant';
            $role_permissions = $this->Permissions->getPermissions('Asistente');

        } else if ($role == 'Estudiante') {
            $role_selected = 'student';
            $role_permissions = $this->Permissions->getPermissions('Estudiante');

        } else if ($role== 'Profesor') {
            $role_selected = 'professor';
            $role_permissions = $this->Permissions->getPermissions('Profesor');
        }

        return in_array($module.'-'.$action, $role_permissions);
    }
}
