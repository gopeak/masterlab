-- 升级数据库sql
-- FROM github release v1.0-beta TO github release v1.0
-- date: 2018-12-17
-- author: jugg

DROP TABLE IF EXISTS `option_configuration`;


INSERT INTO `main_setting` VALUES ('59', 'company', '公司名称', 'basic', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('60', 'company_logo', '公司logo', 'basic', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('61', 'company_linkman', '联系人', 'basic', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('62', 'company_phone', '联系电话', 'basic', '', '', 'string', 'text', null, '');


ALTER TABLE `issue_file_attachment` ADD COLUMN `tmp_issue_id` varchar(32) NOT NULL AFTER `issue_id`;
ALTER TABLE `issue_file_attachment` ADD INDEX `tmp_issue_id` (`tmp_issue_id`);


ALTER TABLE `issue_main` MODIFY COLUMN `pkey` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `issue_num` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT ''
,MODIFY COLUMN `description` text COLLATE utf8mb4_unicode_ci
,MODIFY COLUMN `environment` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT ''
,MODIFY COLUMN `milestone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `assistants` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
,ADD FULLTEXT INDEX `issue_num` (`issue_num`)
,ADD FULLTEXT INDEX `fulltext_summary` (`summary`);


ALTER TABLE `issue_status` DROP COLUMN `text_color`;

ALTER TABLE `user_setting` CHANGE COLUMN `uid` `user_id` int(11) unsigned NOT NULL;

ALTER TABLE `user_password` CHANGE COLUMN `uid` `user_id` int(11) unsigned NOT NULL;

ALTER TABLE `user_main` MODIFY COLUMN `status` tinyint(2) DEFAULT '1' COMMENT '0 审核中;1 正常; 2 禁用';


ALTER TABLE `project_main` MODIFY COLUMN `org_path` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
,MODIFY COLUMN `name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `description` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `key` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
,MODIFY COLUMN `detail` text COLLATE utf8mb4_unicode_ci
,ADD FULLTEXT INDEX `fulltext_name_description` (`name`,`description`);
ALTER TABLE `project_main` DROP COLUMN `detail`;
ALTER TABLE `project_main` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `issue_resolve2`;
CREATE TABLE `issue_resolve2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence` int(11) unsigned DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(128) NOT NULL,
  `description` text,
  `font_awesome` varchar(32) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `main_widget`;
CREATE TABLE `main_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '工具名称',
  `_key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('list','chart_line','chart_pie','chart_bar','text') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '工具类型',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态（1可用，0不可用）',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `required_param` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要参数才能获取数据',
  `description` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `parameter` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}' COMMENT '支持的参数说明',
  `order_weight` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`) USING BTREE,
  KEY `order_weight` (`order_weight`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- ----------------------------
-- Records of main_widget
-- ----------------------------
INSERT INTO `main_widget` VALUES ('1', '我参与的项目', 'my_projects', 'fetchUserHaveJoinProjects', '通用', 'my_projects.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('2', '分配给我的事项', 'assignee_my', 'fetchAssigneeIssues', '通用', 'assignee_my.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('3', '活动日志', 'activity', 'fetchActivity', '通用', 'activity.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('4', '便捷导航', 'nav', '', '通用', 'nav.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('5', '组织', 'org', 'fetchOrgs', '通用', 'org.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('6', '项目-汇总', 'project_stat', 'fetchProjectStat', '项目', 'project_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('7', '项目-解决与未解决对比图', 'project_abs', 'fetchProjectAbs', '项目', 'abs.png', 'chart_bar', '1', '0', '1', '', '\r\n[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"时间\",\"field\":\"by_time\",\"type\":\"select\",\"value\":[{\"title\":\"天\",\"value\":\"day\"},{\"title\":\"周\",\"value\":\"week\"},{\"title\":\"月\",\"value\":\"month\"}]},{\"name\":\"几日之内\",\"field\":\"within_date\",\"type\":\"text\",\"value\":\"\"}]', '0');
INSERT INTO `main_widget` VALUES ('8', '项目-优先级统计', 'project_priority_stat', 'fetchProjectPriorityStat', '项目', 'priority_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]\r\n', '0');
INSERT INTO `main_widget` VALUES ('9', '项目-状态统计', 'project_status_stat', 'fetchProjectStatusStat', '项目', 'status_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('10', '项目-开发者统计', 'project_developer_stat', 'fetchProjectDeveloperStat', '项目', 'developer_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('11', '项目-事项统计', 'project_issue_type_stat', 'fetchProjectIssueTypeStat', '项目', 'issue_type_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('12', '项目-饼状图', 'project_pie', 'fetchProjectPie', '项目', 'chart_pie.png', 'chart_pie', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]},{\"name\":\"开始时间\",\"field\":\"start_date\",\"type\":\"date\",\"value\":\"\"},{\"name\":\"结束时间\",\"field\":\"end_date\",\"type\":\"date\",\"value\":\"\"}]', '0');
INSERT INTO `main_widget` VALUES ('13', '迭代-汇总', 'sprint_stat', 'fetchSprintStat', '迭代', 'sprint_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('14', '迭代-倒计时', 'sprint_countdown', 'fetchSprintCountdown', '项目', 'countdown.png', 'text', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('15', '迭代-燃尽图', 'sprint_burndown', 'fetchSprintBurndown', '迭代', 'burndown.png', 'text', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('16', '迭代-速率图', 'sprint_speed', 'fetchSprintSpeedRate', '迭代', 'sprint_speed.png', 'text', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('17', '迭代-饼状图', 'sprint_pie', 'fetchSprintPie', '迭代', 'chart_pie.png', 'chart_pie', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('18', '迭代-解决与未解决对比图', 'sprint_abs', 'fetchSprintAbs', '迭代', 'abs.png', 'chart_bar', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('19', '迭代-优先级统计', 'sprint_priority_stat', 'fetchSprintPriorityStat', '迭代', 'priority_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('20', '迭代-状态统计', 'sprint_status_stat', 'fetchSprintStatusStat', '迭代', 'status_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('21', '迭代-开发者统计', 'sprint_developer_stat', 'fetchSprintDeveloperStat', '迭代', 'developer_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('22', '迭代-事项统计', 'sprint_issue_type_stat', 'fetchSprintIssueTypeStat', '迭代', 'issue_type_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');



DROP TABLE IF EXISTS `user_widget`;
CREATE TABLE `user_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `widget_id` int(11) NOT NULL COMMENT 'main_widget主键id',
  `order_weight` int(11) unsigned DEFAULT NULL COMMENT '工具顺序',
  `panel` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_saved_parameter` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否保存了过滤参数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


TRUNCATE TABLE `issue_resolve`;
-- ----------------------------
-- Records of issue_resolve
-- ----------------------------
INSERT INTO `issue_resolve` VALUES ('1', '1', '已解决', 'fixed', '事项已经解决', null, '#1aaa55', '0');
INSERT INTO `issue_resolve` VALUES ('2', '2', '不能解决', 'not_fix', '事项不可抗拒原因无法解决', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('3', '3', '事项重复', 'require_duplicate', '事项需要的描述需要有重现步骤', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('4', '4', '信息不完整', 'not_complete', '事项信息描述不完整', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('5', '5', '不能重现', 'not_reproduce', '事项不能重现', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('10000', '6', '结束', 'done', '事项已经解决并关闭掉', null, '#1aaa55', '0');
INSERT INTO `issue_resolve` VALUES ('10100', '8', '问题不存在', 'issue_not_exists', '事项不存在', null, 'rgba(0,0,0,0.85)', '0');
INSERT INTO `issue_resolve` VALUES ('10101', '9', '延迟处理', 'delay', '事项将推迟处理', null, 'rgba(0,0,0,0.85)', '0');



TRUNCATE TABLE `agile_board_column`;
-- ----------------------------
-- Records of agile_board_column
-- ----------------------------
INSERT INTO `agile_board_column` VALUES ('1', 'Todo', '1', '[\"open\",\"reopen\",\"todo\",\"delay\"]', '3');
INSERT INTO `agile_board_column` VALUES ('2', 'In progress', '1', '[\"in_progress\",\"in_review\"]', '2');
INSERT INTO `agile_board_column` VALUES ('3', 'Done', '1', '[\"resolved\",\"closed\",\"done\"]', '1');
INSERT INTO `agile_board_column` VALUES ('4', 'Simple', '2', '[\"1\",\"2\"]', '0');
INSERT INTO `agile_board_column` VALUES ('5', 'Normal', '2', '[\"3\"]', '0');


CREATE TABLE `project_main_extra` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT '0',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `main_setting` ADD `order_weight` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重' AFTER `module`;
ALTER TABLE `main_setting` ADD INDEX( `module`, `order_weight`);
