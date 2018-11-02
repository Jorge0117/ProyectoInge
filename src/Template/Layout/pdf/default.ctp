<?php
/**
 * Layout for pdf files
 */
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

    <?php
    echo $this->Html->css('buttons');
    echo $this->Html->css('forms');
    echo $this->Html->css('titles');
    echo $this->Html->css('grid-index');
    ?>
</head>

<body>
    <!-- <div class="container pt-5"> -->
      <?= $this->fetch('content') ?>
    <!-- </div> -->
</body>
</html>