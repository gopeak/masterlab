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

    public function testGetUserRolesByProject()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getUserRolesByProject(self::$projectUserRoleData['user_id'], self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetCountUserRolesByProject()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getCountUserRolesByProject(self::$projectUserRoleData['user_id'], self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    public function testAdd()
    {
        $this->markTestIncomplete('TODO:' . __METHOD__);
    }

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

    public function testGetUserRoles()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getUserRoles(self::$projectUserRoleData['user_id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetsRoleId()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getsRoleId(self::$projectUserRoleData['role_id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetsByUid()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getsByUid(self::$projectUserRoleData['user_id']);
        $this->assertTrue(is_array($ret));
    }

    public function testInsertRole()
    {
        $this->markTestIncomplete('TODO:' . __METHOD__);
    }

    public function testDeleteByProjectRole()
    {
        $this->markTestIncomplete('TODO:' . __METHOD__);
    }

    public function testGetUidsByProjectRole()
    {
        $model = new ProjectUserRoleModel();
        $ret = $model->getUidsByProjectRole(array(self::$projectData['id']), array(self::$projectUserRoleData['role_id']));
        $this->assertTrue(is_array($ret));
    }
}
