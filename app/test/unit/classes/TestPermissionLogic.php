<?php

namespace main\app\test\unit\classes;

use main\app\model\project\ProjectRoleModel;
use main\app\model\user\GroupModel;
use PHPUnit\Framework\TestCase;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectLogic;

/**
 *  PermissionLogic 测试类
 * @package main\app\test\logic
 */
class TestPermissionLogic extends TestCase
{
    public static $schemeId = 0;

    public static $project = [];

    public static $user = [];

    public static $userRoles = [];

    public static $userGroups = [];


    /**
     * 测试前准备
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        // 先初始化一个项目,并指定权限方案为默认
        $info['permission_scheme_id'] = self::$schemeId;
        self::$project = PermissionLogicDataProvider::initProject($info);
        list($flag, $roleInfo) = ProjectLogic::initRole(self::$project['id']);
        if(!$flag){
            var_dump($roleInfo);
        }
        // 初始用户
        self::$user = PermissionLogicDataProvider::initUser();

        // 给用户当前项目赋予角色
        $model = new ProjectRoleModel();
        self::$userRoles = $model->getsAll();
        foreach (self::$userRoles as $userRole) {
            $roleId = $userRole['id'];
            PermissionLogicDataProvider::initUserProjectRole(self::$user['uid'], self::$project['id'], $roleId);
        }

        // 用户加入用户组
        $model = new GroupModel();
        self::$userGroups = $model->getAll(false);
        foreach (self::$userGroups as $userGroup) {
            $groupId = $userGroup['id'];
            PermissionLogicDataProvider::initUserGroup(self::$user['uid'], $groupId);
        }
    }

    /**
     * 测试后清除数据
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        PermissionLogicDataProvider::clear();
    }

    /**
     * 测试主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $logic = new PermissionLogic();
        $projectId = self::$project['id'];
        $userId = self::$user['uid'];

        $ret = $logic->checkUserHaveProjectItem($userId, $projectId);
        $this->assertTrue($ret);
        $ret = $logic->checkUserHaveProjectItem($userId, 0);
        $this->assertFalse($ret);


        //$ret = $logic->getUserHaveProjectPermissions($userId, $projectId);
        //$this->assertNotEmpty($ret);

        $key1 = $projectId . '_' . self::$userRoles[0]['id'];
        $key2 = $projectId . '_' . mt_rand(10000, 999999);
        $data[$key1] = '';
        $data[$key2] = '';
        list($ret, $msg) = $logic->updateUserProjectRole($userId, $data);
        $this->assertTrue($ret, $msg);

        list($ret) = $logic->updateUserProjectRole($userId, []);
        $this->assertFalse($ret);
    }
}
