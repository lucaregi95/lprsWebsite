-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 22 sep. 2026 à 08:11
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

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
  `id_oU` int NOT NULL AUTO_INCREMENT,
  `ref_offre` int NOT NULL,
  `ref_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_oU`),
  KEY `fk_offreOffreUtilisateur` (`ref_offre`),
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
  `id_participe` int NOT NULL AUTO_INCREMENT,
  `est_orga` tinyint(1) NOT NULL,
  `ref_utilisateur` int NOT NULL,
  `ref_evenement` int NOT NULL,
  PRIMARY KEY (`id_participe`),
  KEY `fk_evenementParticipe` (`ref_evenement`),
  KEY `fk_utilisateurParticipe` (`ref_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `contenu` longtext NOT NULL,
  `datetime` datetime NOT NULL,
  `ref_utilisateur` int NOT NULL,
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
  `id_pF` int NOT NULL AUTO_INCREMENT,
  `ref_professeur` int NOT NULL,
  `ref_formation` int NOT NULL,
  PRIMARY KEY (`id_pF`),
  KEY `fk_professeurProfesseurFormation` (`ref_professeur`),
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
  ADD CONSTRAINT `fk_entrepriseOffre` FOREIGN KEY (`ref_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `offreutilisateur`
--
ALTER TABLE `offreutilisateur`
  ADD CONSTRAINT `fk_offreOffreUtilisateur` FOREIGN KEY (`ref_offre`) REFERENCES `offre` (`id_offre`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_utilisateurOffreUtilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD CONSTRAINT `fk_entreprisePartenaire` FOREIGN KEY (`ref_entreprise`) REFERENCES `entreprise` (`id_entreprise`) ON DELETE RESTRICT ON UPDATE RESTRICT,
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
