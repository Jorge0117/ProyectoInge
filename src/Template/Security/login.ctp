<?php

?>

<div class="container mt-5 mb-5 pt-5 pb-5">
    <div class="row col-10">
        <div class="panel" >
            
            <!-- <div class="row">
                <div class="col-md-2">
                    <label class="col-form-label">Usuario</label>
                </div>  
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label class="col-form-label">Contraseña</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                    </div>
                </div>
            </div> -->

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
            <?= $this->Form->button('Olvidé mis credenciales', ['type' => 'button', 'class' => 'btn btn-secondary float-leftz']) ?>
            <?= $this->Form->button('Iniciar sesión', ['type' => 'submit', 'class' => 'btn btn-primary float-right']) ?>
            <?= $this->Form->end() ?>

            
            <!-- <form method="post" action="login">

                <div class="row col-8">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span style="width:130px" class="input-group-text" id="username"><?= $Variable1 ?></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Usuario" aria-label="Usuario" aria-describedby="username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span style="width:130px" class="input-group-text" id="password">Contraseña</span>
                        </div>
                        <input type="password" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="password">
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 align-items-left">
                        <button type="button" class="btn btn-secondary">Olvidé mis credenciales</button>
                    </div>
                    <div class="col-2 align-items-right">
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </div>
                </div>
            </form> -->
            

        </div>
    </div>

</div>