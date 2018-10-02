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
id_users varchar(10) not null,
carne varchar(6) not null,
foreign key (id_users) references users(id),
primary key(id_users)
);

create table administrative_bosses(
id_users varchar(10) not null,
primary key(id_users),
foreign key (id_users) references users(id)
);

create table administrative_assistants(
id_users varchar(10) not null,
primary key(id_users),
foreign key (id_users) references users(id)
);

create table professors(
id_users varchar(10) not null,
primary key(id_users),
foreign key (id_users) references users(id)
);
