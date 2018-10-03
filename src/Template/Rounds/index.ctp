<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Round'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rounds index large-9 medium-8 columns content">
    <h3><?= __('Rounds') ?></h3>
    <table cellpadding="0" id="roundstable" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('semester') ?></th>
                <th scope="col"><?= $this->Paginator->sort('year') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('approve_limit_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rounds as $round): ?>
            <tr>
                <td><?= $this->Number->format($round->number) ?></td>
                <td><?= $this->Number->format($round->semester) ?></td>
                <td><?= $this->Number->format($round->year) ?></td>
                <td><?= h($round->start_date) ?></td>
                <td><?= h($round->end_date) ?></td>
                <td><?= h($round->approve_limit_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $round->semester]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $round->semester]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $round->semester], ['confirm' => __('Are you sure you want to delete # {0}?', $round->semester)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $("#roundstable").DataTable(
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
