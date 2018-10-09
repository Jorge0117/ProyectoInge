<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
     <!--   <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->identification_number]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->identification_number], ['confirm' => __('Are you sure you want to delete # {0}?', $user->identification_number)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Administrative Assistants'), ['controller' => 'AdministrativeAssistants', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Administrative Assistant'), ['controller' => 'AdministrativeAssistants', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Administrative Bosses'), ['controller' => 'AdministrativeBosses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Administrative Boss'), ['controller' => 'AdministrativeBosses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Professors'), ['controller' => 'Professors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Professor'), ['controller' => 'Professors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul> -->
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cédula') ?></th>
            <td><?= h($user->identification_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Primer apellido') ?></th>
            <td><?= h($user->lastname1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Segundo apellido') ?></th>
            <td><?= h($user->lastname2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre de usuario') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correo') ?></th>
            <td><?= h($user->email_personal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Teléfono') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rol') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->role_id, ['controller' => 'Roles', 'action' => 'view', $user->role->role_id]) : '' ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Administrative Assistants') ?></h4>
        <?php if (!empty($user->administrative_assistants)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->administrative_assistants as $administrativeAssistants): ?>
            <tr>
                <td><?= h($administrativeAssistants->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AdministrativeAssistants', 'action' => 'view', $administrativeAssistants->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AdministrativeAssistants', 'action' => 'edit', $administrativeAssistants->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AdministrativeAssistants', 'action' => 'delete', $administrativeAssistants->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $administrativeAssistants->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Administrative Bosses') ?></h4>
        <?php if (!empty($user->administrative_bosses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->administrative_bosses as $administrativeBosses): ?>
            <tr>
                <td><?= h($administrativeBosses->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AdministrativeBosses', 'action' => 'view', $administrativeBosses->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AdministrativeBosses', 'action' => 'edit', $administrativeBosses->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AdministrativeBosses', 'action' => 'delete', $administrativeBosses->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $administrativeBosses->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Professors') ?></h4>
        <?php if (!empty($user->professors)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->professors as $professors): ?>
            <tr>
                <td><?= h($professors->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Professors', 'action' => 'view', $professors->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Professors', 'action' => 'edit', $professors->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Professors', 'action' => 'delete', $professors->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $professors->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Students') ?></h4>
        <?php if (!empty($user->students)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Carne') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->students as $students): ?>
            <tr>
                <td><?= h($students->user_id) ?></td>
                <td><?= h($students->carne) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Students', 'action' => 'view', $students->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Students', 'action' => 'edit', $students->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Students', 'action' => 'delete', $students->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $students->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
