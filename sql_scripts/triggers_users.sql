DELIMITER |
CREATE TRIGGER add_user AFTER INSERT ON users
FOR EACH ROW 
BEGIN
	IF NEW.role_id = 'Profesor' THEN
		INSERT INTO professors 
        SET user_id = NEW.identification_number;
    ELSEIF NEW.role_id = 'Asistente' THEN
		INSERT INTO administrative_assitants 
        SET user_id = NEW.identification_number;
    ELSEIF NEW.role_id = 'Administrador' THEN
		INSERT INTO administrative_bosses 
        SET user_id = NEW.identification_number;
	END IF;
END;


