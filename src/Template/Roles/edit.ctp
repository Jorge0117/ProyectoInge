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
                $("#assistant_permission_table").hide();
                $("#student_permission_table").hide();
                $("#professor_permission_table").hide();
                $("#administradorPermissions").show();
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Asistente"){
                $("#administradorPermissions").hide();
                $("#student_permission_table").hide();
                $("#professor_permission_table").hide();
                $("#assistant_permission_table").show();   
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Estudiante"){
                $("#administradorPermissions").hide();
                $("#professor_permission_table").hide();
                $("#assistant_permission_table").hide();
                $("#student_permission_table").show();  
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Profesor"){
                $("#administradorPermissions").hide();
                $("#assistant_permission_table").hide();
                $("#student_permission_table").hide();
                $("#professor_permission_table").show();
                $('#modificar_tag').show();  
                $('#edit_checkbox').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else{
                $("#administradorPermissions").hide();
                $("#student_permission_table").hide();
                $("#professor_permission_table").hide();
                $("#assistant_permission_table").hide();
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
                $('#BtnDiv').show();
            }else{
                $('.permissions').prop( "disabled", true );
                $('#BtnDiv').hide();
            }
        });
    });
</script>

<div class='form-size container'>
    <div class='form-section'>
        <?= $this->Form->create(false) ?>
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
            
            <div id='administradorPermissions' style='display: none;'>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="cursos-grupos-tab" data-toggle="tab" href="#cursos-grupos" role="tab" aria-controls="cursos-grupos" aria-selected="true">Cursos-Grupos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reportes-tab" data-toggle="tab" href="#reportes" role="tab" aria-controls="reportes" aria-selected="false">Reportes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="requisitos-tab" data-toggle="tab" href="#requisitos" role="tab" aria-controls="requisitos" aria-selected="false">Requisitos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rondas-tab" data-toggle="tab" href="#rondas" role="tab" aria-controls="rondas" aria-selected="false">Rondas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="solicitudes-tab" data-toggle="tab" href="#solicitudes" role="tab" aria-controls="solicitudes" aria-selected="false">Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="usuarios-tab" data-toggle="tab" href="#usuarios" role="tab" aria-controls="usuarios" aria-selected="false">Usuarios</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="cursos-grupos" role="tabpanel" aria-labelledby="cursos-grupos-tab">
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
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="reportes" role="tabpanel" aria-labelledby="reportes-tab">
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
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="requisitos" role="tabpanel" aria-labelledby="requisitos-tab">
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
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="rondas" role="tabpanel" aria-labelledby="rondas-tab">
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
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">
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
                                }
                            ?>		  
                        </table>
                    </div>
                    <div class="tab-pane fade" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">
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
                                }
                            ?>		  
                        </table>
                    </div>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>