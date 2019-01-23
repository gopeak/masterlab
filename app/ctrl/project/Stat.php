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
class Stat extends BaseUserCtrl
{

    /**
     * Stat constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
        parent::addGVar('sub_nav_active', 'project');
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '项目统计';
        $data['nav_links_active'] = 'stat';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/stat_project.php', $data);
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

        $data['priority_stat'] = IssueFilterLogic::getPriorityStat($projectId, true);
        $this->percent($data['priority_stat'], $data['no_done_count']);

        $data['status_stat'] = IssueFilterLogic::getStatusStat($projectId);
        $this->percent($data['status_stat'], $data['count']);

        $data['type_stat'] = IssueFilterLogic::getTypeStat($projectId);
        $this->percent($data['type_stat'], $data['count']);

        $data['assignee_stat'] = IssueFilterLogic::getAssigneeStat($projectId, true);
		$this->percent($data['assignee_stat'], $data['no_done_count']);
		
		$data['weight_stat'] = IssueFilterLogic::getWeightStat($projectId);
		$sumWeight = 0;
		foreach($data['weight_stat'] as $row){
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
