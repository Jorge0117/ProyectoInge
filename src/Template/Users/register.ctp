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
        float: right;
    }

    h3{
        float: center;
        display: block;
        width: 100%;
        line-height:1.5em;
    }
    
    .form-size{
        width: 70%;
        min-width: 200px;
        padding-left: 50px;
    }

    .btn-cancelar{
        background-color: #999999;
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
        margin-right: 5px;
    }

</style>

<link rel="stylesheet" href="style.css">
<h3>Registrarse</h3>
<div class="form-size users form large-9 medium-8 columns content">
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
        ?>
    </fieldset>
    <div class="submit">
        <?php echo $this->Form->submit(__('Aceptar'), ['class'=>'btn-aceptar'], array('name' => 'ok', 'div' => FALSE)); ?>
        <?php echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-cancelar']); ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>