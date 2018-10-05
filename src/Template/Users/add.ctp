<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
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
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Agregar usuario') ?></legend>
        <?php
            echo $this->Form->control('Cédula');
            echo $this->Form->control('Nombre');
            echo $this->Form->control('Primer apellido');
            echo $this->Form->control('Segundo apellido');
            echo $this->Form->control('Correo personal');
            echo $this->Form->control('Teléfono');
            echo $this->Form->control('Correo ecci');
            echo $this->Form->control('Rol', ['options' => $roles]);
            echo $this->Form->control('Carné');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Aceptar')) ?>
    <?= $this->Form->end() ?>
</div>
