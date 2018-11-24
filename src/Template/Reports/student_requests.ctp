<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Histórico de asistencias') ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Ciclo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Cantidad de horas') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Tipo de horas') ?></th>
                <th scope="col" class="actions"><?= __('Opciones') ?></th>
             
            </tr>
        </thead>
        <tbody>
            <?php foreach ($studentRequests as $studentRequests): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
				<td align = center><?= h($studentRequests->anno) ?></td>
				<td align = center><?= h($studentRequests->semestre) ?></td>
                <td align = left><?= h($studentRequests->curso . " - " . $studentRequests->course_name)  ?></td>
				<td align = center><?= h($studentRequests->grupo) ?></td>
				<td align = center><?= h($ProfessorName) ?></td>
				<td align = center><?= h($studentRequests->hour_ammount) ?></td>
				<td align = center><?= h($studentRequests->tipo_hora) ?></td>

					<td class="actions" align = center>
						<?= $this->Html->link('<i class="fa fa-print"></i>', ['controller' => 'Requests', 'action' => 'view', $studentRequests->id, 'studentRequests', 'Reports'], ['escape'=>false]) ?>

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