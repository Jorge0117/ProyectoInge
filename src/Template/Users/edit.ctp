<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style type="text/css">
    .btn-aceptar{
        background-color: #ceb92bff;
        color: #ffffff;
        border: none;
        text-align: center;
    }

    h3{
        background-color: #ceb92bff;
        color: #ffffff;
        text-align: center;
        display: block;
        width: 100%;
        line-height:1.5em;
    }

</style>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Datos personales') ?></legend>
        <?php
            echo $this->Form->control('identification_number',['type'=>'text']);
            echo $this->Form->control('name',['label'=>['text'=>'Nombre']]);
            echo $this->Form->control('lastname1',['label'=>['text'=>'Primer apellido']]);
            echo $this->Form->control('lastname2',['label'=>['text'=>'Segundo apellido']]);
            echo $this->Form->control('email_personal',['label'=>['text'=>'Correo personal']]);
            echo $this->Form->control('phone', ['label'=>['text'=>'Teléfono']]);
            echo $this->Form->control('Rol', ['options' => $roles]);
            echo $this->Form->control('Carné');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Aceptar'), ['class'=>'btn-aceptar']) ?>
    <?= $this->Form->end() ?>
</div>
