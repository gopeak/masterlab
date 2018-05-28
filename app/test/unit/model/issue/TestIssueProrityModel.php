<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;

/**
 *  IssuePriorityModel 测试类
 * User: sven
 */
class TestIssuePriorityModel extends TestBaseIssueModel
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
        if (!empty(self::$insertIdArr)) {
            $model = new IssuePriorityModel();
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
        $model = new IssuePriorityModel();
        // 1. 新增测试需要的数据
        $info = [];
        $info['name'] = 'test-name' . mt_rand(12345678, 92345678);
        $info['sequence'] = mt_rand(10, 100);
        $info['_key'] = 'test-key' . mt_rand(12345678, 92345678);
        $info['description'] = 'test-description1';
        list($ret, $insertId1) = $model->insertItem($info);
        $this->assertTrue($ret, $insertId1);
        if ($ret) {
            self::$insertIdArr[] = $insertId1;
        }
        $info = [];
        $info['name'] = 'test-name2' . mt_rand(12345678, 92345678);
        $info['sequence'] = mt_rand(100, 200);
        $info['_key'] = 'test-key2' . mt_rand(12345678, 92345678);
        $info['description'] = 'test-description2';
        list($ret, $insertId2) = $model->insertItem($info);
        $this->assertTrue($ret, $insertId2);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }
        // 2.测试 getItemById
        $row = $model->getItemById($insertId1);
        $this->assertNotEmpty($row);
        // 3.测试 getAll
        $allPriorityArr = $model->getAllItem(false);
        $this->assertNotEmpty($allPriorityArr);
        // print_r($allPriorityArr);
        // 4.测试排序
        $insertId1OrderWeight = parent::getArrItemOrderWeight($allPriorityArr, 'id', $insertId1);
        $insertId2OrderWeight = parent::getArrItemOrderWeight($allPriorityArr, 'id', $insertId2);
        $this->assertTrue($insertId2OrderWeight<$insertId1OrderWeight);

        // 5.主键作为主键的情况
        $allPriorityArrKey = $model->getAllItem(true);
        $keys = array_keys($allPriorityArrKey);
        $allPriorityIds = [];
        foreach ($allPriorityArr as $item) {
            $allPriorityIds[] = $item['id'];
        }
        foreach ($allPriorityIds as $id) {
            $this->assertTrue(in_array($id, $keys));
        }

        // 6. 测试 getByName
        $first = current($allPriorityArr);
        $row = $model->getByName($first['name']);
        foreach ($first as $key => $val) {
            if (isset($row[$key])) {
                $this->assertEquals($val, $row[$key]);
            }
        }
        // 7. 测试 getById
        $row = $model->getById($insertId2);
        foreach ($info as $key => $val) {
            if (isset($row[$key])) {
                $this->assertEquals($val, $row[$key]);
            }
        }
        $row = $model->getByKey($first['_key']);
        foreach ($first as $key => $val) {
            if (isset($row[$key])) {
                $this->assertEquals($val, $row[$key]);
            }
        }
        $id = $model->getIdByKey($first['_key']);
        $this->assertEquals($id, $first['id']);

        //8.删除
        $ret = (bool)$model->deleteItem($insertId1);
        $this->assertTrue($ret);
        $ret = (bool)$model->deleteItem($insertId2);
        $this->assertTrue($ret);
    }
}
