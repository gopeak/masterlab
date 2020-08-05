<?php

namespace main\test\permission;

use main\app\classes\PermissionGlobal;
use main\test\unit\BaseUnitTranTestCase;
use PHPUnit\Framework\TestCase;


/**
 * 全局权限逻辑的单元测试
 * @todo 未实现
 * Class TestPermissionGlobal
 * @package main\test\settings
 */
class TestPermissionGlobal extends BaseUnitTranTestCase
{
    public static $uid = 1;
    public static $permId = 1;

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
