<?php

namespace main\app\test\unit\model\project;

/**
 *  项目汇总表模型
 */
class TestReportProjectIssueModel extends TestBaseProjectModel
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

    public function testGetById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetsByProject()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testRemoveById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testRemoveByProject()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
