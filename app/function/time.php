<?php

/**
 *
 * @param string $date
 * @return bool
 */
function is_datetime_format($date = '2020-04-16')
{
    if (date('Y-m-d H:i:s', strtotime($date)) == $date) {
        return true;
    }
    return false;
}

/**
 * 格式化时间戳为中文时间格式
 * @param int $formatTime 时间戳
 * @param int $startTime 起始时间
 * @param string $formatSystem 系统设置的时间格式key  datetime_format|time_format|week_format|full_datetime_format|app_week_format
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

    if (isApp()) {
        $formatSystem = 'app_week_format';
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

    $time = $startTime - $formatTime;
    if ($time >= 86400) {
        if ($formatSystem == 'app_week_format' && $formatTime > strtotime('-1 week')) {
            $weekNumArr = array('日', '一', '二', '三', '四', '五', '六');
            return '星期' . $weekNumArr[date('w', $formatTime)];
        }
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


/**
 *  计算两个时间的工作日, 同时计算手工设置假期的日期和额外的工作日
 * @example
 * $startDate = '2020-03-03';
 * $endDate = '2020-03-22';
 * $holidays = ['2020-03-12','2020-03-13'];
 * $addDays = ['2020-03-08','2020-03-13'];
 * var_dump(getWorkingDays($startDate,$endDate));
 * var_dump(getWorkingDays($startDate,$endDate,$holidays));
 * var_dump(getWorkingDays($startDate,$endDate,$holidays,$addDays));
 * @param $startDate
 * @param $endDate
 * @param $workDates
 * @param $holidays
 * @param $addDays
 * @return float|int
 */
function getWorkingDays($startDate, $endDate, $workDates, $holidays = [], $addDays = [])
{
    if ($startDate == '000-00-00' || $endDate == '000-00-00') {
        return 0;
    }
    if(!is_array($workDates)){
        $workDates = json_decode($workDates, true);
    }
    if(is_null($workDates)){
        $workDates = [1,2,3,4,5];
    }
    $startUnixTime = strtotime($startDate);
    $endUnixTime = strtotime($endDate);

    if ($startUnixTime <= strtotime('1970-01-01')) {
        return 0;
    }
    if ($endUnixTime <= strtotime('1970-01-01')) {
        return 0;
    }

    // 截止时间大于起始时间则返回0
    if ($startUnixTime > $endUnixTime) {
        return 0;
    }
    // 截止日期大于10年之后将不会计算,返回0
    if ($endUnixTime > (time() + 86400 * 365 * 10)) {
        return 0;
    }
    $days = intval(($endUnixTime - $startUnixTime) / 86400) + 1;
    //echo "intval(( {$endUnixTime} - {$startUnixTime}) / 86400) + 1\n";
    //var_dump($days);
    $dateArr = [];
    $finalDays = $days;
    for ($i = 0; $i < $days; $i++) {
        $time = (int)$startUnixTime + $i * 24 * 3600 + 1;
        $date = date('Y-m-d', $time);
        $week = date('w', $time);
        $dateArr[] = $date;
        if (!in_array($date, $addDays)) {
            // 节假日不算
            if (in_array($date, $holidays) ) {
                $finalDays--;
            }else{
                if (!in_array($week, $workDates) ) {
                    $finalDays--;
                }
            }
        }
    }
    return $finalDays;
}


