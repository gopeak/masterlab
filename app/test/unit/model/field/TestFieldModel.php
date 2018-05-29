<?php

namespace main\app\test\unit\model\issue;

use main\app\model\field\FieldModel;

/**
 * FieldModel 测试类
 * User: sven
 */
class TestFieldModel extends TestBaseIssueModel
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
            $model = new FieldModel();
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
        $model = new FieldModel();
        // 1. 新增测试需要的数据
        $info = [];
        $info['name'] = 'test-name-' . mt_rand(11111, 999999);
        $info['title'] = $info['name'];
        $info['description'] = 'test-description';
        $info['type'] = 'TEXT';
        $info['default_value'] = null;
        $info['options'] = '{}';
        $info['is_system'] = 0;
        list($ret, $insertId) = $model->insert($info);
        $this->assertTrue($ret);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }

        // 2.测试 getById

        // 3.测试 getByName
        $row = $model->getByName($info['name']);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 4.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);
    }
}
