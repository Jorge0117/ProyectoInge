<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement[]|\Cake\Collection\CollectionInterface $requirements
 */
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<div class="courses index large-9 medium-8 columns content">
    <?php if($show == 0): ?> <!--Sirve para bloquear o desbloquear botón dependiendo de la ronda-->
            <?= $this->Html->link( //Botón de agregar requisito, que lleva a la vista para poder agregar un nuevo requisito
            'Agregar requisito',
            ['controller'=>'Requirements','action'=>'add'],//Se dirige a la vista de agregar
            ['class'=>'btn btn-primary float-right btn-space']
        )?>
    <?php endif; ?>
    
    <h3><?= __('Requisitos') ?></h3> <!--Título arriba del grid que indica la vista en la que se está-->
    <table cellpadding="0" cellspacing="0" id = 'viewRequirements'><!--Se define el grid con los datos de los requisitos-->
        <thead>
            <tr> <!--Nombre de las columnas en el grid-->
                <th scope="col"><?= $this->Paginator->sort('Descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tipo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Horas') ?></th>
                
                <?php if($show == 0): ?> 
                <?php endif; ?>
                    <th scope="col" class="actions"><?= __(' ') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requirements as $requirement): ?> <!--Se recuperan las tuplas de la base de datos-->
            <tr>
                <td><?= h($requirement->description) ?></td>
                <td><?= h($requirement->type) ?></td>

                <td class="actions">
                    <?php if($show == 0): ?>
                        <?= $this->Html->link('<i class="fa fa-pencil fa_custom fa-2x"></i>', ['action' => 'edit', $requirement->requirement_number],['escape' => false]) ?>
                        <?= $this->Form->postLink(
                            '<i class="fa fa-trash-o fa_custom fa-2x"></i>',
                            [
                                'action' => 'delete',
                                $requirement->requirement_number
                            ], 
                            [
                                'escape' => false,
                                'confirm' => __('Desea eliminar el requisito: {0}?',
                                $requirement->description)
                            ]
                        ) ?>
                    <?php endif; ?>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 </div>

<script type="text/javascript">
    $(document).ready( function () {
        $("#viewRequirements").DataTable(/*Se ponen las características del grid*/
          {
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por página",//Opción para mostrar número de filas por página
                "zeroRecords": "Sin resultados",//Mensaje que se muestra si no existen requisitos cuando se filtra haciendo una búsqueda
                "info": "Mostrando página _PAGE_ de _PAGES_",//Muestra el número de página actual
                "infoEmpty": "Sin datos disponibles",//Mensaje que se muestra si no existen tuplas
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch": "Buscar:",//Opción para buscar tupla
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