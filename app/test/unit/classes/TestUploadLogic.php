<?php

namespace main\app\test\unit\classes;

use PHPUnit\Framework\TestCase;

use main\app\model\system\MailQueueModel;
use main\app\classes\UploadLogic;
use main\app\test\data\LogDataProvider;

/**
 *  UploadLogic 测试类
 * @package main\app\test\unit\classes
 */
class TestUploadLogic extends TestCase
{


    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
        UploadLogicDataProvider::clear();
    }

    /**
     * @throws \Exception
     */
    public function testMain()
    {
        $user = UploadLogicDataProvider::initLoginUser();
        if (empty($user)) {
            parent::fail('create user failed');
        }
        $logic = new UploadLogic();

        // 测试正常的文件上传
        $fieldName = 'test-field-name';
        list($ret) = UploadLogicDataProvider::providerFileObject($fieldName);
        $this->assertTrue($ret);
        $ret = $logic->move($fieldName, 'avatar');
        if ($ret['error'] != UPLOAD_ERR_OK) {
            print_r($ret);
            return;
        }
        $this->assertNotEmpty($ret);
        $this->assertArrayHasKey('error', $ret);
        $this->assertEquals(0, $ret['error']);
        if (!empty($ret['insert_id'])) {
            UploadLogicDataProvider::$fileAttachmentIdArr[] = $ret['insert_id'];
        }
        return;

        // 测试不正确的文件后缀
        $fieldName = 'test-field-name2';
        $originFileName = 'qq.php';
        list($ret, $msg) = UploadLogicDataProvider::providerFileObject($fieldName, $originFileName);
        $this->assertTrue($ret, $msg);
        $ret = $logic->move($fieldName, 'file');
        $this->assertTrue(isset($ret['error']));
        $this->assertEquals(4, $ret['error']);
        if (!empty($ret['insert_id'])) {
            UploadLogicDataProvider::$fileAttachmentIdArr[] = $ret['insert_id'];
        }
    }
}
