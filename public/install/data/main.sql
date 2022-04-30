-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-12-24 17:36:26
-- 服务器版本： 8.0.20
-- PHP 版本： 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `masterlab_dev`
--

-- --------------------------------------------------------

--
-- 表的结构 `agile_board`
--

CREATE TABLE `agile_board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `is_filter_backlog` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_filter_closed` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `weight` int(10) unsigned NOT NULL DEFAULT '0',
  `range_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '看板数据范围',
  `range_data` varchar(1024) NOT NULL COMMENT '范围数据',
  `is_system` tinyint(4) NOT NULL DEFAULT '0',
  `range_due_date` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '截至时间范围',
  `sprint_id` int(11) unsigned DEFAULT '0',
  `is_hide` tinyint(1) unsigned DEFAULT '0' COMMENT '是否隐藏',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `weight` (`weight`),
  KEY `is_system` (`is_system`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `agile_board`
--

INSERT INTO `agile_board` VALUES (2, '整个项目', 0, 'status', 0, 1, 99998, 'all', '', 1, NULL, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `agile_board_column`
--

CREATE TABLE `agile_board_column` (
                                      `id` int UNSIGNED NOT NULL,
                                      `name` varchar(128) NOT NULL,
                                      `board_id` int UNSIGNED NOT NULL,
                                      `data` varchar(1000) NOT NULL,
                                      `weight` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `agile_board_column`
--

INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES
(1, '准 备', 1, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 3),
(2, '进行中', 1, '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 2),
(3, '已完成', 1, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 1),
(4, '准备中', 2, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0),
(5, '进行中', 2, '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0),
(6, '已完成', 2, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0),
(63, '准备中', 19, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":null,\"label\":null,\"assignee\":null}', 3),
(64, '进行中', 19, '{\"status\":[\"in_progress\"],\"resolve\":null,\"label\":null,\"assignee\":null}', 2),
(65, '已解决', 19, '{\"status\":[\"closed\",\"done\"],\"resolve\":null,\"label\":null,\"assignee\":null}', 1);

-- --------------------------------------------------------

--
-- 表的结构 `agile_sprint`
--

CREATE TABLE `agile_sprint` (
                                `id` int UNSIGNED NOT NULL,
                                `project_id` int UNSIGNED NOT NULL,
                                `name` varchar(128) NOT NULL,
                                `description` varchar(256) DEFAULT NULL,
                                `active` tinyint UNSIGNED NOT NULL DEFAULT '0',
                                `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1为准备中，2为已完成，3为已归档',
                                `order_weight` int UNSIGNED NOT NULL DEFAULT '0',
                                `start_date` date DEFAULT NULL,
                                `end_date` date DEFAULT NULL,
                                `target` text NOT NULL COMMENT 'sprint目标内容',
                                `inspect` text NOT NULL COMMENT 'Sprint 评审会议内容',
                                `review` text NOT NULL COMMENT 'Sprint 回顾会议内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `agile_sprint_issue_report`
--

CREATE TABLE `agile_sprint_issue_report` (
                                             `id` int UNSIGNED NOT NULL,
                                             `sprint_id` int UNSIGNED NOT NULL,
                                             `date` date NOT NULL,
                                             `week` tinyint UNSIGNED DEFAULT NULL,
                                             `month` varchar(20) DEFAULT NULL,
                                             `done_count` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
                                             `no_done_count` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
                                             `done_count_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
                                             `no_done_count_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
                                             `today_done_points` int UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
                                             `today_done_number` int UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `field_custom_value`
--

CREATE TABLE `field_custom_value` (
                                      `id` int UNSIGNED NOT NULL,
                                      `issue_id` int UNSIGNED DEFAULT NULL,
                                      `project_id` int UNSIGNED DEFAULT NULL,
                                      `custom_field_id` int DEFAULT NULL,
                                      `parent_key` varchar(255) DEFAULT NULL,
                                      `string_value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
                                      `number_value` varchar(255) DEFAULT NULL,
                                      `text_value` longtext,
                                      `date_value` datetime DEFAULT NULL,
                                      `value_type` varchar(32) NOT NULL DEFAULT 'string'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `field_layout_default`
--

CREATE TABLE `field_layout_default` (
                                        `id` int UNSIGNED NOT NULL,
                                        `issue_type` int UNSIGNED DEFAULT NULL,
                                        `issue_ui_type` tinyint UNSIGNED DEFAULT '1',
                                        `field_id` int UNSIGNED DEFAULT '0',
                                        `verticalposition` decimal(18,0) DEFAULT NULL,
                                        `ishidden` varchar(60) DEFAULT NULL,
                                        `isrequired` varchar(60) DEFAULT NULL,
                                        `sequence` int UNSIGNED DEFAULT NULL,
                                        `tab` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `field_layout_default`
--

INSERT INTO `field_layout_default` (`id`, `issue_type`, `issue_ui_type`, `field_id`, `verticalposition`, `ishidden`, `isrequired`, `sequence`, `tab`) VALUES
(11192, NULL, NULL, 11192, NULL, 'false', 'true', NULL, NULL),
(11193, NULL, NULL, 11193, NULL, 'false', 'true', NULL, NULL),
(11194, NULL, NULL, 11194, NULL, 'false', 'false', NULL, NULL),
(11195, NULL, NULL, 11195, NULL, 'false', 'true', NULL, NULL),
(11196, NULL, NULL, 11196, NULL, 'false', 'false', NULL, NULL),
(11197, NULL, NULL, 11197, NULL, 'false', 'true', NULL, NULL),
(11198, NULL, NULL, 11198, NULL, 'false', 'true', NULL, NULL),
(11199, NULL, NULL, 11199, NULL, 'false', 'false', NULL, NULL),
(11200, NULL, NULL, 11200, NULL, 'false', 'false', NULL, NULL),
(11201, NULL, NULL, 11201, NULL, 'false', 'true', NULL, NULL),
(11202, NULL, NULL, 11202, NULL, 'false', 'false', NULL, NULL),
(11203, NULL, NULL, 11203, NULL, 'false', 'false', NULL, NULL),
(11204, NULL, NULL, 11204, NULL, 'false', 'false', NULL, NULL),
(11205, NULL, NULL, 11205, NULL, 'false', 'false', NULL, NULL),
(11206, NULL, NULL, 11206, NULL, 'false', 'false', NULL, NULL),
(11207, NULL, NULL, 11207, NULL, 'false', 'false', NULL, NULL),
(11208, NULL, NULL, 11208, NULL, 'false', 'false', NULL, NULL),
(11209, NULL, NULL, 11209, NULL, 'false', 'false', NULL, NULL),
(11210, NULL, NULL, 11210, NULL, 'false', 'false', NULL, NULL),
(11211, NULL, NULL, 11211, NULL, 'false', 'false', NULL, NULL),
(11212, NULL, NULL, 11212, NULL, 'false', 'false', NULL, NULL),
(11213, NULL, NULL, 11213, NULL, 'false', 'false', NULL, NULL),
(11214, NULL, NULL, 11214, NULL, 'false', 'false', NULL, NULL),
(11215, NULL, NULL, 11215, NULL, 'false', 'true', NULL, NULL),
(11216, NULL, NULL, 11216, NULL, 'false', 'false', NULL, NULL),
(11217, NULL, NULL, 11217, NULL, 'false', 'false', NULL, NULL),
(11218, NULL, NULL, 11218, NULL, 'false', 'false', NULL, NULL),
(11219, NULL, NULL, 11219, NULL, 'false', 'false', NULL, NULL),
(11220, NULL, NULL, 11220, NULL, 'false', 'false', NULL, NULL),
(11221, NULL, NULL, 11221, NULL, 'false', 'false', NULL, NULL),
(11222, NULL, NULL, 11222, NULL, 'false', 'false', NULL, NULL),
(11223, NULL, NULL, 11223, NULL, 'false', 'false', NULL, NULL),
(11224, NULL, NULL, 11224, NULL, 'false', 'false', NULL, NULL),
(11225, NULL, NULL, 11225, NULL, 'false', 'false', NULL, NULL),
(11226, NULL, NULL, 11226, NULL, 'false', 'false', NULL, NULL),
(11227, NULL, NULL, 11227, NULL, 'false', 'false', NULL, NULL),
(11228, NULL, NULL, 11228, NULL, 'false', 'false', NULL, NULL),
(11229, NULL, NULL, 11229, NULL, 'false', 'false', NULL, NULL),
(11230, NULL, NULL, 11230, NULL, 'false', 'false', NULL, NULL),
(11231, NULL, NULL, 11231, NULL, 'false', 'false', NULL, NULL),
(11232, NULL, NULL, 11232, NULL, 'false', 'false', NULL, NULL),
(11233, NULL, NULL, 11233, NULL, 'false', 'false', NULL, NULL),
(11234, NULL, NULL, 11234, NULL, 'false', 'false', NULL, NULL),
(11235, NULL, NULL, 11235, NULL, 'false', 'false', NULL, NULL),
(11236, NULL, NULL, 11236, NULL, 'false', 'false', NULL, NULL),
(11237, NULL, NULL, 11237, NULL, 'false', 'false', NULL, NULL),
(11238, NULL, NULL, 11238, NULL, 'false', 'false', NULL, NULL),
(11239, NULL, NULL, 11239, NULL, 'false', 'false', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `field_layout_project_custom`
--

CREATE TABLE `field_layout_project_custom` (
                                               `id` int UNSIGNED NOT NULL,
                                               `project_id` int UNSIGNED DEFAULT NULL,
                                               `issue_type` int UNSIGNED DEFAULT NULL,
                                               `issue_ui_type` tinyint UNSIGNED DEFAULT NULL,
                                               `field_id` int UNSIGNED DEFAULT '0',
                                               `verticalposition` decimal(18,0) DEFAULT NULL,
                                               `ishidden` varchar(60) DEFAULT NULL,
                                               `isrequired` varchar(60) DEFAULT NULL,
                                               `sequence` int UNSIGNED DEFAULT NULL,
                                               `tab` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `field_main`
--

CREATE TABLE `field_main` (
                              `id` int UNSIGNED NOT NULL,
                              `name` varchar(255) DEFAULT NULL,
                              `title` varchar(64) NOT NULL DEFAULT '',
                              `description` varchar(512) DEFAULT NULL,
                              `type` varchar(255) DEFAULT NULL,
                              `default_value` varchar(255) DEFAULT NULL,
                              `is_system` tinyint UNSIGNED DEFAULT '0',
                              `options` varchar(5000) DEFAULT '' COMMENT '{}',
                              `order_weight` int UNSIGNED NOT NULL DEFAULT '0',
                              `extra_attr` varchar(512) NOT NULL DEFAULT '' COMMENT '额外的html属性'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `field_main`
--

INSERT INTO `field_main` (`id`, `name`, `title`, `description`, `type`, `default_value`, `is_system`, `options`, `order_weight`, `extra_attr`) VALUES
(1, 'summary', '标 题', NULL, 'TEXT', NULL, 1, NULL, 0, ''),
(2, 'priority', '优先级', NULL, 'PRIORITY', NULL, 1, NULL, 0, ''),
(3, 'fix_version', '解决版本', NULL, 'VERSION', NULL, 1, NULL, 0, ''),
(4, 'assignee', '经办人', NULL, 'USER', NULL, 1, NULL, 0, ''),
(5, 'reporter', '报告人', NULL, 'USER', NULL, 1, NULL, 0, ''),
(6, 'description', '描 述', NULL, 'MARKDOWN', NULL, 1, NULL, 0, ''),
(7, 'module', '模 块', NULL, 'MODULE', NULL, 1, NULL, 0, ''),
(8, 'labels', '标 签', NULL, 'LABELS', NULL, 1, NULL, 0, ''),
(9, 'environment', '运行环境', '如操作系统，软件平台，硬件环境', 'TEXT', NULL, 1, NULL, 0, ''),
(10, 'resolve', '解决结果', '主要是面向测试工作着和产品经理', 'RESOLUTION', NULL, 1, NULL, 0, ''),
(11, 'attachment', '附 件', NULL, 'UPLOAD_FILE', NULL, 1, NULL, 0, ''),
(12, 'start_date', '开始日期', NULL, 'DATE', NULL, 1, '', 0, ''),
(13, 'due_date', '结束日期', NULL, 'DATE', NULL, 1, NULL, 0, ''),
(14, 'milestone', '里程碑', NULL, 'MILESTONE', NULL, 1, '', 0, ''),
(15, 'sprint', '迭 代', NULL, 'SPRINT', NULL, 1, '', 0, ''),
(17, 'parent_issue', '父事项', NULL, 'ISSUES', NULL, 1, '', 0, ''),
(18, 'effect_version', '影响版本', NULL, 'VERSION', NULL, 1, '', 0, ' multiple'),
(19, 'status', '状 态', NULL, 'STATUS', '1', 1, '', 950, ''),
(20, 'assistants', '协助人', '协助人', 'USER_MULTI', NULL, 1, '', 900, ''),
(21, 'weight', '权 重', '待办事项中的权重值', 'NUMBER', '0', 1, '', 0, 'min=\"0\"'),
(23, 'source', '来源', '', 'TEXT', NULL, 0, 'null', 0, ''),
(26, 'progress', '完成度', '', 'PROGRESS', '0', 1, '', 0, 'min=\"0\" max=\"100\"'),
(27, 'duration', '用时(天)', '', 'TEXT', '1', 1, '', 0, ''),
(28, 'is_start_milestone', '是否起始里程碑', '', 'TEXT', '0', 1, '', 0, ''),
(29, 'is_end_milestone', '是否结束里程碑', '', 'TEXT', '0', 1, '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `field_type`
--

CREATE TABLE `field_type` (
                              `id` int UNSIGNED NOT NULL,
                              `name` varchar(64) DEFAULT NULL,
                              `description` varchar(255) DEFAULT NULL,
                              `type` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `field_type`
--

INSERT INTO `field_type` (`id`, `name`, `description`, `type`) VALUES
(1, 'TEXT', NULL, 'TEXT'),
(2, 'TEXT_MULTI_LINE', NULL, 'TEXT_MULTI_LINE'),
(3, 'TEXTAREA', NULL, 'TEXTAREA'),
(4, 'RADIO', NULL, 'RADIO'),
(5, 'CHECKBOX', NULL, 'CHECKBOX'),
(6, 'SELECT', NULL, 'SELECT'),
(7, 'SELECT_MULTI', NULL, 'SELECT_MULTI'),
(8, 'DATE', NULL, 'DATE'),
(9, 'LABEL', NULL, 'LABELS'),
(10, 'UPLOAD_IMG', NULL, 'UPLOAD_IMG'),
(11, 'UPLOAD_FILE', NULL, 'UPLOAD_FILE'),
(12, 'VERSION', NULL, 'VERSION'),
(16, 'USER', NULL, 'USER'),
(18, 'GROUP', '已废弃', 'GROUP'),
(19, 'GROUP_MULTI', '已经废弃', 'GROUP_MULTI'),
(20, 'MODULE', NULL, 'MODULE'),
(21, 'Milestone', NULL, 'MILESTONE'),
(22, 'Sprint', NULL, 'SPRINT'),
(25, 'Reslution', NULL, 'RESOLUTION'),
(26, 'Issues', NULL, 'ISSUES'),
(27, 'Markdown', NULL, 'MARKDOWN'),
(28, 'USER_MULTI', NULL, 'USER_MULTI'),
(29, 'NUMBER', '数字输入框', 'NUMBER'),
(30, 'PROGRESS', '进度值', 'PROGRESS');

-- --------------------------------------------------------

--
-- 表的结构 `hornet_cache_key`
--

CREATE TABLE `hornet_cache_key` (
                                    `key` varchar(100) NOT NULL,
                                    `module` varchar(64) DEFAULT NULL,
                                    `datetime` datetime DEFAULT NULL,
                                    `expire` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `hornet_user`
--

CREATE TABLE `hornet_user` (
                               `id` int UNSIGNED NOT NULL,
                               `name` varchar(60) NOT NULL DEFAULT '',
                               `phone` varchar(20) NOT NULL,
                               `password` varchar(32) NOT NULL DEFAULT '',
                               `email` varchar(50) NOT NULL DEFAULT '',
                               `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '用户状态:1正常,2禁用',
                               `reg_time` int UNSIGNED NOT NULL DEFAULT '0',
                               `last_login_time` int UNSIGNED NOT NULL DEFAULT '0',
                               `company_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- --------------------------------------------------------

--
-- 表的结构 `issue_assistant`
--

CREATE TABLE `issue_assistant` (
                                   `id` int NOT NULL,
                                   `issue_id` int UNSIGNED DEFAULT NULL,
                                   `user_id` int UNSIGNED DEFAULT NULL,
                                   `join_time` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_description_template`
--

CREATE TABLE `issue_description_template` (
                                              `id` int NOT NULL,
                                              `name` varchar(32) NOT NULL,
                                              `content` text NOT NULL,
                                              `created` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
                                              `updated` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新增事项时描述的模板';

--
-- 转存表中的数据 `issue_description_template`
--

INSERT INTO `issue_description_template` (`id`, `name`, `content`, `created`, `updated`) VALUES
(1, 'bug', '\r\n这里输入对bug做出清晰简洁的描述.\r\n\r\n**重现步骤**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n4. xxxxxx\r\n\r\n**期望结果**\r\n简洁清晰的描述期望结果\r\n\r\n**实际结果**\r\n简述实际看到的结果，这里可以配上截图\r\n\r\n\r\n**附加说明**\r\n附加或额外的信息\r\n', 0, 1562299460),
(2, '新功能', '**功能描述**\r\n一句话简洁清晰的描述功能，例如：\r\n作为一个<用户角色>，在<某种条件或时间>下，我想要<完成活动>，以便于<实现价值>\r\n\r\n**功能点**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n\r\n**规则和影响**\r\n1. xx\r\n2. xxx\r\n\r\n**解决方案**\r\n 解决方案的描述\r\n\r\n**备用方案**\r\n 备用方案的描述\r\n\r\n**附加内容**\r\n\r\n', 0, 1562300466);

-- --------------------------------------------------------

--
-- 表的结构 `issue_effect_version`
--

CREATE TABLE `issue_effect_version` (
                                        `id` int UNSIGNED NOT NULL,
                                        `issue_id` int UNSIGNED DEFAULT NULL,
                                        `version_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `issue_extra_worker_day`
--

CREATE TABLE `issue_extra_worker_day` (
                                          `id` int NOT NULL,
                                          `project_id` int NOT NULL DEFAULT '0',
                                          `day` date NOT NULL,
                                          `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_field_layout_project`
--

CREATE TABLE `issue_field_layout_project` (
                                              `id` decimal(18,0) NOT NULL,
                                              `fieldlayout` decimal(18,0) DEFAULT NULL,
                                              `fieldidentifier` varchar(255) DEFAULT NULL,
                                              `description` text,
                                              `verticalposition` decimal(18,0) DEFAULT NULL,
                                              `ishidden` varchar(60) DEFAULT NULL,
                                              `isrequired` varchar(60) DEFAULT NULL,
                                              `renderertype` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_file_attachment`
--

CREATE TABLE `issue_file_attachment` (
                                         `id` int UNSIGNED NOT NULL,
                                         `uuid` varchar(64) NOT NULL DEFAULT '',
                                         `issue_id` int DEFAULT '0',
                                         `tmp_issue_id` varchar(32) NOT NULL,
                                         `mime_type` varchar(64) DEFAULT '',
                                         `origin_name` varchar(128) NOT NULL DEFAULT '',
                                         `file_name` varchar(255) DEFAULT '',
                                         `created` int DEFAULT '0',
                                         `file_size` int DEFAULT '0',
                                         `author` int DEFAULT '0',
                                         `file_ext` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_filter`
--

CREATE TABLE `issue_filter` (
                                `id` int UNSIGNED NOT NULL,
                                `name` varchar(64) DEFAULT NULL,
                                `author` int DEFAULT NULL,
                                `description` varchar(255) DEFAULT NULL,
                                `share_obj` varchar(255) DEFAULT NULL,
                                `share_scope` varchar(20) DEFAULT NULL COMMENT 'all,group,uid,project,origin',
                                `projectid` decimal(18,0) DEFAULT NULL,
                                `filter` mediumtext,
                                `fav_count` decimal(18,0) DEFAULT NULL,
                                `name_lower` varchar(255) DEFAULT NULL,
                                `is_adv_query` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为高级查询',
                                `adv_query_sort_field` varchar(40) NOT NULL DEFAULT '' COMMENT '高级查询的排序字段',
                                `adv_query_sort_by` varchar(12) NOT NULL DEFAULT 'desc' COMMENT '高级查询的排序',
                                `is_show` tinyint(1) unsigned DEFAULT '1' COMMENT '是否展示',
                                `order_weight` int(11) DEFAULT NULL COMMENT '排序权重'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_fix_version`
--

CREATE TABLE `issue_fix_version` (
                                     `id` int UNSIGNED NOT NULL,
                                     `issue_id` int UNSIGNED DEFAULT NULL,
                                     `version_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_follow`
--

CREATE TABLE `issue_follow` (
                                `id` int UNSIGNED NOT NULL,
                                `issue_id` int UNSIGNED NOT NULL,
                                `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_holiday`
--

CREATE TABLE `issue_holiday` (
                                 `id` int NOT NULL,
                                 `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                 `day` date NOT NULL,
                                 `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_label`
--

CREATE TABLE `issue_label` (
                               `id` int UNSIGNED NOT NULL,
                               `project_id` int UNSIGNED NOT NULL,
                               `title` varchar(64) NOT NULL,
                               `color` varchar(20) NOT NULL,
                               `bg_color` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_label`
--

INSERT INTO `issue_label` (`id`, `project_id`, `title`, `color`, `bg_color`) VALUES
(1, 0, '错 误', '#FFFFFF', '#FF0000'),
(2, 0, '成 功', '#FFFFFF', '#69D100'),
(3, 0, '警 告', '#FFFFFF', '#F0AD4E');

-- --------------------------------------------------------

--
-- 表的结构 `issue_label_data`
--

CREATE TABLE `issue_label_data` (
                                    `id` int UNSIGNED NOT NULL,
                                    `issue_id` int UNSIGNED DEFAULT NULL,
                                    `label_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_main`
--

CREATE TABLE `issue_main` (
                              `id` int UNSIGNED NOT NULL,
                              `pkey` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `issue_num` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `project_id` int DEFAULT '0',
                              `issue_type` int UNSIGNED NOT NULL DEFAULT '0',
                              `creator` int UNSIGNED DEFAULT '0',
                              `modifier` int UNSIGNED NOT NULL DEFAULT '0',
                              `reporter` int DEFAULT '0',
                              `assignee` int DEFAULT '0',
                              `summary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                              `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                              `environment` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
                              `priority` int DEFAULT '0',
                              `resolve` int DEFAULT '0',
                              `status` int DEFAULT '0',
                              `created` int DEFAULT '0',
                              `updated` int DEFAULT '0',
                              `start_date` date DEFAULT NULL,
                              `due_date` date DEFAULT NULL,
                              `duration` int UNSIGNED NOT NULL DEFAULT '0',
                              `resolve_date` date DEFAULT NULL,
                              `module` int DEFAULT '0',
                              `milestone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `sprint` int NOT NULL DEFAULT '0',
                              `weight` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '优先级权重值',
                              `backlog_weight` int NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
                              `sprint_weight` int NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
                              `assistants` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                              `level` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '甘特图级别',
                              `master_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
                              `have_children` tinyint UNSIGNED DEFAULT '0' COMMENT '是否拥有子任务',
                              `followed_count` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '被关注人数',
                              `comment_count` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数',
                              `progress` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '完成百分比',
                              `depends` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前置任务',
                              `gant_sprint_weight` int NOT NULL DEFAULT '0' COMMENT '迭代甘特图中该事项在同级的排序权重',
                              `gant_hide` tinyint(1) NOT NULL DEFAULT '0' COMMENT '甘特图中是否隐藏该事项',
                              `is_start_milestone` tinyint UNSIGNED NOT NULL DEFAULT '0',
                              `is_end_milestone` tinyint UNSIGNED NOT NULL DEFAULT '0',
                              `last_close_resolve_time` int(11) unsigned DEFAULT 0 COMMENT '最近解决结果:关闭的时间',
                              `last_close_status_time` int(11) unsigned DEFAULT 0 COMMENT '最近状态:已完成的时间',
                              `last_done_resolve_time` int(11) unsigned DEFAULT 0 COMMENT '最近解决结果:已解决的时间',
                              `last_done_status_time` int(11) unsigned DEFAULT 0 COMMENT '最近状态:已解决的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `issue_moved_issue_key`
--

CREATE TABLE `issue_moved_issue_key` (
                                         `id` decimal(18,0) NOT NULL,
                                         `old_issue_key` varchar(255) DEFAULT NULL,
                                         `issue_id` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_priority`
--

CREATE TABLE `issue_priority` (
                                  `id` int UNSIGNED NOT NULL,
                                  `sequence` int UNSIGNED DEFAULT '0',
                                  `name` varchar(60) DEFAULT NULL,
                                  `_key` varchar(128) NOT NULL,
                                  `description` text,
                                  `iconurl` varchar(255) DEFAULT NULL,
                                  `status_color` varchar(60) DEFAULT NULL,
                                  `font_awesome` varchar(40) DEFAULT NULL,
                                  `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_priority`
--

INSERT INTO `issue_priority` (`id`, `sequence`, `name`, `_key`, `description`, `iconurl`, `status_color`, `font_awesome`, `is_system`) VALUES
(1, 1, '紧 急', 'very_import', '阻塞开发或测试的工作进度，或影响系统无法运行的错误', '/images/icons/priorities/blocker.png', 'red', NULL, 1),
(2, 2, '重 要', 'import', '系统崩溃，丢失数据或内存溢出等严重错误、或者必需完成的任务', '/images/icons/priorities/critical.png', '#cc0000', NULL, 1),
(3, 3, '高', 'high', '主要的功能无效或流程异常', '/images/icons/priorities/major.png', '#ff0000', NULL, 1),
(4, 4, '中', 'normal', '功能部分无效或对现有系统的改进', '/images/icons/priorities/minor.png', '#006600', NULL, 1),
(5, 5, '低', 'low', '不影响功能和流程的问题', '/images/icons/priorities/trivial.png', '#003300', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `issue_recycle`
--

CREATE TABLE `issue_recycle` (
                                 `id` int UNSIGNED NOT NULL,
                                 `delete_user_id` int UNSIGNED NOT NULL,
                                 `issue_id` int UNSIGNED DEFAULT NULL,
                                 `pkey` varchar(32) DEFAULT NULL,
                                 `issue_num` decimal(18,0) DEFAULT NULL,
                                 `project_id` int DEFAULT '0',
                                 `issue_type` int UNSIGNED NOT NULL DEFAULT '0',
                                 `creator` int UNSIGNED DEFAULT '0',
                                 `modifier` int UNSIGNED NOT NULL DEFAULT '0',
                                 `reporter` int DEFAULT '0',
                                 `assignee` int DEFAULT '0',
                                 `summary` varchar(255) DEFAULT '',
                                 `description` text,
                                 `environment` varchar(128) DEFAULT '',
                                 `priority` int DEFAULT '0',
                                 `resolve` int DEFAULT '0',
                                 `status` int DEFAULT '0',
                                 `created` int DEFAULT '0',
                                 `updated` int DEFAULT '0',
                                 `start_date` date DEFAULT NULL,
                                 `due_date` date DEFAULT NULL,
                                 `resolve_date` datetime DEFAULT NULL,
                                 `workflow_id` int DEFAULT '0',
                                 `module` int DEFAULT '0',
                                 `milestone` varchar(20) DEFAULT NULL,
                                 `sprint` int NOT NULL DEFAULT '0',
                                 `assistants` varchar(256) NOT NULL DEFAULT '',
                                 `master_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
                                 `data` text,
                                 `time` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_resolve`
--

CREATE TABLE `issue_resolve` (
                                 `id` int UNSIGNED NOT NULL,
                                 `sequence` int UNSIGNED DEFAULT '0',
                                 `name` varchar(60) DEFAULT NULL,
                                 `_key` varchar(128) NOT NULL,
                                 `description` text,
                                 `font_awesome` varchar(32) DEFAULT NULL,
                                 `color` varchar(20) DEFAULT NULL,
                                 `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_resolve`
--

INSERT INTO `issue_resolve` (`id`, `sequence`, `name`, `_key`, `description`, `font_awesome`, `color`, `is_system`) VALUES
(1, 1, '已解决', 'fixed', '事项已经解决', NULL, '#1aaa55', 1),
(2, 2, '未解决', 'not_fix', '事项不可抗拒原因无法解决', NULL, '#db3b21', 1),
(3, 3, '事项重复', 'require_duplicate', '事项需要的描述需要有重现步骤', NULL, '#db3b21', 1),
(4, 4, '信息不完整', 'not_complete', '事项信息描述不完整', NULL, '#db3b21', 1),
(5, 5, '不能重现', 'not_reproduce', '事项不能重现', NULL, '#db3b21', 1),
(10000, 6, '结束', 'done', '事项已经解决并关闭掉', NULL, '#1aaa55', 1),
(10100, 8, '问题不存在', 'issue_not_exists', '事项不存在', NULL, 'rgba(0,0,0,0.85)', 1),
(10101, 9, '延迟处理', 'delay', '事项将推迟处理', NULL, 'rgba(0,0,0,0.85)', 1);

-- --------------------------------------------------------

--
-- 表的结构 `issue_status`
--

CREATE TABLE `issue_status` (
                                `id` int UNSIGNED NOT NULL,
                                `sequence` int UNSIGNED DEFAULT '0',
                                `name` varchar(60) DEFAULT NULL,
                                `_key` varchar(20) DEFAULT NULL,
                                `description` varchar(500) DEFAULT NULL,
                                `font_awesome` varchar(255) DEFAULT NULL,
                                `is_system` tinyint UNSIGNED DEFAULT '0',
                                `color` varchar(20) DEFAULT NULL COMMENT 'Default Primary Success Info Warning Danger可选',
                                `text_color` varchar(12) NOT NULL DEFAULT 'black' COMMENT '字体颜色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_status`
--

INSERT INTO `issue_status` (`id`, `sequence`, `name`, `_key`, `description`, `font_awesome`, `is_system`, `color`, `text_color`) VALUES
(1, 1, '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', 1, 'info', 'blue'),
(3, 3, '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', 1, 'primary', 'blue'),
(4, 4, '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', 1, 'warning', 'blue'),
(5, 5, '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', 1, 'success', 'green'),
(6, 6, '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', 1, 'success', 'green'),
(10001, 0, '完成', 'done', '表明一件事项已经解决且被实践验证过', '', 1, 'success', 'green'),
(10002, 9, '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', 1, 'info', 'black'),
(10100, 10, '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', 1, 'info', 'black');

-- --------------------------------------------------------

--
-- 表的结构 `issue_type`
--

CREATE TABLE `issue_type` (
                              `id` int UNSIGNED NOT NULL,
                              `sequence` decimal(18,0) DEFAULT NULL,
                              `name` varchar(60) DEFAULT NULL,
                              `_key` varchar(64) NOT NULL,
                              `catalog` enum('Custom','Kanban','Scrum','Standard') DEFAULT 'Standard' COMMENT '类型',
                              `description` text,
                              `font_awesome` varchar(20) DEFAULT NULL,
                              `custom_icon_url` varchar(128) DEFAULT NULL,
                              `is_system` tinyint UNSIGNED DEFAULT '0',
                              `form_desc_tpl_id` int UNSIGNED DEFAULT '0' COMMENT '创建事项时,描述字段对应的模板id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_type`
--

INSERT INTO `issue_type` (`id`, `sequence`, `name`, `_key`, `catalog`, `description`, `font_awesome`, `custom_icon_url`, `is_system`, `form_desc_tpl_id`) VALUES
(1, '1', 'Bug', 'bug', 'Standard', '测试过程、维护过程发现影响系统运行的缺陷', 'fa-bug', NULL, 1, 1),
(2, '2', '新功能', 'new_feature', 'Standard', '对系统提出的新功能', 'fa-plus', NULL, 1, 2),
(3, '3', '任务', 'task', 'Standard', '需要完成的任务', 'fa-tasks', NULL, 1, 0),
(4, '4', '优化改进', 'improve', 'Standard', '对现有系统功能的改进', 'fa-arrow-circle-o-up', NULL, 1, 5),
(5, '0', '子任务', 'child_task', 'Standard', '', 'fa-subscript', NULL, 1, 5),
(6, '2', '用户故事', 'user_story', 'Scrum', '从用户的角度来描述用户渴望得到的功能。一个好的用户故事包括三个要素：1. 角色；2. 活动　3. 商业价值', 'fa-users', NULL, 1, 2),
(7, '3', '技术任务', 'tech_task', 'Scrum', '技术性的任务,如架构设计,数据库选型', 'fa-cogs', NULL, 1, 2),
(8, '5', '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', NULL, 1, 0),
(12, NULL, '甘特图', 'gantt', 'Custom', '', 'fa-exchange', NULL, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_type_scheme`
--

CREATE TABLE `issue_type_scheme` (
                                     `id` int UNSIGNED NOT NULL,
                                     `name` varchar(64) DEFAULT NULL,
                                     `description` varchar(100) DEFAULT NULL,
                                     `is_default` tinyint UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问题方案表';

--
-- 转存表中的数据 `issue_type_scheme`
--

INSERT INTO `issue_type_scheme` (`id`, `name`, `description`, `is_default`) VALUES
(1, '默认事项方案', '系统默认的事项方案', 1),
(2, '敏捷开发事项方案', '敏捷开发适用的方案', 1),
(5, '任务管理事项解决方案', '任务管理', 1);

-- --------------------------------------------------------

--
-- 表的结构 `issue_type_scheme_data`
--

CREATE TABLE `issue_type_scheme_data` (
                                          `id` int UNSIGNED NOT NULL,
                                          `scheme_id` int UNSIGNED DEFAULT NULL,
                                          `type_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问题方案字表';

--
-- 转存表中的数据 `issue_type_scheme_data`
--

INSERT INTO `issue_type_scheme_data` (`id`, `scheme_id`, `type_id`) VALUES
(3, 3, 1),
(17, 4, 10000),
(471, 2, 1),
(472, 2, 2),
(473, 2, 3),
(474, 2, 4),
(475, 2, 6),
(476, 2, 7),
(477, 2, 8),
(488, 5, 3),
(489, 5, 4),
(490, 5, 5),
(491, 1, 1),
(492, 1, 2),
(493, 1, 3),
(494, 1, 4),
(495, 1, 5);

-- --------------------------------------------------------

--
-- 表的结构 `issue_ui`
--

CREATE TABLE `issue_ui` (
                            `id` int UNSIGNED NOT NULL,
                            `schem_id` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '所属方案id',
                            `issue_type_id` int UNSIGNED DEFAULT NULL,
                            `ui_type` varchar(10) DEFAULT '',
                            `field_id` int UNSIGNED DEFAULT NULL,
                            `order_weight` int UNSIGNED DEFAULT NULL,
                            `tab_id` int UNSIGNED DEFAULT '0',
                            `required` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否必填项'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_ui`
--

INSERT INTO `issue_ui` (`id`, `schem_id`, `issue_type_id`, `ui_type`, `field_id`, `order_weight`, `tab_id`, `required`) VALUES
(205, 1, 8, 'create', 1, 3, 0, 1),
(206, 1, 8, 'create', 2, 2, 0, 0),
(207, 1, 8, 'create', 3, 1, 0, 0),
(208, 1, 8, 'create', 4, 0, 0, 0),
(209, 1, 8, 'create', 5, 0, 2, 0),
(210, 1, 8, 'create', 6, 3, 0, 0),
(211, 1, 8, 'create', 7, 2, 0, 0),
(212, 1, 8, 'create', 8, 1, 0, 0),
(213, 1, 8, 'create', 9, 1, 0, 0),
(214, 1, 8, 'create', 10, 0, 0, 0),
(215, 1, 8, 'create', 11, 0, 0, 0),
(216, 1, 8, 'create', 12, 0, 0, 0),
(217, 1, 8, 'create', 13, 0, 0, 0),
(218, 1, 8, 'create', 14, 0, 0, 0),
(219, 1, 8, 'create', 15, 0, 0, 0),
(220, 1, 8, 'create', 16, 0, 0, 0),
(221, 1, 8, 'edit', 1, 3, 0, 1),
(222, 1, 8, 'edit', 2, 2, 0, 0),
(223, 1, 8, 'edit', 3, 1, 0, 0),
(224, 1, 8, 'edit', 4, 0, 0, 0),
(225, 1, 8, 'edit', 5, 0, 2, 0),
(226, 1, 8, 'edit', 6, 3, 0, 0),
(227, 1, 8, 'edit', 7, 2, 0, 0),
(228, 1, 8, 'edit', 8, 1, 0, 0),
(229, 1, 8, 'edit', 9, 1, 0, 0),
(230, 1, 8, 'edit', 10, 0, 0, 0),
(231, 1, 8, 'edit', 11, 0, 0, 0),
(232, 1, 8, 'edit', 12, 0, 0, 0),
(233, 1, 8, 'edit', 13, 0, 0, 0),
(234, 1, 8, 'edit', 14, 0, 0, 0),
(235, 1, 8, 'edit', 15, 0, 0, 0),
(236, 1, 8, 'edit', 16, 0, 0, 0),
(422, 1, 4, 'create', 1, 14, 0, 1),
(423, 1, 4, 'create', 6, 13, 0, 0),
(424, 1, 4, 'create', 2, 12, 0, 0),
(425, 1, 4, 'create', 3, 11, 0, 0),
(426, 1, 4, 'create', 7, 10, 0, 0),
(427, 1, 4, 'create', 9, 9, 0, 0),
(428, 1, 4, 'create', 8, 8, 0, 0),
(429, 1, 4, 'create', 4, 7, 0, 0),
(430, 1, 4, 'create', 19, 6, 0, 0),
(431, 1, 4, 'create', 10, 5, 0, 0),
(432, 1, 4, 'create', 11, 4, 0, 0),
(433, 1, 4, 'create', 12, 3, 0, 0),
(434, 1, 4, 'create', 13, 2, 0, 0),
(435, 1, 4, 'create', 15, 1, 0, 0),
(436, 1, 4, 'create', 20, 0, 0, 0),
(452, 1, 5, 'create', 1, 14, 0, 1),
(453, 1, 5, 'create', 6, 13, 0, 0),
(454, 1, 5, 'create', 2, 12, 0, 0),
(455, 1, 5, 'create', 7, 11, 0, 0),
(456, 1, 5, 'create', 9, 10, 0, 0),
(457, 1, 5, 'create', 8, 9, 0, 0),
(458, 1, 5, 'create', 3, 8, 0, 0),
(459, 1, 5, 'create', 4, 7, 0, 0),
(460, 1, 5, 'create', 19, 6, 0, 0),
(461, 1, 5, 'create', 10, 5, 0, 0),
(462, 1, 5, 'create', 11, 4, 0, 0),
(463, 1, 5, 'create', 12, 3, 0, 0),
(464, 1, 5, 'create', 13, 2, 0, 0),
(465, 1, 5, 'create', 15, 1, 0, 0),
(466, 1, 5, 'create', 20, 0, 0, 0),
(467, 1, 5, 'edit', 1, 14, 0, 1),
(468, 1, 5, 'edit', 6, 13, 0, 0),
(469, 1, 5, 'edit', 2, 12, 0, 0),
(470, 1, 5, 'edit', 7, 11, 0, 0),
(471, 1, 5, 'edit', 9, 10, 0, 0),
(472, 1, 5, 'edit', 8, 9, 0, 0),
(473, 1, 5, 'edit', 3, 8, 0, 0),
(474, 1, 5, 'edit', 4, 7, 0, 0),
(475, 1, 5, 'edit', 19, 6, 0, 0),
(476, 1, 5, 'edit', 10, 5, 0, 0),
(477, 1, 5, 'edit', 11, 4, 0, 0),
(478, 1, 5, 'edit', 12, 3, 0, 0),
(479, 1, 5, 'edit', 13, 2, 0, 0),
(480, 1, 5, 'edit', 15, 1, 0, 0),
(481, 1, 5, 'edit', 20, 0, 0, 0),
(587, 1, 6, 'create', 1, 7, 0, 1),
(588, 1, 6, 'create', 6, 6, 0, 0),
(589, 1, 6, 'create', 2, 5, 0, 0),
(590, 1, 6, 'create', 8, 4, 0, 0),
(591, 1, 6, 'create', 11, 3, 0, 0),
(592, 1, 6, 'create', 4, 2, 0, 0),
(593, 1, 6, 'create', 21, 1, 0, 0),
(594, 1, 6, 'create', 15, 0, 0, 0),
(595, 1, 6, 'create', 19, 6, 33, 0),
(596, 1, 6, 'create', 10, 5, 33, 0),
(597, 1, 6, 'create', 7, 4, 33, 0),
(598, 1, 6, 'create', 20, 3, 33, 0),
(599, 1, 6, 'create', 9, 2, 33, 0),
(600, 1, 6, 'create', 13, 1, 33, 0),
(601, 1, 6, 'create', 12, 0, 33, 0),
(602, 1, 6, 'edit', 1, 7, 0, 1),
(603, 1, 6, 'edit', 6, 6, 0, 0),
(604, 1, 6, 'edit', 2, 5, 0, 0),
(605, 1, 6, 'edit', 8, 4, 0, 0),
(606, 1, 6, 'edit', 4, 3, 0, 0),
(607, 1, 6, 'edit', 11, 2, 0, 0),
(608, 1, 6, 'edit', 15, 1, 0, 0),
(609, 1, 6, 'edit', 21, 0, 0, 0),
(610, 1, 6, 'edit', 19, 6, 34, 0),
(611, 1, 6, 'edit', 10, 5, 34, 0),
(612, 1, 6, 'edit', 7, 4, 34, 0),
(613, 1, 6, 'edit', 20, 3, 34, 0),
(614, 1, 6, 'edit', 9, 2, 34, 0),
(615, 1, 6, 'edit', 12, 1, 34, 0),
(616, 1, 6, 'edit', 13, 0, 34, 0),
(646, 1, 7, 'create', 1, 7, 0, 1),
(647, 1, 7, 'create', 6, 6, 0, 0),
(648, 1, 7, 'create', 2, 5, 0, 0),
(649, 1, 7, 'create', 8, 4, 0, 0),
(650, 1, 7, 'create', 4, 3, 0, 0),
(651, 1, 7, 'create', 11, 2, 0, 0),
(652, 1, 7, 'create', 15, 1, 0, 0),
(653, 1, 7, 'create', 21, 0, 0, 0),
(654, 1, 7, 'create', 19, 6, 37, 0),
(655, 1, 7, 'create', 10, 5, 37, 0),
(656, 1, 7, 'create', 7, 4, 37, 0),
(657, 1, 7, 'create', 20, 3, 37, 0),
(658, 1, 7, 'create', 9, 2, 37, 0),
(659, 1, 7, 'create', 13, 1, 37, 0),
(660, 1, 7, 'create', 12, 0, 37, 0),
(1060, 1, 9, 'create', 1, 4, 0, 1),
(1061, 1, 9, 'create', 19, 3, 0, 0),
(1062, 1, 9, 'create', 3, 2, 0, 0),
(1063, 1, 9, 'create', 6, 1, 0, 0),
(1064, 1, 9, 'create', 4, 0, 0, 0),
(1080, 1, 7, 'edit', 1, 7, 0, 0),
(1081, 1, 7, 'edit', 6, 6, 0, 0),
(1082, 1, 7, 'edit', 2, 5, 0, 0),
(1083, 1, 7, 'edit', 8, 4, 0, 0),
(1084, 1, 7, 'edit', 4, 3, 0, 0),
(1085, 1, 7, 'edit', 11, 2, 0, 0),
(1086, 1, 7, 'edit', 15, 1, 0, 0),
(1087, 1, 7, 'edit', 21, 0, 0, 0),
(1088, 1, 7, 'edit', 19, 6, 63, 0),
(1089, 1, 7, 'edit', 10, 5, 63, 0),
(1090, 1, 7, 'edit', 7, 4, 63, 0),
(1091, 1, 7, 'edit', 9, 3, 63, 0),
(1092, 1, 7, 'edit', 20, 2, 63, 0),
(1093, 1, 7, 'edit', 12, 1, 63, 0),
(1094, 1, 7, 'edit', 13, 0, 63, 0),
(1095, 1, 4, 'edit', 1, 11, 0, 0),
(1096, 1, 4, 'edit', 6, 10, 0, 0),
(1097, 1, 4, 'edit', 2, 9, 0, 0),
(1098, 1, 4, 'edit', 7, 8, 0, 0),
(1099, 1, 4, 'edit', 4, 7, 0, 0),
(1100, 1, 4, 'edit', 19, 6, 0, 0),
(1101, 1, 4, 'edit', 11, 5, 0, 0),
(1102, 1, 4, 'edit', 12, 4, 0, 0),
(1103, 1, 4, 'edit', 13, 3, 0, 0),
(1104, 1, 4, 'edit', 15, 2, 0, 0),
(1105, 1, 4, 'edit', 20, 1, 0, 0),
(1106, 1, 4, 'edit', 21, 0, 0, 0),
(1107, 1, 4, 'edit', 8, 3, 64, 0),
(1108, 1, 4, 'edit', 9, 2, 64, 0),
(1109, 1, 4, 'edit', 3, 1, 64, 0),
(1110, 1, 4, 'edit', 10, 0, 64, 0),
(1414, 1, 12, 'edit', 1, 8, 0, 1),
(1415, 1, 12, 'edit', 4, 7, 0, 1),
(1416, 1, 12, 'edit', 15, 6, 0, 1),
(1417, 1, 12, 'edit', 12, 5, 0, 1),
(1418, 1, 12, 'edit', 13, 4, 0, 1),
(1419, 1, 12, 'edit', 27, 3, 0, 0),
(1420, 1, 12, 'edit', 28, 2, 0, 0),
(1421, 1, 12, 'edit', 29, 1, 0, 0),
(1422, 1, 12, 'edit', 6, 0, 0, 0),
(1423, 1, 12, 'create', 1, 8, 0, 1),
(1424, 1, 12, 'create', 4, 7, 0, 1),
(1425, 1, 12, 'create', 15, 6, 0, 1),
(1426, 1, 12, 'create', 12, 5, 0, 1),
(1427, 1, 12, 'create', 27, 4, 0, 0),
(1428, 1, 12, 'create', 13, 3, 0, 1),
(1429, 1, 12, 'create', 28, 2, 0, 0),
(1430, 1, 12, 'create', 29, 1, 0, 0),
(1431, 1, 12, 'create', 6, 0, 0, 0),
(1432, 1, 2, 'create', 1, 10, 0, 1),
(1433, 1, 2, 'create', 6, 9, 0, 0),
(1434, 1, 2, 'create', 19, 8, 0, 0),
(1435, 1, 2, 'create', 2, 7, 0, 0),
(1436, 1, 2, 'create', 7, 6, 0, 0),
(1437, 1, 2, 'create', 4, 5, 0, 0),
(1438, 1, 2, 'create', 11, 4, 0, 0),
(1439, 1, 2, 'create', 12, 3, 0, 0),
(1440, 1, 2, 'create', 13, 2, 0, 0),
(1441, 1, 2, 'create', 15, 1, 0, 0),
(1442, 1, 2, 'create', 21, 0, 0, 0),
(1443, 1, 2, 'create', 10, 4, 81, 0),
(1444, 1, 2, 'create', 20, 3, 81, 0),
(1445, 1, 2, 'create', 9, 2, 81, 0),
(1446, 1, 2, 'create', 3, 1, 81, 0),
(1447, 1, 2, 'create', 26, 0, 81, 0),
(1448, 1, 2, 'edit', 1, 11, 0, 1),
(1449, 1, 2, 'edit', 19, 10, 0, 0),
(1450, 1, 2, 'edit', 10, 9, 0, 0),
(1451, 1, 2, 'edit', 6, 8, 0, 0),
(1452, 1, 2, 'edit', 2, 7, 0, 0),
(1453, 1, 2, 'edit', 7, 6, 0, 0),
(1454, 1, 2, 'edit', 4, 5, 0, 0),
(1455, 1, 2, 'edit', 11, 4, 0, 0),
(1456, 1, 2, 'edit', 12, 3, 0, 0),
(1457, 1, 2, 'edit', 13, 2, 0, 0),
(1458, 1, 2, 'edit', 15, 1, 0, 1),
(1459, 1, 2, 'edit', 21, 0, 0, 0),
(1460, 1, 2, 'edit', 20, 3, 82, 0),
(1461, 1, 2, 'edit', 9, 2, 82, 0),
(1462, 1, 2, 'edit', 3, 1, 82, 0),
(1463, 1, 2, 'edit', 26, 0, 82, 0),
(1625, 1, 3, 'create', 1, 12, 0, 1),
(1626, 1, 3, 'create', 6, 11, 0, 0),
(1627, 1, 3, 'create', 2, 10, 0, 0),
(1628, 1, 3, 'create', 7, 9, 0, 0),
(1629, 1, 3, 'create', 8, 8, 0, 0),
(1630, 1, 3, 'create', 4, 7, 0, 0),
(1631, 1, 3, 'create', 20, 6, 0, 0),
(1632, 1, 3, 'create', 19, 5, 0, 0),
(1633, 1, 3, 'create', 10, 4, 0, 0),
(1634, 1, 3, 'create', 11, 3, 0, 0),
(1635, 1, 3, 'create', 12, 2, 0, 0),
(1636, 1, 3, 'create', 13, 1, 0, 0),
(1637, 1, 3, 'create', 15, 0, 0, 0),
(1638, 1, 3, 'create', 3, 4, 90, 0),
(1639, 1, 3, 'create', 9, 3, 90, 0),
(1640, 1, 3, 'create', 21, 2, 90, 0),
(1641, 1, 3, 'create', 23, 1, 90, 0),
(1642, 1, 3, 'create', 26, 0, 90, 0),
(1643, 1, 3, 'edit', 1, 13, 0, 1),
(1644, 1, 3, 'edit', 6, 12, 0, 0),
(1645, 1, 3, 'edit', 2, 11, 0, 0),
(1646, 1, 3, 'edit', 7, 10, 0, 0),
(1647, 1, 3, 'edit', 8, 9, 0, 0),
(1648, 1, 3, 'edit', 4, 8, 0, 0),
(1649, 1, 3, 'edit', 20, 7, 0, 0),
(1650, 1, 3, 'edit', 19, 6, 0, 0),
(1651, 1, 3, 'edit', 10, 5, 0, 0),
(1652, 1, 3, 'edit', 11, 4, 0, 0),
(1653, 1, 3, 'edit', 12, 3, 0, 0),
(1654, 1, 3, 'edit', 13, 2, 0, 0),
(1655, 1, 3, 'edit', 26, 1, 0, 0),
(1656, 1, 3, 'edit', 15, 0, 0, 0),
(1657, 1, 3, 'edit', 9, 3, 91, 0),
(1658, 1, 3, 'edit', 3, 2, 91, 0),
(1659, 1, 3, 'edit', 23, 1, 91, 0),
(1660, 1, 3, 'edit', 21, 0, 91, 0),
(2229, 1, 1, 'create', 1, 9, 0, 1),
(2230, 1, 1, 'create', 6, 8, 0, 0),
(2231, 1, 1, 'create', 2, 7, 0, 1),
(2232, 1, 1, 'create', 7, 6, 0, 0),
(2233, 1, 1, 'create', 4, 5, 0, 1),
(2234, 1, 1, 'create', 11, 4, 0, 0),
(2235, 1, 1, 'create', 12, 3, 0, 0),
(2236, 1, 1, 'create', 13, 2, 0, 0),
(2237, 1, 1, 'create', 15, 1, 0, 0),
(2238, 1, 1, 'create', 23, 0, 0, 0),
(2239, 1, 1, 'create', 19, 9, 119, 0),
(2240, 1, 1, 'create', 10, 8, 119, 0),
(2241, 1, 1, 'create', 20, 7, 119, 0),
(2242, 1, 1, 'create', 18, 6, 119, 0),
(2243, 1, 1, 'create', 3, 5, 119, 0),
(2244, 1, 1, 'create', 21, 4, 119, 0),
(2245, 1, 1, 'create', 8, 3, 119, 0),
(2246, 1, 1, 'create', 9, 2, 119, 0),
(2247, 1, 1, 'create', 29, 1, 119, 0),
(2248, 1, 1, 'create', 28, 0, 119, 0),
(2266, 1, 1, 'edit', 1, 10, 0, 1),
(2267, 1, 1, 'edit', 6, 9, 0, 0),
(2268, 1, 1, 'edit', 2, 8, 0, 1),
(2269, 1, 1, 'edit', 19, 7, 0, 0),
(2270, 1, 1, 'edit', 10, 6, 0, 0),
(2271, 1, 1, 'edit', 7, 5, 0, 0),
(2272, 1, 1, 'edit', 4, 4, 0, 1),
(2273, 1, 1, 'edit', 11, 3, 0, 0),
(2274, 1, 1, 'edit', 12, 2, 0, 0),
(2275, 1, 1, 'edit', 13, 1, 0, 0),
(2276, 1, 1, 'edit', 15, 0, 0, 0),
(2277, 1, 1, 'edit', 3, 5, 121, 0),
(2278, 1, 1, 'edit', 18, 4, 121, 0),
(2279, 1, 1, 'edit', 20, 3, 121, 0),
(2280, 1, 1, 'edit', 21, 2, 121, 0),
(2281, 1, 1, 'edit', 8, 1, 121, 0),
(2282, 1, 1, 'edit', 9, 0, 121, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_ui_scheme`
--

CREATE TABLE `issue_ui_scheme` (
                                   `id` int UNSIGNED NOT NULL,
                                   `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                                   `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0',
                                   `order_weight` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='事项表单配置方案';

--
-- 转存表中的数据 `issue_ui_scheme`
--

INSERT INTO `issue_ui_scheme` (`id`, `name`, `is_system`, `order_weight`) VALUES
(1, '默认方案', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_ui_tab`
--

CREATE TABLE `issue_ui_tab` (
                                `id` int UNSIGNED NOT NULL,
                                `scheme_id` int UNSIGNED DEFAULT '1',
                                `issue_type_id` int UNSIGNED DEFAULT NULL,
                                `name` varchar(255) DEFAULT NULL,
                                `order_weight` int DEFAULT NULL,
                                `ui_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_ui_tab`
--

INSERT INTO `issue_ui_tab` (`id`, `scheme_id`, `issue_type_id`, `name`, `order_weight`, `ui_type`) VALUES
(33, 1, 6, '更多', 0, 'create'),
(34, 1, 6, '\n            \n            更多\n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(37, 1, 7, '更 多', 0, 'create'),
(63, 1, 7, '\n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(64, 1, 4, '\n            \n            \n            更多\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(81, 1, 2, '更 多', 0, 'create'),
(82, 1, 2, '\n            \n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             ', 0, 'edit'),
(90, 1, 3, '其他', 0, 'create'),
(91, 1, 3, '\n            \n            \n            \n            \n            \n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n    ', 0, 'edit'),
(119, 1, 1, '更 多', 0, 'create'),
(121, 1, 1, '\n            更多\n             \n            \n        ', 0, 'edit');

-- --------------------------------------------------------

--
-- 表的结构 `log_base`
--

CREATE TABLE `log_base` (
                            `id` int NOT NULL,
                            `company_id` int UNSIGNED NOT NULL DEFAULT '0',
                            `module` varchar(20) DEFAULT NULL COMMENT '所属模块',
                            `obj_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作记录所关联的对象id,如现货id 订单id',
                            `uid` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作者id,0为系统操作',
                            `user_name` varchar(32) DEFAULT '' COMMENT '操作者用户名',
                            `real_name` varchar(255) DEFAULT NULL,
                            `page` varchar(100) DEFAULT '' COMMENT '页面',
                            `pre_status` tinyint UNSIGNED DEFAULT NULL,
                            `cur_status` tinyint UNSIGNED DEFAULT NULL,
                            `action` varchar(20) DEFAULT NULL COMMENT '操作动作',
                            `remark` varchar(100) DEFAULT '' COMMENT '动作',
                            `pre_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
                            `cur_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
                            `ip` varchar(15) DEFAULT '' COMMENT '操作者ip地址 ',
                            `time` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

-- --------------------------------------------------------

--
-- 表的结构 `log_operating`
--

CREATE TABLE `log_operating` (
                                 `id` int NOT NULL,
                                 `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                 `module` varchar(20) DEFAULT NULL COMMENT '所属模块',
                                 `obj_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作记录所关联的对象id,如现货id 订单id',
                                 `uid` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作者id,0为系统操作',
                                 `user_name` varchar(32) DEFAULT '' COMMENT '操作者用户名',
                                 `real_name` varchar(255) DEFAULT NULL,
                                 `page` varchar(100) DEFAULT '' COMMENT '页面',
                                 `pre_status` tinyint UNSIGNED DEFAULT NULL,
                                 `cur_status` tinyint UNSIGNED DEFAULT NULL,
                                 `action` varchar(20) DEFAULT NULL COMMENT '操作动作',
                                 `remark` varchar(100) DEFAULT '' COMMENT '动作',
                                 `pre_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
                                 `cur_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
                                 `ip` varchar(15) DEFAULT '' COMMENT '操作者ip地址 ',
                                 `time` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

--
-- 转存表中的数据 `log_operating`
--

INSERT INTO `log_operating` (`id`, `project_id`, `module`, `obj_id`, `uid`, `user_name`, `real_name`, `page`, `pre_status`, `cur_status`, `action`, `remark`, `pre_data`, `cur_data`, `ip`, `time`) VALUES
(1, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '[]', '{\"name\":\"NewCity\",\"org_id\":\"1\",\"key\":\"city\",\"lead\":\"1\",\"description\":\"wwwww\",\"project_tpl_id\":1,\"category\":0,\"url\":\"\",\"create_time\":1604403288,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '127.0.0.1', 1604403289),
(2, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '[]', '{\"name\":\"NewCity2\",\"org_id\":\"1\",\"key\":\"city2\",\"lead\":\"1\",\"description\":\"wwwww\",\"project_tpl_id\":1,\"category\":0,\"url\":\"\",\"create_time\":1604404475,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '127.0.0.1', 1604404475),
(3, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '[]', '{\"name\":\"NewCity3\",\"org_id\":\"1\",\"key\":\"city3\",\"lead\":\"1\",\"description\":\"wwwww\",\"project_tpl_id\":1,\"category\":0,\"url\":\"\",\"create_time\":1604404565,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '127.0.0.1', 1604404565),
(4, 1, '事项', 139, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"139\",\"pkey\":\"example\",\"issue_num\":\"139\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12167\",\"summary\":\"\\u5546\\u57ce\\u6a21\\u5757\\u7f16\\u7801\",\"description\":\"![1cut-202004181604013986.png](\\/attachment\\/image\\/20200418\\/1cut-202004181604013986.png \\\"\\u622a\\u56fe-1cut-202004181604013986.png\\\")\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242645\",\"updated\":\"1583242645\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-11\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"999250000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"139\",\"pkey\":\"example\",\"issue_num\":\"139\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12167\",\"summary\":\"\\u5546\\u57ce\\u6a21\\u5757\\u7f16\\u7801\",\"description\":\"![1cut-202004181604013986.png](\\/attachment\\/image\\/20200418\\/1cut-202004181604013986.png \\\"\\u622a\\u56fe-1cut-202004181604013986.png\\\")\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242645\",\"updated\":\"1583242645\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-11\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"999250000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604404921),
(5, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '[]', '{\"name\":\"TestProject\",\"org_id\":\"1\",\"key\":\"testproject\",\"lead\":\"1\",\"description\":\"\",\"project_tpl_id\":1,\"category\":0,\"url\":\"\",\"create_time\":1604924929,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '127.0.0.1', 1604924929),
(6, 1, '事项', 139, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"139\",\"pkey\":\"example\",\"issue_num\":\"139\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12167\",\"summary\":\"\\u5546\\u57ce\\u6a21\\u5757\\u7f16\\u7801\",\"description\":\"![1cut-202004181604013986.png](\\/attachment\\/image\\/20200418\\/1cut-202004181604013986.png \\\"\\u622a\\u56fe-1cut-202004181604013986.png\\\")\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242645\",\"updated\":\"1583242645\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-11\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"300000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"999250000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"139\",\"pkey\":\"example\",\"issue_num\":\"139\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12167\",\"summary\":\"\\u5546\\u57ce\\u6a21\\u5757\\u7f16\\u7801\",\"description\":\"![1cut-202004181604013986.png](\\/attachment\\/image\\/20200418\\/1cut-202004181604013986.png \\\"\\u622a\\u56fe-1cut-202004181604013986.png\\\")\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242645\",\"updated\":\"1583242645\",\"start_date\":\"2020-11-10\",\"due_date\":\"2020-11-13\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"300000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"999250000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974636),
(7, 1, '事项', 120, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"120\",\"pkey\":\"example\",\"issue_num\":\"120\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4f18\\u5316\\u6539\\u8fdb\\u4e8b\\u98792\",\"description\":\"![](http:\\/\\/www.masterlab21.com\\/attachment\\/image\\/20200622\\/20200622195934_26594.jpg)\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583232765\",\"updated\":\"1583232765\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-11\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"2\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999900000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"120\",\"pkey\":\"example\",\"issue_num\":\"120\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4f18\\u5316\\u6539\\u8fdb\\u4e8b\\u98792\",\"description\":\"![](http:\\/\\/www.masterlab21.com\\/attachment\\/image\\/20200622\\/20200622195934_26594.jpg)\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583232765\",\"updated\":\"1583232765\",\"start_date\":\"2020-11-16\",\"due_date\":\"2020-11-17\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"2\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999900000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974652),
(8, 1, '事项', 116, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"116\",\"pkey\":\"example\",\"issue_num\":\"116\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u65e5\\u5fd7\\u6a21\\u5757\\u5f00\\u53d1x\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583044099\",\"updated\":\"1583079970\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-03-27\",\"duration\":\"20\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1400000\",\"assistants\":\"12165,12166\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"1\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998400000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"116\",\"pkey\":\"example\",\"issue_num\":\"116\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u65e5\\u5fd7\\u6a21\\u5757\\u5f00\\u53d1x\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583044099\",\"updated\":\"1583079970\",\"start_date\":\"2020-11-17\",\"due_date\":\"2020-11-18\",\"duration\":\"20\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1400000\",\"assistants\":\"12165,12166\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"1\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998400000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974665),
(9, 1, '事项', 108, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"108\",\"pkey\":\"example\",\"issue_num\":\"108\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4ea7\\u54c1\\u6a21\\u5757\\u5f00\\u53d1\\u7f16\\u78011\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"3\",\"created\":\"1583043244\",\"updated\":\"1583043244\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-13\",\"duration\":\"9\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1200000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"4\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999300000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"108\",\"pkey\":\"example\",\"issue_num\":\"108\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4ea7\\u54c1\\u6a21\\u5757\\u5f00\\u53d1\\u7f16\\u78011\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"3\",\"created\":\"1583043244\",\"updated\":\"1583043244\",\"start_date\":\"2020-11-19\",\"due_date\":\"2020-11-20\",\"duration\":\"9\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1200000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"4\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999300000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974688),
(10, 1, '事项', 107, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"107\",\"pkey\":\"example\",\"issue_num\":\"107\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u7528\\u6237\\u6a21\\u5757\\u5f00\\u53d1\\u7f16\\u78011\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583041630\",\"updated\":\"1583041630\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-03-09\",\"duration\":\"11\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999400000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"107\",\"pkey\":\"example\",\"issue_num\":\"107\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u7528\\u6237\\u6a21\\u5757\\u5f00\\u53d1\\u7f16\\u78011\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583041630\",\"updated\":\"1583041630\",\"start_date\":\"2020-11-23\",\"due_date\":\"2020-11-24\",\"duration\":\"11\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"3\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999400000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974699),
(11, 1, '事项', 106, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"106\",\"pkey\":\"example\",\"issue_num\":\"106\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"3\",\"created\":\"1583041489\",\"updated\":\"1583041489\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-03-27\",\"duration\":\"20\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1000000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"2\",\"followed_count\":\"0\",\"comment_count\":\"1\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998700000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"106\",\"pkey\":\"example\",\"issue_num\":\"106\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"3\",\"created\":\"1583041489\",\"updated\":\"1583041489\",\"start_date\":\"2020-11-25\",\"due_date\":\"2020-11-27\",\"duration\":\"20\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1000000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"2\",\"followed_count\":\"0\",\"comment_count\":\"1\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998700000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974712),
(12, 1, '事项', 97, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"97\",\"pkey\":\"example\",\"issue_num\":\"97\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6d41\\u7a0b\\u56fe\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582993719\",\"updated\":\"1582993719\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-03-20\",\"duration\":\"15\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"900000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"2\",\"depends\":\"\",\"gant_sprint_weight\":\"999000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"97\",\"pkey\":\"example\",\"issue_num\":\"97\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6d41\\u7a0b\\u56fe\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582993719\",\"updated\":\"1582993719\",\"start_date\":\"2020-11-30\",\"due_date\":\"2020-3-20\",\"duration\":\"15\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"900000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"2\",\"depends\":\"\",\"gant_sprint_weight\":\"999000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974724),
(13, 1, '事项', 97, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"97\",\"pkey\":\"example\",\"issue_num\":\"97\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6d41\\u7a0b\\u56fe\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582993719\",\"updated\":\"1582993719\",\"start_date\":\"2020-11-30\",\"due_date\":\"2020-03-20\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"900000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"2\",\"depends\":\"\",\"gant_sprint_weight\":\"999000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"97\",\"pkey\":\"example\",\"issue_num\":\"97\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6d41\\u7a0b\\u56fe\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582993719\",\"updated\":\"1582993719\",\"start_date\":\"2020-12-1\",\"due_date\":\"2020-12-2\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"900000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"2\",\"depends\":\"\",\"gant_sprint_weight\":\"999000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604974737),
(14, 1, '事项', 96, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"96\",\"pkey\":\"example\",\"issue_num\":\"96\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"UI\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"3\",\"created\":\"1582993557\",\"updated\":\"1582993557\",\"start_date\":\"2020-03-01\",\"due_date\":\"2020-03-13\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"800000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998900000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"96\",\"pkey\":\"example\",\"issue_num\":\"96\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"UI\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"3\",\"created\":\"1582993557\",\"updated\":\"1582993557\",\"start_date\":\"2020-12-4\",\"due_date\":\"2020-12-5\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"800000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998900000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975363),
(15, 1, '事项', 95, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"95\",\"pkey\":\"example\",\"issue_num\":\"95\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4ea4\\u4e92\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582993508\",\"updated\":\"1582993508\",\"start_date\":\"2020-03-09\",\"due_date\":\"2020-03-20\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"700000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"999100000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"95\",\"pkey\":\"example\",\"issue_num\":\"95\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4ea4\\u4e92\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582993508\",\"updated\":\"1582993508\",\"start_date\":\"2020-12-7\",\"due_date\":\"2020-12-8\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"700000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"999100000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975370),
(16, 1, '事项', 94, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"94\",\"pkey\":\"example\",\"issue_num\":\"94\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u5e02\\u573a\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\\r\\n\\u8fd9\\u91cc\\u8f93\\u5165\\u5bf9bug\\u505a\\u51fa\\u6e05\\u6670\\u7b80\\u6d01\\u7684\\u63cf\\u8ff0.\\r\\n\\r\\n**\\u91cd\\u73b0\\u6b65\\u9aa4**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n4. xxxxxx\\r\\n\\r\\n**\\u671f\\u671b\\u7ed3\\u679c**\\r\\n\\u7b80\\u6d01\\u6e05\\u6670\\u7684\\u63cf\\u8ff0\\u671f\\u671b\\u7ed3\\u679c\\r\\n\\r\\n**\\u5b9e\\u9645\\u7ed3\\u679c**\\r\\n\\u7b80\\u8ff0\\u5b9e\\u9645\\u770b\\u5230\\u7684\\u7ed3\\u679c\\uff0c\\u8fd9\\u91cc\\u53ef\\u4ee5\\u914d\\u4e0a\\u622a\\u56fe\\r\\n\\r\\n\\r\\n**\\u9644\\u52a0\\u8bf4\\u660e**\\r\\n\\u9644\\u52a0\\u6216\\u989d\\u5916\\u7684\\u4fe1\\u606f\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"6\",\"created\":\"1582992127\",\"updated\":\"1582992127\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"s', '{\"id\":\"94\",\"pkey\":\"example\",\"issue_num\":\"94\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u5e02\\u573a\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\\r\\n\\u8fd9\\u91cc\\u8f93\\u5165\\u5bf9bug\\u505a\\u51fa\\u6e05\\u6670\\u7b80\\u6d01\\u7684\\u63cf\\u8ff0.\\r\\n\\r\\n**\\u91cd\\u73b0\\u6b65\\u9aa4**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n4. xxxxxx\\r\\n\\r\\n**\\u671f\\u671b\\u7ed3\\u679c**\\r\\n\\u7b80\\u6d01\\u6e05\\u6670\\u7684\\u63cf\\u8ff0\\u671f\\u671b\\u7ed3\\u679c\\r\\n\\r\\n**\\u5b9e\\u9645\\u7ed3\\u679c**\\r\\n\\u7b80\\u8ff0\\u5b9e\\u9645\\u770b\\u5230\\u7684\\u7ed3\\u679c\\uff0c\\u8fd9\\u91cc\\u53ef\\u4ee5\\u914d\\u4e0a\\u622a\\u56fe\\r\\n\\r\\n\\r\\n**\\u9644\\u52a0\\u8bf4\\u660e**\\r\\n\\u9644\\u52a0\\u6216\\u989d\\u5916\\u7684\\u4fe1\\u606f\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"6\",\"created\":\"1582992127\",\"updated\":\"1582992127\",\"start_date\":\"2020-12-8\",\"due_date\":\"2020-12-9\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"spr', '127.0.0.1', 1604975378),
(17, 1, '事项', 94, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"94\",\"pkey\":\"example\",\"issue_num\":\"94\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u5e02\\u573a\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\\r\\n\\u8fd9\\u91cc\\u8f93\\u5165\\u5bf9bug\\u505a\\u51fa\\u6e05\\u6670\\u7b80\\u6d01\\u7684\\u63cf\\u8ff0.\\r\\n\\r\\n**\\u91cd\\u73b0\\u6b65\\u9aa4**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n4. xxxxxx\\r\\n\\r\\n**\\u671f\\u671b\\u7ed3\\u679c**\\r\\n\\u7b80\\u6d01\\u6e05\\u6670\\u7684\\u63cf\\u8ff0\\u671f\\u671b\\u7ed3\\u679c\\r\\n\\r\\n**\\u5b9e\\u9645\\u7ed3\\u679c**\\r\\n\\u7b80\\u8ff0\\u5b9e\\u9645\\u770b\\u5230\\u7684\\u7ed3\\u679c\\uff0c\\u8fd9\\u91cc\\u53ef\\u4ee5\\u914d\\u4e0a\\u622a\\u56fe\\r\\n\\r\\n\\r\\n**\\u9644\\u52a0\\u8bf4\\u660e**\\r\\n\\u9644\\u52a0\\u6216\\u989d\\u5916\\u7684\\u4fe1\\u606f\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"6\",\"created\":\"1582992127\",\"updated\":\"1582992127\",\"start_date\":\"2020-12-08\",\"due_date\":\"2020-12-09\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"s', '{\"id\":\"94\",\"pkey\":\"example\",\"issue_num\":\"94\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u5e02\\u573a\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\\r\\n\\u8fd9\\u91cc\\u8f93\\u5165\\u5bf9bug\\u505a\\u51fa\\u6e05\\u6670\\u7b80\\u6d01\\u7684\\u63cf\\u8ff0.\\r\\n\\r\\n**\\u91cd\\u73b0\\u6b65\\u9aa4**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n4. xxxxxx\\r\\n\\r\\n**\\u671f\\u671b\\u7ed3\\u679c**\\r\\n\\u7b80\\u6d01\\u6e05\\u6670\\u7684\\u63cf\\u8ff0\\u671f\\u671b\\u7ed3\\u679c\\r\\n\\r\\n**\\u5b9e\\u9645\\u7ed3\\u679c**\\r\\n\\u7b80\\u8ff0\\u5b9e\\u9645\\u770b\\u5230\\u7684\\u7ed3\\u679c\\uff0c\\u8fd9\\u91cc\\u53ef\\u4ee5\\u914d\\u4e0a\\u622a\\u56fe\\r\\n\\r\\n\\r\\n**\\u9644\\u52a0\\u8bf4\\u660e**\\r\\n\\u9644\\u52a0\\u6216\\u989d\\u5916\\u7684\\u4fe1\\u606f\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"6\",\"created\":\"1582992127\",\"updated\":\"1582992127\",\"start_date\":\"2020-12-9\",\"due_date\":\"2020-12-10\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sp', '127.0.0.1', 1604975384),
(18, 1, '事项', 90, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"90\",\"pkey\":\"example\",\"issue_num\":\"90\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4ea7\\u54c1\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"6\",\"created\":\"1582983902\",\"updated\":\"1582983902\",\"start_date\":\"2020-02-28\",\"due_date\":\"2020-03-03\",\"duration\":\"3\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"4\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"90\",\"pkey\":\"example\",\"issue_num\":\"90\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4ea7\\u54c1\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"6\",\"created\":\"1582983902\",\"updated\":\"1582983902\",\"start_date\":\"2020-12-11\",\"due_date\":\"2020-12-14\",\"duration\":\"3\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"4\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975395),
(19, 1, '事项', 87, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"87\",\"pkey\":\"example\",\"issue_num\":\"87\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"\\u4ea7\\u54c1\\u529f\\u80fd\\u8bf4\\u660e\\u4e66\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1582693628\",\"updated\":\"1582693628\",\"start_date\":\"2020-03-01\",\"due_date\":\"2020-03-16\",\"duration\":\"11\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"998800000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"87\",\"pkey\":\"example\",\"issue_num\":\"87\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"\\u4ea7\\u54c1\\u529f\\u80fd\\u8bf4\\u660e\\u4e66\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1582693628\",\"updated\":\"1582693628\",\"start_date\":\"2020-12-15\",\"due_date\":\"2020-12-16\",\"duration\":\"11\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"998800000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975403),
(20, 1, '事项', 64, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"64\",\"pkey\":\"example\",\"issue_num\":\"64\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"\\u524d\\u7aef\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582623716\",\"updated\":\"1582623716\",\"start_date\":\"2020-03-04\",\"due_date\":\"2020-03-06\",\"duration\":\"3\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"500000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"1\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998600000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"64\",\"pkey\":\"example\",\"issue_num\":\"64\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"\\u524d\\u7aef\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582623716\",\"updated\":\"1582623716\",\"start_date\":\"2020-12-16\",\"due_date\":\"2020-12-17\",\"duration\":\"3\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"500000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"1\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998600000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975414),
(21, 1, '事项', 54, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"54\",\"pkey\":\"example\",\"issue_num\":\"54\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"ER\\u5173\\u7cfb\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582602962\",\"updated\":\"1582602962\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-06\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"400000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"54\",\"pkey\":\"example\",\"issue_num\":\"54\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"ER\\u5173\\u7cfb\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582602962\",\"updated\":\"1582602962\",\"start_date\":\"2020-12-21\",\"due_date\":\"2020-12-22\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"400000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975456),
(22, 1, '事项', 53, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"53\",\"pkey\":\"example\",\"issue_num\":\"53\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4f18\\u5316\\u6539\\u8fdb\\u4e8b\\u98791\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582602961\",\"updated\":\"1582602961\",\"start_date\":\"2020-01-17\",\"due_date\":\"2020-02-29\",\"duration\":\"31\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"2\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"5\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"53\",\"pkey\":\"example\",\"issue_num\":\"53\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u4f18\\u5316\\u6539\\u8fdb\\u4e8b\\u98791\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1582602961\",\"updated\":\"1582602961\",\"start_date\":\"2020-12-23\",\"due_date\":\"2020-12-24\",\"duration\":\"31\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"2\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"5\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975469),
(23, 1, '事项', 8, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"8\",\"pkey\":\"example\",\"issue_num\":\"8\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6280\\u672f\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1582199367\",\"updated\":\"1582199367\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"5\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"8\",\"pkey\":\"example\",\"issue_num\":\"8\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6280\\u672f\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1582199367\",\"updated\":\"1582199367\",\"start_date\":\"2020-12-25\",\"due_date\":\"2020-12-28\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"5\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"1000000000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975476),
(24, 1, '事项', 5, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"5\",\"pkey\":\"example\",\"issue_num\":\"5\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12165\",\"summary\":\"\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1581321497\",\"updated\":\"1581321497\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-04\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"3\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998300000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"5\",\"pkey\":\"example\",\"issue_num\":\"5\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12165\",\"summary\":\"\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1581321497\",\"updated\":\"1581321497\",\"start_date\":\"2020-4-29\",\"due_date\":\"2020-4-30\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"3\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998300000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975485),
(25, 1, '事项', 5, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"5\",\"pkey\":\"example\",\"issue_num\":\"5\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12165\",\"summary\":\"\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1581321497\",\"updated\":\"1581321497\",\"start_date\":\"2020-04-29\",\"due_date\":\"2020-04-30\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"3\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998300000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"5\",\"pkey\":\"example\",\"issue_num\":\"5\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12165\",\"summary\":\"\\u53ef\\u884c\\u6027\\u5206\\u6790\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1581321497\",\"updated\":\"1581321497\",\"start_date\":\"2020-12-29\",\"due_date\":\"2020-12-30\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"3\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"998300000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975501),
(26, 1, '事项', 4, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"4\",\"pkey\":\"example\",\"issue_num\":\"4\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6570\\u636e\\u5e93\\u8868\\u7ed3\\u6784\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423320\",\"updated\":\"1583079970\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-01-01\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"200000\",\"sprint_weight\":\"1300000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999800000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"4\",\"pkey\":\"example\",\"issue_num\":\"4\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u6570\\u636e\\u5e93\\u8868\\u7ed3\\u6784\\u8bbe\\u8ba1\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423320\",\"updated\":\"1583079970\",\"start_date\":\"2021-4-5\",\"due_date\":\"2021-4-6\",\"duration\":\"0\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"200000\",\"sprint_weight\":\"1300000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999800000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975531),
(27, 1, '事项', 3, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"3\",\"pkey\":\"example\",\"issue_num\":\"3\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12168\",\"summary\":\"\\u4e1a\\u52a1\\u6a21\\u5757\\u5f00\\u53d1\",\"description\":\"xxxxx\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1579423228\",\"updated\":\"1579423228\",\"start_date\":\"2020-01-20\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"60\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"4\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999500000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"3\",\"pkey\":\"example\",\"issue_num\":\"3\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12168\",\"summary\":\"\\u4e1a\\u52a1\\u6a21\\u5757\\u5f00\\u53d1\",\"description\":\"xxxxx\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1579423228\",\"updated\":\"1579423228\",\"start_date\":\"2021-1-6\",\"due_date\":\"2021-1-7\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"60\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"4\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999500000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975547),
(28, 1, '事项', 2, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"2\",\"pkey\":\"example\",\"issue_num\":\"2\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"xxxxxxxxxxxxxxxxxxxxx\\r\\n1**xxxxxxxx**\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579250062\",\"updated\":\"1582133914\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-06\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"1\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"80\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1800000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"998500000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"2\",\"pkey\":\"example\",\"issue_num\":\"2\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"xxxxxxxxxxxxxxxxxxxxx\\r\\n1**xxxxxxxx**\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579250062\",\"updated\":\"1582133914\",\"start_date\":\"2021-3-8\",\"due_date\":\"2021-3-9\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"1\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"80\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1800000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"998500000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975562);
INSERT INTO `log_operating` (`id`, `project_id`, `module`, `obj_id`, `uid`, `user_name`, `real_name`, `page`, `pre_status`, `cur_status`, `action`, `remark`, `pre_data`, `cur_data`, `ip`, `time`) VALUES
(29, 1, '事项', 2, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"2\",\"pkey\":\"example\",\"issue_num\":\"2\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"xxxxxxxxxxxxxxxxxxxxx\\r\\n1**xxxxxxxx**\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579250062\",\"updated\":\"1582133914\",\"start_date\":\"2021-03-08\",\"due_date\":\"2021-03-09\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"1\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"80\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1800000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"998500000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"2\",\"pkey\":\"example\",\"issue_num\":\"2\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u67b6\\u6784\\u8bbe\\u8ba1\",\"description\":\"xxxxxxxxxxxxxxxxxxxxx\\r\\n1**xxxxxxxx**\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579250062\",\"updated\":\"1582133914\",\"start_date\":\"2021-1-7\",\"due_date\":\"2021-1-8\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"1\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"80\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1800000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"998500000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975576),
(30, 1, '事项', 1, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"1\",\"pkey\":\"example\",\"issue_num\":\"1\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"\\u6570\\u636e\\u5e93\\u8bbe\\u8ba1\",\"description\":\"xxxxxx\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579249719\",\"updated\":\"1582133907\",\"start_date\":\"2020-01-17\",\"due_date\":\"2020-01-30\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"80\",\"backlog_weight\":\"100000\",\"sprint_weight\":\"1600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"3\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999900000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"1\",\"pkey\":\"example\",\"issue_num\":\"1\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"\\u6570\\u636e\\u5e93\\u8bbe\\u8ba1\",\"description\":\"xxxxxx\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579249719\",\"updated\":\"1582133907\",\"start_date\":\"2021-1-18\",\"due_date\":\"2021-1-19\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"80\",\"backlog_weight\":\"100000\",\"sprint_weight\":\"1600000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"3\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"999900000\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1604975597);

-- --------------------------------------------------------

--
-- 表的结构 `log_runtime_error`
--

CREATE TABLE `log_runtime_error` (
                                     `id` int UNSIGNED NOT NULL,
                                     `md5` varchar(32) NOT NULL,
                                     `file` varchar(255) NOT NULL,
                                     `line` smallint UNSIGNED NOT NULL,
                                     `time` int UNSIGNED NOT NULL,
                                     `date` date NOT NULL,
                                     `err` varchar(32) NOT NULL DEFAULT '',
                                     `errstr` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_action`
--

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
                               `actionnum` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_activity`
--

CREATE TABLE `main_activity` (
                                 `id` int UNSIGNED NOT NULL,
                                 `user_id` int UNSIGNED DEFAULT NULL,
                                 `project_id` int UNSIGNED DEFAULT NULL,
                                 `action` varchar(32) DEFAULT NULL COMMENT '动作说明,如 关闭了，创建了，修复了',
                                 `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容',
                                 `type` enum('agile','user','issue','issue_comment','org','project') DEFAULT 'issue' COMMENT 'project,issue,user,agile,issue_comment',
                                 `obj_id` int UNSIGNED DEFAULT NULL,
                                 `title` varchar(128) DEFAULT NULL COMMENT '相关的事项标题',
                                 `date` date DEFAULT NULL,
                                 `time` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_announcement`
--

CREATE TABLE `main_announcement` (
                                     `id` int UNSIGNED NOT NULL,
                                     `content` varchar(255) DEFAULT NULL,
                                     `status` tinyint UNSIGNED DEFAULT '0' COMMENT '0为禁用,1为发布中',
                                     `flag` int DEFAULT '0' COMMENT '每次发布将自增该字段',
                                     `expire_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_cache_key`
--

CREATE TABLE `main_cache_key` (
                                  `key` varchar(100) NOT NULL,
                                  `module` varchar(64) DEFAULT NULL,
                                  `datetime` datetime DEFAULT NULL,
                                  `expire` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_eventtype`
--

CREATE TABLE `main_eventtype` (
                                  `id` decimal(18,0) NOT NULL,
                                  `template_id` decimal(18,0) DEFAULT NULL,
                                  `name` varchar(255) DEFAULT NULL,
                                  `description` text,
                                  `event_type` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_group`
--

CREATE TABLE `main_group` (
                              `id` int NOT NULL,
                              `name` varchar(255) DEFAULT NULL,
                              `active` int DEFAULT NULL,
                              `created_date` datetime DEFAULT NULL,
                              `updated_date` datetime DEFAULT NULL,
                              `description` varchar(255) DEFAULT NULL,
                              `group_type` varchar(60) DEFAULT NULL,
                              `directory_id` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_group`
--

INSERT INTO `main_group` (`id`, `name`, `active`, `created_date`, `updated_date`, `description`, `group_type`, `directory_id`) VALUES
(1, 'administrators', 1, NULL, NULL, NULL, '1', NULL),
(2, 'developers', 1, NULL, NULL, NULL, '1', NULL),
(3, 'users', 1, NULL, NULL, NULL, '1', NULL),
(4, 'qas', 1, NULL, NULL, NULL, '1', NULL),
(5, 'ui-designers', 1, NULL, NULL, NULL, '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `main_mail_queue`
--

CREATE TABLE `main_mail_queue` (
                                   `id` int UNSIGNED NOT NULL,
                                   `seq` varchar(32) DEFAULT NULL,
                                   `title` varchar(100) DEFAULT NULL,
                                   `address` varchar(200) DEFAULT NULL,
                                   `status` varchar(10) DEFAULT NULL,
                                   `create_time` int UNSIGNED DEFAULT NULL,
                                   `error` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_mail_queue`
--

INSERT INTO `main_mail_queue` (`id`, `seq`, `title`, `address`, `status`, `create_time`, `error`) VALUES
(1, '1591062920170', 'default/ex (189) XXXXXXXXXXXXXXX', '121642038@qq.com;797206999@qq.com', 'ready', 1591062920, ''),
(2, '1591063059169', 'default/ex (189) XXXXXXXXXXXXXXX', '121642038@qq.com;797206999@qq.com', 'ready', 1591063059, ''),
(3, '1591187233335', 'default/example (190) 1111111', '121642038@qq.com', 'error', 1591187234, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `main_notify_scheme`
--

CREATE TABLE `main_notify_scheme` (
                                      `id` int NOT NULL,
                                      `name` varchar(20) NOT NULL,
                                      `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_notify_scheme`
--

INSERT INTO `main_notify_scheme` (`id`, `name`, `is_system`) VALUES
(1, '默认通知方案', 1);

-- --------------------------------------------------------

--
-- 表的结构 `main_notify_scheme_data`
--

CREATE TABLE `main_notify_scheme_data` (
                                           `id` int UNSIGNED NOT NULL,
                                           `scheme_id` int UNSIGNED NOT NULL,
                                           `name` varchar(20) NOT NULL,
                                           `flag` varchar(128) DEFAULT NULL,
                                           `user` varchar(1024) NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人',
                                           `title_tpl` varchar(128) NOT NULL DEFAULT '',
                                           `body_tpl` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_notify_scheme_data`
--

INSERT INTO `main_notify_scheme_data` (`id`, `scheme_id`, `name`, `flag`, `user`, `title_tpl`, `body_tpl`) VALUES
(1, 1, '事项创建', 'issue@create', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '<br>\r\n\r\n{display_name} 创建了事项 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(2, 1, '事项更新', 'issue@update', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 更新了 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(3, 1, '事项分配', 'issue@assign', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 更新了 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(4, 1, '事项已解决', 'issue@resolve@complete', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 更新了 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(5, 1, '事项已关闭', 'issue@close', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 更新了 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(6, 1, '事项评论', 'issue@comment@create', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '<br><br>  [ {issue_link} ]<br>\r\n\r\n{display_name} 评论了  {issue_title}<br>\r\n> --------------------------------------<br>\r\n><br>\r\n>     {comment_content}<br>\r\n>  <br>\r\n\r\n\r\n\r\n<br><br>\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(7, 1, '删除评论', 'issue@comment@remove', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '<br><br>  [ {issue_link} ]<br>\r\n\r\n{display_name} 删除评论  {issue_title}<br>\r\n> --------------------------------------<br>\r\n><br>\r\n>     {comment_content}<br>\r\n>  <br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(8, 1, '开始解决事项', 'issue@resolve@start', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 更新了 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(9, 1, '停止解决事项', 'issue@resolve@stop', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 更新了 {issue_title}<br>\r\n> --------------------------------------<br>\r\n>\r\n>    键值: {issue_key}<br>\r\n>    网址: {issue_link}<br>\r\n>    项目: {project_title}<br>\r\n>    问题类型: {issue_type_title}<br>\r\n>    模块: {issue_module_title}<br>\r\n>    报告人: {report_display_name}<br>\r\n>    经办人: {assignee_display_name}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(10, 1, '新增迭代', 'sprint@create', '[\"project\"]', '{project_path}  {sprint_title}', ' <br><br>\r\n\r\n{display_name} 新增迭代： {sprint_title}:<br>\r\n \r\n\r\n> --------------------------------------<br>\r\n><br>\r\n>    项目: {project_title}<br>\r\n>    开始日期: {sprint_start_date}<br>\r\n>    截止日期: {sprint_end_date}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(11, 1, '设置迭代进行时', 'sprint@start', '[\"project\"]', '{project_path}  {sprint_title}', ' <br><br>\r\n\r\n{display_name} 更新了迭代： {sprint_title}:<br>\r\n \r\n\r\n> --------------------------------------<br>\r\n><br>\r\n>    项目: {project_title}<br>\r\n>    开始日期: {sprint_start_date}<br>\r\n>    截止日期: {sprint_end_date}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(12, 1, '删除迭代', 'sprint@remove', '[\"project\"]', '{project_path}  {sprint_title}', ' \r\n<br>\r\n{display_name} 删除迭代： {sprint_title}:<br>\r\n<br>\r\n<br>\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(13, 1, '更新迭代', 'sprint@update', '[\"project\"]', '{project_path}  {sprint_title}', ' <br><br>\r\n\r\n{display_name} 更新了迭代： {sprint_title}:<br>\r\n \r\n\r\n> --------------------------------------<br>\r\n><br>\r\n>    项目: {project_title}<br>\r\n>    开始日期: {sprint_start_date}<br>\r\n>    截止日期: {sprint_end_date}<br>\r\n\r\n><br>\r\n><br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>'),
(14, 1, '事项已删除', 'issue@delete', '[\"assigee\",\"reporter\",\"follow\"]', '{project_path} ({issue_key}) {issue_title}', '\r\n<br>\r\n{display_name} 删除了事项<br>\r\n\r\n\r\n\r\n\r\n--<br>\r\n这条信息是由Masterlab发送的<br>\r\n(v2.1.4)<br>');

-- --------------------------------------------------------

--
-- 表的结构 `main_org`
--

CREATE TABLE `main_org` (
                            `id` int NOT NULL,
                            `path` varchar(64) NOT NULL DEFAULT '',
                            `name` varchar(64) NOT NULL DEFAULT '',
                            `description` text NOT NULL,
                            `avatar` varchar(256) NOT NULL DEFAULT '',
                            `create_uid` int NOT NULL DEFAULT '0',
                            `created` int UNSIGNED NOT NULL DEFAULT '0',
                            `updated` int UNSIGNED NOT NULL DEFAULT '0',
                            `scope` tinyint NOT NULL DEFAULT '1' COMMENT '1 private, 2 internal , 3 public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_org`
--

INSERT INTO `main_org` (`id`, `path`, `name`, `description`, `avatar`, `create_uid`, `created`, `updated`, `scope`) VALUES
(1, 'default', 'Default', 'Default organization', 'org/default.jpg', 0, 0, 1535263464, 3);

-- --------------------------------------------------------

--
-- 表的结构 `main_plugin`
--

CREATE TABLE `main_plugin` (
                               `id` int UNSIGNED NOT NULL,
                               `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `title` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `index_page` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `description` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `version` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1已安装,2未安装,0无效(插件目录不存在)',
                               `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `chmod_json` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `icon_file` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `company` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `install_time` int UNSIGNED NOT NULL DEFAULT '0',
                               `order_weight` int UNSIGNED NOT NULL DEFAULT '0',
                               `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0',
                               `enable` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否启用',
                               `is_display` tinyint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `main_plugin`
--

INSERT INTO `main_plugin` VALUES (1, 'activity', '活动日志', 'ctrl@index@pageIndex', '默认自带的插件：活动日志', '1.0', 1, 'project_module', '', 'http://www.masterlab.vip', '/attachment/plugin/1.png', 'Masterlab官方', 0, 0, 1, 1, 1);
INSERT INTO `main_plugin` VALUES (22, 'webhook', 'webhook', '', '默认自带的插件：webhook', '1.0', 1, 'admin_module', '', 'http://www.masterlab.vip', '/attachment/plugin/webhook.png', 'Masterlab官方', 0, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `main_setting`
--

CREATE TABLE `main_setting` (
                                `id` int NOT NULL,
                                `_key` varchar(50) NOT NULL COMMENT '关键字',
                                `title` varchar(64) NOT NULL COMMENT '标题',
                                `module` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块,basic,advance,ui,datetime,languge,attachment可选',
                                `order_weight` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重',
                                `_value` varchar(100) NOT NULL,
                                `default_value` varchar(100) DEFAULT '' COMMENT '默认值',
                                `format` enum('string','int','float','json') NOT NULL DEFAULT 'string' COMMENT '数据类型',
                                `form_input_type` enum('datetime','date','textarea','select','checkbox','radio','img','color','file','int','number','text') DEFAULT 'text' COMMENT '表单项类型',
                                `form_optional_value` varchar(5000) DEFAULT NULL COMMENT '待选的值定义,为json格式',
                                `description` varchar(200) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

--
-- 转存表中的数据 `main_setting`
--

INSERT INTO `main_setting` (`id`, `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
(1, 'title', '网站的页面标题', 'basic', 0, 'Masterlab', 'MasterLab', 'string', 'text', NULL, ''),
(2, 'open_status', '启用状态', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(3, 'max_login_error', '最大尝试验证登录次数', 'basic', 0, '4', '4', 'int', 'text', NULL, ''),
(4, 'login_require_captcha', '登录时需要验证码', 'basic', 0, '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(5, 'reg_require_captcha', '注册时需要验证码', 'basic', 0, '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(6, 'sender_format', '邮件发件人显示格式', 'basic', 0, '${fullname} (Masterlab)', '${fullname} (Hornet)', 'string', 'text', NULL, ''),
(7, 'description', '说明', 'basic', 0, '', '', 'string', 'text', NULL, ''),
(8, 'date_timezone', '默认用户时区', 'basic', 0, 'Asia/Shanghai', 'Asia/Shanghai', 'string', 'text', '', ''),
(11, 'allow_share_public', '允许用户分享过滤器或面部', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(12, 'max_project_name', '项目名称最大长度', 'basic', 0, '80', '80', 'int', 'text', NULL, ''),
(13, 'max_project_key', '项目键值最大长度', 'basic', 0, '20', '20', 'int', 'text', NULL, ''),
(15, 'email_public', '邮件地址可见性', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(24, 'send_mail_format', '默认发送个邮件的格式', 'user_default', 0, 'text', 'text', 'string', 'radio', '{\"text\":\"text\",\"html\":\"html\"}', ''),
(25, 'issue_page_size', '事项分页数量', 'user_default', 0, '100', '100', 'int', 'text', NULL, ''),
(39, 'time_format', '时间格式', 'datetime', 0, 'H:i:s', 'HH:mm:ss', 'string', 'text', NULL, '例如 11:55:47'),
(40, 'week_format', '星期格式', 'datetime', 0, 'l H:i:s', 'EEEE HH:mm:ss', 'string', 'text', NULL, '例如 Wednesday 11:55:47'),
(41, 'full_datetime_format', '完整日期/时间格式', 'datetime', 0, 'Y-m-d H:i:s', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', NULL, '例如 2007-05-23  11:55:47'),
(42, 'datetime_format', '日期格式(年月日)', 'datetime', 0, 'Y-m-d', 'yyyy-MM-dd', 'string', 'text', NULL, '例如 2007-05-23'),
(43, 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天'),
(45, 'attachment_dir', '附件路径', 'attachment_hide', 0, '{{PUBLIC_PATH}}attachment', '{{PUBLIC_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下'),
(46, 'attachment_size', '附件大小(单位M)', 'attachment', 0, '128.0', '10.0', 'float', 'text', NULL, '超过大小,无法上传,修改该值后同时还要修改 php.ini 的 post_max_size 和 upload_max_filesize'),
(47, 'enbale_thum', '启用缩略图', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图'),
(48, 'enable_zip', '启用ZIP支持', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载'),
(49, 'password_strategy', '密码策略', 'password_strategy', 0, '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', ''),
(50, 'send_mailer', '发信人邮箱', 'mail', 940, 'xx@163.com', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 930, 'Masterlab', '', 'string', 'text', NULL, ''),
(52, 'mail_host', 'SMTP服务器', 'mail', 999, 'smtp.163.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', 980, '25', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 970, 'xxx@163.com', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 960, 'XJXMSWLVCWDMPCEI1', '', 'string', 'text', NULL, ''),
(56, 'mail_timeout', '发送超时', 'mail', 950, '10', '', 'int', 'text', NULL, ''),
(57, 'page_layout', '页面布局', 'user_default', 0, 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', ''),
(58, 'project_view', '项目默认显示页', 'user_default', 0, 'issues', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', ''),
(59, 'company', '公司名称(暂不可用)', 'basic', 0, 'name', '', 'string', 'text', NULL, ''),
(60, 'company_logo', '公司logo(暂不可用)', 'basic', 0, 'logo', '', 'string', 'text', NULL, ''),
(61, 'company_linkman', '联系人', 'basic', 0, '18002516775', '', 'string', 'text', NULL, ''),
(62, 'company_phone', '联系电话', 'basic', 0, '135255256541', '', 'string', 'text', NULL, ''),
(63, 'enable_async_mail', '是否使用异步方式发送邮件', 'mail', 890, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(64, 'enable_mail', '是否开启邮件推送', 'mail', 1024, '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(70, 'socket_server_host', 'MasterlabSocket服务器地址', 'mail', 880, '127.0.0.1', '127.0.0.1', 'string', 'text', NULL, ''),
(71, 'socket_server_port', 'MasterlabSocket服务器端口', 'mail', 870, '9002', '9002', 'int', 'text', NULL, ''),
(72, 'allow_user_reg', '允许用户注册', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户'),
(73, 'ldap_hosts', '服务器地址', 'ldap', 94, '192.168.0.129', '', 'string', 'text', NULL, ''),
(74, 'ldap_port', '服务器端口', 'ldap', 90, '389', '389', 'int', 'text', NULL, ''),
(75, 'ldap_schema', '服务器类型', 'ldap', 96, 'OpenLDAP', 'ActiveDirectory', 'string', 'select', '{\"ActiveDirectory\":\"ActiveDirectory\",\"OpenLDAP\":\"OpenLDAP\",\"FreeIPA\": \"FreeIPA\"}', ''),
(76, 'ldap_username', '管理员DN值', 'ldap', 70, 'CN=Administrator,CN=Users,DC=extest,DC=cn', 'cn=Manager,dc=masterlab,dc=vip', 'string', 'text', NULL, ''),
(77, 'ldap_password', '管理员密码', 'ldap', 60, 'testtest', '', 'string', 'text', NULL, ''),
(78, 'ldap_base_dn', 'BASE_DN', 'ldap', 76, 'dc=extest,dc=cn', 'dc=masterlab,dc=vip', 'string', 'text', NULL, '不能为空'),
(79, 'ldap_timeout', '连接超时时间', 'ldap', 88, '10', '10', 'string', 'text', NULL, ''),
(80, 'ldap_version', '版本', 'ldap', 80, '3', '3', 'string', 'text', NULL, ''),
(81, 'ldap_security protocol', '安全协议', 'ldap', 84, '', '', 'string', 'select', '{\"\":\"普通\",\"ssl\":\"SSL\",\"tls\":\"TLS\"}', ''),
(82, 'ldap_enable', '启用', 'ldap', 99, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(83, 'ldap_match_attr', '匹配属性', 'ldap', 74, 'cn', 'cn', 'string', 'text', '', '设置什么属性作为匹配用户名，建议使用 cn 或 dn '),
(84, 'is_exchange_server', '服务器为ExchangeServer', 'mail', 910, '0', '0', 'string', 'radio', '{\"1\":\"是\",\"0\":\"否\"}', ''),
(85, 'is_ssl', 'SSL', 'mail', 920, '0', '0', 'string', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(86, 'socket_server_type', '服务器类型', 'mail', 920, 'golang', 'golang', 'string', 'radio', '{\"golang\":\"Golang\",\"swoole\":\"Swoole\"}', '异步服务的类型');

-- --------------------------------------------------------

--
-- 表的结构 `main_timeline`
--

CREATE TABLE `main_timeline` (
                                 `id` int UNSIGNED NOT NULL,
                                 `uid` int UNSIGNED NOT NULL DEFAULT '0',
                                 `type` varchar(12) NOT NULL DEFAULT '',
                                 `origin_id` int UNSIGNED NOT NULL DEFAULT '0',
                                 `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                 `issue_id` int UNSIGNED NOT NULL DEFAULT '0',
                                 `action` varchar(32) NOT NULL DEFAULT '',
                                 `action_icon` varchar(64) NOT NULL DEFAULT '',
                                 `content` text NOT NULL,
                                 `content_html` text NOT NULL,
                                 `time` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `main_webhook`
--

CREATE TABLE `main_webhook` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_json` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否启用',
  `timeout` tinyint(3) UNSIGNED NOT NULL DEFAULT '10',
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hook_event_json` text COLLATE utf8mb4_unicode_ci COMMENT '定义触发哪些事件',
  `filter_project_json` text COLLATE utf8mb4_unicode_ci COMMENT '过滤的事件'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--
-- 转存表中的数据 `main_webhook`
--

-- --------------------------------------------------------

--
-- 表的结构 `main_webhook_log`
--

CREATE TABLE `main_webhook_log` (
                                    `id` int NOT NULL,
                                    `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                    `webhook_id` int UNSIGNED NOT NULL DEFAULT '0',
                                    `event_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                                    `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                                    `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                    `status` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '0准备中;1执行成功;2异步发送失败;3队列中;4执行失败',
                                    `time` int UNSIGNED NOT NULL,
                                    `timeout` tinyint UNSIGNED NOT NULL DEFAULT '15' COMMENT '超时时间',
                                    `user_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '提交的当前用户id',
                                    `err_msg` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `main_widget`
--

CREATE TABLE `main_widget` (
                               `id` int NOT NULL COMMENT '主键id',
                               `name` varchar(255) DEFAULT NULL COMMENT '工具名称',
                               `_key` varchar(64) NOT NULL,
                               `method` varchar(64) NOT NULL DEFAULT '',
                               `module` varchar(20) NOT NULL,
                               `pic` varchar(255) NOT NULL,
                               `type` enum('list','chart_line','chart_pie','chart_bar','text') DEFAULT NULL COMMENT '工具类型',
                               `status` tinyint DEFAULT '1' COMMENT '状态（1可用，0不可用）',
                               `is_default` tinyint UNSIGNED NOT NULL DEFAULT '0',
                               `required_param` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否需要参数才能获取数据',
                               `description` varchar(512) DEFAULT '' COMMENT '描述',
                               `parameter` varchar(1024) NOT NULL DEFAULT '{}' COMMENT '支持的参数说明',
                               `order_weight` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_widget`
--

INSERT INTO `main_widget` (`id`, `name`, `_key`, `method`, `module`, `pic`, `type`, `status`, `is_default`, `required_param`, `description`, `parameter`, `order_weight`) VALUES
(1, '我参与的项目', 'my_projects', 'fetchUserHaveJoinProjects', '通用', 'my_projects.png', 'list', 1, 1, 0, '', '[]', 0),
(2, '分配给我的事项', 'assignee_my', 'fetchAssigneeIssues', '通用', 'assignee_my.png', 'list', 1, 1, 0, '', '[]', 0),
(3, '活动日志', 'activity', 'fetchActivity', '通用', 'activity.png', 'list', 1, 1, 0, '', '[]', 0),
(4, '便捷导航', 'nav', 'fetchNav', '通用', 'nav.png', 'list', 1, 1, 0, '', '[]', 0),
(5, '组织', 'org', 'fetchOrgs', '通用', 'org.png', 'list', 1, 1, 0, '', '[]', 0),
(6, '项目-汇总', 'project_stat', 'fetchProjectStat', '项目', 'project_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', 0),
(7, '项目-解决与未解决对比图', 'project_abs', 'fetchProjectAbs', '项目', 'abs.png', 'chart_bar', 1, 0, 1, '', '\r\n[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"时间\",\"field\":\"by_time\",\"type\":\"select\",\"value\":[{\"title\":\"天\",\"value\":\"date\"},{\"title\":\"周\",\"value\":\"week\"},{\"title\":\"月\",\"value\":\"month\"}]},{\"name\":\"几日之内\",\"field\":\"within_date\",\"type\":\"text\",\"value\":\"\"}]', 0),
(8, '项目-优先级统计', 'project_priority_stat', 'fetchProjectPriorityStat', '项目', 'priority_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]\r\n', 0),
(9, '项目-状态统计', 'project_status_stat', 'fetchProjectStatusStat', '项目', 'status_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', 0),
(10, '项目-开发者统计', 'project_developer_stat', 'fetchProjectDeveloperStat', '项目', 'developer_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', 0),
(11, '项目-事项统计', 'project_issue_type_stat', 'fetchProjectIssueTypeStat', '项目', 'issue_type_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]}]', 0),
(12, '项目-饼状图', 'project_pie', 'fetchProjectPie', '项目', 'chart_pie.png', 'chart_pie', 1, 0, 1, '', '[{\"name\":\"项目\",\"field\":\"project_id\",\"type\":\"my_projects_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]},{\"name\":\"开始时间\",\"field\":\"start_date\",\"type\":\"date\",\"value\":\"\"},{\"name\":\"结束时间\",\"field\":\"end_date\",\"type\":\"date\",\"value\":\"\"}]', 0),
(13, '迭代-汇总', 'sprint_stat', 'fetchSprintStat', '迭代', 'sprint_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(14, '迭代-倒计时', 'sprint_countdown', 'fetchSprintCountdown', '项目', 'countdown.png', 'text', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(15, '迭代-燃尽图', 'sprint_burndown', 'fetchSprintBurndown', '迭代', 'burndown.png', 'text', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(16, '迭代-速率图', 'sprint_speed', 'fetchSprintSpeedRate', '迭代', 'sprint_speed.png', 'text', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(17, '迭代-饼状图', 'sprint_pie', 'fetchSprintPie', '迭代', 'chart_pie.png', 'chart_pie', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"数据源\",\"field\":\"data_field\",\"type\":\"select\",\"value\":[{\"title\":\"经办人\",\"value\":\"assignee\"},{\"title\":\"优先级\",\"value\":\"priority\"},{\"title\":\"事项类型\",\"value\":\"issue_type\"},{\"title\":\"状态\",\"value\":\"status\"}]}]', 0),
(18, '迭代-解决与未解决对比图', 'sprint_abs', 'fetchSprintAbs', '迭代', 'abs.png', 'chart_bar', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(19, '迭代-优先级统计', 'sprint_priority_stat', 'fetchSprintPriorityStat', '迭代', 'priority_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"状态\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', 0),
(20, '迭代-状态统计', 'sprint_status_stat', 'fetchSprintStatusStat', '迭代', 'status_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(21, '迭代-开发者统计', 'sprint_developer_stat', 'fetchSprintDeveloperStat', '迭代', 'developer_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]},{\"name\":\"迭代\",\"field\":\"status\",\"type\":\"select\",\"value\":[{\"title\":\"全部\",\"value\":\"all\"},{\"title\":\"未解决\",\"value\":\"unfix\"}]}]', 0),
(22, '迭代-事项统计', 'sprint_issue_type_stat', 'fetchSprintIssueTypeStat', '迭代', 'issue_type_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(23, '分配给我未解决的事项', 'unresolve_assignee_my', 'fetchUnResolveAssigneeIssues', '通用', 'assignee_my.png', 'list', 1, 1, 0, '', '[]', 0),
(24, '我关注的事项', 'my_follow', 'fetchFollowIssues', '通用', 'my_follow.png', 'list', 1, 0, 0, '', '[]', 0);
INSERT INTO `main_widget` (`id`, `name`, `_key`, `method`, `module`, `pic`, `type`, `status`, `is_default`, `required_param`, `description`, `parameter`, `order_weight`) VALUES
(25, '我协助的事项', 'my_assistant_issue', 'fetchAssistantIssues', '通用', 'my_assistant_issue.png', 'list', '1', '0', '0', '', '[]', '0');

-- --------------------------------------------------------

--
-- 表的结构 `mind_issue_attribute`
--

CREATE TABLE `mind_issue_attribute` (
                                        `id` int UNSIGNED NOT NULL,
                                        `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                        `issue_id` int UNSIGNED NOT NULL DEFAULT '0',
                                        `source` varchar(20) NOT NULL DEFAULT '',
                                        `group_by` varchar(20) NOT NULL DEFAULT '',
                                        `layout` varchar(20) NOT NULL DEFAULT '',
                                        `shape` varchar(20) NOT NULL DEFAULT '',
                                        `color` varchar(20) NOT NULL DEFAULT '',
                                        `icon` varchar(64) NOT NULL DEFAULT '',
                                        `font_family` varchar(32) NOT NULL DEFAULT '',
                                        `font_size` tinyint NOT NULL DEFAULT '1',
                                        `font_bold` tinyint(1) NOT NULL DEFAULT '0',
                                        `font_italic` tinyint(1) NOT NULL DEFAULT '0',
                                        `bg_color` varchar(16) NOT NULL,
                                        `text_color` varchar(32) NOT NULL,
                                        `side` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mind_issue_attribute`
--

INSERT INTO `mind_issue_attribute` (`id`, `project_id`, `issue_id`, `source`, `group_by`, `layout`, `shape`, `color`, `icon`, `font_family`, `font_size`, `font_bold`, `font_italic`, `bg_color`, `text_color`, `side`) VALUES
(110, 3, 234, 'all', 'module', '', '', '#EE3333', '', '', 1, 0, 0, '', '', ''),
(112, 3, 174, '5', 'module', '', '', '#EE3333', '', '', 1, 0, 0, '', '', ''),
(113, 3, 170, '5', 'module', '', '', '#EE3333', '', '', 1, 0, 0, '', '', ''),
(118, 3, 239, '44', 'module', '', '', '', '', '', 1, 0, 0, '', '', ''),
(119, 3, 754, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', ''),
(122, 3, 218, '44', 'module', '', '', '#3740A7', '', '', 1, 0, 0, '', '', ''),
(126, 3, 186, '44', 'module', '', '', '', '', '', 1, 1, 0, '', '', ''),
(127, 3, 171, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', ''),
(128, 3, 747, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', ''),
(129, 3, 760, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', ''),
(130, 3, 758, '44', 'module', '', 'ellipse', '', '', '', 1, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `mind_project_attribute`
--

CREATE TABLE `mind_project_attribute` (
                                          `id` int UNSIGNED NOT NULL,
                                          `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                          `layout` varchar(20) NOT NULL DEFAULT '',
                                          `shape` varchar(20) NOT NULL DEFAULT '',
                                          `color` varchar(20) NOT NULL DEFAULT '',
                                          `icon` varchar(64) NOT NULL DEFAULT '',
                                          `font_family` varchar(32) NOT NULL DEFAULT '',
                                          `font_size` tinyint NOT NULL DEFAULT '1',
                                          `font_bold` tinyint(1) NOT NULL DEFAULT '0',
                                          `font_italic` tinyint(1) NOT NULL DEFAULT '0',
                                          `bg_color` varchar(16) NOT NULL,
                                          `text_color` varchar(16) NOT NULL,
                                          `side` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mind_project_attribute`
--

INSERT INTO `mind_project_attribute` (`id`, `project_id`, `layout`, `shape`, `color`, `icon`, `font_family`, `font_size`, `font_bold`, `font_italic`, `bg_color`, `text_color`, `side`) VALUES
(4, 3, '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', ''),
(14, 1, '', '', '', '', '', 3, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `mind_second_attribute`
--

CREATE TABLE `mind_second_attribute` (
                                         `id` int UNSIGNED NOT NULL,
                                         `project_id` int UNSIGNED NOT NULL DEFAULT '0',
                                         `source` varchar(20) NOT NULL DEFAULT '',
                                         `group_by` varchar(20) NOT NULL DEFAULT '',
                                         `group_by_id` varchar(20) NOT NULL DEFAULT '',
                                         `layout` varchar(20) NOT NULL DEFAULT '',
                                         `shape` varchar(20) NOT NULL DEFAULT '',
                                         `color` varchar(20) NOT NULL DEFAULT '',
                                         `icon` varchar(64) NOT NULL DEFAULT '',
                                         `font_family` varchar(32) NOT NULL DEFAULT '',
                                         `font_size` tinyint NOT NULL DEFAULT '1',
                                         `font_bold` tinyint(1) NOT NULL DEFAULT '0',
                                         `font_italic` tinyint(1) NOT NULL DEFAULT '0',
                                         `bg_color` varchar(16) NOT NULL,
                                         `text_color` varchar(16) NOT NULL,
                                         `side` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mind_second_attribute`
--

INSERT INTO `mind_second_attribute` (`id`, `project_id`, `source`, `group_by`, `group_by_id`, `layout`, `shape`, `color`, `icon`, `font_family`, `font_size`, `font_bold`, `font_italic`, `bg_color`, `text_color`, `side`) VALUES
(4, 3, '44', 'module', '11', 'tree-left', '', '', '', '', 1, 0, 0, '', '', ''),
(6, 3, '44', 'module', 'module_10', '', '', '', '', '', 2, 0, 0, '', '', ''),
(7, 3, '44', 'module', 'module_9', '', '', '', '', '', 2, 0, 0, '', '', ''),
(18, 3, '44', 'module', '6', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(23, 3, '44', 'module', '9', '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', ''),
(24, 3, '44', 'module', '10', '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', ''),
(26, 3, '44', 'module', '8', '', 'ellipse', '', '', '', 1, 0, 0, '', '', ''),
(29, 3, '44', 'module', '7', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(110, 1, '1', 'module', '5', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(111, 1, '1', 'module', '4', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(112, 1, '1', 'module', '6', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(114, 1, '1', 'module', '1', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(116, 1, '1', 'module', '2', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(136, 1, '1', 'module', '3', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(174, 1, 'all', 'sprint', '0', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(229, 1, 'all', 'sprint', '1', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(238, 1, 'all', 'sprint', '2', '', '', '', '', '', 1, 0, 0, '', '#000000', '');

-- --------------------------------------------------------

--
-- 表的结构 `mind_sprint_attribute`
--

CREATE TABLE `mind_sprint_attribute` (
                                         `id` int UNSIGNED NOT NULL,
                                         `sprint_id` int UNSIGNED NOT NULL DEFAULT '0',
                                         `layout` varchar(20) NOT NULL DEFAULT '',
                                         `shape` varchar(20) NOT NULL DEFAULT '',
                                         `color` varchar(20) NOT NULL DEFAULT '',
                                         `icon` varchar(64) NOT NULL DEFAULT '',
                                         `font_family` varchar(32) NOT NULL DEFAULT '',
                                         `font_size` tinyint NOT NULL DEFAULT '1',
                                         `font_bold` tinyint(1) NOT NULL DEFAULT '0',
                                         `font_italic` tinyint(1) NOT NULL DEFAULT '0',
                                         `bg_color` varchar(16) NOT NULL,
                                         `text_color` varchar(16) NOT NULL,
                                         `side` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mind_sprint_attribute`
--

INSERT INTO `mind_sprint_attribute` (`id`, `sprint_id`, `layout`, `shape`, `color`, `icon`, `font_family`, `font_size`, `font_bold`, `font_italic`, `bg_color`, `text_color`, `side`) VALUES
(24, 44, '', '', '', '', '', 1, 0, 0, '', '#2196F3BF', '');

-- --------------------------------------------------------

--
-- 表的结构 `permission_default_role`
--

CREATE TABLE `permission_default_role` (
                                           `id` int NOT NULL,
                                           `name` varchar(64) DEFAULT NULL,
                                           `description` varchar(256) DEFAULT NULL,
                                           `project_id` int UNSIGNED DEFAULT '0' COMMENT '3.0版本后废弃',
                                           `project_tpl_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属的项目模板id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目角色表';

--
-- 转存表中的数据 `permission_default_role`
--

INSERT INTO `permission_default_role` (`id`, `name`, `description`, `project_id`, `project_tpl_id`) VALUES
(10000, 'Users', '普通用户', 0, 0),
(10001, 'Developers', '开发者,如程序员，架构师', 0, 0),
(10002, 'Administrators', '项目管理员，如项目经理，技术经理', 0, 0),
(10003, 'QA', '测试工程师', 0, 0),
(10006, 'PO', '产品经理，产品负责人', 0, 0),
(10007, '测试人员', '', 0, 1),
(10008, '开发人员', '', 0, 1),
(10009, '普通成员', '', 0, 1),
(10010, '项目经理', '项目的管理者', 0, 1),
(10011, '测试', '', 0, 2),
(10012, '开发者', '', 0, 2),
(10013, '项目经理', '', 0, 2),
(10015, '产品经理', '', 0, 2),
(10016, '运维', '', 0, 2),
(10017, 'PO', '产品负责人', 0, 3),
(10018, 'Master', '以各种方式服务于产品负责人，开发人员以及团队', 0, 3),
(10019, 'Member', '开发人员可包括具有专业技能的人员，如前端开发人员，后端开发人员，开发人员，QA专家，业务分析师，DBA等，他们都被称为开发人员;', 0, 3);

-- --------------------------------------------------------

--
-- 表的结构 `permission_default_role_relation`
--

CREATE TABLE `permission_default_role_relation` (
                                                    `id` int UNSIGNED NOT NULL,
                                                    `role_id` int UNSIGNED DEFAULT NULL,
                                                    `perm_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission_default_role_relation`
--

INSERT INTO `permission_default_role_relation` (`id`, `role_id`, `perm_id`) VALUES
(42, 10000, 10005),
(43, 10000, 10006),
(44, 10000, 10007),
(45, 10000, 10008),
(46, 10000, 10013),
(47, 10001, 10005),
(48, 10001, 10006),
(49, 10001, 10007),
(50, 10001, 10008),
(51, 10001, 10013),
(52, 10001, 10014),
(53, 10001, 10015),
(79, 10001, 10016),
(54, 10001, 10028),
(55, 10002, 10004),
(56, 10002, 10005),
(57, 10002, 10006),
(58, 10002, 10007),
(59, 10002, 10008),
(60, 10002, 10013),
(61, 10002, 10014),
(62, 10002, 10015),
(80, 10002, 10016),
(81, 10002, 10017),
(63, 10002, 10028),
(64, 10002, 10902),
(65, 10002, 10903),
(66, 10002, 10904),
(82, 10002, 10905),
(83, 10002, 10906),
(100, 10002, 10907),
(101, 10002, 10908),
(91, 10003, 10005),
(92, 10003, 10006),
(93, 10003, 10007),
(94, 10003, 10008),
(95, 10003, 10013),
(96, 10003, 10014),
(97, 10003, 10015),
(99, 10003, 10017),
(98, 10003, 10028),
(67, 10006, 10004),
(68, 10006, 10005),
(69, 10006, 10006),
(70, 10006, 10007),
(71, 10006, 10008),
(72, 10006, 10013),
(73, 10006, 10014),
(74, 10006, 10015),
(87, 10006, 10016),
(84, 10006, 10017),
(75, 10006, 10028),
(76, 10006, 10902),
(77, 10006, 10903),
(78, 10006, 10904),
(85, 10006, 10905),
(86, 10006, 10906),
(102, 10006, 10907),
(103, 10006, 10908),
(140, 10007, 10005),
(141, 10007, 10006),
(142, 10007, 10007),
(143, 10007, 10008),
(144, 10007, 10013),
(145, 10007, 10014),
(146, 10007, 10015),
(147, 10007, 10016),
(148, 10007, 10017),
(149, 10007, 10028),
(150, 10007, 10902),
(151, 10007, 10903),
(152, 10007, 10904),
(153, 10007, 10905),
(154, 10007, 10906),
(155, 10007, 10907),
(156, 10007, 10908),
(157, 10008, 10005),
(158, 10008, 10006),
(159, 10008, 10007),
(160, 10008, 10008),
(161, 10008, 10013),
(162, 10008, 10014),
(163, 10008, 10015),
(164, 10008, 10016),
(165, 10008, 10017),
(166, 10008, 10028),
(167, 10008, 10902),
(168, 10008, 10903),
(169, 10008, 10904),
(170, 10008, 10905),
(171, 10008, 10906),
(172, 10008, 10907),
(173, 10008, 10908),
(122, 10009, 10005),
(123, 10009, 10006),
(124, 10009, 10007),
(125, 10009, 10008),
(126, 10009, 10013),
(104, 10010, 10004),
(105, 10010, 10005),
(106, 10010, 10006),
(107, 10010, 10007),
(108, 10010, 10008),
(109, 10010, 10013),
(110, 10010, 10014),
(111, 10010, 10015),
(112, 10010, 10016),
(113, 10010, 10017),
(114, 10010, 10028),
(115, 10010, 10902),
(116, 10010, 10903),
(117, 10010, 10904),
(118, 10010, 10905),
(119, 10010, 10906),
(120, 10010, 10907),
(121, 10010, 10908),
(259, 10011, 10005),
(260, 10011, 10006),
(261, 10011, 10007),
(262, 10011, 10008),
(263, 10011, 10013),
(264, 10011, 10014),
(265, 10011, 10015),
(266, 10011, 10016),
(267, 10011, 10017),
(251, 10012, 10005),
(252, 10012, 10006),
(253, 10012, 10007),
(254, 10012, 10008),
(255, 10012, 10013),
(256, 10012, 10014),
(257, 10012, 10016),
(258, 10012, 10028),
(192, 10013, 10004),
(193, 10013, 10005),
(194, 10013, 10006),
(195, 10013, 10007),
(196, 10013, 10008),
(197, 10013, 10013),
(198, 10013, 10014),
(199, 10013, 10015),
(200, 10013, 10016),
(201, 10013, 10017),
(202, 10013, 10028),
(203, 10013, 10902),
(204, 10013, 10903),
(205, 10013, 10904),
(206, 10013, 10905),
(207, 10013, 10906),
(208, 10013, 10907),
(209, 10013, 10908),
(174, 10015, 10004),
(175, 10015, 10005),
(176, 10015, 10006),
(177, 10015, 10007),
(178, 10015, 10008),
(179, 10015, 10013),
(180, 10015, 10014),
(181, 10015, 10015),
(182, 10015, 10016),
(183, 10015, 10017),
(184, 10015, 10028),
(185, 10015, 10902),
(186, 10015, 10903),
(187, 10015, 10904),
(188, 10015, 10905),
(189, 10015, 10906),
(190, 10015, 10907),
(191, 10015, 10908),
(244, 10016, 10005),
(245, 10016, 10006),
(246, 10016, 10007),
(247, 10016, 10008),
(248, 10016, 10013),
(249, 10016, 10015),
(250, 10016, 10016),
(295, 10017, 10004),
(296, 10017, 10005),
(297, 10017, 10006),
(298, 10017, 10007),
(299, 10017, 10008),
(300, 10017, 10013),
(301, 10017, 10014),
(302, 10017, 10015),
(303, 10017, 10016),
(304, 10017, 10017),
(305, 10017, 10028),
(306, 10017, 10902),
(307, 10017, 10903),
(308, 10017, 10904),
(309, 10017, 10905),
(310, 10017, 10906),
(311, 10017, 10907),
(312, 10017, 10908),
(277, 10018, 10004),
(278, 10018, 10005),
(279, 10018, 10006),
(280, 10018, 10007),
(281, 10018, 10008),
(282, 10018, 10013),
(283, 10018, 10014),
(284, 10018, 10015),
(285, 10018, 10016),
(286, 10018, 10017),
(287, 10018, 10028),
(288, 10018, 10902),
(289, 10018, 10903),
(290, 10018, 10904),
(291, 10018, 10905),
(292, 10018, 10906),
(293, 10018, 10907),
(294, 10018, 10908),
(268, 10019, 10005),
(269, 10019, 10006),
(270, 10019, 10007),
(271, 10019, 10008),
(272, 10019, 10013),
(273, 10019, 10016),
(274, 10019, 10902),
(275, 10019, 10905),
(276, 10019, 10907);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global`
--

CREATE TABLE `permission_global` (
                                     `id` int UNSIGNED NOT NULL,
                                     `parent_id` int UNSIGNED DEFAULT '0',
                                     `name` varchar(64) DEFAULT NULL,
                                     `description` varchar(255) DEFAULT NULL,
                                     `_key` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `permission_global`
--

INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES
(1, 0, '系统设置', '可以对整个系统进行基本，界面，安全，邮件设置，同时还可以查看操作日志', 'MANAGER_SYSTEM_SETTING'),
(2, 0, '管理用户', '', 'MANAGER_USER'),
(3, 0, '事项管理', '', 'MANAGER_ISSUE'),
(4, 0, '项目管理', '可以对全部项目进行管理，包括创建新项目。', 'MANAGER_PROJECT'),
(5, 0, '组织管理', '', 'MANAGER_ORG');

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_group`
--

CREATE TABLE `permission_global_group` (
                                           `id` int UNSIGNED NOT NULL,
                                           `perm_global_id` int UNSIGNED DEFAULT NULL,
                                           `group_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission_global_group`
--

INSERT INTO `permission_global_group` (`id`, `perm_global_id`, `group_id`) VALUES
(1, 10000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_role`
--

CREATE TABLE `permission_global_role` (
                                          `id` int UNSIGNED NOT NULL,
                                          `name` varchar(40) DEFAULT NULL,
                                          `description` varchar(255) DEFAULT NULL,
                                          `is_system` tinyint UNSIGNED DEFAULT '0' COMMENT '是否是默认角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission_global_role`
--

INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES
(1, '超级管理员', NULL, 1),
(2, '系统设置管理员', '', 0),
(3, '项目管理员', NULL, 0),
(4, '用户管理员', NULL, 0),
(5, '事项设置管理员', NULL, 0),
(6, '组织管理员', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_role_relation`
--

CREATE TABLE `permission_global_role_relation` (
                                                   `id` int UNSIGNED NOT NULL,
                                                   `perm_global_id` int UNSIGNED DEFAULT NULL,
                                                   `role_id` int UNSIGNED DEFAULT NULL,
                                                   `is_system` tinyint UNSIGNED DEFAULT '0' COMMENT '是否系统自带'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组拥有的全局权限';

--
-- 转存表中的数据 `permission_global_role_relation`
--

INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES
(2, 1, 1, 1),
(8, 2, 1, 1),
(9, 3, 1, 1),
(10, 4, 1, 1),
(11, 5, 1, 1),
(13, 1, 2, 1),
(14, 2, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_user_role`
--

CREATE TABLE `permission_global_user_role` (
                                               `id` int UNSIGNED NOT NULL,
                                               `user_id` int UNSIGNED DEFAULT '0',
                                               `role_id` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `permission_global_user_role`
--

INSERT INTO `permission_global_user_role` (`id`, `user_id`, `role_id`) VALUES
(5613, 1, 1),
(5671, 12167, 1);

-- --------------------------------------------------------

--
-- 表的结构 `plugin_document_project_relation`
--

CREATE TABLE `plugin_document_project_relation` (
                                                    `project_id` int UNSIGNED NOT NULL,
                                                    `doc_user` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `project_catalog_label`
--

CREATE TABLE `project_catalog_label` (
                                         `id` int UNSIGNED NOT NULL,
                                         `project_id` int NOT NULL,
                                         `name` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                         `label_id_json` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                         `font_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blueviolet' COMMENT '字体颜色',
                                         `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                                         `order_weight` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='项目的分类定义';

--
-- 转存表中的数据 `project_catalog_label`
--

INSERT INTO `project_catalog_label` (`id`, `project_id`, `name`, `label_id_json`, `font_color`, `description`, `order_weight`) VALUES
(1, 1, '产 品', '[\"1\"]', 'blueviolet', '', 99),
(2, 1, '运营推广', '[\"2\",\"3\"]', 'blueviolet', '', 98),
(3, 1, '开 发', '[\"4\",\"7\",\"8\"]', 'blueviolet', '', 90),
(4, 1, '测 试', '[5,6]', 'blueviolet', '', 0),
(5, 1, 'UI设计', '[\"9\"]', 'blueviolet', '', 96),
(7, 1, '运 维', '[\"1\",\"2\"]', 'blueviolet', '', 88),
(29, 36, '产 品', '[\"35\",\"36\"]', 'blueviolet', '', 105),
(30, 36, '运 营', '[\"37\",\"38\"]', 'blueviolet', '', 104),
(31, 36, '开发', '[\"39\",\"40\",\"41\"]', 'blueviolet', '', 103),
(32, 36, '测 试', '[\"42\",\"43\"]', 'blueviolet', '', 102),
(33, 36, 'UI设计', '[\"44\"]', 'blueviolet', '', 101),
(34, 36, '运 维', '[\"45\"]', 'blueviolet', '', 100),
(89, 1, '增长', '[\"146\"]', '#D9534F', '', 0),
(868, 91, '产品', '[\"612\",\"613\"]', '#0033CC', '', 102),
(869, 91, '开发和BUG', '[\"614\",\"615\"]', '#0033CC', '', 101);

-- --------------------------------------------------------

--
-- 表的结构 `project_category`
--

CREATE TABLE `project_category` (
                                    `id` int UNSIGNED NOT NULL,
                                    `name` varchar(255) DEFAULT NULL,
                                    `description` text,
                                    `color` varchar(20) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_flag`
--

CREATE TABLE `project_flag` (
                                `id` int UNSIGNED NOT NULL,
                                `project_id` int UNSIGNED NOT NULL,
                                `flag` varchar(64) NOT NULL,
                                `value` text NOT NULL,
                                `update_time` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_gantt_setting`
--

CREATE TABLE `project_gantt_setting` (
                                         `id` int UNSIGNED NOT NULL,
                                         `project_id` int UNSIGNED DEFAULT NULL,
                                         `source_type` varchar(20) DEFAULT NULL COMMENT 'project,active_sprint',
                                         `source_from` varchar(20) DEFAULT NULL,
                                         `is_display_backlog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在甘特图中显示待办事项',
                                         `hide_issue_types` varchar(100) NOT NULL DEFAULT '' COMMENT '要隐藏的事项类型key以逗号分隔',
                                         `work_dates` varchar(100) DEFAULT NULL,
                                         `is_check_date` tinyint(1) unsigned zerofill NOT NULL DEFAULT '1' COMMENT '是否检查开始和结束日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_issue_report`
--

CREATE TABLE `project_issue_report` (
                                        `id` int UNSIGNED NOT NULL,
                                        `project_id` int UNSIGNED NOT NULL,
                                        `date` date NOT NULL,
                                        `week` tinyint UNSIGNED DEFAULT NULL,
                                        `month` varchar(20) DEFAULT NULL,
                                        `done_count` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
                                        `no_done_count` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
                                        `done_count_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
                                        `no_done_count_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
                                        `today_done_points` int UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
                                        `today_done_number` int UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_issue_type_scheme_data`
--

CREATE TABLE `project_issue_type_scheme_data` (
                                                  `id` int UNSIGNED NOT NULL,
                                                  `issue_type_scheme_id` int UNSIGNED DEFAULT NULL,
                                                  `project_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_issue_type_scheme_data`
--

INSERT INTO `project_issue_type_scheme_data` (`id`, `issue_type_scheme_id`, `project_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 2, 9),
(10, 2, 10),
(11, 2, 11),
(12, 2, 36),
(13, 2, 37),
(14, 2, 38),
(15, 2, 39),
(16, 2, 40),
(17, 2, 41),
(18, 2, 42),
(26, 2, 43),
(27, 2, 45),
(28, 2, 47),
(29, 2, 48),
(30, 2, 49),
(31, 2, 50),
(32, 2, 51),
(33, 2, 52),
(34, 2, 53),
(35, 2, 54),
(36, 2, 55),
(37, 2, 56),
(38, 2, 57),
(39, 2, 58),
(40, 2, 59),
(41, 2, 60),
(42, 2, 61),
(43, 2, 62),
(44, 2, 63),
(45, 2, 64),
(46, 2, 65),
(47, 2, 66),
(48, 2, 67),
(49, 2, 68),
(50, 2, 69),
(51, 2, 70),
(52, 2, 71),
(53, 2, 72),
(54, 2, 73),
(55, 2, 74),
(56, 2, 75),
(57, 2, 76),
(58, 2, 77),
(59, 2, 78),
(61, NULL, 80),
(62, NULL, 81),
(63, 0, 82),
(64, 0, 83),
(65, 0, 87),
(66, 0, 88),
(67, 0, 89),
(68, 0, 90),
(69, 0, 91);

-- --------------------------------------------------------

--
-- 表的结构 `project_key`
--

CREATE TABLE `project_key` (
                               `id` decimal(18,0) NOT NULL,
                               `project_id` decimal(18,0) DEFAULT NULL,
                               `project_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_label`
--

CREATE TABLE `project_label` (
                                 `id` int UNSIGNED NOT NULL,
                                 `project_id` int UNSIGNED NOT NULL,
                                 `title` varchar(64) NOT NULL,
                                 `color` varchar(20) NOT NULL,
                                 `bg_color` varchar(20) NOT NULL DEFAULT '',
                                 `description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_list_count`
--

CREATE TABLE `project_list_count` (
                                      `id` int UNSIGNED NOT NULL,
                                      `project_type_id` smallint UNSIGNED DEFAULT NULL,
                                      `project_total` int UNSIGNED DEFAULT NULL,
                                      `remark` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_main`
--

CREATE TABLE `project_main` (
                                `id` int UNSIGNED NOT NULL,
                                `org_id` int NOT NULL DEFAULT '1',
                                `org_path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                                `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `lead` int UNSIGNED DEFAULT '0',
                                `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `key` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `pcounter` decimal(18,0) DEFAULT NULL,
                                `default_assignee` int UNSIGNED DEFAULT '0',
                                `assignee_type` int DEFAULT NULL,
                                `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                `category` int UNSIGNED DEFAULT NULL,
                                `type` tinyint DEFAULT '1',
                                `type_child` tinyint DEFAULT '0',
                                `permission_scheme_id` int UNSIGNED DEFAULT '0',
                                `workflow_scheme_id` int UNSIGNED NOT NULL,
                                `create_uid` int UNSIGNED DEFAULT '0',
                                `create_time` int UNSIGNED DEFAULT '0',
                                `un_done_count` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '未完成事项数',
                                `done_count` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '已经完成事项数',
                                `closed_count` int UNSIGNED NOT NULL DEFAULT '0',
                                `archived` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '已归档',
                                `issue_update_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '事项最新更新时间',
                                `is_display_issue_catalog` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否在事项列表显示分类',
                                `subsystem_json` varchar(5012) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]' COMMENT '当前项目启用的子系统',
                                `project_view` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issue' COMMENT '进入项目默认打开的那个页面',
                                `issue_view` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'detail' COMMENT '点击事项的交互',
                                `issue_ui_scheme_id` int NOT NULL DEFAULT '0' COMMENT '所属的界面方案id',
                                `project_tpl_id` int NOT NULL DEFAULT '1' COMMENT '所属的项目模板id',
                                `default_issue_type_id` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '创建事项时默认的类型',
                                `is_remember_last_issue` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否记住上次创建事项的数据',
                                `remember_last_issue_field` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]' COMMENT '上次创建事项的数据字段',
                                `remember_last_issue_data` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}' COMMENT '上次创建事项时的一些数据',
                                `is_strict_status`  tinyint(2) unsigned DEFAULT '0' COMMENT '是否严格启用状态流'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `project_main_extra`
--

CREATE TABLE `project_main_extra` (
                                      `id` int UNSIGNED NOT NULL,
                                      `project_id` int UNSIGNED DEFAULT '0',
                                      `detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `project_mind_setting`
--

CREATE TABLE `project_mind_setting` (
                                        `id` int NOT NULL,
                                        `project_id` int NOT NULL,
                                        `setting_key` varchar(32) NOT NULL,
                                        `setting_value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_module`
--

CREATE TABLE `project_module` (
                                  `id` int UNSIGNED NOT NULL,
                                  `project_id` int UNSIGNED DEFAULT NULL,
                                  `name` varchar(64) DEFAULT '',
                                  `description` varchar(256) DEFAULT NULL,
                                  `lead` int UNSIGNED DEFAULT NULL,
                                  `default_assignee` int UNSIGNED DEFAULT NULL,
                                  `ctime` int UNSIGNED DEFAULT '0',
                                  `order_weight` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_permission`
--

CREATE TABLE `project_permission` (
                                      `id` int UNSIGNED NOT NULL,
                                      `parent_id` int UNSIGNED DEFAULT '0',
                                      `name` varchar(64) DEFAULT NULL,
                                      `description` varchar(255) DEFAULT NULL,
                                      `_key` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `project_permission`
--

INSERT INTO `project_permission` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES
(10004, 0, '管理项目', '可以对项目进行设置', 'ADMINISTER_PROJECTS'),
(10005, 0, '访问事项列表(已废弃)', '', 'BROWSE_ISSUES'),
(10006, 0, '创建事项', '', 'CREATE_ISSUES'),
(10007, 0, '评论', '', 'ADD_COMMENTS'),
(10008, 0, '上传和删除附件', '', 'CREATE_ATTACHMENTS'),
(10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES'),
(10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES'),
(10015, 0, '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES'),
(10016, 0, '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS'),
(10017, 0, '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE'),
(10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS'),
(10902, 0, '管理backlog', '', 'MANAGE_BACKLOG'),
(10903, 0, '管理sprint', '', 'MANAGE_SPRINT'),
(10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN'),
(10905, 0, '导入事项', '可以到导入excel数据到项目中', 'IMPORT_EXCEL'),
(10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL'),
(10907, 0, '管理甘特图', '是否拥有权限操作甘特图中的事项和设置', 'ADMIN_GANTT'),
(10908, 0, '事项分解设置', '是否拥有权限修改事项分解的设置', 'MIND_SETTING');

-- --------------------------------------------------------

--
-- 表的结构 `project_role`
--

CREATE TABLE `project_role` (
                                `id` int UNSIGNED NOT NULL,
                                `project_id` int UNSIGNED DEFAULT NULL,
                                `name` varchar(40) DEFAULT NULL,
                                `description` varchar(255) DEFAULT NULL,
                                `is_system` tinyint UNSIGNED DEFAULT '0' COMMENT '是否是默认角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_role_relation`
--

CREATE TABLE `project_role_relation` (
                                         `id` int UNSIGNED NOT NULL,
                                         `project_id` int UNSIGNED DEFAULT NULL,
                                         `role_id` int UNSIGNED DEFAULT NULL,
                                         `perm_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_template`
--

CREATE TABLE `project_template` (
                                    `id` int UNSIGNED NOT NULL,
                                    `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
                                    `category_id` int NOT NULL DEFAULT '0',
                                    `description` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
                                    `image_bg` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
                                    `order_weight` int UNSIGNED NOT NULL DEFAULT '0',
                                    `created_at` int UNSIGNED DEFAULT NULL,
                                    `updated_at` int UNSIGNED DEFAULT NULL,
                                    `user_id` int UNSIGNED DEFAULT NULL,
                                    `issue_type_scheme_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '事项类型方案id',
                                    `issue_workflow_scheme_id` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '事项工作流方案id',
                                    `issue_ui_scheme_id` int UNSIGNED NOT NULL DEFAULT '0',
                                    `nav_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'left' COMMENT '导航风格：left,top可选',
                                    `ui_style` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'dark' COMMENT '整体风格设置',
                                    `theme_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'blue' COMMENT '主题色',
                                    `is_fix_header` tinyint(1) NOT NULL DEFAULT '0' COMMENT '固定 Header',
                                    `is_fix_left` tinyint(1) NOT NULL DEFAULT '0' COMMENT '固定侧边菜单',
                                    `subsystem_json` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '[]' COMMENT '子系统',
                                    `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否系统自带的模板',
                                    `page_layout` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                                    `project_view` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                                    `issue_view` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                                    `default_issue_type_id` int UNSIGNED NOT NULL DEFAULT '1' COMMENT '创建事项时默认的类型'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT=' 项目模板';

--
-- 转存表中的数据 `project_template`
--

INSERT INTO `project_template` VALUES (1, '默认模板', 0, '系统初始化创建的项目模板，不可编辑和删除', '/dev/img/project_tpl/default.png', 100000, NULL, NULL, NULL, 1, 1, 1, 'left', 'dark', 'blue', 0, 0, '[\"issues\",\"backlog\",\"sprints\",\"gantt\",\"mind\",\"kanban\",\"activity\",\"chart\",\"stat\"]',  1, 'fluid', 'summary', '', 1);
INSERT INTO `project_template` VALUES (2, '软件开发', 1, '模板描述', '/dev/img/project_tpl/software.png', 0, NULL, NULL, NULL, 1, 1, 1, 'left', 'dark', 'blue', 0, 0, '[\"issues\",\"kanban\",\"mind\",\"gantt\",\"activity\",\"chart\",\"stat\"]', 0, 'fluid', 'issues', 'detail', 1);
INSERT INTO `project_template` VALUES (3, 'Scrum敏捷开发', 1, '模板描述', '/dev/img/project_tpl/scrum.png', 0, NULL, NULL, NULL, 1, 1, 1, 'left', 'dark', 'blue', 0, 0, '[\"issues\",\"backlog\",\"sprints\",\"kanban\",\"mind\",\"chart\",\"stat\",\"activity\"]', 0, '', 'issues', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `project_template_display_category`
--

CREATE TABLE `project_template_display_category` (
                                                     `id` int NOT NULL,
                                                     `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
                                                     `order_weight` int UNSIGNED NOT NULL DEFAULT '0',
                                                     `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `project_template_display_category`
--

INSERT INTO `project_template_display_category` (`id`, `name`, `order_weight`, `user_id`) VALUES
(1, '产品研发', 999, NULL),
(2, '市场营销', 998, NULL),
(3, '教育培训', 997, NULL),
(4, '客户服务', 996, NULL),
(5, '生产制造', 995, NULL),
(6, '政务管理', 994, NULL),
(7, '个人计划', 993, NULL),
(8, '产品研发', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `project_tpl_category`
--

CREATE TABLE `project_tpl_category` (
                                        `id` int UNSIGNED NOT NULL,
                                        `name` varchar(255) DEFAULT NULL,
                                        `description` text,
                                        `color` varchar(20) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_tpl_category_label`
--

CREATE TABLE `project_tpl_category_label` (
                                              `id` int UNSIGNED NOT NULL,
                                              `project_tpl_id` int NOT NULL,
                                              `name` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                              `label_id_json` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                                              `font_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blueviolet' COMMENT '字体颜色',
                                              `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                                              `order_weight` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='项目的分类定义';

--
-- 转存表中的数据 `project_tpl_category_label`
--

INSERT INTO `project_tpl_category_label` (`id`, `project_tpl_id`, `name`, `label_id_json`, `font_color`, `description`, `order_weight`) VALUES
(1, 1, '产品', '[\"3\",\"4\"]', '#0033CC', '', 0),
(3, 1, '开发和BUG', '[\"1\",\"2\"]', '#0033CC', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `project_tpl_label`
--

CREATE TABLE `project_tpl_label` (
                                     `id` int UNSIGNED NOT NULL,
                                     `project_tpl_id` int UNSIGNED NOT NULL,
                                     `title` varchar(64) NOT NULL,
                                     `color` varchar(20) NOT NULL,
                                     `bg_color` varchar(20) NOT NULL DEFAULT '',
                                     `description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_tpl_label`
--

INSERT INTO `project_tpl_label` (`id`, `project_tpl_id`, `title`, `color`, `bg_color`, `description`) VALUES
(1, 1, '开发', '#FFFFFF', '', ''),
(2, 1, 'BUG', '#FFFFFF', '#FF0000', ''),
(3, 1, '产品', '#FFFFFF', '#5843AD', ''),
(4, 1, '文档', '#FFFFFF', '#004E00', ''),
(5, 1, '运维', '#FFFFFF', '#8E44AD', ''),
(6, 1, '运营', '#FFFFFF', '#F0AD4E', '');

-- --------------------------------------------------------

--
-- 表的结构 `project_tpl_module`
--

CREATE TABLE `project_tpl_module` (
                                      `id` int UNSIGNED NOT NULL,
                                      `project_tpl_id` int UNSIGNED DEFAULT NULL,
                                      `name` varchar(64) DEFAULT '',
                                      `description` varchar(256) DEFAULT NULL,
                                      `created_at` int UNSIGNED DEFAULT '0',
                                      `order_weight` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_tpl_widget`
--

CREATE TABLE `project_tpl_widget` (
                                      `id` int NOT NULL COMMENT '主键id',
                                      `project_tpl_id` int UNSIGNED NOT NULL COMMENT '项目模板id',
                                      `widget_id` int NOT NULL COMMENT 'main_widget主键id',
                                      `order_weight` int UNSIGNED DEFAULT NULL COMMENT '工具顺序',
                                      `panel` varchar(40) NOT NULL,
                                      `parameter` varchar(1024) NOT NULL,
                                      `is_saved_parameter` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否保存了过滤参数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_user_role`
--

CREATE TABLE `project_user_role` (
                                     `id` int UNSIGNED NOT NULL,
                                     `user_id` int UNSIGNED DEFAULT '0',
                                     `project_id` int UNSIGNED DEFAULT '0',
                                     `role_id` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_version`
--

CREATE TABLE `project_version` (
                                   `id` int NOT NULL,
                                   `project_id` int UNSIGNED DEFAULT NULL,
                                   `name` varchar(255) DEFAULT NULL,
                                   `description` text,
                                   `sequence` decimal(18,0) DEFAULT NULL,
                                   `released` tinyint UNSIGNED DEFAULT '0' COMMENT '0未发布 1已发布',
                                   `archived` varchar(10) DEFAULT NULL,
                                   `url` varchar(255) DEFAULT NULL,
                                   `start_date` int UNSIGNED DEFAULT NULL,
                                   `release_date` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_workflows`
--

CREATE TABLE `project_workflows` (
                                     `id` decimal(18,0) NOT NULL,
                                     `workflowname` varchar(255) DEFAULT NULL,
                                     `creatorname` varchar(255) DEFAULT NULL,
                                     `descriptor` longtext,
                                     `islocked` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_workflow_status`
--

CREATE TABLE `project_workflow_status` (
                                           `id` decimal(18,0) NOT NULL,
                                           `status` varchar(255) DEFAULT NULL,
                                           `parentname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `report_project_issue`
--

CREATE TABLE `report_project_issue` (
                                        `id` int UNSIGNED NOT NULL,
                                        `project_id` int UNSIGNED NOT NULL,
                                        `date` date NOT NULL,
                                        `week` tinyint UNSIGNED DEFAULT NULL,
                                        `month` varchar(20) DEFAULT NULL,
                                        `count_done` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
                                        `count_no_done` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
                                        `count_done_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
                                        `count_no_done_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
                                        `today_done_points` int UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
                                        `today_done_number` int UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `report_sprint_issue`
--

CREATE TABLE `report_sprint_issue` (
                                       `id` int UNSIGNED NOT NULL,
                                       `sprint_id` int UNSIGNED NOT NULL,
                                       `date` date NOT NULL,
                                       `week` tinyint UNSIGNED DEFAULT NULL,
                                       `month` varchar(20) DEFAULT NULL,
                                       `count_done` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
                                       `count_no_done` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
                                       `count_done_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
                                       `count_no_done_by_resolve` int UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
                                       `today_done_points` int UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
                                       `today_done_number` int UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `service_config`
--

CREATE TABLE `service_config` (
                                  `id` decimal(18,0) NOT NULL,
                                  `delaytime` decimal(18,0) DEFAULT NULL,
                                  `clazz` varchar(255) DEFAULT NULL,
                                  `servicename` varchar(255) DEFAULT NULL,
                                  `cron_expression` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `user_application`
--

CREATE TABLE `user_application` (
                                    `id` decimal(18,0) NOT NULL,
                                    `application_name` varchar(255) DEFAULT NULL,
                                    `lower_application_name` varchar(255) DEFAULT NULL,
                                    `created_date` datetime DEFAULT NULL,
                                    `updated_date` datetime DEFAULT NULL,
                                    `active` decimal(9,0) DEFAULT NULL,
                                    `description` varchar(255) DEFAULT NULL,
                                    `application_type` varchar(255) DEFAULT NULL,
                                    `credential` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_application`
--

INSERT INTO `user_application` (`id`, `application_name`, `lower_application_name`, `created_date`, `updated_date`, `active`, `description`, `application_type`, `credential`) VALUES
('1', 'crowd-embedded', 'crowd-embedded', '2013-02-28 11:57:51', '2013-02-28 11:57:51', '1', '', 'CROWD', 'X');

-- --------------------------------------------------------

--
-- 表的结构 `user_attributes`
--

CREATE TABLE `user_attributes` (
                                   `id` decimal(18,0) NOT NULL,
                                   `user_id` decimal(18,0) DEFAULT NULL,
                                   `directory_id` decimal(18,0) DEFAULT NULL,
                                   `attribute_name` varchar(255) DEFAULT NULL,
                                   `attribute_value` varchar(255) DEFAULT NULL,
                                   `lower_attribute_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_email_active`
--

CREATE TABLE `user_email_active` (
                                     `id` int UNSIGNED NOT NULL,
                                     `username` varchar(32) DEFAULT '',
                                     `email` varchar(64) NOT NULL DEFAULT '',
                                     `uid` int UNSIGNED NOT NULL,
                                     `verify_code` varchar(32) NOT NULL,
                                     `time` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_email_active`
--

INSERT INTO `user_email_active` (`id`, `username`, `email`, `uid`, `verify_code`, `time`) VALUES
(1, '19018891771', '19018891771@masterlab.org', 12217, '123456', 1585854569);

-- --------------------------------------------------------

--
-- 表的结构 `user_email_find_password`
--

CREATE TABLE `user_email_find_password` (
                                            `email` varchar(50) NOT NULL,
                                            `uid` int UNSIGNED NOT NULL,
                                            `verify_code` varchar(32) NOT NULL,
                                            `time` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_email_find_password`
--

INSERT INTO `user_email_find_password` (`email`, `uid`, `verify_code`, `time`) VALUES
('19054399592@masterlab.org', 0, '123456', 1585854569);

-- --------------------------------------------------------

--
-- 表的结构 `user_email_token`
--

CREATE TABLE `user_email_token` (
                                    `id` bigint UNSIGNED NOT NULL,
                                    `email` varchar(255) NOT NULL,
                                    `uid` int UNSIGNED NOT NULL,
                                    `token` varchar(255) NOT NULL,
                                    `expired` int UNSIGNED NOT NULL COMMENT '有效期',
                                    `created_at` int UNSIGNED NOT NULL,
                                    `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1-有效，0-无效',
                                    `used_model` varchar(255) NOT NULL DEFAULT '' COMMENT '用于哪个模型或功能'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

CREATE TABLE `user_group` (
                              `id` int UNSIGNED NOT NULL,
                              `uid` int UNSIGNED DEFAULT NULL,
                              `group_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_group`
--

INSERT INTO `user_group` (`id`, `uid`, `group_id`) VALUES
(2, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_invite`
--

CREATE TABLE `user_invite` (
                               `id` int NOT NULL,
                               `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `project_id` int UNSIGNED NOT NULL,
                               `project_roles` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '项目的角色id，可以是多个以逗号,分隔',
                               `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                               `expire_time` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `user_ip_login_times`
--

CREATE TABLE `user_ip_login_times` (
                                       `id` int NOT NULL,
                                       `ip` varchar(20) NOT NULL DEFAULT '',
                                       `times` int NOT NULL DEFAULT '0',
                                       `up_time` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_issue_display_fields`
--

CREATE TABLE `user_issue_display_fields` (
                                             `id` int NOT NULL,
                                             `user_id` int UNSIGNED NOT NULL,
                                             `project_id` int UNSIGNED NOT NULL,
                                             `fields` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_issue_display_fields`
--

INSERT INTO `user_issue_display_fields` (`id`, `user_id`, `project_id`, `fields`) VALUES
(13, 1, 3, 'issue_num,issue_type,priority,module,sprint,summary,assignee,status,plan_date'),
(16, 1, 0, 'issue_num,issue_type,priority,project_id,module,summary,assignee,status,resolve,plan_date'),
(30, 1, 1, 'issue_num,issue_type,priority,module,sprint,summary,label,assignee,status,resolve,plan_date');

-- --------------------------------------------------------

--
-- 表的结构 `user_issue_last_create_data`
--

CREATE TABLE `user_issue_last_create_data` (
                                               `id` int UNSIGNED NOT NULL,
                                               `user_id` int UNSIGNED NOT NULL,
                                               `project_id` int UNSIGNED NOT NULL,
                                               `issue_data` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '{}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user_issue_last_create_data`
--

INSERT INTO `user_issue_last_create_data` (`id`, `user_id`, `project_id`, `issue_data`) VALUES
(3, 1, 36, '{\"issue_type\":1,\"issue_module\":\"\\u8bf7\\u9009\\u62e9\",\"assignee\":12255,\"fix_version\":[\"\"],\"labels\":null}'),
(8, 1, 1, '{\"issue_type\":1,\"module\":\"1\",\"assignee\":12164,\"fix_version\":[\"1\"],\"labels\":[\"1\",\"2\",\"3\"]}');

-- --------------------------------------------------------

--
-- 表的结构 `user_login_log`
--

CREATE TABLE `user_login_log` (
                                  `id` int NOT NULL,
                                  `session_id` varchar(64) NOT NULL DEFAULT '',
                                  `token` varchar(128) DEFAULT '',
                                  `uid` int UNSIGNED NOT NULL DEFAULT '0',
                                  `time` int UNSIGNED NOT NULL DEFAULT '0',
                                  `ip` varchar(24) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- --------------------------------------------------------

--
-- 表的结构 `user_main`
--

CREATE TABLE `user_main` (
                             `uid` int NOT NULL,
                             `schema_source` varchar(12) NOT NULL DEFAULT 'inner' COMMENT '用户数据源: inner ldap wechat weibo github等',
                             `directory_id` int DEFAULT NULL,
                             `phone` varchar(16) DEFAULT NULL,
                             `username` varchar(255) DEFAULT NULL,
                             `openid` varchar(32) NOT NULL,
                             `status` tinyint DEFAULT '1' COMMENT '0 审核中;1 正常; 2 禁用',
                             `first_name` varchar(255) DEFAULT NULL,
                             `last_name` varchar(255) DEFAULT NULL,
                             `display_name` varchar(255) DEFAULT NULL,
                             `email` varchar(255) DEFAULT NULL,
                             `password` varchar(255) DEFAULT NULL,
                             `sex` tinyint UNSIGNED DEFAULT '0' COMMENT '1男2女',
                             `birthday` varchar(20) DEFAULT NULL,
                             `create_time` int UNSIGNED DEFAULT '0',
                             `update_time` int DEFAULT '0',
                             `avatar` varchar(100) DEFAULT '',
                             `source` varchar(20) DEFAULT '',
                             `ios_token` varchar(128) DEFAULT NULL,
                             `android_token` varchar(128) DEFAULT NULL,
                             `version` varchar(20) DEFAULT NULL,
                             `token` varchar(64) DEFAULT '',
                             `last_login_time` int UNSIGNED DEFAULT '0',
                             `is_system` tinyint UNSIGNED DEFAULT '0' COMMENT '是否系统自带的用户,不可删除',
                             `login_counter` int UNSIGNED DEFAULT '0' COMMENT '登录次数',
                             `title` varchar(32) DEFAULT NULL,
                             `sign` varchar(64) DEFAULT NULL,
                             `is_verified` tinyint(2)  UNSIGNED NULL  default 1,
                             `verify_code` varchar(20) COLLATE utf8mb4_unicode_ci COMMENT '验证邮箱的验证码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_main`
--

INSERT INTO `user_main` (`uid`, `schema_source`, `directory_id`, `phone`, `username`, `openid`, `status`, `first_name`, `last_name`, `display_name`, `email`, `password`, `sex`, `birthday`, `create_time`, `update_time`, `avatar`, `source`, `ios_token`, `android_token`, `version`, `token`, `last_login_time`, `is_system`, `login_counter`, `title`, `sign`) VALUES
(1, 'inner', 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', '121642038@qq.com', '$2y$10$f/pmUWT5JFvLVtlq83lv..dhkDMM60Da80w.VidavER.vtCAZSBOS', 1, '2019-01-13', 0, 0, 'avatar/1.png?t=1604387178', '', NULL, NULL, NULL, NULL, 1604924916, 0, 0, '管理员', '简化项目管理，保障结果，快乐团队！');

-- --------------------------------------------------------

--
-- 表的结构 `user_message`
--

CREATE TABLE `user_message` (
                                `id` int NOT NULL,
                                `sender_uid` int UNSIGNED NOT NULL,
                                `sender_name` varchar(64) NOT NULL,
                                `direction` smallint UNSIGNED NOT NULL,
                                `receiver_uid` int UNSIGNED NOT NULL,
                                `title` varchar(128) NOT NULL,
                                `content` text NOT NULL,
                                `readed` tinyint UNSIGNED NOT NULL,
                                `type` tinyint UNSIGNED NOT NULL,
                                `create_time` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_password`
--

CREATE TABLE `user_password` (
                                 `user_id` int UNSIGNED NOT NULL,
                                 `hash` varchar(72) DEFAULT '' COMMENT 'password_hash()值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_password_strategy`
--

CREATE TABLE `user_password_strategy` (
                                          `id` int UNSIGNED NOT NULL,
                                          `strategy` tinyint UNSIGNED DEFAULT NULL COMMENT '1允许所有密码;2不允许非常简单的密码;3要求强密码  关于安全密码策略'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_password_strategy`
--

INSERT INTO `user_password_strategy` (`id`, `strategy`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `user_phone_find_password`
--

CREATE TABLE `user_phone_find_password` (
                                            `id` int NOT NULL,
                                            `phone` varchar(20) NOT NULL,
                                            `verify_code` varchar(128) NOT NULL DEFAULT '',
                                            `time` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='找回密码表';

--
-- 转存表中的数据 `user_phone_find_password`
--

INSERT INTO `user_phone_find_password` (`id`, `phone`, `verify_code`, `time`) VALUES
(1, '19082292994', '123456', 1585854569);

-- --------------------------------------------------------

--
-- 表的结构 `user_posted_flag`
--

CREATE TABLE `user_posted_flag` (
                                    `id` int NOT NULL,
                                    `user_id` int UNSIGNED NOT NULL DEFAULT '0',
                                    `_date` date NOT NULL,
                                    `ip` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_refresh_token`
--

CREATE TABLE `user_refresh_token` (
                                      `uid` int UNSIGNED NOT NULL,
                                      `refresh_token` varchar(256) NOT NULL,
                                      `expire` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户刷新的token表';

-- --------------------------------------------------------

--
-- 表的结构 `user_setting`
--

CREATE TABLE `user_setting` (
                                `id` int UNSIGNED NOT NULL,
                                `user_id` int UNSIGNED NOT NULL,
                                `_key` varchar(64) DEFAULT NULL,
                                `_value` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_setting`
--

INSERT INTO `user_setting` (`id`, `user_id`, `_key`, `_value`) VALUES
(51, 1, 'scheme_style', 'left'),
(53, 1, 'project_view', 'issues'),
(54, 1, 'issue_view', 'list'),
(198, 1, 'initializedWidget', '1'),
(201, 1, 'initialized_widget', '1'),
(353, 1, 'page_layout', 'fixed'),
(516, 1, 'projects_sort', 'latest_activity_desc'),
(521, 12165, 'layout', 'aa'),
(522, 12165, 'initializedWidget', '1'),
(523, 12170, 'layout', 'aa'),
(524, 12170, 'initializedWidget', '1'),
(525, 12170, 'projects_sort', 'created_desc'),
(565, 12255, 'layout', 'aa'),
(566, 12255, 'initializedWidget', '1'),
(567, 12260, 'layout', 'aa'),
(568, 12260, 'initializedWidget', '1'),
(569, 12261, 'layout', 'aa'),
(570, 12261, 'initializedWidget', '1'),
(572, 12256, 'initializedWidget', '1'),
(597, 12256, 'layout', 'aaa'),
(598, 12256, 'projects_sort', 'created_desc'),
(602, 12262, 'layout', 'aa'),
(603, 12262, 'initializedWidget', '1'),
(604, 12262, 'projects_sort', 'created_desc'),
(614, 1, 'layout', 'aaa');

-- --------------------------------------------------------

--
-- 表的结构 `user_token`
--

CREATE TABLE `user_token` (
                              `id` int UNSIGNED NOT NULL,
                              `uid` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
                              `token` varchar(255) NOT NULL DEFAULT '' COMMENT 'token',
                              `token_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'token过期时间',
                              `refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT '刷新token',
                              `refresh_token_time` int UNSIGNED NOT NULL DEFAULT '0' COMMENT '刷新token过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_token`
--

INSERT INTO `user_token` (`id`, `uid`, `token`, `token_time`, `refresh_token`, `refresh_token_time`) VALUES
(1, 1, 'f2c75534fa5f67bf0499f2f081d82d2ea67223dcb4a36780a878c94cbaf81e8b', 1603702456, '1cc3c4b38af5b0729ab026fa1f1919ed5b3eb0f3d2246b922f5b1a7759aa70a4', 1603702456),
(2, 12165, '289782df047c0639a1de60ec30df81be53d3aa23f5e7cee5ef5aa4b20f672467', 1583827161, 'f2e9f12ee857d126d36df54e03e4f0cf98a48d68c05a484f1469710b20a19d3b', 1583827161),
(3, 12170, '091ec9b5343b945a2a879dbfdfc6dcae84ba0e8eafae9c81d63f741f94164677', 1585123124, 'de5f7da9538959dd325522b5526e9ad6bd2aaef4485b9bc5c66971bc6c3c3e01', 1585123124),
(4, 12256, 'ea8a1052074fffe62ee5e9100ed0540c48a812fa8aa80b165908bf5f62a88cea', 1590482533, '807d05146a7385e017feeadb25642c431276ca280e9d78e7d60c9cbf36c98ad3', 1590482533),
(5, 12255, '1900f267de67e2c589a673ea9dd7fa6e3aaef718953de171acc5efd0f7d7df5c', 1590829475, '4b2dc1cf0a9c7b165bd84d943f49fc0d0b8a73ee4155e896616bb50c969545de', 1590829475),
(6, 12260, '2a3d355be7ad548fcdb5cb678c3f954a40b7af3e01ae2315a6b8b8366cab8a2d', 1590941255, '3809c705052ff05d5c7c8df9462f0f2835fc93d257caf06eab6c344a1c462375', 1590941255),
(7, 12261, '9e24d6373c5604e7929a47ac3b8cf66d9ab0af7f5f5ba86c5f293d085872739b', 1590941546, '9cd87f6c48e515f4889fdd5f39ecfa05cba9d6feea987d82b61f9d0806df49aa', 1590941546),
(8, 12262, '4df8c02c95d4262ea8e1656cf56cc24358a7c10d2f92307759bc504a988dc1c5', 1593856423, '702f97f1753c239b384f81c35bf676d6a6f9ba4bc1f247428990e2c3bd22fead', 1593856423);

-- --------------------------------------------------------

--
-- 表的结构 `user_widget`
--

CREATE TABLE `user_widget` (
                               `id` int NOT NULL COMMENT '主键id',
                               `user_id` int UNSIGNED NOT NULL COMMENT '用户id',
                               `widget_id` int NOT NULL COMMENT 'main_widget主键id',
                               `order_weight` int UNSIGNED DEFAULT NULL COMMENT '工具顺序',
                               `panel` varchar(40) NOT NULL,
                               `parameter` varchar(1024) NOT NULL,
                               `is_saved_parameter` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否保存了过滤参数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_widget`
--

INSERT INTO `user_widget` (`id`, `user_id`, `widget_id`, `order_weight`, `panel`, `parameter`, `is_saved_parameter`) VALUES
(1, 0, 1, 1, 'first', '', 0),
(2, 0, 23, 2, 'first', '', 0),
(3, 0, 3, 3, 'first', '', 0),
(4, 0, 4, 1, 'second', '', 0),
(5, 0, 5, 2, 'second', '', 0),
(2908, 1, 1, 2, 'first', '', 0),
(2911, 1, 24, 5, 'first', '', 0),
(2912, 1, 3, 1, 'second', '', 0),
(2915, 1, 23, 3, 'third', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `workflow`
--

CREATE TABLE `workflow` (
                            `id` int UNSIGNED NOT NULL,
                            `name` varchar(40) DEFAULT '',
                            `description` varchar(100) DEFAULT '',
                            `create_uid` int UNSIGNED DEFAULT NULL,
                            `create_time` int UNSIGNED DEFAULT NULL,
                            `update_uid` int UNSIGNED DEFAULT NULL,
                            `update_time` int UNSIGNED DEFAULT NULL,
                            `steps` tinyint UNSIGNED DEFAULT NULL,
                            `data` text,
                            `is_system` tinyint UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `workflow`
--

INSERT INTO `workflow` (`id`, `name`, `description`, `create_uid`, `create_time`, `update_uid`, `update_time`, `steps`, `data`, `is_system`) VALUES
(1, '默认状态流', '', 1, 0, NULL, 1582439359, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":469,\"positionY\":19,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":442,\"positionY\":142,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":755,\"positionY\":136,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":463,\"positionY\":457,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":303,\"positionY\":252,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_122\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(2, '软件开发状态流', '针对软件开发的过程状态流', 1, NULL, NULL, 1529647857, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(3, 'Task状态流', '', 1, NULL, NULL, 1539675552, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);

-- --------------------------------------------------------

--
-- 表的结构 `workflow_block`
--

CREATE TABLE `workflow_block` (
                                  `id` int UNSIGNED NOT NULL,
                                  `workflow_id` int UNSIGNED DEFAULT NULL,
                                  `status_id` int UNSIGNED DEFAULT NULL,
                                  `blcok_id` varchar(64) DEFAULT NULL,
                                  `position_x` smallint UNSIGNED DEFAULT NULL,
                                  `position_y` smallint UNSIGNED DEFAULT NULL,
                                  `inner_html` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `workflow_connector`
--

CREATE TABLE `workflow_connector` (
                                      `id` int UNSIGNED NOT NULL,
                                      `workflow_id` int UNSIGNED DEFAULT NULL,
                                      `connector_id` varchar(32) DEFAULT NULL,
                                      `title` varchar(64) DEFAULT NULL,
                                      `source_id` varchar(64) DEFAULT NULL,
                                      `target_id` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `workflow_scheme`
--

CREATE TABLE `workflow_scheme` (
                                   `id` int NOT NULL,
                                   `name` varchar(128) DEFAULT NULL,
                                   `description` varchar(256) DEFAULT NULL,
                                   `is_system` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `workflow_scheme`
--

INSERT INTO `workflow_scheme` (`id`, `name`, `description`, `is_system`) VALUES
(1, '默认状态流方案', '', 1),
(10100, '敏捷开发状态流方案', '敏捷开发适用', 1),
(10101, '普通的软件开发状态流方案', '', 1),
(10102, '流程管理状态流方案', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `workflow_scheme_data`
--

CREATE TABLE `workflow_scheme_data` (
                                        `id` int UNSIGNED NOT NULL,
                                        `scheme_id` int UNSIGNED DEFAULT NULL,
                                        `issue_type_id` int UNSIGNED DEFAULT NULL,
                                        `workflow_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `workflow_scheme_data`
--

INSERT INTO `workflow_scheme_data` (`id`, `scheme_id`, `issue_type_id`, `workflow_id`) VALUES
(10000, 1, 0, 1),
(10105, 10100, 0, 1),
(10200, 10200, 10105, 1),
(10201, 10200, 0, 1),
(10202, 10201, 10105, 1),
(10203, 10201, 0, 1),
(10300, 10300, 0, 1),
(10307, 10307, 1, 1),
(10308, 10307, 2, 2),
(10311, 10101, 2, 1),
(10312, 10101, 0, 1),
(10319, 10305, 1, 2),
(10320, 10305, 2, 2),
(10321, 10305, 4, 2),
(10322, 10305, 5, 2),
(10323, 10102, 2, 1),
(10324, 10102, 0, 1),
(10325, 10102, 10105, 1);

--
-- 转储表的索引
--

--
-- 表的索引 `agile_board`
--


--
-- 表的索引 `agile_board_column`
--
ALTER TABLE `agile_board_column`
    ADD PRIMARY KEY (`id`),
    ADD KEY `board_id` (`board_id`),
    ADD KEY `id_and_weight` (`id`,`weight`) USING BTREE;

--
-- 表的索引 `agile_sprint`
--
ALTER TABLE `agile_sprint`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
    ADD PRIMARY KEY (`id`),
    ADD KEY `sprint_id` (`sprint_id`),
    ADD KEY `sprintIdAndDate` (`sprint_id`,`date`);

--
-- 表的索引 `field_custom_value`
--
ALTER TABLE `field_custom_value`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique_index` (`issue_id`,`project_id`,`custom_field_id`) USING BTREE,
    ADD KEY `issue_id` (`issue_id`),
    ADD KEY `issue_id_2` (`issue_id`,`project_id`),
    ADD KEY `union_issue_custom` (`issue_id`,`custom_field_id`) USING BTREE;

--
-- 表的索引 `field_layout_default`
--
ALTER TABLE `field_layout_default`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `field_layout_project_custom`
--
ALTER TABLE `field_layout_project_custom`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `field_main`
--
ALTER TABLE `field_main`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_fli_fieldidentifier` (`name`),
    ADD KEY `order_weight` (`order_weight`),
    ADD KEY `is_system` (`is_system`);

--
-- 表的索引 `field_type`
--
ALTER TABLE `field_type`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `type` (`type`) USING BTREE;

--
-- 表的索引 `hornet_cache_key`
--
ALTER TABLE `hornet_cache_key`
    ADD PRIMARY KEY (`key`),
    ADD UNIQUE KEY `module_key` (`key`,`module`) USING BTREE,
    ADD KEY `module` (`module`),
    ADD KEY `expire` (`expire`);

--
-- 表的索引 `hornet_user`
--
ALTER TABLE `hornet_user`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `phone_unique` (`phone`) USING BTREE,
    ADD KEY `phone` (`phone`,`password`),
    ADD KEY `email` (`email`);

--
-- 表的索引 `issue_assistant`
--
ALTER TABLE `issue_assistant`
    ADD PRIMARY KEY (`id`),
    ADD KEY `issue_id` (`issue_id`);

--
-- 表的索引 `issue_description_template`
--
ALTER TABLE `issue_description_template`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_effect_version`
--
ALTER TABLE `issue_effect_version`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_extra_worker_day`
--
ALTER TABLE `issue_extra_worker_day`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_field_layout_project`
--
ALTER TABLE `issue_field_layout_project`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_fli_fieldidentifier` (`fieldidentifier`);

--
-- 表的索引 `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
    ADD PRIMARY KEY (`id`),
    ADD KEY `attach_issue` (`issue_id`),
    ADD KEY `uuid` (`uuid`),
    ADD KEY `tmp_issue_id` (`tmp_issue_id`);

--
-- 表的索引 `issue_filter`
--
ALTER TABLE `issue_filter`
    ADD PRIMARY KEY (`id`),
    ADD KEY `sr_author` (`author`),
    ADD KEY `searchrequest_filternameLower` (`name_lower`);

--
-- 表的索引 `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_follow`
--
ALTER TABLE `issue_follow`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `issue_id` (`issue_id`,`user_id`);

--
-- 表的索引 `issue_holiday`
--
ALTER TABLE `issue_holiday`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_label`
--
ALTER TABLE `issue_label`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `issue_label_data`
--
ALTER TABLE `issue_label_data`
    ADD PRIMARY KEY (`id`),
    ADD KEY `issue_id` (`issue_id`),
    ADD KEY `label_id` (`label_id`);

--
-- 表的索引 `issue_main`
--
ALTER TABLE `issue_main`
    ADD PRIMARY KEY (`id`),
    ADD KEY `issue_created` (`created`),
    ADD KEY `issue_updated` (`updated`),
    ADD KEY `issue_duedate` (`due_date`),
    ADD KEY `issue_assignee` (`assignee`),
    ADD KEY `issue_reporter` (`reporter`),
    ADD KEY `pkey` (`pkey`),
    ADD KEY `summary` (`summary`),
    ADD KEY `backlog_weight` (`backlog_weight`),
    ADD KEY `sprint_weight` (`sprint_weight`),
    ADD KEY `status` (`status`),
    ADD KEY `gant_sprint_weight` (`gant_sprint_weight`),
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `issue_moved_issue_key`
--
ALTER TABLE `issue_moved_issue_key`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `idx_old_issue_key` (`old_issue_key`);

--
-- 表的索引 `issue_priority`
--
ALTER TABLE `issue_priority`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `_key` (`_key`);

--
-- 表的索引 `issue_recycle`
--
ALTER TABLE `issue_recycle`
    ADD PRIMARY KEY (`id`),
    ADD KEY `issue_assignee` (`assignee`),
    ADD KEY `summary` (`summary`),
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `issue_resolve`
--
ALTER TABLE `issue_resolve`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `_key` (`_key`);

--
-- 表的索引 `issue_status`
--
ALTER TABLE `issue_status`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `key` (`_key`);

--
-- 表的索引 `issue_type`
--
ALTER TABLE `issue_type`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `_key` (`_key`);

--
-- 表的索引 `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
    ADD PRIMARY KEY (`id`),
    ADD KEY `scheme_id` (`scheme_id`);

--
-- 表的索引 `issue_ui`
--
ALTER TABLE `issue_ui`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_ui_scheme`
--
ALTER TABLE `issue_ui_scheme`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
    ADD PRIMARY KEY (`id`),
    ADD KEY `issue_id` (`issue_type_id`) USING BTREE;

--
-- 表的索引 `log_base`
--
ALTER TABLE `log_base`
    ADD PRIMARY KEY (`id`),
    ADD KEY `uid` (`uid`),
    ADD KEY `obj_id` (`obj_id`) USING BTREE,
    ADD KEY `like_query` (`uid`,`action`,`remark`) USING BTREE;

--
-- 表的索引 `log_operating`
--
ALTER TABLE `log_operating`
    ADD PRIMARY KEY (`id`),
    ADD KEY `uid` (`uid`),
    ADD KEY `obj_id` (`obj_id`) USING BTREE,
    ADD KEY `like_query` (`uid`,`action`,`remark`) USING BTREE;

--
-- 表的索引 `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `file_line_unique` (`md5`),
    ADD KEY `date` (`date`);

--
-- 表的索引 `main_action`
--
ALTER TABLE `main_action`
    ADD PRIMARY KEY (`id`),
    ADD KEY `action_author_created` (`author`,`created`),
    ADD KEY `action_issue` (`issueid`);

--
-- 表的索引 `main_activity`
--
ALTER TABLE `main_activity`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`),
    ADD KEY `project_id` (`project_id`),
    ADD KEY `date` (`date`);

--
-- 表的索引 `main_announcement`
--
ALTER TABLE `main_announcement`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_cache_key`
--
ALTER TABLE `main_cache_key`
    ADD PRIMARY KEY (`key`),
    ADD UNIQUE KEY `module_key` (`key`,`module`) USING BTREE,
    ADD KEY `module` (`module`),
    ADD KEY `expire` (`expire`);

--
-- 表的索引 `main_eventtype`
--
ALTER TABLE `main_eventtype`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_group`
--
ALTER TABLE `main_group`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `seq` (`seq`) USING BTREE,
    ADD KEY `status` (`status`);

--
-- 表的索引 `main_notify_scheme`
--
ALTER TABLE `main_notify_scheme`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_notify_scheme_data`
--
ALTER TABLE `main_notify_scheme_data`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_org`
--
ALTER TABLE `main_org`
    ADD PRIMARY KEY (`id`),
    ADD KEY `path` (`path`),
    ADD KEY `name` (`name`);

--
-- 表的索引 `main_plugin`
--
ALTER TABLE `main_plugin`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `name` (`name`),
    ADD KEY `order_weight` (`order_weight`),
    ADD KEY `type` (`type`);

--
-- 表的索引 `main_setting`
--
ALTER TABLE `main_setting`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `_key` (`_key`),
    ADD KEY `module` (`module`) USING BTREE,
    ADD KEY `module_2` (`module`,`order_weight`);

--
-- 表的索引 `main_timeline`
--
ALTER TABLE `main_timeline`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_webhook`
--
ALTER TABLE `main_webhook`
    ADD UNIQUE KEY `id` (`id`),
    ADD KEY `enable` (`enable`);

--
-- 表的索引 `main_webhook_log`
--
ALTER TABLE `main_webhook_log`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_widget`
--
ALTER TABLE `main_widget`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `_key` (`_key`) USING BTREE,
    ADD KEY `order_weight` (`order_weight`);

--
-- 表的索引 `mind_issue_attribute`
--
ALTER TABLE `mind_issue_attribute`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_id_2` (`project_id`,`issue_id`,`source`,`group_by`),
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `mind_project_attribute`
--
ALTER TABLE `mind_project_attribute`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_id` (`project_id`);

--
-- 表的索引 `mind_second_attribute`
--
ALTER TABLE `mind_second_attribute`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `mind_unique` (`project_id`,`source`,`group_by`,`group_by_id`) USING BTREE,
    ADD KEY `project_id` (`project_id`),
    ADD KEY `source_group_by` (`project_id`,`source`,`group_by`) USING BTREE;

--
-- 表的索引 `mind_sprint_attribute`
--
ALTER TABLE `mind_sprint_attribute`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `sprint_id` (`sprint_id`);

--
-- 表的索引 `permission_default_role`
--
ALTER TABLE `permission_default_role`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_tpl_id` (`project_tpl_id`);

--
-- 表的索引 `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
    ADD PRIMARY KEY (`id`),
    ADD KEY `default_role_id` (`role_id`),
    ADD KEY `role_id-and-perm_id` (`role_id`,`perm_id`);

--
-- 表的索引 `permission_global`
--
ALTER TABLE `permission_global`
    ADD PRIMARY KEY (`id`) USING BTREE,
    ADD KEY `permission_global_key_idx` (`_key`) USING BTREE;

--
-- 表的索引 `permission_global_group`
--
ALTER TABLE `permission_global_group`
    ADD PRIMARY KEY (`id`),
    ADD KEY `perm_global_id` (`perm_global_id`),
    ADD KEY `group_id` (`group_id`);

--
-- 表的索引 `permission_global_role`
--
ALTER TABLE `permission_global_role`
    ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `permission_global_role_relation`
--
ALTER TABLE `permission_global_role_relation`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique` (`perm_global_id`,`role_id`) USING BTREE,
    ADD KEY `perm_global_id` (`perm_global_id`);

--
-- 表的索引 `permission_global_user_role`
--
ALTER TABLE `permission_global_user_role`
    ADD PRIMARY KEY (`id`) USING BTREE,
    ADD UNIQUE KEY `unique` (`user_id`,`role_id`) USING BTREE,
    ADD KEY `uid` (`user_id`) USING BTREE;

--
-- 表的索引 `project_catalog_label`
--
ALTER TABLE `project_catalog_label`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_id` (`project_id`),
    ADD KEY `project_id_2` (`project_id`,`order_weight`);

--
-- 表的索引 `project_category`
--
ALTER TABLE `project_category`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_project_category_name` (`name`);

--
-- 表的索引 `project_flag`
--
ALTER TABLE `project_flag`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_id` (`project_id`,`flag`);

--
-- 表的索引 `project_gantt_setting`
--
ALTER TABLE `project_gantt_setting`
    ADD PRIMARY KEY (`id`) USING BTREE,
    ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE;

--
-- 表的索引 `project_issue_report`
--
ALTER TABLE `project_issue_report`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_id` (`project_id`),
    ADD KEY `projectIdAndDate` (`project_id`,`date`);

--
-- 表的索引 `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE,
    ADD KEY `issue_type_scheme_id` (`issue_type_scheme_id`) USING BTREE;

--
-- 表的索引 `project_key`
--
ALTER TABLE `project_key`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `idx_all_project_keys` (`project_key`),
    ADD KEY `idx_all_project_ids` (`project_id`);

--
-- 表的索引 `project_label`
--
ALTER TABLE `project_label`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `project_list_count`
--
ALTER TABLE `project_list_count`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `project_main`
--
ALTER TABLE `project_main`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `idx_project_key` (`key`),
    ADD UNIQUE KEY `name` (`name`) USING BTREE,
    ADD KEY `uid` (`create_uid`);

--
-- 表的索引 `project_main_extra`
--
ALTER TABLE `project_main_extra`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE;

--
-- 表的索引 `project_mind_setting`
--
ALTER TABLE `project_mind_setting`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_id` (`project_id`,`setting_key`),
    ADD KEY `project_id_2` (`project_id`);

--
-- 表的索引 `project_module`
--
ALTER TABLE `project_module`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_id` (`project_id`) USING BTREE;

--
-- 表的索引 `project_permission`
--
ALTER TABLE `project_permission`
    ADD PRIMARY KEY (`id`) USING BTREE,
    ADD KEY `project_permission_key_idx` (`_key`) USING BTREE;

--
-- 表的索引 `project_role`
--
ALTER TABLE `project_role`
    ADD PRIMARY KEY (`id`),
    ADD KEY `p[roject_id` (`project_id`) USING BTREE;

--
-- 表的索引 `project_role_relation`
--
ALTER TABLE `project_role_relation`
    ADD PRIMARY KEY (`id`),
    ADD KEY `role_id` (`role_id`),
    ADD KEY `role_id-and-perm_id` (`role_id`,`perm_id`),
    ADD KEY `unique_data` (`project_id`,`role_id`,`perm_id`);

--
-- 表的索引 `project_template`
--
ALTER TABLE `project_template`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `project_template_display_category`
--
ALTER TABLE `project_template_display_category`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `project_tpl_category`
--
ALTER TABLE `project_tpl_category`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_project_category_name` (`name`);

--
-- 表的索引 `project_tpl_category_label`
--
ALTER TABLE `project_tpl_category_label`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_tpl_id` (`project_tpl_id`);

--
-- 表的索引 `project_tpl_label`
--
ALTER TABLE `project_tpl_label`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_tpl_id` (`project_tpl_id`);

--
-- 表的索引 `project_tpl_module`
--
ALTER TABLE `project_tpl_module`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_tpl_id` (`project_tpl_id`) USING BTREE;

--
-- 表的索引 `project_tpl_widget`
--
ALTER TABLE `project_tpl_widget`
    ADD PRIMARY KEY (`id`),
    ADD KEY `project_tpl_id` (`project_tpl_id`);

--
-- 表的索引 `project_user_role`
--
ALTER TABLE `project_user_role`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique` (`user_id`,`project_id`,`role_id`) USING BTREE,
    ADD KEY `uid` (`user_id`) USING BTREE,
    ADD KEY `uid_project` (`user_id`,`project_id`) USING BTREE;

--
-- 表的索引 `project_version`
--
ALTER TABLE `project_version`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `project_name_unique` (`project_id`,`name`) USING BTREE,
    ADD KEY `idx_version_project` (`project_id`),
    ADD KEY `idx_version_sequence` (`sequence`);

--
-- 表的索引 `project_workflows`
--
ALTER TABLE `project_workflows`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `project_workflow_status`
--
ALTER TABLE `project_workflow_status`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_parent_name` (`parentname`);

--
-- 表的索引 `report_project_issue`
--
ALTER TABLE `report_project_issue`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `projectIdAndDate` (`project_id`,`date`) USING BTREE,
    ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `sprintIdAndDate` (`sprint_id`,`date`) USING BTREE,
    ADD KEY `sprint_id` (`sprint_id`);

--
-- 表的索引 `service_config`
--
ALTER TABLE `service_config`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_application`
--
ALTER TABLE `user_application`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `uk_application_name` (`lower_application_name`);

--
-- 表的索引 `user_attributes`
--
ALTER TABLE `user_attributes`
    ADD PRIMARY KEY (`id`),
    ADD KEY `uk_user_attr_name_lval` (`user_id`,`attribute_name`),
    ADD KEY `idx_user_attr_dir_name_lval` (`directory_id`,`attribute_name`(240),`lower_attribute_value`(240)) USING BTREE;

--
-- 表的索引 `user_email_active`
--
ALTER TABLE `user_email_active`
    ADD PRIMARY KEY (`id`),
    ADD KEY `email` (`email`,`verify_code`);

--
-- 表的索引 `user_email_find_password`
--
ALTER TABLE `user_email_find_password`
    ADD PRIMARY KEY (`email`),
    ADD UNIQUE KEY `email` (`email`,`verify_code`);

--
-- 表的索引 `user_email_token`
--
ALTER TABLE `user_email_token`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_group`
--
ALTER TABLE `user_group`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `unique` (`uid`,`group_id`) USING BTREE,
    ADD KEY `uid` (`uid`),
    ADD KEY `group_id` (`group_id`);

--
-- 表的索引 `user_invite`
--
ALTER TABLE `user_invite`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `email` (`email`),
    ADD KEY `token` (`token`);

--
-- 表的索引 `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
    ADD PRIMARY KEY (`id`),
    ADD KEY `ip` (`ip`);

--
-- 表的索引 `user_issue_display_fields`
--
ALTER TABLE `user_issue_display_fields`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `user_fields` (`user_id`,`project_id`) USING BTREE;

--
-- 表的索引 `user_issue_last_create_data`
--
ALTER TABLE `user_issue_last_create_data`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `user_id` (`user_id`,`project_id`);

--
-- 表的索引 `user_login_log`
--
ALTER TABLE `user_login_log`
    ADD PRIMARY KEY (`id`),
    ADD KEY `uid` (`uid`);

--
-- 表的索引 `user_main`
--
ALTER TABLE `user_main`
    ADD PRIMARY KEY (`uid`),
    ADD UNIQUE KEY `openid` (`openid`),
    ADD UNIQUE KEY `email` (`email`) USING BTREE,
    ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- 表的索引 `user_message`
--
ALTER TABLE `user_message`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_password`
--
ALTER TABLE `user_password`
    ADD PRIMARY KEY (`user_id`);

--
-- 表的索引 `user_password_strategy`
--
ALTER TABLE `user_password_strategy`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_phone_find_password`
--
ALTER TABLE `user_phone_find_password`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `username` (`phone`);

--
-- 表的索引 `user_posted_flag`
--
ALTER TABLE `user_posted_flag`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`,`_date`,`ip`),
    ADD KEY `user_id_2` (`user_id`,`_date`);

--
-- 表的索引 `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
    ADD PRIMARY KEY (`uid`),
    ADD KEY `refresh_token` (`refresh_token`(255));

--
-- 表的索引 `user_setting`
--
ALTER TABLE `user_setting`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `user_id` (`user_id`,`_key`),
    ADD KEY `uid` (`user_id`);

--
-- 表的索引 `user_token`
--
ALTER TABLE `user_token`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user_widget`
--
ALTER TABLE `user_widget`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`,`widget_id`),
    ADD KEY `order_weight` (`order_weight`);

--
-- 表的索引 `workflow`
--
ALTER TABLE `workflow`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `workflow_block`
--
ALTER TABLE `workflow_block`
    ADD PRIMARY KEY (`id`),
    ADD KEY `workflow_id` (`workflow_id`);

--
-- 表的索引 `workflow_connector`
--
ALTER TABLE `workflow_connector`
    ADD PRIMARY KEY (`id`),
    ADD KEY `workflow_id` (`workflow_id`);

--
-- 表的索引 `workflow_scheme`
--
ALTER TABLE `workflow_scheme`
    ADD PRIMARY KEY (`id`);

--
-- 表的索引 `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
    ADD PRIMARY KEY (`id`),
    ADD KEY `workflow_scheme` (`scheme_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `agile_board`
--
ALTER TABLE `agile_board`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `agile_board_column`
--
ALTER TABLE `agile_board_column`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- 使用表AUTO_INCREMENT `agile_sprint`
--
ALTER TABLE `agile_sprint`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_custom_value`
--
ALTER TABLE `field_custom_value`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_main`
--
ALTER TABLE `field_main`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用表AUTO_INCREMENT `hornet_user`
--
ALTER TABLE `hornet_user`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 使用表AUTO_INCREMENT `issue_assistant`
--
ALTER TABLE `issue_assistant`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_description_template`
--
ALTER TABLE `issue_description_template`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `issue_effect_version`
--
ALTER TABLE `issue_effect_version`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_extra_worker_day`
--
ALTER TABLE `issue_extra_worker_day`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_follow`
--
ALTER TABLE `issue_follow`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_holiday`
--
ALTER TABLE `issue_holiday`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_label`
--
ALTER TABLE `issue_label`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `issue_label_data`
--
ALTER TABLE `issue_label_data`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_main`
--
ALTER TABLE `issue_main`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_priority`
--
ALTER TABLE `issue_priority`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_recycle`
--
ALTER TABLE `issue_recycle`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_resolve`
--
ALTER TABLE `issue_resolve`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10102;

--
-- 使用表AUTO_INCREMENT `issue_status`
--
ALTER TABLE `issue_status`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10102;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2283;

--
-- 使用表AUTO_INCREMENT `issue_ui_scheme`
--
ALTER TABLE `issue_ui_scheme`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- 使用表AUTO_INCREMENT `log_base`
--
ALTER TABLE `log_base`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `log_operating`
--
ALTER TABLE `log_operating`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用表AUTO_INCREMENT `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_activity`
--
ALTER TABLE `main_activity`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_group`
--
ALTER TABLE `main_group`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `main_notify_scheme`
--
ALTER TABLE `main_notify_scheme`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `main_notify_scheme_data`
--
ALTER TABLE `main_notify_scheme_data`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `main_org`
--
ALTER TABLE `main_org`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- 使用表AUTO_INCREMENT `main_plugin`
--
ALTER TABLE `main_plugin`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用表AUTO_INCREMENT `main_setting`
--
ALTER TABLE `main_setting`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_webhook`
--
ALTER TABLE `main_webhook`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `main_webhook_log`
--
ALTER TABLE `main_webhook_log`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_widget`
--
ALTER TABLE `main_widget`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `mind_issue_attribute`
--
ALTER TABLE `mind_issue_attribute`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- 使用表AUTO_INCREMENT `mind_project_attribute`
--
ALTER TABLE `mind_project_attribute`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `mind_second_attribute`
--
ALTER TABLE `mind_second_attribute`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- 使用表AUTO_INCREMENT `mind_sprint_attribute`
--
ALTER TABLE `mind_sprint_attribute`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `permission_default_role`
--
ALTER TABLE `permission_default_role`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10020;

--
-- 使用表AUTO_INCREMENT `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

--
-- 使用表AUTO_INCREMENT `permission_global`
--
ALTER TABLE `permission_global`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `permission_global_group`
--
ALTER TABLE `permission_global_group`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `permission_global_role`
--
ALTER TABLE `permission_global_role`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `permission_global_role_relation`
--
ALTER TABLE `permission_global_role_relation`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `permission_global_user_role`
--
ALTER TABLE `permission_global_user_role`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5672;

--
-- 使用表AUTO_INCREMENT `project_catalog_label`
--
ALTER TABLE `project_catalog_label`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=870;

--
-- 使用表AUTO_INCREMENT `project_category`
--
ALTER TABLE `project_category`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_flag`
--
ALTER TABLE `project_flag`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_gantt_setting`
--
ALTER TABLE `project_gantt_setting`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_issue_report`
--
ALTER TABLE `project_issue_report`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- 使用表AUTO_INCREMENT `project_label`
--
ALTER TABLE `project_label`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=616;

--
-- 使用表AUTO_INCREMENT `project_list_count`
--
ALTER TABLE `project_list_count`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_main`
--
ALTER TABLE `project_main`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- 使用表AUTO_INCREMENT `project_main_extra`
--
ALTER TABLE `project_main_extra`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_mind_setting`
--
ALTER TABLE `project_mind_setting`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_module`
--
ALTER TABLE `project_module`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_permission`
--
ALTER TABLE `project_permission`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_template`
--
ALTER TABLE `project_template`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `project_template_display_category`
--
ALTER TABLE `project_template_display_category`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `project_tpl_category`
--
ALTER TABLE `project_tpl_category`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_tpl_category_label`
--
ALTER TABLE `project_tpl_category_label`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `project_tpl_label`
--
ALTER TABLE `project_tpl_label`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_tpl_module`
--
ALTER TABLE `project_tpl_module`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_tpl_widget`
--
ALTER TABLE `project_tpl_widget`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '主键id';

--
-- 使用表AUTO_INCREMENT `project_user_role`
--
ALTER TABLE `project_user_role`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_version`
--
ALTER TABLE `project_version`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `report_project_issue`
--
ALTER TABLE `report_project_issue`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_email_active`
--
ALTER TABLE `user_email_active`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `user_email_token`
--
ALTER TABLE `user_email_token`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- 使用表AUTO_INCREMENT `user_invite`
--
ALTER TABLE `user_invite`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_issue_display_fields`
--
ALTER TABLE `user_issue_display_fields`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用表AUTO_INCREMENT `user_issue_last_create_data`
--
ALTER TABLE `user_issue_last_create_data`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
    MODIFY `uid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12264;

--
-- 使用表AUTO_INCREMENT `user_message`
--
ALTER TABLE `user_message`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_phone_find_password`
--
ALTER TABLE `user_phone_find_password`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `user_posted_flag`
--
ALTER TABLE `user_posted_flag`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
    MODIFY `uid` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_setting`
--
ALTER TABLE `user_setting`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=615;

--
-- 使用表AUTO_INCREMENT `user_token`
--
ALTER TABLE `user_token`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `user_widget`
--
ALTER TABLE `user_widget`
    MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=2916;

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `workflow_block`
--
ALTER TABLE `workflow_block`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `workflow_connector`
--
ALTER TABLE `workflow_connector`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `workflow_scheme`
--
ALTER TABLE `workflow_scheme`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10104;

--
-- 使用表AUTO_INCREMENT `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
    MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10326;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
