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

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    public function testGetModuleByFilter()
    {
        $model = new ProjectModel();
        $ret = $model->getAll();
        if (count($ret) > 0) {
            $projectIdArr = array_keys($ret);
            $keySeed = mt_rand(0, count($projectIdArr)-1);
            $projectId = $projectIdArr[$keySeed];

            $model = new ProjectModuleFilterLogic();
            list($flag, $data, $count) = $model->getModuleByFilter($projectId);
            $this->assertTrue(is_array($data));
            $this->assertEquals(count($data), $count);
        } else {
            $this->markTestIncomplete('因为没有项目数据,所以忽略该单元测试.');
        }
    }

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
            $this->markTestIncomplete('因为没有项目数据,所以忽略该单元测试.');
        }
    }

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
            $this->markTestIncomplete('因为没有项目数据,所以忽略该单元测试.');
        }
    }
}
