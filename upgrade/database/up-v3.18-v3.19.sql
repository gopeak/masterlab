
ALTER TABLE `project_main` ADD `is_strict_status`  tinyint(2) unsigned DEFAULT '0' COMMENT '是否严格启用状态流' AFTER `is_verified`;
