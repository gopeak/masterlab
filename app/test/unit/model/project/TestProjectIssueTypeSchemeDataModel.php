<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;

/**
 * 事项类型方案子项1:M 关系的字段方案模型
 * Class TestProjectIssueTypeSchemeDataModel
 * @package main\app\test\unit\model\project
 */
class TestProjectIssueTypeSchemeDataModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectIssueTypeSchemeData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectIssueTypeSchemeData = self::initProjectIssueTypeSchemeData();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);

        $model = new ProjectIssueTypeSchemeDataModel();
        $model->deleteById(self::$projectIssueTypeSchemeData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    public static function initProjectIssueTypeSchemeData($info = [])
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $info['issue_type_scheme_id'] = 6;
        $info['project_id'] = self::$projectData['id'];
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__METHOD__ . '  failed,' . $insertId);
            return [];
        }
        return $model->getRowById($insertId);
    }

    public function testGetSchemeId()
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $ret = $model->getSchemeId(self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    public function testDeleteBySchemeId()
    {
        $model = new ProjectIssueTypeSchemeDataModel();

        $info['issue_type_scheme_id'] = 5;
        $info['project_id'] = self::$projectData['id'];
        list($flag, $insertId) = $model->insert($info);

        $ret = $model->deleteBySchemeId($insertId);
        $this->assertTrue($ret > 0);
    }

    public function testGetByProjectId()
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $ret = $model->getByProjectId(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

}
