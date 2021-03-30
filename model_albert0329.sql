-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema tidytubes
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tidytubes
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tidytubes` DEFAULT CHARACTER SET utf8 ;
USE `tidytubes` ;

-- -----------------------------------------------------
-- Table `tidytubes`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`User` (
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
  `Profile_image` VARCHAR(1000) NULL,
  `idUser` INT AUTO_INCREMENT NOT NULL,
  PRIMARY KEY (`idUser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tidytubes`.`Sample`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`Sample` (
  `idSample` INT AUTO_INCREMENT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Cell_type` VARCHAR(45) NULL,
  `Frozendate` VARCHAR(45) NULL,
  `Availability` VARCHAR(45) NULL,
  `Comment` VARCHAR(300) NULL,
  `Position` VARCHAR(45) NULL,
  `Amount` INT NULL,
  `idUser` INT NOT NULL,
  `idStorage` INT NOT NULL,
  PRIMARY KEY (`idSample`),
  CONSTRAINT `fk_Sample_User`
    FOREIGN KEY (`idUser`)
    REFERENCES `tidytubes`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sample_Storage`
    FOREIGN KEY (`idStorage`)
    REFERENCES `tidytubes`.`Storage` (`idStorage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tidytubes`.`Storage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`Storage` (
  `idStorage` INT AUTO_INCREMENT NOT NULL,
  `Storagename` VARCHAR(45) NULL,
  `Location` VARCHAR(45) NULL,
  PRIMARY KEY (`idStorage`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tidytubes`.`User_has_Storage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`User_has_Storage` (
  `User_idUser` INT NOT NULL,
  `Storage_idStorage` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `Storage_idStorage`),
  INDEX `fk_User_has_Storage_Storage1_idx` (`Storage_idStorage` ASC) VISIBLE,
  INDEX `fk_User_has_Storage_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_Storage_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `tidytubes`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Storage_Storage1`
    FOREIGN KEY (`Storage_idStorage`)
    REFERENCES `tidytubes`.`Storage` (`idStorage`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tidytubes`.`Labgroup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`Labgroup` (
  `idLabgroup` INT AUTO_INCREMENT NOT NULL,
  `Labgroupname` VARCHAR(45) NULL,
  PRIMARY KEY (`idLabgroup`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tidytubes`.`Request`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`Request` (
  `idRequest` INT AUTO_INCREMENT NOT NULL,
  `Name` VARCHAR(45) NULL,
  `Cell_type` VARCHAR(45) NULL,
  `Requestdate` VARCHAR(45) NULL,
  `Availability` VARCHAR(45) NULL,
  `Comment` VARCHAR(300) NULL,
  `Position` VARCHAR(45) NULL,
  `Amount` INT NULL,
  `idUser` INT NOT NULL,
  `idLabgroup` INT NOT NULL,
  PRIMARY KEY (`idRequest`),
  CONSTRAINT `fk_Request_User`
    FOREIGN KEY (`idUser`)
    REFERENCES `tidytubes`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Request_Labgroup`
    FOREIGN KEY (`idLabgroup`)
    REFERENCES `tidytubes`.`Labgroup` (`idLabgroup`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `tidytubes`.`User_has_Labgroup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tidytubes`.`User_has_Labgroup` (
  `User_idUser` INT NOT NULL,
  `Labgroup_idLabgroup` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `Labgroup_idLabgroup`),
  INDEX `fk_User_has_Labgroup_Labgroup1_idx` (`Labgroup_idLabgroup` ASC) VISIBLE,
  INDEX `fk_User_has_Labgroup_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_Labgroup_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `tidytubes`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Labgroup_Labgroup1`
    FOREIGN KEY (`Labgroup_idLabgroup`)
    REFERENCES `tidytubes`.`Labgroup` (`idLabgroup`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
