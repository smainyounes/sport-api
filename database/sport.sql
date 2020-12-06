-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 05, 2020 at 09:16 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `img`
--

DROP TABLE IF EXISTS `img`;
CREATE TABLE IF NOT EXISTS `img` (
  `id_img` int(11) NOT NULL AUTO_INCREMENT,
  `id_sport` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id_img`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `img`
--

INSERT INTO `img` (`id_img`, `id_sport`, `link`) VALUES
(1, 1, '1.jpg'),
(2, 2, '1.jpg'),
(3, 1, '2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wilaya` varchar(50) NOT NULL,
  `commune` varchar(50) NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tel` varchar(20) NOT NULL,
  `img_prof` varchar(100) DEFAULT NULL,
  `img_cover` varchar(100) DEFAULT NULL,
  `description_salle` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `etat_salle` varchar(50) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id_salle`),
  UNIQUE KEY `username` (`username`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salle`
--

INSERT INTO `salle` (`id_salle`, `nom`, `username`, `password`, `wilaya`, `commune`, `address`, `tel`, `img_prof`, `img_cover`, `description_salle`, `etat_salle`) VALUES
(1, 'test', 'test', '$2y$10$GEaLrJxnl0XPzkP1xOVQvOV8tHtyN5FLsJcEgH2vbD7yL3hPpK.qa', '09', 'Oued Alleug', 'f darna', '123456789', '1.jpg', '1.jpg', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\nezjnzregjubzgre', 'active'),
(2, 'test2', 'test2', '$2y$10$jRrfqE6nSQwWUmVcEYA0IeRinSIkictAPfqUhkSnOdT7sbfHyRdei', '09', 'blida', 'blida', '123456789', '1.jpg', '1.jpg', 'some random thing', 'active'),
(3, 'james', 'james', '$2y$10$GaA460EztDwIp3uOylBI5evDw0.LfJare2.ieUj0ACsCPV8iERPn2', '09', 'Blida', 'f darna', '123456798', '1.jpg', '1.jpg', 'lorem bla bla bla hhhhh', 'active'),
(6, 'james', 'younes', '$2y$10$eroQfPsXid1OIrwev9FphOxVASTmFMBMLtZmaE8SvMe57wzgfciR.', 'blida', 'blida', 'somwhere', '123456789', NULL, NULL, 'hello how r u', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `salle_login`
--

DROP TABLE IF EXISTS `salle_login`;
CREATE TABLE IF NOT EXISTS `salle_login` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `id_salle` int(11) NOT NULL,
  `session_tokken` text NOT NULL,
  `ip` varchar(50) NOT NULL,
  `infos` text NOT NULL,
  PRIMARY KEY (`id_session`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;


--
-- Table structure for table `sport`
--

DROP TABLE IF EXISTS `sport`;
CREATE TABLE IF NOT EXISTS `sport` (
  `id_sport` int(11) NOT NULL AUTO_INCREMENT,
  `id_salle` int(11) NOT NULL,
  `nom_arab` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nom_french` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description_sport` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_sport`),
  KEY `id_sport` (`id_sport`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`id_sport`, `id_salle`, `nom_arab`, `nom_french`, `description_sport`) VALUES
(1, 1, 'الكاراتيه\r\n', 'karate', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(2, 1, 'الكاراتيه\r\n', 'karate', 'random bla bla'),
(219, 1, 'رياضة كرة القدم', 'Le football', ''),
(220, 1, 'التنس', 'Le tennis', ''),
(221, 1, 'كرة السلة', 'Le basketball', ''),
(222, 1, 'كرة الطائرة', 'Le volleyball', ''),
(223, 1, 'تنس الريشة', 'Le badminton', ''),
(224, 1, 'كرة اليد', 'Le handball', ''),
(225, 1, 'الاسكواش', 'Le squash', ''),
(226, 1, 'تنس الطاولة', 'Le ping-pong', ''),
(227, 1, 'الهوكي', 'Le hockey', ''),
(228, 1, 'الجمباز', 'La gymnastique', ''),
(229, 1, 'المصارعة', 'La lutte', ''),
(230, 1, 'الملاكمة', 'La boxe', ''),
(231, 1, 'الكاراتية', 'Le karaté', ''),
(232, 1, 'الجودو', 'Le judo', ''),
(233, 1, 'السباحة', 'La natation', ''),
(234, 1, 'التزلج', 'Le patin à glace', ''),
(235, 1, 'التزلج', 'Le patinage', ''),
(236, 1, 'التزلج', 'Le ski', ''),
(237, 1, 'ركوب الامواج', 'Le kitesurf', ''),
(238, 1, 'المركب الشراعي', 'La planche à voile', ''),
(239, 1, 'القوارب المطاطية', 'Le kayak', ''),
(240, 1, 'التجديف', 'Le rafting', ''),
(241, 1, 'الفروسية', 'L’équitation', ''),
(242, 1, 'تسلق الجبال', 'L’escalade', ''),
(243, 1, 'ركوب الدراجات', 'Le cyclisme', ''),
(244, 1, 'رمي السهام', 'Le tir à l’arc', ''),
(245, 1, 'الكرة الحديدية', 'La pétanque', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `img`
--
ALTER TABLE `img`
  ADD CONSTRAINT `img_ibfk_1` FOREIGN KEY (`id_sport`) REFERENCES `sport` (`id_sport`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sport`
--
ALTER TABLE `sport`
  ADD CONSTRAINT `sport_ibfk_1` FOREIGN KEY (`id_salle`) REFERENCES `salle` (`id_salle`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
