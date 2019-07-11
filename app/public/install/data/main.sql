
-- Generation Time: 2019-07-05 19:09:31
-- 服务器版本： 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masterlab_dev`
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
(1, '准 备', 1, '[\"open\",\"reopen\",\"todo\",\"delay\"]', 3),
(2, '进行中', 1, '[\"in_progress\",\"in_review\"]', 2),
(3, '已完成', 1, '[\"resolved\",\"closed\",\"done\"]', 1),
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
(21, 'weight', '权 重', '待办事项中的权重值', 'TEXT', '0', 1, '', 0),
(23, 'source', '来源', '', 'TEXT', NULL, 0, '', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- 表的结构 `issue_follow`
--

CREATE TABLE `issue_follow` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `pkey` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_num` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` int(11) DEFAULT '0',
  `issue_type` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `creator` int(11) UNSIGNED DEFAULT '0',
  `modifier` int(11) UNSIGNED NOT NULL DEFAULT '0',
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
  `weight` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '优先级权重值',
  `backlog_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重',
  `sprint_weight` int(11) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重',
  `assistants` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `master_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务的id,非0表示子任务',
  `have_children` tinyint(1) UNSIGNED DEFAULT '0' COMMENT '是否拥有子任务',
  `followed_count` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '被关注人数',
  `comment_count` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 2, '不能解决', 'not_fix', '事项不可抗拒原因无法解决', NULL, '#db3b21', 1),
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
  `color` varchar(20) DEFAULT NULL COMMENT 'Default Primary Success Info Warning Danger可选'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `issue_status`
--

INSERT INTO `issue_status` (`id`, `sequence`, `name`, `_key`, `description`, `font_awesome`, `is_system`, `color`) VALUES
(1, 1, '打 开', 'open', '表示事项被提交等待有人处理', '/images/icons/statuses/open.png', 1, 'info'),
(3, 3, '进行中', 'in_progress', '表示事项在处理当中，尚未完成', '/images/icons/statuses/inprogress.png', 1, 'primary'),
(4, 4, '重新打开', 'reopen', '事项重新被打开,重新进行解决', '/images/icons/statuses/reopened.png', 1, 'warning'),
(5, 5, '已解决', 'resolved', '事项已经解决', '/images/icons/statuses/resolved.png', 1, 'success'),
(6, 6, '已关闭', 'closed', '问题处理结果确认后，置于关闭状态。', '/images/icons/statuses/closed.png', 1, 'success'),
(10001, 0, '完成', 'done', '表明一件事项已经解决且被实践验证过', '', 1, 'success'),
(10002, 9, '回 顾', 'in_review', '该事项正在回顾或检查中', '/images/icons/statuses/information.png', 1, 'info'),
(10100, 10, '延迟处理', 'delay', '延迟处理', '/images/icons/statuses/generic.png', 1, 'info');

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
(20, 5, 10002),
(446, 1, 1),
(447, 1, 2),
(448, 1, 3),
(449, 1, 4),
(450, 1, 5),
(451, 2, 1),
(452, 2, 2),
(453, 2, 4),
(454, 2, 6),
(455, 2, 7),
(456, 2, 8),
(457, 2, 9);

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
(834, 3, 'create', 1, 13, 0, 1),
(835, 3, 'create', 6, 12, 0, 0),
(836, 3, 'create', 2, 11, 0, 0),
(837, 3, 'create', 7, 10, 0, 0),
(838, 3, 'create', 9, 9, 0, 0),
(839, 3, 'create', 8, 8, 0, 0),
(840, 3, 'create', 3, 7, 0, 0),
(841, 3, 'create', 4, 6, 0, 0),
(842, 3, 'create', 19, 5, 0, 0),
(843, 3, 'create', 10, 4, 0, 0),
(844, 3, 'create', 11, 3, 0, 0),
(845, 3, 'create', 12, 2, 0, 0),
(846, 3, 'create', 13, 1, 0, 0),
(847, 3, 'create', 20, 0, 0, 0),
(848, 3, 'edit', 1, 13, 0, 1),
(849, 3, 'edit', 6, 12, 0, 0),
(850, 3, 'edit', 2, 11, 0, 0),
(851, 3, 'edit', 7, 10, 0, 0),
(852, 3, 'edit', 9, 9, 0, 0),
(853, 3, 'edit', 8, 8, 0, 0),
(854, 3, 'edit', 3, 7, 0, 0),
(855, 3, 'edit', 4, 6, 0, 0),
(856, 3, 'edit', 19, 5, 0, 0),
(857, 3, 'edit', 10, 4, 0, 0),
(858, 3, 'edit', 11, 3, 0, 0),
(859, 3, 'edit', 12, 2, 0, 0),
(860, 3, 'edit', 13, 1, 0, 0),
(861, 3, 'edit', 20, 0, 0, 0),
(862, 3, 'edit', 20, 2, 49, 0),
(863, 3, 'edit', 9, 1, 49, 0),
(864, 3, 'edit', 3, 0, 49, 0),
(958, 2, 'create', 1, 10, 0, 1),
(959, 2, 'create', 6, 9, 0, 0),
(960, 2, 'create', 19, 8, 0, 0),
(961, 2, 'create', 2, 7, 0, 0),
(962, 2, 'create', 7, 6, 0, 0),
(963, 2, 'create', 4, 5, 0, 0),
(964, 2, 'create', 11, 4, 0, 0),
(965, 2, 'create', 12, 3, 0, 0),
(966, 2, 'create', 13, 2, 0, 0),
(967, 2, 'create', 15, 1, 0, 0),
(968, 2, 'create', 21, 0, 0, 0),
(969, 2, 'create', 10, 3, 56, 0),
(970, 2, 'create', 20, 2, 56, 0),
(971, 2, 'create', 9, 1, 56, 0),
(972, 2, 'create', 3, 0, 56, 0),
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
(1215, 2, 'edit', 1, 11, 0, 1),
(1216, 2, 'edit', 19, 10, 0, 0),
(1217, 2, 'edit', 10, 9, 0, 0),
(1218, 2, 'edit', 6, 8, 0, 0),
(1219, 2, 'edit', 2, 7, 0, 0),
(1220, 2, 'edit', 7, 6, 0, 0),
(1221, 2, 'edit', 4, 5, 0, 0),
(1222, 2, 'edit', 11, 4, 0, 0),
(1223, 2, 'edit', 12, 3, 0, 0),
(1224, 2, 'edit', 13, 2, 0, 0),
(1225, 2, 'edit', 15, 1, 0, 1),
(1226, 2, 'edit', 21, 0, 0, 0),
(1227, 2, 'edit', 20, 2, 71, 0),
(1228, 2, 'edit', 9, 1, 71, 0),
(1229, 2, 'edit', 3, 0, 71, 0),
(1355, 1, 'create', 1, 9, 0, 1),
(1356, 1, 'create', 6, 8, 0, 0),
(1357, 1, 'create', 2, 7, 0, 1),
(1358, 1, 'create', 7, 6, 0, 0),
(1359, 1, 'create', 4, 5, 0, 1),
(1360, 1, 'create', 11, 4, 0, 0),
(1361, 1, 'create', 12, 3, 0, 0),
(1362, 1, 'create', 13, 2, 0, 0),
(1363, 1, 'create', 15, 1, 0, 0),
(1364, 1, 'create', 23, 0, 0, 0),
(1365, 1, 'create', 19, 7, 79, 0),
(1366, 1, 'create', 20, 6, 79, 0),
(1367, 1, 'create', 18, 5, 79, 0),
(1368, 1, 'create', 3, 4, 79, 0),
(1369, 1, 'create', 10, 3, 79, 0),
(1370, 1, 'create', 21, 2, 79, 0),
(1371, 1, 'create', 8, 1, 79, 0),
(1372, 1, 'create', 9, 0, 79, 0),
(1373, 1, 'edit', 1, 9, 0, 1),
(1374, 1, 'edit', 6, 8, 0, 0),
(1375, 1, 'edit', 2, 7, 0, 1),
(1376, 1, 'edit', 7, 6, 0, 0),
(1377, 1, 'edit', 4, 5, 0, 1),
(1378, 1, 'edit', 19, 4, 0, 0),
(1379, 1, 'edit', 11, 3, 0, 0),
(1380, 1, 'edit', 12, 2, 0, 0),
(1381, 1, 'edit', 13, 1, 0, 0),
(1382, 1, 'edit', 15, 0, 0, 0),
(1383, 1, 'edit', 3, 6, 80, 0),
(1384, 1, 'edit', 18, 5, 80, 0),
(1385, 1, 'edit', 20, 4, 80, 0),
(1386, 1, 'edit', 10, 3, 80, 0),
(1387, 1, 'edit', 21, 2, 80, 0),
(1388, 1, 'edit', 8, 1, 80, 0),
(1389, 1, 'edit', 9, 0, 80, 0);

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
(49, 3, '\n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(56, 2, '更 多', 0, 'create'),
(63, 7, '\n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(64, 4, '\n            \n            \n            更多\n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit'),
(71, 2, '\n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            ', 0, 'edit'),
(79, 1, '更 多', 0, 'create'),
(80, 1, '\n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n   ', 0, 'edit');

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

-- --------------------------------------------------------

--
-- 表的结构 `main_notify_scheme`
--

CREATE TABLE `main_notify_scheme` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'default', 'Default', 'Default organization', 'org/default.jpg', 0, 0, 1535263464, 3),
(2, 'agile2', '敏捷组织', '敏捷开发部', 'all/20180826/20180826140446_89680.jpg', 10000, 0, 1561361581, 1);

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
(1, 'title', '网站的页面标题', 'basic', 0, '大家好', 'MasterLab', 'string', 'text', NULL, ''),
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
(45, 'attachment_dir', '附件路径', 'attachment', 0, '{{STORAGE_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下'),
(46, 'attachment_size', '附件大小(单位M)', 'attachment', 0, '10.0', '10.0', 'float', 'text', NULL, '超过大小，无法上传'),
(47, 'enbale_thum', '启用缩略图', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图'),
(48, 'enable_zip', '启用ZIP支持', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载'),
(49, 'password_strategy', '密码策略', 'password_strategy', 0, '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', ''),
(50, 'send_mailer', '发信人', 'mail', 0, 'send_mailer@xxx.com', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 0, 'Masterlab', '', 'string', 'text', NULL, ''),
(52, 'mail_host', '主机', 'mail', 0, 'smtpdm.aliyun.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', 0, '465', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 0, 'send_mailer@xxx.com', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 0, 'xxxx', '', 'string', 'text', NULL, ''),
(56, 'mail_timeout', '发送超时', 'mail', 0, '20', '', 'int', 'text', NULL, ''),
(57, 'page_layout', '页面布局', 'user_default', 0, 'float', 'fixed', 'string', 'radio', '{\"fixed\":\"固定\",\"float\":\"自适应\"}', ''),
(58, 'project_view', '项目首页', 'user_default', 0, 'sprints', 'issues', 'string', 'radio', '{\"issues\":\"事项列表\",\"summary\":\"项目摘要\",\"backlog\":\"待办事项\",\"sprints\":\"迭代列表\",\"board\":\"迭代看板\"}', ''),
(59, 'company', '公司名称', 'basic', 0, 'name', '', 'string', 'text', NULL, ''),
(60, 'company_logo', '公司logo', 'basic', 0, 'logo', '', 'string', 'text', NULL, ''),
(61, 'company_linkman', '联系人', 'basic', 0, '18002516775', '', 'string', 'text', NULL, ''),
(62, 'company_phone', '联系电话', 'basic', 0, '135255256541', '', 'string', 'text', NULL, ''),
(63, 'enable_async_mail', '是否使用异步方式发送邮件', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(64, 'enable_mail', '是否开启邮件推送', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(70, 'socket_server_host', 'MasterlabSocket服务器地址', 'mail', 0, '127.0.0.1', '127.0.0.1', 'string', 'text', NULL, ''),
(71, 'socket_server_port', 'MasterlabSocket服务器端口', 'mail', 0, '9002', '9002', 'int', 'text', NULL, '');

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
(22, '迭代-事项统计', 'sprint_issue_type_stat', 'fetchSprintIssueTypeStat', '迭代', 'issue_type_stat.png', 'list', 1, 0, 1, '', '[{\"name\":\"迭代\",\"field\":\"sprint_id\",\"type\":\"my_projects_sprint_select\",\"value\":[]}]', 0),
(23, '分配给我未解决的事项', 'unresolve_assignee_my', 'fetchUnResolveAssigneeIssues', '通用', 'assignee_my.png', 'list', 1, 1, 0, '', '[]', 0);

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
(10005, 0, '访问事项列表(已废弃)', '', 'BROWSE_ISSUES'),
(10006, 0, '创建事项', '', 'CREATE_ISSUES'),
(10007, 0, '评论', '', 'ADD_COMMENTS'),
(10008, 0, '上传和删除附件', '', 'CREATE_ATTACHMENTS'),
(10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES'),
(10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES'),
(10015, 0, '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES'),
(10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS'),
(10902, 0, '管理backlog', '', 'MANAGE_BACKLOG'),
(10903, 0, '管理sprint', '', 'MANAGE_SPRINT'),
(10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN'),
(10905, 0, '导入事项', '可以到导入excel数据到项目中', 'IMPORT_EXCEL'),
(10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL');

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
(1, 10000, 1);

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

-- --------------------------------------------------------

--
-- 表的结构 `project_issue_type_scheme_data`
--

CREATE TABLE `project_issue_type_scheme_data` (
  `id` int(11) UNSIGNED NOT NULL,
  `issue_type_scheme_id` int(11) UNSIGNED DEFAULT NULL,
  `project_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `org_path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead` int(11) UNSIGNED DEFAULT '0',
  `description` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pcounter` decimal(18,0) DEFAULT NULL,
  `default_assignee` int(11) UNSIGNED DEFAULT '0',
  `assignee_type` int(11) DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `project_main_extra`
--

CREATE TABLE `project_main_extra` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED DEFAULT '0',
  `detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

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
  `fields` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `user_issue_display_fields`
--

INSERT INTO `user_issue_display_fields` (`id`, `user_id`, `project_id`, `fields`) VALUES
(13, 1, 3, 'issue_num,issue_type,priority,module,sprint,summary,assignee,status,plan_date');

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

--
-- 转存表中的数据 `user_main`
--

INSERT INTO `user_main` (`uid`, `directory_id`, `phone`, `username`, `openid`, `status`, `first_name`, `last_name`, `display_name`, `email`, `password`, `sex`, `birthday`, `create_time`, `update_time`, `avatar`, `source`, `ios_token`, `android_token`, `version`, `token`, `last_login_time`, `is_system`, `login_counter`, `title`, `sign`) VALUES
(1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', 'phpgrid2@gmail.com', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '2019-01-13', 0, 0, 'avatar/1.png?t=1562323397', '', NULL, NULL, NULL, NULL, 1562323381, 0, 0, '管理员', '~~~交付卓越产品!');

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
  `ip` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(256, 1, 'layout', 'fixed');

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
(915, 1, 23, 1, 'first', '', 0),
(916, 1, 1, 2, 'first', '', 0),
(917, 1, 3, 3, 'first', '', 0),
(918, 1, 14, 1, 'second', '[{\"name\":\"sprint_id\",\"value\":\"8\"}]', 1);

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
(1, '默认工作流方案', '', 1),
(10100, '敏捷开发工作流方案', '敏捷开发适用', 1),
(10101, '普通的软件开发工作流方案', '', 1),
(10102, '流程管理工作流方案', '', 1);

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
-- Indexes for table `issue_effect_version`
--
ALTER TABLE `issue_effect_version`
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
-- Indexes for table `main_mail_queue`
--
ALTER TABLE `main_mail_queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seq` (`seq`) USING BTREE,
  ADD KEY `status` (`status`);

--
-- Indexes for table `main_notify_scheme`
--
ALTER TABLE `main_notify_scheme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_notify_scheme_data`
--
ALTER TABLE `main_notify_scheme_data`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `module` (`module`) USING BTREE,
  ADD KEY `module_2` (`module`,`order_weight`);

--
-- Indexes for table `main_timeline`
--
ALTER TABLE `main_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_widget`
--
ALTER TABLE `main_widget`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `_key` (`_key`) USING BTREE,
  ADD KEY `order_weight` (`order_weight`);

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
-- Indexes for table `project_main_extra`
--
ALTER TABLE `project_main_extra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE;

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
-- Indexes for table `user_issue_display_fields`
--
ALTER TABLE `user_issue_display_fields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_fields` (`user_id`,`project_id`) USING BTREE;

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
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_password`
--
ALTER TABLE `user_password`
  ADD PRIMARY KEY (`user_id`);

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
-- Indexes for table `user_posted_flag`
--
ALTER TABLE `user_posted_flag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`_date`,`ip`),
  ADD KEY `user_id_2` (`user_id`,`_date`);

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
  ADD UNIQUE KEY `user_id` (`user_id`,`_key`),
  ADD KEY `uid` (`user_id`) USING HASH;

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_widget`
--
ALTER TABLE `user_widget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`widget_id`),
  ADD KEY `order_weight` (`order_weight`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
-- 使用表AUTO_INCREMENT `issue_file_attachment`
--
ALTER TABLE `issue_file_attachment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_filter`
--
ALTER TABLE `issue_filter`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_fix_version`
--
ALTER TABLE `issue_fix_version`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_follow`
--
ALTER TABLE `issue_follow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `issue_priority`
--
ALTER TABLE `issue_priority`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10101;

--
-- 使用表AUTO_INCREMENT `issue_type`
--
ALTER TABLE `issue_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme`
--
ALTER TABLE `issue_type_scheme`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `issue_type_scheme_data`
--
ALTER TABLE `issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- 使用表AUTO_INCREMENT `issue_ui`
--
ALTER TABLE `issue_ui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1390;

--
-- 使用表AUTO_INCREMENT `issue_ui_tab`
--
ALTER TABLE `issue_ui_tab`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- 使用表AUTO_INCREMENT `main_setting`
--
ALTER TABLE `main_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- 使用表AUTO_INCREMENT `main_timeline`
--
ALTER TABLE `main_timeline`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `main_widget`
--
ALTER TABLE `main_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10907;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_issue_type_scheme_data`
--
ALTER TABLE `project_issue_type_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `project_main_extra`
--
ALTER TABLE `project_main_extra`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `user_login_log`
--
ALTER TABLE `user_login_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_main`
--
ALTER TABLE `user_main`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12138;

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- 使用表AUTO_INCREMENT `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_widget`
--
ALTER TABLE `user_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=919;

--
-- 使用表AUTO_INCREMENT `workflow`
--
ALTER TABLE `workflow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10105;

--
-- 使用表AUTO_INCREMENT `workflow_scheme_data`
--
ALTER TABLE `workflow_scheme_data`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10337;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
