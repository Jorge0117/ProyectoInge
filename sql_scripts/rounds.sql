-- Drops del módulo rondas
drop trigger rounds_before_insert;
drop trigger rounds_before_update;

alter table applications drop foreign key rounds_fk;
drop table rounds;
drop procedure check_rounds;
drop procedure insert_round;
-- drop procedure select_last_round;
drop procedure delete_last_round;
drop procedure edit_round;

alter table applications add constraint rounds_fk foreign key (round_id) references rounds(start_date);

-- Creación de la tabla rondas ------------------------------------------------------------------------------------------------------------------
CREATE TABLE rounds (
    start_date DATE NOT NULL CHECK (start_date > NOW()-1),
	round_number ENUM('1', '2', '3') NOT NULL,
    semester ENUM('I', 'II') NOT NULL,
    year YEAR(4) NOT NULL CHECK (year >= YEAR(NOW())),
    end_date DATE NOT NULL CHECK (end_date > start_date),
    PRIMARY KEY (start_date)
);
-- Procedimiento almacenado y triggers para simular los checks de rondas, necesarios debido a que mysql ignora los checks al crear la tabla -----
DELIMITER $$
CREATE PROCEDURE check_rounds(
				IN round_n TINYINT, 
				IN sem TINYINT, 
				IN start_d DATETIME, 
                IN end_d DATETIME, 
                IN y YEAR(4)) BEGIN
    IF (round_n > 3) OR (round_n < 1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.round_number failed';
    END IF;
    IF (sem>3) OR (sem<1) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.semester failed';
    END IF;
     IF (start_d < (SELECT MAX(end_date) FROM rounds)) THEN
		SIGNAL SQLSTATE '45000'
			SET MESSAGE_TEXT = 'check constraint on rounds.start_date failed';
    END IF;
	IF (end_d <= start_d) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.end_date failed';
    END IF;
    IF (y < YEAR(NOW())) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on rounds.year failed';
    END IF;
END$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER rounds_before_insert BEFORE INSERT ON rounds FOR EACH ROW BEGIN
    CALL check_rounds(NEW.round_number,NEW.semester,NEW.start_date, NEW.end_date, NEW.year);
END$$   
DELIMITER ;
DELIMITER $$
CREATE TRIGGER rounds_before_update BEFORE UPDATE ON rounds FOR EACH ROW BEGIN
    CALL check_rounds(NEW.round_number,NEW.semester,NEW.start_date, NEW.end_date, NEW.year);
END$$
DELIMITER ;
-- Procedimiento almacenado para insertar rondas, calcula los datos de la llave automáticamente -------------------------------------------------
DELIMITER $$
CREATE PROCEDURE insert_round(IN start_d VARCHAR(10), IN end_d VARCHAR(10)) BEGIN
	SET @year = YEAR(start_d);
	SET @month = MONTH(start_d);

    SET @semester = NULL;
    IF(@month>=12 OR @month<7) THEN
		SET @semester = 'I';
	ELSEIF (@month>=7 OR @month<12) THEN
		SET @semester = 'II';
    END IF;

	SET @round = IFNULL((SELECT MAX(round_number) FROM rounds WHERE start_date = (SELECT MAX(start_date) FROM rounds) ),0);
    IF @round = 3 OR @semester <> (SELECT MAX(semester) FROM rounds WHERE start_date = (SELECT MAX(start_date) FROM rounds)) THEN
		SET @round = 0;
	END IF;

    SET @round = @round+1;
    
    INSERT INTO ROUNDS VALUES(start_d,@round,@semester,@year,end_d);
    
END$$
DELIMITER ;
-- Procedimiento almacenado para seleccionar la última ronda únicamente -------------------------------------------------------------------------
-- DELIMITER $$
-- CREATE PROCEDURE select_last_round() BEGIN
-- 	SELECT MAX(round_number) AS round_number, semester, year, MAX(start_date) AS start_date, end_date, approve_limit_date 
--     FROM rounds
-- 	GROUP BY semester;
-- END$$
-- DELIMITER ;
-- Procedimiento almacenado para eliminar la última ronda únicamente ----------------------------------------------------------------------------

DELIMITER $$
CREATE PROCEDURE delete_last_round()BEGIN
	SET @last_date = (SELECT MAX(start_date) FROM rounds );
    SET @last_round = (SELECT MAX(round_number) FROM rounds WHERE start_date = @last_date);
    IF(NOW()-1 < @last_date)THEN
		DELETE FROM rounds WHERE start_date = @last_date AND round_number = @last_round;
    END IF;
END$$
-- TODO: UPDATE ROUND ---------------------------------------------------------------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE edit_round(IN start_d_old VARCHAR(10), IN start_d_new VARCHAR(10), IN end_d VARCHAR(10), IN round VARCHAR(1)) BEGIN
	SET @year = YEAR(start_d_new);
	SET @month = MONTH(start_d_new);

    SET @semester = NULL;
    IF(@month>=12 OR @month<7) THEN
		SET @semester = 'I';
	ELSEIF (@month>=7 OR @month<12) THEN
		SET @semester = 'II';
    END IF;
    
	SET @round = round; 
    IF @semester <> (SELECT semester FROM rounds WHERE start_date = start_d_old) THEN
		SET @round = 1;
	END IF;

	UPDATE ROUNDS SET start_date = start_d_new, round_number = @round, semester = @semester, year = @year, end_date = end_d
	WHERE start_date = start_d_old;
    
END$$
DELIMITER ;
