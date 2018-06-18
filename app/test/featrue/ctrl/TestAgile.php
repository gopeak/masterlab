<?php

namespace main\app\test\featrue\ctrl;

use main\app\test\BaseAppTestCase;
use main\app\test\data\LogDataProvider;
use main\app\test\BaseDataProvider;
use main\app\model\issue\IssueStatusModel;
use main\app\classes\AgileLogic;

/**
 *
 * @version
 * @link
 */
class TestAgile extends BaseAppTestCase
{
    public static $clean = [];

    public static $sprints = [];

    public static $issues = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // 创建组织
        self::$org = BaseDataProvider::createOrg();

        // 创建一个项目,并指定权限方案为默认
        $info['permission_scheme_id'] = 0;
        $info['origin_id'] = self::$org['id'];
        self::$project = BaseDataProvider::createProject($info);
        $projectId = self::$project['id'];

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
     * 测试页面
     */
    public function testBacklog()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/backlog');
        $resp = BaseAppTestCase::$userCurl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * ajax的日志数据
     */
    public function testGetBacklogIssues()
    {
        //http://www.bom.local/log/_list?page=1&format=json&remark=&user_name=&action=
    }


    /**
     * teardown执行后执行此方法
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }
}
