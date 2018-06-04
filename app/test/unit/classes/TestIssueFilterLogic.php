<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
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

        $user = IssueFilterLogicDataProvider::initUser();
        UserAuth::getInstance()->login($user, 300);

        $logic = new IssueFilterLogic();

        // 无数据查询
        $_GET['project'] = $projectId;
        list($ret, $rows, $count) = $logic->getIssuesByFilter(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($rows);
        $this->assertEquals(0, $count);

        // 构建 issue 测试数据
        $info = [];
        $info['project_id'] = $projectId;
        $info['issue_type'] = IssueTypeModel::getInstance()->getIdByKey('bug');
        $info['priority'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $info['module'] = $module['id'];
        $info['sprint'] = $sprint['id'];
        $info['creator'] = $user['uid'];
        $info['modifier'] = $user['uid'];
        $info['reporter'] = $user['uid'];
        $info['assignee'] = $user['uid'];

        $issues = [];
        $readyCount = 6;
        for ($i = 0; $i < $readyCount; $i++) {
            $issues[] = IssueFilterLogicDataProvider::initIssue($info);
        }

        $_GET['project'] = $projectId;
        list($ret, $arr, $count) = $logic->getIssuesByFilter(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);
    }
}
