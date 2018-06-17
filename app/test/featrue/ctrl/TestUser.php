<?php

namespace main\app\test\featrue;

use main\app\classes\UserAuth;
use main\app\model\user\UserModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;
use main\app\model\user\UserTokenModel;

/**
 *
 * @version
 * @link
 */
class TestPassport extends BaseAppTestCase
{
    public static $clean = [];



    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 测试结束后执行此方法
     */
    public static function tearDownAfterClass()
    {
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
        $this->assertRegExp('/name="user[display_name]"/', $resp);
    }

    public function testPassword()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/user/password');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="user[display_name]"/', $resp);
    }

    public function testNotifications()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/user/notifications');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="user[display_name]"/', $resp);
    }

    public function testGet()
    {
        // 通过登录状态获取
        $curl = BaseAppTestCase::$userCurl;
        $user = BaseAppTestCase::$user;
        $curl->get(ROOT_URL . '/user/get');
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
        $curl->get(ROOT_URL . '/user/get?token='.$token);
        parent::checkPageError($curl);
        $respArr2 = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr2, 'user/get by token failed');
        $this->assertEquals($respArr, $respArr2);

        // 通过openid获取
        $curl->get(ROOT_URL . '/user/get?openid='.$user['openid']);
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
        $reqInfo['params']['display_name'] ='updated_'. $user['display_name'];
        $imageFile = PUBLIC_PATH.'/dev/img/default_avatar.png';
        $imageFnfo = getimagesize($imageFile);
        $base64ImageContent = "data:{$imageFnfo['mime']};base64," . chunk_split(base64_encode(file_get_contents($imageFile)));
        $reqInfo['params']['image'] = $base64ImageContent;
        $curl->post(ROOT_URL . 'user/setProfile', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);

        $model = new UserModel();
        $fetchUser = $model->getByUid($user['uid']);
        $this->assertEquals($fetchUser['display_name'], $reqInfo['params']['display_name']);
        $this->assertEquals($fetchUser['birthday'], $reqInfo['params']['birthday']);
        $this->assertNotEmpty($fetchUser['avatar']);
    }

    public function testSelectFilter()
    {
    }

    public function testSetNewPassword()
    {
        $curl = BaseAppTestCase::$userCurl;
        $user = BaseAppTestCase::$user;
        $newPassword = 'new_123456';
        $reqInfo = [];
        $reqInfo['params']['origin_pass'] = BaseAppTestCase::$userPassword;
        $reqInfo['params']['new_password'] = $newPassword;
        $curl->post(ROOT_URL . 'user/setNewPassword', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);

        $model = new UserModel();
        $fetchUser = $model->getByUid($user['uid']);
        $this->assertEquals($fetchUser['password'], UserAuth::createPassword($newPassword));

        $curl = new \Curl\Curl();
        $loginInfo = [];
        $loginInfo['email'] = $user['email'];
        $loginInfo['password'] = $newPassword;
        $curl->post(ROOT_URL . 'passport/do_login', $loginInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'user/setNewPassword failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertEquals(UserModel::LOGIN_CODE_OK, $respData['code']);
    }
}
