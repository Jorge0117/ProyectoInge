create table courses (
    code               char(7),
    name               varchar(255),
    credits            tinyint,
    primary key(code)
);

create table classes (
    course_id       char(7),
    class_number    tinyint,
    semester        tinyint,
    year            year,
    state           bool,
    primary key(course_id, class_number, semester, year),
    foreign key(course_id) references courses(code)
)

CREATE VIEW courses_classes_vw AS
	SELECT CR.code AS 'Sigla', CR.name AS 'Curso', CL.class_number AS 'Grupo', U.name + U.lastname1 +U.lastname2 AS 'Profesor', CL.semester AS 'Semestre', CL.year AS 'Año'
    FROM courses CR, classes CL, professors P, users as U
    WHERE CR.code = CL.course_id
    AND P.user_id = CL.professor_id
    AND P.user_id = U.identification_number
