-- MasterLab v1.2 升级到 v2.0 数据库表索引补丁
-- by 杨文杰

ALTER TABLE `issue_main` DROP INDEX `fulltext_summary_description`;
ALTER TABLE `issue_main` DROP INDEX `fulltext_summary`;

DROP INDEX `summary` ON `issue_main`;
CREATE INDEX `summary` ON `issue_main`(`summary`) USING BTREE ;

DROP INDEX `default_role_id` ON `permission_default_role_relation`;
CREATE INDEX `default_role_id` ON `permission_default_role_relation`(`role_id`) USING BTREE ;
DROP INDEX `role_id-and-perm_id` ON `permission_default_role_relation`;
CREATE INDEX `role_id-and-perm_id` ON `permission_default_role_relation`(`role_id`, `perm_id`) USING BTREE ;
ALTER TABLE `permission_global` DROP INDEX `_key`;

ALTER TABLE `project_main` DROP INDEX `fulltext_name`;
ALTER TABLE `project_main` DROP INDEX `fulltext_name_description`;

CREATE INDEX `status` ON `issue_main`(`status`) USING BTREE ;
CREATE INDEX `gant_sprint_weight` ON `issue_main`(`gant_sprint_weight`) USING BTREE ;

CREATE INDEX `permission_global_key_idx` ON `permission_global`(`_key`) USING BTREE ;
CREATE INDEX `project_id` ON `project_role`(`project_id`) USING BTREE ;