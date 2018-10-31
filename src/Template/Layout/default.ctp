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
$cakeDescription = 'ECCI - Sistema de Control de Asistencias';
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
      <!-- <link rel="stylesheet" href="plugins/font/typicons.min.css"/></head><body><div class="page-header">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"> -->
    <?= $this->Html->script(['jquery-3.3.1.min', 'bootstrap.min','jquery.dataTables.min']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <style type="text/css">
      .bg-ecci-blue {
        background-color:#015b96ff;
      }
      .bg-ecci-green {
        background-color:#ceb92bff;
      }
      .ecci-title {
        color: white;
        border-bottom: 2px solid #ceb92bff;
      }
    </style>

    <!-- <style type="text/css">
      h1.text {
        color: white;
        text-align: center;
        height:60px;
      }

      h2.text2 {
        color: white;
        text-align: center;
        height:40px;
      }
      .backg2 {
        background-color:#ceb92bff;
      }
      * {
				margin:0px;
				padding:0px;
			}
			#header {
				margin:auto;
				width:630px;
        height:70px;
				font-family:Arial, Helvetica, sans-serif;
        align-items: center; 
			}
			
			ul, ol {
				list-style:none;
			}
			
			.nav > li {
				float:left;
			}
			
			.nav li a {
				background-color:#fff;
				color:#000;
				text-decoration:none;
				padding:10px 12px;
				display:block;
			}
			
			.nav li a:hover {
				background-color:#015b96ff;
        color:#fff;
			}
			
			.nav li ul {
				display:none;
				position:absolute;
				min-width:140px;
			}
			
			.nav li:hover > ul {
				display:block;
			}
			
			.nav li ul li {
				position:relative;
			}
			
			.nav li ul li ul {
				right:-140px;
				top:0px;
			}
      #OverviewText1 img{
        width: 100px;
        height: 50px;
        position: relative;
        float: left;
        top: -40px;
        left: 5px;
      }
      #OverviewText2 img{
        width: 200px;
        height: 50px;
        position: relative;
        float:left;
        top: 25px;
        left: -95px;
      }
      #OverviewText3 img{
        width: 30px;
        height: 30px;
        position: relative;
        top: -30px;
      }
      b {
          border-bottom: 1.5px solid #ceb92bff;
          padding: 0 0 0px;
      }
    </style> -->
</head>
<body>
<!-- <h1 class="text backg"><b><font size="6">Sistema de control de asistencias</font></b>
    <div id="OverviewText1"> 
      <img src="http://www.lis.ucr.ac.cr/_vista/imagenes/logoUcr.png" />
    </div>
    <div id="OverviewText2"> 
      <img src="https://www.ecci.ucr.ac.cr/sites/all/themes/ecci_bootstrap/logo.png" />
    </div>
    <div id="OverviewText3"> 
      <img src="https://cdn.onlinewebfonts.com/svg/img_264570.png" align="right"/>
    </div>
</h1> -->

    
    <nav class="navbar navbar-fixed-top navbar-expand-xl justify-content-between bg-ecci-blue">
      <a class="navbar-brand">
        <?= $this->Html->image('logoUcr.png', ['style' => 'width:100px'])?>
      </a>
      <span class="navbar-text">
        <h2 class="ecci-title">Sistema de control de asistencias</h2>
      </span>
      <div class='dropdown' style='width:100px'>
        <?php if ( $current_user ): ?>
          <div>
            <?= $this->Html->image('userIcon.png', ['class' => 'ml-1','style' => 'width:50px'])?>
          </div>
          <div>
            <a class='dropdown-toggle text-black' id="dropdownLogout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $current_user['name'] ?></a>
            <div class='dropdown-menu dropdown-menu-right' aria-labeledby="dropdownLogout">
              <?= $this->Html->link('Perfil', ['controller' => 'Users', 'action' => 'view', $current_user['identification_number'] ], ['class' => 'dropdown-item']) ?>
              <div class="dropdown-divider"></div>
              <?= $this->Html->link('Cerrar Sesión', ['controller' => 'Security', 'action' => 'logout'], ['class' => 'dropdown-item']) ?>
            </div>
          </div>
        <?php endif ?>
      </div>
    </nav>

    <nav class="navbar navbar-fixed-top navbar-expand-xl justify-content-between navbar-light bg-white">    
      <a class="navbar-brand">
        <?= $this->Html->image('logoEcci.png', ['class' => 'mr-4','style' => 'width:200px'])?>
      </a>

      <div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#modulesList" aria-controls="modulesList" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="modulesList">
          <ul class="nav navbar-nav">
            
            <li class="nav-item"><h5><?= $this->Html->link('Inicio',['controller'=>'Mainpage','action'=>'index'],['class'=>'nav-link']) ?></h5></li>
            
            <li class="nav-item"><h5><?= $this->Html->link('Solicitudes',['controller'=>'Requests','action'=>'index'],['class'=>'nav-link']) ?></h5></li>

            <li class="nav-item"><h5><?= $this->Html->link('Curso-grupo',['controller'=>'CoursesClassesVw','action'=>'index'],['class'=>'nav-link']) ?></h5></li>

            <li class="nav-item dropdown"><h5>
              <a class="nav-link dropdown-toggle" href="#" id="dropdownReq" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Requisitos
              </a>
              <div class="dropdown-menu" aria-labeledby="dropdownReq">
                <?= $this->Html->link('Listar',['controller'=>'Requirements','action'=>'index'],['class'=>'dropdown-item'] ) ?>
                <?= $this->Html->link('Agregar',['controller'=>'Requirements','action'=>'add'],['class'=>'dropdown-item'] ) ?>
              </div>
            </h5></li>

            <li class="nav-item"><h5><?= $this->Html->link('Ronda',['controller'=>'Rounds','action'=>'index'],['class'=>'nav-link']) ?></h5></li>

            
            <li class="nav-item"><h5><?= $this->Html->link('Usuarios',['controller'=>'Users','action'=>'index'],['class'=>'nav-link']) ?></h5></li>

              
            </h5></li>

            <li class="nav-item"><h5><?= $this->Html->link('Roles',['controller'=>'Roles','action'=>'index'],['class'=>'nav-link']) ?></h5></li>

             <li class="nav-item"><h5><?= $this->Html->link('Reportes',['controller'=>'Reports','action'=>'approved_Report'],['class'=>'nav-link']) ?></h5></li>
          
          </ul>
        </div>
      </div>

      <div style="width:200px">
      </div>
    </nav>


    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark justify-content-center bg-ecci-green">
      <span class="navbar-text"> </span>
    </nav>

    <?= $this->Flash->render() ?>

    <div class="container pt-5">
      <?= $this->fetch('content') ?>
    </div>

    <footer>
    </footer>

</body>
</html>