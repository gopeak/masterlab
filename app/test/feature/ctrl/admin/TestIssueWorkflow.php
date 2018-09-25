<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\WorkflowModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

class TestIssueWorkflow extends BaseAppTestCase
{

    public static $workflow = [];

    public static $addWorkflow = [];

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
        if (!empty(self::$addWorkflow)) {
            $model = new WorkflowModel();
            $model->getRowById(self::$addWorkflow ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/workflow');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/workflow/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['workflow']);
        $this->assertNotEmpty($respData['workflow_schemes']);
    }

    public function testGet()
    {
        // 1. 新增测试需要的数据
        self::$workflow = BaseDataProvider::createWorkflow();
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/workflow/get/' . self::$workflow['id']);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testAddUpdateDelete()
    {
        $name = 'test-name-' . mt_rand(10000, 99999);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['is_system'] = '0';
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['data'] = '{}';
        $reqInfo['params']['description'] = $description;
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/workflow/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new WorkflowModel();
        self::$addWorkflow = $model->getByName($name);

        // update
        $id = self::$addWorkflow['id'];
        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $fontAwesome = 'fa fa-like';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = $fontAwesome;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/workflow/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new WorkflowModel();
        self::$addWorkflow = $model->getRowById($id);
        $this->assertEquals($name, self::$addWorkflow['name']);
        $this->assertEquals($description, self::$addWorkflow['description']);

        // delete
        $id = self::$addWorkflow['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/workflow/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
