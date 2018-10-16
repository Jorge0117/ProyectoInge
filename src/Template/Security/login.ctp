<?php

?>

<div class="container col-6 mt-5 mb-5 pt-5 pb-5">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Ingreso al sistema') ?></legend>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span style="width:120px" class="input-group-text">Usuario:</span>
            </div>
            <?php
                echo $this->Form->text('username');
            ?>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span style="width:120px" class="input-group-text">Contraseña:</span>
            </div>
            <?php
                echo $this->Form->password('password');
            ?>
        </div>
    </fieldset>
    <?php //$this->Html->link('Olvidé mis credenciales', ['type' => 'button', 'class' => 'btn btn-secondary float-left']) ?>
    <button type="button" class="btn btn-secondary float-left" data-toggle="modal" data-target="#recuperarModal">Olvidé mis credenciales</button>
    <?= $this->Form->button('Iniciar sesión', ['type' => 'submit', 'class' => 'btn btn-primary float-right']) ?>
    <?= $this->Form->end() ?>

    <div class="modal fade" id="recuperarModal" tabindex="-1" role="dialog" aria-labelledby="recuperarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recuperarModalLabel">Ingresar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-justify">
                    El usuario y contraseña son los mismos que usa para acceder a las computadoras de los laboratorios.
                    Su usuario se creará automáticamente la primera vez que ingrese.
                    En caso de olvidar sus credenciales comuníquese al 2511-8018, al correo soporte@ecci.ucr.cr, o diríjase a la oficina de redes.
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>