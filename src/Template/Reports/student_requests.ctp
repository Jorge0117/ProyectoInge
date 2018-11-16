<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
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
					<td align = center><?= h($studentRequests->fecha) ?></td>
					<td align = center><?= h($studentRequests->promedio) ?></td>
					<td align = center><?= h($studentRequests->anno) ?></td>
					<td align = center><?= h($studentRequests->semestre) ?></td>
					<td><?= h($studentRequests->curso)  ?></td>
					<td align = center><?= h($studentRequests->grupo) ?></td>
					<td><?= h($ProfessorName) ?></td>
					<?php if ($studentRequests->estado === 'p'): ?>
                    <td align = center> Pendiente </td>
					<?php else: ?>
						<?php if ($studentRequests->estado === 'a'): ?>
							<td align = center> Aceptada </td>
						<?php else: ?>
							<?php if ($studentRequests->estado === 'e'): ?>
								<td align = center> Elegible </td>
							<?php else: ?>
								<?php if ($studentRequests->estado === 'r'): ?>
									<td align = center> Rechazada </td>
								<?php else: ?>
									<?php if ($studentRequests->estado === 'i'): ?>
										<td align = center> Elegible por inopia </td>
									<?php else: ?>
										<?php if ($studentRequests->estado === 'n'): ?>
											<td align = center> No elegible </td>
										<?php else: ?>
											<?php if ($studentRequests->estado === 'x'): ?>
												<td align = center> Anulada </td>
											<?php else: ?>
												<?php if ($studentRequests->estado === 'c'): ?>
													<td align = center> Aceptada por inopia </td>
												<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
				<?php endif; ?>

					<td class="actions" align = center>
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