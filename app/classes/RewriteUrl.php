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
        if ( $engine->enableSecurityMap ) {
            $mapConfig = getCommonConfigVar('map');
            if ( empty($engine->mod) ) {
                if ( !isset($mapConfig['ctrl'][$ctrl]) ) {
                    $originModel = new OriginModel();
                    $origins = $originModel->getPaths();
                    if ( isset($origins[$ctrl]) ) {
                        return [ 'OriginRoute', '', 'index' ];
                    }
                }
            }
        } else {
            $list = $this->read_dir(APP_PATH . '/' . 'ctrl');
            if ( !isset($list[$ctrl]) ) {
                $originModel = new OriginModel();
                $origins = $originModel->getPaths();
                if ( isset($origins[$ctrl]) ) {
                    return [ 'OriginRoute', '', 'index' ];
                }
            }
        }
    }

    public function read_dir($dir)
    {
        $array = array();
        $d = dir($dir);
        while ( false !== ( $entry = $d->read() ) ) {
            if ( $entry != '.' && $entry != '..' ) {
                $entry = $dir . '/' . $entry;
                if ( is_dir($entry) ) {
                    $path_parts = pathinfo($entry);
                    $array[$path_parts['filename']] = $entry;
                } else {
                    $path_parts = pathinfo($entry);
                    $array[$path_parts['filename']] = $entry;
                }
            }
        }
        $d->close();
        return $array;
    }

}