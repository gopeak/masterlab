<?php


namespace main\app\test\featrue\api;


use main\app\test\BaseApiTestCase;

class TestModules extends BaseApiTestCase
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
     * 添加模块
     * @throws \Exception
     */
    public function testPost()
    {
        $accessToken = '';
        $projectId = self::$projectId;
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/modules/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;

        $response = $client->post($url, [
            'form_params' => [
                'module_name' => 'test1' . quickRandomStr(50),
                'description' => '描述1：' . quickRandomStr(),
            ]
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        //echo $rawResponse;
        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);

    }

    /**
     * @throws \Exception
     */
    public function testGet()
    {
        $accessToken = '';
        $projectId = self::$projectId;
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/modules/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;

        $response = $client->post($url, [
            'form_params' => [
                'module_name' => '这个模块' . quickRandomStr(50),
                'description' => '描述1：' . quickRandomStr(),
            ]
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $newModuleId = $respArr['data']['body']['id'];


        $url = ROOT_URL.'/api/modules/v1/'.$newModuleId.'?access_token=' . $accessToken;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        if(strpos($respData['body']['name'],'这个模块') !== false){
            $this->assertTrue(true); //包含
        } else {
            $this->assertTrue(false);
        }

        $url = ROOT_URL . 'api/modules/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;
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


}