<?php

namespace main\app\test\unit\classes;

use main\app\classes\ProjectModuleFilterLogic;
use main\app\model\project\ProjectModel;
use PHPUnit\Framework\TestCase;

/**
 *  ProjectModuleFilterLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestProjectModuleFilterLogic extends TestCase
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
    public function testGetModuleByFilter()
    {
        $model = new ProjectModel();
        $ret = $model->getAll();
        if (count($ret) > 0) {
            $projectIdArr = array_keys($ret);
            $keySeed = mt_rand(0, count($projectIdArr)-1);
            $projectId = $projectIdArr[$keySeed];

            $model = new ProjectModuleFilterLogic();
            $ret = $model->getModuleByFilter($projectId);
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

    /**
     * @throws \Exception
     */
    public function testGetByProjectWithUser()
    {
        $model = new ProjectModel();
        $ret = $model->getAll();
        if (count($ret) > 0) {
            $projectIdArr = array_keys($ret);
            $keySeed = mt_rand(0, count($projectIdArr)-1);
            $projectId = $projectIdArr[$keySeed];

            $model = new ProjectModuleFilterLogic();
            $ret = $model->getByProjectWithUser($projectId);
            $this->assertTrue(is_array($ret));
        } else {
            echo '项目列表为空';
        }
    }

    /**
     * @throws \Exception
     */
    public function testGetByProjectWithUserLikeName()
    {
        $model = new ProjectModel();
        $ret = $model->getAll();
        if (count($ret) > 0) {
            $projectIdArr = array_keys($ret);
            $keySeed = mt_rand(0, count($projectIdArr)-1);
            $projectId = $projectIdArr[$keySeed];

            $model = new ProjectModuleFilterLogic();
            $ret = $model->getByProjectWithUserLikeName($projectId, '');
            $this->assertTrue(is_array($ret));

            $randString = 'JUGG-UNIT-TEST-' . quickRandom(10);
            $ret = $model->getByProjectWithUserLikeName($projectId, $randString);
            $this->assertTrue(is_array($ret));
            $this->assertEmpty($ret);
        } else {
            echo '项目列表为空';
        }
    }
}
