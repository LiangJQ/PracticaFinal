-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for practica_final
CREATE DATABASE IF NOT EXISTS `practica_final` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `practica_final`;


-- Dumping structure for table practica_final.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_surname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` enum('user','admin','owner') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table practica_final.users: ~52 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_name`, `user_surname`, `user_password`, `user_email`, `user_role`) VALUES
	(1, 'owner', 'hhhhhhh', '123321', 'owner@owner.com', 'owner'),
	(2, 'admin', 'bbbbbbb', '123', 'admin@admin.com', 'admin'),
	(3, 'user', 'asdsadasd', '1', 'user@user.com', 'user'),
	(4, 'user1', 'vvvvv', '1', 'user1@user1.com', 'user'),
	(5, 'user2', 'dsadsadsad', '1', 'user2@user2.com', 'user'),
	(6, 'user3', 'ccxxzz', '1', 'user3@user3.com', 'user'),
	(7, 'user4', 'dsadsadsad', '1', 'user4@user4.com', 'user'),
	(8, 'user5', 'eqwewq', '1', 'user5@user5.com', 'user'),
	(9, 'user6', 'eeeeeee', '1', 'user6@user6.com', 'user'),
	(10, 'user7', 'xxxxx', '1', 'user7@user7.com', 'user'),
	(11, 'user8', 'dsadsad', '1', 'user8@user8.com', 'user'),
	(12, 'user9', 'dsadsadsad', '1', 'user9@user9.com', 'user'),
	(14, 'user11', 'dsadsadsad', '1', 'user11@user11.com', 'user'),
	(15, 'user12', 'dsadsadsad', '1', 'user12@user12.com', 'user'),
	(16, 'user13', 'dsadsadsad', '1', 'user13@user13.com', 'user'),
	(17, 'user14', 'rewr', '1', 'user14@user14.com', 'user'),
	(18, 'user15', 'dsadsadsad', '1', 'user15@user15.com', 'user'),
	(19, 'user16', 'dsadsadsad', '1', 'user16@user16.com', 'user'),
	(22, 'user19', 'dsadsadsad', '1', 'user19@user19.com', 'user'),
	(23, 'user20', 'dsadsadsad', '1', 'user20@user20.com', 'user'),
	(24, 'user21', 'dsadsaeqweqwedsad', '1', 'user21@user21.com', 'user'),
	(25, 'user22', 'dsadsadsad', '1', 'user22@user22.com', 'user'),
	(26, 'user23', 'dsadsadsad', '1', 'user23@user23.com', 'user'),
	(27, 'user24', 'dsadsadsad', '1', 'user24@user24.com', 'user'),
	(28, 'user25', 'dsadsadsad', '1', 'user25@user25.com', 'user'),
	(29, 'user26', 'dsadsadsad', '1', 'user26@user26.com', 'user'),
	(30, 'user27', 'dsadsadsad', '1', 'user27@user27.com', 'user'),
	(31, 'user28', 'dsadsadsad', '1', 'user28@user28.com', 'user'),
	(32, 'user29', 'dsadsadsad', '1', 'user29@user29.com', 'user'),
	(33, 'user30', 'dsadsadsad', '1', 'user30@user30.com', 'user'),
	(34, 'user31', 'dsadsadsad', '1', 'user31@user31.com', 'user'),
	(35, 'user32', 'dsadsadsad', '1', 'user32@user32.com', 'user'),
	(36, 'user33', 'dsadsadsad', '1', 'user33@user33.com', 'user'),
	(37, 'user34', 'dsadsadsad', '1', 'user34@user34.com', 'user'),
	(38, 'user35', 'dsadsadsad', '1', 'user35@user35.com', 'user'),
	(39, 'user36', 'dsadsadsad', '1', 'user36@user36.com', 'user'),
	(40, 'user37', 'dsadsadsad', '1', 'user37@user37.com', 'user'),
	(41, 'user38', 'dsadsadsad', '1', 'user38@user38.com', 'user'),
	(42, 'user39', 'dsadsadsad', '1', 'user39@user39.com', 'user'),
	(43, 'user40', 'dsadsadsad', '1', 'user40@user40.com', 'user'),
	(44, 'user41', 'dsadsadsad', '1', 'user41@user41.com', 'user'),
	(45, 'user42', 'dsadsadsad', '1', 'user42@user42.com', 'user'),
	(46, 'user43', 'dsadsadsad', '1', 'user43@user43.com', 'user'),
	(47, 'user44', 'dsadsadsad', '1', 'user44@user44.com', 'user'),
	(48, 'user45', 'dsadsadsad', '1', 'user45@user45.com', 'user'),
	(49, 'user46', 'dsadsadsad', '1', 'user46@user46.com', 'user'),
	(50, 'user47', 'dsadsadsad', '1', 'user47@user47.com', 'user'),
	(51, 'user48', 'dsadsadsad', '1', 'user48@user48.com', 'user'),
	(52, 'user49', 'dsadsadsad', '1', 'user49@user49.com', 'user'),
	(53, 'asdsadsa', 'asdsadsadsadsadsa', '1', 'asdsad@asdsad.com', 'user'),
	(100, 'user18', 'dsadsadsad', '1', 'user18@user18.com', 'user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table practica_final.workshop
CREATE TABLE IF NOT EXISTS `workshop` (
  `workshop_id` int(11) NOT NULL AUTO_INCREMENT,
  `workshop_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `workshop_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `workshop_user_id` int(11) NOT NULL,
  `workshop_url_web` text COLLATE utf8_unicode_ci,
  `workshop_url_file` text COLLATE utf8_unicode_ci,
  `workshop_date` date DEFAULT NULL,
  `workshop_request` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `workshop_authorize` enum('Y','N','P') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P',
  PRIMARY KEY (`workshop_id`),
  UNIQUE KEY `workshop_name` (`workshop_name`),
  UNIQUE KEY `workshop_user_id` (`workshop_user_id`),
  UNIQUE KEY `workshop_date` (`workshop_date`),
  CONSTRAINT `FK_workshop_users` FOREIGN KEY (`workshop_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table practica_final.workshop: ~13 rows (approximately)
/*!40000 ALTER TABLE `workshop` DISABLE KEYS */;
INSERT INTO `workshop` (`workshop_id`, `workshop_name`, `workshop_description`, `workshop_user_id`, `workshop_url_web`, `workshop_url_file`, `workshop_date`, `workshop_request`, `workshop_authorize`) VALUES
	(37, 'PHP37', 'blablablaasdasd', 37, '', '', '2014-07-14', 'Y', 'P'),
	(38, 'PHP38', 'blablabla', 38, NULL, NULL, '2014-07-15', 'N', 'P'),
	(39, 'PHP39', 'blablabla', 39, NULL, NULL, '2014-07-16', 'N', 'P'),
	(40, 'PHP40', 'blablabla', 40, NULL, NULL, '2014-07-17', 'N', 'P'),
	(41, 'PHP41', 'blablabla', 41, NULL, NULL, '2014-07-18', 'N', 'P'),
	(42, 'PHP42', 'blablabla', 42, NULL, NULL, '2014-07-19', 'Y', 'P'),
	(43, 'PHP43', 'blablabla', 43, NULL, NULL, '2014-07-20', 'Y', 'P'),
	(44, 'PHP44', 'blablabla', 44, NULL, NULL, '2014-07-21', 'N', 'P'),
	(48, 'PHP46', 'blablabla', 46, NULL, NULL, '2014-06-13', 'Y', 'Y'),
	(54, 'asdsadsadsadsadsadsad', '', 1, '', '', '2014-06-15', 'Y', 'Y'),
	(56, 'jrtuj', '', 100, '', '', '2014-06-16', 'Y', 'Y'),
	(58, 'asdasd', '', 45, '', '', '2014-06-17', 'Y', 'Y'),
	(59, 'dddddddd', '', 35, '', '', '2014-06-18', 'Y', 'Y'),
	(61, 'asdsa', '', 30, '', '', '2014-06-19', 'N', 'P'),
	(62, 'dsadsadsad', '', 2, '', '', '2014-06-20', 'Y', 'P');
/*!40000 ALTER TABLE `workshop` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;


-- Dumping structure for table practica_final.area
CREATE TABLE IF NOT EXISTS `area` (
  `area_id` int(11) NOT NULL,
  `area_table` int(11) NOT NULL DEFAULT '0',
  `area_seat` int(11) NOT NULL DEFAULT '0',
  `area_user_id` int(11) NOT NULL,
  KEY `FK_area_workshop_workshop` (`area_id`),
  KEY `FK_area_workshop_users` (`area_user_id`),
  CONSTRAINT `FK_area_workshop_users` FOREIGN KEY (`area_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_area_workshop_workshop` FOREIGN KEY (`area_id`) REFERENCES `workshop` (`workshop_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table practica_final.area: ~3 rows (approximately)
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` (`area_id`, `area_table`, `area_seat`, `area_user_id`) VALUES
	(54, 2, 1, 2),
	(48, 1, 2, 8),
	(56, 2, 1, 8),
	(56, 2, 2, 1),
	(58, 1, 1, 1),
	(59, 1, 1, 1),
	(62, 1, 2, 4),
	(62, 1, 1, 10);
/*!40000 ALTER TABLE `area` ENABLE KEYS */;