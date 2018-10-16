<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Requirement'), ['action' => 'edit', $requirement->requirement_number]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Requirement'), ['action' => 'delete', $requirement->requirement_number], ['confirm' => __('Are you sure you want to delete # {0}?', $requirement->requirement_number)]) ?> </li>
        <li><?= $this->Html->link(__('List Requirements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Requirement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fulfills Requirement'), ['controller' => 'FulfillsRequirement', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fulfills Requirement'), ['controller' => 'FulfillsRequirement', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="requirements view large-9 medium-8 columns content">
    <h3><?= h($requirement->requirement_number) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($requirement->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($requirement->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Requirement Number') ?></th>
            <td><?= $this->Number->format($requirement->requirement_number) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Fulfills Requirement') ?></h4>
        <?php if (!empty($requirement->fulfills_requirement)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Requirement Id') ?></th>
                <th scope="col"><?= __('Application Id') ?></th>
                <th scope="col"><?= __('Is Fulfilled') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($requirement->fulfills_requirement as $fulfillsRequirement): ?>
            <tr>
                <td><?= h($fulfillsRequirement->requirement_id) ?></td>
                <td><?= h($fulfillsRequirement->application_id) ?></td>
                <td><?= h($fulfillsRequirement->is_fulfilled) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FulfillsRequirement', 'action' => 'view', $fulfillsRequirement->requirement_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FulfillsRequirement', 'action' => 'edit', $fulfillsRequirement->requirement_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FulfillsRequirement', 'action' => 'delete', $fulfillsRequirement->requirement_id], ['confirm' => __('Are you sure you want to delete # {0}?', $fulfillsRequirement->requirement_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
