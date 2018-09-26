<?php

namespace main\app\test\logic;

use PHPUnit\Framework\TestCase;

use main\app\model\system\MailQueueModel;
use main\app\classes\MailQueueLogic;

/**
 *  MailQueueLogic测试类
 * Class testMailQueueLogic
 * @package main\app\test\logic
 */
class TestMailQueueLogic extends TestCase
{
    public static $pageSize = 2;

    public static $insertNum = 4;

    public static $queues = [];

    public static $queueIdArr = [];

    /**
     * 构建环境和数据
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        $model = MailQueueModel::getInstance();
        $model->delete(['title' => 'test-title']);
        for ($i = 0; $i < self::$insertNum; $i++) {
            $info = [];
            $info['title'] = 'test-title';
            $info['address'] = 'test-address';
            $info['status'] = MailQueueModel::STATUS_READY;
            list($ret, $insertId) = $model->insert($info);
            if ($ret) {
                self::$queueIdArr[] = $insertId;
                $row = $model->getRowById($insertId);
                self::$queues[] = $row;
            }else{
                var_dump($insertId);
            }
        }
    }

    /**
     * 清除数据
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$queues)) {
            $model = new MailQueueModel();
            foreach (self::$queues as $row) {
                $model->deleteById($row['id']);
            }
        }
        if (!empty(self::$queueIdArr)) {
            $model = new MailQueueModel();
            foreach (self::$queueIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public function testGetPageInfo()
    {
        $logic = new MailQueueLogic(self::$pageSize);
        $conditions['status'] = MailQueueModel::STATUS_READY;
        $conditions['title'] = 'test-title';
        $page = 1;
        $pageInfo = $logic->getPageInfo($conditions, $page);
        list($total, $pages, $currentPage, $pageHtml, $pageSize) = $pageInfo;
        $this->assertEquals(intval(ceil($total / self::$pageSize)), $pages);
        $this->assertEquals(self::$insertNum, $total);
        $this->assertEquals($page, $currentPage);
        $this->assertEquals(self::$pageSize, $pageSize);
        $this->assertRegExp('/page=\'' . $page . '\'\s+class="current"/', $pageHtml);
    }

    public function testQuery()
    {
        $logic = new MailQueueLogic(self::$pageSize);
        // 正常
        $page = 1;
        $conditions = [];
        $conditions['status'] = MailQueueModel::STATUS_READY;
        $rows = $logic->query($conditions, $page, 'id', 'desc');
        $this->assertNotEmpty($rows);
        // 排序
        $this->assertGreaterThan($rows[1]['id'], $rows[0]['id']);

        // 分页2
        $page = 2;
        $conditions = [];
        $conditions['status'] = MailQueueModel::STATUS_READY;
        $rows = $logic->query($conditions, $page, 'id', 'desc');
        $this->assertNotEmpty($rows);

        //  多条件
        $page = 1;
        $conditions = [];
        $conditions['status'] = MailQueueModel::STATUS_READY;
        $conditions['title'] = 'test-title';
        $rows = $logic->query($conditions, $page, 'id', 'desc');
        $this->assertNotEmpty($rows);

        // 查询不存在的数据
        $page = 1;
        $conditions = [];
        $conditions['status'] = MailQueueModel::STATUS_READY;
        $conditions['title'] = time() . mt_rand(10000, 99999);
        $rows = $logic->query($conditions, $page, 'id', 'desc');
        $this->assertEmpty($rows);
    }

    /**
     * 测试添加和更新
     * @throws \Exception
     */
    public function testAddUpdate()
    {
        $logic = new MailQueueLogic(self::$pageSize);
        $address = 'test-address';
        $title = 'test-title';
        $status = MailQueueModel::STATUS_READY;
        list($ret, $insertId) = $logic->add($address, $title, $status, '');
        $this->assertTrue($ret, $insertId);

        if ($ret) {
            $error = 'error';
            $statusUpdated = MailQueueModel::STATUS_DONE;
            list($ret, $msg) = $logic->updateQueue($insertId, $statusUpdated, $error);
            $this->assertTrue($ret, $msg);
            $model = new MailQueueModel();
            $row = $model->getRowById($insertId);
            $this->assertEquals($statusUpdated, $row['status']);
            $this->assertEquals($error, $row['error']);

            self::$queueIdArr[] = $insertId;
            $model->deleteById($insertId);
        }
    }
}
