<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\project\ProjectRoleModel;
use main\app\model\user\GroupModel;
use main\app\model\user\UserModel;
use main\app\model\system\OrgModel;
use main\app\classes\UserLogic;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

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
        self::$project = BaseDataProvider::createProject();

        // 初始用户
        $info = [];
        self::$user = BaseDataProvider::createUser($info);
        for ($i = 0; $i < 10; $i++) {
            self::$users[] = BaseDataProvider::createUser($info);
        }

        // 给用户当前项目赋予角色
        $model = new ProjectRoleModel();
        self::$userRoles = $model->getAll();
        foreach (self::$userRoles as $userRole) {
            $roleId = $userRole['id'];
            BaseDataProvider::createUserProjectRole(self::$user['uid'], self::$project['id'], $roleId);
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

    public function testUserProjectRolePage()
    {
        $userId = self::$user['uid'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/user/userProjectRole/' . $userId);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testUserProjectRoleFetch()
    {
        $userId = self::$user['uid'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/user/userProjectRoleFetch/' . $userId);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['userProjectRolesIds']);
        $this->assertNotEmpty($respData['projects']);
        $this->assertNotEmpty($respData['roles']);
    }


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
                $this->assertEquals($user['status'], $status);
            }
        }

        // 降序排序
        $status = UserModel::STATUS_NORMAL;
        $orderBy = 'uid';
        $sort = 'asc';
        $reqInfo = [];
        $reqInfo['status'] = $status;
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

    public function testPermission()
    {
        $userId = self::$user['uid'];
        $reqInfo = [];
        $reqInfo['uid'] = $userId;
        $reqInfo['project_id'] = self::$project['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/user/permission/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['permissions']);
    }

    public function testProjectRoles()
    {
        $userId = self::$user['uid'];
        $reqInfo = [];
        $reqInfo['uid'] = $userId;
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/user/projectRoles/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['project_roles']);
    }

    public function testUpdateUserProjectRole()
    {
        $userId = self::$user['uid'];
        $reqInfo = [];
        $reqInfo['uid'] = $userId;
        $reqInfo['params'][self::$project['id'] . '@1'] = '1';
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/user/updateUserProjectRole/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }

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

    public function testUpdateUserGroup($params)
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = self::$user;
        $reqInfo['uid'] = $user['uid'];
        $reqInfop['groups'][] = 1;
        $reqInfop['groups'][] = 2;
        $curl->get(ROOT_URL . '/admin/user/updateUserGroup/', $reqInfop);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }

    public function testAdd()
    {
        $curl = BaseAppTestCase::$userCurl;
        $displayName = '190' . mt_rand(12345678, 92345678);
        $email = $displayName . '@masterlab.org';
        $password = '123456';
        $regInfo['email'] = $email;
        $regInfo['password'] = $password;
        $regInfo['display_name'] = $displayName;
        $curl->post(ROOT_URL . 'passport/register', $regInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
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
