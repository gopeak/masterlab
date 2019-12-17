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
use main\app\classes\ProjectMind;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectGanttSettingModel;
use main\app\model\project\ProjectRoleModel;

/**
 * 思维导图管理
 */
class Mind extends BaseUserCtrl
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
        $data['title'] = '项目事项的思维导图结构';
        $data['nav_links_active'] = 'mind';
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
        $this->render('gitlab/project/mindmap.php', $data);
    }

    public function fetchMindIssues()
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
        $class = new ProjectMind();

        $filterArr = [];
        $addFilterSql = '';
        if (isset($_GET['filter_json'])) {
            $filterArr = json_decode($_GET['filter_json'], true);
            $addFilterSql = '';
        }

        $sourceType = 'all';
        if (isset($_GET['source_type'])) {
            $sourceType = $_GET['source_type'];
        }

        $groupByField = 'module';
        if (isset($_GET['group_by'])) {
            $groupByField = $_GET['group_by'];
        }

        $data = [];
        $projectModel = new ProjectModel();
        $project = $projectModel->getById($projectId);
        if(empty($project)){
            $this->ajaxFailed('提示','获取项目数据失败');
        }
        $root = [];
        $root['id'] = 'project_'.$projectId;
        $root['text'] = $project['name'];
        $root['layout'] = $project['mind_layout'];
        $root['children'] = [];

        if ($sourceType == 'all') {
            $issueChildren = $class->getMindIssuesByProject($projectId, $groupByField, $addFilterSql);
        }else{
            $sprintId = $sourceType;
            $issueChildren = $class->getIssuesGroupBySprint($sprintId, $groupByField);

        }
        $root['children'] = $issueChildren;
        $data['root'] = $root;
        echo json_encode($data);
        //$this->ajaxSuccess('ok', $root);
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

}
