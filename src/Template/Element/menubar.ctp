<?php
/**
 * Barra del menú de navegación, ingluye el logo de la ECCI e información de las rondas.
 */
?>


<?php 
/**
 * La variable $active_menu se usa para indicar cuál es el menú activo. Los posibles valores son:
 * - MenubarInicio
 * - MenubarSolicitudes
 * - MenubarEstSolicitar
 * - MenubarEstHistorial
 * - MenubarProfHistorial
 * - MenubarCursos
 * - MenubarRequisitos
 * - MenubarRonda
 * - MenubarUsuarios
 * - MenubarPermisos
 * - MenubarReportes
 */
if(isset($active_menu)):
?>
    <script type="text/javascript">
    $(document).ready(function() {
        var obj_id = '#<?php echo $active_menu; ?>';
        var clase = $(obj_id).attr('class');
        $(obj_id).attr('class', clase + ' active');
    });
    </script>
<?php else: ?>
<?php endif; ?>

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

                    <li id="MenubarInicio" class="nav-item item-menu"><?= $this->Html->link('Inicio',['controller'=>'Mainpage','action'=>'index'],['class'=>'nav-link']) ?></li>

                    <!-- Nathan González (Empieza) -->
                    <!-- Se pregunta si estamos en ronda -->
                    <?php $between = $this->Rounds->between() ?>
                    <?php if($current_user['role_id'] === 'Estudiante'): ?>
                    
                        <!-- Si estamos en ronda se muestra la opción de enviar una solicitud y ver mis solicitudes -->
                        <?php if($between == true): ?> 
                            <li id="MenubarEstSolicitar" class="nav-item item-menu"><?= $this->Html->link('Solicitar asistencia',['controller'=>'Requests','action'=>'add'],['class'=>'nav-link']) ?></li>
                            <li id="MenubarSolicitudes" class="nav-item item-menu"><?= $this->Html->link('Mis solicitudes',['controller'=>'Requests','action'=>'index'],['class'=>'nav-link']) ?></li>
                        <?php endif ?>
                    <!-- Nathan González (Termina) -->

                        <li id="MenubarEstHistorial" class="nav-item item-menu"><?= $this->Html->link('Historial de asistencias',['controller'=>'Reports','action'=>'studentRequests'],['class'=>'nav-link']) ?></li>
                    <?php else: ?>
                        <?php if($between == true): ?> 
                            <li id="MenubarSolicitudes" class="nav-item item-menu"><?= $this->Html->link('Solicitudes',['controller'=>'Requests','action'=>'index'],['class'=>'nav-link']) ?></li>
                        <?php endif ?>
                    <?php endif ?>

                    <?php if ($current_user['role_id'] === 'Profesor'): ?>
                    <li id="MenubarProfHistorial" class="nav-item item-menu"><?= $this->Html->link('Historial de asistentes',['controller'=>'Reports','action'=>'professorAssistants'],['class'=>'nav-link']) ?></li>
                    <?php endif ?>
                    
                    <?php if ($current_user['role_id'] === 'Administrador'): ?>
                        <li id="MenubarCursos" class="nav-item item-menu"><?= $this->Html->link('Cursos',['controller'=>'CoursesClassesVw','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li id="MenubarRequisitos" class="nav-item item-menu"><?= $this->Html->link('Requisitos',['controller'=>'Requirements','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li id="MenubarRonda" class="nav-item item-menu"><?= $this->Html->link('Ronda',['controller'=>'Rounds','action'=>'index'],['class'=>'nav-link']) ?></li>
                        
                        <li id="MenubarUsuarios" class="nav-item item-menu"><?= $this->Html->link('Usuarios',['controller'=>'Users','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li id="MenubarPermisos" class="nav-item item-menu"><?= $this->Html->link('Permisos',['controller'=>'Roles','action'=>'index'],['class'=>'nav-link']) ?></li>

                        <li id="MenubarReportes" class="nav-item item-menu"><?= $this->Html->link('Reportes',['controller'=>'Reports','action'=>'reports_admin'],['class'=>'nav-link']) ?></li>
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
        <div style="width:250px">
            <div class = 'container border border-danger rounded'>
                <div class = 'row justify-content-center'>
                    <?php if($current_user['role_id'] === 'Administrador'): ?>
                        <div class = 'col-auto align-self-center'  >
                            <div class = 'row'>
                                <h6 class='text-danger' style='font-size:12px;'><b>
                                    <?php
                                        $dsh = (int)$roundData['total_student_hours']-(int)$roundData['actual_student_hours'];
                                        $ddh = (int)$roundData['total_student_hours_d']-(int)$roundData['actual_student_hours_d'];
                                        $dah = (int)$roundData['total_assistant_hours']-(int)$roundData['actual_assistant_hours'];
                                    ?>
                                    <?= "Disponibles" ?><br>
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
                            <h6 class='text-danger' style='font-size:16px;'><b> 
                                <?= "Ronda " .$roundData['round_number'] .' '. $roundData['semester'] . '-' . substr($roundData['year'],2); ?><br>
                                <?= "del: " . substr($roundData['start_date'], 8,2).'-'. substr($roundData['start_date'], 5,2).'-'.substr($roundData['start_date'], 2,2) ?><br>
                                <?=" al: " . substr($roundData['end_date'], 8,2).'-'. substr($roundData['end_date'], 5,2).'-'.substr($roundData['end_date'], 2,2); ?>
                            </b></h6>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <h6 class='text-dark' style='font-size:12px;'>
                        <?= "Fecha y Hora ".date('d-M-Y H:i') ?>
                    </h6>
                </div>        
            </div>        
        </div>        
    <?php endif; ?>
</nav>