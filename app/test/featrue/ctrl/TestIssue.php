<?php

namespace main\app\test\unit\classes;

use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\model\project\ProjectLabelModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;
use \Curl\Curl;

/**
 * 事项控制器测试类
 * Class TestIssueFilterLogic
 * @package main\app\test\logic
 */
class TestIssue extends BaseAppTestCase
{

    public static $org = [];

    public static $project = [];

    public static $issueArr = [];

    public static $sprint = [];

    public static $module = [];

    public static $version = [];

    public static $labelArr = [];

    public static $attachmentArr = [];

    public static $attachmentJsontArr = [];

    public static $projectUrl = '';

    public static $issue = [];

    public static $issueMaster = [];

    public static $issueChildrenArr = [];


    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$org = BaseDataProvider::createOrg();
        $info = [];
        $info['org_id'] = self::$org['id'];
        $info['org_path'] = self::$org['path'];
        self::$project = BaseDataProvider::createProject($info);
        self::$projectUrl = ROOT_URL . self::$org['path'] . '/' . self::$project['key'];

        $projectId = self::$project['id'];
        $userId = parent::$user['uid'];

        $info = [];
        $info['project_id'] = self::$project['id'];
        $info['active'] = '1';
        self::$sprint = BaseDataProvider::createSprint($info);

        $info = [];
        $info['project_id'] = self::$project['id'];
        self::$version = BaseDataProvider::createProjectVersion(['project_id' => self::$project['id']]);

        $info = [];
        $info['project_id'] = self::$project['id'];
        self::$module = BaseDataProvider::createProjectModule($info);

        self::$labelArr[] = BaseDataProvider::createProjectModule();

        for ($i = 0; $i < 2; $i++) {
            list($uploadJson, self::$attachmentArr[]) = BaseDataProvider::createFineUploaderJson();
            $uploadJsonArr = json_decode($uploadJson, true);
            if (!empty($uploadJsonArr) && is_array($uploadJsonArr)) {
                self::$attachmentJsontArr[] = $uploadJsonArr[0];
            }
        }
        // print_r(self::$attachmenJsontArr);

        for ($i = 0; $i < 20; $i++) {
            $info = [];
            $info['summary'] = '测试事项 ' . $i;
            $info['project_id'] = $projectId;
            $info['issue_type'] = IssueTypeModel::getInstance()->getIdByKey('bug');
            $info['priority'] = IssuePriorityModel::getInstance()->getIdByKey('high');
            $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
            $info['resolve'] = IssueResolveModel::getInstance()->getIdByKey('done');
            $info['module'] = self::$module['id'];
            $info['sprint'] = self::$sprint['id'];
            $info['creator'] = $userId;
            $info['modifier'] = $userId;
            $info['reporter'] = $userId;
            $info['assignee'] = $userId;
            $info['updated'] = time();
            $info['start_date'] = date('Y-m-d');
            $info['due_date'] = date('Y-m-d', time() + 3600 * 24 * 7);
            $info['resolve_date'] = date('Y-m-d', time() + 3600 * 24 * 7);
            self::$issueArr[] = BaseDataProvider::createIssue($info);
        }
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        BaseDataProvider::deleteOrg(self::$org['id']);
        BaseDataProvider::deleteProject(self::$org['id']);
        BaseDataProvider::deleteSprint(self::$sprint['id']);
        BaseDataProvider::deleteProjectVersion(self::$version['id']);
        BaseDataProvider::deleteModule(self::$module['id']);

        $model = new ProjectLabelModel();
        foreach (self::$labelArr as $item) {
            $model->deleteById($item['id']);
        }

        foreach (self::$attachmentArr as $item) {
            $model = new IssueFileAttachmentModel();
            $model->deleteById($item['id']);
        }


        $model = new IssueModel();
        foreach (self::$issueArr as $item) {
            $model->deleteById($item['id']);
        }
        if (!empty(self::$issue)) {
            $model->deleteById(self::$issue['id']);
        }
        if (!empty(self::$issueMaster)) {
            $model->deleteById(self::$issueMaster['id']);
        }
        foreach (self::$issueChildrenArr as $item) {
            $model->deleteById($item['id']);
        }
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/issues');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        preg_match_all('/var\s+_issueConfig\s*=\s*\{(.+)\}\;/sU', $resp, $result, PREG_PATTERN_ORDER);
        $issueConfig = "{" . $result[1][0] . "}";
        $issueConfigArr = json_decode($issueConfig, true);

        $this->assertTrue(isset($issueConfigArr['priority']));
        $this->assertTrue(isset($issueConfigArr['issue_types']));
        $this->assertTrue(isset($issueConfigArr['issue_status']));
        $this->assertTrue(isset($issueConfigArr['issue_resolve']));
        $this->assertTrue(isset($issueConfigArr['issue_module']));
        $this->assertTrue(isset($issueConfigArr['issue_version']));
        $this->assertTrue(isset($issueConfigArr['issue_labels']));
        $this->assertTrue(isset($issueConfigArr['users']));
        $this->assertTrue(isset($issueConfigArr['projects']));
    }

    public function testDetailPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $issue = self::$issueArr[0];
        $curl->get(ROOT_URL . '/issue/detail/index/' . $issue['id']);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        preg_match_all('/var\s+_issueConfig\s*=\s*\{(.+)\}\;/sU', $resp, $result, PREG_PATTERN_ORDER);
        $issueConfig = "{" . $result[1][0] . "}";
        $issueConfigArr = json_decode($issueConfig, true);

        $this->assertTrue(isset($issueConfigArr['priority']));
        $this->assertTrue(isset($issueConfigArr['issue_types']));
        $this->assertTrue(isset($issueConfigArr['issue_status']));
        $this->assertTrue(isset($issueConfigArr['issue_resolve']));
        $this->assertTrue(isset($issueConfigArr['issue_module']));
        $this->assertTrue(isset($issueConfigArr['issue_version']));
        $this->assertTrue(isset($issueConfigArr['issue_labels']));
        $this->assertTrue(isset($issueConfigArr['users']));
        $this->assertTrue(isset($issueConfigArr['projects']));
    }

    public function testFilter()
    {
        $projectId = self::$project['id'];
        $user = parent::$user;

        // 无参数查询
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'issue/main/filter?project=' . $projectId);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail(__FUNCTION__ . ' failed');
            return;
        }

        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 用户名查询
        $param = [];
        $param['project'] = $projectId;
        $param['assignee_username'] = $user['username'];
        $param['assignee'] = $user['uid'];
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 用户id查询
        $param = [];
        $param['project'] = $projectId;
        $param['author'] = $user['uid'];
        $param['reporter_uid'] = $user['uid'];
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);

        // 事项标题查询
        $param = [];
        $param['project'] = $projectId;
        $param['search'] = self::$issueArr[0]['summary'];
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertEquals(1, intval($respArr['data']['total']));

        // 按模块查询
        $param = [];
        $param['project'] = $projectId;
        $param['module'] = self::$module['name'];
        $param['module_id'] = self::$module['id'];
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 按优先级查询
        $param = [];
        $param['project'] = $projectId;
        $param['priority'] = 'high';
        $param['priority_id'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 按解决结果查询
        $param = [];
        $param['project'] = $projectId;
        $param['resolve'] = 'done';
        $param['resolve_id'] = IssueResolveModel::getInstance()->getIdByKey('done');
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 按状态查询
        $param = [];
        $param['project'] = $projectId;
        $param['status'] = 'open';
        $param['status_id'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 按创建时间的范围
        $param = [];
        $param['project'] = $projectId;
        $param['created_start'] = time() - 100;
        $param['created_end'] = time() + 10;
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 按更新时间的范围
        $param = [];
        $param['project'] = $projectId;
        $param['updated_start'] = time() - 100;
        $param['updated_end'] = time();
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 排序
        $param = [];
        $param['project'] = $projectId;
        $param['sort_field'] = 'id';
        $param['sort_by'] = 'DESC';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertTrue($respArr['data']['issues'][0]['id'] > $respArr['data']['issues'][1]['id']);

        // 过滤器 分配给我的
        $param = [];
        $param['project'] = $projectId;
        $param['sys_filter'] = 'assignee_mine';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 过滤器 我报告的
        $param = [];
        $param['project'] = $projectId;
        $param['sys_filter'] = 'my_report';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 过滤器 最近解决的
        $param = [];
        $param['project'] = $projectId;
        $param['sys_filter'] = 'recently_resolve';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 过滤器 最近更新的
        $param = [];
        $param['project'] = $projectId;
        $param['sys_filter'] = 'update_recently';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 过滤器 打开的
        $param = [];
        $param['project'] = $projectId;
        $param['sys_filter'] = 'open';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

        // 所有条件都满足的查询
        $param = [];
        $param['project'] = $projectId;
        $param['assignee_username'] = $user['username'];
        $param['assignee'] = $user['uid'];
        $param['author'] = $user['uid'];
        $param['reporter_uid'] = $user['uid'];
        $param['search'] = substr(self::$issueArr[0]['summary'], 0, -2);
        $param['module'] = self::$module['name'];
        $param['module_id'] = self::$module['id'];
        $param['priority'] = 'high';
        $param['priority_id'] = IssuePriorityModel::getInstance()->getIdByKey('high');
        $param['resolve'] = 'done';
        $param['status'] = 'open';
        $param['status_id'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $param['created_start'] = time() - 100;
        $param['created_end'] = time() + 100;
        $param['updated_start'] = time() - 100;
        $param['updated_end'] = time() + 100;
        $param['sort_field'] = 'id';
        $param['sort_by'] = 'DESC';
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));
    }

    /**
     * 测试自定义过滤器
     */
    public function testSaveFilter()
    {

        $projectId = self::$project['id'];
        $user = parent::$user;
        $curl = BaseAppTestCase::$userCurl;

        // 保存一个过滤器
        $filterArr = [];
        $filterArr['project'] = $projectId;
        $filterArr['assignee'] = $user['uid'];
        $filterArr['author_username'] = $user['username'];
        $filterArr['status'] = 'open';
        $filterArr['priority'] = 'high';
        $filterArr['resolve_resolve'] = 'done';

        $param = [];
        $param['name'] = $filterName = 'testSaveFilterName_' . mt_rand(10000, 999999);
        $param['filter'] = http_build_query($filterArr);
        $param['description'] = 'test';
        $curl->get(ROOT_URL . 'issue/main/saveFilter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if ($respArr['ret'] != '200') {
            $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg']);
        }

        // 查询过滤器
        $curl->get(ROOT_URL . 'issue/main/getFavFilter');
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if ($respArr['ret'] != '200') {
            $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg']);
        }
        $this->assertNotEmpty($respArr['data']['filters']);
        list($firstFilters, $hideFilters) = $respArr['data']['filters'];
        $savedFilter = [];
        foreach ($firstFilters as $item) {
            if ($item['name'] == $filterName) {
                $savedFilter = $item;
                break;
            }
        }
        foreach ($hideFilters as $item) {
            if ($item['name'] == $filterName) {
                $savedFilter = $item;
                break;
            }
        }
        $this->assertNotEmpty($savedFilter);

        // 使用过滤器查询
        $param = [];
        $param['fav_filter'] = $savedFilter['id'];
        $curl->get(ROOT_URL . 'issue/main/filter', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(count(self::$issueArr), intval($respArr['data']['total']));

    }

    public function testFetchIssueTypeAndUi()
    {
        $projectId = self::$project['id'];
        $curl = BaseAppTestCase::$userCurl;

        // 获取事项类型

        $param = [];
        $param['project_id'] = $projectId;
        $curl->get(ROOT_URL . 'issue/main/fetchIssueType');
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if ($respArr['ret'] != '200') {
            $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg']);
        }
        $this->assertNotEmpty($respArr['data']['issue_types']);
        $issueTypesArr = $respArr['data']['issue_types'];
        $issueTypeId = current($issueTypesArr)['id'];
        $uiTypeArr = ['create', 'edit'];
        foreach ($uiTypeArr as $uiType) {
            $param = [];
            $param['project_id'] = $projectId;
            $param['issue_type_id'] = $issueTypeId;
            $param['type'] = $uiType;
            $curl->get(ROOT_URL . 'issue/main/fetchUiConfig', $param);
            parent::checkPageError($curl);
            $respArr = json_decode(self::$userCurl->rawResponse, true);
            if ($respArr['ret'] != '200') {
                $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg']);
            }
            $this->assertNotEmpty($respArr['data']['configs']);
            $this->assertNotEmpty($respArr['data']['fields']);
            $this->assertNotEmpty($respArr['data']['field_types']);
            $this->assertNotEmpty($respArr['data']['allow_add_status']);
        }
    }

    public function testAddFetchUpdate()
    {
        // 获得标签id
        $labelsArr = [];
        foreach (self::$labelArr as $label) {
            $labelsArr[] = $label['id'];
        }

        $projectId = self::$project['id'];
        $userId = parent::$user['uid'];
        $info = [];
        $info['summary'] = '测试事项';
        $info['project_id'] = $projectId;
        $info['issue_type'] = IssueTypeModel::getInstance()->getIdByKey('bug');
        $info['priority'] = IssuePriorityModel::getInstance()->getIdByKey('hight');
        $info['status'] = IssueStatusModel::getInstance()->getIdByKey('open');
        $info['resolve'] = IssueResolveModel::getInstance()->getIdByKey('done');
        $info['module'] = self::$module['id'];
        $info['sprint'] = self::$sprint['id'];
        $info['creator'] = $userId;
        $info['reporter'] = $userId;
        $info['assignee'] = $userId;
        $info['start_date'] = date('Y-m-d');
        $info['due_date'] = date('Y-m-d', time() + 3600 * 24 * 7);
        $info['resolve_date'] = date('Y-m-d', time() + 3600 * 24 * 7);
        $info['labels'] = $labelsArr;
        $info['attachment'] = json_encode(self::$attachmentJsontArr);
        $param = [];
        $param['params'] = $info;
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'issue/main/add', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if ($respArr['ret'] != '200') {
            $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg']);
            return;
        }
        $issueId = $respArr['data'];
        $issueModel = new IssueModel();
        self::$issue = $issueModel->getById($issueId);

        $param = [];
        $param['issue_id'] = $issueId;
        $curl->get(ROOT_URL . 'issue/main/fetchIssueEdit', $param);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if ($respArr['ret'] != '200') {
            $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg']);
        }
        $this->assertNotEmpty($respArr['data']['configs']);
        $this->assertNotEmpty($respArr['data']['fields']);
        $this->assertNotEmpty($respArr['data']['field_types']);
        $this->assertNotEmpty($respArr['data']['project_module']);
        $this->assertNotEmpty($respArr['data']['issue']);

        $fetchIssue = $respArr['data']['issue'];
        foreach ($info as $field => $value) {
            if (isset($fetchIssue[$field])) {
                $this->assertEquals($value, $fetchIssue[$field], 'Field '.$field.' not equal');
            }
        }
        // print_r($fetchIssue);

    }

    public function testPath()
    {

    }

    public function testUpload()
    {

    }

    public function testUploadDelete()
    {

    }

    public function testFollow()
    {

    }

    public function testUnFollow()
    {

    }

    public function testConvertChild()
    {

    }

    public function testGetChildIssues()
    {

    }

    public function testRemoveChild()
    {

    }

    public function testDelete()
    {

    }
}
