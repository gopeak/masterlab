<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\IssueFilterLogic;
use main\app\ctrl\Agile;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\issue\Main as IssueMain;
use main\app\model\OrgModel;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectMainExtraModel;
use main\app\model\project\ProjectModel;
use main\app\model\agile\SprintModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\SettingsLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\RewriteUrl;
use main\app\model\user\UserModel;

/**
 * 项目
 */
class Main extends Base
{
    /**
     * Main constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    public function pageIndex()
    {
    }

    /**
     * @throws \Exception
     */
    public function pageNew()
    {
        $orgModel = new OrgModel();
        $orgList = $orgModel->getAllItems();

        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        $data = [];
        $data['title'] = '创建项目';
        $data['sub_nav_active'] = 'project';
        $data['users'] = $users;

        $data['org_list'] = $orgList;
        $data['full_type'] = ProjectLogic::faceMap();

        $data['project_name_max_length'] = (new SettingsLogic)->maxLengthProjectName();
        $data['project_key_max_length'] = (new SettingsLogic)->maxLengthProjectKey();

        $this->render('gitlab/project/main_form.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageHome()
    {
        $data = [];

        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'profile';
        $data['scrolling_tabs'] = 'home';
        $data = RewriteUrl::setProjectData($data);
        $data['title'] = $data['project_name'];
        // 权限判断
        if (!empty($data['project_id'])) {
            $data['issue_main_url'] = ROOT_URL . substr($data['project_root_url'], 1) . '/issues';
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }

        $projectMainExtraModel = new ProjectMainExtraModel();
        $projectExtraInfo = $projectMainExtraModel->getByProjectId($data['project_id']);

        if (empty($projectExtraInfo)) {
            $data['project']['detail'] = '';
        } else {
            $data['project']['detail'] = $projectExtraInfo['detail'];
        }

        $userLogic = new UserLogic();
        $userList = $userLogic->getUsersAndRoleByProjectId($data['project_id']);
        $data['members'] = $userList;

        $this->render('gitlab/project/home.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageProfile()
    {
        $this->pageHome();
    }

    /**
     * @throws \Exception
     */
    public function pageIssueType()
    {
        $data = [];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'issue_type';
        $data['scrolling_tabs'] = 'home';
        $data = RewriteUrl::setProjectData($data);

        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $projectLogic = new ProjectLogic();
        $list = $projectLogic->typeList($data['project_id']);
        $data['title'] = '事项类型 - ' . $data['project_name'];
        $data['list'] = $list;

        $this->render('gitlab/project/issue_type.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageVersion()
    {
        $projectModel = new ProjectModel();
        $projectName = $projectModel->getNameById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '版本 - ' . $projectName['name'];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'version';
        $data['scrolling_tabs'] = 'home';

        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/version.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageModule()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();

        $projectModuleModel = new ProjectModuleModel();
        $count = $projectModuleModel->getAllCount($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $projectModel = new ProjectModel();
        $projectName = $projectModel->getNameById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '模块 - ' . $projectName['name'];
        $data['nav_links_active'] = 'home';
        $data['sub_nav_active'] = 'module';
        $data['users'] = $users;
        $data['query_str'] = http_build_query($_GET);
        $data['count'] = $count;

        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/module.php', $data);
    }

    /**
     * 跳转至事项页面
     * @throws \Exception
     */
    public function pageIssues()
    {
        $issueMainCtrl = new IssueMain();
        $issueMainCtrl->pageIndex();
    }

    /**
     * backlog页面
     * @throws \Exception
     */
    public function pageBacklog()
    {
        $agileCtrl = new Agile();
        $agileCtrl->pageBacklog();
    }

    /**
     * Sprints页面
     * @throws \Exception
     */
    public function pageSprints()
    {
        $agileCtrl = new Agile();
        $agileCtrl->pageSprint();
    }

    /**
     * Kanban页面
     * @throws \Exception
     */
    public function pageKanban()
    {
        $agileCtrl = new Agile();
        $agileCtrl->pageBoard();
    }

    /**
     * 设置页面
     * @throws \Exception
     */
    public function pageSettings()
    {
        $this->pageSettingsProfile();
    }

    /**
     * @throws \Exception
     */
    public function pageChart()
    {
        $chartCtrl = new Chart();
        $chartCtrl->pageProject();
    }

    /**
     * @throws \Exception
     */
    public function pageChartSprint()
    {
        $chartCtrl = new Chart();
        $chartCtrl->pageSprint();
    }


    /**
     * @todo 此处有bug, 不能即是页面有时ajax的处理
     * @throws \Exception
     */
    public function pageSettingsProfile()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }
        $projectModel = new ProjectModel();
        $info = $projectModel->getById($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $projectMainExtra = new ProjectMainExtraModel();
        $infoExtra = $projectMainExtra->getByProjectId($info['id']);
        if ($infoExtra) {
            $info['detail'] = $infoExtra['detail'];
        } else {
            $info['detail'] = '';
        }


        $orgModel = new OrgModel();
        $orgList = $orgModel->getAllItems();
        $data['org_list'] = $orgList;

        $orgName = $orgModel->getOne('name', array('id' => $info['org_id']));
        $data['title'] = '设置';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'basic_info';

        //$data['users'] = $users;
        $info['org_name'] = $orgName;
        $data['info'] = $info;
        $data['full_type'] = ProjectLogic::faceMap();

        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/setting_basic_info.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsIssueType()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $projectLogic = new ProjectLogic();
        $list = $projectLogic->typeList($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '事项类型';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'issue_type';

        $data['list'] = $list;

        $data = RewriteUrl::setProjectData($data);

        // 空数据
        $data['empty_data_msg'] = '无事项类型';
        $data['empty_data_status'] = 'list';  // bag|list|board|error|gps|id|off-line|search
        $data['empty_data_show_button'] = false;

        $this->render('gitlab/project/setting_issue_type.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsVersion()
    {
        // $projectVersionModel = new ProjectVersionModel();
        // $list = $projectVersionModel->getByProject($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }
        $data = [];
        $data['title'] = '版本';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'version';

        $data['query_str'] = http_build_query($_GET);

        $data = RewriteUrl::setProjectData($data);

        $this->render('gitlab/project/setting_version.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsModule()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();

        $projectModuleModel = new ProjectModuleModel();
        //$list = $projectModuleModel->getByProjectWithUser($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);
        $count = $projectModuleModel->getAllCount($_GET[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $data = [];
        $data['title'] = '模块';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'module';
        $data['users'] = $users;
        $data['query_str'] = http_build_query($_GET);
        //$data['list'] = $list;
        $data['count'] = $count;

        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_module.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsLabel()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $data = [];
        $data['title'] = '标签';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'label';
        $data['query_str'] = http_build_query($_GET);

        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_label.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsLabelNew()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }
        $data = [];
        $data['title'] = '标签';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'label';
        $data['query_str'] = http_build_query($_GET);
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_label_new.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsLabelEdit()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $id = isset($_GET['id']) && !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $projectLabelModel = new ProjectLabelModel();
            $info = $projectLabelModel->getById($id);

            $data = [];
            $data['title'] = '标签';
            $data['nav_links_active'] = 'setting';
            $data['sub_nav_active'] = 'label';

            $data['query_str'] = http_build_query($_GET);
            $data = RewriteUrl::setProjectData($data);

            $data['row'] = $info;
            $this->render('gitlab/project/setting_label_edit.php', $data);
        } else {
            echo 404;
            exit;
        }
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsPermission()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $data = [];
        $data['title'] = '权限';
        $data['nav_links_active'] = 'setting';
        $data['sub_nav_active'] = 'permission';
        $data = RewriteUrl::setProjectData($data);
        $this->render('gitlab/project/setting_permission.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsProjectMember()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $memberCtrl = new Member();
        $memberCtrl->pageIndex();
    }

    /**
     * @throws \Exception
     */
    public function pageSettingsProjectRole()
    {
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->warn('提 示', '您没有权限访问该页面,需要项目管理权限');
            die;
        }

        $roleCtrl = new Role();
        $roleCtrl->pageIndex();
    }

    /**
     * @throws \Exception
     */
    public function pageActivity()
    {
        $data = [];
        $data['title'] = 'Activity';
        $data['top_menu_active'] = 'time_line';
        $data['nav_links_active'] = 'home';
        $data['scrolling_tabs'] = 'activity';

        $this->render('gitlab/project/activity.php', $data);
    }

    /**
     * 项目统计页面
     * @throws \Exception
     */
    public function pageStat()
    {
        $statCtrl = new  Stat();
        $statCtrl->pageIndex();
    }

    /**
     * 迭代统计页面
     * @throws \Exception
     */
    public function pageStatSprint()
    {
        $statCtrl = new  StatSprint();
        $statCtrl->pageIndex();
    }

    /**
     * 获取项目信息
     * @param $id
     * @throws \Exception
     */
    public function fetch($id)
    {
        $id = intval($id);
        // 权限判断
        if (!empty($id)) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $id)) {
                $this->ajaxFailed('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
            }
        }
        $projectModel = new ProjectModel();
        $project = $projectModel->getById($id);
        if (empty($project)) {
            $project = new \stdClass();
            $this->ajaxSuccess('ok', $project);
        }

        $projectMainExtraModel = new ProjectMainExtraModel();
        $projectExtraInfo = $projectMainExtraModel->getByProjectId($id);
        if (empty($projectExtraInfo)) {
            $project['detail'] = '';
        } else {
            $project['detail'] = $projectExtraInfo['detail'];
        }

        $project['count'] = IssueFilterLogic::getCount($id);
        $project['no_done_count'] = IssueFilterLogic::getNoDoneCount($id);
        $sprintModel = new SprintModel();
        $project['sprint_count'] = $sprintModel->getCountByProject($id);
        $project = ProjectLogic::formatProject($project);
        $this->ajaxSuccess('ok', $project);
    }


    /**
     * 新增项目
     * @param array $params
     * @throws \Exception
     */
    public function create($params = array())
    {
        if (!$this->isAdmin) {
            $this->ajaxFailed('您没有权限进行此操作,系统管理才能创建项目');
        }

        if (empty($params)) {
            $this->ajaxFailed('错误', '无表单数据提交');
        }

        $err = [];
        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        $settingLogic = new SettingsLogic;
        $maxLengthProjectName = $settingLogic->maxLengthProjectName();
        $maxLengthProjectKey = $settingLogic->maxLengthProjectKey();

        if (!isset($params['name'])) {
            $err['project_name'] = 'name域不存在';
        }
        if (isset($params['name']) && empty(trimStr($params['name']))) {
            $err['project_name'] = '名称不能为空';
        }
        if (isset($params['name']) && strlen($params['name']) > $maxLengthProjectName) {
            $err['project_name'] = '名称长度太长,长度应该小于' . $maxLengthProjectName;
        }
        if (isset($params['name']) && $projectModel->checkNameExist($params['name'])) {
            $err['project_name'] = '项目名称已经被使用了,请更换一个吧';
        }

        if (!isset($params['org_id'])) {
            //$err['org_id'] = '请选择一个组织';
            $params['org_id'] = 1; // 临时使用id为1的默认组织
        } elseif (isset($params['org_id']) && empty(trimStr($params['org_id']))) {
            $err['org_id'] = '组织不能为空';
        }

        if (!isset($params['key'])) {
            $err['project_key'][] = 'KEY域不存在';
        }
        if (isset($params['key']) && empty(trimStr($params['key']))) {
            $err['project_key'][] = '关键字不能为空';
        }
        if (isset($params['key']) && strlen($params['key']) > $maxLengthProjectKey) {
            $err['project_key'][] = '关键字长度太长,长度应该小于' . $maxLengthProjectKey;
        }
        if (isset($params['key']) && $projectModel->checkKeyExist($params['key'])) {
            $err['project_key'][] = '项目关键字已经被使用了,请更换一个吧';
        }
        if (isset($params['key']) && !preg_match("/^[a-zA-Z]+$/", $params['key'])) {
            $err['project_key'][] = '项目关键字必须全部为英文字母,不能包含空格和特殊字符';
        }

        $userModel = new UserModel();
        if (!isset($params['lead'])) {
            $err['project_lead'] = '请选择项目负责人.';
        } elseif (isset($params['lead']) && intval($params['lead']) <= 0) {
            $err['project_lead'] = '请选择项目负责人';
        } elseif (empty($userModel->getByUid($params['lead']))) {
            $err['project_lead'] = '项目负责人错误';
        }

        if (!isset($params['type'])) {
            $err['type'] = '请选择项目类型';
        } elseif (isset($params['type']) && empty(trimStr($params['type']))) {
            $err['type'] = '项目类型不能为空';
        }

        if (!empty($err)) {
            $this->ajaxFailed('错误错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        //$params['key'] = mb_strtoupper(trimStr($params['key']));
        $params['key'] = trimStr($params['key']);
        $params['name'] = trimStr($params['name']);
        $params['type'] = intval($params['type']);

        if (!isset($params['lead']) || empty($params['lead'])) {
            $params['lead'] = $uid;
        }

        $info = [];
        $info['name'] = $params['name'];
        $info['org_id'] = $params['org_id'];
        $info['key'] = $params['key'];
        $info['lead'] = $params['lead'];
        $info['description'] = $params['description'];
        $info['type'] = $params['type'];
        $info['category'] = 0;
        $info['url'] = isset($params['url']) ? $params['url'] : '';
        $info['create_time'] = time();
        $info['create_uid'] = $uid;
        $info['avatar'] = !empty($params['avatar_relate_path']) ? $params['avatar_relate_path'] : '';
        $info['detail'] = isset($params['detail']) ? $params['detail'] : '';
        //$info['avatar'] = !empty($avatar) ? $avatar : "";

        $projectModel->db->beginTransaction();

        $orgModel = new OrgModel();
        $orgInfo = $orgModel->getById($params['org_id']);

        $info['org_path'] = $orgInfo['path'];

        $ret = ProjectLogic::create($info, $uid);
        //$ret['errorCode'] = 0;
        $final = array(
            'project_id' => $ret['data']['project_id'],
            'key' => $params['key'],
            'org_name' => $orgInfo['name'],
            'path' => $orgInfo['path'] . '/' . $params['key'],
        );
        if (!$ret['errorCode']) {
            // 初始化项目角色
            list($flagInitRole, $roleInfo) = ProjectLogic::initRole($ret['data']['project_id']);
            // 把项目负责人赋予该项目的管理员权限
            list($flagAssignAdminRole) = ProjectLogic::assignAdminRoleForProjectLeader($ret['data']['project_id'], $info['lead']);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_ADD;
            $logData['remark'] = '新建项目';
            $logData['pre_data'] = [];
            $logData['cur_data'] = $info;
            LogOperatingLogic::add($uid, 0, $logData);

            if ($flagInitRole && $flagAssignAdminRole) {
                $projectModel->db->commit();

                $currentUid = $this->getCurrentUid();
                $activityModel = new ActivityModel();
                $activityInfo = [];
                $activityInfo['action'] = '创建了项目';
                $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
                $activityInfo['obj_id'] = $ret['data']['project_id'];
                $activityInfo['title'] = $info['name'];
                $activityModel->insertItem($currentUid, $ret['data']['project_id'], $activityInfo);

                $this->ajaxSuccess('success', $final);
            } else {
                $projectModel->db->rollBack();
                $this->ajaxFailed('fail', '项目角色添加失败：' . $roleInfo);
            }
        } else {
            $projectModel->db->rollBack();
            $this->ajaxFailed('服务器错误', '添加失败,错误详情 :' . $ret['msg']);
        }
    }

    /**
     * 更新
     * 注意：该方法未使用,可以删除该方法
     * @param $project_id
     * @throws \Exception
     */
    public function update($project_id)
    {
        // 判断权限:全局权限和项目角色
        if (!isset($this->projectPermArr[PermissionLogic::BROWSE_ISSUES])) {
            $this->ajaxFailed('您没有权限进行此操作,需要项目管理权限');
        }

        $uid = $this->getCurrentUid();
        $projectModel = new ProjectModel($uid);
        // $this->param_valid($projectModel, $name, $key, $type);

        $key = null;
        $projectId = intval($project_id);
        $err = [];
        $info = [];
        if (isset($_REQUEST['name'])) {
            $name = trimStr($_REQUEST['name']);
            if ($projectModel->checkIdNameExist($projectId, $name)) {
                $err['name'] = '名称已经被使用';
            }
            $info['name'] = trimStr($_REQUEST['name']);
        }
        if (isset($_REQUEST['key'])) {
            $key = trimStr($_REQUEST['key']);
            if ($projectModel->checkIdKeyExist($projectId, $key)) {
                $err['key'] = '关键字已经被使用';
            }
            $info['key'] = trimStr($_REQUEST['key']);
        }

        if (!empty($err)) {
            $this->ajaxFailed('提示', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        if (isset($_REQUEST['type'])) {
            $info['type'] = intval($_REQUEST['type']);
        }
        if (isset($_REQUEST['lead'])) {
            $info['lead'] = intval($_REQUEST['lead']);
        }
        if (isset($_REQUEST['description'])) {
            $info['description'] = $_REQUEST['description'];
        }
        if (isset($_REQUEST['category'])) {
            $info['category'] = (int)$_REQUEST['category'];
        }
        if (isset($_REQUEST['url'])) {
            $info['url'] = $_REQUEST['url'];
        }
        if (isset($_REQUEST['avatar'])) {
            $info['avatar'] = $_REQUEST['avatar'];
        }
        if (empty($info)) {
            $this->ajaxFailed('参数错误', '无表单数据提交');
        }
        $project = $projectModel->getRowById($projectId);
        $ret = $projectModel->updateById($projectId, $info);
        if ($ret[0]) {
            if ($project['key'] != $key) {
                // @todo update issue key
            }
            $currentUid = $this->getCurrentUid();
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了项目';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $projectId;
            $activityInfo['title'] = $project['name'];
            $activityModel->insertItem($currentUid, $projectId, $activityInfo);

            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('服务器错误', '新增数据失败,详情:' . $ret[1]);
        }
    }
}
