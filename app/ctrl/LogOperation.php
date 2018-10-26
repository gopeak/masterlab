<?php

namespace main\app\ctrl;

use main\app\classes\LogOperatingLogic;
use main\app\classes\UserAuth;

/**
 * 用户操作日志类
 * @package main\app\ctrl
 */
class LogOperation extends BaseUserCtrl
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取某个用户的操作日志
     * @throws \Exception
     */
    public function fetchByUser()
    {
        $userId = UserAuth::getId();
        if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) {
            $userId = $_REQUEST['user_id'];
        }
        $page = 1;
        $pageSize = 20;
        if (isset($_GET['page'])) {
            $data['page'] = $page = max(1, (int)$_GET['page']);
        }

        $logLogic = new LogOperatingLogic();
        $ret = $logLogic->getLogsByUid($userId, $page, $pageSize);
        list($logs, $total) = $ret;

        unset($logLogic);

        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['logs'] = array_values($logs);
        $this->ajaxSuccess('ok', $data);
    }
}
