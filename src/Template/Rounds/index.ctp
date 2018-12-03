<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>

<link rel = 'stylesheet' href = 'https://cdn.dhtmlx.com/edge/dhtmlx.css' type = 'text/css'> 
<script src = 'https://cdn.dhtmlx.com/edge/dhtmlx.js' type = 'text/javascript'></script>

<?php // Inicializando variables 
    $startDate = $endDate = null;
    $roundNumber = 1;
    $semester = $year = null;
    $totalStudentHours = $totalDHours = $totalAssistantHours = null;
    $actualStudentHours = $actualDHours = $actualAssistantHours = null;
    if($roundData!=null){
        $penultimateRound = $this->Rounds->getPenultimateRow();
        $startDate = $this->Rounds->YmdtodmY($roundData['start_date']);
        $endDate = $this->Rounds->YmdtodmY($roundData['end_date']);
        $roundNumber = $roundData['round_number'];
        $semester = $roundData['semester'];
        $year = $roundData['year'];
        $totalStudentHours = $roundData['total_student_hours'];
        $totalDHours = $roundData['total_student_hours_d'];
        $totalAssistantHours = $roundData['total_assistant_hours'];
        $actualStudentHours = $roundData['actual_student_hours'];
        $actualDHours = $roundData['actual_student_hours_d'];
        $actualAssistantHours = $roundData['actual_assistant_hours'];
    }
?>
<div class = container >

    <!-- Título -->    
    <div class = 'row justify-content-center' id = 'Title'>
        <h3 id ='title' > Gestión de Rondas </h3>
    </div>
    <!-- Botones de acción -->
    <div class = 'row justify-content-end' id = 'ActionTopButtons'>

        <!-- Botón Iniciar nueva ronda, comienza agregado de una nueva ronda -->
        <?= $this->Form->button('Iniciar Nueva Ronda',[
            'onclick'   =>  'start(1)',
            'type'      =>  'button',
            'id'        =>  'add',
            'class'     =>  'btn btn-primary btn-agregar-index btn-space',
            'style'     =>  'margin-right: 3px; margin-leftt: 3px;']); ?>

        <!-- Botón Editar ronda, comienza edición de los datos de la ronda actual -->
        <?=  $this->Form->button('Editar Ronda',[
            'onclick'   =>  'start(2)',
            'type'      =>  'button',
            'id'        =>  'edit',
            'class'     =>  'btn btn-primary btn-agregar-index btn-space',
            'style'     =>  'margin-right: 3px; margin-leftt: 3px;']); ?>

        <!-- Botón Borrar ronda, muestra cuadro de dialogo para confirmar la acción de borrar la ronda actual -->
        <?=  $this->Form->postbutton('Borrar Ronda',[
            'action'    =>  'delete', $roundData['start_date']],[
            'id'        =>  'delete',
            'class'     =>  'btn btn-primary btn-agregar-index btn-space',
            'style'     =>  'margin-right: 3px; margin-leftt: 3px;',
            'confirm'   =>  __(
                '¿Está seguro de que desea borrar la ronda de solicitudes '.
                '#{0} del {1} ciclo {2}?', $roundNumber, $semester,$year
            )]); ?>   
    </div>

    <!-- Sección con datos de las fechas de la ronda actual -->
    <div class='form-section' id = 'datesDiv' style = 'margin-top:10px; margin-bottom:30px'>
        <?php if($roundData): ?>
            <legend id = 'subSection1'> Periodo de la ronda #<?= $roundNumber ?> del <?= $semester ?> ciclo <?= $year ?> </legend>
        <?php else: ?>
            <legend id = 'subSection1'> Periodo de la ronda #1 </legend>
        <?php endif; ?>
        <?= $this->Form->create($round ,['id'=>'mainRoundsIndexform', 'class' => 'row']) ?>
            <div class = col-auto id = 'startDateHeader'>Fecha de Inicio:</div> 
            <div class = 'col-3' id = 'startDateData' >

                <!-- Campo start_date, contiene el valor de la fecha inicial de la ronda -->
                <?= $this->Form->control('start_date',[
                    'type'      =>  'calendar',
                    'value'     =>  $startDate,
                    'label'     =>  false,
                    'readonly'  =>  true,
                    'onfocus'   =>  'sensitiveStart()',
                    'onfocusout'=>  'readOnlyFalse(1)',
                    'style'     =>  'text-align:center']); ?>
            </div>
            <div class = col-auto id = 'endDateHeader'>Fecha Final:</div>
            <div class = 'col-3' id = 'endDateData' >

                <!-- Campo end_date, contiene el valor de la fecha final de la ronda -->
                <?= $this->Form->control('end_date',[
                    'type'      =>  'calendar',
                    'value'     =>  $endDate,
                    'label'     =>  false,
                    'readonly'  =>  true,
                    'onfocus'   =>  'sensitiveEnd()',
                    'onfocusout'=>  'readOnlyFalse(0)',
                    'style'     =>  'text-align:center']); ?>
            </div>

            <!-- Campo flag, indica la operación realizada: {1:add, 2:edit}. -->
            <?= $this->Form->control('flag',[
                    'type' => 'hidden',
                    'value' => 0]); ?>
            <?php 
                // Se colocan estos 'form control' para no saltarse validaciones.
                $this->Form->control('total_student_hours');
                $this->Form->control('total_student_hours_d');
                $this->Form->control('total_assistant_hours');
                // Desbloquea campos que no necesitan validación.
                $this->Form->unlockField('flag');
            ?>
        <?= $this->Form->end(); ?>
    </div>

    <!-- Sección con datos de las horas totales de la ronda actual -->
    <div class='form-section' id = 'HoursDiv' style = 'margin-top:30px; margin-bottom:10px'>
        <legend id = 'subSection2'>Total de horas asignadas</legend>
        <div class = 'row justify-content-center' >
            <div class = 'col'   id = 'totalStudentHours'>
                <!-- Campo total_student_hours, contiene el valor del total de horas estudiante de la ECCI. -->
                <?= $this->Form->control('total_student_hours',[
                    'type'      =>  'number',
                    'value'     =>  $totalStudentHours,
                    'min'       =>  $actualStudentHours,
                    'readonly'  =>  true,
                    'label'     =>  'Total Horas Estudiante ECCI:',
                    'form'      => 'mainRoundsIndexform',
                    'style'     =>  'text-align:center',
                    'required']); ?>
            </div>
            <div class = 'col' id = 'totalDHours'>
                <!-- Campo total_student_hours_d, contiene el valor del total de horas estudiante de docencia. -->
                <?= $this->Form->control('total_student_hours_d',[
                    'type'      =>  'number',
                    'value'     =>  $totalDHours,
                    'min'       =>  $actualDHours,
                    'readonly'  =>  true,
                    'label'     =>  'Total Horas Estudiante DOC:',
                    'form'      => 'mainRoundsIndexform',
                    'style'     =>  'text-align:center',
                    'required']); ?>
            </div>
            <div class = 'col' id = 'totalAssistantHours'>
                <!-- Campo total_assistant_hours, contiene el valor del total de horas asistente de la ECCI. -->
                <?= $this->Form->control('total_assistant_hours',[
                    'type'      =>  'number',
                    'value'     =>  $totalAssistantHours,
                    'min'       =>  $actualAssistantHours,
                    'readonly'  =>  true,
                    'label'     =>  'Total Horas Asistente ECCI:',
                    'form'      => 'mainRoundsIndexform',
                    'style'     =>  'text-align:center',
                    'required']); ?>
            </div>
        </div>
    </div>

    <!-- Botones del formulario -->
    <div class = 'submit'>

        <!-- Botón Aceptar, envia datos del form -->
        <?= $this->Form->postbutton('Aceptar',[
            'action'    =>  'index'],[
            'id'        =>  'aceptar',
            'type'      =>  'submit',
            'form'      =>  'mainRoundsIndexform',
            'class'     =>  'btn btn-primary btn-aceptar',
            'style'     =>  'display:none;margin-right:3px;margin-left:3px;
            ']) ?>

        <!-- Botón Cancelar, resetea la página de rondas al estado inicial de haber entrado -->
        <?= $this->Form->button('Cancelar',[
            'onclick'   =>  'cancel()',
            'id'        =>  'cancelar',
            'class'     =>  'btn btn-secondary btn-cancelar',
            'style'     =>  'display:none;']) ?>    
    </div>
</div>


<?= $this->Html->script('Generic'); ?>
<?= $this->Html->script('DateOps'); ?>

<script>
    /** 
     * @author Daniel Marín <110100010111h@gmail.com>
     * 
     * Obtiene todos los datos de la ronda actual y los almacena en una variable js.
     */
    (function() {
        <?php if($roundData != null): ?>
            resultArray = <?= json_encode($roundData) ?>;
            resultArray['start_date'] = YmdtodmY(resultArray['start_date']);
            resultArray['end_date'] = YmdtodmY(resultArray['end_date']);
            roundData = resultArray;
            penultimateRoundData = <?= json_encode($penultimateRound) ?>;
        <?php else: ?> 
            roundData = null;
        <?php endif; ?> 
    })();
</script>
<?=  $this->Html->script('Rounds'); ?>