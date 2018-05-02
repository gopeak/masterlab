<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4
 * Time: 16:13
 */

namespace main\app\classes;

use main\app\model\OriginModel;

class RewriteUrl
{

    /**
     * @todo 需要缓存处理
     * @param $engine
     * @return array
     */
    public function originRoute($engine)
    {
        $ctrl = $engine->ctrl;
        // var_dump($engine);
        if ($engine->enableSecurityMap) {
            $mapConfig = getCommonConfigVar('map');
            if (empty($engine->mod)) {
                if (!isset($mapConfig['ctrl'][$ctrl])) {
                    $originModel = new OriginModel();
                    $origins = $originModel->getPaths();
                    if (isset($origins[$ctrl])) {
                        return ['OriginRoute', '', 'index'];
                    }
                }
            }
        } else {
            $list = $this->readDir(APP_PATH . '/' . 'ctrl');
            if (!isset($list[$ctrl])) {
                $originModel = new OriginModel();
                $origins = $originModel->getPaths();
                if (isset($origins[$ctrl])) {
                    return ['OriginRoute', '', 'index'];
                }
            }
        }
    }

    /**
     * 读取目录下的所有控制器
     * @param $dir
     * @return array
     */
    public function readDir($dir)
    {
        $array = array();
        $dirObject = dir($dir);
        while (false !== ($entry = $dirObject->read())) {
            if ($entry != '.' && $entry != '..') {
                $entry = $dir . '/' . $entry;
                if (is_dir($entry)) {
                    $path_parts = pathinfo($entry);
                    $array[$path_parts['filename']] = $entry;
                } else {
                    $path_parts = pathinfo($entry);
                    $array[$path_parts['filename']] = $entry;
                }
            }
        }
        $dirObject->close();
        return $array;
    }
}
