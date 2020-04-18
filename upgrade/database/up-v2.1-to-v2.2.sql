
--
-- 表的结构 `main_plugin`
--

CREATE TABLE `main_plugin` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `index_page` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1已安装,2未安装,0无效(插件目录不存在)',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chmod_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_file` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `install_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `order_weight` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `enable` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否启用',
  `is_display` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 表的结构 `main_webhook`
--

CREATE TABLE `main_webhook` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_json` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret_token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enable` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否启用',
  `timeout` tinyint(2) UNSIGNED NOT NULL DEFAULT '10',
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- 转存表中的数据 `main_plugin`
--

INSERT INTO `main_plugin` (`id`, `name`, `title`, `index_page`, `description`, `version`, `status`, `type`, `chmod_json`, `url`, `icon_file`, `company`, `install_time`, `order_weight`, `is_system`, `enable`, `is_display`) VALUES
(1, 'activity', '活动日志', 'ctrl@index@pageIndex', '默认自带的插件：活动日志', '1.0', 1, 'project_module', '', 'http://www.masterlab.vip', '/attachment/plugin/1.png', 'Masterlab官方', 0, 0, 1, 1, 1),
(22, 'webhook', 'webhook', '', '默认自带的插件：webhook', '1.0', 1, 'admin_module', '', 'http://www.masterlab.vip', '/attachment/plugin/webhook.png', 'Masterlab官方', 0, 0, 1, 1, 1);

--
-- 转存表中的数据 `main_webhook`
--

INSERT INTO `main_webhook` (`id`, `name`, `url`, `event_json`, `secret_token`, `enable`, `timeout`, `description`) VALUES
(1, 'local', 'http://masterlab.ink/webhook.php', '', 'xxxxxxxxxxxxxxxxx', 1, 10, '');



ALTER TABLE `issue_main` ADD INDEX(`project_id`);

ALTER TABLE `issue_label_data` ADD INDEX(`issue_id`);
ALTER TABLE `issue_label_data` ADD INDEX(`label_id`);
ALTER TABLE `field_main` ADD INDEX(`is_system`);
ALTER TABLE `field_custom_value` ADD INDEX( `issue_id`, `custom_field_id`);
ALTER TABLE `project_flag` ADD UNIQUE( `project_id`, `flag`);


--
-- 表的索引 `main_plugin`
--
ALTER TABLE `main_plugin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `order_weight` (`order_weight`),
  ADD KEY `type` (`type`);


--
-- 使用表AUTO_INCREMENT `main_plugin`
--
ALTER TABLE `main_plugin` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;


--
-- 表的索引 `main_webhook`
--
ALTER TABLE `main_webhook`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `enable` (`enable`);


--
-- 使用表AUTO_INCREMENT `main_webhook`
--
ALTER TABLE `main_webhook`  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
