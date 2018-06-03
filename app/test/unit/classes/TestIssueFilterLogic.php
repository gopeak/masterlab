<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueFilterLogic;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\ProjectLabelModel;
use PHPUnit\Framework\TestCase;

/**
 * 敏捷模块业务逻辑
 * Class AgileLogic
 * @package main\app\test\logic
 */
class TestIssueFilterLogic extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        AgileLogicDataProvider::clear();
    }

    public function testGetIssuesByFilter()
    {
        // 构建项目数据
        $projectId = IssueFilterLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $sprint = IssueFilterLogicDataProvider::initSprint($info);

        $info = [];
        $info['project_id'] = $projectId;
        $module = IssueFilterLogicDataProvider::initModule($info);

        $info = [];
        $info['project_id'] = $projectId;
        $verison = IssueFilterLogicDataProvider::initVersion($info);

        $logic = new IssueFilterLogic();

        // 无数据查询
        $_GET['project'] = $projectId;
        list($ret, $rows, $count) = $logic->getIssuesByFilter(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($rows);
        $this->assertEquals(0, $count);

        // 构建 issue 测试数据
    }
}
