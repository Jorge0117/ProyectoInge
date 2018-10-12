<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $class
 */
?>
<div class="classes form large-9 medium-8 columns content">
    <?= $this->Form->create($class) ?>
    <fieldset>
        <legend><?= __('Add Class') ?></legend>
        <div class="form-group text">
            <label class="control-label" for="course_id"> Nombre del cursos </label>
            <?= $this->Form->select('course_id',$courses) ?>
        </div>
        <?php
            echo $this->Form->control('class_number',['label'=>['text'=>'Numero de clase'],'type'=>'text']);
            echo $this->Form->control('semester', ['label'=>['text'=>'Semestre'],'type'=>'text']);
            echo $this->Form->control('year', ['label'=>['text'=>'Año'],'type'=>'text']);
            //echo $this->Form->control('state');
            echo $this->Form->control('professor_id', ['options' => $professors, 'empty' => true]);
        ?>
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

</style>
