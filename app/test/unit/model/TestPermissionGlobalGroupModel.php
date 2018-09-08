<?php

namespace main\app\test\unit\model\issue;

use main\app\model\issue\IssueTypeModel;
use main\app\model\permission\PermissionGlobalGroupModel;

/**
 * PermissionGlobalGroupModel 测试类
 * User: sven
 */
class TestPermissionGlobalGroupModel extends TestBaseIssueModel
{

    public static $scheme = [];

    public static $insertIdArr = [];

    const PERM_GLOBAL_ID = 0;

    public static function setUpBeforeClass()
    {
    }

    /**
     * 确保生成的测试数据被清除
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$insertIdArr)) {
            $model = new PermissionGlobalGroupModel();
            foreach (self::$insertIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $permGlobalId = self::PERM_GLOBAL_ID;
        $model = new PermissionGlobalGroupModel();
        $model->delete(['perm_global_id'=>$permGlobalId]);

        // 1. 新增测试需要的数据
        $groupId = 1;
        list($ret, $insertId1) = $model->add($permGlobalId, $groupId);
        $this->assertTrue($ret, $insertId1);
        if ($ret) {
            self::$insertIdArr[] = $insertId1;
        }
        $groupId2 = 2;
        list($ret, $insertId2) = $model->add($permGlobalId, $groupId2);
        $this->assertTrue($ret, $insertId2);
        if ($ret) {
            self::$insertIdArr[] = $insertId2;
        }

        // 2.测试 getsByParentId
        $rows = $model->getsByParentId($permGlobalId);
        $this->assertNotEmpty($rows);
        $this->assertCount(2, $rows);
        $row = $rows[0];
        $this->assertEquals($permGlobalId, $row['perm_global_id']);

        // getByParentIdAndGroupId
        $rows = $model->getByParentIdAndGroupId($permGlobalId, $groupId);
        $this->assertNotEmpty($rows);

        $rows = $model->getByParentIdAndGroupId($permGlobalId, $groupId2);
        $this->assertNotEmpty($rows);

        // 3.删除
        $ret = (bool)$model->delete(['perm_global_id'=>$permGlobalId]);
        $this->assertTrue($ret);
    }
}
