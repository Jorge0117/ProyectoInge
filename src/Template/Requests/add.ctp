<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>

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
		for(c = 0;  c < courses.length; c = c + 1) // Recorre los cursos
		{
			//Si el curso es el mismo al curso seleccionado, manda el grupo al vector
			if(actualCourse.localeCompare(courses[c].text) == 0)
			{
				var tmp = document.createElement("option");
				tmp.text = a1.options[c].text;
				selClass.options.add(tmp,i);
				i = i + 1;
			}
		}
		
		selClass.options = [1,2,3];
	
		

	}
</script>
<nav class="large-3 medium-4 columns" id="actions-sidebar"> 
    <ul class="side-nav">
		
    </ul>
	<button onClick="update()"> pendiente </button> 
</nav>
<div class="requests form large-9 medium-8 columns content" >
    <?= $this->Form->create($request) ?>
    <fieldset>
        <legend><?= __('Añadir Solicitud') ?></legend>
        <?php
			//debug(($classes->execute())[1]);
            echo $this->Form->control('course_id', ['label' => 'Curso:', 'options' => $c2, 'onChange' => 'updateClass()']);
            echo $this->Form->input('class_number',['type' => 'select', 'options' => [], 'controller' => 'Requests', 'onChange' => 'save', 'label' => 'Grupo:']); //Cambiar options por $ grupos.
			echo $this->Form->input('Nombre Curso: ', ['id' => 'nc', 'disabled']);
			echo $this->Form->input('Profesor Que Imparte el Curso: ', ['id' => 'prof', 'disabled']);
            //echo $this->Form->control('student_id', ['options' => $students]);
			echo $this->Form->control('average', ['label' => 'Promedio Ponderado']);
			echo $this->Form->control('has_another_hours', ['label' => 'Tengo otras Horas Asignadas']);
            echo $this->Form->control('another_student_hours', ['label' => 'Cantidad de horas estudiante ya asignadas: ']);
            echo $this->Form->control('another_assistant_hours', ['label' => 'Cantidad de horas asistente ya asignadas: ']);

            echo $this->Form->control('first_time', ['label' => 'Es la primera vez que solicito una asistencia']);
			
			$variable = $this->Cell('Requests');
			
			echo $this->Form->control('a1', ['label' => '', 'id' => 'a1', 'type' => 'select' , 'options' => $class , 'style' => 'visibility:hidden']);
			echo $this->Form->control('a2', ['label' => '', 'id' => 'a2', 'type' => 'select' , 'options' => $course , 'style' => 'visibility:hidden']);
			debug($teacher);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
	<?= $this->Html->link(__('Dejar Solicitud Pendiente'), ['controller' => 'Requests', 'action' => 'save', 'type' => 'submit']) ?>
    <?= $this->Form->end() ?>
	
	
	
	
</div>
updateClass();
