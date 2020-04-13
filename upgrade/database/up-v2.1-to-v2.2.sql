
ALTER TABLE `issue_main` ADD INDEX(`project_id`);

ALTER TABLE `issue_label_data` ADD INDEX(`issue_id`);
ALTER TABLE `issue_label_data` ADD INDEX(`label_id`);
ALTER TABLE `field_main` ADD INDEX(`is_system`);
ALTER TABLE `field_custom_value` ADD INDEX( `issue_id`, `custom_field_id`);


--
-- 表的结构 `main_plugin`
--

CREATE TABLE IF NOT EXISTS `main_plugin` (
     `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
     `name` varchar(64)  NOT NULL,
     `title` varchar(32)  NOT NULL,
     `index_page` varchar(256)  NOT NULL,
     `description` varchar(512)  NOT NULL,
     `version` varchar(24)  NOT NULL,
     `enable` tinyint(1) NOT NULL DEFAULT '1',
     `type` varchar(20)  NOT NULL,
     `chmod_json` text  NOT NULL,
     `url` varchar(256)  NOT NULL,
     `icon_file` varchar(256)  NOT NULL,
     `company` varchar(32)  NOT NULL,
     `install_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
     `order_weight` int(10) UNSIGNED NOT NULL DEFAULT '0',
     PRIMARY KEY (`id`),
     KEY `name` (`name`),
     KEY `order_weight` (`order_weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
COMMIT;

ALTER TABLE `main_plugin` CHANGE `enable` `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1启用,2停用,3开发中,0无效(插件目录不存在)';

