<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
echo $this->Html->css('buttons');
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Reporte de') ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Cantidad de horas') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Tipo de horas') ?></th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
				<td align = center><?= h($report->anno) ?></td>
				<td align = center><?= h($report->semestre) ?></td>
                <td align = center><?= h($report->curso)  ?></td>
				<td align = center><?= h($report->grupo) ?></td>
				<!-- <td align = center><?= h($ProfessorName) ?></td> -->
				<td align = center><?= h($report->hour_ammount) ?></td>
				<td align = center><?= h($report->tipo_hora) ?></td>

                
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