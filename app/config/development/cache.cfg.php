<?php

    $_config = [];
    $_config['redis']['data'] =  [ [ '192.168.3.216', 7379] ]  ;
    $_config['redis']['session'] =  [ [ '192.168.3.216', 7379] ]  ;
    $_config['mongodb']['server'] =  array( '192.168.3.216', 27017  , 'b2b' );
          
    // 千分之几的概率
    $_config['cache_gc_rate'] = 1000;
   
   return $_config;
