<?php
/**
 * @author Nathan González
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
                
                <?php foreach ($requests as $request): ?>
                <tr>  
                    <!-- Número de solicitud -->
                    <td><?= h($request[0]) ?></td>

                    <!-- Carné del solicitante -->
                    <td><?= h($request[1]) ?></td>

                    <!-- Promedio del solicitante -->
                    <td><?= $this->Number->format($request[2]) ?></td>

                    <!-- Curso solicitado -->
                    <td><?= h($request[3]) ?></td>

                    <!-- Grupo solicitado -->
                    <td><?= $this->Number->format($request[4]) ?></td>
                    
                    <!-- Estado de la solicitud -->
                    <td class="actions" style="width:100px;">
                        <select id="status" name="status" class='btn status'>
                            <option value = "n">------------------</option>
                            <option value = "a">Aceptado</option>
                            <option value = "c">Aceptado por inopia</option>
                            <option value = "r">Rechazado</option>
                        </select>
                    </td>
                
                    <!-- Tiene otras horas -->
                    <?php if ($request[5] === true): ?>
					    <td> SI </td>
				    <?php else: ?>
					    <td> NO </td>
				    <?php endif; ?>
                    
                    <!-- Tipo de hora -->
                    <td class="actions">
                        <select id="checkbox" name="checkbox" class='btn checkbox' disabled>
                            <option value = "NON">------------------</option>
                            <option value = 'HAE'>HA ECCI</option>
                            <option value = 'HEE'>HE ECCI</option>
                            <option value = 'HED'>HE DOC</option>
                        </select>
                    </td>

                    <!-- Cantidad de horas -->
                    <td class="actions" style="width:100px">
                        <input type="number" name="hour" class="btn hour" min="3" max="12" style="width:60px" disabled>
                    </td>

                    <!-- Botón para procesar su respectiva fila -->
                    <td>
                        <input type="button" class='btn btn-primary float-right btn-space btn-aceptar' value="Aceptar y enviar" disabled>
                    </td>
                </tr>

                <?= $this->Form->create(false,['id'=>'hourData'] ); ?>
                <?php 
                    // Verifica si tiene horas asignadas
                    $hah = "hasAsignedHours_".$request[0];
                    $assigned = $$hah?1:0;

                    echo $this->Form->control('assigned'.$request[0], ['type'=>'number', 'value' => $assigned, 'label' => false ,'style' => 'display:none' ] ); 

                    $hourMax = "student_max_hours_".$request[0];
                    // maximo de horas estudiante ecci
                    echo $this->Form->control('heeMax'.$request[0], ['type'=>'number', 'value' => $$hourMax['HEE'], 'label' => false ,'style' => 'display:none' ] );

                    // maximo de horas estudiante doc
                    echo$this->Form->control('hedMax'.$request[0], ['type'=>'number', 'value' => $$hourMax['HED'], 'label' => false ,'style' => 'display:none' ] );

                    // maximo de horas asistente ecci
                    echo $this->Form->control('haeMax'.$request[0], ['type'=>'number', 'value' => $$hourMax['HAE'], 'label' => false ,'style' => 'display:none' ] );
                ?> 
                <?= $this->Form->end(); ?>

                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Datos para controlar las horas de la solicitud -->
        <?= $this->Form->create(false,['id'=>'submitRequest'] ); ?>
        <?php 
            // Número de solicitud
            echo $this->Form->input('sendId', ['type'=>'hidden'] ); 

            // Estado de la solicitud
            echo $this->Form->input('sendStatus', ['type'=>'hidden'] );

            // Tipo de horas de la solicitud
            echo $this->Form->input('sendHourType', ['type'=>'hidden'] );

            // Cantidad de horas de la solicitud
            echo $this->Form->input('sendHour', ['type'=>'hidden'] );

            // Botón oculto encargado de enviar a procesar la forma oculta
            echo $this->Form->button('button',['id'=>'button', 'type'=>'button', 'hidden'] );

            // Permiso para enviar los valores de los campos al controlador
            $this->Form->unlockField('sendId');
			$this->Form->unlockField('sendStatus');
            $this->Form->unlockField('sendHourType');
            $this->Form->unlockField('sendHour');
        ?> 
        <?= $this->Form->end(); ?>
    <div> 
</div>

<?= $this->Html->script('Generic'); ?>

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

        /**
         * Si se elige el estado aceptado o aceptado por inopia se desbloquearan los tipos de hora,
         * caso contrario se desbloqueara el botón para enviar la solicitud rechazada.
         * 
         * @author Nathan González
         */
        $('#requesttable').on('change', '.status', function (event) {  
            // Se toma la fila y la columna del elemento que cambio
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;

            // Se busca la tabla por su id
            var table = document.getElementById('requesttable');

            /* Si es aceptado o aceptado por inopia se desbloquea la elección de tipo de hora, sino
             * se bloquea la elección de tipo de hora y si el estado es rechazado se activa el botón 
             * para enviar la solicitud.
             */
            if( this.value == 'a' || this.value == 'c' ){
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

        

        /**
         * Función encargada de establecer el mínimo y máximo de horas 
         * dependiendo del tipo de horas elegidas .
         * 
         * @author Nathan González
         * @author Daniel Marín
         */
        $('#requesttable').on('change', '.checkbox', function (event) {   
            // Se toma la fila y la columna del elemento que cambio             
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;

            // Se busca la tabla por su id
            var table = document.getElementById('requesttable');

            student_max_hours = 'student_max_hours_'.concat(table.rows[row].cells[0].innerText);
            hasAsignedHours = 'hasAsignedHours_'.concat(table.rows[row].cells[0].innerText);
            // Si se elige horas asistentes su min será 3 y su max 20, 
            // si se elije horas estudiantes su min será 3 y su max 12. 
            // Caso contrario se bloqueara la entrada de datos
            
            id = table.rows[row].cells[0].innerText;
            field = table.rows[row].cells[8].firstElementChild;
            console.log('haemax'.concat(id));

            if( this.value == 'HAE' ){
                table.rows[row].cells[8].firstElementChild.disabled = false;
                field.min =  byId('haemax'.concat(id)).value < 3 || byId('assigned'.concat(id)).value? 1:3 ;
                field.max =  byId('haemax'.concat(id)).value;
                table.rows[row].cells[8].firstElementChild.value = table.rows[row].cells[8].firstElementChild.min;
            }
            else{
                if( this.value == 'HEE' || this.value == 'HED' ){
                    table.rows[row].cells[8].firstElementChild.disabled = false;
                    if(this.value == 'HEE'){
                        field.min =  byId('heemax'.concat(id)).value < 3 || byId('assigned'.concat(id)).value? 1:3;
                        field.max =  byId('heemax'.concat(id)).value;
                    }else if(this.value == 'HED'){
                        field.min =  byId('hedmax'.concat(id)).value < 3 || byId('assigned'.concat(id)).value? 1:3;
                        field.max =  byId('hedmax'.concat(id)).value;
                    }
                    
                    //table.rows[row].cells[8].firstElementChild.max = 12;
                    table.rows[row].cells[8].firstElementChild.value = table.rows[row].cells[8].firstElementChild.min;
                }
                else{
                    table.rows[row].cells[8].firstElementChild.disabled = true;
                    table.rows[row].cells[8].firstElementChild.value = null;
                }
            }
        });

        /**
         * Función encargada de desbloquear el botón de envio de solicitud si se establece la hora.
         * 
         * @author Nathan González
         */
        $('#requesttable').on('change', '.hour', function (event) { 
            // Se toma la fila y la columna del elemento que cambio                
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;

            // Se busca la tabla por su id
            var table = document.getElementById('requesttable');

            // Se desbloquea el botón de la fila correspondiente
            table.rows[row].cells[9].firstElementChild.disabled = false;
        });

        /**
         * Función encargada de cargar la forma oculta con los 
         * datos de la solicitud y enviarlos al controlador.
         * 
         * @author Nathan González
         */
        $('#requesttable').on('click', '.btn-aceptar', function (event){  
            // Se toma la fila y la columna del elemento que cambio
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;

            // Se busca el botón por su id
            document.getElementById("button").click();

            $('#button').on('click', function (event){  
                // Se busca la tabla por su id
                var table = document.getElementById('requesttable');

                // Se cargan los datos a la forma oculta
                document.getElementById('sendid').value = table.rows[row].cells[0].innerHTML;
                document.getElementById('sendstatus').value = table.rows[row].cells[5].firstElementChild.value;
                document.getElementById('sendhourtype').value = table.rows[row].cells[7].firstElementChild.value;
                document.getElementById('sendhour').value = table.rows[row].cells[8].firstElementChild.value;

                // Se envia los datos al controlador para que la solicitud sea procesada
                document.getElementById('submitRequest').submit();
            });  
        });
    });
</script>