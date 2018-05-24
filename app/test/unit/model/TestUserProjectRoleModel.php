<?php

namespace main\app\test\unit\model;


use PHPUnit\Framework\TestCase;
use main\app\model\user\UserProjectRoleModel;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;

/**
 *  UserProjectRoleModel 测试类
 * User: sven
 */
class TestUserProjectRoleModel extends TestCase
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
     */
    public static function initUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);


        // 表单数据 $post_data
        $postData = [];
        $postData['username'] = $username;
        $postData['phone'] = $username;
        $postData['email'] = $username . '@masterlab.org';
        $postData['display_name'] = $username;
        $postData['status'] = UserLogic::STATUS_OK;
        $postData['openid'] = UserAuth::createOpenid($username);

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($postData);
        if (!$ret) {
            var_dump('initUser  failed,' . $msg);
            parent::fail('initUser  failed,' . $msg);
            return;
        }
        $user = $userModel->getRowById($msg);
        return $user;
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        $userModel = new UserModel();
        $userModel->deleteById(self::$user['uid']);

        $model = new UserProjectRoleModel();
        $model->deleteById(self::$user['uid']);
    }

    /**
     * 测试新增
     */
    public function testInsertRole()
    {
        $uid = self::$user['uid'];

        $userRoleId = self::USER_ROLE_ID;
        $devRoleId = self::DEV_ROLE_ID;
        $adminRoleId = self::ADMIN_ROLE_ID;
        $projectId = self::PROJECT_ID;

        $model = new UserProjectRoleModel();
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

        $model = new UserProjectRoleModel();
        // 获取用户在某一项目的多个角色id
        $userRoles = $model->getUserRolesByProject($uid, $projectId);
        $this->assertNotEmpty($userRoles);
        $this->assertContains($userRoleId, $userRoles);
        $this->assertContains($devRoleId, $userRoles);
        $this->assertNotContains($adminRoleId, $userRoles);
    }

    public function testGetUidsByProjectRole()
    {
        $uid = self::$user['uid'];

        $userRoleId = self::USER_ROLE_ID;
        $devRoleId = self::DEV_ROLE_ID;
        $adminRoleId = self::ADMIN_ROLE_ID;
        $projectId = self::PROJECT_ID;

        $model = new UserProjectRoleModel();

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

        $model = new UserProjectRoleModel();

        //  清除数据
        $ret = $model->deleteByProjectRole($uid, $projectId, $devRoleId);
        $this->assertEquals(1, $ret);

        $ret = (bool)$model->deleteByUid($uid);
        $this->assertTrue($ret);
    }
}
