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
        header('location:/projects');
        exit;
        $dashboard = new Dashboard();
        $dashboard->index();
        // /data/www/masterlab/app/public/site/baisu_shadu
    }

    public function arg($projectId, $issueId)
    {

        var_dump($projectId, $issueId);
    }

}
