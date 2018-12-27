<?php

namespace main\app\test\unit\classes;

use main\app\classes\ProjectVersionLogic;
use main\app\model\project\ProjectModel;
use PHPUnit\Framework\TestCase;

/**
 *  ProjectVersionLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestProjectVersionLogic extends TestCase
{
    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        ProjectLogicDataProvider::initProjectWithVersionAndModule();
    }

    public static function tearDownAfterClass()
    {
        ProjectLogicDataProvider::clear();
    }

    /**
     * @throws \Exception
     */
    public function testGetVersionByFilter()
    {
        $model = new ProjectModel();
        $ret = $model->getAll();
        if (count($ret) > 0) {
            $projectIdArr = array_keys($ret);
            $keySeed = mt_rand(0, count($projectIdArr)-1);
            $projectId = $projectIdArr[$keySeed];

            $model = new ProjectVersionLogic();
            $ret = $model->getVersionByFilter($projectId);
            $this->assertTrue(is_array($ret));
            $this->assertEquals(count($ret), 3);
            list($flag, $data, $count) = $ret;
            $this->assertTrue($flag);
            $this->assertTrue(is_array($data));
            $this->assertTrue(is_numeric($count));
        } else {
            echo '项目列表为空';
        }
    }
}
