<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#BtnDiv').hide();
        $("#role_select").change(function(){
            if(document.getElementById("role_select").value == "Administrador"){
                $("#assistantPermissions").hide();
                $("#studentPermissions").hide();
                $("#professorPermissions").hide();
                $("#administradorPermissions").show();
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Asistente"){
                $("#administradorPermissions").hide();
                $("#studentPermissions").hide();
                $("#professorPermissions").hide();
                $("#assistantPermissions").show();   
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Estudiante"){
                $("#administradorPermissions").hide();
                $("#professorPermissions").hide();
                $("#assistantPermissions").hide();
                $("#studentPermissions").show();  
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Profesor"){
                $("#administradorPermissions").hide();
                $("#assistantPermissions").hide();
                $("#studentPermissions").hide();
                $("#professorPermissions").show();
                $('#modificar_tag').show();  
                $('#edit_checkbox').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else{
                $("#administradorPermissions").hide();
                $("#studentPermissions").hide();
                $("#professorPermissions").hide();
                $("#assistantPermissions").hide();
                $('#BtnDiv').hide();
                $('#edit_checkbox').hide();
                $('#modificar_tag').hide();
                $('#edit_checkbox').prop('checked', false);
                $('#SelectR').prop('style', 'width: 30%');
            }
        });

        $("#edit_checkbox").change(function(){
            if($("#edit_checkbox").is(":checked")){
                $('.permissions').prop( "disabled", false );
            }else{
                $('.permissions').prop( "disabled", true );
            }
        });
    });
</script>

<div class='form-size container'>
<h3><?= __('Modificar permisos') ?></h3>
    <div class='form-section'>
        <div class='row-right' >
            <div class='input-group mb-3 mr-1' style='width:30%' id='SelectR'>
                <div class="input-group-prepend">
                        <span  class="input-group-text" >Rol:</span>
                </div>
            
                <?php
                    echo $this->Form->select(
                        'role_select',
                        $roles_array,
                        ['id' => 'role_select',
                        'empty' => 'Elija un rol',
                        'class' => "form-control custom-select"]
                    ) 
                ?>
                
            </div>
            
            <div class='input-group mb-3 ml-1' id='modificar_tag' style='display: none'>
                <span  class="input-group-text" >Modificar</span>     
                <div class="input-group-append" >
                        <div class="input-group-text bg-white">
                            <?php
                                echo $this->Form->checkbox(
                                    'Editar',
                                    ['id' => 'edit_checkbox',
                                    'style' => 'display: none'
                                    ]
                                );
                            ?>
                        </div>
                </div>
            </div>
        </div>
                                
        <!-------------------------------------------------------------------------------------------------->
        <!-- Permisos de administrador -->
        <div id='administradorPermissions' style='display: none;'>
            <?= $this->Form->create(false) ?>
        
                <ul class="nav nav-tabs" id="administrador-myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active item-tab" id="administrador-cursos-grupos-tab" data-toggle="tab" href="#administrador-cursos-grupos" role="tab" aria-controls="administrador-cursos-grupos" aria-selected="true">Cursos-Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="administrador-reportes-tab" data-toggle="tab" href="#administrador-reportes" role="tab" aria-controls="administrador-reportes" aria-selected="false">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="administrador-requisitos-tab" data-toggle="tab" href="#administrador-requisitos" role="tab" aria-controls="administrador-requisitos" aria-selected="false">Requisitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="administrador-rondas-tab" data-toggle="tab" href="#administrador-rondas" role="tab" aria-controls="administrador-rondas" aria-selected="false">Rondas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="administrador-solicitudes-tab" data-toggle="tab" href="#administrador-solicitudes" role="tab" aria-controls="administrador-solicitudes" aria-selected="false">Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="administrador-usuarios-tab" data-toggle="tab" href="#administrador-usuarios" role="tab" aria-controls="administrador-usuarios" aria-selected="false">Usuarios</a>
                    </li>
                </ul>
                <div class="tab-content" id="administrador-myTabContent">
                    <div class="tab-pane fade show active" id="administrador-cursos-grupos" role="tabpanel" aria-labelledby="administrador-cursos-grupos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['CoursesClassesVw'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('CoursesClassesVw-'.$action, $administrator_permissions),
                                            'name' => 'CoursesClassesVw-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('CoursesClassesVw-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="administrador-reportes" role="tabpanel" aria-labelledby="administrador-reportes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Reports'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Reports-'.$action, $administrator_permissions),
                                            'name' => 'Reports-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Reports-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="administrador-requisitos" role="tabpanel" aria-labelledby="administrador-requisitos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requirements'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requirements-'.$action, $administrator_permissions),
                                            'name' => 'Requirements-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requirements-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="administrador-rondas" role="tabpanel" aria-labelledby="administrador-rondas-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Rounds'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Rounds-'.$action, $administrator_permissions),
                                            'name' => 'Rounds-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Rounds-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="administrador-solicitudes" role="tabpanel" aria-labelledby="administrador-solicitudes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requests'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requests-'.$action, $administrator_permissions),
                                            'name' => 'Requests-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requests-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="administrador-usuarios" role="tabpanel" aria-labelledby="administrador-usuarios-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Users'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Users-'.$action, $administrator_permissions),
                                            'name' => 'Users-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Users-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                </div>
                <div class="container">
                    <div class='row justify-content-end'> 
                        <?= $this->Html->link(
                            'Cancelar',
                            ['controller'=>'Roles','action'=>'edit'],
                            ['class'=>'btn btn-secondary btn-cancelar']
                        )?>

                        <?php
                            echo $this->Form->button(
                                'Aceptar',
                                [
                                    'id' => 'AceptarAdministrador',
                                    'name' => 'AceptarAdministrador',
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary btn-aceptar'
                                ]);
                            
                        ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>

        <!-------------------------------------------------------------------------------------------------->
        <!-- Permisos de estudiante -->
        <div id='studentPermissions' style='display: none;'>
            <?= $this->Form->create(false) ?>
        
                <ul class="nav nav-tabs" id="student-myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active item-tab" id="student-cursos-grupos-tab" data-toggle="tab" href="#student-cursos-grupos" role="tab" aria-controls="student-cursos-grupos" aria-selected="true">Cursos-Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="student-reportes-tab" data-toggle="tab" href="#student-reportes" role="tab" aria-controls="student-reportes" aria-selected="false">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="student-requisitos-tab" data-toggle="tab" href="#student-requisitos" role="tab" aria-controls="student-requisitos" aria-selected="false">Requisitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="student-rondas-tab" data-toggle="tab" href="#student-rondas" role="tab" aria-controls="student-rondas" aria-selected="false">Rondas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="student-solicitudes-tab" data-toggle="tab" href="#student-solicitudes" role="tab" aria-controls="student-solicitudes" aria-selected="false">Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="student-usuarios-tab" data-toggle="tab" href="#student-usuarios" role="tab" aria-controls="student-usuarios" aria-selected="false">Usuarios</a>
                    </li>
                </ul>
                <div class="tab-content" id="student-myTabContent">
                    <div class="tab-pane fade show active" id="student-cursos-grupos" role="tabpanel" aria-labelledby="student-cursos-grupos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                    
                                foreach ($all_permissions_by_module['CoursesClassesVw'] as $action => $description) {
                                    
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('CoursesClassesVw-'.$action, $student_permissions),
                                            'name' => 'CoursesClassesVw-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('CoursesClassesVw-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="student-reportes" role="tabpanel" aria-labelledby="student-reportes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Reports'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Reports-'.$action, $student_permissions),
                                            'name' => 'Reports-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Reports-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="student-requisitos" role="tabpanel" aria-labelledby="student-requisitos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requirements'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requirements-'.$action, $student_permissions),
                                            'name' => 'Requirements-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requirements-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="student-rondas" role="tabpanel" aria-labelledby="student-rondas-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Rounds'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Rounds-'.$action, $student_permissions),
                                            'name' => 'Rounds-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Rounds-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="student-solicitudes" role="tabpanel" aria-labelledby="student-solicitudes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");

                                foreach ($all_permissions_by_module['Requests'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requests-'.$action, $student_permissions),
                                            'name' => 'Requests-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requests-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="student-usuarios" role="tabpanel" aria-labelledby="student-usuarios-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Users'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Users-'.$action, $student_permissions),
                                            'name' => 'Users-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Users-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                </div>
                <div class="container">
                    <div class='row justify-content-end'> 
                        <?= $this->Html->link(
                            'Cancelar',
                            ['controller'=>'Roles','action'=>'edit'],
                            ['class'=>'btn btn-secondary btn-cancelar']
                        )?>

                        <?php
                            echo $this->Form->button(
                                'Aceptar',
                                [
                                    'id' => 'AceptarEstudiante',
                                    'name' => 'AceptarEstudiante',
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary btn-aceptar'
                                ]);
                            
                        ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>

        <!-------------------------------------------------------------------------------------------------->
        <!-- Permisos de asistente -->
        <div id='assistantPermissions' style='display: none;'>
            <?= $this->Form->create(false) ?>

                <ul class="nav nav-tabs" id="assistant-myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active item-tab" id="assistant-cursos-grupos-tab" data-toggle="tab" href="#assistant-cursos-grupos" role="tab" aria-controls="assistant-cursos-grupos" aria-selected="true">Cursos-Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="assistant-reportes-tab" data-toggle="tab" href="#assistant-reportes" role="tab" aria-controls="assistant-reportes" aria-selected="false">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="assistant-requisitos-tab" data-toggle="tab" href="#assistant-requisitos" role="tab" aria-controls="assistant-requisitos" aria-selected="false">Requisitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="assistant-rondas-tab" data-toggle="tab" href="#assistant-rondas" role="tab" aria-controls="assistant-rondas" aria-selected="false">Rondas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="assistant-solicitudes-tab" data-toggle="tab" href="#assistant-solicitudes" role="tab" aria-controls="assistant-solicitudes" aria-selected="false">Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="assistant-usuarios-tab" data-toggle="tab" href="#assistant-usuarios" role="tab" aria-controls="assistant-usuarios" aria-selected="false">Usuarios</a>
                    </li>
                </ul>

                <div class="tab-content" id="assistant-myTabContent">
                    <div class="tab-pane fade show active" id="assistant-cursos-grupos" role="tabpanel" aria-labelledby="assistant-cursos-grupos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['CoursesClassesVw'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('CoursesClassesVw-'.$action, $assistant_permissions),
                                            'name' => 'CoursesClassesVw-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('CoursesClassesVw-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="assistant-reportes" role="tabpanel" aria-labelledby="assistant-reportes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Reports'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Reports-'.$action, $assistant_permissions),
                                            'name' => 'Reports-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Reports-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="assistant-requisitos" role="tabpanel" aria-labelledby="assistant-requisitos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requirements'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requirements-'.$action, $assistant_permissions),
                                            'name' => 'Requirements-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requirements-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="assistant-rondas" role="tabpanel" aria-labelledby="assistant-rondas-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Rounds'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Rounds-'.$action, $assistant_permissions),
                                            'name' => 'Rounds-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Rounds-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="assistant-solicitudes" role="tabpanel" aria-labelledby="assistant-solicitudes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requests'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requests-'.$action, $assistant_permissions),
                                            'name' => 'Requests-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requests-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="assistant-usuarios" role="tabpanel" aria-labelledby="assistant-usuarios-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Users'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Users-'.$action, $assistant_permissions),
                                            'name' => 'Users-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Users-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                </div>
                <div class="container">
                    <div class='row justify-content-end'> 
                        <?= $this->Html->link(
                            'Cancelar',
                            ['controller'=>'Roles','action'=>'edit'],
                            ['class'=>'btn btn-secondary btn-cancelar']
                        )?>

                        <?php
                            echo $this->Form->button(
                                'Aceptar',
                                [
                                    'id' => 'AceptarAsistente',
                                    'name' => 'AceptarAsistente',
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary btn-aceptar'
                                ]);
                            
                        ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>

        <!-------------------------------------------------------------------------------------------------->
        <!-- Permisos de profesor -->
        <div id='professorPermissions' style='display: none;'>
            <?= $this->Form->create(false) ?>
        
                <ul class="nav nav-tabs" id="professor-myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active item-tab" id="professor-cursos-grupos-tab" data-toggle="tab" href="#professor-cursos-grupos" role="tab" aria-controls="professor-cursos-grupos" aria-selected="true">Cursos-Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="professor-reportes-tab" data-toggle="tab" href="#professor-reportes" role="tab" aria-controls="professor-reportes" aria-selected="false">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="professor-requisitos-tab" data-toggle="tab" href="#professor-requisitos" role="tab" aria-controls="professor-requisitos" aria-selected="false">Requisitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="professor-rondas-tab" data-toggle="tab" href="#professor-rondas" role="tab" aria-controls="professor-rondas" aria-selected="false">Rondas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="professor-solicitudes-tab" data-toggle="tab" href="#professor-solicitudes" role="tab" aria-controls="professor-solicitudes" aria-selected="false">Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link item-tab" id="professor-usuarios-tab" data-toggle="tab" href="#professor-usuarios" role="tab" aria-controls="professor-usuarios" aria-selected="false">Usuarios</a>
                    </li>
                </ul>
                <div class="tab-content" id="professor-myTabContent">
                    <div class="tab-pane fade show active" id="professor-cursos-grupos" role="tabpanel" aria-labelledby="professor-cursos-grupos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['CoursesClassesVw'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('CoursesClassesVw-'.$action, $professor_permissions),
                                            'name' => 'CoursesClassesVw-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('CoursesClassesVw-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="professor-reportes" role="tabpanel" aria-labelledby="professor-reportes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Reports'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Reports-'.$action, $professor_permissions),
                                            'name' => 'Reports-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Reports-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="professor-requisitos" role="tabpanel" aria-labelledby="professor-requisitos-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requirements'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requirements-'.$action, $professor_permissions),
                                            'name' => 'Requirements-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requirements-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="professor-rondas" role="tabpanel" aria-labelledby="professor-rondas-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Rounds'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Rounds-'.$action, $professor_permissions),
                                            'name' => 'Rounds-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Rounds-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="professor-solicitudes" role="tabpanel" aria-labelledby="professor-solicitudes-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Requests'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Requests-'.$action, $professor_permissions),
                                            'name' => 'Requests-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Requests-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="professor-usuarios" role="tabpanel" aria-labelledby="professor-usuarios-tab">
                        <table class='table text-center'>
                            <?php                          
                                echo ("<tr class='bg-white'>
                                    \t<th style='width:70%; text-align: left;'>Permiso</th> 
                                    \t<th style='width:30%'>Conceder</th>
                                    </tr>");
                                foreach ($all_permissions_by_module['Users'] as $action => $description) {
                                    echo('<tr class="bg-white">'."\n");
                                    echo("\t\t\t\t".'<td style= \'text-align: left;\'>'.$description.'</td>'."\n"); 
                                    echo("\t\t\t\t".'<td>'.$this->Form->checkbox(
                                            'Editar',
                                            ['checked' => array_key_exists('Users-'.$action, $professor_permissions),
                                            'name' => 'Users-'.$action,
                                            'class' => 'permissions',
                                            'disabled' => true]
                                        ).'</td>'."\n");
                                    echo('</tr>'."\n");
                                    $this->Form->unlockField('Users-'.$action);
                                }
                            ?>		  
                        </table>
                    </div>
                </div>
                <div class="container">
                    <div class='row justify-content-end'> 
                        <?= $this->Html->link(
                            'Cancelar',
                            ['controller'=>'Roles','action'=>'edit'],
                            ['class'=>'btn btn-secondary btn-cancelar']
                        )?>

                        <?php
                            echo $this->Form->button(
                                'Aceptar',
                                [
                                    'id' => 'AceptarProfesor',
                                    'name' => 'AceptarProfesor',
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary btn-aceptar'
                                ]);
                            
                        ?>
                    </div>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>