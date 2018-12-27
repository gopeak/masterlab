<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\test\BaseDataProvider;

/**
 *   项目模块模型
 */
class TestProjectModuleModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectModuleData = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$projectData = self::initProject();
        self::$projectModuleData = self::initProjectModule();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        self::clearData();
    }

    /**
     * @throws \Exception
     */
    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);

        $model = new ProjectModuleModel();
        $model->deleteById(self::$projectModuleData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    /**
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initProjectModule($info = [])
    {
        $model = new ProjectModuleModel();
        $info['project_id'] = self::$projectData['id'];
        $info['name'] = 'unittest-'.quickRandom(5).quickRandom(5);
        $info['description'] = 'descriptiondescription...'.quickRandom(10);
        $info['lead'] = self::$user['uid'];
        $info['default_assignee'] = self::$user['uid'];
        $info['ctime'] = time();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__METHOD__ . '  failed,' . $insertId);
            return [];
        }
        return $model->getRowById($insertId);
    }

    /**
     * @throws \Exception
     */
    public function testGetAll()
    {
        $model = new ProjectModuleModel();
        $ret = $model->getAll();

        $this->assertTrue(is_array($ret));
        if (count($ret) > 0) {
            $assert = current($ret);
            $this->assertTrue(is_array($assert));
        } else {
            $this->assertEmpty($ret);
        }
    }

    /**
     * @throws \Exception
     */
    public function testGetByProject()
    {
        $model = new ProjectModuleModel();
        $ret = $model->getByProject(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
        if (count($ret) > 0) {
            $assert = current($ret);
            $this->assertTrue(is_array($assert));
        } else {
            $this->assertEmpty($ret);
        }
    }

    /**
     * @throws \Exception
     */
    public function testGetAllCount()
    {
        $model = new ProjectModuleModel();
        $ret = $model->getAllCount(self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testCheckNameExist()
    {
        $model = new ProjectModuleModel();
        $ret = $model->checkNameExist(self::$projectData['id'], self::$projectModuleData['name']);
        $this->assertTrue($ret);

        $ret = $model->checkNameExist(self::$projectData['id'], self::$projectModuleData['name'].quickRandom(2));
        $this->assertFalse($ret);
    }

    /**
     * @throws \Exception
     */
    public function testCheckNameExistExcludeCurrent()
    {
        $model = new ProjectModuleModel();

        // 验证不存在同项目下同名模块
        $ret = $model->checkNameExistExcludeCurrent(
            self::$projectModuleData['id'],
            self::$projectModuleData['project_id'],
            self::$projectModuleData['name']
        );
        $this->assertEquals(0, $ret);

        // 验证存在同项目下同名模块
        $info['project_id'] = self::$projectModuleData['project_id'];
        $info['name'] = self::$projectModuleData['name'];
        $info['description'] = 'descriptiondescription...'.quickRandom(10);
        $info['lead'] = 10000;
        $info['default_assignee'] = 10000;
        $info['ctime'] = time();
        list($ret, $insertId) = $model->insert($info);
        $ret = $model->checkNameExistExcludeCurrent($insertId, self::$projectModuleData['project_id'], self::$projectModuleData['name']);
        $this->assertNotEquals(0, $ret);
        $model->deleteById($insertId);
    }

    /**
     * @throws \Exception
     */
    public function testGetById()
    {
        $model = new ProjectModuleModel();
        $ret = $model->getById(self::$projectModuleData['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetByName()
    {
        $model = new ProjectModuleModel();
        $ret = $model->getByName(self::$projectModuleData['name']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testDeleteByProject()
    {
        $model = new ProjectModuleModel();
        $info['project_id'] = self::$projectData['id'];
        $info['name'] = 'unittest-'.quickRandom(5).quickRandom(5);
        $info['description'] = 'descriptiondescription...'.quickRandom(10);
        $info['lead'] = 10000;
        $info['default_assignee'] = 10000;
        $info['ctime'] = time();
        $model->insert($info);
        $ret = $model->deleteByProject(self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testRemoveById()
    {
        $model = new ProjectModuleModel();
        $info['project_id'] = self::$projectData['id'];
        $info['name'] = 'unittest-'.quickRandom(5).quickRandom(5);
        $info['description'] = 'descriptiondescription...'.quickRandom(10);
        $info['lead'] = 10000;
        $info['default_assignee'] = 10000;
        $info['ctime'] = time();
        list($flag, $insertId) = $model->insert($info);
        $ret = $model->removeById(self::$projectData['id'], $insertId);
        $this->assertTrue(is_numeric($ret));
    }
}
