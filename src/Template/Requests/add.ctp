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
			echo $this->Form->Control('Nombre:',['disabled', 'value' => $nombreEstudiante]);
			echo $this->Form->Control( 'student_id2',['label' => 'Carnet:','disabled', 'value' => $carnet]);
			echo $this->Form->Control('Cédula:',['disabled', 'value' => $cedula]);
			echo $this->Form->Control('Correo electrónico: ',['disabled', 'value' => $correo]);
			echo $this->Form->Control('Teléfono: ',['disabled', 'value' => $telefono]);
		?>
		</div>
		
		<div class="form-section">
		<legend><?= __('Datos del Curso y del Grupo de la Solicitud') ?></legend>
		<?php		
			
            echo $this->Form->control('course_id', ['label' => 'Curso:', 'options' => $c3, 'onChange' => 'updateClass()']);
            echo $this->Form->input('class_number',['type' => 'select', 'options' => [], 'controller' => 'Requests', 'onChange' => 'save()', 'label' => 'Grupo:']); //Cambiar options por $ grupos.
			echo $this->Form->input('Nombre del curso: ', ['id' => 'nc', 'disabled']);
			echo $this->Form->input('Profesor: ', ['id' => 'prof', 'disabled', 'type' =>'text']);
		?>
		</div>
		<div class="form-section">
		<legend><?= __('Datos requeridos para la Solicitud') ?></legend>
		<!--	¿Qué tipo de horas desea solicitar? <checkbox></checkbox> <input type="checkbox"> Horas Asistente <input type="checkbox"> Horas Estudiante -->
		<?php
			echo $this->Form->control('wants_student_hours', ['label' => 'Solicito horas estudiante', 'type' => 'checkbox']);
			echo $this->Form->control('wants_assistant_hours', ['label' => 'Solicito horas asistente', 'type' => 'checkbox']);
			echo $this->Form->control('has_another_hours', ['label' => 'Tengo horas asignadas','onclick'=>"toggleAnother()"]);
            echo $this->Form->control('another_student_hours', ['label' => 'Horas estudiante: ', 'min' => '3', 'max'=> '12','onchange'=>"unrequireAssitant()"]);
            echo $this->Form->control('another_assistant_hours', ['label' => 'Horas asistente: ', 'min' => '3', 'max'=> '12','onchange'=>"unrequireStudent()"]);

            echo $this->Form->control('first_time', ['label' => 'Es la primera vez que solicito una asistencia']);
			?>
			</div>
			

			<?php echo $this->Form->button(__('Agregar Solicitud'),['class'=>'btn-aceptar', 'onclick'=>'send()']) ?>
			<?php echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']); ?>
			
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

   <!-- <button class="button"><?= $this->Html->link('Agregar Solicitud',['controller'=>'requests','action'=>'add'],['class'=>'nav-link']) ?></button> -->

	<!--<?= $this->Html->link(__('Dejar Solicitud Pendiente'), ['controller' => 'Requests', 'action' => 'save', 'type' => 'submit']) ?>-->
    <?= $this->Form->end() ?>
	   <!--<button class="button"><?= $this->Html->link('Cancelar',['controller'=>'RequestsController','action'=>'index'],['class'=>'nav-link']) ?></button>-->

	
	
</div>

<script>

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
			byId('another-assistant-hours').disabled = false;
			byId('another-assistant-hours').required = true;
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
	function unrequireStudent(){
		byId('another-student-hours').required = false;
	}

	/** Función unrequireAssitant
	 * EFE: activa o desactiva el requerir el campo otras horas asistente
	 **/
	function unrequireAssitant(){
		byId('another-assistant-hours').required = false;
	}

	/** Función send
	 * EFE: habilita los campos de otras horas para enviarlos en el form
	 **/
	function send(){
		byId('another-student-hours').disabled = false;
		byId('another-assistant-hours').disabled = false;
	}

	/** Función byId
	 * EFE: Función wrapper de getElementById
	 * REQ: Id del elemento a obtener.
	 * RET: Elemento requerido.
	 **/
	function byId(id) {
		return document.getElementById(id);
	}
</script>