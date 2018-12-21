<?php
/**
 * api接口限制请求数量和请求频率配置
 */

$_config['api'] = array(
    '/api/test/info' => array(
        'timeWithSecond' => 1,
        'numPeriod' => array(
            'unit' => 'day',
            'num' => 2,
        ),
        'freezeTime' => 3600
    ),
);

return $_config;