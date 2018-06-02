<?php

namespace main\app\test\unit\classes;

use main\app\classes\ConfigLogic;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use PHPUnit\Framework\TestCase;

/**
 *  ConfigLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestConfigLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        ConfigLogicDataProvider::clear();
    }
    public function testGetStatus()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getStatus();
        $this->assertNotEmpty($rows);
    }

    public function testGetUsers()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getUsers();
        $this->assertNotEmpty($rows);
    }

    public function testGetResolves()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getResolves();
        $this->assertNotEmpty($rows);
    }

    public function testGetPriority()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getPriority();
        $this->assertNotEmpty($rows);
    }

    public function testGetLabels()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getLabels();
        $this->assertNotEmpty($rows);
    }


    public function testGetModules()
    {
        $projectId = ConfigLogicDataProvider::initProject()['id'];
        $model = new ProjectModuleModel();
        $info = [];
        $info['project_id'] = $projectId;
        $info['name'] = 'test-name-' . mt_rand(100, 999);
        $model->insert($info);
        $model->insert($info);
        $model->insert($info);
        $logic = new ConfigLogic();
        $rows = $logic->getModules($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(3, $info);
        foreach ($rows as $row) {
            $this->assertTrue($row['title']);
        }
        $ret = (bool)$model->deleteByProject($projectId);
        $this->assertTrue($ret);
    }

    public function testGetVersions()
    {
        $projectId = ConfigLogicDataProvider::initProject()['id'];
        $model = new ProjectVersionModel();
        $info = [];
        $info['project_id'] = $projectId;
        $info['name'] = 'test-name-' . mt_rand(100, 999);
        $model->insert($info);
        $model->insert($info);
        $model->insert($info);
        $logic = new ConfigLogic();
        $rows = $logic->getVersions($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(3, $info);
        foreach ($rows as $row) {
            $this->assertTrue($row['title']);
        }
        $ret = (bool)$model->deleteByProject($projectId);
        $this->assertTrue($ret);
    }

}
