<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/21 0021
 * Time: 下午 8:06
 */





function get_func_argNames($funcName) {
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
    $val = strtolower( trim($val) );
    if(empty($val))return 0;


    preg_match('#([0-9]+)[\s]*([a-z]+)#i', $val, $matches);

    $last = '';
    if(isset($matches[2])){
        $last = $matches[2];
    }

    if(isset($matches[1])){
        $val = (int) $matches[1];
    }
    switch ( $last )
    {
        case 'M': case 'm': return (int)$val * 1048576;
        case 'K': case 'k': return (int)$val * 1024;
        case 'G': case 'g': return (int)$val * 1073741824;
        default: return 0;
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

    switch (strtolower($b))
    {
        case '1':
        case 'on':
        case 'yes':
        case 'true':
            return 'assert.active' !== $a;

        case 'stdout':
        case 'stderr':
            return 'display_errors' === $a;

        default:
            return (bool) (int) $b;
    }
}
