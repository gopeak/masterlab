<?php
/**
 * 定时执行数据计算
 * crontab 命令 56 23 * * * /usr/bin/php /data/www/masterlab_pm/app/server/timer/sprintDayReport.php
 */

$currentDir = realpath(dirname(__FILE__). '/') ;

require $currentDir.'/bootstrap.php';
use \main\app\classes\CrontabProject;

try{
    $crontabProject = new CrontabProject();
    // 每天计算一次迭代日数据
    $ret = $crontabProject->computeSprintDayReportIssue();
    print_r($ret);
}catch (Exception $exception){
    print $exception->getMessage();
}
