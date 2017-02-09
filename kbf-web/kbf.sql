-- --------------------------------------------------------
-- Värd:                         127.0.0.1
-- Server version:               10.1.20-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for kbf
CREATE DATABASE IF NOT EXISTS `kbf` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kbf`;

-- Dumping structure for tabell kbf.climbing_fee
CREATE TABLE IF NOT EXISTS `climbing_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL COMMENT '1=semester, 2=year',
  `signed` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `climb_person_fk` (`pnr`),
  CONSTRAINT `climb_person_fk` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `signed` varchar(15) DEFAULT NULL,
  `paymentDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.membership
CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL COMMENT '1=youth, 2=adult',
  `signed` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_person_fk` (`pnr`),
  CONSTRAINT `member_person_fk` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.open
CREATE TABLE IF NOT EXISTS `open` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `responsible` varchar(15) NOT NULL,
  `signed` varchar(15) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_open_responsible` (`responsible`),
  KEY `fk_open_signed` (`signed`),
  CONSTRAINT `fk_open_responsible` FOREIGN KEY (`responsible`) REFERENCES `person` (`pnr`),
  CONSTRAINT `fk_open_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.open_item
CREATE TABLE IF NOT EXISTS `open_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_person` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_open_person_item` (`open_person`),
  CONSTRAINT `fk_open_person_item` FOREIGN KEY (`open_person`) REFERENCES `open_person` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1362 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.open_person
CREATE TABLE IF NOT EXISTS `open_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_id` int(11) NOT NULL,
  `pnr` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `all_fields` (`pnr`,`open_id`,`name`),
  UNIQUE KEY `pnr` (`pnr`,`open_id`),
  KEY `fk_open_id` (`open_id`),
  CONSTRAINT `fk_open_id` FOREIGN KEY (`open_id`) REFERENCES `open` (`id`),
  CONSTRAINT `fk_open_person_pnr` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.person
CREATE TABLE IF NOT EXISTS `person` (
  `pnr` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `responsible` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=is responsible',
  `password` varchar(255) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pnr`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for tabell kbf.ten_card
CREATE TABLE IF NOT EXISTS `ten_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) DEFAULT NULL,
  `left` int(11) NOT NULL DEFAULT '10',
  `card` int(11) NOT NULL,
  `signed` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card` (`card`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
