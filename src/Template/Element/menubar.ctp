<?php
/**
 * Barra del menú de navegación, ingluye el logo de la ECCI e información de las rondas.
 */
?>
<nav class="navbar navbar-fixed-top navbar-expand-xl justify-content-between navbar-light bg-white" >    
    <div style = 'width:218px'>
        <a class="navbar-brand" href="https://www.ecci.ucr.ac.cr/" >
            <?= $this->Html->image('logoEcci.png', ['style' => 'width:200px'])?>
        </a>
    </div>

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
    
    <?php if(!$roundData): ?>
        <div style="width:300px">
        </div>
    <?php else: ?>
        <div style="width:218px">
            <div class = 'container'>
                <div class = 'row justify-content-end'>
                    <?php if($current_user['role_id'] === 'Administrador'): ?>
                        <div class = 'col-auto align-self-center'  >
                            <div class = 'row'>
                                <h6 style='color:red; font-size:12px;margin-bottom:0'><b>
                                    <?php
                                        $dsh = (int)$roundData['total_student_hours']-(int)$roundData['actual_student_hours'];
                                        $ddh = (int)$roundData['total_student_hours_d']-(int)$roundData['actual_student_hours_d'];
                                        $dah = (int)$roundData['total_assistant_hours']-(int)$roundData['actual_assistant_hours'];
                                    ?>
                                    <?= "Horas vacantes" ?><br>
                                    <?= "HE-ECCI: ".(string)$dsh ?><br>
                                    <?= "HE-DOC: ".(string)$ddh ?><br>
                                    <?= "HA-ECCI: ".(string)$dah ?>
                                </b></h6>
                            </div>    
                        </div>        
                        <div class = 'col-auto align-self-center'>
                        </div>
                    <?php endif; ?>
                    <div class = 'col-auto align-self-center'>
                        <div class = 'row'>
                            <h6 style='color:red; font-size:16px;margin-bottom:0'><b> 
                                <?= "Ronda " .$roundData['round_number'] .' '. $roundData['semester'] . ' ' . substr($roundData['year'],2); ?><br>
                                <?= "del: " . substr($roundData['start_date'], 8,2).'-'. substr($roundData['start_date'], 5,2).'-'.substr($roundData['start_date'], 2,2) ?><br>
                                <?=" al: " . substr($roundData['end_date'], 8,2).'-'. substr($roundData['end_date'], 5,2).'-'.substr($roundData['end_date'], 2,2); ?>
                            </b></h6>
                        </div>
                    </div>
                </div>        
            </div>        
        </div>        
    <?php endif; ?>
</nav>
