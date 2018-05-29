<?php

namespace main\app\test\unit\model\user;

use PHPUnit\Framework\TestCase;
use main\app\model\user\UserGroupModel;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;

/**
 *  UserGroupModel 测试类
 * User: sven
 */
class TestUserGroupModel extends TestCase
{
    /**
     * 用户数据
     * @var array
     */
    public static $user = [];

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

        $model = new UserGroupModel();
        $model->deleteById(self::$user['uid']);
    }

    /**
     * 测试获取当前用户设置
     */
    public function testMain()
    {
        $uid = self::$user['uid'];
        $adminGroupId = '1';
        $devGroupId = '2';
        $model = new UserGroupModel();
        list($ret) = $model->add($uid, $adminGroupId);
        $this->assertTrue($ret);
        list($ret) = $model->add($uid, $devGroupId);
        $this->assertTrue($ret);


        // 获取用户的组id
        $userGroups = $model->getGroupsByUid($uid);
        $this->assertNotEmpty($userGroups);
        $this->assertContains($adminGroupId, $userGroups);
        $this->assertContains($devGroupId, $userGroups);

        // 通过组获取多个用户id
        $groups = [$adminGroupId, $devGroupId];
        $userIds = $model->getUserIdsByGroups($groups);
        $this->assertContains($uid, $userIds);

        // 测试 getsByUserIds,只有一个用户id
        $newUser = self::initUser();
        $newUserId = $newUser['uid'];
        $model->add($newUser['uid'], $adminGroupId);
        // 空的情况
        $userIds = [];
        $groups =  $model->getsByUserIds($userIds);
        $this->assertEmpty($groups);
        // 单个用户id
        $userIds = [$newUser['uid']];
        $groups =  $model->getsByUserIds($userIds);
        $this->assertContains($adminGroupId, $groups[$newUserId]);
        $this->assertNotContains($devGroupId, $groups[$newUserId]);
        // 多个用户id
        $userIds = [$uid, $newUser['uid']];
        $groups =  $model->getsByUserIds($userIds);
        $this->assertContains($adminGroupId, $groups[$uid]);
        $this->assertContains($devGroupId, $groups[$uid]);
        $this->assertContains($adminGroupId, $groups[$newUserId]);
        $this->assertNotContains($devGroupId, $groups[$newUserId]);

        //  清除数据
        $ret = $model->deleteByGroupIdUid($uid, $devGroupId);
        $this->assertEquals(1, $ret);

        $ret = (bool)$model->deleteByUid($uid);
        $this->assertTrue($ret);

        $ret = (bool)$model->deleteByUid($newUserId);
        $this->assertTrue($ret);

        $userModel = new UserModel();
        $userModel->deleteById($newUserId);
    }
}
