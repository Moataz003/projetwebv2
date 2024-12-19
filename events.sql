-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 18 déc. 2024 à 16:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `events`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `image` varchar(255) NOT NULL,
  `sponsors` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `location`, `start_date`, `end_date`, `created_at`, `updated_at`, `status`, `image`, `sponsors`) VALUES
(33, 'zdfvvc', 'S§KDVHUMN', 'qekltjg', '2024-12-15 17:06:00', '2024-12-19 17:06:00', '2024-12-12 16:06:54', '2024-12-13 13:01:49', 'active', '', 0),
(34, 'hftyich n', ';j;gcgjctcy', 'htdc', '2024-12-22 17:49:00', '2025-01-04 17:49:00', '2024-12-12 16:49:50', NULL, 'inactive', '', 0),
(35, 'mlhfcvxsdfh', ',hg,jgfgc', 'ngffh', '2024-12-22 17:50:00', '2024-12-25 17:50:00', '2024-12-12 16:50:08', NULL, 'inactive', '', 0),
(36, 'mnbyugfhcfcfcgj', 'nbcgfjfghcgh', 'ngjrdrj', '2024-12-17 21:55:00', '2024-12-28 21:55:00', '2024-12-12 20:55:45', NULL, 'active', '', 0),
(42, 'sdjbs<fs;,', '<sflk', '<fk<fskl,', '2024-12-20 23:37:00', '2024-12-27 23:37:00', '2024-12-12 22:37:59', NULL, 'active', '', 0),
(43, 'Mlhhjbb hjftfc', 'jhyrrt', ':jhgyj', '2024-12-13 23:40:00', '2024-12-27 23:40:00', '2024-12-12 22:41:20', NULL, 'active', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `sponsors`
--

CREATE TABLE `sponsors` (
  `idsponsors` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `contact_info` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sponsors`
--

INSERT INTO `sponsors` (`idsponsors`, `name`, `logo`, `contact_info`, `created_at`, `updated_at`) VALUES
(1, 'Majd', NULL, '98169003', '2024-12-13 13:45:49', '2024-12-13 13:45:49'),
(2, 'Majd', NULL, '98169003', '2024-12-15 13:17:43', '2024-12-15 13:17:43'),
(3, 'oijo', NULL, '98169003', '2024-12-15 13:43:17', '2024-12-15 13:43:17');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sponsors` (`sponsors`);

--
-- Index pour la table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`idsponsors`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `idsponsors` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
