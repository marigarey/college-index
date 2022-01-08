-- Adminer 4.7.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `CollegeIndex` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `CollegeIndex`;

DROP TABLE IF EXISTS `college_CI`;
CREATE TABLE `college_CI` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `city_location` varchar(50) NOT NULL,
  `state_location` varchar(2) NOT NULL,
  `average_act` int NOT NULL,
  `average_tuition` int NOT NULL,
  `pros` longtext NOT NULL,
  `cons` longtext NOT NULL,
  `user_id` int NOT NULL,
  `approved` char(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `college_CI_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_CI` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `college_CI` (`id`, `name`, `city_location`, `state_location`, `average_act`, `average_tuition`, `pros`, `cons`, `user_id`, `approved`) VALUES
(3,	'Northwestern',	'Evansville',	'IL',	35,	70000,	'Close to home!\r\n                      ',	'Expensive\r\n                      ',	1,	'T'),
(4,	'UW Madison',	'Madison',	'WI',	27,	25000,	'Very Close to Home\r\n                      ',	'Very Close to Home\r\n                      ',	1,	'T'),
(5,	'Cornell',	'Ithaca',	'CT',	36,	80000,	'Good Ice Cream\r\n                      ',	'Hard to get into\r\n                      ',	1,	'T'),
(7,	'MATC',	'Madison',	'WI',	25,	10000,	'Great Curriculum! Ken Marks is a great professor \r\n                      ',	'There are no cons!\r\n                      ',	2,	'T'),
(8,	'UW Plattville',	'Plattville',	'WI',	25,	50000,	'Parents went there!\r\n                      ',	'In Wisconsin\r\n                      ',	3,	'T');

DROP TABLE IF EXISTS `user_CI`;
CREATE TABLE `user_CI` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `access_privileges` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No Value Entered',
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'No Value Entered',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user_CI` (`id`, `user_name`, `password_hash`, `access_privileges`, `first_name`, `last_name`) VALUES
(1,	'student',	'$2y$10$zB8MCwH4XJ2v0QPKP6tqCep69NND.5Q.5BIOt5TmzuvRrWQMR8Ss6',	'admin',	'student',	'student'),
(2,	'test',	'$2y$10$zaZXxUfTr65xx/CpaFybOeIXly.i7fXPJ9GvIuiJILbw1Psc0GdRy',	'user',	'test',	'test'),
(3,	'test1',	'$2y$10$7ETm3Ir2PBCprwRV2fu3rO2qUZZsDQYWz26L8exw8FK6mx9sVtNaG',	'user',	'test1',	'test1');

-- 2021-12-11 04:50:57
