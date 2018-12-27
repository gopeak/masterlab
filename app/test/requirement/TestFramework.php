<?php

namespace main\app\test\requirement;

use main\app\test\BaseTestCase;

/**
 * 开发框架测试类
 * Class TestFramework
 */
class TestFramework extends BaseTestCase
{

    public static $clean = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }


    /**
     * 测试开发框架的路由访问
     * @throws \Exception
     */
    public function testRoute()
    {
        // 请求控制器 是否可访问
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/feature/route');
        $this->assertEquals(200, $curl->httpStatusCode);
        $this->assertEquals('route', $curl->rawResponse);

        $curl->get(ROOT_URL . '/framework/module_test/route');
        $this->assertEquals(200, $curl->httpStatusCode);
        $this->assertEquals('route', $curl->rawResponse);

        // 请求Api 是否可访问
        $curl->get(ROOT_URL . '/api/framework/route');
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse);
        $this->assertTrue(isset($json->ret));
        $this->assertEquals('200', $json->ret);

        // 请求Api module是否可访问
        $curl->get(ROOT_URL . '/api/module_test/index/route');
        $this->assertEquals(200, $curl->httpStatusCode);
        $rawResponse = $curl->rawResponse;
        $json = json_decode($rawResponse);
        $this->assertTrue(isset($json->ret));
        $this->assertEquals('200', $json->ret);
        $this->assertEquals('route', $json->data);
    }

    /**
     * 测试伪静态参数
     * @throws \Exception
     */
    public function testArg()
    {
        // 请求控制器 是否可访问
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/feature/arg/121?data_type=json');
        $this->assertEquals(200, $curl->httpStatusCode);
        // 获取参数
        $json = json_decode($curl->rawResponse);
        $this->assertTrue(isset($json->data));
        $this->assertTrue(isset($json->data[3]));
        $this->assertEquals('121', $json->data[3]);
    }

    /**
     * 测试异常
     * @throws \Exception
     */
    public function notestException()
    {
        // 抛出异常,捕获 Exception 关键字
        $curl = new \Curl\Curl();
        parent::curlGet($curl, ROOT_URL . '/framework/feature/show_exception');
        $this->assertEquals(200, $curl->httpStatusCode);
        if (!preg_match('/Exception/', $curl->rawResponse)) {
            $this->fail('expect response show Exception,but not match: ' . $curl->rawResponse);
        }

        // 是否返回异常结果
        parent::curlGet($curl, ROOT_URL . '/api/framework/show_exception');
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse);
        $this->assertTrue(isset($json->ret));
        $this->assertEquals('200', $json->ret);
        $this->assertTrue(isset($json->data->key));
        $this->assertTrue(isset($json->data->value));
    }

    /**
     * 测试sql注入
     * @throws \Exception
     */
    public function testSqlInject()
    {
        $curl = new \Curl\Curl();
        $post_data['username'] = "13002510000' or '1'='1 ";
        $post_data['pwd'] = "121";
        $curl->post(ROOT_URL . "framework/feature/sql_inject?format=json&data_type=json", $post_data);
        $json = json_decode($curl->rawResponse);
        $this->assertNotEmpty($json);
        $this->assertTrue(isset($json->ret));
        $this->assertEquals('0', $json->ret);
    }

    /**
     * 测试Sql注入  $name_evil = "'; DELETE FROM customers WHERE 1 or username = '";
     * @throws \Exception
     */
    public function testSqlInjectDelete()
    {
        $curl = new \Curl\Curl();
        $url = ROOT_URL . "framework/feature/sql_inject_delete?format=json";
        $post_data['phone'] = "13002510000'  ; DELETE FROM xphp_user;Select * From `test_user` WHERE 1 or phone = '";
        $curl->post($url, $post_data);
        $this->assertEquals(200, $curl->httpStatusCode);
        $json = json_decode($curl->rawResponse);
        $this->assertNotEmpty($json);
        $this->assertEquals('0', $json->ret);
    }

    /**
     * 测试会话
     * @throws \Exception
     */
    public function testSession()
    {
        $curl = new \Curl\Curl();
        $curl->setCookieFile('testSession.cookie');
        parent::curlGet($curl, ROOT_URL . "framework/feature/session_step1", [], true);
        $this->assertEquals(200, $curl->httpStatusCode);

        $json = parent::curlGet($curl, ROOT_URL . "framework/feature/session_step2", [], true);
        $this->assertEquals(200, $curl->httpStatusCode);
        if (!isset($json['data']['test_session1']) || empty($json['data']['test_session1'])) {
            $this->fail('testSession fail ,decode json null ,response:' . $curl->rawResponse);
        }
    }

    /**
     *  测试分库功能
     * @throws \Exception
     */
    public function testSplitDatabase()
    {
        // 先创建模型,使用的是default数据库配置
        $modelDefault = 'UnitTestDefaultModel';
        $writeRet = parent::createModelFile($modelDefault);
        if (!$writeRet) {
            $this->fail(MODEL_PATH . $modelDefault . '.php' . " can not write");
            return;
        }

        // 先创建模型,使用的是 unit_test_db  数据库配置
        $modelUnit = 'UnitTestUnitModel';
        $writeRet = parent::createModelFile($modelUnit);
        if (!$writeRet) {
            $this->fail(MODEL_PATH . $modelUnit . '.php' . " can not write");
            return;
        }

        // 更改配置,多库设置
        $dbConfig = getConfigVar('database');
        $dbConfig['database']['log_db'] = $dbConfig['database']['default'];
        if (!in_array($modelUnit, $dbConfig['database']['log_db'])) {
            $dbConfig['config_map_class']['log_db'][] = $modelUnit;
        }

        $newConfigSrc = "<?php\n " . '$_config = ' . var_export($dbConfig, true) . ";\n\n" . 'return $_config;' . "\n";
        $file = APP_PATH . 'config/' . APP_STATUS . '/database.cfg.php';
        $originDatabaseSource = $this->readWithLock($file);
        $writeRet = $this->writeWithLock($file, $newConfigSrc);
        if ($writeRet !== false) {
            require_once MODEL_PATH . 'BaseModel.php';
            require_once MODEL_PATH . 'DbModel.php';
            require_once MODEL_PATH . $modelDefault . '.php';
            $model_default_class = sprintf("main\\%s\\model\\%s", APP_NAME, $modelDefault);
            if (!class_exists($model_default_class)) {
                $this->fail('class ' . $model_default_class . ' no found');
            }
            $modelDefaultObj = new $model_default_class();
            $modelDefaultObj->realConnect();

            require_once MODEL_PATH . $modelUnit . '.php';
            $modelClass = sprintf("main\\%s\\model\\%s", APP_NAME, $modelUnit);
            if (!class_exists($modelClass)) {
                $this->fail('class ' . $modelClass . ' no found');
            }
            $modelUnitObj = new $modelClass();
            $modelUnitObj->realConnect();
            if ($modelUnitObj->db->pdo == $modelDefaultObj->db->pdo) {
                $this->writeWithLock($file, $originDatabaseSource);
                unlink(MODEL_PATH . $modelDefault . '.php');
                unlink(MODEL_PATH . $modelUnit . '.php');
                $defaultConfigName = $modelDefaultObj->configName;
                $unitConfigName = $modelUnitObj->configName;
                $this->fail("SplitDatabase feature failed {$defaultConfigName} equal {$unitConfigName}");
            }
            $this->writeWithLock($file, $originDatabaseSource);
        }
        unlink(MODEL_PATH . $modelDefault . '.php');
        unlink(MODEL_PATH . $modelUnit . '.php');
        $this->assertTrue(true, true);
    }

    /**
     * 测试Ajax 返回格式
     * @throws \Exception
     */
    public function testValidAjaxJson()
    {
        if (!ENABLE_REFLECT_METHOD) {
            return;
        }
        // 故意返回错误的格式
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/feature/not_expect_json');
        $this->assertEquals(200, $curl->httpStatusCode);
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('600', $json->ret);
        // 返回正确的格式
        $curl->get(ROOT_URL . '/framework/feature/expect_json');
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('200', $json->ret);

        // 故意返回错误的复杂格式
        $curl->get(ROOT_URL . '/framework/feature/not_expect_mix_json');
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('600', $json->ret);

        // 返回正确的复杂格式
        $curl->get(ROOT_URL . '/framework/feature/expect_mix_json');
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('200', $json->ret);
    }


    /**
     * 测试返回值格式
     * @throws \Exception
     */
    public function testValidApiJson()
    {
        if (!ENABLE_REFLECT_METHOD) {
            return;
        }
        // 故意返回错误的格式
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/api/framework/not_expect_json');
        $this->assertEquals(200, $curl->httpStatusCode);
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('600', $json->ret);
        // 返回正确的格式
        $curl->get(ROOT_URL . '/api/framework/expect_json');
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('200', $json->ret);

        // 故意返回错误的复杂格式
        $curl->get(ROOT_URL . '/api/framework/not_expect_mix_json');
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('600', $json->ret);

        // 返回正确的复杂格式
        $curl->get(ROOT_URL . '/api/framework/expect_mix_json');
        $this->assertJson($curl->rawResponse);
        $json = json_decode($curl->rawResponse);
        $this->assertEquals('200', $json->ret);
    }


// 测试文件服务器分离, 需要编写通用的上传代码
// 1.上传文件 2.通过返回的url返回文件是否存在
    /**
     * 测试自定义的异常页面
     * @throws \Exception
     */
    public function testCustomExceptionPage()
    {
        // 创建开发框架配置
        $config = new \stdClass();
        $config->currentApp = APP_NAME;
        $config->appPath = APP_PATH;
        $config->appStatus = APP_STATUS;
        $config->enableTrace = ENABLE_TRACE;
        $config->enableXhprof = ENABLE_XHPROF;
        $config->xhprofRate = XHPROF_RATE;
        $config->enableWriteReqLog = WRITE_REQUEST_LOG;
        $config->enableSecurityMap = SECURITY_MAP_ENABLE;
        $config->exceptionPage = VIEW_PATH . 'exception.php';

        $exceptionPageFile = VIEW_PATH . 'unit_test_exception_page.php';
        $exceptionPageSource = "<?php \n \n echo '111';";
        $writeRet = $this->writeWithLock($exceptionPageFile, $exceptionPageSource);
        $this->assertTrue($writeRet, $exceptionPageFile . " can not write");
        $config->exceptionPage = $exceptionPageFile;

        $_SERVER['REQUEST_URI'] = ROOT_URL . 'framework/feature/show_exception';
        $_SERVER['SCRIPT_NAME'] = '';
        ob_start();
        // 实例化开发框架对象
        $engine = parent::getFrameworkInstance($config);
        $engine->route();
        $output = ob_get_contents();
        $this->assertEquals('111', $output, $exceptionPageFile . " not used");
        unlink($exceptionPageFile);
        unset($config, $engine);
        ob_clean();
        ob_end_flush();
    }

    /**
     * @throws \Exception
     */
    public function testXhprof()
    {
        global $framework;

        $this->assertTrue(true, true);

        // 判断是否载入xhprof扩展
        if (!extension_loaded('xhprof')) {
            return;
        }

        // 创建开发框架配置
        $config = new \stdClass();
        $config->currentApp = APP_NAME;
        $config->appPath = APP_PATH;
        $config->appStatus = APP_STATUS;
        $config->enableTrace = ENABLE_TRACE;
        $config->xhprofRoot = APP_PATH . 'public/xhprof/';
        $config->enableXhprof = true;
        $config->xhprofRate = 1000;
        $config->enableWriteReqLog = WRITE_REQUEST_LOG;
        $config->enableSecurityMap = SECURITY_MAP_ENABLE;
        $config->exceptionPage = VIEW_PATH . 'exception.php';

        // 判断是否开启
        $this->assertTrue($config->enableXhprof, "Xhprof option should be enable");
        if (!$config->enableXhprof) {
            return;
        }

        if (!is_writable(STORAGE_PATH . 'xhprof')) {
            $this->fail("Xhprof path not writable");
            return;
        }

        if (!file_exists(APP_PATH . 'public/xhprof/')) {
            $this->fail("Path public/xhprof not exist");
            return;
        }
        // 删除之前的日志文件
        $child_dir = date('Y-m-d') . '/' . date('H');
        @mkdir(STORAGE_PATH . 'xhprof/' . $child_dir, 0777, true);
        @chown(STORAGE_PATH . 'xhprof/' . $child_dir, 'www');

        $_SERVER['REQUEST_URI'] = '/framework/feature/get_php_ini';
        $_SERVER['SCRIPT_NAME'] = '';
        ob_start();
        // 实例化开发框架对象
        //file_put_contents( './aaa.log', var_export($_SERVER,true) );
        $framework = parent::getFrameworkInstance($config);
        $framework->route();
        $output = ob_get_contents();

        $json = json_decode($output, true);
        if (!$json) {
            $this->fail("Response json not object:" . $output);
            return;
        }
        clearstatcache();
        if (!file_exists(STORAGE_PATH . 'xhprof/' . $child_dir)) {
            $this->fail("Xhprof child path {$child_dir} not exist");
            return;
        }

        $cmd = "find " . STORAGE_PATH . 'xhprof/' . $child_dir . "  -name '*framework_get_php_ini.xhprof'";
        exec($cmd, $retval);
        //file_put_contents( './exeStr.log', $cmd." \n".var_export($exeStr,true).var_export($retval,true) );
        if (count($retval) <= 0) {
            $this->fail("Xhprof log file not exist");
        }

        unset($config, $framework);
        ob_end_clean();
    }

    /**
     * Teardown 执行后执行此方法
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }
}
