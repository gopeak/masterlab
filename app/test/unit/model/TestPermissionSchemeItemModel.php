<?php

namespace main\app\test\unit\model;

use PHPUnit\Framework\TestCase;
use main\app\model\user\PermissionSchemeItemModel;

class TestPermissionSchemeItemModel extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 测试一整套流程
     */
    public function testMain()
    {
        $schemeId = '190' . mt_rand(1234678, 9999999);
        $permissionKey = '_key';
        $info['scheme'] = $schemeId;
        $info['perm_type'] = 'group';
        $info['perm_parameter'] = 'developers';
        $info['permission_key'] = $permissionKey;

        $model = new PermissionSchemeItemModel();

        // 1.新增数据
        list($ret, $insertId) = $model->insert($info);
        $this->assertTrue($ret, $insertId);

        // 2.测试 getItemsByIdPermissionKey 方法
        $rows = $model->getItemsByIdPermissionKey($schemeId, $permissionKey);
        $this->assertNotEmpty($rows);
        $this->assertCount(1, $rows);
        $this->assertEquals($info['permission_key'], $rows[0]['permission_key']);
        $this->assertEquals($info['perm_parameter'], $rows[0]['perm_parameter']);

        // 3.测试getItemsById方法
        $rows2 = $model->getItemsById($schemeId);
        $this->assertEquals($rows, $rows2);

        // 4.清除测试数据
        $model->deleteById($insertId);
    }
}
