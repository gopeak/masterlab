<?php

namespace main\app\test\unit\model\project;

use main\app\classes\ProjectLogic;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 * ProjectModel 测试类
 * User: Lyman
 */
class TestProjectModel extends TestBaseProjectModel
{

    public static $project = [];

    public static function setUpBeforeClass()
    {
        self::$project = self::initProject();
    }

    /**
     * 确保生成的测试数据被清除
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 清除数据
     * @throws \Exception
     */
    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$project['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    /**
     * @throws \Exception
     */
    public function testGetAllCount()
    {
        $model = new ProjectModel();
        $ret = $model->getAllCount();
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetAll()
    {
        $model = new ProjectModel();
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
    public function testFilterByType()
    {
        $model = new ProjectModel();
        $ret = $model->filterByType(ProjectLogic::PROJECT_TYPE_SCRUM);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(array_key_exists(0, $ret));

        $ret = $model->filterByType(ProjectLogic::PROJECT_TYPE_SCRUM, true);
        $this->assertTrue(is_array($ret));
        $assert = current($ret);
        $this->assertTrue(array_key_exists($assert['id'], $ret));
    }

    /**
     * @throws \Exception
     */
    public function testFilterByNameOrKey()
    {
        $model = new ProjectModel();
        $keyword = strtoupper(quickRandom(5));
        $ret = $model->filterByNameOrKey($keyword);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetFilter()
    {
        $model = new ProjectModel();
        $ret = $model->getFilter(1, 20);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testUpdateById()
    {
        $str = quickRandom(5);
        $updateData = array('description' => $str);
        $model = new ProjectModel();
        $ret = $model->updateById($updateData, self::$project['id']);
        $this->assertTrue($ret[0]);
        $ret = $model->getById(self::$project['id']);
        $this->assertEquals($ret['description'], $str);
    }

    /**
     * @throws \Exception
     */
    public function testGetKeyById()
    {
        $model = new ProjectModel();
        $ret = $model->getKeyById(self::$project['id']);
        $this->assertEquals($ret, self::$project['key']);
    }

    /**
     * @throws \Exception
     */
    public function testGetById()
    {
        $model = new ProjectModel();
        $ret = $model->getById(self::$project['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetNameById()
    {
        $model = new ProjectModel();
        $ret = $model->getNameById(self::$project['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetByKey()
    {
        $model = new ProjectModel();
        $ret = $model->getByKey(self::$project['key']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetByName()
    {
        $model = new ProjectModel();
        $ret = $model->getByName(self::$project['name']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetsByOrigin()
    {
        $model = new ProjectModel();
        $ret = $model->getsByOrigin(self::$project['org_id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testCheckNameExist()
    {
        $model = new ProjectModel();
        $ret = $model->checkNameExist(self::$project['name']);
        $this->assertTrue($ret);

        $randName = quickRandom(5);
        $ret = $model->checkNameExist($randName);
        $this->assertFalse($ret);
    }

    /**
     * @throws \Exception
     */
    public function testCheckIdNameExist()
    {
        $model = new ProjectModel();
        $ret = $model->checkIdNameExist(self::$project['id'], self::$project['name']);
        $this->assertFalse($ret);

        $randName = quickRandom(5);
        $ret = $model->checkIdNameExist(123, self::$project['name']);
        $this->assertTrue($ret);
    }

    /**
     * @throws \Exception
     */
    public function testCheckKeyExist()
    {
        $model = new ProjectModel();
        $ret = $model->checkKeyExist(self::$project['key']);
        $this->assertTrue($ret);

        $randName = quickRandom(5);
        $ret = $model->checkKeyExist($randName);
        $this->assertFalse($ret);
    }

    /**
     * @throws \Exception
     */
    public function testCheckIdKeyExist()
    {
        $model = new ProjectModel();
        $ret = $model->checkIdKeyExist(self::$project['id'], self::$project['key']);
        $this->assertFalse($ret);

        $randName = quickRandom(5);
        $ret = $model->checkIdKeyExist(123, self::$project['key']);
        $this->assertTrue($ret);
    }
}
