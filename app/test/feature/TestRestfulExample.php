<?php

namespace main\app\test\featrue;

use main\app\test\BaseAppTestCase;

/**
 *
 * 测试 Restfule example
 * @version php v7.1.1
 * @link
 */
class TestRestfulExample extends BaseAppTestCase
{
    /**
     * curl resource
     * @var \Curl\Curl
     */
    public static $curl = null;

    /**
     * 测试 获取所有用户
     */
    public function testGetUsers()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . 'api/restful_example/users');
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse, true);
        if (empty($json)) {
            $this->fail('GET ' .ROOT_URL. 'api/restful_example/users is not json data:'.$curl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data'], $curl->rawResponse);
        $this->assertTrue(count($json['data']) > 1);
        $curl->close();
    }

    /**
     * 测试 获取单个用户
     */
    public function testGetUser()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . 'api/restful_example/users/1');
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse, true);
        if (empty($json)) {
            $this->fail('GET '.ROOT_URL. 'api/restful_example/users/1 is not json data:'.$curl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data'], $curl->rawResponse);
        $this->assertTrue(isset($json['data']['name']));
        $curl->close();
    }

    /**
     * 测试 新增用户
     */
    public function testPostUser()
    {
        $curl = new \Curl\Curl();
        $post_data = [];
        $post_data['name'] = 'SAT用户';
        $post_data['count'] = 23;
        $curl->post(ROOT_URL . 'api/restful_example/users', $post_data);
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse, true);
        if (empty($json)) {
            $this->fail('POST '.ROOT_URL.'api/restful_example/users is not json data:' . $curl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data'], $curl->rawResponse);
        $this->assertTrue(count($json['data']) > 2);
        $curl->close();
    }

    /**
     * 测试 更新用户全部信息
     */
    public function testPutUser()
    {
        $curl = new \Curl\Curl();
        $post_data = [];
        $post_data['name'] = 'SAT-' . time();
        $post_data['count'] = 25;

        $curl->put(ROOT_URL . 'api/restful_example/users/1', $post_data);
        $this->assertEquals(200, $curl->httpStatusCode);
        $resp = $curl->rawResponse;
        $json = json_decode($resp, true);
        if (empty($json)) {
            $this->fail('PUT ' . ROOT_URL . 'api/restful_example/users/1' . '  is not json data:' . $resp);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data'], $resp);
        $this->assertEquals($post_data['name'], $json['data']['1']['name']);
        $this->assertEquals($post_data['count'], $json['data']['1']['count']);
        $curl->close();
    }

    /**
     * 测试 更新部分用户信息
     */
    public function testPatchUser()
    {
        $curl = new \Curl\Curl();
        $post_data = [];
        $post_data['name'] = 'SAT-' . strval(time() + 100);
        $curl->patch(ROOT_URL . 'api/restful_example/users/1', $post_data);
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse, true);
        if (empty($json)) {
            $msg = 'PATCH '.ROOT_URL .'api/restful_example/users/1 is not json data:'.$curl->rawResponse;
            $this->fail($msg);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data'], $curl->rawResponse);
        $this->assertEquals($post_data['name'], $json['data']['1']['name'], $curl->rawResponse);
        $curl->close();
    }

    /**
     * 测试 删除某个用户
     */
    public function testDeleteUser()
    {
        $curl = new \Curl\Curl();
        $curl->delete(ROOT_URL . 'api/restful_example/users/1');
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse, true);
        if (empty($json)) {
            $msg = "DELETE ".ROOT_URL."api/restful_example/users/1  is not json data,get ".$curl->rawResponse;
            $this->fail($msg);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data'], $curl->rawResponse);
        $this->assertEquals(1, count($json['data']));
        $curl->close();
    }
}
