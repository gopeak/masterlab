<?php

/**
 *
 */

require_once realpath(dirname(__FILE__)) . '/bootstrap.php';
require_once $rootDir . '/vendor/autoload.php';


$dbConfig = $GLOBALS['_yml_config']['database']['default'];

$version2Dir = '';
if (isset($argv[1]) && !empty($argv[1])) {
    $version2Dir = $argv[1];
}
if(empty($version2Dir)){
    echo "请指定2.0或者2.1版本的根目录\n";
    die;
}
$version2Status = 'deploy';
if(file_exists($version2Dir.'/env.ini')){
    $envArr = parse_ini_file($version2Dir.'/env.ini');
    $version2Status = $envArr['APP_STATUS'];
    unset($envArr);
}
$ver2DbConfigFile = $version2Dir.'/app/'.$version2Status.'/database.cfg.php';
if(!file_exists($ver2DbConfigFile)){
    echo "2.0或者2.1版本的数据库配置文件不存在:{$ver2DbConfigFile}\n";
    die;
}
include $ver2DbConfigFile;

$ver2DbConfig = $_config['database']['default'];

// 1.导入用户信息


// 2.导入配置


// 3.导入事项配置

// 4.导入项目,角色，权限，迭代，版本，标签，分类等

// 导入事项








/**
 * @param $dbConfig
 * @return \Doctrine\DBAL\Connection|null
 * @throws \Doctrine\DBAL\DBALException
 */
function getDb($dbConfig){
    $db = null;
    try{
        $connectionParams = array(
            'dbname' => $dbConfig['db_name'],
            'user' => $dbConfig['user'],
            'password' => $dbConfig['password'],
            'port' => $dbConfig['port'],
            'host' => $dbConfig['host'],
            'charset' => $dbConfig['charset'],
            'driver' => 'pdo_mysql',
        );
        $db = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        $sqlMode = "SET SQL_MODE='IGNORE_SPACE,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
        $db->exec($sqlMode);
    }catch(\Doctrine\DBAL\DBALException $e){
        echo "数据库链接失败:".print_r($dbConfig, true)."\n";
    }catch(\Exception $e){
        echo "数据库链接失败:".print_r($dbConfig, true)."\n";
    }
    return $db;
}

























