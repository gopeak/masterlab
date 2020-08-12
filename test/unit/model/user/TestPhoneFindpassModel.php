<?php

namespace main\test\unit\model\user;

use PHPUnit\Framework\TestCase;
use main\app\model\user\PhoneFindPassModel;

/**
 *  PhoneFindpassModel 测试类
 * User: sven
 */
class TestPhoneFindpassModel extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 测试获取当前用户设置
     */
    public function testMain()
    {
        $phone = '190' . mt_rand(12345678, 92345678);
        $verifyCode = '123456';
        $info['phone'] = $phone;
        $info['verify_code'] = $verifyCode;
        $info['time'] = time();

        $model = new PhoneFindPassModel();

        list($ret, $msg) = $model->insertPhone($info);
        $this->assertTrue($ret, $msg);

        // 获取记录
        $row = $model->getByPhone($phone);
        $this->assertTrue(isset($row['phone']));
        $this->assertEquals($phone, $row['phone']);

        // 测试删除
        $ret = $model->deleteByPhone($phone);
        $this->assertEquals($ret, 1);
        $row = $model->getByPhone($phone);
        $this->assertFalse(isset($row['phone']));
    }
}
