<?php


namespace main\test\featrue\api;


use main\test\BaseApiTestCase;

class TestSprints extends BaseApiTestCase
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
    public function addSprint($name = '这个迭代')
    {
        $accessToken = '';
        $projectId = self::$projectId;
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/sprints/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;

        $response = $client->post($url, [
            'form_params' => [
                'sprint_name' => $name . quickRandomStr(50),
                'description' => '描述1：' . quickRandomStr(),
            ]
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $newId = $respArr['data']['id'];

        return [
            'id' => $newId,
            'body' => $respArr['data'],
            'resp' => $respArr,
        ];
    }

    /**
     * 添加迭代
     * @throws \Exception
     */
    public function testPost()
    {
        $ret = $this->addSprint();
        $respArr = $ret['resp'];
        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('20000', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    /**
     * @throws \Exception
     */
    public function testGetOne()
    {
        $accessToken = '';
        $projectId = self::$projectId;

        $ret = $this->addSprint();
        $newSprintId = $ret['id'];

        $url = ROOT_URL.'/api/sprints/v1/'.$newSprintId.'?access_token=' . $accessToken;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);

        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('20000', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
        if(strpos($respData['name'],'这个迭代') !== false){
            $this->assertTrue(true); //包含
        } else {
            $this->assertTrue(false);
        }

    }

    /**
     * @throws \Exception
     */
    public function testGetList()
    {
        $accessToken = '';
        $projectId = self::$projectId;

        $ret = $this->addSprint();
        $newSprintId = $ret['id'];

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/sprints/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;
        $response = $client->get($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);

        $this->assertNotEmpty($respArr, '接口请求失败');
        $this->assertTrue(isset($respArr['data']), '不包含data属性');
        $this->assertEquals('20000', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertNotEmpty($respData);
    }

    /**
     * @throws \Exception
     */
    public function testPatch()
    {
        $projectId = self::$projectId;
        $accessToken = '';

        $ret = $this->addSprint();
        $newId = $ret['id'];

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/sprints/v1/' . $newId . '?access_token=' . $accessToken. '&project_id=' . $projectId;
        $response = $client->patch($url, [
            'form_params' => [
                'name' => 'new' . quickRandomStr(50),
                'description' => 'new描述1：' . quickRandomStr(),
                'status' => 1,
                'start_date' => '2020-01-01',
                'end_date' => date('Y-m-s H:i:s', time()),
            ]
        ]);
        //$response = $client->request('PUT', $url, ['body' => 'foo']);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }

    /**
     * @throws \Exception
     */
    public function testSetSprintActive()
    {
        $projectId = self::$projectId;
        $accessToken = '';

        $ret = $this->addSprint();
        $newId = $ret['id'];

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/sprints/set_sprint_active/' . $newId . '?access_token=' . $accessToken;
        $response = $client->patch($url, [
            'form_params' => []
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }

    /**
     * @throws \Exception
     */
    public function testDelete()
    {
        $accessToken = '';

        $ret = $this->addSprint();
        $newId = $ret['id'];

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/sprints/v1/' . $newId . '?access_token=' . $accessToken;
        $response = $client->delete($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }
}