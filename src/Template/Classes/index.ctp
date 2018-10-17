<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $classes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Class'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Courses'), ['controller' => 'Courses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Course'), ['controller' => 'Courses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Professors'), ['controller' => 'Professors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Professor'), ['controller' => 'Professors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="classes index large-9 medium-8 columns content">
    <h3><?= __('Classes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('course_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('class_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('semester') ?></th>
                <th scope="col"><?= $this->Paginator->sort('year') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                <th scope="col"><?= $this->Paginator->sort('professor_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $class): ?>
            <tr>
                <td><?= $class->has('course') ? $this->Html->link($class->course->name, ['controller' => 'Courses', 'action' => 'view', $class->course->code]) : '' ?></td>
                <td><?= $this->Number->format($class->class_number) ?></td>
                <td><?= $this->Number->format($class->semester) ?></td>
                <td><?= h($class->year) ?></td>
                <td><?= h($class->state) ?></td>
                <td><?= $class->has('professor') ? $this->Html->link($class->professor->user_id, ['controller' => 'Professors', 'action' => 'view', $class->professor->user_id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $class->course_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $class->course_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $class->course_id], ['confirm' => __('Are you sure you want to delete # {0}?', $class->course_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
