

ALTER TABLE `issue_main`  MODIFY COLUMN  `backlog_weight` bigint(19) NOT NULL DEFAULT '0' COMMENT 'backlog排序权重';
ALTER TABLE `issue_main`  MODIFY COLUMN  `sprint_weight` bigint(19) NOT NULL DEFAULT '0' COMMENT 'sprint排序权重';
ALTER TABLE `issue_main`  MODIFY COLUMN  `gant_sprint_weight` bigint(19) NOT NULL DEFAULT '0' COMMENT '迭代甘特图中该事项在同级的排序权重';
