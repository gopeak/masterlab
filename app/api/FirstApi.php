<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/28 0028
 * Time: 下午 5:59
 */

namespace main\app\api;

class FirstApi extends BaseApi
{
    public function get( ){
        $ret = [];
        $ret['data'] = ["1","2","3"];
        $ret['msg'] = "ok";
        return $ret;
    }
}