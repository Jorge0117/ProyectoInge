<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Requirements Controller
 *
 * @property \App\Model\Table\RequirementsTable $Requirements
 *
 * @method \App\Model\Entity\Requirement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequirementsController extends AppController
{

    /**
     * Activa el item del menú de navegación
     * 
     * @author Daniel Díaz
     */
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);
        $this->set('active_menu', 'MenubarRequisitos');

    }

    /**
     * Metodo que redirecciona al index, carga los requisitos del modelo y los envía
     *
     * @author Estiven Alfaro <estivenalg@gmail.com>
     * @return void
     */ 
    public function index()
    {
        $table = $this->loadModel('Requirements');
        $requirements = $table->find();
        $this->set(compact('requirements'));
    }

    /**
     * View method
     *
     * @param string|null $id Requirement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requirement = $this->Requirements->get($id, [
            'contain' => ['FulfillsRequirement']
        ]);

        $this->set('requirement', $requirement);
    }

    /**
     * Add method
     *
     * @author Nathan González
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //Crea una nueva entidad de requerimientos.
        $requirement = $this->Requirements->newEntity();

        //Si la nueva entidad de requerimientos fue realizada correctamente, haga
        if ($this->request->is('post')) {
            
            //Pasa los datos de la entidad hecha en la vista a la entidad hecha en el controlador.
            $requirement = $this->Requirements->patchEntity($requirement, $this->request->getData());

            //Si la entidad fue almacenada en la base de datos, haga
            if ($this->Requirements->save($requirement)) {

                //Redireccione a la vista de index y muestre un mensaje de exito.
                $this->redirect(['action' => 'index']);
                return $this->Flash->success(__('Se agregó el requisito correctamente'));

            }

            //Redireccione a la vista de index y muestre un mensaje de error.
            $this->redirect(['action' => 'index']);
            $this->Flash->error(__('No se logró agregar el requisito'));
        }

        //Recolecte el conjunto de todos los requisitos para ser mostrados por el index.
        $this->set(compact('requirement'));
    }

    /**
     * Edit method
     *
     * @author Nathan González
     * @param string|null $id Requirement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //Recolecte los datos de la tupla que se desea modificar.
        $requirement = $this->Requirements->get($id, [
            'contain' => []
        ]);

        //Si la nueva entidad de requerimientos fue realizada correctamente, haga
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Pasa los datos de la entidad hecha en la vista a la entidad hecha en el controlador.
            $requirement = $this->Requirements->patchEntity($requirement, $this->request->getData());
            
            //Si la entidad fue almacenada en la base de datos, haga
            if ($this->Requirements->save($requirement)) {

                //Redireccione a la vista de index y muestre un mensaje de exito.
                $this->redirect(['action' => 'index']);
                return $this->Flash->success(__('Se modificó el requisito correctamente'));
            
            }
            
            //Redireccione a la vista de index y muestre un mensaje de error.
            $this->redirect(['action' => 'index']);
            $this->Flash->error(__('No se logró editar el requisito'));
        }

        //Recolecte el conjunto de todos los requisitos para ser mostrados por el index.
        $this->set(compact('requirement'));
    }

    /**
     * Elimina el requisito elegido
     *
     * @author Estiven Alfaro <estivenalg@gmail.com>
     * @param null $id identificador del requisito.
     * @return redirect Redirecciona al index
     * @throws / Flash success cuando se elimina el requisito, Flash error cuando no se puede borrar el requisito.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requirement = $this->Requirements->get($id);
        if ($this->Requirements->delete($requirement)) {
            $this->Flash->success(__('Se borró el requisito correctamente'));
        } else {
            $this->Flash->error(__('Error: no se pudo borrar el requisito'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //Función que relacionará a una solicitud con los requisitos.
    public function addRequest($requestId){

        //Para cada una de las tuplas en la tabla de requisitos haga lo siguiente.
        foreach ($requirements as $requirement){

            //Tome el valor de su llave.
            $requirementNumber = $requirement->get($id);
            
            /* Llame al un procedimiento almacenado que relacionará
               al id de la solicitud con el del requerimiento. */
            $this->query('CALL requirement_association("'.$requirementNumber.'","'.$requestId.'");');
        
        }

    }

    /**
     * This method was added by Joseph Rementería.
     * 
     * To validate whether a request can be classified as 'e', 'i' 
     * or not, we need to count all of the mandatory requirements.
     * 
     * 
     */
    public function countMandatoryRequirements()
    {
        $requirementsCount = $this->Requirements->find('all')->where(['type' => 'Obligatorio'])->toArray();
        return sizeof($requirementsCount);
    }

}