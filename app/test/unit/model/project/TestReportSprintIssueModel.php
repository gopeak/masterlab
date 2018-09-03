<?php

namespace main\app\test\unit\model\project;

/**
 *  迭代汇总表模型
 */
class TestReportSprintIssueModel extends TestBaseProjectModel
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

    public function testGetsBySprint()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testRemoveById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testRemoveBySprint()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
