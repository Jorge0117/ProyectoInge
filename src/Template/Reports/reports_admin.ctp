<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>

<h3>Generador de reportes</h3>
<div class="form-size users form large-9 medium-8 columns content">
    <?= $this->Form->create('newform', ['novalidate']) ?>
    <fieldset>
        <div class="form-section">
            <?php
                echo $this->Form->control('report_type',['type'=>'select', 'label' => 'Tipo de Reporte', 'options' => ['Elegibles aceptados','Elegibles rechazados','No elegibles', 'Resultados']]);
				echo $this->Form->control('year',['label' => 'Año', 'type'=>'text']);
				echo $this->Form->control('semester',['type'=>'select', 'label' => 'Ciclo', 'options' => ['I','II']]);
				echo $this->Form->control('round',['type'=>'select', 'label' => 'Ronda', 'options' => ['1','2', '3']]);
            ?>
        </div>
        
              
    </fieldset>
    <div class="submit">
        <?php echo $this->Form->submit(__('Ver reporte'), ['class'=>'btn btn-primary btn-aceptar'], array('name' => 'ok', 'div' => FALSE)); ?>
        <?php echo $this->Html->link(__('Cancelar'), $this->request->referer(), ['class'=>'btn btn-secondary btn-cancelar']); ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>