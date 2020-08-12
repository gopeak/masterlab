<?php

namespace main\plugin\activity\ctrl;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\ActivityModel;
use main\app\model\user\UserModel;

/**
 *
 *  活动日志插件的控制器
 * @package main\app\ctrl\project
 */
class OtherCtrl extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();

    }


    public function pageIndex()
    {

    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function fetch($id)
    {

    }

    public function fetchAll()
    {

    }

}
