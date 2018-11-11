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
                $("#administrator_permission_table").show();
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Asistente"){
                $("#administrator_permission_table").hide();
                $("#student_permission_table").hide();
                $("#professor_permission_table").hide();
                $("#assistant_permission_table").show();   
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Estudiante"){
                $("#administrator_permission_table").hide();
                $("#professor_permission_table").hide();
                $("#assistant_permission_table").hide();
                $("#student_permission_table").show();  
                $('#edit_checkbox').show();
                $('#modificar_tag').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else if(document.getElementById("role_select").value == "Profesor"){
                $("#administrator_permission_table").hide();
                $("#assistant_permission_table").hide();
                $("#student_permission_table").hide();
                $("#professor_permission_table").show();
                $('#modificar_tag').show();  
                $('#edit_checkbox').show();
                $('#SelectR').prop('style', 'width: 45%');
            }else{
                $("#administrator_permission_table").hide();
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
                $('.checkbox_perm').prop( "disabled", false );
                $('#BtnDiv').show();
            }else{
                $('.checkbox_perm').prop( "disabled", true );
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
                <div class="tab-pane fade show active" id="cursos-grupos" role="tabpanel" aria-labelledby="cursos-grupos-tab">cursos-grupos</div>
                <div class="tab-pane fade" id="reportes" role="tabpanel" aria-labelledby="reportes-tab">reportes</div>
                <div class="tab-pane fade" id="requisitos" role="tabpanel" aria-labelledby="requisitos-tab">requisitos</div>
                <div class="tab-pane fade" id="rondas" role="tabpanel" aria-labelledby="rondas-tab">rondas</div>
                <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">solicitudes</div>
                <div class="tab-pane fade" id="usuarios" role="tabpanel" aria-labelledby="usuarios-tab">usuarios</div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>