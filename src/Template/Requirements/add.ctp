<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Requirements'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fulfills Requirement'), ['controller' => 'FulfillsRequirement', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fulfills Requirement'), ['controller' => 'FulfillsRequirement', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="requirements form large-9 medium-8 columns content">
    <?= $this->Form->create($requirement) ?>
    <fieldset>
        <legend><?= __('Add Requirement') ?></legend>
        <?php
            echo $this->Form->control('description');
            echo $this->Form->control('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
