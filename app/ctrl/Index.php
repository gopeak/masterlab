<?php

namespace main\app\ctrl;

use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;

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
        $dashboard = new Dashboard();
        $dashboard->index();
    }

    public function arg($projectId, $issueId)
    {

        var_dump($projectId, $issueId);
    }

}
