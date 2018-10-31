<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://cdn.dhtmlx.com/edge/dhtmlx.css" type="text/css"> 
<script src="http://cdn.dhtmlx.com/edge/dhtmlx.js" type="text/javascript"></script>

<script>
    // configuración para un nuevo lenguaje del calendario (Español)
dhtmlXCalendarObject.prototype.langData["es"] = {
    dateformat: "%d.%m.%Y",
    hdrformat: "%F %Y",
    monthesFNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                    "Julio","Agosto","Septiembre","Octubre","Nobiembre","Diciembre"],
    monthesSNames: ["Ene","Feb","Mar","Abr","May","Jun",
                    "Jul","Ago","Sep","Oct","Nov","Dic"],
    daysFNames: ["Domingo","Lunes","Martes","Miercoles","Jueves",
                    "Viernes","Sábado"],
    daysSNames: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
    weekstart: 1,
    weekname: "Sem",
    today: "Hoy",
    clear: "Borrar"
};
dhtmlXCalendarObject.prototype.lang = "es";
</script>

<style>
.btn-x{
    background-color: white;
    border: none;
    color: #007bff;
    padding: 0px 0px;
}

/* Darker color on mouse-over */
.btn-x:hover {
    color: #0056B3;
}
.btn-x:focus{outline:none !important}
</style>

<!--Variables utilizadas para el primer display-->
<?php $last = $this->Rounds->getLastRow()?>
<?php $s_date = $last[0]?>
<?php if($s_date==null){
    $s_date = $this->Rounds->getToday();
}?>
<?php $e_date = $last[4] ?>
<?php if($e_date==null){
    $e_date = $this->Rounds->getToday();
}?>


<div class="rounds index large-9 medium-8 columns content">
    <h3><?= __('Rondas') ?></h3>
    <div class="rounds form large-9 medium-8 columns content">
<table>
    <thead>
        <tr>
            <?php if($last != null){ ?>
                <th scope="col">Ronda</th>
            <?php } ?>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php if($last != null){ ?>
                <td scope="row"> <?=$last[1]?></td>
            <?php } ?>
            <form name="form" action="" method="post">
            <td><div class = "form-group text"><input name="start_date" type="calendar" value =<?=$s_date?> id="start_date" class="form-control"/></div></td>
            <td><div class = "form-group text"><input name="end_date" type="calendar" value = <?=$e_date?> id="end_date" class="form-control" /></div></td>
            </form>
            <?php  debug($_POST); ?>
            <td>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <!-- Botones de accion -->
                        <td><?= $this->Form->button(
                            '<i class="fa fa-pencil"></i>',
                            ['onclick' => "startEdit()",
                            'class' => 'btn-x',
                            'type'=>'button'])?></td>
                        <?php if($last[0] != null){ ?>
                        <td><?= $this->Form->postbutton(
                            '<i class="fa fa-trash-o"></i>',
                            ['action' => 'delete', $s_date],
                            ['class'=>'btn-x',
                            'confirm' => __('¿Está seguro de que ' .
                                            'desea borrar la ronda ' . 
                                            'de solicitudes #{0} del ' .
                                            '{1} ciclo {2}?', $last[1],
                                            $last[2],$last[3])]) ?></td>
                        <?php } ?>
                        <td><?= $this->Form->button(
                            '<i class="fa fa-plus-circle"></i>', 
                            ['onclick' => "startAdd()",
                             'class' => 'btn-x',
                             'type'=>'button']) ?></td>
                    </tr>
                </table>
            </td>         
        </tr>          
    </tbody>
</table>
<!--Botones para enviar datos-->
<div class="submit">
    <?= $this->Form->button('Cancelar', ['onclick' => "disable()",'id'=>'cancelar', 'class' => 'btn btn-secondary float-leftz','style' => "display :none"]) ?>
    <?= $this->Form->button('Aceptar', [['action'=>'edit',$s_date,],'onclick' => "disable()",'id'=>'aceptar1','type' => 'submit', 'class' => 'btn btn-primary float-right','style' => "display:none"]) ?>
    <?= $this->Form->button('Aceptar', ['action'=>'add','onclick' => "disable()",'id'=>'aceptar2','type' => 'submit', 'class' => 'btn btn-primary float-right','style' => "display:none"]) ?>
    <?= $this->Form->end() ?>
</div>
</div>
</div>



<script>
// Muestra, esconde y deshabilita los botones y campos requeridos 
function startEdit(){
    document.getElementById("start_date").disabled = false;
    document.getElementById("end_date").disabled = false;
    document.getElementById("cancelar").style.display = "inline";
    document.getElementById("aceptar2").style.display = "none";
    document.getElementById("aceptar1").style.display = "inline";
}
// Muestra, esconde y deshabilita los botones y campos requeridos 
function startAdd(){
    document.getElementById("start_date").disabled = false;
    document.getElementById("end_date").disabled = false;
    document.getElementById("cancelar").style.display = "inline";
    document.getElementById("aceptar1").style.display = "none";
    document.getElementById("aceptar2").style.display = "inline";
}

// esconde y deshabilita los botones y campos requeridos 
function disable() {

document.getElementById("start_date").disabled = true;
document.getElementById("end_date").disabled = true;
document.getElementById("cancelar").style.display = "none";
document.getElementById("aceptar1").style.display = "none";
document.getElementById("aceptar2").style.display = "none";

}
// Calendario
var calendar1 = new dhtmlXCalendarObject(["start_date","end_date"]);
calendar1.hideTime();
calendar1.setDateFormat("%d-%m-%Y");
</script>