<?php

namespace main\app\test\requirement;

use main\app\test\BaseAppTestCase;

/**
 *
 * @version    php v7.1.1
 * @link
 */
class TestEnv extends BaseAppTestCase
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
     * 测试php版本
     */
    public function testPhpVersion()
    {
        if (version_compare(PHP_VERSION, '7.0.0') == -1) {
            $this->fail('expect php version >=7.0.0,but get ' . PHP_VERSION);
        }
    }

    /**
     * 测试php.ini
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
        $curl->post(ROOT_URL . 'framework/get_php_ini', $req);
        $ret = json_decode($curl->rawResponse);
        if (!isset($ret->data)) {
            $this->fail('get php ini value failed, response: ' . $curl->rawResponse);
        }
        $inisData = $ret->data;

        $this->assertContains($inisData->session_auto_start, ['0', 'off', 0, 'false'], 'session.auto_start not 0 ');

        $sessionUseCookies = $inisData->session_use_cookies;
        $this->assertContains($sessionUseCookies, ['1', 'on', 'true'], 'php.ini session.use_cookies not open ');

        // 要求打开短标记
        $this->assertContains($inisData->short_open_tag, ['1', 'on', 'true'], 'php.ini short_open_tag not open ');

        // 要求上传限制为8M
        $limit8m = return_bytes($inisData->upload_max_filesize) >= (1048576 * 8);
        $this->assertTrue($limit8m, 'expect php.ini upload_max_filesize> 8M,but get ' . $inisData->upload_max_filesize);

        // post大小要求大于8M
        $requirePost8m = return_bytes($inisData->post_max_size) >= (1048576 * 8);
        $this->assertTrue($requirePost8m, 'expect php.ini post_max_size> 8M,but get ' . $inisData->post_max_size);

        // 每个php进程限制128M
        $requirePhp128m = return_bytes($inisData->memory_limit) >= (1048576 * 128);
        $this->assertTrue($requirePhp128m, 'expect php.ini memory_limit >128M , but get ' . $inisData->memory_limit);

        // 最大执行时间 30S,命令行模式下为0
        $maxExecTime = intval($inisData->max_execution_time);
        $requireMaxExecTime = $maxExecTime <= 0 || $maxExecTime >= 30;
        $this->assertTrue($requireMaxExecTime, ' expect php.ini max_execution_time 30s, but get ' . $maxExecTime);
    }

    /**
     * 需要加载的扩展
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
            'mcrypt',
            'mysqlnd',
            'pcre',
            'PDO',
            'pdo_mysql',
            'Reflection',
            'session'
        ];

        foreach ($requireExtensions as $ext) {
            $this->assertTrue(extension_loaded($ext), 'require extesions: ' . $ext);
        }
    }

    /**
     * 测试目录存在性
     */
    public function testPath()
    {
        // 由于执行单元测试执行的系统用户和 web php进程的系统用户执行不是同一个，只能通过请求接口判断目录写入性
        $curl = new \Curl\Curl();
        $json = parent::_get($curl, ROOT_URL . '/framework/feature/validate_dir', [], true);
        if ($curl->httpStatusCode != 200) {
            $this->fail('expect response http code 200,but get ' . $curl->httpStatusCode);
        }
        if (!$this->isJson($json)) {
            $this->fail('expect response is json,but get: ' . $curl->rawResponse);
        }
        if ($json['ret'] !== '200') {
            $this->fail('expect response ret is 200,but get: ' . $json['ret']);
        }

        if (empty($json['data'])) {
            $this->fail('response json data is empty  ');
        }
        $dirs = $json['data'];
        foreach ($dirs as $dir) {
            if (!$dir['exists']) {
                $this->fail('dir ' . $dir['path'] . ' not exist');
            }
            if (!$dir['writable']) {
                $this->fail('dir ' . $dir['path'] . ' not writable');
            }
        }
    }

    /**
     * 测试 配置文件存在
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
     */
    public function testMysqlServer()
    {

        $dbConfigs = getConfigVar('database')['database'];
        foreach ($dbConfigs as $name => $db_config) {
            if ($name == 'default' && empty($db_config)) {
                $this->fail('database default config undefined');
            }
            if (!empty($db_config)) {
                // 检查配置
                $keys = ['driver', 'host', 'port', 'db_name', 'user', 'password', 'charset'];

                foreach ($keys as $key) {
                    if (!isset($db_config[$key])) {
                        $this->fail('db_config ' . $key . ' undefined');
                    }
                }
                if ($db_config['driver'] != 'mysql') {
                    $this->fail('database ' . $name . ' config\'s driver not mysql');
                }
                $dsn = sprintf("%s:host=%s;port=%s;dbname=%s",
                    $db_config['driver'], $db_config['host'], $db_config['port'], $db_config['db_name']);
                $names = $db_config['charset'];
                $params = [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$names}",
                    \PDO::ATTR_PERSISTENT => false,
                    \PDO::ATTR_TIMEOUT => 10
                ];
                try {
                    // 检查连接
                    $pdo = new \PDO($dsn, $db_config['user'], $db_config['password'], $params);
                    if (!$pdo) {
                        $this->fail('mysql err: connection failed');
                    }
                    // 检查版本
                    $sth = $pdo->prepare("select version() as v");
                    $sth->execute();
                    $version = $sth->fetch(\PDO :: FETCH_ASSOC)['v'];
                    $v = floatval(substr($version, 0, 3));
                    if ($v < 5.5) {
                        $this->fail('mysql version require 5.5+ ,current version id ' . $version);
                    }
                    // 检查表引擎
                    $sth = $pdo->prepare("SHOW TABLE STATUS FROM " . $db_config['db_name']);
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

            $test_key = 'test_' . time();
            $test_value = time();
            $redis->set($test_key, $test_value);
            $this->assertEquals($test_value, $redis->get($test_key));
            $redis->delete($test_key);
            $redis->close();
        } catch (\Exception $e) {
            $this->fail('redis server err: ' . $e->getMessage());
        }
    }


    /**
     * 测试邮件发送服务器连通性
     */
    public function testMailServer()
    {
        $mail_config = getConfigVar('mail');
        $fp = @fsockopen($mail_config['host'], $mail_config['port']);
        if (!$fp) {
            $this->fail('Mil  Cannot conect to ' . $mail_config['host'] . ':' . $mail_config['port']);
        } else {
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
