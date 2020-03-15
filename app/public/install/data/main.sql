

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
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `range_type` enum('current_sprint','all','sprints','modules','issue_types') NOT NULL COMMENT '看板数据范围',
  `range_data` varchar(1024) NOT NULL COMMENT '范围数据',
  `is_system` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `agile_board`
--

INSERT INTO `agile_board` (`id`, `name`, `project_id`, `type`, `is_filter_backlog`, `is_filter_closed`, `weight`, `range_type`, `range_data`, `is_system`) VALUES
(1, '进行中的迭代', 0, 'status', 0, 1, 99999, 'current_sprint', '', 1),
(2, '整个项目', 0, 'status', 0, 1, 99998, 'all', '', 1),
(19, '自定义看板3', 1, NULL, 1, 1, 0, 'all', '[]', 0);

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
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `active` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1为准备中，2为已完成，3为已归档',
  `order_weight` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `target` text NOT NULL COMMENT 'sprint目标内容',
  `inspect` text NOT NULL COMMENT 'Sprint 评审会议内容',
  `review` text NOT NULL COMMENT 'Sprint 回顾会议内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `agile_sprint`
--

INSERT INTO `agile_sprint` (`id`, `project_id`, `name`, `description`, `active`, `status`, `order_weight`, `start_date`, `end_date`, `target`, `inspect`, `review`) VALUES
(1, 1, '1.0迭代', '', 1, 1, 0, '2020-01-17', '2020-03-31', '', '', ''),
(2, 1, '2.0迭代', 'xxxx', 0, 1, 0, '2020-02-19', '2020-02-29', '', '', '');

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
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `custom_field_id` int(11) DEFAULT NULL,
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
  `order_weight` int(11) UNSIGNED NOT NULL DEFAULT '0',
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
(18, 'effect_version', '影响版本', NULL, 'VERSION', NULL, 1, '', 0, ''),
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
  `expire` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- 表的结构 `issue_description_template`
--

CREATE TABLE `issue_description_template` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `created` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间'
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
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
  `version_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `issue_extra_worker_day`
--

CREATE TABLE `issue_extra_worker_day` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT '0',
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
(1, '7436abdc-44a0-40d0-8e52-caa2be27d765', 0, '', 'image/png', 'project_example_icon.png', 'project_image/20200117/20200117154554_20263.png', 1579247154, 1136, 1, 'png'),
(2, 'addaecfb-a0ad-4813-ab7e-1299c2e6d3b2', 5, '', 'image/png', 'project.png', 'all/20200212/20200212213520_43572.png', 1581514520, 17411, 1, 'png'),
(3, 'mUQHoeOUjGSdOoio844873', 0, '', 'application/octet-stream', 'import_tpl.xlsx', 'file/20200222/20200222215932_88793.xlsx', 1582379972, 14285, 1, 'xlsx'),
(4, 'RJa4hTPGncexucNh181690', 0, '', 'application/octet-stream', 'import_tpl.xlsx', 'file/20200222/20200222220011_56307.xlsx', 1582380011, 14285, 1, 'xlsx'),
(5, 'HJEMPDSxTFMnWB4k543098', 0, '', 'application/octet-stream', 'import_tpl.xlsx', 'file/20200222/20200222220241_72011.xlsx', 1582380161, 15991, 1, 'xlsx'),
(6, '34549ce8-c869-4848-8555-a81a8269a3fa', 0, '', 'image/jpeg', '019__D722538.jpg', 'all/20200223/20200223185852_86769.jpg', 1582455532, 268943, 1, 'jpg'),
(7, '5ae0d404-8914-4163-8295-ad7312b3232a', 0, '', 'image/jpeg', '019__D722538.jpg', 'all/20200223/20200223190002_31934.jpg', 1582455602, 268943, 1, 'jpg'),
(8, 'dc13b89b-7bac-47de-8a69-63456eddfaf1', 0, '', 'image/jpeg', '019__D722538.jpg', 'all/20200223/20200223190042_49763.jpg', 1582455642, 268943, 1, 'jpg'),
(9, '01c8c24a-7a61-42c7-83ca-97612dc08d2a', 33, '', 'image/png', 'bg.png', 'all/20200223/20200223190216_19803.png', 1582455736, 118546, 1, 'png'),
(10, '73098924-de30-4cdc-ab2e-80461a5ba4e4', 0, '', 'image/jpeg', 'crm.jpg', 'project_image/20200224/20200224192240_65716.jpg', 1582543360, 11071, 1, 'jpg'),
(11, '404573ab-fc00-424c-9fd4-8a7462db654b', 0, '', 'image/jpeg', 'crm2.jpg', 'project_image/20200224/20200224193705_78861.jpg', 1582544225, 6161, 1, 'jpg'),
(12, '1582716044429', 0, '', 'image/jpeg', 'crm.jpg', 'image/20200226/20200226192049_23688.jpg', 1582716049, 11071, 1, 'jpg');

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
  `filter` mediumtext,
  `fav_count` decimal(18,0) DEFAULT NULL,
  `name_lower` varchar(255) DEFAULT NULL,
  `is_adv_query` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为高级查询'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_filter`
--

INSERT INTO `issue_filter` (`id`, `name`, `author`, `description`, `share_obj`, `share_scope`, `projectid`, `filter`, `fav_count`, `name_lower`, `is_adv_query`) VALUES
(1, '2.0迭代', 1, '', NULL, '', '1', '迭代:2.0迭代 sort_field:id sort_by:desc', NULL, NULL, 0),
(2, '经办人Master', 1, '', NULL, '', '1', '经办人:@master sort_field:id sort_by:desc', NULL, NULL, 0),
(10, '我报告的bug', 1, '', NULL, '', '1', '报告人:@master 类型:Bug sort_field:id sort_by:desc', NULL, NULL, 0),
(11, '我进行中的', 1, '', NULL, '', '1', '报告人:@master 状态:进行中 sort_field:id sort_by:desc', NULL, NULL, 0),
(12, '我优先级中的', 1, '', NULL, '', '1', '报告人:@master 优先级:中 sort_field:id sort_by:desc', NULL, NULL, 0),
(13, '我2.0迭代的事项', 1, '', NULL, '', '1', '报告人:@master 迭代:2.0迭代 sort_field:id sort_by:desc', NULL, NULL, 0),
(14, '新功能的', 1, '', NULL, '', '1', '类型:新功能 sort_field:id sort_by:desc', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `issue_fix_version`
--

CREATE TABLE `issue_fix_version` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED DEFAULT NULL,
  `version_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 116, 1);

-- --------------------------------------------------------

--
-- 表的结构 `issue_holiday`
--

CREATE TABLE `issue_holiday` (
  `id` int(11) NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `day` date NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_holiday`
--

INSERT INTO `issue_holiday` (`id`, `project_id`, `day`, `name`) VALUES
(602, 1, '2020-05-01', ''),
(603, 1, '2020-05-02', ''),
(604, 1, '2020-05-03', ''),
(605, 1, '2020-05-04', ''),
(606, 1, '2020-10-01', ''),
(607, 1, '2021-01-01', ''),
(608, 1, '2021-05-01', ''),
(609, 1, '2021-05-02', ''),
(610, 1, '2021-05-03', ''),
(611, 1, '2021-05-04', ''),
(612, 1, '2021-10-01', ''),
(613, 1, '2022-01-01', ''),
(614, 1, '2020-10-02', ''),
(615, 1, '2020-10-03', ''),
(616, 1, '2020-10-04', ''),
(617, 1, '2020-10-05', ''),
(618, 1, '2020-10-06', ''),
(619, 1, '2020-10-07', ''),
(620, 1, '2021-10-02', ''),
(621, 1, '2021-10-03', ''),
(622, 1, '2021-10-04', ''),
(623, 1, '2021-10-05', ''),
(624, 1, '2021-10-06', ''),
(625, 1, '2021-10-07', '');

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
  `duration` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `resolve_date` date DEFAULT NULL,
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `level` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '甘特图级别',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否拥有子任务',
  `followed_count` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '被关注人数',
  `comment_count` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数',
  `progress` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '完成百分比',
  `depends` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前置任务',
  `gant_sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT '迭代甘特图中该事项在同级的排序权重',
  `gant_hide` tinyint(1) NOT NULL DEFAULT '0' COMMENT '甘特图中是否隐藏该事项',
  `is_start_milestone` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `is_end_milestone` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `issue_main`
--

INSERT INTO `issue_main` (`id`, `pkey`, `issue_num`, `project_id`, `issue_type`, `creator`, `modifier`, `reporter`, `assignee`, `summary`, `description`, `environment`, `priority`, `resolve`, `status`, `created`, `updated`, `start_date`, `due_date`, `duration`, `resolve_date`, `module`, `milestone`, `sprint`, `weight`, `backlog_weight`, `sprint_weight`, `assistants`, `level`, `master_id`, `have_children`, `followed_count`, `comment_count`, `progress`, `depends`, `gant_sprint_weight`, `gant_hide`, `is_start_milestone`, `is_end_milestone`) VALUES
(1, 'example', '1', 1, 3, 1, 1, 1, 12166, '数据库设计', 'xxxxxx', '', 4, 2, 1, 1579249719, 1582133907, '2020-01-17', '2020-01-30', 10, NULL, 2, NULL, 1, 80, 0, 1800000, '', 0, 0, 3, 0, 0, 0, '', 999800000, 0, 0, 0),
(2, 'example', '2', 1, 3, 1, 1, 1, 1, '服务器端架构设计', 'xxxxxxxxxxxxxxxxxxxxx\r\n1**xxxxxxxx**', '', 3, 2, 1, 1579250062, 1582133914, '2020-03-03', '2020-03-05', 3, NULL, 1, NULL, 1, 80, 0, 1900000, '', 0, 106, 0, 0, 0, 1, '', 998500000, 0, 0, 0),
(3, 'example', '3', 1, 2, 1, 1, 1, 12168, '业务模块开发', 'xxxxx', '', 3, 2, 1, 1579423228, 1579423228, '2020-01-20', '2020-01-24', 5, NULL, 3, NULL, 1, 60, 0, 1600000, '', 0, 0, 4, 0, 0, 0, '', 999500000, 0, 0, 0),
(4, 'example', '4', 1, 3, 1, 1, 1, 1, '数据库表结构设计', '', '', 4, 2, 1, 1579423320, 1583079970, '2020-03-02', '2020-01-01', 0, NULL, 3, NULL, 1, 0, 0, 1700000, '', 0, 1, 0, 0, 0, 0, '', 999600000, 0, 0, 0),
(5, 'example', '5', 1, 3, 1, 1, 1, 12165, '可行性分析', '', '', 4, 1, 1, 1581321497, 1581321497, '2020-03-03', '2020-03-04', 2, NULL, 3, NULL, 1, 0, 0, 1500000, '', 0, 0, 3, 0, 0, 0, '', 998300000, 0, 0, 0),
(8, 'example', '8', 1, 3, 1, 1, 1, 1, '技术可行性分析', '', '', 4, 1, 6, 1582199367, 1582199367, '0000-00-00', '0000-00-00', 0, NULL, 3, NULL, 1, 0, 0, 1400000, '', 0, 5, 0, 0, 0, 0, '', 1000000000, 0, 0, 0),
(53, 'example', '53', 1, 2, 1, 1, 1, 1, '优化改进事项1', '', '', 4, 2, 1, 1582602961, 1582602961, '2020-01-17', '2020-02-29', 31, NULL, 3, NULL, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '', 1000000000, 0, 0, 0),
(54, 'example', '54', 1, 2, 1, 1, 1, 1, 'ER关系设计', '', '', 4, 2, 1, 1582602962, 1582602962, '2020-03-03', '2020-03-06', 4, NULL, 3, NULL, 1, 0, 0, 100000, '', 0, 1, 0, 0, 0, 0, '', 999700000, 0, 0, 0),
(64, 'example', '64', 1, 3, 1, 1, 1, 12164, '前端架构设计', '', '', 3, 2, 1, 1582623716, 1582623716, '2020-03-04', '2020-03-06', 3, NULL, 3, NULL, 1, 0, 0, 200000, '', 0, 106, 1, 0, 0, 0, '', 998600000, 0, 0, 0),
(87, 'example', '87', 1, 3, 1, 1, 1, 1, '产品功能说明书', '', '', 3, 2, 6, 1582693628, 1582693628, '2020-03-01', '2020-03-20', 15, NULL, 3, NULL, 1, 0, 0, 300000, '', 0, 90, 0, 0, 0, 1, '', 998800000, 0, 0, 0),
(90, 'example', '90', 1, 3, 1, 1, 1, 1, '产品设计', '', '', 3, 2, 6, 1582983902, 1582983902, '2020-02-28', '2020-03-03', 3, NULL, 3, NULL, 1, 0, 0, 400000, '', 0, 0, 4, 0, 0, 0, '', 999200000, 0, 0, 0),
(94, 'example', '94', 1, 1, 1, 1, 1, 1, '市场可行性分析', '\r\n这里输入对bug做出清晰简洁的描述.\r\n\r\n**重现步骤**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n4. xxxxxx\r\n\r\n**期望结果**\r\n简洁清晰的描述期望结果\r\n\r\n**实际结果**\r\n简述实际看到的结果，这里可以配上截图\r\n\r\n\r\n**附加说明**\r\n附加或额外的信息\r\n', '', 2, 2, 6, 1582992127, 1582992127, '0000-00-00', '0000-00-00', 0, NULL, 3, NULL, 1, 0, 0, 1300000, '', 0, 5, 0, 0, 0, 0, '', 999900000, 0, 0, 0),
(95, 'example', '95', 1, 3, 1, 1, 1, 1, '交互设计', '', '', 3, 2, 1, 1582993508, 1582993508, '2020-03-09', '2020-03-20', 10, NULL, 3, NULL, 1, 0, 0, 500000, '', 0, 90, 0, 0, 0, 1, '', 999100000, 0, 0, 0),
(96, 'example', '96', 1, 3, 1, 0, 1, 1, 'UI设计', '', '', 3, 2, 3, 1582993557, 1582993557, '2020-03-01', '2020-03-13', 10, NULL, 3, NULL, 1, 0, 0, 600000, '', 0, 90, 0, 0, 0, 0, '', 998900000, 0, 0, 0),
(97, 'example', '97', 1, 3, 1, 0, 1, 1, '流程图设计', '', '', 3, 2, 1, 1582993719, 1582993719, '2020-03-02', '2020-03-20', 15, NULL, 3, NULL, 1, 0, 0, 700000, '', 0, 90, 0, 0, 0, 2, '', 999000000, 0, 0, 0),
(106, 'example', '106', 1, 3, 1, 0, 1, 1, '架构设计', '', '', 3, 2, 3, 1583041489, 1583041489, '2020-03-02', '2020-03-27', 20, NULL, 3, NULL, 1, 0, 0, 800000, '', 0, 0, 2, 0, 0, 0, '', 998700000, 0, 0, 0),
(107, 'example', '107', 1, 3, 1, 1, 1, 1, '用户模块开发编码1', '', '', 3, 2, 1, 1583041630, 1583041630, '2020-03-02', '2020-03-09', 11, NULL, 3, NULL, 1, 0, 0, 900000, '', 0, 3, 0, 0, 0, 0, '', 999300000, 0, 0, 0),
(108, 'example', '108', 1, 3, 1, 1, 1, 1, '产品模块开发编码1', '', '', 3, 2, 3, 1583043244, 1583043244, '2020-03-03', '2020-03-10', 6, NULL, 3, NULL, 1, 0, 0, 1000000, '', 0, 3, 0, 0, 0, 0, '', 999400000, 0, 0, 0),
(116, 'example', '116', 1, 3, 1, 1, 1, 1, '日志模块开发x', '', '', 3, 2, 1, 1583044099, 1583079970, '2020-03-02', '2020-03-27', 20, NULL, 3, NULL, 1, 0, 0, 1200000, '', 0, 0, 0, 1, 0, 0, '', 998400000, 0, 0, 0),
(120, 'example', '120', 1, 3, 1, 1, 1, 1, '优化改进事项2', '', '', 3, 2, 1, 1583232765, 1583232765, '2020-03-03', '2020-03-11', 7, NULL, 0, NULL, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, '', 999900000, 0, 0, 0),
(139, 'example', '139', 1, 3, 1, 0, 1, 12167, '商城模块编码1', '', '', 3, 2, 1, 1583242645, 1583242645, '2020-03-03', '2020-03-11', 7, NULL, 3, NULL, 1, 0, 0, 0, '', 0, 3, 0, 0, 0, 1, '', 999250000, 0, 0, 0);

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
(1, 1, 119, NULL, NULL, 1, 0, 0, 0, 0, 0, 'YYYYYYYYYYYYYYYYY', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"119\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"YYYYYYYYYYYYYYYYY\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583218180\",\"updated\":\"1583218180\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-03-13\",\"duration\":\"10\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"4553125\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583231601),
(2, 1, 118, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwwwwwwwwwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"118\",\"project_id\":\"1\",\"issue_type\":\"1\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12165\",\"summary\":\"wwwwwwwwwwwwww\",\"description\":\"\\u8fd9\\u91cc\\u8f93\\u5165\\u5bf9bug\\u505a\\u51fa\\u6e05\\u6670\\u7b80\\u6d01\\u7684\\u63cf\\u8ff0.\\r\\n\\r\\n**\\u91cd\\u73b0\\u6b65\\u9aa4**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n4. xxxxxx\\r\\n\\r\\n**\\u671f\\u671b\\u7ed3\\u679c**\\r\\n\\u7b80\\u6d01\\u6e05\\u6670\\u7684\\u63cf\\u8ff0\\u671f\\u671b\\u7ed3\\u679c\\r\\n\\r\\n**\\u5b9e\\u9645\\u7ed3\\u679c**\\r\\n\\u7b80\\u8ff0\\u5b9e\\u9645\\u770b\\u5230\\u7684\\u7ed3\\u679c\\uff0c\\u8fd9\\u91cc\\u53ef\\u4ee5\\u914d\\u4e0a\\u622a\\u56fe\\r\\n\\r\\n\\r\\n**\\u9644\\u52a0\\u8bf4\\u660e**\\r\\n\\u9644\\u52a0\\u6216\\u989d\\u5916\\u7684\\u4fe1\\u606f\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583207957\",\"updated\":\"1583207957\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-10\",\"duration\":\"6\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"9106250\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583231601),
(3, 1, 117, NULL, NULL, 1, 0, 0, 0, 0, 0, '121', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"117\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"121\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583165341\",\"updated\":\"1583165341\",\"start_date\":\"2020-03-02\",\"due_date\":\"2020-03-12\",\"duration\":\"9\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"9206250\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583231601),
(4, 1, 109, NULL, NULL, 1, 0, 0, 0, 0, 0, 'xxxxxxxxxxxxx', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"109\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"xxxxxxxxxxxxx\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583043504\",\"updated\":\"1583043504\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-09\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"1100000\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"18412501\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583231601),
(5, 1, 127, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwwwwwwwwwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"127\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wwwwwwwwwwwwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583239382\",\"updated\":\"1583239382\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-06\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"90\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"12\",\"depends\":\"\",\"gant_sprint_weight\":\"120500003\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(6, 1, 126, NULL, NULL, 1, 0, 0, 0, 0, 0, '23423423', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"126\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"23423423\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583239320\",\"updated\":\"1583239320\",\"start_date\":\"2020-03-04\",\"due_date\":\"2020-03-18\",\"duration\":\"11\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"51016409\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(7, 1, 125, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"125\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wwwwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583239295\",\"updated\":\"1583239295\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-12\",\"duration\":\"8\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"121\",\"depends\":\"\",\"gant_sprint_weight\":\"50842190\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(8, 1, 124, NULL, NULL, 1, 0, 0, 0, 0, 0, '12312312', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"124\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"12312312\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583239225\",\"updated\":\"1583239225\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-12\",\"duration\":\"8\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"11\",\"depends\":\"\",\"gant_sprint_weight\":\"51190628\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(9, 1, 123, NULL, NULL, 1, 0, 0, 0, 0, 0, 'swwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"123\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"swwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583239130\",\"updated\":\"1583239130\",\"start_date\":\"2020-03-04\",\"due_date\":\"2020-03-05\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"2\",\"depends\":\"\",\"gant_sprint_weight\":\"50493753\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(10, 1, 122, NULL, NULL, 1, 0, 0, 0, 0, 0, 'q121', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"122\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"q121\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583238861\",\"updated\":\"1583238861\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-06\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"121\",\"depends\":\"\",\"gant_sprint_weight\":\"51887503\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(11, 1, 121, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwwwwwwwwwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"121\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wwwwwwwwwwwwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583238818\",\"updated\":\"1583238818\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-06\",\"duration\":\"4\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"106\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"100\",\"depends\":\"\",\"gant_sprint_weight\":\"54675003\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583240168),
(12, 1, 138, NULL, NULL, 1, 0, 0, 0, 0, 0, '第三方胜多负少的', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"138\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"\\u7b2c\\u4e09\\u65b9\\u80dc\\u591a\\u8d1f\\u5c11\\u7684\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242243\",\"updated\":\"1583242243\",\"start_date\":\"2020-03-04\",\"due_date\":\"2020-03-11\",\"duration\":\"6\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"791622723\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(13, 1, 137, NULL, NULL, 1, 0, 0, 0, 0, 0, 'sdsdfsdfsd', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"137\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"sdsdfsdfsd\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242125\",\"updated\":\"1583242125\",\"start_date\":\"2020-03-10\",\"due_date\":\"2020-03-10\",\"duration\":\"1\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"797645446\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(14, 1, 136, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwwwwwwwwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"136\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wwwwwwwwwwwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583242107\",\"updated\":\"1583242107\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-12\",\"duration\":\"8\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"2\",\"depends\":\"\",\"gant_sprint_weight\":\"809690893\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(15, 1, 135, NULL, NULL, 1, 0, 0, 0, 0, 0, 'jsonxxx', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"135\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"jsonxxx\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583241918\",\"updated\":\"1583241918\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-14\",\"duration\":\"9\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"833781786\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(16, 1, 134, NULL, NULL, 1, 0, 0, 0, 0, 0, 'qqq121', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"134\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"qqq121\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583241885\",\"updated\":\"1583241885\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-12\",\"duration\":\"8\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"667563573\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(17, 1, 133, NULL, NULL, 1, 0, 0, 0, 0, 0, 'efsedfsdf', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"133\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"12165\",\"summary\":\"efsedfsdf\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583241695\",\"updated\":\"1583241695\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-12\",\"duration\":\"8\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"667563573\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(18, 1, 132, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wdfsefsdf', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"132\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wdfsefsdf\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583241554\",\"updated\":\"1583241554\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-13\",\"duration\":\"9\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"667563573\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(19, 1, 131, NULL, NULL, 1, 0, 0, 0, 0, 0, 'qqqqqqqq', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"131\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"qqqqqqqq\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583241157\",\"updated\":\"1583241157\",\"start_date\":\"2020-03-05\",\"due_date\":\"2020-03-13\",\"duration\":\"7\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"335127146\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(20, 1, 130, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"130\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wwwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583240740\",\"updated\":\"1583240740\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-05\",\"duration\":\"3\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"340708390\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(21, 1, 129, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwwwwwwwwwwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"129\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12167\",\"summary\":\"wwwwwwwwwwwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583240701\",\"updated\":\"1583240701\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-12\",\"duration\":\"8\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_sprint_weight\":\"348150049\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301),
(22, 1, 128, NULL, NULL, 1, 0, 0, 0, 0, 0, 'wwww', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":\"example\",\"issue_num\":\"128\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"1\",\"summary\":\"wwww\",\"description\":\"\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1583240650\",\"updated\":\"1583240650\",\"start_date\":\"2020-03-03\",\"due_date\":\"2020-03-04\",\"duration\":\"2\",\"resolve_date\":null,\"module\":\"2\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"1\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"1\",\"depends\":\"\",\"gant_sprint_weight\":\"363033367\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\",\"delete_user_id\":\"1\"}', 1583242301);

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
  `id` int(11) UNSIGNED NOT NULL,
  `sequence` int(11) UNSIGNED DEFAULT '0',
  `name` varchar(60) DEFAULT NULL,
  `_key` varchar(20) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `font_awesome` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0',
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
(446, 1, 1),
(447, 1, 2),
(448, 1, 3),
(449, 1, 4),
(450, 1, 5),
(468, 5, 3),
(469, 5, 4),
(470, 5, 5),
(471, 2, 1),
(472, 2, 2),
(473, 2, 3),
(474, 2, 4),
(475, 2, 6),
(476, 2, 7),
(477, 2, 8);

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
  `tab_id` int(11) UNSIGNED DEFAULT '0',
  `required` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否必填项'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_ui`
--

INSERT INTO `issue_ui` (`id`, `issue_type_id`, `ui_type`, `field_id`, `order_weight`, `tab_id`, `required`) VALUES
(205, 8, 'create', 1, 3, 0, 1),
(206, 8, 'create', 2, 2, 0, 0),
(207, 8, 'create', 3, 1, 0, 0),
(208, 8, 'create', 4, 0, 0, 0),
(209, 8, 'create', 5, 0, 2, 0),
(210, 8, 'create', 6, 3, 0, 0),
(211, 8, 'create', 7, 2, 0, 0),
(212, 8, 'create', 8, 1, 0, 0),
(213, 8, 'create', 9, 1, 0, 0),
(214, 8, 'create', 10, 0, 0, 0),
(215, 8, 'create', 11, 0, 0, 0),
(216, 8, 'create', 12, 0, 0, 0),
(217, 8, 'create', 13, 0, 0, 0),
(218, 8, 'create', 14, 0, 0, 0),
(219, 8, 'create', 15, 0, 0, 0),
(220, 8, 'create', 16, 0, 0, 0),
(221, 8, 'edit', 1, 3, 0, 1),
(222, 8, 'edit', 2, 2, 0, 0),
(223, 8, 'edit', 3, 1, 0, 0),
(224, 8, 'edit', 4, 0, 0, 0),
(225, 8, 'edit', 5, 0, 2, 0),
(226, 8, 'edit', 6, 3, 0, 0),
(227, 8, 'edit', 7, 2, 0, 0),
(228, 8, 'edit', 8, 1, 0, 0),
(229, 8, 'edit', 9, 1, 0, 0),
(230, 8, 'edit', 10, 0, 0, 0),
(231, 8, 'edit', 11, 0, 0, 0),
(232, 8, 'edit', 12, 0, 0, 0),
(233, 8, 'edit', 13, 0, 0, 0),
(234, 8, 'edit', 14, 0, 0, 0),
(235, 8, 'edit', 15, 0, 0, 0),
(236, 8, 'edit', 16, 0, 0, 0),
(422, 4, 'create', 1, 14, 0, 1),
(423, 4, 'create', 6, 13, 0, 0),
(424, 4, 'create', 2, 12, 0, 0),
(425, 4, 'create', 3, 11, 0, 0),
(426, 4, 'create', 7, 10, 0, 0),
(427, 4, 'create', 9, 9, 0, 0),
(428, 4, 'create', 8, 8, 0, 0),
(429, 4, 'create', 4, 7, 0, 0),
(430, 4, 'create', 19, 6, 0, 0),
(431, 4, 'create', 10, 5, 0, 0),
(432, 4, 'create', 11, 4, 0, 0),
(433, 4, 'create', 12, 3, 0, 0),
(434, 4, 'create', 13, 2, 0, 0),
(435, 4, 'create', 15, 1, 0, 0),
(436, 4, 'create', 20, 0, 0, 0),
(452, 5, 'create', 1, 14, 0, 1),
(453, 5, 'create', 6, 13, 0, 0),
(454, 5, 'create', 2, 12, 0, 0),
(455, 5, 'create', 7, 11, 0, 0),
(456, 5, 'create', 9, 10, 0, 0),
(457, 5, 'create', 8, 9, 0, 0),
(458, 5, 'create', 3, 8, 0, 0),
(459, 5, 'create', 4, 7, 0, 0),
(460, 5, 'create', 19, 6, 0, 0),
(461, 5, 'create', 10, 5, 0, 0),
(462, 5, 'create', 11, 4, 0, 0),
(463, 5, 'create', 12, 3, 0, 0),
(464, 5, 'create', 13, 2, 0, 0),
(465, 5, 'create', 15, 1, 0, 0),
(466, 5, 'create', 20, 0, 0, 0),
(467, 5, 'edit', 1, 14, 0, 1),
(468, 5, 'edit', 6, 13, 0, 0),
(469, 5, 'edit', 2, 12, 0, 0),
(470, 5, 'edit', 7, 11, 0, 0),
(471, 5, 'edit', 9, 10, 0, 0),
(472, 5, 'edit', 8, 9, 0, 0),
(473, 5, 'edit', 3, 8, 0, 0),
(474, 5, 'edit', 4, 7, 0, 0),
(475, 5, 'edit', 19, 6, 0, 0),
(476, 5, 'edit', 10, 5, 0, 0),
(477, 5, 'edit', 11, 4, 0, 0),
(478, 5, 'edit', 12, 3, 0, 0),
(479, 5, 'edit', 13, 2, 0, 0),
(480, 5, 'edit', 15, 1, 0, 0),
(481, 5, 'edit', 20, 0, 0, 0),
(587, 6, 'create', 1, 7, 0, 1),
(588, 6, 'create', 6, 6, 0, 0),
(589, 6, 'create', 2, 5, 0, 0),
(590, 6, 'create', 8, 4, 0, 0),
(591, 6, 'create', 11, 3, 0, 0),
(592, 6, 'create', 4, 2, 0, 0),
(593, 6, 'create', 21, 1, 0, 0),
(594, 6, 'create', 15, 0, 0, 0),
(595, 6, 'create', 19, 6, 33, 0),
(596, 6, 'create', 10, 5, 33, 0),
(597, 6, 'create', 7, 4, 33, 0),
(598, 6, 'create', 20, 3, 33, 0),
(599, 6, 'create', 9, 2, 33, 0),
(600, 6, 'create', 13, 1, 33, 0),
(601, 6, 'create', 12, 0, 33, 0),
(602, 6, 'edit', 1, 7, 0, 1),
(603, 6, 'edit', 6, 6, 0, 0),
(604, 6, 'edit', 2, 5, 0, 0),
(605, 6, 'edit', 8, 4, 0, 0),
(606, 6, 'edit', 4, 3, 0, 0),
(607, 6, 'edit', 11, 2, 0, 0),
(608, 6, 'edit', 15, 1, 0, 0),
(609, 6, 'edit', 21, 0, 0, 0),
(610, 6, 'edit', 19, 6, 34, 0),
(611, 6, 'edit', 10, 5, 34, 0),
(612, 6, 'edit', 7, 4, 34, 0),
(613, 6, 'edit', 20, 3, 34, 0),
(614, 6, 'edit', 9, 2, 34, 0),
(615, 6, 'edit', 12, 1, 34, 0),
(616, 6, 'edit', 13, 0, 34, 0),
(646, 7, 'create', 1, 7, 0, 1),
(647, 7, 'create', 6, 6, 0, 0),
(648, 7, 'create', 2, 5, 0, 0),
(649, 7, 'create', 8, 4, 0, 0),
(650, 7, 'create', 4, 3, 0, 0),
(651, 7, 'create', 11, 2, 0, 0),
(652, 7, 'create', 15, 1, 0, 0),
(653, 7, 'create', 21, 0, 0, 0),
(654, 7, 'create', 19, 6, 37, 0),
(655, 7, 'create', 10, 5, 37, 0),
(656, 7, 'create', 7, 4, 37, 0),
(657, 7, 'create', 20, 3, 37, 0),
(658, 7, 'create', 9, 2, 37, 0),
(659, 7, 'create', 13, 1, 37, 0),
(660, 7, 'create', 12, 0, 37, 0),
(1060, 9, 'create', 1, 4, 0, 1),
(1061, 9, 'create', 19, 3, 0, 0),
(1062, 9, 'create', 3, 2, 0, 0),
(1063, 9, 'create', 6, 1, 0, 0),
(1064, 9, 'create', 4, 0, 0, 0),
(1080, 7, 'edit', 1, 7, 0, 0),
(1081, 7, 'edit', 6, 6, 0, 0),
(1082, 7, 'edit', 2, 5, 0, 0),
(1083, 7, 'edit', 8, 4, 0, 0),
(1084, 7, 'edit', 4, 3, 0, 0),
(1085, 7, 'edit', 11, 2, 0, 0),
(1086, 7, 'edit', 15, 1, 0, 0),
(1087, 7, 'edit', 21, 0, 0, 0),
(1088, 7, 'edit', 19, 6, 63, 0),
(1089, 7, 'edit', 10, 5, 63, 0),
(1090, 7, 'edit', 7, 4, 63, 0),
(1091, 7, 'edit', 9, 3, 63, 0),
(1092, 7, 'edit', 20, 2, 63, 0),
(1093, 7, 'edit', 12, 1, 63, 0),
(1094, 7, 'edit', 13, 0, 63, 0),
(1095, 4, 'edit', 1, 11, 0, 0),
(1096, 4, 'edit', 6, 10, 0, 0),
(1097, 4, 'edit', 2, 9, 0, 0),
(1098, 4, 'edit', 7, 8, 0, 0),
(1099, 4, 'edit', 4, 7, 0, 0),
(1100, 4, 'edit', 19, 6, 0, 0),
(1101, 4, 'edit', 11, 5, 0, 0),
(1102, 4, 'edit', 12, 4, 0, 0),
(1103, 4, 'edit', 13, 3, 0, 0),
(1104, 4, 'edit', 15, 2, 0, 0),
(1105, 4, 'edit', 20, 1, 0, 0),
(1106, 4, 'edit', 21, 0, 0, 0),
(1107, 4, 'edit', 8, 3, 64, 0),
(1108, 4, 'edit', 9, 2, 64, 0),
(1109, 4, 'edit', 3, 1, 64, 0),
(1110, 4, 'edit', 10, 0, 64, 0),
(1414, 12, 'edit', 1, 8, 0, 1),
(1415, 12, 'edit', 4, 7, 0, 1),
(1416, 12, 'edit', 15, 6, 0, 1),
(1417, 12, 'edit', 12, 5, 0, 1),
(1418, 12, 'edit', 13, 4, 0, 1),
(1419, 12, 'edit', 27, 3, 0, 0),
(1420, 12, 'edit', 28, 2, 0, 0),
(1421, 12, 'edit', 29, 1, 0, 0),
(1422, 12, 'edit', 6, 0, 0, 0),
(1423, 12, 'create', 1, 8, 0, 1),
(1424, 12, 'create', 4, 7, 0, 1),
(1425, 12, 'create', 15, 6, 0, 1),
(1426, 12, 'create', 12, 5, 0, 1),
(1427, 12, 'create', 27, 4, 0, 0),
(1428, 12, 'create', 13, 3, 0, 1),
(1429, 12, 'create', 28, 2, 0, 0),
(1430, 12, 'create', 29, 1, 0, 0),
(1431, 12, 'create', 6, 0, 0, 0),
(1432, 2, 'create', 1, 10, 0, 1),
(1433, 2, 'create', 6, 9, 0, 0),
(1434, 2, 'create', 19, 8, 0, 0),
(1435, 2, 'create', 2, 7, 0, 0),
(1436, 2, 'create', 7, 6, 0, 0),
(1437, 2, 'create', 4, 5, 0, 0),
(1438, 2, 'create', 11, 4, 0, 0),
(1439, 2, 'create', 12, 3, 0, 0),
(1440, 2, 'create', 13, 2, 0, 0),
(1441, 2, 'create', 15, 1, 0, 0),
(1442, 2, 'create', 21, 0, 0, 0),
(1443, 2, 'create', 10, 4, 81, 0),
(1444, 2, 'create', 20, 3, 81, 0),
(1445, 2, 'create', 9, 2, 81, 0),
(1446, 2, 'create', 3, 1, 81, 0),
(1447, 2, 'create', 26, 0, 81, 0),
(1448, 2, 'edit', 1, 11, 0, 1),
(1449, 2, 'edit', 19, 10, 0, 0),
(1450, 2, 'edit', 10, 9, 0, 0),
(1451, 2, 'edit', 6, 8, 0, 0),
(1452, 2, 'edit', 2, 7, 0, 0),
(1453, 2, 'edit', 7, 6, 0, 0),
(1454, 2, 'edit', 4, 5, 0, 0),
(1455, 2, 'edit', 11, 4, 0, 0),
(1456, 2, 'edit', 12, 3, 0, 0),
(1457, 2, 'edit', 13, 2, 0, 0),
(1458, 2, 'edit', 15, 1, 0, 1),
(1459, 2, 'edit', 21, 0, 0, 0),
(1460, 2, 'edit', 20, 3, 82, 0),
(1461, 2, 'edit', 9, 2, 82, 0),
(1462, 2, 'edit', 3, 1, 82, 0),
(1463, 2, 'edit', 26, 0, 82, 0),
(1513, 1, 'edit', 1, 10, 0, 1),
(1514, 1, 'edit', 6, 9, 0, 0),
(1515, 1, 'edit', 2, 8, 0, 1),
(1516, 1, 'edit', 19, 7, 0, 0),
(1517, 1, 'edit', 10, 6, 0, 0),
(1518, 1, 'edit', 7, 5, 0, 0),
(1519, 1, 'edit', 4, 4, 0, 1),
(1520, 1, 'edit', 11, 3, 0, 0),
(1521, 1, 'edit', 12, 2, 0, 0),
(1522, 1, 'edit', 13, 1, 0, 0),
(1523, 1, 'edit', 15, 0, 0, 0),
(1524, 1, 'edit', 3, 5, 85, 0),
(1525, 1, 'edit', 18, 4, 85, 0),
(1526, 1, 'edit', 20, 3, 85, 0),
(1527, 1, 'edit', 21, 2, 85, 0),
(1528, 1, 'edit', 8, 1, 85, 0),
(1529, 1, 'edit', 9, 0, 85, 0),
(1530, 3, 'create', 1, 13, 0, 1),
(1531, 3, 'create', 6, 12, 0, 0),
(1532, 3, 'create', 2, 11, 0, 0),
(1533, 3, 'create', 7, 10, 0, 0),
(1534, 3, 'create', 8, 9, 0, 0),
(1535, 3, 'create', 3, 8, 0, 0),
(1536, 3, 'create', 4, 7, 0, 0),
(1537, 3, 'create', 19, 6, 0, 0),
(1538, 3, 'create', 10, 5, 0, 0),
(1539, 3, 'create', 11, 4, 0, 0),
(1540, 3, 'create', 12, 3, 0, 0),
(1541, 3, 'create', 13, 2, 0, 0),
(1542, 3, 'create', 20, 1, 0, 0),
(1543, 3, 'create', 15, 0, 0, 0),
(1544, 3, 'edit', 1, 15, 0, 1),
(1545, 3, 'edit', 6, 14, 0, 0),
(1546, 3, 'edit', 2, 13, 0, 0),
(1547, 3, 'edit', 7, 12, 0, 0),
(1548, 3, 'edit', 9, 11, 0, 0),
(1549, 3, 'edit', 8, 10, 0, 0),
(1550, 3, 'edit', 3, 9, 0, 0),
(1551, 3, 'edit', 4, 8, 0, 0),
(1552, 3, 'edit', 19, 7, 0, 0),
(1553, 3, 'edit', 10, 6, 0, 0),
(1554, 3, 'edit', 11, 5, 0, 0),
(1555, 3, 'edit', 12, 4, 0, 0),
(1556, 3, 'edit', 13, 3, 0, 0),
(1557, 3, 'edit', 20, 2, 0, 0),
(1558, 3, 'edit', 26, 1, 0, 0),
(1559, 3, 'edit', 15, 0, 0, 0),
(1560, 3, 'edit', 20, 2, 86, 0),
(1561, 3, 'edit', 9, 1, 86, 0),
(1562, 3, 'edit', 3, 0, 86, 0),
(1563, 1, 'create', 1, 8, 0, 1),
(1564, 1, 'create', 6, 7, 0, 0),
(1565, 1, 'create', 2, 6, 0, 1),
(1566, 1, 'create', 7, 5, 0, 0),
(1567, 1, 'create', 4, 4, 0, 1),
(1568, 1, 'create', 11, 3, 0, 0),
(1569, 1, 'create', 12, 2, 0, 0),
(1570, 1, 'create', 13, 1, 0, 0),
(1571, 1, 'create', 15, 0, 0, 0),
(1572, 1, 'create', 19, 7, 87, 0),
(1573, 1, 'create', 10, 6, 87, 0),
(1574, 1, 'create', 20, 5, 87, 0),
(1575, 1, 'create', 18, 4, 87, 0),
(1576, 1, 'create', 3, 3, 87, 0),
(1577, 1, 'create', 21, 2, 87, 0),
(1578, 1, 'create', 8, 1, 87, 0),
(1579, 1, 'create', 9, 0, 87, 0);

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
(63, 7, '\n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(64, 4, '\n            \n            \n            更多\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(81, 2, '更 多', 0, 'create'),
(82, 2, '\n            \n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             ', 0, 'edit'),
(85, 1, '\n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            ', 0, 'edit'),
(86, 3, '\n            \n            \n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(87, 1, '更 多', 0, 'create');

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
  `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容',
  `type` enum('agile','user','issue','issue_comment','org','project') DEFAULT 'issue' COMMENT 'project,issue,user,agile,issue_comment',
  `obj_id` int(11) UNSIGNED DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL COMMENT '相关的事项标题',
  `date` date DEFAULT NULL,
  `time` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_activity`
--

INSERT INTO `main_activity` (`id`, `user_id`, `project_id`, `action`, `content`, `type`, `obj_id`, `title`, `date`, `time`) VALUES
(1, 1, 1, '在 \"甘特图\" 模块中修改事项', '标题 变更为 <span style=\"color:#337ab7\"><span style=\"color:#337ab7\">产品模块开发编码1</span></span>', 'issue', 108, '产品模块开发', '2020-03-03', 1583242607),
(2, 1, 1, '在 \"甘特图\" 模块中修改事项', '标题 变更为 <span style=\"color:#337ab7\"><span style=\"color:#337ab7\">用户模块开发编码1</span></span>', 'issue', 107, '用户模块开发1', '2020-03-03', 1583242610),
(3, 1, 1, '创建了 #3 的子任务', '', 'issue', 139, '商城模块编码1', '2020-03-03', 1583242645),
(4, 1, 1, '创建了事项', '', 'issue', 139, '商城模块编码1', '2020-03-03', 1583242645);

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
(1, 'test-content-829016', 0, 1, 0);

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
('dict/label/getAll/0,*', 'dict/label', '2020-03-09 12:07:20', 1583726840),
('dict/sprint/getItemById/1', 'dict/sprint', '2020-03-08 22:17:06', 1583677026),
('dict/type_scheme/getAll/1,*', 'dict/type_scheme', '2020-03-09 00:32:56', 1583685176),
('setting/getSettingByKey/allow_user_reg', 'setting', '2020-03-08 18:48:50', 1583664530),
('setting/getSettingByKey/enable_mail', 'setting', '2020-03-08 22:06:54', 1583676414),
('setting/getSettingByKey/login_require_captcha', 'setting', '2020-03-08 18:48:49', 1583664529),
('setting/getSettingByKey/max_project_key', 'setting', '2020-03-10 20:02:46', 1583841766),
('setting/getSettingByKey/max_project_name', 'setting', '2020-03-10 20:02:46', 1583841766),
('setting/getSettingByKey/reg_require_captcha', 'setting', '2020-03-08 18:48:49', 1583664529),
('setting/getSettingRow/enable_async_mail', 'setting', '2020-03-08 22:06:54', 1583676414),
('setting/getSettingRow/enable_mail', 'setting', '2020-03-08 22:06:54', 1583676414),
('setting/getSettingRow/muchErrorTimesCaptcha', 'setting', '2020-03-08 18:48:51', 1583664531);

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
(5, 'ui-designers', 1, NULL, NULL, NULL, '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `main_mail_queue`
--

CREATE TABLE `main_mail_queue` (
  `id` int(10) UNSIGNED NOT NULL,
  `seq` varchar(32) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `create_time` int(11) UNSIGNED DEFAULT NULL,
  `error` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_mail_queue`
--

INSERT INTO `main_mail_queue` (`id`, `seq`, `title`, `address`, `status`, `create_time`, `error`) VALUES
(1, '1579249186992', '[default/example] 新增迭代 #1 1.0迭代', 'master@masterlab.vip;json@masterlab.vip;shelly@masterlab.vip;Alex@masterlab.vip;Max@masterlab.vip;sandy@masterlab.vip', 'error', 1579249187, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(2, '1579249719062', '[default/example] 事项创建 #example1 数据库设计', 'master@masterlab.vip;json@masterlab.vip', 'error', 1579249720, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(3, '1579250062050', '[default/example] 事项创建 #example2 服务器端开发框架设计', 'master@masterlab.vip;json@masterlab.vip', 'error', 1579250063, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(4, '1579250089575', '[default/example] 事项更新 #example2 服务器端开发框架设计', 'master@masterlab.vip;json@masterlab.vip', 'error', 1579250090, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(5, '1579423228667', '[default/example] 事项创建 #example3 UI设计', 'master@masterlab.vip;sandy@masterlab.vip', 'error', 1579423229, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(6, '1579423252856', '[default/example] 事项更新 #example3 UI设计', 'master@masterlab.vip;sandy@masterlab.vip', 'error', 1579423253, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(7, '1579423320068', '[default/example] 事项创建 #example4 测试用例', 'master@masterlab.vip;Alex@masterlab.vip', 'error', 1579423321, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(8, '1579423346324', '[default/example] 事项更新 #example4 测试用例', 'master@masterlab.vip;Alex@masterlab.vip', 'error', 1579423347, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n'),
(9, '1579423447160', '[default/example] 事项更新 #example4 测试用例', 'master@masterlab.vip;Alex@masterlab.vip', 'error', 1579423448, 'fsockopen failed:10061 由于目标计算机积极拒绝，无法连接。\r\n');

-- --------------------------------------------------------

--
-- 表的结构 `main_notify_scheme`
--

CREATE TABLE `main_notify_scheme` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
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
  `id` int(11) UNSIGNED NOT NULL,
  `scheme_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `flag` varchar(128) DEFAULT NULL,
  `user` varchar(1024) NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `main_notify_scheme_data`
--

INSERT INTO `main_notify_scheme_data` (`id`, `scheme_id`, `name`, `flag`, `user`) VALUES
(1, 1, '事项创建', 'issue@create', '[\"assigee\",\"reporter\",\"follow\"]'),
(2, 1, '事项更新', 'issue@update', '[\"assigee\",\"reporter\",\"follow\"]'),
(3, 1, '事项分配', 'issue@assign', '[\"assigee\",\"reporter\",\"follow\"]'),
(4, 1, '事项已解决', 'issue@resolve@complete', '[\"assigee\",\"reporter\",\"follow\"]'),
(5, 1, '事项已关闭', 'issue@close', '[\"assigee\",\"reporter\",\"follow\"]'),
(6, 1, '事项评论', 'issue@comment@create', '[\"assigee\",\"reporter\",\"follow\"]'),
(7, 1, '删除评论', 'issue@comment@remove', '[\"assigee\",\"reporter\",\"follow\"]'),
(8, 1, '开始解决事项', 'issue@resolve@start', '[\"assigee\",\"reporter\",\"follow\"]'),
(9, 1, '停止解决事项', 'issue@resolve@stop', '[\"assigee\",\"reporter\",\"follow\"]'),
(10, 1, '新增迭代', 'sprint@create', '[\"project\"]'),
(11, 1, '设置迭代进行时', 'sprint@start', '[\"project\"]'),
(12, 1, '删除迭代', 'sprint@remove', '[\"project\"]');

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
(1, 'default', 'Default', 'Default organization', 'org/default.jpg', 0, 0, 1535263464, 3);

-- --------------------------------------------------------

--
-- 表的结构 `main_setting`
--

CREATE TABLE `main_setting` (
  `id` int(11) NOT NULL,
  `_key` varchar(50) NOT NULL COMMENT '关键字',
  `title` varchar(20) NOT NULL COMMENT '标题',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块,basic,advance,ui,datetime,languge,attachment可选',
  `order_weight` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重',
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
(8, 'date_timezone', '默认用户时区', 'basic', 0, 'Asia/Shanghai', 'Asia/Shanghai', 'string', 'text', '[\"Asia/Shanghai\":\"\"]', ''),
(11, 'allow_share_public', '允许用户分享过滤器或面部', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(12, 'max_project_name', '项目名称最大长度', 'basic', 0, '80', '80', 'int', 'text', NULL, ''),
(13, 'max_project_key', '项目键值最大长度', 'basic', 0, '20', '20', 'int', 'text', NULL, ''),
(15, 'email_public', '邮件地址可见性', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(20, 'allow_gravatars', '允许使用Gravatars用户头像', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(21, 'gravatar_server', 'Gravatar服务器', 'basic', 0, '', '', 'string', 'text', NULL, ''),
(24, 'send_mail_format', '默认发送个邮件的格式', 'user_default', 0, 'html', 'text', 'string', 'radio', '{\"text\":\"text\",\"html\":\"html\"}', ''),
(25, 'issue_page_size', '问题导航每页显示的问题数量', 'user_default', 0, '100', '100', 'int', 'text', NULL, ''),
(39, 'time_format', '时间格式', 'datetime', 0, 'H:i:s', 'HH:mm:ss', 'string', 'text', NULL, '例如 11:55:47'),
(40, 'week_format', '星期格式', 'datetime', 0, 'l H:i:s', 'EEEE HH:mm:ss', 'string', 'text', NULL, '例如 Wednesday 11:55:47'),
(41, 'full_datetime_format', '完整日期/时间格式', 'datetime', 0, 'Y-m-d H:i:s', 'yyyy-MM-dd  HH:mm:ss', 'string', 'text', NULL, '例如 2007-05-23  11:55:47'),
(42, 'datetime_format', '日期格式(年月日)', 'datetime', 0, 'Y-m-d', 'yyyy-MM-dd', 'string', 'text', NULL, '例如 2007-05-23'),
(43, 'use_iso', '在日期选择器中使用 ISO8601 标准', 'datetime', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '打开这个选项，在日期选择器中，以星期一作为每周的开始第一天'),
(45, 'attachment_dir', '附件路径', 'attachment', 0, '{{PUBLIC_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下'),
(46, 'attachment_size', '附件大小(单位M)', 'attachment', 0, '128.0', '10.0', 'float', 'text', NULL, '超过大小,无法上传,修改该值后同时还要修改 php.ini 的 post_max_size 和 upload_max_filesize'),
(47, 'enbale_thum', '启用缩略图', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图'),
(48, 'enable_zip', '启用ZIP支持', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载'),
(49, 'password_strategy', '密码策略', 'password_strategy', 0, '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', ''),
(50, 'send_mailer', '发信人', 'mail', 0, 'xxxx@163.com', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 0, 'Masterlab', '', 'string', 'text', NULL, ''),
(52, 'mail_host', '主机', 'mail', 0, 'smtp.163.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', 0, '25', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 0, 'xxxx@163.com', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 0, 'xxxx', '', 'string', 'text', NULL, ''),
(56, 'mail_timeout', '发送超时', 'mail', 0, '20', '', 'int', 'text', NULL, ''),
(57, 'page_layout', '页面布局', 'user_default', 0, 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', ''),
(58, 'project_view', '项目首页', 'user_default', 0, 'sprints', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', ''),
(59, 'company', '公司名称', 'basic', 0, 'name', '', 'string', 'text', NULL, ''),
(60, 'company_logo', '公司logo', 'basic', 0, 'logo', '', 'string', 'text', NULL, ''),
(61, 'company_linkman', '联系人', 'basic', 0, '18002516775', '', 'string', 'text', NULL, ''),
(62, 'company_phone', '联系电话', 'basic', 0, '135255256541', '', 'string', 'text', NULL, ''),
(63, 'enable_async_mail', '是否使用异步方式发送邮件', 'mail', 0, '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(64, 'enable_mail', '是否开启邮件推送', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(70, 'socket_server_host', 'MasterlabSocket服务器地址', 'mail', 0, '127.0.0.1', '127.0.0.1', 'string', 'text', NULL, ''),
(71, 'socket_server_port', 'MasterlabSocket服务器端口', 'mail', 0, '9002', '9002', 'int', 'text', NULL, ''),
(72, 'allow_user_reg', '允许用户注册', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户');

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

-- --------------------------------------------------------

--
-- 表的结构 `main_widget`
--

CREATE TABLE `main_widget` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `name` varchar(255) DEFAULT NULL COMMENT '工具名称',
  `_key` varchar(64) NOT NULL,
  `method` varchar(64) NOT NULL DEFAULT '',
  `module` varchar(20) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `type` enum('list','chart_line','chart_pie','chart_bar','text') DEFAULT NULL COMMENT '工具类型',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态（1可用，0不可用）',
  `is_default` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `required_param` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否需要参数才能获取数据',
  `description` varchar(512) DEFAULT '' COMMENT '描述',
  `parameter` varchar(1024) NOT NULL DEFAULT '{}' COMMENT '支持的参数说明',
  `order_weight` int(10) UNSIGNED NOT NULL
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

-- --------------------------------------------------------

--
-- 表的结构 `mind_issue_attribute`
--

CREATE TABLE `mind_issue_attribute` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `issue_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `source` varchar(20) NOT NULL DEFAULT '',
  `group_by` varchar(20) NOT NULL DEFAULT '',
  `layout` varchar(20) NOT NULL DEFAULT '',
  `shape` varchar(20) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT '',
  `icon` varchar(64) NOT NULL DEFAULT '',
  `font_family` varchar(32) NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT '1',
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
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `layout` varchar(20) NOT NULL DEFAULT '',
  `shape` varchar(20) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT '',
  `icon` varchar(64) NOT NULL DEFAULT '',
  `font_family` varchar(32) NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT '1',
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
(4, 3, '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', '');

-- --------------------------------------------------------

--
-- 表的结构 `mind_second_attribute`
--

CREATE TABLE `mind_second_attribute` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `source` varchar(20) NOT NULL DEFAULT '',
  `group_by` varchar(20) NOT NULL DEFAULT '',
  `group_by_id` varchar(20) NOT NULL DEFAULT '',
  `layout` varchar(20) NOT NULL DEFAULT '',
  `shape` varchar(20) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT '',
  `icon` varchar(64) NOT NULL DEFAULT '',
  `font_family` varchar(32) NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT '1',
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
(131, 1, 'all', 'sprint', '0', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(136, 1, '1', 'module', '3', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(138, 1, 'all', 'sprint', '2', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(151, 1, 'all', 'sprint', '1', '', '', '', '', '', 1, 0, 0, '', '#000000', '');

-- --------------------------------------------------------

--
-- 表的结构 `mind_sprint_attribute`
--

CREATE TABLE `mind_sprint_attribute` (
  `id` int(11) UNSIGNED NOT NULL,
  `sprint_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `layout` varchar(20) NOT NULL DEFAULT '',
  `shape` varchar(20) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT '',
  `icon` varchar(64) NOT NULL DEFAULT '',
  `font_family` varchar(32) NOT NULL DEFAULT '',
  `font_size` tinyint(2) NOT NULL DEFAULT '1',
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
  `role_id` int(11) UNSIGNED DEFAULT NULL,
  `perm_id` int(11) UNSIGNED DEFAULT NULL
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
(86, 10006, 10906);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global`
--

CREATE TABLE `permission_global` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT '0',
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
  `id` int(11) UNSIGNED NOT NULL,
  `perm_global_id` int(11) UNSIGNED DEFAULT NULL,
  `group_id` int(11) UNSIGNED DEFAULT NULL
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
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否是默认角色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permission_global_role`
--

INSERT INTO `permission_global_role` (`id`, `name`, `description`, `is_system`) VALUES
(1, '超级管理员', NULL, 1),
(2, '系统设置管理员', NULL, 0),
(3, '项目管理员', NULL, 0),
(4, '用户管理员', NULL, 0),
(5, '事项设置管理员', NULL, 0),
(6, '组织管理员', NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_role_relation`
--

CREATE TABLE `permission_global_role_relation` (
  `id` int(11) UNSIGNED NOT NULL,
  `perm_global_id` int(11) UNSIGNED DEFAULT NULL,
  `role_id` int(11) UNSIGNED DEFAULT NULL,
  `is_system` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否系统自带'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组拥有的全局权限';

--
-- 转存表中的数据 `permission_global_role_relation`
--

INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES
(2, 1, 1, 1),
(8, 2, 1, 1),
(9, 3, 1, 1),
(10, 4, 1, 1),
(11, 5, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `permission_global_user_role`
--

CREATE TABLE `permission_global_user_role` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT '0',
  `role_id` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `permission_global_user_role`
--

INSERT INTO `permission_global_user_role` (`id`, `user_id`, `role_id`) VALUES
(5613, 1, 1);

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
(1, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1579402711),
(2, 1, 'sprint_1_weight', '{\"2\":400000,\"1\":300000,\"4\":200000,\"3\":100000}', 1581166410),
(3, 1, 'sprint_1_weight', '{\"2\":500000,\"1\":400000,\"4\":300000,\"3\":200000,\"5\":100000}', 1581950857),
(4, 1, 'sprint_1_weight', '{\"2\":500000,\"1\":400000,\"4\":300000,\"3\":200000,\"5\":100000}', 1582045273),
(5, 1, 'sprint_1_weight', '{\"2\":500000,\"1\":400000,\"4\":300000,\"3\":200000,\"5\":100000}', 1582045294),
(6, 1, 'sprint_1_weight', '{\"2\":500000,\"1\":400000,\"4\":300000,\"3\":200000,\"5\":100000}', 1582045323),
(7, 1, 'sprint_1_weight', '{\"2\":500000,\"1\":400000,\"4\":300000,\"3\":200000,\"5\":100000}', 1582125927),
(8, 1, 'sprint_1_weight', '{\"2\":500000,\"1\":400000,\"4\":300000,\"3\":200000,\"5\":100000}', 1582134522),
(9, 1, 'sprint_1_weight', '{\"2\":800000,\"1\":700000,\"4\":600000,\"3\":500000,\"5\":400000,\"7\":300000,\"9\":200000,\"8\":100000}', 1582278961),
(10, 1, 'sprint_1_weight', '{\"2\":800000,\"1\":700000,\"4\":600000,\"3\":500000,\"5\":400000,\"7\":300000,\"9\":200000,\"8\":100000}', 1582308527),
(11, 1, 'sprint_1_weight', '{\"2\":800000,\"1\":700000,\"4\":600000,\"3\":500000,\"5\":400000,\"7\":300000,\"9\":200000,\"8\":100000}', 1582309060),
(12, 1, 'sprint_1_weight', '{\"2\":800000,\"1\":700000,\"4\":600000,\"3\":500000,\"5\":400000,\"7\":300000,\"9\":200000,\"8\":100000}', 1582317236),
(13, 1, 'backlog_weight', '{\"31\":2400000,\"27\":2300000,\"23\":2200000,\"19\":2100000,\"15\":2000000,\"11\":1900000,\"32\":1800000,\"28\":1700000,\"24\":1600000,\"20\":1500000,\"16\":1400000,\"12\":1300000,\"33\":1200000,\"29\":1100000,\"25\":1000000,\"21\":900000,\"17\":800000,\"13\":700000,\"34\":600000,\"30\":500000,\"26\":400000,\"22\":300000,\"18\":200000,\"14\":100000}', 1582456627),
(14, 1, 'sprint_1_weight', '{\"2\":900000,\"1\":800000,\"4\":700000,\"3\":600000,\"5\":500000,\"7\":400000,\"9\":300000,\"8\":200000,\"10\":100000}', 1582456633),
(15, 1, 'sprint_1_weight', '{\"2\":1000000,\"1\":900000,\"4\":800000,\"3\":700000,\"5\":600000,\"7\":500000,\"9\":400000,\"8\":300000,\"10\":200000,\"35\":100000}', 1582518179),
(16, 1, 'sprint_2_weight', '{\"6\":100000}', 1582518184),
(17, 1, 'sprint_1_weight', '{\"2\":1000000,\"1\":900000,\"4\":800000,\"3\":700000,\"5\":600000,\"7\":500000,\"9\":400000,\"8\":300000,\"10\":200000,\"35\":100000}', 1582518185),
(18, 1, 'sprint_1_weight', '{\"2\":1000000,\"1\":900000,\"4\":800000,\"3\":700000,\"5\":600000,\"7\":500000,\"9\":400000,\"8\":300000,\"10\":200000,\"35\":100000}', 1582518417),
(19, 1, 'sprint_1_weight', '{\"2\":1900000,\"1\":1800000,\"4\":1700000,\"3\":1600000,\"5\":1500000,\"8\":1400000,\"94\":1300000,\"116\":1200000,\"109\":1100000,\"108\":1000000,\"107\":900000,\"106\":800000,\"97\":700000,\"96\":600000,\"95\":500000,\"90\":400000,\"87\":300000,\"64\":200000,\"54\":100000}', 1583072226);

-- --------------------------------------------------------

--
-- 表的结构 `project_gantt_setting`
--

CREATE TABLE `project_gantt_setting` (
  `id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL,
  `source_type` varchar(20) DEFAULT NULL COMMENT 'project,active_sprint',
  `source_from` varchar(20) DEFAULT NULL,
  `is_display_backlog` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在甘特图中显示待办事项',
  `hide_issue_types` varchar(100) NOT NULL DEFAULT '' COMMENT '要隐藏的事项类型key以逗号分隔'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `project_gantt_setting`
--

INSERT INTO `project_gantt_setting` (`id`, `project_id`, `source_type`, `source_from`, `is_display_backlog`, `hide_issue_types`) VALUES
(1, 1, 'project', NULL, 1, 'bug,gantt'),
(2, 3, 'project', NULL, 0, ''),
(3, 2, 'project', NULL, 0, ''),
(4, 11, 'project', NULL, 0, ''),
(5, 6, 'project', NULL, 0, '');

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
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6);

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
  `bg_color` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `closed_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `archived` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '已归档',
  `issue_update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '事项最新更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `project_main`
--

INSERT INTO `project_main` (`id`, `org_id`, `org_path`, `name`, `url`, `lead`, `description`, `key`, `pcounter`, `default_assignee`, `assignee_type`, `avatar`, `category`, `type`, `type_child`, `permission_scheme_id`, `workflow_scheme_id`, `create_uid`, `create_time`, `un_done_count`, `done_count`, `closed_count`, `archived`, `issue_update_time`) VALUES
(1, 1, 'default', '示例项目', '', 1, 'Masterlab的示例项目', 'example', NULL, 1, NULL, 'project/avatar/1.jpg', 0, 10, 0, 0, 0, 1, 1579247230, 0, 0, 0, 'N', 1583220515),
(2, 1, 'default', 'CRM示例项目', '', 1, '一个Crm的示例项目', 'crm', NULL, 1, NULL, 'project/avatar/2.jpg', 0, 10, 0, 0, 0, 1, 1582543422, 0, 0, 0, 'N', 1582543422),
(6, 1, 'default', 'Ai城市', '', 1, '', 'ai', NULL, 1, NULL, '', 0, 10, 0, 0, 0, 1, 1582685396, 0, 0, 0, 'N', 1582685396);

-- --------------------------------------------------------

--
-- 表的结构 `project_main_extra`
--

CREATE TABLE `project_main_extra` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT '0',
  `detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 转存表中的数据 `project_main_extra`
--

INSERT INTO `project_main_extra` (`id`, `project_id`, `detail`) VALUES
(1, 1, '该项目展示了，如何将敏捷开发和Masterlab结合在一起.\r\n'),
(2, 2, ''),
(3, 3, ''),
(4, 4, ''),
(5, 5, ''),
(6, 6, '');

-- --------------------------------------------------------

--
-- 表的结构 `project_mind_setting`
--

CREATE TABLE `project_mind_setting` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `setting_key` varchar(32) NOT NULL,
  `setting_value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_mind_setting`
--

INSERT INTO `project_mind_setting` (`id`, `project_id`, `setting_key`, `setting_value`) VALUES
(14, 3, 'default_source_id', ''),
(15, 3, 'fold_count', '16'),
(16, 3, 'default_source', 'sprint'),
(17, 3, 'is_display_label', '1'),
(23, 1, 'is_display_label', '1'),
(147, 1, 'fold_count', '30'),
(148, 1, 'default_source', 'all'),
(149, 1, 'is_display_assignee', '1'),
(150, 1, 'is_display_priority', '0'),
(151, 1, 'is_display_status', '1'),
(152, 1, 'is_display_type', '0'),
(153, 1, 'is_display_progress', '1'),
(154, 1, 'default_source_id', '');

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
  `ctime` int(10) UNSIGNED DEFAULT '0',
  `order_weight` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `project_module`
--

INSERT INTO `project_module` (`id`, `project_id`, `name`, `description`, `lead`, `default_assignee`, `ctime`, `order_weight`) VALUES
(1, 1, '后端架构', '', 0, 0, 1579249107, 0),
(2, 1, '前端架构', '', 0, 0, 1579249118, 0),
(3, 1, '用户', '', 0, 0, 1579249127, 0),
(4, 1, '首页', '', 0, 0, 1579249131, 0),
(5, 1, '引擎', '', 0, 0, 1579249144, 0),
(6, 1, '测试', '', 0, 0, 1579423336, 0);

-- --------------------------------------------------------

--
-- 表的结构 `project_permission`
--

CREATE TABLE `project_permission` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT '0',
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
(10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL');

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
(1, 1, 'Users', '普通用户', 1),
(2, 1, 'Developers', '开发者,如程序员，架构师', 1),
(3, 1, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(4, 1, 'QA', '测试工程师', 1),
(5, 1, 'PO', '产品经理，产品负责人', 1),
(7, 2, 'Users', '普通用户', 1),
(8, 2, 'Developers', '开发者,如程序员，架构师', 1),
(9, 2, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(10, 2, 'QA', '测试工程师', 1),
(11, 2, 'PO', '产品经理，产品负责人', 1),
(12, 3, 'Users', '普通用户', 1),
(13, 3, 'Developers', '开发者,如程序员，架构师', 1),
(14, 3, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(15, 3, 'QA', '测试工程师', 1),
(16, 3, 'PO', '产品经理，产品负责人', 1),
(17, 4, 'Users', '普通用户', 1),
(18, 4, 'Developers', '开发者,如程序员，架构师', 1),
(19, 4, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(20, 4, 'QA', '测试工程师', 1),
(21, 4, 'PO', '产品经理，产品负责人', 1),
(22, 5, 'Users', '普通用户', 1),
(23, 5, 'Developers', '开发者,如程序员，架构师', 1),
(24, 5, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(25, 5, 'QA', '测试工程师', 1),
(26, 5, 'PO', '产品经理，产品负责人', 1),
(27, 6, 'Users', '普通用户', 1),
(28, 6, 'Developers', '开发者,如程序员，架构师', 1),
(29, 6, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(30, 6, 'QA', '测试工程师', 1),
(31, 6, 'PO', '产品经理，产品负责人', 1);

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
(38, 1, 2, 10005),
(39, 1, 2, 10006),
(40, 1, 2, 10007),
(41, 1, 2, 10008),
(42, 1, 2, 10013),
(43, 1, 2, 10014),
(44, 1, 2, 10015),
(45, 1, 2, 10016),
(46, 1, 2, 10017),
(47, 1, 2, 10028),
(48, 1, 3, 10004),
(49, 1, 3, 10005),
(50, 1, 3, 10006),
(51, 1, 3, 10007),
(52, 1, 3, 10008),
(53, 1, 3, 10013),
(54, 1, 3, 10014),
(55, 1, 3, 10015),
(56, 1, 3, 10016),
(57, 1, 3, 10017),
(58, 1, 3, 10028),
(59, 1, 3, 10902),
(60, 1, 3, 10903),
(61, 1, 3, 10904),
(62, 1, 3, 10905),
(63, 1, 3, 10906),
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
(64, 2, 7, 10005),
(65, 2, 7, 10006),
(66, 2, 7, 10007),
(67, 2, 7, 10008),
(68, 2, 7, 10013),
(69, 2, 8, 10005),
(70, 2, 8, 10006),
(71, 2, 8, 10007),
(72, 2, 8, 10008),
(73, 2, 8, 10013),
(74, 2, 8, 10014),
(75, 2, 8, 10015),
(76, 2, 8, 10028),
(77, 2, 9, 10004),
(78, 2, 9, 10005),
(79, 2, 9, 10006),
(80, 2, 9, 10007),
(81, 2, 9, 10008),
(82, 2, 9, 10013),
(83, 2, 9, 10014),
(84, 2, 9, 10015),
(85, 2, 9, 10028),
(86, 2, 9, 10902),
(87, 2, 9, 10903),
(88, 2, 9, 10904),
(89, 2, 11, 10004),
(90, 2, 11, 10005),
(91, 2, 11, 10006),
(92, 2, 11, 10007),
(93, 2, 11, 10008),
(94, 2, 11, 10013),
(95, 2, 11, 10014),
(96, 2, 11, 10015),
(97, 2, 11, 10028),
(98, 2, 11, 10902),
(99, 2, 11, 10903),
(100, 2, 11, 10904),
(101, 3, 12, 10005),
(102, 3, 12, 10006),
(103, 3, 12, 10007),
(104, 3, 12, 10008),
(105, 3, 12, 10013),
(106, 3, 13, 10005),
(107, 3, 13, 10006),
(108, 3, 13, 10007),
(109, 3, 13, 10008),
(110, 3, 13, 10013),
(111, 3, 13, 10014),
(112, 3, 13, 10015),
(113, 3, 13, 10028),
(114, 3, 14, 10004),
(115, 3, 14, 10005),
(116, 3, 14, 10006),
(117, 3, 14, 10007),
(118, 3, 14, 10008),
(119, 3, 14, 10013),
(120, 3, 14, 10014),
(121, 3, 14, 10015),
(122, 3, 14, 10028),
(123, 3, 14, 10902),
(124, 3, 14, 10903),
(125, 3, 14, 10904),
(126, 3, 16, 10004),
(127, 3, 16, 10005),
(128, 3, 16, 10006),
(129, 3, 16, 10007),
(130, 3, 16, 10008),
(131, 3, 16, 10013),
(132, 3, 16, 10014),
(133, 3, 16, 10015),
(134, 3, 16, 10028),
(135, 3, 16, 10902),
(136, 3, 16, 10903),
(137, 3, 16, 10904),
(138, 4, 17, 10005),
(139, 4, 17, 10006),
(140, 4, 17, 10007),
(141, 4, 17, 10008),
(142, 4, 17, 10013),
(143, 4, 18, 10005),
(144, 4, 18, 10006),
(145, 4, 18, 10007),
(146, 4, 18, 10008),
(147, 4, 18, 10013),
(148, 4, 18, 10014),
(149, 4, 18, 10015),
(151, 4, 18, 10016),
(150, 4, 18, 10028),
(152, 4, 19, 10004),
(153, 4, 19, 10005),
(154, 4, 19, 10006),
(155, 4, 19, 10007),
(156, 4, 19, 10008),
(157, 4, 19, 10013),
(158, 4, 19, 10014),
(159, 4, 19, 10015),
(164, 4, 19, 10016),
(165, 4, 19, 10017),
(160, 4, 19, 10028),
(161, 4, 19, 10902),
(162, 4, 19, 10903),
(163, 4, 19, 10904),
(166, 4, 19, 10905),
(167, 4, 19, 10906),
(168, 4, 20, 10017),
(169, 4, 20, 10905),
(170, 4, 20, 10906),
(171, 4, 21, 10004),
(172, 4, 21, 10005),
(173, 4, 21, 10006),
(174, 4, 21, 10007),
(175, 4, 21, 10008),
(176, 4, 21, 10013),
(177, 4, 21, 10014),
(178, 4, 21, 10015),
(186, 4, 21, 10016),
(183, 4, 21, 10017),
(179, 4, 21, 10028),
(180, 4, 21, 10902),
(181, 4, 21, 10903),
(182, 4, 21, 10904),
(184, 4, 21, 10905),
(185, 4, 21, 10906),
(187, 5, 22, 10005),
(188, 5, 22, 10006),
(189, 5, 22, 10007),
(190, 5, 22, 10008),
(191, 5, 22, 10013),
(192, 5, 23, 10005),
(193, 5, 23, 10006),
(194, 5, 23, 10007),
(195, 5, 23, 10008),
(196, 5, 23, 10013),
(197, 5, 23, 10014),
(198, 5, 23, 10015),
(200, 5, 23, 10016),
(199, 5, 23, 10028),
(201, 5, 24, 10004),
(202, 5, 24, 10005),
(203, 5, 24, 10006),
(204, 5, 24, 10007),
(205, 5, 24, 10008),
(206, 5, 24, 10013),
(207, 5, 24, 10014),
(208, 5, 24, 10015),
(213, 5, 24, 10016),
(214, 5, 24, 10017),
(209, 5, 24, 10028),
(210, 5, 24, 10902),
(211, 5, 24, 10903),
(212, 5, 24, 10904),
(215, 5, 24, 10905),
(216, 5, 24, 10906),
(217, 5, 25, 10005),
(218, 5, 25, 10006),
(219, 5, 25, 10007),
(220, 5, 25, 10008),
(221, 5, 25, 10013),
(222, 5, 25, 10014),
(223, 5, 25, 10015),
(225, 5, 25, 10017),
(224, 5, 25, 10028),
(226, 5, 26, 10004),
(227, 5, 26, 10005),
(228, 5, 26, 10006),
(229, 5, 26, 10007),
(230, 5, 26, 10008),
(231, 5, 26, 10013),
(232, 5, 26, 10014),
(233, 5, 26, 10015),
(241, 5, 26, 10016),
(238, 5, 26, 10017),
(234, 5, 26, 10028),
(235, 5, 26, 10902),
(236, 5, 26, 10903),
(237, 5, 26, 10904),
(239, 5, 26, 10905),
(240, 5, 26, 10906),
(242, 6, 27, 10005),
(243, 6, 27, 10006),
(244, 6, 27, 10007),
(245, 6, 27, 10008),
(246, 6, 27, 10013),
(247, 6, 28, 10005),
(248, 6, 28, 10006),
(249, 6, 28, 10007),
(250, 6, 28, 10008),
(251, 6, 28, 10013),
(252, 6, 28, 10014),
(253, 6, 28, 10015),
(255, 6, 28, 10016),
(254, 6, 28, 10028),
(256, 6, 29, 10004),
(257, 6, 29, 10005),
(258, 6, 29, 10006),
(259, 6, 29, 10007),
(260, 6, 29, 10008),
(261, 6, 29, 10013),
(262, 6, 29, 10014),
(263, 6, 29, 10015),
(268, 6, 29, 10016),
(269, 6, 29, 10017),
(264, 6, 29, 10028),
(265, 6, 29, 10902),
(266, 6, 29, 10903),
(267, 6, 29, 10904),
(270, 6, 29, 10905),
(271, 6, 29, 10906),
(272, 6, 30, 10005),
(273, 6, 30, 10006),
(274, 6, 30, 10007),
(275, 6, 30, 10008),
(276, 6, 30, 10013),
(277, 6, 30, 10014),
(278, 6, 30, 10015),
(280, 6, 30, 10017),
(279, 6, 30, 10028),
(281, 6, 31, 10004),
(282, 6, 31, 10005),
(283, 6, 31, 10006),
(284, 6, 31, 10007),
(285, 6, 31, 10008),
(286, 6, 31, 10013),
(287, 6, 31, 10014),
(288, 6, 31, 10015),
(296, 6, 31, 10016),
(293, 6, 31, 10017),
(289, 6, 31, 10028),
(290, 6, 31, 10902),
(291, 6, 31, 10903),
(292, 6, 31, 10904),
(294, 6, 31, 10905),
(295, 6, 31, 10906);

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
(3, 1, 1, 2),
(4, 1, 1, 3),
(10, 1, 2, 9),
(11, 1, 3, 14),
(12, 1, 4, 19),
(13, 1, 5, 24),
(14, 1, 6, 29),
(5, 12164, 1, 2),
(6, 12165, 1, 2),
(8, 12166, 1, 5),
(7, 12167, 1, 2),
(9, 12168, 1, 2);

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
(1, 'ssss', '121642038@qq.com', 12169, 'XZ9OHL0YVVM2IJ37E4X5WZPIL5GTAJ0X', 1581320843);

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
(1, 0, 1),
(2, 1, 1);

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

-- --------------------------------------------------------

--
-- 表的结构 `user_issue_display_fields`
--

CREATE TABLE `user_issue_display_fields` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `fields` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_issue_display_fields`
--

INSERT INTO `user_issue_display_fields` (`id`, `user_id`, `project_id`, `fields`) VALUES
(13, 1, 3, 'issue_num,issue_type,priority,module,sprint,summary,assignee,status,plan_date'),
(16, 1, 0, 'issue_num,issue_type,priority,project_id,module,summary,assignee,status,resolve,plan_date'),
(17, 1, 1, 'issue_num,issue_type,priority,module,sprint,summary,assignee,status,resolve,plan_date');

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
(1, '0951coc1r7puv103kkmoidnv1b', '', 1, 1583048654, '127.0.0.1'),
(2, 'b094qaal1avvgh8ftndbuvvki4', '', 1, 1583059731, '127.0.0.1'),
(3, 'vajcd9307akv6or2djoqnaj21p', '', 1, 1583065822, '127.0.0.1'),
(4, '09cnt7dkc1j01rgmmalit1fjps', '', 1, 1583071552, '127.0.0.1'),
(5, '09qa6c7pu6u0u4obegfdj8usoq', '', 1, 1583122016, '127.0.0.1'),
(6, 'gv92q5mq9d9tmtltjhuv2s5bvl', '', 1, 1583146506, '127.0.0.1'),
(7, 'pvp0je9176sfovc21v6b4mjiv3', '', 1, 1583207929, '127.0.0.1'),
(8, 'lfrnns2g07oqlodsq0ih7uinnd', '', 1, 1583219322, '127.0.0.1'),
(9, 'bht3h9qpcem1fbf8iau7qeebp5', '', 1, 1583231365, '127.0.0.1');

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
(1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', 'master@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '2019-01-13', 0, 0, 'avatar/1.png?t=1579249493', '', NULL, NULL, NULL, NULL, 1583231364, 0, 0, '管理员', '简化项目管理，保障结果，快乐团队！'),
(12164, NULL, NULL, 'json', '87655dd189dc13a7eb36f62a3a8eed4c', 1, NULL, NULL, 'Json', 'json@masterlab.vip', '$2y$10$hW2HeFe4kUO/IDxGW5A68e7r.sERM6.VtP3VrYLXeyHVb0ZjXo2Sm', 0, NULL, 1579247721, 0, 'avatar/12164.png?t=1579247721', '', NULL, NULL, NULL, '', 0, 0, 0, 'Java开发工程师', NULL),
(12165, NULL, NULL, 'shelly', '74eb77b447ad46f0ba76dba8de3e8489', 1, NULL, NULL, 'Shelly', 'shelly@masterlab.vip', '$2y$10$RXindYr74f9I1GyaGtovE.KgD6pgcjE6Z9SZyqLO9UykzImG6n2kS', 0, NULL, 1579247769, 0, 'avatar/12165.png?t=1579247769', '', NULL, NULL, NULL, '', 0, 0, 0, '软件测试工程师', NULL),
(12166, NULL, NULL, 'alex', '22778739b6553330c4f9e8a29d0e1d5f', 1, NULL, NULL, 'Alex', 'Alex@masterlab.vip', '$2y$10$ENToGF7kfUrXm0i6DISJ6utmjq076tSCaVuEyeqQRdQocgUwxZKZ6', 0, NULL, 1579247886, 0, 'avatar/12166.png?t=1579247886', '', NULL, NULL, NULL, '', 0, 0, 0, '产品经理', NULL),
(12167, NULL, NULL, 'max', '9b0e7dc465b9398c2e270e6da415341c', 1, NULL, NULL, 'Max', 'Max@masterlab.vip', '$2y$10$qbv7OEhHuFQFmC4zJK50T.CDN7alvBaSf2FfqCXwSwcaC3FojM0GS', 0, NULL, 1579247926, 0, 'avatar/12167.png?t=1579247926', '', NULL, NULL, NULL, '', 0, 0, 0, '前端开发工程师', NULL),
(12168, NULL, NULL, 'sandy', '322436f4d5a63425e7973a5406b13057', 1, NULL, NULL, 'Sandy', 'sandy@masterlab.vip', '$2y$10$9Y0SadlCrjBKGJtniCG/OepxWnAkfdo4e9iUzXz/6hWWQjFfVzyGK', 0, NULL, 1579247959, 0, 'avatar/12168.png?t=1582043474', '', NULL, NULL, NULL, '', 0, 0, 0, 'UI设计师', NULL),
(12170, NULL, NULL, 'moxao', 'ca78502344a2ca38a80f4fcc77917534', 1, NULL, NULL, 'moxao', 'moxao@vip.qq.com', '$2y$10$eWWFeZAXwrlBYQxAxl85TuzxPdNi2p5jsg2hbX317Sx1HQAQR3Rm2', 0, NULL, 1582044202, 0, 'avatar/12170.png?t=1582044202', '', NULL, NULL, NULL, '', 0, 0, 0, 'gaga', NULL);

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
-- 表的结构 `user_posted_flag`
--

CREATE TABLE `user_posted_flag` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `_date` date NOT NULL,
  `ip` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_posted_flag`
--

INSERT INTO `user_posted_flag` (`id`, `user_id`, `_date`, `ip`) VALUES
(1, 0, '2020-02-25', '127.0.0.1'),
(5, 0, '2020-02-26', '192.168.0.103'),
(6, 0, '2020-02-27', '127.0.0.1'),
(9, 0, '2020-03-01', '127.0.0.1'),
(13, 0, '2020-03-02', '127.0.0.1'),
(15, 0, '2020-03-03', '127.0.0.1'),
(2, 1, '2020-02-25', '127.0.0.1'),
(4, 1, '2020-02-26', '127.0.0.1'),
(7, 1, '2020-02-27', '127.0.0.1'),
(8, 1, '2020-02-29', '127.0.0.1'),
(10, 1, '2020-03-01', '127.0.0.1'),
(11, 1, '2020-03-02', '127.0.0.1'),
(16, 1, '2020-03-03', '127.0.0.1');

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
(51, 1, 'scheme_style', 'left'),
(53, 1, 'project_view', 'issues'),
(54, 1, 'issue_view', 'list'),
(198, 1, 'initializedWidget', '1'),
(201, 1, 'initialized_widget', '1'),
(353, 1, 'page_layout', 'fixed'),
(516, 1, 'projects_sort', 'latest_activity_desc'),
(519, 1, 'layout', 'aaa');

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
(1, 1, 'fe62072d1358fe1f112fe38e339113b5bb4687e7cbf8caa88136df0459eda706', 1583231365, 'b4895a1e9f77c6e09cafb9a2b021de9f5b3eb0f3d2246b922f5b1a7759aa70a4', 1583231365);

-- --------------------------------------------------------

--
-- 表的结构 `user_widget`
--

CREATE TABLE `user_widget` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `widget_id` int(11) NOT NULL COMMENT 'main_widget主键id',
  `order_weight` int(11) UNSIGNED DEFAULT NULL COMMENT '工具顺序',
  `panel` varchar(40) NOT NULL,
  `parameter` varchar(1024) NOT NULL,
  `is_saved_parameter` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否保存了过滤参数'
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
(2447, 1, 1, 1, 'first', '', 0),
(2448, 1, 23, 2, 'first', '', 0),
(2449, 1, 24, 3, 'first', '', 0),
(2450, 1, 14, 1, 'second', '[{\"name\":\"sprint_id\",\"value\":\"1\"}]', 1),
(2451, 1, 15, 2, 'second', '[{\"name\":\"sprint_id\",\"value\":\"1\"}]', 1),
(2452, 1, 12, 3, 'second', '[{\"name\":\"project_id\",\"value\":\"1\"},{\"name\":\"data_field\",\"value\":\"assignee\"},{\"name\":\"start_date\",\"value\":\"\"},{\"name\":\"end_date\",\"value\":\"\"}]', 1),
(2453, 1, 3, 1, 'third', '', 0);

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
(1, '默认状态流', '', 1, 0, NULL, 1582439359, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":469,\"positionY\":19,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":442,\"positionY\":142,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":755,\"positionY\":136,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":463,\"positionY\":457,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":303,\"positionY\":252,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_122\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(2, '软件开发状态流', '针对软件开发的过程状态流', 1, NULL, NULL, 1529647857, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(3, 'Task状态流', '', 1, NULL, NULL, 1539675552, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);

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
(1, '默认状态流方案', '', 1),
(10100, '敏捷开发状态流方案', '敏捷开发适用', 1),
(10101, '普通的软件开发状态流方案', '', 1),
(10102, '流程管理状态流方案', '', 1);

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
  ADD KEY `sprint_weight` (`sprint_weight`),
  ADD KEY `status` (`status`),
  ADD KEY `gant_sprint_weight` (`gant_sprint_weight`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `agile_board_column`
--
ALTER TABLE `agile_board_column`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- 使用表AUTO_INCREMENT `agile_sprint`
--
ALTER TABLE `agile_sprint`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_custom_value`
--
ALTER TABLE `field_custom_value`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_main`
--
ALTER TABLE `field_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- 使用表AUTO_INCREMENT `field_type`
--
ALTER TABLE `field_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用表AUTO_INCREMENT `hornet_user`
--
ALTER TABLE `hornet_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_assistant`
--
ALTER TABLE `issue_assistant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_description_template`
--
ALTER TABLE `issue_description_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `issue_effect_version`
--
ALTER TABLE `issue_effect_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_extra_worker_day`
--
ALTER TABLE `issue_extra_worker_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_follow`
--
ALTER TABLE `issue_follow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `issue_holiday`
--
ALTER TABLE `issue_holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=626;

--
-- 使用表AUTO_INCREMENT `issue_label`
--
ALTER TABLE `issue_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `issue_label_data`
--
ALTER TABLE `issue_label_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_main`
--
ALTER TABLE `issue_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- 使用表AUTO_INCREMENT `issue_priority`
--
ALTER TABLE `issue_priority`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_recycle`
--
ALTER TABLE `issue_recycle`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `issue_resolve`
--
ALTER TABLE `issue_resolve`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10102;

--
-- 使用表AUTO_INCREMENT `issue_status`
--
ALTER TABLE `issue_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10101;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1580;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- 使用表AUTO_INCREMENT `log_base`
--
ALTER TABLE `log_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `main_group`
--
ALTER TABLE `main_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `main_notify_scheme`
--
ALTER TABLE `main_notify_scheme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `main_notify_scheme_data`
--
ALTER TABLE `main_notify_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `main_org`
--
ALTER TABLE `main_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- 使用表AUTO_INCREMENT `main_setting`
--
ALTER TABLE `main_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `main_widget`
--
ALTER TABLE `main_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `mind_issue_attribute`
--
ALTER TABLE `mind_issue_attribute`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- 使用表AUTO_INCREMENT `mind_project_attribute`
--
ALTER TABLE `mind_project_attribute`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `mind_second_attribute`
--
ALTER TABLE `mind_second_attribute`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- 使用表AUTO_INCREMENT `mind_sprint_attribute`
--
ALTER TABLE `mind_sprint_attribute`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `permission_default_role`
--
ALTER TABLE `permission_default_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10007;

--
-- 使用表AUTO_INCREMENT `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- 使用表AUTO_INCREMENT `permission_global`
--
ALTER TABLE `permission_global`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `permission_global_group`
--
ALTER TABLE `permission_global_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `permission_global_role`
--
ALTER TABLE `permission_global_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `permission_global_role_relation`
--
ALTER TABLE `permission_global_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `permission_global_user_role`
--
ALTER TABLE `permission_global_user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5615;

--
-- 使用表AUTO_INCREMENT `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(18) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_flag`
--
ALTER TABLE `project_flag`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `project_gantt_setting`
--
ALTER TABLE `project_gantt_setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `project_issue_report`
--
ALTER TABLE `project_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_label`
--
ALTER TABLE `project_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_list_count`
--
ALTER TABLE `project_list_count`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_main`
--
ALTER TABLE `project_main`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_main_extra`
--
ALTER TABLE `project_main_extra`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_mind_setting`
--
ALTER TABLE `project_mind_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- 使用表AUTO_INCREMENT `project_module`
--
ALTER TABLE `project_module`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `project_permission`
--
ALTER TABLE `project_permission`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10907;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- 使用表AUTO_INCREMENT `project_user_role`
--
ALTER TABLE `project_user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `project_version`
--
ALTER TABLE `project_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `user_email_token`
--
ALTER TABLE `user_email_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_issue_display_fields`
--
ALTER TABLE `user_issue_display_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12173;

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
-- 使用表AUTO_INCREMENT `user_posted_flag`
--
ALTER TABLE `user_posted_flag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_setting`
--
ALTER TABLE `user_setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;

--
-- 使用表AUTO_INCREMENT `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `user_widget`
--
ALTER TABLE `user_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=2454;

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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

