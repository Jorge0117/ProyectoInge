<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize(){
        parent::initialize();
        $this->Auth->allow('register', 'index');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'AdministrativeAssistants', 'AdministrativeBosses', 'Professors', 'Students']
        ]);

        $this->set('user', $user);
    }

    /**
     * Register of a new user
     */
    public function register(){

        $user = $this->Users->newEntity($this->request->getData());
        //instancias para crear cada tipo de usuario en su respectivo controlador
        $Students = new StudentsController;
        $SecurityCont = new SecurityController;

        if (isset($this->request->data['cancel'])) {
            //Volver a sign in
            //return $this->redirect( array( 'action' => 'index' ));
        }

        $carne = $this->request->getData('carne');
        if ($this->request->is('post')) {
            $username = $this->request->getData('username');
            //if( $SecurityCont->checkUsername($username) ){
                $pattern = "/\w\d{5}/";
                //asigna rol segun el nombre de usuario
                if(preg_match($pattern, $username)){
                //es estudiante
                    $user->role_id= 'Estudiante';
                }else{
                    $user->role_id= 'Profesor';
                }
                debug($user->role_id);

                if ($this->Users->save($user)) { 
                    //$user = $this->Users->patchEntity($user, $this->request->getData(), ['username' => $username]);
                    //Guardar en la tabla de tipo de usuario tambien
                    //debug($user);
                    if($user->role === 'Estudiante'){
                        $Students->newStudent($user, $carne);
                    }
                    //triggers para los demás 
    
                    $this->Flash->success(__('Se agregó el usuario correctamente.'));
                    return $this->redirect(['action' => 'index']);
                } 
            //}
            
            debug($user);
            $this->Flash->error(__('No se pudo crear el usuario.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carne = $this->request->getData('carne');
        debug($carne);
        $user = $this->Users->newEntity();
        if (isset($this->request->data['cancel'])) {
            //Volver a sign in
            //return $this->redirect( array( 'action' => 'index' ));
        }
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            debug($user);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Se agregó el usuario correctamente.'));
                return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__('No se pudo crear el usuario.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {   
        $Students = new StudentsController;
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['cancel'])) {
                return $this->redirect( array( 'action' => 'index' ));
            }
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $Students->edit($user);
                $this->Flash->success(__('Se modificó el usuario correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo modificar el usuario.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));

        //on update cascade en la base de datos para los tipos de usuarios que no son estudiantes
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


}
