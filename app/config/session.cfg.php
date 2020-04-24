<?php

// Session 设置
 $sessionConfig = $GLOBALS['_yml_config']['session'];
 $_config['session.cache_expire'] =  $sessionConfig['cache_expire'] ??  24*60*7;
 $_config['session.gc_maxlifetime'] = $sessionConfig['gc_maxlifetime'] ?? 24*60*7*3600;
 $_config['session.cookie_lifetime'] = $sessionConfig['cookie_lifetime'] ?? 24*60*7*3600;
 $_config['session.gc_probability'] = $sessionConfig['gc_probability'] ?? 1;

 // 设置Api不需要进行 session_start
 $_config['no_session_cmd'] =  $sessionConfig['no_session_cmd'] ?? array( 'version.getVersion');
 
 return $_config;