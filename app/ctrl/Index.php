<?php

namespace main\app\ctrl;

class Index extends BaseCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function index()
    {
        header("location:/passport/login");
    }

    public function error()
    {

        dsad;
        // throw new \ErrorException('sssss', 0, 1, 'file', 121);
        throw new \Exception('Division by zero.');
        throw new \Error('error', 4);
        echo $bb / 0;
        $arr = [];
        echo $arr['ee'];
    }


}