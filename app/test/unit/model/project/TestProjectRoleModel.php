<?php
namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\test\BaseDataProvider;

/**
 * 项目拥有的角色 模型
 */
class TestProjectRoleModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectRoleData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectRoleData = self::initProjectRoleModel();
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

        $model = new ProjectRoleModel();
        $model->deleteById(self::$projectRoleData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    /**
     * @throws \Exception
     */
    public static function initProjectRoleModel($info = [])
    {
        $model = new ProjectRoleModel();
        $info['project_id'] = self::$projectData['id'];
        $info['name'] = 'unittest-'.quickRandom(5).quickRandom(5);
        $info['description'] = 'descriptiondescription...'.quickRandom(10);
        $info['is_system'] = 1;
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
        $model = new ProjectRoleModel();
        $ret = $model->getById(self::$projectRoleData['id']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetByName()
    {
        $model = new ProjectRoleModel();
        $ret = $model->getByName(self::$projectRoleData['name']);
        $this->assertTrue(is_array($ret));
    }

    /**
     * @throws \Exception
     */
    public function testGetsAll()
    {
        $model = new ProjectRoleModel();
        $ret = $model->getsAll();
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
    public function testGetsByProject()
    {
        $model = new ProjectRoleModel();
        $ret = $model->getsByProject(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
        if (count($ret) > 0) {
            $assert = current($ret);
            $this->assertTrue(is_array($assert));
        } else {
            $this->assertEmpty($ret);
        }
    }
}
