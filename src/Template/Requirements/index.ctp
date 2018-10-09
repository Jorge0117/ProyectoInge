<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<style>
    .button {
        background-color: #015b96ff;
        border: none;
        color:#fff;
        padding: 15px 32px;
        padding: 5px 7px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 8px 2px;
        cursor: pointer;
        float: right;
    }
    .button a {
        color:#fff; 
    }
    .actions a {
        color:#000; 
    }
    #image1 {
        height: 10px;
        width: 10px;
    }
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<button class="button"><?= $this->Html->link('Agregar',['controller'=>'Requirements','action'=>'add'],['class'=>'nav-link']) ?></button>
<div class="courses index large-9 medium-8 columns content">
    <h3><?= __('Requisitos') ?></h3>
    <table cellpadding="0" cellspacing="0" id = 'viewRequirements'>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tipo') ?></th>
                <th scope="col" class="actions"><?= __('Opciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requirements as $requirement): ?>
            <tr>
                <td><?= h($requirement->description) ?></td>
                <td><?= h($requirement->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fa fa-pencil fa_custom fa-2x"></i>', ['action' => 'edit', $requirement->requirement_number],['escape' => false]) ?>
                    <?= $this->Form->postLink('<i class="fa fa-trash-o fa_custom fa-2x"></i>',['action' => 'delete', $requirement->requirement_number], ['escape' => false,
        'confirm' => __('Desea eliminar el requisito: {0}?', $requirement->description)]) ?>
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
