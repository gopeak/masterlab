<?php
/**
 * Hornet-framework bootstrap file
 */

require_once '../globals.php';
require_once '../../../hornet-framework/src/framework/bootstrap.php';
// 初始化开发框架基本设置
$hornetConfig = new \stdClass();
$hornetConfig->currentApp = APP_NAME;
$hornetConfig->appPath = APP_PATH;
$hornetConfig->appStatus = APP_STATUS;
$hornetConfig->enableTrace = ENABLE_TRACE;
$hornetConfig->enableXhprof = ENABLE_XHPROF;
$hornetConfig->xhprofRate = XHPROF_RATE;
$hornetConfig->xhprofRoot = PRE_APP_PATH . 'lib/xhprof/';
$hornetConfig->enableWriteReqLog = WRITE_REQUEST_LOG;
$hornetConfig->enableSecurityMap = SECURITY_MAP_ENABLE;
$hornetConfig->enableReflectMethod = ENABLE_REFLECT_METHOD;
$hornetConfig->enableFilterSqlInject = false;
$hornetConfig->enableXssFilter = false;
$hornetConfig->exceptionPage = VIEW_PATH . 'exception.php';
$hornetConfig->ajaxProtocolClass = 'ajax';
$hornetConfig->ctrlMethodPrefix = 'page';
$hornetConfig->customRewriteClass = "main\\app\\classes\\RewriteUrl";
$hornetConfig->customRewriteFunction = "orgRoute";
$tplEngine = 'twig';
if (defined('TPL_ENGINE')) {
    $tplEngine = TPL_ENGINE;
}
$hornetConfig->tplEngine = $tplEngine;
//var_dump($hornetConfig);
// 实例化开发框架对象
$framework = new  framework\HornetEngine($hornetConfig);
// 执行路由分发
$framework->route();
