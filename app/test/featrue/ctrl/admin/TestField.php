<?php

namespace main\app\test\featrue\ctrl\admin;

use main\app\model\field\FieldModel;
use main\app\model\field\FieldTypeModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;

class TestField extends BaseAppTestCase
{

    public static $addField = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 测试结束后执行此方法,清除测试数据
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$addField)) {
            $model = new FieldModel();
            $model->deleteById(self::$addField ['id']);
        }
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testIndexPage()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/field');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    public function testFetchAll()
    {
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/field/FetchAll');
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData['fields']);
        $this->assertNotEmpty($respData['field_types']);
    }

    public function testGet()
    {
        $model = new FieldModel();
        $field = $model->getByName('priority');
        $curl = BaseAppTestCase::$userCurl;
        $curl->get('admin/field/get/' . $field['id']);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    public function testAdd()
    {
        $model = new FieldTypeModel();
        $fieldType = $model->getByName('TEXT');
        $name = 'test-name-' . mt_rand(10000, 99999);
        $description = 'test-description';
        $reqInfo = [];
        $reqInfo['params']['field_type_id'] = $fieldType['id'];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        $reqInfo['params']['options'] = '';

        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/field/add', $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'org/add failed');
        $this->assertEquals('200', $respArr['ret']);
        $model = new FieldModel();
        self::$addField = $model->getByName($name);
    }

    public function testUpdate()
    {
        $id = self::$addField['id'];
        $model = new FieldTypeModel();
        $fieldType = $model->getByName('SELECT');
        $name = 'updated-name-' . mt_rand(10000, 99999);
        $description = 'updated-description';
        $reqInfo = [];
        $reqInfo['params']['field_type_id'] = $fieldType['id'];
        $reqInfo['params']['name'] = $name;
        $reqInfo['params']['description'] = $description;
        // 构建上传
        $curl = BaseAppTestCase::$userCurl;
        $curl->post(ROOT_URL . 'admin/field/update/' . $id, $reqInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);

        $model = new FieldModel();
        self::$addField = $model->getRowById($id);
        $this->assertEquals($name, self::$addField['name']);
        $this->assertEquals($description, self::$addField['description']);
    }

    public function testDelete()
    {
        $id = self::$addField['id'];
        $curl = BaseAppTestCase::$userCurl;
        $curl->get(ROOT_URL . 'admin/field/delete/' . $id);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr);
        $this->assertEquals('200', $respArr['ret']);
    }
}
