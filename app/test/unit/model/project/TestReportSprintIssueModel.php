<?php

namespace main\app\test\unit\model\project;

use main\app\model\project\ProjectModel;
use main\app\model\project\ReportSprintIssueModel;
use main\app\test\BaseDataProvider;

/**
 *  迭代汇总表模型
 */
class TestReportSprintIssueModel extends TestBaseProjectModel
{

    public static $projectData = [];
    public static $projectSprintData = [];
    public static $projectSprintReportData = [];

    public static function setUpBeforeClass()
    {
        self::$projectData = self::initProject();
        self::$projectSprintData = self::initProjectSprint();
        self::$projectSprintReportData = self::initProjectSprintReport();
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

        BaseDataProvider::deleteSprint(self::$projectSprintData['id']);

        $model = new ReportSprintIssueModel();
        $model->deleteById(self::$projectSprintReportData['id']);
    }

    public static function initProject($info = [])
    {
        $row = BaseDataProvider::createProject($info);
        return $row;
    }

    public static function initProjectSprint($info = [])
    {
        $row = BaseDataProvider::createSprint($info);
        return $row;
    }

    /**
     * @throws \Exception
     */
    public static function initProjectSprintReport()
    {
        $model = new ReportSprintIssueModel();
        $info['sprint_id'] = self::$projectSprintData['id'];
        $info['date'] = '2018-09-02';
        $info['week'] = 4;
        $info['month'] = '08';
        $info['count_done'] = 2;
        $info['count_no_done'] = 2;
        $info['count_done_by_resolve'] = 2;
        $info['count_no_done_by_resolve'] = 2;
        $info['today_done_points'] = 2;
        $info['today_done_number'] = 2;
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
        $model = new ReportSprintIssueModel();
        $ret = $model->getById(self::$projectSprintReportData['id']);
        $this->assertNotEmpty($ret);
    }

    /**
     * @throws \Exception
     */
    public function testGetsBySprint()
    {
        $model = new ReportSprintIssueModel();
        $ret = $model->getsBySprint(self::$projectSprintReportData['sprint_id']);
        $this->assertNotEmpty($ret);
    }

    /**
     * @throws \Exception
     */
    public function testRemoveById()
    {
        $model = new ReportSprintIssueModel();

        $info['sprint_id'] = self::$projectSprintData['id'];
        $info['date'] = '2018-09-02';
        $info['week'] = 4;
        $info['month'] = '08';
        $info['count_done'] = 2;
        $info['count_no_done'] = 2;
        $info['count_done_by_resolve'] = 2;
        $info['count_no_done_by_resolve'] = 2;
        $info['today_done_points'] = 2;
        $info['today_done_number'] = 2;
        list($ret, $insertId) = $model->insert($info);

        $model->removeById($info['sprint_id'], $insertId);

        $ret = $model->getRow("*", array('sprint_id' => $info['sprint_id'], 'id' => $insertId));

        $this->assertEmpty($ret);
    }

    /**
     * @throws \Exception
     */
    public function testRemoveBySprint()
    {
        $model = new ReportSprintIssueModel();

        $info['sprint_id'] = 100000000 + mt_rand(100000, 999999);
        $info['date'] = '2018-09-02';
        $info['week'] = 4;
        $info['month'] = '08';
        $info['count_done'] = 2;
        $info['count_no_done'] = 2;
        $info['count_done_by_resolve'] = 2;
        $info['count_no_done_by_resolve'] = 2;
        $info['today_done_points'] = 2;
        $info['today_done_number'] = 2;
        list($ret, $insertId) = $model->insert($info);

        $ret = $model->getRow("*", array('sprint_id' => $info['sprint_id']));
        $this->assertNotEmpty($ret);

        $model->removeBySprint($info['sprint_id']);

        $ret = $model->getRow("*", array('sprint_id' => $info['sprint_id']));
        $this->assertEmpty($ret);
    }
}
