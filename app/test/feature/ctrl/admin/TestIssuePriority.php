<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssuePriorityModel;
use main\app\test\BaseAppTestCase;

/**
 *
 * @version
 * @link
 */
class TestIssuePriority extends BaseAppTestCase
{

    public static $addPriority = [];

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
        if (!empty(self::$addPriority)) {
            $model = new IssuePriorityModel();
            $model->getRowById(self::$addPriority ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_priority');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_priority/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['rows']);
    }

    public function testGet()
    {
        $model = new IssuePriorityModel();
        $id = $model->getIdByKey('high');
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_priority/get/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testAddUpdateDelete()
    {
        $key = 'test-key-' . mt_rand(10000, 99999);
        $name = 'test-name-' . mt_rand(10000, 99999);
        $description = 'test-description';

        // 新增
        $reqInfo = [];
        $reqInfo['params']['key'] = $key;
        $reqInfo['params']['font_awesome'] = 'fa fa-home';
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_priority/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new IssuePriorityModel();
        self::$addPriority = $model->getByName($name);

        // 更新
        $id = self::$addPriority['id'];
        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $fontAwesome = 'fa fa-like';
        $key = 'test-key-' . mt_rand(10000, 99999);
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = $fontAwesome;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['key'] = $key;
        $reqInfo['params']['description'] = $description;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_priority/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $model = new IssuePriorityModel();
        self::$addPriority = $model->getRowById($id);
        $this->assertEquals($name, self::$addPriority['name']);
        $this->assertEquals($description, self::$addPriority['description']);
        $this->assertEquals($fontAwesome, self::$addPriority['font_awesome']);

        // 删除
        $id = self::$addPriority['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_priority/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
