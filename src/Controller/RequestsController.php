<?php
namespace App\Controller;

use App\Controller\AppController;
/**
 * Requests Controller
 *
 * @property \App\Model\Table\RequestsTable $Requests
 *
 * @method \App\Model\Entity\Request[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RequestsController extends AppController
{
	
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
	 
	public function validarFecha()
	{
		$resultado = false;
		$inicio = "2009-10-25"; //CAMBIAR POR FUNCION DE RONDA
		$final = "2019-10-25"; //CAMBIAR POR FUNCION DE RONDA
		
		if(strtotime(date("y-m-d")) < strtotime($final) && strtotime(date("y-m-d")) > strtotime($inicio))
			$resultado = true;
		return $resultado;
	
	}	
	 
    public function index()
    {
        /*$this->paginate = [
            'contain' => ['Courses', 'Students']
        ];*/
        $requests = $this->paginate($this->Requests);

		$disponible = $this->validarFecha(); //Devuelve true si la fecha actual se encuentra entre el periodo de alguna ronda
		
        $this->set(compact('requests','disponible'));
    }

    /**
     * View method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $request = $this->Requests->get($id, [
            'contain' => ['Courses', 'Students']
        ]);

        $this->set('request', $request);
		
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
   /* public function add()
    {
        $request = $this->Requests->newEntity();
        if ($this->request->is('post')) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
			
			$RequestsTable=$this->loadmodel('Requests');
			//$round almacena datos originales
			
			debug($request->status,'char');
			
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
        $courses = $this->Requests->Courses->find('list', ['limit' => 200]);
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
        $this->set(compact('request', 'courses', 'students'));
    }
*/

public function get_round_start_date()
{
	$start = date("01/02/03"); //Deberia pedirselo a ronda
	
	return $start;
}

public function get_student_id()
{
	$student_id = "B12345";
	
	return $student_id;
}

public function get_semester()
{
	$semester = "1";
	
	return $semester;
}

public function add()
    {
        
		$request = $this->Requests->newEntity();
        if ($this->request->is('post')) {
			
            $request = $this->Requests->patchEntity($request, $this->request->getData());
			
			$RequestsTable=$this->loadmodel('Requests');
			//$round almacena datos originales
			
			//Modifica los datos que debe extraer de las otras controladoras o que van por defecto:
			$request->set('status', 'p'); //Toda solicitud esta pendiente 
			$request->set('round_start',$this->get_round_start_date());//obtiene llave de ronda
			$request->set('reception_date',date('Y-m-d')); //obtiene fecha actual
			$request->set('student_id',$this->get_student_id()); //obtiene el id del estudiante logueado
			$request->set('class_year',date('Y')); //obtiene el año actual de la solicitud
			$request->set('class_semester',$this->get_semester()); //obtiene el semestre actual de la solicitud
			//die();
			
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
        $courses = $this->Requests->Courses->find('list', ['limit' => 200]);
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
		$classes = $this->Requests->Classes->find('list', ['limit' => 200]);
		$nombre;
		
		//Modifica las clases para dejar los datos requeridos de curso y grupo
		$tuplas = $classes->execute();
		$course;
		$teacher;
		$i = 0;
		$c2;
		foreach($tuplas as $t)
		{
			$class[$i] = $t[1];
			$course[$i] = $t[0];
			$teacher[$i] = $t;
			
			$i = $i + 1;
		}		
		
		$i = 0;
		$courses = $courses->execute();
		
		$c2[0] = "Seleccione un Curso:";
		foreach($courses as $c)
		{
			$c2[$i+1] = $c[0];
			$nombre[$i+1] = $c[1];
			$i = $i + 1;
			
		}
		$teacher = $this->Requests->getTeachers();
		$id = $this->Requests->getID();
        $this->set(compact('request', 'c2', 'students','class','course','teacher','nombre','id'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $request = $this->Requests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $request = $this->Requests->patchEntity($request, $this->request->getData());
            if ($this->Requests->save($request)) {
                $this->Flash->success(__('The request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The request could not be saved. Please, try again.'));
        }
		debug($request);
        $courses = $this->Requests->Courses->find('list', ['limit' => 200]);
        $students = $this->Requests->Students->find('list', ['limit' => 200]);
        $this->set(compact('request', 'courses', 'students'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $request = $this->Requests->get($id);
        if ($this->Requests->delete($request)) {
            $this->Flash->success(__('The request has been deleted.'));
        } else {
            $this->Flash->error(__('The request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
		
    }
	
	public function prueba()
	{
		debug("xdd");
		$this->autoRender = false;
	}
	
	/*public function save()
	{
		//Guarda los datos;
		$backup = $this->loadModel('RequestsBackup');
		$request = $this->Requests->newEntity();
		$request = $this->Requests->patchEntity($request, $this->request->getData()); //Obtiene valores de los campos
		
		$st = $this->get_student_id();
		$ci = null;
		$cai = null;
		$ash = null;
		$aah = null;
		$ft = null; 
		$hah = $request->get('has_another_hours');
		$backup->saveRequest($st,$ci,$cai,$ash,$aah,$ft,$hah);
		
		debug($hah);
		
		//Redirecciona al index
		//return $this->redirect(['action' => 'index']);
	}*/

}
