<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
use main\app\classes\RewriteUrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\project\ReportProjectIssueModel;
use main\app\model\project\ReportSprintIssueModel;

/**
 * 项目报表
 */
class Chart extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    public function pageIndex()
    {
        $this->pageProject();
    }

    public function pageProject()
    {
        $data = [];
        $data['title'] = '项目图表';
        $data['nav_links_active'] = 'chart';
        $data['sub_nav_active'] = 'project';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/chart_project.php', $data);
    }

    public function pageSprint()
    {
        $data = [];
        $data['title'] = '迭代图表';
        $data['nav_links_active'] = 'chart';
        $data['sub_nav_active'] = 'sprint';
        $data = RewriteUrl::setProjectData($data);
        $model = new SprintModel();
        $data['activeSprint'] = $model->getActive($data['project_id']);
        $this->render('gitlab/project/chart_sprint.php', $data);
    }

    /**
     * 获取项目的统计数据
     * @throws \Exception
     */
    public function fetchIssue()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $data['count'] = IssueFilterLogic::getCount($projectId);
        $data['closed_count'] = IssueFilterLogic::getClosedCount($projectId);
        $data['no_done_count'] = IssueFilterLogic::getNoDoneCount($projectId);
        $sprintModel = new SprintModel();
        $data['sprint_count'] = $sprintModel->getCountByProject($projectId);

        $data['priority_stat'] = IssueFilterLogic::getPriorityStat($projectId);
        $this->percent($data['priority_stat'], $data['no_done_count']);

        $data['status_stat'] = IssueFilterLogic::getPriorityStat($projectId);
        $this->percent($data['status_stat'], $data['no_done_count']);

        $data['type_stat'] = IssueFilterLogic::getPriorityStat($projectId);
        $this->percent($data['type_stat'], $data['no_done_count']);

        $data['assignee_stat'] = IssueFilterLogic::getAssigneeStat($projectId);
        $this->percent($data['assignee_stat'], $data['no_done_count']);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 计算百分比
     * @param $rows
     * @param $count
     */
    private function percent(&$rows, $count)
    {
        foreach ($rows as &$row) {
            $row['percent'] = floor(intval($row['count']) / $count * 100);
        }
    }

    /**
     * 获取项目的饼状图数据
     * @throws \Exception
     */
    public function fetchProjectChartPie()
    {
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('failed,params_error');
        }
        $sprintId = null;
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        $field = null;
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
        $rows = IssueFilterLogic::getProjectChartPie($field, $projectId, $sprintId, $startDate, $endDate);
        $config = $this->formatChartJsPie($field, $rows);
        $this->ajaxSuccess('ok', $config);
    }

    /**
     * 获取迭代的饼状图数据
     * @throws \Exception
     */
    public function fetchSprintChartPie()
    {
        $sprintId = null;
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
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
        $config = $this->formatChartJsPie($field, $rows);
        $this->ajaxSuccess('ok', $config);
    }

    /**
     * 格式化饼状图数据
     * @param $field
     * @param $rows
     * @return array
     * @throws \Exception
     */
    private function formatChartJsPie($field, $rows)
    {
        $colorArr = [
            'red' => 'rgb(255, 99, 132)',
            'orange' => 'rgb(255, 159, 64)',
            'yellow' => 'rgb(255, 205, 86)',
            'green' => 'rgb(75, 192, 192)',
            'blue' => 'rgb(54, 162, 235)',
            'purple' => 'rgb(153, 102, 255)',
            'grey' => 'rgb(201, 203, 207)'
        ];
        $randColor = function () {
            return 'rgb(' . mt_rand(1, 50) . ', ' . mt_rand(50, 150) . ', ' . mt_rand(150, 255) . ')';
        };
        $pieConfig = [];
        $pieConfig['type'] = 'pie';
        $pieConfig['options']['responsive'] = true;
        $dataSetArr = [];
        $labels = [];
        switch ($field) {
            case 'assignee':
                $userModel = new UserModel();
                $userArr = $userModel->getAll();
                $label = '按经办人';
                $backgroundColor = [];
                $data = [];
                foreach ($rows as $item) {
                    $data[] = (int)$item['count'];
                    $color = $randColor();
                    if (!empty($colorArr)) {
                        $randKey = array_rand($colorArr);
                        if (isset($colorArr[$randKey])) {
                            $color = $colorArr[$randKey];
                            unset($colorArr[$randKey]);
                        }
                    }
                    $backgroundColor[] = $color;
                    $name = '';
                    if (isset($userArr[$item['id']])) {
                        $name = $userArr[$item['id']]['display_name'];
                    }
                    $labels[] = $name;
                }
                $dataSetArr['label'] = $label;
                $dataSetArr['backgroundColor'] = $backgroundColor;
                $dataSetArr['data'] = $data;
                break;
            case 'priority':
                $model = new IssuePriorityModel();
                $priorityArr = $model->getAllItem(true);
                $label = '按优先级';
                $backgroundColor = [];
                $data = [];
                foreach ($rows as $item) {
                    $data[] = (int)$item['count'];
                    $name = '';
                    if (isset($priorityArr[$item['id']])) {
                        $name = $priorityArr[$item['id']]['name'];
                    }
                    $color = $randColor();
                    if (isset($priorityArr[$item['id']])) {
                        $color = $priorityArr[$item['id']]['status_color'];
                    }
                    $backgroundColor[] = $color;

                    $labels[] = $name;
                }
                $dataSetArr['label'] = $label;
                $dataSetArr['backgroundColor'] = $backgroundColor;
                $dataSetArr['data'] = $data;
                break;
            case 'issue_type':
                $model = new IssueTypeModel();
                $typeArr = $model->getAll(true);
                $label = '按优先级';
                $backgroundColor = [];
                $data = [];
                foreach ($rows as $item) {
                    $data[] = (int)$item['count'];
                    $color = $randColor();
                    if (!empty($colorArr)) {
                        $randKey = array_rand($colorArr);
                        if (isset($colorArr[$randKey])) {
                            $color = $colorArr[$randKey];
                            unset($colorArr[$randKey]);
                        }
                    }
                    $backgroundColor[] = $color;
                    $name = '';
                    if (isset($typeArr[$item['id']])) {
                        $name = $typeArr[$item['id']]['name'];
                    }
                    $labels[] = $name;
                }
                $dataSetArr['label'] = $label;
                $dataSetArr['backgroundColor'] = $backgroundColor;
                $dataSetArr['data'] = $data;
                break;
            case 'status':
                $model = new IssueStatusModel();
                $statusArr = $model->getAll(true);
                $label = '按优先级';
                $backgroundColor = [];
                $data = [];
                foreach ($rows as $item) {
                    $data[] = (int)$item['count'];
                    $color = $randColor();
                    if (!empty($colorArr)) {
                        $randKey = array_rand($colorArr);
                        if (isset($colorArr[$randKey])) {
                            $color = $colorArr[$randKey];
                            unset($colorArr[$randKey]);
                        }
                    }
                    $backgroundColor[] = $color;
                    $name = '';
                    if (isset($statusArr[$item['id']])) {
                        $name = $statusArr[$item['id']]['name'];
                    }
                    $labels[] = $name;
                }
                $dataSetArr['data'] = $data;
                $dataSetArr['backgroundColor'] = $backgroundColor;
                $dataSetArr['label'] = $label;
                break;
            default:
                break;
        }

        $pieConfig['data']['datasets'][] = $dataSetArr;
        $pieConfig['data']['labels'] = $labels;
        return $pieConfig;
    }

    /**
     * 获取柱状图报表
     * @throws \Exception
     */
    public function fetchProjectChartBar()
    {
        $projectId = null;
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $field = null;
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
        $barConfig = $this->formatChartJsBar($rows);
        $this->ajaxSuccess('ok', $barConfig);
    }

    /**
     * 获取迭代的柱状图数据
     * @throws \Exception
     */
    public function fetchSprintChartBar()
    {
        $sprintId = null;
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }

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

        $barConfig = $this->formatChartJsBar($rows);
        $this->ajaxSuccess('ok', $barConfig);
    }

    /**
     * 格式化柱状图格式
     * @param $rows
     * @return array
     */
    private function formatChartJsBar($rows)
    {
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
        $barConfig = [];
        $barConfig['type'] = 'bar';

        $labels = [];

        $dataSetArr = [];
        $dataSetArr['label'] = '已解决';
        $dataSetArr['backgroundColor'] = $colorArr['green'];
        $data = [];
        foreach ($rows as $item) {
            $data[] = (int)$item['count_done'];
        }
        $dataSetArr['data'] = $data;
        $barConfig['data']['datasets'][] = $dataSetArr;

        $dataSetArr = [];
        $dataSetArr['label'] = '未解决';
        $dataSetArr['backgroundColor'] = $colorArr['red'];
        $data = [];
        foreach ($rows as $item) {
            $data[] = (int)$item['count_no_done'];
            $labels[] = $item['label'];
        }
        $dataSetArr['data'] = $data;
        $barConfig['data']['datasets'][] = $dataSetArr;

        $barConfig['data']['labels'] = $labels;
        return $barConfig;
    }

    /**
     * 获取燃尽图
     * @throws \Exception
     */
    public function fetchSprintBurnDownLine()
    {
        $sprintId = null;
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }

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
        $dataSetArr['backgroundColor'] = $colorArr['green'];
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
        $dataSetArr['backgroundColor'] = $colorArr['red'];
        $dataSetArr['borderColor'] = $colorArr['blue'];
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
     * 获取燃尽图
     * @throws \Exception
     */
    public function fetchSprintSpeedLine()
    {
        $sprintId = null;
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('failed,params_error');
        }

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
        $dataSetArr['backgroundColor'] = $colorArr['green'];
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
        $dataSetArr['backgroundColor'] = $colorArr['red'];
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
     * 随机初始化项目的报表数据
     * @throws \Exception
     */
    public function buildProjectReportDemo()
    {
        $projectId = null;
        if (isset($_GET['id'])) {
            $projectId = (int)$_GET['id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $model = new ReportProjectIssueModel();
        // $originArrs = $model->getsByProject($projectId);

        // 清空原来数据
        $model->removeByProject($projectId);
        $count = 200;
        for ($n = 0; $n < 60; $n++) {
            $row = [];
            $row['project_id'] = $projectId;
            $row['date'] = strftime('%Y-%m-%d', strtotime("-{$n} day"));
            $row['week'] = date("w", strtotime("-{$n} day"));
            $row['month'] = date("m", strtotime("-{$n} day"));

            $row['count_done'] = min($count, mt_rand(1 + $n, 10 + $n));
            $row['count_no_done'] = $count - $row['count_done'];

            $row['count_done_by_resolve'] = min($count, mt_rand(1 + $n, 10 + $n));
            $row['count_no_done_by_resolve'] = $count - $row['count_done_by_resolve'];

            $row['today_done_points'] = mt_rand(5, 20);
            $row['today_done_number'] = mt_rand(5, 10);
            $model->insert($row);
        }

        $rows = $model->getsByProject($projectId);
        $this->ajaxSuccess('ok', $rows);
    }

    /**
     * 随机初始化迭代的报表数据
     * @throws \Exception
     */
    public function buildSprintReportDemo()
    {
        $sprintId = null;
        if (isset($_GET['id'])) {
            $sprintId = (int)$_GET['id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        $model = new ReportSprintIssueModel();
        // $originArrs = $model->getsByProject($projectId);

        // 清空原来数据
        $model->removeBySprint($sprintId);
        $count = 100;
        for ($n = 0; $n < 60; $n++) {
            $row = [];
            $row['sprint_id'] = $sprintId;
            $row['date'] = strftime('%Y-%m-%d', strtotime("-{$n} day"));
            $row['week'] = date("w", strtotime("-{$n} day"));
            $row['month'] = date("m", strtotime("-{$n} day"));

            $row['count_done'] = min($count, mt_rand(1 + $n, 10 + $n));
            $row['count_no_done'] = $count - $row['count_done'];

            $row['count_done_by_resolve'] = min($count, mt_rand(1 + $n, 10 + $n));
            $row['count_no_done_by_resolve'] = $count - $row['count_done_by_resolve'];

            $row['today_done_points'] = mt_rand(5, 20);
            $row['today_done_number'] = mt_rand(5, 10);
            $model->insert($row);
        }

        $rows = $model->getsBySprint($sprintId);
        $this->ajaxSuccess('ok', $rows);
    }
}
