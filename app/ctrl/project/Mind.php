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
use main\app\model\project\MindIssueAttributeModel;
use main\app\model\project\MindProjectAttributeModel;
use main\app\model\project\MindSecondtAttributeModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectMindSettingModel;
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

        $projectGanttModel = new ProjectMindSettingModel();
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

        $fontsList = [
            ['value' => '宋体, SimSun;', 'name' => '宋体'],
            ['value' => '微软雅黑, Microsoft YaHei', 'name' => '微软雅黑, Microsoft YaHei'],
            ['value' => '楷体, 楷体_GB2312, SimKai', 'name' => '楷体, 楷体_GB2312, SimKai'],
            ['value' => '黑体, SimHei', 'name' => '黑体, SimHei'],
            ['value' => '隶书, SimLi', 'name' => '隶书, SimLi'],
            ['value' => 'andale mono', 'name' => 'andale mono'],
            ['value' => 'arial, helvetica, sans-serif', 'name' => 'arial, helvetica, sans-serif'],
            ['value' => 'arial black, avant garde', 'name' => 'arial black, avant garde'],
            ['value' => 'comic sans ms', 'name' => 'comic sans ms'],
            ['value' => 'impact, chicago', 'name' => 'impact, chicago'],
            ['value' => 'times new roman', 'name' => 'times new roman'],
            ['value' => 'sans-serif', 'name' => 'sans-serif'],
        ];
        $data['fonts'] = $fontsList;
        $data['fontSizes'] = [10, 12, 16, 18, 24, 32, 48];
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

        $projectGanttModel = new ProjectMindSettingModel();
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
        if (empty($project)) {
            $this->ajaxFailed('提示', '获取项目数据失败');
        }
        $root = [];
        $root['id'] = 'project_' . $projectId;
        $root['text'] = $project['name'];
        $root['layout'] = $project['mind_layout'];
        $root['children'] = [];

        if ($sourceType == 'all') {
            $sprintId = null;
        } else {
            $sprintId = $sourceType;
        }
        $issueChildren = $class->getMindIssues($projectId, $sprintId, $groupByField, $addFilterSql);
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

        $projectGanttModel = new ProjectMindSettingModel();
        $settingsArr = $projectGanttModel->getByProject($projectId);
        if (empty($settingArr)) {
            $settingsArr = $projectGanttModel->getByProject($projectId);
        }
        $arr = [];
        if (!empty($settingsArr)) {
            foreach ($settingsArr as $item) {
                $arr[$item['setting_key']] = $item['setting_value'];
            }
        }
        foreach (ProjectMind::$initSettingArr as $key => $item) {
            if (!isset($arr[$key])) {
                $arr[$key] = $item;
            }
        }

        $this->ajaxSuccess('操作成功', $arr);
    }

    /**
     * 保存思维导图设置
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

        $projectGanttModel = new ProjectMindSettingModel();
        $updateInfo = [];
        foreach (ProjectMind::$initSettingArr as $key => $item) {
            if (isset($_POST[$key])) {
                $updateInfo[$key] = $item;
            }
        }
        if (!empty($updateInfo)) {
            try {
                if(isset($updateInfo['default_source']) && $updateInfo['default_source']=='all'){
                    $updateInfo['default_source_id'] = '';
                }
                foreach ($updateInfo as $key => $item) {
                    $arr = [];
                    $arr['project_id'] = $projectId;
                    $arr['setting_key'] = $key;
                    $arr['setting_value'] = $item;
                    list($ret, $msg) = $projectGanttModel->replaceByProjectId($arr, $projectId);
                    if (!$ret) {
                        $this->ajaxFailed('提示', '服务器执行错误:' . $msg);
                    }
                }
                $this->ajaxSuccess('提示', '操作成功');
            } catch (\PDOException $e) {
                $this->ajaxFailed('提示', '数据库执行错误:' . $e->getMessage());
            }
        }
        $this->ajaxSuccess('提示', '操作成功');

    }


    /**
     * 修改根主题（项目）的格式
     * @throws \Exception
     */
    public function saveProjectFormat()
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

        $mindProjectAttributeModel = new MindProjectAttributeModel();
        $updateInfo = [];
        $fields = ['layout','shape','color','icon','font_family','font_size','font_bold','font_italics','bg_color'];
        foreach ($fields as $field ) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['project_id'] = $projectId;
        list($ret, $msg) = $mindProjectAttributeModel->replaceByProjectId($updateInfo);
        if (!$ret) {
            $this->ajaxFailed('提示', '服务器执行错误:' . $msg);
        }
        $this->ajaxSuccess('提示', '操作成功');
    }

    public function saveSecondFormat()
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

        if (!isset($_GET['source']) || empty($_GET['source'])) {
            $this->ajaxFailed('参数错误', 'source不能为空');
        }
        if (!isset($_GET['group_by']) || empty($_GET['group_by'])) {
            $this->ajaxFailed('参数错误', 'group_by不能为空');
        }
        if (!isset($_GET['group_by_id']) || empty($_GET['group_by_id'])) {
            $this->ajaxFailed('参数错误', 'group_by_id不能为空');
        }


        $mindProjectAttributeModel = new MindSecondtAttributeModel();
        $updateInfo = [];
        $fields = ['layout','shape','color','icon','font_family','font_size','font_bold','font_italics','bg_color'];
        foreach ($fields as $field ) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['project_id'] = $projectId;
        $updateInfo['source'] = $_GET['source'];
        $updateInfo['group_by'] = $_GET['group_by'];
        $updateInfo['group_by_id'] = $_GET['group_by_id'];
        list($ret, $msg) = $mindProjectAttributeModel->replaceByProjectId($updateInfo);
        if (!$ret) {
            $this->ajaxFailed('提示', '服务器执行错误:' . $msg);
        }
        $this->ajaxSuccess('提示', '操作成功');
    }

    public function saveIssueFormat()
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

        if (!isset($_GET['source']) || empty($_GET['source'])) {
            $this->ajaxFailed('参数错误', 'source不能为空');
        }
        if (!isset($_GET['group_by']) || empty($_GET['group_by'])) {
            $this->ajaxFailed('参数错误', 'group_by不能为空');
        }
        if (!isset($_GET['issue_id']) || empty($_GET['issue_id'])) {
            $this->ajaxFailed('参数错误', 'issue_id不能为空');
        }


        $mindProjectAttributeModel = new MindIssueAttributeModel();
        $updateInfo = [];
        $fields = ['layout','shape','color','icon','font_family','font_size','font_bold','font_italics','bg_color'];
        foreach ($fields as $field ) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['project_id'] = $projectId;
        $updateInfo['source'] = $_GET['source'];
        $updateInfo['group_by'] = $_GET['group_by'];
        $updateInfo['issue_id'] = $_GET['issue_id'];
        list($ret, $msg) = $mindProjectAttributeModel->replaceByProjectId($updateInfo);
        if (!$ret) {
            $this->ajaxFailed('提示', '服务器执行错误:' . $msg);
        }
        $this->ajaxSuccess('提示', '操作成功');
    }
}
