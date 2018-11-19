
-- 主机： 127.0.0.1
-- 生成日期： 2018-11-19 03:59:57
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
(1, '准备中', 1, '[\"open\",\"reopen\",\"todo\",\"delay\"]', 3),
(2, '进行中', 1, '[\"in_progress\",\"in_review\"]', 2),
(3, '已解决', 1, '[\"resolved\",\"closed\",\"done\"]', 1),
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
(3, 3, '第三次迭代', '本次迭代结束后发布1.0版本，这是一个正式的对外宣传推广的版本', 1, 1, 0, '2018-10-30', '2018-11-07'),
(12, 26, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(20, 86, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(21, 87, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(22, 88, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(23, 89, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(24, 90, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(25, 91, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(26, 92, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(27, 93, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(28, 94, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(37, 105, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(59, 190, 'test-name', NULL, 0, 0, 0, NULL, NULL),
(67, 2, '第一次迭代', '', 1, 1, 0, '2018-11-19', '2018-11-30');

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
(185, '47fd88aa-cd83-48ac-b98f-a6b670ae9944', 1, 'image/jpeg', 'timg.jpg', 'all/20180913/20180913001332_27981.jpg', 1536768812, 30069, 10000, 'jpg'),
(186, '3f65aea2-1009-4bbf-9fe2-f4f25974ecb4', 2, 'image/jpeg', 'db.jpg', 'all/20180913/20180913001723_53905.jpg', 1536769043, 29271, 10000, 'jpg'),
(194, '5e654090-a516-41a5-b7cd-a04e2079de3d', 4, 'image/jpeg', '4fb349516dc14993d2303f42c87f1793.jpg', 'all/20180913/20180913185638_85846.jpg', 1536836198, 90410, 10000, 'jpg'),
(279, '090b6d63-01e9-4723-91ff-79f23191024f', 0, 'image/jpeg', 'timg.jpg', 'avatar/20181119/20181119000353_65406.jpg', 1542557033, 30069, 10000, 'jpg');

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
(1, 'fm', 10000, '', NULL, '', '3', '经办人:@296459175@qq.com ', NULL, NULL),
(5, 'testSaveFilterName_600796', 11684, 'test', NULL, '', NULL, 'project=44&assignee=11684&author_username=19055938038&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(9, 'testSaveFilterName_431840', 11763, 'test', NULL, '', NULL, 'project=123&assignee=11763&author_username=19023319243&status=open&priority=high&resolve_resolve=done', NULL, NULL),
(14, 'testSaveFilterName_245261', 11841, 'test', NULL, '', NULL, 'project=209&assignee=11841&author_username=19039397491&status=open&priority=high&resolve_resolve=done', NULL, NULL);

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
(30, 150, 32),
(31, 263, 42),
(34, 344, 56);

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
  `resolve_date` date DEFAULT NULL,
  `module` int(11) DEFAULT '0',
  `milestone` varchar(20) DEFAULT NULL,
  `sprint` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) NOT NULL DEFAULT '',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否拥有子任务'
) ;

--
-- 转存表中的数据 `issue_main`
--

INSERT INTO `issue_main` (`id`, `pkey`, `issue_num`, `project_id`, `issue_type`, `creator`, `modifier`, `reporter`, `assignee`, `summary`, `description`, `environment`, `priority`, `resolve`, `status`, `created`, `updated`, `start_date`, `due_date`, `resolve_date`, `module`, `milestone`, `sprint`, `weight`, `backlog_weight`, `sprint_weight`, `assistants`, `master_id`, `have_children`) VALUES
(1, 'CRM', 'CRM1', 1, 1, 10000, 10000, 10000, 11652, '数据库设计', '1.第一步数据建模\r\n2.第二步ER图设计', 'windows', 1, 0, 6, 1536768829, 0, '2018-09-13', '2018-09-30', NULL, 3, NULL, 1, 0, 200000, 100000, '', 0, 0),
(2, 'CRM', 'CRM2', 1, 1, 10000, 10000, 10000, 11652, '数据库表设计', '1.\r\n2.\r\n3.', 'windows mysql', 1, 0, 6, 1536769063, 0, '2018-09-13', '2018-09-15', NULL, 1, NULL, 1, 0, 0, 200000, '', 0, 0),
(3, 'CRM', 'CRM3', 1, 1, 10000, 10000, 10000, 10000, '架构设计', '1.\r\n2.\r\n3.\r\n4.\r\n5.', '', 3, 10000, 1, 1536769153, 0, '2018-09-13', '2018-09-15', NULL, 2, NULL, 0, 0, 100000, 100000, '10000', 0, 0),
(4, 'ERP', 'ERP4', 2, 1, 10000, 0, 10000, 10000, '产品设计', '1.\r\n2.\r\n3.\r\n', '', 1, 0, 1, 1536836249, 0, '0000-00-00', '0000-00-00', NULL, 0, NULL, 0, 0, 100000, 0, '', 0, 0);

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
(11, 11684, 148, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-23855148', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-23855148\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1541954901\",\"updated\":\"1541954909\",\"start_date\":\"2018-11-12\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11684\"}', 1541954914),
(12, 11763, 261, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-25281001', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-25281001\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1541955779\",\"updated\":\"1541955787\",\"start_date\":\"2018-11-12\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11763\"}', 1541955792),
(13, 11841, 342, NULL, NULL, 0, 0, 0, 0, 0, 0, 'test-summary-30491930', NULL, '', 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, NULL, 0, '', 0, '{\"pkey\":null,\"issue_num\":null,\"project_id\":\"0\",\"issue_type\":\"1\",\"creator\":\"0\",\"modifier\":\"0\",\"reporter\":\"0\",\"assignee\":\"0\",\"summary\":\"test-summary-30491930\",\"description\":\"test-description\",\"environment\":\"test-environment\",\"priority\":\"1\",\"resolve\":\"1\",\"status\":\"4\",\"created\":\"1542175311\",\"updated\":\"1542175322\",\"start_date\":\"2018-11-14\",\"due_date\":\"0000-00-00\",\"resolve_date\":\"0000-00-00\",\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"master_id\":\"0\",\"have_children\":\"0\",\"delete_user_id\":\"11841\"}', 1542175326);

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
(1, 1, '已修复', 'fixed', '事项已经解决', NULL, '#1aaa55', 0),
(2, 2, '不能修复', 'not_fix', '事项未解决', NULL, '#db3b21', 0),
(3, 3, '需要重现', 'require_duplicate', '事项需要的描述需要有重现步骤', NULL, '#db3b21', 0),
(4, 4, '信息不完整', 'not_complete', '事项信息描述不完整', NULL, '#db3b21', 0),
(5, 5, '不能重现', 'not_reproduce', '事项不能重现', NULL, '#db3b21', 0),
(10000, 6, '完成', 'done', '事项已经解决并确认了', NULL, '#1aaa55', 0),
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
  `color` varchar(20) DEFAULT NULL COMMENT 'Default Primary Success Info Warning Danger可选',
  `text_color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_status`
--

INSERT INTO `issue_status` (`id`, `sequence`, `name`, `_key`, `description`, `font_awesome`, `is_system`, `color`, `text_color`) VALUES
(1, 1, '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', 0, 'info', NULL),
(3, 3, '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', 0, 'primary', NULL),
(4, 4, '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', 0, 'warning', NULL),
(5, 5, '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', 1, 'success', NULL),
(6, 6, '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', 0, 'success', NULL),
(10001, 8, '完 成', 'done', '事项已经已经被开发人员处理完，但需要被产品或测试人员确认', '/', 0, 'info', NULL),
(10002, 9, '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', 0, 'info', NULL),
(10100, 10, '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', 0, 'info', NULL);

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
(8, '5', '史诗任务', 'epic', 'Scrum', '大型的或大量的工作，包含许多用户故事', 'fa-address-book-o', NULL, 1, 0),
(10, '59', 'test-name44743215', 'test-key71036138', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(12, '13', 'test-name34432300', 'test-key70072224', 'Standard', 'test-description1', NULL, NULL, 0, 0),
(16, '46', 'test-name89864681', 'test-key67473420', 'Standard', 'test-description1', NULL, NULL, 0, 0);

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
(10, 'test-name-356', 'test-description', 0),
(15, 'test-name-658', 'test-description', 0),
(22, 'test-name-307', 'test-description', 0);

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
(437, 4, 'edit', 1, 14, 0),
(438, 4, 'edit', 6, 13, 0),
(439, 4, 'edit', 2, 12, 0),
(440, 4, 'edit', 7, 11, 0),
(441, 4, 'edit', 9, 10, 0),
(442, 4, 'edit', 8, 9, 0),
(443, 4, 'edit', 3, 8, 0),
(444, 4, 'edit', 4, 7, 0),
(445, 4, 'edit', 19, 6, 0),
(446, 4, 'edit', 10, 5, 0),
(447, 4, 'edit', 11, 4, 0),
(448, 4, 'edit', 12, 3, 0),
(449, 4, 'edit', 13, 2, 0),
(450, 4, 'edit', 15, 1, 0),
(451, 4, 'edit', 20, 0, 0),
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
(692, 1, 'edit', 1, 10, 0),
(693, 1, 'edit', 6, 9, 0),
(694, 1, 'edit', 2, 8, 0),
(695, 1, 'edit', 7, 7, 0),
(696, 1, 'edit', 8, 6, 0),
(697, 1, 'edit', 4, 5, 0),
(698, 1, 'edit', 19, 4, 0),
(699, 1, 'edit', 11, 3, 0),
(700, 1, 'edit', 12, 2, 0),
(701, 1, 'edit', 13, 1, 0),
(702, 1, 'edit', 15, 0, 0),
(703, 1, 'edit', 3, 4, 40),
(704, 1, 'edit', 9, 3, 40),
(705, 1, 'edit', 20, 2, 40),
(706, 1, 'edit', 10, 1, 40),
(707, 1, 'edit', 21, 0, 40),
(708, 1, 'create', 1, 10, 0),
(709, 1, 'create', 6, 9, 0),
(710, 1, 'create', 2, 8, 0),
(711, 1, 'create', 7, 7, 0),
(712, 1, 'create', 8, 6, 0),
(713, 1, 'create', 9, 5, 0),
(714, 1, 'create', 4, 4, 0),
(715, 1, 'create', 11, 3, 0),
(716, 1, 'create', 12, 2, 0),
(717, 1, 'create', 13, 1, 0),
(718, 1, 'create', 15, 0, 0),
(719, 1, 'create', 19, 4, 41),
(720, 1, 'create', 20, 3, 41),
(721, 1, 'create', 3, 2, 41),
(722, 1, 'create', 10, 1, 41),
(723, 1, 'create', 21, 0, 41),
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
(865, 2, 'create', 1, 11, 0),
(866, 2, 'create', 6, 10, 0),
(867, 2, 'create', 19, 9, 0),
(868, 2, 'create', 2, 8, 0),
(869, 2, 'create', 7, 7, 0),
(870, 2, 'create', 8, 6, 0),
(871, 2, 'create', 4, 5, 0),
(872, 2, 'create', 11, 4, 0),
(873, 2, 'create', 12, 3, 0),
(874, 2, 'create', 13, 2, 0),
(875, 2, 'create', 15, 1, 0),
(876, 2, 'create', 21, 0, 0),
(877, 2, 'create', 10, 3, 50),
(878, 2, 'create', 20, 2, 50),
(879, 2, 'create', 9, 1, 50),
(880, 2, 'create', 3, 0, 50),
(881, 2, 'edit', 1, 12, 0),
(882, 2, 'edit', 6, 11, 0),
(883, 2, 'edit', 19, 10, 0),
(884, 2, 'edit', 10, 9, 0),
(885, 2, 'edit', 2, 8, 0),
(886, 2, 'edit', 7, 7, 0),
(887, 2, 'edit', 8, 6, 0),
(888, 2, 'edit', 4, 5, 0),
(889, 2, 'edit', 11, 4, 0),
(890, 2, 'edit', 12, 3, 0),
(891, 2, 'edit', 13, 2, 0),
(892, 2, 'edit', 15, 1, 0),
(893, 2, 'edit', 21, 0, 0),
(894, 2, 'edit', 20, 2, 51),
(895, 2, 'edit', 9, 1, 51),
(896, 2, 'edit', 3, 0, 51);

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
(8, 11, 'test-name-53500', 0, 'create'),
(33, 6, '更多', 0, 'create'),
(34, 6, '\n            \n            更多\n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(37, 7, '更 多', 0, 'create'),
(38, 7, '\n            \n            更 多\n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(40, 1, '\n            更 多\n             \n            \n        ', 0, 'edit'),
(41, 1, '更 多', 0, 'create'),
(49, 3, '\n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(50, 2, '更 多', 0, 'create'),
(51, 2, '\n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n  ', 0, 'edit');

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
(122, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1541954866,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1541954876,\"f3\":\"google\"}', 'unknown', 1541954876),
(153, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1541955743,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1541955753,\"f3\":\"google\"}', 'unknown', 1541955753),
(184, 0, '日志', 0, 10000, 'cdwei', 'Sven', 'issuse', NULL, NULL, '新增', '日志测试111', '{\"f1\":\"Adidas\",\"f2\":1542175277,\"f3\":\"google\"}', '{\"f1\":\"Nike\",\"f2\":1542175287,\"f3\":\"google\"}', 'unknown', 1542175287);

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
(1, 2, '项目', 0, 10000, 'cdwei', '郭鑫年', '/project/setting/save_settings_profile?project_id=2', NULL, NULL, '编辑', '修改项目信息', '{\"id\":\"2\",\"org_id\":\"1\",\"org_path\":\"default\",\"name\":\"ERP\\u7cfb\\u7edf\\u5b9e\\u65bd\",\"url\":\"\",\"lead\":\"10000\",\"description\":\"                                                    \\u516c\\u53f8\\u5185\\u90e8ERP\\u9879\\u76ee\\u7684\\u5b9e\\u65bd                                                \",\"key\":\"ERP\",\"pcounter\":null,\"default_assignee\":\"1\",\"assignee_type\":null,\"avatar\":\"avatar\\/20180913\\/20180913144752_28827.jpg\",\"category\":\"0\",\"type\":\"10\",\"type_child\":\"0\",\"permission_scheme_id\":\"0\",\"workflow_scheme_id\":\"0\",\"create_uid\":\"10000\",\"create_time\":\"1536821242\",\"detail\":\"\\u6536\\u85cf 8742\\r\\n968\\r\\nERP\\u7cfb\\u7edf \\u7f16\\u8f91\\r\\nERP\\u7cfb\\u7edf\\u662f\\u4f01\\u4e1a\\u8d44\\u6e90\\u8ba1\\u5212(Enterprise Resource Planning )\\u7684\\u7b80\\u79f0\\uff0c\\u662f\\u6307\\u5efa\\u7acb\\u5728\\u4fe1\\u606f\\u6280\\u672f\\u57fa\\u7840\\u4e0a\\uff0c\\u96c6\\u4fe1\\u606f\\u6280\\u672f\\u4e0e\\u5148\\u8fdb\\u7ba1\\u7406\\u601d\\u60f3\\u4e8e\\u4e00\\u8eab\\uff0c\\u4ee5\\u7cfb\\u7edf\\u5316\\u7684\\u7ba1\\u7406\\u601d\\u60f3\\uff0c\\u4e3a\\u4f01\\u4e1a\\u5458\\u5de5\\u53c', '{\"lead\":\"10000\",\"description\":\"                                                    \\u516c\\u53f8\\u5185\\u90e8ERP\\u9879\\u76ee\\u7684\\u5b9e\\u65bd                                                \",\"type\":10,\"category\":0,\"url\":\"\",\"avatar\":\"\",\"detail\":\"\\r\\n\\r\\nERP\\u7cfb\\u7edf\\u662f\\u4f01\\u4e1a\\u8d44\\u6e90\\u8ba1\\u5212(Enterprise Resource Planning )\\u7684\\u7b80\\u79f0\\uff0c\\u662f\\u6307\\u5efa\\u7acb\\u5728\\u4fe1\\u606f\\u6280\\u672f\\u57fa\\u7840\\u4e0a\\uff0c\\u96c6\\u4fe1\\u606f\\u6280\\u672f\\u4e0e\\u5148\\u8fdb\\u7ba1\\u7406\\u601d\\u60f3\\u4e8e\\u4e00\\u8eab\\uff0c\\u4ee5\\u7cfb\\u7edf\\u5316\\u7684\\u7ba1\\u7406\\u601d\\u60f3\\uff0c\\u4e3a\\u4f01\\u4e1a\\u5458\\u5de5\\u53ca\\u51b3\\u7b56\\u5c42\\u63d0\\u4f9b\\u51b3\\u7b56\\u624b\\u6bb5\\u7684\\u7ba1\\u7406\\u5e73\\u53f0\\u3002\\u5b83\\u662f\\u4eceMRP\\uff08\\u7269\\u6599\\u9700\\u6c42\\u8ba1\\u5212\\uff09\\u53d1\\u5c55\\u800c\\u6765\\u7684\\u65b0\\u4e00\\u4ee3\\u96c6\\u6210\\u5316\\u7ba1\\u7406\\u4fe1\\u606f\\u7cfb\\u7edf\\uff0c\\u5b83\\u6269\\u5c55\\u4e86MRP\\u7684\\u529f\\u80fd\\uff0c\\u5176\\u6838\\u5fc3\\u601d\\u60f3\\u662f\\u4f9b\\u5e94', '127.0.0.1', 1542556972),
(2, 2, '项目', 0, 10000, 'cdwei', '郭鑫年', '/project/setting/save_settings_profile?project_id=2', NULL, NULL, '编辑', '修改项目信息', '{\"id\":\"2\",\"org_id\":\"1\",\"org_path\":\"default\",\"name\":\"ERP\\u7cfb\\u7edf\\u5b9e\\u65bd\",\"url\":\"\",\"lead\":\"10000\",\"description\":\"                                                    \\u516c\\u53f8\\u5185\\u90e8ERP\\u9879\\u76ee\\u7684\\u5b9e\\u65bd                                                \",\"key\":\"ERP\",\"pcounter\":null,\"default_assignee\":\"1\",\"assignee_type\":null,\"avatar\":\"\",\"category\":\"0\",\"type\":\"10\",\"type_child\":\"0\",\"permission_scheme_id\":\"0\",\"workflow_scheme_id\":\"0\",\"create_uid\":\"10000\",\"create_time\":\"1536821242\",\"detail\":\"\\r\\n\\r\\nERP\\u7cfb\\u7edf\\u662f\\u4f01\\u4e1a\\u8d44\\u6e90\\u8ba1\\u5212(Enterprise Resource Planning )\\u7684\\u7b80\\u79f0\\uff0c\\u662f\\u6307\\u5efa\\u7acb\\u5728\\u4fe1\\u606f\\u6280\\u672f\\u57fa\\u7840\\u4e0a\\uff0c\\u96c6\\u4fe1\\u606f\\u6280\\u672f\\u4e0e\\u5148\\u8fdb\\u7ba1\\u7406\\u601d\\u60f3\\u4e8e\\u4e00\\u8eab\\uff0c\\u4ee5\\u7cfb\\u7edf\\u5316\\u7684\\u7ba1\\u7406\\u601d\\u60f3\\uff0c\\u4e3a\\u4f01\\u4e1a\\u5458\\u5de5\\u53ca\\u51b3\\u7b56\\u5c42\\u63d0\\u4f9b\\u51b3\\u7b56\\u624b\\u6bb5\\u7684\\u7ba1\\u7406\\u5e73\\u53f0\\u3002\\u5', '{\"lead\":\"10000\",\"description\":\"                                                    \\u516c\\u53f8\\u5185\\u90e8ERP\\u9879\\u76ee\\u7684\\u5b9e\\u65bd                                                \",\"type\":10,\"category\":0,\"url\":\"\",\"avatar\":\"avatar\\/20181119\\/20181119000353_65406.jpg\",\"detail\":\"\\r\\nERP\\u7cfb\\u7edf\\u662f\\u4f01\\u4e1a\\u8d44\\u6e90\\u8ba1\\u5212(Enterprise Resource Planning )\\u7684\\u7b80\\u79f0\\uff0c\\u662f\\u6307\\u5efa\\u7acb\\u5728\\u4fe1\\u606f\\u6280\\u672f\\u57fa\\u7840\\u4e0a\\uff0c\\u96c6\\u4fe1\\u606f\\u6280\\u672f\\u4e0e\\u5148\\u8fdb\\u7ba1\\u7406\\u601d\\u60f3\\u4e8e\\u4e00\\u8eab\\uff0c\\u4ee5\\u7cfb\\u7edf\\u5316\\u7684\\u7ba1\\u7406\\u601d\\u60f3\\uff0c\\u4e3a\\u4f01\\u4e1a\\u5458\\u5de5\\u53ca\\u51b3\\u7b56\\u5c42\\u63d0\\u4f9b\\u51b3\\u7b56\\u624b\\u6bb5\\u7684\\u7ba1\\u7406\\u5e73\\u53f0\\u3002\\u5b83\\u662f\\u4eceMRP\\uff08\\u7269\\u6599\\u9700\\u6c42\\u8ba1\\u5212\\uff09\\u53d1\\u5c55\\u800c\\u6765\\u7684\\u65b0\\u4e00\\u4ee3\\u96c6\\u6210\\u5316\\u7ba1\\u7406\\u4fe1\\u606f\\u7cfb\\u7edf\\uff0c\\u5b83\\u6269\\u5c55\\u4e86MRP\\u7684\\u529f\\u80fd\\uff0c\\u5176\\u68', '127.0.0.1', 1542557035),
(3, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"1980-11-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557437\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"birthday\":\"1980-11-19\",\"avatar\":\"avatar\\/1.png?t=1542557437\"}', '127.0.0.1', 1542557437),
(4, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"1980-11-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557441\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"birthday\":\"1980-11-19\",\"avatar\":\"avatar\\/1.png?t=1542557441\"}', '127.0.0.1', 1542557441),
(5, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"1980-11-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557444\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"birthday\":\"1980-11-19\",\"avatar\":\"avatar\\/1.png?t=1542557444\"}', '127.0.0.1', 1542557444),
(6, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557458\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542557458\"}', '127.0.0.1', 1542557458),
(7, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557481\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542557481\"}', '127.0.0.1', 1542557481),
(8, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557719\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"121\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"121\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542557719\"}', '127.0.0.1', 1542557719),
(9, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557752\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"121\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"121\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542557752\"}', '127.0.0.1', 1542557752),
(10, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557884\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"121\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"121\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542557884\"}', '127.0.0.1', 1542557884),
(11, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542557933\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"121\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"121\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542557933\"}', '127.0.0.1', 1542557933),
(12, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"0\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542558086\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\"}', '{\"display_name\":\"Master\",\"sex\":0,\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542558086\"}', '127.0.0.1', 1542558086),
(13, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"0\",\"birthday\":\"2011-11-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542558098\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\"}', '{\"display_name\":\"Master\",\"sex\":0,\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\",\"birthday\":\"2011-11-19\",\"avatar\":\"avatar\\/1.png?t=1542558098\"}', '127.0.0.1', 1542558099),
(14, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"0\",\"birthday\":\"1985-07-19\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542558176\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\"}', '{\"display_name\":\"Master\",\"sex\":0,\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\",\"birthday\":\"1985-07-19\",\"avatar\":\"avatar\\/1.png?t=1542558176\"}', '127.0.0.1', 1542558176),
(15, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"0\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542559451\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\"}', '{\"display_name\":\"Master\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542559451\"}', '127.0.0.1', 1542559451),
(16, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"18002510000@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"0\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1542559481\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557235\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"\\u516c\\u53f8\\u8001\\u5927\"}', '{\"display_name\":\"Master\",\"birthday\":\"\",\"avatar\":\"avatar\\/1.png?t=1542559481\"}', '127.0.0.1', 1542559481),
(17, 0, '用户', 10000, 10000, 'cdwei', 'Sven', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"10000\",\"directory_id\":\"1\",\"phone\":\"18002516775\",\"username\":\"cdwei\",\"openid\":\"b7a782741f667201b54880c925faec4b\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"\\u97e6\\u671d\\u593a\",\"display_name\":\"\\u90ed\\u946b\\u5e74\",\"email\":\"121642038@qq.com\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/10000.png?t=1542597827\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557116\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u4ea7\\u54c1\\u7ecf\\u7406 & \\u6280\\u672f\\u7ecf\\u7406\",\"sign\":\"\\u52aa\\u529b\\u662f\\u4e3a\\u4e86\\u8ba9\\u81ea\\u5df1\\u66f4\\u5feb\\u4e50~\"}', '{\"display_name\":\"\\u90ed\\u946b\\u5e74\",\"sex\":1,\"sign\":\"\\u52aa\\u529b\\u662f\\u4e3a\\u4e86\\u8ba9\\u81ea\\u5df1\\u66f4\\u5feb\\u4e50~\",\"birthday\":\"\",\"avatar\":\"avatar\\/10000.png?t=1542597827\"}', '127.0.0.1', 1542597828),
(18, 0, '用户', 10000, 10000, 'cdwei', 'Sven', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"10000\",\"directory_id\":\"1\",\"phone\":\"18002516775\",\"username\":\"cdwei\",\"openid\":\"b7a782741f667201b54880c925faec4b\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"\\u97e6\\u671d\\u593a\",\"display_name\":\"\\u90ed\\u946b\\u5e74\",\"email\":\"121642038@qq.com\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/10000.png?t=1542597832\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1542557116\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u4ea7\\u54c1\\u7ecf\\u7406 & \\u6280\\u672f\\u7ecf\\u7406\",\"sign\":\"\\u52aa\\u529b\\u662f\\u4e3a\\u4e86\\u8ba9\\u81ea\\u5df1\\u66f4\\u5feb\\u4e50~\"}', '{\"display_name\":\"\\u90ed\\u946b\\u5e74\",\"sex\":1,\"sign\":\"\\u52aa\\u529b\\u662f\\u4e3a\\u4e86\\u8ba9\\u81ea\\u5df1\\u66f4\\u5feb\\u4e50~\",\"birthday\":\"\",\"avatar\":\"avatar\\/10000.png?t=1542597832\"}', '127.0.0.1', 1542597832);

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
(2, 10000, 1, '创建了项目', 'project', 1, '客户管理crm系统', '2018-08-25', 1535201403),
(401, 10000, 2, '创建了项目', 'project', 2, 'ERP系统实施', '2018-08-25', 1535201403),
(402, 1, 0, '更新了资料', 'user', 1, 'Master', '2018-11-19', 1542557437),
(414, 1, 0, '更新了资料', 'org', 1, 'Master', '2018-11-19', 1542559451),
(415, 1, 0, '更新了资料', 'org', 1, 'Master', '2018-11-19', 1542559481),
(416, 10000, 2, '创建了迭代', 'agile', 67, '第一次迭代', '2018-11-19', 1542597216),
(417, 10000, 0, '更新了资料', 'user', 10000, '郭鑫年', '2018-11-19', 1542597827),
(418, 10000, 0, '更新了资料', 'user', 10000, '郭鑫年', '2018-11-19', 1542597832);

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
(1, 'test-content-362029', 0, 0, 2018);

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
('dict/list_count/getAll/1,*', 'dict/list_count', '2018-11-26 01:29:16', 1543166956),
('dict/sprint/getItemById/67', 'dict/sprint', '2018-11-26 11:13:37', 1543202017),
('setting/getSettingByKey/datetime_format', 'setting', '2018-11-26 01:29:16', 1543166956),
('setting/getSettingByKey/date_timezone', 'setting', '2018-11-26 01:29:16', 1543166956),
('setting/getSettingByKey/title', 'setting', '2018-11-26 01:29:16', 1543166956);

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
(1, 'default', 'Default', 'Default organization', 'org/default.jpg', 0, 0, 1535263464, 3),
(2, 'ismond', 'Agile', '敏捷开发部', 'org/agile.jpg', 10000, 0, 1535263488, 1);

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
(1, 'title', '网站的页面标题', 'basic', 'MasterLab--基于敏捷开发和事项驱动的现代项目管理工具', 'Masterlab', 'string', 'text', NULL, ''),
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
(28, 11654, 'issue', 0, 0, 52, 'commented', '', '首页的图标必须是正方形，要不然怎么样都不好看', '<p>首页的图标必须是正方形，要不然怎么样都不好看</p>\n', 1540454400);

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
(66, 1, 'backlog_weight', '{\"1\":200000,\"3\":100000}', 1536769363),
(67, 1, 'backlog_weight', '{\"3\":100000}', 1536807016),
(68, 1, 'backlog_weight', '{\"3\":100000}', 1536807475),
(69, 1, 'backlog_weight', '{\"3\":100000}', 1536808903),
(70, 1, 'backlog_weight', '{\"3\":100000}', 1536808906),
(71, 1, 'backlog_weight', '{\"3\":100000}', 1536808909),
(72, 1, 'backlog_weight', '{\"3\":100000}', 1536808915),
(73, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1536808917),
(74, 1, 'backlog_weight', '{\"3\":100000}', 1536808922),
(75, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1536808927),
(76, 1, 'backlog_weight', '{\"3\":100000}', 1536808929),
(77, 1, 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', 1536808933),
(78, 1, 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', 1536813014),
(79, 1, 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', 1536842491),
(80, 1, 'sprint_1_weight', '{\"2\":300000,\"1\":200000,\"3\":100000}', 1536848597),
(81, 2, 'backlog_weight', '{\"4\":100000}', 1536855096),
(82, 1, 'backlog_weight', '{\"3\":100000}', 1536899133),
(83, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1536899134),
(84, 1, 'backlog_weight', '{\"3\":100000}', 1536899135),
(85, 1, 'backlog_weight', '{\"3\":100000}', 1537869374),
(86, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1537869375),
(87, 1, 'backlog_weight', '{\"3\":100000}', 1537869376),
(88, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1537923755),
(89, 1, 'backlog_weight', '{\"3\":100000}', 1537923766),
(90, 1, 'backlog_weight', '{\"3\":100000}', 1537934054),
(91, 1, 'backlog_weight', '{\"3\":100000}', 1537947106),
(92, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1537947108),
(93, 1, 'backlog_weight', '{\"3\":100000}', 1537947110),
(94, 1, 'backlog_weight', '{\"3\":100000}', 1538106795),
(95, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1538191161),
(158, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1540454005);

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
(18, 2, 85),
(20, 2, 164),
(25, 2, 250);

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
(2, 20, 1, '看板开发项目总数'),
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
) ;

--
-- 转存表中的数据 `project_main`
--

INSERT INTO `project_main` (`id`, `org_id`, `org_path`, `name`, `url`, `lead`, `description`, `key`, `pcounter`, `default_assignee`, `assignee_type`, `avatar`, `category`, `type`, `type_child`, `permission_scheme_id`, `workflow_scheme_id`, `create_uid`, `create_time`, `detail`, `un_done_count`, `done_count`, `closed_count`) VALUES
(1, 1, 'default', '客户管理crm系统', '', 10000, '                                                                                                                                                                                                                基于人工智能的客户关系管理系统                                                                                                                                                                                                ', 'CRM', NULL, 1, NULL, 'project/avatar/1.jpg', 0, 10, 0, 0, 0, 10000, 1536553005, 'CRM(Customer Relationship Management\r\n\r\n客户关系管理，是一种以\"客户关系一对一理论\"为基础，旨在改善企业与客户之间关系的新型管理机制。客户关系管理的定义是：企业为提高核心竞争力，利用相应的信息技术以及互联网技术来协调企业与顾客间在销售、营销和服务上的交互，从而提升其管理方式，向客户提供创新式的个性化的客户交互和服务的过程。其最终目标是吸引新客户、保留老客户以及将已有客户转为忠实客户，增加市场份额。\r\n\r\n最早发展客户关系管理的国家是美国，这个概念最初由Gartner Group提出来，在1980年初便有所谓的“接触管理”(Contact Management)，即专门收集客户与公司联系的所有信息，到1990年则演变成包括电话服务中心支持资料分析的客户关怀（Customer care）。开始在企业电子商务中流行。\r\n\r\nCRM系统的宗旨是：为了满足每个客户的特殊需求，同每个客户建立联系，通过同客户的联系来了解客户的不同需求，并在此基础上进行\"一对一\"个性化服务。通常CRM包括销售管理、市场营销管理、客户服务系统以及呼叫中心等方面。\r\n“以客户为中心”，提高客户满意度，培养、维持客户忠诚度，在今天这个电子商务时代显得日益重要。客户关系管理正是改善企业与客户之间关系的新型管理机制，越来越多的企业运用CRM来增加收入、优化赢利性、提高客户满意度。\r\n\r\n统计数据表明，2008年中小企业CRM市场的规模已达8亿美元。在随后五年中，这一市场将快速增长至18亿美元，在整个CRM市场中占比达30%以上。 \r\n\r\nCRM系统主要包含传统CRM系统和在线CRM系统。', 1, 2, 2),
(2, 1, 'default', 'ERP系统实施', '', 10000, '                                                    公司内部ERP项目的实施                                                ', 'ERP', NULL, 1, NULL, 'project/avatar/2.jpg', 0, 10, 0, 0, 0, 10000, 1536821242, '\r\nERP系统是企业资源计划(Enterprise Resource Planning )的简称，是指建立在信息技术基础上，集信息技术与先进管理思想于一身，以系统化的管理思想，为企业员工及决策层提供决策手段的管理平台。它是从MRP（物料需求计划）发展而来的新一代集成化管理信息系统，它扩展了MRP的功能，其核心思想是供应链管理。它跳出了传统企业边界，从供应链范围去优化企业的资源，优化了现代企业的运行模式，反映了市场对企业合理调配资源的要求。它对于改善企业业务流程、提高企业核心竞争力具有显著作用。\r\n\r\n系统特点编辑\r\nERP是Enterprise Resource Planning（企业资源计划）的简称，是上个世纪90年代美国一家IT公司根据当时计算机信息、IT技术发展及企业对供应链管理的需求，预测在今后信息时代企业管理信息系统的发展趋势和即将发生变革，而提出了这个概念。 ERP是针对物资资源管理（物流）、人力资源管理（人流）、财务资源管理（财流）、信息资源管理（信息流）集成一体化的企业管理软件。它将包含客户/服务架构，使用图形用户接口，应用开放系统制作。除了已有的标准功能，它还包括其它特性，如品质、过程运作管理、以及调整报告等。\r\nERP系统的特点有：\r\n企业内部管理所需的业务应用系统，主要是指财务、物流、人力资源等核心模块。\r\n\r\n物流管理系统采用了制造业的MRP管理思想；FMIS有效地实现了预算管理、业务评估、管理会计、ABC成本归集方法等现代基本财务管理方法；人力资源管理系统在组织机构设计、岗位管理、薪酬体系以及人力资源开发等方面同样集成了先进的理念。\r\nERP系统是一个在全公司范围内应用的、高度集成的系统。数据在各业务系统之间高度共享，所有源数据只需在某一个系统中输入一次，保证了数据的一致性。\r\n对公司内部业务流程和管理过程进行了优化，主要的业务流程实现了自动化。\r\n采用了计算机最新的主流技术和体系结构：B/S、INTERNET体系结构，WINDOWS界面。在能通信的地方都可以方便地接入到系统中来。\r\n集成性、先进性、统一性、完整性、开放性。\r\n实用性\r\nERP系统实际应用中更重要的是应该体现其“管理工具”的本质。ERP系统主要宗旨是对企业所拥有的人、财、物、信息、时间和空间等综合资源进行综合平衡和优化管理，ERP软件协调企业各管理部门，ERP系统围绕市场导向开展业务活动，提高企业的核心竞争力，ERP软件从而取得最好的经济效益。所以，ERP系统首先是一个软件，同时是一个管理工具。ERP软件是IT技术与管理思想的融合体，ERP系统也就是先进的管理思想借助电脑，来达成企业的管理目标。\r\n整合性\r\nERP最大特色便是整个企业信息系统的整合，比传统单一的系统更具功能性。\r\n弹性\r\n采用模块化的设计方式，使系统本身可因应企业需要新增模块来支持并整合，提升企业的应变能力。\r\n数据储存\r\n将原先分散企业各角落的数据整合起来，使数据得以一致性，并提升其精确性。\r\n便利性\r\n在整合的环境下，企业内部所产生的信息透过系统将可在企业任一地方取得与应用。\r\n管理绩效\r\nERP系统将使部分间横向的联系有效且紧密，使得管理绩效提升。\r\n互动关系\r\n透过ERP系统配合使企业与原物料供货商之间紧密结合，增加其市场变动的能力。而CRM客户关系管理系统则使企业充分掌握市场需要取向的动脉，两者皆有助于促进企业与上下游的互动发展关系。\r\n实时性\r\nERP是整个企业信息的整合管理，重在整体性，而整体性的关键就体现于“实时和动态管理”上，所谓“兵马未动，粮草先行”，强调的就是不同部门的“实时动态配合”，现实工作中的管理问题，也是部门协调与岗位配合的问题，因此缺乏“实时动态的管理手段和管理能力”的ERP管理，就是空谈。\r\n及时性\r\nERP管理的关键是“现实工作信息化”，即把现实中的工作内容与工作方式，用信息化的手段来表现，因为人的精力和能力是有限的，现实事务达到一定的繁杂程度后，人就会在所难免的出错，将工作内容与工作方式信息化，就能形成ERP管理的信息化体系，才能拥有可靠的信息化管理工具。', 1, 0, 1);

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
(25, 26, 'test-name', 'test-description', 0, 0, 0),
(33, 0, 'test-name', 'test-description', 0, 0, 0),
(34, 86, 'test-name', 'test-description', 0, 0, 0),
(35, 87, 'test-name', 'test-description', 0, 0, 0),
(36, 88, 'test-name', 'test-description', 0, 0, 0),
(37, 89, 'test-name', 'test-description', 0, 0, 0),
(38, 90, 'test-name', 'test-description', 0, 0, 0),
(39, 91, 'test-name', 'test-description', 0, 0, 0),
(40, 92, 'test-name', 'test-description', 0, 0, 0),
(41, 93, 'test-name', 'test-description', 0, 0, 0),
(42, 94, 'test-name', 'test-description', 0, 0, 0),
(46, 105, 'test-name', 'test-description', 0, 0, 0),
(54, 0, 'test-name', 'test-description', 0, 0, 0),
(62, 190, 'test-name', 'test-description', 0, 0, 0),
(70, 0, 'test-name', 'test-description', 0, 0, 0);

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
(31, 85, 'Users', '普通用户', 1),
(32, 85, 'Developers', '开发者,如程序员，架构师', 1),
(33, 85, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(34, 85, 'QA', '测试工程师', 1),
(35, 85, 'PO', '产品经理，产品负责人', 1),
(46, 164, 'Users', '普通用户', 1),
(47, 164, 'Developers', '开发者,如程序员，架构师', 1),
(48, 164, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(49, 164, 'QA', '测试工程师', 1),
(50, 164, 'PO', '产品经理，产品负责人', 1),
(62, 250, 'Users', '普通用户', 1),
(63, 250, 'Developers', '开发者,如程序员，架构师', 1),
(64, 250, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(65, 250, 'QA', '测试工程师', 1),
(66, 250, 'PO', '产品经理，产品负责人', 1);

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
(74, 2, 10, 10904);

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
(147, 1, '2018-11-09', 5, '11', 2, 1, 1, 2, 0, 2),
(148, 2, '2018-11-09', 5, '11', 0, 1, 0, 1, 0, 0),
(149, 3, '2018-11-09', 5, '11', 43, 27, 12, 58, 0, 43),
(150, 4, '2018-11-09', 5, '11', 0, 0, 0, 0, 0, 0);

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
(4, 1, '2018-11-09', 5, '11', 2, 0, 0, 2, 0, 2),
(5, 2, '2018-11-09', 5, '11', 42, 1, 12, 31, 0, 42),
(6, 3, '2018-11-09', 5, '11', 1, 25, 0, 26, 0, 1);

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
('19018992825@masterlab.org', 0, 'OQD5TDU6TOB2TQ012CHVS6OCILTYIJWN', 1541955800),
('19023588032@masterlab.org', 0, 'RIU152FC9LG9MB5B4KTOYMRRCM20Y8IP', 1541954922),
('19061355493@masterlab.org', 0, 'VEMQDPHUSP5RO9U3TBYCENR132Y52010', 1542175334),
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
(10690, 1, 1),
(10000, 10000, 1),
(10001, 10000, 2),
(10224, 10000, 6);

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
(1, 'r67ah5d38c6v4e18s3smvuc5gi', '', 10000, 1542556081, '127.0.0.1'),
(2, 'r67ah5d38c6v4e18s3smvuc5gi', '', 1, 1542557089, '127.0.0.1'),
(3, 'r67ah5d38c6v4e18s3smvuc5gi', '', 10000, 1542557116, '127.0.0.1'),
(4, 'r67ah5d38c6v4e18s3smvuc5gi', '', 1, 1542557235, '127.0.0.1');

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
(1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', '18002510000@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 0, '', 0, 0, 'avatar/1.png?t=1542559481', '', NULL, NULL, NULL, NULL, 1542557235, 0, 0, '管理员', '公司老大'),
(10000, 1, '18002516775', 'cdwei', 'b7a782741f667201b54880c925faec4b', 1, '', '韦朝夺', '郭鑫年', '121642038@qq.com', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '', 0, 0, 'avatar/10000.png?t=1542597832', '', NULL, NULL, NULL, NULL, 1542557116, 0, 0, '产品经理 & 技术经理', '努力是为了让自己更快乐~'),
(11652, NULL, NULL, '79720699@qq.com', '8ceb21e5b4b18e6ae2f63f4568ffcca6', 1, NULL, NULL, '卢卡', '79720699@qq.com', '$2y$10$qZQaNkcprlkr4/T.yk30POfWapHaVf2sYXhVvvdhdJ2kVOy4Mf1Le', 0, NULL, 1536721687, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'coo', NULL),
(11653, NULL, NULL, 'luxueting@qq.com', '37768ff1f406a7ffeb869a39fb84f005', 1, NULL, NULL, '杨阳洋', 'luxueting@qq.com', '$2y$10$YpOrL9dehAD9oo1UZ2e38ujSd.TuC6yV5eq2yQp2knLBpU09uomiq', 0, NULL, 1536721754, 0, '', '', NULL, NULL, NULL, '', 0, 0, 0, 'CI', NULL),
(11654, NULL, NULL, '1043423813@qq.com', '7874f7ec72dc03d77bd1627c0350a770', 1, NULL, NULL, '那蓝', '1043423813@qq.com', '$2y$10$d6rrId1okEVAC8yQweeLZ.Ri8HfiBLosXG2A6i05QsGenhCl8Mtce', 0, '', 1539092584, 0, 'avatar/11654.png?t=1539845533', '', NULL, NULL, NULL, '', 1540798848, 0, 0, '高级前端工程师', NULL),
(11655, NULL, NULL, 'moxao@vip.qq.com', '44466a8b2af46b8de06fb2846e4ba97b', 1, NULL, NULL, 'Mo', 'moxao@vip.qq.com', '$2y$10$OmoUAOqSilUDOGM1ZGm1vuKMZLV/oSHYsXUDK4S3h/oJD14MWKFdu', 0, '', 1539092621, 0, 'avatar/11655.png?t=1539770756', '', NULL, NULL, NULL, '', 1540967904, 0, 0, '高级设计师', NULL),
(11656, NULL, NULL, '23335096@qq.com', '63db4462b453ac29a280bade38e8b3d6', 1, NULL, NULL, '罗维', '23335096@qq.com', '$2y$10$V.OsAQuPq0V1pymlhE1.yuXE7aJRaKUOVDvB5k0Zj5/SOSNLptzbW', 1, '', 1539092741, 0, 'avatar/11656.png', '', NULL, NULL, NULL, '', 1540634774, 0, 0, 'CTO', NULL),
(11657, NULL, NULL, '296459175@qq.com', '31cca79124bdd459995b52a391d54e49', 1, NULL, NULL, '温迪', '296459175@qq.com', '$2y$10$fN8VbuEfd.BWqmVW/Q.zd.jGB4TJWwrsUq/Dze11Mrq0ftNFBn3zG', 1, '', 1539158699, 0, 'avatar/11657.png?t=1539830329', '', NULL, NULL, NULL, '', 1541492264, 0, 0, '开发工程师', NULL);

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
(1, 10000, 'a0dc3ca2c4b07c1cc7d05fab19b5802029ca4e51d2b69e64dca794bfac495f11', 1542557116, '1158ddd717a7e8a0f52740450da3584f0be0cf479c445a35e4530d1a2b91a979', 1542557116),
(2, 1, 'fbaa2106823f681c9379ee1922b4b539cbe257f21e90c4017bddb18a5dc73a05', 1542557235, 'd096a901056ff5ed1b2ca6fedced608d5b3eb0f3d2246b922f5b1a7759aa70a4', 1542557235);

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
(4, 'test-name-476909', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(6, 'test-name-562920', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(7, 'test-name-906294', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(9, 'test-name-48178', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(13, 'test-name-51747', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0),
(15, 'test-name-822955', 'test-description', 1, NULL, NULL, NULL, 0, '{}', 0);

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
  ADD KEY `uuid` (`uuid`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `agile_board_column`
--
ALTER TABLE `agile_board_column`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `agile_sprint`
--
ALTER TABLE `agile_sprint`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- 使用表AUTO_INCREMENT `agile_sprint_issue_report`
--
ALTER TABLE `agile_sprint_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `field_main`
--
ALTER TABLE `field_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `issue_follow`
--
ALTER TABLE `issue_follow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_label`
--
ALTER TABLE `issue_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `issue_label_data`
--
ALTER TABLE `issue_label_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- 使用表AUTO_INCREMENT `issue_main`
--
ALTER TABLE `issue_main`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_priority`
--
ALTER TABLE `issue_priority`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `issue_recycle`
--
ALTER TABLE `issue_recycle`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `issue_resolve`
--
ALTER TABLE `issue_resolve`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10107;

--
-- 使用表AUTO_INCREMENT `issue_status`
--
ALTER TABLE `issue_status`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10106;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=529;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=917;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- 使用表AUTO_INCREMENT `log_base`
--
ALTER TABLE `log_base`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- 使用表AUTO_INCREMENT `log_operating`
--
ALTER TABLE `log_operating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `log_runtime_error`
--
ALTER TABLE `log_runtime_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_activity`
--
ALTER TABLE `main_activity`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;

--
-- 使用表AUTO_INCREMENT `main_group`
--
ALTER TABLE `main_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用表AUTO_INCREMENT `main_org`
--
ALTER TABLE `main_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- 使用表AUTO_INCREMENT `main_setting`
--
ALTER TABLE `main_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 使用表AUTO_INCREMENT `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10905;

--
-- 使用表AUTO_INCREMENT `permission_default_role`
--
ALTER TABLE `permission_default_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10010;

--
-- 使用表AUTO_INCREMENT `permission_default_role_relation`
--
ALTER TABLE `permission_default_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- 使用表AUTO_INCREMENT `permission_global_group`
--
ALTER TABLE `permission_global_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- 使用表AUTO_INCREMENT `project_issue_report`
--
ALTER TABLE `project_issue_report`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `project_label`
--
ALTER TABLE `project_label`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- 使用表AUTO_INCREMENT `project_role`
--
ALTER TABLE `project_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- 使用表AUTO_INCREMENT `project_role_relation`
--
ALTER TABLE `project_role_relation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374;

--
-- 使用表AUTO_INCREMENT `project_user_role`
--
ALTER TABLE `project_user_role`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- 使用表AUTO_INCREMENT `project_version`
--
ALTER TABLE `project_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- 使用表AUTO_INCREMENT `report_project_issue`
--
ALTER TABLE `report_project_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- 使用表AUTO_INCREMENT `report_sprint_issue`
--
ALTER TABLE `report_sprint_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `user_email_active`
--
ALTER TABLE `user_email_active`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `user_email_token`
--
ALTER TABLE `user_email_token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10691;

--
-- 使用表AUTO_INCREMENT `user_ip_login_times`
--
ALTER TABLE `user_ip_login_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11967;

--
-- 使用表AUTO_INCREMENT `user_message`
--
ALTER TABLE `user_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_phone_find_password`
--
ALTER TABLE `user_phone_find_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `user_refresh_token`
--
ALTER TABLE `user_refresh_token`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_setting`
--
ALTER TABLE `user_setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `workflow_block`
--
ALTER TABLE `workflow_block`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `workflow_connector`
--
ALTER TABLE `workflow_connector`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `workflow_scheme`
--
ALTER TABLE `workflow_scheme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10111;

--
-- 使用表AUTO_INCREMENT `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10352;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
