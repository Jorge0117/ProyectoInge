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

        $permission_list = ['Agregar','Modificar', 'Eliminar','Consultar'];
        $this->set(compact('permission_list'));

        $permissions_id = [['SO-AG', 'CU-AG', 'RE-AG', 'RN-AG', 'US-AG'],// 'RO-AG'],
                           ['SO-MO', 'CU-MO', 'RE-MO', 'RN-MO', 'US-MO'],// 'RO-MO'],
                           ['SO-EL', 'CU-EL', 'RE-EL', 'RN-EL', 'US-EL'],// 'RO-EL'],
                           ['SO-CO', 'CU-CO', 'RE-CO', 'RN-CO', 'US-CO']];//, 'RO-CO']];

        //Administrator permissions
        $administrator_permissions = $this->Permissions->find('list')->matching('Roles',function ($q) {
            return $q->where(['Roles.role_id' => 'Administrador']);
        })->toArray() ;
        $this->set(compact('administrator_permissions'));
        
        $administrator_permissions_matrix = [];
        for($i = 0; $i < 4 ; $i++){
            $administrator_permissions_matrix[$i][0] = $permission_list[$i];
            for($j = 1; $j < 6; $j++){
                $administrator_permissions_matrix[$i][$j] = in_array($permissions_id[$i][$j - 1],$administrator_permissions);
            }
        }
        
        $this->set(compact('administrator_permissions_matrix'));

        //Assistant permissions
        $assistant_permissions = $this->Permissions->find('list')->matching('Roles',function ($q) {
            return $q->where(['Roles.role_id' => 'Asistente']);
        })->toArray();
        $this->set(compact('assistant_permissions'));

        $assistant_permissions_matrix = [];
        for($i = 0; $i < 4 ; $i++){
            $assistant_permissions_matrix[$i][0] = $permission_list[$i];
            for($j = 1; $j < 6; $j++){
                $assistant_permissions_matrix[$i][$j] = in_array($permissions_id[$i][$j - 1],$assistant_permissions);
            }
        }
        
        $this->set(compact('assistant_permissions_matrix'));

        //Student permissions
        $student_permissions = $this->Permissions->find('list')->matching('Roles',function ($q) {
            return $q->where(['Roles.role_id' => 'Estudiante']);
        })->toArray();
        $this->set(compact('student_permissions'));

        $student_permissions_matrix = [];
        for($i = 0; $i < 4 ; $i++){
            $student_permissions_matrix[$i][0] = $permission_list[$i];
            for($j = 1; $j < 6; $j++){
                $student_permissions_matrix[$i][$j] = in_array($permissions_id[$i][$j - 1],$student_permissions);
            }
        }
        
        $this->set(compact('student_permissions_matrix'));

        //Professor permissions
        $professor_permissions = $this->Permissions->find('list')->matching('Roles',function ($q) {
            return $q->where(['Roles.role_id' => 'Profesor']);
        })->toArray();
        $this->set(compact('professor_permissions'));

        $professor_permissions_matrix = [];
        for($i = 0; $i < 4 ; $i++){
            $professor_permissions_matrix[$i][0] = $permission_list[$i];
            for($j = 1; $j < 6; $j++){
                $professor_permissions_matrix[$i][$j] = in_array($permissions_id[$i][$j - 1],$professor_permissions);
            }
        }
        
        $this->set(compact('professor_permissions_matrix'));
        
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
            'contain' => ['Permissions']
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
            'contain' => ['Permissions']
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
