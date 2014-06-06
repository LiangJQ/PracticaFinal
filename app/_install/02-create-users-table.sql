CREATE TABLE IF NOT EXISTS `practica_final`.`users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` ENUM ('user','admin','owner') COLLATE utf8_unicode_ci NOT NULL DEFAULT `user`,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create Users
INSERT INTO `users`(`user_id`, `user_name`, `user_password`, `user_email`, `user_role`) VALUES (NULL,'owner','123321','owner@owner.com','owner');
INSERT INTO `practica_final`.`users` (`user_id`, `user_name`, `user_password`, `user_email`, `user_role`) VALUES (NULL, 'admin', '123', 'admin@admin.com', 'admin');