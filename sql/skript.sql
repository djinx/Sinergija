-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema Sinergija
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `Sinergija` ;

-- -----------------------------------------------------
-- Schema Sinergija
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Sinergija` DEFAULT CHARACTER SET utf8 ;
USE `Sinergija` ;

-- -----------------------------------------------------
-- Table `Sinergija`.`Projekat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Projekat` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Projekat` (
  `idProjekta` INT NOT NULL,
  `naziv` VARCHAR(250) NOT NULL,
  `opis` VARCHAR(1024) NOT NULL,
  `Pocetak_rada` DATE NOT NULL,
  `Kraj_rada` DATE NOT NULL,
  `Pocetak_dogadjaja` DATE NOT NULL,
  `Kraj_dogadjaja` DATE NOT NULL,
  PRIMARY KEY (`idProjekta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Tim`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Tim` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Tim` (
  `idTima` INT NOT NULL,
  `Naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTima`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Obaveza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Obaveza` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Obaveza` (
  `idObaveze` INT NOT NULL,
  `Naziv` VARCHAR(45) NOT NULL,
  `Opis` VARCHAR(4086) NOT NULL,
  `Datum_pocetka` DATE NOT NULL,
  `Datum_zavrsetka` DATE NOT NULL,
  `Deadline` DATE NOT NULL,
  `Odradjena` TINYINT(1) NOT NULL,
  `idTima` INT NOT NULL,
  PRIMARY KEY (`idObaveze`),
  INDEX `fk_Obaveza_Tim1_idx` (`idTima` ASC),
  CONSTRAINT `fk_Obaveza_Tim1`
    FOREIGN KEY (`idTima`)
    REFERENCES `Sinergija`.`Tim` (`idTima`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Sadrzi`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Sadrzi` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Sadrzi` (
  `idObaveze` INT NOT NULL,
  `idProjekta` INT NOT NULL,
  PRIMARY KEY (`idObaveze`, `idProjekta`),
  INDEX `fk_Obaveza_has_Projekat_Projekat1_idx` (`idProjekta` ASC),
  INDEX `fk_Obaveza_has_Projekat_Obaveza_idx` (`idObaveze` ASC),
  CONSTRAINT `fk_Obaveza_has_Projekat_Obaveza`
    FOREIGN KEY (`idObaveze`)
    REFERENCES `Sinergija`.`Obaveza` (`idObaveze`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Obaveza_has_Projekat_Projekat1`
    FOREIGN KEY (`idProjekta`)
    REFERENCES `Sinergija`.`Projekat` (`idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Korisnik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Korisnik` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Korisnik` (
  `idKorisnika` INT NOT NULL AUTO_INCREMENT,
  `Ime` VARCHAR(45) NOT NULL,
  `Prezime` VARCHAR(45) NOT NULL,
  `Telefon` VARCHAR(45) NOT NULL,
  `E-mail` VARCHAR(45) NOT NULL,
  `Slika` VARCHAR(4096) NOT NULL,
  `Nadimak` VARCHAR(45) NULL,
  `Sifra` VARCHAR(1024) NOT NULL,
  `Tip` VARCHAR(2) NOT NULL DEFAULT 'c',
  PRIMARY KEY (`idKorisnika`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Ima obavezu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Ima obavezu` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Ima obavezu` (
  `idKorisnika` INT NOT NULL,
  `idObaveze` INT NOT NULL,
  PRIMARY KEY (`idKorisnika`, `idObaveze`),
  INDEX `fk_Korisnik_has_Obaveza_Obaveza1_idx` (`idObaveze` ASC),
  INDEX `fk_Korisnik_has_Obaveza_Korisnik1_idx` (`idKorisnika` ASC),
  CONSTRAINT `fk_Korisnik_has_Obaveza_Korisnik1`
    FOREIGN KEY (`idKorisnika`)
    REFERENCES `Sinergija`.`Korisnik` (`idKorisnika`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Korisnik_has_Obaveza_Obaveza1`
    FOREIGN KEY (`idObaveze`)
    REFERENCES `Sinergija`.`Obaveza` (`idObaveze`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Ucestvuje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Ucestvuje` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Ucestvuje` (
  `idKorisnika` INT NOT NULL,
  `idProjekta` INT NOT NULL,
  `idTima` INT NOT NULL,
  PRIMARY KEY (`idKorisnika`, `idProjekta`),
  INDEX `fk_Korisnik_has_Projekat_Projekat1_idx` (`idProjekta` ASC),
  INDEX `fk_Korisnik_has_Projekat_Korisnik1_idx` (`idKorisnika` ASC),
  INDEX `fk_Ucestvuje_Tim1_idx` (`idTima` ASC),
  CONSTRAINT `fk_Korisnik_has_Projekat_Korisnik1`
    FOREIGN KEY (`idKorisnika`)
    REFERENCES `Sinergija`.`Korisnik` (`idKorisnika`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Korisnik_has_Projekat_Projekat1`
    FOREIGN KEY (`idProjekta`)
    REFERENCES `Sinergija`.`Projekat` (`idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Ucestvuje_Tim1`
    FOREIGN KEY (`idTima`)
    REFERENCES `Sinergija`.`Tim` (`idTima`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Prijatelji`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Prijatelji` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Prijatelji` (
  `idPrijatelja` INT NOT NULL,
  `Naziv` VARCHAR(256) NOT NULL,
  `Tip` VARCHAR(45) NOT NULL,
  `Podtip` VARCHAR(45) NOT NULL,
  `Broj_telefona` VARCHAR(256) NULL,
  `Email` VARCHAR(256) NULL,
  `Veb_sajt` VARCHAR(45) NULL,
  `Ime_kontakta` VARCHAR(256) NULL,
  PRIMARY KEY (`idPrijatelja`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Zaduzen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Zaduzen` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Zaduzen` (
  `idKorisnika` INT NOT NULL,
  `idProjekta` INT NOT NULL,
  `idSponzora` INT NOT NULL,
  `Status` VARCHAR(15) NULL,
  `Napomena` VARCHAR(4096) NULL,
  PRIMARY KEY (`idKorisnika`, `idProjekta`, `idSponzora`),
  INDEX `fk_Zaduzen_Sponzori1_idx` (`idSponzora` ASC),
  CONSTRAINT `fk_table1_Upravlja1`
    FOREIGN KEY (`idKorisnika` , `idProjekta`)
    REFERENCES `Sinergija`.`Ucestvuje` (`idKorisnika` , `idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Zaduzen_Sponzori1`
    FOREIGN KEY (`idSponzora`)
    REFERENCES `Sinergija`.`Prijatelji` (`idPrijatelja`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Sinergija`.`Koordinira`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Sinergija`.`Koordinira` ;

CREATE TABLE IF NOT EXISTS `Sinergija`.`Koordinira` (
  `idProjekta` INT NOT NULL,
  `idKorisnika` INT NOT NULL,
  `idTima` INT NOT NULL,
  PRIMARY KEY (`idProjekta`, `idKorisnika`),
  INDEX `fk_Projekat_has_Korisnik_Korisnik1_idx` (`idKorisnika` ASC),
  INDEX `fk_Projekat_has_Korisnik_Projekat1_idx` (`idProjekta` ASC),
  INDEX `fk_Koordinira_Tim1_idx` (`idTima` ASC),
  CONSTRAINT `fk_Projekat_has_Korisnik_Projekat1`
    FOREIGN KEY (`idProjekta`)
    REFERENCES `Sinergija`.`Projekat` (`idProjekta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Projekat_has_Korisnik_Korisnik1`
    FOREIGN KEY (`idKorisnika`)
    REFERENCES `Sinergija`.`Korisnik` (`idKorisnika`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Koordinira_Tim1`
    FOREIGN KEY (`idTima`)
    REFERENCES `Sinergija`.`Tim` (`idTima`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
