

ALTER TABLE `issue_main`  MODIFY COLUMN  `backlog_weight` bigint(19) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重';
ALTER TABLE `issue_main`  MODIFY COLUMN  `sprint_weight` bigint(19) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重';
ALTER TABLE `issue_main`  MODIFY COLUMN  `gant_sprint_weight` bigint(19) NOT NULL DEFAULT '0' COMMENT '迭代甘特图中该事项在同级的排序权重';

ALTER TABLE `agile_board` ADD COLUMN `is_hide` tinyint(1) unsigned DEFAULT '0' COMMENT '是否隐藏';
ALTER TABLE `main_webhook` ADD COLUMN  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `main_webhook` ADD COLUMN `filter_project_json` text COLLATE utf8mb4_unicode_ci COMMENT '过滤的事件';

