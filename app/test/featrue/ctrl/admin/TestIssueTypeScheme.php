<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\ctrl\admin\IssueType;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

class TestIssueTypeScheme extends BaseAppTestCase
{

    public static $typeScheme = [];

    public static $addTypeScheme = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 测试结束后执行此方法,清除测试数据
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$addTypeScheme)) {
            $model = new IssueTypeSchemeModel();
            $model->getRowById(self::$addTypeScheme ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/IssueTypeScheme');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/IssueTypeScheme/FetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['IssueTypeSchemes']);
        $this->assertNotEmpty($respData['IssueTypeScheme_schemes']);
    }

    public function testGet()
    {
        self::$typeScheme = BaseDataProvider::createTypeScheme();

        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/IssueTypeScheme/get/' . self::$typeScheme['id']);
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
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $model = new IssueTypeModel();
        $issueTypes = $model->getAll(false);
        $forIssueTypesIds = [];
        foreach ($issueTypes as $row) {
            $forIssueTypesIds[] = $row['id'];
        }
        $reqInfo['params']['issue_types'] = $forIssueTypesIds;
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/IssueTypeScheme/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new IssueTypeSchemeModel();
        self::$addTypeScheme = $model->getByName($name);
    }

    public function testUpdate()
    {
        $id = self::$addTypeScheme['id'];

        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $reqInfo = [];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $reqInfo['params']['issue_types'] = [];

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/IssueTypeScheme/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $model = new IssueTypeSchemeModel();
        self::$addTypeScheme = $model->getRowById($id);
        $this->assertEquals($name, self::$addTypeScheme['name']);
        $this->assertEquals($description, self::$addTypeScheme['description']);
    }

    public function testDelete()
    {
        $id = self::$addTypeScheme['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/IssueTypeScheme/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
