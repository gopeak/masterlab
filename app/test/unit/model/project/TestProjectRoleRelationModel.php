<?php

namespace main\app\test\unit\model\project;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;


/**
 * 项目的用户角色所拥有的权限
 */
class TestProjectRoleRelationModel extends TestBaseProjectModel
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

    /**
     * 获取某个角色权限id列表
     * @param $roleId
     * @return array
     */
    public function testGetPermIdsByRoleId()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 新增
     * @param $roleId
     * @param $permId
     * @return array
     * @throws \Exception
     */
    public function testAdd()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 获取多个角色的权限
     * @param $roleIds
     * @return array
     */
    public function testGetPermIdsByRoleIds()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 删除某个角色的关联数据
     * @param $roleId
     * @return int
     */
    public function testDeleteByRoleId()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
