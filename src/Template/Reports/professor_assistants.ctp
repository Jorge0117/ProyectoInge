<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
echo $this->Html->css('buttons');
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 


  <!--
     Autor: Mayquely
     -->
 <div class="users index large-9 medium-8 columns content">
    <h3><?= __('Historial de Asistentes aprobados del profesor(a)  '.$ProfessorName) ?></h3>
    <table cellpadding="0" cellspacing="0" id= datagridUsers> 
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Curso ') ?></th> 
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Carné') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Estudiante') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Cantidad de horas') ?></th>
				<th scope="col"><?= $this->Paginator->sort('Tipo de horas') ?></th>
				<th scope="col"><?= $this->Paginator->sort(' Opciones  ') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($professorAssistants as $professorAssistants): ?>
            <tr> <!-- Aquí se ve que se pone en el datagrid-->
                <td align = "center"><?= h($professorAssistants->curso.' - '.$professorAssistants->course_name)  ?></td>
				<td align = "center"><?= h($professorAssistants->semestre.' - '.$professorAssistants->anno) ?></td>
				<td align = "center"><?= h($professorAssistants->grupo) ?></td>
				<td align = "center"><?= h($professorAssistants->carne) ?></td>
				<td align = "center"><?= h($professorAssistants->nombre) ?></td>
				<td align = "center"><?= h($professorAssistants->hour_ammount) ?></td>
				<td align = "center" ><?= h($professorAssistants->tipo_hora) ?></td>
				<td align = "center" class="actions">
                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Requests', 'action' => 'view', $professorAssistants->id_request], ['escape'=>false]) ?>
                    <?= $this->Html->link('<i class="fa fa-print"></i>', ['controller' => 'Requests', 'action' => 'print', $professorAssistants->id_request], ['target' => '_blank', 'escape'=>false]) ?>
                </td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->Html->link( //Botón de agregar requisito, que lleva a la vista para poder agregar un nuevo requisito
                        'Generar excel',
                        ['controller'=>'Reports','action'=>'CreateExcel'],
                        ['class'=>'btn btn-primary float-right btn-space btn-agregar-index']
                    )?>

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