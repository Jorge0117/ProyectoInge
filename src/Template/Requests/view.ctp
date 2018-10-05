<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Request'), ['action' => 'edit', $request->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Request'), ['action' => 'delete', $request->id], ['confirm' => __('Are you sure you want to delete # {0}?', $request->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Requests'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Request'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requests view large-9 medium-8 columns content">
    <h3><?= h($request->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Class Year') ?></th>
            <td><?= h($request->class_year) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Course') ?></th>
            <td><?= $request->has('course') ? $this->Html->link($request->course->name, ['controller' => 'Courses', 'action' => 'view', $request->course->code]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Student') ?></th>
            <td><?= $request->has('student') ? $this->Html->link($request->student->user_id, ['controller' => 'Students', 'action' => 'view', $request->student->user_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($request->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($request->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Number') ?></th>
            <td><?= $this->Number->format($request->round_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Semester') ?></th>
            <td><?= $this->Number->format($request->round_semester) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Round Year') ?></th>
            <td><?= $this->Number->format($request->round_year) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Class Semester') ?></th>
            <td><?= $this->Number->format($request->class_semester) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Class Number') ?></th>
            <td><?= $this->Number->format($request->class_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Another Assistant Hours') ?></th>
            <td><?= $this->Number->format($request->another_assistant_hours) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Another Student Hours') ?></th>
            <td><?= $this->Number->format($request->another_student_hours) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reception Date') ?></th>
            <td><?= h($request->reception_date) ?></td>
        </tr>
    </table>
</div>
