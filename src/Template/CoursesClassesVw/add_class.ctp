<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $class
 */
?>
<div class="classes form large-9 medium-8 columns content form-size">
    <?= $this->Form->create($coursesClassesVw) ?>
    <fieldset>
        <h3><?= __('Agregar grupo') ?></h3>

        <div class="form-section">
            <div class="form-group text">
                <label class="control-label" for="Curso"> Nombre del curso </label>
                <?= $this->Form->select('Curso',$acr) ?>
            </div>
            <?php
                echo $this->Form->control('Grupo',['label'=>['text'=>'Numero de grupo'],'type'=>'number','max' => 20, 'min' => 1,'required']);
                echo $this->Form->control('Semestre', ['label'=>['text'=>'Ciclo'],'type' => 'number','max' => 2, 'min' => 1,'required', 'value' => $roundData['semester']=='I'?1:2]);
                echo $this->Form->control('Año', ['label'=>['text'=>'Año'],'type' => 'number','max' => 9999, 'min' => 1900,'required','value' => $roundData['year']]);
                //echo $this->Form->control('state');
                echo $this->Form->control('Profesor', ['options' => $professors, 'empty' => true]);
            ?>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-primary btn-aceptar">Aceptar</button>
    <?= $this->Html->link(
        'Cancelar',
        ['controller'=>'CoursesClassesVw','action'=>'index'],
        ['class'=>'btn btn-secondary btn-cancelar btn-space']
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
