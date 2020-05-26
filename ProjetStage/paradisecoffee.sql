-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mar. 26 mai 2020 à 14:46
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `paradisecoffee`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `idadresse` int(11) NOT NULL AUTO_INCREMENT,
  `adressePrenom` varchar(45) DEFAULT NULL,
  `adresseNom` varchar(100) DEFAULT NULL,
  `adresse1` varchar(200) NOT NULL,
  `adresse2` varchar(200) DEFAULT NULL,
  `adresseCP` varchar(50) NOT NULL,
  `adresseVille` varchar(100) NOT NULL,
  `pays_idpays` int(11) NOT NULL,
  PRIMARY KEY (`idadresse`),
  UNIQUE KEY `idadresse_UNIQUE` (`idadresse`),
  KEY `fk_adresse_pays1_idx` (`pays_idpays`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`idadresse`, `adressePrenom`, `adresseNom`, `adresse1`, `adresse2`, `adresseCP`, `adresseVille`, `pays_idpays`) VALUES
(1, NULL, NULL, '25 rue des Fleurs', '', '75000', 'Paris', 1),
(2, NULL, NULL, 'Colonia Altos Lomas del Guijarrro Sur', '4ta. Avenida, 2da Calle, Bloque B, Lote 7,Fte. al BID', 'AP 3441', 'Tegucigalpa', 2),
(3, NULL, NULL, '5th Floor NHIT Building', 'Ragati Road', 'P.O Box 34670-00100', 'Nairobi', 3),
(4, NULL, NULL, 'bât B imm De La Balance', '4 rue Jules Thirel, Bellemene', '97460', 'Saint-Paul', 1),
(5, 'Elsa', 'Minerve', '50 rue du Général de Gaulle', '', '59000', 'Lille', 1),
(12, '', '', '', '', '', '', 6),
(13, 'James', 'Bond', '007 rue de l\'Espion', '', '42000', 'Saint-Etienne', 1),
(14, NULL, NULL, '5 rue du con qui Baille', '', '62800', 'Liévin', 1),
(15, 'Maury', 'Bon', '39 rue des Soupirs', '', '62100', 'Calais', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cafe`
--

DROP TABLE IF EXISTS `cafe`;
CREATE TABLE IF NOT EXISTS `cafe` (
  `idcafe` int(11) NOT NULL AUTO_INCREMENT,
  `nomCafe` varchar(100) NOT NULL,
  `typeCafe` varchar(45) NOT NULL,
  `decafCafe` tinyint(4) DEFAULT '0',
  `bioCafe` tinyint(4) DEFAULT '0',
  `prixCafe` decimal(5,2) NOT NULL,
  `resumeCafe` varchar(255) NOT NULL,
  `descCafe` text NOT NULL,
  `photoCafe` varchar(255) NOT NULL,
  `date_creaCafe` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modifCafe` date DEFAULT NULL,
  `selectCafe` tinyint(4) DEFAULT '0',
  `nbventeCafe` int(11) DEFAULT '0',
  `stockCafe` int(11) DEFAULT NULL,
  `pays_idpays` int(11) NOT NULL,
  `fournisseur_idfournisseur` int(11) NOT NULL,
  PRIMARY KEY (`idcafe`),
  UNIQUE KEY `idcafe_UNIQUE` (`idcafe`),
  KEY `fk_cafe_pays1_idx` (`pays_idpays`),
  KEY `fk_cafe_fournisseur1_idx` (`fournisseur_idfournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cafe`
--

INSERT INTO `cafe` (`idcafe`, `nomCafe`, `typeCafe`, `decafCafe`, `bioCafe`, `prixCafe`, `resumeCafe`, `descCafe`, `photoCafe`, `date_creaCafe`, `date_modifCafe`, `selectCafe`, `nbventeCafe`, `stockCafe`, `pays_idpays`, `fournisseur_idfournisseur`) VALUES
(1, 'Arabica', 'En grain', 1, 1, '20.00', 'Un très bon café léger et subtile!', 'Je suis riche en arômes&lt;br /&gt;\r\nMa finesse gustative est particulièrement appréciée des « gourmets »&lt;br /&gt;\r\nJ’offre plutôt des notes acidulées et moins amères', 'cafe-vrac.png', '2020-05-23 09:33:05', '2020-05-24', NULL, 5, 45, 2, 1),
(2, 'Arabica Moulu', 'Moulu', 1, 1, '9.51', 'Un très bon café moulu léger et subtile!', 'Un très bon café moulu léger et subtile!<br />\r\nUn très bon café moulu léger et subtile!<br />\r\nUn très bon café moulu léger et subtile!<br />\r\nUn très bon café moulu léger et subtile!<br />\r\nUn très bon café moulu léger et subtile! Un très bon café moulu léger et subtile!', 'paquet.png', '2020-05-23 09:35:39', '2020-05-25', 1, 4, 46, 2, 1),
(3, 'Robusta', 'En grain', NULL, 1, '21.00', 'Une belle amertume en bouche!', 'Pour les amateurs de méthodes douces (type Chemex ou Hario par exemple), je vous conseille un Arabica du Kenya : coup de coeur de nos torréfacteurs !   pour les amateurs de méthodes douces (type Chemex ou Hario par exemple), je vous conseille un Arabica du Kenya : coup de coeur de nos torréfacteurs !<br />\r\n  pour les amateurs de méthodes douces (type Chemex ou Hario par exemple), je vous conseille un Arabica du Kenya : coup de coeur de nos torréfacteurs !', 'Cafe-En-Grain.jpg', '2020-05-23 09:38:57', '2020-05-25', 1, 6, 24, 3, 2),
(4, 'Robusta Moulu', 'Moulu', NULL, 1, '10.49', 'Un super café moulu,', 'un très bon café plein de caractères et de force qui ravira vos palais! un très bon café plein de caractères et de force qui ravira vos palais! un très bon café plein de caractères et de force qui ravira vos palais!<br />\r\nun très bon café plein de caractères et de force qui ravira vos palais!', 'paquet.png', '2020-05-23 09:41:28', '2020-05-25', NULL, 2, 28, 3, 2),
(5, 'Bourbon Pointu Grand Cru', 'En grain', NULL, NULL, '400.00', 'Un café d\'exception.', 'Un café exceptionnel<br />\r\n<br />\r\nLe Bourbon pointu (Laurina) est l’une des variétés d’arabica les plus anciennes au monde. Oublié car peu productif, peu caféiné et sensible aux maladies, des hommes menés par un terroir exceptionnel, le Piton des Neiges, lui ont redonné toute sa grâce. <br />\r\n<br />\r\n<br />\r\nUn produit extrêmement rare<br />\r\n<br />\r\nLe Bourbon pointu est produit à quelques centaines de kilos seulement et concentre toutes les attentions de la culture au tri. Ses grains oblongs, sa finesse, sa délicatesse offrent un plaisir intense.<br />\r\n<br />\r\n<br />\r\nUn café de méditation<br />\r\n<br />\r\nLe Bourbon Pointu Grand Cru se dénote par une dominante de fruits rouges. Sa tasse équilibrée, pleine et fine offre une longueur en bouche qui sied parfaitement aux fins de repas.', 'tasseCafe.png', '2020-05-23 09:52:01', '2020-05-25', 1, 2, 8, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `idLigneCommande` int(11) NOT NULL AUTO_INCREMENT,
  `users_idUsers` int(11) NOT NULL,
  `cafe_idcafe` int(11) NOT NULL,
  `dateCommande` datetime NOT NULL,
  `quantite` int(11) NOT NULL,
  `dateLivCommande` date DEFAULT NULL,
  `adresse_idadresse` int(11) NOT NULL,
  PRIMARY KEY (`idLigneCommande`),
  KEY `fk_users_has_cafe_cafe1_idx` (`cafe_idcafe`),
  KEY `fk_users_has_cafe_users1_idx` (`users_idUsers`),
  KEY `fk_commande_adresse1_idx` (`adresse_idadresse`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`idLigneCommande`, `users_idUsers`, `cafe_idcafe`, `dateCommande`, `quantite`, `dateLivCommande`, `adresse_idadresse`) VALUES
(1, 1, 3, '2020-05-23 10:23:11', 1, '2020-05-23', 5),
(2, 1, 5, '2020-05-23 10:24:36', 1, '2020-05-23', 1),
(3, 1, 2, '2020-05-23 10:27:39', 2, NULL, 5),
(4, 1, 3, '2020-05-23 10:27:39', 1, NULL, 5),
(5, 10, 1, '2020-05-23 10:55:09', 3, '2020-05-25', 1),
(6, 10, 5, '2020-05-23 11:02:23', 1, '2020-05-23', 13),
(7, 10, 1, '2020-05-23 11:25:20', 1, NULL, 1),
(8, 10, 3, '2020-05-23 11:25:20', 1, NULL, 1),
(9, 10, 4, '2020-05-23 11:25:20', 1, NULL, 1),
(10, 11, 1, '2020-05-24 12:10:51', 1, NULL, 14),
(11, 11, 2, '2020-05-24 12:13:55', 1, '2020-05-24', 15),
(12, 11, 3, '2020-05-24 12:13:55', 1, '2020-05-24', 15),
(13, 1, 4, '2020-05-25 09:33:27', 1, NULL, 1),
(14, 11, 2, '2020-05-25 15:58:52', 1, NULL, 14),
(15, 11, 3, '2020-05-25 16:00:46', 2, NULL, 14);

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `idfournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `societeFournisseur` varchar(100) NOT NULL,
  `users_idUsers` int(11) NOT NULL,
  PRIMARY KEY (`idfournisseur`),
  UNIQUE KEY `idfournisseur_UNIQUE` (`idfournisseur`),
  KEY `fk_fournisseur_users1_idx` (`users_idUsers`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`idfournisseur`, `societeFournisseur`, `users_idUsers`) VALUES
(1, 'SARL Café Divin', 2),
(2, 'Top Café', 3),
(3, 'Café Réunionais', 4);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `users_idUsers` int(11) NOT NULL,
  `cafe_idcafe` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `adresse_idadresse` int(11) NOT NULL,
  PRIMARY KEY (`users_idUsers`,`cafe_idcafe`),
  KEY `fk_users_has_cafe_cafe1_idx` (`cafe_idcafe`),
  KEY `fk_users_has_cafe_users1_idx` (`users_idUsers`),
  KEY `fk_commande_adresse1_idx` (`adresse_idadresse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`users_idUsers`, `cafe_idcafe`, `quantite`, `adresse_idadresse`) VALUES
(1, 2, 5, 1),
(11, 4, 1, 14);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `idpays` int(11) NOT NULL AUTO_INCREMENT,
  `nomPays` varchar(45) NOT NULL,
  PRIMARY KEY (`idpays`),
  UNIQUE KEY `idpays_UNIQUE` (`idpays`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`idpays`, `nomPays`) VALUES
(1, 'France'),
(2, 'Honduras'),
(3, 'Kenya'),
(6, '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUsers` int(11) NOT NULL AUTO_INCREMENT,
  `nomUsers` varchar(100) NOT NULL,
  `prenomUsers` varchar(100) NOT NULL,
  `mailUsers` varchar(100) NOT NULL,
  `passUsers` varchar(255) NOT NULL,
  `roleUsers` varchar(100) NOT NULL,
  `adresse_idadresse` int(11) NOT NULL,
  PRIMARY KEY (`idUsers`),
  UNIQUE KEY `idUsers_UNIQUE` (`idUsers`),
  KEY `fk_users_adresse_idx` (`adresse_idadresse`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUsers`, `nomUsers`, `prenomUsers`, `mailUsers`, `passUsers`, `roleUsers`, `adresse_idadresse`) VALUES
(1, 'Minerve', 'Sam', 'sam@sam.fr', '$2y$10$PzHbrF6cctuuLIb5/lc4ruxfaIGvlhzqYVsMRG2IdK5lRkDMw2/v2', 'admin', 1),
(2, 'Dupont', 'Michel', 'michel.D@divin.fr', '$2y$10$6glKnVtRGnLIOCX8U5Jo7.rxkk7HpYwqTBVNDrjJCZU.AT3R1UVlu', 'fournisseur', 2),
(3, 'Arthur', 'James', 'james.A@topcafe.com', '$2y$10$.2mPil/0ZtmwLJya8Ko0KuOXr19xlQrzJGZLi8AfQaQbIAQmWQgjm', 'fournisseur', 3),
(4, 'Gwodésire', 'Kenny', 'Kenny.G@cafereunionais.fr', '$2y$10$CNs7zKjn6CAmO.PWlKLFDe3zVTc0JVfl1W9.eRVxhPiC0TmtRrpta', 'fournisseur', 4),
(10, 'Minerve', 'Elle', 'elle@elle.fr', '$2y$10$lQblECXoNqGoiQZ9de7Pf..YQ5awQgjbYdgGM8mi3yzwPQFrM9Y4i', 'client', 1),
(11, 'Bon', 'Jean', 'jean@bon.fr', '$2y$10$iwE.E0SdR4SRU3UES0I/kONkKjkS6lBbYb5bX7IbZV27e6jyrydxq', 'client', 14);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `fk_adresse_pays1` FOREIGN KEY (`pays_idpays`) REFERENCES `pays` (`idpays`);

--
-- Contraintes pour la table `cafe`
--
ALTER TABLE `cafe`
  ADD CONSTRAINT `fk_cafe_fournisseur1` FOREIGN KEY (`fournisseur_idfournisseur`) REFERENCES `fournisseur` (`idfournisseur`),
  ADD CONSTRAINT `fk_cafe_pays1` FOREIGN KEY (`pays_idpays`) REFERENCES `pays` (`idpays`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_commande_adresse1` FOREIGN KEY (`adresse_idadresse`) REFERENCES `adresse` (`idadresse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_has_cafe_cafe1` FOREIGN KEY (`cafe_idcafe`) REFERENCES `cafe` (`idcafe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_has_cafe_users1` FOREIGN KEY (`users_idUsers`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD CONSTRAINT `fk_fournisseur_users1` FOREIGN KEY (`users_idUsers`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_commande_adresse10` FOREIGN KEY (`adresse_idadresse`) REFERENCES `adresse` (`idadresse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_has_cafe_cafe10` FOREIGN KEY (`cafe_idcafe`) REFERENCES `cafe` (`idcafe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_has_cafe_users10` FOREIGN KEY (`users_idUsers`) REFERENCES `users` (`idUsers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_adresse` FOREIGN KEY (`adresse_idadresse`) REFERENCES `adresse` (`idadresse`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
