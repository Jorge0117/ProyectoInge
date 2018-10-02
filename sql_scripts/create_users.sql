create table users ( 
id varchar(10) not null, 
name varchar(50) not null, 
lastname1 varchar(50) not null, 
lastname2 varchar(50) null, 
email_ecci varchar(200) not null, 
email_personal varchar(200) not null,
phone varchar(12) null, 
primary key(id) ); 

create table students(
id_user varchar(10) not null,
carne varchar(6) not null,
foreign key (id_user) references user(id),
primary key(id_user)
);

create table administrative_bosses(
id_user varchar(10) not null,
primary key(id_user),
foreign key (id_user) references user(id)
);

create table administrative_assistants(
id_administrative_assistant varchar(10) not null,
primary key(id_user),
foreign key (id_user) references user(id)
);

create table professors(
id_professor varchar(10) not null,
primary key(id_user),
foreign key (id_user) references user(id)
);
