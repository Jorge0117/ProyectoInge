<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Modificar usuario') ?></legend>
        <?php
            echo $this->Form->control('Nombre');
            echo $this->Form->control('Primer apellido');
            echo $this->Form->control('Segundo apellido');
            echo $this->Form->control('Correo ecci');
            echo $this->Form->control('Correo personal');
            echo $this->Form->control('Teléfono');
            echo $this->Form->control('Rol', ['options' => $roles]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Aceptar')) ?>
    <?= $this->Form->end() ?>
</div>
