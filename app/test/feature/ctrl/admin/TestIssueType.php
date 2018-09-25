<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssueTypeModel;
use main\app\test\BaseAppTestCase;

class TestIssueType extends BaseAppTestCase
{

    public static $addType = [];

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
        if (!empty(self::$addType)) {
            $model = new IssueTypeModel();
            $model->getRowById(self::$addType ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_type');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_type/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['issue_types']);
        $this->assertNotEmpty($respData['issue_type_schemes']);
    }

    public function testGet()
    {
        $model = new IssueTypeModel();
        $id = $model->getIdByKey('task');
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_type/get/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testAdd()
    {
        $name = 'test-name-' . mt_rand(10000, 99999);
        $key = 'test-key-' . mt_rand(10000, 99999);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = 'fa fa-home';
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['key'] = $key;
        $reqInfo['params']['description'] = $description;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_type/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new IssueTypeModel();
        self::$addType = $model->getByName($name);
    }

    public function testUpdate()
    {
        $id = self::$addType['id'];

        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $fontAwesome = 'fa fa-like';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = $fontAwesome;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_type/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $model = new IssueTypeModel();
        self::$addType = $model->getRowById($id);
        $this->assertEquals($name, self::$addType['name']);
        $this->assertEquals($description, self::$addType['description']);
        $this->assertEquals($fontAwesome, self::$addType['font_awesome']);
    }

    public function testDelete()
    {
        $id = self::$addType['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_type/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
