<?php

namespace main\app\ctrl;

use main\app\classes\OriginLogic;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\OriginModel;
use main\app\model\project\ProjectModel;

class OriginRoute extends BaseUserCtrl
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
        var_dump($_GET['_target']);

    }





}
