-- MasterLab 1.2 升级到 2.0 数据库结构补丁
-- by 杨文杰

SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE `agile_board` ADD COLUMN `range_type`  enum('current_sprint','all','sprints','modules','issue_types') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '看板数据范围' AFTER `weight`;
ALTER TABLE `agile_board` ADD COLUMN `range_data`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '范围数据' AFTER `range_type`;
ALTER TABLE `agile_board` ADD COLUMN `is_system`  tinyint(2) NOT NULL DEFAULT 0 AFTER `range_data`;
ALTER TABLE `agile_sprint` MODIFY COLUMN `status`  tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1为准备中，2为已完成，3为已归档' AFTER `active`;
ALTER TABLE `agile_sprint` ADD COLUMN `target`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'sprint目标内容' AFTER `end_date`;
ALTER TABLE `agile_sprint` ADD COLUMN `inspect`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sprint 评审会议内容' AFTER `target`;
ALTER TABLE `agile_sprint` ADD COLUMN `review`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sprint 回顾会议内容' AFTER `inspect`;
ALTER TABLE `field_custom_value` MODIFY COLUMN `id`  int(11) UNSIGNED NOT NULL FIRST ;
ALTER TABLE `field_custom_value` MODIFY COLUMN `issue_id`  int(11) UNSIGNED NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `field_custom_value` MODIFY COLUMN `custom_field_id`  int(11) NULL DEFAULT NULL AFTER `project_id`;
ALTER TABLE `field_custom_value` MODIFY COLUMN `id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;
ALTER TABLE `field_main` ADD COLUMN `extra_attr`  varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '额外的html属性' AFTER `order_weight`;
ALTER TABLE `issue_effect_version` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
CREATE TABLE `issue_extra_worker_day` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) NOT NULL DEFAULT 0 ,
`day`  date NOT NULL ,
`name`  varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
ALTER TABLE `issue_filter` MODIFY COLUMN `filter`  mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `projectid`;
ALTER TABLE `issue_filter` ADD COLUMN `is_adv_query`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否为高级查询' AFTER `name_lower`;
CREATE TABLE `issue_holiday` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`day`  date NOT NULL ,
`name`  varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
ALTER TABLE `issue_main` DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `issue_main` DROP INDEX `fulltext_summary_description`;
ALTER TABLE `issue_main` DROP INDEX `fulltext_summary`;
ALTER TABLE `issue_main` ADD COLUMN `duration`  int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `due_date`;
ALTER TABLE `issue_main` ADD COLUMN `level`  tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '甘特图级别' AFTER `assistants`;
ALTER TABLE `issue_main` ADD COLUMN `progress`  tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '完成百分比' AFTER `comment_count`;
ALTER TABLE `issue_main` ADD COLUMN `depends`  varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前置任务' AFTER `progress`;
ALTER TABLE `issue_main` ADD COLUMN `gant_sprint_weight`  int(11) NOT NULL DEFAULT 0 COMMENT '迭代甘特图中该事项在同级的排序权重' AFTER `depends`;
ALTER TABLE `issue_main` ADD COLUMN `gant_hide`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '甘特图中是否隐藏该事项' AFTER `gant_sprint_weight`;
ALTER TABLE `issue_main` ADD COLUMN `is_start_milestone`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `gant_hide`;
ALTER TABLE `issue_main` ADD COLUMN `is_end_milestone`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `is_start_milestone`;
DROP INDEX `summary` ON `issue_main`;
CREATE INDEX `summary` ON `issue_main`(`summary`) USING BTREE ;
CREATE INDEX `status` ON `issue_main`(`status`) USING BTREE ;
CREATE INDEX `gant_sprint_weight` ON `issue_main`(`gant_sprint_weight`) USING BTREE ;
ALTER TABLE `issue_status` ADD COLUMN `text_color`  varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'black' COMMENT '字体颜色' AFTER `color`;
ALTER TABLE `main_activity` ADD COLUMN `content`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '内容' AFTER `action`;
ALTER TABLE `main_activity` MODIFY COLUMN `title`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '相关的事项标题' AFTER `obj_id`;
ALTER TABLE `main_notify_scheme` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `main_notify_scheme` MODIFY COLUMN `name`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `id`;
ALTER TABLE `main_notify_scheme_data` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `main_notify_scheme_data` MODIFY COLUMN `name`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `scheme_id`;
ALTER TABLE `main_notify_scheme_data` MODIFY COLUMN `flag`  varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `main_notify_scheme_data` MODIFY COLUMN `user`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人' AFTER `flag`;
ALTER TABLE `main_widget` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `main_widget` MODIFY COLUMN `name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '工具名称' AFTER `id`;
ALTER TABLE `main_widget` MODIFY COLUMN `_key`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`;
ALTER TABLE `main_widget` MODIFY COLUMN `method`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `_key`;
ALTER TABLE `main_widget` MODIFY COLUMN `module`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `method`;
ALTER TABLE `main_widget` MODIFY COLUMN `pic`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `module`;
ALTER TABLE `main_widget` MODIFY COLUMN `type`  enum('list','chart_line','chart_pie','chart_bar','text') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '工具类型' AFTER `pic`;
ALTER TABLE `main_widget` MODIFY COLUMN `description`  varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '描述' AFTER `required_param`;
ALTER TABLE `main_widget` MODIFY COLUMN `parameter`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{}' COMMENT '支持的参数说明' AFTER `description`;
CREATE TABLE `mind_issue_attribute` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`issue_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`source`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`group_by`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`layout`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`shape`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`color`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`icon`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_family`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_size`  tinyint(2) NOT NULL DEFAULT 1 ,
`font_bold`  tinyint(1) NOT NULL DEFAULT 0 ,
`font_italic`  tinyint(1) NOT NULL DEFAULT 0 ,
`bg_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`text_color`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`side`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `project_id_2` (`project_id`, `issue_id`, `source`, `group_by`) USING BTREE ,
INDEX `project_id` (`project_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
CREATE TABLE `mind_project_attribute` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`layout`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`shape`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`color`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`icon`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_family`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_size`  tinyint(2) NOT NULL DEFAULT 1 ,
`font_bold`  tinyint(1) NOT NULL DEFAULT 0 ,
`font_italic`  tinyint(1) NOT NULL DEFAULT 0 ,
`bg_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`text_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`side`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `project_id` (`project_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
CREATE TABLE `mind_second_attribute` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`source`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`group_by`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`group_by_id`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`layout`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`shape`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`color`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`icon`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_family`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_size`  tinyint(2) NOT NULL DEFAULT 1 ,
`font_bold`  tinyint(1) NOT NULL DEFAULT 0 ,
`font_italic`  tinyint(1) NOT NULL DEFAULT 0 ,
`bg_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`text_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`side`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `mind_unique` (`project_id`, `source`, `group_by`, `group_by_id`) USING BTREE ,
INDEX `project_id` (`project_id`) USING BTREE ,
INDEX `source_group_by` (`project_id`, `source`, `group_by`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
CREATE TABLE `mind_sprint_attribute` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`sprint_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 ,
`layout`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`shape`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`color`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`icon`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_family`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`font_size`  tinyint(2) NOT NULL DEFAULT 1 ,
`font_bold`  tinyint(1) NOT NULL DEFAULT 0 ,
`font_italic`  tinyint(1) NOT NULL DEFAULT 0 ,
`bg_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`text_color`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`side`  varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `sprint_id` (`sprint_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
-- 下面这一句有变动（原代码为删除default_role_id字段，新增role_id字段，会丢失数据）
ALTER TABLE `permission_default_role_relation` CHANGE COLUMN `default_role_id` `role_id`  int(11) UNSIGNED NULL DEFAULT NULL AFTER `id`;

DROP INDEX `default_role_id` ON `permission_default_role_relation`;
CREATE INDEX `default_role_id` ON `permission_default_role_relation`(`role_id`) USING BTREE ;
DROP INDEX `role_id-and-perm_id` ON `permission_default_role_relation`;
CREATE INDEX `role_id-and-perm_id` ON `permission_default_role_relation`(`role_id`, `perm_id`) USING BTREE ;
ALTER TABLE `permission_global` DROP INDEX `_key`;
ALTER TABLE `permission_global` ADD COLUMN `parent_id`  int(11) UNSIGNED NULL DEFAULT 0 AFTER `id`;
ALTER TABLE `permission_global` MODIFY COLUMN `name`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `parent_id`;
ALTER TABLE `permission_global` MODIFY COLUMN `description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `name`;
CREATE INDEX `permission_global_key_idx` ON `permission_global`(`_key`) USING BTREE ;
ALTER TABLE `permission_global` MODIFY COLUMN `id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;
CREATE TABLE `permission_global_role` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`is_system`  tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否是默认角色' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
CREATE TABLE `permission_global_role_relation` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`perm_global_id`  int(11) UNSIGNED NULL DEFAULT NULL ,
`role_id`  int(11) UNSIGNED NULL DEFAULT NULL ,
`is_system`  tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否系统自带' ,
PRIMARY KEY (`id`),
UNIQUE INDEX `unique` (`perm_global_id`, `role_id`) USING BTREE ,
INDEX `perm_global_id` (`perm_global_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
CREATE TABLE `permission_global_user_role` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`user_id`  int(11) UNSIGNED NULL DEFAULT 0 ,
`role_id`  int(11) UNSIGNED NULL DEFAULT 0 ,
PRIMARY KEY (`id`),
UNIQUE INDEX `unique` (`user_id`, `role_id`) USING BTREE ,
INDEX `uid` (`user_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
CREATE TABLE `project_gantt_setting` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) UNSIGNED NULL DEFAULT NULL ,
`source_type`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'project,active_sprint' ,
`source_from`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`is_display_backlog`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否在甘特图中显示待办事项' ,
`hide_issue_types`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '要隐藏的事项类型key以逗号分隔' ,
PRIMARY KEY (`id`),
UNIQUE INDEX `project_id` (`project_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
ALTER TABLE `project_label` ADD COLUMN `description`  varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `bg_color`;
ALTER TABLE `project_main` DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `project_main` DROP INDEX `fulltext_name`;
ALTER TABLE `project_main` DROP INDEX `fulltext_name_description`;
ALTER TABLE `project_main` ADD COLUMN `archived`  enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '已归档' AFTER `closed_count`;
ALTER TABLE `project_main` ADD COLUMN `issue_update_time`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '事项最新更新时间' AFTER `archived`;
ALTER TABLE `project_main_extra` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `project_main_extra` MODIFY COLUMN `detail`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `project_id`;
CREATE TABLE `project_mind_setting` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) NOT NULL ,
`setting_key`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`setting_value`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `project_id` (`project_id`, `setting_key`) USING BTREE ,
INDEX `project_id_2` (`project_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
ROW_FORMAT=Dynamic
;
ALTER TABLE `project_module` ADD COLUMN `order_weight`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重' AFTER `ctime`;
-- 删除创建表project_permission的语句

-- 修改下面这一句，去掉一个方括号
CREATE INDEX `project_id` ON `project_role`(`project_id`) USING BTREE ;
ALTER TABLE `service_config` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `service_config` MODIFY COLUMN `clazz`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `delaytime`;
ALTER TABLE `service_config` MODIFY COLUMN `servicename`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `clazz`;
ALTER TABLE `service_config` MODIFY COLUMN `cron_expression`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `servicename`;
ALTER TABLE `user_issue_display_fields` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `user_issue_display_fields` MODIFY COLUMN `fields`  varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `project_id`;
ALTER TABLE `user_posted_flag` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `user_posted_flag` MODIFY COLUMN `ip`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `_date`;
ALTER TABLE `user_widget` DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;
ALTER TABLE `user_widget` MODIFY COLUMN `panel`  varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_weight`;
ALTER TABLE `user_widget` MODIFY COLUMN `parameter`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `panel`;

-- 下面这一句注释掉了，不删除表，改名为project_permission
-- DROP TABLE `permission`;

-- 下面这一句注释掉了，不要删除表
-- DROP TABLE `permission_global_relation`;

-- 迁移全局Administrators用户
INSERT INTO `permission_global_user_role` (`user_id`, `role_id`) SELECT `uid`, 1 FROM `user_group` WHERE `group_id` = 1 AND `uid` > 0 AND `uid` NOT IN (SELECT `user_id` FROM `permission_global_user_role` WHERE `role_id` = 1);

-- permission 表改名为 project_permission
ALTER TABLE `permission` RENAME `project_permission`;

-- project_permission 表增加"修改事项状态"，"修改事项解决结果"两行数据
INSERT INTO `project_permission` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('10016', '0', '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS');
INSERT INTO `project_permission` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('10017', '0', '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE');

-- 把 permission_default_role_relation 表的 QA（10003）角色增加"修改事项状态（10016）"，"修改事项解决结果（10017）"两条权限项
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10003', '10016');
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10003', '10017');

-- 把 permission_default_role_relation 表的 Developers（10001）角色增加"修改事项状态（10016）"一条权限项
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10001', '10016');

-- 把 permission_default_role_relation 表的 Administrators（10002）角色增加"修改事项状态（10016）"，"修改事项解决结果（10017）"两条权限项
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10002', '10016');
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10002', '10017');

-- 把 permission_default_role_relation 表的 PO（10006）角色增加"修改事项状态（10016）"，"修改事项解决结果（10017）"两条权限项
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10006', '10016');
INSERT INTO `permission_default_role_relation` (`role_id`, `perm_id`) VALUES ('10006', '10017');

-- 以下四条用PHP执行
-- 把 project_role_relation 表中的 QA（10003）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
-- 把 project_role_relation 表中的 Developers（10001）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
-- 把 project_role_relation 表中的 Administrators（10002）角色增加"修改事项状态"，"修改事项解决结果"两条权限项
-- 把 project_role_relation 表中的 PO（10006）角色增加"修改事项状态"，"修改事项解决结果"两条权限项

DELETE FROM `permission_global` WHERE (`id`='10000');

INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('1', '0', '系统设置', '可以对整个系统进行基本，界面，安全，邮件设置，同时还可以查看操作日志', 'MANAGER_SYSTEM_SETTING');
INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('2', '0', '管理用户', '', 'MANAGER_USER');
INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('3', '0', '事项管理', '', 'MANAGER_ISSUE');
INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('4', '0', '项目管理', '可以对全部项目进行管理，包括创建新项目。', 'MANAGER_PROJECT');
INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES ('5', '0', '组织管理', '', 'MANAGER_ORG');

INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES ('1', '超级管理员', NULL, '1');
INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES ('2', '系统设置管理员', NULL, '0');
INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES ('3', '项目管理员', NULL, '0');
INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES ('4', '用户管理员', NULL, '0');
INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES ('5', '事项设置管理员', NULL, '0');
INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES ('6', '组织管理员', NULL, '0');

INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES ('2', '1', '1', '1');
INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES ('8', '2', '1', '1');
INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES ('9', '3', '1', '1');
INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES ('10', '4', '1', '1');
INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES ('11', '5', '1', '1');

TRUNCATE `agile_board`;

INSERT INTO `agile_board` (`id`, `name`, `project_id`, `type`, `is_filter_backlog`, `is_filter_closed`, `weight`, `range_type`, `range_data`, `is_system`) VALUES ('1', '进行中的迭代', '0', 'status', '0', '1', '99999', 'current_sprint', '', '1');
INSERT INTO `agile_board` (`id`, `name`, `project_id`, `type`, `is_filter_backlog`, `is_filter_closed`, `weight`, `range_type`, `range_data`, `is_system`) VALUES ('2', '整个项目', '0', 'status', '0', '1', '99998', 'all', '', '1');
INSERT INTO `agile_board` (`id`, `name`, `project_id`, `type`, `is_filter_backlog`, `is_filter_closed`, `weight`, `range_type`, `range_data`, `is_system`) VALUES ('18', 'ddcccssss', '1', NULL, '1', '1', '0', 'all', '[]', '0');

TRUNCATE `agile_board_column`;
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('1', '准 备', '1', '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', '3');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('2', '进行中', '1', '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', '2');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('3', '已完成', '1', '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', '1');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('4', '准备中', '2', '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', '0');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('5', '进行中', '2', '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', '0');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('6', '已完成', '2', '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', '0');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('60', '准备中asdasd', '18', '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":null,\"label\":null,\"assignee\":null}', '3');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('61', '进行中', '18', '{\"status\":[\"in_progress\"],\"resolve\":null,\"label\":null,\"assignee\":null}', '2');
INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES ('62', '已解决', '18', '{\"status\":[\"closed\",\"done\"],\"resolve\":null,\"label\":null,\"assignee\":null}', '1');


SET FOREIGN_KEY_CHECKS=1;