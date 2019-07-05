
ALTER TABLE `issue_main` ADD COLUMN `followed_count`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被关注人数' AFTER `have_children`;
ALTER TABLE `issue_main` ADD COLUMN `comment_count`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论数' AFTER `followed_count`;
CREATE FULLTEXT INDEX `issue_num` ON `issue_main`(`issue_num`) ;
ALTER TABLE `issue_ui` ADD COLUMN `required`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否必填项' AFTER `tab_id`;

CREATE TABLE `user_issue_display_fields` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`user_id`  int(11) UNSIGNED NOT NULL ,
`project_id`  int(11) UNSIGNED NOT NULL ,
`fields`  varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `user_fields` (`user_id`, `project_id`) USING BTREE
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci
ROW_FORMAT=Compact
;
