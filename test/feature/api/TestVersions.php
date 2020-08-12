<?php


namespace main\test\featrue\api;


use main\test\BaseApiTestCase;

class TestVersions extends BaseApiTestCase
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
     * @param string $name
     * @return array
     */
    public function addVersion($name = '这个版本')
    {
        $accessToken = '';
        $projectId = self::$projectId;
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/versions/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;

        $response = $client->post($url, [
            'form_params' => [
                'version_name' => $name . quickRandomStr(50),
                'description' => '描述1：' . quickRandomStr(),
            ]
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $newId = $respArr['data']['body']['id'];

        return [
            'id' => $newId,
            'body' => $respArr['data']['body'],
            'resp' => $respArr,
        ];
    }

    /**
     * 添加版本
     * @throws \Exception
     */
    public function testPost()
    {
        $ret = $this->addVersion();
        $respArr = $ret['resp'];
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

        $ret = $this->addVersion();
        $newId = $ret['id'];

        $url = ROOT_URL.'/api/versions/v1/'.$newId.'?access_token=' . $accessToken;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        if(strpos($respData['body']['name'],'这个版本') !== false){
            $this->assertTrue(true); //包含
        } else {
            $this->assertTrue(false);
        }

        $url = ROOT_URL . 'api/versions/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;
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
     *
     * @throws \Exception
     */
    public function testDelete()
    {
        $projectId = self::$projectId;
        $accessToken = '';

        $ret = $this->addVersion();
        $newId = $ret['id'];

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/versions/v1/' . $newId . '?access_token=' . $accessToken. '&project_id=' . $projectId;
        $response = $client->delete($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }

    /**
     * @throws \Exception
     */
    public function testPatch()
    {
        $projectId = self::$projectId;
        $accessToken = '';

        $ret = $this->addVersion();
        $newId = $ret['id'];

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/versions/v1/' . $newId . '?access_token=' . $accessToken. '&project_id=' . $projectId;
        $response = $client->patch($url, [
            'form_params' => [
                'version_name' => 'new' . quickRandomStr(50),
                'description' => 'new描述1：' . quickRandomStr(),
                'released' => 1,
                'start_date' => '2020-01-01 09:21:01',
                'release_date' => date('Y-m-s H:i:s', time()),
            ]
        ]);
        //$response = $client->request('PUT', $url, ['body' => 'foo']);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }
}