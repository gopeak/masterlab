<?php

namespace main\app\test\unit\classes;

use main\app\model\project\ProjectRoleModel;
use main\app\model\user\GroupModel;
use main\app\model\user\UserModel;
use main\app\model\system\OrgModel;
use main\app\classes\UserLogic;
use main\app\classes\ProjectLogic;
use main\app\test\BaseAppTestCase;

/**
 *  UserLogic 测试类
 * @package main\app\test\logic
 */
class TestUserLogic extends BaseAppTestCase
{
    public static $project = [];

    public static $user = [];

    public static $users = [];

    public static $userRoles = [];

    public static $userGroups = [];


    public static function setUpBeforeClass()
    {
        // 先初始化一个项目
        self::$project = UserLogicDataProvider::initProject();
        list($flag, $roleInfo) = ProjectLogic::initRole(self::$project['id']);
        if(!$flag){
            var_dump($roleInfo);
        }
        // 初始用户
        $info = [];
        self::$user = UserLogicDataProvider::initUser($info);
        for ($i = 0; $i < 10; $i++) {
            self::$users[] = UserLogicDataProvider::initUser($info);
        }

        // 给用户当前项目赋予角色
        $model = new ProjectRoleModel();
        self::$userRoles = $model->getsAll();
        foreach (self::$userRoles as $userRole) {
            $roleId = $userRole['id'];
            UserLogicDataProvider::initUserProjectRole(self::$user['uid'], self::$project['id'], $roleId);
        }

        // 用户加入用户组
        $model = new GroupModel();
        self::$userGroups = $model->getAll(false);
        foreach (self::$userGroups as $userGroup) {
            $groupId = $userGroup['id'];
            UserLogicDataProvider::initUserGroup(self::$user['uid'], $groupId);
        }
    }

    public static function tearDownAfterClass()
    {
        UserLogicDataProvider::clear();
    }

    /**
     * @throws \Exception
     */
    public function testMain()
    {
        $logic = new UserLogic();

        $ret = $logic::formatAvatar('');
        $this->assertStringStartsWith('http', $ret);

        $ret = $logic::formatAvatar('abc/avatar.png');
        $this->assertStringStartsWith('http', $ret);

        $ret = $logic::formatAvatar('', 'abc@masterlab.org');
        $this->assertContains('gravatar', $ret);

        $users = $logic->getAllNormalUser();
        $this->assertTrue(count($users) > 10);
        // 测试排序
        $first = current($users);
        $end = end($users);
        $this->assertTrue($first['uid'] > $end['uid']);
        foreach ($users as $user) {
            $this->assertEquals(UserModel::STATUS_NORMAL, $user['status']);
        }

        $users = $logic->getUserLimit(10);
        $this->assertCount(10, $users);
        foreach ($users as $user) {
            $this->assertEquals(UserModel::STATUS_NORMAL, $user['status']);
        }
        // 测试排序
        reset($users);
        $first = current($users);
        $end = end($users);
        $this->assertTrue((int)$first['uid'] > (int)$end['uid']);
    }

    /**
     * @throws \Exception
     */
    public function testFilter()
    {
        $logic = new UserLogic();

        // 默认获取用户
        list($users) = $logic->filter();
        $this->assertNotEmpty($users);

        // 分页为 10
        $uid = 0;
        $username = '';
        $groupId = 0;
        $status = '';
        $orderBy = 'uid';
        $sort = 'desc';
        $page = 1;
        $pageSize = 10;
        list($users) = $logic->filter($uid, $username, $groupId, $status, $orderBy, $sort, $page, $pageSize);
        $this->assertNotEmpty($users);
        $this->assertCount(10, $users);

        // 指定用户id
        $uid = self::$user['uid'];
        list($users) = $logic->filter($uid);
        $this->assertNotEmpty($users);
        $this->assertCount(1, $users);

        // 指定用户名
        $username = self::$user['username'];
        list($users, $count) = $logic->filter($uid, $username);
        $this->assertNotEmpty($users);
        $this->assertEquals(1, $count);

        // 指定用户组id
        $model = new GroupModel();
        $groupId = $model->getAll(false)[0]['id'];
        list($users) = $logic->filter('', '', $groupId);
        //var_dump($users);
        if (!empty($users)) {
            foreach ($users as $user) {
                $groupIdArr = [];
                foreach ($user['group'] as $item) {
                    $groupIdArr[] = $item['id'];
                }
                $this->assertContains($groupId, $groupIdArr);
            }
        }

        // 更改用户状态作为条件
        $status = UserModel::STATUS_DISABLED;
        list($users) = $logic->filter('', '', 0, $status);
        if (!empty($users)) {
            foreach ($users as $user) {
                $this->assertEquals($user['status'], $status);
            }
        }

        // 降序排序
        $status = UserModel::STATUS_NORMAL;
        $orderBy = 'uid';
        $sort = 'asc';
        $page = 1;
        list($users) = $logic->filter('', '', 0, $status, $orderBy, $sort, $page, $pageSize);
        $first = current($users);
        $end = end($users);
        $orderWeight1 = parent::getArrItemOrderWeight($users, 'uid', $first['uid']);
        $orderWeight2 = parent::getArrItemOrderWeight($users, 'uid', $end['uid']);
        $this->assertTrue($orderWeight1 < $orderWeight2);

        // 分页到第二页
        $page = 2;
        $orderBy = 'uid';
        list($users) = $logic->filter('', '', 0, '', $orderBy, $sort, $page, $pageSize);
        $this->assertNotEmpty($users);
    }

    /**
     * @throws \Exception
     */
    public function testSelectUserFilter()
    {
        $logic = new UserLogic();

        // 测试直接获取
        $users = $logic->selectUserFilter();
        $this->assertNotEmpty($users);
        $search = null;
        $limit = null;
        $project_id = null;
        $group_id = null;
        $skip_user_ids = null;

        // 测试用户名
        $search = self::$user['username'];
        $users = $logic->selectUserFilter($search);
        $this->assertNotEmpty($users);

        // 限制数量
        $limit = 2;
        $users = $logic->selectUserFilter(null, $limit);
        $this->assertNotEmpty($users);
        $this->assertCount($limit, $users);

        // 测试全部为正常状态
        $limit = 2;
        $active = true;
        $users = $logic->selectUserFilter(null, $limit, $active);
        $this->assertNotEmpty($users);
        $this->assertCount($limit, $users);
        foreach ($users as $user) {
            $this->assertEquals($user['status'], UserModel::STATUS_NORMAL);
        }

        // 测试所在项目
        $limit = 2;
        $active = true;
        $projectId = self::$project['id'];
        $users = $logic->selectUserFilter(null, $limit, $active, $projectId);
        $this->assertNotEmpty($users);

        // 测试用户组
        $limit = 2;
        $active = true;
        $model = new GroupModel();
        $groupId = $model->getAll(false)[0]['id'];
        $users = $logic->selectUserFilter(null, $limit, $active, null, $groupId);
        $this->assertNotEmpty($users);

        // 测试排除用户
        $skipUserIds = [self::$user['uid']];
        $users = $logic->selectUserFilter(null, null, null, null, null, $skipUserIds);
        $userIdArr = [];
        foreach ($users as $user) {
            $userIdArr[] = $user['id'];
        }
        // var_dump(self::$user['uid'], $userIdArr);
        $this->assertNotContains(self::$user['uid'], $userIdArr);
    }

    /**
     * @throws \Exception
     */
    public function testGroupFilter()
    {
        $logic = new UserLogic();
        list($rows) = $logic->groupFilter();
        $this->assertNotEmpty($rows);
        $group = current($rows);
        $name = $group['name'];
        list($rows, $count) = $logic->groupFilter($name);
        $this->assertNotEmpty($rows);
        $this->assertEquals(1, $count);
        $this->assertEquals($name, $rows[0]['name']);

        list($rows) = $logic->groupFilter('', 1, 1);
        $this->assertNotEmpty($rows);
        $this->assertCount(1, $rows);
    }
}
