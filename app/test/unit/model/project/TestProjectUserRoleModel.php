<?php

namespace main\app\test\unit\model\project;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 * 项目的中的用户所拥有的角色
 */
class TestProjectUserRoleModel extends TestBaseProjectModel
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
     * 用户拥有的项目
     * @param $userId
     * @param $projectId
     * @return array
     */
    public function testGetUserRolesByProject()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 用户所在项目总数
     * @param $userId
     * @param $projectId
     * @return int
     */
    public function testGetCountUserRolesByProject()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }


    /**
     * 新增
     * @param $roleId
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function testAdd()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 删除
     * @param $roleId
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public function testDel()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * @param $userId
     * @return array
     */
    public function testGetUserRoles()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * @param $roleId
     * @return array
     */
    public function testGetsRoleId()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * 获取某个用户组的角色列表
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function testGetsByUid()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * @param $userId
     * @param $projectId
     * @param $roleId
     * @return array
     * @throws \Exception
     */
    public function testInsertRole()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * @param $userId
     * @param $projectId
     * @param $roleId
     * @return int
     */
    public function testDeleteByProjectRole()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }

    /**
     * @param $projectIds
     * @param $roleIds
     * @return array
     */
    public function testGetUidsByProjectRole()
    {
        $this->markTestIncomplete( 'TODO:' . __METHOD__  );
    }
}
