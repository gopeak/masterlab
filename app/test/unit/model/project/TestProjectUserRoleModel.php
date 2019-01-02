<?php

namespace main\app\test\unit\model\project;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\test\BaseDataProvider;

/**
 * 项目的中的用户所拥有的角色
 */
class TestProjectUserRoleModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectUserRoleData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectUserRoleData = self::initProjectUserRoleModel();
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

        $model = new ProjectUserRoleModel();
        $model->deleteById(self::$projectUserRoleData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    /**
     * @throws \Exception
     */
    public static function initProjectUserRoleModel($info = [])
    {
        $model = new ProjectUserRoleModel();
        $info['user_id'] = 99999;
        $info['project_id'] = self::$projectData['id'];
        $info['role_id'] = 10000;
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
    public function testGetUserRolesByProject()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getUserRolesByProject(self::$projectUserRoleData['user_id'], self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetCountUserRolesByProject()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getCountUserRolesByProject(self::$projectUserRoleData['user_id'], self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testAdd()
    {
        $model = new ProjectUserRoleModel();

        // 检查一般插入
        $userId = 99999;
        $projectId = self::$projectData['id'];
        $roleId = 99999;
        $ret = $model->add($projectId, $userId, $roleId);
        $this->assertEquals(true, $ret[0]);

        // 测试表唯一索引是否生效 UNIQUE KEY `unique` (`user_id`,`project_id`,`role_id`)
        $ret1 = $model->add($projectId, $userId, $roleId);
        $this->assertEquals(false, $ret1[0]);

        $model->deleteById($ret[1]);
    }

    /**
     * @throws \Exception
     */
    public function testDel()
    {
        $model = new ProjectUserRoleModel();
        $info['user_id'] = 199999;
        $info['project_id'] = self::$projectData['id'];
        $info['role_id'] = 10000;
        $model->insert($info);

        $ret = $model->del($info['user_id'], $info['role_id']);
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetUserRoles()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getUserRoles(self::$projectUserRoleData['user_id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetsRoleId()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getsRoleId(self::$projectUserRoleData['role_id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetsByUid()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getsByUid(self::$projectUserRoleData['user_id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testInsertRole()
    {
        $model = new ProjectUserRoleModel();

        // 检查一般插入
        $userId = 99999;
        $projectId = self::$projectData['id'];
        $roleId = 99999;
        $ret = $model->insertRole($userId, $projectId, $roleId);
        $this->assertEquals(true, $ret[0]);

        // 测试表唯一索引是否生效 UNIQUE KEY `unique` (`user_id`,`project_id`,`role_id`)
        $ret1 = $model->insertRole($userId, $projectId, $roleId);
        $this->assertEquals(false, $ret1[0]);

        $model->deleteById($ret[1]);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteByProjectRole()
    {
        $model = new ProjectUserRoleModel();
        $info['user_id'] = 199999;
        $info['project_id'] = self::$projectData['id'];
        $info['role_id'] = 199999;
        $model->insert($info);

        $ret = $model->deleteByProjectRole($info['user_id'], $info['project_id'], $info['role_id']);
        $this->assertTrue(is_numeric($ret));
        $ret = $model->getRow("*", $info);
        $this->assertEmpty($ret);
    }

    /**
     * @throws \Exception
     */
    public function testGetUidsByProjectRole()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getUidsByProjectRole(
            array(self::$projectData['id']),
            array(self::$projectUserRoleData['role_id'])
        );
        $this->assertTrue(is_array($ret));
    }
}
