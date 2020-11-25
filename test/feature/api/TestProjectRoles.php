<?php


namespace main\test\featrue\api;

use main\test\BaseApiTestCase;

class TestProjectRoles extends BaseApiTestCase
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
    public function addProjectRole($name = '这个角色')
    {
        $accessToken = '';
        $projectId = self::$projectId;
        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/project_roles/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;

        $response = $client->post($url, [
            'form_params' => [
                'name' => $name . quickRandomStr(30),
                'description' => '描述1：' . quickRandomStr(),
            ]
        ]);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $newId = $respArr['data']['id'];

        return [
            'id' => $newId,
            'body' => $respArr['data'],
            'resp' => $respArr
        ];
    }

    /**
     * 添加项目角色
     * @throws \Exception
     */
    public function testPost()
    {
        $ret = $this->addProjectRole();
        $this->assertTrue(!empty($ret['id']), '添加失败，没有返回新增ID');
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
    public function testGet()
    {
        $accessToken = '';
        $projectId = self::$projectId;

        $url = ROOT_URL . 'api/project_roles/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;
        $client = new \GuzzleHttp\Client();
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
     *
     * @throws \Exception
     */
    public function testDelete()
    {
        $projectId = self::$projectId;
        $accessToken = '';

        $ret = $this->addProjectRole();
        $newId = $ret['id'];

        $url = ROOT_URL . 'api/project_roles/v1/' . $newId . '?access_token='.$accessToken.'&project_id='.$projectId;
        $client = new \GuzzleHttp\Client();
        $response = $client->delete($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }
}