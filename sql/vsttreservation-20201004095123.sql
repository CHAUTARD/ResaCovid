-- ----------------------
-- dump de la base  au 04-Oct-2020
-- ----------------------


-- ---------------------------------------
-- Structure de la table res_creneaux
-- ---------------------------------------
CREATE TABLE `res_creneaux` (
  `id_creneau` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(35) NOT NULL,
  `Salle` enum('Coppée','Tcheuméo') NOT NULL DEFAULT 'Coppée',
  `Jour` tinyint(4) NOT NULL,
  `Heure_Debut` time NOT NULL,
  `Heure_Fin` time NOT NULL,
  `Libre` enum('Oui','Non') NOT NULL DEFAULT 'Non',
  `id_ouvreur` int(11) NOT NULL DEFAULT 0,
  `Nbr_Place` int(11) NOT NULL DEFAULT 12,
  `Ord` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_creneau`),
  KEY `id_ouvreur` (`id_ouvreur`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ---------------------------------------
-- Structure de la table res_licenciers
-- ---------------------------------------
CREATE TABLE `res_licenciers` (
  `id_licencier` int(11) NOT NULL,
  `Civilite` enum('Mr','Mme') NOT NULL DEFAULT 'Mr',
  `Nom` varchar(35) NOT NULL,
  `Surnom` varchar(35) NOT NULL,
  `Prenom` varchar(35) NOT NULL,
  `Classement` int(11) NOT NULL DEFAULT 5,
  `Equipe` tinyint(4) NOT NULL,
  `Telephone` varchar(14) NOT NULL DEFAULT '01.01.01.01.01',
  `Email` varchar(50) NOT NULL DEFAULT 'pas.saisie@faux',
  `Ouvreur` enum('Oui','Non') NOT NULL DEFAULT 'Non',
  `Admin` varchar(10) NOT NULL DEFAULT 'Non',
  `Actif` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_licencier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------
-- Structure de la table res_prioritaires
-- ---------------------------------------
CREATE TABLE `res_prioritaires` (
  `id_prioritaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_creneau` int(11) NOT NULL,
  `id_licencier` int(11) NOT NULL,
  PRIMARY KEY (`id_prioritaire`),
  KEY `id_creneau` (`id_creneau`),
  KEY `id_licencier` (`id_licencier`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ---------------------------------------
-- Structure de la table res_reservations
-- ---------------------------------------
CREATE TABLE `res_reservations` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `id_creneau` int(11) NOT NULL,
  `iDate` int(11) NOT NULL COMMENT 'Date au format YYNNN NNN Numéro de jour dans l''année',
  `id_licencier` int(11) NOT NULL,
  `Ouvreur` enum('Oui','Non') NOT NULL DEFAULT 'Non',
  PRIMARY KEY (`id_reservation`) USING BTREE,
  KEY `id_creneau` (`id_creneau`),
  KEY `id_licencier` (`id_licencier`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;



-- --------------------------------------
-- Contenu de la table res_creneaux
-- --------------------------------------
INSERT INTO res_creneaux VALUES('1', 'Libre', 'Coppée', '1', '18:30:00', '20:00:00', 'Oui', '9317315', '10', '0');
INSERT INTO res_creneaux VALUES('2', 'Loisir', 'Coppée', '1', '20:00:00', '21:00:00', 'Non', '93396', '12', '11');
INSERT INTO res_creneaux VALUES('3', 'Equipe 9 et 10', 'Coppée', '1', '21:00:00', '22:30:00', 'Non', '93396', '12', '11');
INSERT INTO res_creneaux VALUES('4', 'Libre', 'Coppée', '2', '18:30:00', '20:30:00', 'Oui', '0', '10', '0');
INSERT INTO res_creneaux VALUES('5', 'Equipe 1, 2 et 3', 'Coppée', '2', '20:30:00', '22:30:00', 'Non', '7712599', '12', '0');
INSERT INTO res_creneaux VALUES('6', 'Equpe 3 à 8', 'Coppée', '3', '19:00:00', '20:30:00', 'Non', '865607', '10', '31');
INSERT INTO res_creneaux VALUES('7', 'Equipe 3 à 8', 'Coppée', '3', '20:30:00', '22:00:00', 'Non', '865607', '12', '31');
INSERT INTO res_creneaux VALUES('8', 'Libre', 'Tcheuméo', '2', '20:00:00', '22:00:00', 'Oui', '0', '10', '0');
INSERT INTO res_creneaux VALUES('9', 'Libre', 'Tcheuméo', '6', '18:00:00', '19:00:00', 'Oui', '0', '10', '0');
INSERT INTO res_creneaux VALUES('10', 'Libre', 'Coppée', '7', '15:00:00', '16:30:00', 'Oui', '9317315', '10', '1');
INSERT INTO res_creneaux VALUES('11', 'Libre', 'Coppée', '7', '16:30:00', '18:00:00', 'Oui', '0', '10', '1');
INSERT INTO res_creneaux VALUES('12', 'Libre', 'Coppée', '7', '18:00:00', '19:30:00', 'Oui', '0', '10', '1');
INSERT INTO res_creneaux VALUES('13', 'Libre', 'Coppée', '7', '19:30:00', '21:00:00', 'Oui', '0', '10', '1');
INSERT INTO res_creneaux VALUES('15', 'Débutant', 'Coppée', '6', '10:00:00', '11:30:00', 'Non', '9317315', '12', '0');

-- --------------------------------------
-- Contenu de la table res_licenciers
-- --------------------------------------
INSERT INTO res_licenciers VALUES('93396', 'Mr', 'DALLE PIAGGE', '', 'Yves', '0', '0', '06.01.02.03.04', 'yves.dallepiagge@gmail.com', 'Oui', '4pP4RER+TL', '1');
INSERT INTO res_licenciers VALUES('93413', 'Mr', 'GRANDIN', 'NANAR', 'Bernard', '0', '0', '06.01.02.03.05', 'nanar@free.fr', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('93728', 'Mr', 'LAMOLINAIRIE', '', 'Henrique', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('773840', 'Mr', 'CONCHON', '', 'Sylvain', '5', '3', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('865607', 'Mr', 'WILMUS', '', 'Franck', '15', '3', '01.01.01.01.01', 'pas.saisie@faux', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('931327', 'Mr', 'VALADE', '', 'Patrick', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('933602', 'Mr', 'LABOUREAU', '', 'Pierre', '0', '0', '', '', 'Oui', 'e9j>WMhy3z', '1');
INSERT INTO res_licenciers VALUES('933604', 'Mr', 'PALUYAN', '', 'Ari', '0', '3', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('935669', 'Mr', 'DUVAL', '', 'Jérôme', '0', '0', '', '', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('935871', 'Mr', 'BOULANGER', '', 'Frédéric', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('937876', 'Mr', 'DESBOIS', '', 'Sébastien', '0', '0', '', '', 'Oui', 'i9pWJ[Wc9K', '1');
INSERT INTO res_licenciers VALUES('938125', 'Mme', 'AUBIN', '', 'Janine', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('938219', 'Mr', 'GICQUEL', '', 'Erwann', '5', '2', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('939644', 'Mr', 'LECOCQ', 'MA POULE', 'Xavier', '0', '7', '06.01.02.03.04', 'xavier.lecocq@cg94.fr', 'Non', '>LecocqXa<', '1');
INSERT INTO res_licenciers VALUES('949068', 'Mr', 'JOLY', '', 'Christophe', '0', '2', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('951246', 'Mr', 'MACHET', '', 'Thierry', '0', '1', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('957044', 'Mr', 'COLOMER', '', 'Thierry', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('7711698', 'Mr', 'CHARDIN', 'GuiGui', 'Guillaume', '18', '1', '01.01.01.01.01', 'pas.saisie@faux', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('7712599', 'Mr', 'DE LA BARRERA', '', 'Romain', '16', '1', '', '', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('7714816', 'Mr', 'JEAN-BAPTISTE', '', 'Jerome', '5', '0', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('7717097', 'Mr', 'JOLY', '', 'Clément', '5', '1', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('7727498', 'Mr', 'STAUBER', '', 'Julien', '5', '2', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9311514', 'Mr', 'BARTHELEMY', '', 'Stéphane', '0', '8', '01.01.01.01.01', 'pas.saisie@faux', 'Oui', '#Stephane>', '1');
INSERT INTO res_licenciers VALUES('9311718', 'Mr', 'MERELLE', '', 'Jacques', '0', '10', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9311926', 'Mr', 'LELIEUX', '', 'Jérôme', '0', '8', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9312573', 'Mr', 'QUINQUIS', '', 'Erwann', '5', '1', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9312604', 'Mr', 'CARON', '', 'Donovan', '0', '1', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9312611', 'Mr', 'ESNAULT', '', 'Jérémy', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9312623', 'Mr', 'DINOT', '', 'Samuel', '0', '1', '01.01.01.01.01', 'pas.saisie@faux', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('9312754', 'Mr', 'GIORDANO', '', 'Christophe', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9312902', 'Mr', 'CHAPUS-MINETTO', '', 'Brigitte', '0', '0', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9313033', 'Mr', 'PEETERS', '', 'Marie-laure', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9313532', 'Mr', 'GROSCOT', '', 'Jose', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9313773', 'Mr', 'LEMOINE', '', 'Alexandre', '0', '2', '', '', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('9313882', 'Mr', 'HALIN', '', 'Marcel', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9314069', 'Mr', 'SALMON', '', 'Dominique', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9314199', 'Mr', 'ROBERT', '', 'Philippe', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9314255', 'Mr', 'BOSSÉ', '', 'Arthur', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9314351', 'Mr', 'PUTIGNY', '', 'Tony', '5', '2', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9314691', 'Mr', 'DRUART', '', 'Anthony', '0', '10', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315171', 'Mr', 'LOUISE', '', 'Norbert', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315195', 'Mr', 'DEHAINE', '', 'François', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315215', 'Mr', 'GIBON', '', 'Florian', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315622', 'Mr', 'CARON', '', 'Patricia', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315851', 'Mr', 'SAGUES', '', 'David', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315906', 'Mr', 'CHALET', '', 'Sébastien', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9315950', 'Mr', 'ZANNONI', '', 'Florent', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316145', 'Mr', 'BILLARD', '', 'Bruno', '0', '0', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316334', 'Mr', 'PAPP', '', 'Ladislau', '0', '0', '', 'licences.fftt@vstt.com', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316339', 'Mr', 'DOINEAU', '', 'Lucas', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316466', 'Mr', 'MICHEL', '', 'Antoine', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316502', 'Mr', 'GALEA', '', 'Jean pierre', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316613', 'Mr', 'SILLOU', '', 'Elisa', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316851', 'Mr', 'ITIM', '', 'Akima', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316954', 'Mr', 'BACHIR', '', 'Julian-khan', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9316991', 'Mr', 'DONET', '', 'Sylvain', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9317005', 'Mr', 'LAUGIER', '', 'Louis', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9317312', 'Mr', 'DOINEAU', '', 'Maxence', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9317315', 'Mr', 'CHAUTARD', 'PAT', 'Patrick', '0', '9', '', 'licences.fftt@vstt.com', 'Oui', '#Henri1957', '1');
INSERT INTO res_licenciers VALUES('9317599', 'Mr', 'DUMONT', '', 'Corentin', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9317703', 'Mr', 'OUK', '', 'Vibol', '0', '0', '', '', 'Oui', '', '1');
INSERT INTO res_licenciers VALUES('9317979', 'Mr', 'NOIRET', '', 'Quentin', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318103', 'Mr', 'GEORGE', '', 'Fabrice', '0', '10', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318106', 'Mr', 'BOIRIE', '', 'Julien', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318235', 'Mr', 'PELOILLE', '', 'Baptiste', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318237', 'Mr', 'RICHARD', '', 'Antoine', '0', '9', '', 'licences.fftt@vstt.com', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318245', 'Mr', 'PORTEFIN', '', 'Camille', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318258', 'Mr', 'TAMISIER', '', 'Flavien', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318263', 'Mr', 'TRAISNEL', '', 'Charles', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318307', 'Mr', 'IANKOVSKAIA', '', 'Svetlana', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318400', 'Mr', 'LADRECH', '', 'Tiago', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318443', 'Mr', 'FICHOU', '', 'Sebastien', '0', '9', '', '', 'Oui', '#Fichou443', '1');
INSERT INTO res_licenciers VALUES('9318450', 'Mr', 'DALLE PIAGGE', '', 'Martine', '0', '0', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318676', 'Mr', 'DAMASSE', '', 'Robert', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318738', 'Mr', 'LELIEUX', '', 'Arthur', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318846', 'Mr', 'CAUMONT', '', 'Basile', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318949', 'Mr', 'DESPLANCHES', '', 'Matthias', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318950', 'Mr', 'LELOUP', '', 'Jean-yves', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318953', 'Mr', 'CARALP', '', 'Martine', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9318954', 'Mr', 'BOURDERIOUX', '', 'Hugo', '0', '0', '06.08.27.36.32', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319088', 'Mr', 'VILLATA', '', 'Armand', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319381', 'Mr', 'LELIEUX', '', 'Thomas', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319466', 'Mr', 'BOURSE', '', 'Léo', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319470', 'Mr', 'DELOR', '', 'Noam', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319471', 'Mr', 'CALMON-BERDAH', '', 'Logan', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319472', 'Mr', 'GERBIER', '', 'Thibault', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319474', 'Mr', 'AOUADI', '', 'Selyan', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319478', 'Mr', 'QUINIOU', '', 'Gaël', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319482', 'Mr', 'DEMANGE', '', 'Louis', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319483', 'Mr', 'VIALLARD', '', 'Pierre', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319592', 'Mr', 'SAVARY', '', 'Hugo', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319594', 'Mr', 'BONNET', '', 'Gabrielle', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319595', 'Mr', 'PONTUERT-DELUCQ', '', 'Manoë', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319598', 'Mr', 'EVEN', '', 'Maxime', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319599', 'Mr', 'DJAIZ', '', 'Evan', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319674', 'Mr', 'AMPHOUX', '', 'Eric', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319676', 'Mr', 'GOURDES', '', 'Maxime', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319808', 'Mr', 'LEFRANC', '', 'Hugo', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319959', 'Mr', 'MARTHAN', '', 'Stéphane', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319960', 'Mr', 'LELONG', '', 'Jules', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319961', 'Mme', 'ANTUNES-HOUNE', '', 'Laura', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319963', 'Mr', 'DIDELOT', '', 'Yannis', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319964', 'Mr', 'MARCHAL', '', 'Félix', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319965', 'Mr', 'JOUANNE', '', 'Louis', '0', '0', '', 'licences.fftt@vstt.com', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319966', 'Mr', 'GALIZZI', '', 'Juliano', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319967', 'Mr', 'CHRISTOPHE', '', 'Nathalie', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319968', 'Mr', 'CHRISTOPHE', '', 'Baptiste', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9319969', 'Mr', 'POZLEWOICZ', '', 'Stéphane', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320072', 'Mr', 'HERROUX', '', 'Kilian', '0', '9', '', 'licences.fftt@vstt.com', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320073', 'Mr', 'BAUMAN', '', 'Eric', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320074', 'Mr', 'MARCULESCU', '', 'Eric', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320075', 'Mr', 'KALLOU', '', 'Salim', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320076', 'Mr', 'BONNAFOUS', '', 'Louis', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320077', 'Mr', 'JOLIVET', '', 'Léna', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320078', 'Mr', 'PHUNG', '', 'Léo', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320079', 'Mr', 'MARTIGNON', '', 'Delphine', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320080', 'Mr', 'DA SILVA', '', 'Maxime', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320142', 'Mr', 'LE GAL', '', 'Patrick', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320143', 'Mr', 'HADDAD', '', 'Aurore', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320144', 'Mr', 'DALLEAU-PONTHUS', '', 'Lucas', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320145', 'Mr', 'BONNET', '', 'Nathan', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320146', 'Mr', 'ALTMANN-ILIC', '', 'Ilan', '0', '5', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320147', 'Mr', 'FIGUEIREDO', '', 'Alexandra', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320148', 'Mr', 'BONNET', '', 'Matthéo', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320149', 'Mr', 'DONET-ST GES', '', 'Timéo', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320150', 'Mr', 'LE HOLLOCO', '', 'Jean-antoine', '0', '10', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320151', 'Mr', 'RIZZO', '', 'Paul', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320152', 'Mr', 'PAGET', '', 'Eric', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9320153', 'Mr', 'CHARRUA', '', 'Claudio', '0', '0', '', '', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9321187', 'Mr', 'SCHMITT', '', 'Aurélien', '5', '0', '01.01.01.01.01', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9322804', 'Mr', 'DIONNET', '', 'Benjamin', '5', '0', '06.25.77.44.83', 'pas.saisie@faux', 'Non', 'nnn', '1');
INSERT INTO res_licenciers VALUES('9322809', 'Mr', 'BOURDERIOUX', '', 'Florent', '5', '0', '06.08.27.36.32', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9322810', 'Mr', 'SCHMITT', '', 'Martin', '5', '0', '06.01.02.03.04', 'pas.saisie@faux', 'Non', 'Non', '1');
INSERT INTO res_licenciers VALUES('9322900', 'Mr', 'TREVIL VIGNOCAN', '', 'Jaden', '5', '0', '0643.33.03.53', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9322901', 'Mr', 'LE GARS', '', 'Mathis', '5', '0', '06.71.63.47.62', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9322902', 'Mr', 'CARDUCCI', '', 'Antonin', '5', '0', '06.20.31.48.58', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9322903', 'Mr', 'DEMART', '', 'Yam', '5', '0', '06-25-29-31-24', 'pas.saisie@faux', 'Non', '', '1');
INSERT INTO res_licenciers VALUES('9322904', 'Mr', 'GWERARD', '', 'Arthur', '5', '0', '06.81.52.63.25', 'pas.saisie@faux', 'Non', '', '1');

-- --------------------------------------
-- Contenu de la table res_prioritaires
-- --------------------------------------
INSERT INTO res_prioritaires VALUES('1', '3', '9317315');
INSERT INTO res_prioritaires VALUES('2', '7', '9317315');
INSERT INTO res_prioritaires VALUES('41', '3', '93396');
INSERT INTO res_prioritaires VALUES('40', '2', '93396');
INSERT INTO res_prioritaires VALUES('15', '5', '7711698');
INSERT INTO res_prioritaires VALUES('12', '6', '93413');
INSERT INTO res_prioritaires VALUES('13', '5', '93728');
INSERT INTO res_prioritaires VALUES('14', '7', '93728');
INSERT INTO res_prioritaires VALUES('16', '5', '9313773');
INSERT INTO res_prioritaires VALUES('17', '7', '933602');
INSERT INTO res_prioritaires VALUES('18', '6', '7712599');
INSERT INTO res_prioritaires VALUES('19', '7', '9317703');
INSERT INTO res_prioritaires VALUES('20', '5', '951246');
INSERT INTO res_prioritaires VALUES('21', '5', '933604');
INSERT INTO res_prioritaires VALUES('22', '5', '938219');
INSERT INTO res_prioritaires VALUES('23', '5', '9312573');
INSERT INTO res_prioritaires VALUES('24', '5', '9312604');
INSERT INTO res_prioritaires VALUES('25', '5', '7714816');
INSERT INTO res_prioritaires VALUES('26', '2', '9321187');
INSERT INTO res_prioritaires VALUES('27', '2', '9312902');
INSERT INTO res_prioritaires VALUES('28', '2', '9318450');
INSERT INTO res_prioritaires VALUES('29', '2', '9316145');
INSERT INTO res_prioritaires VALUES('30', '2', '9316613');
INSERT INTO res_prioritaires VALUES('31', '15', '9322810');
INSERT INTO res_prioritaires VALUES('32', '15', '9322809');
INSERT INTO res_prioritaires VALUES('33', '15', '9322903');
INSERT INTO res_prioritaires VALUES('34', '15', '9322804');
INSERT INTO res_prioritaires VALUES('35', '15', '9322904');
INSERT INTO res_prioritaires VALUES('36', '15', '9322901');
INSERT INTO res_prioritaires VALUES('37', '15', '9322900');

-- --------------------------------------
-- Contenu de la table res_reservations
-- --------------------------------------
INSERT INTO res_reservations VALUES('1', '7', '20267', '9317315', 'Non');
INSERT INTO res_reservations VALUES('2', '7', '20266', '9317315', 'Oui');
INSERT INTO res_reservations VALUES('3', '10', '20263', '9317315', 'Oui');
INSERT INTO res_reservations VALUES('4', '12', '20263', '9317315', 'Oui');
INSERT INTO res_reservations VALUES('6', '10', '20263', '9317315', 'Non');
INSERT INTO res_reservations VALUES('7', '11', '20263', '9317315', 'Non');
INSERT INTO res_reservations VALUES('11', '6', '20266', '9317315', 'Oui');
INSERT INTO res_reservations VALUES('12', '15', '20269', '9317315', 'Oui');
INSERT INTO res_reservations VALUES('13', '15', '20276', '9322810', 'Non');
INSERT INTO res_reservations VALUES('14', '15', '20276', '9322804', 'Non');
INSERT INTO res_reservations VALUES('15', '15', '20276', '9322809', 'Non');
INSERT INTO res_reservations VALUES('16', '15', '20276', '9322900', 'Non');
INSERT INTO res_reservations VALUES('17', '15', '20276', '9322901', 'Non');
INSERT INTO res_reservations VALUES('18', '15', '20276', '9322902', 'Non');
INSERT INTO res_reservations VALUES('19', '15', '20276', '9322903', 'Non');
INSERT INTO res_reservations VALUES('20', '15', '20276', '9322904', 'Non');
INSERT INTO res_reservations VALUES('21', '15', '20276', '9317315', 'Oui');

