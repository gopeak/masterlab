<?php

namespace main\lib;

class Log
{
    public static function insertLog($type, $msg, $module = '')
    {
        if (!is_string($msg)) {
            $msg = json_encode($msg);
        }
        $dateTime = date('Y-m-d H:i:s');
        $line = "[{$dateTime}] [$type] [$module] {$msg}\n";
        $fileName = date('Y-m-d') . '.log';
        file_put_contents(STORAGE_PATH . 'log/business/' . $fileName, $line, FILE_APPEND);
    }

    public static function debug($msg, $module = '')
    {
        self::insertLog(__FUNCTION__, $msg, $module);
    }


    public static function warn($msg, $module = '')
    {
        self::insertLog(__FUNCTION__, $msg, $module);
    }

    public static function error($msg, $module = '')
    {
        self::insertLog(__FUNCTION__, $msg, $module);
    }

    public static function notice($msg, $module = '')
    {
        self::insertLog(__FUNCTION__, $msg, $module);
    }

    public static function fatal($msg, $module = '')
    {
        self::insertLog(__FUNCTION__, $msg, $module);

    }
}
