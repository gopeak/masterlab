-- MasterLab v2.0 alpha 升级到 v2.0 数据库表索引补丁
-- by 杨文杰

ALTER TABLE `issue_main` DROP INDEX `fulltext_summary_description`;
ALTER TABLE `issue_main` DROP INDEX `fulltext_summary`;
ALTER TABLE `issue_main` DROP INDEX `issue_num`;

CREATE INDEX `gant_sprint_weight` ON `issue_main`(`gant_sprint_weight`) USING BTREE ;

ALTER TABLE `project_main` DROP INDEX `fulltext_name`;
ALTER TABLE `project_main` DROP INDEX `fulltext_name_description`;