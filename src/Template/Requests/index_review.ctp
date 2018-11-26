<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request[]|\Cake\Collection\CollectionInterface $requests
 */
?>

<div class="requests index large-9 medium-8 columns content text-grid">

    <div class='container'>
        <h3><?= __('Revisión final solicitudes') ?></h3>  

        <table cellpadding="0" cellspacing="0" id = "requesttable">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('Número de solicitud') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Carné') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Promedio') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Tiene otras horas') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Tipo de hora') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Hora') ?></th>
                    <th scope="col" class="actions"><?= __('Aceptar') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($query as $request): ?>
                
                <tr>  
                    <td><?= h($request[0]) ?></td>
                    <td><?= h($request[1]) ?></td>

                    <td><?= $this->Number->format($request[2]) ?></td>
                    <td><?= h($request[3]) ?></td>
                    <td><?= $this->Number->format($request[4]) ?></td>
                    
                    <td class="actions" style="width:100px;">
                        <select id="status" name="status" class='btn status'>
                            <option value = "n">------------------</option>
                            <option value = "a">Aceptado</option>
                            <option value = "i">Aceptado por inopia</option>
                            <option value = "r">Rechazado</option>
                        </select>
                    </td>
                
                    <?php if ($request[5] === true): ?>
					    <td> SI </td>
				    <?php else: ?>
					    <td> NO </td>
				    <?php endif; ?>
                    
                    <td class="actions">
                        <select id="checkbox" name="checkbox" class='btn checkbox' disabled>
                            <option value = "NON">------------------</option>
                            <option value = 'HAE'>HA ECCI</option>
                            <option value = 'HEE'>HE ECCI</option>
                            <option value = 'HED'>HE DOC</option>
                        </select>
                    </td>

                    <td class="actions" style="width:100px">
                        <input type="number" name="hour" class="btn hour" min="3" max="12" style="width:60px" disabled>
                    </td>

                    <td>
                        <input type="buttom" class='btn btn-primary float-right btn-space btn-aceptar' style="width:80px" value="Agregar" disabled>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?= $this->Form->create(false,['id'=>'submitRequest'] ); ?>
        <?php 
            echo $this->Form->input('sendId', ['type'=>'hidden'] ); 
            echo $this->Form->input('sendStatus', ['type'=>'hidden'] );
            echo $this->Form->input('sendHourType', ['type'=>'hidden'] );
            echo $this->Form->input('sendHour', ['type'=>'hidden'] );
            echo $this->Form->button('button',['id'=>'button', 'type'=>'button', 'hidden'] );

            $this->Form->unlockField('sendId');
			$this->Form->unlockField('sendStatus');
            $this->Form->unlockField('sendHourType');
            $this->Form->unlockField('sendHour');
        ?> 
        <?= $this->Form->end(); ?>

    <div> 
</div>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 
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

        $('#requesttable').on('change', '.status', function (event) {  
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;
            var table = document.getElementById('requesttable');

            if( this.value == 'a' || this.value == 'i' ){
                table.rows[row].cells[7].firstElementChild.value = 'NON';
                table.rows[row].cells[7].firstElementChild.disabled = false;
                table.rows[row].cells[9].firstElementChild.disabled = true;
            }
            else{
                table.rows[row].cells[7].firstElementChild.value = 'NON';
                table.rows[row].cells[7].firstElementChild.disabled = true;

                table.rows[row].cells[8].firstElementChild.disabled = true;
                table.rows[row].cells[8].firstElementChild.value = null;

                if( this.value == 'r' ) table.rows[row].cells[9].firstElementChild.disabled = false;
                else table.rows[row].cells[9].firstElementChild.disabled = true;
            }
        });

        $('#requesttable').on('change', '.checkbox', function (event) {                
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;
            var table = document.getElementById('requesttable');

            if( this.value == 'HAE' ){
                table.rows[row].cells[8].firstElementChild.disabled = false;
                table.rows[row].cells[8].firstElementChild.value = 3;
                table.rows[row].cells[8].firstElementChild.max = 20;
            }
            else{
                if( this.value == 'HEE' || this.value == 'HED' ){
                    table.rows[row].cells[8].firstElementChild.disabled = false;
                    table.rows[row].cells[8].firstElementChild.value = 3;
                    table.rows[row].cells[8].firstElementChild.max = 12;
                }
                else{
                    table.rows[row].cells[8].firstElementChild.disabled = true;
                    table.rows[row].cells[8].firstElementChild.value = null;
                }
            }
        });

        $('#requesttable').on('change', '.hour', function (event) {                
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;
            var table = document.getElementById('requesttable');

             table.rows[row].cells[9].firstElementChild.disabled = false;
        });

        $('#requesttable').on('click', '.btn-aceptar', function (event){  
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;

            document.getElementById("button").click();

            $('#button').on('click', function (event){  
                var table = document.getElementById('requesttable');

                document.getElementById('sendid').value = table.rows[row].cells[0].innerHTML;
                document.getElementById('sendstatus').value = table.rows[row].cells[5].firstElementChild.value;
                document.getElementById('sendhourtype').value = table.rows[row].cells[7].firstElementChild.value;
                document.getElementById('sendhour').value = table.rows[row].cells[8].firstElementChild.value;

                document.getElementById('submitRequest').submit();
            });  
        });
    });
</script>