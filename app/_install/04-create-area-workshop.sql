CREATE TABLE IF NOT EXISTS `practica_final`.`area_workshop` (
  `area_workshop_id` int(11) NOT NULL,
  `area_workshop_table` int(11) NOT NULL,
  `area_workshop_seat` int(11) NOT NULL,
  `area_workshop_user_id` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `practica_final`.`area_workshop`
ADD CONSTRAINT `area_workshop_workshop_fk` FOREIGN KEY
( `area_workshop_id` ) REFERENCES `practica_final`.`workshop` ( `workshop_id` );

ALTER TABLE `practica_final`.`area_workshop`
ADD CONSTRAINT `area_workshop_users_fk` FOREIGN KEY
( `area_workshop_user_id` ) REFERENCES `practica_final`.`users` ( `user_id` );