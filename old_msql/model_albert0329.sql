-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User` (
  `Email` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  `Username` VARCHAR(45) NOT NULL,
  `Full_name` VARCHAR(100) NULL,
  `Main_task` VARCHAR(45) NULL,
  `Position` VARCHAR(45) NULL,
  `Contact_phone` VARCHAR(45) NULL,
  `Contact_email` VARCHAR(45) NULL,
  `Institute` VARCHAR(45) NULL,
  `Find_me` VARCHAR(246) NULL,
  `Profile_image` VARCHAR(45) NULL,
  `idUser` INT AUTO_INCREMENT NOT NULL,
  PRIMARY KEY (`idUser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Sample`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Sample` (
  `idSample` INT AUTO_INCREMENT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Cell_type` VARCHAR(45) NULL,
  `Frozendate` VARCHAR(45) NULL,
  `Availability` VARCHAR(45) NULL,
  `Comment` VARCHAR(300) NULL,
  `Position` VARCHAR(45) NULL,
  `idUser` INT NOT NULL,
  `idStorage` INT NOT NULL,
  PRIMARY KEY (`idSample`),
  CONSTRAINT `fk_Sample_User`
    FOREIGN KEY (`idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sample_Storage`
    FOREIGN KEY (`idStorage`)
    REFERENCES `mydb`.`Storage` (`idStorage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`role` (
  `idrole` INT AUTO_INCREMENT NOT NULL,
  PRIMARY KEY (`idrole`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`role_has_User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`role_has_User` (
  `role_idrole` INT AUTO_INCREMENT NOT NULL,
  `User_idUser` INT NOT NULL,
  PRIMARY KEY (`role_idrole`, `User_idUser`),
  CONSTRAINT `fk_role_has_User_role`
    FOREIGN KEY (`role_idrole`)
    REFERENCES `mydb`.`role` (`idrole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Storage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Storage` (
  `idStorage` INT AUTO_INCREMENT NOT NULL,
  `Storagename` VARCHAR(45) NULL,
  `Location` VARCHAR(45) NULL,
  PRIMARY KEY (`idStorage`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Request`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Request` (
  `idRequests` INT AUTO_INCREMENT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Cell_type` VARCHAR(45) NULL,
  `Date` VARCHAR(45) NULL,
  `Availability` VARCHAR(45) NULL,
  `Comment` VARCHAR(45) NULL,
  `Position` VARCHAR(45) NULL,
  PRIMARY KEY (`idRequests`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`User_has_Request`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User_has_Request` (
  `User_idUser` INT AUTO_INCREMENT NOT NULL,
  `Request_idRequests` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `Request_idRequests`),
  INDEX `fk_User_has_Request_Request1_idx` (`Request_idRequests` ASC) VISIBLE,
  INDEX `fk_User_has_Request_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_Request_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Request_Request1`
    FOREIGN KEY (`Request_idRequests`)
    REFERENCES `mydb`.`Request` (`idRequests`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`User_has_Storage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User_has_Storage` (
  `User_idUser` INT NOT NULL,
  `Storage_idStorage` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `Storage_idStorage`),
  INDEX `fk_User_has_Storage_Storage1_idx` (`Storage_idStorage` ASC) VISIBLE,
  INDEX `fk_User_has_Storage_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_Storage_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Storage_Storage1`
    FOREIGN KEY (`Storage_idStorage`)
    REFERENCES `mydb`.`Storage` (`idStorage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -- -----------------------------------------------------
-- -- Table `mydb`.`Sample_has_Storage`
-- -- -----------------------------------------------------
-- CREATE TABLE IF NOT EXISTS `mydb`.`Sample_has_Storage` (
--   `Sample_idSample` INT NOT NULL,
--   `Storage_idStorage` INT NOT NULL,
--   PRIMARY KEY (`Sample_idSample`, `Storage_idStorage`),
--   INDEX `fk_Sample_has_Storage_Storage1_idx` (`Storage_idStorage` ASC) VISIBLE,
--   INDEX `fk_Sample_has_Storage_Sample1_idx` (`Sample_idSample` ASC) VISIBLE,
--   CONSTRAINT `fk_Sample_has_Storage_Sample1`
--     FOREIGN KEY (`Sample_idSample`)
--     REFERENCES `mydb`.`Sample` (`idSample`)
--     ON DELETE NO ACTION
--     ON UPDATE NO ACTION,
--   CONSTRAINT `fk_Sample_has_Storage_Storage1`
--     FOREIGN KEY (`Storage_idStorage`)
--     REFERENCES `mydb`.`Storage` (`idStorage`)
--     ON DELETE NO ACTION
--     ON UPDATE NO ACTION)
-- ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
