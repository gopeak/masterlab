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

    public static $versionIdArr = [];

    public static $moduleIdArr = [];

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        ConfigLogicDataProvider::clear();
        $model = new ProjectVersionModel();
        if (!empty(self::$versionIdArr)) {
            foreach (self::$versionIdArr as $id) {
                $model->deleteById($id);
            }
        }
        $model = new ProjectModuleModel();
        if (!empty(self::$moduleIdArr)) {
            foreach (self::$moduleIdArr as $id) {
                $model->deleteById($id);
            }
        }
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

    /**
     * @throws \Exception
     */
    public function testGetModules()
    {
        $projectId = ConfigLogicDataProvider::initProject()['id'];
        $model = new ProjectModuleModel();
        $info = [];
        $info['project_id'] = $projectId;
        for ($i = 0; $i < 3; $i++) {
            $info['name'] = 'test-name-' . mt_rand(100000, 9999999);
            list($ret, $insertId) = $model->insert($info);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$moduleIdArr[] = $insertId;
            }
        }
        $logic = new ConfigLogic();
        $rows = $logic->getModules($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(3, $rows);
        foreach ($rows as $row) {
            $this->assertTrue(isset($row['title']));
        }
        $ret = (bool)$model->deleteByProject($projectId);
        $this->assertTrue($ret);
    }

    /**
     * @throws \Exception
     */
    public function testGetVersions()
    {
        $projectId = ConfigLogicDataProvider::initProject()['id'];
        $model = new ProjectVersionModel();
        $info = [];
        $info['project_id'] = $projectId;
        for ($i = 0; $i < 3; $i++) {
            $info['name'] = 'test-name-' . mt_rand(100000, 9999999);
            list($ret, $insertId) = $model->insert($info);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$versionIdArr[] = $insertId;
            }
        }

        $logic = new ConfigLogic();
        $rows = $logic->getVersions($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(3, $rows);
        foreach ($rows as $row) {
            $this->assertTrue(isset($row['title']));
        }
        $ret = (bool)$model->deleteByProject($projectId);
        $this->assertTrue($ret);
    }
}
