/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : masterlab_pm

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-10-27 19:52:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for agile_board
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_board
-- ----------------------------
INSERT INTO `agile_board` VALUES ('1', 'Active Sprint', '0', null, '1', '1', '99999');
INSERT INTO `agile_board` VALUES ('2', 'LabelS', '10003', 'label', '1', '1', '0');

-- ----------------------------
-- Table structure for agile_board_column
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_board_column
-- ----------------------------
INSERT INTO `agile_board_column` VALUES ('1', 'Todo', '1', '[\"open\",\"reopen\",\"todo\",\"delay\"]', '3');
INSERT INTO `agile_board_column` VALUES ('2', 'In progress', '1', '[\"in_progress\",\"in_review\"]', '2');
INSERT INTO `agile_board_column` VALUES ('3', 'Done', '1', '[\"resolved\",\"closed\",\"done\"]', '1');
INSERT INTO `agile_board_column` VALUES ('4', 'Simple', '2', '[\"1\",\"2\"]', '0');
INSERT INTO `agile_board_column` VALUES ('5', 'Normal', '2', '[\"3\"]', '0');

-- ----------------------------
-- Table structure for agile_sprint
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of agile_sprint
-- ----------------------------
INSERT INTO `agile_sprint` VALUES ('1', '1', '第一次迭代', '', '1', '1', '0', '2018-09-14', '2018-09-30');
INSERT INTO `agile_sprint` VALUES ('2', '3', '第二次迭代', '', '1', '1', '0', '2018-10-10', '2018-10-19');

-- ----------------------------
-- Table structure for agile_sprint_issue_report
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
-- Table structure for field_custom_value
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
-- Table structure for field_layout_default
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
-- Table structure for field_layout_project_custom
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
-- Table structure for field_main
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

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
-- Table structure for field_type
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
-- Table structure for issue_assistant
-- ----------------------------
DROP TABLE IF EXISTS `issue_assistant`;
CREATE TABLE `issue_assistant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `join_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `issue_id` (`issue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_assistant
-- ----------------------------
INSERT INTO `issue_assistant` VALUES ('2', '3', '10000', '0');
INSERT INTO `issue_assistant` VALUES ('3', '27', '11655', '0');

-- ----------------------------
-- Table structure for issue_description_template
-- ----------------------------
DROP TABLE IF EXISTS `issue_description_template`;
CREATE TABLE `issue_description_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='新增事项时描述的模板';

-- ----------------------------
-- Records of issue_description_template
-- ----------------------------
INSERT INTO `issue_description_template` VALUES ('1', 'bug', '\r\n描述内容...\r\n\r\n## 重新步骤\r\n1. 步骤1\r\n\r\n2. 步骤2\r\n\r\n3. 步骤3\r\n\r\n## 期望结果 \r\n\r\n\r\n## 实际结果\r\n\r\n');
INSERT INTO `issue_description_template` VALUES ('2', '新功能', '\r\n一句话概括并描述新功能\r\n\r\n## 功能点：\r\n\r\n## 规则\r\n\r\n## 影响\r\n\r\n');

-- ----------------------------
-- Table structure for issue_field_layout_project
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
-- Table structure for issue_file_attachment
-- ----------------------------
DROP TABLE IF EXISTS `issue_file_attachment`;
CREATE TABLE `issue_file_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `issue_id` int(11) DEFAULT '0',
  `mime_type` varchar(64) DEFAULT '',
  `origin_name` varchar(128) NOT NULL DEFAULT '',
  `file_name` varchar(255) DEFAULT '',
  `created` int(11) DEFAULT '0',
  `file_size` int(11) DEFAULT '0',
  `author` int(11) DEFAULT '0',
  `file_ext` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `attach_issue` (`issue_id`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_file_attachment
-- ----------------------------
INSERT INTO `issue_file_attachment` VALUES ('103', 'uuid-712532', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535978581', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('104', 'uuid-993467', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535978581', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('105', 'uuid-772198', '17498', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535978645', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('106', 'uuid-146109', '17498', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535978645', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('107', 'uuid-465118', '17519', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535978896', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('108', 'uuid-59892', '17519', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535978896', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('115', 'uuid-277157', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535980570', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('116', 'uuid-146026', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535980570', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('117', 'uuid-975366', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535980625', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('118', 'uuid-833512', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535980625', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('121', 'uuid-511211', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535980688', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('122', 'uuid-763956', '0', 'image/png', 'sample.png', 'attached/unittest/sample.png', '1535980688', '44055', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('129', '', '0', 'application/octet-stream', '', 'all/20180903/20180903213321_46866.png', '1535981601', '0', '11159', 'png');
INSERT INTO `issue_file_attachment` VALUES ('132', '', '0', 'application/octet-stream', '', 'all/20180903/20180903213345_35880.png', '1535981625', '0', '11160', 'png');
INSERT INTO `issue_file_attachment` VALUES ('144', '0AiNJtaJ1qoS6LDe573167', '0', 'application/octet-stream', 'sample.png', 'all/20180903/20180903215007_66586.png', '1535982607', '0', '11164', 'png');
INSERT INTO `issue_file_attachment` VALUES ('181', '7kqrIJwuJAf8No7g804506', '0', 'application/octet-stream', 'sample.png', 'image/20180904/20180904104101_69813.png', '1536028861', '44055', '11177', 'png');
INSERT INTO `issue_file_attachment` VALUES ('183', 'ded1ff3e-d609-4b88-9bd2-6adad6108728', '18273', 'image/png', '1.png', 'all/20180909/20180909033816_97784.png', '1536435496', '899531', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('185', '47fd88aa-cd83-48ac-b98f-a6b670ae9944', '1', 'image/jpeg', 'timg.jpg', 'all/20180913/20180913001332_27981.jpg', '1536768812', '30069', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('186', '3f65aea2-1009-4bbf-9fe2-f4f25974ecb4', '2', 'image/jpeg', 'db.jpg', 'all/20180913/20180913001723_53905.jpg', '1536769043', '29271', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('187', '7da87baa-9435-4f00-aeba-459a7dff00c1', '0', 'image/jpeg', 'header.jpg', 'all/20180913/20180913103944_11662.jpg', '1536806384', '19282', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('188', '8d76f0a9-b9f5-4912-aa64-ff79d0b62eda', '0', 'image/jpeg', 'header.jpg', 'all/20180913/20180913104002_60614.jpg', '1536806402', '19282', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('189', '601ad8ec-f2de-4b82-9669-93a5d06db3bc', '0', 'image/jpeg', 'timg.jpg', 'avatar/20180913/20180913144720_35657.jpg', '1536821240', '10975', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('190', '313e6dc3-515c-4b1d-bcdf-cc8f2062dd3b', '0', 'image/jpeg', 'timg.jpg', 'avatar/20180913/20180913144752_28827.jpg', '1536821272', '10975', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('191', 'b33d72a9-0935-4101-89a8-9a739bdc469e', '0', 'image/jpeg', 'crm.jpg', 'avatar/20180913/20180913152541_67492.jpg', '1536823541', '35359', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('192', '30969360-9603-486f-a886-4cb469921486', '0', 'image/jpeg', 'crm.jpg', 'avatar/20180913/20180913152652_67614.jpg', '1536823612', '35359', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('193', 'a6637c2a-88ba-455c-a660-328302cd1c12', '0', 'image/jpeg', 'crm.jpg', 'avatar/20180913/20180913153035_77852.jpg', '1536823835', '12416', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('194', '5e654090-a516-41a5-b7cd-a04e2079de3d', '4', 'image/jpeg', '4fb349516dc14993d2303f42c87f1793.jpg', 'all/20180913/20180913185638_85846.jpg', '1536836198', '90410', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('195', '9b06bbad-50a9-4231-ba33-57b583a58719', '0', 'image/jpeg', 'logo.jpg', 'avatar/20181009/20181009205539_99679.jpg', '1539089739', '105843', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('196', '198a60d0-63e7-463c-94cd-232dd1f93d5f', '0', 'image/png', 'logo.png', 'avatar/20181009/20181009205544_24831.png', '1539089744', '30523', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('197', '1539091449052', '0', 'image/png', '1.png', 'image/20181009/20181009212502_76081.png', '1539091502', '54243', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('198', '9baddd10-0dff-4fbf-98fe-d5d0ff817c93', '9', 'image/png', '1.png', 'all/20181009/20181009212552_20118.png', '1539091552', '54243', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('199', 'c162ee06-df40-42be-942a-6fcdc5065141', '0', 'image/png', '1.png', 'all/20181009/20181009212614_72354.png', '1539091574', '54243', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('200', 'ceb7b4c2-e70f-4746-b41a-1f9cc3e3d6de', '13', 'image/png', '2.png', 'all/20181009/20181009214049_56753.png', '1539092449', '42886', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('201', '1539092453840', '0', 'image/png', '2.png', 'image/20181009/20181009214057_50420.png', '1539092457', '42886', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('202', '1539092839460', '0', 'image/png', '3.png', 'image/20181009/20181009214739_63122.png', '1539092859', '28888', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('203', '1539092911620', '0', 'image/png', '3.png', 'image/20181009/20181009214837_48090.png', '1539092917', '28888', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('205', '52364059-7774-48e8-929d-48a802015b75', '15', 'image/png', '5.png', 'all/20181009/20181009215507_33404.png', '1539093307', '34979', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('206', '4603e3e2-9c49-4fc3-98b6-05a5c819d657', '15', 'image/png', '4.png', 'all/20181009/20181009215509_35501.png', '1539093309', '60032', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('207', 'c67ccc5c-b296-481a-a0d8-5d94fa3256c3', '16', 'image/png', 'QQ浏览器截图20181010095012.png', 'all/20181010/20181010100815_36235.png', '1539137295', '94549', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('208', 'ac131ef5-2ec2-46dc-a924-c3fc1c833891', '18', 'image/png', 'QQ浏览器截图20181010095012.png', 'all/20181010/20181010100934_80087.png', '1539137374', '94549', '0', 'png');
INSERT INTO `issue_file_attachment` VALUES ('209', 'defc24a2-7fd1-45b8-8c63-eb3cd66a0389', '19', 'image/png', 'QQ浏览器截图20181010095012.png', 'all/20181010/20181010101443_67678.png', '1539137683', '94549', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('210', '741a5d95-fb2f-4b33-8ba0-7954f2727805', '20', 'image/png', '11.png', 'all/20181010/20181010110017_32707.png', '1539140417', '21097', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('211', 'c43981dc-f1e4-4285-b229-d6ba5d6d71e0', '21', 'image/png', '1.png', 'all/20181010/20181010110707_49925.png', '1539140827', '15472', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('212', 'c2cec963-4825-427f-bf0f-670532681519', '21', 'image/png', '2.png', 'all/20181010/20181010110710_33700.png', '1539140830', '34071', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('213', 'c221cdb6-1514-4733-afe6-31f7e840f2cd', '22', 'image/png', '3.png', 'all/20181010/20181010111515_91936.png', '1539141315', '37331', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('215', '55cb8cd4-1070-41d3-b5bd-90721ade9313', '33', 'image/png', '1.png', 'all/20181013/20181013170345_25108.png', '1539421425', '73592', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('216', 'c6d45b50-6b34-4e75-bad2-d11901c0c6b7', '0', 'image/png', '4.png', 'avatar/20181013/20181013174944_99998.png', '1539424184', '60032', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('217', '5cf03bca-7b92-4d46-b3eb-2e5343f04683', '0', 'image/png', 'logo.png', 'avatar/20181015/20181015102601_18003.png', '1539570361', '30523', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('218', 'b4713f66-717c-419a-b5b3-d492b3bdaa8e', '0', 'image/png', '快捷键.png', 'all/20181015/20181015181442_62320.png', '1539598482', '67056', '10000', 'png');
INSERT INTO `issue_file_attachment` VALUES ('219', 'e8db6fe3-54ea-4166-851e-3cd748b09e76', '0', 'image/jpeg', '0.jpg', 'all/20181016/20181016162653_79134.jpg', '1539678413', '22825', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('220', '333cb36f-ac36-4abd-92d2-a7139affeae5', '0', 'application/zip', '2017-02-19.zip', 'all/20181016/20181016162829_83890.zip', '1539678509', '953', '10000', 'zip');
INSERT INTO `issue_file_attachment` VALUES ('221', 'aa2e5da3-bb82-4a1d-bb9d-5ae6c47d2912', '0', 'image/jpeg', '阿里云幕布背景照.JPG', 'all/20181016/20181016163024_69184.jpg', '1539678624', '2125857', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('223', '6984f771-ce24-4763-b750-1d147574a409', '0', 'image/jpeg', 'crm.jpg', 'avatar/20181017/20181017180352_48634.jpg', '1539770632', '12416', '10000', 'jpg');
INSERT INTO `issue_file_attachment` VALUES ('224', '9736e657-a7bd-41de-801f-d69753b74939', '0', 'image/jpeg', '1-1F414120137.jpg', 'avatar/20181017/20181017180420_62985.jpg', '1539770660', '24383', '10000', 'jpg');

-- ----------------------------
-- Table structure for issue_filter
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
-- Table structure for issue_fix_version
-- ----------------------------
DROP TABLE IF EXISTS `issue_fix_version`;
CREATE TABLE `issue_fix_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `version_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_fix_version
-- ----------------------------
INSERT INTO `issue_fix_version` VALUES ('3', '16937', '9');
INSERT INTO `issue_fix_version` VALUES ('4', '16937', '10');
INSERT INTO `issue_fix_version` VALUES ('5', '18155', '75');
INSERT INTO `issue_fix_version` VALUES ('6', '18178', '76');
INSERT INTO `issue_fix_version` VALUES ('7', '18201', '77');
INSERT INTO `issue_fix_version` VALUES ('8', '18224', '78');
INSERT INTO `issue_fix_version` VALUES ('9', '18247', '79');
INSERT INTO `issue_fix_version` VALUES ('10', '18270', '80');
INSERT INTO `issue_fix_version` VALUES ('11', '18271', '0');
INSERT INTO `issue_fix_version` VALUES ('12', '18272', '4');
INSERT INTO `issue_fix_version` VALUES ('27', '18274', '3');
INSERT INTO `issue_fix_version` VALUES ('28', '18274', '4');

-- ----------------------------
-- Table structure for issue_follow
-- ----------------------------
DROP TABLE IF EXISTS `issue_follow`;
CREATE TABLE `issue_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `issue_id` (`issue_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_follow
-- ----------------------------
INSERT INTO `issue_follow` VALUES ('2', '38', '10000');
INSERT INTO `issue_follow` VALUES ('1', '16937', '10000');

-- ----------------------------
-- Table structure for issue_label
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
-- Table structure for issue_label_data
-- ----------------------------
DROP TABLE IF EXISTS `issue_label_data`;
CREATE TABLE `issue_label_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) unsigned DEFAULT NULL,
  `label_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_label_data
-- ----------------------------
INSERT INTO `issue_label_data` VALUES ('1', '16937', '1');
INSERT INTO `issue_label_data` VALUES ('2', '16937', '2');
INSERT INTO `issue_label_data` VALUES ('3', '17120', '296');
INSERT INTO `issue_label_data` VALUES ('4', '17141', '298');
INSERT INTO `issue_label_data` VALUES ('5', '17162', '300');
INSERT INTO `issue_label_data` VALUES ('6', '17183', '302');
INSERT INTO `issue_label_data` VALUES ('7', '17204', '304');
INSERT INTO `issue_label_data` VALUES ('8', '17225', '306');
INSERT INTO `issue_label_data` VALUES ('9', '17246', '308');
INSERT INTO `issue_label_data` VALUES ('10', '17267', '310');
INSERT INTO `issue_label_data` VALUES ('11', '17288', '312');
INSERT INTO `issue_label_data` VALUES ('12', '17309', '314');
INSERT INTO `issue_label_data` VALUES ('13', '17330', '316');
INSERT INTO `issue_label_data` VALUES ('14', '17351', '318');
INSERT INTO `issue_label_data` VALUES ('15', '17372', '320');
INSERT INTO `issue_label_data` VALUES ('16', '17393', '322');
INSERT INTO `issue_label_data` VALUES ('17', '17414', '324');
INSERT INTO `issue_label_data` VALUES ('18', '17435', '326');
INSERT INTO `issue_label_data` VALUES ('19', '17456', '328');
INSERT INTO `issue_label_data` VALUES ('20', '17477', '330');
INSERT INTO `issue_label_data` VALUES ('21', '17498', '332');
INSERT INTO `issue_label_data` VALUES ('22', '17519', '334');
INSERT INTO `issue_label_data` VALUES ('27', '18155', '396');
INSERT INTO `issue_label_data` VALUES ('28', '18178', '398');
INSERT INTO `issue_label_data` VALUES ('29', '18201', '400');
INSERT INTO `issue_label_data` VALUES ('30', '18224', '402');
INSERT INTO `issue_label_data` VALUES ('31', '18247', '404');
INSERT INTO `issue_label_data` VALUES ('32', '18271', '3');
INSERT INTO `issue_label_data` VALUES ('33', '18272', '2');
INSERT INTO `issue_label_data` VALUES ('34', '18274', '1');
INSERT INTO `issue_label_data` VALUES ('35', '18274', '2');

-- ----------------------------
-- Table structure for issue_main
-- ----------------------------
DROP TABLE IF EXISTS `issue_main`;
CREATE TABLE `issue_main` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pkey` varchar(32) DEFAULT NULL,
  `issue_num` varchar(64) DEFAULT NULL,
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
  `resolve_date` date DEFAULT NULL,
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) NOT NULL DEFAULT '',
  `master_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) unsigned DEFAULT '0' COMMENT '是否拥有子任务',
  PRIMARY KEY (`id`),
  KEY `issue_created` (`created`),
  KEY `issue_updated` (`updated`),
  KEY `issue_duedate` (`due_date`),
  KEY `issue_assignee` (`assignee`),
  KEY `issue_reporter` (`reporter`),
  KEY `pkey` (`pkey`),
  KEY `summary` (`summary`),
  KEY `backlog_weight` (`backlog_weight`),
  KEY `sprint_weight` (`sprint_weight`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_main
-- ----------------------------
INSERT INTO `issue_main` VALUES ('1', 'CRM', 'CRM1', '1', '1', '10000', '10000', '10000', '11652', '数据库设计', '1.第一步数据建模\r\n2.第二步ER图设计', 'windows', '1', '0', '6', '1536768829', '0', '2018-09-13', '2018-09-30', null, '3', null, '1', '0', '200000', '100000', '', '0', '0');
INSERT INTO `issue_main` VALUES ('2', 'CRM', 'CRM2', '1', '1', '10000', '10000', '10000', '11652', '数据库表设计', '1.\r\n2.\r\n3.', 'windows mysql', '1', '0', '6', '1536769063', '0', '2018-09-13', '2018-09-15', null, '1', null, '1', '0', '0', '200000', '', '0', '0');
INSERT INTO `issue_main` VALUES ('3', 'CRM', 'CRM3', '1', '1', '10000', '10000', '10000', '10000', '架构设计', '1.\r\n2.\r\n3.\r\n4.\r\n5.', '', '3', '10000', '1', '1536769153', '0', '2018-09-13', '2018-09-15', null, '2', null, '0', '0', '100000', '100000', '10000', '0', '0');
INSERT INTO `issue_main` VALUES ('4', 'ERP', 'ERP4', '2', '1', '10000', '0', '10000', '10000', '产品设计', '1.\r\n2.\r\n3.\r\n', '', '1', '0', '1', '1536836249', '0', '0000-00-00', '0000-00-00', null, '0', null, '0', '0', '100000', '0', '', '0', '0');

-- ----------------------------
-- Table structure for issue_moved_issue_key
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
INSERT INTO `issue_moved_issue_key` VALUES ('10100', 'SP-390', '13539');
INSERT INTO `issue_moved_issue_key` VALUES ('10101', 'SP-391', '13540');
INSERT INTO `issue_moved_issue_key` VALUES ('10200', 'ZZSJXC-69', '13600');
INSERT INTO `issue_moved_issue_key` VALUES ('10201', 'ZZSJXC-37', '13204');
INSERT INTO `issue_moved_issue_key` VALUES ('10202', 'ZZSJXC-41', '13213');
INSERT INTO `issue_moved_issue_key` VALUES ('10203', 'ZZSJXC-35', '13202');
INSERT INTO `issue_moved_issue_key` VALUES ('10204', 'ZZSJXC-76', '13721');
INSERT INTO `issue_moved_issue_key` VALUES ('10205', 'ZZSJXC-43', '13215');
INSERT INTO `issue_moved_issue_key` VALUES ('10206', 'ZZSJXC-36', '13203');
INSERT INTO `issue_moved_issue_key` VALUES ('10207', 'ZZSJXC-40', '13210');
INSERT INTO `issue_moved_issue_key` VALUES ('10208', 'ZZSJXC-68', '13599');
INSERT INTO `issue_moved_issue_key` VALUES ('10209', 'ZZSJXC-39', '13209');
INSERT INTO `issue_moved_issue_key` VALUES ('10210', 'ZZSJXC-78', '13789');
INSERT INTO `issue_moved_issue_key` VALUES ('10211', 'ZZSJXC-30', '13192');
INSERT INTO `issue_moved_issue_key` VALUES ('10212', 'ZZSJXC-31', '13193');
INSERT INTO `issue_moved_issue_key` VALUES ('10213', 'ZZSJXC-33', '13198');
INSERT INTO `issue_moved_issue_key` VALUES ('10214', 'ZZSJXC-28', '13130');
INSERT INTO `issue_moved_issue_key` VALUES ('10215', 'ZZSJXC-75', '13709');
INSERT INTO `issue_moved_issue_key` VALUES ('10216', 'ZZSJXC-67', '13598');
INSERT INTO `issue_moved_issue_key` VALUES ('10217', 'ZZSJXC-34', '13200');
INSERT INTO `issue_moved_issue_key` VALUES ('10218', 'ZZSJXC-64', '13588');
INSERT INTO `issue_moved_issue_key` VALUES ('10219', 'ZZSJXC-38', '13205');
INSERT INTO `issue_moved_issue_key` VALUES ('10220', 'ZZSJXC-63', '13581');
INSERT INTO `issue_moved_issue_key` VALUES ('10221', 'ZZSJXC-74', '13708');
INSERT INTO `issue_moved_issue_key` VALUES ('10222', 'ZZSJXC-66', '13597');
INSERT INTO `issue_moved_issue_key` VALUES ('10223', 'ZZSJXC-42', '13214');
INSERT INTO `issue_moved_issue_key` VALUES ('10224', 'ZZSJXC-29', '13191');
INSERT INTO `issue_moved_issue_key` VALUES ('10225', 'ZZSJXC-62', '13580');
INSERT INTO `issue_moved_issue_key` VALUES ('10226', 'ZZSJXC-32', '13195');
INSERT INTO `issue_moved_issue_key` VALUES ('10227', 'ZZSJXC-65', '13593');
INSERT INTO `issue_moved_issue_key` VALUES ('10228', 'ZZSJXC-48', '13549');
INSERT INTO `issue_moved_issue_key` VALUES ('10229', 'ZZSJXC-46', '13547');
INSERT INTO `issue_moved_issue_key` VALUES ('10230', 'ZZSJXC-55', '13556');
INSERT INTO `issue_moved_issue_key` VALUES ('10231', 'ZZSJXC-51', '13552');
INSERT INTO `issue_moved_issue_key` VALUES ('10232', 'ZZSJXC-60', '13561');
INSERT INTO `issue_moved_issue_key` VALUES ('10233', 'ZZSJXC-54', '13555');
INSERT INTO `issue_moved_issue_key` VALUES ('10234', 'ZZSJXC-50', '13551');
INSERT INTO `issue_moved_issue_key` VALUES ('10235', 'ZZSJXC-58', '13559');
INSERT INTO `issue_moved_issue_key` VALUES ('10236', 'ZZSJXC-53', '13554');
INSERT INTO `issue_moved_issue_key` VALUES ('10237', 'ZZSJXC-56', '13557');
INSERT INTO `issue_moved_issue_key` VALUES ('10238', 'ZZSJXC-44', '13545');
INSERT INTO `issue_moved_issue_key` VALUES ('10239', 'ZZSJXC-72', '13631');
INSERT INTO `issue_moved_issue_key` VALUES ('10240', 'ZZSJXC-71', '13630');
INSERT INTO `issue_moved_issue_key` VALUES ('10241', 'ZZSJXC-57', '13558');
INSERT INTO `issue_moved_issue_key` VALUES ('10242', 'ZZSJXC-45', '13546');
INSERT INTO `issue_moved_issue_key` VALUES ('10243', 'ZZSJXC-59', '13560');
INSERT INTO `issue_moved_issue_key` VALUES ('10244', 'ZZSJXC-47', '13548');
INSERT INTO `issue_moved_issue_key` VALUES ('10245', 'ZZSJXC-77', '13730');
INSERT INTO `issue_moved_issue_key` VALUES ('10246', 'ZZSJXC-70', '13629');
INSERT INTO `issue_moved_issue_key` VALUES ('10247', 'ZZSJXC-49', '13550');
INSERT INTO `issue_moved_issue_key` VALUES ('10248', 'ZZSJXC-73', '13707');
INSERT INTO `issue_moved_issue_key` VALUES ('10249', 'ZZSJXC-61', '13562');
INSERT INTO `issue_moved_issue_key` VALUES ('10250', 'ZZSJXC-52', '13553');
INSERT INTO `issue_moved_issue_key` VALUES ('10251', 'ZUAN-152', '12501');
INSERT INTO `issue_moved_issue_key` VALUES ('10252', 'ZUAN-172', '12641');
INSERT INTO `issue_moved_issue_key` VALUES ('10253', 'ZUAN-63', '12176');
INSERT INTO `issue_moved_issue_key` VALUES ('10254', 'ZUAN-76', '12190');
INSERT INTO `issue_moved_issue_key` VALUES ('10255', 'ZUAN-31', '12137');
INSERT INTO `issue_moved_issue_key` VALUES ('10256', 'ZUAN-93', '12306');
INSERT INTO `issue_moved_issue_key` VALUES ('10257', 'ZUAN-75', '12189');
INSERT INTO `issue_moved_issue_key` VALUES ('10258', 'ZUAN-171', '12640');
INSERT INTO `issue_moved_issue_key` VALUES ('10259', 'ZUAN-122', '12452');
INSERT INTO `issue_moved_issue_key` VALUES ('10260', 'ZUAN-145', '12482');
INSERT INTO `issue_moved_issue_key` VALUES ('10261', 'ZUAN-127', '12457');
INSERT INTO `issue_moved_issue_key` VALUES ('10262', 'ZUAN-29', '12135');
INSERT INTO `issue_moved_issue_key` VALUES ('10263', 'ZUAN-128', '12458');
INSERT INTO `issue_moved_issue_key` VALUES ('10264', 'ZUAN-104', '12412');
INSERT INTO `issue_moved_issue_key` VALUES ('10265', 'ZUAN-30', '12136');
INSERT INTO `issue_moved_issue_key` VALUES ('10266', 'ZUAN-134', '12466');
INSERT INTO `issue_moved_issue_key` VALUES ('10267', 'ZUAN-105', '12413');
INSERT INTO `issue_moved_issue_key` VALUES ('10268', 'ZUAN-62', '12175');
INSERT INTO `issue_moved_issue_key` VALUES ('10269', 'ZUAN-158', '12627');
INSERT INTO `issue_moved_issue_key` VALUES ('10270', 'ZUAN-169', '12638');
INSERT INTO `issue_moved_issue_key` VALUES ('10271', 'ZUAN-58', '12170');
INSERT INTO `issue_moved_issue_key` VALUES ('10272', 'ZUAN-163', '12632');
INSERT INTO `issue_moved_issue_key` VALUES ('10273', 'ZUAN-21', '12126');
INSERT INTO `issue_moved_issue_key` VALUES ('10274', 'ZUAN-24', '12129');
INSERT INTO `issue_moved_issue_key` VALUES ('10275', 'ZUAN-92', '12305');
INSERT INTO `issue_moved_issue_key` VALUES ('10276', 'ZUAN-111', '12437');
INSERT INTO `issue_moved_issue_key` VALUES ('10277', 'ZUAN-149', '12495');
INSERT INTO `issue_moved_issue_key` VALUES ('10278', 'ZUAN-96', '12309');
INSERT INTO `issue_moved_issue_key` VALUES ('10279', 'ZUAN-97', '12310');
INSERT INTO `issue_moved_issue_key` VALUES ('10280', 'ZUAN-90', '12303');
INSERT INTO `issue_moved_issue_key` VALUES ('10281', 'ZUAN-59', '12172');
INSERT INTO `issue_moved_issue_key` VALUES ('10282', 'ZUAN-48', '12160');
INSERT INTO `issue_moved_issue_key` VALUES ('10283', 'ZUAN-77', '12191');
INSERT INTO `issue_moved_issue_key` VALUES ('10284', 'ZUAN-46', '12158');
INSERT INTO `issue_moved_issue_key` VALUES ('10285', 'ZUAN-170', '12639');
INSERT INTO `issue_moved_issue_key` VALUES ('10286', 'ZUAN-176', '12748');
INSERT INTO `issue_moved_issue_key` VALUES ('10287', 'ZUAN-119', '12449');
INSERT INTO `issue_moved_issue_key` VALUES ('10288', 'ZUAN-89', '12302');
INSERT INTO `issue_moved_issue_key` VALUES ('10289', 'ZUAN-68', '12182');
INSERT INTO `issue_moved_issue_key` VALUES ('10290', 'ZUAN-174', '12746');
INSERT INTO `issue_moved_issue_key` VALUES ('10291', 'ZUAN-87', '12300');
INSERT INTO `issue_moved_issue_key` VALUES ('10292', 'ZUAN-74', '12188');
INSERT INTO `issue_moved_issue_key` VALUES ('10293', 'ZUAN-38', '12144');
INSERT INTO `issue_moved_issue_key` VALUES ('10294', 'ZUAN-49', '12161');
INSERT INTO `issue_moved_issue_key` VALUES ('10295', 'ZUAN-146', '12483');
INSERT INTO `issue_moved_issue_key` VALUES ('10296', 'ZUAN-95', '12308');
INSERT INTO `issue_moved_issue_key` VALUES ('10297', 'ZUAN-64', '12177');
INSERT INTO `issue_moved_issue_key` VALUES ('10298', 'ZUAN-80', '12194');
INSERT INTO `issue_moved_issue_key` VALUES ('10299', 'ZUAN-115', '12442');
INSERT INTO `issue_moved_issue_key` VALUES ('10300', 'ZUAN-113', '12440');
INSERT INTO `issue_moved_issue_key` VALUES ('10301', 'ZUAN-98', '12311');
INSERT INTO `issue_moved_issue_key` VALUES ('10302', 'ZUAN-37', '12143');
INSERT INTO `issue_moved_issue_key` VALUES ('10303', 'ZUAN-57', '12169');
INSERT INTO `issue_moved_issue_key` VALUES ('10304', 'ZUAN-151', '12497');
INSERT INTO `issue_moved_issue_key` VALUES ('10305', 'ZUAN-109', '12432');
INSERT INTO `issue_moved_issue_key` VALUES ('10306', 'ZUAN-44', '12155');
INSERT INTO `issue_moved_issue_key` VALUES ('10307', 'ZUAN-138', '12471');
INSERT INTO `issue_moved_issue_key` VALUES ('10308', 'ZUAN-54', '12166');
INSERT INTO `issue_moved_issue_key` VALUES ('10309', 'ZUAN-141', '12476');
INSERT INTO `issue_moved_issue_key` VALUES ('10310', 'ZUAN-140', '12474');
INSERT INTO `issue_moved_issue_key` VALUES ('10311', 'ZUAN-126', '12456');
INSERT INTO `issue_moved_issue_key` VALUES ('10312', 'ZUAN-45', '12156');
INSERT INTO `issue_moved_issue_key` VALUES ('10313', 'ZUAN-81', '12195');
INSERT INTO `issue_moved_issue_key` VALUES ('10314', 'ZUAN-71', '12185');
INSERT INTO `issue_moved_issue_key` VALUES ('10315', 'ZUAN-91', '12304');
INSERT INTO `issue_moved_issue_key` VALUES ('10316', 'ZUAN-73', '12187');
INSERT INTO `issue_moved_issue_key` VALUES ('10317', 'ZUAN-108', '12431');
INSERT INTO `issue_moved_issue_key` VALUES ('10318', 'ZUAN-153', '12505');
INSERT INTO `issue_moved_issue_key` VALUES ('10319', 'ZUAN-129', '12459');
INSERT INTO `issue_moved_issue_key` VALUES ('10320', 'ZUAN-35', '12141');
INSERT INTO `issue_moved_issue_key` VALUES ('10321', 'ZUAN-60', '12173');
INSERT INTO `issue_moved_issue_key` VALUES ('10322', 'ZUAN-135', '12467');
INSERT INTO `issue_moved_issue_key` VALUES ('10323', 'ZUAN-139', '12472');
INSERT INTO `issue_moved_issue_key` VALUES ('10324', 'ZUAN-39', '12145');
INSERT INTO `issue_moved_issue_key` VALUES ('10325', 'ZUAN-160', '12629');
INSERT INTO `issue_moved_issue_key` VALUES ('10326', 'ZUAN-143', '12478');
INSERT INTO `issue_moved_issue_key` VALUES ('10327', 'ZUAN-94', '12307');
INSERT INTO `issue_moved_issue_key` VALUES ('10328', 'ZUAN-130', '12460');
INSERT INTO `issue_moved_issue_key` VALUES ('10329', 'ZUAN-82', '12196');
INSERT INTO `issue_moved_issue_key` VALUES ('10330', 'ZUAN-103', '12411');
INSERT INTO `issue_moved_issue_key` VALUES ('10331', 'ZUAN-69', '12183');
INSERT INTO `issue_moved_issue_key` VALUES ('10332', 'ZUAN-114', '12441');
INSERT INTO `issue_moved_issue_key` VALUES ('10333', 'ZUAN-132', '12464');
INSERT INTO `issue_moved_issue_key` VALUES ('10334', 'ZUAN-56', '12168');
INSERT INTO `issue_moved_issue_key` VALUES ('10335', 'ZUAN-53', '12165');
INSERT INTO `issue_moved_issue_key` VALUES ('10336', 'ZUAN-79', '12193');
INSERT INTO `issue_moved_issue_key` VALUES ('10337', 'ZUAN-123', '12453');
INSERT INTO `issue_moved_issue_key` VALUES ('10338', 'ZUAN-110', '12436');
INSERT INTO `issue_moved_issue_key` VALUES ('10339', 'ZUAN-25', '12130');
INSERT INTO `issue_moved_issue_key` VALUES ('10340', 'ZUAN-36', '12142');
INSERT INTO `issue_moved_issue_key` VALUES ('10341', 'ZUAN-99', '12312');
INSERT INTO `issue_moved_issue_key` VALUES ('10342', 'ZUAN-27', '12133');
INSERT INTO `issue_moved_issue_key` VALUES ('10343', 'ZUAN-162', '12631');
INSERT INTO `issue_moved_issue_key` VALUES ('10344', 'ZUAN-133', '12465');
INSERT INTO `issue_moved_issue_key` VALUES ('10345', 'ZUAN-150', '12496');
INSERT INTO `issue_moved_issue_key` VALUES ('10346', 'ZUAN-165', '12634');
INSERT INTO `issue_moved_issue_key` VALUES ('10347', 'ZUAN-40', '12146');
INSERT INTO `issue_moved_issue_key` VALUES ('10348', 'ZUAN-52', '12164');
INSERT INTO `issue_moved_issue_key` VALUES ('10349', 'ZUAN-101', '12402');
INSERT INTO `issue_moved_issue_key` VALUES ('10350', 'ZUAN-124', '12454');
INSERT INTO `issue_moved_issue_key` VALUES ('10351', 'ZUAN-47', '12159');
INSERT INTO `issue_moved_issue_key` VALUES ('10352', 'ZUAN-177', '12749');
INSERT INTO `issue_moved_issue_key` VALUES ('10353', 'ZUAN-102', '12406');
INSERT INTO `issue_moved_issue_key` VALUES ('10354', 'ZUAN-42', '12149');
INSERT INTO `issue_moved_issue_key` VALUES ('10355', 'ZUAN-43', '12153');
INSERT INTO `issue_moved_issue_key` VALUES ('10356', 'ZUAN-136', '12468');
INSERT INTO `issue_moved_issue_key` VALUES ('10357', 'ZUAN-142', '12477');
INSERT INTO `issue_moved_issue_key` VALUES ('10358', 'ZUAN-166', '12635');
INSERT INTO `issue_moved_issue_key` VALUES ('10359', 'ZUAN-117', '12444');
INSERT INTO `issue_moved_issue_key` VALUES ('10360', 'ZUAN-144', '12481');
INSERT INTO `issue_moved_issue_key` VALUES ('10361', 'ZUAN-175', '12747');
INSERT INTO `issue_moved_issue_key` VALUES ('10362', 'ZUAN-168', '12637');
INSERT INTO `issue_moved_issue_key` VALUES ('10363', 'ZUAN-78', '12192');
INSERT INTO `issue_moved_issue_key` VALUES ('10364', 'ZUAN-33', '12139');
INSERT INTO `issue_moved_issue_key` VALUES ('10365', 'ZUAN-112', '12439');
INSERT INTO `issue_moved_issue_key` VALUES ('10366', 'ZUAN-159', '12628');
INSERT INTO `issue_moved_issue_key` VALUES ('10367', 'ZUAN-50', '12162');
INSERT INTO `issue_moved_issue_key` VALUES ('10368', 'ZUAN-55', '12167');
INSERT INTO `issue_moved_issue_key` VALUES ('10369', 'ZUAN-161', '12630');
INSERT INTO `issue_moved_issue_key` VALUES ('10370', 'ZUAN-84', '12198');
INSERT INTO `issue_moved_issue_key` VALUES ('10371', 'ZUAN-120', '12450');
INSERT INTO `issue_moved_issue_key` VALUES ('10372', 'ZUAN-32', '12138');
INSERT INTO `issue_moved_issue_key` VALUES ('10373', 'ZUAN-51', '12163');
INSERT INTO `issue_moved_issue_key` VALUES ('10374', 'ZUAN-173', '12642');
INSERT INTO `issue_moved_issue_key` VALUES ('10375', 'ZUAN-23', '12128');
INSERT INTO `issue_moved_issue_key` VALUES ('10376', 'ZUAN-41', '12147');
INSERT INTO `issue_moved_issue_key` VALUES ('10377', 'ZUAN-70', '12184');
INSERT INTO `issue_moved_issue_key` VALUES ('10378', 'ZUAN-83', '12197');
INSERT INTO `issue_moved_issue_key` VALUES ('10379', 'ZUAN-155', '12554');
INSERT INTO `issue_moved_issue_key` VALUES ('10380', 'ZUAN-118', '12448');
INSERT INTO `issue_moved_issue_key` VALUES ('10381', 'ZUAN-147', '12484');
INSERT INTO `issue_moved_issue_key` VALUES ('10382', 'ZUAN-125', '12455');
INSERT INTO `issue_moved_issue_key` VALUES ('10383', 'ZUAN-28', '12134');
INSERT INTO `issue_moved_issue_key` VALUES ('10384', 'ZUAN-67', '12181');
INSERT INTO `issue_moved_issue_key` VALUES ('10385', 'ZUAN-61', '12174');
INSERT INTO `issue_moved_issue_key` VALUES ('10386', 'ZUAN-164', '12633');
INSERT INTO `issue_moved_issue_key` VALUES ('10387', 'ZUAN-178', '12750');
INSERT INTO `issue_moved_issue_key` VALUES ('10388', 'ZUAN-22', '12127');
INSERT INTO `issue_moved_issue_key` VALUES ('10389', 'ZUAN-157', '12626');
INSERT INTO `issue_moved_issue_key` VALUES ('10390', 'ZUAN-167', '12636');
INSERT INTO `issue_moved_issue_key` VALUES ('10391', 'ZUAN-88', '12301');
INSERT INTO `issue_moved_issue_key` VALUES ('10392', 'ZUAN-107', '12430');
INSERT INTO `issue_moved_issue_key` VALUES ('10393', 'ZUAN-100', '12401');
INSERT INTO `issue_moved_issue_key` VALUES ('10394', 'ZUAN-34', '12140');
INSERT INTO `issue_moved_issue_key` VALUES ('10395', 'ZUAN-65', '12178');
INSERT INTO `issue_moved_issue_key` VALUES ('10396', 'ZUAN-20', '12125');
INSERT INTO `issue_moved_issue_key` VALUES ('10397', 'ZUAN-137', '12469');
INSERT INTO `issue_moved_issue_key` VALUES ('10398', 'ZUAN-148', '12485');
INSERT INTO `issue_moved_issue_key` VALUES ('10399', 'ZUAN-121', '12451');
INSERT INTO `issue_moved_issue_key` VALUES ('10400', 'ZUAN-26', '12132');
INSERT INTO `issue_moved_issue_key` VALUES ('10401', 'ZUAN-72', '12186');
INSERT INTO `issue_moved_issue_key` VALUES ('10402', 'ZUAN-66', '12180');
INSERT INTO `issue_moved_issue_key` VALUES ('10403', 'ZUAN-9', '12097');
INSERT INTO `issue_moved_issue_key` VALUES ('10404', 'ZUAN-16', '12104');
INSERT INTO `issue_moved_issue_key` VALUES ('10405', 'ZUAN-19', '12107');
INSERT INTO `issue_moved_issue_key` VALUES ('10406', 'ZUAN-14', '12102');
INSERT INTO `issue_moved_issue_key` VALUES ('10407', 'ZUAN-18', '12106');
INSERT INTO `issue_moved_issue_key` VALUES ('10408', 'ZUAN-15', '12103');
INSERT INTO `issue_moved_issue_key` VALUES ('10409', 'ZUAN-6', '12094');
INSERT INTO `issue_moved_issue_key` VALUES ('10410', 'ZUAN-1', '12089');
INSERT INTO `issue_moved_issue_key` VALUES ('10411', 'ZUAN-12', '12100');
INSERT INTO `issue_moved_issue_key` VALUES ('10412', 'ZUAN-7', '12095');
INSERT INTO `issue_moved_issue_key` VALUES ('10413', 'ZUAN-10', '12098');
INSERT INTO `issue_moved_issue_key` VALUES ('10414', 'ZUAN-8', '12096');
INSERT INTO `issue_moved_issue_key` VALUES ('10415', 'ZUAN-2', '12090');
INSERT INTO `issue_moved_issue_key` VALUES ('10416', 'ZUAN-4', '12092');
INSERT INTO `issue_moved_issue_key` VALUES ('10417', 'ZUAN-85', '12199');
INSERT INTO `issue_moved_issue_key` VALUES ('10418', 'ZUAN-5', '12093');
INSERT INTO `issue_moved_issue_key` VALUES ('10419', 'ZUAN-86', '12200');
INSERT INTO `issue_moved_issue_key` VALUES ('10420', 'ZUAN-3', '12091');
INSERT INTO `issue_moved_issue_key` VALUES ('10421', 'ZUAN-11', '12099');
INSERT INTO `issue_moved_issue_key` VALUES ('10422', 'ZUAN-13', '12101');
INSERT INTO `issue_moved_issue_key` VALUES ('10423', 'ZUAN-17', '12105');
INSERT INTO `issue_moved_issue_key` VALUES ('10424', 'ZUAN-154', '12512');
INSERT INTO `issue_moved_issue_key` VALUES ('10425', 'ZUAN-131', '12461');
INSERT INTO `issue_moved_issue_key` VALUES ('10426', 'ZUAN-116', '12443');
INSERT INTO `issue_moved_issue_key` VALUES ('10427', 'ZUAN-106', '12414');
INSERT INTO `issue_moved_issue_key` VALUES ('10428', 'ZUAN-156', '12558');
INSERT INTO `issue_moved_issue_key` VALUES ('10429', 'GEETOOL-7', '12692');
INSERT INTO `issue_moved_issue_key` VALUES ('10430', 'GEETOOL-30', '12715');
INSERT INTO `issue_moved_issue_key` VALUES ('10431', 'GEETOOL-6', '12691');
INSERT INTO `issue_moved_issue_key` VALUES ('10432', 'GEETOOL-34', '12723');
INSERT INTO `issue_moved_issue_key` VALUES ('10433', 'GEETOOL-37', '12730');
INSERT INTO `issue_moved_issue_key` VALUES ('10434', 'GEETOOL-33', '12722');
INSERT INTO `issue_moved_issue_key` VALUES ('10435', 'GEETOOL-3', '12688');
INSERT INTO `issue_moved_issue_key` VALUES ('10436', 'GEETOOL-5', '12690');
INSERT INTO `issue_moved_issue_key` VALUES ('10437', 'GEETOOL-32', '12717');
INSERT INTO `issue_moved_issue_key` VALUES ('10438', 'GEETOOL-13', '12698');
INSERT INTO `issue_moved_issue_key` VALUES ('10439', 'GEETOOL-15', '12700');
INSERT INTO `issue_moved_issue_key` VALUES ('10440', 'GEETOOL-26', '12711');
INSERT INTO `issue_moved_issue_key` VALUES ('10441', 'GEETOOL-2', '12687');
INSERT INTO `issue_moved_issue_key` VALUES ('10442', 'GEETOOL-11', '12696');
INSERT INTO `issue_moved_issue_key` VALUES ('10443', 'GEETOOL-40', '12737');
INSERT INTO `issue_moved_issue_key` VALUES ('10444', 'GEETOOL-42', '12755');
INSERT INTO `issue_moved_issue_key` VALUES ('10445', 'GEETOOL-17', '12702');
INSERT INTO `issue_moved_issue_key` VALUES ('10446', 'GEETOOL-1', '12685');
INSERT INTO `issue_moved_issue_key` VALUES ('10447', 'GEETOOL-18', '12703');
INSERT INTO `issue_moved_issue_key` VALUES ('10448', 'GEETOOL-16', '12701');
INSERT INTO `issue_moved_issue_key` VALUES ('10449', 'GEETOOL-36', '12726');
INSERT INTO `issue_moved_issue_key` VALUES ('10450', 'GEETOOL-19', '12704');
INSERT INTO `issue_moved_issue_key` VALUES ('10451', 'GEETOOL-35', '12725');
INSERT INTO `issue_moved_issue_key` VALUES ('10452', 'GEETOOL-24', '12709');
INSERT INTO `issue_moved_issue_key` VALUES ('10453', 'GEETOOL-12', '12697');
INSERT INTO `issue_moved_issue_key` VALUES ('10454', 'GEETOOL-25', '12710');
INSERT INTO `issue_moved_issue_key` VALUES ('10455', 'GEETOOL-14', '12699');
INSERT INTO `issue_moved_issue_key` VALUES ('10456', 'GEETOOL-20', '12705');
INSERT INTO `issue_moved_issue_key` VALUES ('10457', 'GEETOOL-27', '12712');
INSERT INTO `issue_moved_issue_key` VALUES ('10458', 'GEETOOL-38', '12731');
INSERT INTO `issue_moved_issue_key` VALUES ('10459', 'GEETOOL-41', '12754');
INSERT INTO `issue_moved_issue_key` VALUES ('10460', 'GEETOOL-21', '12706');
INSERT INTO `issue_moved_issue_key` VALUES ('10461', 'GEETOOL-45', '13739');
INSERT INTO `issue_moved_issue_key` VALUES ('10462', 'GEETOOL-4', '12689');
INSERT INTO `issue_moved_issue_key` VALUES ('10463', 'GEETOOL-29', '12714');
INSERT INTO `issue_moved_issue_key` VALUES ('10464', 'GEETOOL-28', '12713');
INSERT INTO `issue_moved_issue_key` VALUES ('10465', 'GEETOOL-44', '12758');
INSERT INTO `issue_moved_issue_key` VALUES ('10466', 'GEETOOL-43', '12757');
INSERT INTO `issue_moved_issue_key` VALUES ('10467', 'GEETOOL-10', '12695');
INSERT INTO `issue_moved_issue_key` VALUES ('10468', 'GEETOOL-39', '12735');
INSERT INTO `issue_moved_issue_key` VALUES ('10469', 'GEETOOL-31', '12716');
INSERT INTO `issue_moved_issue_key` VALUES ('10470', 'GEETOOL-22', '12707');
INSERT INTO `issue_moved_issue_key` VALUES ('10471', 'GEETOOL-8', '12693');
INSERT INTO `issue_moved_issue_key` VALUES ('10472', 'GEETOOL-23', '12708');
INSERT INTO `issue_moved_issue_key` VALUES ('10473', 'GEETOOL-9', '12694');
INSERT INTO `issue_moved_issue_key` VALUES ('10474', 'DC-149', '14194');

-- ----------------------------
-- Table structure for issue_priority
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_priority
-- ----------------------------
INSERT INTO `issue_priority` VALUES ('1', '1', '紧 急', 'very_import', '阻塞开发或测试的工作进度，或影响系统无法运行的错误', '/images/icons/priorities/blocker.png', 'red', null, '0');
INSERT INTO `issue_priority` VALUES ('2', '2', '重 要', 'import', '系统崩溃，丢失数据或内存溢出等严重错误、或者必需完成的任务', '/images/icons/priorities/critical.png', '#cc0000', null, '0');
INSERT INTO `issue_priority` VALUES ('3', '3', '高', 'high', '主要的功能无效或流程异常', '/images/icons/priorities/major.png', '#ff0000', null, '0');
INSERT INTO `issue_priority` VALUES ('4', '4', '中', 'normal', '功能部分无效或对现有系统的改进', '/images/icons/priorities/minor.png', '#006600', null, '0');
INSERT INTO `issue_priority` VALUES ('5', '5', '低', 'low', '不影响功能和流程的问题', '/images/icons/priorities/trivial.png', '#003300', null, '0');

-- ----------------------------
-- Table structure for issue_recycle
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_recycle
-- ----------------------------

-- ----------------------------
-- Table structure for issue_resolve
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
) ENGINE=InnoDB AUTO_INCREMENT=10102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_resolve
-- ----------------------------
INSERT INTO `issue_resolve` VALUES ('1', '1', '已修复', 'fixed', '事项已经解决', null, '#1aaa55', '0');
INSERT INTO `issue_resolve` VALUES ('2', '2', '不能修复', 'not_fix', '事项未解决', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('3', '3', '需要重现', 'require_duplicate', '事项需要的描述需要有重现步骤', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('4', '4', '信息不完整', 'not_complete', '事项信息描述不完整', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('5', '5', '不能重现', 'not_reproduce', '事项不能重现', null, '#db3b21', '0');
INSERT INTO `issue_resolve` VALUES ('10000', '6', '完成', 'done', '事项已经解决并确认了', null, '#1aaa55', '0');
INSERT INTO `issue_resolve` VALUES ('10100', '8', '问题不存在', 'issue_not_exists', '事项不存在', null, 'rgba(0,0,0,0.85)', '0');
INSERT INTO `issue_resolve` VALUES ('10101', '9', '延迟处理', 'delay', '事项将推迟处理', null, 'rgba(0,0,0,0.85)', '0');

-- ----------------------------
-- Table structure for issue_status
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
) ENGINE=InnoDB AUTO_INCREMENT=10101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_status
-- ----------------------------
INSERT INTO `issue_status` VALUES ('1', '1', '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', '0', 'info');
INSERT INTO `issue_status` VALUES ('3', '3', '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', '0', 'primary');
INSERT INTO `issue_status` VALUES ('4', '4', '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', '0', 'warning');
INSERT INTO `issue_status` VALUES ('5', '5', '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', '1', 'success');
INSERT INTO `issue_status` VALUES ('6', '6', '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', '0', 'success');
INSERT INTO `issue_status` VALUES ('10001', '8', '完 成', 'done', '事项已经已经被开发人员处理完，但需要被产品或测试人员确认', '/', '0', 'info');
INSERT INTO `issue_status` VALUES ('10002', '9', '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', '0', 'info');
INSERT INTO `issue_status` VALUES ('10100', '10', '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', '0', 'info');

-- ----------------------------
-- Table structure for issue_type
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_type
-- ----------------------------
INSERT INTO `issue_type` VALUES ('1', '1', 'Bug', 'bug', 'Standard', '测试过程、维护过程发现影响系统运行的缺陷', 'fa-bug', null, '1', '0');
INSERT INTO `issue_type` VALUES ('2', '2', '新功能', 'new_feature', 'Standard', '对系统提出的新功能', 'fa-plus', null, '1', '0');
INSERT INTO `issue_type` VALUES ('3', '3', '任务', 'task', 'Standard', '需要完成的任务', 'fa-tasks', null, '1', '0');
INSERT INTO `issue_type` VALUES ('4', '4', '优化改进', 'improve', 'Standard', '对现有系统功能的改进', 'fa-arrow-circle-o-up', null, '1', '0');
INSERT INTO `issue_type` VALUES ('5', '0', '子任务', 'child_task', 'Standard', '', 'fa-subscript', null, '1', '0');
INSERT INTO `issue_type` VALUES ('6', '2', '用户故事', 'user_story', 'Scrum', '从用户的角度来描述用户渴望得到的功能。一个好的用户故事包括三个要素：1. 角色；2. 活动　3. 商业价值', 'fa-users', null, '1', '0');
INSERT INTO `issue_type` VALUES ('7', '3', '技术任务', 'tech_task', 'Scrum', '技术性的任务,如架构设计,数据库选型', 'fa-cogs', null, '1', '0');
INSERT INTO `issue_type` VALUES ('8', '5', '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', null, '1', '0');

-- ----------------------------
-- Table structure for issue_type_scheme
-- ----------------------------
DROP TABLE IF EXISTS `issue_type_scheme`;
CREATE TABLE `issue_type_scheme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `is_default` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='问题方案表';

-- ----------------------------
-- Records of issue_type_scheme
-- ----------------------------
INSERT INTO `issue_type_scheme` VALUES ('1', '默认事项方案', '系统默认的事项方案,但没有设定或事项错误时使用该方案', '1');
INSERT INTO `issue_type_scheme` VALUES ('2', '敏捷开发事项方案', '敏捷开发适用的方案', '1');
INSERT INTO `issue_type_scheme` VALUES ('3', '瀑布模型的事项方案', '普通的软件开发流程', '1');
INSERT INTO `issue_type_scheme` VALUES ('4', '流程管理事项方案', '针对软件开发的', '0');
INSERT INTO `issue_type_scheme` VALUES ('5', '任务管理事项解决方案', '任务管理', '0');

-- ----------------------------
-- Table structure for issue_type_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `issue_type_scheme_data`;
CREATE TABLE `issue_type_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) unsigned DEFAULT NULL,
  `type_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scheme_id` (`scheme_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8 COMMENT='问题方案字表';

-- ----------------------------
-- Records of issue_type_scheme_data
-- ----------------------------
INSERT INTO `issue_type_scheme_data` VALUES ('3', '3', '1');
INSERT INTO `issue_type_scheme_data` VALUES ('17', '4', '10000');
INSERT INTO `issue_type_scheme_data` VALUES ('19', '5', '5');
INSERT INTO `issue_type_scheme_data` VALUES ('20', '5', '10002');
INSERT INTO `issue_type_scheme_data` VALUES ('21', '5', '10106');
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
-- Table structure for issue_ui
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
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=utf8;

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
INSERT INTO `issue_ui` VALUES ('437', '4', 'edit', '1', '14', '0');
INSERT INTO `issue_ui` VALUES ('438', '4', 'edit', '6', '13', '0');
INSERT INTO `issue_ui` VALUES ('439', '4', 'edit', '2', '12', '0');
INSERT INTO `issue_ui` VALUES ('440', '4', 'edit', '7', '11', '0');
INSERT INTO `issue_ui` VALUES ('441', '4', 'edit', '9', '10', '0');
INSERT INTO `issue_ui` VALUES ('442', '4', 'edit', '8', '9', '0');
INSERT INTO `issue_ui` VALUES ('443', '4', 'edit', '3', '8', '0');
INSERT INTO `issue_ui` VALUES ('444', '4', 'edit', '4', '7', '0');
INSERT INTO `issue_ui` VALUES ('445', '4', 'edit', '19', '6', '0');
INSERT INTO `issue_ui` VALUES ('446', '4', 'edit', '10', '5', '0');
INSERT INTO `issue_ui` VALUES ('447', '4', 'edit', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('448', '4', 'edit', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('449', '4', 'edit', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('450', '4', 'edit', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('451', '4', 'edit', '20', '0', '0');
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
INSERT INTO `issue_ui` VALUES ('692', '1', 'edit', '1', '10', '0');
INSERT INTO `issue_ui` VALUES ('693', '1', 'edit', '6', '9', '0');
INSERT INTO `issue_ui` VALUES ('694', '1', 'edit', '2', '8', '0');
INSERT INTO `issue_ui` VALUES ('695', '1', 'edit', '7', '7', '0');
INSERT INTO `issue_ui` VALUES ('696', '1', 'edit', '8', '6', '0');
INSERT INTO `issue_ui` VALUES ('697', '1', 'edit', '4', '5', '0');
INSERT INTO `issue_ui` VALUES ('698', '1', 'edit', '19', '4', '0');
INSERT INTO `issue_ui` VALUES ('699', '1', 'edit', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('700', '1', 'edit', '12', '2', '0');
INSERT INTO `issue_ui` VALUES ('701', '1', 'edit', '13', '1', '0');
INSERT INTO `issue_ui` VALUES ('702', '1', 'edit', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('703', '1', 'edit', '3', '4', '40');
INSERT INTO `issue_ui` VALUES ('704', '1', 'edit', '9', '3', '40');
INSERT INTO `issue_ui` VALUES ('705', '1', 'edit', '20', '2', '40');
INSERT INTO `issue_ui` VALUES ('706', '1', 'edit', '10', '1', '40');
INSERT INTO `issue_ui` VALUES ('707', '1', 'edit', '21', '0', '40');
INSERT INTO `issue_ui` VALUES ('708', '1', 'create', '1', '10', '0');
INSERT INTO `issue_ui` VALUES ('709', '1', 'create', '6', '9', '0');
INSERT INTO `issue_ui` VALUES ('710', '1', 'create', '2', '8', '0');
INSERT INTO `issue_ui` VALUES ('711', '1', 'create', '7', '7', '0');
INSERT INTO `issue_ui` VALUES ('712', '1', 'create', '8', '6', '0');
INSERT INTO `issue_ui` VALUES ('713', '1', 'create', '9', '5', '0');
INSERT INTO `issue_ui` VALUES ('714', '1', 'create', '4', '4', '0');
INSERT INTO `issue_ui` VALUES ('715', '1', 'create', '11', '3', '0');
INSERT INTO `issue_ui` VALUES ('716', '1', 'create', '12', '2', '0');
INSERT INTO `issue_ui` VALUES ('717', '1', 'create', '13', '1', '0');
INSERT INTO `issue_ui` VALUES ('718', '1', 'create', '15', '0', '0');
INSERT INTO `issue_ui` VALUES ('719', '1', 'create', '19', '4', '41');
INSERT INTO `issue_ui` VALUES ('720', '1', 'create', '20', '3', '41');
INSERT INTO `issue_ui` VALUES ('721', '1', 'create', '3', '2', '41');
INSERT INTO `issue_ui` VALUES ('722', '1', 'create', '10', '1', '41');
INSERT INTO `issue_ui` VALUES ('723', '1', 'create', '21', '0', '41');
INSERT INTO `issue_ui` VALUES ('788', '2', 'create', '1', '10', '0');
INSERT INTO `issue_ui` VALUES ('789', '2', 'create', '6', '9', '0');
INSERT INTO `issue_ui` VALUES ('790', '2', 'create', '2', '8', '0');
INSERT INTO `issue_ui` VALUES ('791', '2', 'create', '7', '7', '0');
INSERT INTO `issue_ui` VALUES ('792', '2', 'create', '8', '6', '0');
INSERT INTO `issue_ui` VALUES ('793', '2', 'create', '4', '5', '0');
INSERT INTO `issue_ui` VALUES ('794', '2', 'create', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('795', '2', 'create', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('796', '2', 'create', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('797', '2', 'create', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('798', '2', 'create', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('799', '2', 'create', '19', '4', '46');
INSERT INTO `issue_ui` VALUES ('800', '2', 'create', '10', '3', '46');
INSERT INTO `issue_ui` VALUES ('801', '2', 'create', '20', '2', '46');
INSERT INTO `issue_ui` VALUES ('802', '2', 'create', '9', '1', '46');
INSERT INTO `issue_ui` VALUES ('803', '2', 'create', '3', '0', '46');
INSERT INTO `issue_ui` VALUES ('818', '2', 'edit', '1', '10', '0');
INSERT INTO `issue_ui` VALUES ('819', '2', 'edit', '6', '9', '0');
INSERT INTO `issue_ui` VALUES ('820', '2', 'edit', '2', '8', '0');
INSERT INTO `issue_ui` VALUES ('821', '2', 'edit', '7', '7', '0');
INSERT INTO `issue_ui` VALUES ('822', '2', 'edit', '8', '6', '0');
INSERT INTO `issue_ui` VALUES ('823', '2', 'edit', '4', '5', '0');
INSERT INTO `issue_ui` VALUES ('824', '2', 'edit', '11', '4', '0');
INSERT INTO `issue_ui` VALUES ('825', '2', 'edit', '12', '3', '0');
INSERT INTO `issue_ui` VALUES ('826', '2', 'edit', '13', '2', '0');
INSERT INTO `issue_ui` VALUES ('827', '2', 'edit', '15', '1', '0');
INSERT INTO `issue_ui` VALUES ('828', '2', 'edit', '21', '0', '0');
INSERT INTO `issue_ui` VALUES ('829', '2', 'edit', '19', '4', '48');
INSERT INTO `issue_ui` VALUES ('830', '2', 'edit', '10', '3', '48');
INSERT INTO `issue_ui` VALUES ('831', '2', 'edit', '20', '2', '48');
INSERT INTO `issue_ui` VALUES ('832', '2', 'edit', '9', '1', '48');
INSERT INTO `issue_ui` VALUES ('833', '2', 'edit', '3', '0', '48');
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

-- ----------------------------
-- Table structure for issue_ui_tab
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of issue_ui_tab
-- ----------------------------
INSERT INTO `issue_ui_tab` VALUES ('7', '10', 'test-name-24019', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('8', '11', 'test-name-53500', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('33', '6', '更多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('34', '6', '\n            \n            更多\n             \n            \n        \n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('37', '7', '更 多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('38', '7', '\n            \n            更 多\n             \n            \n        \n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('40', '1', '\n            更 多\n             \n            \n        ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('41', '1', '更 多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('46', '2', '更 多', '0', 'create');
INSERT INTO `issue_ui_tab` VALUES ('48', '2', '\n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n  ', '0', 'edit');
INSERT INTO `issue_ui_tab` VALUES ('49', '3', '\n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        ', '0', 'edit');

-- ----------------------------
-- Table structure for job_run_details
-- ----------------------------
DROP TABLE IF EXISTS `job_run_details`;
CREATE TABLE `job_run_details` (
  `id` decimal(18,0) NOT NULL,
  `job_id` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `run_duration` decimal(18,0) DEFAULT NULL,
  `run_outcome` char(1) DEFAULT NULL,
  `info_message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rundetails_jobid_idx` (`job_id`),
  KEY `rundetails_starttime_idx` (`start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of job_run_details
-- ----------------------------

-- ----------------------------
-- Table structure for log_base
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

-- ----------------------------
-- Records of log_base
-- ----------------------------
INSERT INTO `log_base` VALUES ('31', '0', '日志', '0', '10000', 'cdwei', '韦朝夺', 'issuse', null, null, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1536425345,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1536425355,\"f3\":\"google\"}', 'unknown', '1536425355');

-- ----------------------------
-- Table structure for log_operating
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
) ENGINE=InnoDB AUTO_INCREMENT=553 DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

-- ----------------------------
-- Records of log_operating
-- ----------------------------

-- ----------------------------
-- Table structure for main_action
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
-- Table structure for main_activity
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
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_activity
-- ----------------------------

-- ----------------------------
-- Table structure for main_announcement
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
INSERT INTO `main_announcement` VALUES ('1', 'wwwwwwwwwwwwww', '1', '3', '1539682929');

-- ----------------------------
-- Table structure for main_cache_key
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
INSERT INTO `main_cache_key` VALUES ('1', 'list', null, null);
INSERT INTO `main_cache_key` VALUES ('2', 'list', null, null);
INSERT INTO `main_cache_key` VALUES ('3', 'lsit', null, null);

-- ----------------------------
-- Table structure for main_eventtype
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
-- Table structure for main_group
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
-- Table structure for main_mailserver
-- ----------------------------
DROP TABLE IF EXISTS `main_mailserver`;
CREATE TABLE `main_mailserver` (
  `id` decimal(18,0) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `mailfrom` varchar(255) DEFAULT NULL,
  `prefix` varchar(60) DEFAULT NULL,
  `smtp_port` varchar(60) DEFAULT NULL,
  `protocol` varchar(60) DEFAULT NULL,
  `server_type` varchar(60) DEFAULT NULL,
  `servername` varchar(255) DEFAULT NULL,
  `jndilocation` varchar(255) DEFAULT NULL,
  `mailusername` varchar(255) DEFAULT NULL,
  `mailpassword` varchar(255) DEFAULT NULL,
  `istlsrequired` varchar(60) DEFAULT NULL,
  `timeout` decimal(18,0) DEFAULT NULL,
  `socks_port` varchar(60) DEFAULT NULL,
  `socks_host` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_mailserver
-- ----------------------------
INSERT INTO `main_mailserver` VALUES ('10000', '邮件发送服务', '', 'ismond@vip.163.com', 'Masterlab', '25', 'smtp', 'smtp', 'smtp.vip.163.com', null, 'xxxx@vip.163.com', 'xxxx', 'false', '10000', null, null);

-- ----------------------------
-- Table structure for main_mail_queue
-- ----------------------------
DROP TABLE IF EXISTS `main_mail_queue`;
CREATE TABLE `main_mail_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  `error` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_mail_queue
-- ----------------------------
INSERT INTO `main_mail_queue` VALUES ('1', '(BTOB-1142) 去除退货完成对应货品变为在售的逻辑', '121@qq.com', 'ready', null, null);
INSERT INTO `main_mail_queue` VALUES ('2', '(SSZBD-642) 商品新添加库存时，上传的图片默认为试戴图', '121@qq.com', 'ready', null, null);
INSERT INTO `main_mail_queue` VALUES ('3', '(BTOB-1143) 【定制BOM】toprings最闪婚戒排行榜店铺款式数据、工费方案、钻石价方案导入', '121@qq.com', 'done', null, null);
INSERT INTO `main_mail_queue` VALUES ('4', '(SSZBD-622) 没有权限打折的员工，在选择折扣后没有提示，只有在提交订单时才提示', '1xx@qq.com', 'ready', null, null);
INSERT INTO `main_mail_queue` VALUES ('6', '(SDX-650) 销售倍率，\"使用分类倍率\"不填，却提示\"倍率为数字并大于0\"', 'xxxx@qq.com', null, null, null);
INSERT INTO `main_mail_queue` VALUES ('7', '(SDX-648) 销售-销售倍率，配置时出错，见描述', null, null, null, null);
INSERT INTO `main_mail_queue` VALUES ('8', '(SSZBD-604) 支付的订金小于50%时，没有给出相应提示。可以正常下单x', null, null, null, null);
INSERT INTO `main_mail_queue` VALUES ('9', '(SSZBD-604) 支付的订金小于50%时，没有给出相应提示。可以正常下单', null, null, null, null);
INSERT INTO `main_mail_queue` VALUES ('16', 'test-title', 'test-address', 'ready', '1536336902', '');

-- ----------------------------
-- Table structure for main_org
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_org
-- ----------------------------
INSERT INTO `main_org` VALUES ('1', 'default', 'Default', 'Default organization', 'all/20180826/20180826140421_58245.jpg', '0', '0', '1535263464', '3');
INSERT INTO `main_org` VALUES ('2', 'ismond', 'Agile', '敏捷开发部', 'all/20180826/20180826140446_89680.jpg', '10000', '0', '1535263488', '1');

-- ----------------------------
-- Table structure for main_setting
-- ----------------------------
DROP TABLE IF EXISTS `main_setting`;
CREATE TABLE `main_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_key` varchar(50) NOT NULL COMMENT '关键字',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块,basic,advance,ui,datetime,languge,attachment可选',
  `_value` varchar(100) NOT NULL,
  `default_value` varchar(100) DEFAULT '' COMMENT '默认值',
  `format` enum('string','int','float','json') NOT NULL DEFAULT 'string' COMMENT '数据类型',
  `form_input_type` enum('datetime','date','textarea','select','checkbox','radio','img','color','file','int','number','text') DEFAULT 'text' COMMENT '表单项类型',
  `form_optional_value` varchar(5000) DEFAULT NULL COMMENT '待选的值定义,为json格式',
  `description` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `_key` (`_key`),
  KEY `module` (`module`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of main_setting
-- ----------------------------
INSERT INTO `main_setting` VALUES ('1', 'title', '标题', 'basic', 'MasterLab', 'Hornet', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('2', 'open_status', '启用状态', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('3', 'max_login_error', '最大尝试验证登录次数', 'basic', '4', '4', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('4', 'login_require_captcha', '登录时需要验证码', 'basic', '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('5', 'reg_require_captcha', '注册时需要验证码', 'basic', '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('6', 'sender_format', '邮件发件人显示格式', 'basic', '${fullname} (Hornet)', '${fullname} (Hornet)', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('7', 'description', '说明', 'basic', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('8', 'date_timezone', '默认用户时区', 'basic', 'Asia/Shanghai', 'Asia/Shanghai', 'string', 'text', '[\"Asia/Shanghai\":\"\"]', '');
INSERT INTO `main_setting` VALUES ('11', 'allow_share_public', '允许用户分享过滤器或面部', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('12', 'max_project_name', '项目名称最大长度', 'basic', '80', '80', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('13', 'max_project_key', '项目键值最大长度', 'basic', '20', '20', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('15', 'email_public', '邮件地址可见性', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('20', 'allow_gravatars', '允许使用Gravatars用户头像', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES ('21', 'gravatar_server', 'Gravatar服务器', 'basic', '', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('24', 'send_mail_format', '默认发送个邮件的格式', 'user_default', 'html', 'text', 'string', 'radio', '{\"text\":\"text\",\"html\":\"html\"}', '');
INSERT INTO `main_setting` VALUES ('25', 'issue_page_size', '问题导航每页显示的问题数量', 'user_default', '100', '100', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('39', 'time_format', '时间格式', 'datetime', 'HH:mm:ss', 'HH:mm:ss', 'string', 'text', null, '例如 11:55:47');
INSERT INTO `main_setting` VALUES ('40', 'week_format', '星期格式', 'datetime', 'EEEE HH:mm:ss', 'EEEE HH:mm:ss', 'string', 'text', null, '例如 Wednesday 11:55:47');
INSERT INTO `main_setting` VALUES ('41', 'full_datetime_format', '完整日期/时间格式', 'datetime', 'yyyy-MM-dd  HH:mm:ss', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', null, '例如 2007-05-23  11:55:47');
INSERT INTO `main_setting` VALUES ('42', 'datetime_format', '日期格式(年月日)', 'datetime', 'yyyy-MM-dd', 'yyyy-MM-dd', 'string', 'text', null, '例如 2007-05-23');
INSERT INTO `main_setting` VALUES ('43', 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天');
INSERT INTO `main_setting` VALUES ('45', 'attachment_dir', '附件路径', 'attachment', '{{STORAGE_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', null, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下');
INSERT INTO `main_setting` VALUES ('46', 'attachment_size', '附件大小(单位M)', 'attachment', '10.0', '10.0', 'float', 'text', null, '超过大小，无法上传');
INSERT INTO `main_setting` VALUES ('47', 'enbale_thum', '启用缩略图', 'attachment', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图');
INSERT INTO `main_setting` VALUES ('48', 'enable_zip', '启用ZIP支持', 'attachment', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载');
INSERT INTO `main_setting` VALUES ('49', 'password_strategy', '密码策略', 'password_strategy', '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', '');
INSERT INTO `main_setting` VALUES ('50', 'send_mailer', '发信人', 'mail', 'ismond@vip.163.com', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('51', 'mail_prefix', '前缀', 'mail', 'Hornet', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('52', 'mail_host', '主机', 'mail', 'smtp.vip.163.com', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('53', 'mail_port', 'SMTP端口', 'mail', '25', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('54', 'mail_account', '账号', 'mail', 'ismond@vip.163.com', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('55', 'mail_password', '密码', 'mail', 'ismond163vip', '', 'string', 'text', null, '');
INSERT INTO `main_setting` VALUES ('56', 'mail_timeout', '发送超时', 'mail', '20', '', 'int', 'text', null, '');
INSERT INTO `main_setting` VALUES ('57', 'page_layout', '页面布局', 'user_default', 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', '');
INSERT INTO `main_setting` VALUES ('58', 'project_view', '项目首页', 'user_default', 'issues', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', '');

-- ----------------------------
-- Table structure for main_timeline
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_timeline
-- ----------------------------
INSERT INTO `main_timeline` VALUES ('1', '10000', 'issue', '0', '0', '16936', 'added ', '', 'added\r\n    <a href=\"/ismond/xphp/issues?label_name=Error\" data-original=\"~9\" data-link=\"false\" data-project=\"31\" data-label=\"9\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n        <span class=\"label color-label has-tooltip\" style=\"background-color: #FF0000; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"red waring\">Error</span></a>\r\n    <a href=\"/ismond/xphp/issues?label_name=Success\" data-original=\"~11\" data-link=\"false\" data-project=\"31\" data-label=\"11\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n        <span class=\"label color-label has-tooltip\" style=\"background-color: #69D100; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"\">Success</span></a>\r\n    <a href=\"/ismond/xphp/issues?label_name=Warn\" data-original=\"~10\" data-link=\"false\" data-project=\"31\" data-label=\"10\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n        <span class=\"label color-label has-tooltip\" style=\"background-color: #F0AD4E; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"Warning\">Warn</span></a>labels', '', '0');
INSERT INTO `main_timeline` VALUES ('2', '10000', 'issue', '0', '0', '16936', 'added ', '', 'added\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Error\" data-original=\"~9\" data-link=\"false\" data-project=\"31\" data-label=\"9\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #FF0000; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"red waring\">Error</span></a>\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Success\" data-original=\"~11\" data-link=\"false\" data-project=\"31\" data-label=\"11\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #69D100; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"\">Success</span></a>\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Warn\" data-original=\"~10\" data-link=\"false\" data-project=\"31\" data-label=\"10\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #F0AD4E; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"Warning\">Warn</span></a>labels', '', '0');
INSERT INTO `main_timeline` VALUES ('3', '10000', 'issue', '0', '0', '16936', 'removed', '', 'removed\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Success\" data-original=\"~11\" data-link=\"false\" data-project=\"31\" data-label=\"11\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #69D100; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"\">Success</span></a>label', '', '0');
INSERT INTO `main_timeline` VALUES ('4', '10000', 'issue', '0', '0', '16936', 'changed ', '', 'changed milestone to\r\n                                                                    <a href=\"/ismond/xphp/milestones/1\" data-original=\"%1\" data-link=\"false\" data-project=\"31\" data-milestone=\"1\" data-reference-type=\"milestone\" title=\"\" class=\"gfm gfm-milestone has-tooltip\" data-original-title=\"\">New Milestone</a>', '', '0');
INSERT INTO `main_timeline` VALUES ('5', '10000', 'issue', '0', '0', '16936', 'commented', '', 'commented', '<a class=\"no-attachment-icon\" href=\"http://192.168.3.213/ismond/xphp/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg\" target=\"_blank\" rel=\"noopener noreferrer\"><img src=\"http://192.168.3.213/ismond/xphp/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg\" alt=\"28186ee2d4c9536d2e009848b96765e6\">                             </a>', '1522224215');
INSERT INTO `main_timeline` VALUES ('6', '10000', 'issue', '0', '0', '16936', 'commented+reopened', '', 'commented+reopened', '', '1522224230');
INSERT INTO `main_timeline` VALUES ('7', '10000', 'issue', '0', '0', '16936', 'commented', '', 'dfdsf', 'false', '1522400161');
INSERT INTO `main_timeline` VALUES ('8', '10000', 'issue', '0', '0', '16936', 'commented', '', '![](http://wx.888zb.com/attachment/image/20180725/20180725004731_90568.jpg)', '<p><img src=\"http://wx.888zb.com/attachment/image/20180725/20180725004731_90568.jpg\" alt=\"\"></p>\n', '1532450854');
INSERT INTO `main_timeline` VALUES ('9', '11186', 'issue', '0', '0', '18291', 'commented+reopened', '', 'test-content', 'test-content-html', '1536050994');
INSERT INTO `main_timeline` VALUES ('10', '11187', 'issue', '0', '0', '18313', 'commented', '', 'test-content-updated', '', '1536051019');
INSERT INTO `main_timeline` VALUES ('11', '11188', 'issue', '0', '0', '18335', 'commented', '', 'test-content-updated', '', '1536051036');
INSERT INTO `main_timeline` VALUES ('12', '11189', 'issue', '0', '0', '18357', 'commented', '', 'test-content-updated', '', '1536051063');
INSERT INTO `main_timeline` VALUES ('13', '11190', 'issue', '0', '0', '18379', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051118');
INSERT INTO `main_timeline` VALUES ('14', '11191', 'issue', '0', '0', '18401', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051146');
INSERT INTO `main_timeline` VALUES ('15', '11192', 'issue', '0', '0', '18423', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051176');
INSERT INTO `main_timeline` VALUES ('16', '11193', 'issue', '0', '0', '18445', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051186');
INSERT INTO `main_timeline` VALUES ('17', '11194', 'issue', '0', '0', '18467', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051220');
INSERT INTO `main_timeline` VALUES ('18', '11195', 'issue', '0', '0', '18489', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051227');
INSERT INTO `main_timeline` VALUES ('19', '11196', 'issue', '0', '0', '18511', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051244');
INSERT INTO `main_timeline` VALUES ('20', '11197', 'issue', '0', '0', '18533', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051267');
INSERT INTO `main_timeline` VALUES ('21', '11198', 'issue', '0', '0', '18555', 'commented', '', 'test-content-updated', 'test-content-html-updated', '1536051294');
INSERT INTO `main_timeline` VALUES ('23', '11657', 'issue', '0', '0', '28', 'commented', '', '模块的新增、修改、删除已添加操作日志', '<p>模块的新增、修改、删除已添加操作日志</p>\n', '1539571207');
INSERT INTO `main_timeline` VALUES ('24', '11657', 'issue', '0', '0', '28', 'commented', '', '版本的新增、修改、删除、发布已添加操作日志', '<p>版本的新增、修改、删除、发布已添加操作日志</p>\n', '1539595779');
INSERT INTO `main_timeline` VALUES ('25', '11657', 'issue', '0', '0', '28', 'commented', '', '标签的新增、修改、删除、发布已添加操作日志', '<p>标签的新增、修改、删除、发布已添加操作日志</p>\n', '1539661250');
INSERT INTO `main_timeline` VALUES ('26', '11657', 'issue', '0', '0', '28', 'commented', '', '项目角色的新增、修改、删除、发布已添加操作日志', '<p>项目角色的新增、修改、删除、发布已添加操作日志</p>\n', '1539661256');
INSERT INTO `main_timeline` VALUES ('27', '10000', 'issue', '0', '0', '39', 'commented', '', '111111', '<p>111111</p>\n', '1539766355');

-- ----------------------------
-- Table structure for permission
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
INSERT INTO `permission` VALUES ('10005', '0', '访问事项列表', '', 'BROWSE_ISSUES');
INSERT INTO `permission` VALUES ('10006', '0', '创建事项', '', 'CREATE_ISSUES');
INSERT INTO `permission` VALUES ('10007', '0', '评论', '', 'ADD_COMMENTS');
INSERT INTO `permission` VALUES ('10008', '0', '上传附件', '', 'CREATE_ATTACHMENTS');
INSERT INTO `permission` VALUES ('10013', '0', '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES');
INSERT INTO `permission` VALUES ('10014', '0', '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES');
INSERT INTO `permission` VALUES ('10015', '0', '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES');
INSERT INTO `permission` VALUES ('10028', '0', '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS');
INSERT INTO `permission` VALUES ('10902', '0', '管理backlog', '', 'MANAGE_BACKLOG');
INSERT INTO `permission` VALUES ('10903', '0', '管理sprint', '', 'MANAGE_SPRINT');
INSERT INTO `permission` VALUES ('10904', '0', '管理kanban', null, 'MANAGE_KANBAN');

-- ----------------------------
-- Table structure for permission_default_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_default_role`;
CREATE TABLE `permission_default_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT '0' COMMENT '如果为0表示系统初始化的角色，不为0表示某一项目特有的角色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=utf8 COMMENT='项目角色表';

-- ----------------------------
-- Records of permission_default_role
-- ----------------------------
INSERT INTO `permission_default_role` VALUES ('10000', 'Users', 'A project role that represents users in a project', '0');
INSERT INTO `permission_default_role` VALUES ('10001', 'Developers', 'A project role that represents developers in a project', '0');
INSERT INTO `permission_default_role` VALUES ('10002', 'Administrators', 'A project role that represents administrators in a project', '0');
INSERT INTO `permission_default_role` VALUES ('10003', 'QA', null, '0');
INSERT INTO `permission_default_role` VALUES ('10006', 'PO', null, '0');

-- ----------------------------
-- Table structure for permission_default_role_relation
-- ----------------------------
DROP TABLE IF EXISTS `permission_default_role_relation`;
CREATE TABLE `permission_default_role_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `default_role_id` int(11) unsigned DEFAULT NULL,
  `perm_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `default_role_id` (`default_role_id`) USING HASH,
  KEY `role_id-and-perm_id` (`default_role_id`,`perm_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

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
-- Table structure for permission_global
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
-- Table structure for permission_global_group
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_group`;
CREATE TABLE `permission_global_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `perm_global_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perm_global_id` (`perm_global_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission_global_group
-- ----------------------------
INSERT INTO `permission_global_group` VALUES ('1', '10000', '1');
INSERT INTO `permission_global_group` VALUES ('2', '10000', '2');
INSERT INTO `permission_global_group` VALUES ('7', '10000', '3');

-- ----------------------------
-- Table structure for permission_global_relation
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
-- Table structure for project_category
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
-- Table structure for project_flag
-- ----------------------------
DROP TABLE IF EXISTS `project_flag`;
CREATE TABLE `project_flag` (
  `id` int(11) unsigned NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `flag` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `update_time` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_flag
-- ----------------------------
INSERT INTO `project_flag` VALUES ('2', '10003', 'backlog_weight', '{\"16938\":100000}', '1532778917');
INSERT INTO `project_flag` VALUES ('4', '10004', 'backlog_weight', '{\"14278\":5700000,\"14100\":5600000,\"14062\":5500000,\"13889\":5400000,\"13706\":5300000,\"13262\":5200000,\"13235\":5100000,\"12598\":5000000,\"12555\":4900000,\"12515\":4800000,\"12201\":4700000,\"10202\":4600000,\"10117\":4500000,\"16841\":4400000,\"16830\":4300000,\"16829\":4200000,\"16824\":4100000,\"16815\":4000000,\"16550\":3900000,\"16494\":3800000,\"16446\":3700000,\"16420\":3600000,\"15951\":3500000,\"15828\":3400000,\"15815\":3300000,\"14207\":3200000,\"13891\":3100000,\"13601\":3000000,\"13220\":2900000,\"13212\":2800000,\"12809\":2700000,\"12756\":2600000,\"12753\":2500000,\"12741\":2400000,\"12684\":2300000,\"11400\":2200000,\"11298\":2100000,\"11168\":2000000,\"11167\":1900000,\"10204\":1800000,\"10203\":1700000,\"10123\":1600000,\"10118\":1500000,\"10116\":1400000,\"10111\":1300000,\"10110\":1200000,\"10109\":1100000,\"10107\":1000000,\"10106\":900000,\"10104\":800000,\"10103\":700000,\"16700\":600000,\"13222\":500000,\"12736\":400000,\"12724\":300000,\"12607\":200000,\"10850\":100000}', '1533047447');
INSERT INTO `project_flag` VALUES ('9', '10400', 'backlog_weight', '{\"14303\":9600000,\"14273\":9500000,\"14212\":9400000,\"14208\":9300000,\"14203\":9200000,\"14202\":9100000,\"14191\":9000000,\"14188\":8900000,\"14183\":8800000,\"13926\":8700000,\"13925\":8600000,\"13924\":8500000,\"13923\":8400000,\"13906\":8300000,\"13870\":8200000,\"13864\":8100000,\"13863\":8000000,\"13860\":7900000,\"13730\":7800000,\"13707\":7700000,\"13631\":7600000,\"16421\":7500000,\"14362\":7400000,\"14351\":7300000,\"14319\":7200000,\"14301\":7100000,\"14274\":7000000,\"14272\":6900000,\"14204\":6800000,\"13873\":6700000,\"13861\":6600000,\"13859\":6500000,\"13858\":6400000,\"13857\":6300000,\"13856\":6200000,\"13855\":6100000,\"13854\":6000000,\"13853\":5900000,\"13852\":5800000,\"13851\":5700000,\"13850\":5600000,\"13849\":5500000,\"13848\":5400000,\"13847\":5300000,\"13846\":5200000,\"13845\":5100000,\"13844\":5000000,\"13843\":4900000,\"13842\":4800000,\"13841\":4700000,\"13840\":4600000,\"13839\":4500000,\"13838\":4400000,\"13837\":4300000,\"13836\":4200000,\"13835\":4100000,\"13834\":4000000,\"13833\":3900000,\"13832\":3800000,\"13831\":3700000,\"13830\":3600000,\"13829\":3500000,\"13828\":3400000,\"13827\":3300000,\"13826\":3200000,\"13825\":3100000,\"13824\":3000000,\"13823\":2900000,\"13822\":2800000,\"13821\":2700000,\"13562\":2600000,\"13561\":2500000,\"13560\":2400000,\"13558\":2300000,\"13557\":2200000,\"13556\":2100000,\"13555\":2000000,\"13554\":1900000,\"13553\":1800000,\"13552\":1700000,\"13551\":1600000,\"13550\":1500000,\"13549\":1400000,\"13548\":1300000,\"13547\":1200000,\"13546\":1100000,\"13545\":1000000,\"16351\":900000,\"15927\":800000,\"14321\":700000,\"14247\":600000,\"13899\":500000,\"13865\":400000,\"16826\":300000,\"14338\":200000,\"14320\":100000}', '1533384835');
INSERT INTO `project_flag` VALUES ('17', '10500', 'sprint_3_weight', '{\"16892\":1000000,\"16671\":900000,\"16300\":800000,\"16194\":700000,\"16186\":600000,\"16151\":500000,\"16936\":400000,\"16926\":300000,\"16924\":200000,\"16916\":100000}', '1533543956');
INSERT INTO `project_flag` VALUES ('18', '10500', 'sprint_4_weight', '{\"16935\":700000,\"16934\":600000,\"16919\":500000,\"16192\":400000,\"15693\":300000,\"16922\":200000,\"16904\":100000}', '1533543958');
INSERT INTO `project_flag` VALUES ('19', '10500', 'backlog_weight', '{\"16903\":19500000,\"16902\":19400000,\"16901\":19300000,\"16900\":19200000,\"16899\":19100000,\"16893\":19000000,\"16891\":18900000,\"16890\":18800000,\"16882\":18700000,\"16875\":18600000,\"16874\":18500000,\"16873\":18400000,\"16872\":18300000,\"16871\":18200000,\"16869\":18100000,\"16863\":18000000,\"16862\":17900000,\"16861\":17800000,\"16859\":17700000,\"16858\":17600000,\"16857\":17500000,\"16856\":17400000,\"16851\":17300000,\"16849\":17200000,\"16848\":17100000,\"16847\":17000000,\"16844\":16900000,\"16843\":16800000,\"16752\":16700000,\"16750\":16600000,\"16695\":16500000,\"16693\":16400000,\"16599\":16300000,\"16598\":16200000,\"16597\":16100000,\"16596\":16000000,\"16595\":15900000,\"16594\":15800000,\"16593\":15700000,\"16592\":15600000,\"16591\":15500000,\"16590\":15400000,\"16589\":15300000,\"16588\":15200000,\"16587\":15100000,\"16586\":15000000,\"16585\":14900000,\"16584\":14800000,\"16583\":14700000,\"16582\":14600000,\"16581\":14500000,\"16580\":14400000,\"16579\":14300000,\"16578\":14200000,\"16577\":14100000,\"16576\":14000000,\"16575\":13900000,\"16574\":13800000,\"16573\":13700000,\"16572\":13600000,\"16571\":13500000,\"16570\":13400000,\"16569\":13300000,\"16568\":13200000,\"16566\":13100000,\"16565\":13000000,\"16564\":12900000,\"16563\":12800000,\"16561\":12700000,\"16560\":12600000,\"16559\":12500000,\"16558\":12400000,\"16557\":12300000,\"16555\":12200000,\"16554\":12100000,\"16549\":12000000,\"16548\":11900000,\"16547\":11800000,\"16546\":11700000,\"16544\":11600000,\"16543\":11500000,\"16542\":11400000,\"16541\":11300000,\"16540\":11200000,\"16539\":11100000,\"16538\":11000000,\"16537\":10900000,\"16536\":10800000,\"16535\":10700000,\"16534\":10600000,\"16533\":10500000,\"16532\":10400000,\"16529\":10300000,\"16528\":10200000,\"16527\":10100000,\"16526\":10000000,\"16525\":9900000,\"16524\":9800000,\"16523\":9700000,\"16522\":9600000,\"16521\":9500000,\"16520\":9400000,\"16517\":9300000,\"16516\":9200000,\"16515\":9100000,\"16514\":9000000,\"16513\":8900000,\"16511\":8800000,\"16510\":8700000,\"16509\":8600000,\"16508\":8500000,\"16507\":8400000,\"16506\":8300000,\"16505\":8200000,\"16504\":8100000,\"16503\":8000000,\"16501\":7900000,\"16500\":7800000,\"16499\":7700000,\"16498\":7600000,\"16483\":7500000,\"16472\":7400000,\"16373\":7300000,\"16324\":7200000,\"16199\":7100000,\"16198\":7000000,\"16195\":6900000,\"16184\":6800000,\"16183\":6700000,\"16181\":6600000,\"16169\":6500000,\"16168\":6400000,\"16161\":6300000,\"16152\":6200000,\"16149\":6100000,\"16142\":6000000,\"16139\":5900000,\"16124\":5800000,\"16104\":5700000,\"16094\":5600000,\"16092\":5500000,\"16057\":5400000,\"16055\":5300000,\"16031\":5200000,\"16027\":5100000,\"16014\":5000000,\"15962\":4900000,\"15956\":4800000,\"15946\":4700000,\"15945\":4600000,\"15944\":4500000,\"15695\":4400000,\"15610\":4300000,\"15609\":4200000,\"15608\":4100000,\"15607\":4000000,\"15606\":3900000,\"15605\":3800000,\"15603\":3700000,\"15602\":3600000,\"15490\":3500000,\"15484\":3400000,\"15450\":3300000,\"15449\":3200000,\"14827\":3100000,\"16929\":3000000,\"16913\":2900000,\"16912\":2800000,\"16898\":2700000,\"16896\":2600000,\"16895\":2500000,\"16887\":2400000,\"16223\":2300000,\"16148\":2200000,\"16052\":2100000,\"15617\":2000000,\"15616\":1900000,\"15615\":1800000,\"15614\":1700000,\"15613\":1600000,\"15612\":1500000,\"15611\":1400000,\"16928\":1300000,\"16918\":1200000,\"16917\":1100000,\"16907\":1000000,\"16905\":900000,\"16207\":800000,\"16196\":700000,\"15625\":600000,\"15624\":500000,\"15622\":400000,\"15620\":300000,\"15619\":200000,\"16906\":100000}', '1533543961');
INSERT INTO `project_flag` VALUES ('22', '10401', 'backlog_weight', '{\"15651\":8400000,\"14579\":8300000,\"14566\":8200000,\"16931\":8100000,\"16889\":8000000,\"16870\":7900000,\"16867\":7800000,\"16865\":7700000,\"16838\":7600000,\"16837\":7500000,\"16836\":7400000,\"16835\":7300000,\"16834\":7200000,\"16819\":7100000,\"16797\":7000000,\"16786\":6900000,\"16785\":6800000,\"16783\":6700000,\"16780\":6600000,\"16766\":6500000,\"16757\":6400000,\"16755\":6300000,\"16742\":6200000,\"16717\":6100000,\"16697\":6000000,\"16689\":5900000,\"16681\":5800000,\"16680\":5700000,\"16664\":5600000,\"16663\":5500000,\"16659\":5400000,\"16653\":5300000,\"16644\":5200000,\"16638\":5100000,\"16502\":5000000,\"16437\":4900000,\"16435\":4800000,\"16432\":4700000,\"16431\":4600000,\"16417\":4500000,\"16411\":4400000,\"16409\":4300000,\"16295\":4200000,\"16294\":4100000,\"16283\":4000000,\"15098\":3900000,\"15051\":3800000,\"15050\":3700000,\"15046\":3600000,\"14604\":3500000,\"14563\":3400000,\"14561\":3300000,\"14557\":3200000,\"14035\":3100000,\"14034\":3000000,\"14033\":2900000,\"14032\":2800000,\"16932\":2700000,\"16779\":2600000,\"16678\":2500000,\"16629\":2400000,\"16617\":2300000,\"16454\":2200000,\"16317\":2100000,\"16309\":2000000,\"16299\":1900000,\"16298\":1800000,\"16293\":1700000,\"16292\":1600000,\"16291\":1500000,\"16288\":1400000,\"16286\":1300000,\"16279\":1200000,\"16278\":1100000,\"15466\":1000000,\"15064\":900000,\"15049\":800000,\"14606\":700000,\"14601\":600000,\"14598\":500000,\"14582\":400000,\"14567\":300000,\"14558\":200000,\"16410\":100000}', '1533700709');
INSERT INTO `project_flag` VALUES ('33', '10401', 'sprint_5_weight', '{\"16281\":600000,\"16933\":500000,\"16876\":400000,\"16866\":300000,\"16846\":200000,\"16840\":100000}', '1533722609');
INSERT INTO `project_flag` VALUES ('49', '10005', 'backlog_weight', '{\"10125\":200000,\"10124\":100000}', '1535367580');
INSERT INTO `project_flag` VALUES ('52', '11002', 'backlog_weight', '{\"18611\":300000,\"18610\":200000,\"18609\":100000}', '1536337047');
INSERT INTO `project_flag` VALUES ('53', '11008', 'sprint_105_weight', '{\"18632\":300000,\"18631\":200000,\"18630\":100000}', '1536337047');
INSERT INTO `project_flag` VALUES ('57', '10002', 'backlog_weight', '{\"13440\":28700000,\"13439\":28600000,\"13438\":28500000,\"13321\":28400000,\"14118\":28300000,\"13266\":28200000,\"14201\":28100000,\"14166\":28000000,\"16362\":27900000,\"14093\":27800000,\"14095\":27700000,\"14039\":27600000,\"13974\":27500000,\"13961\":27400000,\"13946\":27300000,\"13945\":27200000,\"13940\":27100000,\"13939\":27000000,\"13938\":26900000,\"13816\":26800000,\"13815\":26700000,\"13814\":26600000,\"13810\":26500000,\"13807\":26400000,\"13805\":26300000,\"13800\":26200000,\"13794\":26100000,\"13778\":26000000,\"13777\":25900000,\"13774\":25800000,\"13771\":25700000,\"13728\":25600000,\"13614\":25500000,\"13596\":25400000,\"13595\":25300000,\"13587\":25200000,\"13586\":25100000,\"13585\":25000000,\"13582\":24900000,\"13579\":24800000,\"13578\":24700000,\"13575\":24600000,\"13566\":24500000,\"13565\":24400000,\"13564\":24300000,\"13543\":24200000,\"13541\":24100000,\"13535\":24000000,\"13534\":23900000,\"13526\":23800000,\"13511\":23700000,\"13509\":23600000,\"13508\":23500000,\"13507\":23400000,\"13503\":23300000,\"13499\":23200000,\"13497\":23100000,\"13466\":23000000,\"13459\":22900000,\"13457\":22800000,\"13451\":22700000,\"13450\":22600000,\"13443\":22500000,\"13442\":22400000,\"13435\":22300000,\"13429\":22200000,\"13417\":22100000,\"13379\":22000000,\"13360\":21900000,\"13344\":21800000,\"13294\":21700000,\"13281\":21600000,\"13270\":21500000,\"13225\":21400000,\"12683\":21300000,\"12682\":21200000,\"12665\":21100000,\"12663\":21000000,\"12662\":20900000,\"12565\":20800000,\"12562\":20700000,\"12561\":20600000,\"12560\":20500000,\"12559\":20400000,\"12486\":20300000,\"12479\":20200000,\"12447\":20100000,\"12446\":20000000,\"12445\":19900000,\"12435\":19800000,\"12434\":19700000,\"12433\":19600000,\"12427\":19500000,\"12423\":19400000,\"12422\":19300000,\"12421\":19200000,\"12420\":19100000,\"12416\":19000000,\"12400\":18900000,\"12313\":18800000,\"12030\":18700000,\"11984\":18600000,\"11956\":18500000,\"11878\":18400000,\"11877\":18300000,\"11876\":18200000,\"11869\":18100000,\"11868\":18000000,\"11867\":17900000,\"11866\":17800000,\"11865\":17700000,\"11864\":17600000,\"11863\":17500000,\"11862\":17400000,\"11861\":17300000,\"11860\":17200000,\"11859\":17100000,\"11858\":17000000,\"11857\":16900000,\"11856\":16800000,\"11855\":16700000,\"11854\":16600000,\"11853\":16500000,\"11852\":16400000,\"11851\":16300000,\"11850\":16200000,\"11849\":16100000,\"11848\":16000000,\"11847\":15900000,\"11846\":15800000,\"11845\":15700000,\"11751\":15600000,\"11749\":15500000,\"11709\":15400000,\"11699\":15300000,\"11692\":15200000,\"11687\":15100000,\"11674\":15000000,\"11673\":14900000,\"11628\":14800000,\"11627\":14700000,\"11488\":14600000,\"11487\":14500000,\"11486\":14400000,\"11485\":14300000,\"11483\":14200000,\"11472\":14100000,\"11471\":14000000,\"11470\":13900000,\"11469\":13800000,\"11468\":13700000,\"11467\":13600000,\"11466\":13500000,\"11465\":13400000,\"11462\":13300000,\"11461\":13200000,\"11460\":13100000,\"11458\":13000000,\"11457\":12900000,\"11456\":12800000,\"11455\":12700000,\"11454\":12600000,\"11453\":12500000,\"11452\":12400000,\"11451\":12300000,\"11450\":12200000,\"11449\":12100000,\"11448\":12000000,\"11447\":11900000,\"11446\":11800000,\"11445\":11700000,\"11444\":11600000,\"11443\":11500000,\"11442\":11400000,\"11441\":11300000,\"11440\":11200000,\"11439\":11100000,\"11438\":11000000,\"11437\":10900000,\"11436\":10800000,\"11435\":10700000,\"11434\":10600000,\"11433\":10500000,\"11432\":10400000,\"11431\":10300000,\"11430\":10200000,\"11429\":10100000,\"11428\":10000000,\"11427\":9900000,\"11426\":9800000,\"11425\":9700000,\"11424\":9600000,\"11423\":9500000,\"11421\":9400000,\"11385\":9300000,\"11211\":9200000,\"11184\":9100000,\"11182\":9000000,\"11181\":8900000,\"11180\":8800000,\"11174\":8700000,\"11173\":8600000,\"11169\":8500000,\"11080\":8400000,\"11022\":8300000,\"11020\":8200000,\"10985\":8100000,\"10952\":8000000,\"10951\":7900000,\"10950\":7800000,\"10948\":7700000,\"10896\":7600000,\"10884\":7500000,\"10878\":7400000,\"10838\":7300000,\"10820\":7200000,\"10819\":7100000,\"10741\":7000000,\"10645\":6900000,\"10644\":6800000,\"10562\":6700000,\"10507\":6600000,\"10428\":6500000,\"10200\":6400000,\"10199\":6300000,\"10195\":6200000,\"10194\":6100000,\"10180\":6000000,\"10179\":5900000,\"10178\":5800000,\"10177\":5700000,\"10176\":5600000,\"10175\":5500000,\"10174\":5400000,\"10173\":5300000,\"10172\":5200000,\"10171\":5100000,\"10170\":5000000,\"10169\":4900000,\"10168\":4800000,\"10167\":4700000,\"10166\":4600000,\"10165\":4500000,\"10164\":4400000,\"10163\":4300000,\"10162\":4200000,\"10161\":4100000,\"10160\":4000000,\"10159\":3900000,\"10157\":3800000,\"10156\":3700000,\"10155\":3600000,\"10154\":3500000,\"10153\":3400000,\"10152\":3300000,\"10151\":3200000,\"10150\":3100000,\"10149\":3000000,\"10148\":2900000,\"10147\":2800000,\"10146\":2700000,\"10145\":2600000,\"10144\":2500000,\"10143\":2400000,\"10142\":2300000,\"10141\":2200000,\"10140\":2100000,\"10139\":2000000,\"10138\":1900000,\"10137\":1800000,\"10136\":1700000,\"10135\":1600000,\"10134\":1500000,\"10133\":1400000,\"10132\":1300000,\"10131\":1200000,\"10129\":1100000,\"13589\":1000000,\"13486\":900000,\"13277\":800000,\"12487\":700000,\"13291\":600000,\"13275\":500000,\"16939\":400000,\"18273\":300000,\"18272\":200000,\"18271\":100000}', '1536436424');
INSERT INTO `project_flag` VALUES ('65', '10002', 'sprint_6_weight', '{\"16372\":600000,\"14318\":500000,\"14205\":400000,\"14165\":300000,\"14132\":200000,\"18274\":100000}', '1536509537');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"1\":200000,\"3\":100000}', '1536769363');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536807016');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536807475');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536808903');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536808906');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536808909');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536808915');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1536808917');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536808922');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1536808927');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536808929');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', '1536808933');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', '1536813014');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', '1536842491');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', '1536848597');
INSERT INTO `project_flag` VALUES ('0', '2', 'backlog_weight', '{\"4\":100000}', '1536855096');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536899133');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1536899134');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1536899135');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1537869374');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1537869375');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1537869376');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1537923755');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1537923766');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1537934054');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1537947106');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1537947108');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1537947110');
INSERT INTO `project_flag` VALUES ('0', '1', 'backlog_weight', '{\"3\":100000}', '1538106795');
INSERT INTO `project_flag` VALUES ('0', '1', 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', '1538191161');
INSERT INTO `project_flag` VALUES ('0', '3', 'backlog_weight', '{\"10\":200000,\"9\":100000}', '1539091878');
INSERT INTO `project_flag` VALUES ('0', '3', 'backlog_weight', '{\"10\":700000,\"9\":600000,\"15\":500000,\"14\":400000,\"13\":300000,\"12\":200000,\"11\":100000}', '1539101910');
INSERT INTO `project_flag` VALUES ('0', '3', 'backlog_weight', '{\"10\":700000,\"9\":600000,\"15\":500000,\"14\":400000,\"13\":300000,\"12\":200000,\"11\":100000}', '1539103022');
INSERT INTO `project_flag` VALUES ('0', '3', 'backlog_weight', '{\"10\":700000,\"9\":600000,\"15\":500000,\"14\":400000,\"13\":300000,\"12\":200000,\"11\":100000}', '1539103065');
INSERT INTO `project_flag` VALUES ('0', '3', 'backlog_weight', '{\"10\":1200000,\"9\":1100000,\"15\":1000000,\"14\":900000,\"13\":800000,\"12\":700000,\"11\":600000,\"16\":500000,\"22\":400000,\"21\":300000,\"19\":200000,\"20\":100000}', '1539141347');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":1200000,\"15\":1100000,\"14\":1000000,\"13\":900000,\"10\":800000,\"22\":700000,\"21\":600000,\"19\":500000,\"12\":400000,\"9\":300000,\"20\":200000,\"11\":100000}', '1539141367');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":1200000,\"15\":1100000,\"14\":1000000,\"13\":900000,\"10\":800000,\"22\":700000,\"21\":600000,\"19\":500000,\"12\":400000,\"9\":300000,\"20\":200000,\"11\":100000}', '1539142915');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2000000,\"15\":1900000,\"14\":1800000,\"13\":1700000,\"10\":1600000,\"22\":1500000,\"21\":1400000,\"19\":1300000,\"12\":1200000,\"9\":1100000,\"20\":1000000,\"11\":900000,\"30\":800000,\"28\":700000,\"27\":600000,\"26\":500000,\"29\":400000,\"25\":300000,\"24\":200000,\"23\":100000}', '1539241443');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2000000,\"15\":1900000,\"14\":1800000,\"13\":1700000,\"10\":1600000,\"22\":1500000,\"21\":1400000,\"19\":1300000,\"12\":1200000,\"9\":1100000,\"20\":1000000,\"11\":900000,\"30\":800000,\"28\":700000,\"27\":600000,\"26\":500000,\"29\":400000,\"25\":300000,\"24\":200000,\"23\":100000}', '1539241448');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2000000,\"15\":1900000,\"14\":1800000,\"13\":1700000,\"26\":1600000,\"24\":1500000,\"10\":1400000,\"23\":1300000,\"22\":1200000,\"21\":1100000,\"19\":1000000,\"12\":900000,\"9\":800000,\"20\":700000,\"11\":600000,\"30\":500000,\"28\":400000,\"27\":300000,\"29\":200000,\"25\":100000}', '1539312280');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2500000,\"15\":2400000,\"14\":2300000,\"13\":2200000,\"26\":2100000,\"24\":2000000,\"10\":1900000,\"23\":1800000,\"22\":1700000,\"21\":1600000,\"19\":1500000,\"12\":1400000,\"9\":1300000,\"20\":1200000,\"11\":1100000,\"30\":1000000,\"28\":900000,\"27\":800000,\"29\":700000,\"25\":600000,\"32\":500000,\"35\":400000,\"34\":300000,\"33\":200000,\"31\":100000}', '1539570379');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2500000,\"15\":2400000,\"14\":2300000,\"13\":2200000,\"26\":2100000,\"24\":2000000,\"10\":1900000,\"23\":1800000,\"22\":1700000,\"21\":1600000,\"19\":1500000,\"12\":1400000,\"9\":1300000,\"20\":1200000,\"11\":1100000,\"30\":1000000,\"28\":900000,\"27\":800000,\"29\":700000,\"25\":600000,\"32\":500000,\"35\":400000,\"34\":300000,\"33\":200000,\"31\":100000}', '1539570382');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2600000,\"15\":2500000,\"14\":2400000,\"13\":2300000,\"26\":2200000,\"24\":2100000,\"10\":2000000,\"23\":1900000,\"22\":1800000,\"21\":1700000,\"19\":1600000,\"12\":1500000,\"9\":1400000,\"20\":1300000,\"11\":1200000,\"30\":1100000,\"28\":1000000,\"27\":900000,\"29\":800000,\"25\":700000,\"32\":600000,\"35\":500000,\"34\":400000,\"33\":300000,\"31\":200000,\"37\":100000}', '1539600402');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2600000,\"15\":2500000,\"14\":2400000,\"13\":2300000,\"26\":2200000,\"24\":2100000,\"10\":2000000,\"23\":1900000,\"22\":1800000,\"21\":1700000,\"19\":1600000,\"12\":1500000,\"9\":1400000,\"20\":1300000,\"11\":1200000,\"30\":1100000,\"28\":1000000,\"27\":900000,\"29\":800000,\"25\":700000,\"32\":600000,\"35\":500000,\"34\":400000,\"33\":300000,\"31\":200000,\"37\":100000}', '1539600407');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2600000,\"15\":2500000,\"14\":2400000,\"13\":2300000,\"26\":2200000,\"24\":2100000,\"10\":2000000,\"23\":1900000,\"22\":1800000,\"21\":1700000,\"19\":1600000,\"12\":1500000,\"9\":1400000,\"20\":1300000,\"11\":1200000,\"30\":1100000,\"28\":1000000,\"27\":900000,\"29\":800000,\"25\":700000,\"32\":600000,\"35\":500000,\"34\":400000,\"33\":300000,\"31\":200000,\"37\":100000}', '1539600408');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2600000,\"15\":2500000,\"14\":2400000,\"13\":2300000,\"26\":2200000,\"24\":2100000,\"10\":2000000,\"23\":1900000,\"22\":1800000,\"21\":1700000,\"19\":1600000,\"12\":1500000,\"9\":1400000,\"20\":1300000,\"11\":1200000,\"30\":1100000,\"28\":1000000,\"27\":900000,\"29\":800000,\"25\":700000,\"32\":600000,\"35\":500000,\"34\":400000,\"33\":300000,\"31\":200000,\"37\":100000}', '1539600413');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"14\":2500000,\"13\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1539600766');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"14\":2500000,\"13\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1539600769');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"14\":2500000,\"13\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1539601701');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2800000,\"15\":2700000,\"14\":2600000,\"13\":2500000,\"26\":2400000,\"24\":2300000,\"10\":2200000,\"23\":2100000,\"22\":2000000,\"21\":1900000,\"19\":1800000,\"12\":1700000,\"9\":1600000,\"20\":1500000,\"11\":1400000,\"30\":1300000,\"28\":1200000,\"27\":1100000,\"29\":1000000,\"25\":900000,\"32\":800000,\"35\":700000,\"34\":600000,\"33\":500000,\"31\":400000,\"37\":300000,\"38\":200000,\"39\":100000}', '1539677270');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2800000,\"15\":2700000,\"14\":2600000,\"13\":2500000,\"26\":2400000,\"24\":2300000,\"10\":2200000,\"23\":2100000,\"22\":2000000,\"21\":1900000,\"19\":1800000,\"12\":1700000,\"9\":1600000,\"20\":1500000,\"11\":1400000,\"30\":1300000,\"28\":1200000,\"27\":1100000,\"29\":1000000,\"25\":900000,\"32\":800000,\"35\":700000,\"34\":600000,\"33\":500000,\"31\":400000,\"37\":300000,\"38\":200000,\"39\":100000}', '1539677272');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2800000,\"15\":2700000,\"14\":2600000,\"13\":2500000,\"26\":2400000,\"24\":2300000,\"10\":2200000,\"23\":2100000,\"22\":2000000,\"21\":1900000,\"19\":1800000,\"12\":1700000,\"9\":1600000,\"20\":1500000,\"11\":1400000,\"30\":1300000,\"28\":1200000,\"27\":1100000,\"29\":1000000,\"25\":900000,\"32\":800000,\"35\":700000,\"34\":600000,\"33\":500000,\"31\":400000,\"37\":300000,\"38\":200000,\"39\":100000}', '1539678078');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2800000,\"15\":2700000,\"14\":2600000,\"13\":2500000,\"26\":2400000,\"24\":2300000,\"10\":2200000,\"23\":2100000,\"22\":2000000,\"21\":1900000,\"19\":1800000,\"12\":1700000,\"9\":1600000,\"20\":1500000,\"11\":1400000,\"30\":1300000,\"28\":1200000,\"27\":1100000,\"29\":1000000,\"25\":900000,\"32\":800000,\"35\":700000,\"34\":600000,\"33\":500000,\"31\":400000,\"37\":300000,\"38\":200000,\"39\":100000}', '1539678089');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2800000,\"15\":2700000,\"14\":2600000,\"13\":2500000,\"26\":2400000,\"24\":2300000,\"10\":2200000,\"23\":2100000,\"22\":2000000,\"21\":1900000,\"19\":1800000,\"12\":1700000,\"9\":1600000,\"20\":1500000,\"11\":1400000,\"30\":1300000,\"28\":1200000,\"27\":1100000,\"29\":1000000,\"25\":900000,\"32\":800000,\"35\":700000,\"34\":600000,\"33\":500000,\"31\":400000,\"37\":300000,\"38\":200000,\"39\":100000}', '1539678090');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"14\":2700000,\"13\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1539678320');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1539679684');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1539683455');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1539771269');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1539771273');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1539831788');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1540007470');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1540125081');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1540192621');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2900000,\"15\":2800000,\"13\":2700000,\"14\":2600000,\"26\":2500000,\"24\":2400000,\"10\":2300000,\"23\":2200000,\"22\":2100000,\"21\":2000000,\"19\":1900000,\"12\":1800000,\"9\":1700000,\"20\":1600000,\"11\":1500000,\"30\":1400000,\"28\":1300000,\"27\":1200000,\"29\":1100000,\"25\":1000000,\"32\":900000,\"35\":800000,\"34\":700000,\"33\":600000,\"31\":500000,\"37\":400000,\"38\":300000,\"39\":200000,\"40\":100000}', '1540192622');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540637763');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540638253');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540638256');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540638724');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540640174');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540640320');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540640322');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540640530');
INSERT INTO `project_flag` VALUES ('0', '3', 'sprint_2_weight', '{\"16\":2700000,\"15\":2600000,\"13\":2500000,\"14\":2400000,\"26\":2300000,\"24\":2200000,\"10\":2100000,\"23\":2000000,\"22\":1900000,\"21\":1800000,\"19\":1700000,\"12\":1600000,\"9\":1500000,\"20\":1400000,\"11\":1300000,\"30\":1200000,\"28\":1100000,\"27\":1000000,\"29\":900000,\"25\":800000,\"32\":700000,\"35\":600000,\"34\":500000,\"33\":400000,\"31\":300000,\"37\":200000,\"38\":100000}', '1540640541');

-- ----------------------------
-- Table structure for project_issue_report
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_issue_report
-- ----------------------------
INSERT INTO `project_issue_report` VALUES ('1', '10500', '2018-07-30', null, null, '10', '5', '0', null, '0', '0');
INSERT INTO `project_issue_report` VALUES ('2', '10500', '2018-07-31', null, null, '2', '3', '0', null, '0', '0');

-- ----------------------------
-- Table structure for project_issue_type_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `project_issue_type_scheme_data`;
CREATE TABLE `project_issue_type_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `issue_type_scheme_id` int(11) unsigned DEFAULT NULL,
  `project_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`) USING BTREE,
  KEY `issue_type_scheme_id` (`issue_type_scheme_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_issue_type_scheme_data
-- ----------------------------
INSERT INTO `project_issue_type_scheme_data` VALUES ('3', '6', '10508');
INSERT INTO `project_issue_type_scheme_data` VALUES ('5', '4', '10509');
INSERT INTO `project_issue_type_scheme_data` VALUES ('6', '1', '10566');
INSERT INTO `project_issue_type_scheme_data` VALUES ('7', '20', '10989');
INSERT INTO `project_issue_type_scheme_data` VALUES ('8', '21', '10991');
INSERT INTO `project_issue_type_scheme_data` VALUES ('9', '23', '10993');
INSERT INTO `project_issue_type_scheme_data` VALUES ('10', '24', '10995');
INSERT INTO `project_issue_type_scheme_data` VALUES ('11', '25', '10997');
INSERT INTO `project_issue_type_scheme_data` VALUES ('12', '2', '10999');
INSERT INTO `project_issue_type_scheme_data` VALUES ('13', '2', '1');
INSERT INTO `project_issue_type_scheme_data` VALUES ('14', '2', '2');
INSERT INTO `project_issue_type_scheme_data` VALUES ('15', '2', '3');
INSERT INTO `project_issue_type_scheme_data` VALUES ('16', '2', '4');

-- ----------------------------
-- Table structure for project_key
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
INSERT INTO `project_key` VALUES ('10002', '10002', 'IP');
INSERT INTO `project_key` VALUES ('10003', '10003', 'ISC');
INSERT INTO `project_key` VALUES ('10004', '10004', 'DIAMOND');
INSERT INTO `project_key` VALUES ('10005', '10005', 'ZB');
INSERT INTO `project_key` VALUES ('10006', '10006', 'CS');
INSERT INTO `project_key` VALUES ('10008', '10008', 'BTB');
INSERT INTO `project_key` VALUES ('10009', '10009', 'DIST');
INSERT INTO `project_key` VALUES ('10013', '10008', 'ISMOND');
INSERT INTO `project_key` VALUES ('10014', '10008', 'ALL');
INSERT INTO `project_key` VALUES ('10015', '10013', 'SJZX');
INSERT INTO `project_key` VALUES ('10100', '10100', 'TM');
INSERT INTO `project_key` VALUES ('10101', '10101', 'SITE');
INSERT INTO `project_key` VALUES ('10102', '10102', 'JXC');
INSERT INTO `project_key` VALUES ('10103', '10103', 'SMDIST');
INSERT INTO `project_key` VALUES ('10104', '10104', 'WBDIST');
INSERT INTO `project_key` VALUES ('10105', '10105', 'BIGDATA');
INSERT INTO `project_key` VALUES ('10106', '10106', 'YW');
INSERT INTO `project_key` VALUES ('10107', '10107', 'SP');
INSERT INTO `project_key` VALUES ('10108', '10108', 'ACTIVITY');
INSERT INTO `project_key` VALUES ('10110', '10110', 'IS');
INSERT INTO `project_key` VALUES ('10111', '10111', 'RF');
INSERT INTO `project_key` VALUES ('10112', '10112', 'DC');
INSERT INTO `project_key` VALUES ('10200', '10200', 'ZUANADMIN');
INSERT INTO `project_key` VALUES ('10207', '10206', 'SCB');
INSERT INTO `project_key` VALUES ('10208', '10207', 'ZZSJXC');
INSERT INTO `project_key` VALUES ('10300', '10300', 'IBLOVE');
INSERT INTO `project_key` VALUES ('10400', '10400', 'ZZSJXCI');
INSERT INTO `project_key` VALUES ('10401', '10401', 'BTOB');
INSERT INTO `project_key` VALUES ('10402', '10402', 'UED');
INSERT INTO `project_key` VALUES ('10403', '10403', 'GYLYSJ');
INSERT INTO `project_key` VALUES ('10404', '10404', 'SDX');
INSERT INTO `project_key` VALUES ('10500', '10500', 'SSZBD');
INSERT INTO `project_key` VALUES ('10501', '10501', 'BOM');

-- ----------------------------
-- Table structure for project_label
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_label
-- ----------------------------
INSERT INTO `project_label` VALUES ('1', '0', 'Error', '#FFFFFF', '#FF0000');
INSERT INTO `project_label` VALUES ('2', '0', 'Success', '#FFFFFF', '#69D100');
INSERT INTO `project_label` VALUES ('3', '0', 'Warn', '#FFFFFF', '#F0AD4E');
INSERT INTO `project_label` VALUES ('4', '10002', 'FSDFDS', '#FFFFFF', '#428BCA');

-- ----------------------------
-- Table structure for project_list_count
-- ----------------------------
DROP TABLE IF EXISTS `project_list_count`;
CREATE TABLE `project_list_count` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_type_id` smallint(5) unsigned DEFAULT NULL,
  `project_total` int(10) unsigned DEFAULT NULL,
  `remark` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_list_count
-- ----------------------------
INSERT INTO `project_list_count` VALUES ('1', '10', '2', '敏捷开发项目总数');
INSERT INTO `project_list_count` VALUES ('2', '20', '0', '看板开发项目总数');
INSERT INTO `project_list_count` VALUES ('3', '30', '0', '软件开发项目总数');
INSERT INTO `project_list_count` VALUES ('4', '40', '0', '项目管理项目总数');
INSERT INTO `project_list_count` VALUES ('5', '50', '0', '流程管理项目总数');
INSERT INTO `project_list_count` VALUES ('6', '60', '0', '任务管理项目总数');

-- ----------------------------
-- Table structure for project_main
-- ----------------------------
DROP TABLE IF EXISTS `project_main`;
CREATE TABLE `project_main` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL DEFAULT '1',
  `org_path` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `lead` int(11) unsigned DEFAULT '0',
  `description` varchar(2000) DEFAULT NULL,
  `key` varchar(20) DEFAULT NULL,
  `pcounter` decimal(18,0) DEFAULT NULL,
  `default_assignee` int(11) unsigned DEFAULT '0',
  `assignee_type` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `category` int(11) unsigned DEFAULT NULL,
  `type` tinyint(2) DEFAULT '1',
  `type_child` tinyint(2) DEFAULT '0',
  `permission_scheme_id` int(11) unsigned DEFAULT '0',
  `workflow_scheme_id` int(11) unsigned NOT NULL,
  `create_uid` int(11) unsigned DEFAULT '0',
  `create_time` int(11) unsigned DEFAULT '0',
  `detail` text,
  `un_done_count` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '未完成事项数',
  `done_count` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '已经完成事项数',
  `closed_count` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_project_key` (`key`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `uid` (`create_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_main
-- ----------------------------
INSERT INTO `project_main` VALUES ('1', '1', 'default', '客户管理crm系统', '', '10000', '                                                                                                                                                                                                                基于人工智能的客户关系管理系统                                                                                                                                                                                                ', 'CRM', null, '1', null, 'avatar/20181017/20181017180352_48634.jpg', '0', '10', '0', '0', '0', '10000', '1536553005', 'CRM(Customer Relationship Management\r\n\r\n客户关系管理，是一种以\"客户关系一对一理论\"为基础，旨在改善企业与客户之间关系的新型管理机制。客户关系管理的定义是：企业为提高核心竞争力，利用相应的信息技术以及互联网技术来协调企业与顾客间在销售、营销和服务上的交互，从而提升其管理方式，向客户提供创新式的个性化的客户交互和服务的过程。其最终目标是吸引新客户、保留老客户以及将已有客户转为忠实客户，增加市场份额。\r\n\r\n最早发展客户关系管理的国家是美国，这个概念最初由Gartner Group提出来，在1980年初便有所谓的“接触管理”(Contact Management)，即专门收集客户与公司联系的所有信息，到1990年则演变成包括电话服务中心支持资料分析的客户关怀（Customer care）。开始在企业电子商务中流行。\r\n\r\nCRM系统的宗旨是：为了满足每个客户的特殊需求，同每个客户建立联系，通过同客户的联系来了解客户的不同需求，并在此基础上进行\"一对一\"个性化服务。通常CRM包括销售管理、市场营销管理、客户服务系统以及呼叫中心等方面。\r\n“以客户为中心”，提高客户满意度，培养、维持客户忠诚度，在今天这个电子商务时代显得日益重要。客户关系管理正是改善企业与客户之间关系的新型管理机制，越来越多的企业运用CRM来增加收入、优化赢利性、提高客户满意度。\r\n\r\n统计数据表明，2008年中小企业CRM市场的规模已达8亿美元。在随后五年中，这一市场将快速增长至18亿美元，在整个CRM市场中占比达30%以上。 \r\n\r\nCRM系统主要包含传统CRM系统和在线CRM系统。', '1', '2', '2');
INSERT INTO `project_main` VALUES ('2', '1', 'default', 'ERP系统实施', '', '10000', '                                                    公司内部ERP项目的实施                                                ', 'ERP', null, '1', null, 'avatar/20180913/20180913144752_28827.jpg', '0', '10', '0', '0', '0', '10000', '1536821242', '收藏 8742\r\n968\r\nERP系统 编辑\r\nERP系统是企业资源计划(Enterprise Resource Planning )的简称，是指建立在信息技术基础上，集信息技术与先进管理思想于一身，以系统化的管理思想，为企业员工及决策层提供决策手段的管理平台。它是从MRP（物料需求计划）发展而来的新一代集成化管理信息系统，它扩展了MRP的功能，其核心思想是供应链管理。它跳出了传统企业边界，从供应链范围去优化企业的资源，优化了现代企业的运行模式，反映了市场对企业合理调配资源的要求。它对于改善企业业务流程、提高企业核心竞争力具有显著作用。\r\n\r\n系统特点编辑\r\nERP是Enterprise Resource Planning（企业资源计划）的简称，是上个世纪90年代美国一家IT公司根据当时计算机信息、IT技术发展及企业对供应链管理的需求，预测在今后信息时代企业管理信息系统的发展趋势和即将发生变革，而提出了这个概念。 ERP是针对物资资源管理（物流）、人力资源管理（人流）、财务资源管理（财流）、信息资源管理（信息流）集成一体化的企业管理软件。它将包含客户/服务架构，使用图形用户接口，应用开放系统制作。除了已有的标准功能，它还包括其它特性，如品质、过程运作管理、以及调整报告等。\r\nERP系统的特点有：\r\n企业内部管理所需的业务应用系统，主要是指财务、物流、人力资源等核心模块。\r\n\r\n物流管理系统采用了制造业的MRP管理思想；FMIS有效地实现了预算管理、业务评估、管理会计、ABC成本归集方法等现代基本财务管理方法；人力资源管理系统在组织机构设计、岗位管理、薪酬体系以及人力资源开发等方面同样集成了先进的理念。\r\nERP系统是一个在全公司范围内应用的、高度集成的系统。数据在各业务系统之间高度共享，所有源数据只需在某一个系统中输入一次，保证了数据的一致性。\r\n对公司内部业务流程和管理过程进行了优化，主要的业务流程实现了自动化。\r\n采用了计算机最新的主流技术和体系结构：B/S、INTERNET体系结构，WINDOWS界面。在能通信的地方都可以方便地接入到系统中来。\r\n集成性、先进性、统一性、完整性、开放性。\r\n实用性\r\nERP系统实际应用中更重要的是应该体现其“管理工具”的本质。ERP系统主要宗旨是对企业所拥有的人、财、物、信息、时间和空间等综合资源进行综合平衡和优化管理，ERP软件协调企业各管理部门，ERP系统围绕市场导向开展业务活动，提高企业的核心竞争力，ERP软件从而取得最好的经济效益。所以，ERP系统首先是一个软件，同时是一个管理工具。ERP软件是IT技术与管理思想的融合体，ERP系统也就是先进的管理思想借助电脑，来达成企业的管理目标。\r\n整合性\r\nERP最大特色便是整个企业信息系统的整合，比传统单一的系统更具功能性。\r\n弹性\r\n采用模块化的设计方式，使系统本身可因应企业需要新增模块来支持并整合，提升企业的应变能力。\r\n数据储存\r\n将原先分散企业各角落的数据整合起来，使数据得以一致性，并提升其精确性。\r\n便利性\r\n在整合的环境下，企业内部所产生的信息透过系统将可在企业任一地方取得与应用。\r\n管理绩效\r\nERP系统将使部分间横向的联系有效且紧密，使得管理绩效提升。\r\n互动关系\r\n透过ERP系统配合使企业与原物料供货商之间紧密结合，增加其市场变动的能力。而CRM客户关系管理系统则使企业充分掌握市场需要取向的动脉，两者皆有助于促进企业与上下游的互动发展关系。\r\n实时性\r\nERP是整个企业信息的整合管理，重在整体性，而整体性的关键就体现于“实时和动态管理”上，所谓“兵马未动，粮草先行”，强调的就是不同部门的“实时动态配合”，现实工作中的管理问题，也是部门协调与岗位配合的问题，因此缺乏“实时动态的管理手段和管理能力”的ERP管理，就是空谈。\r\n及时性\r\nERP管理的关键是“现实工作信息化”，即把现实中的工作内容与工作方式，用信息化的手段来表现，因为人的精力和能力是有限的，现实事务达到一定的繁杂程度后，人就会在所难免的出错，将工作内容与工作方式信息化，就能形成ERP管理的信息化体系，才能拥有可靠的信息化管理工具。', '1', '0', '1');

-- ----------------------------
-- Table structure for project_module
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_module
-- ----------------------------
INSERT INTO `project_module` VALUES ('1', '1', '用户', '用户模块', '0', '11652', '1536768892');
INSERT INTO `project_module` VALUES ('2', '1', '客户', '客户模块', '11653', '10000', '1536768976');
INSERT INTO `project_module` VALUES ('3', '1', '系统', ' ', '0', '0', '1536805496');
INSERT INTO `project_module` VALUES ('4', '3', '用户', '', '0', '0', '1539091728');
INSERT INTO `project_module` VALUES ('5', '3', '首页', '首页相关的功能', '0', '0', '1539091739');
INSERT INTO `project_module` VALUES ('6', '3', '敏捷', '包括待办事项,迭代,看板', '0', '0', '1539091785');
INSERT INTO `project_module` VALUES ('7', '3', '项目信息', '', '0', '0', '1539091820');
INSERT INTO `project_module` VALUES ('8', '3', '项目设置', '', '0', '0', '1539091825');
INSERT INTO `project_module` VALUES ('9', '3', '组织', '', '0', '0', '1539091850');
INSERT INTO `project_module` VALUES ('10', '3', '统计报表', '', '0', '0', '1539091872');
INSERT INTO `project_module` VALUES ('11', '3', '事项', '跟项目事项相关列表，表单，详情等功能', '0', '0', '1539091924');
INSERT INTO `project_module` VALUES ('12', '3', '系统-事项', '', '0', '0', '1539091985');
INSERT INTO `project_module` VALUES ('13', '3', '系统-基本信息', '', '0', '0', '1539091991');
INSERT INTO `project_module` VALUES ('14', '3', '系统-项目', '', '0', '0', '1539091997');
INSERT INTO `project_module` VALUES ('15', '3', '系统-用户', '', '0', '0', '1539092002');

-- ----------------------------
-- Table structure for project_role
-- ----------------------------
DROP TABLE IF EXISTS `project_role`;
CREATE TABLE `project_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) unsigned DEFAULT '0' COMMENT '是否是默认角色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_role
-- ----------------------------
INSERT INTO `project_role` VALUES ('1', '1', 'Users', 'A project role that represents users in a project', '1');
INSERT INTO `project_role` VALUES ('2', '1', 'Developers', 'A project role that represents developers in a project', '1');
INSERT INTO `project_role` VALUES ('3', '1', 'Administrators', 'A project role that represents administrators in a project', '1');
INSERT INTO `project_role` VALUES ('4', '1', 'QA', null, '1');
INSERT INTO `project_role` VALUES ('5', '1', 'PO', null, '1');
INSERT INTO `project_role` VALUES ('6', '2', 'Users', 'A project role that represents users in a project', '1');
INSERT INTO `project_role` VALUES ('7', '2', 'Developers', 'A project role that represents developers in a project', '1');
INSERT INTO `project_role` VALUES ('8', '2', 'Administrators', 'A project role that represents administrators in a project', '1');
INSERT INTO `project_role` VALUES ('9', '2', 'QA', null, '1');
INSERT INTO `project_role` VALUES ('10', '2', 'PO', null, '1');
INSERT INTO `project_role` VALUES ('11', '3', 'Users', 'A project role that represents users in a project', '1');
INSERT INTO `project_role` VALUES ('12', '3', 'Developers', 'A project role that represents developers in a project', '1');
INSERT INTO `project_role` VALUES ('13', '3', 'Administrators', 'A project role that represents administrators in a project', '1');
INSERT INTO `project_role` VALUES ('14', '3', 'QA', null, '1');
INSERT INTO `project_role` VALUES ('15', '3', 'PO', null, '1');
INSERT INTO `project_role` VALUES ('16', '4', 'Users', 'A project role that represents users in a project', '1');
INSERT INTO `project_role` VALUES ('17', '4', 'Developers', 'A project role that represents developers in a project', '1');
INSERT INTO `project_role` VALUES ('18', '4', 'Administrators', 'A project role that represents administrators in a project', '1');
INSERT INTO `project_role` VALUES ('19', '4', 'QA', null, '1');
INSERT INTO `project_role` VALUES ('20', '4', 'PO', null, '1');

-- ----------------------------
-- Table structure for project_role_relation
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
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_role_relation
-- ----------------------------
INSERT INTO `project_role_relation` VALUES ('1', '1', '1', '10005');
INSERT INTO `project_role_relation` VALUES ('2', '1', '1', '10006');
INSERT INTO `project_role_relation` VALUES ('3', '1', '1', '10007');
INSERT INTO `project_role_relation` VALUES ('4', '1', '1', '10008');
INSERT INTO `project_role_relation` VALUES ('5', '1', '1', '10013');
INSERT INTO `project_role_relation` VALUES ('6', '1', '2', '10005');
INSERT INTO `project_role_relation` VALUES ('7', '1', '2', '10006');
INSERT INTO `project_role_relation` VALUES ('8', '1', '2', '10007');
INSERT INTO `project_role_relation` VALUES ('9', '1', '2', '10008');
INSERT INTO `project_role_relation` VALUES ('10', '1', '2', '10013');
INSERT INTO `project_role_relation` VALUES ('11', '1', '2', '10014');
INSERT INTO `project_role_relation` VALUES ('12', '1', '2', '10015');
INSERT INTO `project_role_relation` VALUES ('13', '1', '2', '10028');
INSERT INTO `project_role_relation` VALUES ('14', '1', '3', '10004');
INSERT INTO `project_role_relation` VALUES ('15', '1', '3', '10005');
INSERT INTO `project_role_relation` VALUES ('16', '1', '3', '10006');
INSERT INTO `project_role_relation` VALUES ('17', '1', '3', '10007');
INSERT INTO `project_role_relation` VALUES ('18', '1', '3', '10008');
INSERT INTO `project_role_relation` VALUES ('19', '1', '3', '10013');
INSERT INTO `project_role_relation` VALUES ('20', '1', '3', '10014');
INSERT INTO `project_role_relation` VALUES ('21', '1', '3', '10015');
INSERT INTO `project_role_relation` VALUES ('22', '1', '3', '10028');
INSERT INTO `project_role_relation` VALUES ('23', '1', '3', '10902');
INSERT INTO `project_role_relation` VALUES ('24', '1', '3', '10903');
INSERT INTO `project_role_relation` VALUES ('25', '1', '3', '10904');
INSERT INTO `project_role_relation` VALUES ('26', '1', '5', '10004');
INSERT INTO `project_role_relation` VALUES ('27', '1', '5', '10005');
INSERT INTO `project_role_relation` VALUES ('28', '1', '5', '10006');
INSERT INTO `project_role_relation` VALUES ('29', '1', '5', '10007');
INSERT INTO `project_role_relation` VALUES ('30', '1', '5', '10008');
INSERT INTO `project_role_relation` VALUES ('31', '1', '5', '10013');
INSERT INTO `project_role_relation` VALUES ('32', '1', '5', '10014');
INSERT INTO `project_role_relation` VALUES ('33', '1', '5', '10015');
INSERT INTO `project_role_relation` VALUES ('34', '1', '5', '10028');
INSERT INTO `project_role_relation` VALUES ('35', '1', '5', '10902');
INSERT INTO `project_role_relation` VALUES ('36', '1', '5', '10903');
INSERT INTO `project_role_relation` VALUES ('37', '1', '5', '10904');
INSERT INTO `project_role_relation` VALUES ('38', '2', '6', '10005');
INSERT INTO `project_role_relation` VALUES ('39', '2', '6', '10006');
INSERT INTO `project_role_relation` VALUES ('40', '2', '6', '10007');
INSERT INTO `project_role_relation` VALUES ('41', '2', '6', '10008');
INSERT INTO `project_role_relation` VALUES ('42', '2', '6', '10013');
INSERT INTO `project_role_relation` VALUES ('43', '2', '7', '10005');
INSERT INTO `project_role_relation` VALUES ('44', '2', '7', '10006');
INSERT INTO `project_role_relation` VALUES ('45', '2', '7', '10007');
INSERT INTO `project_role_relation` VALUES ('46', '2', '7', '10008');
INSERT INTO `project_role_relation` VALUES ('47', '2', '7', '10013');
INSERT INTO `project_role_relation` VALUES ('48', '2', '7', '10014');
INSERT INTO `project_role_relation` VALUES ('49', '2', '7', '10015');
INSERT INTO `project_role_relation` VALUES ('50', '2', '7', '10028');
INSERT INTO `project_role_relation` VALUES ('51', '2', '8', '10004');
INSERT INTO `project_role_relation` VALUES ('52', '2', '8', '10005');
INSERT INTO `project_role_relation` VALUES ('53', '2', '8', '10006');
INSERT INTO `project_role_relation` VALUES ('54', '2', '8', '10007');
INSERT INTO `project_role_relation` VALUES ('55', '2', '8', '10008');
INSERT INTO `project_role_relation` VALUES ('56', '2', '8', '10013');
INSERT INTO `project_role_relation` VALUES ('57', '2', '8', '10014');
INSERT INTO `project_role_relation` VALUES ('58', '2', '8', '10015');
INSERT INTO `project_role_relation` VALUES ('59', '2', '8', '10028');
INSERT INTO `project_role_relation` VALUES ('60', '2', '8', '10902');
INSERT INTO `project_role_relation` VALUES ('61', '2', '8', '10903');
INSERT INTO `project_role_relation` VALUES ('62', '2', '8', '10904');
INSERT INTO `project_role_relation` VALUES ('63', '2', '10', '10004');
INSERT INTO `project_role_relation` VALUES ('64', '2', '10', '10005');
INSERT INTO `project_role_relation` VALUES ('65', '2', '10', '10006');
INSERT INTO `project_role_relation` VALUES ('66', '2', '10', '10007');
INSERT INTO `project_role_relation` VALUES ('67', '2', '10', '10008');
INSERT INTO `project_role_relation` VALUES ('68', '2', '10', '10013');
INSERT INTO `project_role_relation` VALUES ('69', '2', '10', '10014');
INSERT INTO `project_role_relation` VALUES ('70', '2', '10', '10015');
INSERT INTO `project_role_relation` VALUES ('71', '2', '10', '10028');
INSERT INTO `project_role_relation` VALUES ('72', '2', '10', '10902');
INSERT INTO `project_role_relation` VALUES ('73', '2', '10', '10903');
INSERT INTO `project_role_relation` VALUES ('74', '2', '10', '10904');
INSERT INTO `project_role_relation` VALUES ('75', '3', '11', '10005');
INSERT INTO `project_role_relation` VALUES ('76', '3', '11', '10006');
INSERT INTO `project_role_relation` VALUES ('77', '3', '11', '10007');
INSERT INTO `project_role_relation` VALUES ('78', '3', '11', '10008');
INSERT INTO `project_role_relation` VALUES ('79', '3', '11', '10013');
INSERT INTO `project_role_relation` VALUES ('80', '3', '12', '10005');
INSERT INTO `project_role_relation` VALUES ('81', '3', '12', '10006');
INSERT INTO `project_role_relation` VALUES ('82', '3', '12', '10007');
INSERT INTO `project_role_relation` VALUES ('83', '3', '12', '10008');
INSERT INTO `project_role_relation` VALUES ('84', '3', '12', '10013');
INSERT INTO `project_role_relation` VALUES ('85', '3', '12', '10014');
INSERT INTO `project_role_relation` VALUES ('86', '3', '12', '10015');
INSERT INTO `project_role_relation` VALUES ('87', '3', '12', '10028');
INSERT INTO `project_role_relation` VALUES ('88', '3', '13', '10004');
INSERT INTO `project_role_relation` VALUES ('89', '3', '13', '10005');
INSERT INTO `project_role_relation` VALUES ('90', '3', '13', '10006');
INSERT INTO `project_role_relation` VALUES ('91', '3', '13', '10007');
INSERT INTO `project_role_relation` VALUES ('92', '3', '13', '10008');
INSERT INTO `project_role_relation` VALUES ('93', '3', '13', '10013');
INSERT INTO `project_role_relation` VALUES ('94', '3', '13', '10014');
INSERT INTO `project_role_relation` VALUES ('95', '3', '13', '10015');
INSERT INTO `project_role_relation` VALUES ('96', '3', '13', '10028');
INSERT INTO `project_role_relation` VALUES ('97', '3', '13', '10902');
INSERT INTO `project_role_relation` VALUES ('98', '3', '13', '10903');
INSERT INTO `project_role_relation` VALUES ('99', '3', '13', '10904');
INSERT INTO `project_role_relation` VALUES ('100', '3', '15', '10004');
INSERT INTO `project_role_relation` VALUES ('101', '3', '15', '10005');
INSERT INTO `project_role_relation` VALUES ('102', '3', '15', '10006');
INSERT INTO `project_role_relation` VALUES ('103', '3', '15', '10007');
INSERT INTO `project_role_relation` VALUES ('104', '3', '15', '10008');
INSERT INTO `project_role_relation` VALUES ('105', '3', '15', '10013');
INSERT INTO `project_role_relation` VALUES ('106', '3', '15', '10014');
INSERT INTO `project_role_relation` VALUES ('107', '3', '15', '10015');
INSERT INTO `project_role_relation` VALUES ('108', '3', '15', '10028');
INSERT INTO `project_role_relation` VALUES ('109', '3', '15', '10902');
INSERT INTO `project_role_relation` VALUES ('110', '3', '15', '10903');
INSERT INTO `project_role_relation` VALUES ('111', '3', '15', '10904');
INSERT INTO `project_role_relation` VALUES ('112', '4', '16', '10005');
INSERT INTO `project_role_relation` VALUES ('113', '4', '16', '10006');
INSERT INTO `project_role_relation` VALUES ('114', '4', '16', '10007');
INSERT INTO `project_role_relation` VALUES ('115', '4', '16', '10008');
INSERT INTO `project_role_relation` VALUES ('116', '4', '16', '10013');
INSERT INTO `project_role_relation` VALUES ('117', '4', '17', '10005');
INSERT INTO `project_role_relation` VALUES ('118', '4', '17', '10006');
INSERT INTO `project_role_relation` VALUES ('119', '4', '17', '10007');
INSERT INTO `project_role_relation` VALUES ('120', '4', '17', '10008');
INSERT INTO `project_role_relation` VALUES ('121', '4', '17', '10013');
INSERT INTO `project_role_relation` VALUES ('122', '4', '17', '10014');
INSERT INTO `project_role_relation` VALUES ('123', '4', '17', '10015');
INSERT INTO `project_role_relation` VALUES ('124', '4', '17', '10028');
INSERT INTO `project_role_relation` VALUES ('125', '4', '18', '10004');
INSERT INTO `project_role_relation` VALUES ('126', '4', '18', '10005');
INSERT INTO `project_role_relation` VALUES ('127', '4', '18', '10006');
INSERT INTO `project_role_relation` VALUES ('128', '4', '18', '10007');
INSERT INTO `project_role_relation` VALUES ('129', '4', '18', '10008');
INSERT INTO `project_role_relation` VALUES ('130', '4', '18', '10013');
INSERT INTO `project_role_relation` VALUES ('131', '4', '18', '10014');
INSERT INTO `project_role_relation` VALUES ('132', '4', '18', '10015');
INSERT INTO `project_role_relation` VALUES ('133', '4', '18', '10028');
INSERT INTO `project_role_relation` VALUES ('134', '4', '18', '10902');
INSERT INTO `project_role_relation` VALUES ('135', '4', '18', '10903');
INSERT INTO `project_role_relation` VALUES ('136', '4', '18', '10904');
INSERT INTO `project_role_relation` VALUES ('137', '4', '20', '10004');
INSERT INTO `project_role_relation` VALUES ('138', '4', '20', '10005');
INSERT INTO `project_role_relation` VALUES ('139', '4', '20', '10006');
INSERT INTO `project_role_relation` VALUES ('140', '4', '20', '10007');
INSERT INTO `project_role_relation` VALUES ('141', '4', '20', '10008');
INSERT INTO `project_role_relation` VALUES ('142', '4', '20', '10013');
INSERT INTO `project_role_relation` VALUES ('143', '4', '20', '10014');
INSERT INTO `project_role_relation` VALUES ('144', '4', '20', '10015');
INSERT INTO `project_role_relation` VALUES ('145', '4', '20', '10028');
INSERT INTO `project_role_relation` VALUES ('146', '4', '20', '10902');
INSERT INTO `project_role_relation` VALUES ('147', '4', '20', '10903');
INSERT INTO `project_role_relation` VALUES ('148', '4', '20', '10904');

-- ----------------------------
-- Table structure for project_user_role
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
-- Table structure for project_version
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project_version
-- ----------------------------
INSERT INTO `project_version` VALUES ('2', '10002', 'Vsersion 5.0', 'hhhh', '0', '1', null, '', '1518105600', '1518969600');
INSERT INTO `project_version` VALUES ('3', '10002', 'Vsersion 6.0', '鹅鹅鹅', '0', null, null, '', '1515427200', '1518969600');
INSERT INTO `project_version` VALUES ('4', '10002', 'Vsersion 6.0.1', 'qqq', '0', null, null, '', '1515427200', '1519056000');
INSERT INTO `project_version` VALUES ('5', '10002', 'Vsersion 6.0.2', 'ddd', '0', null, null, '', '1515427200', '1519056000');
INSERT INTO `project_version` VALUES ('6', '10002', 'Vsersion 6.0.3', 'aaa', '0', null, null, '', '1518451200', '1519747200');
INSERT INTO `project_version` VALUES ('7', '10509', 'V0.0.1', 'vvv', '0', '0', null, '', '1518969600', '1519660800');
INSERT INTO `project_version` VALUES ('8', '10509', 'V0.0.2', '2222', '0', '0', null, '', '1519142400', '1519660800');
INSERT INTO `project_version` VALUES ('9', '10003', 'Vsersion 5.0', 'hhhh', '0', '1', null, '', '1518105600', '1518969600');
INSERT INTO `project_version` VALUES ('10', '10003', 'Vsersion 6.0', '鹅鹅鹅', '0', null, null, '', '1515427200', '1518969600');
INSERT INTO `project_version` VALUES ('11', '10003', 'Vsersion 6.0.1', 'qqq', '0', null, null, '', '1515427200', '1519056000');
INSERT INTO `project_version` VALUES ('12', '10002', 'v7', '发', '0', '0', null, '', '1524067200', '1527350400');
INSERT INTO `project_version` VALUES ('13', '10002', 'v8', '发123', '0', '0', null, '', '1524067200', '1527350400');
INSERT INTO `project_version` VALUES ('14', '10002', 'v9', 'ddd', '0', '0', null, '', '1525449600', '1525795200');
INSERT INTO `project_version` VALUES ('15', '0', 'test-name', 'test-description', '0', '0', null, null, null, null);
INSERT INTO `project_version` VALUES ('16', '10701', 'test-name', 'test-description', '0', '0', null, null, null, null);

-- ----------------------------
-- Table structure for project_workflows
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
INSERT INTO `project_workflows` VALUES ('10000', 'classic default workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.description\">The classic JIRA default workflow</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create Issue\">\n      <meta name=\"opsbar-sequence\">0</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <common-actions>\n    <action id=\"2\" name=\"Close Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">60</meta>\n      <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n      <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n      <meta name=\"jira.i18n.title\">closeissue.title</meta>\n      <restrict-to>\n        <conditions type=\"AND\">\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Resolve Issue</arg>\n          </condition>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Close Issue</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">5</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"3\" name=\"Reopen Issue\" view=\"commentassign\">\n      <meta name=\"opsbar-sequence\">80</meta>\n      <meta name=\"jira.i18n.submit\">issue.operations.reopen.issue</meta>\n      <meta name=\"jira.i18n.description\">issue.operations.reopen.description</meta>\n      <meta name=\"jira.i18n.title\">issue.operations.reopen.issue</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Resolve Issue</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Reopened\" step=\"5\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"field.name\">resolution</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">7</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"4\" name=\"Start Progress\">\n      <meta name=\"opsbar-sequence\">20</meta>\n      <meta name=\"jira.i18n.title\">startprogress.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.AllowOnlyAssignee</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Underway\" step=\"3\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"field.name\">resolution</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">11</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"5\" name=\"Resolve Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">40</meta>\n      <meta name=\"jira.i18n.submit\">resolveissue.resolve</meta>\n      <meta name=\"jira.i18n.description\">resolveissue.desc.line1</meta>\n      <meta name=\"jira.i18n.title\">resolveissue.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Resolve Issue</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Resolved\" step=\"4\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">4</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </common-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n<common-action id=\"4\" />\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n      </actions>\n    </step>\n    <step id=\"3\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n        <action id=\"301\" name=\"Stop Progress\">\n          <meta name=\"opsbar-sequence\">20</meta>\n          <meta name=\"jira.i18n.title\">stopprogress.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.AllowOnlyAssignee</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Assigned\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">12</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"Resolved\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n<common-action id=\"3\" />\n        <action id=\"701\" name=\"Close Issue\" view=\"commentassign\">\n          <meta name=\"opsbar-sequence\">60</meta>\n          <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n          <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n          <meta name=\"jira.i18n.title\">closeissue.title</meta>\n          <meta name=\"jira.description\">Closing an issue indicates there is no more work to be done on it, and it has been verified as complete.</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">Close Issue</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">5</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"Reopened\">\n      <meta name=\"jira.status.id\">4</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n<common-action id=\"4\" />\n      </actions>\n    </step>\n    <step id=\"6\" name=\"Closed\">\n      <meta name=\"jira.status.id\">6</meta>\n      <meta name=\"jira.issue.editable\">false</meta>\n      <actions>\n<common-action id=\"3\" />\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10100', 'Software Simplified Workflow for Project PROJ', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.description\">Generated by JIRA Software version 6.7.7. This workflow is managed internally by JIRA Software. Do not manually modify this workflow.</meta>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.updated.date\">1438661316737</meta>\n  <meta name=\"jira.update.author.name\">admin</meta>\n  <meta name=\"gh.version\">6.7.7</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"permission\">Create Issue</arg>\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"To Do\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">1</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <global-actions>\n    <action id=\"11\" name=\"To Do\">\n      <meta name=\"jira.description\"></meta>\n      <meta name=\"jira.i18n.title\">gh.workflow.preset.todo</meta>\n      <results>\n        <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">\n                                com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">13</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"21\" name=\"In Progress\">\n      <meta name=\"jira.description\"></meta>\n      <meta name=\"jira.i18n.title\">gh.workflow.preset.inprogress</meta>\n      <results>\n        <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"6\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">\n                                com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">13</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"31\" name=\"Done\">\n      <meta name=\"jira.description\"></meta>\n      <meta name=\"jira.i18n.title\">gh.workflow.preset.done</meta>\n      <results>\n        <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"11\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\">10000</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">\n                                com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">13</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </global-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n    </step>\n    <step id=\"6\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n    </step>\n    <step id=\"11\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10101', 'IP: Software Development Workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1439433533440</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10000</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10000</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10000</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10102', 'DIAMOND: Software Development Workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1439791434353</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10103', 'WTGZL', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\">AAA</meta>\n  <meta name=\"jira.updated.date\">1447039624991</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n        <action id=\"11\" name=\"A\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"进行中\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"21\" name=\"B\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"已解决\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n        <action id=\"31\" name=\"C\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"关闭问题\">\n      <meta name=\"jira.status.id\">6</meta>\n      <actions>\n        <action id=\"41\" name=\"D\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"5\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"重启问题\">\n      <meta name=\"jira.status.id\">4</meta>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10104', 'IPAD', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1447040475323</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n        <action id=\"11\" name=\"A\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"进行中\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"21\" name=\"B\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"已解决\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n        <action id=\"31\" name=\"C\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"关闭\">\n      <meta name=\"jira.status.id\">6</meta>\n      <actions>\n        <action id=\"41\" name=\"D\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"5\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"重启问题\">\n      <meta name=\"jira.status.id\">4</meta>\n      <actions>\n        <action id=\"51\" name=\"E\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"F\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"71\" name=\"G\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10200', 'YW: Software Development Workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1460083681271</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10201', 'Copy of DIAMOND: Software Development Workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">fzj01571</meta>\n  <meta name=\"jira.description\">(这是一个当工作流\'DIAMOND: Software Development Workflow\'取消激活时从草稿自动产生的副本。)</meta>\n  <meta name=\"jira.updated.date\">1460623174865</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10202', 'ACTIVITY: Software Development Workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1463630592397</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);
INSERT INTO `project_workflows` VALUES ('10300', 'BTOB Workflow', null, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.updated.date\">1504855305491</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create Issue\">\n      <meta name=\"opsbar-sequence\">0</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"permission\">Create Issue</arg>\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">1</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <common-actions>\n    <action id=\"2\" name=\"Close Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">60</meta>\n      <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n      <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n      <meta name=\"jira.i18n.title\">closeissue.title</meta>\n      <restrict-to>\n        <conditions type=\"AND\">\n          <condition type=\"class\">\n            <arg name=\"permission\">Resolve Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n          <condition type=\"class\">\n            <arg name=\"permission\">Close Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">5</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"3\" name=\"Reopen Issue\" view=\"commentassign\">\n      <meta name=\"opsbar-sequence\">80</meta>\n      <meta name=\"jira.i18n.submit\">issue.operations.reopen.issue</meta>\n      <meta name=\"jira.i18n.description\">issue.operations.reopen.description</meta>\n      <meta name=\"jira.i18n.title\">issue.operations.reopen.issue</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"permission\">Resolve Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Reopened\" step=\"5\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">7</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"4\" name=\"Start Progress\">\n      <meta name=\"opsbar-sequence\">20</meta>\n      <meta name=\"jira.i18n.title\">startprogress.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"permission\">assignable</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Underway\" step=\"3\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">11</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"5\" name=\"Resolve Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">40</meta>\n      <meta name=\"jira.i18n.submit\">resolveissue.resolve</meta>\n      <meta name=\"jira.i18n.description\">resolveissue.desc.line1</meta>\n      <meta name=\"jira.i18n.title\">resolveissue.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"permission\">Resolve Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Resolved\" step=\"4\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">4</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </common-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n<common-action id=\"4\" />\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n      </actions>\n    </step>\n    <step id=\"3\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n        <action id=\"301\" name=\"Stop Progress\">\n          <meta name=\"opsbar-sequence\">20</meta>\n          <meta name=\"jira.i18n.title\">stopprogress.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"permission\">assignable</arg>\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Assigned\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.name\">resolution</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"eventTypeId\">12</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"Resolved\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n<common-action id=\"3\" />\n        <action id=\"701\" name=\"Close Issue\" view=\"commentassign\">\n          <meta name=\"opsbar-sequence\">60</meta>\n          <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n          <meta name=\"jira.description\">Closing an issue indicates there is no more work to be done on it, and it has been verified as complete.</meta>\n          <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n          <meta name=\"jira.i18n.title\">closeissue.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"permission\">Close Issue</arg>\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"eventTypeId\">5</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"Reopened\">\n      <meta name=\"jira.status.id\">4</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n<common-action id=\"4\" />\n      </actions>\n    </step>\n    <step id=\"6\" name=\"Closed\">\n      <meta name=\"jira.issue.editable\">false</meta>\n      <meta name=\"jira.status.id\">6</meta>\n      <actions>\n<common-action id=\"3\" />\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', null);

-- ----------------------------
-- Table structure for project_workflow_status
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
-- Table structure for report_project_issue
-- ----------------------------
DROP TABLE IF EXISTS `report_project_issue`;
CREATE TABLE `report_project_issue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) unsigned DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `count_done` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按状态进行统计',
  `count_done_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) unsigned DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) unsigned DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) unsigned DEFAULT '0' COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`),
  UNIQUE KEY `projectIdAndDate` (`project_id`,`date`) USING BTREE,
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report_project_issue
-- ----------------------------
INSERT INTO `report_project_issue` VALUES ('63', '10500', '2018-08-02', '4', '08', '5', '195', '3', '197', '13', '9');
INSERT INTO `report_project_issue` VALUES ('64', '10500', '2018-08-01', '3', '08', '8', '192', '8', '192', '15', '8');
INSERT INTO `report_project_issue` VALUES ('65', '10500', '2018-07-31', '2', '07', '5', '195', '4', '196', '14', '10');
INSERT INTO `report_project_issue` VALUES ('66', '10500', '2018-07-30', '1', '07', '10', '190', '6', '194', '17', '5');
INSERT INTO `report_project_issue` VALUES ('67', '10500', '2018-07-29', '0', '07', '8', '192', '11', '189', '12', '6');
INSERT INTO `report_project_issue` VALUES ('68', '10500', '2018-07-28', '6', '07', '7', '193', '9', '191', '6', '7');
INSERT INTO `report_project_issue` VALUES ('69', '10500', '2018-07-27', '5', '07', '13', '187', '10', '190', '20', '7');
INSERT INTO `report_project_issue` VALUES ('70', '10500', '2018-07-26', '4', '07', '12', '188', '9', '191', '17', '8');
INSERT INTO `report_project_issue` VALUES ('71', '10500', '2018-07-25', '3', '07', '10', '190', '17', '183', '5', '6');
INSERT INTO `report_project_issue` VALUES ('72', '10500', '2018-07-24', '2', '07', '18', '182', '18', '182', '6', '8');
INSERT INTO `report_project_issue` VALUES ('73', '10500', '2018-07-23', '1', '07', '14', '186', '20', '180', '8', '9');
INSERT INTO `report_project_issue` VALUES ('74', '10500', '2018-07-22', '0', '07', '21', '179', '13', '187', '6', '7');
INSERT INTO `report_project_issue` VALUES ('75', '10500', '2018-07-21', '6', '07', '15', '185', '16', '184', '14', '7');
INSERT INTO `report_project_issue` VALUES ('76', '10500', '2018-07-20', '5', '07', '22', '178', '14', '186', '11', '8');
INSERT INTO `report_project_issue` VALUES ('77', '10500', '2018-07-19', '4', '07', '22', '178', '20', '180', '18', '8');
INSERT INTO `report_project_issue` VALUES ('78', '10500', '2018-07-18', '3', '07', '25', '175', '17', '183', '16', '7');
INSERT INTO `report_project_issue` VALUES ('79', '10500', '2018-07-17', '2', '07', '20', '180', '26', '174', '14', '5');
INSERT INTO `report_project_issue` VALUES ('80', '10500', '2018-07-16', '1', '07', '18', '182', '24', '176', '7', '5');
INSERT INTO `report_project_issue` VALUES ('81', '10500', '2018-07-15', '0', '07', '23', '177', '23', '177', '14', '10');
INSERT INTO `report_project_issue` VALUES ('82', '10500', '2018-07-14', '6', '07', '29', '171', '24', '176', '12', '7');
INSERT INTO `report_project_issue` VALUES ('83', '10500', '2018-07-13', '5', '07', '21', '179', '30', '170', '12', '5');
INSERT INTO `report_project_issue` VALUES ('84', '10500', '2018-07-12', '4', '07', '26', '174', '22', '178', '12', '7');
INSERT INTO `report_project_issue` VALUES ('85', '10500', '2018-07-11', '3', '07', '25', '175', '25', '175', '16', '9');
INSERT INTO `report_project_issue` VALUES ('86', '10500', '2018-07-10', '2', '07', '29', '171', '32', '168', '16', '8');
INSERT INTO `report_project_issue` VALUES ('87', '10500', '2018-07-09', '1', '07', '28', '172', '32', '168', '19', '9');
INSERT INTO `report_project_issue` VALUES ('88', '10500', '2018-07-08', '0', '07', '31', '169', '26', '174', '19', '8');
INSERT INTO `report_project_issue` VALUES ('89', '10500', '2018-07-07', '6', '07', '29', '171', '31', '169', '19', '10');
INSERT INTO `report_project_issue` VALUES ('90', '10500', '2018-07-06', '5', '07', '33', '167', '36', '164', '12', '9');
INSERT INTO `report_project_issue` VALUES ('91', '10500', '2018-07-05', '4', '07', '31', '169', '37', '163', '11', '6');
INSERT INTO `report_project_issue` VALUES ('92', '10500', '2018-07-04', '3', '07', '39', '161', '34', '166', '16', '8');
INSERT INTO `report_project_issue` VALUES ('93', '10500', '2018-07-03', '2', '07', '36', '164', '35', '165', '10', '6');
INSERT INTO `report_project_issue` VALUES ('94', '10500', '2018-07-02', '1', '07', '38', '162', '36', '164', '11', '10');
INSERT INTO `report_project_issue` VALUES ('95', '10500', '2018-07-01', '0', '07', '39', '161', '39', '161', '14', '8');
INSERT INTO `report_project_issue` VALUES ('96', '10500', '2018-06-30', '6', '06', '41', '159', '35', '165', '15', '8');
INSERT INTO `report_project_issue` VALUES ('97', '10500', '2018-06-29', '5', '06', '44', '156', '42', '158', '15', '9');
INSERT INTO `report_project_issue` VALUES ('98', '10500', '2018-06-28', '4', '06', '37', '163', '43', '157', '5', '8');
INSERT INTO `report_project_issue` VALUES ('99', '10500', '2018-06-27', '3', '06', '44', '156', '38', '162', '19', '7');
INSERT INTO `report_project_issue` VALUES ('100', '10500', '2018-06-26', '2', '06', '45', '155', '47', '153', '7', '10');
INSERT INTO `report_project_issue` VALUES ('101', '10500', '2018-06-25', '1', '06', '46', '154', '48', '152', '16', '6');
INSERT INTO `report_project_issue` VALUES ('102', '10500', '2018-06-24', '0', '06', '49', '151', '46', '154', '7', '7');
INSERT INTO `report_project_issue` VALUES ('103', '10500', '2018-06-23', '6', '06', '47', '153', '46', '154', '11', '7');
INSERT INTO `report_project_issue` VALUES ('104', '10500', '2018-06-22', '5', '06', '44', '156', '42', '158', '16', '6');
INSERT INTO `report_project_issue` VALUES ('105', '10500', '2018-06-21', '4', '06', '43', '157', '48', '152', '19', '8');
INSERT INTO `report_project_issue` VALUES ('106', '10500', '2018-06-20', '3', '06', '47', '153', '47', '153', '7', '10');
INSERT INTO `report_project_issue` VALUES ('107', '10500', '2018-06-19', '2', '06', '50', '150', '46', '154', '6', '5');
INSERT INTO `report_project_issue` VALUES ('108', '10500', '2018-06-18', '1', '06', '53', '147', '47', '153', '14', '6');
INSERT INTO `report_project_issue` VALUES ('109', '10500', '2018-06-17', '0', '06', '54', '146', '55', '145', '18', '6');
INSERT INTO `report_project_issue` VALUES ('110', '10500', '2018-06-16', '6', '06', '53', '147', '49', '151', '7', '9');
INSERT INTO `report_project_issue` VALUES ('111', '10500', '2018-06-15', '5', '06', '56', '144', '52', '148', '16', '7');
INSERT INTO `report_project_issue` VALUES ('112', '10500', '2018-06-14', '4', '06', '58', '142', '57', '143', '6', '5');
INSERT INTO `report_project_issue` VALUES ('113', '10500', '2018-06-13', '3', '06', '54', '146', '60', '140', '15', '6');
INSERT INTO `report_project_issue` VALUES ('114', '10500', '2018-06-12', '2', '06', '57', '143', '60', '140', '14', '6');
INSERT INTO `report_project_issue` VALUES ('115', '10500', '2018-06-11', '1', '06', '60', '140', '58', '142', '7', '9');
INSERT INTO `report_project_issue` VALUES ('116', '10500', '2018-06-10', '0', '06', '57', '143', '54', '146', '18', '7');
INSERT INTO `report_project_issue` VALUES ('117', '10500', '2018-06-09', '6', '06', '58', '142', '61', '139', '14', '5');
INSERT INTO `report_project_issue` VALUES ('118', '10500', '2018-06-08', '5', '06', '64', '136', '58', '142', '11', '8');
INSERT INTO `report_project_issue` VALUES ('119', '10500', '2018-06-07', '4', '06', '65', '135', '61', '139', '11', '7');
INSERT INTO `report_project_issue` VALUES ('120', '10500', '2018-06-06', '3', '06', '60', '140', '60', '140', '16', '9');
INSERT INTO `report_project_issue` VALUES ('121', '10500', '2018-06-05', '2', '06', '59', '141', '60', '140', '20', '8');
INSERT INTO `report_project_issue` VALUES ('122', '10500', '2018-06-04', '1', '06', '68', '132', '67', '133', '11', '7');
INSERT INTO `report_project_issue` VALUES ('123', '3', '2018-10-22', '1', '10', '6', '194', '2', '198', '13', '6');
INSERT INTO `report_project_issue` VALUES ('124', '3', '2018-10-21', '0', '10', '10', '190', '4', '196', '10', '5');
INSERT INTO `report_project_issue` VALUES ('125', '3', '2018-10-20', '6', '10', '6', '194', '9', '191', '12', '10');
INSERT INTO `report_project_issue` VALUES ('126', '3', '2018-10-19', '5', '10', '8', '192', '7', '193', '20', '10');
INSERT INTO `report_project_issue` VALUES ('127', '3', '2018-10-18', '4', '10', '8', '192', '6', '194', '18', '8');
INSERT INTO `report_project_issue` VALUES ('128', '3', '2018-10-17', '3', '10', '12', '188', '9', '191', '13', '6');
INSERT INTO `report_project_issue` VALUES ('129', '3', '2018-10-16', '2', '10', '14', '186', '14', '186', '6', '10');
INSERT INTO `report_project_issue` VALUES ('130', '3', '2018-10-15', '1', '10', '17', '183', '8', '192', '19', '8');
INSERT INTO `report_project_issue` VALUES ('131', '3', '2018-10-14', '0', '10', '17', '183', '16', '184', '12', '6');
INSERT INTO `report_project_issue` VALUES ('132', '3', '2018-10-13', '6', '10', '10', '190', '15', '185', '17', '9');
INSERT INTO `report_project_issue` VALUES ('133', '3', '2018-10-12', '5', '10', '12', '188', '13', '187', '18', '9');
INSERT INTO `report_project_issue` VALUES ('134', '3', '2018-10-11', '4', '10', '18', '182', '21', '179', '10', '8');
INSERT INTO `report_project_issue` VALUES ('135', '3', '2018-10-10', '3', '10', '22', '178', '22', '178', '16', '10');
INSERT INTO `report_project_issue` VALUES ('136', '3', '2018-10-09', '2', '10', '19', '181', '21', '179', '11', '9');
INSERT INTO `report_project_issue` VALUES ('137', '3', '2018-10-08', '1', '10', '22', '178', '15', '185', '14', '9');
INSERT INTO `report_project_issue` VALUES ('138', '3', '2018-10-07', '0', '10', '21', '179', '25', '175', '5', '5');
INSERT INTO `report_project_issue` VALUES ('139', '3', '2018-10-06', '6', '10', '22', '178', '17', '183', '9', '9');
INSERT INTO `report_project_issue` VALUES ('140', '3', '2018-10-05', '5', '10', '23', '177', '22', '178', '16', '6');
INSERT INTO `report_project_issue` VALUES ('141', '3', '2018-10-04', '4', '10', '20', '180', '24', '176', '12', '7');
INSERT INTO `report_project_issue` VALUES ('142', '3', '2018-10-03', '3', '10', '26', '174', '27', '173', '20', '9');
INSERT INTO `report_project_issue` VALUES ('143', '3', '2018-10-02', '2', '10', '29', '171', '27', '173', '8', '9');
INSERT INTO `report_project_issue` VALUES ('144', '3', '2018-10-01', '1', '10', '25', '175', '24', '176', '10', '10');
INSERT INTO `report_project_issue` VALUES ('145', '3', '2018-09-30', '0', '09', '31', '169', '29', '171', '13', '6');
INSERT INTO `report_project_issue` VALUES ('146', '3', '2018-09-29', '6', '09', '25', '175', '30', '170', '12', '8');
INSERT INTO `report_project_issue` VALUES ('147', '3', '2018-09-28', '5', '09', '32', '168', '25', '175', '19', '6');
INSERT INTO `report_project_issue` VALUES ('148', '3', '2018-09-27', '4', '09', '31', '169', '32', '168', '20', '9');
INSERT INTO `report_project_issue` VALUES ('149', '3', '2018-09-26', '3', '09', '33', '167', '29', '171', '13', '7');
INSERT INTO `report_project_issue` VALUES ('150', '3', '2018-09-25', '2', '09', '33', '167', '37', '163', '6', '10');
INSERT INTO `report_project_issue` VALUES ('151', '3', '2018-09-24', '1', '09', '33', '167', '33', '167', '16', '9');
INSERT INTO `report_project_issue` VALUES ('152', '3', '2018-09-23', '0', '09', '35', '165', '32', '168', '16', '7');
INSERT INTO `report_project_issue` VALUES ('153', '3', '2018-09-22', '6', '09', '38', '162', '35', '165', '18', '10');
INSERT INTO `report_project_issue` VALUES ('154', '3', '2018-09-21', '5', '09', '39', '161', '35', '165', '5', '9');
INSERT INTO `report_project_issue` VALUES ('155', '3', '2018-09-20', '4', '09', '35', '165', '36', '164', '11', '7');
INSERT INTO `report_project_issue` VALUES ('156', '3', '2018-09-19', '3', '09', '36', '164', '40', '160', '17', '10');
INSERT INTO `report_project_issue` VALUES ('157', '3', '2018-09-18', '2', '09', '35', '165', '38', '162', '6', '9');
INSERT INTO `report_project_issue` VALUES ('158', '3', '2018-09-17', '1', '09', '45', '155', '44', '156', '6', '8');
INSERT INTO `report_project_issue` VALUES ('159', '3', '2018-09-16', '0', '09', '41', '159', '45', '155', '17', '10');
INSERT INTO `report_project_issue` VALUES ('160', '3', '2018-09-15', '6', '09', '46', '154', '46', '154', '12', '8');
INSERT INTO `report_project_issue` VALUES ('161', '3', '2018-09-14', '5', '09', '43', '157', '42', '158', '15', '10');
INSERT INTO `report_project_issue` VALUES ('162', '3', '2018-09-13', '4', '09', '40', '160', '46', '154', '7', '6');
INSERT INTO `report_project_issue` VALUES ('163', '3', '2018-09-12', '3', '09', '48', '152', '46', '154', '15', '10');
INSERT INTO `report_project_issue` VALUES ('164', '3', '2018-09-11', '2', '09', '48', '152', '50', '150', '15', '8');
INSERT INTO `report_project_issue` VALUES ('165', '3', '2018-09-10', '1', '09', '50', '150', '48', '152', '19', '5');
INSERT INTO `report_project_issue` VALUES ('166', '3', '2018-09-09', '0', '09', '44', '156', '44', '156', '19', '9');
INSERT INTO `report_project_issue` VALUES ('167', '3', '2018-09-08', '6', '09', '54', '146', '45', '155', '19', '6');
INSERT INTO `report_project_issue` VALUES ('168', '3', '2018-09-07', '5', '09', '53', '147', '48', '152', '9', '9');
INSERT INTO `report_project_issue` VALUES ('169', '3', '2018-09-06', '4', '09', '55', '145', '55', '145', '6', '8');
INSERT INTO `report_project_issue` VALUES ('170', '3', '2018-09-05', '3', '09', '55', '145', '55', '145', '19', '5');
INSERT INTO `report_project_issue` VALUES ('171', '3', '2018-09-04', '2', '09', '53', '147', '49', '151', '14', '9');
INSERT INTO `report_project_issue` VALUES ('172', '3', '2018-09-03', '1', '09', '55', '145', '50', '150', '6', '7');
INSERT INTO `report_project_issue` VALUES ('173', '3', '2018-09-02', '0', '09', '54', '146', '52', '148', '15', '6');
INSERT INTO `report_project_issue` VALUES ('174', '3', '2018-09-01', '6', '09', '58', '142', '56', '144', '8', '9');
INSERT INTO `report_project_issue` VALUES ('175', '3', '2018-08-31', '5', '08', '60', '140', '60', '140', '19', '7');
INSERT INTO `report_project_issue` VALUES ('176', '3', '2018-08-30', '4', '08', '58', '142', '63', '137', '5', '8');
INSERT INTO `report_project_issue` VALUES ('177', '3', '2018-08-29', '3', '08', '55', '145', '58', '142', '11', '5');
INSERT INTO `report_project_issue` VALUES ('178', '3', '2018-08-28', '2', '08', '56', '144', '63', '137', '9', '9');
INSERT INTO `report_project_issue` VALUES ('179', '3', '2018-08-27', '1', '08', '59', '141', '63', '137', '18', '8');
INSERT INTO `report_project_issue` VALUES ('180', '3', '2018-08-26', '0', '08', '66', '134', '65', '135', '5', '6');
INSERT INTO `report_project_issue` VALUES ('181', '3', '2018-08-25', '6', '08', '60', '140', '63', '137', '16', '8');
INSERT INTO `report_project_issue` VALUES ('182', '3', '2018-08-24', '5', '08', '69', '131', '63', '137', '8', '9');
INSERT INTO `report_project_issue` VALUES ('211', '1', '2018-10-24', '3', '10', '2', '1', '1', '2', '0', '2');
INSERT INTO `report_project_issue` VALUES ('212', '2', '2018-10-24', '3', '10', '0', '1', '0', '1', '0', '0');
INSERT INTO `report_project_issue` VALUES ('213', '3', '2018-10-24', '3', '10', '11', '18', '12', '17', '0', '11');
INSERT INTO `report_project_issue` VALUES ('214', '4', '2018-10-24', '3', '10', '0', '0', '0', '0', '0', '0');
INSERT INTO `report_project_issue` VALUES ('291', '1', '2018-10-25', '4', '10', '2', '1', '1', '2', '0', '0');
INSERT INTO `report_project_issue` VALUES ('292', '2', '2018-10-25', '4', '10', '0', '1', '0', '1', '0', '0');
INSERT INTO `report_project_issue` VALUES ('293', '3', '2018-10-25', '4', '10', '11', '18', '12', '17', '0', '9');
INSERT INTO `report_project_issue` VALUES ('294', '4', '2018-10-25', '4', '10', '0', '0', '0', '0', '0', '0');
INSERT INTO `report_project_issue` VALUES ('303', '1', '2018-10-26', '5', '10', '2', '1', '1', '2', '0', '0');
INSERT INTO `report_project_issue` VALUES ('304', '2', '2018-10-26', '5', '10', '0', '1', '0', '1', '0', '0');
INSERT INTO `report_project_issue` VALUES ('305', '3', '2018-10-26', '5', '10', '9', '18', '12', '15', '0', '7');
INSERT INTO `report_project_issue` VALUES ('306', '4', '2018-10-26', '5', '10', '0', '0', '0', '0', '0', '0');
INSERT INTO `report_project_issue` VALUES ('323', '1', '2018-10-27', '6', '10', '2', '1', '1', '2', '0', '0');
INSERT INTO `report_project_issue` VALUES ('324', '2', '2018-10-27', '6', '10', '0', '1', '0', '1', '0', '0');
INSERT INTO `report_project_issue` VALUES ('325', '3', '2018-10-27', '6', '10', '10', '17', '12', '15', '0', '8');
INSERT INTO `report_project_issue` VALUES ('326', '4', '2018-10-27', '6', '10', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for report_sprint_issue
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
  KEY `sprint_id` (`sprint_id`),
  KEY `sprintIdAndDate` (`sprint_id`,`date`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of report_sprint_issue
-- ----------------------------
INSERT INTO `report_sprint_issue` VALUES ('63', '3', '2018-08-02', '4', '08', '10', '90', '6', '94', '10', '5');
INSERT INTO `report_sprint_issue` VALUES ('64', '3', '2018-08-01', '3', '08', '2', '98', '10', '90', '15', '6');
INSERT INTO `report_sprint_issue` VALUES ('65', '3', '2018-07-31', '2', '07', '3', '97', '8', '92', '11', '10');
INSERT INTO `report_sprint_issue` VALUES ('66', '3', '2018-07-30', '1', '07', '6', '94', '12', '88', '5', '10');
INSERT INTO `report_sprint_issue` VALUES ('67', '3', '2018-07-29', '0', '07', '14', '86', '14', '86', '15', '5');
INSERT INTO `report_sprint_issue` VALUES ('68', '3', '2018-07-28', '6', '07', '15', '85', '12', '88', '14', '8');
INSERT INTO `report_sprint_issue` VALUES ('69', '3', '2018-07-27', '5', '07', '16', '84', '8', '92', '8', '6');
INSERT INTO `report_sprint_issue` VALUES ('70', '3', '2018-07-26', '4', '07', '15', '85', '11', '89', '6', '6');
INSERT INTO `report_sprint_issue` VALUES ('71', '3', '2018-07-25', '3', '07', '12', '88', '13', '87', '10', '10');
INSERT INTO `report_sprint_issue` VALUES ('72', '3', '2018-07-24', '2', '07', '11', '89', '16', '84', '18', '10');
INSERT INTO `report_sprint_issue` VALUES ('73', '3', '2018-07-23', '1', '07', '17', '83', '11', '89', '13', '9');
INSERT INTO `report_sprint_issue` VALUES ('74', '3', '2018-07-22', '0', '07', '13', '87', '16', '84', '17', '8');
INSERT INTO `report_sprint_issue` VALUES ('75', '3', '2018-07-21', '6', '07', '20', '80', '22', '78', '11', '6');
INSERT INTO `report_sprint_issue` VALUES ('76', '3', '2018-07-20', '5', '07', '22', '78', '22', '78', '15', '9');
INSERT INTO `report_sprint_issue` VALUES ('77', '3', '2018-07-19', '4', '07', '21', '79', '16', '84', '10', '5');
INSERT INTO `report_sprint_issue` VALUES ('78', '3', '2018-07-18', '3', '07', '21', '79', '19', '81', '10', '6');
INSERT INTO `report_sprint_issue` VALUES ('79', '3', '2018-07-17', '2', '07', '19', '81', '25', '75', '12', '7');
INSERT INTO `report_sprint_issue` VALUES ('80', '3', '2018-07-16', '1', '07', '18', '82', '21', '79', '9', '5');
INSERT INTO `report_sprint_issue` VALUES ('81', '3', '2018-07-15', '0', '07', '27', '73', '22', '78', '7', '10');
INSERT INTO `report_sprint_issue` VALUES ('82', '3', '2018-07-14', '6', '07', '28', '72', '24', '76', '18', '5');
INSERT INTO `report_sprint_issue` VALUES ('83', '3', '2018-07-13', '5', '07', '30', '70', '25', '75', '18', '9');
INSERT INTO `report_sprint_issue` VALUES ('84', '3', '2018-07-12', '4', '07', '24', '76', '27', '73', '6', '5');
INSERT INTO `report_sprint_issue` VALUES ('85', '3', '2018-07-11', '3', '07', '31', '69', '24', '76', '10', '9');
INSERT INTO `report_sprint_issue` VALUES ('86', '3', '2018-07-10', '2', '07', '27', '73', '24', '76', '10', '5');
INSERT INTO `report_sprint_issue` VALUES ('87', '3', '2018-07-09', '1', '07', '34', '66', '29', '71', '7', '6');
INSERT INTO `report_sprint_issue` VALUES ('88', '3', '2018-07-08', '0', '07', '32', '68', '26', '74', '8', '10');
INSERT INTO `report_sprint_issue` VALUES ('89', '3', '2018-07-07', '6', '07', '34', '66', '30', '70', '6', '10');
INSERT INTO `report_sprint_issue` VALUES ('90', '3', '2018-07-06', '5', '07', '36', '64', '28', '72', '18', '6');
INSERT INTO `report_sprint_issue` VALUES ('91', '3', '2018-07-05', '4', '07', '38', '62', '35', '65', '14', '5');
INSERT INTO `report_sprint_issue` VALUES ('92', '3', '2018-07-04', '3', '07', '32', '68', '36', '64', '8', '8');
INSERT INTO `report_sprint_issue` VALUES ('93', '3', '2018-07-03', '2', '07', '32', '68', '39', '61', '8', '5');
INSERT INTO `report_sprint_issue` VALUES ('94', '3', '2018-07-02', '1', '07', '32', '68', '41', '59', '7', '8');
INSERT INTO `report_sprint_issue` VALUES ('95', '3', '2018-07-01', '0', '07', '33', '67', '33', '67', '6', '5');
INSERT INTO `report_sprint_issue` VALUES ('96', '3', '2018-06-30', '6', '06', '35', '65', '34', '66', '6', '10');
INSERT INTO `report_sprint_issue` VALUES ('97', '3', '2018-06-29', '5', '06', '36', '64', '37', '63', '20', '8');
INSERT INTO `report_sprint_issue` VALUES ('98', '3', '2018-06-28', '4', '06', '42', '58', '41', '59', '16', '7');
INSERT INTO `report_sprint_issue` VALUES ('99', '3', '2018-06-27', '3', '06', '43', '57', '37', '63', '20', '7');
INSERT INTO `report_sprint_issue` VALUES ('100', '3', '2018-06-26', '2', '06', '45', '55', '47', '53', '16', '9');
INSERT INTO `report_sprint_issue` VALUES ('101', '3', '2018-06-25', '1', '06', '43', '57', '39', '61', '10', '8');
INSERT INTO `report_sprint_issue` VALUES ('102', '3', '2018-06-24', '0', '06', '41', '59', '40', '60', '11', '6');
INSERT INTO `report_sprint_issue` VALUES ('103', '3', '2018-06-23', '6', '06', '43', '57', '50', '50', '15', '7');
INSERT INTO `report_sprint_issue` VALUES ('104', '3', '2018-06-22', '5', '06', '46', '54', '50', '50', '8', '7');
INSERT INTO `report_sprint_issue` VALUES ('105', '3', '2018-06-21', '4', '06', '49', '51', '52', '48', '19', '7');
INSERT INTO `report_sprint_issue` VALUES ('106', '3', '2018-06-20', '3', '06', '48', '52', '49', '51', '20', '5');
INSERT INTO `report_sprint_issue` VALUES ('107', '3', '2018-06-19', '2', '06', '50', '50', '50', '50', '11', '9');
INSERT INTO `report_sprint_issue` VALUES ('108', '3', '2018-06-18', '1', '06', '52', '48', '52', '48', '12', '8');
INSERT INTO `report_sprint_issue` VALUES ('109', '3', '2018-06-17', '0', '06', '53', '47', '51', '49', '8', '6');
INSERT INTO `report_sprint_issue` VALUES ('110', '3', '2018-06-16', '6', '06', '55', '45', '49', '51', '6', '5');
INSERT INTO `report_sprint_issue` VALUES ('111', '3', '2018-06-15', '5', '06', '50', '50', '58', '42', '17', '10');
INSERT INTO `report_sprint_issue` VALUES ('112', '3', '2018-06-14', '4', '06', '50', '50', '55', '45', '16', '9');
INSERT INTO `report_sprint_issue` VALUES ('113', '3', '2018-06-13', '3', '06', '56', '44', '60', '40', '20', '7');
INSERT INTO `report_sprint_issue` VALUES ('114', '3', '2018-06-12', '2', '06', '59', '41', '52', '48', '20', '9');
INSERT INTO `report_sprint_issue` VALUES ('115', '3', '2018-06-11', '1', '06', '54', '46', '62', '38', '13', '8');
INSERT INTO `report_sprint_issue` VALUES ('116', '3', '2018-06-10', '0', '06', '60', '40', '56', '44', '15', '7');
INSERT INTO `report_sprint_issue` VALUES ('117', '3', '2018-06-09', '6', '06', '57', '43', '60', '40', '20', '5');
INSERT INTO `report_sprint_issue` VALUES ('118', '3', '2018-06-08', '5', '06', '56', '44', '65', '35', '11', '10');
INSERT INTO `report_sprint_issue` VALUES ('119', '3', '2018-06-07', '4', '06', '61', '39', '59', '41', '16', '7');
INSERT INTO `report_sprint_issue` VALUES ('120', '3', '2018-06-06', '3', '06', '67', '33', '67', '33', '6', '6');
INSERT INTO `report_sprint_issue` VALUES ('121', '3', '2018-06-05', '2', '06', '59', '41', '62', '38', '14', '6');
INSERT INTO `report_sprint_issue` VALUES ('122', '3', '2018-06-04', '1', '06', '60', '40', '63', '37', '5', '9');

-- ----------------------------
-- Table structure for service_config
-- ----------------------------
DROP TABLE IF EXISTS `service_config`;
CREATE TABLE `service_config` (
  `id` decimal(18,0) NOT NULL,
  `delaytime` decimal(18,0) DEFAULT NULL,
  `clazz` varchar(255) DEFAULT NULL,
  `servicename` varchar(255) DEFAULT NULL,
  `cron_expression` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service_config
-- ----------------------------
INSERT INTO `service_config` VALUES ('10000', '60000', 'com.atlassian.jira.service.services.mail.MailQueueService', 'Mail Queue Service', '0 * * * * ?');
INSERT INTO `service_config` VALUES ('10001', '43200000', 'com.atlassian.jira.service.services.export.ExportService', 'Backup Service', '0 15 5/12 * * ?');
INSERT INTO `service_config` VALUES ('10002', '86400000', 'com.atlassian.jira.service.services.auditing.AuditLogCleaningService', 'Audit log cleaning service', '0 15 17 * * ?');
INSERT INTO `service_config` VALUES ('10801', '3600000', 'com.atlassian.jira.plugin.ext.subversion.revisions.scheduling.clustersafe.UpdateSvnIndexService', 'Subversion Index Update Service', null);

-- ----------------------------
-- Table structure for user_email_active
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_email_active
-- ----------------------------
INSERT INTO `user_email_active` VALUES ('1', 'huangjie', '465175275@qq.com', '10827', 'K14V9XW41UBZVD3S9LFF4327YY8YQTM1', '1523628779');
INSERT INTO `user_email_active` VALUES ('2', 'huangjie', '465175275@qq.com', '10831', '74MXCQCDKCOFUJEFNGO8YM9787C5GQOF', '1523628854');
INSERT INTO `user_email_active` VALUES ('3', '19081381571', '19081381571@masterlab.org', '11299', 'GV18YT5CRRNIP0ER8J7E0R2V45TWIC5X', '1536218573');
INSERT INTO `user_email_active` VALUES ('4', '19055406672', '19055406672@masterlab.org', '11336', '61NQU4T4JQLFY3CAZDH0Q11G5SL6Z12G', '1536219700');
INSERT INTO `user_email_active` VALUES ('5', '19080125602', '19080125602@masterlab.org', '11361', '9U1MWHHTYJHLOM9PPDCVKJ2FQRHC6IS4', '1536219834');

-- ----------------------------
-- Table structure for user_email_find_password
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
INSERT INTO `user_email_find_password` VALUES ('19064656538@masterlab.org', '0', 'GXYPZ3J16EJOAKQARET9WJ1VVYFUKDV3', '1535594723');
INSERT INTO `user_email_find_password` VALUES ('465175275@qq.com', '0', 'QHJJWZZ4EC0WNMVPOGAXWWGEBL3GDLGX', '1523628463');

-- ----------------------------
-- Table structure for user_email_token
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
-- Table structure for user_group
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
) ENGINE=InnoDB AUTO_INCREMENT=10528 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES ('10000', '10000', '1');
INSERT INTO `user_group` VALUES ('10001', '10000', '2');
INSERT INTO `user_group` VALUES ('10224', '10000', '6');
INSERT INTO `user_group` VALUES ('10220', '10100', '1');
INSERT INTO `user_group` VALUES ('10223', '10100', '6');
INSERT INTO `user_group` VALUES ('10226', '10101', '6');
INSERT INTO `user_group` VALUES ('10219', '10102', '1');
INSERT INTO `user_group` VALUES ('10221', '10104', '1');
INSERT INTO `user_group` VALUES ('10228', '10111', '1');
INSERT INTO `user_group` VALUES ('10225', '10111', '6');
INSERT INTO `user_group` VALUES ('10222', '10114', '1');
INSERT INTO `user_group` VALUES ('10002', '10115', '1');
INSERT INTO `user_group` VALUES ('10010', '10115', '2');
INSERT INTO `user_group` VALUES ('10111', '10115', '3');
INSERT INTO `user_group` VALUES ('10210', '10115', '4');
INSERT INTO `user_group` VALUES ('10227', '10115', '6');
INSERT INTO `user_group` VALUES ('10215', '10826', '1');
INSERT INTO `user_group` VALUES ('10213', '10826', '4');
INSERT INTO `user_group` VALUES ('10214', '10826', '5');
INSERT INTO `user_group` VALUES ('10229', '10910', '1');
INSERT INTO `user_group` VALUES ('10230', '10910', '2');
INSERT INTO `user_group` VALUES ('10231', '10911', '1');
INSERT INTO `user_group` VALUES ('10232', '10912', '1');
INSERT INTO `user_group` VALUES ('10233', '10912', '2');
INSERT INTO `user_group` VALUES ('10234', '10913', '1');
INSERT INTO `user_group` VALUES ('10235', '10914', '1');
INSERT INTO `user_group` VALUES ('10236', '10914', '2');
INSERT INTO `user_group` VALUES ('10237', '10915', '1');
INSERT INTO `user_group` VALUES ('10238', '10916', '1');
INSERT INTO `user_group` VALUES ('10239', '10916', '2');
INSERT INTO `user_group` VALUES ('10240', '10917', '1');
INSERT INTO `user_group` VALUES ('10241', '10918', '1');
INSERT INTO `user_group` VALUES ('10242', '10918', '2');
INSERT INTO `user_group` VALUES ('10243', '10919', '1');
INSERT INTO `user_group` VALUES ('10244', '10920', '1');
INSERT INTO `user_group` VALUES ('10245', '10920', '2');
INSERT INTO `user_group` VALUES ('10246', '10921', '1');
INSERT INTO `user_group` VALUES ('10247', '10922', '1');
INSERT INTO `user_group` VALUES ('10248', '10922', '2');
INSERT INTO `user_group` VALUES ('10249', '10923', '1');
INSERT INTO `user_group` VALUES ('10250', '10924', '1');
INSERT INTO `user_group` VALUES ('10251', '10924', '2');
INSERT INTO `user_group` VALUES ('10252', '10925', '1');
INSERT INTO `user_group` VALUES ('10253', '10926', '1');
INSERT INTO `user_group` VALUES ('10254', '10926', '2');
INSERT INTO `user_group` VALUES ('10255', '10927', '1');
INSERT INTO `user_group` VALUES ('10352', '11119', '1');
INSERT INTO `user_group` VALUES ('10353', '11119', '2');
INSERT INTO `user_group` VALUES ('10256', '11202', '1');
INSERT INTO `user_group` VALUES ('10257', '11203', '1');
INSERT INTO `user_group` VALUES ('10258', '11204', '1');
INSERT INTO `user_group` VALUES ('10259', '11205', '1');
INSERT INTO `user_group` VALUES ('10260', '11206', '1');
INSERT INTO `user_group` VALUES ('10261', '11207', '1');
INSERT INTO `user_group` VALUES ('10262', '11208', '1');
INSERT INTO `user_group` VALUES ('10263', '11209', '1');
INSERT INTO `user_group` VALUES ('10264', '11210', '1');
INSERT INTO `user_group` VALUES ('10265', '11211', '1');
INSERT INTO `user_group` VALUES ('10266', '11212', '1');
INSERT INTO `user_group` VALUES ('10267', '11213', '1');
INSERT INTO `user_group` VALUES ('10268', '11214', '1');
INSERT INTO `user_group` VALUES ('10269', '11215', '1');
INSERT INTO `user_group` VALUES ('10270', '11216', '1');
INSERT INTO `user_group` VALUES ('10271', '11217', '1');
INSERT INTO `user_group` VALUES ('10272', '11218', '1');
INSERT INTO `user_group` VALUES ('10273', '11219', '1');
INSERT INTO `user_group` VALUES ('10274', '11220', '1');
INSERT INTO `user_group` VALUES ('10275', '11221', '1');
INSERT INTO `user_group` VALUES ('10276', '11222', '1');
INSERT INTO `user_group` VALUES ('10277', '11223', '1');
INSERT INTO `user_group` VALUES ('10278', '11224', '1');
INSERT INTO `user_group` VALUES ('10279', '11225', '1');
INSERT INTO `user_group` VALUES ('10280', '11226', '1');
INSERT INTO `user_group` VALUES ('10281', '11227', '1');
INSERT INTO `user_group` VALUES ('10282', '11228', '1');
INSERT INTO `user_group` VALUES ('10283', '11229', '1');
INSERT INTO `user_group` VALUES ('10284', '11230', '1');
INSERT INTO `user_group` VALUES ('10285', '11231', '1');
INSERT INTO `user_group` VALUES ('10286', '11232', '1');
INSERT INTO `user_group` VALUES ('10287', '11233', '1');
INSERT INTO `user_group` VALUES ('10288', '11234', '1');
INSERT INTO `user_group` VALUES ('10289', '11235', '1');
INSERT INTO `user_group` VALUES ('10290', '11236', '1');
INSERT INTO `user_group` VALUES ('10291', '11237', '1');
INSERT INTO `user_group` VALUES ('10292', '11238', '1');
INSERT INTO `user_group` VALUES ('10293', '11239', '1');
INSERT INTO `user_group` VALUES ('10294', '11240', '1');
INSERT INTO `user_group` VALUES ('10295', '11241', '1');
INSERT INTO `user_group` VALUES ('10296', '11242', '1');
INSERT INTO `user_group` VALUES ('10297', '11243', '1');
INSERT INTO `user_group` VALUES ('10298', '11244', '1');
INSERT INTO `user_group` VALUES ('10299', '11245', '1');
INSERT INTO `user_group` VALUES ('10300', '11246', '1');
INSERT INTO `user_group` VALUES ('10301', '11247', '1');
INSERT INTO `user_group` VALUES ('10302', '11248', '1');
INSERT INTO `user_group` VALUES ('10303', '11249', '1');
INSERT INTO `user_group` VALUES ('10304', '11250', '1');
INSERT INTO `user_group` VALUES ('10305', '11251', '1');
INSERT INTO `user_group` VALUES ('10306', '11252', '1');
INSERT INTO `user_group` VALUES ('10307', '11253', '1');
INSERT INTO `user_group` VALUES ('10308', '11254', '1');
INSERT INTO `user_group` VALUES ('10309', '11255', '1');
INSERT INTO `user_group` VALUES ('10310', '11256', '1');
INSERT INTO `user_group` VALUES ('10311', '11257', '1');
INSERT INTO `user_group` VALUES ('10312', '11258', '1');
INSERT INTO `user_group` VALUES ('10313', '11259', '1');
INSERT INTO `user_group` VALUES ('10314', '11260', '1');
INSERT INTO `user_group` VALUES ('10315', '11261', '1');
INSERT INTO `user_group` VALUES ('10316', '11262', '1');
INSERT INTO `user_group` VALUES ('10317', '11263', '1');
INSERT INTO `user_group` VALUES ('10318', '11264', '1');
INSERT INTO `user_group` VALUES ('10319', '11265', '1');
INSERT INTO `user_group` VALUES ('10320', '11265', '2');
INSERT INTO `user_group` VALUES ('10321', '11265', '3');
INSERT INTO `user_group` VALUES ('10322', '11265', '4');
INSERT INTO `user_group` VALUES ('10323', '11265', '5');
INSERT INTO `user_group` VALUES ('10324', '11265', '8');
INSERT INTO `user_group` VALUES ('10325', '11276', '1');
INSERT INTO `user_group` VALUES ('10326', '11276', '2');
INSERT INTO `user_group` VALUES ('10327', '11276', '3');
INSERT INTO `user_group` VALUES ('10328', '11276', '4');
INSERT INTO `user_group` VALUES ('10329', '11276', '5');
INSERT INTO `user_group` VALUES ('10330', '11276', '8');
INSERT INTO `user_group` VALUES ('10331', '11287', '1');
INSERT INTO `user_group` VALUES ('10332', '11288', '1');
INSERT INTO `user_group` VALUES ('10333', '11288', '2');
INSERT INTO `user_group` VALUES ('10334', '11288', '3');
INSERT INTO `user_group` VALUES ('10335', '11288', '4');
INSERT INTO `user_group` VALUES ('10336', '11288', '5');
INSERT INTO `user_group` VALUES ('10337', '11288', '8');
INSERT INTO `user_group` VALUES ('10338', '11300', '1');
INSERT INTO `user_group` VALUES ('10339', '11301', '1');
INSERT INTO `user_group` VALUES ('10340', '11301', '2');
INSERT INTO `user_group` VALUES ('10341', '11301', '3');
INSERT INTO `user_group` VALUES ('10342', '11301', '4');
INSERT INTO `user_group` VALUES ('10343', '11301', '5');
INSERT INTO `user_group` VALUES ('10344', '11301', '8');
INSERT INTO `user_group` VALUES ('10345', '11312', '1');
INSERT INTO `user_group` VALUES ('10346', '11313', '1');
INSERT INTO `user_group` VALUES ('10347', '11313', '2');
INSERT INTO `user_group` VALUES ('10348', '11313', '3');
INSERT INTO `user_group` VALUES ('10349', '11313', '4');
INSERT INTO `user_group` VALUES ('10350', '11313', '5');
INSERT INTO `user_group` VALUES ('10351', '11313', '8');
INSERT INTO `user_group` VALUES ('10354', '11324', '1');
INSERT INTO `user_group` VALUES ('10355', '11325', '1');
INSERT INTO `user_group` VALUES ('10356', '11325', '2');
INSERT INTO `user_group` VALUES ('10357', '11325', '3');
INSERT INTO `user_group` VALUES ('10358', '11325', '4');
INSERT INTO `user_group` VALUES ('10359', '11325', '5');
INSERT INTO `user_group` VALUES ('10360', '11325', '8');
INSERT INTO `user_group` VALUES ('10361', '11337', '1');
INSERT INTO `user_group` VALUES ('10368', '11338', '1');
INSERT INTO `user_group` VALUES ('10369', '11338', '2');
INSERT INTO `user_group` VALUES ('10370', '11349', '1');
INSERT INTO `user_group` VALUES ('10371', '11350', '1');
INSERT INTO `user_group` VALUES ('10372', '11350', '2');
INSERT INTO `user_group` VALUES ('10373', '11350', '3');
INSERT INTO `user_group` VALUES ('10374', '11350', '4');
INSERT INTO `user_group` VALUES ('10375', '11350', '5');
INSERT INTO `user_group` VALUES ('10376', '11350', '8');
INSERT INTO `user_group` VALUES ('10377', '11362', '1');
INSERT INTO `user_group` VALUES ('10378', '11363', '1');
INSERT INTO `user_group` VALUES ('10379', '11363', '2');
INSERT INTO `user_group` VALUES ('10380', '11363', '3');
INSERT INTO `user_group` VALUES ('10381', '11363', '4');
INSERT INTO `user_group` VALUES ('10382', '11363', '5');
INSERT INTO `user_group` VALUES ('10383', '11363', '8');
INSERT INTO `user_group` VALUES ('10384', '11375', '1');
INSERT INTO `user_group` VALUES ('10385', '11376', '1');
INSERT INTO `user_group` VALUES ('10386', '11376', '2');
INSERT INTO `user_group` VALUES ('10387', '11376', '3');
INSERT INTO `user_group` VALUES ('10388', '11376', '4');
INSERT INTO `user_group` VALUES ('10389', '11376', '5');
INSERT INTO `user_group` VALUES ('10390', '11376', '8');
INSERT INTO `user_group` VALUES ('10391', '11388', '1');
INSERT INTO `user_group` VALUES ('10392', '11389', '1');
INSERT INTO `user_group` VALUES ('10393', '11389', '2');
INSERT INTO `user_group` VALUES ('10394', '11389', '3');
INSERT INTO `user_group` VALUES ('10395', '11389', '4');
INSERT INTO `user_group` VALUES ('10396', '11389', '5');
INSERT INTO `user_group` VALUES ('10397', '11389', '8');
INSERT INTO `user_group` VALUES ('10398', '11401', '1');
INSERT INTO `user_group` VALUES ('10399', '11402', '1');
INSERT INTO `user_group` VALUES ('10400', '11402', '2');
INSERT INTO `user_group` VALUES ('10401', '11402', '3');
INSERT INTO `user_group` VALUES ('10402', '11402', '4');
INSERT INTO `user_group` VALUES ('10403', '11402', '5');
INSERT INTO `user_group` VALUES ('10404', '11402', '8');
INSERT INTO `user_group` VALUES ('10405', '11414', '1');
INSERT INTO `user_group` VALUES ('10406', '11415', '1');
INSERT INTO `user_group` VALUES ('10407', '11415', '2');
INSERT INTO `user_group` VALUES ('10408', '11415', '3');
INSERT INTO `user_group` VALUES ('10409', '11415', '4');
INSERT INTO `user_group` VALUES ('10410', '11415', '5');
INSERT INTO `user_group` VALUES ('10411', '11415', '8');
INSERT INTO `user_group` VALUES ('10412', '11426', '1');
INSERT INTO `user_group` VALUES ('10413', '11427', '1');
INSERT INTO `user_group` VALUES ('10414', '11427', '2');
INSERT INTO `user_group` VALUES ('10415', '11427', '3');
INSERT INTO `user_group` VALUES ('10416', '11427', '4');
INSERT INTO `user_group` VALUES ('10417', '11427', '5');
INSERT INTO `user_group` VALUES ('10418', '11427', '8');
INSERT INTO `user_group` VALUES ('10419', '11438', '1');
INSERT INTO `user_group` VALUES ('10420', '11439', '1');
INSERT INTO `user_group` VALUES ('10421', '11439', '2');
INSERT INTO `user_group` VALUES ('10422', '11439', '3');
INSERT INTO `user_group` VALUES ('10423', '11439', '4');
INSERT INTO `user_group` VALUES ('10424', '11439', '5');
INSERT INTO `user_group` VALUES ('10425', '11439', '8');
INSERT INTO `user_group` VALUES ('10426', '11451', '1');
INSERT INTO `user_group` VALUES ('10427', '11452', '1');
INSERT INTO `user_group` VALUES ('10428', '11452', '2');
INSERT INTO `user_group` VALUES ('10429', '11452', '3');
INSERT INTO `user_group` VALUES ('10430', '11452', '4');
INSERT INTO `user_group` VALUES ('10431', '11452', '5');
INSERT INTO `user_group` VALUES ('10432', '11452', '8');
INSERT INTO `user_group` VALUES ('10433', '11464', '1');
INSERT INTO `user_group` VALUES ('10434', '11465', '1');
INSERT INTO `user_group` VALUES ('10435', '11465', '2');
INSERT INTO `user_group` VALUES ('10436', '11465', '3');
INSERT INTO `user_group` VALUES ('10437', '11465', '4');
INSERT INTO `user_group` VALUES ('10438', '11465', '5');
INSERT INTO `user_group` VALUES ('10439', '11465', '8');
INSERT INTO `user_group` VALUES ('10440', '11476', '1');
INSERT INTO `user_group` VALUES ('10441', '11477', '1');
INSERT INTO `user_group` VALUES ('10442', '11477', '2');
INSERT INTO `user_group` VALUES ('10443', '11477', '3');
INSERT INTO `user_group` VALUES ('10444', '11477', '4');
INSERT INTO `user_group` VALUES ('10445', '11477', '5');
INSERT INTO `user_group` VALUES ('10446', '11477', '8');
INSERT INTO `user_group` VALUES ('10447', '11488', '1');
INSERT INTO `user_group` VALUES ('10448', '11489', '1');
INSERT INTO `user_group` VALUES ('10449', '11489', '2');
INSERT INTO `user_group` VALUES ('10450', '11489', '3');
INSERT INTO `user_group` VALUES ('10451', '11489', '4');
INSERT INTO `user_group` VALUES ('10452', '11489', '5');
INSERT INTO `user_group` VALUES ('10453', '11489', '8');
INSERT INTO `user_group` VALUES ('10454', '11500', '1');
INSERT INTO `user_group` VALUES ('10455', '11501', '1');
INSERT INTO `user_group` VALUES ('10456', '11501', '2');
INSERT INTO `user_group` VALUES ('10457', '11501', '3');
INSERT INTO `user_group` VALUES ('10458', '11501', '4');
INSERT INTO `user_group` VALUES ('10459', '11501', '5');
INSERT INTO `user_group` VALUES ('10460', '11501', '8');
INSERT INTO `user_group` VALUES ('10461', '11512', '1');
INSERT INTO `user_group` VALUES ('10462', '11513', '1');
INSERT INTO `user_group` VALUES ('10463', '11513', '2');
INSERT INTO `user_group` VALUES ('10464', '11513', '3');
INSERT INTO `user_group` VALUES ('10465', '11513', '4');
INSERT INTO `user_group` VALUES ('10466', '11513', '5');
INSERT INTO `user_group` VALUES ('10467', '11513', '8');
INSERT INTO `user_group` VALUES ('10468', '11524', '1');
INSERT INTO `user_group` VALUES ('10469', '11525', '1');
INSERT INTO `user_group` VALUES ('10470', '11525', '2');
INSERT INTO `user_group` VALUES ('10471', '11525', '3');
INSERT INTO `user_group` VALUES ('10472', '11525', '4');
INSERT INTO `user_group` VALUES ('10473', '11525', '5');
INSERT INTO `user_group` VALUES ('10474', '11525', '8');
INSERT INTO `user_group` VALUES ('10475', '11536', '1');
INSERT INTO `user_group` VALUES ('10476', '11537', '1');
INSERT INTO `user_group` VALUES ('10477', '11537', '2');
INSERT INTO `user_group` VALUES ('10478', '11537', '3');
INSERT INTO `user_group` VALUES ('10479', '11537', '4');
INSERT INTO `user_group` VALUES ('10480', '11537', '5');
INSERT INTO `user_group` VALUES ('10481', '11537', '8');
INSERT INTO `user_group` VALUES ('10482', '11548', '1');
INSERT INTO `user_group` VALUES ('10489', '11549', '1');
INSERT INTO `user_group` VALUES ('10490', '11549', '2');
INSERT INTO `user_group` VALUES ('10491', '11561', '1');
INSERT INTO `user_group` VALUES ('10492', '11562', '1');
INSERT INTO `user_group` VALUES ('10493', '11562', '2');
INSERT INTO `user_group` VALUES ('10494', '11562', '3');
INSERT INTO `user_group` VALUES ('10495', '11562', '4');
INSERT INTO `user_group` VALUES ('10496', '11562', '5');
INSERT INTO `user_group` VALUES ('10497', '11562', '8');
INSERT INTO `user_group` VALUES ('10498', '11575', '1');
INSERT INTO `user_group` VALUES ('10505', '11576', '1');
INSERT INTO `user_group` VALUES ('10506', '11576', '2');
INSERT INTO `user_group` VALUES ('10507', '11589', '1');
INSERT INTO `user_group` VALUES ('10508', '11590', '1');
INSERT INTO `user_group` VALUES ('10509', '11590', '2');
INSERT INTO `user_group` VALUES ('10510', '11590', '3');
INSERT INTO `user_group` VALUES ('10511', '11590', '4');
INSERT INTO `user_group` VALUES ('10512', '11590', '5');
INSERT INTO `user_group` VALUES ('10513', '11590', '8');
INSERT INTO `user_group` VALUES ('10514', '11601', '1');
INSERT INTO `user_group` VALUES ('10521', '11602', '1');
INSERT INTO `user_group` VALUES ('10522', '11602', '2');
INSERT INTO `user_group` VALUES ('10523', '11615', '1');
INSERT INTO `user_group` VALUES ('10524', '11616', '1');
INSERT INTO `user_group` VALUES ('10525', '11617', '1');
INSERT INTO `user_group` VALUES ('10526', '11618', '1');
INSERT INTO `user_group` VALUES ('10527', '11619', '1');

-- ----------------------------
-- Table structure for user_ip_login_times
-- ----------------------------
DROP TABLE IF EXISTS `user_ip_login_times`;
CREATE TABLE `user_ip_login_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `times` int(11) NOT NULL DEFAULT '0',
  `up_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_ip_login_times
-- ----------------------------
INSERT INTO `user_ip_login_times` VALUES ('1', '1902454631', '0', '1527260906');
INSERT INTO `user_ip_login_times` VALUES ('2', '1906299743', '4', '1527260936');

-- ----------------------------
-- Table structure for user_login_log
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
) ENGINE=InnoDB AUTO_INCREMENT=669 DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- ----------------------------
-- Records of user_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for user_main
-- ----------------------------
DROP TABLE IF EXISTS `user_main`;
CREATE TABLE `user_main` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `directory_id` int(11) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `openid` varchar(32) NOT NULL,
  `status` tinyint(2) DEFAULT '1',
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
  KEY `email` (`email`),
  KEY `username` (`username`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=11658 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_main
-- ----------------------------
INSERT INTO `user_main` VALUES ('10000', '1', '18002516775', 'cdwei', 'b7a782741f667201b54880c925faec4b', '1', '', '韦朝夺', 'Sven', '121642038@qq.com', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', '1', '', '0', '0', 'avatar/10000.png?t=1539826289', '', null, null, null, null, '1540622238', '0', '0', '产品经理 & 技术经理', '努力是为了让自己更快乐~');
INSERT INTO `user_main` VALUES ('11652', null, null, '79720699@qq.com', '8ceb21e5b4b18e6ae2f63f4568ffcca6', '1', null, null, '韦哥', '79720699@qq.com', '$2y$10$qZQaNkcprlkr4/T.yk30POfWapHaVf2sYXhVvvdhdJ2kVOy4Mf1Le', '0', null, '1536721687', '0', '', '', null, null, null, '', '0', '0', '0', 'coo', null);
INSERT INTO `user_main` VALUES ('11653', null, null, 'luxueting@qq.com', '37768ff1f406a7ffeb869a39fb84f005', '1', null, null, '陆雪婷', 'luxueting@qq.com', '$2y$10$YpOrL9dehAD9oo1UZ2e38ujSd.TuC6yV5eq2yQp2knLBpU09uomiq', '0', null, '1536721754', '0', '', '', null, null, null, '', '0', '0', '0', 'CI', null);
INSERT INTO `user_main` VALUES ('11654', null, null, '1043423813@qq.com', '7874f7ec72dc03d77bd1627c0350a770', '1', null, null, 'Jelly', '1043423813@qq.com', '$2y$10$d6rrId1okEVAC8yQweeLZ.Ri8HfiBLosXG2A6i05QsGenhCl8Mtce', '0', '', '1539092584', '0', 'avatar/11654.png?t=1539845533', '', null, null, null, '', '1539845064', '0', '0', '高级前端工程师', null);
INSERT INTO `user_main` VALUES ('11655', null, null, 'moxao@vip.qq.com', '44466a8b2af46b8de06fb2846e4ba97b', '1', null, null, 'Mo', 'moxao@vip.qq.com', '$2y$10$OmoUAOqSilUDOGM1ZGm1vuKMZLV/oSHYsXUDK4S3h/oJD14MWKFdu', '0', '', '1539092621', '0', 'avatar/11655.png?t=1539770756', '', null, null, null, '', '1539758227', '0', '0', '高级设计师', null);
INSERT INTO `user_main` VALUES ('11656', null, null, '23335096@qq.com', '63db4462b453ac29a280bade38e8b3d6', '1', null, null, '李建', '23335096@qq.com', '$2y$10$V.OsAQuPq0V1pymlhE1.yuXE7aJRaKUOVDvB5k0Zj5/SOSNLptzbW', '1', '', '1539092741', '0', 'avatar/11656.png', '', null, null, null, '', '1539571520', '0', '0', 'CTO', null);
INSERT INTO `user_main` VALUES ('11657', null, null, '296459175@qq.com', '31cca79124bdd459995b52a391d54e49', '1', null, null, '陈方铭', '296459175@qq.com', '$2y$10$fN8VbuEfd.BWqmVW/Q.zd.jGB4TJWwrsUq/Dze11Mrq0ftNFBn3zG', '1', '', '1539158699', '0', 'avatar/11657.png?t=1539830329', '', null, null, null, '', '1540172861', '0', '0', '开发工程师', null);

-- ----------------------------
-- Table structure for user_message
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
-- Table structure for user_password
-- ----------------------------
DROP TABLE IF EXISTS `user_password`;
CREATE TABLE `user_password` (
  `uid` int(10) unsigned NOT NULL,
  `hash` varchar(72) DEFAULT '' COMMENT 'password_hash()值',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_password
-- ----------------------------

-- ----------------------------
-- Table structure for user_password_strategy
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
-- Table structure for user_phone_find_password
-- ----------------------------
DROP TABLE IF EXISTS `user_phone_find_password`;
CREATE TABLE `user_phone_find_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) NOT NULL,
  `verify_code` varchar(128) NOT NULL DEFAULT '',
  `time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='找回密码表';

-- ----------------------------
-- Records of user_phone_find_password
-- ----------------------------

-- ----------------------------
-- Table structure for user_refresh_token
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
-- Table structure for user_setting
-- ----------------------------
DROP TABLE IF EXISTS `user_setting`;
CREATE TABLE `user_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `_key` varchar(64) DEFAULT NULL,
  `_value` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_setting
-- ----------------------------
INSERT INTO `user_setting` VALUES ('1', '0', 'email_format', 'text');
INSERT INTO `user_setting` VALUES ('2', '0', 'activity_page_size', '100');
INSERT INTO `user_setting` VALUES ('3', '0', 'share', 'public');
INSERT INTO `user_setting` VALUES ('4', '0', 'notify_other', '0');
INSERT INTO `user_setting` VALUES ('5', '0', 'auto_watch_my', '1');
INSERT INTO `user_setting` VALUES ('6', '10896', 'test_key', 'test_value');
INSERT INTO `user_setting` VALUES ('7', '10897', 'test_key', 'test_value');
INSERT INTO `user_setting` VALUES ('8', '10898', 'test_key', 'test_value2');
INSERT INTO `user_setting` VALUES ('9', '10899', 'test_key', 'test_value2');
INSERT INTO `user_setting` VALUES ('10', '10900', 'test_key', 'test_value2');
INSERT INTO `user_setting` VALUES ('11', '10901', 'test_key', 'test_value2');

-- ----------------------------
-- Table structure for user_token
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
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_token
-- ----------------------------
INSERT INTO `user_token` VALUES ('1', '10826', '9c5a77b57ae2fced9acf03e6c0869e9f60f46c50dd0314c6278d2a13295fc79c', '1508330460', '2491507bd4d5cddc748be078c6dd62a4d16010e49008c47bab9a49852d8f1829', '1508330460');
INSERT INTO `user_token` VALUES ('2', '10000', '65c2086b2f09ae4e0d20ced2229f1d3f5f493d223833ad61df5c34767d0e782c', '1540622238', 'a1a26f791a967aba73b0812fa7e1c7110be0cf479c445a35e4530d1a2b91a979', '1540622238');
INSERT INTO `user_token` VALUES ('3', '10833', 'f3c6c5459ffbfe40262e7a2b978ba72d19d128d14a4270abd5f3e293df551c91', '1526956546', '29c53ac7d3e115b048de0ac561c32cefe9a9e1e63906338a4982eb203ea437d2', '1526956546');
INSERT INTO `user_token` VALUES ('4', '10834', '2603f7b09dccd002a297f3984c5208c7d3d45f527264e1ffc7623dc28b3aa83c', '1526957444', 'dc3ddd1665ff3e344b00a02f971b96813783a3179e44f89665ed84dbf9f7675c', '1526957444');
INSERT INTO `user_token` VALUES ('5', '10835', '374ea66c9a52c0b5d85bfdee09bace6f1454bb49f742732ab585069c2aa19cee', '1526958149', 'a1713a5570e445ad114d6d339ca200f88ff47a9c08155a492402c7badf23044e', '1526958149');
INSERT INTO `user_token` VALUES ('6', '10836', 'b3caaf6059320b93475c0bd9d057d22419fc1669ee34e7f321c0def15afd7462', '1526958329', 'ff1ed1f094f5a8c7daa6d13c8a2bde0eb7082f082dc5311e543790656e502185', '1526958329');
INSERT INTO `user_token` VALUES ('7', '10837', '24600e0dddf1b345d7b9ce31a5a3d94ab1700ab6e13e138e75384faed64187be', '1526958379', '10b162616dd34d3c9b667e7dfb0458bbdffd2aa7f450d38d99f01d5aa4560cf9', '1526958379');
INSERT INTO `user_token` VALUES ('8', '10838', '38a5df844794e1b04fc04827a0247a0ac03b09d928eba2bb2b9d3ef2c99ce287', '1526958387', '5f581984938f15d80e64702a293354f9fe34f67173abaf986eec03e5de078be5', '1526958387');
INSERT INTO `user_token` VALUES ('9', '10839', 'a443bcff2d18851723882f7a56f456cc4b7720ffc3763272ee70ab2ab6093d90', '1526958437', '9e8389d42b680d54f05c0cdd691f11cc993b57ede652125519c250a0b4958513', '1526958437');
INSERT INTO `user_token` VALUES ('10', '10840', 'fcd55c02d0d11749b4b961c03fb5b75e106017f6fbc7513c8a79068884f69514', '1526958463', '14194a610f72167667d686086f21b5524cfdb27c82487bedf81d12a9377bd1c9', '1526958463');
INSERT INTO `user_token` VALUES ('11', '10841', 'b7d5a31b49efd5979cd77797353e33f29588057291f764920e6aa3b127c028a9', '1526958474', '3d12404f70a0cf4dc3ddd7c02ccd46a67687c513deb01cf6f59de23e46c8a199', '1526958474');
INSERT INTO `user_token` VALUES ('12', '10842', 'a276f8e7556f073dd93b637a3c09d132407c94f6f572f45cbb68a148a3e8d428', '1526958493', '37edc033728792af34cfd178020e9d84936230ed5b3318d97779a2e1f5bf28d1', '1526958493');
INSERT INTO `user_token` VALUES ('13', '10843', '02399cf94d8737e02d205aa45954a0cc7ea064216589737c435c2790890a0ab5', '1526958587', '84387467309b78df8d05d839a2427e849c78ecea7c8a54c79550773aae7f4a33', '1526958587');
INSERT INTO `user_token` VALUES ('14', '10844', 'd85be62854579cecf292427b008f14ac3d5f3b4d12c05e3087178e02b2e454b9', '1526967952', '61840405407a35fd995246b824594e61bd373a90cf455722c48e98f49f2b5478', '1526967952');
INSERT INTO `user_token` VALUES ('15', '10845', 'c9b2334727b98c0d0815232141a68193b19dff8d521e3799e737a0f24dd057f1', '1526967980', '9f6f932ed0c70be1a7466227952992551acd1b52d4e4222cd87838e5da4421bf', '1526967980');
INSERT INTO `user_token` VALUES ('16', '10846', 'd6b733fd1c7a8502372e86ae102302895334903acd07ad07ca0cbcff5b35593f', '1526968359', 'da7904c42bce1eedc24595692269bee446d6da013d093a23d95a5b91e9d434d4', '1526968359');
INSERT INTO `user_token` VALUES ('17', '10847', '8e3f7154da8fd0cf46d6ad5c54f60c467201ce85356eb97cba21b854056bb396', '1526968573', '8c51f31e0098f42ef3ef0c701b6ae35cc9b4a29df354953073a0451b61e3988a', '1526968573');
INSERT INTO `user_token` VALUES ('18', '10848', 'e9b8184d2237adcccf7ef6fbdea11019ed648e3443fad1e68876975074c29619', '1526968581', '7c042fd2eaf2d0688579758165c5de6085a81bd7194399b7f9cda1a1615f1999', '1526968581');
INSERT INTO `user_token` VALUES ('19', '10849', 'ae4547d64d47f23b9b3dadf0295a810891a0a44916a1351ae5c27a94e49a57b7', '1526968948', '547466bb2b6282160dd60a1dbf58cb74aa5a04a184ea9f2644c3e4014615b68e', '1526968948');
INSERT INTO `user_token` VALUES ('20', '11573', 'ce321fecef17d0d4f4e6e6fa25d9b14782b00c0e70d5dceb26ce2fdf2494ba25', '1529478153', '34949bd4b7370b809f4ac987f71fa0be7b764c43783bb0b364019f7132ebf1cf', '1529478153');
INSERT INTO `user_token` VALUES ('21', '11574', '260cc279c69f3435fd86272eced4f30420b1626ebd959bf681a4d29acea1810f', '1529478195', '44cd0df803ce1769b9750056b7f5fdde91dcbcb815a162b9c7a0142c393914b8', '1529478195');
INSERT INTO `user_token` VALUES ('22', '11575', '396daa739a54dd03d9c476a7b68671e09f97e35828f7732a3f053f8d40fbe195', '1536226493', 'c8b9a106f0fe97ddc08de0e8aa5692cf635a15ce25ff03b2c6919be4f8a7b680', '1536226493');
INSERT INTO `user_token` VALUES ('23', '11576', '8d81944a8cdaf696c88a0ffe1506ba06ccec4cff5f5cc24a0baf2358e44b2228', '1529670759', '5c3eae7cd105aae5a896f8e81851b7cb37af83715809a04a468b666c07613b90', '1529670759');
INSERT INTO `user_token` VALUES ('24', '10968', '2c1a0950bd6197a90dab07a160dae929df712a5f91cdc641a5e6d03373449f9b', '1535594712', 'f9cf48fe25bee1012c68474641ba8396cd4c899949474585da8b4b4d1c352f07', '1535594712');
INSERT INTO `user_token` VALUES ('25', '10969', '04977bb6049a5cccf66e2ec777120852c09882a3615d4b6c9ac67dce8896872f', '1535594719', '9cc05ac80a20b9068d561a2a40a9e3ff4ec8de7c4254ed52405562c352be2abb', '1535594719');
INSERT INTO `user_token` VALUES ('26', '10971', '0528bdb40f35fe73cf4147d48bb7e6bb2235ca5a21b20db1ce132fefb0c34276', '1535594722', '5d3c9aa35cdd21102875804f9bc595300efbe86fb623dd9b8395f462596b558b', '1535594722');
INSERT INTO `user_token` VALUES ('27', '10973', 'f6c2c4c603be8e61789c1ffef375b35132994d2b4c3082b15870893dc6eaf4e7', '1535594759', '135ed7e824c6b47e00a64f361b9dc51263efde04f1fa8b1efff42965d3b13e1a', '1535594759');
INSERT INTO `user_token` VALUES ('28', '10975', 'd3aa52d753ffc12f198ca8d7e7db209536ca28f30a11b45ac1a26598b9b36c30', '1535594788', 'c1d271ec81f4bdf5bd9ac4d7fff143962d1f9f9a6b582ee2d6b89fb5faf848c5', '1535594788');
INSERT INTO `user_token` VALUES ('29', '10977', '5893f8ad6bf0d5261c87cce2eb6f2ef33babac7a5603c7885482d25120e94ec7', '1535596617', 'eca5492ed429c7df097099b55fa239b8b67992fe84b5a8de44704e55e8740131', '1535596617');
INSERT INTO `user_token` VALUES ('30', '10978', 'b22b77e2ef519234b2795706fcd92098a8de62c1d9321ef2a506462a81fc8e32', '1535596658', 'b0cf76008431e94d714076a211acf67679f8f68080b643b07ad273edd2bcf826', '1535596658');
INSERT INTO `user_token` VALUES ('31', '10979', '5a0b67c16f0ef3c51fd14eceb8957446678f1068d593b7a4e7d68556b62fab20', '1535596677', 'fbf008aa1f9883bf53dee208d385ec1ee3776623d2bd3a127de35119b11eaf5f', '1535596677');
INSERT INTO `user_token` VALUES ('32', '10980', '657d67b036d5013fa566de516ee4c3d26aecc26845d57990b4edda7b8784d800', '1535596915', '83bcf5c4e6e2e233f293165114e714a58501b990d56b4d4a974f4821707dc971', '1535596915');
INSERT INTO `user_token` VALUES ('33', '10981', 'c99c61bdc5f6c0c17cfefbac951186729eed7ef7f4d72d3718bcaf58f2137347', '1535597039', '7bda4c57470fd4678184e7d042182d2225691290cf5eb91306db931652b3b818', '1535597039');
INSERT INTO `user_token` VALUES ('34', '10982', 'c01ff6c660f41dd615fa18280d74f8a7c9559682cbafbcbbd73de74a2f2ec385', '1535597093', 'bda501718056ed18fa251e955bd66dfa8c544f992455f03a2abe48a1ff7d3307', '1535597093');
INSERT INTO `user_token` VALUES ('35', '10983', '343b2f9c8bddfad2a143845eb7e17d4b4a3dbecdf2001b11df3e3b257612cf9f', '1535597826', '81daf706b076aeefa9587b02b8d4e7ae7c1eff4ae9510c1a20a0e97d648a7649', '1535597826');
INSERT INTO `user_token` VALUES ('36', '10984', 'dc4d040b441b6c5073450fca3b8223f6c6e7d57cd030d63a16899f9d05b78444', '1535597853', 'f7e80dd856a692d61cf2afb5dd0d03b428e1c7c61363e9bc2625c69675fc1a0b', '1535597853');
INSERT INTO `user_token` VALUES ('37', '10985', 'de7b294877845cc8a1df76edbb13b580c1e81981736bc36a50f2cc570f042119', '1535597902', '61314f91b7785545f55afb2e662bbd641e8a0b667b630ff9ba3e3f679feaeeff', '1535597902');
INSERT INTO `user_token` VALUES ('38', '10986', 'da0aa8f74373cdc58cd8dfc5ccbab652c5223773cdbd287e0c0435fb9d6e9734', '1535597999', '91a415a656710d7833eaa4b9b136a4b9e85d82534d6be3007a446ef6975c5f7c', '1535597999');
INSERT INTO `user_token` VALUES ('39', '10987', 'a20b700bdc76205752bce13e33067cdd563a2eeb9964acceabfde141f2a73c88', '1535598292', 'a78fb38553dea15ed63c13dff793ced1683561e9cb30a0e06b5b6118d663e703', '1535598292');
INSERT INTO `user_token` VALUES ('40', '10988', '691c1d648411c05bbf1322c7c9f5e1fb8c4ea073519db1edad43026ee8f39efa', '1535598365', '930fa2873f7d2f54c7d0b7de37c4109553abc1522887d581075e7a7dd848f189', '1535598365');
INSERT INTO `user_token` VALUES ('41', '10989', '3632289cf76b0956c8379232c07f26954d0a6e8a5a8c2891428c96679202c8b8', '1535598433', '3acd2f63be8c643d323e47aa6100b159651a71c601fed20453125e57538bf0f6', '1535598433');
INSERT INTO `user_token` VALUES ('42', '10990', 'edf6c76962814ff6cc8da45cf071b9bd1f8c59d202c28b66b66f24684154812b', '1535598482', '94512f11373ee85a0ec19b553ed2f7feb9911bf57b12ffdd0c60b38bdf81fccb', '1535598482');
INSERT INTO `user_token` VALUES ('43', '10991', '1321cffca0d4237894c852c8494426d018bd2a2071a4d00e2c144cb0e11b4c56', '1535598540', '7e3918304841d24c67532853388b4880505fe6b38580df0469a501b8465c8d6c', '1535598540');
INSERT INTO `user_token` VALUES ('44', '10992', 'c1a2346dc9d0c1594bab3b986b3d00074535b743fab830eed695aef2723adee6', '1535598565', '28ac86f6e8970f38f6e0946631e5bec940a758fc55110291b408bd6c2d147c1e', '1535598565');
INSERT INTO `user_token` VALUES ('45', '10993', '6118cef0d6d90933bb338b71cbe42540ecc5af12acf7667132394ec6081c3a71', '1535598786', '22c9a207b218cf9c4e961beb28fa3dec2bbef0a94521ada05f93e4927ec1194b', '1535598786');
INSERT INTO `user_token` VALUES ('46', '10995', 'ea419194e8cc35b9e580b02c63c2ccdf2cfdc73ba9dcb1066ece3edbea88322c', '1535598984', 'd9be15870289319b9fab5f402009565abd8177f2e431feb5d7ae1b5d411b47ef', '1535598984');
INSERT INTO `user_token` VALUES ('47', '10997', 'b8dab9e381058eefdbf26181afc800cd773aa79fbaf40d5c9823d55374df5a11', '1535599221', '5afbe324631a4ee21bac0cb6937144ec513b88727267605a8316b7cffcbb5031', '1535599221');
INSERT INTO `user_token` VALUES ('48', '10999', '5a664e706ffcea24f689900b2c812bf16ddda15f63dddec115cc95e6cc7edbe7', '1535599286', '862eb85c87bcbc3189fec45c2dfbffcf92420d6ef2d7ce8680e9d63a99d46f96', '1535599286');
INSERT INTO `user_token` VALUES ('49', '11001', '1dbc1367e66bf2d7ada11df76c29cd58440af1f7902c79d3f55544523f04d2c7', '1535599470', '846e250baa68b5dd1aed11b0f2e0ac3202bce44e0888cadcb2588bb109c1e721', '1535599470');
INSERT INTO `user_token` VALUES ('50', '11003', 'bfd0efdb7381e3b85783b81b2e699691f687913112dad16abaa786b9458401ab', '1535599499', '5bfc52850f7b53f23c6eb0a2f4642e8f3bb5a69d02e2d21eec9ef251a6fc52b1', '1535599499');
INSERT INTO `user_token` VALUES ('51', '11005', '5a105d07fa07ac43636daab10011745eccf543122d586ba1fd50fbbd66a7cf02', '1535599676', '9885dedee93de30654bb7817f1b077deabd3971144882d9029027892810c55e9', '1535599676');
INSERT INTO `user_token` VALUES ('52', '11007', '3ec2909e507fd0e189bf39fb7d951602683bb85f0a995a7be8112f0b938e9fc3', '1535599703', '9221343762e211d4bc40e9ce124a08ee14a7c828ce822208118561bdbfd4dacb', '1535599703');
INSERT INTO `user_token` VALUES ('53', '11009', 'b13e841c1942ace87918e9c5dbf0343884eafd4113a2e4fc849e2b03a254bda4', '1535599779', 'f9dcf056ad4b68c90715ec1361cf70a6e8a3f0328175c9bb54c9c6a569d88895', '1535599779');
INSERT INTO `user_token` VALUES ('54', '11011', '9502c7d0e701c7a3243bf484e0f32f39ad9a1002c02e62698719c7078b9c509d', '1535599815', '36d80e8a20357e2d2992686f713dbd945b1fcb5f0f82de34155b1af3287e6bf9', '1535599815');
INSERT INTO `user_token` VALUES ('55', '11013', '22b403fff3c3e7d3c32bc57c3147d4af3183754e5a49926c94c2fa76c6fb4efa', '1535599902', 'f87b5c3dc48b37b753a6a5d813ce463c624ecd4c8a5026e47a4e1f9b13e83fff', '1535599902');
INSERT INTO `user_token` VALUES ('56', '11015', 'ac0d00d0ea497cf7de38e82c1d15c191ccd00702365cfac059a641c61c8bcfbe', '1535599943', 'fdfcbc30ca86f046a4dd932e123fe4820ae252f6004f863a03183213e2f65513', '1535599943');
INSERT INTO `user_token` VALUES ('57', '11016', '4fb5930e671944ae967ccef40a8e8194640a484ade5e9dc891b8a4728b7a0ce0', '1535599943', '62ab49005fcab85e44ea04145e0584ef3de89a6be98b7d6dafe3c43224f53963', '1535599943');
INSERT INTO `user_token` VALUES ('58', '11017', 'cb3ce3377c87ba6e108145ac90d66fefeaedd9341d067e50a610abb4473d44f1', '1535599961', 'e7db4b18d3b2f6d21167c5eba0ad9ce80be0f7197d7464eb30d1fca083cfb460', '1535599961');
INSERT INTO `user_token` VALUES ('59', '11018', 'edf331c684fdb0ec0bce99d75dc22748dc2c0bb31c00767bb7f5aa5f8131919c', '1535599961', '082bc25d716723ce57dda4c97644459c9ebc12e613ce1cdf6e38fcb9aca27876', '1535599961');
INSERT INTO `user_token` VALUES ('60', '11019', '1a093962d3eea0f87d676482a61405bd77212e2a2a204e65ccbe9e021eb6d1d1', '1535600001', 'e09c8d6069e085b472b3d1a7b2380a2dfd1696ee9700fca137cd809541dde750', '1535600001');
INSERT INTO `user_token` VALUES ('61', '11020', '80115be25a95274af62a7942bbc71751be95d7217414a7e92ce96cf6752c1b7d', '1535600001', '1b6dff3ecf332bef7545b05f789c3952fe218393f6fe63c4fe44882d936c9070', '1535600001');
INSERT INTO `user_token` VALUES ('62', '11021', 'b0c31a89ec3b25f0dde70cffca349e5405898432210bc74396dabc5021e54182', '1535600031', 'd337b140b62ce6a66b27e1e9557293053384500e6c245d65d71cf0eecdd99d36', '1535600031');
INSERT INTO `user_token` VALUES ('63', '11022', '684afc8ba748a5c5d277a01f821cc61a03c5cf03f335270afc99fe7a6904c9ad', '1535600031', '2130598d4d7954fec7ecb919fc17964c552cecbc076a9af3befa4cdd9eb9975c', '1535600031');
INSERT INTO `user_token` VALUES ('64', '11023', 'dc333113df3eba170a15f677e8190d8b4567d732270a3e5b485d56017eec0bad', '1535600103', '4eb20ca1f9cec28fbf5aaf2dd43f37ce9b1dffe09faf2387a8b45c8aab46c4a7', '1535600103');
INSERT INTO `user_token` VALUES ('65', '11024', 'b1bea99a4153d920cb55e9f1e3d648bde81f314d39adac06bfad946fd041de4f', '1535600103', '9e669f8f65e50b04c32c6edba6eb3cf1ae22049f69b988ee7d28534fb3b20490', '1535600103');
INSERT INTO `user_token` VALUES ('66', '11025', 'f49ddace94c14cf61fc2a5f4b4e657058123dd5a497c43febfb722a85b2a9d54', '1535600259', '8d695ebceaf8ca98097fa742554e9dc172017d8300b9270cf09ccf634dbc2f9c', '1535600259');
INSERT INTO `user_token` VALUES ('67', '11026', 'b9af86020f89d7018bb7382ada6ff1a5b97a23d2ffd97b3476b90a051dccf85c', '1535600259', '7c71c3b367d30dc67753d89de964d7f32cbe0999335b7e753469c52461518c60', '1535600259');
INSERT INTO `user_token` VALUES ('68', '11027', '6bba0a997b33f8d8399a1a49bc597b6e3b996555b38f40989256ca240a00fba5', '1535600333', 'daa8acb8d69ce74929883fbf86123794d0a475ad323942c9b9bbf2eb23ec6387', '1535600333');
INSERT INTO `user_token` VALUES ('69', '11028', '9f8336699df35490f9e341f4bd4f08904146c2b422c688957f36eabb97ae9c90', '1535600334', '2345e7cda6f95c023abfa038b879829d0abbe5fa27637a43380f9f572c5f63d5', '1535600334');
INSERT INTO `user_token` VALUES ('70', '11029', 'dc49ea7cead5adc6b9deecf866c4b02dfba773e348d189408f962e965b06aca2', '1535600422', 'de71317e7bb51793cc9f43a5bc23ef1d6c91924e34fd4ae3d19716d4a71368a1', '1535600422');
INSERT INTO `user_token` VALUES ('71', '11030', '9d11fb090e94a03e270ec4ebd1c8b2deb55969c010cba522778441d7d4f5b387', '1535600423', '7af1577b326904bfdabef1874c72da56408f9094ee431a48be44a1ea620755ab', '1535600423');
INSERT INTO `user_token` VALUES ('72', '11031', '497ae29365c52fa13ad6eab6c3cd935ba29a0f8aba88d8b96928cf9454570e9f', '1535600609', '91feace76401ca0f27cb0ddc17a28607f74527757418015bd5ad5b58da22e685', '1535600609');
INSERT INTO `user_token` VALUES ('73', '11032', '5377e0133a3e69a59c9c399c54c49bce85f276285221db84cbb2befe6862c064', '1535600610', 'eddf2476bb2fc1a26c1e59ccb198727a2f1f2d4f155845e4aba1f51ef20349d7', '1535600610');
INSERT INTO `user_token` VALUES ('74', '11033', 'be941461ca731c128d1c54c35bb9899d54ffdf7b45796e45f4a397c2cc1a2bc4', '1535600631', '751dc520a0cf34f75f966c3f0f1783db21de39133065de0eb49c62a3898ef3d0', '1535600631');
INSERT INTO `user_token` VALUES ('75', '11034', '6cbc35d03bc2dec56a1e0096f529e070f9690050aab181b06eeafeda4c89e61a', '1535600631', '07357962a9341493e67c247bfd9c174e2f965c07946d271244a34f9f5a501d41', '1535600631');
INSERT INTO `user_token` VALUES ('76', '11035', '114d54c7c282f6ea516f95ec651e8bf3cafe49508025a3557d8e3125c589f750', '1535618230', '7c2eadb1edad1ed81cd78004efdf6569899eadc01eb3e0944eb2dfa327c058a9', '1535618230');
INSERT INTO `user_token` VALUES ('77', '11036', 'e80209fa6df058e4a95c7877181acd3c1d549161abccb565828ece970f629ff9', '1535618231', '549c9309907154cb90ceeea0a4661abd9876246db8616fcbfb83a83b0e8d54df', '1535618231');
INSERT INTO `user_token` VALUES ('78', '11037', 'ab530c9781dded063c42e5fc674c4dbee5d9fabe5cb01ed4c6d439a3ceadccd8', '1535618306', 'a4a131f0c929caadb4f8c31796c0494f6efa5ebbad5801d72462e9acb0af152f', '1535618306');
INSERT INTO `user_token` VALUES ('79', '11038', '7c347e4b222ee9619274b746a4259d7117f080472c31ffe9d4cd539fd334c27b', '1535618306', 'fe0a2533cddc970d27da67b11726774190eba7373124eb58134984c36b679174', '1535618306');
INSERT INTO `user_token` VALUES ('80', '11039', '8eec001a21bfbe448ab9e18300a7b78879f57be854426d1c48f39482ca4ded2e', '1535618325', '9eff4563a5e3196317ce62d68e13dc8394e337ecd532a8fa4520c141022512df', '1535618325');
INSERT INTO `user_token` VALUES ('81', '11040', '58bf313ba9e0691e694312c9aea9ab9ab8c0adc0c545f3aff07bba1c846a6e38', '1535618325', 'd73e6a4009b1656fc52739b983f79f52348a1662ac3a6111ed8c6b3ebe83b79f', '1535618325');
INSERT INTO `user_token` VALUES ('82', '11041', '7da89281bcbbcb83ecad046ad11900e8c3917189f7766ed58c6b27d0741a2915', '1535618429', '1c8e5a9f7f0a07f97b2fd197b45c28ead4ac048da691f0d14f9d71d4912b4d51', '1535618429');
INSERT INTO `user_token` VALUES ('83', '11042', '8ce0a7b9e5aa3e30beeda763d9c6d4bcb1c668cf383545a6242ca8d2a1c1d8ba', '1535618429', '82f32e4fa949811688cfced37a8b18b12b04224b34231de87180d475600e3a0e', '1535618429');
INSERT INTO `user_token` VALUES ('84', '11043', 'c4422d666c76f12c1e40e933c16747352fe77b9b21865ee56125f51fcb0daf58', '1535698314', 'dbcc3a42199f70d9bc4e4a33178ed83387bbf904391c4e3f7e3b0d195abdc5a6', '1535698314');
INSERT INTO `user_token` VALUES ('85', '11044', '06693e8f8d31800b84855668b7e43c2d4693826dada762a18c357be48615f558', '1535698314', '52814e3352e6a393a0a946a102bda3c58b1b505b1cc83159fff65597f6751e38', '1535698314');
INSERT INTO `user_token` VALUES ('86', '11045', '99c70989a9bd544fa1f3260e9ee952520ae2816eefbfde580328e684efa07b79', '1535698344', '9f13dc795c73696fd99f8c3854c95740778dd83087a91ef3abd5e91d6c42cf9e', '1535698344');
INSERT INTO `user_token` VALUES ('87', '11046', '82eb5914944ebcc49eda6f3783b8d2aacaaf9f116a82a570701102eb0e3d8376', '1535698344', '83296020373f07c1495e26cbd0093b588c91bd959c3b1a5d93c60d2fed56724f', '1535698344');
INSERT INTO `user_token` VALUES ('88', '11047', '8143ed536f8092755227fc697ac1ef2ff9ac91413413b364fb6565828495464e', '1535698463', '3bd3bb6fa704d2c0535455dfc36f5a37c18f3d3c8113d1265adfa42955a92195', '1535698463');
INSERT INTO `user_token` VALUES ('89', '11048', 'df63ebcf7d0f03ca40631760ed016053d50354a482192dd6e0ae0d4a8efb356f', '1535698463', '1302a5d432cf86e15977041f18bb898af0cd459c8598465cce54799070fb1689', '1535698463');
INSERT INTO `user_token` VALUES ('90', '11049', '16dd0aecbf4ba355c1427096dc691b5eca6ada3c1ceca8f320b8f9c164b2b88b', '1535698631', 'ddb298b49942e7c547a4c94af00965bcfe2d138084f99c3fddedb39c289fcc90', '1535698631');
INSERT INTO `user_token` VALUES ('91', '11050', 'd21fe4b96837b69c900c836f6d4ed004822bcd81f4b43475c965057bb473891f', '1535698631', '27fa9fe1272b908cb030e24d0906784d566e083d5a264c96e49728757fbfdb21', '1535698631');
INSERT INTO `user_token` VALUES ('92', '11051', '1941bab6c123f35e759d53d8a0645bd76cdc0c3f9469c56be355c8761ac534e4', '1535698687', '6c1ee8b94f37580648a90cfedafe514b72ab889626dbcdaace3bbb7fae518535', '1535698687');
INSERT INTO `user_token` VALUES ('93', '11052', '69aa8e874c42920b43e616f55f87f016b51eeb138762c97ad9b05fbc99ac793e', '1535698687', '987f155dc5f3df649d1f7829fbee0774ce6a8dfc94cd1cdb6cbf4e2f0c0f8d47', '1535698687');
INSERT INTO `user_token` VALUES ('94', '11053', '6d6c6abb0ef6651a662d3d2a21ffd55188309ff5b75c860d8e190c86d26e9fa4', '1535699247', 'adf30712f67a636d9d86e736440f09c7dc76c091e5fa3114c6dfd087b1a6a138', '1535699247');
INSERT INTO `user_token` VALUES ('95', '11054', 'c52a15912a64c400ed44f61d69045a22215e6c017e03bd6267afc087dcac6938', '1535699247', '6324c7fd5f5314536d6a28f97e17235cd6c2b242892ed6e6d8425bb4a70e2410', '1535699247');
INSERT INTO `user_token` VALUES ('96', '11055', 'c73e70658d49b1fd06ba3851e3fe0214334f40870c1e3ac4f410b2f4566f24c1', '1535699320', 'f543411b7a40678b67988763e813cc90b2b793cdca49f0e4ac5db29133da1a3a', '1535699320');
INSERT INTO `user_token` VALUES ('97', '11056', '974376c1bda9d141a2def41b80c7b06b25a3e4b4331b9018cb9d7d885d55326b', '1535699321', 'cd16223f1d8917ef09c2bbe1f6e37f994a2aff21f94db8f49ebbf7e06de27b92', '1535699321');
INSERT INTO `user_token` VALUES ('98', '11057', '57844ab1e6dd6d81953171b4ed2ede0cf8c4c733055dc59ed854871600774eee', '1535699385', '0d70abfa70a5ddb045f53b1b190cf4a146e525f47d945032af04abbdd1a6a221', '1535699385');
INSERT INTO `user_token` VALUES ('99', '11058', 'efa9dedf13cb434fa83bc45b934541d6d5a3616589ea8e9f6326caa9fb51f28b', '1535699386', '80e45e66e4b6659a42db8a4560c6a3deb041076ccca00c1cd5af5e1d0a663060', '1535699386');
INSERT INTO `user_token` VALUES ('100', '11059', '6cfecb0a2c45c67201670ad44b873e60b6e859bf914270ec9b0432fd9829fcaf', '1535699455', '82fe8aad6e42bc18e125c52dabc93dfe9e6302804d03043b7df7bcd1d0c3adf7', '1535699455');
INSERT INTO `user_token` VALUES ('101', '11060', '8cd955df112e2a21a322e23a88a735d747dd1cbd85d897a8d89f80dc18d51be4', '1535699455', 'd88037e29eacb2ae6380170552e5e6e6cb7e7aa1ecdb082581dc40853d84651f', '1535699455');
INSERT INTO `user_token` VALUES ('102', '11061', '9ffd7f920c62de60a07fb4ffc483d3c4f4b9e5e22b1a307279fbd2693eba42b5', '1535699499', '99ea52abf968a06730bcc6a82651b084c1a886f6117ed3d2e51475a2337e0f9d', '1535699499');
INSERT INTO `user_token` VALUES ('103', '11062', 'd3196832d32a4c5ef2c618deea111338c4f4d219ab49009611654c98190a7c21', '1535699499', 'a7ee4ab345dae0144addcaf017eb7078d1465099440f71c7bdaece2d8e2b2207', '1535699499');
INSERT INTO `user_token` VALUES ('104', '11063', '273219eff100db686a4ea638ca55a800a585c449cae2d2ad5b47684c9b829995', '1535699567', 'd770c4dd07c383f20d4318ae4b2ecec212fc2a86b0a804d09d15c596cbfcca38', '1535699567');
INSERT INTO `user_token` VALUES ('105', '11064', '0db9bd233c7c1720c610efc794dbfd71cafab6207507a497807a67ba8cc73eee', '1535699567', 'cfba5f02f4eb0e299db91d721b35b2aeb0842ffd21b8a496e2b63452d342d2e8', '1535699567');
INSERT INTO `user_token` VALUES ('106', '11065', '5b6e9310a7c837f67e8120a1389f20dcd437f9330fa60439213059b43e2786fc', '1535699645', 'cc2326c1d50d3eef029bef9880c94ac5d89f826cab79cb5f717eaba1ad22eeeb', '1535699645');
INSERT INTO `user_token` VALUES ('107', '11066', 'acc683bcb2123015a79cb141df48dd7e4d3b5bd5188d8be6c2166f7761685327', '1535699645', '59c9c046ca33f0ab10c496dbcc28e5f38b001de52b39d2adbf8663340e6403de', '1535699645');
INSERT INTO `user_token` VALUES ('108', '11067', '87cf1d424df913ac471d57effe857d6f419e0d7d0755a09812c002296c9e29e5', '1535699674', '63fdeb40bb7719351800d650fe23cd632ab7aa7c533612e13a405ada912c768f', '1535699674');
INSERT INTO `user_token` VALUES ('109', '11068', '1c801d90cb6a28b752baf8240414e25941462778b4a394988f782be8e4b943d8', '1535699674', 'cb524fead6d813f87d9018784b627e65f4e4cc241a926db506e08a38ed98ff23', '1535699674');
INSERT INTO `user_token` VALUES ('110', '11069', 'e021a49d8cd1c78801abe75247491646334a1e3c929a3ac1b7dde36e445277a0', '1535716801', 'c5ed39d5d6d9c442d26c093db8769100a04db87ecec34461ee03c45faba9eb4c', '1535716801');
INSERT INTO `user_token` VALUES ('111', '11070', 'a3a5faf9cd6c7c3b962e6c549a0d9ca969d833c5d908d24f0f2359e319efc5af', '1535716872', '7035337690691fe13fa54277314b0e28d8c3b0fa0253c315312fd13d30258b6f', '1535716872');
INSERT INTO `user_token` VALUES ('112', '11071', 'b2d867884bd86bb6177a8f8937d524d965bb65b5d3abecf4a9ea28264e6efa9c', '1535716909', '74583f7e776f860f1b28733e8819c6d8dc62fa1278e365aea0034c1753e09628', '1535716909');
INSERT INTO `user_token` VALUES ('113', '11072', '17af679b4380a56f4da647fe1d73912c95bc24cde73b614ee61fb5d8b013e3b9', '1535717083', '44444f96ca5cbb0aeaafeea515d88ff996050b26e49456c525707d857cdc6b0b', '1535717083');
INSERT INTO `user_token` VALUES ('114', '11073', 'a91994caa04e2f5519a7b862f7ebc32434f088b5a2d742f7f3ea275162d39c88', '1535717104', '98fdc927db5268d1546a4db5d1d0a4a575f4d3495630f99c53d092b0a2dc1f7a', '1535717104');
INSERT INTO `user_token` VALUES ('115', '11074', 'aa626c89bb9da871177684e87eec42f7c8bc4fe7548512c9048b41100e02331a', '1535717145', '6c3613fc3fef53602e821f8e5f9a30f2693abb78e76323da9bb7fd9b1f486013', '1535717145');
INSERT INTO `user_token` VALUES ('116', '11075', '1d582f32ebc8e2f21564a3fa1b6caee5c5dbb4cbdde0ed0a6f587ed47b9ab0a2', '1535717196', 'e067c4c336806671ce19d5ae1860cedc8574ffdf4e1594d24be5a9621a35d6d5', '1535717196');
INSERT INTO `user_token` VALUES ('117', '11076', '4b3bd6edc94f6702ecf3963a762ee732817b4811ed6c23e306a3aa4f966588ea', '1535717322', 'e7ba0ad0a1c6b77cdf1603d52dec9aa7352836b70400107e349a9f23781d87c7', '1535717322');
INSERT INTO `user_token` VALUES ('118', '11077', '23303f7645aef7ffb6a0b8ae412df6236e53c203cc22cff0520ad288e732d887', '1535717334', '533158dbf6e2f017fd457dd08c3c679adef1151688d3377196ddc7d4b276846d', '1535717334');
INSERT INTO `user_token` VALUES ('119', '11078', 'c1008c9d6698517118d89c72d704a29223b3daeb249704481e8dbd4eebeb0ff4', '1535717348', '70cb7f967d85b27ba634001314dd738a74d17744268ecede7190f80500143f86', '1535717348');
INSERT INTO `user_token` VALUES ('120', '11079', 'df76278ac04470940220f5fc8e345381f2422304962607c0a1c02aea6860819d', '1535717370', 'bee87a54030569e246d812cc17f7086a016c26f3a000e1c966122bfb7fa9538d', '1535717370');
INSERT INTO `user_token` VALUES ('121', '11080', 'efb17ad22fedf88ff1a546e75ddbeb862a6d9b8036dea9d35fbe85d6ba9bd671', '1535717403', '4a369007b533554a7291e6962baf7106abb5fbfedd7050413f07e18d8eb441f8', '1535717403');
INSERT INTO `user_token` VALUES ('122', '11081', '1e2c2780d46054925047e9e8a08803dc220ee4779b32da879745df01adf63a7e', '1535717422', '380d512b01e3740911ad7ab73ccfdf02c1e14d63ac53a36d274067dc2713dc33', '1535717422');
INSERT INTO `user_token` VALUES ('123', '11082', 'ff84392b6e32993da6c4d408b678ceb1876f95861cb13c73fc5cb7537301246c', '1535717451', '047f1fb0f6729092d1f6c1fb3c42a2d713541a9eaa35f41395c78dcae112e360', '1535717451');
INSERT INTO `user_token` VALUES ('124', '11083', 'be74cb157dd3db110a18b4dd1ca07c13493d8da98b58879cbbc90be6a413bb0b', '1535717538', 'd4ab08727355b9b3eb1191435d31cc083785b5e83f25a400eb8715d34a8671e6', '1535717538');
INSERT INTO `user_token` VALUES ('125', '11084', 'c91f3f679fffacb4e5eb64742b563f9fad960dabd421cf1190cd31481451d739', '1535717563', '6b3683f6d9f71a35f8e47cfa162fdc0ae94986ba135c97a2176d855cafa2af55', '1535717563');
INSERT INTO `user_token` VALUES ('126', '11085', '8d9f5360ec74818e91d7f0f3ac62ed3c95ae42cd6c0767a48274b484fa54ea15', '1535717590', 'a087adf94f7d9821a34d3a3ccaa0947d1f152cf643ee6ed253e122956acddd9d', '1535717590');
INSERT INTO `user_token` VALUES ('127', '11086', '181a93e301697dfa8e4e48764126344160750dfe869aff2c27aee84d2d439436', '1535717665', '7318aeb3b672ba3d97431fb711e7951ab5731cd13ce4916a2fb95522bf109ee9', '1535717665');
INSERT INTO `user_token` VALUES ('128', '11087', '15a7bc1f904bec1a5d4d9434d318b9bd0dd1a5e6447548c3fab39b855b8a625a', '1535717717', '74d93bb49196a5a4776328c156e72a8e8d5c96480cdd81ab6f093b8140ac5380', '1535717717');
INSERT INTO `user_token` VALUES ('129', '11088', 'd336cbc71605a6374b091eede6d05111159fbee56ad448c0ac4707e8c03cd7e2', '1535717730', '7fe2234374c2aa2645684c485d631f693066b4b4cc95751fd11d02b3c5c2a162', '1535717730');
INSERT INTO `user_token` VALUES ('130', '11089', '4b41db1ba9bbae64c03a90d23fbae704dbab4d0810c17b4cb2a98a3264d7039f', '1535717833', '1f2239924664a5c08047d0fab41a6f6a4bed3ccaaa8e26e702efb139d8fde368', '1535717833');
INSERT INTO `user_token` VALUES ('131', '11090', 'e9e7dce46508e48ae3b6efcb6a9b38700741823c1e6d3c3a16222b9d5933e231', '1535718025', '97078701f0dac80b82390999e09149bd1f49ea1abd521542caf829d24074d39b', '1535718025');
INSERT INTO `user_token` VALUES ('132', '11091', '7aa7dce45407acb100275e5277df5eb91376ef1c030e004e2a2ca12f1c7c4b9d', '1535718453', '6d70ecd615f4075f241eb958274cb9cacee3c25874f10e715f80dfdf6517908b', '1535718453');
INSERT INTO `user_token` VALUES ('133', '11092', '55ee46725f454510437a0100a4d523b4644bda4321803dee99e3bafd7f6f21f9', '1535718477', '429dcf71003bb5d7335e88a626af1d7bedbfd9e5723e88f33f790389a6aabd74', '1535718477');
INSERT INTO `user_token` VALUES ('134', '11093', '7debc91a5ada343b81d4cce9059caaef746bc29ae65ef087e4517335abdc7697', '1535718495', 'c17261d6679a4f047dfeef09e93b61f189ca51009bcab49e34ac3fe38bda49ed', '1535718495');
INSERT INTO `user_token` VALUES ('135', '11094', '3db17747608fb4a4a5ac8990dd97ba658382a78515181603ea06ddfd23860865', '1535718510', 'dbf037395c93c9b3f822316257fd4d6ea5cc3cc4e919b399a9431ae0aa425ac1', '1535718510');
INSERT INTO `user_token` VALUES ('136', '11095', '9d61f3e7a1bf0a898ca8a172dd9604b23fc2ce963c6ee1d50483241846e852ca', '1535718824', '8ac8b9e1670bd6ec80d3388b2400af2717e8ca9c70a0bd884566fb6ef9b91ef9', '1535718824');
INSERT INTO `user_token` VALUES ('137', '11096', '620126742990c95013f617f3f94cb8bbabc5944b563ed4dfe1a5871a17687900', '1535718920', 'b3dce2a77ccfd1fe15c087f61df98fd431c7d47ec995bb9dabfcaad07ac095fc', '1535718920');
INSERT INTO `user_token` VALUES ('138', '11097', '228b5fbcfa44954c4ecd1c07c89e130a4665e851ff2f99321e5daf194411044b', '1535719036', 'cefc9e36b4d02ad98f2e2202ffdbcb794488c510838a4946d0c8482f4087c707', '1535719036');
INSERT INTO `user_token` VALUES ('139', '11098', '3d18a80e476a990d6197e62836a180fd03980ca0f2301135f8de24831b345cf5', '1535719117', '2d9e350528da742fa1148ba956c1c36d91dc1f06ec5f91496582c8ba9ee65de8', '1535719117');
INSERT INTO `user_token` VALUES ('140', '11099', '92ba122b15527a4c17be66ec42640d117e0fa6ca8c4a0619c88984dd35dff19c', '1535719182', '4c63370235ad56b3bf9c894ed359419f52adb551067ebec9b3fb9f168df3ef58', '1535719182');
INSERT INTO `user_token` VALUES ('141', '11100', '880d11be5bcd9a46789b00ae1219435212ad338e5a25fd645e4b889083c9741a', '1535719195', '9d3cb78e66c57c1fe8b9a1bf9e2c1bc30fa00dfa4a697944b71d1df710134d18', '1535719195');
INSERT INTO `user_token` VALUES ('142', '11101', 'd7ae4db2dc7486e1925126dc9ceaf17a91d852781fcf12041fd37a85b80f7628', '1535719314', '79aa1ff9c3354ddde38075f1ca8360bd9acce350132e84748a71b5f641087cc8', '1535719314');
INSERT INTO `user_token` VALUES ('143', '11102', '1d0beddd64cd7f00ab1fea0e2c60bf87c7d6b28d548bcff5f074077cace77fba', '1535719327', '0f4f43f89953ebe92f3ed83d6d8d6803410d652bcce094c65f3780c29072a6a7', '1535719327');
INSERT INTO `user_token` VALUES ('144', '11103', '6bfdef1e1750a4c86f1a791cc7451d54821a16e7d9659d395f6b41364d30adc9', '1535719434', 'c479f385cbe430f60c2177fe83dc726cfb15c43d3a4b3c6a60bd84ea0e15d887', '1535719434');
INSERT INTO `user_token` VALUES ('145', '11104', '6644bec0249cf680066a0c41422b472163bfe369484d75abd5cbf442c210411e', '1535719472', '00297da83a16d817d4d82229ed9a49dfe2bc1ca9fefad2fc0419ddef1222c646', '1535719472');
INSERT INTO `user_token` VALUES ('146', '11105', '04c4bfbff6c3119bbc31273464e23168f1b0a023b6c921f157571ae7c38dd9ca', '1535719503', 'f3388997b34e8b6fe275166caa960dcb1a7b07f268c8c2331bf70b092076459e', '1535719503');
INSERT INTO `user_token` VALUES ('147', '11106', '20abeb2a4483bd652cfd021e0a3e222c5eb3434758a0a2e80b0fba6d521d3380', '1535719611', '554e9f95fb33ffa9bb4dbcd9f8b0cee7259e553e73f745a868399312e6d3039a', '1535719611');
INSERT INTO `user_token` VALUES ('148', '11107', '9f908a76c1acaec3243fb58bc55bf2c418af599f6dffced2ba7b62c1fa9ef4d3', '1535719782', 'dcb475906c413b88ae59aa9710ff11ef7a3402a7270323653e7c5bf76352829d', '1535719782');
INSERT INTO `user_token` VALUES ('149', '11108', 'e5bbdcefebcfe20b354b4d5fc7cb1ac1460bc09f8c124b86496d814766cb09b2', '1535719795', 'a0e5b935f41bb5bed00db235a49c670674ec8a2c891fdb5a94e9ed6ccd005630', '1535719795');
INSERT INTO `user_token` VALUES ('150', '11109', '83d95f6b041fafcb441f546b0486e3d798917375b916f497e54c6e32216e8ee0', '1535719852', '1f1429819443f203bcdf8d6bbde61b8e78e6691a3cff7d71559e42e1a20a0e00', '1535719852');
INSERT INTO `user_token` VALUES ('151', '11110', 'e8097c61955545fcbfca136aed9ee06619f617516dd7003b684e2fb1de5c84f0', '1535719991', '1e75ab67deede121ca4602f575c3d969c982c22d3378d8516c77265d46423bb5', '1535719991');
INSERT INTO `user_token` VALUES ('152', '11111', '1f6273d0587f2548cb1dbc341e8f07214093117ba74f8138ccb822bb46dda209', '1535720063', 'cdd5923c9d533455bc373117f82718974f5ae64fd3d0a9ea9a7df91d4b89a2d6', '1535720063');
INSERT INTO `user_token` VALUES ('153', '11112', '578f540e51338fd26ccf19ed2c31f747c63345f1133fb82fa17e3c53bae2663d', '1535720101', '9f84abb87785f0d6a158a96651724f676895998cb4560dcd28d7b0bfd3979486', '1535720101');
INSERT INTO `user_token` VALUES ('154', '11113', 'b58712596aa8c7ed11688e6bc25665cf502c43f800c51597985a152cca5e3244', '1535720123', 'a7292224bb6ba7877de3c3d7075c11abb86d7a190a8036751d718a5f65ad33c9', '1535720123');
INSERT INTO `user_token` VALUES ('155', '11114', '4e56791c9de2ee1cc63a3bdb729b0067174a16f3e159f419a7670a04a7dc95bc', '1535720185', 'fc7693b1fc7784eb3f31a07f7e872ef3a7e989c320bc19343ea2fd06448c6e8a', '1535720185');
INSERT INTO `user_token` VALUES ('156', '11115', 'a9adcc525c16493c66f224abf1c4c78307e91b6a8646d0e92ac318cb304d874c', '1535720251', 'b261bcb7c7f4b7f3deacc4b374b21b3e7eade5ef36cdbf7f56b193b7040f8c33', '1535720251');
INSERT INTO `user_token` VALUES ('157', '11116', '447315f529cfcd401a102ee5e341bf289c24803246c41033b8c4da7dd21e979f', '1535720276', '57c8cc393bd24dafcd846147db529ec633aadbd99258d2fbef2aed7345b09490', '1535720276');
INSERT INTO `user_token` VALUES ('158', '11117', '1188168754df0a675f8df512ee36bcca229212483ef7e2e366ea192e15c65037', '1535720366', 'afad4d5d8d97277c745ac51ee4141c358fb6e85b570f2cdeadcdac90bbec4e55', '1535720366');
INSERT INTO `user_token` VALUES ('159', '11118', '9b1ceb99df08e1b259168158400c8c36a2a61c9ea3e1dfa82f296830b2d91e23', '1535965049', 'f9477af9a982892e46a4a9008570a93181ecb0e42a59d9ce3dfb0b3c2fdf8e83', '1535965049');
INSERT INTO `user_token` VALUES ('160', '11119', '6f7ea7899acdaf7a2d7f4462f0af914487ead3e8b22dcc6ed20c35e1646eadce', '1535965146', '289e8192e9172ffaf32e5b2c01a52f0eb51ec82d858a615a245c8a9aa206e989', '1535965146');
INSERT INTO `user_token` VALUES ('161', '11120', 'a144e86a5fcf98df0be022c3f4365f475507781b414cc152cf3df9c57c4466e1', '1535965193', '9778fab518ce7c20c105cd3f2b016728734f508a1a8db154b1664207d304c573', '1535965193');
INSERT INTO `user_token` VALUES ('162', '11121', 'bfc617749e0d9a06f3cab834d705517bbc320220f49ea1cd5f83bc67dfd87e68', '1535965205', '695f45171071a527b67c0f85b7bbf2613e49eb9381132bda8e50d9253cdd21a8', '1535965205');
INSERT INTO `user_token` VALUES ('163', '11122', '28ffdd0ad2f65d45ec44e69bc9ff9320cf1b8769324bbc7f63deb4642a43cc69', '1535965214', 'f94c4b1323c70df597b82fcf6bb9b931812b987c6a0b19283b37d70478987aa5', '1535965214');
INSERT INTO `user_token` VALUES ('164', '11123', '210dfe0a4e62f0cee5d8712b40f92f6f1ace458bcea3a89b8d22806161cfd261', '1535965244', '9da3891d58e7388a9cf5b85bdafb27c9d7ddc94725433015f9ca5c26ab324611', '1535965244');
INSERT INTO `user_token` VALUES ('165', '11124', 'edc539b63f584d91e3c98e9990bd9334abe5283c7a2757a97c165ea6cc300a49', '1535965305', '57e5f4b14725ed3ac633ce5584ea8589c95000d4e5a4cd99e4c9ffa7f0301df5', '1535965305');
INSERT INTO `user_token` VALUES ('166', '11125', '2715848ba85af9e4aa342610c187096d4c5cea248c93e91e312681287d0e32d2', '1535965317', '5fa962f99fc0600c6b2f2369ee1ab4dcb5ca4f2640ca3ac9d035b112481ede2e', '1535965317');
INSERT INTO `user_token` VALUES ('167', '11126', '85c4a8666e424b1e9651574ed7d621d84d620f29eb7e70993f63f7fedcda7a2c', '1535965410', '00f7c877f8388f610a7ef1a656decddcce65be748459089ac69be18139c5d1fc', '1535965410');
INSERT INTO `user_token` VALUES ('168', '11127', '9dad31e1007919933f7219caa3e450bf2aca7c8497827b2429c3f7ab55a346b6', '1535965433', '68e6543e85fb69e2e88e63db3f69f4614441b7c24a34d40abff8cd955f3eda94', '1535965433');
INSERT INTO `user_token` VALUES ('169', '11128', '270bbad07eceb149b48e0cfec0484adba7dec611064f2ab7a96551fe9be77b40', '1535965452', 'ca6f5e8a8890afdee3b25f65c2c2e5a212cbdb1a3d633a746bef607b87113b33', '1535965452');
INSERT INTO `user_token` VALUES ('170', '11129', 'ab334999c433a102a3a1df2953f48a647058097fe9452ef6fc6f46791cebbb95', '1535965523', 'bbe985fd8a24c40787ce48849ec31259039759fe2c749e95144b4a1839a55eec', '1535965523');
INSERT INTO `user_token` VALUES ('171', '11130', '0175187f582224318778765ee57e939795e673d39123557e370394a009872bfd', '1535965741', 'c7af383443a09750263c2dd3a3664ac61a1a4d6faf8d9e3e8557b6f76dd0a080', '1535965741');
INSERT INTO `user_token` VALUES ('172', '11131', '1bc1bb7b22d2d159ae3392f51a42928f8b4bfe0b71b9159ade3ddef4d25e50d7', '1535965754', 'cbf9a65d05898df10db21cfffe6c587c05f4ba74853ba9d94abdc52ecda968df', '1535965754');
INSERT INTO `user_token` VALUES ('173', '11132', '8eb2393184a5161d5e42ef52df476dc25dc104beead9f96c36726488b6f6dddb', '1535965883', 'a925d32db5c2690cea5d1ef2ea377a33e2570ad7e63798d19556a9444ebb8023', '1535965883');
INSERT INTO `user_token` VALUES ('174', '11133', 'e5a9d2c23711b6af95809cf6370663805c2284acc28a4d99253e63a1ab8de829', '1535965916', 'c4a450cbc79f6447951619ba167a45f78ab80ac9a8d9f4e8351e4409e764f8bf', '1535965916');
INSERT INTO `user_token` VALUES ('175', '11134', 'c9b08480fd7fa39abf33db4783d94efeaf58a6da06cd66f73c5f25aa6314feae', '1535966064', '030cf65acc2a2915792d0c6b38360b16731729ad08b5d53cc730f33286807266', '1535966064');
INSERT INTO `user_token` VALUES ('176', '11135', '06303c8d3f2ce73fbf1f924cce187efc86cee5daa1589a2ef5c8131e001f0a92', '1535966516', 'aae30c36c427de5e52744299f4bfff4379689796accbb86d6a2a16d804184a78', '1535966516');
INSERT INTO `user_token` VALUES ('177', '11136', '8643963a0186bb4c030b8aa7b67cd091c7568045b1d532943f8ddb25476216ce', '1535966558', 'ba798d392c0b1e07f1c07862e1c5a7696c19164b5ef1e432e11888327701d212', '1535966558');
INSERT INTO `user_token` VALUES ('178', '11137', '0a99498d651119db5149218b4b44192666247a0bfcd86de8b2728b810e155294', '1535967649', '584dcb7a1f770a2ecbd9336b07515f6f0ea4ca93d08d2fb89cef22f9d0afacce', '1535967649');
INSERT INTO `user_token` VALUES ('179', '11138', 'fabafaa8a07f63339dededb35c0ee74dd9479df02116764f05dfe98035af96ef', '1535967670', '5bce6b3b11d5976c9a253bd62736b1b0e3694d698ad47073318d9be6eb75fe64', '1535967670');
INSERT INTO `user_token` VALUES ('180', '11139', 'f2bb60a001ef0ee45cdc47c0a84c1179b48f105fdc45ac776fe52a5622e15785', '1535977819', '05234e75d2d896a190574c9739d7d100f1611b2fff49aceb2e527a81bccca1ce', '1535977819');
INSERT INTO `user_token` VALUES ('181', '11140', 'd9aa1e3e11ffc0a6dec9cdcd1e6d1a6e6c73a9d6157171c53938d918bf5fe7c3', '1535977920', '6643266861583117e2a5476c0e66e5443c79b1bb7f59b41dbd455b729288cf54', '1535977920');
INSERT INTO `user_token` VALUES ('182', '11141', '7f0079aab20611d24a66a36c99855f399d05ac3d5277c7b2df3bafd9b130a8fb', '1535977969', '5fc92954e8124e230c8545e4745196005ce68c70d7046cc74d1c784a0b51e333', '1535977969');
INSERT INTO `user_token` VALUES ('183', '11142', 'cdd6378b1bc05f3b51ed5973ae90562582be2a6226eccebb3fc5fd79bd5460fa', '1535978114', '34dc83029c54027dc2e4a410292b169eff512a028c387e225998cc59734f16c8', '1535978114');
INSERT INTO `user_token` VALUES ('184', '11143', 'fe47b276244de0d2c4a7edb532b38788838541364b1ad1e75c3010d48831c599', '1535978252', '8e599c0c86926edfac43b1dd824d36dd0f2ea1fe8e8572e7d4506840f923eafd', '1535978252');
INSERT INTO `user_token` VALUES ('185', '11144', 'b96b07126f9c65120212afa7c2685ba1ff30b5888eb80483967fb5049ee8f304', '1535978367', '43acffeccda2a0a13c43be63ecdb97e5cd5f8c54d69f661f57645cc0ee9418dd', '1535978367');
INSERT INTO `user_token` VALUES ('186', '11145', '32621fa0ccbd6e4a507d9954b099e402790b1c4661954eea048e7f9de1adfecc', '1535978581', '73fcb9292ba3f9055ec1f7da800f4741ae06f29343e18f32144624e3f3d20b84', '1535978581');
INSERT INTO `user_token` VALUES ('187', '11146', '5aed40e4472caa04ea68ec3cf361dacde41f7fe8aaf5eec5f34b930a7292d85a', '1535978644', 'b5a394ead27399bd34d442b69c5a7a5fe02a2c6e77bf3ebe7d77f2310bdbacd0', '1535978644');
INSERT INTO `user_token` VALUES ('188', '11147', '50be1fee2c7c262290ba65c52f42e70393a448a9ffb4c4d5f25d3486f77f9fda', '1535978896', 'f2a9ffbb43faa38d634692c8247a588962947cc14cc8961d5d143f303d2189f6', '1535978896');
INSERT INTO `user_token` VALUES ('189', '11148', 'e9a0b191f2ac528e1e3787bed16762b3aaa9dbf3d78d672fde7ba281b9bd7eba', '1535979953', '858e4061fcf4b7150a659039832ff3ec03f9dc442dd795214ad3e83840954c76', '1535979953');
INSERT INTO `user_token` VALUES ('190', '11149', '3e7bd1c5b280b7c8e3c1074ad5e29a6cebe944bbe1a4022d6bb41460cbc569ce', '1535980002', '1ac8660a1f04b157981f1ee1d2dac8a79464bde13bf04e91ff811f8551b9f0a3', '1535980002');
INSERT INTO `user_token` VALUES ('191', '11150', '17ac6b510e4f0ec946d3eaf1d1c3be04e6b432f362e8ccc41592f8948da932c6', '1535980074', '6523bd9e976d6daaf434f4e9640a7a7fed5caa8de324ec4996e1025161a7ec6b', '1535980074');
INSERT INTO `user_token` VALUES ('192', '11151', '7f61bd8d80360d5f847748b7599ec65c378ca77f80a7c0b90c36fba42ba01fbb', '1535980570', '1733cdb85cdb92f1cd825142b5efb473beaa54cec497ddb3601640520674e409', '1535980570');
INSERT INTO `user_token` VALUES ('193', '11152', '9846ea1d0e56a8b0d74173fcd390326165d2e6587ba2a362a3ffc79f1d3cd967', '1535980624', '2c0765d27826d173af8fb07dd874fa8ce460f36e3cc6badd24de26da482b2d9d', '1535980624');
INSERT INTO `user_token` VALUES ('194', '11153', 'f3148b84194e796c2e1585564b19a1d96696d44fb8ccf0428a9850122d2f74d3', '1535980638', '79377228c48ab2c2a1bbc5062c003145b26707cca592a3b4505a7e2d2fed79b7', '1535980638');
INSERT INTO `user_token` VALUES ('195', '11154', '694b9b21cd2aed3f2cdcc632224e106e853f931e82e04a304f5914bb58beaa93', '1535980688', '2fc8f62236a05b84c86107dd2c82444819965b903126f48349521ed4dead73ed', '1535980688');
INSERT INTO `user_token` VALUES ('196', '11155', 'e3415c0c11dbada278b4ace5b91a4fb49600133ee28b740d889755ab0cf0dc98', '1535980956', '1a3bc2ae95564c15ecf4b1909bb827402dd3b09d91e1223ef84d0459c0f6bd41', '1535980956');
INSERT INTO `user_token` VALUES ('197', '11157', 'cd167739a6dfaffac01a389e4a7505dfb435f00f8afbe9f7e0e01d4517f5d82d', '1535980976', 'ebb73617ef70b36538d19db8627799434eefd34555809645c38eb2e91994043f', '1535980976');
INSERT INTO `user_token` VALUES ('198', '11159', 'ca524ff7ffefdd29d2ace54d5eab4db24cbfe75c75f44d03bfad990e0604e42a', '1535981601', '2a1cdc6b4039758fbddd478a4ce3d284ac0170567080cce348b666833eec504d', '1535981601');
INSERT INTO `user_token` VALUES ('199', '11160', 'ffa8936d74a16b7594e531a38dbb2a27e8bf8c9e0fd5b6f6f3d5fde296c48ca0', '1535981624', '4ac9c1635f80d2563aa5647768d7b46d2dfed4756005b844d34bfec340098acd', '1535981624');
INSERT INTO `user_token` VALUES ('200', '11161', 'd54ffa39bb3877731c5cc99be6f664497b0dae39492f82de58bb006f4e3f95b8', '1535981841', '9e9d4769e1a0a6dba42ccc6677cad36122d1182b1d3227de6a2d25ab0cb1e49d', '1535981841');
INSERT INTO `user_token` VALUES ('201', '11162', 'a66385cbb601579bcd7137be935d05dbc29d274bd4e7a6962b26df07b7c6b775', '1535981974', '5a9106614c22f2c6cfa799e723c7437536f89494dd891e618db849bcfa29aafe', '1535981974');
INSERT INTO `user_token` VALUES ('202', '11163', '26fe480b009905dfac145750208f7186c84dce16623a21f9483d86cc8ebbcae0', '1535982443', '93da3f895d935980e64f2b7e24ae645bf50c7fdd95b0185ecbbf81dfe792351a', '1535982443');
INSERT INTO `user_token` VALUES ('203', '11164', '1a0cb2bc7f0bc396d3606d862aea7b8ebd3e2ceb278cfc163b8b18599f8a25d2', '1535982606', 'bf721b07fd889c9184c79ba04ac7b1d444bcd7e50a119f8b64d549a61d9b9e79', '1535982606');
INSERT INTO `user_token` VALUES ('204', '11165', '097399a4fcc5058815bce6e686772e332d94cd807c7ffbc5890b6d581720685e', '1535982681', '6b4e275721867dfb94c699490c95c99156d64d36a745822f63b88dc68f199535', '1535982681');
INSERT INTO `user_token` VALUES ('205', '11166', '0f640eda3b16454d2d2b09f8f13e687523d869ae261caddb28caa6661fa23d93', '1535982751', '9cddebd42f32d018a4075288bf324f2dd4e107fdff591b3cac62bf888ad7b981', '1535982751');
INSERT INTO `user_token` VALUES ('206', '11167', 'd29e36a027e2294052ac1e5bf9c55afbb19c6b321d88c04af239a63256776d2c', '1535982873', 'cd254e16f9a977df449478857022b689e76290fc892aa0abd5c27a791b6b4265', '1535982873');
INSERT INTO `user_token` VALUES ('207', '11168', 'e4581a3c967843fbe655f5d025d51981cfce242884c9c3c1535afd3ffbd5ea8f', '1535982920', '7d423c328e58f1369f4283a3412a3f4db21976e9a3934b38c76639f7d51b6935', '1535982920');
INSERT INTO `user_token` VALUES ('208', '11169', 'f91ffe4a8bdc8ce8fd53a9f6f2a926dd900e35f7d76171cc5e3c990e760539a9', '1535982978', '0e2a5c1c0855ec21c169284202a97f59ddd994a0a07377690daf54261cab613a', '1535982978');
INSERT INTO `user_token` VALUES ('209', '11170', 'd8e9efa5507deffb2a8628ae2ea6f17bf36e02d5bcdc99ec7d7931af02c74de1', '1535983019', 'a8875536df6bbb5c5708fd550b0bb5dc14bd7f2373703bb76c7378325212af6f', '1535983019');
INSERT INTO `user_token` VALUES ('210', '11171', 'f9f3f19cb7d0136e1b565ab8aeffb430305d69d68b69c2088495a7c7a83101e2', '1535983097', '050838ec6119a0fee91d9ad1fab7084592d2afaf976d70b2df546a2b795b94da', '1535983097');
INSERT INTO `user_token` VALUES ('211', '11172', 'fd5e05c42d47768513afd96427736055ac3352853639b6450dad230312de1fbb', '1535983118', '62efcafb2edf1c054f901cbe0cda2ab42e7fb69fe715d62962084aa7156ca3c3', '1535983118');
INSERT INTO `user_token` VALUES ('212', '11173', 'af92b29c5abc7a38b42e7da2a2b609363a254f207dcb815945ec7752f5d06b0d', '1535983154', '8cdfb2110b654dd2654a62df5cf1fde267cbc0c0d08343f2b84e2fe2e89a197a', '1535983154');
INSERT INTO `user_token` VALUES ('213', '11174', 'addfaf1e9c5a1f07264f23b7b458274af5ab32fa4796c64e0bfa2d609db94f3f', '1535983187', '7710f1ba5b22ca9eacd6426038786e727323be8e4226b97a8b4e0c88b8c707b6', '1535983187');
INSERT INTO `user_token` VALUES ('214', '11175', 'e59c9eee2bb5f13572c8f03eab050611b49fc018c0fbee7b61dbf3ab759234c8', '1535983321', '654a92231af5dd5dccccadc779ec61f4fd1c530e8e31e5ae0074f730d2f6924c', '1535983321');
INSERT INTO `user_token` VALUES ('215', '11176', '84cb42b305aecbd26ab93321dfc321ff9d426e82cb60720870a5110b8364be80', '1535983325', '4f171a9fea98d0465cc32ff0d02b1834bf10a7702405442a33063e79d88b837c', '1535983325');
INSERT INTO `user_token` VALUES ('216', '11177', 'd68f54577fd8818f72591ce4f9f49ac752e8349e5fe10d4f937a7bc2791d4215', '1536028860', 'c5e7df2618d4b086623714c541c3e5244d8311e5bbdbf01dcb3ceed01298d80d', '1536028860');
INSERT INTO `user_token` VALUES ('217', '11178', '6e4bd1c0c95a27059044d372d55263a5b5f6a66c2e9eb5f1b948a8d0de6c3aa7', '1536028921', '93103d56e7938f30fc5ebf0a2d9934bf4062b6abb49f584c68890fa800a962ab', '1536028921');
INSERT INTO `user_token` VALUES ('218', '11179', 'a69557c302fd6cecbf05aaba2f598d4291d1eede5916c810e88963585af8608f', '1536044747', '92591e9a96f6c348704dc3c7ff0c6f1fb47e90855891056b5bf57d2146b4dd7c', '1536044747');
INSERT INTO `user_token` VALUES ('219', '11180', '9baa4d19ac85857824f2e2ef53d2e586c4a6741f6159b80566f15032555dd431', '1536045031', 'ecadbc93fe550f64035abb030d6365e6b2c945f1cfc86da9d7f8b0c039f9a959', '1536045031');
INSERT INTO `user_token` VALUES ('220', '11181', 'c973647a128d24d10551a88941dc7416a57b98e80f607f6ee574af5954c86ec4', '1536045096', 'a9d0e9812804cf08ee700fba4d6bc4a2ef0b08e359f94f984cdcf4d01da95df0', '1536045096');
INSERT INTO `user_token` VALUES ('221', '11182', '4e8ee4eb719066ce97040980d5848df7fce89eb8dff2fa1ebd3133882ee48288', '1536047675', '4c9060ba7f1d24e6e9a7aacbcd640fd0ae828c5258fa688f2f75490f9dfb4d51', '1536047675');
INSERT INTO `user_token` VALUES ('222', '11183', '47b193cf85c9a6359d57da8b5ae5b55affbe14c6f6d12bdd6cfefad7de9da211', '1536047702', '7ca2b682d7a6f4638ed32682222947466964548dc1efea1eb36c2179e9b517f2', '1536047702');
INSERT INTO `user_token` VALUES ('223', '11184', '55811d97b8c5f0fd20fac1d63b3c7808dcae8382680ee7a9c36dd95f40c565e0', '1536047736', 'b1b545f7210fb5cd55c74570663c958f3b7c2fae198f029c49570cee8ca22e97', '1536047736');
INSERT INTO `user_token` VALUES ('224', '11185', 'f90216efa67d81ae970e7871fcfa53307558fb2dbcfa34405a4a7f30d9f5e00d', '1536047759', 'a26a95c5501a6b34504c847908533c7eff8700f5ebf287315902d1d6ac65ff1e', '1536047759');
INSERT INTO `user_token` VALUES ('225', '11186', '5c2910ff697adb236a009900c745d0ecf3a015cf6ae643eb46b89c60cf42dcbe', '1536050994', '0a2052e27b5d4f839b5160f30d66861142ea37a7c69cd57d1080f5c1fc903937', '1536050994');
INSERT INTO `user_token` VALUES ('226', '11187', '58aebf0b0d83ea4f8120f51bfcd58a939afcb13c3dbedfc3db1c49e24af68174', '1536051019', 'd08dd33b58c5d1bb3d263f08c0c3e9cb4d92c3e2ac78b2d7e40398c13a75b5be', '1536051019');
INSERT INTO `user_token` VALUES ('227', '11188', 'f52566ca0fb28e37ee1eea2d5d2130f43fdd43c167de268fedbf6ab71af53861', '1536051036', 'd18c54e65a8747a289892550164fbe00196d4980e8fcaaf3abc7b6af9fd88628', '1536051036');
INSERT INTO `user_token` VALUES ('228', '11189', '9d3b4f26b798832525602748b7855d0aaf41a52b5bf82e50b2046500c566cb3a', '1536051063', '2baf655d425b5d1b17a13fcfcd6a6d3ef81dc3e776e73492a6ae44247b096d1e', '1536051063');
INSERT INTO `user_token` VALUES ('229', '11190', 'bea62610192a0704c7a8a4113bff43c856f515893602e62e211f76df8545bad8', '1536051118', 'd21777692dfd2e2f78b26e59ec615af9f49dfd3399e31fee459aca0a55ff0d85', '1536051118');
INSERT INTO `user_token` VALUES ('230', '11191', '6d15682b1eb7bec0fd07f2ede028bad09034798e7477d9ee5f60ed00c42e665a', '1536051146', '52e87ca9fcf695d5455619284d6e58099d497136762303b734110d5aa0bb3660', '1536051146');
INSERT INTO `user_token` VALUES ('231', '11192', '8b942aff7c2a4bba11cd0335f0ef5260b419f3ffce9d394904a7a22ce5027d1a', '1536051176', 'f3fd0363a6794f0c3740ee2e310cded8917da8ae0d1846962c437a8dd22ffca7', '1536051176');
INSERT INTO `user_token` VALUES ('232', '11193', '8c3a29b7df251b1a6c79b6c5072b66862ae4529cb433aa20ed2b8377feb39a78', '1536051186', '6be2e8efc2e68c0b72085ee83ca476703cee688ae4ba8302dcf85044b6772a8b', '1536051186');
INSERT INTO `user_token` VALUES ('233', '11194', '104364b5261434f7871fedbaf95dae6ca8da5cde45fe1f963ea458d197801258', '1536051219', '6402dbb625568fcf1c9db48521bc560a0fd0bd2f1ae3c0ff0d9a66808cca4163', '1536051219');
INSERT INTO `user_token` VALUES ('234', '11195', '0a0463d2dddbd2c4386ccf9fe79579c2ea88881f0482e67ec9cde1b7743d1ec0', '1536051227', '3b428503156c1e8444cc578cb39e57885912b3c1c485b08b9f85da9b8c363476', '1536051227');
INSERT INTO `user_token` VALUES ('235', '11196', '652093fea2c788a77db24a05a4379084228010402cc0f25f5b22f35c7b2a3377', '1536051244', '3ee12a75c347da4e016060065919e3977d68ccd5baee3978faa5db7c76b13c81', '1536051244');
INSERT INTO `user_token` VALUES ('236', '11197', '148673aff77ca39181b6d34bc9824c6d3085f68c317d1f10a90e148b7a3d8990', '1536051267', 'd2058768a9efb4c422d0beaf914fed8cb9006b3168698091854eeb77bbec9942', '1536051267');
INSERT INTO `user_token` VALUES ('237', '11198', '70a9833e6494bc31fc6bfd89eb01cd3192b80fadb0905eb2a95f9b17f22d3c44', '1536051294', '8edd6a678aa0ecf8865630c42ffcce18f5334ee1754d9e13a37960d83ff25331', '1536051294');
INSERT INTO `user_token` VALUES ('238', '11199', '836308641564dc41beec2d9360e694730ca0e199bd8b9ad3c6ca159e4d821d4e', '1536051321', 'd86d4b85cd2418f257e053ecf091c531c5ec400b9da128d7bcd19884b03c5b18', '1536051321');
INSERT INTO `user_token` VALUES ('239', '11200', 'e8fed53be321f9507fc7e55a2fbce620ae0f905a3524a597486ed196a89a7bc5', '1536051333', 'bb8a2f49267e59dd11e3a9fc3db8661a9b8fd57a28e7f68dd51b462a477cb26f', '1536051333');
INSERT INTO `user_token` VALUES ('240', '11201', '562a0e3e96b3a4d62ca7c89903442effdfefc9cee84740ec1915bdda049e2b12', '1536144306', 'e9ce83a6ff6464f132d15859019cde3f56140d95b165c17b5ea5a0e83b25827f', '1536144306');
INSERT INTO `user_token` VALUES ('241', '11202', '2f424386f670e2acb06dfa1c11fd003ea2703b59e767dce614c6edc2ccceb764', '1536198827', '74ab60aa8a80e6ed2a91d9d9b365a41235970a382b22caf7cf72c92259929820', '1536198827');
INSERT INTO `user_token` VALUES ('242', '11203', 'dcde4b0a176eb44ed257e66e80d33617789bef4b8a4e9b2300ae45b4b509f43b', '1536200137', '84f9960a81e6c40b37f8c85948b2a10ac15fef70875a6f228da647edb9fa94a8', '1536200137');
INSERT INTO `user_token` VALUES ('243', '11204', '0d4be902945006c1caf61e2e0deea392183c71cfcb0a2cd6c3b03d3d7247669f', '1536200167', 'b1ea48da8bfdea5675252c41960fdc7c1ae0319a10215ee66b8fdab4656cc813', '1536200167');
INSERT INTO `user_token` VALUES ('244', '11205', '53f0115cd0902f558dac0be33b41cab66e85a417b9f2d6a4f12c6c12cd6ac014', '1536200365', '960c4c2c60051cb94fe10e793455467e5a0ed1613af2279e02a408e1998de8ff', '1536200365');
INSERT INTO `user_token` VALUES ('245', '11206', '5cabf82312caef2968e907bfdb086e86cf1e2063ecd3459baba9ae5db17601b6', '1536200441', 'ba8203978c7fc7d543e741163beeac9d28585d774f063506ee5f73da7100d002', '1536200441');
INSERT INTO `user_token` VALUES ('246', '11207', '6f7b303065abb1550d8b872aefbbbae924b8c799575e434a7bc9f5d3aec946ee', '1536200547', '59a78fd589ec458c5b5615c01c5faaa7d42deb92dc941285486e0d42858a4293', '1536200547');
INSERT INTO `user_token` VALUES ('247', '11208', 'fb585634f32d8d9c49b0c45bd7ae2743f30aae49405865d65fd6d6fa264f39e9', '1536200566', 'd7f5539f72d3abec82a0ffaa3e9387dd03ca11807235c133560fe4cfb1fede6e', '1536200566');
INSERT INTO `user_token` VALUES ('248', '11209', '520fdd9b8a483ce55de9356b45b4edb61f9b697cd8e9e6db1fcbb4308ce5e22e', '1536200679', 'eee95f9c5cd569f26b012b1a2c70195598f6aec4d5e48e23519496f31b49aaa4', '1536200679');
INSERT INTO `user_token` VALUES ('249', '11210', 'ae52a945331d6dfdd107c6b1666680707e0a9d5aa5869b8d1c681bc12ec01e0a', '1536200697', 'd7544c80cddb71b893fc3e0db20744c84c3b46c88309b074d5e5995ef442882e', '1536200697');
INSERT INTO `user_token` VALUES ('250', '11211', 'b70220040e5d487609c35c0421d66eaa7e91274a09e7d1e3e8dc4a7920bbe37c', '1536200715', '835d704803e8914c147af0f46a620161e8f74c2bce89a00e7eaa425b41d2028b', '1536200715');
INSERT INTO `user_token` VALUES ('251', '11212', '1520da6e85df5a5849470b6d3ffce2f29a18b2ca3a08982f60b70dcd269f0e91', '1536200723', 'e668602d00a6d51a1bf715293e2d69af291541600b1594fd90af6af01dd056b8', '1536200723');
INSERT INTO `user_token` VALUES ('252', '11213', '47c03016c9530227efb413ba83a6a05b8d02c6895b699378ba6a9ddb4dadd5d9', '1536200817', '643c05306702da87e61b47ab17a102e85cf9e34538297bde760984d6e7f8ec93', '1536200817');
INSERT INTO `user_token` VALUES ('253', '11214', '376b8e6049c9ab79976f99c4cbd062cd17b927a6c01cc7e6e89e493b45e89dc3', '1536200891', 'c9f4786f8791729d6b0b6429b94e182e7199d0bd23f98b75c487aeb2917fb407', '1536200891');
INSERT INTO `user_token` VALUES ('254', '11215', 'a650fe7387a800602b50091f7b01b5e3a1fb252948383d4e9d50048295dc45c2', '1536200918', '46b7126d29f19ace075d6193c6ebe082627b7ff57772866b93745df1df1ca2ef', '1536200918');
INSERT INTO `user_token` VALUES ('255', '11216', '2d53afb675c57202cf96b72ea189d16d02f929773944b41174963bd2a8e7c86d', '1536200949', '35f2eaf5ee983cee7ede4055283943818fe1936e37b5b56cf2f3876b191d0b4e', '1536200949');
INSERT INTO `user_token` VALUES ('256', '11217', '0d3a933807114fd158ada89166192ef72f101ccc28297055fb471886ed00de52', '1536201393', 'aacdacd6cb5e730ce1e9875f3739d60e378571c0bd355106956ffd5948b02122', '1536201393');
INSERT INTO `user_token` VALUES ('257', '11218', '33a843195a814d02d9af520bf4fd3f9ad84a42e5c2a3da263aa256e90422eb1d', '1536201399', 'e388d1cead456e803e2280e33e0579bbb3392faf85c1199a1b31ab317a43a660', '1536201399');
INSERT INTO `user_token` VALUES ('258', '11219', '3abdca0742f906dcdf03314257c63eb2307f2cd4fe9eb2725a79744c22a0b37a', '1536201404', '31c784c08dc87024783f59d254eeba5a52b9893ce4313d6a49e6b0a9730a9281', '1536201404');
INSERT INTO `user_token` VALUES ('259', '11220', '9e2cf699c806b6d477b61f7db8575d554d3875d4c4bf4d4a94ed8bd070401d31', '1536201425', 'b897f919c207a532fd4ba260adc0855e31a51108ceea3924b972379a782385e8', '1536201425');
INSERT INTO `user_token` VALUES ('260', '11221', '63d7651873f07f70263c499e8e276d7445429987dbca6c18238123cfd8a0c2e7', '1536201494', '37d3003b41cb67950348167e8df598ee03bc429a039e7d2011604ce9639b034a', '1536201494');
INSERT INTO `user_token` VALUES ('261', '11222', 'c7ec586c35aff30d46302a1978c3f0b65e9bc66aa6ca7d4f1d7743ba99f40a36', '1536201595', 'fd6801efa6bfa6414cb15900ab1ab0f4bdcc34af5107a0e032b50224af327a13', '1536201595');
INSERT INTO `user_token` VALUES ('262', '11223', '61991b48b98e854f334b14d10e6cef9e6d0fcd9dcccbcd738e9edc96984c353a', '1536201610', 'fb2e2a55063966c7cbe931d4f5eed9d8c61701184ce6fef9f7267f9caff111d0', '1536201610');
INSERT INTO `user_token` VALUES ('263', '11224', 'a8809e6ef5d74b29f2ccc349d67b0ef1add0b884a95be9d5fe76e8a6904a22b9', '1536201742', 'd7e5fc203a593ef58783667a90fcc80fd2def684a7670f6e5322e6e3d0617ad0', '1536201742');
INSERT INTO `user_token` VALUES ('264', '11225', '0e4d4540f9e82f9e7a75ac651f95c38d780238c57e8920d7cd569114c1623bca', '1536201761', '5832901e972e306838dd5dc4b79b01a526b4526562d5a05e124c8c24390871ef', '1536201761');
INSERT INTO `user_token` VALUES ('265', '11226', 'b49007efd6b8343156de2075d5021b3ed4d5c217296b272288aa97118eeb0e6b', '1536201803', '03ada80f6522aa0b7c5a2e48128078756024f4106652d1ea36ffbb44c11f7e44', '1536201803');
INSERT INTO `user_token` VALUES ('266', '11227', 'dd3b950d6473e2a1602630351d296d862b26683b439586505f3536021c7c231c', '1536201966', 'f070e2f901af55e3692c0e1926d9e0360d0a6dfa8885ec102e80fddcea476803', '1536201966');
INSERT INTO `user_token` VALUES ('267', '11228', '8a347da79a37eaf137543e7ce802e00a345008f331476c533ce03443ccae30d7', '1536202009', '9e33d3f846d9e1603888a598959a1cbb8752bedea85212a8ac7f52885e4b894d', '1536202009');
INSERT INTO `user_token` VALUES ('268', '11229', '350d16aecadf53b465dfe13c919844cdd431b02a160490dcb7fd126cbb914e9f', '1536202013', '4da39a34fb8697313cdac91238141e39231df0c64a471775cd26b86d95b58025', '1536202013');
INSERT INTO `user_token` VALUES ('269', '11230', '435de97d01ae1b55ac616d936991df5085a34ee7bc23f9702bb2aeb9990815d0', '1536202064', '4cc0d6b74580725f6adbd40cfabf167ff46a6e01b50259560ff8db89220e981d', '1536202064');
INSERT INTO `user_token` VALUES ('270', '11231', 'ac9eab99a248b6adf1d8ca61d41920ac112178f1ccd9a624c173fabb48132087', '1536202137', 'e2c6359cc6d36d5b6721ab0320d063a204c408eaa3744bf894ff18c3f47eb8b7', '1536202137');
INSERT INTO `user_token` VALUES ('271', '11232', '04171e63cda717d34706cea30d8788d5ad3bbb622a665e240a72dad8b0625909', '1536202156', '6607469f8049b4290c97df337e5279c4a853599959112ef55673ce660dfdbb0f', '1536202156');
INSERT INTO `user_token` VALUES ('272', '11233', '4d182c3f9adf78552ae8dce24762aaa1b42268c2f9ab07bec0972a96e11ba1b2', '1536202189', '578c6cc0bc3a880cb89e4bb842576da464ce3424dbfacefa2c8e0e5ee996a8fb', '1536202189');
INSERT INTO `user_token` VALUES ('273', '11234', 'af0d096423a6d26dc37daa5ee066014fef025ad8bbd3ff843a7a50d8be9450b2', '1536202524', '6988aa14b733e2971650144e60dfda13d6f9db36d2a2615b63c9b8854fb65611', '1536202524');
INSERT INTO `user_token` VALUES ('274', '11235', '7886c967a4b191a84a0c65ed699216f47717d7ec795884c64bdb9ff4dfa43a30', '1536203136', '38755a5ef6edadd604d0e4af97036098444ea562a474683e884d97e96440823e', '1536203136');
INSERT INTO `user_token` VALUES ('275', '11236', 'e50a4ec373e55d48d2279079bf18839d85674134a9312e7a1b900bc2b6535ae1', '1536203140', '980526c9668247fcb50dfe71081a5ffbce5c3746fe23669787c46b11769d005f', '1536203140');
INSERT INTO `user_token` VALUES ('276', '11237', '32b1e10d0f5697b4e994887411805b2346adcda48e9fb0a281dec7377b0358d9', '1536203152', '5193faad6b38102f2419e9e0aea90bc308e5576a5687163ad9b351b8c691613c', '1536203152');
INSERT INTO `user_token` VALUES ('277', '11238', 'acae5da696a50807b3fc203ea8962bb1ab3312264f5983dab4623a37bc13b738', '1536203259', '63ccb4e68fc46dc9b51a8046c3fbd95029c8f38d09a80cd424e7daa85c671d73', '1536203259');
INSERT INTO `user_token` VALUES ('278', '11239', '146de09ea4abcea9c17d873b28fb2d9b3b0b16f0877943467025f4152bcac156', '1536203637', '527519ff9a43ac3fe35a4244d3702593e95d68df8c2a59f4ff7e06021fe50deb', '1536203637');
INSERT INTO `user_token` VALUES ('279', '11240', '0baf4a1045146a7209419dd9333d168a4ada464f424ad7e81bc206c49703d757', '1536203682', 'bcbe52da1daac94106c86fee4421336f714b196b42fd838bdb681f88357bcc0f', '1536203682');
INSERT INTO `user_token` VALUES ('280', '11241', '2a9214bc1ea17cf33b3ca5488dd31c6313e55091c5feb3945a48f599411662a6', '1536204060', '73ab5c8e706b44d05d5540ac5d976578e52c7f995b647a37a73401392a2e9f41', '1536204060');
INSERT INTO `user_token` VALUES ('281', '11242', '87252ec7696e226359f4d4a95669a8b86f0cd9c253ae863ca38c07c5eb85500e', '1536204541', '6e5846e3b63a6e6f6b377782612c9fdaffc47c71e9dd8db6d9f694d65c538817', '1536204541');
INSERT INTO `user_token` VALUES ('282', '11243', 'e6fd0c8598d19444ce175c6446cb77ed8b3d75a91b1cbe08754935a1e4566e62', '1536204765', 'ee8c4aff903166fe98e3b7c6448f26442b29198058efc19bd9bb7000fae34fc5', '1536204765');
INSERT INTO `user_token` VALUES ('283', '11244', 'b5a2f7ff5903904860d237281fa3a7eb43a7e7d8bdc3a8aff4a2502057d93369', '1536204848', 'ad79afca6b28a84cb841b952f18bf182483be8eb50d1b41851367513de22ae78', '1536204848');
INSERT INTO `user_token` VALUES ('284', '11245', 'ca282e91c7bc6116c883aa28e3d3acb2b329be6388fa4335b822bdd043e5fb95', '1536204998', 'dd4dd1a7ce732681424d12e934e02e874f924d969e289902010db9c52fd3925f', '1536204998');
INSERT INTO `user_token` VALUES ('285', '11246', '98ee61e9430055aea9e75e7f5828703140c78e5aa2cf3ccf36d9fa60b11bf33e', '1536205003', '7a46e1d31257ea97b54c2dbd34c0d8a07930c2ab3abcad2f9cf2ed6a6b595968', '1536205003');
INSERT INTO `user_token` VALUES ('286', '11247', '22c98ab61fde03d1fed1c014f8335bf07135095e28ebd11fc2b4e2e2076c608f', '1536205020', '32bb820ec573d974c36676377ada74dd98a7a47083b7dc115b41c6eb91b1460a', '1536205020');
INSERT INTO `user_token` VALUES ('287', '11248', '151f00328a8499d1972e8770da6654ef2d7a2801896a18dea779d7cbd4b6c54d', '1536205081', '3b885137a9b32a8d12fedc0ec8e8b70f60b2e6b7cbdd0e49ba30cc7f8b640d2e', '1536205081');
INSERT INTO `user_token` VALUES ('288', '11249', '7b34f728bc1501dc0f950e9ee2f01fe43335f1b16500095bbe3ed8357a8300e8', '1536205116', 'b91b077cc27c62a68d073e698458efe0ce5818ab645c3baebde589f7491e0016', '1536205116');
INSERT INTO `user_token` VALUES ('289', '11250', '122ded5f8d51bd7a63a77644966fd70a1e54f823eeef9d130dc1d5ba6377088c', '1536205172', 'd8a4b877be75a573d888fad8780b9dc0ca8ebe2a4f584de969fcaab0e32363d9', '1536205172');
INSERT INTO `user_token` VALUES ('290', '11251', '20eaacc131ef7b0e18638b2e92bb47f260c3bcbd5b8178aab38f6d3ee545e969', '1536205541', '6fc42cebde31d7ecbf0c938c357d81a2fe2af6cfda5d6e5a8c39ff3ff56509e0', '1536205541');
INSERT INTO `user_token` VALUES ('291', '11252', '25005d5842d5f6cebcc35fab509d9f6b90970899c2ae8ffb5a315a4ecacf9301', '1536205590', 'f6f5f95cec193d055421d9e625721df130545b7c64f66f969c28c6b826b9539b', '1536205590');
INSERT INTO `user_token` VALUES ('292', '11253', '1f28025c2a9d314f8b1cc2a39bba74f597f9800c5e952d3b2b7a1b63a19f766d', '1536205629', '5867aca9aa0224ff72f4117bf45e1a6f8328369888b542d39083eb30041eb247', '1536205629');
INSERT INTO `user_token` VALUES ('293', '11254', '0efa5fc081276912de2dbb077f3767d51dd128350b3b9265c48a89cca4bc5f90', '1536205706', '2e676d91391bce42ad2a3c486d1397efba59d858dfed335a116fb8a492ba7a6e', '1536205706');
INSERT INTO `user_token` VALUES ('294', '11255', 'e8054acb77c074d5b2a61f5eaa632c184cd3d96de0dfad0fc1bcb67cf8e2db76', '1536205735', '55118848a620dc37256899e6860a89eb0306dd78e57dd9cb9dab733c39152b38', '1536205735');
INSERT INTO `user_token` VALUES ('295', '11256', 'cdaf742b1ac916c8cd5bc02db89bc84b80d6fa6ea5d753c0f3d3c1d37a9b7b71', '1536214842', '0f5e1417082eeba0b39621dfae94f9c9430807946f5de03df1a8b71cbc1f06e6', '1536214842');
INSERT INTO `user_token` VALUES ('296', '11257', 'c3492e006856c5b78d68cf65232163776e5817b38ddf6ab020aa940e25ebbb7e', '1536214880', '5945ba02b9810ff1e77c879de02f8bb8a17181a967222feabd8a8bcfcb4fc11f', '1536214880');
INSERT INTO `user_token` VALUES ('297', '11258', '1c4000dde178f3e8cff8fbcba9a9fb15645ffaeaa0168b07c7b94d224bf4c2cc', '1536214891', '052cc5024c18655739ca22f8e6674696efddad8da97fabe0e6f54b91660348eb', '1536214891');
INSERT INTO `user_token` VALUES ('298', '11259', '6baa89df45a7e14ef6b9a46f2e4af93486924bf34866d332ac00bfeac45af332', '1536214963', '76b7bbb1d23bb7dcb4052401df81a7ad38622459fe889e2e80c3295a62fa00fd', '1536214963');
INSERT INTO `user_token` VALUES ('299', '11260', '110f37324d6e5a28c30fa18c57cda9337aa1e571d15c50106b92ee8ac96b7d54', '1536214989', '07c2c799357542e675b9aa9354d8b81ddc723f082c671d1fc28e335b29f90143', '1536214989');
INSERT INTO `user_token` VALUES ('300', '11261', '4ac159e05575fe2f6723b2d46a8741bb52625762d8da9bc4bc06e8cce4428e94', '1536215057', '247bf3fd8e7c52901096844c61ba36efe6cfa4b5e8c574afc844a04a2b9e8bf8', '1536215057');
INSERT INTO `user_token` VALUES ('301', '11262', '3be5ffbeba3bebd185fac4b29fbe87cf0490e11a47f8820785e1e71749e81617', '1536215523', 'e05d75e92b6c4f4f49c6131f38d40333a4e65d8192a8743c12ff63fe69753118', '1536215523');
INSERT INTO `user_token` VALUES ('302', '11263', '2743669cca8cbb4459f158d4733e292bf59afe8e6ce5082a4a8555e8144b7505', '1536215553', '87fc757cf1be5937bb2d0a87a088cba2e4ab3ccbf765c68485e6b52b362a93e4', '1536215553');
INSERT INTO `user_token` VALUES ('303', '11264', 'b1519c1996adf3a85b29356754533e930061fb389f5cf83a77089a5547ee44ed', '1536216535', 'fd349938b490cfdbc025e1a91fccc5fc93994b956d8d1abdccf9f7b05abe3460', '1536216535');
INSERT INTO `user_token` VALUES ('304', '11287', '209092b52e82b445ab085d50d364c3e90ee1ffcccbd5c17547b7992bcd562907', '1536218570', '668d065e451ec90106ba624ad72c75151e694535a93defbf9172a2bf502dd548', '1536218570');
INSERT INTO `user_token` VALUES ('305', '11300', '11d7658df8468e44c1c8a754634f704ed436dd2934395a1cebda5b921ea6f82f', '1536219031', 'f13ef95749cab64ca0498df4279505a29046727e8d95def869919b7c40569e1e', '1536219031');
INSERT INTO `user_token` VALUES ('306', '11312', 'c2984e3c4bf2a457b753670b4a3590a649a05086691c90f5709afcf5de89f43b', '1536219039', 'c75a84c3e6a8d5c791026ecf18acfa76c2ae5695b6d494ba249ff045a8750d79', '1536219039');
INSERT INTO `user_token` VALUES ('307', '11324', 'f9bf34da1c90dfd569fcbaef86ae6f41000b3007cdc411bcfdb3469da39baca6', '1536219698', 'c1af07b354fa27896a52f765b38034e9a692c3f77ef69678c7f538033743875d', '1536219698');
INSERT INTO `user_token` VALUES ('308', '11337', '5788e8a47c44f952946d1d389ac9f18d2427f964ff698bdb15151d1a351e26ab', '1536219828', 'd201c96351a53da62aa7c0397e4d34183ebe76abc6ecb0e2e5cb0fc481e6261b', '1536219828');
INSERT INTO `user_token` VALUES ('309', '11349', '7cbfa539f40dcfdb55209cdb4aa858037ab8d2b594891f9a94ff10c1d2090b14', '1536219833', 'dd372d65b9b5d7e36cb66035cb3535847ecfc05161d3ffb220e36da39aa6e1d1', '1536219833');
INSERT INTO `user_token` VALUES ('310', '11362', 'a81635d0731738f8a0adb6c694c599cb3b8106980b94c74b38be016bf9a506fb', '1536220281', '8853719b01328def630ea6669f12e7521c49982a691c4b8f58b2f3838a98447c', '1536220281');
INSERT INTO `user_token` VALUES ('311', '11375', 'eda107735ce1fddf46de73a3625540b3dae293536bead7daa2cc87cfc5599505', '1536220465', '2aa8a06959d726176661ca287f1a5f2610299485638d71312235733c37740cfe', '1536220465');
INSERT INTO `user_token` VALUES ('312', '11388', 'f1d462bfaca80ac15f474bae67566f6a3bf7735c810473c70dd18a7f2144d21a', '1536220536', 'e05943f076d66791dac3d21b197c4689bd8bd49725de2e43f68706f53277bec4', '1536220536');
INSERT INTO `user_token` VALUES ('313', '11401', '827263cf00326a8090ffbfab1ab79cd7197d277c665d1229c6c9cb1afbd68fec', '1536220580', 'c3ba10debaa081eeae0ae2fe8c76237946867ca69e19e85f30875399f688f7fd', '1536220580');
INSERT INTO `user_token` VALUES ('314', '11414', '9767336e00ec6ee09d071018a68d032bcb19d6a224b06c72b054934fc3618c99', '1536220594', '760a019f61182c256bed0d9ee42feb5bfcbc51a4d5d8fba978468bdef7b202ea', '1536220594');
INSERT INTO `user_token` VALUES ('315', '11426', '8e9b0db54ef1c59d91bfa9a5f32897d0539ae3d3247b2c767212805c0b794259', '1536220759', '2e5404f4d40763aff0f38a170d8c2ec46dcf72d12b80e6b99fc79988ddfa589e', '1536220759');
INSERT INTO `user_token` VALUES ('316', '11438', 'e03dd03f254fbde5c195be9a33af540d31c1209282731f8a92ad13fce04f2f79', '1536220774', 'ceba4ee547b2fd54a18729ae3a2485244c50f2393ded971acd29a33c64bccd35', '1536220774');
INSERT INTO `user_token` VALUES ('317', '11451', 'd253ec324610b9b3af7441484bd74af4df2caf934d69979091a91c7ddcb767e1', '1536220864', '51c818adcf81dc139fc30e902db45634c32e9e66b4a57885f151bc03ae0970db', '1536220864');
INSERT INTO `user_token` VALUES ('318', '11464', '1fbea414220cda0fa76ba597f1cc11ccd92015e18b6834a2a183f2f47ba8e6ea', '1536222989', 'e1e6da502eebec8cae479b2f9593939ee004f410c6849c5e0cbba6483e19f46c', '1536222989');
INSERT INTO `user_token` VALUES ('319', '11476', '1f15b58ab6dd84ec356e01d81f6c48bf4f910d6eb3aeeee7283fc9a70ed0e560', '1536226103', '1e347d08b81549c0a5ae6da252002fdf120de2ceff4d9e0da6ae4b5a5c1a3d5e', '1536226103');
INSERT INTO `user_token` VALUES ('320', '11488', '6f232628c499f65247028a0516ff5825d36adeace001d79e0f054944eb869b6d', '1536226256', 'fcd20f93c99a094e38ca0370010870aa81db789c8255d022c0156c9dcf98bac2', '1536226256');
INSERT INTO `user_token` VALUES ('321', '11500', '3af68b1d88568774323660cfda08c1aedca275c9a199e0bb42f2f9923741cdf0', '1536226305', 'f1bcbb6379a16955e35e408fadc879165aa3cc1a65499673c8e768a6a3f931d5', '1536226305');
INSERT INTO `user_token` VALUES ('322', '11512', '0e2dfca7456c41ff01bfdf0b5bca8c3550c7b8582ae863f969ec91958141fd87', '1536226345', 'cceeb02822a9e10a3973fb68d616097a8c60694783dff9081a829dd190c09aca', '1536226345');
INSERT INTO `user_token` VALUES ('323', '11524', 'dafaef52e7fdd7d71c36702b0d26e4c699eaca7cf3aa18a4fc67294a4570190e', '1536226369', '2758c2910982c32151b7971118d67299cc1d3641ee35f6000a7bdfa5d6788227', '1536226369');
INSERT INTO `user_token` VALUES ('324', '11536', '6fdd6d9a027e9256483c745a9600d46fbacca74f91bcbd5801e9d521d384a2fb', '1536226411', '572b4846dfb61ff9617371ad87b0a5efca5a5b21b3cf06801516098e1950d987', '1536226411');
INSERT INTO `user_token` VALUES ('325', '11548', '30fabcc92a91b4d92e14f7bf91b4c2d0cef6671094978c743365541df7c0023d', '1536226418', '0ceb0140ea51946d770ca39f1c78126e28972b0d85d49c08ac5ba88bb0dc220e', '1536226418');
INSERT INTO `user_token` VALUES ('326', '11561', '15d9fd67fc9d20f369a730294b260ee1fe9c4927b03315fe860635faa50fd9bf', '1536226468', 'cb6e8534c7887238286e6dc4c2213f7332f54326a96a482726530fac03aca7ae', '1536226468');
INSERT INTO `user_token` VALUES ('327', '11589', '0e8ecc516b59486c5aaddbe07cfddbdad102fe56eea0479b8fdb159cae63680b', '1536226624', 'ada8bfbd06ddfb0689e5a7b6fa0fed3f8a696a6c5baf186cdba1f18381ce1743', '1536226624');
INSERT INTO `user_token` VALUES ('328', '11601', 'cf6dcb1c58c38809a9e57cc3de03d8dd0727e56bdd52feb96bf541cc97fb0a51', '1536226713', '0e2e596c83c4717c61f76dae6a20c378e59f6fd31afb4dcf4def4f636d501cfc', '1536226713');
INSERT INTO `user_token` VALUES ('329', '11615', 'e79d9c18f3f43d031d04b21a0a05dd6ab87e090074b17b40492d59731fe5b465', '1536226734', '8c615145397c7a708875390a440907687a74fa85a2f94d058b55fbc0cf5af51c', '1536226734');
INSERT INTO `user_token` VALUES ('330', '11616', '79ce601a3df7aa01904f66a9bdd06faa23834dbe7c122629a4d2d7f1218396e0', '1536227085', '9c3c7c201ba6144244467025ad287c0b1e4b43d625a9506c4496332d2b608183', '1536227085');
INSERT INTO `user_token` VALUES ('331', '11617', 'f08d79e965629697781eb8be8ace1621793963a55203ce45bc2281c9d1573f7c', '1536227325', '8e68f57c2f6fee0146a6a932b688a6229f917eee9006ecc25cdd1158f9b92f4c', '1536227325');
INSERT INTO `user_token` VALUES ('332', '11618', '6c1da04f87992e23096903b0310fa6e8cd8b3c3cbe72c9550ee41f048b544bd6', '1536227359', '4fbcdc25cf57cc8f99d4448a243346ee9e4892e08051529c45c10feecde42467', '1536227359');
INSERT INTO `user_token` VALUES ('333', '11619', 'a22bc0d0c760e4858d9b0ef90f4afac9266fc05976fca2693456c389d8dfed2b', '1536227938', 'e031f3604b15c2fe4b4bb714cf5dcb2f439992469817ae24ad89763bd5967659', '1536227938');
INSERT INTO `user_token` VALUES ('334', '11655', 'de1bcdf70553b4de3a6929176ba3350ea359433a82ee923a0bbb714e8dbc50e9', '1539758227', 'cff25e02ef1bda61a60a7d63931fcdd87bb759ad707e0f48c7cb85183b32a38e', '1539758227');
INSERT INTO `user_token` VALUES ('335', '11657', '8b378a1fa2dc83482a3b30ede70bce3c9b3e904608d49d12576a69d086280bab', '1540172861', '57e71db8352c2edabd37acf60e71ffab1ab45ac6d4782b764d20f03d093bb1eb', '1540172861');
INSERT INTO `user_token` VALUES ('336', '11654', 'f8f5c0298ccee1badd890c79b0833a055d250a8dd618297cce72c3e6004a3a73', '1539845064', '0a447eb53342ae607c0734d26c6a4c04fa53c16df166974752d875439d5f7794', '1539845064');
INSERT INTO `user_token` VALUES ('337', '11656', '639cfedd15be6f343ef8fddbd974758a849e69a41a21130092f1866f8c8d0934', '1539571520', 'e42ee9644b46842aff32ae98adedae2deaf99e9a4511d08685ca9d1f91da4a76', '1539571520');

-- ----------------------------
-- Table structure for workflow
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow
-- ----------------------------
INSERT INTO `workflow` VALUES ('1', '默认工作流', '', '1', '0', null, '1539675295', null, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', '1');
INSERT INTO `workflow` VALUES ('2', '软件开发工作流', '针对软件开发的过程状态流', '1', null, null, '1529647857', null, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', '1');
INSERT INTO `workflow` VALUES ('3', 'Task工作流', '', '1', null, null, '1539675552', null, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', '1');

-- ----------------------------
-- Table structure for workflow_block
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_block
-- ----------------------------

-- ----------------------------
-- Table structure for workflow_connector
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_connector
-- ----------------------------

-- ----------------------------
-- Table structure for workflow_scheme
-- ----------------------------
DROP TABLE IF EXISTS `workflow_scheme`;
CREATE TABLE `workflow_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10103 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workflow_scheme
-- ----------------------------
INSERT INTO `workflow_scheme` VALUES ('1', '默认工作流方案', '', '0');
INSERT INTO `workflow_scheme` VALUES ('10100', '敏捷开发工作流方案', '敏捷开发适用', '0');
INSERT INTO `workflow_scheme` VALUES ('10101', '普通的软件开发工作流方案', '', '0');
INSERT INTO `workflow_scheme` VALUES ('10102', '流程管理工作流方案', '', '0');

-- ----------------------------
-- Table structure for workflow_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `workflow_scheme_data`;
CREATE TABLE `workflow_scheme_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) unsigned DEFAULT NULL,
  `issue_type_id` int(11) unsigned DEFAULT NULL,
  `workflow_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflow_scheme` (`scheme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10326 DEFAULT CHARSET=utf8;

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
