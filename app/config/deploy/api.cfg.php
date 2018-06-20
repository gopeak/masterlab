<?php
/**
 * api接口限制请求数量和请求频率配置
 */

$_config['api'] = array(
    //示例
    //接口地址uri
    '/api/test/info' => array(
        //访问频率为1次每秒
        'timeWithSecond' => 1,
        //每天访问最高数据量为2次
        'numPeriod' => array(
            'unit' => API_TIME_UNITS['day'],
            'num' => 2,
        ),
        //冻结时间为1个小时，单位为秒
        'freezeTime' => 3600
    ),
);

return $_config;