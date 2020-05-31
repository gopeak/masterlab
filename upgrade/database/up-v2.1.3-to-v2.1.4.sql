
ALTER TABLE `main_notify_scheme_data` ADD `title_tpl` VARCHAR(128) NOT NULL DEFAULT '' AFTER `user`;
ALTER TABLE `main_notify_scheme_data` ADD `body_tpl` TEXT NOT NULL AFTER `title_tpl`;
