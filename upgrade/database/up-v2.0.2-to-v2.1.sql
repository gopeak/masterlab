

ALTER TABLE `user_main` CHANGE `from_schema` `schema_source` VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'inner' COMMENT '用户数据源: inner ldap wechat weibo github等';
