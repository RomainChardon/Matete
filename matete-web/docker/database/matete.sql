-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 05 oct. 2021 à 15:57
-- Version du serveur :  8.0.26-0ubuntu0.20.04.2
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

USE mathismatete;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mathismatete`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int NOT NULL,
  `producteur_id` int DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `producteur_id`, `status`) VALUES
(1, 1, 'admin'),
(2, NULL, 'prod');

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id` int NOT NULL,
  `lieu_id` int DEFAULT NULL,
  `categorie_id` int DEFAULT NULL,
  `creneaux_debut` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `creneaux_fin` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `libelle_produit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_unitaire` double NOT NULL,
  `quantite` int NOT NULL,
  `producteur_id` int DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_mise_en_ligne` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id`, `lieu_id`, `categorie_id`, `creneaux_debut`, `creneaux_fin`, `libelle_produit`, `prix_unitaire`, `quantite`, `producteur_id`, `status`, `date_mise_en_ligne`) VALUES
(1, 1, 1, '2016-01-01 11:00:00', '2016-01-03 10:00:00', 'Pomme', 1, 5600, 1, 'pasEnLigne', NULL),
(2, 2, 1, '2016-01-06 00:00:00', '2016-01-10 00:00:00', 'Frite', 99991, 1, 1, 'enLigne', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int NOT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(1, 'Fruits');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int NOT NULL,
  `date_commande` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_annonce`
--

CREATE TABLE `commande_annonce` (
  `commande_id` int NOT NULL,
  `annonce_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211005122944', '2021-10-05 14:30:03', 807),
('DoctrineMigrations\\Version20211005123305', '2021-10-05 14:33:08', 358),
('DoctrineMigrations\\Version20211005134335', '2021-10-05 15:48:45', 33);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id` int NOT NULL,
  `coo_x` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coo_y` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_lieu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `coo_x`, `coo_y`, `desc_lieu`, `nom`) VALUES
(1, '42.69265478575354', '2.9098509', 'Ceci est le lieu de DEV', 'Salle 110'),
(2, '42.67633206186138', '2.847212154196323', 'Ceci est la maison ou réside le développeur présumé en ce nom de Mathis', 'Mathis');

-- --------------------------------------------------------

--
-- Structure de la table `lieu_producteur`
--

CREATE TABLE `lieu_producteur` (
  `lieu_id` int NOT NULL,
  `producteur_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `producteur`
--

CREATE TABLE `producteur` (
  `id` int NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `producteur`
--

INSERT INTO `producteur` (`id`, `nom`, `prenom`, `tel`, `mail`, `mdp`) VALUES
(1, 'chardon', 'romain', '0678748755', 'romain', 'mdp');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_32EB52E8AB9BB300` (`producteur_id`);

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F65593E56AB213CC` (`lieu_id`),
  ADD KEY `IDX_F65593E5BCF5E72D` (`categorie_id`),
  ADD KEY `IDX_F65593E5AB9BB300` (`producteur_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande_annonce`
--
ALTER TABLE `commande_annonce`
  ADD PRIMARY KEY (`commande_id`,`annonce_id`),
  ADD KEY `IDX_EEE14582EA2E54` (`commande_id`),
  ADD KEY `IDX_EEE1458805AB2F` (`annonce_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lieu_producteur`
--
ALTER TABLE `lieu_producteur`
  ADD PRIMARY KEY (`lieu_id`,`producteur_id`),
  ADD KEY `IDX_2BB1AFA46AB213CC` (`lieu_id`),
  ADD KEY `IDX_2BB1AFA4AB9BB300` (`producteur_id`);

--
-- Index pour la table `producteur`
--
ALTER TABLE `producteur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `producteur`
--
ALTER TABLE `producteur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD CONSTRAINT `FK_32EB52E8AB9BB300` FOREIGN KEY (`producteur_id`) REFERENCES `producteur` (`id`);

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `FK_F65593E56AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `FK_F65593E5AB9BB300` FOREIGN KEY (`producteur_id`) REFERENCES `producteur` (`id`),
  ADD CONSTRAINT `FK_F65593E5BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `commande_annonce`
--
ALTER TABLE `commande_annonce`
  ADD CONSTRAINT `FK_EEE14582EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EEE1458805AB2F` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `lieu_producteur`
--
ALTER TABLE `lieu_producteur`
  ADD CONSTRAINT `FK_2BB1AFA46AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2BB1AFA4AB9BB300` FOREIGN KEY (`producteur_id`) REFERENCES `producteur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
