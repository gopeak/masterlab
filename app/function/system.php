<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/21 0021
 * Time: 下午 8:06
 */


function get_func_argNames($funcName)
{
    $f = new ReflectionFunction($funcName);
    $result = array();
    foreach ($f->getParameters() as $param) {
        $result[] = $param->name;
    }
    return $result;
}


/**
 * 获取已经加载的php.ini配置项的值并转换为byte值
 * @param $val
 * @return int
 */
function return_bytes($val)
{
    $val = strtolower(trim($val));
    if (empty($val)) {
        return 0;
    }


    preg_match('#([0-9]+)[\s]*([a-z]+)#i', $val, $matches);

    $last = '';
    if (isset($matches[2])) {
        $last = $matches[2];
    }

    if (isset($matches[1])) {
        $val = (int)$matches[1];
    }
    switch ($last) {
        case 'M':
        case 'm':
            return (int)$val * 1048576;
        case 'K':
        case 'k':
            return (int)$val * 1024;
        case 'G':
        case 'g':
            return (int)$val * 1073741824;
        default:
            return 0;
    }
}

/**
 * 获取已经加载的php.ini配置项的值并转换为bool
 * @param $a
 * @return bool
 */
function ini_get_bool($a)
{
    $b = ini_get($a);

    switch (strtolower($b)) {
        case '1':
        case 'on':
        case 'yes':
        case 'true':
            return 'assert.active' !== $a;

        case 'stdout':
        case 'stderr':
            return 'display_errors' === $a;

        default:
            return (bool)(int)$b;
    }
}


function uInt32($i, $endianness = false)
{
    $i = intval($i);
    if ($endianness === true) {  // big-endian
        $i = pack("N", $i);
    } else if ($endianness === false) {  // little-endian
        $i = pack("V", $i);
    } else if ($endianness === null) {  // machine byte order
        $i = pack("L", $i);
    }

    return is_array($i) ? $i[1] : $i;
}

function mbstrlen($str)
{
    $len = strlen($str);

    if ($len <= 0) {
        return 0;
    }

    $count = 0;

    for ($i = 0; $i < $len; $i++) {
        $count++;
        if (ord($str{$i}) >= 0x80) {
            $i += 2;
        }
    }

    return $count;
}

