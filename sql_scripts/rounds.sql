CREATE TABLE `Proyecto`.`rounds` (
  `number` INT NOT NULL,
  `semester` INT NOT NULL,
  `year` INT NOT NULL,
  `start_date` DATETIME NOT NULL,
  `end_date` DATETIME NOT NULL,
  `approve_limit_date` DATETIME NOT NULL,
  PRIMARY KEY (`semester`, `number`, `year`),
  UNIQUE INDEX `approve_limit_date_UNIQUE` (`approve_limit_date` ASC),
  UNIQUE INDEX `start_date_UNIQUE` (`start_date` ASC),
  UNIQUE INDEX `end_date_UNIQUE` (`end_date` ASC));
