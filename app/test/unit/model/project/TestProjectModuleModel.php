<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 *   项目模块模型
 */
class TestProjectModuleModel extends TestBaseProjectModel
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
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }


    public function testGetByProject()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetByProjectWithUser()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetByProjectWithUserLikeName()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testDeleteByProject()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testRemoveById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetAllCount()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testCheckNameExist()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testCheckNameExistExcludeCurrent()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }


    public function testGetById()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    public function testGetByName()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
