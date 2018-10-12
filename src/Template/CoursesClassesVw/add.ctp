<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CoursesClassesVw $coursesClassesVw
 */
?>

<div class="coursesClassesVw form large-9 medium-8 columns content">
    <?= $this->Form->create($coursesClassesVw) ?>
    <fieldset>
        <legend><?= __('Add Course') ?></legend>
        <?php
            echo $this->Form->control('Sigla');
            echo $this->Form->control('Curso');
            echo $this->Form->control('Creditos');
            echo $this->Form->control('Grupo');
            echo $this->Form->control('Profesor', ['options' => $professors, 'empty' => true]);
            echo $this->Form->control('Semestre');
            echo $this->Form->control('Año');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Aceptar'), ['class'=>'btn-aceptar']) ?>
    <?= $this->Form->button(__('Cancelar'), ['class'=>'btn-cancelar', 'type' => 'button', 'onclick' => 'location.href=\'index\''] ) ?>
    <?= $this->Form->end() ?>
</div>

<style type="text/css">
    .btn-aceptar{
        background-color: #ceb92bff;
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
    }

    h3{
        float: center;
        display: block;
        width: 100%;
        line-height:1.5em;
    }
    
    .form-size{
        width: 70%;
        min-width: 200px;
        padding-left: 50px;
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