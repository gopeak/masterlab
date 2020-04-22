<?php
/**
 *  项目必经必经文件，用于初始化框架数据
 */


// 项目文件根目录（文件系统，即本文件所在目录）
define('APP_PATH', realpath(dirname(__FILE__)) . '/');
define('PRE_APP_PATH', realpath(dirname(__FILE__) . '/../') . '/');

// composer自动加载文件
require_once APP_PATH . '/../vendor/autoload.php';

// 加载自定义的函数库
include_once APP_PATH . 'function/autoload.php';

use main\app\model\DbModel;
use Symfony\Component\Yaml\Yaml;

// 项目状态:deploy | development
$envVarArr = getEnvVar(PRE_APP_PATH);
bindAppConfig($envVarArr);

// 加载公共常量定义文件
include_once APP_PATH . "constants.php";

// 测试环境
testEnvAutoTransactionRollback();

/**
 * 获取env.ini的设置项
 * @param $rootPath
 * @return array
 */
function getEnvVar($rootPath)
{
    $appStatus = "deploy";
    $cacheYamlConfig = false;
    if (file_exists($rootPath . 'env.ini')) {
        $envArr = parse_ini_file($rootPath . 'env.ini');
        $appStatus = $envArr['APP_STATUS'];
        if (isset($envArr['CACHE_YAML'])) {
            if (strtolower($envArr['CACHE_YAML']) == 'false' || strtolower($envArr['CACHE_YAML']) == 'off') {
                $envArr['CACHE_YAML'] = false;
            }
            $cacheYamlConfig = (boolean)$envArr['CACHE_YAML'];
        }
        unset($envArr);
    }
    if (isset($_GET['_app_status']) && isset($_GET['_test_token'])) {
        $token = getCommonConfigVar('data')['token'];
        if ($_GET['_test_token'] == md5($token['public_key'])) {
            $appStatus = $_GET['_app_status'];
        }
    }
    if (isset($_SERVER['APP_STATUS'])) {
        $appStatus = $_SERVER['APP_STATUS'];
    }
    return ['APP_STATUS' => $appStatus, 'CACHE_YAML' => $cacheYamlConfig];
}


/**
 * 根据env.ini的设置项，载入config.xxx.yaml文件，并将选项绑定到 app.cfg.php
 * @param $envVarArr
 */
function bindAppConfig($envVarArr)
{
    $cacheYamlConfig = $envVarArr['CACHE_YAML'];
    $appStatus = $envVarArr['APP_STATUS'];

    // 加载主配置文件 config.yml @todo 使用yaml扩展函数将更高效
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
    $GLOBALS['_yml_config']['app_status'] = $appStatus;
    // 绑定到php配置文件
    include_once APP_PATH . "config/app.cfg.php";
}

/**
 * 测试环境是否自动开启事务和回滚，用于自动清理测试产生的数据
 * @throws Exception
 */
function testEnvAutoTransactionRollback()
{
    if (!in_array(APP_STATUS, ['test', 'travis'])) {
        return;
    }
    // 必须先自动加载
    spl_autoload_register('testAutoload');

    if (!$GLOBALS['_yml_config']['use_transaction']) {
        return;
    }
    $dbModel = (new DbModel());
    try {
        $dbModel->connect();
        $dbModel->beginTransaction();
    } catch (\Doctrine\DBAL\DBALException $e) {
        print "test env use AutoTransactionRollback failed:\n" . $e->getMessage();
    }
    register_shutdown_function(function () {
        if (empty($dbModel)) {
            $dbModel = (new DbModel());
        }
        if($dbModel->db->getTransactionNestingLevel()>0){
            $dbModel->rollBack();
        }

    }, $dbModel);
}


/**
 * @param $class
 */
function testAutoload($class)
{
    //var_dump($class );
    if (strpos($class, 'main\\') === false) {
        return;
    }
    $class = str_replace('main\\', '', $class);
    //var_dump($class );
    $file = realpath(dirname(APP_PATH . '/../../')) . '/' . $class . '.php';
    $file = str_replace(['\\', '//'], ['/', '/'], $file);
    //  var_dump($file );
    if (is_file($file)) {
        include_once $file;
        return;
    }
}