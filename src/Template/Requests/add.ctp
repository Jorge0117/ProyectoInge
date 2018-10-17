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
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<script>
	function updateClass() //Se encarga de actualizar dinamicamente el select de clases
	{

		selClass = document.getElementById("class-number");
		selCourse = document.getElementById("course-id");
		a1 = document.getElementById("a1");
		a2 = document.getElementById("a2");
		
		//elimina todas las opciones de clase:
		var l = selClass.options.length;
		
		for(j = 0; j < l; j = j + 1)
		{
			selClass.options.remove(0);
		}
		
		actualCourse = selCourse.options[selCourse.selectedIndex].text;

		courses = a2.options;
		i = 0;
		var tmp2 = document.createElement("option");
		tmp2.text = "Seleccione un Curso"
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
				tmp.text = a1.options[c+1].text;
				selClass.options.add(tmp,i);
				i = i + 1;
				
			}

		}
		
		//selClass.options = [1,2,3];
		txtNombre = document.getElementById("nc");
		if(selCourse.selectedIndex != 0)
			txtNombre.value = document.getElementById("a3").options[selCourse.selectedIndex-1].text;
		else
			txtNombre.value = "";
		
		
		var x = document.getElementById("course-id").options;
		l = x.length;
		s = x.selectedIndex;
		
		if(x[0].value == "0") //Realiza el cambio
		{
			//selCourse = document.getElementById("course-id");
			var cursos = [];
			for(i = 0; i < l; ++i)
			{
				cursos.push(selCourse.options[0].text);
				selCourse.options.remove(0);
				
				
			}
			
			for(j = 0; j < l; ++j)
			{
				var tmp = document.createElement("option");
				tmp.value = cursos[j];
				tmp.text = cursos[j];
				selCourse.options.add(tmp,j);
			}
		}

		selCourse.selectedIndex = s;
		

	}
	function save()
	{
		selClass = document.getElementById("class-number");
		selCourse = document.getElementById("course-id");
		
		Course = selCourse.options[selCourse.selectedIndex].text;
		Group = selClass.options[selClass.selectedIndex].text;
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
		
		document.getElementById("prof").value = (p[6] + " " + p[7]).split(")")[0];
	},
	error: function(jqxhr, status, exception)
	{
		alert(exception);

	}
		});
		
		if(selClass.options[(selClass.length-1)].text == "Seleccione un Curso")
			selClass.options.remove((selClass.length-1));
	}

</script>
<nav class="large-3 medium-4 columns" id="actions-sidebar"> 
    <ul class="side-nav">
		
    </ul>
	<!--<button onClick="update()"> pendiente </button>-->
</nav>
<div class="requests form large-9 medium-8 columns content" >
    <?= $this->Form->create($request) ?>
    <fieldset>
        <legend><?= __('Añadir Solicitud') ?></legend>
        <?php
			//debug(($classes->execute())[1]);
			echo $this->Form->control('a1', ['label' => '', 'id' => 'a1', 'type' => 'select' , 'options' => $class , 'style' => 'visibility:hidden']);

            echo $this->Form->control('course_id', ['label' => 'Curso:', 'options' => $c2, 'onChange' => 'updateClass()']);
            echo $this->Form->input('class_number',['type' => 'select', 'options' => [], 'controller' => 'Requests', 'onChange' => 'save()', 'label' => 'Grupo:']); //Cambiar options por $ grupos.
			echo $this->Form->input('Nombre Curso: ', ['id' => 'nc', 'disabled']);
			echo $this->Form->input('Profesor Que Imparte el Curso: ', ['id' => 'prof', 'disabled', 'type' =>'text']);
			echo $this->Form->control('average', ['label' => 'Promedio Ponderado']);
		?>
			¿Qué tipo de horas desea solicitar? <checkbox></checkbox> <input type="checkbox"> Horas Asistente <input type="checkbox"> Horas Estudiante
		<?php
			echo "\n";
            //echo $this->Form->control('student_id', ['options' => $students]);

			echo $this->Form->control('has_another_hours', ['label' => 'Tengo otras Horas Asignadas']);
            echo $this->Form->control('another_student_hours', ['label' => 'Cantidad de horas estudiante ya asignadas: ']);
            echo $this->Form->control('another_assistant_hours', ['label' => 'Cantidad de horas asistente ya asignadas: ']);

            echo $this->Form->control('first_time', ['label' => 'Es la primera vez que solicito una asistencia']);
			echo $this->Form->control('a2', ['label' => '', 'id' => 'a2', 'type' => 'select' , 'options' => $course , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a3', ['label' => '', 'id' => 'a3', 'type' => 'select' , 'options' => $nombre , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a4', ['label' => '', 'id' => 'a4', 'type' => 'select' , 'options' => $teacher , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a5', ['label' => '', 'id' => 'a5', 'type' => 'select' , 'options' => $id , 'style' => 'visibility:hidden']);
			$urlControlador = \Cake\Routing\Router::url(array('controller'=>'Requests','action'=>'add'));
			echo $urlControlador;

			

		?>
    </fieldset>
   <?= $this->Form->button(__('Agregar Solicitud'),['class'=>'btn btn-primary']) ?>
   <!-- <button class="button"><?= $this->Html->link('Agregar Solicitud',['controller'=>'requests','action'=>'add'],['class'=>'nav-link']) ?></button> -->

	<!--<?= $this->Html->link(__('Dejar Solicitud Pendiente'), ['controller' => 'Requests', 'action' => 'save', 'type' => 'submit']) ?>-->
    <?= $this->Form->end() ?>
	   <!--<button class="button"><?= $this->Html->link('Cancelar',['controller'=>'RequestsController','action'=>'index'],['class'=>'nav-link']) ?></button>-->

	
	
</div>

