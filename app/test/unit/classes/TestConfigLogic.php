<?php

namespace main\app\test\unit\classes;

use main\app\classes\ConfigLogic;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use PHPUnit\Framework\TestCase;

/**
 *  ConfigLogic 模块业务逻辑
 * @package main\app\test\logic
 */
class TestConfigLogic extends TestCase
{

    public static $projectId = null;

    public static $versionIdArr = [];

    public static $moduleIdArr = [];

    public static $labelIdArr = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        self::$projectId = ConfigLogicDataProvider::initProject()['id'];
    }

    /**
     * @throws \Exception
     */
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

        $model = new ProjectLabelModel();
        if (!empty(self::$labelIdArr)) {
            foreach (self::$labelIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function testGetStatus()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getStatus();
        $this->assertNotEmpty($rows);
    }

    /**
     * @throws \Exception
     */
    public function testGetUsers()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getUsers();
        $this->assertNotEmpty($rows);
    }

    /**
     * @throws \Exception
     */
    public function testGetResolves()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getResolves();
        $this->assertNotEmpty($rows);
    }

    /**
     * @throws \Exception
     */
    public function testGetPriority()
    {
        $logic = new ConfigLogic();
        $rows = $logic->getPriority();
        $this->assertNotEmpty($rows);
    }

    /**
     * @throws \Exception
     */
    public function testGetLabels()
    {
        $projectId = self::$projectId;
        $model = new ProjectLabelModel();
        $info = [];
        $info['project_id'] = $projectId;
        for ($i = 0; $i < 3; $i++) {
            $info['title'] = 'test-title-' . mt_rand(100000, 9999999);
            list($ret, $insertId) = $model->insert($info);
            $this->assertTrue($ret, $insertId);
            if ($ret) {
                self::$labelIdArr[] = $insertId;
            }
        }
        $logic = new ConfigLogic();
        $rows = $logic->getLabels($projectId);
        $this->assertNotEmpty($rows);
    }

    /**
     * @throws \Exception
     */
    public function testGetModules()
    {
        $projectId = self::$projectId;
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
    }

    /**
     * @throws \Exception
     */
    public function testGetVersions()
    {
        $projectId = self::$projectId;
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

        $rows =ConfigLogic::getVersions($projectId);
        $this->assertNotEmpty($rows);
        $this->assertCount(3, $rows);
        foreach ($rows as $row) {
            $this->assertTrue(isset($row['title']));
        }
    }
}
