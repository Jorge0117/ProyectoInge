<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<!-- Se crea un contenedor para el form. -->
<div class="container">
    
    <!-- Se crea el form. -->
    <div class="requirements form col-lg-8 col-offset-4 centered">
        
        <!-- Se busca crear un nuevo requisito desde el form, para modificarlo. -->
        <?= $this->Form->create($requirement) ?>
    
        <fieldset>

            <!-- Titulo de la vista. -->
            <h3><?= __('Editar requisito') ?></h3>
        
            <?php

                //Entreda para ingresar la nueva descripción del requisito (línea de caracteres).
                echo $this->Form->input('description',['label' => 'Descripción del requisito', 'class' => 'form-control']);
                
                //Entrada para ingresar el nuevo tipo de requisito (radio box).
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

            ?>
            <br> <br>
            <br> <br>

            <!-- Botón de modificar, cuando es presionado se ingresa la modificación de la tupla a la base de datos. -->
            <button type="submit" class="btn btn-primary" style='position:absolute; left: 86.3%; top: 77.8%;'>
                Modificar
            </button>

            <!-- Botón de cancelar, cuando es presionado se regresa a el index de los requisitos. -->
            <?= $this->Html->link('Cancelar',['controller'=>'Requirements','action'=>'index'],['class'=>'btn btn-secondary', 'style'=>'position:absolute; left: 1.5%; top: 77.8%;']) ?>
        </fieldset>

    </div>

    <!-- Final del form -->
    <?= $this->Form->end() ?>

</div>