<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $class
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Class'), ['action' => 'edit', $class->course_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Class'), ['action' => 'delete', $class->course_id], ['confirm' => __('Are you sure you want to delete # {0}?', $class->course_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Classes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Class'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Professors'), ['controller' => 'Professors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Professor'), ['controller' => 'Professors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="classes view large-9 medium-8 columns content">
    <h3><?= h($class->course_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Course') ?></th>
            <td><?= $class->has('course') ? $this->Html->link($class->course->name, ['controller' => 'Courses', 'action' => 'view', $class->course->code]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Year') ?></th>
            <td><?= h($class->year) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Professor') ?></th>
            <td><?= $class->has('professor') ? $this->Html->link($class->professor->user_id, ['controller' => 'Professors', 'action' => 'view', $class->professor->user_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Class Number') ?></th>
            <td><?= $this->Number->format($class->class_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Semester') ?></th>
            <td><?= $this->Number->format($class->semester) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $class->state ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
