<?php


function input(&$data)
{
    foreach ((array)$data as $key => $value) {
        if (is_string($value)) {
            if (!get_magic_quotes_gpc()) {
                $value = htmlentities($value, ENT_NOQUOTES);
                $value = addslashes(trim($value));
            }
        } else {
            $data[$key] = input($value);
        }
    }
}


function importSql(&$install_error, &$install_recover)
{
    global $html_title, $html_header, $html_footer;
    if ($_POST['submitform'] != 'submit') {
        return;
    }
    $db_host = trimString($_POST['db_host']);
    $db_port = trimString($_POST['db_port']);
    $db_user = trimString($_POST['db_user']);
    $db_pwd = trimString($_POST['db_pwd']);
    $db_name = trimString($_POST['db_name']);
    $db_prefix = $_POST['db_prefix'];
    $admin = $_POST['admin'];
    $password = $_POST['password'];
    if (!$db_host || !$db_port || !$db_user || !$db_name || !$admin || !$password) {
        $install_error = '输入不完整，请检查';
    }
    if (strpos($db_prefix, '.') !== false) {
        $install_error .= '数据表前缀为空，或者格式错误，请检查';
    }

    if (strlen($admin) > 15 || preg_match("/^$|^c:\\con\\con$|　|[,\"\s\t\<\>&]|^游客|^Guest/is", $admin)) {
        $install_error .= '非法用户名，用户名长度不应当超过 15 个英文字符，且不能包含特殊字符，一般是中文，字母或者数字';
    }
    if ($install_error != '') {
        return;
    }
    $mysqli = @ new mysqli($db_host, $db_user, $db_pwd, '', $db_port);
    if ($mysqli->connect_error) {
        $install_error = '数据库连接失败';
        return;
    }

    if (floatval($mysqli->get_server_info()) > 5.0) {
        $mysqli->query("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET " . DBCHARSET);
    } else {
        $install_error = '数据库必须为MySQL5.0版本以上';
        return;
    }
    if ($mysqli->error) {
        $install_error = $mysqli->error;
        return;
    }
    if ($_POST['install_recover'] != 'yes' && ($query = $mysqli->query("SHOW TABLES FROM $db_name"))) {
        while ($row = mysqli_fetch_array($query)) {
            if (preg_match("/^$db_prefix/", $row[0])) {
                $install_error = '数据表已存在，继续安装将会覆盖已有数据';
                $install_recover = 'yes';
                return;
            }
        }
    }

    require('step_4.php');
    $http_type = (
        (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
    ) ? 'https://' : 'http://';
    $sitepath = strtolower(substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));
    $sitepath = str_replace('install', "", $sitepath);
    $auto_site_url = strtolower($http_type . $_SERVER['HTTP_HOST'] . $sitepath);
    $auto_site_url = substr($auto_site_url, -1) == '/' ? $auto_site_url : $auto_site_url . '/';
    writeDbConfig();
    writeAppConfig($auto_site_url);
    writeCacheConfig(true);
    writeSocketConfig();
    $ret = file_put_contents(ROOT_PATH . '/../../env.ini', "APP_STATUS = deploy\n");
    showJsMessage("env.ini文件写入结果:" . $ret);

    $_charset = strtolower(DBCHARSET);
    $mysqli->select_db($db_name);
    $mysqli->set_charset($_charset);
    $sql = file_get_contents("data/main.sql");
    //判断是否安装测试数据
    if ($_POST['demo_data'] == '1') {
        $sql .= file_get_contents("data/demo.sql");
    }
    // 执行全文索引sql
    if (floatval($mysqli->get_server_info()) >= 5.7) {
        $sql .= file_get_contents("data/fulltext-5.7.sql");
    } else {
        $sql .= file_get_contents("data/fulltext-5.6.sql");
    }

    $sql = str_replace("\r\n", "\n", $sql);
    runSql($sql, $db_prefix, $mysqli);
    $mysqli->query("COMMIT;");
    /**
     * 转码
     */
    $siteSame = $_POST['site_name'];
    $linkman = $_POST['linkman'];
    $phone = $_POST['phone'];
    // $username = $_POST['admin'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // 管理员账号密码
    $pwd = password_hash($password, PASSWORD_DEFAULT);
    $adminSql = "UPDATE `user_main`  SET is_system=1, `password` = '{$pwd}',phone='{$phone}',email='{$email}' WHERE `uid` =1";
    $mysqli->query($adminSql);
    $mysqli->query("COMMIT;");

    // 更改配置
    $mysqli->query("UPDATE `main_setting` SET `_value` = '{$siteSame}' WHERE  `_key` = 'company'");
    $mysqli->query("UPDATE `main_setting` SET `_value` = '{$siteSame}' WHERE  `_key` = 'title'");
    $mysqli->query("UPDATE `main_setting` SET `_value` = '{$linkman}' WHERE `_key` = 'company_linkman'");
    $mysqli->query("UPDATE `main_setting` SET `_value` = '{$phone}' WHERE `_key` = 'company_phone'");
    $mysqli->query("COMMIT;");

    // 测试数据
    if ($_POST['demo_data'] == '1') {
        $sql = file_get_contents("data/demo.sql");
        runSql($sql, $db_prefix, $mysqli);
        $mysqli->query("COMMIT;");
    }
    showJsMessage('初始化数据 ... 成功 ');


    //新增一个标识文件，用来屏蔽重新安装
    $fp = @fopen('lock', 'wb+');
    @fclose($fp);
    exit("<script type=\"text/javascript\">document.getElementById('install_process').innerHTML = '安装完成，下一步...';document.getElementById('install_process').href='index.php?step=5';</script>");
    exit();
}


//execute sql
function runSql($sql, $db_prefix, $mysqli)
{
    if (!isset($sql) || empty($sql)) {
        return;
    }
    $sql = str_replace("\r", "\n", str_replace('#__', $db_prefix, $sql));
    $ret = array();
    $num = 0;
    foreach (explode(";\n", trim($sql)) as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        foreach ($queries as $query) {
            $ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0] . $query[1] == '--') ? '' : $query;
        }
        $num++;
    }
    unset($sql);
    foreach ($ret as $query) {
        $query = trim($query);
        if ($query) {
            if (substr($query, 0, 12) == 'CREATE TABLE') {
                $line = explode('`', $query);
                $data_name = $line[1];
                showJsMessage('数据表  ' . $data_name . ' ... 创建成功');
                $mysqli->query(droptable($data_name));
                $mysqli->query($query);
                unset($line, $data_name);
            } else {
                $mysqli->query($query);
            }
        }
    }
}


//抛出JS信息
function showJsMessage($message)
{
    echo '<script type="text/javascript">showmessage(\'' . addslashes($message) . ' \');</script>' . "\r\n";
    flush();
    ob_flush();
}

//写入config文件
function writeDbConfig()
{
    //var_dump($url);
    //extract($GLOBALS, EXTR_SKIP);
    $_config = [];
    $dbFile = ROOT_PATH . '/../config/deploy/database.cfg.php';
    if (file_exists($dbFile)) {
        include $dbFile;
    }

    $db_type = 'mysql';
    $mysqlConfig = array(
        'driver' => $db_type,
        'host' => $_POST['db_host'],
        'port' => $_POST['db_port'],
        'user' => $_POST['db_user'],
        'password' => $_POST['db_pwd'],
        'db_name' => $_POST['db_name'],
        'charset' => 'utf8',
        'timeout' => 10,
        'show_field_info' => false,
    );
    $_config['database']['default'] = $mysqlConfig;
    $_config['database']['framework_db'] = $mysqlConfig;
    $_config['database']['log_db'] = $mysqlConfig;

    $ret = file_put_contents($dbFile, "<?php \n" . '$_config=' . var_export($_config, true) . ";\n" . 'return $_config;');
    showJsMessage("数据库文件配置写入结果:" . $ret);
}

/**
 * @param $url
 */
function writeAppConfig($url)
{
    $appFile = ROOT_PATH . '/../config/deploy/app.cfg.php';
    $appContent = file_get_contents($appFile);
    $appContent = preg_replace('/define\s*\(\s*\'ROOT_URL\'\s*,\s*\'([^\']*)\'\);/m', "define('ROOT_URL', '" . $url . "');", $appContent);
    $ret = file_put_contents($appFile, $appContent);
    showJsMessage("主配置文件写入结果:" . $ret);
}

/**
 * @param bool $enable
 */
function writeCacheConfig($enable = false)
{
    $_config = [];
    $redisFile = ROOT_PATH . '/../config/deploy/cache.cfg.php';
    if (file_exists($redisFile)) {
        include $redisFile;
    }
    $redisHost = trimString($_POST['redis_host']);
    $redisPort = trimString($_POST['redis_port']);
    $redisPassword = trimString($_POST['redis_password']);
    $redisConfig = [[$redisHost, $redisPort,$redisPassword]];
    $_config['redis']['data'] = $redisConfig;
    $_config['redis']['session'] = $redisConfig;
    $_config['enable'] = (bool)$enable;

    $ret = file_put_contents($redisFile, "<?php \n" . '$_config = ' . var_export($_config, true) . ";\n" . 'return $_config;');
    showJsMessage("缓存配置文件写入结果:" . $ret);
}

function writeSocketConfig()
{
    $tplFile = ROOT_PATH . '/../../bin/config-tpl.toml';
    $tplContent = file_get_contents($tplFile);
    $searchArr = [];
    $searchArr['{{db}}'] = trimString($_POST['db_name']);
    $searchArr['{{host}}'] = trimString($_POST['db_host']);
    $searchArr['{{port}}'] =trimString( $_POST['db_port']);
    $searchArr['{{user}}'] = trimString($_POST['db_user']);
    $searchArr['{{password}}'] = trimString($_POST['db_pwd']);
    $searchArr['{{redis_host}}'] = trimString($_POST['redis_host']);
    $searchArr['{{redis_port}}'] = trimString($_POST['redis_port']);
    $searchArr['{{redis_password}}'] = trimString($_POST['redis_password']);
    $content = str_replace(array_keys($searchArr), array_values($searchArr), $tplContent);
    $ret = file_put_contents(ROOT_PATH . '/../../bin/config.toml', $content);
    showJsMessage("MasterlabSocket config.toml 文件写入结果:" . (bool)$ret);

    $tplFile = ROOT_PATH . '/../../bin/cron-tpl.json';
    $tplContent = file_get_contents($tplFile);
    $preAppPath = realpath(ROOT_PATH. '/../../') . "/";
    $searchArr = [];
    $searchArr['{{exe_bin}}'] = $_POST['php_bin'];
    $searchArr['{{root_path}}'] = str_replace('\\','/',$preAppPath );
    $content = str_replace(array_keys($searchArr), array_values($searchArr), $tplContent);
    $ret = file_put_contents(ROOT_PATH . '/../../bin/cron.json', $content);
    showJsMessage("MasterlabSocket cron.json 文件写入结果:" . (bool)$ret);
}

/**
 * environmental check
 */
function env_check(&$env_items)
{
    $env_items[] = array('name' => '操作系统', 'min' => '无限制', 'good' => 'linux', 'cur' => PHP_OS, 'status' => 1);
    $env_items[] = array('name' => 'PHP版本', 'min' => '5.6', 'good' => '7.1', 'cur' => PHP_VERSION, 'status' => (PHP_VERSION < 5.6 ? 0 : 1));
    $tmp = function_exists('gd_info') ? gd_info() : array();
    preg_match("/[\d.]+/", $tmp['GD Version'], $match);
    unset($tmp);
    $env_items[] = array('name' => 'GD库', 'min' => '2.0', 'good' => '2.0', 'cur' => $match[0], 'status' => ($match[0] < 2 ? 0 : 1));
    $env_items[] = array('name' => '附件上传', 'min' => '未限制', 'good' => '8M', 'cur' => ini_get('upload_max_filesize'), 'status' => 1);
    $short_open_tag = strtolower(ini_get('short_open_tag'));
    if ($short_open_tag == '1' || $short_open_tag == 'on') {
        $short_open_tag = 'on';
    } else {
        $short_open_tag = 'off';
    }
    $short_open_tag_status = $short_open_tag == 'on' ? 1 : 0;
    $env_items[] = array('name' => '短标记 short_open_tag', 'min' => 'on', 'good' => 'on', 'cur' => $short_open_tag, 'status' => $short_open_tag_status);
    $disk_place = function_exists('disk_free_space') ? floor(disk_free_space(ROOT_PATH) / (1024 * 1024)) : 0;
    $env_items[] = array('name' => '磁盘空间', 'min' => '200M', 'good' => '>500M', 'cur' => empty($disk_place) ? '未知' : $disk_place . 'M', 'status' => $disk_place < 200 ? 0 : 1);
}

/**
 * file check
 */
function dirfile_check(&$dirfile_items)
{
    foreach ($dirfile_items as $key => $item) {
        if ($item['type'] == 'dir') {
            if (dir_writeable($item['path'])) {
                $dirfile_items[$key]['status'] = 1;
                $dirfile_items[$key]['current'] = '+r+w';
            } else {
                $dirfile_items[$key]['status'] = 0;
                $dirfile_items[$key]['current'] = '+r';
            }
        } else {
            if (!file_exists($item['path']) || !is_writable($item['path'])) {
                $dirfile_items[$key]['status'] = 0;
                $dirfile_items[$key]['current'] = '';
            } else {
                $dirfile_items[$key]['status'] = 1;
                $dirfile_items[$key]['current'] = '+r+w';
            }
        }
    }
}

/**
 * dir is writeable
 * @return number
 */
function dir_writeable($dir)
{
    $writeable = 0;
    if (!is_dir($dir)) {
        @mkdir($dir, 0755);
    } else {
        @chmod($dir, 0755);
    }
    if (is_dir($dir)) {
        if ($fp = @fopen("$dir/test.txt", 'w')) {
            @fclose($fp);
            @unlink("$dir/test.txt");
            $writeable = 1;
        } else {
            $writeable = 0;
        }
    }
    return $writeable;
}

/**
 * function is exist
 */
function function_check(&$func_items)
{
    $func = array();
    foreach ($func_items as $key => $item) {
        $func_items[$key]['status'] = function_exists($item['name']) ? 1 : 0;
    }
}

function extension_check(&$extension_items)
{
    $func = array();
    foreach ($extension_items as $key => $item) {
        $extension_items[$key]['status'] = extension_loaded($item['name']) ? 1 : 0;
    }
}

/**
 * @param $msg
 */
function show_msg($msg)
{
    global $html_title, $html_header, $html_footer;
    include 'step_msg.php';
    exit();
}

//make rand
function random($length, $numeric = 0)
{
    $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * drop table
 */
function droptable($table_name)
{
    return "DROP TABLE IF EXISTS `" . $table_name . "`;";
}

/**
 * @return array
 */
function check_mysql()
{
    error_reporting(E_ERROR);
    $ret = array();
    $ret['ret'] = 200;
    $ret['msg'] = '';

    $host = trimString($_POST['db_host']);
    $user = trimString($_POST['db_user']);
    $password = trimString($_POST['db_pwd']);
    $db_name = trimString($_POST['db_name']);
    $port = trimString($_POST['db_port']);

    $dsn = "mysql:host={$host};port={$port}";
    try {
        new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        $ret['ret'] = 0;
        $ret['msg'] = 'Mysql连接失败,请检查连接配置';
        return $ret;
    }
    return $ret;
}

/**
 * @return array
 */
function check_redis()
{
    error_reporting(E_ERROR);
    $ret = array();
    $ret['ret'] = 200;
    $ret['msg'] = '';

    $host = trimString($_POST['redis_host']);
    $port = trimString($_POST['redis_port']);
    $pwd = trimString($_POST['redis_password']);
    if (!extension_loaded("redis")) {
        $ret['ret'] = 405;
        $ret['msg'] = 'Redis扩展未安装';
        return $ret;
    }
    try {
        $redis = new \Redis();
        $connectRet = $redis->connect($host, $port);
        if ($pwd != "") {
            $redis->auth($pwd);
        }
        if (!$connectRet) {
            $ret['ret'] = 500;
            $ret['msg'] = 'Redis服务连接失败,请启动服务或检查配置.' . mb_convert_encoding($connectRet, 'utf-8', 'gbk');
            return $ret;
        }
    } catch (\Exception $e) {
        $ret['ret'] = 501;
        $ret['msg'] = 'Redis服务连接异常,原因:' . mb_convert_encoding($e->getMessage(), 'utf-8', 'gbk');
        return $ret;
    }
    return $ret;
}

function check_socket()
{
    error_reporting(E_ERROR);
    $ret = array();
    $ret['ret'] = 200;
    $ret['msg'] = '';

    $host = $_POST['socket_host'];
    $port = $_POST['socket_port'];

    ignore_user_abort(TRUE);
    $fp = fsockopen($host, $port, $errno, $errstr, 10);
    if (!$fp) {
        $ret['ret'] = 500;
        $ret['msg'] = 'Matserlab_Socket连接失败,请启动或检查配置.:' . mb_convert_encoding($errno . " " . $errstr, 'utf-8', 'gbk');
        return $ret;
    }

    return $ret;
}

/**
 * 获取php命令行程序的绝对路径
 * @return array
 */
function get_php_bin_dir()
{
    if (substr(strtolower(PHP_OS), 0, 3) == 'win') {
        $ini = ini_get_all();
        $path = $ini['extension_dir']['local_value'];
        $b = substr($path, 0, -3);
        $phpPath = str_replace('\\', '/', $b);
        $realPath = $phpPath . 'php.exe';

        if (strpos($realPath, 'ephp.exe') !== FALSE) {
            $realPath = str_replace('ephp.exe', 'php.exe', $realPath);
        }
        $cmd = $realPath . " -r var_export(true);";
    } else {
        $realPath = PHP_BINDIR . '/php';
        $cmd = $realPath . " -r 'var_export(true);'";
    }

    $lastLine = exec($cmd);
    return [$lastLine == 'true', $realPath];
}


function trimString($str)
{
    $str = trim($str);
    $ret_str = '';
    for ($i = 0; $i < strlen($str); $i++) {
        if (substr($str, $i, 1) != " ") {
            $ret_str .= trim(substr($str, $i, 1));
        } else {
            while (substr($str, $i, 1) == " ") {
                $i++;
            }
            $ret_str .= " ";
            $i--;
        }
    }
    return $ret_str;
}