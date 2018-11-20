<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
 use Cake\Routing\Router;
?>

<script>
	/*
	Esta funcion se encarga de cargar el valor de select de grupos en base al valor ingresado en el select de curso.
	Ejemplo: Si se selecciona curso ci1314, entonces el select de grupos almacenara todos los grupos en los que se imparte dicho curso
	*/
	function updateClass() 
	{
		document.getElementById("prof").value = ""; 
		//Obtiene los select de grupo y curso respectivamente
		selClass = document.getElementById("class-number");
		selCourse = document.getElementById("course-id");
		

		//+++++++++++++++++++++++++++++++++++++++++++++
		selCourseII = document.getElementById("c2");
		//+++++++++++++++++++++++++++++++++++++++++++++
		
		//Obtiene valores de los inputs ocultos
		a1 = document.getElementById("a1");
		a2 = document.getElementById("a2");
		
		//elimina todas las opciones de clase:
		var l = selClass.options.length;
		
		//Remueve todas las opciones de grupo actuales
		for(j = 0; j < l; j = j + 1)
		{
			selClass.options.remove(0);
		}
		
		//Recuerda el curso actual seleccionado

		//---------------------------------------------------------------
		//actualCourse = selCourse.options[selCourse.selectedIndex].text;
		//---------------------------------------------------------------

		//+++++++++++++++++++++++++++++++++++++++++++++
		actualCourse = selCourseII.options[selCourse.selectedIndex].text;
		//+++++++++++++++++++++++++++++++++++++++++++++
		
		
		courses = a2.options;
		i = 0;
		var tmp2 = document.createElement("option");
		tmp2.text = "Seleccione un Grupo"
		selClass.options.add(tmp2,0);
		tmp2 = document.createElement("option");
		tmp2.text = "BORRAR";
		
		var course_array = [];

		for(c = 0;  c < courses.length; c = c + 1) // Recorre los cursos
		{
			//Si el curso es el mismo al curso seleccionado, manda el grupo al vector
			if(actualCourse.localeCompare(courses[c].text) == 0)
			{
				var tmp = document.createElement("option");
				//if(c+1 < a1.options.length)
				//{
				tmp.text = a1.options[c].text; //Prestarle atencion a esta linea
				selClass.options.add(tmp,i);
				i = i + 1;
				//}
				
			}

		}
		
		//selClass.options = [1,2,3];
		txtNombre = document.getElementById("nc");
	
		if(selCourse.selectedIndex != 0)
		{
			
			txtNombre.value = document.getElementById("a3").options[selCourse.selectedIndex-1].text;
			
		}
		else
			txtNombre.value = "";
		
		//Esta parte de la funcion se encarga de corregir el error de PHP, en el que mete valores basura al vector y por lo tanto 
		//impiden que el codigo de curso se agregue correctamente
		var x = document.getElementById("course-id").options;
		l = x.length;
		s = x.selectedIndex;
		
		if(x[0].value == "0") //Realiza el cambio
		{
			//selCourse = document.getElementById("course-id");
			var cursos = [];
			
			//Recorre todos los cursos y los borra
			for(i = 0; i < l; ++i)
			{
				cursos.push(selCourse.options[0].text);
				selCourse.options.remove(0);
				
				
			}
			
			//Agarra todos los cursos y los mete otra vez, pero esta vez con el formato correcto para que el codigo de curso
			//se agregue correctamente.
			for(j = 0; j < l; ++j)
			{
				//Agrega el curso. 
				var tmp = document.createElement("option");
				tmp.value = cursos[j]; //Para que phpcake detecte el valor seleccionado y no el indice
				tmp.text = cursos[j]; //Para que el select despliegue el valor respectivo de la opcion y no un valor vacio
				selCourse.options.add(tmp,j);
			}
		}

		//Dado que se borro y se recreo el select de cursos, es necesario recordar cual fue el valor que habia seleccionado el usuario
		selCourse.selectedIndex = s;
		

	}
	/*
		Esta funcion se encarga de salvar el nombre del curso y del profesor en 2 campos de texto bloqueados, de modo que el usuario pueda 
		ver la información del grupo y curso que selecciono
	*/
	function save()
	{
		//Referencia los selects de grupo y curso respectivamente
		selClass = document.getElementById("class-number");
		selCourse = document.getElementById("course-id");
		
		//Obtiene el valor del curso y grupo seleccionados actualmente
		
		//----------------------------------------------------------
		//Course = selCourse.options[selCourse.selectedIndex].text;
		//----------------------------------------------------------
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		Course = document.getElementById("c2").options[selCourse.selectedIndex].text;
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		Group = selClass.options[selClass.selectedIndex].text;/*
		//Realiza una peticion al servidor mediante la tecnica AJAX, para obtener el nombre del profesor en base al curso y grupo actual
		$.ajax({
	url:"<?php echo \Cake\Routing\Router::url(array('controller'=>'Requests','action'=>'obtenerProfesor'));?>" ,   cache: false,
    type: 'GET',
	contentType: 'application/json; charset=utf-8',
    dataType: 'text',
	async: false,
	data: { curso: Course, grupo: Group, salida:"xdxd"},
    success: function (data,response) {
       // $('#context').html(data);
	   	alert(response);
	    p = data.split(" ");
		//Mete en el campo bloqueado la informacion del profesor
		document.getElementById("prof").value = (p[6] + " " + p[7]).split(")")[0]; 
	},
	error: function(jqxhr, status, exception)
	{
		alert(exception);

	}
		});*/
		
		
		//Mete al profesor:
		
		cursos = document.getElementById("a2").options;
		grupos  = document.getElementById("a1").options;
		
		//cursoActual = selCourse.options[selCourse.selectedIndex].text;
		cursoActual = document.getElementById("c2").options[selCourse.selectedIndex].text;
		grupoActual = selClass.options[selClass.selectedIndex].text;

		for(c = 0;  c < cursos.length; c = c + 1) // Recorre los cursos
		{	
			//Si el curso es el mismo al curso seleccionado, manda el grupo al vector
			
			if(cursoActual.localeCompare(cursos[c].text) == 0)
			{
				//alert(grupos[c].text);
				if(grupoActual == grupos[c].text)
				{
				/*var tmp = document.createElement("option");
				//if(c+1 < a1.options.length)
				//{
				tmp.text = a1.options[c].text; //Prestarle atencion a esta linea
				selClass.options.add(tmp,i);
				i = i + 1;
				//}*/
		
				document.getElementById("prof").value = (document.getElementById("a4")[c].text);
				}
			}

		}
		
		//Ahora que se selecciono un curso, ya no es necesario que aparezca esta opcion
		if(selClass.options[(selClass.length-1)].text == "Seleccione un Curso")
			selClass.options.remove((selClass.length-1));
	}

</script>

<style>
    body {font-family: Arial, Helvetica, sans-serif;}

    /* Fondo del modal */
    .modal {
        display: none; 
        position: fixed;
        z-index: 1;
        padding-top: 100px; /*Posición del modal */
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; /* En caso de ser necesario se puede hacer scroll */
        background-color: rgb(0,0,0); /* Color del fondo */
        background-color: rgba(0,0,0,0.4); /* Color con transparencia */
    }

    /* Contenido del modal */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<nav class="large-3 medium-4 columns" id="actions-sidebar"> 
    <ul class="side-nav">
		
    </ul>
	<!--<button onClick="update()"> pendiente </button>-->
</nav>
<div class="form-size requests form large-9 medium-8 columns content" >
    <?= $this->Form->create($request) ?>
    <fieldset>
        <center><legend><?= __('Agregar Solicitud') ?></legend></center>
        <?php
			//debug(($classes->execute())[1]);

			//Implementacion del bloque que se trae todos los datos del usuario
		?>
		<div class="form-section">
		<legend><?= __('Datos del estudiante') ?></legend>
		<?php
			echo $this->Form->Control('Nombre',['disabled', 'value' => $nombreEstudiante]);
			echo $this->Form->Control( 'student_id2',['label' => 'Carné','disabled', 'value' => $carnet]);
			echo $this->Form->Control('Cédula',['disabled', 'value' => $cedula]);
			echo $this->Form->Control('Correo electrónico ',['disabled', 'value' => $correo]);
			echo $this->Form->Control('Teléfono ',['disabled', 'value' => $telefono]);
		?>
		</div>
		
		<div class="form-section">
		<legend><?= __('Datos del Curso y del Grupo de la Solicitud') ?></legend>
		<?php		
			
            echo $this->Form->control('course_id', ['label' => 'Curso', 'options' => $c3, 'onChange' => 'updateClass()']);
            echo $this->Form->input('class_number',['type' => 'select', 'options' => [], 'controller' => 'Requests', 'onChange' => 'save()', 'label' => 'Grupo:']); //Cambiar options por $ grupos.
			echo $this->Form->input('Nombre curso ', ['id' => 'nc', 'disabled']);
			echo $this->Form->input('Profesor ', ['id' => 'prof', 'disabled', 'type' =>'text']);
		?>
		</div>
		<div class="form-section">
		<legend><?= __('Datos requeridos para la Solicitud') ?></legend>
		<!--	¿Qué tipo de horas desea solicitar? <checkbox></checkbox> <input type="checkbox"> Horas Asistente <input type="checkbox"> Horas Estudiante -->
		<?php
			echo $this->Form->control('wants_student_hours', ['label' => 'Solicito horas estudiante', 'type' => 'checkbox']);
			echo $this->Form->control('wants_assistant_hours', ['label' => 'Solicito horas asistente', 'type' => 'checkbox']);
			echo $this->Form->control('has_another_hours', ['label' => 'Tengo horas asignadas','onclick'=>"toggleAnother()"]);
            echo $this->Form->control('another_student_hours', ['label' => 'Horas estudiante ', 'min' => '3', 'max'=> '12','onchange'=>"requireStudent()",'onclick'=>"requireStudent()"]);
            echo $this->Form->control('another_assistant_hours', ['label' => 'Horas asistente ', 'min' => '3', 'max'=> '20','onchange'=>"requireAssistant()",'onclick'=>"requireAssistant()"]);
        ?>
			<font color="red">* Si no cuenta con un tipo de horas, deje el campo en blanco</font>
		<?php
			echo $this->Form->control('first_time', ['label' => 'Es la primera vez que solicito una asistencia']);
			
			?>
			</div>
			
			
			
						<div id="confirmacion" class="modal", style = "z-index:20">
    <div class="modal-content">
        <div class="files form large-9 medium-8 columns content">

            <fieldset>
                <legend><?= __('Agregar solicitud') ?></legend>
				
				<br>
									<br> </br>


				¿Esta seguro que desea agregar la solicitud?
				

            </fieldset>
            <!--<button type="submit" class="btn btn-primary float-right">Aceptar</button>-->
			 <button id="butCanc" type="reset" class="btn btn-secondary float-right btn-space" onclick="cancelarModal()">Cancelar</button>
			<?php echo $this->Form->button(__('Aceptar'),['class'=>'btn-aceptar', 'onclick'=>'send()']) ?>
	
        

        </div>
    </div>
</div>
			
			
			
			<!--<?php echo $this->Form->button(__('Agregar solicitud'),['class'=>'btn-aceptar', 'onclick'=>'send()']) ?>-->
			<?php 
						echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']); 
			echo $this->Form->control('Agregar Solicitud',['type' => 'button', 'onclick' =>'confirmar()', 'id' => 'btnConfirmacion', 'label' => '','value' => 'Agregar solicitud', 'class'=>'btn-aceptar']);
?>
			
			<?php
			/*echo $this->Form->Label("Datos adicionales Solicitud: ");
			
			echo $this->Form->input('class_semester',['disabled', 'label' => 'Semestre:', 'type' => 'text' , 'value' => $semestre]);
			echo $this->Form->Control('class_year',['disabled', 'label' => 'Año:','value' => $año]);

			*/
			
			/*
				Estos campos solamente sirven para almacenar vectores, dado que esta es la única forma eficiente que conozco de compartir variables
				entre php y javascript. Si conocen una mejor me avisan :)
			*/
			echo $this->Form->control('a1', ['label' => '', 'id' => 'a1', 'type' => 'select' , 'options' => $class , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a2', ['label' => '', 'id' => 'a2', 'type' => 'select' , 'options' => $course , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a3', ['label' => '', 'id' => 'a3', 'type' => 'select' , 'options' => $nombre , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a4', ['label' => '', 'id' => 'a4', 'type' => 'select' , 'options' => $profesor , 'style' => 'visibility:hidden']);
			echo $this->Form->control('c2', ['label' => '', 'id' => 'c2', 'type' => 'select' , 'options' => $c2 , 'style' => 'visibility:hidden']);
			//echo $this->Form->control('a5', ['label' => '', 'id' => 'a5', 'type' => 'select' , 'options' => $id , 'style' => 'visibility:hidden', 'height' => '1px']);


			
			
			
			
			
			
			
			?>
			
			


		
    </fieldset>

	
	<!--<?= $this->Html->link(__('Dejar Solicitud Pendiente'), ['controller' => 'Requests', 'action' => 'save', 'type' => 'submit']) ?>-->
    <?= $this->Form->end() ?>
	   <!--<button class="button"><?= $this->Html->link('Cancelar',['controller'=>'RequestsController','action'=>'index'],['class'=>'nav-link']) ?></button>-->

	
	
</div>



<script>
	// Inicia Daniel Marín
	// función inicial 
	$(document).ready( function () {			
		byId('another-student-hours').disabled = true;
		byId('another-assistant-hours').disabled = true;
	});
	/** Función toggleAnother
	 * EFE: activa o desactiva los campos de otras horas
	 **/
	function toggleAnother(){
		if(byId('has-another-hours').checked){
			byId('another-student-hours').disabled = false;
			byId('another-student-hours').required = true;
			byId('another-student-hours').max = 12;
			byId('another-assistant-hours').disabled = false;
			byId('another-assistant-hours').required = true;
			byId('another-assistant-hours').max = 20;
		}else{
			byId('another-student-hours').disabled = true;
			byId('another-student-hours').value = null;
			byId('another-student-hours').required = false;
			byId('another-assistant-hours').disabled = true;
			byId('another-assistant-hours').value = null;
			byId('another-assistant-hours').required = false;
		}
	}

	/** Función unrequireStudent
	 * EFE: activa o desactiva el requerir el campo otras horas estudiante 
	 **/
	function requireStudent(){
		byId('another-student-hours').required = true;
		if(!byId('another-assistant-hours').value){
			byId('another-assistant-hours').required = false;
		}
		if(20 > 20 - byId('another-student-hours').value){
			console.log('cambio assitant')
			byId('another-assistant-hours').max = 20 - byId('another-student-hours').value;
			if(20-byId('another-student-hours').value<3)byId('another-assistant-hours').value = ''; 
		}else{
			byId('another-assistant-hours').max = 20;
		}
		
	}

	/** Función unrequireAssitant
	 * EFE: activa o desactiva el requerir el campo otras horas asistente
	 **/
	function requireAssistant(){
		byId('another-assistant-hours').required = true;
		if(!byId('another-student-hours').value){
			byId('another-student-hours').required = false;
		}
		if(12 > 20 - byId('another-assistant-hours').value){
			byId('another-student-hours').max = 20-byId('another-assistant-hours').value;
		}else{
			byId('another-student-hours').max = 12;
		}
		if(byId('another-assistant-hours').value>17){
			byId('another-student-hours').disabled = true;
			byId('another-student-hours').value = null;
		}else{
			byId('another-student-hours').disabled = false;
		}
		
		
	}

	/** Función send
	 * EFE: habilita los campos de otras horas para enviarlos en el form
	 **/
	function send(){
		byId('another-student-hours').disabled = false;
		byId('another-assistant-hours').disabled = false;
		// autor: ...
		var modal = byId("confirmacion");
		modal.style.display = "none";

		$('html,body').scrollTop(0);		
		
	}

	/** Función byId
	 * EFE: Función wrapper de getElementById
	 * REQ: Id del elemento a obtener.
	 * RET: Elemento requerido.
	 **/
	function byId(id) {
		return document.getElementById(id);
	}
	//termina Daniel M
	function confirmar()
	{
		var modal = byId("confirmacion");
		modal.style.display = "block";
	}
	

	

	
	function cancelarModal()
	{
		var modal = byId("confirmacion");
		modal.style.display = "none";
		
		byId('has-another-hours').checked = false;
		byId('another-student-hours').disabled = true;
		byId('another-assistant-hours').disabled = true;
	}
</script>