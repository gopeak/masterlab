<?php

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\ctrl\project\Main;
use main\app\model\SettingModel;
use main\app\model\user\UserSettingModel;

/**
 * Class OrgRoute
 * @package main\app\ctrl
 */
class OrgRoute extends BaseUserCtrl
{
    /**
     * OrgRoute constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        global $framework;
        $_target = $_GET['_target'];

        if (isset($_target[1]) && !empty($_target[1])) {
            $projectKey = trimStr($_target[1]);
            $model = new projectModel();
            $project = $model->getByKey($projectKey);
            if (isset($project['id']) && $project['id']) {
                $_GET[ProjectLogic::PROJECT_GET_PARAM_ID] = $project['id'];
                $projectCtrlMain = new Main();
                if (!isset($_GET['_target'][2])) {
                    // {"issues":"事项列表","summary":"项目摘要","backlog":"待办事项","sprints":"迭代列表","board":"迭代看板"}
                    $projectHomePage = SettingModel::getInstance()->getValue('project_view');
                    $userId = UserAuth::getId();
                    $userSettingModel = new UserSettingModel($userId);
                    $tmp = $userSettingModel->getSettingByKey($userId, 'project_view');
                    if (!empty($tmp)) {
                        $projectHomePage = $tmp;
                    }
                    switch ($projectHomePage) {
                        case 'issues':
                            $projectCtrlMain->pageIssues();
                            break;
                        case 'plugin':
                            $this->pageProjectPlugin();
                            break;
                        case 'summary':
                            $projectCtrlMain->pageHome();
                            break;
                        case 'backlog':
                            $projectCtrlMain->pageBacklog();
                            break;
                        case 'sprints':
                            $projectCtrlMain->pageSprints();
                            break;
                        case 'board':
                            $projectCtrlMain->pageKanban();
                            break;
                        default:
                            $projectCtrlMain->pageHome();
                    }
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


    public function pageAdminPlugin()
    {
        // 1.取出插件名称
        $pluginName = $_GET['_target'][2];

        $pluginFile = PLUGIN_PATH . $pluginName . "/index.php";
        //var_dump($pluginFile);
        if (file_exists($pluginFile)) {
            require_once($pluginFile);
            $pluginIndexClass = sprintf("main\\app\\plugin\\%s\\%s",  $pluginName, 'Index');
            if (class_exists($pluginIndexClass)) {
                $indexCtrl = new $pluginIndexClass($this->dispatcher);

            }else{
                echo "入口类: {$pluginIndexClass} 缺失";
            }

        }else{
            echo "入口文件: {$pluginFile} 缺失";
        }
    }

    public function pageProjectPlugin()
    {
        // 1.取出插件名称
        $pluginName = $_GET['_target'][3];
        $pluginFile = PLUGIN_PATH . $pluginName . "/index.php";
        //var_dump($pluginFile);
        if (file_exists($pluginFile)) {
            require_once($pluginFile);
            $pluginIndexClass = sprintf("main\\app\\plugin\\%s\\%s",  $pluginName, 'Index');
            if (class_exists($pluginIndexClass)) {
                $indexCtrl = new $pluginIndexClass($this->dispatcher);
                if(method_exists($indexCtrl,'main')){
                    $indexCtrl->main();
                }
                if(method_exists($indexCtrl,'pageIndex')){
                    $indexCtrl->pageIndex();
                }
            }else{
                echo "入口类: {$pluginIndexClass} 缺失";
            }

        }else{
            echo "入口文件: {$pluginFile} 缺失";
        }
    }
}
