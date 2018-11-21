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
                        <li class="nav-item item-menu"><?= $this->Html->link('Histórico de asistencias',['controller'=>'Reports','action'=>'studentRequests'],['class'=>'nav-link']) ?></li>
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

                    <?php if ($current_user['role_id'] === 'Profesor'): ?>
                    <li class="nav-item item-menu"><?= $this->Html->link('Historial de asistentes',['controller'=>'Reports','action'=>'professorAssistants'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>
                    
                    <?php if ($current_user['role_id'] === 'Administrador' || $current_user['role_id'] === 'Asistente'): ?>
                        <li class="nav-item item-menu"><?= $this->Html->link('Curso-grupo',['controller'=>'CoursesClassesVw','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Requisitos',['controller'=>'Requirements','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Ronda',['controller'=>'Rounds','action'=>'index'],['class'=>'nav-link']) ?></li>
                        
                        <li class="nav-item item-menu"><?= $this->Html->link('Usuarios',['controller'=>'Users','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Roles',['controller'=>'Roles','action'=>'index'],['class'=>'nav-link']) ?></li>

                           <li class="nav-item item-menu"><?= $this->Html->link('Reportes',['controller'=>'Reports','action'=>'reports_admin'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>

                </ul>
            </div>
        <?php else: ?>

            <span class="navbar-text">
            </span>
        <?php endif ?>

    </div>

    <?php $round = $this->Rounds->getLastRound() ?>
    <?php if($round == null): ?>
        <div style="width:200px">
        </div>
    <?php else: ?>
        <div style="height:69px">  
            <h5 style='color:red;'><strong> <?= $round[0] ?><br><?= $round[1] ?><br><?= $round[2] ?> </strong></h5>
        </div>
    <?php endif; ?>
</nav>