<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 <?= $this->Html->link(
        'Agregar usuario',
        ['controller'=>'Users','action'=>'add'],
        ['class'=>'btn btn-primary btn-agregar-index']
    )?>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Usuarios') ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Cédula ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Nombre ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Rol') ?></th>
                <th scope="col" class="actions"><?= __(' ') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
                <td><?= h($user->identification_number) ?></td>
                <td><?= h($user->name.' '.$user->lastname1. ' '.$user->lastname2 )  ?></td>
                <td><?=  h($user->role->role_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->identification_number], ['escape'=>false]) ?>
                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->identification_number], ['escape'=>false]) ?>
                    <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->identification_number], ['escape'=>false, 'confirm' => __('¿Está seguro que desea eliminar el usuario {0}?', $user->name.' '. $user->lastname1 )]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
	$(document).ready( function () {
    	$("#datagridUsers").DataTable(
      	{
        	/** Configuración del DataTable para cambiar el idioma, se puede personalisar aun más **/
        	"language": {
            	"lengthMenu": "Mostrar _MENU_ filas por página",
            	"zeroRecords": "Sin resultados",
            	"info": "Mostrando página _PAGE_ de _PAGES_",
            	"infoEmpty": "Sin datos disponibles",
            	"infoFiltered": "(filtered from _MAX_ total records)",
            	"sSearch": "Buscar:",
            	"oPaginate": {
                    	"sFirst": "Primero",
                    	"sLast": "Último",
                    	"sNext": "Siguiente",
                    	"sPrevious": "Anterior"
                	}
        	}
      	}
    	);
	} );
</script>