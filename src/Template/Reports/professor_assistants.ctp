<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
echo $this->Html->css('buttons');
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


 
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Historial de Asistentes') ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Curso ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Estudiante') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Carné del estudiante') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Información de contacto') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Tipo de horas') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Cantidad de horas') ?></th>
             
            </tr>
        </thead>
        <tbody>
            <?php foreach ($professorAssistants as $professorAssistants): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
                <td><?= h($professorAssistants->curso)  ?></td>
				<td><?= h($professorAssistants->semestre.'-'.$professorAssistants->anno) ?></td>
				<td><?= h($professorAssistants->nombre) ?></td>
				<td><?= h($professorAssistants->carne) ?></td>
				<td><?= h($contactInfo) ?></td> <!--informacion de contancto-->
				<td><?= h($professorAssistants->tipo_hora) ?></td>
				<td><?= h($professorAssistants->hour_ammount) ?></td>
                
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