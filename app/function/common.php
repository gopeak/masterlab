<?php


function unit_set($key)
{

    return false;
}

function getConfigVar($file)
{
    $_config = [];
    $_file = APP_PATH . 'config/' . APP_STATUS . '/' . $file . '.cfg.php';

    if (file_exists($_file)) {
        include $_file;
    } else {
        if (APP_STATUS == 'development') {
            include APP_PATH . 'config/development/' . $file . '.cfg.php';
        } else {
            include APP_PATH . 'config/deploy/' . $file . '.cfg.php';
        }
    }
    return $_config;
}

/**
 * 获取通用的配置
 * @param $file
 * @return array
 */
function getCommonConfigVar($file)
{
    $_config = [];

    $absFile = APP_PATH . 'config/' . $file . '.cfg.php';

    if (file_exists($absFile)) {
        include $absFile;
    }
    return $_config;
}

/**
 * 判断是否来自微信
 * @return bool
 */
function is_weixin()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}

/**
 * 价格格式化，四舍五入的方式
 * @param $price              价格，纯数字形式
 * @param int $decimals 规定多少个小数
 * @param null $format 单位换算，如输入数字10000，则换算为XX万，null则表示不进行单位换算
 * @param string $separator 千位分隔符，空字符则不显示分隔符.
 * @return bool|string
 */
function price_format($price, $decimals = 2, $format = null, $separator = "")
{
    if (!is_numeric($price)) {
        return false;
    }
    if (!empty($format) && !is_integer($format)) {
        return false;
    }

    $unit = "";
    if ($format != null) {
        $cnygrees = array("拾", "佰", "仟", "万", "拾万", "佰万", "仟万", "亿");
        $price = round($price / $format, $decimals);
        $index = 0;
        $quotient = $format / 10;
        while ($quotient >= 10) {
            $quotient /= 10;
            $index++;
        }
        $unit = $cnygrees[$index];
    }

    return number_format($price, $decimals, '.', $separator) . $unit;
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('safeFilter')) {
    /**
     * 防注入和XSS攻击通用过滤
     * @param $arr
     */
    function safeFilter(&$arr)
    {
        $ra = array(
            '/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/',
            '/script/',
            '/javascript/',
            '/vbscript/',
            '/expression/',
            '/applet/',
            '/meta/',
            '/xml/',
            '/blink/',
            '/link/',
            '/style/',
            '/embed/',
            '/object/',
            '/frame/',
            '/layer/',
            '/title/',
            '/bgsound/',
            '/base/',
            '/onload/',
            '/onunload/',
            '/onchange/',
            '/onsubmit/',
            '/onreset/',
            '/onselect/',
            '/onblur/',
            '/onfocus/',
            '/onabort/',
            '/onkeydown/',
            '/onkeypress/',
            '/onkeyup/',
            '/onclick/',
            '/ondblclick/',
            '/onmousedown/',
            '/onmousemove/',
            '/onmouseout/',
            '/onmouseover/',
            '/onmouseup/',
            '/onunload/'
        );
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (!is_array($value)) {
                    //json格式不进行转义
                    if (is_json($value)) {
                        continue;
                    }
                    //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
                    if (!get_magic_quotes_gpc()) {
                        //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
                        $value = addslashes($value);
                    }
                    //删除非打印字符，粗暴式过滤xss可疑字符串
                    $value = preg_replace($ra, '', $value);
                    //去除 HTML 和 PHP 标记并转换为 HTML 实体
                    $arr[$key] = htmlentities(strip_tags($value));
                } else {
                    safeFilter($arr[$key]);
                }
            }
        }
    }
}

if (!function_exists('price')) {
    /**
     * 价格格式化
     * 个位数逢4,7加一
     *
     * @param double $price
     * @return int
     */
    function price($price)
    {
        if (!is_integer($price)) {
            $price = intval($price);
        }

        $num = substr((string)$price, -1);
        if ($num == 4 || $num == 7) {
            $price++;
        }
        return $price;
    }
}

/**
 * @param $vars
 * @param bool $output
 * @param bool $show_trace
 * @return string
 */
function dump($vars, $output = false, $show_trace = false)
{

    if (true == $show_trace) {
        $content = htmlspecialchars(print_r($vars, true));
    } else {
        $content = "<div align=left><pre>\n" . htmlspecialchars(print_r($vars, true)) . "\n</pre></div>\n";
    }
    if (true != $output) {
        return $content;
    } // 直接返回，不输出。
    echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head><body>{$content}</body></html>";
}

if (!function_exists('closeResources')) {
    /**
     * close resources
     */
    function closeResources()
    {
        if (isset($GLOBALS['global_pdo']) && !empty($GLOBALS['global_pdo'])) {
            foreach ($GLOBALS['global_pdo'] as $k => &$pdo) {
                $GLOBALS['global_pdo'][$k] = NULL;
                unset($pdo);
                unset($GLOBALS['global_pdo'][$k]);
            }
        }
        if (function_exists('get_resources')) {

            $res_types = [
                'curl' => 'curl_close',
                'gd' => 'imagedestroy',
                'imap' => 'imap_close',
                'pdf' => 'PDF_close',
                'shmop' => 'shmop_close',
                'stream' => 'fclose',
                'xml' => 'xml_parser_free',
                'zlib' => 'gzclose',
                'pdf' => 'PDF_close',

            ];
            foreach ($res_types as $res_name => $close_function) {
                if (!function_exists($close_function)) {
                    break;
                }
                $resources = get_resources($res_name);
                if (!empty($resources)) {
                    foreach ($resources as $res) {
                        @$close_function($res);
                    }
                }
            }

        }
        //f(TMP_PATH.'/get_resources.log',var_export( get_resources(), true ));
    }
}