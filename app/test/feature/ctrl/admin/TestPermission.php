<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\permission\PermissionModel;
use main\app\model\permission\DefaultRoleModel;
use main\app\model\permission\DefaultRoleRelationModel;
use main\app\test\BaseAppTestCase;

/**
 * Class TestPermission
 * @package main\app\test\featrue\ctrl\admin
 */
class TestPermission extends BaseAppTestCase
{

    public static $addRole = [];

    public static $roleId = '';

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 测试结束后执行此方法,清除测试数据
     */
    public static function tearDownAfterClass()
    {
        $model = new DefaultRoleModel();
        if (!empty(self::$addRole)) {
            $model->deleteById(self::$addRole ['id']);
        }
        if (!empty(self::$roleId)) {
            $model->deleteById(self::$roleId);
            $model = new DefaultRoleRelationModel();
            $model->deleteByRoleId(self::$roleId);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/permission/default_role');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/默认角色/', $resp);
    }

    public function testFetch()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/permission/roleFetch');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['roles']);
        $roleArr = $respData['roles'];

        $role = current($roleArr);
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/permission/roleGet/' . $role['id']);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testDefaultRoleUpdatePermission()
    {
        // 1.创建一个测试的默认角色
        $info = [];
        $info['name'] = 'test-name-' . mt_rand(100000, 9999999);
        $info['description'] = 'test-description';
        $model = new DefaultRoleModel();
        list($ret, $insertId) = $model->insertItem($info);
        if (!$ret) {
            $this->fail('创建test默认角色失败');
            return;
        }

        // 2.编辑权限
        $model = new PermissionModel();
        $all = $model->getAll(true);
        $permissionArr = array_keys($all);
        self::$roleId = $insertId;
        $reqInfo = [];
        $reqInfo['roleId'] = self::$roleId;
        $reqInfo['format'] = 'json';
        $reqInfo['permissionIds'] = implode(',', $permissionArr);
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/permission/role_edit', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        // 3.获取树形结构
        $reqInfo = [];
        $reqInfo['roleId'] = self::$roleId;
        $reqInfo['format'] = 'json';
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/permission/tree', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertCount(count($permissionArr), $respArr);
    }
}
