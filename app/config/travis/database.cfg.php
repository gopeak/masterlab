<?php
$_config = array(
    'database' =>
        array(
            'default' =>
                array(
                    'driver' => 'mysql',
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'user' => 'root', //hornet
                    'password' => 'Masterlab123@#', // hornet2017@.@
                    'db_name' => 'masterlab_ci',
                    'charset' => 'utf8',
                    'timeout' => 10,
                    'show_field_info' => false,
                ),
            'framework_db' =>
                array(
                    'driver' => 'mysql',
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => 'Masterlab123@#',
                    'db_name' => 'masterlab_ci',
                    'charset' => 'utf8',
                    'timeout' => 10,
                    'show_field_info' => false,
                ),
            'log_db' =>
                array(
                    'driver' => 'mysql',
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => 'Masterlab123@#',
                    'db_name' => 'masterlab_ci',
                    'charset' => 'utf8',
                    'timeout' => 10,
                    'show_field_info' => false,
                ),
        ),
    'config_map_class' =>
        array(
            'default' =>
                array(),
            'framework_db' =>
                array(
                    0 => 'FrameworkUserModel',
                    1 => 'FrameworkCacheKeyModel',
                ),
            'log_db' =>
                array(
                    0 => 'UnitTestUnitModel'
                ),
        ),
);

return $_config;
