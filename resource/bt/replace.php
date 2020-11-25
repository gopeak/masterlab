<?php

$searchArr = [];
list($flag, $phpBin) = get_php_bin_dir();
$searchArr['{{php_exe}}'] = $phpBin;
$searchArr['{{root_path}}'] = $rootPath = str_replace('\\','/', realpath('./') );

$tplFile = $rootPath . '/config.yml';
$tplContent = file_get_contents($tplFile);
$content = str_replace(array_keys($searchArr), array_values($searchArr), $tplContent);
$ret = file_put_contents($tplFile, $content);

/**
 * 获取php命令行程序的绝对路径
 * @return array
 */
function get_php_bin_dir()
{
    if (substr(strtolower(PHP_OS), 0, 3) == 'win') {
        $ini = ini_get_all();
        $path = $ini['extension_dir']['local_value'];
        $b = substr($path, 0, -3);
        $phpPath = str_replace('\\', '/', $b);
        $realPath = $phpPath . 'php.exe';

        if (strpos($realPath, 'ephp.exe') !== FALSE) {
            $realPath = str_replace('ephp.exe', 'php.exe', $realPath);
        }
        $cmd = $realPath . " -r var_export(true);";
    } else {
        $realPath = PHP_BINDIR . '/php';
        $cmd = $realPath . " -r 'var_export(true);'";
    }

    $lastLine = @exec($cmd);
    return [$lastLine == 'true', $realPath];
}
