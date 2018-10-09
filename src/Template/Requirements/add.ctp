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

<style>
    .btn-acept{
        background-color: #015b96ff;
        border: none;
        color:#fff;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        float: right;
    }
    .btn-acept:hover{
        color: #fff;
    }
    .btn-revoke{
        background-color: #999999;
        border: none;
        color:#fff;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        float: right; 
        position:absolute; 
        left: 1.5%;
        top: 77.8%;
    }
    .btn-revoke:hover{
        color: #fff;
    }
    .btn-acept{
        background-color: #015b96ff;
        border: none;
        color:#fff;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        float: right;
    }
</style>

<div class="container">
<div class="requirements form col-lg-8 col-offset-4 centered">
    <?= $this->Form->create($requirement) ?>
    <fieldset>
        <legend><?= __('Agregar requisito') ?></legend>
        <?php
            echo $this->Form->input('description',['label' => 'Descripción del requisito', 'class' => 'form-control']);
            echo $this->Form->label('Tipo del requisito');
            echo '<br>';
            echo $this->Form->radio( 'type' , ['Obligatorio' => 'Obligatorio','Opcional' => 'Opcional']);
        ?>      
        <br> <br>
        <button type="submit" class="btn btn-acept">
            Agregar
        </button>
        <button type="buttom">
            <?= $this->Html->link('Cancelar',['controller'=>'Requirements','action'=>'index'],['class'=>'btn btn-revoke']) ?>
        </button>
    </fieldset>
</div>
</div>

<div class="modal fade sucess" id="sucess">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header" style="padding:10px 15px;">
                 <h4 class="modal-title" style="margin:0 auto;">Requisitos</h4>
            </div>

            <div class="modal-body" style="padding:40px 50px; margin:0 auto;">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <p>Se agrego el requisito correctamente.</p>
            </div>

            <div class="modal-footer"  style="padding:40px 50px; margin:0 auto;">
                <button type="button" class="btn btn" style="background-color:#015b96ff; border:none; color:#fff; padding:5px 10px;">
                    <?= $this->Html->link('Aceptar',['controller'=>'Requirements','action'=>'index'],['class'=>'btn btn-acept']) ?>
                </button>
            </div>
        </div>      
    </div>
</div>  

<?= $this->Form->end() ?>
</div>