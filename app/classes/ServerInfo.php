<?php
namespace main\app\classes;

/**
 * 服务器信息探测
 * @package main\app\classes
 */
class ServerInfo
{
    public static function memoryUsage()
    {
        $memory = (!function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
        return $memory;
    }

    /**
     * 计时
     * @return mixed
     */
    public static function microtimeFloat()
    {
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        return $mtime[1] + $mtime[0];
    }

    /**
     * 获取域名
     * @return mixed
     */
    public static function getDomain()
    {
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * 当前 PHP 脚本所有者名称
     * @return string
     */
    public static function getLocalServerUser()
    {
        return @get_current_user();
    }

    /**
     * 获取服务器IP
     * @return mixed|string
     */
    public static function getLocalIp()
    {
        if ('/' == DIRECTORY_SEPARATOR) {
            return $_SERVER['SERVER_ADDR'];
        } else {
            return @gethostbyname($_SERVER['SERVER_NAME']);
        }
    }

    /**
     * 获取服务器端口
     * @return mixed
     */
    public static function getLocalPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * 获取服务器主机名
     * @return mixed
     */
    public static function getLocalHostName()
    {
        $os = explode(" ", php_uname());
        if ('/' == DIRECTORY_SEPARATOR) {
            return $os[1];
        } else {
            return $os[2];
        }
    }

    /**
     * 获取服务器语言
     * @return array|false|string
     */
    public static function getLocalLang()
    {
        return getenv("HTTP_ACCEPT_LANGUAGE");
    }

    /**
     * 获取服务器操作系统及内核
     * @return string
     */
    public static function getSysOS()
    {
        $os = explode(" ", php_uname());
        if ('/' == DIRECTORY_SEPARATOR) {
            $kernel = $os[2];
        } else {
            $kernel = $os[1];
        }

        return $os[0] . '  内核版本：' . $kernel;
    }

    /**
     * 获取Web服务器解译引擎  nginx/1.14.0
     * @return mixed
     */
    public static function getWebEngine()
    {
        return $_SERVER['SERVER_SOFTWARE'];
    }

    /**
     * PHP已加载的模块
     * @return array
     */
    public static function getPHPLoadedExt()
    {
        $extList = get_loaded_extensions();
        return $extList;
    }
}
