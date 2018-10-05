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
        <?php
            echo $this->Form->input('description',['label' => 'Descripción del requisito', 'class' => 'form-control']);
            echo $this->Form->label('Tipo del requisito');
            echo $this->Form->radio('type',['R' => ' Obligatorio ', 'B' => ' Opcional ']);
        ?>      
    </fieldset>
    <div>
</div>
    <?= $this->Form->button(__('Agregar')) ?>
    <?= $this->Form->end() ?>
</div>
