<?php

namespace main\test\settings;

use main\app\classes\Settings;
use main\test\unit\BaseUnitTranTestCase;
use PHPUnit\Framework\TestCase;


/**
 * 系统全局设置的各种配置属性
 * Class testLogLogic
 * @package main\test\settings
 */
class TestSettings extends BaseUnitTranTestCase
{
    public static $timestamp = 1531291961;
    public static $timeType = 'full_datetime_format';

    public static $logs = [];


    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    /**
     * @throws \Exception
     */
    public function testTime()
    {
        //测试返回的时间格式
        $result = Settings::getInstance()->time(self::$timestamp, self::$timeType);

        $this->assertNotEmpty($result);
    }

    /**
     * @throws \Exception
     */
    public function testAttachment()
    {
        //测试返回的附件配置
        $result = Settings::getInstance()->attachment();
        $this->assertNotEmpty($result);
    }
}
