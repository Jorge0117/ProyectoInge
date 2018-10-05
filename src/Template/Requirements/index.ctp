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
<nav class="large-8 medium-8 columns" id="actions-sidebar">
    <ul class="nav">
        <li><?= $this->Html->link(__('Agregar un requisito'), ['controller' => 'Requirements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="courses index large-9 medium-8 columns content">
    <h3><?= __('Requisitos') ?></h3>
    <table cellpadding="0" cellspacing="0" id = 'viewRequirements'>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Sigla') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Curso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Grupo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Profesor') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Semestres') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
                <th scope="col" class="actions"><?= __('Opciones') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coursesClassesVw as $course): ?>
            <tr>
                <td><?= h($course->Sigla) ?></td>
                <td><?= h($course->Curso) ?></td>
                <td><?= $this->Number->format($course->Grupo) ?></td>
                <td><?= h($course->Profesor) ?></td>
                <td><?= h($course->Semestre) ?></td>
                <td><?= h($course->Año) ?></td>
                
                <td class="actions">
                    <?= $this->Html->link(
                                        __('Editar'), ['action' => 'edit', $course->Sigla]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $course->code], ['confirm' => __('Are you sure you want to delete # {0}?', $course->code)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

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