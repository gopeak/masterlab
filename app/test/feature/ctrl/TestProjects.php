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
        $user = parent::$user;

        $targetURI = 'projects/upload';

        $url = ROOT_URL . $targetURI;

        $ch = curl_init();
        $filename = TEST_PATH . 'data/test.jpg';
        $minetype = 'image/jpeg';
        $curlFile = curl_file_create($filename, $minetype);
        $postData = [
            'qquuid' => 'UNITUUID-' . quickRandom(18),
            'qqtotalfilesize' => 333,
            'qqfilename' => 'UNIT-' . quickRandom(8),
            'qqfile' => $curlFile,
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $res = curl_exec($ch);
        $error_no = curl_errno($ch);
        $err_msg = '';
        if ($error_no) {
            $err_msg = curl_error($ch);
            $this->assertTrue(false);
        } else {
            $ret = json_decode($res, true);
            // print_r($ret);
            $this->assertTrue($ret['success']);
        }
        curl_close($ch);

        //$this->markTestIncomplete('TODO: '.__METHOD__);
    }
}
