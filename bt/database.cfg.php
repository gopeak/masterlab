<?php
$_config = [
    'database' =>
        [
            'default' =>
                [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'BT_DB_USERNAME',
                    'password' => 'BT_DB_PASSWORD',
                    'db_name' => 'BT_DB_NAME',
                    'charset' => 'utf8',
                    'timeout' => 10,
                    'show_field_info' => false,
                ]
        ],
    'config_map_class' =>
        [
            'default' => [],
            'framework_db' => [],
            'log_db' => [],
        ],
];
return $_config;