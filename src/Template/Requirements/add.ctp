<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
?>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<div class="container">
<div class="requirements form col-lg-8 col-offset-4 centered">
    <?= $this->Form->create($requirement) ?>
    <fieldset>
        <legend><?= __('Agregar requisito') ?></legend>
        <?php
            echo $this->Form->input('description',['label' => 'Descripción del requisito', 'class' => 'form-control']);
            echo $this->Form->label('Tipo del requisito');
            echo '<br>';
            echo $this->Form->radio(
                'type',
                [
                    ['value' => 'Obligatorio', 'text' => '<span style="padding:0 10px 0 10px;">Obligatorio</span>'],
                    
                    ['value' => 'Opcional', 'text' => '<span style="padding:0 10px 0 10px;">Opcional</span>'],
                ],
                [ 
                    'div' => false, 
                    'class' => 'col-md-15', 
                    'escape' => false,
                ]
            );
        ?>
        <br> <br>
        <br> <br>
        <button type="submit" class="btn btn-primary" style='position:absolute; left: 86.3%; top: 77.8%;'>
            Agregar
        </button>
        <button type="buttom">
            <?= $this->Html->link('Cancelar',['controller'=>'Requirements','action'=>'index'],['class'=>'btn', 'style'=>'position:absolute; left: 1.5%; top: 77.8%;']) ?>
        </button>
    </fieldset>
</div>
</div>

<?= $this->Form->end() ?>
</div>