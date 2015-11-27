ALTER TABLE `af_persons` CHANGE `created` `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `af_persons` CHANGE `social_sec_nr` `social_sec_nr` BIGINT(11) NULL DEFAULT NULL;