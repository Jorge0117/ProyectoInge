drop table approvedrequests;
drop table requests;


CREATE TABLE `proyecto_inge`.`requests` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `round_number` INT NOT NULL,
  `round_semester` INT NOT NULL,
  `round_year` INT NOT NULL,
  `reception_date` DATETIME NOT NULL,
  `class_year` YEAR NOT NULL,
  `course_id`  char(7) NOT NULL,
  `class_semester`   tinyint NOT NULL,
  `class_number` tinyint NOT NULL,
  `student_id` varchar(20) NOT NULL, 
  `status` CHAR NOT NULL,
  `another_assistant_hours` tinyint NOT NULL,
  `another_student_hours` tinyint NOT NULL,
  PRIMARY KEY (`id`)
  FOREIGN KEY(course_id,class_number,class_semester,class_year) references classes(course_id,class_number,semester,year),
  FOREIGN KEY(student_id) references students(user_id));
  /*Reservado para FOREIGN KEY de Rondas*/
  
CREATE TABLE `proyecto_inge`.`approvedrequests` (
  `request_id` INT NOT NULL,
  `assistant_hours` TINYINT NOT NULL,
  `student_hours` TINYINT NOT NULL,
  PRIMARY KEY (`request_id`),
foreign key (request_id) references requests(id));

CREATE TABLE `proyecto_inge`.`requests_backup` (
  `student_id` VARCHAR(20) NOT NULL,
  `course_id` CHAR(7) NULL,
  `class_id` CHAR(7) NULL,
  `requests_backupcol` VARCHAR(45) NULL,
  `another_student_hours` TINYINT NULL,
  `another_assistant_hours` VARCHAR(45) NULL,
  PRIMARY KEY (`student_id`));



  CREATE TABLE `proyecto_inge`.`requestsrequirements` (
  `requirement_number` INT NOT NULL,
  `request_id` INT NOT NULL,
  PRIMARY KEY (`requirement_number`, `request_id`),
  FOREIGN KEY(request_id) REFERENCES requests(id),
  FOREIGN KEY(requirement_number) REFERENCES requirements(requirement_number));






