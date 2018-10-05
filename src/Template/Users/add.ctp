<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Datos personales') ?></legend>
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