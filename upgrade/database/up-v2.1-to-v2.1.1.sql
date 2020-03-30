
ALTER TABLE `field_custom_value` ADD `value_type` VARCHAR(32) NOT NULL DEFAULT 'string' AFTER `valuet_ype`;
ALTER TABLE `field_custom_value` DROP `valuet_ype`;
