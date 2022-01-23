
ALTER TABLE `agile_board` ADD COLUMN `is_hide` tinyint(1) unsigned DEFAULT '0' COMMENT '是否隐藏';

ALTER TABLE `main_webhook` ADD COLUMN  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `main_webhook` ADD COLUMN `filter_project_json` text COLLATE utf8mb4_unicode_ci COMMENT '过滤的事件';