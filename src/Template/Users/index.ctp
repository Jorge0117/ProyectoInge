<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Usuarios') ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Cédula ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Nombre ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Apellidos') ?></th>
                <th scope="col"><?= $this->Paginator->sort(' ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Rol') ?></th>
                <th scope="col" class="actions"><?= __(' ') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
                <td><?= h($user->identification_number) ?></td>
                <td><?= h($user->name)  ?></td>
                <td><?= h($user->lastname1) ?></td>
                <td><?= h($user->lastname2) ?></td>
               <!-- <td><?= h($user->username) ?></td>
                <td><?= h($user->email_personal) ?></td>
                <td><?= h($user->phone) ?></td> -->
                <td><?= $user->has('role') ? $this->Html->link($user->role->role_id, ['controller' => 'Roles', 'action' => 'view', $user->role->role_id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->identification_number]) ?>
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->identification_number]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $user->identification_number], ['confirm' => __('Are you sure you want to delete # {0}?', $user->identification_number)]) ?>
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