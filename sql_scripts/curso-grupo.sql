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

