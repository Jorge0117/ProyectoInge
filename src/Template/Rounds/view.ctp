<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round $round
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Round'), ['action' => 'edit', $round->semester]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Round'), ['action' => 'delete', $round->semester], ['confirm' => __('Are you sure you want to delete # {0}?', $round->semester)]) ?> </li>
        <li><?= $this->Html->link(__('List Rounds'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Round'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rounds view large-9 medium-8 columns content">
    <h3><?= h($round->semester) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Number') ?></th>
            <td><?= $this->Number->format($round->number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Semester') ?></th>
            <td><?= $this->Number->format($round->semester) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Year') ?></th>
            <td><?= $this->Number->format($round->year) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($round->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Date') ?></th>
            <td><?= h($round->end_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approve Limit Date') ?></th>
            <td><?= h($round->approve_limit_date) ?></td>
        </tr>
    </table>
</div>
