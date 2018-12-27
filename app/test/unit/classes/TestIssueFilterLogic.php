<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\model\project\ProjectModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\ProjectLabelModel;
use PHPUnit\Framework\TestCase;

/**
 * 事项查询业务逻辑的测试类
 * Class TestIssueFilterLogic
 * @package main\app\test\logic
 */
class TestIssueFilterLogic extends TestCase
{

    public static $projectId = null;

    public static function setUpBeforeClass()
    {
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        $model = new ProjectModel();
        $model->deleteById(self::$projectId);
        AgileLogicDataProvider::clear();
        IssueFilterLogicDataProvider::clear();
    }

    /**
     * @throws \Exception
     */
    public function testGetIssuesByFilter()
    {
        // 构建项目数据
        self::$projectId = $projectId = IssueFilterLogicDataProvider::initProject()['id'];
        $info = [];
        $info['project_id'] = $projectId;
        $sprint = IssueFilterLogicDataProvider::initSprint($info);

        $info = [];
        $info['project_id'] = $projectId;
        $module = IssueFilterLogicDataProvider::initModule($info);

        $user = IssueFilterLogicDataProvider::initUser();
        UserAuth::getInstance()->login($user, 300);

        $logic = new IssueFilterLogic();

        // 无参数查询
        $_GET['project'] = $projectId;
        list($ret, $rows, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertEmpty($rows);
        $this->assertEquals(0, $count);

        // 构建 issue 测试数据
        $info = [];
        $info['project_id'] = $projectId;
        $info['issue_type'] = IssueTypeModel::getInstance()->getIdByKey('bug');
        $info['priority'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $info['resolve'] = IssueResolveModel::getInstance()->getIdByKey('done');
        $info['module'] = $module['id'];
        $info['sprint'] = $sprint['id'];
        $info['creator'] = $user['uid'];
        $info['modifier'] = $user['uid'];
        $info['reporter'] = $user['uid'];
        $info['assignee'] = $user['uid'];
        $info['updated'] = time();
        $info['start_date'] = date('Y-m-d');
        $info['due_date'] = date('Y-m-d', time() + 3600 * 24 * 7);
        $info['resolve_date'] = date('Y-m-d', time() + 3600 * 24 * 7);

        $issues = [];
        $readyCount = 4;
        for ($i = 0; $i < $readyCount; $i++) {
            $info['summary'] = 'testFilterSummary' . $i . 'Rand' . mt_rand(12345678, 92345678);
            $issues[] = IssueFilterLogicDataProvider::initIssue($info);
        }

        $_GET['project'] = $projectId;
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        $_GET['assignee_username'] = $user['username'];
        $_GET['assignee'] = $user['uid'];
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['author'] = $user['uid'];
        $_GET['reporter_uid'] = $user['uid'];
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['search'] = $issues[0]['summary'];
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        //$this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['module'] = $module['name'];
        $_GET['module_id'] = $module['id'];
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['priority'] = 'high';
        $_GET['priority_id'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['resolve'] = 'done';
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['status'] = 'open';
        $_GET['status_id'] = IssueStatusModel::getInstance()->getIdByKey('open');
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['created_start'] = time() - 10;
        $_GET['created_end'] = time() + 10;
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['updated_start'] = time() - 10;
        $_GET['updated_end'] = time() + 10;
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['sort_field'] = 'id';
        $_GET['sort_by'] = 'DESC';
        list($ret, $arr, $count) = $logic->getList(1, 2);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);

        if ($_GET['sys_filter'] = 'assignee_mine') {
            list($ret, $arr, $count) = $logic->getList(1, 2);
            $this->assertTrue($ret);
            $this->assertNotEmpty($arr);
            $this->assertEquals($readyCount, $count);
        }
        if ($_GET['sys_filter'] = 'my_report') {
            list($ret, $arr, $count) = $logic->getList(1, 2);
            $this->assertTrue($ret);
            $this->assertNotEmpty($arr);
            $this->assertEquals($readyCount, $count);
        }

        if ($_GET['sys_filter'] = 'update_recently') {
            list($ret, $arr, $count) = $logic->getList(1, 2);
            $this->assertTrue($ret);
            $this->assertNotEmpty($arr);
            $this->assertEquals($readyCount, $count);
        }

        if ($_GET['sys_filter'] = 'open') {
            list($ret, $arr, $count) = $logic->getList(1, 2);
            $this->assertTrue($ret);
            $this->assertNotEmpty($arr);
            $this->assertEquals($readyCount, $count);
        }

        // 构建 issue 测试数据
        $info = [];
        $info['project_id'] = $projectId;
        $info['issue_type'] = IssueTypeModel::getInstance()->getIdByKey('bug');
        $info['priority'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('resolved');
        $info['resolve'] = IssueResolveModel::getInstance()->getIdByKey('done');
        $info['module'] = $module['id'];
        $info['sprint'] = $sprint['id'];
        $info['creator'] = $user['uid'];
        $info['modifier'] = $user['uid'];
        $info['reporter'] = $user['uid'];
        $info['assignee'] = $user['uid'];
        $info['updated'] = time();
        $info['start_date'] = date('Y-m-d');
        $info['due_date'] = date('Y-m-d', time() + 3600 * 24 * 7);
        $info['resolve_date'] = date('Y-m-d', time() + 3600 * 24 * 7);

        $issues = [];
        $doneCount = 2;
        for ($i = 0; $i < $doneCount; $i++) {
            $info['summary'] = 'testDoneSummary' . $i . 'Rand' . mt_rand(12345678, 92345678);
            $issues[] = IssueFilterLogicDataProvider::initIssue($info);
        }
        if ($_GET['sys_filter'] = 'recently_resolve') {
            list($ret, $arr, $count) = $logic->getList(1, 2);
            $this->assertTrue($ret);
            $this->assertNotEmpty($arr);
            $this->assertEquals($doneCount, $count);
        }
        if ($_GET['sys_filter'] = 'done') {
            list($ret, $arr, $count) = $logic->getList(1, 2);
            $this->assertTrue($ret);
            $this->assertNotEmpty($arr);
            $this->assertEquals($doneCount, $count);
        }
        $readyCount = $readyCount + $doneCount;

        // 所有条件都满足的查询
        unset($_GET);
        $_GET['project'] = $projectId;
        $_GET['assignee_username'] = $user['username'];
        $_GET['assignee'] = $user['uid'];
        $_GET['author'] = $user['uid'];
        $_GET['reporter_uid'] = $user['uid'];
        //$_GET['search'] = $issues[0]['summary'];
        $_GET['module'] = $module['name'];
        $_GET['module_id'] = $module['id'];
        $_GET['priority'] = 'high';
        $_GET['priority_id'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        $_GET['resolve'] = 'done';
        //$_GET['status'] = 'open';
        //$_GET['status_id'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $_GET['created_start'] = time() - 10;
        $_GET['created_end'] = time() + 100;
        //$_GET['updated_start'] = time() - 10;
        //$_GET['updated_end'] = time() + 10;
        $_GET['sort_field'] = 'id';
        $_GET['sort_by'] = 'DESC';
        list($ret, $arr, $count) = $logic->getList(1, 10);
        $this->assertTrue($ret);
        $this->assertNotEmpty($arr);
        $this->assertEquals($readyCount, $count);
    }
}
