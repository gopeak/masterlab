<?php
/**
 * 定时执行数据计算
 */

$appDir = realpath(dirname(__FILE__). '/../../') ;
$wwwDir = realpath(dirname(__FILE__). '/../../../../') ;

require_once $appDir.'/globals.php';
require_once $wwwDir.'/hornet-framework/src/framework/bootstrap.php';

use \main\app\classes\CrontabProject;

// 初始化开发框架基本设置
$config = new \stdClass();
$config->currentApp = APP_NAME;
$config->appPath = APP_PATH;
$config->appStatus = APP_STATUS;
$config->enableTrace = ENABLE_TRACE;
$config->enableXhprof = ENABLE_XHPROF;
$config->xhprofRate = XHPROF_RATE;
$config->enableWriteReqLog = WRITE_REQUEST_LOG;
$config->enableSecurityMap = SECURITY_MAP_ENABLE;
$config->exceptionPage = VIEW_PATH . 'exception.php';
$config->ajaxProtocolClass = 'ajax';
$config->enableReflectMethod = ENABLE_REFLECT_METHOD;

$config->customRewriteClass = "main\\app\\classes\\RewriteUrl";
$config->customRewriteFunction = "orgRoute";

try{
    // 实例化开发框架对象
    $framework = new  framework\HornetEngine($config);

    $crontabProject = new CrontabProject();
    // 每一个小时计算冗余的项目数据
    $ret = $crontabProject->computeIssue();
    print_r($ret);

    // 每天计算一次
    $ret = $crontabProject->computeDayReportIssue();
    print_r($ret);
}catch (Exception $exception){
    print $exception->getMessage();
}
