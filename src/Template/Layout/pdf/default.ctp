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
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon', ['fullBase' => true])    ?>

    <!-- Espacio donde se cargan los archivos pertinentes a bootstrap -->
    <?= $this->Html->css(['bootstrap.min','jquery.dataTables.min'], ['fullBase' => true])?>


    <?php
    echo $this->Html->css('buttons', ['fullBase' => true]);
    echo $this->Html->css('forms', ['fullBase' => true]);
    echo $this->Html->css('titles', ['fullBase' => true]);
    echo $this->Html->css('grid-index', ['fullBase' => true]);
    ?>

    <!-- <link type="text/css" href="webroot/css/bootstrap.min.css" rel="stylesheet" /> -->
    <!-- <link type="text/css" href="webroot/css/jquery.dataTables.min.css" rel="stylesheet" /> -->

</head>

<body>
    <!-- <div class="container pt-5"> -->
      <?= $this->fetch('content') ?>
    <!-- </div> -->
</body>
</html>