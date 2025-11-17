<?php

// 将配置数据赋值给常量
$appConfig = $GLOBALS['_yml_config'];

// 设置错误报告
error_reporting($appConfig['error_reporting'] == 'E_ALL' ? E_ALL : E_ERROR);

define("APP_STATUS", $appConfig['app_status']);

// 主程序URL地址，可手动设置
define('ROOT_URL', trimStr($appConfig['app_url']) == '' ? currentHttpDomain() : $appConfig['app_url']);

// 附件url
define('ATTACHMENT_URL', ROOT_URL . 'attachment/');

// office支持实时预览
define('IS_OFFICE_PREVIEW', (boolean)$appConfig['office_preview']['enanle']);
define('OFFICE_PREVIEW_API', $appConfig['office_preview']['office_api']);
define('OFFICE_PREVIEW_SUFFIX_MAP', (array)$appConfig['office_preview']['office_suffix_map']);

// 当前版本号
define('MASTERLAB_VERSION', $appConfig['version']);

// 使用twig模板引擎
define('TPL_ENGINE', 'twig');

// Xhprof设置
define('ENABLE_XHPROF', (boolean)$appConfig['xhprof']['enable']);

//触发xhprof的几率
define('XHPROF_RATE', $appConfig['xhprof']['rate']);

// 是否记录访问日志
define('WRITE_REQUEST_LOG', (boolean)$appConfig['write_request_log']);

// 是否在网页底部显示debug信息
define('XPHP_DEBUG', (boolean)$appConfig['xdebug']);

// api和ajax请求时是否开启Trace
define('ENABLE_TRACE', (boolean)$appConfig['trace']);

// 是否开启反射和检验返回值格式功能
define('ENABLE_REFLECT_METHOD', true);

// 启用过滤接口机制
define('SECURITY_MAP_ENABLE', (boolean)$appConfig['security_map']);

//时区设置
date_default_timezone_set($appConfig['date_default_timezone']);

// api使用JWT
define("JWT_KEY", $appConfig['encrypy_key']);
define("JWT_TOKEN_EXPIRED", 3600*24*30*3);
define("JWT_REFRESH_TOKEN_EXPIRED", 3600*24*30*6);

// 销毁该全局变量
unset($appConfig);
