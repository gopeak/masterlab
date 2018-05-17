<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/9 0009
 * Time: 下午 4:22
 */

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
