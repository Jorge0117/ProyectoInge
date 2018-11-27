/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Calcula el día actual.
 * 
 * @return {String} hilera con formato de fecha 'dd-mm-yyyy' con el día actual como valor.
 */
function getToday(){
    var today  = new Date(1970,0,1,0,0,0,0);
    var GMTm6ms = 21600000;
    today.setMilliseconds(Date.now()-GMTm6ms);
    return dateToString(today);
}

/**
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Traduce de string con formato 'dd-mm-yyyy' a formato de objeto fecha.
 * 
 * @param {String} date - hilera con formato de fecha 'dd-mm-yyyy'.
 * @return {Date} objeto fecha.
 */
function stringToDate(date){
    var day = date.substr(0,2);
    var month = date.substr(3,2);
    var year = date.substr(6,4);    
    return new Date(month.concat('-',day,'-',year));
}

/**
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Traduce de formato de objeto fecha a string con formato 'dd-mm-yyyy'.
 * 
 * @param {Date} date - objeto fecha a traducir.
 * @return {String} hilera con formato de fecha 'dd-mm-yyyy'.
 */
function dateToString(date){
    var result = '';
    var dc = '';
    if(date.getDate() < 10)dc = '0';
    var d = date.getDate().toString();
    var mc = '';
    if(date.getMonth() < 9)mc = '0';
    var m = (date.getMonth()+1).toString();
    var y = date.getFullYear().toString();
    return result.concat(dc,d,'-',mc,m,'-',y);
}

/**
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Altera el día de la fecha dada según el valor alter.
 *
 * @param {String} date - hilera con formato de fecha 'dd-mm-yyyy'.
 * @param {int} alter - entero con cualquier valor.
 * @return {String} fecha alterada.
 */
function alterDate(date,alter){
    var result = stringToDate(date);
    result.setDate(result.getDate()+alter);
    return dateToString(result);
}

/**
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Compara dos fechas dadas para saber cual es mayor, menor o si son iguales.
 * 
 * @param {String} date1 - hilera con formato de fecha 'dd-mm-yyyy'.
 * @param {String} date2 - hilera con formato de fecha 'dd-mm-yyyy'.
 * @return {int} date1 < date2 => result < 0, 
 *               date1 = date2 => result = 0,
 *               date1 > date2 => result > 0.
 */
function compareDates(date1,date2){
    var d1 = splitDate(date1);
    var d2 = splitDate(date2);
    var result = d1['y'] - d2['y'];
    if(!result) result = d1['m'] - d2['m'];
    if(!result) result = d1['d'] - d2['d'];
    return result;    
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Divide la fecha dada en día, mes y año.
 * 
 * @param {String} date - hilera con formato de fecha 'dd-mm-yyyy'.
 * @return {Array} {'d':dd, 'm':mm, 'y':yyyy}.
 */
function splitDate(date){
    result = {
        'd' : parseInt(date.substr(0,2)),
        'm' : parseInt(date.substr(3,2)),
        'y' : parseInt(date.substr(6,4))
    };
    return result;
}

/** 
 * @author Daniel Marín <110100010111h@gmail.com>
 * 
 * Transforma una hilera con formato de fecha 'yyyy-mm-dd' a 'dd-mm-yyyy' y viceversa.
 * 
 * @param {String} date - hilera con formato de fecha 'yyyy-mm-dd' o 'dd-mm-yyyy'.
 * @return {String} hilera resultado de la transformación.
 */
function YmdtodmY(date){
    n = date.length;
    j = i = 0;
    while(date[i] != '/' && date[i] != '-' && i < n)i++;
    first = date.substr(j,i++);
    j = i; i = 0;
    while(date[j+i] != '/' && date[j+i] != '-' && i < n)i++;
    second = date.substr(j,i++);
    third = date.substr(j+i);
    result = third.concat("-",second,"-",first);
    return result;
}