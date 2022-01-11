
ALTER TABLE `agile_board`  MODIFY COLUMN `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;
ALTER TABLE `agile_board`  MODIFY COLUMN `range_type` varchar(20)  NOT NULL COMMENT '看板数据范围';
ALTER TABLE `agile_board` ADD COLUMN`sprint_id` int(11) unsigned DEFAULT '0';
ALTER TABLE `agile_board` ADD COLUMN `range_due_date` varchar(64) DEFAULT NULL COMMENT '截至时间范围';
ALTER TABLE `agile_board` ADD COLUMN `is_hide` tinyint(2) unsigned DEFAULT '0' COMMENT '是否隐藏';
UPDATE  `agile_board`  SET  `type`='custom_board',range_type = 'user' WHERE `is_system`=0;