SET FOREIGN_KEY_CHECKS=0;

ALTER TABLE `agile_board` ADD COLUMN `range_type` enum('current_sprint','all','sprints','modules','issue_types') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '看板数据范围' AFTER `weight`;

ALTER TABLE `agile_board` ADD COLUMN `range_data` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '范围数据' AFTER `range_type`;

ALTER TABLE `agile_board` ADD COLUMN `is_system` tinyint(2) NOT NULL DEFAULT 0 AFTER `range_data`;

ALTER TABLE `agile_sprint` ADD COLUMN `target` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'sprint目标内容' AFTER `end_date`;

ALTER TABLE `agile_sprint` ADD COLUMN `inspect` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sprint 评审会议内容' AFTER `target`;

ALTER TABLE `agile_sprint` ADD COLUMN `review` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sprint 回顾会议内容' AFTER `inspect`;

ALTER TABLE `agile_sprint` MODIFY COLUMN `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1为准备中，2为已完成，3为已归档' AFTER `active`;

ALTER TABLE `field_custom_value` MODIFY COLUMN `id` int(11) UNSIGNED NOT NULL FIRST;

ALTER TABLE `field_custom_value` MODIFY COLUMN `issue_id` int(11) UNSIGNED NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `field_custom_value` MODIFY COLUMN `custom_field_id` int(11) NULL DEFAULT NULL AFTER `project_id`;

ALTER TABLE `field_custom_value` MODIFY COLUMN `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST;

ALTER TABLE `field_main` ADD COLUMN `extra_attr` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '额外的html属性' AFTER `order_weight`;



ALTER TABLE `issue_main` ADD COLUMN `duration` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `due_date`;

ALTER TABLE `issue_main` ADD COLUMN `level` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '甘特图级别' AFTER `assistants`;

ALTER TABLE `issue_main` ADD COLUMN `progress` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '完成百分比' AFTER `comment_count`;

ALTER TABLE `issue_main` ADD COLUMN `depends` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前置任务' AFTER `progress`;

ALTER TABLE `issue_main` ADD COLUMN `gant_sprint_weight` bigint(18) NOT NULL DEFAULT 0 COMMENT '迭代甘特图中该事项在同级的排序权重' AFTER `gant_proj_module_weight`;

ALTER TABLE `issue_main` ADD COLUMN `gant_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '甘特图中是否隐藏该事项' AFTER `gant_sprint_weight`;

ALTER TABLE `issue_main` ADD COLUMN `is_start_milestone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gant_hide`;

ALTER TABLE `issue_main` ADD COLUMN `is_end_milestone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `is_start_milestone`;


ALTER TABLE `issue_main` ADD FULLTEXT INDEX `issue_num`(`issue_num`);

ALTER TABLE `issue_status` ADD COLUMN `text_color` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'black' COMMENT '字体颜色' AFTER `color`;

CREATE TABLE `mind_issue_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `issue_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `source` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `layout` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shape` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_family` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT 12,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id_2`(`project_id`, `issue_id`, `source`, `group_by`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

CREATE TABLE `mind_project_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `layout` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shape` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_family` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT 12,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

CREATE TABLE `mind_second_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `source` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_by_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `layout` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shape` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_family` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT 12,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mind_unique`(`project_id`, `source`, `group_by`, `group_by_id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE,
  INDEX `source_group_by`(`project_id`, `source`, `group_by`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

CREATE TABLE `mind_sprint_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `layout` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shape` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_family` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT 12,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sprint_id`(`sprint_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

ALTER TABLE `permission_default_role_relation` DROP INDEX `default_role_id`;

ALTER TABLE `permission_default_role_relation` DROP INDEX `role_id-and-perm_id`;

ALTER TABLE `permission_default_role_relation` ADD COLUMN `role_id` int(11) UNSIGNED NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `permission_default_role_relation` DROP COLUMN `default_role_id`;

ALTER TABLE `permission_default_role_relation` ADD INDEX `default_role_id`(`role_id`) USING BTREE;

ALTER TABLE `permission_default_role_relation` ADD INDEX `role_id-and-perm_id`(`role_id`, `perm_id`) USING BTREE;

ALTER TABLE `permission_global` COMMENT = '';

ALTER TABLE `permission_global` DROP INDEX `_key`;

ALTER TABLE `permission_global` ADD COLUMN `parent_id` int(11) UNSIGNED NULL DEFAULT 0 AFTER `id`;

ALTER TABLE `permission_global` MODIFY COLUMN `id` int(11) UNSIGNED NOT NULL FIRST;

ALTER TABLE `permission_global` MODIFY COLUMN `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `description`;

ALTER TABLE `permission_global` MODIFY COLUMN `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST;

ALTER TABLE `permission_global` ADD INDEX `permission_global_key_idx`(`_key`) USING BTREE;

CREATE TABLE `permission_global_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否是默认角色',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

CREATE TABLE `permission_global_role_relation`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `perm_global_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `role_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否系统自带',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`perm_global_id`, `role_id`) USING BTREE,
  INDEX `perm_global_id`(`perm_global_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组拥有的全局权限' ROW_FORMAT = Dynamic;

CREATE TABLE `permission_global_user_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NULL DEFAULT 0,
  `role_id` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`user_id`, `role_id`) USING BTREE,
  INDEX `uid`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

CREATE TABLE `project_gantt_setting`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `source_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'project,active_sprint,module 可选',
  `source_from` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

ALTER TABLE `project_label` ADD COLUMN `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `bg_color`;

ALTER TABLE `project_main` CHARACTER SET = utf8, COLLATE = utf8_general_ci;

ALTER TABLE `project_main` DROP INDEX `fulltext_name_description`;

ALTER TABLE `project_main` DROP INDEX `fulltext_name`;

ALTER TABLE `project_main` ADD FULLTEXT INDEX `fulltext_name_description`(`name`, `description`);

CREATE TABLE `project_mind_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `setting_key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`, `setting_key`) USING BTREE,
  INDEX `project_id_2`(`project_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

ALTER TABLE `project_module` ADD COLUMN `order_weight` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重' AFTER `ctime`;

CREATE TABLE `project_permission`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_permission_key_idx`(`_key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

ALTER TABLE `project_role` ADD INDEX `p[roject_id`(`project_id`) USING BTREE;


SET FOREIGN_KEY_CHECKS=1;