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
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\project\ProjectGanttSettingModel;
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
        $projectId = $data['project_id'];
        $data['current_uid'] = UserAuth::getId();
        $userLogic = new UserLogic();
        $projectUsers = $userLogic->getUsersAndRoleByProjectId($projectId);

        foreach ($projectUsers as &$user) {
            $user = UserLogic::format($user);
        }
        $data['project_users'] = $projectUsers;

        $projectRolemodel = new ProjectRoleModel();
        $data['roles'] = $projectRolemodel->getsByProject($projectId);

        $projectGanttModel = new ProjectGanttSettingModel();
        $setting = $projectGanttModel->getByProject($projectId);
        $class = new ProjectGantt();
        if (empty($setting)) {
            $class->initGanttSetting($projectId);
        }

        // 迭代数据
        $data['sprints'] = [];
        $data['active_sprint'] = [];
        if (!empty($data['project_id'])) {
            $sprintModel = new SprintModel();
            $data['sprints'] = $sprintModel->getItemsByProject($projectId);
            $data['active_sprint'] = $sprintModel->getActive($projectId);
        }

        ConfigLogic::getAllConfigs($data);
        $this->render('gitlab/project/gantt_project.php', $data);
    }

    public function fetchSetting()
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

        $projectGanttModel = new ProjectGanttSettingModel();
        $ganttSetting = $projectGanttModel->getByProject($projectId);
        $class = new ProjectGantt();
        if (empty($ganttSetting)) {
            $class->initGanttSetting($projectId);
            $ganttSetting = $projectGanttModel->getByProject($projectId);
        }
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (in_array($ganttSetting['source_type'], $sourceArr)) {
            $sourceType = $sourceType = $ganttSetting['source_type'];
        }
        $this->ajaxSuccess('操作成功', $sourceType);
    }

    /**
     * 保存甘特图有设置
     * @throws \Exception
     */
    public function saveSetting()
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

        $projectGanttModel = new ProjectGanttSettingModel();
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (isset($_POST['source_type'])) {
            if (in_array($_POST['source_type'], $sourceArr)) {
                $sourceType = $_POST['source_type'];
            }
        }
        $updateInfo['source_type'] = $sourceType;
        list($ret, $msg) = $projectGanttModel->updateByProjectId($updateInfo, $projectId);
        if ($ret) {
            $this->ajaxSuccess('操作成功', $sourceType);
        } else {
            $this->ajaxFailed('服务器执行错误', $msg);
        }

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

        $projectGanttModel = new ProjectGanttSettingModel();
        $ganttSetting = $projectGanttModel->getByProject($projectId);
        $class = new ProjectGantt();
        if (empty($ganttSetting)) {
            $class->initGanttSetting($projectId);
            $ganttSetting = $projectGanttModel->getByProject($projectId);
        }
        $sourceType = 'project';
        $sourceArr = ['project', 'active_sprint', 'module'];
        if (in_array($ganttSetting['source_type'], $sourceArr)) {
            $sourceType = $sourceType = $ganttSetting['source_type'];
        }

        $data['tasks'] = [];
        if ($sourceType == 'project') {
            $data['tasks'] = $class->getIssuesGroupBySprint($projectId);
        }
        if ($sourceType == 'active_sprint') {
            $data['tasks'] = $class->getIssuesGroupBySprint($projectId, true);
        }
        if ($sourceType == 'module') {
            $data['tasks'] = $class->getIssuesGroupByModule($projectId);
        }

        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        foreach ($data['tasks'] as &$task) {
            $assigs = [];
            if (isset($users[$task['assigs']]['display_name'])) {
                $tmp = [];
                $tmp['id'] = $task['assigs'];
                $tmp['name'] = @$users[$task['assigs']]['display_name'];
                $tmp['resourceId'] = $task['assigs'];
                $tmp['roleId'] = '';
                $assigs[] = $tmp;
            }
            $task['assigs'] = $assigs;
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

    public function moveUpIssue()
    {
        $currentId = null;
        if (isset($_POST['current_id'])) {
            $currentId = (int)$_POST['current_id'];
        }
        $newId = null;
        if (isset($_POST['new_id'])) {
            $newId = (int)$_POST['new_id'];
        }
        if (!$currentId || !$newId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $issueModel = new IssueModel();
        $currentIsuse = $issueModel->getById($currentId);
        $newIssue = $issueModel->getById($newId);
        if (!isset($currentIsuse['gant_proj_sprint_weight']) || !isset($newIssue['gant_proj_sprint_weight'])) {
            $this->ajaxFailed('参数错误,找不到事项信息', $_POST);
        }

        $currentWeight = (int)$currentIsuse['gant_proj_sprint_weight'];
        $newWeight = (int)$newIssue['gant_proj_sprint_weight'];
        if ($currentWeight == $newWeight) {
            $currentWeight++;
        } else {
            $tmp = $newWeight;
            $newWeight = $currentWeight;
            $currentWeight = $tmp;
        }
        $currentInfo = ['gant_proj_sprint_weight' => $currentWeight];
        $newInfo = ['gant_proj_sprint_weight' => $newWeight];
        $issueModel->updateItemById($currentId, $currentInfo);
        $issueModel->updateItemById($newId, $newInfo);

        $this->ajaxSuccess('更新成功', [$currentId => $currentInfo, $newId => $newInfo]);
    }

    public function moveDownIssue()
    {
        $currentId = null;
        if (isset($_POST['current_id'])) {
            $currentId = (int)$_POST['current_id'];
        }
        $newId = null;
        if (isset($_POST['new_id'])) {
            $newId = (int)$_POST['new_id'];
        }
        if (!$currentId || !$newId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $issueModel = new IssueModel();
        $currentIsuse = $issueModel->getById($currentId);
        $newIssue = $issueModel->getById($newId);
        if (!isset($currentIsuse['gant_proj_sprint_weight']) || !isset($newIssue['gant_proj_sprint_weight'])) {
            $this->ajaxFailed('参数错误,找不到事项信息', $_POST);
        }

        $currentWeight = (int)$currentIsuse['gant_proj_sprint_weight'];
        $newWeight = (int)$newIssue['gant_proj_sprint_weight'];
        if ($currentWeight == $newWeight) {
            $newWeight++;
        } else {
            $tmp = $newWeight;
            $newWeight = $currentWeight;
            $currentWeight = $tmp;
        }
        $currentInfo = ['gant_proj_sprint_weight' => $currentWeight];
        $newInfo = ['gant_proj_sprint_weight' => $newWeight];
        $issueModel->updateItemById($currentId, $currentInfo);
        $issueModel->updateItemById($newId, $newInfo);

        $this->ajaxSuccess('更新成功', [$currentId => $currentInfo, $newId => $newInfo]);
    }

    public function outdent()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        $masterId = '0';
        if (isset($_POST['old_master_id'])) {
            $masterId = (int)$_POST['old_master_id'];
        }

        $nextId = '0';
        if (isset($_POST['next_id'])) {
            $nextId = (int)$_POST['next_id'];
        }

        $children = [];
        if (isset($_POST['children'])) {
            $children = $_POST['children'];
        }

        if (!$issueId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        $masterWeight = 0;
        $nextWeight = 0;
        $level = 0;
        $nextMasterId = 0;
        if ($masterId != '0') {
            $masterIssue = $issueModel->getById($masterId);
            if (!empty($masterIssue) && isset($masterIssue['master_id'])) {
                $masterId = $masterIssue['master_id'];
                $level = (int)$masterIssue['level'];
                $masterWeight = $masterIssue['gant_proj_sprint_weight'];
            }
        }
        if ($nextId != '0') {
            $nextIssue = $issueModel->getById($nextId);
            if (!empty($nextIssue)) {
                $nextWeight = $nextIssue['gant_proj_sprint_weight'];
                $nextMasterId = (int)$nextIssue['master_id'];
            }
        }
        $weight = round(($masterWeight - $nextWeight) / 2);

        $currentInfo = [];
        $currentInfo['level'] = $level;
        $currentInfo['master_id'] = $masterId;
        $currentInfo['gant_proj_sprint_weight'] = $weight;
        $issueModel->updateItemById($issueId, $currentInfo);

        if (!empty($children)) {
            foreach ($children as $childId) {
                $issueModel->updateItemById($childId, ['master_id' => $issueId]);
            }
            $issueModel->inc('have_children', $issueId, 'id');
        }
        if (!empty($issue['master_id']) && $issue['master_id'] != '0') {
            $issueModel->dec('have_children', $issue['master_id'], 'id');
        }
        $this->ajaxSuccess('更新成功', []);
    }

    public function indent()
    {
        $issueId = null;
        if (isset($_POST['issue_id'])) {
            $issueId = (int)$_POST['issue_id'];
        }

        $masterId = '0';
        if (isset($_POST['master_id'])) {
            $masterId = (int)$_POST['master_id'];
        }
        $nextId = '0';
        if (isset($_POST['next_id'])) {
            $nextId = (int)$_POST['next_id'];
        }

        $children = [];
        if (isset($_POST['children'])) {
            $children = $_POST['children'];
        }

        if (!$issueId) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (!isset($issue['id'])) {
            $this->ajaxFailed('参数错误', $_POST);
        }
        $masterWeight = 0;
        $nextWeight = 0;
        if ($masterId != '0') {
            $masterIssue = $issueModel->getById($masterId);
            if (isset($masterIssue['gant_proj_sprint_weight'])) {
                $masterWeight = $masterIssue['gant_proj_sprint_weight'];
            }
        }
        if ($nextId != '0') {
            $nextIssue = $issueModel->getById($nextId);
            if (isset($nextIssue['gant_proj_sprint_weight'])) {
                $nextWeight = $nextIssue['gant_proj_sprint_weight'];
            }
        }

        $weight = round(($masterWeight - $nextWeight) / 2);

        $currentInfo = [];
        $currentInfo['level'] = max(0, (int)$issue['level'] - 1);
        $currentInfo['master_id'] = $masterId;
        $currentInfo['gant_proj_sprint_weight'] = $weight;
        list($ret, $msg) = $issueModel->updateItemById($issueId, $currentInfo);
        if ($ret) {
            if (!empty($children)) {
                foreach ($children as $childId) {
                    $issueModel->dec('level', $childId, 'id');
                }
            }
            if ($masterId != '0') {
                $issueModel->inc('have_children', $masterId, 'id');
            }
        } else {
            $this->ajaxFailed($msg);
        }

        $this->ajaxSuccess('更新成功', $_POST);
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
