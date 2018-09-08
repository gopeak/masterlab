<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueFilterModel;

/**
 *  IssueFilterModel 测试类
 * User: sven
 */
class TestIssueFilterModel extends TestBaseIssueModel
{
    /**
     * issue 数据
     * @var array
     */
    public static $issue = [];

    public static $insertId = null;

    public static function setUpBeforeClass()
    {
    }

    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$insertId)) {
            $model = new IssueFilterModel();
            $model->deleteById(self::$insertId);
        }
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new IssueFilterModel();
        // 1. 新增测试需要的数据
        $userId = mt_rand(12345678, 92345678);
        $info = [];
        $info['author'] = $userId;
        $info['name'] = 'test-name';
        $info['description'] = 'test-description';
        $info['share_obj'] = 'test-share_obj';
        $info['share_scope'] = 'all';
        $info['filter'] = 'test-filter';
        $info['fav_count'] = 1;
        list($ret, $insertId) = $model->addItem($info);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertId = $insertId;
        }
        // 2.测试 getItemById
        $row = $model->getItemById($insertId);
        $this->assertNotEmpty($row);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 3.测试 updateItemId
        $updateInfo = [];
        $updateInfo['name'] = 'test-name-updated';
        $updateInfo['filter'] = 'test-filter-updated';
        list($ret, $msg) = $model->updateItemById($insertId, $updateInfo);
        $this->assertTrue($ret, $msg);
        $row = $model->getItemById($insertId);
        $this->assertEquals($updateInfo['name'], $row['name']);
        $this->assertEquals($updateInfo['filter'], $row['filter']);

        // 4. 测试 getCurUserFilter
        $rows = $model->getCurUserFilter($userId);
        $this->assertNotEmpty($rows);
        $this->assertCount(1, $rows);

        // 5.删除
        $ret = (bool)$model->deleteItemById($insertId);
        $this->assertTrue($ret);
    }
}
