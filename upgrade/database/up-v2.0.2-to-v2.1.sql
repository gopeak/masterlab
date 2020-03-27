

ALTER TABLE `main_setting` MODIFY COLUMN `title`  varchar(64) NOT NULL COMMENT '标题' AFTER `_key`;

# 创建项目分类表
CREATE TABLE  IF NOT EXISTS  `project_catalog_label` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`project_id`  int(11) NOT NULL ,
`name`  varchar(24) NOT NULL ,
`label_id_json`  varchar(5000) NOT NULL ,
`font_color`  varchar(20) NOT NULL DEFAULT 'blueviolet' COMMENT '字体颜色' ,
`description`  varchar(200) NOT NULL DEFAULT '' ,
`order_weight`  int(11) UNSIGNED NOT NULL ,
PRIMARY KEY (`id`),
INDEX `project_id` (`project_id`) USING BTREE ,
INDEX `project_id_2` (`project_id`, `order_weight`) USING BTREE
)ENGINE=InnoDB ROW_FORMAT=Compact;

# 增加上班日选项
ALTER TABLE `project_gantt_setting` ADD COLUMN `work_dates`  varchar(100) NULL DEFAULT NULL AFTER `hide_issue_types`;

# 增加是否在事项列表显示分类
ALTER TABLE `project_main` ADD COLUMN `is_display_issue_catalog`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否在事项列表显示分类' AFTER `issue_update_time`;

# 用户邀请表
CREATE TABLE  IF NOT EXISTS  `user_invite` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`email`  varchar(128) NOT NULL ,
`project_id`  int(11) UNSIGNED NOT NULL ,
`project_roles`  varchar(256) NOT NULL COMMENT '项目的角色id，可以是多个以逗号,分隔' ,
`token`  varchar(32) NOT NULL ,
`expire_time`  int(11) UNSIGNED NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `email` (`email`) USING BTREE ,
INDEX `token` (`token`) USING BTREE
)ENGINE=InnoDB ROW_FORMAT=Compact;

# 增加对ldap的支持
ALTER TABLE `user_main` ADD COLUMN `schema_source`  varchar(12) NOT NULL DEFAULT 'inner' COMMENT '用户数据源: inner ldap wechat weibo github等' AFTER `uid`;

# 修改消息表
ALTER TABLE `user_message` MODIFY COLUMN `content`  text NOT NULL AFTER `title`;

# 1.2升级到2.0遗漏的数据
REPLACE INTO `main_setting` ( `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
( 'allow_user_reg', '允许用户注册', 'basic', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '如关闭，则用户无法注册系统用户');


# 增加：管理甘特图和事项分解设置的权限项 @todo 升级脚本要增加管理员和po角色的权限
REPLACE INTO `project_permission` (`id`, `parent_id`, `name`, `description`, `_key`) VALUES
(10907, 0, '管理甘特图', '是否拥有权限操作甘特图中的事项和设置', 'ADMIN_GANTT'),
(10908, 0, '事项分解设置', '是否拥有权限修改事项分解的设置', 'MIND_SETTING');

# 增加ldap设置项
REPLACE INTO `main_setting` ( `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
( 'ldap_enable', '启用', 'ldap', 99, '0', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
('ldap_schema', '服务器类型', 'ldap', 96, 'OpenLDAP', 'ActiveDirectory', 'string', 'select', '{\"ActiveDirectory\":\"ActiveDirectory\",\"OpenLDAP\":\"OpenLDAP\",\"FreeIPA\": \"FreeIPA\"}', ''),
('ldap_hosts', '服务器地址', 'ldap', 94, '192.168.0.129', '', 'string', 'text', NULL, ''),
('ldap_port', '服务器端口', 'ldap', 90, '389', '389', 'int', 'text', NULL, ''),
( 'ldap_timeout', '连接超时时间', 'ldap', 88, '10', '10', 'string', 'text', NULL, ''),
( 'ldap_security protocol', '安全协议', 'ldap', 84, '', '', 'string', 'select', '{\"\":\"普通\",\"ssl\":\"SSL\",\"tls\":\"TLS\"}', ''),
( 'ldap_version', '版本', 'ldap', 80, '3', '3', 'string', 'text', NULL, ''),
( 'ldap_base_dn', 'BASE_DN', 'ldap', 76, 'dc=extest,dc=cn', 'dc=masterlab,dc=vip', 'string', 'text', NULL, '不能为空'),
( 'ldap_match_attr', '匹配属性', 'ldap', 74, 'cn', 'cn', 'string', 'text', '', '设置什么属性作为匹配用户名，建议使用 cn 或 dn '),
( 'ldap_username', '管理员DN值', 'ldap', 70, 'CN=Administrator,CN=Users,DC=extest,DC=cn', 'cn=Manager,dc=masterlab,dc=vip', 'string', 'text', NULL, ''),
( 'ldap_password', '管理员密码', 'ldap', 60, 'xxxxx', '', 'string', 'text', NULL, '');


REPLACE INTO `main_setting` (`id`, `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
(84, 'is_exchange_server', '服务器为ExchangeServer', 'mail', 910, '0', '0', 'string', 'radio', '{\"1\":\"是\",\"0\":\"否\"}', ''),
(85, 'is_ssl', 'SSL', 'mail', 920, '0', '0', 'string', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');




