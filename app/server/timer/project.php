<?php
/**
 * 定时执行数据计算
 * crontab 命令 0,30 22-23 * * * /usr/bin/php /data/www/masterlab_pm/app/server/timer/project.php
 */

$currentDir = realpath(dirname(__FILE__). '/') ;

require $currentDir.'/bootstrap.php';
use \main\app\classes\CrontabProject;

try{
    $crontabProject = new CrontabProject();
    // 每一个小时计算冗余的项目数据
    $ret = $crontabProject->computeIssue();
    print_r($ret);
}catch (Exception $exception){
    print $exception->getMessage();
}
