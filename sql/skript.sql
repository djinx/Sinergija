-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sinergija
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `sinergija` ;

-- -----------------------------------------------------
-- Schema sinergija
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sinergija` DEFAULT CHARACTER SET utf8 ;
USE `sinergija` ;

-- -----------------------------------------------------
-- Table `sinergija`.`korisnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`korisnik` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`korisnik` (
  `idKorisnika` INT(11) NOT NULL AUTO_INCREMENT,
  `Ime` VARCHAR(45) NOT NULL,
  `Prezime` VARCHAR(45) NOT NULL,
  `Telefon` VARCHAR(45) NOT NULL,
  `E-mail` VARCHAR(45) NOT NULL,
  `Slika` VARCHAR(4096) NOT NULL DEFAULT '../uploads/novi.png',
  `Nadimak` VARCHAR(45) NOT NULL,
  `Sifra` VARCHAR(1024) NOT NULL,
  `Tip` VARCHAR(2) NOT NULL DEFAULT 'c',
  PRIMARY KEY (`idKorisnika`),
  UNIQUE INDEX `E-mail_UNIQUE` (`E-mail` ASC),
  UNIQUE INDEX `Nadimak_UNIQUE` (`Nadimak` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`tim`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`tim` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`tim` (
  `idTima` INT(11) NOT NULL AUTO_INCREMENT,
  `Naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTima`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`obaveza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`obaveza` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`obaveza` (
  `idObaveze` INT(11) NOT NULL AUTO_INCREMENT,
  `Naziv` VARCHAR(45) NOT NULL,
  `Opis` VARCHAR(4086) NOT NULL,
  `Datum_pocetka` DATE NOT NULL,
  `Datum_zavrsetka` DATE NOT NULL,
  `Deadline` DATE NOT NULL,
  `Odradjena` TINYINT(1) NOT NULL,
  `idTima` INT(11) NOT NULL,
  PRIMARY KEY (`idObaveze`),
  INDEX `fk_Obaveza_Tim1_idx` (`idTima` ASC),
  CONSTRAINT `fk_Obaveza_Tim1`
    FOREIGN KEY (`idTima`)
    REFERENCES `sinergija`.`tim` (`idTima`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`ima obavezu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`ima obavezu` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`ima obavezu` (
  `idKorisnika` INT(11) NOT NULL,
  `idObaveze` INT(11) NOT NULL,
  PRIMARY KEY (`idKorisnika`, `idObaveze`),
  INDEX `fk_Korisnik_has_Obaveza_Obaveza1_idx` (`idObaveze` ASC),
  INDEX `fk_Korisnik_has_Obaveza_Korisnik1_idx` (`idKorisnika` ASC),
  CONSTRAINT `fk_Korisnik_has_Obaveza_Korisnik1`
    FOREIGN KEY (`idKorisnika`)
    REFERENCES `sinergija`.`korisnik` (`idKorisnika`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Korisnik_has_Obaveza_Obaveza1`
    FOREIGN KEY (`idObaveze`)
    REFERENCES `sinergija`.`obaveza` (`idObaveze`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`projekat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`projekat` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`projekat` (
  `idProjekta` INT(11) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(250) NOT NULL,
  `opis` VARCHAR(1024) NOT NULL,
  `Pocetak_rada` DATE NOT NULL,
  `Kraj_rada` DATE NOT NULL,
  `Pocetak_dogadjaja` DATE NOT NULL,
  `Kraj_dogadjaja` DATE NOT NULL,
  PRIMARY KEY (`idProjekta`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`koordinira`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`koordinira` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`koordinira` (
  `idProjekta` INT(11) NOT NULL,
  `idKorisnika` INT(11) NOT NULL,
  `idTima` INT(11) NOT NULL,
  PRIMARY KEY (`idProjekta`, `idKorisnika`),
  INDEX `fk_Projekat_has_Korisnik_Korisnik1_idx` (`idKorisnika` ASC),
  INDEX `fk_Projekat_has_Korisnik_Projekat1_idx` (`idProjekta` ASC),
  INDEX `fk_Koordinira_Tim1_idx` (`idTima` ASC),
  CONSTRAINT `fk_Koordinira_Tim1`
    FOREIGN KEY (`idTima`)
    REFERENCES `sinergija`.`tim` (`idTima`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Projekat_has_Korisnik_Korisnik1`
    FOREIGN KEY (`idKorisnika`)
    REFERENCES `sinergija`.`korisnik` (`idKorisnika`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Projekat_has_Korisnik_Projekat1`
    FOREIGN KEY (`idProjekta`)
    REFERENCES `sinergija`.`projekat` (`idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`prijatelji`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`prijatelji` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`prijatelji` (
  `idPrijatelja` INT(11) NOT NULL AUTO_INCREMENT,
  `Naziv` VARCHAR(256) NOT NULL,
  `Tip` VARCHAR(45) NOT NULL,
  `Podtip` VARCHAR(45) NOT NULL,
  `Broj_telefona` VARCHAR(256) NULL DEFAULT NULL,
  `Email` VARCHAR(256) NULL DEFAULT NULL,
  `Veb_sajt` VARCHAR(45) NULL DEFAULT NULL,
  `Ime_kontakta` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`idPrijatelja`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`sadrzi`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`sadrzi` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`sadrzi` (
  `idObaveze` INT(11) NOT NULL,
  `idProjekta` INT(11) NOT NULL,
  PRIMARY KEY (`idObaveze`, `idProjekta`),
  INDEX `fk_Obaveza_has_Projekat_Projekat1_idx` (`idProjekta` ASC),
  INDEX `fk_Obaveza_has_Projekat_Obaveza_idx` (`idObaveze` ASC),
  CONSTRAINT `fk_Obaveza_has_Projekat_Obaveza`
    FOREIGN KEY (`idObaveze`)
    REFERENCES `sinergija`.`obaveza` (`idObaveze`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Obaveza_has_Projekat_Projekat1`
    FOREIGN KEY (`idProjekta`)
    REFERENCES `sinergija`.`projekat` (`idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`ucestvuje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`ucestvuje` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`ucestvuje` (
  `idKorisnika` INT(11) NOT NULL,
  `idProjekta` INT(11) NOT NULL,
  `idTima` INT(11) NOT NULL,
  PRIMARY KEY (`idKorisnika`, `idProjekta`),
  INDEX `fk_Korisnik_has_Projekat_Projekat1_idx` (`idProjekta` ASC),
  INDEX `fk_Korisnik_has_Projekat_Korisnik1_idx` (`idKorisnika` ASC),
  INDEX `fk_Ucestvuje_Tim1_idx` (`idTima` ASC),
  CONSTRAINT `fk_Korisnik_has_Projekat_Korisnik1`
    FOREIGN KEY (`idKorisnika`)
    REFERENCES `sinergija`.`korisnik` (`idKorisnika`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Korisnik_has_Projekat_Projekat1`
    FOREIGN KEY (`idProjekta`)
    REFERENCES `sinergija`.`projekat` (`idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Ucestvuje_Tim1`
    FOREIGN KEY (`idTima`)
    REFERENCES `sinergija`.`tim` (`idTima`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `sinergija`.`zaduzen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sinergija`.`zaduzen` ;

CREATE TABLE IF NOT EXISTS `sinergija`.`zaduzen` (
  `idKorisnika` INT(11) NOT NULL,
  `idProjekta` INT(11) NOT NULL,
  `idSponzora` INT(11) NOT NULL,
  `Status` VARCHAR(15) NULL DEFAULT NULL,
  `Napomena` VARCHAR(4096) NULL DEFAULT NULL,
  PRIMARY KEY (`idKorisnika`, `idProjekta`, `idSponzora`),
  INDEX `fk_Zaduzen_Sponzori1_idx` (`idSponzora` ASC),
  CONSTRAINT `fk_Zaduzen_Sponzori1`
    FOREIGN KEY (`idSponzora`)
    REFERENCES `sinergija`.`prijatelji` (`idPrijatelja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_Upravlja1`
    FOREIGN KEY (`idKorisnika` , `idProjekta`)
    REFERENCES `sinergija`.`ucestvuje` (`idKorisnika` , `idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE = '';
GRANT USAGE ON *.* TO omikron;
 DROP USER omikron;
SET SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
CREATE USER 'omikron' IDENTIFIED BY '123456';

GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `sinergija`.* TO 'omikron';
GRANT SELECT, INSERT, TRIGGER ON TABLE `sinergija`.* TO 'omikron';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sinergija`.`korisnik`
-- -----------------------------------------------------
START TRANSACTION;
USE `sinergija`;
INSERT INTO `sinergija`.`korisnik` (`idKorisnika`, `Ime`, `Prezime`, `Telefon`, `E-mail`, `Slika`, `Nadimak`, `Sifra`, `Tip`) VALUES (1000, 'Nikola', 'Ajzenhamer', '060 734 3333', 'ajzenhamernikola@gmail.com', '../uploads/novi.png', 'Ajzen', '$2y$10$CbouRMdpUqUDP3Q0f7x1YeBXXfgeh2Zdz/r0nuhVunf4u41GPPo6m', 'u');
INSERT INTO `sinergija`.`korisnik` (`idKorisnika`, `Ime`, `Prezime`, `Telefon`, `E-mail`, `Slika`, `Nadimak`, `Sifra`, `Tip`) VALUES (1001, 'ImePrimer', 'PrezimePrimer', '060 000 0000', 'primer@email.com', '../uploads/novi.png', 'Primer', '$2y$10$CbouRMdpUqUDP3Q0f7x1YeBXXfgeh2Zdz/r0nuhVunf4u41GPPo6m', 'c');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sinergija`.`tim`
-- -----------------------------------------------------
START TRANSACTION;
USE `sinergija`;
INSERT INTO `sinergija`.`tim` (`idTima`, `Naziv`) VALUES (2000, 'Fundraising (FR)');
INSERT INTO `sinergija`.`tim` (`idTima`, `Naziv`) VALUES (2001, 'Public Relations (PR)');
INSERT INTO `sinergija`.`tim` (`idTima`, `Naziv`) VALUES (2002, 'Project Management (PM)');
INSERT INTO `sinergija`.`tim` (`idTima`, `Naziv`) VALUES (2003, 'Logistics (LO)');
INSERT INTO `sinergija`.`tim` (`idTima`, `Naziv`) VALUES (2004, 'Human Resources (HR)');

COMMIT;

