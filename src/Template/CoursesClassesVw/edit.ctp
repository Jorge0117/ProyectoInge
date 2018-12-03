<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course $course
 */
?>

<div class="courses form large-9 medium-8 columns content form-size">
    <?= $this->Form->create() ?>
    <h3><?= __('Editar Grupo') ?></h3>
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
                        'min' => 1,
                        'required'
                    ]
                );
                echo $this->Form->control(
                    'Ciclo',
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
                        'min' => 2018,
                        'max' => 2155,
                        'required'
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
   
    <button type="submit" class="btn btn-primary btn-aceptar">Aceptar</button>
   
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary btn-cancelar']
    )?>

    <?= $this->Form->end() ?>
</div>
