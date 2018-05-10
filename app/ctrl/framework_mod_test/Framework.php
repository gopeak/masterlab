<?php
/**
 * 开发框架测试的代码,请勿随意修改或删除
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:49
 */
namespace main\app\ctrl\framework_mod_test;

use main\app\ctrl\BaseCtrl;

/**
 * Class for test
 * @package main\app\ctrl
 */
class Framework extends BaseCtrl
{
    public function index()
    {
        echo 'index';
    }

    public function route()
    {
        echo 'route';
    }
}
