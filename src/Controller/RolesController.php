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

        $roles_array = $this->Roles->find('list');
        $this->set(compact('roles_array'));

        //Administrator permissions
        $administrator_permissions = $this->Permissions->getPermissions('Administrador');
        $this->set(compact('administrator_permissions'));

        //Assistant permissions
        $assistant_permissions = $this->Permissions->getPermissions('Asistente');
        $this->set(compact('assistant_permissions'));

        //Student permissions
        $student_permissions = $this->Permissions->getPermissions('Estudiante');
        $this->set(compact('student_permissions'));

        //Professor permissions
        $professor_permissions = $this->Permissions->getPermissions('Profesor');
        $this->set(compact('professor_permissions'));

        $all_permissions_by_module = $this->Permissions->getAllPermissionsByModule();
        $this->set(compact('all_permissions_by_module'));
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
