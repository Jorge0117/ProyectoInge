<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Course $course
 */
?>

<div class="courses form large-9 medium-8 columns content">
    <?= $this->Form->create($course) ?>
    <fieldset>
        <legend><?= __('Añadir grupo') ?></legend>
        <?php
            echo $this->Form->control('Sigla');
            echo $this->Form->control('Curso');
            echo $this->Form->control('Creditos');
            echo $this->Form->control('Grupo');
            echo $this->Form->control('Profesor');
            echo $this->Form->control('Semestre');
            echo $this->Form->control('Año');
        ?>
    </fieldset>

    <?= $this->Form->end() ?>
</div>
