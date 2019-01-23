<?php

namespace main\app\test\featrue;

use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\model\issue\IssueModel;
use main\app\model\ActivityModel;
use main\app\test\BaseDataProvider;
use main\app\test\BaseAppTestCase;

/**
 *
 * @link
 */
class TestDashboard extends BaseAppTestCase
{
    public static $clean = [];

    public static $users = [];

    public static $activityArr = [];

    public static $project = [];

    public static $issueArr = [];

    public static $model = null;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        // 1.新增项目 新增事项

        self::$project = BaseDataProvider::createProject();

        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['assignee'] = parent::$user['uid'];
            $info['project_id'] = parent::$project['id'];
            self::$issueArr[] = BaseDataProvider::createIssue($info);
        }
        // 2.插入活动数据
        self::$model = new ActivityModel();
        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['user_id'] = parent::$user['uid'];
            $info['project_id'] = parent::$project['id'];
            $info['type'] = 'issue';
            $info['obj_id'] = self::$issueArr[$i]['id'];
            $info['date'] = date('Y-m-d', time() - mt_rand(24 * 3600 * 1, 24 * 3600 * 20));
            list($ret, $insertId) = self::$model->insertItem(parent::$user['uid'], parent::$project['id'], $info);
            if ($ret) {
                $info['id'] = $insertId;
                self::$activityArr[] = $info;
            } else {
                var_dump('ActivityModel 构建数据失败');
            }
        }
    }

    /**
     *  测试完毕后执行此方法
     */
    public static function tearDownAfterClass()
    {
        BaseDataProvider::deleteProject(self::$project ['id']);

        self::$model = new ActivityModel();
        foreach (self::$activityArr as $item) {
            self::$model->deleteById($item['id']);
        }

        $model = new IssueModel();
        foreach (self::$issueArr as $item) {
            $model->deleteById($item['id']);
        }
        parent::tearDownAfterClass();
    }

    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'dashboard/index');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchPanelAssigneeIssues()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'dashboard/fetchPanelAssigneeIssues');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        if (!$respArr) {
            //echo $curl->rawResponse;
            $this->fail('fetchPanelAssigneeIssues failed');
            return;
        }

        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['issues']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertNotEmpty(intval($respArr['data']['total']));
    }

    public function testFetchPanelActivity()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'dashboard/fetchPanelActivity');
        parent::checkPageError($curl);

        $respArr = json_decode($curl->rawResponse, true);
        if (!$respArr) {
            $this->fail('fetchPanelActivity is empty');
            return;
        }
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['activity']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertNotEmpty(intval($respArr['data']['total']));
    }
}
