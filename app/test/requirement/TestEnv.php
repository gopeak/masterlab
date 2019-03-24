<?php

namespace main\app\test\requirement;

use main\app\test\BaseTestCase;

/**
 *
 * @version    php v7.1.1
 * @link
 */
class TestEnv extends BaseTestCase
{

    public static $clean = [];

    public static $mysqlVersion = 0;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * 测试php版本
     * @throws \Exception
     */
    public function testPhpVersion()
    {
        $expectVersion = '5.6.0';
        $failMsg = "expect php version >={$expectVersion},but get " . PHP_VERSION;
        $this->assertTrue(version_compare(PHP_VERSION, $expectVersion, '>='), $failMsg);
    }

    /**
     * 测试php.ini
     * @throws \Exception
     */
    public function testPhpIni()
    {
        $inis = [
            'session.auto_start',
            'session.use_cookies',
            'short_open_tag',
            'upload_max_filesize',
            'post_max_size',
            'memory_limit',
            'max_execution_time'
        ];
        $req['inis'] = json_encode($inis);
        $curl = new \Curl\Curl();
        $curl->post(ROOT_URL . 'framework/feature/get_php_ini?data_type=json', $req);
        $ret = json_decode($curl->rawResponse);
        $this->assertTrue(isset($ret->data), 'get php ini value failed, response: ' . $curl->rawResponse);
        $iniData = $ret->data;

        $this->assertContains($iniData->session_auto_start, ['0', 'off', 0, 'false'], 'session.auto_start not 0 ');

        $sessionUseCookies = $iniData->session_use_cookies;
        $this->assertContains($sessionUseCookies, ['1', 'on', 'true'], 'php.ini session.use_cookies not open ');

        // 要求打开短标记
        $this->assertContains($iniData->short_open_tag, ['1', 'on', 'true'], 'php.ini short_open_tag not open ');

        // 要求上传限制为8M
        $limit8m = return_bytes($iniData->upload_max_filesize) >= (1048576 * 8);
        $this->assertTrue($limit8m, 'expect php.ini upload_max_filesize> 8M,but get ' . $iniData->upload_max_filesize);

        // post大小要求大于8M
        $requirePost8m = return_bytes($iniData->post_max_size) >= (1048576 * 8);
        $this->assertTrue($requirePost8m, 'expect php.ini post_max_size> 8M,but get ' . $iniData->post_max_size);

        // 每个php进程限制32M以上
        $requirePhp128m = return_bytes($iniData->memory_limit) >= (1048576 * 32);
        $this->assertTrue($requirePhp128m, 'expect php.ini memory_limit >32M , but get ' . $iniData->memory_limit);

        // 最大执行时间 30S,命令行模式下为0
        $maxExecTime = intval($iniData->max_execution_time);
        $requireMaxExecTime = $maxExecTime <= 0 || $maxExecTime >= 30;
        $this->assertTrue($requireMaxExecTime, ' expect php.ini max_execution_time 30s, but get ' . $maxExecTime);
    }

    /**
     * 需要加载的扩展
     * @throws \Exception
     */
    public function testExtension()
    {
        $requireExtensions = [
            'curl',
            'redis',
            'gd',
            'hash',
            'json',
            'mbstring',
            'mysqlnd',
            'pcre',
            'PDO',
            'pdo_mysql',
            'Reflection',
            'session'
        ];

        foreach ($requireExtensions as $ext) {
            $this->assertTrue(extension_loaded($ext), 'require extension: ' . $ext);
        }
    }

    /**
     * 测试目录存在性
     * @throws \Exception
     */
    public function testExistsPath()
    {
        // 由于执行单元测试执行的系统用户和 web php进程的系统用户执行不是同一个，只能通过请求接口判断目录写入性
        $curl = new \Curl\Curl();
        $json = parent::curlGet($curl, ROOT_URL . '/framework/feature/validate_exists_dir?data_type=json', [], true);

        $httpCode = $curl->httpStatusCode;
        $this->assertEquals(200, $httpCode, 'expect response http code 200,but get ' . $httpCode);
        $this->assertJson($curl->rawResponse, 'expect response is json,but get: ' . $curl->rawResponse);
        $this->assertEquals('200', $json['ret'], 'expect response ret is 200,but get: ' . $json['ret']);
        $this->assertNotEmpty($json['data'], 'response json data is empty');
        $dirs = $json['data'];
        foreach ($dirs as $dir) {
            $this->assertTrue($dir['exists'], "dir {$dir['path']} not exist");
        }
    }

    public function testWritablePath()
    {
        // 由于执行单元测试执行的系统用户和 web php进程的系统用户执行不是同一个，只能通过请求接口判断目录写入性
        $curl = new \Curl\Curl();
        $json = parent::curlGet($curl, ROOT_URL . '/framework/feature/validate_writable_dir?data_type=json', [], true);

        $httpCode = $curl->httpStatusCode;
        $this->assertEquals(200, $httpCode, 'expect response http code 200,but get ' . $httpCode);
        $this->assertJson($curl->rawResponse, 'expect response is json,but get: ' . $curl->rawResponse);
        $this->assertEquals('200', $json['ret'], 'expect response ret is 200,but get: ' . $json['ret']);
        $this->assertNotEmpty($json['data'], 'response json data is empty');
        $dirs = $json['data'];
        foreach ($dirs as $dir) {
            $this->assertTrue($dir['exists'], "dir {$dir['path']} not exist");
            $this->assertTrue($dir['writable'], "dir {$dir['path']} not writable");
        }
    }

    /**
     * 测试 配置文件存在
     * @throws \Exception
     */
    public function testConfigFile()
    {
        $configDir = APP_PATH . 'config/' . APP_STATUS . DS;

        $configFile = $configDir . 'app.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');

        $_config = [];
        $configFile = $configDir . 'async.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'cache.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);


        $_config = [];
        $configFile = APP_PATH . 'config/' . 'common.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'database.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'data.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'error.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'mail.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = APP_PATH . 'config/' . 'map.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'queue' . '.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);


        $_config = [];
        $configFile = $configDir . 'server_status' . '.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $_config = [];
        $configFile = $configDir . 'session' . '.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
        include $configFile;
        $this->assertNotEmpty($_config);

        $configFile = $configDir . 'validation.cfg.php';
        $this->assertTrue(file_exists($configFile), $configFile . ' not exist');
    }

    /**
     * 测试网站域名是否可访问
     * @throws \Exception
     */
    public function testSiteUrl()
    {
        $curl = new  \Curl\Curl();
        $curl->setTimeout(10);
        $curl->setHeader('Cache-Control', 'no-store');

        $okCodes = [403, 302, 301, 200];
        $curl->get(ROOT_URL);
        $this->assertContains($curl->httpStatusCode, $okCodes);

        $curl->get(ATTACHMENT_URL);
        $this->assertContains($curl->httpStatusCode, $okCodes);
    }

    /**
     * 测试Mysql
     * @throws \Exception
     */
    public function testMysqlServer()
    {
        $dbConfigs = getConfigVar('database')['database'];
        foreach ($dbConfigs as $name => $dbConfig) {
            if ($name == 'default' && empty($dbConfig)) {
                $this->fail('database default config undefined');
            }
            if (!empty($dbConfig)) {
                // 检查配置
                $keys = ['driver', 'host', 'port', 'db_name', 'user', 'password', 'charset'];
                foreach ($keys as $key) {
                    $this->assertTrue(isset($dbConfig[$key]), "db_config {$key} undefined");
                }
                $this->assertEquals('mysql', $dbConfig['driver'], "database {$name} config's driver not mysql");

                $format = "%s:host=%s;port=%s;dbname=%s";
                $driver = $dbConfig['driver'];
                $host = $dbConfig['host'];
                $port = $dbConfig['port'];
                $db_name = $dbConfig['db_name'];
                $names = $dbConfig['charset'];
                $dsn = sprintf($format, $driver, $host, $port, $db_name);
                $params = [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$names}",
                    \PDO::ATTR_PERSISTENT => false,
                    \PDO::ATTR_TIMEOUT => 20
                ];
                try {
                    // 检查连接
                    $pdo = new \PDO($dsn, $dbConfig['user'], $dbConfig['password'], $params);
                    if (!$pdo) {
                        $this->fail('mysql err: connection failed');
                    }
                    // 检查版本
                    $sth = $pdo->prepare("select version() as v");
                    $sth->execute();
                    $version = $sth->fetch(\PDO :: FETCH_ASSOC)['v'];
                    self::$mysqlVersion = $v = floatval(substr($version, 0, 3));
                    if ($v < 5.5) {
                        $this->fail('mysql version require 5.5+ ,current version id ' . $version);
                    }
                    // 检查表引擎
                    $sth = $pdo->prepare("SHOW TABLE STATUS FROM " . $dbConfig['db_name']);
                    $sth->execute();
                    $tables = $sth->fetchAll(\PDO :: FETCH_ASSOC);
                    foreach ($tables as $tb) {
                        if (!empty($tb['Engine']) && strtolower($tb['Engine']) != 'innodb') {
                            $this->fail('table ' . $tb['Name'] . ' engine not InnoDB ');
                        }
                    }
                    $pdo = null;
                } catch (\PDOException $e) {
                    $this->fail('mysql err: ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * 测试Redis
     * @expectException \Exception
     */
    public function testRedisServer()
    {
        $redisConfig = getConfigVar('cache')['redis']['data'];
        try {
            $redis = new \Redis();
            foreach ($redisConfig as $info) {
                $redis->connect($info[0], $info[1]);
            }
            $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);

            $testKey = 'test_' . time();
            $testValue = time();
            $redis->set($testKey, $testValue);
            $this->assertEquals($testValue, $redis->get($testKey));
            $redis->delete($testKey);
            $redis->close();
        } catch (\Exception $e) {
            $this->fail('redis server err: ' . $e->getMessage());
        }
    }



    /**
     * 测试邮件发送服务器连通性
     * @throws \Exception
     */
    public function testMailServer()
    {
        $mailConfig = getConfigVar('mail');
        $host = $mailConfig['host'];
        $port = $mailConfig['port'];
        $timeout = $mailConfig['timeout'];
        $fp = @fsockopen($host, $port, $errNo, $errStr, $timeout);
        //var_dump($host,$port,$fp);
        $this->assertNotEmpty($fp, "Mail Cannot connect to {$host} : {$port},tip:{$errNo} $errStr");
        if ($fp) {
            fclose($fp);
        }
    }

    /**
     * 测试结束后清理动作
     */
    public function tearDown()
    {
    }

    /**
     * teardown执行后执行此方法
     */
    public static function tearDownAfterClass()
    {
        //var_dump( get_resources() );
        parent::tearDownAfterClass();
    }
}
