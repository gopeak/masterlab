<?php

namespace main\app\test\unit\model\project;

use  main\app\test\BaseAppTestCase;

/**
 * TestBaseProjectModel 基类
 * User: Lyman
 */
class TestBaseProjectModel extends BaseAppTestCase
{
    /**
     * project 数据
     * @var array
     */
    public static $projectData = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    /**
     * 初始化 project
     */
    public static function initProject()
    {
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
    }

    public function testMain()
    {
        $abc = true;
        $this->assertTrue($abc);
    }
}
