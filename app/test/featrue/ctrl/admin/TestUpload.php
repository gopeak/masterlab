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
 *  admin/Upload 测试类
 * @package main\app\test\logic
 */
class TestUpload extends BaseAppTestCase
{
    public static $project = [];

    public static $user = [];

    public static $users = [];

    public static $userRoles = [];

    public static $userGroups = [];


    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }


    /**
     * 测试页面
     */
    public function testUploadImg()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/user');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testUploadAvatar()
    {
        $userId = self::$user['uid'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/user/userProjectRole/' . $userId);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }


}
