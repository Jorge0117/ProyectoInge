<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CoursesClassesVw $coursesClassesVw
 */
?>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<div class="coursesClassesVw form large-9 medium-8 columns content">
    <?= $this->Form->create($coursesClassesVw) ?>
    <fieldset>
        <legend><?= __('Add Course') ?></legend>

        <table>
        <thead>
            <tr>
            <th><?php echo implode('</th><th>', array_keys(current($table))); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $row): array_map('htmlentities', $row); ?>
            <tr>
            <td><?php echo implode('</td><td>', $row); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>

    </fieldset>
    <?= $this->Form->button(__('Aceptar'), ['class'=>'btn-aceptar']) ?>
    <?= $this->Form->end() ?>
</div>

<style>
.btn-aceptar{
    background-color: #ceb92bff;
    color: #ffffff;
    border: none;
    text-align: center;
}
</style>