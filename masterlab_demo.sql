-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-09-12 13:23:07
-- 服务器版本： 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masterlab_demo`
--

-- --------------------------------------------------------

--
-- 表的结构 `agile_board`
--

CREATE TABLE `agile_board` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `type` enum('status','issue_type','label','module','resolve','priority','assignee') DEFAULT NULL,
  `is_filter_backlog` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `is_filter_closed` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `agile_board`
--

INSERT INTO `agile_board` (`id`, `name`, `project_id`, `type`, `is_filter_backlog`, `is_filter_closed`, `weight`) VALUES
(1, 'Active Sprint', 0, NULL, 1, 1, 99999),
(2, 'LabelS', 10003, 'label', 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `agile_board_column`
--

CREATE TABLE `agile_board_column` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `board_id` int(11) UNSIGNED NOT NULL,
  `data` varchar(1000) NOT NULL,
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `agile_board_column`
--

INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES
(1, 'Todo', 1, '[\"open\",\"reopen\",\"todo\",\"delay\"]', 3),
(2, 'In progress', 1, '[\"in_progress\",\"in_review\"]', 2),
(3, 'Done', 1, '[\"resolved\",\"closed\",\"done\"]', 1),
(4, 'Simple', 2, '[\"1\",\"2\"]', 0),
(5, 'Normal', 2, '[\"3\"]', 0);

-- --------------------------------------------------------

--
-- 表的结构 `agile_sprint`
--

CREATE TABLE `agile_sprint` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `order_weight` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `agile_sprint_issue_report`
--

CREATE TABLE `agile_sprint_issue_report` (
  `id` int(10) UNSIGNED NOT NULL,
  `sprint_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `done_count` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `no_done_count` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `done_count_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `no_done_count_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `audit_changed_value`
--

CREATE TABLE `audit_changed_value` (
  `id` decimal(18,0) NOT NULL,
  `log_id` decimal(18,0) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `delta_from` longtext,
  `delta_to` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `audit_item`
--

CREATE TABLE `audit_item` (
  `id` decimal(18,0) NOT NULL,
  `log_id` decimal(18,0) DEFAULT NULL,
  `object_type` varchar(60) DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `object_name` varchar(255) DEFAULT NULL,
  `object_parent_id` varchar(255) DEFAULT NULL,
  `object_parent_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `audit_log`
--

CREATE TABLE `audit_log` (
  `id` decimal(18,0) NOT NULL,
  `remote_address` varchar(60) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `author_key` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `object_type` varchar(60) DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `object_name` varchar(255) DEFAULT NULL,
  `object_parent_id` varchar(255) DEFAULT NULL,
  `object_parent_name` varchar(255) DEFAULT NULL,
  `author_type` decimal(9,0) DEFAULT NULL,
  `event_source_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `long_description` longtext,
  `search_field` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `changeitem`
--

CREATE TABLE `changeitem` (
  `id` decimal(18,0) NOT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `fieldtype` varchar(32) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `oldvalue` longtext,
  `oldstring` longtext,
  `newvalue` longtext,
  `newstring` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `field_custom_value`
--

CREATE TABLE `field_custom_value` (
  `id` decimal(18,0) NOT NULL,
  `issue_id` decimal(18,0) DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `custom_field_id` decimal(18,0) DEFAULT NULL,
  `parent_key` varchar(255) DEFAULT NULL,
  `string_value` varchar(255) DEFAULT NULL,
  `number_value` decimal(18,6) DEFAULT NULL,
  `text_value` longtext,
  `date_value` datetime DEFAULT NULL,
  `valuet_ype` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `field_layout_default`
--

CREATE TABLE `field_layout_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_type` int(11) UNSIGNED DEFAULT NULL,
  `issue_ui_type` tinyint(1) UNSIGNED DEFAULT '1',
  `field_id` int(11) UNSIGNED DEFAULT '0',
  `verticalposition` decimal(18,0) DEFAULT NULL,
  `ishidden` varchar(60) DEFAULT NULL,
  `isrequired` varchar(60) DEFAULT NULL,
  `sequence` int(11) UNSIGNED DEFAULT NULL,
  `tab` int(11) UNSIGNED DEFAULT NULL
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
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `issue_type` int(11) UNSIGNED DEFAULT NULL,
  `issue_ui_type` tinyint(2) UNSIGNED DEFAULT NULL,
  `field_id` int(11) UNSIGNED DEFAULT '0',
  `verticalposition` decimal(18,0) DEFAULT NULL,
  `ishidden` varchar(60) DEFAULT NULL,
  `isrequired` varchar(60) DEFAULT NULL,
  `sequence` int(11) UNSIGNED DEFAULT NULL,
  `tab` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `field_main`
--

CREATE TABLE `field_main` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(512) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0',
  `options` varchar(5000) DEFAULT '' COMMENT '{}',
  `order_weight` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `field_main`
--

INSERT INTO `field_main` (`id`, `name`, `title`, `description`, `type`, `default_value`, `is_system`, `options`, `order_weight`) VALUES
(1, 'summary', '标 题', NULL, 'TEXT', NULL, 1, NULL, 0),
(2, 'priority', '优先级', NULL, 'PRIORITY', NULL, 1, NULL, 0),
(3, 'fix_version', '解决版本', NULL, 'VERSION', NULL, 1, NULL, 0),
(4, 'assignee', '经办人', NULL, 'USER', NULL, 1, NULL, 0),
(5, 'reporter', '报告人', NULL, 'USER', NULL, 1, NULL, 0),
(6, 'description', '描 述', NULL, 'MARKDOWN', NULL, 1, NULL, 0),
(7, 'module', '模 块', NULL, 'MODULE', NULL, 1, NULL, 0),
(8, 'labels', '标 签', NULL, 'LABELS', NULL, 1, NULL, 0),
(9, 'environment', '运行环境', '如操作系统，软件平台，硬件环境', 'TEXT', NULL, 1, NULL, 0),
(10, 'resolve', '解决结果', '主要是面向测试工作着和产品经理', 'RESOLUTION', NULL, 1, NULL, 0),
(11, 'attachment', '附 件', NULL, 'UPLOAD_FILE', NULL, 1, NULL, 0),
(12, 'start_date', '开始日期', NULL, 'DATE', NULL, 1, '', 0),
(13, 'due_date', '结束日期', NULL, 'DATE', NULL, 1, NULL, 0),
(14, 'milestone', '里程碑', NULL, 'MILESTONE', NULL, 1, '', 0),
(15, 'sprint', '迭 代', NULL, 'SPRINT', NULL, 1, '', 0),
(17, 'parent_issue', '父事项', NULL, 'ISSUES', NULL, 1, '', 0),
(18, 'effect_version', '影响版本', NULL, 'VERSION', NULL, 1, '', 0),
(19, 'status', '状 态', NULL, 'STATUS', '1', 1, '', 950),
(20, 'assistants', '协助人', '协助人', 'USER_MULTI', NULL, 1, '', 900);

-- --------------------------------------------------------

--
-- 表的结构 `field_type`
--

CREATE TABLE `field_type` (
  `id` int(11) UNSIGNED NOT NULL,
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
(18, 'GROUP', NULL, 'GROUP'),
(19, 'GROUP_MULTI', NULL, 'GROUP_MULTI'),
(20, 'MODULE', NULL, 'MODULE'),
(21, 'Milestone', NULL, 'MILESTONE'),
(22, 'Sprint', NULL, 'SPRINT'),
(25, 'Reslution', NULL, 'RESOLUTION'),
(26, 'Issues', NULL, 'ISSUES'),
(27, 'Markdown', NULL, 'MARKDOWN'),
(28, 'USER_MULTI', NULL, 'USER_MULTI');

-- --------------------------------------------------------

--
-- 表的结构 `issue_assistant`
--

CREATE TABLE `issue_assistant` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `join_time` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_assistant`
--

INSERT INTO `issue_assistant` (`id`, `issue_id`, `user_id`, `join_time`) VALUES
(0, 18274, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_description_template`
--

CREATE TABLE `issue_description_template` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新增事项时描述的模板';

--
-- 转存表中的数据 `issue_description_template`
--

INSERT INTO `issue_description_template` (`id`, `name`, `content`) VALUES
(1, 'bug', '\r\n描述内容...\r\n\r\n## 重新步骤\r\n1. 步骤1\r\n\r\n2. 步骤2\r\n\r\n3. 步骤3\r\n\r\n## 期望结果 \r\n\r\n\r\n## 实际结果\r\n\r\n'),
(2, '新功能', '\r\n一句话概括并描述新功能\r\n\r\n## 功能点：\r\n\r\n## 规则\r\n\r\n## 影响\r\n\r\n');

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
  `id` int(11) UNSIGNED NOT NULL,
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `issue_id` int(11) DEFAULT '0',
  `mime_type` varchar(64) DEFAULT '',
  `origin_name` varchar(128) NOT NULL DEFAULT '',
  `file_name` varchar(255) DEFAULT '',
  `created` int(11) DEFAULT '0',
  `file_size` int(11) DEFAULT '0',
  `author` int(11) DEFAULT '0',
  `file_ext` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_file_attachment`
--

INSERT INTO `issue_file_attachment` (`id`, `uuid`, `issue_id`, `mime_type`, `origin_name`, `file_name`, `created`, `file_size`, `author`, `file_ext`) VALUES
(103, 'uuid-712532', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978581, 44055, 0, 'png'),
(104, 'uuid-993467', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978581, 44055, 0, 'png'),
(105, 'uuid-772198', 17498, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978645, 44055, 0, 'png'),
(106, 'uuid-146109', 17498, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978645, 44055, 0, 'png'),
(107, 'uuid-465118', 17519, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978896, 44055, 0, 'png'),
(108, 'uuid-59892', 17519, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978896, 44055, 0, 'png'),
(115, 'uuid-277157', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980570, 44055, 0, 'png'),
(116, 'uuid-146026', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980570, 44055, 0, 'png'),
(117, 'uuid-975366', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980625, 44055, 0, 'png'),
(118, 'uuid-833512', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980625, 44055, 0, 'png'),
(121, 'uuid-511211', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980688, 44055, 0, 'png'),
(122, 'uuid-763956', 0, 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980688, 44055, 0, 'png'),
(129, '', 0, 'application/octet-stream', '', 'all/20180903/20180903213321_46866.png', 1535981601, 0, 11159, 'png'),
(132, '', 0, 'application/octet-stream', '', 'all/20180903/20180903213345_35880.png', 1535981625, 0, 11160, 'png'),
(144, '0AiNJtaJ1qoS6LDe573167', 0, 'application/octet-stream', 'sample.png', 'all/20180903/20180903215007_66586.png', 1535982607, 0, 11164, 'png'),
(181, '7kqrIJwuJAf8No7g804506', 0, 'application/octet-stream', 'sample.png', 'image/20180904/20180904104101_69813.png', 1536028861, 44055, 11177, 'png'),
(183, 'ded1ff3e-d609-4b88-9bd2-6adad6108728', 18273, 'image/png', '1.png', 'all/20180909/20180909033816_97784.png', 1536435496, 899531, 10000, 'png');

-- --------------------------------------------------------

--
-- 表的结构 `issue_filter`
--

CREATE TABLE `issue_filter` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `share_obj` varchar(255) DEFAULT NULL,
  `share_scope` varchar(20) DEFAULT NULL COMMENT 'all,group,uid,project,origin',
  `projectid` decimal(18,0) DEFAULT NULL,
  `filter` longtext,
  `fav_count` decimal(18,0) DEFAULT NULL,
  `name_lower` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_fix_version`
--

CREATE TABLE `issue_fix_version` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
  `version_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_fix_version`
--

INSERT INTO `issue_fix_version` (`id`, `issue_id`, `version_id`) VALUES
(3, 16937, 9),
(4, 16937, 10),
(5, 18155, 75),
(6, 18178, 76),
(7, 18201, 77),
(8, 18224, 78),
(9, 18247, 79),
(10, 18270, 80),
(11, 18271, 0),
(12, 18272, 4),
(27, 18274, 3),
(28, 18274, 4);

-- --------------------------------------------------------

--
-- 表的结构 `issue_follow`
--

CREATE TABLE `issue_follow` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_follow`
--

INSERT INTO `issue_follow` (`id`, `issue_id`, `user_id`) VALUES
(1, 16937, 10000);

-- --------------------------------------------------------

--
-- 表的结构 `issue_label`
--

CREATE TABLE `issue_label` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
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
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
  `label_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_label_data`
--

INSERT INTO `issue_label_data` (`id`, `issue_id`, `label_id`) VALUES
(1, 16937, 1),
(2, 16937, 2),
(3, 17120, 296),
(4, 17141, 298),
(5, 17162, 300),
(6, 17183, 302),
(7, 17204, 304),
(8, 17225, 306),
(9, 17246, 308),
(10, 17267, 310),
(11, 17288, 312),
(12, 17309, 314),
(13, 17330, 316),
(14, 17351, 318),
(15, 17372, 320),
(16, 17393, 322),
(17, 17414, 324),
(18, 17435, 326),
(19, 17456, 328),
(20, 17477, 330),
(21, 17498, 332),
(22, 17519, 334),
(27, 18155, 396),
(28, 18178, 398),
(29, 18201, 400),
(30, 18224, 402),
(31, 18247, 404),
(32, 18271, 3),
(33, 18272, 2),
(34, 18274, 1),
(35, 18274, 2);

-- --------------------------------------------------------

--
-- 表的结构 `issue_main`
--

CREATE TABLE `issue_main` (
  `id` int(11) UNSIGNED NOT NULL,
  `pkey` varchar(32) DEFAULT NULL,
  `issue_num` varchar(64) DEFAULT NULL,
  `project_id` int(11) DEFAULT '0',
  `issue_type` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `creator` int(11) UNSIGNED DEFAULT '0',
  `modifier` int(11) UNSIGNED NOT NULL DEFAULT '0',
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
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) NOT NULL DEFAULT '',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否拥有子任务'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_moved_issue_key`
--

CREATE TABLE `issue_moved_issue_key` (
  `id` decimal(18,0) NOT NULL,
  `old_issue_key` varchar(255) DEFAULT NULL,
  `issue_id` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_moved_issue_key`
--

INSERT INTO `issue_moved_issue_key` (`id`, `old_issue_key`, `issue_id`) VALUES
('10100', 'SP-390', '13539'),
('10101', 'SP-391', '13540'),
('10200', 'ZZSJXC-69', '13600'),
('10201', 'ZZSJXC-37', '13204'),
('10202', 'ZZSJXC-41', '13213'),
('10203', 'ZZSJXC-35', '13202'),
('10204', 'ZZSJXC-76', '13721'),
('10205', 'ZZSJXC-43', '13215'),
('10206', 'ZZSJXC-36', '13203'),
('10207', 'ZZSJXC-40', '13210'),
('10208', 'ZZSJXC-68', '13599'),
('10209', 'ZZSJXC-39', '13209'),
('10210', 'ZZSJXC-78', '13789'),
('10211', 'ZZSJXC-30', '13192'),
('10212', 'ZZSJXC-31', '13193'),
('10213', 'ZZSJXC-33', '13198'),
('10214', 'ZZSJXC-28', '13130'),
('10215', 'ZZSJXC-75', '13709'),
('10216', 'ZZSJXC-67', '13598'),
('10217', 'ZZSJXC-34', '13200'),
('10218', 'ZZSJXC-64', '13588'),
('10219', 'ZZSJXC-38', '13205'),
('10220', 'ZZSJXC-63', '13581'),
('10221', 'ZZSJXC-74', '13708'),
('10222', 'ZZSJXC-66', '13597'),
('10223', 'ZZSJXC-42', '13214'),
('10224', 'ZZSJXC-29', '13191'),
('10225', 'ZZSJXC-62', '13580'),
('10226', 'ZZSJXC-32', '13195'),
('10227', 'ZZSJXC-65', '13593'),
('10228', 'ZZSJXC-48', '13549'),
('10229', 'ZZSJXC-46', '13547'),
('10230', 'ZZSJXC-55', '13556'),
('10231', 'ZZSJXC-51', '13552'),
('10232', 'ZZSJXC-60', '13561'),
('10233', 'ZZSJXC-54', '13555'),
('10234', 'ZZSJXC-50', '13551'),
('10235', 'ZZSJXC-58', '13559'),
('10236', 'ZZSJXC-53', '13554'),
('10237', 'ZZSJXC-56', '13557'),
('10238', 'ZZSJXC-44', '13545'),
('10239', 'ZZSJXC-72', '13631'),
('10240', 'ZZSJXC-71', '13630'),
('10241', 'ZZSJXC-57', '13558'),
('10242', 'ZZSJXC-45', '13546'),
('10243', 'ZZSJXC-59', '13560'),
('10244', 'ZZSJXC-47', '13548'),
('10245', 'ZZSJXC-77', '13730'),
('10246', 'ZZSJXC-70', '13629'),
('10247', 'ZZSJXC-49', '13550'),
('10248', 'ZZSJXC-73', '13707'),
('10249', 'ZZSJXC-61', '13562'),
('10250', 'ZZSJXC-52', '13553'),
('10251', 'ZUAN-152', '12501'),
('10252', 'ZUAN-172', '12641'),
('10253', 'ZUAN-63', '12176'),
('10254', 'ZUAN-76', '12190'),
('10255', 'ZUAN-31', '12137'),
('10256', 'ZUAN-93', '12306'),
('10257', 'ZUAN-75', '12189'),
('10258', 'ZUAN-171', '12640'),
('10259', 'ZUAN-122', '12452'),
('10260', 'ZUAN-145', '12482'),
('10261', 'ZUAN-127', '12457'),
('10262', 'ZUAN-29', '12135'),
('10263', 'ZUAN-128', '12458'),
('10264', 'ZUAN-104', '12412'),
('10265', 'ZUAN-30', '12136'),
('10266', 'ZUAN-134', '12466'),
('10267', 'ZUAN-105', '12413'),
('10268', 'ZUAN-62', '12175'),
('10269', 'ZUAN-158', '12627'),
('10270', 'ZUAN-169', '12638'),
('10271', 'ZUAN-58', '12170'),
('10272', 'ZUAN-163', '12632'),
('10273', 'ZUAN-21', '12126'),
('10274', 'ZUAN-24', '12129'),
('10275', 'ZUAN-92', '12305'),
('10276', 'ZUAN-111', '12437'),
('10277', 'ZUAN-149', '12495'),
('10278', 'ZUAN-96', '12309'),
('10279', 'ZUAN-97', '12310'),
('10280', 'ZUAN-90', '12303'),
('10281', 'ZUAN-59', '12172'),
('10282', 'ZUAN-48', '12160'),
('10283', 'ZUAN-77', '12191'),
('10284', 'ZUAN-46', '12158'),
('10285', 'ZUAN-170', '12639'),
('10286', 'ZUAN-176', '12748'),
('10287', 'ZUAN-119', '12449'),
('10288', 'ZUAN-89', '12302'),
('10289', 'ZUAN-68', '12182'),
('10290', 'ZUAN-174', '12746'),
('10291', 'ZUAN-87', '12300'),
('10292', 'ZUAN-74', '12188'),
('10293', 'ZUAN-38', '12144'),
('10294', 'ZUAN-49', '12161'),
('10295', 'ZUAN-146', '12483'),
('10296', 'ZUAN-95', '12308'),
('10297', 'ZUAN-64', '12177'),
('10298', 'ZUAN-80', '12194'),
('10299', 'ZUAN-115', '12442'),
('10300', 'ZUAN-113', '12440'),
('10301', 'ZUAN-98', '12311'),
('10302', 'ZUAN-37', '12143'),
('10303', 'ZUAN-57', '12169'),
('10304', 'ZUAN-151', '12497'),
('10305', 'ZUAN-109', '12432'),
('10306', 'ZUAN-44', '12155'),
('10307', 'ZUAN-138', '12471'),
('10308', 'ZUAN-54', '12166'),
('10309', 'ZUAN-141', '12476'),
('10310', 'ZUAN-140', '12474'),
('10311', 'ZUAN-126', '12456'),
('10312', 'ZUAN-45', '12156'),
('10313', 'ZUAN-81', '12195'),
('10314', 'ZUAN-71', '12185'),
('10315', 'ZUAN-91', '12304'),
('10316', 'ZUAN-73', '12187'),
('10317', 'ZUAN-108', '12431'),
('10318', 'ZUAN-153', '12505'),
('10319', 'ZUAN-129', '12459'),
('10320', 'ZUAN-35', '12141'),
('10321', 'ZUAN-60', '12173'),
('10322', 'ZUAN-135', '12467'),
('10323', 'ZUAN-139', '12472'),
('10324', 'ZUAN-39', '12145'),
('10325', 'ZUAN-160', '12629'),
('10326', 'ZUAN-143', '12478'),
('10327', 'ZUAN-94', '12307'),
('10328', 'ZUAN-130', '12460'),
('10329', 'ZUAN-82', '12196'),
('10330', 'ZUAN-103', '12411'),
('10331', 'ZUAN-69', '12183'),
('10332', 'ZUAN-114', '12441'),
('10333', 'ZUAN-132', '12464'),
('10334', 'ZUAN-56', '12168'),
('10335', 'ZUAN-53', '12165'),
('10336', 'ZUAN-79', '12193'),
('10337', 'ZUAN-123', '12453'),
('10338', 'ZUAN-110', '12436'),
('10339', 'ZUAN-25', '12130'),
('10340', 'ZUAN-36', '12142'),
('10341', 'ZUAN-99', '12312'),
('10342', 'ZUAN-27', '12133'),
('10343', 'ZUAN-162', '12631'),
('10344', 'ZUAN-133', '12465'),
('10345', 'ZUAN-150', '12496'),
('10346', 'ZUAN-165', '12634'),
('10347', 'ZUAN-40', '12146'),
('10348', 'ZUAN-52', '12164'),
('10349', 'ZUAN-101', '12402'),
('10350', 'ZUAN-124', '12454'),
('10351', 'ZUAN-47', '12159'),
('10352', 'ZUAN-177', '12749'),
('10353', 'ZUAN-102', '12406'),
('10354', 'ZUAN-42', '12149'),
('10355', 'ZUAN-43', '12153'),
('10356', 'ZUAN-136', '12468'),
('10357', 'ZUAN-142', '12477'),
('10358', 'ZUAN-166', '12635'),
('10359', 'ZUAN-117', '12444'),
('10360', 'ZUAN-144', '12481'),
('10361', 'ZUAN-175', '12747'),
('10362', 'ZUAN-168', '12637'),
('10363', 'ZUAN-78', '12192'),
('10364', 'ZUAN-33', '12139'),
('10365', 'ZUAN-112', '12439'),
('10366', 'ZUAN-159', '12628'),
('10367', 'ZUAN-50', '12162'),
('10368', 'ZUAN-55', '12167'),
('10369', 'ZUAN-161', '12630'),
('10370', 'ZUAN-84', '12198'),
('10371', 'ZUAN-120', '12450'),
('10372', 'ZUAN-32', '12138'),
('10373', 'ZUAN-51', '12163'),
('10374', 'ZUAN-173', '12642'),
('10375', 'ZUAN-23', '12128'),
('10376', 'ZUAN-41', '12147'),
('10377', 'ZUAN-70', '12184'),
('10378', 'ZUAN-83', '12197'),
('10379', 'ZUAN-155', '12554'),
('10380', 'ZUAN-118', '12448'),
('10381', 'ZUAN-147', '12484'),
('10382', 'ZUAN-125', '12455'),
('10383', 'ZUAN-28', '12134'),
('10384', 'ZUAN-67', '12181'),
('10385', 'ZUAN-61', '12174'),
('10386', 'ZUAN-164', '12633'),
('10387', 'ZUAN-178', '12750'),
('10388', 'ZUAN-22', '12127'),
('10389', 'ZUAN-157', '12626'),
('10390', 'ZUAN-167', '12636'),
('10391', 'ZUAN-88', '12301'),
('10392', 'ZUAN-107', '12430'),
('10393', 'ZUAN-100', '12401'),
('10394', 'ZUAN-34', '12140'),
('10395', 'ZUAN-65', '12178'),
('10396', 'ZUAN-20', '12125'),
('10397', 'ZUAN-137', '12469'),
('10398', 'ZUAN-148', '12485'),
('10399', 'ZUAN-121', '12451'),
('10400', 'ZUAN-26', '12132'),
('10401', 'ZUAN-72', '12186'),
('10402', 'ZUAN-66', '12180'),
('10403', 'ZUAN-9', '12097'),
('10404', 'ZUAN-16', '12104'),
('10405', 'ZUAN-19', '12107'),
('10406', 'ZUAN-14', '12102'),
('10407', 'ZUAN-18', '12106'),
('10408', 'ZUAN-15', '12103'),
('10409', 'ZUAN-6', '12094'),
('10410', 'ZUAN-1', '12089'),
('10411', 'ZUAN-12', '12100'),
('10412', 'ZUAN-7', '12095'),
('10413', 'ZUAN-10', '12098'),
('10414', 'ZUAN-8', '12096'),
('10415', 'ZUAN-2', '12090'),
('10416', 'ZUAN-4', '12092'),
('10417', 'ZUAN-85', '12199'),
('10418', 'ZUAN-5', '12093'),
('10419', 'ZUAN-86', '12200'),
('10420', 'ZUAN-3', '12091'),
('10421', 'ZUAN-11', '12099'),
('10422', 'ZUAN-13', '12101'),
('10423', 'ZUAN-17', '12105'),
('10424', 'ZUAN-154', '12512'),
('10425', 'ZUAN-131', '12461'),
('10426', 'ZUAN-116', '12443'),
('10427', 'ZUAN-106', '12414'),
('10428', 'ZUAN-156', '12558'),
('10429', 'GEETOOL-7', '12692'),
('10430', 'GEETOOL-30', '12715'),
('10431', 'GEETOOL-6', '12691'),
('10432', 'GEETOOL-34', '12723'),
('10433', 'GEETOOL-37', '12730'),
('10434', 'GEETOOL-33', '12722'),
('10435', 'GEETOOL-3', '12688'),
('10436', 'GEETOOL-5', '12690'),
('10437', 'GEETOOL-32', '12717'),
('10438', 'GEETOOL-13', '12698'),
('10439', 'GEETOOL-15', '12700'),
('10440', 'GEETOOL-26', '12711'),
('10441', 'GEETOOL-2', '12687'),
('10442', 'GEETOOL-11', '12696'),
('10443', 'GEETOOL-40', '12737'),
('10444', 'GEETOOL-42', '12755'),
('10445', 'GEETOOL-17', '12702'),
('10446', 'GEETOOL-1', '12685'),
('10447', 'GEETOOL-18', '12703'),
('10448', 'GEETOOL-16', '12701'),
('10449', 'GEETOOL-36', '12726'),
('10450', 'GEETOOL-19', '12704'),
('10451', 'GEETOOL-35', '12725'),
('10452', 'GEETOOL-24', '12709'),
('10453', 'GEETOOL-12', '12697'),
('10454', 'GEETOOL-25', '12710'),
('10455', 'GEETOOL-14', '12699'),
('10456', 'GEETOOL-20', '12705'),
('10457', 'GEETOOL-27', '12712'),
('10458', 'GEETOOL-38', '12731'),
('10459', 'GEETOOL-41', '12754'),
('10460', 'GEETOOL-21', '12706'),
('10461', 'GEETOOL-45', '13739'),
('10462', 'GEETOOL-4', '12689'),
('10463', 'GEETOOL-29', '12714'),
('10464', 'GEETOOL-28', '12713'),
('10465', 'GEETOOL-44', '12758'),
('10466', 'GEETOOL-43', '12757'),
('10467', 'GEETOOL-10', '12695'),
('10468', 'GEETOOL-39', '12735'),
('10469', 'GEETOOL-31', '12716'),
('10470', 'GEETOOL-22', '12707'),
('10471', 'GEETOOL-8', '12693'),
('10472', 'GEETOOL-23', '12708'),
('10473', 'GEETOOL-9', '12694'),
('10474', 'DC-149', '14194');

-- --------------------------------------------------------

--
-- 表的结构 `issue_priority`
--

CREATE TABLE `issue_priority` (
  `id` int(11) UNSIGNED NOT NULL,
  `sequence` int(11) UNSIGNED DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(128) NOT NULL,
  `description` text,
  `iconurl` varchar(255) DEFAULT NULL,
  `status_color` varchar(60) DEFAULT NULL,
  `font_awesome` varchar(40) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_priority`
--

INSERT INTO `issue_priority` (`id`, `sequence`, `name`, `_key`, `description`, `iconurl`, `status_color`, `font_awesome`, `is_system`) VALUES
(1, 1, '紧 急', 'very_import', 'Blocks development and/or testing work, production could not run.', '/images/icons/priorities/blocker.png', 'red', NULL, 0),
(2, 2, '重要', 'import', 'Crashes, loss of data, severe memory leak.', '/images/icons/priorities/critical.png', '#cc0000', NULL, 0),
(3, 3, '高', 'high', 'Major loss of function.', '/images/icons/priorities/major.png', '#ff0000', NULL, 0),
(4, 4, '中', 'normal', 'Minor loss of function, or other problem where easy workaround is present.', '/images/icons/priorities/minor.png', '#006600', NULL, 0),
(5, 5, '低', 'low', 'Cosmetic problem like misspelt words or misaligned text.', '/images/icons/priorities/trivial.png', '#003300', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_recycle`
--

CREATE TABLE `issue_recycle` (
  `id` int(11) UNSIGNED NOT NULL,
  `delete_user_id` int(11) UNSIGNED NOT NULL,
  `pkey` varchar(32) DEFAULT NULL,
  `issue_num` decimal(18,0) DEFAULT NULL,
  `project_id` int(11) DEFAULT '0',
  `issue_type` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `creator` int(11) UNSIGNED DEFAULT '0',
  `modifier` int(11) UNSIGNED NOT NULL DEFAULT '0',
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
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `issue_resolve`
--

CREATE TABLE `issue_resolve` (
  `id` int(11) UNSIGNED NOT NULL,
  `sequence` int(11) UNSIGNED DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(128) NOT NULL,
  `description` text,
  `font_awesome` varchar(32) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_resolve`
--

INSERT INTO `issue_resolve` (`id`, `sequence`, `name`, `_key`, `description`, `font_awesome`, `color`, `is_system`) VALUES
(1, 1, '已修复', 'fixed', 'A fix for this issue is checked into the tree and tested.', NULL, '#1aaa55', 0),
(2, 2, '不能修复', 'not_fix', 'The problem described is an issue which will never be fixed.', NULL, '#db3b21', 0),
(3, 3, '需要重现', 'require_duplicate', 'The problem is a duplicate of an existing issue.', NULL, '#db3b21', 0),
(4, 4, '信息不完整', 'not_complete', 'The problem is not completely described.', NULL, '#db3b21', 0),
(5, 5, '不能重现', 'not_reproduce', 'All attempts at reproducing this issue failed, or not enough information was available to reproduce the issue. Reading the code produces no clues as to why this behavior would occur. If more information appears later, please reopen the issue.', NULL, '#db3b21', 0),
(10000, 6, '完成', 'done', 'GreenHopper Managed Resolution', NULL, '#1aaa55', 0),
(10100, 8, '问题不存在', 'issue_not_exists', '', NULL, 'rgba(0,0,0,0.85)', 0),
(10101, 9, '延迟处理', 'delay', '', NULL, 'rgba(0,0,0,0.85)', 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_status`
--

CREATE TABLE `issue_status` (
  `id` int(11) UNSIGNED NOT NULL,
  `sequence` int(11) UNSIGNED DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(20) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `font_awesome` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0',
  `color` varchar(20) DEFAULT NULL COMMENT 'Default Primary Success Info Warning Danger可选'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_status`
--

INSERT INTO `issue_status` (`id`, `sequence`, `name`, `_key`, `description`, `font_awesome`, `is_system`, `color`) VALUES
(1, 1, '打 开', 'open', 'The issue is open and ready for the assignee to start work on it.', '/images/icons/statuses/open.png', 0, 'info'),
(3, 3, '进行中', 'in_progress', 'This issue is being actively worked on at the moment by the assignee.', '/images/icons/statuses/inprogress.png', 0, 'primary'),
(4, 4, '重新打开', 'reopen', 'This issue was once resolved, but the resolution was deemed incorrect. From here issues are either marked assigned or resolved.', '/images/icons/statuses/reopened.png', 0, 'warning'),
(5, 5, '已解决', 'resolved', 'A resolution has been taken, and it is awaiting verification by reporter. From here issues are either reopened, or are closed.', '/images/icons/statuses/resolved.png', 0, 'success'),
(6, 6, '已关闭', 'closed', 'The issue is considered finished, the resolution is correct. Issues which are closed can be reopened.', '/images/icons/statuses/closed.png', 0, 'success'),
(10000, 7, '待 办', 'todo', '', '/', 0, 'info'),
(10001, 8, '完 成', 'done', '', '/', 0, 'info'),
(10002, 9, '回 顾', 'in_review', NULL, '/images/icons/statuses/information.png', 0, 'info'),
(10100, 10, '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', 0, 'info');

-- --------------------------------------------------------

--
-- 表的结构 `issue_type`
--

CREATE TABLE `issue_type` (
  `id` int(11) UNSIGNED NOT NULL,
  `sequence` decimal(18,0) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(64) NOT NULL,
  `catalog` enum('Custom','Kanban','Scrum','Standard') DEFAULT 'Standard' COMMENT '类型',
  `description` text,
  `font_awesome` varchar(20) DEFAULT NULL,
  `custom_icon_url` varchar(128) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0',
  `form_desc_tpl_id` int(11) UNSIGNED DEFAULT '0' COMMENT '创建事项时,描述字段对应的模板id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_type`
--

INSERT INTO `issue_type` (`id`, `sequence`, `name`, `_key`, `catalog`, `description`, `font_awesome`, `custom_icon_url`, `is_system`, `form_desc_tpl_id`) VALUES
(1, '1', 'Bug', 'bug', 'Standard', 'A problem which impairs or prevents the functions of the product.', 'fa-bug', NULL, 1, 0),
(2, '2', '新功能', 'new_feature', 'Standard', '', 'fa-plus', NULL, 1, 0),
(3, '3', '任务', 'task', 'Standard', ' ', 'fa-tasks', NULL, 1, 0),
(4, '4', '优化改进', 'improve', 'Standard', '优化改进', 'fa-arrow-circle-o-up', NULL, 1, 0),
(5, '0', '子任务', 'child_task', 'Standard', '', 'fa-subscript', NULL, 1, 0),
(6, '2', '用户故事', 'user_story', 'Scrum', 'gh.issue.story.desc', 'fa-users', NULL, 1, 0),
(7, '3', '技术任务', 'tech_task', 'Scrum', '', 'fa-cogs', NULL, 1, 0),
(8, '5', '史诗任务', 'epic', 'Standard', '敏捷开发里的产品收集', 'fa-address-book-o', NULL, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_type_scheme`
--

CREATE TABLE `issue_type_scheme` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `is_default` tinyint(1) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问题方案表';

--
-- 转存表中的数据 `issue_type_scheme`
--

INSERT INTO `issue_type_scheme` (`id`, `name`, `description`, `is_default`) VALUES
(1, '默认事项方案', '系统默认的事项方案,但没有设定或事项错误时使用该方案', 1),
(2, '敏捷开发事项方案', '敏捷开发适用的方案', 1),
(3, '瀑布模型的事项方案', '普通的软件开发流程', 1),
(4, '流程管理事项方案', '针对软件开发的', 0),
(5, '任务管理事项解决方案', '任务管理', 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_type_scheme_data`
--

CREATE TABLE `issue_type_scheme_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `scheme_id` int(11) UNSIGNED DEFAULT NULL,
  `type_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问题方案字表';

--
-- 转存表中的数据 `issue_type_scheme_data`
--

INSERT INTO `issue_type_scheme_data` (`id`, `scheme_id`, `type_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 1, 2),
(5, 2, 2),
(6, 1, 3),
(16, 4, 3),
(17, 4, 10000),
(18, 5, 3),
(19, 5, 5),
(20, 5, 10002),
(21, 5, 10106),
(22, 12, 1),
(23, 12, 3),
(24, 13, 1),
(25, 13, 3),
(26, 14, 1),
(27, 14, 3),
(28, 15, 1),
(29, 15, 3),
(30, 16, 1),
(31, 16, 3),
(32, 17, 1),
(33, 17, 3);

-- --------------------------------------------------------

--
-- 表的结构 `issue_ui`
--

CREATE TABLE `issue_ui` (
  `id` int(10) UNSIGNED NOT NULL,
  `issue_type_id` int(10) UNSIGNED DEFAULT NULL,
  `ui_type` varchar(10) DEFAULT '',
  `field_id` int(10) UNSIGNED DEFAULT NULL,
  `order_weight` int(10) UNSIGNED DEFAULT NULL,
  `tab_id` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_ui`
--

INSERT INTO `issue_ui` (`id`, `issue_type_id`, `ui_type`, `field_id`, `order_weight`, `tab_id`) VALUES
(1, 2, 'create', 1, 3, 0),
(2, 2, 'create', 2, 2, 0),
(3, 2, 'create', 3, 1, 0),
(4, 2, 'create', 4, 0, 0),
(5, 2, 'create', 5, 0, 2),
(6, 2, 'create', 6, 3, 0),
(7, 2, 'create', 7, 2, 0),
(8, 2, 'create', 8, 1, 0),
(9, 2, 'create', 9, 1, 0),
(10, 2, 'create', 10, 0, 0),
(11, 2, 'create', 11, 0, 0),
(12, 2, 'create', 12, 0, 0),
(13, 2, 'create', 13, 0, 0),
(14, 2, 'create', 14, 0, 0),
(15, 2, 'edit', 1, 3, 0),
(16, 2, 'edit', 2, 2, 0),
(17, 2, 'edit', 3, 1, 0),
(18, 2, 'edit', 4, 0, 0),
(19, 2, 'edit', 5, 0, 2),
(20, 2, 'edit', 6, 3, 0),
(21, 2, 'edit', 7, 2, 0),
(22, 2, 'edit', 8, 1, 0),
(23, 2, 'edit', 9, 1, 0),
(24, 2, 'edit', 10, 0, 0),
(25, 2, 'edit', 11, 0, 0),
(26, 2, 'edit', 12, 0, 0),
(27, 2, 'edit', 13, 0, 0),
(28, 2, 'edit', 14, 0, 0),
(57, 3, 'create', 1, 3, 0),
(58, 3, 'create', 2, 2, 0),
(59, 3, 'create', 3, 1, 0),
(60, 3, 'create', 4, 0, 0),
(61, 3, 'create', 5, 0, 2),
(62, 3, 'create', 6, 3, 0),
(63, 3, 'create', 7, 2, 0),
(64, 3, 'create', 8, 1, 0),
(65, 3, 'create', 9, 1, 0),
(66, 3, 'create', 10, 0, 0),
(67, 3, 'create', 11, 0, 0),
(68, 3, 'create', 12, 0, 0),
(69, 3, 'create', 13, 0, 0),
(70, 3, 'create', 14, 0, 0),
(71, 3, 'edit', 1, 3, 0),
(72, 3, 'edit', 2, 2, 0),
(73, 3, 'edit', 3, 1, 0),
(74, 3, 'edit', 4, 0, 0),
(75, 3, 'edit', 5, 0, 2),
(76, 3, 'edit', 6, 3, 0),
(77, 3, 'edit', 7, 2, 0),
(78, 3, 'edit', 8, 1, 0),
(79, 3, 'edit', 9, 1, 0),
(80, 3, 'edit', 10, 0, 0),
(81, 3, 'edit', 11, 0, 0),
(82, 3, 'edit', 12, 0, 0),
(83, 3, 'edit', 13, 0, 0),
(84, 3, 'edit', 14, 0, 0),
(85, 4, 'create', 1, 3, 0),
(86, 4, 'create', 2, 2, 0),
(87, 4, 'create', 3, 1, 0),
(88, 4, 'create', 4, 0, 0),
(89, 4, 'create', 5, 0, 2),
(90, 4, 'create', 6, 3, 0),
(91, 4, 'create', 7, 2, 0),
(92, 4, 'create', 8, 1, 0),
(93, 4, 'create', 9, 1, 0),
(94, 4, 'create', 10, 0, 0),
(95, 4, 'create', 11, 0, 0),
(96, 4, 'create', 12, 0, 0),
(97, 4, 'create', 13, 0, 0),
(98, 4, 'create', 14, 0, 0),
(99, 4, 'edit', 1, 3, 0),
(100, 4, 'edit', 2, 2, 0),
(101, 4, 'edit', 3, 1, 0),
(102, 4, 'edit', 4, 0, 0),
(103, 4, 'edit', 5, 0, 2),
(104, 4, 'edit', 6, 3, 0),
(105, 4, 'edit', 7, 2, 0),
(106, 4, 'edit', 8, 1, 0),
(107, 4, 'edit', 9, 1, 0),
(108, 4, 'edit', 10, 0, 0),
(109, 4, 'edit', 11, 0, 0),
(110, 4, 'edit', 12, 0, 0),
(111, 4, 'edit', 13, 0, 0),
(112, 4, 'edit', 14, 0, 0),
(113, 5, 'create', 1, 3, 0),
(114, 5, 'create', 2, 2, 0),
(115, 5, 'create', 3, 1, 0),
(116, 5, 'create', 4, 0, 0),
(117, 5, 'create', 5, 0, 2),
(118, 5, 'create', 6, 3, 0),
(119, 5, 'create', 7, 2, 0),
(120, 5, 'create', 8, 1, 0),
(121, 5, 'create', 9, 1, 0),
(122, 5, 'create', 10, 0, 0),
(123, 5, 'create', 11, 0, 0),
(124, 5, 'create', 12, 0, 0),
(125, 5, 'create', 13, 0, 0),
(126, 5, 'create', 14, 0, 0),
(127, 5, 'edit', 1, 3, 0),
(128, 5, 'edit', 2, 2, 0),
(129, 5, 'edit', 3, 1, 0),
(130, 5, 'edit', 4, 0, 0),
(131, 5, 'edit', 5, 0, 2),
(132, 5, 'edit', 6, 3, 0),
(133, 5, 'edit', 7, 2, 0),
(134, 5, 'edit', 8, 1, 0),
(135, 5, 'edit', 9, 1, 0),
(136, 5, 'edit', 10, 0, 0),
(137, 5, 'edit', 11, 0, 0),
(138, 5, 'edit', 12, 0, 0),
(139, 5, 'edit', 13, 0, 0),
(140, 5, 'edit', 14, 0, 0),
(141, 6, 'create', 1, 3, 0),
(142, 6, 'create', 2, 2, 0),
(143, 6, 'create', 3, 1, 0),
(144, 6, 'create', 4, 0, 0),
(145, 6, 'create', 5, 0, 2),
(146, 6, 'create', 6, 3, 0),
(147, 6, 'create', 7, 2, 0),
(148, 6, 'create', 8, 1, 0),
(149, 6, 'create', 9, 1, 0),
(150, 6, 'create', 10, 0, 0),
(151, 6, 'create', 11, 0, 0),
(152, 6, 'create', 12, 0, 0),
(153, 6, 'create', 13, 0, 0),
(154, 6, 'create', 14, 0, 0),
(155, 6, 'create', 15, 0, 0),
(156, 6, 'create', 16, 0, 0),
(157, 6, 'edit', 1, 3, 0),
(158, 6, 'edit', 2, 2, 0),
(159, 6, 'edit', 3, 1, 0),
(160, 6, 'edit', 4, 0, 0),
(161, 6, 'edit', 5, 0, 2),
(162, 6, 'edit', 6, 3, 0),
(163, 6, 'edit', 7, 2, 0),
(164, 6, 'edit', 8, 1, 0),
(165, 6, 'edit', 9, 1, 0),
(166, 6, 'edit', 10, 0, 0),
(167, 6, 'edit', 11, 0, 0),
(168, 6, 'edit', 12, 0, 0),
(169, 6, 'edit', 13, 0, 0),
(170, 6, 'edit', 14, 0, 0),
(171, 6, 'edit', 15, 0, 0),
(172, 6, 'edit', 16, 0, 0),
(173, 7, 'create', 1, 3, 0),
(174, 7, 'create', 2, 2, 0),
(175, 7, 'create', 3, 1, 0),
(176, 7, 'create', 4, 0, 0),
(177, 7, 'create', 5, 0, 2),
(178, 7, 'create', 6, 3, 0),
(179, 7, 'create', 7, 2, 0),
(180, 7, 'create', 8, 1, 0),
(181, 7, 'create', 9, 1, 0),
(182, 7, 'create', 10, 0, 0),
(183, 7, 'create', 11, 0, 0),
(184, 7, 'create', 12, 0, 0),
(185, 7, 'create', 13, 0, 0),
(186, 7, 'create', 14, 0, 0),
(187, 7, 'create', 15, 0, 0),
(188, 7, 'create', 16, 0, 0),
(189, 7, 'edit', 1, 3, 0),
(190, 7, 'edit', 2, 2, 0),
(191, 7, 'edit', 3, 1, 0),
(192, 7, 'edit', 4, 0, 0),
(193, 7, 'edit', 5, 0, 2),
(194, 7, 'edit', 6, 3, 0),
(195, 7, 'edit', 7, 2, 0),
(196, 7, 'edit', 8, 1, 0),
(197, 7, 'edit', 9, 1, 0),
(198, 7, 'edit', 10, 0, 0),
(199, 7, 'edit', 11, 0, 0),
(200, 7, 'edit', 12, 0, 0),
(201, 7, 'edit', 13, 0, 0),
(202, 7, 'edit', 14, 0, 0),
(203, 7, 'edit', 15, 0, 0),
(204, 7, 'edit', 16, 0, 0),
(205, 8, 'create', 1, 3, 0),
(206, 8, 'create', 2, 2, 0),
(207, 8, 'create', 3, 1, 0),
(208, 8, 'create', 4, 0, 0),
(209, 8, 'create', 5, 0, 2),
(210, 8, 'create', 6, 3, 0),
(211, 8, 'create', 7, 2, 0),
(212, 8, 'create', 8, 1, 0),
(213, 8, 'create', 9, 1, 0),
(214, 8, 'create', 10, 0, 0),
(215, 8, 'create', 11, 0, 0),
(216, 8, 'create', 12, 0, 0),
(217, 8, 'create', 13, 0, 0),
(218, 8, 'create', 14, 0, 0),
(219, 8, 'create', 15, 0, 0),
(220, 8, 'create', 16, 0, 0),
(221, 8, 'edit', 1, 3, 0),
(222, 8, 'edit', 2, 2, 0),
(223, 8, 'edit', 3, 1, 0),
(224, 8, 'edit', 4, 0, 0),
(225, 8, 'edit', 5, 0, 2),
(226, 8, 'edit', 6, 3, 0),
(227, 8, 'edit', 7, 2, 0),
(228, 8, 'edit', 8, 1, 0),
(229, 8, 'edit', 9, 1, 0),
(230, 8, 'edit', 10, 0, 0),
(231, 8, 'edit', 11, 0, 0),
(232, 8, 'edit', 12, 0, 0),
(233, 8, 'edit', 13, 0, 0),
(234, 8, 'edit', 14, 0, 0),
(235, 8, 'edit', 15, 0, 0),
(236, 8, 'edit', 16, 0, 0),
(237, 5, 'create', 17, NULL, NULL),
(238, 5, 'edit', 17, NULL, NULL),
(271, 1, 'create', 1, 6, 0),
(272, 1, 'create', 6, 5, 0),
(273, 1, 'create', 2, 4, 0),
(274, 1, 'create', 7, 3, 0),
(275, 1, 'create', 9, 2, 0),
(276, 1, 'create', 4, 1, 0),
(277, 1, 'create', 11, 0, 0),
(278, 1, 'create', 15, 5, 13),
(279, 1, 'create', 19, 4, 13),
(280, 1, 'create', 20, 3, 13),
(281, 1, 'create', 8, 2, 13),
(282, 1, 'create', 3, 1, 13),
(283, 1, 'create', 10, 0, 13),
(284, 1, 'create', 12, 1, 14),
(285, 1, 'create', 13, 0, 14),
(286, 1, 'edit', 1, 6, 0),
(287, 1, 'edit', 6, 5, 0),
(288, 1, 'edit', 2, 4, 0),
(289, 1, 'edit', 7, 3, 0),
(290, 1, 'edit', 4, 2, 0),
(291, 1, 'edit', 11, 1, 0),
(292, 1, 'edit', 19, 0, 0),
(293, 1, 'edit', 12, 1, 15),
(294, 1, 'edit', 13, 0, 15),
(295, 1, 'edit', 8, 4, 16),
(296, 1, 'edit', 10, 3, 16),
(297, 1, 'edit', 3, 2, 16),
(298, 1, 'edit', 9, 1, 16),
(299, 1, 'edit', 15, 0, 16);

-- --------------------------------------------------------

--
-- 表的结构 `issue_ui_tab`
--

CREATE TABLE `issue_ui_tab` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_type_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `order_weight` int(11) DEFAULT NULL,
  `ui_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_ui_tab`
--

INSERT INTO `issue_ui_tab` (`id`, `issue_type_id`, `name`, `order_weight`, `ui_type`) VALUES
(7, 10, 'test-name-24019', 0, 'create'),
(8, 11, 'test-name-53500', 0, 'create'),
(13, 1, '其他', 1, 'create'),
(14, 1, '时间', 0, 'create'),
(15, 1, '\n            时间\n             \n            \n        ', 1, 'edit'),
(16, 1, '\n            其他\n             \n            \n        ', 0, 'edit');

-- --------------------------------------------------------

--
-- 表的结构 `job_run_details`
--

CREATE TABLE `job_run_details` (
  `id` decimal(18,0) NOT NULL,
  `job_id` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `run_duration` decimal(18,0) DEFAULT NULL,
  `run_outcome` char(1) DEFAULT NULL,
  `info_message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `log_base`
--

CREATE TABLE `log_base` (
  `id` int(11) NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `module` varchar(20) DEFAULT NULL COMMENT '所属模块',
  `obj_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作记录所关联的对象id,如现货id 订单id',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作者id,0为系统操作',
  `user_name` varchar(32) DEFAULT '' COMMENT '操作者用户名',
  `real_name` varchar(255) DEFAULT NULL,
  `page` varchar(100) DEFAULT '' COMMENT '页面',
  `pre_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `cur_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL COMMENT '操作动作',
  `remark` varchar(100) DEFAULT '' COMMENT '动作',
  `pre_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `cur_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `ip` varchar(15) DEFAULT '' COMMENT '操作者ip地址 ',
  `time` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

--
-- 转存表中的数据 `log_base`
--

INSERT INTO `log_base` (`id`, `company_id`, `module`, `obj_id`, `uid`, `user_name`, `real_name`, `page`, `pre_status`, `cur_status`, `action`, `remark`, `pre_data`, `cur_data`, `ip`, `time`) VALUES
(31, 0, '日志', 0, 10000, 'cdwei', '韦朝夺', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1536425345,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1536425355,\"f3\":\"google\"}', 'unknown', 1536425355);

-- --------------------------------------------------------

--
-- 表的结构 `log_operating`
--

CREATE TABLE `log_operating` (
  `id` int(11) NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `module` varchar(20) DEFAULT NULL COMMENT '所属模块',
  `obj_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作记录所关联的对象id,如现货id 订单id',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '操作者id,0为系统操作',
  `user_name` varchar(32) DEFAULT '' COMMENT '操作者用户名',
  `real_name` varchar(255) DEFAULT NULL,
  `page` varchar(100) DEFAULT '' COMMENT '页面',
  `pre_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `cur_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL COMMENT '操作动作',
  `remark` varchar(100) DEFAULT '' COMMENT '动作',
  `pre_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `cur_data` varchar(1000) DEFAULT '{}' COMMENT '操作记录前的数据,json格式',
  `ip` varchar(15) DEFAULT '' COMMENT '操作者ip地址 ',
  `time` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='组合模糊查询索引';

--
-- 转存表中的数据 `log_operating`
--

INSERT INTO `log_operating` (`id`, `project_id`, `module`, `obj_id`, `uid`, `user_name`, `real_name`, `page`, `pre_status`, `cur_status`, `action`, `remark`, `pre_data`, `cur_data`, `ip`, `time`) VALUES
(399, 10003, 'issue', 16938, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"Summary11111111111\",\"creator\":\"10000\",\"project_id\":10003,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"\",\"module\":\"1\",\"environment\":\"\",\"start_date\":\"2018-07-25\",\"due_date\":\"2018-07-25\",\"milestone\":0}', '{\"summary\":\"Summary11111111111\",\"creator\":\"10000\",\"project_id\":10003,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"\",\"module\":\"1\",\"environment\":\"\",\"start_date\":\"2018-07-25\",\"due_date\":\"2018-07-25\",\"milestone\":0}', '116.25.238.238', 1532493245),
(400, 10002, 'issue', 16939, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"w\",\"creator\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"wwwwwwwwwwwwwwwwwwww\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"milestone\":0}', '{\"summary\":\"w\",\"creator\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"wwwwwwwwwwwwwwwwwwww\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"milestone\":0}', '127.0.0.1', 1534911054),
(401, 10719, 'issue', 17120, 11128, '19026653114', '19079200128', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11128\",\"project_id\":10719,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11128,\"reporter\":11128,\"module\":\"295\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11128\",\"project_id\":10719,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11128,\"reporter\":11128,\"module\":\"295\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535965453),
(402, 10721, 'issue', 17141, 11129, '19035012216', '19012946839', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11129\",\"project_id\":10721,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11129,\"reporter\":11129,\"module\":\"297\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11129\",\"project_id\":10721,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11129,\"reporter\":11129,\"module\":\"297\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535965523),
(403, 10723, 'issue', 17162, 11130, '19077237734', '19070950532', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11130\",\"project_id\":10723,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11130,\"reporter\":11130,\"module\":\"299\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11130\",\"project_id\":10723,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11130,\"reporter\":11130,\"module\":\"299\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535965741),
(404, 10725, 'issue', 17183, 11131, '19021962325', '19083409712', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11131\",\"project_id\":10725,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11131,\"reporter\":11131,\"module\":\"301\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11131\",\"project_id\":10725,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11131,\"reporter\":11131,\"module\":\"301\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535965754),
(405, 10727, 'issue', 17204, 11132, '19030965967', '19059813699', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11132\",\"project_id\":10727,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11132,\"reporter\":11132,\"module\":\"303\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11132\",\"project_id\":10727,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11132,\"reporter\":11132,\"module\":\"303\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535965884),
(406, 10729, 'issue', 17225, 11133, '19082927575', '19086696224', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11133\",\"project_id\":10729,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11133,\"reporter\":11133,\"module\":\"305\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11133\",\"project_id\":10729,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11133,\"reporter\":11133,\"module\":\"305\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535965917),
(407, 10731, 'issue', 17246, 11134, '19090796489', '19079246653', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11134\",\"project_id\":10731,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11134,\"reporter\":11134,\"module\":\"307\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11134\",\"project_id\":10731,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11134,\"reporter\":11134,\"module\":\"307\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535966064),
(408, 10733, 'issue', 17267, 11135, '19048263022', '19061410572', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11135\",\"project_id\":10733,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11135,\"reporter\":11135,\"module\":\"309\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11135\",\"project_id\":10733,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11135,\"reporter\":11135,\"module\":\"309\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535966516),
(409, 10735, 'issue', 17288, 11136, '19014333374', '19064342199', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11136\",\"project_id\":10735,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11136,\"reporter\":11136,\"module\":\"311\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11136\",\"project_id\":10735,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11136,\"reporter\":11136,\"module\":\"311\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\"}', '127.0.0.1', 1535966559),
(410, 10737, 'issue', 17309, 11137, '19071173161', '19080401567', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11137\",\"project_id\":10737,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11137,\"reporter\":11137,\"module\":\"313\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":26}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11137\",\"project_id\":10737,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11137,\"reporter\":11137,\"module\":\"313\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":26}', '127.0.0.1', 1535967649),
(411, 10739, 'issue', 17330, 11138, '19069643274', '19046382892', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11138\",\"project_id\":10739,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11138,\"reporter\":11138,\"module\":\"315\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":27}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11138\",\"project_id\":10739,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11138,\"reporter\":11138,\"module\":\"315\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":27}', '127.0.0.1', 1535967670),
(412, 10741, 'issue', 17351, 11139, '19080788033', '19073438793', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11139\",\"project_id\":10741,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11139,\"reporter\":11139,\"module\":\"317\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":28}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11139\",\"project_id\":10741,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11139,\"reporter\":11139,\"module\":\"317\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":28}', '127.0.0.1', 1535977819),
(413, 10743, 'issue', 17372, 11140, '19025189948', '19015625902', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11140\",\"project_id\":10743,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11140,\"reporter\":11140,\"module\":\"319\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":29}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11140\",\"project_id\":10743,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11140,\"reporter\":11140,\"module\":\"319\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":29}', '127.0.0.1', 1535977920),
(414, 10745, 'issue', 17393, 11141, '19026394203', '19066854538', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11141\",\"project_id\":10745,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11141,\"reporter\":11141,\"module\":\"321\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":30}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11141\",\"project_id\":10745,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11141,\"reporter\":11141,\"module\":\"321\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":30}', '127.0.0.1', 1535977969),
(415, 10747, 'issue', 17414, 11142, '19028185978', '19088637731', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11142\",\"project_id\":10747,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11142,\"reporter\":11142,\"module\":\"323\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":31}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11142\",\"project_id\":10747,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11142,\"reporter\":11142,\"module\":\"323\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":31}', '127.0.0.1', 1535978115),
(416, 10749, 'issue', 17435, 11143, '19020521734', '19046286296', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11143\",\"project_id\":10749,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11143,\"reporter\":11143,\"module\":\"325\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":32}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11143\",\"project_id\":10749,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11143,\"reporter\":11143,\"module\":\"325\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":32}', '127.0.0.1', 1535978252),
(417, 10751, 'issue', 17456, 11144, '19083585499', '19049348790', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11144\",\"project_id\":10751,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11144,\"reporter\":11144,\"module\":\"327\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":33}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11144\",\"project_id\":10751,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11144,\"reporter\":11144,\"module\":\"327\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":33}', '127.0.0.1', 1535978367),
(418, 10753, 'issue', 17477, 11145, '19052386865', '19064109992', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11145\",\"project_id\":10753,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11145,\"reporter\":11145,\"module\":\"329\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":34}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11145\",\"project_id\":10753,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11145,\"reporter\":11145,\"module\":\"329\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":34}', '127.0.0.1', 1535978581),
(419, 10755, 'issue', 17498, 11146, '19043607925', '19085258237', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11146\",\"project_id\":10755,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11146,\"reporter\":11146,\"module\":\"331\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":35}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11146\",\"project_id\":10755,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11146,\"reporter\":11146,\"module\":\"331\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":35}', '127.0.0.1', 1535978645),
(420, 10757, 'issue', 17519, 11147, '19018168751', '19075533885', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11147\",\"project_id\":10757,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11147,\"reporter\":11147,\"module\":\"333\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":36}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11147\",\"project_id\":10757,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11147,\"reporter\":11147,\"module\":\"333\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":36}', '127.0.0.1', 1535978897),
(421, 10759, 'issue', 17540, 11148, '19041157046', '19076826461', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11148\",\"project_id\":10759,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11148,\"reporter\":11148,\"module\":\"335\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":37}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11148\",\"project_id\":10759,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11148,\"reporter\":11148,\"module\":\"335\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":37}', '127.0.0.1', 1535979953),
(422, 10759, 'issue', 17540, 11148, '19041157046', '19076826461', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"17540\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10759\",\"issue_type\":\"1\",\"creator\":\"11148\",\"modifier\":\"0\",\"reporter\":\"11148\",\"assignee\":\"11148\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"resolve_date\":null,\"module\":\"335\",\"milestone\":null,\"sprint\":\"37\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"17540\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10759\",\"issue_type\":\"1\",\"creator\":\"11148\",\"modifier\":\"11148\",\"reporter\":\"11148\",\"assignee\":\"11148\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-02\",\"due_date\":\"2018-09-09\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1535979953),
(423, 10761, 'issue', 17561, 11149, '19031403962', '19016540512', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11149\",\"project_id\":10761,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11149,\"reporter\":11149,\"module\":\"337\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":38}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11149\",\"project_id\":10761,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11149,\"reporter\":11149,\"module\":\"337\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":38}', '127.0.0.1', 1535980002),
(424, 10761, 'issue', 17561, 11149, '19031403962', '19016540512', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"17561\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10761\",\"issue_type\":\"1\",\"creator\":\"11149\",\"modifier\":\"0\",\"reporter\":\"11149\",\"assignee\":\"11149\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"resolve_date\":null,\"module\":\"337\",\"milestone\":null,\"sprint\":\"38\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"17561\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10761\",\"issue_type\":\"1\",\"creator\":\"11149\",\"modifier\":\"11149\",\"reporter\":\"11149\",\"assignee\":\"11149\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-02\",\"due_date\":\"2018-09-09\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1535980002),
(425, 10763, 'issue', 17582, 11150, '19020442383', '19074216496', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11150\",\"project_id\":10763,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11150,\"reporter\":11150,\"module\":\"339\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":39}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11150\",\"project_id\":10763,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11150,\"reporter\":11150,\"module\":\"339\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":39}', '127.0.0.1', 1535980074),
(426, 10763, 'issue', 17582, 11150, '19020442383', '19074216496', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"17582\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10763\",\"issue_type\":\"1\",\"creator\":\"11150\",\"modifier\":\"0\",\"reporter\":\"11150\",\"assignee\":\"11150\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"resolve_date\":null,\"module\":\"339\",\"milestone\":null,\"sprint\":\"39\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"17582\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10763\",\"issue_type\":\"1\",\"creator\":\"11150\",\"modifier\":\"11150\",\"reporter\":\"11150\",\"assignee\":\"11150\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-02\",\"due_date\":\"2018-09-09\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1535980074),
(427, 10769, 'issue', 17643, 11153, '19052796505', '19059278687', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11153\",\"project_id\":10769,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11153,\"reporter\":11153,\"module\":\"345\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":42}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11153\",\"project_id\":10769,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11153,\"reporter\":11153,\"module\":\"345\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"sprint\":42}', '127.0.0.1', 1535980638),
(428, 10769, 'issue', 17643, 11153, '19052796505', '19059278687', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"17643\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10769\",\"issue_type\":\"1\",\"creator\":\"11153\",\"modifier\":\"0\",\"reporter\":\"11153\",\"assignee\":\"11153\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"resolve_date\":null,\"module\":\"345\",\"milestone\":null,\"sprint\":\"42\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"17643\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10769\",\"issue_type\":\"1\",\"creator\":\"11153\",\"modifier\":\"11153\",\"reporter\":\"11153\",\"assignee\":\"11153\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-02\",\"due_date\":\"2018-09-09\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1535980638),
(429, 10819, 'issue', 18155, 11180, '19051719956', '19069884712', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11180\",\"project_id\":10819,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11180,\"reporter\":11180,\"module\":\"395\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":67}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11180\",\"project_id\":10819,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11180,\"reporter\":11180,\"module\":\"395\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":67}', '127.0.0.1', 1536045031),
(430, 10821, 'issue', 18178, 11181, '19042388525', '19087533054', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11181\",\"project_id\":10821,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11181,\"reporter\":11181,\"module\":\"397\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":68}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11181\",\"project_id\":10821,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11181,\"reporter\":11181,\"module\":\"397\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":68}', '127.0.0.1', 1536045096),
(431, 10823, 'issue', 18201, 11182, '19062433836', '19019250521', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11182\",\"project_id\":10823,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11182,\"reporter\":11182,\"module\":\"399\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":69}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11182\",\"project_id\":10823,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11182,\"reporter\":11182,\"module\":\"399\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":69}', '127.0.0.1', 1536047675),
(432, 10825, 'issue', 18224, 11183, '19067834208', '19055027598', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11183\",\"project_id\":10825,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11183,\"reporter\":11183,\"module\":\"401\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":70}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11183\",\"project_id\":10825,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11183,\"reporter\":11183,\"module\":\"401\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":70}', '127.0.0.1', 1536047702),
(433, 10827, 'issue', 18247, 11184, '19030933152', '19027308712', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11184\",\"project_id\":10827,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11184,\"reporter\":11184,\"module\":\"403\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":71}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11184\",\"project_id\":10827,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11184,\"reporter\":11184,\"module\":\"403\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":71}', '127.0.0.1', 1536047737),
(434, 10829, 'issue', 18270, 11185, '19062767487', '19047437678', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11185\",\"project_id\":10829,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11185,\"reporter\":11185,\"module\":\"405\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":72}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11185\",\"project_id\":10829,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11185,\"reporter\":11185,\"module\":\"405\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"sprint\":72}', '127.0.0.1', 1536047759),
(435, 10829, 'issue', 18270, 11185, '19062767487', '19047437678', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"18270\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10829\",\"issue_type\":\"1\",\"creator\":\"11185\",\"modifier\":\"0\",\"reporter\":\"11185\",\"assignee\":\"11185\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-04\",\"due_date\":\"2018-09-11\",\"resolve_date\":null,\"module\":\"405\",\"milestone\":null,\"sprint\":\"72\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"18270\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10829\",\"issue_type\":\"1\",\"creator\":\"11185\",\"modifier\":\"11185\",\"reporter\":\"11185\",\"assignee\":\"11185\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-10\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1536047760),
(436, 10002, 'issue', 18271, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"Summary\",\"creator\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":10000,\"assignee\":10000,\"description\":\"Description\",\"module\":\"-1\",\"environment\":\"Environment\",\"start_date\":\"2018-09-10\",\"due_date\":\"\",\"milestone\":0}', '{\"summary\":\"Summary\",\"creator\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":10000,\"assignee\":10000,\"description\":\"Description\",\"module\":\"-1\",\"environment\":\"Environment\",\"start_date\":\"2018-09-10\",\"due_date\":\"\",\"milestone\":0}', '127.0.0.1', 1536435263),
(437, 10002, 'issue', 18272, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"Summary111\",\"creator\":\"10000\",\"reporter\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":1,\"assignee\":10100,\"description\":\"Description\",\"module\":\"12\",\"environment\":\"\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-11\",\"milestone\":0}', '{\"summary\":\"Summary111\",\"creator\":\"10000\",\"reporter\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":1,\"assignee\":10100,\"description\":\"Description\",\"module\":\"12\",\"environment\":\"\",\"start_date\":\"2018-09-03\",\"due_date\":\"2018-09-11\",\"milestone\":0}', '127.0.0.1', 1536435449),
(438, 10002, 'issue', 18273, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"Summary111111111111\",\"creator\":\"10000\",\"reporter\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":1,\"assignee\":10100,\"description\":\"Description11111\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"milestone\":0}', '{\"summary\":\"Summary111111111111\",\"creator\":\"10000\",\"reporter\":\"10000\",\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":1,\"assignee\":10100,\"description\":\"Description11111\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"milestone\":0}', '127.0.0.1', 1536435501),
(439, 10002, 'issue', 18273, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"18273\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10100\",\"summary\":\"Summary111111111111\",\"description\":\"Description11111\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"1\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":\"0\",\"sprint\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"18273\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":10100,\"summary\":\"Summary111111111111\",\"description\":\"Description11111\",\"environment\":\"Environment\",\"priority\":1,\"resolve\":1,\"status\":6,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"0100-01-01\",\"due_date\":\"0100-01-01\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":0,\"sprint\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1536436011),
(440, 10002, 'issue', 18273, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"18273\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10100\",\"summary\":\"Summary111111111111\",\"description\":\"Description11111\",\"environment\":\"Environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"6\",\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"0100-01-01\",\"due_date\":\"0100-01-01\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":\"0\",\"sprint\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"18273\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":10100,\"summary\":\"Summary111111111111\",\"description\":\"Description11111\",\"environment\":\"Environment\",\"priority\":1,\"resolve\":1,\"status\":1,\"created\":\"0\",\"updated\":\"0\",\"start_date\":\"2018-09-09\",\"due_date\":\"2018-09-09\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":0,\"sprint\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1536436027),
(441, 10002, 'issue', 18274, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u4e8b\\u98791\",\"creator\":\"10000\",\"reporter\":\"10000\",\"created\":1536508878,\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":1,\"assignee\":10100,\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":6}', '{\"summary\":\"\\u4e8b\\u98791\",\"creator\":\"10000\",\"reporter\":\"10000\",\"created\":1536508878,\"project_id\":10002,\"issue_type\":1,\"status\":1,\"priority\":1,\"resolve\":1,\"assignee\":10100,\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":6}', '127.0.0.1', 1536508878),
(442, 10002, 'issue', 18274, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"18274\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10100\",\"summary\":\"\\u4e8b\\u98791\",\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"1\",\"created\":\"1536508878\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"6\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"18274\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":10100,\"summary\":\"\\u4e8b\\u98791\",\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"environment\":\"\",\"priority\":1,\"resolve\":1,\"status\":6,\"created\":\"1536508878\",\"updated\":\"0\",\"start_date\":\"\",\"due_date\":\"\",\"resolve_date\":null,\"module\":\"12\",\"milestone\":0,\"sprint\":\"6\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1536510324),
(443, 10002, 'issue', 18274, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"18274\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10100\",\"summary\":\"\\u4e8b\\u98791\",\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"6\",\"created\":\"1536508878\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"12\",\"milestone\":\"0\",\"sprint\":\"6\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"18274\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":10000,\"summary\":\"\\u4e8b\\u98791\",\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"environment\":\"\",\"priority\":1,\"resolve\":1,\"status\":1,\"created\":\"1536508878\",\"updated\":\"0\",\"start_date\":\"\",\"due_date\":\"\",\"resolve_date\":null,\"module\":\"12\",\"milestone\":0,\"sprint\":\"6\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1536510656),
(444, 10002, 'issue', 18274, 10000, 'cdwei', '韦朝夺', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"18274\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u4e8b\\u98791\",\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"1\",\"created\":\"1536508878\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"12\",\"milestone\":\"0\",\"sprint\":\"6\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"18274\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"10002\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":10000,\"summary\":\"\\u4e8b\\u98791\",\"description\":\"\\u4e00\\u5927\\u5806\\u63cf\\u8ff0\",\"environment\":\"\",\"priority\":1,\"resolve\":1,\"status\":6,\"created\":\"1536508878\",\"updated\":\"0\",\"start_date\":\"\",\"due_date\":\"\",\"resolve_date\":null,\"module\":\"12\",\"milestone\":0,\"sprint\":\"6\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1536510801);

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
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `action` varchar(32) DEFAULT NULL COMMENT '动作说明,如 关闭了，创建了，修复了',
  `type` enum('agile','user','issue','issue_comment','project') DEFAULT 'issue' COMMENT 'project,issue,user,agile,issue_comment',
  `obj_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_activity`
--

INSERT INTO `main_activity` (`id`, `user_id`, `project_id`, `action`, `type`, `obj_id`, `title`, `date`, `time`) VALUES
(1, 10000, 10002, '重新打开', 'issue', 16936, ' 金工石类分销单订单，加工完成后，条码计算器显示的数据是供货商的，建议隐藏', '2018-07-21', 111111111),
(2, 10000, 10002, '修改', 'project', 10002, '类型 \"软件开发-->敏捷开发\"', '2018-08-25', 1535201403);

-- --------------------------------------------------------

--
-- 表的结构 `main_announcement`
--

CREATE TABLE `main_announcement` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `status` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '0为禁用,1为发布中',
  `flag` int(11) DEFAULT '0' COMMENT '每次发布将自增该字段',
  `expire_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_announcement`
--

INSERT INTO `main_announcement` (`id`, `content`, `status`, `flag`, `expire_time`) VALUES
(1, 'test-content-516516', 0, 2, 1536335343);

-- --------------------------------------------------------

--
-- 表的结构 `main_cache_key`
--

CREATE TABLE `main_cache_key` (
  `key` varchar(100) NOT NULL,
  `module` varchar(64) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `expire` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_cache_key`
--

INSERT INTO `main_cache_key` (`key`, `module`, `datetime`, `expire`) VALUES
('1', 'list', NULL, NULL),
('2', 'list', NULL, NULL),
('3', 'lsit', NULL, NULL);

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

--
-- 转存表中的数据 `main_eventtype`
--

INSERT INTO `main_eventtype` (`id`, `template_id`, `name`, `description`, `event_type`) VALUES
('1', NULL, 'Issue Created', 'This is the \'issue created\' event.', 'jira.system.event.type'),
('2', NULL, 'Issue Updated', 'This is the \'issue updated\' event.', 'jira.system.event.type'),
('3', NULL, 'Issue Assigned', 'This is the \'issue assigned\' event.', 'jira.system.event.type'),
('4', NULL, 'Issue Resolved', 'This is the \'issue resolved\' event.', 'jira.system.event.type'),
('5', NULL, 'Issue Closed', 'This is the \'issue closed\' event.', 'jira.system.event.type'),
('6', NULL, 'Issue Commented', 'This is the \'issue commented\' event.', 'jira.system.event.type'),
('7', NULL, 'Issue Reopened', 'This is the \'issue reopened\' event.', 'jira.system.event.type'),
('8', NULL, 'Issue Deleted', 'This is the \'issue deleted\' event.', 'jira.system.event.type'),
('9', NULL, 'Issue Moved', 'This is the \'issue moved\' event.', 'jira.system.event.type'),
('10', NULL, 'Work Logged On Issue', 'This is the \'work logged on issue\' event.', 'jira.system.event.type'),
('11', NULL, 'Work Started On Issue', 'This is the \'work started on issue\' event.', 'jira.system.event.type'),
('12', NULL, 'Work Stopped On Issue', 'This is the \'work stopped on issue\' event.', 'jira.system.event.type'),
('13', NULL, 'Generic Event', 'This is the \'generic event\' event.', 'jira.system.event.type'),
('14', NULL, 'Issue Comment Edited', 'This is the \'issue comment edited\' event.', 'jira.system.event.type'),
('15', NULL, 'Issue Worklog Updated', 'This is the \'issue worklog updated\' event.', 'jira.system.event.type'),
('16', NULL, 'Issue Worklog Deleted', 'This is the \'issue worklog deleted\' event.', 'jira.system.event.type'),
('17', NULL, 'Issue Comment Deleted', 'This is the \'issue comment deleted\' event.', 'jira.system.event.type');

-- --------------------------------------------------------

--
-- 表的结构 `main_group`
--

CREATE TABLE `main_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
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
(5, 'ui-designers', 1, NULL, NULL, NULL, '1', NULL),
(8, 'AAA', NULL, NULL, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `main_mailserver`
--

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
  `socks_host` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_mailserver`
--

INSERT INTO `main_mailserver` (`id`, `name`, `description`, `mailfrom`, `prefix`, `smtp_port`, `protocol`, `server_type`, `servername`, `jndilocation`, `mailusername`, `mailpassword`, `istlsrequired`, `timeout`, `socks_port`, `socks_host`) VALUES
('10000', 'JIRA邮件', '', 'ismond@vip.163.com', 'Ismond', '25', 'smtp', 'smtp', 'smtp.vip.163.com', NULL, 'ismond@vip.163.com', 'ismond163vip', 'false', '10000', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `main_mail_queue`
--

CREATE TABLE `main_mail_queue` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `create_time` int(11) UNSIGNED DEFAULT NULL,
  `error` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_mail_queue`
--

INSERT INTO `main_mail_queue` (`id`, `title`, `address`, `status`, `create_time`, `error`) VALUES
(1, '(BTOB-1142) 去除退货完成对应货品变为在售的逻辑', '121@qq.com', 'ready', NULL, NULL),
(2, '(SSZBD-642) 商品新添加库存时，上传的图片默认为试戴图', '121@qq.com', 'ready', NULL, NULL),
(3, '(BTOB-1143) 【定制BOM】toprings最闪婚戒排行榜店铺款式数据、工费方案、钻石价方案导入', '121@qq.com', 'done', NULL, NULL),
(4, '(SSZBD-622) 没有权限打折的员工，在选择折扣后没有提示，只有在提交订单时才提示', '1xx@qq.com', 'ready', NULL, NULL),
(6, '(SDX-650) 销售倍率，\"使用分类倍率\"不填，却提示\"倍率为数字并大于0\"', 'xxxx@qq.com', NULL, NULL, NULL),
(7, '(SDX-648) 销售-销售倍率，配置时出错，见描述', NULL, NULL, NULL, NULL),
(8, '(SSZBD-604) 支付的订金小于50%时，没有给出相应提示。可以正常下单x', NULL, NULL, NULL, NULL),
(9, '(SSZBD-604) 支付的订金小于50%时，没有给出相应提示。可以正常下单', NULL, NULL, NULL, NULL),
(16, 'test-title', 'test-address', 'ready', 1536336902, '');

-- --------------------------------------------------------

--
-- 表的结构 `main_org`
--

CREATE TABLE `main_org` (
  `id` int(11) NOT NULL,
  `path` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `avatar` varchar(256) NOT NULL DEFAULT '',
  `create_uid` int(11) NOT NULL DEFAULT '0',
  `created` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `updated` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `scope` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1 private, 2 internal , 3 public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_org`
--

INSERT INTO `main_org` (`id`, `path`, `name`, `description`, `avatar`, `create_uid`, `created`, `updated`, `scope`) VALUES
(1, 'default', 'Default', 'Default organization', 'all/20180826/20180826140421_58245.jpg', 0, 0, 1535263464, 3),
(2, 'ismond', 'Agile', '敏捷开发部', 'all/20180826/20180826140446_89680.jpg', 10000, 0, 1535263488, 1);

-- --------------------------------------------------------

--
-- 表的结构 `main_setting`
--

CREATE TABLE `main_setting` (
  `id` int(11) NOT NULL,
  `_key` varchar(50) NOT NULL COMMENT '关键字',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块,basic,advance,ui,datetime,languge,attachment可选',
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

INSERT INTO `main_setting` (`id`, `_key`, `title`, `module`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
(1, 'title', '标题', 'basic', 'MasterLab', 'Hornet', 'string', 'text', NULL, ''),
(2, 'open_status', '启用状态', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(3, 'max_login_error', '最大尝试验证登录次数', 'basic', '4', '4', 'int', 'text', NULL, ''),
(4, 'login_require_captcha', '登录时需要验证码', 'basic', '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(5, 'reg_require_captcha', '注册时需要验证码', 'basic', '0', '0', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(6, 'sender_format', '邮件发件人显示格式', 'basic', '${fullname} (Hornet)', '${fullname} (Hornet)', 'string', 'text', NULL, ''),
(7, 'description', '说明', 'basic', '', '', 'string', 'text', NULL, ''),
(8, 'date_timezone', '默认用户时区', 'basic', 'Asia/Shanghai', 'Asia/Shanghai', 'string', 'text', '[\"Asia/Shanghai\":\"\"]', ''),
(11, 'allow_share_public', '允许用户分享过滤器或面部', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(12, 'max_project_name', '项目名称最大长度', 'basic', '80', '80', 'int', 'text', NULL, ''),
(13, 'max_project_key', '项目键值最大长度', 'basic', '20', '20', 'int', 'text', NULL, ''),
(15, 'email_public', '邮件地址可见性', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(20, 'allow_gravatars', '允许使用Gravatars用户头像', 'basic', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(21, 'gravatar_server', 'Gravatar服务器', 'basic', '', '', 'string', 'text', NULL, ''),
(24, 'send_mail_format', '默认发送个邮件的格式', 'user_default', 'html', 'text', 'string', 'radio', '{\"text\":\"text\",\"html\":\"html\"}', ''),
(25, 'issue_page_size', '问题导航每页显示的问题数量', 'user_default', '100', '100', 'int', 'text', NULL, ''),
(39, 'time_format', '时间格式', 'datetime', 'HH:mm:ss', 'HH:mm:ss', 'string', 'text', NULL, '例如 11:55:47'),
(40, 'week_format', '星期格式', 'datetime', 'EEEE HH:mm:ss', 'EEEE HH:mm:ss', 'string', 'text', NULL, '例如 Wednesday 11:55:47'),
(41, 'full_datetime_format', '完整日期/时间格式', 'datetime', 'yyyy-MM-dd  HH:mm:ss', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', NULL, '例如 2007-05-23  11:55:47'),
(42, 'datetime_format', '日期格式(年月日)', 'datetime', 'yyyy-MM-dd', 'yyyy-MM-dd', 'string', 'text', NULL, '例如 2007-05-23'),
(43, 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天'),
(45, 'attachment_dir', '附件路径', 'attachment', '{{STORAGE_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下'),
(46, 'attachment_size', '附件大小(单位M)', 'attachment', '10.0', '10.0', 'float', 'text', NULL, '超过大小，无法上传'),
(47, 'enbale_thum', '启用缩略图', 'attachment', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图'),
(48, 'enable_zip', '启用ZIP支持', 'attachment', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载'),
(49, 'password_strategy', '密码策略', 'password_strategy', '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', ''),
(50, 'send_mailer', '发信人', 'mail', 'ismond@vip.163.com', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 'Hornet', '', 'string', 'text', NULL, ''),
(52, 'mail_host', '主机', 'mail', 'smtp.vip.163.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', '25', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 'ismond@vip.163.com', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 'ismond163vip', '', 'string', 'text', NULL, ''),
(56, 'mail_timeout', '发送超时', 'mail', '20', '', 'int', 'text', NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `main_timeline`
--

CREATE TABLE `main_timeline` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(12) NOT NULL DEFAULT '',
  `origin_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `issue_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `action` varchar(32) NOT NULL DEFAULT '',
  `action_icon` varchar(64) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `content_html` text NOT NULL,
  `time` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_timeline`
--

INSERT INTO `main_timeline` (`id`, `uid`, `type`, `origin_id`, `project_id`, `issue_id`, `action`, `action_icon`, `content`, `content_html`, `time`) VALUES
(1, 10000, 'issue', 0, 0, 16936, 'added ', '', 'added\r\n    <a href=\"/ismond/xphp/issues?label_name=Error\" data-original=\"~9\" data-link=\"false\" data-project=\"31\" data-label=\"9\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n        <span class=\"label color-label has-tooltip\" style=\"background-color: #FF0000; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"red waring\">Error</span></a>\r\n    <a href=\"/ismond/xphp/issues?label_name=Success\" data-original=\"~11\" data-link=\"false\" data-project=\"31\" data-label=\"11\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n        <span class=\"label color-label has-tooltip\" style=\"background-color: #69D100; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"\">Success</span></a>\r\n    <a href=\"/ismond/xphp/issues?label_name=Warn\" data-original=\"~10\" data-link=\"false\" data-project=\"31\" data-label=\"10\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n        <span class=\"label color-label has-tooltip\" style=\"background-color: #F0AD4E; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"Warning\">Warn</span></a>labels', '', 0),
(2, 10000, 'issue', 0, 0, 16936, 'added ', '', 'added\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Error\" data-original=\"~9\" data-link=\"false\" data-project=\"31\" data-label=\"9\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #FF0000; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"red waring\">Error</span></a>\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Success\" data-original=\"~11\" data-link=\"false\" data-project=\"31\" data-label=\"11\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #69D100; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"\">Success</span></a>\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Warn\" data-original=\"~10\" data-link=\"false\" data-project=\"31\" data-label=\"10\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #F0AD4E; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"Warning\">Warn</span></a>labels', '', 0),
(3, 10000, 'issue', 0, 0, 16936, 'removed', '', 'removed\r\n                                                                    <a href=\"/ismond/xphp/issues?label_name=Success\" data-original=\"~11\" data-link=\"false\" data-project=\"31\" data-label=\"11\" data-reference-type=\"label\" title=\"\" class=\"gfm gfm-label has-tooltip\" data-original-title=\"\">\r\n                                                                        <span class=\"label color-label has-tooltip\" style=\"background-color: #69D100; color: #FFFFFF\" title=\"\" data-container=\"body\" data-original-title=\"\">Success</span></a>label', '', 0),
(4, 10000, 'issue', 0, 0, 16936, 'changed ', '', 'changed milestone to\r\n                                                                    <a href=\"/ismond/xphp/milestones/1\" data-original=\"%1\" data-link=\"false\" data-project=\"31\" data-milestone=\"1\" data-reference-type=\"milestone\" title=\"\" class=\"gfm gfm-milestone has-tooltip\" data-original-title=\"\">New Milestone</a>', '', 0),
(5, 10000, 'issue', 0, 0, 16936, 'commented', '', 'commented', '<a class=\"no-attachment-icon\" href=\"http://192.168.3.213/ismond/xphp/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg\" target=\"_blank\" rel=\"noopener noreferrer\"><img src=\"http://192.168.3.213/ismond/xphp/uploads/bdcf4757ed0ba6dd2f3bde6179cf18bf/28186ee2d4c9536d2e009848b96765e6.jpg\" alt=\"28186ee2d4c9536d2e009848b96765e6\">                             </a>', 1522224215),
(6, 10000, 'issue', 0, 0, 16936, 'commented+reopened', '', 'commented+reopened', '', 1522224230),
(7, 10000, 'issue', 0, 0, 16936, 'commented', '', 'dfdsf', 'false', 1522400161),
(8, 10000, 'issue', 0, 0, 16936, 'commented', '', '![](http://wx.888zb.com/attachment/image/20180725/20180725004731_90568.jpg)', '<p><img src=\"http://wx.888zb.com/attachment/image/20180725/20180725004731_90568.jpg\" alt=\"\"></p>\n', 1532450854),
(9, 11186, 'issue', 0, 0, 18291, 'commented+reopened', '', 'test-content', 'test-content-html', 1536050994),
(10, 11187, 'issue', 0, 0, 18313, 'commented', '', 'test-content-updated', '', 1536051019),
(11, 11188, 'issue', 0, 0, 18335, 'commented', '', 'test-content-updated', '', 1536051036),
(12, 11189, 'issue', 0, 0, 18357, 'commented', '', 'test-content-updated', '', 1536051063),
(13, 11190, 'issue', 0, 0, 18379, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051118),
(14, 11191, 'issue', 0, 0, 18401, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051146),
(15, 11192, 'issue', 0, 0, 18423, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051176),
(16, 11193, 'issue', 0, 0, 18445, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051186),
(17, 11194, 'issue', 0, 0, 18467, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051220),
(18, 11195, 'issue', 0, 0, 18489, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051227),
(19, 11196, 'issue', 0, 0, 18511, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051244),
(20, 11197, 'issue', 0, 0, 18533, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051267),
(21, 11198, 'issue', 0, 0, 18555, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051294);

-- --------------------------------------------------------

--
-- 表的结构 `notification`
--

CREATE TABLE `notification` (
  `id` decimal(18,0) NOT NULL,
  `scheme` decimal(18,0) DEFAULT NULL,
  `event` varchar(60) DEFAULT NULL,
  `event_type_id` decimal(18,0) DEFAULT NULL,
  `template_id` decimal(18,0) DEFAULT NULL,
  `notif_type` varchar(60) DEFAULT NULL,
  `notif_parameter` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `notification`
--

INSERT INTO `notification` (`id`, `scheme`, `event`, `event_type_id`, `template_id`, `notif_type`, `notif_parameter`) VALUES
('10000', '10000', NULL, '1', NULL, 'Current_Assignee', NULL),
('10001', '10000', NULL, '1', NULL, 'Current_Reporter', NULL),
('10002', '10000', NULL, '1', NULL, 'All_Watchers', NULL),
('10003', '10000', NULL, '2', NULL, 'Current_Assignee', NULL),
('10004', '10000', NULL, '2', NULL, 'Current_Reporter', NULL),
('10005', '10000', NULL, '2', NULL, 'All_Watchers', NULL),
('10006', '10000', NULL, '3', NULL, 'Current_Assignee', NULL),
('10007', '10000', NULL, '3', NULL, 'Current_Reporter', NULL),
('10008', '10000', NULL, '3', NULL, 'All_Watchers', NULL),
('10009', '10000', NULL, '4', NULL, 'Current_Assignee', NULL),
('10010', '10000', NULL, '4', NULL, 'Current_Reporter', NULL),
('10011', '10000', NULL, '4', NULL, 'All_Watchers', NULL),
('10012', '10000', NULL, '5', NULL, 'Current_Assignee', NULL),
('10013', '10000', NULL, '5', NULL, 'Current_Reporter', NULL),
('10014', '10000', NULL, '5', NULL, 'All_Watchers', NULL),
('10015', '10000', NULL, '6', NULL, 'Current_Assignee', NULL),
('10016', '10000', NULL, '6', NULL, 'Current_Reporter', NULL),
('10017', '10000', NULL, '6', NULL, 'All_Watchers', NULL),
('10018', '10000', NULL, '7', NULL, 'Current_Assignee', NULL),
('10019', '10000', NULL, '7', NULL, 'Current_Reporter', NULL),
('10020', '10000', NULL, '7', NULL, 'All_Watchers', NULL),
('10021', '10000', NULL, '8', NULL, 'Current_Assignee', NULL),
('10022', '10000', NULL, '8', NULL, 'Current_Reporter', NULL),
('10023', '10000', NULL, '8', NULL, 'All_Watchers', NULL),
('10024', '10000', NULL, '9', NULL, 'Current_Assignee', NULL),
('10025', '10000', NULL, '9', NULL, 'Current_Reporter', NULL),
('10026', '10000', NULL, '9', NULL, 'All_Watchers', NULL),
('10027', '10000', NULL, '10', NULL, 'Current_Assignee', NULL),
('10028', '10000', NULL, '10', NULL, 'Current_Reporter', NULL),
('10029', '10000', NULL, '10', NULL, 'All_Watchers', NULL),
('10030', '10000', NULL, '11', NULL, 'Current_Assignee', NULL),
('10031', '10000', NULL, '11', NULL, 'Current_Reporter', NULL),
('10032', '10000', NULL, '11', NULL, 'All_Watchers', NULL),
('10033', '10000', NULL, '12', NULL, 'Current_Assignee', NULL),
('10034', '10000', NULL, '12', NULL, 'Current_Reporter', NULL),
('10035', '10000', NULL, '12', NULL, 'All_Watchers', NULL),
('10036', '10000', NULL, '13', NULL, 'Current_Assignee', NULL),
('10037', '10000', NULL, '13', NULL, 'Current_Reporter', NULL),
('10038', '10000', NULL, '13', NULL, 'All_Watchers', NULL),
('10100', '10000', NULL, '14', NULL, 'Current_Assignee', NULL),
('10101', '10000', NULL, '14', NULL, 'Current_Reporter', NULL),
('10102', '10000', NULL, '14', NULL, 'All_Watchers', NULL),
('10103', '10000', NULL, '15', NULL, 'Current_Assignee', NULL),
('10104', '10000', NULL, '15', NULL, 'Current_Reporter', NULL),
('10105', '10000', NULL, '15', NULL, 'All_Watchers', NULL),
('10106', '10000', NULL, '16', NULL, 'Current_Assignee', NULL),
('10107', '10000', NULL, '16', NULL, 'Current_Reporter', NULL),
('10108', '10000', NULL, '16', NULL, 'All_Watchers', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `notification_instance`
--

CREATE TABLE `notification_instance` (
  `id` decimal(18,0) NOT NULL,
  `notificationtype` varchar(60) DEFAULT NULL,
  `source` decimal(18,0) DEFAULT NULL,
  `emailaddress` varchar(255) DEFAULT NULL,
  `messageid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `notification_scheme`
--

CREATE TABLE `notification_scheme` (
  `id` decimal(18,0) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `notification_scheme`
--

INSERT INTO `notification_scheme` (`id`, `name`, `description`) VALUES
('10000', '默认通知方案', '');

-- --------------------------------------------------------

--
-- 表的结构 `option_configuration`
--

CREATE TABLE `option_configuration` (
  `id` decimal(18,0) NOT NULL,
  `fieldid` varchar(60) DEFAULT NULL,
  `optionid` varchar(60) DEFAULT NULL,
  `fieldconfig` decimal(18,0) DEFAULT NULL,
  `sequence` decimal(18,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `option_configuration`
--

INSERT INTO `option_configuration` (`id`, `fieldid`, `optionid`, `fieldconfig`, `sequence`) VALUES
('10300', 'issuetype', '1', '10215', '0'),
('10301', 'issuetype', '2', '10215', '1'),
('10302', 'issuetype', '5', '10215', '2'),
('10303', 'issuetype', '10001', '10215', '3'),
('10304', 'issuetype', '3', '10215', '4'),
('10324', 'issuetype', '1', '10221', '0'),
('10325', 'issuetype', '10105', '10221', '1'),
('10326', 'issuetype', '10104', '10221', '2'),
('10327', 'issuetype', '10102', '10221', '3'),
('10328', 'issuetype', '10103', '10221', '4'),
('10400', 'issuetype', '10000', '10100', '0'),
('10401', 'issuetype', '10001', '10100', '1'),
('10402', 'issuetype', '10002', '10100', '2'),
('10403', 'issuetype', '1', '10100', '3'),
('10404', 'issuetype', '4', '10100', '4'),
('10405', 'issuetype', '2', '10100', '5'),
('10406', 'issuetype', '10103', '10100', '6'),
('10441', 'issuetype', '1', '10000', '0'),
('10442', 'issuetype', '2', '10000', '1'),
('10443', 'issuetype', '3', '10000', '2'),
('10444', 'issuetype', '4', '10000', '3'),
('10445', 'issuetype', '5', '10000', '4'),
('10446', 'issuetype', '10000', '10000', '5'),
('10447', 'issuetype', '10001', '10000', '6'),
('10448', 'issuetype', '10002', '10000', '7'),
('10449', 'issuetype', '10100', '10000', '8'),
('10450', 'issuetype', '10101', '10000', '9'),
('10451', 'issuetype', '1', '10300', '0'),
('10452', 'issuetype', '10105', '10300', '1'),
('10453', 'issuetype', '10104', '10300', '2'),
('10454', 'issuetype', '10102', '10300', '3'),
('10455', 'issuetype', '10103', '10300', '4'),
('10456', 'issuetype', '1', '10301', '0'),
('10457', 'issuetype', '10105', '10301', '1'),
('10458', 'issuetype', '10104', '10301', '2'),
('10459', 'issuetype', '10102', '10301', '3'),
('10460', 'issuetype', '10103', '10301', '4');

-- --------------------------------------------------------

--
-- 表的结构 `permission`
--

CREATE TABLE `permission` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `_key` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission`
--

INSERT INTO `permission` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES
(10004, 0, '管理项目', '可以对项目进行设置', 'ADMINISTER_PROJECTS'),
(10005, 0, '访问事项列表', '', 'BROWSE_ISSUES'),
(10006, 0, '创建事项', '', 'CREATE_ISSUES'),
(10007, 0, '评论', '', 'ADD_COMMENTS'),
(10008, 0, '上传附件', '', 'CREATE_ATTACHMENTS'),
(10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES'),
(10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES'),
(10015, 0, '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES'),
(10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS'),
(10902, 0, '管理backlog', '', 'MANAGE_BACKLOG'),
(10903, 0, '管理sprint', '', 'MANAGE_SPRINT'),
(10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN');

-- --------------------------------------------------------

--
-- 表的结构 `permission_default_role`
--

CREATE TABLE `permission_default_role` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT '0' COMMENT '如果为0表示系统初始化的角色，不为0表示某一项目特有的角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目角色表';

--
-- 转存表中的数据 `permission_default_role`
--

INSERT INTO `permission_default_role` (`id`, `name`, `description`, `project_id`) VALUES
(10000, 'Users', 'A project role that represents users in a project', 0),
(10001, 'Developers', 'A project role that represents developers in a project', 0),
(10002, 'Administrators', 'A project role that represents administrators in a project', 0),
(10003, 'QA', NULL, 0),
(10006, 'PO', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `permission_default_role_relation`
--

CREATE TABLE `permission_default_role_relation` (
  `id` int(11) UNSIGNED NOT NULL,
  `default_role_id` int(11) UNSIGNED DEFAULT NULL,
  `perm_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission_default_role_relation`
--

INSERT INTO `permission_default_role_relation` (`id`, `default_role_id`, `perm_id`) VALUES
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
(54, 10001, 10028),
(55, 10002, 10004),
(56, 10002, 10005),
(57, 10002, 10006),
(58, 10002, 10007),
(59, 10002, 10008),
(60, 10002, 10013),
(61, 10002, 10014),
(62, 10002, 10015),
(63, 10002, 10028),
(64, 10002, 10902),
(65, 10002, 10903),
(66, 10002, 10904),
(67, 10006, 10004),
(68, 10006, 10005),
(69, 10006, 10006),
(70, 10006, 10007),
(71, 10006, 10008),
(72, 10006, 10013),
(73, 10006, 10014),
(74, 10006, 10015),
(75, 10006, 10028),
(76, 10006, 10902),
(77, 10006, 10903),
(78, 10006, 10904);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global`
--

CREATE TABLE `permission_global` (
  `id` int(11) UNSIGNED NOT NULL,
  `_key` varchar(64) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='全局权限定义表';

--
-- 转存表中的数据 `permission_global`
--

INSERT INTO `permission_global` (`id`, `_key`, `name`, `description`) VALUES
(10000, '系统管理员', '系统管理员', '负责执行所有管理功能。至少在这个权限中设置一个用户组。');

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_group`
--

CREATE TABLE `permission_global_group` (
  `id` int(11) UNSIGNED NOT NULL,
  `perm_global_id` int(11) UNSIGNED DEFAULT NULL,
  `group_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission_global_group`
--

INSERT INTO `permission_global_group` (`id`, `perm_global_id`, `group_id`) VALUES
(1, 10000, 1),
(2, 10000, 2),
(7, 10000, 3);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_relation`
--

CREATE TABLE `permission_global_relation` (
  `id` int(11) UNSIGNED NOT NULL,
  `perm_global_id` int(11) UNSIGNED DEFAULT NULL,
  `group_id` int(11) UNSIGNED DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否系统自带'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组拥有的全局权限';

--
-- 转存表中的数据 `permission_global_relation`
--

INSERT INTO `permission_global_relation` (`id`, `perm_global_id`, `group_id`, `is_system`) VALUES
(2, 10001, 5, 1),
(8, 10000, 1, 1),
(9, 10000, 4, 0),
(10, 10003, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `project_category`
--

CREATE TABLE `project_category` (
  `id` int(18) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `color` varchar(20) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_issue_report`
--

CREATE TABLE `project_issue_report` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `done_count` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `no_done_count` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `done_count_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `no_done_count_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_issue_report`
--

INSERT INTO `project_issue_report` (`id`, `project_id`, `date`, `week`, `month`, `done_count`, `no_done_count`, `done_count_by_resolve`, `no_done_count_by_resolve`, `today_done_points`, `today_done_number`) VALUES
(1, 10500, '2018-07-30', NULL, NULL, 10, 5, 0, NULL, 0, 0),
(2, 10500, '2018-07-31', NULL, NULL, 2, 3, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `project_issue_type_scheme_data`
--

CREATE TABLE `project_issue_type_scheme_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_type_scheme_id` int(11) UNSIGNED DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_issue_type_scheme_data`
--

INSERT INTO `project_issue_type_scheme_data` (`id`, `issue_type_scheme_id`, `project_id`) VALUES
(3, 6, 10508),
(5, 4, 10509),
(6, 1, 10566),
(7, 20, 10989),
(8, 21, 10991),
(9, 23, 10993),
(10, 24, 10995),
(11, 25, 10997),
(12, 2, 10999),
(13, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `project_key`
--

CREATE TABLE `project_key` (
  `id` decimal(18,0) NOT NULL,
  `project_id` decimal(18,0) DEFAULT NULL,
  `project_key` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_key`
--

INSERT INTO `project_key` (`id`, `project_id`, `project_key`) VALUES
('10002', '10002', 'IP'),
('10003', '10003', 'ISC'),
('10004', '10004', 'DIAMOND'),
('10005', '10005', 'ZB'),
('10006', '10006', 'CS'),
('10008', '10008', 'BTB'),
('10009', '10009', 'DIST'),
('10013', '10008', 'ISMOND'),
('10014', '10008', 'ALL'),
('10015', '10013', 'SJZX'),
('10100', '10100', 'TM'),
('10101', '10101', 'SITE'),
('10102', '10102', 'JXC'),
('10103', '10103', 'SMDIST'),
('10104', '10104', 'WBDIST'),
('10105', '10105', 'BIGDATA'),
('10106', '10106', 'YW'),
('10107', '10107', 'SP'),
('10108', '10108', 'ACTIVITY'),
('10110', '10110', 'IS'),
('10111', '10111', 'RF'),
('10112', '10112', 'DC'),
('10200', '10200', 'ZUANADMIN'),
('10207', '10206', 'SCB'),
('10208', '10207', 'ZZSJXC'),
('10300', '10300', 'IBLOVE'),
('10400', '10400', 'ZZSJXCI'),
('10401', '10401', 'BTOB'),
('10402', '10402', 'UED'),
('10403', '10403', 'GYLYSJ'),
('10404', '10404', 'SDX'),
('10500', '10500', 'SSZBD'),
('10501', '10501', 'BOM');

-- --------------------------------------------------------

--
-- 表的结构 `project_label`
--

CREATE TABLE `project_label` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(64) NOT NULL,
  `color` varchar(20) NOT NULL,
  `bg_color` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_label`
--

INSERT INTO `project_label` (`id`, `project_id`, `title`, `color`, `bg_color`) VALUES
(1, 0, 'Error', '#FFFFFF', '#FF0000'),
(2, 0, 'Success', '#FFFFFF', '#69D100'),
(3, 0, 'Warn', '#FFFFFF', '#F0AD4E'),
(4, 10002, 'FSDFDS', '#FFFFFF', '#428BCA');

-- --------------------------------------------------------

--
-- 表的结构 `project_list_count`
--

CREATE TABLE `project_list_count` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_type_id` smallint(5) UNSIGNED DEFAULT NULL,
  `project_total` int(10) UNSIGNED DEFAULT NULL,
  `remark` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_list_count`
--

INSERT INTO `project_list_count` (`id`, `project_type_id`, `project_total`, `remark`) VALUES
(1, 10, 1, '敏捷开发项目总数'),
(2, 20, 0, '看板开发项目总数'),
(3, 30, 0, '软件开发项目总数'),
(4, 40, 0, '项目管理项目总数'),
(5, 50, 0, '流程管理项目总数'),
(6, 60, 0, '任务管理项目总数');

-- --------------------------------------------------------

--
-- 表的结构 `project_main`
--

CREATE TABLE `project_main` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_id` int(11) NOT NULL DEFAULT '1',
  `org_path` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `lead` int(11) UNSIGNED DEFAULT '0',
  `description` varchar(2000) DEFAULT NULL,
  `key` varchar(20) DEFAULT NULL,
  `pcounter` decimal(18,0) DEFAULT NULL,
  `default_assignee` int(11) UNSIGNED DEFAULT '0',
  `assignee_type` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `category` int(11) UNSIGNED DEFAULT NULL,
  `type` tinyint(2) DEFAULT '1',
  `type_child` tinyint(2) DEFAULT '0',
  `permission_scheme_id` int(11) UNSIGNED DEFAULT '0',
  `workflow_scheme_id` int(11) UNSIGNED NOT NULL,
  `create_uid` int(11) UNSIGNED DEFAULT '0',
  `create_time` int(11) UNSIGNED DEFAULT '0',
  `detail` text,
  `un_done_count` int(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '未完成事项数',
  `done_count` int(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '已经完成事项数',
  `closed_count` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_main`
--

INSERT INTO `project_main` (`id`, `org_id`, `org_path`, `name`, `url`, `lead`, `description`, `key`, `pcounter`, `default_assignee`, `assignee_type`, `avatar`, `category`, `type`, `type_child`, `permission_scheme_id`, `workflow_scheme_id`, `create_uid`, `create_time`, `detail`, `un_done_count`, `done_count`, `closed_count`) VALUES
(1, 1, '', '客户管理crm系统', '', 10000, '基于人工智能的客户关系管理系统', 'CRM', NULL, 1, NULL, '', 0, 10, 0, 0, 0, 10000, 1536553005, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `project_module`
--

CREATE TABLE `project_module` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(64) DEFAULT '',
  `description` varchar(256) DEFAULT NULL,
  `lead` int(11) UNSIGNED DEFAULT NULL,
  `default_assignee` int(11) UNSIGNED DEFAULT NULL,
  `ctime` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_role`
--

CREATE TABLE `project_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否是默认角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_role`
--

INSERT INTO `project_role` (`id`, `project_id`, `name`, `description`, `is_system`) VALUES
(1, 1, 'Users', 'A project role that represents users in a project', 1),
(2, 1, 'Developers', 'A project role that represents developers in a project', 1),
(3, 1, 'Administrators', 'A project role that represents administrators in a project', 1),
(4, 1, 'QA', NULL, 1),
(5, 1, 'PO', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `project_role_relation`
--

CREATE TABLE `project_role_relation` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `role_id` int(11) UNSIGNED DEFAULT NULL,
  `perm_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_role_relation`
--

INSERT INTO `project_role_relation` (`id`, `project_id`, `role_id`, `perm_id`) VALUES
(1, 1, 1, 10005),
(2, 1, 1, 10006),
(3, 1, 1, 10007),
(4, 1, 1, 10008),
(5, 1, 1, 10013),
(6, 1, 2, 10005),
(7, 1, 2, 10006),
(8, 1, 2, 10007),
(9, 1, 2, 10008),
(10, 1, 2, 10013),
(11, 1, 2, 10014),
(12, 1, 2, 10015),
(13, 1, 2, 10028),
(14, 1, 3, 10004),
(15, 1, 3, 10005),
(16, 1, 3, 10006),
(17, 1, 3, 10007),
(18, 1, 3, 10008),
(19, 1, 3, 10013),
(20, 1, 3, 10014),
(21, 1, 3, 10015),
(22, 1, 3, 10028),
(23, 1, 3, 10902),
(24, 1, 3, 10903),
(25, 1, 3, 10904),
(26, 1, 5, 10004),
(27, 1, 5, 10005),
(28, 1, 5, 10006),
(29, 1, 5, 10007),
(30, 1, 5, 10008),
(31, 1, 5, 10013),
(32, 1, 5, 10014),
(33, 1, 5, 10015),
(34, 1, 5, 10028),
(35, 1, 5, 10902),
(36, 1, 5, 10903),
(37, 1, 5, 10904);

-- --------------------------------------------------------

--
-- 表的结构 `project_user_role`
--

CREATE TABLE `project_user_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT '0',
  `project_id` int(11) UNSIGNED DEFAULT '0',
  `role_id` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_version`
--

CREATE TABLE `project_version` (
  `id` int(11) NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `sequence` decimal(18,0) DEFAULT NULL,
  `released` tinyint(10) UNSIGNED DEFAULT '0' COMMENT '0未发布 1已发布',
  `archived` varchar(10) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `start_date` int(10) UNSIGNED DEFAULT NULL,
  `release_date` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_version`
--

INSERT INTO `project_version` (`id`, `project_id`, `name`, `description`, `sequence`, `released`, `archived`, `url`, `start_date`, `release_date`) VALUES
(2, 10002, 'Vsersion 5.0', 'hhhh', '0', 1, NULL, '', 1518105600, 1518969600),
(3, 10002, 'Vsersion 6.0', '鹅鹅鹅', '0', NULL, NULL, '', 1515427200, 1518969600),
(4, 10002, 'Vsersion 6.0.1', 'qqq', '0', NULL, NULL, '', 1515427200, 1519056000),
(5, 10002, 'Vsersion 6.0.2', 'ddd', '0', NULL, NULL, '', 1515427200, 1519056000),
(6, 10002, 'Vsersion 6.0.3', 'aaa', '0', NULL, NULL, '', 1518451200, 1519747200),
(7, 10509, 'V0.0.1', 'vvv', '0', 0, NULL, '', 1518969600, 1519660800),
(8, 10509, 'V0.0.2', '2222', '0', 0, NULL, '', 1519142400, 1519660800),
(9, 10003, 'Vsersion 5.0', 'hhhh', '0', 1, NULL, '', 1518105600, 1518969600),
(10, 10003, 'Vsersion 6.0', '鹅鹅鹅', '0', NULL, NULL, '', 1515427200, 1518969600),
(11, 10003, 'Vsersion 6.0.1', 'qqq', '0', NULL, NULL, '', 1515427200, 1519056000),
(12, 10002, 'v7', '发', '0', 0, NULL, '', 1524067200, 1527350400),
(13, 10002, 'v8', '发123', '0', 0, NULL, '', 1524067200, 1527350400),
(14, 10002, 'v9', 'ddd', '0', 0, NULL, '', 1525449600, 1525795200),
(15, 0, 'test-name', 'test-description', '0', 0, NULL, NULL, NULL, NULL),
(16, 10701, 'test-name', 'test-description', '0', 0, NULL, NULL, NULL, NULL);

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

--
-- 转存表中的数据 `project_workflows`
--

INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10000', 'classic default workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.description\">The classic JIRA default workflow</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create Issue\">\n      <meta name=\"opsbar-sequence\">0</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <common-actions>\n    <action id=\"2\" name=\"Close Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">60</meta>\n      <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n      <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n      <meta name=\"jira.i18n.title\">closeissue.title</meta>\n      <restrict-to>\n        <conditions type=\"AND\">\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Resolve Issue</arg>\n          </condition>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Close Issue</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">5</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"3\" name=\"Reopen Issue\" view=\"commentassign\">\n      <meta name=\"opsbar-sequence\">80</meta>\n      <meta name=\"jira.i18n.submit\">issue.operations.reopen.issue</meta>\n      <meta name=\"jira.i18n.description\">issue.operations.reopen.description</meta>\n      <meta name=\"jira.i18n.title\">issue.operations.reopen.issue</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Resolve Issue</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Reopened\" step=\"5\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"field.name\">resolution</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">7</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"4\" name=\"Start Progress\">\n      <meta name=\"opsbar-sequence\">20</meta>\n      <meta name=\"jira.i18n.title\">startprogress.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.AllowOnlyAssignee</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Underway\" step=\"3\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"field.name\">resolution</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">11</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"5\" name=\"Resolve Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">40</meta>\n      <meta name=\"jira.i18n.submit\">resolveissue.resolve</meta>\n      <meta name=\"jira.i18n.description\">resolveissue.desc.line1</meta>\n      <meta name=\"jira.i18n.title\">resolveissue.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n            <arg name=\"permission\">Resolve Issue</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Resolved\" step=\"4\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">4</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </common-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n<common-action id=\"4\" />\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n      </actions>\n    </step>\n    <step id=\"3\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n        <action id=\"301\" name=\"Stop Progress\">\n          <meta name=\"opsbar-sequence\">20</meta>\n          <meta name=\"jira.i18n.title\">stopprogress.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.AllowOnlyAssignee</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Assigned\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">12</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"Resolved\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n<common-action id=\"3\" />\n        <action id=\"701\" name=\"Close Issue\" view=\"commentassign\">\n          <meta name=\"opsbar-sequence\">60</meta>\n          <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n          <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n          <meta name=\"jira.i18n.title\">closeissue.title</meta>\n          <meta name=\"jira.description\">Closing an issue indicates there is no more work to be done on it, and it has been verified as complete.</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">Close Issue</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">5</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"Reopened\">\n      <meta name=\"jira.status.id\">4</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n<common-action id=\"4\" />\n      </actions>\n    </step>\n    <step id=\"6\" name=\"Closed\">\n      <meta name=\"jira.status.id\">6</meta>\n      <meta name=\"jira.issue.editable\">false</meta>\n      <actions>\n<common-action id=\"3\" />\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL),
('10100', 'Software Simplified Workflow for Project PROJ', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.description\">Generated by JIRA Software version 6.7.7. This workflow is managed internally by JIRA Software. Do not manually modify this workflow.</meta>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.updated.date\">1438661316737</meta>\n  <meta name=\"jira.update.author.name\">admin</meta>\n  <meta name=\"gh.version\">6.7.7</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"permission\">Create Issue</arg>\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"To Do\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">1</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <global-actions>\n    <action id=\"11\" name=\"To Do\">\n      <meta name=\"jira.description\"></meta>\n      <meta name=\"jira.i18n.title\">gh.workflow.preset.todo</meta>\n      <results>\n        <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">\n                                com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">13</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"21\" name=\"In Progress\">\n      <meta name=\"jira.description\"></meta>\n      <meta name=\"jira.i18n.title\">gh.workflow.preset.inprogress</meta>\n      <results>\n        <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"6\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">\n                                com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">13</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"31\" name=\"Done\">\n      <meta name=\"jira.description\"></meta>\n      <meta name=\"jira.i18n.title\">gh.workflow.preset.done</meta>\n      <results>\n        <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"11\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\">10000</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">\n                                com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction\n                            </arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">13</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction\n                            </arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </global-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n    </step>\n    <step id=\"6\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n    </step>\n    <step id=\"11\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n    </step>\n  </steps>\n</workflow>\n', NULL);
INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10101', 'IP: Software Development Workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1439433533440</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10000</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10000</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10000</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL);
INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10102', 'DIAMOND: Software Development Workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1439791434353</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL),
('10103', 'WTGZL', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\">AAA</meta>\n  <meta name=\"jira.updated.date\">1447039624991</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n        <action id=\"11\" name=\"A\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"进行中\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"21\" name=\"B\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"已解决\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n        <action id=\"31\" name=\"C\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"关闭问题\">\n      <meta name=\"jira.status.id\">6</meta>\n      <actions>\n        <action id=\"41\" name=\"D\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"5\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"重启问题\">\n      <meta name=\"jira.status.id\">4</meta>\n    </step>\n  </steps>\n</workflow>\n', NULL);
INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10104', 'IPAD', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1447040475323</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n        <action id=\"11\" name=\"A\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"进行中\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"21\" name=\"B\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"已解决\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n        <action id=\"31\" name=\"C\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"关闭\">\n      <meta name=\"jira.status.id\">6</meta>\n      <actions>\n        <action id=\"41\" name=\"D\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"5\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"重启问题\">\n      <meta name=\"jira.status.id\">4</meta>\n      <actions>\n        <action id=\"51\" name=\"E\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"F\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"71\" name=\"G\">\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.fieldscreen.id\"></meta>\n          <results>\n            <unconditional-result old-status=\"null\" status=\"null\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL),
('10200', 'YW: Software Development Workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1460083681271</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL);
INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10201', 'Copy of DIAMOND: Software Development Workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">fzj01571</meta>\n  <meta name=\"jira.description\">(这是一个当工作流\'DIAMOND: Software Development Workflow\'取消激活时从草稿自动产生的副本。)</meta>\n  <meta name=\"jira.updated.date\">1460623174865</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\">10001</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL);
INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10202', 'ACTIVITY: Software Development Workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.updated.date\">1463630592397</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create\">\n      <meta name=\"jira.i18n.submit\">common.forms.create</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n          <arg name=\"permission\">Create Issue</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"null\" status=\"open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n              <arg name=\"eventTypeId\">1</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <steps>\n    <step id=\"1\" name=\"To Do\">\n      <meta name=\"jira.status.id\">10000</meta>\n      <actions>\n        <action id=\"11\" name=\"Start Progress\">\n          <meta name=\"jira.i18n.submit\">startprogress.title</meta>\n          <meta name=\"jira.i18n.title\">startprogress.title</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"21\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"131\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"2\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n        <action id=\"71\" name=\"Start Review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.startreview.name</meta>\n          <meta name=\"jira.description\">Start Review</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"151\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"161\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"3\" name=\"Done\">\n      <meta name=\"jira.status.id\">10001</meta>\n      <actions>\n        <action id=\"51\" name=\"Reopen\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopen.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"61\" name=\"Reopen and start progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"101\" name=\"Reopen and start review\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.reopenandstartreview.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"4\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"In Review\">\n      <meta name=\"jira.status.id\">10002</meta>\n      <actions>\n        <action id=\"91\" name=\"Done\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.done.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">resolve</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"3\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.value\">10102</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                  <arg name=\"field.name\">resolution</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"171\" name=\"Restart Progress\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.restartprogress.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"2\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n        <action id=\"181\" name=\"To Do\">\n          <meta name=\"jira.i18n.submit\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.i18n.title\">jira.softwaredevelopment.workflow.action.todo.name</meta>\n          <meta name=\"jira.description\"></meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n                <arg name=\"permission\">assignable</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Not Done\" status=\"Done\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowupdateissuestatus-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowcreatecomment-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowgeneratechangehistory-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowreindexissue-function</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                  <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowfireevent-function</arg>\n                  <arg name=\"eventTypeId\">13</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL);
INSERT INTO `project_workflows` (`id`, `workflowname`, `creatorname`, `descriptor`, `islocked`) VALUES
('10300', 'BTOB Workflow', NULL, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<!DOCTYPE workflow PUBLIC \"-//OpenSymphony Group//DTD OSWorkflow 2.8//EN\" \"http://www.opensymphony.com/osworkflow/workflow_2_8.dtd\">\n<workflow>\n  <meta name=\"jira.description\"></meta>\n  <meta name=\"jira.update.author.key\">wseven</meta>\n  <meta name=\"jira.updated.date\">1504855305491</meta>\n  <initial-actions>\n    <action id=\"1\" name=\"Create Issue\">\n      <meta name=\"opsbar-sequence\">0</meta>\n      <meta name=\"jira.i18n.title\">common.forms.create</meta>\n      <validators>\n        <validator name=\"\" type=\"class\">\n          <arg name=\"permission\">Create Issue</arg>\n          <arg name=\"class.name\">com.atlassian.jira.workflow.validator.PermissionValidator</arg>\n        </validator>\n      </validators>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Open\" step=\"1\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueCreateFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">1</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </initial-actions>\n  <common-actions>\n    <action id=\"2\" name=\"Close Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">60</meta>\n      <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n      <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n      <meta name=\"jira.i18n.title\">closeissue.title</meta>\n      <restrict-to>\n        <conditions type=\"AND\">\n          <condition type=\"class\">\n            <arg name=\"permission\">Resolve Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n          <condition type=\"class\">\n            <arg name=\"permission\">Close Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">5</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"3\" name=\"Reopen Issue\" view=\"commentassign\">\n      <meta name=\"opsbar-sequence\">80</meta>\n      <meta name=\"jira.i18n.submit\">issue.operations.reopen.issue</meta>\n      <meta name=\"jira.i18n.description\">issue.operations.reopen.description</meta>\n      <meta name=\"jira.i18n.title\">issue.operations.reopen.issue</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"permission\">Resolve Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Reopened\" step=\"5\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">7</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"4\" name=\"Start Progress\">\n      <meta name=\"opsbar-sequence\">20</meta>\n      <meta name=\"jira.i18n.title\">startprogress.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"permission\">assignable</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Underway\" step=\"3\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"field.name\">resolution</arg>\n              <arg name=\"field.value\"></arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"full.module.key\">com.atlassian.jira.plugin.system.workflowassigntocurrentuser-function</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.AssignToCurrentUserFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">11</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n    <action id=\"5\" name=\"Resolve Issue\" view=\"resolveissue\">\n      <meta name=\"opsbar-sequence\">40</meta>\n      <meta name=\"jira.i18n.submit\">resolveissue.resolve</meta>\n      <meta name=\"jira.i18n.description\">resolveissue.desc.line1</meta>\n      <meta name=\"jira.i18n.title\">resolveissue.title</meta>\n      <restrict-to>\n        <conditions>\n          <condition type=\"class\">\n            <arg name=\"permission\">Resolve Issue</arg>\n            <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n          </condition>\n        </conditions>\n      </restrict-to>\n      <results>\n        <unconditional-result old-status=\"Finished\" status=\"Resolved\" step=\"4\">\n          <post-functions>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n            </function>\n            <function type=\"class\">\n              <arg name=\"eventTypeId\">4</arg>\n              <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n            </function>\n          </post-functions>\n        </unconditional-result>\n      </results>\n    </action>\n  </common-actions>\n  <steps>\n    <step id=\"1\" name=\"Open\">\n      <meta name=\"jira.status.id\">1</meta>\n      <actions>\n<common-action id=\"4\" />\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n      </actions>\n    </step>\n    <step id=\"3\" name=\"In Progress\">\n      <meta name=\"jira.status.id\">3</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n        <action id=\"301\" name=\"Stop Progress\">\n          <meta name=\"opsbar-sequence\">20</meta>\n          <meta name=\"jira.i18n.title\">stopprogress.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"permission\">assignable</arg>\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Assigned\" step=\"1\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"field.name\">resolution</arg>\n                  <arg name=\"field.value\"></arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueFieldFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"eventTypeId\">12</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"4\" name=\"Resolved\">\n      <meta name=\"jira.status.id\">5</meta>\n      <actions>\n<common-action id=\"3\" />\n        <action id=\"701\" name=\"Close Issue\" view=\"commentassign\">\n          <meta name=\"opsbar-sequence\">60</meta>\n          <meta name=\"jira.i18n.submit\">closeissue.close</meta>\n          <meta name=\"jira.description\">Closing an issue indicates there is no more work to be done on it, and it has been verified as complete.</meta>\n          <meta name=\"jira.i18n.description\">closeissue.desc</meta>\n          <meta name=\"jira.i18n.title\">closeissue.title</meta>\n          <restrict-to>\n            <conditions>\n              <condition type=\"class\">\n                <arg name=\"permission\">Close Issue</arg>\n                <arg name=\"class.name\">com.atlassian.jira.workflow.condition.PermissionCondition</arg>\n              </condition>\n            </conditions>\n          </restrict-to>\n          <results>\n            <unconditional-result old-status=\"Finished\" status=\"Closed\" step=\"6\">\n              <post-functions>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.UpdateIssueStatusFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.misc.CreateCommentFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.GenerateChangeHistoryFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.issue.IssueReindexFunction</arg>\n                </function>\n                <function type=\"class\">\n                  <arg name=\"eventTypeId\">5</arg>\n                  <arg name=\"class.name\">com.atlassian.jira.workflow.function.event.FireIssueEventFunction</arg>\n                </function>\n              </post-functions>\n            </unconditional-result>\n          </results>\n        </action>\n      </actions>\n    </step>\n    <step id=\"5\" name=\"Reopened\">\n      <meta name=\"jira.status.id\">4</meta>\n      <actions>\n<common-action id=\"5\" />\n<common-action id=\"2\" />\n<common-action id=\"4\" />\n      </actions>\n    </step>\n    <step id=\"6\" name=\"Closed\">\n      <meta name=\"jira.issue.editable\">false</meta>\n      <meta name=\"jira.status.id\">6</meta>\n      <actions>\n<common-action id=\"3\" />\n      </actions>\n    </step>\n  </steps>\n</workflow>\n', NULL);

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
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `count_done` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `count_done_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `report_project_issue`
--

INSERT INTO `report_project_issue` (`id`, `project_id`, `date`, `week`, `month`, `count_done`, `count_no_done`, `count_done_by_resolve`, `count_no_done_by_resolve`, `today_done_points`, `today_done_number`) VALUES
(63, 10500, '2018-08-02', 4, '08', 5, 195, 3, 197, 13, 9),
(64, 10500, '2018-08-01', 3, '08', 8, 192, 8, 192, 15, 8),
(65, 10500, '2018-07-31', 2, '07', 5, 195, 4, 196, 14, 10),
(66, 10500, '2018-07-30', 1, '07', 10, 190, 6, 194, 17, 5),
(67, 10500, '2018-07-29', 0, '07', 8, 192, 11, 189, 12, 6),
(68, 10500, '2018-07-28', 6, '07', 7, 193, 9, 191, 6, 7),
(69, 10500, '2018-07-27', 5, '07', 13, 187, 10, 190, 20, 7),
(70, 10500, '2018-07-26', 4, '07', 12, 188, 9, 191, 17, 8),
(71, 10500, '2018-07-25', 3, '07', 10, 190, 17, 183, 5, 6),
(72, 10500, '2018-07-24', 2, '07', 18, 182, 18, 182, 6, 8),
(73, 10500, '2018-07-23', 1, '07', 14, 186, 20, 180, 8, 9),
(74, 10500, '2018-07-22', 0, '07', 21, 179, 13, 187, 6, 7),
(75, 10500, '2018-07-21', 6, '07', 15, 185, 16, 184, 14, 7),
(76, 10500, '2018-07-20', 5, '07', 22, 178, 14, 186, 11, 8),
(77, 10500, '2018-07-19', 4, '07', 22, 178, 20, 180, 18, 8),
(78, 10500, '2018-07-18', 3, '07', 25, 175, 17, 183, 16, 7),
(79, 10500, '2018-07-17', 2, '07', 20, 180, 26, 174, 14, 5),
(80, 10500, '2018-07-16', 1, '07', 18, 182, 24, 176, 7, 5),
(81, 10500, '2018-07-15', 0, '07', 23, 177, 23, 177, 14, 10),
(82, 10500, '2018-07-14', 6, '07', 29, 171, 24, 176, 12, 7),
(83, 10500, '2018-07-13', 5, '07', 21, 179, 30, 170, 12, 5),
(84, 10500, '2018-07-12', 4, '07', 26, 174, 22, 178, 12, 7),
(85, 10500, '2018-07-11', 3, '07', 25, 175, 25, 175, 16, 9),
(86, 10500, '2018-07-10', 2, '07', 29, 171, 32, 168, 16, 8),
(87, 10500, '2018-07-09', 1, '07', 28, 172, 32, 168, 19, 9),
(88, 10500, '2018-07-08', 0, '07', 31, 169, 26, 174, 19, 8),
(89, 10500, '2018-07-07', 6, '07', 29, 171, 31, 169, 19, 10),
(90, 10500, '2018-07-06', 5, '07', 33, 167, 36, 164, 12, 9),
(91, 10500, '2018-07-05', 4, '07', 31, 169, 37, 163, 11, 6),
(92, 10500, '2018-07-04', 3, '07', 39, 161, 34, 166, 16, 8),
(93, 10500, '2018-07-03', 2, '07', 36, 164, 35, 165, 10, 6),
(94, 10500, '2018-07-02', 1, '07', 38, 162, 36, 164, 11, 10),
(95, 10500, '2018-07-01', 0, '07', 39, 161, 39, 161, 14, 8),
(96, 10500, '2018-06-30', 6, '06', 41, 159, 35, 165, 15, 8),
(97, 10500, '2018-06-29', 5, '06', 44, 156, 42, 158, 15, 9),
(98, 10500, '2018-06-28', 4, '06', 37, 163, 43, 157, 5, 8),
(99, 10500, '2018-06-27', 3, '06', 44, 156, 38, 162, 19, 7),
(100, 10500, '2018-06-26', 2, '06', 45, 155, 47, 153, 7, 10),
(101, 10500, '2018-06-25', 1, '06', 46, 154, 48, 152, 16, 6),
(102, 10500, '2018-06-24', 0, '06', 49, 151, 46, 154, 7, 7),
(103, 10500, '2018-06-23', 6, '06', 47, 153, 46, 154, 11, 7),
(104, 10500, '2018-06-22', 5, '06', 44, 156, 42, 158, 16, 6),
(105, 10500, '2018-06-21', 4, '06', 43, 157, 48, 152, 19, 8),
(106, 10500, '2018-06-20', 3, '06', 47, 153, 47, 153, 7, 10),
(107, 10500, '2018-06-19', 2, '06', 50, 150, 46, 154, 6, 5),
(108, 10500, '2018-06-18', 1, '06', 53, 147, 47, 153, 14, 6),
(109, 10500, '2018-06-17', 0, '06', 54, 146, 55, 145, 18, 6),
(110, 10500, '2018-06-16', 6, '06', 53, 147, 49, 151, 7, 9),
(111, 10500, '2018-06-15', 5, '06', 56, 144, 52, 148, 16, 7),
(112, 10500, '2018-06-14', 4, '06', 58, 142, 57, 143, 6, 5),
(113, 10500, '2018-06-13', 3, '06', 54, 146, 60, 140, 15, 6),
(114, 10500, '2018-06-12', 2, '06', 57, 143, 60, 140, 14, 6),
(115, 10500, '2018-06-11', 1, '06', 60, 140, 58, 142, 7, 9),
(116, 10500, '2018-06-10', 0, '06', 57, 143, 54, 146, 18, 7),
(117, 10500, '2018-06-09', 6, '06', 58, 142, 61, 139, 14, 5),
(118, 10500, '2018-06-08', 5, '06', 64, 136, 58, 142, 11, 8),
(119, 10500, '2018-06-07', 4, '06', 65, 135, 61, 139, 11, 7),
(120, 10500, '2018-06-06', 3, '06', 60, 140, 60, 140, 16, 9),
(121, 10500, '2018-06-05', 2, '06', 59, 141, 60, 140, 20, 8),
(122, 10500, '2018-06-04', 1, '06', 68, 132, 67, 133, 11, 7);

-- --------------------------------------------------------

--
-- 表的结构 `report_sprint_issue`
--

CREATE TABLE `report_sprint_issue` (
  `id` int(10) UNSIGNED NOT NULL,
  `sprint_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `week` tinyint(2) UNSIGNED DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `count_done` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数',
  `count_no_done` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,安装状态进行统计',
  `count_done_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总完成的事项总数,按照解决结果进行统计',
  `count_no_done_by_resolve` int(11) UNSIGNED DEFAULT '0' COMMENT '今天汇总未完成的事项总数,按照解决结果进行统计',
  `today_done_points` int(11) UNSIGNED DEFAULT '0' COMMENT '敏捷开发中的事项工作量或点数',
  `today_done_number` int(11) UNSIGNED DEFAULT '0' COMMENT '当天完成的事项数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `report_sprint_issue`
--

INSERT INTO `report_sprint_issue` (`id`, `sprint_id`, `date`, `week`, `month`, `count_done`, `count_no_done`, `count_done_by_resolve`, `count_no_done_by_resolve`, `today_done_points`, `today_done_number`) VALUES
(63, 3, '2018-08-02', 4, '08', 10, 90, 6, 94, 10, 5),
(64, 3, '2018-08-01', 3, '08', 2, 98, 10, 90, 15, 6),
(65, 3, '2018-07-31', 2, '07', 3, 97, 8, 92, 11, 10),
(66, 3, '2018-07-30', 1, '07', 6, 94, 12, 88, 5, 10),
(67, 3, '2018-07-29', 0, '07', 14, 86, 14, 86, 15, 5),
(68, 3, '2018-07-28', 6, '07', 15, 85, 12, 88, 14, 8),
(69, 3, '2018-07-27', 5, '07', 16, 84, 8, 92, 8, 6),
(70, 3, '2018-07-26', 4, '07', 15, 85, 11, 89, 6, 6),
(71, 3, '2018-07-25', 3, '07', 12, 88, 13, 87, 10, 10),
(72, 3, '2018-07-24', 2, '07', 11, 89, 16, 84, 18, 10),
(73, 3, '2018-07-23', 1, '07', 17, 83, 11, 89, 13, 9),
(74, 3, '2018-07-22', 0, '07', 13, 87, 16, 84, 17, 8),
(75, 3, '2018-07-21', 6, '07', 20, 80, 22, 78, 11, 6),
(76, 3, '2018-07-20', 5, '07', 22, 78, 22, 78, 15, 9),
(77, 3, '2018-07-19', 4, '07', 21, 79, 16, 84, 10, 5),
(78, 3, '2018-07-18', 3, '07', 21, 79, 19, 81, 10, 6),
(79, 3, '2018-07-17', 2, '07', 19, 81, 25, 75, 12, 7),
(80, 3, '2018-07-16', 1, '07', 18, 82, 21, 79, 9, 5),
(81, 3, '2018-07-15', 0, '07', 27, 73, 22, 78, 7, 10),
(82, 3, '2018-07-14', 6, '07', 28, 72, 24, 76, 18, 5),
(83, 3, '2018-07-13', 5, '07', 30, 70, 25, 75, 18, 9),
(84, 3, '2018-07-12', 4, '07', 24, 76, 27, 73, 6, 5),
(85, 3, '2018-07-11', 3, '07', 31, 69, 24, 76, 10, 9),
(86, 3, '2018-07-10', 2, '07', 27, 73, 24, 76, 10, 5),
(87, 3, '2018-07-09', 1, '07', 34, 66, 29, 71, 7, 6),
(88, 3, '2018-07-08', 0, '07', 32, 68, 26, 74, 8, 10),
(89, 3, '2018-07-07', 6, '07', 34, 66, 30, 70, 6, 10),
(90, 3, '2018-07-06', 5, '07', 36, 64, 28, 72, 18, 6),
(91, 3, '2018-07-05', 4, '07', 38, 62, 35, 65, 14, 5),
(92, 3, '2018-07-04', 3, '07', 32, 68, 36, 64, 8, 8),
(93, 3, '2018-07-03', 2, '07', 32, 68, 39, 61, 8, 5),
(94, 3, '2018-07-02', 1, '07', 32, 68, 41, 59, 7, 8),
(95, 3, '2018-07-01', 0, '07', 33, 67, 33, 67, 6, 5),
(96, 3, '2018-06-30', 6, '06', 35, 65, 34, 66, 6, 10),
(97, 3, '2018-06-29', 5, '06', 36, 64, 37, 63, 20, 8),
(98, 3, '2018-06-28', 4, '06', 42, 58, 41, 59, 16, 7),
(99, 3, '2018-06-27', 3, '06', 43, 57, 37, 63, 20, 7),
(100, 3, '2018-06-26', 2, '06', 45, 55, 47, 53, 16, 9),
(101, 3, '2018-06-25', 1, '06', 43, 57, 39, 61, 10, 8),
(102, 3, '2018-06-24', 0, '06', 41, 59, 40, 60, 11, 6),
(103, 3, '2018-06-23', 6, '06', 43, 57, 50, 50, 15, 7),
(104, 3, '2018-06-22', 5, '06', 46, 54, 50, 50, 8, 7),
(105, 3, '2018-06-21', 4, '06', 49, 51, 52, 48, 19, 7),
(106, 3, '2018-06-20', 3, '06', 48, 52, 49, 51, 20, 5),
(107, 3, '2018-06-19', 2, '06', 50, 50, 50, 50, 11, 9),
(108, 3, '2018-06-18', 1, '06', 52, 48, 52, 48, 12, 8),
(109, 3, '2018-06-17', 0, '06', 53, 47, 51, 49, 8, 6),
(110, 3, '2018-06-16', 6, '06', 55, 45, 49, 51, 6, 5),
(111, 3, '2018-06-15', 5, '06', 50, 50, 58, 42, 17, 10),
(112, 3, '2018-06-14', 4, '06', 50, 50, 55, 45, 16, 9),
(113, 3, '2018-06-13', 3, '06', 56, 44, 60, 40, 20, 7),
(114, 3, '2018-06-12', 2, '06', 59, 41, 52, 48, 20, 9),
(115, 3, '2018-06-11', 1, '06', 54, 46, 62, 38, 13, 8),
(116, 3, '2018-06-10', 0, '06', 60, 40, 56, 44, 15, 7),
(117, 3, '2018-06-09', 6, '06', 57, 43, 60, 40, 20, 5),
(118, 3, '2018-06-08', 5, '06', 56, 44, 65, 35, 11, 10),
(119, 3, '2018-06-07', 4, '06', 61, 39, 59, 41, 16, 7),
(120, 3, '2018-06-06', 3, '06', 67, 33, 67, 33, 6, 6),
(121, 3, '2018-06-05', 2, '06', 59, 41, 62, 38, 14, 6),
(122, 3, '2018-06-04', 1, '06', 60, 40, 63, 37, 5, 9);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `service_config`
--

INSERT INTO `service_config` (`id`, `delaytime`, `clazz`, `servicename`, `cron_expression`) VALUES
('10000', '60000', 'com.atlassian.jira.service.services.mail.MailQueueService', 'Mail Queue Service', '0 * * * * ?'),
('10001', '43200000', 'com.atlassian.jira.service.services.export.ExportService', 'Backup Service', '0 15 5/12 * * ?'),
('10002', '86400000', 'com.atlassian.jira.service.services.auditing.AuditLogCleaningService', 'Audit log cleaning service', '0 15 17 * * ?'),
('10801', '3600000', 'com.atlassian.jira.plugin.ext.subversion.revisions.scheduling.clustersafe.UpdateSvnIndexService', 'Subversion Index Update Service', NULL);

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

--
-- 转存表中的数据 `user_attributes`
--

INSERT INTO `user_attributes` (`id`, `user_id`, `directory_id`, `attribute_name`, `attribute_value`, `lower_attribute_value`) VALUES
('10000', '10000', '1', 'requiresPasswordChange', 'false', 'false'),
('10001', '10000', '1', 'passwordLastChanged', '1437646318556', '1437646318556'),
('10002', '10000', '1', 'password.reset.request.expiry', '1437732718743', '1437732718743'),
('10003', '10000', '1', 'password.reset.request.token', 'f297fa55571e90a2ab2b7e16aee1ee1b6ab3b363', 'f297fa55571e90a2ab2b7e16aee1ee1b6ab3b363'),
('10004', '10000', '1', 'invalidPasswordAttempts', '0', '0'),
('10005', '10000', '1', 'lastAuthenticated', '1505115080910', '1505115080910'),
('10006', '10000', '1', 'login.currentFailedCount', '0', '0'),
('10007', '10000', '1', 'login.lastLoginMillis', '1505115081005', '1505115081005'),
('10008', '10000', '1', 'login.count', '588', '588'),
('10009', '10000', '1', 'login.previousLoginMillis', '1505114873265', '1505114873265'),
('10100', '10100', '1', 'requiresPasswordChange', 'false', 'false'),
('10101', '10100', '1', 'passwordLastChanged', '1500458611225', '1500458611225'),
('10104', '10100', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10105', '10100', '1', 'invalidPasswordAttempts', '0', '0'),
('10106', '10100', '1', 'lastAuthenticated', '1504945309575', '1504945309575'),
('10107', '10100', '1', 'login.currentFailedCount', '0', '0'),
('10108', '10100', '1', 'login.lastLoginMillis', '1505096638770', '1505096638770'),
('10109', '10100', '1', 'login.count', '438', '438'),
('10110', '10100', '1', 'login.previousLoginMillis', '1504945309598', '1504945309598'),
('10111', '10101', '1', 'requiresPasswordChange', 'false', 'false'),
('10112', '10101', '1', 'passwordLastChanged', '1439437471215', '1439437471215'),
('10113', '10101', '1', 'password.reset.request.expiry', '1439523871326', '1439523871326'),
('10114', '10101', '1', 'password.reset.request.token', '0ded63fc3e2d2a91377cc46dbae529b763464f37', '0ded63fc3e2d2a91377cc46dbae529b763464f37'),
('10115', '10101', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10116', '10102', '1', 'requiresPasswordChange', 'false', 'false'),
('10117', '10102', '1', 'passwordLastChanged', '1452761876532', '1452761876532'),
('10120', '10102', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10121', '10101', '1', 'invalidPasswordAttempts', '0', '0'),
('10122', '10101', '1', 'lastAuthenticated', '1503627686157', '1503627686157'),
('10123', '10101', '1', 'login.currentFailedCount', '0', '0'),
('10124', '10101', '1', 'login.lastLoginMillis', '1504609479785', '1504609479785'),
('10125', '10101', '1', 'login.count', '139', '139'),
('10126', '10101', '1', 'login.previousLoginMillis', '1504603487472', '1504603487472'),
('10132', '10104', '1', 'requiresPasswordChange', 'false', 'false'),
('10133', '10104', '1', 'passwordLastChanged', '1477735257276', '1477735257276'),
('10136', '10104', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10137', '10104', '1', 'login.currentFailedCount', '0', '0'),
('10138', '10104', '1', 'invalidPasswordAttempts', '0', '0'),
('10139', '10104', '1', 'lastAuthenticated', '1504769175104', '1504769175104'),
('10140', '10104', '1', 'login.lastLoginMillis', '1504781024863', '1504781024863'),
('10141', '10104', '1', 'login.count', '432', '432'),
('10142', '10104', '1', 'login.previousLoginMillis', '1504769175122', '1504769175122'),
('10143', '10100', '1', 'login.lastFailedLoginMillis', '1501756162961', '1501756162961'),
('10144', '10100', '1', 'login.totalFailedCount', '5', '5'),
('10151', '10102', '1', 'invalidPasswordAttempts', '0', '0'),
('10152', '10102', '1', 'lastAuthenticated', '1455898672569', '1455898672569'),
('10153', '10102', '1', 'login.currentFailedCount', '0', '0'),
('10154', '10102', '1', 'login.lastLoginMillis', '1455898672585', '1455898672585'),
('10155', '10102', '1', 'login.count', '14', '14'),
('10156', '10102', '1', 'login.previousLoginMillis', '1453341209703', '1453341209703'),
('10167', '10106', '1', 'requiresPasswordChange', 'false', 'false'),
('10168', '10106', '1', 'passwordLastChanged', '1447036769476', '1447036769476'),
('10171', '10106', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10172', '10106', '1', 'login.currentFailedCount', '0', '0'),
('10173', '10106', '1', 'invalidPasswordAttempts', '0', '0'),
('10174', '10106', '1', 'lastAuthenticated', '1452653170852', '1452653170852'),
('10175', '10106', '1', 'login.lastLoginMillis', '1452653170872', '1452653170872'),
('10176', '10106', '1', 'login.count', '20', '20'),
('10177', '10106', '1', 'login.previousLoginMillis', '1447208499276', '1447208499276'),
('10178', '10107', '1', 'requiresPasswordChange', 'false', 'false'),
('10179', '10107', '1', 'passwordLastChanged', '1442222458778', '1442222458778'),
('10182', '10107', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10183', '10107', '1', 'invalidPasswordAttempts', '0', '0'),
('10184', '10107', '1', 'login.lastFailedLoginMillis', '1453252528054', '1453252528054'),
('10185', '10107', '1', 'login.currentFailedCount', '0', '0'),
('10186', '10107', '1', 'login.totalFailedCount', '3', '3'),
('10187', '10107', '1', 'lastAuthenticated', '1471423282203', '1471423282203'),
('10188', '10107', '1', 'login.lastLoginMillis', '1471423282221', '1471423282221'),
('10189', '10107', '1', 'login.count', '63', '63'),
('10190', '10107', '1', 'login.previousLoginMillis', '1470813321822', '1470813321822'),
('10191', '10108', '1', 'requiresPasswordChange', 'false', 'false'),
('10192', '10108', '1', 'passwordLastChanged', '1445825768597', '1445825768597'),
('10193', '10108', '1', 'password.reset.request.expiry', '1445912168713', '1445912168713'),
('10194', '10108', '1', 'password.reset.request.token', 'ee02d496831e1c6215e9b02377f776e8f5605362', 'ee02d496831e1c6215e9b02377f776e8f5605362'),
('10195', '10108', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10196', '10109', '1', 'requiresPasswordChange', 'false', 'false'),
('10197', '10109', '1', 'passwordLastChanged', '1453359992542', '1453359992542'),
('10200', '10109', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10201', '10109', '1', 'invalidPasswordAttempts', '0', '0'),
('10202', '10109', '1', 'lastAuthenticated', '1453774500080', '1453774500080'),
('10203', '10109', '1', 'login.currentFailedCount', '0', '0'),
('10204', '10109', '1', 'login.lastLoginMillis', '1453774500094', '1453774500094'),
('10205', '10109', '1', 'login.count', '10', '10'),
('10206', '10104', '1', 'login.lastFailedLoginMillis', '1502950608249', '1502950608249'),
('10207', '10104', '1', 'login.totalFailedCount', '16', '16'),
('10213', '10108', '1', 'invalidPasswordAttempts', '0', '0'),
('10214', '10108', '1', 'lastAuthenticated', '1495504563572', '1495504563572'),
('10215', '10108', '1', 'login.currentFailedCount', '0', '0'),
('10216', '10108', '1', 'login.lastLoginMillis', '1495504563614', '1495504563614'),
('10217', '10108', '1', 'login.count', '570', '570'),
('10224', '10109', '1', 'login.previousLoginMillis', '1453359994396', '1453359994396'),
('10225', '10108', '1', 'login.previousLoginMillis', '1495439354082', '1495439354082'),
('10226', '10000', '1', 'login.lastFailedLoginMillis', '1496484188939', '1496484188939'),
('10227', '10000', '1', 'login.totalFailedCount', '34', '34'),
('10228', '10111', '1', 'requiresPasswordChange', 'false', 'false'),
('10229', '10111', '1', 'passwordLastChanged', '1446777773089', '1446777773089'),
('10230', '10111', '1', 'password.reset.request.expiry', '1446864173242', '1446864173242'),
('10231', '10111', '1', 'password.reset.request.token', 'a6bf49d587f77124e52655567a369a66798b9b5a', 'a6bf49d587f77124e52655567a369a66798b9b5a'),
('10232', '10111', '1', 'invalidPasswordAttempts', '0', '0'),
('10233', '10111', '1', 'lastAuthenticated', '1505097129707', '1505097129707'),
('10234', '10112', '1', 'requiresPasswordChange', 'false', 'false'),
('10235', '10112', '1', 'passwordLastChanged', '1446777846710', '1446777846710'),
('10236', '10112', '1', 'password.reset.request.expiry', '1446864246744', '1446864246744'),
('10237', '10112', '1', 'password.reset.request.token', '061f87811ee9a80d1081a4b2ad40c2cf9540f7c7', '061f87811ee9a80d1081a4b2ad40c2cf9540f7c7'),
('10238', '10112', '1', 'invalidPasswordAttempts', '0', '0'),
('10239', '10112', '1', 'lastAuthenticated', '1476175939877', '1476175939877'),
('10240', '10113', '1', 'requiresPasswordChange', 'false', 'false'),
('10241', '10113', '1', 'passwordLastChanged', '1482291981562', '1482291981562'),
('10244', '10113', '1', 'invalidPasswordAttempts', '0', '0'),
('10245', '10113', '1', 'lastAuthenticated', '1505099227715', '1505099227715'),
('10246', '10114', '1', 'requiresPasswordChange', 'false', 'false'),
('10247', '10114', '1', 'passwordLastChanged', '1450400968764', '1450400968764'),
('10250', '10114', '1', 'invalidPasswordAttempts', '0', '0'),
('10251', '10114', '1', 'lastAuthenticated', '1504833726843', '1504833726843'),
('10252', '10115', '1', 'requiresPasswordChange', 'false', 'false'),
('10253', '10115', '1', 'passwordLastChanged', '1446777986699', '1446777986699'),
('10254', '10115', '1', 'password.reset.request.expiry', '1446864386731', '1446864386731'),
('10255', '10115', '1', 'password.reset.request.token', 'bb9c212572aac0d4936de8b123e6a1bf79519b54', 'bb9c212572aac0d4936de8b123e6a1bf79519b54'),
('10256', '10115', '1', 'invalidPasswordAttempts', '0', '0'),
('10257', '10115', '1', 'lastAuthenticated', '1501147218116', '1501147218116'),
('10258', '10101', '1', 'login.lastFailedLoginMillis', '1496630476036', '1496630476036'),
('10259', '10101', '1', 'login.totalFailedCount', '11', '11'),
('10260', '10114', '1', 'login.lastFailedLoginMillis', '1478654742045', '1478654742045'),
('10261', '10114', '1', 'login.currentFailedCount', '0', '0'),
('10262', '10114', '1', 'login.totalFailedCount', '13', '13'),
('10263', '10114', '1', 'login.lastLoginMillis', '1505099501669', '1505099501669'),
('10264', '10114', '1', 'login.count', '237', '237'),
('10265', '10106', '1', 'login.lastFailedLoginMillis', '1451444002144', '1451444002144'),
('10266', '10106', '1', 'login.totalFailedCount', '4', '4'),
('10267', '10113', '1', 'login.currentFailedCount', '0', '0'),
('10268', '10113', '1', 'login.lastLoginMillis', '1505099227729', '1505099227729'),
('10269', '10113', '1', 'login.count', '126', '126'),
('10270', '10113', '1', 'login.previousLoginMillis', '1504941289806', '1504941289806'),
('10271', '10113', '1', 'login.lastFailedLoginMillis', '1491013208827', '1491013208827'),
('10272', '10113', '1', 'login.totalFailedCount', '16', '16'),
('10273', '10115', '1', 'login.currentFailedCount', '0', '0'),
('10274', '10115', '1', 'login.lastLoginMillis', '1501147218131', '1501147218131'),
('10275', '10115', '1', 'login.count', '531', '531'),
('10276', '10111', '1', 'login.currentFailedCount', '0', '0'),
('10277', '10111', '1', 'login.lastLoginMillis', '1505097129736', '1505097129736'),
('10278', '10111', '1', 'login.count', '268', '268'),
('10279', '10116', '1', 'requiresPasswordChange', 'false', 'false'),
('10280', '10116', '1', 'passwordLastChanged', '1481188426498', '1481188426498'),
('10283', '10116', '1', 'invalidPasswordAttempts', '0', '0'),
('10284', '10116', '1', 'lastAuthenticated', '1489990466746', '1489990466746'),
('10285', '10114', '1', 'login.previousLoginMillis', '1504833726865', '1504833726865'),
('10286', '10115', '1', 'login.previousLoginMillis', '1500288289621', '1500288289621'),
('10287', '10112', '1', 'login.currentFailedCount', '0', '0'),
('10288', '10112', '1', 'login.lastLoginMillis', '1476408173804', '1476408173804'),
('10289', '10112', '1', 'login.count', '312', '312'),
('10290', '10111', '1', 'login.previousLoginMillis', '1504952068224', '1504952068224'),
('10291', '10112', '1', 'login.previousLoginMillis', '1476236894429', '1476236894429'),
('10294', '10116', '1', 'login.lastFailedLoginMillis', '1479804929712', '1479804929712'),
('10295', '10116', '1', 'login.currentFailedCount', '0', '0'),
('10296', '10116', '1', 'login.totalFailedCount', '11', '11'),
('10297', '10116', '1', 'login.lastLoginMillis', '1489990466779', '1489990466779'),
('10298', '10116', '1', 'login.count', '322', '322'),
('10299', '10116', '1', 'login.previousLoginMillis', '1489747237623', '1489747237623'),
('10300', '10117', '1', 'requiresPasswordChange', 'false', 'false'),
('10301', '10117', '1', 'passwordLastChanged', '1452653603039', '1452653603039'),
('10304', '10117', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10305', '10117', '1', 'login.currentFailedCount', '0', '0'),
('10306', '10117', '1', 'invalidPasswordAttempts', '0', '0'),
('10307', '10117', '1', 'lastAuthenticated', '1461046757199', '1461046757199'),
('10308', '10117', '1', 'login.lastLoginMillis', '1461046757216', '1461046757216'),
('10309', '10117', '1', 'login.count', '41', '41'),
('10310', '10108', '1', 'login.lastFailedLoginMillis', '1490684333311', '1490684333311'),
('10311', '10108', '1', 'login.totalFailedCount', '10', '10'),
('10312', '10117', '1', 'login.previousLoginMillis', '1460514318314', '1460514318314'),
('10313', '10102', '1', 'login.lastFailedLoginMillis', '1453105953278', '1453105953278'),
('10314', '10102', '1', 'login.totalFailedCount', '1', '1'),
('10400', '10107', '1', 'password.reset.request.expiry', '1453338944954', '1453338944954'),
('10401', '10107', '1', 'password.reset.request.token', 'a056ec45ef27da7c41a79546e24ad703c420bdc5', 'a056ec45ef27da7c41a79546e24ad703c420bdc5'),
('10402', '10114', '1', 'password.reset.request.expiry', '1453427804113', '1453427804113'),
('10403', '10114', '1', 'password.reset.request.token', 'd8816817b91e9c4c2a6128f46830ef9d545e07b4', 'd8816817b91e9c4c2a6128f46830ef9d545e07b4'),
('10404', '10109', '1', 'login.lastFailedLoginMillis', '1453359953298', '1453359953298'),
('10405', '10109', '1', 'login.totalFailedCount', '3', '3'),
('10417', '10117', '1', 'password.reset.request.expiry', '1455689641434', '1455689641434'),
('10418', '10117', '1', 'password.reset.request.token', '8960b1a47af42c761fa4e74109c98d49ecf3f6d3', '8960b1a47af42c761fa4e74109c98d49ecf3f6d3'),
('10419', '10201', '1', 'requiresPasswordChange', 'false', 'false'),
('10420', '10201', '1', 'passwordLastChanged', '1456977025666', '1456977025666'),
('10421', '10201', '1', 'password.reset.request.expiry', '1457063425767', '1457063425767'),
('10422', '10201', '1', 'password.reset.request.token', '53bc17c728a962ac537f63f8c142170f48a781b7', '53bc17c728a962ac537f63f8c142170f48a781b7'),
('10423', '10201', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10424', '10201', '1', 'invalidPasswordAttempts', '0', '0'),
('10425', '10201', '1', 'lastAuthenticated', '1505100319046', '1505100319046'),
('10426', '10201', '1', 'login.currentFailedCount', '0', '0'),
('10427', '10201', '1', 'login.lastLoginMillis', '1505100319069', '1505100319069'),
('10428', '10201', '1', 'login.count', '163', '163'),
('10429', '10201', '1', 'login.previousLoginMillis', '1504836387033', '1504836387033'),
('10430', '10202', '1', 'requiresPasswordChange', 'false', 'false'),
('10431', '10202', '1', 'passwordLastChanged', '1457058193345', '1457058193345'),
('10432', '10202', '1', 'password.reset.request.expiry', '1457144593436', '1457144593436'),
('10433', '10202', '1', 'password.reset.request.token', 'b03878ca08ce961166908f4d98306c7bf8341b7b', 'b03878ca08ce961166908f4d98306c7bf8341b7b'),
('10434', '10202', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10435', '10202', '1', 'invalidPasswordAttempts', '0', '0'),
('10436', '10202', '1', 'lastAuthenticated', '1477446874434', '1477446874434'),
('10437', '10202', '1', 'login.currentFailedCount', '0', '0'),
('10438', '10202', '1', 'login.lastLoginMillis', '1477446874455', '1477446874455'),
('10439', '10202', '1', 'login.count', '249', '249'),
('10440', '10203', '1', 'requiresPasswordChange', 'false', 'false'),
('10441', '10203', '1', 'passwordLastChanged', '1457058420911', '1457058420911'),
('10442', '10203', '1', 'password.reset.request.expiry', '1457144820934', '1457144820934'),
('10443', '10203', '1', 'password.reset.request.token', 'cc6cb2bcfebe4a8c9f4d9d77ed9fdc7abb997885', 'cc6cb2bcfebe4a8c9f4d9d77ed9fdc7abb997885'),
('10444', '10203', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10445', '10203', '1', 'invalidPasswordAttempts', '0', '0'),
('10446', '10203', '1', 'lastAuthenticated', '1461922391016', '1461922391016'),
('10447', '10203', '1', 'login.currentFailedCount', '0', '0'),
('10448', '10203', '1', 'login.lastLoginMillis', '1462518933409', '1462518933409'),
('10449', '10203', '1', 'login.count', '52', '52'),
('10450', '10202', '1', 'login.previousLoginMillis', '1477359785263', '1477359785263'),
('10451', '10203', '1', 'login.previousLoginMillis', '1462327574067', '1462327574067'),
('10452', '10203', '1', 'login.lastFailedLoginMillis', '1459820777790', '1459820777790'),
('10453', '10203', '1', 'login.totalFailedCount', '5', '5'),
('10454', '10204', '1', 'requiresPasswordChange', 'false', 'false'),
('10455', '10204', '1', 'passwordLastChanged', '1464072021023', '1464072021023'),
('10458', '10204', '1', 'invalidPasswordAttempts', '0', '0'),
('10459', '10204', '1', 'lastAuthenticated', '1486521646950', '1486521646950'),
('10460', '10205', '1', 'requiresPasswordChange', 'false', 'false'),
('10461', '10205', '1', 'passwordLastChanged', '1460535639003', '1460535639003'),
('10464', '10205', '1', 'invalidPasswordAttempts', '0', '0'),
('10465', '10205', '1', 'lastAuthenticated', '1464336686496', '1464336686496'),
('10466', '10205', '1', 'login.currentFailedCount', '0', '0'),
('10467', '10205', '1', 'login.lastLoginMillis', '1464336686517', '1464336686517'),
('10468', '10205', '1', 'login.count', '29', '29'),
('10469', '10204', '1', 'login.currentFailedCount', '0', '0'),
('10470', '10204', '1', 'login.lastLoginMillis', '1486521646995', '1486521646995'),
('10471', '10204', '1', 'login.count', '28', '28'),
('10472', '10206', '1', 'requiresPasswordChange', 'false', 'false'),
('10473', '10206', '1', 'passwordLastChanged', '1459849908673', '1459849908673'),
('10476', '10206', '1', 'invalidPasswordAttempts', '0', '0'),
('10477', '10206', '1', 'lastAuthenticated', '1504929354943', '1504929354943'),
('10478', '10206', '1', 'login.currentFailedCount', '0', '0'),
('10479', '10206', '1', 'login.lastLoginMillis', '1504929354948', '1504929354948'),
('10480', '10206', '1', 'login.count', '132', '132'),
('10481', '10205', '1', 'login.previousLoginMillis', '1463535770482', '1463535770482'),
('10482', '10206', '1', 'login.previousLoginMillis', '1504865340471', '1504865340471'),
('10483', '10204', '1', 'login.previousLoginMillis', '1484018329290', '1484018329290'),
('10486', '10206', '1', 'login.lastFailedLoginMillis', '1479460158026', '1479460158026'),
('10487', '10206', '1', 'login.totalFailedCount', '5', '5'),
('10488', '10207', '1', 'requiresPasswordChange', 'false', 'false'),
('10489', '10207', '1', 'passwordLastChanged', '1459903971887', '1459903971887'),
('10492', '10207', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10493', '10207', '1', 'invalidPasswordAttempts', '0', '0'),
('10494', '10207', '1', 'lastAuthenticated', '1468551258088', '1468551258088'),
('10495', '10207', '1', 'login.currentFailedCount', '0', '0'),
('10496', '10207', '1', 'login.lastLoginMillis', '1468551258108', '1468551258108'),
('10497', '10207', '1', 'login.count', '49', '49'),
('10498', '10207', '1', 'login.previousLoginMillis', '1467270249533', '1467270249533'),
('10504', '10209', '1', 'requiresPasswordChange', 'false', 'false'),
('10505', '10209', '1', 'passwordLastChanged', '1460082804398', '1460082804398'),
('10506', '10209', '1', 'password.reset.request.expiry', '1460169204578', '1460169204578'),
('10507', '10209', '1', 'password.reset.request.token', '6214652cd0e60f5852e7560b7a0f40a459652b3b', '6214652cd0e60f5852e7560b7a0f40a459652b3b'),
('10508', '10209', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10509', '10209', '1', 'invalidPasswordAttempts', '0', '0'),
('10510', '10209', '1', 'lastAuthenticated', '1500434220248', '1500434220248'),
('10511', '10209', '1', 'login.currentFailedCount', '0', '0'),
('10512', '10209', '1', 'login.lastLoginMillis', '1500434220321', '1500434220321'),
('10513', '10209', '1', 'login.count', '59', '59'),
('10514', '10209', '1', 'login.previousLoginMillis', '1500427827146', '1500427827146'),
('10515', '10205', '1', 'login.lastFailedLoginMillis', '1463463877944', '1463463877944'),
('10516', '10205', '1', 'login.totalFailedCount', '11', '11'),
('10517', '10207', '1', 'login.lastFailedLoginMillis', '1462326603202', '1462326603202'),
('10518', '10207', '1', 'login.totalFailedCount', '1', '1'),
('10519', '10210', '1', 'requiresPasswordChange', 'false', 'false'),
('10520', '10210', '1', 'passwordLastChanged', '1463451579846', '1463451579846'),
('10521', '10210', '1', 'password.reset.request.expiry', '1463537980157', '1463537980157'),
('10522', '10210', '1', 'password.reset.request.token', 'eaee4de5f08b2ab8feb6ea4fd85a02a5a2445b5d', 'eaee4de5f08b2ab8feb6ea4fd85a02a5a2445b5d'),
('10523', '10210', '1', 'invalidPasswordAttempts', '0', '0'),
('10524', '10210', '1', 'lastAuthenticated', '1505095824385', '1505095824385'),
('10525', '10210', '1', 'login.currentFailedCount', '0', '0'),
('10526', '10210', '1', 'login.lastLoginMillis', '1505095824409', '1505095824409'),
('10527', '10210', '1', 'login.count', '238', '238'),
('10528', '10210', '1', 'login.previousLoginMillis', '1504921084160', '1504921084160'),
('10529', '10211', '1', 'requiresPasswordChange', 'false', 'false'),
('10530', '10211', '1', 'passwordLastChanged', '1498123609925', '1498123609925'),
('10533', '10211', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10534', '10211', '1', 'login.currentFailedCount', '0', '0'),
('10535', '10211', '1', 'invalidPasswordAttempts', '0', '0'),
('10536', '10211', '1', 'lastAuthenticated', '1504596943120', '1504596943120'),
('10537', '10211', '1', 'login.lastLoginMillis', '1504766621172', '1504766621172'),
('10538', '10211', '1', 'login.count', '305', '305'),
('10539', '10211', '1', 'login.previousLoginMillis', '1504751661834', '1504751661834'),
('10540', '10211', '1', 'login.lastFailedLoginMillis', '1495780886532', '1495780886532'),
('10541', '10211', '1', 'login.totalFailedCount', '13', '13'),
('10542', '10204', '1', 'login.lastFailedLoginMillis', '1483082470825', '1483082470825'),
('10543', '10204', '1', 'login.totalFailedCount', '2', '2'),
('10544', '10212', '1', 'requiresPasswordChange', 'false', 'false'),
('10545', '10212', '1', 'passwordLastChanged', '1480470581484', '1480470581484'),
('10548', '10212', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10549', '10213', '1', 'requiresPasswordChange', 'false', 'false'),
('10550', '10213', '1', 'passwordLastChanged', '1499322968215', '1499322968215'),
('10553', '10213', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10554', '10212', '1', 'login.currentFailedCount', '0', '0'),
('10555', '10212', '1', 'invalidPasswordAttempts', '0', '0'),
('10556', '10212', '1', 'lastAuthenticated', '1505099313767', '1505099313767'),
('10557', '10212', '1', 'login.lastLoginMillis', '1505099313792', '1505099313792'),
('10558', '10212', '1', 'login.count', '144', '144'),
('10559', '10214', '1', 'requiresPasswordChange', 'false', 'false'),
('10560', '10214', '1', 'passwordLastChanged', '1467620976355', '1467620976355'),
('10563', '10214', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10564', '10213', '1', 'login.currentFailedCount', '3', '3'),
('10565', '10213', '1', 'invalidPasswordAttempts', '0', '0'),
('10566', '10213', '1', 'lastAuthenticated', '1499322983754', '1499322983754'),
('10567', '10213', '1', 'login.lastLoginMillis', '1499322983797', '1499322983797'),
('10568', '10213', '1', 'login.count', '124', '124'),
('10569', '10212', '1', 'login.previousLoginMillis', '1504752129840', '1504752129840'),
('10570', '10202', '1', 'login.lastFailedLoginMillis', '1476409382306', '1476409382306'),
('10571', '10202', '1', 'login.totalFailedCount', '20', '20'),
('10572', '10215', '1', 'requiresPasswordChange', 'false', 'false'),
('10573', '10215', '1', 'passwordLastChanged', '1466560393146', '1466560393146'),
('10574', '10215', '1', 'password.reset.request.expiry', '1466646793482', '1466646793482'),
('10575', '10215', '1', 'password.reset.request.token', 'e32d023a969d78c6156afccad6749698d0061d31', 'e32d023a969d78c6156afccad6749698d0061d31'),
('10576', '10215', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10577', '10215', '1', 'invalidPasswordAttempts', '0', '0'),
('10578', '10215', '1', 'lastAuthenticated', '1469672363151', '1469672363151'),
('10579', '10215', '1', 'login.currentFailedCount', '0', '0'),
('10580', '10215', '1', 'login.lastLoginMillis', '1469672363210', '1469672363210'),
('10581', '10215', '1', 'login.count', '8', '8'),
('10582', '10215', '1', 'login.previousLoginMillis', '1467254467144', '1467254467144'),
('10583', '10213', '1', 'login.previousLoginMillis', '1499239107709', '1499239107709'),
('10584', '10216', '1', 'requiresPasswordChange', 'false', 'false'),
('10585', '10216', '1', 'passwordLastChanged', '1476237303408', '1476237303408'),
('10588', '10216', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10589', '10216', '1', 'invalidPasswordAttempts', '0', '0'),
('10590', '10216', '1', 'lastAuthenticated', '1504922933409', '1504922933409'),
('10591', '10216', '1', 'login.currentFailedCount', '0', '0'),
('10592', '10216', '1', 'login.lastLoginMillis', '1504922933449', '1504922933449'),
('10593', '10216', '1', 'login.count', '145', '145'),
('10594', '10217', '1', 'requiresPasswordChange', 'false', 'false'),
('10595', '10217', '1', 'passwordLastChanged', '1467167652496', '1467167652496'),
('10598', '10217', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10599', '10217', '1', 'login.currentFailedCount', '0', '0'),
('10600', '10217', '1', 'invalidPasswordAttempts', '0', '0'),
('10601', '10217', '1', 'lastAuthenticated', '1467890067972', '1467890067972'),
('10602', '10217', '1', 'login.lastLoginMillis', '1467890067991', '1467890067991'),
('10603', '10217', '1', 'login.count', '5', '5'),
('10604', '10216', '1', 'login.previousLoginMillis', '1504835459875', '1504835459875'),
('10605', '10214', '1', 'invalidPasswordAttempts', '0', '0'),
('10606', '10214', '1', 'lastAuthenticated', '1503906859745', '1503906859745'),
('10607', '10214', '1', 'login.currentFailedCount', '0', '0'),
('10608', '10214', '1', 'login.lastLoginMillis', '1503906859780', '1503906859780'),
('10609', '10214', '1', 'login.count', '132', '132'),
('10610', '10214', '1', 'login.previousLoginMillis', '1503627092402', '1503627092402'),
('10611', '10218', '1', 'requiresPasswordChange', 'false', 'false'),
('10612', '10218', '1', 'passwordLastChanged', '1476152735742', '1476152735742'),
('10615', '10218', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10616', '10217', '1', 'login.previousLoginMillis', '1467335616649', '1467335616649'),
('10617', '10217', '1', 'login.lastFailedLoginMillis', '1467335477493', '1467335477493'),
('10618', '10217', '1', 'login.totalFailedCount', '2', '2'),
('10619', '10218', '1', 'login.currentFailedCount', '0', '0'),
('10620', '10218', '1', 'invalidPasswordAttempts', '0', '0'),
('10621', '10218', '1', 'lastAuthenticated', '1504836640869', '1504836640869'),
('10622', '10218', '1', 'login.lastLoginMillis', '1504836640886', '1504836640886'),
('10623', '10218', '1', 'login.count', '100', '100'),
('10624', '10212', '1', 'login.lastFailedLoginMillis', '1494554443925', '1494554443925'),
('10625', '10212', '1', 'login.totalFailedCount', '6', '6'),
('10630', '10214', '1', 'login.lastFailedLoginMillis', '1473044561303', '1473044561303'),
('10631', '10214', '1', 'login.totalFailedCount', '6', '6'),
('10632', '10201', '1', 'login.lastFailedLoginMillis', '1495619348152', '1495619348152'),
('10633', '10201', '1', 'login.totalFailedCount', '2', '2'),
('10634', '10219', '1', 'requiresPasswordChange', 'false', 'false'),
('10635', '10219', '1', 'passwordLastChanged', '1471486990913', '1471486990913'),
('10636', '10219', '1', 'password.reset.request.expiry', '1471573391375', '1471573391375'),
('10637', '10219', '1', 'password.reset.request.token', '841a45c6cde7e6af4caf86583fa5c6d65ae9b90a', '841a45c6cde7e6af4caf86583fa5c6d65ae9b90a'),
('10638', '10219', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10639', '10219', '1', 'invalidPasswordAttempts', '4', '4'),
('10640', '10219', '1', 'lastAuthenticated', '1474161368973', '1474161368973'),
('10641', '10219', '1', 'login.currentFailedCount', '285', '285'),
('10642', '10219', '1', 'login.lastLoginMillis', '1474161368990', '1474161368990'),
('10643', '10219', '1', 'login.count', '19', '19'),
('10644', '10219', '1', 'login.previousLoginMillis', '1473215347594', '1473215347594'),
('10645', '10220', '1', 'requiresPasswordChange', 'false', 'false'),
('10646', '10220', '1', 'passwordLastChanged', '1472018414081', '1472018414081'),
('10647', '10220', '1', 'password.reset.request.expiry', '1472104814113', '1472104814113'),
('10648', '10220', '1', 'password.reset.request.token', 'ef59e8673257571141ffa6a60e605eec8da6115f', 'ef59e8673257571141ffa6a60e605eec8da6115f'),
('10649', '10220', '1', 'invalidPasswordAttempts', '0', '0'),
('10650', '10220', '1', 'lastAuthenticated', '1504838472395', '1504838472395'),
('10651', '10219', '1', 'login.lastFailedLoginMillis', '1484897899852', '1484897899852'),
('10652', '10219', '1', 'login.totalFailedCount', '288', '288'),
('10653', '10213', '1', 'login.lastFailedLoginMillis', '1499391882543', '1499391882543'),
('10654', '10213', '1', 'login.totalFailedCount', '6', '6'),
('10655', '10220', '1', 'login.currentFailedCount', '0', '0'),
('10656', '10220', '1', 'login.lastLoginMillis', '1504838472411', '1504838472411'),
('10657', '10220', '1', 'login.count', '130', '130'),
('10658', '10220', '1', 'login.previousLoginMillis', '1504776168757', '1504776168757'),
('10659', '10210', '1', 'login.lastFailedLoginMillis', '1501835156251', '1501835156251'),
('10660', '10210', '1', 'login.totalFailedCount', '29', '29'),
('10661', '10218', '1', 'login.previousLoginMillis', '1504058430201', '1504058430201'),
('10700', '10218', '1', 'login.lastFailedLoginMillis', '1478572848617', '1478572848617'),
('10701', '10218', '1', 'login.totalFailedCount', '8', '8'),
('10702', '10220', '1', 'login.lastFailedLoginMillis', '1504661813475', '1504661813475'),
('10703', '10220', '1', 'login.totalFailedCount', '7', '7'),
('10704', '10300', '1', 'requiresPasswordChange', 'false', 'false'),
('10705', '10300', '1', 'passwordLastChanged', '1476259594466', '1476259594466'),
('10706', '10300', '1', 'password.reset.request.expiry', '1476345994780', '1476345994780'),
('10707', '10300', '1', 'password.reset.request.token', '72afe824b95f5fc6a90570108db1cbafc86d2415', '72afe824b95f5fc6a90570108db1cbafc86d2415'),
('10708', '10300', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10709', '10300', '1', 'invalidPasswordAttempts', '0', '0'),
('10710', '10300', '1', 'lastAuthenticated', '1476322686084', '1476322686084'),
('10711', '10300', '1', 'login.currentFailedCount', '0', '0'),
('10712', '10300', '1', 'login.lastLoginMillis', '1476322686100', '1476322686100'),
('10713', '10300', '1', 'login.count', '2', '2'),
('10714', '10300', '1', 'login.previousLoginMillis', '1476267484447', '1476267484447'),
('10717', '10301', '1', 'requiresPasswordChange', 'false', 'false'),
('10718', '10301', '1', 'passwordLastChanged', '1490598425943', '1490598425943'),
('10721', '10301', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10722', '10301', '1', 'login.currentFailedCount', '0', '0'),
('10723', '10301', '1', 'invalidPasswordAttempts', '0', '0'),
('10724', '10301', '1', 'lastAuthenticated', '1505098856954', '1505098856954'),
('10725', '10301', '1', 'login.lastLoginMillis', '1505098856973', '1505098856973'),
('10726', '10301', '1', 'login.count', '115', '115'),
('10727', '10301', '1', 'login.lastFailedLoginMillis', '1500606627253', '1500606627253'),
('10728', '10301', '1', 'login.totalFailedCount', '21', '21'),
('10729', '10301', '1', 'login.previousLoginMillis', '1504835556373', '1504835556373'),
('10730', '10302', '1', 'requiresPasswordChange', 'false', 'false'),
('10731', '10302', '1', 'passwordLastChanged', '1500345660906', '1500345660906'),
('10734', '10302', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10735', '10302', '1', 'invalidPasswordAttempts', '0', '0'),
('10736', '10302', '1', 'lastAuthenticated', '1504854315202', '1504854315202'),
('10737', '10302', '1', 'login.currentFailedCount', '0', '0'),
('10738', '10302', '1', 'login.lastLoginMillis', '1505097573618', '1505097573618'),
('10739', '10302', '1', 'login.count', '55', '55'),
('10740', '10302', '1', 'login.previousLoginMillis', '1505093207814', '1505093207814'),
('10741', '10303', '1', 'requiresPasswordChange', 'false', 'false'),
('10742', '10303', '1', 'passwordLastChanged', '1479461580094', '1479461580094'),
('10743', '10303', '1', 'password.reset.request.expiry', '1479547980124', '1479547980124'),
('10744', '10303', '1', 'password.reset.request.token', '0b74ef2c7a0e1ebfc7addf9fe4a8636d563ec5a1', '0b74ef2c7a0e1ebfc7addf9fe4a8636d563ec5a1'),
('10745', '10303', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10746', '10303', '1', 'invalidPasswordAttempts', '0', '0'),
('10747', '10303', '1', 'lastAuthenticated', '1504832724597', '1504832724597'),
('10748', '10303', '1', 'login.currentFailedCount', '0', '0'),
('10749', '10303', '1', 'login.lastLoginMillis', '1505096123024', '1505096123024'),
('10750', '10303', '1', 'login.count', '160', '160'),
('10751', '10303', '1', 'login.previousLoginMillis', '1504958831522', '1504958831522'),
('10802', '10400', '1', 'requiresPasswordChange', 'false', 'false'),
('10803', '10400', '1', 'passwordLastChanged', '1480560663430', '1480560663430'),
('10804', '10400', '1', 'password.reset.request.expiry', '1480647063663', '1480647063663'),
('10805', '10400', '1', 'password.reset.request.token', '7845b2c28857f495a0138f5d1c0f0a3ade25a6ff', '7845b2c28857f495a0138f5d1c0f0a3ade25a6ff'),
('10806', '10400', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10807', '10400', '1', 'invalidPasswordAttempts', '0', '0'),
('10808', '10400', '1', 'lastAuthenticated', '1504576144296', '1504576144296'),
('10809', '10400', '1', 'login.currentFailedCount', '0', '0'),
('10810', '10400', '1', 'login.lastLoginMillis', '1505096743000', '1505096743000'),
('10811', '10400', '1', 'login.count', '257', '257'),
('10812', '10400', '1', 'login.previousLoginMillis', '1504953072974', '1504953072974'),
('10813', '10401', '1', 'requiresPasswordChange', 'false', 'false'),
('10814', '10401', '1', 'passwordLastChanged', '1481078777636', '1481078777636'),
('10817', '10401', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10818', '10401', '1', 'login.currentFailedCount', '18', '18'),
('10819', '10401', '1', 'invalidPasswordAttempts', '0', '0'),
('10820', '10401', '1', 'lastAuthenticated', '1499391073898', '1499391073898'),
('10821', '10401', '1', 'login.lastLoginMillis', '1500257948054', '1500257948054'),
('10822', '10401', '1', 'login.count', '64', '64'),
('10834', '10209', '1', 'login.lastFailedLoginMillis', '1483408711444', '1483408711444'),
('10835', '10209', '1', 'login.totalFailedCount', '2', '2'),
('10836', '10115', '1', 'login.lastFailedLoginMillis', '1481189274738', '1481189274738'),
('10837', '10115', '1', 'login.totalFailedCount', '1', '1'),
('10838', '10401', '1', 'login.previousLoginMillis', '1499996872032', '1499996872032'),
('10839', '10400', '1', 'login.lastFailedLoginMillis', '1503970870842', '1503970870842'),
('10840', '10400', '1', 'login.totalFailedCount', '7', '7'),
('10900', '10500', '1', 'requiresPasswordChange', 'false', 'false'),
('10901', '10500', '1', 'passwordLastChanged', '1488769162129', '1488769162129'),
('10902', '10500', '1', 'password.reset.request.expiry', '1488855562621', '1488855562621'),
('10903', '10500', '1', 'password.reset.request.token', 'acfa11abe49c8a6b9e0e4db163508c7771200bc1', 'acfa11abe49c8a6b9e0e4db163508c7771200bc1'),
('10904', '10500', '1', 'invalidPasswordAttempts', '0', '0'),
('10905', '10500', '1', 'lastAuthenticated', '1505096291188', '1505096291188'),
('10906', '10500', '1', 'login.currentFailedCount', '0', '0'),
('10907', '10500', '1', 'login.lastLoginMillis', '1505096291221', '1505096291221'),
('10908', '10500', '1', 'login.count', '266', '266'),
('10909', '10500', '1', 'login.previousLoginMillis', '1505096139374', '1505096139374'),
('10910', '10501', '1', 'requiresPasswordChange', 'false', 'false'),
('10911', '10501', '1', 'passwordLastChanged', '1490245548466', '1490245548466'),
('10914', '10501', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10915', '10502', '1', 'requiresPasswordChange', 'false', 'false'),
('10916', '10502', '1', 'passwordLastChanged', '1492653191642', '1492653191642'),
('10919', '10502', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10920', '10501', '1', 'login.currentFailedCount', '0', '0'),
('10921', '10501', '1', 'invalidPasswordAttempts', '0', '0'),
('10922', '10501', '1', 'lastAuthenticated', '1503888007709', '1503888007709'),
('10923', '10501', '1', 'login.lastLoginMillis', '1504954509116', '1504954509116'),
('10924', '10501', '1', 'login.count', '74', '74'),
('10925', '10502', '1', 'invalidPasswordAttempts', '0', '0'),
('10926', '10502', '1', 'lastAuthenticated', '1504923397175', '1504923397175'),
('10927', '10502', '1', 'login.currentFailedCount', '0', '0'),
('10928', '10502', '1', 'login.lastLoginMillis', '1504923397196', '1504923397196'),
('10929', '10502', '1', 'login.count', '99', '99'),
('10930', '10501', '1', 'login.lastFailedLoginMillis', '1495781588624', '1495781588624'),
('10931', '10501', '1', 'login.totalFailedCount', '3', '3'),
('10932', '10502', '1', 'login.previousLoginMillis', '1504851138739', '1504851138739'),
('10933', '10500', '1', 'login.lastFailedLoginMillis', '1502696750483', '1502696750483'),
('10934', '10500', '1', 'login.totalFailedCount', '2', '2'),
('10935', '10503', '1', 'requiresPasswordChange', 'false', 'false'),
('10936', '10503', '1', 'passwordLastChanged', '1495532425928', '1495532425928'),
('10939', '10503', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10940', '10503', '1', 'invalidPasswordAttempts', '0', '0'),
('10941', '10503', '1', 'lastAuthenticated', '1496649578189', '1496649578189'),
('10942', '10503', '1', 'login.currentFailedCount', '0', '0'),
('10943', '10503', '1', 'login.lastLoginMillis', '1496730367465', '1496730367465'),
('10944', '10503', '1', 'login.count', '4', '4'),
('10945', '10501', '1', 'login.previousLoginMillis', '1504840738021', '1504840738021'),
('10946', '10503', '1', 'login.lastFailedLoginMillis', '1496649551664', '1496649551664'),
('10947', '10503', '1', 'login.totalFailedCount', '12', '12'),
('10948', '10502', '1', 'login.lastFailedLoginMillis', '1504923392974', '1504923392974'),
('10949', '10502', '1', 'login.totalFailedCount', '9', '9'),
('10950', '10504', '1', 'requiresPasswordChange', 'false', 'false'),
('10951', '10504', '1', 'passwordLastChanged', '1501473785592', '1501473785592'),
('10954', '10504', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10955', '10504', '1', 'invalidPasswordAttempts', '0', '0'),
('10956', '10504', '1', 'lastAuthenticated', '1504777220727', '1504777220727'),
('10957', '10504', '1', 'login.currentFailedCount', '0', '0'),
('10958', '10504', '1', 'login.lastLoginMillis', '1504777220746', '1504777220746'),
('10959', '10504', '1', 'login.count', '13', '13'),
('10960', '10504', '1', 'login.previousLoginMillis', '1504768719209', '1504768719209'),
('10961', '10505', '1', 'requiresPasswordChange', 'false', 'false'),
('10962', '10505', '1', 'passwordLastChanged', '1495188918959', '1495188918959'),
('10965', '10505', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10966', '10506', '1', 'requiresPasswordChange', 'false', 'false'),
('10967', '10506', '1', 'passwordLastChanged', '1495176234049', '1495176234049'),
('10968', '10506', '1', 'password.reset.request.expiry', '1495262634160', '1495262634160'),
('10969', '10506', '1', 'password.reset.request.token', 'deb7894f2366b04889282653da71199d65aacf97', 'deb7894f2366b04889282653da71199d65aacf97'),
('10970', '10506', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10971', '10507', '1', 'requiresPasswordChange', 'false', 'false'),
('10972', '10507', '1', 'passwordLastChanged', '1496373612663', '1496373612663'),
('10975', '10507', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10976', '10508', '1', 'requiresPasswordChange', 'false', 'false'),
('10977', '10508', '1', 'passwordLastChanged', '1496631258071', '1496631258071'),
('10980', '10508', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10981', '10508', '1', 'login.currentFailedCount', '0', '0'),
('10982', '10508', '1', 'invalidPasswordAttempts', '0', '0'),
('10983', '10508', '1', 'lastAuthenticated', '1504576360520', '1504576360520'),
('10984', '10508', '1', 'login.lastLoginMillis', '1504861245227', '1504861245227'),
('10985', '10508', '1', 'login.count', '131', '131'),
('10986', '10505', '1', 'login.currentFailedCount', '0', '0'),
('10987', '10505', '1', 'invalidPasswordAttempts', '0', '0'),
('10988', '10505', '1', 'lastAuthenticated', '1504860046287', '1504860046287'),
('10989', '10505', '1', 'login.lastLoginMillis', '1504860046319', '1504860046319'),
('10990', '10505', '1', 'login.count', '33', '33'),
('10991', '10509', '1', 'requiresPasswordChange', 'false', 'false'),
('10992', '10509', '1', 'passwordLastChanged', '1495508590074', '1495508590074'),
('10995', '10509', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('10996', '10510', '1', 'requiresPasswordChange', 'false', 'false'),
('10997', '10510', '1', 'passwordLastChanged', '1495508554760', '1495508554760'),
('11000', '10510', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11001', '10509', '1', 'login.currentFailedCount', '0', '0'),
('11002', '10509', '1', 'invalidPasswordAttempts', '0', '0'),
('11003', '10509', '1', 'lastAuthenticated', '1495508617027', '1495508617027'),
('11004', '10509', '1', 'login.lastLoginMillis', '1495508617053', '1495508617053'),
('11005', '10509', '1', 'login.count', '2', '2'),
('11006', '10510', '1', 'login.currentFailedCount', '0', '0'),
('11007', '10510', '1', 'invalidPasswordAttempts', '0', '0'),
('11010', '10510', '1', 'login.lastFailedLoginMillis', '1498443117972', '1498443117972'),
('11011', '10510', '1', 'login.totalFailedCount', '3', '3'),
('11012', '10509', '1', 'login.lastFailedLoginMillis', '1495507148275', '1495507148275'),
('11013', '10509', '1', 'login.totalFailedCount', '1', '1'),
('11014', '10509', '1', 'login.previousLoginMillis', '1495506702483', '1495506702483'),
('11015', '10510', '1', 'lastAuthenticated', '1504660206073', '1504660206073'),
('11016', '10510', '1', 'login.lastLoginMillis', '1505094311005', '1505094311005'),
('11017', '10510', '1', 'login.count', '94', '94'),
('11100', '10508', '1', 'login.previousLoginMillis', '1504836720748', '1504836720748'),
('11103', '10503', '1', 'password.reset.request.expiry', '1495618837728', '1495618837728'),
('11104', '10503', '1', 'password.reset.request.token', '67dd467230e7b2223574d763618bead92801d7eb', '67dd467230e7b2223574d763618bead92801d7eb'),
('11105', '10503', '1', 'login.previousLoginMillis', '1496649578239', '1496649578239'),
('11106', '10510', '1', 'login.previousLoginMillis', '1504956661792', '1504956661792'),
('11107', '10600', '1', 'requiresPasswordChange', 'false', 'false'),
('11108', '10600', '1', 'passwordLastChanged', '1499738730567', '1499738730567'),
('11111', '10600', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11125', '10507', '1', 'login.currentFailedCount', '0', '0'),
('11126', '10507', '1', 'invalidPasswordAttempts', '0', '0'),
('11127', '10507', '1', 'lastAuthenticated', '1504234547681', '1504234547681'),
('11128', '10507', '1', 'login.lastLoginMillis', '1505097345420', '1505097345420'),
('11129', '10507', '1', 'login.count', '85', '85'),
('11130', '10508', '1', 'login.lastFailedLoginMillis', '1497923992307', '1497923992307'),
('11131', '10508', '1', 'login.totalFailedCount', '7', '7'),
('11134', '10508', '1', 'password.reset.request.expiry', '1496717917500', '1496717917500'),
('11135', '10508', '1', 'password.reset.request.token', '98c73ee171642b643676e22d14ccc0e1ee90852b', '98c73ee171642b643676e22d14ccc0e1ee90852b'),
('11136', '10507', '1', 'login.previousLoginMillis', '1504863298939', '1504863298939'),
('11138', '10506', '1', 'invalidPasswordAttempts', '0', '0'),
('11139', '10506', '1', 'lastAuthenticated', '1496743408274', '1496743408274'),
('11140', '10506', '1', 'login.currentFailedCount', '0', '0'),
('11141', '10506', '1', 'login.lastLoginMillis', '1496743408315', '1496743408315'),
('11142', '10506', '1', 'login.count', '1', '1'),
('11143', '10505', '1', 'login.previousLoginMillis', '1504751060801', '1504751060801'),
('11144', '10603', '1', 'requiresPasswordChange', 'false', 'false'),
('11145', '10603', '1', 'passwordLastChanged', '1500434798939', '1500434798939'),
('11148', '10603', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11149', '10603', '1', 'invalidPasswordAttempts', '0', '0'),
('11150', '10603', '1', 'lastAuthenticated', '1505099992239', '1505099992239'),
('11151', '10603', '1', 'login.currentFailedCount', '0', '0'),
('11152', '10603', '1', 'login.lastLoginMillis', '1505099992337', '1505099992337'),
('11153', '10603', '1', 'login.count', '65', '65'),
('11154', '10603', '1', 'login.previousLoginMillis', '1504834153868', '1504834153868'),
('11155', '10216', '1', 'login.lastFailedLoginMillis', '1504504863653', '1504504863653'),
('11156', '10216', '1', 'login.totalFailedCount', '3', '3'),
('11157', '10212', '1', 'password.reset.request.expiry', '1498528852206', '1498528852206'),
('11158', '10212', '1', 'password.reset.request.token', '2f41acc76de72a796ee3081842004286b8e180a0', '2f41acc76de72a796ee3081842004286b8e180a0'),
('11170', '10507', '1', 'login.lastFailedLoginMillis', '1500718522573', '1500718522573'),
('11171', '10507', '1', 'login.totalFailedCount', '2', '2'),
('11172', '10600', '1', 'login.currentFailedCount', '0', '0'),
('11173', '10600', '1', 'invalidPasswordAttempts', '0', '0'),
('11174', '10600', '1', 'lastAuthenticated', '1504681725571', '1504681725571'),
('11175', '10600', '1', 'login.lastLoginMillis', '1505096213421', '1505096213421'),
('11176', '10600', '1', 'login.count', '67', '67'),
('11177', '10605', '1', 'requiresPasswordChange', 'false', 'false'),
('11178', '10605', '1', 'passwordLastChanged', '1499756645931', '1499756645931'),
('11179', '10605', '1', 'password.reset.request.expiry', '1499843046132', '1499843046132'),
('11180', '10605', '1', 'password.reset.request.token', 'af29a08e02a5e5145375a5484b00a0be574b5b6e', 'af29a08e02a5e5145375a5484b00a0be574b5b6e'),
('11181', '10605', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11182', '10605', '1', 'invalidPasswordAttempts', '0', '0'),
('11183', '10605', '1', 'lastAuthenticated', '1505095694883', '1505095694883'),
('11184', '10605', '1', 'login.currentFailedCount', '0', '0'),
('11185', '10605', '1', 'login.lastLoginMillis', '1505095694902', '1505095694902'),
('11186', '10605', '1', 'login.count', '103', '103'),
('11187', '10605', '1', 'login.previousLoginMillis', '1504919146238', '1504919146238'),
('11188', '10600', '1', 'login.previousLoginMillis', '1504835159208', '1504835159208'),
('11200', '10700', '1', 'requiresPasswordChange', 'false', 'false'),
('11201', '10700', '1', 'passwordLastChanged', '1501729710068', '1501729710068'),
('11204', '10700', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11205', '10401', '1', 'login.lastFailedLoginMillis', '1500345769577', '1500345769577'),
('11206', '10401', '1', 'login.totalFailedCount', '16', '16'),
('11207', '10701', '1', 'requiresPasswordChange', 'false', 'false'),
('11208', '10701', '1', 'passwordLastChanged', '1500350131390', '1500350131390'),
('11209', '10701', '1', 'password.reset.request.expiry', '1500436531498', '1500436531498'),
('11210', '10701', '1', 'password.reset.request.token', 'e5c572fc0db2ef7c62039de630df3969bfeaafde', 'e5c572fc0db2ef7c62039de630df3969bfeaafde'),
('11211', '10701', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11212', '10701', '1', 'invalidPasswordAttempts', '0', '0'),
('11213', '10701', '1', 'lastAuthenticated', '1500350229633', '1500350229633'),
('11214', '10701', '1', 'login.currentFailedCount', '0', '0'),
('11215', '10701', '1', 'login.lastLoginMillis', '1500350229670', '1500350229670'),
('11216', '10701', '1', 'login.count', '2', '2'),
('11217', '10701', '1', 'login.previousLoginMillis', '1500350155509', '1500350155509'),
('11300', '10603', '1', 'login.lastFailedLoginMillis', '1500434688173', '1500434688173'),
('11301', '10603', '1', 'login.totalFailedCount', '1', '1'),
('11302', '10505', '1', 'login.lastFailedLoginMillis', '1500445415323', '1500445415323'),
('11303', '10505', '1', 'login.totalFailedCount', '1', '1'),
('11304', '10505', '1', 'password.reset.request.expiry', '1500531833306', '1500531833306'),
('11305', '10505', '1', 'password.reset.request.token', 'c632a913d24df87f066c4a88aa66552d475ea157', 'c632a913d24df87f066c4a88aa66552d475ea157'),
('11306', '10800', '1', 'passwordLastChanged', '1501035685245', '1501035685245'),
('11307', '10800', '1', 'requiresPasswordChange', 'false', 'false'),
('11308', '10800', '1', 'invalidPasswordAttempts', '0', '0'),
('11309', '10800', '1', 'password.reset.request.expiry', '1501122085306', '1501122085306'),
('11310', '10800', '1', 'password.reset.request.token', 'bf1adf7bb1942775a9b996607bf94454cc711697', 'bf1adf7bb1942775a9b996607bf94454cc711697'),
('11311', '10800', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11312', '10800', '1', 'lastAuthenticated', '1504142857280', '1504142857280'),
('11313', '10800', '1', 'login.currentFailedCount', '0', '0'),
('11314', '10800', '1', 'login.lastLoginMillis', '1505096472631', '1505096472631'),
('11315', '10800', '1', 'login.count', '73', '73'),
('11316', '10800', '1', 'login.previousLoginMillis', '1505096472149', '1505096472149'),
('11317', '10700', '1', 'login.currentFailedCount', '0', '0'),
('11318', '10700', '1', 'invalidPasswordAttempts', '0', '0'),
('11319', '10700', '1', 'lastAuthenticated', '1505095570933', '1505095570933'),
('11320', '10700', '1', 'login.lastLoginMillis', '1505095571142', '1505095571142'),
('11321', '10700', '1', 'login.count', '12', '12'),
('11322', '10700', '1', 'login.previousLoginMillis', '1504834309563', '1504834309563'),
('11323', '10801', '1', 'passwordLastChanged', '1502155180474', '1502155180474'),
('11324', '10801', '1', 'requiresPasswordChange', 'false', 'false'),
('11325', '10801', '1', 'invalidPasswordAttempts', '0', '0'),
('11326', '10801', '1', 'password.reset.request.expiry', '1502241580534', '1502241580534'),
('11327', '10801', '1', 'password.reset.request.token', 'd1adae616e65d275216961f185c9647d25af5603', 'd1adae616e65d275216961f185c9647d25af5603'),
('11328', '10801', '1', 'lastAuthenticated', '1502347628731', '1502347628731'),
('11329', '10801', '1', 'login.currentFailedCount', '0', '0');
INSERT INTO `user_attributes` (`id`, `user_id`, `directory_id`, `attribute_name`, `attribute_value`, `lower_attribute_value`) VALUES
('11330', '10801', '1', 'login.lastLoginMillis', '1502704746639', '1502704746639'),
('11331', '10801', '1', 'login.count', '3', '3'),
('11332', '10801', '1', 'login.lastFailedLoginMillis', '1502347622367', '1502347622367'),
('11333', '10801', '1', 'login.totalFailedCount', '1', '1'),
('11334', '10801', '1', 'login.previousLoginMillis', '1502347628761', '1502347628761'),
('11335', '10802', '1', 'passwordLastChanged', '1502697093277', '1502697093277'),
('11336', '10802', '1', 'requiresPasswordChange', 'false', 'false'),
('11337', '10802', '1', 'invalidPasswordAttempts', '0', '0'),
('11340', '10802', '1', 'com.atlassian.jira.dvcs.invite.groups', ' ', ' '),
('11341', '10802', '1', 'login.currentFailedCount', '0', '0'),
('11342', '10802', '1', 'lastAuthenticated', '1505095918835', '1505095918835'),
('11343', '10802', '1', 'login.lastLoginMillis', '1505095918846', '1505095918846'),
('11344', '10802', '1', 'login.count', '34', '34'),
('11345', '10802', '1', 'login.previousLoginMillis', '1504920703482', '1504920703482'),
('11346', '10302', '1', 'login.lastFailedLoginMillis', '1503643498370', '1503643498370'),
('11347', '10302', '1', 'login.totalFailedCount', '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `user_email_active`
--

CREATE TABLE `user_email_active` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `uid` int(11) UNSIGNED NOT NULL,
  `verify_code` varchar(32) NOT NULL,
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_email_active`
--

INSERT INTO `user_email_active` (`id`, `username`, `email`, `uid`, `verify_code`, `time`) VALUES
(1, 'huangjie', '465175275@qq.com', 10827, 'K14V9XW41UBZVD3S9LFF4327YY8YQTM1', 1523628779),
(2, 'huangjie', '465175275@qq.com', 10831, '74MXCQCDKCOFUJEFNGO8YM9787C5GQOF', 1523628854),
(3, '19081381571', '19081381571@masterlab.org', 11299, 'GV18YT5CRRNIP0ER8J7E0R2V45TWIC5X', 1536218573),
(4, '19055406672', '19055406672@masterlab.org', 11336, '61NQU4T4JQLFY3CAZDH0Q11G5SL6Z12G', 1536219700),
(5, '19080125602', '19080125602@masterlab.org', 11361, '9U1MWHHTYJHLOM9PPDCVKJ2FQRHC6IS4', 1536219834);

-- --------------------------------------------------------

--
-- 表的结构 `user_email_find_password`
--

CREATE TABLE `user_email_find_password` (
  `email` varchar(50) NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `verify_code` varchar(32) NOT NULL,
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_email_find_password`
--

INSERT INTO `user_email_find_password` (`email`, `uid`, `verify_code`, `time`) VALUES
('121642038@qq.com', 0, 'KDBQ6N3V7ECRRDU2B9T33BBZ8TZKF4DA', 1536467329),
('19064656538@masterlab.org', 0, 'GXYPZ3J16EJOAKQARET9WJ1VVYFUKDV3', 1535594723),
('465175275@qq.com', 0, 'QHJJWZZ4EC0WNMVPOGAXWWGEBL3GDLGX', 1523628463);

-- --------------------------------------------------------

--
-- 表的结构 `user_email_token`
--

CREATE TABLE `user_email_token` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `expired` int(10) UNSIGNED NOT NULL COMMENT '有效期',
  `created_at` int(10) UNSIGNED NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1-有效，0-无效',
  `used_model` varchar(255) NOT NULL DEFAULT '' COMMENT '用于哪个模型或功能'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(11) UNSIGNED DEFAULT NULL,
  `group_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_group`
--

INSERT INTO `user_group` (`id`, `uid`, `group_id`) VALUES
(10000, 10000, 1),
(10001, 10000, 2),
(10224, 10000, 6),
(10220, 10100, 1),
(10223, 10100, 6),
(10226, 10101, 6),
(10219, 10102, 1),
(10221, 10104, 1),
(10228, 10111, 1),
(10225, 10111, 6),
(10222, 10114, 1),
(10002, 10115, 1),
(10010, 10115, 2),
(10111, 10115, 3),
(10210, 10115, 4),
(10227, 10115, 6),
(10215, 10826, 1),
(10213, 10826, 4),
(10214, 10826, 5),
(10229, 10910, 1),
(10230, 10910, 2),
(10231, 10911, 1),
(10232, 10912, 1),
(10233, 10912, 2),
(10234, 10913, 1),
(10235, 10914, 1),
(10236, 10914, 2),
(10237, 10915, 1),
(10238, 10916, 1),
(10239, 10916, 2),
(10240, 10917, 1),
(10241, 10918, 1),
(10242, 10918, 2),
(10243, 10919, 1),
(10244, 10920, 1),
(10245, 10920, 2),
(10246, 10921, 1),
(10247, 10922, 1),
(10248, 10922, 2),
(10249, 10923, 1),
(10250, 10924, 1),
(10251, 10924, 2),
(10252, 10925, 1),
(10253, 10926, 1),
(10254, 10926, 2),
(10255, 10927, 1),
(10352, 11119, 1),
(10353, 11119, 2),
(10256, 11202, 1),
(10257, 11203, 1),
(10258, 11204, 1),
(10259, 11205, 1),
(10260, 11206, 1),
(10261, 11207, 1),
(10262, 11208, 1),
(10263, 11209, 1),
(10264, 11210, 1),
(10265, 11211, 1),
(10266, 11212, 1),
(10267, 11213, 1),
(10268, 11214, 1),
(10269, 11215, 1),
(10270, 11216, 1),
(10271, 11217, 1),
(10272, 11218, 1),
(10273, 11219, 1),
(10274, 11220, 1),
(10275, 11221, 1),
(10276, 11222, 1),
(10277, 11223, 1),
(10278, 11224, 1),
(10279, 11225, 1),
(10280, 11226, 1),
(10281, 11227, 1),
(10282, 11228, 1),
(10283, 11229, 1),
(10284, 11230, 1),
(10285, 11231, 1),
(10286, 11232, 1),
(10287, 11233, 1),
(10288, 11234, 1),
(10289, 11235, 1),
(10290, 11236, 1),
(10291, 11237, 1),
(10292, 11238, 1),
(10293, 11239, 1),
(10294, 11240, 1),
(10295, 11241, 1),
(10296, 11242, 1),
(10297, 11243, 1),
(10298, 11244, 1),
(10299, 11245, 1),
(10300, 11246, 1),
(10301, 11247, 1),
(10302, 11248, 1),
(10303, 11249, 1),
(10304, 11250, 1),
(10305, 11251, 1),
(10306, 11252, 1),
(10307, 11253, 1),
(10308, 11254, 1),
(10309, 11255, 1),
(10310, 11256, 1),
(10311, 11257, 1),
(10312, 11258, 1),
(10313, 11259, 1),
(10314, 11260, 1),
(10315, 11261, 1),
(10316, 11262, 1),
(10317, 11263, 1),
(10318, 11264, 1),
(10319, 11265, 1),
(10320, 11265, 2),
(10321, 11265, 3),
(10322, 11265, 4),
(10323, 11265, 5),
(10324, 11265, 8),
(10325, 11276, 1),
(10326, 11276, 2),
(10327, 11276, 3),
(10328, 11276, 4),
(10329, 11276, 5),
(10330, 11276, 8),
(10331, 11287, 1),
(10332, 11288, 1),
(10333, 11288, 2),
(10334, 11288, 3),
(10335, 11288, 4),
(10336, 11288, 5),
(10337, 11288, 8),
(10338, 11300, 1),
(10339, 11301, 1),
(10340, 11301, 2),
(10341, 11301, 3),
(10342, 11301, 4),
(10343, 11301, 5),
(10344, 11301, 8),
(10345, 11312, 1),
(10346, 11313, 1),
(10347, 11313, 2),
(10348, 11313, 3),
(10349, 11313, 4),
(10350, 11313, 5),
(10351, 11313, 8),
(10354, 11324, 1),
(10355, 11325, 1),
(10356, 11325, 2),
(10357, 11325, 3),
(10358, 11325, 4),
(10359, 11325, 5),
(10360, 11325, 8),
(10361, 11337, 1),
(10368, 11338, 1),
(10369, 11338, 2),
(10370, 11349, 1),
(10371, 11350, 1),
(10372, 11350, 2),
(10373, 11350, 3),
(10374, 11350, 4),
(10375, 11350, 5),
(10376, 11350, 8),
(10377, 11362, 1),
(10378, 11363, 1),
(10379, 11363, 2),
(10380, 11363, 3),
(10381, 11363, 4),
(10382, 11363, 5),
(10383, 11363, 8),
(10384, 11375, 1),
(10385, 11376, 1),
(10386, 11376, 2),
(10387, 11376, 3),
(10388, 11376, 4),
(10389, 11376, 5),
(10390, 11376, 8),
(10391, 11388, 1),
(10392, 11389, 1),
(10393, 11389, 2),
(10394, 11389, 3),
(10395, 11389, 4),
(10396, 11389, 5),
(10397, 11389, 8),
(10398, 11401, 1),
(10399, 11402, 1),
(10400, 11402, 2),
(10401, 11402, 3),
(10402, 11402, 4),
(10403, 11402, 5),
(10404, 11402, 8),
(10405, 11414, 1),
(10406, 11415, 1),
(10407, 11415, 2),
(10408, 11415, 3),
(10409, 11415, 4),
(10410, 11415, 5),
(10411, 11415, 8),
(10412, 11426, 1),
(10413, 11427, 1),
(10414, 11427, 2),
(10415, 11427, 3),
(10416, 11427, 4),
(10417, 11427, 5),
(10418, 11427, 8),
(10419, 11438, 1),
(10420, 11439, 1),
(10421, 11439, 2),
(10422, 11439, 3),
(10423, 11439, 4),
(10424, 11439, 5),
(10425, 11439, 8),
(10426, 11451, 1),
(10427, 11452, 1),
(10428, 11452, 2),
(10429, 11452, 3),
(10430, 11452, 4),
(10431, 11452, 5),
(10432, 11452, 8),
(10433, 11464, 1),
(10434, 11465, 1),
(10435, 11465, 2),
(10436, 11465, 3),
(10437, 11465, 4),
(10438, 11465, 5),
(10439, 11465, 8),
(10440, 11476, 1),
(10441, 11477, 1),
(10442, 11477, 2),
(10443, 11477, 3),
(10444, 11477, 4),
(10445, 11477, 5),
(10446, 11477, 8),
(10447, 11488, 1),
(10448, 11489, 1),
(10449, 11489, 2),
(10450, 11489, 3),
(10451, 11489, 4),
(10452, 11489, 5),
(10453, 11489, 8),
(10454, 11500, 1),
(10455, 11501, 1),
(10456, 11501, 2),
(10457, 11501, 3),
(10458, 11501, 4),
(10459, 11501, 5),
(10460, 11501, 8),
(10461, 11512, 1),
(10462, 11513, 1),
(10463, 11513, 2),
(10464, 11513, 3),
(10465, 11513, 4),
(10466, 11513, 5),
(10467, 11513, 8),
(10468, 11524, 1),
(10469, 11525, 1),
(10470, 11525, 2),
(10471, 11525, 3),
(10472, 11525, 4),
(10473, 11525, 5),
(10474, 11525, 8),
(10475, 11536, 1),
(10476, 11537, 1),
(10477, 11537, 2),
(10478, 11537, 3),
(10479, 11537, 4),
(10480, 11537, 5),
(10481, 11537, 8),
(10482, 11548, 1),
(10489, 11549, 1),
(10490, 11549, 2),
(10491, 11561, 1),
(10492, 11562, 1),
(10493, 11562, 2),
(10494, 11562, 3),
(10495, 11562, 4),
(10496, 11562, 5),
(10497, 11562, 8),
(10498, 11575, 1),
(10505, 11576, 1),
(10506, 11576, 2),
(10507, 11589, 1),
(10508, 11590, 1),
(10509, 11590, 2),
(10510, 11590, 3),
(10511, 11590, 4),
(10512, 11590, 5),
(10513, 11590, 8),
(10514, 11601, 1),
(10521, 11602, 1),
(10522, 11602, 2),
(10523, 11615, 1),
(10524, 11616, 1),
(10525, 11617, 1),
(10526, 11618, 1),
(10527, 11619, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user_ip_login_times`
--

CREATE TABLE `user_ip_login_times` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL DEFAULT '',
  `times` int(11) NOT NULL DEFAULT '0',
  `up_time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_ip_login_times`
--

INSERT INTO `user_ip_login_times` (`id`, `ip`, `times`, `up_time`) VALUES
(1, '1902454631', 0, 1527260906),
(2, '1906299743', 4, 1527260936);

-- --------------------------------------------------------

--
-- 表的结构 `user_login_log`
--

CREATE TABLE `user_login_log` (
  `id` int(11) NOT NULL,
  `session_id` varchar(64) NOT NULL DEFAULT '',
  `token` varchar(128) DEFAULT '',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ip` varchar(24) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';

--
-- 转存表中的数据 `user_login_log`
--

INSERT INTO `user_login_log` (`id`, `session_id`, `token`, `uid`, `time`, `ip`) VALUES
(4, '6jtejh3v8c0l6u2s380rgo1o32', '', 10826, 1508330461, '127.0.0.1'),
(135, 'm5q8mc82s34klqtuiri3abmu7p', '', 11573, 1529478153, '127.0.0.1'),
(136, '4dlfggtisogmhejso3t9sgat12', '', 11574, 1529478195, '127.0.0.1'),
(138, 'u76mpl7n2v5atj7at5blvcm49n', '', 11575, 1529567101, '127.0.0.1'),
(147, 'd83d236ed8648bddce7106e496af8d58', '', 11576, 1529670759, '127.0.0.1'),
(264, 's5spvmntrvviad24hskvenj9eh', '', 10968, 1535594712, '127.0.0.1'),
(265, '61ahijkmtc0moub0r2705qefe8', '', 10969, 1535594719, '127.0.0.1'),
(266, 'kh61agioah54a7nm6crpu2smbj', '', 10971, 1535594722, '127.0.0.1'),
(267, '2ai48qoa4ijm4951192t404j9r', '', 10973, 1535594759, '127.0.0.1'),
(268, 'mvpirsjtlkoibs7fe8nu4qtat0', '', 10975, 1535594788, '127.0.0.1'),
(269, 'dqcbk1bh57dut674tubte9ptqn', '', 10977, 1535596617, '127.0.0.1'),
(270, 'kfvdoj4u0og422dnetb1lj47b2', '', 10978, 1535596658, '127.0.0.1'),
(271, 'd5bolt46n3qd4qcjcc9eg5fq47', '', 10979, 1535596677, '127.0.0.1'),
(272, 'gq4k83d5000m0oqdpvgr5n4p5f', '', 10980, 1535596915, '127.0.0.1'),
(273, 'd99sngaajsno21cfsnnvf22v53', '', 10981, 1535597039, '127.0.0.1'),
(274, '5qpjtirhlsigmq7ob4n28k1fio', '', 10982, 1535597093, '127.0.0.1'),
(275, 'r61vspbtm9h7590ha2m89g7b12', '', 10983, 1535597826, '127.0.0.1'),
(276, 'ssocvbrq52gt5oivrvmogimv1d', '', 10984, 1535597853, '127.0.0.1'),
(277, 'fon8n63cenrlmkcpkc076v394g', '', 10985, 1535597902, '127.0.0.1'),
(278, 'jajuq9ok5sgrdn6rvl33fik233', '', 10986, 1535597999, '127.0.0.1'),
(279, 'hb7su0m4ekv5kpslk0nsci8lea', '', 10987, 1535598292, '127.0.0.1'),
(280, 'r8uctd9tchpaptkicp0b8jmhjq', '', 10988, 1535598365, '127.0.0.1'),
(281, 'rv2avjeoqbknabu01r59irpasb', '', 10989, 1535598433, '127.0.0.1'),
(282, 'atfenurseifilmqkd0t2crr9kg', '', 10990, 1535598482, '127.0.0.1'),
(283, 'sduth1anm02g0n4t2feep1bcuo', '', 10991, 1535598540, '127.0.0.1'),
(284, '7thgrsgg6rjitmjcp12mccuj77', '', 10992, 1535598565, '127.0.0.1'),
(285, 'v1nrhmehjr039u4otnspsub5oq', '', 10993, 1535598786, '127.0.0.1'),
(286, '2rgqfrtn2vqrbf2uhsh632resd', '', 10995, 1535598984, '127.0.0.1'),
(287, '0t78qrud38m1vf1btr1a9k2qc5', '', 10997, 1535599221, '127.0.0.1'),
(288, '0euhullqu5ekp2501kbcrspln0', '', 10999, 1535599286, '127.0.0.1'),
(289, '96dkn3jtn6ijnur5kv23hj1e4j', '', 11001, 1535599470, '127.0.0.1'),
(290, '35kqf6a2f3i6nu7bjficejj37q', '', 11003, 1535599499, '127.0.0.1'),
(291, 'd4h9mubhsdi9k8aeglavkhcj4g', '', 11005, 1535599676, '127.0.0.1'),
(292, 'mvcip68q4bp4u5aa5ddq927io4', '', 11007, 1535599703, '127.0.0.1'),
(293, 'eb1hrimnj7bteoqu7bdh70dac3', '', 11009, 1535599779, '127.0.0.1'),
(294, 'f5gknen5726ct0d9lleglge59q', '', 11011, 1535599815, '127.0.0.1'),
(295, '6fev2d39fkhmao8ckhi70fv2ir', '', 11013, 1535599902, '127.0.0.1'),
(296, '24qu1d4jai4sdcm887pohgp0i8', '', 11015, 1535599943, '127.0.0.1'),
(297, '9jb0icoqctclav7a17erbql4ic', '', 11016, 1535599943, '127.0.0.1'),
(298, '3uhnkhu553m6cdn184mbmkvglf', '', 11017, 1535599961, '127.0.0.1'),
(299, 'l7mnbsnr735gl1ms93t5oe1ept', '', 11018, 1535599961, '127.0.0.1'),
(300, '9iafdvmggus4lc2mv140aike59', '', 11019, 1535600001, '127.0.0.1'),
(301, '9mkhksl6soso18a49qd99lkkne', '', 11020, 1535600001, '127.0.0.1'),
(302, 'c1rffeq8sas2et2celojvmokti', '', 11021, 1535600031, '127.0.0.1'),
(303, '6o7qdvmdl2u5bcdgvmg4io44jq', '', 11022, 1535600031, '127.0.0.1'),
(304, 'im0dhvqa9ti0tbsul2mp11u5i1', '', 11023, 1535600103, '127.0.0.1'),
(305, '8u1p3mnagft40i6l47dr9j3avp', '', 11024, 1535600103, '127.0.0.1'),
(306, 'j60onjqdj06gp9v59gq5ndla5a', '', 11025, 1535600259, '127.0.0.1'),
(307, '121pe1qql9aa5a6dbl847u0g3n', '', 11026, 1535600259, '127.0.0.1'),
(308, 'a0ie9rc7de8d152mafiv580mub', '', 11027, 1535600333, '127.0.0.1'),
(309, '2kpkugu0cfehatouoharpafrrs', '', 11028, 1535600334, '127.0.0.1'),
(310, 'frtvm298ie5n455i0kfv8iv06r', '', 11029, 1535600422, '127.0.0.1'),
(311, '26pcc2fmg85vfoq89hsdaj78na', '', 11030, 1535600423, '127.0.0.1'),
(312, 'sfutojvh8deuqadeftgvjau06f', '', 11031, 1535600609, '127.0.0.1'),
(314, 'j42blgjkftdv1iverhlv3hh2hg', '', 11032, 1535600610, '127.0.0.1'),
(315, 'h23jdbsob28qh3ia7q0ghbc1sb', '', 11033, 1535600631, '127.0.0.1'),
(317, '62e3p7622d7l6rh86tkd60jv8v', '', 11034, 1535600631, '127.0.0.1'),
(318, '3nbp2j8b0001fjgp385pafaml7', '', 11035, 1535618230, '127.0.0.1'),
(319, 'uptolvvc11td0of6o6c53ri6pg', '', 11036, 1535618231, '127.0.0.1'),
(320, '86qtfknthmfd0jt5p01ask8j11', '', 11037, 1535618306, '127.0.0.1'),
(321, '36j7rer3g9pfos7iqthnf8m18d', '', 11038, 1535618306, '127.0.0.1'),
(322, '5mo2bqi5r3kg8gcfdmeav5tvs7', '', 11039, 1535618325, '127.0.0.1'),
(323, 'dvfvpnvet3gqd7hre1khdpkp4s', '', 11040, 1535618325, '127.0.0.1'),
(324, 'jiqor5t737l36lj325rsq3plts', '', 11041, 1535618429, '127.0.0.1'),
(325, '7f5fvqrokohjd5qbne4m0detms', '', 11042, 1535618429, '127.0.0.1'),
(326, '283ua009j1k2hbokiolgv6pkkq', '', 11043, 1535698314, '127.0.0.1'),
(327, 'sfb40d6r3u06n8skcrgsgb4b5u', '', 11044, 1535698314, '127.0.0.1'),
(328, 'qqkr7429rebs3e1cuudg5f927d', '', 11045, 1535698344, '127.0.0.1'),
(329, 'f7ugjtqa0v26pjvc7ke97t3qut', '', 11046, 1535698344, '127.0.0.1'),
(330, 'mlk6vmkde2c6ijf85lfieerq6r', '', 11047, 1535698463, '127.0.0.1'),
(331, 'f8k2nel8s271ln9qanm5cu6lof', '', 11048, 1535698463, '127.0.0.1'),
(332, 'ull9t8qjm64clkm09hjl5gvktt', '', 11049, 1535698631, '127.0.0.1'),
(333, '8re6fmflf3ns1vnlo60o5uggid', '', 11050, 1535698631, '127.0.0.1'),
(334, 'tm2l1m4b7qakde1297gc9nhrqg', '', 11051, 1535698687, '127.0.0.1'),
(335, 'qrulmc3iemllsrgjf1uh283cp2', '', 11052, 1535698687, '127.0.0.1'),
(336, 'pvcsfk4s2pqc54p5psa7r8kjql', '', 11053, 1535699247, '127.0.0.1'),
(337, '6fqeoebd5mjk53nd6foo5k0op4', '', 11054, 1535699247, '127.0.0.1'),
(338, 'uopflr7v0ps56d7r59h7tjvi2q', '', 11055, 1535699320, '127.0.0.1'),
(339, 'if1l4jcop3bkn0dkvt9d45irsu', '', 11056, 1535699321, '127.0.0.1'),
(340, '4bm7jv0tfhnqu8gksgf67flj8c', '', 11057, 1535699385, '127.0.0.1'),
(341, 'm3jfrsicslu962orgsqmin7i8a', '', 11058, 1535699386, '127.0.0.1'),
(342, '186t4042bpubo7mjvqt4lc3d9r', '', 11059, 1535699455, '127.0.0.1'),
(343, 'cq1576d7ii57s33f1fi56g3bns', '', 11060, 1535699456, '127.0.0.1'),
(344, '597egfq7o74krib349si0em8fl', '', 11061, 1535699499, '127.0.0.1'),
(345, 'fh2kocs3hcvs852tnepdpbbspn', '', 11062, 1535699499, '127.0.0.1'),
(346, '6aib0bf9tbgdeetmhou4si7mmd', '', 11063, 1535699567, '127.0.0.1'),
(347, '30gp2r8pl092q4ud414s67pog2', '', 11064, 1535699567, '127.0.0.1'),
(348, 'crhiapg3mmi64hp35j5l0nqdls', '', 11065, 1535699645, '127.0.0.1'),
(349, '5eva82j5ivsppnk9k7qv0lg5d0', '', 11066, 1535699645, '127.0.0.1'),
(350, 'uch08nq7goo0jiqjm0dtle51ia', '', 11067, 1535699674, '127.0.0.1'),
(351, 'a0js4ng6jaq6k73u7ikbm8ccq6', '', 11068, 1535699674, '127.0.0.1'),
(352, 'c8n23beoijo3bta4q0nbl93f3k', '', 11069, 1535716801, '127.0.0.1'),
(353, 'q457f08bo9puqqevq17eu379l1', '', 11070, 1535716872, '127.0.0.1'),
(354, 'gdrpr1ib714os76schfpb0libq', '', 11071, 1535716909, '127.0.0.1'),
(355, 'jdqb7etfp381su9ohbccea3c5g', '', 11072, 1535717083, '127.0.0.1'),
(356, 'r3fdc29h9m95que9ha3ta31u9l', '', 11073, 1535717104, '127.0.0.1'),
(357, 'chquseh5iqplj7f0ssq7dcsj2q', '', 11074, 1535717145, '127.0.0.1'),
(358, 'e155c57rockdeccmcmp1jggsmg', '', 11075, 1535717196, '127.0.0.1'),
(359, 'kqm538tcja9a5b2lpeuip3r5k4', '', 11076, 1535717322, '127.0.0.1'),
(360, '54qisoug0pqq3ornjp05s35fb5', '', 11077, 1535717334, '127.0.0.1'),
(361, 'tahla7tcajlt4478p14d5mta3u', '', 11078, 1535717348, '127.0.0.1'),
(362, 'v4sfs6rs8crm0ugfgijnpa54ln', '', 11079, 1535717370, '127.0.0.1'),
(363, 've8avd0gcsohptq18jm09t1a49', '', 11080, 1535717403, '127.0.0.1'),
(364, '8l4qnokp9dgbiae6fv0qo2887f', '', 11081, 1535717422, '127.0.0.1'),
(365, 'ollu212r08o6fq33tghtb9bc1m', '', 11082, 1535717451, '127.0.0.1'),
(366, 'jr20llm59o14njduhrbegeml66', '', 11083, 1535717538, '127.0.0.1'),
(367, '2rka95jjr4m48h5ns550pk57a8', '', 11084, 1535717563, '127.0.0.1'),
(368, 'lod4dm653vpnot1bt5rsek0pb2', '', 11085, 1535717590, '127.0.0.1'),
(369, '87fqgqcmgopovcji0gou3gkemi', '', 11086, 1535717665, '127.0.0.1'),
(370, 'j80ih9p24nd0mpb66uj71746ej', '', 11087, 1535717717, '127.0.0.1'),
(371, '6lience26ct8jstbq6uhhcmo15', '', 11088, 1535717730, '127.0.0.1'),
(372, 'am7jb3fogt15lc7be7ajsrra44', '', 11089, 1535717833, '127.0.0.1'),
(373, 'oeag95cfcbhgb0a9hqak8tgjgq', '', 11090, 1535718025, '127.0.0.1'),
(374, 'pmbrn33kj0mk9j1q94kqhqnq14', '', 11091, 1535718453, '127.0.0.1'),
(375, 'dogdfpqou9gst6q5fcfqhmu3e0', '', 11092, 1535718477, '127.0.0.1'),
(376, '8cbjs1u11j7nomsg2nu8tf9e67', '', 11093, 1535718495, '127.0.0.1'),
(377, '16oa9ko141j7abd7nc30i56ijq', '', 11094, 1535718510, '127.0.0.1'),
(378, 'tsm91h2cnaco2gq6qi85e4a63d', '', 11095, 1535718824, '127.0.0.1'),
(379, '76cj9dedh4sqcv90sdnfflh1u0', '', 11096, 1535718920, '127.0.0.1'),
(380, '3fjbqm43s88a2juebefdcidu6q', '', 11097, 1535719036, '127.0.0.1'),
(381, 'er4q2ur72ebjp3vp7973btqnav', '', 11098, 1535719117, '127.0.0.1'),
(382, 'ptbho7nk5i1lk53nh0e2avbogi', '', 11099, 1535719182, '127.0.0.1'),
(383, 'vvs47prhu3safd2v80de19k90h', '', 11100, 1535719195, '127.0.0.1'),
(384, 'peclvumlru88fmp3u6mdgdu9d2', '', 11101, 1535719314, '127.0.0.1'),
(385, 'l4plhrom65gkenr9e84p5v0b49', '', 11102, 1535719327, '127.0.0.1'),
(386, 'up2pidcns3ksvkt4j0tkbgeai3', '', 11103, 1535719434, '127.0.0.1'),
(387, 'gf8r3errjjh7h5gaom39685mt5', '', 11104, 1535719472, '127.0.0.1'),
(388, '8lbedv17s0dlgl8coo1nbrcips', '', 11105, 1535719503, '127.0.0.1'),
(389, 'e8dhdfg132uqp5h65ciqj8hbrc', '', 11106, 1535719611, '127.0.0.1'),
(390, '90igluon9rla0hg0ijabef25n7', '', 11107, 1535719782, '127.0.0.1'),
(391, '0i7p23ovps1tn1iakhroq1fah5', '', 11108, 1535719795, '127.0.0.1'),
(392, 'o8jd7uuemdn529fsqfcfag1uer', '', 11109, 1535719852, '127.0.0.1'),
(393, 'q14c54jak83qlq9hmb8cvgon4l', '', 11110, 1535719991, '127.0.0.1'),
(394, '7o10k223osktuo9t9ahh5mi6j0', '', 11111, 1535720063, '127.0.0.1'),
(395, '6hp5tsui95lrg9obcjk08c5dkq', '', 11112, 1535720101, '127.0.0.1'),
(396, '59jb921epgg95k1kgpnf7o1a77', '', 11113, 1535720123, '127.0.0.1'),
(397, 'jqri5v8t9trmatd638ffku14dj', '', 11114, 1535720185, '127.0.0.1'),
(398, 'oq0l7s5ttai0n5l866chf5ml4i', '', 11115, 1535720251, '127.0.0.1'),
(399, 'r7495pto5n0234dqmajv94j87l', '', 11116, 1535720276, '127.0.0.1'),
(400, 'h2i39g2qom52bga5sdfpnlgsrj', '', 11117, 1535720366, '127.0.0.1'),
(403, 'ffo5ctevvkrb9u35ame2v5oh35', '', 11118, 1535965049, '127.0.0.1'),
(404, 'qce1do1qivcknc74c6teuvobf7', '', 11119, 1535965146, '127.0.0.1'),
(405, 'g2sdedlg2rkbdpdparq9ein6gh', '', 11120, 1535965193, '127.0.0.1'),
(406, '6j2h5h9d06ausdj8a0rges9877', '', 11121, 1535965205, '127.0.0.1'),
(407, 'b9acj38k15epjl3tgqagb4fnm4', '', 11122, 1535965214, '127.0.0.1'),
(408, '1bvohhmk86bsrutegi6olb4ll9', '', 11123, 1535965244, '127.0.0.1'),
(409, 'iid471e28v25ckg9eipf27vgqn', '', 11124, 1535965305, '127.0.0.1'),
(410, 'bbuq0qlibgfckssep5bdj2ovfe', '', 11125, 1535965317, '127.0.0.1'),
(411, 'p62m34s098omko4fk8vm1hjrli', '', 11126, 1535965410, '127.0.0.1'),
(412, '2slj4204o4991stv996dnjqlap', '', 11127, 1535965433, '127.0.0.1'),
(413, 'frd2k2tfrm64hmce65lmoncc45', '', 11128, 1535965452, '127.0.0.1'),
(414, 'eeqnjr1e3ejvrtuilsg1avi5mv', '', 11129, 1535965523, '127.0.0.1'),
(415, 'vn1vssbe7fm36dqoii1lq04vke', '', 11130, 1535965741, '127.0.0.1'),
(416, 'tp6hn8da8nptpqqucvvqq2o69m', '', 11131, 1535965754, '127.0.0.1'),
(417, 'i11lk31qjimlmbquoo7fer3c69', '', 11132, 1535965883, '127.0.0.1'),
(418, 'h4qom5ko8b48o2jhjr3va31eoa', '', 11133, 1535965916, '127.0.0.1'),
(419, 'ir3vtj3181nbau2dfar5vv2jiu', '', 11134, 1535966064, '127.0.0.1'),
(420, '45d0g15dqarslbq7slmrb197i0', '', 11135, 1535966516, '127.0.0.1'),
(421, 'u8ro5hudrdjr0eg12vkee3us5u', '', 11136, 1535966558, '127.0.0.1'),
(422, '0552i6k8evpmbl09684shms5sq', '', 11137, 1535967649, '127.0.0.1'),
(423, '51taq1ufni5c1mg4q9n9nbp1f7', '', 11138, 1535967670, '127.0.0.1'),
(425, 'h38htifu43oai9p1ujqt96kssd', '', 11139, 1535977819, '127.0.0.1'),
(426, '7v2oqmp6g2r8p36ht9re3aal4b', '', 11140, 1535977920, '127.0.0.1'),
(427, '6n4beuak6d7ifhf5oo7f5l1l1t', '', 11141, 1535977969, '127.0.0.1'),
(428, '8letpum7amh4c81oo42rl496ri', '', 11142, 1535978114, '127.0.0.1'),
(429, 'tpnsteee22tdai8rl3tldlqu42', '', 11143, 1535978252, '127.0.0.1'),
(430, '4lujkmhfgee1sbeejv6dnijfe5', '', 11144, 1535978367, '127.0.0.1'),
(431, '2h0qbn1akfsgtmpr95ujsdh7at', '', 11145, 1535978581, '127.0.0.1'),
(432, '7plcid8ji0uqq05qur2jijpvt5', '', 11146, 1535978645, '127.0.0.1'),
(433, '29ftu12s65q6n2s6t145o2aub0', '', 11147, 1535978896, '127.0.0.1'),
(434, '1pc7fgl4q7kr7humoo9u8eeia6', '', 11148, 1535979953, '127.0.0.1'),
(435, 'srd09mtrp65tult9vfgha1shru', '', 11149, 1535980002, '127.0.0.1'),
(436, 'a6gqjgcd3q49i4kl64lqmja4gq', '', 11150, 1535980074, '127.0.0.1'),
(437, 'hdklv7ph9kagkckk7q57rp6g0d', '', 11151, 1535980570, '127.0.0.1'),
(438, 'hdeiapvp8032r1006uds2hfuo0', '', 11152, 1535980624, '127.0.0.1'),
(439, 'tuf808kgrsu8fir5ikela1i726', '', 11153, 1535980638, '127.0.0.1'),
(440, 'lr05nigp718pahda3leuv5c50h', '', 11154, 1535980688, '127.0.0.1'),
(441, 'og1fald15a6di35ij658dol7ob', '', 11155, 1535980956, '127.0.0.1'),
(442, 'mcaanujrdhie1f8jfm2blarp9q', '', 11157, 1535980976, '127.0.0.1'),
(443, 'm8avemqtjbvecql6lmvqcj2c8r', '', 11159, 1535981601, '127.0.0.1'),
(444, 'ojcss7d7qv7gsnu751v5mqk7od', '', 11160, 1535981624, '127.0.0.1'),
(445, 'l35squqi7sano36fae8jnhk9dd', '', 11161, 1535981841, '127.0.0.1'),
(446, 'mgrgu872tt65tj2lf1hmn6btvq', '', 11162, 1535981974, '127.0.0.1'),
(447, 'm6rcm5f64j8dh15prh1km3p335', '', 11163, 1535982443, '127.0.0.1'),
(448, 'tgc2spsvlid7sc0d0sra8fe5cn', '', 11164, 1535982606, '127.0.0.1'),
(449, 'ie9up90pkngpop2ig07nrf50ue', '', 11165, 1535982681, '127.0.0.1'),
(450, 'n57kguelabsldkfcjv0n5p6bfh', '', 11166, 1535982751, '127.0.0.1'),
(451, 'qfp7hvqtb50gmvv9b0nc7suqn0', '', 11167, 1535982873, '127.0.0.1'),
(452, '50iu7168gqd7tqbuajf6auimrf', '', 11168, 1535982920, '127.0.0.1'),
(453, 'uu9e3lab69n6ksk92euppnopqj', '', 11169, 1535982978, '127.0.0.1'),
(454, '4iaafrd1uppl1c7ptknq9ggrg5', '', 11170, 1535983019, '127.0.0.1'),
(455, 'm3f4vif11ki6fmfdo1pc5baq6h', '', 11171, 1535983097, '127.0.0.1'),
(456, '653kfo93vhhjd37hnk3jtd0441', '', 11172, 1535983118, '127.0.0.1'),
(457, 'nqp7t5ihrfin55s9q6dh8hs5o0', '', 11173, 1535983154, '127.0.0.1'),
(458, 'd5dv141gjim4n2dd05c4ht10ma', '', 11174, 1535983187, '127.0.0.1'),
(459, 'ojdfj0pmtei1r7o7tm7mgcb81g', '', 11175, 1535983321, '127.0.0.1'),
(460, 'so0p7knuq19qa5ppjobiuipioe', '', 11176, 1535983325, '127.0.0.1'),
(461, 'tajqosi911ht68r0216qo0khvb', '', 11177, 1536028860, '127.0.0.1'),
(462, 'i0knou12b1327iir9ndd623d16', '', 11178, 1536028921, '127.0.0.1'),
(463, 'oim8c84fkr2hc4n9v4g4hkclac', '', 11179, 1536044747, '127.0.0.1'),
(464, 'qb0e32n771teruhenon751ojo1', '', 11180, 1536045031, '127.0.0.1'),
(465, 'brn1j85qcjutrrkihlaau5tf42', '', 11181, 1536045096, '127.0.0.1'),
(467, 'f66hk4b0tsc5il3numo4uuvbm9', '', 11182, 1536047675, '127.0.0.1'),
(468, 'utlplbdi8i1vq0dnfj68d7j9cf', '', 11183, 1536047702, '127.0.0.1'),
(469, '86mp1vg9kqj01ke6tevcpbrcdq', '', 11184, 1536047736, '127.0.0.1'),
(470, 'sdksurntfogu0m1fsfe0ij8h0j', '', 11185, 1536047759, '127.0.0.1'),
(471, 'mgt9gqt9i9eeavr82dneeert2e', '', 11186, 1536050994, '127.0.0.1'),
(472, '9ll2cmbfv0d923iooja2v22ti4', '', 11187, 1536051019, '127.0.0.1'),
(473, '5fchbv8q53d5cqfejqp314a7gl', '', 11188, 1536051036, '127.0.0.1'),
(474, 'fimnkak2h0f3t7r1a7kd55hpij', '', 11189, 1536051063, '127.0.0.1'),
(475, '88bjmc0v117ljrsb0flmkv3srb', '', 11190, 1536051118, '127.0.0.1'),
(476, 'np4mq4oodai4p8re8vf31mu0o1', '', 11191, 1536051146, '127.0.0.1'),
(477, 'scbrpio0s5dpotlsou6t6vr15v', '', 11192, 1536051176, '127.0.0.1'),
(478, 'bk20cfd5sadc3t7av3p2m1bu09', '', 11193, 1536051186, '127.0.0.1'),
(479, 'o9lnqpo269ur2ht7578dnnast4', '', 11194, 1536051219, '127.0.0.1'),
(480, 'l8stiih1dvgsec4ko21m8qkuqo', '', 11195, 1536051227, '127.0.0.1'),
(481, 'h297puh94e8hsl53aln7m0upe4', '', 11196, 1536051244, '127.0.0.1'),
(482, 'cuq0p5l8aot9klr4ar0fo0g52i', '', 11197, 1536051267, '127.0.0.1'),
(483, 'p67qrugpm4rl9qa8fd9s25n2oh', '', 11198, 1536051294, '127.0.0.1'),
(484, 'ghao4itmd1fmp21ubaani91aat', '', 11199, 1536051321, '127.0.0.1'),
(485, 'mnig8polsad77le6le5ig75cfl', '', 11200, 1536051333, '127.0.0.1'),
(486, '7veo6a7vki97inu3h68cjtnnte', '', 11201, 1536144306, '127.0.0.1'),
(487, '2lvn017fd0ji2luof8vqml3sq5', '', 11202, 1536198827, '127.0.0.1'),
(488, 'cn6d387m746kt931r1gign8ilj', '', 11203, 1536200137, '127.0.0.1'),
(489, 'mq5ch4j14u2shssjel969n6r3m', '', 11204, 1536200167, '127.0.0.1'),
(490, 'uad1snctdottq64jpmrqjk7gf9', '', 11205, 1536200365, '127.0.0.1'),
(491, 'gfni6cnei2p0kptto8dhtnhaar', '', 11206, 1536200441, '127.0.0.1'),
(492, 'ke9i6lstjcopd3kcs2rv1a8eng', '', 11207, 1536200547, '127.0.0.1'),
(493, 'cb1c9u58fhj5ts5e3ub5nm1ls1', '', 11208, 1536200566, '127.0.0.1'),
(494, '14gda352tbcvvt6spkvddgpb7n', '', 11209, 1536200679, '127.0.0.1'),
(495, '21lfm0tt05mpp0fqtffvitgj3q', '', 11210, 1536200697, '127.0.0.1'),
(496, 'svaqa8vfaeciquho1rheaen73c', '', 11211, 1536200715, '127.0.0.1'),
(497, 'kkukj31ule63qcfb028vu8r36n', '', 11212, 1536200723, '127.0.0.1'),
(498, 'o9cuot4seg6dqi2j6chrptm6va', '', 11213, 1536200817, '127.0.0.1'),
(499, 'c9jauha1hap579mf8in2avkkep', '', 11214, 1536200891, '127.0.0.1'),
(500, 'eovk7jektoc4hosq97fie42vol', '', 11215, 1536200918, '127.0.0.1'),
(501, 'p73dj46ua7r8reoifu1rh7tn88', '', 11216, 1536200949, '127.0.0.1'),
(502, 'jbesm8tv5qdobfqptrdbf057mt', '', 11217, 1536201393, '127.0.0.1'),
(503, '5ks1kac9t190n42cd3fcijhjq8', '', 11218, 1536201399, '127.0.0.1'),
(504, '7njs6n5i82nl2v255j0rh47ed0', '', 11219, 1536201404, '127.0.0.1'),
(505, 'c3s2dqbk22eh3m40to3mk1qd88', '', 11220, 1536201425, '127.0.0.1'),
(506, 'ih9emnmblo1sgasmd0er1pmm67', '', 11221, 1536201494, '127.0.0.1'),
(507, '23nu63mv4l8lhn9djc43khp17b', '', 11222, 1536201595, '127.0.0.1'),
(508, 'mjaetamg2lvq0a8aq8nibp9u7t', '', 11223, 1536201610, '127.0.0.1'),
(509, 'plm34a5gvcfogsaa52g6vv2816', '', 11224, 1536201742, '127.0.0.1'),
(510, 'ac5brjltsg8cqvdc6uulv52jug', '', 11225, 1536201761, '127.0.0.1'),
(511, 'dq8bfp4b9qb7h9nha1ebek176l', '', 11226, 1536201803, '127.0.0.1'),
(512, '90mvq74dvid3ff2o40mv7d0dmf', '', 11227, 1536201966, '127.0.0.1'),
(513, 'kocd1ro93i9jdlurbdnd7sko6h', '', 11228, 1536202009, '127.0.0.1'),
(514, 'vubl59skq9pkrnfch0g5lhuoc0', '', 11229, 1536202013, '127.0.0.1'),
(515, 'c180d64fupo82b3qfibardd591', '', 11230, 1536202064, '127.0.0.1'),
(516, '0ci88skqum7ufqa06076vqvjs7', '', 11231, 1536202137, '127.0.0.1'),
(517, 'kr7qnssppfog5o4dkqmoof5u0b', '', 11232, 1536202156, '127.0.0.1'),
(518, 'qhuvpcl73aadk91i0upgklvp5s', '', 11233, 1536202189, '127.0.0.1'),
(519, 'poc7arimp61b3p3v9g9junurmc', '', 11234, 1536202524, '127.0.0.1'),
(520, 'ropbd7u1k4m3didrenipu4icf6', '', 11235, 1536203136, '127.0.0.1'),
(521, 'trlmdcu3c9biqddmfuh809v0je', '', 11236, 1536203140, '127.0.0.1'),
(522, 'giu3vte82gs2ei0t3848of40l9', '', 11237, 1536203152, '127.0.0.1'),
(523, '18iudeuar06lak9cf5rnsu1ith', '', 11238, 1536203259, '127.0.0.1'),
(524, '5n695k6d5e61ojjqploae5r24o', '', 11239, 1536203637, '127.0.0.1'),
(525, 'h9qq53uo9c1h6tfhba6bdhhlkq', '', 11240, 1536203682, '127.0.0.1'),
(526, 'u40d4l9691d2jvoplcrq40crjr', '', 11241, 1536204060, '127.0.0.1'),
(527, 'pk7n5guidvu7u66o8tl7utagad', '', 11242, 1536204541, '127.0.0.1'),
(528, '3hluodavafnocemushlhpsjc27', '', 11243, 1536204765, '127.0.0.1'),
(529, '15qocuke7e80vlp89kv9d0gtfh', '', 11244, 1536204848, '127.0.0.1'),
(530, 'dcppbmg16t5u5q4ecsta4mvi18', '', 11245, 1536204998, '127.0.0.1'),
(531, '2enih9kvn7mrkli3dco8hak7nu', '', 11246, 1536205003, '127.0.0.1'),
(532, 'ushu8s4ad7ctfta4rv8ehdjcs3', '', 11247, 1536205020, '127.0.0.1'),
(533, 'p9b2c5l0ltfu5c2fga73cobhum', '', 11248, 1536205081, '127.0.0.1'),
(534, 'j8ni1s8oj0aj1rtpgjcpb2br5h', '', 11249, 1536205116, '127.0.0.1'),
(535, 'o6dpco95k71acnbrjpq5n0bk9p', '', 11250, 1536205172, '127.0.0.1'),
(536, '3n7vr716b5m4jp4qvkjfcceed6', '', 11251, 1536205541, '127.0.0.1'),
(537, 'c76pu43p3q8n3b0lrcucrf9mp2', '', 11252, 1536205590, '127.0.0.1'),
(538, 'tpt1i2i9bb89dufp9rv1drrs1t', '', 11253, 1536205629, '127.0.0.1'),
(539, 'jr3oq4p2ajiljijmmarqkoucsk', '', 11254, 1536205706, '127.0.0.1'),
(540, '772nhuspdvp2c638ke0kienrr7', '', 11255, 1536205735, '127.0.0.1'),
(541, '6f2g39u80nffbu7qtbn9lvnu0l', '', 11256, 1536214842, '127.0.0.1'),
(542, 'm8d1pg8aerol5v08o1um4p1r3o', '', 11257, 1536214880, '127.0.0.1'),
(543, 'ak7cubs1d31e0r6ucpr1ej62a5', '', 11258, 1536214891, '127.0.0.1'),
(544, 'm0r1it1h84d6d0kpsktp9vhtv0', '', 11259, 1536214963, '127.0.0.1'),
(545, 'phq1i2aa4v1in3vs977gbsabvb', '', 11260, 1536214989, '127.0.0.1'),
(546, 's4tu6mhbq2q54lsc0tkpr8964p', '', 11261, 1536215057, '127.0.0.1'),
(547, 'pb89oc9jhnv0svg28r607gnobe', '', 11262, 1536215523, '127.0.0.1'),
(548, 'vfc23h82r8sduejldk00vm9jib', '', 11263, 1536215553, '127.0.0.1'),
(549, 'l961jhq6k9pcodk91e5hgvjufu', '', 11264, 1536216535, '127.0.0.1'),
(550, 'a90hup6ridk63asq5t5p8gfb1f', '', 11287, 1536218570, '127.0.0.1'),
(551, 'fqk4ptqkddphk9k4bos6795c72', '', 11300, 1536219031, '127.0.0.1'),
(552, 'bcv95iuoahfgjlelo1bp9vh8gd', '', 11312, 1536219039, '127.0.0.1'),
(553, '8tio7kl83da4qtf7kdh64042s5', '', 11324, 1536219698, '127.0.0.1'),
(554, 'o7ckt6cp6tq2nq1msfckq6ik33', '', 11337, 1536219828, '127.0.0.1'),
(555, '4idds3pl1s5j4fnl81f04hmuqi', '', 11349, 1536219833, '127.0.0.1'),
(556, 'g3m7qvc3u48otjfsaroi94fut4', '', 11362, 1536220281, '127.0.0.1'),
(557, 'nmfebpc3t3ofdmp0ll9n8h9upt', '', 11375, 1536220465, '127.0.0.1'),
(558, 'b5tetn8dq5rsq8nlcq7i7venls', '', 11388, 1536220536, '127.0.0.1'),
(559, 'j4qrdr2ljnh4baf946nrb1j1g6', '', 11401, 1536220580, '127.0.0.1'),
(560, 'mp3fn4gjgepmk1neeaf9euscm2', '', 11414, 1536220594, '127.0.0.1'),
(561, 'p6uisv6n2u9rkovevvbc1n1aip', '', 11426, 1536220759, '127.0.0.1'),
(562, 'ldolalc6q3dlr7r6t5cvug8k0o', '', 11438, 1536220774, '127.0.0.1'),
(563, 'e69b9lnhq833iido88cf4a1dah', '', 11451, 1536220864, '127.0.0.1'),
(564, '947rfnrqpvr2ldt4hn3ad0h2v1', '', 11464, 1536222989, '127.0.0.1'),
(565, 'ada2tip44d2lv8tce6k6dhuics', '', 11476, 1536226103, '127.0.0.1'),
(566, '8n3tb2pb4pr09e9hombcrs8las', '', 11488, 1536226256, '127.0.0.1'),
(567, 'oc1h4koescbv1oatggbf5m9ktf', '', 11500, 1536226305, '127.0.0.1'),
(568, 'dsjmgr8c1v5psnjasjpu4kgrfk', '', 11512, 1536226345, '127.0.0.1'),
(569, 'ocu26krviq9pbnpqdprq0503dh', '', 11524, 1536226369, '127.0.0.1'),
(570, '589pr04njovboajrskjdrbccsr', '', 11536, 1536226411, '127.0.0.1'),
(571, 'ljejvctd6entgaof581up4f1mb', '', 11548, 1536226418, '127.0.0.1'),
(572, '7hg35gigdorlgomcltgh8e5k4u', '', 11561, 1536226468, '127.0.0.1'),
(573, '3ohpraapbea0ipgj5ctqicdea8', '', 11575, 1536226493, '127.0.0.1'),
(574, 'fn4moa20i5p92hkmv4le3afpf0', '', 11589, 1536226624, '127.0.0.1'),
(575, '3rf2nou82gh7mld4gu373certm', '', 11601, 1536226713, '127.0.0.1'),
(576, 'eekfakp20krq29ue9fnkrs8vnt', '', 11615, 1536226734, '127.0.0.1'),
(577, '1mc0eede844ggijgin3hr1m0ef', '', 11616, 1536227085, '127.0.0.1'),
(578, 'jqgdr7isvcg7kq9k2om9ug1afu', '', 11617, 1536227325, '127.0.0.1'),
(579, 'ah4g8tcohvjnacohb2jc1usate', '', 11618, 1536227359, '127.0.0.1'),
(580, 'fbe77uo565sfbevf7rbub2915n', '', 11619, 1536227938, '127.0.0.1'),
(589, 'ihm9s3a4tdhevvifs3gqgpqh3j', '', 10000, 1536490761, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `user_main`
--

CREATE TABLE `user_main` (
  `uid` int(11) NOT NULL,
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
  `sex` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '1男2女',
  `birthday` varchar(20) DEFAULT NULL,
  `create_time` int(11) UNSIGNED DEFAULT '0',
  `update_time` int(11) DEFAULT '0',
  `avatar` varchar(100) DEFAULT '',
  `source` varchar(20) DEFAULT '',
  `ios_token` varchar(128) DEFAULT NULL,
  `android_token` varchar(128) DEFAULT NULL,
  `version` varchar(20) DEFAULT NULL,
  `token` varchar(64) DEFAULT '',
  `last_login_time` int(11) UNSIGNED DEFAULT '0',
  `is_system` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否系统自带的用户,不可删除',
  `login_counter` int(11) UNSIGNED DEFAULT '0' COMMENT '登录次数',
  `title` varchar(32) DEFAULT NULL,
  `sign` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_main`
--

INSERT INTO `user_main` (`uid`, `directory_id`, `phone`, `username`, `openid`, `status`, `first_name`, `last_name`, `display_name`, `email`, `password`, `sex`, `birthday`, `create_time`, `update_time`, `avatar`, `source`, `ios_token`, `android_token`, `version`, `token`, `last_login_time`, `is_system`, `login_counter`, `title`, `sign`) VALUES
(10000, 1, '18002516775', 'cdwei', 'b7a782741f667201b54880c925faec4b', 1, '', '韦朝夺', '韦朝夺', '121642038@qq.com', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '', 0, 0, 'avatar/10000.png', '', NULL, NULL, NULL, NULL, 1536490761, 0, 0, '产品经理 & 技术经理', '努力是为了让自己更快乐~'),
(11652, NULL, NULL, '79720699@qq.com', '8ceb21e5b4b18e6ae2f63f4568ffcca6', 1, NULL, NULL, '韦哥', '79720699@qq.com', '$2y$10$qZQaNkcprlkr4/T.yk30POfWapHaVf2sYXhVvvdhdJ2kVOy4Mf1Le', 0, NULL, 1536721687, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'coo', NULL),
(11653, NULL, NULL, 'luxueting@qq.com', '37768ff1f406a7ffeb869a39fb84f005', 1, NULL, NULL, '陆雪婷', 'luxueting@qq.com', '$2y$10$YpOrL9dehAD9oo1UZ2e38ujSd.TuC6yV5eq2yQp2knLBpU09uomiq', 0, NULL, 1536721754, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'CI', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user_message`
--

CREATE TABLE `user_message` (
  `id` int(11) NOT NULL,
  `sender_uid` int(11) UNSIGNED NOT NULL,
  `sender_name` varchar(64) NOT NULL,
  `direction` smallint(4) UNSIGNED NOT NULL,
  `receiver_uid` int(11) UNSIGNED NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `readed` tinyint(1) UNSIGNED NOT NULL,
  `type` tinyint(2) UNSIGNED NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_password`
--

CREATE TABLE `user_password` (
  `uid` int(10) UNSIGNED NOT NULL,
  `hash` varchar(72) DEFAULT '' COMMENT 'password_hash()值'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_password_strategy`
--

CREATE TABLE `user_password_strategy` (
  `id` int(1) UNSIGNED NOT NULL,
  `strategy` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '1允许所有密码;2不允许非常简单的密码;3要求强密码  关于安全密码策略'
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
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `verify_code` varchar(128) NOT NULL DEFAULT '',
  `time` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='找回密码表';

-- --------------------------------------------------------

--
-- 表的结构 `user_refresh_token`
--

CREATE TABLE `user_refresh_token` (
  `uid` int(10) UNSIGNED NOT NULL,
  `refresh_token` varchar(256) NOT NULL,
  `expire` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户刷新的token表';

-- --------------------------------------------------------

--
-- 表的结构 `user_setting`
--

CREATE TABLE `user_setting` (
  `id` int(11) UNSIGNED NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `_key` varchar(64) DEFAULT NULL,
  `_value` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_setting`
--

INSERT INTO `user_setting` (`id`, `uid`, `_key`, `_value`) VALUES
(1, 0, 'email_format', 'text'),
(2, 0, 'activity_page_size', '100'),
(3, 0, 'share', 'public'),
(4, 0, 'notify_other', '0'),
(5, 0, 'auto_watch_my', '1'),
(6, 10896, 'test_key', 'test_value'),
(7, 10897, 'test_key', 'test_value'),
(8, 10898, 'test_key', 'test_value2'),
(9, 10899, 'test_key', 'test_value2'),
(10, 10900, 'test_key', 'test_value2'),
(11, 10901, 'test_key', 'test_value2');

-- --------------------------------------------------------

--
-- 表的结构 `user_token`
--

CREATE TABLE `user_token` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `token` varchar(255) NOT NULL DEFAULT '' COMMENT 'token',
  `token_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'token过期时间',
  `refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT '刷新token',
  `refresh_token_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '刷新token过期时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_token`
--

INSERT INTO `user_token` (`id`, `uid`, `token`, `token_time`, `refresh_token`, `refresh_token_time`) VALUES
(1, 10826, '9c5a77b57ae2fced9acf03e6c0869e9f60f46c50dd0314c6278d2a13295fc79c', 1508330460, '2491507bd4d5cddc748be078c6dd62a4d16010e49008c47bab9a49852d8f1829', 1508330460),
(2, 10000, 'd844922cd026f260b1b112aa7d4be2ed21678f6dcbb9e63a30139dd4d65b7eff', 1536490761, 'e8ee67570e1330597216ffc50c8df3090be0cf479c445a35e4530d1a2b91a979', 1536490761),
(3, 10833, 'f3c6c5459ffbfe40262e7a2b978ba72d19d128d14a4270abd5f3e293df551c91', 1526956546, '29c53ac7d3e115b048de0ac561c32cefe9a9e1e63906338a4982eb203ea437d2', 1526956546),
(4, 10834, '2603f7b09dccd002a297f3984c5208c7d3d45f527264e1ffc7623dc28b3aa83c', 1526957444, 'dc3ddd1665ff3e344b00a02f971b96813783a3179e44f89665ed84dbf9f7675c', 1526957444),
(5, 10835, '374ea66c9a52c0b5d85bfdee09bace6f1454bb49f742732ab585069c2aa19cee', 1526958149, 'a1713a5570e445ad114d6d339ca200f88ff47a9c08155a492402c7badf23044e', 1526958149),
(6, 10836, 'b3caaf6059320b93475c0bd9d057d22419fc1669ee34e7f321c0def15afd7462', 1526958329, 'ff1ed1f094f5a8c7daa6d13c8a2bde0eb7082f082dc5311e543790656e502185', 1526958329),
(7, 10837, '24600e0dddf1b345d7b9ce31a5a3d94ab1700ab6e13e138e75384faed64187be', 1526958379, '10b162616dd34d3c9b667e7dfb0458bbdffd2aa7f450d38d99f01d5aa4560cf9', 1526958379),
(8, 10838, '38a5df844794e1b04fc04827a0247a0ac03b09d928eba2bb2b9d3ef2c99ce287', 1526958387, '5f581984938f15d80e64702a293354f9fe34f67173abaf986eec03e5de078be5', 1526958387),
(9, 10839, 'a443bcff2d18851723882f7a56f456cc4b7720ffc3763272ee70ab2ab6093d90', 1526958437, '9e8389d42b680d54f05c0cdd691f11cc993b57ede652125519c250a0b4958513', 1526958437),
(10, 10840, 'fcd55c02d0d11749b4b961c03fb5b75e106017f6fbc7513c8a79068884f69514', 1526958463, '14194a610f72167667d686086f21b5524cfdb27c82487bedf81d12a9377bd1c9', 1526958463),
(11, 10841, 'b7d5a31b49efd5979cd77797353e33f29588057291f764920e6aa3b127c028a9', 1526958474, '3d12404f70a0cf4dc3ddd7c02ccd46a67687c513deb01cf6f59de23e46c8a199', 1526958474),
(12, 10842, 'a276f8e7556f073dd93b637a3c09d132407c94f6f572f45cbb68a148a3e8d428', 1526958493, '37edc033728792af34cfd178020e9d84936230ed5b3318d97779a2e1f5bf28d1', 1526958493),
(13, 10843, '02399cf94d8737e02d205aa45954a0cc7ea064216589737c435c2790890a0ab5', 1526958587, '84387467309b78df8d05d839a2427e849c78ecea7c8a54c79550773aae7f4a33', 1526958587),
(14, 10844, 'd85be62854579cecf292427b008f14ac3d5f3b4d12c05e3087178e02b2e454b9', 1526967952, '61840405407a35fd995246b824594e61bd373a90cf455722c48e98f49f2b5478', 1526967952),
(15, 10845, 'c9b2334727b98c0d0815232141a68193b19dff8d521e3799e737a0f24dd057f1', 1526967980, '9f6f932ed0c70be1a7466227952992551acd1b52d4e4222cd87838e5da4421bf', 1526967980),
(16, 10846, 'd6b733fd1c7a8502372e86ae102302895334903acd07ad07ca0cbcff5b35593f', 1526968359, 'da7904c42bce1eedc24595692269bee446d6da013d093a23d95a5b91e9d434d4', 1526968359),
(17, 10847, '8e3f7154da8fd0cf46d6ad5c54f60c467201ce85356eb97cba21b854056bb396', 1526968573, '8c51f31e0098f42ef3ef0c701b6ae35cc9b4a29df354953073a0451b61e3988a', 1526968573),
(18, 10848, 'e9b8184d2237adcccf7ef6fbdea11019ed648e3443fad1e68876975074c29619', 1526968581, '7c042fd2eaf2d0688579758165c5de6085a81bd7194399b7f9cda1a1615f1999', 1526968581),
(19, 10849, 'ae4547d64d47f23b9b3dadf0295a810891a0a44916a1351ae5c27a94e49a57b7', 1526968948, '547466bb2b6282160dd60a1dbf58cb74aa5a04a184ea9f2644c3e4014615b68e', 1526968948),
(20, 11573, 'ce321fecef17d0d4f4e6e6fa25d9b14782b00c0e70d5dceb26ce2fdf2494ba25', 1529478153, '34949bd4b7370b809f4ac987f71fa0be7b764c43783bb0b364019f7132ebf1cf', 1529478153),
(21, 11574, '260cc279c69f3435fd86272eced4f30420b1626ebd959bf681a4d29acea1810f', 1529478195, '44cd0df803ce1769b9750056b7f5fdde91dcbcb815a162b9c7a0142c393914b8', 1529478195),
(22, 11575, '396daa739a54dd03d9c476a7b68671e09f97e35828f7732a3f053f8d40fbe195', 1536226493, 'c8b9a106f0fe97ddc08de0e8aa5692cf635a15ce25ff03b2c6919be4f8a7b680', 1536226493),
(23, 11576, '8d81944a8cdaf696c88a0ffe1506ba06ccec4cff5f5cc24a0baf2358e44b2228', 1529670759, '5c3eae7cd105aae5a896f8e81851b7cb37af83715809a04a468b666c07613b90', 1529670759),
(24, 10968, '2c1a0950bd6197a90dab07a160dae929df712a5f91cdc641a5e6d03373449f9b', 1535594712, 'f9cf48fe25bee1012c68474641ba8396cd4c899949474585da8b4b4d1c352f07', 1535594712),
(25, 10969, '04977bb6049a5cccf66e2ec777120852c09882a3615d4b6c9ac67dce8896872f', 1535594719, '9cc05ac80a20b9068d561a2a40a9e3ff4ec8de7c4254ed52405562c352be2abb', 1535594719),
(26, 10971, '0528bdb40f35fe73cf4147d48bb7e6bb2235ca5a21b20db1ce132fefb0c34276', 1535594722, '5d3c9aa35cdd21102875804f9bc595300efbe86fb623dd9b8395f462596b558b', 1535594722),
(27, 10973, 'f6c2c4c603be8e61789c1ffef375b35132994d2b4c3082b15870893dc6eaf4e7', 1535594759, '135ed7e824c6b47e00a64f361b9dc51263efde04f1fa8b1efff42965d3b13e1a', 1535594759),
(28, 10975, 'd3aa52d753ffc12f198ca8d7e7db209536ca28f30a11b45ac1a26598b9b36c30', 1535594788, 'c1d271ec81f4bdf5bd9ac4d7fff143962d1f9f9a6b582ee2d6b89fb5faf848c5', 1535594788),
(29, 10977, '5893f8ad6bf0d5261c87cce2eb6f2ef33babac7a5603c7885482d25120e94ec7', 1535596617, 'eca5492ed429c7df097099b55fa239b8b67992fe84b5a8de44704e55e8740131', 1535596617),
(30, 10978, 'b22b77e2ef519234b2795706fcd92098a8de62c1d9321ef2a506462a81fc8e32', 1535596658, 'b0cf76008431e94d714076a211acf67679f8f68080b643b07ad273edd2bcf826', 1535596658),
(31, 10979, '5a0b67c16f0ef3c51fd14eceb8957446678f1068d593b7a4e7d68556b62fab20', 1535596677, 'fbf008aa1f9883bf53dee208d385ec1ee3776623d2bd3a127de35119b11eaf5f', 1535596677),
(32, 10980, '657d67b036d5013fa566de516ee4c3d26aecc26845d57990b4edda7b8784d800', 1535596915, '83bcf5c4e6e2e233f293165114e714a58501b990d56b4d4a974f4821707dc971', 1535596915),
(33, 10981, 'c99c61bdc5f6c0c17cfefbac951186729eed7ef7f4d72d3718bcaf58f2137347', 1535597039, '7bda4c57470fd4678184e7d042182d2225691290cf5eb91306db931652b3b818', 1535597039),
(34, 10982, 'c01ff6c660f41dd615fa18280d74f8a7c9559682cbafbcbbd73de74a2f2ec385', 1535597093, 'bda501718056ed18fa251e955bd66dfa8c544f992455f03a2abe48a1ff7d3307', 1535597093),
(35, 10983, '343b2f9c8bddfad2a143845eb7e17d4b4a3dbecdf2001b11df3e3b257612cf9f', 1535597826, '81daf706b076aeefa9587b02b8d4e7ae7c1eff4ae9510c1a20a0e97d648a7649', 1535597826),
(36, 10984, 'dc4d040b441b6c5073450fca3b8223f6c6e7d57cd030d63a16899f9d05b78444', 1535597853, 'f7e80dd856a692d61cf2afb5dd0d03b428e1c7c61363e9bc2625c69675fc1a0b', 1535597853),
(37, 10985, 'de7b294877845cc8a1df76edbb13b580c1e81981736bc36a50f2cc570f042119', 1535597902, '61314f91b7785545f55afb2e662bbd641e8a0b667b630ff9ba3e3f679feaeeff', 1535597902),
(38, 10986, 'da0aa8f74373cdc58cd8dfc5ccbab652c5223773cdbd287e0c0435fb9d6e9734', 1535597999, '91a415a656710d7833eaa4b9b136a4b9e85d82534d6be3007a446ef6975c5f7c', 1535597999),
(39, 10987, 'a20b700bdc76205752bce13e33067cdd563a2eeb9964acceabfde141f2a73c88', 1535598292, 'a78fb38553dea15ed63c13dff793ced1683561e9cb30a0e06b5b6118d663e703', 1535598292),
(40, 10988, '691c1d648411c05bbf1322c7c9f5e1fb8c4ea073519db1edad43026ee8f39efa', 1535598365, '930fa2873f7d2f54c7d0b7de37c4109553abc1522887d581075e7a7dd848f189', 1535598365),
(41, 10989, '3632289cf76b0956c8379232c07f26954d0a6e8a5a8c2891428c96679202c8b8', 1535598433, '3acd2f63be8c643d323e47aa6100b159651a71c601fed20453125e57538bf0f6', 1535598433),
(42, 10990, 'edf6c76962814ff6cc8da45cf071b9bd1f8c59d202c28b66b66f24684154812b', 1535598482, '94512f11373ee85a0ec19b553ed2f7feb9911bf57b12ffdd0c60b38bdf81fccb', 1535598482),
(43, 10991, '1321cffca0d4237894c852c8494426d018bd2a2071a4d00e2c144cb0e11b4c56', 1535598540, '7e3918304841d24c67532853388b4880505fe6b38580df0469a501b8465c8d6c', 1535598540),
(44, 10992, 'c1a2346dc9d0c1594bab3b986b3d00074535b743fab830eed695aef2723adee6', 1535598565, '28ac86f6e8970f38f6e0946631e5bec940a758fc55110291b408bd6c2d147c1e', 1535598565),
(45, 10993, '6118cef0d6d90933bb338b71cbe42540ecc5af12acf7667132394ec6081c3a71', 1535598786, '22c9a207b218cf9c4e961beb28fa3dec2bbef0a94521ada05f93e4927ec1194b', 1535598786),
(46, 10995, 'ea419194e8cc35b9e580b02c63c2ccdf2cfdc73ba9dcb1066ece3edbea88322c', 1535598984, 'd9be15870289319b9fab5f402009565abd8177f2e431feb5d7ae1b5d411b47ef', 1535598984),
(47, 10997, 'b8dab9e381058eefdbf26181afc800cd773aa79fbaf40d5c9823d55374df5a11', 1535599221, '5afbe324631a4ee21bac0cb6937144ec513b88727267605a8316b7cffcbb5031', 1535599221),
(48, 10999, '5a664e706ffcea24f689900b2c812bf16ddda15f63dddec115cc95e6cc7edbe7', 1535599286, '862eb85c87bcbc3189fec45c2dfbffcf92420d6ef2d7ce8680e9d63a99d46f96', 1535599286),
(49, 11001, '1dbc1367e66bf2d7ada11df76c29cd58440af1f7902c79d3f55544523f04d2c7', 1535599470, '846e250baa68b5dd1aed11b0f2e0ac3202bce44e0888cadcb2588bb109c1e721', 1535599470),
(50, 11003, 'bfd0efdb7381e3b85783b81b2e699691f687913112dad16abaa786b9458401ab', 1535599499, '5bfc52850f7b53f23c6eb0a2f4642e8f3bb5a69d02e2d21eec9ef251a6fc52b1', 1535599499),
(51, 11005, '5a105d07fa07ac43636daab10011745eccf543122d586ba1fd50fbbd66a7cf02', 1535599676, '9885dedee93de30654bb7817f1b077deabd3971144882d9029027892810c55e9', 1535599676),
(52, 11007, '3ec2909e507fd0e189bf39fb7d951602683bb85f0a995a7be8112f0b938e9fc3', 1535599703, '9221343762e211d4bc40e9ce124a08ee14a7c828ce822208118561bdbfd4dacb', 1535599703),
(53, 11009, 'b13e841c1942ace87918e9c5dbf0343884eafd4113a2e4fc849e2b03a254bda4', 1535599779, 'f9dcf056ad4b68c90715ec1361cf70a6e8a3f0328175c9bb54c9c6a569d88895', 1535599779),
(54, 11011, '9502c7d0e701c7a3243bf484e0f32f39ad9a1002c02e62698719c7078b9c509d', 1535599815, '36d80e8a20357e2d2992686f713dbd945b1fcb5f0f82de34155b1af3287e6bf9', 1535599815),
(55, 11013, '22b403fff3c3e7d3c32bc57c3147d4af3183754e5a49926c94c2fa76c6fb4efa', 1535599902, 'f87b5c3dc48b37b753a6a5d813ce463c624ecd4c8a5026e47a4e1f9b13e83fff', 1535599902),
(56, 11015, 'ac0d00d0ea497cf7de38e82c1d15c191ccd00702365cfac059a641c61c8bcfbe', 1535599943, 'fdfcbc30ca86f046a4dd932e123fe4820ae252f6004f863a03183213e2f65513', 1535599943),
(57, 11016, '4fb5930e671944ae967ccef40a8e8194640a484ade5e9dc891b8a4728b7a0ce0', 1535599943, '62ab49005fcab85e44ea04145e0584ef3de89a6be98b7d6dafe3c43224f53963', 1535599943),
(58, 11017, 'cb3ce3377c87ba6e108145ac90d66fefeaedd9341d067e50a610abb4473d44f1', 1535599961, 'e7db4b18d3b2f6d21167c5eba0ad9ce80be0f7197d7464eb30d1fca083cfb460', 1535599961),
(59, 11018, 'edf331c684fdb0ec0bce99d75dc22748dc2c0bb31c00767bb7f5aa5f8131919c', 1535599961, '082bc25d716723ce57dda4c97644459c9ebc12e613ce1cdf6e38fcb9aca27876', 1535599961),
(60, 11019, '1a093962d3eea0f87d676482a61405bd77212e2a2a204e65ccbe9e021eb6d1d1', 1535600001, 'e09c8d6069e085b472b3d1a7b2380a2dfd1696ee9700fca137cd809541dde750', 1535600001),
(61, 11020, '80115be25a95274af62a7942bbc71751be95d7217414a7e92ce96cf6752c1b7d', 1535600001, '1b6dff3ecf332bef7545b05f789c3952fe218393f6fe63c4fe44882d936c9070', 1535600001),
(62, 11021, 'b0c31a89ec3b25f0dde70cffca349e5405898432210bc74396dabc5021e54182', 1535600031, 'd337b140b62ce6a66b27e1e9557293053384500e6c245d65d71cf0eecdd99d36', 1535600031),
(63, 11022, '684afc8ba748a5c5d277a01f821cc61a03c5cf03f335270afc99fe7a6904c9ad', 1535600031, '2130598d4d7954fec7ecb919fc17964c552cecbc076a9af3befa4cdd9eb9975c', 1535600031),
(64, 11023, 'dc333113df3eba170a15f677e8190d8b4567d732270a3e5b485d56017eec0bad', 1535600103, '4eb20ca1f9cec28fbf5aaf2dd43f37ce9b1dffe09faf2387a8b45c8aab46c4a7', 1535600103),
(65, 11024, 'b1bea99a4153d920cb55e9f1e3d648bde81f314d39adac06bfad946fd041de4f', 1535600103, '9e669f8f65e50b04c32c6edba6eb3cf1ae22049f69b988ee7d28534fb3b20490', 1535600103),
(66, 11025, 'f49ddace94c14cf61fc2a5f4b4e657058123dd5a497c43febfb722a85b2a9d54', 1535600259, '8d695ebceaf8ca98097fa742554e9dc172017d8300b9270cf09ccf634dbc2f9c', 1535600259),
(67, 11026, 'b9af86020f89d7018bb7382ada6ff1a5b97a23d2ffd97b3476b90a051dccf85c', 1535600259, '7c71c3b367d30dc67753d89de964d7f32cbe0999335b7e753469c52461518c60', 1535600259),
(68, 11027, '6bba0a997b33f8d8399a1a49bc597b6e3b996555b38f40989256ca240a00fba5', 1535600333, 'daa8acb8d69ce74929883fbf86123794d0a475ad323942c9b9bbf2eb23ec6387', 1535600333),
(69, 11028, '9f8336699df35490f9e341f4bd4f08904146c2b422c688957f36eabb97ae9c90', 1535600334, '2345e7cda6f95c023abfa038b879829d0abbe5fa27637a43380f9f572c5f63d5', 1535600334),
(70, 11029, 'dc49ea7cead5adc6b9deecf866c4b02dfba773e348d189408f962e965b06aca2', 1535600422, 'de71317e7bb51793cc9f43a5bc23ef1d6c91924e34fd4ae3d19716d4a71368a1', 1535600422),
(71, 11030, '9d11fb090e94a03e270ec4ebd1c8b2deb55969c010cba522778441d7d4f5b387', 1535600423, '7af1577b326904bfdabef1874c72da56408f9094ee431a48be44a1ea620755ab', 1535600423),
(72, 11031, '497ae29365c52fa13ad6eab6c3cd935ba29a0f8aba88d8b96928cf9454570e9f', 1535600609, '91feace76401ca0f27cb0ddc17a28607f74527757418015bd5ad5b58da22e685', 1535600609),
(73, 11032, '5377e0133a3e69a59c9c399c54c49bce85f276285221db84cbb2befe6862c064', 1535600610, 'eddf2476bb2fc1a26c1e59ccb198727a2f1f2d4f155845e4aba1f51ef20349d7', 1535600610),
(74, 11033, 'be941461ca731c128d1c54c35bb9899d54ffdf7b45796e45f4a397c2cc1a2bc4', 1535600631, '751dc520a0cf34f75f966c3f0f1783db21de39133065de0eb49c62a3898ef3d0', 1535600631),
(75, 11034, '6cbc35d03bc2dec56a1e0096f529e070f9690050aab181b06eeafeda4c89e61a', 1535600631, '07357962a9341493e67c247bfd9c174e2f965c07946d271244a34f9f5a501d41', 1535600631),
(76, 11035, '114d54c7c282f6ea516f95ec651e8bf3cafe49508025a3557d8e3125c589f750', 1535618230, '7c2eadb1edad1ed81cd78004efdf6569899eadc01eb3e0944eb2dfa327c058a9', 1535618230),
(77, 11036, 'e80209fa6df058e4a95c7877181acd3c1d549161abccb565828ece970f629ff9', 1535618231, '549c9309907154cb90ceeea0a4661abd9876246db8616fcbfb83a83b0e8d54df', 1535618231),
(78, 11037, 'ab530c9781dded063c42e5fc674c4dbee5d9fabe5cb01ed4c6d439a3ceadccd8', 1535618306, 'a4a131f0c929caadb4f8c31796c0494f6efa5ebbad5801d72462e9acb0af152f', 1535618306),
(79, 11038, '7c347e4b222ee9619274b746a4259d7117f080472c31ffe9d4cd539fd334c27b', 1535618306, 'fe0a2533cddc970d27da67b11726774190eba7373124eb58134984c36b679174', 1535618306),
(80, 11039, '8eec001a21bfbe448ab9e18300a7b78879f57be854426d1c48f39482ca4ded2e', 1535618325, '9eff4563a5e3196317ce62d68e13dc8394e337ecd532a8fa4520c141022512df', 1535618325),
(81, 11040, '58bf313ba9e0691e694312c9aea9ab9ab8c0adc0c545f3aff07bba1c846a6e38', 1535618325, 'd73e6a4009b1656fc52739b983f79f52348a1662ac3a6111ed8c6b3ebe83b79f', 1535618325),
(82, 11041, '7da89281bcbbcb83ecad046ad11900e8c3917189f7766ed58c6b27d0741a2915', 1535618429, '1c8e5a9f7f0a07f97b2fd197b45c28ead4ac048da691f0d14f9d71d4912b4d51', 1535618429),
(83, 11042, '8ce0a7b9e5aa3e30beeda763d9c6d4bcb1c668cf383545a6242ca8d2a1c1d8ba', 1535618429, '82f32e4fa949811688cfced37a8b18b12b04224b34231de87180d475600e3a0e', 1535618429),
(84, 11043, 'c4422d666c76f12c1e40e933c16747352fe77b9b21865ee56125f51fcb0daf58', 1535698314, 'dbcc3a42199f70d9bc4e4a33178ed83387bbf904391c4e3f7e3b0d195abdc5a6', 1535698314),
(85, 11044, '06693e8f8d31800b84855668b7e43c2d4693826dada762a18c357be48615f558', 1535698314, '52814e3352e6a393a0a946a102bda3c58b1b505b1cc83159fff65597f6751e38', 1535698314),
(86, 11045, '99c70989a9bd544fa1f3260e9ee952520ae2816eefbfde580328e684efa07b79', 1535698344, '9f13dc795c73696fd99f8c3854c95740778dd83087a91ef3abd5e91d6c42cf9e', 1535698344),
(87, 11046, '82eb5914944ebcc49eda6f3783b8d2aacaaf9f116a82a570701102eb0e3d8376', 1535698344, '83296020373f07c1495e26cbd0093b588c91bd959c3b1a5d93c60d2fed56724f', 1535698344),
(88, 11047, '8143ed536f8092755227fc697ac1ef2ff9ac91413413b364fb6565828495464e', 1535698463, '3bd3bb6fa704d2c0535455dfc36f5a37c18f3d3c8113d1265adfa42955a92195', 1535698463),
(89, 11048, 'df63ebcf7d0f03ca40631760ed016053d50354a482192dd6e0ae0d4a8efb356f', 1535698463, '1302a5d432cf86e15977041f18bb898af0cd459c8598465cce54799070fb1689', 1535698463),
(90, 11049, '16dd0aecbf4ba355c1427096dc691b5eca6ada3c1ceca8f320b8f9c164b2b88b', 1535698631, 'ddb298b49942e7c547a4c94af00965bcfe2d138084f99c3fddedb39c289fcc90', 1535698631),
(91, 11050, 'd21fe4b96837b69c900c836f6d4ed004822bcd81f4b43475c965057bb473891f', 1535698631, '27fa9fe1272b908cb030e24d0906784d566e083d5a264c96e49728757fbfdb21', 1535698631),
(92, 11051, '1941bab6c123f35e759d53d8a0645bd76cdc0c3f9469c56be355c8761ac534e4', 1535698687, '6c1ee8b94f37580648a90cfedafe514b72ab889626dbcdaace3bbb7fae518535', 1535698687),
(93, 11052, '69aa8e874c42920b43e616f55f87f016b51eeb138762c97ad9b05fbc99ac793e', 1535698687, '987f155dc5f3df649d1f7829fbee0774ce6a8dfc94cd1cdb6cbf4e2f0c0f8d47', 1535698687),
(94, 11053, '6d6c6abb0ef6651a662d3d2a21ffd55188309ff5b75c860d8e190c86d26e9fa4', 1535699247, 'adf30712f67a636d9d86e736440f09c7dc76c091e5fa3114c6dfd087b1a6a138', 1535699247),
(95, 11054, 'c52a15912a64c400ed44f61d69045a22215e6c017e03bd6267afc087dcac6938', 1535699247, '6324c7fd5f5314536d6a28f97e17235cd6c2b242892ed6e6d8425bb4a70e2410', 1535699247),
(96, 11055, 'c73e70658d49b1fd06ba3851e3fe0214334f40870c1e3ac4f410b2f4566f24c1', 1535699320, 'f543411b7a40678b67988763e813cc90b2b793cdca49f0e4ac5db29133da1a3a', 1535699320),
(97, 11056, '974376c1bda9d141a2def41b80c7b06b25a3e4b4331b9018cb9d7d885d55326b', 1535699321, 'cd16223f1d8917ef09c2bbe1f6e37f994a2aff21f94db8f49ebbf7e06de27b92', 1535699321),
(98, 11057, '57844ab1e6dd6d81953171b4ed2ede0cf8c4c733055dc59ed854871600774eee', 1535699385, '0d70abfa70a5ddb045f53b1b190cf4a146e525f47d945032af04abbdd1a6a221', 1535699385),
(99, 11058, 'efa9dedf13cb434fa83bc45b934541d6d5a3616589ea8e9f6326caa9fb51f28b', 1535699386, '80e45e66e4b6659a42db8a4560c6a3deb041076ccca00c1cd5af5e1d0a663060', 1535699386),
(100, 11059, '6cfecb0a2c45c67201670ad44b873e60b6e859bf914270ec9b0432fd9829fcaf', 1535699455, '82fe8aad6e42bc18e125c52dabc93dfe9e6302804d03043b7df7bcd1d0c3adf7', 1535699455),
(101, 11060, '8cd955df112e2a21a322e23a88a735d747dd1cbd85d897a8d89f80dc18d51be4', 1535699455, 'd88037e29eacb2ae6380170552e5e6e6cb7e7aa1ecdb082581dc40853d84651f', 1535699455),
(102, 11061, '9ffd7f920c62de60a07fb4ffc483d3c4f4b9e5e22b1a307279fbd2693eba42b5', 1535699499, '99ea52abf968a06730bcc6a82651b084c1a886f6117ed3d2e51475a2337e0f9d', 1535699499),
(103, 11062, 'd3196832d32a4c5ef2c618deea111338c4f4d219ab49009611654c98190a7c21', 1535699499, 'a7ee4ab345dae0144addcaf017eb7078d1465099440f71c7bdaece2d8e2b2207', 1535699499),
(104, 11063, '273219eff100db686a4ea638ca55a800a585c449cae2d2ad5b47684c9b829995', 1535699567, 'd770c4dd07c383f20d4318ae4b2ecec212fc2a86b0a804d09d15c596cbfcca38', 1535699567),
(105, 11064, '0db9bd233c7c1720c610efc794dbfd71cafab6207507a497807a67ba8cc73eee', 1535699567, 'cfba5f02f4eb0e299db91d721b35b2aeb0842ffd21b8a496e2b63452d342d2e8', 1535699567),
(106, 11065, '5b6e9310a7c837f67e8120a1389f20dcd437f9330fa60439213059b43e2786fc', 1535699645, 'cc2326c1d50d3eef029bef9880c94ac5d89f826cab79cb5f717eaba1ad22eeeb', 1535699645),
(107, 11066, 'acc683bcb2123015a79cb141df48dd7e4d3b5bd5188d8be6c2166f7761685327', 1535699645, '59c9c046ca33f0ab10c496dbcc28e5f38b001de52b39d2adbf8663340e6403de', 1535699645),
(108, 11067, '87cf1d424df913ac471d57effe857d6f419e0d7d0755a09812c002296c9e29e5', 1535699674, '63fdeb40bb7719351800d650fe23cd632ab7aa7c533612e13a405ada912c768f', 1535699674),
(109, 11068, '1c801d90cb6a28b752baf8240414e25941462778b4a394988f782be8e4b943d8', 1535699674, 'cb524fead6d813f87d9018784b627e65f4e4cc241a926db506e08a38ed98ff23', 1535699674),
(110, 11069, 'e021a49d8cd1c78801abe75247491646334a1e3c929a3ac1b7dde36e445277a0', 1535716801, 'c5ed39d5d6d9c442d26c093db8769100a04db87ecec34461ee03c45faba9eb4c', 1535716801),
(111, 11070, 'a3a5faf9cd6c7c3b962e6c549a0d9ca969d833c5d908d24f0f2359e319efc5af', 1535716872, '7035337690691fe13fa54277314b0e28d8c3b0fa0253c315312fd13d30258b6f', 1535716872),
(112, 11071, 'b2d867884bd86bb6177a8f8937d524d965bb65b5d3abecf4a9ea28264e6efa9c', 1535716909, '74583f7e776f860f1b28733e8819c6d8dc62fa1278e365aea0034c1753e09628', 1535716909),
(113, 11072, '17af679b4380a56f4da647fe1d73912c95bc24cde73b614ee61fb5d8b013e3b9', 1535717083, '44444f96ca5cbb0aeaafeea515d88ff996050b26e49456c525707d857cdc6b0b', 1535717083),
(114, 11073, 'a91994caa04e2f5519a7b862f7ebc32434f088b5a2d742f7f3ea275162d39c88', 1535717104, '98fdc927db5268d1546a4db5d1d0a4a575f4d3495630f99c53d092b0a2dc1f7a', 1535717104),
(115, 11074, 'aa626c89bb9da871177684e87eec42f7c8bc4fe7548512c9048b41100e02331a', 1535717145, '6c3613fc3fef53602e821f8e5f9a30f2693abb78e76323da9bb7fd9b1f486013', 1535717145),
(116, 11075, '1d582f32ebc8e2f21564a3fa1b6caee5c5dbb4cbdde0ed0a6f587ed47b9ab0a2', 1535717196, 'e067c4c336806671ce19d5ae1860cedc8574ffdf4e1594d24be5a9621a35d6d5', 1535717196),
(117, 11076, '4b3bd6edc94f6702ecf3963a762ee732817b4811ed6c23e306a3aa4f966588ea', 1535717322, 'e7ba0ad0a1c6b77cdf1603d52dec9aa7352836b70400107e349a9f23781d87c7', 1535717322),
(118, 11077, '23303f7645aef7ffb6a0b8ae412df6236e53c203cc22cff0520ad288e732d887', 1535717334, '533158dbf6e2f017fd457dd08c3c679adef1151688d3377196ddc7d4b276846d', 1535717334),
(119, 11078, 'c1008c9d6698517118d89c72d704a29223b3daeb249704481e8dbd4eebeb0ff4', 1535717348, '70cb7f967d85b27ba634001314dd738a74d17744268ecede7190f80500143f86', 1535717348),
(120, 11079, 'df76278ac04470940220f5fc8e345381f2422304962607c0a1c02aea6860819d', 1535717370, 'bee87a54030569e246d812cc17f7086a016c26f3a000e1c966122bfb7fa9538d', 1535717370),
(121, 11080, 'efb17ad22fedf88ff1a546e75ddbeb862a6d9b8036dea9d35fbe85d6ba9bd671', 1535717403, '4a369007b533554a7291e6962baf7106abb5fbfedd7050413f07e18d8eb441f8', 1535717403),
(122, 11081, '1e2c2780d46054925047e9e8a08803dc220ee4779b32da879745df01adf63a7e', 1535717422, '380d512b01e3740911ad7ab73ccfdf02c1e14d63ac53a36d274067dc2713dc33', 1535717422),
(123, 11082, 'ff84392b6e32993da6c4d408b678ceb1876f95861cb13c73fc5cb7537301246c', 1535717451, '047f1fb0f6729092d1f6c1fb3c42a2d713541a9eaa35f41395c78dcae112e360', 1535717451),
(124, 11083, 'be74cb157dd3db110a18b4dd1ca07c13493d8da98b58879cbbc90be6a413bb0b', 1535717538, 'd4ab08727355b9b3eb1191435d31cc083785b5e83f25a400eb8715d34a8671e6', 1535717538),
(125, 11084, 'c91f3f679fffacb4e5eb64742b563f9fad960dabd421cf1190cd31481451d739', 1535717563, '6b3683f6d9f71a35f8e47cfa162fdc0ae94986ba135c97a2176d855cafa2af55', 1535717563),
(126, 11085, '8d9f5360ec74818e91d7f0f3ac62ed3c95ae42cd6c0767a48274b484fa54ea15', 1535717590, 'a087adf94f7d9821a34d3a3ccaa0947d1f152cf643ee6ed253e122956acddd9d', 1535717590),
(127, 11086, '181a93e301697dfa8e4e48764126344160750dfe869aff2c27aee84d2d439436', 1535717665, '7318aeb3b672ba3d97431fb711e7951ab5731cd13ce4916a2fb95522bf109ee9', 1535717665),
(128, 11087, '15a7bc1f904bec1a5d4d9434d318b9bd0dd1a5e6447548c3fab39b855b8a625a', 1535717717, '74d93bb49196a5a4776328c156e72a8e8d5c96480cdd81ab6f093b8140ac5380', 1535717717),
(129, 11088, 'd336cbc71605a6374b091eede6d05111159fbee56ad448c0ac4707e8c03cd7e2', 1535717730, '7fe2234374c2aa2645684c485d631f693066b4b4cc95751fd11d02b3c5c2a162', 1535717730),
(130, 11089, '4b41db1ba9bbae64c03a90d23fbae704dbab4d0810c17b4cb2a98a3264d7039f', 1535717833, '1f2239924664a5c08047d0fab41a6f6a4bed3ccaaa8e26e702efb139d8fde368', 1535717833),
(131, 11090, 'e9e7dce46508e48ae3b6efcb6a9b38700741823c1e6d3c3a16222b9d5933e231', 1535718025, '97078701f0dac80b82390999e09149bd1f49ea1abd521542caf829d24074d39b', 1535718025),
(132, 11091, '7aa7dce45407acb100275e5277df5eb91376ef1c030e004e2a2ca12f1c7c4b9d', 1535718453, '6d70ecd615f4075f241eb958274cb9cacee3c25874f10e715f80dfdf6517908b', 1535718453),
(133, 11092, '55ee46725f454510437a0100a4d523b4644bda4321803dee99e3bafd7f6f21f9', 1535718477, '429dcf71003bb5d7335e88a626af1d7bedbfd9e5723e88f33f790389a6aabd74', 1535718477),
(134, 11093, '7debc91a5ada343b81d4cce9059caaef746bc29ae65ef087e4517335abdc7697', 1535718495, 'c17261d6679a4f047dfeef09e93b61f189ca51009bcab49e34ac3fe38bda49ed', 1535718495),
(135, 11094, '3db17747608fb4a4a5ac8990dd97ba658382a78515181603ea06ddfd23860865', 1535718510, 'dbf037395c93c9b3f822316257fd4d6ea5cc3cc4e919b399a9431ae0aa425ac1', 1535718510),
(136, 11095, '9d61f3e7a1bf0a898ca8a172dd9604b23fc2ce963c6ee1d50483241846e852ca', 1535718824, '8ac8b9e1670bd6ec80d3388b2400af2717e8ca9c70a0bd884566fb6ef9b91ef9', 1535718824),
(137, 11096, '620126742990c95013f617f3f94cb8bbabc5944b563ed4dfe1a5871a17687900', 1535718920, 'b3dce2a77ccfd1fe15c087f61df98fd431c7d47ec995bb9dabfcaad07ac095fc', 1535718920),
(138, 11097, '228b5fbcfa44954c4ecd1c07c89e130a4665e851ff2f99321e5daf194411044b', 1535719036, 'cefc9e36b4d02ad98f2e2202ffdbcb794488c510838a4946d0c8482f4087c707', 1535719036),
(139, 11098, '3d18a80e476a990d6197e62836a180fd03980ca0f2301135f8de24831b345cf5', 1535719117, '2d9e350528da742fa1148ba956c1c36d91dc1f06ec5f91496582c8ba9ee65de8', 1535719117),
(140, 11099, '92ba122b15527a4c17be66ec42640d117e0fa6ca8c4a0619c88984dd35dff19c', 1535719182, '4c63370235ad56b3bf9c894ed359419f52adb551067ebec9b3fb9f168df3ef58', 1535719182),
(141, 11100, '880d11be5bcd9a46789b00ae1219435212ad338e5a25fd645e4b889083c9741a', 1535719195, '9d3cb78e66c57c1fe8b9a1bf9e2c1bc30fa00dfa4a697944b71d1df710134d18', 1535719195),
(142, 11101, 'd7ae4db2dc7486e1925126dc9ceaf17a91d852781fcf12041fd37a85b80f7628', 1535719314, '79aa1ff9c3354ddde38075f1ca8360bd9acce350132e84748a71b5f641087cc8', 1535719314),
(143, 11102, '1d0beddd64cd7f00ab1fea0e2c60bf87c7d6b28d548bcff5f074077cace77fba', 1535719327, '0f4f43f89953ebe92f3ed83d6d8d6803410d652bcce094c65f3780c29072a6a7', 1535719327),
(144, 11103, '6bfdef1e1750a4c86f1a791cc7451d54821a16e7d9659d395f6b41364d30adc9', 1535719434, 'c479f385cbe430f60c2177fe83dc726cfb15c43d3a4b3c6a60bd84ea0e15d887', 1535719434),
(145, 11104, '6644bec0249cf680066a0c41422b472163bfe369484d75abd5cbf442c210411e', 1535719472, '00297da83a16d817d4d82229ed9a49dfe2bc1ca9fefad2fc0419ddef1222c646', 1535719472),
(146, 11105, '04c4bfbff6c3119bbc31273464e23168f1b0a023b6c921f157571ae7c38dd9ca', 1535719503, 'f3388997b34e8b6fe275166caa960dcb1a7b07f268c8c2331bf70b092076459e', 1535719503),
(147, 11106, '20abeb2a4483bd652cfd021e0a3e222c5eb3434758a0a2e80b0fba6d521d3380', 1535719611, '554e9f95fb33ffa9bb4dbcd9f8b0cee7259e553e73f745a868399312e6d3039a', 1535719611),
(148, 11107, '9f908a76c1acaec3243fb58bc55bf2c418af599f6dffced2ba7b62c1fa9ef4d3', 1535719782, 'dcb475906c413b88ae59aa9710ff11ef7a3402a7270323653e7c5bf76352829d', 1535719782),
(149, 11108, 'e5bbdcefebcfe20b354b4d5fc7cb1ac1460bc09f8c124b86496d814766cb09b2', 1535719795, 'a0e5b935f41bb5bed00db235a49c670674ec8a2c891fdb5a94e9ed6ccd005630', 1535719795),
(150, 11109, '83d95f6b041fafcb441f546b0486e3d798917375b916f497e54c6e32216e8ee0', 1535719852, '1f1429819443f203bcdf8d6bbde61b8e78e6691a3cff7d71559e42e1a20a0e00', 1535719852),
(151, 11110, 'e8097c61955545fcbfca136aed9ee06619f617516dd7003b684e2fb1de5c84f0', 1535719991, '1e75ab67deede121ca4602f575c3d969c982c22d3378d8516c77265d46423bb5', 1535719991),
(152, 11111, '1f6273d0587f2548cb1dbc341e8f07214093117ba74f8138ccb822bb46dda209', 1535720063, 'cdd5923c9d533455bc373117f82718974f5ae64fd3d0a9ea9a7df91d4b89a2d6', 1535720063),
(153, 11112, '578f540e51338fd26ccf19ed2c31f747c63345f1133fb82fa17e3c53bae2663d', 1535720101, '9f84abb87785f0d6a158a96651724f676895998cb4560dcd28d7b0bfd3979486', 1535720101),
(154, 11113, 'b58712596aa8c7ed11688e6bc25665cf502c43f800c51597985a152cca5e3244', 1535720123, 'a7292224bb6ba7877de3c3d7075c11abb86d7a190a8036751d718a5f65ad33c9', 1535720123),
(155, 11114, '4e56791c9de2ee1cc63a3bdb729b0067174a16f3e159f419a7670a04a7dc95bc', 1535720185, 'fc7693b1fc7784eb3f31a07f7e872ef3a7e989c320bc19343ea2fd06448c6e8a', 1535720185),
(156, 11115, 'a9adcc525c16493c66f224abf1c4c78307e91b6a8646d0e92ac318cb304d874c', 1535720251, 'b261bcb7c7f4b7f3deacc4b374b21b3e7eade5ef36cdbf7f56b193b7040f8c33', 1535720251),
(157, 11116, '447315f529cfcd401a102ee5e341bf289c24803246c41033b8c4da7dd21e979f', 1535720276, '57c8cc393bd24dafcd846147db529ec633aadbd99258d2fbef2aed7345b09490', 1535720276),
(158, 11117, '1188168754df0a675f8df512ee36bcca229212483ef7e2e366ea192e15c65037', 1535720366, 'afad4d5d8d97277c745ac51ee4141c358fb6e85b570f2cdeadcdac90bbec4e55', 1535720366),
(159, 11118, '9b1ceb99df08e1b259168158400c8c36a2a61c9ea3e1dfa82f296830b2d91e23', 1535965049, 'f9477af9a982892e46a4a9008570a93181ecb0e42a59d9ce3dfb0b3c2fdf8e83', 1535965049),
(160, 11119, '6f7ea7899acdaf7a2d7f4462f0af914487ead3e8b22dcc6ed20c35e1646eadce', 1535965146, '289e8192e9172ffaf32e5b2c01a52f0eb51ec82d858a615a245c8a9aa206e989', 1535965146),
(161, 11120, 'a144e86a5fcf98df0be022c3f4365f475507781b414cc152cf3df9c57c4466e1', 1535965193, '9778fab518ce7c20c105cd3f2b016728734f508a1a8db154b1664207d304c573', 1535965193),
(162, 11121, 'bfc617749e0d9a06f3cab834d705517bbc320220f49ea1cd5f83bc67dfd87e68', 1535965205, '695f45171071a527b67c0f85b7bbf2613e49eb9381132bda8e50d9253cdd21a8', 1535965205),
(163, 11122, '28ffdd0ad2f65d45ec44e69bc9ff9320cf1b8769324bbc7f63deb4642a43cc69', 1535965214, 'f94c4b1323c70df597b82fcf6bb9b931812b987c6a0b19283b37d70478987aa5', 1535965214),
(164, 11123, '210dfe0a4e62f0cee5d8712b40f92f6f1ace458bcea3a89b8d22806161cfd261', 1535965244, '9da3891d58e7388a9cf5b85bdafb27c9d7ddc94725433015f9ca5c26ab324611', 1535965244),
(165, 11124, 'edc539b63f584d91e3c98e9990bd9334abe5283c7a2757a97c165ea6cc300a49', 1535965305, '57e5f4b14725ed3ac633ce5584ea8589c95000d4e5a4cd99e4c9ffa7f0301df5', 1535965305),
(166, 11125, '2715848ba85af9e4aa342610c187096d4c5cea248c93e91e312681287d0e32d2', 1535965317, '5fa962f99fc0600c6b2f2369ee1ab4dcb5ca4f2640ca3ac9d035b112481ede2e', 1535965317),
(167, 11126, '85c4a8666e424b1e9651574ed7d621d84d620f29eb7e70993f63f7fedcda7a2c', 1535965410, '00f7c877f8388f610a7ef1a656decddcce65be748459089ac69be18139c5d1fc', 1535965410),
(168, 11127, '9dad31e1007919933f7219caa3e450bf2aca7c8497827b2429c3f7ab55a346b6', 1535965433, '68e6543e85fb69e2e88e63db3f69f4614441b7c24a34d40abff8cd955f3eda94', 1535965433),
(169, 11128, '270bbad07eceb149b48e0cfec0484adba7dec611064f2ab7a96551fe9be77b40', 1535965452, 'ca6f5e8a8890afdee3b25f65c2c2e5a212cbdb1a3d633a746bef607b87113b33', 1535965452),
(170, 11129, 'ab334999c433a102a3a1df2953f48a647058097fe9452ef6fc6f46791cebbb95', 1535965523, 'bbe985fd8a24c40787ce48849ec31259039759fe2c749e95144b4a1839a55eec', 1535965523),
(171, 11130, '0175187f582224318778765ee57e939795e673d39123557e370394a009872bfd', 1535965741, 'c7af383443a09750263c2dd3a3664ac61a1a4d6faf8d9e3e8557b6f76dd0a080', 1535965741),
(172, 11131, '1bc1bb7b22d2d159ae3392f51a42928f8b4bfe0b71b9159ade3ddef4d25e50d7', 1535965754, 'cbf9a65d05898df10db21cfffe6c587c05f4ba74853ba9d94abdc52ecda968df', 1535965754),
(173, 11132, '8eb2393184a5161d5e42ef52df476dc25dc104beead9f96c36726488b6f6dddb', 1535965883, 'a925d32db5c2690cea5d1ef2ea377a33e2570ad7e63798d19556a9444ebb8023', 1535965883),
(174, 11133, 'e5a9d2c23711b6af95809cf6370663805c2284acc28a4d99253e63a1ab8de829', 1535965916, 'c4a450cbc79f6447951619ba167a45f78ab80ac9a8d9f4e8351e4409e764f8bf', 1535965916),
(175, 11134, 'c9b08480fd7fa39abf33db4783d94efeaf58a6da06cd66f73c5f25aa6314feae', 1535966064, '030cf65acc2a2915792d0c6b38360b16731729ad08b5d53cc730f33286807266', 1535966064),
(176, 11135, '06303c8d3f2ce73fbf1f924cce187efc86cee5daa1589a2ef5c8131e001f0a92', 1535966516, 'aae30c36c427de5e52744299f4bfff4379689796accbb86d6a2a16d804184a78', 1535966516),
(177, 11136, '8643963a0186bb4c030b8aa7b67cd091c7568045b1d532943f8ddb25476216ce', 1535966558, 'ba798d392c0b1e07f1c07862e1c5a7696c19164b5ef1e432e11888327701d212', 1535966558),
(178, 11137, '0a99498d651119db5149218b4b44192666247a0bfcd86de8b2728b810e155294', 1535967649, '584dcb7a1f770a2ecbd9336b07515f6f0ea4ca93d08d2fb89cef22f9d0afacce', 1535967649),
(179, 11138, 'fabafaa8a07f63339dededb35c0ee74dd9479df02116764f05dfe98035af96ef', 1535967670, '5bce6b3b11d5976c9a253bd62736b1b0e3694d698ad47073318d9be6eb75fe64', 1535967670),
(180, 11139, 'f2bb60a001ef0ee45cdc47c0a84c1179b48f105fdc45ac776fe52a5622e15785', 1535977819, '05234e75d2d896a190574c9739d7d100f1611b2fff49aceb2e527a81bccca1ce', 1535977819),
(181, 11140, 'd9aa1e3e11ffc0a6dec9cdcd1e6d1a6e6c73a9d6157171c53938d918bf5fe7c3', 1535977920, '6643266861583117e2a5476c0e66e5443c79b1bb7f59b41dbd455b729288cf54', 1535977920),
(182, 11141, '7f0079aab20611d24a66a36c99855f399d05ac3d5277c7b2df3bafd9b130a8fb', 1535977969, '5fc92954e8124e230c8545e4745196005ce68c70d7046cc74d1c784a0b51e333', 1535977969),
(183, 11142, 'cdd6378b1bc05f3b51ed5973ae90562582be2a6226eccebb3fc5fd79bd5460fa', 1535978114, '34dc83029c54027dc2e4a410292b169eff512a028c387e225998cc59734f16c8', 1535978114),
(184, 11143, 'fe47b276244de0d2c4a7edb532b38788838541364b1ad1e75c3010d48831c599', 1535978252, '8e599c0c86926edfac43b1dd824d36dd0f2ea1fe8e8572e7d4506840f923eafd', 1535978252),
(185, 11144, 'b96b07126f9c65120212afa7c2685ba1ff30b5888eb80483967fb5049ee8f304', 1535978367, '43acffeccda2a0a13c43be63ecdb97e5cd5f8c54d69f661f57645cc0ee9418dd', 1535978367),
(186, 11145, '32621fa0ccbd6e4a507d9954b099e402790b1c4661954eea048e7f9de1adfecc', 1535978581, '73fcb9292ba3f9055ec1f7da800f4741ae06f29343e18f32144624e3f3d20b84', 1535978581),
(187, 11146, '5aed40e4472caa04ea68ec3cf361dacde41f7fe8aaf5eec5f34b930a7292d85a', 1535978644, 'b5a394ead27399bd34d442b69c5a7a5fe02a2c6e77bf3ebe7d77f2310bdbacd0', 1535978644),
(188, 11147, '50be1fee2c7c262290ba65c52f42e70393a448a9ffb4c4d5f25d3486f77f9fda', 1535978896, 'f2a9ffbb43faa38d634692c8247a588962947cc14cc8961d5d143f303d2189f6', 1535978896),
(189, 11148, 'e9a0b191f2ac528e1e3787bed16762b3aaa9dbf3d78d672fde7ba281b9bd7eba', 1535979953, '858e4061fcf4b7150a659039832ff3ec03f9dc442dd795214ad3e83840954c76', 1535979953),
(190, 11149, '3e7bd1c5b280b7c8e3c1074ad5e29a6cebe944bbe1a4022d6bb41460cbc569ce', 1535980002, '1ac8660a1f04b157981f1ee1d2dac8a79464bde13bf04e91ff811f8551b9f0a3', 1535980002),
(191, 11150, '17ac6b510e4f0ec946d3eaf1d1c3be04e6b432f362e8ccc41592f8948da932c6', 1535980074, '6523bd9e976d6daaf434f4e9640a7a7fed5caa8de324ec4996e1025161a7ec6b', 1535980074),
(192, 11151, '7f61bd8d80360d5f847748b7599ec65c378ca77f80a7c0b90c36fba42ba01fbb', 1535980570, '1733cdb85cdb92f1cd825142b5efb473beaa54cec497ddb3601640520674e409', 1535980570),
(193, 11152, '9846ea1d0e56a8b0d74173fcd390326165d2e6587ba2a362a3ffc79f1d3cd967', 1535980624, '2c0765d27826d173af8fb07dd874fa8ce460f36e3cc6badd24de26da482b2d9d', 1535980624),
(194, 11153, 'f3148b84194e796c2e1585564b19a1d96696d44fb8ccf0428a9850122d2f74d3', 1535980638, '79377228c48ab2c2a1bbc5062c003145b26707cca592a3b4505a7e2d2fed79b7', 1535980638),
(195, 11154, '694b9b21cd2aed3f2cdcc632224e106e853f931e82e04a304f5914bb58beaa93', 1535980688, '2fc8f62236a05b84c86107dd2c82444819965b903126f48349521ed4dead73ed', 1535980688),
(196, 11155, 'e3415c0c11dbada278b4ace5b91a4fb49600133ee28b740d889755ab0cf0dc98', 1535980956, '1a3bc2ae95564c15ecf4b1909bb827402dd3b09d91e1223ef84d0459c0f6bd41', 1535980956),
(197, 11157, 'cd167739a6dfaffac01a389e4a7505dfb435f00f8afbe9f7e0e01d4517f5d82d', 1535980976, 'ebb73617ef70b36538d19db8627799434eefd34555809645c38eb2e91994043f', 1535980976),
(198, 11159, 'ca524ff7ffefdd29d2ace54d5eab4db24cbfe75c75f44d03bfad990e0604e42a', 1535981601, '2a1cdc6b4039758fbddd478a4ce3d284ac0170567080cce348b666833eec504d', 1535981601),
(199, 11160, 'ffa8936d74a16b7594e531a38dbb2a27e8bf8c9e0fd5b6f6f3d5fde296c48ca0', 1535981624, '4ac9c1635f80d2563aa5647768d7b46d2dfed4756005b844d34bfec340098acd', 1535981624),
(200, 11161, 'd54ffa39bb3877731c5cc99be6f664497b0dae39492f82de58bb006f4e3f95b8', 1535981841, '9e9d4769e1a0a6dba42ccc6677cad36122d1182b1d3227de6a2d25ab0cb1e49d', 1535981841),
(201, 11162, 'a66385cbb601579bcd7137be935d05dbc29d274bd4e7a6962b26df07b7c6b775', 1535981974, '5a9106614c22f2c6cfa799e723c7437536f89494dd891e618db849bcfa29aafe', 1535981974),
(202, 11163, '26fe480b009905dfac145750208f7186c84dce16623a21f9483d86cc8ebbcae0', 1535982443, '93da3f895d935980e64f2b7e24ae645bf50c7fdd95b0185ecbbf81dfe792351a', 1535982443),
(203, 11164, '1a0cb2bc7f0bc396d3606d862aea7b8ebd3e2ceb278cfc163b8b18599f8a25d2', 1535982606, 'bf721b07fd889c9184c79ba04ac7b1d444bcd7e50a119f8b64d549a61d9b9e79', 1535982606),
(204, 11165, '097399a4fcc5058815bce6e686772e332d94cd807c7ffbc5890b6d581720685e', 1535982681, '6b4e275721867dfb94c699490c95c99156d64d36a745822f63b88dc68f199535', 1535982681),
(205, 11166, '0f640eda3b16454d2d2b09f8f13e687523d869ae261caddb28caa6661fa23d93', 1535982751, '9cddebd42f32d018a4075288bf324f2dd4e107fdff591b3cac62bf888ad7b981', 1535982751),
(206, 11167, 'd29e36a027e2294052ac1e5bf9c55afbb19c6b321d88c04af239a63256776d2c', 1535982873, 'cd254e16f9a977df449478857022b689e76290fc892aa0abd5c27a791b6b4265', 1535982873),
(207, 11168, 'e4581a3c967843fbe655f5d025d51981cfce242884c9c3c1535afd3ffbd5ea8f', 1535982920, '7d423c328e58f1369f4283a3412a3f4db21976e9a3934b38c76639f7d51b6935', 1535982920),
(208, 11169, 'f91ffe4a8bdc8ce8fd53a9f6f2a926dd900e35f7d76171cc5e3c990e760539a9', 1535982978, '0e2a5c1c0855ec21c169284202a97f59ddd994a0a07377690daf54261cab613a', 1535982978),
(209, 11170, 'd8e9efa5507deffb2a8628ae2ea6f17bf36e02d5bcdc99ec7d7931af02c74de1', 1535983019, 'a8875536df6bbb5c5708fd550b0bb5dc14bd7f2373703bb76c7378325212af6f', 1535983019),
(210, 11171, 'f9f3f19cb7d0136e1b565ab8aeffb430305d69d68b69c2088495a7c7a83101e2', 1535983097, '050838ec6119a0fee91d9ad1fab7084592d2afaf976d70b2df546a2b795b94da', 1535983097),
(211, 11172, 'fd5e05c42d47768513afd96427736055ac3352853639b6450dad230312de1fbb', 1535983118, '62efcafb2edf1c054f901cbe0cda2ab42e7fb69fe715d62962084aa7156ca3c3', 1535983118),
(212, 11173, 'af92b29c5abc7a38b42e7da2a2b609363a254f207dcb815945ec7752f5d06b0d', 1535983154, '8cdfb2110b654dd2654a62df5cf1fde267cbc0c0d08343f2b84e2fe2e89a197a', 1535983154),
(213, 11174, 'addfaf1e9c5a1f07264f23b7b458274af5ab32fa4796c64e0bfa2d609db94f3f', 1535983187, '7710f1ba5b22ca9eacd6426038786e727323be8e4226b97a8b4e0c88b8c707b6', 1535983187),
(214, 11175, 'e59c9eee2bb5f13572c8f03eab050611b49fc018c0fbee7b61dbf3ab759234c8', 1535983321, '654a92231af5dd5dccccadc779ec61f4fd1c530e8e31e5ae0074f730d2f6924c', 1535983321),
(215, 11176, '84cb42b305aecbd26ab93321dfc321ff9d426e82cb60720870a5110b8364be80', 1535983325, '4f171a9fea98d0465cc32ff0d02b1834bf10a7702405442a33063e79d88b837c', 1535983325),
(216, 11177, 'd68f54577fd8818f72591ce4f9f49ac752e8349e5fe10d4f937a7bc2791d4215', 1536028860, 'c5e7df2618d4b086623714c541c3e5244d8311e5bbdbf01dcb3ceed01298d80d', 1536028860),
(217, 11178, '6e4bd1c0c95a27059044d372d55263a5b5f6a66c2e9eb5f1b948a8d0de6c3aa7', 1536028921, '93103d56e7938f30fc5ebf0a2d9934bf4062b6abb49f584c68890fa800a962ab', 1536028921),
(218, 11179, 'a69557c302fd6cecbf05aaba2f598d4291d1eede5916c810e88963585af8608f', 1536044747, '92591e9a96f6c348704dc3c7ff0c6f1fb47e90855891056b5bf57d2146b4dd7c', 1536044747),
(219, 11180, '9baa4d19ac85857824f2e2ef53d2e586c4a6741f6159b80566f15032555dd431', 1536045031, 'ecadbc93fe550f64035abb030d6365e6b2c945f1cfc86da9d7f8b0c039f9a959', 1536045031),
(220, 11181, 'c973647a128d24d10551a88941dc7416a57b98e80f607f6ee574af5954c86ec4', 1536045096, 'a9d0e9812804cf08ee700fba4d6bc4a2ef0b08e359f94f984cdcf4d01da95df0', 1536045096),
(221, 11182, '4e8ee4eb719066ce97040980d5848df7fce89eb8dff2fa1ebd3133882ee48288', 1536047675, '4c9060ba7f1d24e6e9a7aacbcd640fd0ae828c5258fa688f2f75490f9dfb4d51', 1536047675),
(222, 11183, '47b193cf85c9a6359d57da8b5ae5b55affbe14c6f6d12bdd6cfefad7de9da211', 1536047702, '7ca2b682d7a6f4638ed32682222947466964548dc1efea1eb36c2179e9b517f2', 1536047702),
(223, 11184, '55811d97b8c5f0fd20fac1d63b3c7808dcae8382680ee7a9c36dd95f40c565e0', 1536047736, 'b1b545f7210fb5cd55c74570663c958f3b7c2fae198f029c49570cee8ca22e97', 1536047736),
(224, 11185, 'f90216efa67d81ae970e7871fcfa53307558fb2dbcfa34405a4a7f30d9f5e00d', 1536047759, 'a26a95c5501a6b34504c847908533c7eff8700f5ebf287315902d1d6ac65ff1e', 1536047759),
(225, 11186, '5c2910ff697adb236a009900c745d0ecf3a015cf6ae643eb46b89c60cf42dcbe', 1536050994, '0a2052e27b5d4f839b5160f30d66861142ea37a7c69cd57d1080f5c1fc903937', 1536050994),
(226, 11187, '58aebf0b0d83ea4f8120f51bfcd58a939afcb13c3dbedfc3db1c49e24af68174', 1536051019, 'd08dd33b58c5d1bb3d263f08c0c3e9cb4d92c3e2ac78b2d7e40398c13a75b5be', 1536051019),
(227, 11188, 'f52566ca0fb28e37ee1eea2d5d2130f43fdd43c167de268fedbf6ab71af53861', 1536051036, 'd18c54e65a8747a289892550164fbe00196d4980e8fcaaf3abc7b6af9fd88628', 1536051036),
(228, 11189, '9d3b4f26b798832525602748b7855d0aaf41a52b5bf82e50b2046500c566cb3a', 1536051063, '2baf655d425b5d1b17a13fcfcd6a6d3ef81dc3e776e73492a6ae44247b096d1e', 1536051063),
(229, 11190, 'bea62610192a0704c7a8a4113bff43c856f515893602e62e211f76df8545bad8', 1536051118, 'd21777692dfd2e2f78b26e59ec615af9f49dfd3399e31fee459aca0a55ff0d85', 1536051118),
(230, 11191, '6d15682b1eb7bec0fd07f2ede028bad09034798e7477d9ee5f60ed00c42e665a', 1536051146, '52e87ca9fcf695d5455619284d6e58099d497136762303b734110d5aa0bb3660', 1536051146),
(231, 11192, '8b942aff7c2a4bba11cd0335f0ef5260b419f3ffce9d394904a7a22ce5027d1a', 1536051176, 'f3fd0363a6794f0c3740ee2e310cded8917da8ae0d1846962c437a8dd22ffca7', 1536051176),
(232, 11193, '8c3a29b7df251b1a6c79b6c5072b66862ae4529cb433aa20ed2b8377feb39a78', 1536051186, '6be2e8efc2e68c0b72085ee83ca476703cee688ae4ba8302dcf85044b6772a8b', 1536051186),
(233, 11194, '104364b5261434f7871fedbaf95dae6ca8da5cde45fe1f963ea458d197801258', 1536051219, '6402dbb625568fcf1c9db48521bc560a0fd0bd2f1ae3c0ff0d9a66808cca4163', 1536051219),
(234, 11195, '0a0463d2dddbd2c4386ccf9fe79579c2ea88881f0482e67ec9cde1b7743d1ec0', 1536051227, '3b428503156c1e8444cc578cb39e57885912b3c1c485b08b9f85da9b8c363476', 1536051227),
(235, 11196, '652093fea2c788a77db24a05a4379084228010402cc0f25f5b22f35c7b2a3377', 1536051244, '3ee12a75c347da4e016060065919e3977d68ccd5baee3978faa5db7c76b13c81', 1536051244),
(236, 11197, '148673aff77ca39181b6d34bc9824c6d3085f68c317d1f10a90e148b7a3d8990', 1536051267, 'd2058768a9efb4c422d0beaf914fed8cb9006b3168698091854eeb77bbec9942', 1536051267),
(237, 11198, '70a9833e6494bc31fc6bfd89eb01cd3192b80fadb0905eb2a95f9b17f22d3c44', 1536051294, '8edd6a678aa0ecf8865630c42ffcce18f5334ee1754d9e13a37960d83ff25331', 1536051294),
(238, 11199, '836308641564dc41beec2d9360e694730ca0e199bd8b9ad3c6ca159e4d821d4e', 1536051321, 'd86d4b85cd2418f257e053ecf091c531c5ec400b9da128d7bcd19884b03c5b18', 1536051321),
(239, 11200, 'e8fed53be321f9507fc7e55a2fbce620ae0f905a3524a597486ed196a89a7bc5', 1536051333, 'bb8a2f49267e59dd11e3a9fc3db8661a9b8fd57a28e7f68dd51b462a477cb26f', 1536051333),
(240, 11201, '562a0e3e96b3a4d62ca7c89903442effdfefc9cee84740ec1915bdda049e2b12', 1536144306, 'e9ce83a6ff6464f132d15859019cde3f56140d95b165c17b5ea5a0e83b25827f', 1536144306),
(241, 11202, '2f424386f670e2acb06dfa1c11fd003ea2703b59e767dce614c6edc2ccceb764', 1536198827, '74ab60aa8a80e6ed2a91d9d9b365a41235970a382b22caf7cf72c92259929820', 1536198827),
(242, 11203, 'dcde4b0a176eb44ed257e66e80d33617789bef4b8a4e9b2300ae45b4b509f43b', 1536200137, '84f9960a81e6c40b37f8c85948b2a10ac15fef70875a6f228da647edb9fa94a8', 1536200137),
(243, 11204, '0d4be902945006c1caf61e2e0deea392183c71cfcb0a2cd6c3b03d3d7247669f', 1536200167, 'b1ea48da8bfdea5675252c41960fdc7c1ae0319a10215ee66b8fdab4656cc813', 1536200167),
(244, 11205, '53f0115cd0902f558dac0be33b41cab66e85a417b9f2d6a4f12c6c12cd6ac014', 1536200365, '960c4c2c60051cb94fe10e793455467e5a0ed1613af2279e02a408e1998de8ff', 1536200365),
(245, 11206, '5cabf82312caef2968e907bfdb086e86cf1e2063ecd3459baba9ae5db17601b6', 1536200441, 'ba8203978c7fc7d543e741163beeac9d28585d774f063506ee5f73da7100d002', 1536200441),
(246, 11207, '6f7b303065abb1550d8b872aefbbbae924b8c799575e434a7bc9f5d3aec946ee', 1536200547, '59a78fd589ec458c5b5615c01c5faaa7d42deb92dc941285486e0d42858a4293', 1536200547),
(247, 11208, 'fb585634f32d8d9c49b0c45bd7ae2743f30aae49405865d65fd6d6fa264f39e9', 1536200566, 'd7f5539f72d3abec82a0ffaa3e9387dd03ca11807235c133560fe4cfb1fede6e', 1536200566),
(248, 11209, '520fdd9b8a483ce55de9356b45b4edb61f9b697cd8e9e6db1fcbb4308ce5e22e', 1536200679, 'eee95f9c5cd569f26b012b1a2c70195598f6aec4d5e48e23519496f31b49aaa4', 1536200679),
(249, 11210, 'ae52a945331d6dfdd107c6b1666680707e0a9d5aa5869b8d1c681bc12ec01e0a', 1536200697, 'd7544c80cddb71b893fc3e0db20744c84c3b46c88309b074d5e5995ef442882e', 1536200697),
(250, 11211, 'b70220040e5d487609c35c0421d66eaa7e91274a09e7d1e3e8dc4a7920bbe37c', 1536200715, '835d704803e8914c147af0f46a620161e8f74c2bce89a00e7eaa425b41d2028b', 1536200715),
(251, 11212, '1520da6e85df5a5849470b6d3ffce2f29a18b2ca3a08982f60b70dcd269f0e91', 1536200723, 'e668602d00a6d51a1bf715293e2d69af291541600b1594fd90af6af01dd056b8', 1536200723),
(252, 11213, '47c03016c9530227efb413ba83a6a05b8d02c6895b699378ba6a9ddb4dadd5d9', 1536200817, '643c05306702da87e61b47ab17a102e85cf9e34538297bde760984d6e7f8ec93', 1536200817),
(253, 11214, '376b8e6049c9ab79976f99c4cbd062cd17b927a6c01cc7e6e89e493b45e89dc3', 1536200891, 'c9f4786f8791729d6b0b6429b94e182e7199d0bd23f98b75c487aeb2917fb407', 1536200891),
(254, 11215, 'a650fe7387a800602b50091f7b01b5e3a1fb252948383d4e9d50048295dc45c2', 1536200918, '46b7126d29f19ace075d6193c6ebe082627b7ff57772866b93745df1df1ca2ef', 1536200918),
(255, 11216, '2d53afb675c57202cf96b72ea189d16d02f929773944b41174963bd2a8e7c86d', 1536200949, '35f2eaf5ee983cee7ede4055283943818fe1936e37b5b56cf2f3876b191d0b4e', 1536200949),
(256, 11217, '0d3a933807114fd158ada89166192ef72f101ccc28297055fb471886ed00de52', 1536201393, 'aacdacd6cb5e730ce1e9875f3739d60e378571c0bd355106956ffd5948b02122', 1536201393),
(257, 11218, '33a843195a814d02d9af520bf4fd3f9ad84a42e5c2a3da263aa256e90422eb1d', 1536201399, 'e388d1cead456e803e2280e33e0579bbb3392faf85c1199a1b31ab317a43a660', 1536201399),
(258, 11219, '3abdca0742f906dcdf03314257c63eb2307f2cd4fe9eb2725a79744c22a0b37a', 1536201404, '31c784c08dc87024783f59d254eeba5a52b9893ce4313d6a49e6b0a9730a9281', 1536201404),
(259, 11220, '9e2cf699c806b6d477b61f7db8575d554d3875d4c4bf4d4a94ed8bd070401d31', 1536201425, 'b897f919c207a532fd4ba260adc0855e31a51108ceea3924b972379a782385e8', 1536201425),
(260, 11221, '63d7651873f07f70263c499e8e276d7445429987dbca6c18238123cfd8a0c2e7', 1536201494, '37d3003b41cb67950348167e8df598ee03bc429a039e7d2011604ce9639b034a', 1536201494),
(261, 11222, 'c7ec586c35aff30d46302a1978c3f0b65e9bc66aa6ca7d4f1d7743ba99f40a36', 1536201595, 'fd6801efa6bfa6414cb15900ab1ab0f4bdcc34af5107a0e032b50224af327a13', 1536201595),
(262, 11223, '61991b48b98e854f334b14d10e6cef9e6d0fcd9dcccbcd738e9edc96984c353a', 1536201610, 'fb2e2a55063966c7cbe931d4f5eed9d8c61701184ce6fef9f7267f9caff111d0', 1536201610),
(263, 11224, 'a8809e6ef5d74b29f2ccc349d67b0ef1add0b884a95be9d5fe76e8a6904a22b9', 1536201742, 'd7e5fc203a593ef58783667a90fcc80fd2def684a7670f6e5322e6e3d0617ad0', 1536201742),
(264, 11225, '0e4d4540f9e82f9e7a75ac651f95c38d780238c57e8920d7cd569114c1623bca', 1536201761, '5832901e972e306838dd5dc4b79b01a526b4526562d5a05e124c8c24390871ef', 1536201761),
(265, 11226, 'b49007efd6b8343156de2075d5021b3ed4d5c217296b272288aa97118eeb0e6b', 1536201803, '03ada80f6522aa0b7c5a2e48128078756024f4106652d1ea36ffbb44c11f7e44', 1536201803),
(266, 11227, 'dd3b950d6473e2a1602630351d296d862b26683b439586505f3536021c7c231c', 1536201966, 'f070e2f901af55e3692c0e1926d9e0360d0a6dfa8885ec102e80fddcea476803', 1536201966),
(267, 11228, '8a347da79a37eaf137543e7ce802e00a345008f331476c533ce03443ccae30d7', 1536202009, '9e33d3f846d9e1603888a598959a1cbb8752bedea85212a8ac7f52885e4b894d', 1536202009),
(268, 11229, '350d16aecadf53b465dfe13c919844cdd431b02a160490dcb7fd126cbb914e9f', 1536202013, '4da39a34fb8697313cdac91238141e39231df0c64a471775cd26b86d95b58025', 1536202013),
(269, 11230, '435de97d01ae1b55ac616d936991df5085a34ee7bc23f9702bb2aeb9990815d0', 1536202064, '4cc0d6b74580725f6adbd40cfabf167ff46a6e01b50259560ff8db89220e981d', 1536202064),
(270, 11231, 'ac9eab99a248b6adf1d8ca61d41920ac112178f1ccd9a624c173fabb48132087', 1536202137, 'e2c6359cc6d36d5b6721ab0320d063a204c408eaa3744bf894ff18c3f47eb8b7', 1536202137),
(271, 11232, '04171e63cda717d34706cea30d8788d5ad3bbb622a665e240a72dad8b0625909', 1536202156, '6607469f8049b4290c97df337e5279c4a853599959112ef55673ce660dfdbb0f', 1536202156),
(272, 11233, '4d182c3f9adf78552ae8dce24762aaa1b42268c2f9ab07bec0972a96e11ba1b2', 1536202189, '578c6cc0bc3a880cb89e4bb842576da464ce3424dbfacefa2c8e0e5ee996a8fb', 1536202189),
(273, 11234, 'af0d096423a6d26dc37daa5ee066014fef025ad8bbd3ff843a7a50d8be9450b2', 1536202524, '6988aa14b733e2971650144e60dfda13d6f9db36d2a2615b63c9b8854fb65611', 1536202524),
(274, 11235, '7886c967a4b191a84a0c65ed699216f47717d7ec795884c64bdb9ff4dfa43a30', 1536203136, '38755a5ef6edadd604d0e4af97036098444ea562a474683e884d97e96440823e', 1536203136),
(275, 11236, 'e50a4ec373e55d48d2279079bf18839d85674134a9312e7a1b900bc2b6535ae1', 1536203140, '980526c9668247fcb50dfe71081a5ffbce5c3746fe23669787c46b11769d005f', 1536203140),
(276, 11237, '32b1e10d0f5697b4e994887411805b2346adcda48e9fb0a281dec7377b0358d9', 1536203152, '5193faad6b38102f2419e9e0aea90bc308e5576a5687163ad9b351b8c691613c', 1536203152),
(277, 11238, 'acae5da696a50807b3fc203ea8962bb1ab3312264f5983dab4623a37bc13b738', 1536203259, '63ccb4e68fc46dc9b51a8046c3fbd95029c8f38d09a80cd424e7daa85c671d73', 1536203259),
(278, 11239, '146de09ea4abcea9c17d873b28fb2d9b3b0b16f0877943467025f4152bcac156', 1536203637, '527519ff9a43ac3fe35a4244d3702593e95d68df8c2a59f4ff7e06021fe50deb', 1536203637),
(279, 11240, '0baf4a1045146a7209419dd9333d168a4ada464f424ad7e81bc206c49703d757', 1536203682, 'bcbe52da1daac94106c86fee4421336f714b196b42fd838bdb681f88357bcc0f', 1536203682),
(280, 11241, '2a9214bc1ea17cf33b3ca5488dd31c6313e55091c5feb3945a48f599411662a6', 1536204060, '73ab5c8e706b44d05d5540ac5d976578e52c7f995b647a37a73401392a2e9f41', 1536204060),
(281, 11242, '87252ec7696e226359f4d4a95669a8b86f0cd9c253ae863ca38c07c5eb85500e', 1536204541, '6e5846e3b63a6e6f6b377782612c9fdaffc47c71e9dd8db6d9f694d65c538817', 1536204541),
(282, 11243, 'e6fd0c8598d19444ce175c6446cb77ed8b3d75a91b1cbe08754935a1e4566e62', 1536204765, 'ee8c4aff903166fe98e3b7c6448f26442b29198058efc19bd9bb7000fae34fc5', 1536204765),
(283, 11244, 'b5a2f7ff5903904860d237281fa3a7eb43a7e7d8bdc3a8aff4a2502057d93369', 1536204848, 'ad79afca6b28a84cb841b952f18bf182483be8eb50d1b41851367513de22ae78', 1536204848),
(284, 11245, 'ca282e91c7bc6116c883aa28e3d3acb2b329be6388fa4335b822bdd043e5fb95', 1536204998, 'dd4dd1a7ce732681424d12e934e02e874f924d969e289902010db9c52fd3925f', 1536204998),
(285, 11246, '98ee61e9430055aea9e75e7f5828703140c78e5aa2cf3ccf36d9fa60b11bf33e', 1536205003, '7a46e1d31257ea97b54c2dbd34c0d8a07930c2ab3abcad2f9cf2ed6a6b595968', 1536205003),
(286, 11247, '22c98ab61fde03d1fed1c014f8335bf07135095e28ebd11fc2b4e2e2076c608f', 1536205020, '32bb820ec573d974c36676377ada74dd98a7a47083b7dc115b41c6eb91b1460a', 1536205020),
(287, 11248, '151f00328a8499d1972e8770da6654ef2d7a2801896a18dea779d7cbd4b6c54d', 1536205081, '3b885137a9b32a8d12fedc0ec8e8b70f60b2e6b7cbdd0e49ba30cc7f8b640d2e', 1536205081),
(288, 11249, '7b34f728bc1501dc0f950e9ee2f01fe43335f1b16500095bbe3ed8357a8300e8', 1536205116, 'b91b077cc27c62a68d073e698458efe0ce5818ab645c3baebde589f7491e0016', 1536205116),
(289, 11250, '122ded5f8d51bd7a63a77644966fd70a1e54f823eeef9d130dc1d5ba6377088c', 1536205172, 'd8a4b877be75a573d888fad8780b9dc0ca8ebe2a4f584de969fcaab0e32363d9', 1536205172),
(290, 11251, '20eaacc131ef7b0e18638b2e92bb47f260c3bcbd5b8178aab38f6d3ee545e969', 1536205541, '6fc42cebde31d7ecbf0c938c357d81a2fe2af6cfda5d6e5a8c39ff3ff56509e0', 1536205541);
INSERT INTO `user_token` (`id`, `uid`, `token`, `token_time`, `refresh_token`, `refresh_token_time`) VALUES
(291, 11252, '25005d5842d5f6cebcc35fab509d9f6b90970899c2ae8ffb5a315a4ecacf9301', 1536205590, 'f6f5f95cec193d055421d9e625721df130545b7c64f66f969c28c6b826b9539b', 1536205590),
(292, 11253, '1f28025c2a9d314f8b1cc2a39bba74f597f9800c5e952d3b2b7a1b63a19f766d', 1536205629, '5867aca9aa0224ff72f4117bf45e1a6f8328369888b542d39083eb30041eb247', 1536205629),
(293, 11254, '0efa5fc081276912de2dbb077f3767d51dd128350b3b9265c48a89cca4bc5f90', 1536205706, '2e676d91391bce42ad2a3c486d1397efba59d858dfed335a116fb8a492ba7a6e', 1536205706),
(294, 11255, 'e8054acb77c074d5b2a61f5eaa632c184cd3d96de0dfad0fc1bcb67cf8e2db76', 1536205735, '55118848a620dc37256899e6860a89eb0306dd78e57dd9cb9dab733c39152b38', 1536205735),
(295, 11256, 'cdaf742b1ac916c8cd5bc02db89bc84b80d6fa6ea5d753c0f3d3c1d37a9b7b71', 1536214842, '0f5e1417082eeba0b39621dfae94f9c9430807946f5de03df1a8b71cbc1f06e6', 1536214842),
(296, 11257, 'c3492e006856c5b78d68cf65232163776e5817b38ddf6ab020aa940e25ebbb7e', 1536214880, '5945ba02b9810ff1e77c879de02f8bb8a17181a967222feabd8a8bcfcb4fc11f', 1536214880),
(297, 11258, '1c4000dde178f3e8cff8fbcba9a9fb15645ffaeaa0168b07c7b94d224bf4c2cc', 1536214891, '052cc5024c18655739ca22f8e6674696efddad8da97fabe0e6f54b91660348eb', 1536214891),
(298, 11259, '6baa89df45a7e14ef6b9a46f2e4af93486924bf34866d332ac00bfeac45af332', 1536214963, '76b7bbb1d23bb7dcb4052401df81a7ad38622459fe889e2e80c3295a62fa00fd', 1536214963),
(299, 11260, '110f37324d6e5a28c30fa18c57cda9337aa1e571d15c50106b92ee8ac96b7d54', 1536214989, '07c2c799357542e675b9aa9354d8b81ddc723f082c671d1fc28e335b29f90143', 1536214989),
(300, 11261, '4ac159e05575fe2f6723b2d46a8741bb52625762d8da9bc4bc06e8cce4428e94', 1536215057, '247bf3fd8e7c52901096844c61ba36efe6cfa4b5e8c574afc844a04a2b9e8bf8', 1536215057),
(301, 11262, '3be5ffbeba3bebd185fac4b29fbe87cf0490e11a47f8820785e1e71749e81617', 1536215523, 'e05d75e92b6c4f4f49c6131f38d40333a4e65d8192a8743c12ff63fe69753118', 1536215523),
(302, 11263, '2743669cca8cbb4459f158d4733e292bf59afe8e6ce5082a4a8555e8144b7505', 1536215553, '87fc757cf1be5937bb2d0a87a088cba2e4ab3ccbf765c68485e6b52b362a93e4', 1536215553),
(303, 11264, 'b1519c1996adf3a85b29356754533e930061fb389f5cf83a77089a5547ee44ed', 1536216535, 'fd349938b490cfdbc025e1a91fccc5fc93994b956d8d1abdccf9f7b05abe3460', 1536216535),
(304, 11287, '209092b52e82b445ab085d50d364c3e90ee1ffcccbd5c17547b7992bcd562907', 1536218570, '668d065e451ec90106ba624ad72c75151e694535a93defbf9172a2bf502dd548', 1536218570),
(305, 11300, '11d7658df8468e44c1c8a754634f704ed436dd2934395a1cebda5b921ea6f82f', 1536219031, 'f13ef95749cab64ca0498df4279505a29046727e8d95def869919b7c40569e1e', 1536219031),
(306, 11312, 'c2984e3c4bf2a457b753670b4a3590a649a05086691c90f5709afcf5de89f43b', 1536219039, 'c75a84c3e6a8d5c791026ecf18acfa76c2ae5695b6d494ba249ff045a8750d79', 1536219039),
(307, 11324, 'f9bf34da1c90dfd569fcbaef86ae6f41000b3007cdc411bcfdb3469da39baca6', 1536219698, 'c1af07b354fa27896a52f765b38034e9a692c3f77ef69678c7f538033743875d', 1536219698),
(308, 11337, '5788e8a47c44f952946d1d389ac9f18d2427f964ff698bdb15151d1a351e26ab', 1536219828, 'd201c96351a53da62aa7c0397e4d34183ebe76abc6ecb0e2e5cb0fc481e6261b', 1536219828),
(309, 11349, '7cbfa539f40dcfdb55209cdb4aa858037ab8d2b594891f9a94ff10c1d2090b14', 1536219833, 'dd372d65b9b5d7e36cb66035cb3535847ecfc05161d3ffb220e36da39aa6e1d1', 1536219833),
(310, 11362, 'a81635d0731738f8a0adb6c694c599cb3b8106980b94c74b38be016bf9a506fb', 1536220281, '8853719b01328def630ea6669f12e7521c49982a691c4b8f58b2f3838a98447c', 1536220281),
(311, 11375, 'eda107735ce1fddf46de73a3625540b3dae293536bead7daa2cc87cfc5599505', 1536220465, '2aa8a06959d726176661ca287f1a5f2610299485638d71312235733c37740cfe', 1536220465),
(312, 11388, 'f1d462bfaca80ac15f474bae67566f6a3bf7735c810473c70dd18a7f2144d21a', 1536220536, 'e05943f076d66791dac3d21b197c4689bd8bd49725de2e43f68706f53277bec4', 1536220536),
(313, 11401, '827263cf00326a8090ffbfab1ab79cd7197d277c665d1229c6c9cb1afbd68fec', 1536220580, 'c3ba10debaa081eeae0ae2fe8c76237946867ca69e19e85f30875399f688f7fd', 1536220580),
(314, 11414, '9767336e00ec6ee09d071018a68d032bcb19d6a224b06c72b054934fc3618c99', 1536220594, '760a019f61182c256bed0d9ee42feb5bfcbc51a4d5d8fba978468bdef7b202ea', 1536220594),
(315, 11426, '8e9b0db54ef1c59d91bfa9a5f32897d0539ae3d3247b2c767212805c0b794259', 1536220759, '2e5404f4d40763aff0f38a170d8c2ec46dcf72d12b80e6b99fc79988ddfa589e', 1536220759),
(316, 11438, 'e03dd03f254fbde5c195be9a33af540d31c1209282731f8a92ad13fce04f2f79', 1536220774, 'ceba4ee547b2fd54a18729ae3a2485244c50f2393ded971acd29a33c64bccd35', 1536220774),
(317, 11451, 'd253ec324610b9b3af7441484bd74af4df2caf934d69979091a91c7ddcb767e1', 1536220864, '51c818adcf81dc139fc30e902db45634c32e9e66b4a57885f151bc03ae0970db', 1536220864),
(318, 11464, '1fbea414220cda0fa76ba597f1cc11ccd92015e18b6834a2a183f2f47ba8e6ea', 1536222989, 'e1e6da502eebec8cae479b2f9593939ee004f410c6849c5e0cbba6483e19f46c', 1536222989),
(319, 11476, '1f15b58ab6dd84ec356e01d81f6c48bf4f910d6eb3aeeee7283fc9a70ed0e560', 1536226103, '1e347d08b81549c0a5ae6da252002fdf120de2ceff4d9e0da6ae4b5a5c1a3d5e', 1536226103),
(320, 11488, '6f232628c499f65247028a0516ff5825d36adeace001d79e0f054944eb869b6d', 1536226256, 'fcd20f93c99a094e38ca0370010870aa81db789c8255d022c0156c9dcf98bac2', 1536226256),
(321, 11500, '3af68b1d88568774323660cfda08c1aedca275c9a199e0bb42f2f9923741cdf0', 1536226305, 'f1bcbb6379a16955e35e408fadc879165aa3cc1a65499673c8e768a6a3f931d5', 1536226305),
(322, 11512, '0e2dfca7456c41ff01bfdf0b5bca8c3550c7b8582ae863f969ec91958141fd87', 1536226345, 'cceeb02822a9e10a3973fb68d616097a8c60694783dff9081a829dd190c09aca', 1536226345),
(323, 11524, 'dafaef52e7fdd7d71c36702b0d26e4c699eaca7cf3aa18a4fc67294a4570190e', 1536226369, '2758c2910982c32151b7971118d67299cc1d3641ee35f6000a7bdfa5d6788227', 1536226369),
(324, 11536, '6fdd6d9a027e9256483c745a9600d46fbacca74f91bcbd5801e9d521d384a2fb', 1536226411, '572b4846dfb61ff9617371ad87b0a5efca5a5b21b3cf06801516098e1950d987', 1536226411),
(325, 11548, '30fabcc92a91b4d92e14f7bf91b4c2d0cef6671094978c743365541df7c0023d', 1536226418, '0ceb0140ea51946d770ca39f1c78126e28972b0d85d49c08ac5ba88bb0dc220e', 1536226418),
(326, 11561, '15d9fd67fc9d20f369a730294b260ee1fe9c4927b03315fe860635faa50fd9bf', 1536226468, 'cb6e8534c7887238286e6dc4c2213f7332f54326a96a482726530fac03aca7ae', 1536226468),
(327, 11589, '0e8ecc516b59486c5aaddbe07cfddbdad102fe56eea0479b8fdb159cae63680b', 1536226624, 'ada8bfbd06ddfb0689e5a7b6fa0fed3f8a696a6c5baf186cdba1f18381ce1743', 1536226624),
(328, 11601, 'cf6dcb1c58c38809a9e57cc3de03d8dd0727e56bdd52feb96bf541cc97fb0a51', 1536226713, '0e2e596c83c4717c61f76dae6a20c378e59f6fd31afb4dcf4def4f636d501cfc', 1536226713),
(329, 11615, 'e79d9c18f3f43d031d04b21a0a05dd6ab87e090074b17b40492d59731fe5b465', 1536226734, '8c615145397c7a708875390a440907687a74fa85a2f94d058b55fbc0cf5af51c', 1536226734),
(330, 11616, '79ce601a3df7aa01904f66a9bdd06faa23834dbe7c122629a4d2d7f1218396e0', 1536227085, '9c3c7c201ba6144244467025ad287c0b1e4b43d625a9506c4496332d2b608183', 1536227085),
(331, 11617, 'f08d79e965629697781eb8be8ace1621793963a55203ce45bc2281c9d1573f7c', 1536227325, '8e68f57c2f6fee0146a6a932b688a6229f917eee9006ecc25cdd1158f9b92f4c', 1536227325),
(332, 11618, '6c1da04f87992e23096903b0310fa6e8cd8b3c3cbe72c9550ee41f048b544bd6', 1536227359, '4fbcdc25cf57cc8f99d4448a243346ee9e4892e08051529c45c10feecde42467', 1536227359),
(333, 11619, 'a22bc0d0c760e4858d9b0ef90f4afac9266fc05976fca2693456c389d8dfed2b', 1536227938, 'e031f3604b15c2fe4b4bb714cf5dcb2f439992469817ae24ad89763bd5967659', 1536227938);

-- --------------------------------------------------------

--
-- 表的结构 `workflow`
--

CREATE TABLE `workflow` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT '',
  `description` varchar(100) DEFAULT '',
  `create_uid` int(11) UNSIGNED DEFAULT NULL,
  `create_time` int(11) UNSIGNED DEFAULT NULL,
  `update_uid` int(11) UNSIGNED DEFAULT NULL,
  `update_time` int(11) UNSIGNED DEFAULT NULL,
  `steps` tinyint(2) UNSIGNED DEFAULT NULL,
  `data` text,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `workflow`
--

INSERT INTO `workflow` (`id`, `name`, `description`, `create_uid`, `create_time`, `update_uid`, `update_time`, `steps`, `data`, `is_system`) VALUES
(1, '默认工作流', '', 1, 0, NULL, 0, NULL, '{\r\n  \"blocks\": [\r\n    {\r\n      \"id\": \"state_begin\",\r\n      \"positionX\": 520,\r\n      \"positionY\": 21,\r\n      \"innerHTML\": \"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\r\n      \"innerText\": \"BEGIN\"\r\n    },\r\n    {\r\n      \"id\": \"state_open\",\r\n      \"positionX\": 534,\r\n      \"positionY\": 168,\r\n      \"innerHTML\": \"OPEN<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\r\n      \"innerText\": \"OPEN\"\r\n    },\r\n    {\r\n      \"id\": \"state_resolve\",\r\n      \"positionX\": 975,\r\n      \"positionY\": 175,\r\n      \"innerHTML\": \"RESOLVE<div class=\\\"ep\\\" action=\\\"phone2\\\"></div>\",\r\n      \"innerText\": \"RESOLVE\"\r\n    },\r\n    {\r\n      \"id\": \"state_reopen\",\r\n      \"positionX\": 974,\r\n      \"positionY\": 386,\r\n      \"innerHTML\": \"REOPEN<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\r\n      \"innerText\": \"REOPEN\"\r\n    },\r\n    {\r\n      \"id\": \"state_in_progress\",\r\n      \"positionX\": 515,\r\n      \"positionY\": 345,\r\n      \"innerHTML\": \"IN PROGRESS<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\r\n      \"innerText\": \"IN PROGRESS\"\r\n    },\r\n    {\r\n      \"id\": \"state_closed\",\r\n      \"positionX\": 759,\r\n      \"positionY\": 376,\r\n      \"innerHTML\": \"CLOSED<div class=\\\"ep\\\"></div>\",\r\n      \"innerText\": \"CLOSED\"\r\n    }\r\n  ],\r\n  \"connections\": [\r\n    {\r\n      \"id\": \"con_3\",\r\n      \"sourceId\": \"state_begin\",\r\n      \"targetId\": \"state_open\"\r\n    },\r\n    {\r\n      \"id\": \"con_10\",\r\n      \"sourceId\": \"state_open\",\r\n      \"targetId\": \"state_resolve\"\r\n    },\r\n    {\r\n      \"id\": \"con_17\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_24\",\r\n      \"sourceId\": \"state_reopen\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_31\",\r\n      \"sourceId\": \"state_open\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_38\",\r\n      \"sourceId\": \"state_resolve\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_45\",\r\n      \"sourceId\": \"state_resolve\",\r\n      \"targetId\": \"state_reopen\"\r\n    },\r\n    {\r\n      \"id\": \"con_52\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_open\"\r\n    },\r\n    {\r\n      \"id\": \"con_59\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_resolve\"\r\n    },\r\n	{\r\n      \"id\": \"con_69\",\r\n      \"sourceId\": \"state_closed\",\r\n      \"targetId\": \"state_open\"\r\n    }\r\n  ]\r\n}', 1),
(2, '敏捷Bug工作流', '针对敏捷开发中bug状态流', 1, NULL, NULL, 1529647857, NULL, '{\r\n  \"blocks\": [\r\n    {\r\n      \"id\": \"state_begin\",\r\n      \"positionX\": 520,\r\n      \"positionY\": 21,\r\n      \"innerHTML\": \"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\r\n      \"innerText\": \"BEGIN\"\r\n    },\r\n    {\r\n      \"id\": \"state_open\",\r\n      \"positionX\": 534,\r\n      \"positionY\": 168,\r\n      \"innerHTML\": \"OPEN<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\r\n      \"innerText\": \"OPEN\"\r\n    },\r\n    {\r\n      \"id\": \"state_resolve\",\r\n      \"positionX\": 975,\r\n      \"positionY\": 175,\r\n      \"innerHTML\": \"RESOLVE<div class=\\\"ep\\\" action=\\\"phone2\\\"></div>\",\r\n      \"innerText\": \"RESOLVE\"\r\n    },\r\n    {\r\n      \"id\": \"state_reopen\",\r\n      \"positionX\": 974,\r\n      \"positionY\": 386,\r\n      \"innerHTML\": \"REOPEN<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\r\n      \"innerText\": \"REOPEN\"\r\n    },\r\n    {\r\n      \"id\": \"state_in_progress\",\r\n      \"positionX\": 515,\r\n      \"positionY\": 345,\r\n      \"innerHTML\": \"IN PROGRESS<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\r\n      \"innerText\": \"IN PROGRESS\"\r\n    },\r\n    {\r\n      \"id\": \"state_closed\",\r\n      \"positionX\": 759,\r\n      \"positionY\": 376,\r\n      \"innerHTML\": \"CLOSED<div class=\\\"ep\\\"></div>\",\r\n      \"innerText\": \"CLOSED\"\r\n    }\r\n  ],\r\n  \"connections\": [\r\n    {\r\n      \"id\": \"con_3\",\r\n      \"sourceId\": \"state_begin\",\r\n      \"targetId\": \"state_open\"\r\n    },\r\n    {\r\n      \"id\": \"con_10\",\r\n      \"sourceId\": \"state_open\",\r\n      \"targetId\": \"state_resolve\"\r\n    },\r\n    {\r\n      \"id\": \"con_17\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_24\",\r\n      \"sourceId\": \"state_reopen\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_31\",\r\n      \"sourceId\": \"state_open\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_38\",\r\n      \"sourceId\": \"state_resolve\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_45\",\r\n      \"sourceId\": \"state_resolve\",\r\n      \"targetId\": \"state_reopen\"\r\n    },\r\n    {\r\n      \"id\": \"con_52\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_open\"\r\n    },\r\n    {\r\n      \"id\": \"con_59\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_resolve\"\r\n    },\r\n	{\r\n      \"id\": \"con_69\",\r\n      \"sourceId\": \"state_closed\",\r\n      \"targetId\": \"state_open\"\r\n    }\r\n  ]\r\n}', 1),
(3, 'Task工作流', '', 1, NULL, NULL, 1529642062, NULL, '{\r\n  \"blocks\": [\r\n    {\r\n      \"id\": \"state_begin\",\r\n      \"positionX\": 520,\r\n      \"positionY\": 21,\r\n      \"innerHTML\": \"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\r\n      \"innerText\": \"BEGIN\"\r\n    },\r\n    {\r\n      \"id\": \"state_open\",\r\n      \"positionX\": 534,\r\n      \"positionY\": 168,\r\n      \"innerHTML\": \"OPEN<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\r\n      \"innerText\": \"OPEN\"\r\n    },\r\n    {\r\n      \"id\": \"state_resolve\",\r\n      \"positionX\": 975,\r\n      \"positionY\": 175,\r\n      \"innerHTML\": \"RESOLVE<div class=\\\"ep\\\" action=\\\"phone2\\\"></div>\",\r\n      \"innerText\": \"RESOLVE\"\r\n    },\r\n    {\r\n      \"id\": \"state_reopen\",\r\n      \"positionX\": 974,\r\n      \"positionY\": 386,\r\n      \"innerHTML\": \"REOPEN<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\r\n      \"innerText\": \"REOPEN\"\r\n    },\r\n    {\r\n      \"id\": \"state_in_progress\",\r\n      \"positionX\": 515,\r\n      \"positionY\": 345,\r\n      \"innerHTML\": \"IN PROGRESS<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\r\n      \"innerText\": \"IN PROGRESS\"\r\n    },\r\n    {\r\n      \"id\": \"state_closed\",\r\n      \"positionX\": 759,\r\n      \"positionY\": 376,\r\n      \"innerHTML\": \"CLOSED<div class=\\\"ep\\\"></div>\",\r\n      \"innerText\": \"CLOSED\"\r\n    }\r\n  ],\r\n  \"connections\": [\r\n    {\r\n      \"id\": \"con_3\",\r\n      \"sourceId\": \"state_begin\",\r\n      \"targetId\": \"state_open\"\r\n    },\r\n    {\r\n      \"id\": \"con_10\",\r\n      \"sourceId\": \"state_open\",\r\n      \"targetId\": \"state_resolve\"\r\n    },\r\n    {\r\n      \"id\": \"con_17\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_24\",\r\n      \"sourceId\": \"state_reopen\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_31\",\r\n      \"sourceId\": \"state_open\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_38\",\r\n      \"sourceId\": \"state_resolve\",\r\n      \"targetId\": \"state_closed\"\r\n    },\r\n    {\r\n      \"id\": \"con_45\",\r\n      \"sourceId\": \"state_resolve\",\r\n      \"targetId\": \"state_reopen\"\r\n    },\r\n    {\r\n      \"id\": \"con_52\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_open\"\r\n    },\r\n    {\r\n      \"id\": \"con_59\",\r\n      \"sourceId\": \"state_in_progress\",\r\n      \"targetId\": \"state_resolve\"\r\n    },\r\n	{\r\n      \"id\": \"con_69\",\r\n      \"sourceId\": \"state_closed\",\r\n      \"targetId\": \"state_open\"\r\n    }\r\n  ]\r\n}', 1),
(4, 'test-name-85049', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(5, 'updated-name-46612', 'updated-description', 11256, 1536214842, NULL, 1536214842, NULL, '{}', 0),
(6, 'test-name-973756', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(7, 'test-name-266707', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(8, 'test-name-295380', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(9, 'test-name-578753', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(10, 'updated-name-73410', 'updated-description', 11262, 1536215524, NULL, 1536215524, NULL, '{}', 0),
(12, 'test-name-15033', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0);

-- --------------------------------------------------------

--
-- 表的结构 `workflow_block`
--

CREATE TABLE `workflow_block` (
  `id` int(11) UNSIGNED NOT NULL,
  `workflow_id` int(11) UNSIGNED DEFAULT NULL,
  `status_id` int(11) UNSIGNED DEFAULT NULL,
  `blcok_id` varchar(64) DEFAULT NULL,
  `position_x` smallint(4) UNSIGNED DEFAULT NULL,
  `position_y` smallint(4) UNSIGNED DEFAULT NULL,
  `inner_html` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `workflow_connector`
--

CREATE TABLE `workflow_connector` (
  `id` int(11) UNSIGNED NOT NULL,
  `workflow_id` int(11) UNSIGNED DEFAULT NULL,
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
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `workflow_scheme`
--

INSERT INTO `workflow_scheme` (`id`, `name`, `description`, `is_system`) VALUES
(1, '默认工作流方案', '', 0),
(10100, '敏捷开发工作流方案', '敏捷开发适用', 0),
(10101, '普通的软件开发工作流方案', '', 0),
(10102, '流程管理工作流方案', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `workflow_scheme_data`
--

CREATE TABLE `workflow_scheme_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `scheme_id` int(11) UNSIGNED DEFAULT NULL,
  `issue_type_id` int(11) UNSIGNED DEFAULT NULL,
  `workflow_id` int(11) UNSIGNED DEFAULT NULL
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
-- Indexes for dumped tables
--

--
-- Indexes for table `agile_board`
--
ALTER TABLE `agile_board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `weight` (`weight`);

--
-- Indexes for table `agile_board_column`
--
ALTER TABLE `agile_board_column`
  ADD PRIMARY KEY (`id`),
  ADD KEY `board_id` (`board_id`),
  ADD KEY `id_and_weight` (`id`,`weight`) USING BTREE;

--
-- Indexes for table `agile_sprint`
--
ALTER TABLE `agile_sprint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sprint_id` (`sprint_id`),
  ADD KEY `sprintIdAndDate` (`sprint_id`,`date`);

--
-- Indexes for table `audit_changed_value`
--
ALTER TABLE `audit_changed_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_changed_value_log_id` (`log_id`);

--
-- Indexes for table `audit_item`
--
ALTER TABLE `audit_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_item_log_id2` (`log_id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_log_created` (`created`);

--
-- Indexes for table `changeitem`
--
ALTER TABLE `changeitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chgitem_chggrp` (`origin_id`),
  ADD KEY `chgitem_field` (`field`);

--
-- Indexes for table `field_custom_value`
--
ALTER TABLE `field_custom_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cfvalue_issue` (`issue_id`,`custom_field_id`);

--
-- Indexes for table `field_layout_default`
--
ALTER TABLE `field_layout_default`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_layout_project_custom`
--
ALTER TABLE `field_layout_project_custom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `field_main`
--
ALTER TABLE `field_main`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fli_fieldidentifier` (`name`),
  ADD KEY `order_weight` (`order_weight`);

--
-- Indexes for table `field_type`
--
ALTER TABLE `field_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`) USING BTREE;

--
-- Indexes for table `issue_assistant`
--
ALTER TABLE `issue_assistant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_id`);

--
-- Indexes for table `issue_description_template`
--
ALTER TABLE `issue_description_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_field_layout_project`
--
ALTER TABLE `issue_field_layout_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fli_fieldidentifier` (`fieldidentifier`);

--
-- Indexes for table `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attach_issue` (`issue_id`),
  ADD KEY `uuid` (`uuid`);

--
-- Indexes for table `issue_filter`
--
ALTER TABLE `issue_filter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sr_author` (`author`),
  ADD KEY `searchrequest_filternameLower` (`name_lower`);

--
-- Indexes for table `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_follow`
--
ALTER TABLE `issue_follow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issue_id` (`issue_id`,`user_id`);

--
-- Indexes for table `issue_label`
--
ALTER TABLE `issue_label`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `issue_label_data`
--
ALTER TABLE `issue_label_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_main`
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
  ADD KEY `sprint_weight` (`sprint_weight`);

--
-- Indexes for table `issue_moved_issue_key`
--
ALTER TABLE `issue_moved_issue_key`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_old_issue_key` (`old_issue_key`);

--
-- Indexes for table `issue_priority`
--
ALTER TABLE `issue_priority`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`);

--
-- Indexes for table `issue_recycle`
--
ALTER TABLE `issue_recycle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_assignee` (`assignee`),
  ADD KEY `summary` (`summary`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `issue_resolve`
--
ALTER TABLE `issue_resolve`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`);

--
-- Indexes for table `issue_status`
--
ALTER TABLE `issue_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`_key`);

--
-- Indexes for table `issue_type`
--
ALTER TABLE `issue_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`);

--
-- Indexes for table `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scheme_id` (`scheme_id`) USING HASH;

--
-- Indexes for table `issue_ui`
--
ALTER TABLE `issue_ui`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_type_id`) USING BTREE;

--
-- Indexes for table `job_run_details`
--
ALTER TABLE `job_run_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rundetails_jobid_idx` (`job_id`),
  ADD KEY `rundetails_starttime_idx` (`start_time`);

--
-- Indexes for table `log_base`
--
ALTER TABLE `log_base`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING HASH,
  ADD KEY `obj_id` (`obj_id`) USING BTREE,
  ADD KEY `like_query` (`uid`,`action`,`remark`) USING BTREE;

--
-- Indexes for table `log_operating`
--
ALTER TABLE `log_operating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING HASH,
  ADD KEY `obj_id` (`obj_id`) USING BTREE,
  ADD KEY `like_query` (`uid`,`action`,`remark`) USING BTREE;

--
-- Indexes for table `main_action`
--
ALTER TABLE `main_action`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_author_created` (`author`,`created`),
  ADD KEY `action_issue` (`issueid`);

--
-- Indexes for table `main_activity`
--
ALTER TABLE `main_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `main_announcement`
--
ALTER TABLE `main_announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_cache_key`
--
ALTER TABLE `main_cache_key`
  ADD PRIMARY KEY (`key`),
  ADD UNIQUE KEY `module_key` (`key`,`module`) USING BTREE,
  ADD KEY `module` (`module`),
  ADD KEY `expire` (`expire`);

--
-- Indexes for table `main_eventtype`
--
ALTER TABLE `main_eventtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_group`
--
ALTER TABLE `main_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `main_mailserver`
--
ALTER TABLE `main_mailserver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `main_org`
--
ALTER TABLE `main_org`
  ADD PRIMARY KEY (`id`),
  ADD KEY `path` (`path`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `main_setting`
--
ALTER TABLE `main_setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`),
  ADD KEY `module` (`module`) USING BTREE;

--
-- Indexes for table `main_timeline`
--
ALTER TABLE `main_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ntfctn_scheme` (`scheme`);

--
-- Indexes for table `notification_instance`
--
ALTER TABLE `notification_instance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notif_source` (`source`),
  ADD KEY `notif_messageid` (`messageid`);

--
-- Indexes for table `notification_scheme`
--
ALTER TABLE `notification_scheme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option_configuration`
--
ALTER TABLE `option_configuration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fieldid_optionid` (`fieldid`,`optionid`),
  ADD KEY `fieldid_fieldconf` (`fieldid`,`fieldconfig`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_key_idx` (`_key`);

--
-- Indexes for table `permission_default_role`
--
ALTER TABLE `permission_default_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `default_role_id` (`default_role_id`) USING HASH,
  ADD KEY `role_id-and-perm_id` (`default_role_id`,`perm_id`) USING HASH;

--
-- Indexes for table `permission_global`
--
ALTER TABLE `permission_global`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`);

--
-- Indexes for table `permission_global_group`
--
ALTER TABLE `permission_global_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perm_global_id` (`perm_global_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `permission_global_relation`
--
ALTER TABLE `permission_global_relation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`perm_global_id`,`group_id`) USING BTREE,
  ADD KEY `perm_global_id` (`perm_global_id`) USING HASH;

--
-- Indexes for table `project_category`
--
ALTER TABLE `project_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_project_category_name` (`name`);

--
-- Indexes for table `project_issue_report`
--
ALTER TABLE `project_issue_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `projectIdAndDate` (`project_id`,`date`);

--
-- Indexes for table `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE,
  ADD KEY `issue_type_scheme_id` (`issue_type_scheme_id`) USING BTREE;

--
-- Indexes for table `project_key`
--
ALTER TABLE `project_key`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_all_project_keys` (`project_key`),
  ADD KEY `idx_all_project_ids` (`project_id`);

--
-- Indexes for table `project_label`
--
ALTER TABLE `project_label`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_list_count`
--
ALTER TABLE `project_list_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_main`
--
ALTER TABLE `project_main`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_project_key` (`key`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD KEY `uid` (`create_uid`);

--
-- Indexes for table `project_module`
--
ALTER TABLE `project_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`) USING BTREE;

--
-- Indexes for table `project_role`
--
ALTER TABLE `project_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_role_relation`
--
ALTER TABLE `project_role_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`) USING HASH,
  ADD KEY `role_id-and-perm_id` (`role_id`,`perm_id`) USING HASH,
  ADD KEY `unique_data` (`project_id`,`role_id`,`perm_id`);

--
-- Indexes for table `project_user_role`
--
ALTER TABLE `project_user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`user_id`,`project_id`,`role_id`) USING BTREE,
  ADD KEY `uid` (`user_id`) USING BTREE,
  ADD KEY `uid_project` (`user_id`,`project_id`) USING BTREE;

--
-- Indexes for table `project_version`
--
ALTER TABLE `project_version`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_name_unique` (`project_id`,`name`) USING BTREE,
  ADD KEY `idx_version_project` (`project_id`),
  ADD KEY `idx_version_sequence` (`sequence`);

--
-- Indexes for table `project_workflows`
--
ALTER TABLE `project_workflows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_workflow_status`
--
ALTER TABLE `project_workflow_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_name` (`parentname`);

--
-- Indexes for table `report_project_issue`
--
ALTER TABLE `report_project_issue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `projectIdAndDate` (`project_id`,`date`);

--
-- Indexes for table `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sprint_id` (`sprint_id`),
  ADD KEY `sprintIdAndDate` (`sprint_id`,`date`);

--
-- Indexes for table `service_config`
--
ALTER TABLE `service_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_application`
--
ALTER TABLE `user_application`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_application_name` (`lower_application_name`);

--
-- Indexes for table `user_attributes`
--
ALTER TABLE `user_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uk_user_attr_name_lval` (`user_id`,`attribute_name`),
  ADD KEY `idx_user_attr_dir_name_lval` (`directory_id`,`attribute_name`(240),`lower_attribute_value`(240)) USING BTREE;

--
-- Indexes for table `user_email_active`
--
ALTER TABLE `user_email_active`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`,`verify_code`);

--
-- Indexes for table `user_email_find_password`
--
ALTER TABLE `user_email_find_password`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `email` (`email`,`verify_code`);

--
-- Indexes for table `user_email_token`
--
ALTER TABLE `user_email_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`uid`,`group_id`) USING BTREE,
  ADD KEY `uid` (`uid`) USING HASH,
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `user_login_log`
--
ALTER TABLE `user_login_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_main`
--
ALTER TABLE `user_main`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `openid` (`openid`),
  ADD KEY `email` (`email`),
  ADD KEY `username` (`username`) USING HASH;

--
-- Indexes for table `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_password`
--
ALTER TABLE `user_password`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_password_strategy`
--
ALTER TABLE `user_password_strategy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_phone_find_password`
--
ALTER TABLE `user_phone_find_password`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`phone`);

--
-- Indexes for table `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `refresh_token` (`refresh_token`(255));

--
-- Indexes for table `user_setting`
--
ALTER TABLE `user_setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING HASH;

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow`
--
ALTER TABLE `workflow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow_block`
--
ALTER TABLE `workflow_block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_id` (`workflow_id`) USING HASH;

--
-- Indexes for table `workflow_connector`
--
ALTER TABLE `workflow_connector`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_id` (`workflow_id`) USING HASH;

--
-- Indexes for table `workflow_scheme`
--
ALTER TABLE `workflow_scheme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workflow_scheme_data`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `agile_board_column`
--
ALTER TABLE `agile_board_column`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `agile_sprint`
--
ALTER TABLE `agile_sprint`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_main`
--
ALTER TABLE `field_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `issue_description_template`
--
ALTER TABLE `issue_description_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10713;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `issue_follow`
--
ALTER TABLE `issue_follow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `issue_label`
--
ALTER TABLE `issue_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `issue_label_data`
--
ALTER TABLE `issue_label_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `issue_main`
--
ALTER TABLE `issue_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_priority`
--
ALTER TABLE `issue_priority`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_recycle`
--
ALTER TABLE `issue_recycle`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_resolve`
--
ALTER TABLE `issue_resolve`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10102;

--
-- 使用表AUTO_INCREMENT `issue_status`
--
ALTER TABLE `issue_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10104;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `log_base`
--
ALTER TABLE `log_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 使用表AUTO_INCREMENT `log_operating`
--
ALTER TABLE `log_operating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;

--
-- 使用表AUTO_INCREMENT `main_activity`
--
ALTER TABLE `main_activity`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `main_group`
--
ALTER TABLE `main_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `main_org`
--
ALTER TABLE `main_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `main_setting`
--
ALTER TABLE `main_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用表AUTO_INCREMENT `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10905;

--
-- 使用表AUTO_INCREMENT `permission_default_role`
--
ALTER TABLE `permission_default_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10007;

--
-- 使用表AUTO_INCREMENT `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- 使用表AUTO_INCREMENT `permission_global_group`
--
ALTER TABLE `permission_global_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `permission_global_relation`
--
ALTER TABLE `permission_global_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(18) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_issue_report`
--
ALTER TABLE `project_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `project_label`
--
ALTER TABLE `project_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `project_list_count`
--
ALTER TABLE `project_list_count`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_main`
--
ALTER TABLE `project_main`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 使用表AUTO_INCREMENT `project_user_role`
--
ALTER TABLE `project_user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_version`
--
ALTER TABLE `project_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `report_project_issue`
--
ALTER TABLE `report_project_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- 使用表AUTO_INCREMENT `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- 使用表AUTO_INCREMENT `user_email_active`
--
ALTER TABLE `user_email_active`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `user_email_token`
--
ALTER TABLE `user_email_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10528;

--
-- 使用表AUTO_INCREMENT `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=590;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11654;

--
-- 使用表AUTO_INCREMENT `user_message`
--
ALTER TABLE `user_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_phone_find_password`
--
ALTER TABLE `user_phone_find_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_setting`
--
ALTER TABLE `user_setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `workflow_block`
--
ALTER TABLE `workflow_block`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `workflow_connector`
--
ALTER TABLE `workflow_connector`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `workflow_scheme`
--
ALTER TABLE `workflow_scheme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10306;

--
-- 使用表AUTO_INCREMENT `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10326;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
