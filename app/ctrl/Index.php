<?php

namespace main\app\ctrl;

use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;

/**
 * Class Index
 * @package main\app\ctrl
 */
class Index extends BaseCtrl
{


    /**
     * 首页的控制器
     * Index constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function pageIndex()
    {
        $dashboard = new Dashboard();
        $dashboard->pageIndex();
    }
}
