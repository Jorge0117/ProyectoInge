<?php
namespace App\Controller;
//namespace Cake\ORM;

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

            //agrega a la tabla students
            if($user->role_id === 'Estudiante'){
                $carne = $username;
                $Students->newStudent($user, $carne);
            }

            if ($this->Users->save($user)) { 
                $session->delete('NEW_USER');        

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
        $SecurityCont = new SecurityController;
        if (isset($this->request->data['cancel'])) {
            //Volver a sign in
            return $this->redirect(['controller' => 'Security', 'action' => 'login']);
        }
        if ($this->request->is('post')) {
            $username =  $this->request->getData('username');
            $user->username= $username;
                $pattern = "/\w\d{5}/";
                //asigna rol segun el nombre de usuario
                if(preg_match($pattern, $username)){
                    //es estudiante
                    $user->role_id= 'Estudiante';
                }else{
                    $user->role_id= 'Profesor';
                }

                
                if($user->role_id === 'Estudiante'){
                    
                    $students = TableRegistry::get('Students');
                    $students = $students->patchEntity($students, [$user, $username]);

                    if ($students->save($students)) {
                        $this->Flash->success(__('Se agregó el estudiante correctamente.'));        
                    }

                
                    //$Students->newStudent($user, $carne);
                }

                $user = $this->Users->patchEntity($user, $this->request->getData());
                
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
        $Professors = new ProfessorsController;
        $AdministrativeBoss = new AdministrativeBossesController;
        $AdministrativeAssistant = new AdministrativeAssistantsController;
        //guarda el rol del usuario actual para verificar si puede editar el rol
        $rol_usuario = $this->getRequest()->getSession()->read('role_id');
        //debug($rol_usuario);
        $admin = 0;
        if($rol_usuario === 'Administrador'){
            $admin = 1;
        }
        
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['cancel'])) {
                return $this->redirect( array( 'action' => 'index' ));
            }
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                if($user->isDirty('role_id')){
                    //modifico el rol
                    $rol_original = $user->getOriginal('role_id');
                    
                    if($rol_original === 'Profesor'){
                        //rol anterior era profesor
                        //se elimina de la tabla profesores y se agrega al nuevo rol
                        $Professors->delete($user);
                        if($user->role_id === 'Administrador'){
                            $AdministrativeBoss->newAdmin($user);
                        }else{
                            if($user->role_id === 'Asistente'){
                                $AdministrativeAssistant->newAssistant($user);
                            }
                        } 
                    }else{
                        if($rol_original === 'Administrador'){
                            //rol anterior era jefe administrativo
                            //se elimina de la tabla administrativebosses y se agrega al nuevo rol
                            if($user->role_id === 'Asistente'){
                                $AdministrativeAssistant->newAssistant($user);
                            }else{
                                if($user->role_id === 'Profesor'){
                                    $Professors->newProfessor($user);
                                }
                            }
                        }else{
                            if($rol_original === 'Asistente'){
                                //roll anterior era asistente administrativo
                                //se elimina de la tabla administrative_assistants y se agrega al nuevo rol
                                $AdministrativeAssistant->delete($user);

                                if($user->role_id === 'Administrador'){
                                    $AdministrativeBoss->newAdmin($user);
                                }else{
                                    if($user->role_id === 'Profesor'){
                                        $Professors->newAssistant($user);
                                    }
                                }
                            }
                        }
                    }
                }
                $this->Flash->success(__('Se modificó el usuario correctamente.'));
                return $this->redirect(['action' => 'index']);
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


}
