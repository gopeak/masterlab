<?php

namespace main\app\test\featrue;

use main\app\model\issue\IssueModel;
use main\app\model\user\UserModel;
use main\app\model\project\ProjectModel;
use main\app\test\BaseDataProvider;
use main\app\test\BaseAppTestCase;

/**
 * 搜索的功能测试
 * @link
 */
class TestSearch extends BaseAppTestCase
{
    public static $clean = [];

    public static $users = [];

    public static $activityArr = [];

    public static $projectArr = [];

    public static $issueArr = [];

    public static $model = null;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // 1.插入项目数据
        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['name'] = 'test-Search-' . mt_rand(100000, 99999999);
            self::$projectArr[] = BaseDataProvider::createProject($info);
        }

        // 2.插入事项
        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['summary'] = '测试事项 ' . $i;
            $info['assignee'] = parent::$user['uid'];
            $info['project_id'] = self::$project['id'];
            self::$issueArr[] = BaseDataProvider::createIssue($info);
        }

        // 检查版本
        $model = new IssueModel();
        $versionSql = 'select version() as vv';
        $versionStr = $model->db->getOne($versionSql);
        $mysqlVer = 0;
        if (strpos($versionStr, 'MariaDB') === false) {
            $mysqlVer = floatval(substr($versionStr, 0, 3));
        }
    }

    /**
     *  测试完毕后执行此方法
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        self::$model = new ProjectModel();
        foreach (self::$projectArr as $item) {
            self::$model->deleteById($item['id']);
        }

        $model = new IssueModel();
        foreach (self::$issueArr as $item) {
            $model->deleteById($item['id']);
        }

        $model = new UserModel();
        foreach (self::$users as $item) {
            $model->deleteById($item['uid']);
        }
        parent::tearDownAfterClass();
    }

    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'search');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/搜索结果/', $resp);
    }


    public function testSearchProject()
    {
        $curl = BaseAppTestCase::$userCurl;
        #$reqInfo['keyword'] = 'test-Search';
        #$reqInfo['data_type'] = 'json';
        #$reqInfo['scope'] = 'project';
        $curl->get(ROOT_URL . 'search?format=json&data_type=json&keyword=test-Search&scope=project');
        //echo self::$userCurl->rawResponse;
        $this->assertNotRegExp('/查询错误/', self::$userCurl->rawResponse);
        // f(APP_PATH.'/test/testSearchProject.log',self::$userCurl->rawResponse);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail('search failed');
            return;
        }
       // print_r($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['projects']);
        $this->assertNotEmpty($respArr['data']['project_pages']);
        $this->assertNotEmpty(intval($respArr['data']['project_total']));
    }

    public function testSearchIssue()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'search?data_type=json&scope=issue&keyword=' . urlencode('测试事项'));
        // echo self::$userCurl->rawResponse;
        $this->assertNotRegExp('/查询错误/', self::$userCurl->rawResponse);
        // f(APP_PATH.'/test/testSearchIssue.log',self::$userCurl->rawResponse);
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail('search failed');
            return;
        }
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['issue_pages']);
        $this->assertNotEmpty(intval($respArr['data']['issue_total']));
    }
}
