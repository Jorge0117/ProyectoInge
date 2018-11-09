<?php
/**
 * Barra superior con el logo de UCR, el nombre del sistema y el
 * ícono/menú del del usuario.
 */
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> 

<nav class="navbar navbar-fixed-top navbar-expand-xl justify-content-between bg-ecci-blue">
    <a class="navbar-brand">
        <?= $this->Html->image('logoUcr.png', ['style' => 'width:100px'])?>
    </a>

    <span class="navbar-text">
        <h1>Sistema de control de asistencias</h1>
    </span>

    <div class='dropdown' style='width: 120px'>
        <?php if ( $current_user ): ?>
            <div>
                <i class="fa fa-user-circle-o" style="font-size:48px;color:white"></i>
            </div>
            <div>
                <a class='dropdown-toggle text-white user-icon' id="dropdownLogout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $current_user['name'] ?></a>
                <div class='dropdown-menu dropdown-menu-right' aria-labeledby="dropdownLogout">
                    <?= $this->Html->link('Perfil', ['controller' => 'Users', 'action' => 'view', $current_user['identification_number'] ], ['class' => 'dropdown-item']) ?>
                    <div class="dropdown-divider"></div>
                    <?= $this->Html->link('Cerrar Sesión', ['controller' => 'Security', 'action' => 'logout'], ['class' => 'dropdown-item']) ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</nav>