<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\WorkflowSchemeModel;

/**
 * WorkflowSchemeModel 测试类
 * User: sven
 */
class TestWorkflowSchemeModel extends TestBaseIssueModel
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
            $model = new WorkflowSchemeModel();
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
        $model = new WorkflowSchemeModel();
        // 1. 新增测试需要的数据
        $info = [];
        $info['name'] = 'test-' . mt_rand(10000, 99999);
        $info['description'] = 'test-description';
        $info['is_system'] = '0';
        list($ret, $insertId) = $model->insert($info);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }

        // 2.测试 getByName
        $row = $model->getByName($info['name']);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }
        // 3.测试 getAllItems
        $rows = $model->fetchAll();
        $this->assertNotEmpty($rows);
        foreach ($rows as $key => $row) {
            $this->assertTrue(is_array($row));
        }
        $rows = $model->fetchAll(true);
        foreach ($rows as $key => $row) {
            $this->assertEquals($key, $row['id']);
        }

        // 4.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);
    }
}
