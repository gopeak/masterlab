<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\user\GroupModel;

/**
 *  GroupModel 测试类
 * User: sven
 */
class TestGroupModel extends TestCase
{
    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new GroupModel();

        // 1.测试getAll
        $goupsByKey = $model->getAll(true);
        $this->assertNotEmpty($goupsByKey);
        foreach ($goupsByKey as $key => $row) {
            $this->assertEquals($key, $row['id']);
        }
        $groupArr = $model->getAll(false);
        $this->assertNotEmpty($groupArr);
        foreach ($groupArr as $key => $val) {
            $this->assertTrue(is_int($key), $key.'=> error');
        }

        // 2.新增一条记录
        $name = 'group_' . mt_rand(12345678, 92345678);
        $description = 'abc';
        $active = 1;
        list($ret, $insertId) = $model->add($name, $description, $active);
        $this->assertTrue($ret, $insertId);

        // 3.测试 getById
        $row = $model->getById($insertId);
        $this->assertEquals($name, $row['name']);
        $this->assertEquals($description, $row['description']);
        $this->assertEquals($active, (int)$row['active']);

        // 4.测试 getByName
        $row = $model->getByName($name);
        $this->assertEquals($name, $row['name']);
        $this->assertEquals($description, $row['description']);
        $this->assertEquals($active, (int)$row['active']);

        // 5.测试 getIds
        $groupIds = $model->getIds();
        $goupsByKey = $model->getAll(true);
        $this->assertNotEmpty($groupIds);
        foreach ($groupIds as $groupId) {
            $this->assertArrayHasKey($groupId, $goupsByKey);
        }
        // 5.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);
    }
}
