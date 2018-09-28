create table user ( 
user_id varchar(10) not null, 
name varchar(50) not null, 
lastname1 varchar(50) not null, 
lastname2 varchar(50) null, 
email_ecci varchar(200) not null, 
email_personal varchar(200) not null,
phone varchar(12) null, 
primary key(user_id) ); 

create table student(
id_student varchar(10) not null,
carne varchar(6) not null,
foreign key (id_student) references user(user_id),
primary key(id_student)
);

create table administrative_boss(
id_administrative_boss varchar(10) not null,
foreign key (id_administrative_boss) references user(user_id),
primary key(id_administrative_boss)
);

create table administrative_assistant(
id_administrative_assistant varchar(10) not null,
foreign key (id_administrative_assistant) references user(user_id),
);

create table professor(
id_professor varchar(10) not null,
foreign key (id_professor) references user(user_id),
);
