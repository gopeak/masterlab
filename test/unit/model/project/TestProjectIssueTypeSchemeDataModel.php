<?php

namespace main\test\unit\model\project;

use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectModel;
use main\test\BaseDataProvider;

/**
 * 事项类型方案子项1:M 关系的字段方案模型
 * Class TestProjectIssueTypeSchemeDataModel
 * @package main\test\unit\model\project
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
    }


    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    /**
     * @param array $info
     * @return array
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function testGetSchemeId()
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $ret = $model->getSchemeId(self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    /**
     * @throws \Exception
     */
    public function testDeleteBySchemeId()
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $issue_type_scheme_id = mt_rand(10000,1000000);
        $project = BaseDataProvider::createProject();
        $info['issue_type_scheme_id'] = $issue_type_scheme_id;
        $info['project_id'] = $project['id'];
        list($flag, $insertId) = $model->insert($info);

        $ret = $model->deleteBySchemeId($issue_type_scheme_id);
        $this->assertTrue($ret > 0);
    }

    /**
     * @throws \Exception
     */
    public function testGetByProjectId()
    {
        $model = new ProjectIssueTypeSchemeDataModel();
        $ret = $model->getByProjectId(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

}
