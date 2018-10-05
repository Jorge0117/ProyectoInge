<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
?>
<div class="requirements form large-9 medium-8 columns content">
    <?= $this->Form->create($requirement) ?>
    <fieldset>
        <legend><?= __('Agregar requisito') ?></legend>
        <style>
            .submit{
                background-color: #ceb92bff;
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
        <button type="submit" class="submit"><?= $this->Html->link('Agregar',['controller'=>'Requirements','action'=>'index'],['class'=>'nav-link']) ?></button>
        <br>
        <?php
            echo $this->Form->input('description',['label' => 'Descripción del requisito', 'class' => 'form-control']);
            echo $this->Form->label('Tipo del requisito');
            echo $this->Form->radio( 'type' , ['Obligatorio' => 'Obligatorio','Opcional' => 'Opcional']);
        ?>      
    </fieldset>
    <div>
</div>
    <?= $this->Form->button(__('Agregar')) ?>
    <?= $this->Form->end() ?>
</div>
