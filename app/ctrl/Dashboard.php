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
use main\app\classes\WidgetLogic;
use main\app\model\issue\IssueFollowModel;
use main\app\model\project\ProjectModel;
use main\app\model\user\UserModel;
use main\app\model\user\UserSettingModel;

/**
 * Class Dashboard
 * @package main\app\ctrl
 */
class Dashboard extends BaseUserCtrl
{

    /**
     * Dashboard constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'index');
    }


    /**
     * 首页面板
     * @throws \Exception
     */
    public function pageIndex()
    {
        if (!UserAuth::getId()) {
            header("location:/passport/login");
            die;
        }
        $data = [];
        $data['title'] = '首页';
        $data['top_menu_active'] = 'index';
        $data['nav_links_active'] = 'index';
        $data['sub_nav_active'] = 'all';
        ConfigLogic::getAllConfigs($data);

        $userId = UserAuth::getId();
        $widgetLogic = new WidgetLogic();
        $data['widgets'] = $widgetLogic->getAvailableWidget();
        $data['user_widgets'] = $widgetLogic->getUserWidgets($userId);
        $data['user_in_projects'] = $widgetLogic->getUserHaveJoinProjects(1000);
        $data['user_in_sprints'] = $widgetLogic->getUserHaveSprints($data['user_in_projects']);

        // 参与项目数
        $data['joined_project_count'] = count($data['user_in_projects']);

        // 关注事项数
        $issueFollowModel = new IssueFollowModel();
        $data['follow_issue_count'] = $issueFollowModel->getCountByUserId(UserAuth::getId());

        $data['user_layout'] = 'aa';
        $userSettingModel = new UserSettingModel();
        $layout = $userSettingModel->getSettingByKey($userId, 'layout');
        if (!empty($layout)) {
            $data['user_layout'] = $layout;
        }
        ConfigLogic::getAllConfigs($data);

        $this->render('gitlab/dashboard.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchWidgets()
    {
        $widgetLogic = new WidgetLogic();
        $data['widgets'] = $widgetLogic->getAvailableWidget();
        $this->ajaxSuccess('ok', $data);
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
        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }

        $userId = UserAuth::getId();
        list($data['activity'], $total) = ActivityLogic::filterByIndex($userId, $page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $this->ajaxSuccess('ok', $data);
    }
}
