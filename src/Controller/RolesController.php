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

    public $permissions_id_matrix = [['Requests-add', 'CU-AG', 'Requirements-add', 'Rounds-add', 'Users-add'], // 'RO-AG'],
                                     ['Requests-edit', 'CU-MO', 'Requirements-edit', 'Rounds-edit', 'Users-edit'], // 'RO-MO'],
                                     ['Requests-delete', 'CU-EL', 'Requirements-delete', 'Rounds-delete', 'Users-delete'], // 'RO-EL'],
                                     ['Requests-view', 'CU-CO', 'Requirements-view', 'Rounds-view', 'Users-view'], //, 'RO-CO']];
                                     ['Requests-index','CU-index','Requirements-index','Rounds-index','Users-index']]; 

    public $permission_types = ['Agregar', 'Modificar', 'Eliminar', 'Consultar', 'Listar'];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $n_permission_types = count($this->permission_types);
        $this->set(compact('n_permission_types'));

        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));

        $roles_array = $this->Roles->find('list');
        $this->set(compact('roles_array'));

        $this->loadModel('Permissions');

        //Administrator permissions
        $administrator_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Administrador']);
        })->toArray();
        $this->set(compact('administrator_permissions'));

        for ($i = 0; $i < $n_permission_types; $i++) {
            $administrator_permissions_matrix[$i][0] = $this->permission_types[$i];
            for ($j = 1; $j <= count($this->permissions_id_matrix[$i]); $j++) {
                $administrator_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $administrator_permissions);
            }
        }
        
        $this->set(compact('administrator_permissions_matrix'));

        //Assistant permissions
        $assistant_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Asistente']);
        })->toArray();
        $this->set(compact('assistant_permissions'));

        for ($i = 0; $i < $n_permission_types; $i++) {
            $assistant_permissions_matrix[$i][0] = $this->permission_types[$i];
            for ($j = 1; $j <= count($this->permissions_id_matrix[$i]); $j++) {
                $assistant_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $assistant_permissions);
            }
        }

        $this->set(compact('assistant_permissions_matrix'));

        //Student permissions
        $student_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Estudiante']);
        })->toArray();
        $this->set(compact('student_permissions'));

        for ($i = 0; $i < $n_permission_types; $i++) {
            $student_permissions_matrix[$i][0] = $this->permission_types[$i];
            for ($j = 1; $j <= count($this->permissions_id_matrix[$i]); $j++) {
                $student_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $student_permissions);
            }
        }

        $this->set(compact('student_permissions_matrix'));

        //Professor permissions
        $professor_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Profesor']);
        })->toArray();
        $this->set(compact('professor_permissions'));

        for ($i = 0; $i < $n_permission_types; $i++) {
            $professor_permissions_matrix[$i][0] = $this->permission_types[$i];
            for ($j = 1; $j <= count($this->permissions_id_matrix[$i]); $j++) {
                $professor_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $professor_permissions);
            }
        }

        $this->set(compact('professor_permissions_matrix'));
    }

    public function updatePermissions()
    {
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
                            if ($this->PermissionsRoles->save($permission_role)) {
                                //$this->Flash->success(__('The role has been saved.'));
                            } else {
                                //$this->Flash->error(__('The role could not be saved. Please, try again.'));
                            }
                        }
                    } else {
                        if ($old_permissions_matrix[$i][$j]) {
                            $permission_role = $this->PermissionsRoles->get(
                                ['role_id' => $data['role_select'],
                                    'permission_id' => $this->permissions_id_matrix[$i][$j - 1]]);
                            if ($this->PermissionsRoles->delete($permission_role)) {
                                //$this->Flash->success(__('The role has been deleted.'));
                            } else {
                                //$this->Flash->error(__('The role could not be saved. Please, try again.'));
                            }
                        }
                    }
                }
            }

        }
        return $this->redirect('/roles/index');
    }

    public function is_Authorized($role, $module, $action){
        $role_permissions = [];
        $this->loadModel('PermissionsRoles');
        $this->loadModel('Permissions');
        if ($role == 'Administrador') {
            $role_selected = 'administrator';
            $role_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                return $q->where(['Roles.role_id' => 'Administrador']);
            })->toArray();

        } else if ($role == 'Asistente') {
            $role_selected = 'assistant';
            $role_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                return $q->where(['Roles.role_id' => 'Asistente']);
            })->toArray();

        } else if ($role == 'Estudiante') {
            $role_selected = 'student';
            $role_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                return $q->where(['Roles.role_id' => 'Estudiante']);
            })->toArray();

        } else if ($role== 'Profesor') {
            $role_selected = 'professor';
            $role_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
                return $q->where(['Roles.role_id' => 'Profesor']);
            })->toArray();
        }

        return in_array($module.'-'.$action, $role_permissions);
    }
}