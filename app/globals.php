<?php
/**
 *  项目统一加载文件
 */


// 项目文件根目录（文件系统，即本文件所在目录）
define('APP_PATH', realpath(dirname(__FILE__)) . '/');
define('PRE_APP_PATH', realpath(dirname(__FILE__) . '/../') . '/');

// composer自动加载文件
require_once APP_PATH . '/../vendor/autoload.php';

// 加载自定义的函数库
include_once APP_PATH . 'function/autoload.php';

// 项目状态:deploy | development
$appStatus = "deploy";
$cacheYamlConfig = false;
if (file_exists(PRE_APP_PATH . 'env.ini')) {
    $envArr = parse_ini_file(PRE_APP_PATH . 'env.ini');
    $appStatus = $envArr['APP_STATUS'];
    if (isset($envArr['CACHE_YAML'])) {
        if (strtolower($envArr['CACHE_YAML']) == 'false' || strtolower($envArr['CACHE_YAML']) == 'off') {
            $envArr['CACHE_YAML'] = false;
        }
        $cacheYamlConfig = (boolean)$envArr['CACHE_YAML'];
    }
    unset($envArr);
}
if (isset($_GET['_app_status']) && isset($_GET['_test_token']) ) {
    $token = getCommonConfigVar('data')['token'];
    if($_GET['_test_token']==md5($token['public_key'])){
        $appStatus = $_GET['_app_status'];
    }
}
if (isset($_SERVER['APP_STATUS'])) {
    $appStatus = $_SERVER['APP_STATUS'];
}
define("APP_STATUS", $appStatus);

// 加载主配置文件 config.yml @todo 使用yaml扩展函数将更高效
use Symfony\Component\Yaml\Yaml;

$cacheYamlConfigFile = APP_PATH . 'storage/cache/config.' . $appStatus . '.yaml.php';
if ($cacheYamlConfig && file_exists($cacheYamlConfigFile)) {
    include $cacheYamlConfigFile;
    if (isset($_yaml_config) && !empty($_yaml_config)) {
        $GLOBALS['_yml_config'] = $_yaml_config;
        unset($_yaml_config);
    }
} else {
    $configFile = PRE_APP_PATH . 'config.yml';
    if ($appStatus != 'deploy') {
        $configFile = PRE_APP_PATH . 'config.' . $appStatus . '.yml';
    }
    $GLOBALS['_yml_config'] = Yaml::parseFile($configFile);
    if ($cacheYamlConfig) {
        $cacheYamlConfigVar = "<?php \n" . '$_yaml_config = ' . var_export($GLOBALS['_yml_config'], true) . ";\n";
        @file_put_contents($cacheYamlConfigFile, $cacheYamlConfigVar);
    }
}


// 加载公共常量定义文件
include_once APP_PATH . "constants.php";

// 加载主配置文件
include_once APP_PATH . "config/app.cfg.php";

