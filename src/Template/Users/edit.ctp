<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<h3>Modificar usuario</h3>

<div class="form-size">
    <?= $this->Form->create($user,array(
                'type'=>'file')) ?>
    

    <fieldset>
        <div class="form-section">
            <legend><?= __('Datos personales') ?></legend>
            <?php
                //Espacios para modificar datos personales del usuario
                echo $this->Form->control('identification_number',['type'=>'text']);
                echo $this->Form->control('identification_type', ['options' => ['Cédula de nacional', 'Cédula de residencia', 'Pasaporte', 'Otra'], 'label'=>['text'=>'Tipo de identificación']]);
                echo $this->Form->control('name',['label'=>['text'=>'Nombre']]);
                echo $this->Form->control('lastname1',['label'=>['text'=>'Primer apellido']]);
                echo $this->Form->control('lastname2',['label'=>['text'=>'Segundo apellido']]);
                echo $this->Form->control('email_personal',['label'=>['text'=>'Correo personal'], 'type'=>'email']);
                echo $this->Form->control('phone', ['label'=>['text'=>'Teléfono']]);  
            ?>
        </div>
        
        <?php
        if($admin == 1){
            echo '<div class="form-section" id = "show_rol">';
            echo '<legend><?= __("Datos de seguridad") ?></legend>';
           
                //espacio para modificar rol del usuario, solamente puede verlo el administrador
                echo $this->Form->control('role_id', ['options' => $roles, 'label'=>['text'=>'Rol']]);
        
            echo '</div>';
        }
        

        ?>
        
    </fieldset>
    
    <div>
        <?php echo $this->Form->submit(__('Aceptar'), ['class'=>'btn btn-primary btn-aceptar'], array('name' => 'ok', 'div' => FALSE)); ?>
        <?php echo $this->Html->link(__('Cancelar'), ['action' => 'view', $user->identification_number], ['class'=>'btn btn-secondary btn-cancelar']); ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>
