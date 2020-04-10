
ALTER TABLE `issue_main` ADD INDEX(`project_id`);

ALTER TABLE `issue_label_data` ADD INDEX(`issue_id`);
ALTER TABLE `issue_label_data` ADD INDEX(`label_id`);
ALTER TABLE `field_main` ADD INDEX(`is_system`);
ALTER TABLE `field_custom_value` ADD INDEX( `issue_id`, `custom_field_id`);