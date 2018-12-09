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
        <legend><?= __('Vista previa del archivo') ?></legend>

        <table>
        <thead>
            <tr>
            <th><?php echo implode('</th><th>', array_keys(current($table))); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php 
            foreach ($table as $row): array_map('htmlentities', $row); 
            if($row['Curso'] != null):
        ?>
            <tr>
            <td><?php echo implode('</td><td>', $row); ?></td>
            </tr>
        <?php 
            endif;
            endforeach; 
        ?>
        </tbody>
        </table>

    </fieldset>
    <button type="submit" class="btn btn-primary float-right">Aceptar</button>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'cancelExcel'],
        ['class'=>'btn btn-secondary float-right btn-space']
    )?>
    <?= $this->Form->end() ?>
</div>


<style>
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }
</style>