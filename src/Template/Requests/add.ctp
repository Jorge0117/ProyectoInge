<script>
	function guardar()
	{		
		//Recupera los datos:
		
		class_number = document.getElementById('class_number').value;
		Grupo = document.getElementById('Grupo').value;
		aah = document.getElementById('aah').value;
		ash = document.getElementById('ash').value;
	
		
		alert("Los datos han sido guardados para la proxima vez que ingrese la solicitud");
		
		
	}
</script>


<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
	<button id="saveRequestbtn" onClick="guardar();"> Dejar Pendiente</button>
</nav>
<div class="requests form large-9 medium-8 columns content">
    <?= $this->Form->create($request) ?>
				
    <fieldset>
        <legend><?= __('Add Request') ?></legend>
        <?php
			
		//	echo $this->Form->control('id', ['value' =>'2']);
           echo $this->Form->control('round_number',['value' => '1','type' => 'hidden']);
            echo $this->Form->control('round_semester',['value' => '1','type' => 'hidden']);
            echo $this->Form->control('round_year',['value' => '2018','type' => 'hidden','id' => 'round_year']);
			//PEDIR a controladora RONDa
			
	
			
            echo $this->Form->control('reception_date',['type' => 'hidden', 'value' => date('Y-m-d H:i:s')]); //INNECESARIA, ya que se puede generar con funcion que obtenga dia de hoy
			
           // echo $this->Form->control('Año');  //Preguntarle a la profesora si debo pedirlo. Igual el semestre
			echo $this->Form->control('class_year');
            echo $this->Form->control('Curso', ['options' => $courses]); /*Podria ser combo box. En caso de que si, PEDIR*/		
           // echo $this->Form->control('Semestre');
			
			echo $this->Form->control('class_semester');
            echo $this->Form->control('class_number', ['id' => 'class_number']);
			
            echo $this->Form->control('grupo',['id' => 'Grupo']); /*También deberia ser comboBox y debo PEDIRLO*/
			
           //echo $this->Form->control('student_id', ['options' => $students]);// PEDIRLO 
			echo $this->Form->control('student_id', ['options' => ['A12345']]);
			
            echo $this->Form->control('status', ['value' => 'p','type' => 'hidden']);  //Jamas deberia salir
			
			 echo $this->Form->control('round_year',['value' => '2018']);

			
            echo $this->Form->control('another_assistant_hours' ,['value' => '1', 'id' => 'aah']);
            echo $this->Form->control('another_student_hours',['value' => '1', 'id' => 'ash']);

			
        ?>
    </fieldset>

	<BR>
    <?= $this->Form->button(__('Submit')) ?>
	
	
	

    <?= $this->Form->end() ?>
	
</div>
