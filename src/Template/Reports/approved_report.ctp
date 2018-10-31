<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
echo $this->Html->css('buttons');
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Asistencias Aprobadas') ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
			<th scope="col"><?= $this->Paginator->sort('Nombre Estudiente') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Tipo de Horas') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Cantidad de Horas') ?></th>
             
            </tr>
        </thead>
        <tbody>
            <?php foreach ($approvedRequestsView as $approvedRequestsView): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
                <td><?= h($approvedRequestsView->nombre) ?></td>
                <td><?= h($approvedRequestsView->curso)  ?></td>
				<td><?= h($approvedRequestsView->semestre.'-'.$approvedRequestsView->anno) ?></td>
				<td><?= h($ProfessorName) ?></td>
				<td><?= h($approvedRequestsView->tipo_hora) ?></td>
				<td><?= h($approvedRequestsView->hour_ammount) ?></td>
                
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