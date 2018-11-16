<?php

namespace main\app\test\unit\model\project;
use main\app\model\project\ProjectFlagModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;


/**
 *  项目标识模型
 */
class TestProjectFlagModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectFlagData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectFlagData = self::initProjectFlag();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);

        $model = new ProjectFlagModel();
        $model->deleteById(self::$projectFlagData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    public static function initProjectFlag($info = [])
    {
        $model = new ProjectFlagModel();
        $info['project_id'] = self::$projectData['id'];
        $info['flag'] = 'TEST_'.quickRandom(8).'_'.time();//'sprint_6_weight';
        $info['value'] = '{"16372":300000,"16362":200000,"14118":100000}';
        $info['update_time'] = time();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__METHOD__ . '  failed,' . $insertId);
            return [];
        }
        return $model->getRowById($insertId);
    }

    public function testAdd()
    {
        $model = new ProjectFlagModel();
        $projectId = 90401;
        $flag = 'sprint_4_weight';
        $value = '{"10125":200000,"10124":100000}';
        $ret = $model->add($projectId, $flag, $value);

        $this->assertEquals(true, $ret[0]);
        $model->deleteById($ret[1]);
    }

    public function testGetById()
    {
        $model = new ProjectFlagModel();
        $ret = $model->getById(self::$projectFlagData['id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetByFlag()
    {
        $model = new ProjectFlagModel();
        $ret = $model->getByFlag(self::$projectData['id'], self::$projectFlagData['id']);
        $this->assertTrue(is_array($ret));

        $model = new ProjectFlagModel();
        $ret = $model->getByFlag(self::$projectData['id'], 'hhhhhhh');
        $this->assertEmpty($ret);
    }

    public function testGetValueByFlag()
    {
        $model = new ProjectFlagModel();
        $ret = $model->getValueByFlag(self::$projectData['id'], self::$projectFlagData['flag']);
        $this->assertEquals($ret, self::$projectFlagData['value']);
        $errValue = quickRandom(5);
        $this->assertNotEquals($ret, $errValue);
    }
}
