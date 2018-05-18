<?php

namespace main\app\test\logic;

use PHPUnit\Framework\TestCase;

use main\app\model\LogBaseModel;
use main\app\classes\LogLogic;
use main\app\test\data\LogDataProvider;

/**
 * 日志业务逻辑
 * Class testLogLogic
 * @package main\app\test\logic
 */
class TestLogLogic extends TestCase
{
    static $page_size = 10;

    static $logs = [];


    public static function setUpBeforeClass()
    {
        static::$logs = LogDataProvider::initLogs(self::$page_size);
    }

    public static function tearDownAfterClass()
    {
        LogDataProvider::clearLogs();
    }

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
    }

    public function testGetPageHtml()
    {
        $logLogic = new LogLogic(static::$page_size);
        $conditions['uid'] = LogDataProvider::UID;
        $page = 1;
        $page_html = $logLogic->getPageHtml($conditions, $page);

        $this->assertNotEmpty($page_html);
        $this->assertRegExp('/page=\'' . $page . '\'\s+class="current"/', $page_html);
    }

    public function testQuery()
    {
        $logLogic = new LogLogic(static::$page_size);

        // 正常
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $page1_logs = $logLogic->query($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($page1_logs);
        // 排序
        $this->assertGreaterThan($page1_logs[1]['id'], $page1_logs[0]['id']);

        // 分页2
        $page = 2;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $page2_logs = $logLogic->query($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($page2_logs);
        $this->assertGreaterThan($page2_logs[0]['id'], $page1_logs[0]['id']);

        // 详情查询
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $remark = '日志插入测试';
        $remark_logs = $logLogic->query($conditions, $page, $remark, 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 用户名查询
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $conditions['user_name'] = LogDataProvider::USER_NAME;
        $remark_logs = $logLogic->query($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 联合查询
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $conditions['user_name'] = LogDataProvider::USER_NAME;
        $conditions['action'] = LogBaseModel::ACT_ADD;
        $remark_logs = $logLogic->query($conditions, $page, $remark, 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 查询不存在的数据
        $page = 1;
        $conditions = [];
        $conditions['company_id'] = LogDataProvider::COMPANY_ID;
        $conditions['user_name'] = LogDataProvider::USER_NAME . time();
        $conditions['action'] = LogBaseModel::ACT_DELETE;
        $remark = md5(time());
        $remark_logs = $logLogic->query($conditions, $page, $remark, 'id', 'desc');
        $this->assertEmpty($remark_logs);
    }
}
