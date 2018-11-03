<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request[]|\Cake\Collection\CollectionInterface $requests
 */
echo $this->Html->css('buttons');
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 

<nav class="large-3 medium-4 columns" id="actions-sidebar">

    <?php if ($disponible === true): ?>
    <?= $this->Html->link(__('Agregar solicitud'), ['action' => 'add'], ['class'=>'btn btn-primary btn-agregar-index']) ?>
	<?php endif; ?>
    
</nav>
<div class="requests index large-9 medium-8 columns content text-grid">
    <h3><?= __('Solicitudes') ?></h3>

    <br>

    <label style='position:absolute; left: 52%;'>
        Filtrar por:
    </label>

    <select id = 'request_' name='request_' onchange='hideRequest(this.id, "requesttable")' style='position:absolute; left: 58%; height: 5%; width: 13.3%; border-width:2px; border-style:inset; z-index: 1;'>
        <option value = 't'>Todas</option>
        <option value = 'e'>Elegible</option>
        <option value = 'n'>No elegible</option>
    </select>

    <table cellpadding="0" cellspacing="0" id = "requesttable">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Fecha de solicitud') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Carné') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Promedio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Ronda') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tiene otras horas') ?></th>
                <th scope="col" class="actions"><?= __('Opciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $request): ?>
            <tr>
                <td><?= h($request->fecha) ?></td>
                
                <td><?= h($request->carne) ?></td>
                <td><?= h($request->nombre) ?></td>

                <td><?= $this->Number->format($request->promedio) ?></td>
                <td><?= h($request->anno) ?></td>
                <td><?= $this->Number->format($request->semestre) ?></td>
                <td><?= h($request->curso) ?></td>
                <td><?= $this->Number->format($request->grupo) ?></td>
                <td><?= $this->Number->format($request->ronda) ?></td>
				
                <td><?= h($request->estado) ?></td>

                <?php if ($request->otras_horas === true): ?>
					<td> SI </td>
				<?php else: ?>
					<td> NO </td>
				<?php endif; ?>
				
                
                <td class="actions">
                    <?= $this->Html->link('<i class="fa fa-print"></i>', ['action' => 'view', $request->id], ['escape'=>false]) ?>
                    
                    <?php if ($admin === true): ?>
                    <?= $this->Html->link('<i class="fa fa-pencil-square-o"></i>', ['action' => 'review', $request->id], ['escape'=>false]) ?>
                    <?php endif; ?>
                </td>
				
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $("#requesttable").DataTable(
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

    function hideRequest(selector, table){
        var selId = document.getElementById(selector);
        var tabId = document.getElementById(table);
        var numRows = tabId.rows.length;

        if(selId.value != 't'){
            for(var i = 1; i < numRows; ++i){
                if( tabId.rows[i].cells[9].innerHTML != selId.value )
                    tabId.rows[i].style.display = "none";
                else
                    tabId.rows[i].style.display = "table-row";
            }
        }
        else{
            for(var i = 1; i < numRows; ++i){
                tabId.rows[i].style.display = "table-row";
            }
        }
    }
</script>