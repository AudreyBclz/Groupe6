-- MySQL Script generated by MySQL Workbench
-- Tue Mar 31 15:16:23 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema exo_chaussure
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `exo_chaussure` ;

-- -----------------------------------------------------
-- Schema exo_chaussure
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `exo_chaussure` DEFAULT CHARACTER SET utf8 ;
USE `exo_chaussure` ;

-- -----------------------------------------------------
-- Table `exo_chaussure`.`Adresse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Adresse` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Adresse` (
  `idAdresse` INT NOT NULL AUTO_INCREMENT,
  `numVoieAd` INT NULL,
  `typeVoieAd` VARCHAR(100) NOT NULL,
  `nomVoieAd` VARCHAR(100) NOT NULL,
  `codePostalAd` INT NOT NULL,
  `villeAd` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idAdresse`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exo_chaussure`.`Utilisateur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Utilisateur` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Utilisateur` (
  `idUtilisateur` INT NOT NULL AUTO_INCREMENT,
  `nomutilisateur` VARCHAR(100) NOT NULL,
  `prenomUtilisateur` VARCHAR(100) NOT NULL,
  `roleUtilisateur` VARCHAR(100) NOT NULL,
  `Adresse_idAdresse` INT NOT NULL,
  PRIMARY KEY (`idUtilisateur`, `Adresse_idAdresse`),
  INDEX `fk_Utilisateur_Adresse1_idx` (`Adresse_idAdresse` ASC),
  UNIQUE INDEX `nomutilisateur_UNIQUE` (`nomutilisateur` ASC),
  CONSTRAINT `fk_Utilisateur_Adresse1`
    FOREIGN KEY (`Adresse_idAdresse`)
    REFERENCES `exo_chaussure`.`Adresse` (`idAdresse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exo_chaussure`.`Client`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Client` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Client` (
  `idClient` INT NOT NULL AUTO_INCREMENT,
  `dateNaissClient` DATE NOT NULL,
  `sexeClient` VARCHAR(1) NOT NULL,
  `dateInscClient` DATE NOT NULL,
  `dateModifClient` DATE NULL,
  `raisonModifClient` VARCHAR(100) NULL,
  `Utilisateur_idUtilisateur` INT NOT NULL,
  `Utilisateur_Adresse_idAdresse` INT NOT NULL,
  `Produit_idProduit` INT NOT NULL,
  `Produit_Type_idType` INT NOT NULL,
  PRIMARY KEY (`idClient`, `Utilisateur_idUtilisateur`, `Utilisateur_Adresse_idAdresse`, `Produit_idProduit`, `Produit_Type_idType`),
  INDEX `fk_Client_Utilisateur1_idx` (`Utilisateur_idUtilisateur` ASC, `Utilisateur_Adresse_idAdresse` ASC),
  CONSTRAINT `fk_Client_Utilisateur1`
    FOREIGN KEY (`Utilisateur_idUtilisateur` , `Utilisateur_Adresse_idAdresse`)
    REFERENCES `exo_chaussure`.`Utilisateur` (`idUtilisateur` , `Adresse_idAdresse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exo_chaussure`.`Type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Type` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Type` (
  `idType` INT NOT NULL AUTO_INCREMENT,
  `nomType` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idType`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exo_chaussure`.`Produit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Produit` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Produit` (
  `idProduit` INT NOT NULL AUTO_INCREMENT,
  `nomProduit` VARCHAR(100) NOT NULL,
  `dateEntreeProduit` DATE NOT NULL,
  `descProduit` VARCHAR(255) NOT NULL,
  `stocktProduit` INT(5) NOT NULL,
  `etatProduit` TINYINT NOT NULL,
  `dateModifProduit` DATE NULL,
  `raisonModifProduit` VARCHAR(100) NULL,
  `Type_idType` INT NOT NULL,
  PRIMARY KEY (`idProduit`, `Type_idType`),
  INDEX `fk_Produit_Type1_idx` (`Type_idType` ASC),
  UNIQUE INDEX `nomProduit_UNIQUE` (`nomProduit` ASC),
  CONSTRAINT `fk_Produit_Type1`
    FOREIGN KEY (`Type_idType`)
    REFERENCES `exo_chaussure`.`Type` (`idType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exo_chaussure`.`Fournisseur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Fournisseur` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Fournisseur` (
  `idFournisseur` INT NOT NULL AUTO_INCREMENT,
  `nomSocieteFournisseur` VARCHAR(100) NOT NULL,
  `Utilisateur_idUtilisateur` INT NOT NULL,
  `Utilisateur_Adresse_idAdresse` INT NOT NULL,
  `Produit_idProduit` INT NOT NULL,
  PRIMARY KEY (`idFournisseur`, `Utilisateur_idUtilisateur`, `Utilisateur_Adresse_idAdresse`, `Produit_idProduit`),
  INDEX `fk_Fournisseur_Utilisateur1_idx` (`Utilisateur_idUtilisateur` ASC, `Utilisateur_Adresse_idAdresse` ASC),
  INDEX `fk_Fournisseur_Produit1_idx` (`Produit_idProduit` ASC),
  UNIQUE INDEX `nomSocieteFournisseur_UNIQUE` (`nomSocieteFournisseur` ASC),
  CONSTRAINT `fk_Fournisseur_Utilisateur1`
    FOREIGN KEY (`Utilisateur_idUtilisateur` , `Utilisateur_Adresse_idAdresse`)
    REFERENCES `exo_chaussure`.`Utilisateur` (`idUtilisateur` , `Adresse_idAdresse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Fournisseur_Produit1`
    FOREIGN KEY (`Produit_idProduit`)
    REFERENCES `exo_chaussure`.`Produit` (`idProduit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exo_chaussure`.`Commande`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exo_chaussure`.`Commande` ;

CREATE TABLE IF NOT EXISTS `exo_chaussure`.`Commande` (
  `idCommande` INT NOT NULL AUTO_INCREMENT,
  `dateCommande` DATE NOT NULL,
  `qteCommande` VARCHAR(45) NOT NULL,
  `montantTVA` DECIMAL(3,2) NOT NULL,
  `Produit_idProduit` INT NOT NULL,
  `Produit_Type_idType` INT NOT NULL,
  `Client_idClient` INT NOT NULL,
  `Client_Utilisateur_idUtilisateur` INT NOT NULL,
  `Client_Utilisateur_Adresse_idAdresse` INT NOT NULL,
  `Client_Produit_idProduit` INT NOT NULL,
  `Client_Produit_Type_idType` INT NOT NULL,
  PRIMARY KEY (`idCommande`, `Produit_idProduit`, `Produit_Type_idType`, `Client_idClient`, `Client_Utilisateur_idUtilisateur`, `Client_Utilisateur_Adresse_idAdresse`, `Client_Produit_idProduit`, `Client_Produit_Type_idType`),
  INDEX `fk_Commande_Produit1_idx` (`Produit_idProduit` ASC, `Produit_Type_idType` ASC),
  INDEX `fk_Commande_Client1_idx` (`Client_idClient` ASC, `Client_Utilisateur_idUtilisateur` ASC, `Client_Utilisateur_Adresse_idAdresse` ASC, `Client_Produit_idProduit` ASC, `Client_Produit_Type_idType` ASC),
  CONSTRAINT `fk_Commande_Produit1`
    FOREIGN KEY (`Produit_idProduit` , `Produit_Type_idType`)
    REFERENCES `exo_chaussure`.`Produit` (`idProduit` , `Type_idType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Commande_Client1`
    FOREIGN KEY (`Client_idClient` , `Client_Utilisateur_idUtilisateur` , `Client_Utilisateur_Adresse_idAdresse` , `Client_Produit_idProduit` , `Client_Produit_Type_idType`)
    REFERENCES `exo_chaussure`.`Client` (`idClient` , `Utilisateur_idUtilisateur` , `Utilisateur_Adresse_idAdresse` , `Produit_idProduit` , `Produit_Type_idType`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
