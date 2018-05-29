<?php

namespace main\app\test\unit\model\issue;

use main\app\model\system\MailQueueModel;

/**
 * MailQueueModel 测试类
 * User: sven
 */
class TestMailQueueModel extends TestBaseIssueModel
{

    public static $scheme = [];

    public static $insertIdArr = [];

    public static function setUpBeforeClass()
    {
    }

    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        if (!empty(self::$insertIdArr)) {
            $model = new MailQueueModel();
            foreach (self::$insertIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new MailQueueModel();
        // 1. 新增测试数据
        $info = [];
        $info['title'] = 'test-title';
        $info['address'] = 'test-address';
        $info['status'] = 'ready';
        $info['error'] = '';
        list($ret, $insertId) = $model->add($info);
        $this->assertTrue($ret);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        $row = $model->getRowById($insertId);
        foreach ($info as $key => $item) {
            $this->assertEquals($item, $row[$key]);
        }

        $object = new \stdClass();
        $object->title = 'test-title2';
        $object->address = 'test-address2';
        $object->status = 'ready';
        $object->error = '';

        list($ret, $insertId2) = $model->add($object);
        $this->assertTrue($ret);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }

        // 2.删除
        $model->deleteById($insertId);
        $model->deleteById($insertId2);
    }

    public function testGetStatus()
    {
        $reflect = new \ReflectionClass("main\app\model\system\MailQueueModel");
        $constants = $reflect->getConstants();
        $status = MailQueueModel::getStatus();

        foreach ($status as $key => $item) {
            $this->assertTrue(isset($constants[$key]));
            $this->assertEquals($item, $constants[$key]);
        }

        $this->assertTrue(isset($status['STATUS_READY']));
        $this->assertEquals($status['STATUS_READY'], 'ready');
    }
}
