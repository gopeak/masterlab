<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\test\BaseDataProvider;

/**
 * 项目的用户角色所拥有的权限
 */
class TestProjectRoleRelationModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectRoleRelationtData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectRoleRelationtData = self::initProjectRoleRelationModel();
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

        $model = new ProjectRoleRelationModel();
        $model->deleteById(self::$projectRoleRelationtData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    /**
     * @throws \Exception
     */
    public static function initProjectRoleRelationModel($info = [])
    {
        $model = new ProjectRoleRelationModel();
        $info['project_id'] = self::$projectData['id'];
        $info['role_id'] = 1;
        $info['perm_id'] = 2;
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
    public function testGetPermIdsByRoleId()
    {
        $model = new ProjectRoleRelationModel();
        $ret = $model->getPermIdsByRoleId(self::$projectRoleRelationtData['role_id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testAdd()
    {
        $model = new ProjectRoleRelationModel();
        $ret = $model->add(self::$projectData['id'], 1, 2);
        $this->assertEquals(true, $ret[0]);
        $model->deleteById($ret[1]);
    }

    /**
     * @throws \Exception
     */
    public function testGetPermIdsByRoleIds()
    {
        $model = new ProjectRoleRelationModel();
        $ret = $model->getPermIdsByRoleIds(array(self::$projectRoleRelationtData['role_id']));
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testDeleteByRoleId()
    {
        $model = new ProjectRoleRelationModel();
        $info['project_id'] = self::$projectData['id'];
        $info['role_id'] = 9999;
        $info['perm_id'] = 2;
        $model->insert($info);

        $ret = $model->deleteByRoleId($info['role_id']);
        $this->assertTrue(is_numeric($ret));

        $ret = $model->getPermIdsByRoleId($info['role_id']);
        $this->assertEmpty($ret);
    }
}
