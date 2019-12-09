-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 09 déc. 2019 à 23:54
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.3.10

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
('20191201221338', '2019-12-02 10:00:47');

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
(15, 9, 'Meuble TV', 'MEUBLE', 'bon état', 'Super meuble en bois idéale pour des grandes télévisions!!\r\nCause de vente: prend de la place dans un petit appartement...', 350, '2019-12-09 23:18:17'),
(16, 9, 'Télévision 50\"', 'MULTIMEDIA', 'neuf', 'TV au top!\r\nQuasiment neuve!', 1000, '2019-12-09 23:21:00'),
(17, 11, 'Peugeot 405', 'VEHICULE', 'Mais c\'etait sur', 'Super voiture que j\'ai utilisé 20 ans, fonctionne encore, mais vend pour pièces...', 3000, '2019-12-09 23:31:09'),
(18, 11, 'Jouet Coccinelle', 'LOISIR', 'bon état', 'Jouet de déco coccinelle rouge de toute beauté!!', 50, '2019-12-09 23:34:31'),
(19, 11, 'Marteau', 'MATERIEL', 'neuf', 'Marteau qui fait le travail d\'un marteau :/', 10, '2019-12-09 23:37:01'),
(20, 9, 'Collier pas ouf en 8', 'LOISIR', 'Mais c\'etait sur', 'Voila le pire truc du monde mais je le vend quand même pour me payé l\'électricité que m\'a utilisé l\'ordinateur pour mettre en vente celui-ci', 2, '2019-12-09 23:40:59'),
(21, 12, 'BIM BAM BOUM', 'MULTIMEDIA', 'Mais c\'etait sur', 'Du délice cette album!\r\nMais j\'en fait profité tout le monde pour ce prix très faible!\r\nhttps://youtu.be/pjJ2w1FX_Wg?list=RDuAVUl0cAKpo', 1000000, '2019-12-09 23:51:53'),
(22, 12, 'Vend Mon BERNARD', 'LOISIR', 'neuf', 'Il fait que crier \"J\'veux faire l\'amour\"\r\nCa prend la tête mais si vous êtes en manque d\'affection il est au TOP,\r\nje recommande!!', 404, '2019-12-09 23:51:20');

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
(11, 15, 'imagesP2QX0R2T-5deec82924472.jpeg'),
(12, 15, 'imagesW7W30AMM-5deec82927c82.jpeg'),
(13, 15, 'meubletvenboisdeteckrecycle160cargo-5deec8296a189.jpeg'),
(14, 16, 'meubletvenboisdeteckrecycle160ca1rgo-5deec8cc4e4c4.jpeg'),
(15, 16, 'thomson50uv6006tvleduhd4k50127cmhdr-5deec8cc5082e.jpeg'),
(16, 17, '301pxPeugeot405rear20070926-5deecb2d3608d.jpeg'),
(17, 17, 'thumb816x460191df027db5ac0e5d524f3951d96b196-5deecb2d381df.jpeg'),
(18, 17, 'VehiculePEUGEOT405161992f4b14e2ad548d11b469287450d7e08d3e4fd140640f08bd29f336c997e39398e-5deecb2d388d8.jpeg'),
(19, 18, 'MaggiolinorossoLR-5deecbf703250.jpeg'),
(20, 18, 'MaggiolinorossoretroLR-5deecbf705599.jpeg'),
(21, 18, 'vw1303kaefer1972rotmodellauto118norev-5deecbf705f82.jpeg'),
(22, 18, 'a7c0ae50421aa0734135c19174aa-5deecbf7067f2.jpeg'),
(23, 19, 'gedoremarteautyperusse500g4e5008586680ig23539-5deecc8d741b9.jpeg'),
(24, 19, 'marteaurivoirmanchebois1kg38mm-5deecc8d761c4.jpeg'),
(25, 19, 'marteaurivoirjpg-5deecc8dba181.png'),
(26, 20, 'collierargent925pendentifsigneinfinizirconium-5deecd7b6461d.jpeg'),
(27, 20, 'collierinfiniargent-5deecd7b666d6.jpeg'),
(28, 20, 'imagesC1KYHMPF-5deecd7b66e31.jpeg'),
(29, 21, 'bimbamboom-5deecef76038f.jpeg'),
(30, 21, 'cd-5deecef762890.jpeg'),
(31, 21, 'giphy-5deecef762fec.gif'),
(32, 22, 'tenor-5deecfe8271d3.gif'),
(33, 22, '1571164474maxresdefault-5deecfe82a4be.png'),
(34, 22, 'maxresdefault-5deecfe86cbfd.jpeg');

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
(4, 9, 'femme1-5deec6e4e6c58.png'),
(5, 10, 'suprisedman-5deec975ebbd9.jpeg'),
(6, 11, 'suprisedman-5deec9f9109f7.jpeg'),
(7, 12, 'creepyhumanfacemasksdogmuzzlesamazon15d038427be452700-5deece38620a4.jpeg');

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
(9, 'Jeaninedu62', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$N0FkYVRiWExpN0tLS2NZaQ$z/ApLA6C3tMwmtwlDIie8RaGkuL882pThVCT7XxRG5s', 'Jeanine', 'Payre', '2019-12-09', 'Berck Plage', 'Berck', 'Je suis la 1ere vendeuse sur du site j\'adore les animaux!!!', 62600, 'jeaninedu62@gmail.com', '0632569473'),
(10, 'Tom', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$N3ZEMmgyNjRYVXp6ZGJZeA$B5tuzNu/pnt76saNGQzp6OmISK4+l3l3MJn/Z1AD/CI', 'Thomas', 'Pifouny', '2019-12-09', 'place de la mairie', 'Orléans', 'Eleveur d\'animaux en général =)', 45100, 'tom', '0358612745'),
(11, 'thomasdu45', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$WTlmVjV3bENtdW85aTREcg$/8lczuWGxHlR1YLuw/VpvvsMUTDd9TweSl/EeajnXbk', 'Thomas', '¨Phinou', '2019-12-09', 'place de la mairie', 'Orléans', 'Voiture <3', 45000, 'thomasdu45@gmail.com', '0326974538'),
(12, 'Dogeu59', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$US5CcDJuTzllLzJFVTdhOA$Bp24eBjGV3DI27HYLMHzmCRw6TdgNvHi2HeFlMuMteo', 'euhjsp', 'dogeu', '2019-12-09', 'Ah ahhhh jous me trouverai j\'amais', 'Lille', 'Je suis pas ici! O_o', 59000, 'dogeu@gmail.com', '0796253845');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
