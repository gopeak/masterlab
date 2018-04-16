<?php

function abslength($str)
{
    if (empty($str)) {
        return 0;
    }
    if (function_exists('mb_strlen')) {
        return mb_strlen($str, 'utf-8');
    } else {
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}


/**
 * 设置防止csrf攻击的token，系统为每个用户分配随机的token
 * @author jesen
 */
function csrfToken($token_name = '_token', $action = 'default')
{
    $_SESSION[$action][$token_name] = quickRandom(16);
    $encrypt = encrypt($_SESSION[$action][$token_name], 'ENCODE', ENCRYPT_KEY);

    $msg = $_SERVER['REQUEST_URI'] . '生成原action [' . $action . '] - [' . $token_name . '] token=' . $_SESSION[$action][$token_name] . ' 加密字符串=' . $encrypt . ', 解密字符串=' .
        encrypt($encrypt, 'DECODE', ENCRYPT_KEY);
    file_put_contents(DEBUG_LOG . 'encrypt_msg.txt', $msg . "\n", FILE_APPEND);

    return $encrypt;
}

/**
 * 生成随机字符串
 * @param number $length
 */
function randomToken($length = 16, $is_page_token = false, $token_name = 'page_token', $action = 'default')
{
    $string = '';

    if (!function_exists('random_bytes')) {
        $string = quickRandom($length);
        return $string;
    }

    while (($len = strlen($string)) < $length) {
        $size = $length - $len;

        $bytes = random_bytes($size);

        $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
    }

    if ($is_page_token) {
        $_SESSION[$action][$token_name] = $string;
    }

    return $string;
}

/**
 * 简单的随机字符串
 * @param number $length
 */
function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
}

/**
 * 双向加密解密函数
 * @param string $string 待加密字符串
 * @param string $operation ENCODE 加密， DECODE 解密
 * @param string $key 加密key
 * @param number $expiry 过期时间
 */
function encrypt($string, $operation = 'ENCODE', $key = '', $expiry = 0)
{
    if ($operation == 'DECODE') {
        $string = str_replace('_', '/', $string);
        $string = str_replace('#', ' ', $string);
    }
    $key_length = 4;

    $fixedkey = md5($key);
    $egiskeys = md5(substr($fixedkey, 16, 16));
    $runtokey = $key_length ? ($operation == 'ENCODE' ? substr(md5(microtime(true)), -$key_length) : substr($string, 0, $key_length)) : '';
    $keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
    $string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));

    $i = 0;
    $result = '';
    $string_length = strlen($string);
    for ($i = 0; $i < $string_length; $i++) {
        $result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
    }
    if ($operation == 'ENCODE') {
        $retstrs = str_replace('=', '', base64_encode($result));
        $retstrs = str_replace('/', '_', $retstrs);
        $retstrs = str_replace(' ', '#', $retstrs);
        return $runtokey . $retstrs;
    } else {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $egiskeys), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    }
}


function pwd_strength($str)
{
    $score = 0;
    if (preg_match("/[0-9]+/", $str)) {
        $score++;
    }
    if (preg_match("/[0-9]{3,}/", $str)) {
        $score++;
    }
    if (preg_match("/[a-z]+/", $str)) {
        $score++;
    }
    if (preg_match("/[a-z]{3,}/", $str)) {
        $score++;
    }
    if (preg_match("/[A-Z]+/", $str)) {
        $score++;
    }
    if (preg_match("/[A-Z]{3,}/", $str)) {
        $score++;
    }
    if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/", $str)) {
        $score += 2;
    }
    if (preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/", $str)) {
        $score++;
    }
    if (strlen($str) >= 10) {
        $score++;
    }
    return $score;
}


function is_phone($phone)
{
    return preg_match('/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|70)\d{8}$/', $phone);
}

function wrapBlank($string)
{
    return sprintf(" %s ", $string);
}

/**
 * 判断是否数字0，区别于null、空串.
 * @param $value
 * @return bool
 */
function isZero($value)
{
    $value = trim($value);
    return is_numeric($value) && ($value == 0);
}

if (!function_exists('is_json')) {
    /**
     * 判断是否json格式
     *
     * @param $string
     * @return bool
     */
    function is_json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
if (!function_exists('trimStr')) {
    function trimStr($str)
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
                $i--; // ***
            }
        }
        return $ret_str;
    }
}