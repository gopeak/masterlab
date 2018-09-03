<?php

namespace main\app\test\unit\model\project;


/**
 *  项目标识模型
 */
class TestProjectFlagModel extends TestBaseProjectModel
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

    public function testAdd()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetByFlag()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetValueByFlag()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
