

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Database: `dev`
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
(24, 57, 6, 0);

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
(274, 'B7yiYJ-1543940801725', 0, 'B7yiYJ-1543940801725', 'image/png', 'word.png', 'all/20181205/20181205002959_13149.png', 1543940999, 629280, 10000, 'png');

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
(28, 18274, 4),
(29, 57, 0);

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
(15, 10000, 117, NULL, NULL, 3, 0, 0, 0, 0, 0, '可以通过二维码上传手机附件', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"DEV\",\"issue_num\":\"DEV117\",\"project_id\":\"3\",\"issue_type\":\"2\",\"creator\":\"10000\",\"modifier\":\"10000\",\"reporter\":\"10000\",\"assignee\":\"10000\",\"summary\":\"\\u53ef\\u4ee5\\u901a\\u8fc7\\u4e8c\\u7ef4\\u7801\\u4e0a\\u4f20\\u624b\\u673a\\u9644\\u4ef6\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"0\",\"status\":\"3\",\"created\":\"1543314118\",\"updated\":\"1543314118\",\"start_date\":\"2018-11-28\",\"due_date\":\"2018-12-05\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"30\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1700000\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"10000\"}', 1543598517);

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
-- 表的结构 `issue_resolve2`
--

CREATE TABLE `issue_resolve2` (
  `id` int(11) UNSIGNED NOT NULL,
  `sequence` int(11) UNSIGNED DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(128) NOT NULL,
  `description` text,
  `font_awesome` varchar(32) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, '1', 'Bug', 'bug', 'Standard', '测试过程、维护过程发现影响系统运行的缺陷', 'fa-bug', NULL, 1, 0),
(2, '2', '新功能', 'new_feature', 'Standard', '对系统提出的新功能', 'fa-plus', NULL, 1, 0),
(3, '3', '任务', 'task', 'Standard', '需要完成的任务', 'fa-tasks', NULL, 1, 0),
(4, '4', '优化改进', 'improve', 'Standard', '对现有系统功能的改进', 'fa-arrow-circle-o-up', NULL, 1, 0),
(5, '0', '子任务', 'child_task', 'Standard', '', 'fa-subscript', NULL, 1, 0),
(6, '2', '用户故事', 'user_story', 'Scrum', '从用户的角度来描述用户渴望得到的功能。一个好的用户故事包括三个要素：1. 角色；2. 活动　3. 商业价值', 'fa-users', NULL, 1, 0),
(7, '3', '技术任务', 'tech_task', 'Scrum', '技术性的任务,如架构设计,数据库选型', 'fa-cogs', NULL, 1, 0),
(8, '5', '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', NULL, 1, 0);

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
(3, 3, 1),
(17, 4, 10000),
(19, 5, 5),
(20, 5, 10002),
(21, 5, 10106),
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
(1, 'wwwwwwwwwwwwww', 1, 3, 1539682929);

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
('dict/description_template/getAll/0,*', 'dict/description_template', '2018-12-14 15:17:58', 1544771878),
('dict/label/getAll/0,*', 'dict/label', '2018-12-14 15:20:37', 1544772037),
('dict/label/getAll/1,*', 'dict/label', '2018-12-11 15:58:23', 1544515103),
('dict/list_count/getAll/1,*', 'dict/list_count', '2018-12-11 15:58:14', 1544515094),
('dict/main/getAll/0,*', 'dict/main', '2018-12-14 15:20:36', 1544772036),
('dict/priority/getAll/1,*', 'dict/priority', '2018-12-11 15:58:23', 1544515103),
('dict/resolve/getAll/1,*', 'dict/resolve', '2018-12-11 15:58:22', 1544515102),
('dict/sprint/getItemById/2', 'dict/sprint', '2018-12-11 00:14:09', 1544458449),
('dict/sprint/getItemById/3', 'dict/sprint', '2018-12-11 00:14:08', 1544458448),
('dict/sprint/getItemById/4', 'dict/sprint', '2018-12-11 15:58:27', 1544515107),
('dict/status/getAll/1,*', 'dict/status', '2018-12-11 15:58:22', 1544515102),
('dict/type/getAll/0,*', 'dict/type', '2018-12-14 15:20:37', 1544772037),
('dict/type/getAll/1,*', 'dict/type', '2018-12-14 15:20:37', 1544772037),
('dict/type_scheme/getAll/1,*', 'dict/type_scheme', '2018-12-11 00:14:35', 1544458475),
('setting/getSettingByKey/datetime_format', 'setting', '2018-12-14 12:16:20', 1544760980),
('setting/getSettingByKey/date_timezone', 'setting', '2018-12-14 12:16:14', 1544760974),
('setting/getSettingByKey/full_datetime_format', 'setting', '2018-12-11 10:16:22', 1544494582),
('setting/getSettingByKey/login_require_captcha', 'setting', '2018-12-14 12:16:14', 1544760974),
('setting/getSettingByKey/max_project_key', 'setting', '2018-12-15 16:21:23', 1544862083),
('setting/getSettingByKey/max_project_name', 'setting', '2018-12-15 16:21:23', 1544862083),
('setting/getSettingByKey/reg_require_captcha', 'setting', '2018-12-14 12:16:14', 1544760974),
('setting/getSettingByKey/title', 'setting', '2018-12-14 12:16:14', 1544760974),
('setting/getSettingRow/muchErrorTimesCaptcha', 'setting', '2018-12-14 12:16:19', 1544760979),
('setting/getSettingRow/project_view', 'setting', '2018-12-14 16:58:34', 1544777914),
('setting/getSettingRow/reg_require_pic_code', 'setting', '2018-12-11 10:27:46', 1544495266);

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
(58, 'project_view', '项目首页', 'user_default', 'issues', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', '');

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
(40, 11656, 'issue', 0, 0, 119, 'commented', '', '- 1. 框架已集成提交字段过滤的功能来抵御XSS\n![](http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png)\n\n- 2. 还需要增加CSRF的安全防护功能', '<ul>\n<li><ol>\n<li>框架已集成提交字段过滤的功能来抵御XSS<br><img src=\"http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png\" alt=\"\"></li></ol>\n</li><li><ol>\n<li>还需要增加CSRF的安全防护功能</li></ol>\n</li></ul>\n', 1543649108);

-- --------------------------------------------------------

--
-- 表的结构 `main_widget`
--

CREATE TABLE `main_widget` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '工具名称',
  `type` int(2) DEFAULT NULL COMMENT '工具类型',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态（1可用，0不可用）',
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '执行方法',
  `html` text COLLATE utf8mb4_unicode_ci COMMENT 'html',
  `created` int(11) DEFAULT NULL COMMENT '创建人',
  `updated` int(11) DEFAULT NULL COMMENT '修改人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(17, 2, 5);

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
(1, 10, 4, '敏捷开发项目总数'),
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
  `detail` text COLLATE utf8mb4_unicode_ci,
  `un_done_count` int(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '未完成事项数',
  `done_count` int(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '已经完成事项数',
  `closed_count` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(25, 5, 'PO', '产品经理，产品负责人', 1);

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
(7, 'SSS', '1216420381@qq.com', 11659, 'PV5HZSDTAB5UKY8B9DYIAXG7B7VLZWZG', 1543890492);

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
(1, 10000, '8c0b26549889e2059cc834c863f5877d88bed468effe958d991524c49bb66bdb', 1544251554, '055d06c0e733b02824d0ae13406c7ef70be0cf479c445a35e4530d1a2b91a979', 1544251554),
(2, 11672, '8cfe95bbbcd7157b755eadb34d0ad288d777b4bcb285774688527aca2d99f4be', 1543921269, '9a89ba630496c75afe47b04e6de72982a63afbd658b222e5effb3de1d775636f', 1543921269),
(3, 11674, '564f6bb0b86cfb276c934c805cc31923cb88013330ef6ea8fd32d496745d1b50', 1543921442, '78d30729d3512be999b79f123af5e2b1e45467f941dcfdb06db7c1b670043155', 1543921442),
(4, 1, '25f08a6c6da7e4a1d08b01c2d7e2f61a64919805e0362f6409e2e0bd7464c53c', 1544170273, '4d7013de3838061bc198a4d2d7ede32d5b3eb0f3d2246b922f5b1a7759aa70a4', 1544170273);

-- --------------------------------------------------------

--
-- 表的结构 `user_widget`
--

CREATE TABLE `user_widget` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `mid` int(11) NOT NULL COMMENT 'main_widget主键id',
  `order` int(11) DEFAULT NULL COMMENT '工具顺序',
  `del_flag` tinyint(2) DEFAULT NULL COMMENT '删除标识（1已删，0未删）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, 'Task工作流', '', 1, NULL, NULL, 1539675552, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);

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
-- Indexes for table `hornet_cache_key`
--
ALTER TABLE `hornet_cache_key`
  ADD PRIMARY KEY (`key`),
  ADD UNIQUE KEY `module_key` (`key`,`module`) USING BTREE,
  ADD KEY `module` (`module`),
  ADD KEY `expire` (`expire`);

--
-- Indexes for table `hornet_user`
--
ALTER TABLE `hornet_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_unique` (`phone`) USING BTREE,
  ADD KEY `phone` (`phone`,`password`),
  ADD KEY `email` (`email`);

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
  ADD KEY `uuid` (`uuid`),
  ADD KEY `tmp_issue_id` (`tmp_issue_id`);

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
  ADD KEY `summary` (`summary`(191)),
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
-- Indexes for table `issue_resolve2`
--
ALTER TABLE `issue_resolve2`
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
-- Indexes for table `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_line_unique` (`md5`),
  ADD KEY `date` (`date`);

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
-- Indexes for table `main_widget`
--
ALTER TABLE `main_widget`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `project_flag`
--
ALTER TABLE `project_flag`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `projectIdAndDate` (`project_id`,`date`) USING BTREE,
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sprintIdAndDate` (`sprint_id`,`date`) USING BTREE,
  ADD KEY `sprint_id` (`sprint_id`);

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
-- Indexes for table `user_widget`
--
ALTER TABLE `user_widget`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `hornet_user`
--
ALTER TABLE `hornet_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_assistant`
--
ALTER TABLE `issue_assistant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `issue_description_template`
--
ALTER TABLE `issue_description_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `issue_resolve`
--
ALTER TABLE `issue_resolve`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10102;

--
-- 使用表AUTO_INCREMENT `issue_resolve2`
--
ALTER TABLE `issue_resolve2`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_status`
--
ALTER TABLE `issue_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10101;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- 使用表AUTO_INCREMENT `log_base`
--
ALTER TABLE `log_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 使用表AUTO_INCREMENT `log_operating`
--
ALTER TABLE `log_operating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_activity`
--
ALTER TABLE `main_activity`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- 使用表AUTO_INCREMENT `main_widget`
--
ALTER TABLE `main_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id';

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
-- 使用表AUTO_INCREMENT `project_flag`
--
ALTER TABLE `project_flag`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_issue_report`
--
ALTER TABLE `project_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_user_role`
--
ALTER TABLE `project_user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_version`
--
ALTER TABLE `project_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `report_project_issue`
--
ALTER TABLE `report_project_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_email_active`
--
ALTER TABLE `user_email_active`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `user_email_token`
--
ALTER TABLE `user_email_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10529;

--
-- 使用表AUTO_INCREMENT `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `user_widget`
--
ALTER TABLE `user_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id';

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10103;

--
-- 使用表AUTO_INCREMENT `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10326;
COMMIT;
