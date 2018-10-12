<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
    
</nav> <!-- Aqui es la vista individual :D-->
<div class="users view large-9 medium-8 columns content">
    <table class="vertical-table">
    <tr>
            <th scope="row"><?= __('Datos personales:') ?></th>
        </tr>
    <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cédula') ?></th>
            <td><?= h($user->identification_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Primer apellido') ?></th>
            <td><?= h($user->lastname1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Segundo apellido') ?></th>
            <td><?= h($user->lastname2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre de usuario') ?></th>
            <td><?= h($user->username) ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('Correo') ?></th>
            <td><?= h($user->email_personal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Datos de seguridad:') ?></th>
        </tr>
        <tr>
            <th scope="row"><?= __('Teléfono') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('Rol') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->role_id, ['controller' => 'Roles', 'action' => 'view', $user->role->role_id]) : '' ?></td>
        </tr>
        <td class="actions">
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->identification_number]) ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $user->identification_number], ['confirm' => __('Are you sure you want to delete # {0}?', $user->identification_number)]) ?>
                </td>
    </table>
    <?php 
        echo $this->Html->link('Cancelar', 'users', array('class' => 'btn btn-primary')); 
    ?>
    