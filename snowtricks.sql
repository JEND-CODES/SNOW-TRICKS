-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 02 mars 2021 à 21:59
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `classification`
--

CREATE TABLE `classification` (
  `id` int(11) NOT NULL,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classification`
--

INSERT INTO `classification` (`id`, `title`) VALUES
(1, 'Nouveautés'),
(2, 'Créations'),
(3, 'Grabs'),
(4, 'Rotations'),
(5, 'Flips'),
(6, 'Slides'),
(7, 'One Foot'),
(8, 'Old School'),
(9, 'Switchings'),
(10, 'Improvisés'),
(11, 'Flyings'),
(12, 'Big Air'),
(13, 'Half Pipe'),
(14, 'Slopestyle'),
(15, 'Bordercross'),
(16, 'Street');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210204232701', '2021-02-25 18:33:05', 669),
('DoctrineMigrations\\Version20210205005437', '2021-02-25 18:33:06', 3072);

-- --------------------------------------------------------

--
-- Structure de la table `figure`
--

CREATE TABLE `figure` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `classification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fresh_date` datetime DEFAULT NULL,
  `labelled` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `figure`
--

INSERT INTO `figure` (`id`, `title`, `content`, `image`, `created_at`, `classification_id`, `user_id`, `fresh_date`, `labelled`) VALUES
(1, 'Mute', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/styleweek.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'mute'),
(2, 'Style Week', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/tips.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'style-week'),
(3, 'Indy', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/backair.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'indy'),
(4, 'Stalefish', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/stalefish.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'stalefish'),
(5, 'Tail grab', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/redstyle.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'tail-grab'),
(6, 'Nose Grab', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/backgrab.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'nose-grab'),
(7, 'Japan Air', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/birdy.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'japan-air'),
(8, 'Seat Belt', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/elegant.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'seat-belt'),
(9, 'Truck driver', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/falling.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'truck-driver'),
(10, 'Big foot', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/flying.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'big-foot'),
(11, 'Slide', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/halfpipe.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'slide'),
(12, 'Modulo', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/header.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'modulo'),
(13, 'Flip', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/indy.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'flip'),
(14, 'Method Air', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/curvy.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'method-air'),
(15, 'Back flip', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/jumpgrab.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'back-flip'),
(16, 'Misty', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/longrampe.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'misty'),
(17, 'Tail slide', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/multiple.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'tail-slide'),
(18, 'Big air', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/jump.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'big-air'),
(19, 'Gutter Ball', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/noseslide.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'gutter-ball'),
(20, 'Flip 900', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/onehand.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'flip-900'),
(21, 'Rotation 180', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/perspective.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'rotation-180'),
(22, 'Rotation 360', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/rampe.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'rotation-360'),
(23, 'Rotation 720', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/sapins.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'rotation-720'),
(24, 'Switch 270', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/slide.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'switch-270'),
(25, 'Front flip', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/slideleft.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'front-flip'),
(26, 'Mac Twist', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/specialjump.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'mac-twist'),
(27, 'Rodeo', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/speed.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'rodeo'),
(28, 'Backside Air', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/mute.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'backside-air'),
(29, 'Nose slide', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/backnose.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'nose-slide'),
(30, 'Rocket Air', 'Lorem ipsum sed ut perspiciatis..!', 'http://symfony1.planetcode.fr/photos/incredible.jpg', '2021-03-02 10:56:06', 16, 7, NULL, 'rocket-air');

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validation` tinyint(1) NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `email`, `username`, `password`, `avatar`, `created_at`, `token`, `validation`, `role`) VALUES
(1, 'jean@gmail.com', 'jean', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar0.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_ADMIN'),
(2, 'julie@gmail.com', 'julie', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar1.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_USER'),
(3, 'vincent@gmail.com', 'vincent', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar2.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_USER'),
(4, 'billy@gmail.com', 'billy', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar3.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_USER'),
(5, 'marion@gmail.com', 'marion', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar4.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_USER'),
(6, 'michel@gmail.com', 'michel', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar5.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_USER'),
(7, 'paolo@gmail.com', 'paolo', '$2y$13$Nkxk0zZrpPkk/xI/YV1qr.TmBvlGqAx6u3x10u4KxCYarocKllkh6', 'snowAvatar6.jpg', '2021-03-02 10:56:06', NULL, 1, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Structure de la table `mention`
--

CREATE TABLE `mention` (
  `id` int(11) NOT NULL,
  `figure_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mention`
--

INSERT INTO `mention` (`id`, `figure_id`, `content`, `created_at`, `user_id`) VALUES
(1, 1, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(2, 2, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(3, 3, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(4, 4, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(5, 5, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(6, 6, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(7, 7, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(8, 8, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(9, 9, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(10, 10, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(11, 11, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(12, 12, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(13, 13, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(14, 14, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(15, 15, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(16, 16, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(17, 17, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(18, 18, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(19, 19, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(20, 20, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(21, 21, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(22, 22, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(23, 23, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(24, 24, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(25, 25, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(26, 26, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(27, 27, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(28, 28, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(29, 29, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7),
(30, 30, 'Lorem ipsum dolor sit amet..!', '2021-03-02 10:56:06', 7);

-- --------------------------------------------------------

--
-- Structure de la table `screen`
--

CREATE TABLE `screen` (
  `id` int(11) NOT NULL,
  `figure_id` int(11) NOT NULL,
  `thumbnail` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `screen`
--

INSERT INTO `screen` (`id`, `figure_id`, `thumbnail`) VALUES
(1, 1, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(2, 1, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(3, 1, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(4, 1, 'UrMDH3um3CE'),
(5, 1, 's3jRiFyOijw'),
(6, 1, 'SQyTWk7OxSI'),
(7, 2, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(8, 2, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(9, 2, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(10, 2, 'UrMDH3um3CE'),
(11, 2, 's3jRiFyOijw'),
(12, 2, 'SQyTWk7OxSI'),
(13, 3, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(14, 3, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(15, 3, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(16, 3, 'UrMDH3um3CE'),
(17, 3, 's3jRiFyOijw'),
(18, 3, 'SQyTWk7OxSI'),
(19, 4, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(20, 4, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(21, 4, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(22, 4, 'UrMDH3um3CE'),
(23, 4, 's3jRiFyOijw'),
(24, 4, 'SQyTWk7OxSI'),
(25, 5, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(26, 5, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(27, 5, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(28, 5, 'UrMDH3um3CE'),
(29, 5, 's3jRiFyOijw'),
(30, 5, 'SQyTWk7OxSI'),
(31, 6, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(32, 6, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(33, 6, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(34, 6, 'UrMDH3um3CE'),
(35, 6, 's3jRiFyOijw'),
(36, 6, 'SQyTWk7OxSI'),
(37, 7, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(38, 7, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(39, 7, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(40, 7, 'UrMDH3um3CE'),
(41, 7, 's3jRiFyOijw'),
(42, 7, 'SQyTWk7OxSI'),
(43, 8, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(44, 8, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(45, 8, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(46, 8, 'UrMDH3um3CE'),
(47, 8, 's3jRiFyOijw'),
(48, 8, 'SQyTWk7OxSI'),
(49, 9, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(50, 9, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(51, 9, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(52, 9, 'UrMDH3um3CE'),
(53, 9, 's3jRiFyOijw'),
(54, 9, 'SQyTWk7OxSI'),
(55, 10, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(56, 10, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(57, 10, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(58, 10, 'UrMDH3um3CE'),
(59, 10, 's3jRiFyOijw'),
(60, 10, 'SQyTWk7OxSI'),
(61, 11, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(62, 11, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(63, 11, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(64, 11, 'UrMDH3um3CE'),
(65, 11, 's3jRiFyOijw'),
(66, 11, 'SQyTWk7OxSI'),
(67, 12, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(68, 12, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(69, 12, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(70, 12, 'UrMDH3um3CE'),
(71, 12, 's3jRiFyOijw'),
(72, 12, 'SQyTWk7OxSI'),
(73, 13, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(74, 13, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(75, 13, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(76, 13, 'UrMDH3um3CE'),
(77, 13, 's3jRiFyOijw'),
(78, 13, 'SQyTWk7OxSI'),
(79, 14, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(80, 14, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(81, 14, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(82, 14, 'UrMDH3um3CE'),
(83, 14, 's3jRiFyOijw'),
(84, 14, 'SQyTWk7OxSI'),
(85, 15, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(86, 15, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(87, 15, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(88, 15, 'UrMDH3um3CE'),
(89, 15, 's3jRiFyOijw'),
(90, 15, 'SQyTWk7OxSI'),
(91, 16, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(92, 16, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(93, 16, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(94, 16, 'UrMDH3um3CE'),
(95, 16, 's3jRiFyOijw'),
(96, 16, 'SQyTWk7OxSI'),
(97, 17, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(98, 17, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(99, 17, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(100, 17, 'UrMDH3um3CE'),
(101, 17, 's3jRiFyOijw'),
(102, 17, 'SQyTWk7OxSI'),
(103, 18, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(104, 18, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(105, 18, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(106, 18, 'UrMDH3um3CE'),
(107, 18, 's3jRiFyOijw'),
(108, 18, 'SQyTWk7OxSI'),
(109, 19, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(110, 19, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(111, 19, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(112, 19, 'UrMDH3um3CE'),
(113, 19, 's3jRiFyOijw'),
(114, 19, 'SQyTWk7OxSI'),
(115, 20, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(116, 20, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(117, 20, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(118, 20, 'UrMDH3um3CE'),
(119, 20, 's3jRiFyOijw'),
(120, 20, 'SQyTWk7OxSI'),
(121, 21, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(122, 21, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(123, 21, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(124, 21, 'UrMDH3um3CE'),
(125, 21, 's3jRiFyOijw'),
(126, 21, 'SQyTWk7OxSI'),
(127, 22, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(128, 22, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(129, 22, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(130, 22, 'UrMDH3um3CE'),
(131, 22, 's3jRiFyOijw'),
(132, 22, 'SQyTWk7OxSI'),
(133, 23, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(134, 23, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(135, 23, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(136, 23, 'UrMDH3um3CE'),
(137, 23, 's3jRiFyOijw'),
(138, 23, 'SQyTWk7OxSI'),
(139, 24, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(140, 24, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(141, 24, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(142, 24, 'UrMDH3um3CE'),
(143, 24, 's3jRiFyOijw'),
(144, 24, 'SQyTWk7OxSI'),
(145, 25, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(146, 25, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(147, 25, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(148, 25, 'UrMDH3um3CE'),
(149, 25, 's3jRiFyOijw'),
(150, 25, 'SQyTWk7OxSI'),
(151, 26, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(152, 26, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(153, 26, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(154, 26, 'UrMDH3um3CE'),
(155, 26, 's3jRiFyOijw'),
(156, 26, 'SQyTWk7OxSI'),
(157, 27, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(158, 27, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(159, 27, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(160, 27, 'UrMDH3um3CE'),
(161, 27, 's3jRiFyOijw'),
(162, 27, 'SQyTWk7OxSI'),
(163, 28, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(164, 28, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(165, 28, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(166, 28, 'UrMDH3um3CE'),
(167, 28, 's3jRiFyOijw'),
(168, 28, 'SQyTWk7OxSI'),
(169, 29, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(170, 29, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(171, 29, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(172, 29, 'UrMDH3um3CE'),
(173, 29, 's3jRiFyOijw'),
(174, 29, 'SQyTWk7OxSI'),
(175, 30, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(176, 30, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(177, 30, 'https://www.meriski.co.uk/uploads/Images/blog/Beginners_Guide_To_Skiing/_1200/41273701930_c5a6c590f0_o.jpg'),
(178, 30, 'UrMDH3um3CE'),
(179, 30, 's3jRiFyOijw'),
(180, 30, 'SQyTWk7OxSI');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classification`
--
ALTER TABLE `classification`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `figure`
--
ALTER TABLE `figure`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2F57B37A2B36786B` (`title`),
  ADD KEY `IDX_2F57B37A2A86559F` (`classification_id`),
  ADD KEY `IDX_2F57B37AA76ED395` (`user_id`);

--
-- Index pour la table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_70E4FA78E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_70E4FA78F85E0677` (`username`);

--
-- Index pour la table `mention`
--
ALTER TABLE `mention`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E20259CD5C011B5` (`figure_id`),
  ADD KEY `IDX_E20259CDA76ED395` (`user_id`);

--
-- Index pour la table `screen`
--
ALTER TABLE `screen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DF4C61305C011B5` (`figure_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classification`
--
ALTER TABLE `classification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `figure`
--
ALTER TABLE `figure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `mention`
--
ALTER TABLE `mention`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `screen`
--
ALTER TABLE `screen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `FK_2F57B37A2A86559F` FOREIGN KEY (`classification_id`) REFERENCES `classification` (`id`),
  ADD CONSTRAINT `FK_2F57B37AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `member` (`id`);

--
-- Contraintes pour la table `mention`
--
ALTER TABLE `mention`
  ADD CONSTRAINT `FK_E20259CD5C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`),
  ADD CONSTRAINT `FK_E20259CDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `member` (`id`);

--
-- Contraintes pour la table `screen`
--
ALTER TABLE `screen`
  ADD CONSTRAINT `FK_DF4C61305C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
