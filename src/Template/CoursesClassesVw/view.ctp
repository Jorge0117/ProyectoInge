<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CoursesClassesVw $coursesClassesVw
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Course'), ['action' => 'edit', $coursesClassesVw->code]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Course'), ['action' => 'delete', $coursesClassesVw->code], ['confirm' => __('Are you sure you want to delete # {0}?', $coursesClassesVw->code)]) ?> </li>
        <li><?= $this->Html->link(__('List Courses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Course'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Applications'), ['controller' => 'Applications', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Application'), ['controller' => 'Applications', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Classes'), ['controller' => 'Classes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Class'), ['controller' => 'Classes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="courses view large-9 medium-8 columns content">
    <h3><?= h($course->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= h($course->code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($course->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credits') ?></th>
            <td><?= $this->Number->format($course->credits) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Applications') ?></h4>
        <?php if (!empty($course->applications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Application Number') ?></th>
                <th scope="col"><?= __('Date Submitted') ?></th>
                <th scope="col"><?= __('Student Id') ?></th>
                <th scope="col"><?= __('Round Number') ?></th>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col"><?= __('Class Number') ?></th>
                <th scope="col"><?= __('Semester') ?></th>
                <th scope="col"><?= __('Year') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($course->applications as $applications): ?>
            <tr>
                <td><?= h($applications->application_number) ?></td>
                <td><?= h($applications->date_submitted) ?></td>
                <td><?= h($applications->student_id) ?></td>
                <td><?= h($applications->round_number) ?></td>
                <td><?= h($applications->course_id) ?></td>
                <td><?= h($applications->class_number) ?></td>
                <td><?= h($applications->semester) ?></td>
                <td><?= h($applications->year) ?></td>
                <td><?= h($applications->state) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $applications->application_number]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Applications', 'action' => 'edit', $applications->application_number]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Applications', 'action' => 'delete', $applications->application_number], ['confirm' => __('Are you sure you want to delete # {0}?', $applications->application_number)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Classes') ?></h4>
        <?php if (!empty($course->classes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Course Id') ?></th>
                <th scope="col"><?= __('Class Number') ?></th>
                <th scope="col"><?= __('Semester') ?></th>
                <th scope="col"><?= __('Year') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Professor Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($course->classes as $classes): ?>
            <tr>
                <td><?= h($classes->course_id) ?></td>
                <td><?= h($classes->class_number) ?></td>
                <td><?= h($classes->semester) ?></td>
                <td><?= h($classes->year) ?></td>
                <td><?= h($classes->state) ?></td>
                <td><?= h($classes->professor_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Classes', 'action' => 'view', $classes->course_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Classes', 'action' => 'edit', $classes->course_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Classes', 'action' => 'delete', $classes->course_id], ['confirm' => __('Are you sure you want to delete # {0}?', $classes->course_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
