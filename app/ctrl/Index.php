<?php

namespace main\app\ctrl;

use main\lib\Trigger;

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

    public function arg($projectId, $issueId)
    {

        var_dump($projectId, $issueId);
    }
    
}
