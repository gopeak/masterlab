<?php

namespace main\app\test\featrue\ctrl\project;

use main\app\model\project\ProjectListCountModel;
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

    public static $project = [];

    public static $projectUrl = '';

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$org = BaseDataProvider::createOrg();
        $info = [];
        $info['org_id'] = self::$org['id'];
        $info['org_path'] = self::$org['path'];
        self::$project = BaseDataProvider::createProject($info);
        self::$projectUrl = ROOT_URL . self::$org['path'] . '/' . self::$project['key'];
    }

    /**
     * 测试结束后执行此方法,清除测试数据
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        BaseDataProvider::deleteOrg(self::$org['id']);
        BaseDataProvider::deleteProject(self::$org['id']);
    }

    public function testPageIndex()
    {
        $this->markTestIncomplete();
    }

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

    public function testPageHome()
    {
        $this->markTestIncomplete();
    }

    public function testPageIssueType()
    {
        $this->markTestIncomplete();
    }

    public function testPageVersion()
    {
        $this->markTestIncomplete();
    }

    public function testPageModule()
    {
        $this->markTestIncomplete();
    }

    public function testPageIssues()
    {
        $this->markTestIncomplete();
    }

    public function testPageBacklog()
    {
        $this->markTestIncomplete();
    }

    public function testPageSprints()
    {
        $this->markTestIncomplete();
    }

    public function testPageKanban()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettings()
    {
        $this->markTestIncomplete();
    }

    public function testPageChart()
    {
        $this->markTestIncomplete();
    }

    public function testPageChartSprint()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettingsProfile()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(self::$projectUrl);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/' . self::$project['key'] . '/', $resp);
    }

    public function testPageSettingsIssueType()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettingsVersion()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettingsModule()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettingsLabel()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettingsLabelNew()
    {
        $this->markTestIncomplete();
    }

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

    public function testPageSettingsPermission()
    {
        $this->markTestIncomplete();
    }

    public function testPageSettingsProjectRole()
    {
        $this->markTestIncomplete();
    }

    public function testPageActivity()
    {
        $this->markTestIncomplete();
    }

    public function testPageStat()
    {
        $this->markTestIncomplete();
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
            'lead' => 10000,
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

    public function deleteProject($projectId, $projectTypeId)
    {
        $model = new ProjectModel();
        $model->deleteById($projectId);
        $projectListCountModel = new ProjectListCountModel();
        $projectListCountModel->decrByTypeid($projectTypeId);
    }

    /**
     * 更新
     * @param $project_id
     * @param $name
     * @param $key
     * @param $type
     * @param string $url
     * @param string $category
     * @param string $avatar
     * @param string $description
     * @throws \Exception
     */
    public function testUpdate()
    {
        $this->markTestIncomplete('NEED TODO: '. __METHOD__);
    }

    public function testDelete()
    {
        $this->markTestIncomplete('NEED TODO: '. __METHOD__);
    }
}
