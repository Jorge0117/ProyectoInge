/**
 Carga el comboBox de grupos de acuerdo al curso seleccionado
 * 
 * @author Esteban Rojas
 **/
function updateClass() 
{
    document.getElementById("prof").value = ""; 
    //Obtiene los select de grupo y curso respectivamente
    selClass = document.getElementById("class-number");
    selCourse = document.getElementById("course-id");
    
    selCourseII = document.getElementById("c2");
    
    //Obtiene valores de los inputs ocultos
    a1 = document.getElementById("a1");
    a2 = document.getElementById("a2");
    
    //elimina todas las opciones de clase:
    var l = selClass.options.length;
    
    //Remueve todas las opciones de grupo actuales
    for(j = 0; j < l; j = j + 1)
    {
        selClass.options.remove(0);
    }
    
    //Recuerda el curso actual seleccionado

    actualCourse = selCourseII.options[selCourse.selectedIndex].text;
    
    courses = a2.options;
    i = 0;
    var tmp2 = document.createElement("option");
    tmp2.text = "Seleccione un Grupo"
    selClass.options.add(tmp2,0);
    tmp2 = document.createElement("option");
    tmp2.text = "BORRAR";
    
    var course_array = [];

    for(c = 0;  c < courses.length; c = c + 1) // Recorre los cursos
    {
        //Si el curso es el mismo al curso seleccionado, manda el grupo al vector
        if(actualCourse.localeCompare(courses[c].text) == 0)
        {
            var tmp = document.createElement("option");
            //if(c+1 < a1.options.length)
            //{
            tmp.text = a1.options[c].text; //Prestarle atencion a esta linea
            selClass.options.add(tmp,i);
            i = i + 1;
            //}
            
        }

    }
    
    //selClass.options = [1,2,3];
    txtNombre = document.getElementById("nc");

    if(selCourse.selectedIndex != 0)
    {
        
        txtNombre.value = document.getElementById("a3").options[selCourse.selectedIndex-1].text;
        
    }
    else
        txtNombre.value = "";
    
    //Esta parte de la funcion se encarga de corregir el error de PHP, en el que mete valores basura al vector y por lo tanto 
    //impiden que el codigo de curso se agregue correctamente
    var x = document.getElementById("course-id").options;
    l = x.length;
    s = x.selectedIndex;
    
    if(x[0].value == "0") //Realiza el cambio
    {
        //selCourse = document.getElementById("course-id");
        var cursos = [];
        
        //Recorre todos los cursos y los borra
        for(i = 0; i < l; ++i)
        {
            cursos.push(selCourse.options[0].text);
            selCourse.options.remove(0);
        }
        
        //Agarra todos los cursos y los mete otra vez, pero esta vez con el formato correcto para que el codigo de curso
        //se agregue correctamente.
        for(j = 0; j < l; ++j)
        {
            //Agrega el curso. 
            var tmp = document.createElement("option");
            tmp.value = cursos[j]; //Para que phpcake detecte el valor seleccionado y no el indice
            tmp.text = cursos[j]; //Para que el select despliegue el valor respectivo de la opcion y no un valor vacio
            selCourse.options.add(tmp,j);
        }
    }

    //Dado que se borro y se recreo el select de cursos, es necesario recordar cual fue el valor que habia seleccionado el usuario
    selCourse.selectedIndex = s;
    

}


/**
 Carga el nombre del profesor y del curso según el curso y grupos seleccionados
 * 
 * @author Esteban Rojas
 **/
function save()
{
    //Referencia los selects de grupo y curso respectivamente
    selClass = document.getElementById("class-number");
    selCourse = document.getElementById("course-id");
    
    //Obtiene el valor del curso y grupo seleccionados actualmente
    Course = document.getElementById("c2").options[selCourse.selectedIndex].text;
    Group = selClass.options[selClass.selectedIndex].text;

    //Mete al profesor:
    cursos = document.getElementById("a2").options;
    grupos  = document.getElementById("a1").options;
    nombreCurso = document.getElementById("nc").value;
    
    //cursoActual = selCourse.options[selCourse.selectedIndex].text;
    cursoActual = document.getElementById("c2").options[selCourse.selectedIndex].text;
    grupoActual = selClass.options[selClass.selectedIndex].text;

    for(c = 0;  c < cursos.length; c = c + 1) // Recorre los cursos
    {    
        //Si el curso es el mismo al curso seleccionado, manda el grupo al vector
        
        if(cursoActual.localeCompare(cursos[c].text) == 0)
        {

            if(grupoActual == grupos[c].text)
            {        
                document.getElementById("prof").value = (document.getElementById("a4")[c].text);
            }
        }

    }
    
    //Ahora que se selecciono un curso, ya no es necesario que aparezca esta opcion
    if(selClass.options[(selClass.length-1)].text == "Seleccione un Curso") {
        selClass.options.remove((selClass.length-1));
    }
    
    confirm = document.getElementById("mensajeConfirmacion");
    confirm.innerHTML = "¿Esta seguro que desea solicitar una asistencia al grupo " + grupoActual +" del curso " +cursoActual+ "-" + nombreCurso + "?";

}

// Inicia Daniel Marín
// función inicial 
$(document).ready( function () {            
    byId('another-student-hours').disabled = true;
    byId('another-assistant-hours').disabled = true;
});
/** Función toggleAnother
 * EFE: activa o desactiva los campos de otras horas
 **/
function toggleAnother(){
    if(byId('has-another-hours').checked){
        byId('another-student-hours').disabled = false;
        byId('another-student-hours').required = true;
        byId('another-student-hours').max = 12;
        byId('another-assistant-hours').disabled = false;
        byId('another-assistant-hours').required = true;
        byId('another-assistant-hours').max = 20;
    }else{
        byId('another-student-hours').disabled = true;
        byId('another-student-hours').value = null;
        byId('another-student-hours').required = false;
        byId('another-assistant-hours').disabled = true;
        byId('another-assistant-hours').value = null;
        byId('another-assistant-hours').required = false;
    }
}

/** Función unrequireStudent
 * EFE: activa o desactiva el requerir el campo otras horas estudiante 
 **/
function requireStudent(){
    byId('another-student-hours').required = true;
    if(!byId('another-assistant-hours').value){
        byId('another-assistant-hours').required = false;
    }
    if(20 > 20 - byId('another-student-hours').value){
        console.log('cambio assitant')
        byId('another-assistant-hours').max = 20 - byId('another-student-hours').value;
        if(20-byId('another-student-hours').value<3)byId('another-assistant-hours').value = ''; 
    }else{
        byId('another-assistant-hours').max = 20;
    }
    
}

/** Función unrequireAssitant
 * EFE: activa o desactiva el requerir el campo otras horas asistente
 **/
function requireAssistant(){
    byId('another-assistant-hours').required = true;
    if(!byId('another-student-hours').value){
        byId('another-student-hours').required = false;
    }
    if(12 > 20 - byId('another-assistant-hours').value){
        byId('another-student-hours').max = 20-byId('another-assistant-hours').value;
    }else{
        byId('another-student-hours').max = 12;
    }
    if(byId('another-assistant-hours').value>17){
        byId('another-student-hours').disabled = true;
        byId('another-student-hours').value = null;
    }else{
        byId('another-student-hours').disabled = false;
    }
    
    
}

/** 
 * Se ejecuta cuando el usuario acepta el modal con el mensaje de confirmación.
 * 
 * Función send
 * EFE: habilita los campos de otras horas para enviarlos en el form
 **/
function send(){

    byId('another-student-hours').disabled = false;
    byId('another-assistant-hours').disabled = false;
    // autor: ...
    $('#confirmacion').modal('hide'); 
}

/** Función byId
 * EFE: Función wrapper de getElementById
 * REQ: Id del elemento a obtener.
 * RET: Elemento requerido.
 **/
function byId(id) {
    return document.getElementById(id);
}
//termina Daniel M


/**
 * Oculta el mensaje de confirmar solicitud
 * 
 * @author Esteban Rojas
 */
function cancelarModal()
{
    $('#confirmacion').modal('hide');
}