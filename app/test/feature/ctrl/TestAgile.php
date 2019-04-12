<?php

namespace main\app\test\featrue\ctrl;

use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;
use main\app\model\issue\IssueStatusModel;
use main\app\classes\AgileLogic;
use main\app\model\issue\IssueModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectModel;
use main\app\model\OrgModel;

/**
 * 敏捷模块的功能测试
 * @version
 * @link
 */
class TestAgile extends BaseAppTestCase
{
    public static $clean = [];

    public static $sprints = [];

    public static $issues = [];

    public static $currentOrg = [];

    public static $currentProject = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // 创建组织
        self::$currentOrg = BaseDataProvider::createOrg();

        // 创建一个项目,并指定权限方案为默认
        $info['permission_scheme_id'] = 0;
        $info['org_id'] = self::$currentOrg['id'];
        $info['org_path'] = self::$currentOrg['path'];
        self::$currentProject = BaseDataProvider::createProject($info);
        $projectId = self::$currentProject['id'];

        // 创建sprint
        $info = [];
        $info['project_id'] = $projectId;
        self::$sprints[] = BaseDataProvider::createSprint($info);
        self::$sprints[] = BaseDataProvider::createSprint($info);
        self::$sprints[] = BaseDataProvider::createSprint($info);

        //创建backlog's issue
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogic::BACKLOG_VALUE;
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        self::$issues[] = BaseDataProvider::createIssue($info);
        self::$issues[] = BaseDataProvider::createIssue($info);
        self::$issues[] = BaseDataProvider::createIssue($info);
    }

    /**
     * tearDown 执行后执行此方法
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        $model = new ProjectModel();
        $model->deleteById(self::$currentProject['id']);

        $model = new IssueModel();
        foreach (self::$issues as $issue) {
            $model->deleteById($issue['id']);
        }

        $model = new SprintModel();
        foreach (self::$sprints as $issue) {
            $model->deleteById($issue['id']);
        }
        $model->deleteByProjectId(self::$currentProject['id']);

        $model = new ProjectModel();
        $model->deleteById(self::$currentProject['id']);

        $model = new OrgModel();
        $model->deleteById(self::$currentOrg['id']);
    }

    /**
     * 测试页面
     */
    public function testPageBacklog()
    {
        $url = ROOT_URL . self::$currentProject['org_path'] . "/" . self::$currentProject['key'] . '/backlog';
        $curl = BaseAppTestCase::$userCurl;
        $curl->get($url);
        $resp = BaseAppTestCase::$userCurl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * 获取待办事项列表
     */
    public function testGetBacklogIssues()
    {
        // http://masterlab.ink/agile/fetch_backlog_issues/1
        $url = ROOT_URL . 'agile/fetch_backlog_issues/' . self::$currentProject['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get($url);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/fetch_backlog_issues failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        $this->assertEquals(count(self::$issues), count($respData['issues']));
    }

    public function testPageSprint()
    {
        $url = ROOT_URL . self::$currentProject['org_path'] . "/" . self::$currentProject['key'] . '/sprints';
        $curl = BaseAppTestCase::$userCurl;
        $curl->get($url);
        $resp = BaseAppTestCase::$userCurl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testGetSprints()
    {
        $url = ROOT_URL . 'agile/fetchSprints/' . self::$currentProject['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get($url);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/fetchSprints failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        $this->assertEquals(count(self::$sprints), count($respData['sprints']));
    }

    public function testSprintAddUpdateDelete()
    {
        $url = ROOT_URL . 'agile/';

        // 新增
        $name = 'test-name-' . mt_rand(10000, 99999);
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', time() + 3600 * 24 * 7);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['project_id'] = self::$currentProject['id'];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $reqInfo['params']['start_date'] = $start_date;
        $reqInfo['params']['end_date'] = $end_date;
        $curl = BaseAppTestCase::$userCurl;
        $curl->post($url . 'addSprint/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/addSprint failed');
        $this->assertEquals('200', $respArr['ret']);
        $sprintModel = new SprintModel();
        self::$sprints[] = $sprint = $sprintModel->getByName($name);
        $this->assertEquals(self::$currentProject['id'], $sprint['project_id']);
        $this->assertEquals($name, $sprint['name']);
        $this->assertEquals($description, $sprint['description']);
        $this->assertEquals($start_date, $sprint['start_date']);
        $this->assertEquals($end_date, $sprint['end_date']);

        // 更新
        $name = $name . '-updated';
        $start_date = date('Y-m-d', time() + 3600 * 24 * 2);
        $end_date = date('Y-m-d', time() + 3600 * 24 * 10);
        $description = $description . '-updated';
        $reqInfo = [];
        $reqInfo['sprint_id'] = $sprint['id'];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $reqInfo['params']['start_date'] = $start_date;
        $reqInfo['params']['end_date'] = $end_date;
        $curl->post($url . 'updateSprint/' . $sprint['id'], $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/updateSprint failed');
        $this->assertEquals('200', $respArr['ret']);
        $sprintModel = new SprintModel();
        self::$sprints[] = $sprint = $sprintModel->getByName($name);
        $this->assertEquals(self::$currentProject['id'], $sprint['project_id']);
        $this->assertEquals($name, $sprint['name']);
        $this->assertEquals($description, $sprint['description']);
        $this->assertEquals($start_date, $sprint['start_date']);
        $this->assertEquals($end_date, $sprint['end_date']);

        // 删除
        $reqInfo = [];
        $reqInfo['sprint_id'] = $sprint['id'];
        $curl->post($url . 'deleteSprint/' . $sprint['id'], $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/deleteSprint failed');
        $this->assertEquals('200', $respArr['ret']);
        unset(self::$sprints[count(self::$sprints)-1]);
    }

    /**
     * 设置为活动的迭代
     */
    public function testSetSprintActive()
    {
        $projectId = self::$currentProject['id'];
        // 创建sprint
        $info = [];
        $info['project_id'] = $projectId;
        self::$sprints[] = $sprint = BaseDataProvider::createSprint($info);

        // 设置为活动的sprint
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'agile/fetchSprints/' . $projectId);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/fetchSprints failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);

        $reqInfo['sprint_id'] = $sprint['id'];
        $curl->post(ROOT_URL . 'agile/setSprintActive', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/setSprintActive failed');
        $this->assertEquals('200', $respArr['ret']);

        $model = new SprintModel();
        $activeSprint = $model->getActive($projectId);
        $this->assertNotEmpty($activeSprint);
        $this->assertEquals($sprint['id'], $activeSprint['id']);

        $curl->get(ROOT_URL . 'agile/fetchSprints/' . $projectId);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $sprints = $respArr['data']['sprints'];

        $reqInfo['sprint_id'] = self::$sprints[0]['id'];
        $curl->post(ROOT_URL . 'agile/setSprintActive', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/setSprintActive failed');
        $this->assertEquals('200', $respArr['ret']);

        $activeSprintArr = [];
        foreach ($sprints as $sprint) {
            if ($sprint['active'] == '1') {
                $activeSprintArr[] = $sprint;
            }
        }
        $this->assertCount(1, $activeSprintArr);
    }


    public function testJoin()
    {

        $projectId = self::$currentProject['id'];
        // 创建sprint
        $info = [];
        $info['project_id'] = $projectId;
        self::$sprints[] = $sprint = BaseDataProvider::createSprint($info);

        //创建backlog's issue
        $info = [];
        $info['project_id'] = $projectId;
        $info['sprint'] = AgileLogic::BACKLOG_VALUE;
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        self::$issues[] = $issue1 = BaseDataProvider::createIssue($info);

        // join sprint
        $curl = BaseAppTestCase::$userCurl;
        $reqInfo['issue_id'] = $issue1['id'];
        $reqInfo['sprint_id'] = $sprint['id'];
        $curl->post(ROOT_URL . 'agile/joinSprint', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/joinSprint failed');
        $this->assertEquals('200', $respArr['ret']);

        // fetchSprintIssues
        $curl = BaseAppTestCase::$userCurl;
        $reqInfo['id'] = $sprint['id'];
        $curl->get(ROOT_URL . 'agile/fetchSprintIssues', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/fetchSprintIssues failed');
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['sprint']);
        $this->assertNotEmpty($respArr['data']['issues']);

        // join closed
        $curl = BaseAppTestCase::$userCurl;
        $reqInfo['issue_id'] = $issue1['id'];
        $curl->post(ROOT_URL . 'agile/joinClosed', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/joinClosed failed');
        $this->assertEquals('200', $respArr['ret']);

        // fetchClosedIssuesByProject
        $curl = BaseAppTestCase::$userCurl;
        $reqInfo['id'] = $projectId;
        $curl->get(ROOT_URL . 'agile/fetchClosedIssuesByProject/' . $projectId, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/fetchClosedIssuesByProject failed');
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $success = false;
        foreach ($respArr['data']['issues'] as $item) {
            if ($item['id'] == $issue1['id']) {
                $success = true;
            }
        }
        $this->assertTrue($success);

        // join backlog
        $curl = BaseAppTestCase::$userCurl;
        $reqInfo['issue_id'] = $issue1['id'];
        $curl->post(ROOT_URL . 'agile/joinBacklog', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'agile/joinBacklog failed');
        $this->assertEquals('200', $respArr['ret']);
    }

    public function testBoard()
    {
        $url = ROOT_URL . self::$currentProject['org_path'] . "/" . self::$currentProject['key'] . '/kanban';
        $curl = BaseAppTestCase::$userCurl;
        $curl->get($url);
        $resp = BaseAppTestCase::$userCurl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }
}
