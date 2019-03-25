
ALTER TABLE `main_mail_queue` ADD COLUMN `seq`  varchar(32) NULL DEFAULT NULL AFTER `id`;
CREATE UNIQUE INDEX `seq` ON `main_mail_queue`(`seq`) USING BTREE ;
CREATE TABLE `main_notify_scheme` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`name`  varchar(20) NOT NULL ,
`is_system`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
ROW_FORMAT=Compact
;

CREATE TABLE `main_notify_scheme_data` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
`scheme_id`  int(11) UNSIGNED NOT NULL ,
`name`  varchar(20) NOT NULL ,
`flag`  varchar(128) NULL DEFAULT NULL ,
`user`  varchar(1024) NOT NULL DEFAULT '[]' COMMENT '项目成员,经办人,报告人,关注人' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
ROW_FORMAT=Compact
;
DROP TABLE `job_run_details`;
DROP TABLE `main_mailserver`;


INSERT INTO `main_notify_scheme` (`id`, `name`, `is_system`) VALUES
(1, '默认通知方案', 1);
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



INSERT INTO `main_setting` (`id`,  `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
(NULL, 'enable_async_mail', '是否使用异步方式发送邮件', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', ''),
(NULL, 'enable_mail', '是否开启邮件推送', 'mail', 0, '1', '1', 'int', 'radio', '{\"1\":\"开启\",\"0\":\"关闭\"}', '');
INSERT INTO `main_setting` (`id`, `_key`, `title`, `module`, `order_weight`, `_value`, `default_value`, `format`, `form_input_type`, `form_optional_value`, `description`) VALUES
(NULL, 'socket_server_host', 'MasterlabSocket服务器地址', 'mail', '0', '127.0.0.1', '127.0.0.1', 'string', 'text', NULL, ''),
(NULL, 'socket_server_port', 'MasterlabSocket服务器端口', 'mail', '0', '9002', '9002', 'int', 'text', NULL, '');

