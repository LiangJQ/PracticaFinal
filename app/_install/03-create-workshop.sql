CREATE TABLE IF NOT EXISTS `practica_final`.`workshop` (
  `workshop_id` int(11) NOT NULL AUTO_INCREMENT,
  `workshop_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `workshop_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `workshop_url_web` varchar(150) COLLATE utf8_unicode_ci,
  `workshop_url-file` varchar(200) COLLATE utf8_unicode_ci,
  `workshop_date` date NOT NULL,
  PRIMARY KEY (`workshop_id`),
  UNIQUE KEY `workshop_name` (`workshop_name`),
  UNIQUE KEY `workshop_date` (`workshop_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
