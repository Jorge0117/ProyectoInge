<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
echo $this->Html->css('buttons');
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 
<div class="users index large-9 medium-8 columns content">
	<div class="row justify-content-between" >
		<h3><?= __('Histórico de asistencias') ?></h3>
		<table cellpadding="0" cellspacing="0" id= datagridUsers> 
			<thead>
				<tr>
					<th scope="col"><?= $this->Paginator->sort('Fecha de solicitud') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Promedio') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Año') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
					<th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
					<th scope="col" class="actions"><?= __('Opciones') ?></th>
				
				</tr>
			</thead>
			<tbody>
				<?php foreach ($studentRequests as $studentRequests): ?>
				<tr> <!-- Aquí se ve que se pone en el datagrid-->
					<td><?= h($studentRequests->fecha) ?></td>
					<td><?= h($studentRequests->promedio) ?></td>
					<td><?= h($studentRequests->anno) ?></td>
					<td><?= h($studentRequests->semestre) ?></td>
					<td><?= h($studentRequests->curso)  ?></td>
					<td><?= h($studentRequests->grupo) ?></td>
					<td><?= h($ProfessorName) ?></td>
					<td><?= h($studentRequests->estado) ?></td>

					<td class="actions">
						<?= $this->Html->link('<i class="fa fa-print"></i>', ['controller' => 'Requests', 'action' => 'view', $studentRequests->id], ['escape'=>false]) ?>

					</td>
					
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
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