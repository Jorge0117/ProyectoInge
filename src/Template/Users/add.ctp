<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>

<h3>Agregar usuario</h3>
<div class="form-size users form large-9 medium-8 columns content">
    <?= $this->Form->create($user, ['novalidate']) ?>
    <fieldset>
        <div class="form-section">
            <legend><?= __('Datos personales') ?></legend>
            <?php
                echo $this->Form->control('identification_number',['type'=>'text', 'label'=>['text'=>'Número de cédula']]);
                echo $this->Form->control('identification_type', ['options' => ['Cédula nacional', 'Cédula de residencia', 'Pasaporte', 'Otra'], 'label'=>['text'=>'Tipo de identificación']]);
                echo $this->Form->control('name',['label'=>['text'=>'Nombre']]);
                echo $this->Form->control('lastname1',['label'=>['text'=>'Primer apellido']]);
                echo $this->Form->control('lastname2',['label'=>['text'=>'Segundo apellido']]);
                echo $this->Form->control('email_personal',['label'=>['text'=>'Correo personal'], 'type'=>'email']);
                echo $this->Form->control('phone', ['label'=>['text'=>'Teléfono'], 'type'=>'integer']);
            ?>
        </div>
        
        <div class="form-section">
            <legend><?= __('Datos de seguridad') ?></legend>
            <?php
                echo $this->Form->control('username',['label'=>['text'=>'Nombre de usuario (ecci)']]);
            ?>
        </div>
              
    </fieldset>
    <div class="submit">
        <?php echo $this->Form->submit(__('Aceptar'), ['class'=>'btn btn-primary btn-aceptar'], array('name' => 'ok', 'div' => FALSE)); ?>
        <?php echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']); ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>