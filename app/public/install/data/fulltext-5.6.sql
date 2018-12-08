-- Mysql5.6及以下版本执行
-- version 1.0

ALTER table issue_main add fulltext index fulltext_summary( `summary`) ;
ALTER table issue_main add fulltext index fulltext_summary_description( `summary`, `description`) ;
ALTER table project_main add fulltext index fulltext_name_description( `name`, `description`) ;
ALTER table project_main add fulltext index fulltext_name( `name`) ;