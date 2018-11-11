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

           
        <?= $this->Form->end() ?>
    </div>
</div>