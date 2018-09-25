<?php

namespace main\app\test\featrue\ctrl;

use main\app\classes\ProjectLogic;
use main\app\model\OrgModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

/**
 * 项目控制器测试类
 * @version
 * @link
 */
class TestProjects extends BaseAppTestCase
{
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
        parent::tearDownAfterClass();
    }

    public function testPageIndex()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'projects');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $targetURI = 'projects/fetch_all';
        $curl = BaseAppTestCase::$userCurl;

        $curl->get(ROOT_URL . $targetURI);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $respArr = json_decode($resp, true);
        $this->assertNotEmpty($respArr, "{$targetURI} fail.");
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);

        $curl->get(ROOT_URL . $targetURI . '?typeId=' . ProjectLogic::PROJECT_TYPE_SCRUM);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $respArr = json_decode($resp, true);
        $this->assertNotEmpty($respArr, "{$targetURI}?typeId={ProjectLogic::PROJECT_TYPE_SCRUM} fail.");
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);

        $errTypeId = 999;
        $curl->get(ROOT_URL . $targetURI . '?typeId=' . $errTypeId);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $respArr = json_decode($resp, true);
        $this->assertNotEmpty($respArr, "{$targetURI}?typeId={$errTypeId} fail.");
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        $this->assertTrue(isset($respData['projects']));
        $this->assertEmpty($respData['projects']);
    }

    public function testUpload()
    {
        $this->markTestIncomplete('TODO: '.__METHOD__);
    }
}
