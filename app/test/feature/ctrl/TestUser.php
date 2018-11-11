<?php

namespace main\app\test\featrue;

use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;
use main\app\test\BaseAppTestCase;
use main\app\model\user\UserTokenModel;
use \Curl\Curl;

/**
 *
 * @version
 * @link
 */
class TestUser extends BaseAppTestCase
{
    public static $clean = [];

    public static $users = [];

    public static $projects = [];

    public static $projectRoleIdArr = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     *  测试完毕后执行此方法
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        $projectUserRoleModel = new  ProjectUserRoleModel();
        $projectRoleModel = new ProjectRoleModel();
        foreach (self::$users as $user) {
            if (isset($user['uid'])) {
                BaseDataProvider::deleteUser($user ['uid']);
                $projectUserRoleModel->delete(['user_id'=>$user ['uid']]);
            }
        }

        foreach (self::$projects as $project) {
            BaseDataProvider::deleteProject($project ['id']);
        }

        foreach (self::$projectRoleIdArr as $roleId) {
            $projectRoleModel->deleteById($roleId);
        }
        parent::tearDownAfterClass();
    }

    public function testProfile()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/user/profile');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/<div\s+class="cover-title">[^<]+<\/div>/', $resp);
    }

    public function testProfileEdit()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/user/profile_edit');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="params\[display_name\]"/', $resp);
    }

    public function testPassword()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/user/password');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="params\[new_password\]"/', $resp);
    }

    public function testNotifications()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/user/notifications');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testGet()
    {
        // 通过登录状态获取
        $curl = BaseAppTestCase::$userCurl;
        $user = BaseAppTestCase::$user;
        $curl->get(ROOT_URL . '/user/get?data_type=json');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'passport login failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['user']);
        $this->assertEquals($user['email'], $respData['user']['email']);
        $this->assertEquals($user['display_name'], $respData['user']['display_name']);
        $this->assertArrayNotHasKey('password', $respData['user']);

        // 通过token获取
        $model = new UserTokenModel($user['uid']);
        $token = $model->getUserToken($user['uid'])['token'];
        $curl->get(ROOT_URL . '/user/get?token=' . $token);
        parent::checkPageError($curl);
        $respArr2 = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr2, 'user/get by token failed');
        $this->assertEquals($respArr, $respArr2);

        // 通过openid获取
        $curl->get(ROOT_URL . '/user/get?openid=' . $user['openid']);
        parent::checkPageError($curl);
        $respArr3 = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr3, 'user/get by openid failed');
        $this->assertEquals($respArr, $respArr3);
    }

    public function testSetProfile()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = BaseAppTestCase::$user;
        $reqInfo = [];
        $reqInfo['params']['birthday'] = date('Y-m-d');
        $reqInfo['params']['display_name'] = 'updated_' . $user['display_name'];
        $imageFile = PUBLIC_PATH . '/dev/img/default_avatar.png';
        $imageFnfo = getimagesize($imageFile);
        $base64ImageContent = "data:{$imageFnfo['mime']};base64," . chunk_split(base64_encode(file_get_contents($imageFile)));
        $reqInfo['image'] = $base64ImageContent;
        $curl->post(ROOT_URL . 'user/setProfile', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);

        $model = new UserModel();
        $fetchUser = $model->getByUid($user['uid']);
        $this->assertEquals($fetchUser['display_name'], $reqInfo['params']['display_name']);
        $this->assertEquals($fetchUser['birthday'], $reqInfo['params']['birthday']);
        $this->assertNotEmpty($fetchUser['avatar']);
        if(strpos($fetchUser['avatar'],'?')!==false){
            list($fetchUser['avatar']) = explode('?',$fetchUser['avatar']);
        }
        $this->assertTrue(unlink(STORAGE_PATH . 'attachment/' . $fetchUser['avatar']));
    }

    public function testSelectFilter()
    {
        $abc = true;
        $this->assertTrue($abc);
    }

    /**
     * 测试修改密码
     * @throws \Exception
     */
    public function testSetNewPassword()
    {
        // 构建一个登录的curl
        $username = '190' . mt_rand(12345678, 92345678);
        $originPassword = '123456';
        $info['email'] = $username . '@masterlab.org';
        $info['username'] = $info['email'];
        $info['password'] = UserAuth::createPassword($originPassword);
        self::$users[] = $user = BaseDataProvider::createUser($info);
        // 登录成为授权用户
        $loginData = [];
        $loginData['username'] = $info['email'];
        $loginData['password'] = $originPassword;
        $curl = new Curl();
        $curl->setCookieFile(TEST_LOG . '/testSetNewPassword.txt');
        $curl->post(ROOT_URL . 'passport/do_login?data_type=json', $loginData);
        $respData = json_decode(self::$userCurl->rawResponse, true);
        if (!$respData) {
            $this->fail('login failed');
            return;
        }

        $newPassword = 'new_123456';
        $reqInfo = [];
        $reqInfo['params']['origin_pass'] = $originPassword;
        $reqInfo['params']['new_password'] = $newPassword;
        $curl->post(ROOT_URL . 'user/setNewPassword', $reqInfo);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);

        $curl = new Curl();
        $loginInfo = [];
        $loginInfo['username'] = $user['email'];
        $loginInfo['password'] = $newPassword;
        $curl->post(ROOT_URL . 'passport/do_login', $loginInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'user/setNewPassword failed');

        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertEquals(UserModel::LOGIN_CODE_OK, $respData['code']);
    }


    /**
     * 测试我参加的项目
     * @throws \Exception
     */
    public function testFetchUserHaveJoinProjects()
    {
        // 1.构建新用户并且登录
        $username = '190' . mt_rand(12345678, 92345678);
        $originPassword = '123456';
        $info['email'] = $username . '@masterlab.org';
        $info['username'] = $info['email'];
        $info['password'] = UserAuth::createPassword($originPassword);
        self::$users[] = $user = BaseDataProvider::createUser($info);
        // 登录成为授权用户
        $loginData = [];
        $loginData['username'] = $info['email'];
        $loginData['password'] = $originPassword;
        $curl = new Curl();
        $curl->setCookieFile(TEST_LOG . '/testFetchUserHaveJoinProjects.txt');
        $curl->post(ROOT_URL . 'passport/do_login', $loginData);
        $respData = json_decode(self::$userCurl->rawResponse, true);
        if (!$respData) {
            $this->fail('login failed');
            return;
        }

        // 2.创建多个项目及相关角色,让当前用户加入角色
        $initProjectCount = 5;
        for ($i = 0; $i < $initProjectCount; $i++) {
            self::$projects[] = BaseDataProvider::createProject();
        }
        $projectRoleModel = new ProjectRoleModel();
        $projectUserRoleModel = new  ProjectUserRoleModel();
        foreach (self::$projects as &$project) {
            $info = [];
            $info['project_id'] = $project['id'];
            $info['name'] = 'testRoleName';
            list($ret, $roleId) = $projectRoleModel->insert($info);
            $this->assertTrue($ret);
            if ($ret) {
                self::$projectRoleIdArr[] = $roleId;
            }
            $info = [];
            $info['project_id'] = $project['id'];
            $info['role_id'] = $roleId;
            $info['user_id'] = $user['uid'];
            $projectUserRoleModel->insert($info);
        }
        // print_r(self::$projectRoleIdArr);
        // 3.获取列表,校验
        $curl->get(ROOT_URL . 'user/fetchUserHaveJoinProjects');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        // echo $curl->rawResponse;
        $this->assertNotEmpty($respArr, 'user/fetchUserHaveJoinProjects failed');

        $this->assertEquals('200', $respArr['ret']);
        $projects = $respArr['data']['projects'];
        $this->assertCount($initProjectCount, $projects);
    }
}
