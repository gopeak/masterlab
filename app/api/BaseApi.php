<?php

namespace main\app\api;

use main\app\classes\B2bcrypt;
use main\app\classes\Sign;
use main\lib\phpcurl\Curl;

/**
 * api 基类， 提供对外接口的接入操作
 *
 * @author jesen
 *
 */
class BaseApi
{

    /**
     * 允许的请求方式
     * */
    protected static $method_type = array('get', 'post', 'put', 'patch', 'delete');

    /**
     * 参数处理
     */
    public function __construct()
    {

    }


    protected function validateRestfulHandler( )
    {
        foreach( self::$method_type as $method ) {
            if(  !method_exists( $this,$method . 'Handler') ) {
                throw new \Exception( 'Restful '.$method . 'Handler not exists',500 );
            }
        }
    }

}
