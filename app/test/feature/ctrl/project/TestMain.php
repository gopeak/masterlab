<?php

namespace main\app\test\featrue\ctrl\project;

use main\app\classes\ProjectListCountLogic;
use main\app\model\project\ProjectModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 *
 * @version
 * @link
 */
class TestMain extends BaseAppTestCase
{
    public static $org = [];

    public static $currentProject = [];

    public static $projectUrl = '';

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
        self::$currentProject = BaseDataProvider::createProject($info);
        self::$projectUrl = ROOT_URL . self::$org['path'] . '/' . self::$currentProject['key'];
    }

    /**
     *  测试结束后执行此方法,清除测试数据
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        BaseDataProvider::deleteOrg(self::$org['id']);
        BaseDataProvider::deleteProject(self::$currentProject['id']);
    }

    /**
     * @throws \Exception
     */
    public function testPageNew()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'project/main/new');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp);
        $this->assertRegExp('/name="params\[name\]"/', $resp);
        $this->assertRegExp('/name="params\[org_id\]"/', $resp);
        $this->assertRegExp('/name="params\[type\]"/', $resp);
        $this->assertRegExp('/name="params\[key\]"/', $resp);
        $this->assertRegExp('/name="params\[description\]"/', $resp);
        $this->assertRegExp('/name="params\[lead\]"/', $resp);
        $this->assertRegExp('/name="params\[avatar_relate_path\]"/', $resp);
    }

    /**
     * @throws \Exception
     */
    public function testPageHome()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/home');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageIssueType()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/issue_type');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageVersion()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/version');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageModule()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/module');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageIssues()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/issues');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageBacklog()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/backlog');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSprints()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/sprints');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageKanban()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/kanban');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettings()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageChart()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/chart');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageChartSprint()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/chart_sprint');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsProfile()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/' . self::$currentProject['key'] . '/', $resp);
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsIssueType()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_issue_type');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsVersion()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_version');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsModule()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_module');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsLabel()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_label');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsLabelNew()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_label_new');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsLabelEdit()
    {
        $labelInfo = BaseDataProvider::createProjectLabel();
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_label_edit?id=' . $labelInfo['id']);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/' . $labelInfo['title'] . '/', $resp);
        BaseDataProvider::deleteProjectLabel($labelInfo['id']);
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsPermission()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_permission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        //$this->markTestIncomplete();
    }

    /**
     * @throws \Exception
     */
    public function testPageSettingsProjectRole()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/settings_project_role');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testPageStat()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl . '/stat');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * 新增项目
     * @param array $params
     * @throws \Exception
     */
    public function testCreate()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'project/main/create', []);
        $resp = $curl->rawResponse;
        $resp = json_decode($resp, true);
        $this->assertEquals(0, $resp['ret']);

        $typeId = 10;
        $postData = array('params' => array(
            'name' => 'PROName-' . quickRandom(10),
            'org_id' => 1,
            'key' => 'PROKEY'.strtoupper(quickRandomStr(5)),
            'lead' => self::$user['uid'],
            'type' => $typeId,
            'description' => quickRandom(10),
            'detail' => quickRandom(10),
            'url' => quickRandom(10),
        ));
        $curl->post(ROOT_URL . 'project/main/create', $postData);
        $resp = $curl->rawResponse;
        $resp = json_decode($resp, true);
        $this->assertEquals(200, $resp['ret']);
        // 删除创建成功的项目
        $this->deleteProject($resp['data']['project_id'], $typeId);


        $postData = array('params' => array(
            'name' => 'PROName-' . quickRandom(10),
            'org_id' => 1,
            'description' => quickRandom(10),
            'detail' => quickRandom(10),
            'url' => quickRandom(10),
        ));
        $curl->post(ROOT_URL . 'project/main/create', $postData);
        $resp = $curl->rawResponse;
        $resp = json_decode($resp, true);
        $this->assertEquals(104, $resp['ret']);
    }

    /**
     * @param $projectId
     * @param $projectTypeId
     * @throws \Exception
     */
    public function deleteProject($projectId, $projectTypeId)
    {
        $model = new ProjectModel();
        $model->deleteById($projectId);

        $projectListCountLogic = new ProjectListCountLogic();
        $projectListCountLogic->resetProjectTypeCount($projectTypeId);
    }
}
