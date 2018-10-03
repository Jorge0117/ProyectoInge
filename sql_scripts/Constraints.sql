DELIMITER $$

CREATE PROCEDURE check_users(IN email_ecci VARCHAR(42), IN personal_email VARCHAR(200), IN phone VARCHAR(12))
BEGIN
    IF email_ecci NOT LIKE '%_@ecci.ucr.ac.cr' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on users.email_ecci failed';
    END IF;
    IF personal_email NOT LIKE '%_@%_' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on users.personal_email failed';
    END IF;
    IF phone regexp '.*([a-z]|[A-Z]).*' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'check constraint on users.phone failed';
	-- ELSEIF phone NOT REGEXP '\+[0-9]{11,11}' THEN
      --  SIGNAL SQLSTATE '45000'
        --    SET MESSAGE_TEXT = 'check constraint on users.phone failed';
    END IF;
END$$

DELIMITER ;

DELIMITER $$
CREATE TRIGGER users_before_insert BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    CALL check_users(new.email_ecci, new.personal_email, new.phone);
END$$   
DELIMITER ;
-- before update

DELIMITER $$
CREATE TRIGGER users_before_update BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    CALL check_users(new.email_ecci,new.personal_email,new.phone);
END$$
DELIMITER ;
