<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
 use Cake\Routing\Router;
?>

<style>
	/* Esta clase se usa para campos ocultos */
	.no-size {
		margin: 0px;
		padding: 0px;
		width: 0px;
		height: 0px;
		visibility:hidden;
	}
</style>

<?php 
	/**
	 * Este script contiene todas las funciones que se usan en la vista.
	 */
	echo $this->Html->script('views/agregar_solicitud.js');
?>

<div class="form-size requests form large-9 medium-8 columns content" >
    <?= $this->Form->create($request) ?>
    <fieldset>
        <center><legend><?= __('Agregar Solicitud') ?></legend></center>
        <?php

            //Implementacion del bloque que se trae todos los datos del usuario
        ?>
        <div class="form-section">
            <legend><?= __('Datos del estudiante') ?></legend>
            <?php
                echo $this->Form->Control('Nombre',['disabled', 'value' => $nombreEstudiante]);
                echo $this->Form->Control( 'student_id2',['label' => 'Carné','disabled', 'value' => strtoupper($carnet)]);
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
        <legend><?= __('Tipos de horas solicitadas') ?></legend>
        <!--    ¿Qué tipo de horas desea solicitar? <checkbox></checkbox> <input type="checkbox"> Horas Asistente <input type="checkbox"> Horas Estudiante -->
            <?php
                echo $this->Form->control('wants_student_hours', ['label' => 'Solicito horas estudiante', 'type' => 'checkbox']);
                echo $this->Form->control('wants_assistant_hours', ['label' => 'Solicito horas asistente', 'type' => 'checkbox']);
				?><font color="red">* Debe solicitar al menos un tipo de hora</font><?php
                echo '<hr/>';
			?>
			<legend><?= __('Datos de otras asistencias') ?></legend>
			<?php
                echo $this->Form->control('has_another_hours', ['label' => 'Tengo otras horas asignadas','onclick'=>"toggleAnother()"]);
                echo $this->Form->control('another_student_hours', ['label' => 'Horas estudiante ', 'min' => '3', 'max'=> '12','onchange'=>"requireStudent()",'onclick'=>"requireStudent()"]);
                echo $this->Form->control('another_assistant_hours', ['label' => 'Horas asistente ', 'min' => '3', 'max'=> '20','onchange'=>"requireAssistant()",'onclick'=>"requireAssistant()"]);
            ?>
            <font color="red">* Si no cuenta con un tipo de horas, deje el campo vacío</font>
            <hr/>
            <?php
                echo $this->Form->control('first_time', ['label' => 'Es la primera vez que solicito una asistencia']);
            ?>
        </div>
                            
        <?= $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']) ?>
		<?= $this->Form->button('Agregar Solicitud',['id' => 'btnConfirmacion', 'class'=>'btn btn-primary btn-aceptar', 'type'=>'button', 'data-toggle' => 'modal', 'data-target' => '#confirmacion']) ?>
    
        <?php
            /**
             *  Estos campos solamente sirven para almacenar vectores, dado que esta es la única forma eficiente que conozco de compartir variables
             *  entre php y javascript. Si conocen una mejor me avisan :)
			 * 
			 * TODO:
			 * La próxima use el HTML helper para insertar codigo js inline y/o JQuery para setear las variable en contexto global.
            */
            echo $this->Form->text('a1', ['label' => '', 'id' => 'a1', 'type' => 'select' , 'options' => $class , 'class' => 'no-size']);
            echo $this->Form->text('a2', ['label' => '', 'id' => 'a2', 'type' => 'select' , 'options' => $course , 'class' => 'no-size']);
            echo $this->Form->text('a3', ['label' => '', 'id' => 'a3', 'type' => 'select' , 'options' => $nombre , 'class' => 'no-size']);
            echo $this->Form->text('a4', ['label' => '', 'id' => 'a4', 'type' => 'select' , 'options' => $profesor , 'class' => 'no-size']);
            echo $this->Form->text('c2', ['label' => '', 'id' => 'c2', 'type' => 'select' , 'options' => $c2 , 'class' => 'no-size']);
            //echo $this->Form->control('a5', ['label' => '', 'id' => 'a5', 'type' => 'select' , 'options' => $id , 'style' => 'visibility:hidden', 'height' => '1px']);
        ?>

		<div id="confirmacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmacion	Label" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
							<h5 class="modal-title">Agregar Solicitud</h5>
					</div>
					<div class="modal-body">
						<p id="mensajeConfirmacion">¿Esta seguro que desea agregar la solicitud?</p>
					</div>
					<div class="modal-footer">
						<button type="button" id="butCanc" class="btn btn-secondary" onclick="cancelarModal()">Cancelar</button>
						<?= $this->Form->button('Aceptar', ["type" => "submit", "class" => "btn btn-primary btn-aceptar", "onclick" => "send()"]) ?>
					</div>
				</div>
			</div>
		</div>

    </fieldset>    
    <?= $this->Form->end() ?>
</div>
