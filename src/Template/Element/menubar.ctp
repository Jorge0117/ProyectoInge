<?php
/**
 * Barra del menú de navegación, ingluye el logo de la ECCI e información de las rondas.
 */
?>

<nav class="navbar navbar-fixed-top navbar-expand-xl justify-content-between navbar-light bg-white">    
    <a class="navbar-brand">
        <?= $this->Html->image('logoEcci.png', ['class' => 'mr-4','style' => 'width:200px'])?>
    </a>

    <div>
        <?php if ($current_user): ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#modulesList" aria-controls="modulesList" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="modulesList">
                <ul class="nav navbar-nav">

                    <li class="nav-item item-menu"><?= $this->Html->link('Inicio',['controller'=>'Mainpage','action'=>'index'],['class'=>'nav-link']) ?></li>

                    
                    <?php if($current_user['role_id'] === 'Estudiante'): ?>
                        <li class="nav-item item-menu"><?= $this->Html->link('Solicitar asistencia',['controller'=>'Requests','action'=>'add'],['class'=>'nav-link']) ?></li>
                        <li class="nav-item item-menu"><?= $this->Html->link('Mis solicitudes',['controller'=>'Requests','action'=>'index'],['class'=>'nav-link']) ?></li>
                        <li class="nav-item item-menu"><?= $this->Html->link('Asistencias pasadas',['controller'=>'Requests','action'=>'index'],['class'=>'nav-link']) ?></li>
                    <?php else: ?>
                        <li class="nav-item dropdown item-menu">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownSol" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Solicitudes
                            </a>

                            <div class="dropdown-menu" aria-labeledby="dropdownSol">
    
                                <?php if($current_user['role_id'] === 'Administrador' || $current_user['role_id'] === 'Asistente'): ?>
                                    <?= $this->Html->link('Listar',['controller'=>'Requests','action'=>'index'],['class'=>'dropdown-item']) ?>
                                    <?= $this->Html->link('Revisar',['controller'=>'Requests','action'=>'index'],['class'=>'dropdown-item']) ?>
                                    <?= $this->Html->link('Aprobadas',['controller'=>'Requests','action'=>'index'],['class'=>'dropdown-item']) ?>
                                <?php elseif($current_user['role_id' === 'Profesor']): ?>
                                    <?= $this->Html->link('Revisar',['controller'=>'Requests','action'=>'index'],['class'=>'dropdown-item']) ?>
                                    <?= $this->Html->link('Asistentes pasados',['controller'=>'Requests','action'=>'index'],['class'=>'dropdown-item']) ?>
                                <?php endif ?>
                            </div>   
                        </li>
                    <?php endif ?>

                    
                    <?php if ($current_user['role_id'] === 'Administrador' || $current_user['role_id'] === 'Asistente'): ?>
                        <li class="nav-item item-menu"><?= $this->Html->link('Curso-grupo',['controller'=>'CoursesClassesVw','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Requisitos',['controller'=>'Requirements','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Ronda',['controller'=>'Rounds','action'=>'index'],['class'=>'nav-link']) ?></li>
                        
                        <li class="nav-item item-menu"><?= $this->Html->link('Usuarios',['controller'=>'Users','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Roles',['controller'=>'Roles','action'=>'index'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>

                </ul>
            </div>
        <?php else: ?>

            <span class="navbar-text">
            </span>
        <?php endif ?>

    </div>

    <div style="width:200px">
    </div>
</nav>