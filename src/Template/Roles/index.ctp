<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<div class='row'>
<h2> Rol:
</h2>
    <?php 
    echo $this->Form->select(
        'roles',
        $roles_array,
        ['empty' => 'Elija un rol...'
        ,'style' => 'width: 14%']
    )?>
    <?php 

    echo $this->Form->checkbox(
        'Editar'
    );
    ?>

</div>

<table style="width:100%">
<?php 
echo $this->Html->tableHeaders(['Permiso', 'Solicitudes','Cursos-Grupo',
 'Requisitos', 'Ronda', 'Usuarios',  'Roles' ]);

$con_check = $this->Form->checkbox(
    'Editar',
    ['checked' => true]
);
$sin_check = $this->Form->checkbox(
    'Editar',
    ['checked' => false]
);

foreach ($permissions_matrix as $perm_row){
    $permission_row[] = $perm_row[0];
    for($i = 1; $i < 7 ;$i++){
        $permission_row[] = $perm_row[$i]? $con_check : $sin_check; 
    }
    echo $this->Html->tableCells([
        $permission_row
    ]);
    $permission_row = [];
}

?>

</table>
<div>

</div>

<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Permissions'), ['controller' => 'Permissions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Permission'), ['controller' => 'Permissions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="roles index large-9 medium-8 columns content">
    <h3><?= __('Roles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
            <tr>
                <td><?= h($role->role_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $role->role_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $role->role_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $role->role_id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->role_id)]) ?>
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

-->