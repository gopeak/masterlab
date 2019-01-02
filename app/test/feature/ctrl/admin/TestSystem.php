<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\classes\SettingsLogic;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\permission\PermissionModel;
use main\app\model\SettingModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\permission\PermissionGlobalGroupModel;
use main\app\model\system\AnnouncementModel;
use main\app\model\system\MailQueueModel;
use main\app\model\user\GroupModel;
use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\DefaultRoleRelationModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 *  admin/system 测试类
 * @package main\app\test\logic
 */
class TestSystem extends BaseAppTestCase
{
    public static $project = [];

    public static $groupId = [];

    public static $userGroups = [];

    public static $userProjectRoles = [];

    public static $users = [];

    public static $addProjectRole = [];

    public static $permissionGroup = [];

    public static $roleId = '10001';

    public static $roleIdPerms = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        BaseAppTestCase::setUpBeforeClass();
        $model = new GroupModel();
        list($ret, $groupId) = $model->add('test-name-mail', '', true);
        if ($ret) {
            self::$groupId = $groupId;
        }
        $model = new DefaultRoleRelationModel();
        self::$roleIdPerms = $model->getPermIdsByRoleId(self::$roleId);
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$groupId)) {
            $model = new GroupModel();
            $model->deleteById(self::$groupId);
        }
        if (!empty(self::$userGroups)) {
            foreach (self::$userGroups as $item) {
                BaseDataProvider::deleteUserGroup($item['id']);
            }
        }
        if (!empty(self::$users)) {
            foreach (self::$users as $item) {
                BaseDataProvider::deleteUser($item['uid']);
            }
        }
        if (!empty(self::$project)) {
            BaseDataProvider::deleteProject(self::$project['id']);
        }
        if (!empty(self::$addProjectRole)) {
            $model = new ProjectRoleModel();
            $model->deleteById(self::$addProjectRole['id']);
        }

        if (!empty(self::$userProjectRoles)) {
            $model = new ProjectUserRoleModel();
            foreach (self::$userProjectRoles as $userProjectRole) {
                $model->deleteById($userProjectRole['id']);
            }
        }
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

    public function testBasicSettingEditPage()
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
        $maxLoginError = null;
        foreach ($respData['settings'] as $setting) {
            if ($setting['_key'] == 'max_login_error') {
                $maxLoginError = $setting['_value'];
            }
        }
        $this->assertNotNull($maxLoginError);

        // 更新
        $originValue = $maxLoginError;
        $updateValue = intval($originValue) + 1;
        $updateInfo = [];
        $updateInfo['params']['max_login_error'] = $updateValue;
        $curl->get(ROOT_URL . 'admin/system/basicSettingUpdate', $updateInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $setting = SettingModel::getInstance()->getSettingByKey('max_login_error');
        $this->assertEquals($updateValue, (int)$setting['_value']);

        // 恢复数据
        $model = new SettingModel();
        $ret = $model->updateSetting('max_login_error', $originValue);
        $this->assertTrue($ret);
    }

    public function testGlobalPermissionPage()
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
        $curl->get(ROOT_URL . 'admin/system/global_permission_fetch?format=json');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['items']);
        $this->assertNotEmpty($respData['groups']);
    }

    public function testGlobalPermissionGroupAddDelete()
    {
        $permId = mt_rand(10000, 99999);
        $groupId = mt_rand(10000, 99999);
        $reqInfo = [];
        $reqInfo['params']['perm_id'] = $permId;
        $reqInfo['params']['group_id'] = $groupId;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/global_permission_group_add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new PermissionGlobalGroupModel();
        self::$permissionGroup = $model->getByParentIdAndGroupId($permId, $groupId);

        $id = self::$permissionGroup['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermissionGroupDelete?id=' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }

    public function testPasswordStrategyPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testDatetimeSettingPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testAttachmentSettingPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testUiSettingPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testUserDefaultSettingPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testAnnouncementPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/globalPermission');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testAnnouncementRelease()
    {
        $model = new AnnouncementModel();
        $originRow = $model->getRowById(AnnouncementModel::ID);

        $reqInfo = [];
        $reqInfo['content'] = 'test-content';
        $reqInfo['expire_time'] = date("Y-m-d H:i:s", time() + 2);

        // 发布公告
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/announcementRelease', $reqInfo);
        parent::checkPageError($curl);
        //echo $curl->rawResponse;
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        // 取消发布
        $curl->post(ROOT_URL . 'admin/system/announcementDisable', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        // 还原
        $content = $originRow['content'];
        $expireTime = intval($reqInfo['expire_time']);
        $model = new AnnouncementModel();
        $info = [];
        $info['id'] = AnnouncementModel::ID;
        $info['content'] = $content;
        $info['expire_time'] = $expireTime;
        $info['status'] = $originRow['status'];
        $model->replace($info);
    }

    public function testTmtpConfigPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/smtpConfig');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testMailTest()
    {
        $this->assertTrue(true);
        if (APP_STATUS == 'travis') {
            return;
        }
        $reqInfo = [];
        $reqInfo['params']['title'] = 'test-title';
        $reqInfo['params']['content'] = 'test-content';
        $reqInfo['params']['mailto'] = '121642038@qq.com';
        $reqInfo['params']['recipients'] = '121642038@qq.com';
        $reqInfo['params']['content_type'] = 'html';

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/mailTest', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        if ($respArr['ret'] != '200') {
            echo $respArr['data']['err'];
        }
    }

    public function testEmailQueuePage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/emailQueue');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testMailQueueFetch()
    {
        $reqInfo = [];
        $reqInfo['page'] = 1;

        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/mailQueueFetch?page=1', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']);
        $this->assertArrayHasKey('queues', $respArr['data']);

        $reqInfo = [];
        $reqInfo['page'] = 1;
        $reqInfo['status'] = MailQueueModel::STATUS_DONE;
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/mailQueueFetch', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $this->assertNotEmpty($respArr['data']);
        $this->assertArrayHasKey('queues', $respArr['data']);
        foreach ($respArr['data']['queues'] as $item) {
            $this->assertEquals(MailQueueModel::STATUS_DONE, $item['status']);
        }
    }

    public function testEmailQueueErrorClear()
    {
        $model = MailQueueModel::getInstance();
        $info = [];
        $info['status'] = MailQueueModel::STATUS_ERROR;
        $info['title'] = 'test-title-error';
        $info['address'] = 'test-address';
        list($ret, $insertId) = $model->add($info);
        $this->assertTrue($ret);

        $curl = BaseAppTestCase::$userCurl;
        $curl->setTimeout(20);
        $curl->get(ROOT_URL . 'admin/system/emailQueueErrorClear');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $errorRow = $model->getRowById($insertId);
        $this->assertEmpty($errorRow);
    }

    public function testEmailSendMailPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/system/sendMail');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * 发送邮件
     * @throws \Exception
     */
    public function testSendMailPost()
    {
        $this->assertTrue(true);
        if (APP_STATUS == 'travis') {
            return;
        }
        $roleId = 1;
        $groupId = self::$groupId;
        self::$project = BaseDataProvider::createProject();
        $projectId = self::$project['id'];
        $info = [];
        for ($i = 0; $i < 2; $i++) {
            $info['email'] = mt_rand(100000, 999999) . $i . '@masterlab.org';
            self::$users[] = BaseDataProvider::createUser($info);
        }
        // 用户加入项目角色
        foreach (self::$users as $user) {
            self::$userProjectRoles[] = BaseDataProvider::createUserProjectRole($user['uid'], $projectId, $roleId);
        }
        // 用户加入用户组
        foreach (self::$users as $user) {
            self::$userGroups[] = BaseDataProvider::createUserGroup($user['uid'], $groupId);
        }

        $reqInfo = [];
        $reqInfo['params']['title'] = 'test-title';
        $reqInfo['params']['content'] = 'test-content';
        $reqInfo['params']['content_type'] = 'html';
        $reqInfo['params']['reply'] = '121642038@qq.com';
        $reqInfo['params']['send_to'] = 'project';
        $reqInfo['params']['to_project'] = [$projectId];
        $reqInfo['params']['to_role'] = [$roleId];

        // 发送给项目角色
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/sendMailPost', $reqInfo);
        // echo $curl->rawResponse;
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        if ($respArr['ret'] != '200') {
            echo $respArr['data']['err'];
            echo $respArr['data']['verbose'];
        }

        // 发送给用户组
        $reqInfo['params']['send_to'] = 'group';
        $reqInfo['params']['to_group'] = [$groupId];
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/system/sendMailPost', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        if ($respArr['ret'] != '200') {
            echo $respArr['data']['err'] . "\n";
            echo $respArr['data']['verbose'] . "\n";
        }
    }
}
