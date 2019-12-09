-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 09 déc. 2019 à 23:04
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `newlbc`
--

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191201221338', '2019-12-01 22:13:52');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `publishdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `user_id`, `name`, `category`, `state`, `description`, `price`, `publishdate`) VALUES
(4, 10, 'fzfefa', 'IMMOBILIER', 'neuf', 'gqgezq', 76, '2019-12-02 19:57:09'),
(5, 10, 'fzfefa', 'IMMOBILIER', 'neuf', 'gqgezq', 76, '2019-12-02 20:02:41'),
(6, 10, 'zefzf', 'IMMOBILIER', 'neuf', 'hrhrth', 68, '2019-12-02 20:03:29'),
(7, 10, 'calloc', 'MEUBLE', 'neuf', 'zezfegeag', 9983, '2019-12-02 20:23:39'),
(8, 10, 'zadadaz', 'LOISIR', 'mauvais état', 'zadad', 4564, '2019-12-03 17:57:00'),
(9, 10, 'testtest', 'IMMOBILIER', 'bon état', 'fezfez', 56, '2019-12-07 18:05:45');

-- --------------------------------------------------------

--
-- Structure de la table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `filename`) VALUES
(2, 4, 'background2-5de55e85264a4.gif'),
(3, 5, 'background2-5de55fd1c743e.gif'),
(4, 6, 'background3-5de56001f15a3.gif'),
(5, 6, 'background4-5de56001f3665.gif'),
(6, 6, 'ico-5de56001f3e3b.png'),
(7, 7, 'background2-5de564bb18bc2.gif'),
(8, 7, 'ico-5de564bb28614.png'),
(9, 7, 'background-5de564bb28cf6.gif'),
(10, 8, 'background4-5de693dc13485.gif'),
(11, 8, 'background4-5de693dc1b96e.gif'),
(12, 8, 'background3-5de693dc1c070.gif'),
(13, 8, 'ico-5de693dc1c9de.png'),
(14, 9, 'ico-5debdbe94df8d.png'),
(15, 9, 'background-5debdbe95164b.gif');

-- --------------------------------------------------------

--
-- Structure de la table `user_image`
--

CREATE TABLE `user_image` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_image`
--

INSERT INTO `user_image` (`id`, `user_id`, `filename`) VALUES
(7, 10, 'background-5de441720369e.gif');

-- --------------------------------------------------------

--
-- Structure de la table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creationdate` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalcode` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_login`
--

INSERT INTO `user_login` (`id`, `username`, `roles`, `password`, `firstname`, `lastname`, `creationdate`, `address`, `city`, `description`, `postalcode`, `email`, `phone`) VALUES
(10, 'tomper', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$dU9ndjJvSWdCVDJyMjR6Qg$ZShi/pYE/2QtNwoA8z9ca5CxRn0oP1glqXMMaNCW4sU', 'per', 'tom', '2019-12-01', 'azdzadaz', 'dzadad', 'gergege', 4, 'tom.per@orange.fr', 'dzadza');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04ADA76ED395` (`user_id`);

--
-- Index pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64617F034584665A` (`product_id`);

--
-- Index pour la table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_27FFFF07A76ED395` (`user_id`);

--
-- Index pour la table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_48CA3048F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`);

--
-- Contraintes pour la table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `FK_64617F034584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `user_image`
--
ALTER TABLE `user_image`
  ADD CONSTRAINT `FK_27FFFF07A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
