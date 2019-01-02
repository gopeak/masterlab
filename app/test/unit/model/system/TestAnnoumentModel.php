<?php

namespace main\app\test\unit\model\issue;

use main\app\model\system\AnnouncementModel;

/**
 * AnnouncementModel 测试类
 * User: sven
 */
class TestAnnouncementModel extends TestBaseIssueModel
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
            $model = new AnnouncementModel();
            foreach (self::$insertIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $model = new AnnouncementModel();
        // 1. release
        $content = 'test-content-' . mt_rand(11111, 999999);
        $expireTime = 5;

        $initRow = $model->getRowById(AnnouncementModel::ID);
        if (empty($initRow)) {
            $info['id'] = AnnouncementModel::ID;
            $info['flag'] = AnnouncementModel::STATUS_DISABLE;
            $info['content'] = '';
            $info['expire_time'] = time();
            $model->insertItem($info);
            $initRow = $model->getRowById(AnnouncementModel::ID);
        }
        $ret = $model->release($content, $expireTime);
        $this->assertTrue($ret);
        $row = $model->getRowById(AnnouncementModel::ID);
        $this->assertEquals($content, $content);
        $this->assertEquals(AnnouncementModel::STATUS_RELEASE, (int)$row['status']);
        if (!empty($initRow)) {
            $this->assertEquals((int)$initRow['flag'] + 1, $row['flag']);
        }

        // 2.测试 disable
        $model->disable();
        $row = $model->getRowById(AnnouncementModel::ID);
        $this->assertEquals(AnnouncementModel::STATUS_DISABLE, (int)$row['status']);

        // 3.还原
        $ret = (bool)$model->updateById(AnnouncementModel::ID, $row);
        $this->assertTrue($ret);
    }
}
