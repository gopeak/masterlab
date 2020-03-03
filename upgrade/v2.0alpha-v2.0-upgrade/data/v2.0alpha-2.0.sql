-- MasterLab v2.0 alpha 升级到 v2.0 数据库结构补丁
-- by 杨文杰

SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE `issue_main` DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `issue_main` MODIFY COLUMN `pkey`  varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `issue_main` MODIFY COLUMN `issue_num`  varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `pkey`;
ALTER TABLE `issue_main` MODIFY COLUMN `summary`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' AFTER `assignee`, MODIFY COLUMN `description`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `summary`;
ALTER TABLE `issue_main` MODIFY COLUMN `environment`  varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' AFTER `description`;
ALTER TABLE `issue_main` MODIFY COLUMN `milestone`  varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `module`;
ALTER TABLE `issue_main` MODIFY COLUMN `assistants`  varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' AFTER `sprint_weight`;
ALTER TABLE `issue_main` MODIFY COLUMN `depends`  varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前置任务' AFTER `progress`;
ALTER TABLE `issue_main` MODIFY COLUMN `gant_sprint_weight`  int(11) NOT NULL DEFAULT 0 COMMENT '迭代甘特图中该事项在同级的排序权重' AFTER `depends`;
ALTER TABLE `issue_main` DROP COLUMN `gant_proj_sprint_weight`;
ALTER TABLE `issue_main` DROP COLUMN `gant_proj_module_weight`;
ALTER TABLE `main_activity` ADD COLUMN `content`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '内容' AFTER `action`;
ALTER TABLE `main_activity` MODIFY COLUMN `title`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '相关的事项标题' AFTER `obj_id`;
ALTER TABLE `project_gantt_setting` MODIFY COLUMN `source_type`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'project,active_sprint' AFTER `project_id`;
ALTER TABLE `project_gantt_setting` ADD COLUMN `is_display_backlog`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否在甘特图中显示待办事项' AFTER `source_from`;
ALTER TABLE `project_gantt_setting` ADD COLUMN `hide_issue_types`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '要隐藏的事项类型key以逗号分隔' AFTER `is_display_backlog`;
ALTER TABLE `project_main` DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `project_main` MODIFY COLUMN `org_path`  varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' AFTER `org_id`;
ALTER TABLE `project_main` MODIFY COLUMN `name`  varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `org_path`, MODIFY COLUMN `description`  varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `lead`;
ALTER TABLE `project_main` MODIFY COLUMN `url`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `project_main` MODIFY COLUMN `key`  varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `description`;
ALTER TABLE `project_main` MODIFY COLUMN `avatar`  varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `assignee_type`;
ALTER TABLE `project_main` ADD COLUMN `issue_update_time`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '事项最新更新时间' AFTER `archived`;

-- DROP TABLE `permission`;

SET FOREIGN_KEY_CHECKS=1;