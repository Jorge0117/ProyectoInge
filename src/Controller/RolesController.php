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
     * Activa el item del menú de navegación
     * 
     * @author Daniel Díaz
     */
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        $this->set('active_menu', 'MenubarPermisos');

    }

    /**
     * Se encarga de la logica de modificar permisos de rol.
     *
     * @return \Cake\Http\Response|void
     */
    public function edit()
    {
        $this->loadModel('Permissions');
        $this->loadModel('PermissionsRoles');

        // Se solicitan los roles existentes en el sistema para mostrarlos en la vista
        $roles_array = $this->Roles->find('list');
        $this->set(compact('roles_array'));

        // Se solicitan los permisos de administrador
        $administrator_permissions = $this->Permissions->getPermissions('Administrador');
        $this->set(compact('administrator_permissions'));

        // Se solicitan los permisos de asistente
        $assistant_permissions = $this->Permissions->getPermissions('Asistente');
        $this->set(compact('assistant_permissions'));

        // Se solicitan los permisos de estudiante
        $student_permissions = $this->Permissions->getPermissions('Estudiante');
        $this->set(compact('student_permissions'));
 
        // Se solicitan los permisos de profesor
        $professor_permissions = $this->Permissions->getPermissions('Profesor');
        $this->set(compact('professor_permissions'));

        /*
         * Se solicitan todos los permisos del sistema categorizados por modulo(Para más información, revisar el metodo
         * getAllPermissionsByModule del modelo Permissions).
         */
        $all_permissions_by_module = $this->Permissions->getAllPermissionsByModule();
        $this->set(compact('all_permissions_by_module'));

        // Manejo la solicitud del cliente
        if ($this->request->is('post')) {
            // Se guardan los datos enviados por el cliente
            $data = $this->request->getData();
            // Variable usada para verificar que todas las operaciones fueron ejecutadas correctamente
            $completed = true;

            /*
             * Dependiendo del rol que se estaba modificando se oprime un boton aceptar diferente.
             * En este if se verifica que boton fue oprimido, y con esto saber que rol esta siendo modificado.
             * 
             * Para aumentar la velocidad, algunos campos que no son indispensables del array son borrados, 
             * para asi no tener que sacar uno a uno los que si son indispensables.
             */ 
            if(array_key_exists('AceptarAdministrador',$data)){
                unset($data['AceptarAdministrador']);
                $role = 'Administrador';
                $role_permissions = $administrator_permissions;
            }else if(array_key_exists('AceptarEstudiante',$data)){
                unset($data['AceptarEstudiante']);
                $role = 'Estudiante';
                $role_permissions = $student_permissions;
            }else if(array_key_exists('AceptarAsistente',$data)){
                unset($data['AceptarAsistente']);
                $role = 'Asistente';
                $role_permissions = $assistant_permissions;
            }else if(array_key_exists('AceptarProfesor',$data)){
                unset($data['AceptarProfesor']);
                $role = 'Profesor';
                $role_permissions = $professor_permissions;
            }


            /*
             * Para aumentar la velocidad, se usa la operacion diferencia(es una operación de conjuntos, que devuelve
             * los elementos que estan en el primer conjunto pero no en el segundo). Esto es necesario ya que en 
             * $data estan los permisos que el usuario espera que esten concedidos al rol, pero algunos ya estan en la 
             * base, por lo que no hay que guardarlos. 
             * 
             * Con la operacion diferencia, se buscan en $data los permisos que no esten en la base (en este caso 
             * representada por $role_permissions) para crear el array $permissions_to_add, para despues ser agregados. 
             * 
             * Por otro lado, para saber cuales hay que borrar, se deben buscar los permisos que estan en la
             * base ($role_permissions) y que no esten en $data, debido a que como se menciono anteriormente, si no 
             * estan en $data significa que el usuario no los concedio. Estos permisos son guardados en 
             * $permissions_to_delete, para despues ser borrados.
             */
            $permissions_to_add = array_diff_key($data, $role_permissions);
            $permissions_to_delete = array_diff_key($role_permissions, $data);

            /*
             * Para aumentar la velocidad, algunos campos que no son indispensables del array son borrados, 
             * para asi no tener que sacar uno a uno los que si son indispensables.
             * 
             * Estos (en este caso 'Mainpage-index' y 'Roles-edit') deben ser borrados ya que son permisos que no se deben modificar,
             * o sea los roles siempre deben tenerlos sin importa que. En caso de que no se borren de este array, 
             * seran puestos en el array de permisos a borrar ya que en la interfaz no hay un campo para ellos, 
             * por lo que en el array recibido de checks del usuario nunca van a estar. 
             */ 
            if ($role == 'Administrador'){
                // Este requiere de un if ya que solo el administrador tiene este permiso
                unset($permissions_to_delete['Roles-edit']);
            }
            unset($permissions_to_delete['Mainpage-index']);

            /*
             * Se recorre y se agregan los permisos que estan en $permissions_to_add
             */ 
            foreach ($permissions_to_add as $permission => $value) {
                $permission_to_add = $this->PermissionsRoles->newEntity();
                $permission_to_add->permission_id = $permission;
                $permission_to_add->role_id= $role;

                // Se verifica que la operacion se completo correctamente
                if(!$this->PermissionsRoles->save($permission_to_add)){
                    $complete = false;
                }
            }

            /*
             * Se recorre y se borran los permisos que estan en $permissions_to_delete
             */
            foreach ($permissions_to_delete as $permission => $value) {
                $permission_to_delete = $this->PermissionsRoles->get(
                    ['role_id' => $role,
                        'permission_id' => $permission]);

                // Se verifica que la operacion se completo correctamente
                if(!$this->PermissionsRoles->delete($permission_to_delete)){
                    $complete = false;
                }
            }

            /*
             * Si se completaron todas las operaciones se muestra un mensaje de exito, en caso contrario
             * se muestra un mensaje de error.
             */
            if($completed){
                $this->Flash->success(__('Se modificaron los permisos del rol correctamente.'));
            }else{
                $this->Flash->error(__('Error: no se lograron modificar los permisos del usuario.'));
            }

            //Se recarga la pagina para que se muestren los cambios.
            return $this->redirect('/roles/index');
        }
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
