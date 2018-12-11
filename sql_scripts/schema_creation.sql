CREATE SCHEMA `sistema_control_asistencias` ;

USE sistema_control_asistencias;

#---------------------------------------------------------------------------------------------------------------
# Tables (DDL)

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `file_dir` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `permissions` (
  `permission_id` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `roles` (
  `role_id` varchar(24) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `permissions_roles` (
  `permission_id` varchar(50) NOT NULL,
  `role_id` varchar(24) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permissions_roles_ibfk_2` (`permission_id`),
  CONSTRAINT `permissions_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permissions_roles_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `identification_number` varchar(20) NOT NULL,
  `identification_type` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname1` varchar(50) NOT NULL,
  `lastname2` varchar(50) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email_personal` varchar(200) NOT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `role_id` varchar(24) NOT NULL,
  PRIMARY KEY (`identification_number`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `administrative_assistants` (
  `user_id` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `administrative_assistants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`identification_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `administrative_bosses` (
  `user_id` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `administrative_bosses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`identification_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `professors` (
  `user_id` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `professors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`identification_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `students` (
  `user_id` varchar(20) NOT NULL,
  `carne` varchar(6) NOT NULL,
  `average` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`identification_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `courses` (
  `code` char(7) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  ##`credits` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `classes` (
  `course_id` char(7) NOT NULL,
  `class_number` tinyint(4) NOT NULL,
  `semester` tinyint(4) NOT NULL,
  `year` year(4) NOT NULL,
  `state` tinyint(1) DEFAULT NULL,
  `professor_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`course_id`,`class_number`,`semester`,`year`),
  KEY `classes_ibfk_2` (`professor_id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `requirements` (
  `description` varchar(250) NOT NULL,
  `type` enum('Obligatorio','Opcional') NOT NULL,
  `requirement_number` int(11) NOT NULL AUTO_INCREMENT,
  `hour_type` enum('Estudiante','Asistente','Ambos') NOT NULL,
  PRIMARY KEY (`requirement_number`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

CREATE TABLE `rounds` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `round_number` enum('1','2','3') NOT NULL,
  `semester` enum('I','II') NOT NULL,
  `year` year(4) NOT NULL,
  `total_student_hours` smallint(6) NOT NULL,
  `total_student_hours_d` smallint(6) NOT NULL,
  `total_assistant_hours` smallint(6) NOT NULL,
  `actual_student_hours` smallint(6) NOT NULL,
  `actual_student_hours_d` smallint(6) NOT NULL,
  `actual_assistant_hours` smallint(6) NOT NULL,
  PRIMARY KEY (`start_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='student_hours : horas estudiante de la ECCI\nstudent_hours_d : horas estudiante de Docencia\nassistant_hours :  horas asistente de la ECCI\n';

CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `round_start` date NOT NULL,
  `reception_date` date NOT NULL,
  `class_year` year(4) NOT NULL,
  `course_id` char(7) NOT NULL,
  `class_semester` tinyint(4) NOT NULL,
  `class_number` tinyint(4) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `status` char(1) NOT NULL,
  `another_assistant_hours` tinyint(4) NOT NULL,
  `another_student_hours` tinyint(4) NOT NULL,
  `has_another_hours` tinyint(1) NOT NULL,
  `first_time` tinyint(1) NOT NULL,
  `wants_student_hours` tinyint(1) DEFAULT NULL,
  `wants_assistant_hours` tinyint(1) DEFAULT NULL,
  `stage` tinyint(3) DEFAULT '1',
  `scope` enum('n','e','a','i','c','b') DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `pk_round_start` (`round_start`),
  CONSTRAINT `fk_round_start` FOREIGN KEY (`course_id`,`class_number`,`class_semester`,`class_year`) REFERENCES `classes` (`course_id`,`class_number`,`semester`,`year`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT `fk_rounds` FOREIGN KEY (`round_start`) REFERENCES `rounds` (`start_date`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=400 DEFAULT CHARSET=latin1;

CREATE TABLE `requests_requirements` (
  `requirement_number` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `state` char(1) NOT NULL DEFAULT 'p',
  `acepted_inopia` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`requirement_number`,`request_id`),
  KEY `requests_requirements_ibfk_1` (`request_id`),
  CONSTRAINT `requests_requirements_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `requests_requirements_ibfk_2` FOREIGN KEY (`requirement_number`) REFERENCES `requirements` (`requirement_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `approved_requests` (
  `request_id` int(11) NOT NULL,
  `hour_type` enum('HAE','HEE','HED') NOT NULL,
  `hour_ammount` tinyint(4) NOT NULL,
  PRIMARY KEY (`request_id`),
  CONSTRAINT `approved_requests_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#TO_DO: REJECTED_REQUEST

CREATE TABLE `canceled_requests` (
  `request_id` int(11) NOT NULL,
  `justification` varchar(250) NOT NULL,
  PRIMARY KEY (`request_id`),
  CONSTRAINT `canceled_requests_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



#---------------------------------------------------------------------------------------------------------------
# Views (DDL)

CREATE VIEW `sistema_control_asistencias`.`courses_classes_vw` AS
  select `cr`.`code` AS `Sigla`,
    `cr`.`name` AS `Curso`,
    concat(`u`.`name`,' ',`u`.`lastname1`,' ',`u`.`lastname2`) AS `Profesor`,
    `cl`.`class_number` AS `Grupo`,
    `cl`.`semester` AS `Semestre`,
    `cl`.`year` AS `Año` 
    from
    (
      (
      (`classes` `cl` join `courses` `cr`) 
        join `professors` `p`
    ) 
    join `users` `u`
  ) 
  where (
    (`cl`.`course_id` = `cr`.`code`) 
        and (`cl`.`professor_id` = `p`.`user_id`) 
        and (`p`.`user_id` = `u`.`identification_number`) 
        and (`cl`.`state` = 1)
    );
    
CREATE VIEW `info_requests` AS 
  select `r`.`id` AS `id`,
    `r`.`reception_date` AS `fecha`,
    `r`.`student_id` AS `cedula`,
    `st`.`carne` AS `carne`,
    concat(`u`.`name`,' ',`u`.`lastname1`,' ',`u`.`lastname2`) AS `nombre`,
    `st`.`average` AS `promedio`,
    `r`.`class_year` AS `anno`,
    `r`.`class_semester` AS `semestre`,
    `r`.`course_id` AS `curso`,
    `r`.`class_number` AS `grupo`,
    `r`.`round_start` AS `inicio`,
    `ro`.`round_number` AS `ronda`,
    `r`.`status` AS `estado`,
    `r`.`has_another_hours` AS `otras_horas`,
    `c`.`professor_id` AS `id_prof` 
    from (
    (
      (
        (`requests` `r` join `rounds` `ro`) 
                join `students` `st`
      ) 
            join `users` `u`
    ) 
    join `classes` `c`
    ) 
    where (
      (`r`.`round_start` = `ro`.`start_date`) 
      and (`st`.`user_id` = `r`.`student_id`) 
      and (`st`.`user_id` = `u`.`identification_number`) 
      and (`c`.`course_id` = `r`.`course_id`) 
      and (`c`.`year` = `r`.`class_year`) 
      and (`c`.`semester` = `r`.`class_semester`) 
      and (`c`.`class_number` = `r`.`class_number`)
        );
        
CREATE VIEW `professor_assistants` AS 
  select `r`.`id` AS `id`,
    `st`.`carne` AS `carne`,
        concat(`u`.`name`,' ',`u`.`lastname1`,' ',`u`.`lastname2`) AS `nombre`,
        `r`.`class_year` AS `anno`,
        `r`.`id` AS `id_request`,
        `r`.`class_semester` AS `semestre`,
        `r`.`course_id` AS `curso`,
        `r`.`class_number` AS `grupo`,
        `ar`.`hour_type` AS `tipo_hora`,
        `ar`.`hour_ammount` AS `hour_ammount`,
        `c`.`professor_id` AS `id_prof`,
        `cu`.`name` AS `course_name`,
        `st`.`user_id` AS `id_student` 
        from (
      (
        (
          (
            (`requests` `r` join `students` `st`) 
                        join `users` `u`
          ) 
                    join `courses` `cu`
        ) join `approved_requests` `ar`
      ) 
            join `classes` `c`
    ) 
        where (
      (`st`.`user_id` = `r`.`student_id`)
            and (`st`.`user_id` = `u`.`identification_number`) 
            and (`r`.`id` = `ar`.`request_id`) 
            and (`c`.`course_id` = `r`.`course_id`) 
            and (`c`.`year` = `r`.`class_year`) 
            and (`c`.`course_id` = `cu`.`code`) 
            and (`c`.`semester` = `r`.`class_semester`) 
            and (`c`.`class_number` = `r`.`class_number`)
    );

#---------------------------------------------------------------------------------------------------------------
# Stored procedures

DELIMITER $$
CREATE PROCEDURE `addClass`(id char(7), num tinyint, sem tinyint, year int, state tinyint, profId varchar(20))
begin
  insert into classes (course_id, class_number, semester, year, state, professor_id)
    values (id, num, sem, year, state, profId);
end$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `addCourse`(codeC varchar(7), nameC varchar(255))
BEGIN
  insert into courses (code, name) values (codeC, nameC);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `approve_request`(IN id INT, IN h_type VARCHAR(3), IN cnt TINYINT)
BEGIN
  SET @s_date = (SELECT round_start FROM requests as r WHERE r.id = id);
  SET @h_ammount = (SELECT hour_ammount from approved_requests where request_id = id);
  SET @h_type = (SELECT hour_type from approved_requests where request_id = id);
    IF(SELECT @h_type IS NOT NULL) THEN
    IF(h_type = @h_type) THEN 
      SET @h_ammount = cnt-IFNULL(@h_ammount,0);
      IF(h_type = 'HEE')THEN
        UPDATE rounds 
        SET actual_student_hours = actual_student_hours + @h_ammount
        WHERE start_date = @s_date;
      ELSEIF(h_type = 'HED')THEN
        UPDATE rounds 
        SET actual_student_hours_d = actual_student_hours_d + @h_ammount
        WHERE start_date = @s_date;
      ELSE
        UPDATE rounds 
        SET actual_assistant_hours = actual_assistant_hours + @h_ammount
        WHERE start_date = @s_date;
      END IF;
            UPDATE approved_requests 
      SET hour_ammount = hour_ammount + @h_ammount
      WHERE request_id = id;
    ELSE
      IF(h_type = 'HEE')THEN
        IF(@h_type = 'HED')THEN
          UPDATE rounds 
          SET actual_student_hours_d = actual_student_hours_d - @h_ammount,
          actual_student_hours = actual_student_hours + cnt
          WHERE start_date = @s_date;
        ELSE
          UPDATE rounds 
          SET actual_assistant_hours = actual_assistant_hours - @h_ammount,
          actual_student_hours = actual_student_hours + cnt
          WHERE start_date = @s_date;
                END IF;
      ELSEIF(h_type = 'HED')THEN
        IF(@h_type = 'HEE')THEN
          UPDATE rounds 
          SET actual_student_hours = actual_student_hours - @h_ammount,
          actual_student_hours_d = actual_student_hours_d + cnt
          WHERE start_date = @s_date;
        ELSE
          UPDATE rounds 
          SET actual_assistant_hours = actual_assistant_hours - @h_ammount,
          actual_student_hours_d = actual_student_hours_d + cnt
          WHERE start_date = @s_date;
                END IF;
      ELSE
        IF(@h_type = 'HEE')THEN
          UPDATE rounds 
          SET actual_student_hours = actual_student_hours - @h_ammount,
          actual_assistant_hours = actual_assistant_hours + cnt 
          WHERE start_date = @s_date;
        ELSE
          UPDATE rounds 
          SET actual_student_hours_d = actual_student_hours_d - @h_ammount,
          actual_assistant_hours = actual_assistant_hours + cnt 
          WHERE start_date = @s_date;
                END IF;
      END IF;
      UPDATE approved_requests 
      SET hour_type = h_type, hour_ammount = cnt
      WHERE request_id = id;
    END IF;
  ELSE
    IF(h_type = 'HEE')THEN
      UPDATE rounds 
      SET actual_student_hours = actual_student_hours + cnt
      WHERE start_date = @s_date;
    ELSEIF(h_type = 'HED')THEN
      UPDATE rounds 
      SET actual_student_hours_d = actual_student_hours_d + cnt
      WHERE start_date = @s_date;
    ELSE
      UPDATE rounds 
      SET actual_assistant_hours = actual_assistant_hours + cnt 
      WHERE start_date = @s_date;
    END IF;
        INSERT INTO approved_requests VALUES (id,h_type,cnt);
    END IF;  
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `check_rounds_on_insert`(
        IN round_n TINYINT, 
        IN sem TINYINT, 
        IN start_d DATETIME, 
                IN end_d DATETIME, 
                IN y YEAR(4),
                IN tsh SMALLINT,
                IN tdh SMALLINT,
                IN tah SMALLINT,
                IN ash SMALLINT,
                IN adh SMALLINT,
                IN aah SMALLINT,
                IN old_tsh SMALLINT,
                IN old_tdh SMALLINT,
                IN old_tah SMALLINT,
                IN old_ash SMALLINT,
                IN old_adh SMALLINT,
                IN old_aah SMALLINT)
BEGIN
                
    IF (round_n > 3) OR (round_n < 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.round_number failed';
    END IF;
    IF (sem > 2) OR (sem < 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.semester failed';
    END IF;
     IF (start_d <  IFNULL((SELECT MAX(end_date) FROM rounds ),(SELECT SUBDATE(DATE(NOW()),1)))) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'check constraint on rounds.start_date failed';
    END IF;
  IF (end_d < start_d) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.end_date failed';
    END IF;
    IF (y <> YEAR(start_d) && MONTH(start_d) <> 12 || y <> YEAR(start_d)+1 && MONTH(start_d) = 12) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.year failed';
    END IF;
    IF ((round_n = 1) && (tsh < 0) || (round_n <> 1) && (tsh < old_tsh-old_ash) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_student_hours failed';
    END IF;
    IF ((round_n = 1) && (tdh < 0) || (round_n <> 1) && (tdh < old_tdh-old_adh) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_student_hours_d failed';
    END IF;
    IF ((round_n = 1) && (tah < 0) || (round_n <> 1) && (tah < old_tah-old_aah) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_assitant_hours failed';
    END IF;
    IF (ash <> 0) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours failed';
    END IF;
    IF (adh <> 0) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours_d failed';
    END IF;
    IF (aah <> 0) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_assistant_hours failed';
    END IF;
    
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `check_rounds_on_update`(
        IN round_n TINYINT, 
        IN sem TINYINT, 
        IN start_d DATETIME, 
                IN end_d DATETIME, 
                IN y YEAR(4),
                IN old_start_d DATETIME,
                IN tsh SMALLINT,
                IN tdh SMALLINT,
                IN tah SMALLINT,
                IN ash SMALLINT,
                IN adh SMALLINT,
                IN aah SMALLINT,
                IN old_ash SMALLINT,
                IN old_adh SMALLINT,
                IN old_aah SMALLINT)
BEGIN
                
    IF (round_n > 3) OR (round_n < 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.round_number failed';
    END IF;
    IF (sem > 2) OR (sem < 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.semester failed';
    END IF;
  IF (start_d <  IFNULL((SELECT MAX(end_date) FROM rounds WHERE end_date < end_d ),(SELECT DATE(SUBDATE(NOW(),10)))) AND start_d != old_start_d) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'check constraint on rounds.start_date failed';
    END IF;
  IF (end_d < start_d) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.end_date failed';
    END IF;
    IF (y <> YEAR(start_d) && MONTH(start_d) <> 12 || y <> YEAR(start_d)+1 && MONTH(start_d) = 12) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.year failed';
    END IF;
  IF (tsh < 0)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_student_hours failed';
    END IF;
    IF (tdh < 0) || (tdh < adh)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_student_hours_d failed';
    END IF;
    IF (tah < 0) || (tah < aah)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_assitant_hours failed';
    END IF;
    IF (ash < 0)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours failed';
    END IF;
    IF (adh < 0)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours_d failed';
    END IF;
    IF (aah < 0)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_assitant_hours failed';
    END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE `decline_request`(IN id INT)
BEGIN
  SET @s_date = (SELECT round_start FROM requests as r WHERE r.id = id);
  SET @h_ammount = (SELECT hour_ammount from approved_requests where request_id = id);
  SET @h_type = (SELECT hour_type from approved_requests where request_id = id);
    IF(SELECT @h_type IS NOT NULL) THEN
    IF(@h_type = 'HEE')THEN
      UPDATE rounds 
      SET actual_student_hours = actual_student_hours - @h_ammount
      WHERE start_date = @s_date;
    ELSEIF(@h_type = 'HED')THEN
      UPDATE rounds 
      SET actual_student_hours_d = actual_student_hours_d - @h_ammount
      WHERE start_date = @s_date;
    ELSE
      UPDATE rounds 
      SET actual_assistant_hours = actual_assistant_hours - @h_ammount
      WHERE start_date = @s_date;
    END IF;
    delete from approved_requests where request_id = id;
    END IF;  
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `delete_class`(IN 
  code       CHAR(7),
  class_number  TINYINT(4),
    semester    TINYINT(4),
    year      YEAR(4)
)
BEGIN
  DELETE FROM classes 
  WHERE   course_id       = code
  AND   class_number    = class_number
  AND   semester        = semester
  AND   year            = year;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `delete_round`(IN start_d VARCHAR(10))
BEGIN
    IF (start_d < DATE_ADD(DATE(NOW()), INTERVAL -1 DAY))THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'delete round failed';
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `insert_round`(
  IN start_d VARCHAR(10),
    IN end_d VARCHAR(10),
    IN tsh SMALLINT,
    IN tdh SMALLINT,
    IN tah SMALLINT
)
BEGIN
  
    -- Calcula el año y el mes según la fecha inicial
  SET @year = YEAR(start_d);
  SET @month = MONTH(start_d);
    IF(@month = 12) THEN
    SET @year = @year+1;
    END IF;
    
     -- Calcula el semestre en base al mes de la ronda
    SET @semester = NULL;
    IF(@month=12 OR @month<7) THEN
    SET @semester = 'I';
  ELSEIF @month>=7 THEN
    SET @semester = 'II';
    END IF;
    
    -- Recupera últimos datos en la tabla
    SET @last_start_date = (SELECT MAX(start_date) FROM rounds);
  SET @last_semester = (SELECT MAX(semester) FROM rounds WHERE start_date = @last_start_date);
    SET @last_year = (SELECT MAX(year) FROM rounds WHERE start_date = @last_start_date);
  
    -- Calcula el número de la ronda
    SET @round = IFNULL((SELECT MAX(round_number) FROM rounds WHERE start_date = @last_start_date ),0);
    IF @semester <> @last_semester OR @year <> @last_year THEN
    SET @round = 0;
  END IF;
    SET @round = @round+1;
    
    -- Inicia insertar ronda
    INSERT INTO rounds VALUES(start_d,end_d,@round,@semester,@year,tsh,tdh,tah,0,0,0);
    
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `requirement_association`(in requirementNumber int, in requestId int)
BEGIN

  INSERT INTO requestsrequirements(requirement_number,request_id)
    VALUES (requirementNumber,requestId);
    
  END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `save_request`(IN st VARCHAR(20), IN ci char(7), IN cai char(7), IN ash tinyint, aah tinyInt, ft bool, hah bool )
BEGIN
DELETE FROM requests_backup WHERE student_id = st;
INSERT INTO requests_backup(student_id, course_id, class_id, another_student_hours, another_assistant_hours, first_time, has_another_hours  ) 
VALUES (st,ci,cai, ash, aah, ft, hah);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `update_round`(
  IN start_d VARCHAR(10),
    IN end_d VARCHAR(10),
    IN old_start_d VARCHAR(10),
    IN tsh SMALLINT,
    IN tdh SMALLINT,
    IN tah SMALLINT
)
BEGIN
  -- Calcula el año y el mes según la fecha inicial
  SET @year = YEAR(start_d);
  SET @month = MONTH(start_d);
  IF(@month = 12) THEN
    SET @year = @year+1;
    END IF;
    
    -- Calcula el semestre en base al mes de la ronda
    SET @semester = NULL;
    IF(@month = 12 OR @month < 7) THEN
    SET @semester = 'I';
  ELSEIF @month >= 7 THEN
    SET @semester = 'II';
    END IF;
    
  -- Recupera datos antiguos
  SET @old_semester = (SELECT semester FROM rounds WHERE start_date = old_start_d);
    SET @old_year = (SELECT year FROM rounds WHERE start_date = old_start_d);
    
    -- Calcula el número de la ronda
  SET @round = (SELECT round_number FROM rounds WHERE start_date = old_start_d);
    IF @semester <> @old_semester OR @year <> @old_year THEN
    SET @round = 1;
  END IF;
    
    -- Inicia el update
    UPDATE rounds SET 
    start_date = start_d, 
        round_number = @round, 
        semester = @semester, 
        year = @year, 
        end_date = end_d, 
        total_student_hours = tsh,
        total_student_hours_d = tdh,
        total_assistant_hours = tah
    WHERE start_date = old_start_d;
END$$
DELIMITER ;
#---------------------------------------------------------------------------------------------------------------
# Triggers

DELIMITER $$
CREATE TRIGGER assign_requirements AFTER INSERT ON requests
FOR EACH ROW
INSERT INTO requests_requirements(requirement_number, request_id) 
(SELECT r.requirement_number,NEW.id  from requirements r )
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `requests_AFTER_UPDATE` AFTER UPDATE ON `requests` FOR EACH ROW
BEGIN
  IF(new.id = old.id && (new.status <> 'a'&& new.status <> 'c') && old.status = 'a'||old.status = 'c') THEN
    call decline_request(new.id);
  END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER rounds_before_insert BEFORE INSERT ON rounds FOR EACH ROW 
BEGIN
  SET @last_start_date = (SELECT MAX(start_date) FROM rounds);
    CALL check_rounds_on_insert(
    NEW.round_number,
        NEW.semester,
        NEW.start_date,
        NEW.end_date,
        NEW.year,
        NEW.total_student_hours,
        NEW.total_student_hours_d,
        NEW.total_assistant_hours,
        NEW.actual_student_hours,
        NEW.actual_student_hours_d,
        NEW.actual_assistant_hours,
        (SELECT total_student_hours FROM rounds WHERE start_date = @last_start_date),
        (SELECT total_student_hours_d FROM rounds WHERE start_date = @last_start_date),
        (SELECT total_assistant_hours FROM rounds WHERE start_date = @last_start_date),
        (SELECT actual_student_hours FROM rounds WHERE start_date = @last_start_date),
        (SELECT actual_student_hours_d FROM rounds WHERE start_date = @last_start_date),
        (SELECT actual_assistant_hours FROM rounds WHERE start_date = @last_start_date)
  );
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER rounds_before_update BEFORE UPDATE ON rounds FOR EACH ROW
BEGIN
    CALL check_rounds_on_update(
    NEW.round_number,
        NEW.semester,
        NEW.start_date,
        NEW.end_date,
        NEW.year,
        OLD.start_date,
    NEW.total_student_hours,
        NEW.total_student_hours_d,
    NEW.total_assistant_hours,
    NEW.actual_student_hours,
        NEW.actual_student_hours_d,
    NEW.actual_assistant_hours,
    OLD.actual_student_hours,
        OLD.actual_student_hours_d,
    OLD.actual_assistant_hours
  );
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER rounds_before_delete BEFORE DELETE ON rounds FOR EACH ROW 
BEGIN
    CALL delete_round(OLD.start_date);
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER restart AFTER INSERT ON rounds FOR EACH ROW 
BEGIN
  IF NEW.round_number = 1 THEN
    update students set average = 0;
    delete from requests where status <> 'a' AND status <> 'c';
  END IF;
END
DELIMITER ;

DELIMITER $$
CREATE TRIGGER users_BEFORE_DELETE BEFORE DELETE ON users FOR EACH ROW
BEGIN
  IF OLD.role_id = 'Administrador' THEN 
    SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on user.role_id failed: usuarios con rol Administrador no se pueden borrar';
  END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER add_user AFTER INSERT ON users
FOR EACH ROW 
BEGIN
  IF NEW.role_id = 'Profesor' THEN
    INSERT INTO professors 
        SET user_id = NEW.identification_number;
    ELSEIF NEW.role_id = 'Asistente' THEN
    INSERT INTO administrative_assistants 
        SET user_id = NEW.identification_number;
    ELSEIF NEW.role_id = 'Administrador' THEN
    INSERT INTO administrative_bosses 
        SET user_id = NEW.identification_number;
  END IF;
END $$
DELIMITER ;
