<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;

/**
 * IssueTypeSchemeModel 测试类
 * User: sven
 */
class TestIssueTypeSchemeModel extends TestBaseIssueModel
{

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
            $model = new IssueTypeSchemeItemsModel();
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
        $model = new IssueTypeSchemeModel();
        // 1. 新增测试需要的数据
        $info = [];
        $info['name'] = 'test-' . mt_rand(10000, 99999);
        $info['description'] = 'test-description';
        $info['is_default'] = '0';
        list($ret, $schemeId) = $model->insert($info);
        $this->assertTrue($ret);
        if ($ret) {
            self::$insertIdArr[] = $schemeId;
        }

        // 2.测试 getItemsBySchemeId
        $row = $model->getByName($info['name']);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 3.删除
        $ret = (bool)$model->deleteById($schemeId);
        $this->assertTrue($ret);
    }
}
