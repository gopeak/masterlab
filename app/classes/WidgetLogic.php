<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\WidgetModel;
use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\IssueFilterLogic;
use main\app\model\user\UserModel;
use main\app\model\user\UserTokenModel;
use main\app\model\project\ProjectModel;
use main\app\model\ActivityModel;


/**
 * 面板逻辑类
 * Class WidgetLogic
 * @package main\app\classes
 */
class WidgetLogic
{
    /**
     * 获取可用的面板列表
     * @return array
     */
    public function getAvailableWidget()
    {
        $model = new WidgetModel();
        $rows = $model->getAllItems();
        $widgetArr = [];
        foreach ($rows as $row) {
            if ($row['status'] == '1') {
                $row['pic'] = ROOT_URL.'gitlab/images/widget/'.$row['pic'];
                $row['parameter'] = json_decode($row['parameter']);
                $widgetArr[] = $row;
            }
        }
        return $widgetArr;
    }

    /**
     * @throws \Exception
     */
    public function getUserHaveJoinProjects($limit)
    {
        $userId = UserAuth::getId();
        if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) {
            $userId = (int)$_REQUEST['user_id'];
        }
        if (PermissionGlobal::check($userId, PermissionGlobal::ADMINISTRATOR)) {
            $projectModel = new ProjectModel();
            $all = $projectModel->getAll(false);
            $i = 0;
            $projects = [];
            foreach ($all as &$item) {
                $i++;
                if ($i > $limit) {
                    break;
                }
                $projects[] = ProjectLogic::formatProject($item);
            }
        } else {
            $projects = PermissionLogic::getUserRelationProjects($userId, $limit);
        }
        return $projects;
    }
}
