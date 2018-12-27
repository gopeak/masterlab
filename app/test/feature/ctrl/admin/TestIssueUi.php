<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueUiModel;
use main\app\model\issue\IssueUiTabModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 * TestIssueUi
 */
class TestIssueUi extends BaseAppTestCase
{

    public static $addIssueUiArr = [];

    public static $addIssueType = [];

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
        if (!empty(self::$addIssueUiArr)) {
            $model = new IssueStatusModel();
            foreach (self::$addIssueUiArr as $id) {
                $model->deleteById($id);
            }
        }
        if (!empty(self::$addIssueType)) {
            $model = new IssueTypeModel();
            $model->deleteItem(self::$addIssueType['id']);

            $model = new IssueUiModel();
            $conditions = [];
            $conditions['issue_type_id'] = self::$addIssueType['id'];
            $model->delete($conditions);

            $model = new IssueUiTabModel();
            $conditions = [];
            $conditions['issue_type_id'] = self::$addIssueType['id'];
            $model->delete($conditions);
        }


        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_ui');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_ui/fetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['issue_types']);
    }

    public function testGet()
    {
        $model = new IssueTypeModel();
        $id = $model->getIdByKey('bug');
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_ui/get/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testGetUiConfig()
    {
        $model = new IssueTypeModel();
        $issueTypeId = $model->getIdByKey('bug');
        $type = 'create';
        $reqInfo = [];
        $reqInfo['issue_type_id'] = $issueTypeId;
        $reqInfo['type'] = $type;
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/issue_ui/getUiConfig/', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        $this->assertNotEmpty($respData['configs']);
        $this->assertNotEmpty($respData['fields']);
        $this->assertNotEmpty($respData['field_types']);
        $this->assertNotEmpty($respData['tabs']);
    }

    public function testSaveUiConfig()
    {
        self::$addIssueType = BaseDataProvider::createIssueType();
        $issueTypeId = self::$addIssueType['id'];
        $type = 'create';
        $tabName = 'test-name-' . mt_rand(10000, 99999);
        $tabModel = new IssueUiTabModel();
        list($ret, $tabId) = $tabModel->add($issueTypeId, 0, $tabName, $type);
        if (!$ret) {
            $this->fail('IssueUiTabModel add failed');
        }
        $reqInfo = [];
        $reqInfo['issue_type_id'] = self::$addIssueType['id'];
        $reqInfo['type'] = $type;
        $reqInfo['data'] = json_encode([$tabId => ['fields' => [1, 2, 3], 'display' => $tabName]]);
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/issue_ui/saveCreateConfig', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
