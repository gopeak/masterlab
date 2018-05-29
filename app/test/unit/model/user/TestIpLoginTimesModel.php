<?php

namespace main\app\test\unit\model\user;

use main\app\model\user\IpLoginTimesModel;
use PHPUnit\Framework\TestCase;

/**
 * IpLoginTimesModel 测试类
 * User: sven
 */
class TestIpLoginTimesModel extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 测试一整套流程
     */
    public function testMain()
    {
        // 1. 新增记录
        $ipAddr = '190' . mt_rand(1234678, 9999999);
        $initTimes = 1;
        $model = new IpLoginTimesModel();
        list($ret, $insertId) = $model->insertIp($ipAddr, $initTimes);
        $this->assertTrue($ret);
        $this->assertTrue(intval($insertId) > 0);

        // 2. 获取记录
        $row = $model->getIpLoginTimes($ipAddr);
        $this->assertNotEmpty($row);
        $this->assertEquals($initTimes, (int)$row['times']);

        // 3. 测试 resetInsertIp 方法
        list($ret, $msg) = $model->resetInsertIp($ipAddr);
        $this->assertTrue($ret, $msg);
        $row = $model->getIpLoginTimes($ipAddr);
        $this->assertEquals(0, (int)$row['times']);

        // 4. 测试updateIpTime
        $updateTime = 4;
        list($ret, $msg) = $model->updateIpTime($ipAddr, $updateTime);
        $this->assertTrue($ret, $msg);
        $row = $model->getIpLoginTimes($ipAddr);
        $this->assertEquals($updateTime, (int)$row['times']);

        // 5. 清除数据
        $deletedCount = (int)$model->deleteByIp($ipAddr);
        $this->assertEquals(1, $deletedCount);
    }
}
