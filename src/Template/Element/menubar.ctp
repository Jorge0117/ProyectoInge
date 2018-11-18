<?php
/**
 * Barra del menú de navegación, ingluye el logo de la ECCI e información de las rondas.
 */
?>
<nav class="navbar navbar-fixed-top navbar-expand-xl justify-content-between navbar-light bg-white">    
    <a class="navbar-brand" href="https://www.ecci.ucr.ac.cr/">
        <?= $this->Html->image('logoEcci.png', ['style' => 'width:200px'])?>
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
                        <li class="nav-item item-menu"><?= $this->Html->link('Historial de asistencias',['controller'=>'Reports','action'=>'studentRequests'],['class'=>'nav-link']) ?></li>
                    <?php else: ?>
                    <li class="nav-item item-menu"><?= $this->Html->link('Solicitudes',['controller'=>'Requests','action'=>'index'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>

                    <?php if ($current_user['role_id'] === 'Profesor'): ?>
                    <li class="nav-item item-menu"><?= $this->Html->link('Historial de asistentes',['controller'=>'Reports','action'=>'professorAssistants'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>
                    
                    <?php if ($current_user['role_id'] === 'Administrador' || $current_user['role_id'] === 'Asistente'): ?>
                        <li class="nav-item item-menu"><?= $this->Html->link('Cursos',['controller'=>'CoursesClassesVw','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Requisitos',['controller'=>'Requirements','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Ronda',['controller'=>'Rounds','action'=>'index'],['class'=>'nav-link']) ?></li>
                        
                        <li class="nav-item item-menu"><?= $this->Html->link('Usuarios',['controller'=>'Users','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li class="nav-item item-menu"><?= $this->Html->link('Permisos',['controller'=>'Roles','action'=>'index'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>

                </ul>
            </div>
        <?php else: ?>
            <span class="navbar-text">
            </span>
        <?php endif ?>

    </div>
    <!-- Element/menubar.ctp -->
    
    <?php if($round == null): ?>
        <div style="width:200px">
        </div>
    <?php else: ?>
        <div style="width:200px ">
            <div>  
                <h6 style='color:red; font-size:19px;'><strong> 
                    <?= $round[0] ?><br>
                    <?= $round[1] ?><br>
                    <?php if($current_user['role_id'] === 'Administrador'): ?>
                        <?= $round[2] ?><br>
                        <?= $round[3] ?><br>
                    <?php endif; ?>

                </strong></h6>
                <h6 style='color:black; font-size:12px;'>
                <?php echo "Fecha y Hora ".date('d-M-Y H:i') ?>
            </div>
        </div>        
    <?php endif; ?>
</nav>
