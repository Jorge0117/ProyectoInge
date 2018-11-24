<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<!DOCTYPE html>
<html>
<head>
<style>
<div class= 'row'>
table, th, td {
    border: 1px solid black;
    border-collapse: separated;
    border-spacing: 10px 5px;
}
th, td {
    padding: 5px;
}
#boton bt {
  margin: 0;
  font-size: 35px;
  bottom:0; right:0;
}

.bottomright {
    position: absolute;
    bottom: -60px;
    right: 250px;
    font-size: 18px;
    display:flex;
    justify-content:space-araund;
    margin: 0;
    display: inline-block;
}


</style>
</head>
<body>

<div class="row">

    <div class="col-md-5">
        <h2>Datos personales</h2>

        <table class="table">
        <tbody>
          <tr>
            <th scope="row">Cedula:</th>
            <td><?= h($user->identification_number) ?></td>
          </tr>
          <tr>
            <th scope="row">Nombre:</th>
            <td><?= h($user->name) ?></td>
          </tr>
          <tr>
            <th scope="row">Apellidos:</th>
            <td><?= h($user->lastname1.' '.$user->lastname2) ?></td>
          </tr>
          <tr>
            <th scope="row">Teléfono:</th>
            <td><?= h($user->phone) ?></td>
          </tr>
          <tr>
            <th scope="row">Correo:</th>
            <td><?= h($user->email_personal) ?></td>
          </tr>
          <?php if ($user['role_id'] === 'Estudiante'): ?>
            <th scope="row">Carné:</th>
            <td><?= h(strtoupper($user->students[0]->carne)) ?></td>
          <?php endif ?>
        </tbody>
        </table>
    </div>

    <div class="col-md-5 offset-md-2">
        <h2> Datos de seguridad</h2>
        <table class="table">
        <tbody>
        <tr>
            <th scope="row">Nombre de usuario:</th>
            <td><?= h($user->username) ?></td>
          </tr>
          <tr>
            <th scope="row">Rol:</th>
            <td><?=  h($user->role->role_id) ?></td>
          </tr>
        </tbody>
        </table>
    </div>
</div>
<div class="row mt-5">
    <div class="col" align="right">
    <!-- <bt> -->
    <?php 
     echo $this->Html->link('Editar', ['action' => 'edit', $user->identification_number], array('class' => 'btn btn-primary')); 
     ?>
    <?php
      if ($current_user['role_id'] === 'Administrador') {
        echo $this->Form->postLink('Eliminar', ['action' => 'delete', $user->identification_number, 
        'confirm' => __('¿Está seguro que desea eliminar el usuario {0}?', $user->name.' '.$user->lastname1)], 
        array('class' => 'btn btn-primary'));
      }
     ?>
    <?php 
        echo $this->Html->link('Cancelar', ['action' => 'index'], array('class' => 'btn btn-secondary')); 
    ?>
    <!-- </bt> -->
    </div>
</div>
</body>
</html>

