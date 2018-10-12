<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>

<link rel="stylesheet" href="http://cdn.dhtmlx.com/edge/dhtmlx.css" 
    type="text/css"> 
<script src="http://cdn.dhtmlx.com/edge/dhtmlx.js" 
    type="text/javascript"></script>

<script>
    // settings for a new language (Español)
// make sure dhtmlxcalendar.js will be loaded
dhtmlXCalendarObject.prototype.langData["es"] = {
    // date format for inputs
    dateformat: "%d.%m.%Y",
    // header format
    hdrformat: "%F %Y",
    // full names of months
    monthesFNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                    "Julio","Agosto","Septiembre","Octubre","Nobiembre","Diciembre"],
    // short names of months
    monthesSNames: ["Ene","Feb","Mar","Abr","May","Jun",
                    "Jul","Ago","Sep","Oct","Nov","Dic"],
    // full names of days
    daysFNames: ["Domingo","Lunes","Martes","Miercoles","Jueves",
                    "Viernes","Sábado"],
    // short names of days
    daysSNames: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
    // starting day of a week. Number from 1(Monday) to 7(Sunday)
    weekstart: 1,
    // the title of the week number column
    weekname: "Sem",
    // name of the "Today" button
    today: "Hoy",
    // name of the "Clear" button
    clear: "Borrar"
};
dhtmlXCalendarObject.prototype.lang = "es";
</script>



<div class="rounds index large-9 medium-8 columns content">
    <h3><?= __('Rondas') ?></h3>
    <div class="rounds form large-9 medium-8 columns content">
<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>Ronda</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th >Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php $s_date = $this->Rounds->getLastRow()[0]; ?>

            <?php if($s_date==null){$s_date = " ";}?>
            <?php $e_date =  $this->Rounds->getLastRow()[4]; ?>
            <td><?=$this->Rounds->getLastRow()[1]?></td>
            <td><input name="Inicio" type="calendar" value =<?=$s_date?> id="start_date"/></td>
            <td><input name="Fin" type="calendar" value = <?=$e_date?> id="end_date"/></td>
            <td>
                <?= $this->Html->link(__('Editar'), ['onclick' => "enable()"]) ?>
                <?= $this->Form->postLink(__('Borrar'), ['action' => 'delete', $s_date], ['confirm' => __('¿Está seguro de que desea borrar la ronda de solicitudes #{0} del {1} ciclo {2}??', $this->Rounds->getLastRow()[1],$this->Rounds->getLastRow()[2],$this->Rounds->getLastRow()[3])]) ?>
                <?= $this->Html->link(__('Agregar'), [$s_date, 'onclick' => "enable()"]) ?>
            </td>
        </tr>
    </tbody>
</table>


<script>
function disable() {
document.getElementById("start_date").disabled = true;
document.getElementById("end_date").disabled = true;
}
function enable() {
    document.getElementById("start_date").disabled = false;
document.getElementById("end_date").disabled = false;
}
</script>

<script>
var calendar1 = new dhtmlXCalendarObject(["start_date","end_date"]);
calendar1.hideTime();
calendar1.setDateFormat("%d-%m-%Y");
</script>