CREATE DATABASE  IF NOT EXISTS `dbuser`;

USE `dbuser`;

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `photo` varchar(300) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);