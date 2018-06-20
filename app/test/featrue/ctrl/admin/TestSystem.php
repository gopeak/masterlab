<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\SettingModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\PermissionGlobalGroupModel;
use main\app\model\user\GroupModel;
use main\app\model\user\UserModel;
use main\app\classes\UserLogic;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 *  admin/system 测试类
 * @package main\app\test\logic
 */
class TestSystem extends BaseAppTestCase
{
    public static $fileAttachmentIdArr = [];

    public static $addProjectRole = [];

    public static $permissionGroup = [];

    public static function setUpBeforeClass()
    {
        BaseAppTestCase::setUpBeforeClass();
    }

    public static function tearDownAfterClass()
    {

        BaseAppTestCase::tearDownAfterClass();
    }

    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/index');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testBasicSettingEdit()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/basicSettingEdit');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testSettingFetchAndUpdate()
    {
        $curl = BaseAppTestCase::$userCurl;
        // 默认空的情况
        $curl->get(ROOT_URL . 'admin/system/settingFetch');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['settings']);
        $this->assertNotEmpty($respData['settings']['max_login_error']);
        // 更新
        $originValue = $respData['settings']['max_login_error'];
        $updateValue = intval($originValue) + 1;
        $updateInfo = [];
        $updateInfo['params']['max_login_error'] = $updateValue;
        $curl->get(ROOT_URL . 'admin/system/basicSettingUpdate', $updateInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        // basic
        $reqInfo = [];
        $reqInfo['module'] = 'basic';
        $curl->get(ROOT_URL . 'admin/system/settingFetch', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['settings']);
        $this->assertNotEmpty($respData['settings']['max_login_error']);
        $afterValue = (int)$respData['settings']['max_login_error'];
        $this->assertEquals($updateValue, $afterValue);

        $model = new SettingModel();
        $ret = $model->updateSetting('max_login_error', $originValue);
        $this->assertTrue($ret);
    }

    public function testSecurityPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/security');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testProjectRolePage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/project_role');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testProjectRoleFetch()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/issue_ui/projectRoleFetch');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['roles']);
    }

    public function testProjectRoleAdd()
    {
        $name = 'test-name-' . mt_rand(10000, 99999);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/projectRoleAdd', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new ProjectRoleModel();
        self::$addProjectRole = $model->getByName($name);
    }

    public function testProjectRoleDelete()
    {
        $id = self::$addProjectRole['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/projectRoleDelete?id=' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }

    public function testGlobalPermission()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testGlobalPermissionFetch()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/issue_ui/globalPermissionFetch');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['items']);
        $this->assertNotEmpty($respData['groups']);
    }

    public function testGlobalPermissionGroupAdd()
    {
        $permId = mt_rand(10000, 99999);
        $groupId = mt_rand(10000, 99999);
        $reqInfo = [];
        $reqInfo['params']['perm_id'] = $permId;
        $reqInfo['params']['group_id'] = $groupId;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/globalPermissionGroupAdd', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new PermissionGlobalGroupModel();
        self::$permissionGroup = $model->getByParentIdAndGroupId($permId, $groupId);
    }
    public function testGlobalPermissionGroupDelete()
    {
        $id = self::$permissionGroup['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermissionGroupDelete?id=' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }

    public function testPasswordStrategy()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testDatetimeSetting()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testAttachmentSetting()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testUiSetting()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testUserDefaultSetting()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testAnnouncement()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

}
