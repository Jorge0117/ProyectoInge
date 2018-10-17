<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style type="text/css">
    .btn-aceptar{
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
    }

    h3{
        background-color: #ceb92bff;
        color: #ffffff;
        text-align: center;
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

    .form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }

    #show_rol{
        display: none;
    }

</style>


<div class="users form large-9 medium-8 columns content form-size">
    <?= $this->Form->create($user,array(
                'type'=>'file','onsubmit'=>'window.alert("Se ha modificado el usuario correctamente.")')) ?>
    
    <?php echo $mostrar; 
        if($mostrar == 0){
            ?>
            <style type="text/css">#show_rol{
            display: none;
            }</style>
            <?php
        }
    ?>

    <fieldset>
        <div class="form-section">
            <legend><?= __('Datos personales') ?></legend>
            <?php
                //Espacios para modificar datos personales del usuario
                echo $this->Form->control('identification_number',['type'=>'text']);
                echo $this->Form->control('name',['label'=>['text'=>'Nombre']]);
                echo $this->Form->control('lastname1',['label'=>['text'=>'Primer apellido']]);
                echo $this->Form->control('lastname2',['label'=>['text'=>'Segundo apellido']]);
                echo $this->Form->control('email_personal',['label'=>['text'=>'Correo personal']]);
                echo $this->Form->control('phone', ['label'=>['text'=>'Teléfono']]);  
            ?>
        </div>
        

        <div class="form-section" id = "show_rol">
            <legend><?= __('Datos de seguridad') ?></legend>
            <?php
                //espacio para modificar rol del usuario, solamente puede verlo el administrador
                echo $this->Form->control('role', ['options' => $roles, 'label'=>['text'=>'Rol']]);
            ?>
        </div>
        
    </fieldset>
    
    <div class="submit">
        <?php echo $this->Form->submit(__('Aceptar'), ['class'=>'btn btn-primary btn-aceptar'], array('name' => 'ok', 'div' => FALSE)); ?>
        <?php echo $this->Form->submit(__('Cancelar'), ['class'=>'btn btn-secondary btn-cancelar'], array('name' => 'cancel', 'formnovalidate' => TRUE, 'div' => FALSE)); ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>
