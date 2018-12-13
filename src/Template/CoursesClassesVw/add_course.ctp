<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CoursesClassesVw $coursesClassesVw
 */
?>

<div class="coursesClassesVw form large-9 medium-8 columns content form-size">
    <?= $this->Form->create($coursesClassesVw) ?>
    <fieldset>
        <h3><?= __('Agregar curso') ?></h3>

        <div class="form-section">
            <?php
                echo $this->Form->control('Sigla', ['pattern' => "[A-Z]{2}[0-9]{4}",'placeholder'=> 'Sigla con el formato: CI0000']);
                echo $this->Form->control('Curso', ['required','placeholder'=>'Nombre del curso']);
                
            ?>
        </div>
    </fieldset>

    <button type="submit" class="btn btn-primary btn-aceptar">Aceptar</button>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary btn-cancelar btn-space']
    )?>
    <?= $this->Form->end() ?> 
</div>


<style>
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }

    .form-size{
        width: 70%;
        min-width: 200px;
        padding-left: 50px;
    }

        .form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }
</style>