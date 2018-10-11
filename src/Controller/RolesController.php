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

    public $permissions_id_matrix = [['SO-AG', 'CU-AG', 'RE-AG', 'RN-AG', 'US-AG'], // 'RO-AG'],
        ['SO-MO', 'CU-MO', 'RE-MO', 'RN-MO', 'US-MO'], // 'RO-MO'],
        ['SO-EL', 'CU-EL', 'RE-EL', 'RN-EL', 'US-EL'], // 'RO-EL'],
        ['SO-CO', 'CU-CO', 'RE-CO', 'RN-CO', 'US-CO']]; //, 'RO-CO']];

    public $permission_list = ['Agregar', 'Modificar', 'Eliminar', 'Consultar'];
    public $professor_permissions_matrix = [];
    public $student_permissions_matrix = [];
    public $assistant_permissions_matrix = [];
    public $administrator_permissions_matrix = [];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
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

        for ($i = 0; $i < 4; $i++) {
            $administrator_permissions_matrix[$i][0] = $this->permission_list[$i];
            for ($j = 1; $j < 6; $j++) {
                $administrator_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $administrator_permissions);
            }
        }

        $this->set(compact('administrator_permissions_matrix'));

        //Assistant permissions
        $assistant_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Asistente']);
        })->toArray();
        $this->set(compact('assistant_permissions'));

        for ($i = 0; $i < 4; $i++) {
            $assistant_permissions_matrix[$i][0] = $this->permission_list[$i];
            for ($j = 1; $j < 6; $j++) {
                $assistant_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $assistant_permissions);
            }
        }

        $this->set(compact('assistant_permissions_matrix'));

        //Student permissions
        $student_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Estudiante']);
        })->toArray();
        $this->set(compact('student_permissions'));

        for ($i = 0; $i < 4; $i++) {
            $student_permissions_matrix[$i][0] = $this->permission_list[$i];
            for ($j = 1; $j < 6; $j++) {
                $student_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $student_permissions);
            }
        }

        $this->set(compact('student_permissions_matrix'));

        //Professor permissions
        $professor_permissions = $this->Permissions->find('list')->matching('Roles', function ($q) {
            return $q->where(['Roles.role_id' => 'Profesor']);
        })->toArray();
        $this->set(compact('professor_permissions'));

        for ($i = 0; $i < 4; $i++) {
            $professor_permissions_matrix[$i][0] = $this->permission_list[$i];
            for ($j = 1; $j < 6; $j++) {
                $professor_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $professor_permissions);
            }
        }

        $this->set(compact('professor_permissions_matrix'));
    }

    public function updatePermissions()
    {
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

            for ($i = 0; $i < 4; $i++) {
                $old_permissions_matrix[$i][0] = $this->permission_list[$i];
                for ($j = 1; $j < 6; $j++) {
                    $old_permissions_matrix[$i][$j] = in_array($this->permissions_id_matrix[$i][$j - 1], $old_permissions);
                }
            }

            for ($i = 0; $i < count($this->permissions_id_matrix); $i++) {
                for ($j = 1; $j < count($this->permissions_id_matrix[$i]) + 1; $j++) {
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

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Permissions'],
        ]);

        $this->set('role', $role);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $permissions = $this->Roles->Permissions->find('list', ['limit' => 200]);
        $this->set(compact('role', 'permissions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Permissions'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->getData());
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role could not be saved. Please, try again.'));
        }
        $permissions = $this->Roles->Permissions->find('list', ['limit' => 200]);
        $this->set(compact('role', 'permissions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $role = $this->Roles->get($id);
        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
