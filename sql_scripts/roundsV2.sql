CREATE TABLE `rounds` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `round_number` enum('1','2','3') NOT NULL,
  `semester` enum('I','II') NOT NULL,
  `year` year(4) NOT NULL,
  `total_student_hours` smallint(6) NOT NULL,
  `total_assistant_hours` smallint(6) NOT NULL,
  `actual_student_hours` smallint(6) NOT NULL,
  `actual_assistant_hours` smallint(6) NOT NULL,
  PRIMARY KEY (`start_date`)
)

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
USE `proyecto_inge`;
DROP procedure IF EXISTS `check_rounds_on_insert`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE PROCEDURE `check_rounds_on_insert`(
				IN round_n TINYINT, 
				IN sem TINYINT, 
				IN start_d DATETIME, 
                IN end_d DATETIME, 
                IN y YEAR(4),
                IN tsh SMALLINT,
                IN tah SMALLINT,
                IN ash SMALLINT,
                IN aah SMALLINT,
				IN old_tsh SMALLINT,
                IN old_tah SMALLINT,
                IN old_ash SMALLINT,
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
    IF (start_d <  IFNULL((SELECT MAX(end_date) FROM rounds ),(SELECT SUBDATE(NOW(),1)))) THEN
		SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'check constraint on rounds.start_date failed';
    END IF;
	IF (end_d <= start_d) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.end_date failed';
    END IF;
    IF (y <> YEAR(start_d) && MONTH(start_d) <> 12 || y <> YEAR(start_d)+1 && MONTH(start_d) = 12) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.year failed';
    END IF;
    IF ((round_n = 1) && (tsh <= 0) || (round_n <> 1) && (tsh <> old_tsh) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_student_hours failed';
    END IF;
    IF ((round_n = 1) && (tah <= 0) || (round_n <> 1) && (tah <> old_tah) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_assitant_hours failed';
    END IF;
    IF ((round_n = 1) && (ash <> 0) || (round_n <> 1) && (ash <> old_ash) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours failed';
    END IF;
    IF ((round_n = 1) && (aah <> 0) || (round_n <> 1) && (aah <> old_aah) ) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_assistant_hours failed';
    END IF;
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
USE `proyecto_inge`;
DROP procedure IF EXISTS `check_rounds_on_update`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE PROCEDURE `check_rounds_on_update`(
				IN round_n TINYINT, 
				IN sem TINYINT, 
				IN start_d DATETIME, 
                IN end_d DATETIME, 
                IN y YEAR(4),
                IN old_start_d DATETIME,
                IN tsh SMALLINT,
                IN tah SMALLINT,
                IN ash SMALLINT,
                IN aah SMALLINT,
                IN old_ash SMALLINT,
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
    IF (start_d <  IFNULL((SELECT MAX(end_date) FROM rounds WHERE end_date < end_d ),(SELECT SUBDATE(NOW(),10))) AND start_d != old_start_d) THEN
		SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'check constraint on rounds.start_date failed';
    END IF;
	IF (end_d <= start_d) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.end_date failed';
    END IF;
    IF (y <> YEAR(start_d) && MONTH(start_d) <> 12 || y <> YEAR(start_d)+1 && MONTH(start_d) = 12) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.year failed';
    END IF;
	IF ((round_n = 1) && (tsh <= 0)) || ((round_n <> 1) && (tsh < ash))THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_student_hours failed';
    END IF;
    IF ((round_n = 1) && (tah <= 0)) || ((round_n <> 1) && (tah < aah))THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.total_assitant_hours failed';
    END IF;
    set @var = concat('check constraint on rounds.actual_student_hours failed ', (round_n <> 1));
    IF (round_n <> 1) && (ash <> old_ash) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = @var;
    END IF;
    IF (round_n <> 1) && (aah <> old_aah)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_assistant_hours failed';
    END IF;
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
USE `proyecto_inge`;
DROP procedure IF EXISTS `delete_round`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE PROCEDURE `delete_round`(IN start_d VARCHAR(10))
BEGIN
    IF (start_d < DATE(NOW()) - INTERVAL 10 DAY)THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'delete round failed';
    END IF;
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
USE `proyecto_inge`;
DROP procedure IF EXISTS `insert_round`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE PROCEDURE `insert_round`(IN start_d VARCHAR(10), IN end_d VARCHAR(10), IN tsh SMALLINT, IN tah SMALLINT)
BEGIN
	SET @year = YEAR(start_d);
	SET @month = MONTH(start_d);
    
    IF(@month = 12) THEN
		SET @year = @year+1;
    END IF;
    
    SET @semester = NULL;
    IF(@month=12 OR @month<7) THEN
		SET @semester = 'I';
	ELSEIF @month>=7 THEN
		SET @semester = 'II';
    END IF;
    
    SET @last_start_date = (SELECT MAX(start_date) FROM rounds);
    
	SET @last_semester = (SELECT MAX(semester) FROM rounds WHERE start_date = @last_start_date);
    SET @last_year = (SELECT MAX(year) FROM rounds WHERE start_date = @last_start_date);
	
    SET @round = IFNULL((SELECT MAX(round_number) FROM rounds WHERE start_date = @last_start_date ),0);
    IF @semester <> @last_semester OR @year <> @last_year THEN
		SET @round = 0;
	END IF;
	
    SET @round = @round+1;
    
    IF @round = 1 THEN
		SET @tsh = tsh;
		SET @tah = tah;
		SET @ash = 0;
		SET @aah = 0;
	END IF;
    
    IF @round <> 1 THEN
    	SET @tsh = (SELECT total_student_hours FROM rounds WHERE start_date = @last_start_date);
		SET @tah = (SELECT total_assistant_hours FROM rounds WHERE start_date = @last_start_date);
		SET @ash = (SELECT actual_student_hours FROM rounds WHERE start_date = @last_start_date);
		SET @aah = (SELECT actual_assistant_hours FROM rounds WHERE start_date = @last_start_date);
	END IF;
    
    INSERT INTO ROUNDS VALUES(start_d,end_d,@round,@semester,@year,@tsh,@tah,@ash,@aah);
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
USE `proyecto_inge`;
DROP procedure IF EXISTS `update_round`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE PROCEDURE `update_round`(IN start_d VARCHAR(10), IN end_d VARCHAR(10), IN old_start_d VARCHAR(10), IN tsh SMALLINT, IN tah SMALLINT)
BEGIN
	SET @year = YEAR(start_d);
	SET @month = MONTH(start_d);
    
	IF(@month = 12) THEN
		SET @year = @year+1;
    END IF;
    
    SET @semester = NULL;
    IF(@month=12 OR @month<7) THEN
		SET @semester = 'I';
	ELSEIF @month>=7 THEN
		SET @semester = 'II';
    END IF;

	SET @old_semester = (SELECT semester FROM rounds WHERE start_date = old_start_d);
    SET @old_year = (SELECT year FROM rounds WHERE start_date = old_start_d);
    
	SET @round = (SELECT round_number FROM rounds WHERE start_date = old_start_d);
    IF @semester <> @old_semester OR @year <> @old_year THEN
		SET @round = 1;
	END IF;
    
    UPDATE rounds SET start_date = start_d, round_number = @round, semester = @semester, year = @year, end_date = end_d, total_student_hours = tsh, total_assistant_hours = tah
    WHERE start_date = old_start_d;    
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
USE `proyecto_inge`;
DROP procedure IF EXISTS `update_round_actual_hours`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE PROCEDURE `update_round_actual_hours`(IN start_d VARCHAR(10), IN ash TINYINT, IN aah TINYINT)
BEGIN
	SET @tsh = (SELECT total_student_hours FROM rounds WHERE start_date = start_d);
    SET @tah = (SELECT total_assistant_hours FROM rounds WHERE start_date = start_d);
    SET @ash = (SELECT actual_student_hours FROM rounds WHERE start_date = start_d);
    SET @aah = (SELECT actual_assistant_hours FROM rounds WHERE start_date = start_d);
    IF (@ash + ash > @tsh) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours failed';
    END IF;
    IF ash <> 0 && (ash > 12 || ash < 3 || @ash + ash > @tsh) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_student_hours failed';
    END IF;
    IF aah <> 0 && (aah > 20 || aah < 3 || @aah + aah > @tah) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.actual_assistant_hours failed';
    END IF;
    UPDATE rounds SET actual_student_hours = actual_student_hours + ash, actual_assistant_hours = actual_assistant_hours + aah
    WHERE start_date = start_d;
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `proyecto_inge`.`rounds_before_insert`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE TRIGGER rounds_before_insert BEFORE INSERT ON rounds FOR EACH ROW BEGIN
	SET @last_start_date = (SELECT MAX(start_date) FROM rounds);
    CALL check_rounds_on_insert(
		NEW.round_number,
        NEW.semester,
        NEW.start_date,
        NEW.end_date,
        NEW.year,
        NEW.total_student_hours,
        NEW.total_assistant_hours,
        NEW.actual_student_hours,
        NEW.actual_assistant_hours,
        (SELECT total_student_hours FROM rounds WHERE start_date = @last_start_date),
        (SELECT total_assistant_hours FROM rounds WHERE start_date = @last_start_date),
        (SELECT actual_student_hours FROM rounds WHERE start_date = @last_start_date),
        (SELECT actual_assistant_hours FROM rounds WHERE start_date = @last_start_date)
	);
    
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `proyecto_inge`.`rounds_before_update`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE TRIGGER rounds_before_update BEFORE UPDATE ON rounds FOR EACH ROW BEGIN
    CALL check_rounds_on_update(
		NEW.round_number,
        NEW.semester,
        NEW.start_date,
        NEW.end_date,
        NEW.year,
        OLD.start_date,
		NEW.total_student_hours,
		NEW.total_assistant_hours,
		NEW.actual_student_hours,
		NEW.actual_assistant_hours,
		OLD.actual_student_hours,
		OLD.actual_assistant_hours
	);
END$$
DELIMITER ;

-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS `proyecto_inge`.`rounds_before_delete`;

DELIMITER $$
USE `proyecto_inge`$$
CREATE TRIGGER rounds_before_delete BEFORE DELETE ON rounds FOR EACH ROW BEGIN
    CALL delete_round(OLD.start_date);
END$$
DELIMITER ;
