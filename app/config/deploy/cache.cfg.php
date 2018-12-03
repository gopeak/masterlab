<?php

    $_config = [];
    $_config['redis']['data'] =  [ [ '127.0.0.1', 7379, 'masterlab'] ]  ;
    $_config['redis']['session'] =  [ [ '127.0.0.1', 7379, 'masterlab-session'] ]  ;
    $_config['mongodb']['server'] =  array( '127.0.0.1', 27017  , 'mongodb' );

    $_config['enable'] = true;

    // 千分之几的概率
    $_config['cache_gc_rate'] = 1000;

    $_config['default_expire'] = 1000;

   return $_config;
