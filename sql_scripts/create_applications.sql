create table applications (
    application_number int,
    date_submitted datetime not null,
    student_id  varchar(10),
    round_number tinyint not null,
    course_id char(7) not null,
    class_number tinyint not null,
    semester tinyint not null,
    year year not null,
    state ENUM('Pendiente', 'No elegible', 'Elegible', 'Rechazada', 'Aceptada', 'Anulada') not null default 'Pendiente',

    primary key(application_number),
    foreign key(student_id) references users(identification_number),
    foreign key(round_number) references rounds(round_number),
    foreign key(course_id, class_number, semester, year)
        references classes(course_id, class_number, semester, year)
);