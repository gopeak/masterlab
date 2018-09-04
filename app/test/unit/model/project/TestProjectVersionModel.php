<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\test\BaseDataProvider;

/**
 *   项目版本模型
 */
class TestProjectVersionModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectVersionData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectVersionData = self::initProjectVersionModel();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);

        $model = new ProjectVersionModel();
        $model->deleteById(self::$projectVersionData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    public static function initProjectVersionModel($info = [])
    {
        $model = new ProjectVersionModel();
        $info['project_id'] = self::$projectData['id'];
        $info['name'] = 'test-v'.self::$projectData['id'].'-'.quickRandom(3).quickRandom(3);
        $info['description'] = 'test-description-'.self::$projectData['id'].'-'.quickRandom(3).quickRandom(3);
        $info['released'] = 1;
        $info['start_date'] = time();
        $info['release_date'] = time();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__METHOD__ . '  failed,' . $insertId);
            return [];
        }
        return $model->getRowById($insertId);
    }

    public function testGetAll()
    {
        $model = new ProjectVersionModel();
        $ret = $model->getAll();
        $this->assertTrue(is_array($ret));
        if (count($ret) > 0) {
            $assert = current($ret);
            $this->assertTrue(is_array($assert));
        } else {
            $this->assertEmpty($ret);
        }
    }

    public function testGetByProject()
    {
        $model = new ProjectVersionModel();
        $ret = $model->getByProject(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetByProjectPrimaryKey()
    {
        $model = new ProjectVersionModel();
        $ret = $model->getByProjectPrimaryKey(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetByProjectIdName()
    {
        $model = new ProjectVersionModel();
        $ret = $model->getByProjectIdName(self::$projectData['id'], self::$projectVersionData['name']);
        $this->assertTrue(is_array($ret));
    }

    public function testUpdateReleaseStatus()
    {
        $model = new ProjectVersionModel();
        $ret = $model->updateReleaseStatus(self::$projectData['id'], self::$projectVersionData['id']);
        $this->assertTrue($ret);
    }

    public function testDeleteByVersinoId()
    {
        $model = new ProjectVersionModel();
        $info['project_id'] = self::$projectData['id'];
        $info['name'] = 'test-v'.self::$projectData['id'].'-'.quickRandom(3).quickRandom(3);
        $info['description'] = 'test-description-'.self::$projectData['id'].'-'.quickRandom(3).quickRandom(3);
        $info['released'] = 1;
        $info['start_date'] = time();
        $info['release_date'] = time();
        list($flag, $insertId) = $model->insert($info);

        $ret = $model->deleteByVersinoId(self::$projectData['id'], $insertId);
        $this->assertTrue(is_numeric($ret));

        $ret = $model->getRowById($insertId);
        $this->assertEmpty($ret);
    }

    public function testDeleteByProject()
    {
        $model = new ProjectVersionModel();
        $info['project_id'] = 999999;
        $info['name'] = 'test-v'.self::$projectData['id'].'-'.quickRandom(3).quickRandom(3);
        $info['description'] = 'test-description-'.self::$projectData['id'].'-'.quickRandom(3).quickRandom(3);
        $info['released'] = 1;
        $info['start_date'] = time();
        $info['release_date'] = time();
        list($flag, $insertId) = $model->insert($info);

        $ret = $model->deleteByProject($info['project_id']);
        $this->assertTrue(is_numeric($ret));

        $ret = $model->getByProject($info['project_id']);
        $this->assertEmpty($ret);
    }

    public function testCheckNameExist()
    {
        $model = new ProjectVersionModel();
        $ret = $model->checkNameExist(self::$projectData['id'], self::$projectVersionData['name']);
        $this->assertTrue($ret);

        $ret = $model->checkNameExist(self::$projectData['id'], quickRandom(6));
        $this->assertFalse($ret);
    }

    public function testCheckNameExistExcludeCurrent()
    {
        $this->markTestIncomplete();
    }

}