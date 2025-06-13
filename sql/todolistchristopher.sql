-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 13 juin 2025 à 15:38
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
-- Base de données : `todolistchristopher`
--

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `author` int NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upDateAt` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `validatedAt` datetime DEFAULT NULL,
  `isDone` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id`, `title`, `description`, `author`, `createdAt`, `upDateAt`, `validatedAt`, `isDone`) VALUES
(2, 'Dark Vador1', 'je suis ton pere1', 0, '2025-06-11 14:27:23', '2025-06-12 11:39:21', NULL, 0),
(3, 'Mazda RX-7 FD3S', '13B ROTARY', 0, '2025-06-12 14:46:15', NULL, NULL, 0),
(4, 'Subaru WRX STI', 'EJ2C', 0, '2025-06-12 14:47:55', NULL, NULL, 0),
(5, 'Honda S2000', 'F22C', 0, '2025-06-12 14:48:41', NULL, NULL, 0),
(7, 'Supra MK4', '2JZ-GTE', 0, '2025-06-12 14:50:39', NULL, NULL, 0),
(8, 'Skyline GTR R34', 'RB26', 0, '2025-06-12 14:51:54', NULL, NULL, 0),
(9, 'David', 'Formateur DWWM', 13, '2025-06-12 16:03:09', NULL, NULL, 0),
(10, 'Naruto', 'naruto', 13, '2025-06-13 13:13:43', NULL, NULL, 0),
(11, 'Tomate', 'Couer de boeuf', 1, '2025-06-13 13:49:45', '2025-06-13 14:09:37', NULL, 0),
(12, 'Salade', 'Salade', 13, '2025-06-13 14:17:20', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName` (`userName`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `email`, `isActive`) VALUES
(1, 'sazuke', 'motdepasse', 'rab@aca.portos', 0),
(2, 'david', '1234', 'rgsdfcrez@ezfzf.fr', 0),
(4, 'dd', '1234', 'rgsdfcrez@e.com', 0),
(5, 'gfxgsgfx', 'sgvshfqdfhbfghg', 'de@zerzer.fr', 0),
(6, 'dav', '$2y$10$ILsMbNJQ2wSHBoVf6kdjD.lAPqw0.Z2qiiO96zSBhcxFIJ0lxPIUS', 'dav@mail.fr', 0),
(7, 'cr', '$2y$10$gHQMXe9uXxJIzSva4M29R.JDIrsVcE8EhJ.xBYN6vFC8yDUeYAeQu', 'm@ptpt.fr', 0),
(10, 'test', '$2y$10$dXcQjm8o/wrKvq9yizLSeuA0t9zs56uA/rLXPmrSAOpxk7MMvThye', 'test@test.com', 0),
(12, 'portos', '$2y$10$OZEeztfRuWnIuHdoU.SJ7uLjFDL463JX3vh53gMqwOdAjO.DHdXEe', 'portugal@gmail.com', 0),
(13, 'christopher', '$2y$10$jyPPYn3tp04XXsnfxCcFPept5TDrdSbFmMRxd5Tdp2eplwfqyk2JK', 'ardeche@mail.com', 0),
(14, 'testeur', '$2y$10$zVtLZWqDnL2yR3DvQs5L7.l5IrkLw0RLOtBKx5js6WwNyBN6Jadlu', 'fdjchurfehd@mail.fr', 0);

-- --------------------------------------------------------

--
-- Structure de la table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE IF NOT EXISTS `userinfo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `firstName` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `birthDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `userinfo`
--

INSERT INTO `userinfo` (`id`, `name`, `firstName`, `birthDate`) VALUES
(1, 'RABA', 'Dav', '1985-05-23');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
