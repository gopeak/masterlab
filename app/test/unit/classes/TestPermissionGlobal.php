<?php

namespace main\app\test\permission;

use main\app\classes\PermissionGlobal;
use PHPUnit\Framework\TestCase;


/**
 * 全局权限逻辑的单元测试
 * @todo 未实现
 * Class TestPermissionGlobal
 * @package main\app\test\settings
 */
class TestPermissionGlobal extends TestCase
{
    public static $uid = 1;
    public static $permId = 10000;

    public static $logs = [];


    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * @throws \Exception
     */
    public function testCheck()
    {
        //全局权限检测
        $result = PermissionGlobal::check(self::$uid, self::$permId);
        $this->assertNotEmpty($result);
    }
}
