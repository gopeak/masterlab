<?php
/**
 * Created by Sven.
 * author: 121642038@qq.com
 * Date: 2018/7/24
 * Time: 0:13
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\classes\OrgLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\ActivityLogic;
use main\app\classes\WidgetLogic;
use main\app\model\agile\SprintModel;
use main\app\model\user\UserSettingModel;

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
     * @throws \Exception
     */
    public function fetchUserWidget()
    {
        $curUserId = UserAuth::getId();
        $widgetLogic = new WidgetLogic();
        $data['user_widgets'] = $widgetLogic->getUserWidgets($curUserId);
        $data['layout'] = 'aa';
        $userSettingModel = new UserSettingModel();
        $layout = $userSettingModel->getSettingByKey($curUserId, 'layout');
        if (!empty($layout)) {
            $data['layout'] = $layout;
        }

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 保存用户自定义面板的配置
     * @throws \Exception
     */
    public function saveUserWidget()
    {
        $userId = UserAuth::getId();

        // 校验参数
        if (!isset($_POST['panel']) || !isset($_POST['layout'])) {
            $this->ajaxFailed('参数错误');
        }

        // 获取数据
        $panelArr = json_decode($_POST['panel'], true);
        $layout = $_POST['layout'];
        if (empty($panelArr)) {
            $this->ajaxFailed('panel参数不能为空');
        }

        // 保存到数据库中
        $widgetLogic = new WidgetLogic();
        list($ret, $errMsg) = $widgetLogic->saveUserWidgets($userId, $panelArr, $layout);
        if (!$ret) {
            $this->ajaxFailed($errMsg, [$layout, $panelArr]);
        }
        // 获取数据
        $data['user_widgets'] = $widgetLogic->getUserWidgets($userId);
        $data['user_layout'] = 'aa';
        $userSettingModel = new UserSettingModel();
        $layout = $userSettingModel->getSettingByKey($userId, 'layout');
        if (!empty($layout)) {
            $data['user_layout'] = $layout;
        }

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 保存widget的查询参数
     * @throws \Exception
     */
    public function saveUserWidgetParameter()
    {
        $userId = UserAuth::getId();

        // 校验参数
        if (!isset($_POST['widget_id']) || !isset($_POST['parameter'])) {
            $this->ajaxFailed('参数错误');
        }

        // 获取数据
        $parameterArr = json_decode($_POST['parameter'], true);
        $widgetId = $_POST['widget_id'];
        if (empty($parameterArr)) {
            $this->ajaxFailed('查询参数不能为空');
        }

        // 保存到数据库中
        $widgetLogic = new WidgetLogic();
        list($ret, $errMsg) = $widgetLogic->saveUserWidgetParameter($userId, $parameterArr, $widgetId);
        if (!$ret) {
            $this->ajaxFailed($errMsg, [$widgetId, $parameterArr]);
        }

        $this->ajaxSuccess('ok', []);
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

    /**
     * @throws \Exception
     */
    public function fetchOrgs()
    {
        $data = [];
        $orgLogic = new OrgLogic();
        $data['orgs'] = $orgLogic->getOrigins();
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchProjectStat()
    {
        $data = [];
        $projectId = $this->getParamProjectId();
        $data['count'] = IssueFilterLogic::getCount($projectId);
        $data['closed_count'] = IssueFilterLogic::getClosedCount($projectId);
        $data['no_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
        $sprintModel = new SprintModel();
        $data['sprint_count'] = $sprintModel->getCountByProject($projectId);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchProjectPriorityStat()
    {
        $data = [];
        $projectId = $this->getParamProjectId();
        $data['priority_stat'] = IssueFilterLogic::getPriorityStat($projectId, true);
        $data['count'] = IssueFilterLogic::getCount($projectId);
        $data['no_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
        $this->percent($data['priority_stat'], $data['no_done_count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchProjectDeveloperStat()
    {
        $data = [];
        $projectId = $this->getParamProjectId();
        $data['assignee_stat'] = IssueFilterLogic::getAssigneeStat($projectId, true);
        $data['count'] = IssueFilterLogic::getCount($projectId);
        $data['no_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
        $this->percent($data['assignee_stat'], $data['no_done_count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchProjectStatusStat()
    {
        $data = [];
        $projectId = $this->getParamProjectId();
        $data['status_stat'] = IssueFilterLogic::getStatusStat($projectId);
        $data['count'] = IssueFilterLogic::getCount($projectId);
        $data['no_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
        $this->percent($data['status_stat'], $data['count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchProjectIssueTypeStat()
    {
        $data = [];
        $projectId = $this->getParamProjectId();
        $data['type_stat'] = IssueFilterLogic::getTypeStat($projectId);
        $data['count'] = IssueFilterLogic::getCount($projectId);
        $data['no_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
        $this->percent($data['type_stat'], $data['count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchProjectPie()
    {
        $projectId = $this->getParamProjectId();

        $field = 'assignee';
        if (isset($_GET['data_type'])) {
            $field = $_GET['data_type'];
        }

        $startDate = null;
        if (!empty($_GET['start_date'])) {
            $startDate = $_GET['start_date'];
        }
        $endDate = null;
        if (!empty($_GET['end_date'])) {
            $endDate = $_GET['end_date'];
        }
        $allowFieldArr = ['assignee', 'priority', 'issue_type', 'status'];
        if (!in_array($field, $allowFieldArr)) {
            $this->ajaxFailed('参数错误', '数据类型异常,可接受参数:assignee, priority, issue_type, status');
        }
        // 从数据库查询数据
        $rows = IssueFilterLogic::getProjectChartPie($field, $projectId, false, $startDate, $endDate);
        $data = WidgetLogic::formatChartJsPie($field, $rows);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取项目事项对比数据
     * @throws \Exception
     */
    public function fetchProjectAbs()
    {
        $projectId = $this->getParamProjectId();

        $field = 'date';
        if (isset($_GET['by_time'])) {
            $field = $_GET['by_time'];
        }

        $withinDate = null;
        if (!empty($_GET['within_date'])) {
            $withinDate = (int)$_GET['within_date'];
        }

        $allowFieldArr = ['date', 'week', 'month'];
        if (!in_array($field, $allowFieldArr)) {
            $this->ajaxFailed('参数错误', '时间异常,可接受参数:date, week, month');
        }
        // 从数据库查询数据
        $rows = IssueFilterLogic::getProjectChartBar($field, $projectId, $withinDate);
        $data = WidgetLogic::formatChartJsBar($rows);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @return int|null
     */
    public function getParamSprintId()
    {
        $sprintId = null;
        if (isset($_GET['_target'][2])) {
            $sprintId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        return $sprintId;
    }

    /**
     * @return int|null
     */
    public function getParamProjectId()
    {
        $projectId = null;
        if (isset($_GET['_target'][2])) {
            $projectId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        return $projectId;
    }

    /**
     * 当前迭代的事项汇总
     * @throws \Exception
     */
    public function fetchSprintStat()
    {
        $data = [];
        $sprintId = $this->getParamSprintId();
        $data['count'] = IssueFilterLogic::getCountBySprint($sprintId);
        $data['closed_count'] = IssueFilterLogic::getSprintClosedCount($sprintId);
        $data['no_done_count'] = IssueFilterLogic::getSprintNoDoneCount($sprintId);

        $model = new SprintModel();
        $data['activeSprint'] = $model->getById($sprintId);

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 当前迭代的优先级数据汇总
     * @throws \Exception
     */
    public function fetchSprintPriorityStat()
    {
        $data = [];
        $sprintId = $this->getParamSprintId();
        $data['priority_stat'] = IssueFilterLogic::getSprintPriorityStat($sprintId, true);
        $data['no_done_count'] = IssueFilterLogic::getSprintNoDoneCount($sprintId);
        $this->percent($data['priority_stat'], $data['no_done_count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 当前迭代的开发者数据汇总
     * @throws \Exception
     */
    public function fetchSprintDeveloperStat()
    {
        $data = [];
        $sprintId = $this->getParamSprintId();
        $data['assignee_stat'] = IssueFilterLogic::getSprintAssigneeStat($sprintId, true);
        $data['no_done_count'] = IssueFilterLogic::getSprintNoDoneCount($sprintId);
        $this->percent($data['assignee_stat'], $data['no_done_count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 当前迭代的状态数据汇总
     * @throws \Exception
     */
    public function fetchSprintStatusStat()
    {
        $data = [];
        $sprintId = $this->getParamSprintId();
        $data['status_stat'] = IssueFilterLogic::getSprintStatusStat($sprintId);
        $data['count'] = IssueFilterLogic::getCountBySprint($sprintId);
        $this->percent($data['status_stat'], $data['count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 当前迭代的事项汇总
     * @throws \Exception
     */
    public function fetchSprintIssueTypeStat()
    {
        $sprintId = $this->getParamSprintId();
        $data['type_stat'] = IssueFilterLogic::getSprintTypeStat($sprintId);
        $data['count'] = IssueFilterLogic::getCountBySprint($sprintId);
        $this->percent($data['type_stat'], $data['count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 当前迭代的pie数据
     * @throws \Exception
     */
    public function fetchSprintPie()
    {
        $sprintId = $this->getParamSprintId();
        $field = 'assignee';
        if (isset($_GET['data_type'])) {
            $field = $_GET['data_type'];
        }
        $allowFieldArr = ['assignee', 'priority', 'issue_type', 'status'];
        if (!in_array($field, $allowFieldArr)) {
            $this->ajaxFailed('参数错误', '数据类型异常,可接受参数:assignee, priority, issue_type, status');
        }
        // 从数据库查询数据
        $rows = IssueFilterLogic::getSprintIssueChartPieData($field, $sprintId);
        $data = WidgetLogic::formatChartJsPie($field, $rows);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 当前迭代的解决与未解决对比数据
     * @throws \Exception
     */
    public function fetchSprintAbs()
    {
        $sprintId = $sprintId = $this->getParamSprintId();

        $field = 'date';
        if (isset($_GET['by_time'])) {
            $field = $_GET['by_time'];
        }
        $allowFieldArr = ['date', 'week', 'month'];
        if (!in_array($field, $allowFieldArr)) {
            $this->ajaxFailed('failed,params_error');
        }
        // 从数据库查询数据
        $rows = IssueFilterLogic::getSprintChartBar($field, $sprintId);
        $barConfig = WidgetLogic::formatChartJsBar($rows);
        $this->ajaxSuccess('ok', $barConfig);
    }

    /**
     * 获取活跃迭代的倒计时
     * @throws \Exception
     */
    public function fetchSprintCountdown()
    {
        return $this->fetchSprintStat();
    }

    /**
     * 获取活跃迭代的燃尽图
     * @throws \Exception
     */
    public function fetchSprintBurndown()
    {
        $sprintId = $this->getParamSprintId();

        $field = 'date';
        // 从数据库查询数据
        $rows = IssueFilterLogic::getSprintReport($field, $sprintId);
        //print_r($rows);
        $colorArr = [
            'red' => 'rgb(255, 99, 132)',
            'orange' => 'rgb(255, 159, 64)',
            'yellow' => 'rgb(255, 205, 86)',
            'green' => 'rgb(75, 192, 192)',
            'blue' => 'rgb(54, 162, 235)',
            'purple' => 'rgb(153, 102, 255)',
            'grey' => 'rgb(201, 203, 207)'
        ];
        $lineConfig = [];
        $lineConfig['type'] = 'line';

        $labels = [];

        $dataSetArr = [];
        $dataSetArr['label'] = '按状态';
        $dataSetArr['backgroundColor'] = $colorArr['red'];
        $dataSetArr['borderColor'] = $colorArr['red'];
        $dataSetArr['fill'] = false;
        $data = [];
        foreach ($rows as $item) {
            $data[] = (int)$item['count_no_done'];
        }
        $dataSetArr['data'] = $data;
        $lineConfig['data']['datasets'][] = $dataSetArr;

        $dataSetArr = [];
        $dataSetArr['label'] = '按解决结果';
        $dataSetArr['backgroundColor'] = $colorArr['orange'];
        $dataSetArr['borderColor'] = $colorArr['orange'];
        $dataSetArr['fill'] = false;
        $data = [];
        foreach ($rows as $item) {
            $data[] = (int)$item['count_no_done_by_resolve'];
            $labels[] = $item['label'];
        }
        $dataSetArr['data'] = $data;
        $lineConfig['data']['datasets'][] = $dataSetArr;

        $lineConfig['data']['labels'] = $labels;
        $this->ajaxSuccess('ok', $lineConfig);
    }

    /**
     * 获取活跃迭代的速率
     * @throws \Exception
     */
    public function fetchSprintSpeedRate()
    {
        $sprintId = $this->getParamSprintId();

        $field = 'date';
        // 从数据库查询数据
        $rows = IssueFilterLogic::getSprintReport($field, $sprintId);
        //print_r($rows);
        $colorArr = [
            'red' => 'rgb(255, 99, 132)',
            'orange' => 'rgb(255, 159, 64)',
            'yellow' => 'rgb(255, 205, 86)',
            'green' => 'rgb(75, 192, 192)',
            'blue' => 'rgb(54, 162, 235)',
            'purple' => 'rgb(153, 102, 255)',
            'grey' => 'rgb(201, 203, 207)'
        ];
        $lineConfig = [];
        $lineConfig['type'] = 'line';

        $labels = [];

        $dataSetArr = [];
        $dataSetArr['label'] = '完成事项数';
        $dataSetArr['backgroundColor'] = $colorArr['red'];
        $dataSetArr['borderColor'] = $colorArr['red'];
        $dataSetArr['fill'] = false;
        $data = [];
        foreach ($rows as $item) {
            $data[] = (int)$item['today_done_number'];
        }
        $dataSetArr['data'] = $data;
        $lineConfig['data']['datasets'][] = $dataSetArr;

        $dataSetArr = [];
        $dataSetArr['label'] = '完成点数';
        $dataSetArr['backgroundColor'] = $colorArr['blue'];
        $dataSetArr['borderColor'] = $colorArr['blue'];
        $dataSetArr['fill'] = false;
        $data = [];
        foreach ($rows as $item) {
            $data[] = (int)$item['today_done_points'];
            $labels[] = $item['label'];
        }
        $dataSetArr['data'] = $data;
        $lineConfig['data']['datasets'][] = $dataSetArr;

        $lineConfig['data']['labels'] = $labels;
        $this->ajaxSuccess('ok', $lineConfig);
    }

    /**
     * 计算百分比
     * @param $rows
     * @param $count
     */
    private function percent(&$rows, $count)
    {
        foreach ($rows as &$row) {
            if ($count <= 0) {
                $row['percent'] = 0;
            } else {
                $row['percent'] = floor(intval($row['count']) / $count * 100);
            }
        }
    }
}
