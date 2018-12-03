<?php
/**
 * @author Valeria Zamora
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request[]|\Cake\Collection\CollectionInterface $requests
 */
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 
<script type="text/javascript">
    $(document).ready( function () {
        $("#requesttable").DataTable(
          {
            "order": [[ 0, "desc" ]],
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

    /**
     * Función encargada de filtrar las solicitudes.
     * 
     * @author Nathan González
     * @parameter selector Id del select para tomar su valor.
     * @parameter table Id de la tabla para poder filtrarla.  
     * @return Flash Para informar que la solicitud se reviso con exito.
     */
    function hideRequest(selector, table){
        var selId = document.getElementById(selector); // Identificador del selector.
        var tabId = document.getElementById(table);    // Identificador de la tabla que se va a filtrar.
        var numRows = tabId.rows.length;               // Cantidad de solicitudes en la tabla.
        
        // Si el valor es todos, muestre todas las solicitudes de la tabla.
        // Si no filtre las solicitudes y muestre todas las solicitudes con el estado deseado.
        if(selId.value != 't'){
            for(var i = 1; i < numRows; ++i){
                tabId.rows[i].style.display = "table-row";
            }

            for(var i = 1; i < numRows; ++i){
                if( tabId.rows[i].cells[9].innerText != selId.value ){
                    tabId.rows[i].style.display = "none";
                }
                else{
                    tabId.rows[i].style.display = "table-row";
                }
            }
        }
        else{
            for(var i = 1; i < numRows; ++i){
                tabId.rows[i].style.display = "table-row";
            }
        }
    }
</script>

<div class="requests index large-9 medium-8 columns content text-grid">
    <h3><?= __('Solicitudes de la ronda actual') ?></h3>

    <br><br>

    <!-- Nos permite filtrar las solicitudes dependiendo del estado de las que queremos buscar. -->
    <div class="row justify-content-between" >
        <div class="col-0">
            <label> 
                Buscar por:
            </label>

            <!-- Elija el estado que se desea mostrar o elija todas para mostrar todas las solicitudes. -->
            <select id = 'request' name='request_' onchange='hideRequest(this.id, "requesttable")' style='border-style: inset;'>
                <option value = 't'>Todas</option>
                <option value = 'Aceptada'>Aceptada</option>
                <option value = 'Elegible'>Elegible</option>
                <option value = 'Elegible por inopia'>Elegible por inopia</option>
                <option value = 'No elegible'>No elegible</option>
                <option value = 'Pendiente'>Pendiente</option>
                <option value = 'Rechazada'>Rechazada</option>
                <option value = 'Anulada'>Anulada</option>
                <option value = 'Aceptada por inopia'>Aceptada por inopia</option>
            </select>
        </div>

        <?php if ($current_user['role_id'] === 'Administrador'): ?>
            <div class="col-xl-0 self-align-end">
                <?= $this->Html->link('Revisar solicitudes elegibles',['controller'=>'Requests','action'=>'index_review'],['class'=>'btn btn-primary float-right btn-space btn-aceptar']) ?>
            </div>
        <?php endif; ?>
    <div>

    <br>
    
    <table cellpadding="0" cellspacing="0" id = "requesttable">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Número de solicitud') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha', 'Fecha de solicitud') ?></th>
                <?php if (!($current_user['role_id'] === 'Estudiante')): ?>
                    <th scope="col"><?= $this->Paginator->sort('Carné') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Promedio') ?></th>
                <?php endif; ?>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Ciclo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Ronda') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                <th scope="col"><?= $this->Paginator->sort('otras_horas','Tiene otras horas') ?></th>
                <th scope="col" class="actions"><?= __('Opciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $request): ?>
            <tr>
                <td><?= h($request->id) ?></td>
                
                <td><?= h($request->fecha) ?></td>
                

                <?php if (!($current_user['role_id'] === 'Estudiante')): ?>
                    <td><?= h(strtoupper($request->carne)) ?></td>
                    <td><?= h($request->nombre) ?></td>

                    <?php if ($this->Number->format($request->promedio) == 0): ?>
                        <td> Pendiente </td>
                    <?php else: ?>
                        <td><?= $this->Number->format($request->promedio) ?></td>
                    <?php endif; ?>
                <?php endif; ?>

                <td><?= h($request->anno) ?></td>
                <td><?= $this->Number->format($request->semestre) ?></td>
                <td><?= h($request->curso) ?></td>
                <td><?= $this->Number->format($request->grupo) ?></td>
                <td><?= $this->Number->format($request->ronda) ?></td>
                
                <?php if ($request->estado === 'p'): ?>
                    <td> Pendiente </td>
				<?php else: ?>
                    <?php if ($request->estado === 'a'): ?>
                        <td> Aceptada </td>
                    <?php else: ?>
                        <?php if ($request->estado === 'e'): ?>
                            <td> Elegible </td>
                        <?php else: ?>
                            <?php if ($request->estado === 'r'): ?>
                                <td> Rechazada </td>
                            <?php else: ?>
                                <?php if ($request->estado === 'i'): ?>
                                    <td> Elegible por inopia </td>
                                <?php else: ?>
                                    <?php if ($request->estado === 'n'): ?>
                                        <td> No elegible </td>
                                    <?php else: ?>
                                        <?php if ($request->estado === 'x'): ?>
                                            <td> Anulada </td>
                                        <?php else: ?>
                                            <?php if ($request->estado === 'c'): ?>
                                                <td> Aceptada por inopia </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

				<?php endif; ?>

                <?php if ($request->otras_horas === true): ?>
					<td> SI </td>
				<?php else: ?>
					<td> NO </td>
				<?php endif; ?>
				
                
                <td class="actions">
                    <div width="20px">
                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $request->id], ['escape'=>false]) ?>

                    <?= $this->Html->link('<i class="fa fa-print"></i>', ['action' => 'print', $request->id], ['target' => '_blank', 'escape'=>false]) ?>
                    
                    <?php if ($admin === true): ?>
                    <?= $this->Html->link('<i class="fa fa-pencil-square-o"></i>', ['action' => 'review', $request->id], ['escape'=>false]) ?>

                    <?= $this->Form->button('<i class="fa fa-times"></i>', ['onclick' => "cancelJust($request->id)",'id'=>'cancelar', "class" => "btn-x"]) ?>    

                    <?php endif; ?>
                    </div>
                </td>
				
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>

function cancelJust(id) {
    var just = prompt("Anular solicitud", "Inserte la justificación");
    if(just != null){
        window.location.replace("./requests/cancelRequest/" + id + "/" + just);
    }
}

</script>

