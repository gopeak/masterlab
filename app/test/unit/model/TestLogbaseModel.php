<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\LogBaseModel;

/**
 * testLogBaseModel 测试类
 * User: sven
 * Date: 2017/7/15 0015
 * Time: 下午 5:24
 */
class TestLogBaseModel extends TestCase
{

    const UID = 9999999;

    const OBJ_ID = 888888;

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 清除日志
     */
    public static function clearLogs()
    {
        // 清空数据
        $logBaseModel = new LogBaseModel();
        $conditions['uid'] = static::UID;
        $logBaseModel->delete($conditions);
    }

    /**
     * 测试动作列表
     */
    public function testGetActions()
    {
        $actions = LogBaseModel::getActions();
        if (empty($actions)) {
            $this->fail('LogBaseModel::getActions failed , actions is empty');
        }
        foreach ($actions as $k => $c) {
            if (strpos($k, 'ACT_') !== 0) {
                $this->fail('expect LogBaseModel action const start "ACT_", but get: ' . $c);
            }
        }
    }

    /**
     * 测试单例对象
     */
    public function testGetInstance()
    {
        $logModel1 = LogBaseModel::getInstance();
        $logModel2 = LogBaseModel::getInstance();
        $logModel3 = LogBaseModel::getInstance(false);

        if ($logModel1 = $logModel2 && $logModel2 = $logModel3) {
        } else {
            $this->fail('expect LogBaseModel::getInstance()\' $logModel1 $logModel2 $logModel3  equal,but not ');
        }

        $logModelPersistent = LogBaseModel::getInstance(true);
        if ($logModelPersistent === $logModel1) {
            $this->fail('expect LogBaseModel::getInstance(false)  not equal LogBaseModel::getInstance(true),but not ');
        }
    }


    /**
     * 测试实际连接数据库
     */
    public function testLog()
    {
        $pre_data = [];
        $pre_data['f1'] = 'Adidas';
        $pre_data['f2'] = time() - 10;
        $pre_data['f3'] = 'google';

        $cur_data = [];
        $cur_data['f1'] = 'Nike';
        $cur_data['f2'] = time();
        $cur_data['f3'] = 'google';

        $obj_id = static::OBJ_ID;
        $uid = static::UID;

        $log = new \stdClass();
        $log->uid = $uid;
        $log->user_name = 'unit_username';
        $log->real_name = 'unit_realname';
        $log->obj_id = $obj_id;
        $log->module = '日志';
        $log->page = '操作日志';
        $log->action = '编辑';
        $log->remark = '日志插入测试';
        $log->pre_data = $pre_data;
        $log->cur_data = $cur_data;
        $log->company_id = 121;
        $logModel = LogBaseModel::getInstance();
        list($ret, $msg) = $logModel->insert($log);

        if (!$ret) {
            $this->fail(' LogBaseModel add failed:' . $msg);
            return;
        }

        $db_log = $logModel->getById($msg);
        foreach ($log as $k => $l) {
            $this->assertEquals($l, $db_log[$k]);
        }

        $logs = $logModel->getsByObj(static::OBJ_ID);
        $this->assertNotEmpty($logs);
        $this->assertEquals(1, count($logs));

        $logModel->deleteById($msg);
    }
}
