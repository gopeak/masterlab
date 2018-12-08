<?php

/**
 * @param $str
 * @return int
 */
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

    /*
    $msg = $_SERVER['REQUEST_URI'] . '生成原action [' . $action . '] - [' . $token_name . '] token=' . $_SESSION[$action][$token_name] . ' 加密字符串=' . $encrypt . ', 解密字符串=' .
        encrypt($encrypt, 'DECODE', ENCRYPT_KEY);
    file_put_contents(DEBUG_LOG . 'encrypt_msg.txt', $msg . "\n", FILE_APPEND);
    */
    return $encrypt;
}

/**
 * 验证csrf_token是否有效
 * @param $csrf_token
 * @param string $token_name
 * @param string $action
 * @return bool
 */
function checkCsrfToken($csrf_token, $token_name = '_token', $action = 'default')
{
    // 解密
    $csrfTokenSessionString = encrypt($csrf_token, 'DECODE', ENCRYPT_KEY);

    if ( isset($_SESSION[$action][$token_name]) && $_SESSION[$action][$token_name] == $csrfTokenSessionString) {
        return true;
    } else {
        return false;
    }
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

function quickRandomStr($length = 16)
{
    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

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
    $runtokey = $key_length ? ($operation == 'ENCODE' ? substr(md5(microtime(true)), -$key_length) : substr($string, 0,
        $key_length)) : '';
    $keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
    $string = $operation == 'ENCODE' ? sprintf('%010d',
            $expiry ? $expiry + time() : 0) . substr(md5($string . $egiskeys), 0,
            16) . $string : base64_decode(substr($string, $key_length));

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
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0)
            && substr($result, 10, 16) == substr(md5(substr($result, 26) . $egiskeys), 0, 16)) {
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
                $i--;
            }
        }
        return $ret_str;
    }
}

/**
 * 蛇形字符串转驼峰字符串 issue_type -> issueType
 * @param $str
 * @return mixed
 */
function underlineToUppercase($str)
{
    $fnc = function ($matches) {
        return strtoupper($matches[1]);
    };
    $str = preg_replace_callback('/_+([a-z])/', $fnc, $str);
    return $str;
}

/**
 * 取汉字的第一个字的首字母
 * @param string $str
 * @return string|null
 */
function getFirstChar($str)
{
    if (empty($str)) {
        return '';
    }

    $fir = $fchar = ord($str[0]);
    if ($fchar >= ord('A') && $fchar <= ord('z')) {
        return strtoupper($str[0]);
    }

    $s1 = @iconv('UTF-8', 'gb2312', $str);
    $s2 = @iconv('gb2312', 'UTF-8', $s1);
    $s = $s2 == $str ? $s1 : $str;
    if (!isset($s[0]) || !isset($s[1])) {
        return '';
    }

    $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;

    if (is_numeric($str)) {
        return $str;
    }

    if (($asc >= -20319 && $asc <= -20284) || $fir == 'A') {
        return 'A';
    }
    if (($asc >= -20283 && $asc <= -19776) || $fir == 'B') {
        return 'B';
    }
    if (($asc >= -19775 && $asc <= -19219) || $fir == 'C') {
        return 'C';
    }
    if (($asc >= -19218 && $asc <= -18711) || $fir == 'D') {
        return 'D';
    }
    if (($asc >= -18710 && $asc <= -18527) || $fir == 'E') {
        return 'E';
    }
    if (($asc >= -18526 && $asc <= -18240) || $fir == 'F') {
        return 'F';
    }
    if (($asc >= -18239 && $asc <= -17923) || $fir == 'G') {
        return 'G';
    }
    if (($asc >= -17922 && $asc <= -17418) || $fir == 'H') {
        return 'H';
    }
    if (($asc >= -17417 && $asc <= -16475) || $fir == 'J') {
        return 'J';
    }
    if (($asc >= -16474 && $asc <= -16213) || $fir == 'K') {
        return 'K';
    }
    if (($asc >= -16212 && $asc <= -15641) || $fir == 'L') {
        return 'L';
    }
    if (($asc >= -15640 && $asc <= -15166) || $fir == 'M') {
        return 'M';
    }
    if (($asc >= -15165 && $asc <= -14923) || $fir == 'N') {
        return 'N';
    }
    if (($asc >= -14922 && $asc <= -14915) || $fir == 'O') {
        return 'O';
    }
    if (($asc >= -14914 && $asc <= -14631) || $fir == 'P') {
        return 'P';
    }
    if (($asc >= -14630 && $asc <= -14150) || $fir == 'Q') {
        return 'Q';
    }
    if (($asc >= -14149 && $asc <= -14091) || $fir == 'R') {
        return 'R';
    }
    if (($asc >= -14090 && $asc <= -13319) || $fir == 'S') {
        return 'S';
    }
    if (($asc >= -13318 && $asc <= -12839) || $fir == 'T') {
        return 'T';
    }
    if (($asc >= -12838 && $asc <= -12557) || $fir == 'W') {
        return 'W';
    }
    if (($asc >= -12556 && $asc <= -11848) || $fir == 'X') {
        return 'X';
    }
    if (($asc >= -11847 && $asc <= -11056) || $fir == 'Y') {
        return 'Y';
    }
    if (($asc >= -11055 && $asc <= -10247) || $fir == 'Z') {
        return 'Z';
    }

    return '';
}

/**
 * 根据项目key来定义颜色
 */
function mapKeyColor($key)
{
    $ascii = ord(strtoupper($key));
    if ($ascii >= 65 && $ascii < 70) {
        return 'F3E5F5';
    } elseif ($ascii >= 70 && $ascii < 75) {
        return 'FFEBEE';
    } elseif ($ascii >= 75 && $ascii < 78) {
        return 'E8EAF6';
    } elseif ($ascii >= 78 && $ascii < 85) {
        return 'E3F2FD';
    } elseif ($ascii >= 85 && $ascii < 90) {
        return 'E0F2F1';
    } else {
        return 'EEEEEE';
    }
}

if (!function_exists('safeStr')) {
    /**
     * request param filter
     * @param string $str
     * @return string
     */
    function safeStr($str)
    {
        if (!empty($str) && is_string($str)) {
            return str_replace(array(
                '\\',
                "\0",
                "\n",
                "\r",
                "'",
                '"',
                "\x1a"
            ), array(
                '\\\\',
                '\\0',
                '\\n',
                '\\r',
                "\\'",
                '\\"',
                '\\Z'
            ), $str);
        }

        return $str;
    }
}