<?php


// 项目中常用到的常量

// 获取所在目录名称
define("APP_NAME", basename(__DIR__));

// 网站名称
define('SITE_NAME', 'MasterLab');

// DIRECTORY_SEPARATOR 简写
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

// 项目程序控制器所在根目录（文件系统）
define('CTRL_PATH', APP_PATH . 'ctrl/');

// 项目程序模型文件所在根目录（文件系统）
define('MODEL_PATH', APP_PATH . 'model/');

// 插件目录
define('PLUGIN_PATH', PRE_APP_PATH . 'plugin/');

// 项目程序服务文件所在根目录（文件系统）
define('API_PATH', APP_PATH . 'api/');

define('SERVICE_PATH', API_PATH);

// 项目程序视图文件所在根目录（文件系统）
define('VIEW_PATH', APP_PATH . 'view/');

// 项目程序视图文件所在根目录（文件系统）
define('PUBLIC_PATH', PRE_APP_PATH . 'public/');

// 项目程序上传目录（文件系统）
define('STORAGE_PATH', PRE_APP_PATH . 'storage/');

// 临时文件存储目录
define('TMP_PATH', STORAGE_PATH . 'tmp/');

/**
 * 加密秘钥（用于图片加密，一旦上线，此值不可修改，修改后无法解密）
 * @var string
 */
define('ENCRYPT_KEY', '1234567890abc');


