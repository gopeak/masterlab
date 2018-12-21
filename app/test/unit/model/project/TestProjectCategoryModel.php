<?php
namespace main\app\test\unit\model\project;
use main\app\model\project\ProjectCategoryModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 *   项目模型
 */
class TestProjectCategoryModel extends TestBaseProjectModel
{

    public static $projectData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    public function testGetAll()
    {
        $model = new ProjectCategoryModel();
        $ret = $model->getAll();
        $this->assertTrue(is_array($ret));
        if (count($ret) > 0) {
            $assert = current($ret);
            $this->assertTrue(is_array($assert));
        } else {
            $this->assertEmpty($ret);
        }
    }


    public function testGetByName()
    {
        $model = new ProjectCategoryModel();
        $keyword = strtoupper(quickRandom(5));
        $ret = $model->getByName($keyword);
        $this->assertEmpty($ret);
    }
    
}