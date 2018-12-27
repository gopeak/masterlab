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
    public static $pageSize = 10;

    public static $logs = [];


    public static function setUpBeforeClass()
    {
        static::$logs = LogDataProvider::initLogs(self::$pageSize);
    }

    public static function tearDownAfterClass()
    {
        LogDataProvider::clearLogs();
    }

    /**
     * 测试构造函数
     * @throws \Exception
     */
    public function testConstruct()
    {
        $this->assertTrue(true, true);
    }


    /*public function testFilter()
    {
        $logLogic = new LogLogic();

        // 正常
        $page = 1;
        $conditions = [];
        $page1_logs = $logLogic->filter($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($page1_logs);
        // 排序
        $this->assertGreaterThan($page1_logs[1]['id'], $page1_logs[0]['id']);

        // 分页2
        $page = 2;
        $conditions = [];
        $page2_logs = $logLogic->filter($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($page2_logs);
        $this->assertGreaterThan($page2_logs[0]['id'], $page1_logs[0]['id']);

        // 详情查询
        $page = 1;
        $conditions = [];
        $remark = '日志插入测试';
        $remark_logs = $logLogic->filter($conditions, $page, $remark, 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 用户名查询
        $page = 1;
        $conditions = [];
        $conditions['user_name'] = LogDataProvider::USER_NAME;
        $remark_logs = $logLogic->filter($conditions, $page, '', 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 联合查询
        $page = 1;
        $conditions = [];
        $conditions['user_name'] = LogDataProvider::USER_NAME;
        $conditions['action'] = LogBaseModel::ACT_ADD;
        $remark_logs = $logLogic->filter($conditions, $page, $remark, 'id', 'desc');
        $this->assertNotEmpty($remark_logs);

        // 查询不存在的数据
        $page = 1;
        $conditions = [];
        $conditions['user_name'] = LogDataProvider::USER_NAME . time();
        $conditions['action'] = LogBaseModel::ACT_DELETE;
        $remark = md5(time());
        $remark_logs = $logLogic->filter($conditions, $page, $remark, 'id', 'desc');
        $this->assertEmpty($remark_logs);
    }*/

    /**
     * @throws \Exception
     */
    public function testAdd()
    {

        $pre_data = [];
        $pre_data['f1'] = 'Adidas';
        $pre_data['f2'] = time() - 10;
        $pre_data['f3'] = 'google';

        $cur_data = [];
        $cur_data['f1'] = 'Nike';
        $cur_data['f2'] = time();
        $cur_data['f3'] = 'google';

        $obj_id = 0;
        $uid = 10000;

        $result = LogLogic::add(
            '日志测试111',
            $pre_data,
            $cur_data,
            $obj_id,
            '日志',
            '新增',
            'issuse',
            $uid
        );

        $this->assertNotEmpty($result);
    }
}
