-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema baka-database
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema baka-database
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `baka-database` DEFAULT CHARACTER SET utf8 ;
USE `baka-database` ;

-- -----------------------------------------------------
-- Table `baka-database`.`URGENCY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`URGENCY` (
  `id_URGENCY` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_URGENCY`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baka-database`.`REPRODUCTIVE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`REPRODUCTIVE` (
  `id_REPRODUCTIVE` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_REPRODUCTIVE`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baka-database`.`PROJECT_PHASE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`PROJECT_PHASE` (
  `id_PROJECT_PHASE` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_PROJECT_PHASE`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (
  `id_NUMBER_OF_AFFECTIVE_MACHINES` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_NUMBER_OF_AFFECTIVE_MACHINES`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baka-database`.`IMPACT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`IMPACT` (
  `id_IMPACT` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_IMPACT`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baka-database`.`PRIORITY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`PRIORITY` (
  `idPRIORITY` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(45) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idPRIORITY`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `baka-database`.`INCIDENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `baka-database`.`INCIDENT` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `sla_time` INT NOT NULL,
  `urgency` INT NOT NULL,
  `reproductive` INT NOT NULL,
  `project_phase` INT NOT NULL,
  `number_of_effective_machines` INT NOT NULL,
  `impact` INT NOT NULL,
  `expected_priority` INT NULL,
  `priority_1` INT NULL,
  `priority_2` INT NULL,
  `priority_3` INT NULL,
  `priority_4` INT NULL,
  `priority_5` INT NULL,
  `priority_1_rating` FLOAT NULL,
  `priority_2_rating` FLOAT NULL,
  `priority_3_rating` FLOAT NULL,
  `priority_4_rating` FLOAT NULL,
  `priority_5_rating` FLOAT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_INCIDENT_URGENCY`
    FOREIGN KEY (`urgency`)
    REFERENCES `baka-database`.`URGENCY` (`id_URGENCY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_REPRODUCTIVE1`
    FOREIGN KEY (`reproductive`)
    REFERENCES `baka-database`.`REPRODUCTIVE` (`id_REPRODUCTIVE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PROJECT_PHASE1`
    FOREIGN KEY (`project_phase`)
    REFERENCES `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_NUMBER_OF_AFFECTIVE_MACHINES1`
    FOREIGN KEY (`number_of_effective_machines`)
    REFERENCES `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (`id_NUMBER_OF_AFFECTIVE_MACHINES`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_IMPACT1`
    FOREIGN KEY (`impact`)
    REFERENCES `baka-database`.`IMPACT` (`id_IMPACT`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PRIORITY1`
    FOREIGN KEY (`expected_priority`)
    REFERENCES `baka-database`.`PRIORITY` (`idPRIORITY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PRIORITY2`
    FOREIGN KEY (`priority_1`)
    REFERENCES `baka-database`.`PRIORITY` (`idPRIORITY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PRIORITY3`
    FOREIGN KEY (`priority_2`)
    REFERENCES `baka-database`.`PRIORITY` (`idPRIORITY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PRIORITY4`
    FOREIGN KEY (`priority_3`)
    REFERENCES `baka-database`.`PRIORITY` (`idPRIORITY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PRIORITY5`
    FOREIGN KEY (`priority_4`)
    REFERENCES `baka-database`.`PRIORITY` (`idPRIORITY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_INCIDENT_PRIORITY6`
    FOREIGN KEY (`priority_5`)
    REFERENCES `baka-database`.`PRIORITY` (`idPRIORITY`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `baka-database`.`URGENCY`
-- -----------------------------------------------------
START TRANSACTION;
USE `baka-database`;
INSERT INTO `baka-database`.`URGENCY` (`id_URGENCY`, `value`, `name`) VALUES (DEFAULT, 'highest', 'Highest');
INSERT INTO `baka-database`.`URGENCY` (`id_URGENCY`, `value`, `name`) VALUES (DEFAULT, 'high', 'High');
INSERT INTO `baka-database`.`URGENCY` (`id_URGENCY`, `value`, `name`) VALUES (DEFAULT, 'medium', 'Medium');
INSERT INTO `baka-database`.`URGENCY` (`id_URGENCY`, `value`, `name`) VALUES (DEFAULT, 'low', 'Low');

COMMIT;


-- -----------------------------------------------------
-- Data for table `baka-database`.`REPRODUCTIVE`
-- -----------------------------------------------------
START TRANSACTION;
USE `baka-database`;
INSERT INTO `baka-database`.`REPRODUCTIVE` (`id_REPRODUCTIVE`, `value`, `name`) VALUES (DEFAULT, 'yes', 'Yes');
INSERT INTO `baka-database`.`REPRODUCTIVE` (`id_REPRODUCTIVE`, `value`, `name`) VALUES (DEFAULT, 'no', 'No');

COMMIT;


-- -----------------------------------------------------
-- Data for table `baka-database`.`PROJECT_PHASE`
-- -----------------------------------------------------
START TRANSACTION;
USE `baka-database`;
INSERT INTO `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`, `value`, `name`) VALUES (DEFAULT, 'production', 'Production');
INSERT INTO `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`, `value`, `name`) VALUES (DEFAULT, 'pilot', 'Pilot');
INSERT INTO `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`, `value`, `name`) VALUES (DEFAULT, 'uat', 'UAT');
INSERT INTO `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`, `value`, `name`) VALUES (DEFAULT, 'certification', 'Certification');
INSERT INTO `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`, `value`, `name`) VALUES (DEFAULT, 'sit', 'SIT');
INSERT INTO `baka-database`.`PROJECT_PHASE` (`id_PROJECT_PHASE`, `value`, `name`) VALUES (DEFAULT, 'internal_qa', 'Internal QA');

COMMIT;


-- -----------------------------------------------------
-- Data for table `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES`
-- -----------------------------------------------------
START TRANSACTION;
USE `baka-database`;
INSERT INTO `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (`id_NUMBER_OF_AFFECTIVE_MACHINES`, `value`, `name`) VALUES (DEFAULT, '>1000', '> 1000');
INSERT INTO `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (`id_NUMBER_OF_AFFECTIVE_MACHINES`, `value`, `name`) VALUES (DEFAULT, '101-1000', '101 - 1000');
INSERT INTO `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (`id_NUMBER_OF_AFFECTIVE_MACHINES`, `value`, `name`) VALUES (DEFAULT, '11-100', '11 - 100');
INSERT INTO `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (`id_NUMBER_OF_AFFECTIVE_MACHINES`, `value`, `name`) VALUES (DEFAULT, '2-10', '2 - 100');
INSERT INTO `baka-database`.`NUMBER_OF_AFFECTIVE_MACHINES` (`id_NUMBER_OF_AFFECTIVE_MACHINES`, `value`, `name`) VALUES (DEFAULT, '1', '1');

COMMIT;


-- -----------------------------------------------------
-- Data for table `baka-database`.`IMPACT`
-- -----------------------------------------------------
START TRANSACTION;
USE `baka-database`;
INSERT INTO `baka-database`.`IMPACT` (`id_IMPACT`, `value`, `name`) VALUES (DEFAULT, 'critical', 'Critical');
INSERT INTO `baka-database`.`IMPACT` (`id_IMPACT`, `value`, `name`) VALUES (DEFAULT, 'non-critical', 'Non-critical');

COMMIT;


-- -----------------------------------------------------
-- Data for table `baka-database`.`PRIORITY`
-- -----------------------------------------------------
START TRANSACTION;
USE `baka-database`;
INSERT INTO `baka-database`.`PRIORITY` (`idPRIORITY`, `value`, `name`) VALUES (DEFAULT, 'very_high', 'Very high');
INSERT INTO `baka-database`.`PRIORITY` (`idPRIORITY`, `value`, `name`) VALUES (DEFAULT, 'high', 'High');
INSERT INTO `baka-database`.`PRIORITY` (`idPRIORITY`, `value`, `name`) VALUES (DEFAULT, 'medium', 'Medium');
INSERT INTO `baka-database`.`PRIORITY` (`idPRIORITY`, `value`, `name`) VALUES (DEFAULT, 'low', 'Low');

COMMIT;