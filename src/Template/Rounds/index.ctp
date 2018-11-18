<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Round[]|\Cake\Collection\CollectionInterface $rounds
 */
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.dhtmlx.com/edge/dhtmlx.css" type="text/css"> 
<script src="https://cdn.dhtmlx.com/edge/dhtmlx.js" type="text/javascript"></script>

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
<?php 
    $penultimateRound = $this->Rounds->getPenultimateRow();
    $s_date = $this->Rounds->YmdtodmY($roundData['start_date']);
    $e_date = $this->Rounds->YmdtodmY($roundData['end_date']);
    $rn = $roundData['round_number'];
    $sem = $roundData['semester'];
    $year = $roundData['year'];
    $tsh = $roundData['total_student_hours'];
    $tdh = $roundData['total_student_hours_d'];
    $tah = $roundData['total_assistant_hours'];
    $ash = $roundData['actual_student_hours'];
    $adh = $roundData['actual_student_hours_d'];
    $aah = $roundData['actual_assistant_hours'];
    if(!$roundData){
        $tsh = $tdh = $tah = $ash = $adh = $aah = 0;
    }
?>


<div class='rounds index large-9 menium-8 columns content'>
    <h3 id='title' ><?= 'Gestión de Rondas' ?></h3>
</div>
<div>
    <table cellspacing="0" cellpadding="0" class="table">
        <thead>
            <tr>
                <th id='RoundnumberHeader'><?= '#' ?></th>
                <th><?= 'Fecha Inicio' ?></th>    
                <th><?= 'Fecha Fin' ?></th>
                <th id = 'tshHeader' style = 'width:100px; display:none'><?= "HE ECCI" ?></th>
                <th id = 'tdhHeader' style = 'width:100px; display:none'><?= "HE DOC" ?></th>
                <th id = 'tahHeader' style = 'width:100px; display:none'><?= "HA ECCI" ?></th>
                <th style = 'width:80px;'> </th>
            </tr>
        </thead>
        <tbody>
            <tr><div class='rounds form large-9 medium-8 columns content'>
                <td id= 'RoundnumberData'><p style = 'padding:6px 0px'><?= $rn ?></p></td>
                    <?= $this->Form->create($round ,['id'=>'mainRoundsIndexform']) ?>
                    <fieldset>
                        <div>
                            <td>
                                <?= $this->Form->control('start_date',[
                                    'type'=>'calendar',
                                    'value'=>$s_date,
                                    'label' => false,
                                    'readonly'=>true,
                                    'onclick'=>"sensitiveRange(1)"
                                ]);?></td>
                            <td>
                                <?= $this->Form->control('end_date',[
                                    'type'=>'calendar',
                                    'value'=>$e_date,
                                    'label' => false,
                                    'readonly'=>true,
                                    'onclick'=>"sensitiveRange(0)"
                                ]);?></td>
                            <td id = 'tshData' style = 'display:none'>
                                <?= $this->Form->control('total_student_hours',[
                                    'type'=>'number',
                                    'value'=> $tsh,
                                    'label' => false,
                                    'min' => $ash,
                                    'max' => '99999',
                                    'required'
                                ]);?></td>
                            <td id = 'tdhData' style = 'display:none'>
                                <?= $this->Form->control('total_student_hours_d',[
                                    'type'=>'number',
                                    'value'=> $tdh,
                                    'label' => false,
                                    'min' => $adh,
                                    'max' => '99999',
                                    'required'
                                ]);?></td>
                            <td id = 'tahData' style = 'display:none'>
                                <?= $this->Form->control('total_assistant_hours',[
                                    'type'=>'number',
                                    'value'=> $tah,
                                    'label' => false,
                                    'min' => $aah,
                                    'max' => '99999',
                                    'required'
                                ]);?></td>
                            </div>
                            <input type="hidden" id="flag" name='flag' value="0">
                            <?php $this->Form->unlockField('flag')?>
                        </div>
                    </fieldset>
                    <?= $this->Form->end() ?>
                <!-- Botones de accion -->                
                <td>
                    <?= $this->Form->postbutton('<i class="fa fa-trash-o"></i>',[ 'action' => 'delete', $s_date],['style' => 'padding:0px 2px','class'=>'btn-x float-left','id' => 'trash','confirm' =>__('¿Está seguro de que desea borrar la ronda de solicitudes #{0} del {1} ciclo {2}?', $rn, $sem,$year)]);?>
                </td>
            </div></tr>
        </tbody>
    </table>
</div>

<div class="submit">
    <?= $this->Form->postbutton('Aceptar',['action' => 'index'],['id'=>'aceptar','type' => 'submit','form' => 'mainRoundsIndexform', 'class' => 'btn btn-primary btn-aceptar','style' => "display:none; margin-right:3px; margin-left:3px"]) ?>
    <?= $this->Form->button('Cancelar', ['onclick' => "cancel()",'id'=>'cancelar', 'class' => 'btn btn-secondary btn-cancelar','style' => "display:none;"]) ?>    
    <?= $this->Form->button('Iniciar Nueva Ronda', ['onclick' => "startAdd()",'id'=>'add', 'class' => 'btn btn-primary btn-aceptar']) ?>    
    <?= $this->Form->button('Editar Ronda', ['onclick' => "startEdit()",'id'=>'edit', 'class' => 'btn btn-primary btn-aceptar']) ?>    
    <?= $this->Form->end() ?>
</div>

<script>

// configuración para un nuevo lenguaje del calendario (Español)
dhtmlXCalendarObject.prototype.langData["es"] = {
    dateformat: "%d.%m.%Y",
    hdrformat: "%F %Y",
    monthesFNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
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

calendar = new dhtmlXCalendarObject(["start-date", "end-date"]);
calendar.setDateFormat("%d-%m-%Y");
calendar.hideTime();
var last = getLast();

// función inicial altera campos visibles si
$(document).ready( function () {
    if(!last){                
        startAdd();
        byId('start-date').value = getToday();
        byId('end-date').value = byId('start-date').value;
        byId('tshHeader').style.display = "table-cell";
        byId('tshData').style.display = "table-cell";
        byId('tshData').value = 0;
        byId('tdhHeader').style.display = "table-cell";
        byId('tdhData').style.display = "table-cell";
        byId('tdhData').value = 0;
        byId('tahHeader').style.display = "table-cell";
        byId('tahData').style.display = "table-cell";
        byId('tahData').value = 0;
    }else{
        // Comentar bloque para poder agregar una ronda.
        // Si hay una ronda activa, no se pueden agregar rondas.
        // Una ronda activa es aquella en la que su último día es mayor a hoy.
        if(compareDates(last['end_date'],getToday())>=0){
           byId('add').style.display = 'none';
        }
    }
});

function sensitiveRange(first){
    var today = getToday();
    if(first){// start_date
        var min = today;
        var max = null;
        if(byId('flag').value == '1' && last){// añadir
            if(last['round_number'] == 3){
                var sem1ds = '01-07-'.concat(last['year']);
                var sem2ds = '01-12-'.concat(last['year']);
                if(last['semester'] == 'I' && (compareDates(sem1ds,min) > 0)) min = sem1ds;
                else if(last['semester'] == 'II' && (compareDates(sem2ds,min) > 0)) min = sem2ds;
            }
            if(compareDates(last['start_date'],last['end_date']) == 0 && compareDates(last['end_date'],min) > 0){
                min = alterDate(last['end_date'],1);
            }else if(compareDates(last['end_date'],min) > 0){
                min = last['end_date'];
            }
        }else{ // editar
            var penultimateStart = '<?= $penultimateRound['start_date'] ?>';
            var penultimateEnd = '<?= $penultimateRound['end_date'] ?>';
            if(compareDates(penultimateStart,penultimateEnd) == 0 && compareDates(penultimateEnd,min) > 0){
                min = alterDate(penultimateEnd,1);
            }else if(compareDates(penultimateEnd,min) > 0){
                min = penultimateEnd;
            }

            var sem1ds = '01-12-'.concat(last['year']-1);
            var sem2ds = '01-07-'.concat(last['year']);
            if(last['semester'] == 'I' && (compareDates(sem1ds,min) > 0)) min = sem1ds;
            else if(last['semester'] == 'II' && (compareDates(sem2ds,min) > 0)) min = sem2ds;

            if(last){
                if(compareDates(last['start_date'],today)<0){
                    max = min = last['start_date'];
                }else{
                    if(last['semester'] == 'I') max = '30-06-';                              //primer semestre
                    else max = '30-11-';                                            //segundo semestre
                    max = max.concat(last['year']);                                      // agrega el año
                }   
            }

        }        
        calendar.setSensitiveRange(min,max);
    }else{// end_date
        var min = byId('start-date').value
        if(compareDates(min,today) < 0) min = today;  //Para poder cerrar la ronda sin eliminarla
        var max = null;
        if(last){
            if(last['semester'] == 'I') max = '30-06-';                              //primer semestre
            else max = '30-11-';                                            //segundo semestre
            max = max.concat(last['year']);                                      // agrega el año
            if(byId('flag').value != '2'){                                  // Añadir
                if(compareDates(max,min)<0){
                    var minDate = splitDate(min);
                    var year = minDate['y'];
                    if(minDate['m'] == '12' || parseInt(minDate['m']) < 7){
                        if(minDate['m'] == '12'){
                            year = parseInt(year)+1;
                        }
                        max = '30-06-'.concat(year);
                    }else{
                        max = '30-11-'.concat(year);
                    }
                }
            }
        }
        calendar.setSensitiveRange(min,max);
    }
}    

// cambia el estado de neutro a editar, verifica que al agregar una nueva ronda esta sea el el semestre actual o de uno nuevo,
calendar.attachEvent("onClick", function(date){    
    var start = byId('start-date').value;
    var end = byId('end-date').value;
    if(compareDates(start,end)>0){
        byId('end-date').value = start;
    }
    if(last){
        if( byId('flag').value == '1'){
            var startDate = splitDate(start);
            var year = startDate['y'];
            if(startDate['m'] == 12) year = parseInt(year)+1;
            if(year != last['year'] || (last['semester'] == 'I' && parseInt(startDate['m']) > 6 && parseInt(startDate['m']) < 12) || (last['semester'] == 'II' && parseInt(startDate['m']) > 11)){
                byId('total-student-hours').value = 0;
                byId('total-student-hours-d').value = 0;
                byId('total-assistant-hours').value = 0;
            }else{
                byId('total-student-hours').value = last['total_student_hours']-last['actual_student_hours'];
                byId('total-student-hours-d').value = last['total_student_hours_d']-last['actual_student_hours_d'];
                byId('total-assistant-hours').value =  last['total_assistant_hours']-last['actual_assistant_hours'];
            }
        }else if((compareDates(start,last['start_date'])!=0 || compareDates(end,last['end_date'])!=0) && byId('flag').value != '1'){
            startEdit();
        }
    }
});

/** función getToday
  * EFE: Calcula el día actual.
  * RET: string con el valor del dia actual
  **/
function getToday(){
    var today  = new Date(1970,0,1,0,0,0,0);
    var GMTm6ms = 21600000;
    today.setMilliseconds(Date.now()-GMTm6ms);
    return getStringFormat(today);
}

/**  función getDateFormat
  * EFE: Obtiene el formato de objeto fecha del string dado.
  * REQ: date: string con formato de fecha 'dd-mm-yyyy'.
  * RET: objeto fecha.
  **/
function getDateFormat(date){
    var day = date.substr(0,2);
    var month = date.substr(3,2);
    var year = date.substr(6,4);    
    return new Date(month.concat('-',day,'-',year));
}

/**  función getStringFormat
  * EFE: Obtiene el formato string del objeto fecha date.
  * REQ: date: objeto fecha.
  * RET: string con formato de fecha 'dd-mm-yyyy'
  **/
function getStringFormat(date){
    var result = '';
    if(date.getDate() < 10)result = '0';
    var d = date.getDate().toString();
    var mc = '';
    if(date.getMonth() < 9)mc = '0';
    var m = (date.getMonth()+1).toString();
    var y = date.getFullYear().toString();
    return result.concat(d,'-',mc,m,'-',y);
}

/**  funcion alterDate
  * EFE: Cambia el día de la fecha dada según al valor alt.
  * REQ: date: string con formato de fecha 'dd-mm-yyyy'.
  *      alt: entero con cualquier valor.
  * RET: string de la fecha alterada.
  **/
function alterDate(date,alt){
    var d = getDateFormat(date);
    d.setDate(d.getDate()+alt);
    return getStringFormat(d);
}

/** función compareDates
  * EFE: Compara cual de las dos fechas dadas es mayor o menor o si son iguales.
  * REQ: dos strings con formato de fecha 'dd-mm-yyyy'.
  * RET: < 0: si date1 < date2 
  *      = 0: si date1 = date2
  *      > 0: si date1 > date2
  **/
function compareDates(date1,date2){
    var d1 = splitDate(date1);
    var d2 = splitDate(date2);
    var result = d1['y'] - d2['y'];
    if(!result) result = d1['m'] - d2['m'];
    if(!result) result = d1['d'] - d2['d'];
    return result;    
}

/** Función splitDate
  * EFE: Divide un string con formato de fecha 'dd-mm-yyyy' y lo transforma en un array.
  * REQ: date: string con formato de fecha 'dd-mm-yyyy'.
  * RET: Array con los tres valores correspondientes para las llaves 'd', 'm', 'y'
  **/
function splitDate(date){
    return {'d':date.substr(0,2),'m':date.substr(3,2),'y':date.substr(6,4)};
}

/** Función startEdit
  * EFE: Habilita los campos de hora y les asigna el valor actual.
  **/
function startEdit(){ 
    start('2');
    byId('tshHeader').style.display = "table-cell";
    byId('tshData').style.display = "table-cell";
    byId('tdhHeader').style.display = "table-cell";
    byId('tdhData').style.display = "table-cell";
    byId('tahHeader').style.display = "table-cell";
    byId('tahData').style.display = "table-cell";
    byId('total-student-hours').value = last['total_student_hours'];
    byId('total-student-hours-d').value = last['total_student_hours_d'];
    byId('total-assistant-hours').value = last['total_assistant_hours'];
    byId('total-student-hours').min = last['actual_student_hours'];
    byId('total-student-hours-d').min = last['actual_student_hours_d'];
    byId('total-assistant-hours').min = last['actual_assistant_hours'];
    byId('title').innerText = 'Editando Ronda';
}

/** Función startAdd
  * EFE: Altera los valores de las entradas de fecha degún a los datos anteriores,
  *      además habilita los campos de hora si llega a ser necesario al agregar 
  *      una ronda.
  **/
function startAdd(){
    start('1');
    if(last){
        if(last['round_number'] == 3){
            var newRoundStart = '';
            if(last['semester'] == 'I')newRoundStart = newRoundStart.concat('01-07-', last['year']);
            else newRoundStart = newRoundStart.concat('01-12-', last['year']);
            byId('start-date').value = newRoundStart;            
        }else if(compareDates(byId('start-date').value,last['end_date'])<=0){
            if(compareDates(last['start_date'],last['end_date'])==0){
                byId('start-date').value = alterDate(last['end_date'],1);
            }else{
                byId('start-date').value = last['end_date'];
            }
        }
        var end = byId('start-date').value;
        if(compareDates(byId('end-date').value,end)<0){
            byId('end-date').value = end;
        }   
        byId('tshHeader').style.display = "table-cell";
        byId('tshData').style.display = "table-cell";
        byId('tdhHeader').style.display = "table-cell";
        byId('tdhData').style.display = "table-cell";
        byId('tahHeader').style.display = "table-cell";
        byId('tahData').style.display = "table-cell";
        if(last['round_numer'] != 3){
            byId('total-student-hours').value = last['total_student_hours'] - last['actual_student_hours'] ;
            byId('total-student-hours-d').value = last['total_student_hours_d'] - last['actual_student_hours_d'];
            byId('total-assistant-hours').value = last['total_assistant_hours'] - last['actual_assistant_hours'];
            byId('total-student-hours').min = byId('total-student-hours').value;
            byId('total-student-hours-d').min = byId('total-student-hours-d').value;
            byId('total-assistant-hours').min = byId('total-assistant-hours').value;
            
        }else{
            byId('total-student-hours').value = 0;
            byId('total-student-hours-d').value = 0;
            byId('total-assistant-hours').value = 0;
        }

    }
    byId('title').innerText = 'Añadiendo Ronda';
}

/** Función start
  * EFE: Inicia la acción requerida por el usuario entre añadir y editar.
  * REQ: flag: bandera que indica la acción requerida.
  **/
function start(flag){
    
    byId('edit').style.display = "none";
    byId('add').style.display = "none"
    if(flag == '1'){
        byId('RoundnumberHeader').style.display = "none";
        byId('RoundnumberData').style.display = "none";
        byId('trash').style.display = "none";
    }
    if(last){
        byId('cancelar').style.display = "inline";
    }
    byId('aceptar').style.display = "inline";
    byId('flag').value = flag; 
}

/** Función cancel
  * EFE: Vuelve a colocar los datos iniciales en lo campos del form
  **/
function cancel() {
    byId('start-date').value = last['start_date'];
    byId('end-date').value = last['end_date'];
    byId('flag').value = "0"; 
    end();
}

/** Función end
  * EFE: Reinicia el estado de la vista al estado anterior del cambio por hacer
  * Es llamada al presionar el botón aceptar.
  **/
function end() {
    if(last && last['round_number'] != 3){
        var tsh = byId('total-student-hours').value;
        var tdh = byId('total-student-hours-d').value;
        var tah = byId('total-assistant-hours').value;
        if(tsh < parseInt(last['actual_student_hours']))byId('total-student-hours').value = last['actual_student_hours'];
        if(tdh < parseInt(last['actual_student_hours_d']))byId('total-student-hours-d').value = last['actual_student_hours_d'];
        if(tah < parseInt(last['actual_assistant_hours']))byId('total-assistant-hours').value = last['actual_assistant_hours'];
    }else{
        if(!byId('total-student-hours').value)byId('total-student-hours').value = 0;
        if(!byId('total-assistant-hours').value)byId('total-assistant-hours').value = 0;
    }
    // Campos del número de ronda
    byId('RoundnumberHeader').style.display = "table-cell";
    byId('RoundnumberData').style.display = "table-cell";
    // Horas por asignar
    byId('tshHeader').style.display = "none";
    byId('tshData').style.display = "none";
    byId('tdhHeader').style.display = "none";
    byId('tdhData').style.display = "none";
    byId('tahHeader').style.display = "none";
    byId('tahData').style.display = "none";
    //Botones
    byId('trash').style.display = "table-cell";
    byId('edit').style.display = "table-cell";
    if(compareDates(last['end_date'],getToday())<0){
        byId('add').style.display = "table-cell";
    }
    byId('cancelar').style.display = "none";
    byId('aceptar').style.display = "none";
    byId('title').innerText = 'Gestión de Rondas';
}

/** Función getLast
  * EFE: avoid the use of php tags inside js scritps when the $roundData var is required
  * RET: Array conatining all the elements of $roundData, or null if it is null.
  **/
function getLast(){
    if(<?= $roundData != null ?>){
        <?= "var resultArray = ". json_encode($roundData) . ";\n"?>
        resultArray["start_date"] = '<?= $this->Rounds->YmdtodmY($roundData['start_date']) ?>'
        resultArray["end_date"] = '<?= $this->Rounds->YmdtodmY($roundData['end_date']) ?>'
        return resultArray;
    }
    return null;
}

/** Función byId
  * EFE: Función wrapper de getElementById
  * REQ: Id del elemento a obtener.
  * RET: Elemento requerido.
  **/
function byId(id) {
	return document.getElementById(id);
}



</script>