<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course $course
 */
?>
<!--
    <nav class="large-3 medium-4 columns" id="actions-sidebar">
        <ul class="side-nav">
            <li class="heading"><?= __('Actions') ?></li>
            <li><?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $course->code],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $course->code)]
                )
            ?></li>
            <li><?= $this->Html->link(__('List Courses'), ['action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('List Applications'), ['controller' => 'Applications', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Application'), ['controller' => 'Applications', 'action' => 'add']) ?></li>
            <li><?= $this->Html->link(__('List Classes'), ['controller' => 'Classes', 'action' => 'index']) ?></li>
            <li><?= $this->Html->link(__('New Class'), ['controller' => 'Classes', 'action' => 'add']) ?></li>
        </ul>
    </nav>
-->
<style>
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }
</style>
<div class="courses form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <!--<legend><?= __('Editar Curso') ?></legend>-->
        <?php
            // echo $this->Form->control(
            //     'Sigla',
            //     [
            //         'default' => $code,
            //         'options' => $all_classes_codes
            //     ]
            // ); 
            echo $this->Form->control(
                'Curso',
                [
                    'options' => $courses,
                    'default' => $course_name
                ]
            );
            echo $this->Form->control(
                'Grupo',
                ['default' => $class_number]
            );
            echo $this->Form->control(
                'Semestre',
                ['default' => $semester]
            );
            echo $this->Form->control(
                'Año',
                ['default' => $year]
            );
            echo $this->Form->control(
                'Profesor',
                ['options' => $professors]
            );
        ?>
    </fieldset>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary float-right btn-space']
    )?>
    <button type="submit" class="btn btn-primary float-right  btn-space">Aceptar</button>
    <?= $this->Form->end() ?>
</div>
