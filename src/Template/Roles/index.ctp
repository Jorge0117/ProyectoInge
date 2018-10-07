<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<head>
    <script type="text/javascript">
       $(document).ready(function(){
            $("#role_select").change(function(){
                if(document.getElementById("role_select").value == "Administrador"){
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#administrator_permission_table").show();
                }else if(document.getElementById("role_select").value == "Asistente"){
                    $("#administrator_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").show();
                }else if(document.getElementById("role_select").value == "Estudiante"){
                    $("#administrator_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").show();
                }else if(document.getElementById("role_select").value == "Profesor"){
                    $("#administrator_permission_table").hide();
                    $("#assistant_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").show();
                }else{
                    $("#administrator_permission_table").hide();
                    $("#student_permission_table").hide();
                    $("#professor_permission_table").hide();
                    $("#assistant_permission_table").hide();
                }
            });

            $("#edit_checkbox").change(function(){
                if($("#edit_checkbox").is(":checked")){
                    $('.checkbox_perm').prop( "disabled", false );
                }else{
                    $('.checkbox_perm').prop( "disabled", true );
                }
            });
        });
    </script>
</head>

<body>
<div class='row'>
<button id='but' style="display: none;">Aceptar</button>
<h2> Rol:
</h2>
    <?php
echo $this->Form->select(
    'role_select',
    $roles_array,
    ['id' => 'role_select',
        'empty' => 'Elija un rol',
        'style' => 'width: 14%',
        'class' => "form-control"]
) ?>
    <?php

echo $this->Form->checkbox(
    'Editar',
    ['id' => 'edit_checkbox']
);
?>
</div>
<?php
$con_check = $this->Form->checkbox(
    'Editar',
    ['checked' => true,
        'disabled' => true,
        'class' => 'checkbox_perm']
);

$sin_check = $this->Form->checkbox(
    'Editar',
    ['checked' => false,
        'disabled' => true,
        'class' => 'checkbox_perm']
);
?>
<div id='assistant_permission_table' class='container' style="display: none;">
    <table id='assistant_table'  style="width:100%">
        <?php
echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
    'Requisitos', 'Ronda', 'Usuarios']); //, 'Roles']);

foreach ($assistant_permissions_matrix as $perm_row) {
    $permission_row[] = $perm_row[0];
    for ($i = 1; $i < 7; $i++) {
        $permission_row[] = $perm_row[$i] ? $con_check : $sin_check;
    }
    echo $this->Html->tableCells([
        $permission_row,
    ]);
    $permission_row = [];
}

?>
    </table>
    </div>

    <div id='administrator_permission_table' class='container' style="display: none;">
     <table id='administrator_table'  style="width:100%">
        <?php
echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
    'Requisitos', 'Ronda', 'Usuarios']); //, 'Roles']);

foreach ($administrator_permissions_matrix as $perm_row) {
    $permission_row[] = $perm_row[0];
    for ($i = 1; $i < 6; $i++) {
        $permission_row[] = $perm_row[$i] ? $con_check : $sin_check;
    }
    echo $this->Html->tableCells([
        $permission_row,
    ]);
    $permission_row = [];
}

?>
    </table>
</div>

<div id='student_permission_table' class='container' style="display: none;">
     <table id='student_table'  style="width:100%">
        <?php
echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
    'Requisitos', 'Ronda', 'Usuarios', 'Roles']);

foreach ($student_permissions_matrix as $perm_row) {
    $permission_row[] = $perm_row[0];
    for ($i = 1; $i < 7; $i++) {
        $permission_row[] = $perm_row[$i] ? $con_check : $sin_check;
    }
    echo $this->Html->tableCells([
        $permission_row,
    ]);
    $permission_row = [];
}

?>
    </table>
</div>

<div id='professor_permission_table' class='container' style="display: none;">
     <table id='professor_table'  style="width:100%">
        <?php
echo $this->Html->tableHeaders(['Permiso', 'Solicitudes', 'Cursos-Grupo',
    'Requisitos', 'Ronda', 'Usuarios', 'Roles']);

foreach ($professor_permissions_matrix as $perm_row) {
    $permission_row[] = $perm_row[0];
    for ($i = 1; $i < 7; $i++) {
        $permission_row[] = $perm_row[$i] ? $con_check : $sin_check;
    }
    echo $this->Html->tableCells([
        $permission_row,
    ]);
    $permission_row = [];
}

?>
    </table>
</div>
</body>