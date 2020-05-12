-- MySQL Script generated by MySQL Workbench
-- Tue May 12 11:48:50 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema paradisecoffee
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `paradisecoffee` ;

-- -----------------------------------------------------
-- Schema paradisecoffee
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `paradisecoffee` DEFAULT CHARACTER SET utf8 ;
USE `paradisecoffee` ;

-- -----------------------------------------------------
-- Table `paradisecoffee`.`adresse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`adresse` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`adresse` (
  `idadresse` INT NOT NULL AUTO_INCREMENT,
  `adresePrenom` VARCHAR(45) NULL,
  `adresseNom` VARCHAR(100) NULL,
  `adresse1` VARCHAR(200) NOT NULL,
  `adresse2` VARCHAR(200) NULL,
  `adresseCP` INT NOT NULL,
  `adresseVille` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idadresse`),
  UNIQUE INDEX `idadresse_UNIQUE` (`idadresse` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paradisecoffee`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`users` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`users` (
  `idUsers` INT NOT NULL AUTO_INCREMENT,
  `nomUsers` VARCHAR(100) NOT NULL,
  `prenomUsers` VARCHAR(100) NOT NULL,
  `mailUsers` VARCHAR(100) NOT NULL,
  `passUsers` VARCHAR(255) NOT NULL,
  `roleUsers` VARCHAR(100) NOT NULL,
  `adresse_idadresse` INT NOT NULL,
  PRIMARY KEY (`idUsers`),
  UNIQUE INDEX `idUsers_UNIQUE` (`idUsers` ASC),
  INDEX `fk_users_adresse_idx` (`adresse_idadresse` ASC),
  CONSTRAINT `fk_users_adresse`
    FOREIGN KEY (`adresse_idadresse`)
    REFERENCES `paradisecoffee`.`adresse` (`idadresse`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paradisecoffee`.`fournisseur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`fournisseur` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`fournisseur` (
  `idfournisseur` INT NOT NULL AUTO_INCREMENT,
  `societeFournisseur` VARCHAR(100) NOT NULL,
  `users_idUsers` INT NOT NULL,
  PRIMARY KEY (`idfournisseur`),
  UNIQUE INDEX `idfournisseur_UNIQUE` (`idfournisseur` ASC),
  INDEX `fk_fournisseur_users1_idx` (`users_idUsers` ASC),
  CONSTRAINT `fk_fournisseur_users1`
    FOREIGN KEY (`users_idUsers`)
    REFERENCES `paradisecoffee`.`users` (`idUsers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paradisecoffee`.`pays`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`pays` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`pays` (
  `idpays` INT NOT NULL AUTO_INCREMENT,
  `nomPays` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idpays`),
  UNIQUE INDEX `idpays_UNIQUE` (`idpays` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paradisecoffee`.`cafe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`cafe` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`cafe` (
  `idcafe` INT NOT NULL AUTO_INCREMENT,
  `nomCafe` VARCHAR(100) NOT NULL,
  `typeCafe` VARCHAR(45) NOT NULL,
  `decafCafe` TINYINT NULL DEFAULT 0,
  `bioCafe` TINYINT NULL DEFAULT 0,
  `prixCafe` DECIMAL(5,2) NOT NULL,
  `resumeCafe` VARCHAR(255) NOT NULL,
  `descCafe` TEXT(10000) NOT NULL,
  `photoCafe` VARCHAR(255) NOT NULL,
  `date_creaCafe` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modifCafe` DATE NULL,
  `selectCafe` TINYINT NULL DEFAULT 0,
  `epuisecafe` TINYINT NULL DEFAULT 0,
  `nbventeCafe` INT NULL DEFAULT 0,
  `stockCafe` INT NULL,
  `pays_idpays` INT NOT NULL,
  `fournisseur_idfournisseur` INT NOT NULL,
  PRIMARY KEY (`idcafe`),
  UNIQUE INDEX `idcafe_UNIQUE` (`idcafe` ASC),
  INDEX `fk_cafe_pays1_idx` (`pays_idpays` ASC),
  INDEX `fk_cafe_fournisseur1_idx` (`fournisseur_idfournisseur` ASC),
  CONSTRAINT `fk_cafe_pays1`
    FOREIGN KEY (`pays_idpays`)
    REFERENCES `paradisecoffee`.`pays` (`idpays`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cafe_fournisseur1`
    FOREIGN KEY (`fournisseur_idfournisseur`)
    REFERENCES `paradisecoffee`.`fournisseur` (`idfournisseur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paradisecoffee`.`commande`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`commande` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`commande` (
  `users_idUsers` INT NOT NULL,
  `cafe_idcafe` INT NOT NULL,
  `dateCommande` DATETIME NOT NULL,
  `quantite` INT NOT NULL,
  `dateLivCommande` DATE NULL,
  `adresse_idadresse` INT NOT NULL,
  PRIMARY KEY (`users_idUsers`, `cafe_idcafe`),
  INDEX `fk_users_has_cafe_cafe1_idx` (`cafe_idcafe` ASC),
  INDEX `fk_users_has_cafe_users1_idx` (`users_idUsers` ASC),
  INDEX `fk_commande_adresse1_idx` (`adresse_idadresse` ASC),
  CONSTRAINT `fk_users_has_cafe_users1`
    FOREIGN KEY (`users_idUsers`)
    REFERENCES `paradisecoffee`.`users` (`idUsers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_cafe_cafe1`
    FOREIGN KEY (`cafe_idcafe`)
    REFERENCES `paradisecoffee`.`cafe` (`idcafe`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_commande_adresse1`
    FOREIGN KEY (`adresse_idadresse`)
    REFERENCES `paradisecoffee`.`adresse` (`idadresse`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paradisecoffee`.`Panier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paradisecoffee`.`Panier` ;

CREATE TABLE IF NOT EXISTS `paradisecoffee`.`Panier` (
  `users_idUsers` INT NOT NULL,
  `cafe_idcafe` INT NOT NULL,
  `quantite` INT NOT NULL,
  `adresse_idadresse` INT NOT NULL,
  PRIMARY KEY (`users_idUsers`, `cafe_idcafe`),
  INDEX `fk_users_has_cafe_cafe1_idx` (`cafe_idcafe` ASC),
  INDEX `fk_users_has_cafe_users1_idx` (`users_idUsers` ASC),
  INDEX `fk_commande_adresse1_idx` (`adresse_idadresse` ASC),
  CONSTRAINT `fk_users_has_cafe_users10`
    FOREIGN KEY (`users_idUsers`)
    REFERENCES `paradisecoffee`.`users` (`idUsers`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_cafe_cafe10`
    FOREIGN KEY (`cafe_idcafe`)
    REFERENCES `paradisecoffee`.`cafe` (`idcafe`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_commande_adresse10`
    FOREIGN KEY (`adresse_idadresse`)
    REFERENCES `paradisecoffee`.`adresse` (`idadresse`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
