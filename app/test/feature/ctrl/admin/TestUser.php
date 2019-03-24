<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssueStatusModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\GroupModel;
use main\app\model\user\UserModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 *  User 测试类
 * @package main\app\test\logic
 */
class TestUser extends BaseAppTestCase
{
    public static $project = [];

    public static $user = [];

    public static $users = [];

    public static $userRoles = [];

    public static $userGroups = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        // 先初始化一个项目
        self::$project = BaseDataProvider::createProject();

        // 初始用户
        $info = [];
        self::$user = BaseDataProvider::createUser($info);
        for ($i = 0; $i < 10; $i++) {
            self::$users[] = BaseDataProvider::createUser($info);
        }

        // 给用户当前项目赋予角色
        $model = new ProjectRoleModel();
        self::$userRoles = $model->getsAll();
        $model = new ProjectUserRoleModel();
        foreach (self::$userRoles as $userRole) {
            $roleId = $userRole['id'];
            $model->insertRole(self::$user['uid'], self::$project['id'], $roleId);
        }

        // 用户加入用户组
        $model = new GroupModel();
        self::$userGroups = $model->getAll(false);
        foreach (self::$userGroups as $userGroup) {
            $groupId = $userGroup['id'];
            BaseDataProvider::createUserGroup(self::$user['uid'], $groupId);
        }
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        BaseDataProvider::deleteUser(self::$user['uid']);
        if (!empty(self::$users)) {
            foreach (self::$users as $user) {
                BaseDataProvider::deleteUser($user['uid']);
            }
        }
        BaseDataProvider::deleteProject(self::$project['id']);

        if (!empty(self::$users)) {
            foreach (self::$users as $user) {
                BaseDataProvider::deleteUser($user['uid']);
            }
        }
        if (!empty(self::$userRoles)) {
            foreach (self::$userRoles as $role) {
                BaseDataProvider::deleteUserProjectRole($role['id']);
            }
        }
        if (!empty(self::$userGroups)) {
            foreach (self::$userGroups as $ug) {
                BaseDataProvider::deleteUserGroup($ug['id']);
            }
        }
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/user');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }


    /**
     * @throws \Exception
     */
    public function testFilter()
    {
        // 分页为 20
        $uid = 0;
        $username = '';
        $groupId = 0;
        $status = '';
        $orderBy = 'uid';
        $sort = 'desc';
        $page = 1;
        $pageSize = 20;

        $reqInfo = [];
        $reqInfo['uid'] = $uid;
        $reqInfo['username'] = $username;
        $reqInfo['group_id'] = $groupId;
        $reqInfo['status'] = $status;
        $reqInfo['order_by'] = $orderBy;
        $reqInfo['sort'] = $sort;
        $reqInfo['page'] = $page;
        $reqInfo['page_size'] = $pageSize;

        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/add failed');
        $this->assertEquals('200', $respArr['ret']);
        $dataObj = $respArr['data'];
        $this->assertNotEmpty($dataObj['users']);
        $this->assertNotEmpty($dataObj['groups']);
        $this->assertNotEmpty($dataObj['total']);
        $this->assertNotEmpty($dataObj['pages']);
        $this->assertNotEmpty($dataObj['page_size']);
        $this->assertEquals($page, $dataObj['page']);

        // 指定用户id
        $reqInfo = [];
        $reqInfo['uid'] = self::$user['uid'];
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $dataObj = $respArr['data'];
        $this->assertNotEmpty($dataObj['users']);
        $this->assertCount(1, $dataObj['users']);

        // 指定用户名
        $reqInfo = [];
        $reqInfo['username'] = self::$user['username'];
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $dataObj = $respArr['data'];
        $this->assertNotEmpty($dataObj['users']);
        $this->assertCount(1, $dataObj['users']);

        // 指定用户组id
        $model = new GroupModel();
        $groupId = $model->getAll(false)[0]['id'];
        $reqInfo = [];
        $reqInfo['username'] = self::$user['username'];
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $dataObj = $respArr['data'];
        $this->assertNotEmpty($dataObj['users']);
        $users = $dataObj['users'];
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
        $info = [];
        $info['status'] = $status;
        self::$users[] = BaseDataProvider::createUser($info);
        $reqInfo = [];
        $reqInfo['status'] = $status;
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $dataObj = $respArr['data'];
        $this->assertNotEmpty($dataObj['users']);
        $users = $dataObj['users'];
        if (!empty($users)) {
            foreach ($users as $user) {
                $this->assertEquals($user['status'], $status);
            }
        }

        // 降序排序
        $orderBy = 'uid';
        $sort = 'asc';
        $reqInfo = [];
        $reqInfo['order_by'] = $orderBy;
        $reqInfo['sort'] = $sort;
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $dataObj = $respArr['data'];
        $this->assertNotEmpty($dataObj['users']);
        $users = $dataObj['users'];
        $first = current($users);
        $end = end($users);
        $orderWeight1 = parent::getArrItemOrderWeight($users, 'uid', $first['uid']);
        $orderWeight2 = parent::getArrItemOrderWeight($users, 'uid', $end['uid']);
        $this->assertTrue($orderWeight1 < $orderWeight2);

        // 分页到第二页
        $reqInfo = [];
        $reqInfo['page'] = 2;
        $reqInfo['page_size'] = 10;
        $curl->get(ROOT_URL . 'admin/user/filter', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertEquals(2, $respArr['data']['page']);
    }

    /**
     * 获取单个信息
     */
    public function testGet()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;
        $userId = $user['uid'];
        $curl->get(ROOT_URL . '/admin/user/get/' . $userId);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        $this->assertEquals($user['email'], $respData['email']);
        $this->assertEquals($user['display_name'], $respData['display_name']);
        $this->assertArrayNotHasKey('password', $respData);
    }

    public function testGets()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/admin/user/gets/');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']);
    }

    public function testUserGroup()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;
        $userId = $user['uid'];
        $curl->get(ROOT_URL . '/admin/user/userGroup/' . $userId);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        $this->assertNotEmpty($respData['user_groups']);
        $this->assertNotEmpty($respData['groups']);
    }

    public function testUpdateUserGroup()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;
        $reqInfo['uid'] = $user['uid'];
        $reqInfo['params']['groups'][] = 1;
        $reqInfo['params']['groups'][] = 2;
        $curl->get(ROOT_URL . '/admin/user/updateUserGroup/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }

    public function testAdd()
    {
        // 禁用新增
        $curl = BaseAppTestCase::$userCurl;
        $displayName = '190' . mt_rand(12345678, 92345678);
        $email = $displayName . '@masterlab.org';
        $password = '123456';

        $reqInfo = [];
        $reqInfo['params']['email'] = $email;
        $reqInfo['params']['username'] = $displayName;
        $reqInfo['params']['password'] = $password;
        $reqInfo['params']['display_name'] = $displayName;
        $reqInfo['params']['disable'] = true;

        $curl->post(ROOT_URL . 'admin/user/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $userModel = new UserModel();
        self::$users[] = $user = $userModel->getByEmail($email);
        $this->assertEquals(UserModel::STATUS_DISABLED, $user['status']);

        // 正常新增
        $displayName = '190' . mt_rand(100000, 900000);
        $email = $displayName . '@masterlab.org';
        $password = '123456';
        $reqInfo = [];
        $reqInfo['params']['email'] = $email;
        $reqInfo['params']['username'] = $displayName;
        $reqInfo['params']['password'] = $password;
        $reqInfo['params']['display_name'] = $displayName;
        $curl->post(ROOT_URL . 'admin/user/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $userModel = new UserModel();
        self::$users[] = $user = $userModel->getByEmail($email);
        $this->assertEquals(UserModel::STATUS_NORMAL, $user['status']);
    }

    public function testDisable()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;
        $userId = $user['uid'];
        $curl->get(ROOT_URL . '/admin/user/disable/' . $userId);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $user = UserModel::getInstance()->getByUid($userId);
        $this->assertEquals(UserModel::STATUS_DISABLED, $user['status']);
    }

    public function testUpdate()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;
        $reqInfo = [];
        $reqInfo['uid'] = $user['uid'];
        $reqInfo['params']['birthday'] = date('Y-m-d');
        $reqInfo['params']['display_name'] = 'updated_' . $user['display_name'];
        $curl->post(ROOT_URL . 'admin/user/update', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);

        $model = new UserModel();
        $fetchUser = $model->getByUid($user['uid']);
        $this->assertEquals($fetchUser['display_name'], $reqInfo['params']['display_name']);

        $reqInfo = [];
        $reqInfo['uid'] = $user['uid'];
        $reqInfo['params']['disable'] = '1';
        $reqInfo['params']['display_name'] = 'updated_' . $user['display_name'];
        $curl->post(ROOT_URL . 'admin/user/update', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $fetchUser = $model->getByUid($user['uid']);
        $this->assertEquals(UserModel::STATUS_DISABLED, $fetchUser['status']);
    }

    public function testBatch()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;

        $reqInfo = [];
        $reqInfo['checkbox_id'] = [];
        foreach (self::$users as $user) {
            $reqInfo['checkbox_id'][] = $user['uid'];
        }

        $curl->get(ROOT_URL . '/admin/user/batchDisable/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $users = UserModel::getInstance()->getUsersByIds($reqInfo['checkbox_id']);
        foreach ($users as $user) {
            $this->assertEquals(UserModel::STATUS_DISABLED, $user['status']);
        }

        $curl->get(ROOT_URL . '/admin/user/batchRecovery/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $users = UserModel::getInstance()->getUsersByIds($reqInfo['checkbox_id']);
        foreach ($users as $user) {
            $this->assertEquals(UserModel::STATUS_NORMAL, $user['status']);
        }
    }
}
