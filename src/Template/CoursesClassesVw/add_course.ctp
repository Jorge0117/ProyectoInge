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

        <div class="form-section">
            <?php
                echo $this->Form->control('Sigla', ['pattern' => "[A-Z]{2}[0-9]{4}"]);
                echo $this->Form->control('Curso', ['requiered']);
                echo $this->Form->control('Creditos', ['type' => 'number','max' => 8, 'min' => 1]);
                echo $this->Form->control('Grupo', ['type' => 'number','max' => 20, 'min' => 1]);
                echo $this->Form->control('Profesor', ['options' => $professors, 'empty' => false]);
                echo $this->Form->control('Semestre', ['type' => 'number','max' => 2, 'min' => 1]);
                echo $this->Form->control('Año', ['type' => 'number','max' => 9999, 'min' => 1900]);
            ?>
        </div>
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

        .form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }
</style>