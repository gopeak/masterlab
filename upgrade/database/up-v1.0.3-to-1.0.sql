
UPDATE `issue_description_template` SET `content` = '\r\n描述内容...\r\n\r\n### 重现步骤\r\n1. 步骤1\r\n\r\n2. 步骤2\r\n\r\n3. 步骤3\r\n\r\n### 期望结果 \r\n\r\n\r\n### 实际结果\r\n\r\n' WHERE `issue_description_template`.`id` = 1;
UPDATE `issue_description_template` SET `content` = '\r\n### 功能点：\r\n\r\n### 规则\r\n\r\n### 影响\r\n' WHERE `issue_description_template`.`id` = 2;
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
