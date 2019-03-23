<?php

namespace main\app\test\user_function;

use PHPUnit\Framework\TestCase;

/**
 * 函数测试类
 */
class TestResponseError extends TestCase
{

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    public function testCheckUserError()
    {
        $curl = new \Curl\Curl();
        if (extension_loaded('xdebug')) {
            $curl->get(ROOT_URL . 'framework/response_error/userError?enable_xdebug=1');
            $ret = checkXdebugUserError($curl->rawResponse);
            if (error_reporting() == E_ALL) {
                $this->assertNotEmpty($ret);
            }
        }
        $curl->get(ROOT_URL . 'framework/response_error/userError?enable_xdebug=0');
        // echo $curl->rawResponse;
        $ret = checkUserError($curl->rawResponse);
        if (error_reporting() == E_ALL) {
            $this->assertNotEmpty($ret);
        }
        $this->assertTrue(error_reporting()>=0);
    }

    public function testCheckTriggerError()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . 'framework/response_error/triggerError?enable_xdebug=0');
        $ret = checkUserError($curl->rawResponse);
        $this->assertNotEmpty($ret);
    }

    public function testCheckXdebugTriggerError()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/response_error/triggerError?enable_xdebug=0');
        $ret = checkUserError($curl->rawResponse);
        $this->assertNotEmpty($ret);
    }

    public function testCheckFatalError()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/response_error/fatalError?enable_xdebug=0');
        $ret = checkUserError($curl->rawResponse);
        $this->assertNotEmpty($ret);
    }

    public function testCheckXdebugFatalError()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/response_error/fatalError?enable_xdebug=0');
        $ret = checkUserError($curl->rawResponse);
        $this->assertNotEmpty($ret);
    }

    public function testCheckXdebugUnDefine()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/response_error/unDefine?enable_xdebug=1');
        $ret = checkXdebugUserError($curl->rawResponse);
        $this->assertNotEmpty($ret);
    }

    public function testCheckUnDefine()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/response_error/unDefine?enable_xdebug=0');
        $this->assertFalse($curl->error);
        $ret = checkUnDefine($curl->rawResponse);
        if (error_reporting() == E_ALL) {
            $this->assertNotEmpty($ret);
        }
    }


    public function testCheckExceptionError()
    {
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/response_error/exception');
        //echo $curl->rawResponse;
        $pattern = '%Division\s+by\s+zero%U';
        $ret = checkRegCommon($pattern, $curl->rawResponse);
        $this->assertNotEmpty($ret);
    }
}
