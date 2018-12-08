<?php
namespace App\Controller;
//namespace Cake\ORM;

use App\Controller\AppController;
//use Cake\ORM\TableRegistry;
//App::import('Controller', 'Students'); // mention at top


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
     * Activa el item del menú de navegación
     * 
     * @author Daniel Díaz
     */
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

        $role = $this->Auth->user('role_id');
        if ($role === 'Administrador' || $role === 'Asistente' ) {
            $this->set('active_menu', 'MenubarUsuarios');
        }

    }

    /**
     * Devuelve verdadero si el usuario tiene permiso para ingresar al view.
     *
     * @param String $user
     * @return boolean Verdadero si el usuario tiene permiso para ingresar al view, falso si no
     */
    public function isAuthorized($user)
    {
        // Cualquier usuario puede acceder a las acciones view y edit de su propio usuario
        if (in_array($this->request->getParam('action'), ['view', 'edit'])) {
            $user_id = (int)$this->request->getParam('pass.0');           
            if ($user_id === (int)$user['identification_number']) {
                return true;
            }
        }
        
        // Para otros casos usar el módulo de autorización
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
      /*  $this->paginate = [
            'contain' => ['Roles']
        ];
        $users = $this->paginate($this->Users);
        */ 
         $table = $this->loadmodel('Users');

        $users = $table->find();
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
        // debug($s_username);
        if (!$session->check('NEW_USER') || $s_username != $username) {
            return $this->redirect('/');
        }

        // Caso en que fue redirigido desde Security
        if ($this->request->is('get')) {
            $user['username'] = $username;

        // Caso en que se recibio el form
        } elseif ($this->request->is('post')) {

            // Obtener los datos del Form y agregar el username     
            $user = $this->Users->newEntity($this->request->getData());
            $user['username'] = $username;

            //instancias para crear cada tipo de usuario en su respectivo controlador
            $Students = new StudentsController;

            $pattern = "/\w\d{5}/";
            //asigna rol segun el nombre de usuario
            if(preg_match($pattern, $username)){
            //es estudiante
                $user->role_id= 'Estudiante';
            }else{
                $user->role_id= 'Profesor';
            }

            if ($this->Users->save($user)) { 
                $session->delete('NEW_USER');        
                if($user->role_id === 'Estudiante'){
                    $table = $this->loadModel('Students');
                    $table->addStudent($user->identification_number, $username);
                }
                $this->Flash->success(__('Se agregó el usuario correctamente.'));
                return $this->redirect(['controller' => 'Security', 'action' => 'login']);
            } 
            
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
        $user = $this->Users->newEntity();
        $valid_user = $this->Auth->identify();
        $SecurityCont = new SecurityController;
        if (isset($this->request->data['cancel'])) {
            //Volver a sign in
            return $this->redirect(['controller' => 'Security', 'action' => 'login']);
        }
        if ($this->request->is('post')) {
            $username =  $this->request->getData('username');
            //verificar que username exista en la base de datos
            $user->username= $username;
                $pattern = "/\w\d{5}/";
                //asigna rol segun el nombre de usuario
                if(preg_match($pattern, $username)){
                    //es estudiante
                    $user->role_id= 'Estudiante';
                }else{
                    $user->role_id= 'Profesor';
                }

                $user = $this->Users->patchEntity($user, $this->request->getData());
                
                if ($this->Users->save($user)) {
                    if($user->role_id === 'Estudiante'){
                        $table = $this->loadModel('Students');
                        $table->addStudent($user->identification_number, $username);
                    }
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
        $tableStudents = $this->loadModel('Students');
        $tableProfessors = $this->loadModel('Professors');
        $tableAdm = $this->loadModel('AdministrativeBosses');
        $tableAs = $this->loadModel('AdministrativeAssistants');

        //guarda el rol del usuario actual para verificar si puede editar el rol
        $rol_usuario = $this->Auth->user('role_id');
        $admin = 0;
        if($rol_usuario === 'Administrador'){
            $admin = 1;
        }
        
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $rol_original = $user->role_id;
        if ($this->request->is(['patch', 'post', 'put'])) {

            $user = $this->Users->patchEntity($user, $this->request->getData());
            $rol_actual = $user->role_id;
            $id = $user->identification_number;
            
            if ($this->Users->save($user)) {
                if($rol_actual != $rol_original){
                    //modifico el rol
                    
                    if($user->role_id === 'Administrador'){
                        $tableAdm->addBoss($id);
                    }else{
                        if($user->role_id === 'Asistente'){
                            $tableAs->addAssistant($id);
                        }else{
                            if($user->role_id === 'Profesor'){
                                $tableProfessors->addProfessor($id);
                            }else{
                                if($user->role_id === 'Estudiante'){
                                    $carne = $user->username;
                                    $tableStudents->addStudent($id, $carne);
                                }
                            }
                        }
                    }

                    if($rol_original === 'Profesor'){
                        //rol anterior era profesor
                        //se elimina de la tabla profesores
                        $tableProfessors->deleteProfessor($id);
                         
                    }else{
                        if($rol_original === 'Administrador'){
                            //rol anterior era jefe administrativo
                            //se elimina de la tabla administrativebosses 
                            $tableAdm->deleteBoss($id);
                            
                        }else{
                            if($rol_original === 'Asistente'){
                                //roll anterior era asistente administrativo
                                //se elimina de la tabla administrative_assistants
                                $tableAs->deleteAssistant($id);
                            }else{
                                if($rol_original === 'Estudiante'){
                                    //roll anterior era asistente administrativo
                                    //se elimina de la tabla administrative_assistants
                                    $tableStudents->deleteStudent($id);
                                }   
                            }
                        }
                    }
                     
                }
                $this->Flash->success(__('Se modificó el usuario correctamente.'));
                if($rol_usuario === 'Administrador'){
                    return $this->redirect(['action' => 'index']);
                }else{
                    return $this->redirect(['action' => 'view', $user->identification_number]);
                }
            }
            $this->Flash->error(__('No se pudo modificar el usuario.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'admin'));
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
            $this->Flash->success(__('Se borró el usuario correctamente.'));
        } else {
            $this->Flash->error(__('Error: no se pudo borrar el usuario'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getId ($name, $lastname) {

        $userTable=$this->loadmodel('Users');
        return $userTable->getId($name, $lastname);
    }

    public function getProfessors() {
        $userTable=$this->loadmodel('Users');
        return $userTable->getProfessors();
    }
     /** 
     * Autor: Mayquely
     */
    public function getNameUser ($id) {

        $userTable=$this->loadmodel('Users');
        return $userTable->getNameUser($id);
    }
	
	   public function getContactInfo ($id) {
        $userTable=$this->loadmodel('Users');
        return $userTable->getContactInfo($id);
    }
	
	//Obtiene toda la información de un usuario según su id
	public function getStudentInfo ($id) {
        $userTable=$this->loadmodel('Users');
        return $userTable->getStudentInfo($id);
    }
    

}
