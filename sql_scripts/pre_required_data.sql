use sistema_control_asistencias;

##Usuario para conectarse a la bd
create user 'asistencias'@'localhost' identified by 'ProyInge1!';
GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON sistema_control_asistencias.* TO 'asistencias'@'localhost';
FLUSH PRIVILEGES;

##Ingresar roles del sistema
insert into roles values('Administrador');
insert into roles values('Estudiante');
insert into roles values('Asistente');
insert into roles values('Profesor');

##Asignar permisos no modificables a los roles
insert into permissions values('Mainpage-index', 'Ingresar a la pagina principal');

insert into permissions_roles values('Mainpage-index', 'Administrador');
insert into permissions_roles values('Mainpage-index', 'Estudiante');
insert into permissions_roles values('Mainpage-index', 'Asistente');
insert into permissions_roles values('Mainpage-index', 'Profesor');

##Solo un administrador puede conceder y revocar permisos
insert into permissions values('Roles-edit', 'Modificar los permisos de los roles');

insert into permissions_roles values('Roles-edit', 'Administrador');

##Permisos modificables: solicitudes
insert into permissions values('Requests-index', 'Listar solicitudes');
insert into permissions values('Requests-view', 'Consultar una solicitud');
insert into permissions values('Requests-review', 'Ingresar a la revision de una solicitud');
insert into permissions values('Requests-reviewFinal', 'Asignar estado final de una solicitud según criterio del profesor');
insert into permissions values('Requests-reviewPreliminary', 'Asignar estado de la solicitud según el cumplimiento de requisitos');
insert into permissions values('Requests-reviewRequirements', 'Revisar los requerimientos de una solicitud');
insert into permissions values('Requests-indexReview', 'Revision final de solicitudes en index');
insert into permissions values('Requests-add', 'Agregar una solicitud');
insert into permissions values('Requests-cancelRequest', 'Cancelar una solicitud');

insert into permissions_roles values('Requests-index', 'Administrador');
insert into permissions_roles values('Requests-view', 'Administrador');
insert into permissions_roles values('Requests-review', 'Administrador');
insert into permissions_roles values('Requests-reviewRequirements', 'Administrador');
insert into permissions_roles values('Requests-reviewPreliminary', 'Administrador');
insert into permissions_roles values('Requests-reviewFinal', 'Administrador');
insert into permissions_roles values('Requests-indexReview', 'Administrador');
insert into permissions_roles values('Requests-cancelRequest', 'Administrador');

insert into permissions_roles values('Requests-index', 'Asistente');
insert into permissions_roles values('Requests-view', 'Asistente');
insert into permissions_roles values('Requests-review', 'Asistente');
insert into permissions_roles values('Requests-reviewRequirements', 'Asistente');

insert into permissions_roles values('Requests-index', 'Estudiante');
insert into permissions_roles values('Requests-view', 'Estudiante');
insert into permissions_roles values('Requests-add', 'Estudiante');

##Cursos-grupos
insert into permissions values('CoursesClassesVw-index', 'Listar cursos');
insert into permissions values('CoursesClassesVw-edit', 'Modificar un curso');
insert into permissions values('CoursesClassesVw-delete', 'Eliminar un curso');
insert into permissions values('CoursesClassesVw-uploadFile', 'Subir archivo con los cursos y grupos del semestre');
insert into permissions values('CoursesClassesVw-addCourse', 'Agregar un curso manualmente');
insert into permissions values('CoursesClassesVw-addClass', 'Agregar un grupo manualmente');
insert into permissions values('CoursesClassesVw-importExcelfile', 'Importar un archivo con clases y cursos');
insert into permissions values('CoursesClassesVw-cancelExcel', 'Cancelar subida de excel');

insert into permissions_roles values('CoursesClassesVw-index', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-edit', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-delete', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-uploadFile', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-addCourse', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-addClass', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-importExcelfile', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-cancelExcel', 'Administrador');

##Requisitos
insert into permissions values('Requirements-index', 'Listar requerimientos');
insert into permissions values('Requirements-add', 'Agregar un requisito');
insert into permissions values('Requirements-delete', 'Eliminar un requisito');
insert into permissions values('Requirements-edit', 'Modificar un requerimiento');


insert into permissions_roles values('Requirements-index', 'Administrador');
insert into permissions_roles values('Requirements-add', 'Administrador');
insert into permissions_roles values('Requirements-delete', 'Administrador');
insert into permissions_roles values('Requirements-edit', 'Administrador');

##Rondas
insert into permissions values('Rounds-index', 'Listar rondas');
insert into permissions values('Rounds-add', 'Agregar un ronda');
insert into permissions values('Rounds-edit', 'Modificar una ronda');
insert into permissions values('Rounds-delete', 'Eliminar una ronda');

insert into permissions_roles values('Rounds-index', 'Administrador');
insert into permissions_roles values('Rounds-add', 'Administrador');
insert into permissions_roles values('Rounds-edit', 'Administrador');
insert into permissions_roles values('Rounds-delete', 'Administrador');


##Usuarios
insert into permissions values('Users-index', 'Listar usuarios');

insert into permissions values('Users-add', 'Agregar un usuario manualmente');
insert into permissions values('Users-delete', 'Eliminar un usuario');
insert into permissions values('Users-edit', 'Modificar un usuario');
insert into permissions values('Users-view', 'Consultar un usuario');

insert into permissions_roles values('Users-index', 'Administrador');
insert into permissions_roles values('Users-add', 'Administrador');
insert into permissions_roles values('Users-delete', 'Administrador');
insert into permissions_roles values('Users-edit', 'Administrador');
insert into permissions_roles values('Users-view', 'Administrador');


##Historicos
insert into permissions values('Reports-professorAssistants', 'Historico de asistentes de un profesor');
insert into permissions values('Reports-studentRequests', 'Historico de asistencias de un estudiante');
insert into permissions values('Reports-reportsAdmin', 'Historico de asistencias en general');


insert into permissions_roles values('Reports-professorAssistants', 'Profesor');
insert into permissions_roles values('Reports-studentRequests', 'Estudiante');
insert into permissions_roles values('Reports-reportsAdmin', 'Administrador');


insert into users
values ('100010001','Nacional', 'Estudiante', 'Estudiante', 'Estudiante', 'estudiante', 'estudiante@mail.com', '80008000', 'Estudiante');

insert into students values ('100010001','b00000',10);

insert into users
values ('100010002','Nacional', 'Asistente', 'Asistente', 'Asistente', 'asistente', 'asistente@mail.com', '80008000', 'Asistente');

insert into users
values ('000000000','Nacional', 'Administrador', 'Administrador', 'Administrador', 'administrador', 'administrador@mail.com', '00000000', 'Administrador');

insert into users
values ('10001004','Nacional', 'Profesor', 'Profesor', 'Profesor', 'profesor', 'profesor@mail.com', '80008000', 'Profesor');

## Requisitos actuales
Insert into requirements values('Matricular un mínimo de 9 créditos en el ciclo lectivo en el cual está designado','Obligatorio',1,'Ambos');
Insert into requirements values('Haber aprobado el curso en el cual va a prestar la colaboración','Obligatorio',2,'Ambos');
Insert into requirements values('Primer año de carrera aprobado','Obligatorio',3,'Estudiante');
Insert into requirements values('Tener un promedio ponderado anual igual o superior a 7,5','Opcional',4,'Estudiante');
Insert into requirements values('Haber aprobado el 50% del plan de estudios ','Obligatorio',5,'Asistente');
Insert into requirements values('Tener un promedio ponderado anual igual o superior a 8,0','Opcional',6,'Asistente');