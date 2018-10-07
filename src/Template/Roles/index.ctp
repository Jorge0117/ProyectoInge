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
                    $("#administrator_permission_table").show();
                }else if(document.getElementById("role_select").value == "Asistente"){
                    $("#administrator_permission_table").hide();
                    $("#assistant_permission_table").show();
                }else{
                    $("#permission_table").hide();   
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
        'empty' =>  'Elija un rol',
        'style' => 'width: 14%']
    )?>
    <?php 

    echo $this->Form->checkbox(
        'Editar'
    );
    ?>
</div>

<div id='assistant_permission_table' style="display: none;">
    <table id='assistant_table'  style="width:100%">
        <?php 
            echo $this->Html->tableHeaders(['Permiso', 'Solicitudes','Cursos-Grupo',
                'Requisitos', 'Ronda', 'Usuarios',  'Roles' ]);

            $con_check = $this->Form->checkbox(
                'Editar',
                ['checked' => true]
            );

            $sin_check = $this->Form->checkbox(
                'Editar',
                ['checked' => false]
            );

            foreach ($assistant_permissions_matrix as $perm_row){
                $permission_row[] = $perm_row[0];
                for($i = 1; $i < 7 ;$i++){
                    $permission_row[] = $perm_row[$i]? $con_check : $sin_check; 
                }
                echo $this->Html->tableCells([
                    $permission_row
                ]);
                $permission_row = [];
            }

        ?>
    </table>
    </div>

    <div id='administrator_permission_table' style="display: none;">
     <table id='administrator_table'  style="width:100%">
        <?php 
            echo $this->Html->tableHeaders(['Permiso', 'Solicitudes','Cursos-Grupo',
                'Requisitos', 'Ronda', 'Usuarios',  'Roles' ]);

            $con_check = $this->Form->checkbox(
                'Editar',
                ['checked' => true]
            );

            $sin_check = $this->Form->checkbox(
                'Editar',
                ['checked' => false]
            );

            foreach ($administrator_permissions_matrix as $perm_row){
                $permission_row[] = $perm_row[0];
                for($i = 1; $i < 7 ;$i++){
                    $permission_row[] = $perm_row[$i]? $con_check : $sin_check; 
                }
                echo $this->Html->tableCells([
                    $permission_row
                ]);
                $permission_row = [];
            }

        ?>
    </table>
</div>
</body>