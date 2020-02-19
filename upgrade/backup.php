<?php
include_once dirname(__DIR__) . '/app/globals.php';

$commandArr = [
    'mysqldump' => "type mysqldump >/dev/null 2>&1 || echo 'mysqldump command not found'",
    'gzip' => "type gzip >/dev/null 2>&1 || echo 'gzip command not found'",
];

foreach ($commandArr as $key=>$command) {
    if (!empty(system($command))) {
        die(sprintf("\n命令 %s 不存在\n", $key));
    }
}

$databaseCfg = getConfigVar('database');
$useDbCfg = $databaseCfg['database']['default'];
$dbHost = $useDbCfg['host'];
$dbPort = $useDbCfg['port'];
$dbUser = $useDbCfg['user'];
$dbPass = $useDbCfg['password'];
$dbName = $useDbCfg['db_name'];

$backupFile = 'masterlab-backup' . date("Y-m-d-H-i-s") . '.gz';
$command = "mysqldump --opt -h $dbHost -P $dbPort -u $dbUser -p$dbPass --single-transaction --set-gtid-purged=off  " .
    $dbName . " | gzip > $backupFile";

system($command);