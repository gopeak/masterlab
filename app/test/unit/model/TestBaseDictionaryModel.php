<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\BaseDictionaryModel;

/**
 *  BaseDictionaryModel 测试类
 * User: sven
 */
class TestBaseDictionaryModel extends TestCase
{

    public static $insertIdArr = [];

    /**
     * @var BaseDictionaryModel
     */
    public static $model = null;

    public static function setUpBeforeClass()
    {
        // 构建实例
        $model = new BaseDictionaryModel();
        $model->prefix = 'main_';
        $model->table = 'group';
        $model->primaryKey = 'id';
        self::$model = $model;
    }

    public static function tearDownAfterClass()
    {
        if (!empty(self::$insertIdArr)) {
            foreach (self::$insertIdArr as $id) {
                self::$model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $model = self::$model;

        // 1.测试getAll
        $goupsByKey = $model->getAll(true);
        $this->assertNotEmpty($goupsByKey);
        foreach ($goupsByKey as $key => $row) {
            $this->assertEquals($key, $row['id']);
        }
        $goupsArr = $model->getAll(false);
        $this->assertNotEmpty($goupsArr);
        foreach ($goupsArr as $key => $val) {
            $this->assertTrue(is_int($key));
        }

        // 2.新增一条记录
        $info = [];
        $info['name'] = 'test-name' . mt_rand(100000, 9999999);
        $info['description'] = 'test-description';
        $info['active'] = 1;
        list($ret, $insertId) = $model->insertItem($info);
        $this->assertTrue($ret, $insertId);
        if ($ret) {
            self::$insertIdArr[] = $insertId;
        }

        // 3.测试 getById
        $row = $model->getItemById($insertId);
        $this->assertNotEmpty($row);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 4.测试 getByName
        $row = $model->getItemByName($info['name']);
        $this->assertNotEmpty($row);
        foreach ($info as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 5.测试updateItem
        $updateInfo = [];
        $updateInfo['name'] = 'test-name2' . mt_rand(1, 99999);
        $updateInfo['description'] = 'test-description2';
        $updateInfo['active'] = 0;
        list($ret, $msg) = $model->updateItem($insertId, $updateInfo);
        $this->assertTrue($ret, $msg);
        $row = $model->getRowById($insertId);
        $this->assertNotEmpty($row);
        foreach ($updateInfo as $key => $val) {
            $this->assertEquals($val, $row[$key]);
        }

        // 5.删除
        $ret = (bool)$model->deleteItem($insertId);
        $this->assertTrue($ret);

        // 6.测试deleteItemByName
        $info = [];
        $info['name'] = 'test-name2' . mt_rand(99999, 999999);
        $info['description'] = 'test-description2';
        $info['active'] = 1;
        list($ret, $insertId2) = $model->insertItem($info);
        $this->assertTrue($ret, $insertId2);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }
        $ret = (bool)$model->deleteItemByName($info['name']);
        $this->assertTrue($ret);
    }
}
