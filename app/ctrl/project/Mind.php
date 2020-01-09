<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\IssueFilterLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\ProjectLogic;
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
use main\app\model\project\MindSecondAttributeModel;
use main\app\model\project\MindSprintAttributeModel;
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


    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '事项脑图';
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

        $projectMindModel = new ProjectMindSettingModel();
        $dbSettingsArr = $projectMindModel->getByProject($projectId);
        $settingArr = ProjectMind::$initSettingArr;
        if (!empty($settingsArr)) {
            foreach ($dbSettingsArr as $item) {
                $settingArr[$item['setting_key']] = $item['setting_value'];
            }
        }
        if ($settingArr['default_source'] == 'sprint' && $settingArr['default_source_id'] == '0' && $data['active_sprint']) {
            $settingArr['default_source_id'] = $data['active_sprint']['id'];
        }
        $data['mind_setting'] = $settingArr;

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
        $data['fontSizes'] = [1.0, 1.2, 1.6, 1.8, 2.4, 3.2, 4.8];
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

        list($project['avatar'], $project['avatar_exist']) = ProjectLogic::formatAvatar($project['avatar']);
        // 获取格式
        if ($sourceType == 'all') {
            $mindProjectAttributeModel = new MindProjectAttributeModel();
            $format = $mindProjectAttributeModel->getByProject($projectId);
        } else {
            $sprintId = $sourceType;
            $mindSprintAttributeModel = new MindSprintAttributeModel();
            $format = $mindSprintAttributeModel->getBySprint($sprintId);
        }
        if (empty($format)) {
            // 设置默认值
            $format['layout'] = 'graph-bottom';
            $format['shape'] = 'box';
            $format['color'] = '#EE3333';
            $format['icon'] = '';
            $format['font_family'] = '宋体, SimSun;';
            $format['font_size'] = 1.2;
            $format['font_bold'] = 1;
            $format['font_italic'] = 0;
            $format['bg_color'] = '';
            $format['text_color'] = '';
        }
        if (empty($format['layout'])) {
            $format['layout'] = 'graph-bottom';
        }
        if (empty($format['shape'])) {
            $format['shape'] = 'box';
        }

        $root = [];
        $root['layout'] = $format['layout'];
        $root['shape'] = $format['shape'];
        $root['color'] = $format['color'];
        $root['font_family'] = $format['font_family'];
        $root['font_size'] = $format['font_size'];
        $root['font_bold'] = $format['font_bold'];
        $root['font_italic'] = $format['font_italic'];
        $root['bg_color'] = $format['bg_color'];
        $root['text_color'] = $format['text_color'];
        $root['children'] = [];

        if ($sourceType == 'all') {
            $sprintId = null;
            $root['origin_id'] = $projectId;
            $root['id'] = 'project_' . $projectId;
            $root['type'] = 'project';
            $root['text'] = $project['name'];
            $root['avatar_exist'] = $project['avatar_exist'];
            $root['avatar'] = $project['avatar'];
        } else {
            $sprintId = $sourceType;
            $sprintModel = new SprintModel();
            $sprint = $sprintModel->getById($sprintId);
            if (!empty($sprint)) {
                $root['origin_id'] = $sprintId;
                $root['id'] = 'sprint_' . $sprintId;
                $root['type'] = 'root_sprint';
                $root['text'] = $sprint['name'];
                $root['avatar_exist'] = true;
                $root['avatar'] = '/dev/img/mind/rocket.png';
            } else {
                $this->ajaxFailed('参数错误', '迭代数据为空');
            }
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
                $updateInfo[$key] = $_POST[$key];
            }
        }
        if (!empty($updateInfo)) {
            try {
                if (isset($updateInfo['default_source']) && $updateInfo['default_source'] == 'all') {
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

        $model = new MindProjectAttributeModel();
        $updateInfo = [];
        $fields = ['layout', 'shape', 'color', 'icon', 'font_family', 'font_size', 'font_bold', 'font_italic', 'bg_color', 'text_color'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['project_id'] = $projectId;
        list($ret, $msg) = $model->replaceByProjectId($updateInfo);
        if (!$ret) {
            $this->ajaxFailed('提示', '服务器执行错误:' . $msg);
        }
        $this->ajaxSuccess('提示', '操作成功');
    }

    /**
     * @throws \Exception
     */
    public function saveSprintFormat()
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

        $model = new MindSprintAttributeModel();
        $updateInfo = [];
        $fields = ['layout', 'shape', 'color', 'icon', 'font_family', 'font_size', 'font_bold', 'font_italic', 'bg_color', 'text_color'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['sprint_id'] = $sprintId;
        list($ret, $msg) = $model->replaceBySprintId($updateInfo);
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

        $model = new MindSecondAttributeModel();
        $updateInfo = [];
        $fields = ['layout', 'shape', 'color', 'icon', 'font_family', 'font_size', 'font_bold', 'font_italic', 'bg_color', 'text_color'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['project_id'] = $projectId;
        $updateInfo['source'] = $_GET['source'];
        $updateInfo['group_by'] = $_GET['group_by'];
        $updateInfo['group_by_id'] = $_GET['group_by_id'];
        list($ret, $msg) = $model->replaceByProjectId($updateInfo);
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


        $model = new MindIssueAttributeModel();
        $updateInfo = [];
        $fields = ['layout', 'shape', 'color', 'icon', 'font_family', 'font_size', 'font_bold', 'font_italic', 'bg_color', 'text_color'];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $updateInfo[$field] = $_POST[$field];
            }
        }
        $updateInfo['project_id'] = $projectId;
        $updateInfo['source'] = $_GET['source'];
        $updateInfo['group_by'] = $_GET['group_by'];
        $updateInfo['issue_id'] = $_GET['issue_id'];
        list($ret, $msg) = $model->replaceByProjectId($updateInfo);
        if (!$ret) {
            $this->ajaxFailed('提示', '服务器执行错误:' . $msg);
        }
        $this->ajaxSuccess('提示', '操作成功');
    }
}
