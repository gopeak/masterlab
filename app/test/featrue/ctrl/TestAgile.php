<?php
namespace main\app\test\featrue;

use main\app\test\BaseAppTestCase;
use main\app\test\data\LogDataProvider;

/**
 *
 * @version
 * @link
 */
class TestAgile extends BaseAppTestCase
{
    public static $clean = [];

    public static $logs = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::$logs = LogDataProvider::initLogs(20, parent::$user['uid'], parent::$user['company_id']);
    }

    /**
     * 测试页面
     */
    public function testBacklog()
    {
        static::$user_curl->get(ROOT_URL . '/backlog');
        $resp = static::$user_curl->rawResponse;
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
    }

    /**
     * ajax的日志数据
     */
    public function testAjaxFetch()
    {
        //http://www.bom.local/log/_list?page=1&format=json&remark=&user_name=&action=

        //print_r(static::$logs );
        // 无查询
        $param = sprintf("format=json&page=%d&remark=%s&user_name=%s&action=%s", 1, '', '', '');
        static::$user_curl->get(ROOT_URL . 'log/_list?' . $param);
        $json = json_decode(static::$user_curl->rawResponse, true);
        if (empty($json)) {
            $this->fail(' fetch log is not json data:' . static::$user_curl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data']['logs'], static::$user_curl->rawResponse);
        $this->assertNotEmpty($json['data']['page_str']);

        // 详情查询
        $param = sprintf("format=json&page=%d&remark=%s&user_name=%s&action=%s", 1, md5(time()), '', '');
        static::$user_curl->get(ROOT_URL . 'log/_list?' . $param);
        $json = json_decode(static::$user_curl->rawResponse, true);
        if (empty($json)) {
            $this->fail(' fetch log is not json data:' . static::$user_curl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertEmpty($json['data']['logs']);

        // 用户名查询
        $param = sprintf("format=json&page=%d&remark=%s&user_name=%s&action=%s", 1, '', self::$logs[0]->user_name, '');
        static::$user_curl->get(ROOT_URL . 'log/_list?' . $param);
        $json = json_decode(static::$user_curl->rawResponse, true);
        if (empty($json)) {
            $this->fail(' fetch log is not json data:' . static::$user_curl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data']['logs']);
    }

    /**
     * 测试细节
     */
    public function testDetail()
    {
        $curl = static::$user_curl;

        static::$user_curl->get(ROOT_URL . 'log/detail?id=' . self::$logs[0]->id);
        $resp = $curl->rawResponse;
        if (empty($resp)) {
            $this->fail(' fetch log detail  is empty:' . $curl->rawResponse);
        }

        $this->assertContains('<td>f1</td>', $resp);
        $this->assertContains('<td>f2</td>', $resp);
    }

    /**
     * teardown执行后执行此方法
     */
    public static function tearDownAfterClass()
    {
        //var_dump( get_resources() );
        LogDataProvider::clearLogs(parent::$user['uid']);
        parent::tearDownAfterClass();
    }
}
