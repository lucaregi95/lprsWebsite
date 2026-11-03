-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 nov. 2026 à 08:17
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lprs`
--

-- --------------------------------------------------------

--
-- Structure de la table `alumni`
--

DROP TABLE IF EXISTS `alumni`;
CREATE TABLE IF NOT EXISTS `alumni` (
  `ref_utilisateur` int NOT NULL,
  `cv` varchar(200) NOT NULL,
  `poste_occupe` varchar(200) NOT NULL,
  `ref_promotion` int NOT NULL,
  `ref_entreprise` int NOT NULL,
  PRIMARY KEY (`ref_utilisateur`),
  KEY `fk_entrepriseAlumni` (`ref_entreprise`),
  KEY `fk_formationAlumni` (`ref_promotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id_entreprise` int NOT NULL AUTO_INCREMENT,
  `adresse` longtext NOT NULL,
  `nom_entreprise` varchar(200) NOT NULL,
  `site_web` varchar(200) NOT NULL,
  PRIMARY KEY (`id_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `ref_utilisateur` int NOT NULL,
  `cv` varchar(150) NOT NULL,
  `ref_formation` int NOT NULL,
  `ref_promotion` int NOT NULL,
  PRIMARY KEY (`ref_utilisateur`),
  KEY `fk_formationEtudiant` (`ref_formation`),
  KEY `fk_promotionEtudiant` (`ref_promotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

DROP TABLE IF EXISTS `evenement`;
CREATE TABLE IF NOT EXISTS `evenement` (
  `id_evenement` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) NOT NULL,
  `description` longtext NOT NULL,
  `lieu` varchar(250) NOT NULL,
  `nbr_places` int NOT NULL,
  `date_evenement` date NOT NULL,
  `lat` int NOT NULL,
  `lng` int NOT NULL,
  PRIMARY KEY (`id_evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id_formation` int NOT NULL AUTO_INCREMENT,
  `nom_formation` varchar(255) NOT NULL,
  PRIMARY KEY (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

DROP TABLE IF EXISTS `offre`;
CREATE TABLE IF NOT EXISTS `offre` (
  `id_offre` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) NOT NULL,
  `description` longtext NOT NULL,
  `mission` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `salaire` decimal(6,2) NOT NULL,
  `type_offre` varchar(150) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `ref_entreprise` int NOT NULL,
  PRIMARY KEY (`id_offre`),
  KEY `fk_entrepriseOffre` (`ref_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offreutilisateur`
--

DROP TABLE IF EXISTS `offreutilisateur`;
CREATE TABLE IF NOT EXISTS `offreutilisateur` (
  `ref_offre` int NOT NULL,
  `ref_utilisateur` int NOT NULL,
  PRIMARY KEY (`ref_offre`,`ref_utilisateur`),
  KEY `fk_utilisateurOffreUtilisateur` (`ref_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

DROP TABLE IF EXISTS `partenaire`;
CREATE TABLE IF NOT EXISTS `partenaire` (
  `ref_utilisateur` int NOT NULL,
  `poste_occupe` varchar(200) NOT NULL,
  `motif_inscription` varchar(500) NOT NULL,
  `ref_entreprise` int NOT NULL,
  PRIMARY KEY (`ref_utilisateur`),
  KEY `fk_entreprisePartenaire` (`ref_entreprise`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `ref_utilisateur` int NOT NULL,
  `ref_evenement` int NOT NULL,
  `est_orga` tinyint(1) NOT NULL,
  PRIMARY KEY (`ref_utilisateur`,`ref_evenement`),
  KEY `fk_evenementParticipe` (`ref_evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `contenu` longtext NOT NULL,
  `date_post` datetime NOT NULL,
  `ref_utilisateur` int NOT NULL,
  `categorie_post` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `titre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_post`),
  KEY `fk_postUtilisateur` (`ref_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `ref_utilisateur` int NOT NULL,
  `specialite` varchar(200) NOT NULL,
  PRIMARY KEY (`ref_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeurformation`
--

DROP TABLE IF EXISTS `professeurformation`;
CREATE TABLE IF NOT EXISTS `professeurformation` (
  `ref_professeur` int NOT NULL,
  `ref_formation` int NOT NULL,
  PRIMARY KEY (`ref_professeur`,`ref_formation`),
  KEY `fk_formationProfesseurFormation` (`ref_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id_promotion` int NOT NULL AUTO_INCREMENT,
  `annee` varchar(9) NOT NULL,
  PRIMARY KEY (`id_promotion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `contenu` longtext NOT NULL,
  `datetime_reponse` datetime NOT NULL,
  `ref_utilisateur` int NOT NULL,
  `ref_post` int NOT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `fk_reponsePost` (`ref_post`),
  KEY `fk_utilisateurPost` (`ref_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `signalement`
--

DROP TABLE IF EXISTS `signalement`;
CREATE TABLE IF NOT EXISTS `signalement` (
  `id_signalement` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `ref_signalant` int NOT NULL,
  `ref_signale` int NOT NULL,
  `titre` text NOT NULL,
  `contenu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_signalement`),
  KEY `fk_utilisateurSignalant` (`ref_signalant`),
  KEY `fk_utilisateurSignale` (`ref_signale`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mdp` varchar(256) NOT NULL,
  `date_inscription` date NOT NULL,
  `statut_validation` varchar(50) NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_utilisateurwithrole`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_utilisateurwithrole`;
CREATE TABLE IF NOT EXISTS `v_utilisateurwithrole` (
`date_inscription` date
,`email` varchar(150)
,`id_utilisateur` int
,`mdp` varchar(256)
,`nom` varchar(100)
,`prenom` varchar(100)
,`role` varchar(10)
,`statut_validation` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure de la vue `v_utilisateurwithrole`
--
DROP TABLE IF EXISTS `v_utilisateurwithrole`;

DROP VIEW IF EXISTS `v_utilisateurwithrole`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_utilisateurwithrole`  AS SELECT `u`.`id_utilisateur` AS `id_utilisateur`, `u`.`nom` AS `nom`, `u`.`prenom` AS `prenom`, `u`.`email` AS `email`, `u`.`mdp` AS `mdp`, `u`.`date_inscription` AS `date_inscription`, `u`.`statut_validation` AS `statut_validation`, 'alumni' AS `role` FROM (`alumni` `a` join `utilisateur` `u` on((`u`.`id_utilisateur` = `a`.`ref_utilisateur`)))union select `u`.`id_utilisateur` AS `id_utilisateur`,`u`.`nom` AS `nom`,`u`.`prenom` AS `prenom`,`u`.`email` AS `email`,`u`.`mdp` AS `mdp`,`u`.`date_inscription` AS `date_inscription`,`u`.`statut_validation` AS `statut_validation`,'etudiant' AS `role` from (`etudiant` `e` join `utilisateur` `u` on((`u`.`id_utilisateur` = `e`.`ref_utilisateur`))) union select `u`.`id_utilisateur` AS `id_utilisateur`,`u`.`nom` AS `nom`,`u`.`prenom` AS `prenom`,`u`.`email` AS `email`,`u`.`mdp` AS `mdp`,`u`.`date_inscription` AS `date_inscription`,`u`.`statut_validation` AS `statut_validation`,'partenaire' AS `role` from (`partenaire` `p` join `utilisateur` `u` on((`u`.`id_utilisateur` = `p`.`ref_utilisateur`))) union select `u`.`id_utilisateur` AS `id_utilisateur`,`u`.`nom` AS `nom`,`u`.`prenom` AS `prenom`,`u`.`email` AS `email`,`u`.`mdp` AS `mdp`,`u`.`date_inscription` AS `date_inscription`,`u`.`statut_validation` AS `statut_validation`,'professeur' AS `role` from (`professeur` `pr` join `utilisateur` `u` on((`u`.`id_utilisateur` = `pr`.`ref_utilisateur`)))  ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `fk_entrepriseAlumni` FOREIGN KEY (`ref_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_formationAlumni` FOREIGN KEY (`ref_promotion`) REFERENCES `promotion` (`id_promotion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_utilisateurAlumni` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `fk_formationEtudiant` FOREIGN KEY (`ref_formation`) REFERENCES `formation` (`id_formation`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_promotionEtudiant` FOREIGN KEY (`ref_promotion`) REFERENCES `promotion` (`id_promotion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_utilisateurEtudiant` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `fk_entrepriseOffre` FOREIGN KEY (`ref_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `offreutilisateur`
--
ALTER TABLE `offreutilisateur`
  ADD CONSTRAINT `fk_offreOffreUtilisateur` FOREIGN KEY (`ref_offre`) REFERENCES `offre` (`id_offre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateurOffreUtilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD CONSTRAINT `fk_entreprisePartenaire` FOREIGN KEY (`ref_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateurPartenaire` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `fk_evenementParticipe` FOREIGN KEY (`ref_evenement`) REFERENCES `evenement` (`id_evenement`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_utilisateurParticipe` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_postUtilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD CONSTRAINT `fk_utilisateurProfesseur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `professeurformation`
--
ALTER TABLE `professeurformation`
  ADD CONSTRAINT `fk_formationProfesseurFormation` FOREIGN KEY (`ref_formation`) REFERENCES `formation` (`id_formation`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_professeurProfesseurFormation` FOREIGN KEY (`ref_professeur`) REFERENCES `professeur` (`ref_utilisateur`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_reponsePost` FOREIGN KEY (`ref_post`) REFERENCES `post` (`id_post`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_utilisateurPost` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `signalement`
--
ALTER TABLE `signalement`
  ADD CONSTRAINT `fk_utilisateurSignalant` FOREIGN KEY (`ref_signalant`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateurSignale` FOREIGN KEY (`ref_signale`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
