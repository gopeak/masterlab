<?php

namespace main\app\test\unit\model\user;

use PHPUnit\Framework\TestCase;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;

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
    public static function initUser($info=[])
    {
        $user = BaseDataProvider::createUser($info);
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
