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


<style type="text/css">
    .btn-aceptar{
        background-color: #ceb92bff;
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
    }

    h3{
        float: center;
        display: block;
        width: 100%;
        line-height:1.5em;
    }
    
    .form-size{
        width: 70%;
        min-width: 200px;
        padding-left: 50px;
    }

    .btn-cancelar{
        background-color: #999999;
        color: #ffffff;
        border: none;
        text-align: center;
        float: right;
        margin-right: 5px;
    }
