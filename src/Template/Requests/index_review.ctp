<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request[]|\Cake\Collection\CollectionInterface $requests
 */
?>

<style>
    /*DIV.table{
        display:table;
    }

    FORM.tr, DIV.tr{
        display:table-row;
    }

    SPAN.td{
        display:table-cell;
    }*/
</style>

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

        $('#requesttable').on('click', '.assistance', function (event) {                
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;
            var table = document.getElementById('requesttable');

            table.rows[row].cells[col].firstElementChild.value = null;
            table.rows[row].cells[col].firstElementChild.disabled = false;

            table.rows[row].cells[col + 1].firstElementChild.value = null;
            table.rows[row].cells[col + 1].firstElementChild.disabled = true;

            table.rows[row].cells[col + 2].firstElementChild.value = null;
            table.rows[row].cells[col + 2].firstElementChild.disabled = true;
        });

        $('#requesttable').on('click', '.student', function (event) {                
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;
            var table = document.getElementById('requesttable');

            table.rows[row].cells[col].firstElementChild.value = null;
            table.rows[row].cells[col].firstElementChild.disabled = false;

            if(col == 9){
                table.rows[row].cells[10].firstElementChild.value = null;
                table.rows[row].cells[10].firstElementChild.disabled = false;
            }
            else{
                table.rows[row].cells[9].firstElementChild.value = null;
                table.rows[row].cells[9].firstElementChild.disabled = false;
            }

            table.rows[row].cells[8].firstElementChild.value = null;
            table.rows[row].cells[8].firstElementChild.disabled = true;
        });

        $('#requesttable').on('change', '.status', function (event) {  
            var $d = $(this).parent("td");     
            var col = $d.parent().children().index($d);
            var row = $d.parent().parent().children().index($d.parent()) + 1;
            var table = document.getElementById('requesttable');

            if(this.value == 'a' || this.value == 'i'){
                table.rows[row].cells[col + 2].firstElementChild.value = null;
                table.rows[row].cells[col + 2].firstElementChild.disabled = false;
                table.rows[row].cells[col + 2].firstElementChild.style.borderColor = "grey";

                table.rows[row].cells[col + 3].firstElementChild.value = null;
                table.rows[row].cells[col + 3].firstElementChild.disabled = false;
                table.rows[row].cells[col + 3].firstElementChild.style.borderColor = "grey";

                table.rows[row].cells[col + 4].firstElementChild.value = null;
                table.rows[row].cells[col + 4].firstElementChild.disabled = false;
                table.rows[row].cells[col + 4].firstElementChild.style.borderColor = "grey";

            }
            else{
                table.rows[row].cells[col + 2].firstElementChild.value = null;
                table.rows[row].cells[col + 2].firstElementChild.disabled = true;

                table.rows[row].cells[col + 3].firstElementChild.value = null;
                table.rows[row].cells[col + 3].firstElementChild.disabled = true;

                table.rows[row].cells[col + 4].firstElementChild.value = null;
                table.rows[row].cells[col + 4].firstElementChild.disabled = true;
            }
        });
    });
</script>

<div class="requests index large-9 medium-8 columns content text-grid">
    <!--?= $this->Form->create($request) ?-->

    <div class='container'>
        <h3><?= __('Revisión final solicitudes') ?></h3>
    
        <table cellpadding="0" cellspacing="0" id = "requesttable">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('Carné') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Promedio') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Ronda') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Tiene otras horas') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('HA ECCI') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('HE ECCI') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('HE DOC') ?></th>
                    <th scope="col" class="actions"><?= __('Aceptar') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $index=1; foreach ($query as $request): ?>
                <form id="form".$index method=GET action="indexReview">
                <tr>  
                    <td><?= h($request[0]) ?></td>
                    <td><?= h($request[1]) ?></td>

                    <td><?= $this->Number->format($request[2]) ?></td>
                    <td><?= h($request[3]) ?></td>
                    <td><?= $this->Number->format($request[4]) ?></td>
                    <td><?= $this->Number->format($request[5]) ?></td>
                    
                    <td class="actions" style="width:100px;">
                        <select id="status" name="status" class='btn status'>
                            <option value = "n">------------------</option>
                            <option value = "a">Aceptado</option>
                            <option value = "i">Aceptado por inopia</option>
                            <option value = "r">Rechazado</option>
                        </select>
                    </td>
                
                    <?php if ($request[7] === true): ?>
					    <td> SI </td>
				    <?php else: ?>
					    <td> NO </td>
				    <?php endif; ?>
                    
                    <td class="actions">
                        <input type="number" name="ashour" class="btn assistance" min="3" max="20" style="width:60px;" disabled>
                        
                        <!--?= $this->Form->control('hours',[
                            'class'=>'assistance',
							'type'=>'number',
							'min' => '3',
							'max' => '12',
                            'label' => false,
                            'onclick'=>"clear_student_hours(requesttable)",
							//'disabled'
						]);?-->
                    </td>

                    <td class="actions" style="width:100px">
                        <input type="number" name="eshourEcci" class="btn student" min="3" max="12" style="width:60px" disabled>

                        <!--?= $this->Form->control('hours',[
                            'class'=>'student',
							'type'=>'number',
							'min' => '3',
							'max' => '12',
                            'label' => false,
                            'onclick'=>"clearHours()",
							'disabled'
						]);?-->
                    </td>

                    <td class="actions" style="width:100px">
                        <input type="number" name="eshourDoc" class="btn student" min="3" max="12" style="width:60px" disabled>
                        <!--?= $this->Form->control('hours',[
                            'class'=>'student',
							'type'=>'number',
							'min' => '3',
							'max' => '12',
                            'label' => false,
                            'onclick'=>"clearHours()",
							'disabled'
						]);?-->
                    </td>

                    <!--td class="actions">
                        <button type="submit" class='btn btn-primary float-right btn-space btn-aceptar'>
                            Aceptar
                        </button>
                    </td-->

                    <td>
                        <input type="submit" class='btn btn-primary float-right btn-space btn-aceptar' id="submit".$index form="form".$index value="Aceptar" />
                    </td>
                    <!--td class="submit">
                        
                    </td-->
                </tr>
                </form>
                <?php $index=$index+1; endforeach; ?>
            </tbody>
        </table>

        <?php 
            $this->Form->unlockField("status");
            $this->Form->unlockField("ashour");
            $this->Form->unlockField("eshourEcci");
            $this->Form->unlockField("eshourDoc");
        ?>
    <div> 

    
</div>