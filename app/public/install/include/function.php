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


function step3(&$install_error, &$install_recover)
{
    global $html_title, $html_header, $html_footer;
    if ($_POST['submitform'] != 'submit') {
        return;
    }
    $db_host = $_POST['db_host'];
    $db_port = $_POST['db_port'];
    $db_user = $_POST['db_user'];
    $db_pwd = $_POST['db_pwd'];
    $db_name = $_POST['db_name'];
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

    if ($mysqli->get_server_info() > '5.0') {
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
    $sitepath = strtolower(substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')));
    $sitepath = str_replace('install', "", $sitepath);
    $auto_site_url = strtolower('http://' . $_SERVER['HTTP_HOST'] . $sitepath);
    writeDbConfig($auto_site_url);
    writeAppConfig($auto_site_url);
    writeCacheConfig(true);

    $_charset = strtolower(DBCHARSET);
    $mysqli->select_db($db_name);
    $mysqli->set_charset($_charset);
    $sql = file_get_contents("data/main.sql");
    //判断是否安装测试数据
    if ($_POST['demo_data'] == '1') {
        $sql .= file_get_contents("data/demo.sql");
    }
    $sql = str_replace("\r\n", "\n", $sql);
    runSql($sql, $db_prefix, $mysqli);
    showJsMessage('初始化数据 ... 成功 ');

    /**
     * 转码
     */
    $sitename = $_POST['site_name'];
    $username = $_POST['admin'];
    $password = $_POST['password'];
    $openid = md5($username.time());
    /**
     * 产生随机的md5_key，来替换系统默认的md5_key值
     */
    //$md5_key = md5(random(4).substr(md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'].$db_host.$db_user.$db_pwd.$db_name.substr(time(), 0, 6)), 8, 6).random(10));
    //$mysqli->query("UPDATE {$db_prefix}setting SET value='".$sitename."' WHERE name='site_name'");

    //管理员账号密码
    $pwd = password_hash($password, PASSWORD_DEFAULT);
    $mysqli->query("INSERT INTO `user_main` (`phone`, `username`, `openid`, `status`, `first_name`, `last_name`, `display_name`, `email`, `password`, `sex`, `birthday`, `create_time`,`is_system`) VALUES ( '190000000', '{$username}', '{$openid}', '1', 'Master', NULL, 'Master', NULL, '$pwd', '0', NULL, UTC_TIMESTAMP(),'1');");

    //测试数据
    if ($_POST['demo_data'] == '1') {
        $sql = file_get_contents("data/demo.sql");
        runSql($sql, $db_prefix, $mysqli);
    }
    //新增一个标识文件，用来屏蔽重新安装
    $fp = @fopen('lock', 'wb+');
    @fclose($fp);
    exit("<script type=\"text/javascript\">document.getElementById('install_process').innerHTML = '安装完成，下一步...';document.getElementById('install_process').href='index.php?step=5&sitename={$sitename}&username={$username}&password={$password}';</script>");
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
    //var_dump($ret);
}

/**
 * @param $url
 */
function writeAppConfig($url)
{
    $appFile = ROOT_PATH . '/../config/deploy/app.cfg.php';
    $appContent = file_get_contents($appFile);
    $appContent = preg_replace('/define\s*\(\s*\'ROOT_URL\'\s*,\s*\'([^\']+)\'\);/m', "define('ROOT_URL', '".$url."');", $appContent);
    file_put_contents($appFile, $appContent);
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

    $redisConfig = [$_POST['redis_host'], $_POST['redis_port'], $_POST['redis_dbname']];
    $_config['redis']['data'] = $redisConfig;
    $_config['redis']['data'] = $redisConfig;
    $_config['enable'] = (bool)$enable;

    file_put_contents($redisFile, "<?php \n" . '$_config = ' . var_export($_config, true) . ";\n" . 'return $_config;');
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
        $item_path = '/' . $item['path'];
        if ($item['type'] == 'dir') {
            if (!dir_writeable(ROOT_PATH . $item_path)) {
                if (is_dir(ROOT_PATH . $item_path)) {
                    $dirfile_items[$key]['status'] = 0;
                    $dirfile_items[$key]['current'] = '+r';
                } else {
                    $dirfile_items[$key]['status'] = -1;
                    $dirfile_items[$key]['current'] = 'nodir';
                }
            } else {
                $dirfile_items[$key]['status'] = 1;
                $dirfile_items[$key]['current'] = '+r+w';
            }
        } else {
            if (file_exists(ROOT_PATH . $item_path)) {
                if (is_writable(ROOT_PATH . $item_path)) {
                    $dirfile_items[$key]['status'] = 1;
                    $dirfile_items[$key]['current'] = '+r+w';
                } else {
                    $dirfile_items[$key]['status'] = 0;
                    $dirfile_items[$key]['current'] = '+r';
                }
            } else {
                if ($fp = @fopen(ROOT_PATH . $item_path, 'wb+')) {
                    $dirfile_items[$key]['status'] = 1;
                    $dirfile_items[$key]['current'] = '+r+w';
                    @fclose($fp);
                    @unlink(ROOT_PATH . $item_path);
                } else {
                    $dirfile_items[$key]['status'] = -1;
                    $dirfile_items[$key]['current'] = 'nofile';
                }
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

    $host = $_POST['db_host'];
    $user = $_POST['db_user'];
    $password = $_POST['db_pwd'];
    $db_name = $_POST['db_name'];
    $port = $_POST['db_port'];

    $dsn = "mysql:dbname={$db_name};host={$host};port={$port}";
    try {
        new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        $ret['ret'] = 0;
        $ret['msg'] = 'Mysql连接失败';
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

    $host = $_POST['redis_host'];
    $port = $_POST['redis_port'];
    if (!extension_loaded("redis")) {
        $ret['ret'] = 405;
        $ret['msg'] = 'Redis扩展未安装';
        return $ret;
    }
    try {
        $redis = new \Redis();
        $connectRet = $redis->connect($host, $port);
        if(!$connectRet){
            $ret['ret'] = 500;
            $ret['msg'] = '连接错误,'.strval($connectRet);
            return $ret;
        }
    } catch (\RedisException $e) {
        $ret['ret'] = 501;
        $ret['msg'] = '连接异常,'.$e->getMessage();
        return $ret;
    }
    return $ret;
}

