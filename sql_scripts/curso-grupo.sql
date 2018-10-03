create table courses (
    id				char(7),
    name			varchar(255),
    credits			tinyint,
    
    primary key(id)
);

create table classes (
	course_id		char(7),
    id          	tinyint,
    semester		tinyint,
    year			year,
    state			bool,
    
    primary key(courses_id,id),
    foreign key(courses_id) references courses(id)
)
