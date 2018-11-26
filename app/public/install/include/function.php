<?php

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

function check_mysql()
{
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