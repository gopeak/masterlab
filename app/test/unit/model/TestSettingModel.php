<?php

namespace main\app\test\unit\model\issue;

use main\app\model\SettingModel;

/**
 *  SettingModel 测试类
 * User: sven
 */
class TestSettingModel extends TestBaseIssueModel
{

    public static $insertIdArr = [];

    public static $key = '';

    public static function setUpBeforeClass()
    {

    }

    /**
     * 确保生成的测试数据被清除
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$insertIdArr)) {
            $model = new SettingModel();
            foreach (self::$insertIdArr as $id) {
                $model->delSetting(self::$key);
                $model->deleteById($id);
            }
        }

    }


    /**
     * 主流程
     * @throws \Exception
     */
    public function testMain()
    {
        $settingModel = new SettingModel();

        // 测试已经有的数据
        $title = $settingModel->getSettingValue('title');
        $this->assertNotEmpty($title);
        $this->assertTrue(is_string($title));
        $titleSecond = $settingModel->getSettingValue('title');
        $this->assertEquals($title, $titleSecond);

        // 构建测试数据
        $key = 'setting_test_' . mt_rand(100000, 9999999);
        $value = time() - 10;
        $module = 'unit_test';
        list($ret, $settingId) = $settingModel->insertSetting($key, $value, $module, 'unit_test_key', 'int');
        if (!$ret) {
            //var_dump('TestBaseUserModel initUser  failed,' . $msg);
            parent::fail(__CLASS__ . ' initSetting  failed,' . $settingId);
            return [];
        }
        self::$insertIdArr[] = $settingId;
        self::$key = $key;
        $setting = $settingModel->getRowById($settingId);

        // 测试获取key的值
        $fetchValue = $settingModel->getValue($key);
        $this->assertEquals($value, $fetchValue);

        // 测试获取记录
        $fetchRow = $settingModel->getSettingRow($key);
        $this->assertEquals($setting['_value'], $fetchRow['_value']);
        $this->assertEquals($setting['module'], $fetchRow['module']);

        // 测试更新
        $newValue = time();
        $settingModel->updateSetting($key, $newValue);
        $fetchValue = $settingModel->getValue($key);
        $this->assertEquals($newValue, $fetchValue);
        $fetchRow = $settingModel->getSettingRow($key);
        $this->assertEquals($newValue, $fetchRow['_value']);

        // 测试删除
        $ret = $settingModel->delSetting($key);
        $this->assertTrue((bool)$ret);
        $fetchValue = $settingModel->getValue($key);
        $this->assertFalse($fetchValue);
        $fetchRow = $settingModel->getSettingRow($key);
        $this->assertEquals([], $fetchRow);
    }
}
