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
     * 获取用户参与的项目
     * @throws \Exception
     */
    public function fetchByProject()
    {
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        $this->ajaxFailed('参数错误', '项目id不能为空');

        $page = 1;
        $pageSize = 2;
        if (isset($_GET['page'])) {
            $data['page'] = $page = max(1, (int)$_GET['page']);
        }
        $model = new ProjectModel();
        $org = $model->getById($id);
        if (empty($org)) {
            $this->ajaxFailed('参数错误', '项目数据为空');
        }

        list($data['activity_list'], $total) = ActivityLogic::filterByProject($id, $page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;

        $this->ajaxSuccess('success', []);
    }
}
