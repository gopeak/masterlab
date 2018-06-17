<?php

namespace main\app\test\featrue;

use main\app\model\OrgModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;
use main\app\test\data\LogDataProvider;

/**
 * 组织控制器测试类
 * @version
 * @link
 */
class TestOrg extends BaseAppTestCase
{
    public static $clean = [];

    public static $org = [];

    public static $projects = [];

    public static $addOrg = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 测试结束后执行此方法,清除测试数据
     */
    public static function tearDownAfterClass()
    {
        BaseDataProvider::deleteOrg(self::$org ['id']);
        if (!empty(self::$projects)) {
            foreach (self::$projects as $project) {
                $id = $project['id'];
                BaseDataProvider::deleteProject($id);
            }
        }
        if (!empty(self::$addOrg)) {
            BaseDataProvider::deleteOrg(self::$addOrg ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$noLoginCurl;
        $curl->get(ROOT_URL . '/org/index');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testDetailPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $id = BaseAppTestCase::$org['id'];
        $curl->get(ROOT_URL . '/org/detail/' . $id);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testCreatePage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/org/create/');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="params[name]"/', $resp);
        $this->assertRegExp('/name="params[path]"/', $resp);
        $this->assertRegExp('/name="params[description]"/', $resp);
    }

    public function testEditPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $id = BaseAppTestCase::$org['id'];
        $curl->get(ROOT_URL . '/org/edit/' . $id);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="params[name]"/', $resp);
        $this->assertRegExp('/name="params[description]"/', $resp);
    }

    public function testFetchProjects()
    {
        $id = BaseAppTestCase::$org['id'];
        $info['origin_id'] = $id;
        self::$projects[] = BaseDataProvider::createProject($info);
        self::$projects[] = BaseDataProvider::createProject($info);
        self::$projects[] = BaseDataProvider::createProject($info);

        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . '/org/fetchProjects/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/fetchProjects failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('/org/FetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/fetchAll failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testGet()
    {
        $id = BaseAppTestCase::$org['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('/org/get/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/get failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testAdd()
    {
        $path = 'test-path-' . mt_rand(10000, 99999);
        $name = $path;
        $reqInfo = [];
        $reqInfo['params']['path'] = $path;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = 'test-description';
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'org/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/add failed');
        $this->assertEquals('200', $respArr['ret']);
        $orgModel = new OrgModel();
        self::$addOrg = $orgModel->getByPath($path);
    }

    public function testUpdate()
    {
        $id = self::$addOrg['id'];
        $name = 'updated-name';
        $description = 'updated-description';
        $reqInfo = [];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        //$reqInfo['params']['fine_uploader_json'] = '[{"name":"wKgBEFpVtuWAcsYIAA1uGbceyuY11 (1).jpeg","originalName":"wKgBEFpVtuWAcsYIAA1uGbceyuY11 (1).jpeg","uuid":"d1901335-3348-459e-a29e-09460f60820f","size":880153,"status":"upload successful","file":{"qqButtonId":"3607e1bb-14c3-4802-b165-f5261a60b2c6","qqThumbnailId":0},"batchId":"e3197434-dec5-496e-99fc-6b4a98e5d3f0","id":0}]';
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'org/update/'.$id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $orgModel = new OrgModel();
        self::$addOrg = $orgModel->getById($id);
        $this->assertEquals($name, self::$addOrg['name']);
        $this->assertEquals($description, self::$addOrg['description']);
    }

    public function testDelete()
    {
        $id = self::$addOrg['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'org/delete/'.$id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
