<?php


namespace main\test\featrue\api;

use main\app\model\project\ProjectRoleModel;
use main\test\BaseApiTestCase;
use main\test\BaseDataProvider;

class TestProjectUsers extends BaseApiTestCase
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
     * @throws \Exception
     */
    public function addProjectUser($name = '这个用户')
    {
        $accessToken = '';
        $projectId = self::$projectId;

        // 初始用户
        $info = [];
        $user = BaseDataProvider::createUser($info);

        $projectRoleModel = new ProjectRoleModel();
        $rolesArr = $projectRoleModel->getsByProject($projectId);

        $client = new \GuzzleHttp\Client();
        $url = ROOT_URL . 'api/project_users/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;

        $response = $client->post($url, [
            'form_params' => [
                'role_id' => $rolesArr[0]['id'],
                'user_id' => $user['uid'],
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
     * 添加项目用户
     * @throws \Exception
     */
    public function testPost()
    {
        $ret = $this->addProjectUser();
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

        $ret = $this->addProjectUser();

        $url = ROOT_URL . 'api/project_users/v1/?access_token=' . $accessToken . '&project_id=' . $projectId;
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

        $ret = $this->addProjectUser();
        $newId = $ret['id'];

        $url = ROOT_URL . "api/project_users/v1/?project_id={$projectId}&user_id={$newId}&access_token=" . $accessToken;
        $client = new \GuzzleHttp\Client();
        $response = $client->delete($url);
        $rawResponse = $response->getBody()->getContents();
        $respArr = json_decode($rawResponse, true);
        $this->assertNotEmpty($respArr, '接口请求失败');
    }
}