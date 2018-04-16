<?php

namespace main\app\ctrl;

use main\app\classes\OriginLogic;
use main\app\classes\ProjectLogic;
use main\app\model\OriginModel;
use main\app\model\project\ProjectModel;
use main\app\ctrl\project\Main;

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

        if (isset($_GET['_target'][2]) && !empty($_GET['_target'][2])) {
            $projectKey = trimStr($_GET['_target'][2]);
            $model = new projectModel();
            $project = $model->getByKey($projectKey);
            if ($project['id']) {
                $_GET[ProjectLogic::PROJECT_GET_PARAM_ID] = $project['id'];
                $projectCtrlMain = new Main();
                $projectCtrlMain->home();
                return;
            }
        }
    }
}
