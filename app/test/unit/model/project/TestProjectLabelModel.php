<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 *  标签模型
 */
class TestProjectLabelModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectLabelData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectLabelData = self::initProjectLabel();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * @throws \Exception
     */
    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);

        $model = new ProjectLabelModel();
        $model->deleteById(self::$projectLabelData['id']);
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
    public static function initProjectLabel($info = [])
    {
        $model = new ProjectLabelModel();
        $info['project_id'] = self::$projectData['id'];
        $info['title'] = 'unittest-'.quickRandom(5).quickRandom(5);
        $info['color'] = '#FFFFFF';
        $info['bg_color'] = '#FFFFFF';
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
    public function testGetById()
    {
        $model = new ProjectLabelModel();
        $ret = $model->getById(self::$projectLabelData['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetByName()
    {
        $model = new ProjectLabelModel();
        $ret = $model->getByName(self::$projectLabelData['title']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetByProject()
    {
        $model = new ProjectLabelModel();
        $ret = $model->getByProject(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testRemoveById()
    {
        $model = new ProjectLabelModel();
        $info['project_id'] = self::$projectData['id'];
        $info['title'] = 'unittest-1'.quickRandom(5).quickRandom(5);
        $info['color'] = '#FFFFFD';
        $info['bg_color'] = '#FFFFFf';
        list($flag, $insertId) = $model->insert($info);

        $ret = $model->removeById(self::$projectData['id'], $insertId);
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testCheckNameExist()
    {
        $model = new ProjectLabelModel();
        $ret = $model->checkNameExist(self::$projectData['id'], self::$projectLabelData['title']);
        $this->assertTrue($ret);

        $ret = $model->checkNameExist(self::$projectData['id'], quickRandom(5));
        $this->assertFalse($ret);
    }
}
