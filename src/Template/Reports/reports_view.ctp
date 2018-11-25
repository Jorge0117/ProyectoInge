<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
echo $this->Html->css('buttons');
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Reporte de solicitudes ' . $titulo) ?></h3>
    <table cellpadding="0" cellspacing="0" id="datagridReports"> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Sigla') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Carné') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>
				
				<?php if($horas == 1): ?>
				<th scope="col"><?= $this->Paginator->sort('H.A') ?></th>
				<th scope="col"><?= $this->Paginator->sort('H.E') ?></th>
                
				<?php endif ?>

				<?php if($imprimirEstado == 1): ?>
					<th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
				<?php endif?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $r): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
				<td><?= h($r->curso) ?></td>
				<td><?= h($r->curso) ?></td>
                <td><?= h($r->grupo)  ?></td>
				<td><?= h($r->id_prof) ?></td>
				<td><?= h($r->carne) ?></td>
				<td><?= h($r->nombre) ?></td>
				<?php if($horas == 1): ?>
				
				<td><?= h($r->hour_ammount) ?></td>
				<td><?= h($r->tipo_hora) ?></td>
				<?php endif ?>
				
				<?php if($imprimirEstado == 1): ?>
					<td><?= h($r->Estado) ?></td>
				<?php endif?>

                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<?= $this->Form->create('report') ?>
	<?php echo $this->Form->button(__('Generar Reporte'),['class'=>'btn-aceptar']) ?>
	
</div>
    <?= $this->Form->end() ?>
<script type="text/javascript">
	$(document).ready( function () {
    	$("#datagridReports").DataTable(
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