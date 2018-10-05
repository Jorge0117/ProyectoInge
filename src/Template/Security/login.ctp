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

            <!-- <?= $this->Flash->render('auth') ?> -->
            <!-- <?= $this->Form->create() ?> -->
            <form method="post" action="login">

                <div class="row col-8">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span style="width:130px" class="input-group-text" id="username">Usuario</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Usuario" aria-label="Usuario" aria-describedby="username">
                        <!-- <? $this->Form->input('username', ['class' => 'form-control', 'placeholder' => 'Usuario', 'label' => false, 'required']) ?> -->
                    </div>
                <!-- </div> -->

                <!-- <div class="row col-8"> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span style="width:130px" class="input-group-text" id="password">Contraseña</span>
                        </div>
                        <input type="password" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="password">
                        <!-- <? $this->Form->input('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'label' => false, 'required']) ?> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 align-items-left">
                        <button type="button" class="btn btn-secondary">Olvidé mis credenciales</button>

                        <? $this->Form->button('Olvidé mis credenciales', ['class' => 'btn btn-secondary']) ?>
                    </div>
                    <div class="col-2 align-items-right">
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        <!-- <? $this->Form->button('Iniciar sesión', ['class' => 'btn btn-primary']) ?> -->
                    </div>
                </div>
            <!-- <?= $this->Form->end() ?> -->
            </form>
        </div>
    </div>

</div>