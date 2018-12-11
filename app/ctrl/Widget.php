<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 0:13
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\classes\OrgLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\ActivityLogic;
use main\app\classes\WidgetLogic;
use main\app\model\project\ProjectModel;
use main\app\model\user\UserModel;

/**
 * Class Widget
 * @package main\app\ctrl
 */
class Widget extends BaseUserCtrl
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
     * @throws \Exception
     */
    public function fetchAvailable()
    {
        $widgetLogic = new WidgetLogic();
        $data['widgets'] = $widgetLogic->getAvailableWidget();
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取分配给我的问题列表
     * @throws \Exception
     */
    public function fetchAssigneeIssues()
    {
        $curUserId = UserAuth::getId();
        $pageSize = 10;
        $page = 1;
        list($data['issues'], $total) = IssueFilterLogic::getsByAssignee($curUserId, $page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        return $data;
    }

    /**
     * 获取活动动态
     * @throws \Exception
     */
    public function fetchActivity()
    {
        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }
        list($data['activity'], $total) = ActivityLogic::filterByIndex($page, $pageSize);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        return $data;
    }

    /**
     * @throws \Exception
     */
    public function fetchUserHaveJoinProjects()
    {
        $limit = 6;
        if (isset($_REQUEST['limit'])) {
            $limit = (int)$_REQUEST['limit'];
        }

        $widgetLogic = new WidgetLogic();
        $data['projects'] = $widgetLogic->getUserHaveJoinProjects($limit);

        $this->ajaxSuccess('ok', $data);
    }

    public function fetchOrgs()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectPriorityStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectDeveloperStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectStatusStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectIssueTypeStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectPie()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    public function fetchProjectAbs()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }


    /**
     * 当前迭代的事项汇总
     * @return array
     */
    public function fetchSprintStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 当前迭代的优先级数据汇总
     * @return array
     */
    public function fetchSprintPriorityStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 当前迭代的开发者数据汇总
     * @return array
     */
    public function fetchSprintDeveloperStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 当前迭代的状态数据汇总
     * @return array
     */
    public function fetchSprintStatusStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 当前迭代的事项汇总
     * @return array
     */
    public function fetchSprintIssueTypeStat()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 当前迭代的pie数据
     * @return array
     */
    public function fetchSprintPie()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 当前迭代的解决与未解决对比数据
     * @return array
     */
    public function fetchSprintAbs()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 获取活跃迭代的倒计时
     * @return array
     */
    public function fetchSprintCountdown()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 获取活跃迭代的燃尽图
     * @return array
     */
    public function fetchSprintBurndown()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }

    /**
     * 获取活跃迭代的速率
     * @return array
     */
    public function fetchSprintSpeedRate()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        return $data;
    }
}
