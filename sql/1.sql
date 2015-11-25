-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema np3799_abprojekt
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema np3799_abprojekt
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema np3799_abprojekt
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `np3799_abprojekt` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `np3799_abprojekt` ;

-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_isikud_patsiendid`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_isikud_patsiendid` (
  `isikukood` INT NOT NULL COMMENT '',
  `nimi` VARCHAR(45) NOT NULL COMMENT '',
  `ravikindlustus` VARCHAR(45) NOT NULL COMMENT '',
  `sugu` VARCHAR(45) NOT NULL COMMENT '',
  `vanus` INT NOT NULL COMMENT '',
  PRIMARY KEY (`isikukood`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_haigused`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_haigused` (
  `haiguse_nimetus` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`haiguse_nimetus`)  COMMENT '',
  UNIQUE INDEX `haiguse_nimetus_UNIQUE` (`haiguse_nimetus` ASC)  COMMENT '')
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_staatused`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_staatused` (
  `staatus` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`staatus`)  COMMENT '',
  UNIQUE INDEX `staatus_UNIQUE` (`staatus` ASC)  COMMENT '')
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_asutused`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_asutused` (
  `asutuse_nimetus` VARCHAR(45) NOT NULL COMMENT '',
  `osakond` VARCHAR(100) NULL COMMENT '',
  `aadress` VARCHAR(100) NULL COMMENT '',
  `linn` VARCHAR(100) NULL COMMENT '',
  `koordinaadid_x` INT NULL COMMENT '',
  `koordinaadid_y` INT NULL COMMENT '',
  `piirkond` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`asutuse_nimetus`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_arstid`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_arstid` (
  `arsti_isikukood` INT NOT NULL COMMENT '',
  `eriala` VARCHAR(45) NULL COMMENT '',
  `asutused_asutuse_nimetus` VARCHAR(45) NOT NULL COMMENT '',
  `haigused_haiguse_nimetus` VARCHAR(45) NOT NULL COMMENT '',
  `gp_isikud_patsiendid_isikukood` INT NOT NULL COMMENT '',
  PRIMARY KEY (`arsti_isikukood`)  COMMENT '',
  INDEX `fk_arstid_asutused_idx` (`asutused_asutuse_nimetus` ASC)  COMMENT '',
  INDEX `fk_I_haigused1_idx` (`haigused_haiguse_nimetus` ASC)  COMMENT '',
  INDEX `fk_gp_arstid_gp_isikud_patsiendid1_idx` (`gp_isikud_patsiendid_isikukood` ASC)  COMMENT '',
  CONSTRAINT `fk_arstid_asutused`
    FOREIGN KEY (`asutused_asutuse_nimetus`)
    REFERENCES `np3799_abprojekt`.`gp_asutused` (`asutuse_nimetus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_I_haigused1`
    FOREIGN KEY (`haigused_haiguse_nimetus`)
    REFERENCES `np3799_abprojekt`.`gp_haigused` (`haiguse_nimetus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_arstid_gp_isikud_patsiendid1`
    FOREIGN KEY (`gp_isikud_patsiendid_isikukood`)
    REFERENCES `np3799_abprojekt`.`gp_isikud_patsiendid` (`isikukood`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_arsti_vastuvotud`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_arsti_vastuvotud` (
  `date_id` INT NOT NULL COMMENT '',
  `time_start` VARCHAR(45) NULL COMMENT '',
  `time_end` VARCHAR(45) NULL COMMENT '',
  `arsti_isikukood` INT NOT NULL COMMENT '',
  `date` DATE NULL COMMENT '',
  `bron_staatus` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`date_id`)  COMMENT '',
  INDEX `fk_gp_arsti_vastuvotud_gp_arstid2_idx`    (`arsti_isikukood` ASC)  COMMENT '',
  INDEX `fk_gp_arsti_vastuvotud_gp_staatused2_idx` (`bron_staatus` ASC)  COMMENT '',
  CONSTRAINT `fk_gp_arsti_vastuvotud_gp_arstid2`
    FOREIGN KEY (`arsti_isikukood`)
    REFERENCES `np3799_abprojekt`.`gp_arstid` (`arsti_isikukood`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_arsti_vastuvotud_staat2`
    FOREIGN KEY (`bron_staatus`)
    REFERENCES `np3799_abprojekt`.`gp_staatused` (`staatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `np3799_abprojekt`.`gp_broneeringud`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `np3799_abprojekt`.`gp_broneeringud` (
  `bron_nr` INT NOT NULL COMMENT '',
  `mure` VARCHAR(500) NOT NULL COMMENT '',
  `staatus` VARCHAR(45) NOT NULL COMMENT '',
  `haigused_haiguse_nimetus` VARCHAR(45) NOT NULL COMMENT '',
  `gp_asutused_asutuse_nimetus` VARCHAR(45) NOT NULL COMMENT '',
  `gp_isikud_patsiendid_isikukood` INT NOT NULL COMMENT '',
  `gp_arstid_isikukood` INT NOT NULL COMMENT '',
  `gp_arsti_vastuvotud_date_id` INT NOT NULL COMMENT '',
  INDEX `fk_Broneeringud_haigused1_idx` (`haigused_haiguse_nimetus` ASC)  COMMENT '',
  PRIMARY KEY (`bron_nr`)  COMMENT '',
  INDEX `fk_gp_broneeringud_gp_asutused1_idx` (`gp_asutused_asutuse_nimetus` ASC)  COMMENT '',
  INDEX `fk_gp_broneeringud_gp_isikud_patsiendid1_idx` (`gp_isikud_patsiendid_isikukood` ASC)  COMMENT '',
  INDEX `fk_gp_broneeringud_gp_arstid1_idx`       (`gp_arstid_isikukood` ASC)  COMMENT '',
  INDEX `fk_gp_broneeringud_gp_arsti_vasvot2_idx` (`gp_arsti_vastuvotud_date_id` ASC)  COMMENT '',
  INDEX `fk_gp_broneeringud_gp_stars_idx3` (`staatus` ASC)  COMMENT '',
  CONSTRAINT `fk_broneeringud_haigused2`
    FOREIGN KEY (`haigused_haiguse_nimetus`)
    REFERENCES `np3799_abprojekt`.`gp_haigused` (`haiguse_nimetus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_broneeringud_gp_asutused1`
    FOREIGN KEY (`gp_asutused_asutuse_nimetus`)
    REFERENCES `np3799_abprojekt`.`gp_asutused` (`asutuse_nimetus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_broneeringud_gp_isikud_patsiendid1`
    FOREIGN KEY (`gp_isikud_patsiendid_isikukood`)
    REFERENCES `np3799_abprojekt`.`gp_isikud_patsiendid` (`isikukood`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_broneeringud_gp_arstid1`
    FOREIGN KEY (`gp_arstid_isikukood`)
    REFERENCES `np3799_abprojekt`.`gp_arstid` (`arsti_isikukood`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_broneeringud_gp_arsti_vastuvotud1`
    FOREIGN KEY (`gp_arsti_vastuvotud_date_id`)
    REFERENCES `np3799_abprojekt`.`gp_arsti_vastuvotud` (`date_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_broneeringud_gp_staatus`
    FOREIGN KEY (`staatus`)
    REFERENCES `np3799_abprojekt`.`gp_staatused` (`staatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_isikud_patsiendid`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_isikud_patsiendid` (`isikukood`, `nimi`, `ravikindlustus`, `sugu`, `vanus`) VALUES (12345678, 'Sven', 'yes', 'mees', 15);
INSERT INTO `np3799_abprojekt`.`gp_isikud_patsiendid` (`isikukood`, `nimi`, `ravikindlustus`, `sugu`, `vanus`) VALUES (87654321, 'Inga', 'yes', 'naine', 44);
INSERT INTO `np3799_abprojekt`.`gp_isikud_patsiendid` (`isikukood`, `nimi`, `ravikindlustus`, `sugu`, `vanus`) VALUES (12346789, 'dr Jaagup', 'no', 'mees', 33);
INSERT INTO `np3799_abprojekt`.`gp_isikud_patsiendid` (`isikukood`, `nimi`, `ravikindlustus`, `sugu`, `vanus`) VALUES (09876543, 'Peo Hunt', 'no', 'naine', 22);

COMMIT;


-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_haigused`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_haigused` (`haiguse_nimetus`) VALUES ('Viirushaiguse');
INSERT INTO `np3799_abprojekt`.`gp_haigused` (`haiguse_nimetus`) VALUES ('Nakkushaigused');
INSERT INTO `np3799_abprojekt`.`gp_haigused` (`haiguse_nimetus`) VALUES ('alergia');
INSERT INTO `np3799_abprojekt`.`gp_haigused` (`haiguse_nimetus`) VALUES ('selljavalu');

COMMIT;

-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_staatused`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_staatused` (`staatus`) VALUES ('broneeritud');
INSERT INTO `np3799_abprojekt`.`gp_staatused` (`staatus`) VALUES ('vaba');
INSERT INTO `np3799_abprojekt`.`gp_staatused` (`staatus`) VALUES ('tyhistatud');

COMMIT;

-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_asutused`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_asutused` (`asutuse_nimetus`, `osakond`, `aadress`, `linn`, `koordinaadid_x`, `koordinaadid_y`, `piirkond`) VALUES ('Keskhaigla', 'nakkusosakond', 'keskhaigla 1', 'Tallinn', 11, 22, 'tallinn');
INSERT INTO `np3799_abprojekt`.`gp_asutused` (`asutuse_nimetus`, `osakond`, `aadress`, `linn`, `koordinaadid_x`, `koordinaadid_y`, `piirkond`) VALUES ('Mecivover', 'perearstide osakond', 'randvere tee 1', 'Viiimsi', 33, 44, 'harjumaa');

COMMIT;


-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_arstid`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_arstid` (`arsti_isikukood`, `eriala`, `asutused_asutuse_nimetus`, `haigused_haiguse_nimetus`, `gp_isikud_patsiendid_isikukood`) VALUES (1, 'Dr ', 'Keskhaigla', 'Nakkushaigused', 12346789);
INSERT INTO `np3799_abprojekt`.`gp_arstid` (`arsti_isikukood`, `eriala`, `asutused_asutuse_nimetus`, `haigused_haiguse_nimetus`, `gp_isikud_patsiendid_isikukood`) VALUES (2, 'Perearst', 'Mecivover', 'Viirushaiguse', 9876543);

COMMIT;


-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_arsti_vastuvotud`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_arsti_vastuvotud` (`date_id`, `time_start`, `time_end`, `arsti_isikukood`, `date`, `bron_staatus`) VALUES (1, '11:00', '12:00', 12346789, '2015-01-01', 'vaba');
INSERT INTO `np3799_abprojekt`.`gp_arsti_vastuvotud` (`date_id`, `time_start`, `time_end`, `arsti_isikukood`, `date`, `bron_staatus`) VALUES (2, '12:00', '13:00', 12346789, '2015-01-01', 'broneeritud');
INSERT INTO `np3799_abprojekt`.`gp_arsti_vastuvotud` (`date_id`, `time_start`, `time_end`, `arsti_isikukood`, `date`, `bron_staatus`) VALUES (3, '11:00', '12:00', 9876543, '2015-01-01', 'tyhistatud');
INSERT INTO `np3799_abprojekt`.`gp_arsti_vastuvotud` (`date_id`, `time_start`, `time_end`, `arsti_isikukood`, `date`, `bron_staatus`) VALUES (4, '11:00', '12:00', 9876543, '2015-01-01', 'broneeritud');

COMMIT;


-- -----------------------------------------------------
-- Data for table `np3799_abprojekt`.`gp_broneeringud`
-- -----------------------------------------------------
START TRANSACTION;
USE `np3799_abprojekt`;
INSERT INTO `np3799_abprojekt`.`gp_broneeringud` (`bron_nr`, `mure`, `staatus`, `haigused_haiguse_nimetus`, `gp_asutused_asutuse_nimetus`, `gp_isikud_patsiendid_isikukood`, `gp_arstid_isikukood`, `gp_arsti_vastuvotud_date_id`) VALUES (11, 'suur mure ', 'broneeritud', 'Nakkushaigused', 'Keskhaigla', 12345678, 12346789, 1);
INSERT INTO `np3799_abprojekt`.`gp_broneeringud` (`bron_nr`, `mure`, `staatus`, `haigused_haiguse_nimetus`, `gp_asutused_asutuse_nimetus`, `gp_isikud_patsiendid_isikukood`, `gp_arstid_isikukood`, `gp_arsti_vastuvotud_date_id`) VALUES (12, 'vaike mure', 'broneeritud', 'Viirushaiguse', 'Mecivover', 87654321, 12346789, 2);
INSERT INTO `np3799_abprojekt`.`gp_broneeringud` (`bron_nr`, `mure`, `staatus`, `haigused_haiguse_nimetus`, `gp_asutused_asutuse_nimetus`, `gp_isikud_patsiendid_isikukood`, `gp_arstid_isikukood`, `gp_arsti_vastuvotud_date_id`) VALUES (13, 'mingi mure', 'vaba', 'Viirushaiguse', 'Mecivover', 87654321, 12346789, 3);
INSERT INTO `np3799_abprojekt`.`gp_broneeringud` (`bron_nr`, `mure`, `staatus`, `haigused_haiguse_nimetus`, `gp_asutused_asutuse_nimetus`, `gp_isikud_patsiendid_isikukood`, `gp_arstid_isikukood`, `gp_arsti_vastuvotud_date_id`) VALUES (14, 'Ei tea ise kaa miks tulin', 'visiit toimimunud', 'Nakkushaigused', 'Keskhaigla', 12346789, 9876543, 4);

COMMIT;
