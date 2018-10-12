<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>


<link rel="stylesheet" href="style.css">
<h3>Agregar usuario</h3>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user, ['novalidate']) ?>
    <fieldset>
        <legend><?= __('Datos personales') ?></legend>
        <?php
            echo $this->Form->control('identification_number',['type'=>'text']);
            echo $this->Form->control('name',['label'=>['text'=>'Nombre']]);
            echo $this->Form->control('lastname1',['label'=>['text'=>'Primer apellido']]);
            echo $this->Form->control('lastname2',['label'=>['text'=>'Segundo apellido']]);
            echo $this->Form->control('email_personal',['label'=>['text'=>'Correo personal']]);
            echo $this->Form->control('phone', ['label'=>['text'=>'Teléfono']]);
            echo $this->Form->control('carne');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Aceptar'), ['class'=>'btn-aceptar']) ?>
    <?= $this->Form->end() ?>
</div>