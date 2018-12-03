<?php
/**
 * @author Nathan González
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<!-- Se crea un contenedor para el form. -->
<div class="form-section">

    <!-- Se busca crear un nuevo requisito desde el form. -->
    <?= $this->Form->create($requirement) ?>

    <div class='container'>
        <div class='row'>
            <div class="col align-self-center">

                <!-- Titulo de la vista. -->
                <h3><?= __('Editar requisito') ?></h3>

                <?php

                    //Entreda para ingresar la descripción del requisito (línea de caracteres).
                    echo $this->Form->input('description',['label' => 'Descripción del requisito', 'class' => 'form-control']);
            
                    //Entrada para ingresar el tipo de requisito (radio box).
                    echo $this->Form->label('Tipo del requisito');
                    echo '<br>';
                    echo $this->Form->radio(
                        'type',
                        [
                            ['value' => 'Obligatorio', 'text' => '<span style="padding:0 10px 0 10px;">Obligatorio</span>'],
                    
                            ['value' => 'Opcional', 'text' => '<span style="padding:0 10px 0 10px;">Opcional</span>'],
                        ],
                        [ 
                            'div' => false,
                            'class' => 'col-md-15', 
                            'escape' => false,
                        ]
                    );

                    echo '<br>';

                    //Entrada para ingresar el tipo de horas (radio box).
                    echo $this->Form->label('Tipo de horas');
                    echo '<br>';
                    echo $this->Form->radio(
                        'hour_type',
                        [
                            ['value' => 'Estudiante', 'text' => '<span style="padding:0 10px 0 10px;">Horas Estudiante</span>'],
                    
                            ['value' => 'Asistente', 'text' => '<span style="padding:0 10px 0 10px;">Horas Asistente</span>'],

                            ['value' => 'Ambos', 'text' => '<span style="padding:0 10px 0 10px;">Ambas</span>'],
                        ],
                        [ 
                            'div' => false,
                            'class' => 'col-md-15', 
                            'escape' => false,
                        ]
                    );

                ?>
            <div>
        <div>
    <div>

    <div class='container'>
        <div class='row'>
            <div class='col self-align-end'>

                <!-- Botón de agregar, cuando es presionado se ingresa la nueva tupla a la base de datos. -->
                <button type="submit" class='btn btn-primary btn-space btn-aceptar'>
                    Aceptar
                </button>

                <!-- Botón de cancelar, cuando es presionado se regresa a el index de los requisitos. -->
                <?= $this->Html->link('Cancelar',['controller'=>'Requirements','action'=>'index'],['class'=>'btn btn-primary float-right btn-space btn-cancelar']) ?>
            
            <div>
        <div>
    <div>
    
    <!-- Final del form -->
    <?= $this->Form->end() ?>

</div>