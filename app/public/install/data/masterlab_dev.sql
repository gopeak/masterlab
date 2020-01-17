/*
 Navicat Premium Data Transfer

 Source Server         : Mysql8.0
 Source Server Type    : MySQL
 Source Server Version : 80018
 Source Host           : 127.0.0.1:3306
 Source Schema         : masterlab_dev

 Target Server Type    : MySQL
 Target Server Version : 80018
 File Encoding         : 65001

 Date: 17/01/2020 16:08:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for agile_board
-- ----------------------------
DROP TABLE IF EXISTS `agile_board`;
CREATE TABLE `agile_board`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `type` enum('status','issue_type','label','module','resolve','priority','assignee') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_filter_backlog` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `is_filter_closed` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `weight` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `range_type` enum('current_sprint','all','sprints','modules','issue_types') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '看板数据范围',
  `range_data` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '范围数据',
  `is_system` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE,
  INDEX `weight`(`weight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agile_board
-- ----------------------------
INSERT INTO `agile_board` VALUES (1, '进行中的迭代', 0, 'status', 0, 1, 99999, 'current_sprint', '', 1);
INSERT INTO `agile_board` VALUES (2, '整个项目', 0, 'status', 0, 1, 99998, 'all', '', 1);

-- ----------------------------
-- Table structure for agile_board_column
-- ----------------------------
DROP TABLE IF EXISTS `agile_board_column`;
CREATE TABLE `agile_board_column`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `board_id` int(11) UNSIGNED NOT NULL,
  `data` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `weight` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `board_id`(`board_id`) USING BTREE,
  INDEX `id_and_weight`(`id`, `weight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agile_board_column
-- ----------------------------
INSERT INTO `agile_board_column` VALUES (1, '准 备', 1, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 3);
INSERT INTO `agile_board_column` VALUES (2, '进行中', 1, '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 2);
INSERT INTO `agile_board_column` VALUES (3, '已完成', 1, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 1);
INSERT INTO `agile_board_column` VALUES (4, '准备中', 2, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0);
INSERT INTO `agile_board_column` VALUES (5, '进行中', 2, '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0);
INSERT INTO `agile_board_column` VALUES (6, '已完成', 2, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0);

-- ----------------------------
-- Table structure for agile_sprint
-- ----------------------------
DROP TABLE IF EXISTS `agile_sprint`;
CREATE TABLE `agile_sprint`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1为准备中，2为已完成，3为已归档',
  `order_weight` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `start_date` date NULL DEFAULT NULL,
  `end_date` date NULL DEFAULT NULL,
  `target` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'sprint目标内容',
  `inspect` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sprint 评审会议内容',
  `review` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sprint 回顾会议内容',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 75 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for agile_sprint_issue_report
-- ----------------------------
DROP TABLE IF EXISTS `agile_sprint_issue_report`;
CREATE TABLE `agile_sprint_issue_report`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `month` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `done_count` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数',
  `no_done_count` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `done_count_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `no_done_count_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sprint_id`(`sprint_id`) USING BTREE,
  INDEX `sprintIdAndDate`(`sprint_id`, `date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for field_custom_value
-- ----------------------------
DROP TABLE IF EXISTS `field_custom_value`;
CREATE TABLE `field_custom_value`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `custom_field_id` int(11) NULL DEFAULT NULL,
  `parent_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `string_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `number_value` decimal(18, 6) NULL DEFAULT NULL,
  `text_value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date_value` datetime(0) NULL DEFAULT NULL,
  `valuet_ype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cfvalue_issue`(`issue_id`, `custom_field_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for field_layout_default
-- ----------------------------
DROP TABLE IF EXISTS `field_layout_default`;
CREATE TABLE `field_layout_default`  (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_type` int(11) UNSIGNED NULL DEFAULT NULL,
  `issue_ui_type` tinyint(1) UNSIGNED NULL DEFAULT 1,
  `field_id` int(11) UNSIGNED NULL DEFAULT 0,
  `verticalposition` decimal(18, 0) NULL DEFAULT NULL,
  `ishidden` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `isrequired` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sequence` int(11) UNSIGNED NULL DEFAULT NULL,
  `tab` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of field_layout_default
-- ----------------------------
INSERT INTO `field_layout_default` VALUES (11192, NULL, NULL, 11192, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11193, NULL, NULL, 11193, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11194, NULL, NULL, 11194, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11195, NULL, NULL, 11195, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11196, NULL, NULL, 11196, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11197, NULL, NULL, 11197, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11198, NULL, NULL, 11198, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11199, NULL, NULL, 11199, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11200, NULL, NULL, 11200, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11201, NULL, NULL, 11201, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11202, NULL, NULL, 11202, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11203, NULL, NULL, 11203, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11204, NULL, NULL, 11204, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11205, NULL, NULL, 11205, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11206, NULL, NULL, 11206, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11207, NULL, NULL, 11207, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11208, NULL, NULL, 11208, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11209, NULL, NULL, 11209, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11210, NULL, NULL, 11210, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11211, NULL, NULL, 11211, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11212, NULL, NULL, 11212, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11213, NULL, NULL, 11213, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11214, NULL, NULL, 11214, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11215, NULL, NULL, 11215, NULL, 'false', 'true', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11216, NULL, NULL, 11216, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11217, NULL, NULL, 11217, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11218, NULL, NULL, 11218, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11219, NULL, NULL, 11219, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11220, NULL, NULL, 11220, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11221, NULL, NULL, 11221, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11222, NULL, NULL, 11222, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11223, NULL, NULL, 11223, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11224, NULL, NULL, 11224, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11225, NULL, NULL, 11225, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11226, NULL, NULL, 11226, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11227, NULL, NULL, 11227, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11228, NULL, NULL, 11228, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11229, NULL, NULL, 11229, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11230, NULL, NULL, 11230, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11231, NULL, NULL, 11231, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11232, NULL, NULL, 11232, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11233, NULL, NULL, 11233, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11234, NULL, NULL, 11234, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11235, NULL, NULL, 11235, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11236, NULL, NULL, 11236, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11237, NULL, NULL, 11237, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11238, NULL, NULL, 11238, NULL, 'false', 'false', NULL, NULL);
INSERT INTO `field_layout_default` VALUES (11239, NULL, NULL, 11239, NULL, 'false', 'false', NULL, NULL);

-- ----------------------------
-- Table structure for field_layout_project_custom
-- ----------------------------
DROP TABLE IF EXISTS `field_layout_project_custom`;
CREATE TABLE `field_layout_project_custom`  (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `issue_type` int(11) UNSIGNED NULL DEFAULT NULL,
  `issue_ui_type` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `field_id` int(11) UNSIGNED NULL DEFAULT 0,
  `verticalposition` decimal(18, 0) NULL DEFAULT NULL,
  `ishidden` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `isrequired` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sequence` int(11) UNSIGNED NULL DEFAULT NULL,
  `tab` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for field_main
-- ----------------------------
DROP TABLE IF EXISTS `field_main`;
CREATE TABLE `field_main`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `default_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0,
  `options` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '{}',
  `order_weight` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `extra_attr` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '额外的html属性',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_fli_fieldidentifier`(`name`) USING BTREE,
  INDEX `order_weight`(`order_weight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of field_main
-- ----------------------------
INSERT INTO `field_main` VALUES (1, 'summary', '标 题', NULL, 'TEXT', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (2, 'priority', '优先级', NULL, 'PRIORITY', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (3, 'fix_version', '解决版本', NULL, 'VERSION', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (4, 'assignee', '经办人', NULL, 'USER', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (5, 'reporter', '报告人', NULL, 'USER', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (6, 'description', '描 述', NULL, 'MARKDOWN', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (7, 'module', '模 块', NULL, 'MODULE', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (8, 'labels', '标 签', NULL, 'LABELS', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (9, 'environment', '运行环境', '如操作系统，软件平台，硬件环境', 'TEXT', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (10, 'resolve', '解决结果', '主要是面向测试工作着和产品经理', 'RESOLUTION', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (11, 'attachment', '附 件', NULL, 'UPLOAD_FILE', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (12, 'start_date', '开始日期', NULL, 'DATE', NULL, 1, '', 0, '');
INSERT INTO `field_main` VALUES (13, 'due_date', '结束日期', NULL, 'DATE', NULL, 1, NULL, 0, '');
INSERT INTO `field_main` VALUES (14, 'milestone', '里程碑', NULL, 'MILESTONE', NULL, 1, '', 0, '');
INSERT INTO `field_main` VALUES (15, 'sprint', '迭 代', NULL, 'SPRINT', NULL, 1, '', 0, '');
INSERT INTO `field_main` VALUES (17, 'parent_issue', '父事项', NULL, 'ISSUES', NULL, 1, '', 0, '');
INSERT INTO `field_main` VALUES (18, 'effect_version', '影响版本', NULL, 'VERSION', NULL, 1, '', 0, '');
INSERT INTO `field_main` VALUES (19, 'status', '状 态', NULL, 'STATUS', '1', 1, '', 950, '');
INSERT INTO `field_main` VALUES (20, 'assistants', '协助人', '协助人', 'USER_MULTI', NULL, 1, '', 900, '');
INSERT INTO `field_main` VALUES (21, 'weight', '权 重', '待办事项中的权重值', 'NUMBER', '0', 1, '', 0, 'min=\"0\"');
INSERT INTO `field_main` VALUES (23, 'source', '来源', '', 'TEXT', NULL, 0, 'null', 0, '');
INSERT INTO `field_main` VALUES (26, 'progress', '完成度', '', 'PROGRESS', '0', 1, '', 0, 'min=\"0\" max=\"100\"');
INSERT INTO `field_main` VALUES (27, 'duration', '用时(天)', '', 'TEXT', '1', 1, '', 0, '');
INSERT INTO `field_main` VALUES (28, 'is_start_milestone', '是否起始里程碑', '', 'TEXT', '0', 1, '', 0, '');
INSERT INTO `field_main` VALUES (29, 'is_end_milestone', '是否结束里程碑', '', 'TEXT', '0', 1, '', 0, '');

-- ----------------------------
-- Table structure for field_type
-- ----------------------------
DROP TABLE IF EXISTS `field_type`;
CREATE TABLE `field_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of field_type
-- ----------------------------
INSERT INTO `field_type` VALUES (1, 'TEXT', NULL, 'TEXT');
INSERT INTO `field_type` VALUES (2, 'TEXT_MULTI_LINE', NULL, 'TEXT_MULTI_LINE');
INSERT INTO `field_type` VALUES (3, 'TEXTAREA', NULL, 'TEXTAREA');
INSERT INTO `field_type` VALUES (4, 'RADIO', NULL, 'RADIO');
INSERT INTO `field_type` VALUES (5, 'CHECKBOX', NULL, 'CHECKBOX');
INSERT INTO `field_type` VALUES (6, 'SELECT', NULL, 'SELECT');
INSERT INTO `field_type` VALUES (7, 'SELECT_MULTI', NULL, 'SELECT_MULTI');
INSERT INTO `field_type` VALUES (8, 'DATE', NULL, 'DATE');
INSERT INTO `field_type` VALUES (9, 'LABEL', NULL, 'LABELS');
INSERT INTO `field_type` VALUES (10, 'UPLOAD_IMG', NULL, 'UPLOAD_IMG');
INSERT INTO `field_type` VALUES (11, 'UPLOAD_FILE', NULL, 'UPLOAD_FILE');
INSERT INTO `field_type` VALUES (12, 'VERSION', NULL, 'VERSION');
INSERT INTO `field_type` VALUES (16, 'USER', NULL, 'USER');
INSERT INTO `field_type` VALUES (18, 'GROUP', NULL, 'GROUP');
INSERT INTO `field_type` VALUES (19, 'GROUP_MULTI', NULL, 'GROUP_MULTI');
INSERT INTO `field_type` VALUES (20, 'MODULE', NULL, 'MODULE');
INSERT INTO `field_type` VALUES (21, 'Milestone', NULL, 'MILESTONE');
INSERT INTO `field_type` VALUES (22, 'Sprint', NULL, 'SPRINT');
INSERT INTO `field_type` VALUES (25, 'Reslution', NULL, 'RESOLUTION');
INSERT INTO `field_type` VALUES (26, 'Issues', NULL, 'ISSUES');
INSERT INTO `field_type` VALUES (27, 'Markdown', NULL, 'MARKDOWN');
INSERT INTO `field_type` VALUES (28, 'USER_MULTI', NULL, 'USER_MULTI');
INSERT INTO `field_type` VALUES (29, 'NUMBER', '数字输入框', 'NUMBER');
INSERT INTO `field_type` VALUES (30, 'PROGRESS', '进度值', 'PROGRESS');

-- ----------------------------
-- Table structure for hornet_cache_key
-- ----------------------------
DROP TABLE IF EXISTS `hornet_cache_key`;
CREATE TABLE `hornet_cache_key`  (
  `key` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `module` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `datetime` datetime(0) NULL DEFAULT NULL,
  `expire` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  UNIQUE INDEX `module_key`(`key`, `module`) USING BTREE,
  INDEX `module`(`module`) USING BTREE,
  INDEX `expire`(`expire`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hornet_user
-- ----------------------------
DROP TABLE IF EXISTS `hornet_user`;
CREATE TABLE `hornet_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '用户状态:1正常,2禁用',
  `reg_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `last_login_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `company_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `phone_unique`(`phone`) USING BTREE,
  INDEX `phone`(`phone`, `password`) USING BTREE,
  INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_assistant
-- ----------------------------
DROP TABLE IF EXISTS `issue_assistant`;
CREATE TABLE `issue_assistant`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `user_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `join_time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `issue_id`(`issue_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 395 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_description_template
-- ----------------------------
DROP TABLE IF EXISTS `issue_description_template`;
CREATE TABLE `issue_description_template`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '新增事项时描述的模板' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_description_template
-- ----------------------------
INSERT INTO `issue_description_template` VALUES (1, 'bug', '\r\n这里输入对bug做出清晰简洁的描述.\r\n\r\n**重现步骤**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n4. xxxxxx\r\n\r\n**期望结果**\r\n简洁清晰的描述期望结果\r\n\r\n**实际结果**\r\n简述实际看到的结果，这里可以配上截图\r\n\r\n\r\n**附加说明**\r\n附加或额外的信息\r\n', 0, 1562299460);
INSERT INTO `issue_description_template` VALUES (2, '新功能', '**功能描述**\r\n一句话简洁清晰的描述功能，例如：\r\n作为一个<用户角色>，在<某种条件或时间>下，我想要<完成活动>，以便于<实现价值>\r\n\r\n**功能点**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n\r\n**规则和影响**\r\n1. xx\r\n2. xxx\r\n\r\n**解决方案**\r\n 解决方案的描述\r\n\r\n**备用方案**\r\n 备用方案的描述\r\n\r\n**附加内容**\r\n\r\n', 0, 1562300466);

-- ----------------------------
-- Table structure for issue_effect_version
-- ----------------------------
DROP TABLE IF EXISTS `issue_effect_version`;
CREATE TABLE `issue_effect_version`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `version_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for issue_extra_worker_day
-- ----------------------------
DROP TABLE IF EXISTS `issue_extra_worker_day`;
CREATE TABLE `issue_extra_worker_day`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_extra_worker_day
-- ----------------------------
INSERT INTO `issue_extra_worker_day` VALUES (1, '2020-01-25');
INSERT INTO `issue_extra_worker_day` VALUES (2, '2020-01-18');

-- ----------------------------
-- Table structure for issue_field_layout_project
-- ----------------------------
DROP TABLE IF EXISTS `issue_field_layout_project`;
CREATE TABLE `issue_field_layout_project`  (
  `id` decimal(18, 0) NOT NULL,
  `fieldlayout` decimal(18, 0) NULL DEFAULT NULL,
  `fieldidentifier` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `verticalposition` decimal(18, 0) NULL DEFAULT NULL,
  `ishidden` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `isrequired` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `renderertype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_fli_fieldidentifier`(`fieldidentifier`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_file_attachment
-- ----------------------------
DROP TABLE IF EXISTS `issue_file_attachment`;
CREATE TABLE `issue_file_attachment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `issue_id` int(11) NULL DEFAULT 0,
  `tmp_issue_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mime_type` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `origin_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `created` int(11) NULL DEFAULT 0,
  `file_size` int(11) NULL DEFAULT 0,
  `author` int(11) NULL DEFAULT 0,
  `file_ext` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `attach_issue`(`issue_id`) USING BTREE,
  INDEX `uuid`(`uuid`) USING BTREE,
  INDEX `tmp_issue_id`(`tmp_issue_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 540 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_file_attachment
-- ----------------------------
INSERT INTO `issue_file_attachment` VALUES (1, '7436abdc-44a0-40d0-8e52-caa2be27d765', 0, '', 'image/png', 'project_example_icon.png', 'project_image/20200117/20200117154554_20263.png', 1579247154, 1136, 1, 'png');

-- ----------------------------
-- Table structure for issue_filter
-- ----------------------------
DROP TABLE IF EXISTS `issue_filter`;
CREATE TABLE `issue_filter`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `author` int(11) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `share_obj` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `share_scope` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'all,group,uid,project,origin',
  `projectid` decimal(18, 0) NULL DEFAULT NULL,
  `filter` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fav_count` decimal(18, 0) NULL DEFAULT NULL,
  `name_lower` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_adv_query` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否为高级查询',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sr_author`(`author`) USING BTREE,
  INDEX `searchrequest_filternameLower`(`name_lower`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_fix_version
-- ----------------------------
DROP TABLE IF EXISTS `issue_fix_version`;
CREATE TABLE `issue_fix_version`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `version_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_follow
-- ----------------------------
DROP TABLE IF EXISTS `issue_follow`;
CREATE TABLE `issue_follow`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `issue_id`(`issue_id`, `user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_holiday
-- ----------------------------
DROP TABLE IF EXISTS `issue_holiday`;
CREATE TABLE `issue_holiday`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_label
-- ----------------------------
DROP TABLE IF EXISTS `issue_label`;
CREATE TABLE `issue_label`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bg_color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_label
-- ----------------------------
INSERT INTO `issue_label` VALUES (1, 0, '错 误', '#FFFFFF', '#FF0000');
INSERT INTO `issue_label` VALUES (2, 0, '成 功', '#FFFFFF', '#69D100');
INSERT INTO `issue_label` VALUES (3, 0, '警 告', '#FFFFFF', '#F0AD4E');

-- ----------------------------
-- Table structure for issue_label_data
-- ----------------------------
DROP TABLE IF EXISTS `issue_label_data`;
CREATE TABLE `issue_label_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `label_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_main
-- ----------------------------
DROP TABLE IF EXISTS `issue_main`;
CREATE TABLE `issue_main`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pkey` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `issue_num` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `project_id` int(11) NULL DEFAULT 0,
  `issue_type` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `creator` int(11) UNSIGNED NULL DEFAULT 0,
  `modifier` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `reporter` int(11) NULL DEFAULT 0,
  `assignee` int(11) NULL DEFAULT 0,
  `summary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `environment` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '',
  `priority` int(11) NULL DEFAULT 0,
  `resolve` int(11) NULL DEFAULT 0,
  `status` int(11) NULL DEFAULT 0,
  `created` int(11) NULL DEFAULT 0,
  `updated` int(11) NULL DEFAULT 0,
  `start_date` date NULL DEFAULT NULL,
  `due_date` date NULL DEFAULT NULL,
  `duration` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `resolve_date` date NULL DEFAULT NULL,
  `module` int(11) NULL DEFAULT 0,
  `milestone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT 0,
  `weight` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT 0 COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT 0 COMMENT 'sprint排序权重',
  `assistants` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `level` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '甘特图级别',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否拥有子任务',
  `followed_count` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被关注人数',
  `comment_count` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论数',
  `progress` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '完成百分比',
  `depends` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前置任务',
  `gant_proj_sprint_weight` bigint(18) NOT NULL DEFAULT 0 COMMENT '项目甘特图中该事项在同级的排序权重',
  `gant_proj_module_weight` bigint(18) NOT NULL DEFAULT 0 COMMENT '项目甘特图中该事项在同级的排序权重',
  `gant_sprint_weight` bigint(18) NOT NULL DEFAULT 0 COMMENT '迭代甘特图中该事项在同级的排序权重',
  `gant_hide` tinyint(1) NOT NULL DEFAULT 0 COMMENT '甘特图中是否隐藏该事项',
  `is_start_milestone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_end_milestone` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `issue_created`(`created`) USING BTREE,
  INDEX `issue_updated`(`updated`) USING BTREE,
  INDEX `issue_duedate`(`due_date`) USING BTREE,
  INDEX `issue_assignee`(`assignee`) USING BTREE,
  INDEX `issue_reporter`(`reporter`) USING BTREE,
  INDEX `pkey`(`pkey`) USING BTREE,
  INDEX `summary`(`summary`) USING BTREE,
  INDEX `backlog_weight`(`backlog_weight`) USING BTREE,
  INDEX `sprint_weight`(`sprint_weight`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  FULLTEXT INDEX `issue_num`(`issue_num`),
  FULLTEXT INDEX `fulltext_summary`(`summary`)
) ENGINE = InnoDB AUTO_INCREMENT = 762 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_moved_issue_key
-- ----------------------------
DROP TABLE IF EXISTS `issue_moved_issue_key`;
CREATE TABLE `issue_moved_issue_key`  (
  `id` decimal(18, 0) NOT NULL,
  `old_issue_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `issue_id` decimal(18, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_old_issue_key`(`old_issue_key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_priority
-- ----------------------------
DROP TABLE IF EXISTS `issue_priority`;
CREATE TABLE `issue_priority`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sequence` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `iconurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status_color` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `font_awesome` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `_key`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_priority
-- ----------------------------
INSERT INTO `issue_priority` VALUES (1, 1, '紧 急', 'very_import', '阻塞开发或测试的工作进度，或影响系统无法运行的错误', '/images/icons/priorities/blocker.png', 'red', NULL, 1);
INSERT INTO `issue_priority` VALUES (2, 2, '重 要', 'import', '系统崩溃，丢失数据或内存溢出等严重错误、或者必需完成的任务', '/images/icons/priorities/critical.png', '#cc0000', NULL, 1);
INSERT INTO `issue_priority` VALUES (3, 3, '高', 'high', '主要的功能无效或流程异常', '/images/icons/priorities/major.png', '#ff0000', NULL, 1);
INSERT INTO `issue_priority` VALUES (4, 4, '中', 'normal', '功能部分无效或对现有系统的改进', '/images/icons/priorities/minor.png', '#006600', NULL, 1);
INSERT INTO `issue_priority` VALUES (5, 5, '低', 'low', '不影响功能和流程的问题', '/images/icons/priorities/trivial.png', '#003300', NULL, 1);

-- ----------------------------
-- Table structure for issue_recycle
-- ----------------------------
DROP TABLE IF EXISTS `issue_recycle`;
CREATE TABLE `issue_recycle`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `delete_user_id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `pkey` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `issue_num` decimal(18, 0) NULL DEFAULT NULL,
  `project_id` int(11) NULL DEFAULT 0,
  `issue_type` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `creator` int(11) UNSIGNED NULL DEFAULT 0,
  `modifier` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `reporter` int(11) NULL DEFAULT 0,
  `assignee` int(11) NULL DEFAULT 0,
  `summary` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `environment` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `priority` int(11) NULL DEFAULT 0,
  `resolve` int(11) NULL DEFAULT 0,
  `status` int(11) NULL DEFAULT 0,
  `created` int(11) NULL DEFAULT 0,
  `updated` int(11) NULL DEFAULT 0,
  `start_date` date NULL DEFAULT NULL,
  `due_date` date NULL DEFAULT NULL,
  `resolve_date` datetime(0) NULL DEFAULT NULL,
  `workflow_id` int(11) NULL DEFAULT 0,
  `module` int(11) NULL DEFAULT 0,
  `milestone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT 0,
  `assistants` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父任务的id,非0表示子任务',
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `time` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `issue_assignee`(`assignee`) USING BTREE,
  INDEX `summary`(`summary`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for issue_resolve
-- ----------------------------
DROP TABLE IF EXISTS `issue_resolve`;
CREATE TABLE `issue_resolve`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sequence` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `font_awesome` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `_key`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10102 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_resolve
-- ----------------------------
INSERT INTO `issue_resolve` VALUES (1, 1, '已解决', 'fixed', '事项已经解决', NULL, '#1aaa55', 1);
INSERT INTO `issue_resolve` VALUES (2, 2, '未解决', 'not_fix', '事项不可抗拒原因无法解决', NULL, '#db3b21', 1);
INSERT INTO `issue_resolve` VALUES (3, 3, '事项重复', 'require_duplicate', '事项需要的描述需要有重现步骤', NULL, '#db3b21', 1);
INSERT INTO `issue_resolve` VALUES (4, 4, '信息不完整', 'not_complete', '事项信息描述不完整', NULL, '#db3b21', 1);
INSERT INTO `issue_resolve` VALUES (5, 5, '不能重现', 'not_reproduce', '事项不能重现', NULL, '#db3b21', 1);
INSERT INTO `issue_resolve` VALUES (10000, 6, '结束', 'done', '事项已经解决并关闭掉', NULL, '#1aaa55', 1);
INSERT INTO `issue_resolve` VALUES (10100, 8, '问题不存在', 'issue_not_exists', '事项不存在', NULL, 'rgba(0,0,0,0.85)', 1);
INSERT INTO `issue_resolve` VALUES (10101, 9, '延迟处理', 'delay', '事项将推迟处理', NULL, 'rgba(0,0,0,0.85)', 1);

-- ----------------------------
-- Table structure for issue_status
-- ----------------------------
DROP TABLE IF EXISTS `issue_status`;
CREATE TABLE `issue_status`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sequence` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `font_awesome` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0,
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Default Primary Success Info Warning Danger可选',
  `text_color` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'black' COMMENT '字体颜色',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10101 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_status
-- ----------------------------
INSERT INTO `issue_status` VALUES (1, 1, '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', 1, 'info', 'blue');
INSERT INTO `issue_status` VALUES (3, 3, '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', 1, 'primary', 'blue');
INSERT INTO `issue_status` VALUES (4, 4, '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', 1, 'warning', 'blue');
INSERT INTO `issue_status` VALUES (5, 5, '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', 1, 'success', 'green');
INSERT INTO `issue_status` VALUES (6, 6, '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', 1, 'success', 'green');
INSERT INTO `issue_status` VALUES (10001, 0, '完成', 'done', '表明一件事项已经解决且被实践验证过', '', 1, 'success', 'green');
INSERT INTO `issue_status` VALUES (10002, 9, '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', 1, 'info', 'black');
INSERT INTO `issue_status` VALUES (10100, 10, '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', 1, 'info', 'black');

-- ----------------------------
-- Table structure for issue_type
-- ----------------------------
DROP TABLE IF EXISTS `issue_type`;
CREATE TABLE `issue_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sequence` decimal(18, 0) NULL DEFAULT NULL,
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `catalog` enum('Custom','Kanban','Scrum','Standard') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Standard' COMMENT '类型',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `font_awesome` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `custom_icon_url` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0,
  `form_desc_tpl_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '创建事项时,描述字段对应的模板id',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `_key`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_type
-- ----------------------------
INSERT INTO `issue_type` VALUES (1, 1, 'Bug', 'bug', 'Standard', '测试过程、维护过程发现影响系统运行的缺陷', 'fa-bug', NULL, 1, 1);
INSERT INTO `issue_type` VALUES (2, 2, '新功能', 'new_feature', 'Standard', '对系统提出的新功能', 'fa-plus', NULL, 1, 2);
INSERT INTO `issue_type` VALUES (3, 3, '任务', 'task', 'Standard', '需要完成的任务', 'fa-tasks', NULL, 1, 0);
INSERT INTO `issue_type` VALUES (4, 4, '优化改进', 'improve', 'Standard', '对现有系统功能的改进', 'fa-arrow-circle-o-up', NULL, 1, 5);
INSERT INTO `issue_type` VALUES (5, 0, '子任务', 'child_task', 'Standard', '', 'fa-subscript', NULL, 1, 5);
INSERT INTO `issue_type` VALUES (6, 2, '用户故事', 'user_story', 'Scrum', '从用户的角度来描述用户渴望得到的功能。一个好的用户故事包括三个要素：1. 角色；2. 活动　3. 商业价值', 'fa-users', NULL, 1, 2);
INSERT INTO `issue_type` VALUES (7, 3, '技术任务', 'tech_task', 'Scrum', '技术性的任务,如架构设计,数据库选型', 'fa-cogs', NULL, 1, 2);
INSERT INTO `issue_type` VALUES (8, 5, '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', NULL, 1, 0);
INSERT INTO `issue_type` VALUES (12, NULL, '甘特图', 'gantt', 'Custom', '', 'fa-exchange', NULL, 0, 0);

-- ----------------------------
-- Table structure for issue_type_scheme
-- ----------------------------
DROP TABLE IF EXISTS `issue_type_scheme`;
CREATE TABLE `issue_type_scheme`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_default` tinyint(1) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '问题方案表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_type_scheme
-- ----------------------------
INSERT INTO `issue_type_scheme` VALUES (1, '默认事项方案', '系统默认的事项方案,但没有设定或事项错误时使用该方案', 1);
INSERT INTO `issue_type_scheme` VALUES (2, '敏捷开发事项方案', '敏捷开发适用的方案', 1);
INSERT INTO `issue_type_scheme` VALUES (5, '任务管理事项解决方案', '任务管理', 0);

-- ----------------------------
-- Table structure for issue_type_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `issue_type_scheme_data`;
CREATE TABLE `issue_type_scheme_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `type_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `scheme_id`(`scheme_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 478 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '问题方案字表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_type_scheme_data
-- ----------------------------
INSERT INTO `issue_type_scheme_data` VALUES (3, 3, 1);
INSERT INTO `issue_type_scheme_data` VALUES (17, 4, 10000);
INSERT INTO `issue_type_scheme_data` VALUES (446, 1, 1);
INSERT INTO `issue_type_scheme_data` VALUES (447, 1, 2);
INSERT INTO `issue_type_scheme_data` VALUES (448, 1, 3);
INSERT INTO `issue_type_scheme_data` VALUES (449, 1, 4);
INSERT INTO `issue_type_scheme_data` VALUES (450, 1, 5);
INSERT INTO `issue_type_scheme_data` VALUES (468, 5, 3);
INSERT INTO `issue_type_scheme_data` VALUES (469, 5, 4);
INSERT INTO `issue_type_scheme_data` VALUES (470, 5, 5);
INSERT INTO `issue_type_scheme_data` VALUES (471, 2, 1);
INSERT INTO `issue_type_scheme_data` VALUES (472, 2, 2);
INSERT INTO `issue_type_scheme_data` VALUES (473, 2, 3);
INSERT INTO `issue_type_scheme_data` VALUES (474, 2, 4);
INSERT INTO `issue_type_scheme_data` VALUES (475, 2, 6);
INSERT INTO `issue_type_scheme_data` VALUES (476, 2, 7);
INSERT INTO `issue_type_scheme_data` VALUES (477, 2, 8);

-- ----------------------------
-- Table structure for issue_ui
-- ----------------------------
DROP TABLE IF EXISTS `issue_ui`;
CREATE TABLE `issue_ui`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_type_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `ui_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `field_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `order_weight` int(10) UNSIGNED NULL DEFAULT NULL,
  `tab_id` int(11) UNSIGNED NULL DEFAULT 0,
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否必填项',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1530 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_ui
-- ----------------------------
INSERT INTO `issue_ui` VALUES (205, 8, 'create', 1, 3, 0, 1);
INSERT INTO `issue_ui` VALUES (206, 8, 'create', 2, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (207, 8, 'create', 3, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (208, 8, 'create', 4, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (209, 8, 'create', 5, 0, 2, 0);
INSERT INTO `issue_ui` VALUES (210, 8, 'create', 6, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (211, 8, 'create', 7, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (212, 8, 'create', 8, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (213, 8, 'create', 9, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (214, 8, 'create', 10, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (215, 8, 'create', 11, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (216, 8, 'create', 12, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (217, 8, 'create', 13, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (218, 8, 'create', 14, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (219, 8, 'create', 15, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (220, 8, 'create', 16, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (221, 8, 'edit', 1, 3, 0, 1);
INSERT INTO `issue_ui` VALUES (222, 8, 'edit', 2, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (223, 8, 'edit', 3, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (224, 8, 'edit', 4, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (225, 8, 'edit', 5, 0, 2, 0);
INSERT INTO `issue_ui` VALUES (226, 8, 'edit', 6, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (227, 8, 'edit', 7, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (228, 8, 'edit', 8, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (229, 8, 'edit', 9, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (230, 8, 'edit', 10, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (231, 8, 'edit', 11, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (232, 8, 'edit', 12, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (233, 8, 'edit', 13, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (234, 8, 'edit', 14, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (235, 8, 'edit', 15, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (236, 8, 'edit', 16, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (422, 4, 'create', 1, 14, 0, 1);
INSERT INTO `issue_ui` VALUES (423, 4, 'create', 6, 13, 0, 0);
INSERT INTO `issue_ui` VALUES (424, 4, 'create', 2, 12, 0, 0);
INSERT INTO `issue_ui` VALUES (425, 4, 'create', 3, 11, 0, 0);
INSERT INTO `issue_ui` VALUES (426, 4, 'create', 7, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (427, 4, 'create', 9, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (428, 4, 'create', 8, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (429, 4, 'create', 4, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (430, 4, 'create', 19, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (431, 4, 'create', 10, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (432, 4, 'create', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (433, 4, 'create', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (434, 4, 'create', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (435, 4, 'create', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (436, 4, 'create', 20, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (452, 5, 'create', 1, 14, 0, 1);
INSERT INTO `issue_ui` VALUES (453, 5, 'create', 6, 13, 0, 0);
INSERT INTO `issue_ui` VALUES (454, 5, 'create', 2, 12, 0, 0);
INSERT INTO `issue_ui` VALUES (455, 5, 'create', 7, 11, 0, 0);
INSERT INTO `issue_ui` VALUES (456, 5, 'create', 9, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (457, 5, 'create', 8, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (458, 5, 'create', 3, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (459, 5, 'create', 4, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (460, 5, 'create', 19, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (461, 5, 'create', 10, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (462, 5, 'create', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (463, 5, 'create', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (464, 5, 'create', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (465, 5, 'create', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (466, 5, 'create', 20, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (467, 5, 'edit', 1, 14, 0, 1);
INSERT INTO `issue_ui` VALUES (468, 5, 'edit', 6, 13, 0, 0);
INSERT INTO `issue_ui` VALUES (469, 5, 'edit', 2, 12, 0, 0);
INSERT INTO `issue_ui` VALUES (470, 5, 'edit', 7, 11, 0, 0);
INSERT INTO `issue_ui` VALUES (471, 5, 'edit', 9, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (472, 5, 'edit', 8, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (473, 5, 'edit', 3, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (474, 5, 'edit', 4, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (475, 5, 'edit', 19, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (476, 5, 'edit', 10, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (477, 5, 'edit', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (478, 5, 'edit', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (479, 5, 'edit', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (480, 5, 'edit', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (481, 5, 'edit', 20, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (587, 6, 'create', 1, 7, 0, 1);
INSERT INTO `issue_ui` VALUES (588, 6, 'create', 6, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (589, 6, 'create', 2, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (590, 6, 'create', 8, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (591, 6, 'create', 11, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (592, 6, 'create', 4, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (593, 6, 'create', 21, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (594, 6, 'create', 15, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (595, 6, 'create', 19, 6, 33, 0);
INSERT INTO `issue_ui` VALUES (596, 6, 'create', 10, 5, 33, 0);
INSERT INTO `issue_ui` VALUES (597, 6, 'create', 7, 4, 33, 0);
INSERT INTO `issue_ui` VALUES (598, 6, 'create', 20, 3, 33, 0);
INSERT INTO `issue_ui` VALUES (599, 6, 'create', 9, 2, 33, 0);
INSERT INTO `issue_ui` VALUES (600, 6, 'create', 13, 1, 33, 0);
INSERT INTO `issue_ui` VALUES (601, 6, 'create', 12, 0, 33, 0);
INSERT INTO `issue_ui` VALUES (602, 6, 'edit', 1, 7, 0, 1);
INSERT INTO `issue_ui` VALUES (603, 6, 'edit', 6, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (604, 6, 'edit', 2, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (605, 6, 'edit', 8, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (606, 6, 'edit', 4, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (607, 6, 'edit', 11, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (608, 6, 'edit', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (609, 6, 'edit', 21, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (610, 6, 'edit', 19, 6, 34, 0);
INSERT INTO `issue_ui` VALUES (611, 6, 'edit', 10, 5, 34, 0);
INSERT INTO `issue_ui` VALUES (612, 6, 'edit', 7, 4, 34, 0);
INSERT INTO `issue_ui` VALUES (613, 6, 'edit', 20, 3, 34, 0);
INSERT INTO `issue_ui` VALUES (614, 6, 'edit', 9, 2, 34, 0);
INSERT INTO `issue_ui` VALUES (615, 6, 'edit', 12, 1, 34, 0);
INSERT INTO `issue_ui` VALUES (616, 6, 'edit', 13, 0, 34, 0);
INSERT INTO `issue_ui` VALUES (646, 7, 'create', 1, 7, 0, 1);
INSERT INTO `issue_ui` VALUES (647, 7, 'create', 6, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (648, 7, 'create', 2, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (649, 7, 'create', 8, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (650, 7, 'create', 4, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (651, 7, 'create', 11, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (652, 7, 'create', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (653, 7, 'create', 21, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (654, 7, 'create', 19, 6, 37, 0);
INSERT INTO `issue_ui` VALUES (655, 7, 'create', 10, 5, 37, 0);
INSERT INTO `issue_ui` VALUES (656, 7, 'create', 7, 4, 37, 0);
INSERT INTO `issue_ui` VALUES (657, 7, 'create', 20, 3, 37, 0);
INSERT INTO `issue_ui` VALUES (658, 7, 'create', 9, 2, 37, 0);
INSERT INTO `issue_ui` VALUES (659, 7, 'create', 13, 1, 37, 0);
INSERT INTO `issue_ui` VALUES (660, 7, 'create', 12, 0, 37, 0);
INSERT INTO `issue_ui` VALUES (1060, 9, 'create', 1, 4, 0, 1);
INSERT INTO `issue_ui` VALUES (1061, 9, 'create', 19, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1062, 9, 'create', 3, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1063, 9, 'create', 6, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1064, 9, 'create', 4, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1080, 7, 'edit', 1, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1081, 7, 'edit', 6, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1082, 7, 'edit', 2, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1083, 7, 'edit', 8, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1084, 7, 'edit', 4, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1085, 7, 'edit', 11, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1086, 7, 'edit', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1087, 7, 'edit', 21, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1088, 7, 'edit', 19, 6, 63, 0);
INSERT INTO `issue_ui` VALUES (1089, 7, 'edit', 10, 5, 63, 0);
INSERT INTO `issue_ui` VALUES (1090, 7, 'edit', 7, 4, 63, 0);
INSERT INTO `issue_ui` VALUES (1091, 7, 'edit', 9, 3, 63, 0);
INSERT INTO `issue_ui` VALUES (1092, 7, 'edit', 20, 2, 63, 0);
INSERT INTO `issue_ui` VALUES (1093, 7, 'edit', 12, 1, 63, 0);
INSERT INTO `issue_ui` VALUES (1094, 7, 'edit', 13, 0, 63, 0);
INSERT INTO `issue_ui` VALUES (1095, 4, 'edit', 1, 11, 0, 0);
INSERT INTO `issue_ui` VALUES (1096, 4, 'edit', 6, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (1097, 4, 'edit', 2, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (1098, 4, 'edit', 7, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (1099, 4, 'edit', 4, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1100, 4, 'edit', 19, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1101, 4, 'edit', 11, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1102, 4, 'edit', 12, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1103, 4, 'edit', 13, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1104, 4, 'edit', 15, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1105, 4, 'edit', 20, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1106, 4, 'edit', 21, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1107, 4, 'edit', 8, 3, 64, 0);
INSERT INTO `issue_ui` VALUES (1108, 4, 'edit', 9, 2, 64, 0);
INSERT INTO `issue_ui` VALUES (1109, 4, 'edit', 3, 1, 64, 0);
INSERT INTO `issue_ui` VALUES (1110, 4, 'edit', 10, 0, 64, 0);
INSERT INTO `issue_ui` VALUES (1414, 12, 'edit', 1, 8, 0, 1);
INSERT INTO `issue_ui` VALUES (1415, 12, 'edit', 4, 7, 0, 1);
INSERT INTO `issue_ui` VALUES (1416, 12, 'edit', 15, 6, 0, 1);
INSERT INTO `issue_ui` VALUES (1417, 12, 'edit', 12, 5, 0, 1);
INSERT INTO `issue_ui` VALUES (1418, 12, 'edit', 13, 4, 0, 1);
INSERT INTO `issue_ui` VALUES (1419, 12, 'edit', 27, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1420, 12, 'edit', 28, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1421, 12, 'edit', 29, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1422, 12, 'edit', 6, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1423, 12, 'create', 1, 8, 0, 1);
INSERT INTO `issue_ui` VALUES (1424, 12, 'create', 4, 7, 0, 1);
INSERT INTO `issue_ui` VALUES (1425, 12, 'create', 15, 6, 0, 1);
INSERT INTO `issue_ui` VALUES (1426, 12, 'create', 12, 5, 0, 1);
INSERT INTO `issue_ui` VALUES (1427, 12, 'create', 27, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1428, 12, 'create', 13, 3, 0, 1);
INSERT INTO `issue_ui` VALUES (1429, 12, 'create', 28, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1430, 12, 'create', 29, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1431, 12, 'create', 6, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1432, 2, 'create', 1, 10, 0, 1);
INSERT INTO `issue_ui` VALUES (1433, 2, 'create', 6, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (1434, 2, 'create', 19, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (1435, 2, 'create', 2, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1436, 2, 'create', 7, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1437, 2, 'create', 4, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1438, 2, 'create', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1439, 2, 'create', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1440, 2, 'create', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1441, 2, 'create', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1442, 2, 'create', 21, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1443, 2, 'create', 10, 4, 81, 0);
INSERT INTO `issue_ui` VALUES (1444, 2, 'create', 20, 3, 81, 0);
INSERT INTO `issue_ui` VALUES (1445, 2, 'create', 9, 2, 81, 0);
INSERT INTO `issue_ui` VALUES (1446, 2, 'create', 3, 1, 81, 0);
INSERT INTO `issue_ui` VALUES (1447, 2, 'create', 26, 0, 81, 0);
INSERT INTO `issue_ui` VALUES (1448, 2, 'edit', 1, 11, 0, 1);
INSERT INTO `issue_ui` VALUES (1449, 2, 'edit', 19, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (1450, 2, 'edit', 10, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (1451, 2, 'edit', 6, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (1452, 2, 'edit', 2, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1453, 2, 'edit', 7, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1454, 2, 'edit', 4, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1455, 2, 'edit', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1456, 2, 'edit', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1457, 2, 'edit', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1458, 2, 'edit', 15, 1, 0, 1);
INSERT INTO `issue_ui` VALUES (1459, 2, 'edit', 21, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1460, 2, 'edit', 20, 3, 82, 0);
INSERT INTO `issue_ui` VALUES (1461, 2, 'edit', 9, 2, 82, 0);
INSERT INTO `issue_ui` VALUES (1462, 2, 'edit', 3, 1, 82, 0);
INSERT INTO `issue_ui` VALUES (1463, 2, 'edit', 26, 0, 82, 0);
INSERT INTO `issue_ui` VALUES (1464, 3, 'create', 1, 12, 0, 1);
INSERT INTO `issue_ui` VALUES (1465, 3, 'create', 6, 11, 0, 0);
INSERT INTO `issue_ui` VALUES (1466, 3, 'create', 2, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (1467, 3, 'create', 7, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (1468, 3, 'create', 8, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (1469, 3, 'create', 3, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1470, 3, 'create', 4, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1471, 3, 'create', 19, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1472, 3, 'create', 10, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1473, 3, 'create', 11, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1474, 3, 'create', 12, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1475, 3, 'create', 13, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1476, 3, 'create', 20, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1477, 3, 'edit', 1, 14, 0, 1);
INSERT INTO `issue_ui` VALUES (1478, 3, 'edit', 6, 13, 0, 0);
INSERT INTO `issue_ui` VALUES (1479, 3, 'edit', 2, 12, 0, 0);
INSERT INTO `issue_ui` VALUES (1480, 3, 'edit', 7, 11, 0, 0);
INSERT INTO `issue_ui` VALUES (1481, 3, 'edit', 9, 10, 0, 0);
INSERT INTO `issue_ui` VALUES (1482, 3, 'edit', 8, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (1483, 3, 'edit', 3, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (1484, 3, 'edit', 4, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1485, 3, 'edit', 19, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1486, 3, 'edit', 10, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1487, 3, 'edit', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1488, 3, 'edit', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1489, 3, 'edit', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1490, 3, 'edit', 20, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1491, 3, 'edit', 26, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1492, 3, 'edit', 20, 2, 83, 0);
INSERT INTO `issue_ui` VALUES (1493, 3, 'edit', 9, 1, 83, 0);
INSERT INTO `issue_ui` VALUES (1494, 3, 'edit', 3, 0, 83, 0);
INSERT INTO `issue_ui` VALUES (1495, 1, 'create', 1, 9, 0, 1);
INSERT INTO `issue_ui` VALUES (1496, 1, 'create', 6, 8, 0, 0);
INSERT INTO `issue_ui` VALUES (1497, 1, 'create', 2, 7, 0, 1);
INSERT INTO `issue_ui` VALUES (1498, 1, 'create', 7, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1499, 1, 'create', 4, 5, 0, 1);
INSERT INTO `issue_ui` VALUES (1500, 1, 'create', 11, 4, 0, 0);
INSERT INTO `issue_ui` VALUES (1501, 1, 'create', 12, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1502, 1, 'create', 13, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1503, 1, 'create', 15, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1504, 1, 'create', 23, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1505, 1, 'create', 19, 7, 84, 0);
INSERT INTO `issue_ui` VALUES (1506, 1, 'create', 10, 6, 84, 0);
INSERT INTO `issue_ui` VALUES (1507, 1, 'create', 20, 5, 84, 0);
INSERT INTO `issue_ui` VALUES (1508, 1, 'create', 18, 4, 84, 0);
INSERT INTO `issue_ui` VALUES (1509, 1, 'create', 3, 3, 84, 0);
INSERT INTO `issue_ui` VALUES (1510, 1, 'create', 21, 2, 84, 0);
INSERT INTO `issue_ui` VALUES (1511, 1, 'create', 8, 1, 84, 0);
INSERT INTO `issue_ui` VALUES (1512, 1, 'create', 9, 0, 84, 0);
INSERT INTO `issue_ui` VALUES (1513, 1, 'edit', 1, 10, 0, 1);
INSERT INTO `issue_ui` VALUES (1514, 1, 'edit', 6, 9, 0, 0);
INSERT INTO `issue_ui` VALUES (1515, 1, 'edit', 2, 8, 0, 1);
INSERT INTO `issue_ui` VALUES (1516, 1, 'edit', 19, 7, 0, 0);
INSERT INTO `issue_ui` VALUES (1517, 1, 'edit', 10, 6, 0, 0);
INSERT INTO `issue_ui` VALUES (1518, 1, 'edit', 7, 5, 0, 0);
INSERT INTO `issue_ui` VALUES (1519, 1, 'edit', 4, 4, 0, 1);
INSERT INTO `issue_ui` VALUES (1520, 1, 'edit', 11, 3, 0, 0);
INSERT INTO `issue_ui` VALUES (1521, 1, 'edit', 12, 2, 0, 0);
INSERT INTO `issue_ui` VALUES (1522, 1, 'edit', 13, 1, 0, 0);
INSERT INTO `issue_ui` VALUES (1523, 1, 'edit', 15, 0, 0, 0);
INSERT INTO `issue_ui` VALUES (1524, 1, 'edit', 3, 5, 85, 0);
INSERT INTO `issue_ui` VALUES (1525, 1, 'edit', 18, 4, 85, 0);
INSERT INTO `issue_ui` VALUES (1526, 1, 'edit', 20, 3, 85, 0);
INSERT INTO `issue_ui` VALUES (1527, 1, 'edit', 21, 2, 85, 0);
INSERT INTO `issue_ui` VALUES (1528, 1, 'edit', 8, 1, 85, 0);
INSERT INTO `issue_ui` VALUES (1529, 1, 'edit', 9, 0, 85, 0);

-- ----------------------------
-- Table structure for issue_ui_tab
-- ----------------------------
DROP TABLE IF EXISTS `issue_ui_tab`;
CREATE TABLE `issue_ui_tab`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_type_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_weight` int(11) NULL DEFAULT NULL,
  `ui_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `issue_id`(`issue_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 86 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of issue_ui_tab
-- ----------------------------
INSERT INTO `issue_ui_tab` VALUES (7, 10, 'test-name-24019', 0, 'create');
INSERT INTO `issue_ui_tab` VALUES (8, 11, 'test-name-53500', 0, 'create');
INSERT INTO `issue_ui_tab` VALUES (33, 6, '更多', 0, 'create');
INSERT INTO `issue_ui_tab` VALUES (34, 6, '\n            \n            更多\n             \n            \n        \n             \n            \n        ', 0, 'edit');
INSERT INTO `issue_ui_tab` VALUES (37, 7, '更 多', 0, 'create');
INSERT INTO `issue_ui_tab` VALUES (63, 7, '\n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit');
INSERT INTO `issue_ui_tab` VALUES (64, 4, '\n            \n            \n            更多\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit');
INSERT INTO `issue_ui_tab` VALUES (81, 2, '更 多', 0, 'create');
INSERT INTO `issue_ui_tab` VALUES (82, 2, '\n            \n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             ', 0, 'edit');
INSERT INTO `issue_ui_tab` VALUES (83, 3, '\n            \n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit');
INSERT INTO `issue_ui_tab` VALUES (84, 1, '更 多', 0, 'create');
INSERT INTO `issue_ui_tab` VALUES (85, 1, '\n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            ', 0, 'edit');

-- ----------------------------
-- Table structure for log_base
-- ----------------------------
DROP TABLE IF EXISTS `log_base`;
CREATE TABLE `log_base`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属模块',
  `obj_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作记录所关联的对象id,如现货id 订单id',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作者id,0为系统操作',
  `user_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作者用户名',
  `real_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `page` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '页面',
  `pre_status` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `cur_status` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `action` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作动作',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '动作',
  `pre_data` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `cur_data` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作者ip地址 ',
  `time` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `obj_id`(`obj_id`) USING BTREE,
  INDEX `like_query`(`uid`, `action`, `remark`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 249 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '组合模糊查询索引' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_operating
-- ----------------------------
DROP TABLE IF EXISTS `log_operating`;
CREATE TABLE `log_operating`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '所属模块',
  `obj_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作记录所关联的对象id,如现货id 订单id',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作者id,0为系统操作',
  `user_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作者用户名',
  `real_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `page` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '页面',
  `pre_status` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `cur_status` tinyint(3) UNSIGNED NULL DEFAULT NULL,
  `action` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作动作',
  `remark` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '动作',
  `pre_data` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `cur_data` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '操作者ip地址 ',
  `time` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `obj_id`(`obj_id`) USING BTREE,
  INDEX `like_query`(`uid`, `action`, `remark`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 958 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '组合模糊查询索引' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of log_operating
-- ----------------------------
INSERT INTO `log_operating` VALUES (1, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '[]', '{\"name\":\"\\u793a\\u4f8b\\u9879\\u76ee\",\"org_id\":\"1\",\"key\":\"example\",\"lead\":\"1\",\"description\":\"Masterlab\\u7684\\u793a\\u4f8b\\u9879\\u76ee\",\"type\":10,\"category\":0,\"url\":\"\",\"create_time\":1579247230,\"create_uid\":\"1\",\"avatar\":\"project_image\\/20200117\\/20200117154554_20263.png\",\"detail\":\"\\u8be5\\u9879\\u76ee\\u5c55\\u793a\\u4e86\\uff0c\\u5982\\u4f55\\u5c06\\u654f\\u6377\\u5f00\\u53d1\\u548cMasterlab\\u7ed3\\u5408\\u5728\\u4e00\\u8d77.\\r\\n\",\"org_path\":\"default\"}', '127.0.0.1', 1579247230);

-- ----------------------------
-- Table structure for log_runtime_error
-- ----------------------------
DROP TABLE IF EXISTS `log_runtime_error`;
CREATE TABLE `log_runtime_error`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `md5` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `line` smallint(6) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `err` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `errstr` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `file_line_unique`(`md5`) USING BTREE,
  INDEX `date`(`date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for main_action
-- ----------------------------
DROP TABLE IF EXISTS `main_action`;
CREATE TABLE `main_action`  (
  `id` decimal(18, 0) NOT NULL,
  `issueid` decimal(18, 0) NULL DEFAULT NULL,
  `author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actiontype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `actionlevel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rolelevel` decimal(18, 0) NULL DEFAULT NULL,
  `actionbody` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `created` datetime(0) NULL DEFAULT NULL,
  `updateauthor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `updated` datetime(0) NULL DEFAULT NULL,
  `actionnum` decimal(18, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `action_author_created`(`author`, `created`) USING BTREE,
  INDEX `action_issue`(`issueid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for main_activity
-- ----------------------------
DROP TABLE IF EXISTS `main_activity`;
CREATE TABLE `main_activity`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `action` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '动作说明,如 关闭了，创建了，修复了',
  `type` enum('agile','user','issue','issue_comment','org','project') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'issue' COMMENT 'project,issue,user,agile,issue_comment',
  `obj_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date` date NULL DEFAULT NULL,
  `time` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE,
  INDEX `date`(`date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1829 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_activity
-- ----------------------------
INSERT INTO `main_activity` VALUES (1, 1, 1, '创建了项目', 'project', 1, '示例项目', '2020-01-17', 1579247230);

-- ----------------------------
-- Table structure for main_announcement
-- ----------------------------
DROP TABLE IF EXISTS `main_announcement`;
CREATE TABLE `main_announcement`  (
  `id` int(10) UNSIGNED NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '0为禁用,1为发布中',
  `flag` int(11) NULL DEFAULT 0 COMMENT '每次发布将自增该字段',
  `expire_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_announcement
-- ----------------------------
INSERT INTO `main_announcement` VALUES (1, 'test-content-829016', 0, 1, 0);

-- ----------------------------
-- Table structure for main_cache_key
-- ----------------------------
DROP TABLE IF EXISTS `main_cache_key`;
CREATE TABLE `main_cache_key`  (
  `key` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `module` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `datetime` datetime(0) NULL DEFAULT NULL,
  `expire` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  UNIQUE INDEX `module_key`(`key`, `module`) USING BTREE,
  INDEX `module`(`module`) USING BTREE,
  INDEX `expire`(`expire`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_cache_key
-- ----------------------------
INSERT INTO `main_cache_key` VALUES ('dict/default_role/getAll/0,*', 'dict/default_role', '2020-01-24 15:47:10', 1579852030);
INSERT INTO `main_cache_key` VALUES ('dict/default_role_relation/getAll/0,*', 'dict/default_role_relation', '2020-01-24 15:47:10', 1579852030);
INSERT INTO `main_cache_key` VALUES ('dict/type_scheme/getAll/1,*', 'dict/type_scheme', '2020-01-24 15:08:11', 1579849691);
INSERT INTO `main_cache_key` VALUES ('dict/workflow_scheme/getAll/1,*', 'dict/workflow_scheme', '2020-01-24 15:08:22', 1579849702);
INSERT INTO `main_cache_key` VALUES ('setting/getSettingByKey/max_project_key', 'setting', '2020-01-24 15:11:18', 1579849878);
INSERT INTO `main_cache_key` VALUES ('setting/getSettingByKey/max_project_name', 'setting', '2020-01-24 15:11:18', 1579849878);

-- ----------------------------
-- Table structure for main_eventtype
-- ----------------------------
DROP TABLE IF EXISTS `main_eventtype`;
CREATE TABLE `main_eventtype`  (
  `id` decimal(18, 0) NOT NULL,
  `template_id` decimal(18, 0) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `event_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_eventtype
-- ----------------------------
INSERT INTO `main_eventtype` VALUES (1, NULL, 'Issue Created', 'This is the \'issue created\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (2, NULL, 'Issue Updated', 'This is the \'issue updated\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (3, NULL, 'Issue Assigned', 'This is the \'issue assigned\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (4, NULL, 'Issue Resolved', 'This is the \'issue resolved\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (5, NULL, 'Issue Closed', 'This is the \'issue closed\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (6, NULL, 'Issue Commented', 'This is the \'issue commented\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (7, NULL, 'Issue Reopened', 'This is the \'issue reopened\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (8, NULL, 'Issue Deleted', 'This is the \'issue deleted\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (9, NULL, 'Issue Moved', 'This is the \'issue moved\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (10, NULL, 'Work Logged On Issue', 'This is the \'work logged on issue\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (11, NULL, 'Work Started On Issue', 'This is the \'work started on issue\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (12, NULL, 'Work Stopped On Issue', 'This is the \'work stopped on issue\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (13, NULL, 'Generic Event', 'This is the \'generic event\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (14, NULL, 'Issue Comment Edited', 'This is the \'issue comment edited\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (15, NULL, 'Issue Worklog Updated', 'This is the \'issue worklog updated\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (16, NULL, 'Issue Worklog Deleted', 'This is the \'issue worklog deleted\' event.', 'jira.system.event.type');
INSERT INTO `main_eventtype` VALUES (17, NULL, 'Issue Comment Deleted', 'This is the \'issue comment deleted\' event.', 'jira.system.event.type');

-- ----------------------------
-- Table structure for main_group
-- ----------------------------
DROP TABLE IF EXISTS `main_group`;
CREATE TABLE `main_group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `active` int(11) NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  `updated_date` datetime(0) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `group_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `directory_id` decimal(18, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_group
-- ----------------------------
INSERT INTO `main_group` VALUES (1, 'administrators', 1, NULL, NULL, NULL, '1', NULL);
INSERT INTO `main_group` VALUES (2, 'developers', 1, NULL, NULL, NULL, '1', NULL);
INSERT INTO `main_group` VALUES (3, 'users', 1, NULL, NULL, NULL, '1', NULL);
INSERT INTO `main_group` VALUES (4, 'qas', 1, NULL, NULL, NULL, '1', NULL);
INSERT INTO `main_group` VALUES (5, 'ui-designers', 1, NULL, NULL, NULL, '1', NULL);

-- ----------------------------
-- Table structure for main_mail_queue
-- ----------------------------
DROP TABLE IF EXISTS `main_mail_queue`;
CREATE TABLE `main_mail_queue`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seq` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(11) UNSIGNED NULL DEFAULT NULL,
  `error` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `seq`(`seq`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 474 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for main_notify_scheme
-- ----------------------------
DROP TABLE IF EXISTS `main_notify_scheme`;
CREATE TABLE `main_notify_scheme`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_notify_scheme
-- ----------------------------
INSERT INTO `main_notify_scheme` VALUES (1, '默认通知方案', 1);

-- ----------------------------
-- Table structure for main_notify_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `main_notify_scheme_data`;
CREATE TABLE `main_notify_scheme_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_notify_scheme_data
-- ----------------------------
INSERT INTO `main_notify_scheme_data` VALUES (1, 1, '事项创建', 'issue@create', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (2, 1, '事项更新', 'issue@update', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (3, 1, '事项分配', 'issue@assign', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (4, 1, '事项已解决', 'issue@resolve@complete', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (5, 1, '事项已关闭', 'issue@close', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (6, 1, '事项评论', 'issue@comment@create', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (7, 1, '删除评论', 'issue@comment@remove', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (8, 1, '开始解决事项', 'issue@resolve@start', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (9, 1, '停止解决事项', 'issue@resolve@stop', '[\"assigee\",\"reporter\",\"follow\"]');
INSERT INTO `main_notify_scheme_data` VALUES (10, 1, '新增迭代', 'sprint@create', '[\"project\"]');
INSERT INTO `main_notify_scheme_data` VALUES (11, 1, '设置迭代进行时', 'sprint@start', '[\"project\"]');
INSERT INTO `main_notify_scheme_data` VALUES (12, 1, '删除迭代', 'sprint@remove', '[\"project\"]');

-- ----------------------------
-- Table structure for main_org
-- ----------------------------
DROP TABLE IF EXISTS `main_org`;
CREATE TABLE `main_org`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `create_uid` int(11) NOT NULL DEFAULT 0,
  `created` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `updated` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `scope` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1 private, 2 internal , 3 public',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `path`(`path`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_org
-- ----------------------------
INSERT INTO `main_org` VALUES (1, 'default', 'Default', 'Default organization', 'org/default.jpg', 0, 0, 1535263464, 3);

-- ----------------------------
-- Table structure for main_setting
-- ----------------------------
DROP TABLE IF EXISTS `main_setting`;
CREATE TABLE `main_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键字',
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `module` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '所属模块,basic,advance,ui,datetime,languge,attachment可选',
  `order_weight` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重',
  `_value` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `default_value` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '默认值',
  `format` enum('string','int','float','json') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'string' COMMENT '数据类型',
  `form_input_type` enum('datetime','date','textarea','select','checkbox','radio','img','color','file','int','number','text') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'text' COMMENT '表单项类型',
  `form_optional_value` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '待选的值定义,为json格式',
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `_key`(`_key`) USING BTREE,
  INDEX `module`(`module`) USING BTREE,
  INDEX `module_2`(`module`, `order_weight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_setting
-- ----------------------------
INSERT INTO `main_setting` VALUES (1, 'title', '网站的页面标题', 'basic', 0, '大家好', 'MasterLab', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (2, 'open_status', '启用状态', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (3, 'max_login_error', '最大尝试验证登录次数', 'basic', 0, '4', '4', 'int', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (4, 'login_require_captcha', '登录时需要验证码', 'basic', 0, '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (5, 'reg_require_captcha', '注册时需要验证码', 'basic', 0, '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (6, 'sender_format', '邮件发件人显示格式', 'basic', 0, '${fullname} (Masterlab)', '${fullname} (Hornet)', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (7, 'description', '说明', 'basic', 0, '', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (8, 'date_timezone', '默认用户时区', 'basic', 0, 'Asia/Shanghai', 'Asia/Shanghai', 'string', 'text', '[\"Asia/Shanghai\":\"\"]', '');
INSERT INTO `main_setting` VALUES (11, 'allow_share_public', '允许用户分享过滤器或面部', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (12, 'max_project_name', '项目名称最大长度', 'basic', 0, '80', '80', 'int', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (13, 'max_project_key', '项目键值最大长度', 'basic', 0, '20', '20', 'int', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (15, 'email_public', '邮件地址可见性', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (20, 'allow_gravatars', '允许使用Gravatars用户头像', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (21, 'gravatar_server', 'Gravatar服务器', 'basic', 0, '', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (24, 'send_mail_format', '默认发送个邮件的格式', 'user_default', 0, 'html', 'text', 'string', 'radio', '{\"text\":\"text\",\"html\":\"html\"}', '');
INSERT INTO `main_setting` VALUES (25, 'issue_page_size', '问题导航每页显示的问题数量', 'user_default', 0, '100', '100', 'int', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (39, 'time_format', '时间格式', 'datetime', 0, 'H:i:s', 'HH:mm:ss', 'string', 'text', NULL, '例如 11:55:47');
INSERT INTO `main_setting` VALUES (40, 'week_format', '星期格式', 'datetime', 0, 'l H:i:s', 'EEEE HH:mm:ss', 'string', 'text', NULL, '例如 Wednesday 11:55:47');
INSERT INTO `main_setting` VALUES (41, 'full_datetime_format', '完整日期/时间格式', 'datetime', 0, 'Y-m-d H:i:s', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', NULL, '例如 2007-05-23  11:55:47');
INSERT INTO `main_setting` VALUES (42, 'datetime_format', '日期格式(年月日)', 'datetime', 0, 'Y-m-d', 'yyyy-MM-dd', 'string', 'text', NULL, '例如 2007-05-23');
INSERT INTO `main_setting` VALUES (43, 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天');
INSERT INTO `main_setting` VALUES (45, 'attachment_dir', '附件路径', 'attachment', 0, '{{PUBLIC_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下');
INSERT INTO `main_setting` VALUES (46, 'attachment_size', '附件大小(单位M)', 'attachment', 0, '128.0', '10.0', 'float', 'text', NULL, '超过大小,无法上传,修改该值后同时还要修改 php.ini 的 post_max_size 和 upload_max_filesize');
INSERT INTO `main_setting` VALUES (47, 'enbale_thum', '启用缩略图', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图');
INSERT INTO `main_setting` VALUES (48, 'enable_zip', '启用ZIP支持', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载');
INSERT INTO `main_setting` VALUES (49, 'password_strategy', '密码策略', 'password_strategy', 0, '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', '');
INSERT INTO `main_setting` VALUES (50, 'send_mailer', '发信人', 'mail', 0, 'send_mailer@xxx.com', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (51, 'mail_prefix', '前缀', 'mail', 0, 'Masterlab', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (52, 'mail_host', '主机', 'mail', 0, 'smtpdm.aliyun.com', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (53, 'mail_port', 'SMTP端口', 'mail', 0, '465', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (54, 'mail_account', '账号', 'mail', 0, 'send_mailer@xxx.com', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (55, 'mail_password', '密码', 'mail', 0, 'xxxx', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (56, 'mail_timeout', '发送超时', 'mail', 0, '20', '', 'int', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (57, 'page_layout', '页面布局', 'user_default', 0, 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', '');
INSERT INTO `main_setting` VALUES (58, 'project_view', '项目首页', 'user_default', 0, 'sprints', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', '');
INSERT INTO `main_setting` VALUES (59, 'company', '公司名称', 'basic', 0, 'name', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (60, 'company_logo', '公司logo', 'basic', 0, 'logo', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (61, 'company_linkman', '联系人', 'basic', 0, '18002516775', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (62, 'company_phone', '联系电话', 'basic', 0, '135255256541', '', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (63, 'enable_async_mail', '是否使用异步方式发送邮件', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (64, 'enable_mail', '是否开启邮件推送', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` VALUES (70, 'socket_server_host', 'MasterlabSocket服务器地址', 'mail', 0, '127.0.0.1', '127.0.0.1', 'string', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (71, 'socket_server_port', 'MasterlabSocket服务器端口', 'mail', 0, '9002', '9002', 'int', 'text', NULL, '');
INSERT INTO `main_setting` VALUES (72, 'allow_user_reg', '允许用户注册', 'basic', 0, '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户');

-- ----------------------------
-- Table structure for main_timeline
-- ----------------------------
DROP TABLE IF EXISTS `main_timeline`;
CREATE TABLE `main_timeline`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `type` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `origin_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `issue_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `action` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `action_icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content_html` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for main_widget
-- ----------------------------
DROP TABLE IF EXISTS `main_widget`;
CREATE TABLE `main_widget`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '工具名称',
  `_key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('list','chart_line','chart_pie','chart_bar','text') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '工具类型',
  `status` tinyint(2) NULL DEFAULT 1 COMMENT '状态（1可用，0不可用）',
  `is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `required_param` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否需要参数才能获取数据',
  `description` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '描述',
  `parameter` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}' COMMENT '支持的参数说明',
  `order_weight` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `_key`(`_key`) USING BTREE,
  INDEX `order_weight`(`order_weight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of main_widget
-- ----------------------------
INSERT INTO `main_widget` VALUES (1, '我参与的项目', 'my_projects', 'fetchUserHaveJoinProjects', '通用', 'my_projects.png', 'list', 1, 1, 0, '', '[]', 0);
INSERT INTO `main_widget` VALUES (2, '分配给我的事项', 'assignee_my', 'fetchAssigneeIssues', '通用', 'assignee_my.png', 'list', 1, 1, 0, '', '[]', 0);
INSERT INTO `main_widget` VALUES (3, '活动日志', 'activity', 'fetchActivity', '通用', 'activity.png', 'list', 1, 1, 0, '', '[]', 0);
INSERT INTO `main_widget` VALUES (4, '便捷导航', 'nav', 'fetchNav', '通用', 'nav.png', 'list', 1, 1, 0, '', '[]', 0);
INSERT INTO `main_widget` VALUES (5, '组织', 'org', 'fetchOrgs', '通用', 'org.png', 'list', 1, 1, 0, '', '[]', 0);
INSERT INTO `main_widget` VALUES (6, '项目-汇总', 'project_stat', 'fetchProjectStat', '项目', 'project_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (7, '项目-解决与未解决对比图', 'project_abs', 'fetchProjectAbs', '项目', 'abs.png', 'chart_bar', 1, 0, 1, '', '\r\n[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"时间\",\"field\":\"by_time\",\"type\":\"select\",\"value\":[{\"title\":\"天\",\"value\":\"date\"},{\"title\":\"周\",\"value\":\"week\"},{\"title\":\"月\",\"value\":\"month\"}]},{\"name\":\"几日之内\",\"field\":\"within_date\",\"type\":\"text\",\"value\":\"\"}]', 0);
INSERT INTO `main_widget` VALUES (8, '项目-优先级统计', 'project_priority_stat', 'fetchProjectPriorityStat', '项目', 'priority_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]\r\n', 0);
INSERT INTO `main_widget` VALUES (9, '项目-状态统计', 'project_status_stat', 'fetchProjectStatusStat', '项目', 'status_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (10, '项目-开发者统计', 'project_developer_stat', 'fetchProjectDeveloperStat', '项目', 'developer_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', 0);
INSERT INTO `main_widget` VALUES (11, '项目-事项统计', 'project_issue_type_stat', 'fetchProjectIssueTypeStat', '项目', 'issue_type_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (12, '项目-饼状图', 'project_pie', 'fetchProjectPie', '项目', 'chart_pie.png', 'chart_pie', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]},{\"name\":\"开始时间\",\"field\":\"start_date\",\"type\":\"date\",\"value\":\"\"},{\"name\":\"结束时间\",\"field\":\"end_date\",\"type\":\"date\",\"value\":\"\"}]', 0);
INSERT INTO `main_widget` VALUES (13, '迭代-汇总', 'sprint_stat', 'fetchSprintStat', '迭代', 'sprint_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (14, '迭代-倒计时', 'sprint_countdown', 'fetchSprintCountdown', '项目', 'countdown.png', 'text', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (15, '迭代-燃尽图', 'sprint_burndown', 'fetchSprintBurndown', '迭代', 'burndown.png', 'text', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (16, '迭代-速率图', 'sprint_speed', 'fetchSprintSpeedRate', '迭代', 'sprint_speed.png', 'text', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (17, '迭代-饼状图', 'sprint_pie', 'fetchSprintPie', '迭代', 'chart_pie.png', 'chart_pie', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]}]', 0);
INSERT INTO `main_widget` VALUES (18, '迭代-解决与未解决对比图', 'sprint_abs', 'fetchSprintAbs', '迭代', 'abs.png', 'chart_bar', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (19, '迭代-优先级统计', 'sprint_priority_stat', 'fetchSprintPriorityStat', '迭代', 'priority_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', 0);
INSERT INTO `main_widget` VALUES (20, '迭代-状态统计', 'sprint_status_stat', 'fetchSprintStatusStat', '迭代', 'status_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (21, '迭代-开发者统计', 'sprint_developer_stat', 'fetchSprintDeveloperStat', '迭代', 'developer_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"迭代\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', 0);
INSERT INTO `main_widget` VALUES (22, '迭代-事项统计', 'sprint_issue_type_stat', 'fetchSprintIssueTypeStat', '迭代', 'issue_type_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);
INSERT INTO `main_widget` VALUES (23, '分配给我未解决的事项', 'unresolve_assignee_my', 'fetchUnResolveAssigneeIssues', '通用', 'assignee_my.png', 'list', 1, 1, 0, '', '[]', 0);
INSERT INTO `main_widget` VALUES (24, '我关注的事项', 'my_follow', 'fetchFollowIssues', '通用', 'my_follow.png', 'list', 1, 0, 0, '', '[]', 0);

-- ----------------------------
-- Table structure for mind_issue_attribute
-- ----------------------------
DROP TABLE IF EXISTS `mind_issue_attribute`;
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
  `font_size` tinyint(2) NOT NULL DEFAULT 1,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id_2`(`project_id`, `issue_id`, `source`, `group_by`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 131 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mind_issue_attribute
-- ----------------------------
INSERT INTO `mind_issue_attribute` VALUES (110, 3, 234, 'all', 'module', '', '', '#EE3333', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (112, 3, 174, '5', 'module', '', '', '#EE3333', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (113, 3, 170, '5', 'module', '', '', '#EE3333', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (118, 3, 239, '44', 'module', '', '', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (119, 3, 754, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (122, 3, 218, '44', 'module', '', '', '#3740A7', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (126, 3, 186, '44', 'module', '', '', '', '', '', 1, 1, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (127, 3, 171, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (128, 3, 747, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (129, 3, 760, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_issue_attribute` VALUES (130, 3, 758, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');

-- ----------------------------
-- Table structure for mind_project_attribute
-- ----------------------------
DROP TABLE IF EXISTS `mind_project_attribute`;
CREATE TABLE `mind_project_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `layout` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shape` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_family` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT 1,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mind_project_attribute
-- ----------------------------
INSERT INTO `mind_project_attribute` VALUES (4, 3, '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', '');

-- ----------------------------
-- Table structure for mind_second_attribute
-- ----------------------------
DROP TABLE IF EXISTS `mind_second_attribute`;
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
  `font_size` tinyint(2) NOT NULL DEFAULT 1,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mind_unique`(`project_id`, `source`, `group_by`, `group_by_id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE,
  INDEX `source_group_by`(`project_id`, `source`, `group_by`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mind_second_attribute
-- ----------------------------
INSERT INTO `mind_second_attribute` VALUES (4, 3, '44', 'module', '11', 'tree-left', '', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_second_attribute` VALUES (6, 3, '44', 'module', 'module_10', '', '', '', '', '', 2, 0, 0, '', '', '');
INSERT INTO `mind_second_attribute` VALUES (7, 3, '44', 'module', 'module_9', '', '', '', '', '', 2, 0, 0, '', '', '');
INSERT INTO `mind_second_attribute` VALUES (18, 3, '44', 'module', '6', '', '', '', '', '', 1, 0, 0, '', '#000000', '');
INSERT INTO `mind_second_attribute` VALUES (23, 3, '44', 'module', '9', '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', '');
INSERT INTO `mind_second_attribute` VALUES (24, 3, '44', 'module', '10', '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', '');
INSERT INTO `mind_second_attribute` VALUES (26, 3, '44', 'module', '8', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');
INSERT INTO `mind_second_attribute` VALUES (29, 3, '44', 'module', '7', '', '', '', '', '', 1, 0, 0, '', '#000000', '');

-- ----------------------------
-- Table structure for mind_sprint_attribute
-- ----------------------------
DROP TABLE IF EXISTS `mind_sprint_attribute`;
CREATE TABLE `mind_sprint_attribute`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `layout` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shape` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_family` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT 1,
  `font_bold` tinyint(1) NOT NULL DEFAULT 0,
  `font_italic` tinyint(1) NOT NULL DEFAULT 0,
  `bg_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `side` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sprint_id`(`sprint_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mind_sprint_attribute
-- ----------------------------
INSERT INTO `mind_sprint_attribute` VALUES (24, 44, '', '', '', '', '', 1, 0, 0, '', '#2196F3BF', '');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `permission_key_idx`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10907 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (10004, 0, '管理项目', '可以对项目进行设置', 'ADMINISTER_PROJECTS');
INSERT INTO `permission` VALUES (10005, 0, '访问事项列表(已废弃)', '', 'BROWSE_ISSUES');
INSERT INTO `permission` VALUES (10006, 0, '创建事项', '', 'CREATE_ISSUES');
INSERT INTO `permission` VALUES (10007, 0, '评论', '', 'ADD_COMMENTS');
INSERT INTO `permission` VALUES (10008, 0, '上传和删除附件', '', 'CREATE_ATTACHMENTS');
INSERT INTO `permission` VALUES (10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES');
INSERT INTO `permission` VALUES (10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES');
INSERT INTO `permission` VALUES (10015, 0, '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES');
INSERT INTO `permission` VALUES (10016, 0, '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS');
INSERT INTO `permission` VALUES (10017, 0, '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE');
INSERT INTO `permission` VALUES (10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS');
INSERT INTO `permission` VALUES (10902, 0, '管理backlog', '', 'MANAGE_BACKLOG');
INSERT INTO `permission` VALUES (10903, 0, '管理sprint', '', 'MANAGE_SPRINT');
INSERT INTO `permission` VALUES (10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN');
INSERT INTO `permission` VALUES (10905, 0, '导入事项', '可以到导入excel数据到项目中', 'IMPORT_EXCEL');
INSERT INTO `permission` VALUES (10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL');

-- ----------------------------
-- Table structure for permission_default_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_default_role`;
CREATE TABLE `permission_default_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `project_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '如果为0表示系统初始化的角色，不为0表示某一项目特有的角色',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10007 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '项目角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_default_role
-- ----------------------------
INSERT INTO `permission_default_role` VALUES (10000, 'Users', '普通用户', 0);
INSERT INTO `permission_default_role` VALUES (10001, 'Developers', '开发者,如程序员，架构师', 0);
INSERT INTO `permission_default_role` VALUES (10002, 'Administrators', '项目管理员，如项目经理，技术经理', 0);
INSERT INTO `permission_default_role` VALUES (10003, 'QA', '测试工程师', 0);
INSERT INTO `permission_default_role` VALUES (10006, 'PO', '产品经理，产品负责人', 0);

-- ----------------------------
-- Table structure for permission_default_role_relation
-- ----------------------------
DROP TABLE IF EXISTS `permission_default_role_relation`;
CREATE TABLE `permission_default_role_relation`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `perm_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `default_role_id`(`role_id`) USING BTREE,
  INDEX `role_id-and-perm_id`(`role_id`, `perm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 79 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_default_role_relation
-- ----------------------------
INSERT INTO `permission_default_role_relation` VALUES (42, 10000, 10005);
INSERT INTO `permission_default_role_relation` VALUES (43, 10000, 10006);
INSERT INTO `permission_default_role_relation` VALUES (44, 10000, 10007);
INSERT INTO `permission_default_role_relation` VALUES (45, 10000, 10008);
INSERT INTO `permission_default_role_relation` VALUES (46, 10000, 10013);
INSERT INTO `permission_default_role_relation` VALUES (47, 10001, 10005);
INSERT INTO `permission_default_role_relation` VALUES (48, 10001, 10006);
INSERT INTO `permission_default_role_relation` VALUES (49, 10001, 10007);
INSERT INTO `permission_default_role_relation` VALUES (50, 10001, 10008);
INSERT INTO `permission_default_role_relation` VALUES (51, 10001, 10013);
INSERT INTO `permission_default_role_relation` VALUES (52, 10001, 10014);
INSERT INTO `permission_default_role_relation` VALUES (53, 10001, 10015);
INSERT INTO `permission_default_role_relation` VALUES (54, 10001, 10028);
INSERT INTO `permission_default_role_relation` VALUES (55, 10002, 10004);
INSERT INTO `permission_default_role_relation` VALUES (56, 10002, 10005);
INSERT INTO `permission_default_role_relation` VALUES (57, 10002, 10006);
INSERT INTO `permission_default_role_relation` VALUES (58, 10002, 10007);
INSERT INTO `permission_default_role_relation` VALUES (59, 10002, 10008);
INSERT INTO `permission_default_role_relation` VALUES (60, 10002, 10013);
INSERT INTO `permission_default_role_relation` VALUES (61, 10002, 10014);
INSERT INTO `permission_default_role_relation` VALUES (62, 10002, 10015);
INSERT INTO `permission_default_role_relation` VALUES (63, 10002, 10028);
INSERT INTO `permission_default_role_relation` VALUES (64, 10002, 10902);
INSERT INTO `permission_default_role_relation` VALUES (65, 10002, 10903);
INSERT INTO `permission_default_role_relation` VALUES (66, 10002, 10904);
INSERT INTO `permission_default_role_relation` VALUES (67, 10006, 10004);
INSERT INTO `permission_default_role_relation` VALUES (68, 10006, 10005);
INSERT INTO `permission_default_role_relation` VALUES (69, 10006, 10006);
INSERT INTO `permission_default_role_relation` VALUES (70, 10006, 10007);
INSERT INTO `permission_default_role_relation` VALUES (71, 10006, 10008);
INSERT INTO `permission_default_role_relation` VALUES (72, 10006, 10013);
INSERT INTO `permission_default_role_relation` VALUES (73, 10006, 10014);
INSERT INTO `permission_default_role_relation` VALUES (74, 10006, 10015);
INSERT INTO `permission_default_role_relation` VALUES (75, 10006, 10028);
INSERT INTO `permission_default_role_relation` VALUES (76, 10006, 10902);
INSERT INTO `permission_default_role_relation` VALUES (77, 10006, 10903);
INSERT INTO `permission_default_role_relation` VALUES (78, 10006, 10904);

-- ----------------------------
-- Table structure for permission_global
-- ----------------------------
DROP TABLE IF EXISTS `permission_global`;
CREATE TABLE `permission_global`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `permission_global_key_idx`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_global
-- ----------------------------
INSERT INTO `permission_global` VALUES (1, 0, '系统设置', '可以对整个系统进行基本，界面，安全，邮件设置，同时还可以查看操作日志', 'MANAGER_SYSTEM_SETTING');
INSERT INTO `permission_global` VALUES (2, 0, '管理用户', '', 'MANAGER_USER');
INSERT INTO `permission_global` VALUES (3, 0, '事项管理', '', 'MANAGER_ISSUE');
INSERT INTO `permission_global` VALUES (4, 0, '项目管理', '可以对全部项目进行管理，包括创建新项目。', 'MANAGER_PROJECT');
INSERT INTO `permission_global` VALUES (5, 0, '组织管理', '', 'MANAGER_ORG');

-- ----------------------------
-- Table structure for permission_global_group
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_group`;
CREATE TABLE `permission_global_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `perm_global_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `group_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `perm_global_id`(`perm_global_id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_global_group
-- ----------------------------
INSERT INTO `permission_global_group` VALUES (1, 10000, 1);

-- ----------------------------
-- Table structure for permission_global_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_role`;
CREATE TABLE `permission_global_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否是默认角色',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_global_role
-- ----------------------------
INSERT INTO `permission_global_role` VALUES (1, '超级管理员', NULL, 1);
INSERT INTO `permission_global_role` VALUES (2, '系统设置管理员', NULL, 0);
INSERT INTO `permission_global_role` VALUES (3, '项目管理员', NULL, 0);
INSERT INTO `permission_global_role` VALUES (4, '用户管理员', NULL, 0);
INSERT INTO `permission_global_role` VALUES (5, '事项设置管理员', NULL, 0);
INSERT INTO `permission_global_role` VALUES (6, '组织管理员', NULL, 0);

-- ----------------------------
-- Table structure for permission_global_role_relation
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_role_relation`;
CREATE TABLE `permission_global_role_relation`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `perm_global_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `role_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否系统自带',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`perm_global_id`, `role_id`) USING BTREE,
  INDEX `perm_global_id`(`perm_global_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户组拥有的全局权限' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_global_role_relation
-- ----------------------------
INSERT INTO `permission_global_role_relation` VALUES (2, 1, 1, 1);
INSERT INTO `permission_global_role_relation` VALUES (8, 2, 1, 1);
INSERT INTO `permission_global_role_relation` VALUES (9, 3, 1, 1);
INSERT INTO `permission_global_role_relation` VALUES (10, 4, 1, 1);
INSERT INTO `permission_global_role_relation` VALUES (11, 5, 1, 1);

-- ----------------------------
-- Table structure for permission_global_user_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_global_user_role`;
CREATE TABLE `permission_global_user_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NULL DEFAULT 0,
  `role_id` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`user_id`, `role_id`) USING BTREE,
  INDEX `uid`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5614 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_global_user_role
-- ----------------------------
INSERT INTO `permission_global_user_role` VALUES (5613, 1, 1);

-- ----------------------------
-- Table structure for project_category
-- ----------------------------
DROP TABLE IF EXISTS `project_category`;
CREATE TABLE `project_category`  (
  `id` int(18) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_project_category_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_flag
-- ----------------------------
DROP TABLE IF EXISTS `project_flag`;
CREATE TABLE `project_flag`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `flag` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `update_time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1543 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_gantt_setting
-- ----------------------------
DROP TABLE IF EXISTS `project_gantt_setting`;
CREATE TABLE `project_gantt_setting`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `source_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'project,active_sprint,module 可选',
  `source_from` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_gantt_setting
-- ----------------------------
INSERT INTO `project_gantt_setting` VALUES (1, 1, 'active_sprint', NULL);
INSERT INTO `project_gantt_setting` VALUES (2, 3, 'project', NULL);
INSERT INTO `project_gantt_setting` VALUES (3, 2, 'project', NULL);
INSERT INTO `project_gantt_setting` VALUES (4, 11, 'project', NULL);

-- ----------------------------
-- Table structure for project_issue_report
-- ----------------------------
DROP TABLE IF EXISTS `project_issue_report`;
CREATE TABLE `project_issue_report`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `month` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `done_count` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数',
  `no_done_count` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `done_count_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `no_done_count_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE,
  INDEX `projectIdAndDate`(`project_id`, `date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_issue_type_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `project_issue_type_scheme_data`;
CREATE TABLE `project_issue_type_scheme_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `issue_type_scheme_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`) USING BTREE,
  INDEX `issue_type_scheme_id`(`issue_type_scheme_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_issue_type_scheme_data
-- ----------------------------
INSERT INTO `project_issue_type_scheme_data` VALUES (1, 2, 1);

-- ----------------------------
-- Table structure for project_key
-- ----------------------------
DROP TABLE IF EXISTS `project_key`;
CREATE TABLE `project_key`  (
  `id` decimal(18, 0) NOT NULL,
  `project_id` decimal(18, 0) NULL DEFAULT NULL,
  `project_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_all_project_keys`(`project_key`) USING BTREE,
  INDEX `idx_all_project_ids`(`project_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_label
-- ----------------------------
DROP TABLE IF EXISTS `project_label`;
CREATE TABLE `project_label`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bg_color` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_list_count
-- ----------------------------
DROP TABLE IF EXISTS `project_list_count`;
CREATE TABLE `project_list_count`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_type_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `project_total` int(10) UNSIGNED NULL DEFAULT NULL,
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_main
-- ----------------------------
DROP TABLE IF EXISTS `project_main`;
CREATE TABLE `project_main`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL DEFAULT 1,
  `org_path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lead` int(11) UNSIGNED NULL DEFAULT 0,
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `key` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `pcounter` decimal(18, 0) NULL DEFAULT NULL,
  `default_assignee` int(11) UNSIGNED NULL DEFAULT 0,
  `assignee_type` int(11) NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `category` int(11) UNSIGNED NULL DEFAULT NULL,
  `type` tinyint(2) NULL DEFAULT 1,
  `type_child` tinyint(2) NULL DEFAULT 0,
  `permission_scheme_id` int(11) UNSIGNED NULL DEFAULT 0,
  `workflow_scheme_id` int(11) UNSIGNED NOT NULL,
  `create_uid` int(11) UNSIGNED NULL DEFAULT 0,
  `create_time` int(11) UNSIGNED NULL DEFAULT 0,
  `un_done_count` int(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '未完成事项数',
  `done_count` int(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已经完成事项数',
  `closed_count` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_project_key`(`key`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE,
  INDEX `uid`(`create_uid`) USING BTREE,
  FULLTEXT INDEX `fulltext_name_description`(`name`, `description`)
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_main
-- ----------------------------
INSERT INTO `project_main` VALUES (1, 1, 'default', '示例项目', '', 1, 'Masterlab的示例项目', 'example', NULL, 1, NULL, 'project/avatar/1.png', 0, 10, 0, 0, 0, 1, 1579247230, 0, 0, 0);

-- ----------------------------
-- Table structure for project_main_extra
-- ----------------------------
DROP TABLE IF EXISTS `project_main_extra`;
CREATE TABLE `project_main_extra`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(10) UNSIGNED NULL DEFAULT 0,
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of project_main_extra
-- ----------------------------
INSERT INTO `project_main_extra` VALUES (1, 1, '该项目展示了，如何将敏捷开发和Masterlab结合在一起.\r\n');

-- ----------------------------
-- Table structure for project_mind_setting
-- ----------------------------
DROP TABLE IF EXISTS `project_mind_setting`;
CREATE TABLE `project_mind_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `setting_key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_id`(`project_id`, `setting_key`) USING BTREE,
  INDEX `project_id_2`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_mind_setting
-- ----------------------------
INSERT INTO `project_mind_setting` VALUES (14, 3, 'default_source_id', '');
INSERT INTO `project_mind_setting` VALUES (15, 3, 'fold_count', '16');
INSERT INTO `project_mind_setting` VALUES (16, 3, 'default_source', 'sprint');
INSERT INTO `project_mind_setting` VALUES (17, 3, 'is_display_label', '1');

-- ----------------------------
-- Table structure for project_module
-- ----------------------------
DROP TABLE IF EXISTS `project_module`;
CREATE TABLE `project_module`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lead` int(11) UNSIGNED NULL DEFAULT NULL,
  `default_assignee` int(11) UNSIGNED NULL DEFAULT NULL,
  `ctime` int(10) UNSIGNED NULL DEFAULT 0,
  `order_weight` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 143 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_permission
-- ----------------------------
DROP TABLE IF EXISTS `project_permission`;
CREATE TABLE `project_permission`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) UNSIGNED NULL DEFAULT 0,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `project_permission_key_idx`(`_key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10907 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_permission
-- ----------------------------
INSERT INTO `project_permission` VALUES (10004, 0, '管理项目', '可以对项目进行设置', 'ADMINISTER_PROJECTS');
INSERT INTO `project_permission` VALUES (10005, 0, '访问事项列表(已废弃)', '', 'BROWSE_ISSUES');
INSERT INTO `project_permission` VALUES (10006, 0, '创建事项', '', 'CREATE_ISSUES');
INSERT INTO `project_permission` VALUES (10007, 0, '评论', '', 'ADD_COMMENTS');
INSERT INTO `project_permission` VALUES (10008, 0, '上传和删除附件', '', 'CREATE_ATTACHMENTS');
INSERT INTO `project_permission` VALUES (10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES');
INSERT INTO `project_permission` VALUES (10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES');
INSERT INTO `project_permission` VALUES (10015, 0, '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES');
INSERT INTO `project_permission` VALUES (10016, 0, '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS');
INSERT INTO `project_permission` VALUES (10017, 0, '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE');
INSERT INTO `project_permission` VALUES (10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS');
INSERT INTO `project_permission` VALUES (10902, 0, '管理backlog', '', 'MANAGE_BACKLOG');
INSERT INTO `project_permission` VALUES (10903, 0, '管理sprint', '', 'MANAGE_SPRINT');
INSERT INTO `project_permission` VALUES (10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN');
INSERT INTO `project_permission` VALUES (10905, 0, '导入事项', '可以到导入excel数据到项目中', 'IMPORT_EXCEL');
INSERT INTO `project_permission` VALUES (10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL');

-- ----------------------------
-- Table structure for project_role
-- ----------------------------
DROP TABLE IF EXISTS `project_role`;
CREATE TABLE `project_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否是默认角色',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `p[roject_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 772 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_role
-- ----------------------------
INSERT INTO `project_role` VALUES (1, 1, 'Users', '普通用户', 1);
INSERT INTO `project_role` VALUES (2, 1, 'Developers', '开发者,如程序员，架构师', 1);
INSERT INTO `project_role` VALUES (3, 1, 'Administrators', '项目管理员，如项目经理，技术经理', 1);
INSERT INTO `project_role` VALUES (4, 1, 'QA', '测试工程师', 1);
INSERT INTO `project_role` VALUES (5, 1, 'PO', '产品经理，产品负责人', 1);

-- ----------------------------
-- Table structure for project_role_relation
-- ----------------------------
DROP TABLE IF EXISTS `project_role_relation`;
CREATE TABLE `project_role_relation`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `role_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `perm_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_id`(`role_id`) USING BTREE,
  INDEX `role_id-and-perm_id`(`role_id`, `perm_id`) USING BTREE,
  INDEX `unique_data`(`project_id`, `role_id`, `perm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5649 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_role_relation
-- ----------------------------
INSERT INTO `project_role_relation` VALUES (1, 1, 1, 10005);
INSERT INTO `project_role_relation` VALUES (2, 1, 1, 10006);
INSERT INTO `project_role_relation` VALUES (3, 1, 1, 10007);
INSERT INTO `project_role_relation` VALUES (4, 1, 1, 10008);
INSERT INTO `project_role_relation` VALUES (5, 1, 1, 10013);
INSERT INTO `project_role_relation` VALUES (6, 1, 2, 10005);
INSERT INTO `project_role_relation` VALUES (7, 1, 2, 10006);
INSERT INTO `project_role_relation` VALUES (8, 1, 2, 10007);
INSERT INTO `project_role_relation` VALUES (9, 1, 2, 10008);
INSERT INTO `project_role_relation` VALUES (10, 1, 2, 10013);
INSERT INTO `project_role_relation` VALUES (11, 1, 2, 10014);
INSERT INTO `project_role_relation` VALUES (12, 1, 2, 10015);
INSERT INTO `project_role_relation` VALUES (13, 1, 2, 10028);
INSERT INTO `project_role_relation` VALUES (14, 1, 3, 10004);
INSERT INTO `project_role_relation` VALUES (15, 1, 3, 10005);
INSERT INTO `project_role_relation` VALUES (16, 1, 3, 10006);
INSERT INTO `project_role_relation` VALUES (17, 1, 3, 10007);
INSERT INTO `project_role_relation` VALUES (18, 1, 3, 10008);
INSERT INTO `project_role_relation` VALUES (19, 1, 3, 10013);
INSERT INTO `project_role_relation` VALUES (20, 1, 3, 10014);
INSERT INTO `project_role_relation` VALUES (21, 1, 3, 10015);
INSERT INTO `project_role_relation` VALUES (22, 1, 3, 10028);
INSERT INTO `project_role_relation` VALUES (23, 1, 3, 10902);
INSERT INTO `project_role_relation` VALUES (24, 1, 3, 10903);
INSERT INTO `project_role_relation` VALUES (25, 1, 3, 10904);
INSERT INTO `project_role_relation` VALUES (26, 1, 5, 10004);
INSERT INTO `project_role_relation` VALUES (27, 1, 5, 10005);
INSERT INTO `project_role_relation` VALUES (28, 1, 5, 10006);
INSERT INTO `project_role_relation` VALUES (29, 1, 5, 10007);
INSERT INTO `project_role_relation` VALUES (30, 1, 5, 10008);
INSERT INTO `project_role_relation` VALUES (31, 1, 5, 10013);
INSERT INTO `project_role_relation` VALUES (32, 1, 5, 10014);
INSERT INTO `project_role_relation` VALUES (33, 1, 5, 10015);
INSERT INTO `project_role_relation` VALUES (34, 1, 5, 10028);
INSERT INTO `project_role_relation` VALUES (35, 1, 5, 10902);
INSERT INTO `project_role_relation` VALUES (36, 1, 5, 10903);
INSERT INTO `project_role_relation` VALUES (37, 1, 5, 10904);

-- ----------------------------
-- Table structure for project_user_role
-- ----------------------------
DROP TABLE IF EXISTS `project_user_role`;
CREATE TABLE `project_user_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NULL DEFAULT 0,
  `project_id` int(11) UNSIGNED NULL DEFAULT 0,
  `role_id` int(11) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`user_id`, `project_id`, `role_id`) USING BTREE,
  INDEX `uid`(`user_id`) USING BTREE,
  INDEX `uid_project`(`user_id`, `project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5613 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project_user_role
-- ----------------------------
INSERT INTO `project_user_role` VALUES (1, 1, 1, 3);

-- ----------------------------
-- Table structure for project_version
-- ----------------------------
DROP TABLE IF EXISTS `project_version`;
CREATE TABLE `project_version`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sequence` decimal(18, 0) NULL DEFAULT NULL,
  `released` tinyint(10) UNSIGNED NULL DEFAULT 0 COMMENT '0未发布 1已发布',
  `archived` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `start_date` int(10) UNSIGNED NULL DEFAULT NULL,
  `release_date` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `project_name_unique`(`project_id`, `name`) USING BTREE,
  INDEX `idx_version_project`(`project_id`) USING BTREE,
  INDEX `idx_version_sequence`(`sequence`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_workflow_status
-- ----------------------------
DROP TABLE IF EXISTS `project_workflow_status`;
CREATE TABLE `project_workflow_status`  (
  `id` decimal(18, 0) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `parentname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_parent_name`(`parentname`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for project_workflows
-- ----------------------------
DROP TABLE IF EXISTS `project_workflows`;
CREATE TABLE `project_workflows`  (
  `id` decimal(18, 0) NOT NULL,
  `workflowname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `creatorname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descriptor` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `islocked` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_project_issue
-- ----------------------------
DROP TABLE IF EXISTS `report_project_issue`;
CREATE TABLE `report_project_issue`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `month` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `count_done` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `count_done_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `projectIdAndDate`(`project_id`, `date`) USING BTREE,
  INDEX `project_id`(`project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 394 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for report_sprint_issue
-- ----------------------------
DROP TABLE IF EXISTS `report_sprint_issue`;
CREATE TABLE `report_sprint_issue`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sprint_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `month` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `count_done` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `count_done_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '当天完成的事项数量',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `sprintIdAndDate`(`sprint_id`, `date`) USING BTREE,
  INDEX `sprint_id`(`sprint_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 372 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for service_config
-- ----------------------------
DROP TABLE IF EXISTS `service_config`;
CREATE TABLE `service_config`  (
  `id` decimal(18, 0) NOT NULL,
  `delaytime` decimal(18, 0) NULL DEFAULT NULL,
  `clazz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `servicename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `cron_expression` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user_application
-- ----------------------------
DROP TABLE IF EXISTS `user_application`;
CREATE TABLE `user_application`  (
  `id` decimal(18, 0) NOT NULL,
  `application_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lower_application_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_date` datetime(0) NULL DEFAULT NULL,
  `updated_date` datetime(0) NULL DEFAULT NULL,
  `active` decimal(9, 0) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `application_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `credential` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_application_name`(`lower_application_name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_application
-- ----------------------------
INSERT INTO `user_application` VALUES (1, 'crowd-embedded', 'crowd-embedded', '2013-02-28 11:57:51', '2013-02-28 11:57:51', 1, '', 'CROWD', 'X');

-- ----------------------------
-- Table structure for user_attributes
-- ----------------------------
DROP TABLE IF EXISTS `user_attributes`;
CREATE TABLE `user_attributes`  (
  `id` decimal(18, 0) NOT NULL,
  `user_id` decimal(18, 0) NULL DEFAULT NULL,
  `directory_id` decimal(18, 0) NULL DEFAULT NULL,
  `attribute_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `attribute_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lower_attribute_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uk_user_attr_name_lval`(`user_id`, `attribute_name`) USING BTREE,
  INDEX `idx_user_attr_dir_name_lval`(`directory_id`, `attribute_name`(240), `lower_attribute_value`(240)) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_email_active
-- ----------------------------
DROP TABLE IF EXISTS `user_email_active`;
CREATE TABLE `user_email_active`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `uid` int(11) UNSIGNED NOT NULL,
  `verify_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `email`(`email`, `verify_code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_email_find_password
-- ----------------------------
DROP TABLE IF EXISTS `user_email_find_password`;
CREATE TABLE `user_email_find_password`  (
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `verify_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`email`) USING BTREE,
  UNIQUE INDEX `email`(`email`, `verify_code`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_email_token
-- ----------------------------
DROP TABLE IF EXISTS `user_email_token`;
CREATE TABLE `user_email_token`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `expired` int(10) UNSIGNED NOT NULL COMMENT '有效期',
  `created_at` int(10) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1-有效，0-无效',
  `used_model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用于哪个模型或功能',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NULL DEFAULT NULL,
  `group_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES (1, 0, 1);
INSERT INTO `user_group` VALUES (2, 1, 1);

-- ----------------------------
-- Table structure for user_ip_login_times
-- ----------------------------
DROP TABLE IF EXISTS `user_ip_login_times`;
CREATE TABLE `user_ip_login_times`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `times` int(11) NOT NULL DEFAULT 0,
  `up_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ip`(`ip`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_issue_display_fields
-- ----------------------------
DROP TABLE IF EXISTS `user_issue_display_fields`;
CREATE TABLE `user_issue_display_fields`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `fields` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_fields`(`user_id`, `project_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_issue_display_fields
-- ----------------------------
INSERT INTO `user_issue_display_fields` VALUES (13, 1, 3, 'issue_num,issue_type,priority,module,sprint,summary,assignee,status,plan_date');
INSERT INTO `user_issue_display_fields` VALUES (16, 1, 0, 'issue_num,issue_type,priority,project_id,module,summary,assignee,status,resolve,plan_date');

-- ----------------------------
-- Table structure for user_login_log
-- ----------------------------
DROP TABLE IF EXISTS `user_login_log`;
CREATE TABLE `user_login_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `token` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `ip` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 676 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_main
-- ----------------------------
DROP TABLE IF EXISTS `user_main`;
CREATE TABLE `user_main`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `directory_id` int(11) NULL DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `openid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(2) NULL DEFAULT 1 COMMENT '0 审核中;1 正常; 2 禁用',
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sex` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '1男2女',
  `birthday` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` int(11) UNSIGNED NULL DEFAULT 0,
  `update_time` int(11) NULL DEFAULT 0,
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `source` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `ios_token` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `android_token` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `version` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `last_login_time` int(11) UNSIGNED NULL DEFAULT 0,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否系统自带的用户,不可删除',
  `login_counter` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '登录次数',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sign` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE INDEX `openid`(`openid`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12164 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_main
-- ----------------------------
INSERT INTO `user_main` VALUES (1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', 'master@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '2019-01-13', 0, 0, 'avatar/1.png?t=1562323397', '', NULL, NULL, NULL, NULL, 1579236329, 0, 0, '管理员', '~~~交付卓越产品!');
INSERT INTO `user_main` VALUES (12164, NULL, NULL, 'json', '87655dd189dc13a7eb36f62a3a8eed4c', 1, NULL, NULL, 'Json', 'json@masterlab.vip', '$2y$10$hW2HeFe4kUO/IDxGW5A68e7r.sERM6.VtP3VrYLXeyHVb0ZjXo2Sm', 0, NULL, 1579247721, 0, 'avatar/12164.png?t=1579247721', '', NULL, NULL, NULL, '', 0, 0, 0, 'Java开发工程师', NULL);
INSERT INTO `user_main` VALUES (12165, NULL, NULL, 'shelly', '74eb77b447ad46f0ba76dba8de3e8489', 1, NULL, NULL, 'Shelly', 'shelly@masterlab.vip', '$2y$10$RXindYr74f9I1GyaGtovE.KgD6pgcjE6Z9SZyqLO9UykzImG6n2kS', 0, NULL, 1579247769, 0, 'avatar/12165.png?t=1579247769', '', NULL, NULL, NULL, '', 0, 0, 0, '软件测试工程师', NULL);
INSERT INTO `user_main` VALUES (12166, NULL, NULL, 'alex', '22778739b6553330c4f9e8a29d0e1d5f', 1, NULL, NULL, 'Alex', 'Alex@masterlab.vip', '$2y$10$ENToGF7kfUrXm0i6DISJ6utmjq076tSCaVuEyeqQRdQocgUwxZKZ6', 0, NULL, 1579247886, 0, 'avatar/12166.png?t=1579247886', '', NULL, NULL, NULL, '', 0, 0, 0, '产品经理', NULL);
INSERT INTO `user_main` VALUES (12167, NULL, NULL, 'max', '9b0e7dc465b9398c2e270e6da415341c', 1, NULL, NULL, 'Max', 'Max@masterlab.vip', '$2y$10$qbv7OEhHuFQFmC4zJK50T.CDN7alvBaSf2FfqCXwSwcaC3FojM0GS', 0, NULL, 1579247926, 0, 'avatar/12167.png?t=1579247926', '', NULL, NULL, NULL, '', 0, 0, 0, '前端开发工程师', NULL);
INSERT INTO `user_main` VALUES (12168, NULL, NULL, 'sandy', '322436f4d5a63425e7973a5406b13057', 1, NULL, NULL, 'Sandy', 'sandy@masterlab.vip', '$2y$10$9Y0SadlCrjBKGJtniCG/OepxWnAkfdo4e9iUzXz/6hWWQjFfVzyGK', 0, NULL, 1579247959, 0, 'avatar/12168.png?t=1579247959', '', NULL, NULL, NULL, '', 0, 0, 0, 'UI设计师', NULL);

-- ----------------------------
-- Table structure for user_message
-- ----------------------------
DROP TABLE IF EXISTS `user_message`;
CREATE TABLE `user_message`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_uid` int(11) UNSIGNED NOT NULL,
  `sender_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `direction` smallint(4) UNSIGNED NOT NULL,
  `receiver_uid` int(11) UNSIGNED NOT NULL,
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` varchar(5000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `readed` tinyint(1) UNSIGNED NOT NULL,
  `type` tinyint(2) UNSIGNED NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_password
-- ----------------------------
DROP TABLE IF EXISTS `user_password`;
CREATE TABLE `user_password`  (
  `user_id` int(11) UNSIGNED NOT NULL,
  `hash` varchar(72) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'password_hash()值',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_password_strategy
-- ----------------------------
DROP TABLE IF EXISTS `user_password_strategy`;
CREATE TABLE `user_password_strategy`  (
  `id` int(1) UNSIGNED NOT NULL,
  `strategy` tinyint(1) UNSIGNED NULL DEFAULT NULL COMMENT '1允许所有密码;2不允许非常简单的密码;3要求强密码  关于安全密码策略',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_password_strategy
-- ----------------------------
INSERT INTO `user_password_strategy` VALUES (1, 2);

-- ----------------------------
-- Table structure for user_phone_find_password
-- ----------------------------
DROP TABLE IF EXISTS `user_phone_find_password`;
CREATE TABLE `user_phone_find_password`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `verify_code` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `time` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '找回密码表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_posted_flag
-- ----------------------------
DROP TABLE IF EXISTS `user_posted_flag`;
CREATE TABLE `user_posted_flag`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `_date` date NOT NULL,
  `ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`, `_date`, `ip`) USING BTREE,
  INDEX `user_id_2`(`user_id`, `_date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 551 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_posted_flag
-- ----------------------------
INSERT INTO `user_posted_flag` VALUES (1, 1, '2020-01-17', '127.0.0.1');

-- ----------------------------
-- Table structure for user_refresh_token
-- ----------------------------
DROP TABLE IF EXISTS `user_refresh_token`;
CREATE TABLE `user_refresh_token`  (
  `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `refresh_token` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `expire` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`uid`) USING BTREE,
  INDEX `refresh_token`(`refresh_token`(255)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户刷新的token表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_setting
-- ----------------------------
DROP TABLE IF EXISTS `user_setting`;
CREATE TABLE `user_setting`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `_key` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `_value` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id`, `_key`) USING BTREE,
  INDEX `uid`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 427 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_setting
-- ----------------------------
INSERT INTO `user_setting` VALUES (51, 1, 'scheme_style', 'left');
INSERT INTO `user_setting` VALUES (53, 1, 'project_view', 'issues');
INSERT INTO `user_setting` VALUES (54, 1, 'issue_view', 'list');
INSERT INTO `user_setting` VALUES (198, 1, 'initializedWidget', '1');
INSERT INTO `user_setting` VALUES (201, 1, 'initialized_widget', '1');
INSERT INTO `user_setting` VALUES (353, 1, 'page_layout', 'fixed');
INSERT INTO `user_setting` VALUES (452, 1, 'layout', 'aa');

-- ----------------------------
-- Table structure for user_token
-- ----------------------------
DROP TABLE IF EXISTS `user_token`;
CREATE TABLE `user_token`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'token',
  `token_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'token过期时间',
  `refresh_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '刷新token',
  `refresh_token_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '刷新token过期时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 205 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_widget
-- ----------------------------
DROP TABLE IF EXISTS `user_widget`;
CREATE TABLE `user_widget`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `widget_id` int(11) NOT NULL COMMENT 'main_widget主键id',
  `order_weight` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '工具顺序',
  `panel` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_saved_parameter` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否保存了过滤参数',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`, `widget_id`) USING BTREE,
  INDEX `order_weight`(`order_weight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1804 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_widget
-- ----------------------------
INSERT INTO `user_widget` VALUES (1, 0, 1, 1, 'first', '', 0);
INSERT INTO `user_widget` VALUES (2, 0, 23, 2, 'first', '', 0);
INSERT INTO `user_widget` VALUES (3, 0, 3, 3, 'first', '', 0);
INSERT INTO `user_widget` VALUES (4, 0, 4, 1, 'second', '', 0);
INSERT INTO `user_widget` VALUES (5, 0, 5, 2, 'second', '', 0);
INSERT INTO `user_widget` VALUES (1903, 1, 1, 1, 'first', '', 0);
INSERT INTO `user_widget` VALUES (1904, 1, 23, 2, 'first', '', 0);
INSERT INTO `user_widget` VALUES (1905, 1, 24, 3, 'first', '', 0);
INSERT INTO `user_widget` VALUES (1906, 1, 3, 1, 'second', '', 0);

-- ----------------------------
-- Table structure for workflow
-- ----------------------------
DROP TABLE IF EXISTS `workflow`;
CREATE TABLE `workflow`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `create_uid` int(11) UNSIGNED NULL DEFAULT NULL,
  `create_time` int(11) UNSIGNED NULL DEFAULT NULL,
  `update_uid` int(11) UNSIGNED NULL DEFAULT NULL,
  `update_time` int(11) UNSIGNED NULL DEFAULT NULL,
  `steps` tinyint(2) UNSIGNED NULL DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `is_system` tinyint(1) UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of workflow
-- ----------------------------
INSERT INTO `workflow` VALUES (1, '默认工作流', '', 1, 0, NULL, 1539675295, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);
INSERT INTO `workflow` VALUES (2, '软件开发工作流', '针对软件开发的过程状态流', 1, NULL, NULL, 1529647857, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);
INSERT INTO `workflow` VALUES (3, 'Task工作流', '', 1, NULL, NULL, 1539675552, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);

-- ----------------------------
-- Table structure for workflow_block
-- ----------------------------
DROP TABLE IF EXISTS `workflow_block`;
CREATE TABLE `workflow_block`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `status_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `blcok_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `position_x` smallint(4) UNSIGNED NULL DEFAULT NULL,
  `position_y` smallint(4) UNSIGNED NULL DEFAULT NULL,
  `inner_html` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `workflow_id`(`workflow_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for workflow_connector
-- ----------------------------
DROP TABLE IF EXISTS `workflow_connector`;
CREATE TABLE `workflow_connector`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `connector_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `source_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `target_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `workflow_id`(`workflow_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for workflow_scheme
-- ----------------------------
DROP TABLE IF EXISTS `workflow_scheme`;
CREATE TABLE `workflow_scheme`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10103 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of workflow_scheme
-- ----------------------------
INSERT INTO `workflow_scheme` VALUES (1, '默认工作流方案', '', 1);
INSERT INTO `workflow_scheme` VALUES (10100, '敏捷开发工作流方案', '敏捷开发适用', 1);
INSERT INTO `workflow_scheme` VALUES (10101, '普通的软件开发工作流方案', '', 1);
INSERT INTO `workflow_scheme` VALUES (10102, '流程管理工作流方案', '', 1);

-- ----------------------------
-- Table structure for workflow_scheme_data
-- ----------------------------
DROP TABLE IF EXISTS `workflow_scheme_data`;
CREATE TABLE `workflow_scheme_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `scheme_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `issue_type_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `workflow_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `workflow_scheme`(`scheme_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10326 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of workflow_scheme_data
-- ----------------------------
INSERT INTO `workflow_scheme_data` VALUES (10000, 1, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10105, 10100, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10200, 10200, 10105, 1);
INSERT INTO `workflow_scheme_data` VALUES (10201, 10200, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10202, 10201, 10105, 1);
INSERT INTO `workflow_scheme_data` VALUES (10203, 10201, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10300, 10300, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10307, 10307, 1, 1);
INSERT INTO `workflow_scheme_data` VALUES (10308, 10307, 2, 2);
INSERT INTO `workflow_scheme_data` VALUES (10311, 10101, 2, 1);
INSERT INTO `workflow_scheme_data` VALUES (10312, 10101, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10319, 10305, 1, 2);
INSERT INTO `workflow_scheme_data` VALUES (10320, 10305, 2, 2);
INSERT INTO `workflow_scheme_data` VALUES (10321, 10305, 4, 2);
INSERT INTO `workflow_scheme_data` VALUES (10322, 10305, 5, 2);
INSERT INTO `workflow_scheme_data` VALUES (10323, 10102, 2, 1);
INSERT INTO `workflow_scheme_data` VALUES (10324, 10102, 0, 1);
INSERT INTO `workflow_scheme_data` VALUES (10325, 10102, 10105, 1);

SET FOREIGN_KEY_CHECKS = 1;
