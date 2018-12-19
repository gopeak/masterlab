-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2018-12-19 10:39:48
-- 服务器版本： 5.7.24
-- PHP 版本： 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `masterlab_demo`
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

--
-- 转存表中的数据 `agile_sprint`
--

INSERT INTO `agile_sprint` (`id`, `project_id`, `name`, `description`, `active`, `status`, `order_weight`, `start_date`, `end_date`) VALUES
(1, 1, '第一次迭代', '', 1, 1, 0, '2018-09-14', '2018-09-30'),
(2, 3, '第二次迭代', '', 0, 1, 0, '2018-10-10', '2018-10-30'),
(3, 3, '第三次迭代', '本次迭代结束后发布1.0版本，这是一个正式的对外宣传推广的版本', 0, 1, 0, '2018-10-30', '2018-11-07'),
(4, 3, '第四次迭代', '对外发布前的迭代', 1, 1, 0, '2018-11-28', '2018-12-18'),
(20, 31, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(42, 116, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(64, 201, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(86, 286, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(108, 371, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(116, 2, 'qwwq', 'ewwe', 1, 1, 0, '2018-12-19', '2018-12-26'),
(131, 460, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(153, 545, 'test-name', NULL, 0, 0, 0, NULL, NULL);

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
(20, 'assistants', '协助人', '协助人', 'USER_MULTI', NULL, 1, '', 900),
(21, 'weight', '权 重', '待办事项中的权重值', 'TEXT', '0', 1, '', 0);

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
-- 表的结构 `hornet_cache_key`
--

CREATE TABLE `hornet_cache_key` (
  `key` varchar(100) NOT NULL,
  `module` varchar(64) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `expire` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hornet_cache_key`
--

INSERT INTO `hornet_cache_key` (`key`, `module`, `datetime`, `expire`) VALUES
('1', 'list', NULL, NULL),
('2', 'list', NULL, NULL),
('3', 'lsit', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `hornet_user`
--

CREATE TABLE `hornet_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1' COMMENT '用户状态:1正常,2禁用',
  `reg_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_login_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `company_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

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
(2, 3, 10000, 0),
(4, 50, 11654, 0),
(5, 27, 1, 0),
(6, 27, 1, 0),
(7, 27, 5, 0),
(8, 27, 5, 0),
(9, 27, 6, 0),
(16, 57, 0, 0),
(17, 57, 0, 0),
(18, 57, 0, 0),
(19, 57, 0, 0),
(20, 57, 1, 0),
(21, 57, 1, 0),
(22, 57, 4, 0),
(23, 57, 5, 0),
(24, 57, 6, 0),
(26, 543, 1, 0),
(27, 543, 1, 0),
(28, 543, 2, 0),
(29, 543, 5, 0),
(30, 543, 6, 0);

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
  `tmp_issue_id` varchar(32) NOT NULL,
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

INSERT INTO `issue_file_attachment` (`id`, `uuid`, `issue_id`, `tmp_issue_id`, `mime_type`, `origin_name`, `file_name`, `created`, `file_size`, `author`, `file_ext`) VALUES
(103, 'uuid-712532', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978581, 44055, 0, 'png'),
(104, 'uuid-993467', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978581, 44055, 0, 'png'),
(105, 'uuid-772198', 17498, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978645, 44055, 0, 'png'),
(106, 'uuid-146109', 17498, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978645, 44055, 0, 'png'),
(107, 'uuid-465118', 17519, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978896, 44055, 0, 'png'),
(108, 'uuid-59892', 17519, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535978896, 44055, 0, 'png'),
(115, 'uuid-277157', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980570, 44055, 0, 'png'),
(116, 'uuid-146026', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980570, 44055, 0, 'png'),
(117, 'uuid-975366', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980625, 44055, 0, 'png'),
(118, 'uuid-833512', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980625, 44055, 0, 'png'),
(121, 'uuid-511211', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980688, 44055, 0, 'png'),
(122, 'uuid-763956', 0, '', 'image/png', 'sample.png', 'attached/unittest/sample.png', 1535980688, 44055, 0, 'png'),
(129, '', 0, '', 'application/octet-stream', '', 'all/20180903/20180903213321_46866.png', 1535981601, 0, 11159, 'png'),
(132, '', 0, '', 'application/octet-stream', '', 'all/20180903/20180903213345_35880.png', 1535981625, 0, 11160, 'png'),
(144, '0AiNJtaJ1qoS6LDe573167', 0, '', 'application/octet-stream', 'sample.png', 'all/20180903/20180903215007_66586.png', 1535982607, 0, 11164, 'png'),
(181, '7kqrIJwuJAf8No7g804506', 0, '', 'application/octet-stream', 'sample.png', 'image/20180904/20180904104101_69813.png', 1536028861, 44055, 11177, 'png'),
(183, 'ded1ff3e-d609-4b88-9bd2-6adad6108728', 18273, '', 'image/png', '1.png', 'all/20180909/20180909033816_97784.png', 1536435496, 899531, 10000, 'png'),
(185, '47fd88aa-cd83-48ac-b98f-a6b670ae9944', 1, '', 'image/jpeg', 'timg.jpg', 'all/20180913/20180913001332_27981.jpg', 1536768812, 30069, 10000, 'jpg'),
(186, '3f65aea2-1009-4bbf-9fe2-f4f25974ecb4', 2, '', 'image/jpeg', 'db.jpg', 'all/20180913/20180913001723_53905.jpg', 1536769043, 29271, 10000, 'jpg'),
(187, '7da87baa-9435-4f00-aeba-459a7dff00c1', 0, '', 'image/jpeg', 'header.jpg', 'all/20180913/20180913103944_11662.jpg', 1536806384, 19282, 10000, 'jpg'),
(188, '8d76f0a9-b9f5-4912-aa64-ff79d0b62eda', 0, '', 'image/jpeg', 'header.jpg', 'all/20180913/20180913104002_60614.jpg', 1536806402, 19282, 10000, 'jpg'),
(189, '601ad8ec-f2de-4b82-9669-93a5d06db3bc', 0, '', 'image/jpeg', 'timg.jpg', 'avatar/20180913/20180913144720_35657.jpg', 1536821240, 10975, 10000, 'jpg'),
(190, '313e6dc3-515c-4b1d-bcdf-cc8f2062dd3b', 0, '', 'image/jpeg', 'timg.jpg', 'avatar/20180913/20180913144752_28827.jpg', 1536821272, 10975, 10000, 'jpg'),
(191, 'b33d72a9-0935-4101-89a8-9a739bdc469e', 0, '', 'image/jpeg', 'crm.jpg', 'avatar/20180913/20180913152541_67492.jpg', 1536823541, 35359, 10000, 'jpg'),
(192, '30969360-9603-486f-a886-4cb469921486', 0, '', 'image/jpeg', 'crm.jpg', 'avatar/20180913/20180913152652_67614.jpg', 1536823612, 35359, 10000, 'jpg'),
(193, 'a6637c2a-88ba-455c-a660-328302cd1c12', 0, '', 'image/jpeg', 'crm.jpg', 'avatar/20180913/20180913153035_77852.jpg', 1536823835, 12416, 10000, 'jpg'),
(194, '5e654090-a516-41a5-b7cd-a04e2079de3d', 4, '', 'image/jpeg', '4fb349516dc14993d2303f42c87f1793.jpg', 'all/20180913/20180913185638_85846.jpg', 1536836198, 90410, 10000, 'jpg'),
(195, '9b06bbad-50a9-4231-ba33-57b583a58719', 0, '', 'image/jpeg', 'logo.jpg', 'avatar/20181009/20181009205539_99679.jpg', 1539089739, 105843, 10000, 'jpg'),
(196, '198a60d0-63e7-463c-94cd-232dd1f93d5f', 0, '', 'image/png', 'logo.png', 'avatar/20181009/20181009205544_24831.png', 1539089744, 30523, 10000, 'png'),
(197, '1539091449052', 0, '', 'image/png', '1.png', 'image/20181009/20181009212502_76081.png', 1539091502, 54243, 10000, 'png'),
(198, '9baddd10-0dff-4fbf-98fe-d5d0ff817c93', 9, '', 'image/png', '1.png', 'all/20181009/20181009212552_20118.png', 1539091552, 54243, 10000, 'png'),
(199, 'c162ee06-df40-42be-942a-6fcdc5065141', 0, '', 'image/png', '1.png', 'all/20181009/20181009212614_72354.png', 1539091574, 54243, 10000, 'png'),
(200, 'ceb7b4c2-e70f-4746-b41a-1f9cc3e3d6de', 13, '', 'image/png', '2.png', 'all/20181009/20181009214049_56753.png', 1539092449, 42886, 10000, 'png'),
(201, '1539092453840', 0, '', 'image/png', '2.png', 'image/20181009/20181009214057_50420.png', 1539092457, 42886, 10000, 'png'),
(202, '1539092839460', 0, '', 'image/png', '3.png', 'image/20181009/20181009214739_63122.png', 1539092859, 28888, 10000, 'png'),
(203, '1539092911620', 0, '', 'image/png', '3.png', 'image/20181009/20181009214837_48090.png', 1539092917, 28888, 10000, 'png'),
(205, '52364059-7774-48e8-929d-48a802015b75', 15, '', 'image/png', '5.png', 'all/20181009/20181009215507_33404.png', 1539093307, 34979, 10000, 'png'),
(206, '4603e3e2-9c49-4fc3-98b6-05a5c819d657', 15, '', 'image/png', '4.png', 'all/20181009/20181009215509_35501.png', 1539093309, 60032, 10000, 'png'),
(207, 'c67ccc5c-b296-481a-a0d8-5d94fa3256c3', 16, '', 'image/png', 'QQ浏览器截图20181010095012.png', 'all/20181010/20181010100815_36235.png', 1539137295, 94549, 0, 'png'),
(208, 'ac131ef5-2ec2-46dc-a924-c3fc1c833891', 18, '', 'image/png', 'QQ浏览器截图20181010095012.png', 'all/20181010/20181010100934_80087.png', 1539137374, 94549, 0, 'png'),
(209, 'defc24a2-7fd1-45b8-8c63-eb3cd66a0389', 19, '', 'image/png', 'QQ浏览器截图20181010095012.png', 'all/20181010/20181010101443_67678.png', 1539137683, 94549, 10000, 'png'),
(210, '741a5d95-fb2f-4b33-8ba0-7954f2727805', 20, '', 'image/png', '11.png', 'all/20181010/20181010110017_32707.png', 1539140417, 21097, 10000, 'png'),
(211, 'c43981dc-f1e4-4285-b229-d6ba5d6d71e0', 21, '', 'image/png', '1.png', 'all/20181010/20181010110707_49925.png', 1539140827, 15472, 10000, 'png'),
(212, 'c2cec963-4825-427f-bf0f-670532681519', 21, '', 'image/png', '2.png', 'all/20181010/20181010110710_33700.png', 1539140830, 34071, 10000, 'png'),
(213, 'c221cdb6-1514-4733-afe6-31f7e840f2cd', 22, '', 'image/png', '3.png', 'all/20181010/20181010111515_91936.png', 1539141315, 37331, 10000, 'png'),
(215, '55cb8cd4-1070-41d3-b5bd-90721ade9313', 33, '', 'image/png', '1.png', 'all/20181013/20181013170345_25108.png', 1539421425, 73592, 10000, 'png'),
(216, 'c6d45b50-6b34-4e75-bad2-d11901c0c6b7', 0, '', 'image/png', '4.png', 'avatar/20181013/20181013174944_99998.png', 1539424184, 60032, 10000, 'png'),
(217, '5cf03bca-7b92-4d46-b3eb-2e5343f04683', 0, '', 'image/png', 'logo.png', 'avatar/20181015/20181015102601_18003.png', 1539570361, 30523, 10000, 'png'),
(218, 'b4713f66-717c-419a-b5b3-d492b3bdaa8e', 0, '', 'image/png', '快捷键.png', 'all/20181015/20181015181442_62320.png', 1539598482, 67056, 10000, 'png'),
(219, 'e8db6fe3-54ea-4166-851e-3cd748b09e76', 0, '', 'image/jpeg', '0.jpg', 'all/20181016/20181016162653_79134.jpg', 1539678413, 22825, 10000, 'jpg'),
(220, '333cb36f-ac36-4abd-92d2-a7139affeae5', 0, '', 'application/zip', '2017-02-19.zip', 'all/20181016/20181016162829_83890.zip', 1539678509, 953, 10000, 'zip'),
(221, 'aa2e5da3-bb82-4a1d-bb9d-5ae6c47d2912', 0, '', 'image/jpeg', '阿里云幕布背景照.JPG', 'all/20181016/20181016163024_69184.jpg', 1539678624, 2125857, 10000, 'jpg'),
(223, '6984f771-ce24-4763-b750-1d147574a409', 0, '', 'image/jpeg', 'crm.jpg', 'avatar/20181017/20181017180352_48634.jpg', 1539770632, 12416, 10000, 'jpg'),
(224, '9736e657-a7bd-41de-801f-d69753b74939', 0, '', 'image/jpeg', '1-1F414120137.jpg', 'avatar/20181017/20181017180420_62985.jpg', 1539770660, 24383, 10000, 'jpg'),
(226, '4f14629d-1af1-4d11-83f1-0d62d809b1f9', 40, '', 'image/png', '11.png', 'all/20181022/20181022235802_34514.png', 1540223882, 21276, 10000, 'png'),
(227, '1b22475e-72bf-4521-8470-83e5a0041352', 41, '', 'image/png', '11.png', 'all/20181023/20181023000000_64903.png', 1540224000, 21276, 10000, 'png'),
(228, '3ce52f1a-8f24-46bb-afb6-1324fa38a883', 0, '', 'image/png', '22.png', 'all/20181023/20181023001721_42173.png', 1540225041, 42983, 10000, 'png'),
(229, '097c9abe-6575-4767-9f78-e9a902c7bfdf', 43, '', 'image/png', '22.png', 'all/20181023/20181023002424_19078.png', 1540225464, 42983, 10000, 'png'),
(232, '7e9338b9-6529-4626-b84c-0c4c382d0f06', 46, '', 'image/png', '11.png', 'all/20181024/20181024014723_67162.png', 1540316843, 56265, 10000, 'png'),
(233, '6d1301ad-1fa1-4a4d-8290-039c8b19783e', 48, '', 'image/png', '232.png', 'all/20181024/20181024015625_44742.png', 1540317385, 40565, 10000, 'png'),
(234, 'c28fcc1b-d2c3-4bda-9e4a-63a564c05167', 49, '', 'image/png', 'biaoqian.png', 'all/20181025/20181025000936_66013.png', 1540397376, 26102, 10000, 'png'),
(235, '5413d8b4-679e-4bf7-8b6e-ce5fc041e139', 50, '', 'image/png', '22.png', 'all/20181025/20181025001207_69843.png', 1540397527, 67445, 10000, 'png'),
(237, '29674b15-b7ad-41e1-b8ed-bd6a8baaf720', 52, '', 'image/png', '11.png', 'all/20181025/20181025112753_17125.png', 1540438073, 48753, 10000, 'png'),
(238, '4a98cc74-fcdb-4ff2-8272-ed1ad79a6dde', 53, '', 'image/png', '5.png', 'all/20181026/20181026142056_98414.png', 1540534856, 36829, 10000, 'png'),
(239, 'bc359ad4-44dc-47b0-bd28-9e3f446c8b4c', 53, '', 'image/png', '4.png', 'all/20181026/20181026142056_75187.png', 1540534856, 37535, 10000, 'png'),
(240, '7ef11733-0a03-490e-931a-b355ab7bc49f', 53, '', 'image/png', '3.png', 'all/20181026/20181026142056_87452.png', 1540534856, 44867, 10000, 'png'),
(241, '24d69909-7a95-4f8d-a879-c66d15e5ff56', 53, '', 'image/png', '1.png', 'all/20181026/20181026142056_54308.png', 1540534856, 27101, 10000, 'png'),
(242, 'fa46a465-2126-4deb-a039-3a3f7b8e5169', 53, '', 'image/png', '2.png', 'all/20181026/20181026142056_74544.png', 1540534856, 51433, 10000, 'png'),
(243, '9e389fb0-2c0c-40b9-ba65-02a18126f06b', 54, '', 'image/png', '11.png', 'all/20181027/20181027011053_47594.png', 1540573853, 37614, 10000, 'png'),
(244, 'ec2fd5d0-092c-4566-896c-7b7542e3e4e5', 56, '', 'image/png', '11.png', 'all/20181027/20181027195230_24330.png', 1540641150, 54982, 10000, 'png'),
(245, 'c42aeef9-558c-4485-9aad-dca4764b88e3', 4, '', 'image/jpeg', '818A8A6F-7EC2-49CC-8971-DE808A47D762.jpeg', 'all/20181027/20181027203436_76970.jpeg', 1540643676, 180034, 10000, 'jpeg'),
(246, 'ce0e08cf-0227-4409-9d29-c7c97940c5bb', 65, '', 'image/png', '11.png', 'all/20181029/20181029163720_89642.png', 1540802240, 69504, 10000, 'png'),
(247, 'cbf12885-dd6a-4458-a568-361769046757', 66, '', 'image/png', 'detail.png', 'all/20181030/20181030012613_49168.png', 1540833973, 88152, 10000, 'png'),
(248, '574af719-1eab-4478-b3cf-3042b8d785b4', 69, '', 'image/png', 'select_version_module_error.png', 'all/20181031/20181031115824_71693.png', 1540958304, 45498, 10000, 'png'),
(249, '9202c952-9c0a-4e9b-97e9-580cbdc40876', 69, '', 'image/png', 'add_version_failed.png', 'all/20181031/20181031115824_89927.png', 1540958304, 42973, 10000, 'png'),
(250, '2fa5845a-8e76-4466-b3a2-c7a7f6967568', 59, '', 'image/png', 'QQ图片20181102110746.png', 'all/20181102/20181102110812_57317.png', 1541128092, 3604, 11654, 'png'),
(251, '97585ff1-5a4e-4d15-a8c3-61a95a1dc9fb', 90, '', 'image/png', '11.png', 'all/20181106/20181106161919_36851.png', 1541492359, 28150, 10000, 'png'),
(252, 'a7e9c7bc-0107-43ee-8998-bbc54ca9c50d', 93, '', 'image/png', '121.png', 'all/20181107/20181107151747_70455.png', 1541575067, 71635, 10000, 'png'),
(253, '705d1b2c-fefe-4132-b165-1699d77872d0', 95, '', 'image/png', 'debugissuedetail.png', 'all/20181109/20181109151511_27939.png', 1541747711, 54536, 11656, 'png'),
(254, 'c7f5ff02-b8c8-4f62-a1b3-9d528e291e5a', 96, '', 'image/png', 'debugissuedetail.png', 'all/20181109/20181109152330_19606.png', 1541748210, 92695, 11656, 'png'),
(255, '137bf286-5d87-4ac9-b879-094b4f1f4b86', 98, '', 'image/png', '491EAA0D-75A0-44B9-80FF-C813F65CEF6D.png', 'all/20181110/20181110195219_85366.png', 1541850739, 214366, 10000, 'png'),
(256, 'b831dcb5-e552-438d-94c5-b3bf95bfca0d', 99, '', 'image/jpeg', 'QQ截图20181111001802.jpg', 'all/20181111/20181111001829_19455.jpg', 1541866709, 11004, 10000, 'jpg'),
(257, '12cf72cd-d8c6-47e6-b6b0-4a4fe68eccd5', 100, '', 'image/jpeg', 'QQ截图20181111020117.jpg', 'all/20181111/20181111020159_31461.jpg', 1541872919, 35289, 10000, 'jpg'),
(259, '30b174b4-f17a-4333-bbb3-ff458517f54b', 102, '', 'image/png', 'jira_detai.png', 'all/20181113/20181113003836_67474.png', 1542040716, 228906, 10000, 'png'),
(260, '084af688-54bc-4b29-aa63-fe4c77347ae5', 103, '', 'image/png', '121.png', 'all/20181114/20181114141714_75647.png', 1542176234, 28243, 10000, 'png'),
(262, '38a5e701-85e3-438f-8bfa-c632f3e53f60', 100, '', 'image/png', 'admin_icon.png', 'all/20181120/20181120174234_83771.png', 1542706954, 6007, 11657, 'png'),
(264, '81ac13f7-7a35-434d-9e91-809f89b09109', 105, '', 'image/jpeg', '1.jpg', 'all/20181120/20181120235915_43840.jpg', 1542729555, 18344, 10000, 'jpg'),
(265, '2d1ac1ac-b5cc-495c-accc-bd4c4f410f5a', 105, '', 'image/jpeg', '2.jpg', 'all/20181120/20181120235919_87725.jpg', 1542729559, 3500, 10000, 'jpg'),
(266, '6d36019d-3c0d-4874-90c9-6b5fc0cd4332', 115, '', 'image/png', 'left_layout_ant.png', 'all/20181127/20181127181322_27993.png', 1543313602, 103775, 10000, 'png'),
(267, '6153bb1e-e1af-4324-a904-fbb87e05337b', 115, '', 'image/png', 'left_layout.png', 'all/20181127/20181127181324_95653.png', 1543313604, 153774, 10000, 'png'),
(268, '3f0a5774-2766-4006-b5d7-63ccf653648d', 118, '', 'image/png', 'ant_list.png', 'all/20181127/20181127182813_18265.png', 1543314493, 63101, 10000, 'png'),
(269, 'aa27ad21-40a9-4c09-aa3d-930b90f1db1a', 118, '', 'image/png', 'gitlab_list.png', 'all/20181127/20181127182814_52583.png', 1543314494, 116192, 10000, 'png'),
(270, 'bc4f36b7-5a88-402d-b2eb-4880c1a18120', 133, '', 'image/jpeg', 'tip.jpg', 'all/20181201/20181201140756_68370.jpg', 1543644476, 66042, 10000, 'jpg'),
(271, '6ebe1b20-c53a-489a-b8c7-689c28afdb17', 129, '', 'image/jpeg', '500.jpg', 'all/20181201/20181201143745_15303.jpg', 1543646265, 23346, 10000, 'jpg'),
(272, '40bc3364-5d70-4043-8d8c-98328a099b79', 129, '', 'image/jpeg', 'logo.jpg', 'all/20181201/20181201143910_47157.jpg', 1543646350, 20161, 10000, 'jpg'),
(273, '1543648972905', 0, '', 'image/png', 'filter_xss.png', 'image/20181201/20181201152353_87673.png', 1543649033, 9601, 11656, 'png'),
(274, 'B7yiYJ-1543940801725', 0, 'B7yiYJ-1543940801725', 'image/png', 'word.png', 'all/20181205/20181205002959_13149.png', 1543940999, 629280, 10000, 'png'),
(275, 'sRZSsa-1544269667317', 0, 'sRZSsa-1544269667317', 'image/png', 'qr.png', 'all/20181208/20181208194923_59776.png', 1544269763, 3483, 0, 'png'),
(276, '6c61d082-dc35-4f95-b83f-63b84ac781b6', 124, '', 'image/png', '20181015102601_18003.png', 'all/20181217/20181217170610_84917.png', 1545037570, 30523, 11657, 'png'),
(277, '5120e54f-fad2-4853-8823-d06862309966', 105, '', 'image/png', '20181015102601_18003.png', 'all/20181218/20181218094943_28218.png', 1545097783, 30523, 11657, 'png'),
(278, '882c1786-4b94-41c5-b3fd-14e578857893', 105, '', 'image/png', '20181015102601_18003.png', 'all/20181218/20181218110430_12959.png', 1545102270, 30523, 11657, 'png'),
(287, 'UNITUUID-vAMKCdmwuXNC2TQ7rn', 0, '', 'image/jpeg', 'UNIT-LUZZBJo7', 'avatar/20181218/20181218181138_18399.jpg', 1545127898, 333, 11714, 'jpg'),
(288, '5b93d366-64d7-4a87-8082-28daa132e990', 217, '', 'image/png', '1.png', 'all/20181218/20181218181147_95386.png', 1545127907, 79982, 1, 'png'),
(291, 'bJMWY3-1545128298392', 134, 'bJMWY3-1545128298392', 'image/jpeg', '0E9046FD-9B8F-47A8-A1B4-F1821E1FFD8E.jpeg', 'all/20181218/20181218181943_67940.jpeg', 1545128383, 79415, 0, 'jpeg'),
(292, 'bJMWY3-1545128298392', 134, 'bJMWY3-1545128298392', 'image/png', '417E3044-F972-456F-BAEF-C5DC49E07846.png', 'all/20181218/20181218182002_72901.png', 1545128402, 160086, 0, 'png'),
(301, 'UNITUUID-t4AZ01qar9BkFPgWke', 0, '', 'image/jpeg', 'UNIT-amN2NIEz', 'avatar/20181218/20181218183603_55666.jpg', 1545129363, 333, 11790, 'jpg'),
(312, 'UNITUUID-0b7qRgN1huK1ujZ6mv', 0, '', 'image/jpeg', 'UNIT-ilgANIT8', 'avatar/20181218/20181218194958_84390.jpg', 1545133798, 333, 11866, 'jpg'),
(323, 'UNITUUID-TbeUfXTcpmGWDBnDlL', 0, '', 'image/jpeg', 'UNIT-ADfHTE6G', 'avatar/20181218/20181218201054_46177.jpg', 1545135054, 333, 11942, 'jpg'),
(326, '97244534-ffae-4996-a0e1-309ec96234cc', 134, '', 'image/png', 'word.png', 'all/20181218/20181218225113_49601.png', 1545144673, 629280, 1, 'png'),
(327, 'fb592736-5ded-4441-8194-e8cb2faa32c4', 133, '', 'image/png', '234242.png', 'all/20181218/20181218225135_98221.png', 1545144695, 92488, 1, 'png'),
(328, 'kkiJ5a-1545144708390', 133, 'kkiJ5a-1545144708390', 'image/jpeg', '21AE898A-0236-4189-8A63-952F6E8008EA.jpeg', 'all/20181218/20181218225307_16362.jpeg', 1545144787, 806627, 0, 'jpeg'),
(337, 'UNITUUID-v2P46SU2Q0Qtd1LscN', 0, '', 'image/jpeg', 'UNIT-3ADpjQl9', 'avatar/20181219/20181219014526_94901.jpg', 1545155126, 333, 12018, 'jpg'),
(348, 'UNITUUID-aO2XzkjUapGPfzts4T', 0, '', 'image/jpeg', 'UNIT-06lkmW9j', 'avatar/20181219/20181219161712_57556.jpg', 1545207432, 333, 12096, 'jpg'),
(359, 'UNITUUID-C2e3XifIdM2KyiJaYi', 0, '', 'image/jpeg', 'UNIT-w0lYkDnA', 'avatar/20181219/20181219165823_99206.jpg', 1545209903, 333, 12172, 'jpg'),
(362, '0622e0a0-756c-456f-8cb8-3bd5589fb514', 0, '', 'image/jpeg', 'photo-1542841791-54bef61e2235.jpg', 'all/20181219/20181219173629_59908.jpg', 1545212189, 223874, 1, 'jpg');

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

--
-- 转存表中的数据 `issue_filter`
--

INSERT INTO `issue_filter` (`id`, `name`, `author`, `description`, `share_obj`, `share_scope`, `projectid`, `filter`, `fav_count`, `name_lower`) VALUES
(5, 'testSaveFilterName_76259', 11707, 'test', NULL, '', NULL, 'project=50&assignee=11707&author_username=19077564988&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(10, 'testSaveFilterName_915626', 11783, 'test', NULL, '', NULL, 'project=135&assignee=11783&author_username=19072024882&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(15, 'testSaveFilterName_973192', 11859, 'test', NULL, '', NULL, 'project=220&assignee=11859&author_username=19015148724&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(20, 'testSaveFilterName_798637', 11935, 'test', NULL, '', NULL, 'project=305&assignee=11935&author_username=19021976938&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(25, 'testSaveFilterName_318160', 12011, 'test', NULL, '', NULL, 'project=390&assignee=12011&author_username=19075305187&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(30, 'testSaveFilterName_440933', 12089, 'test', NULL, '', NULL, 'project=479&assignee=12089&author_username=19046046976&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(35, 'testSaveFilterName_572384', 12165, 'test', NULL, '', NULL, 'project=564&assignee=12165&author_username=19047554246&status=open&priority=high&resolve_resolve=done', NULL, NULL);

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
(28, 18274, 4),
(29, 57, 0),
(32, 205, 30),
(35, 287, 44),
(38, 368, 58),
(41, 449, 72),
(44, 530, 86),
(47, 613, 100),
(50, 694, 114);

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
(2, 134, 11674),
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
(35, 18274, 2),
(36, 41, 3),
(37, 43, 1),
(38, 76, 3),
(39, 97, 3);

-- --------------------------------------------------------

--
-- 表的结构 `issue_main`
--

CREATE TABLE `issue_main` (
  `id` int(11) UNSIGNED NOT NULL,
  `pkey` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_num` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) DEFAULT '0',
  `issue_type` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `creator` int(11) UNSIGNED DEFAULT '0',
  `modifier` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reporter` int(11) DEFAULT '0',
  `assignee` int(11) DEFAULT '0',
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci,
  `environment` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `priority` int(11) DEFAULT '0',
  `resolve` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created` int(11) DEFAULT '0',
  `updated` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `resolve_date` date DEFAULT NULL,
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否拥有子任务'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `issue_main`
--

INSERT INTO `issue_main` (`id`, `pkey`, `issue_num`, `project_id`, `issue_type`, `creator`, `modifier`, `reporter`, `assignee`, `summary`, `description`, `environment`, `priority`, `resolve`, `status`, `created`, `updated`, `start_date`, `due_date`, `resolve_date`, `module`, `milestone`, `sprint`, `weight`, `backlog_weight`, `sprint_weight`, `assistants`, `master_id`, `have_children`) VALUES
(1, 'CRM', 'CRM1', 1, 1, 10000, 10000, 10000, 11652, '数据库设计', '1.第一步数据建模\r\n2.第二步ER图设计', 'windows', 1, 0, 6, 1536768829, 0, '2018-09-13', '2018-09-30', NULL, 3, NULL, 1, 0, 200000, 100000, '', 0, 0),
(2, 'CRM', 'CRM2', 1, 1, 10000, 10000, 10000, 11652, '数据库表设计', '1.\r\n2.\r\n3.', 'windows mysql', 1, 0, 6, 1536769063, 0, '2018-09-13', '2018-09-15', NULL, 1, NULL, 1, 0, 0, 200000, '', 0, 0),
(3, 'CRM', 'CRM3', 1, 1, 10000, 10000, 10000, 10000, '架构设计', '1.\r\n2.\r\n3.\r\n4.\r\n5.', '', 3, 10000, 1, 1536769153, 0, '2018-09-13', '2018-09-15', NULL, 2, NULL, 0, 0, 200000, 100000, '10000', 0, 0),
(4, 'ERP', 'ERP4', 2, 1, 10000, 0, 10000, 10000, '产品设计', '1.\r\n2.\r\n3.\r\n', '', 1, 0, 1, 1536836249, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 100000, 0, '', 0, 0),
(9, 'DEV', 'DEV9', 3, 1, 10000, 10000, 10000, 10000, '事项类型方案的类型重复显示', '', 'web', 3, 0, 6, 1539091562, 0, '2018-10-10', '2018-10-15', NULL, 12, NULL, 2, 0, 1100000, 3200000, '', 0, 0),
(10, 'DEV', 'DEV10', 3, 1, 10000, 11654, 10000, 11654, '事项详情不能显示附件', '', '', 2, 1, 5, 1539091678, 0, '2018-10-10', '2018-10-12', NULL, 11, NULL, 2, 0, 1200000, 3600000, '', 0, 0),
(11, 'DEV', 'DEV11', 3, 1, 10000, 10000, 10000, 10000, '右下角的客服头像重新设计', '该头像涉及侵权风险，需要重新设计，应该设计为与 masterlab logo 相关的形状，比如蝴蝶小仙子\r\n', '', 4, 0, 5, 1539092238, 0, '2018-10-10', '2018-10-12', NULL, 11, NULL, 2, 0, 600000, 3000000, '', 0, 0),
(12, 'DEV', 'DEV12', 3, 4, 10000, 10000, 10000, 11654, '事项类型应该可以编辑', '', '', 3, 0, 5, 1539092358, 0, '2018-10-10', '2018-10-12', NULL, 11, '0', 2, 0, 700000, 100000, '', 0, 0),
(13, 'DEV', 'DEV13', 3, 1, 10000, 11654, 10000, 11654, '新增事项时有时描述无法输入', '![](http://pm.888zb.com/attachment/image/20181009/20181009214057_50420.png)', '', 1, 1, 5, 1539092463, 0, '2018-10-10', '2018-10-12', NULL, 11, NULL, 2, 0, 800000, 4000000, '', 0, 0),
(14, 'DEV', 'DEV14', 3, 1, 10000, 10000, 10000, 10000, '用户资料无法编辑', '![](http://pm.888zb.com/attachment/image/20181009/20181009214837_48090.png)', '', 1, 1, 5, 1539092930, 0, '2018-10-10', '2018-10-12', NULL, 15, NULL, 2, 0, 900000, 3900000, '', 0, 0),
(15, 'DEV', 'DEV15', 3, 1, 10000, 11656, 10000, 11656, '左上角的项目列表跳转错误(组织的path不能显示)', '', '', 1, 1, 5, 1539093321, 0, '2018-10-10', '2018-10-12', NULL, 5, NULL, 2, 0, 1000000, 4100000, '', 0, 0),
(16, 'DEV', 'DEV16', 3, 1, 0, 11654, 0, 11654, '项目摘要的右下角的客服头像点击无响应', '', '', 1, 1, 5, 1539137311, 0, '2018-10-10', '2018-10-12', NULL, 0, NULL, 2, 0, 500000, 4200000, '', 0, 0),
(19, 'DEV', 'DEV19', 3, 1, 10000, 11654, 10000, 11654, '项目摘要页面的右下角客服头像点击无响应', '部分页面也有此问题', '', 3, 1, 5, 1539137684, 0, '2018-10-10', '2018-10-12', NULL, 7, NULL, 2, 0, 200000, 3300000, '', 0, 0),
(20, 'DEV', 'DEV20', 3, 1, 10000, 11654, 10000, 11654, '无迭代时应该显示图文并茂的提示', '', '', 4, 0, 5, 1539140426, 0, '2018-10-10', '2018-10-12', NULL, 6, NULL, 2, 0, 100000, 3100000, '', 0, 0),
(21, 'DEV', 'DEV21', 3, 1, 10000, 11656, 10000, 11656, '项目设置完善左侧信息提示', '', '', 3, 1, 5, 1539140843, 0, '2018-10-10', '2018-10-12', NULL, 8, NULL, 2, 0, 300000, 3400000, '', 0, 0),
(22, 'DEV', 'DEV22', 3, 1, 10000, 11656, 10000, 11656, '项目设置-标签无数据时提示错误', '', '', 3, 1, 5, 1539141321, 0, '2018-10-10', '2018-10-12', NULL, 8, NULL, 2, 0, 400000, 3500000, '', 0, 0),
(23, 'DEV', 'DEV23', 3, 4, 10000, 10000, 10000, 10000, '无数据的插图需要重写设计', '要根据产品的logo和产品特点进行设计，包括：\r\n1.数据为空时：项目列表,迭代,事项，模块，版本，标签\r\n2.询问的弹出层，如删除操作\r\n', '', 3, 0, 5, 1539144107, 0, '2018-10-10', '2018-10-13', NULL, 0, '0', 3, 0, 0, 1300000, '', 0, 0),
(24, 'DEV', 'DEV24', 3, 2, 10000, 10000, 10000, 10000, '增加weight 权重点数字段', '', '', 3, 0, 6, 1539221701, 0, '2018-10-11', '2018-10-13', NULL, 11, NULL, 2, 0, 0, 3700000, '', 0, 0),
(25, 'DEV', 'DEV25', 3, 2, 10000, 10000, 10000, 10000, '看板事项移动时要更新到服务器端', '', '', 3, 0, 6, 1539221773, 0, '2018-10-11', '2018-10-13', NULL, 6, NULL, 2, 0, 0, 2800000, '', 0, 0),
(26, 'DEV', 'DEV26', 3, 1, 10000, 10000, 10000, 10000, '待办事项列表要显示权重点数', '', '', 2, 0, 6, 1539222559, 0, '2018-10-11', '2018-10-13', NULL, 6, NULL, 2, 0, 0, 3800000, '', 0, 0),
(27, 'DEV', 'DEV27', 3, 1, 10000, 11656, 10000, 11656, '系统中的各种设置项的应用(时间 公告 UI)', '', '', 2, 0, 5, 1539222644, 0, '2018-10-11', '2018-10-13', NULL, -1, NULL, 2, 0, 0, 2900000, '1,1,6,5,5', 0, 0),
(28, 'DEV', 'DEV28', 3, 1, 10000, 11657, 10000, 11657, '各个功能模块添加操作日志', '', '', 2, 0, 5, 1539223637, 0, '2018-10-11', '2018-10-13', NULL, 0, NULL, 3, 0, 0, 1200000, '', 0, 0),
(29, 'DEV', 'DEV29', 3, 4, 10000, 11655, 10000, 11655, '快捷键在各个模块的应用', '快捷键规则从Jira中提炼，主要规则如下\r\n## 全局\r\n  快速搜索: /\r\n  创建一个创建表单: c\r\n  快速操作: .\r\n  打开帮助: ?\r\n  提交表单: CTRL + ENTER\r\n  取消表单: ESC\r\n## 事项：\r\n. 在拥有创建表单的界面中, 按键 C 则打开创建表单\r\n. 如果在列表中 按 E 键则进行编辑操作， 按 D 则是删除操作\r\n', '', 3, 0, 5, 1539225437, 0, '2018-10-11', '2018-10-13', NULL, 0, NULL, 2, 0, 0, 200000, '', 0, 0),
(31, 'DEV', 'DEV31', 3, 1, 10000, 10000, 10000, 10000, '事项编辑时，经办人不能正确显示', '', '', 3, 0, 5, 1539332647, 0, '2018-10-12', '2018-10-13', NULL, 11, NULL, 2, 0, 0, 2300000, '', 0, 0),
(32, 'DEV', 'DEV32', 3, 1, 10000, 11654, 10000, 11654, '事项详情的描述为乱码(markdown)', 'fdsafa **fdsafds** [fdsfd](http://baidu.com \"fdsfd\")', '', 2, 1, 5, 1539332732, 0, '2018-10-12', '2018-10-13', NULL, 11, NULL, 2, 0, 0, 2700000, '', 0, 0),
(33, 'DEV', 'DEV33', 3, 1, 10000, 11656, 10000, 11656, '事项详情的', '', '', 3, 10000, 5, 1539421427, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, 2, 0, 0, 2400000, '', 0, 0),
(34, 'DEV', 'DEV34', 3, 1, 10000, 11654, 10000, 11654, '事项的表单要启用模板功能(该功能曾经实现过)', '', '', 3, 1, 5, 1539421663, 0, '2018-10-13', '2018-10-16', NULL, 11, NULL, 2, 0, 0, 2500000, '', 0, 0),
(35, 'DEV', 'DEV35', 3, 2, 10000, 11655, 10000, 11655, '检查浏览器是否支持', '用户访问masterlab，当浏览器不支持时，要浮动出一个层提示用户：更换QQ浏览器里或谷歌火狐浏览器及版本和下载地址', '', 3, 0, 5, 1539424484, 0, '2018-10-13', '2018-10-16', NULL, 0, NULL, 2, 0, 0, 2600000, '', 0, 0),
(37, 'DEV', 'DEV37', 3, 1, 10000, 11654, 10000, 11654, '事项的表单未能按照系统设置的 UI 进行排版', '', '', 2, 1, 5, 1539600400, 0, '2018-10-15', '2018-10-16', NULL, 11, NULL, 2, 0, 0, 2200000, '', 0, 0),
(38, 'DEV', 'DEV38', 3, 1, 10000, 0, 10000, 10000, '工作流编辑异常', '', '', 2, 0, 5, 1539600504, 0, '2018-10-15', '2018-10-16', NULL, 12, NULL, 2, 0, 0, 2100000, '', 0, 0),
(39, 'DEV', 'DEV39', 3, 1, 10000, 10000, 10000, 10000, '点击用户头像时，跳转到的用户资料页不正确', '', '', 2, 0, 5, 1539659107, 0, '2018-10-16', '2018-10-19', NULL, 4, NULL, 2, 0, 0, 2000000, '', 0, 0),
(40, 'DEV', 'DEV40', 3, 1, 10000, 10000, 10000, 10000, '迭代列表的事项需要跳转道详情', '', '', 4, 0, 5, 1539678315, 0, '2018-10-16', '2018-10-23', NULL, 6, NULL, 2, 0, 0, 1900000, '', 0, 0),
(41, 'DEV', 'DEV41', 3, 1, 10000, 11656, 10000, 11656, '事项详情的时间显示异常', '', '', 3, 0, 5, 1540224010, 0, '2018-10-23', '2018-10-23', NULL, 11, NULL, 2, 0, 0, 1500000, '', 0, 0),
(42, 'DEV', 'DEV42', 3, 1, 10000, 10000, 10000, 10000, '事情列表需要排序功能', '', '', 2, 0, 5, 1540224363, 0, '2018-10-23', '2018-10-24', NULL, 11, NULL, 2, 0, 0, 1600000, '', 0, 0),
(43, 'DEV', 'DEV43', 3, 1, 10000, 11654, 10000, 11654, '多次点击事项列表的“创建”按钮时选项卡重复出现', '', '', 1, 0, 5, 1540225471, 0, '2018-10-23', '2018-10-23', NULL, 11, NULL, 2, 0, 0, 1800000, '', 0, 0),
(44, 'DEV', 'DEV44', 3, 1, 10000, 10000, 10000, 10000, '事项详情-可以上传图片', '', '', 2, 0, 5, 1540226138, 0, '2018-10-23', '2018-10-23', NULL, 11, NULL, 2, 0, 0, 1700000, '', 0, 0),
(46, 'DEV', 'DEV46', 3, 1, 10000, 11656, 10000, 11656, '用户资料页实现操作记录功能(参考jira的个人操作记录)', '', '', 3, 0, 5, 1540316851, 0, '2018-10-24', '2018-10-25', NULL, 4, NULL, 2, 0, 0, 1200000, '', 0, 0),
(47, 'DEV', 'DEV47', 3, 1, 10000, 10000, 10000, 10000, '实现编辑时，修改事项类型无效', '', '', 2, 0, 5, 1540316976, 0, '2018-10-24', '2018-10-25', NULL, 11, NULL, 2, 0, 0, 1400000, '', 0, 0),
(48, 'DEV', 'DEV48', 3, 1, 10000, 10000, 10000, 10000, '实现实现列表的批量处理功能', '', '', 3, 0, 5, 1540317394, 0, '2018-10-24', '2018-10-25', NULL, 11, NULL, 2, 0, 0, 1300000, '', 0, 0),
(49, 'DEV', 'DEV49', 3, 1, 10000, 11654, 10000, 11654, '事项表单的标签颜色显示异常', '', '', 3, 0, 5, 1540397352, 0, '2018-10-25', '2018-10-25', NULL, 11, NULL, 2, 0, 0, 900000, '', 0, 0),
(50, 'DEV', 'DEV50', 3, 1, 10000, 11656, 10000, 11656, '项目介绍页的内容不能显示markdown的内容', '具体实现方法请问下松青。', '', 3, 0, 5, 1540397508, 0, '2018-10-25', '2018-10-25', NULL, 7, NULL, 2, 0, 0, 1000000, '11654', 0, 0),
(51, 'DEV', 'DEV51', 3, 1, 10000, 10000, 10000, 10000, '事项编辑时，修改协助人无效', '', '', 3, 0, 5, 1540397910, 0, '2018-10-25', '2018-10-25', NULL, 11, NULL, 2, 0, 0, 1100000, '', 0, 0),
(52, 'DEV', 'DEV52', 3, 1, 10000, 11654, 10000, 11654, '首页项目列表图标显示异常', '', '', 3, 0, 5, 1540438082, 0, '2018-10-25', '2018-10-25', NULL, 5, NULL, 2, 0, 0, 800000, '', 0, 0),
(53, 'DEV', 'DEV53', 3, 4, 10000, 10000, 10000, 11654, '将无数据时的提示修改为图文并茂的方式', '1.将原来的空数据图片用 public/dev/img/empty 下svg替换掉\r\n2.实现 将相关链接加上去，请参考附件\r\n\r\n参考链接：\r\nhttps://gitlab.com/weichaoduo/demo/issues', '', 1, 0, 5, 1540534870, 0, '2018-10-26', '2018-10-26', NULL, 6, NULL, 2, 0, 0, 700000, '', 0, 0),
(54, 'DEV', 'DEV54', 3, 1, 10000, 11654, 10000, 11654, '创建事项的表单 tab 页重复', '重现步骤：\r\n1.打开事项列表\r\n2.点击“创建”按钮\r\n3.更换事项类型：“新功能”\r\n4.更换事项类型：“bug”', '', 2, 0, 5, 1540573865, 0, '2018-10-26', '2018-10-26', NULL, 11, NULL, 2, 0, 0, 600000, '', 0, 0),
(55, 'DEV', 'DEV55', 3, 1, 11655, 10000, 11655, 10000, '导航菜单问题', '左上角菜单，在首页时加粗的项是组织。', '', 3, 0, 5, 1540624468, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 2, 0, 0, 500000, '', 0, 0),
(56, 'DEV', 'DEV56', 3, 1, 10000, 11654, 10000, 11654, '首页当动态数据为空时 使用通用的空图显示', '', '', 4, 0, 5, 1540641158, 0, '2018-10-29', '2018-10-29', NULL, 0, NULL, 3, 0, 100000, 1800000, '', 0, 0),
(57, 'DEV', 'DEV57', 3, 4, 10000, 10000, 10000, 10000, '增加一个未解决的过滤器', '', '', 3, 0, 5, 1540663864, 0, '2018-10-28', '2018-10-28', NULL, 11, NULL, 2, 0, 0, 400000, '1,,,1,,,6,,,5,,,4', 0, 0),
(58, 'DEV', 'DEV58', 3, 1, 10000, 10000, 10000, 10000, '去掉自动登录的账号', '', '', 3, 0, 5, 1540754430, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 200000, 3700000, '', 0, 0),
(59, 'DEV', 'DEV59', 3, 1, 10000, 11654, 10000, 11654, '迭代应该可以选择空', '选择为空时属于代办事项', '', 3, 0, 5, 1540754458, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 400000, 1500000, '', 0, 0),
(60, 'DEV', 'DEV60', 3, 1, 10000, 10000, 10000, 10000, '登录页面的文字需要修饰修改', '', '', 3, 0, 5, 1540754499, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 3800000, '', 0, 0),
(62, 'DEV', 'DEV62', 3, 1, 10000, 10000, 10000, 10000, '增加缓存处理', '', '', 3, 0, 5, 1540754638, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 400000, 3600000, '', 0, 0),
(63, 'DEV', 'DEV63', 3, 4, 10000, 11657, 10000, 11657, '用户动态功能需要优化', '1.首页的用户动态，需要分页\r\n2.对已经有的动态项，进行内容补充，目前内容比较简陋，至于达到什么标准，可参考 jira动态功能\r\n3.某些模块未添加动态，需要进行查漏补缺', '', 3, 1, 5, 1540754710, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 600000, 3900000, '', 0, 0),
(64, 'DEV', 'DEV64', 3, 4, 10000, 10000, 10000, 11656, 'PHP的设计模式优化', '', '', 2, 0, 10100, 1540754764, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 800000, 2300000, '', 0, 0),
(65, 'DEV', 'DEV65', 3, 1, 10000, 11655, 10000, 11655, '更换个人设置页的图片', '详见附件', '', 4, 0, 5, 1540802453, 0, '0000-00-00', '0000-00-00', NULL, 4, NULL, 0, 0, 700000, 2100000, '', 0, 0),
(66, 'DEV', 'DEV66', 3, 1, 10000, 11656, 10000, 11656, '事项详情页面的左上角 项目显示错误', '请看截图的左上角', '', 2, 0, 5, 1540833978, 0, '2018-10-30', '2018-10-30', NULL, 0, NULL, 2, 0, 0, 300000, '', 0, 0),
(67, 'DEV', 'DEV67', 3, 2, 10000, 11654, 10000, 11654, '在迭代和看板页面可以创建事项', '', '', 3, 0, 5, 1540957298, 0, '2018-11-01', '2018-11-05', NULL, 0, NULL, 3, 20, 0, 3200000, '', 0, 0),
(68, 'DEV', 'DEV68', 3, 4, 10000, 11654, 10000, 11654, '在创建事项的表单中,当变更事项类型时，原先填写的数据要保留', '###当前步骤或情况：\r\n  1. 进入事项列表页面\r\n  2. 打开创建事项表单，此时默认事项类型为bug,并输入标题:xxxxx\r\n  3. 变更事项类型为 新功能 \r\n  4. 之前输入的标题变成了空\r\n  \r\n### 优化后的步骤或结果：\r\n  1. 进入事项列表页面\r\n  2. 打开创建事项表单，此时默认事项类型为bug,并输入标题:xxxxx\r\n  3. 变更事项类型为 新功能 \r\n  4. 之前输入的标题内容仍然保留\r\n\r\n', '', 3, 0, 5, 1540958040, 0, '2018-10-31', '2018-11-05', NULL, 11, NULL, 3, 0, 0, 3400000, '', 0, 0),
(69, 'DEV', 'DEV69', 3, 1, 10000, 11654, 10000, 11654, '创建或编辑事项表单的版本和模块下拉时点击错误', '详看截图	', '', 2, 0, 5, 1540958318, 0, '2018-10-31', '2018-10-29', NULL, 11, NULL, 3, 0, 0, 3500000, '', 0, 0),
(70, 'DEV', 'DEV70', 3, 3, 10000, 11657, 10000, 11657, '在wiki上编写使用指南', '参考 \r\nhttps://panjiachen.github.io/vue-element-admin-site/zh/guide/#%E5%8A%9F%E8%83%BD\r\nhttps://doc.fastadmin.net/docs/install.html#%E5%91%BD%E4%BB%A4%E8%A1%8C%E5%AE%89%E8%A3%85-3\r\nhttps://ant.design/index-cn\r\n\r\n内容和结构\r\n\r\n- Masterlab 如何进行高效的项目管理和团队协作\r\n- 项目角色定义\r\n- 工作流和方案\r\n- 事项类型及方案\r\n- 最佳实践，创建组织或产品,创建项目,项目设置，添加事项，创建迭代，跟踪和管理迭代，数据和图表分析，交付产品\r\n- 快捷键\r\n- 其他配置\r\n- 定制或二次开发\r\n- 常见问题\r\n\r\n', '', 3, 1, 5, 1540969482, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3300000, '', 0, 0),
(71, 'DEV', 'DEV71', 3, 3, 10000, 11656, 10000, 11656, '在wiki上编写‘Linux下的Nginx，Mysql5.7，Php7.2，Redis的运行环境的’文档', '三篇，分别基于centos6,centos7,Ubuntu;\r\ncentos的yum参考 webtatic.com\r\n包括redis扩展\r\n\r\n', '', 4, 0, 5, 1540970938, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2900000, '', 0, 0),
(72, 'DEV', 'DEV72', 3, 3, 10000, 11656, 10000, 11656, '创建Masterlab docker及安装文档', '\r\n包含dockerfile和compose，以及上传至 公共的hub上', '', 4, 0, 5, 1540971351, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3000000, '', 0, 0),
(73, 'DEV', 'DEV73', 3, 3, 10000, 10000, 10000, 10000, '更新官方网站的内容', '1.创建一个新的 github 项目\r\n2.修改其中的内容\r\n', '', 4, 0, 5, 1540971562, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3100000, '', 0, 0),
(74, 'DEV', 'DEV74', 3, 2, 10000, 10000, 10000, 10000, '事项列表搜索-增加迭代项', '', '', 3, 0, 5, 1540972012, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2700000, '', 0, 0),
(75, 'DEV', 'DEV75', 3, 4, 10000, 11656, 10000, 11656, '项目类型进行精简', ' 敏捷开发 --> 不变\r\n 看板开发 --> 删除 \r\n 软件开发 --> 不变\r\n 项目管理 --> 删除 \r\n 流程管理 --> 删除 \r\n 任务管理 --> 不变', '', 3, 1, 5, 1540972695, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2800000, '', 0, 0),
(76, 'DEV', 'DEV76', 3, 2, 10000, 10000, 10000, 10000, '迭代和待办事项页面要显示事项的状态，解决结果，经办人', '静态结构已经增加，返回数据中暂缺少对应项。', '', 3, 0, 5, 1540973678, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2400000, '', 0, 0),
(77, 'DEV', 'DEV77', 3, 2, 10000, 11655, 10000, 11655, '看板页面需要增加可编辑和新增事项的功能', '', '', 3, 0, 5, 1540973714, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2500000, '', 0, 0),
(78, 'DEV', 'DEV78', 3, 2, 10000, 10000, 10000, 10000, '项目统计页面需要增加专门针对当前迭代的统计', '', '', 3, 0, 5, 1540973749, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2600000, '', 0, 0),
(79, 'DEV', 'DEV79', 3, 1, 10000, 11655, 10000, 11655, '迭代页面，需要高亮显示当前迭代', '', '', 4, 0, 5, 1540973900, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2300000, '', 0, 0),
(80, 'DEV', 'DEV80', 3, 1, 10000, 10000, 10000, 10000, '项目图表的‘ 解决与未解决事项对比报告’为空', '', '', 3, 0, 5, 1540973995, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2100000, '', 0, 0),
(81, 'DEV', 'DEV81', 3, 4, 10000, 10000, 10000, 10000, '官方网站的图片需要重写设计', '', '', 3, 0, 5, 1540974064, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2200000, '', 0, 0),
(82, 'DEV', 'DEV82', 3, 1, 10000, 11654, 10000, 11654, '迭代列表的事项可以点击，然后右侧浮动出事项详情', '', '', 3, 0, 5, 1540974142, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 1900000, '', 0, 0),
(83, 'DEV', 'DEV83', 3, 2, 10000, 10000, 10000, 10000, '实现事项查询的自定义过滤器', '', '', 3, 0, 5, 1540974180, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2000000, '', 0, 0),
(84, 'DEV', 'DEV84', 3, 4, 10000, 10000, 10000, 10000, '事项列表和待办事项及迭代页面增加总数', '', '', 3, 0, 5, 1540976592, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1700000, '', 0, 0),
(85, 'DEV', 'DEV85', 3, 2, 10000, 10000, 10000, 10000, '启用Mysql5.7以上版本的全文索引', '支持以下查询\r\n```sql\r\n... WHERE MATCH (`summary`,`description`) AGAINST (\'异常 设计\' IN NATURAL LANGUAGE MODE)\r\n```', '', 3, 0, 5, 1541000974, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1500000, '', 0, 0),
(86, 'DEV', 'DEV86', 3, 4, 10000, 10000, 10000, 10000, '优化事项类型的表单配置', '', '', 4, 0, 5, 1541001338, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1400000, '', 0, 0),
(87, 'DEV', 'DEV87', 3, 1, 10000, 10000, 10000, 10000, '点击事项列表的用户头像后跳转的个人资料页错误', '', '', 2, 0, 5, 1541004095, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1600000, '', 0, 0),
(88, 'DEV', 'DEV88', 3, 1, 10000, 10000, 10000, 10000, '看板查询功能失效', '', '', 2, 0, 5, 1541350759, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1100000, '', 0, 0),
(89, 'DEV', 'DEV89', 3, 1, 11658, 10000, 11658, 10000, '注册新用户无法登录', '步骤：\r\n1、注册页面注册新用户成功\r\n2、登录提示用户已被禁用\r\n3、使用系统管理员账号登录系统-用户管理，用户列表中该用户的状态为空（正常情况为正常），点击编辑，弹出框中，禁用为未选中状态，此时点击禁用，该用户状态为禁用，需要再次编辑该用户，取消禁用，该用户状态为正常，可以登录\r\n问题：\r\n需要设置两次状态以后用户才能登录，正常情况下应该只需要设置一次即可', '', 3, 0, 5, 1541490486, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1000000, '', 0, 0),
(90, 'DEV', 'DEV90', 3, 4, 10000, 11655, 10000, 11655, '当鼠标移动到事项列表上面时，高亮显示表格的行', '', '', 4, 0, 5, 1541492362, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, 3, 0, 0, 700000, '', 0, 0),
(92, 'DEV', 'DEV92', 3, 4, 10000, 11654, 10000, 11654, '事项表单的 迭代 字段默认值要修改', '如果当前项目有活跃的迭代，则默认选中该迭代\r\n如果项目没有迭代，则选中待办事项\r\n后端会在页面中放置一个全局的js变量 _active_sprint_id', '', 4, 0, 5, 1541574516, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 900000, '', 0, 0),
(93, 'DEV', 'DEV93', 3, 4, 10000, 11655, 10000, 11655, '美观官方网站的关于我们', '详看附件\r\n要左对齐\r\n左边放置 头像，右边是介绍', '', 4, 0, 5, 1541575069, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 800000, '', 0, 0),
(94, 'DEV', 'DEV94', 3, 1, 10000, 10000, 10000, 10000, '登录页面增加快捷键', '', '', 4, 0, 5, 1541728375, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 600000, '', 0, 0),
(95, 'DEV', 'DEV95', 3, 1, 11656, 11656, 11656, 11656, '编辑事项的修改时间显示错误', '编辑事项的修改时间显示错误\r\n原因是：在更新事项表单的时候没有把更新时间写入事项表的更新字段', '', 1, 0, 5, 1541747728, 0, '2018-11-09', '2018-11-10', NULL, 11, NULL, 0, 0, 300000, 0, '', 0, 0),
(96, 'DEV', 'DEV96', 3, 1, 11656, 11656, 11656, 11654, '事项详情页面点击事项编辑按钮后附件框会多出来一部分', '重现：\r\n1、在事项详情页面点击事项编辑按钮\r\n2、关闭编辑页面', '', 4, 0, 1, 1541748239, 0, '2018-11-12', '2018-11-16', NULL, 11, NULL, 0, 0, 600000, 100000, '', 0, 0),
(97, 'DEV', 'DEV97', 3, 1, 10000, 10000, 10000, 10000, '创建一个smtp帐号并测试邮件发送功能', '', '', 3, 10000, 6, 1541850637, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 2100000, '', 0, 0),
(98, 'DEV', 'DEV98', 3, 1, 10000, 10000, 10000, 10000, '标签数据错误', '', '', 3, 10000, 6, 1541850743, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 2200000, '', 0, 0),
(99, 'DEV', 'DEV99', 3, 1, 10000, 11656, 10000, 11656, 'DbModel不应该添加特定的updated字段', '应该在 事项 的控制器或classes中添加\r\n.', '', 2, 0, 5, 1541866713, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 500000, 500000, '', 0, 0),
(100, 'DEV', 'DEV100', 3, 1, 10000, 11657, 10000, 11657, '动态内容缺失', '详看附件', '', 3, 3, 3, 1541872925, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 500000, '', 0, 0),
(101, 'DEV', 'DEV101', 3, 1, 10000, 10000, 10000, 10000, '安装文档还要添加 Redis Sphinx 和 定时任务说明', '', '', 3, 0, 5, 1541957329, 1541957329, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 400000, '', 0, 0),
(102, 'DEV', 'DEV102', 3, 4, 10000, 10000, 10000, 10000, '详情页面参考jira7.12', '详看附件', '', 4, 10000, 6, 1542040723, 1542040723, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 0, 1900000, '', 0, 0),
(103, 'DEV', 'DEV103', 3, 1, 10000, 10000, 10000, 10000, '迭代的数据统计错误', '', '', 2, 0, 5, 1542176236, 1542176236, '0000-00-00', '0000-00-00', NULL, 6, NULL, 3, 0, 0, 300000, '', 0, 0),
(104, 'DEV', 'DEV104', 3, 1, 10000, 11654, 10000, 11654, '上传附件删除时需要汉化', '', '', 3, 1, 1, 1542558617, 1542558617, '0000-00-00', '0000-00-00', NULL, 11, NULL, 3, 0, 0, 200000, '', 0, 0),
(105, 'DEV', 'DEV105', 3, 1, 10000, 11656, 10000, 11656, '用户头像上传后的大小和设置时的大小不一致', '', '', 2, 0, 5, 1542729562, 1542729562, '0000-00-00', '0000-00-00', NULL, 4, NULL, 3, 0, 0, 100000, '', 0, 0),
(106, 'DEV', 'DEV106', 3, 4, 10000, 10000, 10000, 10000, '在创建和编辑事项时可以通过二维码在手机上传附件', '', '', 3, 0, 3, 1542765651, 1542765651, '0000-00-00', '0000-00-00', NULL, 11, NULL, 4, 0, 0, 400000, '', 0, 0),
(108, 'DEV', 'DEV108', 3, 2, 10000, 10000, 10000, 11657, '自定义首页面板', '', '', 3, 0, 1, 1542766745, 1542766745, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 60, 200000, 800000, '', 0, 0),
(111, 'DEV', 'DEV111', 3, 1, 10000, 10000, 10000, 10000, '实现自动安装的功能', '', '', 3, 0, 3, 1543309637, 1543309637, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 30, 0, 1500000, '', 0, 0),
(112, 'DEV', 'DEV112', 3, 2, 10000, 10000, 10000, 11656, '增加docker安装方式', '要充分进行测试\r\n支持以下操作系统\r\nwin10\r\nmac\r\nlinux\r\n', '', 3, 0, 3, 1543309913, 1543309913, '2018-11-27', '2018-12-05', NULL, 0, NULL, 4, 20, 0, 1600000, '', 0, 0),
(113, 'DEV', 'DEV113', 3, 1, 10000, 10000, 10000, 10000, '创建事项时默认的状态应该为 打开 ', '', '', 3, 0, 3, 1543310077, 1543310077, '2018-11-27', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 2000000, '', 0, 0),
(114, 'DEV', 'DEV114', 3, 1, 10000, 0, 10000, 11657, '优化文档', '1.文档用词要更专业化更容易理解\r\n2.截图过多，要适当的删减\r\n3.要重点说明：迭代(排序规则，可以拖拽等)；看板的事项可拖拽；解释事项的权重；自定义工作流；自定义事项的表单；事项类型和项目的关系\r\n', '', 3, 10000, 6, 1543310616, 1543310616, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 1900000, '', 0, 0),
(115, 'DEV', 'DEV115', 3, 2, 10000, 10000, 10000, 11654, '增加左侧菜单的布局', '参考一下成熟方案\r\n\r\nhttps://preview.pro.ant.design/dashboard/analysis\r\n\r\n\r\n', '', 2, 0, 3, 1543313567, 1543313567, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 30, 0, 1800000, '', 0, 0),
(116, 'DEV', 'DEV116', 3, 4, 10000, 10000, 10000, 11656, '事项列表的表格行中双击可以直接修改状态和解决结果、经办人', '', '', 3, 0, 3, 1543313945, 1543313945, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 20, 0, 1700000, '', 0, 0),
(118, 'DEV', 'DEV118', 3, 1, 10000, 10000, 10000, 11654, '事项列表-增加类似gitlab的展示方式(去除table tr td)', '参考\r\n\r\nhttps://gitlab.com/gitlab-org/gitlab-runner/issues\r\n\r\nhttps://preview.pro.ant.design/list/basic-list', '', 3, 0, 3, 1543314501, 1543314501, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 700000, '', 0, 0),
(119, 'DEV', 'DEV119', 3, 4, 10000, 10000, 10000, 11656, '增强安全性防止 XSS 和 CSRF 攻击', '', '', 2, 0, 4, 1543314945, 1543314945, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 30, 0, 1200000, '', 0, 0),
(120, 'DEV', 'DEV120', 3, 1, 10000, 10000, 10000, 10000, '创建事项时默认的状态错误', '默认状态应该是 打开', '', 2, 0, 4, 1543314989, 1543314989, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 1300000, '', 0, 0),
(121, 'DEV', 'DEV121', 3, 4, 10000, 10000, 10000, 11655, '当用户初次体验系统是在一些高级的功能UI上添加提示功能', '使用 Hopscotch\r\nhttp://www.jq22.com/yanshi215\r\n\r\n###提示的UI有：\r\n- 事项列表的快捷键\r\n- 事项列表的搜索功能\r\n- 迭代可以拖拽\r\n- 看板可以拖拽\r\n- 迭代统计\r\n- 迭代图表\r\n\r\n', '', 3, 10000, 6, 1543315331, 1543315331, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 1000000, '', 0, 0),
(123, 'DEV', 'DEV123', 3, 2, 10000, 10000, 10000, 10000, '添加 hotjar 用于收集用户使用masterlab的使用情况', 'hotjar ', '', 3, 0, 4, 1543315590, 1543315590, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 1100000, '', 0, 0),
(124, 'DEV', 'DEV124', 3, 1, 10000, 10000, 10000, 11657, '自定义首页面板', '注：首页已经实现了 拖拽 app/view/gitlab/dashboard_sortable.php\r\n\r\nhttps://github.com/arboshiki/lobipanel\r\n\r\n请参考 \r\njira7 版本的自定义面板功能\r\nhttp://www.jq22.com/yanshi10850\r\nhttp://www.jq22.com/yanshi5531\r\nhttps://github.com/williammustaffa/jquery.dad.js', '', 1, 10000, 6, 1543315755, 1543315755, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 60, 0, 1400000, '', 0, 0),
(125, 'DEV', 'DEV125', 3, 4, 10000, 10000, 10000, 10000, '完善二次开发指南', '', '', 3, 0, 4, 1543316506, 1543316506, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 900000, '', 0, 0),
(127, 'DEV', 'DEV127', 3, 1, 10000, 0, 10000, 11654, '迭代页面无法编辑事项', '', '', 2, 0, 4, 1543370239, 1543370239, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 600000, '', 0, 0),
(128, 'DEV', 'DEV128', 3, 1, 10000, 0, 10000, 10000, '图表统计颜色错误', '', '', 3, 0, 1, 1543372068, 1543372068, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 500000, '', 0, 0),
(129, 'DEV', 'DEV129', 3, 4, 10000, 10000, 10000, 11655, '统一更换logo', '更换为这个\r\ngitlab/images/logo.png ', '', 3, 0, 1, 1543598948, 1543598948, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 100000, '', 0, 0),
(131, 'DEV', 'DEV131', 3, 1, 10000, 0, 10000, 11654, '事项列表的右侧的详情浮动中，无事项标题', '', '', 2, 0, 4, 1543599218, 1543599218, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 200000, '', 0, 0),
(132, 'DEV', 'DEV132', 3, 1, 10000, 0, 10000, 10000, '注册时发送邮件地址有误', '', '', 2, 0, 4, 1543642156, 1543642156, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 300000, '', 0, 0),
(133, 'DEV', 'DEV133', 3, 1, 10000, 1, 10000, 11655, '使用非chrome Firefox浏览器时没有提示兼容性', '同时提示用户去下载 谷歌和QQ浏览器 ', '', 3, 0, 4, 1543644426, 1543644426, '2018-12-01', '2018-12-04', NULL, 0, NULL, 0, 0, 100000, 200000, '', 0, 0),
(134, 'DEV', 'DEV134', 3, 1, 10000, 10000, 10000, 10000, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '', '', 2, 0, 5, 1543644588, 1543644588, '2018-12-13', '2018-12-22', NULL, 0, NULL, 0, 0, 200000, 500000, '', 0, 0),
(164, NULL, NULL, 31, 1, 11689, 11689, 11689, 11689, 'testFilterSummary0Rand58730182', 'test-description', 'test-environment', 3, 10000, 1, 1545127356, 1545127356, '2018-12-18', '2018-12-25', '2018-12-25', 23, NULL, 20, 0, 0, 0, '', 0, 0),
(165, NULL, NULL, 31, 1, 11689, 11689, 11689, 11689, 'testFilterSummary1Rand45067039', 'test-description', 'test-environment', 3, 10000, 1, 1545127356, 1545127356, '2018-12-18', '2018-12-25', '2018-12-25', 23, NULL, 20, 0, 0, 0, '', 0, 0),
(166, NULL, NULL, 31, 1, 11689, 11689, 11689, 11689, 'testFilterSummary2Rand45357426', 'test-description', 'test-environment', 3, 10000, 1, 1545127357, 1545127356, '2018-12-18', '2018-12-25', '2018-12-25', 23, NULL, 20, 0, 0, 0, '', 0, 0),
(167, NULL, NULL, 31, 1, 11689, 11689, 11689, 11689, 'testFilterSummary3Rand45263330', 'test-description', 'test-environment', 3, 10000, 1, 1545127357, 1545127356, '2018-12-18', '2018-12-25', '2018-12-25', 23, NULL, 20, 0, 0, 0, '', 0, 0),
(246, NULL, NULL, 116, 1, 11765, 11765, 11765, 11765, 'testFilterSummary0Rand55349261', 'test-description', 'test-environment', 3, 10000, 1, 1545128803, 1545128803, '2018-12-18', '2018-12-25', '2018-12-25', 39, NULL, 42, 0, 0, 0, '', 0, 0),
(247, NULL, NULL, 116, 1, 11765, 11765, 11765, 11765, 'testFilterSummary1Rand47459354', 'test-description', 'test-environment', 3, 10000, 1, 1545128803, 1545128803, '2018-12-18', '2018-12-25', '2018-12-25', 39, NULL, 42, 0, 0, 0, '', 0, 0),
(248, NULL, NULL, 116, 1, 11765, 11765, 11765, 11765, 'testFilterSummary2Rand84679595', 'test-description', 'test-environment', 3, 10000, 1, 1545128804, 1545128803, '2018-12-18', '2018-12-25', '2018-12-25', 39, NULL, 42, 0, 0, 0, '', 0, 0),
(249, NULL, NULL, 116, 1, 11765, 11765, 11765, 11765, 'testFilterSummary3Rand48622734', 'test-description', 'test-environment', 3, 10000, 1, 1545128804, 1545128803, '2018-12-18', '2018-12-25', '2018-12-25', 39, NULL, 42, 0, 0, 0, '', 0, 0),
(327, NULL, NULL, 201, 1, 11841, 11841, 11841, 11841, 'testFilterSummary0Rand27230136', 'test-description', 'test-environment', 3, 10000, 1, 1545133207, 1545133207, '2018-12-18', '2018-12-25', '2018-12-25', 55, NULL, 64, 0, 0, 0, '', 0, 0),
(328, NULL, NULL, 201, 1, 11841, 11841, 11841, 11841, 'testFilterSummary1Rand17224726', 'test-description', 'test-environment', 3, 10000, 1, 1545133207, 1545133207, '2018-12-18', '2018-12-25', '2018-12-25', 55, NULL, 64, 0, 0, 0, '', 0, 0),
(329, NULL, NULL, 201, 1, 11841, 11841, 11841, 11841, 'testFilterSummary2Rand68729526', 'test-description', 'test-environment', 3, 10000, 1, 1545133207, 1545133207, '2018-12-18', '2018-12-25', '2018-12-25', 55, NULL, 64, 0, 0, 0, '', 0, 0),
(330, NULL, NULL, 201, 1, 11841, 11841, 11841, 11841, 'testFilterSummary3Rand38764155', 'test-description', 'test-environment', 3, 10000, 1, 1545133208, 1545133207, '2018-12-18', '2018-12-25', '2018-12-25', 55, NULL, 64, 0, 0, 0, '', 0, 0),
(408, NULL, NULL, 286, 1, 11917, 11917, 11917, 11917, 'testFilterSummary0Rand71824898', 'test-description', 'test-environment', 3, 10000, 1, 1545134449, 1545134449, '2018-12-18', '2018-12-25', '2018-12-25', 71, NULL, 86, 0, 0, 0, '', 0, 0),
(409, NULL, NULL, 286, 1, 11917, 11917, 11917, 11917, 'testFilterSummary1Rand29454764', 'test-description', 'test-environment', 3, 10000, 1, 1545134450, 1545134449, '2018-12-18', '2018-12-25', '2018-12-25', 71, NULL, 86, 0, 0, 0, '', 0, 0),
(410, NULL, NULL, 286, 1, 11917, 11917, 11917, 11917, 'testFilterSummary2Rand53761322', 'test-description', 'test-environment', 3, 10000, 1, 1545134450, 1545134449, '2018-12-18', '2018-12-25', '2018-12-25', 71, NULL, 86, 0, 0, 0, '', 0, 0),
(411, NULL, NULL, 286, 1, 11917, 1, 11917, 11917, 'testFilterSummary3Rand13463933', 'test-description', 'test-environment', 3, 10000, 5, 1545134450, 1545134449, '2018-12-18', '2018-12-25', '2018-12-25', 71, NULL, 86, 0, 0, 0, '', 0, 0),
(489, NULL, NULL, 371, 1, 11993, 11993, 11993, 11993, 'testFilterSummary0Rand89809323', 'test-description', 'test-environment', 3, 10000, 1, 1545154498, 1545154498, '2018-12-19', '2018-12-26', '2018-12-26', 87, NULL, 108, 0, 0, 0, '', 0, 0),
(490, NULL, NULL, 371, 1, 11993, 11993, 11993, 11993, 'testFilterSummary1Rand46387397', 'test-description', 'test-environment', 3, 10000, 1, 1545154498, 1545154498, '2018-12-19', '2018-12-26', '2018-12-26', 87, NULL, 108, 0, 0, 0, '', 0, 0),
(491, NULL, NULL, 371, 1, 11993, 11993, 11993, 11993, 'testFilterSummary2Rand64552574', 'test-description', 'test-environment', 3, 10000, 1, 1545154499, 1545154498, '2018-12-19', '2018-12-26', '2018-12-26', 87, NULL, 108, 0, 0, 0, '', 0, 0),
(492, NULL, NULL, 371, 1, 11993, 11993, 11993, 11993, 'testFilterSummary3Rand59788747', 'test-description', 'test-environment', 3, 10000, 1, 1545154499, 1545154498, '2018-12-19', '2018-12-26', '2018-12-26', 87, NULL, 108, 0, 0, 0, '', 0, 0),
(542, 'RECORD', 'RECORD542', 431, 1, 1, 0, 1, 1, '录入', '\r\n描述内容...\r\n\r\n## 重新步骤\r\n1. 步骤1\r\n\r\n2. 步骤2\r\n\r\n3. 步骤3\r\n\r\n## 期望结果 \r\n\r\n\r\n## 实际结果\r\n\r\n', '', 1, 0, 1, 1545188223, 1545188223, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 100000, 0, '', 0, 0),
(543, 'CRM', 'CRM543', 1, 1, 1, 1, 1, 1, 'aa', '描述内容...\r\n\r\n## 重新步骤\r\n1. 步骤1\r\n\r\n2. 步骤2\r\n\r\n3. 步骤3\r\n\r\n## 期望结果 \r\n\r\n\r\n## 实际结果\r\n\r\n', '', 1, 0, 1, 1545204203, 1545204203, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 100000, 0, '1,1,6,5,2', 0, 0),
(572, NULL, NULL, 460, 1, 12071, 12071, 12071, 12071, 'testFilterSummary0Rand27765034', 'test-description', 'test-environment', 3, 10000, 1, 1545206680, 1545206680, '2018-12-19', '2018-12-26', '2018-12-26', 103, NULL, 131, 0, 0, 0, '', 0, 0),
(573, NULL, NULL, 460, 1, 12071, 12071, 12071, 12071, 'testFilterSummary1Rand44725203', 'test-description', 'test-environment', 3, 10000, 1, 1545206681, 1545206680, '2018-12-19', '2018-12-26', '2018-12-26', 103, NULL, 131, 0, 0, 0, '', 0, 0),
(574, NULL, NULL, 460, 1, 12071, 12071, 12071, 12071, 'testFilterSummary2Rand49966498', 'test-description', 'test-environment', 3, 10000, 1, 1545206681, 1545206680, '2018-12-19', '2018-12-26', '2018-12-26', 103, NULL, 131, 0, 0, 0, '', 0, 0),
(575, NULL, NULL, 460, 1, 12071, 12071, 12071, 12071, 'testFilterSummary3Rand53957102', 'test-description', 'test-environment', 3, 10000, 1, 1545206681, 1545206680, '2018-12-19', '2018-12-26', '2018-12-26', 103, NULL, 131, 0, 0, 0, '', 0, 0),
(653, NULL, NULL, 545, 1, 12147, 12147, 12147, 12147, 'testFilterSummary0Rand89852705', 'test-description', 'test-environment', 3, 10000, 1, 1545209125, 1545209125, '2018-12-19', '2018-12-26', '2018-12-26', 119, NULL, 153, 0, 0, 0, '', 0, 0),
(654, NULL, NULL, 545, 1, 12147, 12147, 12147, 12147, 'testFilterSummary1Rand79010912', 'test-description', 'test-environment', 3, 10000, 1, 1545209125, 1545209125, '2018-12-19', '2018-12-26', '2018-12-26', 119, NULL, 153, 0, 0, 0, '', 0, 0),
(655, NULL, NULL, 545, 1, 12147, 12147, 12147, 12147, 'testFilterSummary2Rand76535781', 'test-description', 'test-environment', 3, 10000, 1, 1545209126, 1545209125, '2018-12-19', '2018-12-26', '2018-12-26', 119, NULL, 153, 0, 0, 0, '', 0, 0),
(656, NULL, NULL, 545, 1, 12147, 12147, 12147, 12147, 'testFilterSummary3Rand78635945', 'test-description', 'test-environment', 3, 10000, 1, 1545209126, 1545209125, '2018-12-19', '2018-12-26', '2018-12-26', 119, NULL, 153, 0, 0, 0, '', 0, 0);

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
(1, 1, '紧 急', 'very_import', '阻塞开发或测试的工作进度，或影响系统无法运行的错误', '/images/icons/priorities/blocker.png', 'red', NULL, 0),
(2, 2, '重 要', 'import', '系统崩溃，丢失数据或内存溢出等严重错误、或者必需完成的任务', '/images/icons/priorities/critical.png', '#cc0000', NULL, 0),
(3, 3, '高', 'high', '主要的功能无效或流程异常', '/images/icons/priorities/major.png', '#ff0000', NULL, 0),
(4, 4, '中', 'normal', '功能部分无效或对现有系统的改进', '/images/icons/priorities/minor.png', '#006600', NULL, 0),
(5, 5, '低', 'low', '不影响功能和流程的问题', '/images/icons/priorities/trivial.png', '#003300', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_recycle`
--

CREATE TABLE `issue_recycle` (
  `id` int(11) UNSIGNED NOT NULL,
  `delete_user_id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
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
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `data` text,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_recycle`
--

INSERT INTO `issue_recycle` (`id`, `delete_user_id`, `issue_id`, `pkey`, `issue_num`, `project_id`, `issue_type`, `creator`, `modifier`, `reporter`, `assignee`, `summary`, `description`, `environment`, `priority`, `resolve`, `status`, `created`, `updated`, `start_date`, `due_date`, `resolve_date`, `workflow_id`, `module`, `milestone`, `sprint`, `assistants`, `master_id`, `data`, `time`) VALUES
(1, 10000, 5, NULL, NULL, 1, 0, 0, 0, 0, 0, 'cfm测试', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"CRM\",\"issue_num\":\"CRM5\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"cfm\\u6d4b\\u8bd5\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1538018318\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1538018511),
(2, 10000, 6, NULL, NULL, 1, 0, 0, 0, 0, 0, 'cfm测试', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"CRM\",\"issue_num\":\"CRM6\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"cfm\\u6d4b\\u8bd5\",\"description\":\"\",\"environment\":\"123\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1538097518\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1538097646),
(3, 10000, 7, NULL, NULL, 1, 0, 0, 0, 0, 0, 'cfm测试', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"CRM\",\"issue_num\":\"CRM7\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"cfm\\u6d4b\\u8bd5\",\"description\":\"\",\"environment\":\"\",\"priority\":\"4\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1538097779\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1538101123),
(4, 10000, 8, NULL, NULL, 1, 0, 0, 0, 0, 0, 'cfm测试123', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"CRM\",\"issue_num\":\"CRM8\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"0\",\"summary\":\"cfm\\u6d4b\\u8bd5123\",\"description\":\"123131312313123212312312\",\"environment\":\"\",\"priority\":\"5\",\"resolve\":\"0\",\"status\":\"6\",\"created\":\"1538103625\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1538106562),
(5, 10000, 18, NULL, NULL, 3, 0, 0, 0, 0, 0, '项目摘要页面的右下角客服头像点击无效', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV18\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"\\u9879\\u76ee\\u6458\\u8981\\u9875\\u9762\\u7684\\u53f3\\u4e0b\\u89d2\\u5ba2\\u670d\\u5934\\u50cf\\u70b9\\u51fb\\u65e0\\u6548\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1539137381\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"7\",\"milestone\":null,\"sprint\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1539140311),
(6, 10000, 17, NULL, NULL, 3, 0, 0, 0, 0, 0, '项目摘要页面的右下角客服头像点击无效', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV17\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"\\u9879\\u76ee\\u6458\\u8981\\u9875\\u9762\\u7684\\u53f3\\u4e0b\\u89d2\\u5ba2\\u670d\\u5934\\u50cf\\u70b9\\u51fb\\u65e0\\u6548\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1539137375\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"7\",\"milestone\":null,\"sprint\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1539140316),
(7, 11656, 36, NULL, NULL, 4, 0, 0, 0, 0, 0, '768768768', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"JUGGSELF\",\"issue_num\":\"JUGGSELF36\",\"project_id\":\"4\",\"issue_type\":\"1\",\"creator\":\"11656\",\"modifier\":\"0\",\"reporter\":\"11656\",\"assignee\":\"0\",\"summary\":\"768768768\",\"description\":\"gfdsgfdsg\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1539571742\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11656\"}', 1539573174),
(8, 10000, 61, NULL, NULL, 3, 0, 0, 0, 0, 0, '增加websocket同步修改的配置数据', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV61\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u589e\\u52a0websocket\\u540c\\u6b65\\u4fee\\u6539\\u7684\\u914d\\u7f6e\\u6570\\u636e\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1540754614\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"3\",\"weight\":\"0\",\"backlog_weight\":\"300000\",\"sprint_weight\":\"2400000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1540983658),
(9, 10000, 45, NULL, NULL, 3, 0, 0, 0, 0, 0, '客服头像的帮助内容需要更新', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV45\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5ba2\\u670d\\u5934\\u50cf\\u7684\\u5e2e\\u52a9\\u5185\\u5bb9\\u9700\\u8981\\u66f4\\u65b0\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1540226308\",\"updated\":\"0\",\"start_date\":\"2018-10-23\",\"due_date\":\"2018-10-23\",\"resolve_date\":null,\"module\":\"5\",\"milestone\":null,\"sprint\":\"3\",\"weight\":\"0\",\"backlog_weight\":\"100000\",\"sprint_weight\":\"2800000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1540983805),
(10, 10000, 30, NULL, NULL, 3, 0, 0, 0, 0, 0, '使用帮助和在线提示', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV30\",\"project_id\":\"3\",\"issue_type\":\"3\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u4f7f\\u7528\\u5e2e\\u52a9\\u548c\\u5728\\u7ebf\\u63d0\\u793a\",\"description\":\"\\u5206\\u4e24\\u4e2a\\u90e8\\u5206\\r\\n\\r\\n## \\u4e00\\u4e2a\\u662f\\u8f83\\u4e3a\\u5b8c\\u6574\\u7684\\u7528\\u6237\\u624b\\u518c\\uff0c\\u5305\\u542b\\uff1a\\r\\n 1. \\u5b89\\u88c5\\u8bf4\\u660e\\u548c\\u6b65\\u9aa4\\r\\n 2. \\u521d\\u59cb\\u914d\\u7f6e\\r\\n 3. Masterlab\\u7279\\u70b9\\u548c\\u4f7f\\u7528\\u5efa\\u8bae\\r\\n 4. \\u5404\\u4e2a\\u529f\\u80fd\\u4f7f\\u7528\\u8bf4\\u660e\\r\\n\\r\\n## \\u5728\\u7ebf\\u8bf4\\u660e\\r\\n  1.\\u9875\\u9762\\u7684\\u53f3\\u4e0b\\u89d2\\u6709\\u4e2a\\u5ba2\\u670d\\u5934\\u50cf\\uff0c\\u70b9\\u51fb\\u540e\\u53ef\\u4ee5\\u51fa\\u73b0\\u4e00\\u4e9b\\u5e38\\u89c1\\u7684\\u5e2e\\u52a9\\u548c\\u8bf4\\u660e\\uff0c\\u5229\\u4e8e\\u7528\\u6237\\u4f7f\\u7528masterlab\\r\\n  2.\\u5305\\u542b\\uff1a\\u5e38\\u89c1\\u95ee\\u9898, \\u529f\\u80fd\\u4ecb\\u7ecd,\\u7ba1\\u7406\\u5458\\u4f7f\\u7528\\u5e2e\\u52a9,\\u5feb\\u6377\\u952e\\u4ee5\\u53ca \\u5173\\u4e8e Masterlab ,\\u5173\\u4e8e\\u7814\\u53d1\\u56e2\\u961f\\uff0c\\u8054\\u7cfb\\u6211\\u4eec\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"1\",\"status\":\"1\",\"created\":\"1539226794\",\"updated\":\"0\",\"start_date\":\"2018-10-11\",\"due_date\":\"2018-10-13\",\"resolve_date\":null,\"module\":\"-1\",\"milestone\":\"0\",\"sprint\":\"3\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"2900000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1540983852),
(11, 10000, 91, NULL, NULL, 3, 0, 0, 0, 0, 0, '看板的事项不能编辑，点击无效', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV91\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"11654\",\"summary\":\"\\u770b\\u677f\\u7684\\u4e8b\\u9879\\u4e0d\\u80fd\\u7f16\\u8f91\\uff0c\\u70b9\\u51fb\\u65e0\\u6548\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1541573244\",\"updated\":\"0\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"6\",\"milestone\":null,\"sprint\":\"3\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1541577141),
(12, 10000, 109, NULL, NULL, 3, 0, 0, 0, 0, 0, '主菜单增加左侧布局，参考gitlab11.0版本', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV109\",\"project_id\":\"3\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"0\",\"summary\":\"\\u4e3b\\u83dc\\u5355\\u589e\\u52a0\\u5de6\\u4fa7\\u5e03\\u5c40\\uff0c\\u53c2\\u8003gitlab11.0\\u7248\\u672c\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1542767100\",\"updated\":\"1542767100\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1900000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1543370322),
(13, 10000, 110, NULL, NULL, 3, 0, 0, 0, 0, 0, '要防止常见的Web攻击', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV110\",\"project_id\":\"3\",\"issue_type\":\"4\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u8981\\u9632\\u6b62\\u5e38\\u89c1\\u7684Web\\u653b\\u51fb\",\"description\":\"1. XSS\\u8de8\\u7ad9\\u811a\\u672c\\u653b\\u51fb\\r\\n2. CSRF\\u8de8\\u7ad9\\u8bf7\\u6c42\\u4f2a\\u9020\\uff0c\\u901a\\u8fc7\\u4f2a\\u88c5\\u6765\\u81ea\\u4fe1\\u4efb\\u7528\\u6237\\u7684\\u8bf7\\u6c42\\u6765\\u5229\\u7528\\u53d7\\u4fe1\\u4efb\\u7684\\u7f51\\u7ad9\\u3002\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"3\",\"created\":\"1542785084\",\"updated\":\"1542785084\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"3\",\"weight\":\"10\",\"backlog_weight\":\"0\",\"sprint_weight\":\"300000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1543370333),
(14, 10000, 107, NULL, NULL, 3, 0, 0, 0, 0, 0, '增加快捷键的提示功能', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV107\",\"project_id\":\"3\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u589e\\u52a0\\u5feb\\u6377\\u952e\\u7684\\u63d0\\u793a\\u529f\\u80fd\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1542766717\",\"updated\":\"1542766717\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"10\",\"backlog_weight\":\"100000\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1543370340),
(15, 10000, 117, NULL, NULL, 3, 0, 0, 0, 0, 0, '可以通过二维码上传手机附件', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV117\",\"project_id\":\"3\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u53ef\\u4ee5\\u901a\\u8fc7\\u4e8c\\u7ef4\\u7801\\u4e0a\\u4f20\\u624b\\u673a\\u9644\\u4ef6\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"3\",\"created\":\"1543314118\",\"updated\":\"1543314118\",\"start_date\":\"2018-11-28\",\"due_date\":\"2018-12-05\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"30\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1543598517),
(16, 11674, 135, NULL, NULL, 3, 0, 0, 0, 0, 0, '111', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV135\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"11674\",\"modifier\":\"0\",\"reporter\":\"11674\",\"assignee\":\"0\",\"summary\":\"111\",\"description\":\"111\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1545031778\",\"updated\":\"1545031778\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11674\"}', 1545032384),
(17, 11674, 122, NULL, NULL, 3, 0, 0, 0, 0, 0, '新手教程', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV122\",\"project_id\":\"3\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"11655\",\"summary\":\"\\u65b0\\u624b\\u6559\\u7a0b\",\"description\":\"\\u65b0\\u624b\\uff1a\\u7b2c\\u4e00\\u6b21\\u8fdb\\u884c\\u7cfb\\u7edf\\u7684\\u7528\\u6237\\r\\n\\r\\n\\u53c2\\u8003 Hopscotch\\r\\nhttp:\\/\\/www.jq22.com\\/yanshi215\\r\\n\\r\\n\\u65b0\\u624b\\u5185\\u5bb9\\u6709\\r\\n\\r\\n\\u5bf9\\u4e8e\\u7ba1\\u7406\\u5458\\uff1a \\u521b\\u5efa\\u9879\\u76ee \\u521b\\u5efa\\u4e8b\\u9879 \\u4fee\\u6539\\u72b6\\u6001 \\u8fed\\u4ee3\\u7ba1\\u7406 \\u770b\\u677f\\u4f7f\\u7528\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"4\",\"created\":\"1543315524\",\"updated\":\"1543315524\",\"start_date\":\"2018-11-28\",\"due_date\":\"2018-12-05\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11674\"}', 1545064075),
(18, 11674, 126, NULL, NULL, 3, 0, 0, 0, 0, 0, '插件功能', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV126\",\"project_id\":\"3\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u63d2\\u4ef6\\u529f\\u80fd\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"10000\",\"status\":\"6\",\"created\":\"1543316541\",\"updated\":\"1543316541\",\"start_date\":\"2018-11-28\",\"due_date\":\"2018-12-05\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"70\",\"backlog_weight\":\"0\",\"sprint_weight\":\"2100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11674\"}', 1545064195),
(19, 11674, 130, NULL, NULL, 3, 0, 0, 0, 0, 0, '完善权限控制', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV130\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5b8c\\u5584\\u6743\\u9650\\u63a7\\u5236\",\"description\":\"\\r\\n1.\\u5bf9\\u6ca1\\u6709\\u6743\\u9650\\u7684\\u7528\\u6237\\u4e0d\\u53ef\\u8bbf\\u95ee\\u76f8\\u5173\\u7684\\u9875\\u9762\\u548c\\u6570\\u636e\\r\\n2.\\u5728\\u6587\\u6863\\u4e2d\\u9488\\u5bf9\\u6743\\u9650\\u7cfb\\u7edf\\u8fdb\\u884c\\u8bf4\\u660e\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"4\",\"created\":\"1543599053\",\"updated\":\"1543599053\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11674\"}', 1545064224),
(20, 11707, 203, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-78193682', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-78193682\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545127619\",\"updated\":\"1545127732\",\"start_date\":\"2018-12-18\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11707\"}', 1545127774),
(21, 11783, 285, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-90159336', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-90159336\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545129080\",\"updated\":\"1545129194\",\"start_date\":\"2018-12-18\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11783\"}', 1545129236),
(22, 11859, 366, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-13178319', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-13178319\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545133509\",\"updated\":\"1545133628\",\"start_date\":\"2018-12-18\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11859\"}', 1545133674),
(23, 11935, 447, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-74142049', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-74142049\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545134766\",\"updated\":\"1545134885\",\"start_date\":\"2018-12-18\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11935\"}', 1545134930),
(24, 10000, 217, NULL, NULL, 3, 0, 0, 0, 0, 0, '新bug来了', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV217\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"0\",\"summary\":\"\\u65b0bug\\u6765\\u4e86\",\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1545127910\",\"updated\":\"1545127910\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"100000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1545154285),
(25, 12011, 528, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-65096797', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-65096797\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545154837\",\"updated\":\"1545154958\",\"start_date\":\"2018-12-19\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"12011\"}', 1545155003),
(26, 12089, 611, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-21971938', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-21971938\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545207141\",\"updated\":\"1545207260\",\"start_date\":\"2018-12-19\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"12089\"}', 1545207306),
(27, 12165, 692, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-40264106', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-40264106\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1545209615\",\"updated\":\"1545209733\",\"start_date\":\"2018-12-19\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"12165\"}', 1545209779);

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
(1, 1, '已解决', 'fixed', '事项已经解决', NULL, '#1aaa55', 0),
(2, 2, '不能解决', 'not_fix', '事项不可抗拒原因无法解决', NULL, '#db3b21', 0),
(3, 3, '事项重复', 'require_duplicate', '事项需要的描述需要有重现步骤', NULL, '#db3b21', 0),
(4, 4, '信息不完整', 'not_complete', '事项信息描述不完整', NULL, '#db3b21', 0),
(5, 5, '不能重现', 'not_reproduce', '事项不能重现', NULL, '#db3b21', 0),
(10000, 6, '结束', 'done', '事项已经解决并关闭掉', NULL, '#1aaa55', 0),
(10100, 8, '问题不存在', 'issue_not_exists', '事项不存在', NULL, 'rgba(0,0,0,0.85)', 0),
(10101, 9, '延迟处理', 'delay', '事项将推迟处理', NULL, 'rgba(0,0,0,0.85)', 0);

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
(1, 1, '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', 0, 'info'),
(3, 3, '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', 0, 'primary'),
(4, 4, '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', 0, 'warning'),
(5, 5, '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', 1, 'success'),
(6, 6, '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', 0, 'success'),
(10002, 9, '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', 0, 'info'),
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
(1, '1', 'Bug', 'bug', 'Standard', '测试过程、维护过程发现影响系统运行的缺陷', 'fa-bug', NULL, 1, 1),
(2, '2', '新功能', 'new_feature', 'Standard', '对系统提出的新功能', 'fa-plus', NULL, 1, 2),
(3, '3', '任务', 'task', 'Standard', '需要完成的任务', 'fa-tasks', NULL, 1, 0),
(4, '4', '优化改进', 'improve', 'Standard', '对现有系统功能的改进', 'fa-arrow-circle-o-up', NULL, 1, 0),
(5, '0', '子任务', 'child_task', 'Standard', '', 'fa-subscript', NULL, 1, 0),
(6, '2', '用户故事', 'user_story', 'Scrum', '从用户的角度来描述用户渴望得到的功能。一个好的用户故事包括三个要素：1. 角色；2. 活动　3. 商业价值', 'fa-users', NULL, 1, 0),
(7, '3', '技术任务', 'tech_task', 'Scrum', '技术性的任务,如架构设计,数据库选型', 'fa-cogs', NULL, 1, 0),
(8, '5', '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', NULL, 1, 0),
(12, '68', 'test-name38147211', 'test-key43903502', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(16, '58', 'test-name37399527', 'test-key74793134', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(20, '88', 'test-name63762354', 'test-key26769367', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(24, '47', 'test-name18787943', 'test-key14132436', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(28, '50', 'test-name71799634', 'test-key54110281', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(32, '92', 'test-name33473927', 'test-key66224311', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(36, '77', 'test-name76615836', 'test-key64836446', 'Standard', 'test-description1', NULL, NULL, 0, 0);

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
(5, '任务管理事项解决方案', '任务管理', 0),
(12, 'test-name-345', 'test-description', 0),
(19, 'test-name-861', 'test-description', 0),
(26, 'test-name-579', 'test-description', 0),
(33, 'test-name-961', 'test-description', 0),
(40, 'test-name-768', 'test-description', 0),
(47, 'test-name-610', 'test-description', 0),
(54, 'test-name-923', 'test-description', 0);

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
(3, 3, 1),
(17, 4, 10000),
(19, 5, 5),
(20, 5, 10002),
(440, 2, 1),
(441, 2, 2),
(442, 2, 4),
(443, 2, 6),
(444, 2, 7),
(445, 2, 8),
(446, 1, 1),
(447, 1, 2),
(448, 1, 3),
(449, 1, 4),
(450, 1, 5);

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
(422, 4, 'create', 1, 14, 0),
(423, 4, 'create', 6, 13, 0),
(424, 4, 'create', 2, 12, 0),
(425, 4, 'create', 3, 11, 0),
(426, 4, 'create', 7, 10, 0),
(427, 4, 'create', 9, 9, 0),
(428, 4, 'create', 8, 8, 0),
(429, 4, 'create', 4, 7, 0),
(430, 4, 'create', 19, 6, 0),
(431, 4, 'create', 10, 5, 0),
(432, 4, 'create', 11, 4, 0),
(433, 4, 'create', 12, 3, 0),
(434, 4, 'create', 13, 2, 0),
(435, 4, 'create', 15, 1, 0),
(436, 4, 'create', 20, 0, 0),
(452, 5, 'create', 1, 14, 0),
(453, 5, 'create', 6, 13, 0),
(454, 5, 'create', 2, 12, 0),
(455, 5, 'create', 7, 11, 0),
(456, 5, 'create', 9, 10, 0),
(457, 5, 'create', 8, 9, 0),
(458, 5, 'create', 3, 8, 0),
(459, 5, 'create', 4, 7, 0),
(460, 5, 'create', 19, 6, 0),
(461, 5, 'create', 10, 5, 0),
(462, 5, 'create', 11, 4, 0),
(463, 5, 'create', 12, 3, 0),
(464, 5, 'create', 13, 2, 0),
(465, 5, 'create', 15, 1, 0),
(466, 5, 'create', 20, 0, 0),
(467, 5, 'edit', 1, 14, 0),
(468, 5, 'edit', 6, 13, 0),
(469, 5, 'edit', 2, 12, 0),
(470, 5, 'edit', 7, 11, 0),
(471, 5, 'edit', 9, 10, 0),
(472, 5, 'edit', 8, 9, 0),
(473, 5, 'edit', 3, 8, 0),
(474, 5, 'edit', 4, 7, 0),
(475, 5, 'edit', 19, 6, 0),
(476, 5, 'edit', 10, 5, 0),
(477, 5, 'edit', 11, 4, 0),
(478, 5, 'edit', 12, 3, 0),
(479, 5, 'edit', 13, 2, 0),
(480, 5, 'edit', 15, 1, 0),
(481, 5, 'edit', 20, 0, 0),
(587, 6, 'create', 1, 7, 0),
(588, 6, 'create', 6, 6, 0),
(589, 6, 'create', 2, 5, 0),
(590, 6, 'create', 8, 4, 0),
(591, 6, 'create', 11, 3, 0),
(592, 6, 'create', 4, 2, 0),
(593, 6, 'create', 21, 1, 0),
(594, 6, 'create', 15, 0, 0),
(595, 6, 'create', 19, 6, 33),
(596, 6, 'create', 10, 5, 33),
(597, 6, 'create', 7, 4, 33),
(598, 6, 'create', 20, 3, 33),
(599, 6, 'create', 9, 2, 33),
(600, 6, 'create', 13, 1, 33),
(601, 6, 'create', 12, 0, 33),
(602, 6, 'edit', 1, 7, 0),
(603, 6, 'edit', 6, 6, 0),
(604, 6, 'edit', 2, 5, 0),
(605, 6, 'edit', 8, 4, 0),
(606, 6, 'edit', 4, 3, 0),
(607, 6, 'edit', 11, 2, 0),
(608, 6, 'edit', 15, 1, 0),
(609, 6, 'edit', 21, 0, 0),
(610, 6, 'edit', 19, 6, 34),
(611, 6, 'edit', 10, 5, 34),
(612, 6, 'edit', 7, 4, 34),
(613, 6, 'edit', 20, 3, 34),
(614, 6, 'edit', 9, 2, 34),
(615, 6, 'edit', 12, 1, 34),
(616, 6, 'edit', 13, 0, 34),
(646, 7, 'create', 1, 7, 0),
(647, 7, 'create', 6, 6, 0),
(648, 7, 'create', 2, 5, 0),
(649, 7, 'create', 8, 4, 0),
(650, 7, 'create', 4, 3, 0),
(651, 7, 'create', 11, 2, 0),
(652, 7, 'create', 15, 1, 0),
(653, 7, 'create', 21, 0, 0),
(654, 7, 'create', 19, 6, 37),
(655, 7, 'create', 10, 5, 37),
(656, 7, 'create', 7, 4, 37),
(657, 7, 'create', 20, 3, 37),
(658, 7, 'create', 9, 2, 37),
(659, 7, 'create', 13, 1, 37),
(660, 7, 'create', 12, 0, 37),
(661, 7, 'edit', 1, 7, 0),
(662, 7, 'edit', 6, 6, 0),
(663, 7, 'edit', 2, 5, 0),
(664, 7, 'edit', 8, 4, 0),
(665, 7, 'edit', 4, 3, 0),
(666, 7, 'edit', 11, 2, 0),
(667, 7, 'edit', 15, 1, 0),
(668, 7, 'edit', 21, 0, 0),
(669, 7, 'edit', 19, 6, 38),
(670, 7, 'edit', 10, 5, 38),
(671, 7, 'edit', 7, 4, 38),
(672, 7, 'edit', 9, 3, 38),
(673, 7, 'edit', 20, 2, 38),
(674, 7, 'edit', 12, 1, 38),
(675, 7, 'edit', 13, 0, 38),
(834, 3, 'create', 1, 13, 0),
(835, 3, 'create', 6, 12, 0),
(836, 3, 'create', 2, 11, 0),
(837, 3, 'create', 7, 10, 0),
(838, 3, 'create', 9, 9, 0),
(839, 3, 'create', 8, 8, 0),
(840, 3, 'create', 3, 7, 0),
(841, 3, 'create', 4, 6, 0),
(842, 3, 'create', 19, 5, 0),
(843, 3, 'create', 10, 4, 0),
(844, 3, 'create', 11, 3, 0),
(845, 3, 'create', 12, 2, 0),
(846, 3, 'create', 13, 1, 0),
(847, 3, 'create', 20, 0, 0),
(848, 3, 'edit', 1, 13, 0),
(849, 3, 'edit', 6, 12, 0),
(850, 3, 'edit', 2, 11, 0),
(851, 3, 'edit', 7, 10, 0),
(852, 3, 'edit', 9, 9, 0),
(853, 3, 'edit', 8, 8, 0),
(854, 3, 'edit', 3, 7, 0),
(855, 3, 'edit', 4, 6, 0),
(856, 3, 'edit', 19, 5, 0),
(857, 3, 'edit', 10, 4, 0),
(858, 3, 'edit', 11, 3, 0),
(859, 3, 'edit', 12, 2, 0),
(860, 3, 'edit', 13, 1, 0),
(861, 3, 'edit', 20, 0, 0),
(862, 3, 'edit', 20, 2, 49),
(863, 3, 'edit', 9, 1, 49),
(864, 3, 'edit', 3, 0, 49),
(911, 2, 'edit', 1, 11, 0),
(912, 2, 'edit', 19, 10, 0),
(913, 2, 'edit', 10, 9, 0),
(914, 2, 'edit', 6, 8, 0),
(915, 2, 'edit', 2, 7, 0),
(916, 2, 'edit', 7, 6, 0),
(917, 2, 'edit', 4, 5, 0),
(918, 2, 'edit', 11, 4, 0),
(919, 2, 'edit', 12, 3, 0),
(920, 2, 'edit', 13, 2, 0),
(921, 2, 'edit', 15, 1, 0),
(922, 2, 'edit', 21, 0, 0),
(923, 2, 'edit', 20, 2, 53),
(924, 2, 'edit', 9, 1, 53),
(925, 2, 'edit', 3, 0, 53),
(926, 1, 'create', 1, 8, 0),
(927, 1, 'create', 6, 7, 0),
(928, 1, 'create', 2, 6, 0),
(929, 1, 'create', 7, 5, 0),
(930, 1, 'create', 4, 4, 0),
(931, 1, 'create', 11, 3, 0),
(932, 1, 'create', 12, 2, 0),
(933, 1, 'create', 13, 1, 0),
(934, 1, 'create', 15, 0, 0),
(935, 1, 'create', 19, 6, 54),
(936, 1, 'create', 20, 5, 54),
(937, 1, 'create', 3, 4, 54),
(938, 1, 'create', 10, 3, 54),
(939, 1, 'create', 21, 2, 54),
(940, 1, 'create', 8, 1, 54),
(941, 1, 'create', 9, 0, 54),
(942, 1, 'edit', 1, 9, 0),
(943, 1, 'edit', 6, 8, 0),
(944, 1, 'edit', 2, 7, 0),
(945, 1, 'edit', 7, 6, 0),
(946, 1, 'edit', 4, 5, 0),
(947, 1, 'edit', 19, 4, 0),
(948, 1, 'edit', 11, 3, 0),
(949, 1, 'edit', 12, 2, 0),
(950, 1, 'edit', 13, 1, 0),
(951, 1, 'edit', 15, 0, 0),
(952, 1, 'edit', 3, 5, 55),
(953, 1, 'edit', 20, 4, 55),
(954, 1, 'edit', 10, 3, 55),
(955, 1, 'edit', 21, 2, 55),
(956, 1, 'edit', 8, 1, 55),
(957, 1, 'edit', 9, 0, 55),
(958, 2, 'create', 1, 10, 0),
(959, 2, 'create', 6, 9, 0),
(960, 2, 'create', 19, 8, 0),
(961, 2, 'create', 2, 7, 0),
(962, 2, 'create', 7, 6, 0),
(963, 2, 'create', 4, 5, 0),
(964, 2, 'create', 11, 4, 0),
(965, 2, 'create', 12, 3, 0),
(966, 2, 'create', 13, 2, 0),
(967, 2, 'create', 15, 1, 0),
(968, 2, 'create', 21, 0, 0),
(969, 2, 'create', 10, 3, 56),
(970, 2, 'create', 20, 2, 56),
(971, 2, 'create', 9, 1, 56),
(972, 2, 'create', 3, 0, 56),
(989, 4, 'edit', 1, 11, 0),
(990, 4, 'edit', 6, 10, 0),
(991, 4, 'edit', 2, 9, 0),
(992, 4, 'edit', 7, 8, 0),
(993, 4, 'edit', 4, 7, 0),
(994, 4, 'edit', 19, 6, 0),
(995, 4, 'edit', 11, 5, 0),
(996, 4, 'edit', 12, 4, 0),
(997, 4, 'edit', 13, 3, 0),
(998, 4, 'edit', 15, 2, 0),
(999, 4, 'edit', 20, 1, 0),
(1000, 4, 'edit', 21, 0, 0),
(1001, 4, 'edit', 8, 3, 58),
(1002, 4, 'edit', 9, 2, 58),
(1003, 4, 'edit', 3, 1, 58),
(1004, 4, 'edit', 10, 0, 58);

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
(33, 6, '更多', 0, 'create'),
(34, 6, '\n            \n            更多\n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(37, 7, '更 多', 0, 'create'),
(38, 7, '\n            \n            更 多\n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(49, 3, '\n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(53, 2, '\n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n   ', 0, 'edit'),
(54, 1, '更 多', 0, 'create'),
(55, 1, '\n            \n            更 多\n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(56, 2, '更 多', 0, 'create'),
(58, 4, '\n            \n            更多\n             \n            \n        \n             \n            \n        ', 0, 'edit');

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
(31, 0, '日志', 0, 10000, 'cdwei', '韦朝夺', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1536425345,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1536425355,\"f3\":\"google\"}', 'unknown', 1536425355),
(62, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545127373,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545127383,\"f3\":\"google\"}', 'unknown', 1545127383),
(93, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545128819,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545128829,\"f3\":\"google\"}', 'unknown', 1545128830),
(124, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545133223,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545133233,\"f3\":\"google\"}', 'unknown', 1545133234),
(155, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545134466,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545134476,\"f3\":\"google\"}', 'unknown', 1545134477),
(186, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545154515,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545154525,\"f3\":\"google\"}', 'unknown', 1545154525),
(217, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545206697,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545206707,\"f3\":\"google\"}', 'unknown', 1545206707),
(248, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1545209142,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1545209152,\"f3\":\"google\"}', 'unknown', 1545209152);

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
(1, 3, '事项', 134, 10000, 'cdwei', 'Sven', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"134\",\"pkey\":\"DEV\",\"issue_num\":\"DEV134\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"0\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5f53\\u767b\\u5f55\\u72b6\\u6001\\u5931\\u6548\\u540eAjax\\u8bf7\\u6c42\\u7684\\u63a5\\u53e3\\u5e94\\u8be5\\u8df3\\u8f6c\\u5230\\u767b\\u5f55\\u9875\\u9762\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"4\",\"created\":\"1543644588\",\"updated\":\"1543644588\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"600000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"134\",\"pkey\":\"DEV\",\"issue_num\":\"DEV134\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5f53\\u767b\\u5f55\\u72b6\\u6001\\u5931\\u6548\\u540eAjax\\u8bf7\\u6c42\\u7684\\u63a5\\u53e3\\u5e94\\u8be5\\u8df3\\u8f6c\\u5230\\u767b\\u5f55\\u9875\\u9762\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":5,\"created\":\"1543644588\",\"updated\":\"1543644588\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"600000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1544408436),
(2, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/addRoleUser', NULL, NULL, '新增', '添加项目角色的用户', '{\"user_id\":10000,\"project_id\":\"3\",\"role_id\":13}', '{\"user_id\":10000,\"project_id\":\"3\",\"role_id\":13}', '127.0.0.1', 1544986020),
(3, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/addRoleUser', NULL, NULL, '新增', '添加项目角色的用户', '{\"user_id\":11674,\"project_id\":\"3\",\"role_id\":12}', '{\"user_id\":11674,\"project_id\":\"3\",\"role_id\":12}', '127.0.0.1', 1545031329),
(4, 3, '事项', 135, 11674, '79720699@qq.com', 'Sven', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"111\",\"creator\":\"11674\",\"reporter\":\"11674\",\"created\":1545031778,\"updated\":1545031778,\"project_id\":3,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"111\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":4,\"weight\":0}', '{\"summary\":\"111\",\"creator\":\"11674\",\"reporter\":\"11674\",\"created\":1545031778,\"updated\":1545031778,\"project_id\":3,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"111\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":4,\"weight\":0}', '127.0.0.1', 1545031779),
(5, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545032121),
(6, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545032209),
(7, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545032252),
(8, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545032259),
(9, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545032401),
(10, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545032842),
(11, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545036143),
(12, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/addRoleUser', NULL, NULL, '新增', '添加项目角色的用户', '{\"user_id\":11653,\"project_id\":\"3\",\"role_id\":13}', '{\"user_id\":11653,\"project_id\":\"3\",\"role_id\":13}', '127.0.0.1', 1545036310),
(13, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545060539),
(14, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545060758),
(15, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545060789),
(16, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545060818),
(17, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545060832),
(18, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545062508),
(19, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545071655),
(20, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545072526),
(21, 50, '事项', 205, 11707, '19077564988', '19061235624', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11707\",\"reporter\":\"11707\",\"created\":1545127691,\"updated\":1545127691,\"project_id\":50,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11707,\"module\":\"30\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":27}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11707\",\"reporter\":\"11707\",\"created\":1545127691,\"updated\":1545127691,\"project_id\":50,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11707,\"module\":\"30\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":27}', '127.0.0.1', 1545127693),
(22, 50, '事项', 205, 11707, '19077564988', '19061235624', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"205\",\"pkey\":\"TESTKEY4CPLU38548221\",\"issue_num\":\"TESTKEY4CPLU38548221205\",\"project_id\":\"50\",\"issue_type\":\"1\",\"creator\":\"11707\",\"modifier\":\"0\",\"reporter\":\"11707\",\"assignee\":\"11707\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545127691\",\"updated\":\"1545127691\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"30\",\"milestone\":null,\"sprint\":\"27\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"205\",\"pkey\":\"TESTKEY4CPLU38548221\",\"issue_num\":\"TESTKEY4CPLU38548221205\",\"project_id\":\"50\",\"issue_type\":\"1\",\"creator\":\"11707\",\"modifier\":\"11707\",\"reporter\":\"11707\",\"assignee\":\"11707\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545127691\",\"updated\":\"1545127691\",\"start_date\":\"2018-12-17\",\"due_date\":\"2018-12-24\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545127711),
(23, 0, '组织', 0, 11709, '19089064741', '19037544041', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-74019\",\"name\":\"test-path-74019\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545127804,\"create_uid\":\"11709\"}', '{\"path\":\"test-path-74019\",\"name\":\"test-path-74019\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545127804,\"create_uid\":\"11709\"}', '127.0.0.1', 1545127804),
(24, 0, '项目', 0, 11709, '19089064741', '19037544041', '/org/update/14', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"14\",\"path\":\"test-path-74019\",\"name\":\"test-path-74019\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11709\",\"created\":\"1545127804\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545127807}', '127.0.0.1', 1545127808),
(25, 0, '组织', 0, 11709, '19089064741', '19037544041', '/org/delete/14', NULL, NULL, '删除', '删除组织', '{\"id\":\"14\",\"path\":\"test-path-74019\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11709\",\"created\":\"1545127804\",\"updated\":\"1545127807\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545127812),
(26, 3, '事项', 217, 1, 'master', 'Master', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u65b0bug\\u6765\\u4e86\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1545127910,\"updated\":1545127910,\"project_id\":3,\"issue_type\":1,\"status\":1,\"priority\":2,\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":4,\"weight\":0}', '{\"summary\":\"\\u65b0bug\\u6765\\u4e86\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1545127910,\"updated\":1545127910,\"project_id\":3,\"issue_type\":1,\"status\":1,\"priority\":2,\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":4,\"weight\":0}', '183.11.31.54', 1545127910),
(27, 0, '用户', 11720, 11720, '19089531557', '19029239247', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"11720\",\"directory_id\":null,\"phone\":\"19029239247\",\"username\":\"19089531557\",\"openid\":\"f4f5d64e9e9d02069616694a40e04768\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19029239247\",\"email\":\"19029239247@masterlab.org\",\"password\":\"$2y$10$N2mZp1gn9V0LHN9CBLZSaOt7fr8q9k3rMJ\\/YoRgH11Iw.4ZbX2ipu\",\"sex\":\"0\",\"birthday\":\"2018-12-18\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/11720.png?t=1545127941\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545127924\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19029239247\",\"birthday\":\"2018-12-18\",\"avatar\":\"avatar\\/11720.png?t=1545127941\"}', '127.0.0.1', 1545127942),
(28, 3, '事项', 134, 1, 'master', 'Master', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"134\",\"pkey\":\"DEV\",\"issue_num\":\"DEV134\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5f53\\u767b\\u5f55\\u72b6\\u6001\\u5931\\u6548\\u540eAjax\\u8bf7\\u6c42\\u7684\\u63a5\\u53e3\\u5e94\\u8be5\\u8df3\\u8f6c\\u5230\\u767b\\u5f55\\u9875\\u9762\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"5\",\"created\":\"1543644588\",\"updated\":\"1543644588\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"500000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"134\",\"pkey\":\"DEV\",\"issue_num\":\"DEV134\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"1\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5f53\\u767b\\u5f55\\u72b6\\u6001\\u5931\\u6548\\u540eAjax\\u8bf7\\u6c42\\u7684\\u63a5\\u53e3\\u5e94\\u8be5\\u8df3\\u8f6c\\u5230\\u767b\\u5f55\\u9875\\u9762\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"5\",\"created\":\"1543644588\",\"updated\":\"1543644588\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"500000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '183.11.31.54', 1545128409),
(29, 0, '项目', 0, 11750, '19064156715', '19027458690', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-ysMfjA7031\",\"org_id\":\"1\",\"key\":\"PROKEYJXTNN\",\"lead\":\"10000\",\"description\":\"h5quCKoAHr\",\"type\":10,\"category\":0,\"url\":\"7wQ9pAJkWe\",\"create_time\":1545128417,\"create_uid\":\"11750\",\"avatar\":\"\",\"detail\":\"MzXAAPA3po\",\"org_path\":\"default\"}', '{\"name\":\"PROName-ysMfjA7031\",\"org_id\":\"1\",\"key\":\"PROKEYJXTNN\",\"lead\":\"10000\",\"description\":\"h5quCKoAHr\",\"type\":10,\"category\":0,\"url\":\"7wQ9pAJkWe\",\"create_time\":1545128417,\"create_uid\":\"11750\",\"avatar\":\"\",\"detail\":\"MzXAAPA3po\",\"org_path\":\"default\"}', '127.0.0.1', 1545128426),
(30, 135, '事项', 287, 11783, '19072024882', '19077049456', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11783\",\"reporter\":\"11783\",\"created\":1545129153,\"updated\":1545129153,\"project_id\":135,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11783,\"module\":\"46\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":49}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11783\",\"reporter\":\"11783\",\"created\":1545129153,\"updated\":1545129153,\"project_id\":135,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11783,\"module\":\"46\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":49}', '127.0.0.1', 1545129155),
(31, 135, '事项', 287, 11783, '19072024882', '19077049456', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"287\",\"pkey\":\"TESTKEYFVDLN39602100\",\"issue_num\":\"TESTKEYFVDLN39602100287\",\"project_id\":\"135\",\"issue_type\":\"1\",\"creator\":\"11783\",\"modifier\":\"0\",\"reporter\":\"11783\",\"assignee\":\"11783\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545129153\",\"updated\":\"1545129153\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"46\",\"milestone\":null,\"sprint\":\"49\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"287\",\"pkey\":\"TESTKEYFVDLN39602100\",\"issue_num\":\"TESTKEYFVDLN39602100287\",\"project_id\":\"135\",\"issue_type\":\"1\",\"creator\":\"11783\",\"modifier\":\"11783\",\"reporter\":\"11783\",\"assignee\":\"11783\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545129153\",\"updated\":\"1545129153\",\"start_date\":\"2018-12-17\",\"due_date\":\"2018-12-24\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545129173),
(32, 0, '组织', 0, 11785, '19019868982', '19079362586', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-38543\",\"name\":\"test-path-38543\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545129266,\"create_uid\":\"11785\"}', '{\"path\":\"test-path-38543\",\"name\":\"test-path-38543\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545129266,\"create_uid\":\"11785\"}', '127.0.0.1', 1545129267),
(33, 0, '项目', 0, 11785, '19019868982', '19079362586', '/org/update/45', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"45\",\"path\":\"test-path-38543\",\"name\":\"test-path-38543\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11785\",\"created\":\"1545129266\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545129269}', '127.0.0.1', 1545129270),
(34, 0, '组织', 0, 11785, '19019868982', '19079362586', '/org/delete/45', NULL, NULL, '删除', '删除组织', '{\"id\":\"45\",\"path\":\"test-path-38543\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11785\",\"created\":\"1545129266\",\"updated\":\"1545129269\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545129273),
(35, 0, '用户', 11796, 11796, '19079779372', '19031854971', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"11796\",\"directory_id\":null,\"phone\":\"19031854971\",\"username\":\"19079779372\",\"openid\":\"28fe325097ed5ebf714abf14c177b696\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19031854971\",\"email\":\"19031854971@masterlab.org\",\"password\":\"$2y$10$VLOs9VfMKiEegqCdx4N0leu1e99osBsNCaMqDQfxNCIxO4zIeFuyi\",\"sex\":\"0\",\"birthday\":\"2018-12-18\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/11796.png?t=1545129407\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545129390\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19031854971\",\"birthday\":\"2018-12-18\",\"avatar\":\"avatar\\/11796.png?t=1545129407\"}', '127.0.0.1', 1545129408),
(36, 0, '项目', 0, 11826, '19053976204', '19047111709', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-DcTIojlgYm\",\"org_id\":\"1\",\"key\":\"PROKEYQEZFV\",\"lead\":\"10000\",\"description\":\"JbCDYoPQJs\",\"type\":10,\"category\":0,\"url\":\"3JD8aznMzj\",\"create_time\":1545129887,\"create_uid\":\"11826\",\"avatar\":\"\",\"detail\":\"7oyq3Tpis3\",\"org_path\":\"default\"}', '{\"name\":\"PROName-DcTIojlgYm\",\"org_id\":\"1\",\"key\":\"PROKEYQEZFV\",\"lead\":\"10000\",\"description\":\"JbCDYoPQJs\",\"type\":10,\"category\":0,\"url\":\"3JD8aznMzj\",\"create_time\":1545129887,\"create_uid\":\"11826\",\"avatar\":\"\",\"detail\":\"7oyq3Tpis3\",\"org_path\":\"default\"}', '127.0.0.1', 1545129896),
(37, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1545129978\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\",\"birthday\":\"\"}', '171.111.227.98', 1545130092),
(38, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1545129978\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\",\"birthday\":\"\"}', '171.111.227.98', 1545130094),
(39, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1545129978\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\",\"birthday\":\"\"}', '171.111.227.98', 1545130095),
(40, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1545129978\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\",\"birthday\":\"\"}', '171.111.227.98', 1545130096),
(41, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1545129978\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\",\"birthday\":\"\"}', '171.111.227.98', 1545130097),
(42, 220, '事项', 368, 11859, '19015148724', '19079891097', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11859\",\"reporter\":\"11859\",\"created\":1545133586,\"updated\":1545133586,\"project_id\":220,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11859,\"module\":\"62\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":71}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11859\",\"reporter\":\"11859\",\"created\":1545133586,\"updated\":1545133586,\"project_id\":220,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11859,\"module\":\"62\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":71}', '127.0.0.1', 1545133588),
(43, 220, '事项', 368, 11859, '19015148724', '19079891097', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"368\",\"pkey\":\"TESTKEYILXOT31871670\",\"issue_num\":\"TESTKEYILXOT31871670368\",\"project_id\":\"220\",\"issue_type\":\"1\",\"creator\":\"11859\",\"modifier\":\"0\",\"reporter\":\"11859\",\"assignee\":\"11859\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545133586\",\"updated\":\"1545133586\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"62\",\"milestone\":null,\"sprint\":\"71\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"368\",\"pkey\":\"TESTKEYILXOT31871670\",\"issue_num\":\"TESTKEYILXOT31871670368\",\"project_id\":\"220\",\"issue_type\":\"1\",\"creator\":\"11859\",\"modifier\":\"11859\",\"reporter\":\"11859\",\"assignee\":\"11859\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545133586\",\"updated\":\"1545133586\",\"start_date\":\"2018-12-17\",\"due_date\":\"2018-12-24\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545133607),
(44, 0, '组织', 0, 11861, '19065034195', '19014605420', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-56974\",\"name\":\"test-path-56974\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545133705,\"create_uid\":\"11861\"}', '{\"path\":\"test-path-56974\",\"name\":\"test-path-56974\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545133705,\"create_uid\":\"11861\"}', '127.0.0.1', 1545133705),
(45, 0, '项目', 0, 11861, '19065034195', '19014605420', '/org/update/76', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"76\",\"path\":\"test-path-56974\",\"name\":\"test-path-56974\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11861\",\"created\":\"1545133705\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545133708}', '127.0.0.1', 1545133709),
(46, 0, '组织', 0, 11861, '19065034195', '19014605420', '/org/delete/76', NULL, NULL, '删除', '删除组织', '{\"id\":\"76\",\"path\":\"test-path-56974\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11861\",\"created\":\"1545133705\",\"updated\":\"1545133708\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545133712),
(47, 0, '用户', 11872, 11872, '19018181483', '19016103401', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"11872\",\"directory_id\":null,\"phone\":\"19016103401\",\"username\":\"19018181483\",\"openid\":\"54196c6eaaaea4c3d03144057498e8b2\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19016103401\",\"email\":\"19016103401@masterlab.org\",\"password\":\"$2y$10$plHBRcjGGdAo62nYUbVs1etdvPdg0ppwtMDw0VDQ\\/CDQ6hvGpUuu2\",\"sex\":\"0\",\"birthday\":\"2018-12-18\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/11872.png?t=1545133843\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545133825\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19016103401\",\"birthday\":\"2018-12-18\",\"avatar\":\"avatar\\/11872.png?t=1545133843\"}', '127.0.0.1', 1545133844),
(48, 0, '项目', 0, 11902, '19064197591', '19044791235', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-TBi763sGg9\",\"org_id\":\"1\",\"key\":\"PROKEYPLYLN\",\"lead\":\"10000\",\"description\":\"BZozfO4WvT\",\"type\":10,\"category\":0,\"url\":\"etYz19Mhke\",\"create_time\":1545134333,\"create_uid\":\"11902\",\"avatar\":\"\",\"detail\":\"FYIljv18U7\",\"org_path\":\"default\"}', '{\"name\":\"PROName-TBi763sGg9\",\"org_id\":\"1\",\"key\":\"PROKEYPLYLN\",\"lead\":\"10000\",\"description\":\"BZozfO4WvT\",\"type\":10,\"category\":0,\"url\":\"etYz19Mhke\",\"create_time\":1545134333,\"create_uid\":\"11902\",\"avatar\":\"\",\"detail\":\"FYIljv18U7\",\"org_path\":\"default\"}', '127.0.0.1', 1545134342),
(49, 305, '事项', 449, 11935, '19021976938', '19075488911', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11935\",\"reporter\":\"11935\",\"created\":1545134842,\"updated\":1545134842,\"project_id\":305,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11935,\"module\":\"78\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":93}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"11935\",\"reporter\":\"11935\",\"created\":1545134842,\"updated\":1545134842,\"project_id\":305,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":11935,\"module\":\"78\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"sprint\":93}', '127.0.0.1', 1545134844),
(50, 305, '事项', 449, 11935, '19021976938', '19075488911', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"449\",\"pkey\":\"TESTKEYHLIXJ91184983\",\"issue_num\":\"TESTKEYHLIXJ91184983449\",\"project_id\":\"305\",\"issue_type\":\"1\",\"creator\":\"11935\",\"modifier\":\"0\",\"reporter\":\"11935\",\"assignee\":\"11935\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545134842\",\"updated\":\"1545134842\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"78\",\"milestone\":null,\"sprint\":\"93\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"449\",\"pkey\":\"TESTKEYHLIXJ91184983\",\"issue_num\":\"TESTKEYHLIXJ91184983449\",\"project_id\":\"305\",\"issue_type\":\"1\",\"creator\":\"11935\",\"modifier\":\"11935\",\"reporter\":\"11935\",\"assignee\":\"11935\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545134842\",\"updated\":\"1545134842\",\"start_date\":\"2018-12-17\",\"due_date\":\"2018-12-24\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545134863),
(51, 0, '组织', 0, 11937, '19033527389', '19068806973', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-73024\",\"name\":\"test-path-73024\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545134961,\"create_uid\":\"11937\"}', '{\"path\":\"test-path-73024\",\"name\":\"test-path-73024\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545134961,\"create_uid\":\"11937\"}', '127.0.0.1', 1545134961),
(52, 0, '项目', 0, 11937, '19033527389', '19068806973', '/org/update/107', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"107\",\"path\":\"test-path-73024\",\"name\":\"test-path-73024\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11937\",\"created\":\"1545134961\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545134964}', '127.0.0.1', 1545134965),
(53, 0, '组织', 0, 11937, '19033527389', '19068806973', '/org/delete/107', NULL, NULL, '删除', '删除组织', '{\"id\":\"107\",\"path\":\"test-path-73024\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"11937\",\"created\":\"1545134961\",\"updated\":\"1545134964\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545134968),
(54, 0, '用户', 11948, 11948, '19081448317', '19073055713', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"11948\",\"directory_id\":null,\"phone\":\"19073055713\",\"username\":\"19081448317\",\"openid\":\"78ee45c8c52423dc66484a506939860f\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19073055713\",\"email\":\"19073055713@masterlab.org\",\"password\":\"$2y$10$DfVjuq\\/4\\/BGow81K6QefB.zg8Xo2CAEvpHr9HOjs4jn8YU06uL9Iu\",\"sex\":\"0\",\"birthday\":\"2018-12-18\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/11948.png?t=1545135099\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545135081\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19073055713\",\"birthday\":\"2018-12-18\",\"avatar\":\"avatar\\/11948.png?t=1545135099\"}', '127.0.0.1', 1545135100),
(55, 0, '项目', 0, 11978, '19086422099', '19016217078', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-YqpUGU37L1\",\"org_id\":\"1\",\"key\":\"PROKEYZIFTX\",\"lead\":\"10000\",\"description\":\"OmJfeIWxMq\",\"type\":10,\"category\":0,\"url\":\"N9ydTwfg8b\",\"create_time\":1545135590,\"create_uid\":\"11978\",\"avatar\":\"\",\"detail\":\"fBjPqQiWne\",\"org_path\":\"default\"}', '{\"name\":\"PROName-YqpUGU37L1\",\"org_id\":\"1\",\"key\":\"PROKEYZIFTX\",\"lead\":\"10000\",\"description\":\"OmJfeIWxMq\",\"type\":10,\"category\":0,\"url\":\"N9ydTwfg8b\",\"create_time\":1545135590,\"create_uid\":\"11978\",\"avatar\":\"\",\"detail\":\"fBjPqQiWne\",\"org_path\":\"default\"}', '127.0.0.1', 1545135599),
(56, 3, '事项', 133, 1, 'master', 'Master', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"133\",\"pkey\":\"DEV\",\"issue_num\":\"DEV133\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"11655\",\"summary\":\"\\u4f7f\\u7528\\u975echrome Firefox\\u6d4f\\u89c8\\u5668\\u65f6\\u6ca1\\u6709\\u63d0\\u793a\\u517c\\u5bb9\\u6027\",\"description\":\"\\u540c\\u65f6\\u63d0\\u793a\\u7528\\u6237\\u53bb\\u4e0b\\u8f7d \\u8c37\\u6b4c\\u548cQQ\\u6d4f\\u89c8\\u5668 \",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"4\",\"created\":\"1543644426\",\"updated\":\"1543644426\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"4\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"133\",\"pkey\":\"DEV\",\"issue_num\":\"DEV133\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"1\",\"reporter\":\"10000\",\"assignee\":\"11655\",\"summary\":\"\\u4f7f\\u7528\\u975echrome Firefox\\u6d4f\\u89c8\\u5668\\u65f6\\u6ca1\\u6709\\u63d0\\u793a\\u517c\\u5bb9\\u6027\",\"description\":\"\\u540c\\u65f6\\u63d0\\u793a\\u7528\\u6237\\u53bb\\u4e0b\\u8f7d \\u8c37\\u6b4c\\u548cQQ\\u6d4f\\u89c8\\u5668 \",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"4\",\"created\":\"1543644426\",\"updated\":\"1543644426\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"200000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '113.104.244.207', 1545144811),
(57, 286, '事项', 411, 1, 'master', 'Master', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"411\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"286\",\"issue_type\":\"1\",\"creator\":\"11917\",\"modifier\":\"11917\",\"reporter\":\"11917\",\"assignee\":\"11917\",\"summary\":\"testFilterSummary3Rand13463933\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545134450\",\"updated\":\"1545134449\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":\"2018-12-25\",\"module\":\"71\",\"milestone\":null,\"sprint\":\"86\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"411\",\"pkey\":null,\"issue_num\":null,\"project_id\":\"286\",\"issue_type\":\"1\",\"creator\":\"11917\",\"modifier\":\"1\",\"reporter\":\"11917\",\"assignee\":\"11917\",\"summary\":\"testFilterSummary3Rand13463933\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":5,\"created\":\"1545134450\",\"updated\":\"1545134449\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":\"2018-12-25\",\"module\":\"71\",\"milestone\":null,\"sprint\":\"86\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '113.88.81.230', 1545149443),
(58, 3, '事项', 134, 10000, 'cdwei', 'Sven', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"134\",\"pkey\":\"DEV\",\"issue_num\":\"DEV134\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"1\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5f53\\u767b\\u5f55\\u72b6\\u6001\\u5931\\u6548\\u540eAjax\\u8bf7\\u6c42\\u7684\\u63a5\\u53e3\\u5e94\\u8be5\\u8df3\\u8f6c\\u5230\\u767b\\u5f55\\u9875\\u9762\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"5\",\"created\":\"1543644588\",\"updated\":\"1543644588\",\"start_date\":\"2018-12-01\",\"due_date\":\"2018-12-04\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"200000\",\"sprint_weight\":\"500000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"134\",\"pkey\":\"DEV\",\"issue_num\":\"DEV134\",\"project_id\":\"3\",\"issue_type\":\"1\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u5f53\\u767b\\u5f55\\u72b6\\u6001\\u5931\\u6548\\u540eAjax\\u8bf7\\u6c42\\u7684\\u63a5\\u53e3\\u5e94\\u8be5\\u8df3\\u8f6c\\u5230\\u767b\\u5f55\\u9875\\u9762\",\"description\":\"\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"0\",\"status\":\"5\",\"created\":\"1543644588\",\"updated\":\"1543644588\",\"start_date\":\"2018-12-13\",\"due_date\":\"2018-12-22\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"200000\",\"sprint_weight\":\"500000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545154307),
(59, 390, '事项', 530, 12011, '19075305187', '19078667781', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"12011\",\"reporter\":\"12011\",\"created\":1545154915,\"updated\":1545154915,\"project_id\":390,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":12011,\"module\":\"94\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"sprint\":115}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"12011\",\"reporter\":\"12011\",\"created\":1545154915,\"updated\":1545154915,\"project_id\":390,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":12011,\"module\":\"94\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"sprint\":115}', '127.0.0.1', 1545154917),
(60, 390, '事项', 530, 12011, '19075305187', '19078667781', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"530\",\"pkey\":\"TESTKEYITFDH68771050\",\"issue_num\":\"TESTKEYITFDH68771050530\",\"project_id\":\"390\",\"issue_type\":\"1\",\"creator\":\"12011\",\"modifier\":\"0\",\"reporter\":\"12011\",\"assignee\":\"12011\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545154915\",\"updated\":\"1545154915\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"resolve_date\":null,\"module\":\"94\",\"milestone\":null,\"sprint\":\"115\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"530\",\"pkey\":\"TESTKEYITFDH68771050\",\"issue_num\":\"TESTKEYITFDH68771050530\",\"project_id\":\"390\",\"issue_type\":\"1\",\"creator\":\"12011\",\"modifier\":\"12011\",\"reporter\":\"12011\",\"assignee\":\"12011\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545154915\",\"updated\":\"1545154915\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545154935),
(61, 0, '组织', 0, 12013, '19030646588', '19022449738', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-94526\",\"name\":\"test-path-94526\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545155034,\"create_uid\":\"12013\"}', '{\"path\":\"test-path-94526\",\"name\":\"test-path-94526\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545155034,\"create_uid\":\"12013\"}', '127.0.0.1', 1545155034),
(62, 0, '项目', 0, 12013, '19030646588', '19022449738', '/org/update/138', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"138\",\"path\":\"test-path-94526\",\"name\":\"test-path-94526\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"12013\",\"created\":\"1545155034\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545155037}', '127.0.0.1', 1545155038),
(63, 0, '组织', 0, 12013, '19030646588', '19022449738', '/org/delete/138', NULL, NULL, '删除', '删除组织', '{\"id\":\"138\",\"path\":\"test-path-94526\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"12013\",\"created\":\"1545155034\",\"updated\":\"1545155037\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545155041),
(64, 0, '用户', 12024, 12024, '19032268338', '19028356340', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"12024\",\"directory_id\":null,\"phone\":\"19028356340\",\"username\":\"19032268338\",\"openid\":\"c06d466e1a446ddf8608538adbe6cdca\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19028356340\",\"email\":\"19028356340@masterlab.org\",\"password\":\"$2y$10$PvkqpCBLQxEEATLYQ0ox9ed8ZpkCWGJVYsv0i5qfyths90zEtt9rK\",\"sex\":\"0\",\"birthday\":\"2018-12-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/12024.png?t=1545155171\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545155153\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19028356340\",\"birthday\":\"2018-12-19\",\"avatar\":\"avatar\\/12024.png?t=1545155171\"}', '127.0.0.1', 1545155172),
(65, 0, '项目', 0, 12054, '19031188839', '19017608617', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-X5h4aX8lAM\",\"org_id\":\"1\",\"key\":\"PROKEYPITYU\",\"lead\":\"10000\",\"description\":\"83VC11eTWJ\",\"type\":10,\"category\":0,\"url\":\"MULynVGQDs\",\"create_time\":1545155665,\"create_uid\":\"12054\",\"avatar\":\"\",\"detail\":\"6I23Efq2PX\",\"org_path\":\"default\"}', '{\"name\":\"PROName-X5h4aX8lAM\",\"org_id\":\"1\",\"key\":\"PROKEYPITYU\",\"lead\":\"10000\",\"description\":\"83VC11eTWJ\",\"type\":10,\"category\":0,\"url\":\"MULynVGQDs\",\"create_time\":1545155665,\"create_uid\":\"12054\",\"avatar\":\"\",\"detail\":\"6I23Efq2PX\",\"org_path\":\"default\"}', '127.0.0.1', 1545155675),
(66, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/addRoleUser', NULL, NULL, '新增', '添加项目角色的用户', '{\"user_id\":11674,\"project_id\":\"3\",\"role_id\":12}', '{\"user_id\":11674,\"project_id\":\"3\",\"role_id\":12}', '127.0.0.1', 1545185716),
(67, 3, '项目', 0, 10000, 'cdwei', 'Sven', '/project/role/update_perm', NULL, NULL, '编辑', '修改项目角色权限', '[]', '[]', '127.0.0.1', 1545185802),
(68, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"\\u6863\\u6848\",\"org_id\":\"1\",\"key\":\"RECORD\",\"lead\":\"1\",\"description\":\"\\u6863\\u6848\",\"type\":30,\"category\":0,\"url\":\"\",\"create_time\":1545188084,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '{\"name\":\"\\u6863\\u6848\",\"org_id\":\"1\",\"key\":\"RECORD\",\"lead\":\"1\",\"description\":\"\\u6863\\u6848\",\"type\":30,\"category\":0,\"url\":\"\",\"create_time\":1545188084,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '222.216.163.38', 1545188084),
(69, 431, '事项', 542, 1, 'master', 'Master', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u5f55\\u5165\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1545188223,\"updated\":1545188223,\"project_id\":431,\"issue_type\":1,\"status\":1,\"priority\":1,\"assignee\":1,\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":0,\"weight\":0}', '{\"summary\":\"\\u5f55\\u5165\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1545188223,\"updated\":1545188223,\"project_id\":431,\"issue_type\":1,\"status\":1,\"priority\":1,\"assignee\":1,\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":0,\"weight\":0}', '222.216.163.38', 1545188223),
(70, 0, '组织', 0, 1, 'master', 'Master', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"11\",\"name\":\"11\",\"description\":\"11\",\"scope\":\"1\",\"created\":1545198108,\"create_uid\":\"1\"}', '{\"path\":\"11\",\"name\":\"11\",\"description\":\"11\",\"scope\":\"1\",\"created\":1545198108,\"create_uid\":\"1\"}', '42.84.38.180', 1545198108),
(71, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"a\",\"org_id\":\"1\",\"key\":\"A\",\"lead\":\"1\",\"description\":\"a\",\"type\":60,\"category\":0,\"url\":\"\",\"create_time\":1545203393,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"a\",\"org_path\":\"default\"}', '{\"name\":\"a\",\"org_id\":\"1\",\"key\":\"A\",\"lead\":\"1\",\"description\":\"a\",\"type\":60,\"category\":0,\"url\":\"\",\"create_time\":1545203393,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"a\",\"org_path\":\"default\"}', '116.22.52.85', 1545203393),
(72, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"b\",\"org_id\":\"1\",\"key\":\"B\",\"lead\":\"1\",\"description\":\"b\",\"type\":30,\"category\":0,\"url\":\"\",\"create_time\":1545203718,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '{\"name\":\"b\",\"org_id\":\"1\",\"key\":\"B\",\"lead\":\"1\",\"description\":\"b\",\"type\":30,\"category\":0,\"url\":\"\",\"create_time\":1545203718,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\",\"org_path\":\"default\"}', '116.22.52.85', 1545203718);
INSERT INTO `log_operating` (`id`, `project_id`, `module`, `obj_id`, `uid`, `user_name`, `real_name`, `page`, `pre_status`, `cur_status`, `action`, `remark`, `pre_data`, `cur_data`, `ip`, `time`) VALUES
(73, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"\\u660e\\u5a9a\",\"org_id\":\"1\",\"key\":\"ASDF\",\"lead\":\"1\",\"description\":\"\\u660e\\u5a9a\",\"type\":10,\"category\":0,\"url\":\"\",\"create_time\":1545203858,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\\u660e\\u5a9a\",\"org_path\":\"default\"}', '{\"name\":\"\\u660e\\u5a9a\",\"org_id\":\"1\",\"key\":\"ASDF\",\"lead\":\"1\",\"description\":\"\\u660e\\u5a9a\",\"type\":10,\"category\":0,\"url\":\"\",\"create_time\":1545203858,\"create_uid\":\"1\",\"avatar\":\"\",\"detail\":\"\\u660e\\u5a9a\",\"org_path\":\"default\"}', '116.22.52.85', 1545203858),
(74, 1, '事项', 543, 1, 'master', 'Master', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"aa\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1545204203,\"updated\":1545204203,\"project_id\":1,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":1,\"weight\":0}', '{\"summary\":\"aa\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1545204203,\"updated\":1545204203,\"project_id\":1,\"issue_type\":1,\"status\":1,\"priority\":1,\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"start_date\":\"\",\"due_date\":\"\",\"sprint\":1,\"weight\":0}', '116.22.52.85', 1545204203),
(75, 1, '事项', 543, 1, 'master', 'Master', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"543\",\"pkey\":\"CRM\",\"issue_num\":\"CRM543\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"0\",\"summary\":\"aa\",\"description\":\"\\r\\n\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1545204203\",\"updated\":\"1545204203\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"543\",\"pkey\":\"CRM\",\"issue_num\":\"CRM543\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"0\",\"summary\":\"aa\",\"description\":\"\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1545204203\",\"updated\":\"1545204203\",\"start_date\":\"\",\"due_date\":\"\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '116.22.52.85', 1545204236),
(76, 1, '事项', 543, 1, 'master', 'Master', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"543\",\"pkey\":\"CRM\",\"issue_num\":\"CRM543\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"0\",\"summary\":\"aa\",\"description\":\"\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1545204203\",\"updated\":\"1545204203\",\"start_date\":\"0000-00-00\",\"due_date\":\"0000-00-00\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"11652\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"543\",\"pkey\":\"CRM\",\"issue_num\":\"CRM543\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":1,\"summary\":\"aa\",\"description\":\"\\u63cf\\u8ff0\\u5185\\u5bb9...\\r\\n\\r\\n## \\u91cd\\u65b0\\u6b65\\u9aa4\\r\\n1. \\u6b65\\u9aa41\\r\\n\\r\\n2. \\u6b65\\u9aa42\\r\\n\\r\\n3. \\u6b65\\u9aa43\\r\\n\\r\\n## \\u671f\\u671b\\u7ed3\\u679c \\r\\n\\r\\n\\r\\n## \\u5b9e\\u9645\\u7ed3\\u679c\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"1\",\"resolve\":\"0\",\"status\":\"1\",\"created\":\"1545204203\",\"updated\":\"1545204203\",\"start_date\":\"\",\"due_date\":\"\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"11652\",\"master_id\":\"0\",\"have_children\":\"0\"}', '116.22.52.85', 1545204300),
(77, 479, '事项', 613, 12089, '19046046976', '19014101119', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"12089\",\"reporter\":\"12089\",\"created\":1545207218,\"updated\":1545207218,\"project_id\":479,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":12089,\"module\":\"110\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"sprint\":138}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"12089\",\"reporter\":\"12089\",\"created\":1545207218,\"updated\":1545207218,\"project_id\":479,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":12089,\"module\":\"110\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"sprint\":138}', '127.0.0.1', 1545207220),
(78, 479, '事项', 613, 12089, '19046046976', '19014101119', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"613\",\"pkey\":\"TESTKEYEIDP271026327\",\"issue_num\":\"TESTKEYEIDP271026327613\",\"project_id\":\"479\",\"issue_type\":\"1\",\"creator\":\"12089\",\"modifier\":\"0\",\"reporter\":\"12089\",\"assignee\":\"12089\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545207218\",\"updated\":\"1545207218\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"resolve_date\":null,\"module\":\"110\",\"milestone\":null,\"sprint\":\"138\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"613\",\"pkey\":\"TESTKEYEIDP271026327\",\"issue_num\":\"TESTKEYEIDP271026327613\",\"project_id\":\"479\",\"issue_type\":\"1\",\"creator\":\"12089\",\"modifier\":\"12089\",\"reporter\":\"12089\",\"assignee\":\"12089\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545207218\",\"updated\":\"1545207218\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545207238),
(79, 0, '组织', 0, 12091, '19058245243', '19072935017', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-91488\",\"name\":\"test-path-91488\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545207336,\"create_uid\":\"12091\"}', '{\"path\":\"test-path-91488\",\"name\":\"test-path-91488\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545207336,\"create_uid\":\"12091\"}', '127.0.0.1', 1545207337),
(80, 0, '项目', 0, 12091, '19058245243', '19072935017', '/org/update/170', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"170\",\"path\":\"test-path-91488\",\"name\":\"test-path-91488\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"12091\",\"created\":\"1545207336\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545207340}', '127.0.0.1', 1545207340),
(81, 0, '组织', 0, 12091, '19058245243', '19072935017', '/org/delete/170', NULL, NULL, '删除', '删除组织', '{\"id\":\"170\",\"path\":\"test-path-91488\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"12091\",\"created\":\"1545207336\",\"updated\":\"1545207340\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545207344),
(82, 0, '用户', 12102, 12102, '19064315075', '19029828672', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"12102\",\"directory_id\":null,\"phone\":\"19029828672\",\"username\":\"19064315075\",\"openid\":\"f7895905aeb56f2dc318dbbb67496c19\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19029828672\",\"email\":\"19029828672@masterlab.org\",\"password\":\"$2y$10$KZpHc.4xW\\/MHxYKTzBzFz.EhvhGQE6kanLOEB0Zb8SpYL.35fTq6.\",\"sex\":\"0\",\"birthday\":\"2018-12-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/12102.png?t=1545207478\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545207459\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19029828672\",\"birthday\":\"2018-12-19\",\"avatar\":\"avatar\\/12102.png?t=1545207478\"}', '127.0.0.1', 1545207478),
(83, 0, '项目', 0, 12132, '19017066306', '19061251476', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-Lh236mMrGC\",\"org_id\":\"1\",\"key\":\"PROKEYZNMXT\",\"lead\":\"10000\",\"description\":\"6XptNcgfpo\",\"type\":10,\"category\":0,\"url\":\"JCEV6Uzouj\",\"create_time\":1545207980,\"create_uid\":\"12132\",\"avatar\":\"\",\"detail\":\"Ep1SaDfl4w\",\"org_path\":\"default\"}', '{\"name\":\"PROName-Lh236mMrGC\",\"org_id\":\"1\",\"key\":\"PROKEYZNMXT\",\"lead\":\"10000\",\"description\":\"6XptNcgfpo\",\"type\":10,\"category\":0,\"url\":\"JCEV6Uzouj\",\"create_time\":1545207980,\"create_uid\":\"12132\",\"avatar\":\"\",\"detail\":\"Ep1SaDfl4w\",\"org_path\":\"default\"}', '127.0.0.1', 1545207989),
(84, 564, '事项', 694, 12165, '19047554246', '19025843675', 'main', NULL, NULL, '新增', '新增事项', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"12165\",\"reporter\":\"12165\",\"created\":1545209691,\"updated\":1545209691,\"project_id\":564,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":12165,\"module\":\"126\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"sprint\":160}', '{\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"creator\":\"12165\",\"reporter\":\"12165\",\"created\":1545209691,\"updated\":1545209691,\"project_id\":564,\"issue_type\":1,\"status\":1,\"priority\":3,\"resolve\":10000,\"assignee\":12165,\"module\":\"126\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"sprint\":160}', '127.0.0.1', 1545209693),
(85, 564, '事项', 694, 12165, '19047554246', '19025843675', 'main', NULL, NULL, '编辑', '修改事项', '{\"id\":\"694\",\"pkey\":\"TESTKEYHPYK281558816\",\"issue_num\":\"TESTKEYHPYK281558816694\",\"project_id\":\"564\",\"issue_type\":\"1\",\"creator\":\"12165\",\"modifier\":\"0\",\"reporter\":\"12165\",\"assignee\":\"12165\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"10000\",\"status\":\"1\",\"created\":\"1545209691\",\"updated\":\"1545209691\",\"start_date\":\"2018-12-19\",\"due_date\":\"2018-12-26\",\"resolve_date\":null,\"module\":\"126\",\"milestone\":null,\"sprint\":\"160\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '{\"id\":\"694\",\"pkey\":\"TESTKEYHPYK281558816\",\"issue_num\":\"TESTKEYHPYK281558816694\",\"project_id\":\"564\",\"issue_type\":\"1\",\"creator\":\"12165\",\"modifier\":\"12165\",\"reporter\":\"12165\",\"assignee\":\"12165\",\"summary\":\"\\u6d4b\\u8bd5\\u4e8b\\u9879\",\"description\":null,\"environment\":\"\",\"priority\":2,\"resolve\":1,\"status\":6,\"created\":\"1545209691\",\"updated\":\"1545209691\",\"start_date\":\"2018-12-18\",\"due_date\":\"2018-12-25\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":0,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\"}', '127.0.0.1', 1545209711),
(86, 0, '组织', 0, 12167, '19014313314', '19070774734', '/org/add', NULL, NULL, '新增', '创建组织', '{\"path\":\"test-path-39041\",\"name\":\"test-path-39041\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545209809,\"create_uid\":\"12167\"}', '{\"path\":\"test-path-39041\",\"name\":\"test-path-39041\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"created\":1545209809,\"create_uid\":\"12167\"}', '127.0.0.1', 1545209810),
(87, 0, '项目', 0, 12167, '19014313314', '19070774734', '/org/update/201', NULL, NULL, '编辑', '修改组织信息', '{\"id\":\"201\",\"path\":\"test-path-39041\",\"name\":\"test-path-39041\",\"description\":\"test-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"12167\",\"created\":\"1545209809\",\"updated\":\"0\",\"scope\":\"1\"}', '{\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"updated\":1545209813}', '127.0.0.1', 1545209813),
(88, 0, '组织', 0, 12167, '19014313314', '19070774734', '/org/delete/201', NULL, NULL, '删除', '删除组织', '{\"id\":\"201\",\"path\":\"test-path-39041\",\"name\":\"updated-name\",\"description\":\"updated-description\",\"avatar\":\"unittest\\/sample.png\",\"create_uid\":\"12167\",\"created\":\"1545209809\",\"updated\":\"1545209813\",\"scope\":\"1\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"path\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"avatar\":\"\\u5df2\\u5220\\u9664\",\"create_uid\":\"\\u5df2\\u5220\\u9664\",\"created\":\"\\u5df2\\u5220\\u9664\",\"updated\":\"\\u5df2\\u5220\\u9664\",\"scope\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1545209816),
(89, 0, '用户', 12178, 12178, '19076576297', '19085523856', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"12178\",\"directory_id\":null,\"phone\":\"19085523856\",\"username\":\"19076576297\",\"openid\":\"7a751894c47d031ecd057e767c23f654\",\"status\":\"1\",\"first_name\":null,\"last_name\":null,\"display_name\":\"updated_19085523856\",\"email\":\"19085523856@masterlab.org\",\"password\":\"$2y$10$hluk7fIDTmgB0Pr\\/Arm.s.5N5iTEXcjMvFepGc8q5BoGHkzBhZ3E6\",\"sex\":\"0\",\"birthday\":\"2018-12-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/12178.png?t=1545209949\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":\"\",\"last_login_time\":\"1545209930\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":null,\"sign\":null}', '{\"display_name\":\"updated_19085523856\",\"birthday\":\"2018-12-19\",\"avatar\":\"avatar\\/12178.png?t=1545209949\"}', '127.0.0.1', 1545209949),
(90, 0, '项目', 0, 12208, '19083899976', '19039243801', '/project/main/create', NULL, NULL, '新增', '新建项目', '{\"name\":\"PROName-dekYf39tgu\",\"org_id\":\"1\",\"key\":\"PROKEYUZTKO\",\"lead\":\"10000\",\"description\":\"qxEIIKTN5b\",\"type\":10,\"category\":0,\"url\":\"df8oKkCF1l\",\"create_time\":1545210451,\"create_uid\":\"12208\",\"avatar\":\"\",\"detail\":\"jxXs79uLYC\",\"org_path\":\"default\"}', '{\"name\":\"PROName-dekYf39tgu\",\"org_id\":\"1\",\"key\":\"PROKEYUZTKO\",\"lead\":\"10000\",\"description\":\"qxEIIKTN5b\",\"type\":10,\"category\":0,\"url\":\"df8oKkCF1l\",\"create_time\":1545210451,\"create_uid\":\"12208\",\"avatar\":\"\",\"detail\":\"jxXs79uLYC\",\"org_path\":\"default\"}', '127.0.0.1', 1545210460);

-- --------------------------------------------------------

--
-- 表的结构 `log_runtime_error`
--

CREATE TABLE `log_runtime_error` (
  `id` int(10) UNSIGNED NOT NULL,
  `md5` varchar(32) NOT NULL,
  `file` varchar(255) NOT NULL,
  `line` smallint(6) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
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
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `action` varchar(32) DEFAULT NULL COMMENT '动作说明,如 关闭了，创建了，修复了',
  `type` enum('agile','user','issue','issue_comment','org','project') DEFAULT 'issue' COMMENT 'project,issue,user,agile,issue_comment',
  `obj_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_activity`
--

INSERT INTO `main_activity` (`id`, `user_id`, `project_id`, `action`, `type`, `obj_id`, `title`, `date`, `time`) VALUES
(2, 10000, 1, '创建了项目', 'project', 10002, '客户管理crm系统', '2018-08-25', 1535201403),
(3, 10000, 1, '创建了', 'issue', 2, '数据库表设计', '2018-09-13', 1535201403),
(4, 10000, 1, '创建了', 'issue', 1, '数据库设计', '2018-09-13', 1535201403),
(5, 10000, 1, '创建了事项', 'issue', 1, 'cfm测试', '2018-09-27', 1538018319),
(6, 10000, 1, '删除了事项', 'issue', 5, 'cfm测试', '2018-09-27', 1538018511),
(7, 10000, 1, '创建了事项', 'issue', 1, 'cfm测试', '2018-09-28', 1538097519),
(8, 10000, 1, '删除了事项', 'issue', 6, 'cfm测试', '2018-09-28', 1538097646),
(9, 10000, 1, '创建了事项', 'issue', 1, 'cfm测试', '2018-09-28', 1538097779),
(10, 10000, 1, '删除了事项', 'issue', 7, 'cfm测试', '2018-09-28', 1538101396),
(11, 10000, 1, '创建了事项', 'issue', 1, 'cfm测试123', '2018-09-28', 1538103661),
(12, 10000, 1, '更新了事项', 'issue', 8, 'cfm测试123', '2018-09-28', 1538105640),
(13, 10000, 1, '删除了事项', 'issue', 8, 'cfm测试123', '2018-09-28', 1538106580),
(14, 10000, 0, '更新了资料', 'org', 10000, '安娜', '2018-10-09', 1539076274),
(15, 10000, 3, '创建了项目', 'project', 3, 'Masterlab-Development', '2018-10-09', 1539089761),
(16, 10000, 3, '创建了事项', 'issue', 3, '事项类型方案的类型重复显示', '2018-10-09', 1539091562),
(17, 10000, 3, '创建了事项', 'issue', 3, '事项详情不能显示附件', '2018-10-09', 1539091678),
(18, 10000, 3, '更新了事项', 'issue', 10, '事项详情不能显示附件', '2018-10-09', 1539091939),
(19, 10000, 3, '更新了事项', 'issue', 9, '事项类型方案的类型重复显示', '2018-10-09', 1539092044),
(20, 10000, 3, '更新了事项', 'issue', 10, '事项详情不能显示附件', '2018-10-09', 1539092054),
(21, 10000, 3, '更新了事项', 'issue', 9, '事项类型方案的类型重复显示', '2018-10-09', 1539092063),
(22, 10000, 3, '创建了事项', 'issue', 3, '右下角的客服头像重新设计', '2018-10-09', 1539092238),
(23, 10000, 3, '更新了事项', 'issue', 11, '右下角的客服头像重新设计', '2018-10-09', 1539092256),
(24, 10000, 3, '创建了事项', 'issue', 3, '事项类型应该可以编辑', '2018-10-09', 1539092358),
(25, 10000, 3, '创建了事项', 'issue', 3, '新增事项时有时描述无法输入', '2018-10-09', 1539092463),
(26, 10000, 3, '更新了事项', 'issue', 13, '新增事项时有时描述无法输入', '2018-10-09', 1539092486),
(27, 10000, 3, '更新了事项', 'issue', 13, '新增事项时有时描述无法输入', '2018-10-09', 1539092499),
(28, 10000, 3, '更新了事项', 'issue', 12, '事项类型应该可以编辑', '2018-10-09', 1539092514),
(29, 10000, 3, '创建了事项', 'issue', 3, '用户资料无法编辑', '2018-10-09', 1539092931),
(30, 10000, 3, '更新了事项', 'issue', 14, '用户资料无法编辑', '2018-10-09', 1539092937),
(31, 10000, 3, '创建了事项', 'issue', 3, '左上角的项目列表跳转错误(组织的path不能显示)', '2018-10-09', 1539093321),
(32, 10000, 3, '更新了事项', 'issue', 13, '新增事项时有时描述无法输入', '2018-10-09', 1539093339),
(33, 10000, 3, '更新了事项', 'issue', 12, '事项类型应该可以编辑', '2018-10-09', 1539093363),
(34, 10000, 3, '更新了事项', 'issue', 10, '事项详情不能显示附件', '2018-10-09', 1539093378),
(35, 10000, 3, '更新了事项', 'issue', 15, '左上角的项目列表跳转错误(组织的path不能显示)', '2018-10-09', 1539096675),
(36, 10000, 3, '更新了事项', 'issue', 14, '用户资料无法编辑', '2018-10-09', 1539096684),
(37, 0, 3, '创建了事项', 'issue', 3, '项目摘要的右下角的客服头像点击无响应', '2018-10-10', 1539137311),
(38, 0, 3, '创建了事项', 'issue', 3, '项目摘要页面的右下角客服头像点击无效', '2018-10-10', 1539137375),
(39, 0, 3, '创建了事项', 'issue', 3, '项目摘要页面的右下角客服头像点击无效', '2018-10-10', 1539137381),
(40, 10000, 3, '创建了事项', 'issue', 3, '项目摘要页面的右下角客服头像点击无响应', '2018-10-10', 1539137684),
(41, 10000, 3, '更新了事项', 'issue', 19, '项目摘要页面的右下角客服头像点击无响应', '2018-10-10', 1539137706),
(42, 10000, 3, '更新了事项', 'issue', 19, '项目摘要页面的右下角客服头像点击无响应', '2018-10-10', 1539137719),
(43, 10000, 3, '删除了事项', 'issue', 18, '项目摘要页面的右下角客服头像点击无效', '2018-10-10', 1539140311),
(44, 10000, 3, '删除了事项', 'issue', 17, '项目摘要页面的右下角客服头像点击无效', '2018-10-10', 1539140316),
(45, 10000, 3, '更新了事项', 'issue', 19, '项目摘要页面的右下角客服头像点击无响应', '2018-10-10', 1539140323),
(46, 10000, 3, '创建了事项', 'issue', 3, '无迭代时应该显示图文并茂的提示', '2018-10-10', 1539140426),
(47, 10000, 3, '更新了事项', 'issue', 16, '项目摘要的右下角的客服头像点击无响应', '2018-10-10', 1539140449),
(48, 10000, 3, '创建了事项', 'issue', 3, '项目设置完善左侧信息提示', '2018-10-10', 1539140843),
(49, 10000, 3, '创建了事项', 'issue', 3, '项目设置-标签无数据时提示错误', '2018-10-10', 1539141321),
(50, 10000, 3, '创建了迭代', 'agile', 2, '第二次迭代', '2018-10-10', 1539141344),
(51, 10000, 3, '创建了事项', 'issue', 3, '无数据的插图需要重写设计', '2018-10-10', 1539144108),
(52, 10000, 3, '更新了事项', 'issue', 23, '无数据的插图需要重写设计', '2018-10-10', 1539144122),
(53, 10000, 3, '创建了事项', 'issue', 3, '增加weight 权重点数字段', '2018-10-11', 1539221701),
(54, 10000, 3, '创建了事项', 'issue', 3, '看板事项移动时要更新到服务器端', '2018-10-11', 1539221773),
(55, 10000, 3, '创建了事项', 'issue', 3, '待办事项列表要显示权重点数', '2018-10-11', 1539222559),
(56, 10000, 3, '创建了事项', 'issue', 3, '系统中的各种设置项的应用(时间 公告 UI)', '2018-10-11', 1539222644),
(57, 11654, 3, '更新了事项', 'issue', 19, '项目摘要页面的右下角客服头像点击无响应', '2018-10-11', 1539222890),
(58, 11654, 3, '更新了事项', 'issue', 16, '项目摘要的右下角的客服头像点击无响应', '2018-10-11', 1539222947),
(59, 10000, 3, '创建了事项', 'issue', 3, '各个功能模块添加操作日志', '2018-10-11', 1539223637),
(60, 10000, 3, '创建了事项', 'issue', 3, '快捷键在各个模块的应用', '2018-10-11', 1539225437),
(61, 10000, 3, '创建了事项', 'issue', 3, '使用帮助和在线提示', '2018-10-11', 1539226794),
(62, 10000, 3, '更新了事项', 'issue', 30, '使用帮助和在线提示', '2018-10-11', 1539241551),
(63, 11656, 3, '更新了事项', 'issue', 15, '左上角的项目列表跳转错误(组织的path不能显示)', '2018-10-11', 1539244177),
(64, 11656, 3, '更新了事项', 'issue', 22, '项目设置-标签无数据时提示错误', '2018-10-11', 1539245495),
(65, 11656, 3, '更新了事项', 'issue', 21, '项目设置完善左侧信息提示', '2018-10-11', 1539246732),
(66, 11654, 3, '更新了事项', 'issue', 10, '事项详情不能显示附件', '2018-10-11', 1539252708),
(67, 10000, 3, '更新了事项', 'issue', 23, '无数据的插图需要重写设计', '2018-10-12', 1539312822),
(68, 10000, 3, '更新了事项', 'issue', 14, '用户资料无法编辑', '2018-10-12', 1539330999),
(69, 10000, 3, '创建了事项', 'issue', 3, '事项编辑时，经办人不能正确显示', '2018-10-12', 1539332647),
(70, 10000, 3, '创建了事项', 'issue', 3, '事项详情的描述为乱码(markdown)', '2018-10-12', 1539332732),
(71, 10000, 3, '创建了事项', 'issue', 3, '事项详情的\"返回事项列表\"要返回项目的事项列表', '2018-10-13', 1539421427),
(72, 11656, 0, '更新了资料', 'org', 11656, '李建', '2018-10-13', 1539421568),
(73, 10000, 3, '创建了事项', 'issue', 3, '事项的表单要启用模板功能(该功能曾经实现过)', '2018-10-13', 1539421663),
(74, 11656, 3, '更新了事项', 'issue', 33, '事项详情的\"返回事项列表\"要返回项目的事项列表', '2018-10-13', 1539423512),
(75, 11656, 3, '更新了事项', 'issue', 33, '事项详情的\"返回事项列表\"要返回项目的事项列表', '2018-10-13', 1539423516),
(76, 11656, 3, '更新了事项', 'issue', 33, '事项详情的\"返回事项列表\"要返回项目的事项列表', '2018-10-13', 1539423520),
(77, 11656, 3, '更新了事项', 'issue', 33, '事项详情的\"返回事项列表\"要返回项目的事项列表', '2018-10-13', 1539423624),
(78, 10000, 3, '创建了事项', 'issue', 3, '检查浏览器是否支持', '2018-10-13', 1539424484),
(79, 11657, 3, '添加了事项评论', 'issue_comment', 28, '各个功能模块添加操作日志', '2018-10-15', 1539571200),
(80, 11657, 3, '添加了事项评论', 'issue_comment', 28, '各个功能模块添加操作日志', '2018-10-15', 1539571207),
(81, 11657, 3, '删除了事项评论', 'issue_comment', 22, '', '2018-10-15', 1539571211),
(82, 11654, 3, '更新了事项', 'issue', 32, '事项详情的描述为乱码(markdown)', '2018-10-15', 1539571395),
(83, 11656, 4, '创建了项目', 'project', 4, 'JUGGself', '2018-10-15', 1539571557),
(84, 11656, 4, '创建了事项', 'issue', 4, '768768768', '2018-10-15', 1539571742),
(85, 11656, 4, '删除了事项', 'issue', 36, '768768768', '2018-10-15', 1539573174),
(86, 11657, 3, '添加了事项评论', 'issue_comment', 28, '各个功能模块添加操作日志', '2018-10-15', 1539595779),
(87, 11654, 3, '更新了事项', 'issue', 13, '新增事项时有时描述无法输入', '2018-10-15', 1539597784),
(88, 10000, 3, '更新了事项', 'issue', 31, '事项编辑时，经办人不能正确显示', '2018-10-15', 1539598766),
(89, 10000, 3, '更新了事项', 'issue', 26, '待办事项列表要显示权重点数', '2018-10-15', 1539598781),
(90, 10000, 3, '更新了事项', 'issue', 31, '事项编辑时，经办人不能正确显示', '2018-10-15', 1539598925),
(91, 11654, 3, '更新了事项', 'issue', 32, '事项详情的描述为乱码(markdown)', '2018-10-15', 1539599519),
(92, 11654, 3, '更新了事项', 'issue', 34, '事项的表单要启用模板功能(该功能曾经实现过)', '2018-10-15', 1539600079),
(93, 10000, 3, '创建了事项', 'issue', 3, '事项的表单未能按照系统设置的 UI 进行排版', '2018-10-15', 1539600400),
(94, 10000, 3, '更新了迭代', 'agile', 2, '第二次迭代', '2018-10-15', 1539600412),
(95, 10000, 3, '创建了事项', 'issue', 3, '工作流编辑异常', '2018-10-15', 1539600504),
(96, 10000, 3, '更新了事项', 'issue', 25, '看板事项移动时要更新到服务器端', '2018-10-15', 1539600607),
(97, 10000, 3, '更新了事项', 'issue', 25, '看板事项移动时要更新到服务器端', '2018-10-15', 1539600609),
(98, 10000, 3, '更新了事项', 'issue', 24, '增加weight 权重点数字段', '2018-10-15', 1539600638),
(99, 10000, 3, '更新了事项', 'issue', 9, '事项类型方案的类型重复显示', '2018-10-15', 1539600662),
(100, 10000, 3, '创建了事项', 'issue', 3, '点击用户头像时，跳转到的用户资料页不正确', '2018-10-16', 1539659107),
(101, 11657, 3, '添加了事项评论', 'issue_comment', 28, '各个功能模块添加操作日志', '2018-10-16', 1539661250),
(102, 11657, 3, '添加了事项评论', 'issue_comment', 28, '各个功能模块添加操作日志', '2018-10-16', 1539661256),
(103, 10000, 3, '更新事项', 'issue', 38, ' 工作流编辑异常 状态:resolved', '2018-10-16', 1539675157),
(104, 10000, 3, '更新事项', 'issue', 31, ' 事项编辑时，经办人不能正确显示 状态:resolved', '2018-10-16', 1539675174),
(105, 10000, 3, '更新事项', 'issue', 14, ' 用户资料无法编辑 状态:resolved', '2018-10-16', 1539675204),
(106, 10000, 3, '更新了事项', 'issue', 39, '点击用户头像时，跳转到的用户资料页不正确', '2018-10-16', 1539675578),
(107, 10000, 3, '更新了迭代', 'agile', 2, '第二次迭代', '2018-10-16', 1539678087),
(108, 10000, 3, '创建了事项', 'issue', 3, '迭代列表的事项需要跳转道详情', '2018-10-16', 1539678315),
(109, 11655, 3, '更新了事项', 'issue', 35, '检查浏览器是否支持', '2018-10-17', 1539758240),
(110, 11655, 3, '更新了事项', 'issue', 29, '快捷键在各个模块的应用', '2018-10-17', 1539758256),
(111, 10000, 3, '添加了事项评论', 'issue_comment', 39, '点击用户头像时，跳转到的用户资料页不正确', '2018-10-17', 1539766355),
(112, 10000, 0, '更新了资料', 'org', 10000, '安娜', '2018-10-17', 1539766571),
(113, 10000, 0, '更新了资料', 'org', 10000, '安娜', '2018-10-17', 1539766606),
(114, 10000, 0, '更新了资料', 'org', 10000, '安娜', '2018-10-17', 1539766620),
(115, 11655, 0, '更新了资料', 'org', 11655, 'Mo', '2018-10-17', 1539770756),
(116, 10000, 3, '更新事项', 'issue', 40, ' 迭代列表的事项需要跳转道详情 状态:in_progress', '2018-10-17', 1539771333),
(117, 10000, 0, '更新了资料', 'org', 10000, '安娜', '2018-10-18', 1539826240),
(118, 10000, 0, '更新了资料', 'org', 10000, '安娜', '2018-10-18', 1539826289),
(119, 11657, 0, '更新了资料', 'org', 11657, '陈方铭', '2018-10-18', 1539830329),
(120, 10000, 3, '更新了事项', 'issue', 40, '迭代列表的事项需要跳转道详情', '2018-10-18', 1539831780),
(121, 11654, 3, '更新了事项', 'issue', 37, '事项的表单未能按照系统设置的 UI 进行排版', '2018-10-18', 1539845346),
(122, 11654, 0, '更新了资料', 'org', 11654, 'Jelly', '2018-10-18', 1539845533),
(123, 11655, 3, '更新了事项', 'issue', 29, '快捷键在各个模块的应用', '2018-10-18', 1539850559),
(124, 10000, 0, '更新了资料', 'org', 10000, 'Sven', '2018-10-20', 1540007504),
(125, 10000, 0, '更新了资料', 'org', 10000, 'Sven', '2018-10-20', 1540007509),
(126, 10000, 3, '更新了事项', 'issue', 39, '点击用户头像时，跳转到的用户资料页不正确', '2018-10-22', 1540140025),
(127, 10000, 3, '更新事项', 'issue', 37, ' 事项的表单未能按照系统设置的 UI 进行排版 状态:in_progress', '2018-10-22', 1540201207),
(128, 10000, 3, '更新了事项', 'issue', 23, '无数据的插图需要重写设计', '2018-10-22', 1540201380),
(129, 10000, 3, '更新了事项', 'issue', 40, '迭代列表的事项需要跳转道详情', '2018-10-22', 1540223896),
(130, 10000, 3, '创建了事项', 'issue', 3, '事项详情的时间显示异常', '2018-10-23', 1540224010),
(131, 10000, 3, '创建了事项', 'issue', 3, '事情列表需要排序功能', '2018-10-23', 1540224363),
(132, 10000, 3, '创建了事项', 'issue', 3, '多次点击事项列表的“创建”按钮时选项卡重复出现', '2018-10-23', 1540225471),
(133, 10000, 3, '创建了事项', 'issue', 3, '事项详情-可以上车图片', '2018-10-23', 1540226138),
(134, 10000, 3, '创建了事项', 'issue', 3, '客服头像的帮助内容需要更新', '2018-10-23', 1540226308),
(135, 11657, 3, '更新了事项', 'issue', 30, '使用帮助和在线提示', '2018-10-23', 1540260872),
(136, 11655, 3, '更新了事项', 'issue', 45, '客服头像的帮助内容需要更新', '2018-10-23', 1540261340),
(137, 10000, 3, '更新了事项', 'issue', 44, '事项详情-可以上车图片', '2018-10-23', 1540287832),
(138, 10000, 3, '更新了事项', 'issue', 41, '事项详情的时间显示异常', '2018-10-23', 1540288131),
(139, 10000, 3, '创建了事项', 'issue', 3, '用户资料页实现操作记录功能(参考jira的个人操作记录)', '2018-10-24', 1540316851),
(140, 10000, 3, '创建了事项', 'issue', 3, '实现编辑时，修改事项类型无效', '2018-10-24', 1540316976),
(141, 10000, 3, '创建了事项', 'issue', 3, '实现实现列表的批量处理功能', '2018-10-24', 1540317394),
(142, 10000, 3, '更新了事项', 'issue', 20, '无迭代时应该显示图文并茂的提示', '2018-10-24', 1540317880),
(143, 10000, 3, '更新了事项', 'issue', 44, '事项详情-可以上传图片', '2018-10-24', 1540317895),
(144, 10000, 3, '更新了事项', 'issue', 11, '右下角的客服头像重新设计', '2018-10-24', 1540317914),
(145, 10000, 3, '更新了事项', 'issue', 23, '无数据的插图需要重写设计', '2018-10-24', 1540317937),
(146, 10000, 3, '更新了事项', 'issue', 11, '右下角的客服头像重新设计', '2018-10-24', 1540317990),
(147, 10000, 3, '更新了事项', 'issue', 23, '无数据的插图需要重写设计', '2018-10-24', 1540318076),
(148, 10000, 3, '创建了事项', 'issue', 3, '事项表单的标签颜色显示异常', '2018-10-25', 1540397352),
(149, 10000, 3, '创建了事项', 'issue', 3, '项目介绍页的内容不能显示markdown的内容', '2018-10-25', 1540397508),
(150, 10000, 3, '创建了事项', 'issue', 3, '事项编辑时，修改协助人无效', '2018-10-25', 1540397910),
(151, 11656, 3, '更新了事项', 'issue', 15, '左上角的项目列表跳转错误(组织的path不能显示)', '2018-10-25', 1540433723),
(152, 11656, 3, '更新了事项', 'issue', 21, '项目设置完善左侧信息提示', '2018-10-25', 1540435992),
(153, 11656, 3, '更新了事项', 'issue', 22, '项目设置-标签无数据时提示错误', '2018-10-25', 1540436008),
(154, 11656, 3, '更新了事项', 'issue', 33, '事项详情的\"返回事项列表\"要返回项目的事项列表', '2018-10-25', 1540436038),
(155, 11656, 3, '更新了事项', 'issue', 27, '系统中的各种设置项的应用(时间 公告 UI)', '2018-10-25', 1540436045),
(156, 10000, 3, '创建了事项', 'issue', 3, '首页项目列表图标显示异常', '2018-10-25', 1540438082),
(157, 11654, 3, '更新了事项', 'issue', 10, '事项详情不能显示附件', '2018-10-25', 1540450633),
(158, 11654, 3, '更新了事项', 'issue', 13, '新增事项时有时描述无法输入', '2018-10-25', 1540450684),
(159, 11654, 3, '更新了事项', 'issue', 16, '项目摘要的右下角的客服头像点击无响应', '2018-10-25', 1540450696),
(160, 11654, 3, '更新了事项', 'issue', 19, '项目摘要页面的右下角客服头像点击无响应', '2018-10-25', 1540450706),
(161, 11654, 3, '更新了事项', 'issue', 32, '事项详情的描述为乱码(markdown)', '2018-10-25', 1540450718),
(162, 11654, 3, '更新了事项', 'issue', 34, '事项的表单要启用模板功能(该功能曾经实现过)', '2018-10-25', 1540450728),
(163, 11654, 3, '更新了事项', 'issue', 43, '多次点击事项列表的“创建”按钮时选项卡重复出现', '2018-10-25', 1540450759),
(164, 11654, 3, '更新了事项', 'issue', 37, '事项的表单未能按照系统设置的 UI 进行排版', '2018-10-25', 1540450791),
(165, 11654, 3, '更新了事项', 'issue', 49, '事项表单的标签颜色显示异常', '2018-10-25', 1540450933),
(166, 10000, 3, '更新事项', 'issue', 50, ' 项目介绍页的内容不能显示markdown的内容 状态:in_progress', '2018-10-25', 1540451822),
(167, 11654, 3, '更新了事项', 'issue', 49, '事项表单的标签颜色显示异常', '2018-10-25', 1540453474),
(168, 11654, 3, '更新了事项', 'issue', 52, '首页项目列表图标显示异常', '2018-10-25', 1540453824),
(169, 11654, 3, '添加了事项评论', 'issue_comment', 52, '首页项目列表图标显示异常', '2018-10-25', 1540454400),
(170, 11654, 3, '更新了事项', 'issue', 20, '无迭代时应该显示图文并茂的提示', '2018-10-25', 1540454922),
(171, 11654, 3, '更新了事项', 'issue', 52, '首页项目列表图标显示异常', '2018-10-25', 1540455762),
(172, 10000, 3, '更新了事项', 'issue', 42, '事情列表需要排序功能', '2018-10-26', 1540533768),
(173, 10000, 3, '更新了事项', 'issue', 48, '实现实现列表的批量处理功能', '2018-10-26', 1540533893),
(174, 10000, 3, '更新了事项', 'issue', 45, '客服头像的帮助内容需要更新', '2018-10-26', 1540533929),
(175, 10000, 3, '更新了事项', 'issue', 20, '无迭代时应该显示图文并茂的提示', '2018-10-26', 1540533960),
(176, 10000, 3, '创建了事项', 'issue', 3, '将无数据时的提示修改为图文并茂的方式', '2018-10-26', 1540534870),
(177, 10000, 3, '更新了事项', 'issue', 53, '将无数据时的提示修改为图文并茂的方式', '2018-10-26', 1540534910),
(178, 11654, 3, '更新了事项', 'issue', 53, '将无数据时的提示修改为图文并茂的方式', '2018-10-26', 1540543620),
(179, 11654, 3, '更新了事项', 'issue', 53, '将无数据时的提示修改为图文并茂的方式', '2018-10-26', 1540549605),
(180, 10000, 3, '创建了事项', 'issue', 3, '创建事项的表单 tab 页重复', '2018-10-27', 1540573865),
(181, 10000, 3, '更新了事项', 'issue', 53, '将无数据时的提示修改为图文并茂的方式', '2018-10-27', 1540573902),
(182, 11654, 3, '更新了事项', 'issue', 20, '无迭代时应该显示图文并茂的提示', '2018-10-27', 1540624255),
(183, 11655, 3, '创建了事项', 'issue', 3, '导航菜单问题', '2018-10-27', 1540624468),
(184, 11654, 3, '更新了事项', 'issue', 54, '创建事项的表单 tab 页重复', '2018-10-27', 1540627910),
(185, 11656, 3, '更新了事项', 'issue', 50, '项目介绍页的内容不能显示markdown的内容', '2018-10-27', 1540636645),
(186, 11656, 3, '更新了事项', 'issue', 46, '用户资料页实现操作记录功能(参考jira的个人操作记录)', '2018-10-27', 1540636695),
(187, 11656, 3, '更新了事项', 'issue', 46, '用户资料页实现操作记录功能(参考jira的个人操作记录)', '2018-10-27', 1540636706),
(188, 11656, 3, '更新了事项', 'issue', 46, '用户资料页实现操作记录功能(参考jira的个人操作记录)', '2018-10-27', 1540636738),
(189, 11656, 3, '更新了事项', 'issue', 41, '事项详情的时间显示异常', '2018-10-27', 1540640799),
(190, 10000, 3, '创建了事项', 'issue', 3, '首页当动态数据为空时 使用通用的空图显示', '2018-10-27', 1540641158),
(191, 10000, 3, '更新了事项', 'issue', 55, '导航菜单问题', '2018-10-28', 1540660562),
(192, 10000, 3, '更新了事项', 'issue', 48, '实现实现列表的批量处理功能', '2018-10-28', 1540660575),
(193, 10000, 3, '更新了事项', 'issue', 23, '无数据的插图需要重写设计', '2018-10-28', 1540660597),
(194, 10000, 3, '更新了事项', 'issue', 11, '右下角的客服头像重新设计', '2018-10-28', 1540660615),
(195, 10000, 3, '创建了事项', 'issue', 3, '自己一个\"未解决\"的系统过滤器', '2018-10-28', 1540663864),
(196, 10000, 3, '更新了迭代', 'agile', 2, '第二次迭代', '2018-10-28', 1540663899),
(197, 10000, 3, '更新了事项', 'issue', 57, '自己一个\"未解决\"的系统过滤器', '2018-10-28', 1540664032),
(198, 10000, 3, '更新了事项', 'issue', 57, '增加一个未解决的过滤器', '2018-10-29', 1540750627),
(199, 10000, 3, '更新了事项', 'issue', 47, '实现编辑时，修改事项类型无效', '2018-10-29', 1540751575),
(200, 10000, 3, '更新了事项', 'issue', 51, '事项编辑时，修改协助人无效', '2018-10-29', 1540753347),
(201, 10000, 3, '创建了事项', 'issue', 3, '去掉自动登录的账号', '2018-10-29', 1540754430),
(202, 10000, 3, '创建了事项', 'issue', 3, '迭代应该可以选择空', '2018-10-29', 1540754458),
(203, 10000, 3, '创建了事项', 'issue', 3, '登录页面的文字需要修饰修改', '2018-10-29', 1540754499),
(204, 10000, 3, '创建了事项', 'issue', 3, '增加websocket同步修改的配置数据', '2018-10-29', 1540754614),
(205, 10000, 3, '创建了事项', 'issue', 3, '增加缓存处理', '2018-10-29', 1540754638),
(206, 10000, 3, '创建了事项', 'issue', 3, '优化动态描述信息', '2018-10-29', 1540754710),
(207, 10000, 3, '创建了事项', 'issue', 3, 'PHP的设计模式优化', '2018-10-29', 1540754764),
(208, 11654, 3, '更新了事项', 'issue', 56, '首页当动态数据为空时 使用通用的空图显示', '2018-10-29', 1540797135),
(209, 11654, 3, '更新了事项', 'issue', 56, '首页当动态数据为空时 使用通用的空图显示', '2018-10-29', 1540799006),
(210, 10000, 3, '创建了事项', 'issue', 3, '更换个人设置页的图片', '2018-10-29', 1540802453),
(211, 10000, 3, '创建了迭代', 'agile', 3, '第三次迭代', '2018-10-29', 1540805049),
(212, 10000, 3, '更新事项', 'issue', 12, ' 事项类型应该可以编辑 状态:resolved', '2018-10-29', 1540805216),
(213, 10000, 3, '更新了事项', 'issue', 30, '使用帮助和在线提示', '2018-10-29', 1540805263),
(214, 10000, 3, '更新了事项', 'issue', 30, 'Id:65,64,63,62,61,60,58,45,30', '2018-10-29', 1540805464),
(215, 10000, 0, '更新了资料', 'org', 10000, 'Sven', '2018-10-30', 1540833289),
(216, 10000, 0, '更新了资料', 'org', 10000, 'Sven', '2018-10-30', 1540833292),
(217, 10000, 0, '更新了资料', 'org', 10000, 'Sven', '2018-10-30', 1540833319),
(218, 10000, 3, '创建了事项', 'issue', 3, '事项详情页面的左上角 项目显示错误', '2018-10-30', 1540833978),
(219, 10000, 3, '更新事项', 'issue', 54, ' 创建事项的表单 tab 页重复 状态:in_progress', '2018-10-30', 1540834058),
(220, 10000, 3, '更新事项', 'issue', 55, ' 导航菜单问题 状态:in_progress', '2018-10-30', 1540834060),
(221, 10000, 3, '更新事项', 'issue', 52, ' 首页项目列表图标显示异常 状态:in_progress', '2018-10-30', 1540834062),
(222, 10000, 3, '更新事项', 'issue', 49, ' 事项表单的标签颜色显示异常 状态:open', '2018-10-30', 1540834064),
(223, 10000, 3, '更新事项', 'issue', 47, ' 实现编辑时，修改事项类型无效 状态:open', '2018-10-30', 1540834066),
(224, 10000, 3, '更新事项', 'issue', 48, ' 实现实现列表的批量处理功能 状态:in_progress', '2018-10-30', 1540834069),
(225, 10000, 3, '更新事项', 'issue', 48, ' 实现实现列表的批量处理功能 状态:resolved', '2018-10-30', 1540836655),
(226, 10000, 3, '更新事项', 'issue', 52, ' 首页项目列表图标显示异常 状态:resolved', '2018-10-30', 1540836657),
(227, 10000, 3, '更新事项', 'issue', 54, ' 创建事项的表单 tab 页重复 状态:resolved', '2018-10-30', 1540836661),
(228, 10000, 3, '更新事项', 'issue', 49, ' 事项表单的标签颜色显示异常 状态:resolved', '2018-10-30', 1540836665),
(229, 10000, 3, '更新事项', 'issue', 47, ' 实现编辑时，修改事项类型无效 状态:resolved', '2018-10-30', 1540836667),
(230, 10000, 3, '更新事项', 'issue', 28, ' 各个功能模块添加操作日志 状态:in_progress', '2018-10-30', 1540836673),
(231, 10000, 3, '创建了事项', 'issue', 3, '在迭代和看板页面可以创建事项', '2018-10-31', 1540957298),
(232, 10000, 3, '创建了事项', 'issue', 3, '在创建事项的表单中,当变更事项类型时，原先填写的数据要保留', '2018-10-31', 1540958040),
(233, 10000, 3, '创建了事项', 'issue', 3, '创建或编辑事项表单的版本和模块下拉时点击错误', '2018-10-31', 1540958318),
(234, 10000, 3, '创建了事项', 'issue', 3, '在wiki上编写使用指南', '2018-10-31', 1540969482),
(235, 10000, 3, '更新了事项', 'issue', 70, '在wiki上编写使用指南', '2018-10-31', 1540969517),
(236, 10000, 3, '创建了事项', 'issue', 3, '在wiki上编写Linux下的Nginx，Mysql5.7，Php7.2，Redis的运行环境', '2018-10-31', 1540970938),
(237, 10000, 3, '创建了事项', 'issue', 3, '创建Masterlab docker及安装文档', '2018-10-31', 1540971351),
(238, 10000, 3, '更新了事项', 'issue', 67, 'Id:72,71,70,69,68,67', '2018-10-31', 1540971431),
(239, 10000, 3, '创建了事项', 'issue', 3, '更新官方网站的内容', '2018-10-31', 1540971562),
(240, 10000, 3, '更新了事项', 'issue', 73, '更新官方网站的内容', '2018-10-31', 1540971574),
(241, 10000, 3, '更新了迭代', 'agile', 3, '第三次迭代', '2018-10-31', 1540971711),
(242, 10000, 3, '更新了事项', 'issue', 55, '导航菜单问题', '2018-10-31', 1540971761),
(243, 10000, 3, '更新了事项', 'issue', 28, 'Id:62,61,60,59,58,45,30,28', '2018-10-31', 1540971792),
(244, 10000, 3, '创建了事项', 'issue', 3, '事项列表搜索-增加迭代项', '2018-10-31', 1540972012),
(245, 10000, 3, '创建了事项', 'issue', 3, '项目类型进行精简', '2018-10-31', 1540972695),
(246, 10000, 3, '更新了事项', 'issue', 75, '项目类型进行精简', '2018-10-31', 1540972706),
(247, 10000, 3, '更新了事项', 'issue', 63, '优化动态描述信息', '2018-10-31', 1540973437),
(248, 10000, 3, '创建了事项', 'issue', 3, '迭代和待办事项页面要显示事项的状态，标签，更新时间，经办人', '2018-10-31', 1540973678),
(249, 10000, 3, '创建了事项', 'issue', 3, '看板页面需要增加可编辑和新增事项的功能', '2018-10-31', 1540973714),
(250, 10000, 3, '创建了事项', 'issue', 3, '项目统计页面需要增加专门针对当前迭代的统计', '2018-10-31', 1540973749),
(251, 10000, 3, '更新了事项', 'issue', 78, '项目统计页面需要增加专门针对当前迭代的统计', '2018-10-31', 1540973761),
(252, 10000, 3, '更新了事项', 'issue', 77, '看板页面需要增加可编辑和新增事项的功能', '2018-10-31', 1540973771),
(253, 10000, 3, '更新了迭代', 'agile', 3, '第三次迭代', '2018-10-31', 1540973818),
(254, 10000, 3, '创建了事项', 'issue', 3, '迭代页面，需要高亮显示当前迭代', '2018-10-31', 1540973900),
(255, 10000, 3, '更新了事项', 'issue', 79, '迭代页面，需要高亮显示当前迭代', '2018-10-31', 1540973907),
(256, 10000, 3, '创建了事项', 'issue', 3, '项目图表的‘ 解决与未解决事项对比报告’为空', '2018-10-31', 1540973995),
(257, 10000, 3, '创建了事项', 'issue', 3, '官方网站的图片需要重写设计', '2018-10-31', 1540974064),
(258, 10000, 3, '更新了事项', 'issue', 81, '官方网站的图片需要重写设计', '2018-10-31', 1540974074),
(259, 10000, 3, '更新了事项', 'issue', 74, 'Id:81,80,79,78,77,76,75,74', '2018-10-31', 1540974090),
(260, 10000, 3, '创建了事项', 'issue', 3, '迭代列表的事项可以点击，然后右侧浮动出事项详情', '2018-10-31', 1540974142),
(261, 10000, 3, '创建了事项', 'issue', 3, '实现事项查询的自定义过滤器', '2018-10-31', 1540974180),
(262, 10000, 3, '更新了事项', 'issue', 80, '项目图表的‘ 解决与未解决事项对比报告’为空', '2018-10-31', 1540974192),
(263, 10000, 3, '创建了事项', 'issue', 3, '事项列表和待办事项及迭代页面增加总数', '2018-10-31', 1540976592),
(264, 10000, 3, '更新了事项', 'issue', 71, '在wiki上编写Linux下的Nginx，Mysql5.7，Php7.2，Redis的运行环境', '2018-10-31', 1540982262),
(265, 10000, 3, '删除了事项', 'issue', 61, '增加websocket同步修改的配置数据', '2018-10-31', 1540983658),
(266, 10000, 3, '删除了事项', 'issue', 45, '客服头像的帮助内容需要更新', '2018-10-31', 1540983805),
(267, 10000, 3, '更新了事项', 'issue', 59, '迭代应该可以选择空', '2018-10-31', 1540983817),
(268, 10000, 3, '删除了事项', 'issue', 30, '使用帮助和在线提示', '2018-10-31', 1540983852),
(269, 10000, 3, '创建了事项', 'issue', 3, '启用Mysql5.7以上版本的全文索引', '2018-10-31', 1541000974),
(270, 10000, 3, '更新了事项', 'issue', 84, '事项列表和待办事项及迭代页面增加总数', '2018-10-31', 1541001274),
(271, 10000, 3, '更新了事项', 'issue', 85, '启用Mysql5.7以上版本的全文索引', '2018-10-31', 1541001292),
(272, 10000, 3, '创建了事项', 'issue', 3, '优化事项类型的表单', '2018-10-31', 1541001338),
(273, 10000, 3, '更新了事项', 'issue', 86, '优化事项类型的表单', '2018-10-31', 1541001416),
(274, 10000, 3, '创建了事项', 'issue', 3, '点击事项列表的用户头像后调整的个人资料页错误', '2018-11-01', 1541004095),
(275, 10000, 3, '更新了事项', 'issue', 74, '事项列表搜索-增加迭代项', '2018-11-01', 1541004182),
(276, 10000, 3, '更新了事项', 'issue', 78, '项目统计页面需要增加专门针对当前迭代的统计', '2018-11-01', 1541004347),
(277, 10000, 3, '更新了事项', 'issue', 77, '看板页面需要增加可编辑和新增事项的功能', '2018-11-01', 1541004360),
(278, 10000, 3, '更新了事项', 'issue', 76, '迭代和待办事项页面要显示事项的状态，标签，更新时间，经办人', '2018-11-01', 1541004467),
(279, 11655, 3, '更新了事项', 'issue', 65, '更换个人设置页的图片', '2018-11-01', 1541037125),
(280, 10000, 3, '更新了事项', 'issue', 87, '点击事项列表的用户头像后调整的个人资料页错误', '2018-11-01', 1541041307),
(281, 11655, 3, '更新了事项', 'issue', 76, '迭代和待办事项页面要显示事项的状态，标签，经办人', '2018-11-01', 1541041643),
(282, 11655, 3, '更新了事项', 'issue', 76, '迭代和待办事项页面要显示事项的状态，标签，经办人', '2018-11-01', 1541043900),
(283, 11655, 3, '更新了事项', 'issue', 79, '迭代页面，需要高亮显示当前迭代', '2018-11-01', 1541044225),
(284, 11657, 3, '添加了事项评论', 'issue_comment', 63, '用户动态功能需要优化', '2018-11-01', 1541044567),
(285, 11657, 3, '添加了事项评论', 'issue_comment', 63, '用户动态功能需要优化', '2018-11-01', 1541044998),
(286, 11657, 3, '添加了事项评论', 'issue_comment', 63, '用户动态功能需要优化', '2018-11-01', 1541059472),
(287, 11657, 3, '添加了事项评论', 'issue_comment', 63, '用户动态功能需要优化', '2018-11-01', 1541067265),
(288, 11654, 3, '更新了事项', 'issue', 82, '迭代列表的事项可以点击，然后右侧浮动出事项详情', '2018-11-02', 1541127746),
(289, 11654, 3, '添加了事项评论', 'issue_comment', 59, '迭代应该可以选择空', '2018-11-02', 1541128103),
(290, 11656, 3, '更新了事项', 'issue', 75, '项目类型进行精简', '2018-11-02', 1541129741),
(291, 11656, 3, '更新了事项', 'issue', 75, '项目类型进行精简', '2018-11-02', 1541129768),
(292, 11656, 3, '更新了事项', 'issue', 71, '在wiki上编写‘Linux下的Nginx，Mysql5.7，Php7.2，Redis的运行环境的’文档', '2018-11-02', 1541129798),
(293, 11656, 3, '更新了事项', 'issue', 75, '项目类型进行精简', '2018-11-02', 1541129846),
(294, 11656, 3, '更新了事项', 'issue', 66, '事项详情页面的左上角 项目显示错误', '2018-11-02', 1541131943),
(295, 11654, 3, '更新了事项', 'issue', 67, '在迭代和看板页面可以创建事项', '2018-11-02', 1541150462),
(296, 10000, 3, '更新了事项', 'issue', 76, '迭代和待办事项页面要显示事项的状态，标签，经办人', '2018-11-03', 1541175646),
(297, 10000, 3, '更新了事项', 'issue', 58, '去掉自动登录的账号', '2018-11-03', 1541175903),
(298, 10000, 3, '更新了事项', 'issue', 60, '登录页面的文字需要修饰修改', '2018-11-03', 1541176072),
(299, 10000, 3, '更新了事项', 'issue', 76, '迭代和待办事项页面要显示事项的状态，解决结果，经办人', '2018-11-03', 1541178901),
(300, 10000, 3, '更新了事项', 'issue', 84, '事项列表和待办事项及迭代页面增加总数', '2018-11-03', 1541178936),
(301, 10000, 3, '更新了事项', 'issue', 87, '点击事项列表的用户头像后跳转的个人资料页错误', '2018-11-03', 1541179793),
(302, 10000, 3, '更新了事项', 'issue', 73, '更新官方网站的内容', '2018-11-05', 1541350600),
(303, 10000, 3, '更新了事项', 'issue', 83, '实现事项查询的自定义过滤器', '2018-11-05', 1541350623),
(304, 10000, 3, '创建了事项', 'issue', 3, '看板查询功能失效', '2018-11-05', 1541350759),
(305, 11655, 3, '更新了事项', 'issue', 77, '看板页面需要增加可编辑和新增事项的功能', '2018-11-05', 1541384012),
(306, 11657, 3, '添加了事项评论', 'issue_comment', 63, '用户动态功能需要优化', '2018-11-05', 1541388619),
(307, 11657, 3, '添加了事项评论', 'issue_comment', 70, '在wiki上编写使用指南', '2018-11-05', 1541389729),
(308, 11657, 3, '添加了事项评论', 'issue_comment', 70, '在wiki上编写使用指南', '2018-11-05', 1541410549),
(309, 11657, 3, '添加了事项评论', 'issue_comment', 70, '在wiki上编写使用指南', '2018-11-05', 1541416025),
(310, 10000, 3, '更新了事项', 'issue', 78, '项目统计页面需要增加专门针对当前迭代的统计', '2018-11-06', 1541438797),
(311, 11656, 3, '更新了事项', 'issue', 71, '在wiki上编写‘Linux下的Nginx，Mysql5.7，Php7.2，Redis的运行环境的’文档', '2018-11-06', 1541478096),
(312, 10000, 3, '更新了事项', 'issue', 88, '看板查询功能失效', '2018-11-06', 1541484802),
(313, 11657, 3, '添加了事项评论', 'issue_comment', 63, '用户动态功能需要优化', '2018-11-06', 1541487964),
(314, 11657, 3, '更新了事项', 'issue', 63, '用户动态功能需要优化', '2018-11-06', 1541487971),
(315, 11657, 3, '更新了事项', 'issue', 28, '各个功能模块添加操作日志', '2018-11-06', 1541488006),
(316, 11658, 3, '创建了事项', 'issue', 3, '注册新用户无法登录', '2018-11-06', 1541490486),
(317, 10000, 3, '创建了事项', 'issue', 3, '当鼠标移动到事项列表上面时，高亮显示表格的行', '2018-11-06', 1541492362),
(318, 10000, 3, '更新了事项', 'issue', 86, '优化事项类型的表单配置', '2018-11-06', 1541493212),
(319, 10000, 3, '更新了事项', 'issue', 83, '实现事项查询的自定义过滤器', '2018-11-06', 1541493221),
(320, 11657, 3, '添加了事项评论', 'issue_comment', 70, '在wiki上编写使用指南', '2018-11-06', 1541495137),
(321, 10000, 3, '更新了事项', 'issue', 89, '注册新用户无法登录', '2018-11-06', 1541513622),
(322, 10000, 3, '更新了事项', 'issue', 78, '项目统计页面需要增加专门针对当前迭代的统计', '2018-11-06', 1541513630),
(323, 10000, 3, '更新了事项', 'issue', 85, '启用Mysql5.7以上版本的全文索引', '2018-11-06', 1541517551),
(324, 10000, 3, '更新了事项', 'issue', 80, '项目图表的‘ 解决与未解决事项对比报告’为空', '2018-11-06', 1541517839),
(325, 10000, 3, '更新了事项', 'issue', 81, '官方网站的图片需要重写设计', '2018-11-06', 1541518321),
(326, 10000, 3, '创建了事项', 'issue', 3, '看板的事项不能编辑，点击无效', '2018-11-07', 1541573244),
(327, 11656, 3, '更新了事项', 'issue', 72, '创建Masterlab docker及安装文档', '2018-11-07', 1541574285),
(328, 11656, 3, '更新了事项', 'issue', 64, 'PHP的设计模式优化', '2018-11-07', 1541574305),
(329, 10000, 3, '创建了事项', 'issue', 3, '事项表单的 迭代 字段默认值要修改', '2018-11-07', 1541574516),
(330, 10000, 3, '创建了事项', 'issue', 3, '美观官方网站的关于我们', '2018-11-07', 1541575069),
(331, 10000, 3, '更新了事项', 'issue', 93, '美观官方网站的关于我们', '2018-11-07', 1541575128),
(332, 10000, 3, '删除了事项', 'issue', 91, '看板的事项不能编辑，点击无效', '2018-11-07', 1541577141),
(333, 10000, 3, '更新了事项', 'issue', 90, '当鼠标移动到事项列表上面时，高亮显示表格的行', '2018-11-07', 1541577266),
(334, 11655, 3, '更新了事项', 'issue', 93, '美观官方网站的关于我们', '2018-11-07', 1541581722),
(335, 11655, 3, '更新了事项', 'issue', 90, '当鼠标移动到事项列表上面时，高亮显示表格的行', '2018-11-07', 1541585603),
(336, 11654, 3, '更新了事项', 'issue', 68, '在创建事项的表单中,当变更事项类型时，原先填写的数据要保留', '2018-11-07', 1541587566),
(337, 11654, 3, '更新了事项', 'issue', 92, '事项表单的 迭代 字段默认值要修改', '2018-11-07', 1541588037),
(338, 11654, 3, '更新了事项', 'issue', 59, '迭代应该可以选择空', '2018-11-07', 1541588050),
(339, 11654, 3, '修改事项状态为 已解决', 'issue', 69, '创建或编辑事项表单的版本和模块下拉时点击错误', '2018-11-08', 1541670581),
(340, 10000, 3, '创建了事项', 'issue', 3, '登录页面增加快捷键', '2018-11-09', 1541728375),
(341, 10000, 3, '修改事项状态为 已解决', 'issue', 94, '登录页面增加快捷键', '2018-11-09', 1541728390),
(342, 11657, 3, '修改事项状态为 已解决', 'issue', 70, '在wiki上编写使用指南', '2018-11-09', 1541733054),
(343, 11657, 3, '修改事项解决结果为 已修复', 'issue', 70, '在wiki上编写使用指南', '2018-11-09', 1541733057),
(344, 11657, 3, '修改事项状态为 已解决', 'issue', 63, '用户动态功能需要优化', '2018-11-09', 1541733115),
(345, 11656, NULL, '为添加了一个附件', 'issue', NULL, 'debugissuedetail.png', '2018-11-09', 1541747711),
(346, 11656, 3, '创建了事项', 'issue', 3, '编辑事项的修改时间显示错误', '2018-11-09', 1541747728),
(347, 11656, 3, '修改事项状态为 已解决', 'issue', 95, '编辑事项的修改时间显示错误', '2018-11-09', 1541747741),
(348, 11656, NULL, '为添加了一个附件', 'issue', NULL, 'debugissuedetail.png', '2018-11-09', 1541748210),
(349, 11656, 3, '创建了事项', 'issue', 3, '事项详情页面点击事项编辑按钮后附件框会多出来一部分', '2018-11-09', 1541748239),
(350, 11656, 3, '修改事项状态为 打 开', 'issue', 96, '事项详情页面点击事项编辑按钮后附件框会多出来一部分', '2018-11-09', 1541748289),
(351, 11656, 3, '更新了事项', 'issue', 95, '编辑事项的修改时间显示错误', '2018-11-09', 1541748327),
(352, 10000, 3, '创建了迭代', 'agile', 4, '第四次迭代', '2018-11-10', 1541850382),
(353, 10000, 3, '创建了事项', 'issue', 3, '创建一个smtp帐号并测试邮件发送功能', '2018-11-10', 1541850637),
(354, 10000, 3, '修改事项状态为 进行中', 'issue', 97, '创建一个smtp帐号并测试邮件发送功能', '2018-11-10', 1541850658),
(355, 10000, NULL, '为添加了一个附件', 'issue', NULL, '491EAA0D-75A0-44B9-80FF-C813F65CEF6D.png', '2018-11-10', 1541850739),
(356, 10000, 3, '创建了事项', 'issue', 3, '标签数据错误', '2018-11-10', 1541850743),
(357, 10000, 3, '修改事项状态为 进行中', 'issue', 98, '标签数据错误', '2018-11-10', 1541850761),
(358, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'QQ截图20181111001802.jpg', '2018-11-11', 1541866709),
(359, 10000, 3, '创建了事项', 'issue', 3, 'DbModel不应该添加特定的updated字段', '2018-11-11', 1541866713),
(360, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'QQ截图20181111020117.jpg', '2018-11-11', 1541872919),
(361, 10000, 3, '创建了事项', 'issue', 3, '动态内容缺失', '2018-11-11', 1541872925),
(362, 10000, 3, '修改事项状态为 已解决', 'issue', 98, '标签数据错误', '2018-11-12', 1541956171),
(363, 10000, 3, '修改事项状态为 已解决', 'issue', 81, '官方网站的图片需要重写设计', '2018-11-12', 1541956186),
(364, 10000, 3, '修改事项状态为 已解决', 'issue', 62, '增加缓存处理', '2018-11-12', 1541956197),
(365, 10000, 3, '创建了事项', 'issue', 3, '安装文档还要添加 Redis Sphinx 和 定时任务说明', '2018-11-12', 1541957329),
(366, 11657, 100, '为动态内容缺失添加了一个附件', 'issue', 100, '微信图片_20180628165448.png', '2018-11-12', 1542005400),
(367, 11657, 3, '修改事项解决结果为 需要重现', 'issue', 100, '动态内容缺失', '2018-11-12', 1542005455),
(368, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'jira_detai.png', '2018-11-13', 1542040716),
(369, 10000, 3, '创建了事项', 'issue', 3, '详情页面参考jira7.12', '2018-11-13', 1542040723),
(370, 10000, NULL, '为添加了一个附件', 'issue', NULL, '121.png', '2018-11-14', 1542176234),
(371, 10000, 3, '创建了事项', 'issue', 3, '迭代的数据统计错误', '2018-11-14', 1542176236),
(372, 10000, 3, '修改事项状态为 已解决', 'issue', 103, '迭代的数据统计错误', '2018-11-17', 1542422391),
(373, 10000, 3, '修改事项状态为 已解决', 'issue', 97, '创建一个smtp帐号并测试邮件发送功能', '2018-11-17', 1542422403),
(374, 10000, 3, '修改事项状态为 已解决', 'issue', 80, '项目图表的‘ 解决与未解决事项对比报告’为空', '2018-11-17', 1542422410),
(375, 10000, 3, '修改事项状态为 已解决', 'issue', 102, '详情页面参考jira7.12', '2018-11-18', 1542536391),
(376, 10000, NULL, '为添加了一个附件', 'issue', NULL, '121.png', '2018-11-19', 1542558614),
(377, 10000, 3, '创建了事项', 'issue', 3, '上传附件删除时需要汉化', '2018-11-19', 1542558617),
(378, 10000, 3, '修改事项状态为 已解决', 'issue', 101, '安装文档还要添加 Redis Sphinx 和 定时任务说明', '2018-11-19', 1542596715),
(379, 10000, 3, '更新了事项', 'issue', 64, 'PHP的设计模式优化', '2018-11-19', 1542596740),
(380, 11656, 3, '更新了事项', 'issue', 99, 'DbModel不应该添加特定的updated字段', '2018-11-19', 1542612662),
(381, 11656, 3, '修改事项状态为 已解决', 'issue', 99, 'DbModel不应该添加特定的updated字段', '2018-11-19', 1542612769),
(382, 11657, 100, '为动态内容缺失添加了一个附件', 'issue', 100, 'admin_icon.png', '2018-11-20', 1542706954),
(383, 11657, 28, '为各个功能模块添加操作日志添加了一个附件', 'issue', 28, 'admin_icon.png', '2018-11-20', 1542707913),
(384, 11654, 3, '修改事项状态为 已解决', 'issue', 104, '上传附件删除时需要汉化', '2018-11-20', 1542708321),
(385, 11654, 3, '修改事项状态为 打 开', 'issue', 104, '上传附件删除时需要汉化', '2018-11-20', 1542708337),
(386, 11654, 3, '修改事项解决结果为 已修复', 'issue', 104, '上传附件删除时需要汉化', '2018-11-20', 1542708358),
(387, 11654, 3, '更新了事项', 'issue', 104, '上传附件删除时需要汉化', '2018-11-20', 1542708363),
(388, 10000, NULL, '为添加了一个附件', 'issue', NULL, '1.jpg', '2018-11-20', 1542729555),
(389, 10000, NULL, '为添加了一个附件', 'issue', NULL, '2.jpg', '2018-11-20', 1542729559),
(390, 10000, 3, '创建了事项', 'issue', 3, '用户头像上传后的大小和设置时的大小不一致', '2018-11-20', 1542729562),
(391, 10000, 3, '更新了事项', 'issue', 105, '用户头像上传后的大小和设置时的大小不一致', '2018-11-21', 1542764879),
(392, 10000, 3, '创建了事项', 'issue', 3, '在创建和编辑事项时可以通过二维码在手机上上传附近', '2018-11-21', 1542765651),
(393, 10000, 3, '修改事项状态为 打 开', 'issue', 106, '在创建和编辑事项时可以通过二维码在手机上上传附近', '2018-11-21', 1542765661),
(394, 10000, 3, '创建了事项', 'issue', 3, '增加快捷键的提示功能', '2018-11-21', 1542766717),
(395, 10000, 3, '创建了事项', 'issue', 3, '自定义首页面板', '2018-11-21', 1542766745),
(396, 10000, 3, '创建了事项', 'issue', 3, '主菜单增加左侧布局，参考gitlab11.0版本', '2018-11-21', 1542767100),
(397, 10000, 3, '创建了事项', 'issue', 3, '要防止常见的Web攻击', '2018-11-21', 1542785084),
(398, 10000, 5, '创建了项目', 'project', 5, '盖房子', '2018-11-22', 1542879646),
(399, 10000, 3, '修改事项状态为 进行中', 'issue', 110, '要防止常见的Web攻击', '2018-11-22', 1542879714),
(400, 10000, 3, '创建了事项', 'issue', 3, '实现自动安装的功能', '2018-11-27', 1543309637),
(401, 10000, 3, '创建了事项', 'issue', 3, '增加docker安装方式', '2018-11-27', 1543309913),
(402, 10000, 3, '创建了事项', 'issue', 3, '创建事项时默认的状态应该为 打开 ', '2018-11-27', 1543310077),
(403, 10000, 3, '创建了事项', 'issue', 3, '优化文档', '2018-11-27', 1543310616),
(404, 10000, 3, '创建了事项', 'issue', 3, '增加左侧菜单的布局', '2018-11-27', 1543313567),
(405, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'left_layout_ant.png', '2018-11-27', 1543313602),
(406, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'left_layout.png', '2018-11-27', 1543313604),
(407, 10000, 3, '更新了事项', 'issue', 115, '增加左侧菜单的布局', '2018-11-27', 1543313606),
(408, 10000, 3, '创建了事项', 'issue', 3, '事项列表的表格行中双击可以直接修改状态和解决结果', '2018-11-27', 1543313945),
(409, 10000, 3, '更新了事项', 'issue', 116, '事项列表的表格行中双击可以直接修改状态和解决结果', '2018-11-27', 1543313969),
(410, 10000, 3, '创建了事项', 'issue', 3, '可以通过二维码上传手机附件', '2018-11-27', 1543314118),
(411, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'ant_list.png', '2018-11-27', 1543314493),
(412, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'gitlab_list.png', '2018-11-27', 1543314494),
(413, 10000, 3, '创建了事项', 'issue', 3, '事项列表-增加类似gitlab的展示方式(去除table tr td)', '2018-11-27', 1543314501),
(414, 10000, 3, '修改事项状态为 进行中', 'issue', 118, '事项列表-增加类似gitlab的展示方式(去除table tr td)', '2018-11-27', 1543314515),
(415, 10000, 3, '创建了事项', 'issue', 3, '增强安全性防止 XSS 和 CSRF 攻击', '2018-11-27', 1543314945),
(416, 10000, 3, '创建了事项', 'issue', 3, '创建事项时默认的状态错误', '2018-11-27', 1543314989),
(417, 10000, 3, '创建了事项', 'issue', 3, '当用户初次体验系统是在一些高级的功能UI上添加提示功能', '2018-11-27', 1543315331),
(418, 10000, 3, '创建了事项', 'issue', 3, '新手教程', '2018-11-27', 1543315524),
(419, 10000, 3, '更新了事项', 'issue', 122, '新手教程', '2018-11-27', 1543315530),
(420, 10000, 3, '创建了事项', 'issue', 3, '添加 hotjar 用于收集用户使用masterlab的使用情况', '2018-11-27', 1543315590),
(421, 10000, 3, '创建了事项', 'issue', 3, '自定义首页面板', '2018-11-27', 1543315755),
(422, 10000, 3, '创建了事项', 'issue', 3, '完善二次开发指南', '2018-11-27', 1543316506),
(423, 10000, 3, '创建了事项', 'issue', 3, '插件功能', '2018-11-27', 1543316541),
(424, 10000, 3, '更新了事项', 'issue', 124, '自定义首页面板', '2018-11-27', 1543317454),
(425, 10000, 3, '更新了事项', 'issue', 124, '自定义首页面板', '2018-11-27', 1543317477),
(426, 10000, 3, '更新了事项', 'issue', 124, '自定义首页面板', '2018-11-27', 1543317764),
(427, 10000, 3, '更新了事项', 'issue', 126, '插件功能', '2018-11-28', 1543366095),
(428, 10000, 3, '更新了事项', 'issue', 125, '完善二次开发指南', '2018-11-28', 1543366182),
(429, 10000, 3, '更新了事项', 'issue', 124, '自定义首页面板', '2018-11-28', 1543366258),
(430, 10000, 3, '更新了事项', 'issue', 123, '添加 hotjar 用于收集用户使用masterlab的使用情况', '2018-11-28', 1543366280),
(431, 10000, 3, '更新了事项', 'issue', 121, '当用户初次体验系统是在一些高级的功能UI上添加提示功能', '2018-11-28', 1543366342),
(432, 10000, 3, '更新了事项', 'issue', 120, '创建事项时默认的状态错误', '2018-11-28', 1543369967),
(433, 10000, 3, '更新了事项', 'issue', 118, '事项列表-增加类似gitlab的展示方式(去除table tr td)', '2018-11-28', 1543369999),
(434, 10000, 3, '更新了事项', 'issue', 117, '可以通过二维码上传手机附件', '2018-11-28', 1543370011),
(435, 10000, 3, '更新了事项', 'issue', 119, '增强安全性防止 XSS 和 CSRF 攻击', '2018-11-28', 1543370039),
(436, 10000, 3, '更新了事项', 'issue', 116, '事项列表的表格行中双击可以直接修改状态和解决结果、经办人', '2018-11-28', 1543370047),
(437, 10000, 3, '更新了事项', 'issue', 117, '可以通过二维码上传手机附件', '2018-11-28', 1543370059),
(438, 10000, 3, '更新了事项', 'issue', 115, '增加左侧菜单的布局', '2018-11-28', 1543370080),
(439, 10000, 3, '更新了事项', 'issue', 107, '增加快捷键的提示功能', '2018-11-28', 1543370091),
(440, 10000, 3, '更新了事项', 'issue', 108, '自定义首页面板', '2018-11-28', 1543370099),
(441, 10000, 3, '更新了事项', 'issue', 110, '要防止常见的Web攻击', '2018-11-28', 1543370109),
(442, 10000, 3, '更新了事项', 'issue', 111, '实现自动安装的功能', '2018-11-28', 1543370120),
(443, 10000, 3, '更新了事项', 'issue', 112, '增加docker安装方式', '2018-11-28', 1543370129),
(444, 10000, 3, '更新了事项', 'issue', 113, '创建事项时默认的状态应该为 打开 ', '2018-11-28', 1543370140),
(445, 10000, 3, '创建了事项', 'issue', 3, '迭代页面无法编辑事项', '2018-11-28', 1543370239),
(446, 10000, 3, '更新了事项', 'issue', 126, '插件功能', '2018-11-28', 1543370288),
(447, 10000, 3, '删除了事项', 'issue', 109, '主菜单增加左侧布局，参考gitlab11.0版本', '2018-11-28', 1543370322),
(448, 10000, 3, '删除了事项', 'issue', 110, '要防止常见的Web攻击', '2018-11-28', 1543370333),
(449, 10000, 3, '删除了事项', 'issue', 107, '增加快捷键的提示功能', '2018-11-28', 1543370340),
(450, 10000, 3, '更新了迭代', 'agile', 4, '第四次迭代', '2018-11-28', 1543370772),
(451, 10000, 3, '创建了事项', 'issue', 3, '图表统计颜色错误', '2018-11-28', 1543372068),
(452, 10000, 3, '修改事项状态为 打 开', 'issue', 102, '详情页面参考jira7.12', '2018-11-28', 1543372153),
(453, 10000, 3, '更新了事项', 'issue', 64, 'PHP的设计模式优化', '2018-11-28', 1543372456),
(454, 10000, 3, '更新了事项', 'issue', 115, '增加左侧菜单的布局', '2018-11-28', 1543372741),
(455, 10000, 3, '更新了事项', 'issue', 124, '自定义首页面板', '2018-11-28', 1543386713),
(456, 10000, 3, '更新了事项', 'issue', 119, '增强安全性防止 XSS 和 CSRF 攻击', '2018-11-29', 1543422061),
(457, 10000, 3, '更新了事项', 'issue', 108, '自定义首页面板', '2018-11-29', 1543422121),
(458, 10000, 3, '更新了事项', 'issue', 126, '插件功能', '2018-11-29', 1543422144),
(459, 10000, 3, '更新了事项', 'issue', 106, '在创建和编辑事项时可以通过二维码在手机上上传附近', '2018-11-29', 1543422184),
(460, 10000, 3, '更新了事项', 'issue', 105, '用户头像上传后的大小和设置时的大小不一致', '2018-11-29', 1543422308),
(461, 10000, 3, '更新了事项', 'issue', 116, '事项列表的表格行中双击可以直接修改状态和解决结果、经办人', '2018-11-29', 1543422329),
(462, 10000, 3, '修改事项状态为 进行中', 'issue', 117, '可以通过二维码上传手机附件', '2018-12-01', 1543598406),
(463, 10000, 3, '更新了事项', 'issue', 106, '在创建和编辑事项时可以通过二维码在手机上传附件', '2018-12-01', 1543598502),
(464, 10000, 3, '删除了事项', 'issue', 117, '可以通过二维码上传手机附件', '2018-12-01', 1543598517),
(465, 10000, 3, '创建了事项', 'issue', 3, '统一更换logo', '2018-12-01', 1543598948),
(466, 10000, 3, '创建了事项', 'issue', 3, '完善权限控制', '2018-12-01', 1543599053),
(467, 10000, 3, '创建了事项', 'issue', 3, '事项列表的右侧的详情浮动中，无事项标题', '2018-12-01', 1543599218),
(468, 10000, 3, '创建了事项', 'issue', 3, '注册时发送邮件地址有误', '2018-12-01', 1543642156),
(469, 10000, 3, '创建了事项', 'issue', 3, '使用非chrome Firefox浏览器时没有提示兼容性', '2018-12-01', 1543644426),
(470, 10000, 3, '更新了事项', 'issue', 133, '使用非chrome Firefox浏览器时没有提示兼容性', '2018-12-01', 1543644462),
(471, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'tip.jpg', '2018-12-01', 1543644476),
(472, 10000, 3, '更新了事项', 'issue', 133, '使用非chrome Firefox浏览器时没有提示兼容性', '2018-12-01', 1543644478),
(473, 10000, 3, '创建了事项', 'issue', 3, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '2018-12-01', 1543644588),
(474, 10000, NULL, '为添加了一个附件', 'issue', NULL, '500.jpg', '2018-12-01', 1543646265),
(475, 10000, NULL, '为添加了一个附件', 'issue', NULL, 'logo.jpg', '2018-12-01', 1543646350),
(476, 10000, 3, '更新了事项', 'issue', 129, '统一更换logo', '2018-12-01', 1543646358),
(477, 11656, 3, '修改事项状态为 已解决', 'issue', 105, '用户头像上传后的大小和设置时的大小不一致', '2018-12-01', 1543646666),
(478, 10000, 3, '修改事项状态为 进行中', 'issue', 106, '在创建和编辑事项时可以通过二维码在手机上传附件', '2018-12-01', 1543647052),
(479, 11656, 3, '为增强安全性防止 XSS 和 CSRF 攻击添加了评论 ', 'issue_comment', 119, '1. 框架已集成提交字段过滤的功能\n![](http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png)\n2. 需要增加CSRF的安全功能', '2018-12-01', 1543649108),
(480, 11656, 3, '更新了评论 - 1. 框架已集成提交字段过滤的功能\n![](ht', 'issue_comment', 40, '1. 框架已集成提交字段过滤的功能\n![](http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png)\n2. 需要增加CSRF的安全功能', '2018-12-01', 1543649133),
(481, 11656, 3, '更新了评论 - 1. 框架已集成提交字段过滤的功能来抵御XSS\n', 'issue_comment', 40, '- 1. 框架已集成提交字段过滤的功能\n![](http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png)\n\n- 2. 需要增加CSRF的安全功能', '2018-12-01', 1543649198),
(482, 10000, NULL, ' 添加了一个附件', 'issue', NULL, 'word.png', '2018-12-05', 1543941000),
(483, 0, NULL, ' 添加了一个附件', 'issue', NULL, 'qr.png', '2018-12-08', 1544269763),
(484, 10000, 3, '修改事项状态为 已解决', 'issue', 134, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '2018-12-10', 1544408436),
(485, 10000, 3, '更新了迭代', 'agile', 4, '第四次迭代', '2018-12-11', 1544459920),
(486, 10000, 3, '更新了迭代', 'agile', 4, '第四次迭代', '2018-12-16', 1544899629),
(487, 11674, 3, '创建了事项', 'issue', 3, '111', '2018-12-17', 1545031779),
(488, 11674, 3, '删除了事项', 'issue', 135, '111', '2018-12-17', 1545032385),
(489, 11657, 124, '为自定义首页面板添加了一个附件', 'issue', 124, '20181015102601_18003.png', '2018-12-17', 1545037570),
(490, 11674, 3, '为当登录状态失效后Ajax请求的接口应该跳转到登录页面添加了评论', 'issue_comment', 134, '12321321', '2018-12-17', 1545060798),
(491, 11674, 3, '为当登录状态失效后Ajax请求的接口应该跳转到登录页面添加了评论', 'issue_comment', 134, '12321321', '2018-12-17', 1545060804),
(492, 11674, 3, '关注了事项', 'issue', 134, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '2018-12-18', 1545063754),
(493, 11674, 3, '删除了事项', 'issue', 122, '新手教程', '2018-12-18', 1545064075),
(494, 11674, 3, '删除了事项', 'issue', 126, '插件功能', '2018-12-18', 1545064195),
(495, 11674, 3, '删除了事项', 'issue', 130, '完善权限控制', '2018-12-18', 1545064224),
(496, 11674, 3, '为使用非chrome Firefox浏览器时没有提示兼容性添加了', 'issue_comment', 133, '更符合规范化', '2018-12-18', 1545065194),
(497, 10000, 3, '删除了评论 更符合规范化', 'issue_comment', 43, '', '2018-12-18', 1545065849),
(498, 11674, 3, '为使用非chrome Firefox浏览器时没有提示兼容性添加了', 'issue_comment', 133, '规划规范化', '2018-12-18', 1545065863),
(499, 11674, 3, '删除了评论 规划规范化', 'issue_comment', 44, '', '2018-12-18', 1545065871),
(500, 11674, 3, '为使用非chrome Firefox浏览器时没有提示兼容性添加了', 'issue_comment', 133, '发的发的顺丰', '2018-12-18', 1545065921),
(501, 11674, 3, '为使用非chrome Firefox浏览器时没有提示兼容性添加了', 'issue_comment', 133, '发的发的顺丰', '2018-12-18', 1545066007),
(502, 11674, 3, '更新了评论 发的发的顺丰大幅度发 为 ', 'issue_comment', 45, '发的发的顺丰', '2018-12-18', 1545066012),
(503, 10000, 3, '更新了评论 发的发的顺丰大幅度发\n电饭锅电饭锅地方 为 ', 'issue_comment', 45, '发的发的顺丰大幅度发', '2018-12-18', 1545066158),
(504, 10000, 3, '创建了迭代', 'agile', 5, '佛挡杀佛', '2018-12-18', 1545069162),
(505, 10000, 3, '删除了迭代', 'agile', 5, '佛挡杀佛', '2018-12-18', 1545069291),
(506, 11657, 105, '为用户头像上传后的大小和设置时的大小不一致添加了一个附件', 'issue', 105, '20181015102601_18003.png', '2018-12-18', 1545097808),
(507, 11657, 105, '为用户头像上传后的大小和设置时的大小不一致添加了一个附件', 'issue', 105, '20181015102601_18003.png', '2018-12-18', 1545102270),
(518, 11705, 46, '创建了迭代', 'agile', 24, 'test-name-21597', '2018-12-18', 1545127539),
(519, 11705, 46, '更新了迭代', 'agile', 24, 'test-name-21597-updated', '2018-12-18', 1545127541),
(520, 11705, 46, '删除了迭代', 'agile', 24, 'test-name-21597-updated', '2018-12-18', 1545127544),
(531, 11707, 50, '创建了事项', 'issue', 50, '测试事项', '2018-12-18', 1545127694),
(532, 11707, 50, '修改事项解决结果为 已解决', 'issue', 205, '测试事项', '2018-12-18', 1545127711),
(533, 11707, 0, '关注了事项', 'issue', 203, 'test-summary-78193682', '2018-12-18', 1545127726),
(534, 11707, 0, '取消关注了事项', 'issue', 203, 'test-summary-78193682', '2018-12-18', 1545127729),
(535, 11707, 0, '转为子任务', 'issue', 203, 'test-summary-78193682', '2018-12-18', 1545127732),
(536, 11707, 0, '取消了子任务', 'issue', 203, 'test-summary-78193682', '2018-12-18', 1545127737),
(537, 11707, 50, '转为子任务', 'issue', 183, 'UnitTest测试事项 0', '2018-12-18', 1545127742),
(538, 11707, 50, '转为子任务', 'issue', 184, 'UnitTest测试事项 1', '2018-12-18', 1545127746),
(539, 11707, 50, '转为子任务', 'issue', 185, 'UnitTest测试事项 2', '2018-12-18', 1545127749),
(540, 11707, 50, '转为子任务', 'issue', 186, 'UnitTest测试事项 3', '2018-12-18', 1545127752),
(541, 11707, 0, '为test-summary-78193682添加了评论 ', 'issue_comment', 203, 'test-content', '2018-12-18', 1545127762),
(542, 11707, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 49, 'test-content', '2018-12-18', 1545127765),
(543, 11707, 0, '删除了评论 test-content-updated', 'issue_comment', 49, '', '2018-12-18', 1545127770),
(544, 11707, 0, '删除了事项', 'issue', 203, 'test-summary-78193682', '2018-12-18', 1545127775),
(545, 11709, 0, '创建了组织', 'org', 14, 'test-path-74019', '2018-12-18', 1545127804),
(546, 11709, 0, '更新了组织', 'org', 14, 'test-path-74019', '2018-12-18', 1545127807),
(547, 11709, 0, '删除了组织', 'org', 14, 'updated-name', '2018-12-18', 1545127811),
(548, 1, NULL, '添加了一个附件', 'issue', NULL, '1.png', '2018-12-18', 1545127908),
(549, 1, 3, '创建了事项', 'issue', 3, '新bug来了', '2018-12-18', 1545127910),
(550, 11720, 0, '更新了资料', 'user', 11720, 'updated_19029239247', '2018-12-18', 1545127942),
(551, 0, NULL, ' 添加了一个附件', 'issue', NULL, '0E9046FD-9B8F-47A8-A1B4-F1821E1FFD8E.jpeg', '2018-12-18', 1545128383),
(552, 0, NULL, ' 添加了一个附件', 'issue', NULL, '417E3044-F972-456F-BAEF-C5DC49E07846.png', '2018-12-18', 1545128402),
(553, 1, 3, '更新了事项', 'issue', 134, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '2018-12-18', 1545128409),
(554, 11750, 90, '创建了项目', 'project', 90, 'PROName-ysMfjA7031', '2018-12-18', 1545128426),
(565, 11781, 131, '创建了迭代', 'agile', 46, 'test-name-12961', '2018-12-18', 1545129001),
(566, 11781, 131, '更新了迭代', 'agile', 46, 'test-name-12961-updated', '2018-12-18', 1545129003),
(567, 11781, 131, '删除了迭代', 'agile', 46, 'test-name-12961-updated', '2018-12-18', 1545129006),
(578, 11783, 135, '创建了事项', 'issue', 135, '测试事项', '2018-12-18', 1545129156),
(579, 11783, 135, '修改事项解决结果为 已解决', 'issue', 287, '测试事项', '2018-12-18', 1545129172),
(580, 11783, 0, '关注了事项', 'issue', 285, 'test-summary-90159336', '2018-12-18', 1545129188),
(581, 11783, 0, '取消关注了事项', 'issue', 285, 'test-summary-90159336', '2018-12-18', 1545129190),
(582, 11783, 0, '转为子任务', 'issue', 285, 'test-summary-90159336', '2018-12-18', 1545129194),
(583, 11783, 0, '取消了子任务', 'issue', 285, 'test-summary-90159336', '2018-12-18', 1545129199),
(584, 11783, 135, '转为子任务', 'issue', 265, 'UnitTest测试事项 0', '2018-12-18', 1545129204),
(585, 11783, 135, '转为子任务', 'issue', 266, 'UnitTest测试事项 1', '2018-12-18', 1545129207),
(586, 11783, 135, '转为子任务', 'issue', 267, 'UnitTest测试事项 2', '2018-12-18', 1545129211),
(587, 11783, 135, '转为子任务', 'issue', 268, 'UnitTest测试事项 3', '2018-12-18', 1545129214),
(588, 11783, 0, '为test-summary-90159336添加了评论 ', 'issue_comment', 285, 'test-content', '2018-12-18', 1545129223),
(589, 11783, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 52, 'test-content', '2018-12-18', 1545129227),
(590, 11783, 0, '删除了评论 test-content-updated', 'issue_comment', 52, '', '2018-12-18', 1545129231),
(591, 11783, 0, '删除了事项', 'issue', 285, 'test-summary-90159336', '2018-12-18', 1545129236),
(592, 11785, 0, '创建了组织', 'org', 45, 'test-path-38543', '2018-12-18', 1545129266),
(593, 11785, 0, '更新了组织', 'org', 45, 'test-path-38543', '2018-12-18', 1545129269),
(594, 11785, 0, '删除了组织', 'org', 45, 'updated-name', '2018-12-18', 1545129272),
(595, 11796, 0, '更新了资料', 'user', 11796, 'updated_19031854971', '2018-12-18', 1545129408),
(596, 11826, 175, '创建了项目', 'project', 175, 'PROName-DcTIojlgYm', '2018-12-18', 1545129896),
(597, 1, 0, '更新了资料', 'user', 1, 'Master', '2018-12-18', 1545130092),
(598, 1, 0, '更新了资料', 'user', 1, 'Master', '2018-12-18', 1545130094),
(599, 1, 0, '更新了资料', 'user', 1, 'Master', '2018-12-18', 1545130095),
(600, 1, 0, '更新了资料', 'user', 1, 'Master', '2018-12-18', 1545130096),
(601, 1, 0, '更新了资料', 'user', 1, 'Master', '2018-12-18', 1545130097),
(612, 11857, 216, '创建了迭代', 'agile', 68, 'test-name-90122', '2018-12-18', 1545133422),
(613, 11857, 216, '更新了迭代', 'agile', 68, 'test-name-90122-updated', '2018-12-18', 1545133424),
(614, 11857, 216, '删除了迭代', 'agile', 68, 'test-name-90122-updated', '2018-12-18', 1545133427),
(625, 11859, 220, '创建了事项', 'issue', 220, '测试事项', '2018-12-18', 1545133589),
(626, 11859, 220, '修改事项解决结果为 已解决', 'issue', 368, '测试事项', '2018-12-18', 1545133606),
(627, 11859, 0, '关注了事项', 'issue', 366, 'test-summary-13178319', '2018-12-18', 1545133622),
(628, 11859, 0, '取消关注了事项', 'issue', 366, 'test-summary-13178319', '2018-12-18', 1545133625),
(629, 11859, 0, '转为子任务', 'issue', 366, 'test-summary-13178319', '2018-12-18', 1545133629),
(630, 11859, 0, '取消了子任务', 'issue', 366, 'test-summary-13178319', '2018-12-18', 1545133634),
(631, 11859, 220, '转为子任务', 'issue', 346, 'UnitTest测试事项 0', '2018-12-18', 1545133640),
(632, 11859, 220, '转为子任务', 'issue', 347, 'UnitTest测试事项 1', '2018-12-18', 1545133643),
(633, 11859, 220, '转为子任务', 'issue', 348, 'UnitTest测试事项 2', '2018-12-18', 1545133646),
(634, 11859, 220, '转为子任务', 'issue', 349, 'UnitTest测试事项 3', '2018-12-18', 1545133650),
(635, 11859, 0, '为test-summary-13178319添加了评论 ', 'issue_comment', 366, 'test-content', '2018-12-18', 1545133660),
(636, 11859, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 55, 'test-content', '2018-12-18', 1545133664),
(637, 11859, 0, '删除了评论 test-content-updated', 'issue_comment', 55, '', '2018-12-18', 1545133669),
(638, 11859, 0, '删除了事项', 'issue', 366, 'test-summary-13178319', '2018-12-18', 1545133674),
(639, 11861, 0, '创建了组织', 'org', 76, 'test-path-56974', '2018-12-18', 1545133705),
(640, 11861, 0, '更新了组织', 'org', 76, 'test-path-56974', '2018-12-18', 1545133708),
(641, 11861, 0, '删除了组织', 'org', 76, 'updated-name', '2018-12-18', 1545133711),
(642, 11872, 0, '更新了资料', 'user', 11872, 'updated_19016103401', '2018-12-18', 1545133844),
(643, 11902, 264, '创建了项目', 'project', 264, 'PROName-TBi763sGg9', '2018-12-18', 1545134342),
(654, 11933, 301, '创建了迭代', 'agile', 90, 'test-name-49308', '2018-12-18', 1545134684),
(655, 11933, 301, '更新了迭代', 'agile', 90, 'test-name-49308-updated', '2018-12-18', 1545134687),
(656, 11933, 301, '删除了迭代', 'agile', 90, 'test-name-49308-updated', '2018-12-18', 1545134689),
(667, 11935, 305, '创建了事项', 'issue', 305, '测试事项', '2018-12-18', 1545134845),
(668, 11935, 305, '修改事项解决结果为 已解决', 'issue', 449, '测试事项', '2018-12-18', 1545134862),
(669, 11935, 0, '关注了事项', 'issue', 447, 'test-summary-74142049', '2018-12-18', 1545134879),
(670, 11935, 0, '取消关注了事项', 'issue', 447, 'test-summary-74142049', '2018-12-18', 1545134881),
(671, 11935, 0, '转为子任务', 'issue', 447, 'test-summary-74142049', '2018-12-18', 1545134885);
INSERT INTO `main_activity` (`id`, `user_id`, `project_id`, `action`, `type`, `obj_id`, `title`, `date`, `time`) VALUES
(672, 11935, 0, '取消了子任务', 'issue', 447, 'test-summary-74142049', '2018-12-18', 1545134890),
(673, 11935, 305, '转为子任务', 'issue', 427, 'UnitTest测试事项 0', '2018-12-18', 1545134896),
(674, 11935, 305, '转为子任务', 'issue', 428, 'UnitTest测试事项 1', '2018-12-18', 1545134899),
(675, 11935, 305, '转为子任务', 'issue', 429, 'UnitTest测试事项 2', '2018-12-18', 1545134903),
(676, 11935, 305, '转为子任务', 'issue', 430, 'UnitTest测试事项 3', '2018-12-18', 1545134906),
(677, 11935, 0, '为test-summary-74142049添加了评论 ', 'issue_comment', 447, 'test-content', '2018-12-18', 1545134916),
(678, 11935, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 58, 'test-content', '2018-12-18', 1545134920),
(679, 11935, 0, '删除了评论 test-content-updated', 'issue_comment', 58, '', '2018-12-18', 1545134925),
(680, 11935, 0, '删除了事项', 'issue', 447, 'test-summary-74142049', '2018-12-18', 1545134930),
(681, 11937, 0, '创建了组织', 'org', 107, 'test-path-73024', '2018-12-18', 1545134961),
(682, 11937, 0, '更新了组织', 'org', 107, 'test-path-73024', '2018-12-18', 1545134964),
(683, 11937, 0, '删除了组织', 'org', 107, 'updated-name', '2018-12-18', 1545134967),
(684, 11948, 0, '更新了资料', 'user', 11948, 'updated_19073055713', '2018-12-18', 1545135099),
(685, 11978, 345, '创建了项目', 'project', 345, 'PROName-YqpUGU37L1', '2018-12-18', 1545135600),
(686, 1, 134, '为当登录状态失效后Ajax请求的接口应该跳转到登录页面添加了一个', 'issue', 134, 'word.png', '2018-12-18', 1545144673),
(687, 1, 133, '为使用非chrome Firefox浏览器时没有提示兼容性添加了', 'issue', 133, '234242.png', '2018-12-18', 1545144695),
(688, 0, NULL, ' 添加了一个附件', 'issue', NULL, '21AE898A-0236-4189-8A63-952F6E8008EA.jpeg', '2018-12-18', 1545144787),
(689, 1, 3, '更新了事项', 'issue', 133, '使用非chrome Firefox浏览器时没有提示兼容性', '2018-12-18', 1545144811),
(690, 1, 286, '修改事项状态为 已解决', 'issue', 411, 'testFilterSummary3Rand13463933', '2018-12-19', 1545149443),
(691, 10000, 3, '删除了事项', 'issue', 217, '新bug来了', '2018-12-19', 1545154285),
(692, 10000, 3, '更新了事项', 'issue', 134, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '2018-12-19', 1545154307),
(703, 12009, 386, '创建了迭代', 'agile', 112, 'test-name-71993', '2018-12-19', 1545154750),
(704, 12009, 386, '更新了迭代', 'agile', 112, 'test-name-71993-updated', '2018-12-19', 1545154753),
(705, 12009, 386, '删除了迭代', 'agile', 112, 'test-name-71993-updated', '2018-12-19', 1545154756),
(716, 12011, 390, '创建了事项', 'issue', 390, '测试事项', '2018-12-19', 1545154918),
(717, 12011, 390, '修改事项解决结果为 已解决', 'issue', 530, '测试事项', '2018-12-19', 1545154935),
(718, 12011, 0, '关注了事项', 'issue', 528, 'test-summary-65096797', '2018-12-19', 1545154951),
(719, 12011, 0, '取消关注了事项', 'issue', 528, 'test-summary-65096797', '2018-12-19', 1545154954),
(720, 12011, 0, '转为子任务', 'issue', 528, 'test-summary-65096797', '2018-12-19', 1545154958),
(721, 12011, 0, '取消了子任务', 'issue', 528, 'test-summary-65096797', '2018-12-19', 1545154963),
(722, 12011, 390, '转为子任务', 'issue', 508, 'UnitTest测试事项 0', '2018-12-19', 1545154969),
(723, 12011, 390, '转为子任务', 'issue', 509, 'UnitTest测试事项 1', '2018-12-19', 1545154972),
(724, 12011, 390, '转为子任务', 'issue', 510, 'UnitTest测试事项 2', '2018-12-19', 1545154976),
(725, 12011, 390, '转为子任务', 'issue', 511, 'UnitTest测试事项 3', '2018-12-19', 1545154979),
(726, 12011, 0, '为test-summary-65096797添加了评论 ', 'issue_comment', 528, 'test-content', '2018-12-19', 1545154990),
(727, 12011, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 61, 'test-content', '2018-12-19', 1545154993),
(728, 12011, 0, '删除了评论 test-content-updated', 'issue_comment', 61, '', '2018-12-19', 1545154998),
(729, 12011, 0, '删除了事项', 'issue', 528, 'test-summary-65096797', '2018-12-19', 1545155003),
(730, 12013, 0, '创建了组织', 'org', 138, 'test-path-94526', '2018-12-19', 1545155034),
(731, 12013, 0, '更新了组织', 'org', 138, 'test-path-94526', '2018-12-19', 1545155038),
(732, 12013, 0, '删除了组织', 'org', 138, 'updated-name', '2018-12-19', 1545155041),
(733, 12024, 0, '更新了资料', 'user', 12024, 'updated_19028356340', '2018-12-19', 1545155172),
(734, 12054, 430, '创建了项目', 'project', 430, 'PROName-X5h4aX8lAM', '2018-12-19', 1545155675),
(735, 1, 431, '创建了项目', 'project', 431, '档案', '2018-12-19', 1545188084),
(736, 1, 431, '创建了事项', 'issue', 431, '录入', '2018-12-19', 1545188223),
(737, 1, 0, '创建了组织', 'org', 158, '11', '2018-12-19', 1545198108),
(738, 1, 2, '创建了迭代', 'agile', 116, 'qwwq', '2018-12-19', 1545199723),
(739, 1, 432, '创建了项目', 'project', 432, 'a', '2018-12-19', 1545203393),
(740, 1, 433, '创建了项目', 'project', 433, 'b', '2018-12-19', 1545203718),
(741, 1, 434, '创建了项目', 'project', 434, '明媚', '2018-12-19', 1545203858),
(742, 1, 1, '创建了事项', 'issue', 1, 'aa', '2018-12-19', 1545204204),
(743, 1, 1, '更新了事项', 'issue', 543, 'aa', '2018-12-19', 1545204236),
(744, 1, 1, '更新了事项', 'issue', 543, 'aa', '2018-12-19', 1545204300),
(755, 12087, 475, '创建了迭代', 'agile', 135, 'test-name-18261', '2018-12-19', 1545207057),
(756, 12087, 475, '更新了迭代', 'agile', 135, 'test-name-18261-updated', '2018-12-19', 1545207060),
(757, 12087, 475, '删除了迭代', 'agile', 135, 'test-name-18261-updated', '2018-12-19', 1545207063),
(768, 12089, 479, '创建了事项', 'issue', 479, '测试事项', '2018-12-19', 1545207221),
(769, 12089, 479, '修改事项解决结果为 已解决', 'issue', 613, '测试事项', '2018-12-19', 1545207238),
(770, 12089, 0, '关注了事项', 'issue', 611, 'test-summary-21971938', '2018-12-19', 1545207254),
(771, 12089, 0, '取消关注了事项', 'issue', 611, 'test-summary-21971938', '2018-12-19', 1545207257),
(772, 12089, 0, '转为子任务', 'issue', 611, 'test-summary-21971938', '2018-12-19', 1545207260),
(773, 12089, 0, '取消了子任务', 'issue', 611, 'test-summary-21971938', '2018-12-19', 1545207266),
(774, 12089, 479, '转为子任务', 'issue', 591, 'UnitTest测试事项 0', '2018-12-19', 1545207271),
(775, 12089, 479, '转为子任务', 'issue', 592, 'UnitTest测试事项 1', '2018-12-19', 1545207275),
(776, 12089, 479, '转为子任务', 'issue', 593, 'UnitTest测试事项 2', '2018-12-19', 1545207278),
(777, 12089, 479, '转为子任务', 'issue', 594, 'UnitTest测试事项 3', '2018-12-19', 1545207282),
(778, 12089, 0, '为test-summary-21971938添加了评论 ', 'issue_comment', 611, 'test-content', '2018-12-19', 1545207292),
(779, 12089, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 64, 'test-content', '2018-12-19', 1545207295),
(780, 12089, 0, '删除了评论 test-content-updated', 'issue_comment', 64, '', '2018-12-19', 1545207300),
(781, 12089, 0, '删除了事项', 'issue', 611, 'test-summary-21971938', '2018-12-19', 1545207306),
(782, 12091, 0, '创建了组织', 'org', 170, 'test-path-91488', '2018-12-19', 1545207337),
(783, 12091, 0, '更新了组织', 'org', 170, 'test-path-91488', '2018-12-19', 1545207340),
(784, 12091, 0, '删除了组织', 'org', 170, 'updated-name', '2018-12-19', 1545207343),
(785, 12102, 0, '更新了资料', 'user', 12102, 'updated_19029828672', '2018-12-19', 1545207478),
(786, 12132, 519, '创建了项目', 'project', 519, 'PROName-Lh236mMrGC', '2018-12-19', 1545207989),
(797, 12163, 560, '创建了迭代', 'agile', 157, 'test-name-73309', '2018-12-19', 1545209531),
(798, 12163, 560, '更新了迭代', 'agile', 157, 'test-name-73309-updated', '2018-12-19', 1545209534),
(799, 12163, 560, '删除了迭代', 'agile', 157, 'test-name-73309-updated', '2018-12-19', 1545209537),
(810, 12165, 564, '创建了事项', 'issue', 564, '测试事项', '2018-12-19', 1545209694),
(811, 12165, 564, '修改事项解决结果为 已解决', 'issue', 694, '测试事项', '2018-12-19', 1545209711),
(812, 12165, 0, '关注了事项', 'issue', 692, 'test-summary-40264106', '2018-12-19', 1545209727),
(813, 12165, 0, '取消关注了事项', 'issue', 692, 'test-summary-40264106', '2018-12-19', 1545209730),
(814, 12165, 0, '转为子任务', 'issue', 692, 'test-summary-40264106', '2018-12-19', 1545209734),
(815, 12165, 0, '取消了子任务', 'issue', 692, 'test-summary-40264106', '2018-12-19', 1545209739),
(816, 12165, 564, '转为子任务', 'issue', 672, 'UnitTest测试事项 0', '2018-12-19', 1545209744),
(817, 12165, 564, '转为子任务', 'issue', 673, 'UnitTest测试事项 1', '2018-12-19', 1545209748),
(818, 12165, 564, '转为子任务', 'issue', 674, 'UnitTest测试事项 2', '2018-12-19', 1545209751),
(819, 12165, 564, '转为子任务', 'issue', 675, 'UnitTest测试事项 3', '2018-12-19', 1545209755),
(820, 12165, 0, '为test-summary-40264106添加了评论 ', 'issue_comment', 692, 'test-content', '2018-12-19', 1545209765),
(821, 12165, 0, '更新了评论 test-content-updated 为 ', 'issue_comment', 67, 'test-content', '2018-12-19', 1545209769),
(822, 12165, 0, '删除了评论 test-content-updated', 'issue_comment', 67, '', '2018-12-19', 1545209774),
(823, 12165, 0, '删除了事项', 'issue', 692, 'test-summary-40264106', '2018-12-19', 1545209779),
(824, 12167, 0, '创建了组织', 'org', 201, 'test-path-39041', '2018-12-19', 1545209810),
(825, 12167, 0, '更新了组织', 'org', 201, 'test-path-39041', '2018-12-19', 1545209813),
(826, 12167, 0, '删除了组织', 'org', 201, 'updated-name', '2018-12-19', 1545209816),
(827, 12178, 0, '更新了资料', 'user', 12178, 'updated_19085523856', '2018-12-19', 1545209949),
(828, 12208, 604, '创建了项目', 'project', 604, 'PROName-dekYf39tgu', '2018-12-19', 1545210461);

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
(1, 'test-content-938144', 0, 0, 2018);

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
('3', 'lsit', NULL, NULL),
('dict/default_role/getAll/0,*', 'dict/default_role', '2018-12-26 17:07:33', 1545815253),
('dict/default_role_relation/getAll/0,*', 'dict/default_role_relation', '2018-12-26 16:49:53', 1545814193),
('dict/description_template/getAll/0,*', 'dict/description_template', '2018-12-26 16:51:56', 1545814316),
('dict/global/getAll/0,*', 'dict/global', '2018-12-26 17:02:43', 1545814963),
('dict/global_group/getAll/0,*', 'dict/global_group', '2018-12-26 17:02:44', 1545814964),
('dict/label/getAll/0,*', 'dict/label', '2018-12-26 16:54:57', 1545814497),
('dict/label/getAll/1,*', 'dict/label', '2018-12-26 16:55:04', 1545814504),
('dict/list_count/getAll/1,*', 'dict/list_count', '2018-12-26 16:49:49', 1545814189),
('dict/main/getAll/0,*', 'dict/main', '2018-12-26 16:54:41', 1545814481),
('dict/permission/getAll/1,*', 'dict/permission', '2018-12-26 16:51:38', 1545814298),
('dict/priority/getAll/0,*', 'dict/priority', '2018-12-26 16:59:55', 1545814795),
('dict/priority/getAll/1,*', 'dict/priority', '2018-12-26 16:54:52', 1545814492),
('dict/resolve/getAll/0,*', 'dict/resolve', '2018-12-26 17:00:14', 1545814814),
('dict/resolve/getAll/1,*', 'dict/resolve', '2018-12-26 16:54:52', 1545814492),
('dict/sprint/getItemById/113', 'dict/sprint', '2018-12-26 01:39:19', 1545759559),
('dict/sprint/getItemById/114', 'dict/sprint', '2018-12-26 01:39:23', 1545759563),
('dict/sprint/getItemById/136', 'dict/sprint', '2018-12-26 16:11:05', 1545811865),
('dict/sprint/getItemById/137', 'dict/sprint', '2018-12-26 16:11:09', 1545811869),
('dict/sprint/getItemById/158', 'dict/sprint', '2018-12-26 16:52:19', 1545814339),
('dict/sprint/getItemById/159', 'dict/sprint', '2018-12-26 16:52:23', 1545814343),
('dict/sprint/getItemById/2', 'dict/sprint', '2018-12-21 23:47:20', 1545407240),
('dict/sprint/getItemById/25', 'dict/sprint', '2018-12-25 18:05:46', 1545732346),
('dict/sprint/getItemById/26', 'dict/sprint', '2018-12-25 18:05:50', 1545732350),
('dict/sprint/getItemById/3', 'dict/sprint', '2018-12-21 23:47:23', 1545407243),
('dict/sprint/getItemById/4', 'dict/sprint', '2018-12-25 01:09:50', 1545671390),
('dict/sprint/getItemById/47', 'dict/sprint', '2018-12-25 18:30:08', 1545733808),
('dict/sprint/getItemById/48', 'dict/sprint', '2018-12-25 18:30:12', 1545733812),
('dict/sprint/getItemById/5', 'dict/sprint', '2018-12-25 01:52:48', 1545673968),
('dict/sprint/getItemById/69', 'dict/sprint', '2018-12-25 19:43:50', 1545738230),
('dict/sprint/getItemById/70', 'dict/sprint', '2018-12-25 19:43:54', 1545738234),
('dict/sprint/getItemById/91', 'dict/sprint', '2018-12-25 20:04:52', 1545739492),
('dict/sprint/getItemById/92', 'dict/sprint', '2018-12-25 20:04:56', 1545739496),
('dict/status/getAll/1,*', 'dict/status', '2018-12-26 16:54:52', 1545814492),
('dict/type/getAll/0,*', 'dict/type', '2018-12-26 16:45:43', 1545813943),
('dict/type/getAll/1,*', 'dict/type', '2018-12-26 16:45:41', 1545813941),
('dict/type_scheme/getAll/1,*', 'dict/type_scheme', '2018-12-26 16:45:44', 1545813944),
('dict/workflow/getAll/1,*', 'dict/workflow', '2018-12-26 17:05:26', 1545815126),
('dict/workflow_scheme/getAll/1,*', 'dict/workflow_scheme', '2018-12-26 17:01:53', 1545814913),
('setting/getSettingByKey/datetime_format', 'setting', '2018-12-26 17:04:05', 1545815045),
('setting/getSettingByKey/date_timezone', 'setting', '2018-12-26 17:05:44', 1545815144),
('setting/getSettingByKey/max_login_error', 'setting', '2018-12-26 17:02:37', 1545814957),
('setting/getSettingByKey/max_project_key', 'setting', '2018-12-26 17:05:46', 1545815146),
('setting/getSettingByKey/max_project_name', 'setting', '2018-12-26 17:05:46', 1545815146),
('setting/getSettingByKey/title', 'setting', '2018-12-26 17:02:40', 1545814960),
('setting/getSettingRow/muchErrorTimesCaptcha', 'setting', '2018-12-26 17:03:30', 1545815010),
('setting/getSettingRow/project_view', 'setting', '2018-12-26 17:06:46', 1545815206);

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
(9, '(SSZBD-604) 支付的订金小于50%时，没有给出相应提示。可以正常下单', NULL, NULL, NULL, NULL);

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
(2, 'ismond', 'Agile', '敏捷开发部', 'all/20180826/20180826140446_89680.jpg', 10000, 0, 1535263488, 1),
(158, '11', '11', '11', '', 1, 1545198108, 0, 1);

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
(1, 'title', '网站的页面标题', 'basic', 'MasterLab--基于敏捷开发和事项驱动的现代项目管理工具', 'MasterLab', 'string', 'text', NULL, ''),
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
(39, 'time_format', '时间格式', 'datetime', 'H:m:s', 'HH:mm:ss', 'string', 'text', NULL, '例如 11:55:47'),
(40, 'week_format', '星期格式', 'datetime', 'EE H:m:s', 'EEEE HH:mm:ss', 'string', 'text', NULL, '例如 Wednesday 11:55:47'),
(41, 'full_datetime_format', '完整日期/时间格式', 'datetime', 'Y-m-d  H:m:s', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', NULL, '例如 2007-05-23  11:55:47'),
(42, 'datetime_format', '日期格式(年月日)', 'datetime', 'Y-m-d', 'yyyy-MM-dd', 'string', 'text', NULL, '例如 2007-05-23'),
(43, 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天'),
(45, 'attachment_dir', '附件路径', 'attachment', '{{STORAGE_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下'),
(46, 'attachment_size', '附件大小(单位M)', 'attachment', '10.0', '10.0', 'float', 'text', NULL, '超过大小，无法上传'),
(47, 'enbale_thum', '启用缩略图', 'attachment', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图'),
(48, 'enable_zip', '启用ZIP支持', 'attachment', '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载'),
(49, 'password_strategy', '密码策略', 'password_strategy', '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', ''),
(50, 'send_mailer', '发信人', 'mail', 'sender@smtp.masterlab.vip', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 'Masterlab', '', 'string', 'text', NULL, ''),
(52, 'mail_host', '主机', 'mail', 'smtpdm.aliyun.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', '25', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 'sender@smtp.masterlab.vip', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 'MasterLab123456', '', 'string', 'text', NULL, ''),
(56, 'mail_timeout', '发送超时', 'mail', '20', '', 'int', 'text', NULL, ''),
(57, 'page_layout', '页面布局', 'user_default', 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', ''),
(58, 'project_view', '项目首页', 'user_default', 'issues', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', ''),
(59, 'company', '公司名称', 'basic', '', '', 'string', 'text', NULL, ''),
(60, 'company_logo', '公司logo', 'basic', '', '', 'string', 'text', NULL, ''),
(61, 'company_linkman', '联系人', 'basic', '', '', 'string', 'text', NULL, ''),
(62, 'company_phone', '联系电话', 'basic', '', '', 'string', 'text', NULL, '');

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
(21, 11198, 'issue', 0, 0, 18555, 'commented', '', 'test-content-updated', 'test-content-html-updated', 1536051294),
(23, 11657, 'issue', 0, 0, 28, 'commented', '', '模块的新增、修改、删除已添加操作日志', '<p>模块的新增、修改、删除已添加操作日志</p>\n', 1539571207),
(24, 11657, 'issue', 0, 0, 28, 'commented', '', '版本的新增、修改、删除、发布已添加操作日志', '<p>版本的新增、修改、删除、发布已添加操作日志</p>\n', 1539595779),
(25, 11657, 'issue', 0, 0, 28, 'commented', '', '标签的新增、修改、删除、发布已添加操作日志', '<p>标签的新增、修改、删除、发布已添加操作日志</p>\n', 1539661250),
(26, 11657, 'issue', 0, 0, 28, 'commented', '', '项目角色的新增、修改、删除、发布已添加操作日志', '<p>项目角色的新增、修改、删除、发布已添加操作日志</p>\n', 1539661256),
(27, 10000, 'issue', 0, 0, 39, 'commented', '', '111111', '<p>111111</p>\n', 1539766355),
(28, 11654, 'issue', 0, 0, 52, 'commented', '', '首页的图标必须是正方形，要不然怎么样都不好看', '<p>首页的图标必须是正方形，要不然怎么样都不好看</p>\n', 1540454400),
(29, 11657, 'issue', 0, 0, 63, 'commented', '', '1.首页的用户动态，需要分页 已完成，目前设置每页只显示20条', '<p>1.首页的用户动态，需要分页 已完成，目前设置每页只显示20条</p>\n', 1541044567),
(30, 11657, 'issue', 0, 0, 63, 'commented', '', '3.某些模块未添加动态，需要进行查漏补缺  目前已有的活动记录如下：项目、标签、模块、项目角色、版本；迭代；组织；用户修改个人资料等', '<p>3.某些模块未添加动态，需要进行查漏补缺  目前已有的活动记录如下：项目、标签、模块、项目角色、版本；迭代；组织；用户修改个人资料等</p>\n', 1541044998),
(31, 11657, 'issue', 0, 0, 63, 'commented', '', '事项上传附件已添加动态', '<p>事项上传附件已添加动态</p>\n', 1541059472),
(32, 11657, 'issue', 0, 0, 63, 'commented', '', '事项状态的修改、解决结果的修改已添加动态', '<p>事项状态的修改、解决结果的修改已添加动态</p>\n', 1541067265),
(33, 11654, 'issue', 0, 0, 59, 'commented', '', '我本地是对的', '<p>我本地是对的</p>\n', 1541128103),
(34, 11657, 'issue', 0, 0, 63, 'commented', '', '项目、标签、模块、项目角色、版本；迭代；组织；用户修改个人资料；事项的创建,更新;事项详情里:附件上传，修改状态,转化子任务,评论；事项列表里的：转化待办事项，转化子任务，批量处理  查漏补缺已完成', '<p>项目、标签、模块、项目角色、版本；迭代；组织；用户修改个人资料；事项的创建,更新;事项详情里:附件上传，修改状态,转化子任务,评论；事项列表里的：转化待办事项，转化子任务，批量处理  查漏补缺已完成</p>\n', 1541388619),
(35, 11657, 'issue', 0, 0, 70, 'commented', '', '快捷键已编写完成', '<p>快捷键已编写完成</p>\n', 1541389729),
(36, 11657, 'issue', 0, 0, 70, 'commented', '', '工作流和方案、事项类型及方案 已编写完成', '<p>工作流和方案、事项类型及方案 已编写完成</p>\n', 1541410549),
(37, 11657, 'issue', 0, 0, 70, 'commented', '', '项目角色定义 已编写完成', '<p>项目角色定义 已编写完成</p>\n', 1541416025),
(38, 11657, 'issue', 0, 0, 63, 'commented', '', '批量操作事项的 解决结果、模块、迭代已经添加用户动态', '<p>批量操作事项的 解决结果、模块、迭代已经添加用户动态</p>\n', 1541487964),
(39, 11657, 'issue', 0, 0, 70, 'commented', '', '最佳实践，创建组织或产品,创建项目,项目设置，添加事项，创建迭代，跟踪和管理迭代，数据和图表分析 已编写完成', '<p>最佳实践，创建组织或产品,创建项目,项目设置，添加事项，创建迭代，跟踪和管理迭代，数据和图表分析 已编写完成</p>\n', 1541495137),
(40, 11656, 'issue', 0, 0, 119, 'commented', '', '- 1. 框架已集成提交字段过滤的功能来抵御XSS\n![](http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png)\n\n- 2. 还需要增加CSRF的安全防护功能', '<ul>\n<li><ol>\n<li>框架已集成提交字段过滤的功能来抵御XSS<br><img src=\"http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png\" alt=\"\"></li></ol>\n</li><li><ol>\n<li>还需要增加CSRF的安全防护功能</li></ol>\n</li></ul>\n', 1543649108),
(41, 11674, 'issue', 0, 0, 134, 'commented', '', '12321321', '<p>12321321</p>\n', 1545060798),
(42, 11674, 'issue', 0, 0, 134, 'commented', '', '12321321', '<p>12321321</p>\n', 1545060804),
(45, 11674, 'issue', 0, 0, 133, 'commented', '', '发的发的顺丰大幅度发\n电饭锅电饭锅地方', '<p>发的发的顺丰大幅度发<br>电饭锅电饭锅地方</p>\n', 1545065921),
(46, 11674, 'issue', 0, 0, 133, 'commented', '', '发的发的顺丰', '<p>发的发的顺丰</p>\n', 1545066007);

-- --------------------------------------------------------

--
-- 表的结构 `main_widget`
--

CREATE TABLE `main_widget` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '工具名称',
  `_key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('list','chart_line','chart_pie','chart_bar','text') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '工具类型',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态（1可用，0不可用）',
  `is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `required_param` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否需要参数才能获取数据',
  `description` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `parameter` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}' COMMENT '支持的参数说明',
  `order_weight` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(22, '迭代-事项统计', 'sprint_issue_type_stat', 'fetchSprintIssueTypeStat', '迭代', 'issue_type_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0);

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
(10004, 0, '项目设置', '可以对项目进行管理,包括设置,事项和评论的管理', 'ADMINISTER_PROJECTS'),
(10005, 0, '访问事项列表', '', 'BROWSE_ISSUES'),
(10006, 0, '创建事项', '', 'CREATE_ISSUES'),
(10007, 0, '添加评论', '', 'ADD_COMMENTS'),
(10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES'),
(10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES'),
(10015, 0, '关闭事项', '项目的所有事项可以关闭,注:关闭功能前端未实现', 'CLOSE_ISSUES'),
(10902, 0, '管理backlog', '', 'MANAGE_BACKLOG'),
(10903, 0, '管理sprint', '', 'MANAGE_SPRINT'),
(10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN'),
(10905, 0, '管理评论', '可以直接编辑和删除项目中的评论', 'MANAGE_COMMENTS');

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
(10000, 'Users', '普通用户', 0),
(10001, 'Developers', '开发者,如程序员，架构师', 0),
(10002, 'Administrators', '项目管理员，如项目经理，技术经理', 0),
(10003, 'QA', '测试工程师', 0),
(10006, 'PO', '产品经理，产品负责人', 0);

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
-- 表的结构 `project_flag`
--

CREATE TABLE `project_flag` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `flag` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `update_time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_flag`
--

INSERT INTO `project_flag` (`id`, `project_id`, `flag`, `value`, `update_time`) VALUES
(1, 3, 'sprint_3_weight', '{\"63\":3800000,\"64\":3700000,\"60\":3600000,\"62\":3500000,\"58\":3400000,\"69\":3300000,\"68\":3200000,\"70\":3100000,\"67\":3000000,\"73\":2900000,\"72\":2800000,\"71\":2700000,\"75\":2600000,\"74\":2500000,\"78\":2400000,\"77\":2300000,\"76\":2200000,\"79\":2100000,\"81\":2000000,\"80\":1900000,\"83\":1800000,\"82\":1700000,\"56\":1600000,\"84\":1500000,\"87\":1400000,\"85\":1300000,\"86\":1200000,\"23\":1100000,\"28\":1000000,\"88\":900000,\"89\":800000,\"92\":700000,\"93\":600000,\"90\":500000,\"94\":400000,\"99\":300000,\"100\":200000,\"101\":100000}', 1542172524),
(2, 3, 'sprint_3_weight', '{\"63\":3800000,\"64\":3700000,\"60\":3600000,\"62\":3500000,\"58\":3400000,\"69\":3300000,\"68\":3200000,\"70\":3100000,\"67\":3000000,\"73\":2900000,\"72\":2800000,\"71\":2700000,\"75\":2600000,\"74\":2500000,\"78\":2400000,\"77\":2300000,\"76\":2200000,\"79\":2100000,\"81\":2000000,\"80\":1900000,\"83\":1800000,\"82\":1700000,\"56\":1600000,\"84\":1500000,\"87\":1400000,\"85\":1300000,\"86\":1200000,\"23\":1100000,\"28\":1000000,\"88\":900000,\"89\":800000,\"92\":700000,\"93\":600000,\"90\":500000,\"94\":400000,\"99\":300000,\"100\":200000,\"101\":100000}', 1542172526),
(3, 3, 'sprint_4_weight', '{\"98\":300000,\"97\":200000,\"102\":100000}', 1542172528),
(4, 3, 'sprint_3_weight', '{\"63\":3800000,\"64\":3700000,\"60\":3600000,\"62\":3500000,\"58\":3400000,\"69\":3300000,\"68\":3200000,\"70\":3100000,\"67\":3000000,\"73\":2900000,\"72\":2800000,\"71\":2700000,\"75\":2600000,\"74\":2500000,\"78\":2400000,\"77\":2300000,\"76\":2200000,\"79\":2100000,\"81\":2000000,\"80\":1900000,\"83\":1800000,\"82\":1700000,\"56\":1600000,\"84\":1500000,\"87\":1400000,\"85\":1300000,\"86\":1200000,\"23\":1100000,\"28\":1000000,\"88\":900000,\"89\":800000,\"92\":700000,\"93\":600000,\"90\":500000,\"94\":400000,\"99\":300000,\"100\":200000,\"101\":100000}', 1542172530),
(5, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542430407),
(6, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542430409),
(7, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1542430431),
(8, 3, 'sprint_4_weight', '{\"98\":300000,\"97\":200000,\"102\":100000}', 1542430432),
(9, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542430433),
(10, 3, 'backlog_weight', '{\"65\":400000,\"59\":300000,\"95\":200000,\"96\":650000,\"99\":450000}', 1542430437),
(11, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542430982),
(12, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542430984),
(13, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542431041),
(14, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542453119),
(15, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542536429),
(16, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542536437),
(17, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1542536439),
(18, 3, 'sprint_4_weight', '{\"98\":300000,\"97\":200000,\"102\":100000}', 1542536439),
(19, 3, 'sprint_3_weight', '{\"63\":3900000,\"64\":3800000,\"60\":3700000,\"62\":3600000,\"58\":3500000,\"69\":3400000,\"68\":3300000,\"70\":3200000,\"67\":3100000,\"73\":3000000,\"72\":2900000,\"71\":2800000,\"75\":2700000,\"74\":2600000,\"78\":2500000,\"77\":2400000,\"76\":2300000,\"79\":2200000,\"81\":2100000,\"80\":2000000,\"83\":1900000,\"82\":1800000,\"56\":1700000,\"84\":1600000,\"87\":1500000,\"85\":1400000,\"86\":1300000,\"23\":1200000,\"28\":1100000,\"88\":1000000,\"89\":900000,\"92\":800000,\"93\":700000,\"90\":600000,\"94\":500000,\"99\":400000,\"100\":300000,\"101\":200000,\"103\":100000}', 1542536440),
(20, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"99\":500000,\"100\":400000,\"101\":300000,\"103\":200000,\"104\":100000}', 1542597002),
(21, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1542705312),
(22, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1542765559),
(23, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542879827),
(24, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542879829),
(25, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1542879833),
(26, 3, 'sprint_4_weight', '{\"64\":500000,\"98\":400000,\"97\":300000,\"102\":200000,\"109\":100000}', 1542879837),
(27, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542879838),
(28, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542879846),
(29, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542879906),
(30, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880442),
(31, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542880443),
(32, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880444),
(33, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880588),
(34, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542880589),
(35, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880591),
(36, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880601),
(37, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542880602),
(38, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880604),
(39, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880685),
(40, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1542880696),
(41, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542880697),
(42, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542902528),
(43, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542902536),
(44, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542903761),
(45, 3, 'backlog_weight', '{\"65\":700000,\"59\":600000,\"95\":500000,\"96\":400000,\"99\":300000,\"108\":200000,\"107\":100000}', 1542956114),
(46, 3, 'sprint_3_weight', '{\"63\":4100000,\"60\":4000000,\"58\":3900000,\"62\":3800000,\"69\":3700000,\"68\":3600000,\"70\":3500000,\"67\":3400000,\"73\":3300000,\"72\":3200000,\"71\":3100000,\"75\":3000000,\"74\":2900000,\"78\":2800000,\"77\":2700000,\"76\":2600000,\"79\":2500000,\"81\":2400000,\"80\":2300000,\"83\":2200000,\"82\":2100000,\"56\":2000000,\"84\":1900000,\"87\":1800000,\"85\":1700000,\"86\":1600000,\"23\":1500000,\"28\":1400000,\"88\":1300000,\"89\":1200000,\"92\":1100000,\"93\":1000000,\"90\":900000,\"94\":800000,\"100\":700000,\"101\":600000,\"103\":500000,\"104\":400000,\"110\":300000,\"105\":200000,\"106\":100000}', 1543314123),
(47, 3, 'sprint_4_weight', '{\"64\":1200000,\"98\":1100000,\"97\":1000000,\"102\":900000,\"109\":800000,\"115\":700000,\"117\":600000,\"116\":500000,\"114\":400000,\"113\":300000,\"112\":200000,\"111\":100000}', 1543314127),
(48, 3, 'sprint_4_weight', '{\"64\":1200000,\"98\":1100000,\"97\":1000000,\"102\":900000,\"109\":800000,\"115\":700000,\"117\":600000,\"116\":500000,\"114\":400000,\"113\":300000,\"112\":200000,\"111\":100000}', 1543314129),
(49, 3, 'sprint_4_weight', '{\"64\":1900000,\"98\":1800000,\"97\":1700000,\"102\":1600000,\"109\":1500000,\"115\":1400000,\"117\":1300000,\"116\":1200000,\"114\":1100000,\"113\":1000000,\"112\":900000,\"111\":800000,\"124\":700000,\"122\":600000,\"120\":500000,\"119\":400000,\"123\":300000,\"121\":200000,\"118\":100000}', 1543316379),
(50, 3, 'sprint_4_weight', '{\"64\":1900000,\"98\":1800000,\"97\":1700000,\"102\":1600000,\"109\":1500000,\"115\":1400000,\"117\":1300000,\"116\":1200000,\"114\":1100000,\"113\":1000000,\"112\":900000,\"111\":800000,\"122\":700000,\"120\":600000,\"119\":500000,\"123\":400000,\"121\":300000,\"118\":200000,\"126\":100000}', 1543317699),
(51, 3, 'sprint_4_weight', '{\"64\":1900000,\"98\":1800000,\"97\":1700000,\"102\":1600000,\"109\":1500000,\"115\":1400000,\"117\":1300000,\"116\":1200000,\"114\":1100000,\"113\":1000000,\"112\":900000,\"111\":800000,\"122\":700000,\"120\":600000,\"119\":500000,\"123\":400000,\"121\":300000,\"118\":200000,\"126\":100000}', 1543317701),
(52, 3, 'sprint_4_weight', '{\"64\":2300000,\"98\":2200000,\"97\":2100000,\"102\":2000000,\"109\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"126\":400000,\"125\":300000,\"108\":200000,\"107\":100000}', 1543370142),
(53, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370720),
(54, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370725),
(55, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370727),
(56, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370729),
(57, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370732),
(58, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370755),
(59, 3, 'sprint_4_weight', '{\"64\":2200000,\"98\":2100000,\"97\":2000000,\"102\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"126\":400000,\"125\":300000,\"108\":200000,\"127\":100000}', 1543370761),
(60, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543370772),
(61, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543372072),
(62, 3, 'sprint_4_weight', '{\"64\":2300000,\"98\":2200000,\"97\":2100000,\"102\":2000000,\"115\":1900000,\"117\":1800000,\"116\":1700000,\"114\":1600000,\"113\":1500000,\"112\":1400000,\"111\":1300000,\"124\":1200000,\"122\":1100000,\"120\":1000000,\"119\":900000,\"123\":800000,\"121\":700000,\"118\":600000,\"126\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543372073),
(63, 3, 'backlog_weight', '{\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543372378),
(64, 3, 'sprint_4_weight', '{\"64\":2300000,\"98\":2200000,\"97\":2100000,\"102\":2000000,\"115\":1900000,\"117\":1800000,\"116\":1700000,\"114\":1600000,\"113\":1500000,\"112\":1400000,\"111\":1300000,\"124\":1200000,\"122\":1100000,\"120\":1000000,\"119\":900000,\"123\":800000,\"121\":700000,\"118\":600000,\"126\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543372379),
(65, 3, 'sprint_4_weight', '{\"98\":2200000,\"97\":2100000,\"102\":2000000,\"115\":1900000,\"117\":1800000,\"116\":1700000,\"114\":1600000,\"113\":1500000,\"112\":1400000,\"111\":1300000,\"124\":1200000,\"122\":1100000,\"120\":1000000,\"119\":900000,\"123\":800000,\"121\":700000,\"118\":600000,\"126\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543372464),
(66, 3, 'sprint_4_weight', '{\"98\":2200000,\"97\":2100000,\"102\":2000000,\"115\":1900000,\"117\":1800000,\"116\":1700000,\"114\":1600000,\"113\":1500000,\"112\":1400000,\"111\":1300000,\"124\":1200000,\"122\":1100000,\"120\":1000000,\"119\":900000,\"123\":800000,\"121\":700000,\"118\":600000,\"126\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373319),
(67, 3, 'sprint_4_weight', '{\"98\":2200000,\"126\":2100000,\"97\":2000000,\"102\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373334),
(68, 3, 'sprint_4_weight', '{\"126\":2100000,\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373394),
(69, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1543373412),
(70, 3, 'sprint_4_weight', '{\"126\":2100000,\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373423),
(71, 3, 'sprint_4_weight', '{\"126\":2100000,\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373427),
(72, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543373438),
(73, 3, 'sprint_4_weight', '{\"126\":2100000,\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373497),
(74, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543373751),
(75, 3, 'sprint_4_weight', '{\"126\":2100000,\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373869),
(76, 3, 'sprint_4_weight', '{\"126\":2100000,\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543373984),
(77, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543394745),
(78, 3, 'sprint_4_weight', '{\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543422333),
(79, 3, 'sprint_4_weight', '{\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543422337),
(80, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543422346),
(81, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543422386),
(82, 3, 'sprint_4_weight', '{\"98\":2000000,\"97\":1900000,\"115\":1800000,\"117\":1700000,\"116\":1600000,\"114\":1500000,\"113\":1400000,\"112\":1300000,\"111\":1200000,\"124\":1100000,\"122\":1000000,\"120\":900000,\"119\":800000,\"123\":700000,\"121\":600000,\"118\":500000,\"125\":400000,\"108\":300000,\"127\":200000,\"128\":100000}', 1543558788),
(83, 1, 'backlog_weight', '{\"3\":100000,\"543\":100000}', 1543569299),
(84, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1543569454),
(85, 3, 'sprint_4_weight', '{\"98\":2000000,\"97\":1900000,\"115\":1800000,\"116\":1700000,\"114\":1600000,\"113\":1500000,\"112\":1400000,\"111\":1300000,\"124\":1200000,\"122\":1100000,\"120\":1000000,\"119\":900000,\"123\":800000,\"121\":700000,\"118\":600000,\"125\":500000,\"108\":400000,\"127\":300000,\"128\":200000,\"106\":100000}', 1543598520),
(86, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543598525),
(87, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543647145),
(88, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543647146),
(89, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543647147),
(90, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543684395),
(91, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543726017),
(92, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543849186),
(93, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543849195),
(94, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543849237),
(95, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543853644),
(96, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543853645),
(97, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543853646),
(98, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543853647),
(99, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1543853649),
(100, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1543853650),
(101, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543853651),
(102, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543853652),
(103, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1543853653),
(104, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1543853654),
(105, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543853654),
(106, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543853656),
(107, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543910307),
(108, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543939912),
(109, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543940514),
(110, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543940800),
(111, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544169091),
(112, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544176442),
(113, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544176551),
(114, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544176557),
(115, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544176562),
(116, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544251706),
(117, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544251708),
(118, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544268331),
(119, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544268333),
(120, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544368808),
(121, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544368824),
(122, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1544368826),
(123, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544368827),
(124, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1544368829),
(125, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1544368830),
(126, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544368830),
(127, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544368894),
(128, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544368937),
(129, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544368989),
(130, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544426161),
(131, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544426164),
(132, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544426166),
(133, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544426173),
(134, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544459477),
(135, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544459479),
(136, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544459900),
(137, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544459902),
(138, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544459922),
(139, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544542202),
(140, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544670382),
(141, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544670384),
(142, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544673584),
(143, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544673592),
(144, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1544770972),
(145, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"113\":2200000,\"114\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544802420),
(146, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"113\":2200000,\"114\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544802428);
INSERT INTO `project_flag` (`id`, `project_id`, `flag`, `value`, `update_time`) VALUES
(147, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1544802441),
(148, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1544802443),
(149, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"113\":2200000,\"114\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544802444),
(150, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"113\":2200000,\"114\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"125\":1200000,\"108\":1100000,\"118\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544899620),
(151, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"113\":2200000,\"114\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"125\":1200000,\"108\":1100000,\"118\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544899623),
(152, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"113\":2200000,\"114\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"125\":1200000,\"108\":1100000,\"118\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1544899630),
(153, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1544985542),
(154, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545037783),
(155, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545066191),
(156, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545066588),
(157, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545066591),
(158, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545066593),
(159, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545066601),
(160, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545066856),
(161, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545067270),
(162, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545067364),
(163, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545067378),
(164, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545067388),
(165, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545067467),
(166, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068335),
(167, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068378),
(168, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068401),
(169, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068421),
(170, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068436),
(171, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068452),
(172, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545068462),
(173, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545068853),
(174, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069080),
(175, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1545069155),
(176, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069158),
(177, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069165),
(178, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1545069170),
(179, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069176),
(180, 3, 'sprint_5_weight', '{\"96\":100000}', 1545069176),
(181, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069179),
(182, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069195),
(183, 3, 'sprint_5_weight', '{\"96\":100000}', 1545069197),
(184, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1545069206),
(185, 3, 'sprint_5_weight', '{\"96\":100000}', 1545069209),
(186, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069289),
(187, 3, 'sprint_5_weight', '{\"96\":100000}', 1545069291),
(188, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069293),
(189, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"99\":200000,\"96\":100000}', 1545069296),
(190, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1545069301),
(191, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"99\":200000,\"96\":100000}', 1545069317),
(192, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069370),
(193, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069384),
(194, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"99\":200000,\"96\":100000}', 1545069385),
(195, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069393),
(196, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069395),
(197, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069403),
(198, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069404),
(199, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069463),
(200, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069466),
(201, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069475),
(202, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069478),
(203, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069479),
(204, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069552),
(205, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069554),
(206, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069558),
(207, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069560),
(208, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545069622),
(209, 3, 'sprint_3_weight', '{\"63\":3900000,\"60\":3800000,\"58\":3700000,\"62\":3600000,\"69\":3500000,\"68\":3400000,\"70\":3300000,\"67\":3200000,\"73\":3100000,\"72\":3000000,\"71\":2900000,\"75\":2800000,\"74\":2700000,\"78\":2600000,\"77\":2500000,\"76\":2400000,\"79\":2300000,\"81\":2200000,\"80\":2100000,\"83\":2000000,\"82\":1900000,\"56\":1800000,\"84\":1700000,\"87\":1600000,\"85\":1500000,\"86\":1400000,\"23\":1300000,\"28\":1200000,\"88\":1100000,\"89\":1000000,\"92\":900000,\"93\":800000,\"90\":700000,\"94\":600000,\"100\":500000,\"101\":400000,\"103\":300000,\"104\":200000,\"105\":100000}', 1545069624),
(210, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069625),
(211, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"99\":200000,\"96\":100000}', 1545069629),
(212, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069633),
(213, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"113\":2000000,\"114\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069667),
(214, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"114\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069739),
(215, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"115\":2200000,\"116\":2100000,\"114\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545069922),
(216, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"99\":200000,\"96\":100000}', 1545069936),
(217, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070023),
(218, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070026),
(219, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070082),
(220, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545070102),
(221, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070103),
(222, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070108),
(223, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545070114),
(224, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070115),
(225, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070118),
(226, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070127),
(227, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070138),
(228, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070148),
(229, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070318),
(230, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070356),
(231, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070359),
(232, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070471),
(233, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070491),
(234, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070509),
(235, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070512),
(236, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070553),
(237, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070554),
(238, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070593),
(239, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070595),
(240, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070704),
(241, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545070708),
(242, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545070726),
(243, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545070773),
(244, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071053),
(245, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071055),
(246, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071096),
(247, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071098),
(248, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071136),
(249, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071138),
(250, 3, 'sprint_2_weight', '{\"16\":4200000,\"15\":4100000,\"13\":4000000,\"14\":3900000,\"26\":3800000,\"24\":3700000,\"10\":3600000,\"22\":3500000,\"21\":3400000,\"19\":3300000,\"9\":3200000,\"20\":3100000,\"11\":3000000,\"27\":2900000,\"25\":2800000,\"32\":2700000,\"35\":2600000,\"34\":2500000,\"33\":2400000,\"31\":2300000,\"37\":2200000,\"38\":2100000,\"39\":2000000,\"40\":1900000,\"43\":1800000,\"44\":1700000,\"42\":1600000,\"41\":1500000,\"47\":1400000,\"48\":1300000,\"46\":1200000,\"51\":1100000,\"50\":1000000,\"49\":900000,\"52\":800000,\"53\":700000,\"54\":600000,\"55\":500000,\"57\":400000,\"66\":300000,\"29\":200000,\"12\":100000}', 1545071141),
(251, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071142),
(252, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071148),
(253, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071154),
(254, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071156),
(255, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"114\":2200000,\"115\":2100000,\"116\":2000000,\"113\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071246),
(256, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071382),
(257, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071422),
(258, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071463),
(259, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071481),
(260, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"113\":2200000,\"114\":2100000,\"115\":2000000,\"116\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071519),
(261, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"113\":2200000,\"114\":2100000,\"115\":2000000,\"116\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071631),
(262, 3, 'sprint_4_weight', '{\"98\":2400000,\"97\":2300000,\"113\":2200000,\"114\":2100000,\"115\":2000000,\"116\":1900000,\"112\":1800000,\"111\":1700000,\"124\":1600000,\"120\":1500000,\"119\":1400000,\"123\":1300000,\"121\":1200000,\"125\":1100000,\"108\":1000000,\"118\":900000,\"127\":800000,\"128\":700000,\"106\":600000,\"134\":500000,\"132\":400000,\"131\":300000,\"133\":200000,\"129\":100000}', 1545071659),
(263, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545071689),
(264, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545072393),
(265, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545072464),
(266, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545072508),
(267, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545072534),
(268, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545072794),
(271, 23, 'backlog_weight', '{\"142\":300000,\"141\":200000,\"140\":100000}', 1545127318),
(272, 29, 'sprint_19_weight', '{\"163\":300000,\"162\":200000,\"161\":100000}', 1545127335),
(273, 46, 'backlog_weight', '{\"171\":300000,\"170\":200000,\"169\":100000}', 1545127528),
(274, 46, 'sprint_26_weight', '{\"172\":100000}', 1545127553),
(275, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545127984),
(276, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"99\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1545127989),
(279, 108, 'backlog_weight', '{\"224\":300000,\"223\":200000,\"222\":100000}', 1545128765),
(280, 114, 'sprint_41_weight', '{\"245\":300000,\"244\":200000,\"243\":100000}', 1545128782),
(281, 131, 'backlog_weight', '{\"253\":300000,\"252\":200000,\"251\":100000}', 1545128990),
(282, 131, 'sprint_48_weight', '{\"254\":100000}', 1545129015),
(285, 193, 'backlog_weight', '{\"305\":300000,\"304\":200000,\"303\":100000}', 1545133169),
(286, 199, 'sprint_63_weight', '{\"326\":300000,\"325\":200000,\"324\":100000}', 1545133186),
(287, 216, 'backlog_weight', '{\"334\":300000,\"333\":200000,\"332\":100000}', 1545133410),
(288, 216, 'sprint_70_weight', '{\"335\":100000}', 1545133437),
(291, 278, 'backlog_weight', '{\"386\":300000,\"385\":200000,\"384\":100000}', 1545134411),
(292, 284, 'sprint_85_weight', '{\"407\":300000,\"406\":200000,\"405\":100000}', 1545134428),
(293, 301, 'backlog_weight', '{\"415\":300000,\"414\":200000,\"413\":100000}', 1545134672),
(294, 301, 'sprint_92_weight', '{\"416\":100000}', 1545134699),
(295, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545140063),
(296, 3, 'backlog_weight', '{\"64\":700000,\"65\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"134\":100000}', 1545144679),
(297, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"99\":600000,\"59\":500000,\"95\":400000,\"96\":300000,\"134\":200000,\"133\":100000}', 1545144899),
(298, 3, 'sprint_4_weight', '{\"98\":2300000,\"97\":2200000,\"113\":2100000,\"114\":2000000,\"115\":1900000,\"116\":1800000,\"112\":1700000,\"111\":1600000,\"124\":1500000,\"120\":1400000,\"119\":1300000,\"123\":1200000,\"121\":1100000,\"125\":1000000,\"108\":900000,\"118\":800000,\"127\":700000,\"128\":600000,\"106\":500000,\"132\":400000,\"131\":300000,\"129\":200000,\"217\":100000}', 1545144901),
(299, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"99\":600000,\"59\":500000,\"95\":400000,\"96\":300000,\"134\":200000,\"133\":100000}', 1545144902),
(300, 3, 'sprint_4_weight', '{\"98\":2300000,\"97\":2200000,\"113\":2100000,\"114\":2000000,\"115\":1900000,\"116\":1800000,\"112\":1700000,\"111\":1600000,\"124\":1500000,\"120\":1400000,\"119\":1300000,\"123\":1200000,\"121\":1100000,\"125\":1000000,\"108\":900000,\"118\":800000,\"127\":700000,\"128\":600000,\"106\":500000,\"132\":400000,\"131\":300000,\"129\":200000,\"217\":100000}', 1545144905),
(301, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545144906),
(302, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545153956),
(303, 3, 'sprint_4_weight', '{\"98\":2300000,\"97\":2200000,\"113\":2100000,\"114\":2000000,\"115\":1900000,\"116\":1800000,\"112\":1700000,\"111\":1600000,\"124\":1500000,\"120\":1400000,\"119\":1300000,\"123\":1200000,\"121\":1100000,\"125\":1000000,\"108\":900000,\"118\":800000,\"127\":700000,\"128\":600000,\"106\":500000,\"132\":400000,\"131\":300000,\"129\":200000,\"217\":100000}', 1545153960),
(304, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545153962),
(307, 363, 'backlog_weight', '{\"467\":300000,\"466\":200000,\"465\":100000}', 1545154460),
(308, 369, 'sprint_107_weight', '{\"488\":300000,\"487\":200000,\"486\":100000}', 1545154477),
(309, 386, 'backlog_weight', '{\"496\":300000,\"495\":200000,\"494\":100000}', 1545154739),
(310, 386, 'sprint_114_weight', '{\"497\":100000}', 1545154765),
(311, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545181472),
(312, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545182755),
(313, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545187772),
(314, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545187775),
(315, 431, 'backlog_weight', '{\"542\":100000}', 1545188244),
(316, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545193967),
(317, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545194226),
(318, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545194233),
(319, 3, 'sprint_4_weight', '{\"98\":2200000,\"97\":2100000,\"113\":2000000,\"114\":1900000,\"115\":1800000,\"116\":1700000,\"112\":1600000,\"111\":1500000,\"124\":1400000,\"120\":1300000,\"119\":1200000,\"123\":1100000,\"121\":1000000,\"125\":900000,\"108\":800000,\"118\":700000,\"127\":600000,\"128\":500000,\"106\":400000,\"132\":300000,\"131\":200000,\"129\":100000}', 1545194236),
(320, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545194240),
(321, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545197205),
(322, 2, 'backlog_weight', '{\"4\":100000}', 1545197238),
(323, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545199673),
(324, 1, 'backlog_weight', '{\"3\":200000,\"543\":100000}', 1545205509),
(325, 1, 'backlog_weight', '{\"3\":200000,\"543\":100000}', 1545205522),
(326, 1, 'backlog_weight', '{\"3\":200000,\"543\":100000}', 1545205559),
(327, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1545205564),
(328, 1, 'backlog_weight', '{\"3\":200000,\"543\":100000}', 1545205573),
(331, 452, 'backlog_weight', '{\"550\":300000,\"549\":200000,\"548\":100000}', 1545206642),
(332, 458, 'sprint_130_weight', '{\"571\":300000,\"570\":200000,\"569\":100000}', 1545206659),
(333, 475, 'backlog_weight', '{\"579\":300000,\"578\":200000,\"577\":100000}', 1545207046),
(334, 475, 'sprint_137_weight', '{\"580\":100000}', 1545207072),
(337, 537, 'backlog_weight', '{\"631\":300000,\"630\":200000,\"629\":100000}', 1545209087),
(338, 543, 'sprint_152_weight', '{\"652\":300000,\"651\":200000,\"650\":100000}', 1545209104),
(339, 560, 'backlog_weight', '{\"660\":300000,\"659\":200000,\"658\":100000}', 1545209520),
(340, 560, 'sprint_159_weight', '{\"661\":100000}', 1545209546),
(341, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545215849),
(342, 3, 'sprint_4_weight', '{\"98\":2200000,\"97\":2100000,\"113\":2000000,\"114\":1900000,\"115\":1800000,\"116\":1700000,\"112\":1600000,\"111\":1500000,\"124\":1400000,\"120\":1300000,\"119\":1200000,\"123\":1100000,\"121\":1000000,\"125\":900000,\"108\":800000,\"118\":700000,\"127\":600000,\"128\":500000,\"106\":400000,\"132\":300000,\"131\":200000,\"129\":100000}', 1545215849),
(343, 3, 'backlog_weight', '{\"64\":800000,\"65\":700000,\"96\":600000,\"99\":500000,\"59\":400000,\"95\":300000,\"134\":200000,\"133\":100000}', 1545215850);

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
(13, 2, 1),
(14, 2, 2),
(15, 2, 3),
(16, 2, 4),
(17, 2, 5),
(22, 2, 90),
(27, 2, 175),
(32, 2, 264),
(37, 2, 345),
(42, 2, 430),
(43, 3, 431),
(44, 5, 432),
(45, 3, 433),
(46, 2, 434),
(51, 2, 519),
(56, 2, 604);

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
(3, 0, 'Warn', '#FFFFFF', '#F0AD4E');

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
(1, 10, 5, '敏捷开发项目总数'),
(2, 20, 7, '看板开发项目总数'),
(3, 30, 2, '软件开发项目总数'),
(4, 40, 0, '项目管理项目总数'),
(5, 50, 0, '流程管理项目总数'),
(6, 60, 1, '任务管理项目总数');

-- --------------------------------------------------------

--
-- 表的结构 `project_main`
--

CREATE TABLE `project_main` (
  `id` int(10) UNSIGNED NOT NULL,
  `org_id` int(11) NOT NULL DEFAULT '1',
  `org_path` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead` int(11) UNSIGNED DEFAULT '0',
  `description` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pcounter` decimal(18,0) DEFAULT NULL,
  `default_assignee` int(11) UNSIGNED DEFAULT '0',
  `assignee_type` int(11) DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) UNSIGNED DEFAULT NULL,
  `type` tinyint(2) DEFAULT '1',
  `type_child` tinyint(2) DEFAULT '0',
  `permission_scheme_id` int(11) UNSIGNED DEFAULT '0',
  `workflow_scheme_id` int(11) UNSIGNED NOT NULL,
  `create_uid` int(11) UNSIGNED DEFAULT '0',
  `create_time` int(11) UNSIGNED DEFAULT '0',
  `un_done_count` int(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '未完成事项数',
  `done_count` int(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '已经完成事项数',
  `closed_count` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `project_main`
--

INSERT INTO `project_main` (`id`, `org_id`, `org_path`, `name`, `url`, `lead`, `description`, `key`, `pcounter`, `default_assignee`, `assignee_type`, `avatar`, `category`, `type`, `type_child`, `permission_scheme_id`, `workflow_scheme_id`, `create_uid`, `create_time`, `un_done_count`, `done_count`, `closed_count`) VALUES
(1, 1, 'default', '客户管理crm系统', '', 10000, '                                                                                                                                                                                                                基于人工智能的客户关系管理系统                                                                                                                                                                                                ', 'CRM', NULL, 1, NULL, 'avatar/20181017/20181017180352_48634.jpg', 0, 10, 0, 0, 0, 10000, 1536553005, 1, 2, 1),
(2, 1, 'default', 'ERP系统实施', '', 10000, '                                                    公司内部ERP项目的实施                                                ', 'ERP', NULL, 1, NULL, 'avatar/20180913/20180913144752_28827.jpg', 0, 10, 0, 0, 0, 10000, 1536821242, 1, 0, 0),
(3, 1, 'default', 'Masterlab-Development', 'http://master.888zb.com/about.php', 10000, 'Masterlab的项目管理', 'DEV', NULL, 1, NULL, 'avatar/20181015/20181015102601_18003.png', 0, 10, 0, 0, 0, 10000, 1539089761, 24, 91, 8);

-- --------------------------------------------------------

--
-- 表的结构 `project_main_extra`
--

CREATE TABLE `project_main_extra` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT '0',
  `detail` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `project_main_extra`
--

INSERT INTO `project_main_extra` (`id`, `project_id`, `detail`) VALUES
(1, 35, 'test-detail'),
(2, 90, 'MzXAAPA3po'),
(3, 120, 'test-detail'),
(4, 175, '7oyq3Tpis3'),
(5, 205, 'test-detail'),
(6, 264, 'FYIljv18U7'),
(7, 290, 'test-detail'),
(8, 345, 'fBjPqQiWne'),
(9, 375, 'test-detail'),
(10, 430, '6I23Efq2PX'),
(11, 431, ''),
(12, 432, 'a'),
(13, 433, ''),
(14, 434, '明媚'),
(15, 464, 'test-detail'),
(16, 519, 'Ep1SaDfl4w'),
(17, 549, 'test-detail'),
(18, 604, 'jxXs79uLYC');

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

--
-- 转存表中的数据 `project_module`
--

INSERT INTO `project_module` (`id`, `project_id`, `name`, `description`, `lead`, `default_assignee`, `ctime`) VALUES
(1, 1, '用户', '用户模块', 0, 11652, 1536768892),
(2, 1, '客户', '客户模块', 11653, 10000, 1536768976),
(3, 1, '系统', ' ', 0, 0, 1536805496),
(4, 3, '用户', '', 0, 0, 1539091728),
(5, 3, '首页', '首页相关的功能', 0, 0, 1539091739),
(6, 3, '敏捷', '包括待办事项,迭代,看板', 0, 0, 1539091785),
(7, 3, '项目信息', '', 0, 0, 1539091820),
(8, 3, '项目设置', '', 0, 0, 1539091825),
(9, 3, '组织', '', 0, 0, 1539091850),
(10, 3, '统计报表', '', 0, 0, 1539091872),
(11, 3, '事项', '跟项目事项相关列表，表单，详情等功能', 0, 0, 1539091924),
(12, 3, '系统-事项', '', 0, 0, 1539091985),
(13, 3, '系统-基本信息', '', 0, 0, 1539091991),
(14, 3, '系统-项目', '', 0, 0, 1539091997),
(15, 3, '系统-用户', '', 0, 0, 1539092002),
(23, 31, 'test-name', 'test-description', 0, 0, 0),
(31, 0, 'test-name', 'test-description', 0, 0, 0),
(39, 116, 'test-name', 'test-description', 0, 0, 0),
(47, 0, 'test-name', 'test-description', 0, 0, 0),
(55, 201, 'test-name', 'test-description', 0, 0, 0),
(63, 0, 'test-name', 'test-description', 0, 0, 0),
(71, 286, 'test-name', 'test-description', 0, 0, 0),
(79, 0, 'test-name', 'test-description', 0, 0, 0),
(87, 371, 'test-name', 'test-description', 0, 0, 0),
(95, 0, 'test-name', 'test-description', 0, 0, 0),
(103, 460, 'test-name', 'test-description', 0, 0, 0),
(111, 0, 'test-name', 'test-description', 0, 0, 0),
(119, 545, 'test-name', 'test-description', 0, 0, 0),
(127, 0, 'test-name', 'test-description', 0, 0, 0);

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
(5, 1, 'PO', NULL, 1),
(6, 2, 'Users', 'A project role that represents users in a project', 1),
(7, 2, 'Developers', 'A project role that represents developers in a project', 1),
(8, 2, 'Administrators', 'A project role that represents administrators in a project', 1),
(9, 2, 'QA', NULL, 1),
(10, 2, 'PO', NULL, 1),
(11, 3, 'Users', 'A project role that represents users in a project', 1),
(12, 3, 'Developers', 'A project role that represents developers in a project', 1),
(13, 3, 'Administrators', 'A project role that represents administrators in a project', 1),
(14, 3, 'QA', NULL, 1),
(15, 3, 'PO', NULL, 1),
(16, 4, 'Users', 'A project role that represents users in a project', 1),
(17, 4, 'Developers', 'A project role that represents developers in a project', 1),
(18, 4, 'Administrators', 'A project role that represents administrators in a project', 1),
(19, 4, 'QA', NULL, 1),
(20, 4, 'PO', NULL, 1),
(21, 5, 'Users', '普通用户', 1),
(22, 5, 'Developers', '开发者,如程序员，架构师', 1),
(23, 5, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(24, 5, 'QA', '测试工程师', 1),
(25, 5, 'PO', '产品经理，产品负责人', 1),
(37, 90, 'Users', '普通用户', 1),
(38, 90, 'Developers', '开发者,如程序员，架构师', 1),
(39, 90, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(40, 90, 'QA', '测试工程师', 1),
(41, 90, 'PO', '产品经理，产品负责人', 1),
(53, 175, 'Users', '普通用户', 1),
(54, 175, 'Developers', '开发者,如程序员，架构师', 1),
(55, 175, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(56, 175, 'QA', '测试工程师', 1),
(57, 175, 'PO', '产品经理，产品负责人', 1),
(69, 264, 'Users', '普通用户', 1),
(70, 264, 'Developers', '开发者,如程序员，架构师', 1),
(71, 264, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(72, 264, 'QA', '测试工程师', 1),
(73, 264, 'PO', '产品经理，产品负责人', 1),
(85, 345, 'Users', '普通用户', 1),
(86, 345, 'Developers', '开发者,如程序员，架构师', 1),
(87, 345, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(88, 345, 'QA', '测试工程师', 1),
(89, 345, 'PO', '产品经理，产品负责人', 1),
(101, 430, 'Users', '普通用户', 1),
(102, 430, 'Developers', '开发者,如程序员，架构师', 1),
(103, 430, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(104, 430, 'QA', '测试工程师', 1),
(105, 430, 'PO', '产品经理，产品负责人', 1),
(106, 431, 'Users', '普通用户', 1),
(107, 431, 'Developers', '开发者,如程序员，架构师', 1),
(108, 431, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(109, 431, 'QA', '测试工程师', 1),
(110, 431, 'PO', '产品经理，产品负责人', 1),
(111, 432, 'Users', '普通用户', 1),
(112, 432, 'Developers', '开发者,如程序员，架构师', 1),
(113, 432, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(114, 432, 'QA', '测试工程师', 1),
(115, 432, 'PO', '产品经理，产品负责人', 1),
(116, 433, 'Users', '普通用户', 1),
(117, 433, 'Developers', '开发者,如程序员，架构师', 1),
(118, 433, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(119, 433, 'QA', '测试工程师', 1),
(120, 433, 'PO', '产品经理，产品负责人', 1),
(121, 434, 'Users', '普通用户', 1),
(122, 434, 'Developers', '开发者,如程序员，架构师', 1),
(123, 434, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(124, 434, 'QA', '测试工程师', 1),
(125, 434, 'PO', '产品经理，产品负责人', 1),
(137, 519, 'Users', '普通用户', 1),
(138, 519, 'Developers', '开发者,如程序员，架构师', 1),
(139, 519, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(140, 519, 'QA', '测试工程师', 1),
(141, 519, 'PO', '产品经理，产品负责人', 1),
(153, 604, 'Users', '普通用户', 1),
(154, 604, 'Developers', '开发者,如程序员，架构师', 1),
(155, 604, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(156, 604, 'QA', '测试工程师', 1),
(157, 604, 'PO', '产品经理，产品负责人', 1);

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
(37, 1, 5, 10904),
(38, 2, 6, 10005),
(39, 2, 6, 10006),
(40, 2, 6, 10007),
(41, 2, 6, 10008),
(42, 2, 6, 10013),
(43, 2, 7, 10005),
(44, 2, 7, 10006),
(45, 2, 7, 10007),
(46, 2, 7, 10008),
(47, 2, 7, 10013),
(48, 2, 7, 10014),
(49, 2, 7, 10015),
(50, 2, 7, 10028),
(51, 2, 8, 10004),
(52, 2, 8, 10005),
(53, 2, 8, 10006),
(54, 2, 8, 10007),
(55, 2, 8, 10008),
(56, 2, 8, 10013),
(57, 2, 8, 10014),
(58, 2, 8, 10015),
(59, 2, 8, 10028),
(60, 2, 8, 10902),
(61, 2, 8, 10903),
(62, 2, 8, 10904),
(63, 2, 10, 10004),
(64, 2, 10, 10005),
(65, 2, 10, 10006),
(66, 2, 10, 10007),
(67, 2, 10, 10008),
(68, 2, 10, 10013),
(69, 2, 10, 10014),
(70, 2, 10, 10015),
(71, 2, 10, 10028),
(72, 2, 10, 10902),
(73, 2, 10, 10903),
(74, 2, 10, 10904),
(75, 3, 11, 10005),
(76, 3, 11, 10006),
(77, 3, 11, 10007),
(78, 3, 11, 10008),
(79, 3, 11, 10013),
(660, 3, 12, 10005),
(661, 3, 12, 10006),
(662, 3, 12, 10007),
(663, 3, 12, 10013),
(664, 3, 12, 10014),
(665, 3, 12, 10904),
(88, 3, 13, 10004),
(89, 3, 13, 10005),
(90, 3, 13, 10006),
(91, 3, 13, 10007),
(92, 3, 13, 10008),
(93, 3, 13, 10013),
(94, 3, 13, 10014),
(95, 3, 13, 10015),
(96, 3, 13, 10028),
(97, 3, 13, 10902),
(98, 3, 13, 10903),
(99, 3, 13, 10904),
(100, 3, 15, 10004),
(101, 3, 15, 10005),
(102, 3, 15, 10006),
(103, 3, 15, 10007),
(104, 3, 15, 10008),
(105, 3, 15, 10013),
(106, 3, 15, 10014),
(107, 3, 15, 10015),
(108, 3, 15, 10028),
(109, 3, 15, 10902),
(110, 3, 15, 10903),
(111, 3, 15, 10904),
(112, 4, 16, 10005),
(113, 4, 16, 10006),
(114, 4, 16, 10007),
(115, 4, 16, 10008),
(116, 4, 16, 10013),
(117, 4, 17, 10005),
(118, 4, 17, 10006),
(119, 4, 17, 10007),
(120, 4, 17, 10008),
(121, 4, 17, 10013),
(122, 4, 17, 10014),
(123, 4, 17, 10015),
(124, 4, 17, 10028),
(125, 4, 18, 10004),
(126, 4, 18, 10005),
(127, 4, 18, 10006),
(128, 4, 18, 10007),
(129, 4, 18, 10008),
(130, 4, 18, 10013),
(131, 4, 18, 10014),
(132, 4, 18, 10015),
(133, 4, 18, 10028),
(134, 4, 18, 10902),
(135, 4, 18, 10903),
(136, 4, 18, 10904),
(137, 4, 20, 10004),
(138, 4, 20, 10005),
(139, 4, 20, 10006),
(140, 4, 20, 10007),
(141, 4, 20, 10008),
(142, 4, 20, 10013),
(143, 4, 20, 10014),
(144, 4, 20, 10015),
(145, 4, 20, 10028),
(146, 4, 20, 10902),
(147, 4, 20, 10903),
(148, 4, 20, 10904),
(149, 5, 21, 10005),
(150, 5, 21, 10006),
(151, 5, 21, 10007),
(152, 5, 21, 10008),
(153, 5, 21, 10013),
(154, 5, 22, 10005),
(155, 5, 22, 10006),
(156, 5, 22, 10007),
(157, 5, 22, 10008),
(158, 5, 22, 10013),
(159, 5, 22, 10014),
(160, 5, 22, 10015),
(161, 5, 22, 10028),
(162, 5, 23, 10004),
(163, 5, 23, 10005),
(164, 5, 23, 10006),
(165, 5, 23, 10007),
(166, 5, 23, 10008),
(167, 5, 23, 10013),
(168, 5, 23, 10014),
(169, 5, 23, 10015),
(170, 5, 23, 10028),
(171, 5, 23, 10902),
(172, 5, 23, 10903),
(173, 5, 23, 10904),
(174, 5, 25, 10004),
(175, 5, 25, 10005),
(176, 5, 25, 10006),
(177, 5, 25, 10007),
(178, 5, 25, 10008),
(179, 5, 25, 10013),
(180, 5, 25, 10014),
(181, 5, 25, 10015),
(182, 5, 25, 10028),
(183, 5, 25, 10902),
(184, 5, 25, 10903),
(185, 5, 25, 10904),
(315, 90, 37, 10005),
(316, 90, 37, 10006),
(317, 90, 37, 10007),
(318, 90, 37, 10008),
(319, 90, 37, 10013),
(320, 90, 38, 10005),
(321, 90, 38, 10006),
(322, 90, 38, 10007),
(323, 90, 38, 10008),
(324, 90, 38, 10013),
(325, 90, 38, 10014),
(326, 90, 38, 10015),
(327, 90, 38, 10028),
(328, 90, 39, 10004),
(329, 90, 39, 10005),
(330, 90, 39, 10006),
(331, 90, 39, 10007),
(332, 90, 39, 10008),
(333, 90, 39, 10013),
(334, 90, 39, 10014),
(335, 90, 39, 10015),
(336, 90, 39, 10028),
(337, 90, 39, 10902),
(338, 90, 39, 10903),
(339, 90, 39, 10904),
(340, 90, 41, 10004),
(341, 90, 41, 10005),
(342, 90, 41, 10006),
(343, 90, 41, 10007),
(344, 90, 41, 10008),
(345, 90, 41, 10013),
(346, 90, 41, 10014),
(347, 90, 41, 10015),
(348, 90, 41, 10028),
(349, 90, 41, 10902),
(350, 90, 41, 10903),
(351, 90, 41, 10904),
(392, 175, 53, 10005),
(393, 175, 53, 10006),
(394, 175, 53, 10007),
(395, 175, 53, 10008),
(396, 175, 53, 10013),
(397, 175, 54, 10005),
(398, 175, 54, 10006),
(399, 175, 54, 10007),
(400, 175, 54, 10008),
(401, 175, 54, 10013),
(402, 175, 54, 10014),
(403, 175, 54, 10015),
(404, 175, 54, 10028),
(405, 175, 55, 10004),
(406, 175, 55, 10005),
(407, 175, 55, 10006),
(408, 175, 55, 10007),
(409, 175, 55, 10008),
(410, 175, 55, 10013),
(411, 175, 55, 10014),
(412, 175, 55, 10015),
(413, 175, 55, 10028),
(414, 175, 55, 10902),
(415, 175, 55, 10903),
(416, 175, 55, 10904),
(417, 175, 57, 10004),
(418, 175, 57, 10005),
(419, 175, 57, 10006),
(420, 175, 57, 10007),
(421, 175, 57, 10008),
(422, 175, 57, 10013),
(423, 175, 57, 10014),
(424, 175, 57, 10015),
(425, 175, 57, 10028),
(426, 175, 57, 10902),
(427, 175, 57, 10903),
(428, 175, 57, 10904),
(469, 264, 69, 10005),
(470, 264, 69, 10006),
(471, 264, 69, 10007),
(472, 264, 69, 10008),
(473, 264, 69, 10013),
(474, 264, 70, 10005),
(475, 264, 70, 10006),
(476, 264, 70, 10007),
(477, 264, 70, 10008),
(478, 264, 70, 10013),
(479, 264, 70, 10014),
(480, 264, 70, 10015),
(481, 264, 70, 10028),
(482, 264, 71, 10004),
(483, 264, 71, 10005),
(484, 264, 71, 10006),
(485, 264, 71, 10007),
(486, 264, 71, 10008),
(487, 264, 71, 10013),
(488, 264, 71, 10014),
(489, 264, 71, 10015),
(490, 264, 71, 10028),
(491, 264, 71, 10902),
(492, 264, 71, 10903),
(493, 264, 71, 10904),
(494, 264, 73, 10004),
(495, 264, 73, 10005),
(496, 264, 73, 10006),
(497, 264, 73, 10007),
(498, 264, 73, 10008),
(499, 264, 73, 10013),
(500, 264, 73, 10014),
(501, 264, 73, 10015),
(502, 264, 73, 10028),
(503, 264, 73, 10902),
(504, 264, 73, 10903),
(505, 264, 73, 10904),
(546, 345, 85, 10005),
(547, 345, 85, 10006),
(548, 345, 85, 10007),
(549, 345, 85, 10008),
(550, 345, 85, 10013),
(551, 345, 86, 10005),
(552, 345, 86, 10006),
(553, 345, 86, 10007),
(554, 345, 86, 10008),
(555, 345, 86, 10013),
(556, 345, 86, 10014),
(557, 345, 86, 10015),
(558, 345, 86, 10028),
(559, 345, 87, 10004),
(560, 345, 87, 10005),
(561, 345, 87, 10006),
(562, 345, 87, 10007),
(563, 345, 87, 10008),
(564, 345, 87, 10013),
(565, 345, 87, 10014),
(566, 345, 87, 10015),
(567, 345, 87, 10028),
(568, 345, 87, 10902),
(569, 345, 87, 10903),
(570, 345, 87, 10904),
(571, 345, 89, 10004),
(572, 345, 89, 10005),
(573, 345, 89, 10006),
(574, 345, 89, 10007),
(575, 345, 89, 10008),
(576, 345, 89, 10013),
(577, 345, 89, 10014),
(578, 345, 89, 10015),
(579, 345, 89, 10028),
(580, 345, 89, 10902),
(581, 345, 89, 10903),
(582, 345, 89, 10904),
(623, 430, 101, 10005),
(624, 430, 101, 10006),
(625, 430, 101, 10007),
(626, 430, 101, 10008),
(627, 430, 101, 10013),
(628, 430, 102, 10005),
(629, 430, 102, 10006),
(630, 430, 102, 10007),
(631, 430, 102, 10008),
(632, 430, 102, 10013),
(633, 430, 102, 10014),
(634, 430, 102, 10015),
(635, 430, 102, 10028),
(636, 430, 103, 10004),
(637, 430, 103, 10005),
(638, 430, 103, 10006),
(639, 430, 103, 10007),
(640, 430, 103, 10008),
(641, 430, 103, 10013),
(642, 430, 103, 10014),
(643, 430, 103, 10015),
(644, 430, 103, 10028),
(645, 430, 103, 10902),
(646, 430, 103, 10903),
(647, 430, 103, 10904),
(648, 430, 105, 10004),
(649, 430, 105, 10005),
(650, 430, 105, 10006),
(651, 430, 105, 10007),
(652, 430, 105, 10008),
(653, 430, 105, 10013),
(654, 430, 105, 10014),
(655, 430, 105, 10015),
(656, 430, 105, 10028),
(657, 430, 105, 10902),
(658, 430, 105, 10903),
(659, 430, 105, 10904),
(666, 431, 106, 10005),
(667, 431, 106, 10006),
(668, 431, 106, 10007),
(669, 431, 106, 10008),
(670, 431, 106, 10013),
(671, 431, 107, 10005),
(672, 431, 107, 10006),
(673, 431, 107, 10007),
(674, 431, 107, 10008),
(675, 431, 107, 10013),
(676, 431, 107, 10014),
(677, 431, 107, 10015),
(678, 431, 107, 10028),
(679, 431, 108, 10004),
(680, 431, 108, 10005),
(681, 431, 108, 10006),
(682, 431, 108, 10007),
(683, 431, 108, 10008),
(684, 431, 108, 10013),
(685, 431, 108, 10014),
(686, 431, 108, 10015),
(687, 431, 108, 10028),
(688, 431, 108, 10902),
(689, 431, 108, 10903),
(690, 431, 108, 10904),
(691, 431, 110, 10004),
(692, 431, 110, 10005),
(693, 431, 110, 10006),
(694, 431, 110, 10007),
(695, 431, 110, 10008),
(696, 431, 110, 10013),
(697, 431, 110, 10014),
(698, 431, 110, 10015),
(699, 431, 110, 10028),
(700, 431, 110, 10902),
(701, 431, 110, 10903),
(702, 431, 110, 10904),
(703, 432, 111, 10005),
(704, 432, 111, 10006),
(705, 432, 111, 10007),
(706, 432, 111, 10008),
(707, 432, 111, 10013),
(708, 432, 112, 10005),
(709, 432, 112, 10006),
(710, 432, 112, 10007),
(711, 432, 112, 10008),
(712, 432, 112, 10013),
(713, 432, 112, 10014),
(714, 432, 112, 10015),
(715, 432, 112, 10028),
(716, 432, 113, 10004),
(717, 432, 113, 10005),
(718, 432, 113, 10006),
(719, 432, 113, 10007),
(720, 432, 113, 10008),
(721, 432, 113, 10013),
(722, 432, 113, 10014),
(723, 432, 113, 10015),
(724, 432, 113, 10028),
(725, 432, 113, 10902),
(726, 432, 113, 10903),
(727, 432, 113, 10904),
(728, 432, 115, 10004),
(729, 432, 115, 10005),
(730, 432, 115, 10006),
(731, 432, 115, 10007),
(732, 432, 115, 10008),
(733, 432, 115, 10013),
(734, 432, 115, 10014),
(735, 432, 115, 10015),
(736, 432, 115, 10028),
(737, 432, 115, 10902),
(738, 432, 115, 10903),
(739, 432, 115, 10904),
(740, 433, 116, 10005),
(741, 433, 116, 10006),
(742, 433, 116, 10007),
(743, 433, 116, 10008),
(744, 433, 116, 10013),
(745, 433, 117, 10005),
(746, 433, 117, 10006),
(747, 433, 117, 10007),
(748, 433, 117, 10008),
(749, 433, 117, 10013),
(750, 433, 117, 10014),
(751, 433, 117, 10015),
(752, 433, 117, 10028),
(753, 433, 118, 10004),
(754, 433, 118, 10005),
(755, 433, 118, 10006),
(756, 433, 118, 10007),
(757, 433, 118, 10008),
(758, 433, 118, 10013),
(759, 433, 118, 10014),
(760, 433, 118, 10015),
(761, 433, 118, 10028),
(762, 433, 118, 10902),
(763, 433, 118, 10903),
(764, 433, 118, 10904),
(765, 433, 120, 10004),
(766, 433, 120, 10005),
(767, 433, 120, 10006),
(768, 433, 120, 10007),
(769, 433, 120, 10008),
(770, 433, 120, 10013),
(771, 433, 120, 10014),
(772, 433, 120, 10015),
(773, 433, 120, 10028),
(774, 433, 120, 10902),
(775, 433, 120, 10903),
(776, 433, 120, 10904),
(777, 434, 121, 10005),
(778, 434, 121, 10006),
(779, 434, 121, 10007),
(780, 434, 121, 10008),
(781, 434, 121, 10013),
(782, 434, 122, 10005),
(783, 434, 122, 10006),
(784, 434, 122, 10007),
(785, 434, 122, 10008),
(786, 434, 122, 10013),
(787, 434, 122, 10014),
(788, 434, 122, 10015),
(789, 434, 122, 10028),
(790, 434, 123, 10004),
(791, 434, 123, 10005),
(792, 434, 123, 10006),
(793, 434, 123, 10007),
(794, 434, 123, 10008),
(795, 434, 123, 10013),
(796, 434, 123, 10014),
(797, 434, 123, 10015),
(798, 434, 123, 10028),
(799, 434, 123, 10902),
(800, 434, 123, 10903),
(801, 434, 123, 10904),
(802, 434, 125, 10004),
(803, 434, 125, 10005),
(804, 434, 125, 10006),
(805, 434, 125, 10007),
(806, 434, 125, 10008),
(807, 434, 125, 10013),
(808, 434, 125, 10014),
(809, 434, 125, 10015),
(810, 434, 125, 10028),
(811, 434, 125, 10902),
(812, 434, 125, 10903),
(813, 434, 125, 10904),
(854, 519, 137, 10005),
(855, 519, 137, 10006),
(856, 519, 137, 10007),
(857, 519, 137, 10008),
(858, 519, 137, 10013),
(859, 519, 138, 10005),
(860, 519, 138, 10006),
(861, 519, 138, 10007),
(862, 519, 138, 10008),
(863, 519, 138, 10013),
(864, 519, 138, 10014),
(865, 519, 138, 10015),
(866, 519, 138, 10028),
(867, 519, 139, 10004),
(868, 519, 139, 10005),
(869, 519, 139, 10006),
(870, 519, 139, 10007),
(871, 519, 139, 10008),
(872, 519, 139, 10013),
(873, 519, 139, 10014),
(874, 519, 139, 10015),
(875, 519, 139, 10028),
(876, 519, 139, 10902),
(877, 519, 139, 10903),
(878, 519, 139, 10904),
(879, 519, 141, 10004),
(880, 519, 141, 10005),
(881, 519, 141, 10006),
(882, 519, 141, 10007),
(883, 519, 141, 10008),
(884, 519, 141, 10013),
(885, 519, 141, 10014),
(886, 519, 141, 10015),
(887, 519, 141, 10028),
(888, 519, 141, 10902),
(889, 519, 141, 10903),
(890, 519, 141, 10904),
(931, 604, 153, 10005),
(932, 604, 153, 10006),
(933, 604, 153, 10007),
(934, 604, 153, 10008),
(935, 604, 153, 10013),
(936, 604, 154, 10005),
(937, 604, 154, 10006),
(938, 604, 154, 10007),
(939, 604, 154, 10008),
(940, 604, 154, 10013),
(941, 604, 154, 10014),
(942, 604, 154, 10015),
(943, 604, 154, 10028),
(944, 604, 155, 10004),
(945, 604, 155, 10005),
(946, 604, 155, 10006),
(947, 604, 155, 10007),
(948, 604, 155, 10008),
(949, 604, 155, 10013),
(950, 604, 155, 10014),
(951, 604, 155, 10015),
(952, 604, 155, 10028),
(953, 604, 155, 10902),
(954, 604, 155, 10903),
(955, 604, 155, 10904),
(956, 604, 157, 10004),
(957, 604, 157, 10005),
(958, 604, 157, 10006),
(959, 604, 157, 10007),
(960, 604, 157, 10008),
(961, 604, 157, 10013),
(962, 604, 157, 10014),
(963, 604, 157, 10015),
(964, 604, 157, 10028),
(965, 604, 157, 10902),
(966, 604, 157, 10903),
(967, 604, 157, 10904);

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

--
-- 转存表中的数据 `project_user_role`
--

INSERT INTO `project_user_role` (`id`, `user_id`, `project_id`, `role_id`) VALUES
(609, 11674, 3, 12),
(74, 11735, 86, 5),
(75, 11735, 86, 6),
(76, 11735, 86, 7),
(77, 11735, 86, 8),
(78, 11735, 86, 9),
(79, 11735, 86, 10),
(80, 11735, 86, 11),
(82, 11735, 86, 13),
(83, 11735, 86, 14),
(84, 11735, 86, 15),
(90, 11735, 86, 21),
(91, 11735, 86, 22),
(92, 11735, 86, 23),
(93, 11735, 86, 24),
(94, 11735, 86, 25),
(171, 11811, 171, 1),
(172, 11811, 171, 2),
(173, 11811, 171, 3),
(174, 11811, 171, 4),
(175, 11811, 171, 5),
(176, 11811, 171, 6),
(177, 11811, 171, 7),
(178, 11811, 171, 8),
(179, 11811, 171, 9),
(180, 11811, 171, 10),
(181, 11811, 171, 11),
(182, 11811, 171, 12),
(183, 11811, 171, 13),
(184, 11811, 171, 14),
(185, 11811, 171, 15),
(186, 11811, 171, 16),
(187, 11811, 171, 17),
(188, 11811, 171, 18),
(189, 11811, 171, 19),
(190, 11811, 171, 20),
(191, 11811, 171, 21),
(192, 11811, 171, 22),
(193, 11811, 171, 23),
(194, 11811, 171, 24),
(195, 11811, 171, 25),
(196, 11811, 171, 37),
(197, 11811, 171, 38),
(198, 11811, 171, 39),
(199, 11811, 171, 40),
(200, 11811, 171, 41),
(210, 11838, 5, 10002),
(287, 11887, 256, 1),
(288, 11887, 256, 2),
(289, 11887, 256, 3),
(290, 11887, 256, 4),
(291, 11887, 256, 5),
(292, 11887, 256, 6),
(293, 11887, 256, 7),
(294, 11887, 256, 8),
(295, 11887, 256, 9),
(296, 11887, 256, 10),
(297, 11887, 256, 11),
(298, 11887, 256, 12),
(299, 11887, 256, 13),
(300, 11887, 256, 14),
(301, 11887, 256, 15),
(302, 11887, 256, 16),
(303, 11887, 256, 17),
(304, 11887, 256, 18),
(305, 11887, 256, 19),
(306, 11887, 256, 20),
(307, 11887, 256, 21),
(308, 11887, 256, 22),
(309, 11887, 256, 23),
(310, 11887, 256, 24),
(311, 11887, 256, 25),
(312, 11887, 256, 37),
(313, 11887, 256, 38),
(314, 11887, 256, 39),
(315, 11887, 256, 40),
(316, 11887, 256, 41),
(317, 11887, 256, 53),
(318, 11887, 256, 54),
(319, 11887, 256, 55),
(320, 11887, 256, 56),
(321, 11887, 256, 57),
(331, 11914, 5, 10002),
(418, 11963, 341, 1),
(419, 11963, 341, 2),
(420, 11963, 341, 3),
(421, 11963, 341, 4),
(422, 11963, 341, 5),
(423, 11963, 341, 6),
(424, 11963, 341, 7),
(425, 11963, 341, 8),
(426, 11963, 341, 9),
(427, 11963, 341, 10),
(428, 11963, 341, 11),
(429, 11963, 341, 12),
(430, 11963, 341, 13),
(431, 11963, 341, 14),
(432, 11963, 341, 15),
(433, 11963, 341, 16),
(434, 11963, 341, 17),
(435, 11963, 341, 18),
(436, 11963, 341, 19),
(437, 11963, 341, 20),
(438, 11963, 341, 21),
(439, 11963, 341, 22),
(440, 11963, 341, 23),
(441, 11963, 341, 24),
(442, 11963, 341, 25),
(443, 11963, 341, 37),
(444, 11963, 341, 38),
(445, 11963, 341, 39),
(446, 11963, 341, 40),
(447, 11963, 341, 41),
(448, 11963, 341, 53),
(449, 11963, 341, 54),
(450, 11963, 341, 55),
(451, 11963, 341, 56),
(452, 11963, 341, 57),
(453, 11963, 341, 69),
(454, 11963, 341, 70),
(455, 11963, 341, 71),
(456, 11963, 341, 72),
(457, 11963, 341, 73),
(467, 11990, 5, 10002),
(564, 12039, 426, 1),
(565, 12039, 426, 2),
(566, 12039, 426, 3),
(567, 12039, 426, 4),
(568, 12039, 426, 5),
(569, 12039, 426, 6),
(570, 12039, 426, 7),
(571, 12039, 426, 8),
(572, 12039, 426, 9),
(573, 12039, 426, 10),
(574, 12039, 426, 11),
(575, 12039, 426, 12),
(576, 12039, 426, 13),
(577, 12039, 426, 14),
(578, 12039, 426, 15),
(579, 12039, 426, 16),
(580, 12039, 426, 17),
(581, 12039, 426, 18),
(582, 12039, 426, 19),
(583, 12039, 426, 20),
(584, 12039, 426, 21),
(585, 12039, 426, 22),
(586, 12039, 426, 23),
(587, 12039, 426, 24),
(588, 12039, 426, 25),
(589, 12039, 426, 37),
(590, 12039, 426, 38),
(591, 12039, 426, 39),
(592, 12039, 426, 40),
(593, 12039, 426, 41),
(594, 12039, 426, 53),
(595, 12039, 426, 54),
(596, 12039, 426, 55),
(597, 12039, 426, 56),
(598, 12039, 426, 57),
(599, 12039, 426, 69),
(600, 12039, 426, 70),
(601, 12039, 426, 71),
(602, 12039, 426, 72),
(603, 12039, 426, 73),
(604, 12039, 426, 85),
(605, 12039, 426, 86),
(606, 12039, 426, 87),
(607, 12039, 426, 88),
(608, 12039, 426, 89),
(619, 12068, 5, 10002),
(766, 12117, 515, 1),
(767, 12117, 515, 2),
(768, 12117, 515, 3),
(769, 12117, 515, 4),
(770, 12117, 515, 5),
(771, 12117, 515, 6),
(772, 12117, 515, 7),
(773, 12117, 515, 8),
(774, 12117, 515, 9),
(775, 12117, 515, 10),
(776, 12117, 515, 11),
(777, 12117, 515, 12),
(778, 12117, 515, 13),
(779, 12117, 515, 14),
(780, 12117, 515, 15),
(781, 12117, 515, 16),
(782, 12117, 515, 17),
(783, 12117, 515, 18),
(784, 12117, 515, 19),
(785, 12117, 515, 20),
(786, 12117, 515, 21),
(787, 12117, 515, 22),
(788, 12117, 515, 23),
(789, 12117, 515, 24),
(790, 12117, 515, 25),
(791, 12117, 515, 37),
(792, 12117, 515, 38),
(793, 12117, 515, 39),
(794, 12117, 515, 40),
(795, 12117, 515, 41),
(796, 12117, 515, 53),
(797, 12117, 515, 54),
(798, 12117, 515, 55),
(799, 12117, 515, 56),
(800, 12117, 515, 57),
(801, 12117, 515, 69),
(802, 12117, 515, 70),
(803, 12117, 515, 71),
(804, 12117, 515, 72),
(805, 12117, 515, 73),
(806, 12117, 515, 85),
(807, 12117, 515, 86),
(808, 12117, 515, 87),
(809, 12117, 515, 88),
(810, 12117, 515, 89),
(811, 12117, 515, 101),
(812, 12117, 515, 102),
(813, 12117, 515, 103),
(814, 12117, 515, 104),
(815, 12117, 515, 105),
(816, 12117, 515, 106),
(817, 12117, 515, 107),
(818, 12117, 515, 108),
(819, 12117, 515, 109),
(820, 12117, 515, 110),
(821, 12117, 515, 111),
(822, 12117, 515, 112),
(823, 12117, 515, 113),
(824, 12117, 515, 114),
(825, 12117, 515, 115),
(826, 12117, 515, 116),
(827, 12117, 515, 117),
(828, 12117, 515, 118),
(829, 12117, 515, 119),
(830, 12117, 515, 120),
(831, 12117, 515, 121),
(832, 12117, 515, 122),
(833, 12117, 515, 123),
(834, 12117, 515, 124),
(835, 12117, 515, 125),
(845, 12144, 5, 10002),
(1002, 12193, 600, 1),
(1003, 12193, 600, 2),
(1004, 12193, 600, 3),
(1005, 12193, 600, 4),
(1006, 12193, 600, 5),
(1007, 12193, 600, 6),
(1008, 12193, 600, 7),
(1009, 12193, 600, 8),
(1010, 12193, 600, 9),
(1011, 12193, 600, 10),
(1012, 12193, 600, 11),
(1013, 12193, 600, 12),
(1014, 12193, 600, 13),
(1015, 12193, 600, 14),
(1016, 12193, 600, 15),
(1017, 12193, 600, 16),
(1018, 12193, 600, 17),
(1019, 12193, 600, 18),
(1020, 12193, 600, 19),
(1021, 12193, 600, 20),
(1022, 12193, 600, 21),
(1023, 12193, 600, 22),
(1024, 12193, 600, 23),
(1025, 12193, 600, 24),
(1026, 12193, 600, 25),
(1027, 12193, 600, 37),
(1028, 12193, 600, 38),
(1029, 12193, 600, 39),
(1030, 12193, 600, 40),
(1031, 12193, 600, 41),
(1032, 12193, 600, 53),
(1033, 12193, 600, 54),
(1034, 12193, 600, 55),
(1035, 12193, 600, 56),
(1036, 12193, 600, 57),
(1037, 12193, 600, 69),
(1038, 12193, 600, 70),
(1039, 12193, 600, 71),
(1040, 12193, 600, 72),
(1041, 12193, 600, 73),
(1042, 12193, 600, 85),
(1043, 12193, 600, 86),
(1044, 12193, 600, 87),
(1045, 12193, 600, 88),
(1046, 12193, 600, 89),
(1047, 12193, 600, 101),
(1048, 12193, 600, 102),
(1049, 12193, 600, 103),
(1050, 12193, 600, 104),
(1051, 12193, 600, 105),
(1052, 12193, 600, 106),
(1053, 12193, 600, 107),
(1054, 12193, 600, 108),
(1055, 12193, 600, 109),
(1056, 12193, 600, 110),
(1057, 12193, 600, 111),
(1058, 12193, 600, 112),
(1059, 12193, 600, 113),
(1060, 12193, 600, 114),
(1061, 12193, 600, 115),
(1062, 12193, 600, 116),
(1063, 12193, 600, 117),
(1064, 12193, 600, 118),
(1065, 12193, 600, 119),
(1066, 12193, 600, 120),
(1067, 12193, 600, 121),
(1068, 12193, 600, 122),
(1069, 12193, 600, 123),
(1070, 12193, 600, 124),
(1071, 12193, 600, 125),
(1072, 12193, 600, 137),
(1073, 12193, 600, 138),
(1074, 12193, 600, 139),
(1075, 12193, 600, 140),
(1076, 12193, 600, 141);

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
(5, 1, '2018-11-12', 1, '11', 2, 1, 1, 2, 0, 2),
(6, 2, '2018-11-12', 1, '11', 0, 1, 0, 1, 0, 0),
(7, 3, '2018-11-12', 1, '11', 79, 7, 15, 71, 20, 79),
(8, 4, '2018-11-12', 1, '11', 0, 0, 0, 0, 0, 0),
(9, 1, '2018-11-13', 2, '11', 2, 1, 1, 2, 0, 0),
(10, 2, '2018-11-13', 2, '11', 0, 1, 0, 1, 0, 0),
(11, 3, '2018-11-13', 2, '11', 79, 8, 15, 72, 20, 77),
(12, 4, '2018-11-13', 2, '11', 0, 0, 0, 0, 0, 0),
(13, 1, '2018-11-14', 3, '11', 2, 1, 1, 2, 0, 0),
(14, 2, '2018-11-14', 3, '11', 0, 1, 0, 1, 0, 0),
(15, 3, '2018-11-14', 3, '11', 79, 9, 15, 73, 20, 77),
(16, 4, '2018-11-14', 3, '11', 0, 0, 0, 0, 0, 0),
(17, 1, '2018-11-15', 4, '11', 2, 1, 1, 2, 0, 0),
(18, 2, '2018-11-15', 4, '11', 0, 1, 0, 1, 0, 0),
(19, 3, '2018-11-15', 4, '11', 79, 9, 15, 73, 20, 77),
(20, 4, '2018-11-15', 4, '11', 0, 0, 0, 0, 0, 0),
(21, 1, '2018-11-16', 5, '11', 2, 1, 1, 2, 0, 0),
(22, 2, '2018-11-16', 5, '11', 0, 1, 0, 1, 0, 0),
(23, 3, '2018-11-16', 5, '11', 79, 9, 15, 73, 20, 77),
(24, 4, '2018-11-16', 5, '11', 0, 0, 0, 0, 0, 0),
(25, 1, '2018-11-17', 6, '11', 2, 1, 1, 2, 0, 0),
(26, 2, '2018-11-17', 6, '11', 0, 1, 0, 1, 0, 0),
(27, 3, '2018-11-17', 6, '11', 82, 6, 15, 73, 20, 80),
(28, 1, '2018-11-18', 0, '11', 2, 1, 1, 2, 0, 0),
(29, 2, '2018-11-18', 0, '11', 0, 1, 0, 1, 0, 0),
(30, 3, '2018-11-18', 0, '11', 83, 5, 15, 73, 20, 81),
(31, 1, '2018-11-19', 1, '11', 2, 1, 1, 2, 0, 0),
(32, 2, '2018-11-19', 1, '11', 0, 1, 0, 1, 0, 0),
(33, 3, '2018-11-19', 1, '11', 85, 4, 15, 74, 20, 83),
(34, 1, '2018-11-20', 2, '11', 2, 1, 1, 2, 0, 0),
(35, 2, '2018-11-20', 2, '11', 0, 1, 0, 1, 0, 0),
(36, 3, '2018-11-20', 2, '11', 85, 4, 16, 73, 20, 83),
(37, 1, '2018-11-21', 3, '11', 2, 1, 1, 2, 0, 0),
(38, 2, '2018-11-21', 3, '11', 0, 1, 0, 1, 0, 0),
(39, 3, '2018-11-21', 3, '11', 85, 10, 16, 79, 20, 83),
(40, 1, '2018-11-22', 4, '11', 2, 1, 1, 2, 0, 0),
(41, 2, '2018-11-22', 4, '11', 0, 1, 0, 1, 0, 0),
(42, 3, '2018-11-22', 4, '11', 85, 10, 16, 79, 20, 83),
(43, 5, '2018-11-22', 4, '11', 0, 0, 0, 0, 0, 0),
(44, 1, '2018-11-23', 5, '11', 2, 1, 1, 2, 0, 0),
(45, 2, '2018-11-23', 5, '11', 0, 1, 0, 1, 0, 0),
(46, 3, '2018-11-23', 5, '11', 85, 10, 16, 79, 20, 83),
(47, 5, '2018-11-23', 5, '11', 0, 0, 0, 0, 0, 0),
(48, 1, '2018-11-24', 6, '11', 2, 1, 1, 2, 0, 0),
(49, 2, '2018-11-24', 6, '11', 0, 1, 0, 1, 0, 0),
(50, 3, '2018-11-24', 6, '11', 85, 10, 16, 79, 20, 83),
(51, 5, '2018-11-24', 6, '11', 0, 0, 0, 0, 0, 0),
(52, 1, '2018-11-25', 0, '11', 2, 1, 1, 2, 0, 0),
(53, 2, '2018-11-25', 0, '11', 0, 1, 0, 1, 0, 0),
(54, 3, '2018-11-25', 0, '11', 85, 10, 16, 79, 20, 83),
(55, 5, '2018-11-25', 0, '11', 0, 0, 0, 0, 0, 0),
(56, 1, '2018-11-26', 1, '11', 2, 1, 1, 2, 0, 0),
(57, 2, '2018-11-26', 1, '11', 0, 1, 0, 1, 0, 0),
(58, 3, '2018-11-26', 1, '11', 85, 10, 16, 79, 20, 83),
(59, 5, '2018-11-26', 1, '11', 0, 0, 0, 0, 0, 0),
(60, 1, '2018-11-27', 2, '11', 2, 1, 1, 2, 0, 0),
(61, 2, '2018-11-27', 2, '11', 0, 1, 0, 1, 0, 0),
(62, 3, '2018-11-27', 2, '11', 85, 26, 16, 95, 20, 83),
(63, 5, '2018-11-27', 2, '11', 0, 0, 0, 0, 0, 0),
(64, 1, '2018-11-28', 3, '11', 2, 1, 1, 2, 0, 0),
(65, 2, '2018-11-28', 3, '11', 0, 1, 0, 1, 0, 0),
(66, 3, '2018-11-28', 3, '11', 89, 21, 23, 87, 150, 87),
(67, 5, '2018-11-28', 3, '11', 0, 0, 0, 0, 0, 0),
(68, 1, '2018-11-29', 4, '11', 2, 1, 1, 2, 0, 0),
(69, 2, '2018-11-29', 4, '11', 0, 1, 0, 1, 0, 0),
(70, 3, '2018-11-29', 4, '11', 89, 21, 23, 87, 150, 87),
(71, 5, '2018-11-29', 4, '11', 0, 0, 0, 0, 0, 0),
(72, 1, '2018-11-30', 5, '11', 2, 1, 1, 2, 0, 0),
(73, 2, '2018-11-30', 5, '11', 0, 1, 0, 1, 0, 0),
(74, 3, '2018-11-30', 5, '11', 89, 21, 23, 87, 150, 87),
(75, 5, '2018-11-30', 5, '11', 0, 0, 0, 0, 0, 0);

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
(5, 1, '2018-11-12', 1, '11', 2, 0, 0, 2, 0, 2),
(6, 2, '2018-11-12', 1, '11', 42, 0, 12, 30, 0, 42),
(7, 3, '2018-11-12', 1, '11', 33, 5, 3, 35, 0, 33),
(8, 4, '2018-11-12', 1, '11', 1, 1, 0, 2, 0, 1),
(9, 1, '2018-11-13', 2, '11', 2, 0, 0, 2, 0, 0),
(10, 2, '2018-11-13', 2, '11', 42, 0, 12, 30, 0, 40),
(11, 3, '2018-11-13', 2, '11', 33, 5, 3, 35, 0, 31),
(12, 4, '2018-11-13', 2, '11', 1, 2, 0, 3, 0, 0),
(13, 1, '2018-11-14', 3, '11', 2, 0, 0, 2, 0, 0),
(14, 2, '2018-11-14', 3, '11', 42, 0, 12, 30, 0, 40),
(15, 3, '2018-11-14', 3, '11', 33, 6, 3, 36, 0, 31),
(16, 4, '2018-11-14', 3, '11', 1, 2, 0, 3, 0, 0),
(17, 1, '2018-11-15', 4, '11', 2, 0, 0, 2, 0, 0),
(18, 2, '2018-11-15', 4, '11', 42, 0, 12, 30, 0, 40),
(19, 3, '2018-11-15', 4, '11', 33, 6, 3, 36, 0, 31),
(20, 4, '2018-11-15', 4, '11', 1, 2, 0, 3, 0, 0),
(21, 1, '2018-11-16', 5, '11', 2, 0, 0, 2, 0, 0),
(22, 2, '2018-11-16', 5, '11', 42, 0, 12, 30, 0, 40),
(23, 3, '2018-11-16', 5, '11', 33, 6, 3, 36, 0, 31),
(24, 4, '2018-11-16', 5, '11', 1, 2, 0, 3, 0, 0),
(25, 1, '2018-11-17', 6, '11', 2, 0, 0, 2, 0, 0),
(26, 2, '2018-11-17', 6, '11', 42, 0, 12, 30, 0, 40),
(27, 3, '2018-11-17', 6, '11', 35, 4, 3, 36, 0, 33),
(28, 4, '2018-11-17', 6, '11', 2, 1, 0, 3, 0, 0),
(29, 1, '2018-11-18', 0, '11', 2, 0, 0, 2, 0, 0),
(30, 2, '2018-11-18', 0, '11', 42, 0, 12, 30, 0, 40),
(31, 3, '2018-11-18', 0, '11', 35, 4, 3, 36, 0, 33),
(32, 4, '2018-11-18', 0, '11', 3, 0, 0, 3, 0, 1),
(33, 1, '2018-11-19', 1, '11', 2, 0, 0, 2, 0, 0),
(34, 2, '2018-11-19', 1, '11', 42, 0, 12, 30, 0, 40),
(35, 3, '2018-11-19', 1, '11', 36, 2, 3, 35, 0, 34),
(36, 4, '2018-11-19', 1, '11', 3, 1, 0, 4, 0, 1),
(37, 1, '2018-11-20', 2, '11', 2, 0, 0, 2, 0, 0),
(38, 2, '2018-11-20', 2, '11', 42, 0, 12, 30, 0, 40),
(39, 3, '2018-11-20', 2, '11', 36, 2, 4, 34, 0, 34),
(40, 4, '2018-11-20', 2, '11', 3, 1, 0, 4, 0, 1),
(41, 1, '2018-11-21', 3, '11', 2, 0, 0, 2, 0, 0),
(42, 2, '2018-11-21', 3, '11', 42, 0, 12, 30, 0, 40),
(43, 3, '2018-11-21', 3, '11', 36, 4, 4, 36, 0, 34),
(44, 4, '2018-11-21', 3, '11', 3, 2, 0, 5, 0, 1),
(45, 1, '2018-11-22', 4, '11', 2, 0, 0, 2, 0, 0),
(46, 2, '2018-11-22', 4, '11', 42, 0, 12, 30, 0, 40),
(47, 3, '2018-11-22', 4, '11', 36, 5, 4, 37, 0, 34),
(48, 4, '2018-11-22', 4, '11', 3, 2, 0, 5, 0, 1),
(49, 1, '2018-11-23', 5, '11', 2, 0, 0, 2, 0, 0),
(50, 2, '2018-11-23', 5, '11', 42, 0, 12, 30, 0, 40),
(51, 3, '2018-11-23', 5, '11', 36, 5, 4, 37, 0, 34),
(52, 4, '2018-11-23', 5, '11', 3, 2, 0, 5, 0, 1),
(53, 1, '2018-11-24', 6, '11', 2, 0, 0, 2, 0, 0),
(54, 2, '2018-11-24', 6, '11', 42, 0, 12, 30, 0, 40),
(55, 3, '2018-11-24', 6, '11', 36, 5, 4, 37, 0, 34),
(56, 4, '2018-11-24', 6, '11', 3, 2, 0, 5, 0, 1),
(57, 1, '2018-11-25', 0, '11', 2, 0, 0, 2, 0, 0),
(58, 2, '2018-11-25', 0, '11', 42, 0, 12, 30, 0, 40),
(59, 3, '2018-11-25', 0, '11', 36, 5, 4, 37, 0, 34),
(60, 4, '2018-11-25', 0, '11', 3, 2, 0, 5, 0, 1),
(61, 1, '2018-11-26', 1, '11', 2, 0, 0, 2, 0, 0),
(62, 2, '2018-11-26', 1, '11', 42, 0, 12, 30, 0, 40),
(63, 3, '2018-11-26', 1, '11', 36, 5, 4, 37, 0, 34),
(64, 4, '2018-11-26', 1, '11', 3, 2, 0, 5, 0, 1),
(65, 1, '2018-11-27', 2, '11', 2, 0, 0, 2, 0, 0),
(66, 2, '2018-11-27', 2, '11', 42, 0, 12, 30, 0, 40),
(67, 3, '2018-11-27', 2, '11', 36, 6, 4, 38, 0, 34),
(68, 4, '2018-11-27', 2, '11', 3, 16, 0, 19, 0, 1),
(69, 1, '2018-11-28', 3, '11', 2, 0, 0, 2, 0, 0),
(70, 2, '2018-11-28', 3, '11', 42, 0, 12, 30, 0, 40),
(71, 3, '2018-11-28', 3, '11', 36, 4, 4, 36, 0, 34),
(72, 4, '2018-11-28', 3, '11', 6, 15, 6, 15, 0, 4),
(73, 1, '2018-11-29', 4, '11', 2, 0, 0, 2, 0, 0),
(74, 2, '2018-11-29', 4, '11', 42, 0, 12, 30, 0, 40),
(75, 3, '2018-11-29', 4, '11', 36, 4, 4, 36, 0, 34),
(76, 4, '2018-11-29', 4, '11', 5, 15, 5, 15, 0, 3),
(77, 1, '2018-11-30', 5, '11', 2, 0, 0, 2, 0, 0),
(78, 2, '2018-11-30', 5, '11', 42, 0, 12, 30, 0, 40),
(79, 3, '2018-11-30', 5, '11', 36, 4, 4, 36, 0, 34),
(80, 4, '2018-11-30', 5, '11', 5, 15, 5, 15, 0, 3);

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
(5, '19080125602', '19080125602@masterlab.org', 11361, '9U1MWHHTYJHLOM9PPDCVKJ2FQRHC6IS4', 1536219834),
(6, 'cfm_test', '442118411@qq.com', 11658, 'JUR4B9DXBRX4R11QV4NP27X76ODK8PQ1', 1541489893),
(7, 'SSS', '1216420381@qq.com', 11659, 'PV5HZSDTAB5UKY8B9DYIAXG7B7VLZWZG', 1543890492),
(33, 'kuangxz', 'kuangxingzuo@hotmail.com', 12055, 'KN6PNPLQ1PG743ISZI0LRVICS32BFLFD', 1545180823);

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
('19035438315@masterlab.org', 0, '0PJJB0HOO9RXGW324YJTYBZAV8NCEOZC', 1545127855),
('19046176519@masterlab.org', 0, '1UJZC6CTYMA4OYCVEF77B1YNOSOI55S8', 1545129316),
('19058980697@masterlab.org', 0, 'L3UNPAQ5WWWV6KVL3F27JMX8G5UMAL7C', 1545155085),
('19064656538@masterlab.org', 0, 'GXYPZ3J16EJOAKQARET9WJ1VVYFUKDV3', 1535594723),
('19068014805@masterlab.org', 0, 'OK648JJ2YIS7XOQUDNEAWUDWQUHXANME', 1545209861),
('19069270974@masterlab.org', 0, 'KYMPBKG7AGM1WP20BZX12PB3DUWWKP7U', 1545207387),
('19073255376@masterlab.org', 0, 'UTNLTLGE4GD72J9XLVGZ34VVT0ZGGBSZ', 1545133756),
('19092032476@masterlab.org', 0, 'U56FNFEHZG7LBH2440D06OTVI94YTT0L', 1545135012),
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
(10528, 1, 1),
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
(10527, 11619, 1),
(10532, 11654, 1),
(10533, 11654, 2),
(10534, 11654, 3),
(10529, 11657, 1),
(10530, 11657, 2),
(10531, 11657, 3),
(10550, 11704, 1),
(10551, 11705, 1),
(10552, 11706, 1),
(10553, 11707, 1),
(10554, 11709, 1),
(10555, 11710, 1),
(10556, 11714, 1),
(10557, 11715, 1),
(10558, 11720, 1),
(10559, 11723, 1),
(10560, 11724, 1),
(10561, 11725, 1),
(10562, 11726, 1),
(10563, 11727, 1),
(10564, 11728, 1),
(10565, 11729, 1),
(10566, 11730, 1),
(10567, 11731, 1),
(10568, 11732, 1),
(10569, 11733, 1),
(10570, 11734, 1),
(10577, 11735, 1),
(10578, 11735, 2),
(10579, 11749, 1),
(10580, 11750, 1),
(10596, 11780, 1),
(10597, 11781, 1),
(10598, 11782, 1),
(10599, 11783, 1),
(10600, 11785, 1),
(10601, 11786, 1),
(10602, 11790, 1),
(10603, 11791, 1),
(10604, 11796, 1),
(10605, 11799, 1),
(10606, 11800, 1),
(10607, 11801, 1),
(10608, 11802, 1),
(10609, 11803, 1),
(10610, 11804, 1),
(10611, 11805, 1),
(10612, 11806, 1),
(10613, 11807, 1),
(10614, 11808, 1),
(10615, 11809, 1),
(10616, 11810, 1),
(10623, 11811, 1),
(10624, 11811, 2),
(10625, 11825, 1),
(10626, 11826, 1),
(10642, 11856, 1),
(10643, 11857, 1),
(10644, 11858, 1),
(10645, 11859, 1),
(10646, 11861, 1),
(10647, 11862, 1),
(10648, 11866, 1),
(10649, 11867, 1),
(10650, 11872, 1),
(10651, 11875, 1),
(10652, 11876, 1),
(10653, 11877, 1),
(10654, 11878, 1),
(10655, 11879, 1),
(10656, 11880, 1),
(10657, 11881, 1),
(10658, 11882, 1),
(10659, 11883, 1),
(10660, 11884, 1),
(10661, 11885, 1),
(10662, 11886, 1),
(10669, 11887, 1),
(10670, 11887, 2),
(10671, 11901, 1),
(10672, 11902, 1),
(10688, 11932, 1),
(10689, 11933, 1),
(10690, 11934, 1),
(10691, 11935, 1),
(10692, 11937, 1),
(10693, 11938, 1),
(10694, 11942, 1),
(10695, 11943, 1),
(10696, 11948, 1),
(10697, 11951, 1),
(10698, 11952, 1),
(10699, 11953, 1),
(10700, 11954, 1),
(10701, 11955, 1),
(10702, 11956, 1),
(10703, 11957, 1),
(10704, 11958, 1),
(10705, 11959, 1),
(10706, 11960, 1),
(10707, 11961, 1),
(10708, 11962, 1),
(10715, 11963, 1),
(10716, 11963, 2),
(10717, 11977, 1),
(10718, 11978, 1),
(10734, 12008, 1),
(10735, 12009, 1),
(10736, 12010, 1),
(10737, 12011, 1),
(10738, 12013, 1),
(10739, 12014, 1),
(10740, 12018, 1),
(10741, 12019, 1),
(10742, 12024, 1),
(10743, 12027, 1),
(10744, 12028, 1),
(10745, 12029, 1),
(10746, 12030, 1),
(10747, 12031, 1),
(10748, 12032, 1),
(10749, 12033, 1),
(10750, 12034, 1),
(10751, 12035, 1),
(10752, 12036, 1),
(10753, 12037, 1),
(10754, 12038, 1),
(10761, 12039, 1),
(10762, 12039, 2),
(10763, 12053, 1),
(10764, 12054, 1),
(10780, 12086, 1),
(10781, 12087, 1),
(10782, 12088, 1),
(10783, 12089, 1),
(10784, 12091, 1),
(10785, 12092, 1),
(10786, 12096, 1),
(10787, 12097, 1),
(10788, 12102, 1),
(10789, 12105, 1),
(10790, 12106, 1),
(10791, 12107, 1),
(10792, 12108, 1),
(10793, 12109, 1),
(10794, 12110, 1),
(10795, 12111, 1),
(10796, 12112, 1),
(10797, 12113, 1),
(10798, 12114, 1),
(10799, 12115, 1),
(10800, 12116, 1),
(10807, 12117, 1),
(10808, 12117, 2),
(10809, 12131, 1),
(10810, 12132, 1),
(10826, 12162, 1),
(10827, 12163, 1),
(10828, 12164, 1),
(10829, 12165, 1),
(10830, 12167, 1),
(10831, 12168, 1),
(10832, 12172, 1),
(10833, 12173, 1),
(10834, 12178, 1),
(10835, 12181, 1),
(10836, 12182, 1),
(10837, 12183, 1),
(10838, 12184, 1),
(10839, 12185, 1),
(10840, 12186, 1),
(10841, 12187, 1),
(10842, 12188, 1),
(10843, 12189, 1),
(10844, 12190, 1),
(10845, 12191, 1),
(10846, 12192, 1),
(10853, 12193, 1),
(10854, 12193, 2),
(10855, 12207, 1),
(10856, 12208, 1);

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
(18, '2adjj4lh3ipfsopdmjc7fk0g37', '', 11672, 1543921269, '127.0.0.1'),
(92, 'sog1rosbd6bu6arruuareonpt7', '', 11657, 1545102173, '127.0.0.1'),
(96, 'vkfb5br2sv8l0t25nqtngp4pfm', '', 11704, 1545127502, '127.0.0.1'),
(97, 'ltudrc18lddecisl30s4gl3e0k', '', 11705, 1545127515, '127.0.0.1'),
(98, 'ac417cnc1kl92u32iu3r4q2tdf', '', 11706, 1545127572, '127.0.0.1'),
(99, '6clgh3hhmshdmjj2i0hir8dbc4', '', 11707, 1545127595, '127.0.0.1'),
(100, 'c4ufqqiooi03p2r5c9ak0uftau', '', 11709, 1545127784, '127.0.0.1'),
(101, '12q1s882h0eaomh56ph8fsiduq', '', 11710, 1545127816, '127.0.0.1'),
(103, 'soe0n3lphukjqi4e1d482mvv1r', '', 11712, 1545127853, '127.0.0.1'),
(104, 'hquu5e0qjugmkdrv5mikqal1or', '', 11714, 1545127884, '127.0.0.1'),
(105, 'q6gv9v038viieu9ggsq42p944k', '', 11715, 1545127901, '127.0.0.1'),
(106, 'gj7nbu1cdtb88kfgl0vikounj9', '', 11720, 1545127925, '127.0.0.1'),
(107, 'ihir0lk78di85ph29484daalam', '', 11721, 1545127945, '127.0.0.1'),
(108, 'lpaujq4a3u9cfhj690ae19433u', '', 11721, 1545127949, '127.0.0.1'),
(109, 'dn6rlj8t8rg398rc102i563tbg', '', 11722, 1545127952, '127.0.0.1'),
(110, 'r8dceql9pkqhs06q6v3n9lvsd4', '', 11723, 1545127963, '127.0.0.1'),
(111, '13pcio76bpcqspecqsr6l9kbe3', '', 11724, 1545127982, '127.0.0.1'),
(112, 'p5ml3eujvqtkup83j6e0sumk1b', '', 11725, 1545128001, '127.0.0.1'),
(113, 'c299gmt3qvkpd3n417knfad1t0', '', 11726, 1545128020, '127.0.0.1'),
(114, 'nv8jiomp39nktqi30vfojl7530', '', 11727, 1545128038, '127.0.0.1'),
(115, '9tb8froelkml2nhsag6295jc5g', '', 11728, 1545128057, '127.0.0.1'),
(116, '8kjkihn7gqrm235s3vhaf413r5', '', 11729, 1545128080, '127.0.0.1'),
(117, 'kv177cshtlh168f4v2idv9cl98', '', 11730, 1545128098, '127.0.0.1'),
(118, 'cl74cj7m9uksv16ml6itiulgcq', '', 11731, 1545128118, '127.0.0.1'),
(119, 'ig7em47ufa63t1qe2smpsql7lh', '', 11732, 1545128136, '127.0.0.1'),
(120, 'ti393v14ihl6u9der59acmqr1n', '', 11733, 1545128202, '127.0.0.1'),
(121, '8dmhi5kk38ugfg52o1tpoq57ik', '', 11734, 1545128212, '127.0.0.1'),
(122, 'g0coljnlqag1rtij37bnmgfon5', '', 11749, 1545128293, '127.0.0.1'),
(123, 'eu3stmhe0p4n5317te3j19r6qh', '', 11750, 1545128315, '127.0.0.1'),
(124, 'ef84e080a84157312e010c8798c82308', '', 11656, 1545128547, '183.11.31.54'),
(127, 'jr6spirlj5g6t2idfdorbmfbdj', '', 11780, 1545128964, '127.0.0.1'),
(128, 'oel0295v5hbom651gnvqh8ri7d', '', 11781, 1545128977, '127.0.0.1'),
(129, 'hvh2jdhbap3q14hr8i5msn7brp', '', 11782, 1545129034, '127.0.0.1'),
(130, '8sc432ihm3r8t8sqfg71pmlug9', '', 11783, 1545129055, '127.0.0.1'),
(131, 'oui75lntlkt2m83fqesmp66u84', '', 11785, 1545129246, '127.0.0.1'),
(132, 'vh5ob0oqh0u62kqjmjksc6pgjv', '', 11786, 1545129277, '127.0.0.1'),
(133, 'd1le274qujbhnvddvd7v813ok3', '', 11788, 1545129314, '127.0.0.1'),
(134, 'epaol2eibn9kucs9dltj1iht0l', '', 11790, 1545129345, '127.0.0.1'),
(135, 'p39q56lg96v6smno1otpirtskj', '', 11791, 1545129366, '127.0.0.1'),
(136, 'ea3i4ujp1gm404nei56osstf8h', '', 11796, 1545129391, '127.0.0.1'),
(137, 'aqi1r2p0idfslf9nh1pitnn0ll', '', 11797, 1545129411, '127.0.0.1'),
(138, 'c032ftokjbst3t976buab0hhvq', '', 11797, 1545129415, '127.0.0.1'),
(139, 'badtvdl9v466nr47bpaeh1jf7b', '', 11798, 1545129418, '127.0.0.1'),
(140, '3n1ki932o5pr1fd5b5ivgab5j5', '', 11799, 1545129429, '127.0.0.1'),
(141, 'pqvi64b49mklghqflflivqnhma', '', 11800, 1545129448, '127.0.0.1'),
(142, 'k54qgr0q2qevok7knq9kph38sn', '', 11801, 1545129467, '127.0.0.1'),
(143, 'arndtn2ab8dhvhakd34f70dpor', '', 11802, 1545129486, '127.0.0.1'),
(144, 'acp9ecmhcfkgkfueeehaoe84j0', '', 11803, 1545129505, '127.0.0.1'),
(145, '7vn0sftre3akclqti6gv89223t', '', 11804, 1545129524, '127.0.0.1'),
(146, '6sgo41onhkbnntrr89i1kilbjq', '', 11805, 1545129547, '127.0.0.1'),
(147, 'qh3826kgfs18a1gt51im5mjqe1', '', 11806, 1545129565, '127.0.0.1'),
(148, '50jo1olgsp330ksuid5un59p1t', '', 11807, 1545129584, '127.0.0.1'),
(149, '3j4lm741q3iud10gn5vrrnenpq', '', 11808, 1545129603, '127.0.0.1'),
(150, 'vr5hgb1cojpulsflr5fp1fkit6', '', 11809, 1545129669, '127.0.0.1'),
(151, 'bttkcgt7e8qgnlr4p0iblg5qqi', '', 11810, 1545129679, '127.0.0.1'),
(152, 'pf4bpce6c54h0sp22vbpjimp4j', '', 11825, 1545129762, '127.0.0.1'),
(153, '0cbd1e3sba1700ijteh77rqmvd', '', 11826, 1545129785, '127.0.0.1'),
(156, 'spgvp88se6ql6t8i90dln3kgue', '', 11856, 1545133383, '127.0.0.1'),
(157, 'd57l0no006m07g34fln5e4av9a', '', 11857, 1545133396, '127.0.0.1'),
(158, '257a4s8n6p49ti9p5vmql5vtpi', '', 11858, 1545133459, '127.0.0.1'),
(159, '5ms93008mubnsl3234q4tbfvhm', '', 11859, 1545133485, '127.0.0.1'),
(160, 'sms9d8ckr56khbltkp81h96cop', '', 11861, 1545133684, '127.0.0.1'),
(161, 'ud5u928demk1sq5a9e7kiplmu0', '', 11862, 1545133716, '127.0.0.1'),
(162, 'oo05n5n8rjkimq2ul2j20o5re7', '', 11864, 1545133754, '127.0.0.1'),
(163, '1q2k6e42059n6rg113a0fqn82t', '', 11866, 1545133784, '127.0.0.1'),
(164, '13einmjadjh3hm90uhc2lr12rg', '', 11867, 1545133801, '127.0.0.1'),
(165, 'hvc1ktqvr1801h75l81hpivi5q', '', 11872, 1545133825, '127.0.0.1'),
(166, 'rf19v9g4n9l5hadmmbks4gb3r5', '', 11873, 1545133847, '127.0.0.1'),
(167, 'esiggrte7jickkbhgtmtfln640', '', 11873, 1545133851, '127.0.0.1'),
(168, 'a548gvd347v0jjg8a8fk1jnnca', '', 11874, 1545133854, '127.0.0.1'),
(169, 's9ughuvoc7u0i722np1mi06pd8', '', 11875, 1545133865, '127.0.0.1'),
(170, 'auubrgk1as2kcfh2nfsop1ref4', '', 11876, 1545133884, '127.0.0.1'),
(171, '9cddoem54dhjpco764tckp5n1u', '', 11877, 1545133903, '127.0.0.1'),
(172, '122nthdgopicl8b0s4j4lab0p7', '', 11878, 1545133922, '127.0.0.1'),
(173, '4lcnqatlj6vr6hmllem04g86mm', '', 11879, 1545133941, '127.0.0.1'),
(174, 'q2uc7g109i20tsvi3abn18p84t', '', 11880, 1545133960, '127.0.0.1'),
(175, 'tv9o7c9sqf8hnu66ms9sktfsft', '', 11881, 1545133984, '127.0.0.1'),
(176, '1kqtqpugaf1fktoh2jnp5g2594', '', 11882, 1545134002, '127.0.0.1'),
(177, 'jm0i3da2uio9sqjhmsp4dbnk67', '', 11883, 1545134021, '127.0.0.1'),
(178, 'gpsgscpaabbrgb2vsurg64nmrm', '', 11884, 1545134039, '127.0.0.1'),
(179, 'oukb9p7kl1c6r57gaad2lg6rb0', '', 11885, 1545134105, '127.0.0.1'),
(180, 'bqmds588ch9nojjbvssjsqsjq6', '', 11886, 1545134115, '127.0.0.1'),
(181, 'qjth8u8oeadl8mtjq941b1e1f4', '', 11901, 1545134199, '127.0.0.1'),
(182, 'jjstqqgiu21al0vmh25928c5n3', '', 11902, 1545134222, '127.0.0.1'),
(184, 'ja5ee5qm9vskekbln3i6akn60v', '', 11932, 1545134645, '127.0.0.1'),
(185, '2fqu6mdlh75so1rtb4m53t7aiu', '', 11933, 1545134659, '127.0.0.1'),
(186, '2ov3vm927gv15fa3b749977fto', '', 11934, 1545134719, '127.0.0.1'),
(187, 'on8s0vkf45715gavialvbp948s', '', 11935, 1545134741, '127.0.0.1'),
(188, '1149d18tnqa533vbs8ree007p4', '', 11937, 1545134940, '127.0.0.1'),
(189, 'qcv32mfrmk5h1kk3di6tqgjp5j', '', 11938, 1545134972, '127.0.0.1'),
(190, '1b02senspaktkuojg22rvpatl7', '', 11940, 1545135010, '127.0.0.1'),
(191, 'kulfma7ullqsqjdbsue4urqnus', '', 11942, 1545135041, '127.0.0.1'),
(192, 'qrs851ctoajmvc3llmt39mvro9', '', 11943, 1545135057, '127.0.0.1'),
(193, 'j01md3486314pvgmlfgbkr1n9j', '', 11948, 1545135081, '127.0.0.1'),
(194, 'r6mrlscju8p6krpeghmfvme2c2', '', 11949, 1545135103, '127.0.0.1'),
(195, 'eh686ck89p92mfs3bubj661rjl', '', 11949, 1545135107, '127.0.0.1'),
(196, 'ivnl8fjbvd5bqtljvi1lpaitrn', '', 11950, 1545135110, '127.0.0.1'),
(197, '119m8242vfbakkta6cfd2vilvq', '', 11951, 1545135121, '127.0.0.1'),
(198, 'dec4bm1fff0akf4eucvftgnoam', '', 11952, 1545135140, '127.0.0.1'),
(199, 'djov0frag7m4aqpgjopaoo8j93', '', 11953, 1545135159, '127.0.0.1'),
(200, 'gl4ov6js36r78j2lgi6b5fh38a', '', 11954, 1545135178, '127.0.0.1'),
(201, '0qusr0th8g6b7bvon02t9k3fhl', '', 11955, 1545135196, '127.0.0.1'),
(202, 'j3nipsrssr0ejeqp7m8nddqme2', '', 11956, 1545135215, '127.0.0.1'),
(203, 'jfac5uor40u9d61nuc6nmm6nk5', '', 11957, 1545135239, '127.0.0.1'),
(204, 'erihimj79h1b8vmcu595tn0cmm', '', 11958, 1545135257, '127.0.0.1'),
(205, 'b4sb2b5vejnj1ff0tbm1fksfm2', '', 11959, 1545135276, '127.0.0.1'),
(206, 'tm0g2sdaahledff6frvrilbpg1', '', 11960, 1545135295, '127.0.0.1'),
(207, 'totmk58op6ueq2t4eco53gmhc2', '', 11961, 1545135361, '127.0.0.1'),
(208, 'fhu5j7hoeuov6gldm0itnlddhv', '', 11962, 1545135370, '127.0.0.1'),
(209, 'au84g7jch8m7ffrf75q5i6sefk', '', 11977, 1545135457, '127.0.0.1'),
(210, 'bnt4hqg984ajar0ttub9026kaf', '', 11978, 1545135480, '127.0.0.1'),
(222, '4isd21n6f2fl7v7mih7u6v422n', '', 12008, 1545154712, '127.0.0.1'),
(223, 'gfkei7ijmqe3e6jufvhheg1gve', '', 12009, 1545154725, '127.0.0.1'),
(224, 'cno6o87bae15nf62nnjbn0c5n8', '', 12010, 1545154785, '127.0.0.1'),
(225, 'v0303v3nb0vlnl0ts8r4sbr1ak', '', 12011, 1545154812, '127.0.0.1'),
(226, '6lgs77mh2876tnb9n3hn0u2qnt', '', 12013, 1545155013, '127.0.0.1'),
(227, 'op7hig0akph8c16orrs72dii68', '', 12014, 1545155045, '127.0.0.1'),
(228, 'vmbu9lnna8bg36l6sl7ucemg75', '', 12016, 1545155083, '127.0.0.1'),
(229, 'j1opiih3iq2sfeqhvkqmguoilq', '', 12018, 1545155113, '127.0.0.1'),
(230, '8fm5irn4kbbcf8muptksfs9brk', '', 12019, 1545155129, '127.0.0.1'),
(231, 'dj7jlirr71odaeuhjqd8qerbr5', '', 12024, 1545155153, '127.0.0.1'),
(232, '024lv38s1f0rgbc6dp1e9cm2fl', '', 12025, 1545155175, '127.0.0.1'),
(233, '196sru1euc715b3n7vu923rm4s', '', 12025, 1545155179, '127.0.0.1'),
(234, 'n9jjhadv8961gpf30pq8hu0ev6', '', 12026, 1545155182, '127.0.0.1'),
(235, 'oi68rtnmj9s21g7tplhmteubij', '', 12027, 1545155194, '127.0.0.1'),
(236, 'k5rfcfk2pilpkistcr3aj9bgha', '', 12028, 1545155213, '127.0.0.1'),
(237, 'iki249en2jhci6ppb7pvkaipen', '', 12029, 1545155231, '127.0.0.1'),
(238, '04jj5r2hbf8k10a8qmtpvnp876', '', 12030, 1545155250, '127.0.0.1'),
(239, 'i10j5tsq6mdfdtbm3bcktik8bv', '', 12031, 1545155269, '127.0.0.1'),
(240, '90d7n67c4b8i46erp7uedpnqj5', '', 12032, 1545155288, '127.0.0.1'),
(241, 'h8ilo53ouqbvno19l8m5u4fa8n', '', 12033, 1545155312, '127.0.0.1'),
(242, 'qvjp6goipj11l2u2mg07437gel', '', 12034, 1545155330, '127.0.0.1'),
(243, 's91rdeit0b2ttvhist5g9n7kan', '', 12035, 1545155350, '127.0.0.1'),
(244, 'vb1vdi19651d93er6mllbnh9tj', '', 12036, 1545155368, '127.0.0.1'),
(245, '9rjpc006oha9ds4pb29mmmiefs', '', 12037, 1545155434, '127.0.0.1'),
(246, 'aaeofc38ehqg9je8nrqjpdpu3m', '', 12038, 1545155444, '127.0.0.1'),
(247, 'je0dniij3huojhoji48f4atj6t', '', 12053, 1545155532, '127.0.0.1'),
(248, 'n5js06bl4btclorsijb5j1tcs8', '', 12054, 1545155555, '127.0.0.1'),
(279, 'jn95vo1qrrlqtuna8q3qgdktii', '', 10000, 1545204077, '127.0.0.1'),
(286, 'csdqendscjtoo1f7ftmgii8dfo', '', 12086, 1545207018, '127.0.0.1'),
(287, '66vagh0aeg6p0g6h1n3q6luc0o', '', 12087, 1545207032, '127.0.0.1'),
(288, 'ohcadrjvai9isdrsre2hbhs99c', '', 12088, 1545207092, '127.0.0.1'),
(289, 'l9jmceo6bdl822gm5gq7c168qq', '', 12089, 1545207117, '127.0.0.1'),
(290, '5gh39ur4vjt40aao9q32ag0iaj', '', 12091, 1545207315, '127.0.0.1'),
(291, 'l9s5mmko3g08k996afn98565gh', '', 12092, 1545207348, '127.0.0.1'),
(292, 'sajfrq8pmnkrt42uasqupbfg8a', '', 12094, 1545207385, '127.0.0.1'),
(293, 'a132blm5ndk241i5fl8pqecb9u', '', 12096, 1545207417, '127.0.0.1'),
(294, '8eurlcpf53mnom2hqu9e4qs4ls', '', 12097, 1545207436, '127.0.0.1'),
(295, '9p3j4852b20656cdqbduvop4oi', '', 12102, 1545207460, '127.0.0.1'),
(296, 'a0il01ap462c6l8c93i62s0h55', '', 12103, 1545207481, '127.0.0.1'),
(297, 'uhfs0t7c005bfocmoadj27ag4f', '', 12103, 1545207485, '127.0.0.1'),
(298, 'o7is4b70sina9llo3j28nupj7e', '', 12104, 1545207488, '127.0.0.1'),
(299, '7q0u5i6e46ntaa2tlf0jeqi46g', '', 12105, 1545207500, '127.0.0.1'),
(300, '32vvrjvcudds12akg9kt5crqhe', '', 12106, 1545207519, '127.0.0.1'),
(301, '55d94kk0oentoiv7pv7vl40iph', '', 12107, 1545207537, '127.0.0.1'),
(302, 'u8v0j73h8av0bsjcctdbflr47a', '', 12108, 1545207556, '127.0.0.1'),
(303, 'ocdedmkk7c03sshanccq1mrt20', '', 12109, 1545207575, '127.0.0.1'),
(304, '8ea3a01gv57366tgiiqrihu324', '', 12110, 1545207594, '127.0.0.1'),
(305, 'qetcu2qae6moovqjh4uu6kqo1r', '', 12111, 1545207619, '127.0.0.1'),
(306, '3vfc7svol30s8e4efe3phkja80', '', 12112, 1545207637, '127.0.0.1'),
(307, 'e0urnaves8uue1qj4otpk6qng9', '', 11674, 1545207624, '127.0.0.1'),
(308, 'ucu0bmuitfl35g1rjq883ta3qb', '', 12113, 1545207656, '127.0.0.1'),
(309, 'e724vuagposagfcgqk0rrhsptl', '', 12114, 1545207674, '127.0.0.1'),
(310, 'm0i1vcc7e3ao2ddakjaplj04gf', '', 12115, 1545207740, '127.0.0.1'),
(311, 'k5fv1np3kl5eq85vfod3hgpvlo', '', 12116, 1545207750, '127.0.0.1'),
(312, 'kq19c4s5136lc4cimvraudjn8k', '', 12131, 1545207846, '127.0.0.1'),
(313, '4qqn6mvqqgcoafpqgfehilv27t', '', 12132, 1545207869, '127.0.0.1'),
(315, 'plbpnqpd1lkd1ab30fn2mrr4mu', '', 12162, 1545209492, '127.0.0.1'),
(316, 'mnbfvj6b2dgjkospsj00pk3h65', '', 12163, 1545209506, '127.0.0.1'),
(317, 'jqigad9718f7h82lrto19ud4bp', '', 12164, 1545209566, '127.0.0.1'),
(318, '2ertq8djjm4lipvuo8neimpbf7', '', 12165, 1545209591, '127.0.0.1'),
(320, 'pq1dqv5avbulb4g6ebhlpsq75h', '', 12167, 1545209788, '127.0.0.1'),
(321, 'pd97mp84e8hllauk4orqkdsvdc', '', 12168, 1545209821, '127.0.0.1'),
(322, 'v90jdnn1kjegl76j0k4jncgbr2', '', 12170, 1545209859, '127.0.0.1'),
(323, '222mpmmg5eb6l1drtvj0ru888a', '', 12172, 1545209890, '127.0.0.1'),
(324, 'rmd9t8dg31d9rlljgk456a2p8e', '', 12173, 1545209907, '127.0.0.1'),
(325, 'liud2gojki3utf62ogc83quj00', '', 12178, 1545209931, '127.0.0.1'),
(326, '5j7s3k7ea7sjdhmrspgolo6f8p', '', 12179, 1545209952, '127.0.0.1'),
(327, 'e9e41up88boelois7ghf0rd6rl', '', 12179, 1545209956, '127.0.0.1'),
(328, '561i536jpdgbouk23pf96aqgcj', '', 12180, 1545209959, '127.0.0.1'),
(329, 'il8q4heb4tfpvqq3ric9blbl7i', '', 12181, 1545209971, '127.0.0.1'),
(330, 'q9kvpll4pt3jiuf74bnfgquk5i', '', 12182, 1545209989, '127.0.0.1'),
(331, '6ukm80b8oftg2ssuns13n8f77c', '', 12183, 1545210008, '127.0.0.1'),
(332, 'rbvkuma4amstkh6stmf7o0ts8o', '', 12184, 1545210027, '127.0.0.1'),
(333, '1p3hvtma68hltss6ks7on8qgc2', '', 12185, 1545210046, '127.0.0.1'),
(334, 'eikl6kruu6sqn0t80175okki1j', '', 12186, 1545210064, '127.0.0.1'),
(335, '18lvbgu30jdv2sadegc2u94151', '', 12187, 1545210089, '127.0.0.1'),
(336, 'jmbrlq9l9aq35js8u5m2ecnhr3', '', 12188, 1545210107, '127.0.0.1'),
(337, '8h4skjbum5dgpv215g5cjggj58', '', 12189, 1545210126, '127.0.0.1'),
(338, 'rvi9ks5ac0s4v73dubqvtkca4p', '', 12190, 1545210145, '127.0.0.1'),
(339, 'k8v8opjvo77rumahpnqanhun4e', '', 12191, 1545210210, '127.0.0.1'),
(340, 'qf9osshjqgtcm5kape84tc84fc', '', 12192, 1545210220, '127.0.0.1'),
(341, 'jjm9l9o5ujnt50isrnckklrltt', '', 12207, 1545210318, '127.0.0.1'),
(342, 'nlb6t29rrt3n9d7e3idi4e4ppq', '', 12208, 1545210341, '127.0.0.1'),
(344, 'b4df2f42085fb886f198299fb8d56188', '', 1, 1545212154, '1.80.2.94');

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
  `status` tinyint(2) DEFAULT '1' COMMENT '0 审核中;1 正常; 2 禁用',
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
(1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', '18002510000@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '', 0, 0, '', '', NULL, NULL, NULL, NULL, 1545212154, 0, 0, '管理员', '交付卓越产品!'),
(10000, 1, '18002516775', 'cdwei', 'b7a782741f667201b54880c925faec4b', 1, '', 'Sven', 'Sven', '121642038@qq.com', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '', 0, 0, 'avatar/10000.png?t=1540833319', '', NULL, NULL, NULL, NULL, 1545204077, 0, 0, '产品经理 & 技术经理', '努力是为了让自己更快乐~'),
(11652, NULL, NULL, '179720699@qq.com', '8ceb21e5b4b18e6ae2f63f4568ffcca6', 1, NULL, NULL, '韦哥', '179720699@qq.com', '$2y$10$qZQaNkcprlkr4/T.yk30POfWapHaVf2sYXhVvvdhdJ2kVOy4Mf1Le', 0, NULL, 1536721687, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'coo', NULL),
(11653, NULL, NULL, 'luxueting@qq.com', '37768ff1f406a7ffeb869a39fb84f005', 1, NULL, NULL, '陆雪婷', 'luxueting@qq.com', '$2y$10$YpOrL9dehAD9oo1UZ2e38ujSd.TuC6yV5eq2yQp2knLBpU09uomiq', 0, NULL, 1536721754, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'CI', NULL),
(11654, NULL, NULL, '1043423813@qq.com', '7874f7ec72dc03d77bd1627c0350a770', 1, NULL, NULL, 'Jelly', '1043423813@qq.com', '$2y$10$d6rrId1okEVAC8yQweeLZ.Ri8HfiBLosXG2A6i05QsGenhCl8Mtce', 0, '', 1539092584, 0, 'avatar/11654.png?t=1539845533', '', NULL, NULL, NULL, '', 1543551680, 0, 0, '高级前端工程师', NULL),
(11655, NULL, NULL, 'moxao@vip.qq.com', '44466a8b2af46b8de06fb2846e4ba97b', 1, NULL, NULL, 'Mo', 'moxao@vip.qq.com', '$2y$10$OmoUAOqSilUDOGM1ZGm1vuKMZLV/oSHYsXUDK4S3h/oJD14MWKFdu', 0, '', 1539092621, 0, 'avatar/11655.png?t=1539770756', '', NULL, NULL, NULL, '', 1541579251, 0, 0, '高级设计师', NULL),
(11656, NULL, NULL, '23335096@qq.com', '63db4462b453ac29a280bade38e8b3d6', 1, NULL, NULL, '李建', '23335096@qq.com', '$2y$10$V.OsAQuPq0V1pymlhE1.yuXE7aJRaKUOVDvB5k0Zj5/SOSNLptzbW', 1, '', 1539092741, 0, 'avatar/11656.png', '', NULL, NULL, NULL, '', 1545128547, 0, 0, 'CTO', NULL),
(11657, NULL, NULL, '296459175@qq.com', '31cca79124bdd459995b52a391d54e49', 1, NULL, NULL, '陈方铭', '296459175@qq.com', '$2y$10$fN8VbuEfd.BWqmVW/Q.zd.jGB4TJWwrsUq/Dze11Mrq0ftNFBn3zG', 1, '', 1539158699, 0, 'avatar/11657.png?t=1539830329', '', NULL, NULL, NULL, '', 1545102173, 0, 0, '开发工程师', NULL),
(11658, NULL, NULL, NULL, '6ab429a22a03c5b6f2a995b486cd01b0', 1, NULL, NULL, 'cfm_test', '442118411@qq.com', '$2y$10$t7tmIS6wo1rUq6Q1pVvjhuxxAxPAQ02eR5jOoBg6.g1vnHq2N9OPe', 0, NULL, 1541489893, 0, '', '', NULL, NULL, NULL, '', 1541490380, 0, 0, '', NULL),
(11659, NULL, NULL, NULL, 'bc6eded8960ff67e12a623d93a6dcce2', 0, NULL, NULL, 'SSS', '1216420381@qq.com', '$2y$10$GfjewfsDXVyiZyB5CcRhnOy85otmO/.1JYgzcgzyJepEb6knLYllS', 0, NULL, 1543890492, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11674, NULL, NULL, '79720699@qq.com', '3246439efda4bbfb58560f0e99395721', 1, NULL, NULL, 'Sven', '79720699@qq.com', '$2y$10$vfghbulezsUSuWBoYOGOT.jmhwC8lEbZ9qtcFVdOFHVa1qKmETNpm', 0, NULL, 1543921419, 0, '', '', NULL, NULL, NULL, '', 1545207623, 0, 0, NULL, NULL),
(11675, NULL, '19067696552', '19067696552', 'f6ffdeb524e1923fbe4c73b92144c094', 1, NULL, NULL, '19067696552', '19067696552@masterlab.org', '$2y$10$ry6kc.n3tVpbapwrJ.gUL.JvkV.uY0vXARkk3mLsg7g1kt1CdQmTu', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11688, NULL, '19080442378', '19080442378', '4d59ffc1b99abbb7dbfab0ed88ba66f2', 1, NULL, NULL, '19080442378', '19080442378@masterlab.org', '$2y$10$.IHrArwlUH3xnVs.uJDI8OJpdXuj0kBhIT4lgwT6u1m6ofvZffZPe', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11689, NULL, '19033082580', '19033082580', '2c24ba3503d2a3c47f53ecb2480296af', 1, NULL, NULL, '19033082580', '19033082580@masterlab.org', '$2y$10$EbJVGt8elgnreSCatKSo3OWYDuVSLdnEMUr1OftBMaSt3cUJrAtVO', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11712, NULL, NULL, '19058175143@masterlab.org', '0e45c8c277ab22d2940eb7ef6750e134', 1, NULL, NULL, '19058175143', '19058175143@masterlab.org', '$2y$10$XOYoIV4EKaFF9T8jS8DEkuHv4inA5Uy16yazNQvrumlq0lsp80tIy', 0, NULL, 1545127828, 0, '', '', NULL, NULL, NULL, '', 1545127852, 0, 0, NULL, NULL),
(11751, NULL, '19034069130', '19034069130', 'ce0c3ca6926af504d90611cb3b73e08e', 1, NULL, NULL, '19034069130', '19034069130@masterlab.org', '$2y$10$hdRh0LbsM9pIU8.5CV25TuOc87C43HwjvCua.uqY.Tc29xq3Iywb.', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11764, NULL, '19025173636', '19025173636', 'fb5b1909fade2e66407017583fb2f437', 1, NULL, NULL, '19025173636', '19025173636@masterlab.org', '$2y$10$yTXDLxYGomfHmbGUYR3pnOdYMIiJhvzwzjaXL1gNGqAV0/1pCemJW', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11765, NULL, '19073057943', '19073057943', '802e1dcf89db5067f9930cb3dfa1837c', 1, NULL, NULL, '19073057943', '19073057943@masterlab.org', '$2y$10$aDpwD3Z6O7U.Dhna3qjTd.0ou.vbUAyv2dJ71mnmyBvmDxVO0C1qK', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11788, NULL, NULL, '19037913285@masterlab.org', 'cc421bc8be6c52e07ed619dabfcc1ba3', 1, NULL, NULL, '19037913285', '19037913285@masterlab.org', '$2y$10$XcmtERNZjgpZRApmElimZOmSCCR4c42.mTwkv9hKAotB4wauRv1jS', 0, NULL, 1545129289, 0, '', '', NULL, NULL, NULL, '', 1545129314, 0, 0, NULL, NULL),
(11827, NULL, '19048139758', '19048139758', '7a671dd9359f2cb417bdfcaa7bbdd06f', 1, NULL, NULL, '19048139758', '19048139758@masterlab.org', '$2y$10$ohMHLxcp4cHvx7l9elJU7ubM0UKBrz1NMRBMBrhLBPiQ68JoGlnAm', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11840, NULL, '19061015904', '19061015904', 'bd3293c86b735aa6996d11442093e0a6', 1, NULL, NULL, '19061015904', '19061015904@masterlab.org', '$2y$10$huHRacFqyQKZtNDAyc3lBO4RPfoURKfvd/zilkAirqTlw9Pki1PCW', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11841, NULL, '19080597290', '19080597290', '90689d380dc6f80219c2ccf83c7aecaa', 1, NULL, NULL, '19080597290', '19080597290@masterlab.org', '$2y$10$sNAkkhuILThncbF174JTMOgAkRtFfB9eMI6Q3/jGS7u8CxuEq.6bi', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11864, NULL, NULL, '19067102910@masterlab.org', '91f18755cbba58077dd895b309ef2bfb', 1, NULL, NULL, '19067102910', '19067102910@masterlab.org', '$2y$10$Gm.62s.1qGgSRye643Sp4e88p27Y/m6SVpmBY1fxl5qnUogGQLdGO', 0, NULL, 1545133729, 0, '', '', NULL, NULL, NULL, '', 1545133753, 0, 0, NULL, NULL),
(11903, NULL, '19045074984', '19045074984', 'a216d58bcc72050182086cacd01a5226', 1, NULL, NULL, '19045074984', '19045074984@masterlab.org', '$2y$10$NKRZpXx5fX/MvqICCSICg.L/RSH6Np334cudq4Wn9537KPLbiBm62', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11916, NULL, '19049173336', '19049173336', '95fd38407729a1f42bd65ad6e79ce749', 1, NULL, NULL, '19049173336', '19049173336@masterlab.org', '$2y$10$mPULV7.F4/M1JLctrP81Wu6UGcSC/GjiysbVS79QBocd3WVyhdFLS', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11917, NULL, '19018075593', '19018075593', 'adbd6569a5786238912a63e8cadf0a57', 1, NULL, NULL, '19018075593', '19018075593@masterlab.org', '$2y$10$YyG0o9.kWVsc8al5OtIi7OiZxQJcXc/6aGnwVCNQU6WXVnOrF0X0m', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11940, NULL, NULL, '19056159982@masterlab.org', '5e439377bce1fd82d750a2374d94851a', 1, NULL, NULL, '19056159982', '19056159982@masterlab.org', '$2y$10$e8VQ9bd61wTtVQwRSOkhIeXAjOhCEC68C8NlitOHboibanuYMInQi', 0, NULL, 1545134984, 0, '', '', NULL, NULL, NULL, '', 1545135009, 0, 0, NULL, NULL),
(11979, NULL, '19036556971', '19036556971', 'fdf032257c8fcb1f430ed61f3a0d3b40', 1, NULL, NULL, '19036556971', '19036556971@masterlab.org', '$2y$10$8eajgqDFnbG9fjGvXtatM.6dpKiF6idZ2DxvfK2bGQAdv27L/38Yy', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11992, NULL, '19081166973', '19081166973', '4e465a8f9336270dfe0bad8cf2b8062b', 1, NULL, NULL, '19081166973', '19081166973@masterlab.org', '$2y$10$svc7MrLJcsgoPp9acqhBQeV6WBzbBGZxYTuQakQ.cjMe.Rk4vfjI.', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(11993, NULL, '19035692928', '19035692928', '858c391daaeb93d6327efb24db95acdd', 1, NULL, NULL, '19035692928', '19035692928@masterlab.org', '$2y$10$cp9TmPV4EXELf..tIntMu.zWFqjc1Hfpk2xmEa8AybM5Tqb.3RIyy', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12016, NULL, NULL, '19075760949@masterlab.org', '6eb5603da27b9a8d46f4538a6189853a', 1, NULL, NULL, '19075760949', '19075760949@masterlab.org', '$2y$10$EhUokj1myARml/yTxwupJ.zOCxMLSq0FmWw8GRe2Q5oydK8ukWLzW', 0, NULL, 1545155058, 0, '', '', NULL, NULL, NULL, '', 1545155082, 0, 0, NULL, NULL),
(12055, NULL, NULL, 'kuangxingzuo@hotmail.com', '1d7a59ef318d41ed3eab35488a7c395c', 0, NULL, NULL, 'kuangxz', 'kuangxingzuo@hotmail.com', '$2y$10$HHTIzji7cJyqDM6jK6c1weD.XaM5c1W2fTWefCk2tXJZNYPqdMr36', 0, NULL, 1545180823, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12056, NULL, NULL, 'kuangxingzuo@hotmail.com', '0cfa311226a8906848a23726611fd856', 0, NULL, NULL, 'kuangxz', 'kuangxingzuo@hotmail.com', '$2y$10$5zBkE7pWrAyiipWZQ49/OOPp1RPrjeJkECTowvZuA9shXYbBVML62', 0, NULL, 1545180843, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12057, NULL, '19024709494', '19024709494', 'dc17b8cd88be40c192a7449de67c36b9', 1, NULL, NULL, '19024709494', '19024709494@masterlab.org', '$2y$10$ICl6ytH5/EwqWcYrsi1Ch.SYD4Lm46wovcNteg/bYuKrV02qERdcC', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12070, NULL, '19089057835', '19089057835', '4e2d025da0a2e3bcbaa8ef29e2d23268', 1, NULL, NULL, '19089057835', '19089057835@masterlab.org', '$2y$10$7LhZzOO0JhAPJGTwI...D.p5Ztu5kWK6X.8ljYkrFg5/l.PMSjiGq', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12071, NULL, '19040484985', '19040484985', 'e4fbdf7ad687b1a993bdc5e85a9f7dec', 1, NULL, NULL, '19040484985', '19040484985@masterlab.org', '$2y$10$j/nRiZsuBL826OMvHQQUQuREKvMW.zJozin4i1QI3TiUCCSKNYjDq', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12094, NULL, NULL, '19053443583@masterlab.org', '081680c2e9ada0ef23cac0d87f9dd7c0', 1, NULL, NULL, '19053443583', '19053443583@masterlab.org', '$2y$10$2apvbfYE0gWOP6N9HfSE/uVsrLLWP2mzXmuxwj7JkyZ2Vsc3udRTy', 0, NULL, 1545207360, 0, '', '', NULL, NULL, NULL, '', 1545207384, 0, 0, NULL, NULL),
(12133, NULL, '19077408211', '19077408211', 'f645f07eaceb4a57d11e3b2bfc676a67', 1, NULL, NULL, '19077408211', '19077408211@masterlab.org', '$2y$10$S6qcRrCNxWki0CtquI/RPueUlnhoDPV2UiFbUcA97N8GpX0JNQWYi', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12146, NULL, '19077577212', '19077577212', 'b2f83f777418a375afae87567a92df0d', 1, NULL, NULL, '19077577212', '19077577212@masterlab.org', '$2y$10$TZhdGvw9Ns2f8fV8T0v0R.fJdvD9IHWf..qhRSX6Ma/uZlbYgwAaW', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12147, NULL, '19066700793', '19066700793', 'ed79a840dd6ab2131e0e2687ca792197', 1, NULL, NULL, '19066700793', '19066700793@masterlab.org', '$2y$10$PixFaVDC0fJKa3eOjOcYZuEBxaeXfdIPyv/6VePq.wrMHF2J9SrdC', 0, NULL, 0, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, NULL, NULL),
(12170, NULL, NULL, '19081833341@masterlab.org', 'e03c68e9a548ac7487d49987b8d79645', 1, NULL, NULL, '19081833341', '19081833341@masterlab.org', '$2y$10$HLty8hp6SHzf8aPZXLoyV.WcRXOKikQS1SpOPGzC4eRtNCl0F30v2', 0, NULL, 1545209833, 0, '', '', NULL, NULL, NULL, '', 1545209858, 0, 0, NULL, NULL);

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
  `user_id` int(11) UNSIGNED NOT NULL,
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
  `user_id` int(11) UNSIGNED NOT NULL,
  `_key` varchar(64) DEFAULT NULL,
  `_value` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_setting`
--

INSERT INTO `user_setting` (`id`, `user_id`, `_key`, `_value`) VALUES
(8, 10000, 'scheme_style', 'left'),
(10, 10000, 'project_view', 'issues'),
(11, 10000, 'issue_view', 'list'),
(12, 11674, 'scheme_style', 'left'),
(14, 11674, 'project_view', 'issues'),
(15, 11674, 'issue_view', 'list'),
(20, 10000, 'layout', 'aa'),
(46, 11674, 'layout', 'aa');

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
(1, 10000, '8645b77af5d88897cf79a34e5859e17fe76fd248ef2019a25696df37b774b277', 1545204077, 'd00095c5cb67a854e961e9625c8bb2250be0cf479c445a35e4530d1a2b91a979', 1545204077),
(2, 11672, '8cfe95bbbcd7157b755eadb34d0ad288d777b4bcb285774688527aca2d99f4be', 1543921269, '9a89ba630496c75afe47b04e6de72982a63afbd658b222e5effb3de1d775636f', 1543921269),
(3, 11674, '6e2589e719e2373b44761e2497254dc5c40b098625b6b2c6c9e90b66b9582800', 1545207624, '4057114a0dc539466a0d6e6c914272cae45467f941dcfdb06db7c1b670043155', 1545207624),
(4, 1, '6e755f4bbad80855731fc36de4392d8187515cb09cf021d3375217fcbb790cab', 1545212154, '0c347584c36cf32111e8a912bc210f365b3eb0f3d2246b922f5b1a7759aa70a4', 1545212154),
(5, 11657, '40091f5890d6a78c3319bc123911d157f46f1da57d15d9ef5da5dc9e3bbb6cfa', 1545102173, 'c2804056689c72a486ae99ba94898dda1ab45ac6d4782b764d20f03d093bb1eb', 1545102173),
(6, 11704, 'ec977ed7e2c13dd309be5eddb038daaeabb09187488a3ceeb5cb073046ffa009', 1545127502, '806646fd81f754f75f8509171bdfbcd1c58eaeab9f6addcf17e07e6a93b22ab7', 1545127502),
(7, 11705, 'af60ba1c2751a7a7292959fff659c1c5fc90236d6e3648709fc34a2c57c7ef1c', 1545127515, 'a0b7a5d380368342b290ae951d732f2e8bc45ec6a1391b2ccfb1e34beb67cdd1', 1545127515),
(8, 11706, 'c33fe757e5e22664213420cd4b34eb21dacfc1269e407ee7cc6014a73b1c7f60', 1545127572, '9cfa34fad2ea2e8dbbe94c5d4e972f82c287fd28f7daf2de15c81df5af634da9', 1545127572),
(9, 11707, '89e50358d635632845f24caa0a87bc16e17ecb637a3d28fb123e16086ad5f4ed', 1545127595, '91093495b519833082171e2bde01aa216ca087327a89b2ea0b3db03e963ecc46', 1545127595),
(10, 11709, '1f546cec0075d98833763dadf5109dad292d1b382105d801922f154f347d312e', 1545127784, '3d0163d0462906c1761ce41e9df64628d145bc4684c97ff78bc0ae5f1c123fbc', 1545127784),
(11, 11710, '7a40d3124dfb1ea3797331ce4fed1263ee1944778b2f8a2cca1b027938664639', 1545127816, '5ae6f5fd2a6e399c4b99bec2779da0931675bf5dbee0ea3ceb9280a9e2ee1e60', 1545127816),
(12, 11712, '4345d6dfa6521e329ea99d301092942c12ebcfbc5911548278765ed24aff79e2', 1545127853, '3e3b72c5dec41d723d938b8549c9d3a814de7ae93ed1c0f19967f00de75c3288', 1545127853),
(13, 11714, '04ce6ae25d5c801bbd422c7d682e196de01d9d8476c04c155484c2c2b1a38b82', 1545127884, '2ebb853cfb8e982832d1c03f6d810cc42a6c8991c0ddfda0c3d96cd25fdcc359', 1545127884),
(14, 11715, '340437c5afd6f926d9e0200f306f9992c3057d606e8ab9cf9d81ec60e1baf49e', 1545127901, '3498fff34b3ec9d5c261685088356d921eb10fb1aa773137e4b530788de12400', 1545127901),
(15, 11720, 'f73d844ec6d2c77adf6e7e1d6306f473a252774cfeca83c7a52e82a9dc279bd7', 1545127925, 'faf2c25fc7ee3e75c59f0f43f84ef1329f83fc465c59eab2a8e81938a6faaceb', 1545127925),
(16, 11721, 'abb2bfd5cf6056acf9199913f191de45b0afd2069fea1d59066d2026f78065e2', 1545127949, 'fe04cc3333d00f14ad046dd29b41318a820c227e6bb07ecd23596334ab2e2cf9', 1545127949),
(17, 11722, '3b1fa1e0352e5cfbc7ab27515c3bedb719e82ff6addab497ffe5873d0479d098', 1545127951, 'fa909238ad6c044b7992f0409a7bbf18602ed1421156bd4c39d82523b6a13c21', 1545127951),
(18, 11723, 'b04262f2e20c8a1265ab7f4347ed6d8b3e9905958118f716951b1bc8a506c811', 1545127963, '55557b2b9f51807d0916cb4538bbacd8141f99f3e78e125b2ec175fb51f6c282', 1545127963),
(19, 11724, '1fa8fdcf73975462f73d15d8f2a0b7eba9501a284ada6f170a7341002b09f3ef', 1545127982, 'cd056fa6edaf2220293c35674835070567f319c0b6a23359ec9ffc1b4c13be87', 1545127982),
(20, 11725, '67a3353270353c6ab924800902e19d829c52f232ae0bed222dedd69f40d1229f', 1545128001, '242e093df7c24e857753c1e7790c7ddccaaff63d9c8d27efd88793fb52da4da5', 1545128001),
(21, 11726, 'f2c4d90f9c886f881b92c836b9320c13030dc00c126fd2a21eb1ff1dcf9fc220', 1545128019, '80f28232693ddd37efe709b1b07297194ff7827d7d4d442c0d92359b57a7afc0', 1545128019),
(22, 11727, 'ec2af2fb70b206a482933fc35bee3c5d1dbcf839fb80fd11960357efe6d518d8', 1545128038, '36957a1afe87788b03fc7a68db5885c4142de8360a329534dfc7eded1d90faf8', 1545128038),
(23, 11728, '469e171b1d4fc4c3780c817e5108eed62ecca4db0427b34b8bbd8dc5671ef234', 1545128057, 'e2606c1575516e7b21d5025dc92da6dc35c28e54e10fbf606f8ebc49bf75a30c', 1545128057),
(24, 11729, '51ca5f3867d2d9363dbfe2ec89e57f7ebca234b6251f8b0f4c637913c4725370', 1545128080, 'a5a92eb7c51c4299c52f147bc8126c10c2f65388fdd5fdcc8a7ff12d69bfbf71', 1545128080),
(25, 11730, 'ca4168e80f32e30909284f7cbafb399a9db9100d095a0bdbc5a5c5ecf124f976', 1545128098, '7dca51be8159accc8f04e93ace5524717589237dc40c43693ef92e530b8e4812', 1545128098),
(26, 11731, '8b471769a0b3993b273b06aa825ed1e1604481d2e959186823244b8b68851dfd', 1545128117, '9943e986546532f217d6ba955ecee6c40c00a8538b346f496659b7f08a2ea4bc', 1545128117),
(27, 11732, 'b26c027de1ef22a342ad1618703ed35cefb4e1b83273d393e1c2212b3e4001f1', 1545128136, 'ce032bfb2940c3aa2dc422f28763a97a0d94bd7b7f00c8966e7059b223a9117b', 1545128136),
(28, 11733, '7eed363fb8e9bf4419037cfab91f436777bef734fd61209c6abebbf9abcfc3f4', 1545128202, '4819b74ba045d494c2be1e1482c6e1878303185f8c6b76df00ed5f8d65d282f4', 1545128202),
(29, 11734, 'e0169b5e70f982a3f27f8c2b0f204cf26d80e68f6c1aa4c7c6f5d749d78e89ca', 1545128211, '864c6a467cf1df9e26e05f06e8eb6219e6b3734d82bac632c9ded1266997cbd0', 1545128211),
(30, 11749, '11b2e8ab1f8b9eaff4c33f54e3c6ca5bbfceac0030403634ee2474adcce7de52', 1545128292, '4f5b3ed3f2d527fba93dffbe928d6de9c8387d2ce2275bae5d9f288fb93990a0', 1545128292),
(31, 11750, '25c4f792aa73d8a8978bdb713c1046e8ac0240faebd71bc28b8e2ae3f2206d73', 1545128315, '73cf5ff892af6645c76e8f02eb36cf9b772f21361b7c58f4a83da15c80ccb9f0', 1545128315),
(32, 11656, '6adee74965ddef70969f4ee7d5bc793e0f5913b9d37ed3b7afde1fb278d6f8f4', 1545128547, '1cf6bbc1b16f51be13b52c0d6d3e5cffeaf99e9a4511d08685ca9d1f91da4a76', 1545128547),
(33, 11780, '4440cc6225f2be051a4434e804fe545904f5e67fc7c41ed745507eb8befb18f4', 1545128964, '84eafea832b7e390d4c8607661f99c9dbc0ebcfa13a79281a8c6db2d714aad52', 1545128964),
(34, 11781, '83fb4340117fcee4b5aa219d75f5505b84145d5306e1445087a5f9d51a195367', 1545128977, '48ebc15e23619153981b235b8c05b1c7d61dfc8d954fd59f812aa6f0d199a35f', 1545128977),
(35, 11782, '747c9529f5689e6b63222b350ba76978bdf8e87fc8b21efd14cf80d8bfa60e88', 1545129034, '59b65fceafb462ac5ae1d987f83e91f490927f3f370493cd2c9ea2a5911cbc1f', 1545129034),
(36, 11783, 'c663cfcb364af26679c72fbd89aff226017276ae925e6898853e55e948cf0809', 1545129055, '130fcc401b9be446984989a734ebbfa11a04be47d97aa5c98ed70a5899bdd8c2', 1545129055),
(37, 11785, 'e1fc8eae8f05db36456f7af7d85d04e7bcb4af4e4033701dbea043dc8e4f54b4', 1545129246, '3243698070104f9624b8a85cdab7cfc9e69cf55363b697d9237db0360b5171c8', 1545129246),
(38, 11786, 'b07f8e37f700f616782ad29b73b4c7fce9ec8d31fa660ec5d3f682600d7afb3f', 1545129277, '0ef464a141c4da5287f17a1531c89ec3ef9bf561fd89cca4db92fcf0e3b95c12', 1545129277),
(39, 11788, '8c0eeeec3ecfc810b107dacdb8353fd6f2ef9e6f9fdb88f1587a8f88af4f57dc', 1545129314, 'fea66f447edf4ab13742601cde4a4a827ad0a441addf34f9db923eecb467fffd', 1545129314),
(40, 11790, 'b0f35cfa5b6f9eef449c8de5c0daa95b2cf05a97f512e5bf4fc377810bd646b1', 1545129344, '67e95132e7307a0b6c8dc8ca188c7127e4f7cb3677ec917695cffa618a0e5594', 1545129344),
(41, 11791, '7e3b49eee12e6028c6e20c40f0c24f088e964adee6e9dee0f301503a2fc09b29', 1545129366, 'b7966e14bd56ecbfdfc1510f55fc43d71ccd53ed132680b2b5fd896ca57385c2', 1545129366),
(42, 11796, 'b2c9da2ef8f9845b462b653562089f30452a5fe92c01ecd0d25e2eab60e381d8', 1545129391, '02dfcb7ee8acc116f64e5b961f9144921f8f74a27fab4c92c910ec650f42ae39', 1545129391),
(43, 11797, 'bf172277874151b9735f35b696d2fd28792e35ad3eb5ce392feec17fda0467ef', 1545129415, '67193f99c4ad6880cd2cdcbcdaf8545200ec5ef008fd8f233950ac6d7602a45a', 1545129415),
(44, 11798, '12fd069cff2fd0b44e6a0df197112fb2b9dc7c1a774f4dc5a0e4fa7bf1e6025f', 1545129417, '75f5a2664dec0e00e6830ff7a674aac5a250b9e41cf4140d3a08b9b6d6c99684', 1545129417),
(45, 11799, 'fc3cee0cc4c01a7bd671997484105daae5891135a2b8f9cae73cebd69cc8b77c', 1545129429, '81b07d4fe4fa489bbe6b5deb039ce298a104bde60cd5091afbf5cf7398773920', 1545129429),
(46, 11800, 'c9af72a7fa7898f00f4ab25bef2e1337b51ceb53f7f1eae3a3eb05f3de88b137', 1545129448, 'da44d189814c94802a2cb283eb74788170a2cc7048a2f2c275258bbc80c58d51', 1545129448),
(47, 11801, '2d07ce6d0ebdab07a4a624dffec5733a70aa76b6bbf6bf207f0575cce5a59b8c', 1545129467, 'aca8df185561fd2951533171a599c0c039a319af44817913141854304e81dbca', 1545129467),
(48, 11802, '471b6242d94f3cee3eb52c135a8bf4c17b0142d127b6bcd423b0776865d51b7a', 1545129486, 'f17c68c248a5c6838fd579356f9e09b7f449e930b9a1790010180a8980717156', 1545129486),
(49, 11803, 'afbd577c3b02b9cec222c1efba62d7e4af154a9bd7958ecf35cc344410ebbc13', 1545129504, 'bf57091bf53edcac1b011303efbfc4b0ea315b62b1c82273995ebd204c23f8ce', 1545129504),
(50, 11804, '4f9c6552555179f274ad741a965dae5c97f064c850227794e86491691c19de04', 1545129523, '099623e07c281ae03405561a6d5fd10e9525c8516979881647d838b8e4dcd40e', 1545129523),
(51, 11805, '8896441476458db6d61b8b2f71dd1bfcc6c6e2df6257d45b3a6e3b4565ea566d', 1545129547, '1541405cee89eae694e50f74265cce4379fe5d0e697b1fae1682f1d7c2452507', 1545129547),
(52, 11806, '922be406761c61ef69fbbe4e787677ace4a8630fdaf8c4c9945f583b349bf529', 1545129565, 'fa41889b8e6f8f8612b0cefe1cdb746e27acbfadc7348e1507824ea170608a99', 1545129565),
(53, 11807, '112aba2126e21592a2a9762b1c1646f74e4065dcbce899335e733542f6e90df5', 1545129584, '9ffe18bc25405da00082c3158ef77944d79107bae542fd98f78a8d2cae2311aa', 1545129584),
(54, 11808, '8ca057bea672cd157f313bcbdffd4989e77b084e68a1c47d2e97acb9ab723f88', 1545129603, '9aacf48be3c8b8bcc659f06429d52ac4132c18e7af58a36bfef0ef6883ca1f40', 1545129603),
(55, 11809, '1eb0dd67818a214e4ff55a4cd76f70e8ca3ee65679bd1dbac8d2c687bdb0dbe3', 1545129669, '2a41d5d963b15503acfe18fdefec603f56dff50f91e0c3aa039128e537700291', 1545129669),
(56, 11810, 'acda4a3eac6076373debb1489fc834dccd8435c8074ddf57dc8bf8e652b2814a', 1545129679, '30f03c31c18ed5b75f626e7ab3b8ce0e82331a39d505bfa12ab805ae6d6e7823', 1545129679),
(57, 11825, '5d3aaea96a7c2259ccb160284abd925723a0d35ad06a0ff5fa16b5602019b409', 1545129762, 'a0eccfbe8e8e90005fdf4166981d708ccbfae8e543aca86c7778a22ad3bd56cb', 1545129762),
(58, 11826, '1a281eb419758f15a79aee457871776ad2828d3de16d23ad79351a9b42df086a', 1545129785, 'c2a5bb988535484719dbc5bfcab40ecab15a9b3a3971cd160d4a904f96a6fb14', 1545129785),
(59, 11856, '1226d13db7faf3892482e1261167ebd7260644890bd5eb9b4db0502c31ce33ed', 1545133382, 'f44e82d0b5e7693315953543a3f6b1b382d15d02e62cc94d667905daa688ec2c', 1545133382),
(60, 11857, 'ef4572f410d939c3c093cb1e2ff7b93e48a2f0c05804aa7e0110e15bf7ee1278', 1545133396, '7edd28e523878fb53b39f4627b03653e436f9ed1a3f91ac41954b60e487c66b7', 1545133396),
(61, 11858, 'cc43a7862524a08697ea814dc724d83cc6590bca9ac0bf5134d56d90f009064d', 1545133459, '47f274c137322ce10fc66c374d2367d8627bb93ac4de623e43dfd61f16d371a2', 1545133459),
(62, 11859, 'b7edd0e2a808608a4c64a3ae27af4037ea73118e035eac8e1020dc57386454a9', 1545133485, '4c55781ca05aba6535ecb58e551e205eca9e107961b3ca90c51c715b01526b33', 1545133485),
(63, 11861, '8df3dde89f81d43d36ccc560923856f1a787fbeba2fed1a1fa1922bba410120c', 1545133683, 'b748b3d0249ab6db9a9d8d9ff8066295cecaafb5249006b97398db4b067e31c3', 1545133683),
(64, 11862, 'dbbdcbdec30d8a8ad795f136f600872f552090e3208da5bde168e30aa88751cd', 1545133716, 'ca425de7f9cdaebb1e66bd4796ccb9548ac69245a303e637a461d5dfe3eba7be', 1545133716),
(65, 11864, 'cc68ae6f7bc90140590701490c38d4fb2cc9f7ec6ba6a51c764f3ead80cd9f90', 1545133754, '917d3546e839a385c805af0887d8151f635b91339b9d0d628d4cd8de532f85db', 1545133754),
(66, 11866, '25af487aa1cfb0a26580531bf8e9602c656f3812a4e8d5b2f886bd75d84f253e', 1545133783, '2dc9cbbbc1e5f2438cd1cd78da2e6b5cada330038b701b63c016ff550f84a512', 1545133783),
(67, 11867, 'a7828a0f643fff88972fd13bccefd3a28c28e7f7a9ea214a4243f07c65e6ab82', 1545133801, 'd630357588915496cbb5686b4cb90a791aba7c1017113041b1c84765d1717a66', 1545133801),
(68, 11872, 'ee57a0bff27830815c14a60b3b9dd0a05e70335990e8c79aa6fb9f3ffe7f3455', 1545133825, '56607a32c6f3837523f9e22465701c47430c16a5c4ebc18f256737ad5211cb65', 1545133825),
(69, 11873, 'cb5f03acaa83f7f2a5c1be2f6c92194ceb53c628e3b03ae195ac1f675629a1a2', 1545133851, '96767efe6e73206e0ce1bd3cd0c71fbfc56ec85db34dbf341dea4e849adc1676', 1545133851),
(70, 11874, '28895d1363ffeb2080061740dbfd8b5c2d7ef3345b70e684f74f08ac98120c4b', 1545133854, '514513b42c8f7ac44451b9e363c8324b7a202e31be93269000eeaeeb3013b4e7', 1545133854),
(71, 11875, 'ffa0be0e57cef017e3b009a2b66d8fcd769a64f3fbb0ce6b129c6d189e4c7f75', 1545133865, '1f24c1621a2af7121daea74763d5092be03af39bca0b2ddffb31fb83db517154', 1545133865),
(72, 11876, '1c0fdb5bbeaaa9fa815ae20dbbec12c66bebd32aebf277a12606d1fa6b8a08c7', 1545133884, '7ff1b03a39993825d9ffa269d9bc2a9c0b574775f7bf88e95125ad48c2cd2dae', 1545133884),
(73, 11877, '63b4b7e16cc352d0ca25993f0a671803830f02b27f5e2fd6ea96e12e5c000218', 1545133903, 'b42e6b23b1a1583d4d67bfacd5073897adf675c3b8e3e0bdef4955a05aafe2b4', 1545133903),
(74, 11878, '4a2b5693e6113aabb21ccaf950ae9890604c1a87b922185c4cc4123bd2ae033b', 1545133922, '5fb24059372ea8e8db77af1e2628af768c1f0d8baf5607b55fc09a344f85a710', 1545133922),
(75, 11879, 'd5f69ca3db55c049e4548738413eec4062a84a6ddaa07564da3efb07082dffb0', 1545133941, 'b9997eba19b5592d0cb44ec77a0b7db6362ea330993d287d495d7af68e38be9a', 1545133941),
(76, 11880, '35630e5a1b1554ad039f6c4cfb87df3fb796d6bd7c65d00690c5278b4bdda8c6', 1545133960, '2b575ceb49dc7d1b9f5fdfa42da6cf0d6dc67c4ac83b53edbb0e71fb087f01e3', 1545133960),
(77, 11881, '5a206fd2c0c21aece284fdeec6ea5ae7cde95c0a0dfde0da34ccf86a8fd54e2f', 1545133984, '0fd2bf996036ef7648bdfc8090edcded469505181c629c05922b6f186031d2ed', 1545133984),
(78, 11882, '13a897b6275dbc96e360ab97c5921b06e8a4cc7673eb7b63e96d61ddc121272e', 1545134001, '6c95e6270ee3b196ee5f0a6c00f438332cf2e96d49eeb21853eb116ab937b577', 1545134001),
(79, 11883, 'e415621f38889b4701335d45c5475d2efcbb195dfd8e8d9cd192fbdc29f77709', 1545134021, 'd29d35343f804eb299f403f2c68341c5d2fb4ec171ce22bd4a36d470cc389bfc', 1545134021),
(80, 11884, 'd5783d95834eb771b3049e5c23dea3532bc9630535baec4fcf23653ef6845bed', 1545134039, 'f5d4cd23c030bbf13c35f47ec064cc57764da7cf2065e1434b9d8b764d24743d', 1545134039),
(81, 11885, '957c47738c5e3ff026ccd88214548dc688e2ea4106b7a57751bbe969efe5c298', 1545134105, '9b53013a5d10bd7768966ab27552eda5e72ec6afe321899bcfc1bc92a831ef8b', 1545134105),
(82, 11886, 'a78b42c74fd9e32872ccf1ae42e191d31398df9482d8aa7c2a65889efa70d2f4', 1545134115, '2faeb58d360e49fd845b45241e769dddb6554fedb7dfdb612e03357e5b84240d', 1545134115),
(83, 11901, '53416ce65f12688c56d79f2e262ce09be40f0534b08b9dd1fa46c8e9c327934b', 1545134199, '38a941602f1bc61333e8d02d73ab0d37d80ef5b3c44c8d54b462985490af8f31', 1545134199),
(84, 11902, 'f2f9df4d201664cdd1bd4860d49ed0b682080defaaedd5817a357008ed533051', 1545134222, '32ce19a858f36a3effe339e813258f2a64e6060a6111887feceefdc49682f7e8', 1545134222),
(85, 11932, 'b807333845f46a950f3d1a8b23374aaf214d1057e5f3c17c5a3ecdddd9581930', 1545134645, 'ca8900bf260b5cec574238b3afda184d9bd247a28fa84be7022cf3a5ecdbd711', 1545134645),
(86, 11933, '918e5ae32dd85df0419601317f606e6afc19a4a8afaadc3128de6727ca0be18e', 1545134658, '12fb67fd627896dd8242e138a0b9114bcce8568f6331bc9d7693adc49fc56892', 1545134658),
(87, 11934, 'bdc4f7f07be3a84904dfaa266836c26422941742edcccfb22205b8a996842b7b', 1545134719, 'dc8bb6bdae263e03c3e4e98d1309416eeb6d9a248363b906a443d0ae8bdad6c6', 1545134719),
(88, 11935, 'fa3aec062144fa17c27aa03932fe15a11db88a65b72211d68b32191b8b23f331', 1545134741, '617298b09c07097f1c39604fe4f7fb6c1b94ecc7a141a7a7c5516ed4640ce4ae', 1545134741),
(89, 11937, 'bc28a797b38dd60491b0f2c1da478ed566c624fe8a08e61b487ca478a7ab2239', 1545134940, 'cc5fd0294244a73b5b24233c2e27907452d4e0d95d9ac847ccbd27b94afb9e50', 1545134940),
(90, 11938, '46c19000eafab6be3b279a9f64e846332de79ee678e2e678e28c5d75cd46f88a', 1545134972, 'cc8eda8fd05a4bb9c628a20dfe4d888040f02ee87fa91efafd31ed55ef15f492', 1545134972),
(91, 11940, '36efcf887bd3e51ef7a1bf694a229a11568640c0f4e82628a4c2648b02626353', 1545135009, '3fdc30ae8c563c3f29798d5a862fed5c185bf158e7873f408de6db2ad6befc19', 1545135009),
(92, 11942, '352153e55929f307e661dbf08286f30353222e6d1b9873cc14136e36334a8470', 1545135041, '15abf3d83a3efc0589ad0f5b81a8a2024e1d1ecb3484e77d32f04c8b46a00605', 1545135041),
(93, 11943, '66e8b49900c3a4a17d8581d1c5e6993a97b04245ec6757ae25b8f3ff6bff6f5c', 1545135057, '54fbaab6d4349e97ee49d95eea95a9e565c53f0974efe53a670933a851e2e1c3', 1545135057),
(94, 11948, '731967ea4b0635f16cc79cdd981c5316ed5220ca88df1b85afa0cac3ee0e334c', 1545135081, 'b7e7f4d7088af97a98a4e15a4f58b329aa4603e6eb2e772e55723cc976107fe3', 1545135081),
(95, 11949, '36164adf3fa923956919f9e8a0dc4fc66e59b29bdf8dd8e8555388324d331078', 1545135107, '450202317babd1150d90a0f460e6ff37664f15f0fe2e2f5cf7631162b2f699b1', 1545135107),
(96, 11950, '1595c6d899dc1be507c629a97118a2732702dc6f15dcfae1910ea26e3e5dafe9', 1545135109, '3803cf3e9bdb468c4747c4a033135c0e8f4673d2ba0e50e68042408b490690b4', 1545135109),
(97, 11951, 'f605794629935338b26a89754b926b7a05ea1a405dfbc547ccc01fc713cfa4f8', 1545135121, '112eadefb3844782a5d06636ed5ecf678587b6c1d6ac02242ad491467804add6', 1545135121),
(98, 11952, '9898a844c80e137cdbf04b0f80b264f54d12b516b1a19ff7c36686e2c6d2b777', 1545135140, '98fffe999f5c972d0eb645f7cbac364a7853c2fe4bfafd95e3c4bfe61fc3e40a', 1545135140),
(99, 11953, '627775e84727a1fe871d7f2311c70ade8c24c9acee423ba4078d9a0160f5529f', 1545135159, 'a3b537c9712b0e3c7e47168aabde06977eb13aab187c53a715f79a4e454adcd3', 1545135159),
(100, 11954, 'a4d812ff1f7a2cfce93cd572745bf9fce5802cd0e8add9f80811367ff919aac5', 1545135178, '3f2e7f119e643915677f49179558d9cce91f655ff83bd631e72756cafdbfcc99', 1545135178),
(101, 11955, 'c361d74e873b95a00149b23ef7a356228252b87dff5125e41297425848e74d2c', 1545135196, 'eb30e21f1c4b90e9890b40af7f48580b3cd700e0d9aa80644a39a267b8a19a46', 1545135196),
(102, 11956, 'a4e1722e314cd44a85d1e5d09652a558750c7043d4325b6774d9d1809841e19a', 1545135215, '5c4b56dee001135e3e19036fb5573a70e7cce3a64a62bcb567919ac62fb09310', 1545135215),
(103, 11957, '30f4d9a2dff1d1587133d69b88fd6d7257d84141a409657500607b33c43e66e1', 1545135239, 'f934971432ad37596582d58a3fd947e0c4351f9e86467c024697543af114e361', 1545135239),
(104, 11958, '50c003c0ee3fd81e390fa4c1ec5251153dc3a7d0fb9cd39c09e6b26b80c8282b', 1545135257, '460d105ce5834c3ef92d9f56436dc763ba2f21d0bcfeab35cef65f56cf9a700a', 1545135257),
(105, 11959, '4124ecaf0af0a56c3e6f4c6a7344c720dbda5e323b1ecd1698f1f74e18a93498', 1545135276, '780d44b08193370972fcaf9f026906fc4fe5c5d8828c57fee5197e9c158621cc', 1545135276),
(106, 11960, 'ce65724e3d23cc37f859b6da02728fc418c75e0e7b377ec9f1b04bc5956a807e', 1545135295, 'f8b6392fad9e967bbb094b45f48db8a53e991422a087ba212f05d3f725b8bbba', 1545135295),
(107, 11961, '97a1738e708bd0876029a5cc321ab30165c747ffbd884a48192a60f087933992', 1545135361, '8ff7892131ae2014cd2c6563d0276e19316da1754b23f6ad443a481d2f146233', 1545135361),
(108, 11962, '38bf7b857410bf25d56c1bc4fac630222dc72ce0457d0c38550235a7d1aa9ce5', 1545135370, 'e64a232ec3fa4b02085f9dc9b353cec5150d0ab52072c13e0a95c03b45b248fd', 1545135370),
(109, 11977, '359f410f1a0cd7a8c1b28e6d46beb2fb558e142c8ca7825df86c7265cf8420c3', 1545135457, 'e4a146297b49f292d047e3f079cc768fedeab082522475b6d899c8d4ffb75d9b', 1545135457),
(110, 11978, '81f955e9f55e26c8e2978e20685c4caff374e564326b3d138617937033739ba2', 1545135480, 'd31ed304538b199cf5f804ebee53763e2a11ac4b57c344cb85e842538fc00183', 1545135480),
(111, 12008, '87d2d349b96701eddbbcda7b092bdd7dacc4ecebbde3427a2c9faf2ecbb7b26c', 1545154711, 'c30b6a89b6dd759714a8efbfd81739c64f4fb13a78821aaa5a0223cb4f97050e', 1545154711),
(112, 12009, 'cfd79431dfddd6131f4089d01beb0e2a874eafe7fc2fec433efa58c620d9a060', 1545154725, '4c1a58656eb256d5d72c53dde6c5074dd11595b8dccfcb45dd5902143d802d4e', 1545154725),
(113, 12010, '0517df73d9dbcd0bdbb4c70152a6a36ea10513212f7bb7e3042fd2aa27eb8086', 1545154785, 'f6819d7f37fea7af04b1b9a0f11a1d2ff9a982267c6768971346329c9e8d38eb', 1545154785),
(114, 12011, '0884d8ce85a1bdaff2af9927c2ebfbb29ab2d6dc7e3ccb86e714352c02ca274c', 1545154812, '9b1760d80e1ea0c228806896f6a70f8a6b9e7aa2f223f18d080aaf0259964ff9', 1545154812),
(115, 12013, '5c868d470bf24b2ec615b9b748066b452f01af5a9e25519d6c2ccd30521f0ffa', 1545155013, 'c88cc8f8f50690d85aad05fa60e81ce6ee54d84880b766ba32463c7f1475d8cd', 1545155013),
(116, 12014, '62c6bbef1c2dd3f37b24de3b2af52d697ccd70c17880e98b2ed04cd9625cdf90', 1545155045, '6a87e1a548dd675113e8dd40c6fb722dfb459d18c7c1f57363645639274c9b62', 1545155045),
(117, 12016, 'bc9f046de81bb680cc15496d24fb456c5f35427de81814e628beced8ca9626c6', 1545155083, 'c3ecc0ff7c221cbcf29cda90d6cdae67e024fcb8f78d3215b6eaef2479d28e07', 1545155083),
(118, 12018, '284782be65bfc9489e69f111fd40ecee883189ac70dad84bb44c6b6166eb6c33', 1545155113, 'b86727ba2e6cb92d85ec9f491cac9e84b21e4dc427b0b041af3c5ec8ed4cca69', 1545155113),
(119, 12019, 'fc8c1355c36f7f938d5a6a7b6d09aba97035c9b4b7d434975b85a32c514da0d0', 1545155129, '2302b41b43303548b3ca830700b24f4beeb1b4c9b76894c6cfdb82aa7a4bf7a5', 1545155129),
(120, 12024, '7fbb88e737819c4a309d1ec2d891174f27ec17be770c58bdfafd54794c17561a', 1545155153, '63ecc035bd9cf7183d1f52192f20de2b4e8e7f7bafeea328f34b1837d6d06c12', 1545155153),
(121, 12025, 'c9e693ae849e751703d0a459a613be7b5ac17764bcc4c1096b76d13799b5da19', 1545155179, 'dd71e3ac193c758d9ec3249f8637135ed78c2e999aabf686475303d9dd7bc563', 1545155179),
(122, 12026, 'e987af13ed93fbbe869097ca3070ed89eb7767d83827724c7fa2f9da72b0312f', 1545155182, 'b1cd6d8ea89da7d3f9f9af969d2e827dd7e3e3894651e7ec2fb1a570bd7cd1f6', 1545155182),
(123, 12027, '3a316d35ddf2f5922c2f247f20b59dabf5e3dd7020af0c5c9e38842b3f6c9ae4', 1545155194, 'cd7b202e90b86f5072f2785de3439cc1f33c30e473c53f8f1a622ab08b6a3c60', 1545155194),
(124, 12028, 'd6b2be8314ba4bea646fb376c2fcf789cce5fe8d4de585d1c7107d7a2c1b1ce7', 1545155212, '1a4d7681fc936018fdf67604a4be146b707ad44f59bef06474f6a1700f69aef3', 1545155212),
(125, 12029, 'a51ba8aa8721b5346ffa28fadb517dc72153dbcaf9547f6d584d80582d161df8', 1545155231, 'b1e645d7d4b4300d4b46ac5369b968f617b3836230a31ade5cecb90100b683be', 1545155231),
(126, 12030, '4a8b7d206035744314503bd2aaf2096748e977b922f235b64f243b79d51e6889', 1545155250, 'ebce642e37f21030800598d264f2703eb82a12d1f0a0e263bd99f4184521ff42', 1545155250),
(127, 12031, '45501bc2107d83625233dd932fc77f50bf068b1d01149e66e1996336475b46e5', 1545155269, '02b7a40dc8bed6f4401c3a8ba6f179c9e0f3c1ff4bc2c51776bbd9757deaba8f', 1545155269),
(128, 12032, '9879f6530c162ba87be16b7de6b758ad5a9f398dafdb2a9e6965ab11bc24c034', 1545155287, '46c694c4c6e208dc13dfddd03a7f4564c28fb5c41964f728e8aafb57380c93ef', 1545155287),
(129, 12033, 'f114c8c93ba2b14d1eca839a4ce94ab1c82ca734c69259d7b95f15a08268a7b1', 1545155312, '99fe830eace037811365287849b13891cbc6a7215c68cced314689260ce4770d', 1545155312),
(130, 12034, '21476fa7e13afe7c02d0d02cd412ccedeedf4feff858464e7dc51a19644b89fb', 1545155330, '728a8e8bf4ec6c5a03a6da00f87b8d4e1029227372f73635398bfb7e88fdc735', 1545155330),
(131, 12035, '0cf01294e6b89d8a3e191cc56b6a7350608c426992c10b186c46754c43e2cea9', 1545155350, 'd52fe199bbe25cebca23c4d9ebba55a0280402428a4aa296bfebbaac41ce48ee', 1545155350),
(132, 12036, '76b9e7caee45d1f818ca79d03c724d01be9c740335243a46d35fe7b8612b426e', 1545155368, '6ba2edb2988e10efab7157773006b138cdaeca1537079930b96517ff0a8c6981', 1545155368),
(133, 12037, '050b3660c189d61f392bbd5afb8a4b75e878df403660215fdb236855bcf6a1fb', 1545155434, 'f1b3e4397ab797c8280638aed2e127c521a89adf4f9880f95fcba1745e9b63d0', 1545155434),
(134, 12038, 'e2bb38d3546c3ba3ea33abcd7fbe7c5efa0754ff93933dd99f9b290f673038a0', 1545155443, 'd32be01939a7763145bff89558bdc95ca3b85689d71132821f41a9abe5e57d7e', 1545155443),
(135, 12053, 'ae275b71cbd8bc5c65c24b0572e879b2d9f66e87955840277162a66e3ea03b15', 1545155531, '96ddfcb882cbbf5542871d90a5e38daaa6aac6981eb51abbbc7a3d55c709384e', 1545155531),
(136, 12054, '5152d6418b1bbc70784c603571e63b0fca56ff42ab46fc23be21e3296c999307', 1545155554, 'd4610619946784e835251c4e2e619d7c8e6abab72b0d1bb213b2837c2ebf220c', 1545155554),
(137, 12086, '292f3c1579f9558768d7e5529ab7c81c2886f1b7035d92652ec0eee84c0806df', 1545207018, 'ec503414aff9a83b5c5641276142f4f790342a990f1ef290ca06dfe6a3041520', 1545207018),
(138, 12087, 'cd58af19147f82a3996f57d409d59150b7312dcd36b801882b48ba5cdf51b1ef', 1545207032, 'a3378c50ac7411380ef142542e38b4462d725729098365e9c3880443914e4792', 1545207032),
(139, 12088, '6d9f071d8f8878d73582d966371c8a534e9854324d2e4f16e42c340d6a7bd291', 1545207092, 'da6093ced03ed9cd83b8a588db784062fc6bd4ba9d5b3838a9389e0415364b69', 1545207092),
(140, 12089, '739eeff425c5af81188887022ba7c90f31584b3aaaa3b93de9a1e66dd5f22d40', 1545207117, '75283dfa44947257705685a17b5e5330f3e7a8acb2c731f435bde5e007fee909', 1545207117),
(141, 12091, 'da98b9c8cb72edce160afe96580998a296c57b634d7e1cf6b497aa26e0a56968', 1545207315, 'fadd45bf8a96a284be7e55f28d400cb132e948bd51d20d31ad02d80b9d890c37', 1545207315),
(142, 12092, '820db1b1f51fa0d6557bbf23b41d36c85b9c53cf2f38c3627efbc60264a03184', 1545207348, 'c607d13c61a5660db66eeed3e5b7ebecaae11fa20ae3b2591ea973457d703411', 1545207348),
(143, 12094, '04b000f5ee4cfb528726af9ce2f79641830db8a828711080d3b7a6f608730e1b', 1545207385, '75230dd980ee812f8bc588ab8dd66d8b94124200e412aacf074d0d11c7894a5b', 1545207385),
(144, 12096, '4e198e9ff49552c9b03edee8195a6680a133f5de5037df57cdf3f8e997378cc2', 1545207417, 'ab613f25f4bcf62859118e1d600c06a17dce890726b4984ff72f146304111829', 1545207417),
(145, 12097, '7844abac0fff1a3367dc6eeeaddbc23c77c769f4a909a485b44856d7ee62cc77', 1545207435, '3e906de6ed977ccc2445633f3f4e94352749eacff94827ac5f50d896c0023a87', 1545207435),
(146, 12102, '82f6880f37ceccac195bb94a2a399efeb1c3b812125d0537194126412500c571', 1545207460, '7e11f703269f31aec82f763d49346ff33007d4fad28a58d3bb8e29d2fbe0cd9e', 1545207460),
(147, 12103, '7fdd1a5212b4be029e18dcba36a5f95220244e984e3eb16000c618c307a0e4f2', 1545207485, 'd9a4dd8857b824b07684ca71fdf78ef9394aa39a11491a36091c102ff0e6ce67', 1545207485),
(148, 12104, '9677f4e7bfa959b06130be9dddc5433e068ec71a84d915efe2efc33b6ef18115', 1545207488, 'ac5137c3157d6bba3db674b706e4bdb540ed19825a5c51d91df9d283dbd8c50a', 1545207488),
(149, 12105, '53b362982166c775f2df878c4af7eb48b4f4ce623ac9e0fb08f43bc45e3e47b6', 1545207500, '3381e6584968f4a61511a31b878646dd3ba2690328462f075450db6b6d4d3216', 1545207500),
(150, 12106, '25a7df672da14aa325d898128508c0f3362cdce0ef6ff026599729bcc1b94ae4', 1545207518, 'c23ebcd0a83f9932cec59b9a999b42caee02d9cace07e3d41cec840049413684', 1545207518),
(151, 12107, 'aa0a6ce0483409331ad48f3f4b49868207a25a53836365f20dd78c8936183875', 1545207537, '4e88f2edf30596fec66699467b2a1cc5e2cf06fb0c48411d7a567f7f505678a0', 1545207537),
(152, 12108, 'd22bd1c0a19b27c898fca29a3a973c6408b974f94819411d868194a8683fdce5', 1545207556, '53b73d088431ad025f7ad3035d014f3f32c0a8e182f4ad35115aa7e277ef44b4', 1545207556),
(153, 12109, '499097fa04cd8f4116bdc167577de300842a4adf03572e4cfd0401ba9a98eaba', 1545207575, '64aed2f5e263028a2e5d1bb3734a0eb14b2fddf32ef467169083e4dd26c41483', 1545207575),
(154, 12110, 'e790a07ad4470c2a3a07771f4f55bae7f9844be7d4aa92a22a3c3786d97ccbdf', 1545207594, '128ba8be988a8cc369f5e9d189b153a0a40de2f97bfe690a97a33007e2547a27', 1545207594),
(155, 12111, '5bb1c518432680df634b546454fffce4a4b7d31e0f389f88fcf6feb1a2c49836', 1545207618, '63b382f761773080f8da2cdc8a2e07d656a39ef972138709432d3825cf7077a9', 1545207618),
(156, 12112, '07007e5beb98b5b139bed36d6fef9ad25bed5d321099ac25cb3dd6a7599ad37c', 1545207636, '8923a61a5ed91a5fe6ccc8c5be1ccbcd225df16edbdb6e085f3c518b188f6b98', 1545207636),
(157, 12113, '9d28d77ddbc5ebc71913b88da52b4c1bd54c255e33558b3575aff4965ad8a63d', 1545207656, 'ae614acda988459be4689775184bfc6cda8062ebead55f99d2f33d4ee512a358', 1545207656),
(158, 12114, 'f45f488630845a5af749b7efd53436490f4b436ee512dc1b21dd294baaab0282', 1545207674, '5b1d092d05c81f9a81a1f7ceb26dc8f392c5d5f78917d06b4380946a85cde5bb', 1545207674),
(159, 12115, '0a7e55b3667d512ecba1c32dd482957dccd3d14b3d64430af919517d4466f68b', 1545207740, '86995cb09f207aa4356428a100c41ada2c0b876d6c5bf49a9b7b34f3a1f2c9f6', 1545207740),
(160, 12116, '76aa7fd2c2f5d42e58e06c572523fadca4ef25233ef4d4b441448073df98390f', 1545207749, 'b5a259f2836561e6e9f6cb7cbd8bd84bc6b53e663f6846cbc576900277787749', 1545207749),
(161, 12131, 'dffe474b0f17320ec2a50f99f533ecdde925e86324ee140fb44749c5cb786f22', 1545207846, 'b6c23803ed31de4609e1710fb70365acd5f41fe40428db0571b5ff07db693bd0', 1545207846),
(162, 12132, '9b2422203e78f45a5600bf879e5c9a3499fc471b9746ae08f39a904b95f3f29b', 1545207869, '7a3a541fb09b130a1b0e12731cac7d3dda367bab3440519011e23bd7935f7466', 1545207869),
(163, 12162, '01748e9db815da6004c424b7349ef96f04bf9e5ef4d1162a9edc03d3385a10a3', 1545209492, '30620278d3e72f3521b3b4310cc83ec80cb0ba16eccba011aa8918312cfbe9dd', 1545209492),
(164, 12163, '81064ba0782b46c5744bda213ff90e8c05cf3efe9e13133747783350e2f19882', 1545209506, 'df60f25867b197931713546b886f239f46620914d017705ed26835a6e566b55f', 1545209506),
(165, 12164, 'c2191ea92c540a64caee2de20d91d7af118526d046b2c4145223f3fc95518f75', 1545209566, '581d5647139b1c935a57e364c20dd8946a171086b40f2e0b29a88e8160855885', 1545209566),
(166, 12165, '033a4e9469d6f8e0262f5c12dc7afb3a1c494b9eb4129b16e51f469454c6851d', 1545209590, '26067607ee7f29faed90d5a9f3a2f00798a48d68c05a484f1469710b20a19d3b', 1545209590),
(167, 12167, '8d8311d36b5392f9c6b373142c46eaff204fcedd5cc09a31dbea99b300a2ad7a', 1545209788, 'ebab60769b5786c0c12bb27ff0d2467a976e95154caeda178f7e986510d8c81f', 1545209788),
(168, 12168, 'ced610eafd5f6f79ffcd16aace5fa47bc010867e66a9c3b3d02fecc3242af97b', 1545209821, '83224160c94ea59360703db4a77c7077633039c2f2771b720606816bb46452d0', 1545209821),
(169, 12170, '3410d929313b594919333ef28834e181fb253f7eaddf38ed428346c87df9893b', 1545209858, 'c561ae0437e8debb9a2a2413c5c04671bd2aaef4485b9bc5c66971bc6c3c3e01', 1545209858),
(170, 12172, '32cc90451745090392753da86881dd2dc2284cee9fb1a3dc138719647bdd355d', 1545209890, '8200b67a0d174b635c235b0e687dfe786d8208743c2e832e5a47e28dd4d15888', 1545209890),
(171, 12173, 'fee24789ecfe596d598d3a53f4a1dd5fdccf3e8b362a124600c18bee956952ec', 1545209906, 'b706bbbdcedb53dfc790b9ecb6af4db4636045d591dd533426c309a4d4acb609', 1545209906),
(172, 12178, 'cc8246eb71598648bc2835007baae5ee4e3cb4a305449f4bdc1cd99c703ab83e', 1545209931, '36655c1c714070bab23c26930631243ac61261dac27dbeee21d9d137e7ba4fa0', 1545209931),
(173, 12179, '9c7f7aad1fc47eaee413026bda208b71a6fa8451c400f78a4c829688d9873fde', 1545209956, '087727ad3063099ddec0a96108d7ed33280e5f362e2f0d77e9fed3f8771ed6fc', 1545209956),
(174, 12180, 'fc44c51f33379e384f11d4e655087eb36daec7bf426baa05951e819820f9f642', 1545209959, 'eb5894b8464073a0da2e9cdbd0f4776c0204fa56e97ae07867520cd7ad53b2af', 1545209959),
(175, 12181, '820e418a62118ed06ee6e4bda722390f71bbdfddc26ef7c64e95591dcf1c9c6d', 1545209971, '249007ccbc87eca0861f6ace69a79193a3417b311620abbdadd16900094f3e61', 1545209971),
(176, 12182, 'cdc9b0c9628e245aeb210425406d6c55781b3852824c4a8dfb0f700f878b6687', 1545209989, '0eac8797e41bb0ee025584957a92fc9d9f9ef97244a6da4d7574a6c693fda2f1', 1545209989),
(177, 12183, 'fe706aee5d2e9d8bd04eb888af6e220fc98c7389a151b59acbd82e2a633e4b52', 1545210008, 'f4afa2bfbd8790f30c5b291a53d4245188483d78828170140f6312910617bd9b', 1545210008),
(178, 12184, '951d7a755ab2a388973952203c20ccb27a40fa58a1d39e742a7a6f57750e8a9e', 1545210027, '78c9813e33e55f0d53da8bbe6f597f44e1bcc6afe1c47afddb53fb4f5ba36ab3', 1545210027),
(179, 12185, '61614e9af9af32252f8f18f786d57b61c41e84036e0fc48bbc8082befe924aec', 1545210045, '4c02c43ae5994e37516b0a0fa95e1e71124fa529adab7e1cd6f160f33e4173b1', 1545210045),
(180, 12186, 'f7d31d12934070075e770314a5b9cddd20593e744be70ce5d7914c0308057613', 1545210064, '577375a8c13692b2bbdc12df1eab4a1b506d4443b983ac85c313c39ae13cc302', 1545210064),
(181, 12187, 'dcd286ee44e77fa7ad2903c09d63286b48f0bbca9990710d2c2c80fe02e0cb94', 1545210089, '01d60b133bb3b9cd80392614413260dacbb891f4c0ee7c807e30aa7b71364cf4', 1545210089),
(182, 12188, '22110745590beea1dd4970d308e7adb34762cacf77f9b7c129a582abb53a7ab5', 1545210107, 'aa118049c5fc2efa45a9fa0b6bd73227e516977cc5dcd7c78fd7a40378cc2294', 1545210107),
(183, 12189, 'd40e27403531d2652210ad17737dce4cb798acb77b8a2e75a94dc9803175299f', 1545210126, '8035a91be0d113b10045e114d046f4e785750f278cfe2200b24242b45943fcd4', 1545210126),
(184, 12190, 'd72b845fec4384b18a83ddb966e046a6f476c9aa0b25b87ac7073ff427417814', 1545210145, '676ae3a46efbc40ef400bb94460e20f1b2078e1a66d0d9f2bc3fda54e02c7770', 1545210145),
(185, 12191, 'a94fac6482cb8749779863b2c97ec9e255de715857d0db3a44fedf80ea1ea0cd', 1545210210, '5eef8b87887ba10979c8fd1563c20ee87a2f033c3c62875714e9524abdd9daa6', 1545210210),
(186, 12192, '189953abddd77520ff9d61adc8cf9401a89c51dc9dd48e4600f232e742fb931e', 1545210220, '35734c3f8072402cfd28e6ab3f3e5ff66b8750fc13e58aca8ab1cad1d344e0a1', 1545210220),
(187, 12207, '3c3e5901b5a451019458cf56094ca11a566bae867ae77823dbef14a9789b4aee', 1545210318, '3ab5f4c81988861de84582b48d93d9867090bea284284c586d98c44e2ae4ed95', 1545210318),
(188, 12208, '036933adeda666d4af66608f2eb7ecce828e0780d1befcdcf1e0439491719ad6', 1545210341, '36cc57a0e2c37ae1f52daede7db1267b69af854126940998949a4a469440ca6a', 1545210341);

-- --------------------------------------------------------

--
-- 表的结构 `user_widget`
--

CREATE TABLE `user_widget` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `widget_id` int(11) NOT NULL COMMENT 'main_widget主键id',
  `order_weight` int(11) UNSIGNED DEFAULT NULL COMMENT '工具顺序',
  `panel` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_saved_parameter` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否保存了过滤参数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_widget`
--

INSERT INTO `user_widget` (`id`, `user_id`, `widget_id`, `order_weight`, `panel`, `parameter`, `is_saved_parameter`) VALUES
(1, 0, 1, 1, 'first', '', 0),
(2, 0, 2, 2, 'first', '', 0),
(3, 0, 3, 3, 'first', '', 0),
(4, 0, 4, 1, 'second', '', 0),
(5, 0, 5, 2, 'second', '', 0),
(1036, 1, 1, 1, 'first', '', 0),
(1037, 1, 2, 2, 'first', '', 0),
(1038, 1, 3, 3, 'first', '', 0),
(1039, 1, 5, 2, 'second', '', 0),
(1040, 1, 4, 1, 'second', '', 0),
(1133, 10000, 7, 1, 'first', '[{\"name\":\"project_id\",\"value\":\"3\"},{\"name\":\"by_time\",\"value\":\"week\"},{\"name\":\"within_date\",\"value\":\"20\"}]', 0),
(1134, 10000, 1, 2, 'first', '', 0),
(1135, 10000, 8, 3, 'first', '[{\"name\":\"project_id\",\"value\":\"2\"},{\"name\":\"status\",\"value\":\"unfix\"}]', 0),
(1136, 10000, 9, 4, 'first', '[{\"name\":\"project_id\",\"value\":\"5\"}]', 0),
(1137, 10000, 13, 5, 'first', '[{\"name\":\"sprint_id\",\"value\":\"2\"}]', 0),
(1138, 10000, 4, 1, 'second', '', 0),
(1139, 10000, 2, 2, 'second', '', 0),
(1140, 10000, 5, 3, 'second', '', 0),
(1291, 11674, 1, 1, 'first', '', 0),
(1292, 11674, 6, 2, 'first', '[{\"name\":\"project_id\",\"value\":\"3\"}]', 1),
(1293, 11674, 2, 3, 'first', '', 0),
(1294, 11674, 3, 4, 'first', '', 0),
(1295, 11674, 5, 1, 'second', '', 0),
(1296, 11674, 4, 2, 'second', '', 0);

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
(1, '默认工作流', '', 1, 0, NULL, 1539675295, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(2, '软件开发工作流', '针对软件开发的过程状态流', 1, NULL, NULL, 1529647857, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(3, 'Task工作流', '', 1, NULL, NULL, 1539675552, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(7, 'test-name-19716', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(9, 'test-name-20339', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(13, 'test-name-940341', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(15, 'test-name-814308', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(19, 'test-name-791759', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(21, 'test-name-411439', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(25, 'test-name-39834', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(27, 'test-name-849262', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(31, 'test-name-114801', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(33, 'test-name-501180', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(37, 'test-name-533463', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(39, 'test-name-952229', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(43, 'test-name-95033', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(45, 'test-name-35554', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0);

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
-- 转储表的索引
--

--
-- 表的索引 `agile_board`
--
ALTER TABLE `agile_board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `weight` (`weight`);

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
  ADD KEY `cfvalue_issue` (`issue_id`,`custom_field_id`);

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
  ADD KEY `order_weight` (`order_weight`);

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
-- 表的索引 `issue_label`
--
ALTER TABLE `issue_label`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- 表的索引 `issue_label_data`
--
ALTER TABLE `issue_label_data`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `sprint_weight` (`sprint_weight`);
ALTER TABLE `issue_main` ADD FULLTEXT KEY `issue_num` (`issue_num`);
ALTER TABLE `issue_main` ADD FULLTEXT KEY `fulltext_summary` (`summary`);

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
  ADD KEY `scheme_id` (`scheme_id`) USING HASH;

--
-- 表的索引 `issue_ui`
--
ALTER TABLE `issue_ui`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_type_id`) USING BTREE;

--
-- 表的索引 `job_run_details`
--
ALTER TABLE `job_run_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rundetails_jobid_idx` (`job_id`),
  ADD KEY `rundetails_starttime_idx` (`start_time`);

--
-- 表的索引 `log_base`
--
ALTER TABLE `log_base`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING HASH,
  ADD KEY `obj_id` (`obj_id`) USING BTREE,
  ADD KEY `like_query` (`uid`,`action`,`remark`) USING BTREE;

--
-- 表的索引 `log_operating`
--
ALTER TABLE `log_operating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) USING HASH,
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
-- 表的索引 `main_mailserver`
--
ALTER TABLE `main_mailserver`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- 表的索引 `main_org`
--
ALTER TABLE `main_org`
  ADD PRIMARY KEY (`id`),
  ADD KEY `path` (`path`),
  ADD KEY `name` (`name`);

--
-- 表的索引 `main_setting`
--
ALTER TABLE `main_setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`),
  ADD KEY `module` (`module`) USING BTREE;

--
-- 表的索引 `main_timeline`
--
ALTER TABLE `main_timeline`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `main_widget`
--
ALTER TABLE `main_widget`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`) USING BTREE,
  ADD KEY `order_weight` (`order_weight`);

--
-- 表的索引 `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_key_idx` (`_key`);

--
-- 表的索引 `permission_default_role`
--
ALTER TABLE `permission_default_role`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `default_role_id` (`default_role_id`) USING HASH,
  ADD KEY `role_id-and-perm_id` (`default_role_id`,`perm_id`) USING HASH;

--
-- 表的索引 `permission_global`
--
ALTER TABLE `permission_global`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`);

--
-- 表的索引 `permission_global_group`
--
ALTER TABLE `permission_global_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perm_global_id` (`perm_global_id`),
  ADD KEY `group_id` (`group_id`);

--
-- 表的索引 `permission_global_relation`
--
ALTER TABLE `permission_global_relation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique` (`perm_global_id`,`group_id`) USING BTREE,
  ADD KEY `perm_global_id` (`perm_global_id`) USING HASH;

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
  ADD PRIMARY KEY (`id`);

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
ALTER TABLE `project_main` ADD FULLTEXT KEY `fulltext_name_description` (`name`,`description`);

--
-- 表的索引 `project_main_extra`
--
ALTER TABLE `project_main_extra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE;

--
-- 表的索引 `project_module`
--
ALTER TABLE `project_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`) USING BTREE;

--
-- 表的索引 `project_role`
--
ALTER TABLE `project_role`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `project_role_relation`
--
ALTER TABLE `project_role_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`) USING HASH,
  ADD KEY `role_id-and-perm_id` (`role_id`,`perm_id`) USING HASH,
  ADD KEY `unique_data` (`project_id`,`role_id`,`perm_id`);

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
  ADD KEY `uid` (`uid`) USING HASH,
  ADD KEY `group_id` (`group_id`);

--
-- 表的索引 `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

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
  ADD KEY `email` (`email`),
  ADD KEY `username` (`username`) USING HASH;

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
  ADD KEY `uid` (`user_id`) USING HASH;

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
  ADD KEY `workflow_id` (`workflow_id`) USING HASH;

--
-- 表的索引 `workflow_connector`
--
ALTER TABLE `workflow_connector`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workflow_id` (`workflow_id`) USING HASH;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用表AUTO_INCREMENT `agile_board_column`
--
ALTER TABLE `agile_board_column`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用表AUTO_INCREMENT `agile_sprint`
--
ALTER TABLE `agile_sprint`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- 使用表AUTO_INCREMENT `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_main`
--
ALTER TABLE `field_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `hornet_user`
--
ALTER TABLE `hornet_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- 使用表AUTO_INCREMENT `issue_assistant`
--
ALTER TABLE `issue_assistant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用表AUTO_INCREMENT `issue_description_template`
--
ALTER TABLE `issue_description_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- 使用表AUTO_INCREMENT `issue_follow`
--
ALTER TABLE `issue_follow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `issue_label`
--
ALTER TABLE `issue_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `issue_label_data`
--
ALTER TABLE `issue_label_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- 使用表AUTO_INCREMENT `issue_main`
--
ALTER TABLE `issue_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=706;

--
-- 使用表AUTO_INCREMENT `issue_priority`
--
ALTER TABLE `issue_priority`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用表AUTO_INCREMENT `issue_recycle`
--
ALTER TABLE `issue_recycle`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `issue_resolve`
--
ALTER TABLE `issue_resolve`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10123;

--
-- 使用表AUTO_INCREMENT `issue_status`
--
ALTER TABLE `issue_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10122;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=675;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1103;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- 使用表AUTO_INCREMENT `log_base`
--
ALTER TABLE `log_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- 使用表AUTO_INCREMENT `log_operating`
--
ALTER TABLE `log_operating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- 使用表AUTO_INCREMENT `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_activity`
--
ALTER TABLE `main_activity`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=829;

--
-- 使用表AUTO_INCREMENT `main_group`
--
ALTER TABLE `main_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用表AUTO_INCREMENT `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- 使用表AUTO_INCREMENT `main_org`
--
ALTER TABLE `main_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- 使用表AUTO_INCREMENT `main_setting`
--
ALTER TABLE `main_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- 使用表AUTO_INCREMENT `main_widget`
--
ALTER TABLE `main_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10906;

--
-- 使用表AUTO_INCREMENT `permission_default_role`
--
ALTER TABLE `permission_default_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10014;

--
-- 使用表AUTO_INCREMENT `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- 使用表AUTO_INCREMENT `permission_global_group`
--
ALTER TABLE `permission_global_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- 使用表AUTO_INCREMENT `project_flag`
--
ALTER TABLE `project_flag`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=344;

--
-- 使用表AUTO_INCREMENT `project_issue_report`
--
ALTER TABLE `project_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- 使用表AUTO_INCREMENT `project_label`
--
ALTER TABLE `project_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- 使用表AUTO_INCREMENT `project_list_count`
--
ALTER TABLE `project_list_count`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_main`
--
ALTER TABLE `project_main`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- 使用表AUTO_INCREMENT `project_main_extra`
--
ALTER TABLE `project_main_extra`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=968;

--
-- 使用表AUTO_INCREMENT `project_user_role`
--
ALTER TABLE `project_user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1077;

--
-- 使用表AUTO_INCREMENT `project_version`
--
ALTER TABLE `project_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- 使用表AUTO_INCREMENT `report_project_issue`
--
ALTER TABLE `report_project_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- 使用表AUTO_INCREMENT `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- 使用表AUTO_INCREMENT `user_email_active`
--
ALTER TABLE `user_email_active`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 使用表AUTO_INCREMENT `user_email_token`
--
ALTER TABLE `user_email_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10857;

--
-- 使用表AUTO_INCREMENT `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12209;

--
-- 使用表AUTO_INCREMENT `user_message`
--
ALTER TABLE `user_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_phone_find_password`
--
ALTER TABLE `user_phone_find_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_setting`
--
ALTER TABLE `user_setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- 使用表AUTO_INCREMENT `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- 使用表AUTO_INCREMENT `user_widget`
--
ALTER TABLE `user_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=1297;

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- 使用表AUTO_INCREMENT `workflow_block`
--
ALTER TABLE `workflow_block`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `workflow_connector`
--
ALTER TABLE `workflow_connector`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `workflow_scheme`
--
ALTER TABLE `workflow_scheme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10131;

--
-- 使用表AUTO_INCREMENT `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10396;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
