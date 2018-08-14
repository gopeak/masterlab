<?php

namespace main\app\test\permission;

use main\app\classes\PermissionLogic;
use PHPUnit\Framework\TestCase;


/**
 * 系统全局设置的各种配置属性
 * Class testLogLogic
 * @package main\app\test\settings
 */
class TestPermission extends TestCase
{
    public static $uid = 10000;
    public static $action = 'ADMINISTER_PROJECTS';

    public static $logs = [];


    public static function setUpBeforeClass()
    {

    }

    public static function tearDownAfterClass()
    {

    }


    public function testCheck()
    {
    }


}
