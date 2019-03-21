# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.5.5-10.1.37-MariaDB)
# Base de données: spe-clo5
# Temps de génération: 2019-03-21 11:25:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table Categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Categories`;

CREATE TABLE `Categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `people` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `informations` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;

INSERT INTO `Categories` (`id`, `type`, `people`, `price`, `informations`)
VALUES
	(1,'Suite présidentielle',5,1000,NULL),
	(2,'Suite',3,720,NULL),
	(3,'Junior Suite',2,500,NULL),
	(4,'Chambre de luxe',2,300,NULL),
	(5,'Chambre standard',2,150,NULL);

/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Hotels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Hotels`;

CREATE TABLE `Hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zipcode` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `Hotels` WRITE;
/*!40000 ALTER TABLE `Hotels` DISABLE KEYS */;

INSERT INTO `Hotels` (`id`, `name`, `website`, `address`, `city`, `zipcode`)
VALUES
	(1,'MySuperHotel','www.mysuperwebsite.fr','7 rue Maurice Grandcoing','Ivry-sur-Seine',94200),
	(5,'Georges V','www.georgev-speclo5.fr','10 rue République','Paris 16',75016);

/*!40000 ALTER TABLE `Hotels` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Reservations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Reservations`;

CREATE TABLE `Reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `has_parking` tinyint(4) DEFAULT NULL,
  `has_baby_bed` tinyint(4) DEFAULT NULL,
  `has_romance_pack` tinyint(4) DEFAULT NULL,
  `has_breakfast` tinyint(4) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `final_price` float DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`,`room_id`),
  KEY `fk_Reservations_Users1_idx` (`user_id`),
  KEY `fk_Reservations_Rooms1_idx` (`room_id`),
  CONSTRAINT `fk_Reservations_Rooms1` FOREIGN KEY (`room_id`) REFERENCES `Rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reservations_Users1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `Reservations` WRITE;
/*!40000 ALTER TABLE `Reservations` DISABLE KEYS */;

INSERT INTO `Reservations` (`id`, `has_parking`, `has_baby_bed`, `has_romance_pack`, `has_breakfast`, `user_id`, `room_id`, `date_start`, `date_end`, `final_price`)
VALUES
	(1,1,0,1,1,1,1,'2019-06-25 10:00:00','2019-07-05 10:00:00',NULL);

/*!40000 ALTER TABLE `Reservations` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Rooms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Rooms`;

CREATE TABLE `Rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`hotel_id`,`category_id`),
  KEY `fk_Rooms_Hotels_idx` (`hotel_id`),
  KEY `fk_Rooms_Categories1_idx` (`category_id`),
  CONSTRAINT `fk_Rooms_Categories1` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Rooms_Hotels` FOREIGN KEY (`hotel_id`) REFERENCES `Hotels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `Rooms` WRITE;
/*!40000 ALTER TABLE `Rooms` DISABLE KEYS */;

INSERT INTO `Rooms` (`id`, `hotel_id`, `category_id`)
VALUES
	(1,1,1);

/*!40000 ALTER TABLE `Rooms` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;

INSERT INTO `Users` (`id`, `login`, `email`, `password`, `firstname`, `lastname`, `address`, `city`, `zipcode`, `is_admin`)
VALUES
	(1,'ayad_y','ayad_y@etna-alternance.net','test','Yanis','AYAD','76 avenue du Colonel Fabien','Villepinte','93420',1),
	(2,'elhorm_n','elhorm_n@etna-alternance.net','toto','Nassim','EL Hormi','7 chemin du Pont des Marais','Dammartin-En-Goële','77230',0);

/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
