-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 20 oct. 2020 à 13:59
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `vsttreservation`
--

-- --------------------------------------------------------

--
-- Structure de la table `res_creneaux`
--

DROP TABLE IF EXISTS `res_creneaux`;
CREATE TABLE IF NOT EXISTS `res_creneaux` (
  `id_creneau` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(35) NOT NULL,
  `Salle` varchar(25) NOT NULL DEFAULT 'Coppée',
  `Jour` tinyint(4) NOT NULL,
  `Heure_Debut` time NOT NULL,
  `Heure_Fin` time NOT NULL,
  `Libre` enum('Oui','Non') NOT NULL DEFAULT 'Non',
  `id_ouvreur` int(11) NOT NULL DEFAULT 0,
  `Nbr_Place` int(11) NOT NULL DEFAULT 12,
  `Ord` int(11) NOT NULL DEFAULT 0,
  `Actif` enum('Oui','Non') NOT NULL DEFAULT 'Oui',
  PRIMARY KEY (`id_creneau`),
  KEY `id_ouvreur` (`id_ouvreur`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `res_creneaux`
--

INSERT INTO `res_creneaux` (`id_creneau`, `Nom`, `Salle`, `Jour`, `Heure_Debut`, `Heure_Fin`, `Libre`, `id_ouvreur`, `Nbr_Place`, `Ord`, `Actif`) VALUES
(1, 'Libre', 'Coppée', 1, '18:30:00', '20:00:00', 'Oui', 9317315, 10, 0, 'Oui'),
(2, 'Loisir', 'Coppée', 1, '20:00:00', '21:00:00', 'Non', 93396, 12, 11, 'Oui'),
(3, 'Equipe 9,  10', 'Coppée', 1, '21:00:00', '22:30:00', 'Non', 93396, 12, 11, 'Oui'),
(4, 'Libre', 'Coppée', 2, '18:30:00', '20:30:00', 'Oui', 0, 10, 0, 'Oui'),
(5, 'Equipe 1 à 3', 'Coppée', 2, '20:30:00', '22:30:00', 'Non', 7712599, 12, 0, 'Oui'),
(6, 'Equpe 3 à 8', 'Coppée', 3, '19:00:00', '20:30:00', 'Non', 865607, 10, 31, 'Oui'),
(7, 'Equipe 3 à 8', 'Coppée', 3, '20:30:00', '22:00:00', 'Non', 865607, 12, 31, 'Oui'),
(8, 'Libre', 'Tcheuméo', 2, '20:00:00', '22:00:00', 'Oui', 0, 10, 0, 'Oui'),
(9, 'Libre', 'Tcheuméo', 6, '18:00:00', '19:00:00', 'Oui', 0, 10, 0, 'Oui'),
(10, 'Libre', 'Coppée', 7, '15:00:00', '16:30:00', 'Oui', 9317315, 10, 1, 'Oui'),
(11, 'Libre', 'Coppée', 7, '16:30:00', '18:00:00', 'Oui', 0, 10, 1, 'Oui'),
(12, 'Libre', 'Coppée', 7, '18:00:00', '19:30:00', 'Oui', 0, 10, 1, 'Oui'),
(13, 'Libre', 'Coppée', 7, '19:30:00', '21:00:00', 'Oui', 0, 10, 1, 'Oui'),
(15, 'Débutant', 'Coppée', 6, '10:00:00', '11:30:00', 'Non', 9317315, 12, 0, 'Oui');

-- --------------------------------------------------------

--
-- Structure de la table `res_fftt`
--

DROP TABLE IF EXISTS `res_fftt`;
CREATE TABLE IF NOT EXISTS `res_fftt` (
  `id_licencier` int(11) NOT NULL,
  `Serie` char(15) NOT NULL,
  PRIMARY KEY (`id_licencier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Numéro de série de l’utilisateur qui émet la demande';

--
-- Déchargement des données de la table `res_fftt`
--

INSERT INTO `res_fftt` (`id_licencier`, `Serie`) VALUES
(9317315, 'APZ1VLU89BEQHPE');

-- --------------------------------------------------------

--
-- Structure de la table `res_licencies`
--

DROP TABLE IF EXISTS `res_licencies`;
CREATE TABLE IF NOT EXISTS `res_licencies` (
  `id_licencier` int(11) NOT NULL,
  `Civilite` enum('Mr','Mme') NOT NULL DEFAULT 'Mr',
  `Nom` varchar(35) NOT NULL,
  `Surnom` varchar(35) DEFAULT NULL,
  `Prenom` varchar(35) NOT NULL,
  `Classement` int(11) NOT NULL DEFAULT 5,
  `Equipe` tinyint(4) NOT NULL DEFAULT 0,
  `Telephone` varchar(14) NOT NULL DEFAULT '01.01.01.01.01',
  `Email` varchar(50) NOT NULL DEFAULT 'pas.saisie@faux',
  `Ouvreur` enum('Oui','Non') NOT NULL DEFAULT 'Non',
  `Admin` varchar(10) NOT NULL DEFAULT 'Non',
  `Actif` enum('Oui','Non') NOT NULL DEFAULT 'Oui',
  PRIMARY KEY (`id_licencier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `res_licencies`
--

INSERT INTO `res_licencies` (`id_licencier`, `Civilite`, `Nom`, `Surnom`, `Prenom`, `Classement`, `Equipe`, `Telephone`, `Email`, `Ouvreur`, `Admin`, `Actif`) VALUES
(1, 'Mr', 'GHERMAN', '', 'Vasile', 5, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(2, 'Mr', 'DIONNET', '', 'Laurent', 5, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(3, 'Mr', 'BILMAN', '', 'William', 5, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(4, 'Mr', 'OUFELLA', '', 'Arezki', 5, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(93396, 'Mr', 'DALLE PIAGGE', '', 'Yves', 0, 7, '06.80.77.48.00', 'pas.saisie@faux', 'Oui', '4pP4RER+TL', 'Oui'),
(93413, 'Mr', 'GRANDIN', 'NANAR', 'Bernard', 0, 0, '06.01.02.03.05', 'pas.saisie@faux', 'Non', '', 'Oui'),
(93728, 'Mr', 'LAMOLINAIRIE', '', 'Henrique', 0, 0, '', '', 'Non', '', 'Oui'),
(773840, 'Mr', 'CONCHON', '', 'Sylvain', 5, 3, '06.72.80.88.00', 'beuhaaar@yahoo.fr', 'Non', '', 'Oui'),
(865607, 'Mr', 'WILMUS', '', 'Franck', 15, 3, '06.62.55.94.72', 'pas.saisie@faux', 'Oui', '', 'Oui'),
(931327, 'Mr', 'VALADE', '', 'Patrick', 0, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(933602, 'Mr', 'LABOUREAU', '', 'Pierre', 0, 7, '06.71.28.37.86', 'bureau@vstt.com', 'Oui', 'e9j>WMhy3z', 'Oui'),
(933604, 'Mr', 'PALUYAN', '', 'Ari', 0, 3, '06.48.28.98.96', 'bureau@vstt.com', 'Non', '', 'Oui'),
(935669, 'Mr', 'DUVAL', '', 'Jérôme', 0, 0, '06.03.23.06.04', 'pas.saisie@faux', 'Oui', '', 'Oui'),
(935871, 'Mr', 'BOULANGER', '', 'Frédéric', 0, 7, '06.78.92.23.52', 'pas.saisie@faux', 'Non', '', 'Oui'),
(935888, 'Mr', 'ANDRIEU', '', 'Luc', 5, 5, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(936887, 'Mr', 'MAYOUTE', '', 'Cedric', 5, 3, '06.86.52.66.26', 'pas.saisie@faux', 'Non', '', 'Oui'),
(936927, 'Mme', 'AUBIN', '', 'Marie-agnès', 5, 7, '06.19.76.04.29', 'bureau@vstt.com', 'Non', '', 'Oui'),
(937183, 'Mr', 'TORVAL', '', 'Eddie', 5, 5, '07.86.03.60.50', 'pas.saisie@faux', 'Non', '', 'Oui'),
(937876, 'Mr', 'DESBOIS', '', 'Sébastien', 0, 0, '', '', 'Oui', 'i9pWJ[Wc9K', 'Oui'),
(938125, 'Mme', 'AUBIN', '', 'Janine', 0, 0, '', '', 'Non', '', 'Oui'),
(938219, 'Mr', 'GICQUEL', '', 'Erwann', 5, 2, '01.01.01.01.01', 'acbtennisdetable@alicepro.fr', 'Non', '', 'Oui'),
(938986, 'Mr', 'IMAQUE', '', 'Stéphane', 5, 5, '07.87.75.40.85', 'pas.saisie@faux', 'Non', '', 'Oui'),
(939644, 'Mr', 'LECOCQ', '', 'Xavier', 0, 6, '06.01.02.03.04', 'pas.saisie@faux', 'Non', '>LecocqXa<', 'Oui'),
(939804, 'Mr', 'QUINQUIS', '', 'Dominique', 5, 4, '06.72.95.67.41', 'pas.saisie@faux', 'Non', '', 'Oui'),
(949068, 'Mr', 'JOLY', '', 'Christophe', 0, 2, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(951246, 'Mr', 'MACHET', '', 'Thierry', 0, 1, '07.89.01.50.86', 't.machet@wanadoo.fr', 'Non', '', 'Oui'),
(957044, 'Mr', 'COLOMER', '', 'Thierry', 0, 0, '01.39.95.07.57', 'pas.saisie@faux', 'Non', '', 'Oui'),
(3726084, 'Mr', 'YE', '', 'Julien', 5, 9, '06.46.49.14.50', 'pure_yf@yahoo.fr', 'Non', '', 'Oui'),
(7711698, 'Mr', 'CHARDIN', 'GuiGui', 'Guillaume', 18, 1, '06.63.08.65.56', 'pas.saisie@faux', 'Oui', '', 'Oui'),
(7712599, 'Mr', 'DE LA BARRERA', '', 'Romain', 16, 1, '06.77.19.07.59', 'romain_77500@hotmail.fr', 'Oui', '', 'Oui'),
(7712701, 'Mme', 'CONSTANT MORAND', '', 'Caroline', 5, 9, '01.01.01.01.01', 'speedy-caro@orange.fr', 'Non', '', 'Oui'),
(7714816, 'Mr', 'JEAN BAPTISTE', '', 'Jerome', 5, 0, '06.17.12.08.19', 'pas.saisie@faux', 'Non', '', 'Oui'),
(7717097, 'Mr', 'JOLY', '', 'Clément', 5, 1, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(7727498, 'Mr', 'STAUBER', '', 'Julien', 5, 2, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9311514, 'Mr', 'BARTHELEMY', '', 'Stéphane', 0, 8, '06.01.81.68.30', 'bureau@vstt.com', 'Oui', '#Stephane>', 'Oui'),
(9311718, 'Mr', 'MERELLE', '', 'Jacques', 0, 8, '06.89.55.31.03', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9311926, 'Mr', 'LELIEUX', '', 'Jérôme', 0, 7, '06.10.65.49.88', 'j.lelieux@berim.fr', 'Non', '', 'Oui'),
(9312434, 'Mr', 'NICOLAS', NULL, 'Jean-françois', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9312573, 'Mr', 'QUINQUIS', '', 'Erwann', 5, 1, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9312604, 'Mr', 'CARON', '', 'Donovan', 0, 1, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9312607, 'Mr', 'SAINTON', '', 'Nicolas', 5, 4, '06.86.82.21.03', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9312611, 'Mr', 'ESNAULT', '', 'Jérémy', 0, 4, '06.01.02.03.05', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9312623, 'Mr', 'DINOT', '', 'Samuel', 0, 1, '01.01.01.01.01', 'pas.saisie@faux', 'Oui', '', 'Oui'),
(9312754, 'Mr', 'GIORDANO', '', 'Christophe', 0, 0, '', '', 'Non', '', 'Oui'),
(9312902, 'Mr', 'CHAPUS-MINETTO', '', 'Brigitte', 0, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9313033, 'Mr', 'PEETERS', '', 'Marie-laure', 0, 0, '', '', 'Non', '', 'Oui'),
(9313532, 'Mr', 'GROSCOT', '', 'Jose', 0, 0, '', '', 'Non', '', 'Oui'),
(9313773, 'Mr', 'LEMOINE', '', 'Alexandre', 0, 2, '06.33.17.78.47', 'lemoine.alexandre@live.fr', 'Oui', '', 'Oui'),
(9313882, 'Mr', 'HALIN', '', 'Marcel', 0, 0, '', '', 'Non', '', 'Oui'),
(9314069, 'Mr', 'SALMON', '', 'Dominique', 0, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9314199, 'Mr', 'ROBERT', '', 'Philippe', 0, 0, '', '', 'Non', '', 'Oui'),
(9314255, 'Mr', 'BOSSÉ', '', 'Arthur', 0, 0, '', '', 'Non', '', 'Oui'),
(9314351, 'Mr', 'PUTIGNY', '', 'Tony', 5, 2, '06.20.78.33.58', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9314691, 'Mr', 'DRUART', '', 'Anthony', 0, 8, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9315171, 'Mr', 'LOUISE', '', 'Norbert', 0, 0, '', '', 'Non', '', 'Oui'),
(9315195, 'Mr', 'DEHAINE', '', 'François', 0, 0, '', '', 'Non', '', 'Oui'),
(9315215, 'Mr', 'GIBON', '', 'Florian', 0, 0, '', '', 'Non', '', 'Oui'),
(9315622, 'Mr', 'CARON', '', 'Patricia', 0, 0, '', '', 'Non', '', 'Oui'),
(9315851, 'Mr', 'SAGUES', '', 'David', 0, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9315906, 'Mr', 'CHALET', '', 'Sébastien', 0, 0, '', '', 'Non', '', 'Oui'),
(9315950, 'Mr', 'ZANNONI', '', 'Florent', 0, 0, '', '', 'Non', '', 'Oui'),
(9316145, 'Mr', 'BILLARD', '', 'Bruno', 0, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9316334, 'Mr', 'PAPP', '', 'Ladislau', 0, 3, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9316339, 'Mr', 'DOINEAU', '', 'Lucas', 0, 0, '', '', 'Non', '', 'Oui'),
(9316466, 'Mr', 'MICHEL', '', 'Antoine', 0, 0, '06.07.68.82.13', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9316502, 'Mr', 'GALEA', '', 'Jean pierre', 0, 0, '', '', 'Non', '', 'Oui'),
(9316613, 'Mr', 'SILLOU', '', 'Elisa', 0, 0, '', '', 'Non', '', 'Oui'),
(9316851, 'Mr', 'ITIM', '', 'Akima', 0, 0, '', '', 'Non', '', 'Oui'),
(9316954, 'Mr', 'BACHIR', '', 'Julian-khan', 0, 4, '06.71.72.29.14', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9316991, 'Mr', 'DONET', '', 'Sylvain', 0, 0, '', '', 'Non', '', 'Oui'),
(9317005, 'Mr', 'LAUGIER', '', 'Louis', 0, 0, '', '', 'Non', '', 'Oui'),
(9317312, 'Mr', 'DOINEAU', '', 'Maxence', 0, 0, '', '', 'Non', '', 'Oui'),
(9317315, 'Mr', 'CHAUTARD', 'PAT', 'Patrick', 0, 9, '06.75.07.60.71', 'patrick.chautard@free.fr', 'Oui', '#Henri1957', 'Oui'),
(9317599, 'Mr', 'DUMONT', '', 'Corentin', 0, 0, '', '', 'Non', '', 'Oui'),
(9317703, 'Mr', 'OUK', '', 'Vibol', 0, 5, '01.01.01.01.01', 'pas.saisie@faux', 'Oui', '', 'Oui'),
(9317979, 'Mr', 'NOIRET', '', 'Quentin', 0, 0, '', '', 'Non', '', 'Oui'),
(9318103, 'Mr', 'GEORGE', '', 'Fabrice', 0, 8, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9318106, 'Mr', 'BOIRIE', '', 'Julien', 0, 0, '', '', 'Non', '', 'Oui'),
(9318235, 'Mr', 'PELOILLE', '', 'Baptiste', 0, 6, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9318237, 'Mr', 'RICHARD', '', 'Antoine', 0, 9, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9318245, 'Mr', 'PORTEFIN', '', 'Camille', 0, 0, '', '', 'Non', '', 'Oui'),
(9318258, 'Mr', 'TAMISIER', '', 'Flavien', 0, 0, '', '', 'Non', '', 'Oui'),
(9318263, 'Mr', 'TRAISNEL', '', 'Charles', 0, 0, '', '', 'Non', '', 'Oui'),
(9318307, 'Mr', 'IANKOVSKAIA', '', 'Svetlana', 0, 0, '', '', 'Non', '', 'Oui'),
(9318400, 'Mr', 'LADRECH', '', 'Tiago', 0, 0, '', '', 'Non', '', 'Oui'),
(9318443, 'Mr', 'FICHOU', '', 'Sebastien', 0, 9, '', 'pas.saisie@faux', 'Oui', '#Fichou443', 'Oui'),
(9318450, 'Mme', 'DALLE PIAGGE', '', 'Martine', 0, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9318676, 'Mr', 'DAMASSE', '', 'Robert', 0, 0, '', '', 'Non', '', 'Oui'),
(9318738, 'Mr', 'LELIEUX', '', 'Arthur', 0, 0, '', '', 'Non', '', 'Oui'),
(9318846, 'Mr', 'CAUMONT', '', 'Basile', 0, 0, '', '', 'Non', '', 'Oui'),
(9318949, 'Mr', 'DESPLANCHES', '', 'Matthias', 0, 0, '', '', 'Non', '', 'Oui'),
(9318950, 'Mr', 'LELOUP', '', 'Jean-yves', 0, 0, '', '', 'Non', '', 'Oui'),
(9318953, 'Mr', 'CARALP', '', 'Martine', 0, 0, '', '', 'Non', '', 'Oui'),
(9318954, 'Mr', 'BOURDERIOUX', '', 'Hugo', 0, 0, '06.08.27.36.32', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9319088, 'Mr', 'VILLATA', '', 'Armand', 0, 0, '', '', 'Non', '', 'Oui'),
(9319381, 'Mr', 'LELIEUX', '', 'Thomas', 0, 0, '', '', 'Non', '', 'Oui'),
(9319466, 'Mr', 'BOURSE', '', 'Léo', 0, 0, '', '', 'Non', '', 'Oui'),
(9319470, 'Mr', 'DELOR', '', 'Noam', 0, 0, '', '', 'Non', '', 'Oui'),
(9319471, 'Mr', 'CALMON-BERDAH', '', 'Logan', 0, 0, '', '', 'Non', '', 'Oui'),
(9319472, 'Mr', 'GERBIER', '', 'Thibault', 0, 0, '', '', 'Non', '', 'Oui'),
(9319474, 'Mr', 'AOUADI', '', 'Selyan', 0, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9319478, 'Mr', 'QUINIOU', '', 'Gaël', 0, 0, '', '', 'Non', '', 'Oui'),
(9319482, 'Mr', 'DEMANGE', '', 'Louis', 0, 0, '', '', 'Non', '', 'Oui'),
(9319483, 'Mr', 'VIALLARD', '', 'Pierre', 0, 0, '', '', 'Non', '', 'Oui'),
(9319592, 'Mr', 'SAVARY', '', 'Hugo', 0, 0, '', '', 'Non', '', 'Oui'),
(9319594, 'Mr', 'BONNET', '', 'Gabrielle', 0, 0, '', '', 'Non', '', 'Oui'),
(9319595, 'Mr', 'PONTUERT-DELUCQ', '', 'Manoë', 0, 0, '', '', 'Non', '', 'Oui'),
(9319598, 'Mr', 'EVEN', '', 'Maxime', 0, 0, '', '', 'Non', '', 'Oui'),
(9319599, 'Mr', 'DJAIZ', '', 'Evan', 0, 0, '', '', 'Non', '', 'Oui'),
(9319674, 'Mr', 'AMPHOUX', '', 'Eric', 0, 0, '', '', 'Non', '', 'Oui'),
(9319676, 'Mr', 'GOURDES', '', 'Maxime', 0, 0, '', '', 'Non', '', 'Oui'),
(9319808, 'Mr', 'LEFRANC', '', 'Hugo', 0, 0, '', '', 'Non', '', 'Oui'),
(9319959, 'Mr', 'MARTHAN', '', 'Stéphane', 0, 0, '', '', 'Non', '', 'Oui'),
(9319960, 'Mr', 'LELONG', '', 'Jules', 0, 0, '', '', 'Non', '', 'Oui'),
(9319961, 'Mme', 'ANTUNES-HOUNE', '', 'Laura', 0, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Non'),
(9319963, 'Mr', 'DIDELOT', '', 'Yannis', 0, 0, '', '', 'Non', '', 'Oui'),
(9319964, 'Mr', 'MARCHAL', '', 'Félix', 0, 0, '', '', 'Non', '', 'Oui'),
(9319965, 'Mr', 'JOUANNE', '', 'Louis', 0, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9319966, 'Mr', 'GALIZZI', '', 'Juliano', 0, 0, '', '', 'Non', '', 'Oui'),
(9319967, 'Mr', 'CHRISTOPHE', '', 'Nathalie', 0, 0, '', '', 'Non', '', 'Oui'),
(9319968, 'Mr', 'CHRISTOPHE', '', 'Baptiste', 0, 0, '', '', 'Non', '', 'Oui'),
(9319969, 'Mr', 'POZLEWICZ', '', 'Stéphane', 0, 8, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9320072, 'Mr', 'HERROUX', '', 'Kilian', 0, 9, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9320073, 'Mr', 'BAUMAN', '', 'Eric', 0, 0, '', '', 'Non', '', 'Oui'),
(9320074, 'Mr', 'MARCULESCU', '', 'Eric', 0, 0, '', '', 'Non', '', 'Oui'),
(9320075, 'Mr', 'KALLOU', '', 'Salim', 0, 0, '', '', 'Non', '', 'Oui'),
(9320076, 'Mr', 'BONNAFOUS', '', 'Louis', 0, 0, '', '', 'Non', '', 'Oui'),
(9320077, 'Mr', 'JOLIVET', '', 'Léna', 0, 0, '', '', 'Non', '', 'Oui'),
(9320078, 'Mr', 'PHUNG', '', 'Léo', 0, 0, '', '', 'Non', '', 'Oui'),
(9320079, 'Mr', 'MARTIGNON', '', 'Delphine', 0, 0, '', '', 'Non', '', 'Oui'),
(9320080, 'Mr', 'DA SILVA', '', 'Maxime', 0, 0, '', '', 'Non', '', 'Oui'),
(9320142, 'Mr', 'LE GAL', '', 'Patrick', 0, 0, '', '', 'Non', '', 'Oui'),
(9320143, 'Mr', 'HADDAD', '', 'Aurore', 0, 0, '', '', 'Non', '', 'Oui'),
(9320144, 'Mr', 'DALLEAU-PONTHUS', '', 'Lucas', 0, 0, '', '', 'Non', '', 'Oui'),
(9320145, 'Mr', 'BONNET', '', 'Nathan', 0, 0, '', '', 'Non', '', 'Oui'),
(9320146, 'Mr', 'ALTMANN-ILIC', '', 'Ilan', 0, 5, '', '', 'Non', '', 'Oui'),
(9320147, 'Mr', 'FIGUEIREDO', '', 'Alexandra', 0, 0, '', '', 'Non', '', 'Oui'),
(9320148, 'Mr', 'BONNET', '', 'Matthéo', 0, 0, '', '', 'Non', '', 'Oui'),
(9320149, 'Mr', 'DONET-ST GES', '', 'Timéo', 0, 0, '', '', 'Non', '', 'Oui'),
(9320150, 'Mr', 'LE HOLLOCO', '', 'Jean-antoine', 0, 8, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9320151, 'Mr', 'RIZZO', '', 'Paul', 0, 0, '', '', 'Non', '', 'Oui'),
(9320152, 'Mr', 'PAGET', '', 'Eric', 0, 0, '', '', 'Non', '', 'Oui'),
(9320153, 'Mr', 'CHARRUA', '', 'Claudio', 0, 0, '', '', 'Non', '', 'Oui'),
(9320600, 'Mr', 'DIOT', '', 'Thomas', 5, 5, '06.61.57.00.54', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9320765, 'Mr', 'BLANDEL', NULL, 'Josselin', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9321187, 'Mr', 'SCHMITT', '', 'Aurélien', 5, 0, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9321237, 'Mr', 'IM', NULL, 'Tony', 5, 0, '06.12.40.64.24', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9321343, 'Mr', 'DE OLIVEIRA', NULL, 'Theo', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9321348, 'Mr', 'BELCOURT', NULL, 'Maxime', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322006, 'Mr', 'ANTZ', '', 'Achille', 5, 9, '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322795, 'Mr', 'MARDAYMOOTOO', NULL, 'Veniten', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322804, 'Mr', 'DIONNET', '', 'Benjamin', 5, 0, '06.25.77.44.83', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322808, 'Mr', 'DJENA', NULL, 'Haron', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322809, 'Mr', 'BOURDERIOUX', '', 'Florent', 5, 0, '06.08.27.36.32', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322810, 'Mr', 'SCHMITT', '', 'Martin', 5, 0, '06.01.02.03.04', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322900, 'Mr', 'TREVIL VIGNOCAN', '', 'Jaden', 5, 0, '0643.33.03.53', 'vignocan.elodie@gmail.com', 'Non', '', 'Oui'),
(9322901, 'Mr', 'LE GARS', '', 'Mathis', 5, 0, '06.71.63.47.62', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322902, 'Mr', 'CARDUCCI', '', 'Antonin', 5, 0, '06.20.31.48.58', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322903, 'Mr', 'DEMART', '', 'Yam', 5, 0, '06-25-29-31-24', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322904, 'Mr', 'GWERARD', '', 'Arthur', 5, 0, '06.81.52.63.25', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9322905, 'Mr', 'MODESTINE FAJULE', '', 'Ethan', 5, 0, '06.18.0847.94', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9323025, 'Mr', 'JOUANNE', '', 'Grégoire', 5, 0, '06.33.07.70.75', 'pas.saisie@faux', 'Non', '', 'Oui'),
(9323235, 'Mr', 'COTTIN', NULL, 'Noé', 5, 0, '', 'pas.saisie@faux', 'Non', '', 'Oui');

-- --------------------------------------------------------

--
-- Structure de la table `res_prioritaires`
--

DROP TABLE IF EXISTS `res_prioritaires`;
CREATE TABLE IF NOT EXISTS `res_prioritaires` (
  `id_prioritaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_creneau` int(11) NOT NULL,
  `id_licencier` int(11) NOT NULL,
  PRIMARY KEY (`id_prioritaire`),
  KEY `id_creneau` (`id_creneau`),
  KEY `id_licencier` (`id_licencier`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `res_prioritaires`
--

INSERT INTO `res_prioritaires` (`id_prioritaire`, `id_creneau`, `id_licencier`) VALUES
(1, 3, 9317315),
(73, 7, 957044),
(42, 15, 9323025),
(41, 3, 93396),
(40, 2, 93396),
(15, 5, 7711698),
(12, 6, 93413),
(13, 5, 93728),
(14, 7, 93728),
(16, 5, 9313773),
(17, 7, 933602),
(60, 5, 9314351),
(19, 7, 9317703),
(20, 5, 951246),
(21, 5, 933604),
(22, 5, 938219),
(23, 5, 9312573),
(24, 5, 9312604),
(25, 5, 7714816),
(26, 2, 9321187),
(45, 2, 9312902),
(28, 2, 9318450),
(29, 2, 9316145),
(30, 2, 9316613),
(31, 15, 9322810),
(32, 15, 9322809),
(33, 15, 9322903),
(34, 15, 9322804),
(64, 6, 9312611),
(36, 15, 9322901),
(37, 15, 9322900),
(43, 15, 9322905),
(44, 2, 1),
(46, 2, 9313033),
(47, 2, 2),
(61, 5, 7727498),
(49, 5, 9318103),
(50, 3, 3),
(51, 3, 938125),
(52, 3, 9318954),
(53, 3, 4),
(54, 5, 9312623),
(55, 5, 949068),
(63, 6, 9318235),
(62, 6, 9318237),
(65, 6, 9319965),
(66, 6, 9317315),
(67, 6, 938986),
(68, 6, 9320600),
(69, 6, 939644),
(70, 6, 9318443),
(71, 6, 9320072),
(72, 6, 9319474),
(74, 7, 936887),
(75, 7, 9316954),
(76, 7, 9316334),
(77, 7, 9311926),
(78, 7, 931327),
(79, 7, 93728),
(80, 7, 9314069),
(81, 7, 9315851),
(82, 7, 9316466);

-- --------------------------------------------------------

--
-- Structure de la table `res_reservations`
--

DROP TABLE IF EXISTS `res_reservations`;
CREATE TABLE IF NOT EXISTS `res_reservations` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `id_creneau` int(11) NOT NULL,
  `iDate` int(11) NOT NULL COMMENT 'Date au format YYNNN NNN Numéro de jour dans l''année',
  `id_licencier` int(11) NOT NULL,
  `Ouvreur` enum('Oui','Non') NOT NULL DEFAULT 'Non',
  PRIMARY KEY (`id_reservation`) USING BTREE,
  KEY `id_creneau` (`id_creneau`),
  KEY `id_licencier` (`id_licencier`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `res_reservations`
--

INSERT INTO `res_reservations` (`id_reservation`, `id_creneau`, `iDate`, `id_licencier`, `Ouvreur`) VALUES
(1, 7, 20267, 9317315, 'Non'),
(2, 7, 20266, 9317315, 'Oui'),
(3, 10, 20263, 9317315, 'Oui'),
(4, 12, 20263, 9317315, 'Oui'),
(6, 10, 20263, 9317315, 'Non'),
(7, 11, 20263, 9317315, 'Non'),
(11, 6, 20266, 9317315, 'Oui'),
(12, 15, 20269, 9317315, 'Oui'),
(13, 15, 20276, 9322810, 'Non'),
(14, 15, 20276, 9322804, 'Non'),
(15, 15, 20276, 9322809, 'Non'),
(16, 15, 20276, 9322900, 'Non'),
(17, 15, 20276, 9322901, 'Non'),
(18, 15, 20276, 9322902, 'Non'),
(19, 15, 20276, 9322903, 'Non'),
(20, 15, 20276, 9322904, 'Non'),
(21, 15, 20276, 9317315, 'Oui'),
(24, 15, 20290, 9322810, 'Non'),
(26, 15, 20290, 9322904, 'Non'),
(27, 15, 20290, 9322809, 'Non'),
(28, 15, 20290, 9323025, 'Non'),
(29, 15, 20290, 9322804, 'Non'),
(30, 15, 20290, 9322903, 'Non'),
(31, 15, 20290, 9322901, 'Non'),
(32, 15, 20290, 9322900, 'Non'),
(33, 15, 20290, 9322905, 'Non'),
(34, 15, 20283, 9317315, 'Oui'),
(35, 15, 20283, 9322810, 'Oui'),
(36, 15, 20283, 9322904, 'Non'),
(37, 15, 20283, 9322809, 'Non'),
(38, 15, 20283, 9323025, 'Non'),
(39, 15, 20283, 9322804, 'Non'),
(40, 15, 20283, 9322903, 'Non'),
(41, 15, 20283, 9322901, 'Non'),
(42, 15, 20283, 9322900, 'Non'),
(43, 15, 20283, 9322905, 'Non'),
(44, 15, 20290, 9317315, 'Oui'),
(46, 4, 20286, 9317315, 'Oui'),
(47, 4, 20286, 9317315, 'Non');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
