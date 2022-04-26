ALTER TABLE `issue_filter` ADD   `is_show` tinyint(1) unsigned DEFAULT '1' COMMENT '是否展示';
ALTER TABLE `issue_filter` ADD  `order_weight` int(11) DEFAULT NULL COMMENT '排序权重';
