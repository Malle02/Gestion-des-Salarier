-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: 127.0.0.1
-- Généré le : Ven 19 Mai 2023 à 15:44
-- Version du serveur: 5.5.10
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gestion_des_salarier`
--

-- --------------------------------------------------------

--
-- Structure de la table `historiquesalaire`
--

CREATE TABLE IF NOT EXISTS `historiquesalaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_salarier` int(11) DEFAULT NULL,
  `salaire_précédent` decimal(10,2) DEFAULT NULL,
  `salaire_actuel` decimal(10,2) DEFAULT NULL,
  `date_modification` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_salarier` (`id_salarier`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `historiquesalaire`
--

INSERT INTO `historiquesalaire` (`id`, `id_salarier`, `salaire_précédent`, `salaire_actuel`, `date_modification`) VALUES
(1, 26, 4000.00, 5000.00, '2023-05-25'),
(2, 16, 3000.00, 40000.00, '2023-05-09');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE IF NOT EXISTS `projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `id_salarier` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salarier` (`id_salarier`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id`, `nom`, `date_debut`, `date_fin`, `id_salarier`) VALUES
(1, 'Projet A', '2022-02-01', '2022-05-31', 18),
(2, 'Projet B', '2022-03-15', '2022-08-31', NULL),
(3, 'DAMS', '2023-05-09', '2023-06-03', NULL),
(4, 'DAMS', '2023-05-05', '2023-06-11', NULL),
(8, 'Projet B', NULL, NULL, 26),
(9, 'Creation D''IA', '2023-05-25', '2023-08-24', 22),
(10, 'DAMS', '2023-05-19', '2023-06-08', 27),
(11, 'Mis a jour site ', '2023-05-04', '2023-06-10', 27);

-- --------------------------------------------------------

--
-- Structure de la table `salarier`
--

CREATE TABLE IF NOT EXISTS `salarier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `poste` varchar(50) DEFAULT NULL,
  `date_embauche` date DEFAULT NULL,
  `salaire` decimal(10,2) DEFAULT NULL,
  `departement` varchar(50) DEFAULT NULL,
  `adresse_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `salarier`
--

INSERT INTO `salarier` (`id`, `nom`, `prenom`, `poste`, `date_embauche`, `salaire`, `departement`, `adresse_email`) VALUES
(14, 'Lévesque', 'Félix', 'Développeur', '2022-11-15', 4200.00, 'Informatique', 'felix.levesque@example.com'),
(15, 'Morin', 'Léa', 'Développeur', '2022-12-20', 3800.00, 'Informatique', 'lea.morin@example.com'),
(16, 'Lefebvre', 'Samuel', 'Développeur', '2023-01-25', 4000.00, 'Informatique', 'samuel.lefebvre@example.com'),
(17, 'Fortineee', 'Mélissazzzz', 'Développeur', '2023-02-10', 3800.00, 'Informatique', 'melissa.fortin@example.com'),
(18, 'Lévesque', 'David', 'Comptable', '2023-03-15', 3200.00, 'Finance', 'david.levesque@example.com'),
(21, 'Gagnon', 'Mia', 'Développeur', '2023-06-30', 4200.00, 'Informatique', 'mia.gagnon@example.com'),
(22, 'Lavoie', 'Justin', 'Développeur', '2023-07-15', 3800.00, 'Informatique', 'justin.lavoie@example.com'),
(24, 'TEST', 'TEST', 'MANAGER', '2023-05-01', 4000.00, 'Informatique', 'test@gmail.com'),
(25, 'TEST2', 'TEST', 'MANAGER', '2023-05-01', 4000.00, 'Informatique', 'test@gmail.com'),
(26, 'TEST3', 'TEST', 'MANAGER', '2023-05-01', 4000.00, 'Informatique', 'test3@gmail.com'),
(27, 'MALICK', 'DIAO', 'STAGIAIRE', '2023-05-18', 1000.00, 'Informatique', 'STAGE@GMAIL.com');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'john_doe', 'password123', 'john@example.com', '2023-05-18 00:58:53'),
(2, 'jane_smith', 'test456', 'jane@example.com', '2023-05-18 00:58:53'),
(3, 'aa', 'aa', NULL, '2023-05-18 01:37:15'),
(4, 'zz', 'zz', NULL, '2023-05-19 15:41:12'),
(5, 'dd', 'dd', NULL, '2023-05-19 15:41:32');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `historiquesalaire`
--
ALTER TABLE `historiquesalaire`
  ADD CONSTRAINT `historiquesalaire_ibfk_1` FOREIGN KEY (`id_salarier`) REFERENCES `salarier` (`id`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `fk_salarier` FOREIGN KEY (`id_salarier`) REFERENCES `salarier` (`id`);
