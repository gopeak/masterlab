/*
Navicat MySQL Data Transfer

Date: 2019-03-24 02:19:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `agile_board`
-- ----------------------------
DROP TABLE IF EXISTS `agile_board`;
CREATE TABLE `agile_board` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `type` enum('status','issue_type','label','module','resolve','priority','assignee') DEFAULT NULL,
  `is_filter_backlog` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_filter_closed` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `weight` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `weight` (`weight`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_board
-- ----------------------------
INSERT INTO `agile_board` VALUES ('1', 'Active Sprint', '0', null, '1', '1', '99999');
INSERT INTO `agile_board` VALUES ('2', 'LabelS', '10003', 'label', '1', '1', '0');

-- ----------------------------
-- Table structure for `agile_board_column`
-- ----------------------------
DROP TABLE IF EXISTS `agile_board_column`;
CREATE TABLE `agile_board_column` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `board_id` int(11) unsigned NOT NULL,
  `data` varchar(1000) NOT NULL,
  `weight` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `board_id` (`board_id`),
  KEY `id_and_weight` (`id`,`weight`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_board_column
-- ----------------------------
INSERT INTO `agile_board_column` VALUES ('1', 'Todo', '1', '[\"open\",\"reopen\",\"todo\",\"delay\"]', '3');
INSERT INTO `agile_board_column` VALUES ('2', 'In progress', '1', '[\"in_progress\",\"in_review\"]', '2');
INSERT INTO `agile_board_column` VALUES ('3', 'Done', '1', '[\"resolved\",\"closed\",\"done\"]', '1');
INSERT INTO `agile_board_column` VALUES ('4', 'Simple', '2', '[\"1\",\"2\"]', '0');
INSERT INTO `agile_board_column` VALUES ('5', 'Normal', '2', '[\"3\"]', '0');

-- ----------------------------
-- Table structure for `agile_sprint`
-- ----------------------------
DROP TABLE IF EXISTS `agile_sprint`;
CREATE TABLE `agile_sprint` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `order_weight` int(10) unsigned NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_sprint
-- ----------------------------

-- ----------------------------
-- Table structure for `agile_sprint_issue_report`
-- ----------------------------
DROP TABLE IF EXISTS `agile_sprint_issue_report`;
CREATE TABLE `agile_sprint_issue_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) unsigned DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `done_count` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `no_done_count` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `done_count_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `no_done_count_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) unsigned DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) unsigned DEFAULT '0' COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`),
  KEY `sprint_id` (`sprint_id`),
  KEY `sprintIdAndDate` (`sprint_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_sprint_issue_report
-- ----------------------------

-- ----------------------------
-- Table structure for `field_custom_value`
-- ----------------------------
DROP TABLE IF EXISTS `field_custom_value`;
CREATE TABLE `field_custom_value` (
  `id` decimal(18,0) NOT NULL,
  `issue_id` decimal(18,0) DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT NULL,
  `custom_field_id` decimal(18,0) DEFAULT NULL,
  `parent_key` varchar(255) DEFAULT NULL,
  `string_value` varchar(255) DEFAULT NULL,
  `number_value` decimal(18,6) DEFAULT NULL,
  `text_value` longtext,
  `date_value` datetime DEFAULT NULL,
  `valuet_ype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cfvalue_issue` (`issue_id`,`custom_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of field_custom_value
-- ----------------------------

-- ----------------------------
-- Table structure for `field_layout_default`
-- ----------------------------
DROP TABLE IF EXISTS `field_layout_default`;
CREATE TABLE `field_layout_default` (
  `id` int(11) unsigned NOT NULL,
  `issue_type` int(11) unsigned DEFAULT NULL,
  `issue_ui_type` tinyint(1) unsigned DEFAULT '1',
  `field_id` int(11) unsigned DEFAULT '0',
  `verticalposition` decimal(18,0) DEFAULT NULL,
  `ishidden` varchar(60) DEFAULT NULL,
  `isrequired` varchar(60) DEFAULT NULL,
  `sequence` int(11) unsigned DEFAULT NULL,
  `tab` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of field_layout_default
-- ----------------------------
INSERT INTO `field_layout_default` VALUES ('11192', null, null, '11192', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11193', null, null, '11193', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11194', null, null, '11194', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11195', null, null, '11195', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11196', null, null, '11196', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11197', null, null, '11197', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11198', null, null, '11198', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11199', null, null, '11199', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11200', null, null, '11200', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11201', null, null, '11201', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11202', null, null, '11202', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11203', null, null, '11203', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11204', null, null, '11204', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11205', null, null, '11205', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11206', null, null, '11206', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11207', null, null, '11207', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11208', null, null, '11208', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11209', null, null, '11209', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11210', null, null, '11210', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11211', null, null, '11211', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11212', null, null, '11212', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11213', null, null, '11213', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11214', null, null, '11214', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11215', null, null, '11215', null, 'false', 'true', null, null);
INSERT INTO `field_layout_default` VALUES ('11216', null, null, '11216', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11217', null, null, '11217', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11218', null, null, '11218', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11219', null, null, '11219', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11220', null, null, '11220', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11221', null, null, '11221', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11222', null, null, '11222', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11223', null, null, '11223', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11224', null, null, '11224', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11225', null, null, '11225', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11226', null, null, '11226', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11227', null, null, '11227', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11228', null, null, '11228', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11229', null, null, '11229', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11230', null, null, '11230', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11231', null, null, '11231', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11232', null, null, '11232', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11233', null, null, '11233', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11234', null, null, '11234', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11235', null, null, '11235', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11236', null, null, '11236', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11237', null, null, '11237', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11238', null, null, '11238', null, 'false', 'false', null, null);
INSERT INTO `field_layout_default` VALUES ('11239', null, null, '11239', null, 'false', 'false', null, null);

-- ----------------------------
-- Table structure for `field_layout_project_custom`
-- ----------------------------
DROP TABLE IF EXISTS `field_layout_project_custom`;
CREATE TABLE `field_layout_project_custom` (
  `id` int(11) unsigned NOT NULL,
  `project_id` int(11) unsigned DEFAULT NULL,
  `issue_type` int(11) unsigned DEFAULT NULL,
  `issue_ui_type` tinyint(2) unsigned DEFAULT NULL,
  `field_id` int(11) unsigned DEFAULT '0',
  `verticalposition` decimal(18,0) DEFAULT NULL,
  `ishidden` varchar(60) DEFAULT NULL,
  `isrequired` varchar(60) DEFAULT NULL,
  `sequence` int(11) unsigned DEFAULT NULL,
  `tab` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of field_layout_project_custom
-- ----------------------------

-- ----------------------------
-- Table structure for `field_main`
-- ----------------------------
DROP TABLE IF EXISTS `field_main`;
CREATE TABLE `field_main` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(512) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) unsigned DEFAULT '0',
  `options` varchar(5000) DEFAULT '' COMMENT '{}',
  `order_weight` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_fli_fieldidentifier` (`name`),
  KEY `order_weight` (`order_weight`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of field_main
-- ----------------------------
INSERT INTO `field_main` VALUES ('1', 'summary', '标 题', null, 'TEXT', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('2', 'priority', '优先级', null, 'PRIORITY', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('3', 'fix_version', '解决版本', null, 'VERSION', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('4', 'assignee', '经办人', null, 'USER', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('5', 'reporter', '报告人', null, 'USER', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('6', 'description', '描 述', null, 'MARKDOWN', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('7', 'module', '模 块', null, 'MODULE', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('8', 'labels', '标 签', null, 'LABELS', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('9', 'environment', '运行环境', '如操作系统，软件平台，硬件环境', 'TEXT', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('10', 'resolve', '解决结果', '主要是面向测试工作着和产品经理', 'RESOLUTION', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('11', 'attachment', '附 件', null, 'UPLOAD_FILE', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('12', 'start_date', '开始日期', null, 'DATE', null, '1', '', '0');
INSERT INTO `field_main` VALUES ('13', 'due_date', '结束日期', null, 'DATE', null, '1', null, '0');
INSERT INTO `field_main` VALUES ('14', 'milestone', '里程碑', null, 'MILESTONE', null, '1', '', '0');
INSERT INTO `field_main` VALUES ('15', 'sprint', '迭 代', null, 'SPRINT', null, '1', '', '0');
INSERT INTO `field_main` VALUES ('17', 'parent_issue', '父事项', null, 'ISSUES', null, '1', '', '0');
INSERT INTO `field_main` VALUES ('18', 'effect_version', '影响版本', null, 'VERSION', null, '1', '', '0');
INSERT INTO `field_main` VALUES ('19', 'status', '状 态', null, 'STATUS', '1', '1', '', '950');
INSERT INTO `field_main` VALUES ('20', 'assistants', '协助人', '协助人', 'USER_MULTI', null, '1', '', '900');
INSERT INTO `field_main` VALUES ('21', 'weight', '权 重', '待办事项中的权重值', 'TEXT', '0', '1', '', '0');

-- ----------------------------
-- Table structure for `field_type`
-- ----------------------------
DROP TABLE IF EXISTS `field_type`;
CREATE TABLE `field_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of field_type
-- ----------------------------
INSERT INTO `field_type` VALUES ('1', 'TEXT', null, 'TEXT');
INSERT INTO `field_type` VALUES ('2', 'TEXT_MULTI_LINE', null, 'TEXT_MULTI_LINE');
INSERT INTO `field_type` VALUES ('3', 'TEXTAREA', null, 'TEXTAREA');
INSERT INTO `field_type` VALUES ('4', 'RADIO', null, 'RADIO');
INSERT INTO `field_type` VALUES ('5', 'CHECKBOX', null, 'CHECKBOX');
INSERT INTO `field_type` VALUES ('6', 'SELECT', null, 'SELECT');
INSERT INTO `field_type` VALUES ('7', 'SELECT_MULTI', null, 'SELECT_MULTI');
INSERT INTO `field_type` VALUES ('8', 'DATE', null, 'DATE');
INSERT INTO `field_type` VALUES ('9', 'LABEL', null, 'LABELS');
INSERT INTO `field_type` VALUES ('10', 'UPLOAD_IMG', null, 'UPLOAD_IMG');
INSERT INTO `field_type` VALUES ('11', 'UPLOAD_FILE', null, 'UPLOAD_FILE');
INSERT INTO `field_type` VALUES ('12', 'VERSION', null, 'VERSION');
INSERT INTO `field_type` VALUES ('16', 'USER', null, 'USER');
INSERT INTO `field_type` VALUES ('18', 'GROUP', null, 'GROUP');
INSERT INTO `field_type` VALUES ('19', 'GROUP_MULTI', null, 'GROUP_MULTI');
INSERT INTO `field_type` VALUES ('20', 'MODULE', null, 'MODULE');
INSERT INTO `field_type` VALUES ('21', 'Milestone', null, 'MILESTONE');
INSERT INTO `field_type` VALUES ('22', 'Sprint', null, 'SPRINT');
INSERT INTO `field_type` VALUES ('25', 'Reslution', null, 'RESOLUTION');
INSERT INTO `field_type` VALUES ('26', 'Issues', null, 'ISSUES');
INSERT INTO `field_type` VALUES ('27', 'Markdown', null, 'MARKDOWN');
INSERT INTO `field_type` VALUES ('28', 'USER_MULTI', null, 'USER_MULTI');

-- ----------------------------
-- Table structure for `hornet_cache_key`
-- ----------------------------
DROP TABLE IF EXISTS `hornet_cache_key`;
CREATE TABLE `hornet_cache_key` (
  `key` varchar(100) NOT NULL,
  `module` varchar(64) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `expire` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `module_key` (`key`,`module`) USING BTREE,
  KEY `module` (`module`),
  KEY `expire` (`expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hornet_cache_key
-- ----------------------------

-- ----------------------------
-- Table structure for `hornet_user`
-- ----------------------------
DROP TABLE IF EXISTS `hornet_user`;
CREATE TABLE `hornet_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态:1正常,2禁用',
  `reg_time` int(11) unsigned NOT NULL DEFAULT '0',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0',
  `company_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_unique` (`phone`) USING BTREE,
  KEY `phone` (`phone`,`password`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of hornet_user
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_assistant`
-- ----------------------------
DROP TABLE IF EXISTS `issue_assistant`;
CREATE TABLE `issue_assistant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `join_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `issue_id` (`issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_assistant
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_description_template`
-- ----------------------------
DROP TABLE IF EXISTS `issue_description_template`;
CREATE TABLE `issue_description_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `created` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='新增事项时描述的模板';

-- ----------------------------
-- Records of issue_description_template
-- ----------------------------
INSERT INTO `issue_description_template` VALUES ('1', 'bug', '\r\n\r\n\r\n### 重现步骤\r\n1. 步骤1\r\n\r\n2. 步骤2\r\n\r\n3. 步骤3\r\n\r\n### 期望结果 \r\n\r\n\r\n### 实际结果\r\n\r\n', '0', '0');
INSERT INTO `issue_description_template` VALUES ('2', '新功能', '\r\n\r\n### 功能点：\r\n\r\n### 规则\r\n\r\n### 影响\r\n\r\n', '0', '0');

-- ----------------------------
-- Table structure for `issue_effect_version`
-- ----------------------------
DROP TABLE IF EXISTS `issue_effect_version`;
CREATE TABLE `issue_effect_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `version_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of issue_effect_version
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_field_layout_project`
-- ----------------------------
DROP TABLE IF EXISTS `issue_field_layout_project`;
CREATE TABLE `issue_field_layout_project` (
  `id` decimal(18,0) NOT NULL,
  `fieldlayout` decimal(18,0) DEFAULT NULL,
  `fieldidentifier` varchar(255) DEFAULT NULL,
  `description` text,
  `verticalposition` decimal(18,0) DEFAULT NULL,
  `ishidden` varchar(60) DEFAULT NULL,
  `isrequired` varchar(60) DEFAULT NULL,
  `renderertype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_fli_fieldidentifier` (`fieldidentifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_field_layout_project
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_file_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `issue_file_attachment`;
CREATE TABLE `issue_file_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `issue_id` int(11) DEFAULT '0',
  `tmp_issue_id` varchar(32) NOT NULL,
  `mime_type` varchar(64) DEFAULT '',
  `origin_name` varchar(128) NOT NULL DEFAULT '',
  `file_name` varchar(255) DEFAULT '',
  `created` int(11) DEFAULT '0',
  `file_size` int(11) DEFAULT '0',
  `author` int(11) DEFAULT '0',
  `file_ext` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `attach_issue` (`issue_id`),
  KEY `uuid` (`uuid`),
  KEY `tmp_issue_id` (`tmp_issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_file_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_filter`
-- ----------------------------
DROP TABLE IF EXISTS `issue_filter`;
CREATE TABLE `issue_filter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `share_obj` varchar(255) DEFAULT NULL,
  `share_scope` varchar(20) DEFAULT NULL COMMENT 'all,group,uid,project,origin',
  `projectid` decimal(18,0) DEFAULT NULL,
  `filter` longtext,
  `fav_count` decimal(18,0) DEFAULT NULL,
  `name_lower` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sr_author` (`author`),
  KEY `searchrequest_filternameLower` (`name_lower`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_filter
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_fix_version`
-- ----------------------------
DROP TABLE IF EXISTS `issue_fix_version`;
CREATE TABLE `issue_fix_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `version_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_fix_version
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_follow`
-- ----------------------------
DROP TABLE IF EXISTS `issue_follow`;
CREATE TABLE `issue_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `issue_id` (`issue_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_follow
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_label`
-- ----------------------------
DROP TABLE IF EXISTS `issue_label`;
CREATE TABLE `issue_label` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `color` varchar(20) NOT NULL,
  `bg_color` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_label
-- ----------------------------
INSERT INTO `issue_label` VALUES ('1', '0', '错 误', '#FFFFFF', '#FF0000');
INSERT INTO `issue_label` VALUES ('2', '0', '成 功', '#FFFFFF', '#69D100');
INSERT INTO `issue_label` VALUES ('3', '0', '警 告', '#FFFFFF', '#F0AD4E');

-- ----------------------------
-- Table structure for `issue_label_data`
-- ----------------------------
DROP TABLE IF EXISTS `issue_label_data`;
CREATE TABLE `issue_label_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `label_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_label_data
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_main`
-- ----------------------------
DROP TABLE IF EXISTS `issue_main`;
CREATE TABLE `issue_main` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pkey` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_num` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) DEFAULT '0',
  `issue_type` int(11) unsigned NOT NULL DEFAULT '0',
  `creator` int(11) unsigned DEFAULT '0',
  `modifier` int(11) unsigned NOT NULL DEFAULT '0',
  `reporter` int(11) DEFAULT '0',
  `assignee` int(11) DEFAULT '0',
  `summary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `environment` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `priority` int(11) DEFAULT '0',
  `resolve` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created` int(11) DEFAULT '0',
  `updated` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `resolve_date` date DEFAULT NULL,
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `master_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) unsigned DEFAULT '0' COMMENT '是否拥有子任务',
  PRIMARY KEY (`id`),
  KEY `issue_created` (`created`),
  KEY `issue_updated` (`updated`),
  KEY `issue_duedate` (`due_date`),
  KEY `issue_assignee` (`assignee`),
  KEY `issue_reporter` (`reporter`),
  KEY `pkey` (`pkey`),
  KEY `summary` (`summary`(191)),
  KEY `backlog_weight` (`backlog_weight`),
  KEY `sprint_weight` (`sprint_weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of issue_main
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_moved_issue_key`
-- ----------------------------
DROP TABLE IF EXISTS `issue_moved_issue_key`;
CREATE TABLE `issue_moved_issue_key` (
  `id` decimal(18,0) NOT NULL,
  `old_issue_key` varchar(255) DEFAULT NULL,
  `issue_id` decimal(18,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_old_issue_key` (`old_issue_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_moved_issue_key
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_priority`
-- ----------------------------
DROP TABLE IF EXISTS `issue_priority`;
CREATE TABLE `issue_priority` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence` int(11) unsigned DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(128) NOT NULL,
  `description` text,
  `iconurl` varchar(255) DEFAULT NULL,
  `status_color` varchar(60) DEFAULT NULL,
  `font_awesome` varchar(40) DEFAULT NULL,
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_priority
-- ----------------------------
INSERT INTO `issue_priority` VALUES ('1', '1', '紧 急', 'very_import', '阻塞开发或测试的工作进度，或影响系统无法运行的错误', '/images/icons/priorities/blocker.png', 'red', null, '1');
INSERT INTO `issue_priority` VALUES ('2', '2', '重 要', 'import', '系统崩溃，丢失数据或内存溢出等严重错误、或者必需完成的任务', '/images/icons/priorities/critical.png', '#cc0000', null, '1');
INSERT INTO `issue_priority` VALUES ('3', '3', '高', 'high', '主要的功能无效或流程异常', '/images/icons/priorities/major.png', '#ff0000', null, '1');
INSERT INTO `issue_priority` VALUES ('4', '4', '中', 'normal', '功能部分无效或对现有系统的改进', '/images/icons/priorities/minor.png', '#006600', null, '1');
INSERT INTO `issue_priority` VALUES ('5', '5', '低', 'low', '不影响功能和流程的问题', '/images/icons/priorities/trivial.png', '#003300', null, '1');

-- ----------------------------
-- Table structure for `issue_recycle`
-- ----------------------------
DROP TABLE IF EXISTS `issue_recycle`;
CREATE TABLE `issue_recycle` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `delete_user_id` int(11) unsigned NOT NULL,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `pkey` varchar(32) DEFAULT NULL,
  `issue_num` decimal(18,0) DEFAULT NULL,
  `project_id` int(11) DEFAULT '0',
  `issue_type` int(11) unsigned NOT NULL DEFAULT '0',
  `creator` int(11) unsigned DEFAULT '0',
  `modifier` int(11) unsigned NOT NULL DEFAULT '0',
  `reporter` int(11) DEFAULT '0',
  `assignee` int(11) DEFAULT '0',
  `summary` varchar(255) DEFAULT '',
  `description` text,
  `environment` varchar(128) DEFAULT '',
  `priority` int(11) DEFAULT '0',
  `resolve` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created` int(11) DEFAULT '0',
  `updated` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `resolve_date` datetime DEFAULT NULL,
  `workflow_id` int(11) DEFAULT '0',
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `assistants` varchar(256) NOT NULL DEFAULT '',
  `master_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `data` text,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issue_assignee` (`assignee`),
  KEY `summary` (`summary`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_recycle
-- ----------------------------

-- ----------------------------
-- Table structure for `issue_resolve`
-- ----------------------------
DROP TABLE IF EXISTS `issue_resolve`;
CREATE TABLE `issue_resolve` (
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
) ENGINE=InnoDB AUTO_INCREMENT=10115 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_resolve
-- ----------------------------
INSERT INTO `issue_resolve` VALUES ('1', '1', '已解决', 'fixed', '事项已经解决', null, '#1aaa55', '1');
INSERT INTO `issue_resolve` VALUES ('2', '2', '不能解决', 'not_fix', '事项不可抗拒原因无法解决', null, '#db3b21', '1');
INSERT INTO `issue_resolve` VALUES ('3', '3', '事项重复', 'require_duplicate', '事项需要的描述需要有重现步骤', null, '#db3b21', '1');
INSERT INTO `issue_resolve` VALUES ('4', '4', '信息不完整', 'not_complete', '事项信息描述不完整', null, '#db3b21', '1');
INSERT INTO `issue_resolve` VALUES ('5', '5', '不能重现', 'not_reproduce', '事项不能重现', null, '#db3b21', '1');
INSERT INTO `issue_resolve` VALUES ('10000', '6', '结束', 'done', '事项已经解决并关闭掉', null, '#1aaa55', '1');
INSERT INTO `issue_resolve` VALUES ('10100', '8', '问题不存在', 'issue_not_exists', '事项不存在', null, 'rgba(0,0,0,0.85)', '1');
INSERT INTO `issue_resolve` VALUES ('10101', '9', '延迟处理', 'delay', '事项将推迟处理', null, 'rgba(0,0,0,0.85)', '1');

-- ----------------------------
-- Table structure for `issue_status`
-- ----------------------------
DROP TABLE IF EXISTS `issue_status`;
CREATE TABLE `issue_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence` int(11) unsigned DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(20) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `font_awesome` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) unsigned DEFAULT '0',
  `color` varchar(20) DEFAULT NULL COMMENT 'Default Primary Success Info Warning Danger可选',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10114 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_status
-- ----------------------------
INSERT INTO `issue_status` VALUES ('1', '1', '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', '1', 'info');
INSERT INTO `issue_status` VALUES ('3', '3', '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', '1', 'primary');
INSERT INTO `issue_status` VALUES ('4', '4', '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', '1', 'warning');
INSERT INTO `issue_status` VALUES ('5', '5', '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', '1', 'success');
INSERT INTO `issue_status` VALUES ('6', '6', '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', '1', 'success');
INSERT INTO `issue_status` VALUES ('10001', '0', '完成', 'done', null, null, '1', null);
INSERT INTO `issue_status` VALUES ('10002', '9', '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', '1', 'info');
INSERT INTO `issue_status` VALUES ('10100', '10', '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', '1', 'info');

-- ----------------------------
-- Table structure for `issue_type`
-- ----------------------------
DROP TABLE IF EXISTS `issue_type`;
CREATE TABLE `issue_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence` decimal(18,0) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(64) NOT NULL,
  `catalog` enum('Custom','Kanban','Scrum','Standard') DEFAULT 'Standard' COMMENT '类型',
  `description` text,
  `font_awesome` varchar(20) DEFAULT NULL,
  `custom_icon_url` varchar(128) DEFAULT NULL,
  `is_system` tinyint(1) unsigned DEFAULT '0',
  `form_desc_tpl_id` int(11) unsigned DEFAULT '0' COMMENT '创建事项时,描述字段对应的模板id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_type
-- ----------------------------
INSERT INTO `issue_type` VALUES ('1', '1', 'Bug', 'bug', 'Standard', '测试过程、维护过程发现影响系统运行的缺陷', 'fa-bug', null, '1', '1');
INSERT INTO `issue_type` VALUES ('2', '2', '新功能', 'new_feature', 'Standard', '对系统提出的新功能', 'fa-plus', null, '1', '5');
INSERT INTO `issue_type` VALUES ('3', '3', '任务', 'task', 'Standard', '需要完成的任务', 'fa-tasks', null, '1', '0');
INSERT INTO `issue_type` VALUES ('4', '4', '优化改进', 'improve', 'Standard', '对现有系统功能的改进', 'fa-arrow-circle-o-up', null, '1', '5');
INSERT INTO `issue_type` VALUES ('5', '0', '子任务', 'child_task', 'Standard', '', 'fa-subscript', null, '1', '5');
INSERT INTO `issue_type` VALUES ('6', '2', '用户故事', 'user_story', 'Scrum', '从用户的角度来描述用户渴望得到的功能。一个好的用户故事包括三个要素：1. 角色；2. 活动　3. 商业价值', 'fa-users', null, '1', '0');
INSERT INTO `issue_type` VALUES ('7', '3', '技术任务', 'tech_task', 'Scrum', '技术性的任务,如架构设计,数据库选型', 'fa-cogs', null, '1', '5');
INSERT INTO `issue_type` VALUES ('8', '5', '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', null, '1', '0');

-- ----------------------------
-- Table structure for `issue_type_scheme`
-- ----------------------------
DROP TABLE IF EXISTS `issue_type_scheme`;
CREATE TABLE `issue_type_scheme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `is_default` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='问题方案表';

-- ----------------------------
-- Records of issue_type_scheme
-- ----------------------------
INSERT INTO `issue_type_scheme` VALUES ('1', '默认事项方案', '系统默认的事项方案,但没有设定或事项错误时使用该方案', '1');
INSERT INTO `issue_type_scheme` VALUES ('2', '敏捷开发事项方案', '敏捷开发适用的方案', '1');
INSERT INTO `issue_type_scheme` VALUES ('3', '瀑布模型的事项方案', '普通的软件开发流程', '1');
INSERT INTO `issue_type_scheme` VALUES ('4', '流程管理事项方案', '针对软件开发的', '0');
INSERT INTO `issue_type_scheme` VALUES ('5', '任务管理事项解决方案', '任务管理', '0');

-- ----------------------------
-- Table structure for `issue_type_scheme_data`
-- ----------------------------
DROP TABLE IF EXISTS `issue_type_scheme_data`;
CREATE TABLE `issue_type_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) unsigned DEFAULT NULL,
  `type_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scheme_id` (`scheme_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=541 DEFAULT CHARSET=utf8 COMMENT='问题方案字表';

-- ----------------------------
-- Records of issue_type_scheme_data
-- ----------------------------
INSERT INTO `issue_type_scheme_data` VALUES ('3', '3', '1');
INSERT INTO `issue_type_scheme_data` VALUES ('17', '4', '10000');
INSERT INTO `issue_type_scheme_data` VALUES ('20', '5', '10002');
INSERT INTO `issue_type_scheme_data` VALUES ('440', '2', '1');
INSERT INTO `issue_type_scheme_data` VALUES ('441', '2', '2');
INSERT INTO `issue_type_scheme_data` VALUES ('442', '2', '4');
INSERT INTO `issue_type_scheme_data` VALUES ('443', '2', '6');
INSERT INTO `issue_type_scheme_data` VALUES ('444', '2', '7');
INSERT INTO `issue_type_scheme_data` VALUES ('445', '2', '8');
INSERT INTO `issue_type_scheme_data` VALUES ('446', '1', '1');
INSERT INTO `issue_type_scheme_data` VALUES ('447', '1', '2');
INSERT INTO `issue_type_scheme_data` VALUES ('448', '1', '3');
INSERT INTO `issue_type_scheme_data` VALUES ('449', '1', '4');
INSERT INTO `issue_type_scheme_data` VALUES ('450', '1', '5');

-- ----------------------------
-- Table structure for `issue_ui`
-- ----------------------------
DROP TABLE IF EXISTS `issue_ui`;
CREATE TABLE `issue_ui` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue_type_id` int(10) unsigned DEFAULT NULL,
  `ui_type` varchar(10) DEFAULT '',
  `field_id` int(10) unsigned DEFAULT NULL,
  `order_weight` int(10) unsigned DEFAULT NULL,
  `tab_id` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1103 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_ui
-- ----------------------------
INSERT INTO `issue_ui` VALUES ('205', '8', 'create', '1', '3', '0');
INSERT INTO `issue_ui` VALUES ('206', '8', 'create', '2', '2', '0');
INSERT INTO `issue_ui` VALUES ('207', '8', 'create', '3', '1', '0');
INSERT INTO `issue_ui` VALUES ('208', '8', 'create', '4', '0', '0');
INSERT INTO `issue_ui` VALUES ('209', '8', 'create', '5', '0', '2');
INSERT INTO `issue_ui` VALUES ('210', '8', 'create', '6', '3', '0');
INSERT INTO `issue_ui` VALUES ('211', '8', 'create', '7', '2', '0');
INSERT INTO `issue_ui` VALUES ('212', '8', 'create', '8', '1', '0');
INSERT INTO `issue_ui` VALUES ('213', '8', 'create', '9', '1', '0');
INSERT INTO `issue_ui` VALUES ('214', '8', 'create', '10', '0', '0');
INSERT INTO `issue_ui` VALUES ('215', '8', 'create', '11', '0', '0');
INSERT INTO `issue_ui` VALUES ('216', '8', 'create', '12', '0', '0');
INSERT INTO `issue_ui` VALUES ('217', '8', 'create', '13', '0', '0');
INSERT INTO `issue_ui` VALUES ('218', '8', 'create', '14', '0', '0');
INSERT INTO `issue_ui` VALUES ('219', '8', 'create', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('220', '8', 'create', '16', '0', '0');
INSERT INTO `issue_ui` VALUES ('221', '8', 'edit', '1', '3', '0');
INSERT INTO `issue_ui` VALUES ('222', '8', 'edit', '2', '2', '0');
INSERT INTO `issue_ui` VALUES ('223', '8', 'edit', '3', '1', '0');
INSERT INTO `issue_ui` VALUES ('224', '8', 'edit', '4', '0', '0');
INSERT INTO `issue_ui` VALUES ('225', '8', 'edit', '5', '0', '2');
INSERT INTO `issue_ui` VALUES ('226', '8', 'edit', '6', '3', '0');
INSERT INTO `issue_ui` VALUES ('227', '8', 'edit', '7', '2', '0');
INSERT INTO `issue_ui` VALUES ('228', '8', 'edit', '8', '1', '0');
INSERT INTO `issue_ui` VALUES ('229', '8', 'edit', '9', '1', '0');
INSERT INTO `issue_ui` VALUES ('230', '8', 'edit', '10', '0', '0');
INSERT INTO `issue_ui` VALUES ('231', '8', 'edit', '11', '0', '0');
INSERT INTO `issue_ui` VALUES ('232', '8', 'edit', '12', '0', '0');
INSERT INTO `issue_ui` VALUES ('233', '8', 'edit', '13', '0', '0');
INSERT INTO `issue_ui` VALUES ('234', '8', 'edit', '14', '0', '0');
INSERT INTO `issue_ui` VALUES ('235', '8', 'edit', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('236', '8', 'edit', '16', '0', '0');
INSERT INTO `issue_ui` VALUES ('422', '4', 'create', '1', '14', '0');
INSERT INTO `issue_ui` VALUES ('423', '4', 'create', '6', '13', '0');
INSERT INTO `issue_ui` VALUES ('424', '4', 'create', '2', '12', '0');
INSERT INTO `issue_ui` VALUES ('425', '4', 'create', '3', '11', '0');
INSERT INTO `issue_ui` VALUES ('426', '4', 'create', '7', '10', '0');
INSERT INTO `issue_ui` VALUES ('427', '4', 'create', '9', '9', '0');
INSERT INTO `issue_ui` VALUES ('428', '4', 'create', '8', '8', '0');
INSERT INTO `issue_ui` VALUES ('429', '4', 'create', '4', '7', '0');
INSERT INTO `issue_ui` VALUES ('430', '4', 'create', '19', '6', '0');
INSERT INTO `issue_ui` VALUES ('431', '4', 'create', '10', '5', '0');
INSERT INTO `issue_ui` VALUES ('432', '4', 'create', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('433', '4', 'create', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('434', '4', 'create', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('435', '4', 'create', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('436', '4', 'create', '20', '0', '0');
INSERT INTO `issue_ui` VALUES ('452', '5', 'create', '1', '14', '0');
INSERT INTO `issue_ui` VALUES ('453', '5', 'create', '6', '13', '0');
INSERT INTO `issue_ui` VALUES ('454', '5', 'create', '2', '12', '0');
INSERT INTO `issue_ui` VALUES ('455', '5', 'create', '7', '11', '0');
INSERT INTO `issue_ui` VALUES ('456', '5', 'create', '9', '10', '0');
INSERT INTO `issue_ui` VALUES ('457', '5', 'create', '8', '9', '0');
INSERT INTO `issue_ui` VALUES ('458', '5', 'create', '3', '8', '0');
INSERT INTO `issue_ui` VALUES ('459', '5', 'create', '4', '7', '0');
INSERT INTO `issue_ui` VALUES ('460', '5', 'create', '19', '6', '0');
INSERT INTO `issue_ui` VALUES ('461', '5', 'create', '10', '5', '0');
INSERT INTO `issue_ui` VALUES ('462', '5', 'create', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('463', '5', 'create', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('464', '5', 'create', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('465', '5', 'create', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('466', '5', 'create', '20', '0', '0');
INSERT INTO `issue_ui` VALUES ('467', '5', 'edit', '1', '14', '0');
INSERT INTO `issue_ui` VALUES ('468', '5', 'edit', '6', '13', '0');
INSERT INTO `issue_ui` VALUES ('469', '5', 'edit', '2', '12', '0');
INSERT INTO `issue_ui` VALUES ('470', '5', 'edit', '7', '11', '0');
INSERT INTO `issue_ui` VALUES ('471', '5', 'edit', '9', '10', '0');
INSERT INTO `issue_ui` VALUES ('472', '5', 'edit', '8', '9', '0');
INSERT INTO `issue_ui` VALUES ('473', '5', 'edit', '3', '8', '0');
INSERT INTO `issue_ui` VALUES ('474', '5', 'edit', '4', '7', '0');
INSERT INTO `issue_ui` VALUES ('475', '5', 'edit', '19', '6', '0');
INSERT INTO `issue_ui` VALUES ('476', '5', 'edit', '10', '5', '0');
INSERT INTO `issue_ui` VALUES ('477', '5', 'edit', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('478', '5', 'edit', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('479', '5', 'edit', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('480', '5', 'edit', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('481', '5', 'edit', '20', '0', '0');
INSERT INTO `issue_ui` VALUES ('587', '6', 'create', '1', '7', '0');
INSERT INTO `issue_ui` VALUES ('588', '6', 'create', '6', '6', '0');
INSERT INTO `issue_ui` VALUES ('589', '6', 'create', '2', '5', '0');
INSERT INTO `issue_ui` VALUES ('590', '6', 'create', '8', '4', '0');
INSERT INTO `issue_ui` VALUES ('591', '6', 'create', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('592', '6', 'create', '4', '2', '0');
INSERT INTO `issue_ui` VALUES ('593', '6', 'create', '21', '1', '0');
INSERT INTO `issue_ui` VALUES ('594', '6', 'create', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('595', '6', 'create', '19', '6', '33');
INSERT INTO `issue_ui` VALUES ('596', '6', 'create', '10', '5', '33');
INSERT INTO `issue_ui` VALUES ('597', '6', 'create', '7', '4', '33');
INSERT INTO `issue_ui` VALUES ('598', '6', 'create', '20', '3', '33');
INSERT INTO `issue_ui` VALUES ('599', '6', 'create', '9', '2', '33');
INSERT INTO `issue_ui` VALUES ('600', '6', 'create', '13', '1', '33');
INSERT INTO `issue_ui` VALUES ('601', '6', 'create', '12', '0', '33');
INSERT INTO `issue_ui` VALUES ('602', '6', 'edit', '1', '7', '0');
INSERT INTO `issue_ui` VALUES ('603', '6', 'edit', '6', '6', '0');
INSERT INTO `issue_ui` VALUES ('604', '6', 'edit', '2', '5', '0');
INSERT INTO `issue_ui` VALUES ('605', '6', 'edit', '8', '4', '0');
INSERT INTO `issue_ui` VALUES ('606', '6', 'edit', '4', '3', '0');
INSERT INTO `issue_ui` VALUES ('607', '6', 'edit', '11', '2', '0');
INSERT INTO `issue_ui` VALUES ('608', '6', 'edit', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('609', '6', 'edit', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('610', '6', 'edit', '19', '6', '34');
INSERT INTO `issue_ui` VALUES ('611', '6', 'edit', '10', '5', '34');
INSERT INTO `issue_ui` VALUES ('612', '6', 'edit', '7', '4', '34');
INSERT INTO `issue_ui` VALUES ('613', '6', 'edit', '20', '3', '34');
INSERT INTO `issue_ui` VALUES ('614', '6', 'edit', '9', '2', '34');
INSERT INTO `issue_ui` VALUES ('615', '6', 'edit', '12', '1', '34');
INSERT INTO `issue_ui` VALUES ('616', '6', 'edit', '13', '0', '34');
INSERT INTO `issue_ui` VALUES ('646', '7', 'create', '1', '7', '0');
INSERT INTO `issue_ui` VALUES ('647', '7', 'create', '6', '6', '0');
INSERT INTO `issue_ui` VALUES ('648', '7', 'create', '2', '5', '0');
INSERT INTO `issue_ui` VALUES ('649', '7', 'create', '8', '4', '0');
INSERT INTO `issue_ui` VALUES ('650', '7', 'create', '4', '3', '0');
INSERT INTO `issue_ui` VALUES ('651', '7', 'create', '11', '2', '0');
INSERT INTO `issue_ui` VALUES ('652', '7', 'create', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('653', '7', 'create', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('654', '7', 'create', '19', '6', '37');
INSERT INTO `issue_ui` VALUES ('655', '7', 'create', '10', '5', '37');
INSERT INTO `issue_ui` VALUES ('656', '7', 'create', '7', '4', '37');
INSERT INTO `issue_ui` VALUES ('657', '7', 'create', '20', '3', '37');
INSERT INTO `issue_ui` VALUES ('658', '7', 'create', '9', '2', '37');
INSERT INTO `issue_ui` VALUES ('659', '7', 'create', '13', '1', '37');
INSERT INTO `issue_ui` VALUES ('660', '7', 'create', '12', '0', '37');
INSERT INTO `issue_ui` VALUES ('661', '7', 'edit', '1', '7', '0');
INSERT INTO `issue_ui` VALUES ('662', '7', 'edit', '6', '6', '0');
INSERT INTO `issue_ui` VALUES ('663', '7', 'edit', '2', '5', '0');
INSERT INTO `issue_ui` VALUES ('664', '7', 'edit', '8', '4', '0');
INSERT INTO `issue_ui` VALUES ('665', '7', 'edit', '4', '3', '0');
INSERT INTO `issue_ui` VALUES ('666', '7', 'edit', '11', '2', '0');
INSERT INTO `issue_ui` VALUES ('667', '7', 'edit', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('668', '7', 'edit', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('669', '7', 'edit', '19', '6', '38');
INSERT INTO `issue_ui` VALUES ('670', '7', 'edit', '10', '5', '38');
INSERT INTO `issue_ui` VALUES ('671', '7', 'edit', '7', '4', '38');
INSERT INTO `issue_ui` VALUES ('672', '7', 'edit', '9', '3', '38');
INSERT INTO `issue_ui` VALUES ('673', '7', 'edit', '20', '2', '38');
INSERT INTO `issue_ui` VALUES ('674', '7', 'edit', '12', '1', '38');
INSERT INTO `issue_ui` VALUES ('675', '7', 'edit', '13', '0', '38');
INSERT INTO `issue_ui` VALUES ('834', '3', 'create', '1', '13', '0');
INSERT INTO `issue_ui` VALUES ('835', '3', 'create', '6', '12', '0');
INSERT INTO `issue_ui` VALUES ('836', '3', 'create', '2', '11', '0');
INSERT INTO `issue_ui` VALUES ('837', '3', 'create', '7', '10', '0');
INSERT INTO `issue_ui` VALUES ('838', '3', 'create', '9', '9', '0');
INSERT INTO `issue_ui` VALUES ('839', '3', 'create', '8', '8', '0');
INSERT INTO `issue_ui` VALUES ('840', '3', 'create', '3', '7', '0');
INSERT INTO `issue_ui` VALUES ('841', '3', 'create', '4', '6', '0');
INSERT INTO `issue_ui` VALUES ('842', '3', 'create', '19', '5', '0');
INSERT INTO `issue_ui` VALUES ('843', '3', 'create', '10', '4', '0');
INSERT INTO `issue_ui` VALUES ('844', '3', 'create', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('845', '3', 'create', '12', '2', '0');
INSERT INTO `issue_ui` VALUES ('846', '3', 'create', '13', '1', '0');
INSERT INTO `issue_ui` VALUES ('847', '3', 'create', '20', '0', '0');
INSERT INTO `issue_ui` VALUES ('848', '3', 'edit', '1', '13', '0');
INSERT INTO `issue_ui` VALUES ('849', '3', 'edit', '6', '12', '0');
INSERT INTO `issue_ui` VALUES ('850', '3', 'edit', '2', '11', '0');
INSERT INTO `issue_ui` VALUES ('851', '3', 'edit', '7', '10', '0');
INSERT INTO `issue_ui` VALUES ('852', '3', 'edit', '9', '9', '0');
INSERT INTO `issue_ui` VALUES ('853', '3', 'edit', '8', '8', '0');
INSERT INTO `issue_ui` VALUES ('854', '3', 'edit', '3', '7', '0');
INSERT INTO `issue_ui` VALUES ('855', '3', 'edit', '4', '6', '0');
INSERT INTO `issue_ui` VALUES ('856', '3', 'edit', '19', '5', '0');
INSERT INTO `issue_ui` VALUES ('857', '3', 'edit', '10', '4', '0');
INSERT INTO `issue_ui` VALUES ('858', '3', 'edit', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('859', '3', 'edit', '12', '2', '0');
INSERT INTO `issue_ui` VALUES ('860', '3', 'edit', '13', '1', '0');
INSERT INTO `issue_ui` VALUES ('861', '3', 'edit', '20', '0', '0');
INSERT INTO `issue_ui` VALUES ('862', '3', 'edit', '20', '2', '49');
INSERT INTO `issue_ui` VALUES ('863', '3', 'edit', '9', '1', '49');
INSERT INTO `issue_ui` VALUES ('864', '3', 'edit', '3', '0', '49');
INSERT INTO `issue_ui` VALUES ('911', '2', 'edit', '1', '11', '0');
INSERT INTO `issue_ui` VALUES ('912', '2', 'edit', '19', '10', '0');
INSERT INTO `issue_ui` VALUES ('913', '2', 'edit', '10', '9', '0');
INSERT INTO `issue_ui` VALUES ('914', '2', 'edit', '6', '8', '0');
INSERT INTO `issue_ui` VALUES ('915', '2', 'edit', '2', '7', '0');
INSERT INTO `issue_ui` VALUES ('916', '2', 'edit', '7', '6', '0');
INSERT INTO `issue_ui` VALUES ('917', '2', 'edit', '4', '5', '0');
INSERT INTO `issue_ui` VALUES ('918', '2', 'edit', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('919', '2', 'edit', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('920', '2', 'edit', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('921', '2', 'edit', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('922', '2', 'edit', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('923', '2', 'edit', '20', '2', '53');
INSERT INTO `issue_ui` VALUES ('924', '2', 'edit', '9', '1', '53');
INSERT INTO `issue_ui` VALUES ('925', '2', 'edit', '3', '0', '53');
INSERT INTO `issue_ui` VALUES ('958', '2', 'create', '1', '10', '0');
INSERT INTO `issue_ui` VALUES ('959', '2', 'create', '6', '9', '0');
INSERT INTO `issue_ui` VALUES ('960', '2', 'create', '19', '8', '0');
INSERT INTO `issue_ui` VALUES ('961', '2', 'create', '2', '7', '0');
INSERT INTO `issue_ui` VALUES ('962', '2', 'create', '7', '6', '0');
INSERT INTO `issue_ui` VALUES ('963', '2', 'create', '4', '5', '0');
INSERT INTO `issue_ui` VALUES ('964', '2', 'create', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('965', '2', 'create', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('966', '2', 'create', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('967', '2', 'create', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('968', '2', 'create', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('969', '2', 'create', '10', '3', '56');
INSERT INTO `issue_ui` VALUES ('970', '2', 'create', '20', '2', '56');
INSERT INTO `issue_ui` VALUES ('971', '2', 'create', '9', '1', '56');
INSERT INTO `issue_ui` VALUES ('972', '2', 'create', '3', '0', '56');
INSERT INTO `issue_ui` VALUES ('989', '4', 'edit', '1', '11', '0');
INSERT INTO `issue_ui` VALUES ('990', '4', 'edit', '6', '10', '0');
INSERT INTO `issue_ui` VALUES ('991', '4', 'edit', '2', '9', '0');
INSERT INTO `issue_ui` VALUES ('992', '4', 'edit', '7', '8', '0');
INSERT INTO `issue_ui` VALUES ('993', '4', 'edit', '4', '7', '0');
INSERT INTO `issue_ui` VALUES ('994', '4', 'edit', '19', '6', '0');
INSERT INTO `issue_ui` VALUES ('995', '4', 'edit', '11', '5', '0');
INSERT INTO `issue_ui` VALUES ('996', '4', 'edit', '12', '4', '0');
INSERT INTO `issue_ui` VALUES ('997', '4', 'edit', '13', '3', '0');
INSERT INTO `issue_ui` VALUES ('998', '4', 'edit', '15', '2', '0');
INSERT INTO `issue_ui` VALUES ('999', '4', 'edit', '20', '1', '0');
INSERT INTO `issue_ui` VALUES ('1000', '4', 'edit', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('1001', '4', 'edit', '8', '3', '58');
INSERT INTO `issue_ui` VALUES ('1002', '4', 'edit', '9', '2', '58');
INSERT INTO `issue_ui` VALUES ('1003', '4', 'edit', '3', '1', '58');
INSERT INTO `issue_ui` VALUES ('1004', '4', 'edit', '10', '0', '58');
INSERT INTO `issue_ui` VALUES ('1005', '1', 'create', '1', '8', '0');
INSERT INTO `issue_ui` VALUES ('1006', '1', 'create', '6', '7', '0');
INSERT INTO `issue_ui` VALUES ('1007', '1', 'create', '2', '6', '0');
INSERT INTO `issue_ui` VALUES ('1008', '1', 'create', '7', '5', '0');
INSERT INTO `issue_ui` VALUES ('1009', '1', 'create', '4', '4', '0');
INSERT INTO `issue_ui` VALUES ('1010', '1', 'create', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('1011', '1', 'create', '12', '2', '0');
INSERT INTO `issue_ui` VALUES ('1012', '1', 'create', '13', '1', '0');
INSERT INTO `issue_ui` VALUES ('1013', '1', 'create', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('1014', '1', 'create', '19', '7', '59');
INSERT INTO `issue_ui` VALUES ('1015', '1', 'create', '20', '6', '59');
INSERT INTO `issue_ui` VALUES ('1016', '1', 'create', '18', '5', '59');
INSERT INTO `issue_ui` VALUES ('1017', '1', 'create', '3', '4', '59');
INSERT INTO `issue_ui` VALUES ('1018', '1', 'create', '10', '3', '59');
INSERT INTO `issue_ui` VALUES ('1019', '1', 'create', '21', '2', '59');
INSERT INTO `issue_ui` VALUES ('1020', '1', 'create', '8', '1', '59');
INSERT INTO `issue_ui` VALUES ('1021', '1', 'create', '9', '0', '59');
INSERT INTO `issue_ui` VALUES ('1022', '1', 'edit', '1', '9', '0');
INSERT INTO `issue_ui` VALUES ('1023', '1', 'edit', '6', '8', '0');
INSERT INTO `issue_ui` VALUES ('1024', '1', 'edit', '2', '7', '0');
INSERT INTO `issue_ui` VALUES ('1025', '1', 'edit', '7', '6', '0');
INSERT INTO `issue_ui` VALUES ('1026', '1', 'edit', '4', '5', '0');
INSERT INTO `issue_ui` VALUES ('1027', '1', 'edit', '19', '4', '0');
INSERT INTO `issue_ui` VALUES ('1028', '1', 'edit', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('1029', '1', 'edit', '12', '2', '0');
INSERT INTO `issue_ui` VALUES ('1030', '1', 'edit', '13', '1', '0');
INSERT INTO `issue_ui` VALUES ('1031', '1', 'edit', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('1032', '1', 'edit', '3', '6', '60');
INSERT INTO `issue_ui` VALUES ('1033', '1', 'edit', '18', '5', '60');
INSERT INTO `issue_ui` VALUES ('1034', '1', 'edit', '20', '4', '60');
INSERT INTO `issue_ui` VALUES ('1035', '1', 'edit', '10', '3', '60');
INSERT INTO `issue_ui` VALUES ('1036', '1', 'edit', '21', '2', '60');
INSERT INTO `issue_ui` VALUES ('1037', '1', 'edit', '8', '1', '60');
INSERT INTO `issue_ui` VALUES ('1038', '1', 'edit', '9', '0', '60');

-- ----------------------------
-- Table structure for `issue_ui_tab`
-- ----------------------------
DROP TABLE IF EXISTS `issue_ui_tab`;
CREATE TABLE `issue_ui_tab` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_type_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `order_weight` int(11) DEFAULT NULL,
  `ui_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `issue_id` (`issue_type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_ui_tab
-- ----------------------------
INSERT INTO `issue_ui_tab` VALUES ('7', '10', 'test-name-24019', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('8', '11', 'test-name-53500', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('33', '6', '更多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('34', '6', '\n            \n            更多\n             \n            \n        \n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('37', '7', '更 多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('38', '7', '\n            \n            更 多\n             \n            \n        \n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('49', '3', '\n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('53', '2', '\n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n   ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('56', '2', '更 多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('58', '4', '\n            \n            更多\n             \n            \n        \n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('59', '1', '更 多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('60', '1', '\n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        ', '0', 'edit');

-- ----------------------------
-- Table structure for `log_base`
-- ----------------------------
DROP TABLE IF EXISTS `log_base`;
CREATE TABLE `log_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) DEFAULT NULL COMMENT '所属模块',
  `obj_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作记录所关联的对象id,如现货id 订单id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作者id,0为系统操作',
  `user_name` varchar(32) DEFAULT '' COMMENT '操作者用户名',
  `real_name` varchar(255) DEFAULT NULL,
  `page` varchar(100) DEFAULT '' COMMENT '页面',
  `pre_status` tinyint(3) unsigned DEFAULT NULL,
  `cur_status` tinyint(3) unsigned DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL COMMENT '操作动作',
  `remark` varchar(100) DEFAULT '' COMMENT '动作',
  `pre_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `cur_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `ip` varchar(15) DEFAULT '' COMMENT '操作者ip地址 ',
  `time` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING HASH,
  KEY `obj_id` (`obj_id`) USING BTREE,
  KEY `like_query` (`uid`,`action`,`remark`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

-- ----------------------------
-- Records of log_base
-- ----------------------------

-- ----------------------------
-- Table structure for `log_operating`
-- ----------------------------
DROP TABLE IF EXISTS `log_operating`;
CREATE TABLE `log_operating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL DEFAULT '0',
  `module` varchar(20) DEFAULT NULL COMMENT '所属模块',
  `obj_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作记录所关联的对象id,如现货id 订单id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作者id,0为系统操作',
  `user_name` varchar(32) DEFAULT '' COMMENT '操作者用户名',
  `real_name` varchar(255) DEFAULT NULL,
  `page` varchar(100) DEFAULT '' COMMENT '页面',
  `pre_status` tinyint(3) unsigned DEFAULT NULL,
  `cur_status` tinyint(3) unsigned DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL COMMENT '操作动作',
  `remark` varchar(100) DEFAULT '' COMMENT '动作',
  `pre_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `cur_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `ip` varchar(15) DEFAULT '' COMMENT '操作者ip地址 ',
  `time` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING HASH,
  KEY `obj_id` (`obj_id`) USING BTREE,
  KEY `like_query` (`uid`,`action`,`remark`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

-- ----------------------------
-- Records of log_operating
-- ----------------------------

-- ----------------------------
-- Table structure for `log_runtime_error`
-- ----------------------------
DROP TABLE IF EXISTS `log_runtime_error`;
CREATE TABLE `log_runtime_error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `md5` varchar(32) NOT NULL,
  `file` varchar(255) NOT NULL,
  `line` smallint(6) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `err` varchar(32) NOT NULL DEFAULT '',
  `errstr` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_line_unique` (`md5`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_runtime_error
-- ----------------------------

-- ----------------------------
-- Table structure for `main_action`
-- ----------------------------
DROP TABLE IF EXISTS `main_action`;
CREATE TABLE `main_action` (
  `id` decimal(18,0) NOT NULL,
  `issueid` decimal(18,0) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `actiontype` varchar(255) DEFAULT NULL,
  `actionlevel` varchar(255) DEFAULT NULL,
  `rolelevel` decimal(18,0) DEFAULT NULL,
  `actionbody` longtext,
  `created` datetime DEFAULT NULL,
  `updateauthor` varchar(255) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `actionnum` decimal(18,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_author_created` (`author`,`created`),
  KEY `action_issue` (`issueid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_action
-- ----------------------------

-- ----------------------------
-- Table structure for `main_activity`
-- ----------------------------
DROP TABLE IF EXISTS `main_activity`;
CREATE TABLE `main_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT NULL,
  `action` varchar(32) DEFAULT NULL COMMENT '动作说明,如 关闭了，创建了，修复了',
  `type` enum('agile','user','issue','issue_comment','org','project') DEFAULT 'issue' COMMENT 'project,issue,user,agile,issue_comment',
  `obj_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `project_id` (`project_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `main_announcement`
-- ----------------------------
DROP TABLE IF EXISTS `main_announcement`;
CREATE TABLE `main_announcement` (
  `id` int(10) unsigned NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '0为禁用,1为发布中',
  `flag` int(11) DEFAULT '0' COMMENT '每次发布将自增该字段',
  `expire_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_announcement
-- ----------------------------

-- ----------------------------
-- Table structure for `main_cache_key`
-- ----------------------------
DROP TABLE IF EXISTS `main_cache_key`;
CREATE TABLE `main_cache_key` (
  `key` varchar(100) NOT NULL,
  `module` varchar(64) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `expire` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `module_key` (`key`,`module`) USING BTREE,
  KEY `module` (`module`),
  KEY `expire` (`expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_cache_key
-- ----------------------------

-- ----------------------------
-- Table structure for `main_eventtype`
-- ----------------------------
DROP TABLE IF EXISTS `main_eventtype`;
CREATE TABLE `main_eventtype` (
  `id` decimal(18,0) NOT NULL,
  `template_id` decimal(18,0) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `event_type` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_eventtype
-- ----------------------------
INSERT INTO `main_eventtype` VALUES ('1', null, 'Issue Created', 'This is the \'issue created\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('2', null, 'Issue Updated', 'This is the \'issue updated\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('3', null, 'Issue Assigned', 'This is the \'issue assigned\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('4', null, 'Issue Resolved', 'This is the \'issue resolved\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('5', null, 'Issue Closed', 'This is the \'issue closed\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('6', null, 'Issue Commented', 'This is the \'issue commented\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('7', null, 'Issue Reopened', 'This is the \'issue reopened\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('8', null, 'Issue Deleted', 'This is the \'issue deleted\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('9', null, 'Issue Moved', 'This is the \'issue moved\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('10', null, 'Work Logged On Issue', 'This is the \'work logged on issue\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('11', null, 'Work Started On Issue', 'This is the \'work started on issue\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('12', null, 'Work Stopped On Issue', 'This is the \'work stopped on issue\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('13', null, 'Generic Event', 'This is the \'generic event\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('14', null, 'Issue Comment Edited', 'This is the \'issue comment edited\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('15', null, 'Issue Worklog Updated', 'This is the \'issue worklog updated\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('16', null, 'Issue Worklog Deleted', 'This is the \'issue worklog deleted\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES ('17', null, 'Issue Comment Deleted', 'This is the \'issue comment deleted\' event.', 'jira.system.event.type');

-- ----------------------------
-- Table structure for `main_group`
-- ----------------------------
DROP TABLE IF EXISTS `main_group`;
CREATE TABLE `main_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `group_type` varchar(60) DEFAULT NULL,
  `directory_id` decimal(18,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_group
-- ----------------------------
INSERT INTO `main_group` VALUES ('1', 'administrators', '1', null, null, null, '1', null);
INSERT INTO `main_group` VALUES ('2', 'developers', '1', null, null, null, '1', null);
INSERT INTO `main_group` VALUES ('3', 'users', '1', null, null, null, '1', null);
INSERT INTO `main_group` VALUES ('4', 'qas', '1', null, null, null, '1', null);
INSERT INTO `main_group` VALUES ('5', 'ui-designers', '1', null, null, null, '1', null);
INSERT INTO `main_group` VALUES ('8', 'AAA', null, null, null, '', null, null);

-- ----------------------------
-- Table structure for `main_mail_queue`
-- ----------------------------
DROP TABLE IF EXISTS `main_mail_queue`;
CREATE TABLE `main_mail_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `seq` varchar(32) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  `error` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seq` (`seq`) USING BTREE,
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_mail_queue
-- ----------------------------

-- ----------------------------
-- Table structure for `main_notify_scheme`
-- ----------------------------
DROP TABLE IF EXISTS `main_notify_scheme`;
CREATE TABLE `main_notify_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of main_notify_scheme
-- ----------------------------
INSERT INTO `main_notify_scheme` VALUES ('1', '默认通知方案', '1');

-- ----------------------------
-- Table structure for `main_notify_scheme_data`
-- ----------------------------
DROP TABLE IF EXISTS `main_notify_scheme_data`;
CREATE TABLE `main_notify_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of main_notify_scheme_data
-- ----------------------------
INSERT INTO `main_notify_scheme_data` VALUES ('1', '1', '事项创建', 'issue@create', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('2', '1', '事项更新', 'issue@update', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('3', '1', '事项分配', 'issue@assign', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('4', '1', '事项已解决', 'issue@resolve@complete', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('5', '1', '事项已关闭', 'issue@close', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('6', '1', '事项评论', 'issue@comment@create', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('7', '1', '删除评论', 'issue@comment@remove', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('8', '1', '开始解决事项', 'issue@resolve@start', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('9', '1', '停止解决事项', 'issue@resolve@stop', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('10', '1', '新增迭代', 'sprint@create', '[\"project\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('11', '1', '设置迭代进行时', 'sprint@start', '[\"project\"]');
INSERT INTO `main_notify_scheme_data` VALUES ('12', '1', '删除迭代', 'sprint@remove', '[\"project\"]');

-- ----------------------------
-- Table structure for `main_org`
-- ----------------------------
DROP TABLE IF EXISTS `main_org`;
CREATE TABLE `main_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `avatar` varchar(256) NOT NULL DEFAULT '',
  `create_uid` int(11) NOT NULL DEFAULT '0',
  `created` int(11) unsigned NOT NULL DEFAULT '0',
  `updated` int(11) unsigned NOT NULL DEFAULT '0',
  `scope` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 private, 2 internal , 3 public',
  PRIMARY KEY (`id`),
  KEY `path` (`path`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_org
-- ----------------------------
INSERT INTO `main_org` VALUES ('1', 'default', 'Default', 'Default organization', 'org/default.jpg', '0', '0', '1535263464', '3');

-- ----------------------------
-- Table structure for `main_setting`
-- ----------------------------
DROP TABLE IF EXISTS `main_setting`;
CREATE TABLE `main_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_key` varchar(50) NOT NULL COMMENT '关键字',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块,basic,advance,ui,datetime,languge,attachment可选',
  `order_weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序权重',
  `_value` varchar(100) NOT NULL,
  `default_value` varchar(100) DEFAULT '' COMMENT '默认值',
  `format` enum('string','int','float','json') NOT NULL DEFAULT 'string' COMMENT '数据类型',
  `form_input_type` enum('datetime','date','textarea','select','checkbox','radio','img','color','file','int','number','text') DEFAULT 'text' COMMENT '表单项类型',
  `form_optional_value` varchar(5000) DEFAULT NULL COMMENT '待选的值定义,为json格式',
  `description` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`),
  KEY `module` (`module`) USING BTREE,
  KEY `module_2` (`module`,`order_weight`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of main_setting
-- ----------------------------
INSERT INTO `main_setting` VALUES ('1', 'title', '网站的页面标题', 'basic', '0', 'MasterLab--基于敏捷开发和事项驱动的现代项目管理工具', 'MasterLab', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('2', 'open_status', '启用状态', 'basic', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('3', 'max_login_error', '最大尝试验证登录次数', 'basic', '0', '4', '4', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('4', 'login_require_captcha', '登录时需要验证码', 'basic', '0', '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('5', 'reg_require_captcha', '注册时需要验证码', 'basic', '0', '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('6', 'sender_format', '邮件发件人显示格式', 'basic', '0', '${fullname} (Masterlab)', '${fullname} (Hornet)', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('7', 'description', '说明', 'basic', '0', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('8', 'date_timezone', '默认用户时区', 'basic', '0', 'Asia/Shanghai', 'Asia/Shanghai', 'string', 'text', '[\"Asia/Shanghai\":\"\"]', '');
INSERT INTO `main_setting` VALUES ('11', 'allow_share_public', '允许用户分享过滤器或面部', 'basic', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('12', 'max_project_name', '项目名称最大长度', 'basic', '0', '80', '80', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('13', 'max_project_key', '项目键值最大长度', 'basic', '0', '20', '20', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('15', 'email_public', '邮件地址可见性', 'basic', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('20', 'allow_gravatars', '允许使用Gravatars用户头像', 'basic', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('21', 'gravatar_server', 'Gravatar服务器', 'basic', '0', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('24', 'send_mail_format', '默认发送个邮件的格式', 'user_default', '0', 'html', 'text', 'string', 'radio', '{\"text\":\"text\",\"html\":\"html\"}', '');
INSERT INTO `main_setting` VALUES ('25', 'issue_page_size', '问题导航每页显示的问题数量', 'user_default', '0', '100', '100', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('39', 'time_format', '时间格式', 'datetime', '0', 'H:m:s', 'HH:mm:ss', 'string', 'text', null, '例如 11:55:47');
INSERT INTO `main_setting` VALUES ('40', 'week_format', '星期格式', 'datetime', '0', 'EE H:m:s', 'EEEE HH:mm:ss', 'string', 'text', null, '例如 Wednesday 11:55:47');
INSERT INTO `main_setting` VALUES ('41', 'full_datetime_format', '完整日期/时间格式', 'datetime', '0', 'Y-m-d  H:m:s', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', null, '例如 2007-05-23  11:55:47');
INSERT INTO `main_setting` VALUES ('42', 'datetime_format', '日期格式(年月日)', 'datetime', '0', 'Y-m-d', 'yyyy-MM-dd', 'string', 'text', null, '例如 2007-05-23');
INSERT INTO `main_setting` VALUES ('43', 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', '0', '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天');
INSERT INTO `main_setting` VALUES ('45', 'attachment_dir', '附件路径', 'attachment', '0', '{{STORAGE_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', null, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下');
INSERT INTO `main_setting` VALUES ('46', 'attachment_size', '附件大小(单位M)', 'attachment', '0', '10.0', '10.0', 'float', 'text', null, '超过大小，无法上传');
INSERT INTO `main_setting` VALUES ('47', 'enbale_thum', '启用缩略图', 'attachment', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图');
INSERT INTO `main_setting` VALUES ('48', 'enable_zip', '启用ZIP支持', 'attachment', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载');
INSERT INTO `main_setting` VALUES ('49', 'password_strategy', '密码策略', 'password_strategy', '0', '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', '');
INSERT INTO `main_setting` VALUES ('50', 'send_mailer', '发信人', 'mail', '0', 'sender@smtp.masterlab.vip ', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('51', 'mail_prefix', '前缀', 'mail', '0', 'Masterlab', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('52', 'mail_host', '主机', 'mail', '0', 'smtpdm.aliyun.com', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('53', 'mail_port', 'SMTP端口', 'mail', '0', '25', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('54', 'mail_account', '账号', 'mail', '0', 'sender@smtp.masterlab.vip ', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('55', 'mail_password', '密码', 'mail', '0', 'MasterLab123Pwd ', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('56', 'mail_timeout', '发送超时', 'mail', '0', '20', '', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('57', 'page_layout', '页面布局', 'user_default', '0', 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', '');
INSERT INTO `main_setting` VALUES ('58', 'project_view', '项目首页', 'user_default', '0', 'issues', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', '');
INSERT INTO `main_setting` VALUES ('59', 'company', '公司名称', 'basic', '0', 'name', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('60', 'company_logo', '公司logo', 'basic', '0', 'logo', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('61', 'company_linkman', '联系人', 'basic', '0', '18002516775', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('62', 'company_phone', '联系电话', 'basic', '0', '135255256544', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('63', 'enable_async_mail', '是否使用异步方式发送邮件', 'mail', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('64', 'enable_mail', '是否开启邮件推送', 'mail', '0', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');

-- ----------------------------
-- Table structure for `main_timeline`
-- ----------------------------
DROP TABLE IF EXISTS `main_timeline`;
CREATE TABLE `main_timeline` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `type` varchar(12) NOT NULL DEFAULT '',
  `origin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `project_id` int(11) unsigned NOT NULL DEFAULT '0',
  `issue_id` int(11) unsigned NOT NULL DEFAULT '0',
  `action` varchar(32) NOT NULL DEFAULT '',
  `action_icon` varchar(64) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `content_html` text NOT NULL,
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_timeline
-- ----------------------------

-- ----------------------------
-- Table structure for `main_widget`
-- ----------------------------
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
INSERT INTO `main_widget` VALUES ('4', '便捷导航', 'nav', 'fetchNav', '通用', 'nav.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('5', '组织', 'org', 'fetchOrgs', '通用', 'org.png', 'list', '1', '1', '0', '', '[]', '0');
INSERT INTO `main_widget` VALUES ('6', '项目-汇总', 'project_stat', 'fetchProjectStat', '项目', 'project_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('7', '项目-解决与未解决对比图', 'project_abs', 'fetchProjectAbs', '项目', 'abs.png', 'chart_bar', '1', '0', '1', '', '\r\n[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"时间\",\"field\":\"by_time\",\"type\":\"select\",\"value\":[{\"title\":\"天\",\"value\":\"date\"},{\"title\":\"周\",\"value\":\"week\"},{\"title\":\"月\",\"value\":\"month\"}]},{\"name\":\"几日之内\",\"field\":\"within_date\",\"type\":\"text\",\"value\":\"\"}]', '0');
INSERT INTO `main_widget` VALUES ('8', '项目-优先级统计', 'project_priority_stat', 'fetchProjectPriorityStat', '项目', 'priority_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]\r\n', '0');
INSERT INTO `main_widget` VALUES ('9', '项目-状态统计', 'project_status_stat', 'fetchProjectStatusStat', '项目', 'status_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('10', '项目-开发者统计', 'project_developer_stat', 'fetchProjectDeveloperStat', '项目', 'developer_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('11', '项目-事项统计', 'project_issue_type_stat', 'fetchProjectIssueTypeStat', '项目', 'issue_type_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('12', '项目-饼状图', 'project_pie', 'fetchProjectPie', '项目', 'chart_pie.png', 'chart_pie', '1', '0', '1', '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]},{\"name\":\"开始时间\",\"field\":\"start_date\",\"type\":\"date\",\"value\":\"\"},{\"name\":\"结束时间\",\"field\":\"end_date\",\"type\":\"date\",\"value\":\"\"}]', '0');
INSERT INTO `main_widget` VALUES ('13', '迭代-汇总', 'sprint_stat', 'fetchSprintStat', '迭代', 'sprint_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('14', '迭代-倒计时', 'sprint_countdown', 'fetchSprintCountdown', '项目', 'countdown.png', 'text', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('15', '迭代-燃尽图', 'sprint_burndown', 'fetchSprintBurndown', '迭代', 'burndown.png', 'text', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('16', '迭代-速率图', 'sprint_speed', 'fetchSprintSpeedRate', '迭代', 'sprint_speed.png', 'text', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('17', '迭代-饼状图', 'sprint_pie', 'fetchSprintPie', '迭代', 'chart_pie.png', 'chart_pie', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('18', '迭代-解决与未解决对比图', 'sprint_abs', 'fetchSprintAbs', '迭代', 'abs.png', 'chart_bar', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('19', '迭代-优先级统计', 'sprint_priority_stat', 'fetchSprintPriorityStat', '迭代', 'priority_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('20', '迭代-状态统计', 'sprint_status_stat', 'fetchSprintStatusStat', '迭代', 'status_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');
INSERT INTO `main_widget` VALUES ('21', '迭代-开发者统计', 'sprint_developer_stat', 'fetchSprintDeveloperStat', '迭代', 'developer_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"迭代\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', '0');
INSERT INTO `main_widget` VALUES ('22', '迭代-事项统计', 'sprint_issue_type_stat', 'fetchSprintIssueTypeStat', '迭代', 'issue_type_stat.png', 'list', '1', '0', '1', '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', '0');

-- ----------------------------
-- Table structure for `permission`
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `_key` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_key_idx` (`_key`)
) ENGINE=InnoDB AUTO_INCREMENT=10905 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('10004', '0', '管理项目', '可以对项目进行设置', 'ADMINISTER_PROJECTS');
INSERT INTO `permission` VALUES ('10005', '0', '访问事项列表(已废弃)', '', 'BROWSE_ISSUES');
INSERT INTO `permission` VALUES ('10006', '0', '创建事项', '', 'CREATE_ISSUES');
INSERT INTO `permission` VALUES ('10007', '0', '评论', '', 'ADD_COMMENTS');
INSERT INTO `permission` VALUES ('10008', '0', '上传和删除附件', '', 'CREATE_ATTACHMENTS');
INSERT INTO `permission` VALUES ('10013', '0', '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES');
INSERT INTO `permission` VALUES ('10014', '0', '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES');
INSERT INTO `permission` VALUES ('10015', '0', '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES');
INSERT INTO `permission` VALUES ('10028', '0', '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS');
INSERT INTO `permission` VALUES ('10902', '0', '管理backlog', '', 'MANAGE_BACKLOG');
INSERT INTO `permission` VALUES ('10903', '0', '管理sprint', '', 'MANAGE_SPRINT');
INSERT INTO `permission` VALUES ('10904', '0', '管理kanban', null, 'MANAGE_KANBAN');

-- ----------------------------
-- Table structure for `permission_default_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_default_role`;
CREATE TABLE `permission_default_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT '0' COMMENT '如果为0表示系统初始化的角色，不为0表示某一项目特有的角色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10010 DEFAULT CHARSET=utf8 COMMENT='项目角色表';

-- ----------------------------
-- Records of permission_default_role
-- ----------------------------
INSERT INTO `permission_default_role` VALUES ('10000', 'Users', '普通用户', '0');
INSERT INTO `permission_default_role` VALUES ('10001', 'Developers', '开发者,如程序员，架构师', '0');
INSERT INTO `permission_default_role` VALUES ('10002', 'Administrators', '项目管理员，如项目经理，技术经理', '0');
INSERT INTO `permission_default_role` VALUES ('10003', 'QA', '测试工程师', '0');
INSERT INTO `permission_default_role` VALUES ('10006', 'PO', '产品经理，产品负责人', '0');

-- ----------------------------
-- Table structure for `permission_default_role_relation`
-- ----------------------------
DROP TABLE IF EXISTS `permission_default_role_relation`;
CREATE TABLE `permission_default_role_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `default_role_id` int(11) unsigned DEFAULT NULL,
  `perm_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `default_role_id` (`default_role_id`) USING HASH,
  KEY `role_id-and-perm_id` (`default_role_id`,`perm_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission_default_role_relation
-- ----------------------------
INSERT INTO `permission_default_role_relation` VALUES ('42', '10000', '10005');
INSERT INTO `permission_default_role_relation` VALUES ('43', '10000', '10006');
INSERT INTO `permission_default_role_relation` VALUES ('44', '10000', '10007');
INSERT INTO `permission_default_role_relation` VALUES ('45', '10000', '10008');
INSERT INTO `permission_default_role_relation` VALUES ('46', '10000', '10013');
INSERT INTO `permission_default_role_relation` VALUES ('47', '10001', '10005');
INSERT INTO `permission_default_role_relation` VALUES ('48', '10001', '10006');
INSERT INTO `permission_default_role_relation` VALUES ('49', '10001', '10007');
INSERT INTO `permission_default_role_relation` VALUES ('50', '10001', '10008');
INSERT INTO `permission_default_role_relation` VALUES ('51', '10001', '10013');
INSERT INTO `permission_default_role_relation` VALUES ('52', '10001', '10014');
INSERT INTO `permission_default_role_relation` VALUES ('53', '10001', '10015');
INSERT INTO `permission_default_role_relation` VALUES ('54', '10001', '10028');
INSERT INTO `permission_default_role_relation` VALUES ('55', '10002', '10004');
INSERT INTO `permission_default_role_relation` VALUES ('56', '10002', '10005');
INSERT INTO `permission_default_role_relation` VALUES ('57', '10002', '10006');
INSERT INTO `permission_default_role_relation` VALUES ('58', '10002', '10007');
INSERT INTO `permission_default_role_relation` VALUES ('59', '10002', '10008');
INSERT INTO `permission_default_role_relation` VALUES ('60', '10002', '10013');
INSERT INTO `permission_default_role_relation` VALUES ('61', '10002', '10014');
INSERT INTO `permission_default_role_relation` VALUES ('62', '10002', '10015');
INSERT INTO `permission_default_role_relation` VALUES ('63', '10002', '10028');
INSERT INTO `permission_default_role_relation` VALUES ('64', '10002', '10902');
INSERT INTO `permission_default_role_relation` VALUES ('65', '10002', '10903');
INSERT INTO `permission_default_role_relation` VALUES ('66', '10002', '10904');
INSERT INTO `permission_default_role_relation` VALUES ('67', '10006', '10004');
INSERT INTO `permission_default_role_relation` VALUES ('68', '10006', '10005');
INSERT INTO `permission_default_role_relation` VALUES ('69', '10006', '10006');
INSERT INTO `permission_default_role_relation` VALUES ('70', '10006', '10007');
INSERT INTO `permission_default_role_relation` VALUES ('71', '10006', '10008');
INSERT INTO `permission_default_role_relation` VALUES ('72', '10006', '10013');
INSERT INTO `permission_default_role_relation` VALUES ('73', '10006', '10014');
INSERT INTO `permission_default_role_relation` VALUES ('74', '10006', '10015');
INSERT INTO `permission_default_role_relation` VALUES ('75', '10006', '10028');
INSERT INTO `permission_default_role_relation` VALUES ('76', '10006', '10902');
INSERT INTO `permission_default_role_relation` VALUES ('77', '10006', '10903');
INSERT INTO `permission_default_role_relation` VALUES ('78', '10006', '10904');

-- ----------------------------
-- Table structure for `permission_global`
-- ----------------------------
DROP TABLE IF EXISTS `permission_global`;
CREATE TABLE `permission_global` (
  `id` int(11) unsigned NOT NULL,
  `_key` varchar(64) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全局权限定义表';

-- ----------------------------
-- Records of permission_global
-- ----------------------------
INSERT INTO `permission_global` VALUES ('10000', '系统管理员', '系统管理员', '负责执行所有管理功能。至少在这个权限中设置一个用户组。');

-- ----------------------------
-- Table structure for `permission_global_group`
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_group`;
CREATE TABLE `permission_global_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `perm_global_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perm_global_id` (`perm_global_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission_global_group
-- ----------------------------
INSERT INTO `permission_global_group` VALUES ('1', '10000', '1');

-- ----------------------------
-- Table structure for `permission_global_relation`
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_relation`;
CREATE TABLE `permission_global_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `perm_global_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  `is_system` tinyint(1) unsigned DEFAULT '0' COMMENT '是否系统自带',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`perm_global_id`,`group_id`) USING BTREE,
  KEY `perm_global_id` (`perm_global_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='用户组拥有的全局权限';

-- ----------------------------
-- Records of permission_global_relation
-- ----------------------------
INSERT INTO `permission_global_relation` VALUES ('2', '10001', '5', '1');
INSERT INTO `permission_global_relation` VALUES ('8', '10000', '1', '1');
INSERT INTO `permission_global_relation` VALUES ('9', '10000', '4', '0');
INSERT INTO `permission_global_relation` VALUES ('10', '10003', '2', '0');

-- ----------------------------
-- Table structure for `project_category`
-- ----------------------------
DROP TABLE IF EXISTS `project_category`;
CREATE TABLE `project_category` (
  `id` int(18) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `color` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_project_category_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_category
-- ----------------------------

-- ----------------------------
-- Table structure for `project_flag`
-- ----------------------------
DROP TABLE IF EXISTS `project_flag`;
CREATE TABLE `project_flag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `flag` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_flag
-- ----------------------------

-- ----------------------------
-- Table structure for `project_issue_report`
-- ----------------------------
DROP TABLE IF EXISTS `project_issue_report`;
CREATE TABLE `project_issue_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) unsigned DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `done_count` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `no_done_count` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `done_count_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `no_done_count_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) unsigned DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) unsigned DEFAULT '0' COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `projectIdAndDate` (`project_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_issue_report
-- ----------------------------

-- ----------------------------
-- Table structure for `project_issue_type_scheme_data`
-- ----------------------------
DROP TABLE IF EXISTS `project_issue_type_scheme_data`;
CREATE TABLE `project_issue_type_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_type_scheme_id` int(11) unsigned DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`) USING BTREE,
  KEY `issue_type_scheme_id` (`issue_type_scheme_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_issue_type_scheme_data
-- ----------------------------

-- ----------------------------
-- Table structure for `project_key`
-- ----------------------------
DROP TABLE IF EXISTS `project_key`;
CREATE TABLE `project_key` (
  `id` decimal(18,0) NOT NULL,
  `project_id` decimal(18,0) DEFAULT NULL,
  `project_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_all_project_keys` (`project_key`),
  KEY `idx_all_project_ids` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_key
-- ----------------------------

-- ----------------------------
-- Table structure for `project_label`
-- ----------------------------
DROP TABLE IF EXISTS `project_label`;
CREATE TABLE `project_label` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `color` varchar(20) NOT NULL,
  `bg_color` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_label
-- ----------------------------

-- ----------------------------
-- Table structure for `project_list_count`
-- ----------------------------
DROP TABLE IF EXISTS `project_list_count`;
CREATE TABLE `project_list_count` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_type_id` smallint(5) unsigned DEFAULT NULL,
  `project_total` int(10) unsigned DEFAULT NULL,
  `remark` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_list_count
-- ----------------------------

-- ----------------------------
-- Table structure for `project_main`
-- ----------------------------
DROP TABLE IF EXISTS `project_main`;
CREATE TABLE `project_main` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL DEFAULT '1',
  `org_path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead` int(11) unsigned DEFAULT '0',
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pcounter` decimal(18,0) DEFAULT NULL,
  `default_assignee` int(11) unsigned DEFAULT '0',
  `assignee_type` int(11) DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) unsigned DEFAULT NULL,
  `type` tinyint(2) DEFAULT '1',
  `type_child` tinyint(2) DEFAULT '0',
  `permission_scheme_id` int(11) unsigned DEFAULT '0',
  `workflow_scheme_id` int(11) unsigned NOT NULL,
  `create_uid` int(11) unsigned DEFAULT '0',
  `create_time` int(11) unsigned DEFAULT '0',
  `un_done_count` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '未完成事项数',
  `done_count` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '已经完成事项数',
  `closed_count` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_project_key` (`key`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `uid` (`create_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of project_main
-- ----------------------------

-- ----------------------------
-- Table structure for `project_main_extra`
-- ----------------------------
DROP TABLE IF EXISTS `project_main_extra`;
CREATE TABLE `project_main_extra` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT '0',
  `detail` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of project_main_extra
-- ----------------------------

-- ----------------------------
-- Table structure for `project_module`
-- ----------------------------
DROP TABLE IF EXISTS `project_module`;
CREATE TABLE `project_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(64) DEFAULT '',
  `description` varchar(256) DEFAULT NULL,
  `lead` int(11) unsigned DEFAULT NULL,
  `default_assignee` int(11) unsigned DEFAULT NULL,
  `ctime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_module
-- ----------------------------

-- ----------------------------
-- Table structure for `project_role`
-- ----------------------------
DROP TABLE IF EXISTS `project_role`;
CREATE TABLE `project_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) unsigned DEFAULT '0' COMMENT '是否是默认角色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_role
-- ----------------------------

-- ----------------------------
-- Table structure for `project_role_relation`
-- ----------------------------
DROP TABLE IF EXISTS `project_role_relation`;
CREATE TABLE `project_role_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `role_id` int(11) unsigned DEFAULT NULL,
  `perm_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING HASH,
  KEY `role_id-and-perm_id` (`role_id`,`perm_id`) USING HASH,
  KEY `unique_data` (`project_id`,`role_id`,`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_role_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `project_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `project_user_role`;
CREATE TABLE `project_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT '0',
  `project_id` int(11) unsigned DEFAULT '0',
  `role_id` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`user_id`,`project_id`,`role_id`) USING BTREE,
  KEY `uid` (`user_id`) USING BTREE,
  KEY `uid_project` (`user_id`,`project_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_user_role
-- ----------------------------

-- ----------------------------
-- Table structure for `project_version`
-- ----------------------------
DROP TABLE IF EXISTS `project_version`;
CREATE TABLE `project_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `sequence` decimal(18,0) DEFAULT NULL,
  `released` tinyint(10) unsigned DEFAULT '0' COMMENT '0未发布 1已发布',
  `archived` varchar(10) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `start_date` int(10) unsigned DEFAULT NULL,
  `release_date` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_name_unique` (`project_id`,`name`) USING BTREE,
  KEY `idx_version_project` (`project_id`),
  KEY `idx_version_sequence` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_version
-- ----------------------------

-- ----------------------------
-- Table structure for `project_workflows`
-- ----------------------------
DROP TABLE IF EXISTS `project_workflows`;
CREATE TABLE `project_workflows` (
  `id` decimal(18,0) NOT NULL,
  `workflowname` varchar(255) DEFAULT NULL,
  `creatorname` varchar(255) DEFAULT NULL,
  `descriptor` longtext,
  `islocked` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_workflows
-- ----------------------------

-- ----------------------------
-- Table structure for `project_workflow_status`
-- ----------------------------
DROP TABLE IF EXISTS `project_workflow_status`;
CREATE TABLE `project_workflow_status` (
  `id` decimal(18,0) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `parentname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_parent_name` (`parentname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_workflow_status
-- ----------------------------

-- ----------------------------
-- Table structure for `report_project_issue`
-- ----------------------------
DROP TABLE IF EXISTS `report_project_issue`;
CREATE TABLE `report_project_issue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) unsigned DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `count_done` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `count_done_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) unsigned DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) unsigned DEFAULT '0' COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `projectIdAndDate` (`project_id`,`date`) USING BTREE,
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report_project_issue
-- ----------------------------

-- ----------------------------
-- Table structure for `report_sprint_issue`
-- ----------------------------
DROP TABLE IF EXISTS `report_sprint_issue`;
CREATE TABLE `report_sprint_issue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) unsigned DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `count_done` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `count_done_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) unsigned DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) unsigned DEFAULT '0' COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sprintIdAndDate` (`sprint_id`,`date`) USING BTREE,
  KEY `sprint_id` (`sprint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report_sprint_issue
-- ----------------------------

-- ----------------------------
-- Table structure for `service_config`
-- ----------------------------
DROP TABLE IF EXISTS `service_config`;
CREATE TABLE `service_config` (
  `id` decimal(18,0) NOT NULL,
  `delaytime` decimal(18,0) DEFAULT NULL,
  `clazz` varchar(255) DEFAULT NULL,
  `servicename` varchar(255) DEFAULT NULL,
  `cron_expression` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of service_config
-- ----------------------------

-- ----------------------------
-- Table structure for `user_application`
-- ----------------------------
DROP TABLE IF EXISTS `user_application`;
CREATE TABLE `user_application` (
  `id` decimal(18,0) NOT NULL,
  `application_name` varchar(255) DEFAULT NULL,
  `lower_application_name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` decimal(9,0) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `application_type` varchar(255) DEFAULT NULL,
  `credential` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_application_name` (`lower_application_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_application
-- ----------------------------
INSERT INTO `user_application` VALUES ('1', 'crowd-embedded', 'crowd-embedded', '2013-02-28 11:57:51', '2013-02-28 11:57:51', '1', '', 'CROWD', 'X');

-- ----------------------------
-- Table structure for `user_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `user_attributes`;
CREATE TABLE `user_attributes` (
  `id` decimal(18,0) NOT NULL,
  `user_id` decimal(18,0) DEFAULT NULL,
  `directory_id` decimal(18,0) DEFAULT NULL,
  `attribute_name` varchar(255) DEFAULT NULL,
  `attribute_value` varchar(255) DEFAULT NULL,
  `lower_attribute_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uk_user_attr_name_lval` (`user_id`,`attribute_name`),
  KEY `idx_user_attr_dir_name_lval` (`directory_id`,`attribute_name`(240),`lower_attribute_value`(240)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_attributes
-- ----------------------------

-- ----------------------------
-- Table structure for `user_email_active`
-- ----------------------------
DROP TABLE IF EXISTS `user_email_active`;
CREATE TABLE `user_email_active` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `uid` int(11) unsigned NOT NULL,
  `verify_code` varchar(32) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`,`verify_code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_email_active
-- ----------------------------
INSERT INTO `user_email_active` VALUES ('1', 'huangjie', '465175275@qq.com', '10827', 'K14V9XW41UBZVD3S9LFF4327YY8YQTM1', '1523628779');
INSERT INTO `user_email_active` VALUES ('2', 'huangjie', '465175275@qq.com', '10831', '74MXCQCDKCOFUJEFNGO8YM9787C5GQOF', '1523628854');
INSERT INTO `user_email_active` VALUES ('3', '19081381571', '19081381571@masterlab.org', '11299', 'GV18YT5CRRNIP0ER8J7E0R2V45TWIC5X', '1536218573');
INSERT INTO `user_email_active` VALUES ('4', '19055406672', '19055406672@masterlab.org', '11336', '61NQU4T4JQLFY3CAZDH0Q11G5SL6Z12G', '1536219700');
INSERT INTO `user_email_active` VALUES ('5', '19080125602', '19080125602@masterlab.org', '11361', '9U1MWHHTYJHLOM9PPDCVKJ2FQRHC6IS4', '1536219834');
INSERT INTO `user_email_active` VALUES ('6', 'cfm_test', '442118411@qq.com', '11658', 'JUR4B9DXBRX4R11QV4NP27X76ODK8PQ1', '1541489893');
INSERT INTO `user_email_active` VALUES ('7', 'wj', 'masterlabwei@gmail.com', '11659', 'H1021H50VDGRMENC8YEB9C24NZJ7K1WB', '1545629899');
INSERT INTO `user_email_active` VALUES ('8', '邓文杰', '460399316@qq.com', '11661', '5NTSU1COLPZRRXXJBC3K3QZ0PV48YQXP', '1547045923');

-- ----------------------------
-- Table structure for `user_email_find_password`
-- ----------------------------
DROP TABLE IF EXISTS `user_email_find_password`;
CREATE TABLE `user_email_find_password` (
  `email` varchar(50) NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `verify_code` varchar(32) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email` (`email`,`verify_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_email_find_password
-- ----------------------------
INSERT INTO `user_email_find_password` VALUES ('121642038@qq.com', '0', 'KDBQ6N3V7ECRRDU2B9T33BBZ8TZKF4DA', '1536467329');
INSERT INTO `user_email_find_password` VALUES ('19024571277@masterlab.org', '0', 'YGFFYSNI9ST8QUTRVS8P0ERXUHLPVH9V', '1548173177');
INSERT INTO `user_email_find_password` VALUES ('19038208789@masterlab.org', '0', 'D5XEVD7SONONDASUSS2FKVMUOHVUGXL3', '1553353341');
INSERT INTO `user_email_find_password` VALUES ('19042926361@masterlab.org', '0', 'I2S4WFV7Q6R9K2IAIUO1MWD7P8EZXWPP', '1548175197');
INSERT INTO `user_email_find_password` VALUES ('19045731888@masterlab.org', '0', 'PLAWGQD9JCHRUZLIOGVWOUW07LX3H1NA', '1553353040');
INSERT INTO `user_email_find_password` VALUES ('19064656538@masterlab.org', '0', 'GXYPZ3J16EJOAKQARET9WJ1VVYFUKDV3', '1535594723');
INSERT INTO `user_email_find_password` VALUES ('19079415780@masterlab.org', '0', '0KLYTRIWWYJBJDTZXGBHEEC7ME01XKKN', '1553353941');
INSERT INTO `user_email_find_password` VALUES ('465175275@qq.com', '0', 'QHJJWZZ4EC0WNMVPOGAXWWGEBL3GDLGX', '1523628463');

-- ----------------------------
-- Table structure for `user_email_token`
-- ----------------------------
DROP TABLE IF EXISTS `user_email_token`;
CREATE TABLE `user_email_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `expired` int(10) unsigned NOT NULL COMMENT '有效期',
  `created_at` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1-有效，0-无效',
  `used_model` varchar(255) NOT NULL DEFAULT '' COMMENT '用于哪个模型或功能',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_email_token
-- ----------------------------

-- ----------------------------
-- Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING HASH,
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES ('1', '0', '1');
INSERT INTO `user_group` VALUES ('2', '1', '1');

-- ----------------------------
-- Table structure for `user_ip_login_times`
-- ----------------------------
DROP TABLE IF EXISTS `user_ip_login_times`;
CREATE TABLE `user_ip_login_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `times` int(11) NOT NULL DEFAULT '0',
  `up_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_ip_login_times
-- ----------------------------

-- ----------------------------
-- Table structure for `user_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `user_login_log`;
CREATE TABLE `user_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(64) NOT NULL DEFAULT '',
  `token` varchar(128) DEFAULT '',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- ----------------------------
-- Records of user_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `user_main`
-- ----------------------------
DROP TABLE IF EXISTS `user_main`;
CREATE TABLE `user_main` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `directory_id` int(11) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `openid` varchar(32) NOT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '0 审核中;1 正常; 2 禁用',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `sex` tinyint(1) unsigned DEFAULT '0' COMMENT '1男2女',
  `birthday` varchar(20) DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `avatar` varchar(100) DEFAULT '',
  `source` varchar(20) DEFAULT '',
  `ios_token` varchar(128) DEFAULT NULL,
  `android_token` varchar(128) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `token` varchar(64) DEFAULT '',
  `last_login_time` int(11) unsigned DEFAULT '0',
  `is_system` tinyint(1) unsigned DEFAULT '0' COMMENT '是否系统自带的用户,不可删除',
  `login_counter` int(11) unsigned DEFAULT '0' COMMENT '登录次数',
  `title` varchar(32) DEFAULT NULL,
  `sign` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `openid` (`openid`),
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_main
-- ----------------------------
INSERT INTO `user_main` VALUES ('1', '1', '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', '1', '', 'master', 'Master', '18002510000@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', '1', '2019-01-13', '0', '0', '', '', null, null, null, null, '1548124754', '0', '0', '管理员', '~~~交付卓越产品!');

-- ----------------------------
-- Table structure for `user_message`
-- ----------------------------
DROP TABLE IF EXISTS `user_message`;
CREATE TABLE `user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_uid` int(11) unsigned NOT NULL,
  `sender_name` varchar(64) NOT NULL,
  `direction` smallint(4) unsigned NOT NULL,
  `receiver_uid` int(11) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `readed` tinyint(1) unsigned NOT NULL,
  `type` tinyint(2) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_message
-- ----------------------------

-- ----------------------------
-- Table structure for `user_password`
-- ----------------------------
DROP TABLE IF EXISTS `user_password`;
CREATE TABLE `user_password` (
  `user_id` int(11) unsigned NOT NULL,
  `hash` varchar(72) DEFAULT '' COMMENT 'password_hash()值',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_password
-- ----------------------------

-- ----------------------------
-- Table structure for `user_password_strategy`
-- ----------------------------
DROP TABLE IF EXISTS `user_password_strategy`;
CREATE TABLE `user_password_strategy` (
  `id` int(1) unsigned NOT NULL,
  `strategy` tinyint(1) unsigned DEFAULT NULL COMMENT '1允许所有密码;2不允许非常简单的密码;3要求强密码  关于安全密码策略',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_password_strategy
-- ----------------------------
INSERT INTO `user_password_strategy` VALUES ('1', '2');

-- ----------------------------
-- Table structure for `user_phone_find_password`
-- ----------------------------
DROP TABLE IF EXISTS `user_phone_find_password`;
CREATE TABLE `user_phone_find_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) NOT NULL,
  `verify_code` varchar(128) NOT NULL DEFAULT '',
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='找回密码表';

-- ----------------------------
-- Records of user_phone_find_password
-- ----------------------------

-- ----------------------------
-- Table structure for `user_posted_flag`
-- ----------------------------
DROP TABLE IF EXISTS `user_posted_flag`;
CREATE TABLE `user_posted_flag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `_date` date NOT NULL,
  `ip` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`_date`,`ip`),
  KEY `user_id_2` (`user_id`,`_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_posted_flag
-- ----------------------------

-- ----------------------------
-- Table structure for `user_refresh_token`
-- ----------------------------
DROP TABLE IF EXISTS `user_refresh_token`;
CREATE TABLE `user_refresh_token` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refresh_token` varchar(256) NOT NULL,
  `expire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `refresh_token` (`refresh_token`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户刷新的token表';

-- ----------------------------
-- Records of user_refresh_token
-- ----------------------------

-- ----------------------------
-- Table structure for `user_setting`
-- ----------------------------
DROP TABLE IF EXISTS `user_setting`;
CREATE TABLE `user_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `_key` varchar(64) DEFAULT NULL,
  `_value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`_key`),
  KEY `uid` (`user_id`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `user_token`
-- ----------------------------
DROP TABLE IF EXISTS `user_token`;
CREATE TABLE `user_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `token` varchar(255) NOT NULL DEFAULT '' COMMENT 'token',
  `token_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'token过期时间',
  `refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT '刷新token',
  `refresh_token_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '刷新token过期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_token
-- ----------------------------

-- ----------------------------
-- Table structure for `user_widget`
-- ----------------------------
DROP TABLE IF EXISTS `user_widget`;
CREATE TABLE `user_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `widget_id` int(11) NOT NULL COMMENT 'main_widget主键id',
  `order_weight` int(11) unsigned DEFAULT NULL COMMENT '工具顺序',
  `panel` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_saved_parameter` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否保存了过滤参数',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`widget_id`),
  KEY `order_weight` (`order_weight`)
) ENGINE=InnoDB AUTO_INCREMENT=873 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_widget
-- ----------------------------
INSERT INTO `user_widget` VALUES ('1', '0', '1', '1', 'first', '', '0');
INSERT INTO `user_widget` VALUES ('2', '0', '2', '2', 'first', '', '0');
INSERT INTO `user_widget` VALUES ('3', '0', '3', '3', 'first', '', '0');
INSERT INTO `user_widget` VALUES ('4', '0', '4', '1', 'second', '', '0');
INSERT INTO `user_widget` VALUES ('5', '0', '5', '2', 'second', '', '0');

-- ----------------------------
-- Table structure for `workflow`
-- ----------------------------
DROP TABLE IF EXISTS `workflow`;
CREATE TABLE `workflow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT '',
  `description` varchar(100) DEFAULT '',
  `create_uid` int(11) unsigned DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  `update_uid` int(11) unsigned DEFAULT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  `steps` tinyint(2) unsigned DEFAULT NULL,
  `data` text,
  `is_system` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow
-- ----------------------------
INSERT INTO `workflow` VALUES ('1', '默认工作流', '', '1', '0', null, '1539675295', null, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', '1');
INSERT INTO `workflow` VALUES ('2', '软件开发工作流', '针对软件开发的过程状态流', '1', null, null, '1529647857', null, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', '1');
INSERT INTO `workflow` VALUES ('3', 'Task工作流', '', '1', null, null, '1539675552', null, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', '1');
INSERT INTO `workflow` VALUES ('7', 'test-name-593514', 'test-description', '1', null, null, null, '0', '{}', '0');
INSERT INTO `workflow` VALUES ('13', 'test-name-364031', 'test-description', '1', null, null, null, '0', '{}', '0');
INSERT INTO `workflow` VALUES ('17', 'test-name-503829', 'test-description', '1', null, null, null, '0', '{}', '0');
INSERT INTO `workflow` VALUES ('20', 'test-name-141408', 'test-description', '1', null, null, null, '0', '{}', '0');
INSERT INTO `workflow` VALUES ('32', 'test-name-483150', 'test-description', '1', null, null, null, '0', '{}', '0');

-- ----------------------------
-- Table structure for `workflow_block`
-- ----------------------------
DROP TABLE IF EXISTS `workflow_block`;
CREATE TABLE `workflow_block` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) unsigned DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT NULL,
  `blcok_id` varchar(64) DEFAULT NULL,
  `position_x` smallint(4) unsigned DEFAULT NULL,
  `position_y` smallint(4) unsigned DEFAULT NULL,
  `inner_html` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_id` (`workflow_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_block
-- ----------------------------

-- ----------------------------
-- Table structure for `workflow_connector`
-- ----------------------------
DROP TABLE IF EXISTS `workflow_connector`;
CREATE TABLE `workflow_connector` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) unsigned DEFAULT NULL,
  `connector_id` varchar(32) DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL,
  `source_id` varchar(64) DEFAULT NULL,
  `target_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_id` (`workflow_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_connector
-- ----------------------------

-- ----------------------------
-- Table structure for `workflow_scheme`
-- ----------------------------
DROP TABLE IF EXISTS `workflow_scheme`;
CREATE TABLE `workflow_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10119 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_scheme
-- ----------------------------
INSERT INTO `workflow_scheme` VALUES ('1', '默认工作流方案', '', '1');
INSERT INTO `workflow_scheme` VALUES ('10100', '敏捷开发工作流方案', '敏捷开发适用', '1');
INSERT INTO `workflow_scheme` VALUES ('10101', '普通的软件开发工作流方案', '', '1');
INSERT INTO `workflow_scheme` VALUES ('10102', '流程管理工作流方案', '', '1');

-- ----------------------------
-- Table structure for `workflow_scheme_data`
-- ----------------------------
DROP TABLE IF EXISTS `workflow_scheme_data`;
CREATE TABLE `workflow_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) unsigned DEFAULT NULL,
  `issue_type_id` int(11) unsigned DEFAULT NULL,
  `workflow_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_scheme` (`scheme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10360 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_scheme_data
-- ----------------------------
INSERT INTO `workflow_scheme_data` VALUES ('10000', '1', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10105', '10100', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10200', '10200', '10105', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10201', '10200', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10202', '10201', '10105', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10203', '10201', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10300', '10300', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10307', '10307', '1', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10308', '10307', '2', '2');
INSERT INTO `workflow_scheme_data` VALUES ('10311', '10101', '2', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10312', '10101', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10319', '10305', '1', '2');
INSERT INTO `workflow_scheme_data` VALUES ('10320', '10305', '2', '2');
INSERT INTO `workflow_scheme_data` VALUES ('10321', '10305', '4', '2');
INSERT INTO `workflow_scheme_data` VALUES ('10322', '10305', '5', '2');
INSERT INTO `workflow_scheme_data` VALUES ('10323', '10102', '2', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10324', '10102', '0', '1');
INSERT INTO `workflow_scheme_data` VALUES ('10325', '10102', '10105', '1');
