<?php

namespace main\test\featrue\api;

use main\test\BaseTestCase;

/**
 * api auth测试类
 * @version
 * @link
 */
class TestAuth extends BaseTestCase
{
    public static $clean = [];


    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {

        parent::tearDownAfterClass();
    }


    /**
     * @throws \Exception
     */
    public function testGet()
    {
        $curl =   new \Curl\Curl();
        $curl->get(ROOT_URL.'api/auth/?account=master&password=testtest' );
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'api/auth failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

}
