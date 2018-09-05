<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\OrgModel;

/**
 *  OrgModel 测试类
 * User: sven
 */
class TestOrgModel extends TestCase
{
    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * @throws \Exception
     */
    public function testMain()
    {
        $model = new OrgModel();

        // 1.测试getAll
        $all = $model->getAllItems();
        $this->assertNotEmpty($all);
        foreach ($all as $key => $val) {
            $this->assertTrue(is_int($key));
            unset($val);
        }

        // 必须有一个 默认 的组织
        $defaultPath = 'default';
        $defaultOrg = $model->getByPath($defaultPath);
        $this->assertEquals($defaultPath, $defaultOrg['path']);

        //  新增一条记录
        $name = 'test-org-' . mt_rand(12345678, 92345678);
        $description = "test-description";
        $avatar = 'avatar';
        $info = [];
        $info['name'] = $name;
        $info['path'] = $name;
        $info['description'] = $description;
        $info['avatar'] = $avatar;
        list($ret, $insertId) = $model->insertItem($info);
        $this->assertTrue($ret, $insertId);

        // 3.测试 getById
        $row = $model->getById($insertId);
        $this->assertEquals($name, $row['name']);
        $this->assertEquals($description, $row['description']);
        $this->assertEquals($avatar, $row['avatar']);

        // 4.测试 getByName
        $row = $model->getByName($name);
        $this->assertEquals($name, $row['name']);
        $this->assertEquals($description, $row['description']);
        $this->assertEquals($avatar, $row['avatar']);

        // getPaths
        $rows = $model->getPaths();
        $this->assertNotEmpty($rows);

        // 更新
        $info = [];
        $info['name'] = $name . '-updated';
        $info['path'] = $description . '-updated';
        $info['description'] = $name . '-updated';
        $info['avatar'] = '';
        list($ret, $msg) = $model->updateItem($insertId, $info);
        $this->assertTrue($ret, $msg);
        $row = $model->getById($insertId);
        $this->assertEquals($info['name'], $row['name']);
        $this->assertEquals($info['description'], $row['description']);
        $this->assertEquals($info['avatar'], $row['avatar']);
        $this->assertEquals($info['path'], $row['path']);

        // 5.删除
        $ret = (bool)$model->deleteById($insertId);
        $this->assertTrue($ret);
    }
}
