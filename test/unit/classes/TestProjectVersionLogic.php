<?php

namespace main\test\unit\classes;

use main\app\classes\ProjectVersionLogic;
use main\app\model\project\ProjectModel;
use main\test\unit\BaseUnitTranTestCase;
use PHPUnit\Framework\TestCase;

/**
 *  ProjectVersionLogic 模块业务逻辑
 * @package main\test\logic
 */
class TestProjectVersionLogic extends BaseUnitTranTestCase
{
    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        ProjectLogicDataProvider::initProjectWithVersionAndModule();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
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
