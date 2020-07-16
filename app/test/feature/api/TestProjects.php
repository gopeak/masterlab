<?php


namespace main\app\test\featrue\api;


use main\app\test\BaseTestCase;

class TestProjects extends BaseTestCase
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
        $accessToken = '';
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL.'/api/projects/v1/1?access_token=' . $accessToken);
        $respArr = json_decode($curl->rawResponse, true);

        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);

    }

    public function testPost()
    {
    }

}