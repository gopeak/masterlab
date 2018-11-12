<?php

// Session 设置
 $_config['session.cache_expire'] = unit_set('cache_expire') ? unit_set('cache_expire') : 24*60*7;
 $_config['session.gc_maxlifetime'] = 24*60*7*3600;
 $_config['session.cookie_lifetime'] = 24*60*7*3600;
 $_config['session.gc_probability'] = 1;

 // 设置Api不需要进行 session_start
 $_config['no_session_cmd'] = array( 'version.getVersion',  'version.getAppBG' );
 
 return $_config;