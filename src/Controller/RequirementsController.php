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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $requirements = $this->paginate($this->Requirements);
        $this->set(compact('requirements'));
        $this->checkDate();
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
                return $this->Flash->success(__('Se agregó el requisito con exito.'));

            }

            //Redireccione a la vista de index y muestre un mensaje de error.
            $this->redirect(['action' => 'index']);
            $this->Flash->error(__('No se pudo agregar el requisito con éxito'));
        }

        //Recolecte el conjunto de todos los requisitos para ser mostrados por el index.
        $this->set(compact('requirement'));
    }

    /**
     * Edit method
     *
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
                return $this->Flash->success(__('Se modificó el requisito con exito.'));
            
            }
            
            //Redireccione a la vista de index y muestre un mensaje de error.
            $this->redirect(['action' => 'index']);
            $this->Flash->error(__('No se pudo editar el requisito'));
        }

        //Recolecte el conjunto de todos los requisitos para ser mostrados por el index.
        $this->set(compact('requirement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Requirement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($requirement_number)
    {
        //------------------------------------------------
        $result = false;
        //------------------------------------------------
        $model = $this->Requirements->newEntity();
        //------------------------------------------------
        if ($this->request->is('post')) {
            //------------------------------------------------
            $model = $this->Requirements->patchEntity(
                $model, 
                $this->request->getData()
            );
            //------------------------------------------------
            $requirementsModel = $this->loadmodel('Requirements');
            //------------------------------------------------
            $result = $requirementsModel->deleteRequirement(
                $requirement_number
            );
        }
        //------------------------------------------------
        if($result){
            $this->redirect(['action' => 'index']);
            return $this->Flash->success(__('Se eliminó el requisito con exito.'));
        }
        $this->redirect(['action' => 'index']);
        $this->Flash->error(__('No se pudo eliminar el requisito'));
    }

    //Función que verifica si ya la ronda empezo o no para así bloquear el sistema.
    public function checkDate(){

        //Comentado mientras se realiza la función necesaria.
        //$onDate = $this->requestAction('/rounds/nombredelafuncion/');

        //Temporal para que la función sirva.
        $onDate = 0;

        /* Guarda en la variable show el valor de el onDate,
           es decir, nos dirá si ya empezamos la ronda o no. */
        $this->set('show', $onDate);
    
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
}