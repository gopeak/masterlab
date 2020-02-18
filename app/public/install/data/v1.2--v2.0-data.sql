

UPDATE `agile_board` SET `name` = '进行中的迭代', `project_id` = 0, `type` = 'status', `is_filter_backlog` = 0, `is_filter_closed` = 1, `weight` = 99999, `range_type` = 'current_sprint', `range_data` = '', `is_system` = 1 WHERE `id` = 1;

UPDATE `agile_board` SET `name` = '整个项目', `project_id` = 0, `type` = 'status', `is_filter_backlog` = 0, `is_filter_closed` = 1, `weight` = 99998, `range_type` = 'all', `range_data` = '', `is_system` = 1 WHERE `id` = 2;

UPDATE `agile_board_column` SET `name` = '准 备', `board_id` = 1, `data` = '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', `weight` = 3 WHERE `id` = 1;

UPDATE `agile_board_column` SET `name` = '进行中', `board_id` = 1, `data` = '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', `weight` = 2 WHERE `id` = 2;

UPDATE `agile_board_column` SET `name` = '已完成', `board_id` = 1, `data` = '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', `weight` = 1 WHERE `id` = 3;

UPDATE `agile_board_column` SET `name` = '准备中', `board_id` = 2, `data` = '{\"status\":[\"open\",\"reopen\",\"in_review\",\"delay\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', `weight` = 0 WHERE `id` = 4;

UPDATE `agile_board_column` SET `name` = '进行中', `board_id` = 2, `data` = '{\"status\":[\"in_progress\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', `weight` = 0 WHERE `id` = 5;

REPLACE INTO `agile_board_column` ( `name`, `board_id`, `data`, `weight`) VALUES ('已完成', 2, '{\"status\":[\"closed\",\"done\"],\"resolve\":[],\"label\":[],\"assignee\":[]}', 0);


REPLACE INTO  `field_main` SET `name` = 'source', `title` = '来源', `description` = '', `type` = 'TEXT', `default_value` = NULL, `is_system` = 0, `options` = 'null', `order_weight` = 0, `extra_attr` = '';

REPLACE INTO `field_main`( `name`, `title`, `description`, `type`, `default_value`, `is_system`, `options`, `order_weight`, `extra_attr`) VALUES ( 'progress', '完成度', '', 'PROGRESS', '0', 1, '', 0, 'min=\"0\" max=\"100\"');

REPLACE INTO `field_main`( `name`, `title`, `description`, `type`, `default_value`, `is_system`, `options`, `order_weight`, `extra_attr`) VALUES ( 'duration', '用时(天)', '', 'TEXT', '1', 1, '', 0, '');

REPLACE INTO `field_main`( `name`, `title`, `description`, `type`, `default_value`, `is_system`, `options`, `order_weight`, `extra_attr`) VALUES ( 'is_start_milestone', '是否起始里程碑', '', 'TEXT', '0', 1, '', 0, '');

REPLACE INTO `field_main`( `name`, `title`, `description`, `type`, `default_value`, `is_system`, `options`, `order_weight`, `extra_attr`) VALUES ( 'is_end_milestone', '是否结束里程碑', '', 'TEXT', '0', 1, '', 0, '');

UPDATE `field_main` SET `name` = 'weight', `title` = '权 重', `description` = '待办事项中的权重值', `type` = 'NUMBER', `default_value` = '0', `is_system` = 1, `options` = '', `order_weight` = 0, `extra_attr` = 'min=\"0\"' WHERE `id` = 21;


REPLACE INTO `field_type`(`id`, `name`, `description`, `type`) VALUES (29, 'NUMBER', '数字输入框', 'NUMBER');

REPLACE INTO `field_type`(`id`, `name`, `description`, `type`) VALUES (30, 'PROGRESS', '进度值', 'PROGRESS');

UPDATE `issue_resolve` SET `sequence` = 2, `name` = '未解决', `_key` = 'not_fix', `description` = '事项不可抗拒原因无法解决', `font_awesome` = NULL, `color` = '#db3b21', `is_system` = 1 WHERE `id` = 2;

UPDATE `issue_status` SET `sequence` = 1, `name` = '打 开', `_key` = 'open', `description` = '表示事项被提交等待有人处理', `font_awesome` = '/images/icons/statuses/open.png', `is_system` = 1, `color` = 'info', `text_color` = 'blue' WHERE `id` = 1;

UPDATE `issue_status` SET `sequence` = 3, `name` = '进行中', `_key` = 'in_progress', `description` = '表示事项在处理当中，尚未完成', `font_awesome` = '/images/icons/statuses/inprogress.png', `is_system` = 1, `color` = 'primary', `text_color` = 'blue' WHERE `id` = 3;

UPDATE `issue_status` SET `sequence` = 4, `name` = '重新打开', `_key` = 'reopen', `description` = '事项重新被打开,重新进行解决', `font_awesome` = '/images/icons/statuses/reopened.png', `is_system` = 1, `color` = 'warning', `text_color` = 'blue' WHERE `id` = 4;

UPDATE `issue_status` SET `sequence` = 5, `name` = '已解决', `_key` = 'resolved', `description` = '事项已经解决', `font_awesome` = '/images/icons/statuses/resolved.png', `is_system` = 1, `color` = 'success', `text_color` = 'green' WHERE `id` = 5;

UPDATE `issue_status` SET `sequence` = 6, `name` = '已关闭', `_key` = 'closed', `description` = '问题处理结果确认后，置于关闭状态。', `font_awesome` = '/images/icons/statuses/closed.png', `is_system` = 1, `color` = 'success', `text_color` = 'green' WHERE `id` = 6;

UPDATE `issue_status` SET `sequence` = 0, `name` = '完成', `_key` = 'done', `description` = '表明一件事项已经解决且被实践验证过', `font_awesome` = '', `is_system` = 1, `color` = 'success', `text_color` = 'green' WHERE `id` = 10001;

REPLACE INTO `issue_type`(`id`, `sequence`, `name`, `_key`, `catalog`, `description`, `font_awesome`, `custom_icon_url`, `is_system`, `form_desc_tpl_id`) VALUES (12, NULL, '甘特图', 'gantt', 'Custom', '', 'fa-exchange', NULL, 0, 0);


REPLACE INTO `main_setting`(`id`, `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES (72, 'allow_user_reg', '允许用户注册', 'basic', 0, '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户');

UPDATE `main_setting` SET `_key` = 'attachment_dir', `title` = '附件路径', `module` = 'attachment', `order_weight` = 0, `_value` = '{{PUBLIC_PATH}}attachment', `default_value` = '{{STORAGE_PATH}}attachment', `format` = 'string', `form_input_type` = 'text', `form_optional_value` = NULL, `description` = '附件存放的绝对或相对路径, 一旦被修改, 你需要手工拷贝原来目录下所有的附件到新的目录下' WHERE `id` = 45;

UPDATE `main_setting` SET `_key` = 'attachment_size', `title` = '附件大小(单位M)', `module` = 'attachment', `order_weight` = 0, `_value` = '128.0', `default_value` = '10.0', `format` = 'float', `form_input_type` = 'text', `form_optional_value` = NULL, `description` = '超过大小,无法上传,修改该值后同时还要修改 php.ini 的 post_max_size 和 upload_max_filesize' WHERE `id` = 46;



REPLACE INTO `permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10016, 0, '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS');

REPLACE INTO `permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10017, 0, '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE');

UPDATE `permission_default_role_relation` SET `role_id` = 10000, `perm_id` = 10005 WHERE `id` = 42;

UPDATE `permission_default_role_relation` SET `role_id` = 10000, `perm_id` = 10006 WHERE `id` = 43;

UPDATE `permission_default_role_relation` SET `role_id` = 10000, `perm_id` = 10007 WHERE `id` = 44;

UPDATE `permission_default_role_relation` SET `role_id` = 10000, `perm_id` = 10008 WHERE `id` = 45;

UPDATE `permission_default_role_relation` SET `role_id` = 10000, `perm_id` = 10013 WHERE `id` = 46;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10005 WHERE `id` = 47;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10006 WHERE `id` = 48;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10007 WHERE `id` = 49;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10008 WHERE `id` = 50;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10013 WHERE `id` = 51;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10014 WHERE `id` = 52;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10015 WHERE `id` = 53;

UPDATE `permission_default_role_relation` SET `role_id` = 10001, `perm_id` = 10028 WHERE `id` = 54;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10004 WHERE `id` = 55;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10005 WHERE `id` = 56;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10006 WHERE `id` = 57;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10007 WHERE `id` = 58;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10008 WHERE `id` = 59;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10013 WHERE `id` = 60;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10014 WHERE `id` = 61;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10015 WHERE `id` = 62;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10028 WHERE `id` = 63;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10902 WHERE `id` = 64;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10903 WHERE `id` = 65;

UPDATE `permission_default_role_relation` SET `role_id` = 10002, `perm_id` = 10904 WHERE `id` = 66;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10004 WHERE `id` = 67;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10005 WHERE `id` = 68;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10006 WHERE `id` = 69;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10007 WHERE `id` = 70;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10008 WHERE `id` = 71;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10013 WHERE `id` = 72;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10014 WHERE `id` = 73;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10015 WHERE `id` = 74;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10028 WHERE `id` = 75;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10902 WHERE `id` = 76;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10903 WHERE `id` = 77;

UPDATE `permission_default_role_relation` SET `role_id` = 10006, `perm_id` = 10904 WHERE `id` = 78;

REPLACE INTO `permission_global`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (1, 0, '系统设置', '可以对整个系统进行基本，界面，安全，邮件设置，同时还可以查看操作日志', 'MANAGER_SYSTEM_SETTING');

REPLACE INTO `permission_global`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (2, 0, '管理用户', '', 'MANAGER_USER');

REPLACE INTO `permission_global`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (3, 0, '事项管理', '', 'MANAGER_ISSUE');

REPLACE INTO `permission_global`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (4, 0, '项目管理', '可以对全部项目进行管理，包括创建新项目。', 'MANAGER_PROJECT');

REPLACE INTO `permission_global`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (5, 0, '组织管理', '', 'MANAGER_ORG');

DELETE FROM `permission_global` WHERE `id` = 10000;

REPLACE INTO `permission_global_role`(`id`, `name`, `description`, `is_system`) VALUES (1, '超级管理员', NULL, 1);

REPLACE INTO `permission_global_role`(`id`, `name`, `description`, `is_system`) VALUES (2, '系统设置管理员', NULL, 0);

REPLACE INTO `permission_global_role`(`id`, `name`, `description`, `is_system`) VALUES (3, '项目管理员', NULL, 1);

REPLACE INTO `permission_global_role`(`id`, `name`, `description`, `is_system`) VALUES (4, '用户管理员', NULL, 0);

REPLACE INTO `permission_global_role`(`id`, `name`, `description`, `is_system`) VALUES (5, '事项设置管理员', NULL, 0);

REPLACE INTO `permission_global_role`(`id`, `name`, `description`, `is_system`) VALUES (6, '组织管理员', NULL, 0);

REPLACE INTO `permission_global_role_relation`(`id`, `perm_global_id`, `role_id`, `is_system`) VALUES (2, 1, 1, 1);

REPLACE INTO `permission_global_role_relation`(`id`, `perm_global_id`, `role_id`, `is_system`) VALUES (8, 2, 1, 1);

REPLACE INTO `permission_global_role_relation`(`id`, `perm_global_id`, `role_id`, `is_system`) VALUES (9, 3, 1, 1);

REPLACE INTO `permission_global_role_relation`(`id`, `perm_global_id`, `role_id`, `is_system`) VALUES (10, 4, 1, 1);

REPLACE INTO `permission_global_role_relation`(`id`, `perm_global_id`, `role_id`, `is_system`) VALUES (11, 5, 1, 1);

REPLACE INTO `permission_global_user_role`(`id`, `user_id`, `role_id`) VALUES (5613, 1, 1);

REPLACE INTO `project_gantt_setting`(`id`, `project_id`, `source_type`, `source_from`) VALUES (1, 1, 'active_sprint', NULL);

REPLACE INTO `project_gantt_setting`(`id`, `project_id`, `source_type`, `source_from`) VALUES (2, 3, 'project', NULL);

REPLACE INTO `project_gantt_setting`(`id`, `project_id`, `source_type`, `source_from`) VALUES (3, 2, 'project', NULL);

REPLACE INTO `project_gantt_setting`(`id`, `project_id`, `source_type`, `source_from`) VALUES (4, 11, 'project', NULL);

REPLACE INTO `project_mind_setting`(`id`, `project_id`, `setting_key`, `setting_value`) VALUES (14, 3, 'default_source_id', '');

REPLACE INTO `project_mind_setting`(`id`, `project_id`, `setting_key`, `setting_value`) VALUES (15, 3, 'fold_count', '16');

REPLACE INTO `project_mind_setting`(`id`, `project_id`, `setting_key`, `setting_value`) VALUES (16, 3, 'default_source', 'sprint');

REPLACE INTO `project_mind_setting`(`id`, `project_id`, `setting_key`, `setting_value`) VALUES (17, 3, 'is_display_label', '1');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10004, 0, '管理项目', '可以对项目进行设置', 'ADMINISTER_PROJECTS');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10005, 0, '访问事项列表(已废弃)', '', 'BROWSE_ISSUES');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10006, 0, '创建事项', '', 'CREATE_ISSUES');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10007, 0, '评论', '', 'ADD_COMMENTS');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10008, 0, '上传和删除附件', '', 'CREATE_ATTACHMENTS');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10013, 0, '编辑事项', '项目的事项都可以编辑', 'EDIT_ISSUES');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10014, 0, '删除事项', '项目的所有事项可以删除', 'DELETE_ISSUES');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10015, 0, '关闭事项', '项目的所有事项可以关闭', 'CLOSE_ISSUES');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10016, 0, '修改事项状态', '修改事项状态', 'EDIT_ISSUES_STATUS');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10017, 0, '修改事项解决结果', '修改事项解决结果', 'EDIT_ISSUES_RESOLVE');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10028, 0, '删除评论', '项目的所有的评论均可以删除', 'DELETE_COMMENTS');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10902, 0, '管理backlog', '', 'MANAGE_BACKLOG');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10903, 0, '管理sprint', '', 'MANAGE_SPRINT');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10904, 0, '管理kanban', NULL, 'MANAGE_KANBAN');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10905, 0, '导入事项', '可以到导入excel数据到项目中', 'IMPORT_EXCEL');

REPLACE INTO `project_permission`(`id`, `parent_id`, `name`, `description`, `_key`) VALUES (10906, 0, '导出事项', '可以将项目中的数据导出为excel格式', 'EXPORT_EXCEL');

REPLACE INTO `user_setting`(`id`, `user_id`, `_key`, `_value`) VALUES (353, 1, 'page_layout', 'fixed');



