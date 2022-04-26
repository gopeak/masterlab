
ALTER TABLE `issue_main` ADD   `last_close_resolve_time` int(11) unsigned DEFAULT 0 COMMENT '最近解决结果:关闭的时间';
ALTER TABLE `issue_main` ADD   `last_close_status_time` int(11) unsigned DEFAULT 0 COMMENT '最近状态:已完成的时间';
ALTER TABLE `issue_main` ADD   `last_done_resolve_time` int(11) unsigned DEFAULT 0 COMMENT '最近解决结果:已解决的时间';
ALTER TABLE `issue_main` ADD   `last_done_status_time` int(11) unsigned DEFAULT 0 COMMENT '最近状态:已解决的时间';
