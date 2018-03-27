<?php
namespace main\app\protocol;

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/6/30 0030
 * Time: 上午 11:53
 */


interface Iprotocol
{
    public function builder($ret, $data, $msg = '', $format = 'json');

    public function getResponse();
}
