<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssueStatusModel;
use main\app\test\BaseAppTestCase;

/**
 *
 * @version
 * @link
 */
class TestIssueStatus extends BaseAppTestCase
{

    public static $addStatus = [];

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
        if (!empty(self::$addStatus)) {
            $model = new IssueStatusModel();
            $model->deleteById(self::$addStatus ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_status');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_status/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['issue_status']);
    }

    public function testGet()
    {
        $model = new IssueStatusModel();
        $id = $model->getIdByKey('open');
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_status/get/' . $id);
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
        $key = 'test-key-' . mt_rand(10000, 99999);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = 'fa fa-home';
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['key'] = $key;
        $reqInfo['params']['description'] = $description;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_status/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new IssueStatusModel();
        self::$addStatus = $model->getByName($name);

        // udpate
        $id = self::$addStatus['id'];
        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $fontAwesome = 'fa fa-like';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = $fontAwesome;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_status/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $model = new IssueStatusModel();
        self::$addStatus = $model->getRowById($id);
        $this->assertEquals($name, self::$addStatus['name']);
        $this->assertEquals($description, self::$addStatus['description']);
        $this->assertEquals($fontAwesome, self::$addStatus['font_awesome']);

        //  delete
        $id = self::$addStatus['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_status/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
