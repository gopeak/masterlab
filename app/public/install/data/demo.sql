-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-02-08 12:56:46
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
-- 数据库： `masterlab_dev`
--

--
-- 转存表中的数据 `agile_board`
--

INSERT INTO `agile_board` (`id`, `name`, `project_id`, `type`, `is_filter_backlog`, `is_filter_closed`, `weight`, `range_type`, `range_data`, `is_system`) VALUES
(1, '进行中的迭代', 0, 'status', 0, 1, 99999, 'current_sprint', '', 1),
(2, '整个项目', 0, 'status', 0, 1, 99998, 'all', '', 1);

--
-- 转存表中的数据 `agile_board_column`
--

INSERT INTO `agile_board_column` (`id`, `name`, `board_id`, `data`, `weight`) VALUES
(1, '准 备', 1, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 3),
(2, '进行中', 1, '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 2),
(3, '已完成', 1, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 1),
(4, '准备中', 2, '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0),
(5, '进行中', 2, '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0),
(6, '已完成', 2, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0);

--
-- 转存表中的数据 `agile_sprint`
--

INSERT INTO `agile_sprint` (`id`, `project_id`, `name`, `description`, `active`, `status`, `order_weight`, `start_date`, `end_date`, `target`, `inspect`, `review`) VALUES
(1, 1, '1.0迭代', '', 1, 1, 0, '2020-01-17', '2020-03-31', '', '', '');

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

--
-- 转存表中的数据 `issue_description_template`
--

INSERT INTO `issue_description_template` (`id`, `name`, `content`, `created`, `updated`) VALUES
(1, 'bug', '\r\n这里输入对bug做出清晰简洁的描述.\r\n\r\n**重现步骤**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n4. xxxxxx\r\n\r\n**期望结果**\r\n简洁清晰的描述期望结果\r\n\r\n**实际结果**\r\n简述实际看到的结果，这里可以配上截图\r\n\r\n\r\n**附加说明**\r\n附加或额外的信息\r\n', 0, 1562299460),
(2, '新功能', '**功能描述**\r\n一句话简洁清晰的描述功能，例如：\r\n作为一个<用户角色>，在<某种条件或时间>下，我想要<完成活动>，以便于<实现价值>\r\n\r\n**功能点**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n\r\n**规则和影响**\r\n1. xx\r\n2. xxx\r\n\r\n**解决方案**\r\n 解决方案的描述\r\n\r\n**备用方案**\r\n 备用方案的描述\r\n\r\n**附加内容**\r\n\r\n', 0, 1562300466);

--
-- 转存表中的数据 `issue_extra_worker_day`
--

INSERT INTO `issue_extra_worker_day` (`id`, `project_id`, `day`, `name`) VALUES
(1, 0, '2020-01-25', ''),
(2, 0, '2020-01-18', '');

--
-- 转存表中的数据 `issue_file_attachment`
--

INSERT INTO `issue_file_attachment` (`id`, `uuid`, `issue_id`, `tmp_issue_id`, `mime_type`, `origin_name`, `file_name`, `created`, `file_size`, `author`, `file_ext`) VALUES
(1, '7436abdc-44a0-40d0-8e52-caa2be27d765', 0, '', 'image/png', 'project_example_icon.png', 'project_image/20200117/20200117154554_20263.png', 1579247154, 1136, 1, 'png');

--
-- 转存表中的数据 `issue_label`
--

INSERT INTO `issue_label` (`id`, `project_id`, `title`, `color`, `bg_color`) VALUES
(1, 0, '错 误', '#FFFFFF', '#FF0000'),
(2, 0, '成 功', '#FFFFFF', '#69D100'),
(3, 0, '警 告', '#FFFFFF', '#F0AD4E');

--
-- 转存表中的数据 `issue_main`
--

INSERT INTO `issue_main` (`id`, `pkey`, `issue_num`, `project_id`, `issue_type`, `creator`, `modifier`, `reporter`, `assignee`, `summary`, `description`, `environment`, `priority`, `resolve`, `status`, `created`, `updated`, `start_date`, `due_date`, `duration`, `resolve_date`, `module`, `milestone`, `sprint`, `weight`, `backlog_weight`, `sprint_weight`, `assistants`, `level`, `master_id`, `have_children`, `followed_count`, `comment_count`, `progress`, `depends`, `gant_proj_sprint_weight`, `gant_proj_module_weight`, `gant_sprint_weight`, `gant_hide`, `is_start_milestone`, `is_end_milestone`) VALUES
(1, 'example', '1', 1, 2, 1, 0, 1, 12164, '数据库设计', '**功能描述**\r\n一句话简洁清晰的描述功能，例如：\r\n作为一个开发者，在项目开启后，我想要项目的数据存储起来，以便于接下来的编程\r\n\r\n**功能点**\r\n1. 需求分析\r\n2. 表结构设计\r\n3. er设计\r\n\r\n**规则和影响**\r\n1. 整个项目的基础\r\n\r\n**解决方案**\r\n 解决方案的描述\r\n\r\n**备用方案**\r\n Mysql8\r\n\r\n\r\n\r\n', '', 3, 2, 1, 1579249719, 1579249719, '2020-01-17', '2020-01-30', 12, NULL, 1, NULL, 1, 80, 0, 300000, '', 0, 0, 0, 0, 0, 0, '', 100000, 0, 0, 0, 0, 0),
(2, 'example', '2', 1, 2, 1, 1, 1, 12164, '服务器端开发框架设计', '**功能描述**\r\n\r\n作为一个后端开发工程师，在项目开启下，为了实现项目的各项功能，以便于早日完成项目预期\r\n\r\n**功能点**\r\n1. 开发语言的确定\r\n2. 开发框架的评估和分析\r\n3. 开发框架的试用\r\n4. 开发框架的确认\r\n5. 开发框架的培训\r\n\r\n**规则和影响**\r\n1. 后端开发人员都要使用\r\n\r\n\r\n**解决方案**\r\n 解决方案的描述\r\n\r\n**备用方案**\r\n spring boot \r\n\r\n\r\n', '', 2, 2, 1, 1579250062, 1579250062, '2020-01-20', '2020-01-31', 11, NULL, 1, NULL, 1, 80, 0, 400000, '', 0, 0, 0, 0, 0, 0, '', 200000, 0, 0, 0, 0, 0),
(3, 'example', '3', 1, 2, 1, 1, 1, 12168, 'UI设计', '**功能描述**\r\n根据原型进行界面设计\r\n\r\n**功能点**\r\n1. xx\r\n2. xxx\r\n3. xxxx\r\n\r\n**规则和影响**\r\n1. xx\r\n2. xxx\r\n\r\n**解决方案**\r\n 解决方案的描述\r\n\r\n**备用方案**\r\n 备用方案的描述\r\n\r\n**附加内容**\r\n\r\n', '', 3, 2, 1, 1579423228, 1579423228, '2020-01-20', '2020-01-24', 5, NULL, 3, NULL, 1, 60, 0, 100000, '', 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0),
(4, 'example', '4', 1, 3, 1, 1, 1, 12166, '测试用例', '根据原型设计进行测试用例的编写\r\n', '', 2, 2, 1, 1579423320, 1579423320, '2020-01-19', '2020-01-24', 5, NULL, 6, NULL, 1, 0, 0, 200000, '', 0, 0, 0, 0, 0, 0, '', 100000, 0, 0, 0, 0, 0);

--
-- 转存表中的数据 `issue_priority`
--

INSERT INTO `issue_priority` (`id`, `sequence`, `name`, `_key`, `description`, `iconurl`, `status_color`, `font_awesome`, `is_system`) VALUES
(1, 1, '紧 急', 'very_import', '阻塞开发或测试的工作进度，或影响系统无法运行的错误', '/images/icons/priorities/blocker.png', 'red', NULL, 1),
(2, 2, '重 要', 'import', '系统崩溃，丢失数据或内存溢出等严重错误、或者必需完成的任务', '/images/icons/priorities/critical.png', '#cc0000', NULL, 1),
(3, 3, '高', 'high', '主要的功能无效或流程异常', '/images/icons/priorities/major.png', '#ff0000', NULL, 1),
(4, 4, '中', 'normal', '功能部分无效或对现有系统的改进', '/images/icons/priorities/minor.png', '#006600', NULL, 1),
(5, 5, '低', 'low', '不影响功能和流程的问题', '/images/icons/priorities/trivial.png', '#003300', NULL, 1);

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

--
-- 转存表中的数据 `issue_type_scheme`
--

INSERT INTO `issue_type_scheme` (`id`, `name`, `description`, `is_default`) VALUES
(1, '默认事项方案', '系统默认的事项方案,但没有设定或事项错误时使用该方案', 1),
(2, '敏捷开发事项方案', '敏捷开发适用的方案', 1),
(5, '任务管理事项解决方案', '任务管理', 0);

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
(1495, 1, 'create', 1, 9, 0, 1),
(1496, 1, 'create', 6, 8, 0, 0),
(1497, 1, 'create', 2, 7, 0, 1),
(1498, 1, 'create', 7, 6, 0, 0),
(1499, 1, 'create', 4, 5, 0, 1),
(1500, 1, 'create', 11, 4, 0, 0),
(1501, 1, 'create', 12, 3, 0, 0),
(1502, 1, 'create', 13, 2, 0, 0),
(1503, 1, 'create', 15, 1, 0, 0),
(1504, 1, 'create', 23, 0, 0, 0),
(1505, 1, 'create', 19, 7, 84, 0),
(1506, 1, 'create', 10, 6, 84, 0),
(1507, 1, 'create', 20, 5, 84, 0),
(1508, 1, 'create', 18, 4, 84, 0),
(1509, 1, 'create', 3, 3, 84, 0),
(1510, 1, 'create', 21, 2, 84, 0),
(1511, 1, 'create', 8, 1, 84, 0),
(1512, 1, 'create', 9, 0, 84, 0),
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
(1562, 3, 'edit', 3, 0, 86, 0);

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
(84, 1, '更 多', 0, 'create'),
(85, 1, '\n            \n            \n            \n            \n            \n            \n            \n            \n            更 多\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            ', 0, 'edit'),
(86, 3, '\n            \n            \n            \n            \n            其他\n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        \n             \n            \n        ', 0, 'edit');

--
-- 转存表中的数据 `log_operating`
--

INSERT INTO `log_operating` (`id`, `project_id`, `module`, `obj_id`, `uid`, `user_name`, `real_name`, `page`, `pre_status`, `cur_status`, `action`, `remark`, `pre_data`, `cur_data`, `ip`, `time`) VALUES
(1, 0, '项目', 0, 1, 'master', 'Master', '/project/main/create', NULL, NULL, '新增', '新建项目', '[]', '{\"name\":\"\\u793a\\u4f8b\\u9879\\u76ee\",\"org_id\":\"1\",\"key\":\"example\",\"lead\":\"1\",\"description\":\"Masterlab\\u7684\\u793a\\u4f8b\\u9879\\u76ee\",\"type\":10,\"category\":0,\"url\":\"\",\"create_time\":1579247230,\"create_uid\":\"1\",\"avatar\":\"project_image\\/20200117\\/20200117154554_20263.png\",\"detail\":\"\\u8be5\\u9879\\u76ee\\u5c55\\u793a\\u4e86\\uff0c\\u5982\\u4f55\\u5c06\\u654f\\u6377\\u5f00\\u53d1\\u548cMasterlab\\u7ed3\\u5408\\u5728\\u4e00\\u8d77.\\r\\n\",\"org_path\":\"default\"}', '127.0.0.1', 1579247230),
(2, 1, '项目', 0, 1, 'master', 'Master', '/project/role/add_project_member_roles', NULL, NULL, '新增', '添加项目角色的用户', '[]', '{\"user_id\":12164,\"project_id\":\"1\",\"role_id\":\"2\"}', '127.0.0.1', 1579248827),
(3, 1, '项目', 0, 1, 'master', 'Master', '/project/role/add_project_member_roles', NULL, NULL, '新增', '添加项目角色的用户', '[]', '{\"user_id\":12165,\"project_id\":\"1\",\"role_id\":\"2\"}', '127.0.0.1', 1579248838),
(4, 1, '项目', 0, 1, 'master', 'Master', '/project/role/add_project_member_roles', NULL, NULL, '新增', '添加项目角色的用户', '[]', '{\"user_id\":12167,\"project_id\":\"1\",\"role_id\":\"2\"}', '127.0.0.1', 1579248846),
(5, 1, '项目', 0, 1, 'master', 'Master', '/project/role/add_project_member_roles', NULL, NULL, '新增', '添加项目角色的用户', '[]', '{\"user_id\":12166,\"project_id\":\"1\",\"role_id\":\"5\"}', '127.0.0.1', 1579248852),
(6, 1, '项目', 0, 1, 'master', 'Master', '/project/role/add_project_member_roles', NULL, NULL, '新增', '添加项目角色的用户', '[]', '{\"user_id\":12168,\"project_id\":\"1\",\"role_id\":\"2\"}', '127.0.0.1', 1579248857),
(7, 1, '项目', 0, 1, 'master', 'Master', '/project/module/add?project_id=1', NULL, NULL, '新增', '新建项目模块', '[]', '{\"project_id\":1,\"name\":\"\\u540e\\u7aef\\u67b6\\u6784\",\"description\":\"\",\"lead\":0,\"default_assignee\":0,\"ctime\":1579249107}', '127.0.0.1', 1579249107),
(8, 1, '项目', 0, 1, 'master', 'Master', '/project/module/add?project_id=1', NULL, NULL, '新增', '新建项目模块', '[]', '{\"project_id\":1,\"name\":\"\\u524d\\u7aef\\u67b6\\u6784\",\"description\":\"\",\"lead\":0,\"default_assignee\":0,\"ctime\":1579249118}', '127.0.0.1', 1579249118),
(9, 1, '项目', 0, 1, 'master', 'Master', '/project/module/add?project_id=1', NULL, NULL, '新增', '新建项目模块', '[]', '{\"project_id\":1,\"name\":\"\\u7528\\u6237\",\"description\":\"\",\"lead\":0,\"default_assignee\":0,\"ctime\":1579249127}', '127.0.0.1', 1579249127),
(10, 1, '项目', 0, 1, 'master', 'Master', '/project/module/add?project_id=1', NULL, NULL, '新增', '新建项目模块', '[]', '{\"project_id\":1,\"name\":\"\\u9996\\u9875\",\"description\":\"\",\"lead\":0,\"default_assignee\":0,\"ctime\":1579249131}', '127.0.0.1', 1579249131),
(11, 1, '项目', 0, 1, 'master', 'Master', '/project/module/add?project_id=1', NULL, NULL, '新增', '新建项目模块', '[]', '{\"project_id\":1,\"name\":\"\\u5f15\\u64ce\",\"description\":\"\",\"lead\":0,\"default_assignee\":0,\"ctime\":1579249144}', '127.0.0.1', 1579249144),
(12, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0\",\"description\":\"\",\"sequence\":0,\"start_date\":1579190400,\"release_date\":false,\"url\":\"\"}', '127.0.0.1', 1579249164),
(13, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"1\",\"project_id\":\"1\",\"name\":\"1.0\",\"description\":\"\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1579190400\",\"release_date\":\"0\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1579249167),
(14, 0, '用户', 1, 1, 'master', 'Master', '/user/setProfile', NULL, NULL, '编辑', '用户修改个人资料', '{\"uid\":\"1\",\"directory_id\":\"1\",\"phone\":\"18002510000\",\"username\":\"master\",\"openid\":\"q7a752741f667201b54780c926faec4e\",\"status\":\"1\",\"first_name\":\"\",\"last_name\":\"master\",\"display_name\":\"Master\",\"email\":\"master@masterlab.vip\",\"password\":\"$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm\",\"sex\":\"1\",\"birthday\":\"2019-01-13\",\"create_time\":\"0\",\"update_time\":\"0\",\"avatar\":\"avatar\\/1.png?t=1579249493\",\"source\":\"\",\"ios_token\":null,\"android_token\":null,\"version\":null,\"token\":null,\"last_login_time\":\"1579236329\",\"is_system\":\"0\",\"login_counter\":\"0\",\"title\":\"\\u7ba1\\u7406\\u5458\",\"sign\":\"~~~\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\"}', '{\"display_name\":\"Master\",\"sex\":1,\"sign\":\"~~~\\u4ea4\\u4ed8\\u5353\\u8d8a\\u4ea7\\u54c1!\",\"birthday\":\"2019-01-13\",\"avatar\":\"avatar\\/1.png?t=1579249493\"}', '127.0.0.1', 1579249493),
(15, 1, '事项', 1, 1, 'master', 'Master', '/issue/main/add', NULL, NULL, '新增', '新增事项', '[]', '{\"summary\":\"\\u6570\\u636e\\u5e93\\u8bbe\\u8ba1\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1579249719,\"updated\":1579249719,\"project_id\":1,\"issue_type\":2,\"status\":1,\"priority\":3,\"resolve\":\"2\",\"assignee\":12164,\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\u4e00\\u53e5\\u8bdd\\u7b80\\u6d01\\u6e05\\u6670\\u7684\\u63cf\\u8ff0\\u529f\\u80fd\\uff0c\\u4f8b\\u5982\\uff1a\\r\\n\\u4f5c\\u4e3a\\u4e00\\u4e2a\\u5f00\\u53d1\\u8005\\uff0c\\u5728\\u9879\\u76ee\\u5f00\\u542f\\u540e\\uff0c\\u6211\\u60f3\\u8981\\u9879\\u76ee\\u7684\\u6570\\u636e\\u5b58\\u50a8\\u8d77\\u6765\\uff0c\\u4ee5\\u4fbf\\u4e8e\\u63a5\\u4e0b\\u6765\\u7684\\u7f16\\u7a0b\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. \\u9700\\u6c42\\u5206\\u6790\\r\\n2. \\u8868\\u7ed3\\u6784\\u8bbe\\u8ba1\\r\\n3. er\\u8bbe\\u8ba1\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. \\u6574\\u4e2a\\u9879\\u76ee\\u7684\\u57fa\\u7840\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u5907\\u7528\\u65b9\\u6848**\\r\\n Mysql8\\r\\n\\r\\n\\r\\n\\r\\n\",\"module\":\"1\",\"environment\":\"\",\"sprint\":1,\"weight\":80,\"start_date\":\"2020-0', '127.0.0.1', 1579249719),
(16, 1, '事项', 2, 1, 'master', 'Master', '/issue/main/add', NULL, NULL, '新增', '新增事项', '[]', '{\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u5f00\\u53d1\\u6846\\u67b6\\u8bbe\\u8ba1\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1579250062,\"updated\":1579250062,\"project_id\":1,\"issue_type\":2,\"status\":1,\"priority\":2,\"resolve\":\"2\",\"assignee\":12164,\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\r\\n\\u4f5c\\u4e3a\\u4e00\\u4e2a\\u540e\\u7aef\\u5f00\\u53d1\\u5de5\\u7a0b\\u5e08\\uff0c\\u5728\\u9879\\u76ee\\u5f00\\u542f\\u4e0b\\uff0c\\u4e3a\\u4e86\\u5b9e\\u73b0\\u9879\\u76ee\\u7684\\u5404\\u9879\\u529f\\u80fd\\uff0c\\u4ee5\\u4fbf\\u4e8e\\u65e9\\u65e5\\u5b8c\\u6210\\u9879\\u76ee\\u9884\\u671f\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. \\u5f00\\u53d1\\u8bed\\u8a00\\u7684\\u786e\\u5b9a\\r\\n2. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u8bc4\\u4f30\\u548c\\u5206\\u6790\\r\\n3. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u8bd5\\u7528\\r\\n4. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u786e\\u8ba4\\r\\n5. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u57f9\\u8bad\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. \\u540e\\u7aef\\u5f00\\u53d1\\u4eba\\u5458\\u90fd\\u8981\\u4f7f\\u7528\\r\\n\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u', '127.0.0.1', 1579250062),
(17, 1, '事项', 2, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"2\",\"pkey\":\"example\",\"issue_num\":\"2\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u5f00\\u53d1\\u6846\\u67b6\\u8bbe\\u8ba1\",\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\r\\n\\u4f5c\\u4e3a\\u4e00\\u4e2a\\u540e\\u7aef\\u5f00\\u53d1\\u5de5\\u7a0b\\u5e08\\uff0c\\u5728\\u9879\\u76ee\\u5f00\\u542f\\u4e0b\\uff0c\\u4e3a\\u4e86\\u5b9e\\u73b0\\u9879\\u76ee\\u7684\\u5404\\u9879\\u529f\\u80fd\\uff0c\\u4ee5\\u4fbf\\u4e8e\\u65e9\\u65e5\\u5b8c\\u6210\\u9879\\u76ee\\u9884\\u671f\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. \\u5f00\\u53d1\\u8bed\\u8a00\\u7684\\u786e\\u5b9a\\r\\n2. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u8bc4\\u4f30\\u548c\\u5206\\u6790\\r\\n3. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u8bd5\\u7528\\r\\n4. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u786e\\u8ba4\\r\\n5. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u57f9\\u8bad\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. \\u540e\\u7aef\\u5f00\\u53d1\\u4eba\\u5458\\u90fd\\u8981\\u4f7f\\u7528\\r\\n\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u63cf\\', '{\"id\":\"2\",\"pkey\":\"example\",\"issue_num\":\"2\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12164\",\"summary\":\"\\u670d\\u52a1\\u5668\\u7aef\\u5f00\\u53d1\\u6846\\u67b6\\u8bbe\\u8ba1\",\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\r\\n\\u4f5c\\u4e3a\\u4e00\\u4e2a\\u540e\\u7aef\\u5f00\\u53d1\\u5de5\\u7a0b\\u5e08\\uff0c\\u5728\\u9879\\u76ee\\u5f00\\u542f\\u4e0b\\uff0c\\u4e3a\\u4e86\\u5b9e\\u73b0\\u9879\\u76ee\\u7684\\u5404\\u9879\\u529f\\u80fd\\uff0c\\u4ee5\\u4fbf\\u4e8e\\u65e9\\u65e5\\u5b8c\\u6210\\u9879\\u76ee\\u9884\\u671f\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. \\u5f00\\u53d1\\u8bed\\u8a00\\u7684\\u786e\\u5b9a\\r\\n2. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u8bc4\\u4f30\\u548c\\u5206\\u6790\\r\\n3. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u8bd5\\u7528\\r\\n4. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u786e\\u8ba4\\r\\n5. \\u5f00\\u53d1\\u6846\\u67b6\\u7684\\u57f9\\u8bad\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. \\u540e\\u7aef\\u5f00\\u53d1\\u4eba\\u5458\\u90fd\\u8981\\u4f7f\\u7528\\r\\n\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u63cf\\', '127.0.0.1', 1579250089),
(18, 1, '事项', 3, 1, 'master', 'Master', '/issue/main/add', NULL, NULL, '新增', '新增事项', '[]', '{\"summary\":\"UI\\u8bbe\\u8ba1\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1579423228,\"updated\":1579423228,\"project_id\":1,\"issue_type\":2,\"status\":1,\"priority\":3,\"resolve\":\"2\",\"assignee\":12168,\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\u6839\\u636e\\u539f\\u578b\\u8fdb\\u884c\\u754c\\u9762\\u8bbe\\u8ba1\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. xx\\r\\n2. xxx\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u5907\\u7528\\u65b9\\u6848**\\r\\n \\u5907\\u7528\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u9644\\u52a0\\u5185\\u5bb9**\\r\\n\\r\\n\",\"module\":\"\",\"environment\":\"\",\"sprint\":1,\"weight\":60,\"start_date\":\"2020-01-20\",\"due_date\":\"2020-01-24\",\"duration\":5,\"progress\":0,\"is_start_milestone\":0,\"is_end_milestone\":0}', '127.0.0.1', 1579423228),
(19, 1, '事项', 3, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"3\",\"pkey\":\"example\",\"issue_num\":\"3\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"12168\",\"summary\":\"UI\\u8bbe\\u8ba1\",\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\u6839\\u636e\\u539f\\u578b\\u8fdb\\u884c\\u754c\\u9762\\u8bbe\\u8ba1\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. xx\\r\\n2. xxx\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u5907\\u7528\\u65b9\\u6848**\\r\\n \\u5907\\u7528\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u9644\\u52a0\\u5185\\u5bb9**\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423228\",\"updated\":\"1579423228\",\"start_date\":\"2020-01-20\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"60\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",', '{\"id\":\"3\",\"pkey\":\"example\",\"issue_num\":\"3\",\"project_id\":\"1\",\"issue_type\":\"2\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12168\",\"summary\":\"UI\\u8bbe\\u8ba1\",\"description\":\"**\\u529f\\u80fd\\u63cf\\u8ff0**\\r\\n\\u6839\\u636e\\u539f\\u578b\\u8fdb\\u884c\\u754c\\u9762\\u8bbe\\u8ba1\\r\\n\\r\\n**\\u529f\\u80fd\\u70b9**\\r\\n1. xx\\r\\n2. xxx\\r\\n3. xxxx\\r\\n\\r\\n**\\u89c4\\u5219\\u548c\\u5f71\\u54cd**\\r\\n1. xx\\r\\n2. xxx\\r\\n\\r\\n**\\u89e3\\u51b3\\u65b9\\u6848**\\r\\n \\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u5907\\u7528\\u65b9\\u6848**\\r\\n \\u5907\\u7528\\u65b9\\u6848\\u7684\\u63cf\\u8ff0\\r\\n\\r\\n**\\u9644\\u52a0\\u5185\\u5bb9**\\r\\n\\r\\n\",\"environment\":\"\",\"priority\":\"3\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423228\",\"updated\":\"1579423228\",\"start_date\":\"2020-01-20\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"3\",\"milestone\":null,\"sprint\":\"1\",\"weight\":\"60\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",', '127.0.0.1', 1579423252),
(20, 1, '事项', 4, 1, 'master', 'Master', '/issue/main/add', NULL, NULL, '新增', '新增事项', '[]', '{\"summary\":\"\\u6d4b\\u8bd5\\u7528\\u4f8b\",\"creator\":\"1\",\"reporter\":\"1\",\"created\":1579423320,\"updated\":1579423320,\"project_id\":1,\"issue_type\":3,\"status\":1,\"priority\":2,\"resolve\":\"2\",\"assignee\":12166,\"description\":\"\\u6839\\u636e\\u539f\\u578b\\u8bbe\\u8ba1\\u8fdb\\u884c\\u6d4b\\u8bd5\\u7528\\u4f8b\\u7684\\u7f16\\u5199\\r\\n\",\"module\":\"\",\"start_date\":\"2020-01-19\",\"due_date\":\"2020-01-24\",\"duration\":5,\"is_start_milestone\":0,\"is_end_milestone\":0}', '127.0.0.1', 1579423320),
(21, 1, '项目', 0, 1, 'master', 'Master', '/project/module/add?project_id=1', NULL, NULL, '新增', '新建项目模块', '[]', '{\"project_id\":1,\"name\":\"\\u6d4b\\u8bd5\",\"description\":\"\",\"lead\":0,\"default_assignee\":0,\"ctime\":1579423336}', '127.0.0.1', 1579423336),
(22, 1, '事项', 4, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"4\",\"pkey\":\"example\",\"issue_num\":\"4\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"0\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"\\u6d4b\\u8bd5\\u7528\\u4f8b\",\"description\":\"\\u6839\\u636e\\u539f\\u578b\\u8bbe\\u8ba1\\u8fdb\\u884c\\u6d4b\\u8bd5\\u7528\\u4f8b\\u7684\\u7f16\\u5199\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423320\",\"updated\":\"1579423320\",\"start_date\":\"2020-01-19\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"0\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_proj_sprint_weight\":\"0\",\"gant_proj_module_weight\":\"0\",\"gant_sprint_weight\":\"0\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"4\",\"pkey\":\"example\",\"issue_num\":\"4\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"\\u6d4b\\u8bd5\\u7528\\u4f8b\",\"description\":\"\\u6839\\u636e\\u539f\\u578b\\u8bbe\\u8ba1\\u8fdb\\u884c\\u6d4b\\u8bd5\\u7528\\u4f8b\\u7684\\u7f16\\u5199\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423320\",\"updated\":\"1579423320\",\"start_date\":\"2020-01-19\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"6\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_proj_sprint_weight\":\"0\",\"gant_proj_module_weight\":\"0\",\"gant_sprint_weight\":\"0\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1579423346),
(23, 1, '事项', 4, 1, 'master', 'Master', '/issue/main/update', NULL, NULL, '编辑', '修改事项', '{\"id\":\"4\",\"pkey\":\"example\",\"issue_num\":\"4\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"\\u6d4b\\u8bd5\\u7528\\u4f8b\",\"description\":\"\\u6839\\u636e\\u539f\\u578b\\u8bbe\\u8ba1\\u8fdb\\u884c\\u6d4b\\u8bd5\\u7528\\u4f8b\\u7684\\u7f16\\u5199\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423320\",\"updated\":\"1579423320\",\"start_date\":\"2020-01-19\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"6\",\"milestone\":null,\"sprint\":\"0\",\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_proj_sprint_weight\":\"100000\",\"gant_proj_module_weight\":\"0\",\"gant_sprint_weight\":\"0\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '{\"id\":\"4\",\"pkey\":\"example\",\"issue_num\":\"4\",\"project_id\":\"1\",\"issue_type\":\"3\",\"creator\":\"1\",\"modifier\":\"1\",\"reporter\":\"1\",\"assignee\":\"12166\",\"summary\":\"\\u6d4b\\u8bd5\\u7528\\u4f8b\",\"description\":\"\\u6839\\u636e\\u539f\\u578b\\u8bbe\\u8ba1\\u8fdb\\u884c\\u6d4b\\u8bd5\\u7528\\u4f8b\\u7684\\u7f16\\u5199\\r\\n\",\"environment\":\"\",\"priority\":\"2\",\"resolve\":\"2\",\"status\":\"1\",\"created\":\"1579423320\",\"updated\":\"1579423320\",\"start_date\":\"2020-01-19\",\"due_date\":\"2020-01-24\",\"duration\":\"5\",\"resolve_date\":null,\"module\":\"6\",\"milestone\":null,\"sprint\":1,\"weight\":\"0\",\"backlog_weight\":\"0\",\"sprint_weight\":\"0\",\"assistants\":\"\",\"level\":\"0\",\"master_id\":\"0\",\"have_children\":\"0\",\"followed_count\":\"0\",\"comment_count\":\"0\",\"progress\":\"0\",\"depends\":\"\",\"gant_proj_sprint_weight\":\"100000\",\"gant_proj_module_weight\":\"0\",\"gant_sprint_weight\":\"0\",\"gant_hide\":\"0\",\"is_start_milestone\":\"0\",\"is_end_milestone\":\"0\"}', '127.0.0.1', 1579423447),
(24, 1, '项目', 0, 1, 'master', 'Master', '/project/role/add?project_id=1', NULL, NULL, '新增', '添加项目角色', '[]', '{\"is_system\":\"0\",\"project_id\":1,\"name\":\"Reviewers\",\"description\":\"\\u4ee3\\u7801\\u5ba1\\u6838\"}', '127.0.0.1', 1581049696),
(25, 1, '项目', 0, 1, 'master', 'Master', '/project/role/delete?id=6&_csrftoken=e07cAAcJUlYJBFZWAwxRUFVVVFFVXgAEUwECAghEQVJZY1BcBAs6CXB4VlZZ', NULL, NULL, '删除', '删除项目角色', '{\"id\":\"6\",\"project_id\":\"1\",\"name\":\"Reviewers\",\"description\":\"\\u4ee3\\u7801\\u5ba1\\u6838\",\"is_system\":\"0\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"is_system\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581049750),
(26, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.0.0\",\"description\":\"Version 1.0.0.0\",\"sequence\":0,\"start_date\":1577808000,\"release_date\":1581004800,\"url\":\"\"}', '127.0.0.1', 1581049860),
(27, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.1.0\",\"description\":\"Version 1.0.1.0\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1585584000,\"url\":\"\"}', '127.0.0.1', 1581050192),
(28, 1, '项目', 0, 1, 'master', 'Master', '/project/version/update', NULL, NULL, '编辑', '修改项目版本', '{\"id\":\"3\",\"project_id\":\"1\",\"name\":\"1.0.1.0\",\"description\":\"Version 1.0.1.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1585584000\"}', '{\"name\":\"1.0.1\",\"description\":\"Version 1.0.1\",\"start_date\":1581004800,\"release_date\":1585584000}', '127.0.0.1', 1581050294),
(29, 1, '项目', 0, 1, 'master', 'Master', '/project/version/update', NULL, NULL, '编辑', '修改项目版本', '{\"id\":\"2\",\"project_id\":\"1\",\"name\":\"1.0.0.0\",\"description\":\"Version 1.0.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1577808000\",\"release_date\":\"1581004800\"}', '{\"name\":\"1.0.0\",\"description\":\"Version 1.0.0\",\"start_date\":1577808000,\"release_date\":1581004800}', '127.0.0.1', 1581050306),
(30, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.2\",\"description\":\"Version 1.0.2\",\"sequence\":0,\"start_date\":1585670400,\"release_date\":1588262400,\"url\":\"\"}', '127.0.0.1', 1581050343),
(31, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"3\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.1\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1585584000\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581050946),
(32, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"2\",\"project_id\":\"1\",\"name\":\"1.0.0\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1577808000\",\"release_date\":\"1581004800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581050949),
(33, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"4\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"Version 1.0.2\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1585670400\",\"release_date\":\"1588262400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581050957),
(34, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"5\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581051099),
(35, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"6\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"Version 1.0.2\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1583510400\",\"release_date\":\"1586188800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581051103),
(36, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.1\",\"description\":\"Version 1.0.1\",\"sequence\":0,\"start_date\":1583510400,\"release_date\":1586188800,\"url\":\"\"}', '127.0.0.1', 1581051179),
(37, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.2\",\"description\":\"Version 1.0.2\",\"sequence\":0,\"start_date\":1586188800,\"release_date\":1588780800,\"url\":\"\"}', '127.0.0.1', 1581051502),
(38, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.3\",\"description\":\"Version 1.0.3\",\"sequence\":0,\"start_date\":1591459200,\"release_date\":1594051200,\"url\":\"\"}', '127.0.0.1', 1581051794),
(39, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.4\",\"description\":\"Version 1.0.4\",\"sequence\":0,\"start_date\":1591459200,\"release_date\":1594051200,\"url\":\"\"}', '127.0.0.1', 1581051874),
(40, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"9\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"Version 1.0.2\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1586188800\",\"release_date\":\"1588780800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581052054),
(41, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"8\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.1\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1583510400\",\"release_date\":\"1586188800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581052062),
(42, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"7\",\"project_id\":\"1\",\"name\":\"1.0.0\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581052067),
(43, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"10\",\"project_id\":\"1\",\"name\":\"1.0.3\",\"description\":\"Version 1.0.3\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1591459200\",\"release_date\":\"1594051200\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581052119),
(44, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"11\",\"project_id\":\"1\",\"name\":\"1.0.4\",\"description\":\"Version 1.0.4\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1591459200\",\"release_date\":\"1594051200\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581052126),
(45, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1583510400,\"url\":\"\"}', '127.0.0.1', 1581052154),
(46, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.2\",\"description\":\"Version 1.0.0\",\"sequence\":0,\"start_date\":1583510400,\"release_date\":1586188800,\"url\":\"\"}', '127.0.0.1', 1581052775),
(47, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"13\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1583510400\",\"release_date\":\"1586188800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581056562),
(48, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"12\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581056567),
(49, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.1\",\"description\":\"Version 1.0.1\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1583510400,\"url\":\"\"}', '127.0.0.1', 1581056590),
(50, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.2\",\"description\":\"Version 1.0.1.0\",\"sequence\":0,\"start_date\":1583510400,\"release_date\":1586188800,\"url\":\"\"}', '127.0.0.1', 1581056649),
(51, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"15\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"Version 1.0.1.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1583510400\",\"release_date\":\"1586188800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581056658),
(52, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"14\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.1\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581056659),
(53, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1583510400,\"url\":\"\"}', '127.0.0.1', 1581056749),
(54, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.2\",\"description\":\"\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1581004800,\"url\":\"\"}', '127.0.0.1', 1581056837),
(55, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"16\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581056879),
(56, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"17\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1581004800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581056883),
(57, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.0\",\"description\":\"Version 1.0.0\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1583510400,\"url\":\"\"}', '127.0.0.1', 1581056901),
(58, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1583510400,\"url\":\"\"}', '127.0.0.1', 1581056922),
(59, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.2\",\"description\":\"Version 1.0.0\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1583510400,\"url\":\"\"}', '127.0.0.1', 1581056925),
(60, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.3\",\"description\":\"\",\"sequence\":0,\"start_date\":false,\"release_date\":false,\"url\":\"\"}', '127.0.0.1', 1581056959),
(61, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.4\",\"description\":\"\",\"sequence\":0,\"start_date\":false,\"release_date\":false,\"url\":\"\"}', '127.0.0.1', 1581056961),
(62, 1, '项目', 0, 1, 'master', 'Master', '/project/version/add?project_id=1', NULL, NULL, '新增', '添加项目版本', '[]', '{\"project_id\":1,\"name\":\"1.0.5\",\"description\":\"\",\"sequence\":0,\"start_date\":1581004800,\"release_date\":1581004800,\"url\":\"\"}', '127.0.0.1', 1581056968),
(63, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"20\",\"project_id\":\"1\",\"name\":\"1.0.2\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581057012),
(64, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"18\",\"project_id\":\"1\",\"name\":\"1.0.0\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581057104),
(65, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"23\",\"project_id\":\"1\",\"name\":\"1.0.5\",\"description\":\"\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1581004800\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581057107),
(66, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"22\",\"project_id\":\"1\",\"name\":\"1.0.4\",\"description\":\"\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"0\",\"release_date\":\"0\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581057110),
(67, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"21\",\"project_id\":\"1\",\"name\":\"1.0.3\",\"description\":\"\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"0\",\"release_date\":\"0\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581057114),
(68, 1, '项目', 0, 1, 'master', 'Master', '/project/version/delete', NULL, NULL, '删除', '删除项目版本', '{\"id\":\"19\",\"project_id\":\"1\",\"name\":\"1.0.1\",\"description\":\"Version 1.0.0\",\"sequence\":\"0\",\"released\":\"0\",\"archived\":null,\"url\":\"\",\"start_date\":\"1581004800\",\"release_date\":\"1583510400\"}', '{\"id\":\"\\u5df2\\u5220\\u9664\",\"project_id\":\"\\u5df2\\u5220\\u9664\",\"name\":\"\\u5df2\\u5220\\u9664\",\"description\":\"\\u5df2\\u5220\\u9664\",\"sequence\":\"\\u5df2\\u5220\\u9664\",\"released\":\"\\u5df2\\u5220\\u9664\",\"archived\":\"\\u5df2\\u5220\\u9664\",\"url\":\"\\u5df2\\u5220\\u9664\",\"start_date\":\"\\u5df2\\u5220\\u9664\",\"release_date\":\"\\u5df2\\u5220\\u9664\"}', '127.0.0.1', 1581057119);

--
-- 转存表中的数据 `main_activity`
--

INSERT INTO `main_activity` (`id`, `user_id`, `project_id`, `action`, `type`, `obj_id`, `title`, `date`, `time`) VALUES
(1, 1, 1, '创建了项目', 'project', 1, '示例项目', '2020-01-17', 1579247230),
(2, 1, 1, '创建了模块', 'project', 1, '后端架构', '2020-01-17', 1579249107),
(3, 1, 1, '创建了模块', 'project', 2, '前端架构', '2020-01-17', 1579249118),
(4, 1, 1, '创建了模块', 'project', 3, '用户', '2020-01-17', 1579249127),
(5, 1, 1, '创建了模块', 'project', 4, '首页', '2020-01-17', 1579249131),
(6, 1, 1, '创建了模块', 'project', 5, '引擎', '2020-01-17', 1579249144),
(7, 1, 1, '创建了版本', 'project', 1, '1.0', '2020-01-17', 1579249164),
(8, 1, 1, '删除了版本', 'project', 1, '1.0', '2020-01-17', 1579249167),
(9, 1, 1, '创建了迭代', 'agile', 1, '1.0迭代', '2020-01-17', 1579249186),
(10, 1, 0, '更新了资料', 'user', 1, 'Master', '2020-01-17', 1579249493),
(11, 1, 1, '创建了事项', 'issue', 1, '数据库设计', '2020-01-17', 1579249719),
(12, 1, 1, '创建了事项', 'issue', 2, '服务器端开发框架设计', '2020-01-17', 1579250062),
(13, 1, 1, '更新了事项', 'issue', 2, '服务器端开发框架设计', '2020-01-17', 1579250089),
(14, 1, 1, '创建了事项', 'issue', 3, 'UI设计', '2020-01-19', 1579423228),
(15, 1, 1, '更新了事项', 'issue', 3, 'UI设计', '2020-01-19', 1579423252),
(16, 1, 1, '创建了事项', 'issue', 4, '测试用例', '2020-01-19', 1579423320),
(17, 1, 1, '创建了模块', 'project', 6, '测试', '2020-01-19', 1579423336),
(18, 1, 1, '更新了事项', 'issue', 4, '测试用例', '2020-01-19', 1579423346),
(19, 1, 1, '更新了事项', 'issue', 4, '测试用例', '2020-01-19', 1579423447),
(20, 1, 1, '创建了项目角色', 'project', NULL, 'Reviewers', '2020-02-07', 1581049695),
(21, 1, 1, '删除了项目角色', 'project', 6, 'Reviewers', '2020-02-07', 1581049750),
(22, 1, 1, '创建了版本', 'project', 2, '1.0.0.0', '2020-02-07', 1581049859),
(23, 1, 1, '创建了版本', 'project', 3, '1.0.1.0', '2020-02-07', 1581050192),
(24, 1, 1, '更新了版本', 'project', 3, '1.0.1', '2020-02-07', 1581050294),
(25, 1, 1, '更新了版本', 'project', 2, '1.0.0', '2020-02-07', 1581050306),
(26, 1, 1, '创建了版本', 'project', 4, '1.0.2', '2020-02-07', 1581050342),
(27, 1, 1, '删除了版本', 'project', 3, '1.0.1', '2020-02-07', 1581050945),
(28, 1, 1, '删除了版本', 'project', 2, '1.0.0', '2020-02-07', 1581050949),
(29, 1, 1, '删除了版本', 'project', 4, '1.0.2', '2020-02-07', 1581050957),
(30, 1, 1, '删除了版本', 'project', 5, '1.0.1', '2020-02-07', 1581051099),
(31, 1, 1, '删除了版本', 'project', 6, '1.0.2', '2020-02-07', 1581051103),
(32, 1, 1, '创建了版本', 'project', 7, '1.0.0', '2020-02-07', 1581051126),
(33, 1, 1, '创建了版本', 'project', 8, '1.0.1', '2020-02-07', 1581051179),
(34, 1, 1, '创建了版本', 'project', 9, '1.0.2', '2020-02-07', 1581051501),
(35, 1, 1, '创建了版本', 'project', 10, '1.0.3', '2020-02-07', 1581051792),
(36, 1, 1, '创建了版本', 'project', 11, '1.0.4', '2020-02-07', 1581051872),
(37, 1, 1, '删除了版本', 'project', 9, '1.0.2', '2020-02-07', 1581052054),
(38, 1, 1, '删除了版本', 'project', 8, '1.0.1', '2020-02-07', 1581052061),
(39, 1, 1, '删除了版本', 'project', 7, '1.0.0', '2020-02-07', 1581052067),
(40, 1, 1, '删除了版本', 'project', 10, '1.0.3', '2020-02-07', 1581052119),
(41, 1, 1, '删除了版本', 'project', 11, '1.0.4', '2020-02-07', 1581052126),
(42, 1, 1, '创建了版本', 'project', 12, '1.0.1', '2020-02-07', 1581052154),
(43, 1, 1, '创建了版本', 'project', 13, '1.0.2', '2020-02-07', 1581052775),
(44, 1, 1, '删除了版本', 'project', 13, '1.0.2', '2020-02-07', 1581056557),
(45, 1, 1, '删除了版本', 'project', 12, '1.0.1', '2020-02-07', 1581056565),
(46, 1, 1, '创建了版本', 'project', 14, '1.0.1', '2020-02-07', 1581056590),
(47, 1, 1, '创建了版本', 'project', 15, '1.0.2', '2020-02-07', 1581056649),
(48, 1, 1, '删除了版本', 'project', 15, '1.0.2', '2020-02-07', 1581056657),
(49, 1, 1, '删除了版本', 'project', 14, '1.0.1', '2020-02-07', 1581056659),
(50, 1, 1, '创建了版本', 'project', 16, '1.0.1', '2020-02-07', 1581056749),
(51, 1, 1, '创建了版本', 'project', 17, '1.0.2', '2020-02-07', 1581056837),
(52, 1, 1, '删除了版本', 'project', 16, '1.0.1', '2020-02-07', 1581056879),
(53, 1, 1, '删除了版本', 'project', 17, '1.0.2', '2020-02-07', 1581056883),
(54, 1, 1, '创建了版本', 'project', 18, '1.0.0', '2020-02-07', 1581056901),
(55, 1, 1, '创建了版本', 'project', 19, '1.0.1', '2020-02-07', 1581056922),
(56, 1, 1, '创建了版本', 'project', 20, '1.0.2', '2020-02-07', 1581056925),
(57, 1, 1, '创建了版本', 'project', 21, '1.0.3', '2020-02-07', 1581056959),
(58, 1, 1, '创建了版本', 'project', 22, '1.0.4', '2020-02-07', 1581056961),
(59, 1, 1, '创建了版本', 'project', 23, '1.0.5', '2020-02-07', 1581056967),
(60, 1, 1, '删除了版本', 'project', 20, '1.0.2', '2020-02-07', 1581057012),
(61, 1, 1, '删除了版本', 'project', 18, '1.0.0', '2020-02-07', 1581057104),
(62, 1, 1, '删除了版本', 'project', 23, '1.0.5', '2020-02-07', 1581057107),
(63, 1, 1, '删除了版本', 'project', 22, '1.0.4', '2020-02-07', 1581057109),
(64, 1, 1, '删除了版本', 'project', 21, '1.0.3', '2020-02-07', 1581057114),
(65, 1, 1, '删除了版本', 'project', 19, '1.0.1', '2020-02-07', 1581057119);

--
-- 转存表中的数据 `main_announcement`
--

INSERT INTO `main_announcement` (`id`, `content`, `status`, `flag`, `expire_time`) VALUES
(1, 'test-content-829016', 0, 1, 0);

--
-- 转存表中的数据 `main_cache_key`
--

INSERT INTO `main_cache_key` (`key`, `module`, `datetime`, `expire`) VALUES
('dict/description_template/getAll/0,*', 'dict/description_template', '2020-02-13 20:02:23', 1581595343),
('dict/label/getAll/1,*', 'dict/label', '2020-02-13 21:34:28', 1581600868),
('dict/priority/getAll/1,*', 'dict/priority', '2020-02-13 21:34:28', 1581600868),
('dict/project_permission/getAll/1,*', 'dict/project_permission', '2020-02-13 20:01:30', 1581595290),
('dict/resolve/getAll/0,*', 'dict/resolve', '2020-02-15 20:53:33', 1581771213),
('dict/resolve/getAll/1,*', 'dict/resolve', '2020-02-13 21:34:28', 1581600868),
('dict/sprint/getItemById/1', 'dict/sprint', '2020-02-15 20:53:30', 1581771210),
('dict/status/getAll/0,*', 'dict/status', '2020-02-15 20:53:33', 1581771213),
('dict/status/getAll/1,*', 'dict/status', '2020-02-13 21:34:28', 1581600868),
('dict/type/getAll/0,*', 'dict/type', '2020-02-13 21:58:18', 1581602298),
('dict/type/getAll/1,*', 'dict/type', '2020-02-13 18:40:07', 1581590407),
('dict/type_scheme/getAll/1,*', 'dict/type_scheme', '2020-02-13 21:52:48', 1581601968),
('setting/getSettingByKey/date_timezone', 'setting', '2020-02-15 20:54:51', 1581771291),
('setting/getSettingByKey/full_datetime_format', 'setting', '2020-02-15 20:54:51', 1581771291),
('setting/getSettingByKey/title', 'setting', '2020-02-15 20:54:47', 1581771287),
('setting/getSettingRow/issue_view', 'setting', '2020-02-15 20:54:59', 1581771299),
('setting/getSettingRow/project_view', 'setting', '2020-02-15 20:54:59', 1581771299);

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

--
-- 转存表中的数据 `main_group`
--

INSERT INTO `main_group` (`id`, `name`, `active`, `created_date`, `updated_date`, `description`, `group_type`, `directory_id`) VALUES
(1, 'administrators', 1, NULL, NULL, NULL, '1', NULL),
(2, 'developers', 1, NULL, NULL, NULL, '1', NULL),
(3, 'users', 1, NULL, NULL, NULL, '1', NULL),
(4, 'qas', 1, NULL, NULL, NULL, '1', NULL),
(5, 'ui-designers', 1, NULL, NULL, NULL, '1', NULL);

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

--
-- 转存表中的数据 `main_notify_scheme`
--

INSERT INTO `main_notify_scheme` (`id`, `name`, `is_system`) VALUES
(1, '默认通知方案', 1);

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

--
-- 转存表中的数据 `main_org`
--

INSERT INTO `main_org` (`id`, `path`, `name`, `description`, `avatar`, `create_uid`, `created`, `updated`, `scope`) VALUES
(1, 'default', 'Default', 'Default organization', 'org/default.jpg', 0, 0, 1535263464, 3);

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
(45, 'attachment_dir', '附件路径', 'attachment', 0, '{{PUBLIC_PATH}}attachment', '{{STORAGE_PATH}}attachment', 'string', 'text', NULL, '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下'),
(46, 'attachment_size', '附件大小(单位M)', 'attachment', 0, '128.0', '10.0', 'float', 'text', NULL, '超过大小,无法上传,修改该值后同时还要修改 php.ini 的 post_max_size 和 upload_max_filesize'),
(47, 'enbale_thum', '启用缩略图', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许创建图像附件的缩略图'),
(48, 'enable_zip', '启用ZIP支持', 'attachment', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '允许用户将一个问题的所有附件打包成一个ZIP文件下载'),
(49, 'password_strategy', '密码策略', 'password_strategy', 0, '1', '2', 'int', 'radio', '{\"1\":\"禁用\",\"2\":\"简单\",\"3\":\"安全\"}', ''),
(50, 'send_mailer', '发信人', 'mail', 0, 'xxxxx@163.com', '', 'string', 'text', NULL, ''),
(51, 'mail_prefix', '前缀', 'mail', 0, 'Masterlab', '', 'string', 'text', NULL, ''),
(52, 'mail_host', '主机', 'mail', 0, 'smtp.163.com', '', 'string', 'text', NULL, ''),
(53, 'mail_port', 'SMTP端口', 'mail', 0, '25', '', 'string', 'text', NULL, ''),
(54, 'mail_account', '账号', 'mail', 0, 'xxxxx@163.com', '', 'string', 'text', NULL, ''),
(55, 'mail_password', '密码', 'mail', 0, 'xxx', '', 'string', 'text', NULL, ''),
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
(72, 'allow_user_reg', '允许用户注册', 'basic', 0, '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户');

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

--
-- 转存表中的数据 `mind_project_attribute`
--

INSERT INTO `mind_project_attribute` (`id`, `project_id`, `layout`, `shape`, `color`, `icon`, `font_family`, `font_size`, `font_bold`, `font_italic`, `bg_color`, `text_color`, `side`) VALUES
(4, 3, '', '', '', '', '', 1, 0, 0, '', '#9C27B0E6', '');

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
(33, 1, 'all', 'sprint', '0', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(34, 1, '1', 'module', '2', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(36, 1, '1', 'module', '3', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(37, 1, '1', 'module', '4', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(38, 1, '1', 'module', '5', '', '', '', '', '', 1, 0, 0, '', '#000000', ''),
(39, 1, '1', 'module', '1', '', '', '', '', '', 1, 0, 0, '', '#000000', '');

--
-- 转存表中的数据 `mind_sprint_attribute`
--

INSERT INTO `mind_sprint_attribute` (`id`, `sprint_id`, `layout`, `shape`, `color`, `icon`, `font_family`, `font_size`, `font_bold`, `font_italic`, `bg_color`, `text_color`, `side`) VALUES
(24, 44, '', '', '', '', '', 1, 0, 0, '', '#2196F3BF', '');

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
(10016, 0, '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS'),
(10017, 0, '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE'),
(10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS'),
(10902, 0, '管理backlog', '', 'MANAGE_BACKLOG'),
(10903, 0, '管理sprint', '', 'MANAGE_SPRINT'),
(10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN'),
(10905, 0, '导入事项', '可以到导入excel数据到项目中', 'IMPORT_EXCEL'),
(10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL');

--
-- 转存表中的数据 `permission_default_role`
--

INSERT INTO `permission_default_role` (`id`, `name`, `description`, `project_id`) VALUES
(10000, 'Users', '普通用户', 0),
(10001, 'Developers', '开发者,如程序员，架构师', 0),
(10002, 'Administrators', '项目管理员，如项目经理，技术经理', 0),
(10003, 'QA', '测试工程师', 0),
(10006, 'PO', '产品经理，产品负责人', 0);

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

--
-- 转存表中的数据 `permission_global`
--

INSERT INTO `permission_global` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES
(1, 0, '系统设置', '可以对整个系统进行基本，界面，安全，邮件设置，同时还可以查看操作日志', 'MANAGER_SYSTEM_SETTING'),
(2, 0, '管理用户', '', 'MANAGER_USER'),
(3, 0, '事项管理', '', 'MANAGER_ISSUE'),
(4, 0, '项目管理', '可以对全部项目进行管理，包括创建新项目。', 'MANAGER_PROJECT'),
(5, 0, '组织管理', '', 'MANAGER_ORG');

--
-- 转存表中的数据 `permission_global_group`
--

INSERT INTO `permission_global_group` (`id`, `perm_global_id`, `group_id`) VALUES
(1, 10000, 1);

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

--
-- 转存表中的数据 `permission_global_role_relation`
--

INSERT INTO `permission_global_role_relation` (`id`, `perm_global_id`, `role_id`, `is_system`) VALUES
(2, 1, 1, 1),
(8, 2, 1, 1),
(9, 3, 1, 1),
(10, 4, 1, 1),
(11, 5, 1, 1);

--
-- 转存表中的数据 `permission_global_user_role`
--

INSERT INTO `permission_global_user_role` (`id`, `user_id`, `role_id`) VALUES
(5613, 1, 1);

--
-- 转存表中的数据 `project_flag`
--

INSERT INTO `project_flag` (`id`, `project_id`, `flag`, `value`, `update_time`) VALUES
(1, 1, 'sprint_1_weight', '{\"2\":200000,\"1\":100000}', 1579402711),
(2, 1, 'sprint_1_weight', '{\"2\":400000,\"1\":300000,\"4\":200000,\"3\":100000}', 1581166410);

--
-- 转存表中的数据 `project_gantt_setting`
--

INSERT INTO `project_gantt_setting` (`id`, `project_id`, `source_type`, `source_from`) VALUES
(1, 1, 'active_sprint', NULL),
(2, 3, 'project', NULL),
(3, 2, 'project', NULL),
(4, 11, 'project', NULL);

--
-- 转存表中的数据 `project_issue_type_scheme_data`
--

INSERT INTO `project_issue_type_scheme_data` (`id`, `issue_type_scheme_id`, `project_id`) VALUES
(1, 2, 1);

--
-- 转存表中的数据 `project_main`
--

INSERT INTO `project_main` (`id`, `org_id`, `org_path`, `name`, `url`, `lead`, `description`, `key`, `pcounter`, `default_assignee`, `assignee_type`, `avatar`, `category`, `type`, `type_child`, `permission_scheme_id`, `workflow_scheme_id`, `create_uid`, `create_time`, `un_done_count`, `done_count`, `closed_count`, `archived`) VALUES
(1, 1, 'default', '示例项目', '', 1, 'Masterlab的示例项目', 'example', NULL, 1, NULL, 'project/avatar/1.jpg', 0, 10, 0, 0, 0, 1, 1579247230, 0, 0, 0, 'N');

--
-- 转存表中的数据 `project_main_extra`
--

INSERT INTO `project_main_extra` (`id`, `project_id`, `detail`) VALUES
(1, 1, '该项目展示了，如何将敏捷开发和Masterlab结合在一起.\r\n');

--
-- 转存表中的数据 `project_mind_setting`
--

INSERT INTO `project_mind_setting` (`id`, `project_id`, `setting_key`, `setting_value`) VALUES
(14, 3, 'default_source_id', ''),
(15, 3, 'fold_count', '16'),
(16, 3, 'default_source', 'sprint'),
(17, 3, 'is_display_label', '1');

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

--
-- 转存表中的数据 `project_role`
--

INSERT INTO `project_role` (`id`, `project_id`, `name`, `description`, `is_system`) VALUES
(1, 1, 'Users', '普通用户', 1),
(2, 1, 'Developers', '开发者,如程序员，架构师', 1),
(3, 1, 'Administrators', '项目管理员，如项目经理，技术经理', 1),
(4, 1, 'QA', '测试工程师', 1),
(5, 1, 'PO', '产品经理，产品负责人', 1);

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

--
-- 转存表中的数据 `project_user_role`
--

INSERT INTO `project_user_role` (`id`, `user_id`, `project_id`, `role_id`) VALUES
(3, 1, 1, 2),
(4, 1, 1, 3),
(5, 12164, 1, 2),
(6, 12165, 1, 2),
(8, 12166, 1, 5),
(7, 12167, 1, 2),
(9, 12168, 1, 2);

--
-- 转存表中的数据 `user_application`
--

INSERT INTO `user_application` (`id`, `application_name`, `lower_application_name`, `created_date`, `updated_date`, `active`, `description`, `application_type`, `credential`) VALUES
('1', 'crowd-embedded', 'crowd-embedded', '2013-02-28 11:57:51', '2013-02-28 11:57:51', '1', '', 'CROWD', 'X');

--
-- 转存表中的数据 `user_group`
--

INSERT INTO `user_group` (`id`, `uid`, `group_id`) VALUES
(1, 0, 1),
(2, 1, 1);

--
-- 转存表中的数据 `user_issue_display_fields`
--

INSERT INTO `user_issue_display_fields` (`id`, `user_id`, `project_id`, `fields`) VALUES
(13, 1, 3, 'issue_num,issue_type,priority,module,sprint,summary,assignee,status,plan_date'),
(16, 1, 0, 'issue_num,issue_type,priority,project_id,module,summary,assignee,status,resolve,plan_date');

--
-- 转存表中的数据 `user_login_log`
--

INSERT INTO `user_login_log` (`id`, `session_id`, `token`, `uid`, `time`, `ip`) VALUES
(1, 'kprv8i9pdu6in7cmqqoh5qhk55', '', 1, 1579402672, '127.0.0.1'),
(2, 'o7se01e6u2idr8vj7pjo0qm0ng', '', 1, 1580985604, '127.0.0.1'),
(3, 'qoetf70n719k9osusmf0sp6gq5', '', 1, 1581000131, '127.0.0.1'),
(4, 'tb37j7lgmq42k9c26kgram1560', '', 1, 1581048352, '127.0.0.1'),
(5, 'kcqa42243r3qe42e3ssgu8gjie', '', 1, 1581154393, '127.0.0.1'),
(6, 'p0tlhel0bvs8p2g7kphaeontvu', '', 1, 1581161394, '127.0.0.1');

--
-- 转存表中的数据 `user_main`
--

INSERT INTO `user_main` (`uid`, `directory_id`, `phone`, `username`, `openid`, `status`, `first_name`, `last_name`, `display_name`, `email`, `password`, `sex`, `birthday`, `create_time`, `update_time`, `avatar`, `source`, `ios_token`, `android_token`, `version`, `token`, `last_login_time`, `is_system`, `login_counter`, `title`, `sign`) VALUES
(1, 1, '18002510000', 'master', 'q7a752741f667201b54780c926faec4e', 1, '', 'master', 'Master', 'master@masterlab.vip', '$2y$10$hgUOO.S0FPEUnltUk7oAv.f9KWs7zY14TTdbevFVtuRsv.ka.SCdm', 1, '2019-01-13', 0, 0, 'avatar/1.png?t=1579249493', '', NULL, NULL, NULL, NULL, 1581161394, 0, 0, '管理员', '~~~交付卓越产品!'),
(12164, NULL, NULL, 'json', '87655dd189dc13a7eb36f62a3a8eed4c', 1, NULL, NULL, 'Json', 'json@masterlab.vip', '$2y$10$hW2HeFe4kUO/IDxGW5A68e7r.sERM6.VtP3VrYLXeyHVb0ZjXo2Sm', 0, NULL, 1579247721, 0, 'avatar/12164.png?t=1579247721', '', NULL, NULL, NULL, '', 0, 0, 0, 'Java开发工程师', NULL),
(12165, NULL, NULL, 'shelly', '74eb77b447ad46f0ba76dba8de3e8489', 1, NULL, NULL, 'Shelly', 'shelly@masterlab.vip', '$2y$10$RXindYr74f9I1GyaGtovE.KgD6pgcjE6Z9SZyqLO9UykzImG6n2kS', 0, NULL, 1579247769, 0, 'avatar/12165.png?t=1579247769', '', NULL, NULL, NULL, '', 0, 0, 0, '软件测试工程师', NULL),
(12166, NULL, NULL, 'alex', '22778739b6553330c4f9e8a29d0e1d5f', 1, NULL, NULL, 'Alex', 'Alex@masterlab.vip', '$2y$10$ENToGF7kfUrXm0i6DISJ6utmjq076tSCaVuEyeqQRdQocgUwxZKZ6', 0, NULL, 1579247886, 0, 'avatar/12166.png?t=1579247886', '', NULL, NULL, NULL, '', 0, 0, 0, '产品经理', NULL),
(12167, NULL, NULL, 'max', '9b0e7dc465b9398c2e270e6da415341c', 1, NULL, NULL, 'Max', 'Max@masterlab.vip', '$2y$10$qbv7OEhHuFQFmC4zJK50T.CDN7alvBaSf2FfqCXwSwcaC3FojM0GS', 0, NULL, 1579247926, 0, 'avatar/12167.png?t=1579247926', '', NULL, NULL, NULL, '', 0, 0, 0, '前端开发工程师', NULL),
(12168, NULL, NULL, 'sandy', '322436f4d5a63425e7973a5406b13057', 1, NULL, NULL, 'Sandy', 'sandy@masterlab.vip', '$2y$10$9Y0SadlCrjBKGJtniCG/OepxWnAkfdo4e9iUzXz/6hWWQjFfVzyGK', 0, NULL, 1579247959, 0, 'avatar/12168.png?t=1579247959', '', NULL, NULL, NULL, '', 0, 0, 0, 'UI设计师', NULL);

--
-- 转存表中的数据 `user_password_strategy`
--

INSERT INTO `user_password_strategy` (`id`, `strategy`) VALUES
(1, 2);

--
-- 转存表中的数据 `user_posted_flag`
--

INSERT INTO `user_posted_flag` (`id`, `user_id`, `_date`, `ip`) VALUES
(2, 0, '2020-01-19', '127.0.0.1'),
(5, 0, '2020-02-06', '127.0.0.1'),
(6, 0, '2020-02-07', '127.0.0.1'),
(9, 0, '2020-02-08', '127.0.0.1'),
(1, 1, '2020-01-17', '127.0.0.1'),
(3, 1, '2020-01-19', '127.0.0.1'),
(4, 1, '2020-02-06', '127.0.0.1'),
(7, 1, '2020-02-07', '127.0.0.1'),
(10, 1, '2020-02-08', '127.0.0.1');

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
(484, 1, 'layout', 'aa');

--
-- 转存表中的数据 `user_token`
--

INSERT INTO `user_token` (`id`, `uid`, `token`, `token_time`, `refresh_token`, `refresh_token_time`) VALUES
(1, 1, 'aa3d6c938a2f48d36901746d1dc029af48fd11504156cc29e9e40998d83d3a89', 1581161394, 'dbe51061daa573fdf15c9d97e97d7cae5b3eb0f3d2246b922f5b1a7759aa70a4', 1581161394);

--
-- 转存表中的数据 `user_widget`
--

INSERT INTO `user_widget` (`id`, `user_id`, `widget_id`, `order_weight`, `panel`, `parameter`, `is_saved_parameter`) VALUES
(1, 0, 1, 1, 'first', '', 0),
(2, 0, 23, 2, 'first', '', 0),
(3, 0, 3, 3, 'first', '', 0),
(4, 0, 4, 1, 'second', '', 0),
(5, 0, 5, 2, 'second', '', 0),
(2029, 1, 1, 1, 'first', '', 0),
(2030, 1, 2, 2, 'first', '', 0),
(2031, 1, 8, 3, 'first', '[{\"name\":\"project_id\",\"value\":\"1\"},{\"name\":\"status\",\"value\":\"all\"}]', 1),
(2032, 1, 3, 4, 'first', '', 0),
(2033, 1, 14, 1, 'second', '[{\"name\":\"sprint_id\",\"value\":\"1\"}]', 1),
(2034, 1, 12, 2, 'second', '[{\"name\":\"project_id\",\"value\":\"1\"},{\"name\":\"data_field\",\"value\":\"assignee\"},{\"name\":\"start_date\",\"value\":\"\"},{\"name\":\"end_date\",\"value\":\"\"}]', 1),
(2035, 1, 15, 3, 'second', '[{\"name\":\"sprint_id\",\"value\":\"1\"}]', 1);

--
-- 转存表中的数据 `workflow`
--

INSERT INTO `workflow` (`id`, `name`, `description`, `create_uid`, `create_time`, `update_uid`, `update_time`, `steps`, `data`, `is_system`) VALUES
(1, '默认工作流', '', 1, 0, NULL, 1539675295, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(2, '软件开发工作流', '针对软件开发的过程状态流', 1, NULL, NULL, 1529647857, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":511,\"positionY\":159,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":830,\"positionY\":150,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":942,\"positionY\":305,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":490,\"positionY\":395,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":767,\"positionY\":429,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":394,\"positionY\":276,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_45\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_reopen\"},{\"id\":\"con_52\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_66\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_80\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_87\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_94\",\"sourceId\":\"state_closed\",\"targetId\":\"state_reopen\"},{\"id\":\"con_101\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_resolved\"},{\"id\":\"con_108\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_delay\"},{\"id\":\"con_115\",\"sourceId\":\"state_reopen\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_125\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1),
(3, 'Task工作流', '', 1, NULL, NULL, 1539675552, NULL, '{\"blocks\":[{\"id\":\"state_begin\",\"positionX\":506,\"positionY\":40,\"innerHTML\":\"BEGIN<div class=\\\"ep\\\" action=\\\"begin\\\"></div>\",\"innerText\":\"BEGIN\"},{\"id\":\"state_open\",\"positionX\":516,\"positionY\":170,\"innerHTML\":\"打开<div class=\\\"ep\\\" action=\\\"OPEN\\\"></div>\",\"innerText\":\"打开\"},{\"id\":\"state_resolved\",\"positionX\":807,\"positionY\":179,\"innerHTML\":\"已解决<div class=\\\"ep\\\" action=\\\"resolved\\\"></div>\",\"innerText\":\"已解决\"},{\"id\":\"state_reopen\",\"positionX\":1238,\"positionY\":81,\"innerHTML\":\"重新打开<div class=\\\"ep\\\" action=\\\"reopen\\\"></div>\",\"innerText\":\"重新打开\"},{\"id\":\"state_in_progress\",\"positionX\":494,\"positionY\":425,\"innerHTML\":\"处理中<div class=\\\"ep\\\" action=\\\"in_progress\\\"></div>\",\"innerText\":\"处理中\"},{\"id\":\"state_closed\",\"positionX\":784,\"positionY\":424,\"innerHTML\":\"已关闭<div class=\\\"ep\\\" action=\\\"closed\\\"></div>\",\"innerText\":\"已关闭\"},{\"id\":\"state_delay\",\"positionX\":385,\"positionY\":307,\"innerHTML\":\"延迟处理  <div class=\\\"ep\\\" action=\\\"延迟处理\\\"></div>\",\"innerText\":\"延迟处理  \"},{\"id\":\"state_in_review\",\"positionX\":1243,\"positionY\":153,\"innerHTML\":\"回 顾  <div class=\\\"ep\\\" action=\\\"回 顾\\\"></div>\",\"innerText\":\"回 顾  \"},{\"id\":\"state_done\",\"positionX\":1247,\"positionY\":247,\"innerHTML\":\"完 成  <div class=\\\"ep\\\" action=\\\"完 成\\\"></div>\",\"innerText\":\"完 成  \"}],\"connections\":[{\"id\":\"con_3\",\"sourceId\":\"state_begin\",\"targetId\":\"state_open\"},{\"id\":\"con_10\",\"sourceId\":\"state_open\",\"targetId\":\"state_resolved\"},{\"id\":\"con_17\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_closed\"},{\"id\":\"con_24\",\"sourceId\":\"state_open\",\"targetId\":\"state_closed\"},{\"id\":\"con_31\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_closed\"},{\"id\":\"con_38\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_open\"},{\"id\":\"con_45\",\"sourceId\":\"state_in_progress\",\"targetId\":\"state_resolved\"},{\"id\":\"con_52\",\"sourceId\":\"state_closed\",\"targetId\":\"state_open\"},{\"id\":\"con_59\",\"sourceId\":\"state_open\",\"targetId\":\"state_delay\"},{\"id\":\"con_66\",\"sourceId\":\"state_resolved\",\"targetId\":\"state_open\"},{\"id\":\"con_73\",\"sourceId\":\"state_delay\",\"targetId\":\"state_in_progress\"},{\"id\":\"con_83\",\"sourceId\":\"state_open\",\"targetId\":\"state_in_progress\"}]}', 1);

--
-- 转存表中的数据 `workflow_scheme`
--

INSERT INTO `workflow_scheme` (`id`, `name`, `description`, `is_system`) VALUES
(1, '默认工作流方案', '', 1),
(10100, '敏捷开发工作流方案', '敏捷开发适用', 1),
(10101, '普通的软件开发工作流方案', '', 1),
(10102, '流程管理工作流方案', '', 1);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
