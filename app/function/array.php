<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/9 0009
 * Time: 下午 4:22
 */


/**
 * 使用特定function对数组中所有元素做处理
 * @param array $array  要处理的字符串
 * @param string $function  要执行的函数
 * @param bool $apply_to_keys_also 是否也应用到key上
 */
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }

        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

/**
 * 将数组转换为JSON字符串（兼容中文）
 * @param $array 要转换的数组
 * @return string 转换得到的json字符串
 */
function arr2json($array)
{
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}
