<?php

define('VIEW_TWIG_PATH', realpath(dirname(__FILE__)) . '/plugin/');
define('DS', '/');

getEventSubscriberFile(VIEW_TWIG_PATH);
function getEventSubscriberFile($dir)
{
    $currentDir = dir($dir);
    $viewFile = [];
    $errArr = [];
    while ($file = $currentDir->read()) {
        if ((is_dir($dir . $file)) and ($file != ".") and ($file != "..")) {
            getEventSubscriberFile($dir . $file . DS);
        } else {
            // var_dump($dir . $file );
            $pathinfo = pathinfo($dir . $file);
            if (isset($pathinfo['extension'])
                && $pathinfo['extension'] == 'twig'
                && $pathinfo['basename'] != '.'
                && $pathinfo['basename'] != '..'
                && $pathinfo['basename'] != '.gitignore'
            ) {
                $viewFile[] = $filePath = $dir . $file;
                $source = file_get_contents($filePath);
                $exp = '/\{\{(.+)?\}\}/sU';
                $result = preg_replace_callback($exp, function ($matches) {
                    return '<?=' . $matches[1] . '?>';
                }, $source);
                $ret = file_put_contents($filePath, $result);
                if (!$ret) {
                    echo $filePath."\n";
                }
            }
        }
    }
    //var_export($errArr);
    $currentDir->close();
}





