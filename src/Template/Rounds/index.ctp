<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        
    </ul>
    
</nav>

<div class="rounds index large-9 medium-8 columns content">
    <h3>
        <?= __('Rondas') ?>
        <?= $this->Form->Button('Agregar Ronda',['RoundsController' => 'Rounds', 'action'=> 'add','align'=>'right']) ?>
    </h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('#') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Semestre') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Año') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Fecha Inicial') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Fecha Final') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col"><?= $this->Paginator->sort('Fecha Final Aprovación') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th scope="col" class="actions"><?= __('Acciones') ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rounds as $round): ?>
            <tr>
                <td><?= h($round->round_number) ?></td>
                <td><?= h($round->semester) ?></td>
                <td><?= h($round->year) ?></td>
                <td><?= h($round->start_date) ?></td>
                <td><?= h($round->end_date) ?></td>
                <td><?= h($round->approve_limit_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $round->start_date]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->Form->postButton('Eliminar Última Ronda',['RoundsController' => 'Rounds', 'action'=> 'delete']) ?>
</div>
