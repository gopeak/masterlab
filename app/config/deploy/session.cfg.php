<?php

// Session 设置
$_config['session.cache_expire'] = unit_set('cache_expire') ? unit_set('cache_expire') : 180;
$_config['session.gc_maxlifetime'] = 1440;
$_config['session.cookie_lifetime'] = 3600 * 24 * 7;
$_config['session.gc_divisor'] = 100;
$_config['session.gc_probability'] = 1;
//$_config['session.save_path'] = STORAGE_PATH . 'session/';

// 设置Api不需要进行 session_start
$_config['no_session_cmd'] = array('version.getVersion', 'version.getAppBG');

return $_config;