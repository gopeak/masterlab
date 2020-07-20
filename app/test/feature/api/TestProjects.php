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

    /**
     * 创建项目
     * @throws \Exception
     */
    public function testPost()
    {
        $accessToken = '';
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL.'/api/projects/v1/?access_token=' . $accessToken;

        $response = $client->post($url, [
            'form_params' => [
                'name' => 'test-' . quickRandomStr(50),
                'org_id' => 1,
                'key' => 'TEST' . strtoupper(quickRandomStr(15)),
                'lead' => 1,
                'type' => 10,
                'description' => '描述：' . quickRandomStr(),
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
        //print_r($respArr);
        $this->assertTrue(isset($respData['body']['project_id']), '返回值中没有出现项目ID');
        $this->assertTrue($respData['body']['project_id']>0?true:false, '项目ID错误');
    }

    /**
     * 删除项目
     * @throws \Exception
     */
    public function testDelete()
    {
        $projectId = 20;
        $accessToken = '';
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL.'/api/projects/v1/' . $projectId . '?access_token=' . $accessToken;

        $response = $client->delete($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }
}