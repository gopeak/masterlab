<?php

namespace main\app\test\unit\model\project;


/**
 * ProjectModel 测试类
 * User: Lyman
 */
class TestProjectModel extends TestBaseProjectModel
{

    public static $projectData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
    }


    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {

    }


    /**
     * 主流程
     */
    public function testMain()
    {

    }
}
