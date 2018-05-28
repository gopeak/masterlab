<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\WorkflowModel;

/**
 * WorkflowModel 测试类
 * User: sven
 */
class TestWorkflowModel extends TestBaseIssueModel
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
            $model = new WorkflowModel();
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
        $model = new WorkflowModel();
        // 1. 新增测试需要的数据
        $info = [];
        $info['name'] = 'test-name-' . mt_rand(11111, 999999);
        $info['description'] = 'test-description';
        $info['create_uid'] = 1;
        $info['steps'] = 0;
        $info['data'] = '{}';
        $info['is_system'] = 0;
        list($ret, $insertId) = $model->add($info);
        $this->assertTrue($ret);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }
        // 2.测试 getById
        $row = $model->getById($insertId);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }
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
