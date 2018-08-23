<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 0:13
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\classes\ConfigLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\ActivityLogic;

/**
 * Class Dashboard
 * @package main\app\ctrl
 */
class Dashboard extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'index');
    }

    /**
     * index
     */
    public function index()
    {
        if (!UserAuth::getId()) {
            header("location:/passport/login");
            die;
        }
        $data = [];
        $data['title'] = '首页';
        $data['top_menu_active'] = 'org';
        $data['nav_links_active'] = 'org';
        $data['sub_nav_active'] = 'all';
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/dashboard_ant.php', $data);
    }

    /**
     * 获取分配给我的问题列表
     * @throws \Exception
     */
    public function fetchPanelAssigneeIssues()
    {
        $curUserId = UserAuth::getId();
        $pageSize = 10;
        $page = 1;
        list($data['issues'], $total) = IssueFilterLogic::getsByAssignee($curUserId, $page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取活动动态
     * @throws \Exception
     */
    public function fetchPanelActivity()
    {
        $pageSize = 50;
        $page = 1;
        list($data['activity'], $total) = ActivityLogic::filterByIndex($page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $this->ajaxSuccess('ok', $data);
    }
}
