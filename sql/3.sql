ALTER TABLE `af_persons` CHANGE `created` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `af_persons` CHANGE `social_sec_nr` `social_sec_nr` BIGINT(11) NULL DEFAULT NULL;


ALTER TABLE `af_doctors` ADD `dr_name` VARCHAR(200) NULL AFTER `af_hospidals_id`;


ALTER TABLE `af_bookings` DROP FOREIGN KEY `fk_af_bookings_af_doctors_deseaes1`; ALTER TABLE `af_bookings` ADD CONSTRAINT `fk_af_bookings_af_doctors_deseaes2` FOREIGN KEY (`af_doctors_deseaes_id`) REFERENCES `np3799_abprojekt`.`af_deseases`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;