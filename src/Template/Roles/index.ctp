<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<head>
    <?php  
        $urlUpdate = $this->Url->build([
            "controller" => "Roles",
            "action" => "updatePermissions"
        ]);
    ?>

    <script type="text/javascript">
       $(document).ready(function(){
            $("#role_select").change(function(){
                if(document.getElementById("role_select").value == "Administrador"){
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#administrator_permission_table").show();
                    $('#edit_checkbox').show();
                    $('#modificar_tag').show();
                }else if(document.getElementById("role_select").value == "Asistente"){
                    $("#administrator_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").show();   
                    $('#edit_checkbox').show();
                    $('#modificar_tag').show();
                }else if(document.getElementById("role_select").value == "Estudiante"){
                    $("#administrator_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").show();  
                    $('#edit_checkbox').show();
                    $('#modificar_tag').show();
                }else if(document.getElementById("role_select").value == "Profesor"){
                    $("#administrator_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").show();
                    $('#modificar_tag').show();  
                    $('#edit_checkbox').show();
                }else{
                    $("#administrator_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $('#AceptarBtn').hide();
                    $('#edit_checkbox').hide();
                    $('#modificar_tag').hide();
                }
            });

            $("#edit_checkbox").change(function(){
                if($("#edit_checkbox").is(":checked")){
                    $('.checkbox_perm').prop( "disabled", false );
                    $('#AceptarBtn').show();
                }else{
                    $('.checkbox_perm').prop( "disabled", true );
                    $('#AceptarBtn').hide();
                }
            });
        });
    </script>
</head>

<body>
<?= $this->Form->create(false,['url' => '/roles/updatePermissions']) ?>
    <div class='row' >
        <div class='input-group mb-3 col-md-3' style='width:20%'>
            <div class="input-group-prepend">
                    <span style="width:90px" class="input-group-text" >Rol:</span>
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
        
        <div class='input-group mb-3 col-md-4' id='modificar_tag' style='display: none'>
           <span style="width:25%" class="input-group-text" >Modificar</span>     
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

        
        <div class='col-md-5 mb-3' style="text-align:right">
        <?php
            echo $this->Form->button(
                'Aceptar',
                [
                    'id' => 'AceptarBtn',
                    'style' => 'display: none',
                    'type' => 'submit',
                    'class' => 'btn-primary'
                ]);
        ?>
        </div>
    </div>

    <div id='assistant_permission_table' class='container' style="display: none;">
        <table id='assistant_table' class='table text-center'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']); //, 'Roles']);

                    for ($i = 0; $i < $n_permission_types; $i++) {
                        $perm_row = $assistant_permissions_matrix[$i];
                        $permission_row[] = $perm_row[0];
                        for ($j = 1; $j < count($perm_row); $j++) {
                            $permission_row[] = $perm_row[$j] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'assistant_'.$i.$j,
                                'checked' => true,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'assistant['.$i.']['.$j.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'assistant_'.$i.$j,
                                 'checked' => false,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'assistant['.$i.']['.$j.']']
                            );
                        }
                        echo $this->Html->tableCells([$permission_row]);
                        $permission_row = [];
                    }
            ?>
        </table>
    </div>

    <div id='administrator_permission_table' class='container' style="display: none;">
        <table id='administrator_table'  class='table text-center'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']); //, 'Roles']);

                    for ($i = 0; $i < $n_permission_types; $i++) {
                        $perm_row = $administrator_permissions_matrix[$i];
                        $permission_row[] = $perm_row[0];
                        for ($j = 1; $j < count($perm_row); $j++) {
                            $permission_row[] = $perm_row[$j] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'administrator_'.$i.$j,
                                'checked' => true,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'administrator['.$i.']['.$j.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'administrator_'.$i.$j,
                                 'checked' => false,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'administrator['.$i.']['.$j.']']
                            );
                        }
                        echo $this->Html->tableCells([$permission_row]);
                        $permission_row = [];
                    }
            ?>
        </table>
    </div>

    <div id='student_permission_table' class='container' style="display: none;">
        <table id='student_table'  class='table text-center'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']);//, 'Roles']);

                for ($i = 0; $i < $n_permission_types; $i++) {
                    $perm_row = $student_permissions_matrix[$i];
                    $permission_row[] = $perm_row[0];
                    for ($j = 1; $j < count($perm_row); $j++) {
                        $permission_row[] = $perm_row[$j] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'student_'.$i.$j,
                                'checked' => true,
                                'disabled' => true,
                                'class' => 'checkbox_perm checkbox',
                                'name' => 'student['.$i.']['.$j.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'student_'.$i.$j,
                                'checked' => false,
                                'disabled' => true,
                                'class' => 'checkbox_perm checkbox',
                                'name' => 'student['.$i.']['.$j.']']
                            );
                    }
                    echo $this->Html->tableCells([$permission_row]);
                    $permission_row = [];
                }
            ?>
        </table>
    </div>

    <div id='professor_permission_table' class='container' style="display: none;">
        <table id='professor_table'  class='table text-center'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']);//, 'Roles']);

                    for ($i = 0; $i < $n_permission_types; $i++) {
                        $perm_row = $professor_permissions_matrix[$i];
                        $permission_row[] = $perm_row[0];
                        for ($j = 1; $j < count($perm_row); $j++) {
                            $permission_row[] = $perm_row[$j] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'professor_'.$i.$j,
                                'checked' => true,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox align-middle',
                                 'name' => 'professor['.$i.']['.$j.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'professor_'.$i.$j,
                                 'checked' => false,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox ',
                                 'name' => 'professor['.$i.']['.$j.']']
                            );
                            
                        }
                        echo $this->Html->tableCells([$permission_row],['class'=>'align-middle']);
                        $permission_row = [];
                    }

            ?>
        </table>
    </div>
    <?php $this->Form->unlockField('administrator');
          $this->Form->unlockField('assistant');
          $this->Form->unlockField('student');
          $this->Form->unlockField('professor');
    ?>
    <?= $this->Form->end() ?>
</body>