-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: karlskronabergsport.se.mysql:3306
-- Generation Time: Mar 23, 2017 at 09:48 PM
-- Server version: 5.5.54-MariaDB-1~wheezy
-- PHP Version: 5.4.45-0+deb7u7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `karlskronabergs`
--

-- --------------------------------------------------------

--
-- Table structure for table `climbing_fee`
--

CREATE TABLE IF NOT EXISTS `climbing_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL COMMENT '1=semester, 2=year',
  `signed` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `climb_person_fk` (`pnr`),
  KEY `climbing_fee_signed` (`signed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=17 ;

--
-- Dumping data for table `climbing_fee`
--

INSERT INTO `climbing_fee` (`id`, `pnr`, `paymentDate`, `type`, `signed`) VALUES
(8, '850906', '2017-02-21 22:18:55', '2', '901103'),
(9, '960622', '2017-02-23 17:29:12', '2', '901103'),
(10, '961223', '2017-02-23 17:30:32', '2', '901103'),
(11, '861205', '2017-02-26 15:25:29', '2', '901103'),
(12, '931026', '2017-02-28 17:21:35', '2', '901103'),
(13, '850721', '2017-03-02 17:20:21', '1', '911228'),
(14, '730629', '2017-03-05 15:13:53', '2', '901103'),
(15, '910128', '2017-03-07 18:05:16', '2', '901103'),
(16, '831017', '2017-03-09 17:49:52', '2', '901029');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `signed` varchar(15) DEFAULT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_signed` (`signed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `price`, `signed`, `paymentDate`) VALUES
(13, 'Medlemsavgift', 250, '901103', '2017-02-16 22:11:57'),
(14, 'Medlemsavgift', 250, '901103', '2017-02-16 22:14:35'),
(15, '10-kort(5036202)', 400, '901103', '2017-02-19 15:03:04'),
(18, 'Medlemsavgift', 250, '901103', '2017-02-21 17:29:30'),
(19, 'Årskort', 800, '901103', '2017-02-21 22:18:55'),
(20, 'Medlemsavgift', 250, '911228', '2017-02-23 17:13:20'),
(21, 'Medlemsavgift', 250, '901103', '2017-02-23 17:29:12'),
(22, 'Årskort', 800, '901103', '2017-02-23 17:29:12'),
(23, 'Medlemsavgift', 250, '901103', '2017-02-23 17:30:32'),
(24, 'Årskort', 800, '901103', '2017-02-23 17:30:32'),
(25, 'Medlemsavgift', 250, '840626', '2017-02-26 14:03:43'),
(26, 'Medlemsavgift', 250, '880902', '2017-02-26 14:55:11'),
(27, 'Medlemsavgift', 250, '901103', '2017-02-26 15:25:29'),
(28, 'Årskort', 800, '901103', '2017-02-26 15:25:29'),
(29, 'Medlemsavgift', 250, '870924', '2017-02-28 10:12:30'),
(30, 'Medlemsavgift', 250, '870924', '2017-02-28 10:12:51'),
(31, 'Medlemsavgift', 250, '901103', '2017-02-28 17:21:34'),
(32, 'Årskort', 800, '901103', '2017-02-28 17:21:35'),
(33, 'Medlemsavgift', 250, '930220', '2017-02-28 17:26:02'),
(34, 'Medlemsavgift', 250, '911228', '2017-03-02 17:20:21'),
(35, 'Terminskort', 500, '911228', '2017-03-02 17:20:21'),
(36, 'Medlemsavgift', 250, '830825', '2017-03-02 17:28:28'),
(38, 'Medlemsavgift', 250, '930220', '2017-03-05 10:14:09'),
(39, 'Medlemsavgift', 250, '901103', '2017-03-05 15:13:53'),
(40, 'Årskort', 800, '901103', '2017-03-05 15:13:53'),
(41, 'Medlemsavgift', 250, '901103', '2017-03-07 18:05:16'),
(42, 'Årskort', 800, '901103', '2017-03-07 18:05:16'),
(43, 'Medlemsavgift', 250, '911228', '2017-03-09 17:18:23'),
(44, 'Medlemsavgift', 250, '901029', '2017-03-09 17:49:52'),
(45, 'Årskort', 800, '901029', '2017-03-09 17:49:52'),
(46, 'Medlemsavgift', 250, '930220', '2017-03-16 17:14:54'),
(47, 'Medlemsavgift', 250, '870501', '2017-03-16 17:56:32'),
(48, 'Medlemsavgift', 250, '831130', '2017-03-17 08:47:35'),
(49, 'Medlemsavgift', 250, '831130', '2017-03-17 11:25:08'),
(50, '10-kort(5325640)', 400, '870924', '2017-03-23 18:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL COMMENT '1=youth, 2=adult',
  `signed` varchar(15) NOT NULL,
  `registered` int(11) NOT NULL DEFAULT '0',
  `tmpPnr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_person_fk` (`pnr`),
  KEY `member_signed` (`signed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `pnr`, `paymentDate`, `type`, `signed`, `registered`, `tmpPnr`) VALUES
(9, '901103', '2017-02-16 22:11:57', '2', '901103', 1, NULL),
(10, '940825', '2017-02-16 22:14:35', '2', '901103', 1, NULL),
(13, '850906', '2017-02-21 17:29:30', '2', '901103', 1, NULL),
(14, '911228', '2017-02-23 17:13:20', '2', '911228', 1, NULL),
(15, '960622', '2017-02-23 17:29:12', '2', '901103', 1, NULL),
(16, '961223', '2017-02-23 17:30:32', '2', '901103', 1, NULL),
(17, '840626', '2017-02-26 14:03:43', '2', '840626', 1, NULL),
(18, '880902', '2017-02-26 14:55:11', '2', '880902', 1, NULL),
(19, '861205', '2017-02-26 15:25:29', '2', '901103', 1, NULL),
(20, '870924', '2017-02-28 10:12:30', '2', '870924', 1, NULL),
(21, '870924', '2017-02-28 10:12:51', '2', '870924', 1, NULL),
(22, '931026', '2017-02-28 17:21:34', '2', '901103', 1, NULL),
(23, '890223', '2017-02-28 17:26:02', '2', '930220', 1, NULL),
(24, '850721', '2017-03-02 17:20:21', '2', '911228', 1, NULL),
(25, '830825', '2017-03-02 17:28:28', '2', '830825', 1, NULL),
(26, '930220', '2017-03-05 10:14:09', '2', '930220', 1, NULL),
(27, '730629', '2017-03-05 15:13:53', '2', '901103', 1, NULL),
(28, '910128', '2017-03-07 18:05:16', '2', '901103', 1, NULL),
(29, '901029', '2017-03-09 17:18:23', '2', '911228', 1, NULL),
(30, '831017', '2017-03-09 17:49:52', '2', '901029', 1, NULL),
(31, '911203', '2017-03-16 17:14:54', '2', '930220', 1, NULL),
(32, '870501', '2017-03-16 17:56:32', '2', '870501', 1, NULL),
(33, '831130', '2017-03-17 08:47:35', '2', '831130', 1, NULL),
(35, '790318', '2017-03-17 11:25:08', '2', '831130', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `open`
--

CREATE TABLE IF NOT EXISTS `open` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `responsible` varchar(15) NOT NULL,
  `signed` varchar(15) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_open_responsible` (`responsible`),
  KEY `fk_open_signed` (`signed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `open`
--

INSERT INTO `open` (`id`, `responsible`, `signed`, `date`) VALUES
(13, '890223', '890223', '2017-02-19 13:21:18'),
(14, '870924', '870924', '2017-02-19 14:57:44'),
(15, '870924', '870924', '2017-02-21 17:03:23'),
(16, '901103', '901103', '2017-02-23 17:00:38'),
(18, '911228', '911228', '2017-02-26 12:48:19'),
(19, '880902', '880902', '2017-02-26 14:57:48'),
(20, '930220', '930220', '2017-02-28 17:07:30'),
(21, '830825', '830825', '2017-03-02 17:07:43'),
(22, '870924', '870924', '2017-03-05 12:59:44'),
(23, '930220', '930220', '2017-03-05 15:03:20'),
(24, '840626', '840626', '2017-03-07 16:59:38'),
(25, '901029', '901103', '2017-03-09 17:20:09'),
(26, '890223', '890223', '2017-03-12 14:57:55'),
(27, '870501', '870501', '2017-03-14 17:05:45'),
(28, '930220', '930220', '2017-03-16 16:54:51'),
(29, '880902', '880902', '2017-03-19 12:52:17'),
(30, '911228', '911228', '2017-03-19 14:38:20'),
(31, '830825', '830825', '2017-03-21 17:02:51'),
(32, '870924', NULL, '2017-03-23 18:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `open_item`
--

CREATE TABLE IF NOT EXISTS `open_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_person` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_open_person_item` (`open_person`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1524 ;

--
-- Dumping data for table `open_item`
--

INSERT INTO `open_item` (`id`, `open_person`, `name`, `price`) VALUES
(1366, 111, 'Skor', 20),
(1367, 111, 'KlÃ¤ttringsavgift', 50),
(1368, 112, 'Skor', 20),
(1369, 112, 'Skor', 20),
(1370, 112, 'KlÃ¤ttringsavgift', 50),
(1371, 114, 'Skor', 20),
(1372, 114, 'KlÃ¤ttringsavgift', 50),
(1373, 115, 'KlÃ¤ttringsavgift', 50),
(1374, 116, 'Skor', 20),
(1375, 116, 'KlÃ¤ttringsavgift', 50),
(1376, 117, 'Skor', 20),
(1377, 117, 'KlÃ¤ttringsavgift', 50),
(1378, 122, 'Skor', 20),
(1379, 122, 'KlÃ¤ttringsavgift', 50),
(1380, 123, 'Skor', 20),
(1381, 126, 'Skor', 20),
(1382, 126, 'Skor', 20),
(1383, 126, 'KlÃ¤ttringsavgift', 50),
(1384, 131, 'Klättringsavgift', 50),
(1385, 132, 'Skor', 20),
(1386, 132, 'Klättringsavgift', 50),
(1387, 133, 'Skor', 20),
(1388, 133, 'Klättringsavgift', 50),
(1389, 134, 'Skor', 20),
(1390, 134, 'Klättringsavgift', 50),
(1391, 135, 'Skor', 20),
(1392, 135, 'Klättringsavgift', 50),
(1393, 136, 'Skor', 20),
(1394, 136, 'Klättringsavgift', 50),
(1395, 143, 'Skor', 20),
(1396, 144, 'Klättringsavgift', 50),
(1397, 146, 'Klättringsavgift', 50),
(1398, 147, 'Klättringsavgift', 50),
(1399, 149, 'Skor', 20),
(1400, 149, 'Skor', 20),
(1401, 149, 'Klättringsavgift', 50),
(1402, 150, 'Skor', 20),
(1403, 150, 'Skor', 20),
(1404, 150, 'Klättringsavgift', 50),
(1405, 151, 'Skor', 20),
(1406, 151, 'Skor', 20),
(1407, 151, 'Klättringsavgift', 50),
(1408, 152, 'Skor', 20),
(1409, 152, 'Skor', 20),
(1410, 153, 'Skor', 20),
(1411, 153, 'Klättringsavgift', 50),
(1412, 154, 'Skor', 20),
(1413, 154, 'Klättringsavgift', 50),
(1414, 155, 'Skor', 20),
(1415, 155, 'Klättringsavgift', 50),
(1416, 161, 'Skor', 20),
(1417, 161, 'Klättringsavgift', 50),
(1418, 162, 'Skor', 20),
(1419, 162, 'Klättringsavgift', 50),
(1420, 163, 'Klättringsavgift', 50),
(1421, 171, 'Klättringsavgift', 50),
(1422, 173, 'Skor', 20),
(1423, 173, 'Klättringsavgift', 50),
(1424, 174, 'Klättringsavgift', 50),
(1425, 175, 'Skor', 20),
(1426, 175, 'Klättringsavgift', 50),
(1427, 178, 'Skor', 20),
(1428, 182, 'Skor', 20),
(1429, 182, 'Klättringsavgift', 50),
(1430, 186, 'Skor', 20),
(1431, 186, 'Klättringsavgift', 50),
(1432, 190, 'Skor', 20),
(1433, 190, 'Klättringsavgift', 50),
(1436, 192, 'Skor', 20),
(1437, 192, 'Klättringsavgift', 50),
(1439, 194, 'Klättringsavgift', 50),
(1440, 195, 'Klättringsavgift', 50),
(1441, 197, 'Skor', 20),
(1442, 198, 'Klättringsavgift', 50),
(1443, 200, 'Skor', 20),
(1444, 200, 'Skor', 20),
(1445, 200, 'Klättringsavgift', 50),
(1446, 201, 'Skor', 20),
(1447, 201, 'Skor', 20),
(1448, 201, 'Klättringsavgift', 50),
(1449, 202, 'Klättringsavgift', 50),
(1450, 203, 'Klättringsavgift', 50),
(1451, 206, 'Skor', 20),
(1452, 206, 'Klättringsavgift', 50),
(1453, 207, 'Klättringsavgift', 50),
(1454, 208, 'Klättringsavgift', 50),
(1455, 212, 'Skor', 20),
(1456, 212, 'Klättringsavgift', 50),
(1457, 215, 'Klättringsavgift', 50),
(1458, 216, 'Klättringsavgift', 50),
(1459, 219, 'Skor', 20),
(1460, 219, 'Klättringsavgift', 50),
(1461, 220, 'Skor', 20),
(1462, 220, 'Klättringsavgift', 50),
(1463, 228, 'Klättringsavgift', 50),
(1464, 231, 'Klättringsavgift', 50),
(1465, 232, 'Skor', 20),
(1466, 232, 'Klättringsavgift', 50),
(1467, 234, 'Klättringsavgift', 50),
(1468, 235, 'Klättringsavgift', 50),
(1469, 244, 'Klättringsavgift', 50),
(1470, 249, 'Skor', 20),
(1471, 250, 'Skor', 20),
(1472, 250, 'Klättringsavgift', 50),
(1473, 251, 'Skor', 20),
(1474, 251, 'Klättringsavgift', 50),
(1475, 252, 'Skor', 20),
(1476, 252, 'Klättringsavgift', 50),
(1477, 253, 'Klättringsavgift', 50),
(1478, 256, 'Klättringsavgift', 50),
(1479, 257, 'Skor', 20),
(1480, 257, 'Klättringsavgift', 50),
(1481, 258, 'Skor', 20),
(1482, 258, 'Klättringsavgift', 50),
(1483, 261, 'Skor', 20),
(1484, 261, 'Klättringsavgift', 50),
(1485, 262, 'Skor', 20),
(1486, 262, 'Klättringsavgift', 50),
(1488, 273, 'Klättringsavgift', 40),
(1489, 274, 'Klättringsavgift', 50),
(1490, 276, 'Skor', 20),
(1491, 276, 'Klättringsavgift', 50),
(1492, 282, 'Klättringsavgift', 50),
(1493, 285, 'Klättringsavgift', 50),
(1494, 286, 'Klättringsavgift', 50),
(1495, 287, 'Klättringsavgift', 50),
(1496, 291, 'Skor', 20),
(1497, 291, 'Skor', 20),
(1498, 291, 'Klättringsavgift', 50),
(1499, 292, 'Skor', 20),
(1500, 292, 'Klättringsavgift', 50),
(1501, 294, 'Skor', 20),
(1502, 294, 'Klättringsavgift', 50),
(1505, 296, 'Klättringsavgift', 50),
(1506, 297, 'Skor', 20),
(1507, 297, 'Klättringsavgift', 50),
(1508, 298, 'Klättringsavgift', 50),
(1509, 300, 'Skor', 20),
(1510, 300, 'Klättringsavgift', 50),
(1511, 301, 'Skor', 20),
(1512, 301, 'Klättringsavgift', 50),
(1513, 308, 'Skor', 20),
(1514, 308, 'Klättringsavgift', 50),
(1515, 310, 'Skor', 20),
(1516, 310, 'Klättringsavgift', 50),
(1517, 314, 'Klättringsavgift', 50),
(1518, 317, 'Skor', 20),
(1519, 318, 'Skor', 20),
(1520, 318, 'Klättringsavgift', 50),
(1521, 319, 'Skor', 20),
(1522, 319, 'Klättringsavgift', 50),
(1523, 321, 'Klättringsavgift', 50);

-- --------------------------------------------------------

--
-- Table structure for table `open_person`
--

CREATE TABLE IF NOT EXISTS `open_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_id` int(11) NOT NULL,
  `pnr` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `all_fields` (`pnr`,`open_id`,`name`),
  UNIQUE KEY `pnr` (`pnr`,`open_id`),
  KEY `fk_open_id` (`open_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=327 ;

--
-- Dumping data for table `open_person`
--

INSERT INTO `open_person` (`id`, `open_id`, `pnr`, `name`) VALUES
(111, 13, NULL, 'Hanna Tegelberg'),
(112, 13, NULL, 'Karin Jilder'),
(119, 14, NULL, 'Ana pejic'),
(120, 14, NULL, 'Annika Hansson'),
(115, 14, NULL, 'hanne hagerorn'),
(117, 14, NULL, 'Jessica Conrad'),
(118, 14, NULL, 'Stevan Miloradovic'),
(114, 14, NULL, 'Tom Thomas'),
(121, 14, NULL, 'Tristan Axelsson Smith'),
(116, 14, NULL, 'Yannick Wassmer'),
(128, 15, NULL, 'Ana pejic'),
(125, 15, NULL, 'Annika Hansson'),
(130, 15, NULL, 'Bogdan Marculescu'),
(127, 15, NULL, 'Jan-Peter Nilsson'),
(122, 15, NULL, 'Johan Ingemarsson'),
(123, 15, NULL, 'Li Ingemarsson'),
(129, 15, NULL, 'Martin Ahl'),
(126, 15, NULL, 'Peter ostling'),
(124, 15, NULL, 'Simon SvensgÃ¥rd'),
(134, 16, NULL, 'Adam Brus'),
(137, 16, NULL, 'Annika Hansson'),
(146, 16, NULL, 'Aron Helmstad'),
(144, 16, NULL, 'BjÃ¶rn Nyman'),
(148, 16, NULL, 'Bogdan Marculeseu'),
(136, 16, NULL, 'Henrik Lihden'),
(147, 16, NULL, 'Isabell Paulrud'),
(143, 16, NULL, 'Jakup'),
(131, 16, NULL, 'Jonas Nordin'),
(138, 16, NULL, 'Oscar Carlsson'),
(133, 16, NULL, 'Rebecca Heilert'),
(132, 16, NULL, 'Sara Grass'),
(135, 16, NULL, 'Simon Nilsson'),
(139, 16, NULL, 'Simon SvensgÃ¥rd'),
(150, 18, NULL, 'Bosse Stensson'),
(152, 18, NULL, 'Johan Gustavsson'),
(151, 18, NULL, 'Johan Svedberg'),
(149, 18, NULL, 'Lotta Stensson'),
(157, 19, NULL, 'Annika Hansson'),
(153, 19, NULL, 'Dennis wattrup'),
(154, 19, NULL, 'Elin Lindqvist '),
(166, 19, NULL, 'Eva garcia'),
(155, 19, NULL, 'Jenny hoffet'),
(163, 19, NULL, 'Jonas Nordin'),
(160, 19, NULL, 'Justin sjÃ¶berg'),
(156, 19, NULL, 'Oscar Carlsson'),
(161, 19, NULL, 'Sam Biggs'),
(162, 19, NULL, 'Sam Biggs'),
(178, 20, NULL, '850906'),
(171, 20, NULL, 'Hanne Hagedorn'),
(174, 20, NULL, 'Madeleine olbert'),
(175, 20, NULL, 'Sam Biggs'),
(173, 20, NULL, 'Vinicius Ludwig Barbosa'),
(194, 21, NULL, 'Anna-Karin Flenhagen'),
(190, 21, NULL, 'Annika Warnquist'),
(182, 21, NULL, 'Elin Svensson'),
(189, 21, NULL, 'HÃ¥kan Persson'),
(197, 21, NULL, 'Jakob Luszczynski'),
(192, 21, NULL, 'Jonas Heimfors'),
(195, 21, NULL, 'Jonas Nordin'),
(198, 21, NULL, 'Madelene Olbert'),
(186, 21, NULL, 'Marcel SjÃ¶berg'),
(202, 22, NULL, 'Johan Arvidsson'),
(200, 22, NULL, 'Nina FogelstrÃ¶m'),
(203, 22, NULL, 'Simone Wenzel'),
(201, 22, NULL, 'Sofia loell'),
(216, 23, NULL, 'annika silfverberg'),
(212, 23, NULL, 'elin svensson '),
(207, 23, NULL, 'Hanne Hagedorn'),
(215, 23, NULL, 'ivarnelson'),
(206, 23, NULL, 'Jessica Conrad'),
(208, 23, NULL, 'Jonas Nordin '),
(218, 23, NULL, 'Martin Ahl '),
(232, 24, NULL, 'Alberto Cucchi'),
(219, 24, NULL, 'Denis Wattrup'),
(220, 24, NULL, 'Elin Lindqvist'),
(235, 24, NULL, 'Jan-Peter Nilsson'),
(234, 24, NULL, 'Jonas Nordin'),
(228, 24, NULL, 'Linnea Andersson'),
(231, 24, NULL, 'Madeleine Olbert'),
(244, 25, NULL, 'Hanne'),
(253, 26, NULL, 'Alexandra Taranu'),
(257, 26, NULL, 'Axel Niklasson'),
(249, 26, NULL, 'carl nilsson'),
(251, 26, NULL, 'Lorraine Mei'),
(250, 26, NULL, 'marcus karlsson'),
(252, 26, NULL, 'Marcus L'),
(258, 26, NULL, 'Soulo'),
(256, 26, NULL, 'Tszsan wong'),
(261, 27, NULL, 'Frank Larsen'),
(271, 27, NULL, 'Martin Ahl'),
(269, 27, NULL, 'Olivia Brännlund'),
(262, 27, NULL, 'Shahrzad Razm'),
(268, 27, NULL, 'Tszsan Wong'),
(273, 28, NULL, '911203'),
(282, 28, NULL, 'Hanne'),
(276, 28, NULL, 'jens liljegren'),
(274, 28, NULL, 'madeleine olbert'),
(286, 30, NULL, 'Anton Johansson '),
(292, 30, NULL, 'Birgit Gustavsson'),
(297, 30, NULL, 'Christian Nordahl'),
(285, 30, NULL, 'Martin BergstrÃ¶m'),
(287, 30, NULL, 'Mikael Nilsson'),
(291, 30, NULL, 'Ola Gustavsson '),
(296, 30, NULL, 'Piotr Boleslaw'),
(298, 30, NULL, 'Tomas Bereckei '),
(294, 30, NULL, 'Vinicius Barbosa'),
(300, 31, NULL, 'Dennis Wattrup'),
(301, 31, NULL, 'Elin Lindquist'),
(310, 31, NULL, 'Jens Liljegren'),
(314, 31, NULL, 'Madelene Olbert'),
(308, 31, NULL, 'Vinicius Barbosa'),
(325, 32, NULL, '5325640'),
(319, 32, NULL, 'Anna warnqvist'),
(320, 32, NULL, 'Annika Hansson'),
(317, 32, NULL, 'Carl Nilsson'),
(322, 32, NULL, 'Jan-Per Nilsson'),
(318, 32, NULL, 'Jonas Heimfors'),
(321, 32, NULL, 'Rasmus Arvidsson'),
(209, 23, '730629', NULL),
(225, 24, '730629', NULL),
(247, 25, '730629', NULL),
(259, 27, '730629', NULL),
(311, 31, '730629', NULL),
(245, 25, '831017', NULL),
(254, 26, '831017', NULL),
(275, 28, '831017', NULL),
(299, 30, '831017', NULL),
(312, 31, '831017', NULL),
(179, 20, '840626', NULL),
(199, 21, '840626', NULL),
(248, 25, '840626', NULL),
(316, 31, '840626', NULL),
(188, 21, '850721', NULL),
(213, 23, '850721', NULL),
(233, 24, '850721', NULL),
(309, 31, '850721', NULL),
(177, 20, '850906', NULL),
(196, 21, '850906', NULL),
(313, 31, '850906', NULL),
(185, 21, '861205', NULL),
(281, 28, '870501', NULL),
(323, 32, '870501', NULL),
(168, 20, '870924', NULL),
(181, 21, '870924', NULL),
(226, 24, '870924', NULL),
(240, 25, '870924', NULL),
(289, 30, '870924', NULL),
(304, 31, '870924', NULL),
(284, 30, '880902', NULL),
(172, 20, '890223', NULL),
(211, 23, '890223', NULL),
(246, 25, '890223', NULL),
(293, 30, '890223', NULL),
(238, 25, '901029', NULL),
(113, 14, '901103', NULL),
(158, 19, '901103', NULL),
(217, 23, '901103', NULL),
(230, 24, '901103', NULL),
(237, 25, '901103', NULL),
(266, 27, '901103', NULL),
(272, 28, '901103', NULL),
(290, 30, '901103', NULL),
(326, 32, '901103', NULL),
(229, 24, '910128', NULL),
(270, 27, '910128', NULL),
(315, 31, '910128', NULL),
(159, 19, '911228', NULL),
(167, 20, '911228', NULL),
(187, 21, '911228', NULL),
(204, 23, '911228', NULL),
(221, 24, '911228', NULL),
(236, 25, '911228', NULL),
(255, 26, '911228', NULL),
(264, 27, '911228', NULL),
(280, 28, '911228', NULL),
(302, 31, '911228', NULL),
(324, 32, '911228', NULL),
(222, 24, '930220', NULL),
(239, 25, '930220', NULL),
(263, 27, '930220', NULL),
(303, 31, '930220', NULL),
(176, 20, '931026', NULL),
(180, 21, '931026', NULL),
(224, 24, '931026', NULL),
(243, 25, '931026', NULL),
(267, 27, '931026', NULL),
(279, 28, '931026', NULL),
(288, 30, '931026', NULL),
(305, 31, '931026', NULL),
(141, 16, '960622', NULL),
(165, 19, '960622', NULL),
(169, 20, '960622', NULL),
(210, 23, '960622', NULL),
(227, 24, '960622', NULL),
(241, 25, '960622', NULL),
(265, 27, '960622', NULL),
(278, 28, '960622', NULL),
(307, 31, '960622', NULL),
(142, 16, '961223', NULL),
(164, 19, '961223', NULL),
(170, 20, '961223', NULL),
(205, 23, '961223', NULL),
(223, 24, '961223', NULL),
(242, 25, '961223', NULL),
(260, 27, '961223', NULL),
(277, 28, '961223', NULL),
(306, 31, '961223', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `pnr` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `responsible` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=is responsible',
  `password` varchar(255) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `forgotToken` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pnr`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`pnr`, `name`, `address`, `email`, `responsible`, `password`, `active`, `forgotToken`) VALUES
('122000', 'bicoura bicoura', NULL, 'milevianachraf@gmail.com', 0, '$2y$10$YslGv.UgXwwneZXBKEj2lOoJUerwENzscC8qhQGW2zF6bEv9dT8VG', 2, NULL),
('600218', 'Bo Wilhelmsson', NULL, 'bossew60@gmail.com', 0, '$2y$10$E.sK17yNS6f87VQEkggiee.P4Pt8mWIEL8q70IrOW/vUv8WqoLRia', 1, NULL),
('620503', 'Lennart Johansson', NULL, 'lennartochkatarina@telia.com', 0, '$2y$10$2XASiqVX6E8jGF9wh.OlZ.snH3JrG8A.hjgNpiWbvcq8ZK5DpPB2O', 1, NULL),
('730629', 'Bo Nix', NULL, 'bo.m.nix@telia.com', 0, '$2y$10$vW93rwWCwOgZafj5ChtSx.c/BRIkbTRU1IRb3urbHt/M4i9nuQmZ6', 1, NULL),
('790318', 'Catarina NordstrÃ¶m', NULL, 'andersson_catarina@hotmail.com', 0, '$2y$10$3efLs7Tiz9pX1/s4ZH3Gd.Fpq6q2gdWsPDCW1M/NcGFukKbqtQ1fy', 1, NULL),
('800522', 'Andreas Kraft', NULL, 'andreas.kraft@hotmail.com', 2, '$2y$10$FWdAfj4qtESteus19.vnGe9zm8q2f8oEOZOovlIC56Bf4EU69Lbzu', 1, NULL),
('801111', 'Martin Ahl', NULL, 'Martin.ahl.hem@gmail.com', 0, '$2y$10$2ZkPe/IMOiswFDWifKoIVOpLHfyhr8TcyOG0squxRivoFqmqMBnyS', 1, NULL),
('830825', 'Joakim Fredriksson', NULL, 'lak11jfr@student.se', 1, '$2y$10$hya4LiH98xxYPAAGAOQX7Ohrzgy6yjDAXkDxDWAPlvBbwcecG614e', 1, NULL),
('831017', 'Jan-Peter Nilsson', NULL, 'peppe@pappkartong.se', 0, '$2y$10$usmbKIVHCFDuei3HRpQsn.kFMUi35H.KKa4nofHa3DrIfe66cEuba', 1, NULL),
('831130', 'Ola NordstrÃ¶m', NULL, 'nordstromola@hotmail.com', 1, '$2y$10$/q8JG.H6HZ8qhSTDXDv12OB8XI0lEqAA/efkYNk0KVxIxnIVS/MRu', 1, NULL),
('840626', 'Bogdan Marculescu', NULL, 'mmihai352@yahoo.com', 1, '$2y$10$i/Ep0Nbq4dE0dcDUndJosOAvmb54wN0HgapPAcdZ56IF6CQq3Qhp.', 1, NULL),
('850721', 'sandra bejving', NULL, 'yagona@gmail.com', 0, '$2y$10$1CWPXPJyBIJ.LjGsIFuGGexKh0DnltRdMi8iUJs/HhDEfGr8.DHNK', 1, NULL),
('850906', 'Jakub Luszczynski', NULL, 'j.cz.prc@gmail.com', 0, '$2y$10$RM39QmL21g3u/fugHbfHxOWOx4sA/CUNapUxFsfWx9RxLqSxg4UtK', 1, NULL),
('861205', 'Justin SjÃ¶berg', NULL, 'tamar_lake@hotmail.com', 0, '$2y$10$LFzN4CaqVO19D2mjuKWH7OzwAVVcIWZrh8xz/LIO5kTckX/YSRqku', 1, NULL),
('870501', 'Daniel Remle', NULL, 'daniel.remle@gmail.com', 1, '$2y$10$RG3fXNjVtnk1MVkNn.OAfeuFeQv4Sb9pSPc5gWw.qZ86em9Xm.v/a', 1, NULL),
('870924', 'Oscar Carlsson', NULL, 'oscar@0x90.nu', 1, '$2y$10$/4X.SR7/UxxrFEvXgQsJNO4y43MStbGSuqIS4RRsm15jb05OOnif6', 1, NULL),
('880902', 'Tobias Nilsson', NULL, 'tni88@live.se', 1, '$2y$10$1R24dDiFIZLVpLPD/wpOd.c7qPtKW1M5p3VwChPfQvQ0kpvaUc1K2', 1, NULL),
('890223', 'Eva  Garcia', NULL, 'eva.g.596@gmail.com', 1, '$2y$10$C0BZkuIfwMJlOoxCEOWXOOeyMIxvb6RezK67qTuzwCjMVTGlIGOna', 1, NULL),
('900206', 'VinÃ­cius Ludwig Barbosa', NULL, 'viniciuslbar@gmail.com', 0, '$2y$10$eUFwvMvLHWndWL3KsRhmyOB/oobAVPbhxt4cY9GS1OdazBg3tph06', 1, NULL),
('901029', 'Ingar VebjÃ¶rnsen', NULL, 'ingar.vebjornsen@sweco.se', 1, '$2y$10$xYxQEJwt6jPtwgasopZFce.phSzkmjHExdH8Qr6wjUYZI/7rmP4Ye', 1, NULL),
('901103', 'Tobias Hansson', NULL, 'me@tobiashansson.nu', 2, '$2y$10$y6SSCnb2gKUAxcHSNFVHpu6OAgSa.Mdv6huJdn/BCohD1xp0ezwJe', 1, NULL),
('910128', 'Ana Pejic', NULL, 'anaapejic@gmail.com', 0, '$2y$10$LZz8ZZ/T7rVjX3DOhgQqS.LV9lMZDTEZV5QnBXHqyRpXsbIY5Fy3O', 1, NULL),
('911203', 'Rasmus Arvidsson', NULL, 'rasmus.atv@hotmail.com', 0, '$2y$10$vgFaMc4AS0h/ZWrts2RdEOSe29JMYOSt0EdlVWruTznSGgntQkJIC', 1, NULL),
('911228', 'Simon SvensgÃ¥rd', NULL, 'gronbuske@hotmail.com', 1, '$2y$10$bMlQV5ZqxF6WerEbJBAZf.WqdZicYMNjAQACA5adZN/E3.Tz1VRoS', 1, NULL),
('930220', 'HÃ¥kan Persson', NULL, 'hakan.persson.93@gmail.com', 1, '$2y$10$f5inq75wJraO54yU0.exTubl/0FFMMUTExU7xLaboHXLddDM3tKWi', 1, NULL),
('931026', 'Annika Hansson', NULL, 'annika.hansson@saffran.se', 0, '$2y$10$oUhOVDYZVzfCkzq4D.LGa.fcsqi9RdhevERGnmv/68Y0Az7B0dPPC', 1, NULL),
('940122', 'Tsz San Wong', NULL, 'appu.wong@gmail.com', 0, '$2y$10$thdaqUzYv5erGYxQJj6b3uZw0uzvVLSMIx0gEPvP/Y4nq5MciJvI6', 1, NULL),
('940825', 'Olivia BrÃ¤nnlund', NULL, 'olivialillan@hotmail.com', 0, '$2y$10$9VLSojbOFuU5narLtx5zC.V5G5NuVGVmlsgVAox04L4mNJnjVqaQK', 1, NULL),
('960622', 'Tristan Axelsson Smith', NULL, 'tristan23@live.se', 0, '$2y$10$SjghRXioWbjZk.dTZuEY9.GB3RC9/tZRor.MHNAaIRds4KCXYSiGu', 1, NULL),
('961223', 'Stevan Miloradovic', NULL, 'seriousstevan@hotmail.com', 0, '$2y$10$RNF6hzGGQLd8B62wbU1yvOqHlZTJmpx82zXzEsAeQ6iWqYpi3.RRe', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `table` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `member_price` int(11) DEFAULT NULL,
  `is_fee` int(11) DEFAULT NULL,
  `item_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `name`, `table`, `type`, `price`, `member_price`, `is_fee`, `item_type`) VALUES
(1, 'Medlemsavgift', 'membership', 2, 250, NULL, 1, 'checkbox'),
(2, 'Medlemsavgift(0-17 år)', 'membership', 1, 150, NULL, 1, 'checkbox'),
(3, 'Årskort', 'climbing_fee', 2, NULL, 800, 1, 'checkbox'),
(4, 'Terminskort', 'climbing_fee', 1, NULL, 500, 1, 'checkbox'),
(5, '10-kort', 'ten_card', NULL, 400, 300, 1, 'checkbox'),
(6, 'Skor', 'open_item', NULL, 20, NULL, 0, 'amount'),
(7, 'Klättringsavgift', 'open_item', NULL, 50, 40, 0, 'checkbox'),
(8, 'Kritboll', 'open_item', NULL, 50, NULL, 0, 'checkbox'),
(9, 'Årskort(barn)', 'climbing_fee', 2, NULL, 600, 1, 'checkbox'),
(10, 'Terminskort(barn)', 'climbing_fee', 1, NULL, 400, 1, 'checkbox');

-- --------------------------------------------------------

--
-- Table structure for table `ten_card`
--

CREATE TABLE IF NOT EXISTS `ten_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) DEFAULT NULL,
  `left` int(11) NOT NULL DEFAULT '10',
  `card` int(11) NOT NULL,
  `signed` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card` (`card`),
  KEY `ten_card_signed` (`signed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ten_card`
--

INSERT INTO `ten_card` (`id`, `pnr`, `left`, `card`, `signed`) VALUES
(1, NULL, 9, 5325640, '870924');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `climbing_fee`
--
ALTER TABLE `climbing_fee`
  ADD CONSTRAINT `climbing_fee_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`),
  ADD CONSTRAINT `climb_person_fk` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`);

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `member_person_fk` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`),
  ADD CONSTRAINT `member_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`);

--
-- Constraints for table `open`
--
ALTER TABLE `open`
  ADD CONSTRAINT `fk_open_responsible` FOREIGN KEY (`responsible`) REFERENCES `person` (`pnr`),
  ADD CONSTRAINT `fk_open_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`);

--
-- Constraints for table `open_item`
--
ALTER TABLE `open_item`
  ADD CONSTRAINT `fk_open_person_item` FOREIGN KEY (`open_person`) REFERENCES `open_person` (`id`);

--
-- Constraints for table `open_person`
--
ALTER TABLE `open_person`
  ADD CONSTRAINT `fk_open_id` FOREIGN KEY (`open_id`) REFERENCES `open` (`id`),
  ADD CONSTRAINT `fk_open_person_pnr` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`);

--
-- Constraints for table `ten_card`
--
ALTER TABLE `ten_card`
  ADD CONSTRAINT `ten_card_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
