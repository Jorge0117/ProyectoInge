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
                    $('#AceptarBtn').show();
                    $('#edit_checkbox').show();
                }else if(document.getElementById("role_select").value == "Asistente"){
                    $("#administrator_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").show();
                    $('#AceptarBtn').show();
                    $('#edit_checkbox').show();
                }else if(document.getElementById("role_select").value == "Estudiante"){
                    $("#administrator_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").show();
                    $('#AceptarBtn').show();
                    $('#edit_checkbox').show();
                }else if(document.getElementById("role_select").value == "Profesor"){
                    $("#administrator_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").show();
                    $('#AceptarBtn').show();
                    $('#edit_checkbox').show();
                }else{
                    $("#administrator_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $('#AceptarBtn').hide();
                    $('#edit_checkbox').hide();
                }
            });

            $("#edit_checkbox").change(function(){
                if($("#edit_checkbox").is(":checked")){
                    $('.checkbox_perm').prop( "disabled", false );
                    $('#AceptarBtn').prop( "disabled", false );
                }else{
                    $('.checkbox_perm').prop( "disabled", true );
                    $('#AceptarBtn').prop( "disabled", true );
                    
                }
            });

            /**$('#AceptarBtn').click(function () {
                let permissions_matrix_request = [];
                if (document.getElementById("role_select").value == 'Estudiante'){
                    for (let i = 0; i < 4; i++) {
                        permissions_matrix_request[i] = [];
                        for (let j = 1; j < 6; j++) {
                            permissions_matrix_request[i][j] = $("#student_"+i+""+j).is(":checked");
                            
                        }
                        
                    }
                    
                }else if (document.getElementById("role_select").value == 'Administrador'){
                    for (let i = 0; i < 4; i++) {
                        permissions_matrix_request[i] = [];
                        for (let j = 1; j < 6; j++) {
                            permissions_matrix_request[i][j] = $("#administrator_"+i+""+j).is(":checked");
                            
                        }
                        
                    }
                }else if (document.getElementById("role_select").value == 'Asistente'){
                    for (let i = 0; i < 4; i++) {
                        permissions_matrix_request[i] = [];
                        for (let j = 1; j < 6; j++) {
                            permissions_matrix_request[i][j] = $("#assistant_"+i+""+j).is(":checked");
                            
                        }
                        
                    }
                } else if (document.getElementById("role_select").value == 'Profesor'){
                    for (let i = 0; i < 4; i++) {
                        permissions_matrix_request[i] = [];
                        for (let j = 1; j < 6; j++) {
                            permissions_matrix_request[i][j] = $("#professor_"+i+""+j).is(":checked");
                            
                        }
                        
                    }
                }
                console.log(permissions_matrix_request);
            
                let data = {
                    id: document.getElementById("role_select").value,
                    matrix: permissions_matrix_request
                }
                $.post(urlJS, data, function (data, status){
                    console.log('${data} and ${status}');
                })
            });*/
        });
    </script>
</head>

<body>
<?= $this->Form->create(false,['url' => '/roles/updatePermissions']) ?>
    <div class='row'>
        <h2> Rol: </h2>

        <?php
            echo $this->Form->select(
                'role_select',
                $roles_array,
                ['id' => 'role_select',
                'empty' => 'Elija un rol',
                'style' => 'width: 14%',
                'class' => "form-control"]
            ) 
        ?>

        <?php
            echo $this->Form->checkbox(
                'Editar',
                ['id' => 'edit_checkbox',
                 'style' => 'display: none'
                ]
            );
        ?>

        <?php
            echo $this->Form->button(
                'Aceptar',
                [
                    'id' => 'AceptarBtn',
                    'disabled' => true,
                    'style' => 'display: none',
                    'type' => 'submit'
                ]);
        ?>
    </div>

    <div id='assistant_permission_table' class='container' style="display: none;">
        <table id='assistant_table' class='table'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']); //, 'Roles']);

                    for ($j = 0; $j < 4; $j++) {
                        $perm_row = $assistant_permissions_matrix[$j];
                        $permission_row[] = $perm_row[0];
                        for ($i = 1; $i < 6; $i++) {
                            $permission_row[] = $perm_row[$i] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'assistant_'.$j.$i,
                                'checked' => true,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'assistant['.$j.']['.$i.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'assistant_'.$j.$i,
                                 'checked' => false,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'assistant['.$j.']['.$i.']']
                            );
                        }
                        echo $this->Html->tableCells([$permission_row]);
                        $permission_row = [];
                    }
            ?>
        </table>
    </div>

    <div id='administrator_permission_table' class='container' style="display: none;">
        <table id='administrator_table'  class='table'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']); //, 'Roles']);

                    for ($j = 0; $j < 4; $j++) {
                        $perm_row = $administrator_permissions_matrix[$j];
                        $permission_row[] = $perm_row[0];
                        for ($i = 1; $i < 6; $i++) {
                            $permission_row[] = $perm_row[$i] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'administrator_'.$j.$i,
                                'checked' => true,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'administrator['.$j.']['.$i.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'administrator_'.$j.$i,
                                 'checked' => false,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox',
                                 'name' => 'administrator['.$j.']['.$i.']']
                            );
                        }
                        echo $this->Html->tableCells([$permission_row]);
                        $permission_row = [];
                    }
            ?>
        </table>
    </div>

    <div id='student_permission_table' class='container' style="display: none;">
        <table id='student_table'  class='table'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']);//, 'Roles']);

                for ($j = 0; $j < 4; $j++) {
                    $perm_row = $student_permissions_matrix[$j];
                    $permission_row[] = $perm_row[0];
                    for ($i = 1; $i < 6; $i++) {
                        $permission_row[] = $perm_row[$i] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'student_'.$j.$i,
                                'checked' => true,
                                'disabled' => true,
                                'class' => 'checkbox_perm checkbox',
                                'name' => 'student['.$j.']['.$i.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'student_'.$j.$i,
                                'checked' => false,
                                'disabled' => true,
                                'class' => 'checkbox_perm checkbox',
                                'name' => 'student['.$j.']['.$i.']']
                            );
                    }
                    echo $this->Html->tableCells([$permission_row]);
                    $permission_row = [];
                }
            ?>
        </table>
    </div>

    <div id='professor_permission_table' class='container' style="display: none;">
        <table id='professor_table'  class='table'>
            <?php
                echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
                    'Requisitos', 'Ronda', 'Usuarios']);//, 'Roles']);

                    for ($j = 0; $j < 4; $j++) {
                        $perm_row = $professor_permissions_matrix[$j];
                        $permission_row[] = $perm_row[0];
                        for ($i = 1; $i < 6; $i++) {
                            $permission_row[] = $perm_row[$i] ? $this->Form->checkbox(
                                'Editar',
                                ['id' => 'professor_'.$j.$i,
                                'checked' => true,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox align-middle',
                                 'name' => 'professor['.$j.']['.$i.']']
                            ) : $this->Form->checkbox(
                                'Editar',
                                ['id' => 'professor_'.$j.$i,
                                 'checked' => false,
                                 'disabled' => true,
                                 'class' => 'checkbox_perm checkbox ',
                                 'name' => 'professor['.$j.']['.$i.']']
                            );
                            
                        }
                        echo $this->Html->tableCells([$permission_row],['class'=>'align-middle']);
                        $permission_row = [];
                    }

            ?>
        </table>
    </div>
    <?= $this->Form->end() ?>
</body>