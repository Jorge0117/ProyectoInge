
-- Todos los nombres y atributos son en minúsculas
-- Los nombres de las tablas son en plural
-- Los nombres de los atributos son en singular
create table users ( 
    identification_number varchar(10) not null, 
    name varchar(50) not null, 
    lastname1 varchar(50) not null, 
    lastname2 varchar(50) null, 
    email_ecci varchar(200) not null, 
    email_personal varchar(200) not null,
    phone varchar(12) null, 
    role_id varchar(24) not null, -- al mapear relaciones 1 a N ó 1 a 1 el nombre del atributo debería ser el nombre de la tabla que referencia en singular + _id 
    primary key(identification_number),
    foreign key(role_id) references roles(role_id)
); 

create table students(
    user_id varchar(10) not null, -- aquí de nuevo por ser una relacion 1 a 1 el nombre del atributo es el de la tabla a la que referencia en singular + _id
    carne varchar(6) not null,
    foreign key (user_id) references users(identification_number),
    primary key(user_id)
);

-- FIXME:
-- Corregir el resto
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
