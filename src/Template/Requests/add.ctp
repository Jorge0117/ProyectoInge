<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
 use Cake\Routing\Router;
?>

<style>

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
            //debug(($classes->execute())[1]);

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
        <legend><?= __('Datos requeridos para la Solicitud') ?></legend>
        <!--    ¿Qué tipo de horas desea solicitar? <checkbox></checkbox> <input type="checkbox"> Horas Asistente <input type="checkbox"> Horas Estudiante -->
            <?php
                echo $this->Form->control('wants_student_hours', ['label' => 'Solicito horas estudiante', 'type' => 'checkbox']);
                echo $this->Form->control('wants_assistant_hours', ['label' => 'Solicito horas asistente', 'type' => 'checkbox']);
                echo '<hr/>';
                echo $this->Form->control('has_another_hours', ['label' => 'Tengo horas asignadas','onclick'=>"toggleAnother()"]);
                echo $this->Form->control('another_student_hours', ['label' => 'Horas estudiante ', 'min' => '3', 'max'=> '12','onchange'=>"requireStudent()",'onclick'=>"requireStudent()"]);
                echo $this->Form->control('another_assistant_hours', ['label' => 'Horas asistente ', 'min' => '3', 'max'=> '20','onchange'=>"requireAssistant()",'onclick'=>"requireAssistant()"]);
            ?>
            <font color="red">* Si no cuenta con un tipo de horas, deje el campo en blanco</font>
            <hr/>
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
                        <br>
                        </br>
                        <label id="mensajeConfirmacion"> ¿Esta seguro que desea agregar la solicitud? </label>
                    </fieldset>
                    <!--<button type="submit" class="btn btn-primary float-right">Aceptar</button>-->
                    <button id="butCanc" type="reset" class="btn btn-secondary float-right btn-space" onclick="cancelarModal()">Cancelar</button>
                    <?php echo $this->Form->button(__('Aceptar'),['class'=>'btn-aceptar', 'onclick'=>'send()']) ?>

                </div>
            </div>
        </div>
                            
        <?php echo $this->Form->button(__('Agregar solicitud'),['class'=>'btn-aceptar', 'onclick'=>'send()']) ?>
        <?php 
            echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']); 
            echo $this->Form->control('Agregar Solicitud',['type' => 'button', 'onclick' =>'confirmar()', 'id' => 'btnConfirmacion', 'label' => '','value' => 'Agregar solicitud', 'class'=>'btn-aceptar']);
        ?>
            
        <?php
            /*
            echo $this->Form->Label("Datos adicionales Solicitud: ");
            echo $this->Form->input('class_semester',['disabled', 'label' => 'Semestre:', 'type' => 'text' , 'value' => $semestre]);
            echo $this->Form->Control('class_year',['disabled', 'label' => 'Año:','value' => $año]);
            */

            /**
             *  Estos campos solamente sirven para almacenar vectores, dado que esta es la única forma eficiente que conozco de compartir variables
             *  entre php y javascript. Si conocen una mejor me avisan :)
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

    <button id="butAceptar" class="btn btn-primary float-right btn-space">Mensaje</button>
    <button type="submit" class="btn btn-primary float-right">Aceptar</button>
    
</div>

<div id="MensajeInformativo" class="modal">
    <div class="modal-content">
        <div class="files form large-9 medium-8 columns content">
            
            <fieldset>
                    <legend><?= __('Atención') ?></legend>
                    Este documento debe ser impreso y presentado en la secretaría de la Escuela de Ciencias de la Computación e Informática.<br>
                    Si es su primera asistencia, favor presentar una carta de un banco público que certifique su número de cuenta en colones de ahorro o cuenta corriente <br>
                    y una fotocopia legible de la cédula de identidad por ambos lados.
                    <br>
                    <b>Fecha límite: <?php echo $ronda[0]['end_date']; ?></b>
                    <br>
            </fieldset>
            <fieldset>
                <?= $this->Html->link('Aceptar',['controller'=>'requests','action'=>'index'],['class'=>'btn btn-primary float-middle btn-space']) ?>
            </fieldset>
        
            
        </div>
    </div>
</div>