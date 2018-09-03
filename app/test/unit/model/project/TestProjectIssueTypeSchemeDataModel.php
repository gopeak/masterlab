<?php

namespace main\app\test\unit\model\project;


/**
 *  事项类型方案子项1:M 关系的字段方案模型
 */
class TestProjectIssueTypeSchemeDataModel extends TestBaseProjectModel
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

    public function testGetSchemeId()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testDeleteBySchemeId()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetByProjectId()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

}
