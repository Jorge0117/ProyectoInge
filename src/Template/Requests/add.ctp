<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
 use Cake\Routing\Router;
?>



<style>
    .button {
        background-color: #ceb92bff;
        border: none;
        padding: 5px 7px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 8px 2px;
        cursor: pointer;
        float: right;
    }
    .button a {
        color:#fff; 
    }
    /* .actions a {
        color:#000; 
    } */
    #image1 {
        height: 10px;
        width: 10px;
    }
	
	.form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }
	
	.form-size{
        width: 70%;
        min-width: 200px;
        padding-left: 50px;
    }
	
	.btn-aceptar{
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
    }
	
	.btn-cancelar{
        background-color: #999999;
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
        margin-right: 5px;
    }
	
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<script>
	/*
	Esta funcion se encarga de cargar el valor de select de grupos en base al valor ingresado en el select de curso.
	Ejemplo: Si se selecciona curso ci1314, entonces el select de grupos almacenara todos los grupos en los que se imparte dicho curso
	*/
	function updateClass() 
	{

		//Obtiene los select de grupo y curso respectivamente
		selClass = document.getElementById("class-number");
		selCourse = document.getElementById("course-id");
		
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
		actualCourse = selCourse.options[selCourse.selectedIndex].text;

		
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
		Course = selCourse.options[selCourse.selectedIndex].text;
		Group = selClass.options[selClass.selectedIndex].text;
		//Realiza una peticion al servidor mediante la tecnica AJAX, para obtener el nombre del profesor en base al curso y grupo actual
		$.ajax({
	url:"<?php echo \Cake\Routing\Router::url(array('controller'=>'Requests','action'=>'obtenerProfesor'));?>" ,   cache: false,
    type: 'GET',
	contentType: 'application/json; charset=utf-8',
    dataType: 'text',
	async: false,
	data: { curso: Course, grupo: Group, salida:"xdxd"},
    success: function (data) {
       // $('#context').html(data);
	    p = data.split(" ");
		
		//Mete en el campo bloqueado la informacion del profesor
		document.getElementById("prof").value = (p[6] + " " + p[7]).split(")")[0]; 
	},
	error: function(jqxhr, status, exception)
	{
		alert(exception);

	}
		});
		
		//Ahora que se selecciono un curso, ya no es necesario que aparezca esta opcion
		if(selClass.options[(selClass.length-1)].text == "Seleccione un Curso")
			selClass.options.remove((selClass.length-1));
	}
	
	function hidePersonalInfo()
	{
		alert("");
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
        <legend><?= __('Añadir Solicitud') ?></legend>
        <?php
			//debug(($classes->execute())[1]);
			echo $this->Form->control('a1', ['label' => '', 'id' => 'a1', 'type' => 'select' , 'options' => $class , 'style' => 'visibility:hidden']);

			//Implementacion del bloque que se trae todos los datos del usuario
		?>
		<div class="form-section">
		<legend><?= __('Datos del estudiante') ?></legend>
		<?php
			echo $this->Form->Control('Nombre del Estudiante: ',['disabled', 'value' => $nombreEstudiante]);
			echo $this->Form->Control( 'student_id',['label' => 'Carnet del Estudiante:','disabled', 'value' => $carnet]);
			echo $this->Form->Control('Cedula: ',['disabled', 'value' => $cedula]);
			echo $this->Form->Control('Correo Eléctronico: ',['disabled', 'value' => $correo]);
			echo $this->Form->Control('Telefono: ',['disabled', 'value' => $telefono]);
		?>
		</div>
		
		<div class="form-section">
		<legend><?= __('Datos del Curso y del Grupo de la Solicitud') ?></legend>
		<?php		
			
            echo $this->Form->control('course_id', ['label' => 'Curso:', 'options' => $c2, 'onChange' => 'updateClass()']);
            echo $this->Form->input('class_number',['type' => 'select', 'options' => [], 'controller' => 'Requests', 'onChange' => 'save()', 'label' => 'Grupo:']); //Cambiar options por $ grupos.
			echo $this->Form->input('Nombre Curso: ', ['id' => 'nc', 'disabled']);
			echo $this->Form->input('Profesor Que Imparte el Curso: ', ['id' => 'prof', 'disabled', 'type' =>'text']);
			echo $this->Form->control('average', ['label' => 'Promedio Ponderado', 'type' => 'text']);
		?>
		</div>
		<div class="form-section">
		<legend><?= __('Datos requeridos para la Solicitud') ?></legend>
			¿Qué tipo de horas desea solicitar? <checkbox></checkbox> <input type="checkbox"> Horas Asistente <input type="checkbox"> Horas Estudiante
		<?php
			echo "\n";
            //echo $this->Form->control('student_id', ['options' => $students]);

			echo $this->Form->control('has_another_hours', ['label' => 'Tengo otras Horas Asignadas']);
            echo $this->Form->control('another_student_hours', ['label' => 'Cantidad de horas estudiante ya asignadas: ']);
            echo $this->Form->control('another_assistant_hours', ['label' => 'Cantidad de horas asistente ya asignadas: ']);

            echo $this->Form->control('first_time', ['label' => 'Es la primera vez que solicito una asistencia']);
			?>
			</div>
			<?php
			/*echo $this->Form->Label("Datos adicionales Solicitud: ");
			
			echo $this->Form->input('class_semester',['disabled', 'label' => 'Semestre:', 'type' => 'text' , 'value' => $semestre]);
			echo $this->Form->Control('class_year',['disabled', 'label' => 'Año:','value' => $año]);

			*/
			
			/*
				Estos campos solamente sirven para almacenar vectores, dado que esta es la única forma eficiente que conozco de compartir variables
				entre php y javascript. Si conocen una mejor me avisan :)
			*/
			echo $this->Form->control('a2', ['label' => '', 'id' => 'a2', 'type' => 'select' , 'options' => $course , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a3', ['label' => '', 'id' => 'a3', 'type' => 'select' , 'options' => $nombre , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a4', ['label' => '', 'id' => 'a4', 'type' => 'select' , 'options' => $teacher , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a5', ['label' => '', 'id' => 'a5', 'type' => 'select' , 'options' => $id , 'style' => 'visibility:hidden', 'height' => '1px']);



		?>
    </fieldset>
   <?php echo $this->Form->button(__('Agregar Solicitud'),['class'=>'btn btn-primary btn-aceptar']) ?>
   <?php echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']); ?>
   <!-- <button class="button"><?= $this->Html->link('Agregar Solicitud',['controller'=>'requests','action'=>'add'],['class'=>'nav-link']) ?></button> -->

	<!--<?= $this->Html->link(__('Dejar Solicitud Pendiente'), ['controller' => 'Requests', 'action' => 'save', 'type' => 'submit']) ?>-->
    <?= $this->Form->end() ?>
	   <!--<button class="button"><?= $this->Html->link('Cancelar',['controller'=>'RequestsController','action'=>'index'],['class'=>'nav-link']) ?></button>-->

	
	
</div>

