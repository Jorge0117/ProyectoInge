<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CoursesClassesVw $coursesClassesVw
 */
?>

<div class="coursesClassesVw form large-9 medium-8 columns content">
    <?= $this->Form->create($coursesClassesVw) ?>
    <fieldset>
        <h3><?= __('Agregar curso') ?></h3>
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

    <button type="submit" class="btn btn-primary float-right">Aceptar</button>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary float-right btn-space']
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
</style>