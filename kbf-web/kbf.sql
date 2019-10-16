-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.20-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table kbf.climbing_fee
CREATE TABLE IF NOT EXISTS `climbing_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL COMMENT '1=semester, 2=year',
  `signed` varchar(15) NOT NULL,
  `receipt` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `climb_person_fk` (`pnr`),
  KEY `climbing_fee_signed` (`signed`),
  CONSTRAINT `climb_person_fk` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`),
  CONSTRAINT `climbing_fee_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table kbf.climbing_fee: ~0 rows (approximately)
/*!40000 ALTER TABLE `climbing_fee` DISABLE KEYS */;
INSERT INTO `climbing_fee` (`id`, `pnr`, `paymentDate`, `type`, `signed`, `receipt`) VALUES
	(2, '901104', '2018-09-13 19:20:27', '1', '901103', '5efea03248dfbd1b8c62a8478713e9cdf8abbb984c708e0006');
/*!40000 ALTER TABLE `climbing_fee` ENABLE KEYS */;

-- Dumping structure for table kbf.item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `signed` varchar(15) DEFAULT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pnr` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_signed` (`signed`),
  CONSTRAINT `item_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.item: ~8 rows (approximately)
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` (`id`, `name`, `price`, `signed`, `paymentDate`, `pnr`) VALUES
	(3, 'Medlemsavgift', 250, '901103', '2018-09-13 19:20:27', '901104'),
	(4, 'Terminskort', 500, '901103', '2018-09-13 19:20:27', '901104'),
	(5, '10-kort(3276655)', 400, '901103', '2019-03-19 21:43:02', NULL),
	(6, '10-kort(8009158)', 400, '901103', '2019-03-20 21:53:15', NULL),
	(7, '10-kort(3056577)', 400, '901103', '2019-03-20 21:56:41', NULL),
	(8, 'Medlemsavgift', 250, '901103', '2019-03-20 22:35:08', '901104'),
	(9, '10-kort', 300, '901103', '2019-03-20 22:35:08', '901104'),
	(10, '10-kort(4070777)', 300, '901103', '2019-03-20 22:41:00', '901104');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;

-- Dumping structure for table kbf.membership
CREATE TABLE IF NOT EXISTS `membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(10) NOT NULL COMMENT '1=youth, 2=adult',
  `signed` varchar(15) NOT NULL,
  `registered` int(11) NOT NULL DEFAULT '0',
  `tmpPnr` varchar(50) DEFAULT NULL,
  `receipt` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `member_person_fk` (`pnr`),
  KEY `member_signed` (`signed`),
  CONSTRAINT `member_person_fk` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`),
  CONSTRAINT `member_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=1410 DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.membership: ~1 rows (approximately)
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
INSERT INTO `membership` (`id`, `pnr`, `paymentDate`, `type`, `signed`, `registered`, `tmpPnr`, `receipt`) VALUES
	(1407, '901103', '2018-09-13 19:19:47', '2', '901103', 1, NULL, '0'),
	(1408, '901104', '2018-09-13 19:20:27', '2', '901103', 0, '901104xxxx', 'f7b127cb0175bac48ed3b97a47e95e3549ebc2317972c3816f'),
	(1409, '901104', '2019-03-20 22:35:08', '2', '901103', 0, '901104xxxx', 'a6981112c17d7af160611241f355fb87f684c1bb6744988e14');
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;

-- Dumping structure for table kbf.misc
CREATE TABLE IF NOT EXISTS `misc` (
  `type` int(11) DEFAULT NULL,
  `text` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.misc: ~2 rows (approximately)
/*!40000 ALTER TABLE `misc` DISABLE KEYS */;
INSERT INTO `misc` (`type`, `text`) VALUES
	(1, '<ul>    <li>Kod dörr: XXXX</li>    <li>Kod skåp: XXX</li>    <li>Lösenord kalender: XXXX</li></ul><p> <b>2018-01-08</b>: Nu finns blanka tider upplagda i kalendern. Logga in på karlskronabergsport@gmail.com och välj tider för terminen.    Varje öppetansvarig ska ha minst 5 tider.</p>'),
	(2, 'https://drive.google.com/open?id=1ifePduIJikGqA_ztWF2TPFhIFA159-G1'),
	(3, 'https://drive.google.com/open?id=1HNnv9X-DfRtbuiTD-ce53MFdBDmWvf04');
/*!40000 ALTER TABLE `misc` ENABLE KEYS */;

-- Dumping structure for table kbf.open
CREATE TABLE IF NOT EXISTS `open` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `responsible` varchar(15) NOT NULL,
  `signed` varchar(15) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_open_responsible` (`responsible`),
  KEY `fk_open_signed` (`signed`),
  CONSTRAINT `fk_open_responsible` FOREIGN KEY (`responsible`) REFERENCES `person` (`pnr`),
  CONSTRAINT `fk_open_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.open: ~0 rows (approximately)
/*!40000 ALTER TABLE `open` DISABLE KEYS */;
/*!40000 ALTER TABLE `open` ENABLE KEYS */;

-- Dumping structure for table kbf.open_item
CREATE TABLE IF NOT EXISTS `open_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_person` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_open_person_item` (`open_person`),
  CONSTRAINT `fk_open_person_item` FOREIGN KEY (`open_person`) REFERENCES `open_person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table kbf.open_item: ~0 rows (approximately)
/*!40000 ALTER TABLE `open_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `open_item` ENABLE KEYS */;

-- Dumping structure for table kbf.open_person
CREATE TABLE IF NOT EXISTS `open_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `open_id` int(11) NOT NULL,
  `pnr` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `receipt` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `all_fields` (`pnr`,`open_id`,`name`),
  UNIQUE KEY `pnr` (`pnr`,`open_id`),
  KEY `fk_open_id` (`open_id`),
  CONSTRAINT `fk_open_id` FOREIGN KEY (`open_id`) REFERENCES `open` (`id`),
  CONSTRAINT `fk_open_person_pnr` FOREIGN KEY (`pnr`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.open_person: ~0 rows (approximately)
/*!40000 ALTER TABLE `open_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `open_person` ENABLE KEYS */;

-- Dumping structure for table kbf.person
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

-- Dumping data for table kbf.person: ~3 rows (approximately)
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` (`pnr`, `name`, `address`, `email`, `responsible`, `password`, `active`, `forgotToken`) VALUES
	('901102', 'Tobias Hansson', 'Vallgatan 20B', '901102', 3, '$2y$10$dcO7xrogI72vpGabuNleC.KjsmzUoLBIrj.xVYTBA58LfxAyNHzMm', 1, NULL),
	('901103', 'Tobias Hansson', 'Vallgatan 20B', 'me@tobiashansson.nu', 3, '$2y$10$dcO7xrogI72vpGabuNleC.KjsmzUoLBIrj.xVYTBA58LfxAyNHzMm', 1, NULL),
	('901104', '901104 901104', NULL, '901104@test.com', 0, '$2y$10$g8NKsvba2UnR1k4bRWHuheb/TgKRgpyooHlQx4hCOyMQ3ChjSD8Ym', 1, NULL);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;

-- Dumping structure for table kbf.prices
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.prices: ~8 rows (approximately)
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
INSERT INTO `prices` (`id`, `name`, `table`, `type`, `price`, `member_price`, `is_fee`, `item_type`) VALUES
	(1, 'Medlemsavgift', 'membership', 2, 250, NULL, 1, 'checkbox'),
	(2, 'Medlemsavgift(0-17  år)', 'membership', 1, 150, NULL, 1, 'checkbox'),
	(3, 'Årskort', 'climbing_fee', 2, NULL, 800, 1, 'checkbox'),
	(4, 'Terminskort', 'climbing_fee', 1, NULL, 500, 1, 'checkbox'),
	(5, '10-kort', 'ten_card', NULL, 400, 300, 1, 'checkbox'),
	(6, 'Skor', 'open_item', NULL, 20, NULL, 0, 'amount'),
	(7, 'Klättringsavgift', 'open_item', NULL, 50, 40, 0, 'checkbox'),
	(8, 'Kritboll', 'open_item', NULL, 50, NULL, 0, 'checkbox'),
	(9, 'Årskort(barn)', 'climbing_fee', 2, NULL, 600, 1, 'checkbox'),
	(10, 'Terminskort(barn)', 'climbing_fee', 1, NULL, 400, 1, 'checkbox');
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;

-- Dumping structure for table kbf.receipt
CREATE TABLE IF NOT EXISTS `receipt` (
  `id` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table kbf.receipt: ~4 rows (approximately)
/*!40000 ALTER TABLE `receipt` DISABLE KEYS */;
INSERT INTO `receipt` (`id`, `date`) VALUES
	('0c0a12c1bf5fb3107caa8cdcd4d95b1ad3d4dc844ffbb534d1', '2018-02-18 15:12:56'),
	('30382c541fb8f2ebf3d46eab47ce763cb4ae3279a3f92a1fc0', '2018-02-18 21:29:26'),
	('3d3bb60c8465c5d229b6eaef02bdfa449458e09f5910a93ef9', '2019-03-20 22:57:10'),
	('84ff9dd618de4bc349a1cee3189faa1d5109b8d10722969ee4', '2018-02-18 18:32:53'),
	('96563dff2c34f8d29eb7e4bc4919050c2129db9a08607785ca', '2018-02-18 15:26:44'),
	('b8d49dbfd5271ab3ee0680fa6a50acd5b16a8680890f4e549a', '2018-02-18 18:32:22');
/*!40000 ALTER TABLE `receipt` ENABLE KEYS */;

-- Dumping structure for table kbf.ten_card
CREATE TABLE IF NOT EXISTS `ten_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnr` varchar(15) DEFAULT NULL,
  `left` int(11) NOT NULL DEFAULT '10',
  `card` int(11) NOT NULL,
  `signed` varchar(15) NOT NULL,
  `receipt` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card` (`card`),
  KEY `ten_card_signed` (`signed`),
  CONSTRAINT `ten_card_signed` FOREIGN KEY (`signed`) REFERENCES `person` (`pnr`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table kbf.ten_card: ~4 rows (approximately)
/*!40000 ALTER TABLE `ten_card` DISABLE KEYS */;
INSERT INTO `ten_card` (`id`, `pnr`, `left`, `card`, `signed`, `receipt`) VALUES
	(1, NULL, 10, 3276655, '901103', '0'),
	(2, NULL, 10, 8009158, '901103', '0'),
	(3, NULL, 10, 3056577, '901103', 'cd42ff17cc22c9051a3f25fb577e3801b9b49626b3a97e1f06'),
	(4, '901104', 10, 1759582, '901103', 'ec521292a5c091c56dcbad259ff7df9d20763ccf04ca24089b'),
	(5, '901104', 10, 4070777, '901103', '3d3bb60c8465c5d229b6eaef02bdfa449458e09f5910a93ef9');
/*!40000 ALTER TABLE `ten_card` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
