# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.5.5-10.1.37-MariaDB)
# Base de données: spe-clo5
# Temps de génération: 2019-03-20 13:23:58 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table Hotels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Hotels`;

CREATE TABLE `Hotels` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `website` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Hotels` WRITE;
/*!40000 ALTER TABLE `Hotels` DISABLE KEYS */;

INSERT INTO `Hotels` (`id`, `name`, `website`)
VALUES
	(1,'GreatPalacium','www.great-palacium.fr'),
	(2,'SanSiroHotelArena','www.sanssirohotelarena.fr');

/*!40000 ALTER TABLE `Hotels` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Reservations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Reservations`;

CREATE TABLE `Reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `room_id` int(10) unsigned NOT NULL,
  `hotel_id` int(10) unsigned NOT NULL,
  `has_parking` tinyint(4) DEFAULT NULL,
  `has_baby_bed` tinyint(4) DEFAULT NULL,
  `has_romance_pack` tinyint(4) DEFAULT NULL,
  `has_breakfast` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`,`room_id`,`hotel_id`),
  KEY `fk_Reservations_Users1_idx` (`user_id`),
  KEY `fk_Reservations_Hotels1_idx` (`hotel_id`),
  KEY `fk_Reservations_Rooms1_idx` (`room_id`,`hotel_id`),
  CONSTRAINT `fk_Reservations_Hotels1` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reservations_Rooms1` FOREIGN KEY (`room_id`, `hotel_id`) REFERENCES `Rooms` (`id`, `hotel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reservations_Users1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Reservations` WRITE;
/*!40000 ALTER TABLE `Reservations` DISABLE KEYS */;

INSERT INTO `Reservations` (`id`, `user_id`, `room_id`, `hotel_id`, `has_parking`, `has_baby_bed`, `has_romance_pack`, `has_breakfast`)
VALUES
	(1,1,1,1,1,1,1,1);

/*!40000 ALTER TABLE `Reservations` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Rooms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Rooms`;

CREATE TABLE `Rooms` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `nb_people` int(11) DEFAULT NULL,
  `informations` varchar(45) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `hotel_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`hotel_id`),
  KEY `fk_Childrens_Parents1_idx` (`hotel_id`),
  CONSTRAINT `fk_Childrens_Parents1` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Rooms` WRITE;
/*!40000 ALTER TABLE `Rooms` DISABLE KEYS */;

INSERT INTO `Rooms` (`id`, `name`, `nb_people`, `informations`, `price`, `hotel_id`)
VALUES
	(1,'GreatNight',5,NULL,250,1);

/*!40000 ALTER TABLE `Rooms` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `id` int(10) unsigned NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;

INSERT INTO `Users` (`id`, `login`, `password`, `email`, `birthdate`)
VALUES
	(1,'ayad_y','test','ayad_y@etna-alternance.net','1996-03-06 00:00:00');

/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
