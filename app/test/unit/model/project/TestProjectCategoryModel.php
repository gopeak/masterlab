<?php
namespace main\app\test\unit\model\project;

/**
 *   项目模型
 */
class TestProjectCategoryModel extends TestBaseProjectModel
{

    public static $projectData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    public static function clearData()
    {

    }

    public function testGetAll()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }


    public function testGetByName()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
    
}