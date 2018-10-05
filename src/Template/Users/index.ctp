<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Administrative Assistants'), ['controller' => 'AdministrativeAssistants', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Administrative Assistant'), ['controller' => 'AdministrativeAssistants', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Administrative Bosses'), ['controller' => 'AdministrativeBosses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Administrative Boss'), ['controller' => 'AdministrativeBosses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Professors'), ['controller' => 'Professors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Professor'), ['controller' => 'Professors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('identification_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastname1') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastname2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_personal') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->identification_number) ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= h($user->lastname1) ?></td>
                <td><?= h($user->lastname2) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->email_personal) ?></td>
                <td><?= h($user->phone) ?></td>
                <td><?= $user->has('role') ? $this->Html->link($user->role->role_id, ['controller' => 'Roles', 'action' => 'view', $user->role->role_id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->identification_number]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->identification_number]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->identification_number], ['confirm' => __('Are you sure you want to delete # {0}?', $user->identification_number)]) ?>
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
