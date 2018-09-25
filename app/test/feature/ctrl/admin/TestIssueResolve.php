<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssueResolveModel;
use main\app\test\BaseAppTestCase;

/**
 *
 * @version
 * @link
 */
class TestIssueResolve extends BaseAppTestCase
{

    public static $addResolve = [];

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
        if (!empty(self::$addResolve)) {
            $model = new IssueResolveModel();
            $model->deleteById(self::$addResolve ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_resolve');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_resolve/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['issue_resolve']);
    }

    public function testGet()
    {
        $model = new IssueResolveModel();
        $id = $model->getIdByKey('done');
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/issue_resolve/get/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testAddUpdateDelete()
    {
        // 新增
        $name = 'test-name-' . mt_rand(10000, 99999);
        $key = 'test-key-' . mt_rand(10000, 99999);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = 'fa fa-home';
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['key'] = $key;
        $reqInfo['params']['description'] = $description;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_resolve/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new IssueResolveModel();
        self::$addResolve = $model->getByName($name);

        // 更新
        $id = self::$addResolve['id'];
        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $fontAwesome = 'fa fa-like';
        $reqInfo = [];
        $reqInfo['params']['font_awesome'] = $fontAwesome;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_resolve/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $model = new IssueResolveModel();
        self::$addResolve = $model->getRowById($id);
        $this->assertEquals($name, self::$addResolve['name']);
        $this->assertEquals($description, self::$addResolve['description']);
        $this->assertEquals($fontAwesome, self::$addResolve['font_awesome']);

        // 删除
        $id = self::$addResolve['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_resolve/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
