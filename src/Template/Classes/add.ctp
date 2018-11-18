<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $class
 */
?>
<div class="classes form large-9 medium-8 columns content">
    <?= $this->Form->create($class) ?>
    <fieldset>
        <h3><?= __('Agregar grupo') ?></h3>

        <div class="form-section">
            <div class="form-group text">
                <label class="control-label" for="course_id"> Nombre del curso </label>
                <?= $this->Form->select('course_id',$courses) ?>
            </div>
            <?php
                echo $this->Form->control('class_number',['label'=>['text'=>'Numero de clase'],'type'=>'text']);
                echo $this->Form->control('semester', ['label'=>['text'=>'Semestre'],'type'=>'text']);
                echo $this->Form->control('year', ['label'=>['text'=>'Año'],'type'=>'text']);
                //echo $this->Form->control('state');
                echo $this->Form->control('professor_id', ['options' => $professors, 'empty' => true]);
            ?>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-primary float-right">Aceptar</button>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary float-right btn-space']
    )?>
    <?= $this->Form->end() ?>
</div>


<style>
    .btn-space {
        margin-right: 3px;
        margin-leftt: 3px;
    }

    .form-size{
        width: 70%;
        min-width: 200px;
        padding-left: 50px;
    }
    .form-section{
        background-color: #e4e4e4;
        padding: 2%;
        margin: 2%;
    }
</style>
