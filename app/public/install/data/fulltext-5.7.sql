-- Mysql5.7及以上版本执行
-- version 1.0

ALTER table issue_main add fulltext index fulltext_summary( `summary`) with parser ngram;
ALTER table issue_main add fulltext index fulltext_summary_description( `summary`, `description`) with parser ngram;
ALTER table project_main add fulltext index fulltext_name_description( `name`, `description`) with parser ngram;
ALTER table project_main add fulltext index fulltext_name( `name`) with parser ngram;