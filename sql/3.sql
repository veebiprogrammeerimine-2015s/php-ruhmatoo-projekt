ALTER TABLE `af_persons` CHANGE `created` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `af_persons` CHANGE `social_sec_nr` `social_sec_nr` BIGINT(11) NULL DEFAULT NULL;


ALTER TABLE `af_doctors` ADD `dr_name` VARCHAR(200) NULL AFTER `af_hospidals_id`;
