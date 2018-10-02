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
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon')    ?>

    <!-- Espacio donde se cargan los archivos pertinentes a bootstrap -->
    <?= $this->Html->css(['bootstrap.min','jquery.dataTables.min'])?>
    <?= $this->Html->script(['jquery-3.3.1.min', 'bootstrap.min','jquery.dataTables.min']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style type="text/css">
      *{margin: 0; padding: 0;}
      ul {
          list-style : none;
      }

      li {
          width: 200px;
          background: dark;
          padding: 10px;
          border-top: 5px solid #303030;
      }

      li a {
          font-size: 1em;
          color: #f2f2f2;
          text-decoration: none;
          text-shadow: 0 0 1px rgba(0,0,0,.1);
      }
      ul li:hover {
        opacity: .9;
        margin-left: 7px;
      }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <!-- Espacio para el nombre del proyecto. Además se definen columnas-->
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><img src="https://www.ecci.ucr.ac.cr/sites/all/themes/ecci_bootstrap/logo.png" style="width:200px;height:50px;"></a>

      <!-- Barra de la derecha. Aqui está el sing out-->
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sign out</a>
        </li>
      </ul>
    </nav>
    
    <!-- Div para el contenido de debajo de la página-->
    <div class="container-fluid">
      <div class="row">

        <!-- Barra lateral-->
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar">
          <div class="sidebar-sticky pt-5">
            <ul class="nav flex-column">
              <li class="nav-item">
                <?= $this->Html->link('Inicio',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
              </li>
              
              <li class="nav-item">
                <?= $this->Html->link('Solicitudes',['controller'=>'Subjects','action'=>'index'],['class'=>'nav-link']) ?>
              </li>

              <li class="nav-item">
                <?= $this->Html->link('Curso-Grupo',['controller'=>'Students','action'=>'index'],['class'=>'nav-link']) ?>
              </li>
              <li class="nav-item">
                <?= $this->Html->link('Requisitos',['controller'=>'Departments','action'=>'index'],['class'=>'nav-link']) ?>
              </li>
              <li class="nav-item">
                <?= $this->Html->link('Rondas',['controller'=>'Departments','action'=>'index'],['class'=>'nav-link']) ?>
              </li>
              <li class="nav-item">
                <?= $this->Html->link('Usuarios',['controller'=>'Departments','action'=>'index'],['class'=>'nav-link']) ?>
              </li>
              <li class="nav-item">
                <?= $this->Html->link('Roles',['controller'=>'Departments','action'=>'index'],['class'=>'nav-link']) ?>
              </li>
            </ul>

          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <!-- Linea que permite mostrar los msjs generados -->
                <?= $this->Flash->render() ?>

                <!-- Div que encapsula las vistas de los módulos-->
                <div class="container clearfix">
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </main>
    <footer>
    </footer>
</body>
</html>
