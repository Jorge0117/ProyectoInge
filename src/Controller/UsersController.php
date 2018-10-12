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
        $this->Auth->allow('register');
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
    public function register(string $username){
        $session = $this->getRequest()->getSession();
        $user = $this->Users->newEntity();

        $s_username = $session->read('NEW_USER');
        debug($s_username);
        if (!$session->check('NEW_USER') || $s_username != $username) {
            return $this->redirect('/');
        }

        // Caso en que fue redirigido desde Security
        if ($this->request->is('get')) {
            $user['username'] = $username;

        // Caso en que se recibio el form
        } elseif ($this->request->is('post')) {
            if (isset($this->request->data['cancel'])) {
                //return $this->redirect( array( 'action' => 'index' ));
            }
            // Obtener los datos del Form y agregar el username
            $user = $this->Users->newEntity($this->request->getData());
            $user['username'] = $username;

            //instancias para crear cada tipo de usuario en su respectivo controlador
            // debug($user);
            $Students = new StudentsController;
            $SecurityCont = new SecurityController;

            debug($username);

            //if( $ ->checkUsername($username) ){
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
                
                $session->delete('NEW_USER');
                if($user->role === 'Estudiante'){
                    $carne = $this->request->getData('carne');
                    $Students->newStudent($user, $carne);
                }
                //triggers para los demás 

                $this->Flash->success(__('Se agregó el usuario correctamente.'));
                return $this->redirect(['controller' => 'Security', 'action' => 'login']);
            } 
            debug($user);
            $this->Flash->error(__('No se pudo crear el usuario.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'register', $username]);
        }
        // $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //$carne = $this->request->getData('carne');
        //debug($carne);
        $user = $this->Users->newEntity();
        $SecurityCont = new SecurityController;
        if (isset($this->request->data['cancel'])) {
            //Volver a sign in
            return $this->redirect(['controller' => 'Security', 'action' => 'login']);
        }
        if ($this->request->is('post')) {
            $username =  $this->request->getData('username');
            $user->username= $username;
            //if( $this->validateUser($username) ){
                $pattern = "/\w\d{5}/";
                //asigna rol segun el nombre de usuario
                if(preg_match($pattern, $username)){
                //es estudiante
                    $user->role_id= 'Estudiante';
                }else{
                    $user->role_id= 'Profesor';
                }
                
                if($user->role === 'Estudiante'){
                    $carne = $username;
                    $Students->newStudent($user, $carne);
                }

                $user = $this->Users->patchEntity($user, $this->request->getData());
                
                degug($user);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Se agregó el usuario correctamente.'));
                    return $this->redirect(['action' => 'index']);
                }
            //}else{
            //    $this->Flash->error(__('Nombre de usuario no es válido.'));
            //} 
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
