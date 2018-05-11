<?php

require_once TEST_PATH . 'BaseTestCase.php';

/**
 * xphp测试类
 * Class testFramework
 */
class testFramework extends BaseTestCase
{

    public static $clean = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 每个测试都会执行的动作
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
    }

    /**
     * 测试开发框架的路由访问
     */
    public function testRoute()
    {
        // 请求控制器 是否可访问
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/route');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        if ($curl->rawResponse != 'route') {
            $this->fail('expect response page,but get ' . $curl->rawResponse);
        }

        $curl->get(ROOT_URL . '/framework_mod_test/framework/route');
        if ($curl->httpStatusCode != 200) {
            $this->fail('route mod expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        if ($curl->rawResponse != 'route') {
            $this->fail('route mod expect response page,but get ' . $curl->rawResponse);
        }

        // 请求Api 是否可访问
        $curl->get(ROOT_URL . '/api/framework/route');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        $json = json_decode($curl->rawResponse);
        if (!isset($json->ret) || $json->ret != '200') {
            $this->fail('expect response json\' ret 200,but get ' . $curl->rawResponse);
        }
        $curl->get(ROOT_URL . '/api/framework_mod_test/framework/route');
        $json = json_decode($curl->rawResponse);
        if (!isset($json->ret) || $json->ret != '200') {
            $this->fail('expect response json\' ret 200,but get ' . $curl->rawResponse);
        }
        if ($json->data != 'route') {
            $this->fail('route mod test expect json\s data is route,but get ' . $curl->rawResponse);
        }
    }

    /**
     * 测试伪静态参数
     */
    public function testArg()
    {
        // 请求控制器 是否可访问
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/arg/121');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        // 获取参数
        $json = json_decode($curl->rawResponse);
        if (!isset($json->data) || $json->data[2] != '121') {
            $this->fail('expect response json\' data 121,but get ' . $curl->rawResponse);
        }
    }

    /**
     * 测试异常
     */
    public function notestException()
    {
        // 抛出异常,捕获 Exception 关键字
        $curl = new \Curl\Curl();
        parent::_get($curl, ROOT_URL . '/framework/show_exception');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        if (!preg_match('/Exception/', $curl->rawResponse)) {
            $this->fail('expect response show Exception,but not match: ' . $curl->rawResponse);
        }

        // 是否返回异常结果
        parent::_get($curl, ROOT_URL . '/api/framework/show_exception');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        $json = json_decode($curl->rawResponse);
        if ($json->ret == '200') {
            $this->fail('expect response json\' ret not  200,but get ' . $curl->rawResponse);
        }

        if (!isset($json->data->key) || !isset($json->data->value)) {
            $this->fail('expect response json\'has key and value ,but get ' . $curl->rawResponse);
        }
    }

    /**
     * 测试sql注入
     */
    public function testSqlInject()
    {
        $curl = new \Curl\Curl();
        $post_data['username'] = "13002510000' or '1'='1 ";
        $post_data['pwd'] = "121";
        $json = $curl->post(ROOT_URL . "framework/sql_inject?format=json", $post_data);

        if (empty($json)) {
            $this->fail('testSqlInject fail ,response: ' . $curl->rawResponse);
            return;
        }

        if ($json->ret != '0') {
            $this->fail('sql inject success, very danger !,response: ' . $curl->rawResponse);
        }
    }

    /**
     * 测试Sql注入  $name_evil = "'; DELETE FROM customers WHERE 1 or username = '";
     */
    public function testSqlInjectDelete()
    {
        $curl = new \Curl\Curl();
        $url = ROOT_URL . "framework/sql_inject_delete?format=json";
        $post_data['phone'] = "13002510000'  ; DELETE FROM xphp_user;Select * From `test_user` WHERE 1 or phone = '";
        $curl->post($url, $post_data);
        $json = json_decode($curl->rawResponse);

        if (empty($json)) {
            $this->fail('testSqlInject fail ,response: ' . $curl->rawResponse);
        }
        if ($json->ret != '0') {
            $this->fail('sql inject success, very danger !,response: ' . $curl->rawResponse);
        }
    }

    /**
     * 测试会话
     */
    public function testSession()
    {
        $curl = new \Curl\Curl();
        $curl->setCookieFile('testSession.cookie');
        parent::_get($curl, ROOT_URL . "framework/session_step1", [], true);
        $json = parent::_get($curl, ROOT_URL . "framework/session_step2", [], true);

        if (!isset($json['data']['test_session1']) || empty($json['data']['test_session1'])) {
            $this->fail('testSession fail ,decode json null ,response:' . $curl->rawResponse);
        }
    }


    // 测试分库功能
    public function testSplitDatabase()
    {
        // 先创建模型,使用的是default数据库配置
        $model_default = 'UnitTestDefaultModel';
        $write_ret = parent::createModelFile($model_default);
        if (!$write_ret) {
            $this->fail(MODEL_PATH . $model_default . '.php' . " can not write");
            return;
        }

        // 先创建模型,使用的是 unit_test_db  数据库配置
        $model_unit = 'UnitTestUnitModel';
        $write_ret = parent::createModelFile($model_unit);
        if (!$write_ret) {
            $this->fail(MODEL_PATH . $model_unit . '.php' . " can not write");
            return;
        }

        // 更改配置,多库设置
        $db_config = getConfigVar('database');
        $db_config['database']['log_db'] = $db_config['database']['default'];
        $db_config['config_map_class']['log_db'][] = $model_unit;

        $new_config_source = "<?php \n " . '$_config = ' . var_export($db_config,
                true) . ";\n\n" . 'return $_config;' . "\n";

        $file = APP_PATH . 'config/' . APP_STATUS . '/database.cfg.php';
        $origin_database_source = $this->readWithLock($file);

        $w_ret = $this->writeWithLock($file, $new_config_source);

        if ($w_ret !== false) {
            require_once MODEL_PATH . 'BaseModel.php';
            require_once MODEL_PATH . 'DbModel.php';
            require_once MODEL_PATH . $model_default . '.php';
            require_once PRE_APP_PATH.'/lib/MyPdo.php';
            $model_default_class = sprintf("main\\%s\\model\\%s", APP_NAME, $model_default);
            if (!class_exists($model_default_class)) {
                $this->fail('class ' . $model_default_class . ' no found');
            }

            $model_default_obj = new $model_default_class();
            $model_default_obj->realConnect();

            require_once MODEL_PATH . $model_unit . '.php';
            $model_class_class = sprintf("main\\%s\\model\\%s", APP_NAME, $model_unit);
            if (!class_exists($model_class_class)) {
                $this->fail('class ' . $model_class_class . ' no found');
            }
            $model_unit_obj = new $model_class_class();
            $model_unit_obj->realConnect();
            if ($model_unit_obj->db->pdo == $model_default_obj->db->pdo) {
                $this->writeWithLock($file, $origin_database_source);
                unlink(MODEL_PATH . $model_default . '.php');
                unlink(MODEL_PATH . $model_unit . '.php');
                $this->fail("SplitDatabase feature failed " . $model_default_obj->configName . ' equal ' . $model_unit_obj->configName . ' ');
            }
            $this->writeWithLock($file, $origin_database_source);

        }
        unlink(MODEL_PATH . $model_default . '.php');
        unlink(MODEL_PATH . $model_unit . '.php');
    }

    /**
     * 测试Ajax 返回格式
     */
    public function testValidAjaxJson()
    {
        if (!ENABLE_REFLECT_METHOD) {
            return;
        }
        // 故意返回错误的格式
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/framework/not_expect_json');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '600') {
            $this->fail('expect response ret is 600,but get: ' . $json->ret);
        }
        // 返回正确的格式
        $curl->get(ROOT_URL . '/framework/expect_json');
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '200') {
            $this->fail('expect response ret is 200,but get: ' . $json->ret);
        }

        // 故意返回错误的复杂格式
        $curl->get(ROOT_URL . '/framework/not_expect_mix_json');
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '600') {
            $this->fail('expect response ret is 600,but get: ' . $json->ret);
        }

        // 返回正确的复杂格式
        $curl->get(ROOT_URL . '/framework/expect_mix_json');
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '200') {
            $this->fail('expect response ret is 200,but get: ' . $json->ret);
        }

    }

    /**
     * 测试返回值格式
     */
    public function testValidApiJson()
    {
        if (!ENABLE_REFLECT_METHOD) {
            return;
        }
        // 故意返回错误的格式
        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL . '/api/framework/not_expect_json');
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '600') {
            $this->fail('expect response ret is 600,but get: ' . $json->ret);
        }
        // 返回正确的格式
        $curl->get(ROOT_URL . '/api/framework/expect_json');
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '200') {
            $this->fail('expect response ret is 200,but get: ' . $json->ret);
        }

        // 故意返回错误的复杂格式
        $curl->get(ROOT_URL . '/api/framework/not_expect_mix_json');
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '600') {
            $this->fail('expect response ret is 600,but get: ' . $json->ret);
        }

        // 返回正确的复杂格式
        $curl->get(ROOT_URL . '/api/framework/expect_mix_json');
        $json = json_decode($curl->rawResponse);
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json->ret !== '200') {
            $this->fail('expect response ret is 200,but get: ' . $json->ret);
        }
    }


// 测试文件服务器分离, 需要编写通用的上传代码
// 1.上传文件 2.通过返回的url返回文件是否存在


// 测试自定义的异常页面
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

        $exception_page_file = VIEW_PATH . 'unit_test_exception_page.php';
        $exception_page_source = "<?php \n \n echo '111';";
        $write_ret = $this->writeWithLock($exception_page_file, $exception_page_source);

        if ($write_ret === false) {
            $this->fail($exception_page_file . " can not write");
            return;
        }
        $config->exceptionPage = $exception_page_file;

        $_SERVER['REQUEST_URI'] = '/framework/show_exception';
        $_SERVER['SCRIPT_NAME'] = '';
        ob_start();
        // 实例化开发框架对象
        $engine = parent::getFrameworkInstance($config);
        $engine->route();
        $output = ob_get_contents();
        if ($output != '111') {
            $this->fail($exception_page_file . " not used");
        }
        unlink($exception_page_file);
        unset($config, $engine);
        ob_end_flush();
    }

    public function testXhprof()
    {
        global $framework;
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
        $config->enableReflectMethod = ENABLE_REFLECT_METHOD;

        // 判断是否开启
        if (!$config->enableXhprof) {
            $this->fail("Xhprof option should be enable");
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

        $_SERVER['REQUEST_URI'] = '/framework/get_php_ini';
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
     * 测试结束后清理动作
     */
    public function tearDown()
    {
    }


    /**
     * Teardown 执行后执行此方法
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }
}