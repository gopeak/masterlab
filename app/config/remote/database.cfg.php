<?php
$_config = array(
    'database' =>
        array(
            'default' =>
                array(
                    'driver' => 'mysql',
                    'host' => '47.244.62.11',
                    'port' => '3306',
                    'user' => 'remote_mysql_user', //hornet
                    'password' => 'Hornet123', // hornet2017@.@
                    'db_name' => 'masterlab_dev',
                    'charset' => 'utf8',
                    'timeout' => 10,
                    'show_field_info' => false,
                ),
            'framework_db' =>
                array(
                    'driver' => 'mysql',
                    'host' => '47.244.62.11',
                    'port' => '3306',
                    'user' => 'remote_mysql_user',
                    'password' => 'Hornet123',
                    'db_name' => 'masterlab_dev',
                    'charset' => 'utf8',
                    'timeout' => 10,
                    'show_field_info' => false,
                ),
            'log_db' =>
                array(
                    'driver' => 'mysql',
                    'host' => '47.244.62.11',
                    'port' => '3306',
                    'user' => 'remote_mysql_user',
                    'password' => 'Hornet123',
                    'db_name' => 'masterlab_dev',
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
