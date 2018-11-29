// Configuración al español del calendario dhtmlX
dhtmlXCalendarObject.prototype.langData["es"] = {
    dateformat: "%d.%m.%Y",
    hdrformat: "%F %Y",
    monthesFNames:[
        "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
        "Agosto","Septiembre","Octubre","Noviembre","Diciembre"
    ],
    monthesSNames:[
        "Ene","Feb","Mar","Abr","May","Jun",
        "Jul","Ago","Sep","Oct","Nov","Dic"
    ],
    daysFNames:["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"],
    daysSNames:["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
    weekstart: 1,
    weekname: "Sem",
    today: "Hoy",
    clear: "Borrar"
};
dhtmlXCalendarObject.prototype.lang = "es";

// Variables globales
calendar = new dhtmlXCalendarObject(["start-date", "end-date"]);
calendar.setDateFormat("%d-%m-%Y");
calendar.hideTime();

var roundData;
var penultimateRoundData;
var today = getToday();

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Inicializa los campos del formulario dependiendo de la existencia de roundData.
 */
(function() {
    if(!roundData){
        start(1);
        byId('start-date').value = today;
        byId('end-date').value = byId('start-date').value;
    }else{ 
        byId('start-date').disabled = true;
        byId('end-date').disabled = true;
        byId('total-student-hours').disabled = true;
        byId('total-student-hours-d').disabled = true;
        byId('total-assistant-hours').disabled = true;
        if(compareDates(roundData['end_date'],today)>=0){
            //byId('add').style.display = 'none'; DESCOMENTAR AL DEJAR DE PROBAR AGREGADOS
        }
    }
})();


/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Verifica que al agregar una nueva ronda esta sea en el semestre actual o de uno nuevo,
 * 
 */
calendar.attachEvent("onClick", function(date){
    // cambia el valor de la fecha final si la fecha inicial se hace mayor a esta
    if(compareDates(byId('start-date').value, byId('end-date').value) > 0){
        byId('end-date').value = byId('start-date').value;
    }
    var startDate = splitDate(byId('start-date').value);
    var year = startDate['y'];
    if(startDate['m'] == 12) year += 1;
    endSem1 = '01-07-'.concat(year);
    endSem2 = '01-12-'.concat(year);
    // Controla que no se cruzen semestres.
    if(compareDates(byId('start-date').value, endSem1) < 0){
        if(compareDates(byId('end-date').value, endSem1) >= 0){
            byId('end-date').value = alterDate(endSem1,-1);
        }
    }else if(compareDates(byId('start-date').value,endSem2) < 0){
        if(compareDates(byId('end-date').value, endSem2) >= 0){
            byId('end-date').value = alterDate(endSem2,-1);
        }
    }
    if(roundData){
        if( byId('flag').value == '1'){
            if(year != roundData['year'] || (roundData['semester'] == 'I' && startDate['m'] > 6 && startDate['m'] < 12) || (roundData['semester'] == 'II' && startDate['m'] > 11)){
                // Si se cambia de semestre el número de horas se resetean a 0.
                byId('total-student-hours').value = 0;
                byId('total-student-hours-d').value = 0;
                byId('total-assistant-hours').value = 0;
                byId('total-student-hours').min = 0;
                byId('total-student-hours-d').min = 0;
                byId('total-assistant-hours').min = 0;
            }else{
                // Si vuelve al semestre actual se resetea a los datos antiguos.
                byId('total-student-hours').value = roundData['total_student_hours']-roundData['actual_student_hours'];
                byId('total-student-hours-d').value = roundData['total_student_hours_d']-roundData['actual_student_hours_d'];
                byId('total-assistant-hours').value =  roundData['total_assistant_hours']-roundData['actual_assistant_hours'];
                byId('total-student-hours').min = byId('total-student-hours').value;
                byId('total-student-hours-d').min = byId('total-student-hours-d').value;
                byId('total-assistant-hours').min = byId('total-assistant-hours').value;
            }
        }
    }
});

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Función que ayuda a bloquear la entrada de fechas no validas en el campo de fecha inicial
 */
function sensitiveStart(){
    calendar.hide();
    byId('start-date').readOnly = true;
    var min = today;
    var max = null;
    if(byId('flag').value == '1' && roundData){// añadir
        if(roundData['round_number'] == 3){
            var sem1ds = '01-07-'.concat(roundData['year']);
            var sem2ds = '01-12-'.concat(roundData['year']);
            if(roundData['semester'] == 'I' && (compareDates(sem1ds,min) > 0)) min = sem1ds;
            else if(roundData['semester'] == 'II' && (compareDates(sem2ds,min) > 0)) min = sem2ds;
        }
        if(compareDates(roundData['start_date'],roundData['end_date']) == 0 && compareDates(roundData['end_date'],min) > 0){
            min = alterDate(roundData['end_date'],1);
        }else if(compareDates(roundData['end_date'],min) > 0){
            min = roundData['end_date'];
        }
    }else if(roundData){ // editar
        if(penultimateRoundData){
            var penultimateStart = penultimateRoundData['start_date'];
            var penultimateEnd = penultimateRoundData['end_date'];
            if(compareDates(penultimateStart,penultimateEnd) == 0 && compareDates(penultimateEnd,min) > 0){
                min = alterDate(penultimateEnd,1);
            }else if(compareDates(penultimateEnd,min) > 0){
                min = penultimateEnd;
            }
        }
        var sem1ds = '01-12-'.concat(roundData['year']-1);
        var sem2ds = '01-07-'.concat(roundData['year']);
        if(roundData['semester'] == 'I' && (compareDates(sem1ds,min) > 0)) min = sem1ds;
        else if(roundData['semester'] == 'II' && (compareDates(sem2ds,min) > 0)) min = sem2ds;
        if(compareDates(roundData['start_date'],today)<0){
            max = min = roundData['start_date'];
        }else{
            max = ((roundData['semester'] == 'I')? '30-06-':'30-11-').concat(roundData['year']);
        }
    }        
    calendar.setSensitiveRange(min,max);
}    

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Función que ayuda a bloquear la entrada de fechas no validas en el campo de fecha final
 */
function sensitiveEnd(){
    calendar.hide();
    byId('end-date').readOnly = true;
    if(roundData){
        min = roundData['end_date'];
        if(compareDates(min,today) < 0) min = today;
        if(compareDates(min,byId('start-date').value) < 0) min = byId('start-date').value;
        max = (roundData['semester'] == 'I')?'30-06-' : '30-11-';
        max = max.concat(roundData['year']);
        if(byId('flag').value == '1'){
            if(compareDates(max,min)<0){
                var md = splitDate(min);
                if(md['m'] == 12) md['y'] += 1;
                max = ((md['m'] == 12 || md['m'] < 7)?'30-06-':'30-11-').concat(md['y']);
            }
        }
    }else{
        min = byId('start-date').value
        var md = splitDate(min);
        max = ((md['m'] == 12 || md['m'] < 7)?'30-06-':'30-11-').concat(md['y']);
        if(compareDates(min,today) < 0) min = today;
    }
    calendar.setSensitiveRange(min,max);
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Función que ayuda a bloquear la entrada de datos distintos de una fecha
 * 
 * @param {bool} start - indica cual campo deja de tener atención.
 */
function readOnlyFalse(start){
    if(start) byId('start-date').readOnly = false;
    else byId('end-date').readOnly = false;
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Inicializa edición o agregado de una ronda.
 * 
 * @param {int} flag - indica la operación a realizar: {1:add, 2:edit}.
 */
function start(flag){
    // Habilita todos los campos.
    byId('start-date').disabled = false;
    byId('end-date').disabled = false;
    byId('total-student-hours').disabled = false;
    byId('total-student-hours-d').disabled = false;
    byId('total-assistant-hours').disabled = false;

    // Permite escribir datos sobre los campos.
    byId('start-date').readOnly = false;
    byId('end-date').readOnly = false;
    byId('total-student-hours').readOnly = false;
    byId('total-student-hours-d').readOnly = false;
    byId('total-assistant-hours').readOnly = false;
    
    // Esconde botones de acción
    byId('edit').style.visibility = "hidden";
    byId('add').style.visibility = "hidden"
    if(flag == '1')byId('delete').style.visibility = 'hidden';
    
    // Muestra Botones del form
    if(roundData){
        byId('cancelar').style.display = "inline";
    }
    byId('aceptar').style.display = "inline";

    // Asigna el valor de flag a la entrada oculta flag
    byId('flag').value = flag; 
    if(flag == 1){
        startAdd();
    }else if(flag == 2){
        startEdit();
    }
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Altera los valores de las entradas de fecha según a los datos anteriores,
 * además habilita los campos de hora si llega a ser necesario al agregar una ronda.
 * 
 */
function startAdd(){
    byId('title').innerText = 'Añadiendo Ronda';
    byId('subSection1').innerText = 'Periodo de la nueva Ronda';
    if(roundData){
        if(roundData['round_number'] == 3){
            // la siguiente ronda en agregar será la primera.
            if(roundData['semester'] == 'I') newRoundStart = '01-07-'.concat(roundData['year']);
            else newRoundStart = '01-12-'.concat(roundData['year']);
            byId('start-date').value = newRoundStart; 
            byId('total-student-hours').value = 0;
            byId('total-student-hours-d').value = 0;
            byId('total-assistant-hours').value = 0;
            byId('total-student-hours').min = 0;
            byId('total-student-hours-d').min = 0;
            byId('total-assistant-hours').min = 0;
        }else{
            //verifica errores en caso de haber dos rondas el mismo día
            if(compareDates(roundData['start_date'],roundData['end_date'])==0){
                byId('start-date').value = alterDate(roundData['end_date'],1);
            }else{
                byId('start-date').value = roundData['end_date'];
            }
            // Establece los totales de horas siguientes con respecto a las horas sobrantes de la ronda anterior
            byId('total-student-hours').value = roundData['total_student_hours'] - roundData['actual_student_hours'] ;
            byId('total-student-hours-d').value = roundData['total_student_hours_d'] - roundData['actual_student_hours_d'];
            byId('total-assistant-hours').value = roundData['total_assistant_hours'] - roundData['actual_assistant_hours'];
            byId('total-student-hours').min = byId('total-student-hours').value;
            byId('total-student-hours-d').min = byId('total-student-hours-d').value;
            byId('total-assistant-hours').min = byId('total-assistant-hours').value;
        } 
        // Verifica que la fecha fin no sea menor a la fecha inicial
        if(compareDates(byId('end-date').value,byId('start-date').value)<0){
            byId('end-date').value = byId('start-date').value;
        }   
    }
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Habilita los campos de hora y les asigna el valor actual.
 */
function startEdit(){ 
    byId('title').innerText = 'Editando Ronda';
    // Establece los totales y límites de las horas con respecto a las horas actuales
    byId('total-student-hours').value = roundData['total_student_hours'];
    byId('total-student-hours-d').value = roundData['total_student_hours_d'];
    byId('total-assistant-hours').value = roundData['total_assistant_hours'];
    byId('total-student-hours').min = roundData['actual_student_hours'];
    byId('total-student-hours-d').min = roundData['actual_student_hours_d'];
    byId('total-assistant-hours').min = roundData['actual_assistant_hours'];    
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Reinicia el estado de la vista al estado anterior del cambio por hacer.
 */
function cancel() {
    byId('title').innerText = 'Gestión de Rondas';
    byId('subSection1').innerText =  'Periodo de la ronda #'.concat(roundData['round_number'],' del ', roundData['semester'], ' ciclo ', roundData['year']);
    // Datos del formulario
    byId('start-date').value = roundData['start_date'];
    byId('end-date').value = roundData['end_date'];
    byId('total-student-hours').value = roundData['total_student_hours'];
    byId('total-student-hours-d').value = roundData['total_student_hours_d'];
    byId('total-assistant-hours').value = roundData['total_assistant_hours'];
    byId('flag').value = "0";
    // disabled
    byId('start-date').disabled = true;
    byId('end-date').disabled = true;
    byId('total-student-hours').disabled = true;
    byId('total-student-hours-d').disabled = true;
    byId('total-assistant-hours').disabled = true;
    //Botones de Acción
    byId('delete').style.visibility = 'visible';
    byId('edit').style.visibility = "visible";
    //if(compareDates(roundData['end_date'],today)<0){ DESCOMENTAR CUANDO AÑADIR RONDA DEJE DE SER PROBADO
        byId('add').style.visibility = "visible";
    //}
    // Botones del formulario
    byId('cancelar').style.display = "none";
    byId('aceptar').style.display = "none";
}