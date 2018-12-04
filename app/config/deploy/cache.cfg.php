<?php 
$_config = array (
  'redis' => 
  array (
    'data' => 
    array (
      0 => '127.0.0.1',
      1 => '7379',
      2 => 'masterlab',
    ),
    'session' => 
    array (
      0 => 
      array (
        0 => '127.0.0.1',
        1 => 7379,
        2 => 'masterlab-session',
      ),
    ),
  ),
  'mongodb' => 
  array (
    'server' => 
    array (
      0 => '127.0.0.1',
      1 => 27017,
      2 => 'mongodb',
    ),
  ),
  'enable' => true,
  'cache_gc_rate' => 1000,
  'default_expire' => 1000,
);
return $_config;