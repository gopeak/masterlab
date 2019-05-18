<?php

namespace main\app\ctrl;

use main\app\classes\ActivityLogic;
use main\app\classes\UserAuth;
use main\app\model\project\ProjectModel;

/**
 * 活动动态类
 * @package main\app\ctrl
 */
class Activity extends BaseUserCtrl
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取当前用户的日历活跃数据
     * @throws \Exception
     */
    public function fetchCalendarHeatmap()
    {
        $userId = UserAuth::getId();
        if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) {
            $userId = $_REQUEST['user_id'];
        }
        $data['heatmap'] = ActivityLogic::getCalendarHeatmap($userId);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取某个用户的活动动态
     * @throws \Exception
     */
    public function fetchByUser()
    {
        $userId = UserAuth::getId();
        if (isset($_REQUEST['user_id'])) {
            $userId = $_REQUEST['user_id'];
        }
        $page = 1;
        $pageSize = 20;
        if (isset($_GET['page'])) {
            $data['page'] = $page = max(1, (int)$_GET['page']);
        }
        list($data['activity_list'], $total) = ActivityLogic::filterByUser($userId, $page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取项目的活动动态
     * @throws \Exception
     */
    public function fetchByProject()
    {
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = $_GET['project_id'];
        }

        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }
        $activity = [];
        $total = 0;
        if (!empty($projectId)) {
            list($activity, $total) = ActivityLogic::filterByProject($projectId, $page, $pageSize);
            $data['total'] = $total;
        }
        $data['activity'] = $activity;
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $this->ajaxSuccess('ok', $data);
    }
}
