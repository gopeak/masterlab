<?php 
$_config=array (
  'database' => 
  array (
    'default' => 
    array (
      'driver' => 'mysql',
      'host' => 'localhost',
      'port' => '3306',
      'user' => 'root',
      'password' => '',
      'db_name' => 'masterlab',
      'charset' => 'utf8',
      'timeout' => 10,
      'show_field_info' => false,
    ),
    'framework_db' => 
    array (
      'driver' => 'mysql',
      'host' => 'localhost',
      'port' => '3306',
      'user' => 'root',
      'password' => '',
      'db_name' => 'masterlab',
      'charset' => 'utf8',
      'timeout' => 10,
      'show_field_info' => false,
    ),
    'log_db' => 
    array (
      'driver' => 'mysql',
      'host' => 'localhost',
      'port' => '3306',
      'user' => 'root',
      'password' => '',
      'db_name' => 'masterlab',
      'charset' => 'utf8',
      'timeout' => 10,
      'show_field_info' => false,
    ),
  ),
  'config_map_class' => 
  array (
    'default' => 
    array (
    ),
    'framework_db' => 
    array (
      0 => 'FrameworkUserModel',
      1 => 'FrameworkCacheKeyModel',
    ),
    'log_db' => 
    array (
      0 => 'UnitTestUnitModel',
    ),
  ),
);
return $_config;