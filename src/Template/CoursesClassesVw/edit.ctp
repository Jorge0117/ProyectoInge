<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course $course
 */
?>

<style>
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }
</style>
<div class="courses form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <legend><?= __('Editar Grupo') ?></legend>
    <fieldset>
        <div class = "form-section">
            <?php
                $courses = iterator_to_array($courses);
                echo $this->Form->control(
                    'Curso',
                    [
                        'options' => $courses,
                        'default' => $code
                    ]
                );
                echo $this->Form->control(
                    'Grupo',
                    [
                        'default' => $class_number,
                        'type' => 'number',
                        'min' => 1
                    ]
                );
                echo $this->Form->control(
                    'Semestre',
                    [
                        'options' => [1,2,3],
                        'default' => ($semester-1)
                    ]
                );
                echo $this->Form->control(
                    'Año',
                    [
                        'default' => $year,
                        'type' => 'number',
                        'min' => 1901,
                        'max' => 2155
                    ]
                );
                // echo $old_professor;
                $default_prof_index = array_search(trim($old_professor),$professors);
                echo $this->Form->control(
                    'Profesor',
                    [
                        'options' => $professors,
                        'default' => $default_prof_index
                     ]
                );
            ?>
        </div>
    </fieldset>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary float-right btn-space']
    )?>
    <button type="submit" class="btn btn-primary float-right  btn-space">Aceptar</button>
    <?= $this->Form->end() ?>
</div>
