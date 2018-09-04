<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\model\project\ReportProjectIssueModel;
use main\app\test\BaseDataProvider;

/**
 *  项目汇总表模型
 */
class TestReportProjectIssueModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $reportProjectIssueData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$reportProjectIssueData = self::initReportProjectIssueModel();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    public static function clearData()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectData['id']);

        $model = new ReportProjectIssueModel();
        $model->deleteById(self::$reportProjectIssueData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    public static function initReportProjectIssueModel($info = [])
    {
        $model = new ReportProjectIssueModel();
        $info['project_id'] = self::$projectData['id'];
        $info['date'] = date('Y-m-d H:i:s', time());

        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__METHOD__ . '  failed,' . $insertId);
            return [];
        }
        return $model->getRowById($insertId);
    }

    public function testGetById()
    {
        $model = new ReportProjectIssueModel();
        $ret = $model->getById(self::$reportProjectIssueData['id']);
        $this->assertTrue(is_array($ret));
    }

    public function testGetsByProject()
    {
        $model = new ReportProjectIssueModel();
        $ret = $model->getById(self::$projectData['id']);
        $this->assertTrue(is_array($ret));
    }

    public function testRemoveById()
    {
        $model = new ReportProjectIssueModel();
        $ret = $model->removeById(self::$projectData['id'], self::$reportProjectIssueData['id']);
        $this->assertTrue(is_numeric($ret));
    }

    public function testRemoveByProject()
    {
        $model = new ReportProjectIssueModel();
        $ret = $model->removeByProject(self::$projectData['id']);
        $this->assertTrue(is_numeric($ret));
    }
}
