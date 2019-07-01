<?php


/**
 * 格式化时间戳为中文时间格式
 * @param int $formatTime 时间戳
 * @param int $startTime  起始时间
 * @param string $formatSystem 系统设置的时间格式key  datetime_format|time_format|week_format|full_datetime_format
 * @return false|string
 * @throws Exception
 */
function format_unix_time($formatTime, $startTime = 0, $formatSystem = 'full_datetime_format')
{
    $formatTime = intval($formatTime);
    $startTime = intval($startTime);
    if (empty($startTime)) {
        $startTime = time();
    }
    if (empty($formatTime)) {
        return '';
    }
    if (empty($formatSystem)) {
        $formatSystem = 'full_datetime_format';
    }
    $str_time = '';
    $settingLogic = new \main\app\classes\SettingsLogic();

    if ($formatSystem == 'time_format') {
        return date($settingLogic->timeFormat(), $formatTime);
    }
    if ($formatSystem == 'week_format') {
        return date($settingLogic->weekFormat(), $formatTime);
    }
    if ($formatSystem == 'full_datetime_format') {
        return date($settingLogic->fullDatetimeFormat(), $formatTime);
    }

    $time = $startTime-$formatTime;
    if ($time >= 86400) {
        return $str_time = date($settingLogic->datetimeFormat(), $formatTime);
    }
    if ($time >= 3600) {
        $str_time .= intval($time / 3600) . '小时';
        $time = $time % 3600;
    } else {
        $str_time .= '';
    }
    if ($time >= 60) {
        $str_time .= intval($time / 60) . '分钟';
        $time = $time % 60;
    } else {
        $str_time .= '';
    }
    if ($time > 0) {
        $str_time .= intval($time) . '秒前';
    } else {
        $str_time = "";
    }
    return $str_time;
}

function is_online($update_time)
{
    if ((time() - $update_time) < 16) {
        return true;
    }
    return false;
}

if (!function_exists('msectime')) {
    //获取当前毫秒数
    function msectime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }
}
