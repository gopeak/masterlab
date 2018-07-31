<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\user\UserModel;
use main\app\model\issue\IssuePriorityModel;

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

    public function index()
    {
        $this->project();
    }

    public function project()
    {
        $data = [];
        $data['title'] = '项目图表';
        $data['nav_links_active'] = 'chart';
        $data['sub_nav_active'] = 'project';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/chart_project.php', $data);
    }

    public function sprint()
    {
        $data = [];
        $data['title'] = '迭代图表';
        $data['nav_links_active'] = 'chart';
        $data['sub_nav_active'] = 'sprint';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/chart_sprint.php', $data);
    }

    /**
     * 获取项目的统计数据
     * @throws \ReflectionException
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
            $this->ajaxFailed('failed,params_error');
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
     * @throws \ReflectionException
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
        $field = null;
        if (isset($_GET['data_type'])) {
            $field = $_GET['data_type'];
        }

        $allowFieldArr = ['assignee', 'priority', 'issue_type', 'status'];
        if (!in_array($field, $allowFieldArr)) {
            $this->ajaxFailed('failed,params_error');
        }
        // 从数据库查询数据
        $rows = IssueFilterLogic::getProjectChartPie($projectId, $field);

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
                    $randKey = array_rand($colorArr);
                    $color = $randColor();
                    if (isset($colorArr[$randKey])) {
                        $color = $colorArr[$randKey];
                        unset($colorArr[$randKey]);
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

                    $randKey = array_rand($colorArr);
                    $color = $randColor();
                    if (isset($priorityArr[$item['id']])) {
                        $color =$priorityArr[$item['id']]['status_color'];
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
                $typeArr = $model->getAllItems(true);
                $label = '按优先级';
                $backgroundColor = [];
                $data = [];
                foreach ($rows as $item) {
                    $data[] = (int)$item['count'];
                    $randKey = array_rand($colorArr);
                    $color = $randColor();
                    if (isset($colorArr[$randKey])) {
                        $color = $colorArr[$randKey];
                        unset($colorArr[$randKey]);
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
                $statusArr = $model->getAllItems(true);
                $label = '按优先级';
                $backgroundColor = [];
                $data = [];
                foreach ($rows as $item) {
                    $data[] = (int)$item['count'];
                    $randKey = array_rand($colorArr);
                    $color = $randColor();
                    if (isset($colorArr[$randKey])) {
                        $color = $colorArr[$randKey];
                        unset($colorArr[$randKey]);
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

        $this->ajaxSuccess('ok', $pieConfig);
    }
}
