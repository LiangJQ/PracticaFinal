CREATE TABLE `area_workshop` (
	`area_id` INT(11) NOT NULL,
	`area_table` INT(11) NOT NULL DEFAULT '0',
	`area_seat` INT(11) NOT NULL DEFAULT '0',
	`area_user_id` INT(11) NOT NULL,
	INDEX `FK_area_workshop_workshop` (`area_id`),
	INDEX `FK_area_workshop_users` (`area_user_id`),
	CONSTRAINT `FK_area_workshop_workshop` FOREIGN KEY (`area_id`) REFERENCES `workshop` (`workshop_id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK_area_workshop_users` FOREIGN KEY (`area_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB;
