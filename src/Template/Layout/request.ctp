<?php
/**
 * Layout para la pagina de impresión del formulario de solicitud de asistencias.
 * 
 * Incluye un encabezado con los logos de la UCR y la ECCI,
 * y un pie de página con información de contacto de la
 * escuela, el sello de acreditación del SINAES y el
 * conmemorativo de 35 años de la escuela.
 */
$cakeDescription = 'Formulario de Solicitud de Asistencias';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Solicitud de concurso a asistencia 
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

    <?php
      echo $this->Html->css('buttons');
      echo $this->Html->css('forms');
      echo $this->Html->css('titles');
      echo $this->Html->css('grid-index');
    ?>
    <style>
        /*
        body {
            background: white;
            font-size: 12pt;
        }

        footer {
            position: absolute;
            bottom: -55;
            width: 100%;
        }
        */
    </style>

</head>
<body>
    <header class='header'>
        <div class='container border-bottom border-dark pb-1'>
            <div class='row justify-content-between'>
                <div class='col' align='left'>
                    <?= $this->Html->image('ucr_escudo.png', ['style' => 'height:75px'])?>
                </div>
                <div class='col' align='right'>
                    <?= $this->Html->image('logoEcci.png', ['style' => 'height:60px'])?>
                </div>
            </div>
        </div>
    </header>


    <main>
        <?= $this->fetch('content') ?>
    </main>

    <footer class='footer'>
        <div class='container border-top border-dark pt-2'>
            <div class='row justify-content-between'>
                <div class='col' align='left'>
                    <h6>Teléfono: (506) 2511-8000</h6>
                    <h6>Fax: (506) 2511-5527</h6>
                    <h6>http://www.ecci.ucr.ac.cr</h6>
                </div>
                <div class='col' align='center'>
                    <?= $this->Html->image('sinaes.png', ['style' => 'height:100px'])?>
                </div>
                <div class='col' align='right'>
                    <?= $this->Html->image('ecci35.jpg', ['style' => 'height:100px'])?>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>