<?php

function checkRegCommon($pattern, $response)
{
    preg_match_all($pattern, $response, $result, PREG_PATTERN_ORDER);
    $ret = [];
    if (!empty($result[0])) {
        $ret = $result[0];
    }
    return $ret;
}

function checkXdebugError($response)
{
    $pattern = '%>([^<]+)\s+on\s+line\s+<i>(\d+)</i>%m';
    return checkRegCommon($pattern, $response);
}

function checkXdebugUserError($response)
{
    $pattern = '%>([^<]+)\s+on\s+line\s+<i>(\d+)</i>%m';
    return checkRegCommon($pattern, $response);
}

function checkUserError($response)
{
    $pattern = '%<b>([^>]+)</b>:\s+([^>]+)in\s+<b>([^>]+)</b>\s+on\s+line\s+<b>(\d+)</b>%';
    return checkRegCommon($pattern, $response);
}

function checkXdebugTriggerError($response)
{
    $pattern = '%([^>]+):\s+([^>]+)in\s+([^>]+)\s+on\s+line\s+<i>(\d+)</i>%';
    return checkRegCommon($pattern, $response);
}

function checkTriggerError($response)
{
    $pattern = '%<b>([^>]+)</b>:\s+([^>]+)in\s+([^>]+):(\d+)%U';
    return checkRegCommon($pattern, $response);
}

function checkXdebugFatalError($response)
{
    $pattern = '%([^>]+):\s+([^>]+)in\s+([^>]+)\s+on\s+line\s+<i>(\d+)</i>%';
    return checkRegCommon($pattern, $response);
}

function checkFatalError($response)
{
    $pattern = '%<b>([^>]+)</b>:\s+([^>]+)in\s+([^>]+):(\d+)%U';
    return checkRegCommon($pattern, $response);
}

function checkXdebugUnDefine($response)
{
    $pattern = '%([^>]+):\s+([^>]+)in\s+([^>]+)\s+on\s+line\s+<i>(\d+)</i>%';
    return checkRegCommon($pattern, $response);
}

function checkUnDefine($response)
{
    $pattern = '%<b>([^>]+)</b>:\s+([^>]+)in\s+<b>([^>]+)</b>\s+on\s+line\s+<b>(\d+)</b>%';
    return checkRegCommon($pattern, $response);
}

function checkExceptionError($response)
{
    $pattern = '%<title>[^<]*Exception[^<]*</title>%U';
    return checkRegCommon($pattern, $response);
}
