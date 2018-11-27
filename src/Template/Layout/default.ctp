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
$cakeDescription = 'Asistencias ECCI';
?>
<!DOCTYPE html>
<html>
<head>
    <?=$this->Html->charset()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$cakeDescription?>:
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>

    <!-- Espacio donde se cargan los archivos pertinentes a bootstrap -->
    <?=$this->Html->css(['bootstrap.min', 'jquery.dataTables.min'])?>
      <!-- <link rel="stylesheet" href="plugins/font/typicons.min.css"/></head><body><div class="page-header">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"> -->
    <?=$this->Html->script(['jquery-3.3.1.min', 'bootstrap.min', 'jquery.dataTables.min'])?>

    <?=$this->fetch('meta')?>
    <?=$this->fetch('css')?>
    <?=$this->fetch('script')?>

    <?php
echo $this->Html->css('buttons');
echo $this->Html->css('forms');
echo $this->Html->css('titles');
echo $this->Html->css('grid-index');
?>


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
    <?=$this->element('titlebar')?>
    <div style='position: sticky; position: -webkit-sticky; top:0;z-index:10' class="shadow"> 
        <?=$this->element('menubar')?>

        <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark justify-content-center bg-ecci-green">
          <span class="navbar-text"><?php if (isset($title)) {echo h($title);} else {echo " ";}?></span>
        </nav>
    </div>
    <?=$this->Flash->render()?>

    <div class="container my-5">
      <?=$this->fetch('content')?>
    </div>

    <footer>
    </footer>

</body>
</html>