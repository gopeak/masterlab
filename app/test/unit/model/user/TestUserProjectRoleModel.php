<?php

namespace main\app\test\unit\model\user;

use PHPUnit\Framework\TestCase;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;

/**
 *  ProjectUserRoleModel 测试类
 * User: sven
 */
class TestProjectUserRoleModel extends TestCase
{
    /**
     * 用户数据
     * @var array
     */
    public static $user = [];

    const ADMIN_ROLE_ID = '10002';

    const DEV_ROLE_ID = '10001';

    const USER_ROLE_ID = '10000';

    const PROJECT_ID = '5';


    /**
     *
     */
    public static function setUpBeforeClass()
    {
        self::$user = self::initUser();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }

    /**
     * 初始化用户
     * @throws \Exception
     */
    public static function initUser($info=[])
    {
        $user = BaseDataProvider::createUser($info);
        return $user;
    }

    /**
     * 清除数据
     * @throws \Exception
     */
    public static function clearData()
    {
        $userModel = new UserModel();
        $userModel->deleteById(self::$user['uid']);

        $model = new ProjectUserRoleModel();
        $model->deleteById(self::$user['uid']);
    }

    /**
     * 测试新增
     * @throws \Exception
     */
    public function testInsertRole()
    {
        $uid = self::$user['uid'];

        $userRoleId = self::USER_ROLE_ID;
        $devRoleId = self::DEV_ROLE_ID;
        $adminRoleId = self::ADMIN_ROLE_ID;
        $projectId = self::PROJECT_ID;

        $model = new ProjectUserRoleModel();
        list($ret) = $model->insertRole($uid, $projectId, $userRoleId);
        $this->assertTrue($ret);
        list($ret) = $model->insertRole($uid, $projectId, $devRoleId);
        $this->assertTrue($ret);
    }

    /**
     *
     */
    public function testGetUserRolesByProject()
    {
        $uid = self::$user['uid'];

        $userRoleId = self::USER_ROLE_ID;
        $devRoleId = self::DEV_ROLE_ID;
        $adminRoleId = self::ADMIN_ROLE_ID;
        $projectId = self::PROJECT_ID;

        $model = new ProjectUserRoleModel();
        // 获取用户在某一项目的多个角色id
        $userRoles = $model->getUserRolesByProject($uid, $projectId);
        $this->assertNotEmpty($userRoles);
        $this->assertContains($userRoleId, $userRoles);
        $this->assertContains($devRoleId, $userRoles);
        $this->assertNotContains($adminRoleId, $userRoles);
    }

    /**
     * @throws \Exception
     */
    public function testGetUidsByProjectRole()
    {
        $uid = self::$user['uid'];

        $userRoleId = self::USER_ROLE_ID;
        $devRoleId = self::DEV_ROLE_ID;
        $adminRoleId = self::ADMIN_ROLE_ID;
        $projectId = self::PROJECT_ID;

        $model = new ProjectUserRoleModel();

        // 通过组获取多个用户id
        $roleIds = [$userRoleId, $devRoleId];
        $userIds = $model->getUidsByProjectRole([$projectId], $roleIds);
        $this->assertContains($uid, $userIds);

        // 测试 getUidsByProjectRole分发
        // 新增一个用户，并赋予管理员角色
        $newUser = self::initUser();
        $newUserId = $newUser['uid'];
        $model->insertRole($newUser['uid'], $projectId, $adminRoleId);
        // 空的情况
        $roleIds = [];
        $userIds = $model->getUidsByProjectRole([$projectId], $roleIds);
        $this->assertEmpty($userIds);
        // 单个用户的情况
        $roleIds = [$userRoleId];
        $userIds = $model->getUidsByProjectRole([$projectId], $roleIds);
        $this->assertNotContains($newUserId, $userIds);
        // 多个用户的情况
        $roleIds = [$userRoleId, $devRoleId, $adminRoleId];
        $userIds = $model->getUidsByProjectRole([$projectId], $roleIds);
        $this->assertContains($uid, $userIds);
        $this->assertContains($newUserId, $userIds);

        //  清除新增的用户
        $userModel = new UserModel();
        $userModel->deleteById($newUserId);
    }

    public function testDelete()
    {
        $uid = self::$user['uid'];

        $devRoleId = self::DEV_ROLE_ID;
        $projectId = self::PROJECT_ID;

        $model = new ProjectUserRoleModel();

        //  清除数据
        $ret = $model->deleteByProjectRole($uid, $projectId, $devRoleId);
        $this->assertEquals(1, $ret);

        $ret = (bool)$model->deleteByUid($uid);
        $this->assertTrue($ret);
    }
}
