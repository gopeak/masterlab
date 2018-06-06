<?php

namespace main\app\test\logic;

use PHPUnit\Framework\TestCase;

use main\app\model\system\MailQueueModel;
use main\app\classes\MailQueueLogic;
use main\app\test\data\LogDataProvider;

/**
 *  MailQueueLogic测试类
 * Class testMailQueueLogic
 * @package main\app\test\logic
 */
class TestMailQueueLogic extends TestCase
{
    public static $pageSize = 10;

    public static $queues = [];


    public static function setUpBeforeClass()
    {
        $model = MailQueueModel::getInstance();
        $info = [];
        $info[''] = '';
        $model->insert();
    }

    public static function tearDownAfterClass()
    {

    }

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
    }

    public function testGetPageInfo()
    {
        $logic = new MailQueueLogic(static::$pageSize);
        $conditions['uid'] = LogDataProvider::UID;
        $page = 1;
        $page_html = $logic->getPageInfo($conditions, $page);

        $this->assertNotEmpty($page_html);
        $this->assertRegExp('/page=\'' . $page . '\'\s+class="current"/', $page_html);
    }

    public function testQuery()
    {
        $logic = new MailQueueLogic(static::$pageSize);

        // 正常
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $page1_logs = $logic->query($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($page1_logs);
        // 排序
        $this->assertGreaterThan($page1_logs[1]['id'], $page1_logs[0]['id']);

        // 分页2
        $page = 2;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $page2_logs = $logic->query($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($page2_logs);
        $this->assertGreaterThan($page2_logs[0]['id'], $page1_logs[0]['id']);

        // 详情查询
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $remark = '日志插入测试';
        $remark_logs = $logic->query($conditions, $page, $remark, 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 用户名查询
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $conditions['user_name'] = LogDataProvider::USER_NAME;
        $remark_logs = $logic->query($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 联合查询
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $conditions['user_name'] = LogDataProvider::USER_NAME;
        $conditions['action'] = LogBaseModel::ACT_ADD;
        $remark_logs = $logic->query($conditions, $page, $remark, 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 查询不存在的数据
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $conditions['user_name'] = LogDataProvider::USER_NAME . time();
        $conditions['action'] = LogBaseModel::ACT_DELETE;
        $remark = md5(time());
        $remark_logs = $logic->query($conditions, $page, $remark, 'id', 'desc');
        $this->assertEmpty($remark_logs);
    }
}
