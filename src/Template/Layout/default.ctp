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
      h1.text {
        color: white;
        text-align: center;
        height:60px;
      }
      .backg {
        background-color:#015b96ff;
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
      #OverviewText1{
        position: relative;
      }
      #OverviewText1 img{
        width: 100px;
        height: 50px;
        position: absolute;
        top: -85px;
        left: -348px;
      }
      #OverviewText2{
        position: relative;
      }
      #OverviewText2 img{
        width: 200px;
        height: 50px;
        position: absolute;
        top: -23px;
        left: -358px;
      }
      #OverviewText3{
        position: relative;
      }
      #OverviewText3 img{
        width: 30px;
        height: 30px;
        position: absolute;
        top: -75px;
        left: 950px; 
      }
      b {
          border-bottom: 1.5px solid #ceb92bff;
          padding: 0 0 0px;
      }
    </style>
</head>
<body>
<h1 class="text backg"><b><font size="6">Sistema de control de asistencias</font></b></h1>
    <<div id="header">
    <div id="OverviewText1"> 
      <img src="http://www.lis.ucr.ac.cr/_vista/imagenes/logoUcr.png" />
    </div>
    <div id="OverviewText2"> 
      <img src="https://www.ecci.ucr.ac.cr/sites/all/themes/ecci_bootstrap/logo.png" />
    </div>
    <div id="OverviewText3"> 
      <img src="https://cdn.onlinewebfonts.com/svg/img_264570.png" />
    </div>
			<ul class="nav">
        <li>
          <?= $this->Html->link('Inicio',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
        </li>
				<li><?= $this->Html->link('Solicitudes',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
					<ul>
						<li><?= $this->Html->link('Sub',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?></li>
					</ul>
				</li>
				<li><?= $this->Html->link('Curso-grupo',['controller'=>'CoursesClassesVw','action'=>'index'],['class'=>'nav-link']) ?>
					<ul>
						<li><?= $this->Html->link('Sub',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
					</ul>
				</li>
				<li><?= $this->Html->link('Requisitos',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
          <ul>
						<li><?= $this->Html->link('Sub',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
					</ul>
        </li>
        <li><?= $this->Html->link('Ronda',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
          <ul>
						<li><?= $this->Html->link('Sub',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
					</ul>
        </li>
        <li><?= $this->Html->link('Usuarios',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
          <ul>
						<li><?= $this->Html->link('Sub',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
					</ul>
        </li>
        <li><?= $this->Html->link('Roles',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
          <ul>
						<li><?= $this->Html->link('Sub',['controller'=>'Enrollments','action'=>'index'],['class'=>'nav-link']) ?>
					</ul>
        </li>
			</ul>
		</div>
  <h2 class="text2 backg2"><font size="6">Texto de ejemplo</font></h2>
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
