<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $request->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $request->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requests form large-9 medium-8 columns content">
    <?= $this->Form->create($request) ?>
    <fieldset>
        <legend><?= __('Edit Request') ?></legend>
        <?php
            echo $this->Form->control('round_start');
            echo $this->Form->control('reception_date');
            echo $this->Form->control('class_year');
            echo $this->Form->control('course_id', ['options' => $courses]);
            echo $this->Form->control('class_semester');
            echo $this->Form->control('class_number');
            echo $this->Form->control('student_id', ['options' => $students]);
            echo $this->Form->control('status');
            echo $this->Form->control('another_assistant_hours');
            echo $this->Form->control('another_student_hours');
            echo $this->Form->control('has_another_hours');
            echo $this->Form->control('first_time');
            echo $this->Form->control('average');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
