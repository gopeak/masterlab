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
        $url = ROOT_URL.'/api/projects/v1/1?access_token=' . $accessToken;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);

        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);

    }

    public function testPost()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', ROOT_URL.'/api/projects/v1/1?access_token=', [
            'auth' => ['user', 'pass']
        ]);
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
        echo $res->getBody();
    }

}