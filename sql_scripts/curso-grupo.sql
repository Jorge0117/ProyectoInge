create table courses (
    id				char(7),
    name			varchar(255),
    credits			tinyint,
    
    primary key(id)
);

create table classes (
	courses_id		char(7),
    class_number	tinyint,
    semester		tinyint,
    year			year,
    state			bool,
    
    primary key(courses_id),
    foreign key(courses_id) references courses(id)
)