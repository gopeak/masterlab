<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\agile\SprintModel;
use main\app\classes\RewriteUrl;
use main\app\classes\ProjectGantt;
use main\app\model\project\ProjectRoleModel;

/**
 * 甘特图
 */
class Gantt extends BaseUserCtrl
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

    public function pageComputeLevel()
    {
        $class = new ProjectGantt();
        $class->batchUpdateGanttLevel();
        echo 'ok';
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '项目甘特图';
        $data['nav_links_active'] = 'gantt';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/gantt/gantt_project.php', $data);
    }

    /**
     * 获取项目的统计数据
     * @throws \Exception
     */
    public function fetchProjectIssues()
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
        $data['current_uid'] = UserAuth::getId();

        $model = new ProjectRoleModel();
        $data['project_roles'] = $model->getsByProject($projectId);
        $roles = [];
        foreach ($data['project_roles'] as $project_role) {
            $roles[] = ['id' => $project_role['id'], 'name' => $project_role['name']];
        }

        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);
        $resources = [];
        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
            $resources[] = ['id' => $user['uid'], 'name' => $user['display_name']];
        }
        $data['project_users'] = $projectUsers;

        $class = new ProjectGantt();
        $data['tasks'] = $class->getIssuesGroupBySprint($projectId);
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        foreach ($data['tasks'] as &$task) {
            $assigs = [];
            if(isset($users[$task['assigs']]['display_name'])){
                $tmp = [];
                $tmp['id'] = $task['assigs'];
                $tmp['name'] = @$users[$task['assigs']]['display_name'];
                $tmp['resourceId'] = $task['assigs'];
                $tmp['roleId'] = '';
                $assigs[] = $tmp;
            }
            $task['assigs']  = $assigs;
        }
        unset($users);
        $data['selectedRow'] = 2;
        $data['deletedTaskIds'] = [];
        $data['resources'] = $resources;
        $data['roles'] = $roles;
        $data['canWrite'] = true;
        $data['canDelete'] = true;
        $data['canWriteOnParent'] = true;
        $data['canAdd'] = true;
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
