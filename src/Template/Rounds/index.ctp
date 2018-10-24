<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.dhtmlx.com/edge/dhtmlx.css" type="text/css"> 
<script src="https://cdn.dhtmlx.com/edge/dhtmlx.js" type="text/javascript"></script>

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
<?php $s_date = $last[0];?>
<?php if($s_date==null){
    $s_date = $this->Rounds->getToday();
}?>
<?php $e_date = $last[4];?>
<?php if($e_date==null){
    $e_date = $this->Rounds->getToday();
}?>
<div class="rounds index large-9 medium-8 columns content">
    <h3><?= __('Rondas') ?></h3>
    <table class="table">
        <thead>
            <tr>
                <?php if($last != null){ ?>
                <th scope="col" id='num'><?= '#' ?></th>
                <?php } ?>
                <th scope="col"><?= 'Fecha Inicio' ?></th>    
                <th scope="col"><?= 'Fecha Fin' ?></th>
                <th scope="col" colspan=4></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
                <div class="rounds form large-9 medium-8 columns content">
                    <?php if($last != null){ ?>
                    <td id= 'numData'><?= $last[1] ?></td>
                    <?php } ?>
                    <?= $this->Form->create($round,['novalidate']) ?>
                    <fieldset>
                        <td><?= $this->Form->control('start_date',[
                                                     'type'=>'calendar',
                                                     'value'=>$s_date,
                                                     'label' => false,
                                                     'readonly'=>true,
                                                     'disabled',
                                                     'onclick'=>"sensitiveRange('max')"]);?></td>
                        <td><?= $this->Form->control('end_date',[
                                                     'type'=>'calendar',
                                                     'value'=>$e_date,
                                                     'label' => false,
                                                     'readonly'=>true,
                                                     'disabled',
                                                     'onclick'=>"sensitiveRange('min')"]);?></td>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>   
                    <!-- Botones de accion -->
                        <?php if($last != null){ ?>
                        <td><?= $this->Form->button(
                            '<i class="fa fa-pencil"></i>',[
                            'onclick' => "startEdit()",
                            'class' => 'btn-x',
                            'type'=>'button',
                            'id'=>'edit'])?></td>
                        <?php } ?>
                        <?php if($last[0] != null){ ?>
                        <td><?= $this->Form->postbutton(
                            '<i class="fa fa-trash-o"></i>',
                            ['action' => 'delete', $s_date],[
                            'class'=>'btn-x',
                            'id' => 'trash',
                            'confirm' => __('¿Está seguro de que ' .
                                            'desea borrar la ronda ' . 
                                            'de solicitudes #{0} del ' .
                                            '{1} ciclo {2}?', $last[1],
                                            $last[2],$last[3])]) ?></td>
                        <?php } ?>
                        <td><?= $this->Form->button(
                            '<i class="fa fa-calendar-plus-o"></i>', 
                            ['onclick' => "startAdd()",
                             'class' => 'btn-x',
                             'id' => 'caladd',
                             'type'=>'button']) ?></td>
                    
                </div>
                
            </tr>
        </tbody>
    </table>

</div>
<div class="submit">
    <?= $this->Form->button('Cancelar', ['onclick' => "disable()",'id'=>'cancelar', 'class' => 'btn btn-secondary float-leftz','style' => "display :none"]) ?>
    <?= $this->Form->button('Aceptar', ['onclick' => "disable()",'id'=>'aceptar1','type' => 'submit', 'class' => 'btn btn-primary float-right','style' => "display:none"]) ?>
    <?= $this->Form->button('Aceptar', ['action'=>'add','onclick' => "disable()",'id'=>'aceptar2','type' => 'submit', 'class' => 'btn btn-primary float-right','style' => "display:none"]) ?>
    <?= $this->Form->end() ?>
</div>

<script>
// Muestra, esconde y deshabilita los botones y campos requeridos 

calendar = new dhtmlXCalendarObject(["start-date", "end-date"]);
calendar.setDateFormat("%d-%m-%Y");
calendar.hideTime();

function sensitiveRange(k){
    if(k == 'min'){
        var start = alterDate(byId('start-date').value,+1)
        calendar.setSensitiveRange(start,null);
    }else{
        var yesterday = getYesterday();
        var min = yesterday;
        if(compareDates('<?= $last[4]; ?>',yesterday)>=0){
            var min = '<?= $last[4]; ?>';
        }
        calendar.setSensitiveRange(min,null);
    }
}    

function getYesterday(){
    var yesterday  = new Date(1970,0,0,0,0,0,0);
    yesterday.setMilliseconds(Date.now()-86400000);
    return getStringFormat(yesterday);
}

function getDateFormat(date){
    var day = date.substr(0,2);
    var month = date.substr(3,2);
    var year = date.substr(6,4);    
    return new Date(month.concat('-',day,'-',year));
}

function getStringFormat(date){
    var result = '';
    if(date.getDate() < 10){
        result = '0';
    }
    var d = date.getDate().toString();
    var mc = '';
    if(date.getMonth() < 9){
        mc = '0';
    }
    var m = (date.getMonth()+1).toString();
    var y = date.getFullYear().toString();
    return result.concat(d,'-',mc,m,'-',y);
}

function alterDate(date,alt){
    var d = getDateFormat(date);
    d.setDate(d.getDate()+alt);
    return getStringFormat(d);
}

function compareDates(date1,date2){
    var y1 = date1.substr(6,4);
    var y2 = date2.substr(6,4);
    if(y1 < y2){
        return -1;
    }else if(y1 > y2){
        return 1;
    }
    var m1 = date1.substr(3,2);
    var m2 = date2.substr(3,2);
    if(m1 < m2){
        return -1;
    }else if(m1 > m2){
        return 1;
    }
    var d1 = date1.substr(0,2);
    var d2 = date2.substr(0,2);
    if(d1 < d2){
        return -1;
    }else if(d1 > d2){
        return 1;
    }
    return 0;    
}

calendar.attachEvent("onClick", function(date){
    var start = byId('start-date').value;
    var end = byId('end-date').value;
    if(compareDates(start,end)>=0){
        byId('end-date').value = alterDate(start,1);
    }
});

function startEdit(){
    byId('cancelar').style.display = "inline";
    byId('aceptar2').style.display = "none";
    byId('aceptar1').style.display = "inline";
    byId('end-date').disabled = false;
    byId('trash').style.display = "none";
    byId('caladd').style.display = "none";    
    var yesterday = getYesterday();
    if(compareDates(yesterday,byId('start-date').value)>1){
        byId('start-date').disabled = false;
    }

}
// Muestra, esconde y deshabilita los botones y campos requeridos 
function startAdd(){
    byId('cancelar').style.display = "inline";
    byId('aceptar1').style.display = "none";
    byId('aceptar2').style.display = "inline";
    byId('start-date').disabled = false;
    byId('end-date').disabled = false;
    byId('start-date').value = '<?= $last[4]; ?>';
    byId('end-date').value = alterDate('<?= $last[4]; ?>',1);
    byId('trash').style.display = "none";
    byId('edit').style.display = "none";
    byId('num').style.display = "none";
    byId('numData').style.display = "none";
}

// esconde y deshabilita los botones y campos requeridos 
function disable() {
byId('cancelar').style.display = "none";
byId('aceptar2').style.display = "none";
byId('aceptar1').style.display = "none";
byId('start-date').disabled = true;
byId('end-date').disabled = true;
byId('trash').style.display = "table-cell";
byId('edit').style.display = "table-cell";
byId('caladd').style.display = "table-cell";
byId('num').style.display = "table-cell";
byId('numData').style.display = "table-cell";

}
</script>

<script>
function byId(id) {
	return document.getElementById(id);
}
</script>