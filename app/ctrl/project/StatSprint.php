<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\agile\SprintModel;
use main\app\classes\RewriteUrl;

/**
 * 项目统计数据
 */
class StatSprint extends BaseUserCtrl
{

    /**
     * StatSprint constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
        parent::addGVar('sub_nav_active', 'sprint');
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '迭代统计';
        $data['nav_links_active'] = 'stat';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $data['active_sprint_id'] = '';
        $model = new SprintModel();
        $activeSprint = $model->getActive($data['project_id']);
        if (isset($activeSprint['id'])) {
            $data['active_sprint_id'] = $activeSprint['id'];
        } else {
            $sprints = $model->getItemsByProject($data['project_id']);
            if (isset($sprints[0]['id'])) {
                $data['active_sprint_id'] = $sprints[0]['id'];
            }
        }
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/stat_sprint.php', $data);
    }

    /**
     * 获取项目的统计数据
     * @throws \Exception
     */
    public function fetchIssue()
    {
        $sprintId = null;
        if (isset($_GET['_target'][3])) {
            $sprintId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['sprint_id'])) {
            $sprintId = (int)$_GET['sprint_id'];
        }
        if (empty($sprintId)) {
            $this->ajaxFailed('参数错误', '迭代id不能为空');
        }
        $data['count'] = IssueFilterLogic::getCountBySprint($sprintId);
        $data['closed_count'] = IssueFilterLogic::getSprintClosedCount($sprintId);
        $data['no_done_count'] = IssueFilterLogic::getSprintNoDoneCount($sprintId);

        $data['priority_stat'] = IssueFilterLogic::getSprintPriorityStat($sprintId, true);
        $this->percent($data['priority_stat'], $data['no_done_count']);

        $data['status_stat'] = IssueFilterLogic::getSprintStatusStat($sprintId);
        $this->percent($data['status_stat'], $data['count']);

        $data['type_stat'] = IssueFilterLogic::getSprintTypeStat($sprintId);
        $this->percent($data['type_stat'], $data['count']);

        $data['assignee_stat'] = IssueFilterLogic::getSprintAssigneeStat($sprintId, true);
        $this->percent($data['assignee_stat'], $data['no_done_count']);

        $data['weight_stat'] = IssueFilterLogic::getSprintWeightStat($sprintId);
        $sumWeight = 0;
        foreach ($data['weight_stat'] as $row) {
            $sumWeight += intval($row['count']);
        }
        $this->percent($data['weight_stat'], $sumWeight);

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
            if ($count <= 0) {
                $row['percent'] = 0;
            } else {
                $row['percent'] = floor(intval($row['count']) / $count * 100);
            }
        }
    }
}
