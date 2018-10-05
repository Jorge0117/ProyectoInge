<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round $round
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Rounds'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="rounds form large-9 medium-8 columns content">
    <?= $this->Form->create($round) ?>
    <fieldset>
        <legend><?= __('Add Round') ?></legend>
        <?php
            echo $this->Form->control('start_date');
            echo $this->Form->control('end_date');
            echo $this->Form->control('approve_limit_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
