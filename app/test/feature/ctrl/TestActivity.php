<?php

namespace main\app\test\featrue;

use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\ActivityModel;
use main\app\test\BaseDataProvider;
use main\app\test\BaseAppTestCase;
use main\app\model\user\UserTokenModel;
use \Curl\Curl;

/**
 *
 * @link
 */
class TestActivity extends BaseAppTestCase
{
    public static $clean = [];

    public static $users = [];

    public static $activityArr = [];

    public static $project = [];

    public static $issue = [];

    public static $model = null;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        // 1.新增项目 新增事项

        self::$project = BaseDataProvider::createProject();
        self::$issue = BaseDataProvider::createIssue();

        // 2.插入活动数据
        self::$model = new ActivityModel();
        for ($i = 0; $i < 10; $i++) {
            $info = [];
            $info['user_id'] = parent::$user['uid'];
            $info['project_id'] = self::$project['id'];
            $info['type'] = 'issue';
            $info['obj_id'] = self::$issue['id'];
            $info['date'] = date('Y-m-d', time() - mt_rand(24 * 3600 * 1, 24 * 3600 * 20));
            list($ret, $insertId) = self::$model->insertItem(parent::$user['uid'], self::$project['id'], $info);
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
        BaseDataProvider::deleteIssue(self::$issue['id']);

        self::$model = new ActivityModel();
        foreach (self::$activityArr as $item) {
            self::$model->deleteById($item['id']);
        }
        parent::tearDownAfterClass();
    }

    public function testFetchCalendarHeatmap()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/activity/fetchCalendarHeatmap');
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail('fetchCalendarHeatmap failed');
            return;
        }

        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['heatmap']);
    }

    public function testFetchByUser()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/activity/fetchByUser');
        parent::checkPageError($curl);
        $respArr = json_decode(self::$userCurl->rawResponse, true);
        if (!$respArr) {
            $this->fail('fetchByUser failed');
            return;
        }

        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']['activity_list']);
        $this->assertNotEmpty($respArr['data']['pages']);
        $this->assertEquals(10, intval($respArr['data']['total']));
    }
}
