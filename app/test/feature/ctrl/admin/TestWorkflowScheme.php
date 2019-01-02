<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\WorkflowSchemeModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\WorkflowSchemeDataModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 * Class TestWorkflowScheme
 * @package main\app\test\featrue\ctrl\admin
 */
class TestWorkflowScheme extends BaseAppTestCase
{

    public static $workflow = [];

    public static $typeScheme = [];

    public static $typeSchemeDataIdArr = [];

    public static $addTypeScheme = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$workflow = BaseDataProvider::createWorkflow();

        self::$typeScheme = BaseDataProvider::createTypeScheme();
        $issueTypeModel = new IssueTypeModel();
        $model = new WorkflowSchemeDataModel();
        $info = [];
        $info['scheme_id'] = self::$typeScheme['id'];
        $info['issue_type_id'] = $issueTypeModel->getIdByKey('bug');
        $info['workflow_id'] = self::$workflow['id'];
        $model->insert($info);

        $info = [];
        $info['scheme_id'] = self::$typeScheme['id'];
        $info['issue_type_id'] = $issueTypeModel->getIdByKey('task');
        $info['workflow_id'] = self::$workflow['id'];
        $model->insert($info);
    }

    /**
     * 测试结束后执行此方法,清除测试数据
     */
    public static function tearDownAfterClass()
    {

        $model = new IssueTypeSchemeModel();
        $schemeDatamodel = new WorkflowSchemeDataModel();
        $issueTypeSchemeItemsModel = new IssueTypeSchemeItemsModel();
        if (!empty(self::$typeScheme)) {
            $model->deleteById(self::$typeScheme ['id']);
            $issueTypeSchemeItemsModel->deleteBySchemeId(self::$typeScheme ['id']);
            $schemeDatamodel->deleteBySchemeId(self::$typeScheme ['id']);
        }
        if (!empty(self::$addTypeScheme)) {
            $model->deleteById(self::$addTypeScheme ['id']);
            $issueTypeSchemeItemsModel->deleteBySchemeId(self::$addTypeScheme ['id']);
            $schemeDatamodel->deleteBySchemeId(self::$addTypeScheme ['id']);
        }

        BaseDataProvider::deleteWorkflow(self::$workflow['id']);
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/workflow_scheme');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/workflow_scheme/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['workflow_scheme']);
        $this->assertNotEmpty($respData['issue_types']);
        $this->assertNotEmpty($respData['workflow']);
    }

    public function testGet()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL.'admin/workflow_scheme/get/' . self::$typeScheme['id']);
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
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $json = [];
        $json[] = ['issue_type_id' => 1, 'workflow_id' => 1];
        $json[] = ['issue_type_id' => 2, 'workflow_id' => 2];
        $reqInfo['params']['issue_type_workflow'] = json_encode($json);
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/workflow_scheme/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new WorkflowSchemeModel();
        self::$addTypeScheme = $model->getByName($name);

        // testUpdate()
        $id = self::$addTypeScheme['id'];
        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $reqInfo = [];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $json = [];
        $json[] = ['issue_type_id' => 1, 'workflow_id' => 2];
        $json[] = ['issue_type_id' => 2, 'workflow_id' => 1];
        $reqInfo['params']['issue_type_workflow'] = json_encode($json);
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/workflow_scheme/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $model = new WorkflowSchemeModel();
        self::$addTypeScheme = $model->getRowById($id);
        $this->assertEquals($name, self::$addTypeScheme['name']);
        $this->assertEquals($description, self::$addTypeScheme['description']);

        // testDelete()
        $id = self::$addTypeScheme['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/workflow_scheme/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
