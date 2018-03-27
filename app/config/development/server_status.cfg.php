<?php

/**
 * 定义服务器是否可用
 * 该配置不要进行手动配置,服务器的状态由监控程序维护
 */
$_config['swoole'] = 1;
$_config['queue'] = 1;
$_config['redis'] = 1;
$_config['mongodb'] = 0;
return $_config;