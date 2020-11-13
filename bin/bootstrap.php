<?php
$rootDir = realpath(dirname(__FILE__) . '/../');
ini_set('session.auto_start', 'Off');
require $rootDir . '/app/globals.php';
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
// 实例化开发框架对象
$framework = new  framework\HornetEngine($hornetConfig);

// 执行路由分发
use main\app\model\SettingModel;

$settingModel = new SettingModel();
$settings = $settingModel->getSettingByModule('mail');

$config = [];
if (empty($settings)) {
    return [false, 'fetch mail setting error'];
}
foreach ($settings as $s) {
    $config[$s['_key']] = $settingModel->formatValue($s);
}
unset($settings);

/**
 * @return array
 */
function get_php_bin_dir()
{
    if (substr(strtolower(PHP_OS), 0, 3) == 'win') {
        $ini = ini_get_all();
        $path = $ini['extension_dir']['local_value'];
        $b = substr($path, 0, -3);
        $phpPath = str_replace('\\', '/', $b);
        $realPath = $phpPath . 'php.exe';

        if (strpos($realPath, 'ephp.exe') !== FALSE) {
            $realPath = str_replace('ephp.exe', 'php.exe', $realPath);
        }
        $cmd = $realPath . " -r var_export(true);";
    } else {
        $realPath = PHP_BINDIR . '/php';
        $cmd = $realPath . " -r 'var_export(true);'";
    }

    $lastLine = @exec($cmd);
    return [$lastLine == 'true', $realPath];
}

/**
 * @param $msg
 * @return false|int
 */
function log_cron($msg)
{
    global $rootDir;
    return file_put_contents($rootDir . '/bin/cron.log', date('Y-m-d H:i:s') . ' ' . $msg . "\n", FILE_APPEND);
}
