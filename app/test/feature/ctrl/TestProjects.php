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
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    /**
     * @throws \Exception
     */
    public function testPageIndex()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'projects');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * @throws \Exception
     */
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

    /**
     * @throws \Exception
     */
    public function testUpload()
    {
        $curl = BaseAppTestCase::$userCurl;
        $targetURI = 'projects/upload';
        $url = ROOT_URL . $targetURI;

        $filename = TEST_PATH . 'data/test.jpg';
        $minetype = 'image/jpeg';
        $curlFile = curl_file_create($filename, $minetype);
        $uuid = 'UNITUUID-' . quickRandom(18);
        $postData = [
            'qquuid' => $uuid,
            'qqtotalfilesize' => 333,
            'qqfilename' => 'UNIT-' . quickRandom(8),
            'qqfile' => $curlFile,
        ];

        $curl->post($url, $postData);
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        // print_r($resp);
        $ret = json_decode($resp, true);
        $this->assertTrue($ret['success']);

        // 删除
        $curl->get(ROOT_URL . 'issue/main/uploadDelete/'.parent::$project['id'], ['uuid' => $uuid]);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        if ($respArr['ret'] != '200') {
            $this->fail(__FUNCTION__ . ' failed:' . $respArr['msg'] . ',' . $respArr['data']);
            return;
        }

        //$this->markTestIncomplete('TODO: '.__METHOD__);
    }
}
