<?php

namespace main\test\featrue\ctrl\admin;

use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\user\GroupModel;
use main\app\model\user\UserModel;
use main\app\classes\UserLogic;
use main\test\BaseAppTestCase;
use main\test\BaseDataProvider;

/**
 *  admin/Upload 测试类
 * @package main\test\logic
 */
class TestUpload extends BaseAppTestCase
{
    public static $fileAttachmentIdArr = [];


    public static function setUpBeforeClass()
    {
        BaseAppTestCase::setUpBeforeClass();
    }

    public static function tearDownAfterClass()
    {
        if (!empty(self::$fileAttachmentIdArr)) {
            $model = new IssueFileAttachmentModel();
            foreach (self::$fileAttachmentIdArr as $id) {
                $fileRow = $model->getRowById($id);
                unlink(PUBLIC_PATH.'attachment/'.$fileRow['file_name']);
                $model->deleteById($id);
            }
        }
        BaseAppTestCase::tearDownAfterClass();
    }


    /**
     * 测试页面
     */
    public function testUploadImg()
    {
        $curl = BaseAppTestCase::$userCurl;

        $curl->post(ROOT_URL . 'admin/upload/img', array(
            'imgFile' => new \CURLFile(PUBLIC_PATH . 'attachment/unittest/sample.png'),
        ));
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals(0, $respArr['error']);
        $this->assertNotEmpty($respArr['url']);
        $this->assertNotEmpty($respArr['insert_id']);
        self::$fileAttachmentIdArr[] = $respArr['insert_id'];
    }

    public function testUploadAvatar()
    {
        $curl = BaseAppTestCase::$userCurl;

        $curl->post(ROOT_URL . 'admin/upload/avatar', array(
            'imgFile' => new \CURLFile(PUBLIC_PATH . 'attachment/unittest/sample.png'),
        ));
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals(0, $respArr['error']);
        $this->assertNotEmpty($respArr['url']);
        $this->assertNotEmpty($respArr['insert_id']);
        self::$fileAttachmentIdArr[] = $respArr['insert_id'];
    }
}
