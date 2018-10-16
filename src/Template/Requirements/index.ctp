<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement[]|\Cake\Collection\CollectionInterface $requirements
 */
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

<div class="courses index large-9 medium-8 columns content">
    <?php if($show == 0): ?>
        <?= $this->Html->link('Agregar',['controller'=>'Requirements','action'=>'add'],['class'=>'btn btn-primary','style'=>'position:absolute; left: 66%; top: 20%']) ?>
    <?php endif; ?>
    
    <h3><?= __('Requisitos') ?></h3>
    <table cellpadding="0" cellspacing="0" id = 'viewRequirements'>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tipo') ?></th>
                
                <?php if($show == 0): ?>
                    <th scope="col" class="actions"><?= __('Opciones') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requirements as $requirement): ?>
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
        $("#viewRequirements").DataTable(
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