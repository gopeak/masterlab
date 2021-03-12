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
        $url = ROOT_URL.'api/auth?app_key=xxxxxxxxxxxx&app_secret=xxxxxxxxxxxxxx';
        $curl->get($url );
        echo $curl->rawResponse;
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'api/auth failed');
        $this->assertEquals('0', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

}
