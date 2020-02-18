<?php


/**
 * 格式化时间戳为中文时间格式
 * @param int $formatTime 时间戳
 * @param int $startTime 起始时间
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

    $time = $startTime - $formatTime;
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


/**
 *  计算两个时间的工作日,手工设置假期的日期和额外的工作日
 * @example $holidays=array("2008-12-25","2008-12-26","2009-01-01");getWorkingDays("2008-11-22","2009-01-02",$holidays);
 *
 * @param $startDate
 * @param $endDate
 * @param $holidays
 * @return float|int
 */
function getWorkingDays($startDate,$endDate,$holidays, $addDays=[]){
    // do strtotime calculations just once
    $endUnixTime = strtotime($endDate);
    $startUnixTime = strtotime($startDate);

    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endUnixTime - $startUnixTime) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startUnixTime);
    $the_last_day_of_week = date("N", $endUnixTime);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
    $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
        $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startUnixTime <= $time_stamp && $time_stamp <= $endUnixTime && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }
    foreach($addDays as $dayDay){
        $time_stamp=strtotime($dayDay);
        //If the holiday doesn't fall in weekend
        if ($startUnixTime <= $time_stamp && $time_stamp <= $endUnixTime )
            $workingDays++;
    }

    return $workingDays;
}


