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
<?php $last = $this->Rounds->getLastRow() ?>
<?php $s_date = $last[0];?>
<?php if($s_date==null){
    $s_date = $this->Rounds->getToday();
}?>
<?php $e_date = $last[1];?>
<?php if($e_date==null){
    $e_date = $this->Rounds->getToday();
}?>

<div class='rounds index large-9 menium-8 columns content'>
    <h3><?= 'Rondas' ?></h3>
</div>
<div>
    <table cellspacing="0" cellpadding="0" class="table">
        <thead>
            <tr>
                <th id='RoundnumberHeader'><?= '#' ?></th>
                <th><?= 'Fecha Inicio' ?></th>    
                <th scope="col"><?= 'Fecha Fin' ?></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr><div class='rounds form large-9 medium-8 columns content'>
                <td id= 'RoundnumberData'><p style = 'padding:6px 0px'><?= $last[2] ?></p></td>
                    <?= $this->Form->create($round ,['id'=>'mainRoundsIndexform']) ?>
                    <fieldset>
                        <div class="form-section">
                            <td><?= $this->Form->control('start_date',[
                                'type'=>'calendar',
                                'value'=>$s_date,
                                'label' => false,
                                'readonly'=>true,
                                'onclick'=>"sensitiveRange('max')"]);?></td>
                            <td><?= $this->Form->control('end_date',[
                                'type'=>'calendar',
                                'value'=>$e_date,
                                'label' => false,
                                'readonly'=>true,
                                'onclick'=>"sensitiveRange('min')"]);?></td>
                            <input type="hidden" id="flag" name='flag' value="0">
                            <?php $this->Form->unlockField('flag')?>
                        </div>
                    </fieldset>
                    <?= $this->Form->end() ?>
                <!-- Botones de accion -->                
                <td><div>
                    <button id='caladd' class='btn-x float-left' style='padding:6px 2px' onclick='startAdd()' >
                        <i class="fa fa-calendar-plus-o"></i>
                    </button>
                    <button id='edit' class='btn-x float-left' style='padding:6px 2px' onclick='startEdit()' >
                        <i class="fa fa-pencil"></i>
                    </button>
                    <?= $this->Form->postbutton('<i class="fa fa-trash-o"></i>',[ 'action' => 'delete', $s_date],['style' => 'padding:6px 2px','class'=>'btn-x float-left','id' => 'trash','confirm' =>__('¿Está seguro de que desea borrar la ronda de solicitudes #{0} del {1} ciclo {2}?', $last[2],$last[3],$last[4])]);?>
                </div></td>
            </div></tr>
        </tbody>
    </table>
</div>

<div class="submit">
    <?= $this->Form->button('Aceptar',['onclick' => "end()",'id'=>'aceptar','type' => 'submit','form' => 'mainRoundsIndexform', 'class' => 'btn btn-primary float-right','style' => "display :none"]) ?>
    <?= $this->Form->button('Cancelar', ['onclick' => "cancel()",'id'=>'cancelar', 'class' => 'btn btn-secondary float-leftz','style' => "display :none"]) ?>
    <?= $this->Form->end() ?>
</div>

<script>    
    $(document).ready( function () {
        if('<?= $last == null ?>'){                
            byId('RoundnumberHeader').style.display = "none";
            byId('RoundnumberData').style.display = "none";
            byId('cancelar').style.display = "inline";
            byId('aceptar').style.display = "inline";
            byId('flag').value = "1"; 
        }
    });
</script>

<script>
// Muestra, esconde y deshabilita los botones y campos requeridos 

calendar = new dhtmlXCalendarObject(["start-date", "end-date"]);
calendar.setDateFormat("%d-%m-%Y");
calendar.hideTime();


function sensitiveRange(k){
    if('<?= $last != null ?>'){
        var semester = '<?= $last[3]; ?>';
        var year = '<?= $last[4]; ?>'
    }
    if(k == 'min'){
        var min = alterDate(byId('start-date').value,+1)
        var max = null;
        if(byId('flag').value != '1'){   
            if(semester == 'I'){
                max = '30-06-';
                max = max.concat(year);
            }else if(semester == 'II'){
                max = '30-11-';
                max = max.concat(year);
            }
        }

        calendar.setSensitiveRange(min,max);
    }else{
        var yesterday = getYesterday();
        var min = yesterday;
        var max = null;
        if(byId('flag').value == '1' && '<?= $last != null ?>'){
            var lastEnd = '<?= $last[1]; ?>';
            if(compareDates(lastEnd,yesterday) > 0){
                min = lastEnd;
            }
        }else{
            min = yesterday;
            var penultimate = '<?= $this->Rounds->getPenultimateRow()[1]?>';
            var sem1ds = '01-12-';
            sem1ds = sem1ds.concat(year-1);
            var sem2ds = '01-07-'
            sem2ds = sem2ds.concat(year);
            if(semester == 'I' && (compareDates(sem1ds,yesterday) > 0)){
                min = sem1ds;
            }else if(semester == 'II' && (compareDates(sem2ds,yesterday) > 0)){
                min = sem2ds;
            }
            if(compareDates(penultimate,min) > 0){
                min = penultimate;
            }
            if('<?= $last != null ?>'){
                var lastStart = '<?= $last[0]; ?>';
                if(compareDates(lastStart,alterDate(yesterday,1)) < 0){
                    max = lastStart;
                }
            }

        }
        calendar.setSensitiveRange(min,max);
    }
}    

function getYesterday(){
    var yesterday  = new Date(1970,0,0,0,0,0,0);
    yesterday.setMilliseconds(Date.now());
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
    if('<?= $last != null ?>'){
        if((compareDates(start,'<?=$last[0]?>')!=0 || compareDates(end,'<?=$last[1]?>')!=0)&&byId('flag').value != '1'){
            startEdit();
        }
    }
});
</script>

<script>
function startEdit(){
    byId('cancelar').style.display = "inline";
    byId('aceptar').style.display = "inline";
    byId('aceptar').style
    byId('trash').style.display = "none";
    byId('caladd').style.display = "none";    
    var yesterday = getYesterday();
    byId('flag').value = "2"; 
}
</script>

<script>
// Muestra, esconde y deshabilita los botones y campos requeridos 
function startAdd(){
    byId('cancelar').style.display = "inline";
    byId('aceptar').style.display = "inline";
    if('<?= $last != null ?>'){
        if(compareDates(byId('start-date').value,'<?= $last[1]; ?>')<=0){
            byId('start-date').value = '<?= $last[1]; ?>';
        }
        var next = alterDate('<?= $last[1]; ?>',1);
        if(compareDates(byId('end-date').value,next)<=0){
            byId('end-date').value = next;
        }   
    }
    byId('flag').value = "1"; 
    byId('trash').style.display = "none";
    byId('edit').style.display = "none";
    byId('RoundnumberHeader').style.display = "none";
    byId('RoundnumberData').style.display = "none";
}
</script>

<script>
// esconde y deshabilita los botones y campos requeridos 
function end() {
    byId('cancelar').style.display = "none";
    byId('aceptar').style.display = "none";
    byId('trash').style.display = "table-cell";
    byId('edit').style.display = "table-cell";
    byId('caladd').style.display = "table-cell";
    byId('RoundnumberHeader').style.display = "table-cell";
    byId('RoundnumberData').style.display = "table-cell";
}
</script>

<script>
function cancel() {
    byId('cancelar').style.display = "none";
    byId('aceptar').style.display = "none";
    byId('trash').style.display = "table-cell";
    byId('edit').style.display = "table-cell";
    byId('caladd').style.display = "table-cell";
    byId('RoundnumberHeader').style.display = "table-cell";
    byId('RoundnumberData').style.display = "table-cell";
    byId('start-date').disabled = false;
    byId('start-date').value = '<?= $this->Rounds->getLastRow()[0]?>'
    byId('end-date').value = '<?= $this->Rounds->getLastRow()[1]?>'
    byId('flag').value = "0"; 
}
</script>

<script>
function byId(id) {
	return document.getElementById(id);
}
</script>