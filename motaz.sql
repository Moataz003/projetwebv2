-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 08:52 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id_user` int(6) NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Age` int(25) NOT NULL,
  `Ville` varchar(25) NOT NULL,
  `Num_tel` int(12) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `Role` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `img` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id_user`, `Nom`, `Prenom`, `Age`, `Ville`, `Num_tel`, `Email`, `Role`, `password`, `img`) VALUES
(13, 'user2', 'azer', 22, 'el', 98765432, 'zaidiilyes15@gmail.com', 'Administrateur', '908c9a17973cb4ad614c657939d888d1', '../uploads/golf6.jpg'),
(14, 'Ines', 'Azer', 20, 'tu', 12345678, 'ines@gmail.com', 'Administrateur', '12345678', '../uploads/download.jpg'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id_user` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
