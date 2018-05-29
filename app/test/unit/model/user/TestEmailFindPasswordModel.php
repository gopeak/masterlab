<?php

namespace main\app\test\unit\model\user;

use main\app\model\user\EmailFindPasswordModel;

/**
 *  GroupModel 测试类
 * User: sven
 */
class TestEmailFindPasswordModel extends TestBaseUserModel
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new EmailFindPasswordModel();
        // 1. 新增测试需要的数据
        $email = '190' . mt_rand(12345678, 92345678) . '@masterlab.org';
        $verifyCode = '123456';
        list($ret, $insertId) = $model->add($email, $verifyCode);
        $this->assertTrue($ret, $insertId);

        // 2.测试 getByEmail
        $row = $model->getByEmail($email);
        $this->assertEquals($email, $row['email']);
        $this->assertEquals($verifyCode, $row['verify_code']);

        // 3.测试 getByName
        $row = $model->getByEmailVerifyCode($email, $verifyCode);
        $this->assertEquals($email, $row['email']);
        $this->assertEquals($verifyCode, $row['verify_code']);

        // 4.删除
        $ret = (bool)$model->deleteByEmail($email);
        $this->assertTrue($ret);
        $model->deleteById($insertId);
    }
}
