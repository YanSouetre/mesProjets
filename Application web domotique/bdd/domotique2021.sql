-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2021 at 12:13 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `domotique2021`
--

-- --------------------------------------------------------

--
-- Table structure for table `amis`
--

CREATE TABLE `amis` (
  `usersid` int(11) NOT NULL,
  `friendid` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `demandes`
--

CREATE TABLE `demandes` (
  `usersid` int(11) NOT NULL,
  `friendid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lieu`
--

CREATE TABLE `lieu` (
  `id` int(11) NOT NULL,
  `usersid` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lieu`
--

INSERT INTO `lieu` (`id`, `usersid`, `nom`) VALUES
(13, 1, 'room'),
(15, 2, 'SalonRenuy'),
(16, 7, 'lol'),
(17, 7, 'loool'),
(18, 7, 'lol'),
(19, 1, 'bedroom');

-- --------------------------------------------------------

--
-- Table structure for table `objets`
--

CREATE TABLE `objets` (
  `id` int(11) NOT NULL,
  `lieuid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `etat` int(11) NOT NULL,
  `etatprecision` varchar(255) NOT NULL,
  `usersid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `objets`
--

INSERT INTO `objets` (`id`, `lieuid`, `typeid`, `nom`, `etat`, `etatprecision`, `usersid`) VALUES
(97, 13, 3, 'Chauffage', 1, '52;04:58;20:02', 1),
(98, 13, 2, 'Alarme', 0, '17:00;', 1),
(99, 13, 1, 'Ampoule', 0, '#00e1ff;100', 1),
(100, 15, 1, 'Ampoule', 0, '', 2),
(101, 16, 1, 'Ampoule', 0, '', 7),
(103, 15, 2, 'Alarme', 0, '', 2),
(104, 19, 1, 'Ampoule', 0, '', 1),
(105, 19, 4, 'Volets', 0, '', 1),
(106, 13, 4, 'Volets', 2, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `usersid` int(11) NOT NULL,
  `pieces` int(11) NOT NULL,
  `objets` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`usersid`, `pieces`, `objets`) VALUES
(1, 2, 6),
(2, 1, 2),
(7, 3, 1),
(9, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `sexe` varchar(255) NOT NULL,
  `firstco` date NOT NULL DEFAULT current_timestamp(),
  `lastco` datetime DEFAULT NULL,
  `Question` varchar(255) NOT NULL,
  `Reponse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mail`, `prenom`, `nom`, `mdp`, `photo`, `adresse`, `sexe`, `firstco`, `lastco`, `Question`, `Reponse`) VALUES
(1, 'jladeiro@efficom-lille.com', 'Jules', 'Ladeiro', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'e758ee54a4be02d78e3bbf0679f3344c2.jpg', 'Mons-En-Baroeul', '', '2021-03-20', '2021-04-24 12:04:15', 'Comment s\'appelle mon Lapin ?', 'Zen'),
(2, 'grenuy@efficom-lille.com', 'Gregory', 'Renuy', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'stonks3.png', '', '', '2021-04-19', '2021-04-24 12:05:20', '', ''),
(7, 'Morikekonatekm12@gmail.com', 'MORIKE', 'KONATE', '9cf95dacd226dcf43da376cdb6cbba7035218921', 'morike1.png', 'BAMAKO/ML', 'Homme', '2021-04-08', '2021-04-20 16:30:20', '', ''),
(9, 'bamalick56@yahoo.fr', 'Malik Tidiani', 'Ba', '9cf95dacd226dcf43da376cdb6cbba7035218921', '', '72 Rue de DOUAI', 'Homme', '2021-04-14', '2021-04-20 15:23:55', 'Quels est le nom de mon chien ?', 'Lulu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amis`
--
ALTER TABLE `amis`
  ADD KEY `usersid` (`usersid`),
  ADD KEY `friendid` (`friendid`);

--
-- Indexes for table `demandes`
--
ALTER TABLE `demandes`
  ADD KEY `usersid` (`usersid`),
  ADD KEY `friendid` (`friendid`);

--
-- Indexes for table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersid` (`usersid`);

--
-- Indexes for table `objets`
--
ALTER TABLE `objets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersid` (`usersid`),
  ADD KEY `lieuid` (`lieuid`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD KEY `usersid` (`usersid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `objets`
--
ALTER TABLE `objets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amis`
--
ALTER TABLE `amis`
  ADD CONSTRAINT `amis_ibfk_1` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `amis_ibfk_2` FOREIGN KEY (`friendid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `demandes_ibfk_1` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `demandes_ibfk_2` FOREIGN KEY (`friendid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `lieu_ibfk_1` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `objets`
--
ALTER TABLE `objets`
  ADD CONSTRAINT `objets_ibfk_1` FOREIGN KEY (`lieuid`) REFERENCES `lieu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `objets_ibfk_2` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`);

--
-- Constraints for table `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
