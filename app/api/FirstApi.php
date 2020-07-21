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
    public function get()
    {
        $ret = [];
        $ret['data'] = ["1", "2", "3", "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjEtMTU5NDY0NTA0MSJ9.eyJpc3MiOiJodHRwOlwvXC9tYXN0ZXJsYWIuaW5rXC8iLCJhdWQiOiIxIiwianRpIjoiMS0xNTk0NjQ1MDQxIiwiaWF0IjoxNTk0NjQ1MDQxLCJuYmYiOjE1OTQ2NDUxMDEsImV4cCI6MTU5NDczMTQ0MSwidWlkIjoxLCJhY2NvdW50IjoibWFzdGVyIn0.LbfwrMnf4qH8IIpOnggZWxc--92T3IkSqO0bBwLkE1s"];
        $ret['msg'] = "ok";
        return $ret;
    }
}