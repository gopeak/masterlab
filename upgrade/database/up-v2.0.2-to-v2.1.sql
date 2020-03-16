
# 1.2升级到2.0遗漏的数据
INSERT INTO `main_setting` ( `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
( 'allow_user_reg', '允许用户注册', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户');
# 增加对ldap的支持
ALTER TABLE `user_main` CHANGE `from_schema` `schema_source` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'inner' COMMENT '用户数据源: inner ldap wechat weibo github等';

# 增加：管理甘特图和事项分解设置的权限项 @todo 升级脚本要增加管理员和po角色的权限
INSERT INTO `project_permission` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES
(10907, 0, '管理甘特图', '是否拥有权限操作甘特图中的事项和设置', 'ADMIN_GANTT'),
(10908, 0, '事项分解设置', '是否拥有权限修改事项分解的设置', 'MIND_SETTING');

