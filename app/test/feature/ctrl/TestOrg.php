<?php

namespace main\app\test\featrue\ctrl;

use main\app\model\OrgModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

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

    public static $fileAttachment = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$org ['id'])) {
            BaseDataProvider::deleteOrg(self::$org ['id']);
        }

        if (!empty(self::$projects)) {
            foreach (self::$projects as $project) {
                $id = $project['id'];
                BaseDataProvider::deleteProject($id);
            }
        }
        if (!empty(self::$fileAttachment)) {
            foreach (self::$fileAttachment as $file) {
                $id = $file['id'];
                BaseDataProvider::deleteFileAttachment($id);
            }
        }

        if (!empty(self::$addOrg)) {
            BaseDataProvider::deleteOrg(self::$addOrg ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     * @throws \Exception
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'org/index');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testDetailPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $id = BaseAppTestCase::$org['id'];
        $url = ROOT_URL . 'org/detail/?id=' . $id;
        $curl->get($url);
        $resp = $curl->rawResponse;
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
    public function testCreatePage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'org/create');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="params\[name\]"/', $resp);
        $this->assertRegExp('/name="params\[path\]"/', $resp);
        $this->assertRegExp('/name="params\[description\]"/', $resp);
    }

    /**
     * @throws \Exception
     */
    public function testEditPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $id = BaseAppTestCase::$org['id'];
        $curl->get(ROOT_URL . 'org/edit/' . $id);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="params\[name\]"/', $resp);
        $this->assertRegExp('/name="params\[description\]"/', $resp);
    }

    /**
     * @throws \Exception
     */
    public function testFetchProjects()
    {
        $id = BaseAppTestCase::$org['id'];
        $info['org_id'] = $id;
        self::$projects[] = BaseDataProvider::createProject($info);
        self::$projects[] = BaseDataProvider::createProject($info);
        self::$projects[] = BaseDataProvider::createProject($info);

        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'org/fetchProjects/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/fetchProjects failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    /**
     * @throws \Exception
     */
    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'org/FetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/fetchAll failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    /**
     * @throws \Exception
     */
    public function testGet()
    {
        $id = BaseAppTestCase::$org['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'org/get/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/get failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    /**
     * @throws \Exception
     */
    public function testAdd()
    {
        $path = 'testpath' . mt_rand(10000, 99999);
        $name = $path;
        $reqInfo = [];
        $reqInfo['params']['path'] = $path;
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = 'test-description';
        list($uploadJson, $fileRow) = BaseDataProvider::createFineUploaderJson();
        $reqInfo['params']['fine_uploader_json'] = $uploadJson;
        self::$fileAttachment[] = $fileRow;

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'org/add', $reqInfo);
        //echo $curl->rawResponse;
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
        list($uploadJson, $fileRow) = BaseDataProvider::createFineUploaderJson();
        $reqInfo['params']['fine_uploader_json'] = $uploadJson;
        self::$fileAttachment[] = $fileRow;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'org/update/' . $id, $reqInfo);
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
        $curl->get(ROOT_URL . 'org/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
