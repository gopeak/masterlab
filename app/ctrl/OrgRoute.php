<?php

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\ctrl\project\Main;

/**
 * Class OrgRoute
 * @package main\app\ctrl
 */
class OrgRoute extends BaseUserCtrl
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function pageIndex()
    {
        global $framework;
        if (isset($_GET['_target'][1]) && !empty($_GET['_target'][1])) {
            $projectKey = trimStr($_GET['_target'][1]);
            $model = new projectModel();
            $project = $model->getByKey($projectKey);
            if ($project['id']) {
                $_GET[ProjectLogic::PROJECT_GET_PARAM_ID] = $project['id'];
                $projectCtrlMain = new Main();
                if (!isset($_GET['_target'][2])) {
                    $projectCtrlMain->pageHome();
                } else {
                    $funcName = $_GET['_target'][2];
                    if (!empty($framework->ctrlMethodPrefix)) {
                        $funcName = $framework->ctrlMethodPrefix . ucfirst($funcName);
                    }
                    if (!method_exists($projectCtrlMain, $funcName)) {
                        $funcName = underlineToUppercase($funcName);
                    }
                    $projectCtrlMain->$funcName();
                }
                return;
            }
        }
    }


}
