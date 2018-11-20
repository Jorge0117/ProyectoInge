##Ingresar roles del sistema
insert into roles values('Administrador');
insert into roles values('Estudiante');
insert into roles values('Asistente');
insert into roles values('Profesor');

##Ingresar permisos no modificables del sistema
insert into permissions values('Mainpage-index', 'Ingresar a la pagina principal');
insert into permissions values('Roles-edit', 'Modificar los permisos de los roles');

##Asignar permisos no modificables a los roles
insert into permissions_roles values('Mainpage-index', 'Administrador');
insert into permissions_roles values('Mainpage-index', 'Estudiante');
insert into permissions_roles values('Mainpage-index', 'Asistente');
insert into permissions_roles values('Mainpage-index', 'Profesor');

##Solo un administrador puede conceder y revocar permisos
insert into permissions_roles values('Roles-edit', 'Administrador');

##Permisos modificables: solicitudes
insert into permissions values('Requests-index', 'Listar solicitudes');
insert into permissions values('Requests-view', 'Consultar una solicitud');
insert into permissions values('Requests-review', 'Ingresar a la revision de una solicitud');
insert into permissions values('Requests-reviewFinal', 'Asignar estado final de una solicitud según criterio del profesor');
insert into permissions values('Requests-reviewPreliminary', 'Asignar estado de la solicitud según el cumplimiento de requisitos');
insert into permissions values('Requests-reviewRequirements', 'Revisar los requerimientos de una solicitud');
insert into permissions values('Requests-indexReview', 'Revision final de solicitudes en index');

insert into permissions_roles values('Requests-index', 'Administrador');
insert into permissions_roles values('Requests-view', 'Administrador');
insert into permissions_roles values('Requests-review', 'Administrador');
insert into permissions_roles values('Requests-reviewFinal', 'Administrador');
insert into permissions_roles values('Requests-reviewPreliminary', 'Administrador');
insert into permissions_roles values('Requests-reviewRequirements', 'Administrador');
insert into permissions_roles values('Requests-indexReview', 'Administrador');


##Cursos-grupos
insert into permissions values('CoursesClassesVw-index', 'Listar cursos');
insert into permissions values('CoursesClassesVw-edit', 'Modificar un curso');
insert into permissions values('CoursesClassesVw-delete', 'Eliminar un curso');
insert into permissions values('CoursesClassesVw-uploadFile', 'Subir archivo con los cursos y grupos del semestre');
insert into permissions values('CoursesClassesVw-addCourse', 'Agregar un curso manualmente');
insert into permissions values('CoursesClassesVw-addClass', 'Agregar un grupo manualmente');
insert into permissions values('CoursesClassesVw-importExcelfile', 'Importar un archivo con clases y cursos');

insert into permissions_roles values('CoursesClassesVw-index', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-edit', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-delete', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-uploadFile', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-addCourse', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-addClass', 'Administrador');
insert into permissions_roles values('CoursesClassesVw-importExcelfile', 'Administrador');

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

insert into permissions_roles values('Rounds-index', 'Administrador');

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






##insert into permissions values();













