<?php
namespace main\app\test\featrue;

use main\app\test\BaseAppTestCase;
use main\app\test\data\LogDataProvider;

/**
 *
 * @version    php v7.1.1
 * @link
 */
class TestLog extends BaseAppTestCase
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
    public function testIndex()
    {
        static::$userCurl->get(ROOT_URL . 'log');
        $resp = static::$userCurl->rawResponse;
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/<option\svalue=".+"/i', $resp, 'expect <select> tag not empty, but not match');
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
        static::$userCurl->get(ROOT_URL . 'log/_list?' . $param);
        $json = json_decode(static::$userCurl->rawResponse, true);
        if (empty($json)) {
            $this->fail(' fetch log is not json data:' . static::$userCurl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data']['logs'], static::$userCurl->rawResponse);
        $this->assertNotEmpty($json['data']['page_str']);

        // 详情查询
        $param = sprintf("format=json&page=%d&remark=%s&user_name=%s&action=%s", 1, md5(time()), '', '');
        static::$userCurl->get(ROOT_URL . 'log/_list?' . $param);
        $json = json_decode(static::$userCurl->rawResponse, true);
        if (empty($json)) {
            $this->fail(' fetch log is not json data:' . static::$userCurl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertEmpty($json['data']['logs']);

        // 用户名查询
        $param = sprintf("format=json&page=%d&remark=%s&user_name=%s&action=%s", 1, '', self::$logs[0]->user_name, '');
        static::$userCurl->get(ROOT_URL . 'log/_list?' . $param);
        $json = json_decode(static::$userCurl->rawResponse, true);
        if (empty($json)) {
            $this->fail(' fetch log is not json data:' . static::$userCurl->rawResponse);
        }
        $this->assertEquals('200', $json['ret']);
        $this->assertNotEmpty($json['data']['logs']);
    }

    /**
     * 测试细节
     */
    public function testDetail()
    {
        $curl = static::$userCurl;

        static::$userCurl->get(ROOT_URL . 'log/detail?id=' . self::$logs[0]->id);
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
