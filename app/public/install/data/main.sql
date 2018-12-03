

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



--
-- 数据库： `masterlab`
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
(4, 3, '第四次迭代', '对外发布前的迭代', 1, 1, 0, '2018-11-28', '2018-12-05');

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
(273, '1543648972905', 0, '', 'image/png', 'filter_xss.png', 'image/20181201/20181201152353_87673.png', 1543649033, 9601, 11656, 'png');

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

--
-- 转存表中的数据 `issue_main`
--

INSERT INTO `issue_main` (`id`, `pkey`, `issue_num`, `project_id`, `issue_type`, `creator`, `modifier`, `reporter`, `assignee`, `summary`, `description`, `environment`, `priority`, `resolve`, `status`, `created`, `updated`, `start_date`, `due_date`, `resolve_date`, `module`, `milestone`, `sprint`, `weight`, `backlog_weight`, `sprint_weight`, `assistants`, `master_id`, `have_children`) VALUES
(1, 'CRM', 'CRM1', 1, 1, 10000, 10000, 10000, 11652, '数据库设计', '1.第一步数据建模\r\n2.第二步ER图设计', 'windows', 1, 0, 6, 1536768829, 0, '2018-09-13', '2018-09-30', NULL, 3, NULL, 1, 0, 200000, 100000, '', 0, 0),
(2, 'CRM', 'CRM2', 1, 1, 10000, 10000, 10000, 11652, '数据库表设计', '1.\r\n2.\r\n3.', 'windows mysql', 1, 0, 6, 1536769063, 0, '2018-09-13', '2018-09-15', NULL, 1, NULL, 1, 0, 0, 200000, '', 0, 0),
(3, 'CRM', 'CRM3', 1, 1, 10000, 10000, 10000, 10000, '架构设计', '1.\r\n2.\r\n3.\r\n4.\r\n5.', '', 3, 10000, 1, 1536769153, 0, '2018-09-13', '2018-09-15', NULL, 2, NULL, 0, 0, 100000, 100000, '10000', 0, 0),
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
(23, 'DEV', 'DEV23', 3, 4, 10000, 10000, 10000, 10000, '无数据的插图需要重写设计', '要根据产品的logo和产品特点进行设计，包括：\r\n1.数据为空时：项目列表,迭代,事项，模块，版本，标签\r\n2.询问的弹出层，如删除操作\r\n', '', 3, 0, 5, 1539144107, 0, '2018-10-10', '2018-10-13', NULL, 0, '0', 3, 0, 0, 1500000, '', 0, 0),
(24, 'DEV', 'DEV24', 3, 2, 10000, 10000, 10000, 10000, '增加weight 权重点数字段', '', '', 3, 0, 6, 1539221701, 0, '2018-10-11', '2018-10-13', NULL, 11, NULL, 2, 0, 0, 3700000, '', 0, 0),
(25, 'DEV', 'DEV25', 3, 2, 10000, 10000, 10000, 10000, '看板事项移动时要更新到服务器端', '', '', 3, 0, 6, 1539221773, 0, '2018-10-11', '2018-10-13', NULL, 6, NULL, 2, 0, 0, 2800000, '', 0, 0),
(26, 'DEV', 'DEV26', 3, 1, 10000, 10000, 10000, 10000, '待办事项列表要显示权重点数', '', '', 2, 0, 6, 1539222559, 0, '2018-10-11', '2018-10-13', NULL, 6, NULL, 2, 0, 0, 3800000, '', 0, 0),
(27, 'DEV', 'DEV27', 3, 1, 10000, 11656, 10000, 11656, '系统中的各种设置项的应用(时间 公告 UI)', '', '', 2, 0, 5, 1539222644, 0, '2018-10-11', '2018-10-13', NULL, -1, NULL, 2, 0, 0, 2900000, '1,1,6,5,5', 0, 0),
(28, 'DEV', 'DEV28', 3, 1, 10000, 11657, 10000, 11657, '各个功能模块添加操作日志', '', '', 2, 0, 5, 1539223637, 0, '2018-10-11', '2018-10-13', NULL, 0, NULL, 3, 0, 0, 1400000, '', 0, 0),
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
(56, 'DEV', 'DEV56', 3, 1, 10000, 11654, 10000, 11654, '首页当动态数据为空时 使用通用的空图显示', '', '', 4, 0, 5, 1540641158, 0, '2018-10-29', '2018-10-29', NULL, 0, NULL, 3, 0, 100000, 2000000, '', 0, 0),
(57, 'DEV', 'DEV57', 3, 4, 10000, 10000, 10000, 10000, '增加一个未解决的过滤器', '', '', 3, 0, 5, 1540663864, 0, '2018-10-28', '2018-10-28', NULL, 11, NULL, 2, 0, 0, 400000, '1,,,1,,,6,,,5,,,4', 0, 0),
(58, 'DEV', 'DEV58', 3, 1, 10000, 10000, 10000, 10000, '去掉自动登录的账号', '', '', 3, 0, 5, 1540754430, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 200000, 3900000, '', 0, 0),
(59, 'DEV', 'DEV59', 3, 1, 10000, 11654, 10000, 11654, '迭代应该可以选择空', '选择为空时属于代办事项', '', 3, 0, 5, 1540754458, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 400000, 1500000, '', 0, 0),
(60, 'DEV', 'DEV60', 3, 1, 10000, 10000, 10000, 10000, '登录页面的文字需要修饰修改', '', '', 3, 0, 5, 1540754499, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 4000000, '', 0, 0),
(62, 'DEV', 'DEV62', 3, 1, 10000, 10000, 10000, 10000, '增加缓存处理', '', '', 3, 0, 5, 1540754638, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 400000, 3800000, '', 0, 0),
(63, 'DEV', 'DEV63', 3, 4, 10000, 11657, 10000, 11657, '用户动态功能需要优化', '1.首页的用户动态，需要分页\r\n2.对已经有的动态项，进行内容补充，目前内容比较简陋，至于达到什么标准，可参考 jira动态功能\r\n3.某些模块未添加动态，需要进行查漏补缺', '', 3, 1, 5, 1540754710, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 600000, 4100000, '', 0, 0),
(64, 'DEV', 'DEV64', 3, 4, 10000, 10000, 10000, 11656, 'PHP的设计模式优化', '', '', 2, 0, 10100, 1540754764, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 600000, 2300000, '', 0, 0),
(65, 'DEV', 'DEV65', 3, 1, 10000, 11655, 10000, 11655, '更换个人设置页的图片', '详见附件', '', 4, 0, 5, 1540802453, 0, '0000-00-00', '0000-00-00', NULL, 4, NULL, 0, 0, 500000, 2100000, '', 0, 0),
(66, 'DEV', 'DEV66', 3, 1, 10000, 11656, 10000, 11656, '事项详情页面的左上角 项目显示错误', '请看截图的左上角', '', 2, 0, 5, 1540833978, 0, '2018-10-30', '2018-10-30', NULL, 0, NULL, 2, 0, 0, 300000, '', 0, 0),
(67, 'DEV', 'DEV67', 3, 2, 10000, 11654, 10000, 11654, '在迭代和看板页面可以创建事项', '', '', 3, 0, 5, 1540957298, 0, '2018-11-01', '2018-11-05', NULL, 0, NULL, 3, 20, 0, 3400000, '', 0, 0),
(68, 'DEV', 'DEV68', 3, 4, 10000, 11654, 10000, 11654, '在创建事项的表单中,当变更事项类型时，原先填写的数据要保留', '###当前步骤或情况：\r\n  1. 进入事项列表页面\r\n  2. 打开创建事项表单，此时默认事项类型为bug,并输入标题:xxxxx\r\n  3. 变更事项类型为 新功能 \r\n  4. 之前输入的标题变成了空\r\n  \r\n### 优化后的步骤或结果：\r\n  1. 进入事项列表页面\r\n  2. 打开创建事项表单，此时默认事项类型为bug,并输入标题:xxxxx\r\n  3. 变更事项类型为 新功能 \r\n  4. 之前输入的标题内容仍然保留\r\n\r\n', '', 3, 0, 5, 1540958040, 0, '2018-10-31', '2018-11-05', NULL, 11, NULL, 3, 0, 0, 3600000, '', 0, 0),
(69, 'DEV', 'DEV69', 3, 1, 10000, 11654, 10000, 11654, '创建或编辑事项表单的版本和模块下拉时点击错误', '详看截图	', '', 2, 0, 5, 1540958318, 0, '2018-10-31', '2018-10-29', NULL, 11, NULL, 3, 0, 0, 3700000, '', 0, 0),
(70, 'DEV', 'DEV70', 3, 3, 10000, 11657, 10000, 11657, '在wiki上编写使用指南', '参考 \r\nhttps://panjiachen.github.io/vue-element-admin-site/zh/guide/#%E5%8A%9F%E8%83%BD\r\nhttps://doc.fastadmin.net/docs/install.html#%E5%91%BD%E4%BB%A4%E8%A1%8C%E5%AE%89%E8%A3%85-3\r\nhttps://ant.design/index-cn\r\n\r\n内容和结构\r\n\r\n- Masterlab 如何进行高效的项目管理和团队协作\r\n- 项目角色定义\r\n- 工作流和方案\r\n- 事项类型及方案\r\n- 最佳实践，创建组织或产品,创建项目,项目设置，添加事项，创建迭代，跟踪和管理迭代，数据和图表分析，交付产品\r\n- 快捷键\r\n- 其他配置\r\n- 定制或二次开发\r\n- 常见问题\r\n\r\n', '', 3, 1, 5, 1540969482, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3500000, '', 0, 0),
(71, 'DEV', 'DEV71', 3, 3, 10000, 11656, 10000, 11656, '在wiki上编写‘Linux下的Nginx，Mysql5.7，Php7.2，Redis的运行环境的’文档', '三篇，分别基于centos6,centos7,Ubuntu;\r\ncentos的yum参考 webtatic.com\r\n包括redis扩展\r\n\r\n', '', 4, 0, 5, 1540970938, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3100000, '', 0, 0),
(72, 'DEV', 'DEV72', 3, 3, 10000, 11656, 10000, 11656, '创建Masterlab docker及安装文档', '\r\n包含dockerfile和compose，以及上传至 公共的hub上', '', 4, 0, 5, 1540971351, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3200000, '', 0, 0),
(73, 'DEV', 'DEV73', 3, 3, 10000, 10000, 10000, 10000, '更新官方网站的内容', '1.创建一个新的 github 项目\r\n2.修改其中的内容\r\n', '', 4, 0, 5, 1540971562, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3300000, '', 0, 0),
(74, 'DEV', 'DEV74', 3, 2, 10000, 10000, 10000, 10000, '事项列表搜索-增加迭代项', '', '', 3, 0, 5, 1540972012, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2900000, '', 0, 0),
(75, 'DEV', 'DEV75', 3, 4, 10000, 11656, 10000, 11656, '项目类型进行精简', ' 敏捷开发 --> 不变\r\n 看板开发 --> 删除 \r\n 软件开发 --> 不变\r\n 项目管理 --> 删除 \r\n 流程管理 --> 删除 \r\n 任务管理 --> 不变', '', 3, 1, 5, 1540972695, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 3000000, '', 0, 0),
(76, 'DEV', 'DEV76', 3, 2, 10000, 10000, 10000, 10000, '迭代和待办事项页面要显示事项的状态，解决结果，经办人', '静态结构已经增加，返回数据中暂缺少对应项。', '', 3, 0, 5, 1540973678, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2600000, '', 0, 0),
(77, 'DEV', 'DEV77', 3, 2, 10000, 11655, 10000, 11655, '看板页面需要增加可编辑和新增事项的功能', '', '', 3, 0, 5, 1540973714, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2700000, '', 0, 0),
(78, 'DEV', 'DEV78', 3, 2, 10000, 10000, 10000, 10000, '项目统计页面需要增加专门针对当前迭代的统计', '', '', 3, 0, 5, 1540973749, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2800000, '', 0, 0),
(79, 'DEV', 'DEV79', 3, 1, 10000, 11655, 10000, 11655, '迭代页面，需要高亮显示当前迭代', '', '', 4, 0, 5, 1540973900, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2500000, '', 0, 0),
(80, 'DEV', 'DEV80', 3, 1, 10000, 10000, 10000, 10000, '项目图表的‘ 解决与未解决事项对比报告’为空', '', '', 3, 0, 5, 1540973995, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2300000, '', 0, 0),
(81, 'DEV', 'DEV81', 3, 4, 10000, 10000, 10000, 10000, '官方网站的图片需要重写设计', '', '', 3, 0, 5, 1540974064, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2400000, '', 0, 0),
(82, 'DEV', 'DEV82', 3, 1, 10000, 11654, 10000, 11654, '迭代列表的事项可以点击，然后右侧浮动出事项详情', '', '', 3, 0, 5, 1540974142, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2100000, '', 0, 0),
(83, 'DEV', 'DEV83', 3, 2, 10000, 10000, 10000, 10000, '实现事项查询的自定义过滤器', '', '', 3, 0, 5, 1540974180, 0, '2018-10-31', '2018-11-05', NULL, 0, NULL, 3, 0, 0, 2200000, '', 0, 0),
(84, 'DEV', 'DEV84', 3, 4, 10000, 10000, 10000, 10000, '事项列表和待办事项及迭代页面增加总数', '', '', 3, 0, 5, 1540976592, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1900000, '', 0, 0),
(85, 'DEV', 'DEV85', 3, 2, 10000, 10000, 10000, 10000, '启用Mysql5.7以上版本的全文索引', '支持以下查询\r\n```sql\r\n... WHERE MATCH (`summary`,`description`) AGAINST (\'异常 设计\' IN NATURAL LANGUAGE MODE)\r\n```', '', 3, 0, 5, 1541000974, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1700000, '', 0, 0),
(86, 'DEV', 'DEV86', 3, 4, 10000, 10000, 10000, 10000, '优化事项类型的表单配置', '', '', 4, 0, 5, 1541001338, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1600000, '', 0, 0),
(87, 'DEV', 'DEV87', 3, 1, 10000, 10000, 10000, 10000, '点击事项列表的用户头像后跳转的个人资料页错误', '', '', 2, 0, 5, 1541004095, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1800000, '', 0, 0),
(88, 'DEV', 'DEV88', 3, 1, 10000, 10000, 10000, 10000, '看板查询功能失效', '', '', 2, 0, 5, 1541350759, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1300000, '', 0, 0),
(89, 'DEV', 'DEV89', 3, 1, 11658, 10000, 11658, 10000, '注册新用户无法登录', '步骤：\r\n1、注册页面注册新用户成功\r\n2、登录提示用户已被禁用\r\n3、使用系统管理员账号登录系统-用户管理，用户列表中该用户的状态为空（正常情况为正常），点击编辑，弹出框中，禁用为未选中状态，此时点击禁用，该用户状态为禁用，需要再次编辑该用户，取消禁用，该用户状态为正常，可以登录\r\n问题：\r\n需要设置两次状态以后用户才能登录，正常情况下应该只需要设置一次即可', '', 3, 0, 5, 1541490486, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1200000, '', 0, 0),
(90, 'DEV', 'DEV90', 3, 4, 10000, 11655, 10000, 11655, '当鼠标移动到事项列表上面时，高亮显示表格的行', '', '', 4, 0, 5, 1541492362, 0, '0000-00-00', '0000-00-00', NULL, 11, NULL, 3, 0, 0, 900000, '', 0, 0),
(92, 'DEV', 'DEV92', 3, 4, 10000, 11654, 10000, 11654, '事项表单的 迭代 字段默认值要修改', '如果当前项目有活跃的迭代，则默认选中该迭代\r\n如果项目没有迭代，则选中待办事项\r\n后端会在页面中放置一个全局的js变量 _active_sprint_id', '', 4, 0, 5, 1541574516, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1100000, '', 0, 0),
(93, 'DEV', 'DEV93', 3, 4, 10000, 11655, 10000, 11655, '美观官方网站的关于我们', '详看附件\r\n要左对齐\r\n左边放置 头像，右边是介绍', '', 4, 0, 5, 1541575069, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 1000000, '', 0, 0),
(94, 'DEV', 'DEV94', 3, 1, 10000, 10000, 10000, 10000, '登录页面增加快捷键', '', '', 4, 0, 5, 1541728375, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 800000, '', 0, 0),
(95, 'DEV', 'DEV95', 3, 1, 11656, 11656, 11656, 11656, '编辑事项的修改时间显示错误', '编辑事项的修改时间显示错误\r\n原因是：在更新事项表单的时候没有把更新时间写入事项表的更新字段', '', 1, 0, 5, 1541747728, 0, '2018-11-09', '2018-11-10', NULL, 11, NULL, 0, 0, 300000, 0, '', 0, 0),
(96, 'DEV', 'DEV96', 3, 1, 11656, 11656, 11656, 11654, '事项详情页面点击事项编辑按钮后附件框会多出来一部分', '重现：\r\n1、在事项详情页面点击事项编辑按钮\r\n2、关闭编辑页面', '', 4, 0, 1, 1541748239, 0, '2018-11-12', '2018-11-16', NULL, 11, NULL, 0, 0, 200000, 0, '', 0, 0),
(97, 'DEV', 'DEV97', 3, 1, 10000, 10000, 10000, 10000, '创建一个smtp帐号并测试邮件发送功能', '', '', 3, 10000, 6, 1541850637, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 2500000, '', 0, 0),
(98, 'DEV', 'DEV98', 3, 1, 10000, 10000, 10000, 10000, '标签数据错误', '', '', 3, 10000, 6, 1541850743, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 2600000, '', 0, 0),
(99, 'DEV', 'DEV99', 3, 1, 10000, 11656, 10000, 11656, 'DbModel不应该添加特定的updated字段', '应该在 事项 的控制器或classes中添加\r\n.', '', 2, 0, 5, 1541866713, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 100000, 500000, '', 0, 0),
(100, 'DEV', 'DEV100', 3, 1, 10000, 11657, 10000, 11657, '动态内容缺失', '详看附件', '', 3, 3, 3, 1541872925, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 700000, '', 0, 0),
(101, 'DEV', 'DEV101', 3, 1, 10000, 10000, 10000, 10000, '安装文档还要添加 Redis Sphinx 和 定时任务说明', '', '', 3, 0, 5, 1541957329, 1541957329, '0000-00-00', '0000-00-00', NULL, 0, NULL, 3, 0, 0, 600000, '', 0, 0),
(102, 'DEV', 'DEV102', 3, 4, 10000, 10000, 10000, 10000, '详情页面参考jira7.12', '详看附件', '', 4, 10000, 6, 1542040723, 1542040723, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 0, 1900000, '', 0, 0),
(103, 'DEV', 'DEV103', 3, 1, 10000, 10000, 10000, 10000, '迭代的数据统计错误', '', '', 2, 0, 5, 1542176236, 1542176236, '0000-00-00', '0000-00-00', NULL, 6, NULL, 3, 0, 0, 500000, '', 0, 0),
(104, 'DEV', 'DEV104', 3, 1, 10000, 11654, 10000, 11654, '上传附件删除时需要汉化', '', '', 3, 1, 1, 1542558617, 1542558617, '0000-00-00', '0000-00-00', NULL, 11, NULL, 3, 0, 0, 400000, '', 0, 0),
(105, 'DEV', 'DEV105', 3, 1, 10000, 11656, 10000, 11656, '用户头像上传后的大小和设置时的大小不一致', '', '', 2, 0, 5, 1542729562, 1542729562, '0000-00-00', '0000-00-00', NULL, 4, NULL, 3, 0, 0, 200000, '', 0, 0),
(106, 'DEV', 'DEV106', 3, 4, 10000, 10000, 10000, 10000, '在创建和编辑事项时可以通过二维码在手机上传附件', '', '', 3, 0, 3, 1542765651, 1542765651, '0000-00-00', '0000-00-00', NULL, 11, NULL, 4, 0, 0, 700000, '', 0, 0),
(108, 'DEV', 'DEV108', 3, 2, 10000, 10000, 10000, 11657, '自定义首页面板', '', '', 3, 0, 1, 1542766745, 1542766745, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 60, 200000, 1000000, '', 0, 0),
(111, 'DEV', 'DEV111', 3, 1, 10000, 10000, 10000, 10000, '实现自动安装的功能', '', '', 3, 0, 3, 1543309637, 1543309637, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 30, 0, 1900000, '', 0, 0),
(112, 'DEV', 'DEV112', 3, 2, 10000, 10000, 10000, 11656, '增加docker安装方式', '要充分进行测试\r\n支持以下操作系统\r\nwin10\r\nmac\r\nlinux\r\n', '', 3, 0, 3, 1543309913, 1543309913, '2018-11-27', '2018-12-05', NULL, 0, NULL, 4, 20, 0, 2000000, '', 0, 0),
(113, 'DEV', 'DEV113', 3, 1, 10000, 10000, 10000, 10000, '创建事项时默认的状态应该为 打开 ', '', '', 3, 0, 3, 1543310077, 1543310077, '2018-11-27', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 2100000, '', 0, 0),
(114, 'DEV', 'DEV114', 3, 1, 10000, 0, 10000, 11657, '优化文档', '1.文档用词要更专业化更容易理解\r\n2.截图过多，要适当的删减\r\n3.要重点说明：迭代(排序规则，可以拖拽等)；看板的事项可拖拽；解释事项的权重；自定义工作流；自定义事项的表单；事项类型和项目的关系\r\n', '', 3, 10000, 6, 1543310616, 1543310616, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 2200000, '', 0, 0),
(115, 'DEV', 'DEV115', 3, 2, 10000, 10000, 10000, 11654, '增加左侧菜单的布局', '参考一下成熟方案\r\n\r\nhttps://preview.pro.ant.design/dashboard/analysis\r\n\r\n\r\n', '', 2, 0, 3, 1543313567, 1543313567, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 30, 0, 2400000, '', 0, 0),
(116, 'DEV', 'DEV116', 3, 4, 10000, 10000, 10000, 11656, '事项列表的表格行中双击可以直接修改状态和解决结果、经办人', '', '', 3, 0, 3, 1543313945, 1543313945, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 20, 0, 2300000, '', 0, 0),
(118, 'DEV', 'DEV118', 3, 1, 10000, 10000, 10000, 11654, '事项列表-增加类似gitlab的展示方式(去除table tr td)', '参考\r\n\r\nhttps://gitlab.com/gitlab-org/gitlab-runner/issues\r\n\r\nhttps://preview.pro.ant.design/list/basic-list', '', 3, 0, 3, 1543314501, 1543314501, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 1200000, '', 0, 0),
(119, 'DEV', 'DEV119', 3, 4, 10000, 10000, 10000, 11656, '增强安全性防止 XSS 和 CSRF 攻击', '', '', 2, 0, 4, 1543314945, 1543314945, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 30, 0, 1500000, '', 0, 0),
(120, 'DEV', 'DEV120', 3, 1, 10000, 10000, 10000, 10000, '创建事项时默认的状态错误', '默认状态应该是 打开', '', 2, 0, 4, 1543314989, 1543314989, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 1600000, '', 0, 0),
(121, 'DEV', 'DEV121', 3, 4, 10000, 10000, 10000, 11655, '当用户初次体验系统是在一些高级的功能UI上添加提示功能', '使用 Hopscotch\r\nhttp://www.jq22.com/yanshi215\r\n\r\n###提示的UI有：\r\n- 事项列表的快捷键\r\n- 事项列表的搜索功能\r\n- 迭代可以拖拽\r\n- 看板可以拖拽\r\n- 迭代统计\r\n- 迭代图表\r\n\r\n', '', 3, 10000, 6, 1543315331, 1543315331, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 1300000, '', 0, 0),
(122, 'DEV', 'DEV122', 3, 2, 10000, 10000, 10000, 11655, '新手教程', '新手：第一次进行系统的用户\r\n\r\n参考 Hopscotch\r\nhttp://www.jq22.com/yanshi215\r\n\r\n新手内容有\r\n\r\n对于管理员： 创建项目 创建事项 修改状态 迭代管理 看板使用\r\n', '', 2, 0, 4, 1543315524, 1543315524, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 1700000, '', 0, 0),
(123, 'DEV', 'DEV123', 3, 2, 10000, 10000, 10000, 10000, '添加 hotjar 用于收集用户使用masterlab的使用情况', 'hotjar ', '', 3, 0, 4, 1543315590, 1543315590, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 1400000, '', 0, 0),
(124, 'DEV', 'DEV124', 3, 1, 10000, 10000, 10000, 11657, '自定义首页面板', '注：首页已经实现了 拖拽 app/view/gitlab/dashboard_sortable.php\r\n\r\nhttps://github.com/arboshiki/lobipanel\r\n\r\n请参考 \r\njira7 版本的自定义面板功能\r\nhttp://www.jq22.com/yanshi10850\r\nhttp://www.jq22.com/yanshi5531\r\nhttps://github.com/williammustaffa/jquery.dad.js', '', 1, 10000, 6, 1543315755, 1543315755, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 60, 0, 1800000, '', 0, 0),
(125, 'DEV', 'DEV125', 3, 4, 10000, 10000, 10000, 10000, '完善二次开发指南', '', '', 3, 0, 4, 1543316506, 1543316506, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 0, 0, 1100000, '', 0, 0),
(126, 'DEV', 'DEV126', 3, 2, 10000, 10000, 10000, 10000, '插件功能', '', '', 2, 10000, 6, 1543316541, 1543316541, '2018-11-28', '2018-12-05', NULL, 0, NULL, 0, 70, 0, 2100000, '', 0, 0),
(127, 'DEV', 'DEV127', 3, 1, 10000, 0, 10000, 11654, '迭代页面无法编辑事项', '', '', 2, 0, 4, 1543370239, 1543370239, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 900000, '', 0, 0),
(128, 'DEV', 'DEV128', 3, 1, 10000, 0, 10000, 10000, '图表统计颜色错误', '', '', 3, 0, 1, 1543372068, 1543372068, '2018-11-28', '2018-12-05', NULL, 0, NULL, 4, 10, 0, 800000, '', 0, 0),
(129, 'DEV', 'DEV129', 3, 4, 10000, 10000, 10000, 11655, '统一更换logo', '更换为这个\r\ngitlab/images/logo.png ', '', 3, 0, 1, 1543598948, 1543598948, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 100000, '', 0, 0),
(130, 'DEV', 'DEV130', 3, 1, 10000, 0, 10000, 10000, '完善权限控制', '\r\n1.对没有权限的用户不可访问相关的页面和数据\r\n2.在文档中针对权限系统进行说明', '', 3, 0, 4, 1543599053, 1543599053, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 200000, '', 0, 0),
(131, 'DEV', 'DEV131', 3, 1, 10000, 0, 10000, 11654, '事项列表的右侧的详情浮动中，无事项标题', '', '', 2, 0, 4, 1543599218, 1543599218, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 400000, '', 0, 0),
(132, 'DEV', 'DEV132', 3, 1, 10000, 0, 10000, 10000, '注册时发送邮件地址有误', '', '', 2, 0, 4, 1543642156, 1543642156, '0000-00-00', '0000-00-00', NULL, 0, NULL, 4, 0, 0, 500000, '', 0, 0),
(133, 'DEV', 'DEV133', 3, 1, 10000, 10000, 10000, 11655, '使用非chrome Firefox浏览器时没有提示兼容性', '同时提示用户去下载 谷歌和QQ浏览器 ', '', 3, 0, 4, 1543644426, 1543644426, '2018-12-01', '2018-12-04', NULL, 0, NULL, 4, 0, 0, 300000, '', 0, 0),
(134, 'DEV', 'DEV134', 3, 1, 10000, 0, 10000, 10000, '当登录状态失效后Ajax请求的接口应该跳转到登录页面', '', '', 2, 0, 4, 1543644588, 1543644588, '2018-12-01', '2018-12-04', NULL, 0, NULL, 4, 0, 0, 600000, '', 0, 0);

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

--
-- 转存表中的数据 `log_operating`
--
- --------------------------------------------------------

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
(481, 11656, 3, '更新了评论 - 1. 框架已集成提交字段过滤的功能来抵御XSS\n', 'issue_comment', 40, '- 1. 框架已集成提交字段过滤的功能\n![](http://pm.masterlab.vip/attachment/image/20181201/20181201152353_87673.png)\n\n- 2. 需要增加CSRF的安全功能', '2018-12-01', 1543649198);

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
('dict/description_template/getAll/0,*', 'dict/description_template', '2018-12-05 08:47:52', 1543970872),
('dict/label/getAll/0,*', 'dict/label', '2018-12-05 09:52:38', 1543974758),
('dict/label/getAll/1,*', 'dict/label', '2018-12-05 10:28:16', 1543976896),
('dict/list_count/getAll/1,*', 'dict/list_count', '2018-12-06 17:50:16', 1544089816),
('dict/main/getAll/0,*', 'dict/main', '2018-12-05 08:48:02', 1543970882),
('dict/priority/getAll/1,*', 'dict/priority', '2018-12-05 08:48:15', 1543970895),
('dict/resolve/getAll/1,*', 'dict/resolve', '2018-12-05 10:28:16', 1543976896),
('dict/sprint/getAll/0,*', 'dict/sprint', '2018-12-05 23:56:01', 1544025361),
('dict/sprint/getItemById/1', 'dict/sprint', '2018-12-05 10:05:25', 1543975525),
('dict/sprint/getItemById/4', 'dict/sprint', '2018-12-09 12:46:57', 1544330817),
('dict/status/getAll/1,*', 'dict/status', '2018-12-05 08:48:15', 1543970895),
('dict/type/getAll/0,*', 'dict/type', '2018-12-05 08:48:02', 1543970882),
('dict/type/getAll/1,*', 'dict/type', '2018-12-05 08:48:02', 1543970882),
('dict/type_scheme/getAll/1,*', 'dict/type_scheme', '2018-12-04 17:12:05', 1543914725),
('setting/getSettingByKey/datetime_format', 'setting', '2018-12-05 08:47:46', 1543970866),
('setting/getSettingByKey/date_timezone', 'setting', '2018-12-05 08:47:20', 1543970840),
('setting/getSettingByKey/full_datetime_format', 'setting', '2018-12-05 08:47:47', 1543970867),
('setting/getSettingByKey/login_require_captcha', 'setting', '2018-12-05 08:47:20', 1543970840),
('setting/getSettingByKey/reg_require_captcha', 'setting', '2018-12-05 08:47:20', 1543970840),
('setting/getSettingByKey/title', 'setting', '2018-12-05 08:47:20', 1543970840),
('setting/getSettingRow/muchErrorTimesCaptcha', 'setting', '2018-12-05 08:47:46', 1543970866),
('setting/getSettingRow/project_view', 'setting', '2018-12-05 08:47:52', 1543970872);

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
(50, 'send_mailer', '发信人', 'mail', 'ismond@vip.163.com', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 'Hornet', '', 'string', 'text', NULL, ''),
(52, 'mail_host', '主机', 'mail', 'smtp.vip.163.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', '25', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 'ismond@vip.163.com', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 'ismond163vip', '', 'string', 'text', NULL, ''),
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
(10, 3, 'backlog_weight', '{\"65\":400000,\"59\":300000,\"95\":200000,\"96\":100000}', 1542430437),
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
(83, 1, 'backlog_weight', '{\"3\":100000}', 1543569299),
(84, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1543569454),
(85, 3, 'sprint_4_weight', '{\"98\":2000000,\"97\":1900000,\"115\":1800000,\"116\":1700000,\"114\":1600000,\"113\":1500000,\"112\":1400000,\"111\":1300000,\"124\":1200000,\"122\":1100000,\"120\":1000000,\"119\":900000,\"123\":800000,\"121\":700000,\"118\":600000,\"125\":500000,\"108\":400000,\"127\":300000,\"128\":200000,\"106\":100000}', 1543598520),
(86, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543598525),
(87, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543647145),
(88, 3, 'sprint_4_weight', '{\"98\":2600000,\"97\":2500000,\"115\":2400000,\"116\":2300000,\"114\":2200000,\"113\":2100000,\"112\":2000000,\"111\":1900000,\"124\":1800000,\"122\":1700000,\"120\":1600000,\"119\":1500000,\"123\":1400000,\"121\":1300000,\"118\":1200000,\"125\":1100000,\"108\":1000000,\"127\":900000,\"128\":800000,\"106\":700000,\"134\":600000,\"132\":500000,\"131\":400000,\"133\":300000,\"130\":200000,\"129\":100000}', 1543647146),
(89, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543647147),
(90, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543684395),
(91, 3, 'backlog_weight', '{\"64\":600000,\"65\":500000,\"59\":400000,\"95\":300000,\"96\":200000,\"99\":100000}', 1543726017);

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

--
-- 转存表中的数据 `project_main`
--

INSERT INTO `project_main` (`id`, `org_id`, `org_path`, `name`, `url`, `lead`, `description`, `key`, `pcounter`, `default_assignee`, `assignee_type`, `avatar`, `category`, `type`, `type_child`, `permission_scheme_id`, `workflow_scheme_id`, `create_uid`, `create_time`, `detail`, `un_done_count`, `done_count`, `closed_count`) VALUES
(1, 1, 'default', '客户管理crm系统', '', 10000, '                                                                                                                                                                                                                基于人工智能的客户关系管理系统                                                                                                                                                                                                ', 'CRM', NULL, 1, NULL, 'avatar/20181017/20181017180352_48634.jpg', 0, 10, 0, 0, 0, 10000, 1536553005, 'CRM(Customer Relationship Management\r\n\r\n客户关系管理，是一种以\"客户关系一对一理论\"为基础，旨在改善企业与客户之间关系的新型管理机制。客户关系管理的定义是：企业为提高核心竞争力，利用相应的信息技术以及互联网技术来协调企业与顾客间在销售、营销和服务上的交互，从而提升其管理方式，向客户提供创新式的个性化的客户交互和服务的过程。其最终目标是吸引新客户、保留老客户以及将已有客户转为忠实客户，增加市场份额。\r\n\r\n最早发展客户关系管理的国家是美国，这个概念最初由Gartner Group提出来，在1980年初便有所谓的“接触管理”(Contact Management)，即专门收集客户与公司联系的所有信息，到1990年则演变成包括电话服务中心支持资料分析的客户关怀（Customer care）。开始在企业电子商务中流行。\r\n\r\nCRM系统的宗旨是：为了满足每个客户的特殊需求，同每个客户建立联系，通过同客户的联系来了解客户的不同需求，并在此基础上进行\"一对一\"个性化服务。通常CRM包括销售管理、市场营销管理、客户服务系统以及呼叫中心等方面。\r\n“以客户为中心”，提高客户满意度，培养、维持客户忠诚度，在今天这个电子商务时代显得日益重要。客户关系管理正是改善企业与客户之间关系的新型管理机制，越来越多的企业运用CRM来增加收入、优化赢利性、提高客户满意度。\r\n\r\n统计数据表明，2008年中小企业CRM市场的规模已达8亿美元。在随后五年中，这一市场将快速增长至18亿美元，在整个CRM市场中占比达30%以上。 \r\n\r\nCRM系统主要包含传统CRM系统和在线CRM系统。', 1, 2, 1),
(2, 1, 'default', 'ERP系统实施', '', 10000, '                                                    公司内部ERP项目的实施                                                ', 'ERP', NULL, 1, NULL, 'avatar/20180913/20180913144752_28827.jpg', 0, 10, 0, 0, 0, 10000, 1536821242, '收藏 8742\r\n968\r\nERP系统 编辑\r\nERP系统是企业资源计划(Enterprise Resource Planning )的简称，是指建立在信息技术基础上，集信息技术与先进管理思想于一身，以系统化的管理思想，为企业员工及决策层提供决策手段的管理平台。它是从MRP（物料需求计划）发展而来的新一代集成化管理信息系统，它扩展了MRP的功能，其核心思想是供应链管理。它跳出了传统企业边界，从供应链范围去优化企业的资源，优化了现代企业的运行模式，反映了市场对企业合理调配资源的要求。它对于改善企业业务流程、提高企业核心竞争力具有显著作用。\r\n\r\n系统特点编辑\r\nERP是Enterprise Resource Planning（企业资源计划）的简称，是上个世纪90年代美国一家IT公司根据当时计算机信息、IT技术发展及企业对供应链管理的需求，预测在今后信息时代企业管理信息系统的发展趋势和即将发生变革，而提出了这个概念。 ERP是针对物资资源管理（物流）、人力资源管理（人流）、财务资源管理（财流）、信息资源管理（信息流）集成一体化的企业管理软件。它将包含客户/服务架构，使用图形用户接口，应用开放系统制作。除了已有的标准功能，它还包括其它特性，如品质、过程运作管理、以及调整报告等。\r\nERP系统的特点有：\r\n企业内部管理所需的业务应用系统，主要是指财务、物流、人力资源等核心模块。\r\n\r\n物流管理系统采用了制造业的MRP管理思想；FMIS有效地实现了预算管理、业务评估、管理会计、ABC成本归集方法等现代基本财务管理方法；人力资源管理系统在组织机构设计、岗位管理、薪酬体系以及人力资源开发等方面同样集成了先进的理念。\r\nERP系统是一个在全公司范围内应用的、高度集成的系统。数据在各业务系统之间高度共享，所有源数据只需在某一个系统中输入一次，保证了数据的一致性。\r\n对公司内部业务流程和管理过程进行了优化，主要的业务流程实现了自动化。\r\n采用了计算机最新的主流技术和体系结构：B/S、INTERNET体系结构，WINDOWS界面。在能通信的地方都可以方便地接入到系统中来。\r\n集成性、先进性、统一性、完整性、开放性。\r\n实用性\r\nERP系统实际应用中更重要的是应该体现其“管理工具”的本质。ERP系统主要宗旨是对企业所拥有的人、财、物、信息、时间和空间等综合资源进行综合平衡和优化管理，ERP软件协调企业各管理部门，ERP系统围绕市场导向开展业务活动，提高企业的核心竞争力，ERP软件从而取得最好的经济效益。所以，ERP系统首先是一个软件，同时是一个管理工具。ERP软件是IT技术与管理思想的融合体，ERP系统也就是先进的管理思想借助电脑，来达成企业的管理目标。\r\n整合性\r\nERP最大特色便是整个企业信息系统的整合，比传统单一的系统更具功能性。\r\n弹性\r\n采用模块化的设计方式，使系统本身可因应企业需要新增模块来支持并整合，提升企业的应变能力。\r\n数据储存\r\n将原先分散企业各角落的数据整合起来，使数据得以一致性，并提升其精确性。\r\n便利性\r\n在整合的环境下，企业内部所产生的信息透过系统将可在企业任一地方取得与应用。\r\n管理绩效\r\nERP系统将使部分间横向的联系有效且紧密，使得管理绩效提升。\r\n互动关系\r\n透过ERP系统配合使企业与原物料供货商之间紧密结合，增加其市场变动的能力。而CRM客户关系管理系统则使企业充分掌握市场需要取向的动脉，两者皆有助于促进企业与上下游的互动发展关系。\r\n实时性\r\nERP是整个企业信息的整合管理，重在整体性，而整体性的关键就体现于“实时和动态管理”上，所谓“兵马未动，粮草先行”，强调的就是不同部门的“实时动态配合”，现实工作中的管理问题，也是部门协调与岗位配合的问题，因此缺乏“实时动态的管理手段和管理能力”的ERP管理，就是空谈。\r\n及时性\r\nERP管理的关键是“现实工作信息化”，即把现实中的工作内容与工作方式，用信息化的手段来表现，因为人的精力和能力是有限的，现实事务达到一定的繁杂程度后，人就会在所难免的出错，将工作内容与工作方式信息化，就能形成ERP管理的信息化体系，才能拥有可靠的信息化管理工具。', 1, 0, 0),
(3, 1, 'default', 'Masterlab-Development', 'http://master.888zb.com/about.php', 10000, 'Masterlab的项目管理', 'DEV', NULL, 1, NULL, 'avatar/20181015/20181015102601_18003.png', 0, 10, 0, 0, 0, 10000, 1539089761, ':tw-1f41d:Masterlab\r\nMasterLab是公司的核心产品和服务平台,帮助团队随时随地的，专注的管理和参与项目，实现目标，成就伟大产品!\r\n\r\n \r\n\r\nMasterLab由来, master为“主人，教练”译义，而产品经理和项目经理是产品设计和项目研发过程中的关键角色，lab为“实验室”译义；我们期望他们的工作就像在呆实验室一样，轻松的，简单\r\n\r\n \r\n\r\nlogo设计创意：当我们走在花丛中,看着翩翩起舞的蝴蝶会惊羡于她们的美丽,可鲜为人知的是一只只蝴蝶卵需要在黑暗而密闭的蛹经历数白日的煎熬,才能破茧成蝶,凤凰涅槃。这恰恰就是一个成功产品经历的过程。 一只南美洲亚马逊河流域热带雨林中的蝴蝶，偶尔扇动几下翅膀，可以在两周以后引起美国德克萨斯州的一场龙卷风，这就是蝴蝶效应。 蝴蝶互动的精神也是这样，我们只要轻扇翅膀，就能引起一场互联网的风暴。\r\n\r\n', 25, 90, 8),
(5, 1, 'default', '盖房子', '', 10000, '', 'FANGZI', NULL, 1, NULL, '', 0, 10, 0, 0, 0, 10000, 1542879646, '', 0, 0, 0);

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
(15, 3, '系统-用户', '', 0, 0, 1539092002);

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
(80, 3, 12, 10005),
(81, 3, 12, 10006),
(82, 3, 12, 10007),
(83, 3, 12, 10008),
(84, 3, 12, 10013),
(85, 3, 12, 10014),
(86, 3, 12, 10015),
(87, 3, 12, 10028),
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
(185, 5, 25, 10904);

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

--
-- 转存表中的数据 `user_attributes`
--

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
(6, 'cfm_test', '442118411@qq.com', 11658, 'JUR4B9DXBRX4R11QV4NP27X76ODK8PQ1', 1541489893);

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

--
-- 转存表中的数据 `user_login_log`
--


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
(1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', '18002510000@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '', 0, 0, '', '', NULL, NULL, NULL, NULL, 1543686390, 0, 0, '管理员', '交付卓越产品!'),
(10000, 1, '18002516775', 'cdwei', 'b7a782741f667201b54880c925faec4b', 1, '', 'Sven', 'Sven', '121642038@qq.com', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '', 0, 0, 'avatar/10000.png?t=1540833319', '', NULL, NULL, NULL, NULL, 1543726006, 0, 0, '产品经理 & 技术经理', '努力是为了让自己更快乐~'),
(11652, NULL, NULL, '79720699@qq.com', '8ceb21e5b4b18e6ae2f63f4568ffcca6', 1, NULL, NULL, '韦哥', '79720699@qq.com', '$2y$10$qZQaNkcprlkr4/T.yk30POfWapHaVf2sYXhVvvdhdJ2kVOy4Mf1Le', 0, NULL, 1536721687, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'coo', NULL),
(11653, NULL, NULL, 'luxueting@qq.com', '37768ff1f406a7ffeb869a39fb84f005', 1, NULL, NULL, '陆雪婷', 'luxueting@qq.com', '$2y$10$YpOrL9dehAD9oo1UZ2e38ujSd.TuC6yV5eq2yQp2knLBpU09uomiq', 0, NULL, 1536721754, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'CI', NULL),
(11654, NULL, NULL, '1043423813@qq.com', '7874f7ec72dc03d77bd1627c0350a770', 1, NULL, NULL, 'Jelly', '1043423813@qq.com', '$2y$10$d6rrId1okEVAC8yQweeLZ.Ri8HfiBLosXG2A6i05QsGenhCl8Mtce', 0, '', 1539092584, 0, 'avatar/11654.png?t=1539845533', '', NULL, NULL, NULL, '', 1543551680, 0, 0, '高级前端工程师', NULL),
(11655, NULL, NULL, 'moxao@vip.qq.com', '44466a8b2af46b8de06fb2846e4ba97b', 1, NULL, NULL, 'Mo', 'moxao@vip.qq.com', '$2y$10$OmoUAOqSilUDOGM1ZGm1vuKMZLV/oSHYsXUDK4S3h/oJD14MWKFdu', 0, '', 1539092621, 0, 'avatar/11655.png?t=1539770756', '', NULL, NULL, NULL, '', 1541579251, 0, 0, '高级设计师', NULL),
(11656, NULL, NULL, '23335096@qq.com', '63db4462b453ac29a280bade38e8b3d6', 1, NULL, NULL, '李建', '23335096@qq.com', '$2y$10$V.OsAQuPq0V1pymlhE1.yuXE7aJRaKUOVDvB5k0Zj5/SOSNLptzbW', 1, '', 1539092741, 0, 'avatar/11656.png', '', NULL, NULL, NULL, '', 1543306260, 0, 0, 'CTO', NULL),
(11657, NULL, NULL, '296459175@qq.com', '31cca79124bdd459995b52a391d54e49', 1, NULL, NULL, '陈方铭', '296459175@qq.com', '$2y$10$fN8VbuEfd.BWqmVW/Q.zd.jGB4TJWwrsUq/Dze11Mrq0ftNFBn3zG', 1, '', 1539158699, 0, 'avatar/11657.png?t=1539830329', '', NULL, NULL, NULL, '', 1543387929, 0, 0, '开发工程师', NULL),
(11658, NULL, NULL, NULL, '6ab429a22a03c5b6f2a995b486cd01b0', 1, NULL, NULL, 'cfm_test', '442118411@qq.com', '$2y$10$t7tmIS6wo1rUq6Q1pVvjhuxxAxPAQ02eR5jOoBg6.g1vnHq2N9OPe', 0, NULL, 1541489893, 0, '', '', NULL, NULL, NULL, '', 1541490380, 0, 0, '', NULL);

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
-- 表的索引 `issue_resolve2`
--
ALTER TABLE `issue_resolve2`
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
-- 表的索引 `option_configuration`
--
ALTER TABLE `option_configuration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fieldid_optionid` (`fieldid`,`optionid`),
  ADD KEY `fieldid_fieldconf` (`fieldid`,`fieldconfig`);

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
  ADD PRIMARY KEY (`uid`);

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
  ADD KEY `uid` (`uid`) USING HASH;

--
-- 表的索引 `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=841;

--
-- 使用表AUTO_INCREMENT `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_activity`
--
ALTER TABLE `main_activity`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=482;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- 使用表AUTO_INCREMENT `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- 使用表AUTO_INCREMENT `user_email_active`
--
ALTER TABLE `user_email_active`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=844;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11659;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=340;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
